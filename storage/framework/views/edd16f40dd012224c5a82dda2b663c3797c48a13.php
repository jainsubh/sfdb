<div class="main-header">
    <div class="logo">
        <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="">
    </div>

    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
    
    <div class="header-part-right">
        <!-- Full screen toggle -->
        <em class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></em>

        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div  class="user col align-self-end">
                <img src="<?php echo e(asset('assets/images/faces/default.png')); ?>" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <em class="i-Lock-User mr-1"></em> <?php echo e(Auth::user()->name); ?>

                    </div>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                        <?php echo e(__('Sign Out')); ?>

                    </a>

                    <form id="logout-form-header" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- header top menu end --><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/layouts/header-menu.blade.php ENDPATH**/ ?>