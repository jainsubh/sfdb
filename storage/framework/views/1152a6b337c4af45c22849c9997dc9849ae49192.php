<li class="nav-item">
    <?php $__currentLoopData = $datasets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dataset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="nav-item">
        <a class="<?php echo e((strpos(Route::currentRouteName(), 'dataset') === 0 && in_array($dataset->id, Route::current()->parameters())) ? 'open' : ''); ?>" href="<?php echo e(route('dataset.show', $dataset->id)); ?>">
            <em class="nav-icon fas fa-database"></em>
            <span class="item-name"><?php echo e($dataset->name); ?></span>
        </a>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</li><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/components/datanav.blade.php ENDPATH**/ ?>