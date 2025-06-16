<?php 

namespace Cipika\Common;

class Feedback
{
    /* Save feedback */
    function save($data)
    {
        $CI =& get_instance();
        $hash = md5(microtime().rand());
        $insert = array('id_feedback'       => null,
                        'id_hashed'         => $hash,
                        'id_order'          => (isset($data['id_order']))?$data['id_order']:'',
                        'grade'             => (isset($data['grade']))?$data['grade']:'',
                        'feedback'          => (isset($data['feedback']))?$data['feedback']:'',
                        'notes'             => (isset($data['notes']))?$data['notes']:'',
                        'status'            => (isset($data['status']))?$data['status']:'',
                        'resolved_by'       => (isset($data['resolved_by']))?$data['resolved_by']:'',
                        'date_created'      => (isset($data['date_created']))?$data['date_created']:date('Y-m-d H:i:s'),
                        'date_modified'     => (isset($data['date_modified']))?$data['date_modified']:date('Y-m-d H:i:s'),
                        'date_expired'      => (isset($data['date_expired']))?$data['date_expired']:''
                        );
        $CI->db->insert('feedback',$insert); 
        return array('id' => $CI->db->insert_id(),'hash' => $hash);
    }
    
    /* Update feedback */
    function update($id, $data)
    {
        $CI =& get_instance();
        $CI->db->where('id_feedback', (int)$id);
        $CI->db->update('feedback', $data);
        return $CI->db->affected_rows();
    }
    
    /* Get single by hash */
    function getSingleByHash($hash)
    {
        $CI =& get_instance();
        $sql = "select * from feedback where id_hashed='". $CI->db->escape_str($hash) ."' and status='new' limit 0,1";
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->row(); 
		}
    }
    
    /* Get single feedback & order */
    function getSingleFeedbackOrder($idfeedback)
    {
        $CI =& get_instance();
        $sql = "select f.*,o.* from feedback f,tbl_order o where f.id_order=o.id_order and f.id_feedback=". (int)$idfeedback." limit 0,1";
        
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->row(); 
		}
    }
    
    /* Get all Feedback */ 
    function getFeedback($limit=5,$status='',$expired='')
    {
        $CI =& get_instance();        
        $sql = "select * from feedback ";
        $and = "WHERE";
        
        if($status!=''){
            $sql.=" $and status='". $CI->db->escape_str($status) ."' ";
            $and = "AND";
        }
        
        if($expired!=''){
            $sql.=" $and date_expired<='".$expired."' ";
            $and = "AND";
        }
        
        $sql.=" order by date_created asc limit 0," . (int)$limit; 
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
    }
    
    /* Query Paid Order yg belum mempunyai Feedback */
    function getOrderForFeedback($limit=5)
    {
        $CI =& get_instance();
        $sql =  "select o.* from tbl_order o,feedback f where o.id_user<>'' and o.id_merchant<>'' and o.status_payment='paid' and ".
                "o.id_order not in (select id_order from feedback) ".
                "group by o.id_order order by o.date_added asc limit 0," . (int)$limit;
        
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
    }
    
    /* Get all Feedback & Order */ 
    function getFeedbackOrder($start=0,$limit=5,$search='',$grade='')
    {
        $CI =& get_instance();        
        $sql = "select f.*,o.* from feedback f,tbl_order o where o.id_order=f.id_order ";
        $and = "AND";
        
        if($search!=''){            
            parse_str($search, $param);
            if(!empty($param)){
                foreach($param as $k=>$v){
                    if($v!=''){
                        $k  = str_replace('-','.',$k);
                        $sql.=" $and $k='".$v."' ";
                    }
                }
            }
        }
        
        if($grade!=''){
            if($grade=='-'){
                $sql.=" $and (f.grade='' or f.grade IS NULL) ";
            }else{
                $sql.=" $and f.grade='". $CI->db->escape_str($grade) ."' ";
            }
        }
        
        
        
        $sql.=" group by f.id_feedback order by f.date_created desc limit " . (int)$start . "," . (int)$limit; 
        
        $query = $CI->db->query($sql);
        if($query->num_rows() > 0){
			return $query->result(); 
		}
    }
    
    /* Count Feedback & Order */ 
    function countFeedbackOrder($search='')
    {
        $CI =& get_instance();        
        $sql = "select f.*,o.* from feedback f,tbl_order o where o.id_order=f.id_order ";
        $and = "AND";
        
        if($search!=''){            
            parse_str($search, $param);
            if(!empty($param)){
                foreach($param as $k=>$v){
                    if($v!=''){
                        $k  = str_replace('-','.',$k);
                        $sql.=" $and $k='".$v."' ";
                    }
                }
            }
        }
        
        $sql.=" group by f.id_feedback"; 
        
        $query = $CI->db->query($sql);        
		return $query->num_rows();		
    }
}
?>
