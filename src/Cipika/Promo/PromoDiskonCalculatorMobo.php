<?php
namespace Cipika\Promo;

class PromoDiskonCalculatorMobo
{
	private $db;
	
	private $session;
	
	public function __construct($db,$session)
	{
		$this->db = $db;
		$this->session = $session;
	}

	private function get_produk_promo($idarrayprod){
		$now = new \DateTime();
		$nowdate = $now->format("Y-m-d");
		$nowtime = $now->format("H:i:s");
		$idarrayprod = implode(',', $idarrayprod);
		$sql = "SELECT p.* , pd.* FROM `tbl_promo_marketing` p left join `tbl_program_diskon` as pd on p.id_program_diskon = pd.id_program_diskon "
				. "WHERE (SELECT COUNT(*) FROM `tbl_promo_time` pt1 "
				. "WHERE pt1.id_promo_marketing = p.id_promo_marketing"
				. " AND pt1.time_start <= '$nowtime' and pt1.time_end >= '$nowtime') > 0"
				. " AND p.date_start <= '$nowdate' AND p.date_end >= '$nowdate'"
				. " AND p.id_produk in ($idarrayprod)";
		$q = $this->db->query($sql);
		$data=$q->result();
		$q->free_result();
		return $data;
    }
    
    private function get_order_promo_quota($idarrayprod){
		$now = new \DateTime();
		$nowdate = $now->format("Y-m-d");
		$nowtime = $now->format("H:i:s");
		$this->db->select('id_produk, SUM(qty) AS jumlah',FALSE);
		$this->db->group_by('id_produk');
		$this->db->where_in('id_produk', $idarrayprod);
		$q=$this->db->get('tbl_order_promo_marketing');
		$data=$q->result();
		$q->free_result();
		return $data;
	}
	
	private function get_order_promo_quota_per_day($idarrayprod){
		$now = new \DateTime();
		$nowdate = $now->format("Y-m-d");
		$nowtime = $now->format("H:i:s");
		$this->db->select('id_produk, SUM(qty) AS jumlah',FALSE);
		$this->db->group_by('id_produk');
		$this->db->where('date_added', $nowdate);
		$this->db->where_in('id_produk', $idarrayprod);
		$q=$this->db->get('tbl_order_promo_marketing');
		$data=$q->result();
		$q->free_result();
		return $data;
	}
	
	private function get_order_promo_day($idarrayprod, $id_user){
		$now = new \DateTime();
		$nowdate = $now->format("Y-m-d");
		$nowtime = $now->format("H:i:s");
		
		$this->db->select('id_produk, SUM(qty) AS jumlah',FALSE);
		$this->db->group_by('id_produk');
		$this->db->where('date_added', $nowdate);
		$this->db->where('id_user', (int)$id_user);
		$this->db->where_in('id_produk', $idarrayprod);
		$q=$this->db->get('tbl_order_promo_marketing');
		$data=$q->result();
		$q->free_result();
		return $data;
	}
	
	private function arrayidprod($produk)
	{
		foreach ($produk as $row){
            $arrayidprod[] = $row->id_produk;
        }
        
        return $arrayidprod;
	}
    
	public function getPriceList($produk)
	{
		$arrayidprod = $this->arrayidprod($produk);
		$produk_promo = ''; //$this->get_produk_promo($arrayidprod);
		$order_promo_quota = ''; //$this->get_order_promo_quota($arrayidprod);
		$order_promo_quota_per_day = ''; //$this->get_order_promo_quota_per_day($arrayidprod);
//		if($this->session->userdata('member')){
//			$order_promo_day = $this->get_order_promo_day($arrayidprod, $this->session->userdata('member')->id_user);
//		} else {
			$order_promo_day = '';
//		}
		$promo_cek = new \Cipika\Common\PromoCekMobo;
		foreach($produk as $p)
		{
			$diskon_properties = $promo_cek->getPromoPrice(
				$p,
				$produk_promo,
				$order_promo_quota,
				$order_promo_quota_per_day,
				$order_promo_day
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
