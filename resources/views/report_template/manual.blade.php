<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fully Manual Report</title>
  <link href="{{ asset('report_template/css/style.css') }}" rel="stylesheet">
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
                          <img class="img-responsive" src="{{ asset('report_template/images/logo.png') }}">
                        </div>
                      </td>
                      <td width="40%" height="90">
                        <div class="rep-title"> (Note: Fully Manual Report) </div>
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
              <td width="100%" height="10" class="spaceTable"><img src="{{ asset('report_template/images/spacer-10.png') }}"></td>
            </tr>
            <tr>
              <td width="100%" height="120">
                <table class="headTable" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="10%" class="row-head">Title</td>
                      <td width="90%" colspan="5">
                          <h2 id="report_title">
                            @if(isset($fully_manual_report) && $fully_manual_report->title)
                                {{ Str::limit($fully_manual_report->title, 90) }}
                            @endif
                          </h2>
                      </td>
                    </tr>
                    <tr>
                      <td width="10%" class="row-head">Sector</td>
                      <td width="21%">
                        @if(isset($fully_manual_report) && $fully_manual_report->sectors)
                          {!! $fully_manual_report->sectors->name !!}
                        @endif
                      </td>
                      <td width="10%" class="row-head">Priority</td>
                      <td width="10%">
                        @if(isset($fully_manual_report) && $fully_manual_report->priority)
                          {{ $fully_manual_report->priority }}
                        @endif
                      </td>
                      <td width="12%" class="row-head">Objective</td>
                      <td width="37%">
                        @if(isset($fully_manual_report) && $fully_manual_report->objectives)
                          {{ Str::limit($fully_manual_report->objectives, 60) }}
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td class="row-head">Date</td>
                      <td>
                        @if(isset($fully_manual_report) && $fully_manual_report->date_time)
                          {{ \Carbon\Carbon::parse($fully_manual_report->date_time)->isoFormat('ll') }}
                        @endif
                      </td>
                      <td class="row-head">Time</td>
                      <td>
                        @if(isset($fully_manual_report) && $fully_manual_report->date_time)
                          {{ \Carbon\Carbon::parse($fully_manual_report->date_time)->toTimeString() }}
                        @endif
                      </td>
                      <td class="row-head">Reference</td>
                      <td>
                        @if(isset($fully_manual_report) && $fully_manual_report->ref_id)
                          {{ $fully_manual_report->ref_id }}
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
                                        @if(isset($fully_manual_report) && $fully_manual_report->summary)
                                            {!! $fully_manual_report->summary !!}
                                        @endif
                                    </p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                      <td width="10" height="385"><img src="{{ asset('report_template/images/spacer-10.png') }}"></td>
                      <td width="50%" height="385">
                        <table class="imgTable" cellspacing="0" width="100%">
                          <tbody>
                              <tr>
                                <td width="50%">
                                  @if(isset($fully_manual_report->gallery[0]))
                                  <img class="img-responsive" src="{{ asset('storage/'.$fully_manual_report->gallery[0]->images) }}">
                                  @endif
                                </td>
                                <td width="10">
                                  <img src="{{ asset('report_template/images/spacer-10.png') }}">
                                </td>
                                <td width="50%">
                                  @if(isset($fully_manual_report->gallery[1]))
                                  <img class="img-responsive" src="{{ asset('storage/'.$fully_manual_report->gallery[1]->images) }}">
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <td width="10" height="10" colspan="3" class="spaceTable">
                                  <img src="{{ asset('report_template/images/spacer-10.png') }}">
                                </td>
                              </tr>
                              <tr>
                                  @if(isset($fully_manual_report->gallery[2]))
                                  <td><img class="img-responsive" src="{{ asset('storage/'.$fully_manual_report->gallery[2]->images) }}"></td>
                                  @endif
                                  <td><img src="{{ asset('report_template/images/spacer-10.png') }}"></td>
                                  @if(isset($fully_manual_report->gallery[3]))
                                  <td><img class="img-responsive" src="{{ asset('storage/'.$fully_manual_report->gallery[3]->images) }}"></td>
                                  @endif
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
                              @if(isset($fully_manual_report) && $fully_manual_report->key_information)
                                  {!! $fully_manual_report->key_information !!}
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
                              @if(isset($fully_manual_report) && $fully_manual_report->recommendation)
                                  {!! $fully_manual_report->recommendation !!}
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
                        <div class="box-250 box">
                          <div class="box-content">
                            <ul>
                              @if(isset($fully_manual_links) && count($fully_manual_links) > 0)
                                @foreach($fully_manual_links as $i => $link)
                                  @if($i <= 7)
                                  <a href="{!! $link !!}" target="_blank" class="black"><li>{!! $link !!}</li></a>
                                  @endif
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