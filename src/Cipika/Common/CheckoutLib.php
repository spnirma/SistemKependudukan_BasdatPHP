<?php

namespace Cipika\Common; use Cipika\View\Helper\GenerateInvoice;

class CheckoutLib
{
    protected $dbLibrary;

    public function __construct($dbLib)
    {
        $this->dbLibrary = $dbLib;
    }

    public function generateNewKodeInvoice()
    {
        $this->dbLibrary->trans_begin();

        $sqlSequence = "SELECT * FROM tbl_sequence WHERE name ='kode_invoice' and year = '" . date('y') . "' and " .
                " month = '" . date('m') . "' and day = '" . date('d') . "' FOR UPDATE;";
        $query = $this->dbLibrary->query($sqlSequence);
        $rowRespond = $query->row();

        if (empty($rowRespond)) {
            $key = date('ymd');
            $id = $this->_get_new_id_invoice($key);
            $id_new = (int) $id->jumlah;
            $id_new++;

            $sql = "INSERT INTO `tbl_sequence` (`id_sequence` ,`name` ";
            $sql .= ",`year` ,`month`, `day`, `value` )VALUES (NULL ,";
            $sql .= " 'kode_invoice','" . date('y') . "','" . date('m') . "','" . date('d') . "'," . $id_new . ");";
            $q = $this->dbLibrary->query($sql);

            $sqlSequence = "SELECT * FROM tbl_sequence WHERE name ='kode_invoice' and year = '" . date('y') . "' and " .
                    " month = '" . date('m') . "' and day = '" . date('d') . "' FOR UPDATE;";
            $query = $this->dbLibrary->query($sqlSequence);
            $rowRespond = $query->row();
        }

        $newDateInvoice = $rowRespond->year . "-" . $rowRespond->month . "-" . $rowRespond->day;
        $date = new \DateTime($newDateInvoice);
        $prefixDateInvoice = $date->format('ymd');

        $generateInvoice = new \Cipika\View\Helper\GenerateInvoice(5);
        $respondGenerateInvoice = $generateInvoice->generateNewKodeInvoice($prefixDateInvoice, $rowRespond->value);

        $sqlUpdateSeq = "UPDATE `tbl_sequence` set value = value + 1, last_modified = '" . date("Y-m-d H:i:s") . "' ";
        $sqlUpdateSeq .= " where id_sequence = " . $rowRespond->id_sequence . ";";
        $q = $this->dbLibrary->query($sqlUpdateSeq);

        $invoices = $respondGenerateInvoice . "_" . date("dmyHis");

        if ($this->dbLibrary->trans_status() === FALSE) {
            $this->dbLibrary->trans_rollback();
        } else {
            $this->dbLibrary->trans_commit();
        }

        $this->dbLibrary->trans_complete();

        return $invoices;
    }

