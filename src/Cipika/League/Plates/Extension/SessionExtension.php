<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class SessionExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getSession', [$this, 'getSession']);
    }

    public function getSession($parameter)
    {
        $CI =& get_instance();
        $session = $CI->session;
        return $session->userdata($parameter);
    }
}
