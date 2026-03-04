@extends('layouts.app')

@section('content')
<div class="container px-4 py-4">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h1 class="display-6 fw-bold mb-2">{{ $pageTitle ?? 'All Products' }}</h1>
            <p class="text-muted">{{ $products->count() }} products found</p>
        </div>
        <!-- Mobile Filter Button -->
        <button class="btn btn-outline-primary d-lg-none" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#filterSidebar">
            <i class="bi bi-funnel me-2"></i>
            Filters
        </button>
    </div>

        <div class="row">
            <!-- Desktop Filters -->
            <aside class="col-lg-3 d-none d-lg-block">
                <div class="sticky-top" style="top: calc(var(--spacing-xl) + 1rem);">
                    <h2 class="h5 fw-semibold mb-4">Filters</h2>
                    @include('pages.shop.partials.filters')
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="col-lg-9">
                @if($products->count() > 0)
                    <div class="row g-4">
                        @foreach($products as $product)
                            <div class="col-6 col-sm-6 col-lg-4">
                                <x-product-card :product="$product" />
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="lead text-muted">No products found matching your criteria.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3">
                            Clear Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
</div>

<!-- Mobile Filter Sidebar -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="filterSidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Filters</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        @include('pages.shop.partials.filters')
    </div>
</div>
@endsection

