(function($) {
    $(document).ready(function() {
        //$.slidebars();
        
        $(".sb-toggle-left").click(function(){
            $("#sb-site").css('position','fixed');
            $("#sb-site").css('z-index','1001');
        });
        
        $("#sb-site").click(function(){
            $("#sb-site").css('position','none');
            $("#sb-site").css('z-index','1');
        });
    });
}) (jQuery),

// NAVBAR SCROLL OFF
// $(document).ready(function () {
//     $('#navbar-scroll').hide();
//     $(window).bind('scroll', function () {
// //                    var navHeight = $(window).height() - 10;
//         if ($(window).scrollTop() > 90) {
// //                        $('#navbar-secondary').addClass('fixed');
// //                        $('#navbar-main').addClass('fixed');
// //                        $('#navbar-secondary').addClass('fixedSecondary');
//             $('#navbar-scroll').show();
//             $('#navbar-scroll').addClass('fixedScroll');
//             $('#nav-responsive').addClass('fixed');
//             $('.floating-banner-kiri').addClass('floating-banner-fixed');
//             $('.floating-banner-kanan').addClass('floating-banner-fixed');
//         } else {
// //                        $('#navbar-seconday').removeClass('fixed');
// //                        $('#navbar-secondary').removeClass('fixedSecondary');
//             $('#navbar-scroll').removeClass('fixedScroll');
//             $('#navbar-scroll').hide();
//             $('#nav-responsive').removeClass('fixed');
//             $('.floating-banner-kiri').removeClass('floating-banner-fixed');
//             $('.floating-banner-kanan').removeClass('floating-banner-fixed');
//         }
//     });
// });


(function ($) {
    $(document).ready(function () {
        $.slidebars();
    });
})(jQuery),

$(function () {
    $('a[href="#"]').on('click', function (e) {
        e.preventDefault();
    });

    $('#menu > li').on('mouseover', function (e) {
        $(this).find("ul:first").show();
        $(this).find('> a').addClass('active');
    }).on('mouseout', function (e) {
        $(this).find("ul:first").hide();
        $(this).find('> a').removeClass('active');
    });

    $('#menu li li').on('mouseover', function (e) {
        if ($(this).has('ul').length) {
            $(this).parent().addClass('expanded');
        }
        $('ul:first', this).parent().find('> a').addClass('active');
        $('ul:first', this).show();
    }).on('mouseout', function (e) {
        $(this).parent().removeClass('expanded');
        $('ul:first', this).parent().find('> a').removeClass('active');
        $('ul:first', this).hide();
    });

    $('#search > li').on('mouseover', function (e) {
        $(this).find("ul:first").show();
        $(this).find('> a').addClass('active');
    }).on('mouseout', function (e) {
        $(this).find("ul:first").hide();
        $(this).find('> a').removeClass('active');
    });

    $('#search li li').on('mouseover', function (e) {
        if ($(this).has('ul').length) {
            $(this).parent().addClass('expanded');
        }
        $('ul:first', this).parent().find('> a').addClass('active');
        $('ul:first', this).show();
    }).on('mouseout', function (e) {
        $(this).parent().removeClass('expanded');
        $('ul:first', this).parent().find('> a').removeClass('active');
        $('ul:first', this).hide();
    });
}),


function(e) {
        e(document).ready(function() {
            e("#cariproduk,#cariproduk-resp").attr("autocomplete", "off"), e("#cariproduk").autocomplete({
                source: base_url + "mobo/ajax_mobo/psearch",
                open: function(a, t) {
                    var r = e("#cariproduk").val().replace(/\+/g, "%2B").replace(/\s/g, "+");
                    e(".ui-autocomplete").append('<li class="ui-menu-item"><a href="' + base_url + "search/?query=" + r + '&sort=4&page=1&limit=20"><div class="list_item_container"><center><div class="label-name-resp table-cell"><i class="fa fa-search"></i> Lihat Semua Hasil Pencarian <i class="fa fa-angle-double-right"></i></div><center></div></a></li>')
                }
            }).data("ui-autocomplete")._renderItem = function(a, t) {
                var r = '<a href="' + t.link + '"><div class="list_item_container"><div class="image"><img src="' + t.image + '"></div><div class="label-name">' + t.label + "</div></div></a>";
                return e("<li></li>").data("item.autocomplete", t).append(r).appendTo(a)
            }, e("#cariproduk-resp").autocomplete({
                source: base_url + "mobo/ajax_mobo/psearch",
                open: function(a, t) {
                    alert('bb');
                    var r = e("#cariproduk-resp").val().replace(/\+/g, "%2B").replace(/\s/g, "+");
                    e(".ui-autocomplete").append('<li class="ui-menu-item"><a href="' + base_url + "search/?query=" + r + '&sort=4&page=1&limit=20"><div class="list_item_container"><center><div class="label-name-resp table-cell"><i class="fa fa-search"></i> Lihat Semua Hasil Pencarian <i class="fa fa-angle-double-right"></i></div><center></div></a></li>')
                }
            }).data("ui-autocomplete")._renderItem = function(a, t) {
                var r = '<a href="' + t.link + '"><div class="list_item_container"><div class="label-name-resp">' + t.label + "</div></div></a>";
                return e("<li></li>").data("item.autocomplete", t).append(r).appendTo(a)
            }
        })
    }(jQuery);

