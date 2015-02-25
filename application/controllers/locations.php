<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locations extends PP_Controller {

	function __construct(){
		parent::__construct();
		
		$this->load->model('Site_model');
		$this->load->model('Page_model');
		$this->load->model('Location_model');
		$this->load->model('Mail_model');
	}
	
	public function index()
	{
		$this->load->model('Geo_model');
                $this->Geo_model->checkIP();


		$layoutData = array();

		//load the current page
		$page = $this->Page_model->loadPageByUri("locations");
		
		//get locations
		$siteID = $this->Site_model->getPublicSiteID();
		
		$locations['locations'] = $this->Location_model->getAll(array('locations.site_id'=>$siteID));
		
		//load navigation
		$layoutData['navigation'] = $this->Page_model->getNav();
		
		//load the view
		$layoutData['content'] = $this->load->view('index/index',$page,true);
		
		//page info
		$layoutData['page_info'] = $page;
		
		//load locations map
		$layoutData['content'] .= $this->load->view('locations/location_map',$locations,true);
		
		$this->load->view('layouts/main',$layoutData);
	}
}
