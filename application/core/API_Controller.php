<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH . "libraries/REST_Controller.php";
include_once APPPATH . "/libraries/JWT.php";

use \Firebase\JWT\JWT;

class API_Controller extends REST_Controller {

    /**
     * @var Bugsnag_Client bugsnag
     * Bugsnag initialize for bugtracking
     */
    //var $bugsnag; 
    public function __construct()
    {
        parent::__construct();		       	
        /*
        if (defined('ENVIRONMENT') && (ENVIRONMENT == 'production' || ENVIRONMENT == 'testing'))
        {
            $this->bugsnag = new Bugsnag_Client("f7f1f5a0664f50bc415b547b6a4a7246");
            set_error_handler(array($this->bugsnag, "errorHandler"));
            set_exception_handler(array($this->bugsnag, "exceptionHandler"));
            $this->bugsnag->setErrorReportingLevel(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        }*/
	
        /*$this->load->model('models-api/User_Model', '', TRUE);
        $this->load->library('form_validation');

        // Get the api key name variable set in the rest config file
        $api_key_variable = config_item('rest_key_name');

        // Work out the name of the SERVER entry based on config
        $key_name = 'HTTP_'.strtoupper(str_replace('-', '_', $api_key_variable));

        $this->user = $this->User_Model->get_user_by_key($this->input->server($key_name));*/
    }

    protected function _check_request($request, $mandatory, $name, $validate, $param = NULL, $return = NULL)
    {
		$this->load->library('form_validation');
        $hasil = $request;
		
        // Request ada
        if ($request !== FALSE) {
            $bool = TRUE;
            if ($validate != 'skip') {
                if (is_null($param))
                    $bool = $this->form_validation->$validate($request);
                else
                    $bool = $this->form_validation->$validate($request, $param);
            }

            if ($bool === FALSE) {
                $this->response(array(
                    'status'=> 0,
                    'error' => "Your parameter '" . $name . "' is not valid."
                ));
            }

            if(empty($request) && $mandatory) {
                $this->response(array(
                    'status'    => 0,
                    'error'     => "Your parameter is not complete. Missing parameter '" . $name . "'."
                ), 403);
            }

        }
        // Request kosong, mandatory
        else if (empty($request) && $mandatory && ($validate !== "boolean")) {
            // tampilkan error
            $this->response(array(
                    'status'    => 0,
                    'error'     => "Your parameter is not complete. Missing parameter '" . $name . "'."
                ), 403);
        } else if (is_null($request) && $mandatory && ($validate == "boolean")) {
            $this->response(array(
                'status'    => 0,
                'error'     => "Your parameter is not complete. Missing parameter '" . $name . "'."
            ), 403);
        }

        return $hasil;
    }

    protected function _check_all_request($param, $method)
    {
        $data = array();

        // save params in variable
        foreach ($param as $k => $p)
        {
            $var =  (isset($p[1])) ? $p[1] : NULL;
            if ($$k = self::_check_request($this->$method($k), 0, $k, $p[0], $var)) $data[$k] = $$k;
        }
        return $data;
    }

    protected function _validate_request($request, $validate, $param = NULL)
    {
        $bool = false;
        if (is_null($param))
        {
            if (is_null($param))
                $bool = $this->form_validation->$validate($request);
            else
                $bool = $this->form_validation->$validate($request, $param);
        }

        return $bool;
    }

    protected function _check_user($id_user)
    {
        return $this->db->where('id_user', $id_user)->get('users')->row();
    }

    protected function _check_product($id_product)
    {
        return $this->db->where('id_product', $id_product)->get('products')->row();
    }

    /* Start < API MOBILE V3 Function Global. PIC : Alie */
    
    /**
     * Get Request Header 'x-api-key'. Global Key.
     * @return HTTP_X_API_KEY
     */
    protected function _getRequestHeaderGlobalKey() {
        if (!$this->input->server('HTTP_X_API_KEY')) {
                $this->response(array(
                    'status_code'       => 0,
                    'status_message'    => "Global Key tidak tersedia",
                    'data'              => null
                ), 401);
        }
        return $this->input->server('HTTP_X_API_KEY');
    }
    
