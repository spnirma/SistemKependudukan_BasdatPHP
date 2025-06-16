<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class AuthExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getUserNameById', [$this, 'getUserNameById']);
    }

    public function getUserNameById()
    {
        $CI =& get_instance();
        $auth_m = $CI->auth_m;
        return $auth_m->getUserNameById;
    }
}
