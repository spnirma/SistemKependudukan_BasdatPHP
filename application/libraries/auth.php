<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of template
 *
 * @author Afandi
 */
class auth {
    protected $_ci;
    function  __construct() {
        $this->_ci=&get_instance();
    }

    public function check() {

        if (!$this->_ci->session->userdata('admin_session')) {
            redirect(admin_url().('user/login'));
        }
    }
    
    public function cek_hak_akses($resource = null){
        
        if ($resource === null) {
            $resource = $this->_ci->uri->segment(2, 'dashboard');
        }
        $user = $this->_ci->session->userdata('admin_session');
        
        if (! $this->isAllowed($user, $resource)) {
            redirect(admin_url());
        }
    }
    
    public function isAllowed($user, $resource)
    {
        if($user->id_level == 3){
            $hak_akses = array('dashboard',
                'neworder_index',
                'merchant',
                'merchant_request',
                'merchant_verified',
                'merchant_unverified',
                'merchant_export',
                'agregator',
                'user_agregator',
                'member',
                'member_index',
                'produk',
                'produk_request_verifikasi',
                'produk_verified',
                'produk_unverified',
                'produk_merchant_unverified',
                'produk_request_update',
                'produk_export',
                'po_indoloka',
                'neworder',
                'neworder_export',
                'order_detail_invoice',
                'order_edit_shipping',
                'order_commercial_aggrement',
                'status_indoloka_full',
                'user_profile',
                'user_setting',
                'feedback',
                'feedback_index',
                'settlement',
                'settlement_to_request',
                'settlement_request',
                'settlement_progress',
                'settlement_hold',
                'settlement_reject',
                'settlement_paid',
                'settlement_detail',
                'report_settlement',
                'settlement_detail',
                'kategori_index',
                'peserta',
                
                );
            
            if (array_search($resource, $hak_akses) !== false) {
                return true;
            }
            
            return false;
        }elseif($user->id_level == 2){
            $hak_akses = array('dashboard',
                'kategori_index',
                'article',
                'article_index',
                'article_add',
                'article_edit',
                'article_delete',
                'banner',
                'banner_index',
                'banner_add',
                'banner_setting',
                'banner_edit',
                'banner_delete',
                'diskon',
                'diskon_index',
                'diskon_add',
                'diskon_edit',
                'diskon_update',
                'diskon_delete',
                'diskon_import',
                'voucher_readExcel',
                'diskon_delete_program',
                'diskon_edit_program',
                'giveaway_index',
                'giveaway_detail',
                'giveaway_add',
                'giveaway_edit',
                'giveaway_delete',
                'giveaway_tambah_syarat_pembelian',
                'giveaway_tambah_hadiah',
                'giveaway_detail_syarat_pembelian',
                'giveaway_detail_hadiah',
                'giveaway_delete_program',
                'feedback',
                'feedback_index',
                'feedback_edit',
                'freeshipping',
                'freeshipping_index',
                'freeshipping_add',
                'freeshipping_edit',
                'freeshipping_delete',
                'contact_form',
                'contact_form_index',
                'contact_form_delete',
                'import',
                'import_index',
                'import_sales',
                'import_merchant',
                'import_product',
                'import_import_sales',
                'import_import_merchant',
                'import_import_product',
                'member',
                'member_index',
                'member_hapus',
                'member_export',
                'user_add_member',
                'user_edit_member',
                'merchant',
                'user_add_merchant',
                'merchant_request',
                'merchant_verified',
                'merchant_unverified',
                'merchant_act_verified',
                'merchant_act_unverified',
                'merchat_act_unverified',
                'merchant_act_moderasi',
                'merchant_hapus_merchant',
                'merchant_export',
                'user_edit_merchant',
                'agregator',
                'user_agregator',
                'user_add_agregator',
                'user_edit_agregator',
                'user_delete_agregator',
                'neworder',
                'neworder_index',
                'neworder_detail_order',
                'po_indoloka',
                'ongkir',
                'ongkir_index',
                'ongkir_add',
                'ongkir_edit',
                'ongkir_delete',
                'order_index',
                'order_detail',
                'order_edit',
                'order_delete',
                'order_detail_payment',
                'order_detail_delivery',
                'order_detail_invoice',
                'order_edit_shipping',
                'order_commercial_aggrement',
                'status_indoloka_full',
                'neworder_export',
                'page',
                'page_index',
                'page_add',
                'page_edit',
                'page_delete',
                'produk',
                'produk_index',
                'produk_add',
                'produk_add_variant',
                'produk_edit',
                'produk_edit_variant',
                'produk_request_update',
                'produk_request_verifikasi',
                'produk_verified',
                'produk_unverified',
                'produk_merchant_unverified',
                'produk_act_verified',
                'produk_act_unverified',
                'produk_update_jne_berat',
                'produk_changeStatus',
                'produk_update_request',
                'produk_setting',
                'produk_export',
                'produk_request_update_detail',
                'produk_verified_detail',
                'produk_edit',
                'settlement',
                'settlement_to_request',
                'settlement_readytoReq',
                'settlement_requestSettlement',
                'settlement_holdSettlementtoReq',
                'settlement_rejectSettlementtoReq',
                'settlement_requestSettlementHold',
                'settlement_request',
                'settlement_processSettlement',
                'settlement_progress',
                'settlement_progress_simpan',
                'settlement_ready',
                'settlement_sready',
                'settlement_processSettlement',
                'settlement_hold',
                'settlement_rejectSettlement',
                'settlement_reject',
                'settlement_paidSettlement',
                'settlement_paid',
                'settlement_detail',
                'settlement_textExportBCA',
                'settlement_textExportOther',
                'settlement_excel',
                'settlement_excelPaid',
                'settlement_export',
                'settlement_export_bank',
                'settlement_requestSettlementAll',
                'ready_to_request_request_action',
                'settlement_request_proceed',
                'settlement_readytoReq',
                'settlement_progress_simpan',
                'report_settlement',
                'voucher',
                'voucher_index',
                'voucher_detailsingle',
                'voucher_jenisvoucher',
                'voucher_field_jumlah_variable',
                'voucher_detail',
                'voucher_readExcel',
                'voucher_smsblast_index',
                'voucher_smsblast_detail',
                'voucher_email_blast_new_index',
                'voucher_email_blast_new_detail_batch',
                'voucher_email_blast_new_detail_voucher',
                'voucher_email_blast_existing_index',
                'voucher_email_blast_existing_detail_batch',
                'voucher_email_blast_existing_detail_voucher',
                'voucher_smsblast_search_template_wording',
                'voucher_add',
                'voucher_del',
                'voucher_delete',
                'voucher_edit',
                'voucher_import',
                'voucher_readExcel',
                'voucher_smsblast_blast_all',
                'voucher_smsblast_send_sms_voucher',
                'voucher_smsblast_send_sms_voucher_by_batch',
                'voucher_smsblast_kirim_terpilih',
                'voucher_email_blast_new_add',
                'voucher_email_blast_new_edit',
                'voucher_email_blast_existing_import',
                'voucher_email_blast_existing_edit',
                'voucher_email_blast_existing_send_single_mail',
                'voucher_email_blast_existing_send_mail_blast_by_batch',
                'voucher_email_blast_existing_kirim_terpilih',
                'newsletter_index',
                'newsletter_add',
                'newsletter_recipient',
                'newsletter_edit',
                'newsletter_delete',
                'newsletter_recipient_add',
                'newsletter_recipient_edit',
                'newsletter_recipient_delete',
                'newsletter_single_send',
                'newsletter_batch_send',
                'user_admin',
                'user_merchant',
                'user_member',
                'user_profile',
                'payment',
                'payment_index',
                'payment_all_payment',
                'payment_konfirmasi',
                'konfirm_pembayaran_export',
                'kategori_index',
                'kategori_add',
                'kategori_edit',
                'kategori_hapus',
                'kategori_delete',
                'kategori_pindah_produk_n_hapus',
                'kategori_pindah_child_n_hapus',
                'kategori_pindah_parent_n_hapus',
                'kategori_hide',
                'kategori_show',
                'kategori_add_brands',
                'doorprize_index',
                'inbox_new_message',
                'inbox_list_message',
                'inbox_save_message',
                'inbox_delete_message',
                'inbox_reply_message',
                'inbox_close_message',
                'inbox_action_form',
                'doorprize_edit_hadiah',
                'doorprize_hapus_hadiah',
                'newsletter_index',
                'newsletter_create_new_blast',
                'newsletter_create_new',
                'newsletter_edit',
                'ppob_form',
                'user_admin',
                'user_add',
                'user',
                'homepage_management',
                'mobo',
            );
            
            if (array_search($resource, $hak_akses) !== false) {
                return true;
            }
            
            return false;
        }elseif($user->id_level == 4){
            $hak_akses = array('dashboard',
                'member',
                'member_index',
                'member_export',
                'merchant',
                'merchant_request',
                'merchant_verified',
                'merchant_unverified',
                'agregator',
                'user_agregator',
                'neworder',
                'neworder_index',
                'neworder_export',
                'order_index',
                'order_detail',
                'order_detail_payment',
                'order_detail_delivery',
                'order_detail_invoice',
                'order_edit_shipping',
                'order_edit_payment',
                'order_commercial_aggrement',
                'status_indoloka_full',
                'po_indoloka',
                'produk',
                'produk_index',
                'produk_verified',
                'produk_request_verifikasi',
                'produk_request_update',
                'produk_unverified',
                'produk_merchant_unverified',
                'produk_export',
                'settlement',
                'settlement_to_request',
                'settlement_readytoReq',
                'settlement_requestSettlement',
                'settlement_holdSettlementtoReq',
                'settlement_rejectSettlementtoReq',
                'settlement_requestSettlementHold',
                'settlement_request',
                'settlement_processSettlement',
                'settlement_progress',
                'settlement_progress_simpan',
                'settlement_ready',
                'settlement_sready',
                'settlement_processSettlement',
                'settlement_hold',
                'settlement_rejectSettlement',
                'settlement_reject',
                'settlement_paidSettlement',
                'settlement_paid',
                'settlement_detail',
                'settlement_textExportBCA',
                'settlement_textExportOther',
                'settlement_excel',
                'settlement_excelPaid',
                'settlement_export',
                'settlement_export_bank',
                'settlement_requestSettlementAll',
                'ready_to_request_request_action',
                'settlement_request_proceed',
                'settlement_readytoReq',
                'settlement_progress_simpan',
                'report_settlement',
                'payment_konfirmasi',
                'payment',
                'payment_index',
                'payment_all_payment',
                'payment_konfirmasi',
                'konfirm_pembayaran',
                'konfirm_pembayaran_export',
                'report',
                'report_transaction_bruto',
                'report_transaction',
                'report_revenue_nett',
                'report_price_comparison',
                'report_merchant_status',
                'report_product',
                'report_revenue',
                'report_payment',
                'report_widthdraw',
                'report_export',
                'report_settlement',
                'feedback',
                'feedback_index',
                );
            
            if (array_search($resource, $hak_akses) !== false) {
                return true;
            }
            
            return false;
        }elseif($user->id_level == 5){ //CS
            $hak_akses = array('dashboard',
                'contact_form',
                'contact_form_index',
                'contact_form_edit',
                'contact_form_delete',
                'contact_form_export',
                'member',
                'member_index',
                'merchant',
                'merchant_request',
                'merchant_verified',
                'merchant_unverified',
                'agregator',
                'user_agregator',
                'neworder',
                'neworder_index',
                'order_index',
                'order_detail',
                'order_detail_payment',
                'order_detail_delivery',
                'order_detail_invoice',
                'status_indoloka_full',
                'produk',
                'produk_index',
                'produk_verified',
                'produk_request_verifikasi',
                'produk_request_update',
                'produk_unverified',
                'produk_merchant_unverified',
                'settlement',
                'settlement_to_request',
                'settlement_request',
                'settlement_progress',
                'settlement_hold',
                'settlement_reject',
                'settlement_paid',
                'settlement_detail',
                'contact_form_delete',
                'feedback',
                'feedback_index',
                'payment_konfirmasi',
                'inbox_new_message',
                'inbox_list_message',
                'inbox_save_message',
                'inbox_reply_message',
                'inbox_close_message',
                'inbox_action_form'
            );
            if (array_search($resource, $hak_akses) !== false) {
                return true;
            }
            
            return false;
        }elseif($user->id_level == 8){
            $hak_akses = array('dashboard',
                'merchant',
                'merchant_request',
                'merchant_verified',
                'merchant_unverified',
                'merchant_agregator',
                'merchant_add_merchant_agregator',
                'merchant_act_moderasi',
                'merchant_act_unverified',
                'merchat_act_unverified',
                'user_edit_merchant',
                'user_add_merchant',
                'user_agregator',
                'user_add_agregator',
                'user_edit_agregator',
                'user_delete_agregator',
                'neworder',
                'neworder_index',
                'neworder_detail_order',
                'order_index',
                'order_detail',
                'order_edit',
                'order_delete',
                'order_detail_payment',
                'order_detail_delivery',
                'order_detail_invoice',
                'order_edit_shipping',
                'produk',
                'produk_index',
                'produk_add',
                'produk_add_variant',
                'produk_edit',
                'produk_edit_variant',
                'produk_request_verifikasi',
                'produk_act_verified',
                'produk_verified',
                'produk_unverified',
                'produk_merchant_unverified',
                'produk_setting',
                'produk_verified_detail',
                'po_indoloka',
                'settlement',
                'settlement_to_request',
                'settlement_readytoReq',
                'settlement_requestSettlement',
                'settlement_requestSettlementAll',
                'user_profile',
                'user_setting'
                );
            
            if (array_search($resource, $hak_akses) !== false) {
                return true;
            }
            
            return false;
            
        } elseif ($user->id_level == 9) {
            
            $hak_akses = array(
                'dashboard',
                'matrix',
                'matrix_cs202_index',
                'matrix_cs202_lihat_formulir',
                'matrix_cs202_alamat_lengkap',
                'matrix_cs202_dokumen',
                'matrix_cs202_edit',
            );
            
            if (array_search($resource, $hak_akses) !== false) {
                return true;
            }
            
        } else {
            return true;
        }
        
    }

    public function save($_param) {
        $this->_ci->session->set_userdata('admin_session', $_param);
    }

    public function destroy() {

       $this->_ci->session->unset_userdata('admin_session');
       redirect(admin_url() . "user/login");
    }
}
?>
