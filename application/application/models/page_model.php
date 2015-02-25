<?php
class Page_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Global_model');
        $this->load->model('Site_model');
    }
    
    function loadPageByUri($uri="/") {	
    	if($uri=='0')
    		$uri='/';
    	
    	$siteID = $this->Site_model->getPublicSiteID();
    	
    	$data = array("url"=>$uri,"site_id"=>$siteID);
    	$page = $this->Global_model->get("site_pages",$data);
    	return $page[0];
    }
    
	function getSingle($where=array()) {
    	return max($this->Global_model->get("site_pages",$where));
    }
    
	function getAll($where=array(),$siteBool=FALSE) {
    	return $this->Global_model->get("site_pages",$where,NULL,NULL,$siteBool);
    }
    
    function verifyUrl($url,$siteID,$counter=0) {
    	if($this->getSingle(array('site_id'=>$siteID,'url'=>$url))) {
    		return verifyUrl($url."-".++$counter,$siteID,$counter++);
    	}else{
    		return $url;
    	}
    }
    
    function getNav() {
    	$siteID = $this->Site_model->getPublicSiteID();
    	$navigation = $this->getAll(array('site_id'=>$siteID,'url !='=>'/' ,'navigation !='=>true));
    	return $navigation;
    }
    
    function addNewPages($siteID,$license) {
    	//get all pages from base page table
    	
    	switch($license){
    		case "basic":
    			$pages = array('/','services','locations','pet-tales');
    			break;
    		case "standard":
    			$pages = array('/','services','locations','grief-support','pet-tales','faq');
    			break;
    		case "professional":
    			$pages = array('/','services','locations','grief-support','pet-tales','faq');
    			break;
    		default:
    			$pages = array('/','services','locations','grief-support','pet-tales','faq');
    	}
    	
    	$defaultPages = $this->Global_model->get('pages');
    	
    	//insert pages for site
    	foreach($defaultPages as $d) {
    		$d['site_id'] = $siteID;
    		if(in_array($d['url'],$pages))
    			$this->Global_model->insert('site_pages',$d);
    	}
    	return true;
    }
}