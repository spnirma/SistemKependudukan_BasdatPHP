<?php

namespace Cipika\Common;

class VoucherRewardLibrary {

    protected $dbLib;
    protected $eventName = null;

    public function __construct($db) {
        $this->dbLib = $db;
    }

    public function getData($idEvent) {
        $today = date("Y-m-d");

        $sql = "select vr.*, pm.nama from tbl_email_blast_voucher_reward vr join " .
                "tbl_program_promo pm on vr.id_program_promo = pm.id_program_promo " .
                "where vr.periode_start <= '" . $today . "' and vr.periode_end >= '" . $today . "' and vr.id_email_blast_event = " . (int) $idEvent . ";";
        $q = $this->dbLib->query($sql);
        $data = $q->row_object();

        return $data;
    }

    public function cekLogEventUser($idEvent, $idUser) {
        $this->dbLib->where('id_email_blast_voucher_reward',$idEvent);
        $this->dbLib->where('id_user',$idUser);
        $query = $this->dbLib->get('tbl_email_blast_voucher_reward_log');
        // return $this->dbLib->last_query();
        return $query->row();
    }

    public function cekLogEventUserPhone($idEvent, $userPhone) {
        $this->dbLib->where('id_email_blast_voucher_reward',$idEvent);
        $this->dbLib->where('user_phone',$userPhone);
        $query = $this->dbLib->get('tbl_email_blast_voucher_reward_log');
        return $query->row();
    }

    public function countData($idProgram) {
        $sql = "SELECT * FROM tbl_voucher where id_program_promo = " . (int) $idProgram . ";";
        $q = $this->dbLib->query($sql);
        $data = $q->num_rows();
        return $data;
    }

    public function checkVoucher($kodeVoucher) {
        $sql = "SELECT * FROM tbl_voucher where kode_voucher = '" . $this->dbLib->escape_str($kodeVoucher) . "';";
        $q = $this->dbLib->query($sql);
        $data = $q->row_object();
        return $data;
    }

    public function insertVoucher($data) {
        $insertId = $this->dbLib->insert('tbl_voucher', $data);
        return $insertId;
    }

    public function insertVoucherRewardLog($data) {
        $insertId = $this->dbLib->insert('tbl_email_blast_voucher_reward_log', $data);
        return $insertId;
    }

    public function insertEmailVoucherReward($data) {
        $insertId = $this->dbLib->insert('mailer', $data);
        return $insertId;
    }

}