    /**
     * Get Request Header 'key'. User Key.
     * @return HTTP_KEY
     */
    protected function _getRequestHeaderKey() {
        if (!$this->input->server('HTTP_KEY')) {
                $this->response(array(
                    'status_code'       => 0,
                    'status_message'    => "Key tidak tersedia",
                    'data'              => null
                ), 401);
        }
        return $this->input->server('HTTP_KEY');
    }

    /**
     * Get Header 'key'. User Key.
     * @return HTTP_KEY
     */
    protected function _getHeaderKey() {
        if (!$this->input->server('HTTP_KEY')) {
            return null;
        }
        return $this->input->server('HTTP_KEY');
    }
    
    /**
     * Check Request Header 'x-api-key'
     */
    protected function _checkHeaderGlobalKey($globalKey)
    {
        $globalKey = trim($globalKey);

        if ($globalKey !== $this->config->item('mobile_secret_key')) {
            $this->response(
                array(
                    'status_code'       => 0, 
                    'status_message'    => 'Global Key salah',
                    'data'              => null
                ), 
            401);
        }
        return;
    }
    
    /**
     * Check Request Header 'key'. User Key.
     */
    protected function _checkHeaderKey($key)
    {
        $checkKeyUser = (new \Cipika\Common\UserMobileLibrary($this->db))
                                        ->checkUserKey($key);
        if (is_object($checkKeyUser)) {
            if ((int) $checkKeyUser->active !== 1) {
                $this->response(
                    array(
                        'status_code'       => 0, 
                        'status_message'    => 'Key salah',
                        'data'              => null
                    ), 
                401);
            } elseif ((int) $checkKeyUser->active == 1) {
                $this->user = $checkKeyUser;
            }
        } else {
            $this->response(
                array(
                    'status_code'       => 0, 
                    'status_message'    => 'Key salah',
                    'data'              => null
                ), 
            401);
        }
    }
    
