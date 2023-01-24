<section id="alert" class="row">
    <div class="col-12 col-xs-12">
        <div class="alert-holder">
        <div class="alert-txt">
            <h2>ALERTS</h2>
        </div>
        <div class="module-alert">
            <div class="tickerwrapper">
            <ul class='list'>
            <?php if(isset($alert)): ?>
                <li class='listitem'><?php echo e($alert->title); ?></li>
            <?php elseif(isset($alerts)): ?>
                <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class='listitem'><?php echo e($alert->title); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <li class='listitem'></li>
            <?php endif; ?>
            </ul>
            </div>
        </div>
        </div>
    </div>
</section><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/layouts/includes/alert-navigation.blade.php ENDPATH**/ ?>