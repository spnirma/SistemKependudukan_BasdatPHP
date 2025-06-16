<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage_config_m extends MY_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all_config($option = '')
    {
        $db = $this->getReadDb();

        $app = Cipika\Application::getInstance();
        $container = $app->getContainer();
        $redis = $container->get('redis');
        
        if (($HomepageConfigTemp = $redis->get($this->config->item('redis_namespace').'homepageConfig')) !== false) {
            $homepageConfig = json_decode($HomepageConfigTemp,true);
        } else {

            $db->order_by("sorting_config", "asc"); 
            $q = $db->get('tbl_homepage_config');
            $data = $q->result();
            $q->free_result();

            foreach ($data as $value) {
                $homepageConfig[$value->option_config] = array(); 
            }

            foreach ($data as $value) {
                $homepageConfig[$value->option_config][] = $value; 
            }
            $homepageConfig = json_encode($homepageConfig);
            $redis->set($this->config->item('redis_namespace').'homepageConfig',$homepageConfig, array('ex' => 300));
            $homepageConfig = json_decode($homepageConfig, true);
        }
        
        return $homepageConfig[$option];
    }

	public function xtest_view_reg_sess($sql = '')
    {
        $db = $this->getReadDb();



//            $q = $db->get('tb_reg_data_registration');
//            $data = $q->result();
//            $q->free_result();

		$q=$this->db->query($sql);
		$data = $q->result();

            foreach ($data as $value) {
                $homepageConfig[$value->regd_data_item] = array(); 
            }

            foreach ($data as $value) {
                $homepageConfig[$value->regd_data_item][] = $value; 
            }
            $homepageConfig = ($homepageConfig);
//            $redis->set($this->config->item('redis_namespace').'homepageConfig',$homepageConfig, array('ex' => 300));
//            $homepageConfig = json_decode($homepageConfig, true);
        
        return $homepageConfig;
    }	
	
    public function get_value($slug_config)
    {
        $db = $this->getReadDb();
        $db->where('slug_config', $slug_config);
        $q = $db->get('tbl_homepage_config');
        $data = $q->row();
        $q->free_result();
        return $data->value_config;
    }

    public function cek_produk_rekomendasi($id_produk)
    {
        $db = $this->getReadDb();
        $db->where('id_produk', $id_produk);
        $db->where('status', 1);
        $q = $db->get('tbl_rekomendasi_cipika');
        $data = $q->row();
        $q->free_result();
        return $data;
    }

    public function cek_produk_feature($id_user)
    {
        $db = $this->getReadDb();
        $db->where('id_user', $id_user);
        $db->where('status', 1);
        $q = $db->get('tbl_feature_merchant');
        $data = $q->row();
        $q->free_result();
        return $data;
    }

    public function get_produk_rekomendasi()
    {
        $db = $this->getReadDb();
        $db->select('p.id_produk');
        $db->select('p.nama_produk');
        $db->select('rc.id_rekomendasi_cipika');
        $db->select('rc.rekomendasi_type');
        $db->where('rc.status', 1);
        // $db->join('tbl_produk p', 'rc.id_produk = p.id_produk', 'LEFT');
        $db->join('tbl_produk p', 'rc.id_produk = p.id_produk');
        $q = $db->get('tbl_rekomendasi_cipika rc');
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    public function get_produk_feature()
    {
        $db = $this->getReadDb();
        $db->select('s.nama_store');
        $db->select('s.id_user');
        $db->select('fm.store_image');
        $db->select('fm.id_feature_merchant');
        $db->where('fm.status', 1);
        $db->join('tbl_store s', 'fm.id_user = s.id_user', 'LEFT');
        $q = $db->get('tbl_feature_merchant fm');
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    public function get_branded_store()
    {
        $brand_flag = "Brand";

        $brand_flags = array('keterangan' => $brand_flag, 'keterangan' => strtoupper($brand_flag), 'keterangan' => strtolower($brand_flag));
        $db = $this->getReadDb();
        $db->select('s.nama_store');
        $db->select('s.id_user');
        $db->select('fm.store_image');
        $db->select('fm.id_feature_merchant');
        $db->where('fm.status', 1);
        $db->or_like($brand_flags);
        $db->join('tbl_store s', 'fm.id_user = s.id_user', 'LEFT');
        $q = $db->get('tbl_feature_merchant fm');
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    public function get_all_produk($term)
    {
        $db = $this->getReadDb();
        $db->select('p.nama_produk');
        $db->select('p.id_produk');
        $db->where('p.deleted', 0);
        $db->where('p.publish', 1);
        $db->where('s.store_status', 'approve');
        $db->like('p.nama_produk', $term);
        $db->or_like('p.id_produk', $term);
        $db->join('tbl_store s', 's.id_user = p.id_user', 'LEFT');
        $q = $db->get('tbl_produk p');
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    public function get_all_store($term)
    {
        $db = $this->getReadDb();
        $db->select('nama_store');
        $db->select('id_user');
        $db->where('store_status', 'approve');
        $db->like('nama_store', $term);
        $db->or_like('id_user', $term);
        $q = $db->get('tbl_store');
        $data = $q->result();
        $q->free_result();
        return $data;
    }

    public function get_all_logo($id = '')
    {

        $db = $this->getReadDb();
        $app = Cipika\Application::getInstance();
        $container = $app->getContainer();
        $redis = $container->get('redis');
        
        if (($homepageLogoTemp = $redis->get($this->config->item('redis_namespace').'homepageLogo')) !== false) {
            $homepageLogo = json_decode($homepageLogoTemp,true);
        } else {

            // $db->where('id_homepage_config', $id);
            $db->where('status', 1);
            $q = $db->get('tbl_homepage_logo');
            $data = $q->result();
            $q->free_result();

            foreach ($data as $value) {
                $homepageLogo[$value->id_homepage_config] = array(); 
            }

            foreach ($data as $value) {
                $homepageLogo[$value->id_homepage_config][] = $value; 
            }
            $homepageLogo = json_encode($homepageLogo);
            $redis->set($this->config->item('redis_namespace').'homepageLogo',$homepageLogo, array('ex' => 300));
            $homepageLogo = json_decode($homepageLogo, true);
        }
		error_reporting(0);
        
        return $homepageLogo[$id];
    }

    public function get_all_footer($id = '')
    {
        $db = $this->getReadDb();
        $app = Cipika\Application::getInstance();
        $container = $app->getContainer();
        $redis = $container->get('redis');
        
        if (($homepageFooterTemp = $redis->get($this->config->item('redis_namespace').'homepageFooter')) !== false) {
            $homepageFooter = json_decode($homepageFooterTemp,true);
        } else {

            // $db->where('id_homepage_config', $id);
            $db->where('status', 1);
            $db->order_by("sorting", "asc");
            $q = $db->get('tbl_homepage_footer');
            $data = $q->result();

            foreach ($data as $value) {
                $homepageFooter[$value->id_homepage_config] = array(); 
            }

            foreach ($data as $value) {
                $homepageFooter[$value->id_homepage_config][] = $value; 
            }
            $homepageFooter = json_encode($homepageFooter);
            $redis->set($this->config->item('redis_namespace').'homepageFooter',$homepageFooter, array('ex' => 300));
            $homepageFooter = json_decode($homepageFooter, true);
        }
        
        return $homepageFooter[$id];
    }

    public function sorting_update($sorting='', $option)
    {
        $db = $this->getReadDb();
        $this->db->where('sorting_config', $sorting);
        $this->db->where('option_config', $option);
        $q = $this->db->get('tbl_homepage_config');
        $data = $q->row();
        $q->free_result();
        return $data;
    }

    public function count_footer($id = '')
    {
        $db = $this->getReadDb();
        $db->where('id_homepage_config', $id);
        $db->where('status', 1);
        $q = $db->get('tbl_homepage_footer');
        // $data = $q->result();
        $q->free_result();
        return $q->num_rows;
    }

    public function sorting_footer_update($sorting='', $id_homepage_config = '')
    {
        $db = $this->getReadDb();
        $db->where('sorting', $sorting);
        $db->where('id_homepage_config', $id_homepage_config);
        $q = $db->get('tbl_homepage_footer');
        $data = $q->row();
        $q->free_result();
        return $data;
    }

}

/* End of file  */
/* Location: ./application/models/ */
