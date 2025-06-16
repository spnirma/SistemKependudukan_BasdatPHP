<?php

namespace Cipika\Common;

use Cipika\Common\PaymentDatabaseLibrary;
use Cipika\Common\PaymentFeatureLibrary;
use Cipika\Common\Feature;

class PaymentLibrary {

    protected $dbLib;
    protected $listPayment;
    protected $listPaymentRules;
    private $params = null;
    private $paramsFeature = null;
    private $paramsConfig = null;
    private $paramsConstants = null;

    public function setDataPayment($params = array(), $paramsFeature = array(), $paramsConstants = null, $paramsConfig = null) {
        if (is_array($params)) {
            $this->params = (object) $params;
        }
        if (is_array($paramsFeature)) {
            $this->paramsFeature = (object) $paramsFeature;
        }
        if (is_array($paramsConstants)) {
            $this->paramsConstants = (object) $paramsConstants;
        }
        if (is_array($paramsConfig)) {
            $this->paramsConfig = (object) $paramsConfig;
        }
        return true;
    }

    public function getDataPayment() {
        return array(
            'param' => $this->params,
            'param_feature' => $this->paramsFeature,
            'param_constants' => $this->paramsConstants,
            'param_config' => $this->paramsConfig,
        );
    }

    public function setListPayment(PaymentDatabaseLibrary $listPayment) {
        $this->listPayment = $listPayment->getAllPayment();
    }

    public function getListPayment() {
        return $this->listPayment;
    }

    public function setRulesPayment(PaymentRulesLibrary $listPaymentRules) {
        $this->listPaymentRules = $listPaymentRules;
        $this->listPaymentRules->setParams($this->params);
        $this->listPaymentRules->setParamsFeature($this->paramsFeature);
        $this->listPaymentRules->setParamsConfig($this->paramsConfig);
        $this->listPaymentRules->setParamsConstants($this->paramsConstants);
    }

    public function getRulesPayment() {
        return $this->listPaymentRules;
    }

    public function setFeaturePayment(PaymentFeatureLibrary $listPaymentFeature) {
        $this->listPaymentRules->setFeaturePayment($listPaymentFeature);
    }

    public function getFeaturePayment() {
        return $this->listPaymentRules->getFeaturePayment();
    }

    public function getRespondDataPayment() {
        return $this->listPaymentRules->getRespondDataPayment();
    }

    public function listPayment() {
        $idPayment = array();
	if ($this->listPayment) { 
        foreach ($this->listPayment as $k => $v) {
            if ($this->listPaymentRules->getAvailablePayment($v->id_payment, $v->nama_payment)) {
                $idPayment[] = (object) array(
                            'id' => $v->id_payment,
                            'payment' => $v->nama_payment,
                            'status' => $this->listPaymentRules->getAvailablePayment($v->id_payment, $v->nama_payment),
                );
            }
        }
	}
        return $idPayment;
    }

}
