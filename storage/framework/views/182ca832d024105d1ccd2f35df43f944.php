

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-3 px-md-4 py-4 py-md-5">
    <div class="card mx-auto" style="max-width: 42rem;">
        <div class="card-body p-4 p-md-5 text-center">
            <i class="bi bi-check-circle-fill text-success mb-3 mb-md-4" style="font-size: 3rem; font-size: clamp(3rem, 5vw, 5rem);"></i>
            <h1 class="h3 h2-md display-6 fw-bold mb-2">Order Confirmed!</h1>
            <p class="text-muted mb-3 mb-md-4 small-md-base">
                Thank you for your purchase. Your order has been received and is being processed.
            </p>

            <div class="rounded p-3 p-md-4 mb-3 mb-md-4" style="background-color: var(--color-gray-50);">
                <p class="small text-muted mb-2">Order Number</p>
                <p class="h3 h2-md display-6 fw-bold mb-0">#<?php echo e($orderId); ?></p>
            </div>

            <div class="mb-4 text-start">
                <div class="d-flex gap-3 align-items-start">
                    <i class="bi bi-box-seam text-success fs-5"></i>
                    <div>
                        <h3 class="h6 fw-semibold">What's Next?</h3>
                        <p class="small text-muted mb-0">
                            We'll send you a confirmation email with your order details and tracking information once your order ships.
                        </p>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-2 gap-md-3">
                <a href="<?php echo e(route('orders.index')); ?>" 
                   class="btn btn-success flex-fill w-100 w-sm-auto"
                   style="background-color: var(--color-success); border-color: var(--color-success);">
                    View My Orders
                </a>
                <a href="<?php echo e(route('home')); ?>" 
                   class="btn btn-outline-secondary flex-fill w-100 w-sm-auto">
                    <i class="bi bi-house me-2"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/pages/orders/confirmation.blade.php ENDPATH**/ ?>