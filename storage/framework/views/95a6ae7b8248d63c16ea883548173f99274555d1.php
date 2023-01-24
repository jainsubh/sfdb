<?php $__env->startSection('before-css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/editor/codemirror.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/sweet-modal/dist/min/jquery.sweet-modal.min.css')); ?>">
    <style type=text/css>
      .CodeMirror {
        float: left;
        width: 100%;
        border: 1px solid black;
        height: 700px;
        text-align:left;
        margin-bottom: 20px;
      }
      iframe {
        width: 100%;
        float: left;
        height: 400px;
        border: 1px solid black;
        border-left: 0px;
      }
      .sweet-modal-box{
        width: 100% !important;
        margin-top: 0px !important;
        margin-bottom: 0px !important;
        left: 0% !important;
        top: 0% !important;
      }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    <div class="breadcrumb">
        <h1><?php echo e($report_template->name); ?> Report Template</h1>
        <ul>
            <li><a href="<?php echo e(route('report_template.index')); ?>">Report Template</a></li>
            <li>Edit</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">
     
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="mx-auto col-md-12">
                        <?php echo e(Form::model($report_template, ['route' => ['report_template.update', $report_template->id], 'method' => 'patch', 'id' => 'report_template'])); ?>

                          <textarea id="code" name="code"><?php echo e($html_template); ?></textarea>
                          <?php echo e(Form::hidden('type', $report_template->type)); ?>                            
                        
                          <button id="previwTemplate" type="submit" class="btn btn-primary ladda-button example-button" href="#">Save and Preview</button>
                        <?php echo e(Form::close()); ?>

                       
                    </div>
                </div>
            </div>
        </div>
        <iframe id="grabCode" title="grabCode" style="display: none">

        </iframe>
        <!-- end of col -->
    </div>
    <!-- end of row -->
<?php $__env->stopSection(); ?>
        
        
<?php $__env->startSection('page-js'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>
<script src="<?php echo e(asset('assets/js/toastr.script.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/vendor/sweetalert2.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/CodeMirror/lib/codemirror.js' )); ?>"></script>
<script src="<?php echo e(asset('assets/CodeMirror/addon/edit/matchbrackets.js')); ?>"></script>
<script src="<?php echo e(asset('assets/CodeMirror/mode/htmlmixed/htmlmixed.js')); ?>"></script>
<script src="<?php echo e(asset('assets/CodeMirror/mode/xml/xml.js')); ?>"></script>
<script src="<?php echo e(asset('assets/CodeMirror/mode/javascript/javascript.js')); ?>"></script>
<script src="<?php echo e(asset('assets/CodeMirror/mode/css/css.js')); ?>"></script>
<script src="<?php echo e(asset('assets/CodeMirror/mode/clike/clike.js')); ?>"></script>
<script src="<?php echo e(asset('assets/CodeMirror/mode/php/php.js')); ?>"></script>
<script src="<?php echo e(asset('assets/sweet-modal/dist/min/jquery.sweet-modal.min.js')); ?>"></script>

<script>
  var delay;
  // Initialize CodeMirror editor with a nice html5 canvas demo.
  var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    lineNumbers: true,
    matchBrackets: true,
    mode: "application/x-httpd-php",
    indentUnit: 4,
    indentWithTabs: true,
  });

  $('#report_template').on('submit',function(event){
    event.preventDefault();
    $.ajax({
      url: $(this).attr('action'),
      type:"POST",
      data: $(this).serialize(),
      success:function(response){
        if(response.status == 'success'){
          Ladda.stopAll();
          renderHTML();
          $.sweetModal({
            title: 'Preview of Report',
            content: $('#grabCode').html()
          });
          toastr.success(response.message);
        }
      },
      error:function(response, error){
        toastr.error(JSON.parse(response.responseText));
      }
    });
  });

  function renderHTML(){
    $.ajax({
      url: "<?php echo e(route('report_template.show', $report_template->id)); ?>",
      type: 'GET',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      async: false,
      success:function(response){ 
        $('#grabCode').html(response);
      }
    })
  }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/report_template/edit.blade.php ENDPATH**/ ?>