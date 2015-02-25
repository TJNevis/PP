<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pet_tales extends PP_Controller {

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
	
	public function index()
	{
		$layoutData = array();
		
		$ownerInfo = $this->session->userdata('owner_info');
		error_log("OWNERID:".$ownerInfo['owner_id']);
		$layoutData['tales'] = $this->Story_model->getAll(array('story.story_pet_owner_id'=>$ownerInfo['owner_id']),true,true);
		$layoutData['tabs'] = true;
		$layoutData['content'] = $this->load->view('owner/pet-tales/index',$layoutData,true);
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function edit()
	{
		if($this->uri->segment(4)){
			$storyID = $this->uri->segment(4);
		}else{
			$storyID = "";
		}
		
		//get logged in user info
		$owner = $this->session->userdata('owner_info');
		
		//security check
		if( $storyID && !$this->Story_model->checkOwnerAccess($owner['owner_id'],$storyID) )
			redirect('/owner/noaccess');
		
		//get site id
		$siteID = $this->Site_model->getSiteID();
			
		//save/insert if post
		if($this->input->post('story_author_first')) {

			$storyMusic = ($this->input->post('story_music')) ? 1 : 0;

			//prepare data for db
			$data = array(
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
				"story_music"=>$this->input->post('story_music'),
				"story_pet_owner_id"=>$owner['owner_id']
			);

			//check to see if we add or just edit
			if($storyID) {
				//update
				if($this->Global_model->update("story",$data,array("story_id"=>$storyID))){
					$this->messages->add($this->lang->line('story_update_success'), 'success');
				}else
					$this->messages->add($this->lang->line('story_update_error'), 'error');
			}else{
				//new
				$data['story_created'] = time();
				$data['site_id'] = $siteID;
				$data['story_active'] = 0;
				
				$storyID = $this->Global_model->insert("story",$data);
				if(is_int($storyID)) {
					$this->messages->add($this->lang->line('story_add_success'), 'success');
					$mailDate = date("n/j/Y g:i a T");
					$this->Mail_model->adminMail($this->lang->line('story_new_email_subject'), $message="\r\n$mailDate\r\nWebsite: {$_SERVER['SERVER_NAME']}\r\nPet Name:{$data['story_pet_name']}\r\nAuthor Email: {$data['story_email']}\r\n".$this->lang->line('story_new_email'));
			
				}else{
					$this->messages->add($this->lang->line('story_add_error'), 'error');
				}
			}
			
			//update message status
			$this->Story_model->updateStoryMessages($storyID,$this->input->post('tribute_active'),'active');
			
			
			
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
					$fileName = "story_pic$i.".$fileExt;
					
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
			
			//redirect 
			if($storyID)
				redirect("owner/pet-tales/edit/".$storyID);
		}
		
		$layoutData = array();
		$layoutData['tabs'] = true;
		$layoutData['site_id'] = $siteID;
		
		if($storyID) {
			$form = array_merge($this->Story_model->getAdminSingle(array('story_id'=>$storyID)),$layoutData);
			$form['tributes'] = $this->Story_model->getStoryMessages($storyID);
		}else
			$form = $layoutData;
		
		$form['images'] = $this->Story_model->getStoryMedia($storyID);
		$layoutData['content'] = $this->load->view('owner/pet-tales/edit',$form,true);
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function add()
	{
		$layoutData = array();
		$user = $this->session->userdata('user_info');
		$form['site_id'] = $user['site_id'];
		$form['sites'] = $this->Site_model->getAll();
		$layoutData['content'] = $this->load->view('admin/pet-tales/edit',$form,true);
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
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
