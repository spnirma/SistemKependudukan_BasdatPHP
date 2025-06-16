<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class ProductExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getSelectCategoryMerchant', [$this, 'getSelectCategoryMerchant']);
        $engine->registerFunction('getCategory', [$this, 'getCategory']);
        $engine->registerFunction('countProductVarianUser', [$this, 'countProductVarianUser']);
        $engine->registerFunction('getProductVarianUser', [$this, 'getProductVarianUser']);
        $engine->registerFunction('getListLogHargabyId', [$this, 'getListLogHargabyId']);
        $engine->registerFunction('getProduk', [$this, 'getProduk']);
    }

    public function getSelectCategoryMerchant($parentId = 0, $level = 0, $activeCategoryId = null, $produk_array, $channel = '')
    {
        $CI =& get_instance();
        $product = $CI->produk_m;
        return $product->get_select_category_merchant($parentId, $level, $activeCategoryId, $produk_array, $channel);
    }
    
    public function getCategory($id)
    {
        $CI =& get_instance();
        $product = $CI->produk_m;
        return $product->get_kategori($id);
    }
    
    public function countProductVarianUser($id)
    {
        $CI =& get_instance();
        $product = $CI->produk_m;
        return $product->count_produk_varian_user($id);
    }
    
    public function getProductVarianUser($id)
    {
        $CI =& get_instance();
        $product = $CI->produk_m;
        return $product->get_produk_varian_user($id);
    }
    
    public function getListLogHargabyId($id)
    {
        $CI =& get_instance();
        $product = $CI->produk_m;
        return $product->get_list_logharga_byid($id);
    }
    
    public function getProduk($id)
    {
        $CI =& get_instance();
        $product = $CI->produk_m;
        return $product->get_produk($id);
    }
}
