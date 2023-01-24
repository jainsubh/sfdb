<?php $__env->startSection('before-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/pickadate/classic.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/pickadate/classic.date.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/ladda-themeless.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
   <div class="breadcrumb">
        <h1>Edit User</h1>
        <ul>
            <li><a href="<?php echo e(route('users.index')); ?>">Users</a></li>
            <li>Edit</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <?php echo $__env->make('admin::layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">User Information</div>
                    <form method="post" action="<?php echo e(route('users.update', $user->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('Put'); ?>
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
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e($user->name); ?>" placeholder="Enter your full name" required>
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

                            <div class="col-md-6 form-group mb-3">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e($user->email); ?>" placeholder="Enter email" required disabled>
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
unset($__errorArgs, $__bag); ?>" value="<?php echo e($user->phone_no); ?>" name="phone_no" placeholder="Enter your phone number" required>
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
                                <?php echo e(Form::select('timezone', $timezones, $user->timezone, ['class'=>'form-control'])); ?>

                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="user_type">User Type</label>
                                <?php echo Form::select('roles', $roles, $currentUserRole, ['class' => 'form-control']); ?>

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


                            <div class="col-md-12">
                                <button type="submit" name="submit"  class="btn btn-primary ladda-button example-button m-1" data-style="expand-right">Submit</button>
                                <button type="button" class="btn btn-default m-1"  onclick="window.location='<?php echo e(route('users.index')); ?>'">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>
<script src="<?php echo e(asset('assets/js/vendor/spin.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/vendor/ladda.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/ladda.script.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/user/edit.blade.php ENDPATH**/ ?>