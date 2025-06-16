<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* Semua yg berhubungan tbl_propinsi,tbl_kabupaten,tbl_kecamatan */
class Lib_lokasi 
{
    
    function get_propinsi()
    {
        $CI =& get_instance();
        $sql = "select * from tbl_propinsi order by nama_propinsi asc";
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result();
		}
    }
    
    function get_kabupaten($id_propinsi='')
    {
        $CI =& get_instance();
        $sql = "select p.*,kb.* from tbl_propinsi p,tbl_kabupaten kb where kb.id_propinsi=p.id_propinsi ";
        
        if($id_propinsi!=''){
            $sql.="AND kb.id_propinsi=".$id_propinsi." ";
        }
        
        $sql.="order by kb.nama_kabupaten asc";
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result();
		}
    }
    
    function get_kecamatan($id_kabupaten='')
    {
        $CI =& get_instance();
        $sql = "select p.*,kb.*,kc.* from tbl_propinsi p,tbl_kabupaten kb,tbl_kecamatan kc where kc.id_kabupaten=kb.id_kabupaten and kb.id_propinsi=p.id_propinsi ";
        
        if($id_kabupaten!=''){
            $sql.="AND kc.id_kabupaten=".$id_kabupaten." ";
        }
        
        $sql.="order by kc.nama_kecamatan asc";
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result();
		}
    }
    
    function get_lokasi($kecamatan)
    {
        if($kecamatan!=''){
            $CI =& get_instance();
            $sql = "select p.*,kb.*,kc.* from tbl_propinsi p,tbl_kabupaten kb,tbl_kecamatan kc where kc.id_kabupaten=kb.id_kabupaten and kb.id_propinsi=p.id_propinsi AND kc.id_kecamatan=".$kecamatan." limit 0,1";
           
            $query = $CI->db->query($sql);
            if($query->num_rows() > 0){
                return $query->row();
            }
        }
    }
    
    function get_lokasi_by_kabupaten($kabupaten)
    {
        if($kabupaten!=''){
            $CI =& get_instance();
            $sql = "select p.*,kb.* from tbl_propinsi p,tbl_kabupaten kb where kb.id_propinsi=p.id_propinsi AND kb.id_kabupaten=".$kabupaten." limit 0,1";
           //echo $sql;
            $query = $CI->db->query($sql);
            if($query->num_rows() > 0){
                return $query->row();
            }
        }
    }
}