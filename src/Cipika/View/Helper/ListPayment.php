<?php

namespace Cipika\View\Helper;

class ListPayment 
{
    
    protected $configServer;
    protected $dbLibrary;
    protected $params;
    private $totalProduk;
    private $totalOngkir;
    private $totalBayar;
    private $totalPotonganVoucher;
    private $totalPotonganPoint;

    public function __construct($dbLib)
    {
        $this->dbLibrary = $dbLib;
    }
    
    public function checkIdPayment($id)
    {
        $this->dbLibrary->where('id_payment', (int) $id);
        $getPayment = $this->dbLibrary->get('tbl_payment');
        if (!empty($getPayment->result_object())) {
            return $getPayment->result_object();
        }
        return false;
    }
    
    public function getAllPayment()
    {
        $getPayment = $this->dbLibrary->get('tbl_payment');
        if (!empty($getPayment->result_object())) {
            return $getPayment->result_object();
        }
        return false;
    }

    private function _getDatabaseListPayment()
    {
        $getPayment = $this->dbLibrary->get('tbl_payment');
        return $getPayment->result_object();
    }

    private function getParams($params, $name, $respond)
    {
        if (isset($params[$name])) {
            return $params[$name];
        }
        return $respond;
    }

    public function setData($params = array(), $configServer = null)
    {
        $this->params = $params;
    
        $this->totalProduk = isset($params['totalProduk']) ? $params['totalProduk'] : 0;
        $this->totalOngkir = isset($params['totalOngkir']) ? $params['totalOngkir'] : 0;
        $this->totalBayar = isset($params['totalBayar']) ? $params['totalBayar'] : 0;
        $this->totalPotonganVoucher = isset($params['totalPotonganVoucher']) ? $params['totalPotonganVoucher'] : 0;
        $this->totalPotonganPoint = isset($params['totalPotonganPoint']) ? $params['totalPotonganPoint'] : 0;

        $this->configServer = $configServer;

        return true;
    }

    private function getRules($idPayment)
    {
        switch ($idPayment) {
            case 1:
                $output = true;
                if ((int)$this->totalBayar < 0 || $this->totalBayar > 5000000) {
                    $output = false;
                }
                if ($this->totalPotonganVoucher > $this->totalBayar) {
                    $output = false;
                }
                return $output;
                break;
            case 5:
                $output = true;

                if ((int)$this->totalBayar > 1000000) {
                    $output = false;
                }
                $tmpTotalBayar = $this->totalBayar - $this->totalPotonganVoucher;
                if ($tmpTotalBayar < 0){
                    $output = false;
                }
                return $output;
                break;
            case 6:
                $output = true;

                if ((int)$this->totalBayar < 1000000 && (int) $this->totalBayar > 5000000) {
                    $output = false;
                }
                $tmpTotalBayar = $this->totalBayar - $this->totalPotonganVoucher;
                if ($tmpTotalBayar < 0){
                    $output = false;
                }
                return $output;
                break;
            case 7:
                $output = true;
                $tmpTotalBayar = $this->totalBayar - $this->totalPotonganVoucher;
                if ($tmpTotalBayar < 0){
                    $output = false;
                }
                return $output;
            case 8:
                $output = true;
                $tmpTotalBayar = $this->totalBayar - $this->totalPotonganVoucher;
                if ($tmpTotalBayar < 0){
                    $output = false;
                }
                return $output;
            case 9:
                $output = true;
                if ($this->totalPotonganVoucher > $this->totalBayar) {
                    $output = false;
                }
                return $output;
            case 10:
                $output = true;
                if ($this->totalPotonganVoucher > $this->totalBayar) {
                    $output = false;
                }
                return $output;
            case 11:
                $output = true;
                $tmpTotalBayar = $this->totalBayar - $this->totalPotonganVoucher;
                if ($tmpTotalBayar > 0){
                    $output = false;
                }
                if ((int)$this->totalBayar > (int)$this->totalPotonganVoucher) {
                    $output = false;
                }

                return $output;
                break;
             case 12:
                $output = true;
                if ($this->totalPotonganVoucher > $this->totalBayar) {
                    $output = false;
                }
                return $output;
             case 13:
                $output = true;
                if ($this->totalPotonganVoucher > $this->totalBayar) {
                    $output = false;
                }
                return $output;
             case 14:
                $output = true;
                if ($this->totalPotonganVoucher > $this->totalBayar) {
                    $output = false;
                }
                return $output;
        }
        return false;
    }

    public function getPayment()
    {
        $getListPayment = $this->_getDatabaseListPayment(); 

        $listPayment = array();
        $stringShowPayment = "SHOW_PAYMENT_";
        foreach ($getListPayment as $k => $v) {
            $constantPayment = strtoupper(str_replace(" ",  "_", trim($v->nama_payment)));
            $constantShowPayment = $stringShowPayment . $constantPayment;
            $showPayment = false;
            if (property_exists((object)$this->configServer, $constantShowPayment)) {
                $showPayment = $this->configServer[$constantShowPayment];
            } else {
                $showPayment = true;
            }

            if ($this->getRules($v->id_payment) && $showPayment) {
                $listPayment[] = (object)array(
                    'id' => $v->id_payment,
                    'payment' => $v->nama_payment,
                    'status' => $this->getRules($v->id_payment),
                );
            }
        }
        return $listPayment;
    }

}
