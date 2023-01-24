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

<script src="{{asset('js/jquery-3.5.1.min.js') }}" type="text/javascript"></script>
<script src="{{asset('assets/js/vendor/bootstrap-4.5.3.min.js') }}" type="text/javascript"></script>
<script src="{{asset('js/jquery.mCustomScrollbar.min.js') }}" type="text/javascript"></script>
<script src="{{asset('js/jquery.mCustomScrollbar.concat.min.js') }}" type="text/javascript"></script>
<script src="{{asset('js/TweenMax.min.js') }}" type="text/javascript"></script>
<script src="{{asset('js/text_scroller.js') }}" type="text/javascript"></script>
<script src="{{asset('js/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{asset('js/simple-lightbox.jquery.min.js') }}" type="text/javascript"></script>
<script src="{{asset('js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{asset('js/tavo-calendar.js') }}" type="text/javascript"></script>
<script src="{{asset('js/flatpickr.js') }}" type="text/javascript"></script>
<!-- Toastr Notification scripts -->
<script src="{{asset('assets/js/vendor/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/toastr.script.js')}}"></script>
<!-- Ladda Buttons Scripts -->
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<!-- smooth scrolling of marquee -->
<script src="{{asset('assets/js/jquery.marquee.min.js')}}"></script>
<!-- confirm popup -->
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script src="{{asset('js/onScroll_load.min.js') }}" type="text/javascript"></script>

  <script>
    //scrollbar
    (function($) {
      toastr.options = {
        positionClass : 'toast-bottom-right',
      }
    })(jQuery);

    

    $('.marquee-horz').marquee({
          direction: 'left',
          speed: 50000
      });

    function dateToTimestamp(date){
      return new Date(date).getTime()/1000;
    }

    function ladda(){
      $('.example-button').on('click', function(e) {
        $('form').submit(function (event) {
          var laddaBtn = e.currentTarget;
          var l = Ladda.create(laddaBtn);
          // Start loading
          l.start();
          $(".ladda-spinner div").addClass("ladda_progress_bar");
          // Will display a progress bar for 50% of the button width
          l.setProgress(0.5);

        });
      });
    }

    function word_definition(word){
      
      $('#word_definition').modal('show');
      var url;

      if (typeof word !== 'undefined')
        url = "{{route('words.meaning', '') }}/"+word;
      else  
        url = "{{route('words.meaning', '') }}/";
        
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
        url = "{{route('words.meaning', '') }}/"+word+"/1";

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
  </script>