$(document).ready(function() {
	/**
	$(".product-item").hover(function() {
		$(this).find(".panel-installment").slideToggle("fast", "linear");
	});

	$(".product-item-flat").hover(function() {
		// $(this).addClass("animated pulse");
		$(this).find(".panel-installment").slideToggle("fast", "linear");
	});
	*/

	$(document).on('hover', '.yamm .dropdown-menu', function(e) {
  		e.stopPropagation()
	});

	$(".branded-banner").mouseenter(function() {
		// $(this).addClass("animated bounce");
		$(this).addClass("animate-left");
	});

	$(".branded-banner").mouseleave(function() {
		// $(this).removeClass("animated bounce");
		$(this).removeClass("animate-left");
	});

	$(".branded-cell-top").mouseenter(function() {
		// $(this).addClass("animated bounce");
		$(this).addClass("animate-left");
	});

	$(".branded-cell-top").mouseleave(function() {
		// $(this).removeClass("animated bounce");
		$(this).removeClass("animate-left");
	});

	$(".branded-cell").mouseenter(function() {
		// $(this).addClass("animated bounce");
		$(this).addClass("animate-left-underlined");
	});

	$(".branded-cell").mouseleave(function() {
		// $(this).removeClass("animated bounce");
		$(this).removeClass("animate-left-underlined");
	});

	// $("#nav-drop-store").hover(function() {
	// 	$("#nav-drop-store-menu").css("display":"block", "opacity":"1"),
	// 	function() {
	// 		$("#nav-drop-store-menu").css("display":"block", "opacity":"0");
	// 	});
	// });

	// $("#nav-drop-store").hover(function() {
	// 	$("#nav-drop-store-content").toggle();
	// });

	// $("#nav-drop-store").mouseenter(function() {
	// 	$("#nav-drop-store-content").show();
	// });

	// $("#nav-drop-store").mouseleave(function() {
	// 	$("#nav-drop-store-content").hide();
	// });

	// $(function(){
	//   var $menu = $('.dropdown-menu');

	//   $('.dropdown-toggle').hover(
	//     function() {
	//       $menu.css('opacity',1);
	//     },
	//     function() {
	//       $menu.css('opacity',0);
	//     });
	// })();

	// $("#nav-drop-store").hover(function() {
	// 	$("#nav-drop-store-menu").css({"display":"block", "opacity":"1"}, 
	// 		function() {$("#nav-drop-store-menu").css({"display":"block", "opacity":"0"});
	// 	});
	// });

	$('[data-toggle="tooltip"]').tooltip();

	// $('#rwCarousel.carousel').slick({
	//   dots: false,
	//   arrows: false,
	//   autoplay: true,
	//   autoplaySpeed: 5000
	// });

	// $('.float-button a').on('click', function(event) {
	// 	if (this.hash !== "") {
	// 		event.preventDefault();

	// 		var hash = this.hash;

	// 		$('html, body').animate({
	// 			scrollTop: $(hash).offset().top
	// 		}, 900, function() {
	// 			window.location.hash = hash;
	// 			});
	// 	}
	// });

	$('.rw-carousel').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 5000
    });

    $('.rg-carousel').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 6000
    });

    $('.rb-carousel').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 5000
    });

    $('.rh-carousel').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 6000
    });

    $('.ro-carousel').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 5000
    });

    $('.rl-carousel').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 6000
    });
    
	$("img.lazy").lazyload();
});

$(window).scroll(function() {
	if ($(document).scrollTop() > 50) {
		// $('span.slogan').css('font-size', '10px');

		// $('.navbar-top').css('height', '0px');
		$('.navbar-top').css('display', 'none');

		// $('#user-panel-xs').css('display', 'none');
		// $('#user-panel-xs').addClass('covert');
	} else {
		// $('span.slogan').css('font-size', '12px');

		// $('.navbar-top').css('height', '20px');
		$('.navbar-top')
			.css('display', 'block')
			.addClass('hidden-xs hidden-sm');
			
		// $('#user-panel-xs')
		// 	.css('display', 'block');
	}
});
