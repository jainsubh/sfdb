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
    #fully_manual_reference_editor{
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
        <h1>Fully Manual Report Generate</h1>
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
                    <li><a class="nav-link" href="#step-2">Step 2<br /><small>Summary and key information</small></a></li>
                    <li><a class="nav-link" href="#step-3">Step 3<br /><small>Recommendation & References</small></a></li>
                    <li><a class="nav-link" href="#step-4">Step 4<br /><small>Image Gallery</small></a></li>
                    <li><a class="nav-link" href="#step-5">Step 5<br /><small>Preview Report</small></a></li>
                </ul>
                <div class="tab-content">
                    <div id="step-1" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($fully_manual_report, ['route' => ['fully_manual.update', $fully_manual_report->id], 'method' => 'patch', 'id' => 'step1']) }}
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    {{ Form::label('sector','Sector') }}
                                    {{ Form::select('sector_id', $sectors, $fully_manual_report->subject_id, ['class' => 'form-control']) }}
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    {{ Form::label('priority','Priority') }}
                                    {{ Form::select('priority', ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'], $fully_manual_report->priority, ['class' => 'form-control']) }}
                                </div>                         

                                <div class="col-md-6 form-group mb-2">             
                                    {{ Form::label('objectives', 'Objectives') }}
                                    {{ 
                                        Form::text('objectives', $fully_manual_report->objectives, [
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
                                    {!! Form::text('ref_id', $fully_manual_report->ref_id, ['class' => 'form-control disabled','autocomplete' => 'off', 'style' => 'margin-bottom:15px', 'required', 'disabled']) !!}
                                </div>

                            </div>
                        {{ Form::close() }}
                        <br />
                    </div>

                    <div id="step-2" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($fully_manual_report, ['route' => ['fully_manual.update', $fully_manual_report->id], 'method' => 'patch', 'id' => 'step2']) }}
                        <div class="row">
                            <div class="col-md-6 form-group mb-2">
                                {!! Form::label('title', 'Title') !!}
                                {!! Form::text('title', $fully_manual_report->title, 
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
                                    {!! $fully_manual_report->summary !!}
                                </div>
                                {!! Form::textarea('summary', $fully_manual_report->summary, ['id' => 'summary_editor_area']) !!}
                                <span class="quill_counter">Character limit: <span id="summary_span">0</span> / 1240</span>
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                {!! Form::label('key_information', 'Key Information') !!}
                                <div id="key_info_editor">
                                    {!! $fully_manual_report->key_information !!}
                                </div>
                                {!! Form::textarea('key_information', $fully_manual_report->key_information, ['id' => 'keyInformationArea']) !!}
                                <span class="quill_counter">Character limit: <span id="key_info_span">0</span> / 1240</span>
                            </div>
                            
                            <!--<div class="col-md-12 form-group mb-3">
                                {!! Form::label('features', 'Features') !!}
                                <div id="feature_editor">
                                    {!! $fully_manual_report->features !!}
                                </div>
                                {!! Form::textarea('features', $fully_manual_report->features, ['id' => 'feature_editor_area']) !!}
                                <span class="quill_counter">Character limit: <span id="features_span">0</span> / 900</span>
                            </div>
                            
                            <div class="col-md-12 form-group mb-3">
                                {!! Form::label('negatives', 'Negatives') !!}
                                <div id="negative_editor">
                                    {!! $fully_manual_report->negatives !!}
                                </div>
                                {!! Form::textarea('negatives', $fully_manual_report->negatives, ['id' => 'negative_editor_area']) !!}
                                <span class="quill_counter">Character limit: <span id="negative_span">0</span> / 900</span>
                            </div>
                            
                            <div class="col-md-12 form-group mb-3">
                                {!! Form::label('advantages', 'Advantages') !!}
                                <div id="advantage_editor">
                                    {!! $fully_manual_report->advantages !!}
                                </div>
                                {!! Form::textarea('advantages', $fully_manual_report->advantages, ['id' => 'advantage_editor_area']) !!}
                                <span class="quill_counter">Character limit: <span id="advantages_span">0</span> / 900</span>
                            </div>-->
                        </div>
                        {{ Form::close() }}
                    </div>

                    <div id="step-3" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($fully_manual_report, ['route' => ['fully_manual.update', $fully_manual_report->id], 'method' => 'patch', 'id' => 'step3']) }}
                        <div class="row">
                            <!--<div class="col-md-12 form-group mb-3">
                                {!! Form::label('vendor', 'Vendor Information') !!}
                                <div id="vendor_editor">
                                    {!! $fully_manual_report->vendor_information !!}
                                </div>
                                {!! Form::textarea('vendor_information', $fully_manual_report->summary, ['id' => 'vendor_editor_area']) !!}
                                <span class="quill_counter">Character limit: <span id="vendor_span">0</span> / 600</span>
                            </div>-->

                            <div class="col-md-12 form-group mb-3">
                                {!! Form::label('recommendation', 'Recommendation') !!}
                                <div id="recommendation_editor">
                                    {!! $fully_manual_report->recommendation !!}
                                </div>
                                {!! Form::textarea('recommendation', $fully_manual_report->recommendation, ['id' => 'recommendationArea']) !!}
                                <span class="quill_counter">Character limit: <span id="recommendation_span">0</span> / 900</span>
                            </div>

                            <div class="col-md-12 form-group pd-0">
                                <div class="col-md-6 form-group" style="float:left">
                                    {!! Form::label('alert_references', 'System Generated References') !!}
                                    <textarea id="alert_reference_editor">@if(isset($alert_links) && count($alert_links) > 0)@foreach($alert_links as $link){!! $link !!}&#13;&#10;@endforeach @endif</textarea>
                                </div>

                                <div class="exchange">
                                    <button type="button" class="btn btn-exchange" id="exchange_links">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                </div>

                                <div class="col-md-6 form-group" style="float:left">
                                    {!! Form::label('fully_manual_references', 'Fully Manual References') !!}
                                    <textarea name="fully_manual_references" rows="8" id="fully_manual_reference_editor" onblur="exchange_limit(this)">@if(isset($fully_manual_links_array) && count($fully_manual_links_array) > 0){!! implode("\n", $fully_manual_links_array); !!}@endif</textarea>
                                    <div class="theCount">References Count: <span id="linesUsed">0</span>/8</div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>

                    <div id="step-4" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($fully_manual_report, ['route' => ['fully_manual.update', $fully_manual_report->id], 'method' => 'patch', 'class' => 'dropzone', 'id' => 'file-upload']) }}
                            <div class="fallback">
                                <input name="file" type="file" />
                            </div>
                        {{ Form::close() }}
                    </div>

                    <div id="step-5" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($fully_manual_report, ['route' => ['fully_manual.complete', $fully_manual_report->id], 'method' => 'patch', 'id' => 'stepFinal']) }}
                            @method('Put')
                        {{ Form::close() }}
                        <div class="iframeWrap">
                            <iframe id="previewTemplate" title="previewTemplate" src="{{ route('fully_manual.show', $fully_manual_report->id) }}" frameborder="0" scrolling="no" >
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
    function exchange_limit(e){
        var lines = 8;
        var lines_content = $(e).val().split('\n');
        newLines = lines_content.length;
        
        if(newLines > lines) {
            toastr.info('References trimmed -- limit exceed more than 8 ');
            lines_content.splice(lines,newLines);
        }
        $('#fully_manual_reference_editor').val(lines_content.join("\n"));
    }
    
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
                    url: "{{ route('fully_manual_gallery.index') }}",
                    type: 'GET',
                    data: {'fully_manual_id': "{{ $fully_manual_report->id }}" },
                    dataType: 'json',
                    success: function(response){
                        $.each(response, function(key,value) {
                            var mockFile = { name: value.filename, size: value.size, id: value.id };
                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, "{{ route('storage.image', '') }}/"+value.filename );
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
                        url: "{{ route('fully_manual_gallery.destroy', '') }}/"+file.id,
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

        $("#exchange_links").on('click',function(e) {
            e.preventDefault();
            var alert_links = <?php echo json_encode($alert_links); ?>;
            $("#fully_manual_reference_editor").val('');
            var fully_manual_editor = $("#fully_manual_reference_editor");
            $.each(alert_links, function(i, item) {
                if(i<=7){
                    fully_manual_editor.val(fully_manual_editor.val() + item + '\n');
                    $('#linesUsed').text(i+1);
                } 
            });
            
        });

        

        var lines = 8;
        var linesUsed = $('#linesUsed');
        $('#fully_manual_reference_editor').keypress(function(e) {
            newLines = ($(this).val().match(/\n/g)||[]).length;
            linesUsed.text(newLines+1);

            if(newLines >= lines) {
                return false;
            }
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

            //['clean']                                         // remove formatting button
        ];

        const summary_quill = new Quill('#summary_editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        })

        const key_information_quill = new Quill('#key_info_editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        })

        const recommendation_quill = new Quill('#recommendation_editor', {
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

        const limit = 1240;
        summary_quill.on('text-change', () => {
            if (summary_quill.getLength() > limit) {
                $('#summary_span').html(limit);
                summary_quill.deleteText(limit, summary_quill.getLength());
                $('#summary_editor_area').html(summary_quill.getHTML());
            }
            else{
                $('#summary_span').html(summary_quill.getLength()-1);
                $('#summary_editor_area').html(summary_quill.getHTML());
            }
        });

        key_information_quill.on('text-change', () => {
            if (key_information_quill.getLength() > limit) {
                $('#key_info_span').html(limit);
                key_information_quill.deleteText(limit, key_information_quill.getLength());
                $('#keyInformationArea').html(key_information_quill.getHTML());
            }
            else{
                $('#key_info_span').html(key_information_quill.getLength()-1);
                $('#keyInformationArea').html(key_information_quill.getHTML());
            }
        });

        const recommendation_limit = 900;
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

    function textCounter(field,field2,maxlimit){
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