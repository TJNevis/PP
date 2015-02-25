<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Owner extends PP_Controller {

	function __construct(){
		
		parent::__construct();
		if(!$this->session->userdata('logged_in') && $this->uri->segment(2) != "login"){
        	redirect('admin/login');
		}
		$user = $this->session->userdata('user_info');
		$access = $this->config->item('access');
		if(!in_array("owner",$access[$user['type']])) {
			redirect("admin/noaccess/");
		}

		$this->load->model('User_model');
		$this->load->model('Owner_model');
        $this->load->model('Global_model');
	}

	public function index()
	{
		redirect('/admin');
	}

	public function settings()
	{

		//get user info
		$user = $this->session->userdata('user_info');

		if($user['type']=="super_admin" || $user['type']=="pp_admin")
			$data['sites'] = $this->Site_model->getAll();

		if($this->input->post('site_id')){
			$siteID = $this->input->post('site_id');
		}else if($this->uri->segment(4)){
			$siteID = $this->uri->segment(4);
		}else{
			$siteID = "";
		}
		$data['site_id'] = $siteID;

		//save/insert if post
		if($this->input->post('site_id')) {

			//save permissions
			foreach ($this->config->item('ownerPermissions') as $s) {
				$settings[]=array(
					'site_id'=>$siteID,
					'key'=>$s,
					'value'=>$this->input->post($s)
				);
			}
			$this->Owner_model->saveSettings($settings,$siteID);

			$this->messages->add($this->lang->line('owner_permission_save_success'), 'success');
		}

		//get permissions
		$data['settings'] = $this->Owner_model->getSettings($siteID);

			
		//security check
		if(!$this->User_model->securityCheck($user['user_id'],$siteID)) {
			redirect("admin/noaccess/");
		}
		
		$data['permissions'] = $this->config->item('owner_permissions');
		$layoutData['content'] = $this->load->view('admin/owner/permissions',$data,true);
		$this->load->view('layouts/admin',$layoutData);
	}
}
