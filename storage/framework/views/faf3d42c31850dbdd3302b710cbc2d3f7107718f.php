<style>
    #header .clock-holder {
    display: -webkit-flex;
    display: flex;
    -webkit-justify-content: center;
    justify-content: center;
}
.logged_in{
   text-align: right;
   z-index: 999;
   margin-top:3.3%;
   position: relative;
}

a {color:inherit;}

.dropdown_item {
  float: right;
  text-align: center;
  display: none;
  padding-top: 3px;
  width: 130px;
}
.dropdown_item li{
  background: white;
  padding: 5px;
  font-size: 18px;
}
.dropdown_item a{
  width: 130px;
}
.dropdown{
  background: white; 
  
}
.dropdown_item li:hover{
  background: #e6e3e8; 
}
</style>
<header id="header" class="row">
  <div class="col-3 col-lg-5 col-md-5 col-sm-12 col-xs-12">
    <h1><?php echo e($name); ?></h1>
  </div>
  <div class="col-6 col-lg-7 col-md-7 col-sm-12 col-xs-12">
    <div class="clock-holder">
      <div class="clock">
        <div class="clock-no" data-timezone="America/Los_Angeles">19:59</div>
        <div class="clock-txt">Los Angeles</div>
      </div>
      <div class="clock">
        <div class="clock-no" data-timezone="America/New_York">22:59</div>
        <div class="clock-txt">New York</div>
      </div>
      <div class="clock">
        <div class="clock-no" data-timezone="Europe/London">03:59</div>
        <div class="clock-txt">London</div>
      </div>
      <div class="clock">
        <div class="clock-no" data-timezone="Asia/Dubai">07:59</div>
        <div class="clock-txt" >Dubai</div>
      </div>
      <div class="clock">
        <div class="clock-no" data-timezone="Asia/Tokyo">11:59</div>
        <div class="clock-txt">Tokyo</div>
      </div>
    </div>
  </div>
  <div class="col-3 col-lg-5 col-md-5 col-sm-12 col-xs-12">
    <div class="logged_in">
      
      <h3 style="width: 400px; float: right; margin-top: 5px;"> 
        <img src="/images/dictionary.png" alt="dictionary" class="icon" style="width: 40px; height: 40px; cursor: pointer" onclick="word_definition()">
        <?php echo e(auth()->user()->name); ?> &nbsp;
        <a href="javascript:void(0)" onclick="dropdown()" id="dropdown_box" style="padding: 4px;">
          <i class="fa fa-caret-down" aria-hidden="true"></i>
        </a><br>
        <ul class="dropdown_item">
          <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
            <li>
              Logout 
            </li>
          </a>
          <form id="logout-form-header" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
              <?php echo csrf_field(); ?>
          </form>
        </ul>
      </h3>
     
    </div>
  </div>
</header>
<script>
  
const clocks = document.getElementsByClassName("clock-no");
function updateClocks() {
  for (let clock of clocks) {
    let timezone = clock.dataset.timezone;
    let time = new Date().toLocaleTimeString("en-GB", {
      hour: '2-digit',
      minute:'2-digit',
      second:'2-digit',
      timeZone: timezone
    });
    clock.textContent = time;
  }
}

// Update every minute:
setInterval(updateClocks, 1000);
updateClocks();

function dropdown(){
   
    if($(".dropdown_item").is(":visible")){
      $("#dropdown_box").removeClass('dropdown');
      $(".dropdown_item").hide();
    }else{
      $("#dropdown_box").addClass('dropdown');
      $(".dropdown_item").show();
    }
}
</script><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/layouts/includes/header.blade.php ENDPATH**/ ?>