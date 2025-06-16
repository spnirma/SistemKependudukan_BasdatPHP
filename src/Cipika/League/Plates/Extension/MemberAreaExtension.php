<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class MemberAreaExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('countVoucherByIdUser', [$this, 'countVoucherByIdUser']);
        $engine->registerFunction('countPoinByIdUser', [$this, 'countPoinByIdUser']);
    }

    public function countVoucherByIdUser($id_user)
    {
        $CI =& get_instance();
        $user_m = $CI->user_m;
        return $user_m->countVoucherByIdUser($id_user);
    }
    
    public function countPoinByIdUser($id_user)
    {
        $CI =& get_instance();
        $user_m = $CI->user_m;
        return $user_m->count_point($id_user);
    }
}
