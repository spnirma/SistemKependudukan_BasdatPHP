<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
// $route['cpk'] = "admin/dashboard";
$route['404_override'] = '';

$route['admin']                         = "admin/dashboard";
$route['contact-us']                    = "home/contactus";
$route['tnc-diskon-voucher']            = "static_page/tnc_diskon_voucher_idul_adha";
$route['feedback/(:any)']               = "feedback/index/$1";

$route['cron/feedback_generate']        = "feedback/cron_generate";
$route['cron/feedback_generate/(:num)'] = "feedback/cron_generate/$1";
$route['cron/feedback_expired']         = "feedback/cron_expired";
$route['cron/feedback_expired/(:num)']  = "feedback/cron_expired/$1";

$route['syarat-ketentuan-promo']  = "page/promo_diskon";
$route['voucher-belanja'] = "auth/newregister";

$route['login'] = 'notfound';
$route['daftar'] = 'notfound';

// promo page 15 -> subscribe page
$route['promo/15/(:any)'] = "auth/newregister";

// route promo page
$route['promo/(:num)/(:any)']               = "food/search/index/id_prm/$1/$2";

$route['IWantSony']        = "bidding/produk/IWantSony";
$route['IWantSamsung']        = "bidding/produk/IWantSamsung";
$route['IWantLG']        = "bidding/produk/IWantLG";
$route['iwantsony']        = "bidding/produk/IWantSony";
$route['iwantsamsung']        = "bidding/produk/IWantSamsung";
$route['iwantlg']        = "bidding/produk/IWantLG";
$route['doorprize/(:num)'] = "admin/doorprize/publik_halaman_pemenang_undian/$1";
$route['event/01/pitch6-video-kompetisi'] = "static_page/kompetisi_video";
$route['FunVideo'] = "static_page/kompetisi_video";
$route['funvideo'] = "static_page/kompetisi_video";
$route['store/id/(:num)'] = "MerchantStoreController/id/$1";
$route['store/(:any)'] = "MerchantStoreController/slug/$1";
$route['umkm_profile/id/(:num)'] = "MerchantStoreController/id/$1";
$route['umkm_profile/(:any)'] = "MerchantStoreController/slug/$1"; #ass

$route['store_flat/id/(:num)'] = "MerchantStoreControllerFlat/id_flat/$1";
$route['store_flat/(:any)'] = "MerchantStoreControllerFlat/slug_flat/$1";
$route['umkm_profile_flat/id/(:num)'] = "MerchantStoreControllerFlat/id_flat/$1";
$route['umkm_profile_flat/(:any)'] = "MerchantStoreControllerFlat/slug_flat/$1";

$route['shoppinglist'] = "ProductShoppingList/index";
$route['myshoppinglist'] = "MyShoppingList/index";
$route['myshoppinglist/add'] = "MyShoppingList/add";
$route['checkout'] = "cart/checkout";

// URL slug SEO
$route['fesyarsby2019/(:any)/(:num)/(:any)'] = 'product/detail/$2/$3';
$route['fesyarsby2019/(:any)'] = 'fesyarsby2019/home/index/$1';
$route['fesyarsby2019'] = 'fesyarsby2019/home';

$route['gadget/(:any)/(:num)/(:any)'] = 'product/detail/$2/$3';
$route['gadget/(:any)'] = 'gadget/home/index/$1';
$route['gadget'] = 'gadget/home';
$route['food/(:any)/(:num)/(:any)'] = 'product/detail/$2/$3';
$route['food/(:any)'] = 'food/home/index/$1';
$route['food'] = 'food/home';
$route['lifestyle/(:any)/(:num)/(:any)'] = 'product/detail/$2/$3';
$route['lifestyle/(:any)'] = 'lifestyle/home/index/$1';
$route['lifestyle'] = 'lifestyle/home';
$route['matrix/(:any)/(:num)/(:any)'] = 'product/detail/$2/$3';
$route['matrix/(:any)'] = 'matrix/home/index/$1';
$route['matrix'] = 'matrix/home';
$route['homeentertainment/(:any)/(:num)/(:any)'] = 'product/detail/$2/$3';
$route['homeentertainment/(:any)'] = 'homeentertainment/home/index/$1';
$route['homeentertainment'] = 'homeentertainment/home';
$route['brands/(:any)/(:num)/(:any)'] = 'product/detail/$2/$3';
$route['brands/(:any)'] = 'homeentertainment/home/index/$1';
$route['brands'] = 'homeentertainment/home';
$route['wholesale/(:any)/(:num)/(:any)'] = 'product/detail/$2/$3';
$route['wholesale/(:any)'] = 'wholesale/home/index/$1';
$route['wholesale'] = 'wholesale/home';

$route['paket-komplit']  = 'page/index/29';
$route['paketkomplit']  = 'page/index/29';
$route['festivalbelanjaonline'] = 'page/index/37';
$route['partner'] = 'landing_page';
/* End of file routes.php */

/* Location: ./application/config/routes.php */
