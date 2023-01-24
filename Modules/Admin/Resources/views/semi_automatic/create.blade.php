@extends('admin::layouts.master')
@section('before-css')
@endsection
@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/smartwizard/css/smart_wizard_all.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/quill.snow.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/quill.image-uploader.min.css') }}" />
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
    #full-editor{
        height: 200px;
    }
    
    #keyInformationArea{
        display: none;
    }
    #recommendationArea{
        display: none;
    }
    #recommendation-editor{
        height: 200px;
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
    }
</style>
@endsection
@section('main-content')
   <div class="breadcrumb">
        <h1>Generate Report</h1>
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
                        <li><a class="nav-link" href="#step-1">Step 1<br /><small>Key Information</small></a></li>
                        <li><a class="nav-link" href="#step-2">Step 2<br /><small>Image Gallery</small></a></li>
                        <li><a class="nav-link" href="#step-3">Step 3<br /><small>PDF Report Generate</small></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="step-1" class="tab-pane" role="tabpanel">
                            <br />
                            <div class="row">
                                
                                {{ Form::open(array( 'method' => 'post', 'route' => 'semi_automatic.store', 'autocomplete'=>'off', 'id' => 'step1')) }}
                                <div class="col-md-6 form-group mb-3">
                                    {!! Form::label('title', 'Title') !!}
                                    {!! Form::text('title', ($task->alert != null ? $task->alert->title : ''), 
                                    [
                                        'class' => 'form-control', 
                                        'autocomplete' => 'off', 
                                        'maxlength' => 90,
                                        'onkeyup' => "textCounter(this,'title_span',90)",
                                        'style' => 'margin-left:0px', 
                                        'required' => 'required'
                                    ]) !!}
                                    <span id='title_span' class="counter">90</span>
                                </div>
                                
                                <div class="col-md-6 form-group mb-3">             
                                    {{ Form::label('objective', 'Objective') }}
                                    {{ 
                                        Form::text('objective', ($task->semi_automatic != null ? $task->semi_automatic->objective : ''), [
                                            'id'      => 'objective',
                                            'class'    => 'form-control',
                                            'maxlength' => 45,
                                            'onkeyup' => "textCounter(this,'objective_span',45)",
                                        ])
                                    }}
                                    <span id='objective_span' class="counter">45</span>
                                </div>  

                                <div class="col-md-12 form-group mb-3">
                                    {{ Form::label('key_information', 'Key Information') }}
                                    <div id="full-editor">
                                        @if($task->semi_automatic != null)
                                            {!!  $task->semi_automatic->key_information !!}
                                        @endif
                                    </div>
                                    {!! Form::textarea('key_information', ($task->semi_automatic != null ? $task->semi_automatic->key_information : ''), ['id' => 'keyInformationArea']) !!}
                                    <span class="quill_counter">Character limit: <span id="key_info_span">0</span> / 1240</span>

                                </div>

                                <br/>
                                
                                <div class="col-md-12 form-group mb-3">
                                    {{ Form::label('recommendation', 'Recommendation') }}
                                    <div id="recommendation-editor">
                                        @if($task && $task->semi_automatic != null)
                                            {!!  $task->semi_automatic->recommendation !!}
                                        @endif
                                    </div>
                                    {!! Form::textarea('recommendation', ($task->semi_automatic != null ? $task->semi_automatic->recommendation : ''), ['id' => 'recommendationArea']) !!}
                                    <span class="quill_counter">Character limit: <span id="recommendation_span">0</span> / 1240</span>

                                    

                                    {{ Form::hidden('task_id', $task->id) }}
                                    {{ Form::hidden('subject_id', $task->subject_id) }}
                                    {{ Form::hidden('semi_automatic_id', ($task->semi_automatic != null? $task->semi_automatic->id: ''), array('id' => 'semi_automatic_id')) }}
                                </div>

                                

                                {{ Form::close() }}
                            </div>
                        </div>
                        <div id="step-2" class="tab-pane" role="tabpanel">
                            <br />
                            {{ Form::model(null, ['route' => ['semi_automatic.update', ($task->semi_automatic != null? $task->semi_automatic->id: '')], 'method' => 'patch', 'class' => 'dropzone', 'id' => 'file-upload']) }}
                                <div class="fallback">
                                    <input name="file" type="file" />
                                </div>
                            {{ Form::close() }}
                        </div>
                        <div id="step-3" class="tab-pane" role="tabpanel">
                            <br />
                                {{ Form::open(array( 'method' => 'post', 'route' => array('semi_automatic.complete', $task->id), 'autocomplete'=>'off', 'id' => 'stepFinal')) }}
                                    @method('Put')
                                {{ Form::close() }}
                                <div class="iframeWrap">
                                    <iframe id="previewTemplate" title="previewTemplate" src="{{ route('semi_automatic.show', $task->id) }}" frameborder="0" scrolling="yes" >
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
<script src="{{ asset('assets/js/vendor/jquery.smartWizard.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="{{ asset('assets/js/vendor/quill.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/image-uploader.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/image-resize.min.js') }}"></script>
<script src="{{asset('assets/js/vendor/dropzone.min.js') }}"></script>
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
                    url: "{{ route('semi_automatic_gallery.index') }}",
                    type: 'GET',
                    data: {'semi_automatic_id': $('#semi_automatic_id').val() },
                    dataType: 'json',
                    success: function(response){
                        $.each(response, function(key,value) {
                            var mockFile = { name: value.filename, size: value.size, id: value.id };
                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, "{{ route('storage.image', '') }}/"+value.filename+'/semi-automatic' );
                            myDropzone.emit("complete", mockFile);
                            myDropzone.files.push(mockFile);
                        });
                    }
                });

                myDropzone.on("maxfilesexceeded", function(file) {
                    this.removeFile(file);
                })

                myDropzone.on("error", function(file, message) { 
                    toastr.error(message);
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
                        url: "{{ route('semi_automatic_gallery.destroy', '') }}/"+file.id,
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
        if(stepIndex == 3){
            $("#btnNext").addClass('disabled');
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
            var stepIndex = $('#smartwizard').smartWizard("getStepIndex");
            if(stepIndex == 0){
                $.ajax({
                    url: "{{ route('semi_automatic.store') }}",
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
                            $('#semi_automatic_id').val(result.data.id);
                            $('#file-upload').prop('action', "{{ route('semi_automatic.update', '') }}/"+result.data.id);
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
            else if(stepIndex == 1){
                $('#smartwizard').smartWizard("next");
            }
            document.getElementById('previewTemplate').src += '';
        });

        $("#btnFinish").on('click', function(){
            $('#smartwizard').smartWizard("loader", "show");
            $("#stepFinal").submit();
        });
        
        //const editor = $('#full-editor');

        //const editor = $('#recommendation-editor');

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
            //['image'],
            [{ 'font': [] }],
            [{ 'align': [] }],

            ['clean'] 
        ];

        var toolbarOptionsWithImage = [
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
            ['image'],
            [{ 'font': [] }],
            [{ 'align': [] }],

            //['clean']                                         // remove formatting button
        ];

        Quill.register('modules/imageUploader', ImageUploader);

        const key_information_quill = new Quill('#full-editor', {
            modules: {
                toolbar: toolbarOptionsWithImage,
                imageResize: true,
                imageUploader: {
                    upload: file => {
                        saveToServer(file, 'semi-automatic');
                    },
                },
            },
            theme: 'snow'
        });

        const recommendation_quill = new Quill('#recommendation-editor', {
            modules: {
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
        
        const limit = 1240;
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

        recommendation_quill.on('text-change', () => {
            if (recommendation_quill.getLength() > limit) {
                $('#recommendation_span').html(limit);
                recommendation_quill.deleteText(limit, recommendation_quill.getLength());
                $('#recommendationArea').html(recommendation_quill.getHTML());
            }
            else{
                $('#recommendation_span').html(recommendation_quill.getLength()-1);
                $('#recommendationArea').html(recommendation_quill.getHTML());
            }
        });

        function saveToServer(file, report_type) {
            var csrfToken = "{{ csrf_token() }}";
            const fd = new FormData();
            fd.append('file', file);
            //var filename = file.name.split('.').slice(0, -1).join('.');
            const xhr = new XMLHttpRequest();
            xhr.open('POST', "{{ URL::to('/admin/semi_automatic/fileUpload') }}", true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = () => {
                if (xhr.status === 200) {
                    // this is callback data: url
                    const file_name = JSON.parse(xhr.responseText).file_name;
                    insertToEditor(file_name, report_type);
                }
            };
            xhr.send(fd);
        }

        
        function insertToEditor(file_name, report_type) {
            // push image url to rich editor.
            const range = quill.getSelection();
            quill.insertEmbed(range.index, 'image', `<?php echo url('storage') ?>/${file_name}/${report_type}`);
        }

        function selectLocalImage(report_type) {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.click();

            // Listen upload local image and save to server
            input.onchange = () => {
                const file = input.files[0];

                // file type is only image.
                if (/^image\//.test(file.type)) {
                    saveToServer(file, report_type);
                } else {
                    console.warn('You could only upload images.');
                }
            };
        }

        // quill editor add image handler
        key_information_quill.getModule('toolbar').addHandler('image', () => {
            selectLocalImage('semi-automatic');
        });

        //$(".ql-direction").trigger("click");
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