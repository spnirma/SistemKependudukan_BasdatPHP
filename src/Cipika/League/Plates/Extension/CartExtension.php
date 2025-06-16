<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class CartExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getCart', [$this, 'getCart']);
        $engine->registerFunction('cartGetMerchant', [$this, 'cartGetMerchant']);
        $engine->registerFunction('cartGetDetailPaket', [$this, 'cartGetDetailPaket']);
        $engine->registerFunction('cartGetOrderItem', [$this, 'cartGetOrderItem']);
        $engine->registerFunction('totalHarga', [$this, 'totalHarga']);
    }

    public function getCart()
    {
        $CI =& get_instance();
        $cart = $CI->cart;

        return $cart;
    }
    
    public function cartGetMerchant($key)
    {
        $CI =& get_instance();
        $get_merchant = $CI->cart_m->get_merchant($key);
        return $get_merchant;
    }
    
    public function cartGetDetailPaket($id_produk)
    {
        $CI =& get_instance();
        $detail = $CI->cart_m->getDetailPaketByIdProduk($id_produk);
        return $detail;
    }
    
    public function cartGetOrderItem($md5_id_order)
    {
        $CI =& get_instance();
        $orderItem = $CI->cart_m->get_order_item($md5_id_order);
        return $orderItem;
    }
    
    public function totalHarga()
    {
        $CI =& get_instance();
        return $CI->cart_m->totalHarga();
        
    }
}
