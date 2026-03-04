

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-3 px-md-4 d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 200px); padding-top: var(--spacing-xl); padding-bottom: var(--spacing-xl);">
    <div class="card w-100" style="max-width: 28rem;">
        <div class="card-header text-center">
            <h2 class="h4 h3-md fw-bold mb-0">Welcome to Footsy</h2>
        </div>
        <div class="card-body p-3 p-md-4">
            <ul class="nav nav-tabs mb-4" id="authTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" 
                            id="login-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#login" 
                            type="button" 
                            role="tab">
                        Login
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" 
                            id="register-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#register" 
                            type="button" 
                            role="tab">
                        Register
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="authTabsContent">
                <!-- Login Tab -->
                <div class="tab-pane fade show active" id="login" role="tabpanel">
                    <form action="<?php echo e(route('login')); ?>" method="POST" class="d-flex flex-column gap-3">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label for="login-email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="login-email" 
                                   name="email"
                                   placeholder="your@email.com"
                                   value="<?php echo e(old('email')); ?>"
                                   required
                                   style="background-color: var(--color-input-background);">
                        </div>
                        <div>
                            <label for="login-password" class="form-label">Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="login-password" 
                                   name="password"
                                   placeholder="••••••••"
                                   required
                                   style="background-color: var(--color-input-background);">
                        </div>
                        <button type="submit" 
                                class="btn btn-success w-100"
                                style="background-color: var(--color-success); border-color: var(--color-success);">
                            Login
                        </button>

                        <a href="<?php echo e(route('password.forgot')); ?>" class="text-center small text-decoration-none">Forgot password?</a>
                    </form>
                    <div class="mt-4 rounded p-3 small" style="background-color: var(--color-gray-50);">
                        <p class="fw-medium mb-1">Demo Accounts:</p>
                        <p class="mb-0">Admin: admin@footsy.com / admin123</p>
                    </div>
                </div>

                <!-- Register Tab -->
                <div class="tab-pane fade" id="register" role="tabpanel">
                    <form action="<?php echo e(route('register')); ?>" method="POST" class="d-flex flex-column gap-3">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label for="register-name" class="form-label">Full Name</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="register-name" 
                                   name="name"
                                   placeholder="John Doe"
                                   value="<?php echo e(old('name')); ?>"
                                   required
                                   style="background-color: var(--color-input-background);">
                        </div>
                        <div>
                            <label for="register-email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="register-email" 
                                   name="email"
                                   placeholder="your@email.com"
                                   value="<?php echo e(old('email')); ?>"
                                   required
                                   style="background-color: var(--color-input-background);">
                        </div>
                        <div>
                            <label for="register-password" class="form-label">Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="register-password" 
                                   name="password"
                                   placeholder="••••••••"
                                   required
                                   minlength="6"
                                   style="background-color: var(--color-input-background);">
                        </div>
                        <div>
                            <label for="register-confirm" class="form-label">Confirm Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="register-confirm" 
                                   name="password_confirmation"
                                   placeholder="••••••••"
                                   required
                                   style="background-color: var(--color-input-background);">
                        </div>
                        <button type="submit" 
                                class="btn btn-success w-100"
                                style="background-color: var(--color-success); border-color: var(--color-success);">
                            Create Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/pages/auth/login.blade.php ENDPATH**/ ?>