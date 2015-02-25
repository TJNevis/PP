<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pet_tales extends PP_Controller {

	function __construct(){
		parent::__construct();
	
		if( isset($_GET['embed']) && $_GET['embed']=="true"){
			$this->session->set_userdata('embed',true);
		}

		$this->load->model('Site_model');
		$this->load->model('Page_model');
		$this->load->model('Story_model');
		$this->load->model('Mail_model');
	}
	
	public function index()
	{
		$this->load->model('Geo_model');
                $this->Geo_model->checkIP();

		$layoutData = array();

		//load the current page
		$page = $this->Page_model->loadPageByUri("pet-tales");
		
		//load navigation
		$layoutData['navigation'] = $this->Page_model->getNav();
		
		//load the view
		$layoutData['content'] = "";
		
		//page info
		$layoutData['page_info'] = $page;
		
		//load pet tales
		$petTales = $this->Story_model->getSingle($this->uri->segment(2));

		//get id of previous pet tale
		$petTales['story_next'] = $this->Story_model->getNextPrev($petTales['story_id'],'next');
		
		//check if there is any story media
		$siteID = $this->Site_model->getPublicSiteID();
		
		$petTaleMedia = $this->Story_model->getStoryMedia($petTales['story_id']);
		
		//randomize music
		if($petTales['story_music']) {
			$randMusic = rand(1,6);
			$petTales['story_music_file'] = "/media/$randMusic.mp3";
		}else{
			$petTales['story_music_file'] = "";
		}
		
		if($petTaleMedia) {
			$petTales['media_list'] = $petTaleMedia;
			$mediaPlayer = $this->load->view('pet_tales/media',$petTales,true);
			$petTales['story_media'] = $mediaPlayer;
			
			//get first image
			foreach($petTaleMedia as $ptm) {
				if($ptm['media_type']=='image') {
					$mediaPath = $this->config->item('serverPath')."/".$this->config->item('mediaBaseFolder')."/".$this->config->item('storyBaseFolder');
					$mediaFile = $ptm['media_file'];
					if(!file_exists("$mediaPath/{$petTales['story_id']}/$mediaFile")) {
						$mediaFile = strtolower($mediaFile);
					}
					if(!file_exists("$mediaPath/{$petTales['story_id']}/$mediaFile")) {
						$mediaFile = strtoupper($mediaFile);
					}
					
					$petTales['story_image'] = "/".$this->config->item('mediaBaseFolder')."/".$this->config->item('storyBaseFolder')."/{$petTales['story_id']}/$mediaFile";
				}
			}
		}
		
		//if no pet tale image show default
		if(!isset($petTales['story_image']) || !$petTales['story_image']){
			$petTales['story_image'] = $this->config->item('defaultStoryImage');
		}

		//facebook meta info
		$layoutData['facebook_title'] = $this->lang->line('story_default_facebook_title').$petTales['story_pet_name'];
		$layoutData['facebook_description'] = $this->lang->line('story_default_facebook_description').$petTales['story_pet_name'];

		$layoutData['facebook_url'] = "http://".$_SERVER['HTTP_HOST']."/pet-tales/".$petTales['story_id'];
		
		$petTales['share_title'] = $this->lang->line('story_default_facebook_title').$petTales['story_pet_name'];
		$petTales['share_url'] = "http://".$_SERVER['HTTP_HOST']."/pet-tales/".$petTales['story_id'];
		$petTales['share_description'] = $this->lang->line('story_default_facebook_description').$petTales['story_pet_name'];
		
		foreach($petTaleMedia as $m) {
			if($m['media_type']=='image') {
				$layoutData['facebook_image'] = 'http://content.petpassages.com/images/story/'.$m['story_id'].'/'.$m['media_file'];
				$petTales['share_image'] = 'http://content.petpassages.com/images/story/'.$m['story_id'].'/'.$m['media_file'];
				break;
			}
		}

		if($this->uri->segment(2)) {
			//get candles
			$petTales['gifts'] = $this->Story_model->getGifts();
			
			//load pet tale viewer
			$layoutData['content'] .= $this->load->view('pet_tales/view',$petTales,true);
		}else{
			//load pet tale list
			$petTales = $this->Story_model->getFeaturedTales();

			if($petTales)
				$layoutData['featuredTales'] = json_encode( $this->Story_model->getFeaturedTales() );
			else
				$layoutData['featuredTales']=false;
			
			//load locations
			if($this->Site_model->getPublicSiteID()==1) {
				$layoutData['locations'] = $this->Site_model->getAll();
			}else{
				$layoutData['locations'] = array(
					0=>array('site_id'=>$siteID,'name'=>$this->session->userdata('name'))
				);
			}
			
			$layoutData['content'] .= $this->load->view('pet_tales/list',$layoutData,true);			
		}
		if($this->session->userdata('embed')==true)
			$this->load->view('layouts/embed',$layoutData);
		else
			$this->load->view('layouts/main',$layoutData);
	}

	function ajax_get_tales() {
		$sort = $this->input->post('sort');
		$location = $this->input->post('taleLocation');		
		$keyword = $this->input->post('keyword');
		$petTales = $this->Story_model->search($sort,$location,$keyword);

		error_log(print_r($petTales,1));

		if($petTales)
			$return = json_encode( $petTales );
		else
			$return = '';
		echo $return;
	}
	
	public function unsubscribe() {
		$storyID = $this->uri->segment(3);
		
		//unsubscribe
		if($this->input->get('h')) {
			$this->Story_model->updateSubscriber( array('subscriber_hash'=>$this->input->get('h'),'story_id'=>$storyID),array('deleted'=>1,'subscriber_status'=>'unsubscribed') );
		}
		
		redirect("/pet-tales/$storyID#unsubscribe");
	}
	
	public function search() {
		$user = $this->session->userdata('user_info');
		$layoutData['tales'] = $this->Story_model->getAllActiveTales();
		
		//load navigation
		$layoutData['navigation'] = $this->Page_model->getNav();
		
		//page info
		$layoutData['page_info']['title'] = 'Search for Pet Tales';
		
		$layoutData['content'] = $this->load->view('pet_tales/search',$layoutData,true);
		$this->load->view('layouts/main',$layoutData);
	}

	public function share() {
		//load pet tales
		$petTale = $this->Story_model->getSingle($this->uri->segment(3));
		$petTale['form'] = true;
		
		if($this->input->post('tale_email_from')) {
			//send pet tale
			
			$message = $this->input->post('tale_email_message')."\r\n\r\n";
			$message .= $this->input->post('tale_title')."\r\n";
			$message .= "Pet Name: ".$this->input->post('tale_pet')."\r\n";
			$message .= "Pet Tale Author: ".$this->input->post('tale_author')."\r\n";
			
			$license = $this->session->userdata('license');

			switch($license){
				case "basic":
					$siteID = $this->session->userdata('siteID');
					$message .= "Link: http://".APPLICATION_BASE_URL."/pet-tales/".$this->input->post('tale_id')."?lid=$siteID\r\n";
					break;
				default:
					$domain = $_SERVER['SERVER_NAME'];
					$message .= "Link: http://".$domain."/pet-tales/".$this->input->post('tale_id')."\r\n";
			}

			
			
			$to = $this->input->post('tale_email_to');
			
			if($this->input->post('tale_ccfrom_check'))
				$to .= ",".$this->input->post('tale_email_from');
				
			$from = $this->input->post('tale_email_from');
			
			$subject = $this->lang->line('story_share_email_subject').$this->input->post('tale_title');
			
			if($this->Mail_model->sendEmail($to,$from,$subject,$message))
				$this->messages->add($this->lang->line('story_share_success'), 'success');
			else
				$this->messages->add($this->lang->line('story_share_error'), 'error');
			
			$petTale['form'] = false;
		}
		
		//load pet tale viewer
		$layoutData=array();
		
		//load navigation
		$layoutData['navigation'] = $this->Page_model->getNav();
		
		//page info
		$layoutData['page_info']['title'] = 'Share a Pet Tale';
		
		$layoutData['content'] = $this->load->view('pet_tales/share',$petTale,true);
		$this->load->view('layouts/main',$layoutData);
	}
	
	public function playlist() {
		//get story id
		$story['media'] = $this->Story_model->getStoryMedia($this->uri->segment(3));

		
		//load xml
		$this->load->view('pet_tales/playlist',$story);
	}
	
	public function addmessage(){
		if(is_numeric($this->input->post('story_id'))) {
			
			
			$data = array(
				'story_id' => $this->input->post('story_id'),
				'tribute_message' => $this->input->post('pet_tale_message'),
				'tribute_name' => $this->input->post('pet_tale_message_name'),
				'tribute_email' => $this->input->post('pet_tale_message_email'),
				'tribute_media' => $this->input->post('pet_tale_message_media'),
				'tribute_type' => $this->input->post('pet_tale_message_type'),
				'tribute_status' => 'pending',
				'tribute_ip' => $_SERVER['REMOTE_ADDR']
			);
			
			$message_id = $this->Story_model->insertStoryMessage($data);
			
			if($message_id){
				$this->Story_model->emailStoryOwner($this->input->post('story_id'),$message_id);
				echo 1;
			}
		}
	}
	
	public function addsubscriber(){
		if(is_numeric($this->input->post('story_id'))) {
			$data = array(
				'story_id' => $this->input->post('story_id'),
				'subscriber_name' => $this->input->post('pet_tale_subscribe_name'),
				'subscriber_email' => $this->input->post('pet_tale_subscribe_email'),
				'subscriber_status' => 'active',
				'subscriber_hash' => md5($this->input->post('pet_tale_subscribe_email').time()),
				'subscriber_ip' => $_SERVER['REMOTE_ADDR']
			);
			if($this->Story_model->insertStorySubscriber($data)){
				echo 1;
			}
		}
	}

	public function add() {
		$this->load->library('recaptcha');
		$err=false;
		
		//form layout data
		$data = array();
		$data['form'] = true;
		
		//save pet tale if post
		if($this->input->post('tale_owner_first')) {

			$this->recaptcha->recaptcha_check_answer();

			if($this->recaptcha->getIsValid()){
				
				//insert tale info
				$taleData = array();
				$taleData['story_author_first'] = $this->input->post('tale_owner_first');
				$taleData['story_author_last'] = $this->input->post('tale_owner_last');
				$taleData['story_email'] = $this->input->post('tale_owner_email');
				$taleData['story_city'] = $this->input->post('tale_owner_city');
				$taleData['story_state'] = $this->input->post('tale_owner_state');
				$taleData['story_pet_name'] = $this->input->post('tale_pet_name');
				$taleData['story_pet_birthday'] = $this->input->post('tale_pet_birthday');
				$taleData['story_pet_passdate'] = $this->input->post('tale_pet_datepassed');
				$taleData['story_title'] = $this->input->post('tale_title');
				$taleData['story_body'] = $this->input->post('tale_pet_story');
				if($this->input->post('music_check'))
					$taleData['story_music'] = 1;
				$taleData['story_created'] = time();
				$taleData['site_id'] = $this->Site_model->getSiteID();
				$storyID = $this->Global_model->insert("story",$taleData);
				
				if(!$storyID)
					$err=true;
				
				//insert tale media
				$path = $this->config->item('serverPath')."/".$this->config->item('mediaBaseFolder')."/".$this->config->item('storyBaseFolder');
				$tempPath = $this->config->item('serverPath')."/temp";
				$talePath = $path."/".$storyID;
				
				//create the tale folder
				if(!is_dir($talePath)) {
					mkdir($talePath);
					chmod($talePath,0777);
				}
						
				for($i=0;$i<=10;$i++) {
					if($this->input->post("story_pic$i")) {

						//get file and path
						$file = $this->input->post("story_pic$i");

						//rename the file
						$fileExt = end(explode('.', $file));
						$newFile = strtolower("story_pic$i".".".$fileExt);
						
						//move the file
						//rename($tempPath."/".$file, $talePath."/".$newFile);
			
						
						system("mv $tempPath/$file $talePath/$newFile",$ret);
						
						//insert into db
						$taleMedia = array();
						$taleMedia['story_id'] = $storyID;
						$taleMedia['media_file'] = $newFile;
						$taleMedia['media_type'] = "image";
						$mediaID = $this->Global_model->insert("story_media",$taleMedia);
						if(!$mediaID)
							$err=true;
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
				
				//notify admins email
				$mailDate = date("n/j/Y g:i a T");
				$this->Mail_model->adminMail($this->lang->line('story_new_email_subject'), $message="\r\n$mailDate\r\nWebsite: {$_SERVER['SERVER_NAME']}\r\nPet Name:{$taleData['story_pet_name']}\r\nAuthor Email: {$taleData['story_email']}\r\n".$this->lang->line('story_new_email'));
				
				if(!$err)
					$this->messages->add($this->lang->line('story_created_success'), 'success');
				else
					$this->messages->add($this->lang->line('story_created_error'), 'error');
				
				$data['form'] = false;
			}else{
				$this->messages->add($this->lang->line('story_captcha_error'), 'error');
			}
		}

		$data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();

		//load navigation
		$layoutData['navigation'] = $this->Page_model->getNav();
		
		//page info
		$layoutData['page_info']['title'] = 'Create a Pet Tale';
		
		$layoutData['content'] = $this->load->view('pet_tales/add-new',$data,true);
		$this->load->view('layouts/main',$layoutData);
	}
	
	public function previewemail() {
		$data = array(
			'tribute_message'=>'This is the messages',
			'story_pet_name' => 'Sparky',
			'story_id'=>'387',
			'url'=>'http://petpassages.com',
			'tribute_name'=>'Ivan'
		);
		
		
		$this->load->view('emails/pet_tale_message_update',$data);
	}
	
	public function upload(){
		/**
		 * upload.php
		 *
		 * Copyright 2009, Moxiecode Systems AB
		 * Released under GPL License.
		 *
		 * License: http://www.plupload.com/license
		 * Contributing: http://www.plupload.com/contributing
		 */
		
		// HTTP headers for no cache etc
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		// Settings
		$folderHash = isset($_REQUEST["folderHash"]) && $_REQUEST["folderHash"] =! -1 ? $_REQUEST["folderHash"] : md5(time());
		//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload/$folderHash";
		$targetDir = "/var/www/vhosts/petpassages.com/httpdocs/temp";
		//$targetDir = 'uploads';
		
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
		
		// 5 minutes execution time
		@set_time_limit(5 * 60);
		
		// Uncomment this one to fake upload time
		// usleep(5000);
		
		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
		
		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
		
		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);
		
			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;
		
			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}
		
		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		
		// Create target dir
		if (!file_exists($targetDir))
			@mkdir($targetDir);
		
		// Remove old temp files	
		if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
		
				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
					@unlink($tmpfilePath);
				}
			}
		
			closedir($dir);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			
		
		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
		
		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];
		
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");
		
					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		} else {
			// Open temp file
			$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");
		
				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
		
				fclose($in);
				fclose($out);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}
		
		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off 
			rename("{$filePath}.part", $filePath );
		}
		
		
		// Return JSON-RPC response
		die("$fileName");
	}

}
