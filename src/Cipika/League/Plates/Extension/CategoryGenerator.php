<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class CategoryGenerator implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('generateCategory', [$this, 'generateCategory']);
        $engine->registerFunction('generateCategoryMobile', [$this, 'generateCategoryMobile']);
        $engine->registerFunction('generateShoppinglistCategory', [$this, 'generateShoppinglistCategory']);
    }

    public function generateCategory($channel = '', $id_parent = 0)
    {
        $CI =& get_instance();
        $home_ui2_m = $CI->home_ui2_m;
        return $home_ui2_m->kategori_menu_generator($channel, $id_parent);
    }
    
    public function generateCategoryMobile($channel = '', $id_parent = 0)
    {
        $CI =& get_instance();
        $home_ui2_m = $CI->home_ui2_m;
        return $home_ui2_m->kategori_menu_generator_mobile($channel, $id_parent);
    }

    public function generateShoppinglistCategory($channel = '', $id_parent = '')
    {
        $CI =& get_instance();
        return $CI->home_ui2_m->generateShoppinglistCategory($channel, $id_parent);
    }
}
