<?php

namespace Cipika\Common;

class VoucherReloadActionLog
{

    public static function saveLog (
            $idVoucherReload, 
            $idOrder, 
            $transId, 
            $action, 
            $statusReload,
            $respondMessage,
            $idAdmin,
            $reason
        )
    {
        $ci =& get_instance();
        
        $data = array(  
            'id_send_voucher_reload_action_log' => null,
            'id_voucher_reload'                 => $idVoucherReload,
            'id_order'                          => $idOrder,
            'trans_id'                          => $transId,
            'action'                            => $action,
            'status_reload'                     => $statusReload,
            'respond_message'                   => $respondMessage,
            'id_admin'                          => $idAdmin,
            'reason'                            => $reason,
            'date_added'                        => date('Y-m-d H:i:s'),
        );
        $ci->db->insert('tbl_send_voucher_reload_action_log', $data);
        return (int) $ci->db->insert_id();

    }
}
