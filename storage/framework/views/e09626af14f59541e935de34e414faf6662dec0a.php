<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>NEWS-<?php echo e($name); ?></title>
    <?php echo $__env->make('layouts.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <style>
      .item-download{ padding:2px; }
      .modal-content{ width:700px ; padding:15px ; } 
      #alert_panel_empty { position: absolute; left: 50%; top: 50%; transform: translateX(-50%) translateY(-50%); cursor: text !important; }
      #system_alerts_empty { position: absolute; left: 50%; top: 50%; transform: translateX(-50%) translateY(-50%); cursor: text !important; }
      #alert-panel .value{ font-size: 14px; }
      #loading_image{ display:none; }
      .mg-top { margin-top: 15px; }
      .center{ display: block; margin-left: 40%; margin-top: 12%; }
      .module{ height: 540px }
      .select_date{ width:100%}
      #task_reminder_modal .modal-content{ min-height: 600px; min-width: 70%;}
      #task_reminder{
        width:100%; 
      }
      #task_reminder_content tr td{
        padding: 15px 0px;
        color: #fff;
        border-bottom: 1px solid #33477c;
      }
      .task-list{
        height: 600px;
      }
      .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
      }
      .tooltip .tooltiptext {
          visibility: hidden;
          min-width:130px;
          background-color: #0a1942;
          color: #28adfb;
          font-weight: bold;
          text-align: center;
          border-radius: 6px;
          padding: 5px 0;
          font-size:14px;
          top: -2.5em;
          position: absolute;
          z-index: 1;
      }

      .tooltip:hover .tooltiptext {
          visibility: visible;
      }
      .person{
        font-weight: 700;
      }
      @media  only screen and (max-width: 1430px) {
        div.alert-items{
          width: 32% !important;
        }
      }

      /* Style for Manager Dashboard */
      #mng-box-panel{
        height: 900px;
      }
      #mng-box-panel .panel-item{
        width: 100%
      }
      .side_panel{
        float:left;
      }
      .link-txt{
        text-align: center;
        width: 100%;
      }
      .pd-events{
        padding:3px 0px 5px 10px;
        margin-bottom: 10px;
      }
      #mng-box-panel .panel-icon{
        width: 40px;
        height: 40px;
      }
      .events_list, #mng-sysalerts-panel .sysalerts-items .sysalerts-inner{
        height: 300px;
      }
      .myreports-list, .myreports-inner{
        height: 285px !important;
      }
    </style>
  </head>
