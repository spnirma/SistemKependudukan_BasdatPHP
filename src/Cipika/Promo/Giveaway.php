<?php 
namespace Cipika\Promo;

class Giveaway
{
    private $db;
    private $session;
    public function __construct($db,$session)
    {
        $this->db = $db;
        $this->session = $session;
    }
    
    private function cartToIdProduct($cart)
    {
        foreach($cart as $val)
        {
            if(isset($val['id_produk'])){
                $id_produk_cart[] = $val['id_produk'];
            } else {
                $id_produk_cart[] = $val['id'];
            }
        }
        
        return $id_produk_cart;
    }
    
    private function getSyaratGroupByIdPromo($id_syarat_arr)
    {
        $this->db->or_where_in('id_produk',$id_syarat_arr);
        $this->db->group_by('id_promo_giveaway');
        $query = $this->db->get('tbl_syarat_pembelian_promo_giveaway');
        return $query->result();
    }
    
    private function getFullSyaratEachPromo($id_promo_giveaway)
    {
        if(!empty($id_promo_giveaway)) {
            $this->db->select('s.id_produk as id_produk');
            $this->db->select('nama_produk');
            $this->db->select('id_promo_giveaway');
            $this->db->select('qty');
            $this->db->or_where_in('p.id',$id_promo_giveaway);
            $this->db->join('tbl_syarat_pembelian_promo_giveaway s','p.id = s.id_promo_giveaway');
            $this->db->join('tbl_produk prod','prod.id_produk = s.id_produk');
            $this->db->order_by('id_promo_giveaway');
            $query = $this->db->get('tbl_promo_giveaway p');
            return $query->result();
        } else {
            return array();
        }
    }
    
    private function getHadiahByIdPromo($id_promo)
    {
        $this->db->select('p.nama_produk as nama_produk');
        $this->db->select('qty');
        $this->db->select('quota');
        $this->db->select('h.id_produk as id_produk');
        $this->db->where('id_promo_giveaway',$id_promo);
        $this->db->join('tbl_produk p','h.id_produk = p.id_produk');
        $query = $this->db->get('tbl_hadiah_promo_giveaway h');
        return $query->result();
    }
    
    private function getSyaratPembelianByIdPromo($id_promo)
    {
        $this->db->select('p.nama_produk as nama_produk');
        $this->db->select('qty');
        $this->db->select('h.id_produk as id_produk');
        $this->db->where('id_promo_giveaway',$id_promo);
        $this->db->join('tbl_produk p','h.id_produk = p.id_produk');
        $query = $this->db->get('tbl_syarat_pembelian_promo_giveaway h');
        return $query->result();
    }
    
    private function getOrderGiveawayByIdPromoArr($idArr)
    {
        $this->db->select('id_promo_giveaway');
        $this->db->select('id_produk');
        $this->db->select('sum(qty) as qty_order');
        $this->db->where_in('id_promo_giveaway',$idArr);
        $this->db->where('date_added',date("Y-m-d".' 00:00:00'));
        $this->db->where('id_user',$this->session->userdata('member')->id_user);
        $this->db->group_by('id_order_promo');
        $query = $this->db->get('tbl_order_promo_giveaway');
        return $query->result();
    }
    
    private function getProdukDetail($id)
    {
        $sql = "select a.*, d.alamat as alamat_merchant, d.telpon as telpon_merchant, c.nama_kabupaten, b.*, d.nama_store, pf.image
				from tbl_produk a
                left join tbl_user b on a.id_user=b.id_user
                left join tbl_store d on a.id_user=d.id_user
                left join tbl_kecamatan e on d.id_kecamatan=e.id_kecamatan
                left join tbl_kabupaten c on d.id_kabupaten=c.id_kabupaten
                left join tbl_produkfoto pf on a.id_produk = pf.id_produk
				where a.id_produk='" . (int)$id . "'";
        $q = $this->db->query($sql);
        $data = $q->row();
        $q->free_result();
        return $data;
    }
    
    private function getIdPromoByIdProdukSyarat($id_produk)
    {
        $this->db->select('id_promo_giveaway');
        $this->db->select('count(*) as jumlah');
        $this->db->where('id_produk',$id_produk);
        $query = $this->db->get('tbl_syarat_pembelian_promo_giveaway');
        $data =  $query->row();
        if($data->jumlah > 0){
            return $data->id_promo_giveaway;
        } else {
            return null;
        }
    }
    
