<?php $__env->startSection('page-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/datatables.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/sweetalert2.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div class="breadcrumb">
        <h1>Manage Deactivated Users</h1>
        <ul>
            <li><a href="<?php echo e(route('dashboard.index')); ?>">Dashboard</a></li>
            <li>Deactivated Users</li>
        </ul>
    </div>

    <?php echo $__env->make('admin::layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <table id="user_table" aria-describedby="user_table" class="display table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone No.</th>
                        <th scope="col">User Role</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Deactivate Date</th>
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
            var table = $('#user_table').DataTable({
                'ajax': '<?php echo route("users.deleted_user_datatable"); ?>',
                columns:[
                    { data: 'name'},
                    { data: 'email'},
                    { data: 'phone_no' },
                    { data: 'roles' },
                    {
                        data: 'created_at',
                        type: 'num',
                        render: {
                            _: 'display',
                            sort: 'timestamp'
                        }
                    },
                    {
                        data: 'deleted_at',
                        type: 'num',
                        render: {
                            _: 'display',
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
                            text: '<i class="fa fa-undo"></i> &nbsp Restore',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                confirmRestore("restore/"+row_data.id, dt);
                            },
                            enabled: false
                        }
                    ]
                }
            });

            table.on( 'select deselect', function () {
                var selectedRows = table.rows( { selected: true } ).count();
                table.button( 0 ).enable( selectedRows === 1 );
            });
            
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/user/deleted_user.blade.php ENDPATH**/ ?>