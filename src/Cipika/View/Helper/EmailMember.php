<?php

namespace Cipika\View\Helper;

class EmailMember 
{

    protected $dbLibrary;
    protected $from;
    protected $bcc;

    public function __construct($dbLibrary, $from, $bcc) 
    {
        $this->dbLibrary = $dbLibrary;
        $this->from = $from;
        $this->bcc = $bcc;
    }

    public function sendEmailActivationNewMember($user, $urlActivation) 
    {
        $email = "";
        $email .= '<strong>Member CipikaStore Yth,</strong>' .
                '<p>Selamat! Anda berhasil melakukan pendaftaran Member 
                        CipikaStore dengan detil informasi sebagai berikut:</p>';
        $email .= '<table style="border:none;">
                    <tr>
                        <td style="width:150px;">Username</td><td>:</td><td>' . $user['email'] . '</td>
                    </tr>
                    <tr>
			<td>Link Validasi</td><td>:</td><td>' . $urlActivation . '</td>
                    </tr>
                  </table>';
        $email .= '<p>Segera klik Link di atas untuk validasi akun. Jika link validasi tidak clickable, 
                mohon salin link tersebut ke address bar browser yang Anda gunakan. Terima kasih.</p><br>';
        $email .= '<p>Sales & Administration</p>';

        $insert = array(
            'idmailer'          => null,
            'mailer_module'     => "Activation New Member",
            'mailer_from'       => $this->from,
            'mailer_to'         => $user['email'],
            'mailer_subject'    => "Aktivasi registrasi member cipika.co.id",
            'mailer_message'    => $email,
            'mailer_status'     => 'new',
            'mailer_created'    => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return (int) $this->dbLibrary->insert_id();
    }

    public function sendEmailNewRegisterMemberKaryawan($user)
    {
        $email = "";
        $email .= "<p>Anda telah menjadi member Cipika.co.id. Silahkan ganti " .
                  "password Anda di account Cipika dengan login menggunakan " .
                  "user ID dan password sebagai berikut:</p>";
        $email .= "<table style='border:none;'> <tr>
                        <td style='width:150px;'>Username</td><td>:</td>
                        <td>" . htmlspecialchars($user->email) . "</td>
                     </tr>
                     <tr>
                        <td style='width:150px;'>Password</td><td>:</td>
                        <td>" . htmlspecialchars($user->nik) . "</td>
                     </tr>
                   </table>";
        $email .= "<p>Demi keamanan, segera rubah Password anda. Terima kasih.</p><br>";
        $email .= "<p>Langkah cepat mengganti password & melengkapi profile Anda :</p>";
        $email .= "<ol type='number'>" .
                  "   <li>Buka <a href='https://cipika.co.id'>https://cipika.co.id</a>" .
                  "   </li>" .
                  "   <li>Klik menu <strong>Masuk</strong>, sebelah kanan atas, " .
                  "       masukkan username & password (yang sudah Anda terima " .
                  "       by email)</li>".
                  "   <li>Setelah web terbuka, di tempat yang sama klik menu " .
                  "       account, silahkan mengganti password</li>".
                  "   <li>Klik menu <strong>Profile, isi dengan lengkap</strong>" .
                  "       (disarankan untuk pengiriman , alamat ditujukan ke " .
                  "       kantor.</li>".
                  "   <li>Langsung bisa dilanjutkan berbelanja.</li>" .
                  "   <li>Apabila menemui kendala dapat kirim email dengan " .
                  "       <strong>Subject : Perubahan Password Cipika Karyawan " .
                  "       Indosat, ke : <a href='mailto:e-care.store@cipika.co.id'>" .
                  "       e-care.store@cipika.co.id</a></strong> (Jam kerja Senin " .
                  "       - Jumat pukul 8.00 s/d 19.00)</li>" .
                  "</ol>";
        $email .= '<br>';
        $email .= '<p>Sales & Administration</p>';

        $insert = array(
            'idmailer'          => null,
            'mailer_module'     => "Register Member - Karyawan",
            'mailer_from'       => $this->from,
            'mailer_to'         => $user->email,
            'mailer_subject'    => "Registrasi Member cipika.co.id",
            'mailer_message'    => $email,
            'mailer_status'     => 'new',
            'mailer_created'    => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendEmailResetPasswordMemberKaryawan($user)
    {
        $email = "";
        $email .= "<p>Anda telah menjadi member Cipika.co.id. Silahkan ganti " .
                  "password Anda di account Cipika dengan login menggunakan " .
                  "user ID dan password sebagai berikut:</p>";
        $email .= "<table style='border:none;'> <tr>
                        <td style='width:150px;'>Username</td><td>:</td>
                        <td>" . htmlspecialchars($user->email) . "</td>
                     </tr>
                     <tr>
                        <td style='width:150px;'>Password</td><td>:</td>
                        <td>" . htmlspecialchars($user->nik) . "</td>
                     </tr>
                   </table>";
        $email .= '<p>Demi keamanan, segera rubah Password anda. Terima kasih.' .
                  '</p><br>';
        $email .= '<p>Sales & Administration</p>';

        $insert = array(
            'idmailer'          => null,
            'mailer_module'     => "Reset Password Member - Karyawan",
            'mailer_from'       => $this->from,
            'mailer_to'         => $user->email,
            'mailer_subject'    => "Registrasi Member cipika.co.id",
            'mailer_message'    => $email,
            'mailer_status'     => 'new',
            'mailer_created'    => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendEmailVoucherKaryawan($user, $voucher)
    {
        $date = new \DateTime($voucher->date_start);
        $dateStart = $date->format('d-m-Y');

        $date = new \DateTime($voucher->date_expired);
        $dateEnd = $date->format('d-m-Y');

        $nominalVoucher = $voucher->nominal;
        $nominalVoucher = number_format($nominalVoucher, 0, ',', '.');

        $email = "";
        $email .= "<p>Sebagai bentuk dukungan perusahaan terhadap kesehatan karyawan, dan komitmen perusahaan terhadap PKB yang telah disetujui bersama Serikat Pekerja Indosat, maka anda mendapatkan Voucher Belanja Item Sport di Cipika.co.id :</p><br /><br />";
        $email .= "<table style='border:none;'> <tr>
                        <td style='width:150px;'>Kode Voucher</td><td>:</td>
                        <td>" . htmlspecialchars($voucher->kode_voucher) . "</td>
                     </tr>
                     <tr>
                        <td style='width:150px;'>Tanggal Berlaku</td><td>:</td>
                        <td>" . htmlspecialchars($dateStart) . "</td>
                     </tr>
                     <tr>
                        <td style='width:150px;'>Tanggal Expired</td><td>:</td>
                        <td>" . htmlspecialchars($dateEnd) . "</td>
                     </tr>
                     <tr>
                        <td style='width:150px;'>Nominal Voucher</td><td>:</td>
                        <td>Rp " . htmlspecialchars($nominalVoucher) . "</td>
                     </tr>
                   </table>";
        $email .= '<p>Silakan kunjungi <a href="https://cipika.co.id/page/index/24/program-perlengkapan-olahraga-untuk-karyawan-indosat">https://cipika.co.id/page/index/24/program-perlengkapan-olahraga-untuk-karyawan-indosat</a> untuk cara penggunaan voucher. Terima kasih.' .
                  '</p><br>';
        $email .= '<p>Sales & Administration</p>';

        $insert = array(
            'idmailer'          => null,
            'mailer_module'     => "Free Voucher Karyawan",
            'mailer_from'       => $this->from,
            'mailer_to'         => $user->email,
            'mailer_subject'    => "Voucher cipika.co.id",
            'mailer_message'    => $email,
            'mailer_status'     => 'new',
            'mailer_created'    => date('Y-m-d H:i:s')
        );
        $this->dbLibrary->insert('mailer', $insert);
        return $this->dbLibrary->insert_id();
    }

}
