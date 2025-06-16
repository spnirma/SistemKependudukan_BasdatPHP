<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_m extends MY_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	function cek_username($id='', $username=''){
		$sql="SELECT COUNT(*) AS jumlah FROM tbl_user WHERE id_user!='".(int)$id."' AND username='". $this->db->escape_str($username) . "' ";
		$q=$this->db->query($sql);
		$data = $q->row();
		$q->free_result();
		return $data->jumlah;
	}

	function cek_password($id='', $pass=''){
		$sql="SELECT COUNT(*) AS jumlah FROM tbl_user WHERE id_user='". (int)$id."' AND password='". $this->db->escape_str($pass) ."' ";
		$q=$this->db->query($sql);
		$data = $q->row();
		$q->free_result();
		return $data->jumlah;
	}

	function view_all_admin($limit='', $offset='', $is_allowed_add_all_user){
        $condition = "";
        if ($is_allowed_add_all_user === false) {
            $condition = " AND a.id_level = 8 ";
        }
		$sql=	"select a.*, b.nama_level, c.nama_kabupaten, d.nama_status, e.nama_group
				from tbl_user a
				left join tbl_level b on a.id_level=b.id_level
				left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
				left join tbl_status d on a.id_status=d.id_status
				left join tbl_group e on a.id_group=e.id_group
				where a.id_level!=6 and a.id_level!=7 and a.deleted=0
                ".$condition."
				order by a.id_user asc limit ".(int)$offset.",".(int)$limit."";
		$q=$this->db->query($sql);
		$data = $q->result();
		$q->free_result();
		return $data;
	}
        
        function view_all_member($limit='', $offset=''){
		$sql=	"select a.*, c.nama_kabupaten, d.nama_status, e.nama_group, f.nama_kecamatan, g.nama_propinsi
				from tbl_user a
				left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
				left join tbl_status d on a.id_status=d.id_status
				left join tbl_group e on a.id_group=e.id_group
                                left join tbl_kecamatan f on a.id_kecamatan=f.id_kecamatan
                                left join tbl_propinsi g on a.id_propinsi=g.id_propinsi
				where a.id_level IN (6,7)
				and a.id_user>700
				order by a.date_added desc limit ".(int)$offset.",".(int)$limit."";
//				and a.user_ev=".EVENTID."
		$q=$this->db->query($sql);
		$data = $q->result();
		$q->free_result();
		return $data;
	}
        
	function view_all_merchant($limit='', $offset=''){
		$sql=	"select m.*,m.date_added as 'merchant_register_date',m.date_request as 'merchant_request_date',"
                . " m.telpon as 'merchant_telp', kb.nama_kabupaten, kc.nama_kecamatan, pr.nama_propinsi"
                . " from tbl_store m left join tbl_user u on m.id_user=u.id_user"
                . " left join tbl_kecamatan as kc on m.id_kecamatan=kc.id_kecamatan"
                . " left join tbl_kabupaten as kb on m.id_kabupaten=kb.id_kabupaten"
                . " left join tbl_propinsi as pr on m.id_propinsi=pr.id_propinsi"
                . " where u.deleted=0 order by m.date_added DESC limit ".(int)$offset.",".(int)$limit."";
		$q=$this->db->query($sql);
		$data = $q->result();
		$q->free_result();
		return $data;
	}
        
    function view_all_merchant_by_status($status = '', $limit='', $offset=''){
		$sql="select m.*,m.date_added as 'merchant_register_date', m.date_request as 'merchant_request_date',"
                . " m.date_modified as 'merchant_modified_date', jo.display_name as nama_kota_jne,"
                . " m.telpon as 'merchant_telp', kb.nama_kabupaten, kc.nama_kecamatan, pr.nama_propinsi,"
                . " ag.nama_agregator"
                . " from tbl_store m left join tbl_user u on (m.id_user=u.id_user)"
                . " left join tbl_kecamatan kc on (m.id_kecamatan=kc.id_kecamatan)"
                . " left join tbl_kabupaten kb on (m.id_kabupaten=kb.id_kabupaten)"
                . " left join tbl_propinsi pr on (m.id_propinsi=pr.id_propinsi)"
                . " left join jne_origin jo on (jo.id = m.id_jne_origin)"
                . " left join tbl_agregator ag on (ag.kode_agregator = m.merchant_indoloka)"
                . " where u.deleted=0 
				and m.id_event=".EVENTID." 
				and m.store_status='" . $this->db->escape_str($status) . "'
				and m.event like 'gayeng25'";
                
                if($this->session->userdata('admin_session')->id_level == 8){
                    $sql .= " AND m.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
                }
                if($status == 'pending'){
                    $sql .= " order by m.date_request DESC";
                }elseif ($status == 'approve') {
                    $sql .= " order by m.date_verified DESC";
                }elseif ($status == 'block') {
                    $sql .= " order by m.date_unverified DESC";
                }
                $sql .= "  limit ".(int)$offset.",".(int)$limit."";
//echo $sql;die;
		$q=$this->db->query($sql);
		$data = $q->result();
		$q->free_result();
		return $data;
	}
        
    function get_merchant_by_search($by_search = '', $by_mail = '', $by_from = '', $by_to = '', $by_status = '', $by_sumber = '', $by_location = '', $indoloka = '', $limit = '', $offset = '') {
        $query = "select m.*,m.date_added as 'merchant_register_date', m.date_request as 'merchant_request_date', m.date_modified as 'merchant_modified_date',
                m.telpon as 'merchant_telp', kb.nama_kabupaten, kc.nama_kecamatan, pr.nama_propinsi, jo.display_name as nama_kota_jne, ag.nama_agregator
                from tbl_store m left join tbl_user u on (m.id_user=u.id_user)
                left join tbl_kecamatan kc on (m.id_kecamatan=kc.id_kecamatan)
                left join tbl_kabupaten kb on (m.id_kabupaten=kb.id_kabupaten)
                left join tbl_propinsi pr on (m.id_propinsi=pr.id_propinsi)
                left join jne_origin jo on (jo.id = m.id_jne_origin)
                left join tbl_agregator ag on (ag.kode_agregator = m.merchant_indoloka)
                where u.deleted=0 
				and m.event like 'gayeng25'
				and (isnull(m.date_unverified) or m.date_unverified='0000-00-00 00:00:00')				
				and m.id_event=".EVENTID;

        if($this->session->userdata('admin_session')->id_level == 8){
            $query .= " AND m.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
        }
        
        $conditions = array();
        if ($by_search != "") {
            $conditions[] = "m.nama_store LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_mail !="") {
          $conditions[] = "m.email LIKE '%" . $this->db->escape_like_str($by_mail) . "%'";
        }
        if($indoloka !="all") {
          if($indoloka !="") {
          $conditions[] = "m.merchant_indoloka = '" . $this->db->escape_str($indoloka) . "'";
          } else {
            $conditions[] = "m.merchant_indoloka is null";
          }
        }
        if ($by_from != "" && $by_to != "") {
            $from = strftime("%Y-%m-%d", strtotime($by_from));
            $to = strftime("%Y-%m-%d", strtotime($by_to));
            if($by_status == "approve"){
                $conditions[] = "(DATE(m.date_verified) BETWEEN '$from' AND '$to')";
            }else if($by_status == "pending"){
                $conditions[] = "(DATE(m.date_request) BETWEEN '$from' AND '$to')";
            }else if($by_status == "block"){
                $conditions[] = "(DATE(m.date_unverified) BETWEEN '$from' AND '$to')";
            }else{
                $conditions[] = "(DATE(m.date_added) BETWEEN '$from' AND '$to')";
            }
        }
        if ($by_status != "") {
            $conditions[] = "m.store_status='" . $this->db->escape_str($by_status) . "'";
        }
        if ($by_sumber != "") {
            $conditions[] = "m.sumber = '" . $by_sumber . "'";
        }
        if ($by_location != "") {
            $conditions[] = "kb.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        $sql = $query;
        if (count($conditions) > 0) {
            $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
		$sql .=" and m.binaan in (SELECT bn_number FROM `tbl_binaan` where bn_eventname='gayeng25' and bn_event=80)";
		
        if($by_status == 'pending'){
            $sql .= " order by m.date_request DESC";
        }elseif ($by_status == 'approve') {
            $sql .= " order by m.date_verified DESC";
        }elseif ($by_status == 'block') {
            $sql .= " order by m.date_unverified DESC";
        }
        $sql .= " LIMIT " . (int)$offset . ", " . (int)$limit . "";
//echo $sql;die;		
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function get_merchant_export($by_search = '', $by_mail = '', $by_from = '', $by_to = '', $by_status = '', $by_sales = '', $by_location = '', $indoloka = '', $limit = '', $offset = '') {
        $query = "select m.*,m.date_added as 'merchant_register_date', m.date_request as 'merchant_request_date', m.date_modified as 'merchant_modified_date',
                m.telpon as 'merchant_telp', kb.nama_kabupaten, kc.nama_kecamatan, pr.nama_propinsi, jo.display_name as nama_kota_jne,
                ag.nama_agregator
                from tbl_store m left join tbl_user u on (m.id_user=u.id_user)
                left join tbl_kecamatan kc on (m.id_kecamatan=kc.id_kecamatan)
                left join tbl_kabupaten kb on (m.id_kabupaten=kb.id_kabupaten)
                left join tbl_propinsi pr on (m.id_propinsi=pr.id_propinsi)
                left join jne_origin jo on (jo.id = m.id_jne_origin)
                left join tbl_agregator ag on (m.merchant_indoloka = ag.kode_agregator)
                where u.deleted=0
				and m.id_event=".EVENTID;

        if($this->session->userdata('admin_session')->id_level == 8){
            $query .= " AND m.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
        }
        
        $conditions = array();
        if ($by_search != "") {
            $conditions[] = "m.nama_store LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if($by_mail !="") {
          $conditions[] = "m.email LIKE '%" . $this->db->escape_like_str($by_mail) . "%'";
        }
        if($indoloka !="all") {
          if($indoloka !="") {
          $conditions[] = "m.merchant_indoloka = '" . $this->db->escape_str($indoloka) . "'";
          } else {
            $conditions[] = "m.merchant_indoloka is null";
          }
        }
        if ($by_from != "" && $by_to != "") {
            $from = strftime("%Y-%m-%d", strtotime($by_from));
            $to = strftime("%Y-%m-%d", strtotime($by_to));
            if($by_status == "approve"){
                $conditions[] = "(DATE(m.date_verified) BETWEEN '$from' AND '$to')";
            }else if($by_status == "pending"){
                $conditions[] = "(DATE(m.date_request) BETWEEN '$from' AND '$to')";
            }else if($by_status == "block"){
                $conditions[] = "(DATE(m.date_unverified) BETWEEN '$from' AND '$to')";
            }else{
                $conditions[] = "(DATE(m.date_added) BETWEEN '$from' AND '$to')";
            }
        }
        if ($by_status != "") {
            $conditions[] = "m.store_status='" . $this->db->escape_str($by_status) . "'";
        }
        if ($by_sales != "") {
            $conditions[] = "m.id_sales='" . (int)$by_sales . "'";
        }
        if ($by_location != "") {
            $conditions[] = "kb.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        $sql = $query;
        if (count($conditions) > 0) {
            $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        if($by_status == 'pending'){
            $sql .= " order by m.date_request DESC";
        }elseif ($by_status == 'approve') {
            $sql .= " order by m.date_verified DESC";
        }elseif ($by_status == 'block') {
            $sql .= " order by m.date_unverified DESC";
        }

        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_member_by_search($by_search='',$by_mail='', $by_from='', $by_to='',$by_status='', $by_location='', $limit = '', $offset = '')
        {
            $query = "a.*, c.nama_kabupaten, d.nama_status, e.nama_group, f.nama_kecamatan, g.nama_propinsi
                        from tbl_user a
                        left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
                        left join tbl_status d on a.id_status=d.id_status
                        left join tbl_group e on a.id_group=e.id_group
                        left join tbl_kecamatan f on a.id_kecamatan=f.id_kecamatan
                        left join tbl_propinsi g on a.id_propinsi=g.id_propinsi
                        where a.id_level IN (6,7) and a.deleted=0";

            $conditions = array();
            if($by_search !="") {
              $conditions[] = "a.username LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
            }
            if($by_from !="" && $by_to !="") {
                $from = strftime("%Y-%m-%d",strtotime($by_from));
                $to = strftime("%Y-%m-%d",strtotime($by_to));
                $conditions[] = "(DATE(a.date_added) BETWEEN '$from' AND '$to')";
            }
            if($by_mail !="") {
              $conditions[] = "a.email LIKE '%" . $this->db->escape_like_str($by_mail) . "%'";
            }
            if($by_status !="") {
                $conditions[] = "d.id_status='" . (int)$by_status . "'";
              }
            if($by_location !="") {
              $conditions[] = "c.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
            }

            //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

            $sql = $query;
            if (count($conditions) > 0) {
              $sql .= " AND " . implode(' AND ', $conditions) . "";
            }
            $sql .= " group by a.id_user desc LIMIT " . (int)$offset . ", " . (int)$limit . "";
            // var_dump($sql);exit;
            $q = $this->db->query($sql);
            $data = $q->result();
            $q->free_result();
            return $data;
        }
        
        function get_member_by_search_m($by_search='',$by_mail='', $by_from='', $by_to='',$by_status='', $by_level='', $by_jenkel = '', $by_um = '', $by_location='', $limit = '', $offset = '', $not_in_id_array = array())
        {
            $query = "select a.*, c.nama_kabupaten, d.nama_status, e.nama_group, f.nama_kecamatan, g.nama_propinsi
                        from tbl_user a
                        left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
                        left join tbl_status d on a.id_status=d.id_status
                        left join tbl_group e on a.id_group=e.id_group
                        left join tbl_kecamatan f on a.id_kecamatan=f.id_kecamatan
                        left join tbl_propinsi g on a.id_propinsi=g.id_propinsi
                        where a.deleted = 0 ";

            $conditions = array();
            if($by_search !="") {
              $conditions[] = " CONCAT(a.firstname, ' ', a.lastname) LIKE '%". $this->db->escape_like_str($by_search) ."%'";
            }
            if($by_from !="" && $by_to !="") {
                $from = strftime("%Y-%m-%d",strtotime($by_from));
                $to = strftime("%Y-%m-%d",strtotime($by_to));
                $conditions[] = "(DATE(a.date_added) BETWEEN '$from' AND '$to')";
            }
            if($by_mail !="") {
              $conditions[] = "a.email LIKE '%" . $this->db->escape_like_str($by_mail) . "%'";
            }
            if($by_status !="") {
                $conditions[] = "a.id_status = '" . (int)$by_status . "'";
              }
            if($by_level !="") {
                $conditions[] = "a.id_level='" . (int)$by_level . "'";
              }else{
                $conditions[] = "a.id_level IN (6,7)";
              }
            if($by_jenkel !="" AND $by_jenkel !="-") {
                $conditions[] = "a.gender='" . $this->db->escape_str($by_jenkel) . "'";
            }elseif($by_jenkel =="-"){
                $conditions[] = "a.gender NOT IN ('man','woman')";
            }
            
            if (!empty($not_in_id_array)) {
                $conditions[] = 'a.id_user NOT IN ('.implode(",", $not_in_id_array).')';
            }
            
            if($by_um !=""){
                if($by_um == 22){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=22 ";
                }elseif($by_um == 21){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=18 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=21";
                }elseif($by_um == 17){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=13 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=17";
                }elseif($by_um == 12){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=6 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=12";
                }else{
                  $conditions[] = " a.birthdate IS NULL";
                }
                
            }
            if($by_location !="") {
              $conditions[] = "c.nama_kabupaten LIKE '%" . $this->db->escape_str($by_location) . "%'";
            }

            //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

            $sql = $query;
            if (count($conditions) > 0) {
              $sql .= " AND " . implode(' AND ', $conditions) . "";
            }
            $sql .= " order by a.date_added desc LIMIT " . (int)$offset . ", " . (int)$limit . "";
            // var_dump($sql);exit;
            $q = $this->db->query($sql);
            $data = $q->result();
            $q->free_result();
            return $data;
        }
        function get_member_export_m($by_search='',$by_mail='', $by_from='', $by_to='',$by_status='', $by_level='', $by_jenkel = '', $by_um='', $by_location='')
        {
            $query = "select a.*, c.nama_kabupaten, d.nama_status, e.nama_group, f.nama_kecamatan, g.nama_propinsi
                        from tbl_user a
                        left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
                        left join tbl_status d on a.id_status=d.id_status
                        left join tbl_group e on a.id_group=e.id_group
                        left join tbl_kecamatan f on a.id_kecamatan=f.id_kecamatan
                        left join tbl_propinsi g on a.id_propinsi=g.id_propinsi
                        where a.deleted = 0 ";

            $conditions = array();
            if($by_search !="") {
              $conditions[] = " CONCAT(a.firstname, ' ', a.lastname) LIKE '%". $this->db->escape_like_str($by_search) ."%'";
            }
            if($by_from !="" && $by_to !="") {
                $from = strftime("%Y-%m-%d",strtotime($by_from));
                $to = strftime("%Y-%m-%d",strtotime($by_to));
                $conditions[] = "(DATE(a.date_added) BETWEEN '$from' AND '$to')";
            }
            if($by_mail !="") {
              $conditions[] = "a.email LIKE '%" . $this->db->escape_like_str($by_mail) . "%'";
            }
            if($by_status !="") {
                $conditions[] = "a.id_status = '" . (int)$by_status . "'";
              }
            if($by_level !="") {
                $conditions[] = "a.id_level='" . (int)$by_level . "'";
              }else{
                $conditions[] = "a.id_level IN (6,7)";
              }
            if($by_jenkel !="" AND $by_jenkel !="-") {
                $conditions[] = "a.gender='" . $this->db->escape_str($by_jenkel) . "'";
            }elseif($by_jenkel =="-"){
                $conditions[] = "a.gender NOT IN ('man','woman')";
            }
            if($by_um !=""){
                if($by_um == 22){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=22 ";
                }elseif($by_um == 21){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=18 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=21";
                }elseif($by_um == 17){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=13 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=17";
                }elseif($by_um == 12){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=6 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=12";
                }else{
                  $conditions[] = " a.birthdate IS NULL";
                }
                
            }
            if($by_location !="") {
              $conditions[] = "c.nama_kabupaten LIKE '%" . $this->db->escape_str($by_location) . "%'";
            }

            //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

            $sql = $query;
            if (count($conditions) > 0) {
              $sql .= " AND " . implode(' AND ', $conditions) . "";
            }
            $sql .= " order by a.date_added DESC";
            // var_dump($sql);exit;
            $q = $this->db->query($sql);
            $data = $q->result();
            $q->free_result();
            return $data;
        }
        
        function count_all_merchant() {
        $sql = "select count(*) as jumlah from (select m.*,m.date_added as 'merchant_register_date', m.date_modified as 'merchant_modified_date',"
                . " m.telpon as 'merchant_telp', kb.nama_kabupaten, kc.nama_kecamatan, pr.nama_propinsi"
                . " from tbl_store m left join tbl_user u on (m.id_user=u.id_user)"
                . " left join tbl_kecamatan kc on (m.id_kecamatan=kc.id_kecamatan)"
                . " left join tbl_kabupaten kb on (m.id_kabupaten=kb.id_kabupaten)"
                . " left join tbl_propinsi pr on (m.id_propinsi=pr.id_propinsi)"
                . " where u.deleted=0 order by m.date_added DESC) as x";

        $query = $this->db->query($sql);
        $data = $query->row();
        $query->free_result();
        return $data->jumlah;
    }
    
    function count_all_merchant_by_status($status='') {
        $sql = "select count(*) as jumlah from (select m.*,m.date_added as 'merchant_register_date', m.date_modified as 'merchant_modified_date',"
                . " m.telpon as 'merchant_telp', kb.nama_kabupaten, kc.nama_kecamatan, pr.nama_propinsi"
                . " from tbl_store m left join tbl_user u on (m.id_user=u.id_user)"
                . " left join tbl_kecamatan kc on (m.id_kecamatan=kc.id_kecamatan)"
                . " left join tbl_kabupaten kb on (m.id_kabupaten=kb.id_kabupaten)"
                . " left join tbl_propinsi pr on (m.id_propinsi=pr.id_propinsi)"
                . " where u.deleted=0
				and m.id_event=".EVENTID;
        
        if($this->session->userdata('admin_session')->id_level == 8){
            $sql .= " AND m.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
        }
        
            $sql .= " and m.store_status='" . $this->db->escape_str($status) . "' order by m.date_added DESC) as x";
        
        $query = $this->db->query($sql);
        $data = $query->row();
        $query->free_result();
        return $data->jumlah;
    }

    function count_all_member(){
            $sql = "select count(*) as jumlah from tbl_user WHERE id_level IN (6,7) AND deleted=0 AND id_status !=5 
			and id_user>700";
            $q = $this->db->query($sql);
            $data = $q->row();
            $q->free_result();
            return $data->jumlah;
        }
        
    function count_all_merchant_search($by_search = '', $by_mail = '', $by_from = '', $by_to = '', $by_status = '', $by_sumber = '', $by_location = '', $indoloka = '', $limit = '', $offset = '') {
        $query = "select count(*) as jumlah from"
                . "(select m.*,m.date_added as 'merchant_register_date', m.date_modified as 'merchant_modified_date',"
                . " m.telpon as 'merchant_telp', kb.nama_kabupaten, kc.nama_kecamatan, pr.nama_propinsi"
                . " from tbl_store m left join tbl_user u on (m.id_user=u.id_user)"
                . " left join tbl_kecamatan kc on (m.id_kecamatan=kc.id_kecamatan)"
                . " left join tbl_kabupaten kb on (m.id_kabupaten=kb.id_kabupaten)"
                . " left join tbl_propinsi pr on (m.id_propinsi=pr.id_propinsi)"
                . " where u.deleted=0 
				and m.id_event=".EVENTID;
        
        if($this->session->userdata('admin_session')->id_level == 8){
            $query .= " AND m.agregator = ". (int)$this->session->userdata('admin_session')->id_user;
        }
        
        $conditions = array();
        if ($by_search != "") {
            $conditions[] = "m.nama_store LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
        }
        if ($by_from != "" && $by_to != "") {
            $from = strftime("%Y-%m-%d", strtotime($by_from));
            $to = strftime("%Y-%m-%d", strtotime($by_to));
            if($by_status == "approve"){
                $conditions[] = "(DATE(m.date_added) BETWEEN '$from' AND '$to')";
            }else if($by_status == "pending"){
                $conditions[] = "(DATE(m.date_verified) BETWEEN '$from' AND '$to')";
            }else if($by_status == "block"){
                $conditions[] = "(DATE(m.date_unverified) BETWEEN '$from' AND '$to')";
            }else{
                $conditions[] = "(DATE(m.date_added) BETWEEN '$from' AND '$to')";
            }
        }
        if($by_mail !="") {
          $conditions[] = "m.pic_email LIKE '%" . $this->db->escape_like_str($by_mail) . "%'";
        }
        if($indoloka !="all") {
          if($indoloka !="") {
          $conditions[] = "m.merchant_indoloka = '" . $this->db->escape_str($indoloka) . "'";
          } else {
            $conditions[] = "m.merchant_indoloka is null";
          }
        }
        if ($by_status != "") {
            $conditions[] = "m.store_status='" . $this->db->escape_str($by_status) . "'";
        }
        if ($by_sumber != "") {
            $conditions[] = "m.sumber = '" . $by_sumber . "'";
        }        
        if ($by_location != "") {
            $conditions[] = "kb.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        $sql = $query;
        if (count($conditions) > 0) {
            $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by m.id_store) as x";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }

    function count_all_member_search($by_search='',$by_mail='', $by_from='', $by_to='', $by_status='', $by_location='')
        {
            $query = "select count(*) as jumlah from (select a.*, YEAR(CURDATE()) - YEAR(a.birthdate) AS usia, c.nama_kabupaten, d.nama_status, e.nama_group
                from tbl_user a
                left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
                left join tbl_status d on a.id_status=d.id_status
                left join tbl_group e on a.id_group=e.id_group
                where a.id_level IN (6,7) and a.deleted=0";

            $conditions = array();
            if($by_search !="") {
              $conditions[] = "a.username LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
            }
            if($by_from !="" && $by_to !="") {
                $from = strftime("%Y-%m-%d",strtotime($by_from));
                $to = strftime("%Y-%m-%d",strtotime($by_to));
                $conditions[] = "(DATE(a.date_added) BETWEEN '$from' AND '$to')";
            }
            if($by_status !="") {
                $conditions[] = "d.id_status='" . (int)$by_status . "'";
              }
            if($by_location !="") {
              $conditions[] = "c.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
            }

            //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

            $sql = $query;
            if (count($conditions) > 0) {
              $sql .= " AND " . implode(' AND ', $conditions) . "";
            }
            $sql .= " group by a.id_user) as x";
            $q = $this->db->query($sql);
            $data = $q->row();
            $q->free_result();
            return $data->jumlah;
        }
        
        function count_all_member_search_m($by_search='',$by_mail='', $by_from='', $by_to='', $by_status='', $by_level='', $by_jenkel = '', $by_um='', $by_location='')
        {
            $query = "select count(*) as jumlah from (select a.*, c.nama_kabupaten, d.nama_status, e.nama_group
                from tbl_user a
                left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
                left join tbl_status d on a.id_status=d.id_status
                left join tbl_group e on a.id_group=e.id_group
                left join tbl_kecamatan f on a.id_kecamatan=f.id_kecamatan
                left join tbl_propinsi g on a.id_propinsi=g.id_propinsi
                where a.deleted=0";

            $conditions = array();
            if($by_search !="") {
              $conditions[] = "a.username LIKE '%" . $this->db->escape_like_str($by_search) . "%'";
            }
            if($by_from !="" && $by_to !="") {
                $from = strftime("%Y-%m-%d",strtotime($by_from));
                $to = strftime("%Y-%m-%d",strtotime($by_to));
                $conditions[] = "(DATE(a.date_added) BETWEEN '$from' AND '$to')";
            }
            if($by_mail !="") {
                $conditions[] = "a.email LIKE '%" . $this->db->escape_like_str($by_mail) . "%'";
            }
            if($by_status !="") {
                $conditions[] = "a.id_status = '" . $this->db->escape_str($by_status) . "'";
              }
            if($by_level !="") {
                $conditions[] = "a.id_level='" . (int)$by_level . "'";
              }else{
                $conditions[] = "a.id_level IN (6,7)";
              }
            if($by_jenkel !="" AND $by_jenkel !="-") {
                $conditions[] = "a.gender='" . $this->db->escape_str($by_jenkel) . "'";
              }elseif($by_jenkel =="-"){
                $conditions[] = "a.gender NOT IN ('man','woman')";
              }
            if($by_um !=""){
                if($by_um == 22){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=22 ";
                }elseif($by_um == 21){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=18 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=21";
                }elseif($by_um == 17){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=13 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=17";
                }elseif($by_um == 12){
                  $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=6 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=12";
                }else{
                  $conditions[] = " a.birthdate IS NULL";
                }
            }  
            if($by_location !="") {
              $conditions[] = "c.nama_kabupaten LIKE '%" . $this->db->escape_like_str($by_location) . "%'";
            }                        

            //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

            $sql = $query;
            if (count($conditions) > 0) {
              $sql .= " AND " . implode(' AND ', $conditions) . "";
            }
            $sql .= " group by a.id_user) as x";
            $q = $this->db->query($sql);
            $data = $q->row();
            $q->free_result();
            return $data->jumlah;
        }

	function get_username($key){
		$sql="select max(username) as id from tbl_user where (select left(username, 3))='". $this->db->escape_str($key) ."'";
		$q=$this->db->query($sql);
		$data = $q->row();
		$q->free_result();
		if($data->id!=null){
			$id_anyar = str_replace($key, '', $data->id);
			$id_anyar += 1000; $id_anyar++;
			$out = $key.substr($id_anyar, 1,3);	
		} else {
			$id_anyar = 1000; $id_anyar++;
			$out=$key.substr($id_anyar, 1,3);
		}
		return $out;	
	}

	function get_user_login($_username, $_password) {
        $sql = "select * from tbl_user 
            where id_level IN(1, 2, 3, 8, 4, 5, 9) AND (username='" . $this->db->escape_str($_username) . "' or email ='". $this->db->escape_str($_username) ."') 
            AND password = '" . $this->db->escape_str($_password) . "' AND deleted != 1";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }

    function get_email_user($email){
    	$sql = "select * from tbl_user where email ='". $this->db->escape_str($email) ."'
		and user_ev=".EVENTID;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }

    function get_image($id_user=''){
    	$sql = "select image from tbl_user where id_user ='". (int)$id_user."'";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->image;
    }
    
    function delete_love($id_produk, $id_user){		
        $this->db->where('md5(id_produk)', $id_produk);
        $this->db->where('md5(id_user)', $id_user);
        $this->db->delete('tbl_love');
        return $this->db->affected_rows();
    }
    
    /* Check duplicate email */
    function duplicate_email($email)
    {
        $sql = "select email from tbl_user where email='". $this->db->escape_str($email) ."'";
        $query = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
     function get_status(){
    	$sql = "select * from tbl_status";
        $q=$this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }
    
    function get_user($email)
    {
        $sql = "select u.id_user, u.username as name, email, active, firstname, lastname, " .
                "image, alamat, bio, telpon, hp, gender, " .
                "p.nama_propinsi, k.nama_kabupaten, kc.nama_kecamatan , date_added " .
                "from tbl_user u left join tbl_kabupaten k on u.id_kabupaten=k.id_kabupaten " .
                "left join tbl_propinsi p on u.id_propinsi=p.id_propinsi " .
                "left join tbl_kecamatan kc on u.id_kecamatan = kc.id_kecamatan where u.email = '" . $this->db->escape_str($email) . "';";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data;
    }
    
    function get_member_only($term)
    {
        $where = "firstname like '%".$this->db->escape_like_str($term)."%' or lastname like '%".$this->db->escape_like_str($term)."%'";
        $sql = "select id_user, concat(firstname, ' ', lastname) as member, email ";
        $sql .= "from tbl_user where id_level = '6' and active = 1 and (".$where.")";
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_kabupaten_by_propinsi($id_propinsi, $nama_kabupaten)
    {
        $sql = "select id_kabupaten from tbl_kabupaten where nama_kabupaten = '" . $this->db->escape_str($nama_kabupaten) . "' and id_propinsi = " . (int) $id_propinsi . ";";
        $query = $this->db->query($sql);

        if ($data = $query->num_rows() > 0) {
            return $data = $query->row_object();
        } else {
            return FALSE;
        }
    }

    function get_kecamatan_by_kabupaten($id_kabupaten, $nama_kecamatan)
    {
        $sql = "select id_kecamatan from tbl_kecamatan where nama_kecamatan = '" . $this->db->escape_str($nama_kecamatan) . "' and id_kabupaten = " . (int) $id_kabupaten . ";";
        $query = $this->db->query($sql);

        if ($data = $query->num_rows() > 0) {
            return $data = $query->row_object();
        } else {
            return FALSE;
        }
    }

    function get_user_voucher($id_user = '', $limit = '', $offset = '')
    {
        $sql = "select * from tbl_voucher where id_user='" . (int) $id_user . "' order by id_voucher desc limit " . (int) $offset . "," . (int) $limit . "";
        $q = $this->db->query($sql);
        $data = $q->result_array();
        $q->free_result();
        return $data;
    }

    function count_user_voucher($id_user = '')
    {
        $sql = "select * from tbl_voucher where id_user='" . (int) $id_user . "' order by id_voucher desc;";
        $q = $this->db->query($sql);
        $data = $q->num_rows();
        $q->free_result();
        return $data;
    }
    
    function cek_id_user($id_user = '')
    {
        $sql = "select * from tbl_user where id_user = ".(int) $id_user;
        $q = $this->db->query($sql);
        $data = $q->num_rows();
        $q->free_result();
        return $data;
    }
    
    function get_all_point($id_user, $sortBy = 'tanggal', $sort = "ASC")
    {
        $sql = "select * from tbl_point_reward where id_user = '" . (int) $id_user . "' and void = 0 order by '" . $this->db->escape_str($sortBy) . "' " .$this->db->escape_str($sort) . ";";
        $q = $this->db->query($sql);
        $data = $q->result_object();
        $q->free_result();
        return $data;
    }

    function count_point($id_user, $sortBy = 'tanggal', $sort = "ASC")
    {
        $sql = "select sum(debet) as total_debet, sum(kredit) as total_kredit, sum(kredit) - sum(debet) as saldo_point from tbl_point_reward where id_user = '". (int) $id_user ."' and void = 0 order by '" . $this->db->escape_str($sortBy) . "' " .$this->db->escape_str($sort) . ";";

        $q = $this->db->query($sql);
        $data = $q->row_object();
        $q->free_result();
        return $data;
    }

    function view_all_member_with_point($limit='', $offset=''){
        $sql=   "select a.*, c.nama_kabupaten, d.nama_status, e.nama_group, f.nama_kecamatan, g.nama_propinsi, 
                sum(pnt.debet) as total_debet, sum(pnt.kredit) as total_kredit, sum(pnt.kredit) - sum(pnt.debet) as saldo_point 
                from tbl_user a
                left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
                left join tbl_status d on a.id_status=d.id_status
                left join tbl_group e on a.id_group=e.id_group
                                left join tbl_kecamatan f on a.id_kecamatan=f.id_kecamatan
                                left join tbl_propinsi g on a.id_propinsi=g.id_propinsi
                                left join tbl_point_reward pnt on a.id_user = pnt.id_user
                where a.id_level IN (6,7) 
                group by a.id_user order by a.date_added desc  limit ".(int)$offset.",".(int)$limit."";
        $q=$this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function get_member_by_search_m_with_point($by_search='',$by_mail='', $by_from='', $by_to='',$by_status='', $by_level='', $by_jenkel = '', $by_um = '', $by_location='', $by_minimal_saldo=0, $limit = '', $offset = '')
    {
        $query = "select a.*, c.nama_kabupaten, d.nama_status, e.nama_group, f.nama_kecamatan, g.nama_propinsi,
                sum(pnt.debet) as total_debet, sum(pnt.kredit) as total_kredit, sum(pnt.kredit) - sum(pnt.debet) as saldo_point
                    from tbl_user a
                    left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
                    left join tbl_status d on a.id_status=d.id_status
                    left join tbl_group e on a.id_group=e.id_group
                    left join tbl_kecamatan f on a.id_kecamatan=f.id_kecamatan
                    left join tbl_propinsi g on a.id_propinsi=g.id_propinsi 
                    left join tbl_point_reward pnt on a.id_user = pnt.id_user 
                    where a.deleted = 0 ";

        $conditions = array();
        if($by_search !="") {
          $conditions[] = " CONCAT(a.firstname, ' ', a.lastname) LIKE '%". $this->db->escape_like_str($by_search) ."%'";
        }
        if($by_from !="" && $by_to !="") {
            $from = strftime("%Y-%m-%d",strtotime($by_from));
            $to = strftime("%Y-%m-%d",strtotime($by_to));
            $conditions[] = "(DATE(a.date_added) BETWEEN '$from' AND '$to')";
        }
        if($by_mail !="") {
          $conditions[] = "a.email LIKE '%" . $this->db->escape_like_str($by_mail) . "%'";
        }
        if($by_status !="") {
            $conditions[] = "a.id_status = '" . (int)$by_status . "'";
          }
        if($by_level !="") {
            $conditions[] = "a.id_level='" . (int)$by_level . "'";
          }else{
            $conditions[] = "a.id_level IN (6,7)";
          }
        if($by_jenkel !="" AND $by_jenkel !="-") {
            $conditions[] = "a.gender='" . $this->db->escape_str($by_jenkel) . "'";
        }elseif($by_jenkel =="-"){
            $conditions[] = "a.gender NOT IN ('man','woman')";
        }
        if($by_um !=""){
            if($by_um == 22){
              $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=22 ";
            }elseif($by_um == 21){
              $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=18 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=21";
            }elseif($by_um == 17){
              $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=13 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=17";
            }elseif($by_um == 12){
              $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=6 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=12";
            }else{
              $conditions[] = " a.birthdate IS NULL";
            }
            
        }
        if($by_location !="") {
          $conditions[] = "c.nama_kabupaten LIKE '%" . $this->db->escape_str($by_location) . "%'";
        }
        
        $sqlFindMinimalSaldo = "";
        if($by_minimal_saldo !=0) {
          $sqlFindMinimalSaldo = " having saldo_point >= " . (int) $by_minimal_saldo . "";
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        $sql = $query;
        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_user " . $sqlFindMinimalSaldo . " order by a.date_added desc LIMIT " . (int)$offset . ", " . (int)$limit . "";
        // var_dump($sql);exit;
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    function count_all_member_search_m_with_point($by_search='',$by_mail='', $by_from='', $by_to='', $by_status='', $by_level='', $by_jenkel = '', $by_um='', $by_location='', $by_minimal_saldo=0)
    {
        $query = "select count(*) as jumlah from (select a.*, c.nama_kabupaten, d.nama_status, e.nama_group, f.nama_kecamatan, g.nama_propinsi,
                sum(pnt.debet) as total_debet, sum(pnt.kredit) as total_kredit, sum(pnt.kredit) - sum(pnt.debet) as saldo_point
                    from tbl_user a
                    left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
                    left join tbl_status d on a.id_status=d.id_status
                    left join tbl_group e on a.id_group=e.id_group
                    left join tbl_kecamatan f on a.id_kecamatan=f.id_kecamatan
                    left join tbl_propinsi g on a.id_propinsi=g.id_propinsi 
                    left join tbl_point_reward pnt on a.id_user = pnt.id_user 
                    where a.deleted = 0 ";

         $conditions = array();
        if($by_search !="") {
          $conditions[] = " CONCAT(a.firstname, ' ', a.lastname) LIKE '%". $this->db->escape_like_str($by_search) ."%'";
        }
        if($by_from !="" && $by_to !="") {
            $from = strftime("%Y-%m-%d",strtotime($by_from));
            $to = strftime("%Y-%m-%d",strtotime($by_to));
            $conditions[] = "(DATE(a.date_added) BETWEEN '$from' AND '$to')";
        }
        if($by_mail !="") {
          $conditions[] = "a.email LIKE '%" . $this->db->escape_like_str($by_mail) . "%'";
        }
        if($by_status !="") {
            $conditions[] = "a.id_status = '" . (int)$by_status . "'";
          }
        if($by_level !="") {
            $conditions[] = "a.id_level='" . (int)$by_level . "'";
          }else{
            $conditions[] = "a.id_level IN (6,7)";
          }
        if($by_jenkel !="" AND $by_jenkel !="-") {
            $conditions[] = "a.gender='" . $this->db->escape_str($by_jenkel) . "'";
        }elseif($by_jenkel =="-"){
            $conditions[] = "a.gender NOT IN ('man','woman')";
        }
        if($by_um !=""){
            if($by_um == 22){
              $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=22 ";
            }elseif($by_um == 21){
              $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=18 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=21";
            }elseif($by_um == 17){
              $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=13 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=17";
            }elseif($by_um == 12){
              $conditions[] = " YEAR(CURDATE()) - YEAR(a.birthdate) >=6 AND  YEAR(CURDATE()) - YEAR(a.birthdate) <=12";
            }else{
              $conditions[] = " a.birthdate IS NULL";
            }
            
        }
        if($by_location !="") {
          $conditions[] = "c.nama_kabupaten LIKE '%" . $this->db->escape_str($by_location) . "%'";
        }

        $sqlFindMinimalSaldo = "";
        if($by_minimal_saldo !=0) {
          $sqlFindMinimalSaldo = " having saldo_point >= " . (int) $by_minimal_saldo . "";
        }

        //(DATE(date) BETWEEN '".date('Y-m-d', strtotime("-1 month"))."' AND '".date('Y-m-d')."')

        $sql = $query;
        if (count($conditions) > 0) {
          $sql .= " AND " . implode(' AND ', $conditions) . "";
        }
        $sql .= " group by a.id_user " . $sqlFindMinimalSaldo . " order by a.date_added desc) as x";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jumlah;
    }

    function count_total_point()
    {
        $sql = "select sum(debet) as total_debet, sum(kredit) as total_kredit, sum(kredit) - sum(debet) as saldo_point from tbl_point_reward where void = 0;";

        $q = $this->db->query($sql);
        $data = $q->row_object();
        $q->free_result();
        return $data;
    }
    
    public function countVoucherByIdUser($id_user)
    {
        $sql = " SELECT count(id_voucher) as jml_voucher FROM `tbl_voucher` 
                    where id_user=".$id_user." and kode_voucher not in (select kode_voucher from tbl_voucher_log)";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jml_voucher;
        
    }

    public function countExpiredVoucherByIdUser($id_user)
    {
        $sql = " SELECT count(id_voucher) as jml_voucher FROM `tbl_voucher` 
                    where id_user=".$id_user." and kode_voucher in (select kode_voucher from tbl_voucher_log)";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->jml_voucher;
        
    }    

    public function isMatrixMerchant($id_user)
    {
        $this->db->select('count(id_produk) as jumlah');
        $this->db->where('id_user',$id_user);
        $this->db->where('channel','MATRIX');
        $query = $this->db->get('tbl_produk');
        $data = $query->row();
        
        if ($data->jumlah > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function NetcoreSync($email, $nama_kabupaten, $gender, $nama)
    {
        $netCoreConfig = $this->config->item('netcore');
        
        /* ATTRIBUTES
         * 4 = nama_kabupaten
         * 3 = gender
         * 2 = nama
         */

        $attributes = '
        <AttributeValues>
            <RECORD><ID>4</ID><Value>'.strtoupper($nama_kabupaten).'</Value></RECORD>
            <RECORD><ID>3</ID><Value>'.strtoupper($gender).'</Value></RECORD>
            <RECORD><ID>2</ID><Value>'.strtoupper($nama).'</Value></RECORD>
        </AttributeValues>
        ';
        
        $data = 'type=contact&activity=Add&data=
            <DATASET>
                <CONSTANT>
                    <ApiKey>'.$netCoreConfig['key'].'</ApiKey>
                    <RefIp></RefIp><RefWeb></RefWeb>
                </CONSTANT>
                <INPUT>
                    <Unique_id></Unique_id>
                    <AddEmail>'.$email.'</AddEmail>
                    '.$attributes.'
                    <Attributecount>3</Attributecount>
                    <ListMember>'.$netCoreConfig['list_id'].'</ListMember>
                    <DoubleOptin></DoubleOptin>
                    <TriggerEmail></TriggerEmail>
                </INPUT>
            </DATASET>';
        
        $ch = curl_init($netCoreConfig['url']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        
        echo $result;
        
        return simplexml_load_string($result);
    }
    
    
    public function insertSyncNetcoreBatch($data)
    {
        $this->db->insert_batch('tbl_user_sync_netcore', $data);
    }
    
    public function extractUserId($data)
    {
        $id_user = array();
        foreach ($data as $val) {
            $id_user[] = $val->id_user;
        }
        
        return $id_user;
    }
    
    public function userSyncedNetcore($id_user_array_filter = array())
    {
        if (!empty($id_user_array_filter)){
            $this->db->where_not_id('id_user',$id_user_array_filter);
        }
        $query = $this->db->get('tbl_user_sync_netcore');
        return $query->result();
    }

    public function get_autocomplete($term)
    {
        $sql = "select * from tbl_user WHERE username LIKE '%" .
               $this->db->escape_like_str($term) ."%'";
        $sql .= " order by username asc";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function isOutlet($id_user)
    {
        $this->db->where('status', 'verified');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('tbl_wholesale_user');
        $data = $query->row();
        if (!empty($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function userIsAvailable($email)
    {
        $result = $this->db->get_where('tbl_user', array('email' => $email, 'deleted' => 0));

        if($result->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getTotalReedemUserVoucer($id_user = '')
    {
        $sql = "select count(*) as total_reedem, kode_voucher from tbl_voucher_log  where id_user='" . (int) $id_user . "' group by kode_voucher";
        $q = $this->db->query($sql);
        $data = $q->result();
        $arr_reedem = array();

        foreach($data as $voucer_log){
            $arr_reedem[$voucer_log->kode_voucher] = $voucer_log->total_reedem;
        }

        return $arr_reedem;
    }

	function get_single_user($where=''){
		$sql=	"select a.*,b.* "
                . " from tbl_user a left join tbl_mobo_outlet b on (b.mbo_id_user=a.id_user and mbo_status='aktif')"
                . " where ".$where." limit 1";
		$q=$this->db->query($sql);
		$data = $q->row();
		$q->free_result();
		return $data;
	}  
        
    /* Check when product not found */
    function check_product_not_found($productid) {
        $sql = "select id_produk from tbl_produk where id_produk='" . $this->db->escape_str($productid) . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /* Check when order not found */
    function check_order_not_found($orderid) {
        $sql = "select id_order from tbl_order where kode_order='" . $this->db->escape_str($orderid) . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /* Check existing AWB number */
    function check_no_awb($kodeOrder) {
        $sql = "select kode_order from tbl_jne_awb_status where kode_order='" . $this->db->escape_str($kodeOrder) . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /* is awb same */
    function check_no_awb_same($kodeOrder,$awbNumber) {
        $sql = "select awb_number from tbl_jne_awb_status where kode_order='" . $this->db->escape_str($kodeOrder) . "' and awb_number='" . $this->db->escape_str($awbNumber) . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

/* End of file  */
/* Location: ./application/models/ */
