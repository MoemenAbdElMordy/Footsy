<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Mail\OrderPlacedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $shipping = $subtotal > 50 ? 0 : 5;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        $addresses = Address::where('user_id', auth()->id())->latest()->get();
        $defaultAddress = $addresses->firstWhere('is_default', true);

        return view('pages.checkout.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'addresses', 'defaultAddress'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|string',
        ]);

        if ($request->payment_method === 'card') {
            return back()->withErrors([
                'payment_method' => 'Please complete card payment using the card form.',
            ]);
        }

        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
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
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'unpaid' : 'pending',
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'size' => $item->size,
                    'color' => $item->color,
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            return $order;
        });

        Session::forget('cart');

        if (empty($order->order_email_sent_at) && !empty(auth()->user()?->email)) {
            Mail::to(auth()->user()->email)->send(new OrderPlacedMail($order->loadMissing('user')));
            $order->update(['order_email_sent_at' => now()]);
        }

        return redirect()->route('orders.confirmation', $order)->with('success', 'Order placed successfully!');
    }

    private function getCartItems()
    {
        $cart = Session::get('cart', []);
        $items = collect();

        foreach ($cart as $key => $item) {
            $product = \App\Models\Product::find($item['product_id']);
            if ($product) {
                $items->push((object) [
                    'id' => $key,
                    'product' => $product,
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        return $items;
    }
}

