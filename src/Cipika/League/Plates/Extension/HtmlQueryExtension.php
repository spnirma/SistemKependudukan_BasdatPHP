<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class HtmlQueryExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getHtmlQuery', [$this, 'getHtmlQuery']);
        $engine->registerFunction('visitorCount', [$this, 'visitorCount']);
    }

    public function getHtmlQuery($key='',$value='')
    {
        $CI =& get_instance();
        $home_ui2_m = $CI->home_ui2_m;        
        return $home_ui2_m->built_html_get_query($key,$value);
    }

    public function visitorCount()
    {
        $CI =& get_instance();
        $jumlah_visitor = $CI->home_ui2_m->count_visitor();
        return $jumlah_visitor->jumlah;
    }
}
