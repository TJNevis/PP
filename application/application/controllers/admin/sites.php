<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sites extends PP_Controller {

	function __construct(){
		
		parent::__construct();
		if(!$this->session->userdata('logged_in') && $this->uri->segment(2) != "login"){
        	redirect('admin/login');
		}
		
		$user = $this->session->userdata('user_info');
		$access = $this->config->item('access');
		
		if(!in_array("sites",$access[$user['type']])) {
			redirect("admin/noaccess/");
		}

		$this->load->helper('image');
        $this->load->model('Site_model');
        $this->load->model('Global_model');
        $this->load->model('Page_model');
        $this->load->model('User_model');
        $this->load->model('Template_model');
        $this->load->model('Banner_model');
	}
	
	public function index()
	{
		$layoutData = array();
		
		$user = $this->session->userdata('user_info');
		if($user['type']=="super_admin" || $user['type']=="pp_admin")
			$layoutData['sites'] = $this->Site_model->getAll();
		else {
			$layoutData['sites'] = $this->Site_model->getAll(array('site_id'=>$user['site_id']));
			redirect('/admin/sites/edit/'.$user['site_id']);	
		}

		
			
		$layoutData['content'] = $this->load->view('admin/sites/index',$layoutData,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function edit()
	{
			
		if($this->input->post('site_id')){
			$siteID = $this->input->post('site_id');
		}else if($this->uri->segment(4)){
			$siteID = $this->uri->segment(4);
		}else{
			$siteID = "";
		}
		
		$user = $this->session->userdata('user_info');
		$site_info = $this->Site_model->getSingle(array('site_id'=>$siteID));
		
		
		if($this->User_model->securityCheck($user['user_id'],$siteID)) {
			if($this->input->post('banner_type')) {
				
				//upload banner
				$bannerName = "";
				if(isset($_FILES['banner_file']) && $_FILES['banner_file']['size'] > 0) {
					$fileExt = end(explode('.', $_FILES['banner_file']['name']));
					$bannerName = md5(time()).".".$fileExt;
					
					$bannerPathTemp = $this->config->item('serverPath')."/temp/".$bannerName;
		
					$bannerAction = move_uploaded_file($_FILES['banner_file']['tmp_name'], $bannerPathTemp);
					
					if ($bannerAction) {
						system("chmod 644 $bannerPathTemp");
					} else {
						$this->messages->add($this->lang->line('site_image_error'), 'error');
					}
				}else{
					
				}
				
				//upload logo
				$logoName = "";
				if(isset($_FILES['logo']) && $_FILES['logo']['size'] > 0) {
					$fileExt = end(explode('.', $_FILES['logo']['name']));
					$logoName = md5(time()).".".$fileExt;
					
					$logoPathTemp = $this->config->item('serverPath')."/temp/".$logoName;
		
					if (move_uploaded_file($_FILES['logo']['tmp_name'], $logoPathTemp)) {
						createThumbJpg($logoPathTemp,$logoPathTemp,$this->config->item('logoWidth'),$this->config->item('logoHeight'));
						system("chmod 644 $logoPathTemp");
					} else {
						$this->messages->add($this->lang->line('site_image_error'), 'error');
					}
				}
				
				error_log(print_r($this->input->post('banner_item_check'),1));
				
				if(is_array($this->input->post('banner_item_check'))) {
					$banner_id = implode(",",$this->input->post('banner_item_check'));
				}else{
					$banner_id = $this->input->post('banner_id');
				}
				
				//update db
				if($user['type']=="super_admin") {
					$data = array(
						"name"=>$this->input->post('name'),
						"license"=>$this->input->post('license'),
						"domain"=>$this->input->post('domain'),
						"commerce_url"=>$this->input->post('commerce_url'),
						"affiliate_code"=>$this->input->post('affiliate_code'),
						"facebook_link"=>$this->input->post('facebook_link'),
						"twitter_link"=>$this->input->post('twitter_link'),
						"contact_email"=>$this->input->post('contact_email'),
						"contact_phone"=>$this->input->post('contact_phone'),
						"pet_owner_module"=>$this->input->post('pet_owner_module'),
						"banner_type"=>$this->input->post('banner_type'),
						"template_id"=>$this->input->post('template_id'),
						"banner_id"=>$banner_id,
						"banner_text"=>$this->input->post('banner_text')
					);
				}else{
				
					$data = array(
						"banner_type"=>$this->input->post('banner_type'),
						"template_id"=>$this->input->post('template_id'),
						"banner_id"=>$banner_id,
						"banner_text"=>$this->input->post('banner_text')
					);
				}
				
				if($bannerName) {
					$data['banner_file']=$bannerName;
				}
				
				if($logoName) {
					$data['logo']=$logoName;
				}
				
				if($siteID) {
					//update
					if($this->Global_model->update("sites",$data,array("site_id"=>$siteID))){
						$this->messages->add($this->lang->line('site_update_success'), 'success');
					}else
						$this->messages->add($this->lang->line('site_update_error'), 'error');
				}else{
					//new
					$data['created'] = time();
					$siteID = $this->Global_model->insert("sites",$data);
					if(is_int($siteID)) {
						$this->messages->add($this->lang->line('site_add_success'), 'success');
						
						//add default pages
						$this->Page_model->addNewPages($siteID,$this->input->post('license'));
					}else{
						$this->messages->add($this->lang->line('site_add_error'), 'error');
					}
						
	
				}
				
				//create site media folder
				$siteFolder = $this->config->item('serverPath')."/images/".$siteID;
				if(!is_dir($siteFolder)) {
					mkdir($siteFolder);
				}
				
				//move banner file
				if($bannerName) {
					$bannerPath = $siteFolder."/".$bannerName;
					rename($bannerPathTemp, $bannerPath);
				}
				
				
				
				//move logo file
				if($logoName) {
					$logoPath = $siteFolder."/".$logoName;
//					error_log($logoPathTemp);
//					error_log($logoPath);
					rename($logoPathTemp, $logoPath) or die("Unable to rename $logoPathTemp to $logoPath.");
					
				}
				
				//redirect 
				if($siteID)
					redirect("admin/sites/edit/".$siteID);
			}
			
			$layoutData = array();
			
			$site = $this->Site_model->getSingle(array('site_id'=>$siteID));
			
			//split up banners if mutiple
			if(strpos($site['banner_id'],",") > 0) {
				$site['banner_id'] = explode(",",$site['banner_id']);
			}
			
			//get templates
			$site['templates'] = $this->Template_model->getAll($site_info['license']);
			
			//get banners
			$site['banners'] = $this->Banner_model->getAll($site_info['license']);
			

			$layoutData['content'] = $this->load->view('admin/sites/edit',$site,true);
				
			$this->load->view('layouts/admin',$layoutData);
		}else{
			//no access
			redirect("admin/noaccess/");
		}
	}
	
	public function add()
	{
		$layoutData = array();
		$site = "";

		//get templates
		$site['templates'] = $this->Template_model->getAll('basic');
		
		//get banners
		$site['banners'] = $this->Banner_model->getAll('basic');

		$site['license'] = 'basic';
		
		$layoutData['content'] = $this->load->view('admin/sites/edit',$site,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function delete()
	{
		$site_id = $this->uri->segment(4);
		
		$user = $this->session->userdata('user_info');
		if(!$this->User_model->securityCheck($user['user_id'],$site_id)) {
			redirect("admin/noaccess/");
		}
		
		if($this->Global_model->delete("sites",array('site_id'=>$site_id)) && $this->Global_model->delete("site_pages",array('site_id'=>$site_id))) {
			$this->messages->add($this->lang->line('site_delete_success'), 'success');
		}else
			$this->messages->add($this->lang->line('site_delete_error'), 'error');
		redirect("admin/sites/");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */