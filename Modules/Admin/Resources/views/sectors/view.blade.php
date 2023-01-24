
@extends('admin::layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')

    <div class="breadcrumb">
        <h1>Manage Sector</h1>
        <ul>
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li>Sector</li>
        </ul>
    </div>

    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <table id="user_table" aria-describedby="user_table" class="display table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Sector</th>
                        <th scope="col">Date</th>
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
    <script type="text/javascript">
        $(document).ready(function () {
            var editor; // use a global for the submit and return data rendering in the examples
            // alternative pagination
            var table = $('#user_table').DataTable({
                'ajax': '{!! route("manage_sector.datatable") !!}',
                columns:[
                    { data: 'sector'},                 
                    {
                        data: 'created_at',
                        type: 'num',
                        render: {
                            _: 'display',
                            sort: 'timestamp'
                        }
                    }
                ],
                select: true,
                dom: 'Bfrtip',
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
                            action: function ( e, dt, node, config ) {
                                window.location = '{!! route("sectors.create") !!}'
                            }
                        },
                        {
                            text: '<i class="fas fa-pen"></i> &nbsp Edit',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                window.location = "users/"+row_data.id+"/edit";
                                
                            },
                            enabled: false
                        },
                        {
                            text: '<i class="fas fa-trash-alt"></i> &nbsp Delete',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                swal({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#0CC27E',
                                    cancelButtonColor: '#FF586B',
                                    confirmButtonText: 'Yes, delete it!',
                                    cancelButtonText: 'No, cancel!',
                                    confirmButtonClass: 'btn btn-success mr-5',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false
                                }).then(function () {
                                    $.ajax({
                                        url: "users/"+row_data.id,
                                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                                        type: 'DELETE',
                                        success: function(result) {
                                            if(result == 'success'){
                                                dt.row( { selected: true } ).remove().draw( false );
                                                toastr.success("User has been deleted");
                                            }else{
                                                toastr.error("Failed to delete user");
                                            }
                                            
                                        }
                                    });
                                }, function (dismiss) {
                                });
                            },
                            enabled: false
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