<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product Report</title>
  <link href="<?php echo e(asset('report_template/css/style.css')); ?>" rel="stylesheet">
  <style>
    .img-responsive{
      max-height: 178px;
    }
    .box-185{
      height: 185px;
    }
    .box-355{
      height: 355px;
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
                        <div class="rep-title"> (Note: Product Report) </div>
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
                            <?php if(isset($product_report) && $product_report->title): ?>
                                <?php echo e(Str::limit($product_report->title, 90)); ?>

                            <?php endif; ?>
                          </h2>
                      </td>
                    </tr>
                    <tr>
                      <td width="10%" class="row-head">Sector</td>
                      <td width="21%">
                        <?php if(isset($product_report) && $product_report->title): ?>
                            <?php echo e(Str::limit($product_report->sectors->name, 80)); ?>

                        <?php endif; ?>
                      </td>
                      <td width="10%" class="row-head">Priority</td>
                      <td width="10%">
                        <?php if(isset($product_report) && $product_report->priority): ?>
                          <?php echo e($product_report->priority); ?>

                        <?php endif; ?>
                      </td>
                      <td width="12%" class="row-head">Objective</td>
                      <td width="37%">
                        <?php if(isset($product_report) && $product_report->objectives): ?>
                          <?php echo e(Str::limit($product_report->objectives, 60)); ?>

                        <?php endif; ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="row-head">Date</td>
                      <td>
                        <?php if(isset($product_report) && $product_report->date_time): ?>
                          <?php echo e(\Carbon\Carbon::parse($product_report->date_time)->isoFormat('ll')); ?>

                        <?php endif; ?>
                        </td>
                      <td class="row-head">Time</td>
                      <td>
                        <?php if(isset($product_report) && $product_report->date_time): ?>
                          <?php echo e(\Carbon\Carbon::parse($product_report->date_time)->toTimeString()); ?>

                        <?php endif; ?>
                      </td>
                      <td class="row-head">Reference</td>
                      <td>
                        <?php if(isset($product_report) && $product_report->ref_id): ?>
                          <?php echo e($product_report->ref_id); ?>

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
                                <div class="box-355 box">
                                  <div class="box-content">
                                    <p>
                                        <?php if(isset($product_report) && $product_report->summary): ?>
                                            <?php echo $product_report->summary; ?>

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
                                  <?php if(isset($product_report->gallery[0])): ?>
                                  <img class="img-responsive" src="<?php echo e(asset('storage/'.$product_report->gallery[0]->images)); ?>/product">
                                  <?php endif; ?>
                                </td>
                                <td width="10">
                                  <img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>">
                                </td>
                                <td width="50%">
                                  <?php if(isset($product_report->gallery[1])): ?>
                                  <img class="img-responsive" src="<?php echo e(asset('storage/'.$product_report->gallery[1]->images)); ?>/product">
                                  <?php endif; ?>
                                </td>
                              </tr>
                              <tr>
                                <td width="10" height="10" colspan="3" class="spaceTable">
                                  <img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>">
                                </td>
                              </tr>
                              <tr>
                                  <?php if(isset($product_report->gallery[2])): ?>
                                  <td><img class="img-responsive" src="<?php echo e(asset('storage/'.$product_report->gallery[2]->images)); ?>/product"></td>
                                  <?php endif; ?>
                                  <td><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
                                  <?php if(isset($product_report->gallery[3])): ?>
                                  <td><img class="img-responsive" src="<?php echo e(asset('storage/'.$product_report->gallery[3]->images)); ?>/product"></td>
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
              <td width="100%" height="285" class="boxTable">
                <table class="keywordTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="50%" height="285">
                        <table class="newTable" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="300" class="box-title">Features</th>
                              <th width="235">&nbsp;</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td width="100%" colspan="2">
                                <div class="box-200 box">
                                  <div class="box-content">
                                    <p>
                                        <?php if(isset($product_report) && $product_report->features): ?>
                                            <?php echo $product_report->features; ?>

                                        <?php endif; ?>
                                    </p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                      <td width="10" height="285"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
                      <td width="50%" height="285">
                        <table class="newTable" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="300" class="box-title">Negatives</th>
                              <th width="235">&nbsp;</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td width="100%" colspan="2">
                                <div class="box-200 box">
                                  <div class="box-content">
                                    <p>
                                        <?php if(isset($product_report) && $product_report->negatives): ?>
                                            <?php echo $product_report->negatives; ?>

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
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td width="100%" height="10" class="spaceTable"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
            </tr>
            <tr>
              <td width="100%" height="285" class="boxTable">
                <table class="newTable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="300" class="box-title">Advantages</th>
                      <th width="880">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td width="100%" colspan="2">
                        <div class="box-200 box">
                          <div class="box-content">
                            <p>
                            <?php if(isset($product_report) && $product_report->advantages): ?>
                                <?php echo $product_report->advantages; ?>

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
              <td width="100%" height="250" class="boxTable">
                <table class="keywordTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="50%" height="250">
                        <table class="newTable" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="300" class="box-title">Vendor Information</th>
                              <th width="235">&nbsp;</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td width="100%" colspan="2">
                                <div class="box-185 box">
                                  <div class="box-content">
                                    <p>
                                        <?php if(isset($product_report) && $product_report->vendor_information): ?>
                                            <?php echo $product_report->vendor_information; ?>

                                        <?php endif; ?>
                                    </p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                      <td width="10" height="250"><img src="<?php echo e(asset('report_template/images/spacer-10.png')); ?>"></td>
                      <td width="50%" height="250">
                        <table class="newTable" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="300" class="box-title">Approvals</th>
                              <th width="235">&nbsp;</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td width="100%" colspan="2">
                                <div class="box-200 box">
                                  <div class="box-content">
                                    <table class="approvalTable" cellspacing="0" width="100%">
                                      <tbody>
                                        <tr>
                                          <td width="40%">Analyst</td>
                                          <td width="60%">
                                            <?php if(auth()->user()->hasRole('Analyst')): ?>
                                                <?php echo e(auth()->user()->name); ?>

                                            <?php endif; ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td width="40%">Manager</td>
                                          <td width="60%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td width="40%">Director</td>
                                          <td width="60%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td width="40%">Date</td>
                                          <td width="60%">&nbsp;</td>
                                        </tr>
                                      </tbody>
                                    </table>
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
          </tbody>
        </table> 
      </div>
    </section>
  </div>
</body>

</html><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/report_template/product.blade.php ENDPATH**/ ?>