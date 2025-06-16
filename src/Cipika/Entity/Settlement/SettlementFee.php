<?php
/**
* CONSTANT FOR SETTLEMENT STATUS
*
*/

namespace Cipika\Entity\Settlement;

class SettlementFee
{
    private static $feeCipika = 0;
    // private static $transferCost = 5000;
    private static $transferCost = 0;

    /**
    * @param bank_name is String
    */
    public static function getTransferCost($bank_name)
    {
        if (stripos($bank_name, 'BCA') !== false || stripos($bank_name, 'Bank Central Asia') !== false) {
            $transfer_cost = 0;
        } else {
            $transfer_cost = self::$transferCost;
        }

        return $transfer_cost;
    }

    public static function getFeeCipika()
    {
        return self::$feeCipika;
    }
}
