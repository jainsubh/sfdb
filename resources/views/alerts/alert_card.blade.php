@if(count($alerts) > 0)
@foreach($alerts as $key => $alert)
<div id="alert_{{$alert->id}}" style="cursor:pointer" onclick="show_alert(<?= $alert->id ?>,'alert')" 
<?php if(auth()->user()->hasRole('Manager') || auth()->user()->hasRole('Supervisor')) {?> class="alert-items col-4 col-sm-12 col-xs-12" <?php } ?>>
    <div class="sysalerts-item">
        <p>{{ Str::limit($alert->title, 70) }}</p>
        <p class="date red">{{ \Carbon\Carbon::parse($alert->created_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</p>
        <p class="assign blue">
            @if(auth()->user()->hasRole('Analyst'))
            <a href="javascript:void(0)" >Self Assign</a> |
            @endif
            <a href="{{ route('alerts.show',''.$alert->id)}}" target="_blank"> Event Dashboard </a> |
            <a href="javascript:void(0)" onclick="alert_archive({{ $alert->id }}, event)">Archive</a>
        </p>
    </div>
</div>
@endforeach
@if(isset($with_pagination) && $with_pagination == 1)
    {{ $alerts->links('pagination.alert') }}
@endif
@endif