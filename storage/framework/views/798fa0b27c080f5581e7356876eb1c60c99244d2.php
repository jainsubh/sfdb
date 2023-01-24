<?php if(count($tasks) > 0): ?>
<?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="col-6 col-sm-12 col-xs-12" id="<?php echo e($task->subject_type); ?>_<?php echo e($task->subject_id); ?>" onclick="show_alert('<?php echo e($task->subject_id); ?>','<?php echo e($task->subject_type); ?>')">
    <div class="myreports-item">
        <?php if(auth()->user()->hasRole('Analyst')): ?> <div class="sysalerts-item"> <?php endif; ?>
        <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            <?php if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report'): ?>
                <?php echo e(Str::limit($task->subject->title)); ?>

            <?php else: ?>
                <?php echo e(Str::limit($task->subject->name, 80)); ?>

            <?php endif; ?>
        </p>
        <p class="date <?= auth()->user()->hasRole('Manager')?'red':'blue' ?>">Due Date : <?php echo e(\Carbon\Carbon::parse($task->due_date)->isoFormat('ll')); ?></p>
        <?php if(auth()->user()->hasRole('Manager')): ?>
            <p class="person blue">Assigned Analyst: <?php echo e($task->latest_task_log->assigned_to_user->name); ?></p>
        <?php endif; ?>
        <p class="person <?php echo e($task->priority); ?>">Priority: <?php echo e(ucfirst($task->priority)); ?></p>
        <?php if(auth()->user()->hasRole('Analyst')): ?> </div> <?php endif; ?>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /Volumes/Data/sfdbd_new/resources/views/tasks/inprogress_card.blade.php ENDPATH**/ ?>