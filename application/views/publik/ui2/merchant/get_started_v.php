<?=$this->load->view('publik/ui2/header')?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<style type="text/css">
span.plus {
  background: rgb(237, 237, 237);
  padding: 34px;
  border-radius: 13px;
}
div#photo-container {
  padding: 38px 0px;
}
ol.progtrckr {
    margin: 0;
    padding: 0;
    list-style-type none;
}

ol.progtrckr li {
    display: inline-block;
    text-align: center;
    line-height: 3em;
}
ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }

ol.progtrckr li.progtrckr-done {
    color: black;
    border-bottom: 4px solid yellowgreen;
}
ol.progtrckr li.progtrckr-todo {
    color: silver; 
    border-bottom: 4px solid silver;
}
ol.progtrckr li:after {
    content: "\00a0\00a0";
}
ol.progtrckr li:before {
    position: relative;
    bottom: -2.5em;
    float: left;
    left: 50%;
    line-height: 1em;
}
ol.progtrckr li.progtrckr-done:before {
    content: "\2713";
    color: white;
    background-color: yellowgreen;
    height: 1.2em;
    width: 1.2em;
    line-height: 1.2em;
    border: none;
    border-radius: 1.2em;
}
ol.progtrckr li.progtrckr-todo:before {
    content: "\039F";
    color: silver;
    background-color: white;
    font-size: 1.5em;
    bottom: -1.6em;
}

</style>
        <section class="main">

            <div class="featured-list container">

               <div class="row">
                    <div class="col-xs-12">
                        <ol class="progtrckr" data-progtrckr-steps="3">
                            <li class="progtrckr-done">Merchant Profile</li>
                            <li class="progtrckr-done">Upload Produk</li>
                            <li class="progtrckr-todo">Verifikasi</li>
                        </ol>
                        <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Upload Produk</span></h3>
                            <hr>
                            <div class="checkout_step1">
                                <?php if($success=='success'){ ?>
                                <div class='alert-success alert-dismissable' style="padding:16px 0; font-size:16px;" align="center">
                                    Produk berhasil ditambahkan, lanjutkan ke tahap pengajuan verifikasi
                                </div>
                                <?php } ?>

                                <?php if($error!=''){ ?>
                                <div class="alert alert-danger alert-dismissable">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  <?=$error;?>
                                </div>
                            <?php } ?>
                           <?php if($success!='success'): ?>
                            <div class="alamat_profil">
                                
                                <form class="form-horizontal" method="post" action="">
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Nama Produk</label>
                                        <div class="col-lg-4">
                                          <input name="nama_produk" type="text" class="form-control" id="nama_produk" placeholder="" value="<?php echo set_value('nama_produk')?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Deskripsi</label>
                                        <div class="col-lg-4">
                                          <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Stik Wortel merupakan camilan stik yang biasa ditemui di pasaran terbuat dari bahan standar yakni tepung .." rows=5><?php echo set_value('deskripsi')?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Detail Paket</label>
                                        <div class="col-lg-4">
                                          <textarea name="detail_paket" class="form-control" id="deskripsi" placeholder="paket terdiri dari : 1 kotak bolu rasa Keju, 1 kotak bolu rasa Coklat." rows=5><?php echo set_value('detail_paket')?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Berat</label>
                                        <div class="input-group col-lg-4" style="padding: 0 10px;">
                                          <input name="berat" type="text" class="form-control" id="berat" placeholder="0.00" value="<?php echo set_value('berat')?>">
                                          <span class="input-group-addon">Kg</span>
                                        </div>
                                        <small class="col-lg-4 control-label" style="color:red;"> *berat setelah dikemas</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Dimension</label>
                                        <div class="col-lg-9">
                                            <div class="input-group col-lg-3 pull-left">
                                              <input name="panjang" type="text" class="form-control" id="panjang" placeholder="panjang" value="<?php echo set_value('panjang')?>">
                                              <span class="input-group-addon">cm</span>
                                            </div>
                                            <div class="input-group col-lg-3 pull-left">
                                              <input name="lebar" type="text" class="form-control" id="lebar" placeholder="lebar" value="<?php echo set_value('lebar')?>">
                                              <span class="input-group-addon">cm</span>
                                            </div>
                                            <div class="input-group col-lg-4">
                                              <input name="tinggi" type="text" class="form-control" id="tinggi" placeholder="tinggi" value="<?php echo set_value('tinggi')?>">
                                              <span class="input-group-addon">cm</span>
                                            </div>
                                            <br>
                                        </div>
                                        <small class="col-lg-4 control-label"  style="color:red;"> *dimensi setelah dikemas</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Stok</label>
                                        <div class="col-lg-4">
                                          <input onkeypress="return isNumberKey(event)" name="stok_produk" type="text" class="form-control" id="stok_produk" placeholder="" value="<?php echo set_value('stok_produk')?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Harga</label>
                                        <div class="col-lg-4">
                                          <div class="input-group">
                                          <span class="input-group-addon">Rp</span>
                                          <input onkeypress="return isNumberKey(event)" name="harga_produk" type="text" class="form-control" id="harga_produk" placeholder="" value="<?php echo set_value('harga_produk')?>">
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
                                    <br><br>
                                    <div style="text-align:center;">
                                        <button class="btn btn-primary save-product" type="submit" name="simpan" value=1>Simpan</button>
                                    </div>
                                
                                </form>  
                                
                            </div>       
                           <?php endif; ?>
                            <hr />

                            <a href="<?php echo base_url('merchant/verification?notif=new')?>" class="btn btn-lanjut pull-right">Lanjutkan</a>
                            <br />
                            <br>
                        </div>
                    </div>
                </div>

        </section>
<script type="text/javascript">

    

     function isNumberKey(evt)
    {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if ((charCode > 47 && charCode < 58 ) || charCode == 44 || charCode == 46 || charCode == 8)
                return true;

         return false;
    }

    $(window).load(function(){
        $("ol.progtrckr").each(function(){
            $(this).attr("data-progtrckr-steps", 
                         $(this).children("li").length);
        });
    });

    $("#tgl_lahir").datepicker({
        dateFormat: "dd-mm-yy"
    });

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
