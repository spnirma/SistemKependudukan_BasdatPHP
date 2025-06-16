<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {

        parent::__construct();
        $this->load->library('auth');
        $this->auth->check();
    }

	public function index()
	{        
		redirect ('/admin/penduduk');die;
// echo md5('bisemarang');die;		
        $this->auth->cek_hak_akses('dashboard');
		$data=array();
		$data['title']='Dashboard';
		$this->load->view('admin/index', $data);
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */