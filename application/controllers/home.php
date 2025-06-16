<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
        // $this->lib_facebook->cek_connect();
    }

    public function visitor_counter()
    {


        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $ip = "";
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        $created_at = date("Y-m-d H:i:s");

        $insert = [
            'ip' => $ip,
            'user_agen' => $userAgent,
            'referer' => !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'created_at' => $created_at,
            'url' => $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'].'/'.$_SERVER['QUERY_STRING'],
        ];
        // echo substr($created_at,6,2);die;
        if (DOMAINNAME=='fesyarjawa.com' || DOMAINNAME=='www.fesyarjawa.com') {
            $this->db->insert("tbl_visitor_log", $insert);
        }           


        // $insert = [
        //     'ip' => $ip,
        //     'user_agen' => $userAgent,
        //     'created_at' => $created_at,
        // ];
        // echo substr($created_at,6,2);die;
        // $this->db->insert("tbl_visitor_log", $insert);

    }


    public function index()
    {

        // $home_view = $this->load->render('frontend/coming_soon');
        // echo $home_view;die;


        $this->session->set_userdata('bahasa', 'id');  
            redirect ('/main');die;


    }

    public function ProfileButton()
    {
        $initial_remove = '<script>
        $(document).ready(function(){
            $(".login-btn-bawahx.modal-open").remove();
        });
        </script>
        ';
        $member = $this->session->userdata('member');
        if (!empty($member)) {
            $loggedInUser = $member;
            $user_image = $loggedInUser->image;
            if (empty($user_image)) {
                $user_image = base_url("asset_easy/images_easy/avatar/avatar-bg.png");
            } else {
                $user_image = base_url("asset/upload/profil/" . $user_image);
            }

            $log_on = '
            <div class="header-user-menu" style="display:;margin-right:20px;">
                <div class="header-user-name" style=":before{color: red;}">
                    <span><img src="'.$user_image.'" alt=""></span>
                    &nbsp;
                </div>
                <ul style="background:#F7F9FB" >
                    <li><a href="'.base_url().'/user_ve/profile"> User profile</a></li>
                    <li class="divider"><hr></li>
                    <li><a href="'.base_url().'auth/logout">Log Out</a></li>
                </ul>
            </div>
            ';

            return $initial_remove . $log_on;
        } else {
            return '';
        }
    }

    public function index_tlj()
    {


  //       if ($this->agent->is_mobile()) {
            // echo 'ada';die;
        // } else {
        //  echo 'tak ada';
        // }
        // die;
// echo ENVIRONMENT;echo APP;die;   

//         if (ENVIRONMENT=='testing') {
//             switch (APP) {
//                 case 'regpre':
//                     switch ($_SERVER["SERVER_NAME"]) {
//                         case 'bbw.levelup.co.id':
//                             redirect (base_url().'Regpremain/set_ev/TEJISDNhQ2RoY0toZkxYdVdYYys2VzNWaUwwSVgzenZ6MXlCaWV5VmdCTT07bGRWZTljQ3F6bkt0RFVZalNRb09ZV00zSG52eGx5Z2M2ejVvRHVxcVNjUT0l4iLa');
//                         break;
//                         default:
//                             redirect (base_url().'oopss');
//                         break;
//                     }
//                 break;
//                 case 'regcli':
//                     redirect (base_url().'regclilogin');
//                 break;
//                 default:
//                     redirect (base_url().'oopss');
//                 break;
//             }
//         } else if (ENVIRONMENT=='development') {
//             switch (APP) {
//                 case 'regpre':
//                     redirect (base_url().'Regpremain');
//                 break;
//                 case 'regcli':
//                     redirect (base_url().'regclilogin');
//                 break;
//                 default:
//                     redirect (base_url().'oopss');
//                 break;
//             }

//         } else {
//             redirect (base_url().'oopss');
//         }

//         die;
// ======================== UNUSED ===========================================
        
        $beginning1 = $this->timer();
            // echo 'ada';die;

        $logger = $this->get('log');

        if (!empty($this->session->userdata('persib'))) {
            $vRedirect=$_SERVER['HTTP_REFERER'];    
            if ($vRedirect=='') {
                redirect(base_url().'auth/logout');
            } else {
                if ($this->session->userdata('whitelabel_partner')=="Persib" || $this->session->userdata('whitelabel_partner')=="Persib_gerai") {
                    /* logger */
                    $vPersibErr='homepage ada session persib';
                    $log_array_data = array(); //json_decode(json_encode($getVoucherProduct), true);
                    $log_persib_data = array(
                        'page'                  => 'homepage',
                        'error'                 => $vPersibErr,
                        'referer'               => $vRedirect,
                        'id_user'               => (int)$this->session->userdata('member')->id_user,
                        'whitelabel_partner'    => $this->session->userdata('whitelabel_partner'),
                        'persib'                => $this->session->userdata('persib'),
                        'persib_gerai'          => $this->session->userdata('persib_gerai'),
                        'persib_gerai_user'     => $this->session->userdata('persib_gerai_user'),
                    );
                    $log_data = array_merge($log_persib_data,$log_array_data);
                    $logger->addEmergency('persib : persib/error', $log_data);
                    /* !logger */
                    redirect(base_url().'persib/error');
                } else if ($this->session->userdata('whitelabel_partner')=="Persib_ticket") {
                    $this->session->unset_userdata('member');
                    $this->session->unset_userdata('partner');

                    $this->session->unset_userdata('whitelabel');
                    $this->session->unset_userdata('whitelabel_cipika_ident');
                    $this->session->unset_userdata('whitelabel_partner');
                    $this->session->unset_userdata('persib');
                    $this->session->unset_userdata('persib_gerai');
                    $this->session->unset_userdata('persib_gerai_user');
                    $this->session->unset_userdata('formulir_persib');

//                    $this->session->sess_destroy();
//                    $this->lib_facebook->destroy_fb();
//                    $this->cache->clean();
//                    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//                    header("Expires: Wed, 4 Jul 2012 05:00:00 GMT"); // Date in the past
                    if (strpos($vRedirect, '/cart') != false) { $vRedirect='cart/checkout'; }
                    redirect(base_url().'persib/login?ref='.$vRedirect);
                }    
            }
        }

        $this->session->unset_userdata('freedom_combo');
        if (isset($_GET['cat'])) {
            if ($_GET['cat']==242)  { redirect(base_url().'indosatfreedomcombo/?cat=242&page=1'); }
        }

        $app = Cipika\Application::getInstance();
        $container = $app->getContainer();
        $redis = $container->get('redis');
        $is_active_homepage_cache = $this->config->item('is_active_homepage_cache');
        $cache_home_view = false;
        //$is_active_homepage_cache = true;
        // $is_active_homepage_cache = false; // TURN OFF CACHE - DEV MODE
        if ($is_active_homepage_cache === true) {
            $cache_home_view = $redis->get($this->config->item('redis_namespace').'Home');
        }

// $app = Cipika\Application::getInstance();
// $container = $app->getContainer();
// $redis = $container->get('redis');

// $cache_name='Home';
// $status = $redis->delete($this->config->item('redis_namespace').$cache_name);
// echo '<b>'.$cache_name.'</b> :<br><br>';
// var_dump($status);die;

        $show_test_pad = $this->config->item('show_test_pad');
        $show_rekomendasi_wholesale = $this->config->item('show_rekomendasi_wholesale');
        $show_rekomendasi_gadget = $this->config->item('show_rekomendasi_gadget');
        $show_rekomendasi_brands = $this->config->item('show_rekomendasi_brands');
        $show_rekomendasi_home_entertainment = $this->config->item('show_rekomendasi_home_entertainment');
        $show_rekomendasi_otomotif = $this->config->item('show_rekomendasi_otomotif');
        $show_rekomendasi_lifestyle = $this->config->item('show_rekomendasi_lifestyle');
        $show_shortcut = $this->config->item('show_shortcut');
        //$content_source=NULL;
// echo $cache_home_view;die;
        if ($cache_home_view === false) {
                    
            $data = array();

            $data['test_fetch'] = $this->config->item('test_fetch');
            $data['show_test_pad'] = $show_test_pad;
            $data['show_rekomendasi_wholesale'] = $show_rekomendasi_wholesale;
            $data['show_rekomendasi_gadget'] = $show_rekomendasi_gadget;
            $data['show_rekomendasi_brands'] = $show_rekomendasi_brands;
            $data['show_rekomendasi_home_entertainment'] = $show_rekomendasi_home_entertainment;
            $data['show_rekomendasi_otomotif'] = $show_rekomendasi_otomotif;
            $data['show_rekomendasi_lifestyle'] = $show_rekomendasi_lifestyle;
            $data['show_shortcut'] = $show_shortcut;

            if (isset($_GET['s'])) {
                $data['by_search'] = $_GET['s'];
            } else {
                $data['by_search'] = '';
            }
            if (isset($_GET['cat'])) {
                $data['by_category'] = $_GET['cat'];
            } else {
                $data['by_category'] = '';
            }
            if (isset($_GET['loc'])) {
                $data['by_location'] = $_GET['loc'];
            } else {
                $data['by_location'] = '';
            }
            if (isset($_GET['pr'])) {
                $data['by_price'] = $_GET['pr'];
            } else {
                $data['by_price'] = '';
            }
            if (isset($_GET['tag'])) {
                $data['by_tag'] = $_GET['tag'];
            } else {
                $data['by_tag'] = '';
            }
            if (isset($_GET['sort'])) {
                $data['by_sort'] = $_GET['sort'];
            } else {
                $data['by_sort'] = '';
            }

            if (isset($_GET['s'])) {
                $data['by_search'] = $_GET['s'];
            } else {
                $data['by_search'] = '';
            }
            $limit = 15;
            if (isset($_GET['sc'])) {
                $offset = $limit * ($_GET['sc'] - 1);
            } else {
                $offset = 0;
            }

            $diskon_kalkulator_promo_diskon = new Cipika\Promo\PromoDiskonCalculator($this->db,$this->session);
            $diskon_kalkulator_daily_deals = new Cipika\Promo\PromoDailyDealsCalculator($this->db,$this->session);
            $produk_price_calculator = new Cipika\Promo\ProdukPriceCalculator;
            $produk_price_calculator->addPriceListDiskonKalkulator($diskon_kalkulator_promo_diskon);
            $produk_price_calculator->addPriceListDiskonKalkulator($diskon_kalkulator_daily_deals);
            
            if($this->config->item('layout')!='ui2'){
                
                $arrayidprod = array('0');
                $data['produk'] = $this->gadget_m->get_produk($limit, $offset);
                foreach ($data['produk'] as $row){
                    $arrayidprod[] = $row->id_produk;
                }
                    
                $data['produk_promo'] = $this->gadget_m->get_produk_promo($arrayidprod);
                $data['order_promo_quota'] = $this->gadget_m->get_order_promo_quota($arrayidprod);
                $data['order_promo_quota_per_day'] = $this->gadget_m->get_order_promo_quota_per_day($arrayidprod);
                if($this->session->userdata('member')){
                    $data['order_promo_day'] = $this->gadget_m->get_order_promo_day($arrayidprod, $this->session->userdata('member')->id_user);
                }
                
                $data['page'] = $this->page_m->get_list_page();
                
                $data['produk_diskon'] = $produk_price_calculator->getPriceList($data['produk']);
            
            }
            
            if($this->config->item('layout')=='ui2'){
                if($this->getAuthenticatedMember()) {
                    $id_user = $this->getAuthenticatedMember()->id_user;
                } else {
                    $id_user = null;
                }

                $data['produk_row'] = $this->homepage_config_m->get_all_config('Produk Row');
                
                $data['logo_homepage'] = $this->homepage_config_m->get_all_config('Logo Homepage');
                foreach ($data['logo_homepage'] as $value) {
                    $data['logo_image'][$value['id_homepage_config']] = $this->homepage_config_m->get_all_logo($value['id_homepage_config']);
                }

                $kategori = $this->homepage_config_m->get_value('kategori');
                $data['homepage_text'] = $this->homepage_config_m->get_value('homepage-text');

                // $data['banner_web'] = $this->home_ui2_m->getActiveBannerHome('web');
                // $data['banner_web_footer'] = $this->home_ui2_m->getActiveBannerHome('web', 'homepage_bottom');
                // $data['banner_mobile'] = $this->home_ui2_m->getActiveBannerHome('mobile web');
                // $data['banner_mobile_footer'] = $this->home_ui2_m->getActiveBannerHome('mobile web', 'homepage_bottom');

//                 $data['banners_rekomendasi_wholesale'] = $this->home_ui2_m->getActiveBannerHome('side banner', 'rekomendasi_wholesale');
//                 $data['banners_rekomendasi_gadget'] = $this->home_ui2_m->getActiveBannerHome('side banner', 'rekomendasi_gadget');
// // echo '<pre>';print_r($data['banners_rekomendasi_gadget']);die;
//                 $data['banners_rekomendasi_brands'] = $this->home_ui2_m->getActiveBannerHome('side banner', 'rekomendasi_brands');
//                 $data['banners_rekomendasi_home_entertainment'] = $this->home_ui2_m->getActiveBannerHome('side banner', 'rekomendasi_home_entertainment');
//                 $data['banners_rekomendasi_otomotif'] = $this->home_ui2_m->getActiveBannerHome('side banner', 'rekomendasi_otomotif');
//                 $data['banners_rekomendasi_lifestyle'] = $this->home_ui2_m->getActiveBannerHome('side banner', 'rekomendasi_lifestyle');
                
                // Test Banner Protection
                // $data['banner_brands'] = null;
                // $data['banner_rekomendasi'] = null;
                

                // $data['link_brand_rb'] = $this->home_ui2_m->getBrandLink('homeentertainment', 'Reckitt Benckiser');
                // $brand_rb = $this->home_ui2_m->getBrandAttributes('homeentertainment', 'Reckitt Benckiser');
                // $data['brand_rb_link'] = $brand_rb['brand_link'];
                // $data['brand_rb_image'] = $brand_rb['brand_data']->image;

                // $brand_osram = $this->home_ui2_m->getBrandAttributes('homeentertainment', 'Osram');
                // $data['brand_osram_link'] = $brand_osram['brand_link'];
                // $data['brand_osram_image'] = $brand_osram['brand_data']->image;

                // $brand_bosch = $this->home_ui2_m->getBrandAttributes('homeentertainment', 'Bosch');
                // $data['brand_bosch_link'] = $brand_bosch['brand_link'];
                // $data['brand_bosch_image'] = $brand_bosch['brand_data']->image;

                // $brand_meguiars = $this->home_ui2_m->getBrandAttributes('homeentertainment', 'Meguiars');
                // $data['brand_meguiars_link'] = $brand_meguiars['brand_link'];
                // $data['brand_meguiars_image'] = $brand_meguiars['brand_data']->image;

                // $brand_3m = $this->home_ui2_m->getBrandAttributes('homeentertainment', '3M');
                // $data['brand_3m_link'] = $brand_3m['brand_link'];
                // $data['brand_3m_image'] = $brand_3m['brand_data']->image;

                $beginning = $this->timer();
                $topgadget = $this->home_ui2_m->get_top_gadget(10);
                $data['topgadget'] = $produk_price_calculator->getPriceList($topgadget);
                $data['timegadget'] = round($this->timer()-$beginning,6);
// echo '<pre>';print_r($data['banners_rekomendasi_gadget']);die;
                $beginning = $this->timer();
                $camilan = $this->home_ui2_m->get_top_camilan(10);
                $data['topcamilan'] = $produk_price_calculator->getPriceList($camilan);
                $data['timecamilan'] = round($this->timer()-$beginning,6);
                $beginning = $this->timer();
                $topfasion = $this->home_ui2_m->get_top_fasion(10);
                $data['topfasion'] = $produk_price_calculator->getPriceList($topfasion);
                $data['timefasion'] = round($this->timer()-$beginning,6);
                $beginning = $this->timer();
                $terbaru = $this->home_ui2_m->get_produk_terbaru(5);
                $data['produkTerbaru'] = $produk_price_calculator->getPriceList($terbaru);
                $data['timeterbaru'] = round($this->timer()-$beginning,6);
                $beginning = $this->timer();
                $produkIndosat = $this->home_ui2_m->get_produk_indosat(5);
                $data['produkIndosat'] = $produk_price_calculator->getPriceList($produkIndosat);
                $data['timecipika'] = round($this->timer()-$beginning,6);
                $beginning = $this->timer();
                $rekomendasi_cipika = $this->home_ui2_m->get_rekomendasi_cipika(6);
                $data['rekomendasiCipika'] = $produk_price_calculator->getPriceList($rekomendasi_cipika);
                $data['timerekomendasicipika'] = round($this->timer()-$beginning,6);
                $beginning = $this->timer();
                $produkKategori = $this->home_ui2_m->get_produk_kategori(5, $kategori);
                $data['produkKategori'] = $produk_price_calculator->getPriceList($produkKategori);
                $data['timeprodukkategori'] = round($this->timer()-$beginning,6);
                // Rekomendasi By Type
                // $beginning = $this->timer();
                // $rekomendasi_gadget = $this->get_rekomendasi_by_type($rekomendasi_cipika, "GADGET");
                // $data['rekomendasiGadget'] = $produk_price_calculator->getPriceList($rekomendasi_gadget);
                // $data['timerekomendasigadget'] = round($this->timer()-$beginning,6);

                $beginning = $this->timer();
                $rekomendasi_wholesale = $this->home_ui2_m->get_rekomendasi_by_type(6, "WHOLESALE");
                $data['rekomendasiWholesale'] = $produk_price_calculator->getPriceList($rekomendasi_wholesale);
                $data['timerekomendasiwholesale'] = round($this->timer()-$beginning,6);

                $beginning = $this->timer();
                $rekomendasi_gadget = $this->home_ui2_m->get_rekomendasi_by_type(6, "GADGET");
                $data['rekomendasiGadget'] = $produk_price_calculator->getPriceList($rekomendasi_gadget);
// echo '<pre>';print_r($data['rekomendasiGadget']);die;
                $data['timerekomendasigadget'] = round($this->timer()-$beginning,6);
                
                // $beginning = $this->timer();
                // $rekomendasi_food = $this->home_ui2_m->get_rekomendasi_by_type(6, "FOOD");
                // $data['rekomendasiFood'] = $produk_price_calculator->getPriceList($rekomendasi_food);
                // $data['timerekomendasifood'] = round($this->timer()-$beginning,6);

                // $data['kategoriBranded'] = $this->home_ui2_m->get_kategori_branded();
                $data['produkBranded'] = $this->home_ui2_m->get_produk_branded();

                $beginning = $this->timer();
                $rekomendasi_brands = null;
                $data['rekomendasiBrands'] = null;
                $data['timerekomendasibrands'] = round($this->timer()-$beginning,6);

                $beginning = $this->timer();
                $rekomendasi_home_entertainment = $this->home_ui2_m->get_rekomendasi_by_type(6, "HOMEENTERTAINMENT");
                $data['rekomendasiHomeEntertainment'] = $produk_price_calculator->getPriceList($rekomendasi_home_entertainment);
                $data['timerekomendasihomeentertainment'] = round($this->timer()-$beginning,6);

                $beginning = $this->timer();
                $rekomendasi_otomotif = $this->home_ui2_m->get_rekomendasi_by_type(6, "OTOMOTIF");
                $data['rekomendasiOtomotif'] = $produk_price_calculator->getPriceList($rekomendasi_otomotif);
                $data['timerekomendasiotomotif'] = round($this->timer()-$beginning,6);

                $beginning = $this->timer();
                $rekomendasi_lifestyle = $this->home_ui2_m->get_rekomendasi_by_type(6, "LIFESTYLE");
                $data['rekomendasiLifestyle'] = $produk_price_calculator->getPriceList($rekomendasi_lifestyle);
                $data['timerekomendasilifestyle'] = round($this->timer()-$beginning,6);

                /*
                // 2.6
                // ($limit, $brand_slug, $id_store)
                $brand_reckitt_benckiser = $this->home_ui2_m->get_branded_products(10, 'reckitt-benckiser', 1217); // Production
                // $brand_reckitt_benckiser = $this->home_ui2_m->get_branded_products(10, 'reckitt-benckiser', 274); 
                $data['brand_reckitt_benckiser'] = $produk_price_calculator->getPriceList($brand_reckitt_benckiser);
                $data['time_brand_reckitt_benckiser'] = round($this->timer()-$beginning,6);
                $beginning = $this->timer();
                $brand_bosch = $this->home_ui2_m->get_branded_products(10, 'bosch', 1561); // Production
                // $brand_bosch = $this->home_ui2_m->get_branded_products(10, 'bosch', 274);
                $data['brand_bosch'] = $produk_price_calculator->getPriceList($brand_bosch);
                $data['time_brand_bosch'] = round($this->timer()-$beginning,6);
                $beginning = $this->timer();
                $brand_meguiars = $this->home_ui2_m->get_branded_products(10, 'meguiars', 1547); // Production
                // $brand_meguiars = $this->home_ui2_m->get_branded_products(10, 'meguiars', 274);
                $data['brand_meguiars'] = $produk_price_calculator->getPriceList($brand_meguiars);
                $data['time_brand_meguiars'] = round($this->timer()-$beginning,6);
                $beginning = $this->timer();
                $brand_3m = $this->home_ui2_m->get_branded_products(10, '3m', 1601); // Production
                // $brand_3m = $this->home_ui2_m->get_branded_products(10, '3m', 274);
                $data['brand_3m'] = $produk_price_calculator->getPriceList($brand_3m);
                $data['time_brand_3m'] = round($this->timer()-$beginning,6);
                $beginning = $this->timer();
                */

                $all_love = array_merge(
                    $terbaru,
                    $topfasion,
                    $camilan,
                    $topgadget,
                    $produkIndosat,
                    $rekomendasi_cipika,
                    $produkKategori,
                    $rekomendasi_wholesale,
                    $rekomendasi_gadget,
                    $rekomendasi_home_entertainment,
                    $rekomendasi_otomotif,
                    $rekomendasi_lifestyle
                    );

                $feature_merchant = $this->home_ui2_m->get_feature_merchant(5);
                // var_dump($feature_merchant);exit();
                $data['featureMerchant'] = $feature_merchant;
                $data['featured_store_slug'] = $this->home_ui2_m->getStoreSlug($feature_merchant);
     

                $data['all_love'] = $this->love_m->getLoveByProductArray($id_user,$all_love);
                $data['primary_photo'] = $this->home_ui2_m->getPrimaryPhotoByProductArray($all_love);
                $data['wholesale'] = $this->wholesale_m->getWholesaleRuleByProductArray($all_love);
                $data['store_slug'] = $this->home_ui2_m->getStoreSlug($all_love);
                // var_dump($data['store_slug']);exit();

// echo '<pre>';print_r($data['primary_photo']);die;


                if($this->config->item('layout_ui2.1')=='active'){
                    $home_view = $this->load->render('frontend/home',$data);
//prod balikin 
//                    $redis->set($this->config->item('redis_namespace').'Home', $home_view, $this->config->item('redis_expired_time'));
                    
                    $home_view = str_replace('[responsive-login]', $this->getResponsiveLoginView(), $home_view);
                    $home_view = str_replace('[user-panel-xs]', $this->user_panel_xs(), $home_view);
                    $home_view = str_replace('[web-user-nav]', $this->web_user_nav(), $home_view);
                    $home_view = str_replace('[web_user_nav2]', $this->web_user_nav2(), $home_view);
                    $home_view = str_replace('[nav-top-right]', $this->nav_top_right(), $home_view);
                    
                    echo $home_view;
                } else {
                    $this->load->view('publik/ui2/home_v',$data);
                }
            } else {
                $this->load->view('publik/gadget_v', $data);
            }

        } else {
            $count = 0;
            $content_source='cache';
            $cache_home_view = str_replace('[responsive-login]', $this->getResponsiveLoginView(), $cache_home_view);
            $cache_home_view = str_replace('[user-panel-xs]', $this->user_panel_xs(), $cache_home_view, $count);
            $cache_home_view = str_replace('[web-user-nav]', $this->web_user_nav(), $cache_home_view);
            $cache_home_view = str_replace('[web_user_nav2]', $this->web_user_nav2(), $cache_home_view);
            $cache_home_view = str_replace('[nav-top-right]', $this->nav_top_right(), $cache_home_view);
            
            if ($count == 0) {
                $redis->delete($this->config->item('redis_namespace').'Home');
                redirect(base_url());
            } else {
                echo $cache_home_view;
            }
        }

        $ending1 = $this->timer();
        $duration1 = round($ending1-$beginning1,6);
        //echo $ending.'-'.$beginning.'='.$duration;

        /* logger */
        $log_array_data = array();
        $log_stat = array(
            'stat_patch'    => $this->config->item('stat_page_patch'),
            'stat_page'     => 'home',
            'stat_loadtime' => $duration1,
            'stat_datetime' => date('Y-m-d H:i:s'),
            'stat_is_active_page_cache'      => $is_active_homepage_cache,
            'stat_content_source' => ($content_source) ? $content_source : '',
        );
        $log_data = array_merge($log_stat,$log_array_data);
        $logger->addDebug('stat: page load time', $log_data);
        /* !logger */
        //die;
    }

    function cek_login()
    {
        $konek = $this->connect();
        if (isset($konek['user_profile'])) {
            if ($konek['user']) {

                $user = $this->user_m->get_email_user($konek['user_profile']['email']);
                if (!empty($user)) { /* registered, force login */
                    echo "udah daftar";
                } else {
                    $password = random_password();
                    $email = $konek['user_profile']['email'];
                    $input1 = array(
                        "email" => $email,
                        "password" => md5($password),
                        "firstname" => $konek['user_profile']['first_name'],
                        "lastname" => $konek['user_profile']['last_name'],
                        "telpon" => 0,
                        "fb_token" => $konek['token']
                    );

                    $insert1 = $this->user_m->insert('tbl_user', $input1);

                    echo "berhasil daftar";
                }
            }
        }
    }

    /*
     * dihide sementara atas request cipika
    function contactus()
    {
        $this->load->library('form_validation');
        $this->load->model('contact_form_m');

        $data['page'] = $this->page_m->get_list_page();

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('pesan', 'Pesan', 'required');
            $this->form_validation->set_rules('subjek', 'Subjek', 'required');

            $this->form_validation->set_message('required', '%s tidak boleh kosong.');
            $this->form_validation->set_message('valid_email', 'Format email tidak valid.');

            //validation chaptcha
            $resp = $this->lib_recaptcha->auth_recaptcha($_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

            if ($this->form_validation->run()) {
                if (!$resp->is_valid) {
                    $data['error'] = "CAPTCHA Yang anda masukan salah.";
                } else {
                    $insert = array('idcf' => null,
                        'nama' => $this->input->post('nama'),
                        'pesan' => $this->input->post('pesan'),
                        'email' => $this->input->post('email'),
                        'subjek' => $this->input->post('subjek'),
                        'notes' => '',
                        'tgl_kirim' => date('Y-m-d H:i:s'),
                        'read_status' => 0,
                        'delete_status' => 1
                    );
                    $this->contact_form_m->insert('contact_form', $insert);

                    //# send mail nitification to admin

                    $this->load->library('lib_mailer');
                    $mail_data = array('data' => $insert);
                    $message = $this->load->view('email/admin_contact_form_v', $mail_data, TRUE);
                    $mailer = array('module' => 'Contact Form',
                        'from' => $this->config->item('email_from'),
                        'to' => $this->config->item('email_contact_form'),
                        'subject' => "Kontak Form dari " . $insert['nama'],
                        'message' => $message
                    );
                    $this->lib_mailer->save($mailer);


                    redirect(base_url('contact-us?s=1'));
                }
            } else {
                $data['error'] = validation_errors();
            }
        }
        if($this->config->item('layout') == 'ui2'){
            if ($this->config->item('layout_ui2.1')=='active') {
                echo $this->load->render('frontend/contactus',$data);
            } else {
                $this->load->view('publik/ui2/contactus_v',$data);
            }
        } else {
            $this->load->view('publik/contactus_v', $data);
        }
    }
     */
    
    public function timer()
    {
        $time = explode(' ', microtime());
        return $time[0]+$time[1];
    }

    /* Redis optimization */

    public function getResponsiveLoginView()
    {
        return $this->load->render('frontend/partial/responsive-login');
    }

    public function user_panel_xs()
    {
        return $this->load->render('frontend/partial/user_panel_xs');
    }

    public function web_user_nav()
    {
        return $this->load->render('frontend/partial/web_user_nav');
    }

    public function web_user_nav2()
    {
        return $this->load->render('frontend/partial/web_user_nav2');
    }

    public function nav_top_right()
    {
        return $this->load->render('frontend/partial/nav-top-right');
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
