<?php
class User_data extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('encrypt');
        $this->load->model('Global_model');
    }
    
    function loadUser($data) {
    	$result = $this->Global_model->get('users',$data);
    	if(isset($result[0]))
    		return $result[0];
    	else
    		return false;
    	
    }
    
    function passwordResetHash($userID) {
    	$hash = md5($userID.time());
    	
		$data = array('password_reset_hash'=>$hash);
		$this->Global_model->update('users',$data,array("user_id"=>$userID));
		return $hash;
    }
}