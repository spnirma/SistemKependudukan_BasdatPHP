<?php

namespace Cipika\Shipping;

class MerchantShippingArea
{

	private $db;

	public function __construct(){
		$CI =& get_instance();
		$this->db = $CI->db;
	}

	public function isDestinationAvailable($idMerchant, $idProduk, $idPropinsi, $idKabupaten){
		
		$status = false;

		$query_produk = $this->db->get_where('tbl_produk', array('id_produk' => $idProduk));
		$produk = $query_produk->row();
		if ($produk->area_produk == 2) {
			$status = true;
		} elseif ($produk->area_produk == 0) {

			$this->db->where('id_user', $idMerchant);
			$cek_data = $this->db->get('tbl_area_merchant');

			if($cek_data->num_rows < 1){
				$status = true;
			} else {
				$this->db->where('id_propinsi' , $idPropinsi);
				$this->db->where('id_kabupaten is null');
				$this->db->where('id_user', $idMerchant);
				$query_area_merchant_p = $this->db->get('tbl_area_merchant');

				$this->db->where('id_kabupaten', $idKabupaten);
				$this->db->where('id_user', $idMerchant);
				$query_area_merchant_k = $this->db->get('tbl_area_merchant');

				if(($query_area_merchant_p->num_rows() > 0) || ($query_area_merchant_k->num_rows() > 0)){
					$status = true;
				}
			}
		
		} elseif ($produk->area_produk == 1) {

	        $this->db->where('id_produk', $idProduk);
			$cek_data = $this->db->get('tbl_area_produk');

			if($cek_data->num_rows < 1){
				$status = true;
			} else {
				$this->db->where('id_propinsi', $idPropinsi);
				$this->db->where('id_kabupaten is null');
		        $this->db->where('id_produk', $idProduk);
				$query_area_produk_p = $this->db->get('tbl_area_produk');

				$this->db->where('id_kabupaten', $idKabupaten);
		        $this->db->where('id_produk', $idProduk);
				$query_area_produk_k = $this->db->get('tbl_area_produk');

				if(($query_area_produk_p->num_rows() > 0) || ($query_area_produk_k->num_rows() > 0)){
					$status = true;
				}
			}
		}

		return $status;
	}

	public function getMerchantShippingArea($idMerchant, $idProduk){
		
		$area = array();

		$query_produk = $this->db->get_where('tbl_produk', array('id_produk' => $idProduk));
		$produk = $query_produk->row();
		if ($produk->area_produk == 2) {
			$area = array();
		} elseif ($produk->area_produk == 0) {
			$this->db->select('*');
			$this->db->where('am.id_propinsi is not null');
			$this->db->where('am.id_kabupaten is null');
    		$this->db->where('am.id_user', $idMerchant);
	        $this->db->from('tbl_area_merchant am');
	        $this->db->join('tbl_kabupaten k', 'k.id_kabupaten = am.id_kabupaten', 'LEFT');
	        $this->db->join('tbl_propinsi p', 'p.id_propinsi = am.id_propinsi', 'LEFT');
			$query_area_merchant_p = $this->db->get();
			foreach ($query_area_merchant_p->result() as $row)
			{
			   $area[] = "Propinsi ".strtoupper($row->nama_propinsi);
			}

			$this->db->select('*');
    		$this->db->where('am.id_user', $idMerchant);
			$this->db->where('am.id_kabupaten is not null');
	        $this->db->from('tbl_area_merchant am');
	        $this->db->join('tbl_kabupaten k', 'k.id_kabupaten = am.id_kabupaten', 'LEFT');
	        $this->db->join('tbl_propinsi p', 'p.id_propinsi = am.id_propinsi', 'LEFT');
			$query_area_merchant_k = $this->db->get();
			foreach ($query_area_merchant_k->result() as $row)
			{
			   $area[] = "Kota ".$row->nama_kabupaten;
			}

		} elseif ($produk->area_produk == 1) {

			$this->db->select('*');
			$this->db->where('ap.id_propinsi is not null');
			$this->db->where('ap.id_kabupaten is null');
	        $this->db->where('ap.id_produk', $idProduk);
	        $this->db->from('tbl_area_produk ap');
	        $this->db->join('tbl_kabupaten k', 'k.id_kabupaten = ap.id_kabupaten', 'LEFT');
	        $this->db->join('tbl_propinsi p', 'p.id_propinsi = ap.id_propinsi', 'LEFT');
			$query_area_produk_p = $this->db->get();
			foreach ($query_area_produk_p->result() as $row)
			{
			   $area[] = "Propinsi ".strtoupper($row->nama_propinsi);
			}

			$this->db->select('*');
			$this->db->where('ap.id_kabupaten is not null');
	        $this->db->where('ap.id_produk', $idProduk);
	        $this->db->from('tbl_area_produk ap');
	        $this->db->join('tbl_kabupaten k', 'k.id_kabupaten = ap.id_kabupaten', 'LEFT');
	        $this->db->join('tbl_propinsi p', 'p.id_propinsi = ap.id_propinsi', 'LEFT');
			$query_area_produk_k = $this->db->get();
			foreach ($query_area_produk_k->result() as $row)
			{
			   $area[] = "Kota ".$row->nama_kabupaten;
			}
		}

		$shippingArea = "Produk ".$produk->nama_produk." hanya tersedia di ".implode(', ', $area);

		return $shippingArea;
	}

}