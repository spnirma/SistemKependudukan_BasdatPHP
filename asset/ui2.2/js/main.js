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
	  slidesToShow: 5,
	  slidesToScroll: 5,
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

(function($) {
        $(document).ready(function() {
            $("#cariproduk").attr("autocomplete", "off"), $("#cariproduk").autocomplete({
                source: base_url + "mobo/ajax_mobo/psearch",
                open: function(a, t) {
                    var r = $("#cariproduk").val().replace(/\+/g, "%2B").replace(/\s/g, "+");
                    $(".ui-autocomplete").append('<li class="ui-menu-item"><a href="' + base_url + "search/?query=" + r + '&sort=4&page=1&limit=20"><div class="list_item_container"><center><div class="label-name-resp table-cell"><i class="fa fa-search"></i> Lihat Semua Hasil Pencarian <i class="fa fa-angle-double-right"></i></div><center></div></a></li>')
                }
            }).data("ui-autocomplete")._renderItem = function(a, t) {
                var r = '<a href="' + t.link + '"><div class="list_item_container"><div class="image"><img src="' + t.image + '"></div><div class="label-name">' + t.label + "</div></div></a>";
                return $("<li></li>").data("item.autocomplete", t).append(r).appendTo(a);
            }
        });
}) (jQuery);
