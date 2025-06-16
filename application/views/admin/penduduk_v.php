<?php include 'header.php'; ?>
<div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1>Daftar Penduduk <?= get('jenis')?></h1>
            <ol class="breadcrumb" style="height:30px;">
              <li><a href="<?=admin_url()?>">Dashboard</a></li>
              <li class="active">Penduduk</li>
              <div class="pull-right">
              <?php //if($this->auth->isAllowed($user, 'acara_add')) : ?>
				<?php if($user->username=='admin1') { ?>
					<a href="<?=admin_url();?>penduduk/add" type="button" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Tambah Penduduk</button></a>
				<?php } ?>
              <?php //endif; ?>
              </div>
            </ol>
            <?php if(!empty($alert) && $alert=='success'){ ?>
            <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Data berhasil dihapus.
            </div>
            <?php } ?>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
           
            <br>
            <div class="table-responsive">
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Penduduk</th>
                    <th>Usia</th>
                    <th>Jenis Kelamin</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=$offset;foreach ($datas as $data) { $i++;?>
                    <td><?=$i;?></td>
                    <td>
                        <?= htmlspecialchars($data->nama) ;?><br>
                    </td>
                    <td>
                        <?= htmlspecialchars($data->usia) ;?><br>
                    </td>
                    <td><?= htmlspecialchars($data->jenis_kelamin) ;?></td>
                    <td style="width:200px;">
                        <!--
						<a href="<?=admin_url();?>acara/classroom_video/<?=$data->id;?>" type="button" class="btn btn-primary btn-xs"><i class="fa fa-video"></i> Video</a>
                        <a href="<?=admin_url();?>acara/classroom_gallery/<?=$data->id;?>" type="button" class="btn btn-primary btn-xs"><i class="fa fa-picture"></i> Gallery</a><br>
                        <a href="<?=admin_url();?>acara/classroom_doc/<?=$data->id;?>" type="button" class="btn btn-primary btn-xs"><i class="fa fa-doc"></i> Document</a>
                        <a href="<?=admin_url();?>acara/classroom_qna/<?=$data->id;?>" type="button" class="btn btn-primary btn-xs"><i class="fa fa-qna"></i> Q &amp; A</a><br>
                        <?php if (!$data->status_default) : ?>
                        <a href="<?=admin_url();?>acara/setdefault/<?=$data->id;?>" type="button" class="btn btn-success btn-xs"><i class="fa fa-key"></i> Set as Default</a>
                        <?php endif ?>
                        -->
						<?php if($user->username=='admin1') { ?>
							<a href="<?=admin_url();?>penduduk/edit/<?=$data->id_penduduk;?>" type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a>
						<?php } ?>
						<?php if($user->username=='admin2') { ?>
							<a href="<?=admin_url();?>penduduk/setdelete/<?=$data->id_penduduk;?>" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</a>
						<?php } ?>
                    </td> 
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?=$paginator?>
          </div>
        </div><!-- /.row -->
      </div><!-- /#page-wrapper -->
<?php include 'footer.php'; ?>
