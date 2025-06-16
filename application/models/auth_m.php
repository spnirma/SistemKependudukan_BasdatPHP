<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_m extends MY_Model {

	public $variable;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->helper('date');
		session_start();
	}

	function cek_email($email=''){
        $sql = "SELECT COUNT(*) AS jumlah FROM tbl_user";
        $sql .= " WHERE email='" . $this->db->escape_str($email) . "'";
//echo $sql;die;
//        $sql .= " WHERE email='andyajadeh@gmail.com'";
        $q = $this->db->query($sql);
        $data = $q->row();
//print_r($data);//die;		
		//$jumlah=0;
        //if (!empty($data))  $jumlah=1;
//echo $jumlah;die;
		$q->free_result();
        return $data->jumlah;
	}

	function update_registrasi($data=''){
            $this->db->set('active', $data['status_aktif']);
            $this->db->set('id_status', $data['status_aktif']);
            $this->db->set('date_verified', $data['date_verified']);
            $this->db->where('id_user', $data['id_user']);
            $this->db->where('email', str_replace(md5('@'), '@', $data['email']));
            $this->db->where('activation_code', $data['kode_aktivasi']);
            $this->db->update('tbl_user');
            $berhasil = TRUE;
            return $berhasil;
	}

	function login($email='', $password='', $remember=0){
		$pass=md5($password);
		if ($remember==1) $pass=($password);
		if ($remember==2) $pass='';
		$sql="select * from tbl_user
            where (telpon = '" . $this->db->escape_str($email) . "' or email = '". $this->db->escape_str($email) ."') ";
		if ($remember!=2) $sql.=" and password = '".$pass."'";		
        $sql.=" and active = 1 AND id_status = 1 AND deleted != 1";
             // and b.merchant_indoloka != 'Y'";
//echo $sql;
		$query=$this->db->query($sql);
//        echo '<pre>';print_r($query);//die;
		if ($query->num_rows() === 1){
			$user = $query->row();

            if ($user->id_level == 8) { //for indoloka login
//                $this->session->set_userdata('partner', $user);
            }
            else if ($user->id_level == 7) {
                $this->session->set_userdata('member', $user);
                $this->session->set_userdata('merchant_id_user', $user->id_user);
            }
            else if ($user->id_level == 6) {
                $this->session->set_userdata('member', $user);
            }
            else if ($user->id_level == 11) {
//                $this->session->set_userdata('member', $user);
            }
            else if ($user->id_level == 12) {
//                $this->session->set_userdata('member', $user);
            }
            else if ($user->id_level == 13) {
//                $this->session->set_userdata('member', $user);
            }
            else if ($user->id_level == 14) {
                $this->session->set_userdata('member', $user);
            }
			else {
                $this->session->set_userdata('member', $user);
            }

			if ($remember){
				//$this->remember_user($user->id_user);
			}
			return true;
		} else {
			return false;
		}
	}

	function login_fb($email){
        $remember = 1;
		$sql="select * from tbl_user where email='". $this->db->escape_str($email) ."' and active=1 AND id_status = 1";
		$query=$this->db->query($sql);
		if ($query->num_rows() === 1){
			$user = $query->row();
			$this->session->set_userdata('member', $user);
			if ($remember){
				$this->remember_user($user->id_user);
			}
			return true;
		} else {
			return false;
		}
    }

	function remember_user($id){
		if (!$id)
		{
			return FALSE;
		}
		$salt = $this->salt();
		$this->db->update('tbl_user', array('remember_code' => $salt), array('id_user' => $id));
		if ($this->db->affected_rows() > -1)
		{
			$expire = (60*60*24*365*2);
			set_cookie(array(
			    'name'   => 'remember_code',
			    'value'  => $salt,
			    'expire' => $expire
			));
			return TRUE;
		}
		return FALSE;
	}	

	function salt(){
		$raw_salt_len = 16;
 		$buffer = '';
        $buffer_valid = false;
        if (function_exists('mcrypt_create_iv') && !defined('PHALANGER')) {
            $buffer = mcrypt_create_iv($raw_salt_len, MCRYPT_DEV_URANDOM);
            if ($buffer) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
            $buffer = openssl_random_pseudo_bytes($raw_salt_len);
            if ($buffer) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid && @is_readable('/dev/urandom')) {
            $f = fopen('/dev/urandom', 'r');
            $read = strlen($buffer);
            while ($read < $raw_salt_len) {
                $buffer .= fread($f, $raw_salt_len - $read);
                $read = strlen($buffer);
            }
            fclose($f);
            if ($read >= $raw_salt_len) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid || strlen($buffer) < $raw_salt_len) {
            $bl = strlen($buffer);
            for ($i = 0; $i < $raw_salt_len; $i++) {
                if ($i < $bl) {
                    $buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
                } else {
                    $buffer .= chr(mt_rand(0, 255));
                }
            }
        }

        $salt = $buffer;

        // encode string with the Base64 variant used by crypt
        $base64_digits   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        $bcrypt64_digits = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $base64_string   = base64_encode($salt);
        $salt = strtr(rtrim($base64_string, '='), $base64_digits, $bcrypt64_digits);
	    $salt = substr($salt, 0, 22);
		return $salt;
	}

    function check() {
//		echo '<pre>';print_r($this->session->userdata('member'));
//		echo 'x';die;
        if (!$this->session->userdata('member')) {
//		echo 'x';die;
//            redirect('/login_ve');
            redirect('/');
        }
    }

    function checkPartnerx() {
        if (!$this->session->userdata('partner')) {
            redirect(base_url(), 'refresh');
        }
    }

    function get_user(){
    	if($this->session->userdata('member')){
    		// $data=$this->get_single('tbl_user', 'id_user', $this->session->userdata('member')->id_user);
    		$sql="select a.*, b.nama_propinsi, c.nama_kabupaten, d.nama_kecamatan
    			from tbl_user a
    			left join tbl_propinsi b on a.id_propinsi=b.id_propinsi
    			left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
    			left join tbl_kecamatan d on a.id_kecamatan=d.id_kecamatan
    			where a.id_user='". (int)$this->session->userdata('member')->id_user ."'";
    		$q=$this->db->query($sql);
    		$data=$q->row();
    		$q->free_result();
    	}
        else if($this->session->userdata('partner')){
            $sql="select a.*, b.nama_propinsi, c.nama_kabupaten, d.nama_kecamatan
                from tbl_user a
                left join tbl_propinsi b on a.id_propinsi=b.id_propinsi
                left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
                left join tbl_kecamatan d on a.id_kecamatan=d.id_kecamatan
                where a.id_user='". (int)$this->session->userdata('partner')->id_user ."'";
            $q=$this->db->query($sql);
            $data=$q->row();
            $q->free_result();
        }
    	else if($this->session->userdata('admin_session')){
    		$data=$this->get_single('tbl_user', 'id_user', (int)$this->session->userdata('admin_session')->id_user);
    	}
    	return $data;
    }

    function get_propinsi($id=''){
    	$this->db->where('id_propinsi', (int)$id);
    	$q=$this->db->get('tbl_propinsi');
    	$data=$q->row();
    	$q->free_result();
    	return $data->nama_propinsi;
    }

    function get_kabupaten($id=''){
    	$this->db->where('id_kabupaten', (int)$id);
    	$q=$this->db->get('tbl_kabupaten');
    	$data=$q->row();
    	$q->free_result();
    	return $data->nama_kabupaten;
    }

    function get_kecamatan($id=''){
    	$this->db->where('id_kecamatan', (int)$id);
    	$q=$this->db->get('tbl_kecamatan');
    	$data=$q->row();
    	$q->free_result();
    	return $data->nama_kecamatan;
    }

    function getCity()
    {
        // $nama = strtoupper($this->input->post('query'));
        $sql = "SELECT nama_kabupaten FROM tbl_kabupaten";
        $q = $this->db->query($sql);
        $data = $q->result_array();
        $output = array();
        foreach ($data as $key => $value) {
            $output[] = $value['nama_kabupaten'];
        }
        echo json_encode($output);
    }

    function getUserNameById($id)
    {
        $sql = "SELECT username as nama from tbl_user
            WHERE id_user = '". (int)$id . "'";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data->nama;
    }
    
    function kata($kata, $limit){
        $kalimat = "";
        $potong = explode(" ", $kata);
        for($i=0; $i<=$limit; $i++){
        if(isset($potong[$i])){
        $kalimat = $kalimat.$potong[$i]." ";
        }
        }
        $hasil = "$kalimat...";
        return $hasil;
    }
    
    function check_key($key)
    {
        $sql = "SELECT * FROM `tbl_partner` WHERE `key` = '".$key."'";
        $query = $this->db->query($sql);
        if ($query->num_rows() === 1) {
            $key = $query->row();
            return true;
        } else {
            return false;
        }
    }
    
    public function insertLoginHistoryLog($email, $from)
    {
        $this->load->library('user_agent');

        if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
            $ip_address = $_SERVER['HTTP_X_REAL_IP'];
        } else {
            $ip_address = $this->input->ip_address();
        }
        
        $data = array(
            'email'         => $email,
            'user_agent'    => $this->agent->agent,
            'tanggal'       => date("Y-m-d H:i:s"),
            'ip_address'    => $ip_address,
            'login_from'    => $from,
        );
        
        $this->db->insert('tbl_user_login_history', $data);
    }
    
    public function insertLoginAttemptLog($email, $from)
    {
        $this->load->library('user_agent');

        if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
            $ip_address = $_SERVER['HTTP_X_REAL_IP'];
        } else {
            $ip_address = $this->input->ip_address();
        }
 
        $data = array(
            'email'         => $email,
            'user_agent'    => $this->agent->agent,
            'tanggal'       => date("Y-m-d H:i:s"),
            'ip_address'    => $ip_address,
            'login_from'    => $from,
        ); 
        
        $this->db->insert('tbl_user_login_attempt', $data);
    }
    
    public function getLoginLogHistory($limit, $offset, $date_start = "", $date_end = "", $email="", $ip_address = "", $login_from = "", $user_agent = "")
    {
        /*
        echo "date start : ".$date_start."<br>";
        echo "date end : ".$date_end."<br>";
        echo "------------------------------------------<br>";
        */
        
        if (!empty($date_start) && !empty($date_end)) {
            $this->db->where("tanggal > '".strftime("%Y-%m-%d", strtotime($date_start))." 00:00:00'");
            $this->db->where("tanggal < '".strftime("%Y-%m-%d", strtotime($date_end))." 23:59:59'");
        }
        if (!empty($email)) {
            $this->db->like('email',$email);
        }
        if (!empty($ip_address)) {
            $this->db->like('ip_address',$ip_address);
        }
        if (!empty($login_from)) {
            $this->db->where('login_from',$login_from);
        }
        if (!empty($user_agent)) {
            $this->db->like('user_agent',$user_agent);
        }
        $this->db->order_by('id','desc');
        $this->db->limit($limit,$offset);
        $query = $this->db->get('tbl_user_login_history');
        return $query->result();
    }
    
    public function countLoginLogHistory($date_start = "", $date_end = "", $email="", $ip_address = "", $login_from = "", $user_agent = "")
    {
        if (!empty($date_start) && !empty($date_end)) {
            $this->db->where("tanggal > '".strftime("%Y-%m-%d", strtotime($date_start))." 00:00:00'");
            $this->db->where("tanggal < '".strftime("%Y-%m-%d", strtotime($date_end))." 23:59:59'");
        }
        if (!empty($email)) {
            $this->db->like('email',$email);
        }
        if (!empty($ip_address)) {
            $this->db->like('ip_address',$ip_address);
        }
        if (!empty($login_from)) {
            $this->db->where('login_from',$login_from);
        }
        if (!empty($user_agent)) {
            $this->db->like('user_agent',$user_agent);
        }
        $this->db->select('count(id) as jumlah');
        $query = $this->db->get('tbl_user_login_history');
        $data = $query->row();
        if(!empty($data)) {
            return $data->jumlah;
        } else {
            return 0;
        }
    }
    
    public function getLoginLogAttempt($limit, $offset, $date_start = "", $date_end = "", $email="", $ip_address = "", $login_from = "", $user_agent = "")
    {
        if (!empty($date_start) && !empty($date_end)) {
            $this->db->where("tanggal > '".strftime("%Y-%m-%d", strtotime($date_start))." 00:00:00'");
            $this->db->where("tanggal < '".strftime("%Y-%m-%d", strtotime($date_end))." 23:59:59'");
        }
        if (!empty($email)) {
            $this->db->like('email',$email);
        }
        if (!empty($ip_address)) {
            $this->db->like('ip_address',$ip_address);
        }
        if (!empty($login_from)) {
            $this->db->where('login_from',$login_from);
        }
        if (!empty($user_agent)) {
            $this->db->like('user_agent',$user_agent);
        }
        $this->db->order_by('id','desc');
        $this->db->limit($limit,$offset);
        $query = $this->db->get('tbl_user_login_attempt');
        return $query->result();
    }
    
    public function countLoginLogAttempt($date_start = "", $date_end = "", $email="", $ip_address = "", $login_from = "", $user_agent = "")
    {
        if (!empty($date_start) && !empty($date_end)) {
            $this->db->where("tanggal > '".strftime("%Y-%m-%d", strtotime($date_start))." 00:00:00'");
            $this->db->where("tanggal < '".strftime("%Y-%m-%d", strtotime($date_end))." 23:59:59'");
        }
        if (!empty($email)) {
            $this->db->like('email',$email);
        }
        if (!empty($ip_address)) {
            $this->db->like('ip_address',$ip_address);
        }
        if (!empty($login_from)) {
            $this->db->where('login_from',$login_from);
        }
        if (!empty($user_agent)) {
            $this->db->like('user_agent',$user_agent);
        }
        $this->db->select('count(id) as jumlah');
        $query = $this->db->get('tbl_user_login_attempt');
        $data = $query->row();
        if (!empty($data)) {
            return $data->jumlah;
        } else {
            return 0;
        }
    }
    
    public function getLoginLogHistoryArray($date_start = "", $date_end = "", $email="", $ip_address = "", $login_from = "", $user_agent = "")
    {
        
        if (!empty($date_start) && !empty($date_end)) {
            $this->db->where("tanggal > '".strftime("%Y-%m-%d", strtotime($date_start))." 00:00:00'");
            $this->db->where("tanggal < '".strftime("%Y-%m-%d", strtotime($date_end))." 23:59:59'");
        }
        if (!empty($email)) {
            $this->db->like('email',$email);
        }
        if (!empty($ip_address)) {
            $this->db->like('ip_address',$ip_address);
        }
        if (!empty($login_from)) {
            $this->db->where('login_from',$login_from);
        }
        if (!empty($user_agent)) {
            $this->db->like('user_agent',$user_agent);
        }
        $this->db->order_by('id','desc');
        $query = $this->db->get('tbl_user_login_history');
        return $query->result_array();
    }
    
    public function exportCountLoginHistory($date_start = "", $date_end = "", $email="", $ip_address = "", $login_from = "", $user_agent = "")
    {
        $this->db->select('*');
        $this->db->select('count(email) as login_count');
        $this->db->select('DATE_FORMAT(tanggal,"%Y-%m-%d") as tgl_harian', false);
        if (!empty($date_start) && !empty($date_end)) {
            $this->db->where("tanggal > '".strftime("%Y-%m-%d", strtotime($date_start))." 00:00:00'");
            $this->db->where("tanggal < '".strftime("%Y-%m-%d", strtotime($date_end))." 23:59:59'");
        }
        if (!empty($email)) {
            $this->db->like('email',$email);
        }
        if (!empty($ip_address)) {
            $this->db->like('ip_address',$ip_address);
        }
        if (!empty($login_from)) {
            $this->db->where('login_from',$login_from);
        }
        if (!empty($user_agent)) {
            $this->db->like('user_agent',$user_agent);
        }
        $this->db->order_by('tgl_harian','asc');
        $this->db->group_by('email');
        $this->db->group_by('tgl_harian');
        $query = $this->db->get('tbl_user_login_history');
        return $query->result_array();
    }
    
    public function getLoginLogAttemptArray($date_start = "", $date_end = "", $email="", $ip_address = "", $login_from = "", $user_agent = "")
    {
        if (!empty($date_start) && !empty($date_end)) {
            $this->db->where("tanggal > '".strftime("%Y-%m-%d", strtotime($date_start))." 00:00:00'");
            $this->db->where("tanggal < '".strftime("%Y-%m-%d", strtotime($date_end))." 23:59:59'");
        }
        if (!empty($email)) {
            $this->db->like('email',$email);
        }
        if (!empty($ip_address)) {
            $this->db->like('ip_address',$ip_address);
        }
        if (!empty($login_from)) {
            $this->db->where('login_from',$login_from);
        }
        if (!empty($user_agent)) {
            $this->db->like('user_agent',$user_agent);
        }
        $this->db->order_by('id','desc');
        $query = $this->db->get('tbl_user_login_attempt');
        return $query->result_array();
    }
    
    public function exportCountLoginAttempt($date_start = "", $date_end = "", $email="", $ip_address = "", $login_from = "", $user_agent = "")
    {
        $this->db->select('*');
        $this->db->select('count(email) as login_count');
        $this->db->select('DATE_FORMAT(tanggal,"%Y-%m-%d") as tgl_harian', false);
        if (!empty($date_start) && !empty($date_end)) {
            $this->db->where("tanggal > '".strftime("%Y-%m-%d", strtotime($date_start))." 00:00:00'");
            $this->db->where("tanggal < '".strftime("%Y-%m-%d", strtotime($date_end))." 23:59:59'");
        }
        if (!empty($email)) {
            $this->db->like('email',$email);
        }
        if (!empty($ip_address)) {
            $this->db->like('ip_address',$ip_address);
        }
        if (!empty($login_from)) {
            $this->db->where('login_from',$login_from);
        }
        if (!empty($user_agent)) {
            $this->db->like('user_agent',$user_agent);
        }
        $this->db->order_by('tgl_harian','asc');
        $this->db->group_by('email');
        $this->db->group_by('tgl_harian');
        $query = $this->db->get('tbl_user_login_attempt');
        return $query->result_array();
    }

    public function resetUserSession($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('tbl_user');
        $user = $query->row();

		if (!empty($user)) {
            if ($user->id_level == 8) {
                $this->session->set_userdata('partner', $user);
            }
            else {
                $this->session->set_userdata('member', $user);
            }
		}
	}

    public function isGoogleFriendlyAddressRegistred($email)
    {
            return true;
        $email = str_replace('.', '', $email);
        $sql = "SELECT id_user, replace(email, '.', '') as email_replaced " .
            "FROM tbl_user HAVING email_replaced = '" . $this->db->escape_str($email) . "';";
        $query = $this->db->query($sql);
        $data = $query->num_rows();
        if ($query->num_rows() === 0) {
            return true;
        } else {
            return false;
        }
    }

	function login_anggota_persib($email='', $password='', $remember=''){
        $vNoAnggota=$this->db->escape_str($email);
        $vPassword=sha1($password);
        //$hitbss = file_get_contents('http://iips2016.com/cipika_persib_login.php?noanggota='.$vNoAnggota.'&password='.$vPassword);              
        $hitbss = file_get_contents($this->config->item('url_persib_login').'?noanggota='.$vNoAnggota.'&password='.$vPassword);              
        //$hitbss = file_get_contents('http://persib.co.id/mobile/fanzone/pendaftaran.aspx');              
// echo $hitbss;die;

//        if (strtoupper(trim($hitbss))=='SUCCESS'){
        if (strpos($hitbss, 'SUCCESS') != false) {
/*
            $sql="select * from tbl_user
                where (hp = '" . $this->db->escape_str($email) . "' || telpon = '" . $this->db->escape_str($email) . "') 
                and active = 1 
                AND id_user in (select id_user from tbl_persib_formulir where no_hp='".$this->db->escape_str($email)."' and  status_member='aktif') "; //AND id_status = 1 AND deleted != 1 
*/
            $sql="select * from tbl_persib_formulir where no_hp='".$this->db->escape_str($email)."' and  status_member='aktif' "; //AND id_status = 1 AND deleted != 1 
// echo $sql;die;
            $query=$this->db->query($sql);
            if ($query->num_rows() === 1){
                $persibmember = $query->row();
                
                $pieces = explode(",", $hitbss);
                $persib_email=trim($pieces[1]);
// echo '='.$persib_email; die;                
                if ($persib_email<>'' && $persib_email<>$persibmember->email) {
                    $this->db->set('email', $persib_email);
                    $this->db->set('username', $persib_email);
                    $this->db->where('id_user', $persibmember->id_user);
                    $this->db->update('tbl_user');

                    $this->db->set('email', $persib_email);
                    $this->db->where('id_user', $persibmember->id_user);
                    $this->db->where('status_member', 'aktif');
                    $this->db->update('tbl_persib_formulir');
                }

                $sql="select * from tbl_user
                    where (id_user = '" . $persibmember->id_user . "') 
                    "; 
                $query1=$this->db->query($sql);
                $user = $query1->row();
                $this->session->set_userdata('member', $user);
                if ($remember){
                    $this->remember_user($user->id_user);
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        // =========================
        $pass=md5($password);
		$sql="select * from tbl_user
            where (hp = '" . $this->db->escape_str($email) . "') and password = '".$pass."' 
            and active = 1 AND id_status = 1 AND deleted != 1 
            AND id_user in (select id_user from tbl_persib_formulir where no_hp='".$this->db->escape_str($email)."' and  status_member='aktif') ";
             // and b.merchant_indoloka != 'Y'";

		$query=$this->db->query($sql);
		if ($query->num_rows() === 1){
			$user = $query->row();

            if ($user->id_level == 8) { //for indoloka login
                $this->session->set_userdata('partner', $user);
            }
            else {
                $this->session->set_userdata('member', $user);
            }

			if ($remember){
				$this->remember_user($user->id_user);
			}
			return true;
		} else {
			return false;
		}
	}
    
    function get_mobo_user($nomor='', $pass=''){
        $sql = "SELECT mbo_id_user,mbo_status, mbo_outlet_id  FROM `tbl_mobo_outlet` a where a.mbo_outlet_id='" . $this->db->escape_str($nomor) . "' or a.mbo_number='" . $this->db->escape_str($nomor) . "'";
        $q = $this->db->query($sql);
        $data = $q->result();
        $vSTatus=0;$vErr='';
        if ($q->num_rows() == 0) {
            $sql = "SELECT a.rfo_outlet_id,  a.rfo_mobo_number
                    FROM `tbl_mobo_ref_outlet` a
                    where a.rfo_outlet_id='" . $nomor . "' or a.rfo_mobo_number='" . $nomor . "'";
            $q1 = $this->db->query($sql);
            $data1 = $q1->result();
            $vSTatus=0;$vErr='';
            if ($q1->num_rows() == 0) {
                $vSTatus=0;$vErr='Mohon maaf, outlet anda masih belum ada di data kami. Hubungi call center kami untuk menindaklanjuti hal ini.';
            } else {
                $vSTatus=0;$vErr='Outlet anda belum melakukan aktifasi. Lakukan aktifasi terlebih dahulu.';
            }
        } else {
            foreach ($data as $v) {
                $vid_user=(int)($v->mbo_id_user);
                if (($vid_user)>0 && trim($v->mbo_status=='aktif')) {              
                    $sql = "SELECT password FROM `tbl_user` a where a.id_user=" . $vid_user . "";
                    $q1 = $this->db->query($sql);
                    $data1 = $q1->result();
                    $vSTatus=0;$vErr='';
                    if ($q1->num_rows() == 0) {
                        $vSTatus=0;$vErr='Mohon maaf, outlet anda masih belum valid. Hubungi call center kami untuk menindaklanjuti hal ini.';
                    } else {
                        foreach ($data1 as $v1) {
                            if (md5($pass)==($v1->password)) {              
                                $vSTatus=1;$vErr='';
                                $vIDUser='';$vErr='';
                                return array('status' => $vSTatus, 'err' => $vErr, 'mbo_id_user'=> $vid_user ,'mbo_id_outlet' => $v->mbo_outlet_id);  
                            } else {
                                $vSTatus=0;$vErr='Password yg anda masukkan salah.';
                            }
                        }        
                    }
                    //return array('status' => 2, 'existIdUser' => $v->id_user, 'reg_persib' =>$v->reg_persib);        
                } else {
                    $vSTatus=0;$vErr='Outlet anda belum melakukan aktifasi..';
                }
            }        
        }
        return array('status' => $vSTatus, 'err' => $vErr);  
    }

    function get_mobo_user_for_activation($nomor='', $pass=''){
        $sql = "SELECT mbo_id_user,mbo_status, mbo_outlet_id, mbo_number  FROM `tbl_mobo_outlet` a where a.mbo_outlet_id='" . $this->db->escape_str($nomor) . "' or a.mbo_number='" . $this->db->escape_str($nomor) . "'";
        $q = $this->db->query($sql);
        $data = $q->result();
        $vSTatus=0;$vErr='';
        if ($q->num_rows() == 0) {
            $vSTatus=1;$vErr='';
        } else {
            foreach ($data as $v) {
                $vid_user=(int)($v->mbo_id_user);
                if (($vid_user)>0 && trim($v->mbo_status=='aktif')) {              
                    $sql = "SELECT email FROM `tbl_user` a where a.id_user=" . $vid_user . "";
                    $q1 = $this->db->query($sql);
                    $data1 = $q1->result();
                    $vSTatus=0;$vErr='';
                    if ($q1->num_rows() == 0) {
                        $vSTatus=1;$vErr='';
                    } else {
                        foreach ($data1 as $v1) {
                                $vSTatus=0;$vErr='Outlet anda sudah pernah melakukan aktifasi menggunakan <br>email : <u>'.$v1->email.'</u> <br>ID Outlet : <u>'.$v->mbo_outlet_id.'</u> <br>Nomor MOBO : <u>'.$v->mbo_number.'</u> <br>Lakukan login menggunakan ID Outlet atau nomor MOBO anda.';
                                return array('status' => $vSTatus, 'err' => $vErr, 'mbo_id_user'=> $vid_user ,'mbo_id_outlet' => $v->mbo_outlet_id);  
                        }        
                    }
                    //return array('status' => 2, 'existIdUser' => $v->id_user, 'reg_persib' =>$v->reg_persib);        
                } else {
                    $vSTatus=1;$vErr='';
                }
            }        
        }
        if ($vSTatus==1) {
            $sql = "SELECT * FROM `tbl_mobo_ref_outlet` a where a.rfo_outlet_id='" . $this->db->escape_str($nomor) . "' or a.rfo_mobo_number='" . $this->db->escape_str($nomor) . "'";
            $q = $this->db->query($sql);
            $data = $q->result();
            $vSTatus=0;$vErr='';
            if ($q->num_rows() == 0) {
                $vSTatus=0;$vErr='Mohon maaf, data outlet anda masukkan belum terdaftar di sistem. Hubungi call center kami untuk menindaklanjuti hal ini.';
            } else {
                foreach ($data as $v) {
                    $vstatus=(trim($v->rfo_status).'');
                    $vnomobo=(trim($v->rfo_mobo_number).'');
                    $vidoutlet=(trim($v->rfo_outlet_id).'');
                    if ($vstatus!='aktif') {      
                        if ($vnomobo=='') {      
                            $vSTatus=0;$vErr='Nomor MOBO anda tidak valid. Hubungi call center kami untuk menindaklanjuti hal ini.';
                        } else if ($vidoutlet=='') {      
                            $vSTatus=0;$vErr='ID Outlet anda tidak valid. Hubungi call center kami untuk menindaklanjuti hal ini.';
                        } else {
                            $vSTatus=1;$vErr='';
                            return array('status' => $vSTatus, 'err' => $vErr, 'id_outlet'=> $vidoutlet , 'no_mobo'=> $vnomobo ,'outlet_name' => $v->rfo_outlet_name);  
                        }
                    } else {
                        $vSTatus=0;$vErr='Outlet anda sudah pernah melakukan aktifasi. <br>Lakukan login menggunakan ID Outlet atau nomor MOBO anda.<br>Jika anda lupa dengan password yg pernah anda gunakan, anda bisa melakukan reset password.';
                    }
                }        
            }
        } 
        return array('status' => $vSTatus, 'err' => $vErr);  
    }    

	function set_reg_session($evIDEnc=''){
		//$pass=md5($password);
		$vidDec=(int)myDecrypt('regbiz',$evIDEnc);
		if ($vidDec>0) {
			$sql1="select * from tb_events
				where ev_id = " . $vidDec . "  
				limit 1
				";
				 // and b.merchant_indoloka != 'Y'";
//echo $sql1;die;
			$query1=$this->db->query($sql1);
			echo $query1->num_rows();
			if ($query1->num_rows() === 1){
				$arrData1 = (array) $query1->row();
				$sql = "SELECT * FROM `tb_events_config` a 
						where a.event_id=" . $vidDec . " 
						and cfg_status=1 and config_id>0 and cfg_item='config'
						order by cfg_id";
				$query2 = $this->db->query($sql);
				$data2 = $query2->result();
				foreach ($data2 as $v2) {
					$arrData2 = array(
						trim($v2->cfg_name) => trim($v2->cfg_value),
					);
					$arrData1 = array_merge($arrData1,$arrData2);
				}
				$arrData = (object) $arrData1;

				$this->session->set_userdata('lu_event', $arrData);
				//$this->session->set_userdata('merchant_id_user', $user->id_user);
				$this->set_reg_user_session($vidDec);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function set_reg_user_session($iddec=0){
        $this->session->unset_userdata('lu_reg_sess');
		//$pass=md5($password);
		$iddec = 100+(int)$iddec;
		$codeVoucher = $iddec.date('ymdHis').strtoupper(random_string('numeric', 5));
		//$vUsrSess=myEncrypt('regbiz',$codeVoucher);
		$user=array(
			'reg_sess' => myEncrypt('regbiz',$codeVoucher),
		);
		$this->session->set_userdata('lu_reg_sess', $user);
		return true;
		
	}	

	function reset_session($modul='all', $session=''){
		if ($modul=='regpre') {
			if ($session=='all') {
				$this->session->unset_userdata('member');
				$this->session->unset_userdata('event');
				$this->session->unset_userdata('lu_event');
				$this->session->unset_userdata('lu_reg_sess');
				$this->session->sess_destroy();
				$this->lib_facebook->destroy_fb();
				$this->cache->clean();
				header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
				header("Expires: Wed, 4 Jul 2012 05:00:00 GMT"); // Date in the past
			} else if ($session=='lu_reg_sess') {
				$this->session->unset_userdata('lu_reg_sess');
//				$this->session->sess_destroy();
//				$this->lib_facebook->destroy_fb();
				$this->cache->clean();
				header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
				header("Expires: Wed, 4 Jul 2012 05:00:00 GMT"); // Date in the past
			}
		} else {
			$this->session->unset_userdata('member');
			$this->session->unset_userdata('event');
			$this->session->unset_userdata('lu_event');
			$this->session->unset_userdata('lu_reg_sess');
			$this->session->unset_userdata('cart_contents');
			$this->session->unset_userdata('client');
			$this->session->sess_destroy();
			$this->lib_facebook->destroy_fb();
			$this->cache->clean();
			header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
			header("Expires: Wed, 4 Jul 2012 05:00:00 GMT"); // Date in the past
		}
	}	
	
    function page_auth($modul='', $page=''){

		//die;
		$vallow				= false; 
		$vredirect			= "no"; 
		$vredirect_page 	= ""; 
		$vmessage			= "";

		switch ($modul) {
			case "regpre":
				$sql = "SELECT * FROM `rf_events_config` where cfg_status=1 and cfg_module='registration' and cfg_section='web'";
				$q = $this->db->query($sql);
				$data = $q->result();
				//echo '<pre>';print_r($data);//die;					
				//print_r($this->session->userdata('lu_event'));//die;					

				foreach ($data as $v) {
					$config=''.$v->cfg_config;
					if (isset($this->session->userdata('lu_event')->$config)) {
						//echo $this->session->userdata('lu_event')->$config;
					} else {
						// auth/restart
						return (object) array(
							'allow' => false, 
							'redirect' => 'yes', 
							'redirect_page' => base_url().'auth/restart', 
							'message' => ''
							);  
						
					}
				}

				//print_r($this->session->userdata('lu_event'));die;					
				if(!$this->session->userdata('lu_event')){
					$vallow				= false; 
					$vredirect			= "yes"; 
					$vredirect_page 	= base_url()."auth/restart"; 
					$vmessage			= "";
				} else {
					$sql = "SELECT * FROM `tb_events` where ev_id=".$this->session->userdata('lu_event')->ev_id;
					$q = $this->db->query($sql);
					$data = $q->result();
// print_r($data);die;					
					if ($q->num_rows() == 0) {
						$vallow				= false; 
						$vredirect			= "yes"; 
						$vredirect_page 	= base_url()."auth/restart"; 
						$vmessage			= "";
					} else {
						foreach ($data as $v) {
							if ((int)($v->ev_status)==0 || (int)($v->ev_active)==0) {
								$vallow				= false; 
								$vredirect			= "yes"; 
								$vredirect_page 	= base_url()."oopss"; 
								$vmessage			= "This event system hasnt been activated yet ";
							} else {	
								$now = date('Y-m-d H:i:s');	
								if ($now<$v->ev_regpre_start) {
									$vallow				= false; 
									$vredirect			= "yes"; 
									$vredirect_page 	= base_url()."oopss"; 
									$vmessage			= "This event hasnt started yet";
								} else if ($now>$v->ev_regpre_end) {
									$vallow				= false; 
									$vredirect			= "yes"; 
									$vredirect_page 	= base_url()."oopss"; 
									$vmessage			= "This registration has been closed";
								} else {
									switch ($page) {
										case "regpreregistration":
											$vallow				= true; 
											$vredirect			= ""; 
											$vredirect_page 	= ""; 
											$vmessage			= "";
										break;
										case "regprecart":
											if(!$this->session->userdata('lu_reg_sess')){
												$vallow				= false; 
												$vredirect			= "yes"; 
												$vredirect_page 	= base_url()."regpreregistration"; 
												$vmessage			= "Opppssss.. something wrong. Please re-Register";
											} else {
												$vallow				= true; 
												$vredirect			= ""; 
												$vredirect_page 	= ""; 
												$vmessage			= "";
											}
										break;
										case "regprepayment":
											if(!$this->session->userdata('lu_reg_sess')){
												$vallow				= false; 
												$vredirect			= "yes"; 
												$vredirect_page 	= base_url()."regprecart"; 
												$vmessage			= "Opppssss.. something wrong. ";
											} else {
												$vallow				= true; 
												$vredirect			= ""; 
												$vredirect_page 	= ""; 
												$vmessage			= "";
											}
										break;
/*
										case "regpreconfirm":
											if(!$this->session->userdata('lu_reg_sess')){
												$vallow				= false; 
												$vredirect			= "yes"; 
												$vredirect_page 	= base_url()."regpreregistration"; 
												$vmessage			= "Opppssss.. something wrong. Please re-Register";
											} else {
												$vallow				= true; 
												$vredirect			= ""; 
												$vredirect_page 	= ""; 
												$vmessage			= "";
											}
										break;
*/
									}
								}
							}
						}        
					}					
				}
			break;
			case "regost":
			break;
			case "regbzm":
			break;
			case "regcli":
				if(!$this->session->userdata('client')){
					
					$vallow				= false; 						$vredirect			= "yes"; 
					$vredirect_page 	= base_url()."regclilogin";  	$vmessage			= "";
				} else {
					$sql = "SELECT * FROM `tb_events` where ev_id=".$this->session->userdata('lu_event')->ev_id;
					$q = $this->db->query($sql);
					$data = $q->result();

//print_r($data);die;					
					if ($q->num_rows() == 0) {
						$vallow				= false; 						$vredirect			= "yes"; 
						$vredirect_page 	= base_url()."regclilogin";  	$vmessage			= "";
					} else {
						foreach ($data as $v) {
							if ((int)($v->ev_status)==0 || (int)($v->ev_active)==0) {
								$vallow				= false; 						$vredirect			= "yes"; 
								$vredirect_page 	= base_url()."oopss";  	$vmessage			="This event system hasnt activated yet ";
							} else {	
								$now = date('Y-m-d H:i:s');	
								// if ($now<$v->ev_regpre_start) {
//									$vallow				= false; 						$vredirect			= "yes"; 
//									$vredirect_page 	= base_url()."oopss";  	$vmessage			="This event system hasnt started yet";
								// } else if ($now>$v->ev_regpre_end) {
//									$vallow				= false; 						$vredirect			= "yes"; 
//									$vredirect_page 	= base_url()."oopss";  	$vmessage			="This event system period has finished";
								// } else {
									switch ($page) {
										case "regclihome":
											$vallow				= true; 
											$vredirect			= ""; 
											$vredirect_page 	= ""; 
											$vmessage			= "";
										break;
										case "regclireg":
											$vallow				= true; 
											$vredirect			= ""; 
											$vredirect_page 	= ""; 
											$vmessage			= "";
										break;
									}
								// }
							}
						}        
					}					
				}			
			break;
		}
//		die;
/*
        $sql = "SELECT mbo_id_user,mbo_status, mbo_outlet_id, mbo_number  FROM `tbl_mobo_outlet` a where a.mbo_outlet_id='" . $this->db->escape_str($nomor) . "' or a.mbo_number='" . $this->db->escape_str($nomor) . "'";
        $q = $this->db->query($sql);
        $data = $q->result();
        $vSTatus=0;$vErr='';
        if ($q->num_rows() == 0) {
            $vSTatus=1;$vErr='';
        } else {
            foreach ($data as $v) {
                $vid_user=(int)($v->mbo_id_user);
                if (($vid_user)>0 && trim($v->mbo_status=='aktif')) {              
                    $sql = "SELECT email FROM `tbl_user` a where a.id_user=" . $vid_user . "";
                    $q1 = $this->db->query($sql);
                    $data1 = $q1->result();
                    $vSTatus=0;$vErr='';
                    if ($q1->num_rows() == 0) {
                        $vSTatus=1;$vErr='';
                    } else {
                        foreach ($data1 as $v1) {
                                $vSTatus=0;$vErr='Outlet anda sudah pernah melakukan aktifasi menggunakan <br>email : <u>'.$v1->email.'</u> <br>ID Outlet : <u>'.$v->mbo_outlet_id.'</u> <br>Nomor MOBO : <u>'.$v->mbo_number.'</u> <br>Lakukan login menggunakan ID Outlet atau nomor MOBO anda.';
                                return array('status' => $vSTatus, 'err' => $vErr, 'mbo_id_user'=> $vid_user ,'mbo_id_outlet' => $v->mbo_outlet_id);  
                        }        
                    }
                    //return array('status' => 2, 'existIdUser' => $v->id_user, 'reg_persib' =>$v->reg_persib);        
                } else {
                    $vSTatus=1;$vErr='';
                }
            }        
        }
        if ($vSTatus==1) {
            $sql = "SELECT * FROM `tbl_mobo_ref_outlet` a where a.rfo_outlet_id='" . $this->db->escape_str($nomor) . "' or a.rfo_mobo_number='" . $this->db->escape_str($nomor) . "'";
            $q = $this->db->query($sql);
            $data = $q->result();
            $vSTatus=0;$vErr='';
            if ($q->num_rows() == 0) {
                $vSTatus=0;$vErr='Mohon maaf, data outlet anda masukkan belum terdaftar di sistem. Hubungi call center kami untuk menindaklanjuti hal ini.';
            } else {
                foreach ($data as $v) {
                    $vstatus=(trim($v->rfo_status).'');
                    $vnomobo=(trim($v->rfo_mobo_number).'');
                    $vidoutlet=(trim($v->rfo_outlet_id).'');
                    if ($vstatus!='aktif') {      
                        if ($vnomobo=='') {      
                            $vSTatus=0;$vErr='Nomor MOBO anda tidak valid. Hubungi call center kami untuk menindaklanjuti hal ini.';
                        } else if ($vidoutlet=='') {      
                            $vSTatus=0;$vErr='ID Outlet anda tidak valid. Hubungi call center kami untuk menindaklanjuti hal ini.';
                        } else {
                            $vSTatus=1;$vErr='';
                            return array('status' => $vSTatus, 'err' => $vErr, 'id_outlet'=> $vidoutlet , 'no_mobo'=> $vnomobo ,'outlet_name' => $v->rfo_outlet_name);  
                        }
                    } else {
                        $vSTatus=0;$vErr='Outlet anda sudah pernah melakukan aktifasi. <br>Lakukan login menggunakan ID Outlet atau nomor MOBO anda.<br>Jika anda lupa dengan password yg pernah anda gunakan, anda bisa melakukan reset password.';
                    }
                }        
            }
        } 
		*/
        return (object) array(
			'allow' => $vallow, 
			'redirect' => $vredirect, 
			'redirect_page' => $vredirect_page, 
			'message' => $vmessage
			);  
    }  	

	function set_cli_session($evIDEnc=''){
		//$pass=md5($password);
		$vidDec=(int)myDecrypt('regbizcli',$evIDEnc);
		if ($vidDec>0) {
			$sql1="select * from tb_events
				where ev_id = " . $vidDec . "  
				limit 1
				";
				 // and b.merchant_indoloka != 'Y'";
//echo $sql1;die;
			$query1=$this->db->query($sql1);
			echo $query1->num_rows();
			if ($query1->num_rows() === 1){
				$arrData1 = (array) $query1->row();
				$sql = "SELECT * FROM `tb_events_config` a 
						where a.event_id=" . $vidDec . " 
						and cfg_status=1 and config_id>0 and cfg_item='config'
						order by cfg_id";
				$query2 = $this->db->query($sql);
				$data2 = $query2->result();
				foreach ($data2 as $v2) {
					$arrData2 = array(
						trim($v2->cfg_name) => trim($v2->cfg_value),
					);
					$arrData1 = array_merge($arrData1,$arrData2);
				}
				$arrData = (object) $arrData1;

				$this->session->set_userdata('lu_event', $arrData);
				//$this->session->set_userdata('merchant_id_user', $user->id_user);
				//$this->set_reg_user_session($vidDec);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function set_login_by_id($id){
        $remember = 1;
		$sql="select * from tbl_user where id_user = '$id'";
		$query=$this->db->query($sql);
		if ($query->num_rows() === 1){
			$user = $query->row();
			$this->session->set_userdata('member', $user);
			return true;
		} else {
			return false;
		}
    }
	
}

/* End of file  */
/* Location: ./application/models/ */

