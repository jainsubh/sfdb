<?php $__env->startSection('before-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/tags-input/bootstrap-tagsinput.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/jQuery-MultiSelect/jquery.multiselect.css')); ?>">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/calendar/datepiker.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-css'); ?>
<style>
body {
    padding: 0;
}

.bootstrap-tagsinput{
    outline: initial!important;
    background: #f8f9fa;
    border: 1px solid #ced4da;
    color: #47404f;
    display: inline-block;
    width: 100%;
    height: auto;
    padding: .375rem .75rem;
    font-size: .813rem;
    line-height: 1.5;
    color: #665c70;
    background-color: #fff;
    background-clip: padding-box;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.bootstrap-tagsinput .tag{
    margin:3px;
    padding:3px;
}
.tag span {
    background: none repeat scroll 0 0 #592d86;
    border-radius: 2px 0 0 2px;
    margin-right: 4px;
    padding: 1px 7px;
}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
   <div class="breadcrumb">
        <h1>Add Events</h1>
        <ul>
            <li><a href="<?php echo e(route('events.index')); ?>">Events</a></li>
            <li>Add</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <?php echo $__env->make('admin::layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Event Information</div>
                    <?php echo e(Form::open(array( 'method' => 'post','route' => 'events.store','files'=> true,'autocomplete'=>'off'))); ?>

                        <?php echo e(Form::hidden('created_by',auth()->user()->id, array('id' => 'created_by'))); ?>

                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <?php echo e(Form::label('name','Event Name')); ?>

                                <?php echo e(Form::text('name','', [
                                       'id'      => 'name',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter Event name',
                                       'required' => 'required'
                                    ])); ?>

                                <?php $__errorArgs = ['name'];
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
                                <?php echo e(Form::label('departments','Select Categories')); ?>

                                <!-- <?php echo e(Form::hidden('department_id','', array('id' => 'department_id'))); ?> -->
                                <!--<div class="department" id="multi"></div>-->
                                <!--<?php echo e(Form::select('department', $departments, null , ['class' => 'department form-control', 'multiple' => 'multiple', 'required' => 'required'])); ?>-->
                                <select name="department_id[]" class="department" multiple required>
                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                        <option value="<?php echo e($id); ?>" selected="selected") }}><?php echo e($department); ?></option>   
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <?php echo e(Form::label('sectors','Select Sector')); ?>

                                <?php echo e(Form::select('sector_id', $sectors, null , ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select Sector'])); ?>

                            </div>

                            <!--
                            <div class="col-md-6 form-group mb-3">
                                <?php echo e(Form::label('search_type','Select search type')); ?>

                                <?php echo e(Form::select('search_type', ['and' => 'And', 'or' => 'Or'], 'and' , ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select Search Type'])); ?>

                            </div> -->

                            <div class="col-md-6 form-group mb-3">
                                <?php echo e(Form::label('crawl_type','Select crawl type')); ?>

                                <?php echo e(Form::select('crawl_type', [0 => 'Entire Website', 1 => 'Only New Articles'], 'Select crawl type' , ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select Crawl Type'])); ?>

                            </div>

                            <!-- Use tagInput for individual keywords 'data-role'=>'tagsinput', -->
                            <div class="col-md-6 form-group mb-3">             
                                <?php echo e(Form::label('match_condition','Keywords')); ?>

                                <?php echo e(Form::textarea('match_condition','', [
                                        'id'      => 'match_condition',
                                        'class'    =>'form-control',
                                        'required' => 'required',
                                        'style' => 'height:100px'
                                    ])); ?>

                                <?php $__errorArgs = ['match_condition'];
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
                                <?php echo e(Form::label('status','Select Status')); ?>

                                <?php echo e(Form::select('status', ['active' => 'Active', 'deactive' => 'Deactive'], '' , ['class' => 'form-control', 'required' => 'required'])); ?>

                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <?php echo e(Form::label('start_date','Start Date')); ?>

                                <?php echo e(Form::text('start_date','', [
                                       'id'      => 'start_date',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter start date',
                                       'required' => 'required'
                                    ])); ?>

                                <?php $__errorArgs = ['start_date'];
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
                                <?php echo e(Form::label('end_date','End Date')); ?>

                                <?php echo e(Form::text('end_date','', [
                                       'id'      => 'end_date',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter end date'
                                    ])); ?>

                                <?php $__errorArgs = ['end_date'];
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

                            <?php if(auth()->check() && auth()->user()->hasRole('Manager|Admin|Supervisor')): ?>
                            <div class="col-md-6 form-group mb-3">
                                <?php echo e(Form::label('users','Select Assigned Analyst')); ?>

                                <!-- <?php echo e(Form::hidden('user_id','', array('id' => 'user_id'))); ?> -->
                                <!--<div class="users" id="multi"></div>-->
                                <?php echo e(Form::select('user_id[]', $users, null , ['class' => 'users form-control', 'multiple' => 'multiple', 'required' => 'required'])); ?>

                            </div>
                            <?php endif; ?>

                        <div class="col-md-12 form-group mb-3">
                            <?php echo e(Form::submit('Submit', array('class' => 'btn btn-primary ladda-button example-button m-1','data-style' => 'expand-right'))); ?>

                            <button type="button" class="btn btn-default m-1" onclick="window.location='<?php echo e(route('events.index')); ?>'">Cancel</button>
                        </div>
                            
                        </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>
<script src="<?php echo e(asset('assets/js/vendor/tags-input/bootstrap-tagsinput.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/jQuery-MultiSelect/jquery.multiselect.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/vendor/calendar/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/vendor/calendar/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/vendor/calendar/datepicker.min.js')); ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("input[id$=start_date]").datepicker({
            dateFormat:'yy-mm-dd'
        });

        $("input[id$=end_date]").datepicker({
            dateFormat:'yy-mm-dd'
        });
    });

    $(function() {
        var values = [];
        var department = <?php echo $departments ?>;
        console.log(department);
        var user = <?php echo $users ?>;

        $('.department').multiselect({
            columns  : 0,
            search   : true,
            selectAll: true,
            showCheckbox: false,
            // onOptionClick: function(element, option){
            //     console.log(element);
            //     console.log(option);
            // }
        });

        /*
        $('.department').multi_select({  
            data: department,
            selectColor:"purple",
            selectSize:"small",
            selectText:"Select Categories",
            selectedCount: 3,
            onSelect:function(values) {
                $('#department_id').val(values);
            }
        });
        */

        $('.users').multiselect({
            columns  : 0,
            search   : true,
            selectAll: true,
            showCheckbox: false,
            // onOptionClick: function(element, option){
            //     var thisOpt = $(option);
            //     console.log('The Option "'+ thisOpt.val() +'" was '+ (thisOpt.prop('checked') ? '' : 'de') +'selected');
            // }
        });

        /*
        $('.users').multi_select({  
            data: user,
            selectColor:"purple",
            selectSize:"small",
            selectText:"Select Analysts",
            selectedCount: 3,
            onSelect:function(values) {
                $('#user_id').val(values);
            }
        });
        */
    });

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/events/create.blade.php ENDPATH**/ ?>