<body>
  <div class="wrapper">
    <div class="wrap container-fluid">
      <!-- header section start -->
      <?php echo $__env->make('layouts.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- header section end -->

      <!-- alert navigation start -->
      <?php echo $__env->make('layouts.includes.alert-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- alert navigation end -->
      
      <section id="working-area" class="row">
        <div class="col-xs-12 col-sm-12 col-12">
          <div class="col-1 col-lg-4 col-md-12 col-sm-12 col-xs-12 side_panel">
            <article id="mng-box-panel" class="module">
              <div class="panel-item">
                <button class="no-button" onclick="task_reminder()">
                  <div class="panel-icon"><img src="images/task-reminder.svg" alt="task-reminder" class="icon"></div>
                    <div class="panel-txt">Task <br> Reminder</div>
                </button>
              </div>
              <div class="panel-item">
                <button class="no-button" data-modal="#modal-02">
                  <div class="panel-icon"><img src="images/calendar.svg" alt="calendar" class="icon"></div>
                    <div class="panel-txt">Calendar</div>
                </button>
              </div>
              <div class="panel-item">
                <button class="no-button" data-modal="#modal-03">
                  <div class="panel-icon"><img src="images/search.svg" alt="search" class="icon"></div>
                    <div class="panel-txt">Advanced<br>Search</div>
                </button>
              </div>
              <div class="panel-item">
                <button class="no-button" onclick="window.open('<?php echo e(route('events.index')); ?>')">
                  <div class="panel-icon"><img src="images/data-entry.png" alt="data-entry" class="icon"></div>
                    <div class="panel-txt">Data<br>Entry</div>
                </button>
              </div>
              <div class="panel-item">
                <button class="no-button" onclick="window.open('<?php echo e(route('all')); ?>')">
                  <div class="panel-icon"><img src="images/library.svg" alt="library" class="icon"></div>
                  <div class="panel-txt">Library</div>
                </button>
              </div>
              <div class="panel-item">
                <button class="no-button" onclick="window.open('<?php echo e(route('google_search.index')); ?>')">
                  <div class="panel-icon"><img src="images/google-search.png" alt="library" class="icon"></div>
                    <div class="panel-txt">Google Search</div>
                </button>
              </div>
              <div class="panel-item" style="margin-left:10px;">
                <a href="<?php echo e(route('translate.index')); ?>" target="_blank">
                  <div class="panel-icon"><img src="images/translation.png" alt="library" class="icon"></div>
                  <div class="link-txt">Translate </div>
                </a>
              </div>
              <div class="panel-item" style="margin-left:10px;">
                <a href="<?php echo e(route('tasks.index')); ?>" target="_blank">
                  <div class="panel-icon"><img src="images/go-to-panel.png" alt="library" class="icon"></div>
                  <div class="link-txt">Go to<br> Panel <i class="fa fa-share-square-o" aria-hidden="true"></i></div>
                </a>
              </div>
              <div class="panel-item" style="margin-left:10px;">
                <a href="<?php echo e(route('freeform_report.create')); ?>" style="text-align:center" target="_blank">
                  <div class="panel-icon"><img src="images/freeform-report.png" alt="library" class="icon"></div>
                  <div class="link-txt">New <br>FreeForm<br> Report</div>
                </a>
              </div>
            </article>
            <!-- Modals content -->
            <div id="task_reminder_modal" class="modal">
              <div class="modal-content">
                <div class="panel-modal-head">
                    <a class="close">&times;</a>
                    <div class="panel-title">Task Reminder</div>
                </div>
                <div class="panel-modal-content">
                  <div class="panel-table-head">
                    <div class="scroll-wrapper task-list">
                      <div class="scroll-inner">
                        <table id="task_reminder" aria-describedby="task_reminder" border="0">
                            <thead>
                              <tr class="task_reminder">
                                  <th scope="col" style="width:40%">Task Name</th>
                                  <th scope="col" style="width:15%">Analyst</th>
                                  <th scope="col" style="width:10%">Status</th>
                                  <th scope="col" style="width:10%">Priority</th>
                                  <th scope="col" style="width:15%">Start Date</th>
                                  <th scope="col" style="width:10%">Due Date</th>
                              </tr>
                            </thead>
                            
                                <tbody id="task_reminder_content">

                                </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="modal-02" class="modal">
              <div class="modal-content calendar">
                <div class="panel-modal-head">
                  <a class="close">&times;</a>
                  <div class="panel-title">Calendar</div>
                </div>
                <div class="panel-modal-content">
                  <div id="my-calendar"></div>
                </div>
              </div>
            </div>
            <div id="modal-03" class="modal">
              <div class="modal-content search">
                <div class="panel-modal-head">
                  <a class="close">&times;</a>
                  <div class="panel-title">Advanced search</div>
                </div>
                <div class="panel-modal-content">
                  <?php echo e(Form::open(['method' => 'get', 'class' => 'advanced-search', 'url'=> 'library/all', 'id'=>'filter_search' ])); ?>

                    <div class="row">
                      <div class="form-group col-6 col-xs-12" style="margin-bottom:0px">
                        <label><input type="radio" value="search_title" class='search_radio' name="search_by" checked> &nbsp; Search by Name</label>
                      </div>
                      <div class="form-group col-6 col-xs-12" style="margin-bottom:0px">
                        <label><input type="radio" value="search_ref_id" class='search_radio' name="search_by"> &nbsp;  Search by ID</label>
                      </div>
                      <div class="form-group col-12 col-xs-12" id="search_title">
                        <label class="control-label">Search for Title</label>
                        <input type="text" name="search_title" value="" placeholder="Enter search title" class="form-control input-text">
                      </div>
                      <div class="form-group col-12 col-xs-12" id="search_ref_id" style="display:none">
                        <label class="control-label">Search for Id</label>
                        <input type="text" name="search_ref_id" value="" placeholder="Enter search id" class="form-control input-text">
                      </div>
                      <div class="form-group col-6 col-xs-12">
                        <label class="control-label">From Date</label>
                        <input id="start-date" name="from_date" value="" placeholder="Pick a date">
                      </div>
                      <div class="form-group col-6 col-xs-12">
                        <label class="control-label">To Date</label>
                        <input id="end-date" name="to_date" value="" placeholder="Pick a date">
                      </div>
                      
                    </div>
                    <div class="form-actions" style="text-align:right">
                      <button type="submit" formtarget="_blank" class="button">Search</button> &nbsp;
                      <button type="reset" class="button">Reset</button>
                    </div>
                  <?php echo e(Form::close()); ?>

                </div>
              </div>
            </div>

            <div id="assignTo" class="modal" tabindex="-1" role="dialog" aria-labelledby="assignToLabel">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="crudFormLabel">Assign to</h4>
                    </div>
                    <form method="POST" action="<?php echo e(route('tasks.store')); ?>" enctype="multipart/form-data" id = "assign_to_form">
                        <?php echo e(csrf_field()); ?>

                        <!-- name Form Input -->
                        <input type="hidden" name="type" value="institutional_report">
                        <input type="hidden" id="report_id" name="report_id" value="">
                        <div class="col-lg-12 col-md-12 modal-body">
                          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="select-analyst mg-top">
                              <?php echo Form::select('analysts', $analysts, null, ['placeholder' => 'Select Analyst', 'class' => 'form-control']); ?>

                            </div> 
                          </div>
                          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="select_date mg-top">
                                <input type="text" id="due-date" autoComplete="off" name="due_date" placeholder="Select Due Date">
                            </div>
                          </div>
                          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="select_priority mg-top">
                            <?php echo Form::select('priority',['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'], null, ['placeholder' => 'Select Priority', 'class' => 'form-control']); ?>

                            </div>
                          </div>
                        </div>
                        <div class="modal-footer  mg-top">  
                            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right">
                              <button class="button button-red" id="close" style="margin-right: 5px;"> Cancel </button>
                              <!-- Submit Form Button -->
                              <?php echo Form::button('Assign', ['type'=>'submit','class' => 'button ladda-button example-button m-1', 'data-style' => 'expand-right']); ?>

                            </div> 
                        </div>
                    </form>
                  </div>
              </div>
            </div>

            <div id="view_as_analyst_popup" class="modal" tabindex="-1" role="dialog" aria-labelledby="analystPopUpLabel">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="crudFormLabel">View As Analyst</h4>
                    </div>
                    <form method="POST" action="<?php echo e(route('manager.view_as_analyst')); ?>" enctype="multipart/form-data" id="assign_analyst">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" id="" name="" value="">
                        <div class="col-lg-12 col-md-12 modal-body">
                          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="select-analyst mg-top">
                              <?php echo Form::select('analysts', $analysts, null, ['placeholder' => 'Select Analyst', 'class' => 'form-control']); ?>

                            </div> 
                          </div>
                        </div>
                        <div class="modal-footer  mg-top">  
                            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right">
                              <button class="button button-red" id="close" data-dismiss="modal" style="margin-right: 5px;"> Cancel </button>
                              <button class="button ladda-button example-button m-1" data-style="expand-right" onclick="view_as_analyst_submit()"> View As </button>
                            </div> 
                        </div>
                    </form>
                  </div>
              </div>
            </div>
          
          </div>

          <div class="row">
            <div class="col-5 col-lg-8 col-md-12 col-sm-12 col-xs-12">
              <article id="myreports-panel" class="module">
                <input type="radio" id="rewtab1" name="tab" onchange="inactiveEventTab()">
                <label for="rewtab1"><h3>Completed Reports</h3></label>
                <input type="radio" id="rewtab2" name="tab" onchange="inactiveEventTab()" checked>
                <label for="rewtab2"><h3>in progress</h3></label>
                <input type="radio" id="rewtab3" name="tab">
                <label for="rewtab3"><h3>Transfer Request</h3></label>
                
                <div style="float: right">
                  <input type="radio" name="tab">
                  <label class="tooltip account" style="display:none;">
                      <h3>
                        <i class="fa fa-user" aria-hidden="true"></i>
                      </h3>
                    <div class="tooltiptext" style="width: 190px; text-align: left; padding-left: 15px;"></div>
                  </label>
                  <input type="radio" name="tab">
                  <label>
                    <h3 class="red">
                      <i class="fa fa-filter" id="filter" aria-hidden="true" onclick="view_as_analyst_popup()"></i>
                      <i class="fa fa-times" id="cancel" class="red" aria-hidden="true" style="display:none" onClick="history.go(0)"></i>
                    </h3>
                  </label>
                </div>
                <div class="myreports-items">
                  <!-- tab 1 -->
                  <div class="myreports-inner" id="rew1">
                    <div class="scroll-wrapper myreports-list">
                      <div class="scroll-inner">
                        <div class="myreports-content">
                          <input type="hidden" id="latest_team_report" value="<?php echo e(count($tasks_completed) > 0 ? \Carbon\Carbon::parse($tasks_completed[0]->completed_at, 'UTC')->timestamp : \Carbon\Carbon::now()->timestamp); ?>" >
                          <div class="row" id="team_report_content">
                            <?php $__currentLoopData = $tasks_completed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6 col-sm-12 col-xs-12" id="<?php echo e($task->subject_type.'_'.$task->subject_id); ?>" style="curson:pointer" onclick="show_alert('<?php echo e($task->subject_id); ?>', '<?php echo e($task->subject_type); ?>')">
                                <div class="myreports-item">
                                  <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                      <?php if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report'): ?>
                                        <?php echo e(Str::limit($task->subject->title, 80)); ?>

                                      <?php else: ?>
                                        <?php echo e(Str::limit($task->subject->name, 80)); ?>

                                      <?php endif; ?>
                                  </p>
                                  <p class="date red">Complete Date : <?php echo e(\Carbon\Carbon::parse($task->completed_at, 'utc')->setTimezone(auth()->user()->timezone)->isoFormat('lll')); ?></p>
                                  <p class="person blue">Completed By: <?php echo e($task->completed_by_user->name); ?></p>
                                  <p class="person blue">
                                      <?php if($task->semi_automatic && $task->semi_automatic->status == 'complete'): ?>
                                      <a href="<?php echo e(route('semi_automatic.download', $task->semi_automatic->ref_id)); ?>">
                                          Semi Automatic &nbsp;<i class="fa fa-download" aria-hidden="true"></i>  &nbsp;&nbsp; 
                                      </a>
                                      <?php endif; ?>
                                      <?php if($task->fully_manual && $task->fully_manual->status == 'complete'): ?>
                                      <a href="<?php echo e(route('fully_manual.download', $task->fully_manual->ref_id)); ?>">
                                          Fully Manual Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
                                      </a>
                                      <?php endif; ?>
                                      <?php if($task->product && $task->product->status == 'complete'): ?>
                                      <a href="<?php echo e(route('product.download', $task->product->ref_id)); ?>">
                                        Product Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
                                      </a>
                                      <?php endif; ?>
                                      <?php if($task->subject_type == 'freeform_report' && $task->subject->status == 'complete'): ?>
                                      <a href="<?php echo e(route('freeform_report.download', $task->subject->ref_id)); ?>">
                                          FreeForm Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
                                      </a>
                                      <?php endif; ?>
                                      
                                  </p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- tab 2 -->
                  <div class="myreports-inner" id="rew2">
                    <div class="scroll-wrapper myreports-list">
                      <div class="scroll-inner">
                        <div class="myreports-content">
                          <input type="hidden" id="latest_inprogress" value="<?php echo e(count($tasks) > 0 ? \Carbon\Carbon::parse($tasks[0]['updated_at'], 'UTC')->timestamp : \Carbon\Carbon::now()->timestamp); ?>" >
                          <div class="row" id="myReports">
                            <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6 col-sm-12 col-xs-12" id="<?php echo e($task->subject_type); ?>_<?php echo e($task->subject_id); ?>" style="curson:pointer" onclick="show_alert('<?php echo e($task->subject_id); ?>', '<?php echo e($task->subject_type); ?>')">
                              <div class="myreports-item">
                                <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?php if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report'): ?>
                                      <?php echo e(Str::limit($task->subject->title, 80)); ?>

                                    <?php else: ?>
                                      <?php echo e(Str::limit($task->subject->name, 80)); ?>

                                    <?php endif; ?>
                                </p>
                                <p class="date red">Due Date : <?php echo e(\Carbon\Carbon::parse($task->due_date)->isoFormat('ll')); ?></p>
                                <p class="person blue">Assigned Analyst: <?php echo e($task->latest_task_log->assigned_to_user->name); ?></p>
                                <p class="person <?php echo e($task->priority); ?>">Priority: <?php echo e(ucfirst($task->priority)); ?></p>
                              </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                   <!-- tab 3 -->
                   <div class="myreports-inner" id="rew3">
                    <div class="scroll-wrapper myreports-list">
                      <div class="scroll-inner">
                        <div class="myreports-content">
                          <input type="hidden" id="latest_transfer_request" value="<?php echo e(count($task_transfer) > 0 ? \Carbon\Carbon::parse($task_transfer[0]['updated_at'], 'UTC')->timestamp : \Carbon\Carbon::now()->timestamp); ?>" >
                          <div class="row" id="transfer_request_content">
                            <?php if($task_transfer): ?>
                              <?php $__currentLoopData = $task_transfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              
                                <div id="<?php echo e($transfer->subject_type); ?>_<?php echo e($transfer->subject_id); ?>" class="col-4 col-sm-12 col-xs-12" style="cursor:pointer" onclick="show_alert('<?= $transfer->subject_id ?>', '<?= $transfer->subject_type ?>')">
                                  <div class="myreports-item">
                                    <p>
                                      <?php if($transfer->subject_type === 'alert' || $transfer->subject_type === 'freeform_report' || $transfer->subject_type === 'external_report'): ?>
                                        <?php echo e(Str::limit($transfer->subject->title, 80)); ?>

                                      <?php else: ?>
                                        <?php echo e(Str::limit($transfer->subject->name, 80)); ?>

                                      <?php endif; ?>
                                    </p>
                                    <p class="date red"><?php echo e(\Carbon\Carbon::parse($transfer->due_date)->isoFormat('ll')); ?></p>
                                    <p class="person blue">Transfer by: <?php echo e($transfer->latest_task_log->assigned_by_user->name); ?></p>
                                  </div>
                                </div>
                              
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
            </div>

            <div class="col-2 col-lg-12 col-md-12 col-xs-12">
              <article id="myreports-panel" class="module">
                <h3 style="padding: 10px 0px 0px 10px;">Events</h3>
                 <!-- Events -->
                <div class="myreports-inner">
                  <div class="scroll-wrapper events_list">
                    <div class="scroll-inner">
                      <div class="myreports-content">
                        <input type="hidden" id="latest_events" value="<?php echo e((count($events)>0 ? $events[0]->id: '')); ?>" >
                        <div class="row" id="myEvents">
                          <?php if(!empty($events)): ?>
                            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <div class="col-12 col-sm-12 col-xs-12" id="events_<?php echo e($event->id); ?>" onclick="show_alert('<?php echo e($event->id); ?>', 'events')">
                                <div class="myreports-item pd-events">
                                  <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo e(Str::limit($event->name, 80)); ?>

                                  </p>
                                  <p class="person blue">Sector name: <?php echo e(($event->sectors?Str::limit($event->sectors->name, 27):'')); ?></p>
                                  <p class="person blue">Created By: <?php echo e(($event->created_by_user?$event->created_by_user->name:'')); ?></p>
                                  <p class="date red">Event Start date : <?php echo e(\Carbon\Carbon::parse($event->created_at)->isoFormat('ll')); ?></p>
                                </div>
                              </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
            </div>
            
            <div class="col-5 col-lg-12 col-md-12 col-xs-12">
              <article id="mng-sysalerts-panel" class="module">
                <input type="radio" id="systab1" name="tabo" checked>
                <label for="systab1"><h3>System Alerts</h3></label>
                <!--<input type="radio" id="systab2" name="tabo">
                <label for="systab2"><h3>Transfer Requests</h3></label>-->
                <div class="sysalerts-items">
                  <!-- tab 1 -->
                  <div class="sysalerts-inner" id="sys1">
                    <input type="hidden" id="latest_alert" value="<?= (!empty($alerts) && $alerts->count() > 0) ? $alerts[0]['id'] : 0 ?>" >
                    <div id="loading_image_on_alert" class="loader">Loading...</div>
                    <?php if(empty($alerts)): ?>
                      <div class="row" id="system_alerts_empty">
                          <button type="button" class="button" onclick="activeEventTab()">
                            Select events from MY EVENTS tab <br> to view system alerts
                          </button>
                      </div>
                    <?php endif; ?>
                    <div class="sysalerts-list">
                        <div class="scroll-inner">
                          <!--<div class="scrolling-pagination">-->
                            <div class="sysalerts-content">
                              <div class="alert_pagination row" id="alert_content">
                                <?php if(!empty($alerts)): ?>
                                  <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <div  class="alert-items col-4 col-sm-12 col-xs-12" id="alert_<?php echo e($alert->id); ?>" onclick="show_alert(<?= $alert->id ?>,'alert')" >
                                        <div class="sysalerts-item">
                                          <p><?php echo e(Str::limit($alert->title, 80)); ?></p>
                                          <p class="date red"><?php echo e(\Carbon\Carbon::parse($alert->created_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll')); ?></p>
                                          <p class="assign blue">
                                            <a href="<?php echo e(route('alerts.show',''.$alert->id)); ?>" target="_blank">Event Dashboard</a> | 
                                            <a href="javascript:void(0)" onclick="alert_archive(<?php echo e($alert->id); ?>, event)">Archive</a>
                                          </p>
                                        </div>
                                      </div>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  <?php echo e($alerts->links('pagination.alert')); ?>

                                <?php endif; ?>
                              </div>
                            </div>
                          <!--</div>-->
                        </div>
                    </div>
                  </div>
                </div>                
              </article>
            </div>
          </div>

          <div class="row">
              <div class="col-2 col-lg-6 col-md-6 col-xs-12">
                <article id="notification-panel" class="module">
                  <h3>Notification<br>panel</h3>
                  <input type="hidden" id="latest_activity" value="<?php echo e(count($activities) > 0 ? $activities[0]->id: 0); ?>" >
                  <div class="scroll-wrapper notification-list">
                    <div class="scroll-inner">
                      <div class="notification-content" id="notification-content">
                        <?php if($activities): ?>
                          <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <div class="notification-item">
                            <p>
                              <a href="javascript:void(0)" onclick="show_alert('<?php echo e($activity->subject->subject_id); ?>', '<?php echo e($activity->subject->subject_type); ?>')">
                              <?php if($activity->description == 'assign'): ?>
                                Task has been assigned
                              <?php elseif($activity->description == 'self_assign'): ?>
                                Task has been self assigned
                              <?php elseif($activity->description == 'transfer_request'): ?>
                                Task transfer request
                              <?php elseif($activity->description == 'completed'): ?>
                                Task completed
                              <?php elseif($activity->description == 'transfered'): ?>
                                Task has been transfered
                              <?php elseif($activity->description == 'reopen'): ?>
                                Task open for review again
                              <?php endif; ?>
                              </a>
                            </p>
                            <p class="date red">
                              <?php if($activity->description != 'completed'): ?>
                                Due Date - <?php echo e(\Carbon\Carbon::parse($activity->subject->due_date)->isoFormat('ll')); ?>

                              <?php else: ?>
                                Complete Date - <?php echo e(\Carbon\Carbon::parse($activity->updated_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('ll')); ?>

                              <?php endif; ?>
                            </p>
                            <p class="assign blue">
                              <?php if($activity->description == 'completed'): ?>
                                Completed By : <?php echo e($activity->causer->name); ?>

                              <?php else: ?>
                                Assigned To : <?php echo e($activity->getExtraProperty('assigned_to_name')); ?>

                              <?php endif; ?>
                            </p>
                            <p class="person <?php echo e($activity->subject->priority); ?>">
                              Priority: <?php echo e(ucfirst($activity->subject->priority)); ?>

                            </p>
                          </div>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                      </div>
                    </div>
                  </div>
                </article>
              </div>
              <div class="col-8 col-lg-12 first-lg col-md-12 first-md col-xs-12 first-xs">
                <article class="module">
                  <div id="loading_image" class="loader">Loading...</div>

                  <div class="row"  id="alert_panel_empty">
                      <button type="button" class="button">
                        No Alert selected <br> Select any alert to assign it to analyst
                      </button>
                  </div>
                  
                  <div class="row"  id="alert-panel" style="display:none">
                  </div>
                </article>
              </div>
              <div class="col-2 col-lg-6 col-md-6 col-xs-12">
                <article id="mng-ireports-panel" class="module">
                  <h3>INSTITUTIONAL<br>REPORTS</h3>
                  <input type="hidden" id="latest_institution_report" value="<?= $institution_report->count() > 0 ? $institution_report[0]['id'] : 0 ?>" >
                    <div class="scroll-wrapper ireports-list">
                      <div class="scroll-inner" id="ireport_content">   
                      
                        <div class="ireport-scrolling-pagination" id="ireport_pagination"> 
                          <?php $__currentLoopData = $institution_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="ireports-item ireports_<?php echo e($report['institution_report']); ?>" id="institution_report_<?php echo e($report['id']); ?>">
                              <div class="item-download">
                                <a href="<?php echo e(route('institution_report.download',$report['institution_report'])); ?>" class="download_pdf">
                                  <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                                <div id="icon_<?php echo e($report['institution_report']); ?>">
                                  <?php if($report['send_library']): ?>
                                    <a href="javascript:void(0)"><i class="fa fa-book" aria-hidden="true"></i></a>
                                  <?php endif; ?>
                                </div> 
                              </div>
                              <p><?php echo e(Str::limit(urldecode($report['name']), 28)); ?></p>
                              <p>Ref ID: <?php echo e($report['institution_report']); ?></p>
                              <p class="date red"><?php echo e(\Carbon\Carbon::parse($report['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll')); ?></p>
                              <p class ="assign blue">
                                <a href="javascript:void(0)" class="assign_to" onclick="assign_report_form('<?php echo e($report['id']); ?>', '<?php echo e($report['institution_report']); ?>')">Assign to</a>
                                |
                                <a href="javascript:void(0)" onclick="archive('<?php echo e($report['id']); ?>', '<?php echo e($report['institution_report']); ?>')">Archive</a> 
                                <?php if(!$report['send_library']): ?>
                                  <span id="library_<?php echo e($report['institution_report']); ?>">  | <a href="javascript:void(0)" class="send_to_library" onclick="send_to_library('<?php echo e($report['id']); ?>', '<?php echo e($report['institution_report']); ?>')">Send to Library</a> </span>
                                <?php endif; ?>
                              </p>
                            </div>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                          <?php echo e($institution_report->links('pagination.ireport')); ?>

                        </div>

                      </div>
                    </div>
                  </div>
                </article>
              </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <?php echo $__env->make('layouts.includes.footer-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  
  <?php echo $__env->make('layouts.includes.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <style type="text/css">
    .jscroll-inner {
        width: 100%;
    }

    div.alert-items {
      width: 33%;
      margin: 0px;
      display: inline-block;
      cursor:pointer;
    }

    #mng-sysalerts-panel .sysalerts-items .sysalerts-inner .sysalerts-list{
      height:auto;
    }

    div#alert_content{
      height: 300px;
    }

    #mng-ireports-panel .ireports-list{
      height: auto;
    }

    #ireport_pagination{
      height: 450px;
    }
  </style>
  <script>
    $(document).ready(function() {

      setInterval(function() {
        $.ajax({
          url: "<?php echo e(route('auth.check', '')); ?>",
          success: function( response ) {
            if(!response){
              window.location.href = "<?php echo e(route('login')); ?>";
            }
          }
        });
      }, 5000);
      
      setTimeout(latest_institution_report,5000);
      //setTimeout(latest_alert,5000);
      setTimeout(latest_events,5000);
      setTimeout(latest_inprogress,5000);
      setTimeout(latest_transfer_request,5000);
      setTimeout(latest_team_report,5000);
      setTimeout(latest_activities,5000);

      $(".scroll-wrapper").mCustomScrollbar();

      $(".ireport-scrolling-pagination").mCustomScrollbar({
        callbacks:{
            onTotalScroll:function(){
              if($('ul.ireport-pagination').length){
                $(".ireport-scrolling-pagination").mCustomScrollbar("disable");
                $('ul.ireport-pagination li.active + li a')[0].click();
              }
            }
        }
      });
      
      $('.ireport-scrolling-pagination .mCSB_container').jscroll({
          debug: true,
          autoTrigger: false,
          padding: 0, 
          nextSelector: 'ul.ireport-pagination li.active + li a',
          callback: function() {
            $('ul.ireport-pagination:first').remove();
            $(".ireport-scrolling-pagination").mCustomScrollbar("update"); 
          }
      });

      $(".alert_pagination").mCustomScrollbar({
        callbacks:{
            onTotalScroll:function(){
              if($('ul.alert-pagination li.active + li a').length){
                $(".alert_pagination").mCustomScrollbar("disable");
                $('ul.alert-pagination li.active + li a')[0].click();
              }
            }
        }
      });
      
      //modals
      $(".no-button").on("click", function() {
        var modal = $(this).data("modal");
        $(modal).show();
      });

      $('.search_radio').change(function(){
        if($(this).val() == 'search_title')
        {
          $("#search_ref_id").hide();
          $("input[name$=search_ref_id]").val("");
          $("#search_title").show();
        }
        if($(this).val() == 'search_ref_id')
        {
          $("#search_title").hide();
          $("input[name$=search_title]").val("");
          $("#search_ref_id").show();
        }
      });

      $("#close").on("click", function(e) {
        e.preventDefault();
        $('#assignTo').modal('hide');
      });

      $(".modal").on("click", function(e) {
        var className = e.target.className;
        if (className === "modal" || className === "close") {
          $(this).closest(".modal").hide();
        }
      });

      const my_calendar = new TavoCalendar('#my-calendar', {
        date: "<?php echo date('Y-m-d') ?>",
        range_select: true,
        multi_select: true,
        future_select: true,
        past_select: true,
        frozen: false
        //selected: ["<?php echo date('Y-m-d') ?>"]
      });

      flatpickr('#start-date', {
        onChange: null
      });

      flatpickr('#end-date', {
        onChange: null
      });
      
    });

    function activeEventTab(){
      $('#rewtab3').prop('checked',true);

    }

    function inactiveEventTab(){
      $('#rewtab3').prop('checked',false);
    }

    function view_as_analyst_popup(){
      $('#view_as_analyst_popup').modal('show');
    }

    function view_as_analyst_submit(){
      $('#assign_analyst').on('submit',function(e){          
        e.preventDefault();
        $.ajax({
          url: $(this).attr('action'),
          type:"POST",
          data: $(this).serialize(),
          beforeSend: function(){
            $("#assign_analyst .example-button").attr("disabled",true);
            $('.account').show();
            $('#filter').hide();
            $('#cancel').show();
          },
          success: function(data){
            $('.tooltiptext').html(data.view_as_analyst);
            $('#view_as_analyst_popup').modal('hide');
            if(data.success === true){
              if(data.latest_event_id != null)
                $("#latest_events").attr('value',data.latest_event_id);
                $("#myEvents").html(data.html[0]);
                $('#myReports').html(data.html[1]);
                $("#team_report_content").html(data.html[2]);

              }
            }
          });
      });
    }

    function send_to_library(id, report_name){
      $.ajax({
        url: "<?php echo e(route('institution_report.move_to_library', '')); ?>/"+id,
        type: 'PUT',
        dataType: 'json',
        data: {
            "_token": "<?php echo e(csrf_token()); ?>",
            "report_id": id
        },
        success: function(result) {
          if(result.status == 'Success'){
            $('#library_'+report_name).hide();
            $("#icon_"+report_name).html('<a href="javascript:void(0)"><i class="fa fa-book" aria-hidden="true"></i></a>');
            toastr.success(result.message);
          }else{
            toastr.error(result.message);
          }
        }
      });
    }

    function generateSemiAutomatic(task_id, subject_id){
        $.ajax({
            url: "<?php echo e(route('semi_automatic.store')); ?>",
            type: 'POST',
            dataType: 'json',
            data: {"_token": "<?php echo e(csrf_token()); ?>", 'task_id': task_id, 'subject_id': subject_id},
            success: function(result) {
                if(result.status == 'success'){
                    url = "<?php echo e(route('semi_automatic.create')); ?>/task/:task_id";
                    semi_automatic_url = url.replace(':task_id', task_id);
                    window.location.href = semi_automatic_url;
                }
                else{
                    toastr.error(result.message);
                }
            }
        });
    }

    function generateFullyManual(task_id){
        $.ajax({
            url: "<?php echo e(route('fully_manual.store')); ?>",
            type: 'POST',
            dataType: 'json',
            data: {"_token": "<?php echo e(csrf_token()); ?>", 'task_id': task_id},
           
            success: function(result) {
                if(result.status == 'success'){
                    var url = "<?php echo e(route('fully_manual.edit', ':id')); ?>";
                    fully_manual_edit_url = url.replace(':id', result.data.id);
                    window.location.href = fully_manual_edit_url;
                }
                else{
                    toastr.error(result.message);
                }
            }
        });
    }

    function generateProduct(task_id){
        $.ajax({
            url: "<?php echo e(route('product.store')); ?>",
            type: 'POST',
            dataType: 'json',
            data: {"_token": "<?php echo e(csrf_token()); ?>", 'task_id': task_id},
           
            success: function(result) {
                if(result.status == 'success'){
                    var url = "<?php echo e(route('product.edit', ':id')); ?>";
                    product_edit_url = url.replace(':id', result.data.id);
                    window.location.href = product_edit_url;
                }
                else{
                    toastr.error(result.message);
                }
            }
        });
    }

    function completeTask(task_id){
      swal({
        title: 'Are you sure?',
        text: "You want to complete and send this task!",
        type: 'warning',
        closeOnEsc: true,
        closeOnClickOutside: true,
        className: '',
        buttons: {
            cancel: {
                text: "Cancel",
                value: 'cancel',
                visible: true,
                className: "button btn-primary",
                closeModal: true,
            },
            catch: {
                text: "Complete & send",
                value: "ok",
                className: "btn button-red",
            },
        }
        }).then(function (value) {
          switch(value){
            case "ok":
              $.ajax({
                  url: "<?php echo e(route('tasks.complete', '')); ?>/"+task_id,
                  type: 'PUT',
                  dataType: 'json',
                  data: {"_token": "<?php echo e(csrf_token()); ?>"},
                  beforeSend: function(){
                      $(".send .example-button").attr("disabled",true);
                  },
                  success: function(result) {
                      if(result.status == 'success'){
                        //$('#'+result.data.subject_type+'_'+result.data.subject_id).remove();
                        $('#alert-panel').hide();
                        $('#alert_panel_empty').show();
                        $(".send .example-button").attr("disabled",false);
                        toastr.success(result.message);
                      }
                      else{
                        $(".send .example-button").attr("disabled",false);
                        toastr.error(result.message);
                      }
                  }
              });
            default:
              return true;
          }
        }, function (dismiss) {
      });
    }

    function task_reminder(){
      $.ajax({
        url: "<?php echo e(route('tasks.index', '')); ?>",
        type: 'GET',
        beforeSend: function(){
          $("#task_reminder_modal").show();
        },
        success: function(result) {
          $("#task_reminder_content").html(result);
          $("#task_reminder_modal .scroll-wrapper").mCustomScrollbar();
        }
      });
    }

    function assign_report_form(id){
      $('#report_id').val(id);
      $('#assignTo').modal('show');
      flatpickr('#due-date', {
        onChange: null
      });
      assignReportFormSubmit();
    }

    function alert_archive(id, e){
      e.stopImmediatePropagation();
      $.ajax({
        url: "<?php echo e(route('alerts.archive', '')); ?>/"+id,
        type: 'PUT',
        dataType: 'json',
        data: {
            "_token": "<?php echo e(csrf_token()); ?>",
            "alert_id": id
        },
        success: function(result) {
          if(result.status == 'Success'){
            if($('#alert-show-'+id).length > 0){
              $('#alert-panel').hide();
              $('#alert_panel_empty').show();
            }

            $('#alert_'+id).remove();
            toastr.success("System alert has been archived");
          }
          else{
            toastr.error("Failed to archive system alert");
          }
        }
      });
    }

    function archive(id, report_name){
      $.ajax({
        url: "<?php echo e(route('institution_report.archive', '')); ?>/"+id,
        type: 'PUT',
        dataType: 'json',
        data: {
            "_token": "<?php echo e(csrf_token()); ?>",
            "report_id": id
        },
        success: function(result) {
          if(result.status == 'Success'){
            $('#institution_report_'+id).remove();
            toastr.success(result.message);
          }
          else{
            toastr.error(result.message);
          }
        }
      });
    }

    function show_alert(id, type){
      var url;
      if(type == 'alert'){
        url = "<?php echo e(route('alerts.show', '')); ?>/"+id;
      }else if(type == 'freeform_report'){
        url = "<?php echo e(route('freeform_report.show', '')); ?>/"+id;
      }else if(type == 'institution_report'){
        url = "<?php echo e(route('institution_report.show', '')); ?>/"+id;
      }else if(type == 'events'){
        url = "<?php echo e(route('events.show', '')); ?>/"+id;
      }else{
        url = "<?php echo e(route('external_report.show', '')); ?>/"+id;
      }
      $.ajax({
        url: url,
        type: 'GET',
        data: {'type':type},
        beforeSend: function() {
          $(".sysalerts-item").removeClass('selected');
          $(".myreports-item").removeClass('selected');
          $("#"+type+"_"+id+" .sysalerts-item").addClass('selected');
          $("#"+type+"_"+id).find(".myreports-item").addClass('selected');
          $("#alert_panel_empty").hide();
          $("#alert-panel").hide();
          $("#loading_image").show();
        },
        success: function(result) {
          $("#alert-panel").html(result);
          $("#loading_image").hide();
          $("#alert-panel").show(); 
          if(type == 'events'){
            $("#system_alerts_empty").hide();
            $("#loading_image_on_alert").show();
            event_alert(id);
          }
          $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            nav: true,
            dots: false,
            responsive: {
              0: {
                items: 2
              },
              600: {
                items: 3
              },
              1000: {
                items: 4
              }
            }
          });
          
          var $gallery = new SimpleLightbox('.gallery div a', {});

          $(".scroll-wrapper").mCustomScrollbar();
          flatpickr('#due-date', {
            onChange: null
          });

          addCommentFormSubmit(); //On Submit comment form
          assignAlertFormSubmit(); //On Submit assign task form
          transferFormSubmit(); //On Submit assign task forms
          
          $("#detail_event_info").mCustomScrollbar();

          var summary_meaning = $('p#alert_summary');

          summary_meaning.html(function(index, oldHtml) {
              return oldHtml.replace(/\b(\w+?)\b/g, '<span class="word">$1</span>')
          });

          summary_meaning.dblclick(function(event) {
              if(this.id != event.target.id) {
                  word_definition(event.target.innerHTML);
              }
          });

          var title_meaning = $('div#alert_title');

          title_meaning.html(function(index, oldHtml) {
              return oldHtml.replace(/\b(\w+?)\b/g, '<span class="word">$1</span>')
          });

          title_meaning.dblclick(function(event) {
              if(this.id != event.target.id) {
                  word_definition(event.target.innerHTML);
              }
          });

        },
        error:function(response, error){
            $("#loading_image").hide();
            if(type == 'events')
              $("#loading_image_on_alert").hide();
            toastr.error(JSON.parse(response.responseText));
        }
      });
    }

    function addCommentFormSubmit(){
      $('#commentForm').on('submit',function(e){
        e.preventDefault();
        $.ajax({
          url: "alerts/comment",
          type: 'POST',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(result) {
            if(result.status == 'success'){
              $("#commentForm")[0].reset();
              $("#no_comment").hide();
              $("#comment_section").prepend(result.data);
              toastr.success(result.message);
            }
          },
          error: function(response, error){
            toastr.error(JSON.parse(response.responseText));
          }
        });
      });
    }

    function assignAlertFormSubmit(){
      $('#assign_to').on('submit',function(event){
        event.preventDefault();
        $.ajax({
          url: $(this).attr('action'),
          type:"POST",
          data: $(this).serialize(),
          beforeSend: function(){
            $("#assign_to .example-button").attr("disabled",true);
          },
          success:function(response){
            if(response.status == 'Success'){
              $("#latest_inprogress").attr('value', dateToTimestamp(response.data.updated_at));
              $('#'+response.data.subject_type+'_'+response.data.subject_id).remove();
              $('#alert-panel').hide();
              $('#alert_panel_empty').show();
              $('#myReports').prepend(response.task_card);
              $("#assign_to .example-button").attr("disabled",false);
              toastr.success(response.message);
            }
          },
          error:function(response, error){
            $("#assign_to .example-button").attr("disabled",false);
            toastr.error(JSON.parse(response.responseText));
          }
        });
      });
    }

    function assignReportFormSubmit(){
      $("#assign_to_form").submit(function(){ return false; });   
      $('#assign_to_form').on('submit',function(event){         
        event.preventDefault();
        $.ajax({
          url: $(this).attr('action'),
          type:"POST",
          data: $(this).serialize(),
          beforeSend: function(){
            $("#assign_to_form .example-button").attr("disabled",true);
          },
          success:function(response){
            if(response.status == 'Success'){
              $("#latest_inprogress").attr('value', dateToTimestamp(response.data.updated_at));
              $('#assignTo').modal('hide');
              $('#institution_report_'+response.data.subject_id).remove();
              $('#myReports').prepend(response.task_card);
              $("#assign_to_form .example-button").attr("disabled",false);
              toastr.success("Report Assign to analyst successfully");
            }
          },
          error:function(response, error){
            $("#assign_to_form .example-button").attr("disabled",false);
            toastr.error(JSON.parse(response.responseText));
          }
        });
      });
    }

    function reopen(task_id){
      
      $.ajax({
          url: "<?php echo e(route('tasks.reopen', '')); ?>/"+task_id,
          type: 'PUT',
          dataType: 'json',
          data: {"_token": "<?php echo e(csrf_token()); ?>"},
          beforeSend: function(){
              $(".reopen .example-button").attr("disabled",true);
          },
          success: function(response) {
              if(response.status == 'success'){
                $("#latest_inprogress").attr('value', dateToTimestamp(response.data.updated_at));
                $('#'+response.data.subject_type+'_'+response.data.subject_id).remove();
                $('#alert-panel').hide();
                $('#alert_panel_empty').show();
                $('#myReports').prepend(response.task_card);
                $("#reopen .example-button").attr("disabled",false);
                toastr.success(response.message);
              }
              else{
                $(".reopen .example-button").attr("disabled",false);
                toastr.error(response.message);
              }
          }
      });
      
    }

    function latest_institution_report(){
      var id = $("#latest_institution_report").val();

      $.ajax({
        url: '<?php echo e(route("institution_report.latest_institution_report")); ?>',
        type: 'get',
        data: {
            "id": id
        },
        success: function(data){
          if(data.success === true){
            if(data.latest_id != null)
              $("#latest_institution_report").attr('value',data.latest_id);
              $("#ireport_pagination .jscroll-inner").prepend(data.html);
          }
        },
        complete:function(data){
          setTimeout(latest_institution_report,5000);
        }
      });
    }

    function latest_alert(){
      var id = $("#latest_alert").val();

      $.ajax({
        url: '<?php echo e(route("alerts.latest_alert")); ?>',
        type: 'get',
        data: {
            "id": id
        },
        success: function(data){
          if(data.success === true){
            if(data.latest_id != null)
              $("#latest_alert").attr('value',data.latest_id);
              $("#alert_content .jscroll-inner").prepend(data.html);
          }
        },
        complete:function(data){
          setTimeout(latest_alert,5000);
        }
      });
    }

    function latest_events(){
      var event_id = $("#latest_events").val();

      $.ajax({
        url: '<?php echo e(route("events.latest_events")); ?>',
        type: 'get',
        data: {
            "id": event_id
        },
        success: function(data){
          if(data.success === true){
            if(data.latest_event_id != null)
              $("#latest_events").attr('value',data.latest_event_id);
              $("#myEvents").prepend(data.html);
          }
        },
        complete:function(data){
          setTimeout(latest_events,5000);
        }
      });
    }

    function latest_inprogress(){
      var updated_at = $("#latest_inprogress").val();
      
      $.ajax({
        url: '<?php echo e(route("tasks.latest_inprogress")); ?>',
        type: 'get',
        data: {
            "updated_at": updated_at
        },
        success: function(response){
          if(response.success === true){

            if(response.data.length){
              $.each(response.data, function( index, value ) {
                if($('#'+value.subject_type+'_'+value.subject_id).get(0)){
                  $('#'+value.subject_type+'_'+value.subject_id).remove();
                }
              });
              $("#latest_inprogress").attr('value', dateToTimestamp(response.data[0].updated_at));
              $('#myReports').prepend(response.html);
            }

          }
        },
        complete:function(response){
          setTimeout(latest_inprogress,5000);
        }
      });
    }

    function latest_transfer_request(){
      var updated_at = $("#latest_transfer_request").val();
     
      $.ajax({
        url: '<?php echo e(route("tasks.latest_transfer_request")); ?>',
        type: 'get',
        data: {
            "updated_at": updated_at
        },
        success: function(response){
          if(response.success === true && response.data.length){
            $.each(response.data, function( index, value ) {
              if($("#"+value.subject_type+"_"+value.subject_id).length) 
                  $("#"+value.subject_type+"_"+value.subject_id).remove();
            });
            $("#latest_transfer_request").attr('value', dateToTimestamp(response.data[0].updated_at));
            $("#transfer_request_content").prepend(response.html);
          }

        },
        complete:function(response){
          setTimeout(latest_transfer_request,5000);
        }
      });
    }

    function latest_team_report(){
      var completed_at = $("#latest_team_report").val();
      
      $.ajax({
        url: '<?php echo e(route("tasks.latest_team_report")); ?>',
        type: 'get',
        data: {
            "completed_at": completed_at
        },
        success: function(response){
          if(response.data.length){
            $.each(response.data, function( index, value ) {
                if ( $("#"+value.subject_type+"_"+value.subject_id).length ) 
                    $("#"+value.subject_type+"_"+value.subject_id).remove();
            });
            $("#latest_team_report").attr('value', dateToTimestamp(response.data[0].completed_at));
            $("#team_report_content").prepend(response.html);
          }
        },
        complete:function(response){
          setTimeout(latest_team_report,5000);
        }
      });
    }

    function latest_activities(){
      var latest_id = $("#latest_activity").val();
      $.ajax({
        url: '<?php echo e(route("latest_activities")); ?>',
        type: 'get',
        data: {
            "latest_id": latest_id
        },
        success: function(response){
          if(response.data.length){
            $("#latest_activity").val(response.data[0].id);
            $("#notification-content").prepend(response.html);
          }
        },
        complete:function(response){
          setTimeout(latest_activities,5000);
        }
      });
    }

    function event_alert(id){
      $.ajax({
        url: '<?php echo e(route("alerts.event_alert")); ?>',
        type: 'get',
        data: {
            "event_id": id
        },
        beforeSend: function(){
          $("#loading_image_on_alert").show();
          $("#alert_content .mCSB_container").html('');
        },
        success: function(data){
          if(data.success === true){
            if(data.latest_id != null)
              $("#latest_alert").attr('value',data.latest_id);
              $("#loading_image_on_alert").hide();

              $('#alert_content .mCSB_container').html(data.html);
              
              $(".alert_pagination").mCustomScrollbar({
                callbacks:{
                    onTotalScroll:function(){
                      if($('ul.alert-pagination li.active + li a').length){
                        $(".alert_pagination").mCustomScrollbar("disable");
                        $('ul.alert-pagination li.active + li a')[0].click();
                      }
                    }
                }
              });
              
              var pane = $('#alert_content .mCSB_container');
              pane.data('jscroll', null);
              
              pane.jscroll({
                  debug: true,
                  autoTrigger: false,
                  padding: 0,
                  refresh: true,
                  nextSelector: 'ul.alert-pagination li.active + li a',
                  callback: function() {
                    $('ul.alert-pagination:first').remove();
                    $(".alert_pagination").mCustomScrollbar("update"); 
                  }
              });

              $(".marquee-horz .js-marquee").html('');
              $.each(data.alerts_title,function(index,value){
                $(".marquee-horz .js-marquee").append('<span>'+value+'</span><span>&nbsp;&nbsp;&nbsp;</span>');
              });
              $('.marquee-horz').marquee({
                  direction: 'left',
                  speed: 50000
              });
          }
        }
      });
    }

    function detail_event_info(event_id, detail_type){
        $.ajax({
        url: '<?php echo e(route("events.detail_event_info")); ?>',
        type: 'get',
        data: {
            "event_id": event_id,
            "detail_type": detail_type
        },
        success: function(response){
            $("#detail_event_info .mCSB_container").html('');
            if(response.data[0] != ""){
              $.each(response.data,function(index,value){
                if(detail_type == 'departments'){
                  $("#dynamic_head").html('Categories');
                  $("#detail_event_info .mCSB_container").append('<article class="panel module_bottom">'+value.name+'</article>');
                }
                else if(detail_type == 'keywords'){
                  $("#dynamic_head").html('Keywords');
                  $("#detail_event_info .mCSB_container").append('<article class="panel module_bottom">'+value+'</article>');
                }
                else if(detail_type == 'sites'){
                  $("#dynamic_head").html('Sites');
                  $("#detail_event_info .mCSB_container").append('<article class="panel module_bottom">'+value+'</article>');
                }
              });
            }
            else {
              $("#dynamic_head").html(detail_type);
              $("#detail_event_info .mCSB_container").html('<button type="button" class="button no_event_info"> No '+detail_type+' found'+ '</button>');
            }

            $("#detail_event_info").mCustomScrollbar("update"); 
        },
        error: function(response, error){
          toastr.error(JSON.parse(response.responseText));
        }
      });
    }


    function report_modal(type){
        if(type == 'fully_manual'){
            $("#report_modal .btn_fully_manual").show();
            $("#report_modal .btn_semi_automatic").hide();
            $("#report_modal .btn_automatic").hide();
            $("#report_modal .btn_product").hide();
        }else if(type == 'product'){
            $("#report_modal .btn_product").show();
            $("#report_modal .btn_semi_automatic").hide();
            $("#report_modal .btn_fully_manual").hide();
            $("#report_modal .btn_automatic").hide();
        }
        else if(type == 'semi_automatic'){
            $("#report_modal .btn_semi_automatic").show();
            $("#report_modal .btn_fully_manual").hide();
            $("#report_modal .btn_automatic").hide();
            $("#report_modal .btn_product").hide();
        }else if(type == 'automatic'){
          $("#report_modal .btn_semi_automatic").hide();
          $("#report_modal .btn_fully_manual").hide();
          $("#report_modal .btn_automatic").show();
            $("#report_modal .btn_product").hide();
        }
        $("#report_modal").modal('show');
    }
    
    $("#regenerate").bind( "click", function() {
      regenerate();
    });

    function regenerate(id, type){
      if(type == 'freeform_report')
        var url = "<?php echo e(route('freeform_report.regenerate', '')); ?>/"+id;
      else if(type == 'fully_manual')
        var url = "<?php echo e(route('fully_manual.regenerate', '')); ?>/"+id;
      else if(type == 'product')
        var url = "<?php echo e(route('product.regenerate', '')); ?>/"+id;
      else if(type == 'semi_automatic')
        var url = "<?php echo e(route('semi_automatic.regenerate', '')); ?>/"+id;
      else if(type == 'automatic'){
        var alert_edit_url = "<?php echo e(route('alerts.edit', ':id')); ?>";
        var url = alert_edit_url.replace(':id', id);
        window.open(url);
        return false;
      }

      $.ajax({
        url: url,
        type: 'get',
        success: function(response){
          if(response.status == 'Success' && type == "freeform_report"){
            window.open('<?php echo e(route('freeform_report.report_create', '')); ?>/'+response.id);
          }
          else if(response.status == 'Success' && type == "fully_manual"){
            window.open('admin/fully_manual/'+response.id+'/edit');
          }
          else if(response.status == 'Success' && type == "product"){
            window.open('admin/product/'+response.id+'/edit');
          }
          else if(response.status == 'Success' && type == "semi_automatic"){
            window.open('<?php echo e(route('semi_automatic.create', '')); ?>/task/'+response.id);
          }
        }
      });
    }

    function transferFormSubmit(){
      //self assign function
      $('#transfer_form').on('submit',function(event){          
          event.preventDefault();
          swal({
              title: 'Are you sure?',
              text: "You want to transfer this task!",
              type: 'warning',
              closeOnEsc: true,
              closeOnClickOutside: true,
              className: '',
              buttons: {
                  cancel: {
                      text: "Cancel",
                      value: 'cancel',
                      visible: true,
                      className: "button btn-primary",
                      closeModal: true,
                  },
                  catch: {
                      text: "Transfer",
                      value: "ok",
                      className: "btn button-red",
                  },
              }
            }).then(function (value) {
              switch(value){
                  case "ok":
                    $.ajax({
                      url: $("#transfer_form").attr('action'),
                      type:"POST",
                      data: $("#transfer_form").serialize(),
                      beforeSend: function(){
                        $("#transfer_form .example-button").attr("disabled",true);
                      },
                      success:function(response){
                        if(response.status == 'Success'){
                          $('#myReports #'+response.data.subject_type+'_'+response.data.subject_id).remove();
                          $('#alert-panel').hide();
                          $('#alert_panel_empty').show();
                          $("#transfer_form .example-button").attr("disabled",false);
                          toastr.success(response.message);
                      }
                      },
                      error:function(response, error){
                        $("#transfer_form .example-button").attr("disabled",false);
                        toastr.error(JSON.parse(response.responseText));
                      }
                    });
                    default:
                      return true;
              }
              
            }, function (dismiss) {
          });
        });
    }
    
  </script>
</body>

</html>
<?php /**PATH /Volumes/Data/sfdbd_new/resources/views/manager/index.blade.php ENDPATH**/ ?>