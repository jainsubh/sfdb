<div class="col-6 col-sm-12 col-xs-12" id="{{$task->subject_type}}_{{ $task->subject_id }}" onclick="show_alert('<?= $task->subject_id ?>','{{ $task->subject_type }}')">
    @role('Manager|Supervisor')
        <div class="myreports-item">
            <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                @if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report')
                    {{ Str::limit($task->subject->title, 80) }}
                @else
                    {{ Str::limit($task->subject->name, 80) }}
                @endif
            </p>
            <p class="date red">Due Date : {{ \Carbon\Carbon::parse($task->due_date)->isoFormat('ll') }}</p>
            <p class="person blue">Assigned Analyst: {{ $task->latest_task_log->assigned_to_user->name}}</p>
            <p class="person {{ $task->priority }}">Priority: {{ ucfirst($task->priority) }}</p>
        </div>
    @endrole
    @role('Analyst')
        <div class="myreports-item">
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
    @endrole
</div>