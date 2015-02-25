<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pet extends PP_Controller {

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
        $this->load->model('Pet_model');
        $this->load->model('Api_model');
	}
	
	public function index()
	{
		
		$layoutData = array();
		
		if($this->uri->segment(3)) {
			$orderID = $this->uri->segment(3);
			//if order id is provided then get that order
			$url = $this->config->item('apiUrl')."/orders/info/".$this->uri->segment(3);
			$pet = json_decode($this->Api_model->get($url),true);
		}else{
			//else get latest
			$petListUrl = $this->config->item('apiUrl')."/orders/";
			$petList = json_decode($this->Api_model->get($petListUrl), true);
			
			$orderID = $petList[0]['orderID'];
			
			$petUrl = $this->config->item('apiUrl')."/orders/info/$orderID";
			$pet = json_decode($this->Api_model->get($petUrl), true);
		}

		$layoutData['orderID'] = $orderID;
		$layoutData['pet'] = $pet;
		$layoutData['petStatusMessage'] = $this->Pet_model->getPetStatus($layoutData['pet']);
		$layoutData['tabs'] = true;
		$layoutData['content'] = $this->load->view('owner/pet/index',$layoutData,true);
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function all()
	{
		$layoutData = array();
		
		//get pet list
		$url = $this->config->item('apiUrl')."/orders/";
		$pet = $this->Api_model->get($url);
		
		$layoutData['pets'] = $this->Pet_model->addCurrentPetFlag(json_decode($pet,true));

		
		
		$layoutData['tabs'] = true;
		$layoutData['content'] = $this->load->view('owner/pet/list',$layoutData,true);
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
}
