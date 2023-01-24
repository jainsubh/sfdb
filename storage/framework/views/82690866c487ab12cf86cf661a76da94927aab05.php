<?php $__env->startSection('before-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/multiselect/multi.select.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-css'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('assets/jQuery-MultiSelect/jquery.multiselect.css')); ?>">
<style>
    body{
        padding:0;
    }
    #color-box{
        float: left;
        width: 8%;
        margin-top: 22px;
        margin-left: 10px;
        padding: 0px;
        border: 1px solid #ccc;
    }
    .ui-widget.ui-widget-content{
        z-index: 9999 !important;
    }
    .counter{
        font-size: 12px;
        position: relative;
        top: -25px;
        float: right;
        padding-right: 25px;
        display:inline-block;
    }
    .mb-2{
        margin-bottom: 0px !important;
    }
    .gallery{
        width: 150px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
   <div class="breadcrumb">
        <h1>Add Free Form Report</h1>
        <ul>
            <li><a href="<?php echo e(route('freeform_report.index')); ?>">Free Form Report</a></li>
            <li>Add</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <?php echo $__env->make('admin::layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Free Form Report Information</div>
                    <?php echo e(Form::open(array( 'method' => 'post','route' => 'freeform_report.store','autocomplete'=>'off', 'enctype'=>'multipart/form-data'))); ?>

                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-6 form-group mb-2">
                                <?php echo e(Form::label('title','Title')); ?>

                                <?php echo e(Form::text('title','', [
                                       'id'      => 'title',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter report title',
                                       'maxlength' => 90,
                                       'onkeyup' => "textCounter(this,'title_span',90)",
                                       'required' => 'required'
                                    ])); ?>


                                <span id='title_span' class="counter">90</span>

                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div class="col-md-6 form-group mb-2">
                                <?php echo e(Form::label('objective','Objective')); ?>

                                <?php echo e(Form::text('objective','', [
                                       'id'      => 'objective',
                                       'class'    =>"form-control",
                                       'maxlength' => 45,
                                       'onkeyup' => "textCounter(this,'objective_span',45)",
                                       'placeholder'=>'Enter report objective',
                                    ])); ?>


                                <span id='objective_span' class="counter">45</span>

                                <?php $__errorArgs = ['objective'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <?php if(is_array($dataset_arr)): ?>
                                <?php $__currentLoopData = $dataset_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(count($data_val['data']) > 0): ?>
                                        <?php $selector_name = "dataset[".$data_val['id']."][]"; ?>
                                        <div class="col-md-6 form-group mb-3 selector-container">
                                            <?php echo e(Form::label('dataset_id', $data_val['name'])); ?>

                                            <?php echo e(Form::select($selector_name, $data_val['data'], null, [
                                                'id'=>'dataset_'.$data_val['id'],
                                                'class'=>'form-control',
                                                'multiple'=>'multiple'
                                                ])); ?>

                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <div class="col-md-6 form-group mb-3 selector-container">
                                <?php echo e(Form::label('priority','Priority')); ?>

                                <?php echo e(Form::select('priority',['1' => 'Low', '2' => 'Medium','3' => 'High'],null, [
                                    'id'=>'priority',
                                    'placeholder'=>'Select Priority',
                                    'class'=>'form-control',
                                    'required' => 'required'
                                    ])); ?>

                                <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>  

                            <div class="col-md-6 form-group mb-3 selector-container">
                                <?php echo e(Form::label('country_id', 'Country')); ?>

                                <?php echo e(Form::select('countries[]', $countries, null, ['id'=>'country_id','class'=>'form-control', 'multiple'=>'multiple'])); ?>

                                <?php $__errorArgs = ['sector'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div class="col-md-6 form-group mb-3 selector-container">
                                <?php echo e(Form::label('sector_id','Sector')); ?>

                                <?php echo e(Form::select('sector_id',$sectors,null, ['id'=>'sector_id','placeholder'=>'Select Sector','class'=>'form-control'])); ?>

                                <?php $__errorArgs = ['sector'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 form-group mb-3 selector-container">
                                <?php echo e(Form::label('assigned','Assigned To')); ?>

                                <?php if(auth()->user()->hasRole('Analyst')): ?>
                                <?php echo e(Form::hidden('assigned', auth()->user()->id)); ?>

                                <?php echo e(Form::select('assigned',$assigned, auth()->user()->id, ['id'=>'assigned','placeholder'=>'Select User','class'=>'form-control','disabled','required' => 'required'])); ?>

                                <?php else: ?>
                                <?php echo e(Form::select('assigned',$assigned, null, ['id'=>'assigned','placeholder'=>'Select User','class'=>'form-control'])); ?>

                                <?php endif; ?>
                                <?php $__errorArgs = ['assigned'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>   

                            <div class="col-md-6 form-group mb-3">
                                <?php echo e(Form::label('datetime','Due Date')); ?>

                                <?php echo e(Form::text('datetime','', [
                                       'id'      => 'datetime',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter date & time',
                                       'required' => 'required'
                                    ])); ?>

                                <?php $__errorArgs = ['datetime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>   

                            <div class="col-md-6 form-group mb-3">
                                <?php echo e(Form::label('upload_thumbnail','Report Thumbnail')); ?>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="thumbnail_report_text">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <?php echo Form::file('thumbnail_report', ['class' => 'custom-file-input', 'id' => 'thumbnail_report', 'aria-describedby' => "thumbnail_report"]); ?>

                                        <?php echo Form::label('thumbnail_report', 'Choose a file', ['class'=>'custom-file-label']); ?>

                                    </div>
                                </div>
                                <p style="color:red">File should be only in jpg, png, jpeg format</p>
                                <?php if($errors->has('thumbnail_report')): ?> <p class="help-block"><?php echo e($errors->first('thumbnail_report')); ?></p> <?php endif; ?>
                                <div class="gallery"></div>
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <?php echo e(Form::submit('Submit', array('class' => 'btn btn-primary ladda-button example-button m-1','data-style' => 'expand-right'))); ?>

                                <button type="button" class="btn btn-default m-1" onclick="window.location='<?php echo e(route('freeform_report.index')); ?>'">Cancel</button>
                            </div>

                        </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-js'); ?>   
    <!-- Js for date time picker -->
<script src="<?php echo e(asset('assets/js/vendor/calendar/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/vendor/calendar/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/jQuery-MultiSelect/jquery.multiselect.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        // Multiple images preview in browser
        var imagesPreview = function(input, placeToInsertImagePreview) {
            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $(placeToInsertImagePreview).html($($.parseHTML('<img>')).attr('src', event.target.result).attr('style', 'width:150px'));
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };

        $('#thumbnail_report').on('change',function(){
            //get the file name
            var filename = $('input[type=file]').val().split('\\').pop();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(filename);

            imagesPreview(this, 'div.gallery');
        });

        <?php if(is_array($dataset_arr)): ?>
            <?php $__currentLoopData = $dataset_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            $('#dataset_<?php echo e($data_val['id']); ?>').multiselect({
                texts: {
                    placeholder: 'Select <?php echo e($data_val['name']); ?>'
                }
            });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        $('#country_id').multiselect({
            texts: {
                placeholder: 'Select Countries'
            }
        });

        $("input[id$=datetime]").datetimepicker({
            dateFormat:'yy-mm-dd',
            timeFormat:'HH:mm:ss'
        });
    });
    function textCounter(field,field2,maxlimit)
    {
        var countfield = document.getElementById(field2);
        if ( field.value.length > maxlimit ) {
            field.value = field.value.substring( 0, maxlimit );
            return false;
        } else {
            countfield.innerText = maxlimit - field.value.length;
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/freeform_report/create.blade.php ENDPATH**/ ?>