    private function getGivenAway($cart)
    {
        $id_promo = array();
        foreach($cart as $val){
            if($val['id_promo']!='' && $val['jenis_promo']=='giveaway'){
                $id_promo[] = $val['id_promo'];
            }
        }
        
        return $id_promo;
    }
    
    function cartNextId($cart)
    {
        $id = 0;
        foreach($cart as $val){
            $id = $val['id'];
        }
        $id++;
        return $id;
    }
    
    public function groupByPromo($cart)
    {
        if (!empty($cart)) {
            $pesan = array();
            $id_promo_giveaway = array();
            $id_produk_cart = $this->cartToIdProduct($cart);
            $data = $this->getSyaratGroupByIdPromo($id_produk_cart);
            
            foreach($data as $val) {
                $id_promo_giveaway[] = $val->id_promo_giveaway;
            }
            
            $session_member = $this->session->userdata('member');
            
            $OverQuotaPromo = array();
            
            if(!empty($id_promo_giveaway) && $session_member){
                $quotaCheck = $this->getOrderGiveawayByIdPromoArr($id_promo_giveaway);
                
                foreach($quotaCheck as $quotaCheckData){
                    $Hadiah = $this->getHadiahByIdPromo($quotaCheckData->id_promo_giveaway);
                    foreach($Hadiah as $dataHadiah){
                        if($dataHadiah->quota <= $quotaCheckData->qty_order){
                            $OverQuotaPromo[] = $quotaCheckData->id_promo_giveaway;
                        }
                    }
                }
            }
            
            $syaratFull = $this->getFullSyaratEachPromo($id_promo_giveaway);
            
            $id_promo = '';
            $promo = array();
            foreach($syaratFull as $val) {
                if(!empty($OverQuotaPromo)){
                    foreach($OverQuotaPromo as $idOverQuotaPromo){
                        if($val->id_promo_giveaway!=$idOverQuotaPromo){
                            if($id_promo==$val->id_promo_giveaway){
                                $promo[$id_promo][] = array(
                                    'id_produk' => $val->id_produk,
                                    'nama_produk' => $val->nama_produk,
                                    'qty' => $val->qty,
                                );
                            } else {
                                $promo[$val->id_promo_giveaway][] = array(
                                    'id_produk' => $val->id_produk,
                                    'nama_produk' => $val->nama_produk,
                                    'qty' => $val->qty,
                                );
                            }
                        }
                    }
                } else {
                    foreach($syaratFull as $val) {              
                        if($id_promo==$val->id_promo_giveaway){
                            $promo[$id_promo][] = array(
                                'id_produk' => $val->id_produk,
                                'nama_produk' => $val->nama_produk,
                                'qty' => $val->qty,
                            );
                        } else {
                            $promo[$val->id_promo_giveaway][] = array(
                                'id_produk' => $val->id_produk,
                                'nama_produk' => $val->nama_produk,
                                'qty' => $val->qty,
                            );
                        }
                    }
                }
            }
            return $promo;
        } else {
            return array();
        }
    }
    
