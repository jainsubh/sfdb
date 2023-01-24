
<style>
    .panel{
        height: 42px;
        margin-bottom : 10px;
        font-size: 16px;
    }
    .panel h3{
        font-size: 12px !important;
    }
    .item-right{
        text-align:right;
    }
    .text{
        font-weight: 400;
    }
    .module_bottom{
        background: #0a1942;
        border-bottom: 1px solid #33477c;
        padding: 10px;
        margin-bottom: 0px;
        position: relative;
    }
    .no_event_info{
        position: relative;
        top: 40%;
        left: 30%;
    }
    #detail_event_info{
        height: 420px;
    }
   
</style>
@if($event)
    <div id="event-show-{{ $event->id }}" style="display: contents">
        <div class="col-12 col-xs-12">
            <div class="alert-head">
                <div class="item-left alert-title">
                    <h3>Event Name - <span class="blue"> {{$event->name}} </span> </h3>
                </div>
                <!--<div class="item-right alert-title">
                    <a href="" target="_blank"><h3>Event Dashboard</h3></a>
                </div>-->
            </div>
        </div>

        <div class="col-3 col-xs-12">
            <article class="panel module">
                <h3>Sector</h3>
            </article>
            <article class="panel module">
                <h3>Event Start Date</h3>
            </article>
            <article class="panel module">
                <h3>is this continuous event?</h3>
            </article>
            <article  class="panel module">
                <h3>Event End Date</h3>
            </article>
            <article  class="panel module">
                <h3>Event Status</h3>
            </article>
            <article  class="panel module">
                <h3>Event Owner</h3>
            </article>
            <article  class="panel module">
                <h3>Event Categories</h3>
            </article>
            <article  class="panel module">
                <h3>Sites Monitored</h3>
            </article>
            <article  class="panel module">
                <h3>Keywords Monitored</h3>
            </article>
        </div>

        <div class="col-4 col-xs-12">
            <article  class="panel module">
                <span class="text"> {{ ($event->sectors?$event->sectors->name:'') }} </span>
            </article>
            <article  class="panel module">
                <span class="text">{{ $event->start_date?\Carbon\Carbon::parse($event->start_date)->isoFormat('ll'):'--' }}</span>
            </article>
            <article  class="panel module">
                <span class="text">{{ $event->end_date?'No':'Yes' }}</span>
            </article>
            <article  class="panel module">
                <span class="text">{{ $event->end_date?\Carbon\Carbon::parse($event->end_date)->isoFormat('ll'):'--' }}</span>
            </article>
            <article  class="panel module">
                <span class="text">{{ ucfirst($event->status) }}</span>
            </article>
            <article  class="panel module">
                <span class="text"> {{ ($event->created_by_user?$event->created_by_user->name:' -- ') }} </span>
            </article>
            <article  class="panel module">
                <span class="text yellow">
                    <a href="javascript:void(0)" onclick="detail_event_info('{{ $event->id }}' , 'departments')" style="text-decoration: underline"> 
                        Click here to view the list of categories 
                    </a>
                </span>
            </article>
            <article class="panel module">
                <span class="text yellow">
                    <a href="javascript:void(0)" onclick="detail_event_info('{{ $event->id }}' , 'sites')" style="text-decoration: underline"> 
                        Click here to view the list of sites 
                    </a>
                </span>
            </article>
            <article  class="panel module">
                <span class="text yellow">
                    <a href="javascript:void(0)" onclick="detail_event_info('{{ $event->id }}' , 'keywords')" style="text-decoration: underline"> 
                        Click here to view the list of keywords 
                    </a>
                </span>
            </article>
        </div>

    <div class="col-5 col-xs-12">
        <div class="alert-head">
           <h3 style="margin: 6px;"> <span class="blue" id="dynamic_head"></span></h3>
        </div>
        <div  id="detail_event_info">
        </div>
    </div>
@endif