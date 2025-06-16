<?php

namespace Cipika\Common;

class PaymentRulesLibrary {


    private $dataRules;
    private $dataRulesFeature;
    private $dataRulesConstants;
    private $dataRulesConfig;
    private $dataFeature;
    private $respondDataPayment = null;

    public function setParams($data) {
        $this->dataRules = $data;
    }

    public function getParams() {
        return $this->dataRules;
    }

    public function setParamsFeature($data) {
        $this->dataRulesFeature = $data;
    }

    public function getParamsFeature() {
        return $this->dataRulesFeature;
    }
    
    public function setParamsConfig($data) {
        $this->dataRulesConfig = $data;
    }

    public function getParamsConfig() {
        return $this->dataRulesConfig;
    }
    
    public function setParamsConstants($data) {
        $this->dataRulesConstants = $data;
    }

    public function getParamsConstants() {
        return $this->dataRulesConstants;
    }
    
    public function setFeaturePayment($data) {
        $this->dataFeature = $data;
    }

    public function getFeaturePayment() {
        return $this->dataFeature->calc('voucher');
    }

    public function getRules($idPayment) {
        $enable = false;
        $countEnable = 0;
        $codeStatusVoucher = null;
        $availableVoucherPayment = false;
        $codeStatusPointRewards = null;
        $mdrInstallmentFee = 0;
        $grandTotalBayar = 0;
        $showPaymentUnderOutStandingBalance = false;
        $PoinSenyumExist = false;
        $MoboExist = false;

        $this->respondDataPayment = (object) array(
                    'status' => 1,
                    'data' => (object) array(
/*
                        'totalProduk'               => $this->dataRules->totalProduk,
                        'totalOngkir'               => $this->dataRules->totalOngkir,
//                        'totalPotonganVoucher'      => 0,
//                        'totalPotonganPointRupiah'  => 0,
//                        'totalMdrInstallment'       => $mdrInstallmentFee,
                        'totalBayar'                => $this->dataRules->totalProduk +
                                                       $this->dataRules->totalOngkir, 
//                        'totalkomisidropship'       => $this->dataRules->totalkomisidropship,                                       
//                        'totalPointSenyum'          => $this->dataRules->totalPointSenyum,
//                        'isPointSenyumExist'        => $this->dataRules->isPointSenyumExist,
//                        'totalMobo'          => $this->dataRules->totalMobo,
//                        'isMoboExist'        => $this->dataRules->isMoboExist,
//                        'adaMoboRedeem'             => $this->dataRules->adaMoboRedeem,
//                        'adaDropship'               => $this->dataRules->adaDropship,
                        'nProductItem'       => $this->dataRulesFeature->nProductItem,
*/
                        'totalProduk'               => $this->dataRules->totalProduk,
                        'totalOngkir'               => $this->dataRules->totalOngkir,
                        'totalPotonganVoucher'      => 0,
                        'totalPotonganPointRupiah'  => 0,
                        'totalMdrInstallment'       => $mdrInstallmentFee,
                        'totalBayar'                => $this->dataRules->totalProduk +
                                                       $this->dataRules->totalOngkir,
                        'totalPointSenyum'          => $this->dataRules->totalPointSenyum,
                        'isPointSenyumExist'        => $this->dataRules->isPointSenyumExist,
                        'totalMobo'          => $this->dataRules->totalMobo,
                        'isMoboExist'        => $this->dataRules->isMoboExist,
                        'nProductItem'       => $this->dataRulesFeature->nProductItem,

						
						),
        );
		/* regbiz adjust
        if ($this->dataRulesFeature->voucher !== null) {
            $this->dataFeature->setFeatureParams('voucher', $this->dataRulesFeature->voucher);
            $this->dataFeature->setData('voucher', $this->dataRules);
            $this->dataFeature->setConfig('voucher', $this->dataRulesConfig);
            $this->dataFeature->setConstants('voucher', $this->dataRulesConstants);
            $this->respondDataPayment = $this->dataFeature->calc('voucher');
            $this->respondDataPayment->data->totalPotonganPointRupiah = 0;
            if ($this->dataFeature->calc('voucher')->status === 1) {
                $codeStatusVoucher = 1;
            } elseif (
                $this->dataFeature->calc('voucher')->status === 0
                && $this->respondDataPayment->data->totalBayar < $this->dataRulesConfig->MINIMAL_OUTSTANDING_BALANCE
            ) {
                $this->respondDataPayment->status = 1;
                $showPaymentUnderOutStandingBalance = true;
            } elseif ($this->dataFeature->calc('voucher')->status === 0) {
                $codeStatusVoucher = 'error';
            } else {
                if ($this->dataRulesFeature->voucher->used_for_payment !== null) {
                    $listPaymentForVoucher = unserialize($this->dataRulesFeature->voucher->used_for_payment);
                    if (!in_array($idPayment, $listPaymentForVoucher)) {
                        $availableVoucherPayment = true;
                    }
                }
            }
        }
		
        $isPaymentCicilan = false;
        $showPaymentCicilan = true;
        if ($this->dataRulesFeature->productCicilan->enableProductCicilan) {
            $isPaymentCicilan = true;
            if (!in_array($idPayment, $this->dataRulesFeature->productCicilan->listPaymentProductCicilan)) {
                $showPaymentCicilan = false;
            }
        }
        if ($this->dataRulesFeature->pointRewards !== 0) {
            $this->dataFeature->setFeatureParams('pointRewards', $this->dataRulesFeature->pointRewards);
            $this->dataFeature->setData('pointRewards', $this->respondDataPayment->data);
            $this->dataFeature->setConfig('pointRewards', $this->dataRulesConfig);
            $this->dataFeature->setConstants('pointRewards', $this->dataRulesConstants);
            $this->respondDataPayment = $this->dataFeature->calc('pointRewards');
            if ($this->dataFeature->calc('pointRewards')->status === 1) {
                $codeStatusPointRewards = 1;
            } elseif ($this->dataFeature->calc('pointRewards')->status === 0) {
                $codeStatusPointRewards = 'error';
            }
        }
        */

        if (isset($this->dataRulesFeature->idPaymentSelected) &&
            $this->dataRulesFeature->idPaymentSelected !== null
        ) {
            $idPaymentSelected = $this->dataRulesFeature->idPaymentSelected;

            if ($idPaymentSelected == 12 || $idPaymentSelected == 17) {
/*
                $mdrInstallmentPersen = $this->dataRulesConfig->mdr_installment_persen;
                $grandTotalBayar = $this->respondDataPayment->data->totalBayar;
                $mdrInstallmentFee = ($grandTotalBayar * $mdrInstallmentPersen) / 100;

                $this->respondDataPayment->data->totalMdrInstallment = $mdrInstallmentFee;
                $this->respondDataPayment->data->totalBayar = $grandTotalBayar + $mdrInstallmentFee;
            } if ($idPaymentSelected == 25) {
                $mdInstallmentKredivo = $this->dataRulesConfig->mdr_installment_kredivo;
                $grandTotalBayar = $this->respondDataPayment->data->totalBayar;
                $mdrInstallmentFee = ($grandTotalBayar * $mdInstallmentKredivo) / 100;

                $this->respondDataPayment->data->totalMdrInstallment = $mdrInstallmentFee;
                $this->respondDataPayment->data->totalBayar = $grandTotalBayar + $mdrInstallmentFee;
            } else if ($idPaymentSelected == 27) {
                $grandTotalBayar = $this->respondDataPayment->data->totalBayar;
                
                if ($grandTotalBayar != 0) {
                    $mdrInstallmentFee = $this->dataRulesConfig->mdr_nicepay;
                } else {
                    $mdrInstallmentFee = 0;
                }

                $this->respondDataPayment->data->totalMdrInstallment = $mdrInstallmentFee;
                $this->respondDataPayment->data->totalBayar = $grandTotalBayar + $mdrInstallmentFee;
            } else if ($idPaymentSelected == 21) {
                $grandTotalBayar = $this->respondDataPayment->data->totalBayar;
                
                if ($grandTotalBayar != 0) {
                    $mdrInstallmentFee = $this->dataRulesConfig->mdr_indomaret;
                } else {
                    $mdrInstallmentFee = 0;
                }

                $this->respondDataPayment->data->totalMdrInstallment = $mdrInstallmentFee;
                $this->respondDataPayment->data->totalBayar = $grandTotalBayar + $mdrInstallmentFee;
*/
            } else {
//                $this->respondDataPayment->data->totalMdrInstallment = $mdrInstallmentFee;
            }
        } else {
//            $this->respondDataPayment->data->totalMdrInstallment = $mdrInstallmentFee;
        }
        
        $isDisplayForAll = FALSE;
/*
        if (in_array($idPayment, $this->dataRulesFeature->paymentSanityTest)) {
            if (in_array($this->dataRulesFeature->currentAcount, $this->dataRulesFeature->accountSanityTest)) {
                $isDisplayForAll = TRUE;
            } else {
                $isDisplayForAll = FALSE;
            }
        } else {
            $isDisplayForAll = TRUE;
        }
*/        
//        $this->dataRules->isMoboExist>0 ? $MoboExist = true : $MoboExist;
        
        $whitelabel = FALSE;
        $dropship = FALSE;
/*
        if ($this->dataRules->whitelabel_modul != null) {
            $whitelabel = TRUE;
            if ($this->dataRules->whitelabel_modul == 'dropship') {
                $dropship = TRUE;
            }
        }
*/
        switch ($idPayment) {
            case 1: /* Bank Tranfer Permata */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 5: /* Dompetku Token */
                    $this->dataRules->totalBayar < 5000000
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 6: /* Mandiri KlikPay */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $this->dataRules->totalBayar < 50000000
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 7: /* Kartu Kredit Veritrans */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 8: /* BCA KlikPay */
                $this->dataRules->totalBayar > $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 9: /* Bank Mandiri Tranfer */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 10: /* Bank BCA Tranfer */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 11: /* Payment Voucher */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == 1
                ? $countEnable++ : $countEnable;
                break;
            case 12: /* Kartu Kredit BCA */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 13: /* Dompetku USSD */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $this->dataRules->totalBayar < 1000000
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 14: /* Payment iPaymu */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $this->dataRules->totalBayar < 5000000 
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 16: /* Payment Point */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 17: /* Installment Mandiri */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 18: /* Dompetku Plus */
                    $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 19: /* Bank Tranfer Permata Veritrans */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 21: /* Indomaret */
                //$this->dataRulesFeature->adaPersibTiket == true ? $vMinimalOrder=1 : $vMinimalOrder=$this->dataRulesConfig->minimal_order;
                $vMinimalOrder=$this->dataRulesConfig->minimal_order;
                
                $this->dataRules->totalBayar >= $vMinimalOrder
                    && $this->dataRules->totalBayar <= 5000000
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 22: /* Cash Galeri */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 24: /* KOIN */
                $this->dataRules->totalBayar == 0
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 25: /* Kredivo */
                $this->dataRules->totalBayar >= $this->dataRulesConfig->minimal_order
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 27:
                $this->dataRules->totalBayar >= 50000
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 29:
                $this->dataRules->totalBayar >= 0
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            case 30:
                $this->dataRules->totalBayar >= 0
                    && $codeStatusVoucher == null
                ? $countEnable++ : $countEnable;
                break;
            default:
                break;
        }

        if ($countEnable == 1) {
            $enable = true;
        }
        return $enable;
    }

