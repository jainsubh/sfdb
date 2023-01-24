<?php if(count($tasks_completed) > 0): ?>
<?php $__currentLoopData = $tasks_completed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="col-6 col-sm-12 col-xs-12"  style="cursor:pointer" id="<?php echo e($task->subject_type.'_'.$task->subject_id); ?>" onclick="show_alert('<?php echo e($task->subject_id); ?>', '<?php echo e($task->subject_type); ?>')">
    <div class="myreports-item">
        <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            <?php if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report'): ?>
            <?php echo e(Str::limit($task->subject->title, 80)); ?>

            <?php else: ?>
            <?php echo e(Str::limit($task->subject->name, 80)); ?>

            <?php endif; ?>
        </p>
        <p class="date red">Completed Date : <?php echo e(\Carbon\Carbon::parse($task->completed_at, 'UTC')->setTimezone(auth()->user()->timezone)->isoFormat('lll')); ?></p>
        <?php if(auth()->check() && auth()->user()->hasRole('Manager')): ?>
            <p class="person blue">Completed By: <?php echo e($task->completed_by_user->name); ?></p>
        <?php endif; ?>
        <p class="person blue">
            <?php if($task->semi_automatic && $task->semi_automatic->status == 'complete'): ?>
            <a href="<?php echo e(route('semi_automatic.download', $task->semi_automatic->ref_id)); ?>">
                Semi Automatic &nbsp;<i class="fa fa-download" aria-hidden="true"></i>  &nbsp;&nbsp; 
            </a>
            <?php endif; ?>
            <?php if($task->fully_manual && $task->fully_manual->status == 'complete'): ?>
            <a href="<?php echo e(route('fully_manual.download', $task->fully_manual->ref_id)); ?>">
                Fully Manual Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
            </a>
            <?php endif; ?>
            <?php if($task->product && $task->product->status == 'complete'): ?>
            <a href="<?php echo e(route('product.download', $task->product->ref_id)); ?>">
                Product Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
            </a>
            <?php endif; ?>
            <?php if($task->subject_type == 'freeform_report' && $task->subject->status == 'complete'): ?>
            <a href="<?php echo e(route('freeform_report.download', $task->subject->ref_id)); ?>">
                Free Form Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
            </a>
            <?php endif; ?>
        </p>
        <?php /*
        <div class="item-download">
            <a href="{{ route('manager.download', $task->semi_automatic->ref_id) }}">
                <i class="fa fa-download" aria-hidden="true"></i>
            </a>
        </div>
        */ ?>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/tasks/team_report_card.blade.php ENDPATH**/ ?>