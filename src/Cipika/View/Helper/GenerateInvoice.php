<?php

namespace Cipika\View\Helper;

class GenerateInvoice {

    protected $lengthIndexKode;

    public function __construct($length)
    {
        $this->lengthIndexKode = $length;
    }

    public function generateNewKodeInvoice($date, $index)
    {
        $max = $this->lengthIndexKode;
        $countValue = strlen($index);
        $indexPrefix = str_repeat("0", (int) $max - (int) $countValue);
        $kodeInvoice = $date . "-" . $indexPrefix . $index;
        return $kodeInvoice;
    }

}
