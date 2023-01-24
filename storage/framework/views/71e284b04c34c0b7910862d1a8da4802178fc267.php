<?php $__env->startSection('before-css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
   <div class="breadcrumb">
        <h1>Add User</h1>
        <ul>
            <li><a href="<?php echo e(route('users.index')); ?>">Users</a></li>
            <li>Add</li>
            
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <?php echo $__env->make('admin::layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">User Information</div>
                    <form method="post" action="<?php echo e(route('users.index')); ?>" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" placeholder="Enter your full name" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Form Group New Layout -->

                            <div class="col-md-6 form-group mb-3">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" placeholder="Enter email" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                           
                            <div class="col-md-6 form-group mb-3">
                                <label for="phone_no">Phone No</label>
                                <input type="tel" class="form-control <?php $__errorArgs = ['phone_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="phone_no" name="phone_no" placeholder="Enter your phone number" required>
                                <?php $__errorArgs = ['phone_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="user_timezone">User TimeZone</label>
                                <?php echo e(Form::select('timezone', $timezones, 'Asia/Dubai', ['class'=>'form-control'])); ?>

                            </div>
                            
                            <div class="col-md-6 form-group mb-3">
                                <label for="user_type">User Type</label>
                                <?php echo Form::select('roles', $roles, null, ['class' => 'form-control']); ?>

                                <?php $__errorArgs = ['user_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <button type="submit" class="btn btn-primary ladda-button example-button m-1" name="submit" data-style="expand-right">Submit</button>
                                <button type="button" class="btn btn-default m-1" onclick="window.location='<?php echo e(route('users.index')); ?>'">Cancel</button>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/user/add.blade.php ENDPATH**/ ?>