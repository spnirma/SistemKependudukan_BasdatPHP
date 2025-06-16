<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
        $this->load->model('merchant_m');
        $this->load->library('auth');
    }

    public function index()
    {
        $this->auth->check();
        //$this->auth->cek_hak_akses('user_index');
        // $this->auth->cek_hak_akses('merchant_verified');

        $data['alert'] = '';
        $data['title'] = 'user';
        $data['datas'] = $this->user_m->view_all_admin(1000, 0);
        $data['datas2'] = $this->user_m->view_all_member(1000, 0);
        $data['merchant'] = $this->merchant_m->get_merchant(0, 1000);

        $this->load->view('admin/user_v', $data);
    }

    public function admin()
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_admin');
        $data = array();
        if (isset($_GET['alert'])) {
            $data['alert'] = $_GET['alert'];
        } else {
            $data['alert'] = '';
        }

        $data['title'] = 'Admin';
        $user = $this->session->userdata('admin_session');
        $is_allowed_add_all_user = $this->auth->isAllowed($user, 'user_add_all');
        $data['datas'] = $this->user_m->view_all_admin(1000, 0, $is_allowed_add_all_user);
        $this->load->view('admin/user_admin_v', $data);
    }

    public function merchant()
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_merchant');
        $this->load->model('merchant_m');
        $data = array();
        if (isset($_GET['alert'])) {
            $data['alert'] = $_GET['alert'];
        } else {
            $data['alert'] = '';
        }

        if (isset($_GET['hal'])) {
            $hal = $_GET['hal'];
        } else {
            $hal = '';
        }

        $dataPerhalaman = 10;
        ($hal == '') ? $nohalaman = 1 : $nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs((int) $offset);
        $data['offset'] = $offset;

        if (!isset($_GET['s'])) {
            $jmldata = $this->user_m->count_all_merchant();
            $data['paginator'] = $this->user_m->page($jmldata, $dataPerhalaman, $hal);
            $data['datas'] = $this->user_m->view_all_merchant($dataPerhalaman, $off);
            $data['s'] = '';
            $data['fr'] = '';
            $data['to'] = '';
            $data['loc'] = '';
            $data['stat'] = '';
            $data['mail'] = '';
            $data['sales'] = '';
        } else {
            $jmldata = $this->user_m->count_all_merchant_search(
                    $_GET['s'], $_GET['mail'], $_GET['fr'], $_GET['to'], $_GET['stat'], $_GET['sales'], strtoupper($_GET['loc']), $dataPerhalaman, $off
            );
            $data['paginator'] = $this->user_m->page($jmldata, $dataPerhalaman, $hal);
            $data['datas'] = $this->user_m->get_merchant_by_search(
                    $_GET['s'], $_GET['mail'], $_GET['fr'], $_GET['to'], $_GET['stat'], $_GET['sales'], strtoupper($_GET['loc']), $dataPerhalaman, $off
            );
            $data['s'] = $_GET['s'];
            $data['mail'] = $_GET['mail'];
            $data['fr'] = $_GET['fr'];
            $data['to'] = $_GET['to'];
            $data['loc'] = $_GET['loc'];
            $data['stat'] = $_GET['stat'];
            $data['sales'] = $_GET['sales'];
        }
        $data['status'] = $this->user_m->get_status();
        $data['data_sales'] = $this->merchant_m->get_sales();
        $data['title'] = 'Merchant';
