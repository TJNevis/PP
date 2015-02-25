<?php
class Banner_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Global_model');
    }
    
    function getAll($where=array()) {
   		switch($where) {
			case 'basic':
				$allowedTemplates = array('basic');
				break;
			case 'standard':
				$allowedTemplates = array('basic','standard');
				break;
			case 'professional':
				$allowedTemplates = array('basic','standard','professional');
				break;
		}
		
		$this->db->select('*');
		$this->db->from('banners');
		$this->db->where_in('banner_level', $allowedTemplates);
		$query = $this->db->get();	

	    return $query->result_array(); 
    }
    
	function getSingle($where=array()) {
    	return max($this->Global_model->get("banners",$where));
    }

}