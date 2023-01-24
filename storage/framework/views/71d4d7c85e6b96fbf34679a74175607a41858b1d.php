<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fully Manual Report</title>
  <link href="<?php echo e(asset('report_template/css/style.css')); ?>" rel="stylesheet">
  <style>
    .img-responsive{
      max-height: 178px;
    }
    .black{
      color : black;
    }
  </style>
</head>

<body>
  <div class="ccm-page wrapper">
    <section id="innerContent">
      <div class="container">
        <table class="fullTable" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td>
                <table class="titleTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr height="50">
                      <td width="100%" height="40" colspan="3">&nbsp;</td>
                    </tr>
                    <tr height="90" valign="center">
                      <td width="20%" height="90">
                        <div class="logo-left">
                          <img class="img-responsive" src="<?php echo e(asset('report_template/images/logo.png')); ?>">
                        </div>
                      </td>
                      <td width="40%" height="90">
                        <div class="rep-title"> (Note: Fully Manual Report) </div>
                      </td>
                      <td width="20%" height="90">
                        <div class="logo-right">
                          <img class="img-responsive" src="<?php echo e(asset('report_template/images/logo.png')); ?>">
                        </div>
                      </td>
                      <td width="20%" height="90">
                        <div class="logo-right">
                          <img class="img-responsive" src="<?php echo e(asset('report_template/images/logo.png')); ?>">
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td width="100%" height="10" class="spaceTable"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
            </tr>
            <tr>
              <td width="100%" height="120">
                <table class="headTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="10%" class="row-head">Title</td>
                      <td width="90%" colspan="5">
                          <h2 id="report_title">
                            <?php if(isset($fully_manual_report) && $fully_manual_report->title): ?>
                                <?php echo e(Str::limit($fully_manual_report->title, 90)); ?>

                            <?php endif; ?>
                          </h2>
                      </td>
                    </tr>
                    <tr>
                      <td width="10%" class="row-head">Sector</td>
                      <td width="21%">
                        <?php if(isset($fully_manual_report) && $fully_manual_report->sectors): ?>
                          <?php echo $fully_manual_report->sectors->name; ?>

                        <?php endif; ?>
                      </td>
                      <td width="10%" class="row-head">Priority</td>
                      <td width="10%">
                        <?php if(isset($fully_manual_report) && $fully_manual_report->priority): ?>
                          <?php echo e($fully_manual_report->priority); ?>

                        <?php endif; ?>
                      </td>
                      <td width="12%" class="row-head">Objective</td>
                      <td width="37%">
                        <?php if(isset($fully_manual_report) && $fully_manual_report->objectives): ?>
                          <?php echo e(Str::limit($fully_manual_report->objectives, 60)); ?>

                        <?php endif; ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="row-head">Date</td>
                      <td>
                        <?php if(isset($fully_manual_report) && $fully_manual_report->date_time): ?>
                          <?php echo e(\Carbon\Carbon::parse($fully_manual_report->date_time)->isoFormat('ll')); ?>

                        <?php endif; ?>
                      </td>
                      <td class="row-head">Time</td>
                      <td>
                        <?php if(isset($fully_manual_report) && $fully_manual_report->date_time): ?>
                          <?php echo e(\Carbon\Carbon::parse($fully_manual_report->date_time)->toTimeString()); ?>

                        <?php endif; ?>
                      </td>
                      <td class="row-head">Reference</td>
                      <td>
                        <?php if(isset($fully_manual_report) && $fully_manual_report->ref_id): ?>
                          <?php echo e($fully_manual_report->ref_id); ?>

                        <?php endif; ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td width="100%" height="10" class="spaceTable"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
            </tr>
            <tr>
              <td width="100%" height="385" class="boxTable">
                <table class="sumTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="50%" height="385">
                        <table class="newTable" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="300" class="box-title">Summary</th>
                              <th width="235">&nbsp;</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td width="100%" colspan="2">
                                <div class="box-350 box">
                                  <div class="box-content">
                                    <p>
                                        <?php if(isset($fully_manual_report) && $fully_manual_report->summary): ?>
                                            <?php echo $fully_manual_report->summary; ?>

                                        <?php endif; ?>
                                    </p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                      <td width="10" height="385"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
                      <td width="50%" height="385">
                        <table class="imgTable" cellspacing="0" width="100%">
                          <tbody>
                              <tr>
                                <td width="50%">
                                  <?php if(isset($fully_manual_report->gallery[0])): ?>
                                  <img class="img-responsive" src="<?php echo e(asset('storage/'.$fully_manual_report->gallery[0]->images)); ?>">
                                  <?php endif; ?>
                                </td>
                                <td width="10">
                                  <img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>">
                                </td>
                                <td width="50%">
                                  <?php if(isset($fully_manual_report->gallery[1])): ?>
                                  <img class="img-responsive" src="<?php echo e(asset('storage/'.$fully_manual_report->gallery[1]->images)); ?>">
                                  <?php endif; ?>
                                </td>
                              </tr>
                              <tr>
                                <td width="10" height="10" colspan="3" class="spaceTable">
                                  <img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>">
                                </td>
                              </tr>
                              <tr>
                                  <?php if(isset($fully_manual_report->gallery[2])): ?>
                                  <td><img class="img-responsive" src="<?php echo e(asset('storage/'.$fully_manual_report->gallery[2]->images)); ?>"></td>
                                  <?php endif; ?>
                                  <td><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
                                  <?php if(isset($fully_manual_report->gallery[3])): ?>
                                  <td><img class="img-responsive" src="<?php echo e(asset('storage/'.$fully_manual_report->gallery[3]->images)); ?>"></td>
                                  <?php endif; ?>
                              </tr>
                            </tbody>
                          </table>   
                      </td>
                    </tr>
                  </tbody>
                </table> 
              </td>
            </tr>
            <tr>
              <td width="100%" height="10" class="spaceTable"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
            </tr>
            <tr>
              <td width="100%" height="300" class="boxTable">
                <table class="newTable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="300" class="box-title">Key Information Items</th>
                      <th width="880">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td width="100%" colspan="2">
                        <div class="box-200 box">
                          <div class="box-content">
                            <p>
                              <?php if(isset($fully_manual_report) && $fully_manual_report->key_information): ?>
                                  <?php echo $fully_manual_report->key_information; ?>

                              <?php endif; ?>
                            </p>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td width="100%" height="10" class="spaceTable"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
            </tr>
            <tr>
              <td width="100%" height="235" class="boxTable">
                <table class="newTable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="300" class="box-title">Recommendation</th>
                      <th width="880">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td width="100%" colspan="2">
                        <div class="box-200 box">
                          <div class="box-content">
                            <p>
                              <?php if(isset($fully_manual_report) && $fully_manual_report->recommendation): ?>
                                  <?php echo $fully_manual_report->recommendation; ?>

                              <?php endif; ?>
                            </p>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td width="100%" height="10" class="spaceTable"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
            </tr>
            <tr>
              <td width="100%" height="185" class="boxTable">
                <table class="newTable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="300" class="box-title">References</th>
                      <th width="880">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td width="100%" colspan="2">
                        <div class="box-250 box">
                          <div class="box-content">
                            <ul>
                              <?php if(isset($fully_manual_links) && count($fully_manual_links) > 0): ?>
                                <?php $__currentLoopData = $fully_manual_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php if($i <= 7): ?>
                                  <a href="<?php echo $link; ?>" target="_blank" class="black"><li><?php echo $link; ?></li></a>
                                  <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php endif; ?>
                            </ul>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td width="100%" height="10" class="spaceTable"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
            </tr>
            <tr>
              <td width="100%" height="50">
                <table class="footerTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="13.33%">Analyst</td>
                      <td width="20%">
                        <?php if(auth()->user()->hasRole('Analyst')): ?>
                            <?php echo e(auth()->user()->name); ?>

                        <?php endif; ?>
                      </td>
                      <td width="13.33%">Manager</td>
                      <td width="20%">&nbsp;</td>
                      <td width="13.33%">Director</td>
                      <td width="20%">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table> 
      </div>
    </section>
    <!--<section id="footerContent">
      <div class="container">
        <button class="button">Save to PDF</button>
      </div>
    </section>-->
  </div>
</body>

</html><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/report_template/manual.blade.php ENDPATH**/ ?>