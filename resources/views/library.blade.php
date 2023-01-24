<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>NEWS-Library</title>
    @include('layouts.includes.library_head')
    <style>
      .unarchive {
        margin-top:2px;
      }
      .unarchive a{
        text-decoration:none;
        font-weight: 700;
        color: #28adfb;
      }
      .blue{
        font-weight: 500 !important;
      }
      .red{
        font-weight: 500;
      }
      input {
        margin: 0px;
      }
      .lib-item .lib-item-icon{
        height: 85px;
      }
      #alert_panel_empty { position: absolute; left: 50%; top: 50%; transform: translateX(-50%) translateY(-50%); cursor: text !important; }
      #alert-panel .value{ font-size: 14px; }
      #loading_image{ display:none; }
      .mg-top { margin-top: 15px; }
      .center{ display: block; margin-left: 30%; margin-top: 18%; }
      .myreports-item:hover{background: #153753;}
      .selected{background: #153753;}
      h3{ font-size: 20px;}
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
          <div class="col-12 col-xs-12" style="min-height: 100%">
            <article id="library-panel" class="module">
              <div class="library-head">
                <div class="panel-view">
                  <a href="{{ route('dashboard.index') }}">
                    @role('Admin')
                      Back to Panel 
                    @endrole
                    @role('Manager|Analyst')
                      Back to Dashboard 
                    @endrole
                    <i class="fa fa-share-square-o" aria-hidden="true"></i>
                  </a>
                </div>
                <h3>Library</h3>
              </div>
              <div class="library-buttons">
                <div class="row">
                  <div class="col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                      <div class="col-12 col-xs-12">
                        <div class="library-filters">
                          <button class="button-filter {{ Route::currentRouteName() == 'all'? 'selected' : '' }}" onclick="window.location.href='{{ route('all') }}'">All<br>reports</button>
                          <button class="button-filter {{ Route::currentRouteName() == 'alerts'? 'selected' : '' }}" onclick="window.location.href='{{ route('alerts') }}'">System generated<br>reports</button>
                          <button class="button-filter {{ Route::currentRouteName() == 'semi_automatic_report'? 'selected' : '' }}" onclick="window.location.href='{{ route('semi_automatic_report') }}'">Semi Automated<br>reports</button>
                          <button class="button-filter {{ Route::currentRouteName() == 'fully_manual'? 'selected' : '' }}" onclick="window.location.href='{{ route('fully_manual') }}'">Fully Manual<br>reports</button>
                          <button class="button-filter {{ Route::currentRouteName() == 'institution_report' || Route::currentRouteName() == null ? 'selected' : '' }}" onclick="window.location.href='{{ route('institution_report') }}'">Institutional<br>reports</button>
                          <button class="button-filter {{ Route::currentRouteName() == 'freeform_report' || Route::currentRouteName() == null ? 'selected' : '' }}" onclick="window.location.href='{{ route('freeform_report') }}'">FreeForm<br>reports</button>
                          <button class="button-filter {{ Route::currentRouteName() == 'external_report' || Route::currentRouteName() == null ? 'selected' : '' }}" onclick="window.location.href='{{ route('external_report') }}'">External<br>reports</button>
                          <button class="button-filter {{ Route::currentRouteName() == 'scenario_report' || Route::currentRouteName() == null ? 'selected' : '' }}" onclick="window.location.href='{{ route('scenario_report') }}'">Scenario<br>reports</button>
                          <button class="button-filter {{ Route::currentRouteName() == 'video_report' || Route::currentRouteName() == null ? 'selected' : '' }}" onclick="window.location.href='{{ route('video_report') }}'">Video<br>reports</button>
                          <button class="button-filter {{ Route::currentRouteName() == 'archived' || Route::currentRouteName() == null ? 'selected' : '' }}" onclick="window.location.href='{{ route('archived') }}'">Show <br>Archived</button>
                          <button class="button-filter" onclick="window.open('{{ Config::get('constants.sdssapp.url') }}')">SDSS <br />App</button>
                          <button class="button-filter" onclick="window.open('{{ Config::get('constants.warningrisk.url') }}')">Warning <br />Risk</button>
                          <button class="button-filter" onclick="window.open('{{ Config::get('constants.rssapp.url') }}')">RSS <br />App</button>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12 col-xs-12">
                        {{ Form::open(['method' => 'get', 'url'=> 'library/'.Route::currentRouteName()]) }}
                        <div class="library-inputs">
                          <div class="row">
                              @if(auth()->user()->hasRole('Manager') || auth()->user()->hasRole('Admin'))
                                <div class="col-2 col-xs-12">
                                  {!! Form::select('analysts', $analysts, app('request')->input('analysts') , ['id' => 'analysts','placeholder' => 'Select Analyst']) !!}
                                </div>
                                <div class="col-2 col-xs-12">
                                  <input id="from-date" name="from_date" placeholder="From Date" value="{{ (app('request')->input('from_date')!='')?app('request')->input('from_date'):app('request')->input('default_from_date') }}">
                                </div>
                                <div class="col-2 col-xs-12">
                                  <input id="to-date" name="to_date" placeholder="To Date" value="{{ (app('request')->input('to_date')!='')?app('request')->input('to_date'):app('request')->input('default_to_date') }}">
                                </div>
                                <div class="col-2 col-xs-12">
                                  <input type="text" name="search_title" placeholder="Search Reports by Title" value="{{ (app('request')->input('search_title')!='')?app('request')->input('search_title'):'' }}" class="search-input">
                                </div>
                                <div class="col-2 col-xs-12">
                                  <input type="text" name="search_ref_id" placeholder="Search Reports by Ref ID" value="{{ (app('request')->input('search_ref_id')!='')?app('request')->input('search_ref_id'):'' }}" class="search-input">
                                </div>
                                <div class="col-2 col-xs-12">
                                  <button type="submit" class="button" style="margin-right:10px">Search</button>
                                  <button type="reset" class="button" onclick="window.location.href='{{ URL::current() }}'">Reset</button>
                                </div>
                              @else
                                <div class="col-2 col-xs-12">
                                  <input id="from-date" name="from_date" placeholder="From Date" value="{{ (app('request')->input('from_date')!='')?app('request')->input('from_date'):app('request')->input('default_from_date') }}">
                                </div>
                                <div class="col-2 col-xs-12">
                                  <input id="to-date" name="to_date" placeholder="To Date" value="{{ (app('request')->input('to_date')!='')?app('request')->input('to_date'):app('request')->input('default_to_date') }}">
                                </div>
                                <div class="col-3 col-xs-12">
                                  <input type="text" name="search_title" placeholder="Search Reports by Title" value="{{ (app('request')->input('search_title')!='')?app('request')->input('search_title'):'' }}" class="search-input">
                                </div>
                                <div class="col-3 col-xs-12">
                                  <input type="text" name="search_ref_id" placeholder="Search Reports by Ref ID" value="{{ (app('request')->input('search_ref_id')!='')?app('request')->input('search_ref_id'):'' }}" class="search-input">
                                </div>
                                <div class="col-2 col-xs-12">
                                  <button type="submit" class="button" style="margin-right:10px">Search</button>
                                  <button type="reset" class="button" onclick="window.location.href='{{ URL::current() }}'">Reset</button>
                                </div>
                              @endif
                          </div>
                        </div>
                        {{ Form::close() }}
                      </div>

                      <div class="col-4 col-xs-12">
                        {{ Form::open(['method' => 'get', 'style' => 'float:right', 'url'=> 'library/'.Route::currentRouteName() ]) }}
                        
                        {{ Form::close() }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="library-files">
                <div class="row">
                  <div class="col-12 col-xs-12">
                    <div class="lib-actions">
                    
                        <h4 style=" float: left; display: inline-flex;"> {{ strtoupper(str_replace("_"," ",Route::currentRouteName())) }} </h4>
                        <div class="lib-action-butttons"><a href="">Select all </a>&nbsp;
                          <input type="checkbox" name="selectAll" onclick="selectAll()" style="color:#28adfb; margin:0px">
                        </div>
                        @if(Route::currentRouteName() == 'archived')
                          <div class="lib-action-butttons">
                            <a href="javascript:void(0)" onclick="bulk_unarchive('{{ route('library.bulk_unarchive','')}}')">Unarchive </a>
                          </div>
                          @else
                          <div class="lib-action-butttons">
                            <a href="javascript:void(0)" onclick="bulk_download('{{ route('library.bulk_download', Route::currentRouteName()) }}')">
                              Download <i class="fa fa-download" aria-hidden="true"></i>
                            </a>
                          </div>
                          <div class="lib-action-butttons">
                            <a href="javascript:void(0)" onclick="bulk_archive('{{ route(Route::currentRouteName().'.bulk_archive','')}}')">Archive </a>
                          </div>
                          @role('Admin')
                            <div class="lib-action-butttons">
                              <a href="javascript:void(0)" onclick="bulk_delete('{{ route(Route::currentRouteName().'.bulk_delete','')}}')">Delete 
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                              </a>
                            </div>
                          @endrole
                        @endif
                    </div>
                  </div>
                </div>
                <form class="report_bulk_action" method="put">
                @if(Route::currentRouteName() == 'institution_report' || Route::currentRouteName() == 'all')
                  @if(count($institution_report) > 0)
                    @if(Route::currentRouteName() == 'all')<h4>Institutional Report</h4>@endif
                      <div class="row" id="institution_report"> 
                        @foreach(@$institution_report as $report)
                          <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="lib-item">
                              <div class="lib-item-left">
                                <div class="title">{!! Str::limit(html_entity_decode($report['name']), 31) !!}</div>
                                <div class="ref">Ref ID: {{ $report['institution_report'] }}</div>
                                <div class="txt blue">
                                  @if($report->tasks != null)
                                  Assign To : {{$report->tasks->latest_task_log->assigned_to_user->name}}
                                  @else
                                    @role('Manager')
                                    <a href="javascript:void(0)" class="assign_to" id="assign_to_{{ $report['id'] }}" onclick="assign_institution_report_form('{{ $report['id'] }}', '{{ $report['institution_report'] }}')">Assign to</a>
                                    @endrole
                                    @role('Analyst')
                                    <a href="javascript:void(0)" id="assign_to_{{ $report['id'] }}" onclick="assign_institution_report('{{ $report['id'] }}', '{{ $report['institution_report'] }}')">Self Assign</a>
                                    @endrole
                                  @endif
                                </div>
                                <div class="date red">Added : {{ \Carbon\Carbon::parse($report['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              </div> 
                              <div class="lib-item-icon">
                                <input type="checkbox" name="institution_report[]" value="{{$report['institution_report']}}" style="margin-bottom: 30px; float:right">
                                
                                <a href="{{ route('institution_report.download', [$report['institution_report'], 'pdf']) }}">
                                  <img src="{{asset('images/pdf-icon.svg')}}" alt="download_institution_report" class="icon">
                                </a>
                              </div>
                            </div>
                          </div>     
                        @endforeach
                      </div>
                      @if(Route::currentRouteName() != 'all')
                      <div class="d-flex justify-content-center">
                        {{ $institution_report->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'institution_report')    
                  <h6 style="margin: 13em; text-align:center">There are no institutional reports added to library yet.</h6>       
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="institution_report_empty">There are no institutional reports added to library yet.</h6> 
                @endif

                @if(Route::currentRouteName() == 'freeform_report' || Route::currentRouteName() == 'all')
                  @if(count($freeform_report) > 0)
                    @if(Route::currentRouteName() == 'all')<h4>FreeForm Report</h4>@endif
                  
                      <div class="row" id="freeform_report"> 
                        @foreach(@$freeform_report as $report)
                          <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="lib-item">
                              <div class="lib-item-left">
                                <div class="title">{!! Str::limit(html_entity_decode($report->title), 31) !!}</div>
                                <div class="ref">Ref ID: {{ $report['ref_id'] }}</div>
                                <div class="txt blue">
                                  @if($report->tasks != null)
                                  Assign To : {{$report->tasks->latest_task_log->assigned_to_user->name}}
                                  @else
                                  Unassigned
                                  @endif
                                </div>
                                <div class="date red">Added : {{ \Carbon\Carbon::parse($report['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              </div> 
                              <div class="lib-item-icon">
                                <input type="checkbox" name="freeform_report[]" value="{{$report['ref_id']}}" style="margin-bottom: 30px; float:right">
                                
                                <a href="{{ route('freeform_report.download', [$report['ref_id'], 'pdf']) }}">
                                  <img src="{{asset('images/pdf-icon.svg')}}" alt="download_freeform_report" class="icon">
                                </a>
                              </div>
                            </div>
                          </div>     
                        @endforeach
                      </div>
                      @if(Route::currentRouteName() != 'all')
                      <div class="d-flex justify-content-center">
                        {{ $freeform_report->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'freeform_report')    
                  <h6 style="margin: 13em; text-align:center">There are no freeform reports added to library yet.</h6>       
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="freeform_report_empty">There are no freeform reports added to library yet.</h6> 
                @endif

                @if(Route::currentRouteName() == 'external_report' || Route::currentRouteName() == 'all')
                  @if(count($external_report) > 0)
                    @if(Route::currentRouteName() == 'all')<h4>External Reports</h4>@endif
                  
                      <div class="row" id="external_report"> 
                        @foreach(@$external_report as $report)
                          <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="lib-item">
                              <div class="lib-item-left">
                                <div class="title">{!! Str::limit(html_entity_decode($report->title), 31) !!}</div>
                                <div class="ref">Ref ID: {{ $report->external_report }}</div>
                                <div class="txt blue">
                                  @if($report->tasks != null)
                                    Assign To : {{$report->tasks->latest_task_log->assigned_to_user->name}}
                                  @else
                                    @role('Manager|Supervisor')
                                    <a href="javascript:void(0)" class="assign_to" id="assign_to_{{ $report['id'] }}" onclick="assign_external_report_form('{{ $report['id'] }}', '{{ $report['external_report'] }}')">Assign to</a>
                                    @endrole
                                    @role('Analyst')
                                    <a href="javascript:void(0)" id="assign_to_{{ $report['id'] }}" onclick="assign_external_report('{{ $report['id'] }}', '{{ $report['external_report'] }}')">Self Assign</a>
                                    @endrole
                                  @endif
                                </div>
                                <div class="date red">Added : {{ \Carbon\Carbon::parse($report['created_at'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              </div> 
                              <div class="lib-item-icon">
                                <input type="checkbox" name="external_report[]" value="{{$report['external_report']}}" style="margin-bottom: 30px; float:right">
                                
                                <a href="{{ route('external_report.download', [$report['external_report'], 'pdf']) }}">
                                  <img src="{{asset('images/pdf-icon.svg')}}" alt="download_external_report" class="icon">
                                </a>
                              </div>
                            </div>
                          </div>     
                        @endforeach
                      </div>
                      @if(Route::currentRouteName() != 'all')
                      <div class="d-flex justify-content-center">
                        {{ $external_report->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'external_report')    
                  <h6 style="margin: 13em; text-align:center">There are no external reports added to library yet.</h6>       
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="external_report_empty">There are no external reports added to library yet.</h6> 
                @endif

                @if(Route::currentRouteName() == 'scenario_report' || Route::currentRouteName() == 'all')
                  @if(count($scenario_report) > 0)
                    @if(Route::currentRouteName() == 'all')<h4>Scenario Reports</h4>@endif
                  
                      <div class="row" id="scenario_report"> 
                        @foreach(@$scenario_report as $report)
                          <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="lib-item">
                              <div class="lib-item-left">
                                <div class="title">{!! Str::limit(html_entity_decode($report->title), 31) !!}</div>
                                <div class="ref">Ref ID: {{ $report->external_report }}</div>
                                <div class="txt blue">
                                  @if($report->tasks != null)
                                    Assign To : {{$report->tasks->latest_task_log->assigned_to_user->name}}
                                  @else
                                    @role('Manager|Supervisor')
                                    <a href="javascript:void(0)" class="assign_to" id="assign_to_{{ $report['id'] }}" onclick="assign_external_report_form('{{ $report['id'] }}', '{{ $report['external_report'] }}')">Assign to</a>
                                    @endrole
                                    @role('Analyst')
                                    <a href="javascript:void(0)" id="assign_to_{{ $report['id'] }}" onclick="assign_external_report('{{ $report['id'] }}', '{{ $report['external_report'] }}')">Self Assign</a>
                                    @endrole
                                  @endif
                                </div>
                                <div class="date red">Added : {{ \Carbon\Carbon::parse($report['created_at'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              </div> 
                              <div class="lib-item-icon">
                                <input type="checkbox" name="external_report[]" value="{{$report['external_report']}}" style="margin-bottom: 30px; float:right">
                                
                                <a href="{{ route('external_report.download', [$report['external_report'], 'pdf']) }}">
                                  <img src="{{asset('images/pdf-icon.svg')}}" alt="download_external_report" class="icon">
                                </a>
                              </div>
                            </div>
                          </div>     
                        @endforeach
                      </div>
                      @if(Route::currentRouteName() != 'all')
                      <div class="d-flex justify-content-center">
                        {{ $scenario_report->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'scenario_report')    
                  <h6 style="margin: 13em; text-align:center">There are no scenario reports added to library yet.</h6>       
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="scenario_report_empty">There are no scenario reports added to library yet.</h6> 
                @endif

                @if(Route::currentRouteName() == 'video_report' || Route::currentRouteName() == 'all')
                  @if(count($video_report) > 0)
                    @if(Route::currentRouteName() == 'all')<h4>Video Reports</h4>@endif
                  
                      <div class="row" id="video_report"> 
                        @foreach(@$video_report as $report)
                          <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="lib-item">
                              <div class="lib-item-left">
                                <div class="title">{!! Str::limit(html_entity_decode($report->title), 31) !!}</div>
                                <div class="ref">Ref ID: {{ $report->video_report }}</div>
                                <div class="txt blue">
                                  Uploaded By : {{$report->users->name}}
                                </div>
                                <div class="date red">Added : {{ \Carbon\Carbon::parse($report['created_at'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              </div> 
                              <div class="lib-item-icon">
                                <input type="checkbox" name="video_report[]" value="{{$report['video_report']}}" style="margin-bottom: 30px; float:right">
                                
                                <a href="{{ route('video_report.download', [$report['video_report'], 'mp4']) }}">
                                  <img src="{{asset('images/video-icon.png')}}" alt="download_video_report" class="icon">
                                </a>
                              </div>
                            </div>
                          </div>     
                        @endforeach
                      </div>
                      @if(Route::currentRouteName() != 'all')
                      <div class="d-flex justify-content-center">
                        {{ $video_report->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'video_report')    
                  <h6 style="margin: 13em; text-align:center">There are no video reports added to library yet.</h6>       
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="video_report_empty">There are no video reports added to library yet.</h6> 
                @endif

                @if(Route::currentRouteName() == 'semi_automatic_report' || Route::currentRouteName() == 'all')
                  @if(count($semi_automatic_report) > 0)
                    @if(Route::currentRouteName() == 'all')<br><h4>Semi Automatic Report</h4>@endif
                    
                      <div class="row" id="semi_automatic_report"> 
                        @foreach(@$semi_automatic_report as $report)
                          <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="lib-item">
                              <div class="lib-item-left">
                                <div class="title">{!! Str::limit($report->alert->title, 31) !!}</div>
                                <div class="ref">Ref ID: {{ $report->ref_id }}</div>
                                <div class="txt blue">Reported By: {{ $report->reported_by->name }}</div>
                                <div class="date red" value="{{date($report->updated_at)}}">Report Date : {{ \Carbon\Carbon::parse($report->updated_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              </div> 
                              <div class="lib-item-icon">
                                <input type="checkbox" name="semi_automatic_report[]" value="{{ $report->ref_id }}" style="margin-bottom: 30px; float:right">
                              
                                <a href="{{ route('semi_automatic.download', $report->ref_id) }}">
                                  <img src="{{asset('images/pdf-icon.svg')}}" alt="download_semi_automatic" class="icon">
                                </a>
                              </div>
                            </div>
                          </div>     
                        @endforeach
                      </div>
                      @if(Route::currentRouteName() != 'all')
                      <div class="d-flex justify-content-center">
                        {{ $semi_automatic_report->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'semi_automatic_report')
                    <h6 style="margin: 13em; text-align:center">There are no semi automatic reports added to library yet.</h6>             
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="semi_automatic_report_empty">There are no semi automatic reports added to library yet</h6> 
                @endif

                @if(Route::currentRouteName() == 'alerts' || Route::currentRouteName() == 'all')
                  @if(count($system_generated_report) > 0)
                    @if(Route::currentRouteName() == 'all')<br><h4>System Generated Report</h4>@endif
                    
                      <div class="row" id="alerts"> 
                        @foreach(@$system_generated_report as $report)
                          <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="lib-item">
                              <div class="lib-item-left">
                                <div class="title">{!! Str::limit($report->title, 31) !!}</div>
                                <div class="ref">Ref ID: {{ $report->ref_id }}</div>
                                <div class="txt blue">
                                  @if($report->tasks != null)
                                    Assign To : {{$report->tasks->latest_task_log->assigned_to_user->name}}
                                  @else
                                    Unassigned
                                  @endif
                                </div>
                                <div class="date red">Created Date : {{ \Carbon\Carbon::parse($report->created_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              </div> 
                              <div class="lib-item-icon">
                                  <input type="checkbox" name="alerts[]" value="{{ $report->ref_id }}" style="margin-bottom: 30px; float:right">
                                
                                <a href="{{ route('alerts.download', $report->ref_id) }}">
                                  <img src="{{asset('images/pdf-icon.svg')}}" alt="download_system_generated_report" class="icon">
                                </a>
                              </div>
                            </div>
                          </div>     
                        @endforeach
                      </div>
                      @if(Route::currentRouteName() != 'all')
                      <div class="d-flex justify-content-center">
                        {{ $system_generated_report->withQueryString()->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'alerts')
                  <h6 style="margin: 13em; text-align:center">There are no system generated reports added to library yet.</h6>             
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="alerts_empty">There are no system generated alerts added to library yet.</h6>  
                @endif

                @if(Route::currentRouteName() == 'fully_manual' || Route::currentRouteName() == 'all')
                  @if(count($fully_manual) > 0)
                    @if(Route::currentRouteName() == 'all')<br><h4>Fully Manual</h4>@endif
                  
                      <div class="row" id="fully_manual"> 
                        @foreach(@$fully_manual as $report)
                          <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="lib-item">
                              <div class="lib-item-left">
                                <div class="title">{!! Str::limit($report->title, 31) !!}</div>
                                <div class="ref">Ref ID: {{ $report->ref_id }}</div>
                                <div class="txt blue">Reported By: {{ $report->reported_by->name }}</div>
                                <div class="date red">Report Date : {{ \Carbon\Carbon::parse($report->updated_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              </div> 
                              <div class="lib-item-icon">
                                <input type="checkbox" name="fully_manual[]" value="{{ $report->ref_id }}" style="margin-bottom: 30px; float:right">
                              
                                <a href="{{ route('fully_manual.download', $report->ref_id) }}">
                                  <img src="{{asset('images/pdf-icon.svg')}}" alt="download_fully_manual" class="icon">
                                </a>
                              </div>
                            </div>
                          </div>     
                        @endforeach
                      </div>
                      @if(Route::currentRouteName() != 'all')
                        <div class="d-flex justify-content-center">
                          {{ $fully_manual->links('pagination::default') }}
                        </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'fully_manual')
                  <h6 style="margin: 13em; text-align:center">There are no fully manual reports added to library yet.</h6>             
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="fully_manual_empty">There are no fully manual reports added to library yet.</h6>   
                @endif

                @if(Route::currentRouteName() == 'archived')
                  @if(count($institution_report_archived) > 0)
                    <h4>Institutional Reports</h4>
                    <div class="row"> 
                      @foreach($institution_report_archived as $report)
                        <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 institution_report_archived" id="institution_report_{{ $report->id }}">
                          <div class="lib-item">
                            <div class="lib-item-left">
                              <div class="title">{!! Str::limit(html_entity_decode($report['name']), 31) !!}</div>
                              <div class="ref">Ref ID: {{ $report->institution_report }}</div>
                              <div class="txt blue">
                                @if($report->tasks != null)
                                Assign To : {{ $report->tasks->latest_task_log->assigned_to_user->name}}
                                @else
                                Unassigned
                                @endif
                              </div>
                              <div class="date red">Added : {{ \Carbon\Carbon::parse($report['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              <div class="unarchive">
                                <a href="javascript:void(0)" onclick="unarchive('{{route('institution_report.unarchive',$report->id)}}', {{$report->id}} ,'institution_report')">Unarchive</a> 
                              </div>
                            </div> 
                            <div class="lib-item-icon">
                              <input type="checkbox" name="institution_report[]" value="{{$report['institution_report']}}" style="margin-bottom: 30px; float:right">
                                
                              <a href="{{ route('institution_report.download', [$report->institution_report, 'pdf']) }}">
                                <img src="{{asset('images/pdf-icon.svg')}}" alt="download_institution_report" class="icon">
                              </a>
                            </div>
                          </div>
                        </div>     
                      @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                      {{ $institution_report_archived->links('pagination::default') }}
                    </div>
                    <h6 style="margin: 4em auto; text-align:center; display:none" class="no_archived_institution_report">There are no institutional reports archived.</h6>    
                  
                  @endif

                  @if(count($freeform_report_archived) > 0)
                    <h4>FreeForm Reports</h4>
                    <div class="row"> 
                      @foreach($freeform_report_archived as $report)
                        <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 freeform_report_archived" id="freeform_report_{{ $report->id }}">
                          <div class="lib-item">
                            <div class="lib-item-left">
                              <div class="title">{!! Str::limit(html_entity_decode($report['title']), 31) !!}</div>
                              <div class="ref">Ref ID: {{ $report->ref_id }}</div>
                              <div class="txt blue">
                                @if($report->tasks != null)
                                Assign To : {{ $report->tasks->latest_task_log->assigned_to_user->name}}
                                @else
                                Unassigned
                                @endif
                              </div>
                              <div class="date red">Added : {{ \Carbon\Carbon::parse($report['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              <div class="unarchive">
                                <a href="javascript:void(0)" onclick="unarchive('{{route('freeform_report.unarchive',$report->id)}}', {{$report->id}} ,'freeform_report')">Unarchive</a> 
                              </div>
                            </div> 
                            <div class="lib-item-icon">
                              <input type="checkbox" name="freeform_report[]" value="{{$report['ref_id']}}" style="margin-bottom: 30px; float:right">
                                
                              <a href="{{ route('freeform_report.download', [$report->ref_id, 'pdf']) }}">
                                <img src="{{asset('images/pdf-icon.svg')}}" alt="download_freeform_report" class="icon">
                              </a>
                            </div>
                          </div>
                        </div>     
                      @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                      {{ $freeform_report_archived->links('pagination::default') }}
                    </div>
                    <h6 style="margin: 4em auto; text-align:center; display:none" class="no_archived_freeform_report">There are no freeform reports archived.</h6>    
                  
                  @endif

                  @if(count($external_report_archived) > 0)
                    <h4>External Reports</h4>
                    <div class="row"> 
                      @foreach($external_report_archived as $report)
                        <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 external_report_archived" id="external_report_{{ $report->id }}">
                          <div class="lib-item">
                            <div class="lib-item-left">
                              <div class="title">{!! Str::limit(html_entity_decode($report['title']), 31) !!}</div>
                              <div class="ref">Ref ID: {{ $report->external_report }}</div>
                              <div class="txt blue"> Uploaded By : {{ $report->users->name}} </div>
                              <div class="date red">Added : {{ \Carbon\Carbon::parse($report['created_at'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              <div class="unarchive">
                                <a href="javascript:void(0)" onclick="unarchive('{{route('external_report.unarchive',$report->id)}}', {{$report->id}} ,'external_report')">Unarchive</a> 
                              </div>
                            </div> 
                            <div class="lib-item-icon">
                              <input type="checkbox" name="external_report[]" value="{{$report['external_report']}}" style="margin-bottom: 30px; float:right">
                                
                              <a href="{{ route('external_report.download', [$report->external_report, 'pdf']) }}">
                                <img src="{{asset('images/pdf-icon.svg')}}" alt="download_external_report" class="icon">
                              </a>
                            </div>
                          </div>
                        </div>     
                      @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                      {{ $external_report_archived->links('pagination::default') }}
                    </div>
                    <h6 style="margin: 4em auto; text-align:center; display:none" class="no_archived_external_report">There are no external reports archived.</h6>    
                  
                  @endif

                  @if(count($scenario_report_archived) > 0)
                    <h4>Scenario Reports</h4>
                    <div class="row"> 
                      @foreach($scenario_report_archived as $report)
                        <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 scenario_report_archived" id="external_report_{{ $report->id }}">
                          <div class="lib-item">
                            <div class="lib-item-left">
                              <div class="title">{!! Str::limit(html_entity_decode($report['title']), 31) !!}</div>
                              <div class="ref">Ref ID: {{ $report->external_report }}</div>
                              <div class="txt blue"> Uploaded By : {{ $report->users->name}} </div>
                              <div class="date red">Added : {{ \Carbon\Carbon::parse($report['created_at'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              <div class="unarchive">
                                <a href="javascript:void(0)" onclick="unarchive('{{route('external_report.unarchive',$report->id)}}', {{$report->id}} ,'external_report')">Unarchive</a> 
                              </div>
                            </div> 
                            <div class="lib-item-icon">
                              <input type="checkbox" name="external_report[]" value="{{$report['external_report']}}" style="margin-bottom: 30px; float:right">
                                
                              <a href="{{ route('external_report.download', [$report->external_report, 'pdf']) }}">
                                <img src="{{asset('images/pdf-icon.svg')}}" alt="download_external_report" class="icon">
                              </a>
                            </div>
                          </div>
                        </div>     
                      @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                      {{ $scenario_report_archived->links('pagination::default') }}
                    </div>
                    <h6 style="margin: 4em auto; text-align:center; display:none" class="no_archived_external_report">There are no scenario reports archived.</h6>    
                  
                  @endif

                  @if(count($video_report_archived) > 0)
                    <h4>Video Reports</h4>
                    <div class="row"> 
                      @foreach($video_report_archived as $report)
                        <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 video_report_archived" id="video_report_{{ $report->id }}">
                          <div class="lib-item">
                            <div class="lib-item-left">
                              <div class="title">{!! Str::limit(html_entity_decode($report['title']), 31) !!}</div>
                              <div class="ref">Ref ID: {{ $report->video_report }}</div>
                              <div class="txt blue"> Uploaded By : {{ $report->users->name}} </div>
                              <div class="date red">Added : {{ \Carbon\Carbon::parse($report['created_at'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              <div class="unarchive">
                                <a href="javascript:void(0)" onclick="unarchive('{{route('video_report.unarchive',$report->id)}}', {{$report->id}} ,'video_report')">Unarchive</a> 
                              </div>
                            </div> 
                            <div class="lib-item-icon">
                              <input type="checkbox" name="video_report[]" value="{{$report['video_report']}}" style="margin-bottom: 30px; float:right">
                                
                              <a href="{{ route('video_report.download', [$report->video_report, 'pdf']) }}">
                                <img src="{{asset('images/pdf-icon.svg')}}" alt="download_video_report" class="icon">
                              </a>
                            </div>
                          </div>
                        </div>     
                      @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                      {{ $video_report_archived->links('pagination::default') }}
                    </div>
                    <h6 style="margin: 4em auto; text-align:center; display:none" class="no_archived_video_report">There are no video reports archived.</h6>    
                  
                  @endif
                  
                  @if(count($alert_archived) > 0)
                    <h4>Alerts</h4>
                    <div class="row">
                      @foreach($alert_archived as $alert)
                        <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 alerts_archived" id="alerts_{{ $alert->id }}">
                          <div class="lib-item">
                            <div class="lib-item-left">
                              <div class="title">{!! Str::limit(html_entity_decode($alert->title), 31) !!}</div>
                              <div class="ref">Ref ID: {!! $alert->ref_id !!}</div>
                              <div class="txt blue">
                                @if($alert->tasks != null)
                                Assign To : {{ $alert->tasks->latest_task_log->assigned_to_user->name }}
                                @else
                                Unassigned
                                @endif
                              </div>
                              <div class="date red">Added : {{ \Carbon\Carbon::parse($alert->created_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              <div class="unarchive">
                                <a href="javascript:void(0)" onclick="unarchive('{{route('alerts.unarchive',$alert->id)}}', {{$alert->id}} ,'alerts')">Unarchive</a> 
                              </div>
                            </div> 
                            <div class="lib-item-icon">
                              <input type="checkbox" name="alerts[]" value="{{ $alert->ref_id }}" style="margin-bottom: 30px; float:right">
                                
                              <a href="{{ route('alerts.download', [$alert->ref_id, 'pdf']) }}">
                                <img src="{{asset('images/pdf-icon.svg')}}" alt="download_system_generated_report" class="icon">
                              </a>
                            </div>
                          </div>
                        </div>     
                      @endforeach 
                    </div>
                    <div class="d-flex justify-content-center">
                      {{ $alert_archived->links('pagination::default') }}
                    </div>
                    <h6 style="margin: 4em auto; text-align:center; display:none" class="no_archived_alerts">There are no alerts archived.</h6>   
                    
                  @endif

                  @if(count($semi_automatic_report_archived) > 0)
                    <h4>Semi Automatic Reports</h4>
                    <div class="row">
                      @foreach($semi_automatic_report_archived as $semi_automatic_report)
                        <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 semi_automatic_report_archived" id="semi_automatic_report_{{ $semi_automatic_report->id }}">
                          <div class="lib-item">
                              <div class="lib-item-left">
                                <div class="title">{!! Str::limit(html_entity_decode($semi_automatic_report->alert->title), 31) !!}</div>
                                <div class="ref">Ref ID: {!! $semi_automatic_report->ref_id !!}</div>
                                <div class="txt blue">
                                  @if($semi_automatic_report->tasks != null)
                                  Assign To : {{ $semi_automatic_report->reported_by->name }}
                                  @else
                                  Unassigned
                                  @endif
                                </div>
                                <div class="date red">Added : {{ \Carbon\Carbon::parse($semi_automatic_report->updated_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                                <div class="unarchive">
                                  <a href="javascript:void(0)" onclick="unarchive('{{route('semi_automatic_report.unarchive',$semi_automatic_report->id)}}', {{$semi_automatic_report->id}} ,'semi_automatic_report')">Unarchive</a> 
                                </div>
                              </div> 
                              <div class="lib-item-icon">
                                <input type="checkbox" name="semi_automatic_report[]" value="{{ $semi_automatic_report->ref_id }}" style="margin-bottom: 30px; float:right">
                              
                                <a href="{{ route('semi_automatic.download', [$semi_automatic_report->ref_id, 'pdf']) }}">
                                  <img src="{{asset('images/pdf-icon.svg')}}" alt="download_semi_automatic" class="icon">
                                </a>
                            </div>
                          </div>
                        </div>     
                      @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                      {{ $semi_automatic_report_archived->links('pagination::default') }}
                    </div>
                    <h6 style="margin: 4em auto; text-align:center; display:none" class="no_archived_semi_automatic_report">There are no semi automatic reports archived.</h6>   
                  
                  @endif

                  @if(count($fully_manual_archived) > 0)
                    <h4>Fully Manual Reports</h4>
                    <div class="row">
                      @foreach($fully_manual_archived as $fully_manual)
                        <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 fully_manual_archived" id="fully_manual_{{ $fully_manual->id }}">
                          <div class="lib-item">
                            <div class="lib-item-left">
                              <div class="title">{!! Str::limit(html_entity_decode($fully_manual->title), 31) !!}</div>
                              <div class="ref">Ref ID: {!! $fully_manual->ref_id !!}</div>
                              <div class="txt blue">
                                @if($fully_manual->task != null)
                                Assign To : {{ $fully_manual->reported_by->name }}
                                @else
                                Unassigned
                                @endif
                              </div>
                              <div class="date red">Added : {{ \Carbon\Carbon::parse($fully_manual->updated_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>
                              <div class="unarchive">
                                <a href="javascript:void(0)" onclick="unarchive('{{route('fully_manual.unarchive',$fully_manual->id)}}', {{$fully_manual->id}} ,'fully_manual')">Unarchive</a> 
                              </div>
                            </div> 
                            <div class="lib-item-icon">
                              <input type="checkbox" name="fully_manual[]" value="{{ $fully_manual->ref_id }}" style="margin-bottom: 30px; float:right">
                              
                              <a href="{{ route('fully_manual.download', [$fully_manual->ref_id, 'pdf']) }}">
                                <img src="{{asset('images/pdf-icon.svg')}}" alt="download_fully_manual" class="icon">
                              </a>
                            </div>
                          </div>
                        </div>     
                      @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                      {{ $fully_manual_archived->links('pagination::default') }}
                    </div>
                    <h6 style="margin: 4em auto; text-align:center; display:none" class="no_archived_fully_manual">There are no fully manual reports archived.</h6>   
                  
                  @endif
                @endif
                </form>
              </div>
            </article>
          </div>
        </section>
      </div>

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
                  <input type="hidden" class="type" name="type" value="">
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
                        <button class="button button-red close" style="margin-right: 5px;"> Cancel </button>
                        <!-- Submit Form Button -->
                        {!! Form::button('Assign', ['type'=>'submit','class' => 'button ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
                      </div> 
                  </div>
              </form>
            </div>
        </div>
      </div>
      <!-- end self assign institutional report pop up -->

      <!-- Manger assign report to analyst -->
      <div id="assignTo" class="modal" tabindex="-1" role="dialog" aria-labelledby="assignToLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="crudFormLabel">Assign to</h4>
              </div>
              <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data" id = "assign_to_form">
                  {{ csrf_field() }}
                  <!-- name Form Input -->
                  <input type="hidden" class="type" name="type" value="">
                  <input type="hidden" id="report_id" name="report_id" value="">
                  <div class="col-lg-12 col-md-12 modal-body">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <div class="select-analyst mg-top">
                        {!! Form::select('analysts', $analysts, null, ['placeholder' => 'Select Analyst', 'class' => 'form-control']) !!}
                      </div> 
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
                        <button class="button button-red close" style="margin-right: 5px;"> Cancel </button>
                        <!-- Submit Form Button -->
                        {!! Form::button('Assign', ['type'=>'submit','class' => 'button ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
                      </div> 
                  </div>
              </form>
            </div>
        </div>
      </div>
      <!-- End Manger assign institute report to analyst -->
      
    </div>
    @include('layouts.includes.library_footer_scripts')
    
    @include('layouts.includes.message')
  </body>
  <script>
    function selectAll(){
      if($("input[name=selectAll]").prop('checked')) 
        $("input[type=checkbox]").prop('checked', true);
      else 
      $("input[type=checkbox]").prop('checked', false);
    }

    function unarchive(path, id, report_name){
      $.ajax({
        url: path,
        type: 'PUT',
        dataType: 'json',
        data: {
            "_token": "{{ csrf_token() }}"
        },
        success: function(result) {
          if(result.status == 'Success'){
            $('#'+report_name+'_'+id).remove();
            if($('.'+report_name+'_archived').length <= 0){
              $(".no_archived_"+report_name).show();
            }
            toastr.success(result.message);
          }
        },
        error: function(result){
          toastr.error(result.message);
        }
      });
    }

    var bulk_url = '';
    var type = '';

    function bulk_archive(url){
      bulk_url = url;
      type = 'archive';
      //console.log(bulk_url); return false;
      $(".report_bulk_action").submit(); 
    }

    function bulk_unarchive(url){
      bulk_url = url;
      type = 'unarchive';
      //console.log(bulk_url); return false;
      $(".report_bulk_action").submit(); 
    }

    function bulk_delete(url){
      bulk_url = url;
      type = 'delete';
      //console.log(bulk_url); return false;
      $(".report_bulk_action").submit(); 
    }

    function bulk_download(url){  
      bulk_url = url; 
      type = 'download';
      //console.log(bulk_url); return false;
      $(".report_bulk_action").submit();  
    }

    function assign_external_report(id){
      $('#self_assign_report').find('.report_id').val(id);
      $('#self_assign_report').find('.type').val('external_report');
      $('#report_popup').modal('show');
      flatpickr('#due-date', {
        onChange: null
      });

      assign_report();
    }

    function assign_institution_report(id){
      $('#self_assign_report').find('.report_id').val(id);
      $('#self_assign_report').find('.type').val('institutional_report');
      $('#report_popup').modal('show');
      flatpickr('#due-date', {
        onChange: null
      });

      assign_report();
    }

    function assign_report(){
      $('#self_assign_report').on('submit',function(event){
        event.preventDefault();
        $("#self_assign_report .example-button").attr("disabled", true);
        $.ajax({
          url: $(this).attr('action'),
          type:"POST",
          data: $(this).serialize(),
          success:function(response){
            if(response.status == 'Success'){
                //console.log(response.data.latest_task_log.assigned_by_user.name);
                //$("#latest_inprogress").attr('value', dateToTimestamp(response.data.updated_at));
                //$('#'+response.data.subject_type+'_'+response.data.subject_id).remove();
                $('#assign_to_'+response.data.subject_id).parent().html('Assign To : '+response.data.latest_task_log.assigned_by_user.name);
                $('#report_popup').modal('hide');
                //$('#myReports').prepend(response.task_card);
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
    }

    function assign_institution_report_form(id){
      $('#report_id').val(id);
      $('.type').val('institutional_report');
      $('#assignTo').modal('show');
      flatpickr('#due-date', {
        onChange: null
      });
      assignReportFormSubmit();
    }

    function assign_external_report_form(id){
      $('#report_id').val(id);
      $('.type').val('external_report');
      $('#assignTo').modal('show');
      flatpickr('#due-date', {
        onChange: null
      });
      assignReportFormSubmit();
    }

    function assignReportFormSubmit(){
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
              $('#assignTo').hide();
              //$('#institution_report_'+response.data.subject_id).remove();
              //$('#myReports').prepend(response.task_card);
              $('#assign_to_'+response.data.subject_id).parent().html('Assign To : '+response.data.latest_task_log.assigned_to_user.name);
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

      @role('Analyst')
        $(".close").on("click", function(e) {
          e.preventDefault();
          $('#report_popup').modal('hide');
        });
      @endrole

      @role('Manager')
        $(".close").on("click", function(e) {
          console.log('click on console');
          e.preventDefault();
          $('#assignTo').modal('hide');
        });
      @endrole
      
      $(".report_bulk_action").submit(function(e){
        e.preventDefault(); //STOP default action
        var ref_id = $(this).serialize();
        var report_name = "{{ Route::currentRouteName() }}";
        $.ajax({
          url: bulk_url,
          type: (type == 'download' ? 'POST' : 'PUT'),
          dataType: 'json',
          data: {
              "_token": "{{ csrf_token() }}",
              "data": $(this).serialize()
          },
          success: function(result) {
            if(type == 'download'){
                window.location.href = result.zip_path;
            }
            else {
              if(result.status == 'Success'){
                $("input[type=checkbox]:checked").parent().parent().parent().remove();
                if($('#'+report_name+' .lib-item').length <= 0){
                  $("."+report_name+"_empty").show();
                }
                toastr.success(result.message);
              }
            }
          },
          error: function(response, error){
            toastr.error(JSON.parse(response.responseText));
          }
        });
      });

      
    });
  </script>
</html>
