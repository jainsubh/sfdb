<form method="post" action="{{ route('sectors.changeSector', $sector->id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="crudFormLabel">Sector</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <!-- name Form Input -->
            <div class="form-group">
                There are <strong>{{ $sector->alerts->count() }} alerts</strong> and <strong>{{ $sector->freeform_reports->count() }} freeform reports</strong> found using this sector. </b>
            </div>
            <div class="form-group">
                {{ Form::label('sectors','Reassign another Sector to alerts or freeform reports') }}
                {{ Form::select('sector_id', $sectors, $sector->id , ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select Sector']) }}
                {{ Form::hidden('old_sector_id', $sector->id, array('id' => 'old_sector_id')) }}
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <!-- Submit Form Button -->
            {!! Form::button('Reassign and Delete', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
        </div>
    </div>
{!! Form::close() !!}