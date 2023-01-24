<?php $__env->startSection('before-css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/smartwizard/css/smart_wizard_all.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/quill.snow.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/dropzone.min.css')); ?>" />
<style>
    body{
        padding:0;
    }
    .sw-theme-arrows{
        border: 0px;
    }
    .tab-content{
        padding:0px;
    }
    #summary-editor{
        height: 400px;
    }
    #summary{
        display: none;
    }
    #recommendation-editor{
        height: 200px;
    }
    #recommendationArea{
        display: none;
    }
    .sw-theme-arrows > .nav{
        border-bottom: 0px;
    }
    .sw.sw-justified > .nav > li, .sw.sw-justified > .nav .nav-link{
        flex-grow: 0.2;
    }
    .sw-theme-arrows > .tab-content > .tab-pane{
        padding: 0px;
    }
    .iframeWrap{
        height: 800px;
        width: 100%;
        margin: 0 auto;
    }
    #previewTemplate{
        width: 100%;
        height: 1650px;
        transform: scale(0.5);
        transform-origin: 0 0;
        display: block;
        border-style:none;
        margin: 0 auto;
    }
    form{
        width: 80%;
    }
    #multple-file-upload{
        width: 100%;
        min-height: 300px
    }
    .dropzone .dz-preview.dz-image-preview{
        background: none;
    }
    .dropzone .dz-preview .dz-image{
        border-radius: 8px;
    }
    .dropzone .dz-message{
        line-height: 200px;
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
    .quill_counter{
        font-size: 14px;
        float: left;
        color: slategrey;
        display:inline-block;
        width: 100%;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
   <div class="breadcrumb">
        <h1>Generate Report</h1>
        <ul>
            <li><a href="<?php echo e(route('alerts.index')); ?>">Tasks</a></li>
            <li>Add</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <?php echo $__env->make('admin::layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-md-12">
                <!--  SmartWizard html -->
                <div id="smartwizard">
                    <ul class="nav">
                        <li><a class="nav-link" href="#step-1">Step 1<br /><small>Key Information</small></a></li>
                        <!--<li><a class="nav-link" href="#step-2">Step 2<br /><small>Image Gallery</small></a></li>-->
                        <li><a class="nav-link" href="#step-3">Step 3<br /><small>PDF Report Generate</small></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="step-1" class="tab-pane" role="tabpanel">
                            <br />
                            <div class="row">
                                <?php echo e(Form::model(null, ['route' => ['alerts.update', ($alert->id != null? $alert->id: '')], 'method' => 'patch', 'id' => 'step1'])); ?>

                                <div class="col-md-6 form-group mb-3">             
                                    <?php echo e(Form::label('title', 'Title')); ?>

                                    <?php echo e(Form::text('title', ($alert->title != null ? $alert->title : ''), [
                                            'id'      => 'title',
                                            'class'    => 'form-control',
                                            'maxlength' => 80,
                                            'onkeyup' => "textCounter(this,'title_span',80)",
                                        ])); ?>

                                    <span id='title_span' class="counter">80</span>
                                </div>  

                                <div class="col-md-6 form-group mb-3">             
                                    <?php echo e(Form::label('objective', 'Objective')); ?>

                                    <?php echo e(Form::text('objective', ($alert->objective != null ? $alert->objective : ''), [
                                            'id'      => 'objective',
                                            'class'    => 'form-control',
                                            'maxlength' => 240,
                                            'onkeyup' => "textCounter(this,'objective_span',240)",
                                        ])); ?>

                                    <span id='objective_span' class="counter">240</span>
                                </div>  

                                <div class="col-md-12 form-group mb-3">
                                    
                                    <?php echo e(Form::label('summary', 'Summary')); ?>

                                    <div id="summary-editor">
                                        <?php if($alert->summary != null): ?>
                                            <?php echo $alert->summary; ?>

                                        <?php endif; ?>
                                    </div>
                                    <?php echo Form::textarea('summary', ($alert->summary != null ? $alert->summary : ''), ['id' => 'summary']); ?>


                                    <?php echo e(Form::hidden('alert_id', $alert->id, ['id' => 'alert_id'])); ?>


                                    <span class="quill_counter">Character limit: <span id="summary_span">0</span> / 2050</span>
                                </div>

                                <div class="col-md-12 form-group mb-3">
                                    <?php echo e(Form::label('recommendation', 'Recommendation')); ?>

                                    <div id="recommendation-editor">
                                        <?php if($alert->recommendation != null): ?>
                                            <?php echo $alert->recommendation; ?>

                                        <?php endif; ?>
                                    </div>
                                    <?php echo Form::textarea('recommendation', ($alert->recommendation != null ? $alert->recommendation : ''), ['id' => 'recommendationArea']); ?>

                                    <span class="quill_counter">Character limit: <span id="recommendation_span">0</span> / 1350</span>
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                        <!--<div id="step-2" class="tab-pane" role="tabpanel">
                            <br />
                            
                            <?php echo e(Form::model(null, ['route' => ['alerts.update', ($alert->id != null? $alert->id: '')], 'method' => 'patch', 'class' => 'dropzone', 'id' => 'file-upload'])); ?>

                                <div class="fallback">
                                    <input name="file" type="file" />
                                </div>
                            <?php echo e(Form::close()); ?>

                        
                        </div>-->
                        <div id="step-3" class="tab-pane" role="tabpanel">
                            
                            <br />
                            <?php echo e(Form::open(array( 'method' => 'post', 'route' => array('alerts.complete', $alert->id), 'autocomplete'=>'off', 'id' => 'stepFinal'))); ?>

                                <?php echo method_field('Put'); ?>
                            <?php echo e(Form::close()); ?>

                            <div class="iframeWrap">
                                <iframe id="previewTemplate" title="previewTemplate" src="<?php echo e(route('alerts.automatic_template', $alert->id)); ?>" frameborder="0" scrolling="no" >
                                </iframe>
                            </div>
                            <br />
                            
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn-icon m-1 ladda-button example-button" id="btnPrevious">
                    Previous
                </button>
                <button class="btn btn-primary btn-icon m-1 ladda-button example-button" id="btnNext">
                    Next
                </button>
                <button class="btn btn-danger btn-icon m-1 ladda-button example-button" id="btnFinish">
                    Generate PDF Report
                </button>
                <br /><br /><br />
            </div>
        </div><!-- end of main-content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>
<script src="<?php echo e(asset('assets/js/vendor/jquery.smartWizard.min.js')); ?>"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="<?php echo e(asset('assets/js/vendor/quill.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/vendor/dropzone.min.js')); ?>"></script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(document).ready(function () {
        
        $("#file-upload").dropzone({
            paramName: 'file',
            dictDefaultMessage: "Drag your images",
            clickable: true,
            acceptedFiles: ".jpeg,.jpg,.png",
            enqueueForUpload: true,
            maxFiles: 4,
            uploadMultiple: false,
            addRemoveLinks: true,
            init: function() {
                myDropzone = this;
                $.ajax({
                    url: "<?php echo e(route('alert_gallery.index')); ?>",
                    type: 'GET',
                    data: {'alert_id': $('#alert_id').val() },
                    dataType: 'json',
                    success: function(response){
                        $.each(response, function(key,value) {
                            var mockFile = { name: value.filename, size: value.size, id: value.id };
                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, "<?php echo e(route('storage.image', '')); ?>/"+value.filename+'/system_generated_report' );
                            myDropzone.emit("complete", mockFile);
                            myDropzone.files.push(mockFile);
                        });
                    }
                });

                myDropzone.on("maxfilesexceeded", function(file) {
                    this.removeFile(file);
                })

                myDropzone.on("error", function(file, message) { 
                    toastr.error('Max size limit increase');
                    this.removeFile(file); 
                });

                myDropzone.on("success", function(file, response) { 
                    file.id = response.data.id;
                    if(this.files.length > 4){
                        for(var i=4;i<this.files.length;i++){
                            this.removeFile( this.files[i] );
                            return;
                        }
                    }
                });

            },
            removedfile: function(file) 
            {
				if (this.options.dictRemoveFile) {
                    if(file.previewElement.id != ""){
                        var name = file.previewElement.id;
                    }else{
                        var name = file.name;
                    }

                    $.ajax({
                        type: 'DELETE',
                        url: "<?php echo e(route('alert_gallery.destroy', '')); ?>/"+file.id,
                        dataType: "JSON",
                        data: {
                            "_token": "<?php echo e(csrf_token()); ?>",
                        },
                        success: function (data){
                            toastr.success('Image Delete Successfully');
                        },
                        error: function(e) {
                            //console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
                }		
            }
        });
        
        $('#smartwizard').smartWizard({
            selected: 0,
            theme: 'arrows',
            transitionEffect: 'fade',
            enableURLhash: true,
            justified: true,
            toolbar: false,
            keyNavigation: false,
            enableFinishButton: true,
            enableAllSteps:false,
            autoAdjustHeight: false,
            //onFinish: onFinishCallback,
            disableStep: true,
            toolbarSettings: {
                toolbarPosition: 'bottom',
                toolbarButtonPosition: 'left',
                showNextButton: false, // show/hide a Next button
                showPreviousButton: false, // show/hide a Previous button
                //toolbarExtraButtons: [btnFinish]
            },
            keyboardSettings: {
                keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
            },
            transition: {
                animation: 'none', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
                speed: '400', // Transion animation speed
                easing:'' // Transition animation easing. Not supported without a jQuery easing plugin
            }
        });
        
        var stepIndex = $('#smartwizard').smartWizard("getStepIndex")+1;
        console.log(stepIndex);
        if(stepIndex == 3){
            $("#btnNext").addClass('disabled');
        }else{
            $("#btnPrevious").addClass('disabled');
            $("#btnFinish").addClass('disabled');
        }

        // Step show event
        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
            console.log(stepPosition);
            if(stepPosition === 'first') {
                $("#btnFinish").addClass('disabled').prop('disabled', true);
                $("#btnNext").removeClass('disabled').prop('disabled', false);
                $("#btnPrevious").addClass('disabled').prop('disabled', true);
            } else if(stepPosition === 'last') {
                $("#btnPrevious").removeClass('disabled').prop('disabled', false);
                $("#btnNext").addClass('disabled').prop('disabled', true);
                $("#btnFinish").removeClass('disabled').prop('disabled', false);
            } else {
                $("#btnFinish").addClass('disabled').prop('disabled', true);
                $("#btnPrevious").removeClass('disabled').prop('disabled', false);
                $("#btnNext").removeClass('disabled').prop('disabled', false);
            }
        });

        $("#btnPrevious").on('click', function(){
            $('#smartwizard').smartWizard("prev");
        });

        $("#btnNext").on('click', function(){
            // Get current step index
            var stepIndex = $('#smartwizard').smartWizard("getStepIndex")+1;
            
            if(stepIndex == 1){
                $.ajax({
                    url: $('#step'+stepIndex).attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: $('#step'+(stepIndex=1)).serialize(),
                    beforeSend: function(xhr){
                        $('#smartwizard').smartWizard("loader", "show");
                    },
                    success: function(result) {
                        if(result.status == 'success'){
                            document.getElementById('previewTemplate').src += '';
                            toastr.success(result.message);
                            $('#smartwizard').smartWizard("next");
                            $('#smartwizard').smartWizard("loader", "hide");
                            $('#alert_id').val(result.data.id);
                            $('#file-upload').prop('action', "<?php echo e(route('alerts.update', '')); ?>/"+result.data.id);
                        }
                    },
                    error:function(response, error){
                        $('#smartwizard').smartWizard("loader", "hide");
                        //console.log(response);
                        toastr.error(JSON.parse(response.responseText));
                        return false;
                    }
                });
            }
            else if(stepIndex == 2){
                $('#smartwizard').smartWizard("next");
            }
            document.getElementById('previewTemplate').src += '';
        });

        $("#btnFinish").on('click', function(){
            $('#smartwizard').smartWizard("loader", "show");
            $("#stepFinal").submit();
        });

        const editor = $('#summary-editor');

        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            //['blockquote', 'code-block'],

            //[{ 'header': 1 }, { 'header': 2 }],               // custom button values
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            //[{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            //[{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            [{ 'direction': 'rtl' }],                         // text direction

            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'font': [] }],
            [{ 'align': [] }],

            //['clean']                                         // remove formatting button
        ];

        var quill = new Quill('#summary-editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });

        //const editor = $('#recommendation-editor');

        var recommendation_quill = new Quill('#recommendation-editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        

        Quill.prototype.getHTML = function () {
            return this.container.querySelector('.ql-editor').innerHTML;
        };

        Quill.prototype.setHTML = function (html) {
            this.container.querySelector('.ql-editor').innerHTML = html;
        };

        const summary_limit = 2050;
        quill.on('text-change', () => {
            if (quill.getLength() > summary_limit) {
                $('#summary_span').html(summary_limit);
                quill.deleteText(summary_limit, quill.getLength());
            }
            else{
                $('#summary_span').html(quill.getLength()-1);
                $('#summary').html(quill.getHTML());
            }
        });
    

        const recommendation_limit = 1350;

        recommendation_quill.on('text-change', () => {
            if (recommendation_quill.getLength() > recommendation_limit) {
                $('#recommendation_span').html(recommendation_limit);
                recommendation_quill.deleteText(recommendation_limit, recommendation_quill.getLength());
                $('#recommendationArea').html(recommendation_quill.getHTML());
            }
            else{
                $('#recommendation_span').html(recommendation_quill.getLength()-1);
                $('#recommendationArea').html(recommendation_quill.getHTML());
            }
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

<?php $__env->startSection('bottom-js'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/alerts/edit.blade.php ENDPATH**/ ?>