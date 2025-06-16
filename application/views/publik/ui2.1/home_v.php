<?=$this->load->view('publik/ui2.1/header')?>
<!-- TIME -->
<!-- Gadget : <?=$timegadget?>-->
<!-- Camilan : <?=$timegadget?>-->
<!-- Fashion : <?=$timefasion?>-->
<!-- Terbaru : <?=$timeterbaru?>-->
<section class="banner" role="banner">
            <div class="carousel" role="listbox">
                <div class="item">
                  <a href="http://bit.ly/1ElXqW4"><img src="<?=base_url()?>asset/ui2/content/banner/voucher_banner.png"  alt="Promo Voucher"></a>
                </div>
                <div class="item">
                  <a href="https://cipika.co.id/gadget"><img src="<?=base_url()?>asset/ui2/content/banner/Gadget_banner.png"  alt="Gadget"></a>
                </div>
                <div class="item">
                  <a href="https://cipika.co.id/lifestyle"><img src="<?=base_url()?>asset/ui2/content/banner/lifestyle_banner.png"  alt="Lifestyle"></a>
                </div>
                <div class="item">
                  <a href="https://cipika.co.id/travel"><img src="<?=base_url()?>asset/ui2/content/banner/travel_banner.png?201503271301"  alt="Travel"></a>
                </div>
              </div>
        </section>

        <section class="banner-responsive" role="banner">
            <div class="carousel" role="listbox">
                <div class="carousel" role="listbox">
                <div class="item">
                  <a href="http://bit.ly/1ElXqW4"><img src="<?=base_url()?>asset/ui2/content/banner/voucher_banner.png"  alt="Promo Voucher"></a>
                </div>
                <div class="item">
                  <a href="https://cipika.co.id/gadget"><img src="<?=base_url()?>asset/ui2/content/banner/Gadget_banner.png"  alt="Gadget"></a>
                </div>
                <div class="item">
                  <a href="https://cipika.co.id/lifestyle"><img src="<?=base_url()?>asset/ui2/content/banner/lifestyle_banner.png"  alt="Lifestyle"></a>
                </div>
                <div class="item">
                  <a href="https://cipika.co.id/travel"><img src="<?=base_url()?>asset/ui2/content/banner/travel_banner.png?201503271301"  alt="Travel"></a>
                </div>
              </div>
            </div>
        </section>

        <section class="main">
            <div class="featured-list container">
                <h3 class="featured-title"><span>Gadget Terbaik</span></h3>
                <div class="row carousel1">
                <?php foreach($topgadget as $p) { ?>
                  <div class="col-xs-3">
                    <div class="product-item">
                        <a href="<?=base_url();?>product/detail/<?=$p['produk']->id_produk.'/'.urlencode(preg_replace('/[^\\pL0-9]+/u','-',$p['produk']->nama_produk));?>">
                            <figure class="product-thumbnail">
                                <img src="<?=base_url()?>asset/pict.php?src=<?=$p['produk']->image;?>&w=300&h=300&z=1">
                            </figure>
                            <div class="desc">
                                <h3 class="hellip product-title"><?=$p['produk']->nama_produk?></h3>
                                <?php if($p['diskon'] > 0 && $p['produk']->diskon < 1) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['harga_setelah_diskon']);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                    <!-- <strong class="icon-diskon"></strong><?=$p['diskon']?>% -->
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] < 1 && $p['produk']->diskon > 0) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number(((100 - $p['produk']->diskon)/100) * $p['produk']->harga_jual);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                    <!-- <strong class="icon-diskon"></strong><?=$p['diskon']?>% -->
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] > 0 && $p['produk']->diskon > 0) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['harga_setelah_diskon']);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                    <!-- <strong class="icon-diskon"></strong><?=$p['diskon']?>% -->
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] < 1 && $p['produk']->diskon < 1) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></p>    
                                <p class="hellip product-price"></p>
                                <span class="troli-diskon diskon-item">
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                            <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                        </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php
                                $can_buy = true;
                                  //if($produk->stok_produk > 0){ 
                                  if($p['stock_available'] > 0){ 
                                       if(!empty($array_ip)){
                                          foreach ($array_ip as $ip){
                                              if($cek_promo && $harga_diskon < 12000 && $ip == $this->input->ip_address()){
                                                  $can_buy = false;
                                                  break;
                                              }
                                          }
                                        }
                                    }else{
                                        $can_buy = false;
                                    }
                                ?>
                            
                            </div>
                        </a>
                        <?php if(!$can_buy){ ?>
                            <!--
                            <div class="sold-out">Sold Out</div>
                            -->
                        <?php } ?>
                        <div class="product-owner">
                            <a href="<?=base_url();?>store/id/<?=$p['produk']->id_user;?>">
                                <span class="store-thumb">
                                    <?php
                                    $img=$this->user_m->get_single('tbl_user', 'id_user', $p['produk']->id_user);
                                    ?>
                                    <?php if($img->image == NULL){ ?>
                                    <img src="<?=base_url();?>asset/img/no-avatar.jpg" >
                                    <?php } else { ?>
                                    <img src="<?=base_url();?>asset/pict.php?src=<?=base_url();?>asset/upload/profil/<?=$img->image;?>&w=16&h=16&z=1">
                                    <?php } ?>
                                </span>
                                <?php
                                    if(isset($p['produk']->nama_store)){
                                        echo htmlspecialchars(ucwords($p['produk']->nama_store));
                                    }else{
                                        echo htmlspecialchars(ucwords($p['produk']->username));
                                    }
                                ?>
                            </a>
                        </div>

                    </div>
                  </div>
                <?php } ?>
                </div>
                <!-- /FEATURED ONE -->

                <!-- FEATURED TWO -->
                <!--<h3 class="featured-title"><span>Cemilan Terlaris</span></h3>-->
