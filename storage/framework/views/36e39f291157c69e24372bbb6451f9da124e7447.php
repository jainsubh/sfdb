<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Gull - Laravel 7 + Bootstrap 4 admin template</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(asset('assets/styles/css/themes/lite-purple.min.css')); ?>">
    </head>

    <body>
        <div class="auth-layout-wrap" style="background-image: url(<?php echo e(asset('assets/images/photo-wide-4.jpg')); ?>)">
            <div class="auth-content">
                <div class="card o-hidden">
                    <div class="row">
                        <div class="col-md-6 text-center "
                            style="background-size: cover;background-image: url(<?php echo e(asset('assets/images/photo-long-3.jpg')); ?>)">
                            <div class="pl-3 auth-right">
                                <div class="auth-logo text-center mt-4">
                                    <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="">
                                </div>
                                <div class="flex-grow-1"></div>
                                <div class="w-100 mb-4">
                                    <a class="btn btn-outline-primary btn-outline-email btn-block btn-icon-text btn-rounded"
                                        href="<?php echo e(route('login')); ?>">
                                        <em class=" i-Mail-with-At-Sign"></em> Sign in with Email
                                    </a>
                                    <a
                                        class="btn btn-outline-primary btn-outline-google btn-block btn-icon-text btn-rounded">
                                        <em class="i-Google-Plus"></em> Sign in with Google
                                    </a>
                                    <a
                                        class="btn btn-outline-primary btn-outline-facebook btn-block btn-icon-text btn-rounded">
                                        <em class="i-Facebook-2"></em> Sign in with Facebook
                                    </a>
                                </div>
                                <div class="flex-grow-1"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-4">

                                <h1 class="mb-3 text-18">Sign Up</h1>
                                <form method="POST" action="<?php echo e(route('register')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="username">Your name</label>
                                        <input id="name" type="text"
                                            class="form-control-rounded form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name"
                                            autofocus>

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
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input id="email" type="email"
                                            class="form-control-rounded form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email">

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
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input id="password" type="password"
                                            class="form-control-rounded form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="password" required autocomplete="new-password">

                                        <?php $__errorArgs = ['password'];
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
                                    <div class="form-group">
                                        <label for="repassword">Retype password</label>
                                        <input id="password-confirm" type="password"
                                            class="form-control-rounded form-control" name="password_confirmation"
                                            required autocomplete="new-password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block btn-rounded mt-3">Sign
                                        Up</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo e(asset('assets/js/common-bundle-script.js')); ?>"></script>

        <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>
    </body>

</html><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/auth/register.blade.php ENDPATH**/ ?>