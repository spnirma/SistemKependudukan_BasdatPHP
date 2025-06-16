<?=$this->load->view('publik/ui2/header')?>
<style>
span.plus {
  background: rgb(237, 237, 237);
  padding: 34px;
  border-radius: 13px;
}
div#photo-container {
  padding: 38px 0px;
}
</style>
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
                            <h3><span>Upload Produk</span></h3>
                            <hr>
                            <?php if($success!=''){ ?>
                            <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$success;?>
                            </div>
                            <?php } ?>

                            <?php if($error!=''){ ?>
                            <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$error;?>
                            </div>
                            <?php } ?>
                        
                            
                            <form class="form-horizontal" method="post" action="<?=base_url();?>myproduct/upload">
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Nama Produk</label>
                                <div class="col-lg-8">
                                  <input value="<?php echo set_value('nama_produk')?>" name="nama_produk" type="text" class="form-control" id="nama_produk" placeholder="">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Deskripsi</label>
                                <div class="col-lg-9">
                                  <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Stik Wortel merupakan camilan stik yang biasa ditemui di pasaran terbuat dari bahan standar yakni tepung .." rows=5><?php echo set_value('deskripsi')?></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Detail Paket</label>
                                <div class="col-lg-9">
                                  <textarea name="detail_paket" class="form-control" id="deskripsi" placeholder="paket terdiri dari : 1 kotak bolu rasa Keju, 1 kotak bolu rasa Coklat." rows=5><?php echo set_value('detail_paket')?></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Berat</label>
                                <div class="input-group col-lg-4" style="padding: 0 10px;">
                                  <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('berat')?>" name="berat" type="text" class="form-control" id="berat" placeholder="0.00">
                                  <span class="input-group-addon">Kg</span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label"></label>
                                <div class="input-group col-lg-4" style="padding: 0 10px;">
                                 <small style="color:red;"> *dihitung setelah packing</small>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Dimension</label>
                                <div class="col-lg-9">
                                    <div class="input-group col-lg-3 pull-left">
                                      <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('panjang')?>" name="panjang" type="text" class="form-control" id="panjang" placeholder="panjang">
                                      <span class="input-group-addon">cm</span>
                                    </div>
                                    <div class="input-group col-lg-3 pull-left">
                                      <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('lebar')?>" name="lebar" type="text" class="form-control" id="lebar" placeholder="lebar">
                                      <span class="input-group-addon">cm</span>
                                    </div>
                                    <div class="input-group col-lg-3 pull-left">
                                      <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('tinggi')?>" name="tinggi" type="text" class="form-control" id="tinggi" placeholder="tinggi">
                                      <span class="input-group-addon">cm</span>
                                    </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label"></label>
                                <div class="input-group col-lg-4" style="padding: 0 10px;">
                                 <small style="color:red;"> *dihitung setelah packing</small>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Stok</label>
                                <div class="col-lg-4">
                                  <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('stok_produk')?>" name="stok_produk" type="text" class="form-control" id="stok_produk" placeholder="">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Harga</label>
                                <div class="col-lg-4">
                                  <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('harga_produk')?>" name="harga_produk" type="text" class="form-control" id="harga_produk" placeholder="15000">
                                  </div>
                                </div>
                              </div>
                              
                              <div class="form-group" id="category-channel">
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

                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Gambar</label>
                                <div class="col-lg-8">
                                  <div class="row" id="photo-container">
                                    <div id="add-photo1" class="col-lg-2 add-foto" style="height:120px width:80px"><span class="plus">+</span></div>
                                    <div id="add-photo2" class="col-lg-2 add-foto" style="height:120px width:80px"><span class="plus">+</span></div>
                                    <div id="add-photo3" class="col-lg-2 add-foto" style="height:120px width:80px"><span class="plus">+</span></div>
                                    <div id="add-photo4" class="col-lg-2 add-foto" style="height:120px width:80px"><span class="plus">+</span></div>
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

                              <div class="row form-group">
                                <div class="col-md-2">
                                    <label class="control-label">Area Pengiriman</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" name="area_produk" value='0' checked class="radio_area"> Default area pengiriman <br>
                                    <input type="radio" name="area_produk" value='2' class="radio_area"> Ke semua Area <br>
                                </div>
                              </div>
                              <br><br>
                              <div style="text-align:center;">
                                <button class="btn btn-primary save-product" type="submit" name="simpan" value=1>Simpan</button>
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

</script>
<?=$this->load->view('publik/ui2/footer')?>
<?=$this->load->view('publik/ui2/upload')?>
