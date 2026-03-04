<form method="GET" action="<?php echo e(route('shop.index')); ?>" class="d-flex flex-column gap-4">
    <!-- Search -->
    <div>
        <label class="form-label fw-medium">Search</label>
        <input type="text" 
               name="search" 
               class="form-control mt-2" 
               placeholder="Search products..."
               value="<?php echo e(request('search')); ?>"
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
                   value="<?php echo e(request('min_price', 0)); ?>"
                   oninput="document.getElementById('minPriceDisplay').textContent = '$' + this.value">
            <input type="range" 
                   class="form-range" 
                   name="max_price"
                   min="0" 
                   max="300" 
                   step="10"
                   value="<?php echo e(request('max_price', 300)); ?>"
                   oninput="document.getElementById('maxPriceDisplay').textContent = '$' + this.value">
            <div class="d-flex justify-content-between small text-muted mt-2">
                <span id="minPriceDisplay">$<?php echo e(request('min_price', 0)); ?></span>
                <span id="maxPriceDisplay">$<?php echo e(request('max_price', 300)); ?></span>
            </div>
        </div>
    </div>

    <!-- Brands -->
    <div>
        <label class="form-label fw-medium">Brands</label>
        <div class="mt-2 d-flex flex-column gap-2">
            <?php $__currentLoopData = $brands ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="brands[]" 
                           value="<?php echo e($brand); ?>"
                           id="brand-<?php echo e($brand); ?>"
                           <?php echo e(in_array($brand, request('brands', [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label small" for="brand-<?php echo e($brand); ?>">
                        <?php echo e($brand); ?>

                    </label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Colors -->
    <div>
        <label class="form-label fw-medium">Colors</label>
        <div class="mt-2 d-flex flex-column gap-2">
            <?php $__currentLoopData = $colors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="colors[]" 
                           value="<?php echo e($color); ?>"
                           id="color-<?php echo e($color); ?>"
                           <?php echo e(in_array($color, request('colors', [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label small" for="color-<?php echo e($color); ?>">
                        <?php echo e($color); ?>

                    </label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
    <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-outline-secondary w-100">
        <i class="bi bi-x me-2"></i>
        Clear Filters
    </a>
</form>

<?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/pages/shop/partials/filters.blade.php ENDPATH**/ ?>