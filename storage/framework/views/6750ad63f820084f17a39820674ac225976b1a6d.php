<?php if(count($task_transfer) > 0): ?>
<?php $__currentLoopData = $task_transfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div id="<?php echo e($transfer->subject_type); ?>_<?php echo e($transfer->subject_id); ?>" class="col-4 col-sm-12 col-xs-12" style="cursor:pointer" onclick="show_alert('<?= $transfer->subject_id ?>', '<?= $transfer->subject_type ?>')">
    <div class="sysalerts-item myreports-item">
        <p>
            <?php if($transfer->subject_type === 'alert' || $transfer->subject_type === 'freeform_report' ||  $transfer->subject_type === 'external_report'): ?>
            <?php echo e(Str::limit($transfer->subject->title, 80)); ?>

            <?php else: ?>
            <?php echo e(Str::limit($transfer->subject->name, 80)); ?>

            <?php endif; ?>
        </p>
        <p class="date red"><?php echo e(\Carbon\Carbon::parse($transfer->due_date)->isoFormat('ll')); ?></p>
        <p class="assign blue"><a href="javascript:void(0)">Request by: <?php echo e($transfer->latest_task_log->assigned_to_user->name); ?></a></p>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/tasks/transfer_request_card.blade.php ENDPATH**/ ?>