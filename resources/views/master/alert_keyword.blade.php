@if(!$alert_keyword->isEmpty())
<div class="col-7 col-xs-6">
    <div class="entities-items">
        @for($i = 0; $i < 8; $i++)
        <p>{{$alert_keyword[$i]->keyword}}</p>
        @endfor
    </div>
</div>
<div class="col-5 col-xs-6">
    <div class="entities-items">
        @for($i = 8; $i < 16; $i++)
        <p>{{$alert_keyword[$i]->keyword}}</p>
        @endfor
    </div>
</div>
@endif