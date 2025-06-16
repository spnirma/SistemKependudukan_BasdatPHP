<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class PartnerExtention implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('countProdukModerasiMerchant', [$this, 'countProdukModerasiMerchant']);
        $engine->registerFunction('countProdukVerifiedMerchant', [$this, 'countProdukVerifiedMerchant']);
        $engine->registerFunction('countProdukUnverifiedMerchant', [$this, 'countProdukUnverifiedMerchant']);
    }

    public function countProdukModerasiMerchant($id_user)
    {
        $CI =& get_instance();
        $produk_m = $CI->produk_m;
        return $produk_m->count_product_moderasi_merchant($id_user);
    }
    
    public function countProdukVerifiedMerchant($id_user)
    {
        $CI =& get_instance();
        $produk_m = $CI->produk_m;
        return $produk_m->count_product_verified_merchant($id_user);
    }
    
    public function countProdukUnverifiedMerchant($id_user)
    {
        $CI =& get_instance();
        $produk_m = $CI->produk_m;
        return $produk_m->count_product_unverified_merchant($id_user);
    }

}
