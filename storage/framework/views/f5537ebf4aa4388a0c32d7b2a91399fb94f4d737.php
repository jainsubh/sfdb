<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Semi Automated Report</title>
  <link href="<?php echo e(asset('report_template/css/style.css')); ?>" rel="stylesheet">
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
                          <img class="img-responsive" src="<?php echo e(asset('report_template/images/logo.png')); ?>">
                        </div>
                      </td>
                      <td width="40%" height="90">
                        <div class="rep-title"> (Note: Partial Automated Report) </div>
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
                            <?php if($task && $task->alert->title != null): ?>
                                <?php echo e($task->alert->title); ?>

                            <?php endif; ?>
                          </h2>
                      </td>
                    </tr>
                    <tr>
                      <td width="10%" class="row-head">Sector</td>
                      <td width="21%">
                        <?php if($task && $task->id != null): ?>
                            <?php echo e($task->alert->sectors->name); ?>

                          <?php endif; ?>  
                      </td>
                      <td width="10%" class="row-head">Priority</td>
                      <td width="10%">
                        <?php if($task && $task->priority != null): ?>
                            <?php echo e(Str::ucfirst($task->priority)); ?>

                          <?php endif; ?>
                      </td>
                      <td width="12%" class="row-head">Objective</td>
                      <td width="37%">
                        <?php if(isset($task->semi_automatic)): ?>
                            <?php echo e($task->semi_automatic->objective); ?>

                        <?php endif; ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="row-head">Date</td>
                      <td><?php echo e(\Carbon\Carbon::parse(now())->isoFormat('ll')); ?></td>
                      <td class="row-head">Time</td>
                      <td><?php echo e(\Carbon\Carbon::now(auth()->user()->timezone)->toTimeString()); ?></td>
                      <td class="row-head">Reference</td>
                      <td>
                        <?php if(isset($task->semi_automatic)): ?>
                            <?php echo e($task->semi_automatic->ref_id); ?>

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
                                    <?php if($task && $task->alert->summary != null): ?>
                                        <?php echo $task->alert->summary; ?>

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
                                    <td style="width:50%">
                                      <?php if(isset($task->semi_automatic->gallery[0])): ?>
                                      <img class="img-responsive" src="<?php echo e(asset('storage/'.$task->semi_automatic->gallery[0]->images)); ?>/semi-automatic">
                                      <?php endif; ?>
                                    </td>
                                    <td style="width:10">
                                      <img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>">
                                    </td>
                                    <td style="width:50%">
                                      <?php if(isset($task->semi_automatic->gallery[1])): ?>
                                      <img class="img-responsive" src="<?php echo e(asset('storage/'.$task->semi_automatic->gallery[1]->images)); ?>/semi-automatic">
                                      <?php endif; ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="width:10%; height:10px" colspan="3" class="spaceTable">
                                      <img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>">
                                    </td>
                                  </tr>
                                  <tr>
                                      <?php if(isset($task->semi_automatic->gallery[2])): ?>
                                      <td><img class="img-responsive" src="<?php echo e(asset('storage/'.$task->semi_automatic->gallery[2]->images)); ?>/semi-automatic"></td>
                                      <?php endif; ?>
                                      <td><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
                                      <?php if(isset($task->semi_automatic->gallery[3])): ?>
                                      <td><img class="img-responsive" src="<?php echo e(asset('storage/'.$task->semi_automatic->gallery[3]->images)); ?>/semi-automatic"></td>
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
              <td width="100%" height="185" class="boxTable">
                <table class="keywordTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="50%" height="185">
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
                                <div class="box-150 box">
                                  <div class="box-content">
                                     <?php if(isset($keywords) && count($keywords) > 0): ?>
                                      <?php echo e(implode(', ', $keywords)); ?>

                                    <?php endif; ?>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                      <td width="10" height="185"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
                      <td width="50%" height="185">
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
                                <div class="box-150 box">
                                  <div class="box-content">
                                   <?php if(isset($task->alert->countries)): ?>
                                      <?php $__currentLoopData = $task->alert->countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countries): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($countries->country->city); ?>, <?php echo e($countries->country->country_name); ?><br />
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
                            <?php if($task && $task->semi_automatic != null): ?>
                              <?php echo $task->semi_automatic->key_information; ?>

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
                            <?php if($task && $task->semi_automatic != null && $task->semi_automatic->recommendation): ?>
                              <?php echo $task->semi_automatic->recommendation; ?>

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
                             <?php if(isset($links) && count($links) > 0): ?>
                                <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo $link; ?>" target="_blank" class="black"><p><?php echo $link; ?></p></a>
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

</html><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/report_template/semi_automatic.blade.php ENDPATH**/ ?>