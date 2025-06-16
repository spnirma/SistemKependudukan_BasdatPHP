<?php

namespace Cipika\Common;

class CheckoutPaymentLib
{
    protected $dbLibrary;
    protected $config;
    protected $libRest;

    public function __construct($dbLib, $config, $lib_rest)
    {
        $this->dbLibrary = $dbLib;
        $this->config = $config;
        $this->lib_rest = $lib_rest;
    }
    
    public function selectPayment($idPayment, $params)
    {
         switch ($idPayment) {
            case 1:
                $url = 'merchant_id=' . USER_ID_PAYMENT_TRANFER;
                $url.='&transaction_id=' . $params['kode_invoice'];
                $url.='&amount=' . $params['total_bayar'];
                $url.='&cust_email=' . $params['email'];
                $url.='&adm_email=' . ADMIN_EMAIL;
                $url.='&key=' . SECRET_ID_PAYMENT_TRANFER;

                $url = base_url('api/banktranfer/get_payment_tranfer?'. $url);
                
                $pay = $this->lib_rest->rest_get($url);

                $respond = json_decode($pay);

                if (!empty($respond)) {
                    if ($respond->result == 1000) {
                        return (object) array(
                            'status' => 1
                        );
                    } else {
                        return (object) array(
                            'status' => 0, 
                            'error' => 'Terjadi Kesalahan Pada pembayaran Bank Transfer Permata.'
                        );
                    }
                } else {
                    return (object) array(
                        'status' => 0, 
                        'error' => 'Terjadi Kesalahan Pada Sistem Pembayaran Bank Transfer Permata.'
                    );
                }
                break;
            case 5:
                $url = 'amount=' . $params['total_bayar'];
                $url.='&trans_id=' . $params['kode_invoice'];
                $url.='&coupon_id=' . $params['token_user'];
                $url.='&msisdn=' . $params['phone_user'];

                $url = base_url('api/dompetku/post_transfer?' . $url);

                $pay = $this->lib_rest->rest_get($url);

                $respond = json_decode($pay);

                if (isset($respond->status) && $respond->status === 0) {
                    if ($respond->code == 1001) {
                        return (object) array(
                            'status' => 0, 
                            'error' => 'Saldo Anda tidak mencukupi.'
                        );
                    } elseif ($respond->code == 542) {
                        return (object) array(
                            'status' => 0, 
                            'error' => 'Token Anda salah'
                        );
                    } elseif ($respond->code == 1007) {
                        return (object) array(
                            'status' => 0, 
                            'error' => 'Kode Transaksi Anda salah'
                        );
                    } else {
                        return (object) array(
                            'status' => 0, 
                            'error' => 'Telah Terjadi kesalahan pada Pembayaran DompetKu.', 
                            'code' => $respond->status
                        );
                    }
                } elseif (isset($respond->status) && $respond->status === 1) {
                    return (object) array(
                        'status' => 1
                    );
                } else {
                    return (object) array(
                        'status' => 0, 
                        'error' => 'Telah Terjadi kesalahan pada API DompetKu'
                    );
                }
                break;
            case 6:
                $url = 'amount=' . $params['total_bayar'];
                $url.='&trans_id=' . $params['kode_invoice'];
                $url.='&token=' . $params['token_mandiri_user'];
                $url.='&card_no=' . $params['card_number_mandiri_user'];
                $url.='&price=' . $params['total_produk'];
                $url.='&shipping=' . $params['total_ongkir'];
                $url.='&input3=' . $params['unix_number_mandiri_user'];

                $url = base_url('api/mandiriclickpay/post_transfer?'.$url);
                
                $pay = $this->lib_rest->rest_get($url);

                $respond = json_decode($pay);

                if (isset($respond->status) && $respond->out == 1) {
                    if ((int) $respond->status === 0000) {
                        return (object) array(
                            'status' => 1
                        );
                    } else {
                        return (object) array(
                            'status' => 0, 
                            'error' => $respond->respond
                        );
                    }
                } else {
                    return (object) array(
                        'status' => 0, 
                        'error' => "Telah Terjadi kesalahan pada Pembayaran Mandiri ClickPay."
                    );
                }
                break;
            case 7:
                $dataParamVeritrans = array(
                    'amount'    => $params['total_bayar'],
                    'trans_id'  => $params['kode_invoice'],
                    'voucher'   => (int) $params['nominal_voucher'],
                    'user'      => base64_encode(serialize($params['user'])),
                    'item'      => base64_encode(serialize($params['cart'])),
                    'ongkir'    => base64_encode(serialize($params['ongkir'])),
                    'shipping'  => base64_encode(serialize($params['shipping']))
                );
                $pay = $this->lib_rest->rest_post(base_url('api/kartukredit/send_post_transfer?'), $dataParamVeritrans);

                $res = json_decode($pay);

                if (is_object($res)) {
                    if ($res->status != 0)
                    {
                        return (object) array(
                            'status' => 1,
                            'url' => $res->url
                        );
                    }
                    else
                    {
                        return (object) array(
                            'status' => 0,
                            'error' => $res->error
                        );
                    }
                } else {
                    return (object) array(
                        'status' => 0,
                        'error' => "Telah Terjadi kesalahan pada Pembayaran Kartu Kredit."
                    );
                }
                break;
            case 8:
                $url = 'amount=' . $params['total_produk'];
                $url.='&trans_id=' . $params['kode_invoice'];
                $url.='&ongkir=' . $params['total_ongkir'];

                $url = base_url('api/bcaklikpay/post_transfer?' . $url);

                $pay = $this->lib_rest->rest_get($url);

                return json_decode($pay);
                break;
            case 9:
                $inputan = array(
                    'kode_order'    => $params['kode_invoice'],
                    'payment'       => 'BANKTRANSFERMANDIRI',
                    'amount'        => $params['total_bayar'],
                    'created'       => date('Y-m-d H:i:s'),
                );
                $insert_payment = $this->dbLibrary->insert('tbl_payment_buyers', $inputan);
                if ($insert_payment) {
                    return (object) array(
                        'status' => 1
                    );
                } else {
                    return (object) array(
                        'status' => 0, 
                        'error' => "Telah Terjadi kesalahan pada Pembayaran Bank Transfer Mandiri."
                    );
                }
                break;
            case 10:
                $inputan = array(
                    'kode_order'    => $params['kode_invoice'],
                    'payment'       => 'BANKTRANSFERBCA',
                    'amount'        => $params['total_bayar'],
                    'created'       => date('Y-m-d H:i:s'),
                );
                $insert_payment = $this->dbLibrary->insert('tbl_payment_buyers', $inputan);
                if ($insert_payment) {
                    return (object) array(
                        'status' => 1
                    );
                } else {
                    return (object) array(
                        'status' => 0, 
                        'error' => "Telah Terjadi kesalahan pada Pembayaran Bank Transfer BCA."
                    );
                }
            case 11:
                $inputan = array(
                    'kode_order'    => $params['kode_invoice'],
                    'payment'       => 'VOUCHERCOMPLIMENT',
                    'amount'        => $params['total_bayar'],
                    'created'       => date('Y-m-d H:i:s'),
                );
                $insert_payment = $this->dbLibrary->insert('tbl_payment_buyers', $inputan);
                if ($insert_payment) {
                    return (object) array(
                        'status' => 1
                    );
                } else {
                    return (object) array(
                        'status' => 0, 
                        'error' => "Telah Terjadi kesalahan pada Pembayaran Voucher."
                    );
                }
                break;
            case 12:
                if ($params['siteId'] == null) {
                    return (object) array(
                        'status'    => 0,
                        'error'     => "Mohon maaf, Pembayaran BCA Kartu Kredit " .
                                       "hanya untuk produk Cicilan"
                    );
                }

                $inputan = array(
                    'kode_order'    => $params['kode_invoice'],
                    'payment'       => 'BCAKARTUKREDIT',
                    'amount'        => $params['total_bayar'],
                    'created'       => date('Y-m-d H:i:s'),
                );

                $insertPayment = $this->dbLibrary->insert(
                    'tbl_payment_buyers',
                    $inputan
                );
                $insertPayment = true;
                if ($insertPayment) {
                    return (object) array(
                        'status'    => 1,
                        'url'       => BCA_KARTU_KREDIT_URL,
                        'amount'    => $params['total_bayar'],
                        'data'      => (object) $params
                    );
                } else {
                    return (object) array(
                        'status'    => 0,
                        'error'     => 'Maaf, sedang ada maintenance pada Payment BCA Credit Card'
                    );
                }
                break;
            case 13:
                return (object) array('status' => 0, 'error' => 'Maaf, sedang ada maintenance pada Payment DompetKu');
                break;
            case 14:
                return (object) array('status' => 0, 'error' => 'Maaf, sedang ada maintenance pada Payment Ipaymu');
                break;
            case 17:
                $dataParamMandiriVeritrans = array(
                    'trans_id'          => $params['kode_invoice'],
                    'amount'                => $params['total_bayar'],
                    'voucher'               => (int) $params['nominal_voucher'],
                    'periode'               => $params['periode'],
                    'mdr_fee'               => $params['mdr_fee'],
                    'point'                 => 0,
                    'user'                  => base64_encode(serialize($params['user'])),
                    'item'                  => base64_encode(serialize($params['cart'])),
                    'ongkir'                => base64_encode(serialize($params['ongkir'])),
                    'shipping'              => base64_encode(serialize($params['shipping']))
                );
                $pay = $this->lib_rest->rest_post(
                    base_url('api/mandirikartukredit/send_post_transfer'),
                    $dataParamMandiriVeritrans
                );

                $res = json_decode($pay);

                if (is_object($res)) {
                    if ($res->status !== 0)
                    {
                        return (object) array(
                            'status' => 1,
                            'url' => $res->url
                        );
                    }
                    else
                    {
                        return (object) array(
                            'status' => 0,
                            'error' => $res->error
                        );
                    }
                } else {
                    return (object) array(
                        'status' => 0,
                        'error' => "Telah Terjadi kesalahan pada Pembayaran Mandiri Veritrans"
                    );
                }
                break;
            case 19:
                $dataParamVeritrans = array(
                    'kode_invoice'          => $params['kode_invoice'],
                    'amount'                => $params['total_bayar'],
                    'voucher'               => (int) $params['nominal_voucher'],
                    'point'                 => 0,
                    'detail_user'           => base64_encode(serialize($params['user'])),
                    'cart_item'             => base64_encode(serialize($params['cart'])),
                    'detail_shipping_fee'   => base64_encode(serialize($params['ongkir'])),
                    'detail_shipping'       => base64_encode(serialize($params['shipping']))
                );
                $pay = $this->lib_rest->rest_post(
                    base_url('api/permata/send_post_transfer?'),
                    $dataParamVeritrans
                );

                $res = json_decode($pay);

                if (is_object($res)) {
                    if ($res->status_code !== 0)
                    {
                        return (object) array(
                            'status' => 1,
                            'url' => $res->url
                        );
                    }
                    else
                    {
                        return (object) array(
                            'status' => 0,
                            'error' => $res->status_message
                        );
                    }
                } else {
                    return (object) array(
                        'status' => 0,
                        'error' => "Telah Terjadi kesalahan pada Pembayaran Permata Veritrans"
                    );
                }
                break;
            default:
                break;

        }
    }
}
