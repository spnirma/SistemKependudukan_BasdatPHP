<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nusoap_library_mobo
{
function Nusoap_library_mobo()
    {
        if (ENVIRONMENT=='production') {
           require_once('soap_mobo/nusoap_prod'.EXT);
        } else {
           require_once('soap_mobo/nusoap'.EXT);
        }
    }
}
?>