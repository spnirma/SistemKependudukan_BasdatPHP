<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    function status_merchant_label($status)
    {
        switch($status){
            case 'pending':
                $label = 'Pending';
                break;
            case 'approve':
                $label = 'Verified';
                break;
            case 'block':
                $label = 'Unverified';
                break;
            default:    
                $label = 'Unknown Status ('.$status.')';
                break;
        }
        
        return $label;
    }
    
    function status_product_label($status)
    {
        switch($status){
            case 0:
                $label = 'Moderasi';
                break;
            case 1:
                $label = 'Verified';
                break;
            case 2:
                $label = 'Un Verified';
                break;
            default:    
                $label = '-';
                break;
        }
        
        return $label;
    }
    
    function status_payment_label($status)
    {
        switch(strtolower($status)){
            case 'done':
                $label = 'Paid';
                break;
            case 'paid':
                $label = 'Paid';
                break;
            case 'canceled':
                $label = 'Canceled';
                break;
            case 'expired':
                $label = 'Expired';
                break;
            case 'confirmed':
                $label = 'Confirmed';
                break;
            case 'refund':
                $label = 'Refund';
                break;
            case 'waiting_conf':
                $label = 'Payment Verification';
                break;
            default:    
                $label = 'Waiting for Payment';
                break;
        }
        
        return $label;
    }
    
    function status_delivery_label($status)
    {
        switch(strtolower($status)){
            case 'proses pengiriman':
                $label = 'Proses Pengiriman';
                break;
            case 'persiapan pengiriman':
                $label = 'Persiapan Pengiriman';
                break;
            case 'produk telah diterima':
                $label = 'Produk Telah Diterima';
                break;
            case 'proses retur':
                $label = 'Proses Retur';
                break;  
            case 'canceled':
                $label = 'Canceled';
                break;  
            case 'terjadi keterlambatan':
                $label = 'Terjadi Keterlambatan';
                break;  
            case 'proses oleh grab express':
                $label = 'Diproses oleh Grab Express';
                break;
            case 'pengambilan barang oleh grab express':
                $label = 'Pengambilan barang oleh Grab Express';
                break;
            case 'pengiriman barang oleh grab express':
                $label = 'Pengiriman barang oleh Grab Express';
                break;
            default:    
                $label = '-';
                break;
        }
        
        return $label;
    }

    function status_response_merchant_label($status)
    {
        switch(strtolower($status)){
            case 'hold':
                $label = 'Hold';
                break;
            case 'reject':
                $label = 'Reject';
                break;
            case 'accept':
                $label = 'Accept';
                break;
            case 'waiting':
                $label = 'Waiting';
                break;
            default:    
                $label = '-';
                break;
        }
        
        return $label;
    }
    
    function send_mail($to,$from,$subject,$message)
    {
        $headers = "From: " . strip_tags($from) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($from) . "\r\n";       
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
        mail($to, $subject, $message, $headers);
    }
    
    function random_password($length=8) {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    
    /*
        Author  : mdhb2
        Desc    : Get visitor country detail by IP
        @return : array of country details
    */
    function get_visitor_country()
    {
        $ipdb_key   = "b66b39d6f23f63d743304c00afee80254d2fe847240a21f2e598ac0f84f60ef2"; // api key from http://ipinfodb.com
        $ip         = $_SERVER['REMOTE_ADDR'];
        $result     = file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=$ipdb_key&ip=$ip");
        
        $result     = explode(';;',$result);
        $result     = explode(';',$result[1]);
        
        $return     = array('ip'        => $result[0],
                            'country_id'=> $result[1],
                            'country'   => $result[2],
                            'region'    => $result[3],
                            'city'      => $result[4],
                            'lat'       => $result[6],
                            'long'      => $result[7],
                            'timezone'  => $result[8]                            
                            );
        return $return;
    }
    
    
    /*
        Author  : mdhb2
        Desc    : Remove any contact from text (email,phone,BBM)
        @return : string Censored contact replaced with stars
    */
    function remove_contact($string)
    {
        // Remove email address
        $pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
        $replacement = "******";
        $result = preg_replace($pattern, $replacement, $string);
        
        // Remove phone/BBM
        $result = preg_replace('/\+?[0-9][0-9()-\s+]{2,20}[0-9]/', '******', $result);
        
        return $result;    
    }
    
    /*
        Author  : mdhb2
        Desc    : Format angka ke format indonesia (123456 => 123.456)
        @param $int number
        @return : string formated number
    */
    function format_uang($number,$decimal=0)
    {
       return number_format($number,$decimal,",",".");
    }
    
    function status_voucher_by_date($date_start, $date_expired)
    {
        $dateNow = date('Y-m-d');
        $label = "";
        if ($date_start > $dateNow) {
            $label = "TUNGGU";
        } elseif ($date_expired < $dateNow) {
            $label = "EXPIRED";
        } else {
            $label = "AKTIF";
        }
        return $label;
    }

    function status_inbox($id, $from)
    {
        if ($from == 'member') {
        switch($id){
                case 2:
                    $label = 'Anda menerima pesan';
                    break;
                case 3:
                    $label = 'Semua pesan terbaca';
                    break;
                case 4:
                    $label = 'Diskusi Closed';
                    break;
                default:
                    $label = 'Terkirim';
                    break;
            }
        }else{
            switch($id){
                case 1:
                    $label = 'Anda menerima pesan';
                    break;
                case 3:
                    $label = 'Semua pesan terbaca';
                    break;
                case 4:
                    $label = 'Diskusi Closed';
                    break;
                default:
                    $label = 'Terkirim';
                    break;
            }
        }
            
    
        return $label;
    }
    
    function format_price($n = '')
    {
        if ($n == '')
        {
            return 0;
        }
        $n = trim(preg_replace('/([^0-9\.])/i', '', $n));

        return number_format($n, 0, ',', '.');
    }

    function status_respon_agregator($status_respon_agregator)
    {
        if (empty($status_respon_agregator) || $status_respon_agregator == 'waiting') {
            return "-";
        } else {
            return $status_respon_agregator;
        }
    }

    function isHomePage()
    {
        $actual_url =  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $base_url = base_url();
        if ($actual_url == $base_url) {
            return true;
        } else {
            return false;
        }
    }

    // $val='canvasser_oke_ya_kaka';
    // echo '<br>'.$val;
    // echo '<br>encript='.myEncrypt('cip1ka',$val);
    // echo '<br>decript='.myDecrypt('cip1ka',myEncrypt('cip1ka',$val));
    // $val=0;
    // echo '<br>'.$val;
    // echo '<br>encript='.myEncrypt('cip1ka',$val);
    // echo '<br>decript='.myDecrypt('cip1ka',myEncrypt('cip1ka',$val));
    // exit;

    function myEncrypt($secretkey='id',$filecipher){
        $td = mcrypt_module_open('rijndael-256', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $secretkey, $iv);
        $encrypted = mcrypt_generic($td, $filecipher);      
        $encrypted1=base64_encode($iv).";".base64_encode($encrypted);
        $result=base64_encode($encrypted1);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $result=str_replace("=","l4iLa",$result);
        return $result;
    }

    function myDecrypt($secretkey='id',$string){
        $string=str_replace("l4iLa","=",$string);
        list($iv,$filecipher) = explode (";", base64_decode($string));
        $td = mcrypt_module_open('rijndael-256', '', 'ecb', '');
        mcrypt_generic_init($td, $secretkey, base64_decode($iv));
        $result = mdecrypt_generic($td, base64_decode($filecipher));
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $result;
    }

    function islonggerthan($string, $num)
    {
        if (strlen($string) > $num) {
            return "...";
        }
    }

    function errortostring($errors)
    {
        $err = "";
        if (!empty($errors)) {
            foreach ($errors as $v) {
                $err .= '<p>' . $v . '</p>';
            }
        }

        return $err;
    }

    function pre($array)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        exit();
    }

    function get($key, $default = "")
    {
        if (!empty($_GET[$key])) {
            return $_GET[$key];
        } else {
            return $default;
        }
    }

    function youtube_link_to_code($link)
    {
        preg_match("#([\/|\?|&]vi?[\/|=]|youtu\.be\/|embed\/)([a-zA-Z0-9_-]+)#", $link, $matches);
        return end($matches);
    }

    function sub_acara_preview($file_link, $tipe, $desc = "")
    {
        if ($tipe == "classroom_video") {
            return '<iframe width="400" height="200" src="https://www.youtube.com/embed/'.$file_link.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        }
        if ($tipe == "classroom_gallery") {
            return '<img src="'.base_url($file_link).'" style="height:100px">';
        }
        if ($tipe == "classroom_doc") {
            return '<a href="'.base_url($file_link).'" target="_blank" class="btn btn-primary">Download File</a>';
        }
        if ($tipe == "classroom_qna") {
            return $desc;
        }
    }

    function ordefault($value, $default = "")
    {
        if (!empty($value)) {
            return $value;
        } else {
            return $default;
        }
    }

    function human_date($date)
    {
        return date("d M Y", strtotime($date));
    }
    
    function hourminutes($time)
    {
        return substr($time, 0, 5);
    }

    function toclearjson($array)
    {
        $json_str = json_encode($array);
        $json_str = str_replace('"', "'", $json_str);
        return str_replace('\\', "", $json_str);
    }

    function assetlocation($asset)
    {
        return APPPATH . "/../" . $asset;
    }

    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    function removespecial($string)
    {
        return str_replace("'", "", $string);
    }