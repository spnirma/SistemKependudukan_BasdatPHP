<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class commonLib 
{
    
    function get_product_status($id_produk)
    {
        $sql = "select publish from tbl_produk where id_produk=".$id_produk." limit 0,1";
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
            $data = $query->row();
            return $data->publish;
        }
    }
    
    function get_merchant_status($id_user)
    {
        $sql = "select store_status from tbl_store where id_user=".$id_user." limit 0,1";
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
            $data = $query->row();
            return $data->store_status;
        }
    }
    

    /* mdhb2 : ambil data seller */
    function get_seller($iduser)
    {
        if($iduser!=''){
            $CI =& get_instance();
            $sql = "select s.*,u.*,s.alamat as 'alamat_seller',s.id_kota as 'id_kecamatan_seller', kb.*, kc.*, pr.*"
                    . " from  tbl_user u left join tbl_store s on u.id_user=s.id_user"
                    . " left join tbl_propinsi pr on pr.id_propinsi = s.id_propinsi"
                    . " left join tbl_kabupaten kb on kb.id_kabupaten = s.id_kabupaten"
                    . " left join tbl_kecamatan kc on kc.id_kecamatan = s.id_kecamatan where u.id_user=".$iduser." limit 0,1";
            
            $query = $CI->db->query($sql);
            if($query->num_rows() > 0){
                return $query->row();
            }
        }
    }

    /* mdhb2 : Merubah 2014-05-26 12:20:23 menjadi 'xx hari' */
    function time_ago($date)
    {
        $time = time() - strtotime($date);
        
        $tokens = array (
            31536000 => 'tahun',
            2592000 => 'bulan',
            604800 => 'minggu',
            86400 => 'hari',
            3600 => 'jam',
            60 => 'menit',
            1 => 'detik'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }
    }


    /* Check apakah user status merchant dan status_store=X*/
    function check_merchant_status($iduser,$level,$status)
    {
        $CI =& get_instance();
        $sql = "select u.id_user,m.id_store from tbl_user u,tbl_store m where m.id_user=u.id_user AND u.id_level=".$level." AND m.store_status='".$status."' and m.id_user=".$iduser." limit 0,1";
//        $sql = "select u.id_user,m.id_store from tbl_user u,tbl_store m where m.id_user=u.id_user AND u.id_level=".$level." and m.id_user=".$iduser." limit 0,1";
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return TRUE;
		}else{
            return FALSE;
        }
    }
    
    /* Check apakah user status merchant dan status_store=X*/
    function check_merchant($iduser,$level)
    {
        $CI =& get_instance();
//        $sql = "select u.id_user,m.id_store from tbl_user u,tbl_store m where m.id_user=u.id_user AND u.id_level=".$level." AND m.store_status='".$status."' and m.id_user=".$iduser." limit 0,1";
        $sql = "select u.id_user,m.id_store from tbl_user u,tbl_store m where m.id_user=u.id_user AND u.id_level=".$level." and m.id_user=".$iduser." limit 0,1";
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return TRUE;
		}else{
            return FALSE;
        }
    }

	/* Generate Uniq permalink */
	public function generate_permalink($string,$table,$idtable_field,$field)
	{
		$CI =& get_instance();
		
		//# 1 Cek apakah permalink uniq
		$permalink = url_title($string, '-', TRUE);
		$sql 	   = "select $idtable_field,$field from $table where $field='".$permalink."'";
		$query 	   = $CI->db->query($sql);

		if($query->num_rows() > 1){ //# ada > 1 => berarti ada yg sama selain ini
			$data = $query->row_array();
		    $permalink.="-".$data[$idtable_field];
		}
		return $permalink;
	}
    
    /* Get Banner by name */
    public function get_banner($name) 
    {
        $CI =& get_instance();
        $sql = "select * from banner where banner_title='".$name."' limit 0,1";
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->row(); 
		}
    }
    
    /* Custom Count total of cart */
    function cart_total($qty,$price,$cart)
    {
        $total = 0;
        if(!empty($cart)){
            foreach($cart as $row){
                $total = $total + ($row[$qty] * $row[$price]);
            }
        }
        return $total;
    }
    
    /* Set jumlah produk terjual jika status pembayaran di set ke Done */
    function update_terjual($status,$idorder)
    {
        $CI =& get_instance();
        if($status=='done'){
            
            $sql = "select * from tbl_orderitem where id_order=".$idorder;
            $query = $CI->db->query($sql);
            if($query->num_rows() > 0){
                $result = $query->result(); 
                
                foreach($result as $item){
                    $sql2 = "UPDATE `tbl_produk` SET `terjual` = '+".$item->jml_produk."' WHERE `id_produk`=".$item->id_produk;
                    //echo $sql2.'<hr/>';
                    $query2 = $CI->db->query($sql2);
                }
                //exit;
            }
        
            
        }
    }
}