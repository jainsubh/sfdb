  <script type="text/javascript" src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(asset('js/jquery.mCustomScrollbar.min.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(asset('js/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(asset('js/TweenMax.min.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(asset('js/progressbar.js')); ?>"></script>
  <!-- smooth scrolling of marquee -->
  <script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.marquee.min.js')); ?>"></script>
  <script>
    //scrollbar
    (function($) {
      $('.marquee-horz').marquee({
          direction: 'left',
          speed: 50000
      });

      $('.marquee-vert').marquee({
          direction: 'up',
          speed: 50000
      });


      $(window).on("load", function() {
        $(".scroll-wrapper").mCustomScrollbar();
      });
      
    })(jQuery);
    $(document).ready(function() {
      $('#progbar01').progress_fnc();
      $('#progbar02').progress_fnc();
      $('#progbar03').progress_fnc();
      $('#progbar04').progress_fnc();
      $('#progbar05').progress_fnc();
      $('#progbar06').progress_fnc();
      $('#progbar07').progress_fnc();
      $('#progbar08').progress_fnc();
      $('#progbar09').progress_fnc();
      $('#progbar11').progress_fnc();
      $('#progbar12').progress_fnc();
      $('#progbar13').progress_fnc();
      $('#progbar14').progress_fnc();
      $('#progbar15').progress_fnc();
      $('#progbar16').progress_fnc();
      $('#progbar17').progress_fnc();
      $('#progbar18').progress_fnc();
      $('#progbar19').progress_fnc();
    });
</script><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/layouts/includes/master_footer_scripts.blade.php ENDPATH**/ ?>