/* =======

(function($) {
    $(document).ready(function() {

        $('#cariproduk-resp').attr('autocomplete', 'off');
        $('#cariproduk-resp').autocomplete({
            source: base_url + "ajax/psearch",
            open: function(event, ui) {
                var q = $('#cariproduk-resp').val().replace(/\+/g,"%2B").replace(/\s/g,'+');
                $('.ui-autocomplete').append('<li class="ui-menu-item"><a href="' + base_url + 'search/?query='
                                                + q +
                                             '"><div class="list_item_container"><center><div class="label-name-resp table-cell"><i class="fa fa-search"></i> Lihat Semua Hasil Pencarian <i class="fa fa-angle-double-right"></i></div><center></div></a></li>');
=======

function(e) {
        e(document).ready(function() {
            e("#cariproduk,#cariproduk-resp").attr("autocomplete", "off"), e("#cariproduk").autocomplete({
                source: base_url + "mobo/ajax_mobo/psearch",
                open: function(a, t) {
                    var r = e("#cariproduk").val().replace(/\+/g, "%2B").replace(/\s/g, "+");
                    e(".ui-autocomplete").append('<li class="ui-menu-item"><a href="' + base_url + "search/?query=" + r + '&sort=4&page=1&limit=20"><div class="list_item_container"><center><div class="label-name-resp table-cell"><i class="fa fa-search"></i> Lihat Semua Hasil Pencarian <i class="fa fa-angle-double-right"></i></div><center></div></a></li>')
                }
            }).data("ui-autocomplete")._renderItem = function(a, t) {
                var r = '<a href="' + t.link + '"><div class="list_item_container"><div class="image"><img src="' + t.image + '"></div><div class="label-name">' + t.label + "</div></div></a>";
                return e("<li></li>").data("item.autocomplete", t).append(r).appendTo(a)
            }, e("#cariproduk-resp").autocomplete({
                source: base_url + "mobo/ajax_mobo/psearch",
                open: function(a, t) {
                    alert('bb');
                    var r = e("#cariproduk-resp").val().replace(/\+/g, "%2B").replace(/\s/g, "+");
                    e(".ui-autocomplete").append('<li class="ui-menu-item"><a href="' + base_url + "search/?query=" + r + '&sort=4&page=1&limit=20"><div class="list_item_container"><center><div class="label-name-resp table-cell"><i class="fa fa-search"></i> Lihat Semua Hasil Pencarian <i class="fa fa-angle-double-right"></i></div><center></div></a></li>')
                }
            }).data("ui-autocomplete")._renderItem = function(a, t) {
                var r = '<a href="' + t.link + '"><div class="list_item_container"><div class="label-name-resp">' + t.label + "</div></div></a>";
                return e("<li></li>").data("item.autocomplete", t).append(r).appendTo(a)
>>>>>>> add logic searching on page mobo
            }
        })
    }(jQuery);

>>>>>>> change branch
*/

