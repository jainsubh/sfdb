var $tickerWrapper = $(".tickerwrapper");
var $list = $tickerWrapper.find("ul.list");
var $clonedList = $list.clone();
var listWidth = 100;
var rotation_range = 0.03;
var time = 100;
//TimelineMax
var infinite = new TimelineMax({repeat: -1, paused: true});

$list.find("li").each(function (i) {
			listWidth += $(this, i).outerWidth(true);
});

time = listWidth/time;

var endPos = $tickerWrapper.width() - listWidth;

$list.add($clonedList).css({
	"width" : listWidth + "px"
});

$clonedList.addClass("cloned").appendTo($tickerWrapper);

infinite
  .fromTo($list, time, {rotation:rotation_range,x:0}, {force3D:true, x: -listWidth, ease: Linear.easeNone}, 0)
  .fromTo($clonedList, time, {rotation:rotation_range, x:listWidth}, {force3D:true, x:0, ease: Linear.easeNone}, 0)
  .set($list, {force3D:true, rotation:rotation_range, x: listWidth})
  .to($clonedList, time, {force3D:true, rotation:rotation_range, x: -listWidth, ease: Linear.easeNone}, time)
  .to($list, time, {force3D:true, rotation:rotation_range, x: 0, ease: Linear.easeNone}, time)
  .progress(1).progress(0)
  .play();

//Pause/Play		
$tickerWrapper.on("mouseenter", function(){
	infinite.pause();
}).on("mouseleave", function(){
	infinite.play();
});