<?php

class sms_isat_prefix {

	var $url = URL_IMX_ISAT; //'http://api.iklanstore.co.id:9900/'; //sms_isat_prefix
	var $username;
	var $password;
	var $sid;
	var $sessionid;

	function __construct() {

	}

	public function setUsername($username) {
		return $this -> username = $username;
	}

	public function setPassword($password) {
		return $this -> password = $password;
	}
	
	public function setSID($sid) {
		return $this -> sid = $sid;
	}

	function sendSMS($msisdn, $msg) { 

		if ($this->doLogin()) {
			// send sms
			return $this -> requestApi('send/sms/'.$this->sessionid.'/'.$this -> sid.'/'.$msisdn.'/'.$msg);
		}
		return FALSE;
	}

	function doLogin() {
		// create session
		$session = $this -> requestApi('createsession');
		if (empty($session->sessionid)) { return FALSE; }
		$encrypt = strtoupper(md5($session->sessionid . md5($this -> username . $this -> password)));

		// login
		$login = $this -> requestApi('login/'.$session->sessionid . '/'.$this->username . '/' . $encrypt);
		if ($login->result != 0) { return FALSE; }
		
		// set session
		$this->sessionid = $session->sessionid;
		
		return TRUE;
	}

	function requestApi($params) {
		$ch = curl_init($this -> url . $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$data = curl_exec($ch);

		// $info = curl_getinfo($ch);

		curl_close($ch);
		// return $data;
		/*///////////////////////////////////////////////////////////// */
		return json_decode(json_encode(simplexml_load_string($data)));
	}

}
?>