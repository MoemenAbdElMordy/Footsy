@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3 py-md-4">
    <a href="{{ route('home') }}" class="btn btn-link text-dark mb-3 mb-md-4 text-decoration-none">
        <i class="bi bi-arrow-left me-2"></i>
        Back to Home
    </a>

    <h1 class="h3 h2-md display-6 fw-bold mb-3 mb-md-4">My Orders</h1>

    @if($orders->isEmpty())
        <div class="text-center py-4 py-md-5">
            <i class="bi bi-box-seam fs-1 text-muted mb-3 mb-md-4"></i>
            <h2 class="h4 h3-md fw-bold mb-2">No Orders Yet</h2>
            <p class="text-muted mb-3 mb-md-4">Start shopping to see your orders here!</p>
            <a href="{{ route('shop.index') }}" 
               class="btn btn-success w-100 w-md-auto"
               style="background-color: var(--color-success); border-color: var(--color-success);">
                Start Shopping
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-3 gap-md-4">
            @foreach($orders as $order)
                <div class="card">
                    <div class="card-header p-3 p-md-4">
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2">
                            <div>
                                <h3 class="h6 mb-1">Order #{{ $order->id }}</h3>
                                <p class="small text-muted mb-0">
                                    Placed on {{ $order->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2">
                                <span class="badge {{ $order->status === 'pending' ? 'bg-warning' : ($order->status === 'confirmed' ? 'bg-info' : ($order->status === 'shipped' ? 'bg-primary' : 'bg-success')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="badge {{ ($order->payment_status ?? 'unpaid') === 'paid' ? 'bg-success' : ((($order->payment_status ?? 'unpaid') === 'failed') ? 'bg-danger' : ((($order->payment_status ?? 'unpaid') === 'cancelled') ? 'bg-dark' : 'bg-secondary')) }}">
                                    {{ strtoupper($order->payment_status ?? 'unpaid') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex flex-column gap-3">
                            <!-- Order Items -->
                            <div class="d-flex flex-column gap-2">
                                @foreach($order->items as $item)
                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between border-bottom pb-2 gap-2">
                                        <div class="d-flex align-items-center gap-2 gap-md-3 w-100 w-sm-auto">
                                            <img src="{{ ($item->product->images[0] ?? '/images/placeholder.jpg') }}" 
                                                 alt="{{ $item->product->name }}"
                                                 class="rounded flex-shrink-0"
                                                 style="width: 3rem; height: 3rem; min-width: 3rem; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <p class="fw-medium mb-0 small">{{ $item->product->name }}</p>
                                                <p class="small text-muted mb-0">
                                                    Size: {{ $item->size }} | Color: {{ $item->color }} | Qty: {{ $item->quantity }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="fw-semibold small-md-base">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Shipping Info -->
                            <div class="rounded p-3" style="background-color: var(--color-gray-50);">
                                <h4 class="h6 fw-semibold mb-2">Shipping Address</h4>
                                <p class="small text-dark mb-0">
                                    {{ $order->shipping_info['full_name'] ?? '' }}<br>
                                    {{ $order->shipping_info['address'] ?? '' }}<br>
                                    {{ $order->shipping_info['city'] ?? '' }}, {{ $order->shipping_info['state'] ?? '' }} {{ $order->shipping_info['zip_code'] ?? '' }}<br>
                                    Phone: {{ $order->shipping_info['phone'] ?? '' }}
                                </p>
                            </div>

                            <!-- Total -->
                            <div class="d-flex justify-content-between border-top pt-3">
                                <span class="fs-6 fs-md-5 fw-semibold">Total</span>
                                <span class="fs-6 fs-md-5 fw-bold">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

