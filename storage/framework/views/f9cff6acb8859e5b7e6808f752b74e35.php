<header class="sticky-top border-bottom bg-white shadow-sm" style="top: 0; z-index: 50;">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between px-4 py-3">
            <!-- Logo -->
            <a href="<?php echo e(route('home')); ?>" class="text-decoration-none">
                <h2 class="mb-0 fw-bold text-dark">Footsy</h2>
            </a>

            <!-- Desktop Navigation -->
            <nav class="d-none d-md-flex align-items-center gap-4">
                <a href="<?php echo e(route('home')); ?>" 
                   class="text-decoration-none <?php echo e(request()->routeIs('home') ? 'text-success' : 'text-dark'); ?>"
                   style="transition: color var(--transition-fast);">
                    Home
                </a>
                <a href="<?php echo e(route('shop.index')); ?>" 
                   class="text-decoration-none <?php echo e(request()->routeIs('shop.*') ? 'text-success' : 'text-dark'); ?>"
                   style="transition: color var(--transition-fast);">
                    Shop
                </a>
                <a href="<?php echo e(route('shop.category', 'men')); ?>" 
                   class="text-decoration-none <?php echo e(request()->routeIs('shop.category') && request()->segment(3) === 'men' ? 'text-success' : 'text-dark'); ?>"
                   style="transition: color var(--transition-fast);">
                    Men
                </a>
                <a href="<?php echo e(route('shop.category', 'women')); ?>" 
                   class="text-decoration-none <?php echo e(request()->routeIs('shop.category') && request()->segment(3) === 'women' ? 'text-success' : 'text-dark'); ?>"
                   style="transition: color var(--transition-fast);">
                    Women
                </a>
                <a href="<?php echo e(route('shop.category', 'kids')); ?>" 
                   class="text-decoration-none <?php echo e(request()->routeIs('shop.category') && request()->segment(3) === 'kids' ? 'text-success' : 'text-dark'); ?>"
                   style="transition: color var(--transition-fast);">
                    Kids
                </a>
            </nav>

            <!-- Right Actions -->
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-link text-dark p-2">
                    <i class="bi bi-search"></i>
                </a>
                
                <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-link text-dark p-2 d-flex align-items-center">
                    <i class="bi bi-cart"></i>
                    <?php if(isset($cartCount) && $cartCount > 0): ?>
                        <span class="badge rounded-pill bg-success ms-1" 
                              style="font-size: var(--font-size-xs); padding: var(--spacing-xs) var(--spacing-sm);">
                            <?php echo e($cartCount); ?>

                        </span>
                    <?php endif; ?>
                </a>

                <?php if(auth()->guard()->check()): ?>
                    <div class="dropdown">
                        <button class="btn btn-link text-dark p-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if(auth()->user()->is_admin): ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>">Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">Orders</a>
                                </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST" class="px-3 py-1">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-link p-0 text-decoration-none">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" 
                       class="btn btn-success d-none d-md-inline-flex"
                       style="background-color: var(--color-success); border-color: var(--color-success);">
                        Login
                    </a>
                <?php endif; ?>

                <!-- Mobile Menu -->
                <button class="btn btn-link text-dark p-2 d-md-none" 
                        type="button" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#mobileMenu">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="d-flex flex-column gap-3">
                <a href="<?php echo e(route('home')); ?>" class="text-decoration-none text-dark">Home</a>
                <a href="<?php echo e(route('shop.index')); ?>" class="text-decoration-none text-dark">Shop</a>
                <a href="<?php echo e(route('shop.category', 'men')); ?>" class="text-decoration-none text-dark">Men</a>
                <a href="<?php echo e(route('shop.category', 'women')); ?>" class="text-decoration-none text-dark">Women</a>
                <a href="<?php echo e(route('shop.category', 'kids')); ?>" class="text-decoration-none text-dark">Kids</a>
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-success w-100">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>

<?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/components/header.blade.php ENDPATH**/ ?>