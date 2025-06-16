<?php

namespace Cipika\Shipping;

class ShippingJneCalculator
{
    protected $precentage;
    private $priceJne;
    private $serviceNameJne;
    private $markupJne;
    private $potonganOngkirJne = 0;
    private $totalOngkirJne;
    private $totalOutputOngkirJne;
    private $totalOngkirJneOriginal;
    private $freeShipping;
    private $potonganrp = false;

    public function __construct($precentage)
    {
        $this->precentage = $precentage;
    }

    public function calc($priceFromJne, $freeShipping, $markupJne, $potonganShippingKotaLain, $serviceNameJne)
    {
        $this->priceJne = $priceFromJne;
        $this->serviceNameJne = $serviceNameJne;
        if (!empty($freeShipping)) {
            $this->priceJne = $priceFromJne;
            $this->markupJne = $this->priceJne * ($markupJne / $this->precentage);
            $this->totalOngkirJneOriginal = $this->priceJne + $this->markupJne;
            if ($freeShipping->statusfree == 1) {
                $this->potonganOngkirJne = ($this->priceJne + $this->markupJne);
                $this->totalOutputOngkirJne = $this->priceJne + $this->markupJne;
                $this->totalOngkirJne = 0;
                $this->freeShipping = true;
            } elseif ($freeShipping->statusfree == 0) {
                $this->potonganOngkirJne = $freeShipping->potongan_ongkir;
                if (($this->totalOngkirJneOriginal - $this->potonganOngkirJne) > 0) {
                    $this->totalOngkirJne = $this->priceJne + $this->markupJne - $this->potonganOngkirJne;
                    $this->totalOutputOngkirJne = $this->priceJne + $this->markupJne;
                    $this->freeShipping = false;
                    $this->potonganrp = true;
                } else {
                    $this->totalOutputOngkirJne = $this->priceJne + $this->markupJne;
                    $this->totalOngkirJne = 0;
                    $this->freeShipping = true;
                }
            }
        } elseif (empty($freeShipping)) {
            $this->priceJne = $priceFromJne;
            $this->markupJne = $this->priceJne * ($markupJne / $this->precentage);
            $persenpotongankotalain = ($potonganShippingKotaLain / $this->precentage);
            $this->potonganOngkirJne = ($this->priceJne + $this->markupJne) * $persenpotongankotalain;
            $this->totalOutputOngkirJne = $this->priceJne + $this->markupJne - $this->potonganOngkirJne;
            $this->totalOngkirJne = $this->totalOutputOngkirJne;
            $this->totalOngkirJneOriginal = $this->priceJne + $this->markupJne;
            $this->freeShipping = false;
        }
        return (object) array(
            'ongkirAsli' => $this->priceJne,
            'markupOngkir' => $this->markupJne,
            'potonganOngkir' => $this->potonganOngkirJne,
            'ongkirTotal' => $this->totalOngkirJne,
            'ongkirTotalOriginal' => $this->totalOngkirJneOriginal,
            'ongkirOutput' => $this->totalOutputOngkirJne,
            'paketOngkir' => $this->serviceNameJne,
            'freeshipping' => $this->freeShipping,
            'potonganrp' => $this->potonganrp,
        );
    }
}
