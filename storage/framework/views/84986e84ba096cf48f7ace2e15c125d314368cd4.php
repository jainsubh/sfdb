<style>
    .input-group-text{
        margin-top: 6px;
        padding: .38rem .75rem;
    }
    .ui-autocomplete{
        z-index:9999;
    }
 </style>
<form method="post" action="<?php echo e(route('institution_report.update', $institution_report->id)); ?>" enctype="multipart/form-data">
    <?php echo method_field('put'); ?>
    <?php echo e(csrf_field()); ?>

    <div class="modal-header">
    <h4 class="modal-title" id="crudFormLabel">Institution Report</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <div class="form-group <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
            <?php echo Form::label('name', 'Name/Title'); ?>

            <?php echo Form::text('name',  $institution_report->name, ['class' => 'form-control', 'placeholder' => 'Name/Title for report', 'required']); ?>

            <?php if($errors->has('name')): ?> <p class="help-block"><?php echo e($errors->first('name')); ?></p> <?php endif; ?>

            <div class="ui-widget">
                <?php echo Form::label('institute_name', 'Organization Name'); ?>

                <?php echo Form::text('institute_name', $institution_report->institution_name[$institution_report->institute_id] , ['class' => 'form-control','placeholder'=> 'Select organisation name','required']); ?>

                <?php if($errors->has('institute_name')): ?> <p class="help-block"><?php echo e($errors->first('institute_name')); ?></p> <?php endif; ?>
                <?php echo Form::hidden('institute_id', $institution_report->institute_id, ['id' => 'institute_id']); ?>

            </div>

            <?php echo Form::label('date_time', 'Select Date Time'); ?>

            <?php echo Form::text('date_time', $institution_report->date_time, ['class' => 'date form-control','autocomplete' => 'off','style' => 'margin-bottom:15px', 'placeholder' => 'Select Date and Time', 'required']); ?>

            <?php if($errors->has('date_time')): ?> <p class="help-block"><?php echo e($errors->first('date_time')); ?></p> <?php endif; ?>

            <div class="input-group my-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="custom-file">
                    <?php echo Form::hidden('hidden_report', $institution_report->institution_report); ?>

                    <?php echo Form::file('institution_report', ['class' => 'custom-file-input', 'id' => 'inputGroupFile01', 'aria-describedby' => "inputGroupFileAddon01"]); ?>

                    <?php echo Form::label('inputGroupFile01', $institution_report->institution_report , ['class'=>'custom-file-label']); ?>

                </div>
            </div>
            <p style="color:red">File should be only in pdf format, max size allowed 50MB</p>
            <?php if($errors->has('institution_report')): ?> <p class="help-block"><?php echo e($errors->first('institution_report')); ?></p> <?php endif; ?>
            
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!-- Submit Form Button -->
        <?php echo Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']); ?>

    </div>
</form>

<script type="text/javascript">
    $(function() {
        var organisation_name = <?php echo $organisation_name ?>;
        
        $("input[id$=institute_name]").autocomplete({
            source: organisation_name,
            success: function( data ) {
                response( 
                    $.map( data.d, function( item ) {
                        return {
                            label: item.label, 
                            value: item.value
                        }
                    }
                ));
            },
            select: function(event, ui) {
                event.preventDefault();
                $("#institute_name").val(ui.item.label);
                $("#institute_id").val(ui.item.value);  
            },
        });
    }); 
</script>
<?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/institution_report/edit.blade.php ENDPATH**/ ?>