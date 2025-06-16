<?= $this->load->view('publik/ui2/header') ?>
<section class="main">
    <div class="featured-list container">
        <div class="row">
            <div class="col-xs-12">
                <div class="aboutbox-item aboutbox-item-static">
                    <div id="print">
                        <?php
                        if ($order->id_payment == 1) {
                            ?>
                            <h3>Bapak/Ibu Yth. <?= htmlspecialchars($user->firstname) ?> <?= htmlspecialchars($user->lastname) ?></h3>
                            <p>
                                Terimakasih anda telah melakukan sejumlah pembelian melalui CipikaStore. <br>
                                Pembelian anda telah sukses dilakukan.
                            </p>
                            <table style='margin: 2em 0;'>
                                <tr>
                                    <td style='width: 200px'>Nama Bank</td>
                                    <td style='width: px'>:</td>
                                    <td><strong>Bank Permata (kode bank 013)</strong></td>
                                </tr>
                                <tr>
                                    <td style='width: 200px'>Nomor Rekening (VAN ID)</td>
                                    <td style='width: 10px'>:</td>
                                    <td><strong><?= htmlspecialchars($payment) ?></strong></td>
                                </tr>
                            </table>
                            <?php
                            $waktu_exp = date('d-m-Y H:i:s', mktime(date('H') + 24, date('i'), date('s'), date('m'), date('d'), date('Y')));
                            ?>
                            <p>
                                Pembayaran dapat Anda lakukan melalui Jaringan <strong>ATM Bersama</strong>, <strong>PRIMA</strong>, dan <strong>ALTO</strong>. Anda juga diperkenankan memanfaatkan kemudahan fasilitas E-Banking yang dilengkapi menu <strong>Transfer Bank Online</strong>, namun pastikan fasilitas pembayaran yang Anda gunakan tidak memerlukan proses kliring. <br>
                            </p>
                            <p>
                                Pastikan Anda menyelesaikan pembayaran sebelum <strong><?= $waktu_exp ?></strong>. Apabila melebihi periode tersebut, maka Virtual Account (VAN ID) secara otomatis ditutup dan transaksi tidak diproses lebih lanjut.
                            </p>
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
                                    <td style="width: 200px">Total Harga</td>
                                    <td style="width: 4px">:</td>
                                    <td>Rp <?= $this->cart->format_number($totalBayar); ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 200px">Tanggal</td>
                                    <td style="width: 4px">:</td>
                                    <td><?= $order->date_added ?></td>
                                </tr>

                            </table>
                            <?php
                        } elseif ($order->id_payment == 5) {
                            ?>
                            <h3>Terima Kasih Telah Berbelanja di Cipika Store</h3>
                            <br />
                            <p>
                                <strong>Bapak/Ibu Yth. <?= htmlspecialchars($user->firstname) ?> <?= htmlspecialchars($user->lastname) ?></strong><br />
                                Terima kasih Anda telah berbelanja melalui Cipika Store. Apabila saldo yang ada pada Akun DompetKu anda mencukupi, maka secara otomatis pemesanan akan di proses lebih lanjut.
                            </p>
                            <p>
                                Informasi lebih lanjut mengenai proses pengiriman produk akan kami sampaikan dalam waktu maksimal 7 (tujuh) hari kerja kedepan. 
                                Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. Anda akan menerima informasi lebih lanjut apabila diperlukan perpanjangan waktu pengiriman.
                            </p><br>
                            <table style="margin: 2em 0;">
                                <tr>
                                    <td style="width: 200px">Nomer Akun DompetKU</td>
                                    <td style="width: px"> : </td>
                                    <td><?= htmlspecialchars($payment->msisdn); ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 200px">Jumlah yang sudah terbayar</td>
                                    <td style="width: 4px"> : </td>
                                    <td><strong> Rp <?= $this->cart->format_number($totalBayar); ?></strong></td>
                                </tr>
                            </table>
                            <p>
                                Ketentuan pembayaran adalah:
                            </p>
                            <ol>
                                <li>Bila pembayaran kurang dari jumlah biaya yang ditentukan, maka transfer Dompetku secara otomatis akan ditolak oleh system cipikastore.</li>
                                <li>System Cipikastore akan mengambil saldo dari akun DompetKu Anda sesuai nomial pembayaran yang sudah disetujui.</li>
                            </ol>
                            <?php
                        } elseif ($order->id_payment == 6) {
                            ?>
                            <h3>Terima Kasih Telah Berbelanja di Cipika Store</h3>
                            <br />
                            <p>
                                <strong>Bapak/Ibu Yth. <?= htmlspecialchars($user->firstname) ?> <?= htmlspecialchars($user->lastname) ?></strong><br />
                                Terima kasih Anda telah berbelanja melalui Cipika Store. 
                            </p>
                            <p>
                                Informasi lebih lanjut mengenai proses pengiriman produk akan kami sampaikan dalam waktu maksimal 7 (tujuh) hari kerja kedepan. 
                                Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. Anda akan menerima informasi lebih lanjut apabila diperlukan perpanjangan waktu pengiriman.
                            </p><br>
                            <table style="margin: 2em 0;">
                                <tr>
                                    <td style="width: 300px">Kode Transaksi Mandiri ClickPay</td>
                                    <td style="width: px"> : </td>
                                    <td><?= htmlspecialchars($payment->respond); ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 300px">Jumlah yang sudah terbayar</td>
                                    <td style="width: 4px"> : </td>
                                    <td><strong> Rp <?= $this->cart->format_number($totalBayar); ?></strong></td>
                                </tr>
                            </table>
                            <?php
                        } elseif ($order->id_payment == 7) {
                            ?>
                            <h3>Bapak/Ibu Yth : <?= htmlspecialchars($user->firstname) ?> <?= htmlspecialchars($user->lastname) ?></h3>
                            <p>
                                Terimakasih anda telah melakukan sejumlah pembelian melalui CipikaStore. <br>
                                Pembelian anda telah sukses dilakukan.
                            </p>
                            <p>
                                Informasi lebih lanjut mengenai proses pengiriman produk akan kami sampaikan dalam waktu maksimal 7 (tujuh) hari kerja kedepan. 
                                Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. Anda akan menerima informasi lebih lanjut apabila diperlukan perpanjangan waktu pengiriman.
                            </p><br>
                            <?php
                        } elseif ($order->id_payment == 8) {
                            ?>
                            <h3>Bapak/Ibu Yth : <?= htmlspecialchars($user->firstname) ?> <?= htmlspecialchars($user->lastname) ?></h3>
                            <p>
                                Terimakasih anda telah melakukan sejumlah pembelian melalui CipikaStore. <br>
                                <?php
                                if ($order->status_payment == 'waiting') {
                                    ?>
                                    Pembayaran anda telah gagal.
                                    <?php
                                } else {
                                    ?>
                                    Pembelian anda telah sukses di lakukan.
                                    <?php
                                }
                                ?>
                            </p>
                            <?php
                            if ($order->status_payment != 'waiting') {
                                ?>
                                <p>
                                    Informasi lebih lanjut mengenai proses pengiriman produk akan kami sampaikan dalam waktu maksimal 7 (tujuh) hari kerja kedepan. 
                                    Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. Anda akan menerima informasi lebih lanjut apabila diperlukan perpanjangan waktu pengiriman.
                                </p><br>
                                <?php
                            }
                            ?>
                            <?php
                        } elseif ($order->id_payment == 9) {
                            ?>
                            <h3>Bapak/Ibu Yth. <?= htmlspecialchars($user->firstname) ?> <?= htmlspecialchars($user->lastname) ?></h3>
                            <br>
                            <div style="border: 2px black solid; padding:0.3em; margin:2px">
                                <p>
                                    Mohon Perhatian!<br>
                                    Anda menggunakan metode pembayaran Transfer Bank BCA/MANDIRI. Setelah membayar, Anda wajib melakukan Konfirmasi Pembayaran disini atau ikuti langkah berikut:
                                </p>
                                <p>
                                <ol type=number>
                                    <li>Buka <a href='http://cipika.co.id'>www.cipika.co.id</a></li>
                                    <li>Login dengan username & password Anda</li>
                                    <li>Klik menu <strong><a href='<?= base_url(); ?>order/konfirmasi'>Konfirmasi Pembayaran</a></strong></li>
                                    <li>Lengkapi data pembayaran dengan benar dan kirim</li>
                                </ol>
                                </p>
                                <?php
                                $date_exp = date('d-m-Y', mktime(date('H') + 24, date('i'), date('s'), date('m'), date('d'), date('Y')));
                                $time_exp = date('H:i:s', mktime(date('H') + 24, date('i'), date('s'), date('m'), date('d'), date('Y')));
                                ?>
                                <p>
                                    Batas waktu Pembayaran dan Konfirmasi Pembayaran adalah tanggal <strong><?= htmlspecialchars($date_exp); ?></strong> pukul <strong><?= htmlspecialchars($time_exp); ?></strong> WIB. 
                                    Apabila Anda menemui kendala dan/atau lupa konfirmasi sehingga menyebabkan transaksi Expired, segera hubungi e-care.store@cipika.co.id. 
                                    Customer service kami akan memandu anda melakukan konfirmasi dengan batas waktu tertentu sesuai kebijakan Cipika.
                                </p>
                            </div>
                            <p>
                            <u><strong>Detail Pembayaran</strong></u>
                            </p>
                            <table style='margin: 1em 0;'>
                                <tr>
                                    <td style='width: 200px'>Nama Bank</td>
                                    <td style='width: 10px'>:</td>
                                    <td><strong>Bank Mandiri Cabang Jakarta Thamrin</strong></td>
                                </tr>
                                <tr>
                                    <td style='width: 200px'>Nomor Rekening</td>
                                    <td style='width: 10px'>:</td>
                                    <td><strong><?php echo htmlspecialchars(NO_REK_OF_BANK_MANDIRI_TRANSFER) ?></strong></td>
                                </tr>
                                <tr>
                                    <td style='width: 200px'>A/C</td>
                                    <td style='width: 10px'>:</td>
                                    <td><strong>PT Indosat Tbk</strong></td>
                                </tr>
                            </table>
                            <p>
                                Ketentuan Pembayaran :
                            <ol type=number>
                                <li>Bayar melalui ATM Bersama, Prima, Alto. Atau Internet Banking dari Bank yang menyediakan menu Transfer Antar Bank Online.</li>
                                <li>Bayar sesuai nilai tagihan. Transaksi tidak akan diproses jika ada kekurangan bayar hingga pelunasan sesuai kebijakan Cipika. 
                                    Kelebihan bayar akan dikembalikan dalam bentuk point/Voucher, pengembalian kelebihan bayar dalam bentuk uang dikenakan biaya transfer bank.</li>
                                <li>Tidak disarankan menggunakan alat pembayaran dengan proses Kliring. Cipika berhak membatalkan transaksi dengan proses Kliring</li>
                            </ol>
                            </p>
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
                                    <td style="width: 200px">Total Harga</td>
                                    <td style="width: 4px">:</td>
                                    <td><strong> Rp <?= $this->cart->format_number($totalBayar); ?></strong></td>
                                <tr>
                                    <td style="width: 200px">Tanggal</td>
                                    <td style="width: 4px">:</td>
                                    <td><?= $order->date_added ?></td>
                                </tr>

                            </table>
                            <?php
                        } elseif ($order->id_payment == 10) {
                            ?>
                            <h3>Bapak/Ibu Yth. <?= htmlspecialchars($user->firstname) ?> <?= htmlspecialchars($user->lastname) ?></h3>
                            <br>
                            <div style="border: 2px black solid; padding:0.3em; margin:2px">
                                <p>
                                    Mohon Perhatian!<br>
                                    Anda menggunakan metode pembayaran Transfer Bank BCA/MANDIRI. Setelah membayar, Anda wajib melakukan Konfirmasi Pembayaran disini atau ikuti langkah berikut:
                                </p>
                                <p>
                                <ol type=number>
                                    <li>Buka <a href='http://cipika.co.id'>www.cipika.co.id</a></li>
                                    <li>Login dengan username & password Anda</li>
                                    <li>Klik menu <strong><a href='<?= base_url(); ?>order/konfirmasi'>Konfirmasi Pembayaran</a></strong></li>
                                    <li>Lengkapi data pembayaran dengan benar dan kirim</li>
                                </ol>
                                </p>
                                <?php
                                $date_exp = date('d-m-Y', mktime(date('H') + 24, date('i'), date('s'), date('m'), date('d'), date('Y')));
                                $time_exp = date('H:i:s', mktime(date('H') + 24, date('i'), date('s'), date('m'), date('d'), date('Y')));
                                ?>
                                <p>
                                    Batas waktu Pembayaran dan Konfirmasi Pembayaran adalah tanggal <strong><?= htmlspecialchars($date_exp); ?></strong> pukul <strong><?= htmlspecialchars($time_exp); ?></strong> WIB. 
                                    Apabila Anda menemui kendala dan/atau lupa konfirmasi sehingga menyebabkan transaksi Expired, segera hubungi e-care.store@cipika.co.id. 
                                    Customer service kami akan memandu anda melakukan konfirmasi dengan batas waktu tertentu sesuai kebijakan Cipika.
                                </p>
                            </div>
                            <p>
                            <u><strong>Detail Pembayaran</strong></u>
                            </p>
                            <table style='margin: 1em 0;'>
                                <tr>
                                    <td style='width: 200px'>Nama Bank</td>
                                    <td style='width: 10px'>:</td>
                                    <td><strong>Bank BCA Wisma Asia</strong></td>
                                </tr>
                                <tr>
                                    <td style='width: 200px'>A/C</td>
                                    <td style='width: 10px'>:</td>
                                    <td><strong>PT Indosat Tbk</strong></td>
                                </tr>
                                <tr>
                                    <td style='width: 200px'>Nomor Rekening</td>
                                    <td style='width: 10px'>:</td>
                                    <td><strong><?php echo htmlspecialchars(NO_REK_OF_BANK_BCA_TRANSFER) ?></strong></td>
                                </tr>
                            </table>
                            <p>
                                Ketentuan Pembayaran :
                            <ol type=number>
                                <li>Bayar melalui ATM Bersama, Prima, Alto. Atau Internet Banking dari Bank yang menyediakan menu Transfer Antar Bank Online.</li>
                                <li>Bayar sesuai nilai tagihan. Transaksi tidak akan diproses jika ada kekurangan bayar hingga pelunasan sesuai kebijakan Cipika. 
                                    Kelebihan bayar akan dikembalikan dalam bentuk point/Voucher, pengembalian kelebihan bayar dalam bentuk uang dikenakan biaya transfer bank.</li>
                                <li>Tidak disarankan menggunakan alat pembayaran dengan proses Kliring. Cipika berhak membatalkan transaksi dengan proses Kliring</li>
                            </ol>
                            </p>
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
                                    <td style="width: 200px">Total Harga</td>
                                    <td style="width: 4px">:</td>
                                    <td><strong> Rp <?= $this->cart->format_number($totalBayar); ?></strong></td>
                                </tr>
                                <tr>
                                    <td style="width: 200px">Tanggal</td>
                                    <td style="width: 4px">:</td>
                                    <td><?= $order->date_added ?></td>
                                </tr>

                            </table>
                            <?php
                        } elseif ($order->id_payment == 13) {
                            ?>
                            <h3>Bapak/Ibu Yth : <?= htmlspecialchars($user->firstname) ?> <?= htmlspecialchars($user->lastname) ?></h3>
                            <p>
                                Terima kasih anda telah menyelesaikan seluruh proses belanja di Cipika Store. Kami telah mencatat daftar belanja dan pembayaran Anda dengan baik.
                            </p>
                            <p>
                                Informasi lebih lanjut mengenai proses pengiriman produk akan kami sampaikan dalam waktu maksimal 7 (tujuh) hari kerja kedepan. 
                                Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. Anda akan menerima informasi lebih lanjut apabila diperlukan perpanjangan waktu pengiriman.
                            </p>
                            <?php
                        } else {
                            ?>
                            <h3>Bapak/Ibu Yth. <?= htmlspecialchars($user->firstname) ?> <?= htmlspecialchars($user->lastname) ?></h3>
                            <p>
                                Terima kasih anda telah menyelesaikan seluruh proses belanja di Cipika Store. 
                                Kami telah mencatat daftar belanja dan pembayaran Anda dengan baik.
                            </p><br>
                            <p>
                                Informasi lebih lanjut mengenai proses pengiriman produk akan kami sampaikan dalam waktu maksimal 7 (tujuh) hari kerja kedepan. 
                                Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. Anda akan menerima informasi lebih lanjut apabila diperlukan perpanjangan waktu pengiriman.
                            </p><hr>
                            <?php
                        }
                        ?>
                        <small><strong>Data Transaksi</strong></small>
                        <?php
                        $items = array();
                        $total_bayar = 0;
                        foreach ($orderdetail as $value) {
                            $getMerchantReload = $this->store_m->get_single('tbl_store', 'id_user', $value->id_merchant);
                            $phoneNumberItem = $this->order_m->get_orderitem_phone_number($value->id_order);
                            ?>
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
                            <div class="" style="margin-top: 1em;">
                                <?php
                                $shipping_info = $this->cart_m->get_order_shipping($value->id_order);
                                ?>
                                <table width="100%">
                                    <tr>
                                        <?php
                                        if ($getMerchantReload->merchant_voucher_reload != "Y") {
                                            ?>
                                            <td width="40%"><strong>Alamat Pengiriman</strong></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td width="40%"><strong>Nomor Tujuan</strong></td>
                                            <?php
                                        }
                                        ?>
                                        <td width="40%"><strong>Metode Pengiriman</strong></td>
                                        <td width="40%"><strong>Metode Pembayaran</strong></td>
                                    </tr>
                                    <tr>
                                        <?php
                                        if ($getMerchantReload->merchant_voucher_reload != "Y") {
                                            ?>
                                            <td><?= htmlspecialchars(ucwords($shipping_info->nama)); ?></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td><?= $phoneNumberItem; ?></td>
                                            <?php
                                        }
                                        ?>
                                        <td><?= htmlspecialchars(ucwords($value->paket_ongkir)); ?></td>
                                        <td><?= htmlspecialchars(ucwords($order->payment)); ?></td>
                                    </tr>
                                    <tr>
                                        <?php
                                        if ($getMerchantReload->merchant_voucher_reload != "Y") {
                                            ?>
                                            <td><?= htmlspecialchars(ucwords($shipping_info->alamat)); ?></td>
                                            <?php
                                        }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <?php
                                        if ($getMerchantReload->merchant_voucher_reload != "Y") {
                                            ?>
                                            <td><?= htmlspecialchars(ucwords($shipping_info->nama_kabupaten)); ?> - <?= htmlspecialchars(ucwords($shipping_info->nama_propinsi)); ?></td>
                                            <?php
                                        }
                                        ?>

                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <?php
                                        if ($getMerchantReload->merchant_voucher_reload != "Y") {
                                            ?>
                                            <td><?= htmlspecialchars(ucwords($shipping_info->telpon)); ?></td>
                                            <?php
                                        }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="" style="margin-top: 2em;">
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
                                            $itemorder = $this->cart_m->get_order_item(md5($value->id_order));
                                            $i = 0;
                                            $berat = 0;
                                            $subtotal = 0;
                                            foreach ($itemorder as $item) {
                                                $i++;
                                                $items[] = array('id' => $order->kode_invoice, 'name' => $item->nama_produk,
                                                    'price' => $item->harga . '.00', 'quantity' => $item->jml_produk);
                                                ?>
                                                <tr>
                                                    <td style="text-align: center"><?= $i; ?></td>
                                                    <td><?= $item->nama_produk; ?> <?= (!empty($item->detail_paket)) ? '<br>(' . htmlspecialchars($item->detail_paket) . ')' : '' ?>
                                                        <?= (!empty($phoneNumberItem)) ? '<br>Pembelian pulsa untuk nomor : <strong>' . htmlspecialchars($phoneNumberItem) . '</strong>' : '' ?>  
                                                    </td>
                                                    <td style="text-align: right;"><?= $item->jml_produk; ?></td>
                                                    <td style="text-align: right;">Rp <?= $this->cart->format_number($item->harga); ?></td>
                                                    <td style="text-align: right;"><?= $item->diskon; ?>%</td>
                                                    <td style="text-align: right;">Rp <?= $this->cart->format_number($item->total); ?></td>
                                                </tr>
                                                <?php
                                                $subtotal+=$item->total;
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
                                <?php
                                if ($getMerchantReload->merchant_voucher_reload == "Y") {
                                    ?>
                                    <div style="margin-top:-1em;margin-bottom:1em">
                                        <strong>Keterangan :</strong> <label style="color:red">bila pulsa tidak terkirim dalam 1 hari mohon kirim email ke <a href="mailto:e-care.store@cipika.co.id">e-care.store@cipika.co.id</a></label>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                            $total_bayar += $total_harga;
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
                                    <td width="20%" style="text-align: right;"><strong>Potongan Voucher : <?= $order->voucher; ?></strong></td>
                                    <td style="text-align: right">Rp <?= $this->cart->format_number($order->potongan_voucher); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td width="80%" style="text-align: right; font-weight: bold">Grand Total </td>
                                <?php $totalOut = $total_bayar - $order->potongan_voucher; ?>
                                <td width="20%" style="text-align: right;">Rp <?= $totalOut == 0 ? $totalOut : $this->cart->format_number((int) $totalOut); ?></td>
                            </tr>
                        </table>
                        <?php
                        $trans = array('id' => $order->kode_invoice,
                            'revenue' => ($order->total + $order->payment_fee + $order->ongkir) . '.00',
                            'shipping' => $value->ongkir_sementara . '.00',
                            'currency' => 'IDR',
                        );
                        ?>
                    </div>
                    <a target="_blank" href='<?= base_url('order/print_invoice') . '/' . md5($order->kode_invoice); ?>/view' class=" custom-show hidden-md hidden-lg visible-sm visibke-xs">Print Invoice</a> 
                </div>
            </div>
        </div>
    </div>
</section>
<?php
function getTransactionJs(&$trans) {
  return <<<HTML
ga('ecommerce:addTransaction', {
  'id': '{$trans['id']}',
  'revenue': '{$trans['revenue']}',
  'shipping': '{$trans['shipping']}',
  'currency': '{$trans['currency']}'
});
HTML;
}

function getItemJs(&$transId, &$item) {
  return <<<HTML
ga('ecommerce:addItem', {
  'id': '{$item['id']}',
  'name': '{$item['name']}',
  'price': '{$item['price']}',
  'quantity': '{$item['quantity']}'
});
HTML;
}
?>

<!-- Begin HTML -->
<script>
/*ga('require', 'ecommerce');*/

<?php
echo getTransactionJs($trans);
foreach ($items as &$item) {
  echo getItemJs($trans['id'], $item);
}
?>
ga('ecommerce:send');
</script>
<?= $this->load->view('publik/ui2/footer') ?>
