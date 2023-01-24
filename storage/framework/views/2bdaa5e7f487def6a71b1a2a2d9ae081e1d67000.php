<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Freeform Report</title>
  <link href="<?php echo e(asset('report_template/css/style.css')); ?>" rel="stylesheet" />
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
                        <div class="rep-title"> (Note: Freeform Report) </div>
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
                      <td width="90%" colspan="5"><h2 id="report_title">
                        <?php if($freeform_report && $freeform_report->title != null): ?>
                            <?php echo e(Str::ucfirst($freeform_report->title)); ?>

                        <?php endif; ?>
                      </h2>
                      </td>
                    </tr>
                    <tr>
                      <td width="10%" class="row-head">Sector</td>
                      <td width="21%">
                        <?php if($freeform_report && $freeform_report->id != null): ?>
                            <?php echo e($freeform_report->sectors->name); ?>

                        <?php endif; ?>  
                      </td>
                      <td width="10%" class="row-head">Priority</td>
                      <td width="10%">
                        <?php if($freeform_report && $freeform_report->priority != null): ?>
                            <?php echo e(Str::ucfirst($freeform_report->priority)); ?>

                        <?php endif; ?>
                      </td>
                      <td width="12%" class="row-head">Objective</td>
                      <td width="37%">
                        <?php if($freeform_report && $freeform_report->objective != null): ?>
                            <?php echo e(Str::ucfirst($freeform_report->objective)); ?>

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
                        <?php if(isset($freeform_report->ref_id)): ?>
                            <?php echo e($freeform_report->ref_id); ?>

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
              <td width="100%" height="1200" class="boxTable">
                <div class="free-box-content">
                  <img class="img-responsive" src="">
                    <p> 
                        <?php if($freeform_report && $freeform_report != null): ?>
                        <?php echo $freeform_report->key_information; ?>

                      <?php endif; ?>
                    </p>
                </div>
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
                      <td width="20%"></td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table> 
      </div>
    </section>
  </div>
</body>

</html><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/report_template/freeform_report.blade.php ENDPATH**/ ?>