<?php include 'header.php'; ?>
      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1>Add Acara</h1>
            <ol class="breadcrumb">
              <li><a href="<?=admin_url();?>dashboard">Dashboard</a></li>
              <li><a href="#" onclick="window.history.back();return false;">Acara</a></li>
              <li class="active">Add</li>
            </ol>
            <?php if(!empty($success) && $success=='success'){ ?>
            <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Success
            </div>
            <?php } ?>

            <?php if(!empty($error) && $error!=''){ ?>
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?=$error;?>
            </div>
            <?php } ?>
          </div>
        </div><!-- /.row -->
            <div class="row">
              <div class="col-lg-12">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Banner</label>
                        <div class="col-lg-4">
                          <img src="<?= $data['banner'] ? base_url($data['banner']) : base_url("asset/img/no-images.png")  ?>" style="height:100px;" id="banner_upload_preview">
                          <input name="banner_upload" type="file" class="form-control" id="banner_upload"></input>
                          <script>
                          $("#banner_upload").change(function(){
                            var file = $("#banner_upload")[0].files[0];
                            var reader = new FileReader();                                       
                            reader.onload = function(e) {
                              $("#banner_upload_preview").attr("src", e.target.result);
                            }
                            reader.readAsDataURL(file);
                          })
                          </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Jenis</label>
                        <div class="col-lg-4">
                        <select name="jenis" type="text" class="form-control" id="jenis">
                          <option value="">-Pilih Jenis-</option>
                          <?php foreach (['SEMINAR', 'TALKSHOW', 'MAINSTAGE', 'OPCER', 'BUSINESS COACHING', 'COACHING CLINIC' , 'EJAVEC', 'BM BANK', 'BM ZISWAF', 'INFOGRAFIS', 'PHOTO GALLERY', 'DEMO MASAK dan MAKE-UP','VIRTUAL FASHION SHOW','CLOSCER','1 ON 1 CONSULTATION'] as $v) : ?>
                            <option value="<?=$v?>" <?=set_value('jenis', $data['jenis']) == $v ? "selected='selected'" : "" ?>><?=$v?></option>
                          <?php endforeach ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Tanggal</label>
                        <div class="col-lg-4">
                        <input value="<?=set_value('tgl', $data['tgl'])?>" name="tgl" type="text" class="form-control tanggal" id="tgl" placeholder="Tanggal">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Waktu</label>
                        <div class="col-lg-2">
                        <input value="<?=set_value('jam_mulai', $data['jam_mulai'])?>" name="jam_mulai" type="time" class="form-control" id="jam_mulai" placeholder="Jam Mulai">
                        </div>
                        <div class="col-lg-2">
                        <input value="<?=set_value('jam_selesai', $data['jam_selesai'])?>" name="jam_selesai" type="time" class="form-control" id="jam_selesai" placeholder="Jam Selesai">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Youtube</label>
                        <div class="col-lg-4">
                        <input value="https://www.youtube.com/watch?v=<?=set_value('youtube', $data['youtube'])?>" name="youtube" type="text" class="form-control" id="youtube" placeholder="Youtube">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Judul Acara</label>
                        <div class="col-lg-4">
                        <input value="<?=set_value('judul_acara', str_replace('\"','"',$data['judul_acara']))?>" name="judul_acara" type="text" class="form-control" id="judul_acara" placeholder="Judul Acara">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Tipe Acara</label>
                        <div class="col-lg-4">
                        <input value="<?=set_value('tipe_acara', $data['tipe_acara'])?>" name="tipe_acara" type="text" class="form-control" id="tipe_acara" placeholder="Tipe Acara">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Deskripsi (ID)</label>
                        <div class="col-lg-4">
                        <textarea name="deskripsi" type="text" class="form-control rich-editor" id="deskripsi" placeholder="Deskripsi"><?=set_value('deskripsi', $data['deskripsi'])?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Deskripsi (EN)</label>
                        <div class="col-lg-4">
                        <textarea col="30" name="deskripsi_en" type="text" class="form-control rich-editor" id="deskripsi_en" placeholder="Deskripsi"><?=set_value('deskripsi_en', $data['deskripsi_en'])?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Zoom</label>
                        <div class="col-lg-4">
                        <textarea name="zoom" type="text" class="form-control" id="zoom" placeholder="zoom"><?=set_value('zoom', $data['zoom'])?></textarea>
<!--                        
						<input name="zoom" type="text" class="form-control" id="zoom" placeholder="Zoom" value="<?=set_value('zoom', $data['zoom'])?>">
-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label"></label>
                        <div class="col-lg-4">
                        <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
              </div>
            </div><!-- /.row -->

      </div><!-- /#page-wrapper -->
<?php include 'footer.php'; ?>
<?php $this->load->view('admin/tinymce_by_class') ?>
<script>
setInterval(function(){
  $("#deskripsi_tbl").css("width", "100%");
}, 300);
</script>