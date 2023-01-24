<?php $__env->startSection('before-css'); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-css'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/apexcharts.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

     <div class="breadcrumb">
                    <h1>ApexCharts</h1>
                    <ul>
                        <li><a href="">Charts</a></li>
                        <li>Apex Scatter Charts</li>
                    </ul>
                </div>

                <div class="separator-breadcrumb border-top"></div>

                <div class="row">
                    <div class=" col-md-6 col-lg-6 col-sm-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Simple Scatter Chart</div>
                                <div id="simpleScatter"></div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-md-6 col-lg-6 col-sm-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Scatter – Datetime Chart</div>
                                <div id="scatterDatetime"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end of row -->



<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>



    <script src="<?php echo e(asset('assets/js/vendor/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/vendor/apexcharts.dataseries.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/es5/apexScatterChart.script.min.js')); ?>"></script>





<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/charts/apexScatterCharts.blade.php ENDPATH**/ ?>