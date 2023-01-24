<form method="post" action="<?php echo e(route('sectors.store')); ?>" enctype="multipart/form-data">
    <?php echo e(csrf_field()); ?>

    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="crudFormLabel">Sector</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
        </div>
        <div class="modal-body">
            <!-- name Form Input -->
            <div class="form-group <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                <?php echo Form::label('name', 'name'); ?>

                <?php echo Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Sector Name', 'required']); ?>

                <?php if($errors->has('name')): ?> <p class="help-block"><?php echo e($errors->first('name')); ?></p> <?php endif; ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <!-- Submit Form Button -->
            <?php echo Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']); ?>

        </div>
    </div>
<?php echo Form::close(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/sectors/create.blade.php ENDPATH**/ ?>