<?php
class Photo_model extends CI_Model
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
				$allowedPhotos = array('basic');
				break;
			case 'standard':
				$allowedPhotos = array('basic','standard');
				break;
			case 'professional':
				$allowedPhotos = array('basic','standard','professional');
				break;
		}
		
		$this->db->select('*');
		$this->db->from('photos');
		$this->db->where_in('photo_license', $allowedPhotos);
		$query = $this->db->get();	
	    return $query->result_array(); 
    }
    
	function getSingle($where=array()) {
    	return max($this->Global_model->get("photos",$where));
    }

}