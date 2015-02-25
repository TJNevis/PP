<?php
class Location_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Global_model');
    }
    
    function getAll($where=array(),$siteBool=FALSE) {
    	if(!$where || $where['locations.site_id']==1) 
    		return $this->Global_model->get('locations',NULL,NULL,NULL,$siteBool);
    	else
    		return $this->Global_model->get('locations',$where,NULL,NULL,$siteBool);
    }
   
    function getSingle($where=array()) {
    	$loc = $this->Global_model->get('locations',$where);
    	return $loc[0];
    }
    
}