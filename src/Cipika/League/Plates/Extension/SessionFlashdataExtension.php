<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class SessionFlashdataExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getSessionFlashdata', [$this, 'getSessionFlashdata']);
    }

    public function getSessionFlashdata($parameter)
    {
        $CI =& get_instance();
        $session = $CI->session;
        return $session->flashdata($parameter);
    }
}
