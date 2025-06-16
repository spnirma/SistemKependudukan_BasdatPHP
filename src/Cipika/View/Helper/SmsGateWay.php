<?php

namespace Cipika\View\Helper;

class SmsGateWay {

    protected $dbLibrary;
    protected $msisdn;

    /**
     * 
     * @param Object Database , String Handphone Number
     * @output 
     */
    public function __construct($dbLibrary, $msisdn)
    {
        $this->dbLibrary = $dbLibrary;
        $this->msisdn = $msisdn;
    }

    /**
     * 1. Member Sukses Bayar
     * @param String Kode Invoice
     * @output Id Insert Tabel sms_gateway Integer 
     */
    public function sendReminderOrderIndomaret($kodeInvoice, $kodeBayar, $amount, $time, $smsPersib='')
    {
        $timeOut = explode(" ", $time);
        $tanggal = $timeOut[0];
        $jam = $timeOut[1];

        $message = "Anda melakukan pembelian ";
        if ($smsPersib=='yes') {
            $message .= " Keanggotaan PERSIB ";
        }
        $message .= "dgn No Inv ".$kodeInvoice.". Lakukan pembayaran melalui Indomaret dgn menyebutkan CIPIKA dan kode bayar ".$kodeBayar." sebesar Rp ".number_format($amount, 0, ".", ",")." sblm pkl " . trim($jam) . " (".$tanggal.")";
        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }

