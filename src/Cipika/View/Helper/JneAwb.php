<?php

namespace Cipika\View\Helper;

class JneAwb {

    protected $url;
    protected $username;
    protected $api_key;

    public function __construct($url, $username, $api_key)
    {
        $this->url = $url;
        $this->username = $username;
        $this->api_key = $api_key;
    }

    public function insertAwb($kode_order, $awb_number)
    {
        $url = $this->url . "/tracing/cipikastore/insertCnote";

        $data = array(
            'username' => $this->username,
            'api_key' => $this->api_key,
            'ORDER_ID' => $kode_order,
            'AWB_NUMBER' => $awb_number,
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $curl_response = curl_exec($curl);
        curl_close($curl);

        return json_decode($curl_response);
    }

    public function updateAwb($kode_order, $awb_number)
    {
        $url = $this->url . "/tracing/cipikastore/list/cnote/" . $awb_number;

        $data = array(
            'username' => $this->username,
            'api_key' => $this->api_key,
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $curl_response = curl_exec($curl);
        curl_close($curl);

        return json_decode($curl_response);
    }

}
