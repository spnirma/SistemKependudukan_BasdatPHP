<?php 
/**
* CONSTANT FOR Product STATUS
*
*/

   

namespace Cipika\Entity\ProductStatus;

class ProductStatus
{
    const MODERASI = 'Moderasi';
    const VERIFY   = 'Verify';
    const UNVERIFY = 'Unverify';
    const UNKNOWN  = 'Unknown';

    /**
    * 
    * @param datatype: Integer
    * @output String
    */
    public static function getStatus($value)
    {
        switch($value){
            case 0:
                $status = MODERASI;
                break;
            case 1:
                $status = VERIFY;
                break;
            case 2:
                $status = UNVERIFY;
                break;
            default:
                $status = UNKNOWN;
                break;
        }
    }    
}
