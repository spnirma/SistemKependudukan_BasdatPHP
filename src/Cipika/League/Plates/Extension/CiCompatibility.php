<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class CiCompatibility implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getConfig', [$this, 'getConfig']);
        $engine->registerFunction('isMerchant', [$this, 'isMerchant']);
        $engine->registerFunction('checkMerchantStatus', [$this, 'checkMerchantStatus']);
        $engine->registerFunction('isMatrixMerchant', [$this, 'isMatrixMerchant']);
    }

    public function getConfig($key)
    {
        $CI =& get_instance();
        return $CI->config->item($key);
    }
    
    public function isMerchant($id_user, $id_level)
    {
        $CI =& get_instance();
        return $CI->commonlib->check_merchant($id_user, $id_level);
    }
    
    public function checkMerchantStatus($id_user, $id_level, $status)
    {
        $CI =& get_instance();
        return $CI->commonlib->check_merchant_status($id_user, $id_level, $status);
    }
    
    public function isMatrixMerchant($id_user)
    {
        $CI =& get_instance();
        return $CI->user_m->isMatrixMerchant($id_user);
    }
}
