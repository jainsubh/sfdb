<?php if(auth()->check() && auth()->user()->hasRole('Manager')): ?>
    <?php if($activities): ?>
        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="notification-item">
            <p>
                <a href="javascript:void(0)" onclick="show_alert('<?php echo e($activity->subject->subject_id); ?>', '<?php echo e($activity->subject->subject_type); ?>')">
                    <?php if($activity->description == 'assign'): ?>
                        Task has been assigned
                    <?php elseif($activity->description == 'self_assign'): ?>
                        Task has been self assigned
                    <?php elseif($activity->description == 'transfer_request'): ?>
                        Task transfer request
                    <?php elseif($activity->description == 'completed'): ?>
                        Task completed
                    <?php elseif($activity->description == 'transfered'): ?>
                        Task has been transfered
                    <?php elseif($activity->description == 'reopen'): ?>
                        Task open for review again
                    <?php endif; ?>
                </a>
            </p>
            <p class="date red">
            <?php if($activity->description != 'completed'): ?>
                Due Date - <?php echo e(\Carbon\Carbon::parse($activity->subject->due_date)->isoFormat('ll')); ?>

            <?php else: ?>
                Complete Date - <?php echo e(\Carbon\Carbon::parse($activity->updated_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('ll')); ?>

            <?php endif; ?>
            </p>
            <p class="assign blue">
            <?php if($activity->description == 'completed'): ?>
                Completed By : <?php echo e($activity->causer->name); ?>

            <?php else: ?>
                Assigned To : <?php echo e($activity->getExtraProperty('assigned_to_name')); ?>

            <?php endif; ?>
            </p>
            <p class="person <?php echo e($activity->subject->priority); ?>">
            Priority: <?php echo e(ucfirst($activity->subject->priority)); ?>

            </p>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php endif; ?>

<?php if(auth()->check() && auth()->user()->hasRole('Analyst')): ?>
    <?php if($activities): ?>
        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="myalerts-item">
            <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <?php if($activity->subject->latest_task_log->assigned_to == auth()->user()->id && $activity->description != 'transfer_request'): ?>
                    <a href="javascript:void(0)" onclick="show_alert('<?php echo e($activity->subject->subject_id); ?>', '<?php echo e($activity->subject->subject_type); ?>')">
                <?php else: ?>
                    <span style="color: #bbb4b4">
                <?php endif; ?>
                    <?php if($activity->description == 'assign' || $activity->description == 'transfered'): ?>
                        Task has been assigned
                    <?php elseif($activity->description == 'self_assign'): ?>
                        Task has been self assigned
                    <?php elseif($activity->description == 'transfer_request'): ?>
                        Task transfer requested to manager
                    <?php elseif($activity->description == 'completed'): ?>
                        Task completed
                    <?php elseif($activity->description == 'reopen'): ?>
                        Task open for review again
                    <?php endif; ?>
                <?php if($activity->subject->latest_task_log->assigned_to == auth()->user()->id && $activity->description != 'transfer_request'): ?>
                    </a>
                <?php else: ?>
                    </span>
                <?php endif; ?>
            </p>
            <p class="date red">
            <?php if($activity->description != 'completed'): ?>
                Due Date - <?php echo e(\Carbon\Carbon::parse($activity->subject->due_date)->isoFormat('ll')); ?>

            <?php else: ?>
                Complete Date - <?php echo e(\Carbon\Carbon::parse($activity->updated_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('ll')); ?>

            <?php endif; ?>
            </p>
            <p class="assign blue">
            <?php if($activity->description == 'completed'): ?>
            <?php elseif($activity->description == 'self_assign'): ?>
            <?php else: ?>
                Assigned By : <?php echo e($activity->causer->name); ?>

            <?php endif; ?>
            </p>
            <p class="person <?php echo e($activity->subject->priority); ?>">
            Priority: <?php echo e(ucfirst($activity->subject->priority)); ?>

            </p>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php endif; ?><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/activity/show.blade.php ENDPATH**/ ?>