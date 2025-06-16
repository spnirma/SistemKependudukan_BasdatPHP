<?php

namespace Cipika\Common;

class VoucherReloadLog
{

    public static function saveLog ($url, $idOrder, $transId, $request, $respond, $status)
    {
        $ci =& get_instance();
        
        $data = array(  
                    'id_send_voucher_reload_log' => null,
                    'url'                        => $url,
                    'id_order'                   => $idOrder,
                    'trans_id'                   => $transId,
                    'request'                    => $request,
                    'respond'                    => $respond,
                    'status'                     => $status,
                    'date_added'                 => date('Y-m-d H:i:s'),
                    'date_modified'              => null,
                );
//        return $data;
        $ci->db->insert('tbl_send_voucher_reload_log', $data);
        return $ci->db->insert_id();
    }
}
