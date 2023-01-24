<section id="alert" class="row">
    <div class="col-12 col-xs-12">
        <div class="alert-holder">
            <div class="alert-txt">
                <h2>ALERTS</h2>
            </div>
            <div class="marquee-parent">
                <div class="marquee-child">
                    <div class="marquee-horz" style="width:1000px" data-speed=38 data-pauseOnHover='true' data-pauseOnCycle='true' >
                        <?php if(isset($alert)): ?>
                        <span> <?php echo e($alert->title); ?> </span>
                        <?php elseif(isset($alerts)): ?>
                            <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span><?php echo e($alert->title); ?> </span>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/layouts/includes/alert-dashboard.blade.php ENDPATH**/ ?>