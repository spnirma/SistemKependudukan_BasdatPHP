<?php 
/**
* CONSTANT FOR SETTLEMENT STATUS
*
*/

namespace Cipika\Entity\Settlement;

class SettlementStatus
{
    const REQUESTED = 'requested';
    const OK = 'OK';
    const READY = 'ready';
    const PROCEED = 'proceed';
    const PENDING = 'pending';
    const REJECT = 'reject';
    const PAID = 'paid';
    const HOLD = 'hold';

    /**
    * 
    * @param datatype: Integer
    * @output String
    */
    public static function getStatus($value, $ready=1)
    {
        if ($value == 1 && $ready == 1) {
            return self::REQUESTED;
        }
        else if ($value == 2 && $ready == 1) {
            return self::OK;
        }
        else if ($value === 0 && $ready == 1) {
            return self::READY;
        }
        else if ($value == 3 && $ready == 1) {
            return self::PROCEED;  
        }
        else if ($value == 4 && $ready == 1) {
            return self::PENDING;  
        }
        else if ($value == 5 && $ready == 1) {
            return self::REJECT;  
        }
        else if ($value == 6 && $ready == 1) {
            return self::PAID;  
        }
        else if ($value == 7 && $ready == 1) {
            return self::HOLD;  
        }
        else if ($value == NULL && $ready == 1) {
            return 'Ready to Request';
        }
        else if ($value == NULL && $ready == 0) {
            return 'Not Ready';
        }
    }

    public static function getStatusAsString($value)
    {
        if ($value == self::REQUESTED) {
            return 'Requested';
        }
    }
}