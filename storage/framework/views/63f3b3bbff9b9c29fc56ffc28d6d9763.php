<?php $__env->startSection('content'); ?>
<div class="container-fluid px-3 px-md-4 py-3 py-md-4">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-3 mb-md-4 gap-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Order #<?php echo e($order->id); ?></h1>
            <p class="text-muted small mb-0">Placed <?php echo e($order->created_at->format('M d, Y \a\t H:i')); ?></p>
        </div>
        <div class="d-flex gap-2 w-100 w-md-auto">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary w-100 w-md-auto">Back to Dashboard</a>
            <a href="<?php echo e(route('admin.dashboard', request()->only('status'))); ?>" class="btn btn-dark w-100 w-md-auto">Orders</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="row g-3 g-md-4">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h2 class="h6 fw-semibold mb-0">Customer</h2>
                </div>
                <div class="card-body">
                    <p class="mb-1 fw-semibold"><?php echo e($order->user->name ?? 'N/A'); ?></p>
                    <p class="mb-0 text-muted small"><?php echo e($order->user->email ?? ''); ?></p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-dark text-white">
                    <h2 class="h6 fw-semibold mb-0">Shipping</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-1">
                        <div>
                            <span class="text-muted small">Full name:</span>
                            <span class="fw-semibold"><?php echo e($order->shipping_info['full_name'] ?? 'N/A'); ?></span>
                        </div>
                        <div>
                            <span class="text-muted small">Address:</span>
                            <span class="fw-semibold"><?php echo e($order->shipping_info['address'] ?? 'N/A'); ?></span>
                        </div>
                        <div>
                            <span class="text-muted small">City/State:</span>
                            <span class="fw-semibold"><?php echo e(($order->shipping_info['city'] ?? 'N/A')); ?><?php echo e(isset($order->shipping_info['state']) ? ', ' . $order->shipping_info['state'] : ''); ?></span>
                        </div>
                        <div>
                            <span class="text-muted small">Zip:</span>
                            <span class="fw-semibold"><?php echo e($order->shipping_info['zip_code'] ?? 'N/A'); ?></span>
                        </div>
                        <div>
                            <span class="text-muted small">Phone:</span>
                            <span class="fw-semibold"><?php echo e($order->shipping_info['phone'] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-dark text-white">
                    <h2 class="h6 fw-semibold mb-0">Payment</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted small">Method</span>
                        <span class="fw-semibold text-uppercase"><?php echo e($order->payment_method); ?></span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <span class="text-muted small">Status</span>
                        <span class="badge <?php echo e(($order->payment_status ?? 'unpaid') === 'paid' ? 'text-bg-success' : ((($order->payment_status ?? 'unpaid') === 'failed') ? 'text-bg-danger' : ((($order->payment_status ?? 'unpaid') === 'cancelled') ? 'text-bg-dark' : 'text-bg-secondary'))); ?>">
                            <?php echo e(strtoupper($order->payment_status ?? 'unpaid')); ?>

                        </span>
                    </div>
                    <?php if(!empty($order->stripe_payment_intent_id)): ?>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <span class="text-muted small">Stripe PI</span>
                            <span class="fw-semibold"><?php echo e($order->stripe_payment_intent_id); ?></span>
                        </div>
                    <?php elseif($order->payment_method === 'card'): ?>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <span class="text-muted small">Stripe PI</span>
                            <span class="fw-semibold">N/A</span>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($order->paid_at)): ?>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <span class="text-muted small">Paid at</span>
                            <span class="fw-semibold"><?php echo e($order->paid_at->format('M d, Y H:i')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($order->cancelled_at)): ?>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <span class="text-muted small">Cancelled at</span>
                            <span class="fw-semibold"><?php echo e($order->cancelled_at->format('M d, Y H:i')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($order->restocked_at)): ?>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <span class="text-muted small">Restocked at</span>
                            <span class="fw-semibold"><?php echo e($order->restocked_at->format('M d, Y H:i')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if(empty($order->cancelled_at) && ($order->status !== 'delivered')): ?>
                        <form action="<?php echo e(route('admin.orders.cancel', $order)); ?>" method="POST" class="mt-3">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Cancel this order? If payment is PAID, stock will be restocked.');">
                                Cancel & Restock
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
                    <h2 class="h6 fw-semibold mb-0">Items</h2>
                    <span class="badge <?php echo e($order->status === 'delivered' ? 'text-bg-success' : ($order->status === 'shipped' ? 'text-bg-info' : ($order->status === 'confirmed' ? 'text-bg-primary' : 'text-bg-warning'))); ?>">
                        <?php echo e(ucfirst($order->status)); ?>

                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Product</th>
                                    <th>Variant</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-end pe-3">Line Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-semibold"><?php echo e($item->product->name ?? 'Product'); ?></div>
                                            <div class="text-muted small">#<?php echo e($item->product_id); ?></div>
                                        </td>
                                        <td>
                                            <span class="text-muted small">Size <?php echo e($item->size); ?>, <?php echo e($item->color); ?></span>
                                        </td>
                                        <td class="text-end">$<?php echo e(number_format($item->price, 2)); ?></td>
                                        <td class="text-end"><?php echo e($item->quantity); ?></td>
                                        <td class="text-end pe-3">$<?php echo e(number_format($item->price * $item->quantity, 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex flex-column gap-1" style="max-width: 20rem; margin-left: auto;">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total</span>
                            <span class="fw-bold">$<?php echo e(number_format($order->total, 2)); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-dark text-white">
                    <h2 class="h6 fw-semibold mb-0">Update Status</h2>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.orders.update', $order)); ?>" method="POST" class="d-flex flex-column flex-md-row align-items-start align-items-md-end gap-2">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <div class="w-100">
                            <label class="form-label small">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="confirmed" <?php echo e($order->status === 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                                <option value="shipped" <?php echo e($order->status === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                                <option value="delivered" <?php echo e($order->status === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 w-md-auto">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/pages/admin/orders/show.blade.php ENDPATH**/ ?>