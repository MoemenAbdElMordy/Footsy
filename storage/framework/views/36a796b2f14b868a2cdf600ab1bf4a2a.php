<?php $__env->startSection('content'); ?>
<div class="container px-3 px-md-4 py-3 py-md-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="d-flex flex-column gap-3">
                <div class="card">
                    <div class="card-header">
                        <h1 class="h5 fw-semibold mb-0">Profile</h1>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('profile.update')); ?>" method="POST" class="d-flex flex-column gap-3">
                            <?php echo csrf_field(); ?>

                            <div>
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo e(old('name', auth()->user()->name)); ?>" required>
                                <?php $__errorArgs = ['name'];
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

                            <div>
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo e(old('email', auth()->user()->email)); ?>" required>
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

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Save Profile</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="h6 fw-semibold mb-0">Change Password</h2>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('profile.password')); ?>" method="POST" class="d-flex flex-column gap-3">
                            <?php echo csrf_field(); ?>

                            <div>
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                                <?php $__errorArgs = ['current_password'];
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

                            <div>
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" minlength="6" required>
                                <?php $__errorArgs = ['password'];
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

                            <div>
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" minlength="6" required>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-outline-success">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h2 class="h6 fw-semibold mb-0">Address Book</h2>
                        <span class="text-muted small">Used at checkout</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-3">
                            <form action="<?php echo e(route('profile.addresses.store')); ?>" method="POST" class="d-flex flex-column gap-3">
                                <?php echo csrf_field(); ?>

                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Label (optional)</label>
                                        <input type="text" name="label" class="form-control" value="<?php echo e(old('label')); ?>" placeholder="Home / Work">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="full_name" class="form-control" value="<?php echo e(old('full_name', auth()->user()->name)); ?>" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" value="<?php echo e(old('address')); ?>" required>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">City</label>
                                        <input type="text" name="city" class="form-control" value="<?php echo e(old('city')); ?>" required>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">State</label>
                                        <input type="text" name="state" class="form-control" value="<?php echo e(old('state')); ?>" required>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">ZIP</label>
                                        <input type="text" name="zip_code" class="form-control" value="<?php echo e(old('zip_code')); ?>" required>
                                    </div>
                                </div>

                                <div class="row g-3 align-items-end">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_default" value="1" id="addr_default">
                                            <label class="form-check-label" for="addr_default">Set as default</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Add Address</button>
                                </div>
                            </form>

                            <?php if(!empty($addresses) && $addresses->count()): ?>
                                <div class="d-flex flex-column gap-2">
                                    <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="border rounded p-3">
                                            <div class="d-flex align-items-start justify-content-between gap-3">
                                                <div>
                                                    <div class="fw-semibold">
                                                        <?php echo e($address->label ?: 'Address'); ?>

                                                        <?php if($address->is_default): ?>
                                                            <span class="badge text-bg-success ms-2">Default</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="small text-muted"><?php echo e($address->full_name); ?> • <?php echo e($address->phone); ?></div>
                                                    <div class="small"><?php echo e($address->address); ?>, <?php echo e($address->city); ?>, <?php echo e($address->state); ?> <?php echo e($address->zip_code); ?></div>

                                                    <details class="mt-2">
                                                        <summary class="small" style="cursor: pointer;">Edit</summary>
                                                        <form class="mt-2 d-flex flex-column gap-2" action="<?php echo e(route('profile.addresses.update', $address)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PUT'); ?>

                                                            <div class="row g-2">
                                                                <div class="col-12 col-md-6">
                                                                    <input type="text" name="label" class="form-control form-control-sm" value="<?php echo e(old('label', $address->label)); ?>" placeholder="Label">
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <input type="text" name="full_name" class="form-control form-control-sm" value="<?php echo e(old('full_name', $address->full_name)); ?>" placeholder="Full name" required>
                                                                </div>
                                                            </div>

                                                            <input type="text" name="address" class="form-control form-control-sm" value="<?php echo e(old('address', $address->address)); ?>" placeholder="Address" required>

                                                            <div class="row g-2">
                                                                <div class="col-12 col-md-4">
                                                                    <input type="text" name="city" class="form-control form-control-sm" value="<?php echo e(old('city', $address->city)); ?>" placeholder="City" required>
                                                                </div>
                                                                <div class="col-12 col-md-4">
                                                                    <input type="text" name="state" class="form-control form-control-sm" value="<?php echo e(old('state', $address->state)); ?>" placeholder="State" required>
                                                                </div>
                                                                <div class="col-12 col-md-4">
                                                                    <input type="text" name="zip_code" class="form-control form-control-sm" value="<?php echo e(old('zip_code', $address->zip_code)); ?>" placeholder="ZIP" required>
                                                                </div>
                                                            </div>

                                                            <div class="row g-2 align-items-center">
                                                                <div class="col-12 col-md-6">
                                                                    <input type="text" name="phone" class="form-control form-control-sm" value="<?php echo e(old('phone', $address->phone)); ?>" placeholder="Phone" required>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="is_default" value="1" id="addr_default_<?php echo e($address->id); ?>" <?php echo e($address->is_default ? 'checked' : ''); ?>>
                                                                        <label class="form-check-label small" for="addr_default_<?php echo e($address->id); ?>">Default</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </details>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <?php if(!$address->is_default): ?>
                                                        <form action="<?php echo e(route('profile.addresses.default', $address)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit" class="btn btn-sm btn-outline-success">Make default</button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <form action="<?php echo e(route('profile.addresses.destroy', $address)); ?>" method="POST" onsubmit="return confirm('Delete this address?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div class="text-muted small">No saved addresses yet.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/pages/profile/show.blade.php ENDPATH**/ ?>