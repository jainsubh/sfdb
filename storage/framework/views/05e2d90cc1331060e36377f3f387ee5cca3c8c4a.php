<?php if(count($alerts) > 0): ?>
<?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div id="alert_<?php echo e($alert->id); ?>" style="cursor:pointer" onclick="show_alert(<?= $alert->id ?>,'alert')" 
<?php if(auth()->user()->hasRole('Manager') || auth()->user()->hasRole('Supervisor')) {?> class="alert-items col-4 col-sm-12 col-xs-12" <?php } ?>>
    <div class="sysalerts-item">
        <p><?php echo e(Str::limit($alert->title, 70)); ?></p>
        <p class="date red"><?php echo e(\Carbon\Carbon::parse($alert->created_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll')); ?></p>
        <p class="assign blue">
            <?php if(auth()->user()->hasRole('Analyst')): ?>
            <a href="javascript:void(0)" >Self Assign</a> |
            <?php endif; ?>
            <a href="<?php echo e(route('alerts.show',''.$alert->id)); ?>" target="_blank"> Event Dashboard </a> |
            <a href="javascript:void(0)" onclick="alert_archive(<?php echo e($alert->id); ?>, event)">Archive</a>
        </p>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if(isset($with_pagination) && $with_pagination == 1): ?>
    <?php echo e($alerts->links('pagination.alert')); ?>

<?php endif; ?>
<?php endif; ?><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/alerts/alert_card.blade.php ENDPATH**/ ?>