<form method="post" action="{{ route('departments.changeDepartment', $department->id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="crudFormLabel">Department</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <!-- name Form Input -->
            <div class="form-group">
                There are <strong>{{ $department->sites->count() }} sites</strong> and <strong>{{ $department->events->count() }} events</strong> found using this department. </b>
            </div>
            <div class="form-group">
                {{ Form::label('departments','Reassign another department to sites or events') }}
                {{ Form::select('department_id', $departments, $department->id , ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select Department']) }}
                {{ Form::hidden('old_department_id', $department->id, array('id' => 'old_department_id')) }}
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <!-- Submit Form Button -->
            {!! Form::button('Reassign and Delete', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
        </div>
    </div>
{!! Form::close() !!}