//        $data['datas'] = $this->merchant_m->get_merchant(0, 1000);
        $this->load->view('admin/user_merchant_v', $data);
    }

    public function add_merchant()
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('merchant_verified');
        // $this->auth->cek_hak_akses('user_add_merchant');
        $this->load->model('merchant_m');
        $this->load->model('indoloka_m');
        $this->load->library('lib_lokasi');
        $data = array();
        $data['add'] = 'member';
        $data['success'] = '';
        $data['error'] = '';
        $data['title'] = 'Add Merchant';
        $data['merchant_open'] = 'open';
        $data['data_sales'] = $this->merchant_m->get_sales();
        $list = new \Cipika\View\Helper\ListBank();
        $data['bank_list'] = $list->getDataList();

        if ($this->input->post('simpan')) {
// echo '<pre>';print_r($_POST);die;

            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required');
            // $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('nama_store', 'Nama Merchant', 'required');
            $this->form_validation->set_rules('area', 'Area / Karesidenan', 'required');
            $this->form_validation->set_rules('kategori', 'Kategori Produk', 'required');
            // $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            // $this->form_validation->set_rules('id_kabupaten', 'Alamat Kabupaten', 'required');
//            $this->form_validation->set_rules('kecamatan', 'Alamat Kecamatan', 'required');
            // $this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'required');
            // $this->form_validation->set_rules('tgl_lahir_pemilik', 'Tgl Lahir', 'required');
            // $this->form_validation->set_rules('telpon', 'Telp', 'required');
            // $this->form_validation->set_rules('hp', 'No HP', 'required|min_length[10]');
            // $this->form_validation->set_rules('gender', 'Gender', 'required');
            // $this->form_validation->set_rules('bank_nama', 'Nama Bank', 'required');
            // $this->form_validation->set_rules('bank_norek', 'No Rekening', 'required');
            // $this->form_validation->set_rules('bank_pemilik', 'Pemegang Rekening', 'required');
            // $this->form_validation->set_rules('id_jne_origin', 'Kota JNE Origin', '');
            // $this->form_validation->set_rules('lokasi_pickup', 'Alamat Pick Up', '');
            // $this->form_validation->set_rules('pic', 'PIC', '');
            // $this->form_validation->set_rules('telpon_pic', 'Nomer Telpone PIC', '');
            // $this->form_validation->set_rules('merchant_indoloka', 'Merchant Indoloka', '');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                $vArea=$this->input->post('area');
                $vKategori=$this->input->post('kategori');
                $cek_email = $this->user_m->get_email_user($this->input->post('email'));
// echo $vArea.'<br>';print_r($_POST);die;
                if (empty($cek_email)) {
                    $IdvKecamatan=1092;
                    // if (($this->input->post('kecamatan')<>'')) $IdvKecamatan=(int)$this->input->post('kecamatan');
// echo $IdvKecamatan;die;
                    $input_member = array('bn_id' => null,
                        'bn_event' => EVENTID,
                        'bn_kategori' => $vKategori,
                        'bn_eventname' => 'gayeng25',
                    );
// echo 'insert';die;
                    $insert_kategori = $this->user_m->insert('tbl_binaan', $input_member);
                    $update = array('bn_number' => $insert_kategori);
                    $this->merchant_m->update('tbl_binaan', 'bn_id', (int) $insert_kategori, $update);

                    $input_member = array('id_user' => null,
                        'user_ev' => EVENTID,
                        // 'username' => $this->input->post('email'),
                        'password' => md5('bisemarang'), //md5($this->input->post('password')), //md5('123456'),
                        // 'email' => $email,
                        'active' => 1,
                        'firstname' => $this->input->post('nama_store'),
                        // 'alamat' => $this->input->post('alamat'),
                        'id_level' => 7,
                        'id_status' => 1,
                        'id_group' => 3,
                        // 'created_by' => $this->session->userdata('admin_session')->id_user,
                        'date_added' => date('Y-m-d H:i:s'),
                        'date_modified' => date('Y-m-d H:i:s'),
                        'id_kota' => (int)$IdvKecamatan,
                        'id_kecamatan' => (int)$IdvKecamatan,
                        'id_kabupaten' => 144, //(int)$this->input->post('id_kabupaten'),
                        'id_propinsi' => 5, //(int)$this->input->post('id_propinsi'),
//                         'event' => 'gayeng25',
                    );
// echo 'insert';die;
                    $insert_member = $this->user_m->insert('tbl_user', $input_member);
// echo 'insert'.$insert_member;die;
                    $id_user = $insert_member;

                    $email = 'umkm'.$id_user.'@gmail.com'; //strtolower(trim($this->input->post('email')));
                    $update = array('email' => $email, 'username' => $email);
                    $this->merchant_m->update('tbl_user', 'id_user', (int) $id_user, $update);

                } else {
                    $id_user = $cek_email->id_user;
                    $email = $cek_email->email;
                }

                $store = $this->merchant_m->get_single('tbl_store', 'id_user', $id_user);
// echo $id_user; print_r($store);die;

                if (empty($store)) {
                    if ($this->session->userdata('admin_session')->id_level == 8) {
                        $aggregator = $this->input->post('merchant_sales');
                        $status = 'pending';
                    } else {
                        $aggregator = null;
                        $status = 'approve';
                    }
                    $aggregator = null;
                    $status = 'approve';

                    $insert = array(
                            'id_event' => EVENTID,
                            // 'id_kota' => 1891, //$this->input->post('kecamatan'),
                            // 'id_kecamatan' => 1891, //$this->input->post('kecamatan'),
                            // 'id_kabupaten' => 228, //$this->input->post('id_kabupaten'),
                            // 'id_propinsi' => 21, //$this->input->post('id_propinsi'),
                            'id_user' => (int) $id_user,
                            'id_jne_origin' => 1, //$this->input->post('merchant_sales'),
                            'negara' => '-',
                            'nama_store' => $this->input->post('nama_store'),
                            'email' => $email,
                            'store_slug' => $this->commonlib->generate_permalink($this->input->post('nama_store'), 'tbl_store', 'id_store', 'store_slug'),
                            // 'deskripsi' => $this->input->post('biodata'),
                            'shipper' => 1, //$this->input->post('id_jne_origin'),
                            'nama_pemilik' => $this->input->post('nama_pemilik'),
                            // 'tgl_lahir_pemilik' => strftime('%Y-%m-%d', strtotime($this->input->post('tgl_lahir_pemilik'))),
                            // 'alamat' => $this->input->post('alamat'),
                            // 'lokasi_pickup' => $this->input->post('lokasi_pickup'),
                            // 'telpon' => $this->input->post('telpon'),
                            // 'merchant_hp' => $this->input->post('hp'),
                            // 'merchant_gender' => $this->input->post('gender'),
                            // 'agregator' => $aggregator,
                            // 'indoloka_type' => $this->input->post('indoloka_type'),
                            // 'merchant_voucher_reload' => $this->input->post('merchant_voucher_reload'),
                            // 'pic' => $this->input->post('pic'),
                            // 'telpon_pic' => $this->input->post('telpon_pic'),
                            'ym' => '',
                            'fb' => '',
                            'tw' => '',
                            'bb' => '',
                            'wa' => '',
                            'deleted' => 0,
                            'id_sales' => 0,
                            // 'pic_email' => $email,
                            'sumber' => $this->input->post('kota'),
                            // 'bank_nama' => $this->input->post('bank_nama'),
                            //  'bank_branch' => $this->input->post('bank_branch'),
                            //  'bank_bi_code' => $this->input->post('bank_bi_code'),
                            'binaan' => $insert_kategori,
                            'marketplace4' => $vArea,
                            'store_status' => $status,
                            'created_by' => $this->session->userdata('admin_session')->id_user,
                            'date_added' => date('Y-m-d H:i:s'),
                            'date_modified' => date('Y-m-d H:i:s'),
                            'date_verified' => date('Y-m-d H:i:s'),
							'event' => 'gayeng25',
                        );

                    if ($this->input->post('merchant_indoloka') != '') {
                        // $insert['merchant_indoloka'] = $this->input->post('merchant_indoloka');
                        // $insert['indoloka_type'] = $this->input->post('indoloka_type');
                    }
                    $insert1 = $this->merchant_m->insert('tbl_store', $insert);
// echo $insert1;echo '<pre>';print_r($insert);die;
                    // $update = array('id_kabupaten' => 228);
                    // $this->merchant_m->update('tbl_store', 'id_store', (int) $insert1, $update);

                    //# Update status level user ke merchant (7)
                    // $update = array('id_level' => 7);
                    // $this->merchant_m->update('tbl_user', 'id_user', (int) $id_user, $update);

                    if ($insert1) {
                        $data['success'] = 'success';
                        redirect(admin_url().('merchant/merchant_verified'));
                    } else {
                        $data['error'] = 'failed';
                    }
                } else {
                    $data['error'] = 'Email ini telah digunakan oleh UMKM existing. Mohon gunakan email yang lain.';
                }
            }
        }
        $data['kota'] = $this->user_m->get_all_data('tbl_kota', 'id_kota', 'asc');
        $data['jne_origin'] = $this->merchant_m->get_jne_origin();
        $data['agregator'] = $this->indoloka_m->getAgregator();
        $this->load->view('admin/merchant/add_merchant_v', $data);
    }

    public function member()
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_member');
        $data = array();
        if (isset($_GET['alert'])) {
            $data['alert'] = $_GET['alert'];
        } else {
            $data['alert'] = '';
        }

        if (isset($_GET['hal'])) {
            $hal = $_GET['hal'];
        } else {
            $hal = '';
        }

        $dataPerhalaman = 10;
        ($hal == '') ? $nohalaman = 1 : $nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs((int) $offset);
        $data['offset'] = $offset;

        if (!isset($_GET['s'])) {
            $jmldata = $this->user_m->count_all_member();
            $data['paginator'] = $this->user_m->page($jmldata, $dataPerhalaman, $hal);
            $data['datas'] = $this->user_m->view_all_member($dataPerhalaman, $off);
            $data['s'] = '';
            $data['fr'] = '';
            $data['to'] = '';
            $data['loc'] = '';
            $data['stat'] = '';
            $data['mail'] = '';
        } else {
            $jmldata = $this->user_m->count_all_member_search(
                        $_GET['s'],
                        $_GET['mail'],
                        $_GET['fr'],
                        $_GET['to'],
                        $_GET['stat'],
                        strtoupper($_GET['loc']),
                        $dataPerhalaman,
                        $off
                    );
            $data['paginator'] = $this->user_m->page($jmldata, $dataPerhalaman, $hal);
            $data['datas'] = $this->user_m->get_member_by_search(
                        $_GET['s'],
                        $_GET['mail'],
                        $_GET['fr'],
                        $_GET['to'],
                        $_GET['stat'],
                        strtoupper($_GET['loc']),
                        $dataPerhalaman,
                        $off
                    );
            $data['s'] = $_GET['s'];
            $data['mail'] = $_GET['mail'];
            $data['fr'] = $_GET['fr'];
            $data['to'] = $_GET['to'];
            $data['loc'] = $_GET['loc'];
            $data['stat'] = $_GET['stat'];
        }
        $data['status'] = $this->user_m->get_status();
        $data['title'] = 'Member';
        $this->load->view('admin/user_member_v', $data);
    }

    public function profile($id = '')
    {
        $this->auth->check();
        // $this->auth->cek_hak_akses('user_profile');
        $this->auth->cek_hak_akses('merchant_verified');
        if ($id == '') {
            redirect(admin_url().('dashboard'));
        }
        $data = array();
        $data['success'] = '';
        $data['error'] = '';
        $data['title'] = 'Profile';
        if ($this->input->post('simpan')) {
            $input = array(
                // 'username' => $this->input->post('username'),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'bio' => $this->input->post('bio'),
                'alamat' => $this->input->post('alamat'),
                'telpon' => $this->input->post('telpon'),
                'id_kota' => $this->input->post('id_kota'),
            );
            $update = $this->user_m->update('tbl_user', 'id_user', $this->session->userdata('admin_session')->id_user, $input);
            // echo $update;exit;
            if ($_FILES['user_image']['name']) {
                $image = $this->user_m->get_image($this->session->userdata('admin_session')->id_user);
                if ($image) {
                    unlink('asset/upload/profil/'.$image);
                }
                $nama_baru = date('YmdHis').$_FILES['user_image']['name'];
                move_uploaded_file($_FILES['user_image']['tmp_name'], 'asset/upload/profil/'.$nama_baru);
                $inp_pp = array(
                    'image' => $nama_baru,
                );
                $ganti = $this->user_m->update('tbl_user', 'id_user', $this->session->userdata('admin_session')->id_user, $inp_pp);
            }
            if ($update || isset($ganti)) {
                $data['success'] = 'success';
            } else {
                $data['error'] = 'Failed';
            }
        }
        $data['data'] = $this->user_m->get_single('tbl_user', 'id_user', $this->session->userdata('admin_session')->id_user);
        $data['kota'] = $this->user_m->get_all_data('tbl_kota', 'id_kota', 'asc');
        $this->load->view('admin/user_profil_v', $data);
    }

    public function setting()
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_setting');
        $data = array();
        $data['success'] = '';
        $data['error'] = '';
        $data['title'] = 'Setting';
        if ($this->input->post('simpan')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('old_password', 'Old Password', 'required');
            $this->form_validation->set_rules('password', 'New Password', 'required|matches[passconf]|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Konfirmasi password', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                $cek_password = $this->user_m->cek_password($this->session->userdata('admin_session')->id_user, md5($this->input->post('old_password')));
                if ($cek_password > 0) {
                    $ganti = $this->user_m->update('tbl_user', 'id_user', $this->session->userdata('admin_session')->id_user, array('email' => $this->input->post('email'),  'password' => md5($this->input->post('password'))));
                    if ($ganti) {
                        $data['success'] = 'Email dan password berhasil diganti.';
                    } else {
                        $data['error'] = 'Failed';
                    }
                } else {
                    $data['error'] = 'Password Anda salah';
                }
            }
        }
        $data['data'] = $this->user_m->get_single('tbl_user', 'id_user', $this->session->userdata('admin_session')->id_user);
        $this->load->view('admin/user_setting_v', $data);
    }

    public function password()
    {
        $this->auth->check();
        $data = array();
        $data['success'] = '';
        $data['error'] = '';
        if ($this->input->post('simpan')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('old_password', 'Old Password', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                $cek_password = $this->user_m->cek_password($this->session->userdata('admin_session')->id_user, md5($this->input->post('old_password')));
                if ($cek_password > 0) {
                    $ganti = $this->user_m->update('tbl_user', 'id_user', $this->session->userdata('admin_session')->id_user, array('password' => md5($this->input->post('password'))));
                    if ($ganti) {
                        $data['success'] = 'success';
                    } else {
                        $data['error'] = 'Failed';
                    }
                }
            }
        }
        $data['data'] = $this->user_m->get_single('tbl_user', 'id_user', $this->session->userdata('admin_session')->id_user);
        $this->load->view('admin/user_password_v', $data);
    }
    public function add()
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_add');
        $this->load->model('indoloka_m');
        $data = array();
        $data['add'] = 'admin';
        $data['success'] = '';
        $data['error'] = '';
        $data['title'] = 'Add User';
        if ($this->input->post('simpan')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|is_unique[tbl_user.username]');
            $this->form_validation->set_rules('firstname', 'Firstname', 'required');
            $this->form_validation->set_rules('lastname', 'Lastname', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tbl_user.email]');
            $this->form_validation->set_rules('id_kota', 'Kota', 'required');
            $this->form_validation->set_rules('id_level', 'Level', 'required');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                $input = array(
                    'id_user' => null,
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'email' => $this->input->post('email'),
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'id_kota' => $this->input->post('id_kota'),
                    'gender' => $this->input->post('gender'),
                    'id_level' => $this->input->post('id_level'),
                    'bank_nama' => $this->input->post('bank_nama'),
                    'bank_norek' => $this->input->post('bank_norek'),
                    'bank_pemilik' => $this->input->post('bank_pemilik'),
                    'created_by' => $this->session->userdata('admin_session')->id_user,
                    'date_added' => date('Y-m-d H:i:s'),
                    'date_modified' => date('Y-m-d H:i:s'),
                );
                if ($this->input->post('id_level') == 8) {
                    $input['kode_agregator'] = $this->input->post('kode_agregator');
                    $input['date_become_agregator'] = date('Y-m-d H:i:s');
                }
                $insert = $this->user_m->insert('tbl_user', $input);
                if ($insert) {
                    $data['success'] = 'Admin berhasil di buat';
                    $_POST = array();
                } else {
                    $data['error'] = 'failed';
                }
            }
        }

        if ($this->input->post('upgrade_user')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('id_level', 'Level', 'required');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                $cek_email = $this->user_m->get_email_user($this->input->post('email'));
                if (!empty($cek_email)) {
                    $input = array(
                        'email' => $this->input->post('email'),
                        'id_level' => $this->input->post('id_level'),
                        'date_modified' => date('Y-m-d H:i:s'),
                    );
                    if ($this->input->post('id_level') == 8) {
                        $input['kode_agregator'] = $this->input->post('kode_agregator');
                        $input['date_become_agregator'] = date('Y-m-d H:i:s');
                    }
                    $update = $this->user_m->update('tbl_user', 'id_user', $cek_email->id_user, $input);
                    $cek_level = $this->user_m->get_single('tbl_level', 'id_level', $this->input->post('id_level'));
                    if ($update) {
                        $data['success'] = 'Member '.$this->input->post('email').' berhasil diubah menjadi '.$cek_level->nama_level;
                    } else {
                        $data['error'] = 'failed';
                    }
                } else {
                    $data['error'] = 'Email belum terdaftar. Silahkan gunakan form Add New Admin.';
                }
            }
        }
        $data['kota'] = $this->user_m->get_all_data('tbl_kota', 'id_kota', 'asc');
        $data['level'] = $this->user_m->get_all_data('tbl_level', 'id_level', 'asc');
        $data['agregator'] = $this->indoloka_m->getAgregator();
        $this->load->view('admin/user_add_v', $data);
    }

    public function edit($id = '')
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_edit');
        $data = array();
        $data['edit'] = 'admin';
        $data['success'] = '';
        $data['error'] = '';
        $data['title'] = 'Edit User';
        if ($this->input->post('simpan')) {
            $this->load->library('form_validation');
            // $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
            $this->form_validation->set_rules('firstname', 'Firstname', 'required');
            $this->form_validation->set_rules('lastname', 'Lastname', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('id_kota', 'Kota', 'required');
            $this->form_validation->set_rules('id_level', 'Level', 'required');
            $this->form_validation->set_rules('id_status', 'Status', 'required');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                // if($this->user_m->cek_username($id, $this->input->post('username'))==0){
            $input = array(
                // 'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'gender' => $this->input->post('gender'),
                'id_kota' => $this->input->post('id_kota'),
                'id_level' => $this->input->post('id_level'),
                'bank_nama' => $this->input->post('bank_nama'),
                'bank_norek' => $this->input->post('bank_norek'),
                'bank_pemilik' => $this->input->post('bank_pemilik'),
                'id_status' => $this->input->post('id_status'),
                'date_modified' => date('Y-m-d H:i:s'),
            );

                if ($this->input->post('id_status') == 1) {
                    $input['active'] = 1;
                }

                $this->db->trans_begin();
                $insert = $this->user_m->update('tbl_user', 'id_user', $id, $input);
                $status = $this->user_m->get_single('tbl_status', 'id_status', $this->input->post('id_status'));
                $log = $this->user_m->insert('tbl_user_status_log', array(
                'id_user' => $id,
                'id_admin' => $this->session->userdata('admin_session')->id_user,
                'status' => $status->nama_status,
                'date_added' => date('Y-m-d H:i:s'),
                ));

                if ($this->db->trans_status() === true) {
                    $this->db->trans_commit();
                    $data['success'] = 'success';
                } else {
                    $data['error'] = 'failed';
                    $this->db->trans_rollback();
                }

            // }else {
            // 	$data['error']='Username already exist.';
            // }
            }
        }
        $data['data'] = $this->user_m->get_single('tbl_user', 'id_user', $id);
        $data['kota'] = $this->user_m->get_all_data('tbl_kota', 'id_kota', 'asc');
        $data['level'] = $this->user_m->get_all_data('tbl_level', 'id_level', 'asc');
        $data['status'] = $this->user_m->get_all_data('tbl_status', 'id_status', 'asc');
        $this->load->view('admin/user_edit_v', $data);
    }

    public function edit_merchant($id = '')
    {
        $this->auth->check();
//        $this->auth->cek_hak_akses('user_edit_merchant');
        $this->load->model('merchant_m');
        $this->load->model('indoloka_m');
        $this->load->library('lib_lokasi');

        $data['edit'] = 'admin';
        $data['success'] = '';
        $data['error'] = '';
        $data['title'] = 'Edit Merchant';
        $data['merchant_open'] = 'open';
        $data['store'] = $id;

        $list = new \Cipika\View\Helper\ListBank();
        $data['bank_list'] = $list->getDataList();

        $sql = "
        SELECT * FROM `tbl_kabupaten` where id_propinsi in (4,9) 
        group by nama_kabupaten
        order by nama_kabupaten 
        ";
        $query = $this->db->query($sql);
        $data['data_kabupaten'] = $query->result();

		
        if ($this->input->post('simpan')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nama_store', 'Nama Store', 'required');
            // $this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'required');
            // $this->form_validation->set_rules('alamat', 'Alamat Merchant', '');
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');
//			$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
            // $this->form_validation->set_rules('tgl_lahir_pemilik', 'Tanggal Lagir', '');
            // $this->form_validation->set_rules('telpon', 'Telpon', 'required');
            // $this->form_validation->set_rules('hp', 'No HP', 'required|min_length[10]');
            $this->form_validation->set_rules('biodata', 'Deskripsi', '');
            // $this->form_validation->set_rules('bank_nama', 'Nama Bank', '');
            // $this->form_validation->set_rules('bank_norek', 'No Rekening', '');
            // $this->form_validation->set_rules('bank_pemilik', 'Pemilik Bank', '');
            // $this->form_validation->set_rules('id_jne_origin', 'Kota JNE Origin', '');
            // $this->form_validation->set_rules('lokasi_pickup', 'Alamat Pick Up', '');
            // $this->form_validation->set_rules('pic', 'pic', '');
            // $this->form_validation->set_rules('telpon_pic', 'Telpon PIC', '');
            // $this->form_validation->set_rules('merchant_indoloka', 'Merchant Indoloka', '');
//			$this->form_validation->set_rules('store_status', 'Status', 'required');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                $merchant = $this->user_m->get_single('tbl_store', 'id_store', $id);

				
				if ($_FILES['banner_upload']['name']) {
					/*
					$image = $this->user_m->get_image($this->session->userdata('admin_session')->id_user);
					if ($image) {
						unlink('asset/upload/profil/'.$image);
					}
					*/
					$nama_baru = date('YmdHis').$_FILES['banner_upload']['name'];
					move_uploaded_file($_FILES['banner_upload']['tmp_name'], 'asset/upload/'.$nama_baru);
					$inp_pp = array(
						'bb' => $nama_baru,
					);
					$ganti = $this->user_m->update('tbl_store', 'id_store', $id, $inp_pp);
				}
				/*
				echo '='.$ganti;die;				
				if ($update || isset($ganti)) {
					$data['success'] = 'success';
				} else {
					$data['error'] = 'Failed';
				}
				*/
			
			
                $update = array(
//                                     'store_status'     => $this->input->post('store_status'),
                                     'deskripsi' => $this->input->post('biodata'),
                                     'deskripsi_en' => $this->input->post('deskripsi_en'),
//                                     'binaan' => $this->input->post('binaan'),
                                     'id_kota' => (int)$this->input->post('kecamatan'),
                                     'id_kecamatan' => (int)$this->input->post('kecamatan'),
                                     'id_kabupaten' => (int)$this->input->post('id_kabupaten'),
                                     'id_propinsi' => (int)$this->input->post('id_propinsi'),
                                     'nama_store' => $this->input->post('nama_store'),
//                                     'store_slug' => $this->commonlib->generate_permalink($this->input->post('nama_store'), 'tbl_store', 'id_store', 'store_slug'),
                                     'nama_pemilik' => $this->input->post('nama_pemilik'),
//                                     'tgl_lahir_pemilik' => strftime('%Y-%m-%d', strtotime($this->input->post('tgl_lahir_pemilik'))),
                                     'alamat' => $this->input->post('alamat'),
//                                     'lokasi_pickup' => $this->input->post('lokasi_pickup'),
//                                     'telpon' => $this->input->post('telpon'),
                                     'merchant_hp' => $this->input->post('hp'),
//                                     'merchant_voucher_reload' => $this->input->post('merchant_voucher_reload'),
                                     'id_sales' => $this->input->post('merchant_sales'),
                                     'pic' => $this->input->post('pic'),
                                     'telpon_pic' => $this->input->post('telpon_pic'),
//                                     'bank_nama' => $this->input->post('bank_nama'),
//                                     'bank_branch' => $this->input->post('bank_branch'),
//                                     'bank_bi_code' => $this->input->post('bank_bi_code'),
//                                     'bank_norek' => $this->input->post('bank_norek'),
//                                     'bank_pemilik' => $this->input->post('bank_pemilik'),
//                                     'id_jne_origin' => $this->input->post('id_jne_origin'),
                                       'pic_email' => $this->input->post('pic_email'),
                                       'marketplace1' => $this->input->post('marketplace1'),
                                       'marketplace2' => $this->input->post('marketplace2'),
                                       'marketplace3' => $this->input->post('marketplace3'),
                                       'marketplace4' => ucfirst(strtolower($this->input->post('marketplace4'))),
                                       'wa' => $this->input->post('wa'),
                                       'ig' => $this->input->post('ig'),
                                       'fb' => $this->input->post('fb'),
                                       'tw' => $this->input->post('tw'),
                                       'website' => $this->input->post('website'),
                                       'ekspor' => $this->input->post('ekspor'),
                                       'ekspor_en' => $this->input->post('ekspor_en'),
                                    );
//                }

                if ($this->input->post('merchant_indoloka') != '') {
                    $update['merchant_indoloka'] = $this->input->post('merchant_indoloka');
                    $update['indoloka_type'] = $this->input->post('indoloka_type');
                    $updateUser['kode_agregator'] = $this->input->post('merchant_indoloka');
                    $updateUser['date_become_agregator'] = date('Y-m-d H:i:s');
                } else {
                    $update['merchant_indoloka'] = null;
                    $updateUser['date_become_agregator'] = null;
                    $updateUser['kode_agregator'] = $this->input->post('merchant_indoloka');
                }

                $udpdate = $this->user_m->update('tbl_store', 'id_store', (int) $id, $update);
//echo $this->db->last_query();die;
                if ($udpdate) {
                    //kirim email disini
//                	if($this->input->post('store_status')=='approve' && ($this->input->post('store_status')!=$this->input->post('curr_status'))){
//						$data_email='<p>Selamat, Akun Anda telah terverifikasi sebagai Merchant di Cipika Store.</p>';
//						$data_email.='<p>Anda dapat mengatur panel merchant Anda di <a href="'.base_url().'merchant">' . base_url() .'merchant' . '</a></p>';
//
//						$config=$this->_mail_win();
//						$this->load->library('email', $config);
//						$this->email->set_newline("\r\n");
//						$this->email->from($this->config->item('email_from'), 'Cipika Store');
//						$this->email->to($merchant->email);
//						// $this->email->bcc($this->config->item('email_tujuan'));
//						$this->email->subject('Verifikasi Merchant Cipika');
//						$this->email->message($data_email);
//						$send = $this->email->send();
//					}
                    if (!empty($updateUser)) {
                        $id_user = $this->input->post('id_user');
                        $this->user_m->update('tbl_user', 'id_user', (int) $id_user, $updateUser);
                    }
                    $data['success'] = 'success';
                } else {
                    $data['error'] = 'failed';
                }
//                else $data['error']='failed';
            }
        }

        $data['data'] = $this->user_m->get_single('tbl_store', 'id_store', $id);
