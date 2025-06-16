<?php

namespace Cipika\Common; 

class CheckoutValidation
{

    public function check($params)
    {
        $respondValidation = array();
        $respondValidationMessage = null;

        $isError = false;
        /* Check Validation Store */
        if ($params['item']['total_bayar'] < $params['config']['minimal_order']) {
            $respondValidationMessage = "Maaf, untuk total pembelian produk anda kurang dari Rp " . 
                                        number_format($params['config']['minimal_order'], 0, ",", ".");
            return (object) array (
                'status_validation'         => 0,
                'status_validation_message' => $respondValidationMessage,
            );
        }
        
        if (!is_null($params['feature']['voucher']['detail'])) {
            if ($params['feature']['voucher']['detail']->data->totalBayar < 
                $params['config']['MINIMAL_OUTSTANDING_BALANCE'] &&
                $params['feature']['voucher']['detail']->data->totalBayar != 0 
            ) {
                $respondValidationMessage = "Total tagihan dalam transaksi Anda kurang dari Rp " .  
                                            number_format($params['config']['MINIMAL_OUTSTANDING_BALANCE'], 0, ",", ".") . 
                                            ", silahkan tambah item belanja Anda";
                return (object) array (
                    'status_validation'         => 0,
                    'status_validation_message' => $respondValidationMessage,
                );
            }
        }
            
        foreach ($params['cart'] as $kCart => $vCart)
        {
            /* Check Merchant Status */
            if (!$vCart['store']['status_store']) {
                $respondValidationMessage = "Merchant tidak melayani pembelian anda"; 
                return (object) array (
                    'status_validation'         => 0,
                    'status_validation_message' => $respondValidationMessage,
                );
            }

            if (!in_array($vCart['shipping']['id_ongkir'], $vCart['shipping']['list_id_ongkir'])) {
                return (object) array (
                    'status_validation'         => 0,
                    'status_validation_message' => "Id Ongkir tidak benar",
                );
            }

            foreach ($vCart['items'] as $itemCart => $itemValueCart)
            {
                /* Check Product Stok */
                $hitungStok = $itemValueCart['stok_produk'] - $itemValueCart['jumlah_produk'];
                if ($itemValueCart['stok_produk'] == 0 || 
                    $itemValueCart['publish'] != 1 || 
                    $itemValueCart['deleted'] == 1)
                {
                    $respondValidationMessage = "Produk '" . $itemValueCart['nama_produk'] . 
                                                "' saat ini tidak tersedia di etalase Cipika Store";

                    return (object) array (
                        'status_validation'         => 0,
                        'status_validation_message' => $respondValidationMessage,
                    );
                } elseif ($hitungStok < 0) {
                    $respondValidationMessage = "Stok Produk '" . $itemValueCart['nama_produk'] . 
                                                "' tidak memenuhi kuantiti pembelian Anda";
                    return (object) array (
                        'status_validation'         => 0,
                        'status_validation_message' => $respondValidationMessage,
                    );
                }

            }
        }
        if ($params['feature']['product_software']['status']) {
            $totalItemProduct = $params['item']['total_item_produk'] - $params['feature']['product_software']['total_produk'];
            if ($params['feature']['product_software']['total_produk'] > 0 && 
                $totalItemProduct > 1)
            { 
                return (object) array (
                    'status_validation'         => 0,
                    'status_validation_message' => "Maaf, pembelian produk software tidak dapat " .
                                                    "dilakukan bersamaan dengan produk lain.", 
                );
            }
            if ($params['feature']['product_software']['total_jumlah_produk'] > 1) {
                return (object) array (
                    'status_validation'         => 0,
                    'status_validation_message' => "Maaf, pembelian produk software hanya dapat " .
                                                   "dilakukan dengan 1 item produk", 
                );
            }
        }
        if ($params['feature']['product_voucher_reload']['status']) {
            if ($params['feature']['product_voucher_reload']['total_produk'] > 1) {
                return (object) array (
                    'status_validation'         => 0,
                    'status_validation_message' => 'Pembelian produk voucher pulsa hanya bisa ' . 
                                                   'dilakukan dengan 1 item produk', 
                );
            }
            if ($params['feature']['product_voucher_reload']['total_jumlah_produk'] > 1) {
                return (object) array (
                    'status_validation'         => 0,
                    'status_validation_message' => 'Produk voucher pulsa hanya boleh dibeli 1x dalam 1 hari.', 
                );
            }
        }
        if ($params['feature']['product_cicilan']['status']) {
            $totalItemProduct = $params['item']['total_item_produk'] -
                $params['feature']['product_cicilan']['total_produk'];
            if ($params['feature']['product_cicilan']['total_produk'] > 0 &&
                $totalItemProduct > 0)
            {
                return (object) array (
                    'status_validation'         => 0,
                    'status_validation_message' => "Maaf, pembelian produk cicilan tidak dapat " .
                                                    "dilakukan bersamaan dengan produk lain.",
                );
            }
            if ($params['feature']['product_cicilan']['total_jumlah_produk'] > 1) {
                return (object) array (
                    'status_validation'         => 0,
                    'status_validation_message' => 'Produk cicilan hanya boleh dibeli 1 item.',
                );
            }
        }

        return (object) array (
            'status_validation'         => 1,
            'status_validation_message' => "Berhasil",
        );
    }
}
