<?php $__env->startSection('page-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/datatables.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/sweetalert2.min.css')); ?>">
<style>
.pull-right{
        float:left;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div class="breadcrumb">
        <h1>Manage Report Log</h1>
        <ul>
            <li><a href="<?php echo e(route('dashboard.index')); ?>">Dashboard</a></li>
            <li>Report Logs</li>
        </ul>
    </div>

    <?php echo $__env->make('admin::layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <table id="report_log_table" aria-describedby="report_log_table" class="display table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Log Name</th>
                        <th scope="col">Ref Id</th>
                        <th scope="col">Description</th>
                        <th scope="col">User</th>
                        <th scope="col">User Role</th>
                        <th scope="col">Created Date</th>
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
            var table = $('#report_log_table').DataTable({
                'ajax': '<?php echo route("report_log_datatable"); ?>',
                ordering: false,
                serverSide: true,
                processing: true,
                columns:[
                    { data: 'log_name'},
                    { data: 'ref_id'},
                    { data: 'description'},
                    { data: 'causer.name', name: 'causer.name', searchable: true },
                    { data: 'user_role' },
                    { data: 'created_at'},
                ],
                select: true,
                dom: 'Bfrtip',
                order: [[ 4, "desc" ]],
                autoWidth: false,
                columnDefs: [
                    { width: 500, targets: 0 },
                    {targets: 3, "searchable": true}
                ],
                fixedColumns: true
            });

            $('<!--<label class="pull-right" style="width: 154px; margin-left: 15px;">'+
                '<select id="search_role" class="form-control">'+
                '<option value="">Select Role</option>'+
                '<option value="Admin">Admin</option>'+
                '<option value="Manager">Manager</option>'+
                '<option value="Analyst">Analyst</option>'+
                '</select>'+ 
                '</label>-->'+ 
                '<label class="pull-right" style="width: 154px; margin-left: 15px;">'+
                '<select id="search_log" class="form-control">'+
                '<option value="">Select Log</option>'+
                '<option value="login">Login</option>'+
                '<option value="logout">Logout</option>'+
                '</select>'+ 
                '</label>'+                
                '<button type="reset" id="reset" class="form-control" style="float:right; width:100px; cursor:pointer; margin-left:15px">Reset All</button>')
            .appendTo("#auth_log_table_wrapper .dataTables_filter"); //example is our table id

            $(".dataTables_filter label").addClass("pull-right");
            $(".pull-right input").attr("style","height:33px");

            $("#search_role").on('change',function(e){
                table.column(3).search($(this).val()).draw();
            });

            $("#search_log").on('change',function(e){
                table.column(0).search($(this).val()).draw();
            });

            $("#reset").on('click', function(e){
                /*$(".dataTables_filter input").val("");
                $(".dataTables_filter select").prop('selectedIndex',0);*/
                location.reload();
            });

            table.on( 'select deselect', function () {
                var selectedRows = table.rows( { selected: true } ).count();
            });
            
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/report_logs/index.blade.php ENDPATH**/ ?>