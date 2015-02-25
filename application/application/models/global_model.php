<?php
class Global_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('data/Global_data');
    }
    
    function get($table,$data=array(),$order=array(),$limit=NULL,$siteBool=false) {
    	return $this->Global_data->get($table,$data,$order,$limit,$siteBool);
    }
    
	function insert($table,$data) {
    	return $this->Global_data->insert($table,$data);
    }
    
	function update($table,$data,$where) {
    	return $this->Global_data->update($table,$data,$where);
    }
    
	function delete($table,$where) {
    	return $this->Global_data->delete($table,$where);
    }
    
	function addToSession($data) {
		$this->session->set_userdata($data);
	}
	
}