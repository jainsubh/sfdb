<?php if(count($tasks)>0): ?>
    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($task->subject != null): ?>
            <tr>
                <td>
                    <?php if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report'): ?>
                    <?php echo e(Str::limit($task->subject->title, 65)); ?>

                    <?php else: ?>
                    <?php echo e(Str::limit($task->subject->name, 65)); ?>

                    <?php endif; ?>
                </td>
            <?php if(auth()->check() && auth()->user()->hasRole('Manager|Supervisor')): ?>
                <td><?php echo e((isset($task->latest_task_log)? ucfirst($task->latest_task_log->assigned_to_user->name): '' )); ?></td>
            <?php endif; ?>
                <td><?php echo e(ucfirst($task->status)); ?></td>
                <?php if($task->priority === 'high'): ?>
                    <?php $color = 'red' ?>
                <?php elseif($task->priority === 'medium'): ?>
                    <?php $color = 'yellow' ?>
                <?php else: ?>
                    <?php $color = 'green' ?>
                <?php endif; ?>
                <td style="font-weight:bold; color:<?php echo e($color); ?>"><?php echo e(ucfirst($task->priority)); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($task->created_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll')); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($task->due_date)->isoFormat('ll')); ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <tr>
        <td colspan="6">
            <h5 style="margin-top: 20px; color:#28adfb; text-align:center">No tasks assigned yet.</h5>
        </td>
    </tr>
<?php endif; ?>   
<?php /**PATH /Volumes/Data/sfdbd_new/resources/views/tasks/task_reminder.blade.php ENDPATH**/ ?>