<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Language Translator</title>
    @include('layouts.includes.head')
    <style>
      #working-area{
        margin-top: 6px;
        padding: 30px;
      }
      .library-head{
        margin-bottom: 20px;
        height: auto;
      }
      textarea{
          background: none;
          color: #ffff !important;
          height: 500px;;
      }
      #loading_translate{display:none}
      .panel{
        background:#1E4E79;
        border:0px;
        margin-bottom : 25px;
        font-size: 16px;
        padding: 0px;
      }
      .head{
        color: #DADA98;
      }
      .btn-delete-text {
          position: absolute;
          right: 1.5rem;
          top: 0.75rem;
          border: 0;
          background: none;
          padding: 0;
          cursor: pointer;
          color: #666;
      }
      .exchange{
        margin-top: 2px !important;
      }
      @media screen and (max-width: 750px)
      {
        h3 { font-size: 12px; }
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <div class="wrap container-fluid">
        <!-- header section start -->
        @include('layouts.includes.header')
        <!-- header section end -->

        <!-- alert navigation start -->
        @include('layouts.includes.alert-dashboard')
        <!-- alert navigation end -->
        <section id="working-area" class="row">
          
            <div class="col-12 col-xs-12">
                <article id="google-panel" class="module">
                    <div class="library-head">

                        <div class="panel-view">
                            <a href="{{ route('dashboard.index') }}">
                                @role('Admin')
                                Back to Panel 
                                @endrole
                                @role('Manager|Analyst')
                                Back to Dashboard 
                                @endrole
                                <i class="fa fa-share-square-o" aria-hidden="true"></i>
                            </a>
                        </div>

                        <h3>Translate</h3>
                        
                    </div>

                    <div id="loading_translate" class="loader">Loading...</div>

                    <div class="library-inputs">
                        <div class="row">
                            <div class="col-12 col-xs-12">
                            {{ Form::open(['method' => 'post', 'id' => 'translator']) }}
                                <div class="library-inputs">
                                    <div class="row">
                                        <div class="col-xs-6" style="width: 47.5%; margin-left:10px; margin-right: 0.5%">
                                          {!! Form::select('translateFrom',['en'=>'English', 'ar'=>'Arabic'], 'en', 
                                                [ 'id' => 'translateFrom',
                                                  'onChange' => "removeFromText()",
                                                  'required' => 'required',
                                                  'placeholder' => 'Translate From'
                                                ]) 
                                          !!}
                                          <textarea id="translateFromText" dir="auto" name="translateFromText" required></textarea>
                                        </div>

                                        <button type="button" title="exchange" onclick="exchange_lang()" class="button exchange"><i class="fa fa-exchange" aria-hidden="true"></i></button>

                                        <div class="col-xs-6" style="width: 47.5%; margin-left: 0.5%;">
                                          {!! Form::select('translateTo',['ar'=>'Arabic', 'en'=>'English'], 'ar', 
                                              [ 'id' => 'translateTo',
                                                'onChange' => "removeToText()",
                                                'required' => 'required',
                                                'placeholder' => 'Translate To'
                                              ]) 
                                          !!}
                                          <textarea id="translateToText" dir="auto" name="translateToText" value="" disabled></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="lib-actions">
                                    <div class="row">
                                        <button type="button" class="button" onclick="translateFunction()" style="margin-right: 10px; margin-left: 10px;">Translate</button>
                                        <button type="reset" class="button">Clear</button>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
      </div> 
    </div>
    @include('layouts.includes.library_footer_scripts')
  </body>

  <script>
    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 1000;  //time in ms, 5 seconds for example
    var $input = $('#translateFromText');

    //on keyup, start the countdown
    $input.on('keyup', function () {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(translateFunction, doneTypingInterval);
    });

    //on keydown, clear the countdown 
    $input.on('keydown', function () {
      clearTimeout(typingTimer);
    });


    function translateFunction(){
      $("#translator").submit(); 
    }

    function removeFromText(){
      $("#translateFromText").val(''); 
    }

    function exchange_lang(){
      $("#translateFromText").val(''); 
      $("#translateToText").val(''); 
      var selectedFromLang = $("#translateFrom").val();
      var selectedToLang = $("#translateTo").val();

      $("#translateFrom").val(selectedToLang);
      $("#translateTo").val(selectedFromLang);
    }

    function removeToText(){
      $("#translateToText").val(''); 
    }

    $(document).ready(function() {
      $("#translator").submit(function(e){
        e.preventDefault(); //STOP default action

        var abx = $.ajax({
          url: 'translation/translate',
          type: 'post',    
          headers: {
            Accept : "application/json"
          },
          data: {
              "_token": "{{ csrf_token() }}",
              "data": $(this).serialize()
          },
          beforeSend: function(){
            /*var text = $('#translateFromText').val();
            if(text == ''){
              toastr.error("Please enter Some text to translate");
              abx.abort();
            }*/
            $("#loading_translate").show();
          },
          success: function(response) {
            if(response.status === 'Success'){   
              $("#loading_translate").hide();
              $("#translateToText").val(response.data); 
              toastr.success(response.message);
            }
          },
          error: function(response){
              $("#loading_translate").hide();
              toastr.error(JSON.parse(response.responseText));
          }
        });
      });
    });
  </script>
</html>
