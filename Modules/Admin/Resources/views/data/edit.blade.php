<form method="post" action="{{ route('data.update', $data->id) }}" enctype="multipart/form-data">
 @method('put')
    {{ csrf_field() }}
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="crudFormLabel">{{ $data->name }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
        </div>
        <div class="modal-body">
            <!-- name Form Input -->
            <div class="form-group @if ($errors->has('name')) has-error @endif">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', $data->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
            </div>
            {{ Form::hidden('dataset_id', $data->id) }}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <!-- Submit Form Button -->
            {!! Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
        </div>
    </div>
{!! Form::close() !!}