<?php
class Global_data extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get($table,$data,$order,$limit,$siteBool) {
  
    	$this->db->select('*');
    	
		$this->db->from($table);
		
		if($siteBool) {
			$this->db->join('sites', "sites.site_id = $table.site_id", 'left');
		}

    	if($data) {
		    foreach($data as $key=>$val) {
		    	$this->db->where($key, $val);
		    }
    	}
    	
    	$this->db->where($table.'.deleted', 0);
    	
    	if($order) {
	    	foreach($order as $col=>$sort) {
	    		$this->db->order_by($col, $sort); 
	    	}
    	}
    	
	    if($limit)
	    	$this->db->limit($limit);
	    	
	    $query = $this->db->get();	

	    $result = $query->result_array(); 
		return $result;
    }
    
	function insert($table,$data) {
		$this->db->insert($table, $data); 
		error_log($this->db->last_query());
    	return $this->db->insert_id();
    }
    
	function delete($table,$data) {
		$delete['deleted']=1;
		$this->db->where($data);
		return $this->db->update($table, $delete); 
    }
    
	function update($table,$data,$where) {
    	$this->db->where($where);
		return $this->db->update($table, $data); 
    }
}