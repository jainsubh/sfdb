<?php if(count($events) > 0): ?>
<?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-12 col-xs-12" id="event_<?php echo e($event->id); ?>" style="curson:pointer; margin-bottom:10px; padding: 3px 0px 5px 14px;" onclick="show_alert('<?php echo e($event->id); ?>', 'events')">
        <div class="myreports-item">
        <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            <?php echo e(Str::limit($event->name, 80)); ?>

        </p>
        <p class="person blue">Sector name: <?php echo e(($event->sectors?Str::limit($event->sectors->name, 27):'')); ?></p>
        <p class="person blue">Created By: <?php echo e(($event->created_by_user?$event->created_by_user->name:'')); ?></p>
        <p class="date red">Event Start date : <?php echo e(\Carbon\Carbon::parse($event->created_at)->isoFormat('ll')); ?></p>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/events/event_card.blade.php ENDPATH**/ ?>