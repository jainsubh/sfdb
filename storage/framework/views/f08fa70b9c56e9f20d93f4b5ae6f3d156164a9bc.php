<?php $__env->startSection('page-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/datatables.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/sweetalert2.min.css')); ?>">
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div class="breadcrumb">
        <h1>External Reports</h1>
        <ul>
            <li><a href="<?php echo e(route('dashboard.index')); ?>">Dashboard</a></li>
            <li>Manage External Reports</li>
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
                <table id="datatable" aria-describedby="datatable" class="display table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Name/Title</th>
                        <th scope="col">Organization Name</th>
                        <th scope="col">Organization URL</th>
                        <th scope="col">Report Type</th>
                        <th scope="col">Comments</th>
                        <th scope="col">External Report</th>
                        <th scope="col">Uploaded By</th>
                        <th scope="col">Upload Date & Time</th>
                        <th scope="col">Modified Date & Time</th>
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
    <!-- Js for date time picker -->
    <script src="<?php echo e(asset('assets/js/vendor/calendar/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/vendor/calendar/moment.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // alternative pagination
            var table = $('#datatable').DataTable({
                ajax: '<?php echo route("external_report.datatable"); ?>',
                ordering: false,
                serverSide: true,
                processing: true,
                columns:[
                    { data: 'title',},
                    { data: 'organization_name'},
                    { data: 'organization_url'},
                    { data: 'type', 
                        render: function(data) { 
                        if(data == 'external' || data == '') 
                            return 'External'
                        else if(data == 'scenario') 
                            return 'Scenario'
                        else
                            return '--'
                        } 
                        
                    },
                    { data: 'comments'},
                    { data: 'external_report'},
                    { data: 'uploaded_by'},
                    { data: 'created_at'},
                    { data: 'updated_at'}
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
                            action: function (e, node, config){
                                $.ajax({
                                    url: "<?php echo e(route('external_report.create')); ?>",
                                    type: 'GET',
                                    success: function(result) {
                                        $("#crudForm .modal-content").html(result);
                                        $('#crudForm').modal('show');
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
                                    url: "external_report/"+row_data.id+"/edit",
                                    type: 'GET',
                                    success: function(result) {
                                       console.log(result);
                                       $("#crudForm .modal-content").html(result);
                                       $('#crudForm').modal('show');
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
                                    confirmDelete("external_report/"+ids, dt);
                                }
                                else{
                                    var row_data = dt.row( { selected: true } ).data();
                                    confirmDelete("external_report/"+row_data.id, dt);
                                }
                            },
                            enabled: false
                        }
                    ]
                },
                autoWidth: false,
                columnDefs: [
                    { width: 500}
                ],
                fixedColumns: true
            });

            table.on( 'select deselect', function (e, dt, node, config) {
                var selectedRows = table.rows( { selected: true } ).count();
                var row_data = dt.row( { selected: true } ).data();
                table.button( 1 ).enable( selectedRows == 1 );
                table.button( 2 ).enable( selectedRows >= 1 );
                
                
            });
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/external_report/index.blade.php ENDPATH**/ ?>