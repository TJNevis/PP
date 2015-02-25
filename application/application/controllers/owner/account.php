<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends PP_Controller {

	function __construct(){
		
		parent::__construct();
		if(!$this->session->userdata('owner_logged_in') && $this->uri->segment(2) != "login"){
        	redirect('owner/login');
		}
		
		if( isset($_GET['embed']) && $_GET['embed']=="true"){
       		$this->session->set_userdata('embed',true);
        }

    	$this->load->model('Story_model');
   		$this->load->model('Global_model');
    	$this->load->model('Owner_model');
	}
	
	// public function index()
	// {
	// 	$layoutData = array();
		
	// 	//get account information
	// 	$url = $this->config->item('apiUrl')."/contacts/info";
	// 	$accountInfo = json_decode($this->Api_model->get($url),true);
	
	// 	$layoutData['account'] = $accountInfo;
		
	// 	$layoutData['tabs'] = true;
	// 	$layoutData['content'] = $this->load->view('owner/account/index',$layoutData,true);
	// 	if($this->session->userdata('embed')==true)
 //            $this->load->view('layouts/owner_embed',$layoutData);
 //        else
	// 		$this->load->view('layouts/owner',$layoutData);
	// }

	public function index()
	{
		$layoutData = array();
		

		//save account information 
		if($this->input->post('firstName')){
			$data['data']['firstName']=$this->input->post('firstName');
			$data['data']['lastName']=$this->input->post('lastName');

			if($this->input->post('password'))
				$data['data']['password']=$this->input->post('password');

			//print_r($_POST);

			foreach($_POST as $key=>$val){
				if(strpos($key, "ref_")>0){
					$prefKey = str_replace("pref_", "", $key);
					


					//validate phone number format
					if(in_array($prefKey, array('pWork','pHome','pFax','pCell'))){
						    $result = preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $val);
						    $data['data']['prefs'][$prefKey]=urlencode($result)." x ".$_POST["ext_".$prefKey];
					
					}else{
						$data['data']['prefs'][$prefKey]=urlencode($val);
					}
				}
			}

			//get account information
			$url = $this->config->item('apiUrl')."/contacts/update";
			//$url = "http://requestb.in/17fb7yt1";
			$accountInfo = json_decode($this->Api_model->post($url,$data),true);
		}

		//get account information
		$url = $this->config->item('apiUrl')."/contacts/info";
		$accountInfo = json_decode($this->Api_model->get($url),true);
	
		$layoutData['account'] = $accountInfo;
		
		$layoutData['tabs'] = true;
		$layoutData['content'] = $this->load->view('owner/account/index',$layoutData,true);
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
			$this->load->view('layouts/owner',$layoutData);
	}
}
