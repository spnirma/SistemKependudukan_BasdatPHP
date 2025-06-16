<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class penduduk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth');
        $this->auth->check();
		//echo 'a';die;
        //$this->auth->cek_hak_akses();
    }

    public function index()
    {
//        $this->auth->cek_hak_akses('merchant_request'); //acara_index');
        $data = array();
        $data['title'] = 'Acara';
        $hal = get('hal');
        $dataPerhalaman = 10;
        ($hal == '') ? $nohalaman = 1 : $nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs((int) $offset);
        $data['offset'] = $offset;

$vJenis='x';
if (!empty(get("jenis"))) $vJenis=get("jenis");
        //count
        $acara_count = $this->db
//            ->where("id_penduduk", ">0")
            ->select("count(id_penduduk) as jumlah");;
        $acara_count = $acara_count->get("penduduk")->row();
        $jumlahData = $acara_count->jumlah;
//echo $jumlahData;die;            

        //get acara
        $acara = $this->db
//            ->where("jenis",$vJenis)
            ->order_by("id_penduduk",'desc')
            ->limit($dataPerhalaman)
            ->offset($offset);

        if (!empty(get("s"))) {
//            $acara = $acara->where("judul_acara like '%".get("s")."%'");
        }
        if (!empty(get("fr"))) {
//            $acara = $acara->where("tgl >= '".get("fr")."'");
        }
        if (!empty(get("to"))) {
//            $acara = $acara->where("tgl <= '".get("to")."'");
        }
		
        $acara = $acara->get("penduduk");
        $data_acara = $acara->result();
        $acara->free_result();

        $data["datas"] = $data_acara;
        $data['paginator'] = $this->user_m->page($jumlahData, $dataPerhalaman, $hal);

        $this->load->view('admin/penduduk_v', $data);
    }

    public function add()
    {
        $this->form(0);
    }

    public function edit($id)
    {
        $this->form($id);
    }

    public function form($id)
    {
        $this->auth->cek_hak_akses('merchant_request');

        $data = [];
        $data['title'] = 'Penduduk';
        
        //set default
        $data['data'] = [
            'nama' => '',
            'usia' => '',
            'jenis_kelamin' => '',
        ];

        if (!empty($id)) {
            $data['data'] = $this->db->where("id_penduduk", $id)->get("penduduk")->row_array();
        }
//echo '<pre>';print_r($data['data']);die;		

        if (!empty($this->input->post('submit'))) {
            $param = $this->input->post();
			
            $param['nama'] = str_replace('\"','"',$param['nama']);
            $param['usia'] = str_replace('\"','"',$param['usia']);
            $param['jenis_kelamin'] = str_replace('\"','"',$param['jenis_kelamin']);
            unset($param['submit']);
//echo '<pre>';print_r($param);die;		

            if (!empty($id)) {
                $this->db->update("penduduk", $param, "id_penduduk = '$id'");
            } else {
                //$param['created_at'] = date("Y-m-d H:i:s");
                $this->db->insert("penduduk", $param);
            }
            redirect(base_url("admin/penduduk") . "?jenis=" . $param['jenis']);
        }

        $this->load->view('admin/penduduk_form_add', $data);
    }

    public function setdefault($id)
    {
        $acara = $this->db->where("id", $id)->get("tbl_acara")->row();
        $this->db->update("tbl_acara", ['status_default' => '1'], "id = '$id'");
        $this->db->update("tbl_acara", ['status_default' => '0'], "id != '$id' and jenis = '".$acara->jenis."'");
        redirect(base_url("admin/acara"). "?jenis=" . $acara->jenis);
    }

    public function setdelete($id)
    {
//        $this->db->update("tbl_acara", ['deleted_at' => date("Y-m-d H:i:s")], "id = '$id'");
        $this->db->delete("penduduk", "id_penduduk = '$id'");

        redirect(base_url("admin/penduduk"));
    }

    public function subindex($id, $tipe, $title)
    {
        $this->auth->cek_hak_akses('merchant_request');
        $data = array();
        $data['id'] = $id;
        $data['files_type'] = $tipe;
        $data['title'] = $title;
        $hal = get('hal');
        $dataPerhalaman = 10;
        ($hal == '') ? $nohalaman = 1 : $nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs((int) $offset);
        $data['offset'] = $offset;

        //count
        $count = $this->db
            ->where("file_type", $tipe)
            ->where("date_deleted is null")
            ->where("id_acara" , $id)
            ->select("count(id) as jumlah");;
            if (!empty(get("s"))) {
                $count = $count->where("file_name like '%".get("s")."%'");
            }
        $count = $count->get("tbl_merchants_files")->row();
        $jumlahData = $count->jumlah;
            
        //get acara
        $datas = $this->db
            ->where("file_type", $tipe)
            ->where("date_deleted is null")
            ->where("id_acara" , $id)
            ->limit($dataPerhalaman)
            ->offset($offset);
        if (!empty(get("s"))) {
            $datas = $datas->where("file_name like '%".get("s")."%'");
        }
        $datas = $datas->get("tbl_merchants_files");
        $data["datas"] = $datas->result();
        $datas->free_result();

        $data['paginator'] = $this->user_m->page($jumlahData, $dataPerhalaman, $hal);

        $this->load->view('admin/acara_sub_index_v', $data);
    }

    public function classroom_video($id)
    {
        $this->subindex($id, "classroom_video", "Video Sub Acara");
    }

    public function classroom_doc($id)
    {
        $this->subindex($id, "classroom_doc", "Document Sub Acara");
    }

    public function classroom_qna($id)
    {
        $this->subindex($id, "classroom_qna", "QNA Sub Acara");
    }

    public function classroom_gallery($id)
    {
        $this->subindex($id, "classroom_gallery", "Gallery Sub Acara");
    }

    public function subadd($id_acara, $tipe)
    {
        $this->subform($id_acara, $tipe);
    }

    public function subedit($id_acara, $tipe, $id_files)
    {
        $this->subform($id_acara, $tipe, $id_files);
    }

    public function subdelete($id_acara, $tipe, $id_files = 0)
    {
        $this->db->update("tbl_merchants_files", ['date_deleted' => date("Y-m-d H:i:s")], "id = '$id_files'");
        redirect(base_url("admin/acara/$tipe/$id_acara"));
    }

    public function subform($id_acara, $tipe, $id_files = 0)
    {
        $this->auth->cek_hak_akses('merchant_request');

        $data = [];
        $data['title'] = 'Sub Form';
        $data['tipe'] = $tipe;
        
        //set default
        $data['data'] = [
            'file_name' => '',
            'file_description' => '',
            'file_link' => '',
            'file_url_link' => '',
            'file_type' => '',
            'file_sub_gallery' => '',
            'id_acara' => '',
            'id_store' => 0
        ];

        if (!empty($id_files)) {
            $data['data'] = $this->db->where("id", $id_files)->get("tbl_merchants_files")->row_array();
        }

        if (!empty($this->input->post('submit'))) {
            $param = $this->input->post();
            unset($param['submit']);
            $param["file_type"]  = $tipe;
            $param["id_acara"]  = $id_acara;
            $param["id_store"]  = 0;

            if ($tipe == "classroom_video") {
                $param["file_link"] = youtube_link_to_code($this->input->post('file_link'));
            }
            if ($tipe == "classroom_gallery") {
                //main upload
                unset($param["file_link_upload"]);
                $file_name = $this->uploadLogic("file_link_upload");
                if (!empty($file_name)) {
                    $param['file_link'] = $file_name;
                } else {
                    if (!empty($data['data'])) {
                        $param['file_link'] = $data['data']['file_link'];
                    } else {
                        $param["file_link"] = "";
                    }
                }

                //delete action
                $del_photo_pbj = [];
                if (!empty($this->input->post('del_foto'))) {
                    $del_photo = $this->input->post('del_foto');
                    $del_photo_pbj = json_decode($del_photo);
                }

                //gallery upload
                $gallery_uploaded_path = [];
                foreach ([0,1,2,3] as $i) {
                    $gallery_uploaded_path[$i] = $this->uploadLogic("gallery_upload_" . $i);
                }

                // gallery upload check
                @$file_sub_gallery = json_decode($data['data']['file_sub_gallery']);
                foreach ($gallery_uploaded_path as $k => $f) {
                    if (empty($f)) {
                        if (!in_array($k, $del_photo_pbj)) {
                            @$gallery_uploaded_path[$k] = $file_sub_gallery[$k];
                        }
                    }
                }

                $param["file_sub_gallery"] = json_encode($gallery_uploaded_path);
            }
            if ($tipe == "classroom_doc") {
                //main upload
                unset($param["file_link_upload"]);
                $file_name = $this->uploadLogic("file_link_upload");
                if (!empty($file_name)) {
                    $param['file_link'] = $file_name;
                } else {
                    if (!empty($data['data'])) {
                        $param['file_link'] = $data['data']['file_link'];
                    } else {
                        $param["file_link"] = "";
                    }
                }
            }
            if ($tipe == "classroom_qna") {
                $user = $this->auth_m->get_user();
                $param["id_store"] = $user->id_user;
            }            
            
            unset($param['del_foto']);
            if (!empty($id_files)) {
                $this->db->update("tbl_merchants_files", $param, "id = '$id_files'");
            } else {
                $param['date_created'] = date("Y-m-d H:i:s");
                $this->db->insert("tbl_merchants_files", $param);
            }
            redirect(base_url("admin/acara/$tipe/$id_acara"));
        }

        $this->load->view('admin/acara_sub_form_v', $data);
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

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
;