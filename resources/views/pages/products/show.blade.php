@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3 py-md-4">
    <a href="{{ url()->previous() }}" class="btn btn-link text-dark mb-3 mb-md-4 text-decoration-none">
        <i class="bi bi-arrow-left me-2"></i>
        Back
    </a>

    <div class="row g-3 g-md-4">
        <!-- Image Gallery -->
        <div class="col-12 col-lg-6">
        <div class="mb-3 mb-md-4 overflow-hidden rounded" style="background-color: var(--color-gray-100);">
            <img src="{{ ($product->images[0] ?? '/images/placeholder.jpg') }}" 
                 alt="{{ $product->name }}"
                 class="w-100 main-product-image"
                 style="min-height: 250px; height: 50vh; max-height: 500px; object-fit: cover;">
        </div>
            @if(count($product->images) > 1)
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($product->images as $index => $image)
                        <button type="button"
                                class="btn p-0 border rounded overflow-hidden thumbnail-btn {{ $index === 0 ? 'border-success border-2' : 'border-secondary' }}"
                                style="width: 4rem; height: 4rem; min-width: 4rem;"
                                onclick="document.querySelector('.main-product-image').src='{{ $image }}'; document.querySelectorAll('.thumbnail-btn').forEach(btn => { btn.classList.remove('border-success', 'border-2'); btn.classList.add('border-secondary'); }); this.classList.remove('border-secondary'); this.classList.add('border-success', 'border-2');">
                            <img src="{{ $image }}" 
                                 alt="{{ $product->name }} {{ $index + 1 }}"
                                 class="w-100 h-100 object-fit-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-12 col-lg-6">
            <div class="mb-3 mb-md-4">
                <span class="badge bg-secondary mb-2">{{ ucfirst($product->category) }}</span>
                <h1 class="h3 h2-md display-6 fw-bold mb-2">{{ $product->name }}</h1>
                <p class="text-muted small">{{ $product->brand }}</p>
            </div>

            <div class="mb-3 mb-md-4">
                <span class="h3 h2-md display-6 fw-bold">${{ number_format($product->price, 2) }}</span>
                @if($product->stock > 0)
                    <span class="badge bg-success ms-2 ms-md-3">In Stock</span>
                @else
                    <span class="badge bg-danger ms-2 ms-md-3">Out of Stock</span>
                @endif
            </div>

            <div class="mb-4">
                <p class="text-dark">{{ $product->description }}</p>
            </div>

            <!-- Size Selection -->
            <div class="mb-4">
                <label class="form-label fw-semibold mb-3">Select Size</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($product->sizes as $size)
                        <button type="button"
                                class="btn btn-outline-secondary size-btn"
                                data-size="{{ $size }}"
                                onclick="selectSize({{ $size }})">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Color Selection -->
            <div class="mb-4">
                <label class="form-label fw-semibold mb-3">Select Color</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($product->colors as $color)
                        <button type="button"
                                class="btn btn-outline-secondary color-btn"
                                data-color="{{ $color }}"
                                onclick="selectColor('{{ $color }}')">
                            {{ $color }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Quantity -->
            <div class="mb-4">
                <label class="form-label fw-semibold mb-3">Quantity</label>
                <div class="d-flex align-items-center gap-3">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            onclick="updateQuantity(-1)"
                            id="decreaseQty">
                        -
                    </button>
                    <span class="fs-5 fw-semibold quantity-display">1</span>
                    <button type="button"
                            class="btn btn-outline-secondary"
                            onclick="updateQuantity(1)"
                            id="increaseQty">
                        +
                    </button>
                </div>
            </div>

            <!-- Add to Cart Button -->
            <div class="d-flex flex-column flex-sm-row gap-2 gap-md-3">
                <form action="{{ route('cart.add') }}" method="POST" class="flex-fill w-100">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="size" id="selectedSizeInput" value="" required>
                    <input type="hidden" name="color" id="selectedColorInput" value="" required>
                    <input type="hidden" name="quantity" id="quantityInput" value="1">
                    <button type="submit" 
                            class="btn btn-success btn-lg w-100"
                            style="background-color: var(--color-success); border-color: var(--color-success);"
                            {{ $product->stock === 0 ? 'disabled' : '' }}>
                        <i class="bi bi-cart me-2"></i>
                        Add to Cart
                    </button>
                </form>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-primary btn-lg w-100 w-sm-auto">
                    View Cart
                </a>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="mt-4 mt-md-5">
        <h2 class="h4 h3-md fw-bold mb-3 mb-md-4">You May Also Like</h2>
        <div class="row g-3 g-md-4">
            @foreach($relatedProducts ?? [] as $relatedProduct)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100" style="cursor: pointer;" onclick="window.location.href='{{ route('products.show', $relatedProduct->id) }}'">
                        <div class="position-relative" style="aspect-ratio: 1; overflow: hidden; background-color: var(--color-gray-100);">
                            <img src="{{ $relatedProduct->images[0] ?? '/images/placeholder.jpg' }}" 
                                 alt="{{ $relatedProduct->name }}"
                                 class="card-img-top w-100 h-100 object-fit-cover"
                                 style="transition: transform var(--transition-base);"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <h5 class="card-title fw-medium small">{{ $relatedProduct->name }}</h5>
                            <p class="text-muted small mb-0">${{ number_format($relatedProduct->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
let selectedSize = null;
let selectedColor = '';
let quantity = 1;
const maxStock = {{ $product->stock }};

function selectSize(size) {
    selectedSize = size;
    document.getElementById('selectedSizeInput').value = size;
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.classList.remove('btn-success');
        btn.classList.add('btn-outline-secondary');
        if (parseInt(btn.dataset.size) === size) {
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-success');
        }
    });
}

function selectColor(color) {
    selectedColor = color;
    document.getElementById('selectedColorInput').value = color;
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.classList.remove('btn-success');
        btn.classList.add('btn-outline-secondary');
        if (btn.dataset.color === color) {
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-success');
        }
    });
}

function updateQuantity(change) {
    const newQuantity = Math.max(1, Math.min(quantity + change, maxStock));
    quantity = newQuantity;
    document.getElementById('quantityInput').value = newQuantity;
    document.querySelector('.quantity-display').textContent = newQuantity;
    
    // Update button states
    document.getElementById('decreaseQty').disabled = newQuantity <= 1;
    document.getElementById('increaseQty').disabled = newQuantity >= maxStock;
}

// Initialize button states
document.getElementById('decreaseQty').disabled = true;
</script>
@endsection

