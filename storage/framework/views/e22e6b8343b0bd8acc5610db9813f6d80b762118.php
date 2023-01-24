<style>
    .select{ padding: 0px !important; width: 28%; float: left; margin-right: 8px; }
    .select_radio{ float: left; margin-left: 10px; width: 19%;}
    .mg-10{ margin-top: 10px; }
    .button{ height: 40px !important; }
    .item-left{ width: 45% !important; }
    .item-right{ width: 30% !important; text-align: center !important;}
    .item-center{ width:30%; float:left; }
    #alert-panel .mng-tweet-list { height: 160px; }
    .comment-list { height: 180px; }
    .checkmark{margin-top: 0px;}
    .radio{ cursor:pointer;float:left; margin-right: 32%; vertical-align: middle;}
    .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
    }
    .tooltip .tooltiptext {
        visibility: hidden;
        min-width:130px;
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
    .event-title{
        width: 115%;
        text-align:center;
    }
    #alert_event{
        font-size: 16px !important;
        line-height: 2;
    }
    .alert-sector{
        width: 30% !important;
    }
    #report_modal .modal-content{
        width: 500px;
    }
    #alert-panel .title{
        margin-bottom: 7px;
    }
    #alert-panel .summary-list{
        height: 110px;
    }
    #alert-panel .url-list{
        height: 220px;
    }
    #word_definition .modal-content{
        width: 800px;
        max-height: 600px;
        overflow-y: auto;
    }
    #word_definition .word{
        text-align: left;
        margin-bottom: 0px;
    }
    #word_definition .punctuation{
        font-size: 12px;
    }
    #word_definition ul li{
        padding: 4px 25px;
        font-weight: normal;
        font-size: 14px;
    }
    #word_definition .definition_type{
        padding: 5px 0px;
    }
    #word_definition .meaning-container{
        position: relative;
        min-height: 100px;
    }
