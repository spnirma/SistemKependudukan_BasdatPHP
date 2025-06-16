<?php

namespace Cipika\View\Helper;

class MoneyCeiling
{
    public function ceil($number, $significance = 1)
    {
        if (is_numeric($number) && is_numeric($significance)) {
            return ceil($number / $significance) * $significance;
        }

        return false;
    }
}
