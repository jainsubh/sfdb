<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Google-Search</title>
    <?php echo $__env->make('layouts.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <style>
      #working-area{
        margin-top: 6px;
        padding: 30px;
      }
      #google-panel{
        height: 830px;
        background: #ffffff;
      }
      .library-head{
        border-bottom: 1px solid #d0c9c9;
        margin-bottom: 10px;
        height: 110px;
      }
      .library-body{
        /*width: 60%;*/
        margin: 0 auto;
        height: 655px;
        display: block;
        justify-content: center;
        float:left;
      }
      .input-group{
        position: relative;
        float: left;
        width: 100%;
      }
      .google_search{
        /*width: 50% !important;*/
        margin: 0 auto !important;
        display: flow-root;
        position: relative;
        padding: 10px;
      }
      .search_text{
        float: left;
        padding: 0.85em;
        text-align:center;
        width: 10%;
        font-weight: 700;
        background: #28ADFB;
        cursor:pointer;
        color: white;
        font-size: 14px;
        border: 1px solid #dcdcdc;
      }
      .search_box{
        width: 45% !important;
        float:left;
        border-radius: 40px;
        margin: 6px !important;
        font: 400 17px/12px"Roboto", sans-serif !important;
        border: 1px solid #dcdcdc !important;
        color: #000 !important;
        margin-left: 12px !important;
      }
      .search_box[type="text"]:focus{
        border: 1px solid #dcdcdc;
        color: #000;
        box-shadow: 1px 1px 8px 1px #dcdcdc;
        outline:none;
      }
      #search_keyword{
        font-size: 17px;
        float:left;
      }
      #search_keyword img{
        width: 125px;
      }
      .panel{
        background: none;
        border:0px;
        margin-bottom : 15px;
        font-size: 16px;
        padding: 0px;
      }
      .text{  
        color: #5f6368 !important; 
        /*font-weight: 500;*/
        padding: 0px 0px 6px 20px;
        font-size: 13px;
        display: block;
        /*border-bottom: 1px solid #0a1942;*/
      }
      .head{
        color: #DADA98;
        padding:; 0px 0px 4px 20px;
        font-weight: 400;
      }
      .description{
        font-size: 14px;
        font-weight: normal;
        width: 650px;
        /*
        padding-top: 20px;
        padding-bottom: 13px;
        */
      }
      .no-btn{
        background: #1E4E79;
        cursor: default;
      }

      .google-pagination{
        text-align:center;
      }

      .back-button{
        position: relative;
        float: right;
        padding: 2px;
        top: 0px;
        right: 0px;
      }
      .back-button a:hover {
        color:#1a0dab
      }
    
      @media  screen and (max-width: 750px)
      {
        h3 { font-size: 12px; }
      }

      #search_icon {
        all: unset;
        cursor: pointer;
        width: 44px;
        height: 44px;
      }

      #search_icon svg {
        color: #4285f4;
        fill: currentColor;
        width: 28px;
        height: 28px;
        padding: 10px;
      }

      #google_results {
        margin-left: 150px;
      }

      #google_results .title {
        color: #1a0dab !important;
        font-weight: 400;
        font-size: 20px;
      }

    </style>
  </head>
  <body>
    <div class="wrapper">
      <div class="wrap container-fluid">
        <!-- header section start -->
        <?php echo $__env->make('layouts.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- header section end -->

        <!-- alert navigation start -->
        <?php echo $__env->make('layouts.includes.alert-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- alert navigation end -->
        <section id="working-area" class="row">
          <div class="col-12 col-xs-12">
            <article id="google-panel" class="module">
              <div class="library-head">
                <div class="back-button panel-view">
                  <a href="<?php echo e(route('dashboard.index')); ?>">
                    <?php if(auth()->check() && auth()->user()->hasRole('Admin')): ?>
                      Back to Panel 
                    <?php endif; ?>
                    <?php if(auth()->check() && auth()->user()->hasRole('Manager|Analyst')): ?>
                      Back to Dashboard 
                    <?php endif; ?>
                    <i class="fa fa-share-square-o" aria-hidden="true"></i>
                  </a>
                </div>
                <!--<h3>Google Search</h3>-->
                <div class="input-group">
                  <div class="input-group-btn google_search">
                    <form action="" id="google_search_form">
                      <input type="hidden" id="google_start" name="page" value="1" />
                      <span id="search_keyword" style="padding:0.54em;"><img src="images/google.png" /></span>        
                      <input type="text" class="form-control search_box" placeholder="Google Search" id="query" name="search" value="<?php echo e($request->search); ?>">
                      <button id="search_icon"  type="submit">
                        <svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
                      </button>
                      <!--
                      <span class="input-group-btn">
                        <button class="btn btn-default search_text" style="margin-right: 5px" type="submit">Search</button>
                      </span>
                      <button class="btn btn-default search_text" id="reset" type="reset" onclick="window.location.href='<?php echo e(URL::current()); ?>'" >Reset</button>
                      -->
                    </form>
                  </div>
                </div>
              </div>

              <div class="scroll-wrapper library-body">
                <div class="scroll-inner col-12 col-xs-12" id="google_results">
                  <?php if(isset($results)): ?>
                    <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="panel module">
                          <span class="head text">
                            <?php 
                              $data = (array) $result;
                            ?> 
                            <a href="<?= $data["link"] ?>" target="_blank"><?= $data['link'] ?></a>
                          </span>
                          <span class="title text"> <a href="<?= $data["link"] ?>" target="_blank"><?= $data['title'] ?></a> </span>
                          <span class="text description"> <p><?= (isset($data["snippet"])?$data["snippet"]:'') ?></p></span>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($request->has('search') && $request->search != '' && count($paginator) > 0 && $paginator->lastPage() > 1): ?>
                      <article class="panel module google-pagination">
                        <span class="head text">
                          <a href="javascript:void(0)" onclick="search_result(this)" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">Click here to view more results </a>
                        </span>
                      </article>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          </div>
        </section>
      </div> 
    </div>

    <?php echo $__env->make('layouts.includes.footer-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('layouts.includes.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
      $(document).ready(function() {
        $(".scroll-wrapper").mCustomScrollbar();
      });

      function search_result(selector){
        var start_page = parseInt($('#google_start').val())+1;
        var last_page = parseInt(<?= (count($paginator) > 0? $paginator->lastPage(): 0) ?>);
        $.ajax({
            url: "<?php echo e(route('google_search.search_result', '')); ?>",
            type: 'GET',
            data: {'page': start_page, 'search': $('#query').val()},
            beforeSend: function(){
              $(selector).html("Loading ...");
            },
            success: function(result) {
                $(result).insertBefore($('.google-pagination'));
                $('#google_start').val(start_page)
                $(".scroll-wrapper").mCustomScrollbar("update"); 
                if(start_page == last_page){
                  $(selector).html("End Results");
                }else{
                  $(selector).html("Click here to view more results");
                }
            },
            error:function(response, error){
              toastr.error(response.responseJSON.message);
              $(selector).html("Click here to view more results");
            }


        });
      }


    </script>
  </body>
</html>
<?php /**PATH /Volumes/Data/sfdbd_new/resources/views/google_search/index.blade.php ENDPATH**/ ?>