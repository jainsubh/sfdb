<div class="col-6 col-sm-12 col-xs-12" id="<?php echo e($task->subject_type); ?>_<?php echo e($task->subject_id); ?>" onclick="show_alert('<?= $task->subject_id ?>','<?php echo e($task->subject_type); ?>')">
    <?php if(auth()->check() && auth()->user()->hasRole('Manager|Supervisor')): ?>
        <div class="myreports-item">
            <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <?php if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report'): ?>
                    <?php echo e(Str::limit($task->subject->title, 80)); ?>

                <?php else: ?>
                    <?php echo e(Str::limit($task->subject->name, 80)); ?>

                <?php endif; ?>
            </p>
            <p class="date red">Due Date : <?php echo e(\Carbon\Carbon::parse($task->due_date)->isoFormat('ll')); ?></p>
            <p class="person blue">Assigned Analyst: <?php echo e($task->latest_task_log->assigned_to_user->name); ?></p>
            <p class="person <?php echo e($task->priority); ?>">Priority: <?php echo e(ucfirst($task->priority)); ?></p>
        </div>
    <?php endif; ?>
    <?php if(auth()->check() && auth()->user()->hasRole('Analyst')): ?>
        <div class="myreports-item">
            <div class="sysalerts-item">
                <p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <?php if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report'): ?>
                        <?php echo e(Str::limit($task->subject->title, 80)); ?>

                    <?php else: ?>
                        <?php echo e(Str::limit($task->subject->name, 80)); ?>

                    <?php endif; ?>
                </p>
                <p class="date blue">Due Date : <?php echo e(\Carbon\Carbon::parse($task->due_date)->isoFormat('ll')); ?></p>
                <p class="person priority <?php echo e($task->priority); ?>">Priority: <?php echo e(ucfirst($task->priority)); ?></p>
            </div>
        </div>
    <?php endif; ?>
</div><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/tasks/card.blade.php ENDPATH**/ ?>