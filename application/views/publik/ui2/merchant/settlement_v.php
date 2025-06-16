<?=$this->load->view('publik/ui2/header')?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<?php
use Cipika\Entity\Settlement\SettlementStatus;
?>

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
                            <form id="mpsearch" method="get" action="" class="form-inline" role="form">  
                            <button type="button" value='1' id="exportform" class="btn btn-lanjut pull-right" style="margin-top:20px;margin-right:20px;">Export</button>
                            <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Settlement</span></h3>
                            <hr>
                            <?php if (!empty($success)) { ?>
                            <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$success;?>
                            </div>
                            <?php } ?>
                            <?php if (!empty($failed)) { ?>
                            <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$failed;?>
                            </div>
                            <?php } ?>

                            <div class="pull-left" style="font-size:12px;">
                                <?php 
                                  $status = '';
                                  if(!empty($_GET['status'])) $status = htmlspecialchars($_GET['status']);
                                  $tgl_mulai = '';
                                  if(!empty($_GET['tgl_mulai'])) $tgl_mulai = htmlspecialchars($_GET['tgl_mulai']);
                                  $tgl_selesai = '';
                                  if(!empty($_GET['tgl_selesai'])) $tgl_selesai = htmlspecialchars($_GET['tgl_selesai']);
                                  $search = '';
                                  if(!empty($_GET['search'])) $search = htmlspecialchars($_GET['search']);
                                  ?>
                                <input id="date_start" name="tgl_mulai" type="text" class="form-control" id="cari" placeholder="Dari Tgl" value="<?= $tgl_mulai ?>" size="6">
                                <input id="date_end" name="tgl_selesai" type="text" class="form-control" id="cari" placeholder="Sampai Tgl" value="<?= $tgl_selesai ?>" size="6">
                                <select class="form-control" name="status" onchange="this.form.submit()">
                                  <option value="">[Status]</option>
                                  <option value="8" <?=($status=='8')?'selected':'';?>>ready to request</option>
                                  <option value="1" <?=($status=='1')?'selected':'';?>>requested</option>
                                  <option value="3" <?=($status=='3')?'selected':'';?>>proceed</option>
                                  <option value="5" <?=($status=='5')?'selected':'';?>>reject</option>
                                  <option value="6" <?=($status=='6')?'selected':'';?>>paid</option>
                                  <option value="7" <?=($status=='7')?'selected':'';?>>hold</option>
                                </select>
                                <div class="form-group">
                                    <input name="search" type="text" class="form-control" id="cari formbox" placeholder="Kode Order" value="<?= $search ?>">
                                </div>
                                <input type="hidden" value="0" id="export" name="export">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                            <br>
                            <br>
                            <br>
                          </form>

                          
                                <form method="post" action="" >
                                <div class="">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="check_all"></th>
                                            <th>Tanggal</th>
                                            <th>Kode Order</th>
                                            <th>Tot Produk (Rp)</th>
                                            <th>Biaya Kirim (Rp)</th>
                                            <th>Pot. Biaya Transfer (Rp)</th>
                                            <th>Total (Rp)</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Opsi</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i = 0;
                                            foreach ($settlement as $key => $value) { 
                                            $i++;
                                            $total_transfer = $value->total_merchant + min($value->ongkir_merchant, $value->original_shipping_fee) - $value->biaya_transfer; 
                                            $tanggung_kirim = (empty($value->original_shipping_fee) ? $value->ongkir_merchant : min($value->ongkir_merchant, $value->original_shipping_fee));
                                            if($value->status_settlement == null){
                                                $tanggal_set = $value->tanggal_order_add;
                                            } elseif($value->status_settlement == 1) {
                                                $tanggal_set = $value->tanggal_settlement_add;
                                            } else {
                                                $tanggal_set = $value->tanggal_settlement_modified;
                                            }
                                        ?>
                                        <tr data-id="<?=$value->id_order?>">
                                            <td><input type="checkbox" class="item_checkbox" name="request_checkbox[]" value="<?=$value->id_order?>"></td>
                                            <td><?=$tanggal_set;?></td>
                                            <td><a href="<?=base_url();?>merchant/edit_order/<?=$value->id_order?>" title='coba'><?= htmlspecialchars($value->kode_order) ;?></a></td>
                                            <td style="text-align:right;"><?=$this->cart->format_number($value->total_merchant);?></td>
                                            <td style="text-align:right;"><?=$this->cart->format_number(min($value->ongkir_merchant, $value->original_shipping_fee));?></td>
                                            <td style="text-align:right;"><?=(empty($value->biaya_transfer) ? 'Belum Tersedia' : $this->cart->format_number($value->biaya_transfer));?></td>
                                            <td style="text-align:right;"><?=$this->cart->format_number($total_transfer);?></td>
                                            <td class="status_settlement"><?= htmlspecialchars(SettlementStatus::getStatus($value->status_settlement)) ?></td>
                                            <td class="status_settlement"><?= htmlspecialchars(empty($keterangan[$value->id_order]) ? '-' : $keterangan[$value->id_order]) ?></td>
                                            <td class="status_settlement">
                                                <?php if($value->status_settlement == NULL || $value->status_settlement == '7'): ?>
                                                <a href="<?=base_url();?>merchant/edit_order/<?=$value->id_order?>/settlement" type="button" class="btn btn-xs btn-warning">Edit Order</a>
                                                <?php endif; ?>
                                            </td>                 
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-sm btn-warning" value="1" name="request">Request</button>
                            <button type="submit" value="1" name="history" class="btn btn-success btn-sm">Lihat History</button>
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
            <nav class="container">
              <?php
                echo $paginator_new;
                ?>
            </nav>

        </section>
<script type="text/javascript">
    $('.check_all').change(function() {
        var isChecked = $(this).is(':checked');
        $('.item_checkbox').prop('checked', isChecked);
    });

    $('#exportform').click(function (e) {
        $('#export').val('1');
        $('#mpsearch').submit();
    });

   $('input').keyup(function (e) {
        if (e.keyCode == 13) {
            $('#export').val('0');
            $('#mpsearch').submit();
        }
    });

  $("#date_start").datepicker({
    dateFormat: "yy-mm-dd"
    });
  $("#date_end").datepicker({
    dateFormat: "yy-mm-dd"
    });
</script>

<?=$this->load->view('publik/ui2/footer')?>
