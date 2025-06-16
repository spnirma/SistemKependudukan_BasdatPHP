<?php

namespace Cipika\View\Helper;

class ValidationJneAwb
{
    
    public function removeCharAwbNumber($awbNumber)
    {
        $awbNumber = trim($awbNumber);
        $awbNumber = rtrim($awbNumber);
        $awbNumber = ltrim($awbNumber);
        $awbNumber = str_replace("'", '', $awbNumber);
        $awbNumber = str_replace(" ", '', $awbNumber);
        $awbNumber = str_replace("  ", '', $awbNumber);
        $awbNumber = str_replace('"', '', $awbNumber);
        $awbNumber = preg_replace('/\s+/', '', $awbNumber);
        $awbNumber = preg_replace("/[^a-zA-Z0-9]/", "", $awbNumber);
        return $awbNumber;
    }

}
