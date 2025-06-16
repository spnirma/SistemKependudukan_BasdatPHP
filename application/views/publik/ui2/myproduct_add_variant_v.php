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
                            <h3><span>Produk Varian</span></h3>
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
                        
                        
                              <form class="form-horizontal" method="post" action="<?=base_url();?>myproduct/upload_variant/<?= $produk->id_produk ?>">
                                <div class="form-group">
                                  <label for="" class="col-lg-2 control-label">Produk Parent</label>
                                  <div class="col-lg-4">
                                      <input value="<?php echo htmlspecialchars($produk->nama_produk) ?>" readonly="" name="nama_produk" type="text" class="form-control" id="nama_produk" placeholder="">
                                  </div>
                                </div>
                                  <div class="form-group">
                                  <label for="" class="col-lg-2 control-label">Nama Produk</label>
                                  <div class="col-lg-4">
                                    <input value="<?php echo set_value('nama_produk')?>" name="nama_produk" type="text" class="form-control" id="nama_produk" placeholder="">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="" class="col-lg-2 control-label">Deskripsi</label>
                                  <div class="col-lg-4">
                                    <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Stik Wortel merupakan camilan stik yang biasa ditemui di pasaran terbuat dari bahan standar yakni tepung .." rows=5><?php echo set_value('nama_produk', $produk->deskripsi)?></textarea>
                                  </div>
                                </div>
                                   <div class="form-group">
                                  <label for="" class="col-lg-2 control-label">Detail Paket</label>
                                  <div class="col-lg-4">
                                    <textarea name="detail_paket" class="form-control" id="deskripsi" placeholder="paket terdiri dari : 1 kotak bolu rasa Keju, 1 kotak bolu rasa Coklat." rows=5><?php echo set_value('detail_paket', $produk->detail_paket)?></textarea>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="" class="col-lg-2 control-label">Berat</label>
                                  <div class="input-group col-lg-4" style="padding: 0 10px;">
                                    <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('berat', $produk->berat)?>" name="berat" type="text" class="form-control" id="berat" placeholder="0.00">
                                    <span class="input-group-addon">Kg</span>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="" class="col-lg-2 control-label">Dimension</label>
                                  <div class="col-lg-9">
                                      <div class="input-group col-lg-3 pull-left">
                                        <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('panjang', $produk->panjang)?>" name="panjang" type="text" class="form-control" id="panjang" placeholder="panjang">
                                        <span class="input-group-addon">cm</span>
                                      </div>
                                      <div class="input-group col-lg-3 pull-left">
                                        <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('lebar'), $produk->lebar?>" name="lebar" type="text" class="form-control" id="lebar" placeholder="lebar">
                                        <span class="input-group-addon">cm</span>
                                      </div>
                                      <div class="input-group col-lg-3 pull-left">
                                        <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('tinggi', $produk->tinggi)?>" name="tinggi" type="text" class="form-control" id="tinggi" placeholder="tinggi">
                                        <span class="input-group-addon">cm</span>
                                      </div>
                                    <small style="color:red;"> *dihitung setelah packing</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label for="" class="col-lg-2 control-label">Stok</label>
                                  <div class="col-lg-4">
                                    <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('stok_produk', $produk->stok_produk)?>" name="stok_produk" type="text" class="form-control" id="stok_produk" placeholder="">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="" class="col-lg-2 control-label">Harga</label>
                                  <div class="col-lg-4">
                                    <div class="input-group">
                                    <span class="input-group-addon">Rp</span>
                                    <input onkeypress="return isNumberKey(event)" value="<?php echo set_value('harga_produk', $produk->harga_produk)?>" name="harga_produk" type="text" class="form-control" id="harga_produk" placeholder="15000">
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="" class="col-lg-2 control-label">Gambar</label>
                                  <div class="col-lg-8">
                                    <div class="row" id="photo-container">
                                      <div id="add-photo1" class="col-lg-2 add-foto"><span class="plus">+</span></div>
                                      <div id="add-photo2" class="col-lg-2 add-foto"><span class="plus">+</span></div>
                                      <div id="add-photo3" class="col-lg-2 add-foto"><span class="plus">+</span></div>
                                      <div id="add-photo4" class="col-lg-2 add-foto"><span class="plus">+</span></div>
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
<?=$this->load->view('publik/ui2/footer')?>
<?php include 'upload.php'; ?>
