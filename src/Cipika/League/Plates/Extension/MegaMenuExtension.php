<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class MegaMenuExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('MegaMenuGenerator', [$this, 'MegaMenuGenerator']);
        $engine->registerFunction('DropdownMenuGenerator', [$this, 'DropdownMenuGenerator']);
        $engine->registerFunction('getBrandAttributes', [$this, 'getBrandAttributes']);
        // $engine->registerFunction('getBrandLink', [$this, 'getBrandLink']);
        $engine->registerFunction('get_produk_branded', [$this, 'get_produk_branded']);
        $engine->registerFunction('get_Menu_Produk_Mobo', [$this, 'get_Menu_Produk_Mobo']);

        // -- dropship
        $engine->registerFunction('get_Menu_Produk_Mobo_Dropship', [$this, 'get_Menu_Produk_Mobo_Dropship']);
        $engine->registerFunction('DropdownMenuGeneratorDropship', [$this, 'DropdownMenuGeneratorDropship']);
    }
    
    public function MegaMenuGenerator($channel)
    {
		$CI =& get_instance();
		$home_ui2_m = $CI->home_ui2_m;
        return $home_ui2_m->MegaMenuGenerator($channel);
	}

    public function DropdownMenuGenerator($channel, $id_parent=0) {
        $CI =& get_instance();
        $home_ui2_m = $CI->home_ui2_m;
        return $home_ui2_m->dropdownMenuGenerator($channel, $id_parent);
    }

    public function getBrandAttributes($channel = 'homeentertainment', $nama_kategori) {
        $CI =& get_instance();
        $home_ui2_m = $CI->home_ui2_m;
        return $home_ui2_m->getBrandAttributes($channel, $nama_kategori);
    }

    // public function getBrandLink($channel='homeentertainment', $nama_kategori) {
    //     $CI =& get_instance();
    //     $home_ui2_m = $CI->home_ui2_m;
    //     return $home_ui2_m->getBrandLink($channel = 'homeentertainment', $nama_kategori);
    // }

    public function get_produk_branded() {
        $CI =& get_instance();
        $home_ui2_m = $CI->home_ui2_m;
        return $home_ui2_m->get_produk_branded();
    }

    public function get_Menu_Produk_Mobo($channel, $id_parent=0) {
        $CI =& get_instance();
        $home_ui2_m = $CI->home_ui2_m;
        return $home_ui2_m->dropdownMenuGeneratorMobo($channel, $id_parent);
    }

    public function get_Menu_Produk_Mobo_Dropship($channel, $id_parent=0) {
        $CI =& get_instance();
        $home_ui2_m = $CI->home_ui2_m;
        return $home_ui2_m->dropdownMenuGeneratorMoboDropship($channel, $id_parent);
    }

    public function DropdownMenuGeneratorDropship($channel, $id_parent=0) {
        $CI =& get_instance();
        $home_ui2_m = $CI->home_ui2_m;
        return $home_ui2_m->dropdownMenuGeneratorDropship($channel, $id_parent);
    }
    
    
}