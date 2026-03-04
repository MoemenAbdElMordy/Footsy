@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3 py-md-4">
    <h1 class="h3 h2-md display-6 fw-bold mb-3 mb-md-4">Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <div class="text-center py-4 py-md-5">
            <i class="bi bi-bag fs-1 text-muted mb-3 mb-md-4"></i>
            <h2 class="h4 h3-md fw-bold mb-2">Your Cart is Empty</h2>
            <p class="text-muted mb-3 mb-md-4">Add some products to get started!</p>
            <a href="{{ route('shop.index') }}" 
               class="btn btn-success w-100 w-md-auto"
               style="background-color: var(--color-success); border-color: var(--color-success);">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="row g-3 g-md-4">
            <!-- Cart Items -->
            <div class="col-12 col-lg-8">
                <div class="d-flex flex-column gap-3">
                    @foreach($cartItems as $item)
                        <div class="card">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <div class="flex-shrink-0 mx-auto mx-sm-0" style="width: 5rem; height: 5rem; min-width: 5rem; overflow: hidden; border-radius: var(--radius-lg); background-color: var(--color-gray-100);">
                                        <img src="{{ $item->product->images[0] ?? '/images/placeholder.jpg' }}" 
                                             alt="{{ $item->product->name }}"
                                             class="w-100 h-100 object-fit-cover">
                                    </div>

                                    <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="fw-semibold mb-1 small-md-base">{{ $item->product->name }}</h5>
                                            <p class="small text-muted mb-1">{{ $item->product->brand }}</p>
                                            <div class="d-flex flex-wrap gap-2 gap-md-3 small text-muted">
                                                <span>Size: {{ $item->size }}</span>
                                                <span>Color: {{ $item->color }}</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between justify-content-sm-start gap-3 mt-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                    <button type="submit" 
                                                            class="btn btn-outline-secondary btn-sm"
                                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        -
                                                    </button>
                                                </form>
                                                <span class="text-center" style="width: 2rem;">{{ $item->quantity }}</span>
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                    <button type="submit" 
                                                            class="btn btn-outline-secondary btn-sm"
                                                            {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                                        +
                                                    </button>
                                                </form>
                                            </div>
                                            <span class="fs-6 fs-md-5 fw-semibold">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row flex-sm-column align-items-center align-items-sm-end justify-content-between justify-content-sm-start gap-2">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-12 col-lg-4">
                <div class="card sticky-top" style="top: calc(var(--spacing-xl) + 1rem);">
                    <div class="card-body p-3 p-md-4">
                        <h2 class="h5 fw-semibold mb-3 mb-md-4">Order Summary</h2>

                        <div class="d-flex flex-column gap-2 mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-medium">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Shipping</span>
                                <span class="fw-medium">{{ $subtotal > 50 ? 'Free' : '$5.00' }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tax</span>
                                <span class="fw-medium">${{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between">
                                    <span class="fs-5 fw-semibold">Total</span>
                                    <span class="fs-5 fw-bold">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" 
                           class="btn btn-success w-100 btn-lg mb-3"
                           style="background-color: var(--color-success); border-color: var(--color-success);">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('shop.index') }}" 
                           class="btn btn-outline-secondary w-100">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

