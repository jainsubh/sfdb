@if(count($events) > 0)
@foreach($events as $event)
    <div class="col-12 col-xs-12" id="event_{{$event->id}}" style="curson:pointer; margin-bottom:10px; padding: 3px 0px 5px 14px;" onclick="show_alert('{{ $event->id }}', 'events')">
        <div class="myreports-item">
        <p style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            {{ Str::limit($event->name, 80) }}
        </p>
        <p class="person blue">Sector name: {{ ($event->sectors?Str::limit($event->sectors->name, 27):'') }}</p>
        <p class="person blue">Created By: {{ ($event->created_by_user?$event->created_by_user->name:'') }}</p>
        <p class="date red">Event Start date : {{ \Carbon\Carbon::parse($event->created_at)->isoFormat('ll') }}</p>
        </div>
    </div>
@endforeach
@endif