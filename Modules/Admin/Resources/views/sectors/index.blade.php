
@extends('admin::layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')

    <div class="breadcrumb">
        <h1>Manage Sectors</h1>
        <ul>
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li>Sectors</li>
        </ul>
    </div>

    @include('admin::layouts.errors')

    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" aria-describedby="datatable" class="display table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Name</th>                       
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
    <script type="text/javascript">
        $(document).ready(function () {
            var editor; // use a global for the submit and return data rendering in the examples
            // alternative pagination
            var table = $('#datatable').DataTable({
                'ajax': '{!! route("sectors.datatable") !!}',
                "ordering": false,
                columns:[
                    { data: 'name'},
                ],
                select: true,
                dom: 'Bfrtip',
                buttons: {
                    dom: {
                        container:{
                            className: 'dt-buttons bt-container'
                        },
                        button: {
                            className: 'btn btn-primary btn-icon m-1',
                        }
                    },buttons: [
                        {
                            text: '<i class="fas fa-plus"></i> &nbsp New',
                            action: function ( e, dt, node, config ) {
                                $.ajax({
                                    url: "{{ route('sectors.create') }}",
                                    type: 'GET',
                                    success: function(result) {
                                       console.log(result);
                                       $("#crudForm .modal-content").html(result);
                                       $('#crudForm').modal('show');
                                    }
                                });
                                //window.location = '{!! route("users.create") !!}'
                            }
                        },
                        {
                            text: '<i class="fas fa-pen"></i> &nbsp Edit',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                $.ajax({
                                    url: "sectors/"+row_data.id+"/edit",
                                    type: 'GET',
                                    success: function(result) {
                                       console.log(result);
                                       $("#crudForm .modal-content").html(result);
                                       $('#crudForm').modal('show');
                                    }
                                });
                            },
                            enabled: false
                        },
                        {
                            text: '<i class="fas fa-trash-alt"></i> &nbsp Delete',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                $.ajax({
                                    url: "sectors/hasData/"+row_data.id,
                                    type: 'GET',
                                    success: function(result) {
                                       if(result.alerts > 0 || result.freeform_reports > 0){
                                            $("#crudForm .modal-content").html(result.html);
                                            $('#crudForm').modal('show');
                                       }else{
                                            confirmDelete("sectors/"+row_data.id, dt);
                                       }
                                    }
                                });
                                
                            },
                            enabled:false
                        }
                    ]
                }
            });

            table.on( 'select deselect', function () {
                var selectedRows = table.rows( { selected: true } ).count();
                table.button( 1 ).enable( selectedRows === 1 );
                table.button( 2 ).enable( selectedRows === 1 );
            });
            
        });
    </script>
@endsection