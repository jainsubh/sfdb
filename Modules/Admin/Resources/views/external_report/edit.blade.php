<style>
    .input-group-text{
        margin-top: 6px;
        padding: .38rem .75rem;
    }
    .ui-autocomplete{
        z-index:9999;
    }
 </style>
<form method="post" action="{{ route('external_report.update', $external_report->id) }}" enctype="multipart/form-data">
    @method('put')
    {{ csrf_field() }}
    <div class="modal-header">
    <h4 class="modal-title" id="crudFormLabel">External Report</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <div class="form-group @if ($errors->has('message')) has-error @endif">
            <div class="form-group @if ($errors->has('title')) has-error @endif">
                {!! Form::label('title', 'Name/Title') !!}
                {!! Form::text('title', $external_report->title, ['class' => 'form-control', 'placeholder' => 'Name/Title for report', 'required']) !!}
                @if ($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
            </div>
            
            <div class="form-group @if ($errors->has('organization_name')) has-error @endif">
                {!! Form::label('organization_name', 'Organization Name') !!}
                {!! Form::text('organization_name', $external_report->organization_name, ['class' => 'form-control', 'placeholder' => 'Organization Name', 'required']) !!}
                @if ($errors->has('organization_name')) <p class="help-block">{{ $errors->first('organization_name') }}</p> @endif
            </div>

            <div class="form-group @if ($errors->has('organization_url')) has-error @endif">
                {!! Form::label('organization_url', 'Organization Url') !!} 
                <div class="input-group mb-3 @if ($errors->has('organization_url')) has-error @endif">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="top" title="https://www.citrix.com">
                            <em class="fas fa-question-circle"></em>
                        </button>
                    </div>
                    {!! Form::url('organization_url', $external_report->organization_url, ['class' => 'form-control', 'placeholder' => 'Eg: https://www.citrix.com/en-in']) !!}
                    @if ($errors->has('organization_url')) <p class="help-block">{{ $errors->first('organization_url') }}</p> @endif
                </div>
            </div>

            <div class="form-group @if ($errors->has('type')) has-error @endif">
                {{ Form::label('type','Select Type') }}
                {{ Form::select('type', ['external' => 'External', 'scenario' => 'Scenario'], $external_report->type  , ['class' => 'form-control']) }}
            </div>

            <div class="form-group @if ($errors->has('comments')) has-error @endif">
                {!! Form::label('comments', 'Comments') !!}
                {!! Form::text('comments', $external_report->comments , ['class' => 'form-control', 'placeholder' => 'Enter comments', 'required']) !!}
                @if ($errors->has('comments')) <p class="help-block">{{ $errors->first('comments') }}</p> @endif
            </div>

            <div class="input-group my-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="custom-file">
                    {!! Form::hidden('hidden_report', $external_report->external_report) !!}
                    {!! Form::file('external_report', ['class' => 'custom-file-input', 'id' => 'inputGroupFile01', 'aria-describedby' => "inputGroupFileAddon01"]) !!}
                    {!! Form::label('inputGroupFile01', $external_report->external_report , ['class'=>'custom-file-label']) !!}
                </div>
            </div>
            <p style="color:red">File should be only in pdf format, max size allowed 50MB</p>
            @if ($errors->has('external_report')) <p class="help-block">{{ $errors->first('external_report') }}</p> @endif
            
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!-- Submit Form Button -->
        {!! Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
    </div>
</form>

