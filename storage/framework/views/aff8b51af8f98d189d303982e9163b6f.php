

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-3 px-md-4 py-3 py-md-4">
    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3 mb-md-4 gap-3">
        <div>
            <h1 class="h3 h2-md display-6 fw-bold">Admin Dashboard</h1>
            <p class="text-muted small">Welcome back, <?php echo e(auth()->user()->name); ?></p>
        </div>
        <div class="d-flex gap-2 w-100 w-sm-auto">
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-success w-100 w-sm-auto">
                <i class="bi bi-plus-lg me-2"></i>
                Add Product
            </a>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-dark w-100 w-sm-auto">
                <i class="bi bi-box-seam me-2"></i>
                Manage Products
            </a>
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="w-100 w-sm-auto">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-outline-secondary w-100 w-sm-auto">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="row g-3 g-md-4 mb-3 mb-md-4">
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small text-muted mb-1">Total Revenue</p>
                            <p class="h5 h4-md fw-bold mb-0">$<?php echo e(number_format($totalRevenue, 2)); ?></p>
                        </div>
                        <i class="bi bi-currency-dollar text-success d-none d-md-block" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small text-muted mb-1">Total Orders</p>
                            <p class="h5 h4-md fw-bold mb-0"><?php echo e($totalOrders); ?></p>
                        </div>
                        <i class="bi bi-bag text-info d-none d-md-block" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small text-muted mb-1">Pending Orders</p>
                            <p class="h5 h4-md fw-bold mb-0"><?php echo e($pendingOrders); ?></p>
                        </div>
                        <i class="bi bi-box-seam text-warning d-none d-md-block" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small text-muted mb-1">Total Products</p>
                            <p class="h5 h4-md fw-bold mb-0"><?php echo e($products->count()); ?></p>
                        </div>
                        <i class="bi bi-box-seam text-primary d-none d-md-block" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" 
                    id="orders-tab" 
                    data-bs-toggle="tab" 
                    data-bs-target="#orders" 
                    type="button" 
                    role="tab">
                Orders
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" 
                    id="products-tab" 
                    data-bs-toggle="tab" 
                    data-bs-target="#products" 
                    type="button" 
                    role="tab">
                Products
            </button>
        </li>
    </ul>

    <div class="tab-content" id="adminTabsContent">
        <!-- Orders Tab -->
        <div class="tab-pane fade show active" id="orders" role="tabpanel">
            <div class="card">
                <div class="card-header bg-dark text-white d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2">
                    <h3 class="h5 fw-semibold mb-0">Recent Orders</h3>
                    <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center justify-content-between justify-content-md-end gap-2 w-100 w-md-auto">
                        <form action="<?php echo e(route('admin.dashboard')); ?>" method="GET" class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2 w-100">
                            <?php if(!empty($status)): ?>
                                <input type="hidden" name="status" value="<?php echo e($status); ?>">
                            <?php endif; ?>
                            <?php if(!empty($paymentStatus)): ?>
                                <input type="hidden" name="payment_status" value="<?php echo e($paymentStatus); ?>">
                            <?php endif; ?>
                            <input type="text" name="order_id" class="form-control form-control-sm" style="min-width: 8rem;" placeholder="Order #" value="<?php echo e(old('order_id', $orderId ?? '')); ?>">
                            <input type="email" name="email" class="form-control form-control-sm" style="min-width: 14rem;" placeholder="Customer email" value="<?php echo e(old('email', $email ?? '')); ?>">
                            <input type="date" name="date_from" class="form-control form-control-sm" value="<?php echo e(old('date_from', isset($dateFrom) && $dateFrom ? $dateFrom->toDateString() : '')); ?>">
                            <input type="date" name="date_to" class="form-control form-control-sm" value="<?php echo e(old('date_to', isset($dateTo) && $dateTo ? $dateTo->toDateString() : '')); ?>">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-sm btn-outline-light">Apply</button>
                                <a href="<?php echo e(route('admin.dashboard', array_filter(request()->except(['order_id', 'email', 'date_from', 'date_to'])))); ?>" class="btn btn-sm btn-outline-secondary">Clear</a>
                            </div>
                        </form>

                        <div class="d-flex align-items-center justify-content-between justify-content-md-end gap-2 w-100 w-md-auto">
                            <span class="small">Filter:</span>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-light dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Status</span>
                                    <?php if(empty($status)): ?>
                                        <span class="badge text-bg-light">All</span>
                                    <?php else: ?>
                                        <span class="badge <?php echo e($status === 'delivered' ? 'text-bg-success' : ($status === 'shipped' ? 'text-bg-info' : ($status === 'confirmed' ? 'text-bg-primary' : 'text-bg-warning'))); ?>">
                                            <?php echo e(ucfirst($status)); ?>

                                        </span>
                                    <?php endif; ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item <?php echo e(empty($status) ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', request()->except('status'))); ?>">All</a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item <?php echo e($status === 'pending' ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', array_merge(request()->except('status'), ['status' => 'pending']))); ?>">Pending</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item <?php echo e($status === 'confirmed' ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', array_merge(request()->except('status'), ['status' => 'confirmed']))); ?>">Confirmed</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item <?php echo e($status === 'shipped' ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', array_merge(request()->except('status'), ['status' => 'shipped']))); ?>">Shipped</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item <?php echo e($status === 'delivered' ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', array_merge(request()->except('status'), ['status' => 'delivered']))); ?>">Delivered</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-light dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Payment</span>
                                    <?php if(empty($paymentStatus)): ?>
                                        <span class="badge text-bg-light">All</span>
                                    <?php else: ?>
                                        <span class="badge <?php echo e($paymentStatus === 'paid' ? 'text-bg-success' : (($paymentStatus === 'failed') ? 'text-bg-danger' : (($paymentStatus === 'cancelled') ? 'text-bg-dark' : 'text-bg-secondary'))); ?>">
                                            <?php echo e(strtoupper($paymentStatus)); ?>

                                        </span>
                                    <?php endif; ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item <?php echo e(empty($paymentStatus) ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', request()->except('payment_status'))); ?>">All</a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item <?php echo e($paymentStatus === 'unpaid' ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', array_merge(request()->except('payment_status'), ['payment_status' => 'unpaid']))); ?>">Unpaid</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item <?php echo e($paymentStatus === 'pending' ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', array_merge(request()->except('payment_status'), ['payment_status' => 'pending']))); ?>">Pending</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item <?php echo e($paymentStatus === 'paid' ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', array_merge(request()->except('payment_status'), ['payment_status' => 'paid']))); ?>">Paid</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item <?php echo e($paymentStatus === 'failed' ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', array_merge(request()->except('payment_status'), ['payment_status' => 'failed']))); ?>">Failed</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item <?php echo e($paymentStatus === 'cancelled' ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard', array_merge(request()->except('payment_status'), ['payment_status' => 'cancelled']))); ?>">Cancelled</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($orders->isEmpty()): ?>
                        <p class="text-center text-muted py-4 mb-0">No orders yet</p>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-3">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border border-secondary-subtle rounded p-3">
                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-2 gap-2">
                                        <div>
                                            <p class="fw-semibold mb-1 small-md-base">Order #<?php echo e($order->id); ?></p>
                                            <p class="small text-muted mb-0">
                                                <?php echo e($order->created_at->format('M d, Y')); ?> - <?php echo e($order->shipping_info['full_name'] ?? 'N/A'); ?>

                                            </p>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 w-100 w-sm-auto">
                                            <span class="fw-bold small-md-base">$<?php echo e(number_format($order->total, 2)); ?></span>
                                            <span class="badge <?php echo e($order->status === 'delivered' ? 'text-bg-success' : ($order->status === 'shipped' ? 'text-bg-info' : ($order->status === 'confirmed' ? 'text-bg-primary' : 'text-bg-warning'))); ?>">
                                                <?php echo e(ucfirst($order->status)); ?>

                                            </span>
                                            <span class="badge <?php echo e(($order->payment_status ?? 'unpaid') === 'paid' ? 'text-bg-success' : ((($order->payment_status ?? 'unpaid') === 'failed') ? 'text-bg-danger' : ((($order->payment_status ?? 'unpaid') === 'cancelled') ? 'text-bg-dark' : 'text-bg-secondary'))); ?>">
                                                <?php echo e(strtoupper($order->payment_status ?? 'unpaid')); ?>

                                            </span>
                                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-outline-secondary w-100 w-sm-auto">View</a>
                                            <form action="<?php echo e(route('admin.orders.update', $order->id)); ?>" method="POST" class="d-inline w-100 w-sm-auto">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <select name="status" 
                                                        class="form-select form-select-sm w-100 w-sm-auto" 
                                                        onchange="this.form.submit()">
                                                    <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                                    <option value="confirmed" <?php echo e($order->status === 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                                                    <option value="shipped" <?php echo e($order->status === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                                                    <option value="delivered" <?php echo e($order->status === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <p class="small text-muted mb-0">
                                                <?php echo e($item->product->name ?? 'Product'); ?> x <?php echo e($item->quantity); ?> - Size <?php echo e($item->size); ?> (<?php echo e($item->color); ?>)
                                            </p>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Products Tab -->
        <div class="tab-pane fade" id="products" role="tabpanel">
            <div class="card">
                <div class="card-header bg-dark text-white p-3 p-md-4 d-flex align-items-center justify-content-between">
                    <h3 class="h6 h5-md fw-semibold mb-0">Products Inventory</h3>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-sm btn-outline-light">Manage</a>
                        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-sm btn-success">Add</a>
                    </div>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex flex-column gap-3">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between border rounded p-3 gap-3">
                                <div class="d-flex align-items-center gap-2 gap-md-3 w-100 w-sm-auto">
                                    <img src="<?php echo e(($product->images[0] ?? '/images/placeholder.jpg')); ?>" 
                                         alt="<?php echo e($product->name); ?>"
                                         class="rounded flex-shrink-0"
                                         style="width: 3rem; height: 3rem; min-width: 3rem; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <p class="fw-semibold mb-0 small-md-base"><?php echo e($product->name); ?></p>
                                        <p class="small text-muted mb-0">
                                            <?php echo e($product->brand); ?> - <?php echo e($product->category); ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between justify-content-sm-end gap-2 w-100 w-sm-auto">
                                    <div class="text-start text-sm-end">
                                        <p class="fw-semibold mb-0 small-md-base">$<?php echo e(number_format($product->price, 2)); ?></p>
                                        <p class="small text-muted mb-0">Stock: <?php echo e($product->stock); ?></p>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge <?php echo e($product->stock === 0 ? 'text-bg-danger' : ($product->stock < 10 ? 'text-bg-warning' : 'text-bg-success')); ?>">
                                            <?php echo e($product->stock === 0 ? 'Out of Stock' : ($product->stock < 10 ? 'Low Stock' : 'In Stock')); ?>

                                        </span>
                                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/pages/admin/dashboard.blade.php ENDPATH**/ ?>