     public function sendSuccessPaymentBuyer($kodeInvoice, $amountSms, $amountSmsMobo, $amountSmsPointSenyum)
    {
        //143 character    
        $message = "Member Yth, terima kasih telah menyelesaikan transaksi dgn No Inv ".$kodeInvoice.". ".
                "Pembayaran sebesar Rp ".number_format($amountSms, 0, ".", ",")." telah kami terima dengan sukses.";
        if ((int)$amountSmsMobo>0) {
            $message = "Yth outlet Indosat, transaksi pembelian produk dgn No Inv ".$kodeInvoice."";
            $message .= " menggunakan KOIN Saldo MOBO sebesar ".number_format($amountSmsMobo, 0, ".", ",")."";
            $message .= " berhasil diproses.";
        }
        if ((int)$amountSmsPointSenyum>=0) {
            /*
            $message = "Member Yth, transaksi dgn No Inv ".$kodeInvoice." ".
                    "pembayaran Rp ".number_format($amountSms, 0, ".", ",")."";
            $message .= " dan POIN SENYUM ".number_format($amountSmsPointSenyum, 0, ".", ",")."";
            $message .= " telah kami proses dgn sukses.";
            */
        }

        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendSuccessPaymentBuyerMoboUmb($tgl_redeem,$amountKoin,$amountRp)
    { // proses sms after merchant accept

    $message = "Yth outlet Indosat, redeem Saldo MOBO sebesar ".number_format($amountSmsMobo, 0, ".", ",")." KOIN pada tanggal ".$tgl_redeem." sedang dalam proses pengiriman.";
        $message .= " Informasi CIPIKA-MOBO via email e-care.store@cipika.co.id";

        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }    
    
    /**
     * 2. Send PO Merchant
     * @param string Kode Invoice, Object User
     * @output Id Insert Tabel sms_gateway Integer 
     */
    public function sendPoMerchant($kodeInvoice, $detUser)
    {
        //160 pas, character asal nama maksimal 54 character
        $message = "Dear merchant, Anda mendapatkan order dari ".$detUser->firstname." ".$detUser->lastname." dengan kode pesanan : " . $kodeInvoice . " di Cipika Store. Terima kasih.";
        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }
    
    /**
     * 3. 
     * @param string Kode Invoice, String Order Time, String Name Payment
     * @output Id Insert Tabel sms_gateway Integer 
     */
    public function sendReminderUser($kodeInvoice, $orderTime, $payment, $vanid)
    {
        $tanggal = explode(" ", $orderTime);
        $hari = $this->konversi_tanggal("D", $tanggal[0]);
        $tanggalOut = $this->konversi_tanggal("j-m-Y", $tanggal[0]);
        //lebih dari 160 
        //Dear member, mohon lakukan pembayaran dengan Kode Pemesanan : 151112-01063 sebelum hari Minggu tanggal 20-12-2012 pukul 01:12 dengan metode pembayaran BANK PERMATA ke Nomor Rekening (VAN ID) : 88778 140715 00036
        $message = "Dear member, mohon lakukan pembayaran dengan Kode Pemesanan : ".$kodeInvoice." sebelum hari ".$hari." tanggal ".$tanggalOut." pukul ".$tanggal[1]." dengan metode pembayaran " . $payment. " ke Nomor Rekening (VAN ID) : ".str_replace(" ", "", $vanid);
        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }

    /**
     * 4. Reminder Buyer for Buy with Payment Bank Tranfer
     * @param string Kode Invoice, String VAN ID, Int Total Bayar
     * @output Id Insert Tabel sms_gateway Integer 
     */
    public function sendReminderOrderBankTransfer($kodeInvoice, $vanId, $amount, $time)
    {
        $timeOut = explode(" ", $time);
        $tanggal = $timeOut[0];
        $jam = $timeOut[1];
        // under 160 char
        //Anda telah melakukan pembelian dgn No Inv 151112-01063. Mohon transfer ke VAN ID 88778 140715 00036 sebesar Rp 99,999,999 sblm pkl 12:12 (12-12-2016)
        $message = "Anda telah melakukan pembelian dgn No Inv " .
                   $kodeInvoice . ". " . "Mohon transfer ke VAN ID " .
                   $vanId . " sebesar Rp " . number_format($amount, 0, ".", ",") .
                   " sblm pkl " . trim($jam) . " (".$tanggal.")";

        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }
    
    /**
     * 5. Reminder Buyer for Buy with Payment Bank Tranfer Non Permata
     * @param string Kode Invoice, String VAN ID, Int Total Bayar
     * @output Id Insert Tabel sms_gateway Integer 
     */
    public function sendReminderOrderBankTransferNonPermata($kodeInvoice, $noRek, $jenisBank, $accountBank, $amount, $time, $smsPersib='')
    {
        $timeOut = explode(" ", $time);
        $tanggal = $timeOut[0];
        $jam = $timeOut[1];
        // under 160 char
        // Inv Anda 151112-01063. Transfer Rp 99,999,999 ke PERMATA. No Rek :  123456789123 a/n PT. Indosat Tbk sblm pkl 12:12 (12-12-2016)
        $message = "Invoice ";
        if ($smsPersib=='yes') {
            $message .= "pendaftaran Keanggotaan PERSIB ";
        }
        $message .= "Anda " . $kodeInvoice . ". " .
                   "Transfer Rp " . number_format($amount, 0, ".", ",") . " ke " .
                   $jenisBank.". No Rek :  " . $noRek . " a/n " . $accountBank .
                   " sblm pkl " . trim($jam) . " (".$tanggal.")";

        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }
    
    /**
     * 6. Reminder Buyer for Buy with Virtual Account
     * @param string Kode Invoice, String VAN ID, Int Total Bayar
     * @output Id Insert Tabel sms_gateway Integer 
     */
    public function sendReminderOrderVirtualAccount($kodeInvoice, $vanId, $amount, $payment_type, $time)
    {
//        $timeOut = explode(" ", $time);
//        $tanggal = $timeOut[0];
//        $jam = $timeOut[1];
        // under 160 char
        //Anda telah melakukan pembelian dgn No Inv 151112-01063. Mohon transfer ke VAN ID 88778 140715 00036 sebesar Rp 99,999,999 sblm pkl 12:12 (12-12-2016)
        $message = "Segera lakukan pembayaran untuk Inv " . $kodeInvoice . 
                   " ke no-rek " . $vanId . " (VA " . $payment_type . "), "
                   . "sebesar Rp " . number_format($amount, 0, ".", ",") . " sblm " . $time;
//        $message = "Anda telah melakukan pembelian dgn No Inv " .
//                   $kodeInvoice . ". " . "Mohon transfer ke VAN ID " .
//                   $vanId . " sebesar Rp " . number_format($amount, 0, ".", ",") .
//                   " sblm pkl " . trim($jam) . " (".$tanggal.")";

        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendSettlementHold($kodeOrder)
    {
        $message = "Settlement Kode Order ".$kodeOrder." di HOLD. Cek Dashboard Seller Anda. Terima kasih";
        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendSettlementReject($kodeOrder)
    {
        $message = "Settlement Kode Order ".$kodeOrder." di REJECT. Cek Dashboard Seller Anda. Terima kasih";
        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendSettlementPaid($kodeOrder)
    {
        $message = "Settlement Kode Order ".$kodeOrder." di PAID. Cek Dashboard Seller Anda. Terima kasih";
        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendNotificationCipikaBookUser($message)
    {
        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );

        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function formatMSISDN($phone)
    {
        return $this->formatPhone($phone);
    }
    
    function formatPhone($phone)
    {
        // jika penulisan no hp 0811 239 345
        $phone = str_replace(" ", "", $phone);
        // jika penulisan no hp (0274) 778787
        $phone = str_replace("(", "", $phone);
        // jika penulisan no hp (0274) 778787
        $phone = str_replace(")", "", $phone);
        // jika penulisan no hp 0811.239.345
        $phone = str_replace(".", "", $phone);

        if (!preg_match('/[^+0-9]/', trim($phone))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($phone), 0, 3) == '+62') {
                $phones = str_replace("+", "", $phone);
            } elseif (substr(trim($phone), 0, 2) == '62') {
                $phones = trim($phone);
                // cek apakah no hp karakter 1 adalah 0
            } elseif (substr(trim($phone), 0, 1) == '0') {
                $phones = '62' . substr(trim($phone), 1);
            }
            // cek apakah no hp karakter 1 adalah bukan 0
            elseif (substr(trim($phone), 0, 1) != '0') {
                $phones = '62' . substr(trim($phone), 0);
            }
        }
        return $phones;
    }
    
    function konversi_tanggal($format, $tanggal = "now", $bahasa = "id")
    {
        $en = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Jan", "Feb",
            "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

        $id = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu",
            "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
            "Oktober", "Nopember", "Desember");

        return str_replace($en, $id, date($format, strtotime($tanggal)));
    }

    /**
     * Notification Failed Topup Voucher Reload
     * @param string Kode Invoice, string Kode Order , integer Amount Voucher
     * @output Id Insert Tabel sms_gateway Integer 
     */
    public function sendNotifFailedTopupVoucherReload($detInvoice, $kodeOrder, $amountVoucher)
    {
        $dateInvoice = new \DateTime($detInvoice->date_added);
        $dateInvoiceString = $dateInvoice->format('d/m/y');
        // under 160
        //Topup pulsa anda saat ini belum berhasil, tunggu beberapa saat lagi atau contact ke e-care.store@cipika.co.id. No Inv 151112-01063 (12/12/2016)
        $message = "Topup pulsa anda saat ini belum berhasil, tunggu beberapa saat lagi atau contact ke " .
        "e-care.store@cipika.co.id. No Inv " . $detInvoice->kode_invoice . " (" . $dateInvoiceString . ")";
        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }

    public function sendCanvasserOTPCode($OTPCode, $time)
    {
        $timeOut = explode(" ", $time);
        $tanggal = $timeOut[0];
        $jam = $timeOut[1];

        $message = "Gunakan kode OTP ".$OTPCode." untuk melakukan aktifasi registrasi canvasser anda sblm pkl " . trim($jam) . " (".$tanggal.")";

        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }    

    public function sendVoucherElektronikSms($voucherMerchantKode, $voucherMerchant, $list_voucher_data=array(), $vIdOrder=0, $vIdOrderItem=0, $vIdLatestSHippingHistory=0 )
    {
        foreach ($list_voucher_data as $v) {
            $nilai = $v['voucher_nominal'];
            $timeOut = explode(" ", $v['voucher_date_expired']);
            //$tanggal = $timeOut[0];
            //$jam = $timeOut[1];
            $date1 = new \DateTime($v['voucher_date_expired']); 
            $timeExpired1 = '(kadaluarsa '.$date1->format('d/m/Y').')';
            if (substr($date1->format('d/m/Y'),-4)=='1970') {
                $timeExpired1='';
            }
            
            if (substr(trim($voucherMerchantKode),0,14)=='PERSIB_TICKET_') {
                $message = "Kode Tiket Pertandingan PERSIB ke-".$v['voucher_urutan']." Anda : ".$v['voucher_code'].". Penukaran Tiket : Graha Persib Sulanjana, Sabtu 8 April 2017 pukul 09.00 s/d 14.00 - CS Persib 08569019444. ";
            } else if (trim($voucherMerchantKode)=='INDOMARET') {
                $message = "Tunjukkan SMS ini ke KASIR INDOMARET. Kode Voucher VBE-INDOMARET ke-".$v['voucher_urutan']." : ".$v['voucher_code']." senilai Rp ".number_format($nilai).". Baca info cara pemakaian di http://bit.ly/2ewxBST ";
            } else if (substr(trim($voucherMerchantKode),0,8)=='ALFAMART') {
                if (trim($voucherMerchantKode)=='ALFAMART100RB') {
                    $tgl_redeem_mobo='';
                    if ($v['voucher_mobo_date_order']<>'') { $tgl_redeem_mobo = 'Redeem MOBO tgl '.$v['voucher_mobo_date_order'].' sejumlah '.$v['voucher_jumlah'].' voucher. '; }
                    $message = "Kode Voucher ".$voucherMerchant." ke-".$v['voucher_urutan']." : ".$v['voucher_code']." ".$timeExpired1.". ".$tgl_redeem_mobo."Info cara pemakaian di http://bit.ly/2ewxBST - CIPIKA email e-care.store@cipika.co.id";
                    //$message = "Redeem MOBO ".$voucherMerchant." anda tgl ".$tgl_redeem_mobo." kode voucher belanja ".$v['voucher_code']." ".$timeExpired1.". Info Cara Pemakaian di http://bit.ly/2ewxBST - CIPIKA call center 021-30496999";
                } else {
                    $message = "Kode Voucher ".$voucherMerchant." Anda ".$v['voucher_code']." ".$timeExpired1.". Cara Pemakaian & Syarat Ketentuan di http://bit.ly/2ewxBST - email e-care.store@cipika.co.id";
                }
            } else {
                $message = "Kode Voucher ".$voucherMerchant." Anda ".$v['voucher_code']." ".$timeExpired1.". Baca cara dan ketentuan pemakaian yg dikirimkan ke email anda.";
            }
            if ($this->formatPhone($this->msisdn)!='') {
                $insert = array(
                    'id_sms' => null,
                    'msisdn' => $this->formatPhone($this->msisdn),
                    'message' => $message,
                    'sender' => USERID_JATIS,
                    'division' => DIVISION_JATIS,
                    'batch_name' => 'cipika',
                    'upload_by' => UPLOADBY_JATIS,
                    'channel' => CHANNEL_JATIS,
                    'add_time' => date("Y-m-d H:i:s"),
                    'send_time' => "0000-00-00 00:00:00",
                    'send_status' => 0,
                    'id_order' => $vIdOrder,
                    'id_orderitem' => $vIdOrderItem,
                    'id_shippingchange' => $vIdLatestSHippingHistory,
                );
                $this->dbLibrary->insert('tbl_sms_gateway', $insert);
                //            return $this->dbLibrary->insert_id();
            }
        } 

    }    

    public function sendInfoAutoAcceptToMerchant($kodeInvoice, $detUser)
    {
        $message = "Dear Merchant, order member ".$detUser->firstname." ".$detUser->lastname." No Order : " . $kodeInvoice . " di Cipika Store status : Accept. Mohon segera dilakukan pengiriman. Terima kasih.";

        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    } 

    public function sendInfoOrderProsesToCostumer($kodeInvoice, $detUser, $isMobo, $isAddressSA)
    {
        $message = "";
        if ($isMobo==1) {       
            $message = "Redeem koin MOBO Anda sedang diproses nomor order " . $kodeInvoice . ". ";
        } else {
            $message = "Pesanan anda di Cipika Store sedang diproses nomor order " . $kodeInvoice . ". ";
        }
        if ($isAddressSA==1) {
            $message .= " Pengiriman barang ke alamat kantor SA masing-masing.";
        }
        $message .= " Untuk Informasi email e-care.store@cipika.co.id.";

        $insert = array(
            'id_sms' => null,
            'msisdn' => $this->formatPhone($this->msisdn),
            'message' => $message,
            'sender' => USERID_JATIS,
            'division' => DIVISION_JATIS,
            'batch_name' => 'cipika',
            'upload_by' => UPLOADBY_JATIS,
            'channel' => CHANNEL_JATIS,
            'add_time' => date("Y-m-d H:i:s"),
            'send_time' => "0000-00-00 00:00:00",
            'send_status' => 0,
        );
        $this->dbLibrary->insert('tbl_sms_gateway', $insert);
        return $this->dbLibrary->insert_id();
    }    

    
    
}
