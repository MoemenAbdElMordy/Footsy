

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-3 px-md-4 py-3 py-md-4">
    <h1 class="h3 h2-md display-6 fw-bold mb-3 mb-md-4">Shopping Cart</h1>

    <?php if($cartItems->isEmpty()): ?>
        <div class="text-center py-4 py-md-5">
            <i class="bi bi-bag fs-1 text-muted mb-3 mb-md-4"></i>
            <h2 class="h4 h3-md fw-bold mb-2">Your Cart is Empty</h2>
            <p class="text-muted mb-3 mb-md-4">Add some products to get started!</p>
            <a href="<?php echo e(route('shop.index')); ?>" 
               class="btn btn-success w-100 w-md-auto"
               style="background-color: var(--color-success); border-color: var(--color-success);">
                Continue Shopping
            </a>
        </div>
    <?php else: ?>
        <div class="row g-3 g-md-4">
            <!-- Cart Items -->
            <div class="col-12 col-lg-8">
                <div class="d-flex flex-column gap-3">
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <div class="flex-shrink-0 mx-auto mx-sm-0" style="width: 5rem; height: 5rem; min-width: 5rem; overflow: hidden; border-radius: var(--radius-lg); background-color: var(--color-gray-100);">
                                        <img src="<?php echo e($item->product->images[0] ?? '/images/placeholder.jpg'); ?>" 
                                             alt="<?php echo e($item->product->name); ?>"
                                             class="w-100 h-100 object-fit-cover">
                                    </div>

                                    <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="fw-semibold mb-1 small-md-base"><?php echo e($item->product->name); ?></h5>
                                            <p class="small text-muted mb-1"><?php echo e($item->product->brand); ?></p>
                                            <div class="d-flex flex-wrap gap-2 gap-md-3 small text-muted">
                                                <span>Size: <?php echo e($item->size); ?></span>
                                                <span>Color: <?php echo e($item->color); ?></span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between justify-content-sm-start gap-3 mt-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <input type="hidden" name="quantity" value="<?php echo e(max(1, $item->quantity - 1)); ?>">
                                                    <button type="submit" 
                                                            class="btn btn-outline-secondary btn-sm"
                                                            <?php echo e($item->quantity <= 1 ? 'disabled' : ''); ?>>
                                                        -
                                                    </button>
                                                </form>
                                                <span class="text-center" style="width: 2rem;"><?php echo e($item->quantity); ?></span>
                                                <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <input type="hidden" name="quantity" value="<?php echo e($item->quantity + 1); ?>">
                                                    <button type="submit" 
                                                            class="btn btn-outline-secondary btn-sm"
                                                            <?php echo e($item->quantity >= $item->product->stock ? 'disabled' : ''); ?>>
                                                        +
                                                    </button>
                                                </form>
                                            </div>
                                            <span class="fs-6 fs-md-5 fw-semibold">$<?php echo e(number_format($item->product->price * $item->quantity, 2)); ?></span>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row flex-sm-column align-items-center align-items-sm-end justify-content-between justify-content-sm-start gap-2">
                                        <form action="<?php echo e(route('cart.remove', $item->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-link text-danger p-0">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <span class="fw-medium">$<?php echo e(number_format($subtotal, 2)); ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Shipping</span>
                                <span class="fw-medium"><?php echo e($subtotal > 50 ? 'Free' : '$5.00'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tax</span>
                                <span class="fw-medium">$<?php echo e(number_format($tax, 2)); ?></span>
                            </div>
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between">
                                    <span class="fs-5 fw-semibold">Total</span>
                                    <span class="fs-5 fw-bold">$<?php echo e(number_format($total, 2)); ?></span>
                                </div>
                            </div>
                        </div>

                        <a href="<?php echo e(route('checkout.index')); ?>" 
                           class="btn btn-success w-100 btn-lg mb-3"
                           style="background-color: var(--color-success); border-color: var(--color-success);">
                            Proceed to Checkout
                        </a>

                        <a href="<?php echo e(route('shop.index')); ?>" 
                           class="btn btn-outline-secondary w-100">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/pages/cart/index.blade.php ENDPATH**/ ?>