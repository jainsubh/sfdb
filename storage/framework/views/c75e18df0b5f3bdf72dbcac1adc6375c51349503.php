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
                        <li>Apex Bar Charts</li>
                    </ul>
                </div>

                <div class="separator-breadcrumb border-top"></div>

                <div class="row">
                    <div class=" col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title"> Basic Bar chart</div>
                                <div id="basicBar-chart"></div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Grouped Bar </div>
                                <div id="groupedBar"></div>
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
                                    Stacked Bars(Fiction Books Sales)
                                </div>

                                <div id="stackedBar"></div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Bar with Negative Values(Mauritius population pyramid 2011)
                                </div>
                                <div id="negetiveBar"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end of row -->

                <div class="row">
                    <div class=" col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title"> Custom DataLabels Bar</div>
                                <div id="customDatalabelBar"></div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title"> Patterned Bar(Compare Sales Strategy)</div>
                                <div id="PatternedBar"></div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- end of row -->







<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>



    <script src="<?php echo e(asset('assets/js/vendor/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/vendor/apexcharts.dataseries.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/es5/apexBarChart.script.min.js')); ?>"></script>





<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/charts/apexBarCharts.blade.php ENDPATH**/ ?>