@extends('admin::layouts.master')
@section('before-css')
    <link rel="stylesheet" media="screen" type="text/css" href="{{asset('assets/styles/vendor/colorpicker.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/multiselect/multi.select.css')}}">
@endsection
@section('page-css')
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
@endsection
@section('main-content')
   <div class="breadcrumb">
        <h1>Add Site</h1>
        <ul>
            <li><a href="{{ route('sites.index') }}">Sites</a></li>
            <li>Add</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    @include('admin::layouts.errors')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Site Information</div>
                    {{ Form::open(array( 'method' => 'post','route' => 'sites.store','files'=> true,'autocomplete'=>'off')) }}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('company_name','Company Name') }}
                                {{ 
                                    Form::text('company_name','', [
                                       'id'      => 'company_name',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter Company name',
                                       'required' => 'required'
                                    ])
                                }}
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('company_url','Company URL') }}
                                {{ 
                                    Form::url('company_url','', [
                                        'id'      => 'company_url',
                                        'class'    =>"form-control",
                                        'placeholder'=>'Enter company url',
                                        'required' => 'required'
                                    ])
                                }}
                                @error('company_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                           
                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('crawl','Site Crawl') }}
                                {{ Form::select('crawl',['' => 'Select crawl','active' => 'Active', 'inactive' => 'Inactive'],'inactive', ['id'=>'Crawl','class'=>'form-control', 'required' => 'required']) }}
                                @error('crawl')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <div style="float: left; width: 90%;">
                                    {{ Form::label('site_color','Site Color') }}
                                    {{ 
                                        Form::text('site_color','', [
                                            'id'      => 'SiteSiteColor',
                                            'class'    =>"form-control",
                                            'placeholder'=>'Site Color',
                                            'required' => 'required'
                                        ])
                                    }}
                                </div>
                                <div id="color-box" >
                                    <div style="background-color: rgb(0, 0, 0); height: 32px;">&nbsp;</div>
                                </div>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('site_type','Site Type') }}
                                {{ Form::select('site_type',['normal' => 'Normal', 'rss' => 'RSS Feed'],null, ['id'=>'Site_type','class'=>'form-control','required' => 'required']) }}
                                @error('site_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('crawl_interval','Crawl Interval(in mins)') }}
                                {{ 
                                    Form::text('crawl_interval','30', [
                                        'id'      => 'crawl_interval',                                            
                                        'class'    =>"form-control",
                                        'required' => 'required'
                                    ])
                                }}
                                @error('crawl_interval')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
        
                            <div class="col-md-6 form-group mb-3 selector-container">
                                {{ Form::label('crawl_depth','Crawl Depth') }}
                                {{ Form::select('crawl_depth',['1' => 'Glance', '2' => 'Moderate','3' => 'Deep'],null, ['id'=>'Site_type','class'=>'form-control', 'required' => 'required']) }}
                                @error('crawl_depth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                          

                            <div class="col-md-6 form-group mb-3 selector-container">
                                {{ Form::label('selector','Selector') }}
                                {{ Form::select('selector',['id' => 'ID', 'class' => 'Class','tag' => 'Tag'],null, ['class'=>'form-control','placeholder'=> 'Select any Selector','required' => 'required']) }}
                            </div>

                            <div class="col-md-6 form-group mb-3 selector-container">
                                {{ Form::label('selector_value','Selector Value') }}
                                {{ 
                                    Form::text('selector_value','', [
                                        'id'      => 'selector_value',
                                        'class'    =>"form-control",
                                        'placeholder'=>'Selector Value',
                                        'required' => 'required',
                                    ])
                                }}
                            </div>
                                                         
                            <div class="col-md-6 form-group mb-3">
                            {{ Form::label('departments','Select Categories') }}
                                {{ Form::hidden('department_id','', array('id' => 'department_id')) }}
                                <div class="department" id="multi"></div>
                            </div>
                           
                            <div class="col-md-12 form-group mb-3">
                                {{ Form::submit('Submit', array('class' => 'btn btn-primary ladda-button example-button m-1','data-style' => 'expand-right')) }}
                                <button type="button" class="btn btn-default m-1" onclick="window.location='{{ route('sites.index') }}'">Cancel</button>
                            </div>
                            
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script type="text/javascript" src="{{asset('assets/js/vendor/colorpicker.js')}}"></script>
@endsection

@section('bottom-js')
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
<script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/multiselect/multi.select.js')}}"></script>

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
@endsection
