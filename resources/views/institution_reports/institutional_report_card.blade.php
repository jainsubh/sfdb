@if(count($institution_report) > 0)
    @foreach(@$institution_report as $key => $report)
    <div class="ireports-item ireports_{{ $report['institution_report'] }}" id="institution_report_{{ $report['id'] }}">
        <div class="item-download">
            <a href="{{ route('institution_report.download',$report['institution_report']) }}" class="download_pdf">
                <i class="fa fa-download" aria-hidden="true"></i>
            </a>
        <div id="icon_{{ $report['institution_report'] }}">
            @if($report['send_library'])
            <a href="javascript:void(0)"><i class="fa fa-book" aria-hidden="true"></i></a>
            @endif
        </div> 
        </div>
        <p>{{ Str::limit(urldecode($report['name']), 28) }}</p>
        <p>Ref ID: {{ $report['institution_report'] }}</p>
        <p class="date red">{{ \Carbon\Carbon::parse($report['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</p>
        <p class ="assign blue">
            @if(auth()->user()->hasRole('Analyst'))
            <a href="javascript:void(0)" onclick="assign_institution_report('{{ $report['id'] }}', '{{ $report['institution_report'] }}')">Self Assign</a>
            @else
            <a href="javascript:void(0)" class="assign_to" onclick="assign_report_form('{{ $report['id'] }}', '{{ $report['institution_report'] }}')">  Assign to </a>
            @endif
            |
            <a href="javascript:void(0)" onclick="archive('{{ $report['id'] }}', '{{ $report['institution_report'] }}')">Archive</a> 
            @if(!$report['send_library'])
                <span id="library_{{ $report['institution_report'] }}">  | <a href="javascript:void(0)" class="send_to_library" onclick="send_to_library('{{ $report['id'] }}', '{{ $report['institution_report'] }}')">Send to Library</a> </span>
            @endif
        </p>
    </div>
    @endforeach  
    @if(isset($with_pagination) && $with_pagination == 1)
        {{ $institution_report->links('pagination.ireport') }}
    @endif
@endif