var frm = $('#form-login');
        frm.submit(function (ev) {
            //$(".login_error").empty();
            //$(".login_error").append("<p></p>");
            $(".login_error").empty();
            $(".login_error").append("<p><img src='../asset/img/loader-lite.gif'></p>");
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                dataType: 'json',
                beforeSend: function () {
                },
                success: function (data) {
                    if(data.status==0){
                        $(".login_error").empty();
                        $(".login_error").append("<p>" + data.message + "</p>");
                        $(".login_error").empty();
                        $(".login_error").append("<p>" + data.message + "</p>");
                    } else if(data.status==1){
                        if(data.session == 'member'){
                          document.location = window.location.href;
                        } else if (data.session == 'merchant_id_user') {
                            document.location = base_url + 'merchant/update_jasa_pengiriman';
                        } else if(data.session == 'partner'){
                          document.location = base_url + 'partner/agregator/orders';
                        }
                    }
                }
            });

            ev.preventDefault();
        });

                var frmreg = $('#form-reg');
                frmreg.submit(function (ev) {
                    $.ajax({
                        type: frmreg.attr('method'),
                        url: frmreg.attr('action'),
                        data: frmreg.serialize(),
                        dataType: 'json',
                        beforeSend: function () {
                            $('.register-submit').val('Please wait ...');
                            $('#registrasi_error').css('display','none');
                        },
                        success: function (data) {
                            $('.register-submit').val('Daftar');
                            if(data.status==0){
                                $("#recaptcha_reload").click();
                                $(".reg_error").empty();
                                $(".reg_error").append("<p>" + data.message + "</p>");
                                $('#registrasi_error').css('display','');

                            } else if(data.status==1){
                                document.location = data.message;
                            }
                        }
                    });

                    ev.preventDefault();
                });

                $(document).on('click', '.product-thumb-love', function(e) {
                    e.preventDefault();
                    
                    var $productTile = $(this).parents('.product-tile');
                    var productId = $productTile.attr('data-product-id');
                    var $this = $(this);

                    $.ajax({
                        url: base_url + "ajax/love",
                        method: "POST",
                        data: {id: productId},
                        dataType: "json",
                        success: function(str) {
                            // alert('ok');
                            if (str.status=='success') {
                                var $loveCount = $this.children('.love-count');
                                if (str.value == '+1') {
                                    loveValue = parseInt($(".love-value-"+productId).html()) + 1;
                                    $(".love-value-"+productId).html(loveValue);
                                    $this.addClass('user-loved');
                                } else if (str.value == '-1') {
                                    loveValue = parseInt($(".love-value-"+productId).html()) - 1;
                                    $(".love-value-"+productId).html(loveValue);
                                    $this.removeClass('user-loved');
                                }
                            }
                        }
                    })
                });

                $(document).on('click', '.btn-follow', function(e) {
                    e.preventDefault();
                    
                    var userId = $('.user-overview').attr('data-user-id');
                    var $this = $(this);

                    $.ajax({
                        url: base_url + "ajax/follow",
                        method: "POST",
                        data: {'id_user': userId},
                        dataType: "json",
                        success: function(str) {
                            if (str.status && str.status == 1) {
                                $this.removeClass('btn-warning');
                                $this.removeClass('btn-follow');
                                $this.addClass('btn-unfollow');
                                $this.addClass('btn-primary');
                                $this.html('Unfollow');
                                $('.count-follower').html(parseInt($('.count-follower').html())+1);
                            }
                        }
                    });
                });

                $(document).on('click', '.btn-unfollow', function(e) {
                    e.preventDefault();
                    
                    var userId = $('.user-overview').attr('data-user-id');
                    var $this = $(this);

                    $.ajax({
                        url: base_url + "ajax/unfollow",
                        method: "POST",
                        data: {'id_user': userId},
                        dataType: "json",
                        success: function(str) {
                            if (str.status && str.status == 1) {
                                $this.removeClass('btn-primary');
                                $this.removeClass('btn-unfollow');
                                $this.addClass('btn-follow');
                                $this.addClass('btn-warning');
                                $this.html('Follow');
                                $('.count-follower').html(parseInt($('.count-follower').html())-1);
                            }
                        }
                    });
                });
//cek number field
  function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if ((charCode > 47 && charCode < 58 ) || charCode == 44 || charCode == 46 || charCode == 8)
        return true;

     return false;
     // alert(charCode);
  }
    
    $(".mega-menu-triger").hover(function(){
        $(".mega-header-modal").show();
    },function(){
        $(".mega-header-modal").hide();
    });
    
    /*
    $(".user-angle").click(function(){
        $(".menu-member-area").toggle();
        $(".angle").toggle();
    });
    
    $(".user-angle-red").click(function(){
        $(".menu-member-area-red").toggle();
        $(".angle").toggle();
    });
    */
    
    $( ".login-white-header, .menu-member-area" ).hover(
      function() {
        $(".menu-member-area").show();
        $(".angle-up").show();
        $(".angle-down").hide();
      }, function() {
        $(".menu-member-area").delay(500).hide();
        $(".angle-up").delay(500).hide();
        $(".angle-down").delay(500).show();
      }
    );
    
    $( ".login-red-header, .menu-member-area-red" ).hover(
      function() {
        $(".menu-member-area-red").show();
        $(".angle-up").show();
        $(".angle-down").hide();
      }, function() {
        $(".menu-member-area-red").delay(500).hide();
        $(".angle-up").delay(500).hide();
        $(".angle-down").delay(500).show();
      }
    );

    $(document).click(function(even){
        console.log(even);
    });

    $(".berat-alert").blur(function(){
        var berat = $(".berat-alert").val();
        if (parseInt(berat) >= 10) {
            alert("Berat barang melebihi 10kg apakah anda yakin?");
        }
    });

var frm_wl = $('#form-login-wl');
        frm_wl.submit(function (ev) {
            $(".login_error").empty();
            $(".login_error").append("<p><img src='../asset/img/loader-lite.gif'></p>");
            $.ajax({
                type: frm_wl.attr('method'),
                url: frm_wl.attr('action'),
                data: frm_wl.serialize(),
                dataType: 'json',
                beforeSend: function () {
                },
                success: function (data) {
                    if(data.status==0){
                        $(".login_error").empty();
                        $(".login_error").append("<p>" + data.message + "</p>");
                        $(".login_error").empty();
                        $(".login_error").append("<p>" + data.message + "</p>");
                    } else if(data.status==1){
                        var vRedirect='persib'; 
                        if (data.redirect!='') { vRedirect=data.redirect; }
                        if (data.session == 'member'){
                          document.location = base_url + vRedirect;
                        }
                        else if(data.session == 'partner'){
                          document.location = base_url + vRedirect;
                        }
                    }
                }
            });

            ev.preventDefault();
        });
    
    