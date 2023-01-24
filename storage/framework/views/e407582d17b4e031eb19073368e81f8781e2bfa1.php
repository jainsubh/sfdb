<form method="post" action="<?php echo e(route('organization_url.update', $organization_url->id)); ?>" enctype="multipart/form-data">
 <?php echo method_field('put'); ?>
    <?php echo e(csrf_field()); ?>

    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="crudFormLabel">Organization URL</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
        </div>
        <div class="modal-body">
            <!-- name Form Input -->
            <div class="form-group <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                <?php echo Form::label('name', 'Organization Name'); ?>

                <?php echo Form::text('name', $organization_url->name, ['class' => 'form-control', 'placeholder' => 'Organization Name', 'required']); ?>

                <?php if($errors->has('name')): ?> <p class="help-block"><?php echo e($errors->first('name')); ?></p> <?php endif; ?>
            </div>
            <div class="form-group <?php if($errors->has('url')): ?> has-error <?php endif; ?>">
                <?php echo Form::label('url', 'Organization Url'); ?> 
                <div class="input-group mb-3 <?php if($errors->has('url')): ?> has-error <?php endif; ?>">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="top" title="https://www.citrix.com">
                            <em class="fas fa-question-circle"></em>
                        </button>
                    </div>
                    <?php echo Form::url('url', $organization_url->url, ['class' => 'form-control', 'placeholder' => 'Eg: https://www.citrix.com/en-in', 'required']); ?>

                    <?php if($errors->has('url')): ?> <p class="help-block"><?php echo e($errors->first('url')); ?></p> <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <!-- Submit Form Button -->
            <?php echo Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']); ?>

        </div>
    </div>
<?php echo Form::close(); ?>


<?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/organization_url/edit.blade.php ENDPATH**/ ?>