//echo $data['data']->marketplace4.'<pre>'; print_r($data['data']);die;		
//        $data['produk'] = $this->produk_m->get_all_produk_user($data['data']->id_user);
        $data['produk'] = $this->produk_m->get_all_produk_user_edit_merchant($data['data']->id_user);
//echo $data['data']->id_user.'<pre>'; print_r($data['produk']);die;		
        $data['sales'] = $this->produk_m->get_single('tbl_user', 'id_user', $data['data']->id_sales);
        $data['jne_origin'] = $this->merchant_m->get_jne_origin();
        $data['data_sales'] = $this->merchant_m->get_sales();
        $data['agregator'] = $this->indoloka_m->getAgregator();
        $data['binaan'] = $this->merchant_m->get_binaan();
//echo 'done';die;
        $this->load->view('admin/merchant/edit_merchant_v', $data);
    }

    public function delete($id = '', $page = '')
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_delete');
        $delstore = $this->user_m->delete('tbl_store', 'id_user', $id);
        $del = $this->user_m->delete('tbl_user', 'id_user', $id);
        if ($del) {

            // Action Log : Delete User
            $actionLog = new Cipika\Common\ActionLog();
            $actionLog::save('tbl_user', (int) $id, 'delete_user', '', $this->session->userdata('admin_session')->id_user);

            if ($page == 'admin') {
                redirect(admin_url().'user/admin/?alert=success');
            }
            if ($page == 'merchant') {
                redirect(admin_url().'user/merchant/?alert=success');
            }
            if ($page == 'member') {
                redirect(admin_url().'user/member/?alert=success');
            }
        }
    }

    public function delete_agregator($id = '')
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_delete_agregator');
        $del = $this->user_m->delete('tbl_agregator', 'id_agregator', $id);
        if ($del) {
            redirect(admin_url().'user/agregator/?alert=success');
        }
    }

    public function hapus($id = '', $page = '')
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_hapus');
        // $delstore = $this->user_m->delete('tbl_store', 'id_user', $id);
        $this->db->trans_begin();
        $del = $this->user_m->update('tbl_user', 'id_user', $id, array('deleted' => 1, 'active' => 0));
        $log = $this->user_m->insert('tbl_user_status_log', array(
            'id_user' => $id,
            'id_admin' => $this->session->userdata('admin_session')->id_user,
            'status' => 'Terhapus',
            'date_added' => date('Y-m-d H:i:s'),
            ));
        $del2 = $this->user_m->update('tbl_produk', 'id_user', $id, array('deleted' => 1));

        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();

            // Action Log : Delete Merchant
            $actionLog = new Cipika\Common\ActionLog();
            $actionLog::save('tbl_store', (int) $id, 'delete_merchant', '', $this->session->userdata('admin_session')->id_user);

            if ($page == 'admin') {
                redirect(admin_url().'user/admin/?alert=success');
            }
            if ($page == 'merchant') {
                redirect(admin_url().'user/merchant/?alert=success');
            }
            if ($page == 'member') {
                redirect(admin_url().'user/member/?alert=success');
            }
        } else {
            $this->db->trans_rollback();
        }
    }

    public function add_member()
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_add_member');
        $this->load->library('lib_lokasi');
        $data = array();
        $data['add'] = 'member';
        $data['success'] = '';
        $data['error'] = '';
        $data['title'] = 'Add Member';
        if ($this->input->post('simpan')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tbl_user.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
            $this->form_validation->set_rules('username', 'Nama Tampilan', 'required');
            $this->form_validation->set_rules('birthdate', 'Nama Tampilan', '');
            $this->form_validation->set_rules('firstname', 'Nama Depan', 'required');
            $this->form_validation->set_rules('lastname', 'Nama Belakang', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('telpon', 'Telpon', 'required|numeric');
            $this->form_validation->set_rules('hp', 'Hp', 'required|numeric|min_length[10]');
            $this->form_validation->set_rules('id_propinsi', 'Propinsi', 'required');
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                $input = array('id_user' => null,
                    'password' => md5($this->input->post('password')),
                    'email' => $this->input->post('email'),
                    'id_status' => 1,
                    'active' => 1,
                    'username' => $this->input->post('username'),
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'gender' => $this->input->post('gender'),
                    'birthdate' => strftime('%Y-%m-%d', strtotime($this->input->post('birthdate'))),
                    'alamat' => $this->input->post('alamat'),
                    'telpon' => $this->input->post('telpon'),
                    'hp' => $this->input->post('hp'),
                    'id_propinsi' => $this->input->post('id_propinsi'),
                    'id_kabupaten' => $this->input->post('id_kabupaten'),
                    'id_kecamatan' => $this->input->post('kecamatan'),
                    'id_level' => 6,
                    'created_by' => $this->session->userdata('admin_session')->id_user,
                    'date_added' => date('Y-m-d H:i:s'),
                    'date_modified' => date('Y-m-d H:i:s'),
                );
                $insert1 = $this->user_m->insert('tbl_user', $input);
                if ($insert1) {
                    $data['success'] = 'success';
                } else {
                    $data['error'] = 'failed';
                }
            }
        }
        $this->load->view('admin/user_add_member_v', $data);
    }

    public function edit_member($id = '')
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_edit_member');
        $this->load->library('lib_lokasi');
        $list = new \Cipika\View\Helper\ListBank();
        $data = array();
        $data['edit'] = 'member';
        $data['success'] = '';
        $data['error'] = '';
        $data['title'] = 'Edit Member';
        $data['status'] = $this->user_m->get_status();

        if ($this->input->post('simpan')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Nama Tampilan', 'required');
            $this->form_validation->set_rules('birthdate', 'Nama Tampilan', '');
            $this->form_validation->set_rules('firstname', 'Nama Depan', 'required');
            $this->form_validation->set_rules('lastname', 'Nama Belakang', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('telpon', 'Telpon', 'required|numeric');
            $this->form_validation->set_rules('hp', 'Hp', 'required|numeric|min_length[10]');
            $this->form_validation->set_rules('id_propinsi', 'Propinsi', 'required');
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');
//            $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                $input1 = array(
                    'username' => $this->input->post('username'),
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'gender' => $this->input->post('gender'),
                    'id_status' => $this->input->post('id_status'),
                    'birthdate' => strftime('%Y-%m-%d', strtotime($this->input->post('birthdate'))),
                    'alamat' => $this->input->post('alamat'),
                    'telpon' => $this->input->post('telpon'),
                    'hp' => $this->input->post('hp'),
                    'id_propinsi' => $this->input->post('id_propinsi'),
                    'id_kabupaten' => $this->input->post('id_kabupaten'),
                    'id_kecamatan' => $this->input->post('kecamatan'),
                    'date_modified' => date('Y-m-d H:i:s'),
                );

                if ($this->input->post('id_status') == 1) {
                    $input1['active'] = 1;
                    $input1['date_verified'] = date('Y-m-d H:i:s');
                }

                $this->db->trans_start();
                $insert1 = $this->user_m->update('tbl_user', 'id_user', $id, $input1);
                $status = $this->user_m->get_single('tbl_status', 'id_status', $this->input->post('id_status'));
                $log = $this->user_m->insert('tbl_user_status_log', array(
                    'id_user' => $id,
                    'id_admin' => $this->session->userdata('admin_session')->id_user,
                    'status' => $status->nama_status,
                    'date_added' => date('Y-m-d H:i:s'),
                    ));

                if ($this->db->trans_status() === true) {
                    $this->db->trans_commit();
                    $data['success'] = 'success';
                } else {
                    $data['error'] = 'failed';
                    $this->db->trans_rollback();
                }
            }
        }
        $data['data'] = $this->user_m->get_single('tbl_user', 'id_user', $id);
        $data['bank_list'] = $list->getDataList();
        $this->load->view('admin/user_edit_member_v', $data);
    }

    public function add_agregator()
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_add_agregator');
        $data = array();
        $data['success'] = '';
        $data['error'] = '';
        $data['title'] = 'Add Agregator';
        if ($this->input->post('simpan')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nama_agregator', 'Nama Agregator', 'required');
            $this->form_validation->set_rules('kode_agregator', 'Kode Agregator', 'required|is_unique[tbl_agregator.kode_agregator]');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                $this->db->trans_start();
                $email = implode(', ', $this->input->post('email'));
                $input = array('id_agregator' => null,
                    'email_agregator' => $email,
                    'nama_agregator' => $this->input->post('nama_agregator'),
                    'kode_agregator' => $this->input->post('kode_agregator'),
                );
                $insert = $this->user_m->insert('tbl_agregator', $input);

                if ($this->db->trans_status() === true) {
                    $this->db->trans_commit();
                    $data['success'] = 'success';
                } else {
                    $data['error'] = 'failed';
                    $this->db->trans_rollback();
                }
            }
        }
        $this->load->view('admin/agregator_add_v', $data);
    }

    public function edit_agregator($id)
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_edit_agregator');
        $data = array();
        $data['success'] = '';
        $data['error'] = '';
        $data['title'] = 'Edit Agregator';
        if ($this->input->post('simpan')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nama_agregator', 'Nama Agregator', 'required');
            $this->form_validation->set_rules('kode_agregator', 'Kode Agregator', 'required');
            if ($this->form_validation->run() == false) {
                $data['error'] = validation_errors();
            } else {
                $this->db->trans_start();
                $email = implode(', ', $this->input->post('email'));
                $update = array(
                    'email_agregator' => $email,
                    'nama_agregator' => $this->input->post('nama_agregator'),
                    'kode_agregator' => $this->input->post('kode_agregator'),
                );
                $insert = $this->user_m->update('tbl_agregator', 'id_agregator', (int) $id, $update);

                if ($this->db->trans_status() === true) {
                    $this->db->trans_commit();
                    $data['success'] = 'success';
                } else {
                    $data['error'] = 'failed';
                    $this->db->trans_rollback();
                }
            }
        }
        $data['data'] = $this->merchant_m->get_single('tbl_agregator', 'id_agregator', $id);
        $this->load->view('admin/agregator_edit_v', $data);
    }

    public function agregator()
    {
        $this->auth->check();
        $this->auth->cek_hak_akses('user_agregator');
        $this->load->model('indoloka_m');

        $data['title'] = 'Agregator';
        $data['alert'] = '';
        $data['datas'] = $this->indoloka_m->getAgregator();

        $this->load->view('admin/agregator_v', $data);
    }

    public function login()
    {
        if ($this->session->userdata('admin_session')) {
            redirect(base_url('home'));
        }

        $this->load->view('admin/user_login_v');
    }

    public function dologin()
    {
        $this->load->library('form_validation');
        $data['error'] = false;

        //#1 Set Form Validation

        $this->form_validation->set_rules('username', 'Username', 'xss_clean|required');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|required');

        if ($this->form_validation->run($this) == false) {
            //#2 Display Error Message
            $data['error'] = validation_errors();
        } else {
            $username = $this->input->post('username');
            $pass = md5($this->input->post('password'));

            $user = $this->user_m->get_user_login($username, $pass);
            if (!empty($user)) {
                $this->auth->save($user);
                $this->auth_m->insertLoginHistoryLog($username, 'cms admin');

//                var_dump($_SESSION['admin_session']);
                redirect(admin_url().'dashboard');
            } else {
                $this->auth_m->insertLoginAttemptLog($username, 'cms admin');
                $data['error'] = 'Check your Username & Password';
            }
        }

        $this->load->view('admin/user_login_v', $data);
    }

    public function destroy()
    {
        $this->auth->destroy();
    }

    public function _mail_win()
    {
        $config = array(
            'protocol' => $this->config->item('protocol'),
            'smtp_host' => $this->config->item('smtp_host'),
            'smtp_port' => $this->config->item('smtp_port'),
            'smtp_user' => $this->config->item('smtp_user'),
            'smtp_pass' => $this->config->item('smtp_pass'),
            'mailtype' => $this->config->item('mailtype'),
            'charset' => $this->config->item('charset'),
            'smtp_crypto' => $this->config->item('smtp_crypto'),
        );

        return $config;
    }

    public function _mail_unix()
    {
        $config = array(
            'mailtype' => $this->config->item('mailtype'),
            'charset' => $this->config->item('charset'),
        );

        return $config;
    }
	
    public function uploadLogic($cursor)
    {
        if (!empty($_FILES[$cursor]["name"])) {
            $config['upload_path'] = './asset/upload/';
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($cursor)) {
                $upload_error = array('error' => $this->upload->display_errors());
            } else {
                $upload_result = $this->upload->data();
                $file_name = ($upload_result['file_name']);
            }
        }

        if (!empty($file_name)) {
            return "asset/upload/" . $file_name;
        } else {
            return "";
        }
    }
	
}

/* End of file  */
/* Location: ./application/controllers/ */
