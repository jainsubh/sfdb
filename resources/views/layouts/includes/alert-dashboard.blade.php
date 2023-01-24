<section id="alert" class="row">
    <div class="col-12 col-xs-12">
        <div class="alert-holder">
            <div class="alert-txt">
                <h2>ALERTS</h2>
            </div>
            <div class="marquee-parent">
                <div class="marquee-child">
                    <div class="marquee-horz" style="width:1000px" data-speed=38 data-pauseOnHover='true' data-pauseOnCycle='true' >
                        @if(isset($alert))
                        <span> {{$alert->title}} </span>
                        @elseif(isset($alerts))
                            @foreach($alerts as $alert)
                            <span>{{$alert->title}} </span>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            @endforeach
                        @else
                            <div></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>