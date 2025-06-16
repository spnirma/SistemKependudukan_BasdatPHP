<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart_m extends MY_Model {

	public $variable;
    protected $logger;

	public function __construct()
	{
		parent::__construct();		
        $this->logger = \Cipika\Application::getInstance()->getContainer()->get('log');
	}

    public function add_product_registration($id=0, $qty=0){ // hanya digunakan oleh pendaftaran anggota persib , untuk auto add to cart karena kadang2 session cart tiba2 hilang, I DONNT KNOW WHY and WHERE
        $diskon_kalkulator_promo_diskon = new Cipika\Promo\PromoDiskonCalculator($this->db,$this->session);
        $diskon_kalkulator_daily_deals = new Cipika\Promo\PromoDailyDealsCalculator($this->db,$this->session);
        $produk_price_calculator = new Cipika\Promo\ProdukPriceCalculator;
        $produk_price_calculator->addPriceListDiskonKalkulator($diskon_kalkulator_promo_diskon);
        $produk_price_calculator->addPriceListDiskonKalkulator($diskon_kalkulator_daily_deals);
        //$id=$this->input->post('id');
        //$qty=$this->input->post('qty');
        $data_lama=array();
        $sudah_ada=FALSE;
//echo $id;
//die;
        $this->session->unset_userdata('voucherMember');

        //$produk=$this->cart_m->get_produk($id);
        //$produk=$this->produk_m->get_produk($id);
        $produk=$this->produk_m->getProdukDetail($id);
		// $produk=$this->produk_m->getProdukDetail($product_event);
		//print_r($produk);die;

        if ($produk->channel == "WHOLESALE") {
            $wholesale_rule = $this->wholesale_m->getSingleWholesaleRuleByIdProduk($produk->id_produk);
            if ($qty < $wholesale_rule->qty_minimal) {
                $qty = $wholesale_rule->qty_minimal;
            }
        }
        
        // var_dump($produk);exit;
        // cek sudah ada apa belum datanya
        /*
        $arrayidprod = array('0');
        $arrayidprod[] = $produk->id_produk;
        $produk_promo = $this->home_m->get_produk_promo($arrayidprod);
        $order_promo_quota = $this->home_m->get_order_promo_quota($arrayidprod);
        $order_promo_quota_per_day = $this->home_m->get_order_promo_quota_per_day($arrayidprod);
        if($this->session->userdata('member')){
            $order_promo_day = $this->home_m->get_order_promo_day($arrayidprod, $this->session->userdata('member')->
			);
        }
        * */
        $is_bidding = false;
        $cart = $this->cart->contents();
        
        if(!$sudah_ada){
            
            $produk_calculated_list = $produk_price_calculator->getPriceList(array(0=>$produk));
            
            $nama=$produk->nama_produk;
            $id_merchant=$produk->id_user;
            if(!empty($qty)){
                if($qty>=$produk_calculated_list[0]['stock_available']){
                    $jml=$produk_calculated_list[0]['stock_available'];
                } else {
                    $jml=$qty;
                }
            } else {
                $jml=1;
            }
            $image=$produk->images;
            $harga=$produk->harga_jual;         
            $stok=$produk->stok_produk;
            $berat=$produk->jne_berat;
            $dimensi=$produk->panjang*$produk->lebar*$produk->tinggi;
            $berat_produk = $produk->berat;
            $panjang = $produk->panjang;
            $lebar = $produk->lebar;
            $tinggi = $produk->tinggi;
            $hargaMerchant = $produk->harga_produk;
            $blendedTransactionFee = $produk->blended_transaction_fee;
            $blendedInsentifCipika = $produk->blended_insentif_cipika;
            $blendedShippingFeeToJakarta = $produk->blended_shipping_fee_to_jakarta;
            $selisihPembulatan = $produk->selisih_pembulatan;
            $price= $produk_calculated_list[0]['harga_setelah_diskon'];
            $diskon = $produk_calculated_list[0]['diskon'];
            $diskon_rp = $produk_calculated_list[0]['diskon_rp'];
            $stock_available = $produk_calculated_list[0]['stock_available'];
            $jenis_promo = $produk_calculated_list[0]['jenis_promo'];
            $nama_promo = $produk_calculated_list[0]['nama_promo'];
            $id_promo = $produk_calculated_list[0]['id_promo'];
            $id_matrix_plan = "";
			$lockMin=$produk->lock_min;
			$lockMax=$produk->lock_max;

            //Wholesale Add
            $wholesale = $this->produk_m->getWholesaleByIdAndMinQty($id, $jml);

            if (!empty($wholesale)) {
                if ($diskon > 1) {
                    $price = $wholesale->harga_publik * (100 - $diskon) / 100;
                    $harga = $wholesale->harga_publik * (100 - $diskon) / 100;
                } else {
                    $price = $wholesale->harga_publik;
                    $harga = $wholesale->harga_publik;
                }
                $jenis_promo = "wholesale";
                $hargaMerchant = $wholesale->harga_merchant;
                $blendedTransactionFee = $wholesale->transaction_fee;
                $blendedInsentifCipika = $wholesale->blended_insentif;
                $blendedShippingFeeToJakarta = $wholesale->shipping_fee_to_jakarta;
                $selisihPembulatan = $wholesale->selisih_pembulatan;
            }
            


			$vIsVoucher_elektronik=0;$vIsVoucher_elektronik_code='';
/*
			$isProductVoucherElektronik = $this->order_m->get_single_where('tbl_voucher_stock_merchant', 'vsm_type="elektronik" and vsm_product_id like "%,'.$id.',%" '); //and vsm_status="active"
			if ($isProductVoucherElektronik) {
				$vIsVoucher_elektronik      = 1;
				$vIsVoucher_elektronik_code = $isProductVoucherElektronik->vsm_kode;
			}
*/            
            $data=array(
                'id'                                => $id, //$this->cart_m->cartNextId(),
                'id_produk'                         => $id,
                'id_merchant'                       => $id_merchant,
                'image'                             => $image,
                'qty'                               => $jml,
                'name'                              => $nama,
                'price'                             => $price,
                'harga'                             => $harga,
                'harga_merchant'                    => $hargaMerchant,
                'berat'                             => $berat,
                'berat_produk'                      => $berat_produk,
                'lebar'                             => $lebar,
                'panjang'                           => $panjang,
                'tinggi'                            => $tinggi,
                'stok'                              => $stok,
                'dimensi'                           => $dimensi,
                'discount'                          => $diskon,
                'discount_rp'                       => $diskon_rp,
                'stock_available'                   => $stock_available,
                'jenis_promo'                       => $jenis_promo,
                'nama_promo'                        => $nama_promo,
                'id_promo'                          => $id_promo,
                'blended_transaction_fee'           => $blendedTransactionFee,
                'blended_insentif_cipika'           => $blendedInsentifCipika,
                'blended_shipping_fee_to_jakarta'   => $blendedShippingFeeToJakarta,
                'selisih_pembulatan'                => $selisihPembulatan,
                'id_matrix_plan'                    => $id_matrix_plan,
                'kelipatan'                         => $produk->kelipatan,
                'produk_voucher_elektronik'         => $vIsVoucher_elektronik,
                'produk_voucher_elektronik_agent'   => $vIsVoucher_elektronik_code,
                'isMobo'                            => 0,
                'produk_voucher_listrik'            => '',
                'produk_voucher_listrik'            => '',
                'deskripsi'            				=> $produk->deskripsi,
				'lockMin'					=> $lockMin,
				'lockMax'					=> $lockMax,
            );  
            $result = $this->cart->insert($data);
			return $this->cart->total_items();
			
/*
        } else {
            $produk_calculated_list = $produk_price_calculator->getPriceList(array(0=>$produk));
            
                if (empty($data_lama['id_matrix_plan'])) {
                
                    if(empty($qty)){
                        $jumlah = $data_lama['qty']+1;
                    } else {
                        if ($data_lama['jenis_promo'] != 'bidding') {
                            if(($data_lama['qty']+$qty) > $produk_calculated_list[0]['stock_available']){
                                $jumlah = $produk_calculated_list[0]['stock_available'];
                            } else {
                                $jumlah = $data_lama['qty']+$qty;
                            }
                        }
                    }
                    
                } else {
                    
                    $jumlah = $data_lama['qty'];
                    
                }
            
            $data=array(
                'rowid' => md5($id), //$data_lama['rowid'],
                'qty' => $jumlah,
                'berat' => $data_lama['berat']+$produk->jne_berat
            );
            
            $getProduk = $this->produk_m->get_single("tbl_produk", 'id_produk', $id);
            $getMerchantReload = $this->produk_m->get_single('tbl_store', 'id_user', $getProduk->id_user);
            if ($getMerchantReload->merchant_voucher_reload !== "Y") {
                $this->cart->update($data);
            }
*/
        }
        
//        echo json_encode(array('qty'=>$this->cart->total_items()));
    }

    public function remove_product_registration($id=''){ 
		$data=array(
			'rowid' => $id,
			'qty' => 0,
			'berat' => 0
		);   
		$this->cart->remove($data);
    }	
   
    public function productList($ev_id='',$product_exception=''){ // hanya digunakan oleh pendaftaran anggota persib , untuk auto add to cart karena kadang2 session cart tiba2 hilang, I DONNT KNOW WHY and WHERE
        $diskon_kalkulator_promo_diskon = new Cipika\Promo\PromoDiskonCalculator($this->db,$this->session);
        $diskon_kalkulator_daily_deals = new Cipika\Promo\PromoDailyDealsCalculator($this->db,$this->session);
        $produk_price_calculator = new Cipika\Promo\ProdukPriceCalculator;
        $produk_price_calculator->addPriceListDiskonKalkulator($diskon_kalkulator_promo_diskon);
        $produk_price_calculator->addPriceListDiskonKalkulator($diskon_kalkulator_daily_deals);

		
		$dataProductList = array();
		$vProductItem = array();
		$sql = "SELECT * FROM `tbl_produk` where show_on_listing=1 and publish=1 and channel='".$ev_id."' 
				and id_produk not in (".$product_exception.")
				";
//				echo $sql;die;
        $q = $this->db->query($sql);
        $data = $q->result();
		$num=9999;
		foreach ($data as $row) { 
			$num+=1;
            
			$produk=$this->produk_m->getProdukDetail($row->id_produk);
            $produk_calculated_list = $produk_price_calculator->getPriceList(array(0=>$produk));

			$nama=$produk->nama_produk;
            $id_merchant=$produk->id_user;
			$jml=0;
            $image=$produk->images;
            $harga=$produk->harga_jual;         
            $stok=$produk->stok_produk;
            $berat=$produk->jne_berat;
            $dimensi=$produk->panjang*$produk->lebar*$produk->tinggi;
            $berat_produk = $produk->berat;
            $panjang = $produk->panjang;
            $lebar = $produk->lebar;
            $tinggi = $produk->tinggi;
            $hargaMerchant = $produk->harga_produk;
            $blendedTransactionFee = $produk->blended_transaction_fee;
            $blendedInsentifCipika = $produk->blended_insentif_cipika;
            $blendedShippingFeeToJakarta = $produk->blended_shipping_fee_to_jakarta;
            $selisihPembulatan = $produk->selisih_pembulatan;
            $price= $produk_calculated_list[0]['harga_setelah_diskon'];
            $diskon = $produk_calculated_list[0]['diskon'];
            $diskon_rp = $produk_calculated_list[0]['diskon_rp'];
            $stock_available = $produk_calculated_list[0]['stock_available'];
            $jenis_promo = $produk_calculated_list[0]['jenis_promo'];
            $nama_promo = $produk_calculated_list[0]['nama_promo'];
            $id_promo = $produk_calculated_list[0]['id_promo'];
            $id_matrix_plan = "";
			$lockMin=$produk->lock_min;
			$lockMax=$produk->lock_max;

			$vIsVoucher_elektronik=0;$vIsVoucher_elektronik_code='';
            
            $vProductItem[md5($row->id_produk)] = array(
				'rowid'                             => md5($row->id_produk),
                'id'                                => $num,
                'id_produk'                         => $row->id_produk,
                'id_merchant'                       => $id_merchant,
                'image'                             => $image,
                'qty'                               => $jml,
                'name'                              => $nama,
                'price'                             => $price,
                'harga'                             => $harga,
                'harga_merchant'                    => $hargaMerchant,
                'berat'                             => $berat,
                'berat_produk'                      => $berat_produk,
                'lebar'                             => $lebar,
                'panjang'                           => $panjang,
                'tinggi'                            => $tinggi,
                'stok'                              => $stok,
                'dimensi'                           => $dimensi,
                'discount'                          => $diskon,
                'discount_rp'                       => $diskon_rp,
                'stock_available'                   => $stock_available,
                'jenis_promo'                       => $jenis_promo,
                'nama_promo'                        => $nama_promo,
                'id_promo'                          => $id_promo,
                'blended_transaction_fee'           => $blendedTransactionFee,
                'blended_insentif_cipika'           => $blendedInsentifCipika,
                'blended_shipping_fee_to_jakarta'   => $blendedShippingFeeToJakarta,
                'selisih_pembulatan'                => $selisihPembulatan,
                'id_matrix_plan'                    => $id_matrix_plan,
                'kelipatan'                         => $produk->kelipatan,
                'produk_voucher_elektronik'         => $vIsVoucher_elektronik,
                'produk_voucher_elektronik_agent'   => $vIsVoucher_elektronik_code,
                'isMobo'                            => 0,
                'produk_voucher_listrik'            => '',
                'produk_voucher_listrik'            => '',
                'deskripsi'            				=> $produk->deskripsi,
				'lockMin'					=> $lockMin,
				'lockMax'					=> $lockMax,
            );  
			

		}

		$dataProductList +=$vProductItem;
		return $dataProductList;
	}

// ================== CIPIKA =============
	
    function sum_qty($id=''){
        $sql="select sum(qty) as qty from tbl_cart where id_user='". (int)$id ."'";
        $q=$this->db->query($sql);
        $data=$q->row();
        $q->free_result();
        return $data->qty;
    }

    function get_item($id_produk='', $id_user=''){
        $this->db->where('id_produk', (int)$id_produk);
        $this->db->where('id_user', (int)$id_user);
        $q=$this->db->get('tbl_cart');
        $data=$q->row();
        $q->free_result();
        return $data;
    }
    
    function get_invoice($id=''){
        $sql="select a.*, b.nama_payment as payment, c.nama, c.alamat, c.telpon, c.email, d.nama_propinsi, e.nama_kabupaten, f.*
            from tbl_order a, tbl_payment b, tbl_ordershipping c, tbl_propinsi d, tbl_kabupaten e, tbl_invoices f
            where a.id_payment=b.id_payment and a.id_order=c.id_order and c.id_provinsi=d.id_propinsi and c.id_kota=e.id_kabupaten and f.kode_invoice=a.kode_invoice and md5(f.id_invoice)='". $this->db->escape_str($id) ."'";
        $q=$this->db->query($sql);
//        echo $sql;
        $data=$q->row();
        $q->free_result();
        return $data;
    }    
    
    function get_order($id=''){
        $sql="select a.*, b.nama_payment as payment, c.nama, c.alamat, c.telpon, c.email, c.id_kecamatan, d.nama_propinsi, e.nama_kabupaten, f.nama_kecamatan, j.manifest_date, j.city_name, j.pod_receiver, j.paket_pengiriman 
            from tbl_order a
            left join tbl_payment b on a.id_payment=b.id_payment
            left join tbl_ordershipping c on a.id_order=c.id_order
            left join tbl_propinsi d on c.id_provinsi=d.id_propinsi
            left join tbl_kabupaten e on c.id_kota=e.id_kabupaten
            left join tbl_kecamatan f on c.id_kecamatan=f.id_kecamatan
            left join tbl_jne_awb_status j on a.kode_order = j.kode_order
            where md5(a.id_order)='". $this->db->escape_str($id) ."'";
        $q=$this->db->query($sql);
        $data=$q->row();
        $q->free_result();
        return $data;
    }    
    
    function get_order_by_invoice($id=''){
        $sql="select a.*, b.nama_payment as payment, c.nama, c.alamat, c.telpon, c.email, c.id_kecamatan, d.nama_propinsi, e.nama_kabupaten, f.nama_kecamatan
            from tbl_order a
            left join tbl_payment b on a.id_payment=b.id_payment
            left join tbl_ordershipping c on a.id_order=c.id_order
            left join tbl_propinsi d on c.id_provinsi=d.id_propinsi
            left join tbl_kabupaten e on c.id_kota=e.id_kabupaten
            left join tbl_kecamatan f on c.id_kecamatan=f.id_kecamatan  
            where md5(a.kode_invoice)='". $this->db->escape_str($id) ."'";
        $q=$this->db->query($sql);
        $data=$q->result();
        $q->free_result();
        return $data;
    }     

    function get_order_shipping($id=''){
        $sql="select a.*, b.nama_propinsi, c.nama_kabupaten
            from tbl_ordershipping a, tbl_propinsi b, tbl_kabupaten c
            where a.id_provinsi=b.id_propinsi and a.id_kota = c.id_kabupaten and a.id_order='". (int)$id."'";
        $q=$this->db->query($sql);
        $data=$q->row();
        $q->free_result();
        return $data;
    }

    function get_order_item($id=''){
        $sql="select a.*, b.nama_produk
            from tbl_orderitem a, tbl_produk b
            where a.id_produk=b.id_produk and md5(a.id_order)='". $this->db->escape_str($id) ."'";
        $q=$this->db->query($sql);
        $data=$q->result();
        $q->free_result();
        return $data;
    }

    function get_user($id=''){
        $sql="select a.*, b.nama_kabupaten as kabupaten, c.nama_propinsi as propinsi, d.nama_kecamatan as kecamatan
            from tbl_user a left join tbl_kabupaten b on a.id_kabupaten=b.id_kabupaten
            left join tbl_propinsi c on a.id_propinsi=c.id_propinsi
            left join tbl_kecamatan d on a.id_kecamatan = d.id_kecamatan
            where a.id_user='" . (int)$id . "'";
        $q=$this->db->query($sql);
        $data=$q->row();
        $q->free_result();
        return $data;
    }

    function get_cart_qty(){        
        if(isset($_SESSION['cart'])){
            $qty=count($_SESSION['cart']);
        } else {
            $qty=0;
        }
        return $qty;
    }

    function get_merchant($id=''){
        // $this->db->where('id_user', $id);
        // $q=$this->db->get('tbl_user');
        $sql="
select a.*, b.*, c.*, d.*
#, jo.name as jne_origin
, a.id_kecamatan as kecamatan,
            a.id_kabupaten as kabupaten, a.id_propinsi as propinsi 
#            ,jo.branch as origin_code
#            ,ro.name as rpx_origin 
            from tbl_store a
            left join tbl_kecamatan d on a.id_kecamatan=d.id_kecamatan
            left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
            left join tbl_propinsi b on a.id_propinsi=b.id_propinsi
#            left join jne_origin jo on a.id_jne_origin = jo.id
#            left join rpx_origin ro on a.id_rpx_origin = ro.id
            where a.id_user='". (int)$id ."'";
/*
        $sql="select a.*, b.*, c.*, d.*, jo.name as jne_origin, a.id_kecamatan as kecamatan,
            a.id_kabupaten as kabupaten, a.id_propinsi as propinsi 
            , jo.branch as origin_code
            ,ro.name as rpx_origin 
            from tbl_store a
            left join tbl_kecamatan d on a.id_kecamatan=d.id_kecamatan
            left join tbl_kabupaten c on a.id_kabupaten=c.id_kabupaten
            left join tbl_propinsi b on a.id_propinsi=b.id_propinsi
            left join jne_origin jo on a.id_jne_origin = jo.id
            left join rpx_origin ro on a.id_rpx_origin = ro.id
            where a.id_user='". (int)$id ."'";
*/            

        $q=$this->db->query($sql);
        $data=$q->row();
        $q->free_result();
        return $data;
    }

    function get_produk($id=''){
        $sql="select a.*, b.image from tbl_produk a, tbl_produkfoto b
            where a.id_produk = b.id_produk and a.id_produk = '" . (int)$id . "' group by a.id_produk";
        $q=$this->db->query($sql);
        $data=$q->row();
        $q->free_result();
        return $data;
    }
        
    function get_cart_item(){
        foreach ($_SESSION['cart'] as $key) {
            $id[]=$key['id_produk'];
        }
        $data = '\'' . implode('\', \'', $id) . '\'';
        $sql="select * from tbl_produk where id_produk in (".$data.")";
        $q=$this->db->query($sql);
        $data=$q->result();
        $q->free_result();
        return $data;
    }

    function get_new_id_order($key=''){
        
        $length = strlen($key);

        $q = $this->db->query("select count(*) as jumlah from tbl_order where (select left(kode_order, $length))='" . $this->db->escape_str($key) . "' ");
        $data = $q->row();
        $q->free_result();
        return $data;
    }
    
    function get_new_index_order($key=''){
        
        $length = strlen($key);

        $q = $this->db->query("select kode_order from tbl_order where kode_order like '". $this->db->escape_str($key) . "%' order by id_order desc limit 0, 1;");
        $data = $q->row();
        $q->free_result();
        if (isset($data->kode_order)){
            $exp = explode("-", $data->kode_order);
            return (int) $exp[1];
        } else {
            return 0;
        }
    }
    
    function get_new_id_invoice($key=''){
        $length = strlen($key);
        
        $q = $this->db->query("select count(*) as jumlah from tbl_invoices where (select left(kode_invoice, $length))='" . $this->db->escape_str($key) . "' ");
        $data = $q->row();
        $q->free_result();
        return $data;
    }
    
    function check_kategori($id='', $id_kategori=''){
         $sql="select * from tbl_produk_kategori
            where id_produk = '". (int)$id ."' and id_kategori = '". (int)$id_kategori."'";
        $q=$this->db->query($sql);
        $data=$q->num_rows();
        $q->free_result();
        if($data)
        return 1;
        else {
            return 0;
        }
    }

    function cek_jne($from, $to){
        $data = array(
            'transaction_id' => $this->get('transaction_id'),
            's_propinsi' => $this->get('s_propinsi'),
            's_kota_kab' => $this->get('s_kota_kab'),
            'd_kecamatan' => $this->get('d_kecamatan'),
            'd_kota_kab' => $this->get('d_kota_kab'),
            'd_propinsi' => $this->get('d_propinsi'),
            'weight' => $this->get('weight'),
            'volume' => $this->get('volume'),
        );
        $data_string = json_encode($data);

        $url = "http://124.81.102.190:543/shipment/page/api_jne.php?key=" . urlencode($data_string);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $login = curl_exec($ch);
        curl_close($ch);

        $login = json_decode($login);
        
        if ($login)
        {
            return $login;
        }
        else
        {
            echo 'Maaf Ongkos kirim tidak ditemukan.';
        }
    }

    function chekReadySettlement($id)
    {
        $date=date('Y-m-d');
        $sql="SELECT COUNT(*) AS jumlah
            FROM tbl_order a
            LEFT JOIN tbl_store b ON a.id_merchant=b.id_user
            WHERE 
            TIMESTAMPDIFF(DAY, date(a.date_added), NOW()) > 2 
            AND a.status_payment='paid' 
            AND a.status_delivery IN ('proses pengiriman', 'produk telah diterima')
            AND a.id_order = '" . (int)$id . "'
            AND b.store_status = 'approve'";
        $q=$this->db->query($sql);
        $data=$q->row();
        $q->free_result();
        return $data->jumlah;
    }
    
    function cartNextId()
    {
        $id = 0;
        $cart = $this->cart->contents();
        foreach($cart as $val){
            $id = $val['id'];
        }
        $id++;
        return $id;
    }
    
    function getDetailPaketByIdProduk($id_produk)
    {
        $this->db->select('detail_paket');
        $this->db->where('id_produk',$id_produk);
        $query = $this->db->get('tbl_produk');
        $data = $query->row();
        if(!empty($data)){
            return $data->detail_paket;
        } else {
            return '';
        }
    }
    
    function totalharga()
    {
        $cart = $this->cart->contents();
        $totalharga = 0;
        foreach ($cart as $row) {
            if(!empty($row['discount'])){
                $totalharga += ($row['price']*$row['qty']);
            } else {
                $totalharga += ($row['harga']*$row['qty']);
            }
        }
        return $totalharga;
    }

    function totalhargaPS() //point senyum
    {
        /*
        $cart = $this->cart->contents();
        $totalhargaps = 0;
        foreach ($cart as $row) {
            if (isset($row['isPointSenyum'])) {
                if((int)$row['isPointSenyum']>0){
                    $totalhargaps += ($row['harga_produk_ps']*$row['qty']);
                }
            }
        }
        return $totalhargaps;
        */
    }

    function totalhargaMobo() //mobo
    {
        $cart = $this->cart->contents();
        $totalhargaps = 0;
        foreach ($cart as $row) {
            if (isset($row['isMobo'])) {
                if((int)$row['isMobo']>0){
                    $totalhargaps += ($row['harga_mobo']*$row['qty']);
                }
            }
        }
        return $totalhargaps;
    }

    
    function get_order_item_cicilan ($idOrder)
    {
        $sql = "select oic.* from tbl_orderitem oi, tbl_orderitem_cicilan oic ".
                "where oi.id_order = " . (int) $idOrder . " and oi.id_orderitem = oic.id_orderitem;";
        $query = $this->db->query($sql);

        $data = $query->result();

        return $data;
    }
    
    public function getChannelByIdProduk($id_produk)
    {
		$this->db->select('channel');
		$this->db->where('id_produk',$id_produk);
		$query = $this->db->get('tbl_produk');
		$data = $query->row();
		return $data->channel;
	}
    
    public function matrixItemCheck($cart)
    {
		$is_matrix = false;
		foreach ($cart as $c) {
			$channel = $this->getChannelByIdProduk($c['id_produk']);
			if ($channel == 'MATRIX') {
				$is_matrix = $c['id_produk'];
				break;
			}
		}
		
		return $is_matrix;
	}
    
    public function getMatrixItemFromCart($cart)
    {
        $matrix = '';
		foreach ($cart as $c) {
			$channel = $this->getChannelByIdProduk($c['id_produk']);
			if ($channel == 'MATRIX') {
				$matrix = $c;
			}
		}
		
		return $matrix;
    }
    
    public function isMatrixOneAndOnly($cart)
    {
        $error = '';
        $idProdukMatrix = $this->matrixItemCheck($cart);
        $idProdukGiveaway = $this->GiveawayIdProdukExtract($cart);
        $idProdukArr = $this->CartIdProdukExtract($cart);
        
        //hitung jumlah item ilegal
        $IlegalProduct = array_diff($idProdukArr,array( 0 => $idProdukMatrix));
        $IlegalProduct = array_diff($IlegalProduct,$idProdukGiveaway);
        
        if ($idProdukMatrix && count($IlegalProduct) > 0) {
            $error .= '<p>Pembelian produk matrix tidak dapat digabung dengan produk lain, silahkan hapus produk lain tersebut untuk melanjutkan.</p>';
        }
        
        if($idProdukMatrix) {
        
            $matrix_product = $this->getMatrixItemFromCart($cart);
            
            if ($matrix_product['qty'] > 1){
                $error .= '<p>Jumlah produk matrix hanya diizinkan satu, silahkan update jumlah produk matrix menjadi satu.</p>';
            }
        
        }
        
        return $error;
    }
    
    public function CartIdProdukExtract($cart)
    {
        $id_produk = array();
        
        foreach($cart as $data) {
            $id_produk[] = $data['id_produk'];
        }
        
        return $id_produk;
    }
    
    public function GiveawayIdProdukExtract($cart)
    {
        $id_produk = array();
        
        foreach($cart as $data) {
            if($data['jenis_promo'] == 'giveaway') {
                $id_produk[] = $data['id_produk'];
            }
        }
        
        return $id_produk;
    }

    function get_detail_cicilan_by_id_order($idOrder)
    {
        $this->db->select('oic.periode_cicilan, oic.bunga_cicilan');
        $this->db->from('tbl_orderitem oi');
        $this->db->join('tbl_orderitem_cicilan oic', 'oi.id_orderItem = oic.id_orderItem');
        $this->db->where('oi.id_order', $idOrder);

        $query = $this->db->get();
        return $query->row();
    }

    function get_detail_cicilan_by_kode_invoice($kodeInvoice)
    {
        $this->db->select('oic.periode_cicilan, oic.bunga_cicilan');
        $this->db->from('tbl_orderitem oi');
        $this->db->join('tbl_orderitem_cicilan oic', 'oi.id_orderItem = oic.id_orderItem');
        $this->db->join('tbl_order o', 'o.id_order = oi.id_order');
        $this->db->where('o.kode_invoice', $kodeInvoice);

        $query = $this->db->get();
        return $query->row();
    }

    function isCartContainBiddingPriceProduct($cart)
    {
        foreach ($cart as $item) {
            if ($item['jenis_promo'] == 'bidding') {
                return true;
            }
        }

        return false;
    }

    function get_cart_quantity($cart)
    {
        $vQty=0;
        foreach ($cart as $item) {
            $vQty+=$item['qty'];
        }
        return $vQty;
    }    

    function check_allowed_buy_voucher($id_user=0, $cart_qty=0, $productvoucher_detail){


        $sql = 'SELECT count(*) as voucher_ready
                from tbl_voucher_stock a    
                inner join tbl_voucher_stock_merchant b on (b.vsm_kode=a.pvs_parter and b.vsm_type="elektronik")
                where a.pvs_status="ready" and a.pvs_partner="'.$productvoucher_detail->vsm_kode.'"
                ';
        $q = $this->db->query($sql);
        $data = $q->row_object();
        if ($q->num_rows() > 0) {
            if ($data->voucher_ready<$cart_qty) {
                if ($data->voucher_ready==0) {
                    $error= "Maaf, untuk pembelian produk <u><b>".$productvoucher_detail->vsm_name."</b></u> tidak bisa diproses dikarenakan stock tiket elektronik habis. <br>Mohon ulangi beberapa saat lagi.";
                } else {
                    $error= "Maaf, untuk pembelian produk <u><b>".$productvoucher_detail->vsm_name."</b></u> tidak bisa diproses dikarenakan stock tiket elektronik tidak mencukupi atas jumlah order anda. <br>Mohon kurangi jumlah pesanan anda untuk dapat melanjutkan pembelian.";
                }
                $out= array('status' => 0,'error' => $error);
                /* logger */
                $log_array_data = json_decode(json_encode($productvoucher_detail), true);
                $log_persib_data = array(
                    'id_user'           => $id_user,
                    'error'             => $error,
                );
                $log_data = array_merge($log_persib_data,$log_array_data);
                $this->logger->addEmergency('voucher elektronik : order error', $log_data);
                /* !logger */
                return (object) $out;
            }
        }    

        $sql = 'SELECT pvs_partner, DATE_FORMAT(pvs_date_used, "%Y-%m-%d") as last_buy, count(*) as jml_voucher_bought 
                FROM `tbl_voucher_stock` 
                where pvs_used_by='.$id_user.'';
        if (trim($productvoucher_detail->wtl_produk_prefix.'')=='') {
            $sql .= ' and pvs_partner="'.$productvoucher_detail->vsm_kode.'"';
        } else {
            if (trim($productvoucher_detail->wtl_quota_applied_to.'')=='whitelabel') {
                $sql .= ' and pvs_partner like "'.$productvoucher_detail->wtl_produk_prefix.'%"';
            } else if (trim($productvoucher_detail->wtl_quota_applied_to.'')=='produk') {
                $sql .= ' and pvs_partner="'.$productvoucher_detail->vsm_kode.'"';
            } else {
                $sql .= ' and pvs_partner="'.$productvoucher_detail->vsm_kode.'"';
            }
        }
        $sql .= ' group by pvs_partner,pvs_date_used 
                order by pvs_date_used desc limit 1';

        $q = $this->db->query($sql);
        $data = $q->row_object();
        $batasBeliMaksimal=$productvoucher_detail->vsm_quota_value;
        if ($q->num_rows() > 0) {
            if ($data->last_buy != "0000-00-00") {
                //echo 'lastbuy';die;
                $date_last_buy = new DateTime($data->last_buy);
                $date_now = new DateTime();
                $interval = $date_now->diff($date_last_buy);
                $vsm_quota_every=(int)trim(str_replace('hari','',$productvoucher_detail->vsm_quota_every)); //1;
//                echo $vsm_quota_every;die;
                $vOperator='>';
                
                $a = (int)$interval->format('%a');
                //$char = '>';
                //if ($productvoucher_detail->vsm_quota_condition=='') { $char = '=='; }
                $b = ($vsm_quota_every-1);
                //$c = eval("return $a $char $b;");
                //if ($c) {
//                echo $cart_qty.'+'.$data->jml_voucher_bought.'<='.$productvoucher_detail->vsm_quota_value;die;
                $vtotal_beli_today=0;
                if ((int)$interval->format('%a') > ($vsm_quota_every-1)) {
                    //$out= array('status' => 1,'error' => '',);
                } else {
                    $vtotal_beli_today=$data->jml_voucher_bought;
                    /*
                    if (($cart_qty+$data->jml_voucher_bought)<=$productvoucher_detail->vsm_quota_value) {
                        $out= array('status' => 1,'error' => '',);
                    } else {
                        $out= array('status' => 0,'error' => 'Maaf, untuk pembelian produk voucher '.$productvoucher_detail->vsm_kode.' dibatasi '.$productvoucher_detail->vsm_quota_condition.' '.$productvoucher_detail->vsm_quota_value.' voucher setiap '.str_replace('day','',$productvoucher_detail->vsm_quota_every).'.',);
                    }
                    */
                }
//                    if (($cart_qty+$vtotal_beli_today)<=$productvoucher_detail->vsm_quota_value) {
//                        $out= array('status' => 1,'error' => '',);
//                    } else {
//                        $out= array('status' => 0,'error' => 'Maaf, untuk pembelian produk voucher '.$productvoucher_detail->vsm_name.' dibatasi '.$productvoucher_detail->vsm_quota_condition.' '.$productvoucher_detail->vsm_quota_value.' buah setiap '.str_replace('day','',$productvoucher_detail->vsm_quota_every).'.',);
//                    }
                //echo $interval->format('%a total days')."\n";
                //->31 total days
                //echo $interval->format('%m month, %d days');
                //->1 month, 0 days
            }
        } else {
            $vtotal_beli_today=0;
        }

        // Persib ticket Rule
        //if (substr(trim($productvoucher_detail->vsm_kode),0,14)=='PERSIB_TICKET_') {$batasBeliMaksimal=1;}
        //if ($this->get_persib_member($id_user)) {$batasBeliMaksimal=2;}
        // !Persib ticket Rule
        
        $vSetiap = trim(str_replace('','',$productvoucher_detail->vsm_quota_every));
        if ($vSetiap==9999) {$vSetiap='member';}
//        echo ($cart_qty+$vtotal_beli_today).'='.$batasBeliMaksimal;die;
        if (($cart_qty+$vtotal_beli_today)<=$batasBeliMaksimal) {
            $out= array('status' => 1,'error' => '',);
        } else {
            $out= array('status' => 0,'error' => 'Maaf, untuk pembelian produk <u><b>'.$productvoucher_detail->vsm_name.'</b></u> dibatasi '.$productvoucher_detail->vsm_quota_condition.' '.$batasBeliMaksimal.' buah setiap '.$vSetiap.'.',);
        }
        return (object) $out;

    }    
    
    function get_id_program_diskon($id_promo) {
        $this->db->select('id_program_diskon');
        $this->db->where('id_promo_marketing', $id_promo);
        return $this->db->get('tbl_promo_marketing');
    }
    
    function check_trx_promo_diskon($user_id, $nama_promo) {
        $this->db->select('tbl_invoices.kode_invoice, tbl_invoices.status_payment, tbl_order.id_order, tbl_order.kode_order, tbl_orderitem.id_orderItem, tbl_orderitem.id_order, tbl_orderitem.id_produk, tbl_orderitem.jenis_promo, tbl_orderitem.nama_promo');
        $this->db->where('tbl_invoices.id_user', $user_id);
        $this->db->where('tbl_invoices.status_payment', 'paid');
        $this->db->where('tbl_orderitem.jenis_promo', 'promo_diskon');
        $this->db->where('tbl_orderitem.nama_promo', $nama_promo);
        $this->db->where('date(tbl_invoices.date_added)', date('Y-m-d'));
        $this->db->join('tbl_order', 'tbl_order.kode_invoice = tbl_invoices.kode_invoice', 'left');
        $this->db->join('tbl_orderitem', 'tbl_orderitem.id_order = tbl_order.id_order', 'left');
        return $this->db->get('tbl_invoices');
    }
    
    function get_persib_member($id_user=0){
        $sql='select no_hp from tbl_persib_formulir where id_user='.$id_user.' and status_member="aktif"';
        $q=$this->db->query($sql);
        $data=$q->row();
        $q->free_result();
        return $data;
    }    

    public function add($id=0, $qty=0){ // hanya digunakan oleh pendaftaran anggota persib , untuk auto add to cart karena kadang2 session cart tiba2 hilang, I DONNT KNOW WHY and WHERE
        $diskon_kalkulator_promo_diskon = new Cipika\Promo\PromoDiskonCalculator($this->db,$this->session);
        $diskon_kalkulator_daily_deals = new Cipika\Promo\PromoDailyDealsCalculator($this->db,$this->session);
        $produk_price_calculator = new Cipika\Promo\ProdukPriceCalculator;
        $produk_price_calculator->addPriceListDiskonKalkulator($diskon_kalkulator_promo_diskon);
        $produk_price_calculator->addPriceListDiskonKalkulator($diskon_kalkulator_daily_deals);
        // $id=$this->input->post('id_produk');
        // $qty=$this->input->post('qty');
        $data_lama=array();
        $sudah_ada=FALSE;

        $this->session->unset_userdata('voucherMember');

        //$produk=$this->cart_m->get_produk($id);
        //$produk=$this->produk_m->get_produk($id);
        $produk=$this->produk_m->getProdukDetail($id);

        if ($produk->channel == "WHOLESALE") {
            $wholesale_rule = $this->wholesale_m->getSingleWholesaleRuleByIdProduk($produk->id_produk);
            if ($qty < $wholesale_rule->qty_minimal) {
                $qty = $wholesale_rule->qty_minimal;
            }
        }
        
        // var_dump($produk);exit;
        // cek sudah ada apa belum datanya
        /*
        $arrayidprod = array('0');
        $arrayidprod[] = $produk->id_produk;
        $produk_promo = $this->home_m->get_produk_promo($arrayidprod);
        $order_promo_quota = $this->home_m->get_order_promo_quota($arrayidprod);
        $order_promo_quota_per_day = $this->home_m->get_order_promo_quota_per_day($arrayidprod);
        if($this->session->userdata('member')){
            $order_promo_day = $this->home_m->get_order_promo_day($arrayidprod, $this->session->userdata('member')->id_user);
        }
        * */
        $is_bidding = false;
        $cart = $this->cart->contents();
        
        foreach($cart as $items){
            if ($items['jenis_promo'] == 'bidding') {
                $is_bidding = true;
            }
            if(((isset($items['id_produk']) && $items['id_produk']==$id) || $items['id']==$id) && $items['jenis_promo'] != 'giveaway'){
                /*
                $sudah_ada=TRUE;
                $data_lama=$items;
                if($data_lama['qty']==$produk->stok_produk) exit;
                $cek_promo = FALSE;
                foreach ($produk_promo as $data_promo){
                    if($data_promo->id_produk == $produk->id_produk){
        //                echo "a".PHP_EOL;
                        $cek_promo = TRUE;
                        foreach($order_promo_quota as $data_promo_quota){
                            if($data_promo_quota->id_produk == $data_promo->id_produk && $data_promo_quota->jumlah >= $data_promo->quota){
                                $cek_promo = FALSE;
                            }else{
                                foreach($order_promo_quota_per_day as $data_promo_quota_per_day){
                                    if($data_promo_quota_per_day->id_produk == $data_promo->id_produk && $data_promo_quota_per_day->jumlah >= $data_promo->quota_per_day){
                                        $cek_promo = FALSE;
                                    }else{
                                        if(!empty($order_promo_day)){
                                            $cek_promo = TRUE;
                                            foreach($order_promo_day as $data_promo_day){
                                                if($data_promo_day->id_produk == $data_promo->id_produk && $data_promo_day->jumlah >= $data_promo->max_item_per_day){
                                                   $cek_promo = FALSE;
                                                   break;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if($cek_promo){
                            var_dump($data_lama['qty']==$data_promo->max_item_per_day);
                            if($data_lama['qty']==$data_promo->max_item_per_day)
                            exit;
                        }
                    }
                }
                * 
                */
                $produk_calculated_list = $produk_price_calculator->getPriceList(array(0=>$produk));
                $sudah_ada=TRUE;
                $data_lama=$items;
                
                if($data_lama['qty']==$produk->stok_produk) {
                    exit;
                }
                
                if($data_lama['qty']==$produk_calculated_list[0]['stock_available']) {
                    exit;
                }
            }
        }

        if(!$sudah_ada){
            /*
            $diskon = $produk->diskon;
            $harga_diskon = $produk->harga_jual-($produk->harga_jual*$produk->diskon/100);
            $cek_promo = FALSE;
            foreach ($produk_promo as $data_promo){
                if($data_promo->id_produk == $produk->id_produk){
    //                echo "a".PHP_EOL;
                    $cek_promo = TRUE;
                    foreach($order_promo_quota as $data_promo_quota){
                        if($data_promo_quota->id_produk == $data_promo->id_produk && $data_promo_quota->jumlah >= $data_promo->quota){
                            $cek_promo = FALSE;
                        }else{
                            foreach($order_promo_quota_per_day as $data_promo_quota_per_day){
                                if($data_promo_quota_per_day->id_produk == $data_promo->id_produk && $data_promo_quota_per_day->jumlah >= $data_promo->quota_per_day){
                                    $cek_promo = FALSE;
                                }else{
                                    if(!empty($order_promo_day)){
                                        $cek_promo = TRUE;
                                        foreach($order_promo_day as $data_promo_day){
                                            if($data_promo_day->id_produk == $data_promo->id_produk && $data_promo_day->jumlah >= $data_promo->max_item_per_day){
                                               $cek_promo = FALSE;
                                               break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if($cek_promo){
                        $diskon = $data_promo->diskon;
                        $harga_diskon = $produk->harga_jual-($produk->harga_jual*$diskon/100); 
                    }
                }
            }
            */
            
            $produk_calculated_list = $produk_price_calculator->getPriceList(array(0=>$produk));
            
            //Matrix
            $kateogri_produk_matrix = $this->produk_m->getAllKategoriProductByProductId($id);
            $matrix_plan = $this->matrix_m->getMatrixPlanByIdKategori($kateogri_produk_matrix);
            
            $nama=$produk->nama_produk;
            $id_merchant=$produk->id_user;
            if(!empty($qty)){
                if($qty>=$produk_calculated_list[0]['stock_available']){
                    $jml=$produk_calculated_list[0]['stock_available'];
                } else {
                    $jml=$qty;
                }
            } else {
                $jml=1;
            }
            $image=$produk->images;
            $harga=$produk->harga_jual;         
            $stok=$produk->stok_produk;
            $berat=$produk->jne_berat;
            $dimensi=$produk->panjang*$produk->lebar*$produk->tinggi;
            $berat_produk = $produk->berat;
            $panjang = $produk->panjang;
            $lebar = $produk->lebar;
            $tinggi = $produk->tinggi;
            $hargaMerchant = $produk->harga_produk;
            $blendedTransactionFee = $produk->blended_transaction_fee;
            $blendedInsentifCipika = $produk->blended_insentif_cipika;
            $blendedShippingFeeToJakarta = $produk->blended_shipping_fee_to_jakarta;
            $selisihPembulatan = $produk->selisih_pembulatan;
            $price= $produk_calculated_list[0]['harga_setelah_diskon'];
            $diskon = $produk_calculated_list[0]['diskon'];
            $diskon_rp = $produk_calculated_list[0]['diskon_rp'];
            $stock_available = $produk_calculated_list[0]['stock_available'];
            $jenis_promo = $produk_calculated_list[0]['jenis_promo'];
            $nama_promo = $produk_calculated_list[0]['nama_promo'];
            $id_promo = $produk_calculated_list[0]['id_promo'];
            $id_matrix_plan = "";

            //Wholesale Add
            $wholesale = $this->produk_m->getWholesaleByIdAndMinQty($id, $jml);

            if (!empty($wholesale)) {
                if ($diskon > 1) {
                    $price = $wholesale->harga_publik * (100 - $diskon) / 100;
                    $harga = $wholesale->harga_publik * (100 - $diskon) / 100;
                } else {
                    $price = $wholesale->harga_publik;
                    $harga = $wholesale->harga_publik;
                }
                $jenis_promo = "wholesale";
                $hargaMerchant = $wholesale->harga_merchant;
                $blendedTransactionFee = $wholesale->transaction_fee;
                $blendedInsentifCipika = $wholesale->blended_insentif;
                $blendedShippingFeeToJakarta = $wholesale->shipping_fee_to_jakarta;
                $selisihPembulatan = $wholesale->selisih_pembulatan;
            }
            
            if(!empty($matrix_plan)) {
                $id_matrix_plan = $matrix_plan->id;
                $price = $matrix_plan->pembayaran_bulanan * $matrix_plan->kontrak_bulan;
                $harga = $matrix_plan->pembayaran_bulanan * $matrix_plan->kontrak_bulan;
                $stock_available = 1;
                $diskon = 0;
            }

$isProductVoucherElektronik = $this->order_m->get_single_where('tbl_voucher_stock_merchant', 'vsm_type="elektronik" and vsm_product_id like "%,'.$id.',%" '); //and vsm_status="active"
$vIsVoucher_elektronik=0;$vIsVoucher_elektronik_code='';
if ($isProductVoucherElektronik) {
    $vIsVoucher_elektronik      = 1;
    $vIsVoucher_elektronik_code = $isProductVoucherElektronik->vsm_kode;
}
            
            $data=array(
                'id'                                => $this->cart_m->cartNextId(),
                'id_produk'                         => $id,
                'id_merchant'                       => $id_merchant,
                'image'                             => $image,
                'qty'                               => $jml,
                'name'                              => $nama,
                'price'                             => $price,
                'harga'                             => $harga,
                'harga_merchant'                    => $hargaMerchant,
                'berat'                             => $berat,
                'berat_produk'                      => $berat_produk,
                'lebar'                             => $lebar,
                'panjang'                           => $panjang,
                'tinggi'                            => $tinggi,
                'stok'                              => $stok,
                'dimensi'                           => $dimensi,
                'discount'                          => $diskon,
                'discount_rp'                       => $diskon_rp,
                'stock_available'                   => $stock_available,
                'jenis_promo'                       => $jenis_promo,
                'nama_promo'                        => $nama_promo,
                'id_promo'                          => $id_promo,
                'blended_transaction_fee'           => $blendedTransactionFee,
                'blended_insentif_cipika'           => $blendedInsentifCipika,
                'blended_shipping_fee_to_jakarta'   => $blendedShippingFeeToJakarta,
                'selisih_pembulatan'                => $selisihPembulatan,
                'id_matrix_plan'                    => $id_matrix_plan,
                'kelipatan'                         => $produk->kelipatan,
                'produk_voucher_elektronik'         => $vIsVoucher_elektronik,
                'produk_voucher_elektronik_agent'   => $vIsVoucher_elektronik_code,
                'isMobo'                            => 0,
                'produk_voucher_listrik'            => '',
            );  
            $result = $this->cart->insert($data);
        } else {
            $produk_calculated_list = $produk_price_calculator->getPriceList(array(0=>$produk));
            
                if (empty($data_lama['id_matrix_plan'])) {
                
                    if(empty($qty)){
                        $jumlah = $data_lama['qty']+1;
                    } else {
                        if ($data_lama['jenis_promo'] != 'bidding') {
                            if(($data_lama['qty']+$qty) > $produk_calculated_list[0]['stock_available']){
                                $jumlah = $produk_calculated_list[0]['stock_available'];
                            } else {
                                $jumlah = $data_lama['qty']+$qty;
                            }
                        }
                    }
                    
                } else {
                    
                    $jumlah = $data_lama['qty'];
                    
                }
            
            $data=array(
                'rowid' => $data_lama['rowid'],
                'qty' => $jumlah,
                'berat' => $data_lama['berat']+$produk->jne_berat
            );
            
            $getProduk = $this->produk_m->get_single("tbl_produk", 'id_produk', $id);
            $getMerchantReload = $this->store_m->get_single('tbl_store', 'id_user', $getProduk->id_user);
            if ($getMerchantReload->merchant_voucher_reload !== "Y") {
                $this->cart->update($data);
            }
        }
        
//        echo json_encode(array('qty'=>$this->cart->total_items()));
    }

        function get_order_shipping_mobo($id=''){
        $sql="select a.*, b.nama_propinsi, c.nama_kabupaten
            from tbl_ordershipping a
            left join tbl_propinsi b on b.id_propinsi=a.id_provinsi
            left join tbl_kabupaten c on c.id_kabupaten=a.id_kota
            where a.id_order='". (int)$id."'";
        $q=$this->db->query($sql);
        $data=$q->row();
        $q->free_result();
        return $data;
    }
    
    function get_product_adira($id) {
        $sql="SELECT * FROM tbl_order_insurance
              WHERE md5(id_order_insurance)='". $this->db->escape_str($id) ."'";
        $q=$this->db->query($sql);
        $data=$q->row();
        $q->free_result();
        return $data;
    }
    
}

/* End of file  */
/* Location: ./application/models/ */
