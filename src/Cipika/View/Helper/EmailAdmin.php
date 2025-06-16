<?php

namespace Cipika\View\Helper;

class EmailAdmin {

    protected $dbLibrary;
    protected $from;
    protected $bcc = array();

    public function __construct($dbLibrary, $from, array $bcc = array(), $to)
    {
        $this->dbLibrary = $dbLibrary;
        $this->from = $from;
        $this->bcc = $bcc;
        $this->to = $to;
    }

    public function sendNotifKonfirmasiPembayaran($kode_invoice, $detUser, $detPembayaran)
    {
        $email_merchant = "";
        $email_merchant.= "<h3>Bapak/Ibu Admin Yth.</h3>
                <br />
                <p>
                   Pembeli dengan detail berikut ini :
                </p>
                ";
        $email_merchant .= "
                <table style='margin: 2em 0;'>
                    <tr>
                        <td>Nama</td>
                        <td> :</td>
                        <td> " . $detUser['firstname'] . "" . $detUser['lastname'] . "</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> :</td>
                        <td> " . $detUser['email'] . "</td>
                    </tr>
                    <tr>
                        <td>Telpon</td>
                        <td> :</td>
                        <td> " . $detUser['telpon'] . "</td>
                    </tr>
                    <tr>
                        <td>HP</td>
                        <td>:</td>
                        <td> " . $detUser['hp'] . "</td>
                    </tr>
                    </table>";
        $email_merchant .="Telah melakukan konfirmasi Pembayaran dengan detail berikut ini : ";
        $email_merchant .= "
                <table style='margin: 2em 0;'>
                    <tr>
                        <td>Kode Invoice: </td>
                        <td>" . $kode_invoice . "</td>
                    </tr>
                    <tr>
                        <td>Nama Rekening Pengirim : </td>
                        <td>" . $detPembayaran['pemilik_rekening_bayar'] . "</td>
                    </tr>
                    <tr>
                        <td>Nomor Rekening Pengirim : </td>
                        <td>" . $detPembayaran['nomor_rekening_bayar'] . "</td>
                    </tr>
                    <tr>
                        <td>Bank Rekening Pengirim : </td>
                        <td>" . $detPembayaran['bank_rekening_bayar'] . "</td>
                    </tr>
                    <tr>
                        <td>Tanggal Bayar: </td>
                        <td>" . $detPembayaran['tanggal_bayar'] . "</td>
                    </tr>
                    <tr>
                        <td>Cara transfer : </td>
                        <td>" . $detPembayaran['cara_bayar'] . "</td>
                    </tr>
                    <tr>
                        <td>Rekening Tujuan : </td>
                        <td>" . $detPembayaran['rekening_tujuan'] . "</td>
                    </tr>
                    <tr>
                        <td>Total Pengiriman : </td>
                        <td>" . $detPembayaran['total_bayar'] . "</td>
                    </tr>
                    </table>";
        $email_merchant .="Mohon untuk di proses lebih lanjut.Untuk melakukan Verified bisa melalui menu Admin -> Konfirmasi Pembayaran. <br>";
        $email_merchant .= '<br/><p>Terima kasih atas perhatian dan kerjasama yang baik,<br/><br/><br/>
                    <strong>Cipika Store &trade;</strong><br>
                    <a href="' . base_url() . '">cipika.co.id</a>
                    </p>
                    </div>
                    ';
        $list = $this->bcc;
        $list = implode(",", $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Notifikasi Konfirmasi Bayar',
            'mailer_from' => $this->from,
            'mailer_to' => $this->to,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Notifikasi Konfirmasi Pembayaran Pembeli',
            'mailer_message' => $email_merchant,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

}
