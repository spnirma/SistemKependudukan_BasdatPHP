<?php

namespace Cipika\View\Helper;

class EmailBuyerPembelian {

    protected $dbLibrary;
    protected $from;

    public function __construct($dbLibrary, $from)
    {
        $this->dbLibrary = $dbLibrary;
        $this->from = $from;
    }

    public function sendEmailPembelian($to, $single, $inputan_order, $inputan_shipping, 
            $inputan_merchant, $order_item, $link_index, $payment, $user, $id_payment, $invoice_address, $metpayment)
    {
        $email= "";
        if ($id_payment == 1) {
            $email .= "<h3>Bapak/Ibu " . $invoice_address->nama . " Yth.</h3>
                    <br />
                    <p>
                        Terima kasih Anda telah berbelanja melalui CipikaStore. Silahkan lakukan pembayaran Biaya Transaksi sesuai nilai yang tertera dalam Invoice, ke rekening CipikaStore berikut:
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
                            <td><strong>" . $payment->respond . "</strong></td>
                    </tr>
                    </table>";
            $waktu_exp = date('d-m-Y H:i:s', mktime(date('H') + 4, date('i'), date('s'), date('m'), date('d'), date('Y')));
            $email .= "<p>Pembayaran dapat Anda lakukan melalui Jaringan <strong>ATM Bersama</strong>, <strong>PRIMA</strong>, dan <strong>ALTO</strong>. Anda juga diperkenankan memanfaatkan kemudahan fasilitas E-Banking yang dilengkapi menu <strong>Transfer Bank Online</strong>, namun pastikan fasilitas pembayaran yang Anda gunakan tidak memerlukan proses kliring. <br>
                    Pastikan Anda menyelesaikan pembayaran sebelum " . $waktu_exp . ". Apabila melebihi periode tersebut, maka Virtual Account (VAN ID) secara otomatis ditutup dan transaksi tidak diproses lebih lanjut.</p>
                    <hr/>    
                    <table style='margin: 2em 0;'>
                        <tr>
                            <td style='width: 200px'>Invoice No</td>
                            <td style='width: px'>:</td>
                            <td><strong>" . $single->kode_invoice . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nama</td>
                            <td style='width: px'>:</td>
                            <td>" . $invoice_address->nama . "</td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Alamat</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $invoice_address->alamat . " , " . ucfirst(strtolower($invoice_address->nama_kota)) . ", " . ucfirst($invoice_address->nama_provinsi) . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Telp</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $user->telpon . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Handphone</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $user->hp . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Total Harga</td>
                            <td style='width: 4px'>:</td>
                            <td><strong>Rp " . number_format($single->total + $single->ongkir + $single->payment_fee, 0, '.' , ',') . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Tanggal</td>
                            <td style='width: 4px'>:</td>
                            <td><strong>" . date('d-m-Y H:i:s') . "</strong></td>
                        </tr>

                        </table>";
        } elseif ($id_payment == 5) {
            $email .= "
                <p><strong>Bapak/Ibu Yth. " . $invoice_address->nama . "</strong><br />Terima kasih Anda 
                    telah berbelanja melalui Cipika Store. Apabila saldo yang ada pada Akun DompetKu anda 
                    mencukupi, maka secara otomatis pemesanan akan di proses lebih lanjut.</p>
                <p>Pengiriman barang akan dilakukan dalam waktu 7 hari kerja. Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan 
                yang telah disepakati. Anda akan menerima informasi lebih lanjut apabila diperlukan perpanjangan waktu pengiriman.</p>
                <br>
                <table style='margin: 2em 0;'>
                    <tr>
                        <td style='width: 200px'>Nomer Akun DompetKU</td>
                        <td style='width: px'> : </td>
                        <td>" . $payment->msisdn . "</td>
                    </tr>
                    <tr>
                        <td style='width: 200px'>Jumlah yang sudah terbayar</td>
                        <td style='width: 4px'> : </td>
                        <td><strong> Rp " . number_format($single->total + $single->ongkir + $single->payment_fee, 0, '.' , ',')  . "</strong></td>
                    </tr>
                </table>";
        } elseif ($id_payment == 6) {
            $email .= "
                <p>
                    <strong>Bapak/Ibu Yth. " . $invoice_address->nama . "</strong><br />
                    Terima kasih Anda telah berbelanja melalui Cipika Store.
                </p>
                <p>
                        Pengiriman barang akan dilakukan dalam waktu 7 hari kerja.
                        Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. Anda akan menerima informasi lebih lanjut apabila diperlukan perpanjangan waktu pengiriman.
                    </p><br>
                <table style='margin: 2em 0;'>
                    <tr>
                        <td style='width: 200px'>Kode Transaksi Mandiri ClickPay</td>
                        <td style='width: px'> : </td>
                        <td>" . $payment->respond . "</td>
                    </tr>
                    <tr>
                        <td style='width: 200px'>Jumlah yang sudah terbayar</td>
                        <td style='width: 4px'> : </td>
                        <td><strong> Rp " . number_format($single->total + $single->ongkir + $single->payment_fee, 0, '.', ',') . "</strong></td>
                    </tr>
                </table>";
        } elseif ($id_payment == 9) {
            $email .= "<h3>Bapak/Ibu " . $invoice_address->nama . " Yth.</h3>
                    <br />
                    <p>
                        Terima kasih Anda telah berbelanja melalui CipikaStore. Silahkan lakukan pembayaran Biaya Transaksi sesuai nilai yang tertera dalam Invoice, ke rekening CipikaStore berikut:
                    </p>
                    <table style='margin: 2em 0;'>
                        <tr>
                            <td style='width: 200px'>Nama Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>BANK MANDIRI Cabang Jakarta Thamrin</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Pemilik Rekening</td>
                            <td style='width: px'>:</td>
                            <td><strong>PT Indosat Tbk</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nomor Rekening</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . NO_REK_OF_BANK_MANDIRI_TRANSFER . "</strong></td>
                    </tr>
                    </table>";
            $waktu_exp = date('d-m-Y H:i:s', mktime(date('H') + 4, date('i'), date('s'), date('m'), date('d'), date('Y')));
            $email .= "
                    <p>
                        Pembayaran dapat Anda lakukan melalui Jaringan <strong>ATM Bersama</strong>, <strong>PRIMA</strong>, dan <strong>ALTO</strong>. Anda juga diperkenankan memanfaatkan kemudahan fasilitas E-Banking yang dilengkapi menu <strong>Transfer Bank Online</strong>. <br>
                    </p>
                    <p>
                        Pastikan Anda menyelesaikan pembayaran dan konfirmasi sebelum (" . $waktu_exp . "). Apabila melebihi periode tersebut, maka transaksi tidak diproses lebih lanjut.
                    </p>
                    <p>
                        Apabila anda sudah melakukan pembayaran sesuai yang dibayarkan anda bisa langsung mengkonfirmasi pembayaran anda melalui Alamat ini: " . base_url('order/konfirmasi') . ". Apabila Anda telah melakukan pembayaran dan batas waktu konfirmasi pembayaran telah habis, segera konfirmasikan pembayaran Anda melalui e-care.store@cipika.co.id.
                    </p>
                    <table style='margin: 2em 0;'>
                        <tr>
                            <td style='width: 200px'>Invoice No</td>
                            <td style='width: px'>:</td>
                            <td><strong>" . $single->kode_invoice . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nama</td>
                            <td style='width: px'>:</td>
                            <td>" . $invoice_address->nama . "</td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Alamat</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $invoice_address->alamat . " , " . ucfirst(strtolower($invoice_address->nama_kota)) . ", " . ucfirst($invoice_address->nama_provinsi) . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Telp</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $user->telpon . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Handphone</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $user->hp . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Total Harga</td>
                            <td style='width: 4px'>:</td>
                            <td><strong>Rp " . number_format($single->total + $single->ongkir + $single->payment_fee, 0, '.', ',')  . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Tanggal</td>
                            <td style='width: 4px'>:</td>
                            <td><strong>" . date('d-m-Y H:i:s') . "</strong></td>
                        </tr>

                        </table>";
        } elseif ($id_payment == 10) {
            $email .= "<h3>Bapak/Ibu " . $invoice_address->nama . " Yth.</h3>
                    <br />
                    <p>
                        Terima kasih Anda telah berbelanja melalui CipikaStore. Silahkan lakukan pembayaran Biaya Transaksi sesuai nilai yang tertera dalam Invoice, ke rekening CipikaStore berikut:
                    </p>
                    <table style='margin: 2em 0;'>
                        <tr>
                            <td style='width: 200px'>Nama Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>BANK BCA Wisma Asia</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>A/C</td>
                            <td style='width: px'>:</td>
                            <td><strong>PT Indosat Tbk</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nomor Rekening</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . NO_REK_OF_BANK_BCA_TRANSFER . "</strong></td>
                    </tr>
                    </table>";
            $waktu_exp = date('d-m-Y H:i:s', mktime(date('H') + 4, date('i'), date('s'), date('m'), date('d'), date('Y')));
            $email .= "
                    <p>
                        Pembayaran dapat Anda lakukan melalui Jaringan <strong>ATM Bersama</strong>, <strong>PRIMA</strong>, dan <strong>ALTO</strong>. Anda juga diperkenankan memanfaatkan kemudahan fasilitas E-Banking yang dilengkapi menu <strong>Transfer Bank Online</strong>. <br>
                    </p>
                    <p>
                        Pastikan Anda menyelesaikan pembayaran dan konfirmasi sebelum (" . $waktu_exp . "). Apabila melebihi periode tersebut, maka transaksi tidak diproses lebih lanjut.
                    </p>
                    <p>
                        Apabila anda sudah melakukan pembayaran sesuai yang dibayarkan anda bisa langsung mengkonfirmasi pembayaran anda melalui Alamat ini: " . base_url('order/konfirmasi') . ". Apabila Anda telah melakukan pembayaran dan batas waktu konfirmasi pembayaran telah habis, segera konfirmasikan pembayaran Anda melalui e-care.store@cipika.co.id.
                    </p>
                    <table style='margin: 2em 0;'>
                        <tr>
                            <td style='width: 200px'>Invoice No</td>
                            <td style='width: px'>:</td>
                            <td><strong>" . $single->kode_invoice . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nama</td>
                            <td style='width: px'>:</td>
                            <td>" . $invoice_address->nama . "</td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Alamat</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $invoice_address->alamat . " , " . ucfirst(strtolower($invoice_address->nama_kota)) . ", " . ucfirst($invoice_address->nama_provinsi) . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Telp</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $user->telpon . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Handphone</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $user->hp . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Total Harga</td>
                            <td style='width: 4px'>:</td>
                            <td><strong>Rp " . number_format($single->total + $single->ongkir + $single->payment_fee, 0, '.', ',') . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Tanggal</td>
                            <td style='width: 4px'>:</td>
                            <td><strong>" . date('d-m-Y H:i:s') . "</strong></td>
                        </tr>

                        </table>";
        } else {
            $email .= "<p>
                    <strong>Bapak/Ibu Yth. " . $user->firstname . " " . $user->lastname . "</strong><br />
                    Terima kasih Anda telah berbelanja melalui Cipika Store.
                </p>
                <p>
                        Pengiriman barang akan dilakukan dalam waktu 7 hari kerja.
                        Pengiriman produk akan dilakukan langsung oleh Merchant kami melalui jasa ekspedisi dan layanan yang telah disepakati. Anda akan menerima informasi lebih lanjut apabila diperlukan perpanjangan waktu pengiriman.
                    </p><br>
                <table style='margin: 2em 0;'>
                    <tr>
                        <td style='width: 200px'>Jumlah yang sudah terbayar</td>
                        <td style='width: 4px'> : </td>
                        <td><strong> Rp " . number_format($single->total + $single->ongkir + $single->payment_fee, 0, '.', ',') . "</strong></td>
                    </tr>
                </table>";
        }
        $email .= "<hr />";
        $totalPrint = 0;
        $totalAll = 0;
        foreach ($inputan_order as $v)
        {
            $email .= "<table width='100%'>
                            <tr>
                                <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                <td width='20%'>Status: Success</td>
                            </tr>
                        </table>";
            $email .= "<table width='100%'>
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
            $email.= $metpayment->nama_payment;
            $email .= "</td>
                            </tr>
                            </table><br>";
            $email .= '<table style="border-collapse:collapse; width:100%;">
                <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
            $i = 0;
            $total_sub = 0;
            $sub_total = 0;
            foreach ($order_item[$v->id_order] as $items)
            {
                if ($items->diskon > 0)
                    $harga_diskon = $items->harga - $items->diskon_rp;
                else
                    $harga_diskon = $items->harga;
                $total_sub = $harga_diskon * $items->jml_produk;
                $i++;
                $detailPaket = !empty($items->detail_paket)?'<br>('.$items->detail_paket.')':'';
                $email .= '<tr style="text-align:center"><td>' . $i . '</td> 
                        <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a>'.$detailPaket.'</td>
                        <td style="text-align:right">' . $items->jml_produk . '</td>
                        <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                        <td style="text-align:right">' . $items->diskon . '%</td>
                        <td style="text-align:right">Rp. ' . number_format($harga_diskon, 0, '.', ',') . '</td>
                        <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                    </tr>';
                $sub_total += $total_sub;
            }
            $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . number_format($sub_total, 0, '.', ',') . '</td></tr>';
            $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . number_format($v->ongkir_sementara, 0, '.', ',') . '</td></tr>';
            $total_harga = $sub_total + $v->ongkir_sementara;
            $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . number_format($total_harga, 0, '.', ',') . '</td></tr>            
                </table><div style="height:10px;"></div>';
            $totalAll+=$total_harga;
        }
        $totalPrint = $totalAll + $single->payment_fee;
        if ((int) $single->payment_fee > 0)
        {
            $email .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Convenience Fee</td>
                    <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                </tr>
            </table>";
        }
        if ((int) $single->potongan_voucher > 0)
        {
            $email .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Potongan Voucher : " . htmlspecialchars($single->voucher) . "</td>
                    <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_voucher, 0, '.', ',')) . "</td>
                </tr>
            </table>";
        }
        $email .= "<table width='100%'>
                <tr>
                    <td width='80%' style='text-align: right;'>Grand Total </td>
                    <td width='20%' style='text-align: right;'>Rp " . number_format($single->total + $single->ongkir, 0, '.', ',') . "</td>
                </tr>
            </table><br>";
        $email .="
                    <p>Kami sarankan Anda menyimpan dengan baik bukti pembayaran 
                    hingga produk telah Anda terima dan transaksi dinyatakan selesai.</p><br>
                    <p>Untuk informasi, silahkan menghubungi e-care.store@cipika.co.id. 
                    Terima kasih atas kepercayaan Anda berbelanja di Cipika Store.</p>";
        $email .= '<br/><p>Terima Kasih,<br/><br/><br/>
                    <strong>Cipika Store &trade;</strong><br>
                    <a href="' . base_url() . '">cipika.co.id</a>
                    </p>
                    ';
        $insert = array('idmailer' => null,
            'mailer_module' => 'Informasi Order',
            'mailer_from' => $this->from,
            'mailer_to' => $to,
            'mailer_subject' => 'Informasi Order di Cipika Store',
            'mailer_message' => $email,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        if ($id_payment != 7 && $id_payment != 8) {
            $this->dbLibrary->insert('mailer', $insert);
            return $this->dbLibrary->insert_id();
        } else {
            return false;
        }
    }

    public function sendExpiredPembelian($user, $dateExp, $timeExp, $kodeInvoice, $id_payment, $inputan_order, $inputan_shipping, $inputan_merchant, $order_item, $payment, $link_index, $single) {
        if (in_array((int) $id_payment, array(9,10))) {
            $totalAll = 0;
            foreach ($inputan_order as $val) {
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$val->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                        $total_sub = $harga_diskon * $items->jml_produk;
                        $sub_total += $total_sub;
                }
                $total_harga = $sub_total + $val->ongkir_sementara;
                $totalAll+=$total_harga;
            }
 
            $subjectEmail = 'Batas Waktu Pembayaran Habis. Sudah Konfirmasi Pembayaran?';
            $email = "<h3>Bapak/Ibu " . $user->firstname. " " . $user->lastname . " Yth.</h3>
                <p>
                    Sudahkah Anda melakukan konfirmasi Pembayaran untuk transaksi berikut?
                </p>
                <table>
                    <tr>
                        <td width='150px'>Nomor Invoice</td>
                        <td width='15px'>:</td>
                        <td width='300px'>". htmlspecialchars($kodeInvoice) . "</td>
                    </tr>
                    <tr>
                        <td width='150px'>Nilai Tagihan</td>
                        <td width='15px'>:</td>
                        <td width='300px'>Rp " . number_format($totalAll - $single->potongan_voucher, 0, '.', ',') . "</td>
                    </tr>
                </table>
                <p>
                    Saat ini batas waktu pembayaran telah habis dan kami belum menerima konfirmasi pembayaran atas transaksi tersebut. Sehingga untuk <strong>sementara transaksi kami nyatakan Expired.</strong>
                </p>
                <p>
                    Segera informasikan kepada kami melalui e-care.store@cipika.co.id, apabila Anda sudah membayar, 
                    namun lupa/belum konfirmasi. Kami akan memandu Anda untuk melakukan konfirmasi pembayaran sesuai prosedur yang berlaku, 
                    guna memastikan transaksi Anda tercatat dengan baik. Apabila lebih dari 2 (dua) jam ke depan Anda tidak mengirimkan informasi tersebut, maka transaksi dinyatakan <strong>Batal</strong> dan 
                    tidak dapat kami proses lebih lanjut.
                </p>";
        } else {
            $subjectEmail = 'Batas Waktu Pembayaran Habis';
            $email = "<h3>Bapak/Ibu " . $user->firstname. " ". $user->lastname . " Yth.</h3>
                    <p>Sebagai bagian pelayanan terbaik Cipika Store, melalui email ini 
                        kami sampaikan informasi bahwa kami tidak menerima konfirmasi pembayaran atas 
                        transaksi dengan nomor invoice <strong>" . htmlspecialchars($kodeInvoice) . "</strong> hingga berakhirnya batas waktu 
                        pembayaran <strong>" . htmlspecialchars($dateExp) . "</strong> pukul <strong>" . htmlspecialchars($timeExp) . "</strong> WIB. Sesuai kebijakan yang berlaku, maka 
                        transaksi dinyatakan Batal dan tidak dapat kami proses lebih lanjut. 
                        Oleh karenanya, mohon tidak melakukan pembayaran atas transaksi tersebut ke rekening kami.                        
                    </p><hr/>";
            $totalPrint = 0;
            $totalAll = 0;
            foreach ($inputan_order as $v) {
                $email .= "<table width='100%'>
                                <tr>
                                    <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                    <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                    <td width='20%'>Status: Success</td>
                                </tr>
                            </table>";
                $email .= "<table width='100%'>
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
                $email.= $payment->nama_payment;
                $email .= "</td>
                                </tr>
                                </table><br>";
                $email .= '<table style="border-collapse:collapse; width:100%;">
                    <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
                $i = 0;
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$v->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                    $total_sub = $harga_diskon * $items->jml_produk;
                    $i++;
                    $detailPaket = !empty($items->detail_paket) ? '<br>(' . $items->detail_paket . ')' : '';
                    $email .= '<tr style="text-align:center"><td>' . $i . '</td> 
                            <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a>' . $detailPaket . '</td>
                            <td style="text-align:right">' . $items->jml_produk . '</td>
                            <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                            <td style="text-align:right">' . $items->diskon . '%</td>
                            <td style="text-align:right">Rp. ' . number_format($harga_diskon, 0, '.', ',') . '</td>
                            <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                        </tr>';
                    $sub_total += $total_sub;
                }
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . number_format($sub_total, 0, '.', ',') . '</td></tr>';
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . number_format($v->ongkir_sementara, 0, '.', ',') . '</td></tr>';
                $total_harga = $sub_total + $v->ongkir_sementara;
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . number_format($total_harga, 0, '.', ',') . '</td></tr>            
                    </table><div style="height:10px;"></div>';
                $totalAll+=$total_harga;
            }
            $totalPrint = $totalAll + $single->payment_fee;

            if ((int) $single->payment_fee > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Convenience Fee</td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                    </tr>
                </table>";
            }
            if ((int) $single->potongan_voucher > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Potongan Voucher : " . htmlspecialchars($single->voucher) . "</td>
                        <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_voucher, 0, '.', ',')) . "</td>
                    </tr>
                </table>";
            }

            $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Grand Total </td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($totalPrint - $single->potongan_voucher, 0, '.', ',') . "</td>
                    </tr>
                </table><br>";
        }
        $email .= "<p>
                    Semoga Anda berkenan dengan pelayanan kami, terima kasih. 
                    </p><br/>
                    ";
        $email .= '<p>Salam,<br/>
                    <strong>Cipika Store &trade;</strong><br>
                    Semuanya Menjadi Mudah
                    </p>
                    ';
        $insert = array('idmailer' => null,
            'mailer_module' => 'Informasi Order Expired',
            'mailer_from' => $this->from,
            'mailer_to' => $user->email,
            'mailer_subject' => $subjectEmail,
            'mailer_message' => $email,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendReminderPembelian($user, $dateExp, $timeExp, $kodeInvoice, $id_payment, $inputan_order, $inputan_shipping, $inputan_merchant, $order_item, $payment, $link_index, $single, $det_payment) 
    {
        $email = "";        
    	if (in_array((int) $id_payment, array(9,10))) {
            $email = "<h3>Bapak/Ibu " . $user->firstname. " " . $user->lastname . " Yth.</h3>";
    	    $email .= "<p>Produk-produk dalam invoice belanja Anda adalah produk favorit member Cipika. 
                Segera bantu kami untuk mengunci stok produk pilihan tersebut untuk Anda, 
                dengan satu langkah mudah: <a href='".base_url('order/konfirmasi')."'><strong>Konfirmasi Pembayaran</strong></a>.</p>";
            $email .= "<p>Silahkan ikuti panduan kami berikut:</p>
                        <p>
                        <ol type='number'>
                            <li>Kunjungi <a href='".base_url()."'>www.cipika.co.id</a>
                            <li>Login menggunakan akun member Anda : <strong>".htmlspecialchars($user->email) ."</strong></li>
                            <li>Klik <strong>Akun Member</strong> > Klik Menu <strong>Confirm Payment</strong></li>
                            <li>Pilih Kode Invoice > klik tombol <strong>Cek Invoice</strong></li>
                            <li>Isi form Konfirmasi Pembayaran dibagian bawah detil pembelian. 
                            Lampirkan bukti pembayaran (capture SMS Mutasi Bank, Mutasi Rekening, Struk ATM, 
                                atau Slip Transfer) dalam format jpeg, jpg, atau gift, maksimal 2MB.</li>
                        </ol>
                        </p>
                        <label><strong>Rekening Tujuan Pembayaran</strong></label>";
            if ($id_payment === 9) {
                $email .="<table style='margin: 2em 0;'>
                        <tr>
                            <td style='width: 200px'>Nama Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>BANK MANDIRI Cabang Jakarta Thamrin</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Pemilik Rekening</td>
                            <td style='width: px'>:</td>
                            <td><strong>PT Indosat Tbk</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nomor Rekening</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . NO_REK_OF_BANK_MANDIRI_TRANSFER . "</strong></td>
                    </tr>
                    </table>";
            } else {
                $email .= "
                        <table style='margin: 1em 0;'>
                        <tr>
                            <td style='width: 200px'>Nama Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>BANK BCA Wisma Asia</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>A/C</td>
                            <td style='width: px'>:</td>
                            <td><strong>PT Indosat Tbk</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nomor Rekening</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . NO_REK_OF_BANK_BCA_TRANSFER . "</strong></td>
                    </tr>
                    </table>";
            }

            $email .= "<p>Kami sarankan, Anda tidak menggunakan media pembayaran yang 
                membutuhkan proses kliring/RTGS. Sebab proses kliring/RTGS membutuhkan waktu maksimal 3x24 jam, 
                melebihi batas waktu maksimal pembayaran transaksi di Cipika. </p>";

            $totalPrint = 0;
            $totalAll = 0;
            foreach ($inputan_order as $v) {
                $email .= "<table width='100%'>
                                <tr>
                                    <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                    <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                    <td width='20%'>Status: Success</td>
                                </tr>
                            </table>";
                $email .= "<table width='100%'>
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
                $email.= $payment->nama_payment;
                $email .= "</td>
                                </tr>
                                </table><br>";
                $email .= '<table style="border-collapse:collapse; width:100%;">
                    <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
                $i = 0;
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$v->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                    $total_sub = $harga_diskon * $items->jml_produk;
                    $i++;
                    $detailPaket = !empty($items->detail_paket) ? '<br>(' . $items->detail_paket . ')' : '';
                    $email .= '<tr style="text-align:center"><td>' . $i . '</td> 
                            <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a>' . $detailPaket . '</td>
                            <td style="text-align:right">' . $items->jml_produk . '</td>
                            <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                            <td style="text-align:right">' . $items->diskon . '%</td>
                            <td style="text-align:right">Rp. ' . number_format($harga_diskon, 0, '.', ',') . '</td>
                            <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                        </tr>';
                    $sub_total += $total_sub;
                }
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . number_format($sub_total, 0, '.', ',') . '</td></tr>';
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . number_format($v->ongkir_sementara, 0, '.', ',') . '</td></tr>';
                $total_harga = $sub_total + $v->ongkir_sementara;
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . number_format($total_harga, 0, '.', ',') . '</td></tr>            
                    </table><div style="height:10px;"></div>';
                $totalAll+=$total_harga;
            }
            $totalPrint = $totalAll + $single->payment_fee;

            if ((int) $single->payment_fee > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Convenience Fee</td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                    </tr>
                </table>";
            }
            if ((int) $single->potongan_voucher > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Potongan Voucher : " . htmlspecialchars($single->voucher) . "</td>
                        <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_voucher, 0, '.', ',')) . "</td>
                    </tr>
                </table>";
            }

            $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Grand Total </td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($totalPrint - $single->potongan_voucher, 0, '.', ',') . "</td>
                    </tr>
                </table><br>";

            $email .= "<p>Hubungi kami melalui <a href='mailto:e-care.store@cipika.co.id'>e-care.store@cipika.co.id</a>, 
            apabila Anda membutuhkan informasi lebih lanjut. Semoga Anda berkenan dengan pelayanan kami, terima kasih.</p>
                <p>Salam,<br/>
                    <strong>Cipika Store</strong><br>
                    Semuanya Menjadi Mudah
                    </p>";

    	} elseif ((int) $id_payment == 1) {
            $totalAll = 0;
            foreach ($inputan_order as $val) {
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$val->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                        $total_sub = $harga_diskon * $items->jml_produk;
                        $sub_total += $total_sub;
                }
                $total_harga = $sub_total + $val->ongkir_sementara;
                $totalAll+=$total_harga;
            }
            $email = "<h3>Bapak/Ibu " . $user->firstname. " " . $user->lastname . " Yth.</h3>";
            $email .= "<p>Produk-produk dalam invoice belanja Anda adalah produk favorit member Cipika. 
                Segera bantu kami untuk mengunci stok produk tersebut untuk Anda, dengan melakukan pembayaran 
                sebelum batas waktu yang telah ditentukan.</p>";
            $email .= "<p><strong><u>Rekening Tujuan Pembayaran</u></strong></p>
                    <table style='margin: 1em 0;'>
                        <tr>
                            <td style='width: 200px'>Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>PERMATA</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Rekening/VAN ID</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $det_payment . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nilai Tagihan</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>Rp " . number_format($totalAll - $single->potongan_voucher, 0, '.', ',') . "</td>
                        </tr>
                    </table>";
            $email .= "<p><strong>Petunjuk Pembayaran :</strong></p>
                        <ol type='number'>
                            <li>Pembayaran dapat melalui ATM Bersama, Prima, Alto. Atau Internet Banking dari Bank yang menyediakan menu Transfer Antar Bank Online.
                             Tidak disarankan menggunakan alat pembayaran dengan proses Kliring/RTGS. Cipika berhak membatalkan transaksi dengan proses Kliring</a>
                            <li>Nilai yang dibayarkan harus sesuai nilai tagihan.</li>
                            <li>Pembayaran melalui Teller hanya diperkenankan melalui Teller Bank Permata. Selain Teller Bank Permata tidak disarankan</li>
                            <li>Setelah lewat dari batas waktu pembayaran, VAN ID akan expired dan transaksi tidak dapat dilanjutkan.</li>
                        </ol>";

            $totalPrint = 0;
            $totalAll = 0;
            foreach ($inputan_order as $v) {
                $email .= "<table width='100%'>
                                <tr>
                                    <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                    <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                    <td width='20%'>Status: Success</td>
                                </tr>
                            </table>";
                $email .= "<table width='100%'>
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
                $email.= $payment->nama_payment;
                $email .= "</td>
                                </tr>
                                </table><br>";
                $email .= '<table style="border-collapse:collapse; width:100%;">
                    <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
                $i = 0;
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$v->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                    $total_sub = $harga_diskon * $items->jml_produk;
                    $i++;
                    $detailPaket = !empty($items->detail_paket) ? '<br>(' . $items->detail_paket . ')' : '';
                    $email .= '<tr style="text-align:center"><td>' . $i . '</td> 
                            <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a>' . $detailPaket . '</td>
                            <td style="text-align:right">' . $items->jml_produk . '</td>
                            <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                            <td style="text-align:right">' . $items->diskon . '%</td>
                            <td style="text-align:right">Rp. ' . number_format($harga_diskon, 0, '.', ',') . '</td>
                            <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                        </tr>';
                    $sub_total += $total_sub;
                }
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . number_format($sub_total, 0, '.', ',') . '</td></tr>';
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . number_format($v->ongkir_sementara, 0, '.', ',') . '</td></tr>';
                $total_harga = $sub_total + $v->ongkir_sementara;
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . number_format($total_harga, 0, '.', ',') . '</td></tr>            
                    </table><div style="height:10px;"></div>';
                $totalAll+=$total_harga;
            }
            $totalPrint = $totalAll + $single->payment_fee;

            if ((int) $single->payment_fee > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Convenience Fee</td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                    </tr>
                </table>";
            }
            if ((int) $single->potongan_voucher > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Potongan Voucher : " . htmlspecialchars($single->voucher) . "</td>
                        <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_voucher, 0, '.', ',')) . "</td>
                    </tr>
                </table>";
            }

            $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Grand Total </td>
                        <td width='20%' style='text-align: right;'>Rp : " . number_format($totalPrint - $single->potongan_voucher, 0, '.', ',') . "</td>
                    </tr>
                </table><br>";

            $email .= "<p>Hubungi kami melalui <a href='mailto:e-care.store@cipika.co.id'>e-care.store@cipika.co.id</a>, 
            apabila Anda membutuhkan informasi lebih lanjut. Semoga Anda berkenan dengan pelayanan kami, terima kasih.</p>
                <p>Salam,<br/>
                    <strong>Cipika Store</strong><br>
                    Semuanya Menjadi Mudah
                    </p>";
        } else if ((int) $id_payment == 27) {
            /*
             * Email Reminder Payment Virtual Account
             */
            $payExpNicepay = date('Y-m-d H:i:s', strtotime($det_payment->expired . ' -1 hours'));
            $totalAll = 0;
            foreach ($inputan_order as $val) {
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$val->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                        $total_sub = $harga_diskon * $items->jml_produk;
                        $sub_total += $total_sub;
                }
                $total_harga = $sub_total + $val->ongkir_sementara;
                $totalAll+=$total_harga;
            }
            $email = "<h3>Hi " . $user->firstname. " " . $user->lastname . "</h3>,";
            $email .= "<p>Produk-produk dalam invoice belanja Anda adalah produk favorit member Cipika. 
                Segera bantu kami untuk mengunci stok produk tersebut untuk Anda, dengan melakukan pembayaran 
                sebelum batas waktu yang telah ditentukan.</p>";
            $email .= "<p><strong><u>Rekening Tujuan Pembayaran</u></strong></p>
                    <table style='margin: 1em 0;'>
                        <tr>
                            <td style='width: 200px'>Nama Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>" . $det_payment->payment_type . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Rekening/VAN ID</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $det_payment->respond . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Batas waktu pembayaran</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $payExpNicepay . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nilai Tagihan</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>Rp " . number_format($totalAll - $single->potongan_voucher, 0, '.', ',') . "</td>
                        </tr>
                    </table>";
            $email .= "<p><strong>Petunjuk Pembayaran :</strong></p>
                        <ol type='number'>
                            <li>Pembayaran dapat melalui ATM Bersama, Prima, Alto. Atau Internet Banking dari Bank yang menyediakan menu Transfer Antar Bank Online.
                             Tidak disarankan menggunakan alat pembayaran dengan proses Kliring/RTGS. Cipika berhak membatalkan transaksi dengan proses Kliring</a>
                            <li>Nilai yang dibayarkan harus sesuai nilai tagihan.</li>
                            <li>Setelah lewat dari batas waktu pembayaran, VAN ID akan expired dan transaksi tidak dapat dilanjutkan.</li>
                        </ol>";

            $totalPrint = 0;
            $totalAll = 0;
            foreach ($inputan_order as $v) {
                $email .= "<table width='100%'>
                                <tr>
                                    <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                    <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                    <td width='20%'>Status: Success</td>
                                </tr>
                            </table>";
                $email .= "<table width='100%'>
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
                $email.= $payment->nama_payment;
                $email .= "</td>
                                </tr>
                                </table><br>";
                $email .= '<table style="border-collapse:collapse; width:100%;">
                    <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
                $i = 0;
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$v->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                    $total_sub = $harga_diskon * $items->jml_produk;
                    $i++;
                    $detailPaket = !empty($items->detail_paket) ? '<br>(' . $items->detail_paket . ')' : '';
                    $email .= '<tr style="text-align:center"><td>' . $i . '</td> 
                            <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a>' . $detailPaket . '</td>
                            <td style="text-align:right">' . $items->jml_produk . '</td>
                            <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                            <td style="text-align:right">' . $items->diskon . '%</td>
                            <td style="text-align:right">Rp. ' . number_format($harga_diskon, 0, '.', ',') . '</td>
                            <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                        </tr>';
                    $sub_total += $total_sub;
                }
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . number_format($sub_total, 0, '.', ',') . '</td></tr>';
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . number_format($v->ongkir_sementara, 0, '.', ',') . '</td></tr>';
                $total_harga = $sub_total + $v->ongkir_sementara;
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . number_format($total_harga, 0, '.', ',') . '</td></tr>            
                    </table><div style="height:10px;"></div>';
                $totalAll+=$total_harga;
            }
            $totalPrint = $totalAll + $single->payment_fee;

            if ((int) $single->payment_fee > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Convenience Fee</td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                    </tr>
                </table>";
            }
            if ((int) $single->potongan_voucher > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Potongan Voucher : " . htmlspecialchars($single->voucher) . "</td>
                        <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_voucher, 0, '.', ',')) . "</td>
                    </tr>
                </table>";
            }

            $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Grand Total </td>
                        <td width='20%' style='text-align: right;'>Rp : " . number_format($totalPrint - $single->potongan_voucher, 0, '.', ',') . "</td>
                    </tr>
                </table><br>";

            $email .= "<p>Hubungi kami melalui <a href='mailto:e-care.store@cipika.co.id'>e-care.store@cipika.co.id</a>, 
            apabila Anda membutuhkan informasi lebih lanjut. Semoga Anda berkenan dengan pelayanan kami, terima kasih.</p>
                <p>Salam,<br/>
                    <strong>Cipika Store</strong><br>
                    Semuanya Menjadi Mudah
                    </p>";
            
        }
        
        if (!empty($email)) {
            $insert = array('idmailer' => null,
                'mailer_module' => 'Informasi Order Reminder',
                'mailer_from' => $this->from,
                'mailer_to' => $user->email,
                'mailer_subject' => "[" . $kodeInvoice . "] - ". $user->firstname . ", Cukup Satu Langkah Lagi Menyelesaikan Transaksi",
                'mailer_message' => $email,
                'mailer_status' => 'new',
                'mailer_created' => date('Y-m-d H:i:s')
            );
            $this->dbLibrary->insert('mailer', $insert);
            return (int) $this->dbLibrary->insert_id();
        }
    }
   
    public function sendLastReminderPembelian($user, $dateExp, $timeExp, $kodeInvoice, $id_payment, $inputan_order, $inputan_shipping, $inputan_merchant, $order_item, $payment, $link_index, $single, $det_payment) 
    {
        $email = "";        
        if (in_array((int) $id_payment, array(9,10))) {
            $email = "<h3>Bapak/Ibu " . $user->firstname. " " . $user->lastname . " Yth.</h3>";
            $email .= "<p>Waktu pembayaran Anda akan habis dalam 6 (enam) jam kedepan dan kami belum menerima Konfirmasi Pembayaran. 
                    Apakah Anda menemui kendala saat melakukan konfirmasi Pembayaran? Kami pandu Anda sekali lagi. 
                    Silahkan ikuti langkah-langkah Konfirmasi Pembayaran berikut: </p>";
            $email .= "<p>
                        <ol type='number'>
                            <li>Kunjungi <a href='".base_url()."'>www.cipika.co.id</a>
                            <li>Login menggunakan akun member Anda : <strong>" . htmlspecialchars($user->email) . "</strong></li>
                            <li>Klik <strong>Akun Member</strong> > Klik Menu <strong>Confirm Payment</strong></li>
                            <li>Pilih Kode Invoice > klik tombol <strong>Cek Invoice</strong></li>
                            <li>Isi form Konfirmasi Pembayaran dibagian bawah detil pembelian. 
                            Lampirkan bukti pembayaran (capture SMS Mutasi Bank, Mutasi Rekening, Struk ATM, 
                                atau Slip Transfer) dalam format jpeg, jpg, atau gift, maksimal 2MB.</li>
                        </ol>
                        </p>
                        <label><strong>Rekening Tujuan Pembayaran</strong></label>";
            if ($id_payment === 9) {
                $email .="<table style='margin: 2em 0;'>
                        <tr>
                            <td style='width: 200px'>Nama Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>BANK MANDIRI Cabang Jakarta Thamrin</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Pemilik Rekening</td>
                            <td style='width: px'>:</td>
                            <td><strong>PT Indosat Tbk</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nomor Rekening</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . NO_REK_OF_BANK_MANDIRI_TRANSFER . "</strong></td>
                    </tr>
                    </table>";
            } else {
                $email .= "
                        <table style='margin: 1em 0;'>
                        <tr>
                            <td style='width: 200px'>Nama Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>BANK BCA Wisma Asia</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>A/C</td>
                            <td style='width: px'>:</td>
                            <td><strong>PT Indosat Tbk</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nomor Rekening</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . NO_REK_OF_BANK_BCA_TRANSFER . "</strong></td>
                    </tr>
                    </table>";
            }

            $email .= "<p>Kami sarankan, Anda tidak menggunakan media pembayaran yang 
                membutuhkan proses kliring/RTGS. Sebab proses kliring/RTGS membutuhkan waktu maksimal 3x24 jam, 
                melebihi batas waktu maksimal pembayaran transaksi di Cipika. </p>";

            $totalPrint = 0;
            $totalAll = 0;
            foreach ($inputan_order as $v) {
                $email .= "<table width='100%'>
                                <tr>
                                    <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                    <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                    <td width='20%'>Status: Success</td>
                                </tr>
                            </table>";
                $email .= "<table width='100%'>
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
                $email.= $payment->nama_payment;
                $email .= "</td>
                                </tr>
                                </table><br>";
                $email .= '<table style="border-collapse:collapse; width:100%;">
                    <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
                $i = 0;
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$v->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                    $total_sub = $harga_diskon * $items->jml_produk;
                    $i++;
                    $detailPaket = !empty($items->detail_paket) ? '<br>(' . $items->detail_paket . ')' : '';
                    $email .= '<tr style="text-align:center"><td>' . $i . '</td> 
                            <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a>' . $detailPaket . '</td>
                            <td style="text-align:right">' . $items->jml_produk . '</td>
                            <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                            <td style="text-align:right">' . $items->diskon . '%</td>
                            <td style="text-align:right">Rp. ' . number_format($harga_diskon, 0, '.', ',') . '</td>
                            <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                        </tr>';
                    $sub_total += $total_sub;
                }
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . number_format($sub_total, 0, '.', ',') . '</td></tr>';
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . number_format($v->ongkir_sementara, 0, '.', ',') . '</td></tr>';
                $total_harga = $sub_total + $v->ongkir_sementara;
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . number_format($total_harga, 0, '.', ',') . '</td></tr>            
                    </table><div style="height:10px;"></div>';
                $totalAll+=$total_harga;
            }
            $totalPrint = $totalAll + $single->payment_fee;

            if ((int) $single->payment_fee > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Convenience Fee</td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                    </tr>
                </table>";
            }
            if ((int) $single->potongan_voucher > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Potongan Voucher : " . htmlspecialchars($single->voucher) . "</td>
                        <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_voucher, 0, '.', ',')) . "</td>
                    </tr>
                </table>";
            }

            $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Grand Total </td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($totalPrint - $single->potongan_voucher, 0, '.', ',') . "</td>
                    </tr>
                </table><br>";

            $email .= "<p>Hubungi kami melalui <a href='mailto:e-care.store@cipika.co.id'>e-care.store@cipika.co.id</a>, 
            apabila Anda membutuhkan informasi lebih lanjut. Semoga Anda berkenan dengan pelayanan kami, terima kasih.</p>
                <p>Salam,<br/>
                    <strong>Cipika Store</strong><br>
                    Semuanya Menjadi Mudah
                    </p>";

        } elseif ((int) $id_payment == 1) {
            $totalAll = 0;
            foreach ($inputan_order as $val) {
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$val->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                        $total_sub = $harga_diskon * $items->jml_produk;
                        $sub_total += $total_sub;
                }
                $total_harga = $sub_total + $val->ongkir_sementara;
                $totalAll+=$total_harga;
            }

            $email = "<h3>Bapak/Ibu " . $user->firstname. " " . $user->lastname . " Yth.</h3>";
            $email .= "<p>Waktu pembayaran akan habis dalam 6 (enam) jam kedepan dan kami belum menerima pembayaran Anda. 
            Apakah Anda menemui kendala saat melakukan pembayaran? Silahkan hubungi kami melalui 
            <a href='mailto:e-care.store@cipika.co.id'>e-care.store@cipika.co.id</a> supaya kami dapat membantu Anda.</p>";
            $email .= "<p><strong><u>Rekening Tujuan Pembayaran</u></strong></p>
                    <table style='margin: 1em 0;'>
                        <tr>
                            <td style='width: 200px'>Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>PERMATA</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Rekening/VAN ID</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $det_payment . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nilai Tagihan</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>Rp " . number_format($totalAll - $single->potongan_voucher, 0, '.', ',') . "</td>
                        </tr>
                    </table>";
            $email .= "<p><strong>Petunjuk Pembayaran :</strong></p>
                        <ol type='number'>
                            <li>Pembayaran dapat melalui ATM Bersama, Prima, Alto. Atau Internet Banking dari Bank yang menyediakan menu Transfer Antar Bank Online.
                             Tidak disarankan menggunakan alat pembayaran dengan proses Kliring/RTGS. Cipika berhak membatalkan transaksi dengan proses Kliring</a>
                            <li>Nilai yang dibayarkan harus sesuai nilai tagihan.</li>
                            <li>Pembayaran melalui Teller hanya diperkenankan melalui Teller Bank Permata. Selain Teller Bank Permata tidak disarankan</li>
                            <li>Setelah lewat dari batas waktu pembayaran, VAN ID akan expired dan transaksi tidak dapat dilanjutkan.</li>
                        </ol>";

            $totalPrint = 0;
            $totalAll = 0;
            foreach ($inputan_order as $v) {
                $email .= "<table width='100%'>
                                <tr>
                                    <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                    <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                    <td width='20%'>Status: Success</td>
                                </tr>
                            </table>";
                $email .= "<table width='100%'>
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
                $email.= $payment->nama_payment;
                $email .= "</td>
                                </tr>
                                </table><br>";
                $email .= '<table style="border-collapse:collapse; width:100%;">
                    <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
                $i = 0;
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$v->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                    $total_sub = $harga_diskon * $items->jml_produk;
                    $i++;
                    $detailPaket = !empty($items->detail_paket) ? '<br>(' . $items->detail_paket . ')' : '';
                    $email .= '<tr style="text-align:center"><td>' . $i . '</td> 
                            <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a>' . $detailPaket . '</td>
                            <td style="text-align:right">' . $items->jml_produk . '</td>
                            <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                            <td style="text-align:right">' . $items->diskon . '%</td>
                            <td style="text-align:right">Rp. ' . number_format($harga_diskon, 0, '.', ',') . '</td>
                            <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                        </tr>';
                    $sub_total += $total_sub;
                }
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . number_format($sub_total, 0, '.', ',') . '</td></tr>';
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . number_format($v->ongkir_sementara, 0, '.', ',') . '</td></tr>';
                $total_harga = $sub_total + $v->ongkir_sementara;
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . number_format($total_harga, 0, '.', ',') . '</td></tr>            
                    </table><div style="height:10px;"></div>';
                $totalAll+=$total_harga;
            }
            $totalPrint = $totalAll + $single->payment_fee;

            if ((int) $single->payment_fee > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Convenience Fee</td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                    </tr>
                </table>";
            }
            if ((int) $single->potongan_voucher > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Potongan Voucher : " . htmlspecialchars($single->voucher) . "</td>
                        <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_voucher, 0, '.', ',')) . "</td>
                    </tr>
                </table>";
            }

            $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Grand Total </td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($totalPrint - $single->potongan_voucher, 0, '.', ',') . "</td>
                    </tr>
                </table><br>";

            $email .= "<p>Semoga Anda berkenan dengan pelayanan kami, terima kasih.</p>
                <p>Salam,<br/>
                    <strong>Cipika Store</strong><br>
                    Semuanya Menjadi Mudah
                    </p>";
        } else if ((int) $id_payment == 27) {
            
            /*
             * Payment Nicepay (Virtual Account)
             */
            $payExpNicepay = date('Y-m-d H:i:s', strtotime($det_payment->expired . ' -1 hours'));
            $totalAll = 0;
            foreach ($inputan_order as $val) {
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$val->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                        $total_sub = $harga_diskon * $items->jml_produk;
                        $sub_total += $total_sub;
                }
                $total_harga = $sub_total + $val->ongkir_sementara;
                $totalAll+=$total_harga;
            }

            $email = "<h3>Bapak/Ibu " . $user->firstname. " " . $user->lastname . " Yth.</h3>";
            $email .= "<p>Waktu pembayaran akan habis dalam 6 (enam) jam kedepan dan kami belum menerima pembayaran Anda. 
            Apakah Anda menemui kendala saat melakukan pembayaran? Silahkan hubungi kami melalui 
            <a href='mailto:e-care.store@cipika.co.id'>e-care.store@cipika.co.id</a> supaya kami dapat membantu Anda.</p>";
            $email .= "<p><strong><u>Rekening Tujuan Pembayaran</u></strong></p>
                    <table style='margin: 1em 0;'>
                        <tr>
                            <td style='width: 200px'>Nama Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>" . $det_payment->payment_type . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Rekening/VAN ID</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $det_payment->respond . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Batas waktu pembayaran</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $payExpNicepay . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nilai Tagihan</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>Rp " . number_format($totalAll - $single->potongan_voucher, 0, '.', ',') . "</td>
                        </tr>
                    </table>";
            $email .= "<p><strong>Petunjuk Pembayaran :</strong></p>
                        <ol type='number'>
                            <li>Pembayaran dapat melalui ATM Bersama, Prima, Alto. Atau Internet Banking dari Bank yang menyediakan menu Transfer Antar Bank Online.
                             Tidak disarankan menggunakan alat pembayaran dengan proses Kliring/RTGS. Cipika berhak membatalkan transaksi dengan proses Kliring</a>
                            <li>Nilai yang dibayarkan harus sesuai nilai tagihan.</li>
                            <li>Setelah lewat dari batas waktu pembayaran, VAN ID akan expired dan transaksi tidak dapat dilanjutkan.</li>
                        </ol>";

            $totalPrint = 0;
            $totalAll = 0;
            foreach ($inputan_order as $v) {
                $email .= "<table width='100%'>
                                <tr>
                                    <td width='40%'>Merchant: " . ucwords($inputan_merchant[$v->id_merchant]) . "</td>
                                    <td width='40%'>Nomor Transaksi: " . $v->kode_order . "</td>
                                    <td width='20%'>Status: Success</td>
                                </tr>
                            </table>";
                $email .= "<table width='100%'>
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
                $email.= $payment->nama_payment;
                $email .= "</td>
                                </tr>
                                </table><br>";
                $email .= '<table style="border-collapse:collapse; width:100%;">
                    <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
                $i = 0;
                $total_sub = 0;
                $sub_total = 0;
                foreach ($order_item[$v->id_order] as $items) {
                    if ($items->diskon > 0)
                        $harga_diskon = $items->harga - $items->diskon_rp;
                    else
                        $harga_diskon = $items->harga;
                    $total_sub = $harga_diskon * $items->jml_produk;
                    $i++;
                    $detailPaket = !empty($items->detail_paket) ? '<br>(' . $items->detail_paket . ')' : '';
                    $email .= '<tr style="text-align:center"><td>' . $i . '</td> 
                            <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a>' . $detailPaket . '</td>
                            <td style="text-align:right">' . $items->jml_produk . '</td>
                            <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                            <td style="text-align:right">' . $items->diskon . '%</td>
                            <td style="text-align:right">Rp. ' . number_format($harga_diskon, 0, '.', ',') . '</td>
                            <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                        </tr>';
                    $sub_total += $total_sub;
                }
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Sub Total</td><td >Rp. ' . number_format($sub_total, 0, '.', ',') . '</td></tr>';
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Ongkos Kirim</td><td >Rp. ' . number_format($v->ongkir_sementara, 0, '.', ',') . '</td></tr>';
                $total_harga = $sub_total + $v->ongkir_sementara;
                $email .= '<tr style="background:#666666; color:white; text-align:right"><td colspan="6" >Total</td><td >Rp. ' . number_format($total_harga, 0, '.', ',') . '</td></tr>            
                    </table><div style="height:10px;"></div>';
                $totalAll+=$total_harga;
            }
            $totalPrint = $totalAll + $single->payment_fee;

            if ((int) $single->payment_fee > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Convenience Fee</td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($single->payment_fee, 0, '.', ',') . "</td>
                    </tr>
                </table>";
            }
            if ((int) $single->potongan_voucher > 0) {
                $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Potongan Voucher : " . htmlspecialchars($single->voucher) . "</td>
                        <td width='20%' style='text-align: right;'>Rp " . htmlspecialchars(number_format($single->potongan_voucher, 0, '.', ',')) . "</td>
                    </tr>
                </table>";
            }

            $email .= "<table width='100%'>
                    <tr>
                        <td width='80%' style='text-align: right;'>Grand Total </td>
                        <td width='20%' style='text-align: right;'>Rp " . number_format($totalPrint - $single->potongan_voucher, 0, '.', ',') . "</td>
                    </tr>
                </table><br>";

            $email .= "<p>Semoga Anda berkenan dengan pelayanan kami, terima kasih.</p>
                <p>Salam,<br/>
                    <strong>Cipika Store</strong><br>
                    Semuanya Menjadi Mudah
                    </p>";
        }
        if (!empty($email)) {
            $insert = array('idmailer' => null,
                'mailer_module' => 'Informasi Order Last Reminder',
                'mailer_from' => $this->from,
                'mailer_to' => $user->email,
                'mailer_subject' => "[" . $kodeInvoice . "] - ". $user->firstname . ", Waktu Pembayaran Hampir Habis",
                'mailer_message' => $email,
                'mailer_status' => 'new',
                'mailer_created' => date('Y-m-d H:i:s')
            );
            $this->dbLibrary->insert('mailer', $insert);
            return (int) $this->dbLibrary->insert_id();
        }
    }

    public function getEmailInvoicePembelian(
        $detUser,
        $detInvoice,
        $detInvoiceAddress,
        $detOrder,
        $detShipping,
        $detStore,
        $detOrderItem,
        $detailPayment,
        $detPayment,
        $totalBayar,
        $detVoucherReload,
        $idPayment
    ) {
        $email = "";
        /* Start Payment ID : 1 & 19 */
        if ($idPayment == 1 || $idPayment == 19) {
            $date = new \DateTime($detInvoice->date_added);
            $date->add(new \DateInterval('P1D'));
            $datetimeExpired = $date->format('Y-m-d H:i:s');

            $dateInvoice = new \DateTime($detInvoice->date_added);
            $dateInvoice = $date->format('Y-m-d H:i:s');

            $email .= "<h3>Bapak/Ibu " . $detInvoiceAddress->nama . " Yth.</h3>";
            $email .= "<br/><p>Terima kasih Anda telah berbelanja melalui CipikaStore. " .
                      "Silahkan lakukan pembayaran Biaya Transaksi sesuai nilai yang " .
                      "tertera dalam Invoice, ke rekening CipikaStore berikut : </p>";
            $email .= "<table style='margin: 2em 0;'>
                        <tr>
                            <td style='width: 200px'>Nama Bank</td>
                            <td style='width: px'>:</td>
                            <td><strong>Bank Permata (kode bank 013)</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nomor Rekening (VAN ID)</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $detailPayment->respond ."</strong></td>
                        </tr>
                        </table>";
            $email .= "<p>Pembayaran dapat Anda lakukan melalui Jaringan <strong>" .
                      "ATM Bersama</strong>, <strong>PRIMA</strong>, dan <strong>" .
                      "ALTO</strong>. Anda juga diperkenankan memanfaatkan kemudahan " .
                      "fasilitas E-Banking yang dilengkapi menu <strong>Transfer " .
                      "Bank Online</strong>, namun pastikan fasilitas pembayaran " .
                      "yang Anda gunakan tidak memerlukan proses kliring. <br/> " .
                      "Pastikan Anda menyelesaikan pembayaran sebelum " . $datetimeExpired .
                      ". Apabila melebihi periode tersebut, maka Virtual Account" .
                      " (VAN ID) secara otomatis ditutup dan transaksi tidak " .
                      "diproses lebih lanjut.</p>";
            $email .= "<table style='margin: 2em 0;'>
                        <tr>
                            <td style='width: 200px'>Invoice No</td>
                            <td style='width: px'>:</td>
                            <td><strong>" . $detInvoice->kode_invoice . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Nama</td>
                            <td style='width: px'>:</td>
                            <td><strong>" . $detInvoiceAddress->nama . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Alamat</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $detInvoiceAddress->alamat . " , " .
                            ucfirst(strtolower($detInvoiceAddress->nama_kota)).", " .
                            ucfirst($detInvoiceAddress->nama_provinsi) . "</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Telp</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $detUser->telpon . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>No Handphone</td>
                            <td style='width: 10px'>:</td>
                            <td><strong>" . $detUser->hp . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Total Harga</td>
                            <td style='width: 4px'>:</td>
                            <td><strong>Rp " . $totalBayar . "</strong></td>
                        </tr>
                        <tr>
                            <td style='width: 200px'>Tanggal</td>
                            <td style='width: 4px'>:</td>
                            <td><strong>" . $dateInvoice . "</strong></td>
                        </tr>
                      </table>";
        } /* End Payment ID : 1 & 19 */
        $email .= "<hr />";
        /* Start Looping Order */
        $totalBayar = 0;
        $totalBayarInvoice = 0;
        foreach ($detOrder as $key => $value) {
            $detOrderShipping = $detShipping[$value->id_order];
            $detOrderItemVoucherReload = $detVoucherReload[$value->id_order];
            /* Table Order Detail - Start */
            $email .= "<table width='100%'>
                        <tr>
                            <td width='40%'>Merchant: " .
                                ucwords($detStore[$value->id_merchant]->nama_store) .
                            "</td>
                            <td width='40%'>Nomor Transaksi: " .
                                $value->kode_order . "
                            </td>
                            <td width='20%'>Status: Success</td>
                        </tr>
                       </table>";
            $email .= "<table width='100%'>
                        <tr>";
            if ($detStore[$value->id_merchant]->merchant_voucher_reload != "Y") {
                $email .= "<td width='40%'>
                               <strong>Alamat Pengiriman</strong><br /><span></span>
                               " . ucwords($detOrderShipping->nama) . "<br/>
                               " . ucwords($detOrderShipping->alamat) . "<br/>
                               " . ucwords($detOrderShipping->nama_kabupaten) .
                               " - " . ucwords($detOrderShipping->nama_propinsi) . "<br/>
                               " . $detOrderShipping->telpon . "<br/>
                          </td>";
            } else {
                $email .= "<td width='40%'>
                               <strong>Nomor Tujuan</strong><br /><span></span>
                                   " . $detOrderItemVoucherReload . "<br />
                          </td>";
            }
            $email .= "<td width='40%'><strong>Metode Pengiriman</strong><br />" .
                            ucwords($value->paket_ongkir) . "
                       </td>
                       <td width='20%'><strong>Metode Pembayaran</strong><br/>" .
                            $detPayment->nama_payment . "</td>
                        ";
            $email .= "</tr>
                      </table><br/>";
            /* Table Order Detail - End */

            /* Table Header Order Item - Start */
            $email .= "<table style='border-collapse:collapse; width:100%'>";
            $email .= "   <tr style='background:#666666; color:white;'>";
            $email .= "      <td width='10%' style='text-align:center'>No</td>";
            $email .= "      <td>Nama Produk</td>";
            $email .= "      <td width='10%' style='text-align:right'>Jumlah</td>";
            $email .= "      <td width='15%' style='text-align:right'>Harga</td>";
            $email .= "      <td width='10%' style='text-align:right'>Diskon</td>";
            $email .= "      <td width='15%' style='text-align:right'>Harga Setelah Diskon</td>";
            $email .= "      <td width='20%' style='text-align:right'>Subtotal</td>"; $email .= "  </tr>";
            /* Table Header Order Item - End */

            $noUrut= 1;
            $subTotalItem = 0;
            /* Table Looping Order Item - Start */
            foreach($detOrderItem[$value->id_order] as $items) {
                $hargaProdukStr = number_format($items->harga, 0, '', ',');
                $hargaProduk = $items->harga;
                $diskonRupiahProduk = $items->diskon_rp;
                $jumlahProduk = $items->jml_produk;
                $jumlahProduk = $items->jml_produk;
                $hargaDiskon = $hargaProduk - $diskonRupiahProduk;
                $totalSubItem = $hargaDiskon * $jumlahProduk;
                $hargaDiskonStr = number_format($hargaDiskon, 0, '', ',');
                $totalSubItemStr = number_format($totalSubItem, 0, '', ',');
                $subTotalItem += $totalSubItem;

                $urlProduk = base_url() . "product/detail/". $items->id_produk;
                $detailPaket = !empty($items->detail_paket) ? '<br/>(' . $items->detail_paket . ' )' : '';

                $email .= "   <tr style='text-align:center; vertical-align:top'>";
                $email .= "      <td width='10%' style='text-align:center'>". $noUrut++ . ".</td>";
                $email .= "      <td style='text-align:left'><a href='" .$urlProduk . "'>" .
                                $items->nama_produk . "</a>" . $detailPaket . "</td>";
                $email .= "      <td width='10%' style='text-align:right'>" . $jumlahProduk . "</td>";
                $email .= "      <td width='15%' style='text-align:right'>Rp. " . $hargaProdukStr . "</td>";
                $email .= "      <td width='10%' style='text-align:right'>" . $items->diskon . "%</td>";
                $email .= "      <td width='15%' style='text-align:right'>Rp. " . $hargaDiskonStr . "</td>";
                $email .= "      <td width='20%' style='text-align:right'>Rp. " . $totalSubItemStr . "</td>";
                $email .= "  </tr>";
            }
            /* Table Looping Order Item - End */
            $totalOrderItem = $subTotalItem + $value->ongkir_sementara;
            $totalBayar += $totalOrderItem;

            /* Table Footer Order Item - Start */
            $email .= "   <tr style='background:#666666; color:white;text-align:right'>";
            $email .= "      <td colspan='6'>Sub Total</td>";
            $email .= "      <td>Rp. " . number_format($subTotalItem, 0, '', ',') . "</td>";
            $email .= "  </tr>";
            $email .= "   <tr style='background:#666666; color:white;text-align:right'>";
            $email .= "      <td colspan='6'>Ongkos Kirim</td>";
            $email .= "      <td>Rp. " . number_format($value->ongkir_sementara, 0, '', ',') . "</td>";
            $email .= "  </tr>";
            $email .= "   <tr style='background:#666666; color:white;text-align:right'>";
            $email .= "      <td colspan='6'>Total</td>";
            $email .= "      <td>Rp. " . number_format($totalOrderItem, 0, '', ',') . "</td>";
            $email .= "  </tr>";
            /* Table Footer Order Item - End */
            $email .= "</table>";
        } /* End Looping Order */
        $totalBayarInvoice = ($totalBayar + $detInvoice->payment_fee +
            $detInvoice->mdr_installment) - $detInvoice->potongan_voucher -
            $detInvoice->potongan_point_rp;

        if ((int) $detInvoice->payment_fee > 0) {
            $paymentFee = number_format($detInvoice->payment_fee, 0, '', ',');
            $email .= "<table style='width:100%'>";
            $email .= "   <tr>";
            $email .= "      <td width='80%' style='text-align:right'>Convenience Fee</td>";
            $email .= "      <td width='20%' style='text-align:right'>Rp. " . $paymentFee . "</td>";
            $email .= "  </tr>";
            $email .= "</table>";
        }

        if ((int) $detInvoice->potongan_voucher > 0) {
            $potonganVoucher = number_format($detInvoice->potongan_voucher, 0, '', ',');
            $email .= "<table style='width:100%'>";
            $email .= "   <tr>";
            $email .= "      <td width='80%' style='text-align:right'>Potongan Voucher : " .
                              $detInvoice->voucher . "</td>";
            $email .= "      <td width='20%' style='text-align:right'>Rp. " . $potonganVoucher . "</td>";
            $email .= "  </tr>";
            $email .= "</table>";
        }

        if ((int) $detInvoice->potongan_point_rp > 0) {
            $potonganPointRp = number_format($detInvoice->potongan_point_rp, 0, '', ',');
            $kursPoint = $detInvoice->potongan_point_rp / $detInvoice->potongan_point;
            $kursPointStr = number_format($kursPoint, 0, '', ',');
            $email .= "<table style='width:100%'>";
            $email .= "   <tr>";
            $email .= "      <td width='80%' style='text-align:right'>Potongan Poin : " .
                            $detInvoice->potongan_point ." (1 poin = " . $kursPointStr . ")</td>";
            $email .= "      <td width='20%' style='text-align:right'>Rp. " . $potonganPointRp . "</td>";
            $email .= "  </tr>";
            $email .= "</table>";
        }

        if ((int) $detInvoice->mdr_installment > 0) {
            $paymentMdrFee = number_format($detInvoice->mdr_installment, 0, '', ',');
            $email .= "<table style='width:100%'>";
            $email .= "   <tr>";
            $email .= "      <td width='80%' style='text-align:right'>Biaya Administrasi</td>";
            $email .= "      <td width='20%' style='text-align:right'>Rp. " . $paymentMdrFee . "</td>";
            $email .= "  </tr>";
            $email .= "</table>";
        }

        $totalBayarInvoiceStr = number_format($totalBayarInvoice, 0, '', ',');
        $email .= "<table style='width:100%'>";
        $email .= "   <tr>";
        $email .= "      <td width='80%' style='text-align:right'>Grand Total</td>";
        $email .= "      <td width='20%' style='text-align:right'>Rp. " . $totalBayarInvoiceStr . "</td>";
        $email .= "  </tr>";
        $email .= "</table>";

        $email .= "<br/>";
        $email .= "<p>Terima Kasih,<br/><br/><br/><strong>Cipika Store &trade;</strong><br/>" .
                  "<a href='" . base_url() . "'>cipika.co.id</a></p>";

        /* Table Footer Order - Start */
        $email .= "";
        return $email;
    }
}
