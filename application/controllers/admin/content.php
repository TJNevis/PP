<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends PP_Controller {

	function __construct(){
		
		parent::__construct();
		if(!$this->session->userdata('logged_in') && $this->uri->segment(2) != "login"){
        	redirect('admin/login');
		}
		$user = $this->session->userdata('user_info');
		$access = $this->config->item('access');
		if(!in_array("content",$access[$user['type']])) {
			redirect("admin/noaccess/");
		}

		$this->load->model('Site_model');
        $this->load->model('Global_model');
        $this->load->model('Page_model');
        $this->load->model('User_model');
        $this->load->model('Photo_model');
	}
	
	public function index()
	{
		$layoutData = array();
		
		$user = $this->session->userdata('user_info');
		
		if($user['type']=="super_admin" || $user['type']=="pp_admin")
			$layoutData['pages'] = $this->Page_model->getAll(NULL,true);
		else
			$layoutData['pages'] = $this->Page_model->getAll(array('site_pages.site_id'=>$user['site_id']),true);
			
		$layoutData['content'] = $this->load->view('admin/content/index',$layoutData,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function edit()
	{
		$user = $this->session->userdata('user_info');
		
		if($this->input->post('site_page_id')){
			$sitePageID = $this->input->post('site_page_id');
		}else if($this->uri->segment(4)){
			$sitePageID = $this->uri->segment(4);
		}else{
			$sitePageID = "";
		}
		
		if($this->input->post('site_id')) {
			//update db

			
			if($this->input->post('title2'))
				$data['title2']=$this->input->post('title2');
				
			if($this->input->post('content2'))
				$data['content2']=$this->input->post('content2');
				
			if($this->input->post('title3'))
				$data['title3']=$this->input->post('title3');
				
			if($this->input->post('content3'))
				$data['content3']=$this->input->post('content3');
			
			if($this->input->post('title'))
				$data['title']=$this->input->post('title');
				
			if($this->input->post('content1'))
				$data['content']=$this->input->post('content1');

			if($this->input->post('site_id'))
				$data['site_id']=$this->input->post('site_id');
				
			if($this->input->post('image'))
				$data['image']=$this->input->post('image');
			
			
			//security check then save
			if($this->User_model->securityCheck($user['user_id'],$this->input->post('site_id'))) {
				if($sitePageID) {
					//update
	
					
					if($this->Global_model->update("site_pages",$data,array("site_page_id"=>$sitePageID))){
						$this->messages->add($this->lang->line('page_update_success'), 'success');
					}else
						$this->messages->add($this->lang->line('page_update_error'), 'error');
				}else{
					//new
					$url = strtolower($this->input->post('title'));
					$url = str_replace(" ","-",$url);
					$url = ereg_replace("[^A-Za-z0-9]", "", $url );
					$url = $this->Page_model->verifyUrl($url,$this->input->post('site_id'));
					
					$data['url'] = $url;
					$data['created'] = time();
					
					$sitePageID = $this->Global_model->insert("site_pages",$data);
					if(is_int($sitePageID)) {
						$this->messages->add($this->lang->line('page_add_success'), 'success');
					}else{
						$this->messages->add($this->lang->line('page_add_error'), 'error');
					}
				}
			}else{
				//no access
				redirect("admin/noaccess/");
			}
			
			//redirect 
			if($sitePageID)
				redirect("admin/content/edit/".$sitePageID);
		}
		
		$layoutData = array();
		
		$form = $this->Page_model->getSingle(array("site_page_id"=>$sitePageID));
		
		//security check
		if(!$this->User_model->securityCheck($user['user_id'],$form['site_id'])) {
			redirect("admin/noaccess/");
		}
		
		$form['sites'] = $this->Site_model->getAll();
		
		$layoutData['content'] = $this->load->view('admin/content/edit',$form,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function add()
	{
		$layoutData = array();
		$form['sites'] = $this->Site_model->getAll();
		$form['site_id'] = $this->Site_model->getSiteID();
		$layoutData['content'] = $this->load->view('admin/content/edit',$form,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function getimages()
	{
		$site_info = $this->Site_model->getSingle( array('site_id'=>$this->session->userdata('siteID') ));
		
		//get templates
		$layoutData['photos'] = $this->Photo_model->getAll($site_info['license']);
		
		$photo_list = $this->load->view('admin/content/photos',$layoutData,true);
		$this->output->set_output($photo_list);
	}
	
	public function delete()
	{
		$site_page_id = $this->uri->segment(4);
		$user = $this->session->userdata('user_info');
		$page = $this->Page_model->getSingle(array("site_page_id"=>$site_page_id));
		if(!$this->User_model->securityCheck($user['user_id'],$page['site_id'])) {
			redirect("admin/noaccess/");
		}
		if($this->Global_model->delete("site_pages",array('site_page_id'=>$site_page_id))) {
			$this->messages->add($this->lang->line('page_delete_success'), 'success');
		}else
			$this->messages->add($this->lang->line('page_delete_error'), 'error');
		redirect("admin/content/");
	}
}