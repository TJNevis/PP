<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends PP_Controller {

	function __construct(){
		
		parent::__construct();
        	
		if( isset($_GET['embed']) && $_GET['embed']=="true"){
            $this->session->set_userdata('embed',true);
        }

		if(empty($_SERVER['HTTPS']))
			redirect("https://".$this->session->userdata('sub_domain')."/owner/");
        
		$this->load->model('Owner_model');
	}
	
	public function index()
	{
		if(!$this->session->userdata('owner_logged_in')){
        	redirect('/owner/login');
		}
		
		$layoutData = array();
		$bodyData = array();
		$bodyData['pet_information_active'] = true;
		
		$layoutData['content'] = $this->load->view('owner/index',$bodyData,true);
		$layoutData['tabs'] = true;
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function understanding() {
		$layoutData = array();
		$bodyData = array();
		$layoutData['content'] = $this->load->view('owner/understanding',$bodyData,true);
		$layoutData['tabs'] = true;

		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}

	public function children() {
		$layoutData = array();
		$bodyData = array();
		$layoutData['content'] = $this->load->view('owner/children',$bodyData,true);
		$layoutData['tabs'] = true;
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function forgot()
	{
		$bodyData = array();
		$bodyData['form'] = true;

		if($_POST) {
			if($this->input->post('username')) {
				if($this->Owner_model->genHash($this->input->post('username'))) {
					$this->messages->add($this->lang->line('owner_reset_sent'), 'success');
					$bodyData['form'] = false;
				}else{
					$this->messages->add($this->lang->line('owner_reset_sent_error'), 'success');
				}
			}else{
				$this->messages->add($this->lang->line('owner_reset_none_entered'), 'error');
			}
		}
		
		
		$layoutData['tabs'] = false;
		$layoutData['content'] = $this->load->view('owner/forgot',$bodyData,true);
		if($this->session->userdata('embed')==true)
            $this->load->view('layouts/owner_embed',$layoutData);
        else
            $this->load->view('layouts/owner',$layoutData);
	}
	
	public function reset() {
		$bodyData = array();
		$bodyData['form'] = true;
		
		if($this->input->post('password')) {
			//authenticate
			if($this->Owner_model->resetPassword($this->input->post('hash'),$this->input->post('contactID'),$this->input->post('password'))) {
				$this->messages->add($this->lang->line('owner_reset_success'), 'success');
				$bodyData['form'] = false;
			}else{
				$this->messages->add($this->lang->line('owner_reset_hash_expired'), 'error');
				$bodyData['form'] = false;
			}
		}else{
			if(!isset($_GET['h']) || !isset($_GET['c'])){
				$this->messages->add($this->lang->line('owner_reset_hash_expired'), 'error');
				$layoutData['content'] = false;
			}
		}

		$layoutData['content'] = $this->load->view('owner/reset',$bodyData,true);

		$layoutData['tabs'] = false;

		if($this->session->userdata('embed')==true)
            $this->load->view('layouts/owner_embed',$layoutData);
        else
            $this->load->view('layouts/owner',$layoutData);
	}
	
	public function login()
	{
		$layoutData = array();
		$bodyData = array();
		
		//get site id
		$siteID = $this->Site_model->getSiteID();
		
		//authenticate user
		if($this->input->post('username')) {
			$this->session->set_userdata('language', 'english');
			
			//authenticate
			$user = $this->Owner_model->authenticate($this->input->post('username'),$this->input->post('password'));
			if($user){
				//load settings
				$this->Owner_model->loadSettings($siteID);
				redirect('/owner/'); 
			}else
				$this->messages->add($this->lang->line('login_user_incorrect'),'error');
				redirect('/owner/login');
		}
		
		//if the person is loggin out the add the logged out message
		if($this->uri->segment(3))
			$this->messages->add($this->lang->line('logout_success'), 'success');
		
		//turn off tabs
		$layoutData['tabs'] = false;
		$layoutData['content'] = $this->load->view('owner/login',$bodyData,true);

		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		if( isset($_GET['embed']) && $_GET['embed']=="true"){
            $this->session->set_userdata('embed',true);
            redirect('/owner/login/1?embed=true');
        }else{
        	redirect('/owner/login/1');
        }
		
	}

	public function subscribe()
	{
		if(!$this->session->userdata('owner_logged_in')){
        	redirect('/owner/login');
		}

		if($_POST['opt']){
			$opt = $_POST['opt'];
			$email = $_POST['email'];

			$this->Owner_model->subscribeGrievingEmails($email,$opt);		
		}
	}

	public function subscription()
	{
		if(isset($_POST['subscription'])){
			$ownerInfo = $this->session->userdata('owner_info');
			$email = $ownerInfo['owner_email'];	
			$ret = json_decode( $this->Owner_model->checkSubscription($email),1 );	

			$opt = 'true';
			
			if(isset($ret[0]['id'])){
				//update
				$id = $ret[0]['id'];
				$this->Owner_model->updateGrievingEmails($email,$id);
			}else{
				//add
				$this->Owner_model->subscribeGrievingEmails($email,$opt);
			}

			$bodyData['message'] = "Email successfully subscribed.";
		}

		$layoutData['tabs'] = true;
		$bodyData['complete'] = false;
		$layoutData['content'] = $this->load->view('owner/subscribe',$bodyData,true);

		if($this->session->userdata('embed')==true)
            $this->load->view('layouts/owner_embed',$layoutData);
        else
            $this->load->view('layouts/owner',$layoutData);
	}

	public function check_subscribe()
	{
		if(!$this->session->userdata('owner_logged_in')){
        	redirect('/owner/login');
		}

		$email = $_POST['email'];
		
		$ret = json_decode( $this->Owner_model->checkSubscription($email),1 );		

		if(isset($ret[0]['id']))
			echo 1;
		else
			echo 0;
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
