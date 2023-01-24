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
                        <li>Apex Mix Charts</li>
                    </ul>
                </div>

                <div class="separator-breadcrumb border-top"></div>

                <div class="row">
                    <div class=" col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title"> Line Column (Traffic Sources)</div>
                                <div id="lineColumn"></div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title"> Multiple Y-Axis(XYZ - Stock Analysis (2009 - 2016)) </div>
                                <div id="multipleYxis"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end of row -->

                <div class="row">
                    <div class=" col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">
                                    Line & Area(Team A VS Team B)
                                </div>

                                <div id="lineArea"></div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Line Column Area
                                </div>
                                <div id="lineColumnArea"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end of row -->















<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>



    <script src="<?php echo e(asset('assets/js/vendor/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/vendor/apexcharts.dataseries.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/es5/apexMixChart.script.min.js')); ?>"></script>





<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/charts/apexMixCharts.blade.php ENDPATH**/ ?>