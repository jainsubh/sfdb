@extends('admin::layouts.master')

@section('page-css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
<link rel="stylesheet" href="{{asset('assets/jQuery-MultiSelect/jquery.multiselect.css')}}">
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
</style>
@endsection
@section('main-content')
   <div class="breadcrumb">
        <h1>Edit Free Form Report</h1>
        <ul>
            <li><a href="{{ route('freeform_report.index') }}">Free Form Report</a></li>
            <li>Edit</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    @include('admin::layouts.errors')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Free Form Report Information</div>
                    <form method="post" action="{{ route('freeform_report.update', $freeform_report->id) }}" enctype="multipart/form-data">
                        @method('put')
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 form-group mb-2">
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

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 form-group mb-2">
                                {{ Form::label('objective','Objective') }}
                                {{ 
                                    Form::text('objective',$freeform_report->objective, [
                                       'id'      => 'objective',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter report objective'
                                    ])
                                }}
                                @error('objective')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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

                            <div class="col-md-6 form-group mb-3 selector-container">
                                {{ Form::label('sector_id','Sector') }}
                                {{ Form::select('sector_id',$sectors,$freeform_report->sector_id, ['id'=>'sector_id','placeholder'=>'Select Sector','class'=>'form-control']) }}
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
                                        {!! Form::label('thumbnail_report', 'Choose a file', ['class'=>'custom-file-label']) !!}
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

                            <div class="col-md-12 form-group mb-3">
                                {{ Form::submit('Submit', array('class' => 'btn btn-primary ladda-button example-button m-1','data-style' => 'expand-right')) }}
                                <button type="button" class="btn btn-default m-1" onclick="window.location='{{ route('freeform_report.index') }}'">Cancel</button>
                            </div>

                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-js')   
    <!-- Js for date time picker -->
<script src="{{asset('assets/js/vendor/calendar/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/calendar/moment.min.js')}}"></script>
<script src="{{asset('assets/jQuery-MultiSelect/jquery.multiselect.js')}}"></script>
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
@endsection