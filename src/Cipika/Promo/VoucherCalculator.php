<?php 
namespace Cipika\Promo;

class VoucherCalculator
{
    public function calcDiskonVoucher(
        $nominalVoucher,
        $diskonVoucher,
        $maxPotongan = 0
    ) {
        $totalDiskonVoucher = ($nominalVoucher * $diskonVoucher) / 100;

        if ($totalDiskonVoucher > $maxPotongan) {
            return $maxPotongan;
        } elseif ($totalDiskonVoucher < $maxPotongan) {
            return $totalDiskonVoucher;
        }
    }
}
