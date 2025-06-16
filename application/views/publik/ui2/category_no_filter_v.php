<?php $this->load->view('publik/ui2/header')?>
<?php
$uriChannel = $this->uri->segment(1);
if(empty($uriChannel)){
    $uriChannel = 'gadget';
}
?>
        <section class="main">

            <header class="content-head container">
                <div class="attribut-set clearfix">
                    <ol class="breadcrumb">
                      <li><a href="<?=base_url()?>"><img src="<?=base_url()?>asset/ui2/content/icon-home.png" alt="Home"></a></li>
                      <li class="active"><a href="<?=base_url().$uriChannel?>"><?=ucfirst($uriChannel)?></a></li>
                    </ol>
                    <div class="category-setting force-right">
                        <span>Urut Berdasarkan:</span>
                        <div>
                            <?php
                            $params = $_GET;
                            $query = http_build_query($params);
                            ?>
                            <form action="<?=base_url().$uriChannel.'/?'.$query?>" method="POST">
                            <select class="form-control" name="sort" onchange="$('#sort-submit').click();">
                              <option value="2" <?=isset($_GET['sort']) && $_GET['sort']==2 ? 'selected' : ''?>>Terbaru</option>
                              <option value="1" <?=isset($_GET['sort']) && $_GET['sort']==1 ? 'selected' : ''?>>Terpopuler</option>
                              <option value="3" <?=isset($_GET['sort']) && $_GET['sort']==3 ? 'selected' : ''?>>Terbaik</option>
                              <?php if(isset($_GET['s']) && !empty($_GET['s'])) { ?>
                              <option value="4" <?=isset($_GET['sort']) && $_GET['sort']==4 ? 'selected' : ''?>>Relevansi</option>
                              <?php } ?>
                            </select>
                            <button style="display:none;" id="sort-submit" name="sort_submit" value="1">ok</button>
                            </form>
                        </div>
                    </div>      
                </div>
                <div class="boxhead">
                   <div class="row">
                       <div class="col-xs-3">
                           <a href="<?=base_url().$uriChannel.'?filter=1'?>">Pilih Kategori <span class="dropright"><span class="caret"></span></span></a>
                       </div>
                       <div class="col-xs-9">
                           <?= $uriChannel == 'gadget' ? 'Produk Gadget dari berbagai daerah di Indonesia' : ''; ?>
                           <?= $uriChannel == 'food' ? 'Produk Makanan dari berbagai daerah di Indonesia' : ''; ?>
                           <?= $uriChannel == 'lifestyle' ? 'Produk Lifestyle dari berbagai daerah di Indonesia' : ''; ?>
                       </div>
                   </div> 
                </div>
            </header>

            <div class="category-list container">
                
                        <div class="row">
                            
                            <?php if(!empty($produk_diskon)) { ?>
                            <?php foreach ($produk_diskon as $p) { ?>
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
                        <?php } else { ?>
                            <div class="alert alert-danger produk-alert" role="alert"><h3>Produk belum tersedia!</h3></div>
                        <?php } ?>
                            
                        </div>

            </div>
            <div class="totop container">
                <div id="totop" class="ir">
                    To Top
                </div>
            </div>
            
            <nav class="container">
            <?php
                $showhalaman = 0;
                $nohalaman = 0;
                
                // apabila $_GET['halaman'] sudah didefinisikan, gunakan nomor halaman tersebut, 
                // sedangkan apabila belum, nomor halamannya 1.
                if($hal==''){
                    $nohalaman = 1;
                }else{ 
                    $nohalaman = $hal;      
                }
                
                // menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
                $jumhalaman = ceil($jumData/$dataPerhalaman);
                
                $output = '<ul class="pagination pagination-rounded force-right">';
                
                // menampilkan link previous
                if ($nohalaman > 1){
                    $params['page'] = 1;
                    $query = http_build_query($params);        
                    $output .= '<li class="prev"><a href="?'.$query.'"><span class="ir">Next</span></a></li>';
                } else {        
                    //$output .= '<li class="prev"><a href="#"><span class="ir">Next</span></a></li>';
                }

                

                // memunculkan nomor halaman dan linknya
                for($halaman = 1; $halaman <= $jumhalaman; $halaman++)
                {
                    $params = $_GET;
                    $params['page'] = $halaman;

                    $query = http_build_query($params);
                         if ((($halaman >= $nohalaman - 2) && ($halaman <= $nohalaman + 2)) || ($halaman == 1) || ($halaman == $jumhalaman)) 
                         {   
                            if (($showhalaman == 1) && ($halaman != 2)){  $output .= "<li><a>...</a></li>";} 
                            if (($showhalaman != ($jumhalaman - 1)) && ($halaman == $jumhalaman)){  $output .= "<li><a>...</a></li>";}
                            if ($halaman == $nohalaman){                    
                                $output .= '<li class="active"><a href="">'.$halaman.' <span class="sr-only">(current)</span></a></li>';
                            }else{ 
                                $output .= '<li><a href="?'.$query.'">'.$halaman.'</a></li>';
                            }
                            $showhalaman = $halaman;          
                         }
                }

                // menampilkan link next
                if ($nohalaman < $jumhalaman){ 
                    $params['page'] = $jumhalaman;
                    $query = http_build_query($params);
                    $output .= '<li class="next"><a href="?'.($query).'"><span class="ir">Next</span></a></li>';
                } 

                echo $output.='</ul>';
                ?>
            </nav>

        </section>
<?php $this->load->view('publik/ui2/footer')?>
