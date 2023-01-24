@extends('admin::layouts.master')
@section('before-css')
@endsection
@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/smartwizard/css/smart_wizard_all.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/quill.snow.css') }}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/dropzone.min.css') }}" />
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
    #summary_editor{
        height: 300px;
    }
    #summary_editor_area{
        display: none;
    }
    #feature_editor{
        height: 300px;
    }
    #feature_editor_area{
        display: none;
    }
    #negative_editor{
        height: 300px;
    }
    #negative_editor_area{
        display: none;
    }
    #advantage_editor{
        height: 300px;
    }
    #advantage_editor_area{
        display: none;
    }
    #vendor_editor{
        height: 300px;
    }
    #key_info_editor{
        height: 400px;
    }
    #vendor_editor_area{
        display: none;
    }
    #keyInformationArea{
        display: none;
    }
    #recommendationArea{
        display: none;
    }
    #recommendation_editor{
        height: 200px;
    }
    #alert_reference_editor{
        height: 300px;
        width: 100%;
        white-space: pre-wrap;
    }
    #product_reference_editor{
        height: 300px;
        width: 100%;
        white-space: pre-wrap;
    }
    .sw-theme-arrows > .nav{
        border-bottom: 0px;
    }
    .pd-0{
        padding: 0px;
    }
    .sw.sw-justified > .nav > li, .sw.sw-justified > .nav .nav-link{
        flex-grow: 0.2;
    }
    .sw-theme-arrows > .tab-content > .tab-pane{
        padding: 0px;
    }
    .iframeWrap{
        height: 650px;
        width: 100%;
        margin: 0 auto;
    }
    #previewTemplate{
        width: 100%;
        height: 1650px;
        transform: scale(0.4);
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
    .quill_counter{
        font-size: 14px;
        float: left;
        display:inline-block;
    }
    .mb-2{
        margin-bottom: 0px !important;
    }
    .exchange{
        position: absolute;
        top: 50%;
        z-index: 100;
        left: 48%;
    }
    .btn-exchange{
        padding: 10px 20px 10px 20px;
        background-color: #E7E9EB;
    }
