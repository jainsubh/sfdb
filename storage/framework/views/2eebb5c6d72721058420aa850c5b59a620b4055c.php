<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <?php if(count($tasks_completed) > 0): ?>
        <?php $__currentLoopData = $tasks_completed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($task->semi_automatic && $task->semi_automatic->status == 'complete'): ?>
            <item>
                <guid><?php echo e($task->semi_automatic->ref_id); ?></guid>
                <title><?php echo e($task->subject->title); ?>></title>
                <link><?php echo e(route('semi_automatic.download', $task->semi_automatic->ref_id)); ?></link>
                <createdBy><?php echo e($task->completed_by_user->name); ?></createdBy>
                <pubDate><?php echo e($task->completed_at->toRssString()); ?></pubDate>
            </item>
            <?php endif; ?>
            <?php if($task->fully_manual && $task->fully_manual->status == 'complete'): ?>
            <item>
                <guid><?php echo e($task->fully_manual->ref_id); ?></guid>
                <title><?php echo e($task->fully_manual->title); ?>></title>
                <link><?php echo e(route('fully_manual.download', $task->fully_manual->ref_id)); ?></link>
                <createdBy><?php echo e($task->completed_by_user->name); ?></createdBy>
                <pubDate><?php echo e($task->completed_at->toRssString()); ?></pubDate>
            </item>
            <?php endif; ?>
            <?php if($task->subject_type == 'freeform_report' && $task->subject->status == 'complete'): ?>
            <item>
                <guid><?php echo e($task->subject->ref_id); ?></guid>
                <title><?php echo e($task->subject->title); ?>></title>
                <link><?php echo e(route('freeform_report.download', $task->subject->ref_id)); ?></link>
                <createdBy><?php echo e($task->completed_by_user->name); ?></createdBy>
                <pubDate><?php echo e($task->completed_at->toRssString()); ?></pubDate>
            </item>
            <?php endif; ?>
            <?php if($task->product && $task->product->status == 'complete'): ?>
            <item>
                <guid><?php echo e($task->product->ref_id); ?></guid>
                <title><?php echo e($task->product->title); ?>></title>
                <link><?php echo e(route('product.download', $task->product->ref_id)); ?></link>
                <createdBy><?php echo e($task->completed_by_user->name); ?></createdBy>
                <pubDate><?php echo e($task->completed_at->toRssString()); ?></pubDate>
            </item>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</rss><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/feed.blade.php ENDPATH**/ ?>