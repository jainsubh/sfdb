@extends('admin::layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
<style>
    .event_crawl {
        float: right;
        line-height: 37px;
        padding: 2px;
    }
    
    .progress_container{
        float: right;
        position: relative;
        display: block;
        width: 200px;
        padding: 5px;
        line-height:16px;
    }

    .progress_message{
        width: 200px;
        text-align:center;
        float:left;
    }
</style>
@endsection

@section('main-content')

    <div class="breadcrumb">
        <h1>Manage Events</h1>
        <ul>
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li>Events</li>
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
                        <th scope="col" style="width: 30%">keywords</th>
                        <th scope="col">Crawl Type</th> 
                        <th scope="col">sectors</th>  
                        <th scope="col">Status</th>  
                        <th scope="col" style="text-align:center">Start Date</th>  
                        <th scope="col" style="text-align:center">End Date</th>  
                        <th scope="col" style="text-align:center">Created By</th>
                        <th scope="col" style="text-align:center">Modified By</th>                       
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
    <script src="{{asset('assets/js/toastr.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var editor; // use a global for the submit and return data rendering in the examples
            // alternative pagination
            var table = $('#datatable').DataTable({
                'ajax': '{!! route("events.datatable") !!}',
                "ordering": false,
                columns:[
                    { data: 'name'},
                    { data: 'match_condition'},
                    { data: 'crawl_type'},
                    { data: 'sectors'},
                    { data: 'status'},
                    { data: 'start_date',
                      render: function(data) { 
                        if(data) 
                            return data 
                        else 
                            return '--'
                        }
                    },
                    { data: 'end_date',
                      render: function(data) { 
                        if(data) 
                            return data 
                        else 
                            return '--'
                        }
                    },
                    { data: 'created_by_user.name',
                      render: function(data) { 
                        if(data) 
                            return data 
                        else 
                            return '--'
                        }
                    },
                    { data: 'modified_by_user.name',
                      render: function(data) { 
                        if(data) 
                            return data 
                        else 
                            return '--'
                        }
                    },
                ],
                
                select: true,
                dom: 'Bfrtip',
                columnDefs: [ { className: 'text-center' ,'targets': [5,6,7,8] } ],
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
                               window.location = '{!! route("events.create") !!}';
                            }
                        },
                        {
                            text: '<i class="fas fa-pen"></i> &nbsp Edit',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                window.location = "events/"+row_data.id+"/edit";                          
                            },
                            enabled: false
                        },
                        {
                            text: '<i class="fas fa-trash-alt"></i> &nbsp Delete',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                confirmDelete("events/"+row_data.id, dt);
                            },
                            enabled:false
                        },
                        {
                            text: '<i class="fas fa-spider"></i> &nbsp Immediate Crawling',
                            action: function ( e, dt, node, config ) {           
                                var row_data = dt.row( { selected: true } ).data();  
                                var id = row_data.id;              
                                $.ajax({
                                    url: "{{ route('events.immediate_crawl', '') }}/"+id,
                                    type: 'PUT',
                                    dataType: 'json',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "id": id
                                    },
                                    success: function(result){
                                        if(result.status == 'Success'){
                                            dt.row( { selected: true } ).data(result.data).draw();
                                            dt.row( { selected: true } ).deselect();
                                            toastr.success(result.message);
                                        }
                                    },
                                    
                                    error: function(response){
                                        toastr.error(JSON.parse(response.responseText));
                                    }
                                })
                            },
                            enabled: false
                        }
                    ]
                }
            });

            table.on( 'select deselect', function () {
                var selectedRows = table.rows( { selected: true } ).count();
                var selectedData = table.rows( { selected: true } ).data();
                //console.log(selectedData);
                table.button( 1 ).enable( selectedRows === 1 );
                table.button( 2 ).enable( selectedRows === 1 );
                
                $('#datatable_wrapper .bt-container .event_crawl').remove();
                $('#datatable_wrapper .bt-container .progress_container').remove();
                if (selectedRows == 1){
                    console.log(selectedData[0]);
                    if(selectedData[0]['status'] == 'active' && selectedData[0]['event_lock'] == 0){
                        table.button( 3 ).enable( selectedRows === 1 );
                        if(selectedData[0]['crawl_log'] && selectedData[0]['crawl_log']['status'] == 'complete'){
                            $('#datatable_wrapper .bt-container').append('<div class="event_crawl text-info">Last time crawl complete : '+selectedData[0]['crawl_log']['completed_at']+'</div>');
                        }
                    }
                    else{
                        table.button( 3 ).disable();
                        if(selectedData[0]['status'] == 'deactive'){
                            table.button( 3 ).disable( selectedRows === 1 );
                            $('#datatable_wrapper .bt-container').append('<div class="event_crawl text-danger">To immediate crawl, activate event first</div>')
                            return;
                        }
                        if(selectedData[0]['crawl_log']['status'] == 'in_queue'){
                            $('#datatable_wrapper .bt-container').append('<div class="event_crawl text-info">Crawl job in Queue</div>');
                        }else if(selectedData[0]['crawl_log']['status'] == 'in_progress'){
                            get_crawl_status(selectedData[0]['id']);
                        }
                    }
                }else{
                    table.button( 3 ).enable( selectedRows === 1 );
                }
            });

            function get_crawl_status(id){
                $.ajax({
                    url: "{{ route('events.crawl_status', '') }}/"+id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(result){
                        
                        console.log(result.data.no_of_sites);
                        console.log(result.data.site_completed);
                        console.log(result.data.status);
                        console.log(result.data.completed_at);
                        var percentage = (result.data.site_completed/result.data.no_of_sites)*100;
                        if(result.data.status == 'in_progress'){
                            $('#datatable_wrapper .bt-container').append('<div class="progress_container"><div class="progress"><div class="progress-bar" style="width: '+percentage+'%" role="progressbar" aria-valuenow="'+result.data.site_completed+'" aria-valuemin="0" aria-valuemax="'+result.data.no_of_sites+'"></div></div><span class="text-info progress_message">'+result.data.site_completed+'/'+result.data.no_of_sites+' Sites Crawled</span></div>');
                        }
                        else if(result.data.status == 'complete'){
                            table.button( 3 ).enable( selectedRows === 1 );
                            $('#datatable_wrapper .bt-container').append('<div class="event_crawl text-info">Last time crawl complete : '+result.data.completed_at+'</div>');
                        }
                    },
                    error: function(){

                    }
                });
            }
            
            
        });
    </script>
@endsection