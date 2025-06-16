<?php

namespace Cipika\Common\Feature;

interface Feature {

    public function getParams();

    public function setParams($params);

    public function getData();

    public function setData($params);

    public function getConfig();

    public function setConfig($params);

    public function getConstants();

    public function setConstants($params);

    public function calc();
}
