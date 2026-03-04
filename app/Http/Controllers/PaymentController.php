<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\PaymentSucceededMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['webhook']);
    }

    private function stripeSecretKey(): string
    {
        $key = (string) config('stripe.secret');

        if ($key === '') {
            abort(500, 'Stripe secret key is missing. Set STRIPE_SECRET in .env, then run: php artisan config:clear');
        }

        if (!str_starts_with($key, 'sk_')) {
            abort(500, 'Stripe secret key is invalid. STRIPE_SECRET must be your sk_test_... key (not pk_test_...). Then run: php artisan config:clear');
        }

        return $key;
    }

    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return response()->json(['message' => 'Cart is empty.'], 422);
        }

        $cartItems = collect();
        foreach ($cart as $key => $item) {
            $product = \App\Models\Product::find($item['product_id']);
            if ($product) {
                $cartItems->push((object) [
                    'id' => $key,
                    'product' => $product,
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 422);
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $shipping = $subtotal > 50 ? 0 : 5;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        $order = DB::transaction(function () use ($request, $cartItems, $total) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'pending',
                'shipping_info' => [
                    'full_name' => $request->full_name,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'phone' => $request->phone,
                ],
                'payment_method' => 'card',
                'payment_status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'size' => $item->size,
                    'color' => $item->color,
                ]);
            }

            return $order;
        });

        Stripe::setApiKey($this->stripeSecretKey());

        $paymentIntent = PaymentIntent::create([
            'amount' => (int) round($total * 100),
            'currency' => 'usd',
            'metadata' => [
                'order_id' => (string) $order->id,
                'user_id' => (string) auth()->id(),
            ],
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        $order->update([
            'stripe_payment_intent_id' => $paymentIntent->id,
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
            'orderId' => $order->id,
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (empty($order->stripe_payment_intent_id)) {
            return response()->json(['message' => 'Payment intent not found for order.'], 422);
        }

        Stripe::setApiKey($this->stripeSecretKey());
        $pi = PaymentIntent::retrieve($order->stripe_payment_intent_id);

        if (($pi->status ?? null) !== 'succeeded') {
            return response()->json(['message' => 'Payment not completed.'], 422);
        }

        DB::transaction(function () use ($order) {
            $order->refresh();

            if ($order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                ]);

                $order->loadMissing('items.product');
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->decrement('stock', $item->quantity);
                    }
                }
            }
        });

        $order->refresh();
        $order->loadMissing('user');
        if ($order->payment_status === 'paid' && empty($order->payment_email_sent_at) && !empty($order->user?->email)) {
            Mail::to($order->user->email)->send(new PaymentSucceededMail($order));
            $order->update(['payment_email_sent_at' => now()]);
        }

        Session::forget('cart');

        return response()->json([
            'redirect' => route('orders.confirmation', $order),
        ]);
    }

    public function webhook(Request $request)
    {
        $secret = env('STRIPE_WEBHOOK_SECRET');
        $signature = $request->header('Stripe-Signature');

        $payload = $request->getContent();

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        $type = $event->type ?? null;

        if ($type === 'payment_intent.succeeded') {
            $pi = $event->data->object;
            $orderId = $pi->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::with('items.product')->find($orderId);
                if ($order && $order->payment_status !== 'paid') {
                    DB::transaction(function () use ($order) {
                        $order->update([
                            'payment_status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        foreach ($order->items as $item) {
                            if ($item->product) {
                                $item->product->decrement('stock', $item->quantity);
                            }
                        }
                    });

                    $order->refresh();
                    $order->loadMissing('user');
                    if (empty($order->payment_email_sent_at) && !empty($order->user?->email)) {
                        Mail::to($order->user->email)->send(new PaymentSucceededMail($order));
                        $order->update(['payment_email_sent_at' => now()]);
                    }
                }
            }
        }

        if ($type === 'payment_intent.payment_failed') {
            $pi = $event->data->object;
            $orderId = $pi->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::find($orderId);
                if ($order && $order->payment_status !== 'paid') {
                    $order->update([
                        'payment_status' => 'failed',
                    ]);
                }
            }
        }

        return response('OK', 200);
    }
}