    public function generateNewKodeOrder($prefix)
    {
        $prefixKodeOrder = $prefix;
        $this->dbLibrary->trans_begin();

        $sqlSequence = "SELECT * FROM tbl_sequence WHERE name ='kode_order' and year = '" . date('y') . "' and " .
                " month = '" . date('m') . "' and day = '" . date('d') . "' FOR UPDATE;";
        $query = $this->dbLibrary->query($sqlSequence);
        $rowRespondOrder = $query->row();

        //Jika Sequence nya belum ada langsung di insert baru dengan value 1
        if (empty($rowRespondOrder)) {
            $key = $prefixKodeOrder . date('ymd');
            $id = $this->_get_new_index_order($key);
            $id_new = $id;
            $id_new++;

            $sql = "INSERT INTO `tbl_sequence` (`id_sequence` ,`name` ";
            $sql .= ",`year` ,`month`, `day`, `value` )VALUES (NULL ,";
            $sql .= " 'kode_order','" . date('y') . "','" . date('m') . "','" . date('d') . "'," . $id_new . ");";
            $q = $this->dbLibrary->query($sql);

            $sqlSequence = "SELECT * FROM tbl_sequence WHERE name ='kode_order' and year = '" . date('y') . "' and " .
                    " month = '" . date('m') . "' and day = '" . date('d') . "' FOR UPDATE;";
            $query = $this->dbLibrary->query($sqlSequence);
            $rowRespondOrder = $query->row();
        }

        $newDateOrder = $rowRespondOrder->year . "-" . $rowRespondOrder->month . "-" . $rowRespondOrder->day;
        $dateNewOrder = new \DateTime($newDateOrder);
        $prefixDateOrder = $dateNewOrder->format('ymd');

        $generateOrder = new \Cipika\View\Helper\GenerateOrder(5, $prefixKodeOrder);
        $respondGenerateOrder = $generateOrder->generateNewKodeOrder($prefixDateOrder, $rowRespondOrder->value);

        $sqlUpdateSeqOrder = "UPDATE `tbl_sequence` set value = value + 1, last_modified = '" . date("Y-m-d H:i:s") . "' ";
        $sqlUpdateSeqOrder .= " where id_sequence = " . $rowRespondOrder->id_sequence . ";";
        $q = $this->dbLibrary->query($sqlUpdateSeqOrder);
        $kode_order = $respondGenerateOrder;

        if ($this->dbLibrary->trans_status() === FALSE) {
            $this->dbLibrary->trans_rollback();
        } else {
            $this->dbLibrary->trans_commit();
        }

        $this->dbLibrary->trans_complete();
        
        return $kode_order;
    }

    function _get_new_id_order($key = '')
    {
        $index = 1; 
        $length = strlen($key);
           
        $sql = "select count(*) as jumlah from tbl_order where ".
               "(select left(kode_order, $length))='" . 
                $this->dbLibrary->escape_str($key) . "'";
        $query = $this->dbLibrary->query($sql);
        $data = $query->row();
        $query->free_result();

        $id_news = (int) $data->jumlah;
        $id_news += $index;
        $id_news = 10000 + $id_news;
        $kode_order = strtoupper($key . '-' . substr($id_news, 1, 4));
        return $kode_order;
    }

    function _get_new_id_invoice($key='')
    {
        $length = strlen($key);

        $sql = "select count(*) as jumlah from tbl_invoices where " . 
               "(select left(kode_invoice, $length))='" . 
                $this->dbLibrary->escape_str($key) . "'";
        $q = $this->dbLibrary->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data;
    }
    
    function _get_new_index_order($key='')
    {

        $length = strlen($key);

        $sql = "select kode_order from tbl_order where kode_order like '" . 
                $this->dbLibrary->escape_str($key) . "%' order by id_order desc " . 
                "limit 0, 1;";
        $q = $this->dbLibrary->query($sql);
        $data = $q->row();
        $q->free_result();
        if (isset($data->kode_order)){
            $exp = explode("-", $data->kode_order);
            return (int) $exp[1];
        } else {
            return 0;
        }
    }

    public function generateNewTransIdVoucherReload()
    {
        $this->dbLibrary->trans_begin();

        $sqlSequence = "SELECT * FROM tbl_sequence WHERE name ='trans_id_voucher_reload' and year = '" . date('y') . "' and " .
                " month = '" . date('m') . "' and day = '" . date('d') . "' FOR UPDATE;";
        $query = $this->dbLibrary->query($sqlSequence);
        $rowRespond = $query->row();

        // Jika Sequence nya belum ada langsung di insert baru dengan value 1
        if (empty($rowRespond)) {
            $id_new = 1;

            $sql = "INSERT INTO `tbl_sequence` (`id_sequence` ,`name` ";
            $sql .= ",`year` ,`month`, `day`, `value` )VALUES (NULL ,";
            $sql .= " 'trans_id_voucher_reload','" . date('y') . "','" . date('m') . "','" . date('d') . "'," . $id_new . ");";
            $q = $this->dbLibrary->query($sql);

            $sqlSequence = "SELECT * FROM tbl_sequence WHERE name ='trans_id_voucher_reload' and year = '" . date('y') . "' and " .
                    " month = '" . date('m') . "' and day = '" . date('d') . "' FOR UPDATE;";
            $query = $this->dbLibrary->query($sqlSequence);
            $rowRespond = $query->row();
        }
        $respondTransIdVoucher = $this->_generate_trans_id_voucher_reload($rowRespond);

        $sqlUpdateSeq = "UPDATE `tbl_sequence` set value = value + 1, last_modified = '" . date("Y-m-d H:i:s") . "' ";
        $sqlUpdateSeq .= " where id_sequence = " . $rowRespond->id_sequence . ";";
        $q = $this->dbLibrary->query($sqlUpdateSeq);

        if ($this->dbLibrary->trans_status() === FALSE) {
            $this->dbLibrary->trans_rollback();
        } else {
            $this->dbLibrary->trans_commit();
        }
        $this->dbLibrary->trans_complete();

        return $respondTransIdVoucher;
    }

