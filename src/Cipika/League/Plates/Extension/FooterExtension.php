<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class FooterExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('FooterConfig', [$this, 'FooterConfig']);
        $engine->registerFunction('FooterContent', [$this, 'FooterContent']);
    }
    
    public function FooterConfig()
    {
		$CI =& get_instance();
		$homepage_config_m = $CI->homepage_config_m;
        return $homepage_config_m->get_all_config('Footer Link');
	}

    public function FooterContent($id_homepage_config)
    {
        $CI =& get_instance();
        $homepage_config_m = $CI->homepage_config_m;
        return $homepage_config_m->get_all_footer($id_homepage_config);
    }
}
