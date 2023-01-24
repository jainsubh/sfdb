<?php $__env->startSection('page-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/datatables.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/sweetalert2.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div class="breadcrumb">
        <h1>Manage Categories</h1>
        <ul>
            <li><a href="<?php echo e(route('dashboard.index')); ?>">Dashboard</a></li>
            <li>Categories</li>
        </ul>
    </div>

    <?php echo $__env->make('admin::layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
<?php $__env->stopSection(); ?>


<?php $__env->startSection('page-js'); ?>
    <script src="<?php echo e(asset('assets/js/vendor/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/toastr.script.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/vendor/sweetalert2.min.js')); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var editor; // use a global for the submit and return data rendering in the examples
            // alternative pagination
            var table = $('#datatable').DataTable({
                'ajax': '<?php echo route("departments.datatable"); ?>',
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
                                    url: "<?php echo e(route('departments.create')); ?>",
                                    type: 'GET',
                                    success: function(result) {
                                       $("#crudForm .modal-content").html(result);
                                       $('#crudForm').modal('show');
                                    }
                                });
                            }
                        },
                        {
                            text: '<i class="fas fa-pen"></i> &nbsp Edit',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                $.ajax({
                                    url: "departments/"+row_data.id+"/edit",
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
                                    url: "departments/hasData/"+row_data.id,
                                    type: 'GET',
                                    success: function(result) {
                                        console.log(result);
                                       if(result.sites > 0 || result.events > 0){
                                            $("#crudForm .modal-content").html(result.html);
                                            $('#crudForm').modal('show');
                                       }else{
                                            confirmDelete("departments/"+row_data.id, dt);
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/departments/index.blade.php ENDPATH**/ ?>