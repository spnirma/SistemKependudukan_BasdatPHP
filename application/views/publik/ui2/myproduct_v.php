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
                            <a style="margin-top:40px;margin-right:20px;" href="<?=base_url();?>myproduct/upload" class="btn btn-lanjut pull-right">Unggah Produk Baru</a>
                            <a style="margin-top:40px;margin-right:10px;" href="<?=base_url();?>myproduct/update_request" class="btn btn-lanjut pull-right">Daftar Request Update</a>
                            <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Produk Saya</span></h3>
                            <hr>
                            <br>
                            <form id="mpsearch" method="get" action="<?=base_url()?>myproduct" class="form-inline" role="form">
                            <div class="pull-right cari_produk">
                                <select class="form-control" name="cat" onchange="this.form.submit()">
                                  <option value="">[Semua]</option>
                                  <?php $this->produk_m->get_select_category_merchant(0, 0 , $kategori, $produk_array); ?> 
                                </select>

                                <div class="form-group">
                                    <input name="search" type="text" class="form-control" id="cari" placeholder="Nama produk" value="<?=(isset($search))? htmlspecialchars($search) :'';?>">
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg">Cari</button>
                            </div>
                            
                            <div class="status_produk">
                                <ul class="nav nav-tabs" data-toggle="buttons">
                                  <li class="btn <?=($stat=='all')?'active':'';?>">
                                    <input type="radio" name="stat" value="all" onchange="this.form.submit()" <?=($stat=='all')?'checked':'';?>> Semua 
                                  </li>
                                  <li class="btn <?=($stat=='verified')?'active':'';?>">
                                    <input type="radio" name="stat" value="verified" onchange="this.form.submit()" <?=($stat=='verified')?'checked':'';?>> Verified 
                                  </li>
                                  <li class="btn <?=($stat=='moderasi')?'active':'';?>">
                                    <input type="radio" name="stat" value="moderasi" onchange="this.form.submit()" <?=($stat=='moderasi')?'checked':'';?>> Moderasi 
                                  </li>
                                  <li class="btn <?=($stat=='unverified')?'active':'';?>">
                                    <input type="radio" name="stat" value="unverified" onchange="this.form.submit()" <?=($stat=='unverified')?'checked':'';?>> Unverified
                                  </li>
                                </ul>
                            </div>
                            </form>

                            <div class="clearfix"></div>
                            <div class="table-responsive garis_tab">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th></th>
                                        <th width="100px">Nama</th>
                                        <th width="100px">Kategori</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                        <th>Dilihat</th>
                                        <th>Suka</th>
                                        <th>Variant</th>
                                        <th width="30px">Log Harga</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="myproduct_list">
                                    <?php
                                    $i = $offset;
                                    foreach ($produk as $p)
                                    {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td>
                                                <img src="<?=base_url();?>asset/pict.php?src=<?=$p->image;?>&w=100&h=100&z=1">
                                            </td>
                                            <td><?= htmlspecialchars($p->nama_produk) ;?></td>
                                            <td><?= htmlspecialchars($this->produk_m->get_kategori($p->id_produk)) ;?></td>
                                            <td><?=$p->stok_produk;?></td>
                                            <td><?php 
                                                if($p->publish==0) echo 'Moderasi';
                                                else if($p->publish==1) echo 'Verified';
                                                else if($p->publish==2) echo 'Un Verified';
                                            ?></td>
                                            <td><?=$p->viewed;?></td>
                                            <td><?=$p->loved?></td>
                                            <td>
                                                <a href="#" type="button" class="btn btn-success btn-xs" data-toggle='modal' data-target='#ModVP<?= $p->id_produk ?>'>Lihat (<?= $this->produk_m->count_produk_varian_user($p->id_produk); ?>)</a>
                                                
                                                <div style="padding:10%;" class="modal fade" id="ModVP<?= $p->id_produk ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog-variant">
                                                  <div class="modal-content" style="padding:2%;">
                                                    <div class="modal-header-variant">
                                                      <h3 class="modal-title-variant" id="myModalLabel">Produk Variant</h3>
                                                    </div>
                                                    <div class="modal-body-variant">
                                                      <div class="table-responsive">
                                                        <table class="table table-hover table-striped">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Variant</th>
                                                                <th style="text-align:right">Stok</th>
                                                                <th style="text-align:right">Diskon (%)</th>
                                                                <th style="text-align:right">Harga Merchant (Rp)</th>
                                                                <th style="text-align:right">Harga Cipika (Rp)</th>
                                                                <th style="text-align:center">Log Harga</th>
                                                                <th style="text-align:right">Status</th>
                                                                <th style="text-align:right">Action</th>
                                                            </tr>
                                                            <?php 

                                                                $produk_variant = $this->produk_m->get_produk_varian_user($p->id_produk);
                                                                $num = 0;
                                                                foreach ($produk_variant as $variant){
                                                                    $num++;
                                                            ?>
                                                            <tr>
                                                                <td><?=$num?></td>
                                                                <td><?= htmlspecialchars($variant->nama_produk) ?></td>
                                                                <td style="text-align:right"><?= $variant->stok_produk ?></td>
                                                                <td style="text-align:right"><?= $variant->diskon ?></td>
                                                                <td style="text-align:right"><?= format_uang($variant->harga_produk) ?></td>
                                                                <td style="text-align:right"><?= format_uang($variant->harga_jual) ?></td>
                                                                <td style="text-align:center">
                                                                    <a href="#" type="button" class="btn btn-success btn-xs" data-toggle='modal' data-target='#ModVLH<?= $variant->id_produk ?>'>Lihat</a>
                                                                    <div style="padding:15%" class="modal fade" id="ModVLH<?= $variant->id_produk ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog-logharga" style="text-align:left">
                                                                            <div class="modal-content" style="padding:2%;">
                                                                                <div class="modal-header-logharga">
                                                                                    <h3 class="modal-title-logharga" id="myModalLabel">Log Harga</h3>
                                                                                </div>
                                                                                <div class="modal-body-logharga">
                                                                                    <div class="table-responsive">
                                                                                        <span style="font-style:italic">Harga Produk Varian Efektif: Rp <?= format_uang($variant->harga_produk) ?></span>
                                                                                        <table class="table table-hover table-striped">
                                                                                            <tr>
                                                                                                <th rowspan="2">Tanggal</th>
                                                                                                <th style="text-align:center" colspan="3">Sebelumnya</th>
                                                                                                <th rowspan="2"></th>
                                                                                                <th style="text-align:center" colspan="3">Sesudahnya</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th style="text-align:right">Harga Produk (Rp)</th>
                                                                                                <th style="text-align:right">Diskon (%)</th>
                                                                                                <th style="text-align:right">Hak Merchant (Rp)</th>         
                                                                                                <th style="text-align:right">Harga Produk (Rp)</th>
                                                                                                <th style="text-align:right">Diskon (%)</th>
                                                                                                <th style="text-align:right">Hak Merchant (Rp)</th>
                                                                                            </tr>
                                                                                            <?php 
                                                                                                $log_harga = $this->produk_m->get_list_logharga_byid($variant->id_produk);
                                                                                                foreach ($log_harga as $harga){
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td style="text-align:left"><?= $harga->date_added ?></td>
                                                                                                <td style="text-align:right"><?= format_uang($harga->harga_merchant_before) ?></td>
                                                                                                <td style="text-align:right"><?= format_uang($harga->diskon_before) ?></td>
                                                                                                <td style="text-align:right"><?= format_uang($harga->harga_merchant_before - ($harga->harga_merchant_before * $harga->diskon_before / 100)) ?></td>
                                                                                                <td></td>
                                                                                                <td style="text-align:right"><?= format_uang($harga->harga_merchant_after) ?></td>
                                                                                                <td style="text-align:right"><?= format_uang($harga->diskon_after) ?></td>
                                                                                                <td style="text-align:right"><?= format_uang($harga->harga_merchant_after - ($harga->harga_merchant_after * $harga->diskon_after / 100)) ?></td>
                                                                                                
                                                                                            </tr>
                                                                                            <?php
                                                                                                }
                                                                                            ?>
                                                                                        </table>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-default" onclick="$('#ModVLH<?= $variant->id_produk ?>').modal('hide')">Close</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="text-align:right"><?php 
                                                                    if($variant->publish==0) echo 'Moderasi';
                                                                    else if($variant->publish==1) echo 'Verified';
                                                                    else if($variant->publish==2) echo 'Un Verified'; ?></td>
                                                                <td style="text-align:right">
                                                                    <a href="<?=base_url();?>myproduct/edit/<?=md5($variant->id_produk);?>/<?=md5($this->session->userdata('member')->id_user);?>" type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                                                    <?php if($variant->publish==1): ?>
                                                                    <a href="#" type="button" class="btn btn-warning btn-xs" data-toggle='modal' data-target='#ModUnv<?= $variant->id_produk ?>'>Unverify</a>
                                                                    <div style="padding:15%" class="modal fade" id="ModUnv<?= $variant->id_produk ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog-logharga" style="text-align:left">
                                                                            <div class="modal-content" style="padding:2%;">
                                                                                <div class="modal-header-logharga">
                                                                                    <h3 class="modal-title-logharga" id="myModalLabel">Konfirmasi</h3>
                                                                                </div>
                                                                                <form method="POST" action="<?= base_url('myproduct/unverify_variant/'.$variant->id_produk) ?>" >
                                                                                <div class="modal-body-logharga">
                                                                                    <div class="form-group">
                                                                                        <label>Alasan Unverify</label>
                                                                                        <div>
                                                                                            <textarea name="alasan" class="form-control" id="alamat" placeholder="Alasan Unverify"></textarea>
                                                                                        </div>
                                                                                      </div>
                                                                                    <div class="modal-footer">
                                                                                        <input type="submit" class="btn btn-primary" value="Unverify">
                                                                                        <button type="button" class="btn btn-default" onclick="$('#ModUnv<?= $variant->id_produk ?>').modal('hide')">Close</button>
                                                                                    </div>
                                                                                </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php endif;?>
                                                                    <a onclick="return confirm('Are you sure delete this product?')" class="btn btn-danger btn-xs"  href="<?=base_url();?>myproduct/delete/<?=md5($variant->id_produk);?>/<?=md5($this->session->userdata('member')->id_user);?>">Delete</a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                }
                                                            ?>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <a href="<?=base_url();?>myproduct/upload_variant/<?=$p->id_produk;?>" class="btn btn-primary">Add Variant</a>
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </td>

                                            <td>
                                                <a href="#" type="button" class="btn btn-primary btn-xs" data-toggle='modal' data-target='#ModLH<?= $p->id_produk ?>'>Lihat</a>
                                                <div style="padding:10%;" class="modal fade" id="ModLH<?= $p->id_produk ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog-logharga">
                                                      <div class="modal-content" style="padding:2%;">
                                                        <div class="modal-header-logharga">
                                                          <h3 class="modal-title-logharga" id="myModalLabel">Log Harga</h3>
                                                        </div>
                                                        <div class="modal-body-logharga">
                                                          <div class="table-responsive">
                                                            <span style="font-style:italic">Harga Produk Efektif: Rp <?= format_uang($p->harga_produk) ?></span>
                                                            <table class="table table-hover table-striped">
                                                                <tr>
                                                                    <th rowspan="2">Tanggal</th>
                                                                    <th style="text-align:center" colspan="3">Sebelumnya</th>
                                                                    <th rowspan="2"></th>
                                                                    <th style="text-align:center" colspan="3">Sesudahnya</th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align:right">Harga Produk (Rp)</th>
                                                                    <th style="text-align:right">Diskon (%)</th>
                                                                    <th style="text-align:right">Hak Merchant (Rp)</th>         
                                                                    <th style="text-align:right">Harga Produk (Rp)</th>
                                                                    <th style="text-align:right">Diskon (%)</th>
                                                                    <th style="text-align:right">Hak Merchant (Rp)</th>
                                                                </tr>
                                                                <?php 
                                                                    $log_harga = $this->produk_m->get_list_logharga_byid($p->id_produk);
                                                                    foreach ($log_harga as $harga){
                                                                ?>
                                                               <tr>
                                                                    <td style="text-align:left"><?= $harga->date_added ?></td>
                                                                    <td style="text-align:right"><?= format_uang($harga->harga_merchant_before) ?></td>
                                                                    <td style="text-align:right"><?= format_uang($harga->diskon_before) ?></td>
                                                                    <td style="text-align:right"><?= format_uang($harga->harga_merchant_before - ($harga->harga_merchant_before * $harga->diskon_before / 100)) ?></td>
                                                                    <td></td>
                                                                    <td style="text-align:right"><?= format_uang($harga->harga_merchant_after) ?></td>
                                                                    <td style="text-align:right"><?= format_uang($harga->diskon_after) ?></td>
                                                                    <td style="text-align:right"><?= format_uang($harga->harga_merchant_after - ($harga->harga_merchant_after * $harga->diskon_after / 100)) ?></td>
                                                                </tr>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                              </div>
                                            </td>

                                            <td>
                                                <a title="edit" class="btn btn-warning btn-xs" href="<?=base_url();?>myproduct/edit/<?=md5($p->id_produk);?>/<?=md5($this->session->userdata('member')->id_user);?>">Edit</i></a>
                                                <?php if($p->publish==1): ?>
                                                <a href="#" type="button" class="btn btn-warning btn-xs" data-toggle='modal' data-target='#ModUnv<?= $p->id_produk ?>'>Unverify</a>
                                                <div style="padding:15%" class="modal fade" id="ModUnv<?= $p->id_produk ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog-logharga" style="text-align:left">
                                                        <div class="modal-content" style="padding:2%;">
                                                            <div class="modal-header-logharga">
                                                                <h3 class="modal-title-logharga" id="myModalLabel">Konfirmasi</h3>
                                                            </div>
                                                            <form method="POST" action="<?= base_url('myproduct/unverify_variant/'.$p->id_produk) ?>" >
                                                            <div class="modal-body-logharga">
                                                                <div class="form-group">
                                                                    <label>Alasan Unverify</label>
                                                                    <div>
                                                                        <textarea name="alasan" class="form-control" id="alamat" placeholder="Alasan Unverify"></textarea>
                                                                    </div>
                                                                  </div>
                                                                <div class="modal-footer">
                                                                    <input type="submit" class="btn btn-primary" value="Unverify">
                                                                    <button type="button" class="btn btn-default" onclick="$('#ModUnv<?= $p->id_produk ?>').modal('hide')">Close</button>
                                                                </div>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endif;?>
                                                <a title="hapus" onclick="return confirm('Are you sure delete this product?')" class="btn btn-danger btn-xs"  href="<?=base_url();?>myproduct/delete/<?=md5($p->id_produk);?>/<?=md5($this->session->userdata('member')->id_user);?>">Delete</a>
                                                <a href="#" type="button" class="btn btn-success btn-xs" data-toggle='modal' data-target='#ModAr<?= $p->id_produk ?>'>Area</a>
                                                
                                                <div style="padding:10%;" class="modal fade" id="ModAr<?= $p->id_produk ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                  <div class="modal-content" style="padding:2%;">
                                                    <div class="modal-header-variant">
                                                      <h3 class="modal-title-variant" id="myModalLabel">Area Pengiriman Produk</h3>
                                                    </div>
                                                    <div class="modal-body-variant">
                                                      <div class="table-responsive">
                                                        <?php
                                                            if ($p->area_produk == 0){
                                                                $type = "Default area pengiriman";
                                                            } elseif ($p->area_produk == 1) {
                                                                $type = "Customized";
                                                            } elseif ($p->area_produk == 2) {
                                                                $type = "Ke semua Area";
                                                            }
                                                        ?>
                                                        <table class="table table-hover table-striped">
                                                            <tr>
                                                                <th>Nama Produk</th>
                                                                <th>Area Pengiriman</th>
                                                                <th>Opsi</th>
                                                            </tr>
                                                            <tr>
                                                                <td><?= htmlspecialchars($p->nama_produk) ?></td>
                                                                <td><?= $type ?></td>
                                                                <td><a href="<?= base_url('myproduct/area_produk/'.$p->id_produk) ?>" type="button" class="btn btn-success btn-xs">Edit</a></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>

                                                </ul>
                                            </td>
    <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
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
            <nav class="container">
              <?php
                echo $paginator_new;
                ?>
            </nav>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
