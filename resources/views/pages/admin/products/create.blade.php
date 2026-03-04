@extends('layouts.app')

@section('content')
<div class="container px-3 px-md-4 py-3 py-md-4">
    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3 mb-md-4 gap-3">
        <div>
            <h1 class="h4 fw-bold mb-0">Add Product</h1>
            <p class="text-muted small mb-0">Create a new product</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100 w-sm-auto">Back</a>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">
            <h2 class="h6 fw-semibold mb-0">Product Details</h2>
        </div>
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                @csrf

                <div>
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="men" {{ old('category') === 'men' ? 'selected' : '' }}>Men</option>
                            <option value="women" {{ old('category') === 'women' ? 'selected' : '' }}>Women</option>
                            <option value="kids" {{ old('category') === 'kids' ? 'selected' : '' }}>Kids</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" required>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Colors (comma separated)</label>
                        <input type="text" name="colors" class="form-control" value="{{ old('colors') }}" placeholder="Black, White, Red" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Sizes (comma separated)</label>
                        <input type="text" name="sizes" class="form-control" value="{{ old('sizes') }}" placeholder="40, 41, 42" required>
                    </div>
                </div>

                <div>
                    <label class="form-label">Upload Images</label>
                    <input type="file" name="images_upload[]" class="form-control" multiple accept="image/*">
                </div>

                <div>
                    <label class="form-label">Images (comma separated URLs)</label>
                    <input type="text" name="images" class="form-control" value="{{ old('images') }}" placeholder="https://... , https://...">
                </div>

                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured" {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">Featured</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Create</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
