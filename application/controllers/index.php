<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends PP_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Global_model');
		$this->load->model('Story_model');
		$this->load->model('Page_model');
		$this->load->model('Site_model');
	}
	
	public function index()
	{

// var_dump($this->uri);

		$this->load->model('Geo_model');
		$this->Geo_model->checkIP();
		if(strpos($this->uri->segment(1),"efault") > 0) {
			if(isset($_GET['mode'])) {
				switch($_GET['mode']){
					case 'location':
						redirect('/locations');
						break;
					case 'service':
						redirect('/services');
						break;
					case 'faq':
						redirect('/faq');
						break;
					case 'story':
						$story_id = "";
						if(isset($_GET['storyid']))
							$story_id = $_GET['storyid'];
						redirect("/pet-tales/$story_id");
						break;
					case 'story_view':
						$story_id = "";
						if(isset($_GET['storyid']))
							$story_id = $_GET['storyid'];
						redirect("/pet-tales/$story_id");
						break;
					case 'support':
						redirect('/grief-support');
						break;
					default:
						redirect('/');
				}
			}else{
				redirect('/');
			}
			
		}
		
		
		$layoutData = array();


		if($this->uri->segment(1)=="terms") {
			$page = $this->Global_model->get("pages",array('url'=>'terms'));
			$page = $page[0];
		}else{
			//load the current page
// echo "<pre> loadPageByUri in terms else </pre>";
			$page = $this->Page_model->loadPageByUri($this->uri->segment(1));
		}

		$page['pet_tale_box']="";
		
		//if homepage get pet tale box
		if($page['url']=="/") {
			$petTale = $this->Story_model->getSingle();
			
			//check if there is any story media
			$petTaleMedia = $this->Story_model->getStoryMedia($petTale['story_id']);
			if($petTaleMedia) {
				$petTale['story_image'] = true;
				foreach ($petTaleMedia as $pm) {
					if($pm['media_type']=='image'){
						$petTale['story_image_file']=$pm['media_file'];
					}
				}
			}
			
			//load pet tail box view
			$page['pet_tale_box'] = $this->load->view('pet_tales/small',$petTale,true);
		}
		
		//load navigation
		$layoutData['navigation'] = $this->Page_model->getNav();
		
		//load the view
		//page info
		$layoutData['page_info'] = $page;
		
		$layoutData['content'] = $this->load->view('index/index',$page,true);
		
		$this->load->view('layouts/main',$layoutData);	
	}

	
	public function contact() {
		//$this->load->model('Geo_model');
		//$this->Geo_model->checkIP();

		//load navigation
		$layoutData['navigation'] = $this->Page_model->getNav();

		$contactPhone = ( $this->session->userdata('contact_phone') ) ? $this->session->userdata('contact_phone') : "1-888-831-8711";
		
		//load the view
		//page info
		$page['url']="/contact";
		$page['image']="";
		$page['title']="Contact";

		$page['content'] = str_replace("{phone}", $contactPhone, $this->lang->line('contact_message') );
		$page['form']=true;
		
		//send email
		if($this->input->post('attempted')=='completed') {
			$name = $this->input->post('name');
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');
			$comments = $this->input->post('comments');
			$url = $this->input->post('url');
			
			$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
			$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
			$HTTP_COOKIE = $_SERVER['HTTP_COOKIE'];
			
			$bcc = 'mikeharris@harrisfuneralhome.com';
			
			if($this->Site_model->getPublicSiteID()==1){
				$siteID = $this->input->post('franchisee');
				if($siteID == 'NA') 
				{
					$siteName = "I am not currenly affiliated with any funeral homes.";
					$to = $this->session->userdata('contact_email');
				}else{
					$site = $this->Site_model->getSingle(array('site_id'=>$siteID));
					//error_log(print_r($site,1));
					$siteName = $site['name'];
					$to = $site['contact_email'];
				}
			}else{
				$siteName = $this->session->userdata('name');
				$to = $this->session->userdata('contact_email');
			}
			
			$hrefFound = strpos(strtolower($comments), "a href");  // checks for a URL html style
			$urlFound = strpos(strtolower($comments), "[url"); // checks for a URL message board style
			
			if (($urlFound) || ($hrefFound) || ($url != "")) {  
				echo "YOU HAVE BEEN BLOCKED FROM EMAILING THIS SERVER FOR TRIGGERING OUR SPAMMER TRAP.<br><br>If this is a legitimate request, please call us.<br><br><br><br>";
				mail("www@nextwaveservices.com", "SPY - $SERVER_NAME Contact", "attempted access from\n\nHTTP_USER_AGENT: $HTTP_USER_AGENT\nREMOTE_ADDR: $REMOTE_ADDR", "From: spamtrap@nextwaveservices.com\r\n"."Reply-To: spamtrap@nextwaveservices.com\r\n");
				exit;
			}
			$message = "Name: $name\nPhone: $phone\nEmail: $email\n\nComments:\n$comments\n\nWebsite: $siteName\n\nHTTP_USER_AGENT: $HTTP_USER_AGENT\nREMOTE_ADDR: $REMOTE_ADDR\nHTTP_COOKIE: $HTTP_COOKIE";
			$this->Mail_model->sendEmail($to,$email,$this->lang->line('contact_email_subject'), $message,$bcc);
			
			$completed = "true";
			$page['form']=false;
			$page['content']=$this->lang->line('contact_complete_message');
		}
		
		if($this->Site_model->getPublicSiteID()==1) {
			$page['locations'] = $this->Site_model->getAll();
		}	
		
		$layoutData['page_info'] = $page;
		
		$layoutData['content'] = $this->load->view('contact',$page,true);
		
		$this->load->view('layouts/main',$layoutData);	
	}

	public function test(){
		// $ipAddress = $_SERVER['REMOTE_ADDR'];
		$this->load->model('Geo_model');
		// $lookup = $this->Geo_model->getLocationData($ipAddress);
		// print_r($lookup);
		$this->Geo_model->checkIP();
	}
}
