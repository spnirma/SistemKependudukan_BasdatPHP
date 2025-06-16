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
	  slidesToScroll: 4
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
