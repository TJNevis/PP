<?php

class PP_Controller extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->model('Site_model');
		$this->load->model('Global_model');
		
		//load the current site
		// if($_SERVER['SERVER_NAME'] != 'petpassages.com' && $_SERVER['SERVER_NAME'] != 'www.petpassages.com' && $_SERVER['SERVER_NAME'] != 'national.petpassages.com'){
		// 	$server_name = str_replace("www.","",$_SERVER['SERVER_NAME']);
		// 	$site = $this->Site_model->loadSiteByDomain($server_name);
		// 	if(!$site)
		// 		redirect("http://petpassages.com");
		// }else{
		// 	$site = $this->Site_model->loadSiteByLID(1);
		// }
		
		
	}
}

?>
