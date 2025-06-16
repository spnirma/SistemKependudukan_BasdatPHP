<!DOCTYPE html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php if(!empty($title)): ?>
        <title><?= htmlspecialchars(ucwords($title)) ?> | Toko Online Indosat - Gadget, Makanan, Travel dan Fashion</title>
        <meta name="description" content="Cipika: E-commerce Indosat <?= htmlspecialchars(ucwords($title)) ?> - Belanja Online Gadget dan Asesoris, Produk Makanan Unggulan dan Asli Khas Indonesia, Fashion Terkini sampai Paket Travel">
        <?php if(!empty($produk)): ?>
        <link rel="canonical" href="<?=base_url();?>product/detail/<?=$produk->id_produk.'/'.urlencode(preg_replace('/[^\\pL0-9]+/u','-',$produk->nama_produk));?>" />
        <?php endif; ?>
        <?php else: ?>
        <title>cipika.co.id | Toko Online Indosat - Gadget, Makanan, Travel dan Fashion</title>
        <meta name="description" content="Cipika: E-commerce Indosat - Belanja Online Gadget dan Asesoris, Produk Makanan Unggulan dan Asli Khas Indonesia, Fashion Terkini sampai Paket Travel.">
        <link rel="canonical" href="http://www.cipika.co.id/" />
        <?php endif; ?>
        <meta name="keywords" content="cipika,toko,online,asli,indonesia,jual,beli" />
        <meta name="robots" content="index, follow, noodp, noydir" />
        <link rel="shortcut icon" href="<?=base_url()?>asset/img/favicon.ico?201411070848" type="image/x-icon"/>
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="<?=base_url()?>asset/ui2/css/bootstrap.css">
        <link rel="stylesheet" href="<?=base_url()?>asset/ui2/css/main.css">
        <link rel="stylesheet" href="<?=base_url()?>asset/ui2/js/slick/slick.css">
        <link rel="stylesheet" href="<?=base_url()?>asset/ui2/css/custom.css">
        <script src="<?=base_url()?>asset/ui2/js/jquery-1.11.2.min.js"></script>
        <link rel="stylesheet" href="https://bootstrap-datepicker.googlecode.com/git/jquery-ui/themes/smoothness/jquery-ui.min.css">
        <link rel="stylesheet" href="<?=base_url()?>asset/admin/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=base_url()?>asset/css/jRating.jquery.css" type="text/css" />
        
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
        
        <?php echo $this->config->item('google_analytics_script');?>
        <?php echo $this->config->item('fb_tracking_script');?>
        
    </head>
    <body>
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '234905216704515',
                status     : true,
                xfbml      : true
            });
        };

        (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "//connect.facebook.net/en_US/all.js";
             fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'facebook-jssdk'));
    </script>
        <header id="head">
            <?php 
            $uriChannel = $this->uri->segment(1);
            if(empty($uriChannel)){
                $uriChannel = '';
            }
            ?>
              <div class="navbar-main clearfix">
                
                <nav class="navbar-content container cpk-container-ex">
                  <ul class="nav navbar-nav">
                    <li>
                      <a class="ir mm-logo" href="<?=base_url()?>"><h1 class="site-name hidden">Cipika</h1></a>
                    </li>
                    <li <?=$uriChannel=='gadget' ? 'class="active"' : '' ?>>
                      <a class="ir mm-gadget channel-menu" href="<?=base_url()?>gadget"><div class="channel-lable" style="padding-left: 5px;">Gadget</div></a>
                    </li>
                    <li <?=$uriChannel=='food' ? 'class="active"' : '' ?>>
                      <a class="ir mm-store channel-menu" href="<?=base_url()?>food"><div class="channel-lable" style="padding-left: 15px;">Food</div></a>
                    </li>
                    <li <?=$uriChannel=='lifestyle' ? 'class="active"' : '' ?>>
                      <a class="ir mm-lifestyle channel-menu" href="<?=base_url()?>lifestyle"><div class="channel-lable" style="padding-right: 7px;  margin-left: 5px;">Lifestyle</div></a>
                    </li>
                    <li>
                      <a class="ir mm-travel channel-menu" href="<?=base_url()?>travel"><div class="channel-lable" style="padding-left: 14px;">Travel</div></a>
                    </li>
                  </ul>
                </nav>
              </div><!-- /.navbar-main -->
                <?php 
                $uriChannel = $this->uri->segment(1);
                if(empty($uriChannel)){
                    $uriChannel = 'gadget';
                }
                if($this->uri->segment(2)=='id' and is_numeric($this->uri->segment(3))){
                    $uriChannel = 'store/id/'.$this->uri->segment(3);
                }
                if($this->uri->segment(1)=='product' and $this->uri->segment(2)=='detail'){
                    $uriChannel = 'gadget/';
                }
                if($this->uri->segment(1)=='cart'){
                    $uriChannel = 'gadget/';
                }
                if($this->uri->segment(1)=='dailydeals'){
                    $uriChannel = 'dailydeals';
                }
                if($this->uri->segment(1)=='promo'){
                    $uriChannel = 'promo/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
                }
                ?>
            
              <div class="navbar-secondary">
                  <div class="container cpk-container-ex clearfix">
                    <div class="force-right">
                        <nav class="navbar-content">
                          <ul class="nav navbar-nav">
                            <li class="sm-search">
                                <?php
                                if($this->input->post('header-search')==1){
                                    $params = $_GET;
                                    $params['s'] = $this->input->post('s');
                                    $params['page'] = 1;
                                    $params['sort'] = 4;
                                    $query = http_build_query($params);
                                    redirect(base_url().$uriChannel.'/?'.$query);
                                }
                                ?>
                                <form class="form-inline" action="<?=base_url()?><?=$uriChannel?>?<?=$this->home_ui2_m->built_html_get_query()?>" method="post">
                                  <div class="form-group">
                                    <div class="input-group">
                                      <input type="text" class="form-control" id="cariproduk" name="s" placeholder="Cari produk yang Anda inginkan" value="<?=isset($_GET['s']) ? $_GET['s'] : '';?>">
                                      <button type="submit" class="btn btn-primary ir cariproduk input-group-addon" name="header-search" value="1">Cari</button>
                                    </div>
                                  </div>
                                </form>
                            </li>
                            <li class="sm-troli">
                              <a href="<?=base_url()?>cart">
                                <span class="shopping-item"><?=$this->cart->total_items()?></span>
                                <span class="troli">Troli</span>
                              </a>
                            </li>
                            <li class="sm-log">
                            <?php if($this->session->userdata('member')){ 
                                $profil_member = $this->user_m->get_single('tbl_user', 'id_user', $this->session->userdata('member')->id_user);
                            ?>
                            <a id="login-btn" data-toggle="modal"href="<?=base_url()?>user/profile">
                                <?=($profil_member->username)? $profil_member->username : $profil_member->email; ?>
                            </a>
                            <?php } else if ($this->session->userdata('partner')){ 
                                $profil_partner = $this->user_m->get_single('tbl_user', 'id_user', $this->session->userdata('partner')->id_user);
                            ?>
                            <?=($profil_partner->username)? $profil_partner->username : $profil_partner->email; ?>
                            <a id="login-btn" data-toggle="modal" href="<?=base_url()?>partner/indoloka/orders">
                                <?=($profil_partner->username)? $profil_partner->username : $profil_partner->email; ?>
                            </a>
                            <?php } else { ?>
                            <a id="login-btn" data-toggle="modal" data-target="#register-login-form" href="#">
                                <span class="log-auth">Masuk | Daftar </span>
                            </a>
                            <?php } ?>
                            </li>
                            <li class="sm-indosat">
                              <a class="ir" href="http://indosat.com" target="_blank">Indosat</a>
                            </li>
                          </ul>
                        </nav>
                    </div>
                </div>
              </div><!-- /.navbar-secondary -->
            
        </header>
