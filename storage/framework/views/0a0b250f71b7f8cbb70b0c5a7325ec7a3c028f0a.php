<?php $__env->startSection('before-css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
   <div class="breadcrumb">
        <h1>Roles</h1>
        <ul>
            <li><a href="<?php echo e(route('users.index')); ?>">Roles</a></li>
            <li>Add</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12">
                    
                    <!-- Modal -->
                    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
                        <div class="modal-dialog" role="document">
                            <?php echo Form::open(['method' => 'post']); ?>


                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title" id="roleModalLabel">Role</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    
                                </div>
                                <div class="modal-body">
                                    <!-- name Form Input -->
                                    <div class="form-group <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                                        <?php echo Form::label('name', 'Name'); ?>

                                        <?php echo Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Role Name']); ?>

                                        <?php if($errors->has('name')): ?> <p class="help-block"><?php echo e($errors->first('name')); ?></p> <?php endif; ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                    <!-- Submit Form Button -->
                                    <?php echo Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']); ?>

                                </div>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create_roles')): ?>
                        <a href="#" class="btn btn-primary btn-icon m-1" data-toggle="modal" data-target="#roleModal"> <em class="fas fa-plus"></em> New Role</a> <br /><br />
                    <?php endif; ?>
                    

                    <div class="accordion" id="accordionRightIcon">
                        <?php $count = 1 ?>
                        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <!-- /right control icon-->
                            <?php echo Form::model($role, ['method' => 'PUT', 'route' => ['roles.update',  $role->id ], 'class' => 'm-b']); ?>

                            
                            <?php if($role->name === 'Admin'): ?>
                                <?php echo $__env->make('admin::roles.permission', [
                                            'title' => $role->name .' Permissions',
                                            'options' => ['disable'],
                                            'count' => $count ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php else: ?>
                                <?php echo $__env->make('admin::roles.permission', [
                                            'title' => $role->name .' Permissions',
                                            'model' => $role,
                                            'count' => $count ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                            <?php ++$count; ?>
                            <?php echo Form::close(); ?>


                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p>No Roles defined.</p>
                        <?php endif; ?>
                    </div>     
                
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/roles/index.blade.php ENDPATH**/ ?>