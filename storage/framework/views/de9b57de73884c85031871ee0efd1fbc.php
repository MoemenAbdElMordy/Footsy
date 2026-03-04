<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['product']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['product']); ?>
<?php foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="card h-100 overflow-hidden" style="transition: box-shadow var(--transition-base); cursor: pointer;" 
     onclick="window.location.href='<?php echo e(route('products.show', $product->id)); ?>'">
    <div class="d-flex flex-column" style="aspect-ratio: 1; overflow: hidden; background-color: var(--color-gray-100);">
        <div class="d-flex justify-content-end p-2" style="z-index: 1;">
            <?php if($product->stock < 10 && $product->stock > 0): ?>
                <span class="badge bg-warning" style="background-color: var(--color-warning);">
                    Low Stock
                </span>
            <?php endif; ?>
            
            <?php if($product->stock === 0): ?>
                <span class="badge bg-danger" style="background-color: var(--color-danger);">
                    Out of Stock
                </span>
            <?php endif; ?>
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <img src="<?php echo e($product->images[0] ?? '/images/placeholder.jpg'); ?>" 
                 alt="<?php echo e($product->name); ?>"
                 class="w-100 h-100 object-fit-cover"
                 style="transition: transform var(--transition-base);"
                 onmouseover="this.style.transform='scale(1.05)'"
                 onmouseout="this.style.transform='scale(1)'">
        </div>
    </div>
    
    <div class="card-body p-4">
        <h5 class="card-title mb-2 fw-medium" style="font-size: var(--font-size-base);">
            <?php echo e(Str::limit($product->name, 50)); ?>

        </h5>
        <p class="text-muted small mb-3"><?php echo e($product->brand); ?></p>
        <div class="d-flex align-items-center justify-content-between">
            <span class="fs-5 fw-semibold">$<?php echo e(number_format($product->price, 2)); ?></span>
            <div class="d-flex align-items-center justify-content-center rounded-circle bg-success text-white opacity-0"
                 style="width: 2rem; height: 2rem; transition: opacity var(--transition-base);"
                 onmouseover="this.parentElement.parentElement.parentElement.onmouseover = function() { this.querySelector('.cart-icon').style.opacity = '1'; }"
                 onmouseout="this.parentElement.parentElement.parentElement.onmouseout = function() { this.querySelector('.cart-icon').style.opacity = '0'; }">
                <i class="bi bi-cart cart-icon"></i>
            </div>
        </div>
    </div>
</div>

<style>
.card:hover {
    box-shadow: var(--shadow-lg);
}
.card:hover .cart-icon {
    opacity: 1 !important;
}
</style>

<?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/components/product-card.blade.php ENDPATH**/ ?>