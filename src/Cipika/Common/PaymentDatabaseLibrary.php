<?php

namespace Cipika\Common;

class PaymentDatabaseLibrary {

    protected $dbLibrary;

    public function __construct($dbLib) {
        $this->dbLibrary = $dbLib;
    }

    public function checkIdPayment($id) {
//        $this->dbLibrary->where('keterangan', 'active');
        $this->dbLibrary->where('id_payment', (int) $id);
        $getPayment = $this->dbLibrary->get('tb_payment');
        if (!empty($getPayment->result_object())) {
            return $getPayment->result_object();
        }
        return false;
    }

    public function getAllPayment() {
        $this->dbLibrary->where('keterangan', 'active');
        $this->dbLibrary->order_by('display_index', 'asc');
        $this->dbLibrary->order_by('id_payment', 'asc');
        $getPayment = $this->dbLibrary->get('tb_payment');
        if (!empty($getPayment->result_object())) {
            return $getPayment->result_object();
        }
        return false;
    }

}
