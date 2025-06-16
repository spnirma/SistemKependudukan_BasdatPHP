<?php 
namespace Cipika\Common;

class PromoCek
{
	public function getPromoPrice($p,$produk_promo,$order_promo_quota,$order_promo_quota_per_day,$order_promo_day)
    {
        if ($p->diskon_rp > 0) {
            $harga_diskon = $p->harga_jual - $p->diskon_rp;
            $diskon = floor(($p->diskon_rp / ($p->harga_jual+0.00001)) * 100);
            $diskon_rp = $p->diskon_rp;
        } else {
            $diskon = $p->diskon;
            $diskon_rp = $p->harga_jual * $p->diskon / 100;
            $harga_diskon = $p->harga_jual-(($p->harga_jual+0.00001)*$p->diskon/100);
        }
        $cek_promo = FALSE;
        $stock_available = $p->stok_produk;
        $jenis_promo = '';
        $nama_promo = '';
        $id_promo = '';
        if ($p->stok_produk != 0) {
            foreach ($produk_promo as $data_promo){
                if($data_promo->id_produk == $p->id_produk){
                    $cek_promo = TRUE;
                    if(empty($order_promo_quota)){
                        $stock_available = $data_promo->max_item_per_day;
                    }
                    foreach($order_promo_quota as $data_promo_quota){
                        if($data_promo_quota->id_produk == $data_promo->id_produk && $data_promo_quota->jumlah >= $data_promo->quota){
                            $cek_promo = FALSE;
                        }else{
                            if ($stock_available >= $data_promo->quota) {
                                $stock_available = $data_promo->quota;
                            }
                            if(empty($order_promo_quota_per_day))
                            {
                                $stock_available = $data_promo->max_item_per_day;
                            }
                            foreach($order_promo_quota_per_day as $data_promo_quota_per_day){
                                if($data_promo_quota_per_day->id_produk == $data_promo->id_produk && $data_promo_quota_per_day->jumlah >= $data_promo->quota_per_day){
                                    $cek_promo = FALSE;
                                }else{
                                    if ($stock_available >= $data_promo->quota_per_day) {
                                        $stock_available = $data_promo->quota_per_day;
                                    }
                                    if(!empty($order_promo_day)){
                                        $cek_promo = TRUE;
                                        foreach($order_promo_day as $data_promo_day){
                                            if($data_promo_day->id_produk == $data_promo->id_produk && $data_promo_day->jumlah >= $data_promo->max_item_per_day){
                                               $cek_promo = FALSE;
                                               break;
                                            } else {
                                                if ($stock_available >= $data_promo->max_item_per_day) {
                                                    $stock_available = $data_promo->max_item_per_day - $data_promo_day->jumlah;
                                                }
                                            }
                                        }
                                    } else {
                                        $stock_available = $data_promo->max_item_per_day;
                                    }
                                }
                            }
                        }
                    }
                    if($cek_promo){
                        if ($data_promo->diskon_rp > 0) {
                            $harga_diskon = $p->harga_jual - $data_promo->diskon_rp;
                            $diskon_rp = $data_promo->diskon_rp;
                            $diskon = floor(($data_promo->diskon_rp / $p->harga_jual) * 100);
                        } else {
                            $diskon = $data_promo->diskon;
                            $diskon_rp = ($p->harga_jual * $diskon / 100);
                            $harga_diskon = $p->harga_jual - ($p->harga_jual* $diskon / 100);
                        }
                        $jenis_promo = 'promo_diskon';
                        $nama_promo = $data_promo->nama_program_diskon;
                        $id_promo = $data_promo->id_promo_marketing;
                    } else {
                        if ($p->diskon_rp > 0) {
                            $harga_diskon = $p->harga_jual - $p->diskon_rp;
                            $diskon_rp = $p->diskon_rp;
                            $diskon = floor(($p->diskon_rp / $p->harga_jual) * 100);
                        } else {
                            $diskon = $p->diskon;
                            $diskon_rp = $p->harga_jual * $diskon / 100;
                            $harga_diskon = $p->harga_jual - ($p->harga_jual* $diskon / 100);
                        }
                        $jenis_promo = '';
                        $nama_promo = '';
                        $id_promo = '';
                    }
                }
            }
            return array(
                'diskon' => $diskon,
                'diskon_rp' => $diskon_rp,
                'harga_diskon' => $harga_diskon,
                'harga_jual' => $p->harga_jual,
                'cek_promo' => $cek_promo,
                'stock_available' => $stock_available,
                'jenis_promo' => $jenis_promo,
                'nama_promo' => $nama_promo,
                'id_promo' => $id_promo
            );
        } else {
            return array(
                'diskon' => $diskon,
                'diskon_rp' => $diskon_rp,
                'harga_diskon' => $harga_diskon,
                'harga_jual' => $p->harga_jual,
                'cek_promo' => $cek_promo,
                'stock_available' => 0,
                'jenis_promo' => $jenis_promo,
                'nama_promo' => $nama_promo,
                'id_promo' => $id_promo
            );
        }
	}
}
