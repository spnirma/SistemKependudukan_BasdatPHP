<?php 
namespace Cipika\Promo;

class ProdukCicilan
{
    private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}

    public function checkAvailableCicilan($idProduct)
    {   
        $this->db->select('periode_cicilan, bunga_cicilan');
        $this->db->where('id_produk',$idProduct);
        $this->db->where('deleted', 0);
        $this->db->group_by('periode_cicilan');
        $query = $this->db->get('tbl_produk_cicilan');

        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
    
    public function getCicilanProduct($idProduct)
    {   
        $this->db->select('periode_cicilan, bunga_cicilan, id_payment');
        $this->db->where('id_produk',$idProduct);
        $this->db->where('deleted', 0);
        $this->db->order_by('id_payment', 'asc');
        $this->db->order_by('periode_cicilan', 'asc');
        $query = $this->db->get('tbl_produk_cicilan');

        return $query->result();
    }
    
    public function checkCicilanPaymentAvailable($idPayment, $idProduct)
    {
        $this->db->select('periode_cicilan, bunga_cicilan');
        $this->db->where('id_produk', $idProduct);
        $this->db->where('id_payment', $idPayment);
        $this->db->where('deleted', 0);
        $this->db->group_by('periode_cicilan');
        $query = $this->db->get('tbl_produk_cicilan');

        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
 
    public function getCicilanPaymentAvailable($idPayment, $idProduct)
    {
        $this->db->select('id_produk_cicilan, periode_cicilan, bunga_cicilan');
        $this->db->where('id_produk', $idProduct);
        $this->db->where('id_payment', $idPayment);
        $this->db->where('deleted', 0);
        $this->db->group_by('periode_cicilan');
        $query = $this->db->get('tbl_produk_cicilan');

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
   
    public function getProductCicilanPayment($idProduct)
    {   
        $this->db->select('id_payment');
        $this->db->where('id_produk',$idProduct);
        $this->db->where('deleted', 0);
        $this->db->group_by('id_payment');
        $query = $this->db->get('tbl_produk_cicilan');

        $listIdPayment = array();
        foreach ($query->result() as $v) {
            $listIdPayment[] = (int) $v->id_payment;
        }   
        return $listIdPayment;
    }

    public function getSingleDetailCicilan($idProductCicilan)
    {
        $this->db->where('id_produk_cicilan',$idProductCicilan);
        $query = $this->db->get('tbl_produk_cicilan');

        return $query->row();
    }
 
}
