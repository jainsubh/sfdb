<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fully Automated Report</title>
  <link href="<?php echo e(asset('report_template/css/style.css')); ?>" rel="stylesheet" />
  <style>
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
                          <img class="img-responsive" alt="" src="<?php echo e(asset('report_template/images/logo.png')); ?>">
                        </div>
                      </td>
                      <td width="40%" height="90">
                        <div class="rep-title"> (Note: Fully Automated Report) </div>
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
                        <h2>
                          <?php if(isset($alert) && $alert->title): ?>
                            <?php echo e(Str::limit($alert->title, 80)); ?>

                          <?php endif; ?>
                        </h2>
                      </td>
                    </tr>
                    <tr>
                      <td width="10%" class="row-head">Sector</td>
                      <td width="21%">
                        <?php if(isset($alert) && $alert->sectors): ?>
                          <?php echo $alert->sectors->name; ?>

                        <?php endif; ?>
                      </td>
                      <td width="10%" class="row-head">Priority</td>
                      <td width="10%">
                        <?php if(isset($alert) && $alert->priority): ?>
                          <?php echo $alert->priority; ?>

                        <?php else: ?>
                          Medium
                        <?php endif; ?>
                      </td>
                      <td width="12%" class="row-head">Objective</td>
                      <td width="37%">
                        <?php if(isset($alert) && $alert->objective): ?>
                          <?php echo $alert->objective; ?>

                        <?php endif; ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="row-head">Date</td>
                      <td>
                        <?php if(isset($alert) && $alert->created_at): ?>
                          <?php echo e(\Carbon\Carbon::parse($alert->created_at)->isoFormat('ll')); ?>

                        <?php endif; ?>
                      </td>
                      <td class="row-head">Time</td>
                      <td>
                        <?php if(isset($alert) && $alert->created_at): ?>
                          <?php echo e(\Carbon\Carbon::parse($alert->created_at)->toTimeString()); ?>

                        <?php endif; ?>
                      </td>
                      <td class="row-head">Reference</td>
                      <td>
                        <?php if(isset($alert) && $alert->ref_id): ?>
                          <?php echo e($alert->ref_id); ?>

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
                <table class="newTable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="300" class="box-title">Summary</th>
                      <th width="880">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td width="100%" colspan="2">
                        <div class="box-350 box">
                          <div class="box-content">
                            <p>
                              <?php if(isset($alert) && $alert->summary): ?>
                                <?php echo $alert->summary; ?>

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
                <table class="keywordTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="50%" height="235">
                        <table class="newTable" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="300" class="box-title">Keyword - Event Trigger</th>
                              <th width="235">&nbsp;</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td width="100%" colspan="2">
                                <div class="box-200 box">
                                  <div class="box-content">
                                    <p>
                                      <?php if(isset($alert) && $alert->events): ?>
                                        <?php echo $alert->events->name; ?>

                                      <?php endif; ?>
                                    </p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                      <td width="10" height="235"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
                      <td width="50%" height="235">
                        <table class="newTable" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="300" class="box-title">Countries-Cities Mentioned</th>
                              <th width="235">&nbsp;</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td width="100%" colspan="2">
                                <div class="box-200 box">
                                  <div class="box-content">
                                    <?php if(isset($alert->countries)): ?>
                                      <?php $__currentLoopData = $alert->countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countries): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p><?php echo e($countries->country->city); ?>, <?php echo e($countries->country->country_name); ?></p>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                  </div>
                                </div>
                              </td>
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
                              <?php if(isset($alert) && $alert->recommendation): ?>
                                <?php echo $alert->recommendation; ?>

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
                        <div class="box-150 box">
                          <div class="box-content">
                            <ul>
                              <?php if(isset($links) && count($links) > 0): ?>
                                <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <a href="<?php echo $link; ?>" target="_blank" class="black"><p><?php echo $link; ?></p></a>
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

</html><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/report_template/automatic.blade.php ENDPATH**/ ?>