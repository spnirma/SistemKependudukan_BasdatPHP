<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Merchant_m extends MY_Model 
{

	public function __construct()
	{
		parent::__construct();
		
	}
    
    /* 
        Author  : mdhb2
        Desc    : Get all sales (user level=3)        
        @return array all user with roles sales
    */
	function get_foto_bymerchant($id_store=''){
$id_store=282;		
		$sql="SELECT * FROM `tbl_merchants_files` a 
where a.id_store=".$id_store." and a.file_type='gallery'  and a.date_deleted is null";
		$q=$this->db->query($sql);
		$data=$q->result();
		$q->free_result();
		return $data;
	}

	function get_sales()
	{
		$sql = "select * from tbl_user where id_level=3  and deleted=0 order by firstname asc";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
	}
    
	function get_sumber()
	{
		$sql = "select distinct(sumber) from tbl_store where store_status='approve' and sumber<>'' and not isnull(sumber) order by sumber asc";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
	}
    /* 
        Author  : mdhb2
        Desc    : Get all provinsi
        @return array all provinsi
    */
	function get_provinsi()
	{
		$sql = "select * from tbl_propinsi order by nama_propinsi asc";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
	}
    
    /* 
        Author  : mdhb2
        Desc    : Get kota by provinsi
        @param int idprovinsi
        @return array city
    */
	function get_city($id)
	{
		$sql = "select * from tbl_kabupaten where id_propinsi=". (int)$id." order by nama_kabupaten asc";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
	}
    
    function get_merchant($start=0,$limit=50)
    {
        $sql = "select m.*,u.*,m.date_added as 'merchant_register_date', m.telpon as 'merchant_telp' from tbl_store m,tbl_user u where m.id_user=u.id_user and u.deleted=0 order by m.date_added DESC limit " . (int)$start . "," . (int)$limit;
        
        $query = $this->db->query($sql);
        $data=$query->result();
        $query->free_result();
        return $data;
  //       if($query->num_rows() > 0){
		// 	return $query->result(); 
		// }
    }
    
    function get_single_merchant($iduser)
    {
        $sql = "select m.*,u.*,m.id_kota as 'merchant_kota',m.telpon as 'merchant_telpon',"
                . " m.id_propinsi as 'merchant_propinsi',  m.id_kabupaten as 'merchant_kabupaten',  m.id_kecamatan as 'merchant_kecamatan',"
                . " m.merchant_hp as 'merchant_hp' , m.pic_email as 'merchant_email',"
                . " m.bank_nama as merchant_bank_nama, m.bank_norek as merchant_bank_norek,"
                . " m.bank_pemilik as merchant_bank_pemilik, m.alamat as alamat_merchant"
                . " from tbl_store m left join tbl_user u on m.id_user=u.id_user where u.id_user=".(int)$iduser." limit 0,1";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			return $query->row(); 
		}
    }
    
    function get_merchant_product($iduser,$start=0,$limit=20)
    {
        $sql = "select p.*,m.*,u.* from tbl_produk p,tbl_store m,tbl_user u where u.id_user=".(int)$iduser." AND m.id_user=u.id_user AND p.id_user=u.id_user order by p.id_produk desc limit $start,$limit";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
    }
    
    /* Order *********************************************************************************************/    
    
    /* 
        Author  : mdhb2
        Desc    : Get all order detail, buyer,shipping,order item
        @param int id_order
        @return array order detail
    */
    function get_order($idorder)
    {
        $sql = "select *,o.date_added as 'order_date',o.id_user as 'id_buyer',u.email as 'user_email',u.telpon as 'user_telpon',u.id_kecamatan as 'user_idkecamatan' 
            from tbl_order o,
			tbl_user u,
			tbl_ordershipping os,
            tbl_store s where os.id_order=o.id_order 
            and s.id_user = o.id_merchant
            and o.id_user=u.id_user and o.id_order=".(int)$idorder." limit 0,1";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			$result['order'] = $query->row(); 
            
            $sql2 = "select oi.*, oi.harga as harga_jual_order from tbl_orderitem oi where oi.id_order=". (int)$idorder." order by oi.id_orderitem asc";
            $query2 = $this->db->query($sql2);
            if($query2->num_rows() > 0){
                $result['items'] = $query2->result(); 
            }
            
            $sql3 = "select * from tbl_ordershipping where id_order=". (int)$idorder." order by id_OrderShipping asc";
            $query3 = $this->db->query($sql3);
            if($query3->num_rows() > 0){
                $result['shipping'] = $query3->row(); 
            }
            
            return $result;
		}
    }
    
    function get_order_adira($id_order_insurance) {
        $sql = "SELECT a.id_insurance, a.kode_invoice, a.id_order_insurance, a.id_order_main, b.kode_order, c.*
                FROM tbl_order_insurance a 
                LEFT JOIN tbl_order b ON a.id_order_main = b.id_order
                LEFT JOIN tbl_orderitem c ON a.id_order_main = c.id_order
                WHERE a.id_order_insurance = " . $id_order_insurance;
        $query = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    
    
    function get_order_payment($kode_order)
    {
        $sql = "select * from tbl_payment_buyers where kode_order='". $this->db->escape_str($kode_order) ."' limit 0,1";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			return $query->row(); 
		}
    }

    function editable_order($idorder)
    {        
        $sql = "select * from tbl_order 
            where (((TIMESTAMPDIFF(DAY, date(date_added), NOW()) < 2
            OR status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') )
            OR (TIMESTAMPDIFF(DAY, date(date_added), NOW()) < 2
            AND status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') ) )
            OR (status_settlement is null or status_settlement = 7))
            AND id_order=". (int)$idorder;
        
        // echo $sql;
        // exit();

        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return TRUE; 
        }else{
            return FALSE; 
        }
    }
    
    function get_merchant_order($idmerchant,$start=0,$limit=100,$paid_status='')
    {        
        $sql = "select * from tbl_order 
            where ((TIMESTAMPDIFF(DAY, date(date_added), NOW()) <= 2
            OR status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') )
            OR (TIMESTAMPDIFF(DAY, date(date_added), NOW()) <= 2
            AND status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') ) )
            AND id_merchant=". (int)$idmerchant;
        
        if($paid_status!=''){
            $sql.=" AND (status_payment='". $this->db->escape_str($paid_status) ."' ";
            $sql.=" OR status_payment='refund') ";
        }
        
        $sql.=" order by date_added desc limit " . (int)$start . "," . (int)$limit;
        // echo $sql;
        // exit();

        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
    }
    
    function get_merchant_order_adira($idmerchant,$start=0,$limit=100)
    {        
        $sql = "SELECT 
                a.*, 
                b.id_order, b.kode_invoice, b.kode_order, b.status_payment, b.total_merchant, b.original_shipping_fee, b.ongkir_merchant, b.status_response_merchant, b.shipping_vendor,  
                c.status_payment, c.status_delivery
                FROM tbl_order_insurance a 
                LEFT JOIN tbl_order b ON b.id_order = a.id_order_insurance
                LEFT JOIN tbl_order c ON c.id_order = a.id_order_main
                WHERE 
                b.status_payment = 'paid' 
                AND b.id_merchant = " . $idmerchant . "
                AND c.status_payment IN ('paid', 'refund') 
                AND c.status_delivery = 'produk telah diterima' 
                AND TIMESTAMPDIFF(DAY, DATE(b.date_added), NOW()) <= 2 ";
        
        $sql.= "ORDER BY a.date_added DESC LIMIT " . (int)$start . "," . (int)$limit;

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    
    function get_merchant_order_adira_count($idmerchant,$start=0,$limit=100)
    {        
        $sql = "SELECT 
                a.*, 
                b.id_order, b.kode_invoice, b.kode_order, b.status_payment, b.total_merchant, b.original_shipping_fee, b.ongkir_merchant, b.status_response_merchant, b.shipping_vendor,  
                c.status_payment, c.status_delivery
                FROM tbl_order_insurance a 
                LEFT JOIN tbl_order b ON b.id_order = a.id_order_insurance
                LEFT JOIN tbl_order c ON c.id_order = a.id_order_main
                WHERE 
                b.status_payment = 'paid' 
                AND b.id_merchant = " . $idmerchant . "
                AND c.status_payment IN ('paid', 'refund') 
                AND c.status_delivery = 'produk telah diterima' 
                AND TIMESTAMPDIFF(DAY, DATE(b.date_added), NOW()) <= 2 ";

        $query = $this->db->query($sql);
        return $query->num_rows(); 
    }
    
    function get_merchant_single_order_adira($idmerchant, $id_order)
    {        
        $sql = "SELECT 
                a.*, 
                b.id_order, b.kode_invoice, b.kode_order, b.id_merchant, b.status_payment, b.total_merchant, b.original_shipping_fee, b.ongkir_merchant, b.status_response_merchant, b.shipping_vendor,  
                c.status_payment, c.status_delivery
                FROM tbl_order_insurance a 
                LEFT JOIN tbl_order b ON b.id_order = a.id_order_insurance
                LEFT JOIN tbl_order c ON c.id_order = a.id_order_main
                WHERE a.id_order_insurance = " . $id_order . " AND b.status_payment = 'paid' AND b.id_merchant = " . $idmerchant . " AND c.status_payment IN ('paid', 'refund') AND c.status_delivery = 'produk telah diterima' ";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function get_merchant_order_by_search($idmerchant,$start=0,$limit=100,$paid_status='', $kode_order, $date_start, $date_end, $pengiriman)
    {        
        $sql = "select * from tbl_order 
            where ((TIMESTAMPDIFF(DAY, date(date_added), NOW()) < 2
            OR status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') )
            OR (TIMESTAMPDIFF(DAY, date(date_added), NOW()) < 2
            AND status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') ) )
            AND id_merchant=". (int)$idmerchant;
        
        if($paid_status!=''){
            $sql.=" AND (status_payment='". $this->db->escape_str($paid_status) ."' ";
            $sql.=" OR status_payment='refund') ";
        }
        if($kode_order !=''){
            $sql.=" AND kode_order='". $this->db->escape_str($kode_order) ."' ";
        }
        if($date_start !=''){
            $sql.=" AND date_added >= '". $this->db->escape_str($date_start) ."' ";
        }
        if($date_end !=''){
            $sql.=" AND date_added <= '". $this->db->escape_str($date_end) ."' ";
        }
        
        if($pengiriman !="") {
          if($pengiriman=='1'){ $sql.= " AND status_delivery='persiapan pengiriman'";}
          else if($pengiriman=='2'){$sql.= " AND status_delivery='proses pengiriman'";}
          else if($pengiriman=='3'){$sql.= " AND status_delivery='produk telah diterima'";}
          else if($pengiriman=='4'){$sql.= " AND status_delivery='proses retur'";}
        }
        
        $sql.=" order by date_added desc limit " . (int)$start . "," . (int)$limit;
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result(); 
        }
    }

    function get_merchant_order_export($idmerchant, $paid_status='', $kode_order, $date_start, $date_end, $pengiriman)
    {        
        $sql = "select distinct a.kode_order, a.*, a.kode_invoice as kode_invoice2, g.nama_payment, i.*, j.*,
                j.nama as nama_pelanggan_shipping, j.alamat as alamat_pelanggan_shipping,
                j.telpon as no_hp_pelanggan_shipping,
                k.*, i.harga as harga_web, i.harga_merchant as harga_merchant, a.date_added as tanggal_order, ia.*, ia.nama as nama_pelanggan,
                pb.msisdn as payment_dompetku, pb.payment as payment_jen, pb.respond as pay_acc,
                pp.nama as nama_program, vl.*
                from tbl_orderitem i
                left join tbl_order a on a.id_order = i.id_order
                left join tbl_user b on a.id_merchant=b.id_user
                left join tbl_user c on a.id_user=c.id_user
                left join tbl_store d on a.id_merchant=d.id_user
                left join tbl_ordershipping j on a.id_order = j.id_order
                left join tbl_invoice_address as ia on a.kode_invoice = ia.kode_invoice
                left join tbl_payment g on a.id_payment = g.id_payment
                left join tbl_produk k on k.id_produk = i.id_produk 
                left join tbl_invoices inv on inv.kode_invoice = a.kode_invoice
                left join tbl_payment_buyers pb on pb.kode_order like CONCAT('%',a.kode_invoice, '%') and inv.total+inv.ongkir+.inv.payment_fee = pb.amount 
                left join tbl_voucher_log vl on a.kode_invoice = vl.kode_invoice 
                left join tbl_voucher v on vl.kode_voucher = v.kode_voucher
                left join tbl_program_promo pp on pp.id_program_promo = v.id_program_promo
            where ((TIMESTAMPDIFF(DAY, date(a.date_added), NOW()) < 2
            OR status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') )
            OR (TIMESTAMPDIFF(DAY, date(a.date_added), NOW()) < 2
            AND status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') ) )
            AND a.id_merchant=". (int)$idmerchant;
        
        if($paid_status!=''){
            $sql.=" AND (a.status_payment='". $this->db->escape_str($paid_status) ."' ";
            $sql.=" OR a.status_payment='refund') ";
        }
        if($kode_order !=''){
            $sql.=" AND a.kode_order='". $this->db->escape_str($kode_order) ."' ";
        }
        if($date_start !=''){
            $sql.=" AND a.date_added >= '". $this->db->escape_str($date_start) ."' ";
        }
        if($date_end !=''){
            $sql.=" AND a.date_added <= '". $this->db->escape_str($date_end) ."' ";
        }
        
        if($pengiriman !="") {
          if($pengiriman=='1'){ $sql.= " AND a.status_delivery='persiapan pengiriman'";}
          else if($pengiriman=='2'){$sql.= " AND a.status_delivery='proses pengiriman'";}
          else if($pengiriman=='3'){$sql.= " AND a.status_delivery='produk telah diterima'";}
          else if($pengiriman=='4'){$sql.= " AND a.status_delivery='proses retur'";}
        }
        
        $sql.=" order by a.date_added desc ";
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result(); 
        }
    }

    function get_merchant_order_count($idmerchant, $paid_status='')
    {        
        $sql = "select * from tbl_order 
            where ((TIMESTAMPDIFF(DAY, date(date_added), NOW()) < 2
            OR status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') )
            OR (TIMESTAMPDIFF(DAY, date(date_added), NOW()) < 2
            AND status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') ) )
            AND id_merchant=". (int)$idmerchant;
        
        if($paid_status!=''){
            $sql.=" AND (status_payment='". $this->db->escape_str($paid_status) ."' ";
            $sql.=" OR status_payment='refund') ";
        }

        $query = $this->db->query($sql);
        return $query->num_rows(); 
    }

    function get_merchant_order_count_by_search($idmerchant, $paid_status='' ,$kode_order, $date_start, $date_end, $pengiriman)
    {        
        $sql = "select * from tbl_order 
            where ((TIMESTAMPDIFF(DAY, date(date_added), NOW()) < 2
            OR status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') )
            OR (TIMESTAMPDIFF(DAY, date(date_added), NOW()) < 2
            AND status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') ) )
            AND id_merchant=". (int)$idmerchant;
        
        if($paid_status!=''){
            $sql.=" AND (status_payment='". $this->db->escape_str($paid_status) ."' ";
            $sql.=" OR status_payment='refund') ";
        }
        if($kode_order !=''){
            $sql.=" AND kode_order='". $this->db->escape_str($kode_order) ."' ";
        }
        if($date_start !=''){
            $sql.=" AND date_added >= '". $this->db->escape_str($date_start) ."' ";
        }
        if($date_end !=''){
            $sql.=" AND date_added <= '". $this->db->escape_str($date_end) ."' ";
        }

        if($pengiriman !="") {
          if($pengiriman=='1'){ $sql.= " AND status_delivery='persiapan pengiriman'";}
          else if($pengiriman=='2'){$sql.= " AND status_delivery='proses pengiriman'";}
          else if($pengiriman=='3'){$sql.= " AND status_delivery='produk telah diterima'";}
          else if($pengiriman=='4'){$sql.= " AND status_delivery='proses retur'";}
        }


                
        $query = $this->db->query($sql);
        return $query->num_rows(); 
    }
    
    function get_order_total($id_order)
    {
        $sql = "SELECT sum(diskon) as 'total_diskon',sum(harga*jml_produk) as 'total_harga', sum(total) 'grand_total' FROM `tbl_orderitem` where id_order=". (int)$id_order;
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			return $query->row(); 
		}
    }
    
    function get_indoloka_order($start=0,$limit=100,$paid_status='', $kode_agregator)
    {
        $sql = "select * from tbl_order a
            left join tbl_store b on a.id_merchant = b.id_user
            where TIMESTAMPDIFF(DAY, date(a.date_added), NOW()) < 2
            AND b.merchant_indoloka = '".$kode_agregator."'";
        
        if($paid_status!=''){
            $sql.=" AND a.status_payment='". $this->db->escape_str($paid_status) ."' ";
        }
        
        $sql.=" order by a.date_added desc limit " . (int)$start . "," . (int)$limit;
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result(); 
        }
    }
    
    /* 
        Author  : alie
        Desc    : check status merchants
        @param int id_user
        @return data store
    */
    
    function check_merchant_type($id_user)
    {
        $sql = "SELECT `merchant_indoloka`, `indoloka_type`  FROM `tbl_store` WHERE `id_user` = '" . (int)$id_user . "'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row_object();
        }
    }
    
    /*
     * Author   : Afandi
     * Desc     : Mencari kota origin jne
     * @return  : data origin jne
     * 
     */
    
    function get_jne_origin() {
        $sql = "select * from jne_origin order by display_name asc";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function get_binaan() {
        $sql = "select * from tbl_binaan where bn_event=".EVENTID." order by bn_number, bn_name asc";
//echo $sql;die;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    
    function get_autocomplete($term){
        $sql = "select * from tbl_store WHERE nama_store LIKE '%". $this->db->escape_like_str($term) ."%'";
        
        if($this->session->userdata('admin_session')->id_level == 8){
            $sql .= " AND agregator = ". (int)$this->session->userdata('admin_session')->id_user;
        }
        
        $sql .= " order by nama_store asc";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    
    function unverified_produk($id){
        $id_user = $this->get_single('tbl_store', 'id_store', $id);
        
        $data_produk = $this->get_data_where2('tbl_produk', 'id_user', $id_user->id_user, 'publish !=', '2');
        
        $unverified_data = array('publish' => '2',
            'alasan_ditolak' => 'unverified merchant',
            'date_unverified' => date('Y-m-d H:i:s'),
            'unverified_by' => $this->session->userdata('admin_session')->username
        );
		
        $unverified_update=false;
		
        foreach($data_produk as $row){
            $unverified_update = $this->update('tbl_produk', 'id_produk', (int)$row->id_produk, $unverified_data);
        
            $log = $this->user_m->insert('tbl_produk_status_log', array(
                'id_produk' => $row->id_produk, 
                'id_admin' => $this->session->userdata('admin_session')->id_user, 
                'status' => 'Unverifikasi', 
                'date_added' => date('Y-m-d H:i:s')
            ));
            
        }
                
        if($unverified_update){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }
    
    function get_agregator_array($arrayagregator){
        $this->db->select('*');
        $this->db->where_in('id_user', $arrayagregator);
        $query_data = $this->db->get('tbl_user');
        $data_agregator = $query_data->result();
        $data = array();
        foreach ($data_agregator as $row){
            $data[$row->id_user] = $row;
        }
        return $data;
    }
    
    function get_sales_array($arraysales){
        $this->db->select('*');
        $this->db->where_in('id_user', $arraysales);
        $query_data = $this->db->get('tbl_user');
        $data_sales = $query_data->result();
        $data = array();
        foreach ($data_sales as $row){
            $data[$row->id_user] = $row;
        }
        return $data;
    }

    function getAreaMerchant($id_user) {
        $this->db->select('*');
        $this->db->where('am.id_user', $id_user);
        $this->db->from('tbl_area_merchant am');
        $this->db->join('tbl_kabupaten k', 'k.id_kabupaten = am.id_kabupaten', 'LEFT');
        $this->db->join('tbl_propinsi p', 'p.id_propinsi = am.id_propinsi', 'LEFT');
        $query = $this->db->get();

        return $query->result();
    }

    function get_merchant_order_detail_api($idmerchant, $offset='',$limit='', $paid_status='', $kode_order, $date_start, $date_end, $pengiriman)
    {        
        $sql = "select distinct a.kode_order, a.*, a.kode_invoice as kode_invoice2, g.nama_payment, i.*, j.*,
                j.nama as nama_pelanggan_shipping, j.alamat as alamat_pelanggan_shipping,
                j.telpon as no_hp_pelanggan_shipping,
                k.*, i.harga as harga_web, i.harga_merchant as harga_merchant, a.date_added as tanggal_order, ia.*, ia.nama as nama_pelanggan,
                pb.msisdn as payment_dompetku, pb.payment as payment_jen, pb.respond as pay_acc,
                pp.nama as nama_program, vl.*
                from tbl_orderitem i
                left join tbl_order a on a.id_order = i.id_order
                left join tbl_user b on a.id_merchant=b.id_user
                left join tbl_user c on a.id_user=c.id_user
                left join tbl_store d on a.id_merchant=d.id_user
                left join tbl_ordershipping j on a.id_order = j.id_order
                left join tbl_invoice_address as ia on a.kode_invoice = ia.kode_invoice
                left join tbl_payment g on a.id_payment = g.id_payment
                left join tbl_produk k on k.id_produk = i.id_produk 
                left join tbl_invoices inv on inv.kode_invoice = a.kode_invoice
                left join tbl_payment_buyers pb on pb.kode_order like CONCAT('%',a.kode_invoice, '%') and inv.total+inv.ongkir+.inv.payment_fee = pb.amount 
                left join tbl_voucher_log vl on a.kode_invoice = vl.kode_invoice 
                left join tbl_voucher v on vl.kode_voucher = v.kode_voucher
                left join tbl_program_promo pp on pp.id_program_promo = v.id_program_promo
            where ((TIMESTAMPDIFF(DAY, date(a.date_added), NOW()) < 2
            OR status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') )
            OR (TIMESTAMPDIFF(DAY, date(a.date_added), NOW()) < 2
            AND status_delivery NOT IN ('proses pengiriman', 'produk telah diterima') ) )
            AND a.id_merchant=". (int)$idmerchant;
        
        if($paid_status!=''){
            $sql.=" AND (a.status_payment='". $this->db->escape_str($paid_status) ."' ";
            $sql.=" OR a.status_payment='refund') ";
        }
        if($kode_order !=''){
            $sql.=" AND a.kode_order='". $this->db->escape_str($kode_order) ."' ";
        }
        if($date_start !=''){
            $sql.=" AND a.date_added >= '". $this->db->escape_str($date_start) ."' ";
        }
        if($date_end !=''){
            $sql.=" AND a.date_added <= '". $this->db->escape_str($date_end) ."' ";
        }
        
        if($pengiriman !="") {
          if($pengiriman=='1'){ $sql.= " AND a.status_delivery='persiapan pengiriman'";}
          else if($pengiriman=='2'){$sql.= " AND a.status_delivery='proses pengiriman'";}
          else if($pengiriman=='3'){$sql.= " AND a.status_delivery='produk telah diterima'";}
          else if($pengiriman=='4'){$sql.= " AND a.status_delivery='proses retur'";}
        }
        
        $sql.=" order by a.date_added desc limit " . (int)$offset . "," . (int)$limit;
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result(); 
        }
    }

    public function getMerchantApi($id_user)
    {
        $this->db->select('email');
        $this->db->select('nama_store, deskripsi as biodata');
        $this->db->select('id_propinsi, id_kabupaten, id_kecamatan');
        $this->db->select('nama_pemilik, tgl_lahir_pemilik as tanggal_lahir');
        $this->db->select('telpon, merchant_hp');
        $this->db->select('bank_nama, bank_branch, bank_bi_code, bank_norek, bank_pemilik');
        $this->db->select('date_added');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('tbl_store');
        $data = $query->row();

        return $data;
    }
    
    function getOrderAutoAcceptByMerchant($limit = 100, $merchant = null) {
        $date = new DateTime();
        $date->sub(new DateInterval('P4D'));
        $date_start = $date->format('Y-m-d H:i:s');
        
        $this->db->where("status_payment", "paid");
        $this->db->where("status_response_merchant", "waiting");
        $this->db->where_in("id_merchant", $merchant);
        $this->db->where("total_mobo_awal = 0");
        $this->db->limit($limit);
        $query = $this->db->get("tbl_order");
        
        $data = $query->result();
        $query->free_result();
        return $data;
    }

    function getOrderAutoAcceptMobo($limit = 100, $merchant = null) {
        $date = new DateTime();
        $date->sub(new DateInterval('P4D'));
        $date_start = $date->format('Y-m-d H:i:s');
        
        $this->db->where("status_payment", "paid");
        $this->db->where("status_response_merchant", "waiting");
        $this->db->where("total_mobo_awal > 0");
        $this->db->where("date_paid <= '".$date_start."'");
        $this->db->limit($limit);
        $query = $this->db->get("tbl_order");
        
        $data = $query->result();
        $query->free_result();
        return $data;
    }
    
    function getOrderReject($limit = 100)
    {        
        $date = new DateTime();
        $date->sub(new DateInterval('P1D'));
        $date_start = $date->format('Y-m-d H:i:s'); 
        
        $this->db->select("*");
        $this->db->from("tbl_order");

        $this->db->where("status_payment", "paid");
        $this->db->where("status_response_merchant", "waiting");
        $this->db->where("date_paid <= '".$date_start."'");
        $this->db->where("date(date_added) >= '2016-07-27'");
        $this->db->where("id_merchant not in (113928,120544,116818,123081, " . $this->config->item('adira_id_user') . ") "); // electrionic voucher: persib shop, persib tiket, bookmate, cplay
        $this->db->where("total_mobo_awal = 0"); // orderan tanpa koin
        $this->db->limit($limit);
        $query = $this->db->get();

        $data = $query->result();
        $query->free_result();
        return $data;
    }

	function get_list_voucher_merchant($voucher_merchant='')
	{
		$sql = "select * from tbl_voucher_stock_merchant where vsm_type='elektronik'";
        $vWhere = " and vsm_id=0";
        if ($voucher_merchant=='bookmate_store_voucher_product') {
            $vWhere = " and vsm_kode like 'BOOKMATE%'";
        }
        if ($voucher_merchant=='store_voucher_product') {
            $persibStoreId = implode(',', $this->config->item('PERSIB_store_user_id')); 
            //echo 'x,'.$persibStoreId.',x'.'-'.'x,'.$this->session->userdata('member')->id_user.',x';
            $adaPersibStore = strpos('x,'.$persibStoreId.',x', 'x,'.$this->session->userdata('member')->id_user.',x');
            if ($adaPersibStore !== false) {
                $vWhere = " and vsm_kode like 'PERSIB_%'";
            } else {
                $vWhere = " and vsm_store_id ='".$this->session->userdata('member')->id_user."'";
            }
        }
        $sql.=$vWhere;
        //echo $sql;//die;
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
	}

    function getShippingMerchant($id_user,$shipping_vendor ='') {
        $this->db->select('shipping,shipping_desc');
        $this->db->where('id_user', $id_user);
        if ($shipping_vendor!='') {
            $this->db->where('shipping', $shipping_vendor);
        }
        $this->db->from('tbl_shipping_merchant');
        $query = $this->db->get();
        $data_sales = $query->result();
        $data = array();
        foreach ($data_sales as $row){
            $data[] = $row;
        }

//        $data[] = (object) array('shipping' => 'GRABEXPRESS','shipping_desc' => '');

        return $data;
    }

    function syncRpxOrigin($id_user,$jne_origin,$id_store) {

        $this->load->model('order_m');

        // --- sync RPX
        $vJneOriginId=(int)$jne_origin;
        if ($vJneOriginId>0) {
            $nama = $this->order_m->get_single('jne_origin', 'id', $vJneOriginId);
            $vJneOrigin=$nama->name;
            if ($vJneOrigin=='jabodetabekkar') {$vJneOrigin='jabodetabek';}
            $cek = $this->order_m->get_single('rpx_origin', 'name', $vJneOrigin);
            if ($cek) {
                $update = array(
                    'id_rpx_origin'	=> $cek->id,
                );
                $this->order_m->update('tbl_store', 'id_store', $id_store, $update);
echo 'tbl_store - id_store:'.$id_store.' => id_rpx_origin : '.$cek->id.'<br>';
                }
            // Kecuali Karawang	
            $update = array(
                'id_rpx_origin'	=> 0,
            );
            $this->order_m->update('tbl_store', 'id_kabupaten', 163, $update);
        }
        // --- end sync RPX

    }
    
    function get_merchant_grab($id_user) {
        $sql = 'select a.id_store, a.id_user, a.id_propinsi, a.id_kabupaten, a.id_kecamatan, b.id_propinsi, b.id_kabupaten, b.id_kecamatan
                from tbl_store a 
                INNER JOIN tbl_grab_area b ON a.id_kecamatan = b.id_kecamatan
                WHERE a.id_user = ' . $id_user;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    
    function get_merchant_id_user($id_store) {
        $this->db->select('id_store, id_user');
        $this->db->where('id_store', $id_store);
        return $this->db->get('tbl_store');
    }

    
}
