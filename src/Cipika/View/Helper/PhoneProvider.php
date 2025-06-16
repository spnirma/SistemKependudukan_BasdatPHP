<?php

namespace Cipika\View\Helper;

class PhoneProvider
{
    private $listPrefixNumberProvider = array(
        'TELKOMSEL' => array(
            '0811', '0812', '0813', '0821', '0822', '0823', '0852', '0853',
        ),
        'INDOSAT' => array(
            '0814', '0815', '0816', '0855', '0856', '0857', '0858',
        ),
        'XL' => array(
            '0817', '0818', '0819', '0859', '0877', '0878', '0879',
        ),
        'AXIS' => array(
            '0831',
            '0838',
        ),
        'THREE' => array(
            '0895',
            '0896',
            '0897',
            '0898',
            '0899',
        ),
        'SMARTFREN' => array(
            '0881',
            '0882',
            '0883',
            '0884',
            '0885',
            '0886',
            '0887',
            '0888',
            '0889',
        ),
        'ESIA' => array(
            '02', '03', '04', '05', '06', '07',
        ),
        'BOLT' => array(
            '999',
        ),
    );

    public function checkProvider($phoneNumber)
    {
        $phoneNumber = substr($phoneNumber, 0, $this->getPrefixSubstrProvider($phoneNumber));
        $out = array();
        foreach ($this->listPrefixNumberProvider as $k => $v) {
            foreach ($v as $p) {
                if ($phoneNumber == $p) {
                    $out = $k;
                }
            }
        }

        return $out;
    }

    public static function checkPrefix($phoneNumber)
    {
        if (preg_match('/(^([9][9][9])|^([0][2-7])|^([0][8][1-9]))/', $phoneNumber)) {
            return true;
        } elseif (preg_match('/(^([1-9][0-9][0-9]))/', $phoneNumber)) {
            return true;
        }

        return false;
    }

    private function getPrefixSubstrProvider($phoneNumber)
    {
        if (preg_match('/^[9][9][9]/', $phoneNumber)) {
            return 3;
        }

        if (preg_match('/^[0][2-7]/', $phoneNumber)) {
            return 2;
        }

        if (preg_match('/^[0][8][1-9]/', $phoneNumber)) {
            return 4;
        }
    }

    public function getListProvider()
    {
        return $this->listPrefixNumberProvider;
    }
}
