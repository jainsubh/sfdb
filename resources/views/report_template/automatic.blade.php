<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fully Automated Report</title>
  <link href="{{ asset('report_template/css/style.css') }}" rel="stylesheet" />
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
                          <img class="img-responsive" alt="" src="{{ asset('report_template/images/logo.png') }}">
                        </div>
                      </td>
                      <td width="40%" height="90">
                        <div class="rep-title"> (Note: Fully Automated Report) </div>
                      </td>
                      <td width="20%" height="90">
                        <div class="logo-right">
                          <img class="img-responsive" src="{{ asset('report_template/images/logo.png') }}">
                        </div>
                      </td>
                      <td width="20%" height="90">
                        <div class="logo-right">
                          <img class="img-responsive" src="{{ asset('report_template/images/logo.png') }}">
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td width="100%" height="10" class="spaceTable"><img src="{{asset('report_template/images/spacer-10.png') }}"></td>
            </tr>
            <tr>
              <td width="100%" height="120">
                <table class="headTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="10%" class="row-head">Title</td>
                      <td width="90%" colspan="5">
                        <h2>
                          @if(isset($alert) && $alert->title)
                            {{ Str::limit($alert->title, 80) }}
                          @endif
                        </h2>
                      </td>
                    </tr>
                    <tr>
                      <td width="10%" class="row-head">Sector</td>
                      <td width="21%">
                        @if(isset($alert) && $alert->sectors)
                          {!! $alert->sectors->name !!}
                        @endif
                      </td>
                      <td width="10%" class="row-head">Priority</td>
                      <td width="10%">
                        @if(isset($alert) && $alert->priority)
                          {!! $alert->priority !!}
                        @else
                          Medium
                        @endif
                      </td>
                      <td width="12%" class="row-head">Objective</td>
                      <td width="37%">
                        @if(isset($alert) && $alert->objective)
                          {!! $alert->objective !!}
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td class="row-head">Date</td>
                      <td>
                        @if(isset($alert) && $alert->created_at)
                          {{ \Carbon\Carbon::parse($alert->created_at)->isoFormat('ll') }}
                        @endif
                      </td>
                      <td class="row-head">Time</td>
                      <td>
                        @if(isset($alert) && $alert->created_at)
                          {{ \Carbon\Carbon::parse($alert->created_at)->toTimeString() }}
                        @endif
                      </td>
                      <td class="row-head">Reference</td>
                      <td>
                        @if(isset($alert) && $alert->ref_id)
                          {{ $alert->ref_id }}
                        @endif
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td width="100%" height="10" class="spaceTable"><img src="{{ asset('report_template/images/spacer-10.png') }}"></td>
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
                              @if(isset($alert) && $alert->summary)
                                {!! $alert->summary !!}
                              @endif
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
              <td width="100%" height="10" class="spaceTable"><img src="{{ asset('report_template/images/spacer-10.png') }}"></td>
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
                                      @if(isset($alert) && $alert->events)
                                        {!! $alert->events->name !!}
                                      @endif
                                    </p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                      <td width="10" height="235"><img src="{{ asset('report_template/images/spacer-10.png') }}"></td>
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
                                    @if(isset($alert->countries))
                                      @foreach($alert->countries as $countries)
                                        <p>{{$countries->country->city}}, {{$countries->country->country_name}}</p>
                                      @endforeach
                                    @endif
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
              <td width="100%" height="10" class="spaceTable"><img src="{{ asset('report_template/images/spacer-10.png') }}"></td>
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
                              @if(isset($alert) && $alert->recommendation)
                                {!! $alert->recommendation !!}
                              @endif
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
              <td width="100%" height="10" class="spaceTable"><img src="{{ asset('report_template/images/spacer-10.png') }}"></td>
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
                              @if(isset($links) && count($links) > 0)
                                @foreach($links as $link)
                                  <a href="{!! $link !!}" target="_blank" class="black"><p>{!! $link !!}</p></a>
                                @endforeach
                              @endif
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
              <td width="100%" height="10" class="spaceTable"><img src="{{ asset('report_template/images/spacer-10.png') }}"></td>
            </tr>
            <tr>
              <td width="100%" height="50">
                <table class="footerTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="13.33%">Analyst</td>
                      <td width="20%">
                        @if(auth()->user()->hasRole('Analyst'))
                            {{ auth()->user()->name }}
                        @endif
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

</html>