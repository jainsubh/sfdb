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
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/css/themes/radio.min.css')); ?>">
<div id="alert-show-<?php echo e($institute_report->id); ?>" style="display: contents">
    <div class="col-6 col-xs-12">
        <div class="alert-head">
            <div class="alert-title">
            <h3>Institutional Report</h3>
            </div>
            <div class="alert-sector">
                <div class="item">
                    <div class="title">Organisation</div>
                    <div id="alert_sector" class="value"><?php echo e($institute_report->organization->name); ?></div>
                </div>
                
                <div class="item">
                    <div class="title">Priority</div>
                    <div id="alert_department" class="<?php echo e($institute_report->tasks->priority); ?>"><strong><?php echo e(ucfirst($institute_report->tasks->priority)); ?></strong></div>
                </div>
            </div>
        </div>
        <div class="alert-title">
            <div class="title">Title</div>
            <div id="alert_title" class="value"> 
                <?php echo e($institute_report->name); ?>

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
                            <?php if(auth()->check() && auth()->user()->hasRole('Analyst|Supervisor')): ?>
                                <?php if($institute_report->tasks && $institute_report->tasks->latest_task_log && Auth::id() == $institute_report->tasks->latest_task_log->assigned_to): ?>
                                    <?php if($institute_report->tasks && $institute_report->tasks->fully_manual): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">
                                                <?php if($institute_report->tasks->fully_manual->status != 'complete'): ?>
                                                <a href="<?php echo e(route('fully_manual.edit', $institute_report->tasks->fully_manual->id)); ?>">
                                                <?php elseif($institute_report->tasks->fully_manual->status == 'complete' && $institute_report->tasks->status != 'complete'): ?>
                                                <a href="javascript:void(0)" class="report_modal" onclick="report_modal('fully_manual')">
                                                <?php else: ?>
                                                <a href="<?php echo e(route('fully_manual.download', $institute_report->tasks->fully_manual->ref_id)); ?>">
                                                <?php endif; ?>
                                                    <img src="images/ref-edit.svg" alt="fully_manual_report" class="icon">
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">Fully Manual <br> <?php echo e($institute_report->tasks->fully_manual->ref_id); ?></div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">
                                                <a onclick="generateFullyManual('<?php echo e($institute_report->tasks->id); ?>')" href="javascript:void(0)">
                                                    <img src="images/ref-edit.svg" alt="generate_fully_manual" class="icon">
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        <!--Institution Report <br /><?php echo e($institute_report->institution_report); ?>-->
                                                        Generate Fully Manual Report
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($institute_report->tasks && $institute_report->tasks->product): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">
                                                <?php if($institute_report->tasks->product->status != 'complete'): ?>
                                                <a href="<?php echo e(route('product.edit', $institute_report->tasks->product->id)); ?>">
                                                <?php elseif($institute_report->tasks->product->status == 'complete' && $institute_report->tasks->status != 'complete'): ?>
                                                <a href="javascript:void(0)" class="report_modal" onclick="report_modal('product')">
                                                <?php else: ?>
                                                <a href="<?php echo e(route('product.download', $institute_report->tasks->product->ref_id)); ?>">
                                                <?php endif; ?>
                                                    <img src="images/ref-edit.svg" alt="product_report" class="icon">
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">Product <br> <?php echo e($institute_report->tasks->product->ref_id); ?></div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">
                                                <a onclick="generateProduct('<?php echo e($institute_report->tasks->id); ?>')" href="javascript:void(0)">
                                                    <img src="images/ref-edit.svg" alt="generate_product" class="icon">
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        <!--Institution Report <br /><?php echo e($institute_report->institution_report); ?>-->
                                                        Generate Product Report
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(auth()->check() && auth()->user()->hasRole('Manager|Supervisor')): ?>
                                <?php if($institute_report->tasks && $institute_report->tasks->latest_task_log && Auth::id() != $institute_report->tasks->latest_task_log->assigned_to): ?>
                                    <?php if($institute_report->tasks && $institute_report->tasks->fully_manual && $institute_report->tasks->fully_manual->status == 'complete'): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">    
                                                <a href="<?php echo e(route('fully_manual.download', $institute_report->tasks->fully_manual->ref_id)); ?>">
                                                    <img src="images/ref-edit.svg" alt="" class="icon" />
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Fully Manual <br> <?php echo e($institute_report->tasks->fully_manual->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($institute_report->tasks && $institute_report->tasks->product && $institute_report->tasks->product->status == 'complete'): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">    
                                                <a href="<?php echo e(route('product.download', $institute_report->tasks->product->ref_id)); ?>">
                                                    <img src="images/ref-edit.svg" alt="" class="icon" />
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Product <br> <?php echo e($institute_report->tasks->product->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="tooltip">
                                <div class="ref-icon">
                                    <a href="<?php echo e(route('institution_report.download', $institute_report->institution_report)); ?>">
                                        <img src="images/ref-star.svg" alt="download_institution_report" class="icon">
                                        <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                            Institution Report <br /><?php echo e($institute_report->institution_report); ?>

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
            <?php if(auth()->check() && auth()->user()->hasRole('Manager|Supervisor')): ?>
                <div class="select mg-10" id="AssigningForm">
                <?php if($institute_report->tasks->status ==  'pending' || !$institute_report->tasks): ?>
                    <?php echo e(Form::open(array('route' => 'tasks.store', 'method' => 'post' , 'id' => 'assign_to'))); ?>

                    <?php echo e(Form::hidden('report_id', $institute_report->id)); ?>

                    <input type="hidden" name="type" value="institutional_report">
                    <div class="select">
                        <?php echo Form::select('analysts', $analysts, null, ['id' => 'analysts','placeholder' => 'Select Analyst', 'class' => 'form-control']); ?>

                    </div>
                    <div class="select">
                        <input id="due-date" name="due_date" placeholder="Select Due Date">
                    </div>
                    <div class="select_radio" style="<?= ($institute_report->tasks->status == 'pending' ? 'width:16%': '') ?>">
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
                        <?php if($institute_report->tasks->status == 'pending'): ?>
                            <?php echo e(Form::hidden('request_type', 'reassign')); ?>

                            <?php echo e(Form::hidden('task_id', $institute_report->tasks->id, array('id' => 'task_id'))); ?>

                            <?php echo e(Form::button('Reassign', array('class' => 'button-red ladda-button example-button m-1', 'data-style' => 'expand-right', 'type' => 'submit', 'style' => 'margin-top:5px', 'name' => 'reassign'))); ?>

                        <?php else: ?>
                            <?php echo e(Form::button('Assign', array('class' => 'button ladda-button example-button m-1', 'data-style' => 'expand-right', 'type' => 'submit', 'name' => 'assign'))); ?>

                        <?php endif; ?>
                    </div>
                    <?php echo e(Form::close()); ?>

                <?php elseif($institute_report->tasks->status ==  'complete'): ?>
                    <p class="title" style="text-align:center; line-height: 42px">Task has been completed by <?php echo e($institute_report->tasks->completed_by_user->name); ?>

                        <button class="button-red btn-primary" style="float: right" onclick="reopen('<?php echo e($institute_report->tasks->id); ?>')" href="javascript:void(0)"> Reopen </button>
                    </p>
                <?php else: ?>
                    <?php if(auth()->user()->id == $institute_report->tasks->latest_task_log->assigned_to): ?>
                        <div class="alert-buttons" style="margin-top:2%">
                            <div class="transfer">
                                <?php echo e(Form::open(array('route' => 'tasks.transfer', 'method' => 'post', 'id' => 'transfer_form'))); ?> 
                                    <?php if(isset($institute_report->tasks)): ?>
                                        <?php $task_id = $institute_report->tasks->id; ?>
                                    <?php else: ?>    
                                        <?php $task_id = null; ?>
                                    <?php endif; ?>

                                    <?php echo e(Form::hidden('task_id', $task_id, array('id' => 'task_id'))); ?>

                                    <button class="button-red ladda-button example-button m-1" data-style="expand-right" name="submit" type="submit">Transfer</button>
                                <?php echo e(Form::close()); ?>

                            </div>
                            <div class="send">
                                <?php if($institute_report->tasks && $institute_report->tasks->fully_manual && $institute_report->tasks->fully_manual->status == 'complete' && $institute_report->tasks->status != 'complete'): ?>
                                    <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('<?php echo e($institute_report->tasks->id); ?>')" href="javascript:void(0)"> complete & send </button>
                                <?php elseif($institute_report->tasks && $institute_report->tasks->product && $institute_report->tasks->product->status == 'complete' && $institute_report->tasks->status != 'complete'): ?>
                                    <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('<?php echo e($institute_report->tasks->id); ?>')" href="javascript:void(0)"> complete & send </button>
                                <?php else: ?>
                                    <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" href="javascript:void(0)" disabled="disabled"> complete & send </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="title" style="text-align:center">Task has assigned to <?php echo e($institute_report->tasks->latest_task_log->assigned_to_user->name); ?></p>
                
                    <?php endif; ?>
                <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if(auth()->check() && auth()->user()->hasRole('Analyst')): ?>
                <?php if($institute_report->tasks && $institute_report->tasks->status == 'complete'): ?>
                    <div class="select mg-10">
                        <p class="title" style="text-align:center; line-height: 42px">
                            Task has been completed
                        </p>
                    </div>
                <?php else: ?>
                    <div class="alert-buttons" style="margin-top:2%">
                        <div class="transfer">
                            <?php echo e(Form::open(array('route' => 'tasks.transfer', 'method' => 'post', 'id' => 'transfer_form'))); ?> 
                                <?php if(isset($institute_report->tasks)): ?>
                                    <?php $task_id = $institute_report->tasks->id; ?>
                                <?php else: ?>    
                                    <?php $task_id = null; ?>
                                <?php endif; ?>

                                <?php echo e(Form::hidden('task_id', $task_id, array('id' => 'task_id'))); ?>

                                <button class="button-red ladda-button example-button m-1" data-style="expand-right" name="submit" type="submit">Transfer</button>
                            <?php echo e(Form::close()); ?>

                        </div>
                        <div class="send">
                            <?php if($institute_report->tasks && $institute_report->tasks->fully_manual && $institute_report->tasks->fully_manual->status == 'complete' && $institute_report->tasks->status != 'complete'): ?>
                                <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('<?php echo e($institute_report->tasks->id); ?>')" href="javascript:void(0)"> complete & send </button>
                            <?php elseif($institute_report->tasks && $institute_report->tasks->product && $institute_report->tasks->product->status == 'complete' && $institute_report->tasks->status != 'complete'): ?>
                                <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('<?php echo e($institute_report->tasks->id); ?>')" href="javascript:void(0)"> complete & send </button>
                            <?php else: ?>
                                <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" href="javascript:void(0)" disabled="disabled"> complete & send </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
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
                        <?php if($institute_report->tasks && $institute_report->tasks->fully_manual): ?>
                        <button class="button" onclick="window.location='<?php echo e(route('fully_manual.download', $institute_report->tasks->fully_manual->ref_id )); ?>'" style="margin-right: 15px;"> Download Report </button>
                        <button class="button" id="regenerate" onclick="regenerate('<?php echo e($institute_report->tasks->fully_manual->id); ?>', 'fully_manual')"> Continue Report </button>
                        <?php endif; ?>
                    </div>

                    <div class="btn_product" style="display:none">
                        <?php if($institute_report->tasks && $institute_report->tasks->product): ?>
                        <button class="button" onclick="window.location='<?php echo e(route('product.download', $institute_report->tasks->product->ref_id )); ?>'" style="margin-right: 15px;"> Download Report </button>
                        <button class="button" id="regenerate" onclick="regenerate('<?php echo e($institute_report->tasks->product->id); ?>', 'product')"> Continue Report </button>
                        <?php endif; ?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Volumes/Data/sfdbd_new/resources/views/institution_reports/show.blade.php ENDPATH**/ ?>