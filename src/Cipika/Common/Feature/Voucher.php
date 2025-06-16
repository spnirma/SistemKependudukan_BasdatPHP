<?php

namespace Cipika\Common\Feature;

use Cipika\Common\Feature\Feature;

class Voucher implements Feature {

    private $params;
    private $data;
    private $config;
    private $constants;
    private $enable;
    private $balance;

    public function calc() {
        $this->balance = 0;
        if (!empty($this->params)) {
            if (($this->params->nominal == 0) && $this->params->diskon_voucher != 0) {
                $this->params->nominal = ($this->data->totalBayar * $this->params->diskon_voucher) / 100;
            }
            if ($this->params->pemotongan == 1) {
                if ((int) $this->data->totalProduk > (int) $this->params->nominal) {
                    $this->balance = $this->data->totalProduk - $this->params->nominal;
                    $respond = (object) array(
                                'status' => 21,
                                'row' => 1,
                                'data' => (object) array(
                                    'totalProduk' => $this->data->totalProduk,
                                    'totalOngkir' => $this->data->totalOngkir,
                                    'totalPotonganVoucher' => $this->params->nominal,
                                    'totalBayar' => $this->balance +
                                                    $this->data->totalOngkir,
                                ),
                    );
                } elseif ((int) $this->data->totalProduk < (int) $this->params->nominal) {
                    $this->balance = $this->params->nominal - $this->data->totalProduk;
                    $respond = (object) array(
                                'status' => 22,
                                'row' => 2,
                                'data' => (object) array(
                                    'totalProduk' => $this->data->totalProduk,
                                    'totalOngkir' => $this->data->totalOngkir,
                                    'totalPotonganVoucher' => $this->data->totalProduk,
                                    'totalBayar' => $this->data->totalOngkir,
                                ),
                    );
                } elseif ((int) $this->data->totalProduk == (int) $this->params->nominal) {
                    $respond = (object) array(
                                'status' => 23,
                                'row' => 3,
                                'data' => (object) array(
                                    'totalProduk' => $this->data->totalProduk,
                                    'totalOngkir' => $this->data->totalOngkir,
                                    'totalPotonganVoucher' => $this->data->totalProduk,
                                    'totalBayar' => $this->data->totalOngkir,
                                ),
                    );
                }
            } elseif ($this->params->pemotongan == 2) {
                if ((int) $this->data->totalOngkir > (int) $this->params->nominal) {
                    $this->balance = $this->data->totalOngkir - $this->params->nominal;
                    $respond = (object) array(
                                'status' => 2,
                                'row' => 4,
                                'data' => (object) array(
                                    'totalProduk' => $this->data->totalProduk,
                                    'totalOngkir' => $this->data->totalOngkir,
                                    'totalPotonganVoucher' => $this->balance,
                                    'totalBayar' => $this->balance +
                                                    $this->data->totalProduk,
                                ),
                    );
                } elseif ((int) $this->data->totalOngkir < (int) $this->params->nominal) {
                    $this->balance = $this->params->nominal - $this->data->totalOngkir;
                    $respond = (object) array(
                                'status' => 2,
                                'row' => 5,
                                'data' => (object) array(
                                    'totalProduk' => $this->data->totalProduk,
                                    'totalOngkir' => $this->data->totalOngkir,
                                    'totalPotonganVoucher' => $this->data->totalOngkir,
                                    'totalBayar' => $this->data->totalProduk,
                                ),
                    );
                } elseif ((int) $this->data->totalOngkir == (int) $this->params->nominal) {
                    $respond = (object) array(
                                'status' => 2,
                                'row' => 6,
                                'data' => (object) array(
                                    'totalProduk' => $this->data->totalProduk,
                                    'totalOngkir' => $this->data->totalOngkir,
                                    'totalPotonganVoucher' => $this->data->totalOngkir,
                                    'totalBayar' => $this->data->totalProduk,
                                ),
                    );
                }
            } elseif ($this->params->pemotongan == null) {
                $this->balance = $this->data->totalProduk + $this->data->totalOngkir;
                if ($this->balance > $this->params->nominal) {
                    $this->balance -= $this->params->nominal;
                    $respond = (object) array(
                                'status' => 2,
                                'row' => 7,
                                'data' => (object) array(
                                    'totalProduk' => $this->data->totalProduk,
                                    'totalOngkir' => $this->data->totalOngkir,
                                    'totalPotonganVoucher' => $this->params->nominal,
                                    'totalBayar' => $this->balance,
                                ),
                    );
                } elseif ($this->balance < $this->params->nominal) {
                    $this->balance = $this->params->nominal - $this->balance;
                    $respond = (object) array(
                                'status' => 1,
                                'row' => 8,
                                'data' => (object) array(
                                    'totalProduk' => $this->data->totalProduk,
                                    'totalOngkir' => $this->data->totalOngkir,
                                    'totalPotonganVoucher' => $this->data->totalProduk + 
                                                              $this->data->totalOngkir,
                                    'totalBayar' => 0,
                                ),
                    );
                } elseif ($this->balance == $this->params->nominal) {
                    $this->balance = $this->params->nominal - $this->balance;
                    $respond = (object) array(
                                'status' => 1,
                                'row' => 9,
                                'data' => (object) array(
                                    'totalProduk' => $this->data->totalProduk,
                                    'totalOngkir' => $this->data->totalOngkir,
                                    'totalPotonganVoucher' => $this->params->nominal,
                                    'totalBayar' => $this->balance,
                                ),
                    );
                }
            }
            if ($this->params->max_potongan > 0
                && $this->params->diskon_voucher > 0
            ) {
                if ($respond->data->totalBayar > $this->params->max_potongan
                    && $respond->data->totalBayar <= $respond->data->totalPotonganVoucher
                ) {
                    $respond->data->totalBayar = ($respond->data->totalBayar +
                        $respond->data->totalPotonganVoucher) - $this->params->max_potongan;

                    $respond->data->totalPotonganVoucher = $this->params->max_potongan;
                }
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
