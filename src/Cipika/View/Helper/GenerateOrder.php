<?php

namespace Cipika\View\Helper;

class GenerateOrder {

    protected $lengthIndexKode;
    protected $prefix;

    public function __construct($length, $prefix)
    {
        $this->lengthIndexKode = $length;
        $this->prefix = $prefix;
    }

    public function generateNewKodeOrder($date, $index)
    {
        $prefix = $this->prefix;
        $max = $this->lengthIndexKode;
        $countValue = strlen($index);
        $indexPrefix = str_repeat("0", (int) $max - (int) $countValue);
        $kodeInvoice = $prefix . $date . "-" . $indexPrefix . $index;
        return $kodeInvoice;
    }

}
