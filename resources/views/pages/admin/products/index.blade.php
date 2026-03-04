@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3 py-md-4">
    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3 mb-md-4 gap-3">
        <div>
            <h1 class="h4 fw-bold mb-0">Products</h1>
            <p class="text-muted small mb-0">Manage your catalog</p>
        </div>
        <div class="d-flex gap-2 w-100 w-sm-auto">
            <a href="{{ route('admin.products.create') }}" class="btn btn-success w-100 w-sm-auto">
                <i class="bi bi-plus-lg me-2"></i>
                Add Product
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary w-100 w-sm-auto">
                Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header bg-dark text-white">
            <h2 class="h6 fw-semibold mb-0">All Products</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Product</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Stock</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ ($product->images[0] ?? '/images/placeholder.jpg') }}" alt="{{ $product->name }}" class="rounded" style="width: 2.5rem; height: 2.5rem; object-fit: cover;">
                                        <div>
                                            <div class="fw-semibold">{{ $product->name }}</div>
                                            <div class="text-muted small">#{{ $product->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-capitalize">{{ $product->category }}</td>
                                <td>{{ $product->brand }}</td>
                                <td class="text-end">${{ number_format($product->price, 2) }}</td>
                                <td class="text-end">
                                    <span class="badge {{ $product->stock === 0 ? 'text-bg-danger' : ($product->stock < 10 ? 'text-bg-warning' : 'text-bg-success') }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
