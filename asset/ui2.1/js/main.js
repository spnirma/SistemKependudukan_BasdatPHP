$(document).ready(function(){

	$('.carousel').slick({
	  dots: true,
	  arrows: false,
	  autoplay: true,
	  autoplaySpeed: 2000
	});

	$('.carousel1').slick({
	  touchMove: false,
	  infinite: false,
	  slidesToShow: 4,
	  slidesToScroll: 4,
              responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                  }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
              ]
	});
});

$('#collapseOne').on('shown', function(){
    $('#transferselect1').prop('checked', true);
});

$('#collapseTwo').on('shown', function(){
    $('#transferselect2').prop('checked', true);
});

$('#collapseThree').on('shown', function(){
    $('#transferselect3').prop('checked', true);
});

$('#collapseThree').on('shown', function(){
    $('#transferselect4').prop('checked', true);
});

$("#totop").click(function () {
   $("html, body").animate({scrollTop: 0}, 500);
});

$("#totop-responsive").click(function () {
   $("html, body").animate({scrollTop: 0}, 500);
});

(function ($) {
  $('#pdesc a:first').tab('show');

  $('.spinner .btn:first-of-type').on('click', function() {
    $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
  });
  $('.spinner .btn:last-of-type').on('click', function() {
    $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
  });
})(jQuery);