<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e(env('APP_NAME')); ?></title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/styles/css/themes/lite-purple.min.css')); ?>">
    <style>
        .logo{
            font-size: 40px; 
            font-family: sans-serif; 
            font-weight: 700; 
            color: #003473;
            }
        .auth-content{
            min-width: 350px !important;
        }
        body{ overflow: hidden; }
        #video{
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
        }
    </style>
</head>

<body>
    <video id="video" oncontextmenu="return false;" autoplay loop muted>   
        <source src="<?php echo e(asset('assets/images/SFvideo.mp4')); ?>" type="video/mp4" />
        <track src="" kind="subtitles" srclang="en" label="English" />
    </video>
    <div class="auth-layout-wrap">
        <div class="auth-content">
            <div class="card o-hidden">
                   <div class="row">
                    <div class="col-md-12">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4">
                                <span class="logo"> SFCA </span>
                            </div>
                            <?php if(session('status')): ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo e(session('status')); ?>

                                </div>
                            <?php endif; ?>
                            <h1 class="mb-3 text-18">Forgot Password</h1>
                            <form method="POST" action="<?php echo e(route('password.email')); ?>">
                            <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input id="email" type="email" class="form-control form-control-rounded <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
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
                                <button type="submit" class="btn btn-info btn-block btn-rounded mt-3">Reset Password</button>
                            </form>
                            <div class="mt-3 text-center">
                                <a class="text-muted" href="<?php echo e(route('login')); ?>"><u>Sign in</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('assets/js/common-bundle-script.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>
    <script>
        var vid = document.getElementById("video");
        vid.playbackRate = 0.5;
    </script>
</body>

</html>
<?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>