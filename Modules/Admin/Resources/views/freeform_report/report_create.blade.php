@extends('admin::layouts.master')
@section('before-css')
@endsection
@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/smartwizard/css/smart_wizard_all.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/quill.snow.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/quill.image-uploader.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/dropzone.min.css') }}" />
<link rel="stylesheet" href="{{asset('assets/jQuery-MultiSelect/jquery.multiselect.css')}}">
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
        height: 500px;
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
        width: 104%;
        height: 1550px;
        transform: scale(0.5);
        transform-origin: 0 0;
        display: block;
        border-style:none;
        margin: 0 auto;
    }
    .counter{
        font-size: 12px;
        position: relative;
        top: -25px;
        float: right;
        padding-right: 25px;
        display:inline-block;
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
                    <li><a class="nav-link" href="#step-1">Step 1<br /><small>Title & Objective</small></a></li>
                    <li><a class="nav-link" href="#step-2">Step 2<br /><small>Content</small></a></li>
                    <li><a class="nav-link" href="#step-3">Step 3<br /><small>PDF Report Generate</small></a></li>
                </ul>
                <div class="tab-content">
                    <div id="step-1" class="tab-pane" role="tabpanel">
                        <br />
                        
                        {{ Form::model($freeform_report, ['route' => ['freeform_report.update', $freeform_report->id], 'method' => 'patch', 'id' => 'step1',  'enctype' => "multipart/form-data"]) }} 
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('title','Title') }}
                                {{ 
                                    Form::text('title',$freeform_report->title, [
                                       'id'      => 'title',
                                       'class'    =>"form-control",
                                       'maxlength' => 90,
                                       'onkeyup' => "textCounter(this,'title_span',90)",
                                       'placeholder'=>'Enter report title',
                                       'required' => 'required'
                                    ])
                                }}
                                <span id='title_span' class="counter">90</span>
                            </div>
                            
                            <div class="col-md-6 form-group mb-3">             
                                {{ Form::label('objective','Objective') }}
                                {{ 
                                    Form::text('objective',$freeform_report->objective, [
                                       'id'      => 'objective',
                                       'class'    =>"form-control",
                                       'maxlength' => 60,
                                       'onkeyup' => "textCounter(this,'objective_span',60)",
                                       'placeholder'=>'Enter report objective'
                                    ])
                                }}
                                <span id='objective_span' class="counter">60</span>
                            </div>  

                            @if(is_array($dataset_arr))
                                @foreach($dataset_arr as $key => $data_val)
                                    @if(count($data_val['data']) > 0)
                                        @php 
                                            $selector_name = "dataset[".$data_val['id']."][]";
                                            $fill_data = (is_array($dataset_lookup) && count($dataset_lookup) > 0? $dataset_lookup[$data_val['id']]: null);
                                        @endphp
                                        <div class="col-md-6 form-group mb-3">
                                            {{ Form::label('dataset_id', $data_val['name']) }}
                                            {{ Form::select($selector_name, $data_val['data'], $fill_data, [
                                                'id'=>'dataset_'.$data_val['id'],
                                                'placeholder'=>'Select '.$data_val['name'],
                                                'class'=>'form-control',
                                                'multiple' => 'multiple'
                                                ])
                                            }}
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            <div class="col-md-6 form-group mb-3 selector-container">
                                {{ Form::label('country_id', 'Country') }}
                                {{ Form::select('countries[]', $countries, $country_lookup, ['id'=>'country_id','class'=>'form-control', 'multiple'=>'multiple']) }}
                                @error('sector')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('upload_thumbnail','Report Thumbnail') }}
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="thumbnail_report_text">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        {!! Form::file('thumbnail_report', ['class' => 'custom-file-input', 'id' => 'thumbnail_report', 'aria-describedby' => "thumbnail_report"]) !!}
                                        {!! Form::label('thumbnail_report_label', 'Choose a file', ['class'=>'custom-file-label']) !!}
                                    </div>
                                </div>
                                <p style="color:red">File should be only in jpg, png, jpeg format</p>
                                @if ($errors->has('thumbnail_report')) <p class="help-block">{{ $errors->first('thumbnail_report') }}</p> @endif
                                <div class="gallery">
                                    @if($freeform_report->thumbnail)
                                    <img src="{{ route('storage.image', $freeform_report->thumbnail) }}/freeform_report/thumbnail" style="width:150px;" alt="report_thumbnail" title="report_thumbnail">
                                    @endif
                                </div>
                            </div>

                        </div>
                        
                        {{ Form::close() }}
                        
                    </div>

                    <div id="step-2" class="tab-pane" role="tabpanel">
                        <br />
                        {{ Form::model($freeform_report, ['route' => ['freeform_report.update', $freeform_report->id], 'method' => 'patch', 'id' => 'step2']) }}    
                            {{ Form::label('key_information', 'Content') }}
                            <div id="full-editor">
                                {!!  $freeform_report->key_information !!}
                            </div>
                            {!! Form::textarea('key_information', ($freeform_report != null ? $freeform_report->key_information : ''), ['id' => 'keyInformationArea']) !!}
                            <br />
                        {{ Form::close() }}
                    </div>
                
                    <div id="step-3" class="tab-pane" role="tabpanel">
                        <br />
                            {{ Form::open(array( 'method' => 'post', 'route' => array('freeform_report.complete', $freeform_report->id), 'autocomplete'=>'off', 'id' => 'stepFinal')) }}
                                @method('Put')
                            {{ Form::close() }}
                            <div class="iframeWrap">
                                <iframe id="previewTemplate" title="previewTemplate" src="{{ route('freeform_report.report_preview', $freeform_report->id) }}" frameborder="0" scrolling="yes" >
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
<script src="{{asset('assets/jQuery-MultiSelect/jquery.multiselect.js')}}"></script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;

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
        
        $("#step1").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            $.ajax({
                url: $('#step1').attr('action'),
                type: 'POST',
                //dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache:false,
                contentType: false,
                processData: false,
                beforeSend: function(xhr){
                },
                success: function(result) {
                    toastr.success('Thumbnail changed successfully');
                },
                error:function(response, error){
                    $('#smartwizard').smartWizard("loader", "hide");
                    toastr.error(JSON.parse(response.responseText));
                    return false;
                }
            });
        });
        

        $('#thumbnail_report').on('change',function(){
            //get the file name
            var filename = $('input[type=file]').val().split('\\').pop();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(filename);

            imagesPreview(this, 'div.gallery');
            $("#step1").submit();    
        });

        @if(is_array($dataset_arr))
            @foreach($dataset_arr as $key => $data_val)
            $('#dataset_{{ $data_val['id'] }}').multiselect({
                texts: {
                    placeholder: 'Select {{ $data_val['name'] }}'
                }
            });
            @endforeach
        @endif

        $('#country_id').multiselect({
            texts: {
                placeholder: 'Select Countries'
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
        if(stepIndex == 2){
            $("#btnPrevious").addClass('disabled');
            $("#btnFinish").addClass('disabled');
        }else if(stepIndex == 3){
            $("#btnNext").addClass('disabled');
        }else{
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
            console.log(stepIndex);
            if(stepIndex == 1 || stepIndex == 2){
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
                            document.getElementById('previewTemplate').src += ''; 
                            toastr.success(result.message);
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
            else if(stepIndex == 3){
                $('#smartwizard').smartWizard("next");
                document.getElementById('previewTemplate').src += '';
            }
            
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

            //['clean']                                         // remove formatting button
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

        const quill = new Quill('#full-editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptionsWithImage,
                imageResize: true,
                imageUploader: {
                    upload: file => {
                        saveToServer(file, 'freeform_report');
                    },
                },
            },
            theme: 'snow'
        });

        /*const quill_recommendation = new Quill('#recommendation-editor', {
            modules: {
                syntax: !0,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });*/

        Quill.prototype.getHTML = function () {
            return this.container.querySelector('.ql-editor').innerHTML;
        };

        Quill.prototype.setHTML = function (html) {
            this.container.querySelector('.ql-editor').innerHTML = html;
        };

        quill.on('text-change', () => {
            $('#keyInformationArea').html(quill.getHTML());
        });

        /*quill_recommendation.on('text-change', () => {
            $('#recommendationArea').html(quill_recommendation.getHTML());
        });*/

                
        function saveToServer(file, report_type) {
            var csrfToken = "{{ csrf_token() }}";
            const fd = new FormData();
            fd.append('file', file);
            //var filename = file.name.split('.').slice(0, -1).join('.');
            const xhr = new XMLHttpRequest();
            xhr.open('POST', "../fileUpload", true);
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

        /**
         * Step3. insert image url to rich editor.
         *
         * @param {string} file_name
         */
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
        quill.getModule('toolbar').addHandler('image', () => {
            selectLocalImage('freeform_report');
        });
        
        

    });
</script>
@endsection

@section('bottom-js')
@endsection