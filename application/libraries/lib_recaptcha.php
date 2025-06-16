<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('recaptcha/recaptchalib.php');
class Lib_recaptcha
{

        var $publickey = "6LeKwPMSAAAAAJLAa5dtKxNIcpicLKhxwwfzVivr"; // you got this from the signup page
        var $privatekey = "6LeKwPMSAAAAAAHHLylkRcX3aUJN9-EHKg_rNmiu";

	function recaptcha()
	{
            return recaptcha_get_html($this->publickey, null, true);
	}
        
        function auth_recaptcha($chalenge, $response){
            $resp = recaptcha_check_answer ($this->privatekey,
                $_SERVER["REMOTE_ADDR"],
                $chalenge,
                $response);
            return $resp;
        }
}