    protected function _getRequest()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data == null || $_SERVER['CONTENT_TYPE'] != "application/json") {
            $this->response(
                array(
                    'status_code'       => 0,
                    'status_message'    => 'Permintaan harus berupa JSON',
                    'data'              => null
                ),
            406);
            return;
        }
        return $data;
    }

    /**
     * @param $request : all request json data
     * @param $field : field name request
     * @param $name : field label error, $name = NUll, same with field name.
     * @param $mandatory : required/skip
     * @param $isNull : $isNull = true, field cannot have blank value
     * @param $typeData : string/integer
     * @return field value request
     */ 
    protected function _checkRequest($request, $field, $name, $mandatory, $isNull = true, $typeData = 'string')
    {
        if ($request !== null) {
            if ($name == null) {
                $name = $field;
            }
            if ($mandatory === 'required') {
                if (!array_key_exists($field, $request)) {
                    $this->response(array(
                        'status_code'       => 0,
                        'status_message'    => "Parameter '" . $name . "' Tidak Tersedia",
                        'data'              => null
                    ), 400);
                    return;
                } else {
                    if ($isNull) {
                        if (isset($request[$field])) {
                            if (is_array($request[$field])) {
                                $countParamError = 0; 
                                foreach ($request[$field] as $key => $val) {
                                    if (empty($val)) {
                                        $countParamError++;
                                    }
                                }

                                if ($countParamError > 0) {
                                    if ($field == 'bank_code') {
                                        $this->response(array(
                                            'status_code'       => 0,
                                            'status_message'    => "Anda belum memilih Bank penyedia Virtual Account",
                                            'data'              => null
                                        ), 400);
                                        return;
                                    } else {
                                        $this->response(array(
                                            'status_code'       => 0,
                                            'status_message'    => "Parameter '" . $name . "' Tidak Benar",
                                            'data'              => null
                                        ), 400);
                                        return;
                                    }
                                }
                            } else {
                                if (empty($request[$field])) {
                                    if ($field == 'bank_code') {
                                        $this->response(array(
                                            'status_code'       => 0,
                                            'status_message'    => "Anda belum memilih Bank penyedia Virtual Account",
                                            'data'              => null
                                        ), 400);
                                        return;
                                    } else {
                                        $this->response(array(
                                            'status_code'       => 0,
                                            'status_message'    => "Parameter '" . $name . "' Tidak Benar",
                                            'data'              => null
                                        ), 400);
                                        return;
                                    }
                                }
                            }
                        } else if (empty($request[$field])) {
                            $this->response(array(
                                'status_code'       => 0,
                                'status_message'    => "Parameter '" . $name . "' Tidak Benar",
                                'data'              => null
                            ), 400);
                            return;
                        }
                    }
                }

            } elseif ($mandatory === 'skip') {
                if (!array_key_exists($field, $request)) {
                    if ($typeData === 'string') {
                        $request[$field] = "";
                    } elseif ($typeData === 'integer') {
                        $request[$field] = 0;
                    } elseif ($typeData === null) {
                        $request[$field] = null;
                    }
                }
            }
        } else {
            $this->response(array(
                'status_code'       => 0,
                'status_message'    => "Permintaan Tidak Benar",
                'data'              => null
            ), 400);
        }
        return $request[$field];
    }

    protected function _checkAvailableEmail($email)
    {
        $checkEmailUser = (new \Cipika\Common\UserMobileLibrary($this->db))
                                          ->checkAvailableEmail($email);
        return $checkEmailUser;
    }

    protected function _generateUserKey()
    {
        $this->load->helper('security');

        $newKey = null;
        
        do
        {
            $salt = do_hash(time().mt_rand());
            $newKey = substr($salt, 0, config_item('rest_key_length'));
        }

        while ($this->_checkAvailableKey($newKey));

        return $newKey;
    }

    protected function _checkAvailableKey($newKey)
    {
        $checkKeyUser = (new \Cipika\Common\UserMobileLibrary($this->db))
                                        ->checkAvailableKey($newKey);
        return $checkKeyUser;
    }
       
    protected function _saveUserKey($key, $data)
    {
        $saveKeyUser = (new \Cipika\Common\UserMobileLibrary($this->db))
                                        ->saveUserKey($key, $data);
        return $saveKeyUser;
    }
    
    protected function _checkUserEmail($email)
    {
        $checkUserEmail = (new \Cipika\Common\UserMobileLibrary($this->db))
                                        ->checkUserEmail($email);
        return $checkUserEmail;
    }
    
    protected function _getKeyByEmail($email)
    {
        $getKeyByEmail = (new \Cipika\Common\UserMobileLibrary($this->db))
                                        ->getKeyByEmail($email);
        return $getKeyByEmail;
    }

    protected function _getUserKey($idUser)
    {
        $idKey =  $this->db->where('id_user', $idUser)->get('tbl_user')->row()->id_key;
        $queryGetKey = "select * from `keys` where id = " . (int) $idKey. ";";
        return $this->db->query($queryGetKey)->row()->key;
    }
    
    /*
     * Validasi token header (Authorization)
     */
    protected function _check_header($cpid) {
        $headers = $this->input->request_headers();

        try {
            $my_secret = strrev($cpid) . REST_API_MY_SECRET . $cpid;
            $decodedToken = JWT::decode($headers['Authorization'], $my_secret, array('HS256'));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    protected function _statusMessage($status_code) {
        $status_message = array(
            '000' => 'Success',
            '101' => 'Incorrect Authorization',
            '102' => 'Email Already Exist',
            '103' => 'DB Connection Error',
            '104' => 'Data not found',
            '105' => 'Produk Already Exist',
            '106' => 'Merchant Not Found',
            '107' => 'Product Not Found',
            '108' => 'Order not found',
            '201' => 'Invalid Parameter',
            
        );
        foreach ($status_message as $code => $value) {
            if ($code == $status_code) {
                return $value;
            }
        }
    }
}
