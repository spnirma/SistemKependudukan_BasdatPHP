
<?=$this->load->view('publik/ui2/header')?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
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
                            <form id="mpsearch" method="get" action="<?=base_url()?>merchant/orders" class='form-inline' role="form">
                            <button type="submit" value='1' name='export'  class="btn btn-lanjut pull-right" style="margin-top:20px;margin-right:20px;">Export</button>
                            <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Kelola Order</span></h3>
                            <hr>
                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $error?>
                                </div>
                            <?php endif; ?>
                                <div>
                                    <?php 
                                      $pengiriman = '';
                                      if(!empty($_GET['pengiriman'])) $pengiriman = htmlspecialchars($_GET['pengiriman']);
                                      $tgl_mulai = '';
                                      if(!empty($_GET['tgl_mulai'])) $tgl_mulai = htmlspecialchars($_GET['tgl_mulai']);
                                      $tgl_selesai = '';
                                      if(!empty($_GET['tgl_selesai'])) $tgl_selesai = htmlspecialchars($_GET['tgl_selesai']);
                                      $search = '';
                                      if(!empty($_GET['search'])) $search = htmlspecialchars($_GET['search']);
                                      ?>
                                    <input id="date_start" name="tgl_mulai" type="text" class="form-control" placeholder="Dari Tgl" value="<?= $tgl_mulai ?>" size="6">
                                    <input id="date_end" name="tgl_selesai" type="text" class="form-control" placeholder="Sampai Tgl" value="<?= $tgl_selesai ?>" size="6">
                                    <select class="form-control" name="pengiriman" onchange="this.form.submit()">
                                      <option value="">[Status pengiriman]</option>
                                      <option value="1" <?=($pengiriman=='1')?'selected':'';?>>Persiapan</option>
                                      <option value="2" <?=($pengiriman=='2')?'selected':'';?>>Proses</option>
                                      <option value="3" <?=($pengiriman=='3')?'selected':'';?>>Telah diterima</option>
                                      <option value="4" <?=($pengiriman=='4')?'selected':'';?>>Retur</option>
                                    </select>
                                    <div class="form-group">
                                        <input name="search" type="text" class="form-control" id="cari" placeholder="Kode Order" value="<?= $search ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                              </form>
                                
                                <div class="table-responsive">
                                
                                  <table class="table datatable table-hover table-striped tablesorter">
                                    <thead>
                                      <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Kode Order</th>
                                        <th>Harga</th>
                                        <th>Status Pembayaran</th>
                                        <th>Status Pengiriman</th>
                                        <?php if($this->auth_m->get_user()->id_level!='5') { ?>
                                        <th>Kelola Order</th>
                                        <?php } ?>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php if(!empty($orders)):?>  
                                      <?php $i=0;foreach ($orders as $data) { $i++;?>
                                      <tr>
                                        <td><?=$i;?></td>
                                        <td><?=$data->date_added;?></td>
                                        <td><?= htmlspecialchars($data->kode_order) ;?></td>
                                        <td>
                                            Produk : <?php
                                                echo 'Rp.'.format_uang($data->total_merchant);                                       
                                            ?>
                                            <br />---<br />
                                            Ongkir Maks : 
                                            <?php
                                                echo 'Rp.'.format_uang($data->original_shipping_fee);                                       
                                            ?>
                                                                        <br />---<br />
                                            Total : 
                                            <?php
                                                //max reimburse ongkir ialah yang dibayarkan oleh buyer
                                                if(!empty($data->ongkir_merchant))
                                                    $ongkir_cover = min($data->original_shipping_fee, $data->ongkir_merchant); 
                                                else
                                                    $ongkir_cover = $data->original_shipping_fee;
                                                    
                                                echo 'Rp.'.format_uang($data->total_merchant + $ongkir_cover);                                       
                                            ?>
                                            
                                        </td>
                                        <td>
                                            <?= htmlspecialchars(status_payment_label($data->status_payment)) ?>
                                        </td>
                                        <td><?= htmlspecialchars(status_delivery_label($data->status_delivery)) ;?></td> 
                                        <?php if($this->auth_m->get_user()->id_level!='5') { ?>
                                        <td>
                                          <a href="<?php echo base_url('merchant/edit_order/'.$data->id_order)?>/orders" type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a>                                  
                                        </td> 
                                        <?php } ?>
                                      </tr>
                                      <?php } ?>
                                      <?php else: ?>
                                        <tr><td colspan='7'>Tidak ada Order</td></tr>
                                      <?php endif; ?>
                                    </tbody>
                                  </table>
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
            <nav class="container">
              <?php
                echo $paginator_new;
                ?>
            </nav>

            <div class="category-list container">
        </section>

<script>
  $("#date_start").datepicker({
    dateFormat: "yy-mm-dd"
    });
  $("#date_end").datepicker({
    dateFormat: "yy-mm-dd"
    });
</script>

<?=$this->load->view('publik/ui2/footer')?>
