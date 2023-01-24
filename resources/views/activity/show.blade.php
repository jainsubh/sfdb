@role('Manager')
    @if($activities)
        @foreach($activities as $key => $activity)
        <div class="notification-item">
            <p>
                <a href="javascript:void(0)" onclick="show_alert('{{ $activity->subject->subject_id }}', '{{ $activity->subject->subject_type }}')">
                    @if($activity->description == 'assign')
                        Task has been assigned
                    @elseif($activity->description == 'self_assign')
                        Task has been self assigned
                    @elseif($activity->description == 'transfer_request')
                        Task transfer request
                    @elseif($activity->description == 'completed')
                        Task completed
                    @elseif($activity->description == 'transfered')
                        Task has been transfered
                    @elseif($activity->description == 'reopen')
                        Task open for review again
                    @endif
                </a>
            </p>
            <p class="date red">
            @if($activity->description != 'completed')
                Due Date - {{ \Carbon\Carbon::parse($activity->subject->due_date)->isoFormat('ll') }}
            @else
                Complete Date - {{ \Carbon\Carbon::parse($activity->updated_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('ll') }}
            @endif
            </p>
            <p class="assign blue">
            @if($activity->description == 'completed')
                Completed By : {{ $activity->causer->name }}
            @else
                Assigned To : {{ $activity->getExtraProperty('assigned_to_name') }}
            @endif
            </p>
            <p class="person {{ $activity->subject->priority }}">
            Priority: {{ ucfirst($activity->subject->priority) }}
            </p>
        </div>
        @endforeach
    @endif
@endrole

@role('Analyst')
    @if($activities)
        @foreach($activities as $key => $activity)
        <div class="myalerts-item">
            <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                @if($activity->subject->latest_task_log->assigned_to == auth()->user()->id && $activity->description != 'transfer_request')
                    <a href="javascript:void(0)" onclick="show_alert('{{ $activity->subject->subject_id }}', '{{ $activity->subject->subject_type }}')">
                @else
                    <span style="color: #bbb4b4">
                @endif
                    @if($activity->description == 'assign' || $activity->description == 'transfered')
                        Task has been assigned
                    @elseif($activity->description == 'self_assign')
                        Task has been self assigned
                    @elseif($activity->description == 'transfer_request')
                        Task transfer requested to manager
                    @elseif($activity->description == 'completed')
                        Task completed
                    @elseif($activity->description == 'reopen')
                        Task open for review again
                    @endif
                @if($activity->subject->latest_task_log->assigned_to == auth()->user()->id && $activity->description != 'transfer_request')
                    </a>
                @else
                    </span>
                @endif
            </p>
            <p class="date red">
            @if($activity->description != 'completed')
                Due Date - {{ \Carbon\Carbon::parse($activity->subject->due_date)->isoFormat('ll') }}
            @else
                Complete Date - {{ \Carbon\Carbon::parse($activity->updated_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('ll') }}
            @endif
            </p>
            <p class="assign blue">
            @if($activity->description == 'completed')
            @elseif($activity->description == 'self_assign')
            @else
                Assigned By : {{ $activity->causer->name }}
            @endif
            </p>
            <p class="person {{ $activity->subject->priority }}">
            Priority: {{ ucfirst($activity->subject->priority) }}
            </p>
        </div>
        @endforeach
    @endif
@endrole