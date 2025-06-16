<?=$this->load->view('publik/ui2/header')?>

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
                            <div class="aboutbox-item" style="padding-left:10px;">
                            <h3 class="featured-title"><span>Order [<?=$order->kode_order;?>]</span></h3>
                            
                            <div class="row" style="margin-top: 4em;">
                            <table border='0' width='100%'>
                                <tr valign='top'>
                                    <td>
                                        <strong>Alamat Pengiriman</strong><br /><span></span>  
                                        <?= htmlspecialchars($order->nama) ?><br>   
                                        <?= htmlspecialchars($order->alamat) ?><br>
                                        <?= htmlspecialchars($order->nama_kabupaten) ?><br>
                                        <?= htmlspecialchars($order->nama_propinsi) ?><br>
                                    </td>                                                                    
                                    <td>
                                        <strong>Metode Pembayaran</strong><br />
                                        <?= htmlspecialchars(ucwords($order->payment)) ;?><br />
                                        <strong>Status Pembayaran</strong><br />
                                        <?= htmlspecialchars(status_payment_label($order->status_payment)) ;?>
                                        <?=$order->status_payment=='refund'?"(".htmlspecialchars($order->refund_reason).")":"";?><br />
                                        <strong>Status Pengiriman</strong><br />
                                        <?= htmlspecialchars(status_delivery_label($order->status_delivery)) ;?>
                                        <?=$order->status_delivery=='terjadi keterlambatan'?"<br>(".htmlspecialchars($order->shipping_delay_reason).")":"";?><br />
                                        <strong>Paket Pengiriman</strong><br />
                                        <?= htmlspecialchars($order->paket_ongkir) ?><br />
                                    </td>                                
                                    <td>
                                        <?php       
                                            $resi       = (!empty($order->noresi))?$order->noresi:'-';
                                            $tgl_kirim  = (!empty($order->delivery_date))?$order->delivery_date:'-';
                                        
                                            echo    "<strong>No Resi pengiriman</strong><br/>".
                                                    htmlspecialchars($resi) ."<br/>".
                                                    "<strong>Tgl Kirim</strong><br/>".
                                                    htmlspecialchars($tgl_kirim) ."<br/>";
                                            
                                        ?>
                                        <strong>Posisi Pengiriman</strong><br />
                                        <?=isset($delivery->manifest_date)? htmlspecialchars($delivery->manifest_date) ." : ". htmlspecialchars($delivery->city_name) :"";?><br />
                                        <strong>Penerima Paket</strong><br />
                                        <?=isset($delivery->pod_receiver)? htmlspecialchars($delivery->pod_receiver) :"";?><br />
                                        <strong>Paket Pengiriman</strong><br />
                                        <?=isset($delivery->paket_pengiriman)? htmlspecialchars($delivery->paket_pengiriman) :"";?><br />
                                    </td>
                                </tr>
                            </table>
                            </div>

                            <div class="row" style="margin-top: 2em;">
                            <div class="table-responsive">
                            <table class="table table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="padding-left:5px">No.</th>
                                        <th>Nama Produk</th>
                                        <th>Berat (kg)</th>
                                        <th>Volume (cm3)</th>
                                        <th>Jumlah</th>
                                        <th style="text-align: right">Harga (Rp)</th>
                                        <th style="text-align: right">Diskon (%)</th>
                                        <th style="text-align: right; padding-right:5px">Subtotal (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($order_item as $item)
                                    {
                                        $i++;
                                        $volume_prod=$prod[$item->id_produk]->panjang*$prod[$item->id_produk]->tinggi*$prod[$item->id_produk]->lebar;
                                        ?>
                                        <tr>
                                            <td style="padding-left:5px"><?=$i;?></td>
                                            <td><?=$item->nama_produk;?><?= (!empty($item->detail_paket))?'<br>('.$item->detail_paket.')':'' ?></td>
                                            <td><?=$prod[$item->id_produk]->berat;?></td>
                                            <td><?=$volume_prod;?></td>
                                            <td style="text-align: right;"><?=$item->jml_produk;?></td>
                                            <td style="text-align: right;"><?=$item->harga;?></td>
                                            <td style="text-align: right;"><?=$item->diskon;?></td>
                                            <td style="text-align: right; padding-right:5px"><?=$item->total;?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td style="text-align: right; font-weight: bold" colspan="7">Total</td>
                                        <td style="text-align: right; padding-right:5px"><?=$order->total;?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; font-weight: bold" colspan="7">Biaya Pengiriman</td>
                                        <td style="text-align: right; padding-right:5px"><?=$order->ongkir_sementara;?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; font-weight: bold" colspan="7">GRAND TOTAL</td>
                                        <td style="text-align: right; font-weight: bold; padding-right:5px"><?=$order->total+$order->ongkir_sementara;?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <label style='color: #FE2E2E;font-size: 12px'>* Berat & Volume dalam tabel ini adalah Berat & Volume setelah Packaging, bukan Berat & Volume Produk.</label>
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

        </section>
<?=$this->load->view('publik/ui2/footer')?>
