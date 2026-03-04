

<?php $__env->startSection('content'); ?>
<div class="container px-4 py-4">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h1 class="display-6 fw-bold mb-2"><?php echo e($pageTitle ?? 'All Products'); ?></h1>
            <p class="text-muted"><?php echo e($products->count()); ?> products found</p>
        </div>
        <!-- Mobile Filter Button -->
        <button class="btn btn-outline-primary d-lg-none" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#filterSidebar">
            <i class="bi bi-funnel me-2"></i>
            Filters
        </button>
    </div>

        <div class="row">
            <!-- Desktop Filters -->
            <aside class="col-lg-3 d-none d-lg-block">
                <div class="sticky-top" style="top: calc(var(--spacing-xl) + 1rem);">
                    <h2 class="h5 fw-semibold mb-4">Filters</h2>
                    <?php echo $__env->make('pages.shop.partials.filters', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <?php if($products->count() > 0): ?>
                    <div class="row g-4">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6 col-sm-6 col-lg-4">
                                <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <!-- Pagination -->
                    <div class="mt-4">
                        <?php echo e($products->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <p class="lead text-muted">No products found matching your criteria.</p>
                        <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-primary mt-3">
                            Clear Filters
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
</div>

<!-- Mobile Filter Sidebar -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="filterSidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Filters</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <?php echo $__env->make('pages.shop.partials.filters', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/pages/shop/index.blade.php ENDPATH**/ ?>