<!--                <div class="row carousel1">
                  <?php foreach($topcamilan as $p) { ?>
                  <div class="col-xs-3">
                    <div class="product-item">
                        <a href="<?=base_url();?>product/detail/<?=$p['produk']->id_produk.'/'.urlencode(preg_replace('/[^\\pL0-9]+/u','-',$p['produk']->nama_produk));?>">
                            <figure class="product-thumbnail">
                                <img src="<?=base_url()?>asset/pict.php?src=<?=$p['produk']->image;?>&w=300&h=300&z=1">
                            </figure>
                            <div class="desc">
                                <h3 class="hellip product-title"><?=$p['produk']->nama_produk?></h3>
                                <?php if($p['diskon'] > 0 && $p['produk']->diskon < 1) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['harga_setelah_diskon']);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                     <strong class="icon-diskon"></strong><?=$p['diskon']?>% 
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] < 1 && $p['produk']->diskon > 0) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number(((100 - $p['produk']->diskon)/100) * $p['produk']->harga_jual);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                     <strong class="icon-diskon"></strong><?=$p['diskon']?>% 
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] > 0 && $p['produk']->diskon > 0) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['harga_setelah_diskon']);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                     <strong class="icon-diskon"></strong><?=$p['diskon']?>% 
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] < 1 && $p['produk']->diskon < 1) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></p>    
                                <p class="hellip product-price"></p>
                                <span class="troli-diskon diskon-item">
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                            <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                        </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php
                                $can_buy = true;
                                  //if($produk->stok_produk > 0){ 
                                  if($p['stock_available'] > 0){ 
                                       if(!empty($array_ip)){
                                          foreach ($array_ip as $ip){
                                              if($cek_promo && $harga_diskon < 12000 && $ip == $this->input->ip_address()){
                                                  $can_buy = false;
                                                  break;
                                              }
                                          }
                                        }
                                    }else{
                                        $can_buy = false;
                                    }
                                ?>
                                
                            </div>
                        </a>
                        <?php if(!$can_buy){ ?>
                            
                            <div class="sold-out">Sold Out</div>
                            
                        <?php } ?>
                        <div class="product-owner">
                            <a href="<?=base_url();?>store/id/<?=$p['produk']->id_user;?>">
                                <span class="store-thumb">
                                    <?php
                                    $img=$this->user_m->get_single('tbl_user', 'id_user', $p['produk']->id_user);
                                    ?>
                                    <?php if($img->image == NULL){ ?>
                                    <img src="<?=base_url();?>asset/img/no-avatar.jpg" >
                                    <?php } else { ?>
                                    <img src="<?=base_url();?>asset/pict.php?src=<?=base_url();?>asset/upload/profil/<?=$img->image;?>&w=16&h=16&z=1">
                                    <?php } ?>
                                </span>
                                <?php
                                    if(isset($p['produk']->nama_store)){
                                        echo htmlspecialchars(ucwords($p['produk']->nama_store));
                                    }else{
                                        echo htmlspecialchars(ucwords($p['produk']->username));
                                    }
                                ?>
                            </a>
                        </div>
                        
                    </div>
                  </div>
                    <?php } ?>
                </div>-->
                <!-- /FEATURED TWO -->

                <!-- FEATURED THREE -->
                <h3 class="featured-title"><span>Fashion Terlaris</span></h3>
                <div class="row carousel1">
                  <?php foreach($topfasion as $p) { ?>
                  <div class="col-xs-3">
                    <div class="product-item">
                        <a href="<?=base_url();?>product/detail/<?=$p['produk']->id_produk.'/'.urlencode(preg_replace('/[^\\pL0-9]+/u','-',$p['produk']->nama_produk));?>">
                            <figure class="product-thumbnail">
                                <img src="<?=base_url()?>asset/pict.php?src=<?=$p['produk']->image;?>&w=300&h=300&z=1">
                            </figure>
                            <div class="desc">
                                <h3 class="hellip product-title"><?=$p['produk']->nama_produk?></h3>
                                <?php if($p['diskon'] > 0 && $p['produk']->diskon < 1) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['harga_setelah_diskon']);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                    <!-- <strong class="icon-diskon"></strong><?=$p['diskon']?>% -->
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>                                
                                <?php if($p['diskon'] < 1 && $p['produk']->diskon > 0) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number(((100 - $p['produk']->diskon)/100) * $p['produk']->harga_jual);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                    <!-- <strong class="icon-diskon"></strong><?=$p['diskon']?>% -->
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] > 0 && $p['produk']->diskon > 0) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['harga_setelah_diskon']);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                    <!-- <strong class="icon-diskon"></strong><?=$p['diskon']?>% -->
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] < 1 && $p['produk']->diskon < 1) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></p>    
                                <p class="hellip product-price"></p>
                                <span class="troli-diskon diskon-item">
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                            <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                        </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>   
                                <?php
                                $can_buy = true;
                                  //if($produk->stok_produk > 0){ 
                                  if($p['stock_available'] > 0){ 
                                       if(!empty($array_ip)){
                                          foreach ($array_ip as $ip){
                                              if($cek_promo && $harga_diskon < 12000 && $ip == $this->input->ip_address()){
                                                  $can_buy = false;
                                                  break;
                                              }
                                          }
                                        }
                                    }else{
                                        $can_buy = false;
                                    }
                                ?>
                                
                            </div>
                        </a>
                        <?php if(!$can_buy){ ?>
                            <!--
                            <div class="sold-out">Sold Out</div>
                            -->
                        <?php } ?>
                        <div class="product-owner">
                            <a href="<?=base_url();?>store/id/<?=$p['produk']->id_user;?>">
                                <span class="store-thumb">
                                    <?php
                                    $img=$this->user_m->get_single('tbl_user', 'id_user', $p['produk']->id_user);
                                    ?>
                                    <?php if($img->image == NULL){ ?>
                                    <img src="<?=base_url();?>asset/img/no-avatar.jpg" >
                                    <?php } else { ?>
                                    <img src="<?=base_url();?>asset/pict.php?src=<?=base_url();?>asset/upload/profil/<?=$img->image;?>&w=16&h=16&z=1">
                                    <?php } ?>
                                </span>
                                <?php
                                    if(isset($p['produk']->nama_store)){
                                        echo htmlspecialchars(ucwords($p['produk']->nama_store));
                                    }else{
                                        echo htmlspecialchars(ucwords($p['produk']->username));
                                    }
                                ?>
                            </a>
                        </div>
                    </div>
                  </div>
                    <?php } ?>
                </div>
                <!-- /FEATURED THREE -->

            </div><!-- /.featured-list -->

            <div class="new container">
                <h3 class="featured-title"><span>Produk Terbaru</span></h3>
                
                <div class="row carousel1">
                <?php foreach($produkTerbaru as $p) { ?>
                  <div class="col-xs-3">
                    <div class="product-item">
                        <a href="<?=base_url();?>product/detail/<?=$p['produk']->id_produk.'/'.urlencode(preg_replace('/[^\\pL0-9]+/u','-',$p['produk']->nama_produk));?>">
                            <figure class="product-thumbnail">
                                <img src="<?=base_url()?>asset/pict.php?src=<?=$p['produk']->image;?>&w=300&h=300&z=1">
                            </figure>
                            <div class="desc">
                                <h3 class="hellip product-title"><?=$p['produk']->nama_produk?></h3>
                                <?php if($p['diskon'] > 0 && $p['produk']->diskon < 1) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['harga_setelah_diskon']);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                    <!-- <strong class="icon-diskon"></strong><?=$p['diskon']?>% -->
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] < 1 && $p['produk']->diskon > 0) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number(((100 - $p['produk']->diskon)/100) * $p['produk']->harga_jual);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                    <!-- <strong class="icon-diskon"></strong><?=$p['diskon']?>% -->
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] > 0 && $p['produk']->diskon > 0) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['harga_setelah_diskon']);?></p>
                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></del></p>
                                <span class="troli-diskon diskon-item">
                                    <!-- <strong class="icon-diskon"></strong><?=$p['diskon']?>% -->
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                    </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?>
                                <?php if($p['diskon'] < 1 && $p['produk']->diskon < 1) { ?>
                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($p['produk']->harga_jual);?></p>    
                                <p class="hellip product-price"></p>
                                <span class="troli-diskon diskon-item">
                                    <div class="love-button product-tile" data-product-id="<?=$p['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                            <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $p['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                        </div>
                                    <span class="love-value love-value-<?=$p['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$p['produk']->loved;?></span>
                                </span>
                                <?php } ?> 
                                <?php
                                $can_buy = true;
                                  //if($produk->stok_produk > 0){ 
                                  if($p['stock_available'] > 0){ 
                                       if(!empty($array_ip)){
                                          foreach ($array_ip as $ip){
                                              if($cek_promo && $harga_diskon < 12000 && $ip == $this->input->ip_address()){
                                                  $can_buy = false;
                                                  break;
                                              }
                                          }
                                        }
                                    }else{
                                        $can_buy = false;
                                    }
                                ?>
                            </div>
                        </a>
                        <?php if(!$can_buy){ ?>
                            <!--
                            <div class="sold-out">Sold Out</div>
                            -->
                        <?php } ?>
                        <div class="product-owner">
                            <a href="<?=base_url();?>store/id/<?=$p['produk']->id_user;?>">
                                <span class="store-thumb">
                                    <?php
                                    $img=$this->user_m->get_single('tbl_user', 'id_user', $p['produk']->id_user);
                                    ?>
                                    <?php if($img->image == NULL){ ?>
                                    <img src="<?=base_url();?>asset/img/no-avatar.jpg" >
                                    <?php } else { ?>
                                    <img src="<?=base_url();?>asset/pict.php?src=<?=base_url();?>asset/upload/profil/<?=$img->image;?>&w=16&h=16&z=1">
                                    <?php } ?>
                                </span>
                                <?php
                                    if(isset($p['produk']->nama_store)){
                                        echo htmlspecialchars(ucwords($p['produk']->nama_store));
                                    }else{
                                        echo htmlspecialchars(ucwords($p['produk']->username));
                                    }
                                ?>
                            </a>
                        </div>

                    </div>
                  </div>
                <?php } ?>
                </div>
                
            </div>

            <div class="totop container">
                <div id="totop" class="ir">
                    To Top
                </div>
            </div>

        </section>

        <section id="home-foot">
            <div class="aboutbox container">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="aboutbox-item">
                            <h5>Selamat datang di Cipika Store</h5>

                            <p>E-Marketplace yang menghadirkan kemudahan berbelanja online. Diluncurkan pertama kali di Jakarta pada tanggal, 15 Maret 2014 dengan dukungan penuh PT Indosat Tbk, Cipika Store memberikan komitmen kuat menghadirkan pelayanan premium dan pilihan produk berkualitas.</p>

                            <p>Cipika Store menjembatani kebutuhan pelaku usaha di Indonesia untuk memperluas cakupan pasar melalui media online, dengan penyelenggaraan beragam fasilitas dan kegiatan seperti : Integrated Shipping &amp; Tracking, secure Online Payment, Seminar dan Pelatihan, Marketing Campaign, hingga pendampingan Merchant oleh tim Sales.</p>

                            <p>Sementara bagi pelanggan, Cipika Store memastikan nuansa dan pengalaman belanja yang berbeda. Harga bersaing, Merchant yang terpercaya, produk berkualitas, hingga layanan Customer Care. Cipika Store, Semuanya Menjadi Mudah...</p>
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <div class="aboutbox-item">
                            <h5>Metode Pembayaran</h5>
                            <p><img alt="Dompetku, Visa, MasterCard, Bank Transfer" src="<?=base_url()?>asset/ui2/content/icon-payment.jpg"></p>
                            <img class="logo-logo" src="<?=base_url()?>asset/img/logo-bank-bca.png" style="height:40px;">
                            <img class="logo-logo" src="<?=base_url()?>asset/img/mandiri-transfer.png" style="height:40px;">
                            <img class="logo-logo" src="<?=base_url()?>asset/img/permata.jpg" style="height:80px;">
                        </div>
                        <div class="aboutbox-item jasa-pengiriman">
                            <h5>Jasa Pengiriman</h5>
                            <p><img alt="JNE" src="<?=base_url()?>asset/ui2/content/icon-jne.jpg"></p>
                        </div>
                        <div class="aboutbox-item verified-services">
                            <h5>Verified Services</h5>
                            <div class="logo-logo">
                            <span id="logo-pci-dss">
                                <script src="https://sealserver.trustkeeper.net/compliance/seal_js.php?code=x4ij3BctHNOh4gUNVXaQ7FWO2uwMPV&style=normal&size=35x54&language=en">
                                </script>
                                <noscript>
                                    <a href="https://sealserver.trustkeeper.net/compliance/cert.php?code=x4ij3BctHNOh4gUNVXaQ7FWO2uwMPV&style=normal&size=105x54&language=en" target="hATW">
                                        <img src="https://sealserver.trustkeeper.net/compliance/seal.php?code=x4ij3BctHNOh4gUNVXaQ7FWO2uwMPV&style=normal&size=105x54&language=en" border="0" alt="Trusted Commerce" width="25"/>
                                    </a>
                                </noscript>
                            </span>
                            </div>
                            <!-- Trustmark idEA Start -->
                            <div class="logo-logo">
                            <script type="text/javascript" src="https://www.idea.or.id/assets/js/trustmark_badge.js"></script>
                            <input type="hidden" id="hid_trustmark_code" value="SQCqI5sxvQ3ivuhEGSn7svML"/>
                            <input type="hidden" id="hid_base_url" value="https://www.idea.or.id/" />
                            <input type="hidden" id="hid_alt" value="no"/>
                            <div id="idEA_trustmark">
                                <div id="idEA_trustmark_wrapper">
                                    <img id="idEA_trustmark_image" width="105px" />
                                    <div id="idEA_trustmark_verified" style="display:none;">Verifikasi Hingga</div>
                                    <div id="idEA_trustmark_until" style="display:none"></div>
                                </div>
                            </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
<?=$this->load->view('publik/ui2.1/footer')?>
