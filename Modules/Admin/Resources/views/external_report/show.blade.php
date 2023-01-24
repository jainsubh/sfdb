<style>
    .select{ padding: 0px !important; width: 28%; float: left; margin-right: 8px; }
    .select_radio{ float: left; margin-left: 10px; width: 19%;}
    .mg-10{ margin-top: 10px; }
    .button{ height: 40px !important; }
    .item-left{ width: 45% !important; }
    .item-right{ width: 40% !important; text-align: center !important;}
    .item-center{ width:30%; float:left; }
    #alert-panel .mng-tweet-list { height: 160px; }
    .comment-list { height: 85px; }
    .checkmark{margin-top: 0px;}
    .radio{ cursor:pointer;float:left; margin-right: 32%; vertical-align: middle;}
    .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
    }
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        font-size:14px;
        top: -2.5em;
        /* Position the tooltip */
        position: absolute;
        z-index: 1;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
    }
    .comment_user{ width: 73%; display:inline-flex; font-weight:bold;}
    .blue{ color: #28adfb !important;}
    .red{ color: red !important; font-weight:bold; }
    hr{
        border: 0;
        height: 1px;
        color: white;
        margin-bottom:15px;
        background-image: linear-gradient(to right, rgba(0, 0, 0, 0), #f8f9fa, #fff, rgba(0, 0, 0, 0));
    }
        
    .item-right{
        width:100% !important;
        text-align: right;
    }
    .alert-tweets{ height: 300px;}
    .alert-comment{
        height: 70px;
    }
    #report_modal .modal-content{
        width: 500px;
    }
</style>
<link rel="stylesheet" href="{{asset('assets/styles/css/themes/radio.min.css')}}">
<div id="alert-show-{{ $external_report->id }}" style="display: contents">
    <div class="col-6 col-xs-12">
        <div class="alert-head">
            <div class="alert-title">
            <h3>External Report</h3>
            </div>
            <div class="alert-sector">
                <div class="item">
                    <div class="title">Organisation Name</div>
                    <div id="alert_sector" class="value">{{ $external_report->organization_name}}</div>
                </div>
                
                <div class="item">
                    <div class="title">Priority</div>
                    <div id="alert_department" class="{{$external_report->tasks->priority}}"><strong>{{ ucfirst($external_report->tasks->priority) }}</strong></div>
                </div>
            </div>
        </div>
        <div class="alert-title">
            <div class="title">Title</div>
            <div id="alert_title" class="value"> 
                {{ $external_report->title }}
            </div>
        </div>

        <div class="alert-title">
            <div class="title">Organization Url</div>
            <div id="alert_title" class="value"> 
                {{ $external_report->organization_url }}
            </div>
        </div>

        <div class="alert-title">
            <div class="title">Comments</div>
            <div id="alert_title" class="value"> 
                {{ $external_report->comments }}
            </div>
        </div>
    </div>
    <div class="col-6 col-xs-12">
        <div class="alert-ref">
            <div class="alert-keyword">
                <div class="item-right">
                    <div class="ref">
                        <div class="title" style="text-align: right; margin: 0px 30px 4px 0px;">Reports</div>
                    </div>
                    <div class="ref-icons">
                        <div class="icons">                 
                            @role('Analyst|Supervisor')
                                @if($external_report->tasks && $external_report->tasks->fully_manual)
                                <div class="tooltip">
                                    <div class="ref-icon">
                                        @if($external_report->tasks->fully_manual->status != 'complete')
                                        <a href="{{ route('fully_manual.edit', $external_report->tasks->fully_manual->id) }}">
                                        @elseif($external_report->tasks->fully_manual->status == 'complete' && $external_report->tasks->status != 'complete')
                                        <a href="javascript:void(0)" class="report_modal" onclick="report_modal('fully_manual')">
                                        @else
                                        <a href="{{ route('fully_manual.download', $external_report->tasks->fully_manual->ref_id) }}">
                                        @endif
                                            <img src="images/ref-edit.svg" alt="fully_manual_report" class="icon">
                                            <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">Fully Manual <br> {{$external_report->tasks->fully_manual->ref_id}}</div>
                                        </a>
                                    </div>
                                </div>
                                @else
                                <div class="tooltip">
                                    <div class="ref-icon">
                                        <a onclick="generateFullyManual('{{ $external_report->tasks->id }}')" href="javascript:void(0)">
                                            <img src="images/ref-edit.svg" alt="generate_fully_manual" class="icon">
                                            <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                Generate Fully Manual Report
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endif

                                @if($external_report->tasks && $external_report->tasks->product)
                                <div class="tooltip">
                                    <div class="ref-icon">
                                        @if($external_report->tasks->product->status != 'complete')
                                        <a href="{{ route('product.edit', $external_report->tasks->product->id) }}">
                                        @elseif($external_report->tasks->product->status == 'complete' && $external_report->tasks->status != 'complete')
                                        <a href="javascript:void(0)" class="report_modal" onclick="report_modal('product')">
                                        @else
                                        <a href="{{ route('product.download', $external_report->tasks->product->ref_id) }}">
                                        @endif
                                            <img src="images/ref-edit.svg" alt="product_report" class="icon">
                                            <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">Product <br> {{$external_report->tasks->product->ref_id}}</div>
                                        </a>
                                    </div>
                                </div>
                                @else
                                <div class="tooltip">
                                    <div class="ref-icon">
                                        <a onclick="generateProduct('{{ $external_report->tasks->id }}')" href="javascript:void(0)">
                                            <img src="images/ref-edit.svg" alt="generate_product" class="icon">
                                            <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                Generate Product Report
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endif
                            @endrole

                            @role('Manager')
                                @if($external_report->tasks && $external_report->tasks->fully_manual && $external_report->tasks->fully_manual->status == 'complete')
                                <div class="tooltip">
                                    <div class="ref-icon">
                                        <a href="{{ route('fully_manual.download', $external_report->tasks->fully_manual->ref_id) }}">
                                        <img src="images/ref-edit.svg" alt="fully_manual_report" class="icon">
                                        <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">Fully Manual <br> {{$external_report->tasks->fully_manual->ref_id}}</div>
                                    </div>
                                </div>
                                @endif

                                @if($external_report->tasks && $external_report->tasks->product && $external_report->tasks->product->status == 'complete')
                                <div class="tooltip">
                                    <div class="ref-icon">
                                        <a href="{{ route('product.download', $external_report->tasks->product->ref_id) }}">
                                        <img src="images/ref-edit.svg" alt="product_report" class="icon">
                                        <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">Product <br> {{$external_report->tasks->product->ref_id}}</div>
                                    </div>
                                </div>
                                @endif
                            @endrole

                            <div class="tooltip">
                                <div class="ref-icon">
                                    <a href="{{ route('external_report.download', $external_report->external_report) }}">
                                        <img src="images/ref-star.svg" alt="download_external_report" class="icon">
                                        <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                            External Report <br />{{ $external_report->external_report }}
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="alert-tweets mg-10">
        </div>

        <div class="alert-comment mg-10">    
        </div>

        <div class="mng-alert-buttons mg-10">
            @role('Manager|Supervisor')
                <div class="select mg-10" id="AssigningForm">
                @if($external_report->tasks->status ==  'pending' || !$external_report->tasks)
                    {{ Form::open(array('route' => 'tasks.store', 'method' => 'post' , 'id' => 'assign_to')) }}
                    {{ Form::hidden('report_id', $external_report->id) }}
                    <input type="hidden" name="type" value="external_report">
                    <div class="select">
                        {!! Form::select('analysts', $analysts, null, ['id' => 'analysts','placeholder' => 'Select Analyst', 'class' => 'form-control']) !!}
                    </div>
                    <div class="select">
                        <input id="due-date" name="due_date" placeholder="Select Due Date">
                    </div>
                    <div class="select_radio" style="<?= ($external_report->tasks->status == 'pending' ? 'width:16%': '') ?>">
                        <label class="radio radio-outline-success">
                            <div class="tooltip">
                                <input type="radio" name="priority" value="low" formcontrolname="priority">
                                <span class="checkmark"  value="low"></span>
                                <span class="tooltiptext">Low Priority</span>
                            </div>
                        </label>
                        <label class="radio radio-outline-warning">
                            <div class="tooltip">
                                <input type="radio" name="priority" value="medium" formcontrolname="priority">
                                <span class="checkmark" value="medium"></span>
                                <span class="tooltiptext">Medium Priority</span>
                            </div>
                        </label>
                        <label class="radio radio-outline-danger">
                            <div class="tooltip">
                                <input type="radio" name="priority" value="high" formcontrolname="priority">
                                <span class="checkmark" value="high"></span>
                                <span class="tooltiptext">High Priority</span>
                            </div>
                        </label>
                    </div>
                    <div class="assign">
                        @if($external_report->tasks->status == 'pending')
                            {{ Form::hidden('request_type', 'reassign') }}
                            {{ Form::hidden('task_id', $external_report->tasks->id, array('id' => 'task_id')) }}
                            {{ Form::button('Reassign', array('class' => 'button-red ladda-button example-button m-1', 'data-style' => 'expand-right', 'type' => 'submit', 'style' => 'margin-top:5px', 'name' => 'reassign')) }}
                        @else
                            {{ Form::button('Assign', array('class' => 'button ladda-button example-button m-1', 'data-style' => 'expand-right', 'type' => 'submit', 'name' => 'assign')) }}
                        @endif
                    </div>
                    {{ Form::close() }}
                @elseif($external_report->tasks->status ==  'complete')
                    <p class="title" style="text-align:center; line-height: 42px">Task has been completed by {{ $external_report->tasks->completed_by_user->name }}
                        <button class="button-red btn-primary" style="float: right" onclick="reopen('{{ $external_report->tasks->id }}')" href="javascript:void(0)"> Reopen </button>
                    </p>
                @else
                    @if(auth()->user()->id == $external_report->tasks->latest_task_log->assigned_to)
                    <div class="alert-buttons" style="margin-top:2%">
                        <div class="transfer">
                            {{ Form::open(array('route' => 'tasks.transfer', 'method' => 'post', 'id' => 'transfer_form')) }} 
                                @if(isset($external_report->tasks))
                                    <?php $task_id = $external_report->tasks->id; ?>
                                @else    
                                    <?php $task_id = null; ?>
                                @endif

                                {{ Form::hidden('task_id', $task_id, array('id' => 'task_id')) }}
                                <button class="button-red ladda-button example-button m-1" data-style="expand-right" name="submit" type="submit">Transfer</button>
                            {{ Form::close() }}
                        </div>
                        <div class="send">
                            @if($external_report->tasks && $external_report->tasks->fully_manual && $external_report->tasks->fully_manual->status == 'complete' && $external_report->tasks->status != 'complete')
                                <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('{{ $external_report->tasks->id }}')" href="javascript:void(0)"> complete & send </button>
                            @else
                                <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" href="javascript:void(0)" disabled="disabled"> complete & send </button>
                            @endif
                        </div>
                    </div>
                    @else
                    <p class="title" style="text-align:center">Task has assigned to {{ $external_report->tasks->latest_task_log->assigned_to_user->name }}</p>
                    @endif
                @endif
                </div>
            @endrole
            @role('Analyst')
                @if($external_report->tasks && $external_report->tasks->status == 'complete')
                    <div class="select mg-10">
                        <p class="title" style="text-align:center; line-height: 42px">
                            Task has been completed
                        </p>
                    </div>
                @else
                    <div class="alert-buttons" style="margin-top:2%">
                        <div class="transfer">
                            {{ Form::open(array('route' => 'tasks.transfer', 'method' => 'post', 'id' => 'transfer_form')) }} 
                                @if(isset($external_report->tasks))
                                    <?php $task_id = $external_report->tasks->id; ?>
                                @else    
                                    <?php $task_id = null; ?>
                                @endif

                                {{ Form::hidden('task_id', $task_id, array('id' => 'task_id')) }}
                                <button class="button-red ladda-button example-button m-1" data-style="expand-right" name="submit" type="submit">Transfer</button>
                            {{ Form::close() }}
                        </div>
                        <div class="send">
                            @if($external_report->tasks && $external_report->tasks->fully_manual && $external_report->tasks->fully_manual->status == 'complete' && $external_report->tasks->status != 'complete')
                                <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('{{ $external_report->tasks->id }}')" href="javascript:void(0)"> complete & send </button>
                            @else
                                <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" href="javascript:void(0)" disabled="disabled"> complete & send </button>
                            @endif
                        </div>
                    </div>
                @endif
            @endrole

        </div>
    </div>
</div>


<div id="report_modal" class="modal">
    <div class="modal-content">
        <div class="panel-modal-head">
            <a href="javascript:void(0)" onclick="$('#report_modal').modal('hide');" class="close" aria-label="Close">&times;</a>
            <div class="panel-title">Reports</div>
        </div>
        
        <div class="panel-modal-content">
            <div class="title" style="text-align:center;">Please select an option</div>
            <div class="modal-footer" style="margin-top: 25px; ">  
                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center; margin-bottom: 25px;">
                    <div class="btn_fully_manual" style="display:none">
                        @if($external_report->tasks && $external_report->tasks->fully_manual)
                        <button class="button" onclick="window.location='{{ route('fully_manual.download', $external_report->tasks->fully_manual->ref_id ) }}'" style="margin-right: 15px;"> Download Report </button>
                        <button class="button" id="regenerate" onclick="regenerate('{{ $external_report->tasks->fully_manual->id }}', 'fully_manual')"> Continue Report </button>
                        @endif
                    </div>

                    <div class="btn_product" style="display:none">
                        @if($external_report->tasks && $external_report->tasks->product)
                        <button class="button" onclick="window.location='{{ route('product.download', $external_report->tasks->product->ref_id ) }}'" style="margin-right: 15px;"> Download Report </button>
                        <button class="button" id="regenerate" onclick="regenerate('{{ $external_report->tasks->product->id }}', 'product')"> Continue Report </button>
                        @endif
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
