
@extends('admin::layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />

<style>
    .form-group label{
        margin-top:6px;
        margin-bottom:6px;
    }
    .fas{
        font-size:17px;
    }
    .far{
        font-size:17px;
    }
    table.dataTable tbody td {
        word-break: break-word;
    }
    .pull-right{
        float:left;
    }
</style>
@endsection

@section('main-content')

    <div class="breadcrumb">
        <h1>Institutional Report</h1>
        <ul>
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li>Manage Institutional Report</li>
        </ul>
    </div>

    @include('admin::layouts.errors')

    <!-- Modal -->
    <div class="modal fade" id="crudForm" tabindex="-1" role="dialog" aria-labelledby="crudFormLabel" data-toggle="modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" aria-describedby="datatable" class="display table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Name/Title</th>
                        <th scope="col">Institute Name</th>
                        <th scope="col">Institute Type</th>
                        <th scope="col">Institution Report</th>
                        <th scope="col">Report Date and Time</th>
                    </tr>
                </thead>
                </table>
            </div>
        </div>
    </div>
    
    <!-- end of col -->
@endsection


@section('page-js')

    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <!-- Js for date time picker -->
    <script src="{{asset('assets/js/vendor/calendar/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/calendar/moment.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // alternative pagination
            var table = $('#datatable').DataTable({
                ajax: '{!! route("institution_report.datatable") !!}',
                ordering: false,
                serverSide: true,
                processing: true,
                columns:[
                    { 
                        data: 'name',
                        render: function(data, type, full, meta){
                            return decodeURIComponent(data);
                        }
                    },
                    { data: 'institute_name'},
                    { data: 'type',
                        "render": function ( data, type, full, meta ) {
                            if(data == 0)
                                return '<span class="badge badge-info m-2">Manual</span>';
                            else    
                                return '<span class="badge badge-warning m-2">Automatic</span>';
                        }
                    },
                    { data: 'institution_report',
                        "render": function ( data, type, full, meta ) {
                            var class_name = '';
                            if(data.send_library == 1){
                                class_name = 'fas fa-book';
                            }
                            
                            var report =  '<i class="fas fa-file-pdf" style="color: red; font-size: 18px;"></i> &nbsp;'+data.name+' ';
                            report += '<a href="'+data.download_pdf+'" class="report_download">&nbsp;<i class="fas fa-download"></i></a> &nbsp;';
                            report += '<a href="'+data.download_txt+'"><i class="far fa-file-alt"></i></a> &nbsp;';
                            report += '<a href="javascript:void(0)"><i id="is_library_'+data.name+'" class="'+class_name+'"></i></a>';
                            return report;
                        }
                    },
                    { data: 'date_time'}
                ],
                select: true,
                dom: 'Bfrtip',
                order: [[ 4, "desc" ]],
                buttons: {
                    dom: {
                        container:{
                            className: 'dt-buttons bt-container'
                        },
                        button: {
                            className: 'btn btn-primary btn-icon m-1'
                        }
                    },buttons: [
                        {
                            text: '<i class="fas fa-plus"></i> &nbsp New',
                            action: function (e, node, config){
                                $.ajax({
                                    url: "{{ route('institution_report.create') }}",
                                    type: 'GET',
                                    success: function(result) {
                                       $("#crudForm .modal-content").html(result);
                                       $('#crudForm').modal('show');
                                        $("input[id$=date_time]").datetimepicker({
                                            dateFormat:'yy-mm-dd',
                                            timeFormat:'HH:mm:ss'
                                        });
                                        $('#inputGroupFile01').on('change',function(){
                                            //get the file name
                                            var filename = $('input[type=file]').val().split('\\').pop();
                                            //replace the "Choose a file" label
                                            $(this).next('.custom-file-label').html(filename);
                                        });
                                    }
                                });
                            }
                        },
                        {
                            text: '<i class="fas fa-pen"></i> &nbsp Edit',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                $.ajax({
                                    url: "institution_report/"+row_data.id+"/edit",
                                    type: 'GET',
                                    success: function(result) {
                                       console.log(result);
                                       $("#crudForm .modal-content").html(result);
                                       $('#crudForm').modal('show');
                                       $("input[id$=date_time]").datetimepicker({
                                            dateFormat:'yy-mm-dd',
                                            timeFormat:'HH:mm:ss'
                                        });
                                        $('#inputGroupFile01').on('change',function(){
                                            //get the file name
                                            var filename = $('input[type=file]').val().split('\\').pop();
                                            //replace the "Choose a file" label
                                            $(this).next('.custom-file-label').html(filename);
                                        });
                                    }
                                });
                            },
                            enabled: false
                        },
                        {
                            text: '<i class="fas fa-trash-alt"></i> &nbsp Delete',
                            action: function ( e, dt, node, config ) {
                                if(dt.rows({ selected: true }).count() > 1)
                                {
                                    var data = dt.rows( { selected: true } ).data().pluck('id');
                                    var ids = [];
                                    for(var i=0; i < dt.rows({ selected: true }).count(); i++) {
                                        ids.push(data[i]);
                                    }
                                    confirmDelete("institution_report/"+ids, dt);
                                }
                                else{
                                    var row_data = dt.row( { selected: true } ).data();
                                    confirmDelete("institution_report/"+row_data.id, dt);
                                }
                            },
                            enabled: false
                        },
                        {
                            text: '<i class="fas fa-book"></i> &nbsp Move to Library',
                            action: function ( e, dt, node, config ) {
                                if(dt.rows({ selected: true }).count() > 1)
                                {
                                    var row_data = dt.rows( { selected: true } ).data();
                                    var data = dt.rows( { selected: true } ).data().pluck('id');
                                    var id = [];
                                    for(var i=0; i < dt.rows({ selected: true }).count(); i++) {
                                        id.push(data[i]);
                                    }
                                }
                                else{
                                    var row_data = dt.row( { selected: true } ).data();
                                    var id = row_data.id
                                }
                                $.ajax({
                                    url: "institution_report/move_to_library/"+id,
                                    type: 'PUT',
                                    dataType: 'json',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "id": id
                                    },
                                    success: function(result) {
                                        console.log(result);
                                        if(result.status == 'Success'){
                                            if(dt.rows({ selected: true }).count() > 1)
                                            {
                                                dt.rows( { selected: true } ).deselect();
                                                $.each(row_data, function(index){
                                                    row_data[index].send_library = 1;
                                                    row_data[index].institution_report.send_library = 1;
                                                    $('#is_library_'+row_data[index].institution_report.name).addClass('fas fa-book');
                                                    
                                                });
                                                toastr.success("Instituion Reports has been send to library");
                                            }
                                            else{
                                                dt.row( { selected: true } ).deselect();
                                                row_data.send_library = 1;
                                                row_data.institution_report.send_library = 1;
                                                $('#is_library_'+row_data.institution_report.name).addClass('fas fa-book');
                                                toastr.success("Instituion Report has been send to library");
                                            }
                                                
                                        }
                                    },
                                    error: function(data, textStatus, jqXHR){
                                        if(data.responseJSON.status == 'Error'){
                                            toastr.error(data.responseJSON.message);
                                        }
                                    }
                                });
                            },
                            enabled: false
                        },
                        {
                            text: '<i class="fas fa-archive" aria-hidden="true"></i> &nbsp Archive',
                            action: function ( e, dt, node, config ) {
                                if(dt.rows({ selected: true }).count() > 1)
                                {
                                    var data = dt.rows( { selected: true } ).data().pluck('id');
                                    var ids = [];
                                    for(var i=0; i < dt.rows({ selected: true }).count(); i++) {
                                        ids.push(data[i]);
                                    }
                                }
                                else{
                                    var row_data = dt.row( { selected: true } ).data();
                                    var ids = row_data.id;
                                }
                                $.ajax({
                                    url: "{{ route('institution_report.archive', '') }}/"+ids,
                                    type: 'PUT',
                                    dataType: 'json',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "id": ids
                                    },
                                    success: function(result) {
                                        console.log(result);
                                        if(result.status == 'Success'){
                                            if(dt.rows({ selected: true }).count() > 1)
                                                dt.rows( { selected: true } ).remove().draw();
                                            else
                                                dt.row( { selected: true } ).remove().draw( false );
                                            toastr.success(result.message);
                                        }
                                    },
                                    error: function(data, textStatus, jqXHR){
                                        if(data.responseJSON.status == 'Error'){
                                            toastr.error(data.responseJSON.message);
                                        }
                                    }
                                });
                            },
                            enabled: false
                        }
                    ]
                },
                autoWidth: false,
                columnDefs: [
                    { width: 500, targets: 0 },
                    {targets: [2,4], "searchable": true}
                ],
                fixedColumns: true
            });

            $('<label class="pull-right" style="width: 154px; margin-left: 15px;">'+
                '<select id="search_type" class="form-control">'+
                '<option value="">Select Type</option>'+
                '<option value="0">Manual</option>'+
                '<option value="1">Automatic</option>'+
                '</select>'+ 
                '</label>'+
                '<button type="reset" id="reset" class="form-control" style="float:left; width:82px; cursor:pointer; margin-left:15px">Reset All</button>')
            .appendTo("#datatable_wrapper .dataTables_filter"); //example is our table id

            $(".dataTables_filter label").addClass("pull-right");
            $(".pull-right input").attr("style","height:33px");

            $("#search_type").on('change',function(e){
                table.column(2).search($(this).val()).draw();
            });

            $("#reset").on('click', function(e){
                /*$(".dataTables_filter input").val("");
                $(".dataTables_filter select").prop('selectedIndex',0);*/
                location.reload();
            });
            

            table.on( 'select deselect', function (e, dt, node, config) {
                var selectedRows = table.rows( { selected: true } ).count();
                var row_data = dt.row( { selected: true } ).data();
                table.button( 1 ).enable( selectedRows == 1 );
                table.button( 2 ).enable( selectedRows >= 1 );
                table.button( 3 ).enable( selectedRows >= 1 );
                table.button( 4 ).enable( selectedRows >= 1 );
                
                if(typeof row_data != 'undefined')
                    table.button( 3 ).enable( row_data.send_library === 0 && selectedRows > 0);
                else
                    table.button( 3 ).enable( selectedRows === 1 );
                
            });
        });

    </script>
@endsection