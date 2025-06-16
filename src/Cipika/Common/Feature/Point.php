<?php

namespace Cipika\Common\Feature;

use Cipika\Common\Feature\Feature;

class Point implements Feature {

    private $params;
    private $data;
    private $config;
    private $constants;
    private $enable;
    private $balance;
    private $totalPointRupiah;
    private $tmpTotalBayar;

    public function calc() {
        $this->balance = 0;
        $this->totalPointRupiah = $this->params * $this->config->POINT_REWARDS_RUPIAH;
        $this->tmpTotalBayar = ($this->data->totalProduk +
                                $this->data->totalOngkir) -
                                $this->data->totalPotonganVoucher;
        if (!empty($this->params)) {
            if ($this->tmpTotalBayar > $this->totalPointRupiah) {
                $this->balance = $this->tmpTotalBayar - $this->totalPointRupiah;
                $respond = (object) array(
                            'status' => 30,
                            'row' => 1,
                            'data' => (object) array(
                                'totalProduk' => $this->data->totalProduk,
                                'totalOngkir' => $this->data->totalOngkir,
                                'totalPotonganVoucher' => $this->data->totalPotonganVoucher,
                                'totalPotonganPointRupiah' => $this->totalPointRupiah,
                                'totalPotonganPoint' => (int) $this->params,
                                'totalBayar' => $this->balance,
                            ),
                );
            } elseif ($this->tmpTotalBayar < $this->totalPointRupiah) {
                $totalPotonganRupiah = $this->tmpTotalBayar / $this->config->POINT_REWARDS_RUPIAH;
                $respond = (object) array(
                            'status' => 1,
                            'row' => 2,
                            'data' => (object) array(
                                'totalProduk' => $this->data->totalProduk,
                                'totalOngkir' => $this->data->totalOngkir,
                                'totalPotonganVoucher' => $this->data->totalPotonganVoucher,
                                'totalPotonganPointRupiah' => $this->tmpTotalBayar,
                                'totalPotonganPoint' => (int) $totalPotonganRupiah,
                                'totalBayar' => $this->balance,
                            ),
                );
            } elseif ($this->tmpTotalBayar == $this->totalPointRupiah) {
                $totalPotonganRupiah = $this->tmpTotalBayar / $this->config->POINT_REWARDS_RUPIAH;
                $respond = (object) array(
                            'status' => 1,
                            'row' => 3,
                            'data' => (object) array(
                                'totalProduk' => $this->data->totalProduk,
                                'totalOngkir' => $this->data->totalOngkir,
                                'totalPotonganVoucher' => $this->data->totalPotonganVoucher,
                                'totalPotonganPointRupiah' => $this->totalPointRupiah,
                                'totalPotonganPoint' => (int) $totalPotonganRupiah,
                                'totalBayar' => $this->balance,
                            ),
                );
            }
            if ($respond->data->totalBayar < $this->config->MINIMAL_OUTSTANDING_BALANCE && $respond->data->totalBayar != 0) {
                $respond->status = 0;
            }
            return $respond;
        } else {
            return (object) array('status' => false, 'balance' => $this->balance);
        }
    }

    public function getParams() {
        return $this->params;
    }

    public function setParams($params) {
        $this->params = $params;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($params) {
        $this->data = $params;
    }

    public function getConfig() {
        return $this->config;
    }

    public function setConfig($params) {
        $this->config = $params;
    }

    public function getConstants() {
        return $this->constants;
    }

    public function setConstants($params) {
        $this->constants = $params;
    }

}
