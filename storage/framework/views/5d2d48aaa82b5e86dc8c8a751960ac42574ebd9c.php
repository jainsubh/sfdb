<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
            <a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icon-right-<?= $count; ?>" aria-expanded="false">
                <?php echo e($title); ?>

                <?php echo isset($user) ? '<span class="text-danger">(' . $user->getDirectPermissions()->count() . ')</span>' : ''; ?>

            </a>
        </h6>
    </div>
    <div class="collapse" id="accordion-item-icon-right-<?= $count; ?>" data-parent="#accordionRightIcon">
        <div class="card-body">

            <div class="row">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $per_found = null;

                        if( isset($role) ) {
                            $per_found = $role->hasPermissionTo($perm->name);
                        }

                        if( isset($user)) {
                            //$per_found = $user->hasDirectPermission($perm->name);
                        }
                    ?>
                    
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label class="checkbox checkbox-primary">
                                <?php echo Form::checkbox("permissions[]", $perm->name, $per_found, isset($options) ? $options : []); ?> <span><?php echo e($perm->name); ?></span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
                <div class="col-md-12">
                    <?php if($role->name !== 'Admin'): ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_roles')): ?>
                        <?php echo Form::button('Save Permissions', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button', 'data-style' => 'expand-right','style' => 'margin-left:2em']); ?>

                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            </div>
            
        </div>
    </div>
</div>
<?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/roles/permission.blade.php ENDPATH**/ ?>