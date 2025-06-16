<?php

namespace Cipika\Common;

class CheckoutTransactionLog
{
    protected $dbLibrary;

    public function __construct($dbLib)
    {
        $this->dbLibrary = $dbLib;
    }

    public function saveLog(
        $kodeInvoice, 
        $idPayment, 
        $cart, 
        $detUser,
        $paramsLog,
        $featureLog
    ) {
        $invoiceLogInsert = array(
            'kode_invoice'      => $kodeInvoice,
            'id_user'           => $detUser->id_user,
            'id_payment'        => $idPayment,
            'total'             => $paramsLog['total'],
            'ongkir'            => $paramsLog['ongkir'],
            'voucher'           => $paramsLog['voucher'],
            'potongan_voucher'  => $paramsLog['potongan_voucher'],
            'date_added'        => date('Y-m-d H:i:s'),
            'insert_from'       => 'mobile',
        );
        $insertInvoiceLog = $this->dbLibrary->insert('tbl_invoices_log', $invoiceLogInsert);
        if ($insertInvoiceLog) {
            foreach ($cart as $k => $v) {
                $key = strtoupper(substr($detUser->email, 0, 3)) . date('ymd');
                $kodeOrder = $this->_get_new_id_order($key);
                $orderLogInsert = array(
                    'id_order_log'          => null,
                    'kode_order'            => $kodeOrder,
                    'total'                 => $v['store']['total_harga_produk'],
                    'total_merchant'        => $v['store']['total_harga_produk_merchant'],
                    'kode_invoice'          => $kodeInvoice,
                    'diskon'                => $v['store']['total_diskon_produk'],
                    'sebelum_diskon'        => $v['store']['total_harga_produk_asli'],
                    'id_user'               => $detUser->id_user,
                    'id_merchant'           => $k,
                    'id_payment'            => $idPayment,
                    'id_ongkir'             => null,
                    'sales'                 => $v['store']['nama_sales'],
                    'nama_merchant'         => $v['store']['nama_store'],
                    'ongkir_sementara'      => $v['shipping']['ongkos_kirim'],
                    'original_shipping_fee' => $v['shipping']['ongkos_kirim_asli'],
                    'ongkir_total_original' => $v['shipping']['ongkos_kirim_markup'],
                    'shipping_vendor'       => 'JNE',
                    'paket_ongkir'          => $v['shipping']['paket_kirim'],
                    'voucher'               => $paramsLog['voucher'],
                    'potongan_voucher'      => $paramsLog['potongan_voucher'],
                    'status_payment'        => 'waiting',
                    'status_delivery'       => 'waiting',
                    'view_notif'            => 'N',
                    'date_added'            => date('Y-m-d H:i:s'),
                );
                $insertOrderLog = $this->dbLibrary->insert('tbl_order_log', $orderLogInsert);

                if ($insertOrderLog) {
                    $addressShippingLog = array(
                        'id_orderShipping_log' => null,
                        'id_order_log'          => $insertOrderLog,
                        'nama'                  => $v['shipping']['nama'],
                        'alamat'                => $v['shipping']['alamat'],
                        'telpon'                => $v['shipping']['hp'],
                        'email'                 => $v['shipping']['email'],
                        'id_provinsi'           => $v['shipping']['id_propinsi'],
                        'id_kota'               => $v['shipping']['id_kota'],
                        'id_kecamatan'          => $v['shipping']['id_kecamatan'],
                        'origin_propinsi'       => $v['store']['nama_propinsi'],
                        'origin_kabupaten'      => $v['store']['nama_kota'],
                        'origin_kecamatan'      => $v['store']['nama_kecamatan'],
                        'destination_propinsi'  => $v['shipping']['propinsi'],
                        'destination_kabupaten' => $v['shipping']['kota'],
                        'destination_kecamatan' => $v['shipping']['kecamatan'],
                        'date_added'            => date('Y-m-d H:i:s'),
                    );
                    $insertOrderShippingLog = $this->dbLibrary->insert('tbl_ordershipping_log', $addressShippingLog);

                    foreach ($v['items'] as $iK => $items) {
                        $diskon_rp = $items['harga_produk_asli'] * $items['diskon_produk'] / 100;
                        $orderItemInsertLog = array(
                            'id_orderItem_log'                  => null,
                            'id_order_log'                      => $insertOrderLog,
                            'id_produk'                         => $items['id_produk'],
                            'nama_produk'                       => $items['nama_produk'],
                            'jne_berat'                         => $items['jne_berat'],
                            'harga'                             => $items['harga_produk'],
                            'harga_merchant'                    => $items['harga_produk_merchant'],
                            'diskon'                            => $items['diskon_produk'],
                            'diskon_rp'                         => $diskon_rp,
                            'jml_produk'                        => $items['jumlah_produk'],
                            'kategori'                          => $items['kategori'],
                            'berat'                             => $items['berat'],
                            'panjang'                           => $items['panjang'],
                            'lebar'                             => $items['lebar'],
                            'tinggi'                            => $items['tinggi'],
                            'detail_paket'                      => $items['detail_paket'],
                            'blended_transaction_fee'           => $items['blended_transaction_fee'],
                            'blended_insentif_cipika'           => $items['blended_insentif_cipika'],
                            'blended_shipping_fee_to_jakarta'   => $items['blended_shipping_fee_to_jakarta'],
                            'selisih_pembulatan'                => $items['selisih_pembulatan'],
                            'total'                             => $items['total_harga_produk'],
                            'date_added'                        => date('Y-m-d H:i:s')
                        );

                        $insertOrderItemLog = $this->dbLibrary->insert('tbl_orderitem_log', $orderItemInsertLog);
                    }
                }
            }
            return $insertInvoiceLog;
        } else {
            return false; 
        }
    }

    function _get_new_id_order($key = '')
    {
        $index = 1; 
        $length = strlen($key);
           
        $sql = "select count(*) as jumlah from tbl_order where ".
               "(select left(kode_order, $length))='" . 
                $this->dbLibrary->escape_str($key) . "'";
        $query = $this->dbLibrary->query($sql);
        $data = $query->row();
        $query->free_result();

        $id_news = (int) $data->jumlah;
        $id_news += $index;
        $id_news = 10000 + $id_news;
        $kode_order = strtoupper($key . '-' . substr($id_news, 1, 4));
        return $kode_order;
    }

}
