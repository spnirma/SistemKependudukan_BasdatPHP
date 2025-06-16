<?php $this->load->view('publik/ui2/header'); ?>
<?php
    $gaProduct = array(
        'id'   => $produk->id_produk,
        'name' => $produk->nama_produk,
    );
?>
		<link rel="stylesheet" href="<?=base_url() ?>asset/ui2/css/jquery.jqzoom.css">
        <style type="text/css">

            ul#thumblist{display:block;}
            ul#thumblist li{float:left;margin-right:2px;list-style:none;}
            ul#thumblist li a{display:block;border:1px solid #CCC;}
            ul#thumblist li a.zoomThumbActive{
                border:1px solid red;
            }
            .jqzoom{

                text-decoration:none;
                float:left;
            }
        </style>
        <section class="main">

            <header class="content-head container">
                <div class="attribut-set clearfix">
                    <ol class="breadcrumb">
                      <li><a href="<?=base_url()?>"><img src="<?=base_url()?>asset/ui2/content/icon-home.png" alt="Home"></a></li>
                      <?php 
                      $channel = strtolower($produk->channel);
                      if($channel == 'store'){
                          $channel = 'food';
                      }
                      ?>
                      <li><a href="<?=base_url().$channel?>"><?= ucfirst($channel) ?></a></li>
                      <?php $kategoriProduk = $this->myproduct_m->getDeepestCategory($produk->id_produk); ?>
                      <?php $gaProduct['category'] = $kategoriProduk['nama_kategori']; ?>
                      <li><a href="<?=base_url().strtolower($produk->channel).'/?'.$this->home_ui2_m->built_html_get_query('cat',$kategoriProduk['id_kategori']).'&'.$this->home_ui2_m->built_html_get_query('filter',1)?>"><?=$kategoriProduk['nama_kategori']?></a></li>
                      <li class="active"><?= htmlspecialchars($produk->nama_produk) ?></li>
                    </ol>
                </div>
            </header>

            <div class="product-desc container">
                <div class="row">
                    <div class="col-xs-9">
                        <article>
                            <div class="row">
								<?php /*
                                <figure class="col-xs-5">
                                    <?php $i=0;foreach ($produk_foto as $fp) { $i++; ?>
                                    <img src="<?=base_url()?>asset/pict.php?src=<?=$fp->image;?>&w=620&h=620&z=1" class="image-clone">
                                    <?php if($i==1){ break; } ?>
                                    <?php } ?>
                                </figure>
                                */ ?>
                                <figure class="col-xs-5">
                                    <?php 
                                    $ori = explode("/", $produk_foto[0]->image);

                                    if (isset($ori[8])) {
                                        $ori = $ori[8];
                                        $original = base_url() . 'asset/produk/original/' . $ori;
                                    } else {
                                        $original = $produk_foto[0]->image;
                                    }
                                    ?>
                                    <div class="clearfix" style="margin-top: 10px; margin-bottom: 10px">
                                        <a href="<?=base_url()?>asset/pict.php?src=<?=$original?>&w=768&z=1" class="jqzoom" rel='gal1'  title="triumph" >
                                            <img src="<?=base_url()?>asset/pict.php?src=<?=$produk_foto[0]->image;?>&w=500&z=1"  title="triumph" style="border: 1px solid #ccc; width: 100%;">
                                        </a>
                                    </div>
                                    <div class="clearfix" >
                                        <ul id="thumblist" class="clearfix" style="padding-left:0px;" >
                                            <?php 
                                            $i=0;
                                            foreach ($produk_foto as $fp) { $i++;

                                                $produk_ori = explode("/", $fp->image);

                                                if (isset($produk_ori[8])) {
                                                    $produk_ori = $produk_ori[8];
                                                    $img_original = base_url() . 'asset/produk/original/' . $produk_ori;
                                                } else {
                                                    $img_original = $fp->image;
                                                }
                                                
                                            ?>
                                                <li><a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?=base_url()?>asset/pict.php?src=<?=$fp->image;?>&w=500&z=1',largeimage: '<?=base_url()?>asset/pict.php?src=<?=$img_original?>&w=768&z=1'}"><img src="<?=base_url()?>asset/pict.php?src=<?=$fp->image;?>&w=80&z=1" class="image-clone"></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </figure>
                                <div class="col-xs-7">
                                    
                                    <div class="clearfix" style="text-align:right">
                                        <div class="product-tile love-button-detail" data-product-id="<?=$produk->id_produk?>">
                                            <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $produk->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                        </div>
                                        <span class="love-value-detail love-value-<?=$produk->id_produk?>"><?=$produk->loved;?></span>
                                    </div>
                                    <header class="detail-title">
                                        <h1><?= htmlspecialchars($produk->nama_produk)?></h1>
                                        <?php
                                            $seller = $this->commonlib->get_seller($produk->id_user);
                                            if(isset($seller->nama_store)){
                                                $store_name = ucwords($seller->nama_store);
                                            }else{
                                                $store_name = ucwords($produk->username);
                                            }
                                        ?>
                                        <p>
                                        <strong>Merchant:</strong> <a href="<?=base_url();?>store/id/<?=$produk->id_user;?>"><?=$store_name?></a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Lokasi</strong>: <?=htmlspecialchars(ucwords(strtolower($seller->nama_kabupaten)))?>
                                        </p>
                                    </header>
                                    <table class="product-data-table">
                                        <tr>
                                            <td valign="top" width="50">Isi Paket</td><td class="colon" valign="top">:</td><td valign="top"><?=nl2br(htmlspecialchars($produk->detail_paket));?></td>
                                        </tr>
                                        <tr>
                                            <td>Berat</td><td class="colon">:</td><td><?=$produk->berat * 1000;?> Gram</td>
                                        </tr>
                                    </table>
                                    <p class="price">
                                        <?php if($diskon > 0) { ?>
                                        <strike style="font-size:50%;color:#222">Rp <?=$this->cart->format_number($produk->harga_jual);?></strike> 
                                        Rp <?php $gaProduct['price'] = $harga_diskon . '.00';
                                                 echo $this->cart->format_number($harga_diskon); ?> 
                                        <?php } else { ?>
                                        Rp <?php $gaProduct['price'] = $produk->harga_jual . '.00';
                                                 echo $this->cart->format_number($produk->harga_jual); ?>
                                        <?php } ?>                      
                                    </p>
                                    <?php if(!empty($diskon)) { ?>
                                        <span class="troli-diskon diskon-item diskon-big">
                                            <strong class="icon-diskon diskon-big" style="position:absolute;margin-top:7px;margin-left:-15px;"></strong>
                                            <?=$diskon?>%
                                        </span>
                                    <?php } ?>
                                    <div class="share">
                                        Share: 
                                        <span>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?=base_url()?>product/detail/<?=$produk->id_produk?>/<?=$produk->nama_produk?>" target="_blank"><img src="<?=base_url()?>asset/ui2/img/share-fb.jpg"></a>
                                            <a href="https://twitter.com/home?status=<?=base_url()?>product/detail/<?=$produk->id_produk?>/<?=$produk->nama_produk?>" target="_blank"><img src="<?=base_url()?>asset/ui2/img/share-tw.jpg"></a>
                                            <!-- <a href="#"><img src="<?=base_url()?>asset/ui2/img/share-g.jpg"></a> -->
                                            <!-- <a href="#"><img src="<?=base_url()?>asset/ui2/img/share-email.jpg"></a> -->
                                        </span>
                                    </div>
                                    <div class="form-inline buy-this">
                                        <?php
                                          //if($produk->stok_produk > 0){ 
                                          if($stock_available > 0){ 
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
                                        <div class="input-group spinner">
                                            <input type="hidden" id="id_produk" value="<?=$produk->id_produk?>">
                                            <?php if($can_buy){ ?>
                                            <input type="text" class="form-control" id="qty" value="1">
                                            <div class="input-group-btn-vertical">
                                              <button class="btn btn-default" id="dropup"><span class="dropup"><span class="caret"></span></span></button>
                                              <button class="btn btn-default" id="dropdown"><span class="dropdown"><span class="caret"></span></span></button>
                                            </div>
                                            <?php } ?>
                                          </div>
                                        <?php if($can_buy){ ?>
                                        <input type="submit" class="btn btn-buy" value="Beli Sekarang" id="add-cart-btn">
                                        <?php } else { ?>
                                        <span class="btn btn-buy" style="margin-left:-85px;">Sold Out</span>    
                                        <?php } ?>
                                    </div>
                                    <br>
                                    <br>
                                    
                                    <?php
                                    $varian_arr = array();
                                    if(!empty($produk_varian)){
                                        echo '<div id="produk-varian-ddjquery"></div>';
                                    if(!empty($produk_parent)){
                                        if($produk->id_produk != $produk_parent->id_produk) {
                                            $varian_arr[] = array(
                                                'text' => $produk_parent->nama_produk,
                                                'value' => base_url().'product/detail/'.$produk_parent->id_produk.'/'.urlencode(preg_replace('/[^\\pL0-9]+/u','-',$produk_parent->nama_produk)),
                                                'selected' => false,
                                                'description' => $produk_parent->nama_produk,
                                                'imageSrc' => base_url().'asset/pict.php?src='.$produk_parent->image.'&w=50&h=50&z=1',
                                            );
                                        }
                                    }
                                    if(!empty($produk_varian)) {
                                        foreach ($produk_varian as $varian) {                           
                                        $produk_varian_calculated_list = $produk_price_calculator->getPriceList(array(0=>$varian));
                                        if($produk_varian_calculated_list[0]['is_promo']){
                                            $diskon_variant = $produk_varian_calculated_list[0]['diskon'];
                                            $harga_diskon_variant = $produk_varian_calculated_list[0]['harga_setelah_diskon'];
                                        } else {
                                            $diskon_variant = 0;
                                            $harga_diskon_variant = 0;
                                        }
                                        if($produk->id_produk != $varian->id_produk) {
                                        $varian_arr[] = array(
                                            'text' => $varian->nama_produk,
                                            'value' => base_url().'product/detail/'.$varian->id_produk.'/'.urlencode(preg_replace('/[^\\pL0-9]+/u','-',$varian->nama_produk)),
                                            'selected' => false,
                                            'description' => $produk_parent->nama_produk,
                                            'imageSrc' => base_url().'asset/pict.php?src='.$varian->image.'&w=50&h=50&z=1',
                                        );
                                        }
                                    }
                                    }
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="description"> 
                              <ul class="nav nav-tabs clearfix" role="tablist" id="pdesc">
                                  <li role="" class=""><a href="#deskripsi" aria-controls="deskripsi" role="tab" data-toggle="tab">Detail Produk</a></li>
                              </ul>

                                <div class="tab-content">
                                  <div role="tabpanel" class="tab-pane active" id="deskripsi">
                                      <p><?=nl2br(htmlspecialchars($produk->deskripsi));?></p>
                                  </div>
                                </div>
                            </div>
                            <?php if(!empty($produk_other)) { ?>
                            <div class="recomend"> 
                                <h3 class="produk-lainnya">Produk Lainnya dari <?=htmlspecialchars($store_name)?></h3>
                                <div class="row">
                                
                                <?php foreach($produk_other as $data) { ?>
                                    <div class="col-xs-4">
                                        <div class="product-item product-tile" data-product-id="<?=$data['produk']->id_produk?>">
                                        <a href="<?=base_url();?>product/detail/<?=$data['produk']->id_produk.'/'.urlencode(preg_replace('/[^\\pL0-9]+/u','-',$data['produk']->nama_produk));?>">
                                            <figure class="product-thumbnail">
                                                <img src="<?=base_url();?>asset/pict.php?src=<?=$data['produk']->image;?>&w=300&h=300&z=1">
                                            </figure>
                                            <div class="desc">
                                                <h3 class="hellip product-title"><?=htmlspecialchars($data['produk']->nama_produk)?></h3>
                                                <?php if($data['diskon'] > 0 && $data['produk']->diskon < 1) { ?>
                                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($data['harga_setelah_diskon']);?></p>
                                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($data['produk']->harga_jual);?></del></p>
                                                <span class="troli-diskon diskon-item">
                                                    <!-- <strong class="icon-diskon"></strong><?=$data['diskon']?>% -->
                                                    <div class="love-button product-tile" data-product-id="<?=$data['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $data['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                                    </div>
                                                    <span class="love-value love-value-<?=$data['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$data['produk']->loved;?></span>
                                                </span>
                                                <?php } ?>
                                                <?php if($data['diskon'] < 1 && $data['produk']->diskon > 0) { ?>
                                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number(((100 - $data['produk']->diskon)/100) * $data['produk']->harga_jual);?></p>
                                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($data['produk']->harga_jual);?></del></p>
                                                <span class="troli-diskon diskon-item">
                                                    <!-- <strong class="icon-diskon"></strong><?=$data['diskon']?>% -->
                                                    <div class="love-button product-tile" data-product-id="<?=$data['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $data['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                                    </div>
                                                    <span class="love-value love-value-<?=$data['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$data['produk']->loved;?></span>
                                                </span>
                                                <?php } ?>
                                                <?php if($data['diskon'] > 0 && $data['produk']->diskon > 0) { ?>
                                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($data['harga_setelah_diskon']);?></p>
                                                <p class="hellip product-price"><del>Rp <?=$this->cart->format_number($data['produk']->harga_jual);?></del></p>
                                                <span class="troli-diskon diskon-item">
                                                    <!-- <strong class="icon-diskon"></strong><?=$data['diskon']?>% -->
                                                    <div class="love-button product-tile" data-product-id="<?=$data['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                                        <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $data['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                                    </div>
                                                    <span class="love-value love-value-<?=$data['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$data['produk']->loved;?></span>
                                                </span>
                                                <?php } ?>
                                                <?php if($data['diskon'] < 1 && $data['produk']->diskon < 1) { ?>
                                                <p class="hellip product-price-now">Rp <?=$this->cart->format_number($data['produk']->harga_jual);?></p>    
                                                <p class="hellip product-price"></p>
                                                <span class="troli-diskon diskon-item">
                                                    <div class="love-button product-tile" data-product-id="<?=$data['produk']->id_produk?>" style="margin-top:-5px;margin-left: -35px;">
                                                            <i class="shoopicon-heart user-love product-thumb-love <?php if($this->session->userdata('member')){if($this->auth_m->cek('tbl_love', 'id_produk', 'id_user', $data['produk']->id_produk, $this->auth_m->get_user()->id_user)>0) echo 'user-loved';}?>" <?php if(!$this->session->userdata('member')) {echo 'data-toggle="modal" data-target="#register-login-form"';}?>></i>&nbsp;&nbsp;
                                                        </div>
                                                    <span class="love-value love-value-<?=$data['produk']->id_produk?>" style="margin-top:2px;margin-left: -9px;"><?=$data['produk']->loved;?></span>
                                                </span>
                                                <?php } ?>   
                                                <?php
                                                $can_buy = true;
                                                  //if($produk->stok_produk > 0){ 
                                                  if($data['stock_available'] > 0){ 
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
                                            <?php
                                                $seller = $this->commonlib->get_seller($data['produk']->id_user);
                                                if(isset($seller->nama_store)){
                                                    $store_name = ucwords($seller->nama_store);
                                                }else{
                                                    $store_name = ucwords($produk->username);
                                                }
                                            ?>
                                            <a href="<?=base_url();?>store/id/<?=$data['produk']->id_user;?>">                          
                                                <span class="store-thumb">
                                                <?php
                                                $img=$this->user_m->get_single('tbl_user', 'id_user', $data['produk']->id_user);
                                                ?>
                                                <?php if($img->image == NULL){ ?>
                                                <img src="<?=base_url();?>asset/img/no-avatar.jpg" >
                                                <?php } else { ?>
                                                <img src="<?=base_url();?>asset/pict.php?src=<?=base_url();?>asset/upload/profil/<?=$img->image;?>&w=16&h=16&z=1">
                                                <?php } ?>
                                                </span>
                                                <?=htmlspecialchars($store_name)?>
                                            </a>
                                        </div>
                                    </div>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>  
                            <?php } ?>
                        </article>
                    </div>
                    <div class="col-xs-3">
                        <div class="sidebar">
                            <div class="aside-item verification"> 
                                <div class="verified"></div>  
                                <h3>Verified Merchant <a href="<?=base_url()?>store/id/<?=$produk->id_user?>"><?=$store_name?></a></h3>
                                <div class="aside">
                                    <p>Followers <span class="force-right"><?=$jml_follower;?></span></p>
                                    <p>Rating</p>
                                    <div class="rate" data-average="<?= $rating ?>"></div>
                                    <div class="horizontal" style="width:100%;border-bottom:solid 1px #ccc;"></div>
                                    <p>Suka <span class="force-right love-value-<?=$produk->id_produk?>"><?=$produk->loved;?></span></p>
                                    <p>Dilihat <span class="force-right"><?=$viewed?></span></p>
                                    <p>Terbeli <span class="force-right"><?=$jml_list;?></span></p>
                                </div>
                            </div>
                            <div class="aside-item verification"> 
                                <div class="box"></div>  
                                <h3>Informasi Pengiriman</a></h3>
                                <div class="aside">
                                    <?php if($produk->nominal_voucher_reload === null) { ?>
                                    <p style="font-weight:normal;">Produk akan dikirim dalam waktu maksimal 7 hari kerja</p>
                                    <br>
                                    <p style="font-weight:normal;">Jika kami membutuhkan waktu tambahan, maka kami akan memberikan informasi melalui email</p>
                                    <?php } else { ?>
                                    <p style="font-weight:normal;">Pulsa akan langsung ditopupkan ke nomer anda. <br>&nbsp;</br>Jika lebih dari 2 jam pulsa belum masuk, silakan hubungi <b>e-care.cipika@cipika.co.id</b></p>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>  
            </div>

            <div class="totop container">
                <div id="totop" class="ir">
                    To Top
                </div>
            </div>

        </section>
        <script>
            if (typeof ga !== 'undefined') {
                ga('t2.ec:addProduct', <?php echo json_encode($gaProduct) ?>);
                ga('t2.ec:setAction', 'detail');
                ga('t2.send', 'event', 'product', 'view', 'product detail', 1);
            };
        </script>
        <script src="<?= base_url() ?>asset/ui2/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="<?= base_url() ?>asset/ui2/js/jquery.jqzoom-core.js"></script>

		<script type="text/javascript">
		$(document).ready(function() {
				$('.jqzoom').jqzoom({
					zoomType: 'standard',
					lens:true,
					preloadImages: false,
					alwaysOn: false
				});
			});
		</script>
		<script>
		$(document).ready(function(){
            $(".dd-selected-value").change(function(){
                alert($(".dd-selected-value").val());
            });
			$("#dropup").click(function(){
				data = parseInt($("#qty").val())+1;
				if(data < <?=$stock_available+1?>){
					$("#qty").val(data);
				}
			});
			
			$("#dropdown").click(function(){
				data = parseInt($("#qty").val())-1;
				if(data > 0){
					$("#qty").val(data);
				}
			});
			
			$("#qty").change(function(){
				data = parseInt($("#qty").val());
				if(data <= 0){
					$("#qty").val('1');
				} else if (data > <?=$stock_available?>) {
					$("#qty").val('<?=$stock_available?>');
				}
			});
			
			$("#qty").keyup(function(){
				data = parseInt($("#qty").val());
				if(data <= 0){
					$("#qty").val('1');
				} else if (data > <?=$stock_available?>) {
					$("#qty").val('<?=$stock_available?>');
				}
			});
			
			$("#add-cart-btn").click(function(){
                //google event tracking script
                if (typeof ga !== 'undefined') {ga('send', 'event', 'button', 'click', 'add to cart button');}

				$.post("<?=base_url()?>cart/add", {id_produk: $("#id_produk").val(), qty : $("#qty").val()}, function(result){
					obj = jQuery.parseJSON(result);
					$(".shopping-item").html(obj.qty);
				});
				var $viewCart = $('.sm-troli:visible');
				if ($viewCart.size() == 0) {
					return;
				}
				var offset = $viewCart.offset();
				var elem = $('.image-clone').clone();
				elem.css('position', 'absolute');
				elem.css('z-index', '9999');
				elem.css('left', $('.image-clone').offset().left);
				elem.css('top', $('.image-clone').offset().top);
				elem.appendTo('body');
				elem.animate({
					opacity: 0.3,
					left: offset.left + ($viewCart.outerWidth() / 2),
					top: offset.top + ($viewCart.outerHeight() / 2),
					height: 0,
					width: 0,
				}, 1000, function() {
					elem.remove();
				});
			});
			
		});
		</script>
		<script>
			$(document).ready(function(){
			  $(".rate").jRating({
				showRateInfo:true,
				step:true,
				isDisabled : true
			  });
			});
			$(".rate").click(function(){
			$(".rate").jRating({
				showRateInfo:true,
				step:true,
				isDisabled : true
			  });
		  });
		</script>
<?php $this->load->view('publik/ui2/footer'); ?>
<script>
    var dataSelect = <?= json_encode($varian_arr) ?>;
    $("#produk-varian-ddjquery").ddslick({
        data:dataSelect,
        width: 350,
        selectText: "Pilih variant lainnya",
        imagePosition: "left",
        onSelected: function (data) {
            console.log(data);
            if(varianNow!='' && varianNow != data.selectedData.value){
                window.location = data.selectedData.value;
            }
            varianNow = data.selectedData.value;
        }
    });
    
    $(document).ready(function(){
        varianNow = '1';
    });
    
    
</script>
