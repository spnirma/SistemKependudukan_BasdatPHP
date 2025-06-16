<?php

namespace Cipika\Common;

use Cipika\Common\Feature\Voucher;
use Cipika\Common\Feature\Point;

class PaymentFeatureLibrary {

    protected $feature;

    public function __construct() {
        $this->feature = (object) array(
                    'voucher' => new Voucher(),
                    'pointRewards' => new Point(),
        );
    }

    public function setFeatureParams($featureName, $params = null) {
        $this->feature->$featureName->setParams($params);
    }

    public function getFeatureParams($featureName) {
        return $this->feature->$featureName->getParams();
    }

    public function setData($featureName, $params = null) {
        $this->feature->$featureName->setData($params);
    }

    public function getData($featureName) {
        return $this->feature->$featureName->getData();
    }

    public function setConfig($featureName, $params = null) {
        $this->feature->$featureName->setConfig($params);
    }

    public function getConfig($featureName) {
        return $this->feature->$featureName->getConfig();
    }

    public function setConstants($featureName, $params = null) {
        $this->feature->$featureName->setConstants($params);
    }

    public function getConstants($featureName) {
        return $this->feature->$featureName->getConstants();
    }

    public function calc($featureName) {
        return $this->feature->$featureName->calc();
    }

}
