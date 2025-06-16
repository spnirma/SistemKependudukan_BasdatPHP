<?=$this->load->view('publik/ui2/header')?>

        <section class="main">

            <div class="featured-list container">

               <div class="row">
                    <div class="col-xs-12">
                        <div class="aboutbox-item aboutbox-item-static">
                            <h3><span><?php echo ($grade=='bad')?'Feedback':'Testimoni'?></span></h3>
                            <hr>
                            <?php if($error!=''){ ?>
                            <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$error;?>
                            </div>
                            <?php } ?>

                            <?php if($success!=''){ ?>
                            <div class="alert alert-success alert-dismissable">
                              <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
                              <?=$success;?>
                            </div>
                            <?php } else { ?>

                            <form method="post" action="<?php echo base_url('feedback/'.$this->uri->segment(2).'/'.$this->uri->segment(3))?>" class="form-horizontal" role="form">
                                
                                <?php if($grade=='bad'):?>
                                    Halo <?php echo htmlspecialchars($order['order']->nama) ?> terima kasih sekali lagi telah berbelanja di Cipika Store. Kami mohon maaf sekali apabila ada pengalaman yang kurang menyenangkan, dan kami siap membantu Anda untuk menyelesaikan masalah ini.                    
                                    Berikut data pesanan Anda:<br/><br/>
                                    <table border='0' width='100%'>
                                        <tbody>
                                            <tr>
                                                <td width="25%">Tgl Order</td>
                                                <td>:</td>
                                                <td><?php echo strftime("%d-%m-%Y %H:%M:%S",strtotime($order['order']->date_added))?></td>
                                            </tr>
                                            <tr>
                                                <td>Kode Order</td>
                                                <td>:</td>
                                                <td><?php echo htmlspecialchars($order['order']->kode_order) ?></td>
                                            </tr>                           
                                        </tbody>
                                    </table>        
                                    <h3>Barang</h3>
                                    <table border='0' width='100%'>
                                        <tr>
                                            <th width='35%' height="40">Nama</th>
                                            <th width='20%'>Harga</th>
                                            <th width='10%'>Jumlah</th>
                                            <th width='20%'>Total</th>
                                        </tr>
                                        <?php foreach($order['items'] as $row): ?>
                                        <tr>
                                            <td><?= $row->nama_produk ?></td>
                                            <td>Rp. <?= format_uang($row->harga) ?></td>
                                            <td><?= $row->jml_produk ?></td>
                                            <td>Rp. <?= format_uang($row->total) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </table>
                                    <br/><br/>

                                    Silahkan pilih salah satu pilihan di bawah ini yang menggambarkan masalah Anda :<br/><br/>
                                        
                                    <label><input type="radio" name="feedback" value="Barang belum diterima"> Barang belum diterima</label><br/>
                                    <label><input type="radio" name="feedback" value="Barang yang diterima berbeda produk dengan yang dipesan"> Barang yang diterima berbeda produk dengan yang dipesan</label><br/>
                                    <label><input type="radio" name="feedback" value="Barang yang diterima merupakan varian yang berbeda dari rasa, ukuran, atau warna, dengan yang dipesan"> Barang yang diterima merupakan varian yang berbeda dari rasa, ukuran, atau warna, dengan yang dipesan</label><br/>
                                    <label><input type="radio" name="feedback" value="Barang diterima dalam keadaan rusak, atau basi"> Barang diterima dalam keadaan rusak, atau basi</label><br/>
                                    <input name="grade" type="hidden" id="grade" value="bad">
                                    <input name="notes" type="hidden" id="note" value="-">
                                    <br/>
                                    <input name="submit" value="Kirim" type="submit" class="btn btn-primary ">
                                <?php else:?>
                                    
                                    Halo <?php echo htmlspecialchars($order['order']->nama) ?>,<br/><br/>

                                    Untuk meningkatkan kualitas pelayanan kami, mohon tinggalkan pesan/ kesan/ testimoni Anda
                                    atas pengalaman Anda berbelanja di tempat kami untuk pesanan berikut:<br/><br/>

                                    <table border='0' width='100%'>
                                        <tbody>
                                            <tr>
                                                <td width="25%">Tgl Order</td>
                                                <td>:</td>
                                                <td><?php echo strftime("%d-%m-%Y %H:%M:%S",strtotime($order['order']->date_added))?></td>
                                            </tr>
                                            <tr>
                                                <td>Kode Order</td>
                                                <td>:</td>
                                                <td><?php echo htmlspecialchars($order['order']->kode_order) ?></td>
                                            </tr>                           
                                        </tbody>
                                    </table>        
                                    <h3>Barang</h3>
                                    <table border='0' width='100%'>
                                        <tr>
                                            <th width='35%' height="40">Nama</th>
                                            <th width='20%'>Harga</th>
                                            <th width='10%'>Jumlah</th>
                                            <th width='20%'>Total</th>
                                            <th width='20%'>Rating</th>
                                        </tr>
                                        <?php foreach($order['items'] as $row): ?>
                                        <tr>
                                            <td><?= $row->nama_produk ?></td>
                                            <td>Rp. <?= format_uang($row->harga) ?></td>
                                            <td><?= $row->jml_produk ?></td>
                                            <td>Rp. <?= format_uang($row->total) ?></td>
                                            <td>
                                                <?php
                                                    $rating = $this->produk_m->getRateUserProduk($row->id_produk, $this->session->userdata('member')->id_user);
                                                    // $disableRate = $this->produk_m->disableRate($row->id_produk, $this->session->userdata('member')->id_user);
                                                    $root = str_rot13($row->id_produk);
                                                    $convert = base_convert($root, 36, 28);
                                                    $convert1 = base_convert($convert, 36, 23);
                                                    $base = base64_encode($convert1);
                                                    $base1 = base64_encode($base);
                                                ?>
                                                <script type="text/javascript">
                                                $(document).ready(function(){
                                                  $(".rate<?= $row->id_produk ?>").jRating({
                                                    showRateInfo:false,
                                                    step:true,
                                                    canRateAgain : true,
                                                    nbRates : 999999,
                                                    isDisabled : false
                                                  });
                                                });
                                                </script>
                                                <div class="rate<?= $row->id_produk ?>" data-average="<?= $rating ?>" data-id="<?= $base1 ?>" data-id-user='<?= $this->session->userdata('member')->id_user ?>'></div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </table>
                                    <br/><br/>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Judul</label>
                                        <div class="col-sm-6">
                                            <input name="feedback" type="text" class="form-control" id="feedback" placeholder="Judul" value="<?php echo set_value('feedback')?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Komentar Order</label>
                                        <div class="col-sm-6">
                                            <textarea name="notes" cols="40" rows="5" class="form-control"><?php echo set_value('notes')?></textarea>
                                        </div>
                                    </div>
                                    <?php foreach($order['items'] as $row): ?>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Komentar Produk <br>(<?= $row->nama_produk ?>)</label>
                                        <div class="col-sm-6">
                                            <textarea name="komentar[<?= $row->id_produk ?>]" cols="40" rows="5" class="form-control"><?php echo set_value('notes')?></textarea>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <input name="grade" type="hidden" id="grade" value="good">
                                    
                                    <div class="form-group">
                                        <div class="col-sm-offset-8 col-sm-10">
                                            <input name="submit" value="Kirim" type="submit" class="btn btn-primary ">
                                        </div>
                                    </div>
                                    
                                <?php endif;?>
                                
                                <input type="hidden" name="id_feedback" value="<?php echo $feedback->id_feedback?>">
                                <input type="hidden" name="id_order" value="<?php echo $order['order']->id_order?>">
                            </form>

                          <?php } ?>
                        </div>
                    </div>
                </div>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
