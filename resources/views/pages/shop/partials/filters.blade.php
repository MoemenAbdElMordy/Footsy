<form method="GET" action="{{ route('shop.index') }}" class="d-flex flex-column gap-4">
    <!-- Search -->
    <div>
        <label class="form-label fw-medium">Search</label>
        <input type="text" 
               name="search" 
               class="form-control mt-2" 
               placeholder="Search products..."
               value="{{ request('search') }}"
               style="background-color: var(--color-input-background);">
    </div>

    <!-- Price Range -->
    <div>
        <label class="form-label fw-medium">Price Range</label>
        <div class="mt-3">
            <input type="range" 
                   class="form-range" 
                   name="min_price"
                   min="0" 
                   max="300" 
                   step="10"
                   value="{{ request('min_price', 0) }}"
                   oninput="document.getElementById('minPriceDisplay').textContent = '$' + this.value">
            <input type="range" 
                   class="form-range" 
                   name="max_price"
                   min="0" 
                   max="300" 
                   step="10"
                   value="{{ request('max_price', 300) }}"
                   oninput="document.getElementById('maxPriceDisplay').textContent = '$' + this.value">
            <div class="d-flex justify-content-between small text-muted mt-2">
                <span id="minPriceDisplay">${{ request('min_price', 0) }}</span>
                <span id="maxPriceDisplay">${{ request('max_price', 300) }}</span>
            </div>
        </div>
    </div>

    <!-- Brands -->
    <div>
        <label class="form-label fw-medium">Brands</label>
        <div class="mt-2 d-flex flex-column gap-2">
            @foreach($brands ?? [] as $brand)
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="brands[]" 
                           value="{{ $brand }}"
                           id="brand-{{ $brand }}"
                           {{ in_array($brand, request('brands', [])) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="brand-{{ $brand }}">
                        {{ $brand }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Colors -->
    <div>
        <label class="form-label fw-medium">Colors</label>
        <div class="mt-2 d-flex flex-column gap-2">
            @foreach($colors ?? [] as $color)
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="colors[]" 
                           value="{{ $color }}"
                           id="color-{{ $color }}"
                           {{ in_array($color, request('colors', [])) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="color-{{ $color }}">
                        {{ $color }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary w-100">
        <i class="bi bi-x me-2"></i>
        Clear Filters
    </a>
</form>

