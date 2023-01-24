<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Report-Overview</title>
    <link rel="stylesheet" href="{{asset('assets/phoca/phoca-flags.css')}}">
    <link rel="stylesheet" href="{{asset('assets/phoca/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/jQuery-MultiSelect/jquery.multiselect.css')}}">
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
      .lib-item {
        display: grid;
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
      .lib-item:hover .title{
        border-bottom: 1px solid #0a1942;
      }

      .lib-item:hover .card-info-left{
        border-right: 1px solid #0a1942;
      }
      .lib-item-preview{
        width: 100%;
        min-height: 260px;
        max-height: 260px;
      }
      .lib-item-preview .img-preview{
        max-width: 100%;
        /* max-height: 157px; */
        object-fit: cover;
        object-position: center top;
      }
      .title{
        text-align: center;
        padding: 12px;
        border-bottom: 1px solid #33477c;
      }
      .card-info{
        padding: 12px 8px;
      }
      .card-info-left{
        float: left;
        display: block;
        width: 35%;
        border-right: 1px solid #33477c;
      }
      .card-info-right{
        float:right;
      }
      .card-info-right div{
        padding: 2px;
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
                      Back to Main 
                    @endrole
                    @role('Manager|Analyst')
                      Back to Dashboard 
                    @endrole
                    <i class="fa fa-share-square-o" aria-hidden="true"></i>
                  </a>
                </div>
                <h3>Report Overview</h3>
              </div>
              <div class="library-buttons">
                <div class="row">
                  <div class="col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                      <div class="col-12 col-xs-12">
                        {{ Form::open(['method' => 'get', 'url'=> 'report-overview/all']) }}
                        <div class="library-inputs">
                          <div class="row">

                              @if(is_array($dataset_arr))
                                @foreach($dataset_arr as $key => $data_val)
                                  @if(count($data_val['data']) > 0)
                                    @php 
                                      $selector_name = "dataset[".$data_val['id']."][]";
                                      $fill_data = (is_array($dataset_lookup) && array_key_exists($data_val['id'], $dataset_lookup)? $dataset_lookup[$data_val['id']]: null);
                                    @endphp
                                    <div class="col-2 col-xs-12 selector-container">
                                        {{ Form::select($selector_name, $data_val['data'], $fill_data, [
                                            'id'=>'dataset_'.$data_val['id'],
                                            'class'=>'form-control',
                                            'multiple'=>'multiple',
                                            'title' => 'Select '.$data_val['name'],
                                            ]) 
                                        }}
                                    </div>
                                  @endif
                                @endforeach
                              @endif

                              @if(auth()->user()->hasRole('Manager') || auth()->user()->hasRole('Admin'))
                                <div class="col-2 col-xs-12">
                                  <input type="text" name="search_title" placeholder="Search Reports by Title" value="{{ (app('request')->input('search_title')!='')?app('request')->input('search_title'):'' }}" class="search-input">
                                </div>

                                <div class="col-2 col-xs-12">
                                  <button type="submit" class="button" style="margin-right:10px">Search</button>
                                  <button type="reset" class="button" onclick="window.location.href='{{ URL::current() }}'">Reset</button>
                                </div>
                              @else
                                <div class="col-2 col-xs-12">
                                  <input type="text" name="search_title" placeholder="Search Reports by Title" value="{{ (app('request')->input('search_title')!='')?app('request')->input('search_title'):'' }}" class="search-input">
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
                <br />
                <!--
                <div class="row">
                  <div class="col-12 col-xs-12">
                    <div class="lib-actions">
                        <h4 style=" float: left; display: inline-flex;"> {{ strtoupper(str_replace("_"," ",Route::currentRouteName())) }} </h4>
                    </div>
                  </div>
                </div>
                -->

                <form class="report_bulk_action" method="put">
                @if(Route::currentRouteName() == 'freeform_report' || Route::currentRouteName() == 'report-overview')
                  @if(count($freeform_report) > 0)
                    @if(Route::currentRouteName() == 'report-overview')<h4>FreeForm Report</h4>@endif
                  
                      <div class="row" id="freeform_report"> 
                        @foreach(@$freeform_report as $report)
                          <div class="col-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="lib-item">
                              <div class="lib-item-preview">
                                <a href="{{ route('freeform_report.download', [$report['ref_id'], 'pdf']) }}">
                                  @if($report->thumbnail != '')
                                    <img src="{{ route('storage.image', $report->thumbnail) }}/freeform_report/thumbnail" class="img-preview" alt="Report Preview">
                                  @else
                                    <img src="{{ url('images/sample.jpg') }}" class="img-preview" alt="Report Preview" />
                                  @endif 
                                </a>
                              </div>
                              <div class="lib-item-left">
                                <div class="title" >
                                  {!! Str::limit(html_entity_decode($report->title), 31) !!}
                                </div>
                              </div> 
                              <div class="card-info">
                                <a href="{{ route('report-detail', 'freeform_report') }}/{{ $report->id }}">
                                  <div class="card-info-left">
                                    <div class="phoca-box">
                                      <div class="phoca-flagbox">
                                        @if(count($report->report_countries) > 0)
                                        <span class="phoca-flag {{ strtolower($report->report_countries[0]->country->country_code2) }}"></span>
                                        @endif
                                      </div>
                                    </div>
                                  </div>
                                  <div class="card-info-right">
                                    <div class="date red card-date">{{ \Carbon\Carbon::parse($report['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</div>  
                                    <div class="txt card-assignedto">
                                      @if($report->tasks != null)
                                        {{$report->tasks->latest_task_log->assigned_to_user->name}}
                                      @else
                                        Unassigned
                                      @endif
                                    </div>
                                  </div>
                                </a>
                              </div> 
                            </div>
                          </div>     
                        @endforeach
                      </div>
                      @if(Route::currentRouteName() != 'report-overview')
                      <div class="d-flex justify-content-center">
                        {{ $freeform_report->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'freeform_report')    
                  <h6 style="margin: 13em; text-align:center">There are no freeform reports added to library yet.</h6>       
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="freeform_report_empty">There are no freeform reports added to library yet.</h6> 
                @endif

                @if(Route::currentRouteName() == 'external_report' || Route::currentRouteName() == 'report-overview')
                  @if(count($external_report) > 0)
                    @if(Route::currentRouteName() == 'report-overview')<h4>External Reports</h4>@endif
                  
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
                      @if(Route::currentRouteName() != 'report-overview')
                      <div class="d-flex justify-content-center">
                        {{ $external_report->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'external_report')    
                  <h6 style="margin: 13em; text-align:center">There are no external reports added to library yet.</h6>       
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="external_report_empty">There are no external reports added to library yet.</h6> 
                @endif

                @if(Route::currentRouteName() == 'scenario_report' || Route::currentRouteName() == 'report-overview')
                  @if(count($scenario_report) > 0)
                    @if(Route::currentRouteName() == 'report-overview')<h4>Scenario Reports</h4>@endif
                  
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
                      @if(Route::currentRouteName() != 'report-overview')
                      <div class="d-flex justify-content-center">
                        {{ $scenario_report->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'scenario_report')    
                  <h6 style="margin: 13em; text-align:center">There are no scenario reports added to library yet.</h6>       
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="scenario_report_empty">There are no scenario reports added to library yet.</h6> 
                @endif

                @if(Route::currentRouteName() == 'video_report' || Route::currentRouteName() == 'report-overview')
                  @if(count($video_report) > 0)
                    @if(Route::currentRouteName() == 'report-overview')<h4>Video Reports</h4>@endif
                  
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
                      @if(Route::currentRouteName() != 'report-overview')
                      <div class="d-flex justify-content-center">
                        {{ $video_report->links('pagination::default') }}
                      </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'video_report')    
                  <h6 style="margin: 13em; text-align:center">There are no video reports added to library yet.</h6>       
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="video_report_empty">There are no video reports added to library yet.</h6> 
                @endif

                @if(Route::currentRouteName() == 'fully_manual' || Route::currentRouteName() == 'report-overview')
                  @if(count($fully_manual) > 0)
                    @if(Route::currentRouteName() == 'report-overview')<br><h4>Fully Manual</h4>@endif
                  
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
                      @if(Route::currentRouteName() != 'report-overview')
                        <div class="d-flex justify-content-center">
                          {{ $fully_manual->links('pagination::default') }}
                        </div>
                      @endif
                  @elseif(Route::currentRouteName() == 'fully_manual')
                  <h6 style="margin: 13em; text-align:center">There are no fully manual reports added to library yet.</h6>             
                  @endif
                  <h6 style="margin: 13em; text-align:center; display:none" class="fully_manual_empty">There are no fully manual reports added to library yet.</h6>   
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
  <script src="{{asset('assets/jQuery-MultiSelect/jquery.multiselect.js')}}"></script>
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

      @if(is_array($dataset_arr))
        @foreach($dataset_arr as $key => $data_val)
          $('#dataset_{{ $data_val['id'] }}').multiselect({
            texts: {
                placeholder: 'Select {{ $data_val['name'] }}'
            }
          });
        @endforeach
      @endif

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
