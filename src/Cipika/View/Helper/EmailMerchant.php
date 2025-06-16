<?php

namespace Cipika\View\Helper;

class EmailMerchant
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

    public function sendNotifProcessTransfer($emailTo, $merchant = null)
    {
        $email = '';
        $email .= '<h3>Bapak/Ibu Yth.</h3><br/>'.
                  '<p>Proses Settlement anda sudah diproses,'.
                  ' mohon periksa kliring Nomor Rekening anda. '.
                  '</p>';

        $insert = array(
            'idmailer' => null,
            'mailer_module' => 'Proses Settlement Transfer',
            'mailer_from' => $this->from,
            'mailer_to' => $emailTo,
            'mailer_subject' => 'Proses Settlement - Transfer',
            'mailer_message' => $email,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s'),
        );

        $this->dbLibrary->insert('mailer', $insert);

        return (int) $this->dbLibrary->insert_id();
    }
}
