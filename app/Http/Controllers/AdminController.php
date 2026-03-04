<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard(Request $request)
    {
        $allOrders = Order::latest()->get();
        $status = $request->query('status');
        $allowedStatuses = ['pending', 'confirmed', 'shipped', 'delivered'];
        $paymentStatus = $request->query('payment_status');
        $allowedPaymentStatuses = ['unpaid', 'pending', 'paid', 'failed', 'cancelled'];

        $filters = $request->validate([
            'order_id' => 'nullable|integer',
            'email' => 'nullable|email',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
        ]);

        $orderId = $filters['order_id'] ?? null;
        $email = $filters['email'] ?? null;
        $dateFrom = isset($filters['date_from']) ? Carbon::parse($filters['date_from'])->startOfDay() : null;
        $dateTo = isset($filters['date_to']) ? Carbon::parse($filters['date_to'])->endOfDay() : null;

        $ordersQuery = Order::with(['items.product', 'user'])->latest();
        if ($status && in_array($status, $allowedStatuses, true)) {
            $ordersQuery->where('status', $status);
        } else {
            $status = null;
        }

        if ($paymentStatus && in_array($paymentStatus, $allowedPaymentStatuses, true)) {
            $ordersQuery->where('payment_status', $paymentStatus);
        } else {
            $paymentStatus = null;
        }

        if (!empty($orderId)) {
            $ordersQuery->where('id', $orderId);
        }

        if (!empty($email)) {
            $ordersQuery->whereHas('user', function ($q) use ($email) {
                $q->where('email', $email);
            });
        }

        if ($dateFrom && $dateTo) {
            $ordersQuery->whereBetween('created_at', [$dateFrom, $dateTo]);
        } elseif ($dateFrom) {
            $ordersQuery->where('created_at', '>=', $dateFrom);
        } elseif ($dateTo) {
            $ordersQuery->where('created_at', '<=', $dateTo);
        }

        $orders = $ordersQuery->get();
        $products = Product::all();
        
        $totalRevenue = $allOrders->sum('total');
        $pendingOrders = $allOrders->where('status', 'pending')->count();
        $totalOrders = $allOrders->count();

        return view('pages.admin.dashboard', compact('orders', 'products', 'totalRevenue', 'pendingOrders', 'totalOrders', 'status', 'paymentStatus', 'orderId', 'email', 'dateFrom', 'dateTo'));
    }

    public function updateOrder(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated');
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'items.product']);

        return view('pages.admin.orders.show', compact('order'));
    }

    public function cancelOrder(Request $request, Order $order)
    {
        $order->loadMissing('items.product');

        if (!empty($order->cancelled_at)) {
            return back()->with('success', 'Order already cancelled');
        }

        DB::transaction(function () use ($order) {
            $order->refresh();
            $order->loadMissing('items.product');

            $shouldRestock = empty($order->restocked_at) && (
                ($order->payment_method === 'cod') ||
                ($order->payment_status === 'paid')
            );

            if ($shouldRestock) {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }

                $order->restocked_at = now();
            }

            $order->payment_status = 'cancelled';
            $order->cancelled_at = now();
            $order->save();
        });

        return back()->with('success', 'Order cancelled' . (($order->restocked_at ?? null) ? ' and restocked' : ''));
    }
}

