<section id="alert" class="row">
    <div class="col-12 col-xs-12">
        <div class="alert-holder">
        <div class="alert-txt">
            <h2>ALERTS</h2>
        </div>
        <div class="module-alert">
            <div class="tickerwrapper">
            <ul class='list'>
            @if(isset($alert))
                <li class='listitem'>{{$alert->title}}</li>
            @elseif(isset($alerts))
                @foreach($alerts as $alert)
                    <li class='listitem'>{{ $alert->title }}</li>
                @endforeach
            @else
                <li class='listitem'></li>
            @endif
            </ul>
            </div>
        </div>
        </div>
    </div>
</section>