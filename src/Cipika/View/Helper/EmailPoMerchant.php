<?php

namespace Cipika\View\Helper;

class EmailPoMerchant {

    protected $dbLibrary;
    protected $from;
    protected $bcc = array();

    public function __construct($dbLibrary, $from, array $bcc = array())
    {
        $this->dbLibrary = $dbLibrary;
        $this->from = $from;
        $this->bcc = $bcc;
    }

    public function send($to, $inputan_order, $inputan_shipping, $inputan_merchant, $order_item, $link_index)
    {
        $email_merchant = "";
        foreach ($inputan_order as $v)
        {
            $email_merchant = '<style>* {font-family:Arial, serif;font-size:12px} table tr td {padding:2px 5px;} tr.judul td {font-weight:bold;}</style>';
            $email_merchant.= "<h3>Bapak/Ibu " . ucwords($inputan_merchant[$v->id_merchant]) . " Yth.</h3>
                <br />
                <p>
                   Anda menerima order pembelian produk melalui Cipika Store. Mohon segera mengirimkan produk ke alamat pengiriman melalui jasa & paket ekspedisi seperti tercantum dalam detil informasi pembelian berikut:
                </p>
                ";
            $email_merchant .= "
                <table style='margin: 2em 0;'>
                    <tr>
                        <td>Nama : </td>
                        <td>" . $inputan_shipping[$v->id_order]->nama . "</td>
                    </tr>
                    <tr>
                        <td>Email : </td>
                        <td>" . $inputan_shipping[$v->id_order]->email . "</td>
                    </tr>
                    <tr>
                        <td>Phone : </td>
                        <td>" . $inputan_shipping[$v->id_order]->telpon . "</td>
                    </tr>
                    <tr>
                        <td>Alamat : </td>
                        <td>" . $inputan_shipping[$v->id_order]->alamat . "</td>
                    </tr>
                    <tr>
                        <td>Kota/Kab : </td>
                        <td>" . strtoupper($inputan_shipping[$v->id_order]->nama_kabupaten) . "</td>
                    </tr>
                    <tr>
                        <td>Provinsi : </td>
                        <td>" . strtoupper($inputan_shipping[$v->id_order]->nama_propinsi) . "</td>
                    </tr>
                    
                    <tr>
                        <td>Paket Pengiriman: </td>
                        <td>" . ucwords($v->paket_ongkir) . "</td>
                    </tr>
                    </table>";
            $email_merchant .= '<table style="border-collapse:collapse; width:100%;">
                <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td width="10%" style="text-align:center">SKU</td><td>Nama Produk</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="10%" style="text-align:right">Diskon</td><td width="15%" style="text-align:right">Harga setelah diskon</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
            $i = 0;
            $total_sub = 0;
            $sub_total = 0;
            $totalAll = 0;
            foreach ($order_item[$v->id_order] as $items)
            {
                if ($items->diskon > 0)
                    $harga_diskon = $items->harga - ($items->harga) * ($items->diskon / 100);
                else
                    $harga_diskon = $items->harga;
                $total_sub = $harga_diskon * $items->jml_produk;
                $i++;
                $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td>
                        <td>' . $items->id_produk . '</td> 
                        <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a></td>
                        <td style="text-align:right">' . $items->jml_produk . '</td>
                        <td style="text-align:right">Rp. ' . number_format($items->harga, 0, '.', ',') . '</td>                        
                        <td style="text-align:right">' . $items->diskon . '%</td>
                        <td style="text-align:right">Rp. ' . number_format($harga_diskon, 0, '.', ',') . '</td>
                        <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                    </tr>';
                $sub_total += $total_sub;
            }
            $tambahan_wording1='';
            if ($v->ongkir_sementara>0) { $tambahan_wording1=', maksimal sebesar Rp. ' . number_format($v->ongkir_sementara, 0, '.', ','); }
            $email_merchant .= "</table><br>
                <p>
                    Total nilai pembelian dalam informasi di atas belum termasuk biaya pengiriman. Silahkan input nomor resi pengiriman melalui CMS Merchant anda. Cipika Store akan mengganti biaya pengiriman bersamaan dengan proses settlement" . $tambahan_wording1 . ".
                </p>
                </table>";
            $email_merchant .= '<br/><p>Terima kasih atas perhatian dan kerjasama yang baik,<br/><br/><br/>
                    <strong>Cipika Store &trade;</strong><br>
                    <a href="' . base_url() . '">cipika.co.id</a>
                    </p>
                    </div>
                    ';
        }
        $list = $this->bcc;
        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'PO Merchant',
            'mailer_from' => $this->from,
            'mailer_to' => $to,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Informasi Pembelian di Cipika Store',
            'mailer_message' => $email_merchant,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sends($to, $order, $inputan_shipping, $nama_merchant, $order_item, $link_index, $matrix = null)
    {
        $email_merchant = "<h3>Bapak/Ibu " . ucwords($nama_merchant) . " Yth.</h3>
                <br />
                <p>
                   Anda menerima order pembelian produk melalui Cipika Store. Mohon segera mengirimkan produk ke alamat pengiriman melalui jasa & paket ekspedisi seperti tercantum dalam detil informasi pembelian berikut:
                </p>
                ";
        $email_merchant .= "
                <table style='margin: 2em 0;'>
                    <tr>
                        <td>Nama : </td>
                        <td>" . $inputan_shipping->nama . "</td>
                    </tr>
                    <tr>
                        <td>Email : </td>
                        <td>" . $inputan_shipping->email . "</td>
                    </tr>
                    <tr>
                        <td>Phone : </td>
                        <td>" . $inputan_shipping->telpon . "</td>
                    </tr>
                    <tr>
                        <td>Alamat : </td>
                        <td>" . $inputan_shipping->alamat . "</td>
                    </tr>
                    <tr>
                        <td>Kota/Kab : </td>
                        <td>" . strtoupper($inputan_shipping->nama_kabupaten) . "</td>
                    </tr>
                    <tr>
                        <td>Provinsi : </td>
                        <td>" . strtoupper($inputan_shipping->nama_propinsi) . "</td>
                    </tr>
                    
                    <tr>
                        <td>Paket Pengiriman: </td>
                        <td>" . ucwords($order->paket_ongkir) . "</td>
                    </tr>
                    </table>";
        $email_merchant .= "<tabel><tr><td><strong>Kode Order </strong></td><td> : </td><td> ".$order->kode_order."</td></tr></table>";
        $email_merchant .= '<table style="border-collapse:collapse; width:100%;">
                <tr style="background:#666666; color:white;" class="judul"><td width="10%" style="text-align:center">No</td><td width="10%" style="text-align:center">SKU</td><td>Nama Produk</td><td width="30%">Detail Paket</td><td width="10%" style="text-align:right">Jumlah</td><td width="15%" style="text-align:right">Harga</td><td width="20%" style="text-align:right">Subtotal</td></tr>';
        $i = 0;
        $total_sub = 0;
        $sub_total = 0;
        $totalAll = 0;
        foreach ($order_item as $items)
        {
            $total_sub = $items->harga_merchant * $items->jml_produk;
            $i++;
			$detail_paket = "";
			if(!empty($items->detail_paket)){
				$detail_paket = $items->detail_paket;
			}else{
				$detail_paket = $items->nama_produk;
			}
            $email_merchant .= '<tr style="text-align:center"><td>' . $i . '</td>
                        <td>' . $items->id_produk . '</td> 
                        <td style="text-align:left"><a href="' . base_url() . $link_index . 'product/detail/' . $items->id_produk . '" >' . $items->nama_produk . '</a></td>
						<td style="text-align:left">'.$detail_paket.'</td>
                        <td style="text-align:right">' . $items->jml_produk . '</td>
                        <td style="text-align:right">Rp. ' . number_format($items->harga_merchant, 0, '.', ',') . '</td>                        
                        <td style="text-align:right">Rp. ' . number_format($total_sub, 0, '.', ',') . '</td>
                    </tr>';
            $sub_total += $total_sub;
        }
        $email_merchant .= "</table><br>";
        if ($matrix !== null) {
            $email_merchant .= '<br/>';
            $email_merchant .= 'MSISDN Matrix : '. $matrix->msisdn_pelanggan;
        }
        if ($order->keterangan != null) {
            $email_merchant .= "<strong>Notes</strong> : <p align='justify'>" . $order->keterangan . "</p><br>";
        }
        $tambahan_wording1='';
        if ($order->original_shipping_fee>0) { $tambahan_wording1=', maksimal sebesar Rp. ' . number_format($order->original_shipping_fee, 0, '.', ','); }
        $email_merchant .= "<p>Total nilai pembelian dalam informasi di atas belum termasuk biaya pengiriman. Silahkan input nomor resi pengiriman melalui CMS Merchant anda. Cipika Store akan mengganti biaya pengiriman bersamaan dengan proses settlement".$tambahan_wording1.".
                </p></table>";
        $email_merchant .= '<br/><p>Terima kasih atas perhatian dan kerjasama yang baik,<br/><br/><br/>
                    <strong>Cipika Store &trade;</strong><br>
                    <a href="' . base_url() . '">cipika.co.id</a>
                    </p>
                    ';

        $list = $this->bcc;
        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'PO Merchant',
            'mailer_from' => $this->from,
            'mailer_to' => $to,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Informasi Pembelian di Cipika Store',
            'mailer_message' => $email_merchant,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );

        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

}
