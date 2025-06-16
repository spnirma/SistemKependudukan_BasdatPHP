<?php

namespace Cipika\View\Helper;

class EmailBuyerPembayaran {

    protected $bcc;
    protected $dbLibrary;
    protected $from;

    public function __construct($dbLibrary, $from, $bcc)
    {
        $this->dbLibrary = $dbLibrary;
        $this->from = $from;
        $this->bcc= $bcc;
    }

    public function send($to, $single, $inputan_order, $inputan_shipping, $inputan_merchant, $order_item, $link_index, $payment, $user)
    {
        $email_merchant = "";
        foreach ($inputan_order as $v)
        {
            $email_merchant = '<style>* {font-family:Arial, serif;font-size:12px} table tr td {padding:2px 5px;} tr.judul td {font-weight:bold;}</style>';
            $email_merchant.= "<h3>Bapak/Ibu " . ucwords($user->firstname) . " " . ucwords($user->lastname) . " Yth.</h3>
                <br />
                <p>
                    Terima kasih anda telah menyelesaikan seluruh proses belanja di Cipika Store. 
                    Kami telah mencatat daftar belanja dan pembayaran Anda dengan baik.
                </p><br>
                <p>
                    Pengiriman barang akan dilakukan dalam waktu 7 hari kerja.
                    Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. Anda akan menerima informasi lebih lanjut apabila diperlukan perpanjangan waktu pengiriman.
                </p><br>
                ";
            $email_merchant .= "<table width='100%'>
                            <tr>
                                <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                <td width='20%'>Status: Sukses</td>
                            </tr>
                        </table>";
            $email_merchant .= "<table width='100%'>
                            <tr>
                                <td width='40%'>
                                    <strong>Alamat Pengiriman</strong><br /><span></span>
                                    " . ucwords($inputan_shipping[$v->id_order]->nama) . "<br />
                                    " . ucwords($inputan_shipping[$v->id_order]->alamat) . "<br>
                                    " . ucwords($inputan_shipping[$v->id_order]->nama_kabupaten) . " - " . ucwords($inputan_shipping[$v->id_order]->nama_propinsi) . "<br>
                                    " . $inputan_shipping[$v->id_order]->telpon . "<br />
                                </td>
                                <td width='40%'>
                                    <strong>Metode Pengiriman</strong><br />
                                    " . ucwords($v->paket_ongkir) . "
                                </td>
                               <td width='20%'>
                                    <strong>Metode Pembayaran</strong><br>";
            $email_merchant.= $payment->nama_payment;
            $email_merchant .= "</td>
                            </tr>
                            </table><br>";
            $email_merchant .= '<table style="border-collapse:collapse; width:100%;">
                <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
            $i = 0;
            $total_sub = 0;
            $sub_total = 0;
            $totalAll = 0;
            foreach ($order_item[$v->id_order] as $items)
            {
                if ($items->diskon > 0)
                    $harga_diskon = $items->harga - $items->diskon_rp;
                else
                    $harga_diskon = $items->harga;
                $total_sub = $harga_diskon * $items->jml_produk;
                $i++;
                $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td> 
                        <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a></td>
                        <td style="text-align:right">' . $items->jml_produk . '</td>
                        <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                        <td style="text-align:right">' . $items->diskon . '%</td>
                        <td style="text-align:right">Rp. ' . number_format($harga_diskon, 0, '.', ',') . '</td>
                        <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                    </tr>';
                $sub_total += $total_sub;
            }
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . $sub_total . '</td></tr>';
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . $v->ongkir_sementara . '</td></tr>';
            $total_harga = $sub_total + $v->ongkir_sementara;
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . $total_harga . '</td></tr>            
                </table><div style="height:10px;"></div>';
            $totalAll+=$total_harga;
            $totalPrint = $totalAll + $single->payment_fee + $single->ongkir;
        }
        if ((int) $single->payment_fee > 0)
        {
            $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Convenience Fee</td>
                    <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                </tr>
            </table>";
        }
        $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Grand Total </td>
                    <td width='20%' style='text-align: right;'>Rp " . $totalPrint . "</td>
                </tr>
            </table><br>";
        $email_merchant .="
                    <p>Kami sarankan Anda menyimpan dengan baik bukti pembayaran 
                    hingga produk telah Anda terima dan transaksi dinyatakan selesai.</p><br>
                    <p>Untuk informasi, silahkan menghubungi e-care.store@cipika.co.id. 
                    Terima kasih atas kepercayaan Anda berbelanja di Cipika Store.</p>";
        $email_merchant .= '<br/><p>Terima Kasih,<br/><br/><br/>
                    <strong>Cipika Store &trade;</strong><br>
                    <a href="' . base_url() . '">cipika.co.id</a>
                    </p>
                    </div>
                    ';
        $list = $this->bcc;
        $list = implode(",", $list);
        $insert = array('idmailer' => null,
            'mailer_module' => 'Konfirmasi Pembayaran',
            'mailer_from' => $this->from,
            'mailer_to' => $to,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Terima Kasih! Pembayaran & Pembelian telah Tercatat',
            'mailer_message' => $email_merchant,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sends($to, $single, $inputan_order, $inputan_shipping, $inputan_merchant, $order_item, $link_index, $payment, $user, $orderItemCicilan = null)
    {
        $email_merchant = "<h3>Bapak/Ibu " . ucwords($user->firstname) . " " . ucwords($user->lastname) . " Yth.</h3>
                <br />
                <p>
                    Terima kasih anda telah menyelesaikan seluruh proses belanja di Cipika Store. 
                    Kami telah mencatat daftar belanja dan pembayaran Anda dengan baik.
                </p><br>
                <p>
                    Informasi lebih lanjut mengenai proses pengiriman produk akan kami sampaikan dalam waktu maksimal 7 (tujuh) hari kerja. 
                    Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. 
                    Kami akan memberikan informasi melalui email, apabila kami membutuhkan perpanjangan waktu pengiriman  yang disebabkan oleh 
                    alasan dan pertimbangan tertentu, guna menjaga kualitas layanan Cipika Store.
                </p>
                <p>
                Apabila dalam daftar belanja Anda terdapat produk digital, pulsa akan langsung ditambahkan ke nomor Selular yang telah Anda tentukan saat transaksi. Hubungi kami jika lebih dari 2 (dua) jam pulsa belum Anda terima.
                </p>
                
                <hr>
                ";
        $totalPrint = 0;
        $totalAll = 0;
        foreach ($inputan_order as $v)
        {
            $getMerchantDetailSql = "select merchant_voucher_reload from tbl_store where id_user = " . (int) $v->id_merchant . ";";
            $merchantVoucherReload = $this->dbLibrary->query($getMerchantDetailSql)->row()->merchant_voucher_reload;
            
            $getOrderVoucherReloadSql = "select oivr.nomer_hp from tbl_order o, tbl_orderitem_voucher_reload oivr where o.id_order = " . (int) $v->id_order . " and o.id_order = oivr.id_order;";
            $getPhoneVoucherReload = $this->dbLibrary->query($getOrderVoucherReloadSql)->row();

            $phoneVoucherReload = (!empty($getPhoneVoucherReload->nomer_hp)) ? $getPhoneVoucherReload->nomer_hp : "";

            $email_merchant .= "<table width='100%'>
                            <tr>
                                <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                <td width='20%'>Status: Success</td>
                            </tr>
                        </table>";
            $email_merchant .= "<table width='100%'>
                            <tr>";
            if ($merchantVoucherReload != "Y") {
                $email_merchant .= "<td width='40%'>
                                    <strong>Alamat Pengiriman</strong><br /><span></span>
                                    " . ucwords($inputan_shipping[$v->id_order]->nama) . "<br />
                                    " . ucwords($inputan_shipping[$v->id_order]->alamat) . "<br>
                                    " . ucwords($inputan_shipping[$v->id_order]->nama_kabupaten) . " - " . ucwords($inputan_shipping[$v->id_order]->nama_propinsi) . "<br>
                                    " . $inputan_shipping[$v->id_order]->telpon . "<br />
                                </td>";
            } else {
                $email_merchant .= "<td width='40%'>
                                    <strong>Nomor Tujuan</strong><br /><span></span>
                                    " . $phoneVoucherReload . "<br />
                                </td>";
            }
            $email_merchant .= "<td width='40%'>
                                    <strong>Metode Pengiriman</strong><br />
                                    " . ucwords($v->paket_ongkir) . "
                                </td>
                               <td width='20%'>
                                    <strong>Metode Pembayaran</strong><br>";
            $email_merchant.= $payment->nama_payment;
            $detailPaymentCicilan = null;
            if ($orderItemCicilan != null) {
                foreach ($orderItemCicilan[$v->id_order] as $val) {
                    $email_merchant .= "<br>" . $val;
                }
            }
            $email_merchant .= "</td>
                            </tr>
                            </table><br>";
            $email_merchant .= '<table style="border-collapse:collapse; width:100%;">
                <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
            $i = 0;
            $total_sub = 0;
            $sub_total = 0;
            foreach ($order_item[$v->id_order] as $items)
            {
                $harga_diskon = $items->harga - $items->diskon_rp;
                $total_sub = $harga_diskon * $items->jml_produk;
                $i++;
                $detailPaket = !empty($items->detail_paket)?'<br>('.$items->detail_paket.')':'';
                $stringPhoneVoucherReload = !empty($phoneVoucherReload)?'<br>Pembelian pulsa untuk nomor : <strong>'. $phoneVoucherReload .'</strong>':'';
                $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td> 
                        <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a>'.$detailPaket . $stringPhoneVoucherReload.'</td>
                        <td style="text-align:right">' . $items->jml_produk . '</td>
                        <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                        <td style="text-align:right">' . $items->diskon . '%</td>
                        <td style="text-align:right">Rp. ' . number_format($harga_diskon,0, '.', ',') . '</td>
                        <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                    </tr>';
                $sub_total += $total_sub;
            }
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . number_format($sub_total, 0, '.', ',') . '</td></tr>';
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . number_format($v->ongkir_sementara, 0, '.', ',') . '</td></tr>';
            $total_harga = $sub_total + $v->ongkir_sementara;
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . number_format($total_harga, 0, '.', ',') . '</td></tr>            
                </table><div style="height:10px;"></div>';
            $totalAll+=$total_harga;
        }
        $totalPrint = $totalAll + $single->payment_fee;
        if ((int) $single->payment_fee > 0)
        {
            $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Convenience Fee</td>
                    <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                </tr>
            </table>";
        }
        if ((int) $single->potongan_voucher > 0)
        {
            $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Potongan Voucher : " . htmlspecialchars($single->voucher) . "</td>
                    <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_voucher, 0, '.', ',')) . "</td>
                </tr>
            </table>";
        }
        if ($single->potongan_point_rp > 0)
        {
            $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Potongan Point : " . htmlspecialchars($single->potongan_point) . " (1 point = Rp. " . htmlspecialchars(number_format($single->potongan_point_rp / $single->potongan_point, 0, '.', ',')) . ")</td>
                    <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_point_rp, 0, '.', ',')) . "</td>
                </tr>
            </table>";
        }
        if ((int) $single->mdr_installment > 0)
        {
            $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Biaya Administrasi</td>
                    <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->mdr_installment, 0, '.', ',')) . "</td>
                </tr>
            </table>";
        }

        $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Grand Total </td>
                    <td width='20%' style='text-align: right;'>Rp " . number_format(($single->total + $single->ongkir + $single->mdr_installment) - $single->potongan_voucher - $single->potongan_point_rp, 0, '.', ',') . "</td>
                </tr>
            </table><br>";
        $email_merchant .="
                    <p>Kami sarankan Anda menyimpan dengan baik bukti pembayaran 
                    hingga produk telah Anda terima dan transaksi dinyatakan selesai.</p><br>
                    <p>Untuk informasi, silahkan menghubungi e-care.store@cipika.co.id. 
                    Terima kasih atas kepercayaan Anda berbelanja di Cipika Store.</p>";
        $email_merchant .= '<br/><p>Terima Kasih,<br/><br/><br/>
                    <strong>Cipika Store &trade;</strong><br>
                    <a href="' . base_url() . '">cipika.co.id</a>
                    </p>
                    ';
        $list = $this->bcc;
        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Konfirmasi Pembayaran',
            'mailer_from' => $this->from,
            'mailer_to' => $to,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Terima Kasih! Pembayaran & Pembelian telah Tercatat',
            'mailer_message' => $email_merchant,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendNotifKonfirmasiPembayaran($kode_invoice, $detUser, $detPembayaran)
    {
        $email_buyer = "";
        $email_buyer.= "<h3>Bapak/Ibu " . ucwords($detUser->firstname) . " " . ucwords($detUser->lastname) . " Yth.</h3>
                <br />
                <p>
                    Terima kasih telah mengirimkan Konfirmasi Pembayaran atas transaksi dengan nomor invoice <strong>" . htmlspecialchars($kode_invoice) . "</strong>. 
                    Kami membutuhkan waktu verifikasi atas data yang kami terima maksimal 1 x 24 jam pada hari kerja. 
                    Dan khusus transaksi dengan konfirmasi pembayaran pada hari Jumat (setelah pukul 15.00WIB), Sabtu, 
                    Minggu, dan hari besar/libur lainnya, akan kami proses pada hari kerja terdekat. 
                    Demikian kami sampaikan, mohon berkenan menunggu dan terima kasih.</p><br>
                ";
        $email_buyer.= '<br/><p>Salam,<br/>
                    <strong>Cipika Store &trade;</strong><br/>
                    Semuanya Menjadi Mudah
                    </p>
                    ';
        $list = $this->bcc;
        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Konfirmasi Pembayaran Pembeli',
            'mailer_from' => $this->from,
            'mailer_to' => $detUser->email,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Konfirmasi Pembayaran Terkirim',
            'mailer_message' => $email_buyer,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendNotifFailedKonfirmasiPembayaran($kode_invoice, $detUser, $detPembayaran, $dateExpired, $timeExpired)
    {
        $email_buyer = "";
        $email_buyer.= "<h3>Bapak/Ibu " . ucwords($detUser->firstname) . " " . ucwords($detUser->lastname) . " Yth.</h3>
                <br />
                <p>
                    Kami telah menindaklanjuti Konfirmasi Pembayaran atas transaksi dengan nomor Invoice : <strong>" . htmlspecialchars($kode_invoice) . "</strong>. 
                    Berdasarkan hasil verifikasi, kami tidak menemukan pembayaran sesuai dengan data yang Anda sampaikan. 
                    Sehingga Konfirmasi Pembayaran Anda dinyatakan <strong>TIDAK VALID</strong>. 
                </p><br>
                <p>
                Mohon periksa kembali detil Konfirmasi Pembayaran Anda, termasuk akun Bank dan jumlah pembayaran. 
                Pastikan pula jumlah pembayaran telah sesuai dengan nilai tagihan dalam Invoice. 
                Perlu kami sampaikan kembali, batas waktu pembayaran Anda adalah <strong>" . htmlspecialchars($dateExpired) . "</strong> pukul <strong>" . htmlspecialchars($timeExpired) . "</strong> WIB. 
                Mohon tidak melakukan pembayaran jika batas waktu telah habis. 
                </p><br>
                ";
        $email_buyer.= "<p>Untuk informasi, silahkan menghubungi e-care.store@cipika.co.id. Terima kasih atas kepercayaan Anda berbelanja di Cipika Store.</p>";
        $email_buyer.= '<br/><p>Salam<br/>
                    <strong>Cipika Store &trade;</strong><br>
                    Semuanya Menjadi Mudah
                    </p>
                    </div>
                    ';
        $list = $this->bcc;
        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Konfirmasi Pembayaran Tidak Valid',
            'mailer_from' => $this->from,
            'mailer_to' => $detUser->email,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Konfirmasi Pembayaran Tidak Valid',
            'mailer_message' => $email_buyer,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendNotifFailedKonfirmasiPembayaranAlasan($kode_invoice, $detUser, $detPembayaran, $dateExpired, $timeExpired, $alasan)
    {
        $email_buyer = "";
        $email_buyer.= "<h3>Bapak/Ibu " . ucwords($detUser->firstname) . " " . ucwords($detUser->lastname) . " Yth.</h3>
                <br />
                <p>
                    Kami telah menindaklanjuti Konfirmasi Pembayaran atas transaksi dengan nomor Invoice : <strong>" . htmlspecialchars($kode_invoice) . "</strong>.
                    Berdasarkan hasil verifikasi, konfirmasi Pembayaran Anda dinyatakan <strong>TIDAK VALID</strong>, karena <strong>".htmlspecialchars($alasan)."</strong>.
                </p>";
        $email_buyer .="<p>Pembayaran yang kami Unverified ini akan segera kami proses Refund, mohon untuk melengkapi data yang dibutuhkan sebagai berikut</p>";
        $email_buyer .= "<p><ul>";
        $email_buyer .= "<li>Nomor Invoice :</li>";
        $email_buyer .= "<li>Nama Bank dan cabang :</li>";
        $email_buyer .= "<li>Nama Pemilik Rekening :</li>";
        $email_buyer .= "<li>Nomor Rekening :</li>";
        $email_buyer .= "</ul></p>";
        $email_buyer .= "<p>Data tersebut agar dikirimkan ke alamat email <a href='mailto:e-care.store@cipika.co.id'>e-care.store@cipika.co.id</a></p>";
        $email_buyer.= "<p>Jika membutuhkan informasi lebih lanjut, silahkan menghubungi e-care.store@cipika.co.id. Terima kasih atas kepercayaan Anda berbelanja di Cipika Store.</p>";
        $email_buyer.= '<br/><p>Salam<br/>
                    <strong>Cipika Store &trade;</strong><br>
                    Semuanya Menjadi Mudah
                    </p>
                    </div>
                    ';

        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Konfirmasi Pembayaran Tidak Valid + Alasan',
            'mailer_from' => $this->from,
            'mailer_to' => $detUser->email,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Konfirmasi Pembayaran Tidak Valid',
            'mailer_message' => $email_buyer,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendNotifKonfirmasiPembayaranPersib($kode_invoice, $detUser, $detPembayaran)
    {
        $email_buyer = "";
        $email_buyer.= "<h3>Bapak/Ibu " . ucwords($detUser->firstname) . " " . ucwords($detUser->lastname) . " Yth.</h3>
                <br />
                <p>
                    Terima kasih telah mengirimkan Konfirmasi Pembayaran atas transaksi dengan nomor invoice <strong>" . htmlspecialchars($kode_invoice) . "</strong>. 
                    Kami membutuhkan waktu verifikasi atas data yang kami terima maksimal 1 x 24 jam pada hari kerja. 
                    Dan khusus transaksi dengan konfirmasi pembayaran pada hari Jumat (setelah pukul 15.00WIB), Sabtu, 
                    Minggu, dan hari besar/libur lainnya, akan kami proses pada hari kerja terdekat. 
                    Demikian kami sampaikan, mohon berkenan menunggu dan terima kasih.</p><br>
                ";
        $email_buyer.= '<br/><p>Salam,<br/>
                    <strong>Cipika Store &trade;</strong><br/>
                    Semuanya Menjadi Mudah
                    </p>
                    ';
        $list = $this->bcc;
        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Konfirmasi Pembayaran Pembeli',
            'mailer_from' => $this->from,
            'mailer_to' => $detUser->email,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Konfirmasi Pembayaran Terkirim',
            'mailer_message' => $email_buyer,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function persib_sends($to, $single, $inputan_order, $inputan_shipping, $inputan_merchant, $order_item, $user, $persib_formulir)
    {
            //$data['persib_formulir'] = $this->user_m->get_single('tbl_persib_formulir', 'id_user', $this->session->userdata('member')->id_user);
            //$user->firstname
        $totalPrint = 0;
        $totalAll = 0;
        foreach ($inputan_order as $v)
        {
            $total_sub = 0;
            $sub_total = 0;
            foreach ($order_item[$v->id_order] as $items)
            {
                $harga_diskon = $items->harga - $items->diskon_rp;
                $total_sub = $harga_diskon * $items->jml_produk;
                $sub_total += $total_sub;
            }
            $total_harga = $sub_total + $v->ongkir_sementara;
            $totalAll+=$total_harga;
        }
        $totalPrint = $totalAll + $single->payment_fee;
        $jenis_kelamin="";
        if ($persib_formulir->jenis_kelamin=='man') { 
            $jenis_kelamin="Laki-laki";  
        } else if ($persib_formulir->jenis_kelamin=='woman') { 
            $jenis_kelamin="Perempuan"; 
        }

        $email_merchant = "<h3>Yth. Bapak/Ibu " . $persib_formulir->nama .",</h3>
                <p>
                    Terima kasih anda telah sukses menjadi anggota resmi Persib Bandung dengan data seperti berikut :  
                </p>
                                    <strong>DATA TRANSAKSI :</strong>
                                    <table width='100%' border='0' cellpadding='5' cellspacing='0' >
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Nomor Invoice</td>
                                        <td width='70%' style='text-align: left;'>" . $single->kode_invoice . "</td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Total pembayaran</td>
                                        <td width='70%' style='text-align: left;'>Rp " . number_format($totalPrint) . "</td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Status pembayaran</td>
                                        <td width='70%' style='text-align: left;'>Lunas</td>
                                    </tr>
                                    </table> <br>
                                    <strong>DATA KEANGGOTAAN :</strong>
                                    <table width='100%' border='0' >
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Nomor keanggotaan</td>
                                        <td width='70%' style='text-align: left;'><b>" .$persib_formulir->no_hp   . "</b></td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Masa aktif keanggotan s/d</td>
                                        <td width='70%' style='text-align: left;'><b>" .date('d M Y',strtotime($persib_formulir->date_expired))   . "</b></td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Nama lengkap</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->nama   . "</td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Email</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->email   . "</td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Jenis kelamin</td>
                                        <td width='70%' style='text-align: left;'>" .$jenis_kelamin   . "</td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Tempat, tanggal lahir</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->tempat_lahir   . ", " .str_replace("00:00:00","",$persib_formulir->tanggal_lahir)   . "</td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;' valign='top'>Alamat</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->alamat   . "<br>" .$persib_formulir->kecamatan   . ", " .$persib_formulir->kota   . "<br>" .$persib_formulir->propinsi   . " " .$persib_formulir->kode_pos   . "<br></td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Nomor Telepon</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->no_tlp   . "</td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Kepemilikan identitas</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->tipe_identitas   . "</td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Nomor Identitas</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->nomor_identitas   . "</td>
                                    </tr>";
                                if ($persib_formulir->tipe_identitas=='identitas keluarga') {    
                                $email_merchant .= "
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Nama pemegang identitas</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->identitas_keluarga   . "</td>
                                    </tr>";
                                $email_merchant .= "
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Hubungan dengan anggota</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->hubungan_calon   . "</td>
                                    </tr>";
                                }    
                                $email_merchant .= "
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Status dalam keluarga</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->status_keluarga   . "</td>
                                    </tr>
                                    <tr>
                                        <td width='30%' style='text-align: left;'>Nama ahli waris</td>
                                        <td width='70%' style='text-align: left;'>" .$persib_formulir->nama_ahli_waris   . "</td>
                                    </tr>
                                    </table>
                                    ";
            $vRenewal='';
            if ($persib_formulir->tipe=='renewal') { 
                $vRenewal=' RENEWAL ';
                $email_merchant.="
                <p>
                Dokumen ini adalah bukti persetujuan atas ketentuan perpanjangan keanggotaan Persib sekaligus bukti pembayaran keanggotaan.   
                    <ul>
                    <li>Status keanggotaan anda kami nyatakan aktif dan kalau ada pergantian kartu akan kami kirimkan ke alamat anda.
                    </li><li>Email dan password login tidak berubah, di Fanzone website persib.co.id. 
                    </li><li>Kami sarankan Anda menyimpan dengan baik email dan bukti pembayaran hingga kartu telah Anda terima dengan baik. 
                    </li><li>Untuk informasi lebih lengkap, silahkan menghubungi kami melalui email cs@persib.co.id, atau menghubungi call center Persib di 08569019444 . 
                    </li>
                    </ul>
                    
                </p>
                ";
            } else {
                $email_merchant.="
                <p>
                Dokumen ini adalah bukti persetujuan atas ketentuan pendaftaran Persib sekaligus bukti pembayaran keanggotaan.   
                    <ul>
                    <li>Status keanggotaan anda kami nyatakan aktif dan nantikan pengiriman kartu keanggotaan ke alamat anda.
                    </li><li>Anggota dapat melakukan login di Fanzone website persib.co.id setelah 1 x 24 jam. 
                    </li><li>Pengiriman kartu akan dilakukan secara langsung oleh mitra ekspedisi kami. 
                    </li><li>Kami sarankan Anda menyimpan dengan baik email dan bukti pembayaran hingga kartu telah Anda terima dengan baik. 
                    </li><li>Untuk informasi lebih lengkap, silahkan menghubungi kami melalui email cs@persib.co.id, atau menghubungi call center Persib di 08569019444 . 
                    </li>
                    </ul>
                    
                </p>
                ";
            }    

        $email_merchant .= '<br/><p>
                                        Dukung terus Persib. Hatur Nuhun. 
                                        Terima kasih.
                                        </p>
                    ';
        $list = $this->bcc;
        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Register Persib Member',
            'mailer_from' => 'registrasi@persib.co.id',
            'mailer_to' => $to,
            //'mailer_bcc' => $list,
            'mailer_subject' => 'Status keanggotaan '.$vRenewal.' Persib Bandung telah aktif',
            'mailer_message' => $email_merchant,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function voucher_product_sends($VoucherProduct,$user=array(),$list_voucher_data=array(),$invoice=array(),$orderdetail=array(),$payment=array(), $order_item=array())
    {
        if ($VoucherProduct->vsm_type=='fisik') {
            $email_merchant = "<h3>Yth. Bapak/Ibu " . $user->firstname ." " .$user->lastname.",</h3>
                <p>
                    Terima kasih Anda telah berbelanja melalui Cipika Store. Kami sedang mengirimkan Voucher Fisik Anda ke alamat Anda.  
                </p>

                <p>
                <b>Cara mempergunakan Voucher Fisik Anda adalah:</b>   
                    <ul>
                    <li>Harap dipastikan Anda telah memilih produk yang nilainya sama atau lebih besar dari nilai Voucher yang akan Anda belanjakan. Hal ini dikarenakan bila masih ada nilai sisa Voucher, maka sisa Voucher tersebut tidak akan bisa digunakan kembali. 
                    </li><li>Pada saat Anda telah selesai berbelanja, berikan Voucher Fisik pada kasir bahwa Anda akan menggunakan Voucher untuk membayar barang belanjaan Anda. 
                    </li><li>Anda perlu untuk membaca syarat dan ketentuan untuk menggunakan kode voucher belanja. 
                    </li><li>Kode Voucher Anda berlaku diseluruh wilayah Indonesia sesuai dengan nama toko yang disupport oleh Voucher tersebut. 
                    </li>
                    </ul>

                <b>Syarat dan ketentuan:</b>
                    <ul>
                    <li>Semua Voucher yang telah dikirimkan oleh Cipika adalah Voucher yang tidak pernah digunakan sama sekali. 
                    </li><li>Voucher Fisik yang telah dikirimkan oleh Cipika tidak dapat ditukar atau digantikan dengan Voucher Fisik lainnya karena alasan apapun. 
                    </li><li>Voucher Fisik yang telah dikirimkan oleh Cipika tidak dapat dilakukan Refund maupun dibatalkan oleh karena alasan apapun.
                    </li>
                    </ul>
                </p>                ";

            $email_merchant .= '<br/><p>
                                Team Cipika.
                                </p>
                    ';

                    $insert = array('idmailer' => null,
                'mailer_module' => 'Product Voucher',
                'mailer_from' => $this->from,
                'mailer_to' => $user->email,
                'mailer_subject' => 'Tata Cara Penggunaan Voucher ['.$VoucherProduct->vsm_merchantname.']',
                'mailer_message' => $email_merchant,
                'mailer_status' => 'new',
                'mailer_created' => date('Y-m-d H:i:s')
            );
            $this->dbLibrary->insert('mailer', $insert);
            return $this->dbLibrary->insert_id();
        }       

        if ($VoucherProduct->vsm_type=='elektronik') {
            $email_merchant='';
            if (substr($VoucherProduct->vsm_merchantkode,0,8)=='ALFAMART' || substr($VoucherProduct->vsm_merchantkode,0,9)=='INDOMARET') {
                    $email_merchant = "<h3>Yth. Bapak/Ibu " . $user->firstname ." " .$user->lastname.",</h3>
                        <p>
                            Terima kasih Anda telah berbelanja melalui Cipika Store. Anda dapat melihat semua kode Voucher Anda pada tabel dibawah ini. 
                        </p>
                        <p>
                        Cara mempergunakan kode Voucher Anda adalah:
                            <ul>
                            <li>Harap dipastikan Anda telah memilih produk yang nilainya sama atau lebih besar dari nilai Voucher yang akan Anda belanjakan. Hal ini dikarenakan bila masih ada nilai sisa Voucher, maka sisa Voucher tersebut tidak akan bisa digunakan kembali. 
                            </li><li>Pada saat Anda telah selesai berbelanja, katakan pada kasir bahwa Anda akan menggunakan Voucher untuk membayar barang belanjaan Anda.
                            </li><li>Berikan informasi kode Voucher yang akan Anda gunakan ke Kasir. Anda dapat melihat kode voucher dan nilai kode voucher Anda pada tabel dibawah ini.
                            </li><li>Bila Voucher Anda benar, belum pernah digunakan dan belum mencapai tanggal expire, maka Voucher Anda akan bisa digunakan untuk mengurangi nilai belanja yang akan Anda bayar di kasir.
                            </li><li>Anda perlu untuk membaca syarat dan ketentuan untuk menggunakan kode voucher belanja.
                            </li><li>Kode Voucher Anda berlaku diseluruh wilayah Indonesia sesuai dengan nama toko yang disupport oleh Voucher tersebut.
                            </li>
                            </ul>
                            
                        </p>
                        ";

                    $email_merchant .= '<table style="border-collapse:collapse; width:100%;">
                        <tr style="background:#666666; color:white;" class="judul"><td width="5%" style="text-align:center">No</td>
                        <td width="35%">Nama Produk</td>
                        <td width="15%" style="text-align:center">Kode Voucher</td>
                        <td width="20%" style="text-align:center">Nominal</td>
                        <td width="20%" style="text-align:center">Tanggal expired</td>
                        </tr>';

                    $i=0;$total_voucher=0;
                    foreach ($list_voucher_data as $v)
                    {
                        $i++;
                        $vTglExpired = date('d M Y',strtotime($v['voucher_date_expired']));
                        if (date('Y',strtotime($v['voucher_date_expired']))=='1970') {
                            $vTglExpired = '-';
                        }
                        
                        $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td> 
                                <td style="text-align:left">Voucher Elektronik ' . $VoucherProduct->vsm_merchantname . '</td>
                                <td style="text-align:center"><b>' . $v['voucher_code'] . '</b></td>
                                <td style="text-align:right">Rp. ' . number_format($v['voucher_nominal'], 0, '.', ',') . '</td>                        
                                <td style="text-align:center">' . $vTglExpired . '</td>
                            </tr>';
                        $total_voucher += $v['voucher_nominal'];
                    }
                    $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="3" >Total Voucher</td>
                        <td >Rp. ' . number_format($total_voucher, 0, '.', ',') . '</td>
                        <td ></td>
                        </tr>            
                        </table>';
                            
                    $email_merchant .= '
                        <p>
                        Syarat dan ketentuan:
                            <ul>
                            <li>Semua Voucher yang telah dikirimkan oleh Cipika adalah Voucher yang tidak pernah digunakan sama sekali.
                            </li><li>Kode Voucher yang telah dikirimkan oleh Cipika tidak dapat ditukar atau digantikan dengan kode voucher lainnya karena alasan apapun. 
                            </li><li>Kode Voucher yang telah dikirimkan oleh Cipika tidak dapat dilakukan Refund maupun dibatalkan oleh karena alasan apapun.
                            </li><li>Kode Voucher yang Anda miliki dapat digunakan oleh siapapun. Cipika tidak bertanggung jawab bila kode voucher Anda diketahui oleh orang lain karena kelalaian Anda dalam mengamankan kode Voucher Anda.
                            </li><li>Kode Voucher yang telah melebihi expire date tidak dapat digantikan maupun dilakukan refund.
                            </li>
                            </ul>
                        </p>                
                            ';            

                    $email_merchant .= '<br/><p>
                                        Team Cipika.
                                        </p>
                            ';                
            }    
            switch ($VoucherProduct->vsm_merchantkode) {
                case "INDOMARET":
                case "ALFAMART":
                    /*
                    $email_merchant = "<h3>Yth. Bapak/Ibu " . $user->firstname ." " .$user->lastname.",</h3>
                        <p>
                            Terima kasih Anda telah berbelanja melalui Cipika Store. Anda dapat melihat semua kode Voucher Anda pada tabel dibawah ini. 
                        </p>
                        <p>
                        Cara mempergunakan kode Voucher Anda adalah:
                            <ul>
                            <li>Harap dipastikan Anda telah memilih produk yang nilainya sama atau lebih besar dari nilai Voucher yang akan Anda belanjakan. Hal ini dikarenakan bila masih ada nilai sisa Voucher, maka sisa Voucher tersebut tidak akan bisa digunakan kembali. 
                            </li><li>Pada saat Anda telah selesai berbelanja, katakan pada kasir bahwa Anda akan menggunakan Voucher untuk membayar barang belanjaan Anda.
                            </li><li>Berikan informasi kode Voucher yang akan Anda gunakan ke Kasir. Anda dapat melihat kode voucher dan nilai kode voucher Anda pada tabel dibawah ini.
                            </li><li>Bila Voucher Anda benar, belum pernah digunakan dan belum mencapai tanggal expire, maka Voucher Anda akan bisa digunakan untuk mengurangi nilai belanja yang akan Anda bayar di kasir.
                            </li><li>Anda perlu untuk membaca syarat dan ketentuan untuk menggunakan kode voucher belanja.
                            </li><li>Kode Voucher Anda berlaku diseluruh wilayah Indonesia sesuai dengan nama toko yang disupport oleh Voucher tersebut.
                            </li>
                            </ul>
                            
                        </p>
                        ";

                    $email_merchant .= '<table style="border-collapse:collapse; width:100%;">
                        <tr style="background:#666666; color:white;" class="judul"><td width="5%" style="text-align:center">No</td>
                        <td width="35%">Nama Produk</td>
                        <td width="15%" style="text-align:center">Kode Voucher</td>
                        <td width="20%" style="text-align:center">Nominal</td>
                        <td width="20%" style="text-align:center">Tanggal expired</td>
                        </tr>';

                    $i=0;$total_voucher=0;
                    foreach ($list_voucher_data as $v)
                    {
                        $i++;
                        $vTglExpired = date('d M Y',strtotime($v['voucher_date_expired']));
                        if (date('Y',strtotime($v['voucher_date_expired']))=='1970') {
                            $vTglExpired = '';
                        }
                        
                        $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td> 
                                <td style="text-align:left">Voucher Elektronik ' . $VoucherProduct->vsm_merchantname . '</td>
                                <td style="text-align:center"><b>' . $v['voucher_code'] . '</b></td>
                                <td style="text-align:right">Rp. ' . number_format($v['voucher_nominal'], 0, '.', ',') . '</td>                        
                                <td style="text-align:center">' . $vTglExpired . '</td>
                            </tr>';
                        $total_voucher += $v['voucher_nominal'];
                    }
                    $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="3" >Total Voucher</td>
                        <td >Rp. ' . number_format($total_voucher, 0, '.', ',') . '</td>
                        <td ></td>
                        </tr>            
                        </table>';
                            
                    $email_merchant .= '
                        <p>
                        Syarat dan ketentuan:
                            <ul>
                            <li>Semua Voucher yang telah dikirimkan oleh Cipika adalah Voucher yang tidak pernah digunakan sama sekali.
                            </li><li>Kode Voucher yang telah dikirimkan oleh Cipika tidak dapat ditukar atau digantikan dengan kode voucher lainnya karena alasan apapun. 
                            </li><li>Kode Voucher yang telah dikirimkan oleh Cipika tidak dapat dilakukan Refund maupun dibatalkan oleh karena alasan apapun.
                            </li><li>Kode Voucher yang Anda miliki dapat digunakan oleh siapapun. Cipika tidak bertanggung jawab bila kode voucher Anda diketahui oleh orang lain karena kelalaian Anda dalam mengamankan kode Voucher Anda.
                            </li><li>Kode Voucher yang telah melebihi expire date tidak dapat digantikan maupun dilakukan refund.
                            </li>
                            </ul>
                        </p>                
                            ';            

                    $email_merchant .= '<br/><p>
                                        Team Cipika.
                                        </p>
                            ';
                    */                
                    break;
                case "BOOKMATE1BLN":
                case "BOOKMATE3BLN":
                case "BOOKMATE12BLN":
                    $email_merchant = "<h3>Member Cipika Yth Bpk/Ibu " . $user->firstname ." " .$user->lastname.",</h3>
                        <p>
                            Berikut ini adalah detail promo code Cipika Bookmate yang telah Anda pesan dalam Inv No. ".$invoice->kode_invoice." 
                        </p>
                        ";

//                            <tr style="border-color:white;" >
//                            <td width="30%">Kode Order</td>
//                            <td width="70%" style="text-align:left">'.$orderdetail->kode_order.'</td>
//                            </tr>
//                    foreach ($orderdetail as $val) {

//                            <tr style="border-color:white;" >
//                            <td width="30%">Tgl Transaksi </td>
//                            <td width="70%" style="text-align:left">'.date('d M Y',strtotime($orderdetail->date_added)).'</td>
//                            </tr>

                            $email_merchant .= '
                        <table style="border-collapse:collapse; width:60%;">
                            <tr style="border-color:white;" >
                            <td width="30%">Merchant</td>
                            <td width="70%" style="text-align:left">Cipika Bookmate</td>
                            </tr>
                            <tr style="border-color:white;" >
                            <td width="30%">Payment</td>
                            <td width="70%" style="text-align:left">'.$payment->nama_payment.'</td>
                            </tr>
                        </table>';
//                    }

                    $email_merchant .= '<b>Daftar Promo Code :</b><br><br> 
                    <table style="border-collapse:collapse; width:100%;">
                        <tr style="background:#666666; color:white;" class="judul"><td width="5%" style="text-align:center">No</td>
                        <td width="35%">Nama Produk</td>
                        <td width="15%" style="text-align:center">Promo Code</td>
                        <td width="20%" style="text-align:center">Nominal</td>
                        <td width="20%" style="text-align:center">Tanggal expired</td>
                        </tr>';

                    $i=0;$total_voucher=0;
                    foreach ($list_voucher_data as $v)
                    {
                        $i++;
                        $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td> 
                                <td style="text-align:left">Voucher Elektronik ' . $VoucherProduct->vsm_merchantname . '</td>
                                <td style="text-align:center"><b>' . $v['voucher_code'] . '</b></td>
                                <td style="text-align:right">Rp. ' . number_format($v['voucher_nominal'], 0, '.', ',') . '</td>                        
                                <td style="text-align:center">' . date('d M Y',strtotime($v['voucher_date_expired'])) . '</td>
                            </tr>';
                        $total_voucher += $v['voucher_nominal'];
                    }
                    $email_merchant .= ' 
                        </table>';
                            
                    $email_merchant .= "
                        <p>
                        Perhatikan batas waktu redeem/penggunaan promo code dan pastikan Anda telah menggunakannya sebelum masa berlaku berakhir. Penukaran lebih dari 1 (satu) promo code dalam 1 (satu) akun yang sama, secara otomatis akan memperpanjang masa berlaku paket langganan Anda. Petunjuk Penggunaan Promo Code selengkapnya dapat Anda temukan di <a href='http://bit.ly/1HDr5Lt'><b>http://bit.ly/1HDr5Lt</b></a>. 
                        <br>
                        <b>Cara Penggunaan Promo Code di Perangkat Android:</b>
                            <ul>
                            <li>Login dengan akun Anda melalui Mobile App
                            </li><li>Klik Ikon <b>Profil></b> Klik Menu <b>Setting</b>
                            </li><li>Masukkan Promo Code pada field </b>“ENTER THE PROMO CODE”</b>. Perhatikan besar kecil huruf dan kombinasi kodenya. Promo Code bersifat case sensitive. Perhatikan pula masa berlaku Promo Code yang Anda miliki
                            </li><li>Cek Masa Berlaku Paket Langganan Anda di Menu Pengaturan yang sama. Masa Berlaku paket langganan akan sesuai dengan benefit dari tiap Promo Code yang Anda tukarkan
                            </li><li>Ulangi langkah 1 s.d 5 apabila Anda memiliki 2 atau lebih Promo Code. Setiap Promo Code yang Anda tukarkan, akan menambah masa berlangganan secara otomatis
                            </li>
                            </ul>
                            
                        </b>Cara Penggunaan Promo Code di Perangkat iOS:</b>
                            <ul>
                            <li>Kunjungi <a href='www.bookmate.com'>www.bookmate.com</a> melalui web browser kesayangan Anda
                            </li><li>Login dengan akun Bookmate yang sama, seperti yang biasa Anda gunakan di perangkan iOS Anda
                            </li><li>Redeem promo code sesuai petunjuk yang tersedia disini
                            </li><li>Setelah penukaran promo code berhasil, login kembali ke perangkat iOS Anda.
                            </li>
                            </ul>
                        </p>                
                            ";            

                    $email_merchant .= '<p>
                                        Salam,<br>Cipika Store
                                        </p>
                            ';    
                    break;


                    default:
            }
             
            if (substr($VoucherProduct->vsm_merchantkode,0,14)=='PERSIB_TICKET_') {
                    $email_merchant = "
                    <h3>Yth. Bapak/Ibu " . $user->firstname ." " .$user->lastname.",</h3>
                    <h3>No Anggota : " . $user->hp ."</h3>
                        <p>
                            Terima kasih Anda telah melakukan pembelian tiket pertandingan Persib. Anda dapat melihat semua kode tiket Anda pada tabel dibawah ini. 
                        </p>
                        ";

                    $email_merchant .= '<table style="border-collapse:collapse; width:100%;">
                        <tr style="background:#666666; color:white;" class="judul"><td width="5%" style="text-align:center">No</td>
                        <td width="35%">Nama & Tribun Pertandingan</td>
                        <td width="15%" style="text-align:center">Kode Tiket</td>
                        <td width="20%" style="text-align:center">Harga Tiket</td>
                        </tr>
                        ';

                    $i=0;$total_voucher=0;
                    foreach ($list_voucher_data as $v)
                    {
                        $i++;
                        $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td> 
                                <td style="text-align:left">' . $VoucherProduct->vsm_merchantname . '</td>
                                <td style="text-align:center"><b>' . $v['voucher_code'] . '</b></td>
                                <td style="text-align:right">Rp. ' . number_format($v['voucher_nominal'], 0, '.', ',') . '</td>                        
                            </tr>';
                        $total_voucher += $v['voucher_nominal'];
                    }
                    $grandTotal_additionfee=0;


                    foreach ($orderdetail as $v) {
                        foreach ($order_item[$v->id_order] as $items)
                        {
                            $grandTotal_additionfee += $items->additional_fee;
                        }        
                    }

                    if ($grandTotal_additionfee>0) {
                        $email_merchant .= '<tr style="text-align:right"><td colspan="3" >Biaya administrasi</td>
                            <td >Rp. ' . number_format($grandTotal_additionfee, 0, '.', ',') . '</td>
                            </tr>            
                            ';
                    }                            
                    $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="3" >Total</td>
                        <td >Rp. ' . number_format($total_voucher+$grandTotal_additionfee, 0, '.', ',') . '</td>
                        </tr>            
                        </table>';
                    $email_merchant .= '
                        <p>
                        Cara menggunakan kode tiket Anda adalah:
                        <ul>
                        <li>Simpan dan catat baik baik kode tiket dan tunjukkan kode tiket diatas kepada petugas loket penukaran tiket. </li>
                        <li>Silahkan membawa identitas diri dan kartu anggota pada saat penukaran tiket. </li>
                        <li>Kode tersebut akan ditukar dengan tiket pertandingan. Penukaran Tiket : Graha Persib Sulanjana, Sabtu 8 April 2017 pukul 09.00 s/d 14.00    </li>
                        <li>Kode tiket ini hanya berlaku untuk pertandingan ini, tidak dapat digunakan untuk pertandingan yang lain. </li>
                        <li>Kode Tiket ini juga dikirimkan melalui SMS ke nomor Keanggotaan anda : <b>' . $user->hp .'</b>.</li>
                        <li>Untuk pertanyaan lebih lanjut mengenai waktu dan tempat penukaran tiket silahkan menghubungi email cs@persib.co.id, atau call center Persib di <strong>08569019444</strong>. </li>
                        </ul>
                        </p>
                            ';            

                    $email_merchant .= '<p>
                                        Persib salawasna. Hatur Nuhun.
                                        </p>
                            ';    
            }    
            
            if (substr($VoucherProduct->vsm_merchantkode,0,6)=='CPLAY_') {
                    $email_merchant = "<h3>Yth Bpk/Ibu " . $user->firstname ." " .$user->lastname.",</h3>
                        <p>
                            Berikut ini adalah detail voucher code CIPIKA PLAY yang telah Anda pesan dalam Invoice No. <b>".$invoice->kode_invoice."</b>. 
                        </p>
                        ";

                        $vDateAdded='';
                        foreach ($orderdetail as $v) {
                            foreach ($order_item[$v->id_order] as $items)
                            {
                                $vDateAdded=date('d M Y',strtotime($items->date_added));    
                            }        
                        }
                    
                        $email_merchant .= '
                        <table style="border-collapse:collapse; width:60%;">
                            <tr style="border-color:white;" >
                            <td width="30%">Merchant</td>
                            <td width="70%" style="text-align:left">CIPIKA PLAY</td>
                            </tr>
                            <tr style="border-color:white;" >
                            <td width="30%">Tgl Transaksi </td>
                            <td width="70%" style="text-align:left">'.$vDateAdded.'</td>
                            </tr>
                            <tr style="border-color:white;" >
                            <td width="30%">Payment</td>
                            <td width="70%" style="text-align:left">'.$payment->nama_payment.'</td>
                            </tr>
                        </table>';

                    $email_merchant .= '<br><b>Daftar Promo Code :</b><br> 
                    <table style="border-collapse:collapse; width:100%;">
                        <tr style="background:#666666; color:white;" class="judul"><td width="5%" style="text-align:center">No</td>
                        <td width="35%">Nama Produk</td>
                        <td width="15%" style="text-align:center">Voucher Code</td>
                        <td width="20%" style="text-align:center">Nominal</td>
                        <td width="20%" style="text-align:center">Tanggal expired</td>
                        </tr>';

                    $i=0;$total_voucher=0;
                    foreach ($list_voucher_data as $v)
                    {
                        $i++;
                        $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td> 
                                <td style="text-align:left">Voucher Elektronik ' . $VoucherProduct->vsm_merchantname . '</td>
                                <td style="text-align:center"><b>' . $v['voucher_code'] . '</b></td>
                                <td style="text-align:right">Rp. ' . number_format($v['voucher_nominal'], 0, '.', ',') . '</td>                        
                                <td style="text-align:center">' . date('d M Y',strtotime($v['voucher_date_expired'])) . '</td>
                            </tr>';
                        $total_voucher += $v['voucher_nominal'];
                    }
                    $email_merchant .= ' 
                        </table>';
                            
                    $email_merchant .= '
                        <br>
                        <b>ATURAN Penggunaan Voucher:</b>
                            <ul>
                            <li>Voucher promo Cipika Play hanya bisa digunakan di website <a href="http://play.cipika.co.id">play.cipika.co.id</a>
                            </li><li>Voucher ini tidak bisa ditukar atau diuangkan kembali
                            </li><li>Pengguna harus melakukan mendaftarkan email sebelum menggunakan voucher
                            </li><li>1 kode voucher ini hanya bisa digunakan 1x untuk setiap transaksi
                            </li><li>Voucher bisa digunakan untuk membeli semua produk yang tersedia di website Cipika Play
                            </li><li>Kalau nilai di dalam voucher di bawah harga produk, pengguna bisa menambahkan kekurangannya menggunakan Cipika Play point atau menggunakan Indosat Dompetku
                            </li><li>Kalau nilai di dalam voucher di atas harga produk, kelebihan nilai akan menjadi Cipika Play point
                            </li><li>Semua kode voucher memiliki masa batas waktu
                            </li><li>1 akun user hanya bisa membeli 5 voucher per hari
                            </li>
                            </ul>
                            
                        <b>Cara penggunaan Cipika Play voucher:</b>
                            <ul>
                            <li>Penggunakan melakukan login di website <a href="http://play.cipika.co.id">play.cipika.co.id</a>
                            </li><li>masukkan email dan password di kolom yang tersedia
                            </li><li>Pengguna masuk ke halaman produk
                            </li><li>Pengguna memilih produk yang ingin dibeli
                            </li><li>Pengguna masuk ke halaman pembayaran
                            </li><li>Pengguna memasukkan kode voucher di kotak yang disediakan
                            </li><li>Pengguna klik tanda centang hijau
                            </li><li>Klik <u><b>"Pay Now"</b></u>
                            </li><li>Cek order history untuk melihat kode voucher dari produk yang sudah dibeli
                            </li>
                            </ul>
                        </p>                
                            ';            

                    $email_merchant .= 'Salam,<br>Cipika Store                                        
                            ';                  
            }

            if (trim($email_merchant)=='') {
            // content email voucher umum    
                    $email_merchant = "<h3>Yth Bpk/Ibu " . $user->firstname ." " .$user->lastname.",</h3>
                        <p>
                            Berikut ini adalah detail voucher code yang telah Anda pesan dalam Invoice No. <b>".$invoice->kode_invoice."</b>. 
                        </p>
                        ";

                        $vDateAdded='';
                        foreach ($orderdetail as $v) {
                            foreach ($order_item[$v->id_order] as $items)
                            {
                                $vDateAdded=date('d M Y',strtotime($items->date_added));    
                            }        
                        }
                        
                        $email_merchant .= '
                        <table style="border-collapse:collapse; width:60%;">
                            <tr style="border-color:white;" >
                            <td width="30%">Tgl Transaksi </td>
                            <td width="70%" style="text-align:left">'.$vDateAdded.'</td>
                            </tr>
                            <tr style="border-color:white;" >
                            <td width="30%">Payment</td>
                            <td width="70%" style="text-align:left">'.$payment->nama_payment.'</td>
                            </tr>
                        </table>';

                    $email_merchant .= '<br><b>Daftar Voucher Code :</b><br> 
                    <table style="border-collapse:collapse; width:100%;">
                        <tr style="background:#666666; color:white;" class="judul"><td width="5%" style="text-align:center">No</td>
                        <td width="35%">Nama Produk</td>
                        <td width="15%" style="text-align:center">Voucher Code</td>
                        <td width="20%" style="text-align:center">Nominal</td>
                        <td width="20%" style="text-align:center">Tanggal expired</td>
                        </tr>';

                    $i=0;$total_voucher=0;
                    foreach ($list_voucher_data as $v)
                    {
                        $i++;
                        $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td> 
                                <td style="text-align:left">Voucher Elektronik ' . $VoucherProduct->vsm_merchantname . '</td>
                                <td style="text-align:center"><b>' . $v['voucher_code'] . '</b></td>
                                <td style="text-align:right">Rp. ' . number_format($v['voucher_nominal'], 0, '.', ',') . '</td>                        
                                <td style="text-align:center">' . date('d M Y',strtotime($v['voucher_date_expired'])) . '</td>
                            </tr>';
                        $total_voucher += $v['voucher_nominal'];
                    }
                    $email_merchant .= ' 
                        </table>';
                            
                    $email_merchant .= '
                            ';            

                    $email_merchant .= 'Salam,<br>Cipika Store
                                        
                            ';               
            }

            $insert = array('idmailer' => null,
                'mailer_module' => 'Product Voucher',
                'mailer_from' => $this->from,
                'mailer_to' => $user->email,
                'mailer_subject' => 'Kode Voucher Elektronik '.$VoucherProduct->vsm_merchantname.'',
                'mailer_message' => $email_merchant,
                'mailer_status' => 'new',
                'mailer_created' => date('Y-m-d H:i:s')
            );
            $this->dbLibrary->insert('mailer', $insert);
            return $this->dbLibrary->insert_id();
                    
        }    

    }

    public function sendNotifBuyer($dataOrder, $detUser)
    {
        $email_buyer = "";
        $email_buyer.= "<h3>Bapak/Ibu " . ucwords($detUser->firstname) . " " . ucwords($detUser->lastname) . " Yth.</h3>
                <br/>
                <p>
                    Transaksi anda dengan Kode order <strong>".htmlspecialchars($dataOrder->kode_order)."</strong>
                    masih dalam proses <strong>Refund</strong>. Kami membutuhkan waktu verifikasi atas data yang kami terima maksimal
                    1 x 24 jam pada hari kerja. Demikian kami sampaikan, mohon berkenan menunggu dan terima kasih.</p><br>
                ";
        $email_buyer.= '<br/><p>Salam,<br/>
                    <strong>Cipika Store &trade;</strong><br/>
                    Semuanya Menjadi Mudah
                    </p>
                    ';
        $list = $this->bcc;
        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Informasi Order Refund Pembeli',
            'mailer_from' => $this->from,
            'mailer_to' => $detUser->email,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Order Refund ['.$dataOrder->kode_order.']',
            'mailer_message' => $email_buyer,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );

        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }
    
    public function mobo_sends($to, $single, $inputan_order, $inputan_shipping, $inputan_merchant, $order_item, $link_index, $payment, $user, $orderItemCicilan = null, $mobo_outlet = null)
    {
        $email_merchant = "<h3>Bapak/Ibu " . ucwords($user->firstname) . " " . ucwords($user->lastname) . " Yth.</h3>
                <p>
                    Terima kasih anda telah menyelesaikan penukaran KOIN. 
                    Kami telah mencatat daftar belanja dan pembayaran Anda dengan baik.
                </p>
                <p>
                    Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. 
                    Kami akan memberikan informasi melalui email, apabila kami membutuhkan perpanjangan waktu pengiriman  yang disebabkan oleh 
                    alasan dan pertimbangan tertentu, guna menjaga kualitas layanan Cipika Store.
                </p>
                <hr>
                ";
        $totalPrint = 0;
        $totalAll = 0;
        $totalPrintKoin=0;
        foreach ($inputan_order as $v)
        {
            $getMerchantDetailSql = "select merchant_voucher_reload from tbl_store where id_user = " . (int) $v->id_merchant . ";";
            $merchantVoucherReload = $this->dbLibrary->query($getMerchantDetailSql)->row()->merchant_voucher_reload;
            
            $getOrderVoucherReloadSql = "select oivr.nomer_hp from tbl_order o, tbl_orderitem_voucher_reload oivr where o.id_order = " . (int) $v->id_order . " and o.id_order = oivr.id_order;";
            $getPhoneVoucherReload = $this->dbLibrary->query($getOrderVoucherReloadSql)->row();

            $phoneVoucherReload = (!empty($getPhoneVoucherReload->nomer_hp)) ? $getPhoneVoucherReload->nomer_hp : "";

            $email_merchant .= "<table width='100%'>
                            <tr>
                                <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                <td width='20%'>Status: Sukses</td>
                            </tr>
                        </table>";
            $email_merchant .= "<table width='100%'>
                            <tr>";
            $vIdOutlet='';
            if (isset($mobo_outlet->mbo_outlet_id)) { $vIdOutlet=$mobo_outlet->mbo_outlet_id;}                    
            if ($merchantVoucherReload != "Y") {
                $email_merchant .= "<td width='40%' valign='top'>
                                    <strong>Alamat Pengiriman</strong><br /><span></span>
                                    " . ucwords($inputan_shipping[$v->id_order]->nama) . "<br />
                                    ";
                if ($vIdOutlet<>'') {
                    $email_merchant .= "ID Outlet : ".$vIdOutlet."<br>";
                }
                $email_merchant .= "" . ucwords($inputan_shipping[$v->id_order]->alamat) . "<br>
                                    " . ucwords($inputan_shipping[$v->id_order]->nama_kabupaten) . " - " . ucwords($inputan_shipping[$v->id_order]->nama_propinsi) . "<br>
                                    " . $inputan_shipping[$v->id_order]->telpon . "
                                </td>";
            } else {
                $email_merchant .= "<td width='40%' valign='top'>
                                    <strong>Nomor Tujuan</strong><br /><span></span>
                                    " . $phoneVoucherReload . "<br />
                                </td>";
            }
            $email_merchant .= "<td width='40%' valign='top'>
                                    <strong>Metode Pengiriman</strong><br />
                                    " . ucwords($v->paket_ongkir) . "
                                </td>
                               <td width='20%' valign='top'>
                                    <strong>Metode Pembayaran</strong><br>";
            $email_merchant.= $payment->nama_payment;
            $detailPaymentCicilan = null;
            if ($orderItemCicilan != null) {
                foreach ($orderItemCicilan[$v->id_order] as $val) {
                    $email_merchant .= "<br>" . $val;
                }
            }
            $email_merchant .= "</td>
                            </tr>
                            </table><br>";
            $email_merchant .= '<table style="border-collapse:collapse; width:100%;">
                <tr style="background:#666666; color:white;" class="judul">
                    <td width="10%" style="text-align:center">No</td>
                    <td>Nama Produk</td>
                    <td width="10%" style="text-align:right">Jumlah</td>
                    <td width="10%" style="text-align:right">Harga KOIN</td>
                    <td width="15%" style="text-align:right">Harga (Rp.)</td>
                    <td width="10%" style="text-align:right">Diskon</td>
                    <td width="20%" style="text-align:right">Subtotal</td>
                </tr>';
            $i = 0;
            $total_sub = 0;
            $sub_total = 0;
            $sub_total_koin=0;
            $detailPaket = "";
            foreach ($order_item[$v->id_order] as $items)
            {
                $total_ongkir = $row->ongkir_sementara;
                if ($items->total_mobo_bayar_koin==0) {
                    $total = ($items->harga - $items->diskon_rp) * $items->jml_produk;
                    $subtotal += $total;
                    $total_harga = $subtotal + $total_ongkir;
                } else {
                    $total_ongkir=0;
                    if ($items->total_mobo_bayar_rupiah>0) {
                        $total = ($items->total_mobo_bayar_rupiah);
                        $subtotal += $total;
                        $total_harga = $subtotal + 0;
                    } else {
                        $total = 0;
                        $subtotal += $total;
                        $total_harga = $subtotal + 0;
                    }    
                }

                $kointotal += $items->total_mobo_bayar_koin;
                $kolSubtotal='';
                $tambahanKoin='';
                if ($items->total_mobo_bayar_koin>0) {
                    $tambahanKoin=format_uang($items->total_mobo_bayar_koin).' KOIN + ';
                }
                $kolSubtotal=str_replace(' ','&nbsp;',$tambahanKoin."Rp " . format_uang($total));

                //$harga_diskon = $items->total_mobo_bayar_rupiah - $items->diskon_rp;
                //$total_sub = $harga_diskon * $items->jml_produk;
                //$harga_diskon = $items->harga - $items->diskon_rp;
                //$total_sub = $harga_diskon * $items->jml_produk;
                $i++;
                $detailPaket = !empty($items->detail_paket)?'<br>('.$items->detail_paket.')':'';
                $stringPhoneVoucherReload = !empty($phoneVoucherReload)?'<br>Pembelian pulsa untuk nomor : <strong>'. $phoneVoucherReload .'</strong>':'';
                $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td> 
                        <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a>'.$detailPaket . $stringPhoneVoucherReload.'</td>
                        <td style="text-align:right">' . $items->jml_produk . '</td>
                        <td style="text-align:right">' . number_format($items->total_mobo_bayar_koin/$items->jml_produk, 0 , '' , '.' ) . ' KOIN</td>                        
                        <td style="text-align:right">Rp. ' . number_format($items->harga, 0 , '' , '.' ) . '</td>                        
                        <td style="text-align:right">' . $items->diskon . '%</td>
                                    <td style="text-align:right">'.$kolSubtotal. '</td>
                    </tr>';
                $sub_total += $total_sub;
                $sub_total_koin  +=$items->total_mobo_bayar_koin;
            }
            $grant_total = $grant_total + $total_harga;
            $grant_totalkoin = $grant_totalkoin + $kointotal;
            $tambahanKoin='';
            if ($kointotal>0) {
                $tambahanKoin=format_uang($kointotal).' KOIN + ';
            }
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >'.$tambahanKoin.'Rp ' . format_uang($subtotal). '</td></tr>';
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . format_uang($total_ongkir) . '</td></tr>';
            //$total_harga = $sub_total + $v->ongkir_sementara;
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >'.$tambahanKoin.'Rp ' . format_uang($total_harga). '</td></tr>            
                            </table><div style="height:10px;"></div>';
/*
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . number_format($sub_total, 0, '.', ',') . '</td></tr>';
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . number_format($v->ongkir_sementara, 0, '.', ',') . '</td></tr>';
            $total_harga = $sub_total + $v->ongkir_sementara;
            $email_merchant .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . number_format($total_harga, 0, '.', ',') . '</td></tr>            
                </table><div style="height:10px;"></div>';
*/  
            $totalAll+=$total_harga;
            $totalPrintKoin+=$sub_total_koin;
        }
        $tambahanKoin='';
        if ($grant_totalkoin>0) {
            $tambahanKoin=format_uang($grant_totalkoin).' KOIN + ';
        }
        //$totalPrint = $totalAll + $single->payment_fee;
        //$totalPrint = ($single->total + $single->ongkir + $single->mdr_installment) - $single->potongan_voucher - $single->potongan_point_rp;
/*
        if ((int) $single->payment_fee > 0)
        {
            $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Convenience Fee</td>
                    <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                </tr>
            </table>";
        }
        if ((int) $single->potongan_voucher > 0)
        {
            $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Potongan Voucher : " . htmlspecialchars($single->voucher) . "</td>
                    <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_voucher, 0, '.', ',')) . "</td>
                </tr>
            </table>";
        }
        if ($single->potongan_point_rp > 0)
        {
            $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Potongan Point : " . htmlspecialchars($single->potongan_point) . " (1 point = Rp. " . htmlspecialchars(number_format($single->potongan_point_rp / $single->potongan_point, 0, '.', ',')) . ")</td>
                    <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_point_rp, 0, '.', ',')) . "</td>
                </tr>
            </table>";
        }
        if ((int) $single->mdr_installment > 0)
        {
            $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Biaya Administrasi</td>
                    <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->mdr_installment, 0, '.', ',')) . "</td>
                </tr>
            </table>";
        }
*/
        $email_merchant .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Grand Total </td>
                    <td width='20%' style='text-align: right;'>".$tambahanKoin.'Rp ' . format_uang($grant_total). "</td>
                </tr>
            </table><br>";
        $email_merchant .="
                    <p>Kami sarankan Anda menyimpan dengan baik bukti pembayaran 
                    hingga produk telah Anda terima dan transaksi dinyatakan selesai.</p>
                    <p>Untuk informasi, silahkan menghubungi e-care.store@cipika.co.id. 
                    Terima kasih atas kepercayaan Anda berbelanja di Cipika Store.</p>";
        $email_merchant .= '<br/><p>Terima Kasih,<br/><br/><br/>
                    <strong>Cipika Store &trade;</strong><br>
                    <a href="' . base_url() . '">cipika.co.id</a>
                    </p>
                    ';
        $list = $this->bcc;
        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Konfirmasi Pembayaran',
            'mailer_from' => $this->from,
            'mailer_to' => $to,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Terima Kasih! Pembayaran & Pembelian telah Tercatat',
            'mailer_message' => $email_merchant,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }    
    
}
