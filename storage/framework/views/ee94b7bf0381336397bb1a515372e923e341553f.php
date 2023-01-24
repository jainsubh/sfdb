<?php $__env->startSection('before-css'); ?>
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo e(asset('assets/styles/vendor/colorpicker.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/multiselect/multi.select.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-css'); ?>
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
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
   <div class="breadcrumb">
        <h1>Add Site</h1>
        <ul>
            <li><a href="<?php echo e(route('sites.index')); ?>">Sites</a></li>
            <li>Add</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <?php echo $__env->make('admin::layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Site Information</div>
                    <?php echo e(Form::open(array( 'method' => 'post','route' => 'sites.store','files'=> true,'autocomplete'=>'off'))); ?>

                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <?php echo e(Form::label('company_name','Company Name')); ?>

                                <?php echo e(Form::text('company_name','', [
                                       'id'      => 'company_name',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter Company name',
                                       'required' => 'required'
                                    ])); ?>

                                <?php $__errorArgs = ['company_name'];
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
                                <?php echo e(Form::label('company_url','Company URL')); ?>

                                <?php echo e(Form::url('company_url','', [
                                        'id'      => 'company_url',
                                        'class'    =>"form-control",
                                        'placeholder'=>'Enter company url',
                                        'required' => 'required'
                                    ])); ?>

                                <?php $__errorArgs = ['company_url'];
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
                                <?php echo e(Form::label('crawl','Site Crawl')); ?>

                                <?php echo e(Form::select('crawl',['' => 'Select crawl','active' => 'Active', 'inactive' => 'Inactive'],'inactive', ['id'=>'Crawl','class'=>'form-control', 'required' => 'required'])); ?>

                                <?php $__errorArgs = ['crawl'];
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
                                <div style="float: left; width: 90%;">
                                    <?php echo e(Form::label('site_color','Site Color')); ?>

                                    <?php echo e(Form::text('site_color','', [
                                            'id'      => 'SiteSiteColor',
                                            'class'    =>"form-control",
                                            'placeholder'=>'Site Color',
                                            'required' => 'required'
                                        ])); ?>

                                </div>
                                <div id="color-box" >
                                    <div style="background-color: rgb(0, 0, 0); height: 32px;">&nbsp;</div>
                                </div>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <?php echo e(Form::label('site_type','Site Type')); ?>

                                <?php echo e(Form::select('site_type',['normal' => 'Normal', 'rss' => 'RSS Feed'],null, ['id'=>'Site_type','class'=>'form-control','required' => 'required'])); ?>

                                <?php $__errorArgs = ['site_type'];
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
                                <?php echo e(Form::label('crawl_interval','Crawl Interval(in mins)')); ?>

                                <?php echo e(Form::text('crawl_interval','30', [
                                        'id'      => 'crawl_interval',                                            
                                        'class'    =>"form-control",
                                        'required' => 'required'
                                    ])); ?>

                                <?php $__errorArgs = ['crawl_interval'];
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
                                <?php echo e(Form::label('crawl_depth','Crawl Depth')); ?>

                                <?php echo e(Form::select('crawl_depth',['1' => 'Glance', '2' => 'Moderate','3' => 'Deep'],null, ['id'=>'Site_type','class'=>'form-control', 'required' => 'required'])); ?>

                                <?php $__errorArgs = ['crawl_depth'];
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
                                <?php echo e(Form::label('selector','Selector')); ?>

                                <?php echo e(Form::select('selector',['id' => 'ID', 'class' => 'Class','tag' => 'Tag'],null, ['class'=>'form-control','placeholder'=> 'Select any Selector','required' => 'required'])); ?>

                            </div>

                            <div class="col-md-6 form-group mb-3 selector-container">
                                <?php echo e(Form::label('selector_value','Selector Value')); ?>

                                <?php echo e(Form::text('selector_value','', [
                                        'id'      => 'selector_value',
                                        'class'    =>"form-control",
                                        'placeholder'=>'Selector Value',
                                        'required' => 'required',
                                    ])); ?>

                            </div>
                                                         
                            <div class="col-md-6 form-group mb-3">
                            <?php echo e(Form::label('departments','Select Categories')); ?>

                                <?php echo e(Form::hidden('department_id','', array('id' => 'department_id'))); ?>

                                <div class="department" id="multi"></div>
                            </div>
                           
                            <div class="col-md-12 form-group mb-3">
                                <?php echo e(Form::submit('Submit', array('class' => 'btn btn-primary ladda-button example-button m-1','data-style' => 'expand-right'))); ?>

                                <button type="button" class="btn btn-default m-1" onclick="window.location='<?php echo e(route('sites.index')); ?>'">Cancel</button>
                            </div>
                            
                        </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/vendor/colorpicker.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>
<script type="text/javascript">
    $('#SiteSiteColor').ColorPicker({
        color: '#0000ff',
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('#color-box div').css('backgroundColor', '#' + hex);
            $('#SiteSiteColor').val('#' + hex);
        }
    });
    
    $("#Site_type").change(function() {
		var val = $(this).val();
		if(val == 'normal'){
			$('.selector-container').show();
            $('#Site_type').prop('required',true);
            $('#selector').prop('required',true);
            $('#selector_value').prop('required',true);
		}
		else if(val == 'rss'){
			$('.selector-container').hide();
            $('#Site_type').prop('required',false);
            $('#selector').prop('required',false);
            $('#selector_value').prop('required',false);            
		}
    });
</script>
<script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/vendor/multiselect/multi.select.js')); ?>"></script>

<script type="text/javascript">
    $(function() {
        var values = [];
        var myData = <?php echo $departments ?>;
        $('.department').multi_select({  
            data: myData,
            selectColor:"purple",
            selectSize:"small",
            selectText:"Select Categories",
            selectedCount: 3,
            onSelect:function(values) {
                $('#department_id').val(values);
            }

        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/sites/create.blade.php ENDPATH**/ ?>