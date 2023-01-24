<?php $__env->startSection('page-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/datatables.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/sweetalert2.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div class="breadcrumb">
        <h1>Free Form Report</h1>
        <ul>
            <li><a href="<?php echo e(route('dashboard.index')); ?>">Dashboard</a></li>
            <li>Manage Free Form Report</li>
        </ul>
    </div>

    <?php echo $__env->make('admin::layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                <table id="datatable" aria-describedby="datatable" class="display table" style="width:100%; table-layout: fixed;">
                <thead>
                    <tr>
                        <th scope="col" style="width:11%">Title</th>
                        <th scope="col" style="width:12%">Objective</th>
                        <th scope="col" style="width:6%">Priority</th>
                        <th scope="col" style="width:8%">Sector</th>
                        <th scope="col" style="width:8%">Assigned To</th>
                        <th scope="col" style="width:11%">FreeForm Report</th>
                        <th scope="col" style="width:11%">Due Date</th>
                        <th scope="col" style="width:11%">Created At</th>
                        <th scope="col" style="width:11%">Modified At</th>
                        <th scope="col" style="width:11%">Completed At</th>
                    </tr>
                </thead>
                </table>
            </div>
        </div>
    </div>
    
    <!-- end of col -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('page-js'); ?>

    <script src="<?php echo e(asset('assets/js/vendor/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/vendor/sweetalert2.min.js')); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var editor; // use a global for the submit and return data rendering in the examples
            // alternative pagination
            var table = $('#datatable').DataTable({
                'ajax': '<?php echo route("freeform_report.datatable"); ?>',
                "ordering": true,
                columns:[
                    { data: 'title'},
                    { data: 'objective'},
                    { data: 'priority'},
                    { data: 'sector_id'},
                    { data: 'assigned'},
                    { data: 'freeform_report',
                        "render": function ( data, type, full, meta ) {
                            var class_name = '';
                            
                            if(data.send_library == 1){
                                class_name = 'fas fa-book';
                            }

                            var report =  '<i class="fas fa-file-pdf" style="color: red; font-size: 18px;"></i> &nbsp;'+data.name+' ';
                            report += '&nbsp;<a href="javascript:void(0)"><i id="is_library_'+data.name+'" class="'+class_name+'"></i></a>';
                            
                            if(data.status == 'complete'){
                                report += '&nbsp; <a href="'+data.download_pdf+'"><i class="fas fa-download"></i></a>';
                            }

                            return report;
                        }
                    },
                    { data: 'date_time'},
                    { data: 'created_at'},
                    { data: 'updated_at'},
                    { data: 'completed_at'},
                ],
                
                select: true,
                dom: 'Bfrtip',
                order: [[7, "desc"],[8, "desc"],[9, "desc"]],
                columnDefs: [ { type: 'date', 'targets': [7,8,9] }, { className: 'text-center', 'targets': [9] } ],
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
                               window.location = '<?php echo route("freeform_report.create"); ?>';
                            }
                        },
                        {
                            text: '<i class="fas fa-pen"></i> &nbsp Edit',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                window.location = "freeform_report/"+row_data.id+"/edit";
                             
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
                                    confirmDelete("freeform_report/"+ids, dt);
                                }
                                else{
                                    var row_data = dt.row( { selected: true } ).data();
                                    confirmDelete("freeform_report/"+row_data.id, dt);
                                }
                            },
                            enabled:false
                        },
                        /*{
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
                                    url: "freeform_report/move_to_library/"+id,
                                    type: 'PUT',
                                    dataType: 'json',
                                    data: {
                                        "_token": "<?php echo e(csrf_token()); ?>",
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
                                                    row_data[index].freeform_report.send_library = 1;
                                                    $('#is_library_'+row_data[index].freeform_report.name).addClass('fas fa-book');
                                                    
                                                });
                                                toastr.success("FreeForm Reports has been send to library");
                                            }
                                            else{
                                                dt.row( { selected: true } ).deselect();
                                                row_data.send_library = 1;
                                                row_data.freeform_report.send_library = 1;
                                                $('#is_library_'+row_data.freeform_report.name).addClass('fas fa-book');
                                                toastr.success("FreeForm Report has been send to library");
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
                        },*/
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
                                    url: "<?php echo e(route('freeform_report.archive', '')); ?>/"+ids,
                                    type: 'PUT',
                                    dataType: 'json',
                                    data: {
                                        "_token": "<?php echo e(csrf_token()); ?>",
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
                }
            });

            table.on( 'select deselect', function (e, dt, node, config) {
                var selectedRows = table.rows( { selected: true } ).count();
                var row_data = dt.row( { selected: true } ).data();
                table.button( 1 ).enable( selectedRows == 1 );
                table.button( 2 ).enable( selectedRows >= 1 );
                //table.button( 3 ).enable( selectedRows >= 1 );
                table.button( 3 ).enable( selectedRows >= 1 );
                
                /*
                if(typeof row_data != 'undefined')
                    table.button( 3 ).enable( row_data.send_library === 0 && selectedRows > 0);
                else
                    table.button( 3 ).enable( selectedRows === 1 );
                */
                
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/freeform_report/index.blade.php ENDPATH**/ ?>