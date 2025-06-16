<?php include 'header.php'; ?>
      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1>Tambah Penduduk</h1>
            <ol class="breadcrumb">
              <li><a href="<?=admin_url();?>dashboard">Dashboard</a></li>
              <li><a href="#" onclick="window.history.back();return false;">Penduduk</a></li>
              <li class="active">Tambah</li>
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
                        <label for="" class="col-lg-2 control-label">Nama Penduduk</label>
                        <div class="col-lg-4">
                        <input required value="<?=set_value('nama', str_replace('\"','"',$data['nama']))?>" name="nama" type="text" class="form-control" id="nama" placeholder="Nama Penduduk">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Usia</label>
                        <div class="col-lg-4">
                        <input required value="<?=set_value('usia', str_replace('\"','"',$data['usia']))?>" name="usia" type="number" class="form-control" id="usia" placeholder="Usia Penduduk" max-length="3">
                        </div>
                    </div>					
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Jenis Kelamin</label>
                        <div class="col-lg-4">
                        <select required name="jenis_kelamin" type="text" class="form-control" id="jenis_kelamin">
                          <option value="">-Pilih Jenis-</option>
                          <option value="Perempuan" <?=set_value('jenis_kelamin', $data['jenis_kelamin']) == "Perempuan" ? "selected='selected'" : "" ?>>Perempuan</option>
                          <option value="Laki-laki" <?=set_value('jenis_kelamin', $data['jenis_kelamin']) == "Laki-laki" ? "selected='selected'" : "" ?>>Laki-laki</option>
                        </select>
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