</style>
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/css/themes/radio.min.css')); ?>">
<div id="alert-show-<?php echo e($alert->id); ?>" style="display: contents">
    <div class="col-6 col-xs-12">
        <div class="alert-head">
            <div class="item-left alert-title">
                <h3>Alert</h3>
            </div>
            <div class="item-center event-title">
                
                <div id="alert_event" class="value">
                    <a href="<?php echo e(route('alerts.show', $alert->id)); ?>">
                        <strong> <?php echo e($alert->events != null ? Str::limit($alert->events->name,35) : ''); ?></strong>
                    </a>
                </div>
            </div>
            <div class="item-right alert-sector">
                <div class="item">
                    <div class="title">Sector</div>
                    <div id="alert_sector" class="value"><?php echo e(Str::limit($alert->sectors->name, 22)); ?></div>
                </div>
            </div>
        </div>
        <div class="alert-title">
            <div class="title">Title</div>
            <div id="alert_title" class="value"> 
                <?php echo e(Str::limit($alert->title, 105)); ?>

            </div>
        </div>
        <div class="alert-summary">
            <div class="title">Summary</div>
            <div class="scroll-wrapper summary-list">
            <div class="scroll-inner">
                <div class="txt white">
                    <p id="alert_summary">
                        <?php echo e(strip_tags($alert->summary)); ?>

                    </p>
                </div>
            </div>
            </div>
        </div>
        <div class="alert-url">
            <div class="title">Top Url</div>
            <div class="scroll-wrapper url-list">
            <div class="scroll-inner">
                <div class="txt white" id="alert_url">
                <?php $__currentLoopData = $alert->links->pluck('url'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $links): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($links); ?>" target="_blank" style="color:white; "> <p> <?php echo e($key+1); ?>. &nbsp; <?php echo e($links); ?></p> </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xs-12">
        <div class="alert-ref">
            <div class="alert-keyword">
                <div class="item-left">
                    <div class="title">Keyword – Event Trigger</div>
                    <div class="scroll-wrapper keywords-list">
                        <div class="scroll-inner">
                            <div id="alert_keyword" class="keywords-items">
                                <?php $__currentLoopData = $alert->keywords->pluck('keyword'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keywords): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="keywords-box white"> <?php echo e($keywords); ?> </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-right">
                    <div class="title">Sentiment Analysis</div>
                    <div class="txt green">Positive: <?php echo e($alert->positive); ?></div>
                    <div class="txt red">Negative: <?php echo e($alert->negative); ?></div>
                    <div class="txt orange">Neutral: <?php echo e($alert->neutral); ?></div>
                </div>
                <div class="item-center">
                    <div class="title" style="text-align: right; margin: 0px 30px 4px 0px;">Reports</div>
                    <div class="ref-icons">
                        <div class="icons">
                            
                            <?php if(auth()->check() && auth()->user()->hasRole('Manager|Supervisor')): ?>
                                <?php if($alert->tasks && $alert->tasks->latest_task_log && Auth::id() != $alert->tasks->latest_task_log->assigned_to): ?>
                                    <?php if($alert->tasks && $alert->tasks->semi_automatic && $alert->tasks->semi_automatic->status == 'complete'): ?>
                                        <div class="tooltip"> 
                                            <div class="ref-icon">  
                                                <a href="<?php echo e(route('semi_automatic.download', $alert->tasks->semi_automatic->ref_id)); ?>">
                                                    <img src="images/ref-cross.svg" alt="" class="icon">
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">Semi Automatic <br> <?php echo e($alert->tasks->semi_automatic->ref_id); ?></div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($alert->tasks && $alert->tasks->fully_manual && $alert->tasks->fully_manual->status == 'complete'): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">    
                                                <a href="<?php echo e(route('fully_manual.download', $alert->tasks->fully_manual->ref_id)); ?>">
                                                    <img src="images/ref-edit.svg" alt="" class="icon" />
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Fully Manual <br> <?php echo e($alert->tasks->fully_manual->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($alert->tasks && $alert->tasks->product && $alert->tasks->product->status == 'complete'): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">    
                                                <a href="<?php echo e(route('product.download', $alert->tasks->product->ref_id)); ?>">
                                                    <img src="images/ref-edit.svg" alt="" class="icon" />
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Product <br> <?php echo e($alert->tasks->product->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="tooltip">
                                        <div class="ref-icon" style="cursor:pointer">
                                            <a href="<?php echo e(route('alerts.download', $alert->ref_id)); ?>">
                                            <!--<a href="javascript:void(0)" class="report_modal" onclick="report_modal('automatic')">-->
                                                <img src="images/ref-star.svg" alt="" class="icon">
                                                <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">System Generated <br> <?php echo e($alert->ref_id); ?></div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if(auth()->check() && auth()->user()->hasRole('Analyst|Supervisor')): ?>
                                <?php if($alert->tasks && $alert->tasks->latest_task_log && Auth::id() == $alert->tasks->latest_task_log->assigned_to): ?>
                                    <?php if($alert->tasks->status != 'complete' && !$alert->tasks->semi_automatic): ?>
                                        <div class="tooltip"> 
                                            <div class="ref-icon">
                                                <a onclick="generateSemiAutomatic('<?php echo e($alert->tasks->id); ?>', '<?php echo e($alert->tasks->subject_id); ?>')" href="javascript:void(0)">
                                                    <img src="images/ref-cross.svg" alt="" class="icon">  
                                                    <div class="tooltiptext">Semi Automatic </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php elseif($alert->tasks->status != 'complete' && $alert->tasks->semi_automatic && $alert->tasks->semi_automatic->status != 'complete'): ?>
                                        <div class="tooltip"> 
                                            <div class="ref-icon">
                                                <a href="<?php echo e(route('semi_automatic.create')); ?>/task/<?php echo e($alert->tasks->id); ?>">
                                                    <img src="images/ref-cross.svg" alt="" class="icon">  
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Semi Automatic <br /> <?php echo e($alert->tasks->semi_automatic->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php elseif($alert->tasks->status != 'complete' && $alert->tasks->semi_automatic && $alert->tasks->semi_automatic->status == 'complete'): ?>
                                        <div class="tooltip"> 
                                            <div class="ref-icon">  
                                                <a href="javascript:void(0)" class="report_modal" onclick="report_modal('semi_automatic')">
                                                    <img src="images/ref-cross.svg" alt="" class="icon">
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">Semi Automatic <br> <?php echo e($alert->tasks->semi_automatic->ref_id); ?></div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php elseif($alert->tasks->status == 'complete' && $alert->tasks->semi_automatic && $alert->tasks->semi_automatic->status == 'complete'): ?>
                                        <div class="tooltip"> 
                                            <div class="ref-icon">  
                                                <a href="<?php echo e(route('semi_automatic.download', $alert->tasks->semi_automatic->ref_id)); ?>">
                                                    <img src="images/ref-cross.svg" alt="" class="icon">
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">Semi Automatic <br> <?php echo e($alert->tasks->semi_automatic->ref_id); ?></div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                
                                    <?php if($alert->tasks->status != 'complete' && !$alert->tasks->fully_manual): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">    
                                                <a onclick="generateFullyManual('<?php echo e($alert->tasks->id); ?>')" href="javascript:void(0)">
                                                    <img src="images/ref-edit.svg" alt="" class="icon" />
                                                    <div class="tooltiptext" style="width: 120px; text-align: center;">
                                                        Fully Manual
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php elseif($alert->tasks->status != 'complete' && $alert->tasks->fully_manual && $alert->tasks->fully_manual->status != 'complete'): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">    
                                                <a href="<?php echo e(route('fully_manual.edit', $alert->tasks->fully_manual->id)); ?>">
                                                    <img src="images/ref-edit.svg" alt="" class="icon" />
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Fully Manual <br> <?php echo e($alert->tasks->fully_manual->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                
                                    <?php elseif($alert->tasks->status != 'complete' && $alert->tasks->fully_manual && $alert->tasks->fully_manual->status == 'complete'): ?>
                                        <div class="tooltip"> 
                                            <div class="ref-icon">  
                                                <a href="javascript:void(0)" onclick="report_modal('fully_manual')">
                                                    <img src="images/ref-edit.svg" alt="" class="icon">
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Fully Manual <br> <?php echo e($alert->tasks->fully_manual->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php elseif( $alert->tasks->fully_manual && $alert->tasks->fully_manual->status == 'complete'): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">    
                                                <a href="<?php echo e(route('fully_manual.download', $alert->tasks->fully_manual->ref_id)); ?>">
                                                    <img src="images/ref-edit.svg" alt="" class="icon" />
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Fully Manual <br> <?php echo e($alert->tasks->fully_manual->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($alert->tasks->status != 'complete' && !$alert->tasks->product): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">    
                                                <a onclick="generateProduct('<?php echo e($alert->tasks->id); ?>')" href="javascript:void(0)">
                                                    <img src="images/ref-edit.svg" alt="" class="icon" />
                                                    <div class="tooltiptext" style="width: 175px; text-align: center;">
                                                        Generate Product Report
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php elseif($alert->tasks->status != 'complete' && $alert->tasks->product && $alert->tasks->product->status != 'complete'): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">    
                                                <a href="<?php echo e(route('product.edit', $alert->tasks->product->id)); ?>">
                                                    <img src="images/ref-edit.svg" alt="" class="icon" />
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Product <br> <?php echo e($alert->tasks->product->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php elseif($alert->tasks->status != 'complete' && $alert->tasks->product && $alert->tasks->product->status == 'complete'): ?>
                                        <div class="tooltip"> 
                                            <div class="ref-icon">  
                                                <a href="javascript:void(0)" onclick="report_modal('product')">
                                                    <img src="images/ref-edit.svg" alt="" class="icon">
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Product <br> <?php echo e($alert->tasks->product->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php elseif($alert->tasks->product && $alert->tasks->product->status == 'complete' && $alert->tasks->product && $alert->tasks->product->status == 'complete'): ?>
                                        <div class="tooltip">
                                            <div class="ref-icon">    
                                                <a href="<?php echo e(route('product.download', $alert->tasks->product->ref_id)); ?>">
                                                    <img src="images/ref-edit.svg" alt="" class="icon" />
                                                    <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">
                                                        Product <br> <?php echo e($alert->tasks->product->ref_id); ?>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                
                                    <div class="tooltip">
                                        <div class="ref-icon" style="cursor:pointer">
                                            <!--<a href="<?php echo e(route('alerts.download', $alert->ref_id)); ?>">-->
                                            <a href="javascript:void(0)" class="report_modal" onclick="report_modal('automatic')">
                                                <img src="images/ref-star.svg" alt="" class="icon">
                                                <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">System Generated <br> <?php echo e($alert->ref_id); ?></div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(!$alert->tasks): ?>
                            <div class="tooltip">
                                <div class="ref-icon" style="cursor:pointer">
                                    <a href="<?php echo e(route('alerts.download', $alert->ref_id)); ?>">
                                    <!--<a href="javascript:void(0)" class="report_modal" onclick="report_modal('automatic')">-->
                                        <img src="images/ref-star.svg" alt="" class="icon">
                                        <div class="tooltiptext" style="top:-3.7em; width: 190px; text-align: left; padding-left: 15px;">System Generated <br> <?php echo e($alert->ref_id); ?></div>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert-tweets mg-10">
            <div class="title">Categories</div>
            <div class="scroll-wrapper department-list">
                <div class="scroll-inner">
                    <div id="alert_keyword" class="keywords-items">
                        <?php $__currentLoopData = $alert->events->eventdepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="keywords-box white"> <?php echo e($value->departments->name); ?> </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert-comment mg-10">
            <div class="title">Comments</div>
            <div class="scroll-wrapper mg-10 comment-list">
                <div class="scroll-inner">
                    <div id="comment_section">
                        <?php if(count($alert->comments) > 0): ?>
                            <?php $__currentLoopData = $alert->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="txt white">
                                <p>
                                    <span class="comment_user blue"><?php echo e($comment->users->name); ?></span>
                                    <span class="comment_date red"><?php echo e(\Carbon\Carbon::parse($comment->created_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll')); ?></span>
                                </p>
                                <p><?php echo e($comment->comments); ?></p>
                                <hr class="mg-10">
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p id="no_comment" class="title" style="line-height:145px; text-align:center">There are no comments added yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="comment mg-10">
                <?php echo e(Form::open(array('id' => 'commentForm'))); ?>

                    <?php echo e(csrf_field()); ?>

                    <?php echo e(Form::hidden('alert_id', $alert->id)); ?>

                    <input type="text" autoComplete="off" style="width: 75%; float: left; margin-right: 10px;" name="comments" placeholder="Add Comment" required>
                    <button class="button" style=" width: 20%; padding: 0px; cursor:pointer">Add <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
        <div class="mng-alert-buttons mg-10">
            <?php if(auth()->check() && auth()->user()->hasRole('Manager|Supervisor')): ?>
                <div class="select mg-10" id="AssigningForm">
                    <?php if(!$alert->tasks || $alert->tasks->status == 'pending'): ?>
                        <?php echo e(Form::open(array('route' => 'tasks.store', 'method' => 'post' , 'id' => 'assign_to'))); ?>

                        <?php echo e(Form::hidden('alert_id', $alert->id)); ?>

                        <?php 
                            if(isset($alert->tasks->latest_task_log) == 'transfer'){
                                $task_status = 'transfer';
                            }else{
                                $task_status = 'new';
                            }
                        ?>
                        <input type="hidden" name="type" value="alert">
                        <div class="select">
                            <?php echo Form::select('analysts', $analysts, null, ['id' => 'analysts','placeholder' => 'Select Analyst', 'class' => 'form-control']); ?>

                        </div>
                        <div class="select">
                            <input id="due-date" name="due_date" placeholder="Select Due Date">
                        </div>
                        <div class="select_radio" style="<?= ($task_status == 'transfer' ? 'width:16%': '') ?>">
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
                            <?php  if($task_status == 'transfer'){ ?>
                                <?php echo e(Form::hidden('request_type', 'reassign')); ?>

                                <?php echo e(Form::hidden('task_id', $alert->tasks->id, array('id' => 'task_id'))); ?>

                                <?php echo e(Form::button('Reassign', array('class' => 'button-red ladda-button example-button m-1', 'data-style' => 'expand-right', 'type' => 'submit', 'style' => 'margin-top:5px', 'name' => 'reassign'))); ?>

                            <?php }else{ ?>
                                <?php echo e(Form::button('Assign', array('class' => 'button ladda-button example-button m-1', 'data-style' => 'expand-right', 'type' => 'submit', 'name' => 'assign'))); ?>

                            <?php } ?>
                        </div>
                        <?php echo e(Form::close()); ?>

                    <?php elseif($alert->tasks->status ==  'complete'): ?>
                        <div class="reopen">
                            <p class="title" style="text-align:center; line-height: 42px">Task has been completed by <?php echo e($alert->tasks->completed_by_user->name); ?>

                                <button class="example-button button-red btn-primary" style="float: right" onclick="reopen('<?php echo e($alert->tasks->id); ?>')" href="javascript:void(0)"> Reopen </button>
                            </p>
                        </div>
                    <?php else: ?>
                        <?php if(auth()->user()->id == $alert->tasks->latest_task_log->assigned_to): ?>
                            <div class="alert-buttons" id="transferForm" style="margin-top:1%; <?= (isset($alert->tasks)? '': 'display: none') ?>">
                                <div class="transfer">
                                    <?php echo e(Form::open(array('route' => 'tasks.transfer', 'method' => 'post', 'id' => 'transfer_form'))); ?> 
                                    <?php if(isset($alert->tasks)): ?>
                                        <?php $task_id = $alert->tasks->id; ?>
                                    <?php else: ?>
                                        <?php $task_id = null; ?>
                                    <?php endif; ?>

                                    <?php echo e(Form::hidden('task_id', $task_id, array('id' => 'task_id'))); ?>

                                        <button class="button-red ladda-button example-button m-1" data-style="expand-right" name="submit" type="submit">Transfer</button>
                                    <?php echo e(Form::close()); ?>

                                </div>
                                <div class="send">
                                    <?php if($alert->tasks && $alert->tasks->fully_manual && $alert->tasks->fully_manual->status == 'complete'): ?>
                                        <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('<?php echo e($alert->tasks->id); ?>')" href="javascript:void(0)"> complete & send </button>
                                    <?php elseif($alert->tasks && $alert->tasks->semi_automatic && $alert->tasks->semi_automatic->status == 'complete'): ?>
                                        <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('<?php echo e($alert->tasks->id); ?>')" href="javascript:void(0)"> complete & send </button>
                                    <?php elseif($alert->tasks && $alert->tasks->product && $alert->tasks->product->status == 'complete'): ?>
                                        <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('<?php echo e($alert->tasks->id); ?>')" href="javascript:void(0)"> complete & send </button>
                                    <?php else: ?>
                                        <button class="button btn-primary" href="javascript:void(0)" disabled="disabled"> complete & send </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="title" style="text-align:center">Task has assigned to <?php echo e($alert->tasks->latest_task_log->assigned_to_user->name); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if(auth()->check() && auth()->user()->hasRole('Analyst')): ?>

                <?php if($alert->tasks && $alert->tasks->status == 'pending'): ?>
                    <div class="select mg-10">
                        <p class="title" style="text-align:center; line-height: 42px">
                            Request has been submit for transfer to manager
                        </p>
                    </div>
                <?php elseif($alert->tasks && $alert->tasks->status == 'complete'): ?>
                    <div class="select mg-10">
                        <p class="title" style="text-align:center; line-height: 42px">
                            Task has been completed
                        </p>
                    </div>
                <?php else: ?>
                    <div class="alert-buttons" id="transferForm" style="margin-top:1%; <?= (isset($alert->tasks)? '': 'display: none') ?>">
                        <div class="transfer">
                            <?php echo e(Form::open(array('route' => 'tasks.transfer', 'method' => 'post', 'id' => 'transfer_form'))); ?> 
                            <?php if(isset($alert->tasks)): ?>
                                <?php $task_id = $alert->tasks->id; ?>
                            <?php else: ?>
                                <?php $task_id = null; ?>
                            <?php endif; ?>

                            <?php echo e(Form::hidden('task_id', $task_id, array('id' => 'task_id'))); ?>

                                <button class="button-red ladda-button example-button m-1" data-style="expand-right" name="submit" type="submit">Transfer</button>
                            <?php echo e(Form::close()); ?>

                        </div>
                        <div class="send">
                            <?php if($alert->tasks && $alert->tasks->fully_manual && $alert->tasks->fully_manual->status == 'complete'): ?>
                                <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('<?php echo e($alert->tasks->id); ?>')" href="javascript:void(0)"> complete & send </button>
                            <?php elseif($alert->tasks && $alert->tasks->semi_automatic && $alert->tasks->semi_automatic->status == 'complete'): ?>
                                <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('<?php echo e($alert->tasks->id); ?>')" href="javascript:void(0)"> complete & send </button>
                            <?php elseif($alert->tasks && $alert->tasks->product && $alert->tasks->product->status == 'complete'): ?>
                                <button class="button btn-primary ladda-button example-button m-1" data-style="expand-right" onclick="completeTask('<?php echo e($alert->tasks->id); ?>')" href="javascript:void(0)"> complete & send </button>
                            <?php else: ?>
                                <button class="button btn-primary" href="javascript:void(0)" disabled="disabled"> complete & send </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="select mg-10" id="selfAssignForm" style="<?= (isset($alert->tasks)? 'display: none': '') ?>">
                    <?php echo e(Form::open(array('route' => 'tasks.store', 'method' => 'post', 'id' => 'self_assign'))); ?>

                    <?php echo e(Form::hidden('alert_id', $alert->id)); ?>

                    <input type="hidden" name="type" value="alert">
                    <div style="width:40%; float:left; margin-right:18px">
                        <input id="due-date" name="due_date" placeholder="Select Due Date">
                    </div>
                    <div class="title" style="float:left; margin-top: 11px; font-size: 16px;">Priority : </div>
                    <div class="select_radio" style="margin-left:17px; width:20%;">
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
                        <button class="button ladda-button example-button m-1" data-style="expand-right" name="submit" type="submit" style="float:right"> Self Assign </button>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
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
        </div>

        <div class="modal-footer" style="margin-top: 25px; ">  
            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center; margin-bottom: 25px;">
                <div class="btn_semi_automatic" style="display:none">
                    <?php if($alert->tasks && $alert->tasks->semi_automatic): ?>
                    <button class="button" onclick="window.location='<?php echo e(route('semi_automatic.download', $alert->tasks->semi_automatic->ref_id )); ?>'" style="margin-right: 15px;"> Download Report </button>
                    <button class="button" id="regenerate" onclick="regenerate('<?php echo e($alert->tasks->semi_automatic->id); ?>', 'semi_automatic')"> Continue Report </button>
                    <?php endif; ?>    
                </div>
                <div class="btn_fully_manual" style="display:none">
                    <?php if($alert->tasks && $alert->tasks->fully_manual): ?>
                    <button class="button" onclick="window.location='<?php echo e(route('fully_manual.download', $alert->tasks->fully_manual->ref_id )); ?>'" style="margin-right: 15px;"> Download Report </button>
                    <button class="button" id="regenerate" onclick="regenerate('<?php echo e($alert->tasks->fully_manual->id); ?>', 'fully_manual')"> Continue Report </button>
                    <?php endif; ?>   
                </div>
                <div class="btn_product" style="display:none">
                    <?php if($alert->tasks && $alert->tasks->product): ?>
                    <button class="button" onclick="window.location='<?php echo e(route('product.download', $alert->tasks->product->ref_id )); ?>'" style="margin-right: 15px;"> Download Report </button>
                    <button class="button" id="regenerate" onclick="regenerate('<?php echo e($alert->tasks->product->id); ?>', 'product')"> Continue Report </button>
                    <?php endif; ?>   
                </div>
                <div class="btn_automatic" style="display:none">
                    <?php if($alert): ?>
                    <button class="button" onclick="window.location='<?php echo e(route('alerts.download', $alert->ref_id)); ?>'" style="margin-right: 15px;"> Download Report </button>
                    <button class="button" id="regenerate" onclick="regenerate('<?php echo e($alert->id); ?>', 'automatic')"> Continue Report </button>
                    <?php endif; ?>   
                </div>
            </div> 
        </div>
    </div>
</div><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/alerts/show.blade.php ENDPATH**/ ?>