<?php
class Owner_model extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        $this->load->library('encrypt');
        $this->load->model('data/User_data');
        $this->load->model('Global_model');
        $this->load->model('Mail_model');
        $this->load->model('Site_model');
        $this->load->model('Api_model');
    }

    function loadSettings($siteID){
    	$settings = $this->getSettings($siteID);
        $this->session->set_userdata('owner_settings',$settings);
        return true;
    }

    function getSettings($siteID){

    	$savedSettings = $this->Global_model->get('owner_settings',array('site_id'=>$siteID),NULL);
    	foreach($savedSettings as  $ss){
    		$settings[$ss['key']]=$ss['value'];
    	}

    	foreach ($this->config->item('ownerPermissions') as $s) {
    		if(!isset($settings[$s]))
    			$settings[$s]="";
    	}

    	return $settings;
    }

    function saveSettings($data=array(),$site_id) {
        //delete existing perms
        $this->db->delete('owner_settings', array('site_id' => $site_id)); 

        //add new perms
        foreach($data as $s)
        	$permissions = $this->Global_model->insert('owner_settings',$s);

    	return true;
    }

	/*
	 * Authenticates user with given username and password
	 * Returns False or user data
	 */
	function authenticate($username,$password) {
		//autenticate user via api
		$auth = $this->Api_model->auth($username,$password);
		
		//temporary auth
		if($auth){
			//get owner info
			$url = $this->config->item('apiUrl')."/contacts/info";
			$accountInfo = json_decode($this->Api_model->get($url),true);

			$owner=array(
				'owner_id'=>$accountInfo['contactID'],
				'owner_name'=>$accountInfo['name'],
				'owner_company_name'=>$accountInfo['companyName'],
				'owner_email' => $accountInfo['prefs']['email']['value']
			);

			if(!$accountInfo['name']){
				$owner['owner_name'] = $accountInfo['firstName']." ".$accountInfo['lastName'];
			}
			
			$session=array(
				'owner_logged_in'=>TRUE,
				'owner_info'=>$owner
			);

			$this->Global_model->addToSession($session);
			return true;
		}else
			return false;
	}

	function genHash($username) {

		//generate api secure hash
		$timestamp = time();
		$hash = hash_hmac('sha1', $username.':'.$timestamp, $this->config->item('apiKey'));

		$data = array(
			'username' => $username,
			'timestamp' => $timestamp,
			'valid' => $hash
		);

		//get password reset hash
		$url = $this->config->item('apiUrl')."/contacts/passwordHash";
		$hashReturn = json_decode($this->Api_model->post($url,$data,false),true);

		//error_log("Hash Return: ".print_r($hashReturn['prefs'],1));

		$contactID = $hashReturn['contactID'];
		$resetHash = $hashReturn['hash'];

		if($contactID) {

			//send email
			$emailData = array(
				'name' => $hashReturn['info']['firstName'],
				'link' => "https://".$this->session->userdata('sub_domain')."/owner/reset?h=".$resetHash."&c=".$contactID,
				'affiliate' => $this->session->userdata('name')
			);

			$emailBody = $this->load->view('emails/owner_password_reset',$emailData,true);
			$this->Mail_model->sendEmail($hashReturn['info']['prefs']['email']['value'],"support@petpassages.com",$this->lang->line('owner_reset_subject'),$emailBody);

			return true;
		}else{
			return false;
		}	
	}

	function resetPassword($hash,$contactID,$password){

		//generate api secure hash
		$timestamp = time();
		$validHash = hash_hmac('sha1', $contactID.':'.$password.':'.$timestamp, $this->config->item('apiKey'));

		if($contactID) {
			$data = array(
				'contactID' => $contactID,
				'hash' => $hash,
				'password' => $password,
				'timestamp' => $timestamp,
				'valid' => $validHash
			);
		}

		//get password reset hash
		$url = $this->config->item('apiUrl')."/contacts/resetPassword";
		$hashReturn = json_decode($this->Api_model->post($url,$data,false),true);

		//error_log("reset return: ".print_r($hashReturn,1));

		return $hashReturn['success'];
	}

	function checkSubscription($email){
		if(!$email){
			$owner_info = $this->session->userdata('owner_info');
			$email = $owner_info['owner_email'];
		}

		$apiKey = $this->config->item('activeCampaignKey');
		$url = $this->config->item('activeCampaignUrl')."?api_key=$apiKey&api_action=contact_list&api_output=json";
		$list = $this->config->item('activeCampaignList');

		$data = array(
			'filters[email]' => $email,
			'filters[listid]' => $list
		);

		$this->curl->create($url);
		$this->curl->options(array(CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST => true, CURLOPT_POSTFIELDS=>http_build_query($data)));
		$ret = $this->curl->execute();

		return $ret;
	}

	function subscribeGrievingEmails($email=NULL,$optIn){
		if(!$email){
			$owner_info = $this->session->userdata('owner_info');
			$email = $owner_info['owner_email'];
		}

		$apiKey = $this->config->item('activeCampaignKey');
		$url = $this->config->item('activeCampaignUrl')."?api_key=$apiKey&api_action=contact_add&api_output=json";
		$list = $this->config->item('activeCampaignList');

		$data['email'] = $email;

		if($optIn=='true'){
			$data["p[$list]"]=$list;
			$data["status[$list]"]=1;
		}else{
			$data["p[$list]"]=$list;
			$data["status[$list]"]=2;
		}

		$this->curl->create($url);
		$this->curl->options(array(CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST => true, CURLOPT_POSTFIELDS=>http_build_query($data)));
		$ret = $this->curl->execute();

		return $ret;
	}

	function updateGrievingEmails($email=NULL,$id){
		if(!$email){
			$owner_info = $this->session->userdata('owner_info');
			$email = $owner_info['owner_email'];
		}

		$apiKey = $this->config->item('activeCampaignKey');
		$url = $this->config->item('activeCampaignUrl')."?api_key=$apiKey&api_action=contact_edit&api_output=json";
		$list = $this->config->item('activeCampaignList');

		$data['email'] = $email;

		$data['id'] = $id;
		$data["p[$list]"]=$list;
		$data["status[$list]"]=1;

		$this->curl->create($url);
		$this->curl->options(array(CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST => true, CURLOPT_POSTFIELDS=>http_build_query($data)));
		$ret = $this->curl->execute();

		return $ret;
	}
}
