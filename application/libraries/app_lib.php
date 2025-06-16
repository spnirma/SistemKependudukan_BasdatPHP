<?php
class app_lib 
{
    protected $ci;
    function  __construct() {
        $this->ci=&get_instance();
    }

    
    /* get banner detail by name */
    public function get_banner($name) {
        $sql = "select * from banner where banner_title='".$name."' limit 0,1";
        
        $query = $this->ci->db->query($sql);
        if($query->num_rows() > 0){
			return $query->row(); 
		}
    }

   
}
?>
