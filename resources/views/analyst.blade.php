<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>NEWS-{{$name}}</title>
    @include('layouts.includes.head')
    <style type="text/css">
      #alert_panel_empty { 
        position: absolute; left: 50%; top: 50%; transform: translateX(-50%) translateY(-50%); cursor: text !important; 
      }
      #system_alerts_empty { 
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 9999;
        transform: translateX(-50%) translateY(-50%);
        cursor: text !important;
      }
      #alert-panel .value{ font-size: 14px; }
      #loading_image{ display:none; }
      .mg-top { margin-top: 15px; }
      .center{ display: block; margin-left: 30%; margin-top: 18%; }
      .module{ height: 600px }
      .myreports-item:hover{background: #153753;}
      .selected{background: #153753;}
      #alert-panel .summary-list{ height: 140px !important}
      #alert-panel .url-list{ height: 250px !important}
      #alert-panel .department-list { height: 70px !important}
      .comment-list {  height: 200px !important}
      #alert-panel .alert-keyword .item-left .keywords-list { height: 70px !important}
      h3{ font-size: 16px;}
      #task_reminder_modal .modal-content{ min-height: 600px; max-height: 650px; min-width: 70%;}
      #task_reminder_content tr td {
        padding: 15px 0px;
        color: #fff;
        border-bottom: 1px solid #33477c;
      }
      .task-list{
        height: 600px;
      }
      .swal-button:not([disabled]):hover{
        background-color: #e8e8e8;
      }
      .swal-button{
        border: 0px;
      }
      .person{
        font-weight: 700;
      }
      /* Style for Manager Dashboard */
      #mng-box-panel{
        height: 960px;
      }
      #mng-box-panel .panel-item{
        width: 100%
      }
      .side_panel{
        float:left;
        width: 75%;
      }
      .link-txt{
        text-align: center;
        width: 100%;
      }
      #myalerts-panel{
        height: 350px;
      }
      .first_row{
        height: 350px;
        padding-right: 0px;
      }
      .second_row, #ireports-panel{
        height: 600px;
        padding-right: 0px;
      }
      #ireports-panel .ireports-list {
          height: 555px;
          overflow:hidden;
      }
      #myalerts-panel .myalerts-list,
      #myreports-panel .myreports-items .myreports-inner,
      #myreports-panel .myreports-items .myreports-inner .myreports-list ,
      .events_list
       {
          height: 290px;
      }
      .pd-events{
        padding:3px 0px 5px 10px;
        margin-bottom: 10px;
      }

      #sysalerts-panel{
        overflow:hidden;
        width: 100%;
        height: 960px;
      }

      #alert_content{
        height: 890px !important;
      }

      #ireport_content{
        height: 740px;
      }

    </style>
  </head>
  <body>
    <div class="wrapper">
      <div class="wrap container-fluid">
        <!-- header section start -->
        @include('layouts.includes.header')
        <!-- header section end -->

        <!-- alert navigation start -->
        @include('layouts.includes.alert-dashboard')
        <!-- alert navigation end -->
        <section id="working-area" class="row">
          <div class="col-12">
            <div class="col-1 col-lg-1 col-md-1 col-sm-1 col-xs-1 side_panel">
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
                  <button class="no-button" onclick="window.open('{{ route('events.index') }}')">
                    <div class="panel-icon"><img src="images/data-entry.png" alt="data-entry" class="icon"></div>
                      <div class="panel-txt">Data<br>Entry</div>
                  </button>
                </div>
                <div class="panel-item">
                  <button class="no-button" onclick="window.open('{{ route('all') }}')">
                    <div class="panel-icon"><img src="images/library.svg" alt="library" class="icon"></div>
                    <div class="panel-txt">Library</div>
                  </button>
                </div>
                <div class="panel-item">
                  <button class="no-button" onclick="window.open('{{ route('google_search.index') }}')">
                    <div class="panel-icon"><img src="images/google-search.png" alt="library" class="icon"></div>
                      <div class="panel-txt">Google Search</div>
                  </button>
                </div>
                <div class="panel-item" style="margin-left:10px;">
                  <a href="{{ route('translate.index') }}" target="_blank">
                    <div class="panel-icon"><img src="images/translation.png" alt="library" class="icon"></div>
                    <div class="link-txt">Translate </div>
                  </a>
                </div>
                <div class="panel-item" style="margin-left:10px;">
                  <a href="{{ route('tasks.index') }}" target="_blank">
                    <div class="panel-icon"><img src="images/go-to-panel.png" alt="library" class="icon"></div>
                    <div class="link-txt">Go to<br> Panel <i class="fa fa-share-square-o" aria-hidden="true"></i></div>
                  </a>
                </div>
                <div class="panel-item" style="margin-left:10px;">
                  <a href="{{ route('freeform_report.create') }}" style="text-align:center" target="_blank">
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
                          <table style="width:100%; table-layout:auto" aria-describedby=""  border="0">
                              <thead>
                                <tr class="task_reminder">
                                  <th scope="col" style="width:40%">Task Name</th>
                                  <th scope="col" style="width:10%">Status</th>
                                  <th scope="col" style="width:10%">Priority</th>
                                  <th scope="col" style="width:10%">Start Date</th>
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
                    {{ Form::open(['method' => 'get', 'class' => 'advanced-search', 'url'=> 'library/all', 'id'=>'filter_search' ]) }}
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
                    {{ Form::close() }}
                  </div>
                </div>
              </div>  

            </div>
            
            <div class="col-9 row side_panel" style="padding-right: 0px;">
              <div class="row col-12 first_row">
              
                <div class="col-3">
                  <article id="myalerts-panel" class="module">
                    <h3>My Alerts</h3>
                    <input type="hidden" id="latest_activity" value="{{ count($activities) > 0 ? $activities[0]->id: 0 }}" >
                    <div class="scroll-wrapper myalerts-list">
                      <div class="scroll-inner">
                        <div class="myalerts-content" id="notification-content">
                          @if($activities)
                            @foreach($activities as $key => $activity)
                            <div class="myalerts-item">
                              <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?php if($activity->subject->latest_task_log->assigned_to == auth()->user()->id && $activity->description != 'transfer_request') { ?> 
                                  <a href="javascript:void(0)" onclick="show_alert('{{ $activity->subject->subject_id }}', '{{ $activity->subject->subject_type }}')" > 
                                <?php }else{ ?>
                                  <span style="color: #bbb4b4">
                                <?php } ?>
                                @if($activity->description == 'assign' || $activity->description == 'transfered')
                                    Task has been assigned
                                @elseif($activity->description == 'self_assign')
                                    Task has been self assigned
                                @elseif($activity->description == 'transfer_request')
                                  Task transfer requested to manager
                                @elseif($activity->description == 'completed')
                                    Task completed
                                @elseif($activity->description == 'reopen')
                                    Task open for review again
                                @endif
                                <?php if($activity->subject->latest_task_log->assigned_to == auth()->user()->id) { ?> 
                                  </a>
                                <?php }else{ ?>
                                  </span>
                                <?php } ?>
                              </p>
                              <p class="date red">
                                @if($activity->description != 'completed')
                                  Due Date - {{ \Carbon\Carbon::parse($activity->subject->due_date)->isoFormat('ll') }}
                                @else
                                  Complete Date - {{ \Carbon\Carbon::parse($activity->updated_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('ll') }}
                                @endif
                              </p>
                              <p class="assign blue">
                                @if($activity->description == 'completed')
                                @elseif($activity->description == 'self_assign')
                                @else
                                  Assigned By : {{ $activity->causer->name }}
                                @endif
                              </p>
                              <p class="person {{ $activity->subject->priority }}">
                                Priority: {{ ucfirst($activity->subject->priority) }}
                              </p>
                            </div>
                            @endforeach
                          @endif

                        </div>
                      </div>
                    </div>
                  </article>
                </div>

                <div class="col-6">
                  <article id="myreports-panel" class="module">
                    
                    <input type="radio" id="rewtab1" name="tab" onchange="inactiveEventTab()" >
                    <label for="rewtab1"><h3>Completed Reports</h3></label>
                    <input type="radio" id="rewtab2" name="tab" onchange="inactiveEventTab()" checked>
                    <label for="rewtab2"><h3>in progress</h3></label>
                    <!--<input type="radio" id="rewtab3" name="tab">
                    <label for="rewtab3"><h3>Events</h3></label>-->
                    <div class="myreports-items">
                      <!-- tab 1 -->
                      <div class="myreports-inner" id="rew1">
                        <div class="scroll-wrapper myreports-list">
                          <div class="scroll-inner">
                            <div class="myreports-content">
                              <input type="hidden" id="latest_team_report" value="{{ count($tasks_completed) > 0 ? \Carbon\Carbon::parse($tasks_completed[0]->completed_at, 'UTC')->timestamp : \Carbon\Carbon::now()->timestamp }}" >
                              <div class="row"  id="team_report_content">
                                @foreach($tasks_completed as $task)
                                <div class="col-6 col-sm-12 col-xs-12" style="cursor:pointer" id="{{ $task->subject_type.'_'.$task->subject_id }}" onclick="show_alert('{{ $task->subject_id }}', '{{ $task->subject_type }}')">
                                    <div class="myreports-item">
                                      <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                          @if($task->subject_type === 'alert' ||  $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report')
                                            {{ Str::limit($task->subject->title, 80) }}
                                          @else
                                            {{ Str::limit($task->subject->name, 80) }}
                                          @endif
                                      </p>
                                      <p class="date red">
                                          Completed Date : {{ \Carbon\Carbon::parse($task->completed_at, 'UTC')->setTimezone(auth()->user()->timezone)->isoFormat('lll') }}
                                      </p>
                                      <p class="person blue">
                                        @if($task->semi_automatic && $task->semi_automatic->status == 'complete')
                                        <a href="{{ route('semi_automatic.download', $task->semi_automatic->ref_id) }}">
                                          Semi Automatic &nbsp;<i class="fa fa-download" aria-hidden="true"></i>  &nbsp;&nbsp; 
                                        </a>
                                        @endif
                                        @if($task->fully_manual && $task->fully_manual->status == 'complete')
                                        <a href="{{ route('fully_manual.download', $task->fully_manual->ref_id) }}">
                                          Fully Manual Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                        @if($task->product && $task->product->status == 'complete')
                                        <a href="{{ route('product.download', $task->product->ref_id) }}">
                                          Product Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                        @if($task->subject_type == 'freeform_report' && $task->subject->status == 'complete')
                                        <a href="{{ route('freeform_report.download', $task->subject->ref_id) }}">
                                            Free Form Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                      
                                      </p>
                                    </div>
                                </div>
                                @endforeach
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
                              <input type="hidden" id="latest_inprogress" value="{{ count($tasks) > 0 ? \Carbon\Carbon::parse($tasks[0]['updated_at'], 'UTC')->timestamp : \Carbon\Carbon::now()->timestamp }}" >
                              <div class="row" id="myReports">
                                @foreach($tasks as $task)
                                <div class="col-6 col-sm-12 col-xs-12" id="{{ $task->subject_type }}_{{ $task->subject_id }}" onclick="show_alert('{{ $task->subject_id }}','{{ $task->subject_type }}')">
                                  <div class="myreports-item"  style="cursor:pointer">
                                    <div class="sysalerts-item">
                                      <p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        @if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report')
                                          {{ Str::limit($task->subject->title, 80) }}
                                        @else
                                          {{ Str::limit($task->subject->name, 80) }}
                                        @endif
                                      </p>
                                      <p class="date blue">Due Date : {{ \Carbon\Carbon::parse($task->due_date)->isoFormat('ll') }}</p>
                                      <p class="person priority {{ $task->priority }}">Priority: {{ ucfirst($task->priority) }}</p>
                                      
                                    </div>
                                  </div>
                                </div>
                                @endforeach
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- tab 3 -->
                      <!--<div class="myreports-inner" id="rew3">
                        <div class="scroll-wrapper myreports-list">
                          <div class="scroll-inner">
                            <div class="myreports-content">
                              <input type="hidden" id="latest_events" value="{{ (count($events)>0 ? $events[0]->id: '') }}" >
                              <div class="row" id="myEvents">
                              @if(!empty($events))
                              @foreach($events as $event)
                                <div class="col-6 col-sm-12 col-xs-12" id="events_{{$event->id}}" style="curson:pointer" onclick="show_alert('{{ $event->id }}', 'events')">
                                  <div class="myreports-item">
                                    <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                      {{ Str::limit($event->name, 80) }}
                                    </p>
                                    <p class="person blue">Sector name: {{ ($event->sectors?Str::limit($event->sectors->name, 27):'') }}</p>
                                    <p class="person blue">Created By: {{ (($event->created_by_user)?$event->created_by_user->name : 'Anonymous') }}</p>
                                    <p class="date red">Event Start date : {{ \Carbon\Carbon::parse($event->created_at)->isoFormat('ll') }}</p>
                                  </div>
                                </div>
                                @endforeach
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>-->
                    </div>
                  </article>
                </div>

                <div class="col-3">
                  <article id="myreports-panel" class="module">
                    <h3 style="padding: 10px 0px 0px 10px;">Events</h3>
                      <!-- Events -->
                      <div class="myreports-inner">
                        <div class="scroll-wrapper events_list">
                          <div class="scroll-inner">
                            <div class="myreports-content">
                              <input type="hidden" id="latest_events" value="{{ (count($events)>0 ? $events[0]->id: '') }}" >
                              <div class="row" id="myEvents">
                                @if(!empty($events))
                                  @foreach($events as $event)
                                    <div class="col-12 col-sm-12 col-xs-12" id="events_{{$event->id}}" onclick="show_alert('{{ $event->id }}', 'events')">
                                      <div class="myreports-item pd-events">
                                        <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                          {{ Str::limit($event->name, 80) }}
                                        </p>
                                        <p class="person blue">Sector name: {{ ($event->sectors?Str::limit($event->sectors->name, 27):'') }}</p>
                                        <p class="person blue">Created By: {{ ($event->created_by_user?$event->created_by_user->name:'') }}</p>
                                        <p class="date red">Event Start date : {{ \Carbon\Carbon::parse($event->created_at)->isoFormat('ll') }}</p>
                                      </div>
                                    </div>
                                  @endforeach
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </article>
                </div>
              </div>

              <div class="row col-12 second_row" style="margin-top: 10px">
              
                  <!-- self assign institutional report pop up -->
                  <div id="report_popup" class="modal" tabindex="-1" role="dialog" aria-labelledby="assignToLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title" id="crudFormLabel">Self assign</h4>
                          </div>
                          <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data" id='self_assign_report'>
                              {{ csrf_field() }}
                              <!-- name Form Input -->
                              <input type="hidden" name="type" value="institutional_report">
                              
                              <input type="hidden" class="report_id" name="report_id">
                              <div class="col-lg-12 col-md-12 modal-body">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                  <div class="select_date mg-top">
                                      <input type="text" id="due-date" autoComplete="off" name="due_date" placeholder="Select Due Date">
                                  </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                  <div class="select_priority mg-top">
                                  {!! Form::select('priority',['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'], null, ['placeholder' => 'Select Priority', 'class' => 'form-control']) !!}
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer  mg-top">  
                                  <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right">
                                    <button class="button button-red" id="close" style="margin-right: 5px;"> Cancel </button>
                                    <!-- Submit Form Button -->
                                    {!! Form::button('Assign', ['type'=>'submit','class' => 'button ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
                                  </div> 
                              </div>
                          </form>
                        </div>
                    </div>
                  </div>

                  <div class="col-3 col-xs-3">
                    <article id="ireports-panel" class="module">
                      
                      <h3>INSTITUTIONAL REPORTS</h3>
                      
                      <input type="hidden" id="latest_institution_report" value="<?= $institution_report->count() > 0 ? $institution_report[0]['id'] : 0 ?>" >
                      <div class="ireports-list">
                        <div class="scroll-inner" id="ireport_content">
                            @if(@$institution_report) 
                              @foreach(@$institution_report as $key => $report)
                                <div class="ireports-item ireports_{{ $report['institution_report'] }}" id="institution_report_{{ $report['id'] }}">
                                  <div class="item-download"> 
                                    <a href="{{ route('institution_report.download', $report['institution_report']) }}">
                                      <i class="fa fa-download" aria-hidden="true"></i>
                                    </a><br>
                                    <div id="icon_{{ $report['institution_report'] }}">
                                        @if($report['send_library'])
                                          <a href=""><i class="fa fa-book" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                  </div>
                                  <p>{{ Str::limit($report['name'], 28) }}</p>
                                  <p>Ref ID: {{ $report['institution_report'] }}</p>
                                  <p class="date red">{{ \Carbon\Carbon::parse($report['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</p>
                                  <p class="assign blue">
                                    <a href="javascript:void(0)" onclick="assign_institution_report('{{ $report['id'] }}', '{{ $report['institution_report'] }}')">Self Assign</a> | 
                                    <a href="javascript:void(0)" onclick="archive('{{ $report['id'] }}', '{{ $report['institution_report'] }}')">Archive</a>
                                    @if(!$report['send_library'])
                                      <span id="library_{{ $report['institution_report'] }}">  | <a href="javascript:void(0)" class="send_to_library" onclick="send_to_library('{{ $report['id'] }}', '{{ $report['institution_report'] }}')">Send to Library</a> </span>
                                    @endif
                                  </p>
                                </div>
                              @endforeach  
                              {{$institution_report->links('pagination.ireport')}} 
                            @else           
                            @endif
                        </div>
                        
                      </div>
                      
                    </article>
                  </div>
                  <!-- end self assign institutional report pop up -->
                  <div class="col-9 col-xs-9">
                    <article class="module">
                      <div id="loading_image" class="loader">Loading...</div>
                      <div class="row"  id="alert_panel_empty">
                          <button type="button" class="button">
                            No Alert selected <br> Select any alert to self assign
                          </button>
                      </div>
                      <div class="row"  id="alert-panel" style="display:none">
                      </div>
                    </article>
                  </div>
              </div>
            </div>
            
            <div class="col-2 col-xs-2 row" style="padding-right: 0px;">
              <article id="sysalerts-panel" class="module">
              
                <h3>System Alerts</h3>
                <div class="sysalerts-list">
                  <div class="scroll-inner">
                    <div class="scrolling-pagination">
                      <input type="hidden" id="latest_alert" value="<?= (!empty($alerts) && $alerts->count() > 0) ? $alerts[0]['id'] : 0 ?>" >
                      @if(empty($alerts))
                      <div class="row" id="system_alerts_empty">
                          <button type="button" class="button" onclick="activeEventTab()">
                            Select Events
                          </button>
                      </div>
                    @endif
                      <div class="sysalerts-content" id="alert_content">
                        @if(!empty($alerts))
                          @foreach($alerts as $key => $alert)
                            <div id="alert_{{$alert->id}}" style="cursor:pointer" onclick="show_alert(<?= $alert->id ?>, 'alert')">
                              <div class="sysalerts-item">
                                <p>{{ Str::limit($alert->title, 80) }}</p>
                                <p class="date red">{{ \Carbon\Carbon::parse($alert->created_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</p>
                                <p class="assign blue">
                                  <a href="javascript:void(0)" >Self Assign</a> | 
                                  <a href="{{ route('alerts.show',''.$alert->id)}}" target="_blank">Event Dashboard</a> |
                                  <a  href="javascript:void(0)" onclick="alert_archive({{ $alert->id }}, event)">Archive</a>
                                </p>
                              </div>
                            </div>
                          @endforeach
                          {{ $alerts->links('pagination.alert') }}
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </section>
      </div>
    </div>
    @include('layouts.includes.footer-scripts')

    @include('layouts.includes.message')

    <script>
      $(document).ready(function() {

        setInterval(function() {
          $.ajax({
            url: "{{ route('auth.check', '') }}",
            success: function( response ) {
              if(!response){
                window.location.href = "{{ route('login') }}";
              }
            }
          });
        }, 5000);

        setTimeout(latest_institution_report,5000);
        //setTimeout(latest_alert,5000);
        setTimeout(latest_events,5000);
        setTimeout(latest_inprogress,5000);
        setTimeout(latest_team_report,5000);
        setTimeout(latest_activities,5000);

        $(".scroll-wrapper").mCustomScrollbar();

        $("#ireport_content").mCustomScrollbar({
          callbacks:{
              onTotalScroll:function(){
                if($('ul.ireport-pagination').length && $('ul.ireport-pagination li.active + li a').length){
                  $("#ireport_content").mCustomScrollbar("disable");
                  $('ul.ireport-pagination li.active + li a')[0].click();
                }
              },
              onOverflowYNone:function(){
                if($('ul.ireport-pagination').length && $('ul.ireport-pagination li.active + li a').length){
                  $("#ireport_content").mCustomScrollbar("disable");
                  $('ul.ireport-pagination li.active + li a')[0].click();
                }
              }
          }
        });

        $("#alert_content").mCustomScrollbar({
          callbacks:{
              onTotalScroll:function(){
                console.log('on total scroll');
                if($('ul.alert-pagination').length && $('ul.alert-pagination li.active + li a').length){
                  $("#alert_content").mCustomScrollbar("disable");
                  $('ul.alert-pagination li.active + li a')[0].click();
                }
              },
              onOverflowYNone:function(){
                if($('ul.alert-pagination').length && $('ul.alert-pagination li.active + li a').length){
                  $("#alert_content").mCustomScrollbar("disable");
                  $('ul.alert-pagination li.active + li a')[0].click();
                }
              }
          }
        });
        
        $('#ireport_content .mCSB_container').jscroll({
            debug: true,
            autoTrigger: false,
            padding: 0, 
            nextSelector: 'ul.ireport-pagination li.active + li a',
            callback: function() {
              $('ul.ireport-pagination:first').remove();
              $("#ireport_content").mCustomScrollbar("update"); 
            }
        });

        $('#alert_content .mCSB_container').jscroll({
            debug: true,
            autoTrigger: false,
            padding: 0,
            nextSelector: 'ul.alert-pagination li.active + li a',
            callback: function() {
              $('ul.alert-pagination:first').remove();
              $("#alert_content").mCustomScrollbar("update"); 
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
            $("input[name=search_ref_id]").val("");
            $("#search_title").show();
          }
          if($(this).val() == 'search_ref_id')
          {
            $("#search_title").hide();
            $("input[name=search_title]").val("");
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

        $("#close").on("click", function(e) {
          e.preventDefault();
          $('#report_popup').modal('hide');
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

      function task_reminder(){
        $.ajax({
          url: "{{ route('tasks.index', '') }}",
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
      
      function archive(id, report_name){
        $.ajax({
          url: "{{ route('institution_report.archive', '') }}/"+id,
          type: 'PUT',
          dataType: 'json',
          data: {
              "_token": "{{ csrf_token() }}",
              "report_id": id
          },
          success: function(result) {
            toastr.options = {
                positionClass : 'toast-bottom-right',
              }
            if(result.status == 'Success'){
              $('.ireports_'+report_name).hide();
              toastr.success(result.message, {
                  positionClass: "toast-bottom-right"
              });
            }
            else{
              toastr.error(result.message);
            }
            $("#ireport_content").mCustomScrollbar("update"); 
          }
        });
      }

      function alert_archive(id, e){
        e.stopImmediatePropagation();
        $.ajax({
          url: "{{ route('alerts.archive', '') }}/"+id,
          type: 'PUT',
          dataType: 'json',
          data: {
              "_token": "{{ csrf_token() }}",
              "alert_id": id
          },
          success: function(result) {
            toastr.options = {
              positionClass : 'toast-bottom-right',
            }
            if(result.status == 'Success'){
              if($('#alert-show-'+id).length > 0){
                $('#alert-panel').hide();
                $('#alert_'+id).hide();
                $('#alert_panel_empty').show();
              }else{
                $('#alert_'+id).hide();
              }
              toastr.success("System alert has been archived");
            }
            else{
              toastr.error("Failed to archive system alert");
            }
            $("#alert_content").mCustomScrollbar("update");
          }
        });
      }

      function show_alert(id, type){
        var url;
        if(type == 'alert'){
          url = "{{route('alerts.show', '') }}/"+id;
        }else if(type == 'freeform_report'){
          url = "{{route('freeform_report.show', '') }}/"+id;
        }else if(type == 'institution_report'){
          url = "{{route('institution_report.show', '') }}/"+id;
        }else if(type == 'events'){
          url = "{{route('events.show', '') }}/"+id;
        }else{
          url = "{{route('external_report.show', '') }}/"+id;
        }

        $.ajax({
          url: url,
          type: 'GET',
          beforeSend: function() {
            $(".sysalerts-item").removeClass('selected');
            $(".myreports-item").removeClass('selected');
            $("#"+type+"_"+id).find(".sysalerts-item").addClass('selected');
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
              $("#alert_content .jscroll-inner").html('');
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
              if(type == 'events')
                $("#loading_image_on_alert").hide();
              $("#loading_image").hide();
              toastr.error(JSON.parse(response.responseText));
          }
        });
      }

      function addCommentFormSubmit(){
        //Comment Function
        $('#commentForm').on('submit',function(e){
            e.preventDefault();
            $.ajax({
              url: "alerts/comment",
              type: 'POST',
              dataType: 'json',
              data: $(this).serialize(),
              success: function(result) {
                console.log(result.data);
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

      function latest_events(){
        var event_id = $("#latest_events").val();

        $.ajax({
          url: '{{ route("events.latest_events")}}',
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

      function event_alert(id){
        $.ajax({
          url: '{{ route("alerts.event_alert")}}',
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
          url: '{{ route("events.detail_event_info")}}',
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

      function assignAlertFormSubmit(){
        //self assign function
        $('#self_assign').on('submit',function(event){  
            event.preventDefault();
            $.ajax({
              url: $(this).attr('action'),
              type:"POST",
              data: $(this).serialize(),
              beforeSend: function(){
                $("#self_assign .example-button").attr("disabled",true);
              },
              success:function(response){
                if(response.status == 'Success'){
                    $("#latest_inprogress").attr('value', dateToTimestamp(response.data.updated_at));
                    $('#alert_'+response.data.subject_id).remove();
                    $('#selfAssignForm').hide();
                    $('#transferForm').find('#task_id').val(response.data.id);
                    $('#transferForm').show();
                    $('#myReports').prepend(response.task_card);
                    $('#alert_'+response.data.subject_id).find('.sysalerts-item').addClass('selected');
                    $("#self_assign .example-button").attr("disabled",false);
                    toastr.success(response.message);
                }
              },
              error:function(response, error){
                $("#self_assign .example-button").attr("disabled",false);
                toastr.error(JSON.parse(response.responseText));
              }
            });
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
                            $('#'+response.data.subject_type+'_'+response.data.subject_id).remove();
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

      function assign_institution_report(id){
        $('#self_assign_report').find('.report_id').val(id);
        $('#report_popup').modal('show');
        flatpickr('#due-date', {
          onChange: null
        });
      }

      function send_to_library(id, report_name){
        $.ajax({
          url: "{{ route('institution_report.move_to_library', '') }}/"+id,
          type: 'PUT',
          dataType: 'json',
          data: {
              "_token": "{{ csrf_token() }}",
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
              url: "{{ route('semi_automatic.store') }}",
              type: 'POST',
              dataType: 'json',
              data: {"_token": "{{ csrf_token() }}", 'task_id': task_id, 'subject_id': subject_id},
              success: function(result) {
                  if(result.status == 'success'){
                      url = "{{ route('semi_automatic.create') }}/task/:task_id";
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
              url: "{{ route('fully_manual.store') }}",
              type: 'POST',
              dataType: 'json',
              data: {"_token": "{{ csrf_token() }}", 'task_id': task_id},
            
              success: function(result) {
                  if(result.status == 'success'){
                      var url = "{{ route('fully_manual.edit', ':id') }}";
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
              url: "{{ route('product.store') }}",
              type: 'POST',
              dataType: 'json',
              data: {"_token": "{{ csrf_token() }}", 'task_id': task_id},
            
              success: function(result) {
                  if(result.status == 'success'){
                      var url = "{{ route('product.edit', ':id') }}";
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
                    url: "{{ route('tasks.complete', '') }}/"+task_id,
                    type: 'PUT',
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}"},
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

      function latest_institution_report(){
        var id = $("#latest_institution_report").val();
        
        $.ajax({
          url: '{{ route("institution_report.latest_institution_report")}}',
          type: 'get',
          data: {
              "id": id
          },
          success: function(data){
            if(data.success === true){
              if(data.latest_id != null)
                $("#latest_institution_report").attr('value',data.latest_id);
                $("#ireport_content .jscroll-inner").prepend(data.html);
            }
          },
          complete:function(data){
            $("#ireport_content").mCustomScrollbar("update"); 
            setTimeout(latest_institution_report,5000);
          }
        });
      }

      function latest_alert(){
        var id = $("#latest_alert").val();
      
        $.ajax({
          url: '{{ route("alerts.latest_alert")}}',
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
            $("#alert_content").mCustomScrollbar("update");
            setTimeout(latest_alert,5000);
          }
        });
      }
      
      function latest_inprogress(){
        var updated_at = $("#latest_inprogress").val();
      
        $.ajax({
          url: '{{ route("tasks.latest_inprogress")}}',
          type: 'get',
          data: {
              "updated_at": updated_at
          },
          success: function(response){

            if(response.data.length){
              $.each(response.data, function( index, value ) {
                if($('#'+value.subject_type+'_'+value.subject_id).get(0)){
                  $('#'+value.subject_type+'_'+value.subject_id).remove();
                }
              });
              $("#latest_inprogress").attr('value', dateToTimestamp(response.data[0].updated_at));
              $('#myReports').prepend(response.html);
            }

          },
          complete:function(response){
            setTimeout(latest_inprogress,5000);
          }
        });
      }

      function latest_team_report(){
        var completed_at = $("#latest_team_report").val();
        $.ajax({
          url: '{{ route("tasks.latest_team_report")}}',
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
          url: '{{ route("latest_activities")}}',
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

      $('#self_assign_report').on('submit',function(event){
        event.preventDefault();
        $("#self_assign_report .example-button").attr("disabled", true);
        $.ajax({
          url: $(this).attr('action'),
          type:"POST",
          data: $(this).serialize(),
          success:function(response){
            if(response.status == 'Success'){
                $("#latest_inprogress").attr('value', dateToTimestamp(response.data.updated_at));
                $('#'+response.data.subject_type+'_'+response.data.subject_id).remove();
                $('#report_popup').modal('hide');
                $('#myReports').prepend(response.task_card);
                $("#self_assign_report .example-button").attr("disabled",false);
                toastr.success(response.message);
            }
          },
          error:function(response, error){
              $("#self_assign_report .example-button").attr("disabled",false);
              toastr.error(JSON.parse(response.responseText));
          }
        });
      });

      function regenerate(id, type){
        if(type == 'freeform_report')
          var url = "{{ route('freeform_report.regenerate', '') }}/"+id;
        else if(type == 'fully_manual')
          var url = "{{ route('fully_manual.regenerate', '') }}/"+id;
        else if(type == 'product')
          var url = "{{ route('product.regenerate', '') }}/"+id;
        else if(type == 'semi_automatic')
          var url = "{{ route('semi_automatic.regenerate', '') }}/"+id;
        else if(type == 'automatic'){
          var alert_edit_url = "{{ route('alerts.edit', ':id') }}";
          var url = alert_edit_url.replace(':id', id);
          window.open(url);
          return false;
        }

        $.ajax({
          url: url,
          type: 'get',
          success: function(response){
            if(response.status == 'Success' && type == "freeform_report"){
              window.open('{{ route('freeform_report.report_create', '') }}/'+response.id);
            }
            else if(response.status == 'Success' && type == "fully_manual"){
              window.open('admin/fully_manual/'+response.id+'/edit');
            }
            else if(response.status == 'Success' && type == "product"){
              window.open('admin/product/'+response.id+'/edit');
            }
            else if(response.status == 'Success' && type == "semi_automatic"){
              window.open('{{ route('semi_automatic.create', '') }}/task/'+response.id);
            }
          }
        });
      }
    </script>
  </body>
</html>
