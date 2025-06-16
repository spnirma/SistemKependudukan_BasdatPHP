<?php

namespace Cipika\Shipping;

class MerchantShipping
{
    public function isValidProductShipping($productName , $userShipping)
    {
        $produk = null;
        $checkKota = true;
        $part = null;
        if (stristr(strtolower($productName), 'pancake') && stristr(strtolower($productName), 'durian')) {
            $array_kota = array('jakarta', 'bandung', 'surabaya', 'lombok', 'yogyakarta', 'semarang', 'solo', 'bogor', 'depok', 'tangerang', 'bekasi');
            $array_propinsi = array();
            $produk = 1; 
            foreach ($array_kota as $destinasi_kota){
                if(stristr(strtolower($userShipping['kabupaten']), $destinasi_kota)){
                    $checkKota = true;
                }
            }

            if (!empty($array_propinsi)) {
                foreach ($array_propinsi as $destinasi_propinsi) {
                    if (stristr(strtolower($userShipping['propinsi']), $destinasi_propinsi)) {
                        $checkKota = true;
                    }
                }
            }
            $part = 1;
        } elseif ((stristr(strtolower($productName), 'lapis') && stristr(strtolower($productName), 'legit') && stristr(strtolower($productName), 'harum')) || (stristr(strtolower($productName), 'sale') && stristr(strtolower($productName), 'bali') && stristr(strtolower($productName), 'harum'))) {
            $array_kota = array('jakarta', 'bogor', 'depok', 'tangerang', 'bekasi', 'surabaya', 'bali');
            $array_propinsi = array('bali');
            $produk = 2;
            foreach ($array_kota as $destinasi_kota) {
                if (stristr(strtolower($userShipping['kabupaten']), $destinasi_kota)) {
                    $checkKota = true;
                }
            }
            if (!empty($array_propinsi)) {
                foreach ($array_propinsi as $destinasi_propinsi) {
                    if (stristr(strtolower($userShipping['propinsi']), $destinasi_propinsi)) {
                        $checkKota = true;
                    }
                }
            }
            $part = 2;
        } elseif (stristr(strtolower($productName), 'pempek') && stristr(strtolower($productName), 'bu') && stristr(strtolower($productName), 'linda')) {
            $array_kota = array('jakarta', 'bogor', 'depok', 'tangerang', 'bekasi');
            $array_propinsi = array();
            $produk = 3;
            foreach ($array_kota as $destinasi_kota) {
                if(stristr(strtolower($userShipping['kabupaten']), $destinasi_kota)){
                    $checkKota = true;
                }
            }
            if (!empty($array_propinsi)) {
                foreach ($array_propinsi as $destinasi_propinsi) {
                    if(stristr(strtolower($userShipping['propinsi']), $destinasi_propinsi)){
                        $checkKota = true;
                    }
                }
            }
            $part = 3;
        } 
        // open black list kota Cilacap dan Kab. Cilacap
//        elseif (in_array($userShipping['id_kota'], array(100, 561))) {
//            $checkKota = false;
//            $part = 4;
//        }
        return (object) array(
            'produk'    => $produk, 
            'checkKota' => $checkKota,
            'part'      => $part,
        );
    }
    
    /*
     * id_merchant == id_user on tbl_store
     */
    public function isValidMerchantShipping($id_merchant , $userShipping = null)
    {
        $CI =& get_instance();
        $produk = null;
        $checkKota = true;
        $part = null;
        $shipper = false;
        
        if (in_array($id_merchant, $CI->config->item('merchant_shipper'))) {
            $array_kota = array('jakarta', 'bogor', 'depok', 'tangerang', 'bekasi');
            $array_propinsi = array();
            foreach ($array_kota as $destinasi_kota) {
                if(stristr(strtolower($userShipping['kabupaten']), $destinasi_kota)){
                    $checkKota = true;
                }
            }
            if (!empty($array_propinsi)) {
                foreach ($array_propinsi as $destinasi_propinsi) {
                    if(stristr(strtolower($userShipping['propinsi']), $destinasi_propinsi)){
                        $checkKota = true;
                    }
                }
            }
            $part = 1;
            $shipper = true;
        }
        return (object) array(
            'produk'    => $produk, 
            'checkKota' => $checkKota,
            'part'      => $part,
            'shipper'   => $shipper
        );
    }

}
