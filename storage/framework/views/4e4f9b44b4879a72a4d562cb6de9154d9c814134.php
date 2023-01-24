<?php if($errors->any()): ?>
<div class="alert alert-danger" role="alert">
    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="message col-md-8"><?php echo e($error); ?></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/layouts/errors.blade.php ENDPATH**/ ?>