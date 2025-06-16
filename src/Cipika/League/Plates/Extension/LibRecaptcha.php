<?php
namespace Cipika\League\Plates\Extension;

require_once('recaptcha/recaptchalib.php');

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class LibRecaptcha implements ExtensionInterface
{
    public $publickey = "6LeKwPMSAAAAAJLAa5dtKxNIcpicLKhxwwfzVivr"; // you got this from the signup page
    public $privatekey = "6LeKwPMSAAAAAAHHLylkRcX3aUJN9-EHKg_rNmiu";
    
    public function register(Engine $engine)
    {
        $engine->registerFunction('recaptcha', [$this, 'recaptcha']);
        $engine->registerFunction('authRecaptcha', [$this, 'authRecaptcha']);
    }

	public function recaptcha()
	{
        return recaptcha_get_html($this->publickey, null, true);
	}
        
    public function authRecaptcha($chalenge, $response){
        $resp = recaptcha_check_answer ($this->privatekey,
            $_SERVER["REMOTE_ADDR"],
            $chalenge,
            $response);
        return $resp;
    }
}
