<?php 
namespace Cipika\Promo;

class ProdukPriceCalculatorMobo
{
    private $diskonKalkulator = array();
    
    public function addPriceListDiskonKalkulator($diskon_kalkulator)
    {
        $this->diskonKalkulator[] = $diskon_kalkulator;
    }
    
    public function getPriceList(array $produk)
    {
        $produk_price_list = array();
        foreach($produk as $key => $p){            
            $produk_price_list[]['produk'] = $p;
            $produk_price_list[$key]['is_promo'] = false;
            foreach($this->diskonKalkulator as $diskon_list){
                $price_diskon_list = $diskon_list->getPriceList($produk);
                foreach($price_diskon_list as $diskon){
                    if($diskon['is_promo'] === true && $diskon['produk']->id_produk == $p->id_produk){
                        $produk_price_list[$key]['diskon'] = $diskon['diskon'];
                        $produk_price_list[$key]['diskon_rp'] = $diskon['diskon_rp'];
                        $produk_price_list[$key]['harga_setelah_diskon'] = $diskon['harga_setelah_diskon'];
                        $produk_price_list[$key]['harga_jual'] = $diskon['harga_jual'];
                        $produk_price_list[$key]['is_promo'] = $diskon['is_promo'];
                        $produk_price_list[$key]['stock_available'] = $diskon['stock_available'];
                        $produk_price_list[$key]['jenis_promo'] = $diskon['jenis_promo'];
                        $produk_price_list[$key]['nama_promo'] = $diskon['nama_promo'];
                        $produk_price_list[$key]['id_promo'] = $diskon['id_promo'];
                    }
                }
            }
            if($produk_price_list[$key]['is_promo']===false)
            {
                if ($p->diskon_rp > 0) {
                    $produk_price_list[$key]['diskon'] = floor(($p->diskon_rp / $p->harga_jual) * 100);
                    $produk_price_list[$key]['diskon_rp'] = $p->diskon_rp;
                    $produk_price_list[$key]['harga_setelah_diskon'] = $p->harga_jual - $p->diskon_rp;
                } else {
                    $produk_price_list[$key]['diskon'] = $p->diskon;
                    $produk_price_list[$key]['diskon_rp'] = (($p->harga_jual * $p->diskon) / 100);
                    $produk_price_list[$key]['harga_setelah_diskon'] = $p->harga_jual * ((100-$p->diskon) / 100);
                }
                $produk_price_list[$key]['harga_jual'] = $p->harga_jual;
                $produk_price_list[$key]['stock_available'] = $p->stok_produk;
                $produk_price_list[$key]['jenis_promo'] = '';
                $produk_price_list[$key]['nama_promo'] = '';
                $produk_price_list[$key]['id_promo'] = '';
            }
        }
        
        return $produk_price_list;
    }
}
