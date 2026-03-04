

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-3 px-md-4 py-3 py-md-4">
    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-link text-dark mb-3 mb-md-4 text-decoration-none">
        <i class="bi bi-arrow-left me-2"></i>
        Back
    </a>

    <div class="row g-3 g-md-4">
        <!-- Image Gallery -->
        <div class="col-12 col-lg-6">
        <div class="mb-3 mb-md-4 overflow-hidden rounded" style="background-color: var(--color-gray-100);">
            <img src="<?php echo e(($product->images[0] ?? '/images/placeholder.jpg')); ?>" 
                 alt="<?php echo e($product->name); ?>"
                 class="w-100 main-product-image"
                 style="min-height: 250px; height: 50vh; max-height: 500px; object-fit: cover;">
        </div>
            <?php if(count($product->images) > 1): ?>
                <div class="d-flex gap-2 flex-wrap">
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button"
                                class="btn p-0 border rounded overflow-hidden thumbnail-btn <?php echo e($index === 0 ? 'border-success border-2' : 'border-secondary'); ?>"
                                style="width: 4rem; height: 4rem; min-width: 4rem;"
                                onclick="document.querySelector('.main-product-image').src='<?php echo e($image); ?>'; document.querySelectorAll('.thumbnail-btn').forEach(btn => { btn.classList.remove('border-success', 'border-2'); btn.classList.add('border-secondary'); }); this.classList.remove('border-secondary'); this.classList.add('border-success', 'border-2');">
                            <img src="<?php echo e($image); ?>" 
                                 alt="<?php echo e($product->name); ?> <?php echo e($index + 1); ?>"
                                 class="w-100 h-100 object-fit-cover">
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Product Details -->
        <div class="col-12 col-lg-6">
            <div class="mb-3 mb-md-4">
                <span class="badge bg-secondary mb-2"><?php echo e(ucfirst($product->category)); ?></span>
                <h1 class="h3 h2-md display-6 fw-bold mb-2"><?php echo e($product->name); ?></h1>
                <p class="text-muted small"><?php echo e($product->brand); ?></p>
            </div>

            <div class="mb-3 mb-md-4">
                <span class="h3 h2-md display-6 fw-bold">$<?php echo e(number_format($product->price, 2)); ?></span>
                <?php if($product->stock > 0): ?>
                    <span class="badge bg-success ms-2 ms-md-3">In Stock</span>
                <?php else: ?>
                    <span class="badge bg-danger ms-2 ms-md-3">Out of Stock</span>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <p class="text-dark"><?php echo e($product->description); ?></p>
            </div>

            <!-- Size Selection -->
            <div class="mb-4">
                <label class="form-label fw-semibold mb-3">Select Size</label>
                <div class="d-flex flex-wrap gap-2">
                    <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button"
                                class="btn btn-outline-secondary size-btn"
                                data-size="<?php echo e($size); ?>"
                                onclick="selectSize(<?php echo e($size); ?>)">
                            <?php echo e($size); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Color Selection -->
            <div class="mb-4">
                <label class="form-label fw-semibold mb-3">Select Color</label>
                <div class="d-flex flex-wrap gap-2">
                    <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button"
                                class="btn btn-outline-secondary color-btn"
                                data-color="<?php echo e($color); ?>"
                                onclick="selectColor('<?php echo e($color); ?>')">
                            <?php echo e($color); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="flex-fill w-100">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                    <input type="hidden" name="size" id="selectedSizeInput" value="" required>
                    <input type="hidden" name="color" id="selectedColorInput" value="" required>
                    <input type="hidden" name="quantity" id="quantityInput" value="1">
                    <button type="submit" 
                            class="btn btn-success btn-lg w-100"
                            style="background-color: var(--color-success); border-color: var(--color-success);"
                            <?php echo e($product->stock === 0 ? 'disabled' : ''); ?>>
                        <i class="bi bi-cart me-2"></i>
                        Add to Cart
                    </button>
                </form>
                <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-outline-primary btn-lg w-100 w-sm-auto">
                    View Cart
                </a>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="mt-4 mt-md-5">
        <h2 class="h4 h3-md fw-bold mb-3 mb-md-4">You May Also Like</h2>
        <div class="row g-3 g-md-4">
            <?php $__currentLoopData = $relatedProducts ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100" style="cursor: pointer;" onclick="window.location.href='<?php echo e(route('products.show', $relatedProduct->id)); ?>'">
                        <div class="position-relative" style="aspect-ratio: 1; overflow: hidden; background-color: var(--color-gray-100);">
                            <img src="<?php echo e($relatedProduct->images[0] ?? '/images/placeholder.jpg'); ?>" 
                                 alt="<?php echo e($relatedProduct->name); ?>"
                                 class="card-img-top w-100 h-100 object-fit-cover"
                                 style="transition: transform var(--transition-base);"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <h5 class="card-title fw-medium small"><?php echo e($relatedProduct->name); ?></h5>
                            <p class="text-muted small mb-0">$<?php echo e(number_format($relatedProduct->price, 2)); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<script>
let selectedSize = null;
let selectedColor = '';
let quantity = 1;
const maxStock = <?php echo e($product->stock); ?>;

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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/pages/products/show.blade.php ENDPATH**/ ?>