<?php $__env->startSection('before-css'); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/quill.bubble.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/quill.snow.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

              <div class="breadcrumb">
                    <h1>Echarts</h1>
                    <ul>
                        <li><a href="">Charts</a></li>
                        <li>Echarts</li>
                    </ul>
                </div>

                <div class="separator-breadcrumb border-top"></div>
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">This Year Sales</div>
                                <div id="echartBar" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Sales by Countries</div>
                                <div id="echartPie" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Basic Line</div>
                                <div id="basicLine" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Multi Line</div>
                                <div id="multiLine" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Basic Bar chart</div>
                                <div id="basicBar" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Multiple Bar chart</div>
                                <div id="multipleBar" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Multiple Bar chart 2</div>
                                <div id="multipleBar2" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Zoom Bar</div>
                                <div id="zoomBar" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of row -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Basic Doughnut</div>
                                <div id="basicDoughnut" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Gauge Chart</div>
                                <div id="gaugeChart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end of row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Basic Area Chart</div>
                                <div id="basicArea" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Stacked Area Chart</div>
                                <div id="stackedArea" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Stacked Area Chart with Pointer</div>
                                <div id="stackedPointerArea" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Solid Area</div>
                                <div id="solidArea" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- end of row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Basic Pie Chart</div>
                                <div id="basicPie" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Stacked Pie Chart</div>
                                <div id="stackedPie" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of row -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Bubble Chart</div>
                                <div id="bubbleChart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- end of row -->

                <div class="row">



                </div>
                <!-- end of row -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>

    <script src="<?php echo e(asset('assets/js/vendor/echarts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/es5/echarts.script.min.js')); ?>"></script>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/charts/echarts.blade.php ENDPATH**/ ?>