<?php 
namespace Cipika\Common;

class ActionLog
{
    public function save($masterTable='',$idMaster='',$type='',$desc='',$requestBy='',$handleBy='', $action_mobile='')
    {
        $ci =& get_instance();
        if(($idMaster!='') && ($type!='') && ($masterTable!='') ){
            $type = str_replace(' ','_',strtolower($type));
        
            $data = array(  'id_action_log'         => null,
                            'action_master_table'   => $masterTable,
                            'action_master_id'      => $idMaster,
                            'action_type'           => $type,
                            'action_desc'           => $desc,                        
                            'action_request_by'     => $requestBy,                        
                            'action_handle_by'      => $handleBy,
                            'action_ev'      		=> EVENTID,
                            'action_date'           => date('Y-m-d H:i:s'),
                            'action_mobile'      => $action_mobile,
                        );
        
            $ci->db->insert('action_log', $data); 
            return $ci->db->insert_id();
        }
    }
    
}