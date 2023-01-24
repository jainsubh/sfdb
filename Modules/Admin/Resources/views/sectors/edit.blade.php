<form method="post" action="{{ route('sectors.update', $sector->id) }}" enctype="multipart/form-data">
 @method('put')
    {{ csrf_field() }}
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="crudFormLabel">Sector</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
        </div>
        <div class="modal-body">
            <!-- name Form Input -->
            <div class="form-group @if ($errors->has('name')) has-error @endif">
                {!! Form::label('name', 'Sector name') !!}
                {!! Form::text('name', $sector->name, ['class' => 'form-control', 'placeholder' => 'Sector Name']) !!}
                @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <!-- Submit Form Button -->
            {!! Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
        </div>
    </div>
{!! Form::close() !!}