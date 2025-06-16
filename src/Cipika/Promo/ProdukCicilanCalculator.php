<?php 
namespace Cipika\Promo;

class ProdukCicilanCalculator
{

    public function calc($periode, $bunga, $price)
    {   
        $hargaCicilan = ($price + ($price * ($bunga / 100))) / $periode;
        return $hargaCicilan;
    }

}