    private function _generate_trans_id_voucher_reload($dataSequence, $max = 5)
    {
        $dateInvoice = $dataSequence->year . "" . $dataSequence->month . "" . $dataSequence->day;
        $max = 5;
        $indexKodeInvoice = $dataSequence->value;
        $countValue = strlen($dataSequence->value);
        $index = str_repeat("0", (int) $max - (int) $countValue);
        $kodeInvoice = $dateInvoice . "" . $index . $indexKodeInvoice;
        return $kodeInvoice;
    }

    public function generateNewUnixNumberMandiriClickPay()
    {
        $this->dbLibrary->trans_begin();

        $sqlSequence = "SELECT * FROM tbl_sequence WHERE name ='unix_number_mandiri_click_pay' and year = '" . date('y') . "' and " .
                " month = '" . date('m') . "' and day = '" . date('d') . "' FOR UPDATE;";
        $query = $this->dbLibrary->query($sqlSequence);
        $rowRespond = $query->row();

        // Jika Sequence nya belum ada langsung di insert baru dengan value 1
        if (empty($rowRespond)) {
            $id_new = 1;

            $sql = "INSERT INTO `tbl_sequence` (`id_sequence` ,`name` ";
            $sql .= ",`year` ,`month`, `day`, `value` )VALUES (NULL ,";
            $sql .= " 'unix_number_mandiri_click_pay','" . date('y') . "','" . date('m') . "','" . date('d') . "'," . $id_new . ");";
            $q = $this->dbLibrary->query($sql);

            $sqlSequence = "SELECT * FROM tbl_sequence WHERE name ='unix_number_mandiri_click_pay' and year = '" . date('y') . "' and " .
                    " month = '" . date('m') . "' and day = '" . date('d') . "' FOR UPDATE;";
            $query = $this->dbLibrary->query($sqlSequence);
            $rowRespond = $query->row();
        }
        $respondUnixNumberMandiriClickPay = $this->_generate_unix_number_mandiri_clickpay($rowRespond);

        $sqlUpdateSeq = "UPDATE `tbl_sequence` set value = value + 1, last_modified = '" . date("Y-m-d H:i:s") . "' ";
        $sqlUpdateSeq .= " where id_sequence = " . $rowRespond->id_sequence . ";";
        $q = $this->dbLibrary->query($sqlUpdateSeq);

        if ($this->dbLibrary->trans_status() === FALSE) {
            $this->dbLibrary->trans_rollback();
        } else {
            $this->dbLibrary->trans_commit();
        }
        $this->dbLibrary->trans_complete();

        return $respondUnixNumberMandiriClickPay;
    }

    private function _generate_unix_number_mandiri_clickpay($dataSequence, $max = 5)
    {
        $dateInvoice = $dataSequence->year . "" . $dataSequence->month . "" . $dataSequence->day;
        $max = 5;
        $indexKodeInvoice = $dataSequence->value; 
        $countValue = strlen($dataSequence->value);
        $index = str_repeat("0", (int) $max - (int) $countValue);
        $kodeInvoice = $dateInvoice . "" . $index . $indexKodeInvoice;
        return $kodeInvoice;
    }

}
