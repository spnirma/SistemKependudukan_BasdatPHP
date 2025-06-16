<?php

namespace Cipika\Common;

class BcaKlikPayGenerator
{
    public function genKeyId($clearKey)
    {
        return strtoupper(bin2hex($this->str2bin($clearKey)));
    }

    public function genSignature($klikPayCode, $transactionDate, $transactionNo, $amount, $currency, $keyId)
    {
        /*
         * Signature Step 1
        */
        $tempKey1 = $klikPayCode.$transactionNo.$currency.$keyId;
        $hashKey1 = $this->getHash($tempKey1);
        //echo "tempKey1 : " . $tempKey1;
        //echo " hasKey1 : " . $hashKey1 . "<br>";

         /*
         * Signature Step 2
        */
        $expDate = explode('/', substr($transactionDate, 0, 10));
        $strDate = $this->intval32bits($expDate[0].$expDate[1].$expDate[2]);
        $amt = $this->intval32bits($amount);
        $tempKey2 = $strDate + $amt;
        $hashKey2 = $this->getHash((string) $tempKey2);
        //echo "tempKey2 : " . $tempKey2;
        //echo " hashKey2 : " . $hashKey2 . "<br>";
        //echo " stdDate : " . $strDate . "<br>";
        //echo " amt : " . $amt . "<br>";
        /*
         * Generate Key Step 3
        */
        $signature = abs($hashKey1 + $hashKey2);

        return $signature;
    }

    public function genAuthKey($klikPayCode, $transactionNo, $currency, $transactionDate, $keyId)
    {
        /*
        * Step 1 - Padding
        */
        $klikPayCode = str_pad($klikPayCode, 10, '0');
        $transactionNo = str_pad($transactionNo, 18, 'A');
        $currency = str_pad($currency, 5, '1');

        /*
         * Step 2
        */
        $value_1 = $klikPayCode.$transactionNo.$currency.$transactionDate.$keyId;

        //echo $value_1;
        /*
        * Step 3
        */

        $hash_value_1 = strtoupper(md5($value_1));
        /*
        * Step 4
        */

        if (strlen($keyId) == 32) {
            $key = $keyId.substr($keyId, 0, 16);
        } elseif (strlen($keyId) == 48) {
            $key = $keyId;
        }

        // hex encode the return value
        return strtoupper(bin2hex(mcrypt_encrypt(MCRYPT_3DES, $this->hex2bin($key), $this->hex2bin($hash_value_1), MCRYPT_MODE_ECB)));
    }

    private function hex2bin($data)
    {
        $len = strlen($data);

        return pack('H'.$len, $data);
    }

    private function str2bin($data)
    {
        $len = strlen($data);

        return pack('a'.$len, $data);
    }

    private function intval32bits($value)
    {
        if ($value > 2147483647) {
            $value = ($value - 4294967296);
        } elseif ($value < -2147483648) {
            $value = ($value + 4294967296);
        }

        return $value;
    }

    private function getHash($value)
    {
        $h = 0;
        for ($i = 0;$i < strlen($value);++$i) {
            $h = $this->intval32bits($this->add31T($h) + ord($value{$i}));
        }

        return $h;
    }

    private function add31T($value)
    {
        $result = 0;
        for ($i = 1;$i <= 31;++$i) {
            $result = $this->intval32bits($result + $value);
        }

        return $result;
    }
}
