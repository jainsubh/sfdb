<style>
    .input-group-text{
        margin-top: 6px;
        padding: .38rem .75rem;
    }
    .ui-autocomplete{
        z-index:9999;
    }
 </style>
<form method="post" action="<?php echo e(route('video_report.store')); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="modal-header">
    <h4 class="modal-title" id="crudFormLabel">Video Report</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <div class="form-group <?php if($errors->has('message')): ?> has-error <?php endif; ?>">

        <!-- name Form Input -->
            <div class="form-group <?php if($errors->has('title')): ?> has-error <?php endif; ?>">
                <?php echo Form::label('title', 'Name/Title'); ?>

                <?php echo Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Name/Title for video report', 'required']); ?>

                <?php if($errors->has('title')): ?> <p class="help-block"><?php echo e($errors->first('title')); ?></p> <?php endif; ?>
            </div>
            
            <div class="form-group <?php if($errors->has('organization_name')): ?> has-error <?php endif; ?>">
                <?php echo Form::label('organization_name', 'Organization Name'); ?>

                <?php echo Form::text('organization_name', null, ['class' => 'form-control', 'placeholder' => 'Organisation Name', 'required']); ?>

                <?php if($errors->has('organization_name')): ?> <p class="help-block"><?php echo e($errors->first('organization_name')); ?></p> <?php endif; ?>
            </div>

            <div class="form-group <?php if($errors->has('organization_url')): ?> has-error <?php endif; ?>">
                <?php echo Form::label('organization_url', 'Organization Url'); ?> 
                <div class="input-group mb-3 <?php if($errors->has('organization_url')): ?> has-error <?php endif; ?>">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="top" title="https://www.citrix.com">
                            <em class="fas fa-question-circle"></em>
                        </button>
                    </div>
                    <?php echo Form::url('organization_url', null, ['class' => 'form-control', 'placeholder' => 'Eg: https://www.citrix.com/en-in']); ?>

                    <?php if($errors->has('organization_url')): ?> <p class="help-block"><?php echo e($errors->first('organization_url')); ?></p> <?php endif; ?>
                </div>
            </div>

            <div class="form-group <?php if($errors->has('comments')): ?> has-error <?php endif; ?>">
                <?php echo Form::label('comments', 'Comments'); ?>

                <?php echo Form::text('comments', null, ['class' => 'form-control', 'placeholder' => 'Enter comments', 'required']); ?>

                <?php if($errors->has('comments')): ?> <p class="help-block"><?php echo e($errors->first('comments')); ?></p> <?php endif; ?>
            </div>

            <div class="input-group my-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="custom-file">
                    <?php echo Form::file('video_report', ['class' => 'custom-file-input', 'id' => 'inputGroupFile01', 'aria-describedby' => "inputGroupFileAddon01"]); ?>

                    <?php echo Form::label('inputGroupFile01', 'Choose a file', ['class'=>'custom-file-label']); ?>

                </div>
            </div>
            <p style="color:red">File should be only a video, max size allowed 500MB</p>
            <?php if($errors->has('video_report')): ?> <p class="help-block"><?php echo e($errors->first('video_report')); ?></p> <?php endif; ?>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!-- Submit Form Button -->
        <?php echo Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button']); ?>

    </div>
</form>
<?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/video_report/create.blade.php ENDPATH**/ ?>