    public function getRulesConstants($idPayment, $namaPayment) {
        $stringShowPayment = "SHOW_PAYMENT_";
        $constantPayment = strtoupper(str_replace(" ", "_", trim($namaPayment)));
        $constantShowPayment = $stringShowPayment . $constantPayment;
        $showPayment = false;
        if ($idPayment == 19) {
            if (property_exists((object) $this->dataRulesConstants,
                'SHOW_PAYMENT_PERMATA_BANK_TRANSFER')
            ) {
                $showPayment = $this->dataRulesConstants->SHOW_PAYMENT_PERMATA_BANK_TRANSFER;
                return $showPayment;
            }
        }
        if (property_exists((object) $this->dataRulesConstants, $constantShowPayment)) {
            $showPayment = $this->dataRulesConstants->$constantShowPayment;
        } else {
            switch ($idPayment) {
                case 7:
                    $showPayment = $this->dataRulesConstants->SHOW_PAYMENT_KREDIT_CARD;
                    break;
                case 8:
                    $showPayment = $this->dataRulesConstants->SHOW_PAYMENT_BCA_KLIK_PAY;
                    break;
                case 9:
                    $showPayment = $this->dataRulesConstants->SHOW_PAYMENT_BANK_MANDIRI_TRANSFER;
                    break;
                case 10:
                    $showPayment = $this->dataRulesConstants->SHOW_PAYMENT_BANK_BCA_TRANSFER;
                    break;
                case 12:
                    $showPayment = $this->dataRulesConstants->SHOW_PAYMENT_BANK_BCA_KARTU_KREDIT;
                    break;
                case 13:
                    $showPayment = $this->dataRulesConstants->SHOW_PAYMENT_DOMPETKU2;
                    break;
                case 17:
                    $showPayment = $this->dataRulesConstants->SHOW_PAYMENT_MANDIRI_KREDIT_CARD;
                    break;
                case 19:
                    $showPayment = $this->dataRulesConstants->SHOW_PAYMENT_PERMATA_BANK_TRANSFER;
                    break;
                default:
                    $showPayment = true;
                    break;
            }
        }
        return $showPayment;
    }
    
    public function getAvailablePayment($idPayment, $namaPayment) {
        if ($this->getRules($idPayment) && $this->getRulesConstants($idPayment, $namaPayment)) {
            return true;
        }
        return false;
    }
    
    public function getRespondDataPayment() {
        return $this->respondDataPayment;
    }

}
