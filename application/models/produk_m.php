<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk_m extends MY_Model {

    public $variable;

    public $id_produk_request;

    public function __construct()
    {
        parent::__construct();
    }

    function getSales()
    {
        $this->db->where('id_level', '3');
        $this->db->order_by("username", "asc");
        $q = $this->db->get('tbl_user');
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function getMerchant()
    {
        $this->db->order_by("nama_store", "asc");
        $q = $this->db->get('tbl_store');
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    function getKabupaten()
    {
        $this->db->order_by("nama_kabupaten", "asc");
        $q = $this->db->get('tbl_kabupaten');
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_all_produk($limit='', $offset='')
    {
        $sql = "select a.*, a.deskripsi as deskripsi_produk, a.deskripsi_en as deskripsi_produk_en, b.nama_kabupaten, e.nama_kecamatan, f.nama_propinsi, c.*, a.date_modified as tgl_upload, d.*
                from tbl_produk a
                left join tbl_user c on a.id_user=c.id_user
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_kecamatan e on e.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten b on b.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi f on f.id_propinsi=d.id_propinsi
                where a.deleted=0 and a.id_parent is null order by a.date_modified desc LIMIT " . (int)$offset . ", " . (int)$limit . "";
//        echo $sql;
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function get_all_produk_status($status='',$limit='', $offset='')
    {
        $sql = "select a.*, a.deskripsi as deskripsi_produk, a.deskripsi_en as deskripsi_produk_en, a.alasan_ditolak as alasan, b.nama_kabupaten, e.nama_kecamatan, f.nama_propinsi,
                c.*, a.date_added as tgl_upload, a.date_modified as tgl_edit,  a.date_request as tgl_request,
                a.date_verified as tgl_verified, a.date_unverified as tgl_unverified, d.*
                from tbl_produk a
                left join tbl_user c on a.id_user=c.id_user
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_kecamatan e on e.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten b on b.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi f on f.id_propinsi=d.id_propinsi
                where a.deleted=0 and a.publish=". (int)$status." and d.store_status='approve'
				and a.id_event=".EVENTID;
        if ($status != 0){
            $sql .= " and a.id_parent is null";
        }
        
        if($this->session->userdata('admin_session')->id_level == 8){
            $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
        }
        
        if($status == 0){
                $sql .= " order by a.date_request desc";
            }else if($status == 1){
                $sql .= " order by a.date_verified desc";
            }else if($status == 2){
                $sql .= " order by a.date_unverified desc";
            }
        $sql .= " LIMIT " . (int)$offset . ", " . (int)$limit . "";
//echo $sql;die;		
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function get_all_produk_unverified_merchant($limit='', $offset='')
    {
        $sql = "select a.*, a.deskripsi as deskripsi_produk, a.deskripsi_en as deskripsi_produk_en, b.nama_kabupaten, e.nama_kecamatan, f.nama_propinsi,
                c.*, a.date_added as tgl_upload, a.date_modified as tgl_edit,
                a.date_verified as tgl_verified, a.date_unverified as tgl_unverified, d.*
                from tbl_produk a
                left join tbl_user c on a.id_user=c.id_user
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_kecamatan e on e.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten b on b.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi f on f.id_propinsi=d.id_propinsi
                where a.deleted=0 and d.store_status != 'approve' and a.id_parent is null ";
                
                if($this->session->userdata('admin_session')->id_level == 8){
                    $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
                }
                
                $sql .= " order by a.date_added desc LIMIT " . (int)$offset . ", " . (int)$limit . "";
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_kategori($id=''){
        $sql="select b.nama_kategori
            from tbl_produk_kategori a
            left join tbl_kategori b on a.id_kategori=b.id_kategori
            where a.id_produk='". (int)$id."'";
        $q=$this->db->query($sql);
        $data=$q->result();
        $q->free_result();

        foreach ($data as $key => $value) {
            echo $value->nama_kategori;
            echo ", ";
        }
    }

    function get_produk($id = '', $status = '')
    {
        $db = $this->getReadDb();
        $sql = "select a.*, d.alamat as alamat_merchant, d.telpon as telpon_merchant, c.nama_kabupaten, b.*, b.image as merchant_image, d.nama_store
				from tbl_produk a
                left join tbl_user b on a.id_user=b.id_user
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_kecamatan e on d.id_kecamatan=e.id_kecamatan
                left join tbl_kabupaten c on d.id_kabupaten=c.id_kabupaten
				where id_produk='" . (int)$id . "' and a.deleted = 0 ";
                if ($status != '') {
                    $sql .= "and a.publish='".$status."'";
                }
        $q = $db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data;
    }

    function count_list($id)
    {
        $sql = "select * from tbl_produk a
                join tbl_produkfoto b on a.id_produk = b.id_produk 
                where a.id_user='" . (int)$id . "' and a.publish = '1' and a.deleted = '0'
                group by a.id_produk";
        $q = $this->db->query($sql);
        $data = $q->num_rows();
        $q->free_result();
        return $data;
    }

    function count_follower($id)
    {
        $db = $this->getReadDb();
        $sql = "select count(*) as jml from tbl_follow where id_user_followed='" . (int)$id . "'";
        $q = $db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jml;
    }

    function count_following($id)
    {
        $db = $this->getReadDb();
        $sql = "select count(*) as jml from tbl_follow where id_user_following='" . (int)$id . "'";
        $q = $db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jml;
    }

    function count_love($id)
    {
        $db = $this->getReadDb();
        $sql = "select count(*) as jml from tbl_love where id_produk='" . (int)$id . "'";
        $q = $db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jml;
    }

    function count_love_all($id)
    {
        $db = $this->getReadDb();
        $sql = "select count(*) as jml from tbl_love a, tbl_produk b, tbl_user c where a.id_produk=b.id_produk and b.id_user=c.id_user and b.id_user='" . (int)$id . "'";
        $q = $db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jml;
    }

    function count_comment($id)
    {
        $db = $this->getReadDb();
        $sql = "select count(*) as jml from tbl_comment where id_produk='" . (int)$id . "'";
        $q = $db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jml;
    }

    function get_comment($id = '', $limit = '', $offset = '')
    {
        $db = $this->getReadDb();
        $sql = "select a.*, b.username, b.id_user, b.image
			from tbl_comment a, tbl_user b
			where a.id_user=b.id_user and a.id_produk='".(int)$id."' order by a.date_added desc limit " . (int)$offset . "," .(int)$limit . "";
        $q = $db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_produk_user($id = '', $limit = '', $offset = '')
    {
        $sql = "select a.*, c.image
				from tbl_produk a
				left join tbl_produkfoto c
				on a.id_produk=c.id_produk
				where a.id_user=" . (int)$id . " and a.deleted=0 and a.id_parent is null
				group by a.id_produk order by id_produk desc limit " . (int)$offset . "," . (int)$limit . "";
//echo $sql;die;                
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_produk_user_published($id = '', $limit = '', $offset = '')
    {
        $sql = "select a.*, c.image, k.nama_kategori
				from tbl_produk a
				inner join tbl_produkfoto c on a.id_produk=c.id_produk
				left join tbl_kategori k on k.id_kategori=a.id_kategori
				where a.id_user=" . (int)$id . " and a.deleted=0 and a.id_parent is null
				and a.publish=1 and a.show_on_listing=1
				and c.image<>''
				group by a.id_produk order by perkiraan_harga desc limit " . (int)$offset . "," . (int)$limit . "";
//echo $sql;die;                
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

	
    function get_produk_indoloka($kode, $limit, $offset)
    {
        $sql = "select a.*, c.image
                from tbl_produk a
                left join tbl_store b on a.id_store = b.id_store
                left join tbl_produkfoto c on a.id_produk = c.id_produk
                where b.merchant_indoloka = '".$kode."' and a.deleted = 0
                group by a.id_produk order by id_produk desc limit " . (int)$offset . "," . (int)$limit . "";
                
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function get_all_produk_user($id = '')
    {
        $sql = "select a.*, c.image
				from tbl_produk a
				left join tbl_produkfoto c
				on a.id_produk=c.id_produk
				where a.id_user=" . (int)$id . " and a.deleted=0
				group by a.id_produk order by id_produk desc ";
                
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function count_produk_user_by_search($id = '', $by_search='', $by_category='', $by_stat='')
    {
        $sql = "select count(*) as jumlah from (select a.id_produk 
                from tbl_produk a
                left join tbl_produk_kategori b
                on a.id_produk=b.id_produk
                left join tbl_produkfoto c
                on a.id_produk=c.id_produk
                where a.id_user='" . (int)$id . "' and deleted=0 and id_parent is null";

        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }        
        if($by_stat !="") {
            if ($by_stat == 'verified') {
                $conditions[] = "a.publish = 1";
            } else if ($by_stat == 'moderasi') {
                $conditions[] = "a.publish = 0";
            } else if ($by_stat == 'unverified') {
                $conditions[] = "a.publish = 2";
            } else {
                
            }
            
        }

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk) as x";
        // echo $sql;exit;

        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }

    function count_produk_indoloka_by_search($kode, $by_search='', $by_category='')
    {
        $sql = "select count(*) as jumlah from (select a.id_produk 
                from tbl_produk a
                left join tbl_produk_kategori b
                on a.id_produk=b.id_produk
                left join tbl_produkfoto c
                on a.id_produk=c.id_produk
                left join tbl_store d on a.id_store = d.id_store
                where d.merchant_indoloka = '".$kode."' and deleted=0";

        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk) as x";
        // echo $sql;exit;

        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }

    function count_all_product_search($by_search='', $by_category='', $by_sales='', $by_status='', 
    $by_merchant='', $by_stok='', $by_from='', $by_to='', $by_feature='', $by_price='', $by_channel = '', $by_location='',
    $indoloka, $limit = '', $offset = '')
    {
        $sql = "select count(*) as jumlah from (select a.*, c.image
                from tbl_produk a
                left join tbl_produk_kategori b
                on a.id_produk=b.id_produk
                left join tbl_produkfoto c
                on a.id_produk=c.id_produk
                left join tbl_store d
                on a.id_user=d.id_user
                left join tbl_user f on a.id_user=f.id_user
                left join tbl_kabupaten e on f.id_kabupaten=e.id_kabupaten
                where a.deleted=0 and d.store_status = 'approve'";
        
        if($this->session->userdata('admin_session')->id_level == 8){
                    $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
                }

        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }
        if($by_sales !="") {
          $conditions[] = "d.id_sales='" . (int)$by_sales . "'";
        }
        if($by_status != 0) {
          $conditions[] = "a.publish='" . (int)$by_status . "'";
          $conditions[] = "a.id_parent is null";
        }elseif($by_status != ""){
           $conditions[] = "a.publish='" . (int)$by_status . "'";
        }
        if($by_merchant !=0) {
          $conditions[] = "a.id_user='" . (int)$by_merchant . "'";
        }
        if($by_from !="" && $by_to !="") {
            $from = strftime("%Y-%m-%d",strtotime($by_from));
            $to = strftime("%Y-%m-%d",strtotime($by_to));
            $conditions[] = "(DATE(a.date_modified) BETWEEN '" . $this->db->escape_str($from) . "' AND '" . $this->db->escape_str($to) . "')";
        }
        if($by_feature !="") {
            if($by_feature=="1") {$conditions[] = "a.unggulan='1'";}
            else if($by_feature=="2") {$conditions[] = "a.pick='1'";}
            else {}
        }
        if($by_stok !="") {
          if($by_stok=='1'){$conditions[] = "a.stok_produk < 10";}
          else if($by_stok=='2'){$conditions[] = "a.stok_produk BETWEEN 10 AND 100";}
          else if($by_stok=='3'){$conditions[] = "a.stok_produk BETWEEN 100 AND 1000";}
          else {}
        }
        if($by_price !="") {
          if($by_price=='1'){$conditions[] = "a.harga_jual < 50000";}
          else if($by_price=='2'){$conditions[] = "a.harga_jual BETWEEN 50000 AND 100000";}
          else if($by_price=='3'){$conditions[] = "a.harga_jual BETWEEN 100000 AND 250000";}
          else if($by_price=='4'){$conditions[] = "a.harga_jual BETWEEN 250000 AND 500000";}
          else if($by_price=='5'){$conditions[] = "a.harga_jual > 500000";}
          else {}
        }
        
        if($by_channel !="") {
          $conditions[] = "a.channel like '%".$this->db->escape_like_str($by_channel)."%'";
        }
        
        if($by_location !="") {
          $conditions[] = "e.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }

        if($indoloka !="all" && $indoloka !="") {            
            $conditions[] = "d.merchant_indoloka = '" . $this->db->escape_str($indoloka) . "'";
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk) as x";
        // echo $sql;
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function count_all_product_search_unverified_merchant($by_search='', $by_category='', $by_sales='', $by_status='', 
    $by_merchant='', $by_stok='', $by_from='', $by_to='', $by_feature='', $by_price='', $by_channel = '', $by_location='',
    $indoloka='', $limit = '', $offset = '')
    {
        $sql = "select count(*) as jumlah from (select a.*, c.image
                from tbl_produk a
                left join tbl_produk_kategori b
                on a.id_produk=b.id_produk
                left join tbl_produkfoto c
                on a.id_produk=c.id_produk
                left join tbl_store d
                on a.id_user=d.id_user
                left join tbl_user f on a.id_user=f.id_user
                left join tbl_kabupaten e on f.id_kabupaten=e.id_kabupaten
                where a.deleted=0 and d.store_status != 'approve' and a.id_parent is null";
        
        if($this->session->userdata('admin_session')->id_level == 8){
                    $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
                }

        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }
        if($by_sales !="") {
          $conditions[] = "d.id_sales='" . (int)$by_sales . "'";
        }
        if($by_status !="") {
          $conditions[] = "a.publish='" . (int)$by_status . "'";
        }
        if($by_merchant !="") {
          $conditions[] = "a.id_user='" . (int)$by_merchant . "'";
        }
        if($by_from !="" && $by_to !="") {
            $from = strftime("%Y-%m-%d",strtotime($by_from));
            $to = strftime("%Y-%m-%d",strtotime($by_to));
            $conditions[] = "(DATE(a.date_added) BETWEEN '" . $this->db->escape_str($from) . "' AND '" . $this->db->escape_str($to) . "')";
        }
        if($by_feature !="") {
            if($by_feature=="1") {$conditions[] = "a.unggulan='1'";}
            else if($by_feature=="2") {$conditions[] = "a.pick='1'";}
            else {}
        }
        if($by_stok !="") {
          if($by_stok=='1'){$conditions[] = "a.stok_produk < 10";}
          else if($by_stok=='2'){$conditions[] = "a.stok_produk BETWEEN 10 AND 100";}
          else if($by_stok=='3'){$conditions[] = "a.stok_produk BETWEEN 100 AND 1000";}
          else {}
        }
        if($by_price !="") {
          if($by_price=='1'){$conditions[] = "a.harga_jual < 50000";}
          else if($by_price=='2'){$conditions[] = "a.harga_jual BETWEEN 50000 AND 100000";}
          else if($by_price=='3'){$conditions[] = "a.harga_jual BETWEEN 100000 AND 250000";}
          else if($by_price=='4'){$conditions[] = "a.harga_jual BETWEEN 250000 AND 500000";}
          else if($by_price=='5'){$conditions[] = "a.harga_jual > 500000";}
          else {}
        }
        
        if($by_channel !="") {
          $conditions[] = "a.channel like '%".$this->db->escape_like_str($by_channel)."%'";
        }
        if($by_location !="") {
          $conditions[] = "e.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }
        if($indoloka !="all") {
            if($indoloka !="") {
              $conditions[] = "d.merchant_indoloka = '" . $this->db->escape_str($indoloka) . "'";
            } else {
              $conditions[] = "d.merchant_indoloka is null";
            }
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk) as x";
        
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }

    function get_produk_by_search($by_search='', $by_category='', $by_sales='', $by_status='', 
    $by_merchant='', $by_stok='', $by_from='', $by_to='', $by_feature='', $by_price='', $by_channel = '', $by_location='',
    $indoloka= '', $limit = '', $offset = '')
    {
        $sql = "select a.*, a.deskripsi as deskripsi_produk, a.deskripsi_en as deskripsi_produk_en, a.alasan_ditolak as alasan, a.date_added as tgl_upload, a.date_modified as tgl_edit,
                a.date_verified as tgl_verified, a.date_unverified as tgl_unverified, a.date_request as tgl_request,
                d.*, e.nama_kabupaten, g.nama_kecamatan, h.nama_propinsi, f.*
                from tbl_produk a
                left join tbl_produk_kategori b on a.id_produk=b.id_produk
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_user f on a.id_user=f.id_user
                left join tbl_kecamatan g on g.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten e on e.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi h on h.id_propinsi=d.id_propinsi
                where a.deleted=0 and d.store_status='approve'
				and a.id_event=".EVENTID;
        
        if($this->session->userdata('admin_session')->id_level == 8){
                    $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
                }
        
        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }
        if($by_sales !="") {
          $conditions[] = "d.id_sales='" . (int)$by_sales . "'";
        }
        if($by_status != 0) {
          $conditions[] = "a.publish='" . (int)$by_status . "'";
          $conditions[] = "a.id_parent is null";
        }elseif($by_status != ""){
           $conditions[] = "a.publish='" . (int)$by_status . "'";
        }
        if($by_merchant !="") {
          $conditions[] = "a.id_user='" . (int)$by_merchant . "'";
        }
        if($by_from !="" && $by_to !="") {
            $from = strftime("%Y-%m-%d",strtotime($by_from));
            $to = strftime("%Y-%m-%d",strtotime($by_to));
            if($by_status == 0){
                $conditions[] = "(DATE(a.date_request) BETWEEN '$from' AND '$to')";
            }else if($by_status == 1){
                $conditions[] = "(DATE(a.date_verified) BETWEEN '$from' AND '$to')";
            }else if($by_status == 2){
                $conditions[] = "(DATE(a.date_unverified) BETWEEN '$from' AND '$to')";
            }
        }
        if($by_feature !="") {
            if($by_feature=="1") {$conditions[] = "a.unggulan='1'";}
            else if($by_feature=="2") {$conditions[] = "a.pick='1'";}
            else {}
        }
        if($by_stok !="") {
          if($by_stok=='1'){$conditions[] = "a.stok_produk < 10";}
          else if($by_stok=='2'){$conditions[] = "a.stok_produk BETWEEN 10 AND 100";}
          else if($by_stok=='3'){$conditions[] = "a.stok_produk BETWEEN 100 AND 1000";}
          else {}
        }
        if($by_price !="") {
          if($by_price=='1'){$conditions[] = "a.harga_jual < 50000";}
          else if($by_price=='2'){$conditions[] = "a.harga_jual BETWEEN 50000 AND 100000";}
          else if($by_price=='3'){$conditions[] = "a.harga_jual BETWEEN 100000 AND 250000";}
          else if($by_price=='4'){$conditions[] = "a.harga_jual BETWEEN 250000 AND 500000";}
          else if($by_price=='5'){$conditions[] = "a.harga_jual > 500000";}
          else {}
        }
        
        if($by_channel !="") {
          $conditions[] = "a.channel like '%".$this->db->escape_like_str($by_channel)."%'";
        }
        
        if($by_location !="") {
          $conditions[] = "e.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }
        if($indoloka !="all" && $indoloka !="") {
            $conditions[] = "d.merchant_indoloka = '" . $this->db->escape_str($indoloka) . "'";
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')
        
        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk ";
        if($by_status == 0){
                $sql .= "order by a.date_request desc";
            }else if($by_status == 1){
                $sql .= "order by a.date_verified desc";
            }else if($by_status == 2){
                $sql .= "order by a.date_unverified desc";
            }
        $sql .= " LIMIT " . (int)$offset . ", " . (int)$limit . "";
        // var_dump($sql);exit;
        // echo $sql; 
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function export_produk_request_verification_by_search($by_search='', $by_category='', $by_sales='', $by_status='', 
    $by_merchant='', $by_stok='', $by_from='', $by_to='', $by_feature='', $by_price='', $by_channel = '', $by_location='', $indoloka = '')
    {
        $sql = "select a.*, a.deskripsi as deskripsi_produk, a.deskripsi_en as deskripsi_produk_en, a.alasan_ditolak as alasan, a.date_added as tgl_upload, a.date_modified as tgl_edit,
                a.date_verified as tgl_verified, a.date_unverified as tgl_unverified, a.date_request as tgl_request,
                d.*, e.nama_kabupaten, g.nama_kecamatan, h.nama_propinsi, f.*, j.nama_kategori
                from tbl_produk a
                left join tbl_produk_kategori b on a.id_produk=b.id_produk
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_user f on a.id_user=f.id_user
                left join tbl_kecamatan g on g.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten e on e.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi h on h.id_propinsi=d.id_propinsi
                left join tbl_produk_kategori i ON a.id_produk=i.id_produk
                left join tbl_kategori j ON i.id_kategori=j.id_kategori
                where a.deleted=0 and d.store_status='approve'";
        
        if($this->session->userdata('admin_session')->id_level == 8){
                    $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
                }
        
        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }
        if($by_sales !="") {
          $conditions[] = "d.id_sales='" . (int)$by_sales . "'";
        }
        if($by_status != 0) {
          $conditions[] = "a.publish='" . (int)$by_status . "'";
          $conditions[] = "a.id_parent is null";
        }elseif($by_status != ""){
           $conditions[] = "a.publish='" . (int)$by_status . "'";
        }
        if($by_merchant !="") {
          $conditions[] = "a.id_user='" . (int)$by_merchant . "'";
        }
        if($by_from !="" && $by_to !="") {
            $from = strftime("%Y-%m-%d",strtotime($by_from));
            $to = strftime("%Y-%m-%d",strtotime($by_to));
            if($by_status == 0){
                $conditions[] = "(DATE(a.date_request) BETWEEN '$from' AND '$to')";
            }else if($by_status == 1){
                $conditions[] = "(DATE(a.date_verified) BETWEEN '$from' AND '$to')";
            }else if($by_status == 2){
                $conditions[] = "(DATE(a.date_unverified) BETWEEN '$from' AND '$to')";
            }
        }
        if($by_feature !="") {
            if($by_feature=="1") {$conditions[] = "a.unggulan='1'";}
            else if($by_feature=="2") {$conditions[] = "a.pick='1'";}
            else {}
        }
        if($by_stok !="") {
          if($by_stok=='1'){$conditions[] = "a.stok_produk < 10";}
          else if($by_stok=='2'){$conditions[] = "a.stok_produk BETWEEN 10 AND 100";}
          else if($by_stok=='3'){$conditions[] = "a.stok_produk BETWEEN 100 AND 1000";}
          else {}
        }
        if($by_price !="") {
          if($by_price=='1'){$conditions[] = "a.harga_jual < 50000";}
          else if($by_price=='2'){$conditions[] = "a.harga_jual BETWEEN 50000 AND 100000";}
          else if($by_price=='3'){$conditions[] = "a.harga_jual BETWEEN 100000 AND 250000";}
          else if($by_price=='4'){$conditions[] = "a.harga_jual BETWEEN 250000 AND 500000";}
          else if($by_price=='5'){$conditions[] = "a.harga_jual > 500000";}
          else {}
        }
        
        if($by_channel !="") {
          $conditions[] = "a.channel like '%".$this->db->escape_like_str($by_channel)."%'";
        }
        
        if($by_location !="") {
          $conditions[] = "e.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }

        if($indoloka !="all") {
            if($indoloka !="") {
              $conditions[] = "d.merchant_indoloka = '" . $this->db->escape_str($indoloka) . "'";
            } else {
              $conditions[] = "d.merchant_indoloka is null";
            }
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk ";
        if($by_status == 0){
                $sql .= "order by a.date_request desc";
            }else if($by_status == 1){
                $sql .= "order by a.date_verified desc";
            }else if($by_status == 2){
                $sql .= "order by a.date_unverified desc";
            }
        // var_dump($sql);exit;
        // echo $sql;die();
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function export_produk_unverified_by_search($by_search='', $by_category='', $by_sales='', $by_status='', 
    $by_merchant='', $by_stok='', $by_from='', $by_to='', $by_feature='', $by_price='', $by_channel = '', $by_location='')
    {
        $sql = "select a.*, a.deskripsi as deskripsi_produk, a.deskripsi_en as deskripsi_produk_en, a.alasan_ditolak as alasan, a.date_added as tgl_upload, a.date_modified as tgl_edit,
                a.date_verified as tgl_verified, a.date_unverified as tgl_unverified, a.date_request as tgl_request,
                d.*, e.nama_kabupaten, g.nama_kecamatan, h.nama_propinsi, f.*, j.nama_kategori
                from tbl_produk a
                left join tbl_produk_kategori b on a.id_produk=b.id_produk
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_user f on a.id_user=f.id_user
                left join tbl_kecamatan g on g.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten e on e.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi h on h.id_propinsi=d.id_propinsi
                JOIN tbl_produk_kategori i ON a.id_produk=i.id_produk
                JOIN tbl_kategori j ON i.id_kategori=j.id_kategori
                where a.deleted=0 and d.store_status='approve'";
        
        if($this->session->userdata('admin_session')->id_level == 8){
                    $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
                }
        
        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }
        if($by_sales !="") {
          $conditions[] = "d.id_sales='" . (int)$by_sales . "'";
        }
        if($by_status != 0) {
          $conditions[] = "a.publish='" . (int)$by_status . "'";
          $conditions[] = "a.id_parent is null";
        }elseif($by_status != ""){
           $conditions[] = "a.publish='" . (int)$by_status . "'";
        }
        if($by_merchant !="") {
          $conditions[] = "a.id_user='" . (int)$by_merchant . "'";
        }
        if($by_from !="" && $by_to !="") {
            $from = strftime("%Y-%m-%d",strtotime($by_from));
            $to = strftime("%Y-%m-%d",strtotime($by_to));
            if($by_status == 0){
                $conditions[] = "(DATE(a.date_request) BETWEEN '$from' AND '$to')";
            }else if($by_status == 1){
                $conditions[] = "(DATE(a.date_verified) BETWEEN '$from' AND '$to')";
            }else if($by_status == 2){
                $conditions[] = "(DATE(a.date_unverified) BETWEEN '$from' AND '$to')";
            }
        }
        if($by_feature !="") {
            if($by_feature=="1") {$conditions[] = "a.unggulan='1'";}
            else if($by_feature=="2") {$conditions[] = "a.pick='1'";}
            else {}
        }
        if($by_stok !="") {
          if($by_stok=='1'){$conditions[] = "a.stok_produk < 10";}
          else if($by_stok=='2'){$conditions[] = "a.stok_produk BETWEEN 10 AND 100";}
          else if($by_stok=='3'){$conditions[] = "a.stok_produk BETWEEN 100 AND 1000";}
          else {}
        }
        if($by_price !="") {
          if($by_price=='1'){$conditions[] = "a.harga_jual < 50000";}
          else if($by_price=='2'){$conditions[] = "a.harga_jual BETWEEN 50000 AND 100000";}
          else if($by_price=='3'){$conditions[] = "a.harga_jual BETWEEN 100000 AND 250000";}
          else if($by_price=='4'){$conditions[] = "a.harga_jual BETWEEN 250000 AND 500000";}
          else if($by_price=='5'){$conditions[] = "a.harga_jual > 500000";}
          else {}
        }
        
        if($by_channel !="") {
          $conditions[] = "a.channel like '%".$this->db->escape_like_str($by_channel)."%'";
        }
        
        if($by_location !="") {
          $conditions[] = "e.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk ";
        if($by_status == 0){
                $sql .= "order by a.date_request desc";
            }else if($by_status == 1){
                $sql .= "order by a.date_verified desc";
            }else if($by_status == 2){
                $sql .= "order by a.date_unverified desc";
            }
        // echo $sql;die(); 
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function export_produk_verified_by_search($by_search='', $by_category='', $by_sales='', $by_status='', 
    $by_merchant='', $by_stok='', $by_from='', $by_to='', $by_feature='', $by_price='', $by_channel = '', $by_location='', $indoloka = "", $limit = '', $offset = '')
    {
        $sql = "select a.*, a.deskripsi as deskripsi_produk, a.deskripsi_en as deskripsi_produk_en, a.alasan_ditolak as alasan, a.date_added as tgl_upload, a.date_modified as tgl_edit,
                a.date_verified as tgl_verified, a.date_unverified as tgl_unverified, a.date_request as tgl_request,
                d.*, e.nama_kabupaten, g.nama_kecamatan, h.nama_propinsi, f.*, j.nama_kategori
                from tbl_produk a
                left join tbl_produk_kategori b on a.id_produk=b.id_produk
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_user f on a.id_user=f.id_user
                left join tbl_kecamatan g on g.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten e on e.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi h on h.id_propinsi=d.id_propinsi
                left JOIN tbl_kategori j ON b.id_kategori=j.id_kategori 
                where a.deleted=0 and d.store_status='approve'";
        
        if($this->session->userdata('admin_session')->id_level == 8){
                    $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
                }
        
        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }
        if($by_sales !="") {
          $conditions[] = "d.id_sales='" . (int)$by_sales . "'";
        }
        if($by_status != 0) {
          $conditions[] = "a.publish='" . (int)$by_status . "'";
          $conditions[] = "a.id_parent is null";
        }elseif($by_status != ""){
           $conditions[] = "a.publish='" . (int)$by_status . "'";
        }
        if($by_merchant !="") {
          $conditions[] = "a.id_user='" . (int)$by_merchant . "'";
        }
        if($by_from !="" && $by_to !="") {
            $from = strftime("%Y-%m-%d",strtotime($by_from));
            $to = strftime("%Y-%m-%d",strtotime($by_to));
            if($by_status == 0){
                $conditions[] = "(DATE(a.date_request) BETWEEN '$from' AND '$to')";
            }else if($by_status == 1){
                $conditions[] = "(DATE(a.date_verified) BETWEEN '$from' AND '$to')";
            }else if($by_status == 2){
                $conditions[] = "(DATE(a.date_unverified) BETWEEN '$from' AND '$to')";
            }
        }
        if($by_feature !="") {
            if($by_feature=="1") {$conditions[] = "a.unggulan='1'";}
            else if($by_feature=="2") {$conditions[] = "a.pick='1'";}
            else {}
        }
        if($by_stok !="") {
          if($by_stok=='1'){$conditions[] = "a.stok_produk < 10";}
          else if($by_stok=='2'){$conditions[] = "a.stok_produk BETWEEN 10 AND 100";}
          else if($by_stok=='3'){$conditions[] = "a.stok_produk BETWEEN 100 AND 1000";}
          else {}
        }
        if($by_price !="") {
          if($by_price=='1'){$conditions[] = "a.harga_jual < 50000";}
          else if($by_price=='2'){$conditions[] = "a.harga_jual BETWEEN 50000 AND 100000";}
          else if($by_price=='3'){$conditions[] = "a.harga_jual BETWEEN 100000 AND 250000";}
          else if($by_price=='4'){$conditions[] = "a.harga_jual BETWEEN 250000 AND 500000";}
          else if($by_price=='5'){$conditions[] = "a.harga_jual > 500000";}
          else {}
        }
        
        if($by_channel !="") {
          $conditions[] = "a.channel like '%".$this->db->escape_like_str($by_channel)."%'";
        }
        
        if($by_location !="") {
          $conditions[] = "e.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }

        if (!($indoloka == "all" || $indoloka == "")) {
            $conditions[] = "merchant_indoloka = '". $this->db->escape_like_str($indoloka) . "'";
        }
        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk ";
        if($by_status == 0){
                $sql .= "order by a.date_request desc";
            }else if($by_status == 1){
                $sql .= "order by a.date_verified desc";
            }else if($by_status == 2){
                $sql .= "order by a.date_unverified desc";
            }
        // var_dump($sql);exit;
        // echo $sql; die();
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function get_produk_by_search_unverified_merchant($by_search='', $by_category='', $by_sales='', $by_status='', 
    $by_merchant='', $by_stok='', $by_from='', $by_to='', $by_feature='', $by_price='', $by_channel = '', $by_location='',
    $indoloka='', $limit = '', $offset = '')
    {
        $sql = "select a.*, a.deskripsi as deskripsi_produk, a.deskripsi_en as deskripsi_produk_en, a.date_added as tgl_upload, a.date_modified as tgl_edit,
                a.date_verified as tgl_verified, a.date_unverified as tgl_unverified,
                d.*, e.nama_kabupaten, g.nama_kecamatan, h.nama_propinsi, f.*
                from tbl_produk a
                left join tbl_produk_kategori b on a.id_produk=b.id_produk
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_user f on a.id_user=f.id_user
                left join tbl_kecamatan g on g.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten e on e.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi h on h.id_propinsi=d.id_propinsi
                where a.deleted=0 and d.store_status !='approve' and a.id_parent is null";
        
        if($this->session->userdata('admin_session')->id_level == 8){
                    $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
                }
        
        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }
        if($by_sales !="") {
          $conditions[] = "d.id_sales='" . (int)$by_sales . "'";
        }
        if($by_status !="") {
          $conditions[] = "a.publish='" . (int)$by_status . "'";
        }
        if($by_merchant !="") {
          $conditions[] = "a.id_user='" . (int)$by_merchant . "'";
        }
        if($by_from !="" && $by_to !="") {
            $from = strftime("%Y-%m-%d",strtotime($by_from));
            $to = strftime("%Y-%m-%d",strtotime($by_to));
            $conditions[] = "(DATE(a.date_added) BETWEEN '$from' AND '$to')";
        }
        if($by_feature !="") {
            if($by_feature=="1") {$conditions[] = "a.unggulan='1'";}
            else if($by_feature=="2") {$conditions[] = "a.pick='1'";}
            else {}
        }
        if($by_stok !="") {
          if($by_stok=='1'){$conditions[] = "a.stok_produk < 10";}
          else if($by_stok=='2'){$conditions[] = "a.stok_produk BETWEEN 10 AND 100";}
          else if($by_stok=='3'){$conditions[] = "a.stok_produk BETWEEN 100 AND 1000";}
          else {}
        }
        if($by_price !="") {
          if($by_price=='1'){$conditions[] = "a.harga_jual < 50000";}
          else if($by_price=='2'){$conditions[] = "a.harga_jual BETWEEN 50000 AND 100000";}
          else if($by_price=='3'){$conditions[] = "a.harga_jual BETWEEN 100000 AND 250000";}
          else if($by_price=='4'){$conditions[] = "a.harga_jual BETWEEN 250000 AND 500000";}
          else if($by_price=='5'){$conditions[] = "a.harga_jual > 500000";}
          else {}
        }
        if($by_channel !="") {
          $conditions[] = "a.channel like '%".$this->db->escape_like_str($by_channel)."%'";
        }
        if($by_location !="") {
          $conditions[] = "e.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }
        if($indoloka !="all") {
            if($indoloka !="") {
              $conditions[] = "d.merchant_indoloka = '" . $this->db->escape_str($indoloka) . "'";
            } else {
              $conditions[] = "d.merchant_indoloka is null";
            }
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk desc LIMIT " . (int)$offset . ", " . (int)$limit . "";
        // var_dump($sql);exit;
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function export_produk_by_search_unverified_merchant($by_search='', $by_category='', $by_sales='', $by_status='', 
    $by_merchant='', $by_stok='', $by_from='', $by_to='', $by_feature='', $by_price='', $by_channel = '', $by_location='', $indoloka = '')
    {
        $sql = "select a.*, a.deskripsi as deskripsi_produk, a.deskripsi_en as deskripsi_produk_en, a.date_added as tgl_upload, a.date_modified as tgl_edit,
                a.date_verified as tgl_verified, a.date_unverified as tgl_unverified,
                d.*, e.nama_kabupaten, g.nama_kecamatan, h.nama_propinsi, f.*, j.nama_kategori
                from tbl_produk a
                left join tbl_produk_kategori b on a.id_produk=b.id_produk
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_user f on a.id_user=f.id_user
                left join tbl_kecamatan g on g.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten e on e.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi h on h.id_propinsi=d.id_propinsi
                left join tbl_produk_kategori i ON a.id_produk=i.id_produk
                left join tbl_kategori j ON i.id_kategori=j.id_kategori
                where a.deleted=0 and d.store_status !='approve' and a.id_parent is null";
        
        if($this->session->userdata('admin_session')->id_level == 8){
                    $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
                }
        
        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }
        if($by_sales !="") {
          $conditions[] = "d.id_sales='" . (int)$by_sales . "'";
        }
        if($by_status !="") {
          $conditions[] = "a.publish='" . (int)$by_status . "'";
        }
        if($by_merchant !="") {
          $conditions[] = "a.id_user='" . (int)$by_merchant . "'";
        }
        if($by_from !="" && $by_to !="") {
            $from = strftime("%Y-%m-%d",strtotime($by_from));
            $to = strftime("%Y-%m-%d",strtotime($by_to));
            $conditions[] = "(DATE(a.date_added) BETWEEN '$from' AND '$to')";
        }
        if($by_feature !="") {
            if($by_feature=="1") {$conditions[] = "a.unggulan='1'";}
            else if($by_feature=="2") {$conditions[] = "a.pick='1'";}
            else {}
        }
        if($by_stok !="") {
          if($by_stok=='1'){$conditions[] = "a.stok_produk < 10";}
          else if($by_stok=='2'){$conditions[] = "a.stok_produk BETWEEN 10 AND 100";}
          else if($by_stok=='3'){$conditions[] = "a.stok_produk BETWEEN 100 AND 1000";}
          else {}
        }
        if($by_price !="") {
          if($by_price=='1'){$conditions[] = "a.harga_jual < 50000";}
          else if($by_price=='2'){$conditions[] = "a.harga_jual BETWEEN 50000 AND 100000";}
          else if($by_price=='3'){$conditions[] = "a.harga_jual BETWEEN 100000 AND 250000";}
          else if($by_price=='4'){$conditions[] = "a.harga_jual BETWEEN 250000 AND 500000";}
          else if($by_price=='5'){$conditions[] = "a.harga_jual > 500000";}
          else {}
        }
        if($by_channel !="") {
          $conditions[] = "a.channel like '%".$this->db->escape_like_str($by_channel)."%'";
        }
        if($by_location !="") {
          $conditions[] = "e.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }

        if($indoloka !="all") {
            if($indoloka !="") {
              $conditions[] = "d.merchant_indoloka = '" . $this->db->escape_str($indoloka) . "'";
            } else {
              $conditions[] = "d.merchant_indoloka is null";
            }
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk desc ";
        // echo $sql;exit;
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_produk_user_by_search($id = '', $by_search='', $by_category='', $by_stat='', $limit = '', $offset = '')
    {
        $sql = "select a.*, c.image
                from tbl_produk a
                left join tbl_produk_kategori b
                on a.id_produk=b.id_produk
                left join tbl_produkfoto c
                on a.id_produk=c.id_produk
                where a.id_user='" . $id . "' and a.deleted=0 and a.id_parent is null";

        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }
        if($by_stat !="") {
            if ($by_stat == 'verified') {
                $conditions[] = "a.publish = 1";
            } else if ($by_stat == 'moderasi') {
                $conditions[] = "a.publish = 0";
            } else if ($by_stat == 'unverified') {
                $conditions[] = "a.publish = 2";
            } else {

            }
            
        }

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk desc LIMIT " . (int)$offset . ", " . (int)$limit . "";

        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_produk_indoloka_by_search($kode, $by_search='', $by_category='', $limit = '', $offset = '')
    {
        $sql = "select a.*, c.image
                from tbl_produk a
                left join tbl_produk_kategori b
                on a.id_produk=b.id_produk
                left join tbl_produkfoto c
                on a.id_produk=c.id_produk
                left join tbl_store d on a.id_store = d.id_store
                where d.merchant_indoloka = '".$kode."' and a.deleted=0";

        $conditions = array();
        if($by_search !="") {
          $conditions[] = "a.nama_produk LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_category !="") {
          $conditions[] = "b.id_kategori='" . (int)$by_category . "'";
        }

        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_produk desc LIMIT " . (int)$offset . ", " . (int)$limit . "";

        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_produk_other($id = '', $offset = '', $limit = '')
    {
        $db = $this->getReadDb();
        $id_user = $db->query("select id_user from tbl_produk where id_produk='" . (int)$id . "'");
        $idu = $id_user->row();
        $sql = "select a.*, b.image, c.username, c.image as merchant_image, d.count_comment, s.nama_store 
            from tbl_produk a
            join tbl_produkfoto b on a.id_produk=b.id_produk
            join tbl_user c on a.id_user=c.id_user
            join tbl_store s on s.id_user = a.id_user
            left join view_comment d on a.id_produk=d.id_produk
            where a.id_produk!='" . (int)$id . "' and a.id_user='" . (int)$idu->id_user . "' and a.deleted=0 and a.publish='1' and show_on_listing = '1' 
            and a.channel != 'MATRIX' 
            and a.channel != 'WHOLESALE'
            and a.id_parent is null group by id_produk DESC LIMIT " . (int)$offset . ", " . (int)$limit . "";
        $q = $db->query($sql);
        $data = array();
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_produk_varian($id = '')
    {
        $db = $this->getReadDb();
        $sql = "select a.*, b.image
            from tbl_produk a
            join tbl_produkfoto b on a.id_produk = b.id_produk
            where a.id_parent = '" . (int)$id . "' and a.deleted = 0 and a.publish = '1'
            group by id_produk ORDER BY harga_jual ASC, id_produk DESC, date_added DESC, nama_produk ASC";
             // LIMIT " . $offset . ", " . $limit . "";
        $q = $db->query($sql);
        $data = array();
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function get_produk_varian_user($id = '')
    {
        $db = $this->getReadDb();
        $sql = "select a.*, b.image
            from tbl_produk a
            join tbl_produkfoto b on a.id_produk = b.id_produk
            where a.id_parent = '" . (int)$id . "' and a.deleted = 0
            group by id_produk ORDER BY date_added DESC, nama_produk ASC, id_produk DESC";
             // LIMIT " . $offset . ", " . $limit . "";
        $q = $db->query($sql);
        $data = array();
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_produk_parent($id = '')
    {
        $db = $this->getReadDb();
        $sql = "select a.*, b.image
            from tbl_produk a
            join tbl_produkfoto b on a.id_produk = b.id_produk
            where a.id_produk = '" . (int)$id . "' and a.deleted = 0 and a.publish = '1'";
        $q = $db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data;        
    }

    function get_foto($id = '')
    {
        $db = $this->getReadDb();
        $sql = "select * from tbl_produkfoto where id_produk='" . (int)$id . "'";
        $q = $db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_tag($id = '')
    {
        $sql = "select b.nama_tag from tbl_produk_tag a, tbl_tag b where a.id_tag = b.id_tag and id_produk='" . (int)$id . "'";
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function count_tag($id = '')
    {
        $sql = "select b.nama_tag from tbl_produk_tag a, tbl_tag b where a.id_tag = b.id_tag and id_produk='" . (int)$id . "'";
        $q = $this->db->query($sql);
        $data = $q->num_rows();
        $q->free_result();
        return $data;
    }

    function clear_tag($id = '')
    {

        $sql = "DELETE FROM tbl_produk_tag WHERE id_produk='" . (int)$id . "'";

        $this->db->query($sql);
    }

    function get_category($parentId = 0)
    {
        $catgArray = array();
        $sql = $this->db->query("SELECT * FROM tbl_kategori where id_parent=" . (int)$parentId . "");
        if ($sql->num_rows() > 0)
        {
            echo '<ul>';
            foreach ($sql->result() as $mainCatg) {
                echo '<li>';
                echo $mainCatg->nama_kategori;
                $this->get_category($mainCatg->id_kategori);
                echo '</li>';
            }
            echo '</ul>';
        }
    }

    function get_select_category($parentId = 0, $level = 0, $activeCategoryId = null, $channel='')
    {
        $catgArray = array();
        $channel_parram = '';
        if(!empty($channel)){
            $channel_parram = " AND channel = '".$channel."'";
        }

        $sql = "SELECT * FROM tbl_kategori where id_parent=" . (int)$parentId . $channel_parram. " and `show` = '1'";
        $query = $this->db->query($sql);

        foreach ($query->result() as $row)
        {
            echo '<option ';
            echo ($activeCategoryId == $row->id_kategori) ? 'selected ' : '';
            echo 'value="' . $row->id_kategori . '">';
            echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . ucwords($row->nama_kategori);
            $this->get_select_category($row->id_kategori, $level + 1, $activeCategoryId );
            echo '</option>';
        }
    }

    function get_select_category_merchant($parentId = 0, $level = 0, $activeCategoryId = null, $produk_array, $channel='')
    {
        $catgArray = array();
        $channel_parram = '';
        if(!empty($channel)){
            $channel_parram = " AND k.channel = '".$channel."'";
        }

        $implode_produk = implode(" , ", $produk_array);

        $sql = "SELECT * FROM tbl_kategori k left join tbl_produk_kategori pk on k.id_kategori = pk.id_kategori where k.id_parent=" . (int)$parentId . $channel_parram. " and pk.id_produk in (".$implode_produk.") and k.show = '1' group by k.id_kategori";
        $query = $this->db->query($sql);

        foreach ($query->result() as $row)
        {
            echo '<option ';
            echo ($activeCategoryId == $row->id_kategori) ? 'selected ' : '';
            echo 'value="' . $row->id_kategori . '">';
            echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . ucwords($row->nama_kategori);
            $this->get_select_category_merchant($row->id_kategori, $level + 1, $activeCategoryId, $produk_array );
            echo '</option>';
        }
    }

    function get_select_category_edit($parentId = 0, $level = 0, $key = '')
    {
        $catgArray = array();
        $sql = $this->db->query("SELECT * FROM tbl_kategori where id_parent=" . (int)$parentId . "");
        if ($sql->num_rows() > 0)
        {
            foreach ($sql->result() as $mainCatg) {
                echo '<option value="' . $mainCatg->id_kategori . '" ' . $key . '>';
                echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . ucwords($mainCatg->nama_kategori);
                $this->get_select_category($mainCatg->id_kategori, $level + 1, $key);
                echo '</option>';
            }
        }
    }

    function get_product_wishlist($id_user)
    {
        $sql = "SELECT p.*, pf.image FROM tbl_love l, tbl_produk p , tbl_produkfoto pf where l.id_user=" . (int)$id_user . " and l.id_produk=p.id_produk and p.id_produk=pf.id_produk and p.deleted=0 group by p.id_produk ORDER by p.id_produk DESC;";
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function count_product_user($table='', $field='', $key=''){
        $sql = "select count(*) as jumlah from ".$table." WHERE ".$field."='". $this->db->escape_str($key) ."' and deleted=0 and id_parent is null";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }

    function count_product_indoloka($kode){
        $sql = "select count(*) as jumlah 
            from tbl_produk a
            left join tbl_store b on a.id_user = b.id_user
            WHERE b.merchant_indoloka = '".$kode."' and a.deleted=0";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }

    function count_all_product(){
        $sql = "select count(*) as jumlah from tbl_produk WHERE deleted=0 AND id_parent is null";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function count_produk_varian($id = '')
    {
        $sql = "select count(*) as jumlah
            from tbl_produk where id_parent = '" . (int)$id . "' and deleted = 0 and publish = '1'";
             // LIMIT " . $offset . ", " . $limit . "";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function count_produk_varian_user($id = '')
    {
        $sql = "select count(*) as jumlah
            from tbl_produk where id_parent = '" . (int)$id . "' and deleted = 0";
             // LIMIT " . $offset . ", " . $limit . "";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function count_all_product_status($status = ''){
        $sql = "select count(*) as jumlah from tbl_produk a
                left join tbl_user c on a.id_user=c.id_user
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_kecamatan e on e.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten b on b.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi f on f.id_propinsi=d.id_propinsi
                where a.deleted=0 and a.publish=". (int)$status ." and d.store_status='approve'";
        if ($status != 0){
            $sql .= " and a.id_parent is null";
        }
        
        if($this->session->userdata('admin_session')->id_level == 8){
            $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
        }
        
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function count_all_product_unverified_merchant(){
        $sql = "select count(*) as jumlah from tbl_produk a
                left join tbl_user c on a.id_user=c.id_user
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_kecamatan e on e.id_kecamatan=d.id_kecamatan
                left join tbl_kabupaten b on b.id_kabupaten=d.id_kabupaten
                left join tbl_propinsi f on f.id_propinsi=d.id_propinsi
                where a.deleted=0 and d.store_status != 'approve' and a.id_parent is null";
        if($this->session->userdata('admin_session')->id_level == 8){
            $sql .= " AND d.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
        }
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function count_product_verified_merchant($id=''){
        $sql = "select count(*) as jumlah from tbl_produk WHERE id_user=". (int)$id." and publish=1 and deleted=0";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function count_product_verified_merchant_array($arrayid){
//        $sql = "select count(*) as jumlah from tbl_produk WHERE id_user=". (int)$id." and deleted=0";
        $this->db->select('id_user');
        $this->db->select('count(*) as jumlah');
        $this->db->where_in('id_user', $arrayid);
        $this->db->where('deleted', '0');
        $this->db->where('publish', '1');
        $this->db->group_by(array("id_user")); 
        $q = $this->db->get('tbl_produk');
        $data_produk = $q->result();
        $data = array();
        foreach ($data_produk as $row){
            $data[$row->id_user] = $row;
        }
        
        return $data;
    }
    
    function count_product_unverified_merchant($id=''){
        $sql = "select count(*) as jumlah from tbl_produk WHERE id_user=". (int)$id." and publish=2 and deleted=0";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function count_product_unverified_merchant_array($arrayid){
//        $sql = "select count(*) as jumlah from tbl_produk WHERE id_user=". (int)$id." and deleted=0";
        $this->db->select('id_user');
        $this->db->select('count(*) as jumlah');
        $this->db->where_in('id_user', $arrayid);
        $this->db->where('deleted', '0');
        $this->db->where('publish', '2');
        $this->db->group_by(array("id_user")); 
        $q = $this->db->get('tbl_produk');
        $data_produk = $q->result();
        $data = array();
        foreach ($data_produk as $row){
            $data[$row->id_user] = $row;
        }
        
        return $data;
    }
    
    function count_product_moderasi_merchant($id=''){
        $sql = "select count(*) as jumlah from tbl_produk WHERE id_user=". (int)$id." and publish=0 and deleted=0";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function count_product_moderasi_merchant_array($arrayid){
//        $sql = "select count(*) as jumlah from tbl_produk WHERE id_user=". (int)$id." and deleted=0";
        $this->db->select('id_user');
        $this->db->select('count(*) as jumlah');
        $this->db->where_in('id_user', $arrayid);
        $this->db->where('deleted', '0');
        $this->db->where('publish', '0');
        $this->db->group_by(array("id_user")); 
        $q = $this->db->get('tbl_produk');
        $data_produk = $q->result();
        $data = array();
        foreach ($data_produk as $row){
            $data[$row->id_user] = $row;
        }
        
        return $data;
    }
    
    function count_product_all_merchant($id=''){
        $sql = "select count(*) as jumlah from tbl_produk WHERE id_user=". (int)$id." and deleted=0";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function count_product_all_merchant_array($arrayid){
//        $sql = "select count(*) as jumlah from tbl_produk WHERE id_user=". (int)$id." and deleted=0";
        $this->db->select('id_user');
        $this->db->select('count(*) as jumlah');
        $this->db->where_in('id_user', $arrayid);
        $this->db->where('deleted', '0');
        $this->db->group_by(array("id_user")); 
        $q = $this->db->get('tbl_produk');
        $data_produk = $q->result();
        $data = array();
        foreach ($data_produk as $row){
            $data[$row->id_user] = $row;
        }
        
        return $data;
    }

    function get_parent_category(){
        $sql="select * from tbl_kategori where id_parent=0";
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function get_list_logharga_byid($id = '') {
//         $sql = "select * from tbl_produk_logharga where id_produk ='" . (int)$id . "' ORDER BY `date_added` DESC";
// //        echo $sql;
//         $q = $this->db->query($sql);
//         $data = $q->result();
//         $q->free_result();
//         return $data;
        return [];
    }
    
    
    function get_select_category_x_fashion($parentId = 0, $level = 0, $activeCategoryId = null)
    {
        $catgArray = array();
        $sql = $this->db->query("select * from tbl_kategori where id_parent = '0' And id_kategori != '29'");
        if ($sql->num_rows() > 0)
        {
            foreach ($sql->result() as $mainCatg) {
                echo '<option ';
                echo ($activeCategoryId == $mainCatg->id_kategori) ? 'selected ' : '';
                echo 'value="' . $mainCatg->id_kategori . '">';
                echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . ucwords($mainCatg->nama_kategori);
                $this->get_select_category($mainCatg->id_kategori, $level + 1, $activeCategoryId );
                echo '</option>';
            }
        }
    }
    
    function get_detail_produk($id_produk)
    {
        $query = "select id_produk,id_user,nama_produk,detail_paket,deskripsi, stok_produk, harga_produk, diskon, berat, panjang, lebar," .
                " tinggi, jne_berat,publish,harga_asli_merchant, blended_transaction_fee, blended_insentif_cipika," .
                " blended_shipping_fee_to_jakarta, selisih_pembulatan, harga_jual, deleted" .
                " from tbl_produk where id_produk=" . (int) $id_produk . ";";
        $q = $this->db->query($query);
        $data = $q->row();
        $q->free_result();
        return $data;
    }

    function get_produk_promo_diskon($id_produk)
    {
        $nowTime = date("H:i:s");
        $dateTime = date("Y:m:d");
        $query = "select pm.id_produk, pm.diskon from tbl_promo_marketing pm left join tbl_promo_time pt ".
                "on pm.id_promo_marketing = pt.id_promo_marketing where pt.time_start < '".$nowTime."' ".
                "and pt.time_end > '".$nowTime."' and pm.date_start <= '".$dateTime."' ".
                "and pm.date_end >= '".$dateTime."' and pm.id_produk = " . (int) $id_produk . ";";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            $data = $q->row();
        } else {
            $data = false;
        }
        $q->free_result();
        return $data;
    }
    
    function get_produk_promo_by_date($id_produk) {
        $dateTime = date('Y-m-d');
        $query = "select * from tbl_promo_marketing a "
                . "left join tbl_program_diskon b on a.id_program_diskon = b.id_program_diskon "
                . "where a.id_produk = " . $id_produk . " and a.date_start <= '" . $dateTime . "' and a.date_end >= '" . $dateTime . "';";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            $data = $q->row();
        } else {
            $data = false;
        }
        $q->free_result();
        return $data;
    }
    
    function get_all_produk_request_update($limit, $offset){
        $this->db->select("pru.date_request as tgl_request");
        $this->db->select("pru.date_approve as tgl_approve");
        $this->db->select("pru.status as status_request");
        $this->db->select("pru.data as data_update");
        $this->db->select("pru.data_json as data_update_json");
        $this->db->select("pru.id_produk_request");
        $this->db->select("s.*");
        $this->db->select("p.*");
        $this->db->select("ag.nama_agregator");
        $this->db->select("uad.username as nama_admin");
        $this->db->select("ued.username as nama_user_username");
        $this->db->select("ued.email as nama_user_email");
        $this->db->select("pr.nama_propinsi");
        $this->db->select("kb.nama_kabupaten");
        $this->db->select("kc.nama_kecamatan");
        $this->db->from("tbl_produk_request_update as pru");
        $this->db->join("tbl_produk as p", "pru.id_produk = p.id_produk", "LEFT");
        $this->db->join("tbl_store as s", "s.id_user = p.id_user", "LEFT");
        $this->db->join("tbl_agregator as ag","ag.kode_agregator = s.merchant_indoloka", "LEFT");
        $this->db->join("tbl_user as uad", "pru.id_admin = uad.id_user", "LEFT");
        $this->db->join("tbl_user as ued", "pru.id_user = ued.id_user", "LEFT");
        $this->db->join("tbl_kecamatan as kc", "s.id_kecamatan = kc.id_kecamatan", "LEFT");
        $this->db->join("tbl_propinsi as pr", "s.id_propinsi = pr.id_propinsi", "LEFT");
        $this->db->join("tbl_kabupaten as kb", "s.id_kabupaten = kb.id_kabupaten", "LEFT");
        $this->db->where("pru.status", 0);
        $this->db->order_by("pru.date_request", "DESC");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $data = $query->result();
        $query->free_result();
        return $data;
    }

    function get_all_produk_request_update_search($by_search='', $by_merchant='', $by_from='', $by_to='',
    $by_request = '' , $limit = '', $offset = '', $agregator = ''){
        $this->db->select("pru.date_request as tgl_request");
        $this->db->select("pru.date_approve as tgl_approve");
        $this->db->select("pru.status as status_request");
        $this->db->select("pru.data as data_update");
        $this->db->select("pru.data_json as data_update_json");
        $this->db->select("pru.id_produk_request");
        $this->db->select("s.*");
        $this->db->select("p.*");
        $this->db->select('ag.nama_agregator');
        $this->db->select("uad.username as nama_admin");
        $this->db->select("ued.username as nama_user_username");
        $this->db->select("ued.email as nama_user_email");
        $this->db->select("pr.nama_propinsi");
        $this->db->select("kb.nama_kabupaten");
        $this->db->select("kc.nama_kecamatan");
        $this->db->from("tbl_produk_request_update as pru");
        $this->db->join("tbl_produk as p", "pru.id_produk = p.id_produk", "LEFT");
        $this->db->join("tbl_store as s", "s.id_user = p.id_user", "LEFT");
        $this->db->join("tbl_agregator as ag","ag.kode_agregator = s.merchant_indoloka", "LEFT");
        $this->db->join("tbl_user as uad", "pru.id_admin = uad.id_user", "LEFT");
        $this->db->join("tbl_user as ued", "pru.id_user = ued.id_user", "LEFT");
        $this->db->join("tbl_kecamatan as kc", "s.id_kecamatan = kc.id_kecamatan", "LEFT");
        $this->db->join("tbl_propinsi as pr", "s.id_propinsi = pr.id_propinsi", "LEFT");
        $this->db->join("tbl_kabupaten as kb", "s.id_kabupaten = kb.id_kabupaten", "LEFT");
        $this->db->where("pru.status", 0);
        if($by_search !="") {
            $this->db->like("p.nama_produk", $by_search);
        }
        if($by_merchant !="") {
            $this->db->where("s.id_user", $by_merchant);
        }
        if($by_from !="") {
            $this->db->where("pru.date_request >=", strftime("%Y-%m-%d",strtotime($by_from)));
        }
        if($by_to !="") {
            $this->db->where("pru.date_request <=", strftime("%Y-%m-%d",strtotime($by_to)));
        }
        if($by_request !="") {
            $this->db->like("ued.username", $by_request);
        }
        if ($agregator != "") {
            $this->db->where("ag.kode_agregator", $agregator);
        }
        $this->db->order_by("pru.date_request", "DESC");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $data = $query->result();
        $query->free_result();
        return $data;
    }

    function count_all_produk_request_update(){
        $this->db->select("*");
        $this->db->from("tbl_produk_request_update as pru");
        $this->db->join("tbl_produk as p", "pru.id_produk = p.id_produk", "LEFT");
        $this->db->join("tbl_store as s", "s.id_user = p.id_user", "LEFT");
        $this->db->join("tbl_user as uag", "s.agregator = uag.id_user", "LEFT");
        $this->db->join("tbl_user as uad", "pru.id_admin = uad.id_user", "LEFT");
        $this->db->join("tbl_user as ued", "pru.id_user = ued.id_user", "LEFT");
        $this->db->join("tbl_kecamatan as kc", "s.id_kecamatan = kc.id_kecamatan", "LEFT");
        $this->db->join("tbl_propinsi as pr", "s.id_propinsi = pr.id_propinsi", "LEFT");
        $this->db->join("tbl_kabupaten as kb", "s.id_kabupaten = kb.id_kabupaten", "LEFT");
        $this->db->where("pru.status", 0);
        $this->db->order_by("pru.date_request", "DESC");
        $query = $this->db->get();
        $data = $query->num_rows();
        $query->free_result();
        return $data;
    }

    function count_all_produk_request_update_search($by_search='', $by_merchant='', $by_from='', $by_to='',
    $by_request = '', $agregator = "" ){
        $this->db->select("*");
        $this->db->from("tbl_produk_request_update as pru");
        $this->db->join("tbl_produk as p", "pru.id_produk = p.id_produk", "LEFT");
        $this->db->join("tbl_store as s", "s.id_user = p.id_user", "LEFT");
        $this->db->join("tbl_agregator as ag","ag.kode_agregator = s.merchant_indoloka");
        $this->db->join("tbl_user as uad", "pru.id_admin = uad.id_user", "LEFT");
        $this->db->join("tbl_user as ued", "pru.id_user = ued.id_user", "LEFT");
        $this->db->join("tbl_kecamatan as kc", "s.id_kecamatan = kc.id_kecamatan", "LEFT");
        $this->db->join("tbl_propinsi as pr", "s.id_propinsi = pr.id_propinsi", "LEFT");
        $this->db->join("tbl_kabupaten as kb", "s.id_kabupaten = kb.id_kabupaten", "LEFT");
        $this->db->where("pru.status", 0);
        if($by_search !="") {
            $this->db->like("p.nama_produk", $by_search);
        }
        if($by_merchant !="") {
            $this->db->where("s.id_user", $by_merchant);
        }
        if($by_from !="") {
            $this->db->where("pru.date_request >=", strftime("%Y-%m-%d",strtotime($by_from)));
        }
        if($by_to !="") {
            $this->db->where("pru.date_request <=", strftime("%Y-%m-%d",strtotime($by_to)));
        }
        if($by_request !="") {
            $this->db->like("ued.username", $by_request);
        }
        if ($agregator != "") {
            $this->db->where('ag.kode_agregator', $agregator);
        }
        $this->db->order_by("pru.date_request", "DESC");
        $query = $this->db->get();
        $data = $query->num_rows();
        $query->free_result();
        return $data;
    }
    
    function get_all_produk_request_update_merchant($limit, $offset, $id_user){
        $this->db->select("pru.date_request as tgl_request");
        $this->db->select("pru.date_approve as tgl_approve");
        $this->db->select("pru.status as status_request");
        $this->db->select("pru.data as data_update");
        $this->db->select("pru.data_json as data_update_json");
        $this->db->select("pru.id_produk_request");
        $this->db->select("s.*");
        $this->db->select("p.*");
        $this->db->select("uad.username as nama_admin");
        $this->db->select("pr.nama_propinsi");
        $this->db->select("kb.nama_kabupaten");
        $this->db->select("kc.nama_kecamatan");
        $this->db->select("pf.image");
        $this->db->from("tbl_produk_request_update as pru");
        $this->db->join("tbl_produk as p", "pru.id_produk = p.id_produk", "LEFT");
        $this->db->join("tbl_store as s", "s.id_user = p.id_user", "LEFT");
        $this->db->join("tbl_user as uag", "s.agregator = uag.id_user", "LEFT");
        $this->db->join("tbl_user as uad", "pru.id_admin = uad.id_user", "LEFT");
        $this->db->join("tbl_kecamatan as kc", "s.id_kecamatan = kc.id_kecamatan", "LEFT");
        $this->db->join("tbl_propinsi as pr", "s.id_propinsi = pr.id_propinsi", "LEFT");
        $this->db->join("tbl_kabupaten as kb", "s.id_kabupaten = kb.id_kabupaten", "LEFT");
        $this->db->join("tbl_produkfoto as pf", "pru.id_produk = pf.id_produk", "LEFT");
        $this->db->where("pru.status", 0);
        $this->db->where("pru.id_user", $id_user);
        $this->db->order_by("pru.date_request", "DESC");
        $this->db->group_by("pru.id_produk_request");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $data = $query->result();
        $query->free_result();
        return $data;
    }

    function get_all_produk_request_update_foto($id_produk_request){
        $this->db->select("*");
        $this->db->from("tbl_produk_request_update_foto");
        // $this->db->where("status", 0);
        $this->db->where("id_produk_request", $id_produk_request);
        $query = $this->db->get();
        $data = $query->result();
        $query->free_result();
        return $data;
    }
        
    function get_update_request($id_produk){
        $this->db->where('id_produk', $id_produk);
        $this->db->where('status', 0);
        
        $query = $this->db->get('tbl_produk_request_update');
        
        $result = $query->row();
        
        return $result;
    }
    
    function get_produk_promo_diskon_active($id_produk)
    {
        $dateTime = date("Y-m-d");
        $nowTime = date("H:i:s");
        $query = "select pm.id_produk from tbl_promo_marketing pm " .
                "where pm.date_start < '" . $dateTime . "' " .
                "and (SELECT COUNT(*) FROM `tbl_promo_time` pt " .
                "WHERE pt.id_promo_marketing = pm.id_promo_marketing" .
                " AND pt.time_start <= '$nowTime' and pt.time_end >= '$nowTime') > 0 " .
                "and pm.date_end > '" . $dateTime . "' and pm.id_produk = " . (int) $id_produk . ";";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            $data = $q->row();
        } else {
            $data = false;
        }
        $q->free_result();
        return $data;
    }
    
    function check_produk_promo_diskon_active($id_produk)
    {
        $dateTime = date("Y-m-d");
        $nowTime = date("H:i:s");
        $query = "select pm.id_produk from tbl_promo_marketing pm " .
                "where pm.date_start < '" . $dateTime . "' " .
                "and (SELECT COUNT(*) FROM `tbl_promo_time` pt " .
                "WHERE pt.id_promo_marketing = pm.id_promo_marketing" .
                " AND pt.time_start <= '$nowTime' and pt.time_end >= '$nowTime') > 0 " .
                "and pm.date_end > '" . $dateTime . "' and pm.id_produk = " . (int) $id_produk . ";";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            $data = $q->row();
        } else {
            $data = false;
        }
        $q->free_result();
        return $data;
    }

    function getRateProduk($id_produk)
    {
        $db = $this->getReadDb();
        $db->select_avg('rating_value', 'rating');
        $db->where('id_produk', $id_produk);
        $query = $db->get('tbl_rating');

        $row = $query->row();
        if ($row->rating == null) {
            return 0;
        } else {
            return $row->rating;
        }
    }

    function getRateUserProduk($id_produk, $id_user)
    {
        $this->db->select_avg('rating_value', 'rating');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('id_user_rating', $id_user);
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($row->rating == null) {
            return 0;
        } else {
            return $row->rating;
        }
    }

    function getRateAdminProduk($id_produk)
    {
        $this->db->select_avg('rating_value', 'rating');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('id_admin_rating IS NOT NULL');
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($row->rating == null) {
            return 0;
        } else {
            return $row->rating;
        }
    }

    function getRateSumProduk($id_produk)
    {
        $this->db->select_sum('rating_value', 'rating');
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($row->rating == null) {
            return 0;
        } else {
            return $row->rating;
        }
    }

    function getRateUserCount($id_produk)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function getRateLast($id_produk)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $this->db->limit(1, 0);
        $this->db->order_by("date_added", "desc"); 
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $row->date_added;
        } else {
            return '-';
        }
    }

    function getRate1($id_produk)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('rating_value', (int)1);
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function getRate2($id_produk)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('rating_value', (int)2);
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function getRate3($id_produk)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('rating_value', (int)3);
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function getRate4($id_produk)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('rating_value', (int)4);
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function getRate5($id_produk)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('rating_value', (int)5);
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function getAdminRate($id_produk)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('id_admin_rating IS NOT NULL');
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateAdminRate($id_produk, $id_admin, $rate){
        $data = array(
               'rating_value' => $rate,
            );
        $this->db->where('id_produk', $id_produk);
        $this->db->where('id_admin_rating', $id_admin);
        $this->db->update('tbl_rating', $data); 
    }

    function disableRate($id_produk, $id_user)
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->where('id_user_rating', $id_user);
        $query = $this->db->get('tbl_rating');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return "true";
        }else {
            return "false";
        }
    }

    function getAreaProduk($id_produk)
    {
        $this->db->select('*');
        $this->db->where('ap.id_produk', $id_produk);
        $this->db->from('tbl_area_produk ap');
        $this->db->join('tbl_kabupaten k', 'k.id_kabupaten = ap.id_kabupaten', 'LEFT');
        $this->db->join('tbl_propinsi p', 'p.id_propinsi = ap.id_propinsi', 'LEFT');
        $query = $this->db->get();

        return $query->result();
    }

    function getUserRate($id_produk, $id_user)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('id_user_rating IS NOT NULL');
        $query = $this->db->get('tbl_rating');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateUserRate($id_produk, $id_user, $rate){
        $data = array(
               'rating_value' => $rate,
            );
        $this->db->where('id_produk', $id_produk);
        $this->db->where('id_user_rating', $id_user);
        $this->db->update('tbl_rating', $data); 
    }

    public function getProdukDetail($id)
    {
        $sql = "select a.*, d.alamat as alamat_merchant, d.telpon as telpon_merchant, c.nama_kabupaten, b.*, d.nama_store, pf.image as images
				from tbl_produk a
                left join tbl_user b on a.id_user=b.id_user
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_kecamatan e on d.id_kecamatan=e.id_kecamatan
                left join tbl_kabupaten c on d.id_kabupaten=c.id_kabupaten
                left join tbl_produkfoto pf on pf.id_produk = a.id_produk
				where a.id_produk='" . (int)$id . "'";
        $sql = "select a.*, d.alamat as alamat_merchant, d.telpon as telpon_merchant, c.nama_kabupaten, d.nama_store, pf.image as images
				from tbl_produk a
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_kecamatan e on d.id_kecamatan=e.id_kecamatan
                left join tbl_kabupaten c on d.id_kabupaten=c.id_kabupaten
                left join tbl_produkfoto pf on pf.id_produk = a.id_produk
				where a.id_produk='" . (int)$id . "'";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data;
    }

    public function checkProdukVoucherReloadToday($idProduk, $phoneNumber)
    {
        $dateNow = date('Y-m-d');
        $sql = "select * from tbl_orderitem oi, tbl_order o, tbl_orderitem_voucher_reload oivr where oi.id_order = o.id_order and o.id_order = oivr.id_order and oivr.date_added < '" . $dateNow . " 23:00:00' and oivr.date_added > '" . $dateNow. " 00:00:00' and oivr.nomer_hp = '" . $this->db->escape_str($phoneNumber). "' and o.status_payment = 'paid';";
        $q = $this->db->query($sql);
        $data = $q->num_rows();
        $q->free_result();
        return $data;
    }
    
    public function countTerbeliByidProduk($id)
    {
        $db = $this->getReadDb();
        $db->select('sum(jml_produk) as jumlah');
        $db->where('id_produk',$id);
        $query = $db->get('tbl_orderitem');
        $data = $query->row();
        if ($data->jumlah > 0) {
            return $data->jumlah;
        } else {
            return 0;
        }
    }

    public function getCicilan($id_produk)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('deleted', 0);
        $query = $this->db->get('tbl_produk_cicilan');
        $data = $query->result();
        $query->free_result();
        return $data;
    }

    function get_kategori_array_produk($id){
        $this->db->select('pk.id_produk, pk.id_kategori, k.nama_kategori');
        $this->db->where('pk.id_produk', $id);
        $this->db->from("tbl_produk_kategori as pk");
        $this->db->join("tbl_kategori as k", "pk.id_kategori = k.id_kategori", "LEFT");
        $q = $this->db->get();
        $data_produk = $q->result();
        // echo $this->db->last_query();
        // exit();
        $data = array();
        foreach ($data_produk as $row){
            $data[] = $row;
        }
        
        return $data;
    }
    
    public function ResetIndex()
    {
        $dataUpdate = array('list_index' => '0');
        $this->db->update('tbl_produk',$dataUpdate);
    }
    
    function getAllKategoriProductByProductId($id)
    {
        $db = $this->db;
        $db->where('id_produk', $id);
        $query = $db->get('tbl_produk_kategori');
        $data = $query->result();
        $arr_id_kategori = array();
        foreach($data as $val) {
            $arr_id_kategori[] = $val->id_kategori;
        }
        return $arr_id_kategori;
    }

    public function insertBatchWholesaleRule($data)
    {
        $this->db->insert_batch('tbl_wholesale_rule',$data);
    }

    public function getKondisiPreorderByIdProdukArray($produk_arr)
    {
        $this->db->where_in('id_produk', $produk_arr);
        $query = $this->db->get('tbl_wholesale_rule');
        $data = $query->result();
        $grouped_kondisi = array();

        foreach ($produk_arr as $id_produk) {
            $grouped_kondisi[$id_produk] = null;
        }
        
        if (!empty($data)) {
            foreach ($data as $val) {
                $grouped_kondisi[$val->id_produk][] = $val;
            }
        }

        return $grouped_kondisi;
    }

    public function getKondisiPreorderByIdProduk($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get('tbl_wholesale_rule');
        return $query->result();
    }

    public function deleteWholesaleRuleByIdProduk($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->delete('tbl_wholesale_rule');
    }

    public function getProdukKelipatanById($id_produk)
    {
        $this->db->select('kelipatan');
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get('tbl_produk');
        $data = $query->row();
        if (!empty($data)) {
            if ($data->kelipatan > 1) {
                return $data->kelipatan;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

    public function getWholesaleByIdAndMinQty($id_produk, $qty)
    {
        $this->db->where('w.id_produk', $id_produk);
        $this->db->where("w.qty_minimal <= '".$qty."'");
        $this->db->order_by('w.qty_minimal', 'desc');
        $this->db->join('tbl_produk as p','p.id_produk = w.id_produk');
        $query = $this->db->get('tbl_wholesale_rule as w');
        return $query->row();
    }

    public function getKondisiWholesaleByIdProduk($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get('tbl_wholesale_rule');
        return $query->result();
    }

    public function getProdukApi($id = '', $by_search='', $by_category='', $by_stat='', $limit = '', $offset = '')
    {
        $this->db->select("p.id_produk");
        $this->db->select("p.id_parent");
        $this->db->select("p.nama_produk, p.deskripsi, p.detail_paket");
        $this->db->select("p.stok_produk, p.harga_produk");
        $this->db->select("p.berat, p.panjang, p.lebar, p.tinggi");
        $this->db->select("p.channel");
        $this->db->select("p.publish");
        $this->db->select("p.date_added");

        if($id !="") {
          $this->db->where('p.id_user', $id);
        }
        if($by_search !="") {
          $this->db->like('p.nama_produk', $by_search);
        }
        if($by_category !="") {
          $this->db->where('pk.id_kategori', $by_category);
        }
        if($by_stat !="") {
            if ($by_stat == 'verified') {
                $this->db->where('p.publish', 1);
            } else if ($by_stat == 'moderasi') {
                $this->db->where('p.publish', 0);
            } else if ($by_stat == 'unverified') {
                $this->db->where('p.publish', 2);
            }
        }
        $this->db->where('p.deleted', 0);
        $this->db->limit($limit, $offset);
        $this->db->join('tbl_produk_kategori pk', 'p.id_produk = pk.id_produk', 'left');
        $query = $this->db->get('tbl_produk p');
        $data = $query->result();
        $query->free_result();
        return $data;
    }

    public function getProdukApiSingle($id_produk, $id_user)
    {
        $this->db->select('*');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('tbl_produk');
        $data = $query->row();
        return $data;
    }

    function get_all_produk_by_term($term)
    {
        $sql = "select p.id_produk, p.nama_produk from tbl_produk p where p.nama_produk like '%" . $this->db->escape_like_str($term) . "%' and p.deleted = 0 and p.publish = 1 order by p.date_added desc";
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    public function isPromoTodayByIdProduk($id_produk)
    {
        //mercari promo yang habis karena quota stocknya sudah habis
        $this->db->select("count(id_produk) as jumlah");
        $this->db->where('id_produk', $id_produk);
        $this->db->where("date_start <= '".date("Y-m-d H:i:s")."'");
        $this->db->where("date_end >= '".date("Y-m-d H:i:s")."'");
        $query = $this->db->get('tbl_promo_marketing');
        $data = $query->row();

        if (!empty($data) && $data->jumlah > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_data_produk_program_promo($id_produk) {
        $db = $this->getReadDb();
        $query = "select 
                    a.id_produk, a.quota_per_day, a.date_end, a.quota,
                    (select sum(qty) as total from tbl_order_promo_marketing where id_produk = a.id_produk and date(date_added) = curdate()) as total,
                    (select sum(qty) from tbl_order_promo_marketing where id_produk = a.id_produk) as sold
                    from tbl_promo_marketing a 
                    where a.id_produk = " . $id_produk;
        $result = $db->query($query);
        return $result;
    }

    public function getProdukRequestById($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->where('status', '0');
        $query = $this->db->get('tbl_produk_request_update');
        $data = $query->row();

        if (!empty($data)) {
            $this->id_produk_request = $data->id_produk_request;

            if ($data->data_json != "") {
                return json_decode($data->data_json, true);
            } else {
                return json_decode($data->data, true);
            }
        } else {
            return array();
        }
    }

    public function getIdProdukRequest()
    {
        return $this->id_produk_request;
    }

    public function getSingleProdukById($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get('tbl_produk');
        return $query->row();
    }
    
    public function getProdukIdKategori($limit = '', $offset = '') {
        $this->db->select('id_produk, id_parent, nama_produk, id_kategori');
        $this->db->where('id_kategori', 0);
        $this->db->order_by('id_produk', 'desc');
        $this->db->limit($limit, $offset);
        return $this->db->get('tbl_produk');
        
    }
    
    public function getChildKategori($id_kategori) {
        $this->db->where('id_parent', $id_kategori);
        return $this->db->get('tbl_kategori');
    }

    function get_all_produk_disallowed_voucher($list_produkid='')
    {
        if (trim($list_produkid)=='') {$list_produkid='xxx';}
        $sql = "select a.*
                from tbl_produk a
                where a.allow_voucher_payment=0 and id_produk in (" . $list_produkid . ")";
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }    
    
    function soldout_show_by_id_produk($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->where("availabel_date IS NULL");
        $this->db->update('tbl_log_soldout', array('availabel_date' => date("Y-m-d H:i:s")));
    }

    public function isProdukImportAvailable($nama, $harga)
    {
        $this->db->like('nama_produk', $nama);
        $this->db->where('harga_produk', $harga);
        $query = $this->db->get('tbl_produk');
        $data = $query->row();
        if (empty($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_foto_request_update($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->where('status', 1);
        $query = $this->db->get('tbl_produk_request_update_foto');
        return $query->result();
    }
    
    function get_produk_by($condition = '')
    {
        $db = $this->getReadDb();
        $sql = "select a.*, d.alamat as alamat_merchant, d.telpon as telpon_merchant, c.nama_kabupaten, b.*, d.nama_store
				from tbl_produk a
                left join tbl_user b on a.id_user=b.id_user
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_kecamatan e on d.id_kecamatan=e.id_kecamatan
                left join tbl_kabupaten c on d.id_kabupaten=c.id_kabupaten
				where id_produk>0 and a.deleted = 0  ";
                if ($condition != '') {
                    $sql .= "and ".$condition."";
                } else {
                    $sql .= "and id_produk=0";
                }
        $q = $db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data;

        
    }

    function getIdKategori($limit, $channel) {
        $this->db->select('id_produk, nama_produk, id_kategori, publish');
        $this->db->where('publish', 1);
        $this->db->where('id_kategori', 0);
        $this->db->where('channel', $channel);
        $this->db->limit($limit);
        $this->db->order_by('id_produk', 'desc');
        return $this->db->get('tbl_produk');
    }
    
    function get_nama_kategori($id_produk) {
        $sql="select a.id_produk, a.id_kategori, b.nama_kategori
            from tbl_produk a
            left join tbl_kategori b on a.id_kategori = b.id_kategori
            where a.id_produk='". (int) $id_produk."'";
        $q=$this->db->query($sql);
        $data=$q->result();
        return $data;
    }
    
    function get_all_produk_user_edit_merchant($id = '')
    {
        $sql = "SELECT a.id_produk, a.nama_produk, a.stok_produk, a.harga_produk, a.harga_jual, a.diskon, a.diskon_rp, a.publish 
                FROM tbl_produk a WHERE a.id_user = " . (int) $id . " AND a.deleted = 0 
                GROUP BY a.id_produk ORDER BY a.id_produk DESC";
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function getProdukAdira() {
        $this->db->where('id_user', $this->config->item('adira_id_user'));
        $this->db->where('publish', 1);
        return $this->db->get('tbl_produk');
    }
    
    function checkProdukByNameStatus($product_name) {
        $this->db->where_in('publish', array(0));
        $this->db->where('nama_produk', $product_name);
        $q = $this->db->get('tbl_produk');
        $data = array();
        $data = $q->row();
        $q->free_result();
        return $data;
    }
    
    function get_produk_kategori_null($channel, $limit) {
        $sql = "SELECT id_produk, publish, deleted, id_kategori FROM tbl_produk "
                . "WHERE publish = 1 AND deleted = 0 AND id_kategori = 0 AND channel = '" . $channel . "' "
                . "LIMIT " . $limit;
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    
}
/* End of file  */
/* Location: ./application/models/ */