    public function cekSuggestion($cart)
    {
        $promo = $this->groupByPromo($cart);
        $pesanArr = array();
        
        foreach($promo as $idPromo => $eachPromo)
        {
            $promoSyaratList = $eachPromo;
            $jumlahSyaratDipenuhi = 0;
            $jumlahSyarat = count($promoSyaratList);
            foreach($promoSyaratList as $dataPromo) {
                foreach($cart as $dataCart) {
                    if((isset($dataCart['id_produk']) and $dataCart['id_produk']==$dataPromo['id_produk']) or !isset($dataCart['id_produk']) and $dataCart['id']==$dataPromo['id_produk']) {
                        if($dataCart['qty']>=$dataPromo['qty']) {
                            $jumlahSyaratDipenuhi++;
                        }
                    }
                }
            }
            
            if($jumlahSyarat > $jumlahSyaratDipenuhi){
                
                $i = 0;
                $pesan = 'Dapatkan gratis ';
                $hadiahArr = $this->getHadiahByIdPromo($idPromo);
                $jumlahHadiah = count($hadiahArr);
                foreach($hadiahArr as $hadiahList)
                {
                    $i++;
                    $pesan .= '<b><a href="'.base_url().'product/detail/'.$hadiahList->id_produk.'/'.$hadiahList->nama_produk.'" style="color:#31708F">'.$hadiahList->nama_produk.'</a></b> sejumlah <b>'.$hadiahList->qty.'</b>';
                    if($i != $jumlahHadiah){
                        $pesan .= ', ';
                    } else {
                        $pesan .= '. ';
                    }
                }
                
                $i = 0;
                $pesan .= 'Dengan membeli ';
                $syarat = $this->getSyaratPembelianByIdPromo($idPromo);
                $jumlahSyarat = count($syarat);
                foreach($syarat as $syaratList)
                {
                    $i++;
                    $pesan .= '<b><a href="'.base_url().'product/detail/'.$syaratList->id_produk.'/'.$syaratList->nama_produk.'" style="color:#31708F">'.$syaratList->nama_produk.'</a></b> sejumlah <b>'.$syaratList->qty.'</b>';
                    if($i != $jumlahSyarat){
                        $pesan .= ', ';
                    } else {
                        $pesan .= '. ';
                    }
                }
                
                $pesanArr[] = $pesan;
                
            }
        }
        
        return $pesanArr;
        
    }
    
    public function getFreeGiveaway($cart)
    {
        $data = array();
        
        $givenAwayItem = $this->getGivenAway($cart);
        
        $promo = $this->groupByPromo($cart);
        
        $idPromoArr = array();
        foreach($promo as $idPromo => $promoSyaratList) {
            $idPromoArr[] = $idPromo;
        }
        
        $PromoToGive = array_diff($idPromoArr,$givenAwayItem);
        
        $i = $this->cartNextId($cart);
        foreach($promo as $idPromo => $promoSyaratList) {
            //foreach($PromoToGive as $idPromoToGive){
                //if($idPromoToGive==$idPromo){
                    $jumlahSyaratDipenuhi = 0;
                    $jumlahSyarat = count($promoSyaratList);
                    foreach($promoSyaratList as $dataPromo) {
                        foreach($cart as $dataCart) {
                            if((isset($dataCart['id_produk']) and $dataCart['id_produk']==$dataPromo['id_produk']) or (!isset($dataCart['id_produk']) and $dataCart['id']==$dataPromo['id_produk'])) {
                                if($dataCart['qty']>=$dataPromo['qty']) {
                                    $jumlahSyaratDipenuhi++;
                                }
                            }
                        }
                    }
                    
                    if($jumlahSyarat == $jumlahSyaratDipenuhi){
                        $hadiah = $this->getHadiahByIdPromo($idPromo);
                        
                        foreach($hadiah as $dataHadiah){
                            $produk=$this->getProdukDetail($dataHadiah->id_produk);
                            $data[]=array(
                                'id'                => $i,
                                'id_produk'         => $produk->id_produk,
                                'id_merchant'       => $produk->id_user,
                                'image'             => $produk->image,
                                'qty'               => $dataHadiah->qty,
                                'name'              => $produk->nama_produk,
                                'price'             => 0,
                                'harga'             => $produk->harga_jual,
                                'harga_merchant'    => $produk->harga_produk,
                                'berat'             => $produk->jne_berat,
                                'berat_produk'      => $produk->berat,
                                'lebar'             => $produk->lebar,
                                'panjang'           => $produk->panjang,
                                'tinggi'            => $produk->tinggi,
                                'stok'              => $dataHadiah->qty,
                                'dimensi'           => $produk->panjang*$produk->lebar*$produk->tinggi,
                                'discount'          => 100,
                                'discount_rp'       => $produk->harga_jual * $dataHadiah->qty,
                                'stock_available'   => $dataHadiah->qty,
                                'jenis_promo'       => 'giveaway',
                                'nama_promo'        => 'giveaway',
                                'id_promo'          => $idPromo,
                                'produk_voucher_elektronik'         => 0,
                                'produk_voucher_elektronik_agent'   => '',
                            );
                            
                        }
                    }
                //}
            //}
            $i++;
        }
        
        return $data;
    }
    
