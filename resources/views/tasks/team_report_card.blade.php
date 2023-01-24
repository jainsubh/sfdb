@if(count($tasks_completed) > 0)
@foreach($tasks_completed as $key => $task)
<div class="col-6 col-sm-12 col-xs-12"  style="cursor:pointer" id="{{ $task->subject_type.'_'.$task->subject_id }}" onclick="show_alert('{{ $task->subject_id }}', '{{ $task->subject_type }}')">
    <div class="myreports-item">
        <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            @if($task->subject_type === 'alert' || $task->subject_type === 'freeform_report' || $task->subject_type === 'external_report')
            {{ Str::limit($task->subject->title, 80) }}
            @else
            {{ Str::limit($task->subject->name, 80) }}
            @endif
        </p>
        <p class="date red">Completed Date : {{ \Carbon\Carbon::parse($task->completed_at, 'UTC')->setTimezone(auth()->user()->timezone)->isoFormat('lll') }}</p>
        @role('Manager')
            <p class="person blue">Completed By: {{ $task->completed_by_user->name }}</p>
        @endrole
        <p class="person blue">
            @if($task->semi_automatic && $task->semi_automatic->status == 'complete')
            <a href="{{ route('semi_automatic.download', $task->semi_automatic->ref_id) }}">
                Semi Automatic &nbsp;<i class="fa fa-download" aria-hidden="true"></i>  &nbsp;&nbsp; 
            </a>
            @endif
            @if($task->fully_manual && $task->fully_manual->status == 'complete')
            <a href="{{ route('fully_manual.download', $task->fully_manual->ref_id) }}">
                Fully Manual Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
            </a>
            @endif
            @if($task->product && $task->product->status == 'complete')
            <a href="{{ route('product.download', $task->product->ref_id) }}">
                Product Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
            </a>
            @endif
            @if($task->subject_type == 'freeform_report' && $task->subject->status == 'complete')
            <a href="{{ route('freeform_report.download', $task->subject->ref_id) }}">
                Free Form Report &nbsp;<i class="fa fa-download" aria-hidden="true"></i>
            </a>
            @endif
        </p>
        <?php /*
        <div class="item-download">
            <a href="{{ route('manager.download', $task->semi_automatic->ref_id) }}">
                <i class="fa fa-download" aria-hidden="true"></i>
            </a>
        </div>
        */ ?>
    </div>
</div>
@endforeach
@endif