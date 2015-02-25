<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locations extends PP_Controller {

	function __construct(){
		
		parent::__construct();
		if(!$this->session->userdata('logged_in') && $this->uri->segment(2) != "login"){
        	redirect('admin/login');
		}
		
		$user = $this->session->userdata('user_info');
		$access = $this->config->item('access');
		if(!in_array("locations",$access[$user['type']])) {
			redirect("admin/noaccess/");
		}

		$this->load->helper('image');
		$this->load->helper('geo');
        $this->load->model('Location_model');
        $this->load->model('Site_model');
        $this->load->model('Global_model');
        $this->load->model('User_model');
	}
	
	public function index()
	{
		$layoutData = array();
		
		$user = $this->session->userdata('user_info');
		if($user['type']=="super_admin" || $user['type']=="pp_admin")
			$layoutData['locations'] = $this->Location_model->getAll(NULL,1);
		else
			$layoutData['locations'] = $this->Location_model->getAll(array('locations.site_id'=>$user['site_id']),1);

		$layoutData['content'] = $this->load->view('admin/locations/index',$layoutData,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function edit()
	{
			
		if($this->input->post('loc_location_id')){
			$loc_location_id = $this->input->post('loc_location_id');
		}else if($this->uri->segment(4)){
			$loc_location_id = $this->uri->segment(4);
		}else{
			$loc_location_id = "";
		}
		
		//get site id
		$site_id = $this->input->post('site_id');
		
		//get user info
		$user = $this->session->userdata('user_info');

		if($this->input->post('loc_name')) {
			//check security
			if($this->User_model->securityCheck($user['user_id'],$site_id)) {
				
				//upload photo
				$fileName = "";
				if(isset($_FILES['loc_pic_path']) && $_FILES['loc_pic_path']['size'] > 0) {
					$fileExt = end(explode('.', $_FILES['loc_pic_path']['name']));
					$fileName = md5(time()).".".$fileExt;
					
					$filePath = $this->config->item('serverPath')."/".$this->config->item('mediaBaseFolder')."/locations/".$fileName;
		
					if (move_uploaded_file($_FILES['loc_pic_path']['tmp_name'], $filePath)) {
						createThumbJpg($filePath,$filePath,$this->config->item('locationImageWidth'),$this->config->item('locationImageHeight'));
						system("chmod 644 $filePath");
					} else {
						$this->messages->add($this->lang->line('location_image_error'), 'error');
					}
				}
				
				//get location
				$geoAddress = $this->input->post('loc_address1').", ".$this->input->post('loc_city').", ".$this->input->post('loc_state')." ".$this->input->post('loc_zip');
				$geo = new geo();
				$coords = $geo->getCoordinates($geoAddress);
				
				//update db
				$data = array(
					"loc_name"=>htmlspecialchars($this->input->post('loc_name')),
					"loc_phone"=>$this->input->post('loc_phone'),
					"loc_address1"=>htmlspecialchars( str_replace("'", "&#39;", $this->input->post('loc_address1'))),
					"loc_address2"=>htmlspecialchars( str_replace("'", "&#39;", $this->input->post('loc_address2'))),
					"loc_city"=>htmlspecialchars($this->input->post('loc_city')),
					"loc_state"=>$this->input->post('loc_state'),
					"loc_zip"=>$this->input->post('loc_zip'),
					"loc_type_web"=>1,
					"loc_lat"=>$coords['lat'],
					"loc_lng"=>$coords['long'],
					"loc_head"=>$this->input->post('loc_head'),
					"site_id"=>$this->input->post('site_id'),
					"loc_body"=>htmlspecialchars($this->input->post('loc_body')),	
					"loc_website"=>$this->input->post('loc_website'),	
					"loc_transfer_fee"=>$this->input->post('loc_transfer_fee'),	
					"loc_notes"=>$this->input->post('loc_notes')
				);
				
				if($fileName)
					$data['loc_pic_path']=$fileName;
				
				
				if($loc_location_id) {
					//update
					if($this->Global_model->update("locations",$data,array("loc_location_id"=>$loc_location_id))){
						$this->messages->add($this->lang->line('location_update_success'), 'success');
						redirect("admin/locations/edit/".$loc_location_id);
					}else
						$this->messages->add($this->lang->line('location_update_error'), 'error');
				}else{
					//add
					
					$data['created'] = time();
					$loc_location_id = $this->Global_model->insert("locations",$data);
					if(is_int($loc_location_id)) {
						$this->messages->add($this->lang->line('location_add_success'), 'success');
						redirect("admin/locations/edit/".$loc_location_id);
					}else
						$this->messages->add($this->lang->line('location_add_error'), 'error');
				}
			}else{
				//no access
				redirect("admin/noaccess/");
			}//end security check
		}
		
		
		
		$layoutData = array();
		$location = $this->Location_model->getSingle(array('loc_location_id'=>$loc_location_id));
		
		if($this->User_model->securityCheck($user['user_id'],$location['site_id'])) {
			$location['sites'] = $this->Site_model->getAll();
			$layoutData['content'] = $this->load->view('admin/locations/edit',$location,true);
			$this->load->view('layouts/admin',$layoutData);
		}else{
			//no access
			redirect("admin/noaccess/");
		}//end security check
	}
	
	public function add()
	{
		$layoutData = array();
		$location = array();
		$location['sites'] = $this->Site_model->getAll();
		$location['site_id'] = $this->Site_model->getSiteID();
		$layoutData['content'] = $this->load->view('admin/locations/edit',$location,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function delete()
	{
		$loc_location_id = $this->uri->segment(4);
		if($this->Global_model->delete("locations",array('loc_location_id'=>$loc_location_id))) {
			$this->messages->add($this->lang->line('location_delete_success'), 'success');
		}else
			$this->messages->add($this->lang->line('location_delete_error'), 'error');
		redirect("admin/locations/");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */