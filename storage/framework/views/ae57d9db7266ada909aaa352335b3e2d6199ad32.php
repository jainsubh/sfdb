<?php if(count($institution_report) > 0): ?>
    <?php $__currentLoopData = @$institution_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="ireports-item ireports_<?php echo e($report['institution_report']); ?>" id="institution_report_<?php echo e($report['id']); ?>">
        <div class="item-download">
            <a href="<?php echo e(route('institution_report.download',$report['institution_report'])); ?>" class="download_pdf">
                <i class="fa fa-download" aria-hidden="true"></i>
            </a>
        <div id="icon_<?php echo e($report['institution_report']); ?>">
            <?php if($report['send_library']): ?>
            <a href="javascript:void(0)"><i class="fa fa-book" aria-hidden="true"></i></a>
            <?php endif; ?>
        </div> 
        </div>
        <p><?php echo e(Str::limit(urldecode($report['name']), 28)); ?></p>
        <p>Ref ID: <?php echo e($report['institution_report']); ?></p>
        <p class="date red"><?php echo e(\Carbon\Carbon::parse($report['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll')); ?></p>
        <p class ="assign blue">
            <?php if(auth()->user()->hasRole('Analyst')): ?>
            <a href="javascript:void(0)" onclick="assign_institution_report('<?php echo e($report['id']); ?>', '<?php echo e($report['institution_report']); ?>')">Self Assign</a>
            <?php else: ?>
            <a href="javascript:void(0)" class="assign_to" onclick="assign_report_form('<?php echo e($report['id']); ?>', '<?php echo e($report['institution_report']); ?>')">  Assign to </a>
            <?php endif; ?>
            |
            <a href="javascript:void(0)" onclick="archive('<?php echo e($report['id']); ?>', '<?php echo e($report['institution_report']); ?>')">Archive</a> 
            <?php if(!$report['send_library']): ?>
                <span id="library_<?php echo e($report['institution_report']); ?>">  | <a href="javascript:void(0)" class="send_to_library" onclick="send_to_library('<?php echo e($report['id']); ?>', '<?php echo e($report['institution_report']); ?>')">Send to Library</a> </span>
            <?php endif; ?>
        </p>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
    <?php if(isset($with_pagination) && $with_pagination == 1): ?>
        <?php echo e($institution_report->links('pagination.ireport')); ?>

    <?php endif; ?>
<?php endif; ?><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/institution_reports/institutional_report_card.blade.php ENDPATH**/ ?>