<?php 

namespace Cipika\Common;

class Mailer
{
    /* Save mailer */
    function save($data)
    {
        $CI =& get_instance();        
        $insert = array('idmailer'          => null,
                        'mailer_module'     => (isset($data['module']))?$data['module']:'',
                        'mailer_from'       => (isset($data['from']))?$data['from']:'',
                        'mailer_to'         => (isset($data['to']))?$data['to']:'',
                        'mailer_cc'         => (isset($data['cc']))?$data['cc']:'',
                        'mailer_bcc'        => (isset($data['bcc']))?$data['bcc']:'',
                        'mailer_subject'    => (isset($data['subject']))?$data['subject']:'',
                        'mailer_message'    => (isset($data['message']))?$data['message']:'',
                        'mailer_status'     => 'new',
                        'mailer_created'    => (isset($data['created']))?$data['created']:date('Y-m-d H:i:s')
                        );
        $CI->db->insert('mailer',$insert); 
        return $CI->db->insert_id();
    }
    
    function update($id, $data)
    {
        $CI =& get_instance();  
        $CI->db->where('idmailer', $id);
        $CI->db->update('mailer', $data);
        return $CI->db->affected_rows();
    }
    
    /* Get all new email */ 
    function getEmails($limit=5, $trySendLimit = 1)
    {
        $CI =& get_instance();
        $now = date('Y-m-d H:i:s');
        $trySendLimit = (int)$trySendLimit;
        //$sql = "select * from mailer where mailer_status='new' and mailer_created<'$now' AND try_send <= $trySendLimit order by mailer_created asc limit 0,$limit";
        $sql = "select * from mailer "
                . "where mailer_priority = 0 AND mailer_to IS NOT NULL AND mailer_to NOT LIKE '% %' AND mailer_status='new' and mailer_created<'$now' AND try_send <= $trySendLimit "
                . "order by mailer_created asc limit 0,$limit";
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
    }
    
    /* Get all new email */ 
    function getEmailsAttach($limit=5, $trySendLimit = 1)
    {
        $CI =& get_instance();
        $now = date('Y-m-d H:i:s');
        $trySendLimit = (int)$trySendLimit;
        //$sql = "select * from mailer where mailer_status='new' and mailer_created<'$now' AND try_send <= $trySendLimit order by mailer_created asc limit 0,$limit";
        $sql = "select * from mailer "
                . "where mailer_priority = 1 AND mailer_to IS NOT NULL AND mailer_to NOT LIKE '% %' AND mailer_status='new' and mailer_created<'$now' AND try_send <= $trySendLimit "
                . "order by mailer_created asc limit 0,$limit";
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
    }
    
    /* Get single email */
    function getSingleEmail($idmailer)
    {
        $CI =& get_instance();  
        $sql = "select * from mailer where idmailer=". (int)$idmailer." limit 0,1";
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->row(); 
		}
    }
    
    /* Send single email */
	function sendMail($idmailer='')
	{
        $CI =& get_instance(); 
        if($idmailer!=''){            
            $row = $CI->get_single_email((int)$idmailer);
            if(!empty($row)){
                $config = $CI->_mailWin();
                $this->load->library('email', $config);                
                
                $CI->email->set_newline("\r\n");
                $CI->email->from($row->mailer_from, 'Cipika Store');
                $CI->email->to($row->mailer_to);                
                $CI->email->subject($row->mailer_subject);
                $CI->email->message($row->mailer_message);
                $send = $CI->email->send();

                $status = (!$CI->email->send())?'not sent':'sent';
                $CI->update($row->idmailer,array('mailer_status' => $status,'mailer_sent' => date('Y-m-d H:i:s')));
            }
        }
	}
    
    function _mailWin()
    {
        $config = Array(
            'protocol'      => $this->config->item('protocol'),
            'smtp_host'     => $this->config->item('smtp_host'),
            'smtp_port'     => $this->config->item('smtp_port'),
            'smtp_user'     => $this->config->item('smtp_user'),
            'smtp_pass'     => $this->config->item('smtp_pass'),
            'mailtype'      => $this->config->item('mailtype'),
            'charset'       => $this->config->item('charset'),
            'smtp_crypto'   => $this->config->item('smtp_crypto'),
            'bcc_batch_mode'   => true,
            'bcc_batch_size'   => 5            
        );
        return $config;
    }

    function _mailUnix()
    {
        $config = array(
            'mailtype'  => $this->config->item('mailtype'),
            'charset'   => $this->config->item('charset'),
            'bcc_batch_mode'   => true,
            'bcc_batch_size'   => 5            
        );
        return $config;
    }
    
    
}
