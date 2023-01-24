<form method="post" action="{{ route('organization_url.update', $organization_url->id) }}" enctype="multipart/form-data">
 @method('put')
    {{ csrf_field() }}
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="crudFormLabel">Organization URL</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
        </div>
        <div class="modal-body">
            <!-- name Form Input -->
            <div class="form-group @if ($errors->has('name')) has-error @endif">
                {!! Form::label('name', 'Organization Name') !!}
                {!! Form::text('name', $organization_url->name, ['class' => 'form-control', 'placeholder' => 'Organization Name', 'required']) !!}
                @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
            </div>
            <div class="form-group @if ($errors->has('url')) has-error @endif">
                {!! Form::label('url', 'Organization Url') !!} 
                <div class="input-group mb-3 @if ($errors->has('url')) has-error @endif">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="top" title="https://www.citrix.com">
                            <em class="fas fa-question-circle"></em>
                        </button>
                    </div>
                    {!! Form::url('url', $organization_url->url, ['class' => 'form-control', 'placeholder' => 'Eg: https://www.citrix.com/en-in', 'required']) !!}
                    @if ($errors->has('url')) <p class="help-block">{{ $errors->first('url') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <!-- Submit Form Button -->
            {!! Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
        </div>
    </div>
{!! Form::close() !!}

