<?php

namespace Cipika\View\Helper;

class CheckoutEmail
{

    public function getContentCheckoutEmail(
        $detInvoice,
        $detOrder,
        $detOrderItem,
        $detStoreItem,
        $detPaymentItem,
        $detShippingItem,
        $detInvoiceAddress,
        $detPayment,
        $detUser
    ) {
        $totalBayar = ($detInvoice->total + $detInvoice->ongkir) - $detInvoice->potongan_voucher;
        $email = "";
        $email .= "<h3>Bapak/Ibu " . $detInvoiceAddress->nama . " Yth.</h3>";

        if ($detInvoice->id_payment == 1) {
            $email .= "<p>Terima kasih Anda telah berbelanja melalui CipikaStore. ".
                      "Silahkan lakukan pembayaran Biaya Transaksi sesuai nilai yang " .
                      "tertera dalam Invoice, ke rekening CipikaStore berikut: </p>";
            $email .= "<table style='margin: 2em 0;'>
                          <tr>
                              <td style='width: 200px'>Nama Bank</td>
                              <td style='width: px'>:</td>
                              <td><strong>Bank Permata (kode bank 013)</strong></td>
                          </tr>
                          <tr>
                              <td style='width: 200px'>Nomor Rekening (VAN ID)</td>
                              <td style='width: 10px'>:</td>
                              <td><strong>" . $detPayment . "</strong></td>
                          </tr>
                      </table>";
            $waktu_exp = date('d-m-Y H:i:s', mktime(date('H') + 24, date('i'),
                        date('s'), date('m'), date('d'), date('Y')));
            $email .= "<p>Pembayaran dapat Anda lakukan melalui Jaringan <strong>ATM " .
                      "Bersama</strong>, <strong>PRIMA</strong>, dan <strong>ALTO</strong>. " .
                      "Anda juga diperkenankan memanfaatkan kemudahan fasilitas E-Banking " .
                      "yang dilengkapi menu <strong>Transfer Bank Online</strong>, namun " .
                      "pastikan fasilitas pembayaran yang Anda gunakan tidak memerlukan " .
                      "proses kliring. <br>Pastikan Anda menyelesaikan pembayaran sebelum " .
                      $waktu_exp . ". Apabila melebihi periode tersebut, maka Virtual " .
                      "Account (VAN ID) secara otomatis ditutup dan transaksi tidak " .
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
                          <td>" . $detInvoiceAddress->nama . "</td>
                      </tr>
                      <tr>
                          <td style='width: 200px'>Alamat</td>
                          <td style='width: 10px'>:</td>
                          <td><strong>" . $detInvoiceAddress->alamat . " , ".
                            ucfirst(strtolower($detInvoiceAddress->nama_kota)).", ".
                            ucfirst($detInvoiceAddress->nama_provinsi)."</strong></td>
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
                          <td><strong>Rp " . number_format($totalBayar, 0, ',', '.') . "</strong></td>
                      </tr>
                      <tr>
                          <td style='width: 200px'>Tanggal</td>
                          <td style='width: 4px'>:</td>
                          <td><strong>" . date('d-m-Y H:i:s') . "</strong></td>
                      </tr>
                   </table>";
        } else if ($detInvoice->id_payment == 5) {
            $email .= "Terima kasih Anda telah berbelanja melalui Cipika Store. " .
                      "Apabila saldo yang ada pada Akun DompetKu anda mencukupi, " .
                      "maka secara otomatis pemesanan akan di proses lebih lanjut.</p>";
            $email .= "<p>Pengiriman barang akan dilakukan dalam waktu 7 hari kerja. " .
                      "Pengiriman produk akan dilakukan langsung oleh Merchant kami " .
                      "melalui jasa ekspedisi dan layanan yang telah disepakati. Anda " .
                      "akan menerima informasi lebih lanjut apabila diperlukan " .
                      "perpanjangan waktu pengiriman.</p>";
            $email .= "<p>Apabila dalam daftar belanja Anda terdapat produk digital, " .
                      "pulsa akan langsung ditambahkan ke nomor Selular yang telah " .
                      " Anda tentukan saat transaksi. Hubungi kami jika lebih dari 2 " .
                      "(dua) jam pulsa belum Anda terima.</p>";
            $email .= "<table style='margin: 2em 0;'>
                          <tr>
                              <td style='width: 200px'>Nomer Akun DompetKU</td>
                              <td style='width: px'> : </td>
                              <td>" . $detPayment->msisdn . "</td>
                          </tr>
                          <tr>
                              <td style='width: 200px'>Jumlah yang sudah terbayar</td>
                              <td style='width: 4px'> : </td>
                              <td><strong>Rp " . number_format($totalBayar, 0, ',', '.') .
                                "</strong>
                              </td>
                          </tr>
                      </table>";
        } elseif ($detInvoice->id_payment == 6) {
            $email .= "<p>Terima kasih Anda telah berbelanja melalui Cipika Store.</p>";
            $email .= "<p>Pengiriman barang akan dilakukan dalam waktu 7 hari kerja." .
                      "Pengiriman produk akan dilakukan langsung oleh Merchant kami " .
                      "melalui jasa ekspedisi dan layanan yang telah disepakati. Anda " .
                      "akan menerima informasi lebih lanjut apabila diperlukan " .
                      "perpanjangan waktu pengiriman.</p>";
            $email .= "<p>Apabila dalam daftar belanja Anda terdapat produk digital, " .
                      "pulsa akan langsung ditambahkan ke nomor Selular yang telah " .
                      "Anda tentukan saat transaksi. Hubungi kami jika lebih dari 2 (dua) " .
                      "jam pulsa belum Anda terima.</p>";
            $email .= "<table style='margin: 2em 0;'>
                          <tr>
                              <td style='width: 200px'>Kode Transaksi Mandiri ClickPay</td>
                              <td style='width: px'> : </td>
                              <td>" . $detPayment . "</td>
                          </tr>
                          <tr>
                              <td style='width: 200px'>Jumlah yang sudah terbayar</td>
                              <td style='width: 4px'> : </td>
                              <td><strong>Rp " . number_format($totalBayar, 0, ',', '.') .
                                "</strong>
                              </td>
                          </tr>
                      </table>";
        } elseif ($detInvoice->id_payment == 9) {
            $date_exp = date('d-m-Y', mktime(date('H') + 24, date('i'), date('s'),
                            date('m'), date('d'), date('Y')));
            $time_exp = date('H:i:s', mktime(date('H') + 24, date('i'), date('s'),
                            date('m'), date('d'), date('Y')));
            
            $email .= "<div style='border: 2px black solid; padding:0.3em; margin:2px'>";
            $email .= "<p>Mohon Perhatian!<br>Anda menggunakan metode pembayaran Transfer " .
                      "Bank BCA/MANDIRI. Setelah membayar, Anda wajib melakukan Konfirmasi" .
                      " Pembayaran disini atau ikuti langkah berikut:</p>";
            $email .= "<p>
                          <label>A. Dengan membuka website Cipika</label>
                          <ol type=number>
                              <li>Buka <a href='http://cipika.co.id'>www.cipika.co.id</a></li>
                              <li>Login dengan username & password Anda</li>
                              <li>Klik menu <strong><a href='". base_url(). "order/konfirmasi'>" .
                                "Konfirmasi Pembayaran</a></strong></li>
                              <li>Lengkapi data pembayaran dengan benar dan kirim</li>
                          </ol>
                          <label>B. Dengan membuka Aplikasi Cipika Android</label>
                          <ol type=number>
                              <li>Buka Aplikasi Cipika</li>
                              <li>Login dengan username & password Anda</li>
                              <li>Klik tombol main menu di pojok kiri atas</li>
                              <li>Klik menu <strong><a href='" . base_url() . "android_konfirmasi'>" .
                                "Konfirmasi Pembayaran</a></strong></li>
                              <li>Lengkapi data pembayaran dengan benar dan kirim</li>
                          </ol>
                        </p>";
            $email .= "<p>Batas waktu Pembayaran dan Konfirmasi Pembayaran adalah tanggal " .
                      "<strong>" . htmlspecialchars($date_exp) . "</strong> pukul <strong>" .
                      htmlspecialchars($time_exp). "</strong> WIB. Apabila Anda menemui " .
                      "kendala atau lupa konfirmasi sehingga menyebabkan transaksi " .
                      "Expired, segera hubungi e-   care.store@cipika.co.id. Customer " .
                      "service kami akan memandu anda melakukan konfirmasi dengan batas " .
                      "waktu tertentu sesuai kebijakan Cipika.</p>";
            $email .= "</div>";

            $email .= "<p><u><strong>Detail Pembayaran</strong></u></p>";
            $email .= "<table style='margin: 2em 0;'>
                          <tr>
                             <td style='width: 200px'>Nama Bank</td>
                             <td style='width: px'>:</td>
                             <td><strong>" . htmlspecialchars(NAME_OF_BANK_MANDIRI_TRANSFER) .
                                "</strong>
                            </td>
                          </tr>
                          <tr>
                             <td style='width: 200px'>Pemilik Rekening</td>
                             <td style='width: px'>:</td>
                             <td><strong>" . htmlspecialchars(ACCOUNT_OF_BANK_MANDIRI_TRANSFER) .
                                "</strong>
                            </td>
                          </tr>
                          <tr>
                             <td style='width: 200px'>Nomor Rekening</td>
                             <td style='width: 10px'>:</td>
                             <td><strong>" . htmlspecialchars(NO_REK_OF_BANK_MANDIRI_TRANSFER) .
                                "</strong>
                             </td>
                          </tr>
                        </table>";
            $email .= "<p>Ketentuan Pembayaran :
                          <ol type=number>
                             <li>Bayar melalui ATM Bersama, Prima, Alto. Atau Internet " .
                                "Banking dari Bank yang menyediakan menu Transfer Antar " .
                                "Bank Online.
                             </li>
                             <li>Bayar sesuai nilai tagihan. Transaksi tidak akan diproses " .
                                "jika ada kekurangan bayar hingga pelunasan sesuai kebijakan " .
                                "Cipika. Kelebihan bayar akan dikembalikan dalam bentuk " .
                                "point/Voucher, pengembalian kelebihan bayar dalam bentuk " .
                                "uang dikenakan biaya transfer bank.
                            </li>
                            <li>Tidak disarankan menggunakan alat pembayaran dengan proses " .
                                "Kliring. Cipika berhak membatalkan transaksi dengan proses " .
                                "Kliring
                            </li>
                           </ol>
                        </p>";
            $email .= "<table style='margin: 2em 0;'>
                      <tr>
                          <td style='width: 200px'>Invoice No</td>
                          <td style='width: px'>:</td>
                          <td><strong>" . $detInvoice->kode_invoice . "</strong></td>
                      </tr>
                      <tr>
                          <td style='width: 200px'>Nama</td>
                          <td style='width: px'>:</td>
                          <td>" . $detInvoiceAddress->nama . "</td>
                      </tr>
                      <tr>
                          <td style='width: 200px'>Alamat</td>
                          <td style='width: 10px'>:</td>
                          <td><strong>" . $detInvoiceAddress->alamat . " , ".
                            ucfirst(strtolower($detInvoiceAddress->nama_kota)).", ".
                            ucfirst($detInvoiceAddress->nama_provinsi)."</strong></td>
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
                          <td><strong>Rp " . number_format($totalBayar, 0, ',', '.') . "</strong></td>
                      </tr>
                      <tr>
                          <td style='width: 200px'>Tanggal</td>
                          <td style='width: 4px'>:</td>
                          <td><strong>" . date('d-m-Y H:i:s') . "</strong></td>
                      </tr>
                   </table>";
        } elseif ($detInvoice->id_payment == 10) {
            $date_exp = date('d-m-Y', mktime(date('H') + 24, date('i'), date('s'),
                            date('m'), date('d'), date('Y')));
            $time_exp = date('H:i:s', mktime(date('H') + 24, date('i'), date('s'),
                            date('m'), date('d'), date('Y')));
            
            $email .= "<div style='border: 2px black solid; padding:0.3em; margin:2px'>";
            $email .= "<p>Mohon Perhatian!<br>Anda menggunakan metode pembayaran Transfer " .
                      "Bank BCA/MANDIRI. Setelah membayar, Anda wajib melakukan Konfirmasi" .
                      " Pembayaran disini atau ikuti langkah berikut:</p>";
            $email .= "<p>
                          <label>A. Dengan membuka website Cipika</label>
                          <ol type=number>
                              <li>Buka <a href='http://cipika.co.id'>www.cipika.co.id</a></li>
                              <li>Login dengan username & password Anda</li>
                              <li>Klik menu <strong><a href='". base_url(). "order/konfirmasi'>" .
                                "Konfirmasi Pembayaran</a></strong></li>
                              <li>Lengkapi data pembayaran dengan benar dan kirim</li>
                          </ol>
                          <label>B. Dengan membuka Aplikasi Cipika Android</label>
                          <ol type=number>
                              <li>Buka Aplikasi Cipika</li>
                              <li>Login dengan username & password Anda</li>
                              <li>Klik tombol main menu di pojok kiri atas</li>
                              <li>Klik menu <strong><a href='" . base_url() . "android_konfirmasi'>" .
                                "Konfirmasi Pembayaran</a></strong></li>
                              <li>Lengkapi data pembayaran dengan benar dan kirim</li>
                          </ol>
                        </p>";
            $email .= "<p>Batas waktu Pembayaran dan Konfirmasi Pembayaran adalah tanggal " .
                      "<strong>" . htmlspecialchars($date_exp) . "</strong> pukul <strong>" .
                      htmlspecialchars($time_exp). "</strong> WIB. Apabila Anda menemui " .
                      "kendala atau lupa konfirmasi sehingga menyebabkan transaksi " .
                      "Expired, segera hubungi e-   care.store@cipika.co.id. Customer " .
                      "service kami akan memandu anda melakukan konfirmasi dengan batas " .
                      "waktu tertentu sesuai kebijakan Cipika.</p>";
            $email .= "</div>";

            $email .= "<p><u><strong>Detail Pembayaran</strong></u></p>";
            $email .= "<table style='margin: 2em 0;'>
                          <tr>
                             <td style='width: 200px'>Nama Bank</td>
                             <td style='width: px'>:</td>
                             <td><strong>" . htmlspecialchars(NAME_OF_BANK_BCA_TRANSFER) .
                                "</strong>
                            </td>
                          </tr>
                          <tr>
                             <td style='width: 200px'>Pemilik Rekening</td>
                             <td style='width: px'>:</td>
                             <td><strong>" . htmlspecialchars(ACCOUNT_OF_BANK_BCA_TRANSFER) .
                                "</strong>
                            </td>
                          </tr>
                          <tr>
                             <td style='width: 200px'>Nomor Rekening</td>
                             <td style='width: 10px'>:</td>
                             <td><strong>" . htmlspecialchars(NO_REK_OF_BANK_BCA_TRANSFER) .
                                "</strong>
                             </td>
                          </tr>
                        </table>";
            $email .= "<p>Ketentuan Pembayaran :
                          <ol type=number>
                             <li>Bayar melalui ATM Bersama, Prima, Alto. Atau Internet " .
                                "Banking dari Bank yang menyediakan menu Transfer Antar " .
                                "Bank Online.
                             </li>
                             <li>Bayar sesuai nilai tagihan. Transaksi tidak akan diproses " .
                                "jika ada kekurangan bayar hingga pelunasan sesuai kebijakan " .
                                "Cipika. Kelebihan bayar akan dikembalikan dalam bentuk " .
                                "point/Voucher, pengembalian kelebihan bayar dalam bentuk " .
                                "uang dikenakan biaya transfer bank.
                            </li>
                            <li>Tidak disarankan menggunakan alat pembayaran dengan proses " .
                                "Kliring. Cipika berhak membatalkan transaksi dengan proses " .
                                "Kliring
                            </li>
                           </ol>
                        </p>";
            $email .= "<table style='margin: 2em 0;'>
                      <tr>
                          <td style='width: 200px'>Invoice No</td>
                          <td style='width: px'>:</td>
                          <td><strong>" . $detInvoice->kode_invoice . "</strong></td>
                      </tr>
                      <tr>
                          <td style='width: 200px'>Nama</td>
                          <td style='width: px'>:</td>
                          <td>" . $detInvoiceAddress->nama . "</td>
                      </tr>
                      <tr>
                          <td style='width: 200px'>Alamat</td>
                          <td style='width: 10px'>:</td>
                          <td><strong>" . $detInvoiceAddress->alamat . " , ".
                            ucfirst(strtolower($detInvoiceAddress->nama_kota)).", ".
                            ucfirst($detInvoiceAddress->nama_provinsi)."</strong></td>
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
                          <td><strong>Rp " . number_format($totalBayar, 0, ',', '.') . "</strong></td>
                      </tr>
                      <tr>
                          <td style='width: 200px'>Tanggal</td>
                          <td style='width: 4px'>:</td>
                          <td><strong>" . date('d-m-Y H:i:s') . "</strong></td>
                      </tr>
                   </table>";
        } elseif ($detInvoice->id_payment == 13) {
            $email .= "Terima kasih Anda telah berbelanja melalui Cipika Store. " .
                      "Apabila saldo yang ada pada Akun DompetKu anda mencukupi, " .
                      "maka secara otomatis pemesanan akan di proses lebih lanjut.</p>";
            $email .= "<p>Pengiriman barang akan dilakukan dalam waktu 7 hari kerja. " .
                      "Pengiriman produk akan dilakukan langsung oleh Merchant kami " .
                      "melalui jasa ekspedisi dan layanan yang telah disepakati. Anda " .
                      "akan menerima informasi lebih lanjut apabila diperlukan " .
                      "perpanjangan waktu pengiriman.</p>";
            $email .= "<p>Apabila dalam daftar belanja Anda terdapat produk digital, " .
                      "pulsa akan langsung ditambahkan ke nomor Selular yang telah " .
                      " Anda tentukan saat transaksi. Hubungi kami jika lebih dari 2 " .
                      "(dua) jam pulsa belum Anda terima.</p>";
            $email .= "<table style='margin: 2em 0;'>
                          <tr>
                              <td style='width: 200px'>Nomer Akun DompetKU</td>
                              <td style='width: px'> : </td>
                              <td>" . $detPayment->msisdn . "</td>
                          </tr>
                          <tr>
                              <td style='width: 200px'>Jumlah yang sudah terbayar</td>
                              <td style='width: 4px'> : </td>
                              <td><strong>Rp " . number_format($totalBayar, 0, ',', '.') .
                                "</strong>
                              </td>
                          </tr>
                      </table>";
        } else {
            $email .= "<p>Terima kasih Anda telah berbelanja melalui Cipika Store.</p>";
            $email .= "<p>Pengiriman barang akan dilakukan dalam waktu 7 hari kerja." .
                      "Pengiriman produk akan dilakukan langsung oleh Merchant kami " .
                      "melalui jasa ekspedisi dan layanan yang telah disepakati. Anda " .
                      "akan menerima informasi lebih lanjut apabila diperlukan perpanjangan " .
                      "waktu pengiriman.</p><br>";
            $email .= "<table style='margin: 0.5em 0;'>
                          <tr>
                              <td style='width: 200px'>Jumlah yang sudah terbayar</td>
                              <td style='width: 4px'> : </td>
                              <td><strong>Rp " . number_format($totalBayar, 0, ',','.') . "</strong></td>
                          </tr>
                      </table>";
        }
        $email .= "<hr />";
        $totalAll = 0;
        foreach ($detOrder as $value) {
            $email .= "<table width='100%'>
                          <tr>
                              <td width='40%'>Merchant: " .
                                ucwords($detStoreItem[$value->id_merchant]->nama_store) . "</td>
                              <td width='40%'>Nomor Transaksi: " . $value->kode_order . "</td>
                              <td width='20%'>Status: Success</td>
                          </tr>
                       </table>";
            $email .= "<table width='100%'>
                           <tr>
                              <td width='40%'>
                               <strong>Alamat Pengiriman</strong><br /><span></span>
                              " . ucwords($detShippingItem[$value->id_order]->nama) . "<br />
                              " . ucwords($detShippingItem[$value->id_order]->alamat) . "<br>
                              " . ucwords($detShippingItem[$value->id_order]->nama_kabupaten) .
                              " - " . ucwords($detShippingItem[$value->id_order]->nama_propinsi) . "<br>
                              " . $detShippingItem[$value->id_order]->telpon . "<br />
                              </td>
                              <td width='40%'>
                                  <strong>Metode Pengiriman</strong><br />
                                  " . ucwords($value->paket_ongkir) . "
                              </td>
                              <td width='20%'>
                                  <strong>Metode Pembayaran</strong><br>".
                                    $detPaymentItem[$value->id_order]->nama_payment.
                              "</td>
                           </tr>
                        </table><br>";
            $email .= "<table style='border-collapse:collapse; width:100%;'><tr style='background:".
                      "#666666; color:white;' class='judul'><td width='10%' style='text-align:center'".
                      ">No</td><td>Nama Produk</td><td width='10%' style='text-align:right'>Jumlah".
                      "</td><td width='15%' style='text-align:right'>Harga</td><td width='10%' " .
                      "style='text-align:right'>Diskon</td><td width='15%' style='text-align:right'>" .
                      "Harga setelah diskon</td><td width='20%' style='text-align:right'>Subtotal</td>" .
                      "</tr>";
            $i = 0;
            $detailPaket = "";
            $sub_total = 0;
            foreach ($detOrderItem[$value->id_order] as $items) {
                $harga_diskon = $items->harga - $items->diskon_rp;
                $total_sub = $harga_diskon * $items->jml_produk;
                $i++;
                $detailPaket = !empty($items->detail_paket)?'<br>('.$items->detail_paket.')':'';
                $email .= '<tr style="text-align:center; vertical-align:top"><td>' . $i . '</td>' .
                          '<td style="text-align:left"><a href="' . base_url() . 'product/detail/' .
                          $items->id_produk . '" >' . $items->nama_produk . '</a>'.$detailPaket.'</td>' .
                          '<td style="text-align:right">' . $items->jml_produk . '</td>' .
                          '<td style="text-align:right">Rp. ' .
                          number_format($items->harga, 0 , '' , '.' ) . '</td>' .
                          '<td style="text-align:right">' . $items->diskon . '%</td>' .
                          '<td style="text-align:right">Rp. ' .
                          number_format($harga_diskon, 0 , '' , '.' ) . '</td>' .
                          '<td style="text-align:right">Rp. ' .
                          number_format($total_sub, 2, ',', '.') . '</td>'.
                         '</tr>';
                $sub_total += $total_sub;
                $total_harga = $sub_total + $value->ongkir_sementara;
            }
            $email .= '<tr style="background:#666666; color:white; text-align:right">' .
                      '<td colspan="6">Sub Total</td><td>Rp. ' .
                      number_format($sub_total, 0, ',', '.') . '</td></tr>';
            $email .= '<tr style="background:#666666; color:white; text-align:right">' .
                      '<td colspan="6">Ongkos Kirim</td><td>Rp. ' .
                      number_format($value->ongkir_sementara, 0, ',', '.') . '</td></tr>';
            $email .= '<tr style="background:#666666; color:white; text-align:right">' .
                      '<td colspan="6">Total</td><td>Rp. ' .
                      number_format($total_harga, 0, ',', '.') . '</td></tr>';
            $totalAll += $total_harga;
            $email .= "</table>";

        }
        $totalPrint = ($totalAll + $detInvoice->payment_fee) - $detInvoice->potongan_voucher;
  
        if ((int)$detInvoice->payment_fee > 0) {
            $email .= "<table width='100%'>
                          <tr>
                              <td width='80%' style='text-align: right;'>Convenience Fee</td>
                              <td width='20%' style='text-align: right;'>Rp " .
                                number_format($detInvoice->payment_fee, 0, ',', '.') . "</td>
                          </tr>
                      </table>";
        }
        if ((int)$detInvoice->potongan_voucher > 0) {
            $email .= "<table width='100%'>
                          <tr>
                              <td width='80%' style='text-align: right;'>Potongan Voucher : " .
                                $detInvoice->voucher."</td>
                              <td width='20%' style='text-align: right;'>Rp " .
                                number_format($detInvoice->potongan_voucher, 0, ',', '.') . "</td>
                          </tr>
                      </table>";
        }
        $email .= "<table width='100%'>
                       <tr>
                           <td width='80%' style='text-align: right;'>Grand Total </td>
                           <td width='20%' style='text-align: right;'>Rp " .
                           number_format($totalPrint, 0, ',', '.') . "</td>
                       </tr>
                   </table>";
        $email .= '<br/><p>Terima Kasih,<br/><br/><br/><strong>Cipika Store &trade;</strong><br>
                  <a href="' . base_url() . '">cipika.co.id</a></p></div>';

        return $email;
    }
}
