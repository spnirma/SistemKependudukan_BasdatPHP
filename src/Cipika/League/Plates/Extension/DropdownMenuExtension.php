<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class DropdownMenuExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        // $engine->registerFunction('DropdownMenuGenerator', [$this, 'DropdownMenuGenerator']);
        $engine->registerFunction('getBrandAttributes', [$this, 'getBrandAttributes']);
        // $engine->registerFunction('getBrandLink', [$this, 'getBrandLink']);
    }
    
    // public function DropdownMenuGenerator($channel, $id_parent=0) {
    //     $CI =& get_instance();
    //     $home_ui2_m = $CI->home_ui2_m;
    //     return $home_ui2_m->dropdownMenuGenerator($channel, $id_parent);
    // }

    public function getBrandAttributes($channel = 'homeentertainment', $nama_kategori) {
        $CI =& get_instance();
        $home_ui2_m = $CI->home_ui2_m;
        return $home_ui2_m->getBrandAttributes($channel, $id_parent);
    }


}