<form method="post" action="<?php echo e(route('global_dictionary.update', $dictionary->id)); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>    
<?php echo method_field('put'); ?>
<div class="modal-header">
<h4 class="modal-title" id="crudFormLabel">Global Dictionary</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    
    <!-- name Form Input -->
    <div class="form-group <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
        <?php echo Form::label('keywords', 'keywords'); ?>

        <?php echo Form::text('keywords',  $dictionary->keywords, ['class' => 'form-control', 'placeholder' => 'keyword Name', 'required']); ?>

        <?php if($errors->has('keywords')): ?> <p class="help-block"><?php echo e($errors->first('keywords')); ?></p> <?php endif; ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <!-- Submit Form Button -->
    <?php echo Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']); ?>

</div>
</form><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/global_dictionary/edit.blade.php ENDPATH**/ ?>