</style>
@endsection
@section('main-content')
   <div class="breadcrumb">
        <h1>Product Generate</h1>
        <ul>
            <li><a href="{{ route('tasks.index') }}">Tasks</a></li>
            <li>Add</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    @include('admin::layouts.errors')

    <div class="row">
        <div class="col-md-12">
            <!--  SmartWizard html -->
            <div id="smartwizard">
                <ul class="nav">
                    <li><a class="nav-link" href="#step-1">Step 1<br /><small>Time and Objectives</small></a></li>
                    <li><a class="nav-link" href="#step-2">Step 2<br /><small>Summary and Vendor information</small></a></li>
                    <li><a class="nav-link" href="#step-3">Step 3<br /><small>Information</small></a></li>
                    <li><a class="nav-link" href="#step-4">Step 4<br /><small>Image Gallery</small></a></li>
                    <li><a class="nav-link" href="#step-5">Step 5<br /><small>Preview Report</small></a></li>
                </ul>
                <div class="tab-content">
                    <div id="step-1" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($product_report, ['route' => ['product.update', $product_report->id], 'method' => 'patch', 'id' => 'step1']) }}
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    {{ Form::label('sector','Sector') }}
                                    {{ Form::select('sector_id', $sectors, $product_report->subject_id, ['class' => 'form-control']) }}
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    {{ Form::label('priority','Priority') }}
                                    {{ Form::select('priority', ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'], $product_report->priority, ['class' => 'form-control']) }}
                                </div>                         

                                <div class="col-md-6 form-group mb-2">             
                                    {{ Form::label('objectives', 'Objectives') }}
                                    {{ 
                                        Form::text('objectives', $product_report->objectives, [
                                            'id'      => 'objectives',
                                            'class'    => 'form-control',
                                            'maxlength' => 45,
                                            'onkeyup' => "textCounter(this,'objective_span',45)",
                                        ])
                                    }}
                                    <span id='objective_span' class="counter">45</span>
                                </div>  

                                <div class="col-md-6 form-group mb-3">
                                    {!! Form::label('date_time', 'Select Date Time') !!}
                                    {!! Form::text('date_time', null, ['class' => 'date form-control','autocomplete' => 'off','style' => 'margin-bottom:15px', 'placeholder' => 'Select Date and Time']) !!}
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    {!! Form::label('ref_id', 'Reference ID') !!}
                                    {!! Form::text('ref_id', $product_report->ref_id, ['class' => 'form-control disabled','autocomplete' => 'off', 'style' => 'margin-bottom:15px', 'required', 'disabled']) !!}
                                </div>

                            </div>
                        {{ Form::close() }}
                        <br />
                    </div>
                    <div id="step-2" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($product_report, ['route' => ['product.update', $product_report->id], 'method' => 'patch', 'id' => 'step2']) }}
                        <div class="row">
                            <div class="col-md-6 form-group mb-2">
                                {!! Form::label('title', 'Title') !!}
                                {!! Form::text('title', $product_report->title, 
                                [
                                    'class' => 'form-control', 
                                    'autocomplete' => 'off', 
                                    'maxlength' => 90,
                                    'onkeyup' => "textCounter(this,'title_span',90)",
                                    'style' => 'margin-left:0px', 
                                    'required'
                                ]) !!}
                                <span id='title_span' class="counter">90</span>
                            </div>
                            
                            <div class="col-md-12 form-group mb-3">
                                {!! Form::label('summary', 'Summary') !!}
                                <div id="summary_editor">
                                    {!! $product_report->summary !!}
                                </div>
                                {!! Form::textarea('summary', $product_report->summary, ['id' => 'summary_editor_area']) !!}
                                <span class="quill_counter">Character limit: <span id="summary_span">0</span> / 1045</span>
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                {!! Form::label('vendor_information', 'Vendor Information') !!}
                                <div id="vendor_editor">
                                    {!! $product_report->vendor_information !!}
                                </div>
                                {!! Form::textarea('vendor_information', $product_report->vendor_information, ['id' => 'vendor_editor_area']) !!}
                                <span class="quill_counter">Character limit: <span id="vendor_span">0</span> / 440</span>
                            </div>

                        </div>
                        {{ Form::close() }}
                    </div>
                    <div id="step-3" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($product_report, ['route' => ['product.update', $product_report->id], 'method' => 'patch', 'id' => 'step3']) }}
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                {!! Form::label('features', 'Features') !!}
                                <div id="feature_editor">
                                    {!! $product_report->features !!}
                                </div>
                                {!! Form::textarea('features', $product_report->features, ['id' => 'feature_editor_area']) !!}
                                <span class="quill_counter">Character limit: <span id="features_span">0</span> / 595</span>
                            </div>
                            
                            <div class="col-md-12 form-group mb-3">
                                {!! Form::label('negatives', 'Disadvantages') !!}
                                <div id="negative_editor">
                                    {!! $product_report->negatives !!}
                                </div>
                                {!! Form::textarea('negatives', $product_report->negatives, ['id' => 'negative_editor_area']) !!}
                                <span class="quill_counter">Character limit: <span id="negative_span">0</span> / 595</span>
                            </div>
                            
                            <div class="col-md-12 form-group mb-3">
                                {!! Form::label('advantages', 'Advantages') !!}
                                <div id="advantage_editor">
                                    {!! $product_report->advantages !!}
                                </div>
                                {!! Form::textarea('advantages', $product_report->advantages, ['id' => 'advantage_editor_area']) !!}
                                <span class="quill_counter">Character limit: <span id="advantage_span">0</span> / 900</span>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div id="step-4" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($product_report, ['route' => ['product.update', $product_report->id], 'method' => 'patch', 'class' => 'dropzone', 'id' => 'file-upload']) }}
                            <div class="fallback">
                                <input name="file" type="file" />
                            </div>
                        {{ Form::close() }}
                    </div>
                    <div id="step-5" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($product_report, ['route' => ['product.complete', $product_report->id], 'method' => 'patch', 'id' => 'stepFinal']) }}
                            @method('Put')
                        {{ Form::close() }}
                        <div class="iframeWrap">
                            <iframe id="previewTemplate" title="previewTemplate" src="{{ route('product.show', $product_report->id) }}" frameborder="0" scrolling="no" >
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
@endsection

