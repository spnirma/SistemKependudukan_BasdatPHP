(function($) {
    $(document).ready(function() {
        $.slidebars();
        
        $(".sb-toggle-left").click(function(){
            $("#sb-site").css('position','fixed');
            $("#sb-site").css('z-index','1001');
        });
        
        $("#sb-site").click(function(){
            $("#sb-site").css('position','none');
            $("#sb-site").css('z-index','1');
        });
    });
}) (jQuery);

var frm = $('#form-login');
        frm.submit(function (ev) {
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
                        }
                        else if(data.session == 'partner'){
                          document.location = base_url + 'partner/indoloka/orders';
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
                            $('.register-submit').val('Mengirim ...');
                        },
                        success: function (data) {
                            $('.register-submit').val('Daftar');
                            if(data.status==0){
                                $("#recaptcha_reload").click();
                                $(".reg_error").empty();
                                $(".reg_error").append("<p>" + data.message + "</p>");

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

  
