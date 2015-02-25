<?php
class User_model extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        $this->load->library('encrypt');
        $this->load->model('data/User_data');
        $this->load->model('Global_model');
        $this->load->model('Mail_model');
        $this->load->model('Site_model');
    }

	/*
	 * Authenticates user with given username and password
	 * Returns False or user data
	 */
	function authenticate($username,$password) {
		$data['username'] = $username;

		//load user
		$user = $this->loadUser($data);
				
		//check if it's correct
		if (isset($user) && $password) {

			$db_user_password = $user['password'];
			
			if($password == $this->encrypt->decode($db_user_password)){
				//load site
				$site = $this->Site_model->loadSiteByLID($user['site_id']);

				$session=array(
					'logged_in'=>TRUE,
					'user_info'=>$user,
					'site_info'=>$site
				);
				$this->Global_model->addToSession($session);
				return $user;
			}else{
				$this->messages->add("Username or password incorrect.", 'error');
				return false;
			}
		}else{
			$this->messages->add("Username or password incorrect.", 'error');
			return false;
		}
	}
	
	function hashAuthentication($hash,$email,$timestamp) {
		//check hash
		$secretKey = "cd39a5a54c28d426bb63d0b6c4fafa8d";
		$generatedHash = md5($secretKey.$email.$timestamp);
		$timeNow = time();
		
		$timePast = (time()-(60*60));
		
		
		if($timestamp>=$timePast && $timestamp<=$timeNow) {
			if($generatedHash == $hash) {
				//load user
				$user = $this->loadUser(array('email_address'=>$email));
				if(!$user)
					$user = $this->loadUser(array('username'=>$email));

				return $this->authenticate($user['username'], $this->encrypt->decode($user['password']));
			}else
				return false;
			
		}else
			return false;
	}
	
	function checkHash($hash) {
		if($this->loadUser(array("password_reset_hash"=>$hash)))
			return true;
		else
			return false;
	}
	
	function reset($password,$hash) {
		$data['password'] = $this->encrypt->encode($password);
		$data['password_reset_hash'] = "";
		$where['password_reset_hash'] = $hash;


		if($hash && $this->Global_model->update('users',$data,$where))
			return true;
		else
			return false;
	}
	
	function forgot($username,$email) {
		
		if($username)
			$data['username']=$username;
		
		if($email)
			$data['email']=$email;
		
		$user = $this->loadUser($data);
		
		if($user) {
			//generate and save hash
			$hash = $this->User_data->passwordResetHash($user['user_id']);
			
			//send email
			$message = "\r\n\r\nPlease use the following link to reset your password: http://".APPLICATION_BASE_URL."/admin/reset/".$hash."\r\n\r\nSincerely,\r\nPet Passages Support Team";
			$this->Mail_model->sendEmail($user['email_address'],"support@petpassages.com","Pet Passages - Password Reset Instructions",$message);
			
			return true;
		}else{
			return false;
		}
	}
	
	function loadUser($data) {
		return $this->User_data->loadUser($data);
	}
	
    function getAll($where=array(),$siteBool) {
    	return $this->Global_model->get("users",$where,NULL,NULL,$siteBool);
    }
    
	function getSingle($where=array()) {
    	return max($this->Global_model->get("users",$where));
    }
    
    function checkUserSiteID($userID,$siteID) {
    	$user = $this->getSingle(array('user_id'=>$userID));
    	$userSiteID = $user['site_id'];
    	if($userSiteID==$siteID)
    		return true;
    	else
    		return false;
    }
    
    function securityCheck($userID,$siteID,$table=NULL,$data=array()) {
    	//check users site id
    	$user = $this->session->userdata('user_info');
		$access = $this->config->item('securityCheck');
		if($access[$user['type']]==1) {
	    	if($this->checkUserSiteID($userID,$siteID)) {
	    		return true;
	    	}else{
	    		return false;
	    	}
		}
		else
			return true;
    }
}
