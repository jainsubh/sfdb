<form method="post" action="{{ route('global_dictionary.update', $dictionary->id) }}" enctype="multipart/form-data">
@csrf    
@method('put')
<div class="modal-header">
<h4 class="modal-title" id="crudFormLabel">Global Dictionary</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    
    <!-- name Form Input -->
    <div class="form-group @if ($errors->has('name')) has-error @endif">
        {!! Form::label('keywords', 'keywords') !!}
        {!! Form::text('keywords',  $dictionary->keywords, ['class' => 'form-control', 'placeholder' => 'keyword Name', 'required']) !!}
        @if ($errors->has('keywords')) <p class="help-block">{{ $errors->first('keywords') }}</p> @endif
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <!-- Submit Form Button -->
    {!! Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
</div>
</form>