@section('page-js')
<script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/jquery.smartWizard.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="{{ asset('assets/js/vendor/quill.min.js') }}"></script>
<script src="{{asset('assets/js/vendor/calendar/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/calendar/moment.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<script src="{{asset('assets/js/vendor/dropzone.min.js') }}"></script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(document).ready(function () {
        
        $("input[id$=date_time]").datetimepicker({
            dateFormat:'yy-mm-dd',
            timeFormat:'HH:mm:ss'
        });

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
                    url: "{{ route('product_gallery.index') }}",
                    type: 'GET',
                    data: {'product_id': "{{ $product_report->id }}" },
                    dataType: 'json',
                    success: function(response){
                        $.each(response, function(key,value) {
                            var mockFile = { name: value.filename, size: value.size, id: value.id };
                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, "{{ route('storage.image', '') }}/"+value.filename+'/product' );
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
                        url: "{{ route('product_gallery.destroy', '') }}/"+file.id,
                        dataType: "JSON",
                        data: {
                            "_token": "{{ csrf_token() }}",
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
            disableStep: true,
            toolbarSettings: {
                toolbarPosition: 'bottom',
                toolbarButtonPosition: 'left',
                showNextButton: false, // show/hide a Next button
                showPreviousButton: false, // show/hide a Previous button
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
        if(stepIndex == 2 || stepIndex == 3 || stepIndex == 4){
            $("#btnFinish").addClass('disabled');
        }else if(stepIndex == 5){
            $("#btnNext").addClass('disabled');
            $("#btnFinish").addClass('enabled');
        }else{
            $("#btnPrevious").addClass('disabled');
            $("#btnFinish").addClass('disabled');
        }

        // Step show event
        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
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
            
            if(stepIndex == 1 || stepIndex == 2 || stepIndex == 3){
                $.ajax({
                    url: $('#step'+stepIndex).attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: $('#step'+stepIndex).serialize(),
                    beforeSend: function(xhr){
                        $('#smartwizard').smartWizard("loader", "show");
                    },
                    success: function(result) {
                        if(result.status == 'success'){
                            $('#smartwizard').smartWizard("next");
                            $('#smartwizard').smartWizard("loader", "hide");
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

            if(stepIndex == 4){
                $('#smartwizard').smartWizard("next");
            }
            document.getElementById('previewTemplate').src += '';
            
        });

        $("#btnFinish").on('click', function(){
            $('#smartwizard').smartWizard("loader", "show");
            $("#stepFinal").submit();
        });


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

            //['clean']                                 f        // remove formatting button
        ];

        const summary_quill = new Quill('#summary_editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        })

        const vendor_quill = new Quill('#vendor_editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        })
        

        const feature_quill = new Quill('#feature_editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        })

        const negative_quill = new Quill('#negative_editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        })

        const advantage_quill = new Quill('#advantage_editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        })

        Quill.prototype.getHTML = function () {
            return this.container.querySelector('.ql-editor').innerHTML;
        };

        Quill.prototype.setHTML = function (html) {
            this.container.querySelector('.ql-editor').innerHTML = html;
        };

        const summary_limit = 1045;
        summary_quill.on('text-change', () => {
            if (summary_quill.getLength() > summary_limit) {
                $('#summary_span').html(summary_limit);
                summary_quill.deleteText(summary_limit, summary_quill.getLength());
                $('#summary_editor_area').html(summary_quill.getHTML());
            }
            else{
                $('#summary_span').html(summary_quill.getLength()-1);
                $('#summary_editor_area').html(summary_quill.getHTML());
            }
        });

        const vendor_limit = 440;
        vendor_quill.on('text-change', () => {
            if (vendor_quill.getLength() > vendor_limit) {
                $('#vendor_span').html(vendor_limit);
                vendor_quill.deleteText(vendor_limit, vendor_quill.getLength());
                $('#vendor_editor_area').html(vendor_quill.getHTML());
            }
            else{
                $('#vendor_span').html(vendor_quill.getLength()-1);
                $('#vendor_editor_area').html(vendor_quill.getHTML());
            }
        });

        const info_limit = 595;
        feature_quill.on('text-change', () => {
            if (feature_quill.getLength() > info_limit) {
                $('#features_span').html(info_limit);
                feature_quill.deleteText(info_limit, feature_quill.getLength());
                $('#feature_editor_area').html(feature_quill.getHTML());
            }
            else{
                $('#features_span').html(feature_quill.getLength()-1);
                $('#feature_editor_area').html(feature_quill.getHTML());
            }
        });

        negative_quill.on('text-change', () => {
            if (negative_quill.getLength() > info_limit) {
                $('#negative_span').html(info_limit);
                negative_quill.deleteText(info_limit, negative_quill.getLength());
                $('#negative_editor_area').html(negative_quill.getHTML());
            }
            else{
                $('#negative_span').html(negative_quill.getLength()-1);
                $('#negative_editor_area').html(negative_quill.getHTML());
            }
        });

        const advantage_limit = 900;
        advantage_quill.on('text-change', () => {
            if (advantage_quill.getLength() > advantage_limit) {
                $('#advantage_span').html(advantage_limit);
                advantage_quill.deleteText(advantage_limit, advantage_quill.getLength());
                $('#advantage_editor_area').html(advantage_quill.getHTML());
            }
            else{
                $('#advantage_span').html(advantage_quill.getLength()-1);
                $('#advantage_editor_area').html(advantage_quill.getHTML());
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
@endsection

@section('bottom-js')
@endsection