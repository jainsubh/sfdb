@if(count($tasks)>0)
    @foreach($tasks as $key => $task)
        @if($task->subject != null)
            <tr>
                <td>
                    @if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report')
                    {{ Str::limit($task->subject->title, 65) }}
                    @else
                    {{ Str::limit($task->subject->name, 65) }}
                    @endif
                </td>
            @role('Manager|Supervisor')
                <td>{{ (isset($task->latest_task_log)? ucfirst($task->latest_task_log->assigned_to_user->name): '' ) }}</td>
            @endrole
                <td>{{ ucfirst($task->status) }}</td>
                @if($task->priority === 'high')
                    <?php $color = 'red' ?>
                @elseif($task->priority === 'medium')
                    <?php $color = 'yellow' ?>
                @else
                    <?php $color = 'green' ?>
                @endif
                <td style="font-weight:bold; color:{{ $color }}">{{ ucfirst($task->priority) }}</td>
                <td>{{ \Carbon\Carbon::parse($task->created_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll') }}</td>
                <td>{{ \Carbon\Carbon::parse($task->due_date)->isoFormat('ll') }}</td>
            </tr>
        @endif
    @endforeach
@else
    <tr>
        <td colspan="6">
            <h5 style="margin-top: 20px; color:#28adfb; text-align:center">No tasks assigned yet.</h5>
        </td>
    </tr>
@endif   
