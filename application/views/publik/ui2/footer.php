<footer id="foot">
          <div class="container">
            <div class="row">
                <div class="col-xs-2">
                    <h6>Pertanyaan</h6>
                    <ul>
                        <li><a href="<?=base_url()?>page/index/7/FAQ">FAQ</a></li>
                        <!-- <li><a href="#">Cara Pembayaran</a></li> -->
                        <li><a href="<?=base_url()?>page/index/2/Tips-Pembayaran-Aman">Tips Pembayaran Aman</a></li>
                        <li><a href="<?=base_url()?>page/index/5/Cara-Bergabung">Cara Bergabung</a></li>
                    </ul>
                </div>
                <div class="col-xs-2">
                    <h6>Informasi</h6>
                    <ul>
                        <li><a href="<?=base_url()?>page/index/1/Tentang-Kami">Tentang Kami</a></li>
                        <li><a href="<?=base_url()?>page/index/8/Syarat-dan-Ketentuan-">Syarat &amp; Ketentuan</a></li>
                        <!-- <li><a href="#">Corporate Sales</a></li> -->
                    </ul>
                </div>
                <div class="col-xs-2">
                    <h6>Follow Us</h6>
                    <ul class="socmed">
                        <li><a target="_blank" href="https://www.facebook.com/pages/Cipika-Store/466418886820641"><img alt="Facebook" src="<?=base_url()?>asset/img/facebook.png" class="social-media-btn"></a></li>
                        <li><a target="_blank" href="https://twitter.com/Cipika_ID"><img alt="Twitter" src="<?=base_url()?>asset/img/twitter.png" class="social-media-btn"></a></li>
                        <!-- <li><a href="#"><img alt="Google+" src="<?=base_url()?>asset/ui2/img/icon-g.png"></a></li> -->
                    </ul>
                </div>
                <div class="col-xs-3">
                    <h6>Customers Service</h6>
                    <ul>
                        <li><a href="<?=base_url()?>contact-us">Hubungi Kami</a></li>
                        <li style="clear: left"><a target="_blank" href="https://twitter.com/ECareCipika">Twitter ECareCipika</a></li>
                        <!-- <li><a href="#">Bergabung dengan Kami</a></li> -->
                    </ul>
                </div>
                <div class="col-xs-3">
                <?php 
                    if (MERCHANT) {  
                    if ($this->session->userdata('member')) {
                      $member_footer = $this->user_m->get_single('tbl_user','id_user',$this->session->userdata('member')->id_user);                   
                          $stat_merchant = $this->commonlib->check_merchant($this->session->userdata('member')->id_user, $member_footer->id_level);
                          if(!$stat_merchant) { ?>
                        <a class="link" href="<?=base_url('merchant/register');?>">
                        <button class="btn btn-warning btn-lg">Daftar menjadi Merchant</button>
                        </a>
                    <?php } }else{ ?>
                        <a href="<?=base_url()?>page/index/<?=$this->config->item('page_register_merchant').'/Register-Merchant';?>">
                        <button class="btn btn-warning btn-lg">Daftar menjadi Merchant</button>
                        </a>
                    <?php } } ?>
                    </a>
                </div>
                <!--
                <div class="col-xs-4">
                    <h6>Newsletter</h6>
                    <form>
                        <p>Daftarkan dan dapatkan Voucher Rp 100.000</p>
                        <input class="form-control" type="email" placeholder="Email Anda">
                        <div class="form-inline row">
                            <div class="col-xs-6">
                                <button type="submit" class="btn form-control btn subscribe">Pria</button>
                            </div>
                            <div class="col-xs-6">
                                <button type="submit" class="btn form-control btn subscribe">Wanita</button>
                            </div>
                        </div>
                    </form>
                </div>
                -->
            </div>

            <div class="copyright">
                <p>www.cipika.co.id. 2015 Indosat Ooredoo. All rights reserved</p>
            </div>
            
          </div>
        </footer>
            <div id="register-login-form" class="modal fade">
              <?php
                $facebook = $this->lib_facebook->connect();
              ?>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <ul id="tab-register-login" class="nav nav-tabs">
                    <li class="nav_login active"><a href="#login" data-toggle="tab">Masuk</a></li>
                    <li class="nav_register"><a href="#register" data-toggle="tab">Daftar</a></li>
                  </ul>
                </div>
                <div class="tab-content">
                  <div class="tab-pane active" id="login">
                    <div class="modal-body">           
                      <div class="with-facebook">
                        <a href="<?=$facebook['loginUrl']?>" class="fb-login-button btn btn-lg btn-facebook blocken"><i class="shoopicon-facebook"></i> Masuk dengan Facebook</a> 
                      </div>
                      <p class="line-sparator">
                        <span class="sparator-inner">atau masuk dengan email</span>
                      </p>
                      <form id="form-login" class="form" method="post" action="<?php echo $this->config->item('secure_base_url');?>auth/login"> <!-- login form -->
                        <div class="login_error" style="color:red;"></div>
                        <div class="account-form">
                          <p><input name="email" class="form-control auth" type="text" placeholder="Email"></p>
                          <p><input name="password" autocomplete="off" class="form-control auth" type="password" placeholder="Password"></p>
                          <input type="hidden" name="csrf_token" value="<?php echo time() ?>" />
                        </div>
                        <div class="submit-box">
                          <p><input type="submit" class="btn btn-lg btn-primary form-control auth-btn" value="Masuk" /></p>
                          <p><a href="<?=base_url()?>auth/forgot_password">Lupa password?</a></p>
                        </div>
                      </form>


                    </div>
                  </div>
                  <div class="tab-pane" id="register">
                    <div class="modal-body">           
                      <div class="with-facebook">
                        <a href="<?=$facebook['loginUrl'];?>" class="btn btn-lg btn-facebook blocken"><i class="shoopicon-facebook"></i> Daftar dengan Facebook</a> 
                      </div>
                      <p class="line-sparator">
                        <span class="sparator-inner">atau daftar dengan email</span>
                      </p>
                      
                      <div>                
                        <div class='inline_error' id='email_register_error' style='display:none'></div>
                        <div class='inline_error' id='passconf_register_error' style='display:none'></div>
                      </div>
                      
                      <div class="reg_error" style="color:#D7121D !important;">                
                      </div>
                      <form id="form-reg" class="form" method="POST" action="<?php echo $this->config->item('secure_base_url');?>auth/register"> <!-- register form -->
                        <div class="account-form">
                            <!-- <table border='0' width='100%'> -->
                                <!-- <tr>
                                    <td width='90%'> --><p>
                                      <input class="form-control auth" type="text" name="email" id="email_register" placeholder="Email" onblur="check_email()">
                                    </p><!-- </td>
                                    <td align='center'> -->
                                    <!-- <img style='display:none' id='warning_email' src="<?php echo base_url('asset/img/dialog-warning.png')?>">  </td>
                                </tr>
                                <tr>
                                    <td> --><p>
                                      <input class="form-control auth" autocomplete="off" type="password" name="password" placeholder="Password" id="password_register"><small style="color:red;">&nbsp;*panjang minimal 6 karakter.</small>
                                      <input type="hidden" name="csrf_token" value="<?php echo time() ?>" />
                                    </p>
                                      <!-- <img style='display:none' id='warning_password' src="<?php echo base_url('asset/img/dialog-warning.png')?>"> -->
                                   <p>
                                      <input class="form-control auth" autocomplete="off" type="password" name="passconf" placeholder="Konfirmasi Password" id="passconf_register" onblur="check_password()">
                                    </p>
                                      <!-- <img style='display:none' id='warning_passconf' src="<?php echo base_url('asset/img/dialog-warning.png')?>"> -->

                                        <div class="recaptcha">
                                            <?= $this->lib_recaptcha->recaptcha(); ?>
                                        </div>
                          
                          <p class="tnc"><small>Dengan klik tombol daftar, Anda telah menyetujui <a href="<?=base_url().'page/index/8';?>" target='_blank'>Syarat dan Ketentuan Berlaku</a>.</small></p>
                        </div>
                        <div class="submit-box">
                          <p><input type="submit" class="btn btn-lg btn-primary form-control register-submit auth-btn" value="Daftar" /></p>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <script src="<?=base_url()?>asset/ui2/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>asset/ui2/js/slick/slick.min.js"></script>
        <script src="<?=base_url()?>asset/ui2/js/main.js"></script>
        <script src="<?=base_url()?>asset/ui2/js/checkout-page.js"></script>
        <script src="<?=base_url()?>asset/ui2/js/jquery.ddslick.min.js"></script>
        <script type="text/javascript">
            var base_url = '<?= base_url() ?>';
        </script>
        <script src="<?=base_url()?>asset/js/jRating.jquery.js"></script>
        <script type="text/javascript">
        var base_url = '<?=base_url()?>';
        var secure_base_url = '<?php echo $this->config->item('secure_base_url');?>';
        var index_page = '';
        var url_suffix = '';
        </script>
        <script type="text/javascript">
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
        </script>
        <script type="text/javascript">
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
        </script>
        <script>
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
        </script>
        <script type="text/javascript">

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
</script>
<script type="text/javascript">
//cek number field
  function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if ((charCode > 47 && charCode < 58 ) || charCode == 44 || charCode == 46 || charCode == 8)
        return true;

     return false;
     // alert(charCode);
  }
</script>
    </body>
</html>
