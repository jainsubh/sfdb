  <div id="word_definition" class="modal">
    <div class="modal-content" style="width: 800px; min-height: 400px;">
        <div class="panel-modal-head">
            <a href="javascript:void(0)" onclick="$('#word_definition').modal('hide');" class="close" aria-label="Close">&times;</a>
            <div class="panel-title">Dictionary</div>
        </div>
        
        <div class="panel-modal-content">
            <div class="meaning-container .scroll-wrapper">
            </div>
        </div>

        <div class="modal-footer" style="margin-top: 10px; ">  
            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right; margin-bottom: 12px; padding: 0 20px;">
                <div class="btn_semi_automatic">
                    <!--<button class="button" onclick="$('#word_definition').modal('hide');"> OK </button>-->
                </div>
            </div> 
        </div>
    </div>
  </div>
  <script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('assets/js/vendor/bootstrap-4.5.3.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('js/jquery.mCustomScrollbar.min.js')); ?>"></script>
  <script src="<?php echo e(asset('js/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
  <script src="<?php echo e(asset('js/TweenMax.min.js')); ?>"></script>
  <script src="<?php echo e(asset('js/text_scroller.js')); ?>"></script>
  <script src="<?php echo e(asset('js/flatpickr.js')); ?>"></script>
  <!-- Toastr Notifications -->
  <script src="<?php echo e(asset('assets/js/vendor/toastr.min.js')); ?>"></script>
  <script src="<?php echo e(asset('assets/js/toastr.script.js')); ?>"></script>
  <!-- smooth scrolling of marquee -->
  <script src="<?php echo e(asset('assets/js/jquery.marquee.min.js')); ?>"></script>
  <script>
   (function($) {
      toastr.options = {
        positionClass : 'toast-bottom-right',
      }
    })(jQuery);

    $('.marquee-horz').marquee({
          direction: 'left',
          speed: 50000
      });

  //scrollbar
  (function($) {
    $(window).on("load", function() {
      $(".scroll-wrapper").mCustomScrollbar();
    });
  })(jQuery);

  flatpickr('#from-date',{
    onChange: null
  });
  flatpickr('#to-date',{
    onChange: null
  });

  function dateToTimestamp(date){
    return new Date(date).getTime()/1000;
  }

  
  function word_definition(word){
      
      $('#word_definition').modal('show');
      var url;

      if (typeof word !== 'undefined')
        url = "<?php echo e(route('words.meaning', '')); ?>/"+word;
      else  
        url = "<?php echo e(route('words.meaning', '')); ?>/";
        
      $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function(){
          $('#word_definition .meaning-container').html('<div class="loader">Loading...</div>');
        },
        success: function(result) {
          $('#word_definition .meaning-container').html(result);
          $("#task_reminder_modal .scroll-wrapper").mCustomScrollbar();
          dictionaryFormSubmit();
        }
      });      
    }

    //Dictionary search form submit
    function dictionaryFormSubmit(){
      $('#wordForm').on('submit',function(e){
        e.preventDefault();
        word = $('#wordForm input[name=search_word]').val();
        console.log(word);
        var url;
        url = "<?php echo e(route('words.meaning', '')); ?>/"+word+"/1";

        $.ajax({
          url: url,
          type: 'GET',
          beforeSend: function(){
            $('#word_definition .meaning-container').html('<div class="loader">Loading...</div>');
          },
          success: function(result) {
            $('#word_definition .meaning-container').html(result);
            $("#task_reminder_modal .scroll-wrapper").mCustomScrollbar();
            dictionaryFormSubmit();
          }
        });
      });
    }
  </script><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/layouts/includes/library_footer_scripts.blade.php ENDPATH**/ ?>