<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pet_tales extends PP_Controller {

	function __construct(){
		
		parent::__construct();
		if(!$this->session->userdata('logged_in') && $this->uri->segment(2) != "login"){
        	redirect('admin/login');
		}
		$user = $this->session->userdata('user_info');
		$access = $this->config->item('access');
		if(!in_array("pet-tales",$access[$user['type']])) {
			redirect("admin/noaccess/");
		}

        $this->load->model('Story_model');
        $this->load->model('Global_model');
        $this->load->model('User_model');
	}
	
	public function index()
	{
		$layoutData = array();
		
		$user = $this->session->userdata('user_info');
		if($user['type']=="super_admin" || $user['type']=="pp_admin")
			$layoutData['tales'] = $this->Story_model->getAll(NULL,true);
		else
			$layoutData['tales'] = $this->Story_model->getAll(array('story.site_id'=>$user['site_id']),true);
			
		$layoutData['content'] = $this->load->view('admin/pet-tales/index',$layoutData,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function edit()
	{

		if($this->input->post('story_id')){
			$storyID = $this->input->post('story_id');
		}else if($this->uri->segment(4)){
			$storyID = $this->uri->segment(4);
		}else{
			$storyID = "";
		}
		
		//get logged in user info
		$user = $this->session->userdata('user_info');
				
			//save/insert if post
			if($this->input->post('story_author_first')) {
						
				//get site id
				$siteID = $this->input->post('site_id');
				
				$storyMusic = ($this->input->post('story_music')) ? 1 : 0;


	
				//prepare data for db
				$data = array(
					"site_id"=>$siteID,
					"story_active"=>$this->input->post('story_active'),
					"story_author_first"=>$this->input->post('story_author_first'),
					"story_author_last"=>$this->input->post('story_author_last'),
					"story_email"=>$this->input->post('story_email'),
					"story_city"=>$this->input->post('story_city'),
					"story_state"=>$this->input->post('story_state'),
					"story_pet_name"=>$this->input->post('story_pet_name'),
					"story_pet_passdate"=>$this->input->post('story_pet_passdate'),
					"story_pet_birthday"=>$this->input->post('story_pet_birthday'),
					"story_title"=>$this->input->post('story_title'),
					"story_body"=>$this->input->post('story_body'),
					"story_music"=>$this->input->post('story_music')
				);
	
				if($storyID) {
					//get previous status
					$previousStoryValues = $this->Story_model->getAdminSingle(array('story_id'=>$storyID));

					//update
					if($this->Global_model->update("story",$data,array("story_id"=>$storyID))){
						$this->messages->add($this->lang->line('story_update_success'), 'success');
					}else
						$this->messages->add($this->lang->line('story_update_error'), 'error');

					if($previousStoryValues['story_active']==0 && $data['story_active'] == '-1'){
						$this->Story_model->sendApprovalToOwner($storyID);
					}
				}else{
					//new
					$data['story_created'] = time();
					
					$storyID = $this->Global_model->insert("story",$data);
					if(is_int($storyID)) {
						$this->messages->add($this->lang->line('story_add_success'), 'success');
						if($data['story_active'] == '-1'){
							$this->Story_model->sendApprovalToOwner($storyID);
						}
					}else{
						$this->messages->add($this->lang->line('story_add_error'), 'error');
					}

				}
				
				if($this->User_model->securityCheck($user['user_id'],$siteID)) {
					//update message status
					$this->Story_model->updateStoryMessages($storyID,$this->input->post('tribute_active'),'active');
					
					//delete story messages 
					$this->Story_model->deleteStoryMessages($storyID,$this->input->post('tribute_delete'));
					
					//insert tale media
					$path = $this->config->item('serverPath')."/".$this->config->item('mediaBaseFolder')."/".$this->config->item('storyBaseFolder');
					$tempPath = $this->config->item('serverPath')."/temp";
					$talePath = $path."/".$storyID;
					
					//create the tale folder
					if(!is_dir($talePath)) {
						//mkdir($talePath);
						system("mkdir $talePath");
						system("chmod 777 $talePath");
						//error_log("chmod".system("chmod 777 $talePath"));
					}
		
					//delete existing images
					$this->Global_model->delete("story_media",array("story_id"=>$storyID));
					
					//add new images
					for($i=1;$i<=11;$i++) {
						if(isset($_FILES["image-$i"]) && $_FILES["image-$i"]['size'] > 0) {
		
							//upload photo
							$fileName = "";
							$fileExt = end(explode('.', $_FILES["image-$i"]['name']));
							$fileName = strtolower( "story_pic$i.".$fileExt );
							
							$filePath =$path."/".$storyID."/".$fileName;
				
							if (move_uploaded_file($_FILES["image-$i"]['tmp_name'], $filePath)) {
								//createThumbJpg($filePath,$filePath,$this->config->item('locationImageWidth'),$this->config->item('locationImageHeight'));
								system("chmod 644 $filePath");
							} else {
								$this->messages->add($this->lang->line('story_image_error'), 'error');
							}
						
							//insert into db
							$taleMedia = array();
							$taleMedia['story_id'] = $storyID;
							$taleMedia['media_file'] = $fileName;
							$taleMedia['media_type'] = "image";
							$mediaID = $this->Global_model->insert("story_media",$taleMedia);
							if(!$mediaID)
								$err=true;
						}else{
							// reinsert current image
							if(strlen($this->input->post("image-current-$i")) > 1 && $this->input->post("image-delete-$i") != 'true' ) {
								//insert into db
								$taleMedia = array();
								$taleMedia['story_id'] = $storyID;
								$taleMedia['media_file'] = $this->input->post("image-current-$i");
								$taleMedia['media_type'] = "image";
								$mediaID = $this->Global_model->insert("story_media",$taleMedia);
								if(!$mediaID)
									$err=true;
							}
						}
					}
					
					//save youtube
					if($this->input->post('story_youtube')) {
						$taleMedia = array();
						$taleMedia['story_id'] = $storyID;
						$taleMedia['media_file'] = $this->input->post('story_youtube');
						$taleMedia['media_type'] = "youtube";
						$mediaID = $this->Global_model->insert("story_media",$taleMedia);
					}

					//send approval email
					
					
					//redirect 
					if($storyID)
						redirect("admin/pet-tales/edit/".$storyID);
				}else{
					//no access
					redirect("admin/noaccess/");
				}
			}
			
			$layoutData = array();
			
			$form = array_merge($this->Story_model->getAdminSingle(array('story_id'=>$storyID)),$layoutData);
			
			//security check
			if(!$this->User_model->securityCheck($user['user_id'],$form['site_id'])) {
				redirect("admin/noaccess/");
			}
			
			$form['tributes'] = $this->Story_model->getStoryMessages($storyID);
			$form['sites'] = $this->Site_model->getAll();
			$form['images'] = $this->Story_model->getStoryMedia($storyID);

			
			
			$layoutData['content'] = $this->load->view('admin/pet-tales/edit',$form,true);
			$this->load->view('layouts/admin',$layoutData);
	}
	
	public function add()
	{
		$layoutData = array();
		$user = $this->session->userdata('user_info');
		$form['site_id'] = $user['site_id'];
		$form['sites'] = $this->Site_model->getAll();
		$layoutData['content'] = $this->load->view('admin/pet-tales/edit',$form,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function massupdate() {
		$user = $this->session->userdata('user_info');
		$access = $this->config->item('access');
		if(!in_array("pet-tales-mass-update",$access[$user['type']])) {
			redirect("admin/noaccess/");
		}
		
		if($this->input->post('completed')){
			//delete stories
			if($this->input->post('story_delete')) {
				foreach($this->input->post('story_delete') as $key=>$val)
					$this->Global_model->update("story",array('deleted'=>1),array("story_id"=>$val));
			}
			
			//activate stories
			if($this->input->post('story_active')) {
				foreach($this->input->post('story_active') as $key=>$val)
					$this->Global_model->update("story",array('story_active'=>-1),array("story_id"=>$val));
			}
			
			//delete tributes
			if($this->input->post('tribute_delete')) {
				foreach($this->input->post('tribute_delete') as $key=>$val)
					$this->Global_model->update("story_tributes",array('deleted'=>1),array("tribute_id"=>$val));
			}
			
			//activate tributes
			if($this->input->post('tribute_active')) {
				foreach($this->input->post('tribute_active') as $key=>$val)
					$this->Global_model->update("story_tributes",array('tribute_status'=>'active'),array("tribute_id"=>$val));
			}
		}

		
		$form['stories'] = $this->Story_model->getAll(array('story_active'=>0),false);
		$form['tributes'] = $this->Story_model->getUnApprovedMessages();
		//error_log(print_r($form['tributes'],1));
		$layoutData['content'] = $this->load->view('admin/pet-tales/mass_update',$form,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function delete()
	{
		$storyID = $this->uri->segment(4);
		
		//get story
		$story = $this->Story_model->getAdminSingle(array('story_id'=>$storyID));
		
		//get logged in user
		$user = $this->session->userdata('user_info');
		
		//security check
		if(!$this->User_model->securityCheck($user['user_id'],$story['site_id'])) {
			redirect("admin/noaccess/");
		}
		
		
		if($this->Global_model->delete("story",array('story_id'=>$storyID)) && $this->Global_model->delete("story_media",array('story_id'=>$storyID))) {
			
			$this->messages->add($this->lang->line('story_delete_success'), 'success');
		}else
			$this->messages->add($this->lang->line('story_delete_error'), 'error');
		redirect("admin/pet-tales/");
	}
}
