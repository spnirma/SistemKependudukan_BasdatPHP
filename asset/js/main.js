$(document).ready( function() {

  // POPUP LOGIN/REGISTER BEHAVIOUR
  $('#tab-register-login a[href="#login"]').tab('show');
  
  $('#register-btn').click(function (e) {
    e.preventDefault()
    $('#tab-register-login a[href="#register"]').tab('show')
  });

  // SLIDERS
  $('#carousel-featured').carousel({
    interval: 3000
  });
  $('#carousel-featured,#carousel-single').on('slide.bs.carousel', function(e) {
      var from = $('.nav li.active').index();
      var next = $(e.relatedTarget);
      var to =  next.index();
      // change active class positions
      $('.carousel-tabs').find('li').removeClass('active').eq(to).addClass('active');
  });

  $('#carousel-single').carousel();

  // OPTION TO LINK
  $(".has-option-to-link").change(function () {
      if($(this).val() == 'option-to-link') {
        var url = $(".option-to-link:selected").data("url");
        window.location = url;
      }
  });

});