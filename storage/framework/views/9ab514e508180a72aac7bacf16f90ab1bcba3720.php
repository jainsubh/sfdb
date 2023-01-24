<form method="post" action="<?php echo e(route('sectors.changeSector', $sector->id)); ?>" enctype="multipart/form-data">
    <?php echo e(csrf_field()); ?>

    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="crudFormLabel">Sector</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <!-- name Form Input -->
            <div class="form-group">
                There are <strong><?php echo e($sector->alerts->count()); ?> alerts</strong> and <strong><?php echo e($sector->freeform_reports->count()); ?> freeform reports</strong> found using this sector. </b>
            </div>
            <div class="form-group">
                <?php echo e(Form::label('sectors','Reassign another Sector to alerts or freeform reports')); ?>

                <?php echo e(Form::select('sector_id', $sectors, $sector->id , ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select Sector'])); ?>

                <?php echo e(Form::hidden('old_sector_id', $sector->id, array('id' => 'old_sector_id'))); ?>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <!-- Submit Form Button -->
            <?php echo Form::button('Reassign and Delete', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']); ?>

        </div>
    </div>
<?php echo Form::close(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/sectors/hasData.blade.php ENDPATH**/ ?>