<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Freeform Report</title>
  <link href="{{ asset('report_template/css/style.css') }}" rel="stylesheet" />
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
                        <div class="rep-title"> (Note: Freeform Report) </div>
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
                      <td width="90%" colspan="5"><h2 id="report_title">
                        @if($freeform_report && $freeform_report->title != null)
                            {{ Str::ucfirst($freeform_report->title) }}
                        @endif
                      </h2>
                      </td>
                    </tr>
                    <tr>
                      <td width="10%" class="row-head">Sector</td>
                      <td width="21%">
                        @if($freeform_report && $freeform_report->id != null)
                            {{ $freeform_report->sectors->name }}
                        @endif  
                      </td>
                      <td width="10%" class="row-head">Priority</td>
                      <td width="10%">
                        @if($freeform_report && $freeform_report->priority != null)
                            {{ Str::ucfirst($freeform_report->priority) }}
                        @endif
                      </td>
                      <td width="12%" class="row-head">Objective</td>
                      <td width="37%">
                        @if($freeform_report && $freeform_report->objective != null)
                            {{ Str::ucfirst($freeform_report->objective) }}
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td class="row-head">Date</td>
                      <td>{{ \Carbon\Carbon::parse(now())->isoFormat('ll') }}</td>
                      <td class="row-head">Time</td>
                      <td>{{ \Carbon\Carbon::now(auth()->user()->timezone)->toTimeString() }}</td>
                      <td class="row-head">Reference</td>
                      <td>
                        @if(isset($freeform_report->ref_id))
                            {{ $freeform_report->ref_id }}
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
              <td width="100%" height="1200" class="boxTable">
                <div class="free-box-content">
                  <img class="img-responsive" src="">
                    <p> 
                        @if($freeform_report && $freeform_report != null)
                        {!! $freeform_report->key_information !!}
                      @endif
                    </p>
                </div>
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

</html>