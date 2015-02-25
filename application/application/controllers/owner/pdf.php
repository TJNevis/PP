<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf extends PP_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('owner_logged_in') && $this->uri->segment(2) != "login"){
        	redirect('owner/login');
		}

        $this->load->model('Api_model');
	}
	
	public function certificate()
	{
		//get order id
		$orderID = $this->uri->segment(4);

		$url = $this->config->item('apiUrl')."/files/cert/".$orderID;
		$certificate = $this->Api_model->get($url);
		$name = "certificate-$orderID.pdf";
		
		$this->load->helper('download');
		force_download($name, $certificate);
	}

}
