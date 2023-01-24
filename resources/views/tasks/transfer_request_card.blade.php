@if(count($task_transfer) > 0)
@foreach($task_transfer as $key => $transfer)
<div id="{{ $transfer->subject_type }}_{{ $transfer->subject_id }}" class="col-4 col-sm-12 col-xs-12" style="cursor:pointer" onclick="show_alert('<?= $transfer->subject_id ?>', '<?= $transfer->subject_type ?>')">
    <div class="sysalerts-item myreports-item">
        <p>
            @if($transfer->subject_type === 'alert' || $transfer->subject_type === 'freeform_report' ||  $transfer->subject_type === 'external_report')
            {{ Str::limit($transfer->subject->title, 80) }}
            @else
            {{ Str::limit($transfer->subject->name, 80) }}
            @endif
        </p>
        <p class="date red">{{ \Carbon\Carbon::parse($transfer->due_date)->isoFormat('ll') }}</p>
        <p class="assign blue"><a href="javascript:void(0)">Request by: {{ $transfer->latest_task_log->assigned_to_user->name}}</a></p>
    </div>
</div>
@endforeach
@endif