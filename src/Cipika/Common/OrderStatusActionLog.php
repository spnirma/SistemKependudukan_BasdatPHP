<?php 
namespace Cipika\Common;

class OrderStatusActionLog
{

    public static function save(
        $kodeOrder,
        $statusPayment,
        $statusDelivery,
        $username = "system",
        $source = "cronjob"
    ) {
        $ci =& get_instance();

        if (!is_null($kodeOrder) &&
            !is_null($statusPayment) &&
            !is_null($statusDelivery)
        ) {

            $OrderStatusActionLog = new OrderStatusActionLog;
            $statusResponse = $OrderStatusActionLog->getStatusResponse($kodeOrder);

            $params = array(
                'kode_order'        => $kodeOrder,
                'status_payment'    => $statusPayment,
                'status_delivery'   => $statusDelivery,
                'status_response_merchant'   => $statusResponse,
                'username'          => $username,
                'source'            => $source,
                'add_time'          => date('Y-m-d H:i:s'),
            );

            $ci->db->insert('tbl_order_status_log', $params);
            return $ci->db->insert_id();
        }
    }

    public static function save_response(
        $kodeOrder,
        $statusPayment,
        $statusDelivery,
        $statusResponse,
        $reasonstatusResponse,
        $username = "system",
        $source = "cronjob"
    ) {
        $ci =& get_instance();

        if (!is_null($kodeOrder) &&
            !is_null($statusPayment) &&
            !is_null($statusDelivery) &&
            !is_null($statusResponse)
        ) {
            $params = array(
                'kode_order'        => $kodeOrder,
                'status_payment'    => $statusPayment,
                'status_delivery'   => $statusDelivery,
                'status_response_merchant'   => $statusResponse,
                'reason_status_response_merchant'   => $reasonstatusResponse,
                'username'          => $username,
                'source'            => $source,
                'add_time'          => date('Y-m-d H:i:s'),
            );

            $ci->db->insert('tbl_order_status_log', $params);
            return $ci->db->insert_id();
        }
    }

    private function getStatusResponse($kodeOrder)
    {
        $ci =& get_instance();
        $ci->db->select('status_response_merchant'); 
        $ci->db->where('kode_order', $kodeOrder); 
        $query = $ci->db->get('tbl_order');

        if ($query->num_rows() > 0) {
           $row = $query->row(); 
           return $row->status_response_merchant;
        } else {
            return "-";
        }
    }
}