    public function removeFreeGiveaway($cart,$id_produk)
    {
        $removeItem = array();
        $id_promo = $this->getIdPromoByIdProdukSyarat($id_produk);        
        if(!empty($id_promo)){
            foreach($cart as $item){
                if($item['jenis_promo'] == 'giveaway' && $item['id_promo']==$id_promo){
                    $removeItem[] = array('rowid' => $item['rowid'],'qty' => 0);
                }
            }
        } 
        
        return $removeItem;
        /*
        $promo = $this->groupByPromo($cart);
        
        $removeItemArray = array();
        
        foreach($promo as $idPromo => $eachPromo)
        {
            
            $promoSyaratList = $eachPromo;
            $jumlahSyaratDipenuhi = 0;
            $jumlahSyarat = count($promoSyaratList);
            foreach($promoSyaratList as $dataPromo) {
                foreach($cart as $dataCart) {
                    if((isset($dataCart['id_produk']) and $dataCart['id_produk']==$dataPromo['id_produk']) or !isset($dataCart['id_produk']) and $dataCart['id']==$dataPromo['id_produk']) {
                        if($dataCart['qty']>=$dataPromo['qty']) {
                            $jumlahSyaratDipenuhi++;
                        }
                    }
                }
            }
            
            if($jumlahSyarat > $jumlahSyaratDipenuhi){
                $hadiah = $this->getHadiahByIdPromo($idPromo);
                
                foreach($hadiah as $dataHadiah){
                    foreach($cart as $key => $cartData){
                        if($cartData['id_produk'] == $dataHadiah->id_produk and $cartData['jenis_promo'] == 'giveaway'){
                            $item = array('rowid' => $cartData['rowid'],'qty' => 0);
                            $removeItemArray[] = $item;
                        }
                    }
                }
            }
            
        }
        * 
        * return $removeItemArray;
        */
        
        
    }
    
    public function removeFreeGiftOnRemoveItem($cart,$rowid)
    {
        $rowid_target = array();
        
        foreach($cart as $data){
            if($data['rowid'] == $rowid){
                $id_produk = $data['id_produk'];
            }
        }
        
        $id_promo = $this->getIdPromoByIdProdukSyarat($id_produk);
        
        foreach($cart as $data){
            if($data['jenis_promo'] == 'giveaway' and $data['id_promo'] == $id_promo){
                $rowid_target[] = $data['rowid'];
            }
        }
        
        return $rowid_target;
    }
    
    public function isThereGiveAwayItemUpdate($cart,$id_produk)
    {
        $id_promo = $this->getIdPromoByIdProdukSyarat($id_produk);        
        if(!empty($id_promo)){
            return true;
        } else {
            return false;
        }
        
    }

    public function cekOverQuotaGiveaway($cart)
    {
        if (!empty($cart)) {
            $pesan = array();
            $id_promo_giveaway = array();
            $id_produk_cart = $this->cartToIdProduct($cart);
            $data = $this->getSyaratGroupByIdPromo($id_produk_cart);
            
            foreach($data as $val) {
                $id_promo_giveaway[] = $val->id_promo_giveaway;
            }
            
            $session_member = $this->session->userdata('member');
            
            $OverQuotaPromo = array();
            
            if(!empty($id_promo_giveaway) && $session_member){
                $quotaCheck = $this->getOrderGiveawayByIdPromoArr($id_promo_giveaway);
                
                foreach($quotaCheck as $quotaCheckData){
                    $Hadiah = $this->getHadiahByIdPromo($quotaCheckData->id_promo_giveaway);
                    foreach($Hadiah as $dataHadiah){
                        if($dataHadiah->quota <= $quotaCheckData->qty_order){
                            $OverQuotaPromo[] = $quotaCheckData->id_promo_giveaway;
                        }
                    }
                }
            }

            if (!empty($OverQuotaPromo)) {
                $this->db->where_in('g.id_promo_giveaway', $OverQuotaPromo);
                $this->db->join('tbl_produk p','p.id_produk = g.id_produk');
                $query = $this->db->get('tbl_hadiah_promo_giveaway as g');
                $data = $query->result();
                return $data;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
}
