@extends('admin::layouts.master')

@section('before-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/tags-input/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{asset('assets/jQuery-MultiSelect/jquery.multiselect.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/calendar/datepiker.min.css')}}">
@endsection
@section('page-css')
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
@endsection
@section('main-content')
   <div class="breadcrumb">
        <h1>Add Events</h1>
        <ul>
            <li><a href="{{ route('events.index') }}">Events</a></li>
            <li>Add</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    @include('admin::layouts.errors')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Event Information</div>
                    {{ Form::open(array( 'method' => 'post','route' => 'events.store','files'=> true,'autocomplete'=>'off')) }}
                        {{ Form::hidden('created_by',auth()->user()->id, array('id' => 'created_by')) }}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('name','Event Name') }}
                                {{ 
                                    Form::text('name','', [
                                       'id'      => 'name',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter Event name',
                                       'required' => 'required'
                                    ])
                                }}
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                         

                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('departments','Select Categories') }}
                                <!-- {{ Form::hidden('department_id','', array('id' => 'department_id')) }} -->
                                <!--<div class="department" id="multi"></div>-->
                                <!--{{ Form::select('department', $departments, null , ['class' => 'department form-control', 'multiple' => 'multiple', 'required' => 'required']) }}-->
                                <select name="department_id[]" class="department" multiple required>
                                    @foreach ($departments as $id => $department) 
                                        <option value="{{$id}}" selected="selected") }}>{{$department}}</option>   
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('sectors','Select Sector') }}
                                {{ Form::select('sector_id', $sectors, null , ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select Sector']) }}
                            </div>

                            <!--
                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('search_type','Select search type') }}
                                {{ Form::select('search_type', ['and' => 'And', 'or' => 'Or'], 'and' , ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select Search Type']) }}
                            </div> -->

                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('crawl_type','Select crawl type') }}
                                {{ Form::select('crawl_type', [0 => 'Entire Website', 1 => 'Only New Articles'], 'Select crawl type' , ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select Crawl Type']) }}
                            </div>

                            <!-- Use tagInput for individual keywords 'data-role'=>'tagsinput', -->
                            <div class="col-md-6 form-group mb-3">             
                                {{ Form::label('match_condition','Keywords') }}
                                {{ 
                                    Form::textarea('match_condition','', [
                                        'id'      => 'match_condition',
                                        'class'    =>'form-control',
                                        'required' => 'required',
                                        'style' => 'height:100px'
                                    ])
                                }}
                                @error('match_condition')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>  

                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('status','Select Status') }}
                                {{ Form::select('status', ['active' => 'Active', 'deactive' => 'Deactive'], '' , ['class' => 'form-control', 'required' => 'required']) }}
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('start_date','Start Date') }}
                                {{ 
                                    Form::text('start_date','', [
                                       'id'      => 'start_date',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter start date',
                                       'required' => 'required'
                                    ])
                                }}
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>   

                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('end_date','End Date') }}
                                {{ 
                                    Form::text('end_date','', [
                                       'id'      => 'end_date',
                                       'class'    =>"form-control",
                                       'placeholder'=>'Enter end date'
                                    ])
                                }}
                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>   

                            @role('Manager|Admin|Supervisor')
                            <div class="col-md-6 form-group mb-3">
                                {{ Form::label('users','Select Assigned Analyst') }}
                                <!-- {{ Form::hidden('user_id','', array('id' => 'user_id')) }} -->
                                <!--<div class="users" id="multi"></div>-->
                                {{ Form::select('user_id[]', $users, null , ['class' => 'users form-control', 'multiple' => 'multiple', 'required' => 'required']) }}
                            </div>
                            @endrole

                        <div class="col-md-12 form-group mb-3">
                            {{ Form::submit('Submit', array('class' => 'btn btn-primary ladda-button example-button m-1','data-style' => 'expand-right')) }}
                            <button type="button" class="btn btn-default m-1" onclick="window.location='{{ route('events.index') }}'">Cancel</button>
                        </div>
                            
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')

@endsection

@section('bottom-js')
<script src="{{asset('assets/js/vendor/tags-input/bootstrap-tagsinput.js')}}"></script>
<script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('assets/jQuery-MultiSelect/jquery.multiselect.js')}}"></script>
<script src="{{asset('assets/js/vendor/calendar/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/calendar/moment.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/calendar/datepicker.min.js')}}"></script>

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

@endsection