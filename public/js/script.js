//reduce menu size
$(function() {
    var header = $("#header");
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 120) {
            header.addClass("smaller");
        } else {
            header.removeClass("smaller");
        }
    });
});

$(document).ready(function () {
  $(".scroll").click(function () {
    var h = $(this).attr("href");
    var o = $(h);
    return $("html, body").animate({
      scrollTop: o.offset().top - 90
    }, 2000);
  })
});

$(document).ready(function () {
  $(".scroll").click(function () {
    $("#toggle").prop("checked", false);
  })
});

