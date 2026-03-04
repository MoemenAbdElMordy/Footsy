@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="d-flex align-items-center" 
         style="height: 600px; background-color: var(--color-gray-900); background-image: url('https://images.unsplash.com/photo-1695459468644-717c8ae17eed?w=1600&q=80'); background-size: cover; background-position: center; background-blend-mode: overlay;">
    <div class="container px-4 w-100">
        <div class="text-white" style="max-width: 42rem; background-color: rgba(0,0,0,0.4); padding: var(--spacing-xl); border-radius: var(--radius-lg);">
            <h1 class="display-4 fw-bold mb-4">Step Into Style</h1>
            <p class="lead mb-4">
                Discover the latest footwear trends for men, women, and kids. Quality meets comfort in every step.
            </p>
            <div class="d-flex gap-3 flex-column flex-sm-row">
                <a href="{{ route('shop.index') }}" 
                   class="btn btn-success btn-lg"
                   style="background-color: var(--color-success); border-color: var(--color-success);">
                    Shop Now
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <a href="{{ route('shop.index') }}" 
                   class="btn btn-outline-light btn-lg">
                    View Collections
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5" style="padding-top: var(--spacing-3xl); padding-bottom: var(--spacing-3xl);">
    <div class="container px-4">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Shop by Category</h2>
            <p class="text-muted">Find the perfect footwear for everyone</p>
        </div>
        <div class="row g-4">
            @php
                $categories = [
                    ['title' => "Men's Collection", 'image' => 'https://images.unsplash.com/photo-1579528542333-4148f1769c35?w=800&q=80', 'path' => route('shop.category', 'men')],
                    ['title' => "Women's Collection", 'image' => 'https://images.unsplash.com/photo-1554238113-6d3dbed5cf55?w=800&q=80', 'path' => route('shop.category', 'women')],
                    ['title' => "Kids' Collection", 'image' => 'https://images.unsplash.com/photo-1583979365152-173a8f14181b?w=800&q=80', 'path' => route('shop.category', 'kids')],
                ];
            @endphp
            @foreach($categories as $category)
                <div class="col-12 col-md-4">
                    <div class="d-flex flex-column overflow-hidden rounded" 
                         style="height: 20rem; min-height: 15rem; cursor: pointer;"
                         onclick="window.location.href='{{ $category['path'] }}'">
                        <div class="flex-grow-1 overflow-hidden">
                            <img src="{{ $category['image'] }}" 
                                 alt="{{ $category['title'] }}"
                                 class="w-100 h-100 object-fit-cover"
                                 style="transition: transform var(--transition-base);"
                                 onmouseover="this.style.transform='scale(1.1)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </div>
                        <div class="p-4 text-white"
                             style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); margin-top: auto;">
                            <h3 class="h4 fw-bold mb-2">{{ $category['title'] }}</h3>
                            <span class="d-inline-flex align-items-center text-success">
                                Explore Now
                                <i class="bi bi-arrow-right ms-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5" style="background-color: var(--color-gray-50); padding-top: var(--spacing-3xl); padding-bottom: var(--spacing-3xl);">
    <div class="container px-4">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Featured Products</h2>
            <p class="text-muted">Our most popular items this season</p>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts ?? [] as $product)
                <div class="col-6 col-sm-6 col-lg-3">
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('shop.index') }}" 
               class="btn btn-outline-primary btn-lg">
                View All Products
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-5" style="padding-top: var(--spacing-3xl); padding-bottom: var(--spacing-3xl);">
    <div class="container px-4">
        <div class="row g-4">
            <div class="col-12 col-md-4 text-center">
                <div class="mb-4 d-flex justify-content-center">
                    <i class="bi bi-bag fs-1 text-success"></i>
                </div>
                <h3 class="h5 fw-semibold mb-2">Free Shipping</h3>
                <p class="text-muted">Free shipping on orders over $50</p>
            </div>
            <div class="col-12 col-md-4 text-center">
                <div class="mb-4 d-flex justify-content-center">
                    <i class="bi bi-graph-up fs-1 text-success"></i>
                </div>
                <h3 class="h5 fw-semibold mb-2">Latest Trends</h3>
                <p class="text-muted">Stay ahead with newest styles</p>
            </div>
            <div class="col-12 col-md-4 text-center">
                <div class="mb-4 d-flex justify-content-center">
                    <i class="bi bi-shield-check fs-1 text-success"></i>
                </div>
                <h3 class="h5 fw-semibold mb-2">Secure Payment</h3>
                <p class="text-muted">Your payment information is safe</p>
            </div>
        </div>
    </div>
</section>
@endsection

