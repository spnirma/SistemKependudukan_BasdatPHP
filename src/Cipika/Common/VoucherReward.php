<?php

namespace Cipika\Common;

class VoucherReward {

    protected $dataVoucherReward;
    protected $countData;
    protected $readySend = false;
    protected $dataLib;
    protected $dataUser;
    protected $config;
    protected $resultvoucher;

    public function __construct($data, $config) {
        $this->dataVoucherReward = $data;
        $this->config = $config;
    }

    public function setData($countData) {
        $this->countData = $countData;
    }

    public function setDataLib($dataLib) {
        $this->dataLib = $dataLib;
    }

    public function setDataUser($dataUser) {
        $this->dataUser = $dataUser;
    }

    public function getNominalVoucher() {
        return $this->dataVoucherReward->nominal;
    }

    protected function setKodeVoucher()
    {
        $timeIntervalVoucher = $this->dataVoucherReward->masa_aktif;

        $intervalDateTime = new \Cipika\View\Helper\DateTimeIntervalString();
        $interval = $intervalDateTime->getInterval($timeIntervalVoucher, 1, "D");

        $nowDate = date('Y-m-d');
        $date = new \DateTime($nowDate);
        $dateExpiredVoucher = $date->add(new \DateInterval($interval));
        $expiredVoucher = $dateExpiredVoucher->format('Y-m-d');
        $kodeVoucherPrefix = $this->dataVoucherReward->kode_promo;

        $checkVoucher = true;
        while ($checkVoucher) {
            $codeVoucher = strtoupper(random_string('numeric', $this->config->item('LENGTH_CODE_VOUCHER')));
            $row = $this->dataLib->checkVoucher($kodeVoucherPrefix . $codeVoucher);

            $checkVoucher = !empty($row);
        }

        $resultvoucher = $kodeVoucherPrefix . $codeVoucher;

        $inputVoucher = array(
            'id_voucher' => null,
            'kode_voucher' => $resultvoucher,
            'promo' => $kodeVoucherPrefix,
            'id_program_promo' => $this->dataVoucherReward->id_program_promo,
            'date_start' => $nowDate,
            'max_pakai' => 1,
            'max_pakai_user' => (int) $this->dataVoucherReward->variable_pakai,
            'jenis_voucher' => 'single',
            'date_expired' => $expiredVoucher,
            'nominal' => $this->dataVoucherReward->nominal,
            'min_transaksi' => $this->dataVoucherReward->minimal_transaksi,
            'created_by' => 1,
            'date_added' => date('Y-m-d H:i:s'),
            'id_user' => (int) $this->dataUser->id_user,
        );
        $insertVoucher = $this->dataLib->insertVoucher($inputVoucher);

        $this->resultvoucher = $resultvoucher;
    }

    public function getKodeVoucher()
    {
        return $this->resultvoucher;
    }

    public function prepare() {
        if ($this->countData < $this->dataVoucherReward->jumlah_voucher) {
            $this->readySend = true;
            $this->setKodeVoucher();
        } else {
            $this->readySend = false;
        }
        return $this->readySend;
    }

    public function send() {
        $timeIntervalVoucher = $this->dataVoucherReward->masa_aktif;

        $intervalDateTime = new \Cipika\View\Helper\DateTimeIntervalString();
        $interval = $intervalDateTime->getInterval($timeIntervalVoucher, 1, "D");

        $nowDate = date('Y-m-d');
        $date = new \DateTime($nowDate);
        $dateExpiredVoucher = $date->add(new \DateInterval($interval));
        $expiredVoucherEmail = $dateExpiredVoucher->format('d F Y');

        $kodeVoucher = $this->getKodeVoucher();

        $listReplacment = array(
            '%nominal%' => number_format($this->dataVoucherReward->nominal, 0, '.', ','),
            '%nama_promo%' => $this->dataVoucherReward->nama,
            '%kode_voucher%' => $kodeVoucher,
            '%batas_bulan%' => $expiredVoucherEmail,
        );
        $template = $this->dataVoucherReward->template_wording;
        $template = $this->_replace_template_wording($template, $listReplacment);
        $data_email = '<strong>Member CipikaStore Yth,</strong><p>' . $template . '</p>';

        $inputVoucherLog = array(
            'id_email_blast_voucher_reward_log' => null,
            'id_email_blast_voucher_reward' => (int) $this->dataVoucherReward->id_email_blast_voucher_reward,
            'id_email_blast_event' => (int) $this->dataVoucherReward->id_email_blast_event,
            'email' => $this->dataUser->email,
            'id_user' => $this->dataUser->id_user,
            'user_phone' => $this->dataUser->hp,
            'pesan' => $template,
            'kode_voucher' => $kodeVoucher,
            'date_sent' => date('Y-m-d H:i:s'),
        );
        $insertVoucherLog = $this->dataLib->insertVoucherRewardLog($inputVoucherLog);

        $mailer = array('mailer_module' => 'Free Promo Voucher',
            'mailer_from' => $this->config->item('email_from'),
            'mailer_to' => $this->dataUser->email,
            'mailer_subject' => $this->dataVoucherReward->subject_email,
            'mailer_message' => $data_email,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s'),
        );

        $insertMailVoucherReward = $this->dataLib->insertEmailVoucherReward($mailer);
    }

    private function _replace_template_wording($string, $replaceText = array()) {
        $output = "";
        $output = $string;
        foreach ($replaceText as $key => $v) {
            $output = str_replace($key, $v, $output);
        }
        return $output;
    }

}
