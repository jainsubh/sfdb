
@extends('admin::layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />

<style>
    .badge{
        font-weight: 600;
        font-size: 12px;
    }
    .swal-footer{
        text-align: center;
    }
    .swal-button-container{
        margin: 14px;
    }

    .swal-button:not([disabled]):hover{
        background-color: #024495 !important;
    }

    .btn-danger:not([disabled]):hover{
        background-color: #ef2415 !important;
    }
</style>
@endsection

@section('main-content')

    <div class="breadcrumb">
        <h1>
            @role('Manager|Admin|Supervisor')
                Task Audit
            @endrole
            @role('Analyst')
                Manage Tasks
            @endrole
        </h1>
        <ul>
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li>
                @role('Manager|Admin|Supervisor')
                    Task Audit
                @endrole
                @role('Analyst')
                    Manage Tasks
                @endrole
            </li>
        </ul>
    </div>

    @include('admin::layouts.errors')

    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" aria-describedby="datatable" class="display table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col" style="width:400px" data-orderable="false">Name</th>  
                        <th scope="col" style="width:100px">Type</th> 
                        <th scope="col" style="width:100px">Status</th> 
                        <th scope="col" style="width:100px">Priority</th>  
                        @role('Admin|Manager|Supervisor')
                        <th scope="col" style="width:170px">Analyst assigned</th> 
                        @endrole  
                        <th scope="col" style="width:150px">Created At</th>  
                        <th scope="col" style="width:150px">Due Date</th> 
                        <th scope="col" style="width:150px">Modified At</th>  
                        <th scope="col" style="width:150px; text-align:center">Completed At</th>                       
                    </tr>
                </thead>
                </table>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="crudForm" tabindex="-1" role="dialog" aria-labelledby="crudFormLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!-- end of col -->
@endsection


@section('page-js')
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
    
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script type="text/javascript">
        
        $(document).ready(function () {
            
            var editor; // use a global for the submit and return data rendering in the examples
            // alternative pagination
            var table = $('#datatable').DataTable({
                'ajax': '{!! route("tasks.datatable") !!}',
                ordering: true,
                serverSide: true,
                processing: true,
                columns:[
                    { data: 'title', searchable: false},
                    { data: 'subject_type'},
                    { data: 'status'},
                    { data: 'priority', render: function ( data, type, row, meta ) {
                            if(data == 'low'){
                                return '<span class="badge badge-success m-2">'+ucwords(data)+'</span>';
                            }else if(data == 'medium'){
                                return '<span class="badge badge-warning m-2">'+ucwords(data)+'</span>';
                            }else{
                                return '<span class="badge badge-danger m-2">'+ucwords(data)+'</span>';
                            }
                        }
                    },
                    @role('Admin|Manager|Supervisor')
                    { data: 'latest_task_log.assigned_to_user.name',
                      "render": function(data){
                          if(data)
                            return data;
                          else
                            return "--";
                      }
                    },
                    @endrole
                    {
                        data: 'created_at',
                        "render": function (data) {
                            var date = dateToTimestamp(data);
                            return unixToDateTime(date);
                        }
                    },
                    { data: 'due_date'},
                    {
                        data: 'updated_at',
                        "render": function (data) {
                            var date = dateToTimestamp(data);
                            return unixToDateTime(date);
                        }
                    },
                    {
                        data: 'completed_at',
                        "render": function (data) {
                            if(data == null )
                                return '--';
                            else{
                                var date = dateToTimestamp(data);
                                return unixToDateTime(date);
                            }
                        }
                    },
                ],
                select: true,
                dom: 'Bfrtip',
                @role('Manager|Admin|Supervisor')
                    columnDefs: [ { type: 'date', 'targets': [5,6,7,8] },  { className: 'text-center', 'targets': [8] } ],
                    order: [[7, "desc"]],
                @endrole
                @role('Analyst')
                    columnDefs: [ { type: 'date', 'targets': [4,5,6,7] },  { className: 'text-center', 'targets': [7] } ],
                    order: [[6, "desc"]],
                    buttons: {
                        dom: {
                            container:{
                                className: 'dt-buttons bt-container'
                            },
                            button: {
                                className: 'btn btn-primary btn-icon m-1',
                            }
                        },
                        buttons: [
                            {
                                text: '<i class="fas fa-file-pdf"></i> &nbsp Generate Report',
                                action: function ( e, dt, node, config ) {
                                    
                                    var row_data = dt.row( { selected: true } ).data();
                                    console.log(row_data);
                                    if(row_data.subject_type == 'institution_report'){
                                        if(row_data.fully_manual == null){
                                            generate_report(row_data.id);
                                        }else if(row_data.fully_manual.status == 'complete'){
                                            console.log('status complete');
                                        }else{
                                            var url = "{{ route('fully_manual.edit', ':id') }}";
                                            fully_manual_edit_url = url.replace(':id', row_data.fully_manual.id);
                                            window.location.href = fully_manual_edit_url;
                                        }
                                    }else if(row_data.subject_type == 'external_report'){
                                        if(row_data.fully_manual == null){
                                            generate_report(row_data.id);
                                        }else if(row_data.fully_manual.status == 'complete'){
                                            console.log('status complete');
                                        }else{
                                            var url = "{{ route('fully_manual.edit', ':id') }}";
                                            fully_manual_edit_url = url.replace(':id', row_data.fully_manual.id);
                                            window.location.href = fully_manual_edit_url;
                                        }
                                    }else if(row_data.subject_type == 'freeform_report'){
                                        window.location.href = "{{ route('freeform_report.report_create', '') }}/"+row_data.subject.id;
                                    }else{
                                        var semi_button_visibile = false;
                                        var manual_button_visibile = false;

                                        if(row_data.fully_manual == null){
                                            manual_button_visibile = true;
                                        }else if(row_data.fully_manual.status != 'complete'){
                                            manual_button_visibile = true;
                                        }

                                        if(row_data.semi_automatic == null){
                                            semi_button_visibile = true;
                                        }else if(row_data.semi_automatic.status != 'complete'){
                                            semi_button_visibile = true
                                        }

                                        if(semi_button_visibile == false && manual_button_visibile == false){
                                            toastr.error('Reports has already been generated');
                                        }
                                        else{
                                            swal({
                                                title: "Report Generation",
                                                text: "Please select the type of report you want to generate",
                                                icon: "info", //built in icons: success, warning, error, info
                                                closeOnEsc: true,
                                                closeOnClickOutside: true,
                                                buttons: {
                                                    confirm: {
                                                        text: "Fully Manual",
                                                        value: 'fully_manual',
                                                        visible: manual_button_visibile,
                                                        className: "btn btn-info",
                                                        closeModal: true,
                                                    },
                                                    info : {
                                                        text: "Semi Automatic",
                                                        value: 'semi_automatic',
                                                        visible: semi_button_visibile,
                                                        className: "btn btn-info",
                                                        closeModal: true,
                                                    }
                                                }
                                            }).then(function (val) {
                                                if(val == 'semi_automatic'){
                                                    window.location.href = "{{ route('semi_automatic.create') }}/task/"+row_data.id;
                                                }
                                                else if(val == 'fully_manual'){
                                                    generate_report(row_data.id);
                                                }
                                            });
                                        }
                                        
                                        
                                    }
                                    
                                },
                                enabled: false
                            },
                            {
                                text: '<i class="fas fa-file-pdf"></i> &nbsp Complete Task',
                                className: 'btn btn-danger btn-icon m-1',
                                action: function ( e, dt, node, config ) {
                                    this.buttons().disable();
                                    var row_data = dt.row( { selected: true } ).data();
                                    $.ajax({
                                        url: "{{ route('tasks.complete', '') }}/"+row_data.id,
                                        type: 'PUT',
                                        dataType: 'json',
                                        data: {"_token": "{{ csrf_token() }}"},
                                        success: function(result) {
                                            
                                            if(result.status == 'success'){
                                                dt.row( { selected: true } ).data(result.data).draw();
                                                swal({
                                                    title: "Task Completed and Send",
                                                    type: "Danger",
                                                    text: "Notification has been send to Manager",
                                                    icon: "success", //built in icons: success, warning, error, info
                                                    closeOnEsc: true,
                                                    closeOnClickOutside: true,
                                                    buttons: {
                                                        info: {
                                                            text: "Go Back to Task",
                                                            value: 'cancel',
                                                            visible: true,
                                                            className: "btn btn-danger",
                                                            closeModal: true,
                                                        },
                                                    }
                                                }).then(function (val) {
                                                    dt.row( { selected: true } ).deselect();
                                                });
                                                
                                            }
                                            else{
                                                toastr.error(result.message);
                                            }
                                        }
                                    });

                                },
                                enabled: false
                            }
                        ]
                    },
                @endrole
                
            });

             $('#datatable_wrapper .col-md-6:first-child').removeClass("col-md-6").addClass("col-md-2");
             $('#datatable_wrapper .col-md-6').removeClass("col-md-6").addClass("col-md-10");


            $('<label class="pull-right" style="width: 154px; margin-left: 15px;">'+
                '<select id="subject_type" class="form-control">'+
                '<option value="">Search Type</option>'+
                '<option value="alert">Alert</option>'+
                '<option value="institution_report">Institution Report</option>'+
                '<option value="freeform_report">Freeform Report</option>'+
                '<option value="external_report">External Report</option>'+
                '</select>'+
                '</label>'+
                '<label class="pull-right" style="width: 154px; margin-left: 15px;">'+
                '<select id="status" class="form-control">'+
                '<option value="">Search Status</option>'+
                '<option value="new">New</option>'+
                '<option value="pending">Pending</option>'+
                '<option value="complete">Completed</option>'+
                '</select>'+ 
                '</label>'+
                '<label class="pull-right" style="width: 154px; margin-left: 15px;">'+
                '<select id="priority" class="form-control">'+
                '<option value="">Search Priority</option>'+
                '<option value="low">Low</option>'+
                '<option value="medium">Medium</option>'+
                '<option value="high">High</option>'+
                '</select>'+ 
                '</label>'+                
                '<button type="reset" id="reset" class="form-control" style="float:right; width:100px; cursor:pointer; margin-left:15px">Reset All</button>')
            .appendTo("#datatable_wrapper .dataTables_filter"); //example is our table id

            $(".dataTables_filter label").addClass("pull-right");
            $(".pull-right input").attr("style","height:33px; width:150px;");

            $("#priority").on('change',function(e){
                table.column(3).search($(this).val()).draw();
            });

            $("#subject_type").on('change',function(e){
                table.column(1).search($(this).val()).draw();
            });

            $("#status").on('change',function(e){
                table.column(2).search($(this).val()).draw();
            });

            $("#reset").on('click', function(e){
                location.reload();
            });

            table.on('select deselect', function () {
                var selectedData = table.rows( { selected: true } ).data();
                var selectedRows = table.rows( { selected: true } ).count();
                //console.log(selectedData);
                if (selectedRows == 1){
                    if(selectedData[0].status === 'new' && !isReportComplete(selectedData[0]))
                        if(selectedData[0].subject_type == 'institution_report' && isManualComplete(selectedData[0]))
                            table.button( 0 ).disable( true );
                        else
                            table.button( 0 ).enable( true );

                    if(selectedData[0].status === 'complete')
                        table.button( 1 ).disable( true );
                    else if(selectedData[0].subject_type == 'institution_report' && isManualComplete(selectedData[0]))
                        table.button( 1 ).enable( true );
                    else if(isManualComplete(selectedData[0]) || isSemiComplete(selectedData[0]) || isFreeFormComplete(selectedData[0]) )
                        table.button( 1 ).enable( true );
                }
                else{
                    table.button( 0 ).disable( selectedRows === 0 );
                    table.button( 1 ).disable( selectedRows === 0 );
                }
            });

            function generate_report(task_id){
                $.ajax({
                    url: "{{ route('fully_manual.store') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}", 'task_id': task_id},
                    success: function(result) {
                        if(result.status == 'success'){
                            var url = "{{ route('fully_manual.edit', ':id') }}";
                            fully_manual_edit_url = url.replace(':id', result.data.id);
                            window.location.href = fully_manual_edit_url;
                        }
                        else{
                            toastr.error(result.message);
                        }
                    }
                });
            }

            function isManualComplete(data){
                if(data.fully_manual == null){
                    return false;
                }else if(data.fully_manual.status != 'complete'){
                    return false;
                }else{
                    return true;
                }
            }

            function isSemiComplete(data){
                if(data.semi_automatic == null){
                    return false;
                }else if(data.semi_automatic.status != 'complete'){
                    return false;
                }else{
                    return true;
                }
            }

            function isFreeFormComplete(data){
                console.log(data);
                if(data.subject == null){
                    return false;
                }else if(data.subject.status != 'complete'){
                    return false;
                }else{
                    return true;
                }
            }

            function isReportComplete(data){
                var manualReport = false;
                var semiReport = false;

                manualReport = isManualComplete(data);
                semiReport = isSemiComplete(data);

                if(manualReport == true && semiReport == true){
                    return true;
                }else{
                    return false;
                }
            }

            function ucwords (str) {
                return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                    return $1.toUpperCase();
                });
            }
        });
    </script>
    
@endsection