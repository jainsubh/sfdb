<?php if(!$alert_keyword->isEmpty()): ?>
<div class="col-7 col-xs-6">
    <div class="entities-items">
        <?php for($i = 0; $i < 8; $i++): ?>
        <p><?php echo e($alert_keyword[$i]->keyword); ?></p>
        <?php endfor; ?>
    </div>
</div>
<div class="col-5 col-xs-6">
    <div class="entities-items">
        <?php for($i = 8; $i < 16; $i++): ?>
        <p><?php echo e($alert_keyword[$i]->keyword); ?></p>
        <?php endfor; ?>
    </div>
</div>
<?php endif; ?><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/master/alert_keyword.blade.php ENDPATH**/ ?>