<style>
    .input-group-text{
        margin-top: 6px;
        padding: .38rem .75rem;
    }
    .ui-autocomplete{
        z-index:9999;
    }
 </style>
<form method="post" action="{{ route('institution_report.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
    <h4 class="modal-title" id="crudFormLabel">Institution Report</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        
        <!-- name Form Input -->
        <div class="form-group @if ($errors->has('message')) has-error @endif">
            {!! Form::label('name', 'Name/Title') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name/Title for report', 'required']) !!}
            @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
            
            <div class="ui-widget">
                {!! Form::label('institute_name', 'Organization Name') !!}
                {!! Form::text('institute_name', null , ['class' => 'form-control','placeholder'=> 'Select organisation name','required']) !!}
                @if ($errors->has('institute_name')) <p class="help-block">{{ $errors->first('institute_name') }}</p> @endif
                {!! Form::hidden('institute_id', null, ['id' => 'institute_id']) !!}
            </div>

            {!! Form::label('date_time', 'Select Date Time') !!}
            {!! Form::text('date_time', null, ['class' => 'date form-control','autocomplete' => 'off','style' => 'margin-bottom:15px', 'placeholder' => 'Select Date and Time', 'required']) !!}
            @if ($errors->has('date_time')) <p class="help-block">{{ $errors->first('date_time') }}</p> @endif

            <div class="input-group my-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="custom-file">
                    {!! Form::file('institution_report', ['class' => 'custom-file-input', 'id' => 'inputGroupFile01', 'aria-describedby' => "inputGroupFileAddon01"]) !!}
                    {!! Form::label('inputGroupFile01', 'Choose a file', ['class'=>'custom-file-label']) !!}
                </div>
            </div>
            <p style="color:red">File should be only in pdf format, max size allowed 50MB</p>
            @if ($errors->has('institution_report')) <p class="help-block">{{ $errors->first('institution_report') }}</p> @endif

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!-- Submit Form Button -->
        {!! Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button']) !!}
    </div>
</form>
<script type="text/javascript">
    $(function() {
        var organisation_name = <?php echo $organisation_name ?>;
        
        $("input[id$=institute_name]").autocomplete({
            source: organisation_name,
            minLength: 0,
            success: function( data ) {
                response( 
                    $.map( data.d, function( item ) {
                        return {
                            label: item.label, 
                            value: item.value
                        }
                    }
                ));
            },
            select: function(event, ui) {
                event.preventDefault();
                $("#institute_name").val(ui.item.label);
                $("#institute_id").val(ui.item.value);  
            }
        }).on('focus', function(){
            $(this).autocomplete("search", "");
        });
    }); 
</script>
