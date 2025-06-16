<?=$this->load->view('publik/ui2/header')?>

        <section class="main">

            <header class="content-head container">
                <div class="boxhead">
                   <div class="row">
                       <div class="col-xs-3">
                           Merchant Area
                       </div>
                       <div class="col-xs-9">
                       </div>
                   </div> 
                </div>
            </header>

            <div class="category-list container">
                
                <div class="row">
                    <?php $this->load->view('publik/ui2/merchant/sidebar_merchant_v')?>
                    
                    <div class="col-xs-9">
                        <div class="row">
                            <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>
                              <?php
                                  if($produk->id_parent != null){
                                      echo "Edit Produk Varian";
                                  }else{
                                      echo "Edit Produk";
                                  }
                              ?>
                            </span></h3>
                            <hr>
                            <?php if($this->session->flashdata('data_tersimpan')!=''): ?>    
                                <div class="alert alert-success alert-dismissable">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>              
                                  <?php echo $this->session->flashdata('data_tersimpan');?>
                                </div>
                            <?php endif;?>
                          
                            <?php if($success!=''){ ?>
                            <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$success?>
                            </div>
                            <?php } ?>

                            <?php if($error!=''){ ?>
                            <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$error;?>
                            </div>
                            <?php } ?>
                        
                            
                            <form class="form-horizontal" method="post" action="">
                              <input type="text" name="id_produk" value="<?=$produk->id_produk;?>" class="hidden">
                              <?php
                                if($produk->id_parent != null){
                              ?>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Produk Parent</label>
                                <div class="col-lg-4">
                                    <input value="<?= htmlspecialchars($this->produk_m->get_produk($produk->id_parent)->nama_produk) ?>" readonly="" name="nama_produk" type="text" class="form-control" id="nama_produk" placeholder="">
                                </div>
                              </div>
                              <?php
                                }
                              ?>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Nama Produk</label>
                                <div class="col-lg-8">
                                  <input value="<?= htmlspecialchars(set_value('nama_produk', $produk->nama_produk));?>" name="nama_produk" type="text" class="form-control" id="nama_produk" placeholder="">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Deskripsi</label>
                                <div class="col-lg-9">
                                  <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="" rows=5><?= htmlspecialchars(set_value('deskripsi', $produk->deskripsi)) ?></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Detail Paket</label>
                                <div class="col-lg-9">
                                  <textarea name="detail_paket" class="form-control" id="deskripsi" placeholder="" rows=5><?= htmlspecialchars(set_value('detail_paket', $produk->detail_paket)) ?></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Berat</label>
                                <div class="col-lg-4">
                                  <div class="input-group">
                                  <input onkeypress="return isNumberKey(event)" value="<?= htmlspecialchars(set_value('berat',$produk->berat)) ;?>" name="berat" type="text" class="form-control" id="berat" placeholder="">
                                  <span class="input-group-addon">Kg</span>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Dimensi</label>
                                <div class="col-lg-9">
                                    <div class="input-group col-lg-3 pull-left">
                                      <input onkeypress="return isNumberKey(event)" value="<?= htmlspecialchars(set_value('panjang',$produk->panjang));?>" name="panjang" type="text" class="form-control" id="panjang" placeholder="">
                                      <span class="input-group-addon">cm</span>
                                    </div>
                                    <div class="input-group col-lg-3 pull-left">
                                      <input onkeypress="return isNumberKey(event)" value="<?= htmlspecialchars(set_value('lebar',$produk->lebar));?>" name="lebar" type="text" class="form-control" id="lebar" placeholder="">
                                      <span class="input-group-addon">cm</span>
                                    </div>
                                    <div class="input-group col-lg-3 pull-left">
                                      <input onkeypress="return isNumberKey(event)" value="<?= htmlspecialchars(set_value('tinggi',$produk->tinggi));?>" name="tinggi" type="text" class="form-control" id="tinggi" placeholder="">
                                      <span class="input-group-addon">cm</span>
                                    </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label"></label>
                                <small style="color:red;" class="col-lg-4"> *dihitung setelah packing</small>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Stok</label>
                                <div class="col-lg-4">
                                  <input onkeypress="return isNumberKey(event)" value="<?= htmlspecialchars(set_value('stok_produk',$produk->stok_produk));?>" name="stok_produk" type="text" class="form-control" id="stok_produk" placeholder="">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Harga</label>
                                <div class="col-lg-4">
                                  <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input onkeypress="return isNumberKey(event)" value="<?= htmlspecialchars(set_value('harga_produk',$produk->harga_produk));?>" name="harga_produk" type="text" class="form-control" id="harga_produk" placeholder="">
                                </div>
                                </div>
                              </div>
                              <div class="form-group" id="category-channel"  style="display:none;">
                                <label for="" class="col-lg-2 control-label">Channel</label>
                                <div class="col-lg-4">
                                  <select name="channel" class="form-control parent_channel" id="channel" data-sub="0" placeholder="">
                                    <option value="">-- Pilih Channel --</option>
                                    <option value="store">Store</option>
                                    <option value="lifestyle">Lifestyle</option>
                                    <option value="gadget">Gadget</option>
                                  </select>
                                </div>
                            </div>
                            <div class="channel-category"></div>

                              <div class="form-group select_channel">
                                <label for="" class="col-lg-2 control-label">Category</label>
                                <div class="col-lg-4">
                                  <input value="<?php 
                                  echo htmlspecialchars(strtolower(ucwords($produk->channel)))." >> ";
                                  $i=0;foreach ($kategorip as $kat) { $i++;
                                    if($i==1) {echo htmlspecialchars($kat->nama_kategori) ;} else{
                                      echo ' >> '. htmlspecialchars($kat->nama_kategori) ;
                                    }
                                  }
                                  ?>" name="" type="text" class="form-control" id="" placeholder="" disabled>
                                </div>
                                <button type="button" class="btn btn-lg edit_channel">Change</button>
                              </div>
                              <div class="form-group">

                                <label for="" class="col-lg-2 control-label">Image</label>
                                <div class="col-lg-8">
                                  <div class="row ui-sortable" id="photo-container">
                                    <?php $i=0;foreach($fotos as $foto) { ?>
                                    <div class="img-upload col-lg-2">
                                      <img src="<?=$foto->image;?>">
                                      <!--<div class="del-image"></div>-->
                                      <input class="photo_img_input" name="photo_img[<?=$i;?>]" value="<?=$foto->image;?>" type="hidden">                          
                                    </div>
                                    <?php $i++;} ?>
                                    <?php for($j=0;$j<$i;$j++){ ?>
                                    <!--<div disabled="disabled" style="z-index: 0; display: none;" id="add-photo<?=$j+1;?>" class="col-lg-2 add-foto"><span class="plus">+</span></div>-->
                                    <?php } ?>
                                    <?php for($k=0;$k<4-$i;$k++){ ?>
                                    <!--<div disabled="disabled" style="z-index: 0;" id="add-photo<?=$k+$j+1;?>" class="col-lg-2 add-foto"><span class="plus">+</span></div>-->
                                    <?php } ?>
                                  </div>
                                  <div class="row">
                                     <div class="col-lg-8" style="color: #888">
                                       * Maksimal ukuran foto adalah : <?php echo ini_get('upload_max_filesize') ?><br />
                                       * Foto harus square (panjang dan lebar harus sama)<br />
                                     </div>
                                  </div>
                                </div>
                              </div>
                              <div class="clearfix"></div>
                              <br><br>
                              <div style="text-align:center;">
                                <button class="btn btn-primary save-product" type="submit" name="simpan" value=1>Save</button>
                              </div>                      
                              
                              </div>
                            </form>            
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
<script type="text/javascript">
    $(document).ready(function (){
    /**
  AJAX CHANNEL
    **/
    $(document).on('change', '.parent_channel ', function(){
      var id=$(this).val();
      // alert(i);
      $.ajax({
          url: base_url + 'ajax/channel_kategori',
          type: 'POST',
          data: {id: id},
          dataType: 'html',
          success: function (data) {
            // alert(data); 
            $('.channel-category').empty();
            $('.channel-category').append(data);
          }
        });
    });

    /**
    END AJAX CHANNEL
    **/

    /**
  AJAX CATEGORY
    **/
    $(document).on('change', '.parent_category, .sub_category', function(){
      var id=$(this).val();
      var i=$(this).data().sub;
      var j=i+1;
      // alert(i);
      $.ajax({
          url: base_url + 'ajax/category',
          type: 'POST',
          data: {id: id, i: i, j: j},
          dataType: 'html',
          success: function (data) {
            // alert(data); 
            $('.sub-category-'+j).empty();
            $('.sub-category-'+j).append(data);
            $('.sub-category-'+j).append('<div class="sub-category-' + (j+1) +'"></div>');
          }
        });
    });

    /**
    END AJAX CATEGORY
    **/

});
    $('.edit_channel').click(function () {
      $('.select_channel').toggle();
      $('#category-channel').toggle();
    });
</script>
<?=$this->load->view('publik/ui2/footer')?>
<?php include 'upload.php'; ?>
