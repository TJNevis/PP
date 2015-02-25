<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends PP_Controller {

	function __construct(){
		
		parent::__construct();
		if(!$this->session->userdata('logged_in') && $this->uri->segment(2) != "login"){
        	redirect('admin/login');
		}
		$user = $this->session->userdata('user_info');
		$access = $this->config->item('access');
		if(!in_array("users",$access[$user['type']])) {
			redirect("admin/noaccess/");
		}

		$this->load->library('encrypt');
        $this->load->model('Site_model');
        $this->load->model('User_model');
        $this->load->model('Global_model');
        $this->load->model('Page_model');
	}
	
	public function index()
	{
		$layoutData = array();
		
		$user = $this->session->userdata('user_info');
		if($user['type']=="super_admin")
			$layoutData['users'] = $this->User_model->getAll(NULL,true);
		elseif($user['type']=="pp_admin")
			$layoutData['users'] = $this->User_model->getAll(array('users.type !='=>'super_admin'),true);
		else
			$layoutData['users'] = $this->User_model->getAll(array('users.site_id'=>$user['site_id']),true);

		$layoutData['content'] = $this->load->view('admin/users/index',$layoutData,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function edit()
	{
		$user = $this->session->userdata('user_info');
		$form = array();
		$form['sites'] = $this->Site_model->getAll();
		
		if($this->input->post('user_id')){
			$userID = $this->input->post('user_id');
		}else if($this->uri->segment(4)){
			$userID = $this->uri->segment(4);
		}else{
			$userID = "";
		}
		
		if($this->input->post('first_name')) {
			$site_id = $this->input->post('site_id');

				
			//update db
			$data = array(
				"site_id"=>$site_id,
				"first_name"=>$this->input->post('first_name'),
				"last_name"=>$this->input->post('last_name'),
				"username"=>$this->input->post('username'),
				"email_address"=>$this->input->post('email_address'),
				"password"=>$this->encrypt->encode($this->input->post('password')),
				"type"=>$this->input->post('type')
			);
			
			if($this->User_model->securityCheck($user['user_id'],$site_id)) {
				if($userID) {
					//update
					
					if(!$this->input->post('password'))
						unset($data['password']);
					
					if($this->Global_model->update("users",$data,array("user_id"=>$userID))){
						$this->messages->add($this->lang->line('user_update_success'), 'success');
					}else
						$this->messages->add($this->lang->line('user_update_error'), 'error');
				}else{
					//new
					$data['created'] = time();
					
					$userID = $this->Global_model->insert("users",$data);
					if(is_int($userID)) {
						$this->messages->add($this->lang->line('user_add_success'), 'success');
					}else{
						$this->messages->add($this->lang->line('user_add_error'), 'error');
					}
				}
			}else{
				//no access
				redirect("admin/noaccess/");
			}
			
			//redirect 
			if($userID)
				redirect("admin/users/edit/".$userID);
		}
		
		$layoutData = array();
		
		$form = array_merge($this->User_model->getSingle(array('user_id'=>$userID)),$form);
		
		//security check
		if(!$this->User_model->securityCheck($user['user_id'],$form['site_id'])) {
			redirect("admin/noaccess/");
		}
		
		$layoutData['content'] = $this->load->view('admin/users/edit',$form,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function add()
	{
		$layoutData = array();
		$form['sites'] = $this->Site_model->getAll();
		$form['site_id'] = $this->Site_model->getSiteID();
		$layoutData['content'] = $this->load->view('admin/users/edit',$form,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function delete()
	{
		$delete_user_id = $this->uri->segment(4);
		
		//get logged in user
		$user = $this->session->userdata('user_info');
		
		//get delete user
		$delete_user = $this->User_model->getSingle(array("user_id"=>$delete_user_id));
		if(!$this->User_model->securityCheck($user['user_id'],$delete_user['site_id'])) {
			redirect("admin/noaccess/");
		}
		
		if($this->Global_model->delete("users",array('user_id'=>$delete_user_id))) {
			$this->messages->add($this->lang->line('user_delete_success'), 'success');
		}else
			$this->messages->add($this->lang->line('user_delete_error'), 'error');
		redirect("admin/users/");
	}
	
	public function ajax_check_username()
	{
		$username = $this->input->get('username');
		if($this->User_model->getSingle(array("username"=>$username)))
			$ret = false;
		else
			$ret = true;
			
		$this->output
	    ->set_content_type('application/json')
	    ->set_output(json_encode($ret));

	}
}