<?php
namespace Cipika\Promo;

class PromoDailyDealsCalculator
{
	private $db;
	
	private $session;
	
	public function __construct($db,$session)
	{
		$this->db = $db;
		$this->session = $session;
	}
	
	private function arrayidprod($produk)
	{
        $arrayidprod = array();
		foreach ($produk as $row){
            $arrayidprod[] = $row->id_produk;
        }
        return $arrayidprod;
	}
	
	private function get_produk_daily_deals($idarrayprod)
	{
		$this->db->where('tanggal',date("Y-m-d").' 00:00:00');
		$this->db->where_in($idarrayprod);
		$q = $this->db->get('tbl_promo_daily_deals');
		$data=$q->result();
		$q->free_result();
		return $data;
	}
	
	private function get_quota_day_daily_deals($idarrayprod)
	{
		$this->db->select('id_produk');
		$this->db->select('sum(qty) as jumlah');
		$this->db->where('date_added',date("Y-m-d".' 00:00:00'));
		$this->db->where_in($idarrayprod);
		$q = $this->db->get('tbl_order_promo_daily_deals');
		$data=$q->result();
		$q->free_result();
		return $data;
	}
	
	private function get_quota_day_daily_deals_user($idarrayprod)
	{
		$this->db->select('id_produk');
		$this->db->select('sum(qty) as jumlah');
		$this->db->where('date_added',date("Y-m-d".' 00:00:00'));
		$this->db->where('id_user',$this->session->userdata('member')->id_user);
		$this->db->where_in($idarrayprod);
		$q = $this->db->get('tbl_order_promo_daily_deals');
		$data=$q->result();
		$q->free_result();
		return $data;
	}
	
	private function dailyDealsCek($p,$produk_daily_deals,$order_daily_deals_day,$order_daily_deals_day_user)
	{
        if ($p->diskon_rp > 0) {
            $harga_diskon = $p->harga_jual - $p->diskon_rp;
            $diskon = floor(($p->diskon_rp / ($p->harga_jual+0.00001)) * 100);
            $diskon_rp = $p->diskon_rp;
        } else {
            $diskon = $p->diskon;
            $diskon_rp = $p->harga_jual * $p->diskon / 100;
            $harga_diskon = $p->harga_jual - (($p->harga_jual+0.00001) * $p->diskon / 100);
        }
        $cek_promo = FALSE;
        $stock_available = $p->stok_produk;
        $jenis_promo = '';
        $nama_promo = '';
        $id_promo = '';
        foreach($produk_daily_deals as $data_produk_daily_deals){
			if($data_produk_daily_deals->id_produk == $p->id_produk){
				$cek_promo = TRUE;
				foreach($order_daily_deals_day as $data_order_daily_deals_day){
					if($data_order_daily_deals_day->id_produk == $data_produk_daily_deals->id_produk && $data_order_daily_deals_day->jumlah >= $data_produk_daily_deals->quota_per_day){
						$cek_promo = FALSE;
					} else {
                        if($stock_available>=$data_produk_daily_deals->quota_per_day){
                            $stock_available = $data_produk_daily_deals->quota_per_day;
                        }
						if(!empty($order_daily_deals_day_user)){
							$cek_promo = TRUE;
							foreach($order_daily_deals_day_user as $data_order_daily_deals_day_user){
								if($data_order_daily_deals_day_user->id_produk == $data_produk_daily_deals->id_produk && $data_order_daily_deals_day_user->jumlah >= $data_produk_daily_deals->quota_per_day_user){
								   $cek_promo = FALSE;
								   break;
								} else {
                                    if ($stock_available >= ($data_produk_daily_deals->quota_per_day_user)) {
                                        $stock_available = $data_produk_daily_deals->quota_per_day_user;
                                    }
                                }
							}
						} else {
                            $stock_available = $data_produk_daily_deals->quota_per_day_user;
                        }
					}
				}
				if($cek_promo){
					$diskon = $data_produk_daily_deals->diskon;
                    $diskon_rp = $p->harga_jual * $diskon / 100;
					$harga_diskon = $p->harga_jual-($p->harga_jual*$diskon/100);
                    $jenis_promo = 'daily_deals';
                    $nama_promo = '';
                    $id_promo = $data_produk_daily_deals->id;
				} else {
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
	}
	
	public function getPriceList($produk)
	{
		$arrayidprod = $this->arrayidprod($produk);
		$produk_daily_deals = $this->get_produk_daily_deals($arrayidprod);
		$quota_day_daily_deals = $this->get_quota_day_daily_deals($arrayidprod);
		if($this->session->userdata('member')){
			$quota_day_daily_deals_user = $this->get_quota_day_daily_deals_user($arrayidprod, $this->session->userdata('member')->id_user);
		} else {
			$quota_day_daily_deals_user = '';
		}
		
        $productsDiskon = array();
		foreach($produk as $p)
		{
			$diskon_properties = $this->dailyDealsCek(
				$p,
				$produk_daily_deals,
				$quota_day_daily_deals,
				$quota_day_daily_deals_user
			);
			$productsDiskon[] = array(
				'produk' => $p,
				'diskon' => $diskon_properties['diskon'],
				'diskon_rp' => $diskon_properties['diskon_rp'],
				'harga_setelah_diskon' =>$diskon_properties['harga_diskon'],
				'harga_jual' =>$diskon_properties['harga_jual'],
				'is_promo' => $diskon_properties['cek_promo'],
                'stock_available' => $diskon_properties['stock_available'],
                'jenis_promo' => $diskon_properties['jenis_promo'],
                'nama_promo' => $diskon_properties['nama_promo'],
                'id_promo' => $diskon_properties['id_promo'],
			);
		}
		
		return $productsDiskon;
	}
}
