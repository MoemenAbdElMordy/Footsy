<?php $__env->startSection('content'); ?>
<div class="container-fluid px-3 px-md-4 d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 200px); padding-top: var(--spacing-xl); padding-bottom: var(--spacing-xl);">
    <div class="card w-100" style="max-width: 28rem;">
        <div class="card-header text-center">
            <h2 class="h5 fw-bold mb-0">Reset Password</h2>
        </div>
        <div class="card-body p-3 p-md-4">
            <form action="<?php echo e(route('password.email_code')); ?>" method="POST" class="d-flex flex-column gap-3">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>" required style="background-color: var(--color-input-background);">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" class="btn btn-success w-100" style="background-color: var(--color-success); border-color: var(--color-success);">
                    Send Reset Code
                </button>

                <a href="<?php echo e(route('login')); ?>" class="text-center small text-decoration-none">Back to login</a>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/pages/auth/forgot-password.blade.php ENDPATH**/ ?>