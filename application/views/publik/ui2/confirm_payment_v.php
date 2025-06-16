<?=$this->load->view('publik/ui2/header')?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>

        <section class="main">

            <header class="content-head container">
                <div class="boxhead">
                   <div class="row">
                       <div class="col-xs-3">
                           Member Area
                       </div>
                       <div class="col-xs-9">
                       </div>
                   </div> 
                </div>
            </header>

            <div class="category-list container">
                
                <div class="row">
                    <?php $this->load->view('publik/ui2/sidebar_member_v')?>
                    
                    <div class="col-xs-9">
                        <div class="row">
                            <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Konfirmasi Pembayaran</span></h3>
                            <hr>
                            <?php
                            if ($success != '') {
                                ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?= $success; ?>
                                </div>
                            <?php } ?>

                            <?php
                            if ($error != '') {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?= $error; ?>
                                </div>
                            <?php } ?>
                        
                            
                                <?php
                                if ($status == 1) {
                                    ?>
                                    <h4><strong>Detail Transaksi</strong></h4>
                                    <table style="margin: 2em 0;">
                                        <tr>
                                            <td style="width: 200px">Nomor Invoice</td>
                                            <td style="width: px">:</td>
                                            <td><strong><?= htmlspecialchars($order->kode_invoice) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 200px">Nama</td>
                                            <td style="width: px">:</td>
                                            <td><?= htmlspecialchars($invoiceAddress->nama); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 200px">Alamat</td>
                                            <td style="width: 10px">:</td>
                                            <td><?= htmlspecialchars($invoiceAddress->alamat); ?>, <?= htmlspecialchars($invoiceAddress->nama_kota); ?>,  <?= htmlspecialchars(strtoupper($invoiceAddress->nama_provinsi)); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 200px">No Telp</td>
                                            <td style="width: 10px">:</td>
                                            <td><?= htmlspecialchars($invoiceAddress->telpon); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 200px">No Handphone</td>
                                            <td style="width: 10px">:</td>
                                            <td><?= htmlspecialchars($invoiceAddress->hp); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 200px">Total Bayar</td>
                                            <td style="width: 4px">:</td>
                                            <td>Rp <?= $this->cart->format_number($order->total + $order->ongkir + $order->payment_fee); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 200px">Tanggal</td>
                                            <td style="width: 4px">:</td>
                                            <td><?= $order->date_added ?></td>
                                        </tr>

                                    </table>
                                    <smal><strong>Data Transaksi</strong></smal>
                                    <?php foreach ($orderdetail as $value) { ?>
                                        <table width="100%">
                                            <tr>
                                                <td width="40%">Merchant: <?= htmlspecialchars(ucwords($this->cart_m->get_merchant($value->id_merchant)->nama_store)) ?></td>
                                                <td width="40%">Nomor Transaksi: <?= htmlspecialchars($value->kode_order) ?></td>
                                                <td width="20%">
                                                    <?php
                                                    if ($order->status_payment != "waiting") {
                                                        ?>
                                                        Status: Success
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="" style="margin-top: 2em;">
                                            <!--<label>#Belanja dari Merchant:</label> <strong><?= htmlspecialchars(ucwords($this->cart_m->get_merchant($value->id_merchant)->username)) ?></strong>-->
                                            <div class="table-responsive">
                                                <table class="table table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center" width="10%">No.</th>
                                                            <th style="text-align: center">Nama Produk</th>
                                                            <th style="text-align: center" width="10%">Jumlah</th>
                                                            <th style="text-align: center" width="15%">Harga</th>
                                                            <th style="text-align: center" width="15%">Diskon</th>
                                                            <th style="text-align: center" width="20%">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total_harga = 0;
                                                        $itemorder = $this->cart_m->get_order_item(md5($value->id_order));
                                                        ?>
                                                        <?php
                                                        $i = 0;
                                                        $berat = 0;
                                                        $subtotal = 0;
                                                        foreach ($itemorder as $item) {
                                                            $i++;
                                                            ?>
                                                            <tr>
                                                                <td style="text-align: center"><?= $i; ?></td>
                                                                <td><?= htmlspecialchars($item->nama_produk); ?> <?= (!empty($item->detail_paket)) ? '<br>(' . htmlspecialchars($item->detail_paket) . ')' : '' ?></td>
                                                                <td style="text-align: right;"><?= $item->jml_produk; ?></td>
                                                                <td style="text-align: right;">Rp <?= $this->cart->format_number($item->harga); ?></td>
                                                                <td style="text-align: right;"><?= $item->diskon; ?>%</td>
                                                                <?php
                                                                if ($item->diskon > 0) {
                                                                    $total = ($item->harga * $item->jml_produk) - ($item->harga * $item->jml_produk) * ($item->diskon / 100);
                                                                } else {
                                                                    $total = $item->harga * $item->jml_produk;
                                                                }
                                                                ?>
                                                                <td style="text-align: right;">Rp <?= $this->cart->format_number($total); ?></td>
                                                            </tr>
                                                            <?php
                                                            $subtotal+=$total;
                                                        }
                                                        $total_harga = $subtotal + $value->ongkir_sementara;
                                                        ?>
                                                        <tr>
                                                            <td style="text-align: right; font-weight: bold" colspan="5">Subtotal</td>
                                                            <td style="text-align: right">Rp <?= $this->cart->format_number($subtotal); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: right; font-weight: bold" colspan="5">Ongkos Kirim</td>
                                                            <td style="text-align: right">Rp <?= $this->cart->format_number($value->ongkir_sementara); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: right; font-weight: bold" colspan="5">Total</td>
                                                            <td style="text-align: right">Rp <?= $this->cart->format_number($total_harga); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <table class="table table table-bordered" width="100%">
                                        <?php
                                        if ($order->payment_fee > 0) {
                                            ?>
                                            <tr>
                                                <td width="20%" style="text-align: right;"><strong>Convenience Fee</strong></td>
                                                <td style="text-align: right">Rp <?= $this->cart->format_number($order->payment_fee); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($order->potongan_voucher > 0) {
                                            ?>
                                            <tr>
                                                <td width="20%" style="text-align: right;"><strong>Potongan Voucher : <?=$order->voucher;?></strong></td>
                                                <td style="text-align: right">Rp <?= $this->cart->format_number($order->potongan_voucher); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td width="80%" style="text-align: right; font-weight: bold">Grand Total</td>
                                            <td width="20%" style="text-align: right;">Rp <?= $this->cart->format_number(($order->total + $order->payment_fee + $order->ongkir) - $order->potongan_voucher); ?></td>
                                        </tr>
                                    </table>
                                    <hr>
                                    <form class="form-horizontal" name="user_pass"method="post" action="" enctype="multipart/form-data">
                                                <input name="email" type="hidden" class="form-control" id="email" value="<?= htmlspecialchars($detUser->email); ?>">
                                        <label><strong>Detail Pembayaran</strong></label>
                                        <div class="form-group">
                                            <label for="" class="col-lg-4 control-label">Nama Pemegang Rekening<span class="icon-required">*</span></label>
                                            <div class="col-lg-4">
                                                <input name="nama_rekening" value="<?=set_value('nama_rekening');?>" type="text" class="form-control" id="nama_rekening" placeholder="Johan Budi">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-lg-4 control-label">Nomor Rekening Bank Anda<span class="icon-required">*</span></label>
                                            <div class="col-lg-4">
                                                <input name="nomor_rekening" value="<?=set_value('nomor_rekening');?>" onkeypress="return isNumberKey(event)" type="text" class="form-control" id="nomor_rekening" placeholder="0732832892387">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-lg-4 control-label">Bank Rekening Anda<span class="icon-required">*</span></label>
                                            <div class="col-lg-4">
                                                <input name="bank_rekening" value="<?=set_value('bank_rekening');?>" type="text" class="form-control" id="bank_rekening" placeholder="MANDIRI">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-lg-4 control-label">Tanggal Bayar<span class="icon-required">*</span></label>
                                            <div class="col-lg-4">
                                                <input value="" name="tanggal_bayar" value="<?=set_value('tanggal_bayar');?>" type="text" class="form-control" id="tgl_lahir" placeholder="dd-mm-yyyy">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-lg-4 control-label">Cara Transfer<span class="icon-required">*</span></label>
                                            <div class="col-lg-4">
                                                <select id="jenis_pembayaran" name="jenis_pembayaran" class="form-control">
                                                    <option value="EBANKING">E-Banking</option>
                                                    <option value="ATM">ATM</option>
                                                    <option value="MBANKING">M-Banking</option>
                                                    <option value="SETORANTUNAI">Setoran Tunai</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-lg-4 control-label">Rekening Tujuan<span class="icon-required">*</span></label>
                                            <div class="col-lg-4">
                                                <select id="jenis_pembayaran" name="rekening_tujuan" class="form-control">
                                                    <?php
                                                    if (SHOW_PAYMENT_BANK_MANDIRI_TRANSFER) {
                                                        ?>
                                                        <option value="Mandiri <?= htmlspecialchars(NO_REK_OF_BANK_MANDIRI_TRANSFER); ?>">Mandiri <?= htmlspecialchars(NO_REK_OF_BANK_MANDIRI_TRANSFER); ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if (SHOW_PAYMENT_BANK_BCA_TRANSFER) {
                                                        ?>
                                                        <option value="BCA <?= htmlspecialchars(NO_REK_OF_BANK_BCA_TRANSFER); ?>">BCA <?= htmlspecialchars(NO_REK_OF_BANK_BCA_TRANSFER); ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-lg-4 control-label">Nominal Yang Dibayar<span class="icon-required">*</span></label>
                                            <div class="col-lg-4">
                                                <input name="total_bayar" value="<?=set_value('total_bayar');?>" onkeypress="return isNumberKey(event)" type="text" class="form-control" id="total_bayar" placeholder="10000">
                                            </div>
                                        </div>
                                        <div class="row ui-sortable" id="photo-container">
                                            <label for="" class="col-lg-4 control-label">Bukti Pembayaran<span class="icon-required">*</span></label>
                                            <div class="col-lg-6" style="margin-top:1em">
                                                <input type="file" name="bukti_pembayaran" class="form-control" id="bukti_pembayaran" accept="image/x-png,image/x-jpg,image/jpeg">
                                                <div style="margin-top: 0.5em; font-size: 12px">
                                                    <label>* File Bukti Pembayaran harus berupa File gambar (.jpg / .png / .jpeg / .pdf)</label>
                                                    <label>* Maksimal Ukuran file gambar : <?= ini_get("upload_max_filesize"); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <br><br>
                                        <div style="text-align:center;">
                                            <input type="hidden" id='kode_invoice' name="kode_invoice" value='<?= htmlspecialchars($id_invoice) ;?>' />
                                            <button class="btn btn-warning save-product" type="submit" name="simpan" value=1>Konfirmasi</button>
                                            <a href="<?=base_url()."order/konfirmasi";?>"><button class="btn btn-primary save-product" type="button" name="back" value='back'>Kembali</button></a>
                                        </div>                    
                                    </form>
                                    <?php
                                } else {
                                    ?>
                                    <label><strong>Detail User</strong></label>
                                    <form class="form-horizontal" name="user_pass" method="post" action="">
                                        <div class="form-group">
                                            <label for="" class="col-lg-2 control-label">Kode Invoice</label>
                                            <div class="col-lg-6">
                                                <select id="kode_invoice" name="kode_invoice" class="form-control">
                                                    <option value="0">Silahkan Pilih</option>
                                                    <?php
                                                    foreach ($listInvoice as $v) {
                                                        ?>
                                                        <option value="<?= $v->id_invoice; ?>"><?= htmlspecialchars($v->kode_invoice); ?></option>
                                                    <?php } ?>
                                                </select>
                                                <br>
                                                <button type="submit" value="1" name="load" class="btn btn-warning">Cek Kode Invoice</button>
                                            </div>
                                            <!--<button type="submit" id="load" name="load" value="1" class="btn btn-warning" style="width: 150p;height: 30px;margin-left: -125px">Cek Kode Invoice</button>-->
                                        </div>
                                    </form>
                                    <?php
                                }
                                ?>
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
    $("#tgl_lahir").datepicker({
        dateFormat: "dd-mm-yy"
    });

    function isNumberKey(evt)
    {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if ((charCode > 47 && charCode < 58 ) || charCode == 44 || charCode == 46 || charCode == 8)
                return true;

         return false;
    }
</script>
<?=$this->load->view('publik/ui2/footer')?>
