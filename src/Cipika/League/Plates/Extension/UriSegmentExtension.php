<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class UriSegmentExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getUriSegment', [$this, 'getUriSegment']);
    }

    public function getUriSegment($segment)
    {
        $CI =& get_instance();
        $uri = $CI->uri;

        return $uri->segment($segment);
    }
}
