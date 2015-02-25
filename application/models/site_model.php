<?php
class Site_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Global_model');
    }

    function loadSiteByLID($lid) {
    	$data = array("site_id"=>$lid);

    	$site = max($this->Global_model->get("sites",$data));

		$this->session->set_userdata('siteID', $lid);
		$this->session->set_userdata('banner_type', $site['banner_type']);
		$this->session->set_userdata('banner_file', $site['banner_file']);
		$this->session->set_userdata('banner_text', $site['banner_text']);
		$this->session->set_userdata('logo', $site['logo']);
		$this->session->set_userdata('commerce_url', $site['commerce_url']);
		$this->session->set_userdata('template_id', $site['template_id']);
		$this->session->set_userdata('banner_id', $site['banner_id']);
		$this->session->set_userdata('name', $site['name']);
        $this->session->set_userdata('meta_title', $site['meta_title']);
		$this->session->set_userdata('facebook_link', $site['facebook_link']);
		$this->session->set_userdata('twitter_link', $site['twitter_link']);
		$this->session->set_userdata('license', $site['license']);
		$this->session->set_userdata('pet_owner_module', $site['pet_owner_module']);
        $this->session->set_userdata('contact_email', $site['contact_email']);
		$this->session->set_userdata('contact_phone', $site['contact_phone']);
        $this->session->set_userdata('specific_pages_only', $site['specific_pages_only']);
        $this->session->set_userdata('specific_pages_back_link', $site['specific_pages_back_link']);
        $this->session->set_userdata('stripe', $site['stripe']);
        $this->session->set_userdata('stripe_public_key', $site['stripe_public_key']);
        $this->session->set_userdata('sub_domain', $site['sub_domain']);
        $this->session->set_userdata('domain', $site['domain']);
        $this->session->set_userdata('pet_owner_remove_pages', json_decode( $site['pet_owner_remove_pages'],1));
        $this->session->set_userdata('pet_owner_back_text', $site['pet_owner_back_text']);
        $this->session->set_userdata('pet_owner_back_link', $site['pet_owner_back_link']);

    	return $site;
    }

    function loadSiteByDomain($domain) {
    	$data = array("domain"=>$domain);
    	$site = $this->Global_model->get("sites",$data);

        if(!$site){
            $data = array("sub_domain"=>$domain);
            $site = $this->Global_model->get("sites",$data);

            $site = max($site);

            if($site['domain'] && $site['domain'] != $site['sub_domain'] && !$site['embed'] && strpos($_SERVER['REQUEST_URI'], "wner") === false ){
                //error_log("redireting");
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: http://".$site['domain']);
            }
        }else{
            $site = max($site);
        }

        if(!$site){
            return false;
        }



		$this->session->set_userdata('siteID', $site['site_id']);
		$this->session->set_userdata('banner_type', $site['banner_type']);
		$this->session->set_userdata('banner_file', $site['banner_file']);
		$this->session->set_userdata('banner_text', $site['banner_text']);
		$this->session->set_userdata('logo', $site['logo']);
		$this->session->set_userdata('commerce_url', $site['commerce_url']);
		$this->session->set_userdata('template_id', $site['template_id']);
		$this->session->set_userdata('banner_id', $site['banner_id']);
		$this->session->set_userdata('name', $site['name']);
        $this->session->set_userdata('meta_title', $site['meta_title']);
		$this->session->set_userdata('facebook_link', $site['facebook_link']);
		$this->session->set_userdata('twitter_link', $site['twitter_link']);
		$this->session->set_userdata('license', $site['license']);
		$this->session->set_userdata('pet_owner_module', $site['pet_owner_module']);
		$this->session->set_userdata('contact_email', $site['contact_email']);
        $this->session->set_userdata('contact_phone', $site['contact_phone']);
        $this->session->set_userdata('specific_pages_only', $site['specific_pages_only']);
        $this->session->set_userdata('specific_pages_back_link', $site['specific_pages_back_link']);
        $this->session->set_userdata('stripe', $site['stripe']);
        $this->session->set_userdata('stripe_public_key', $site['stripe_public_key']);
        $this->session->set_userdata('sub_domain', $site['sub_domain']);
        $this->session->set_userdata('domain', $site['domain']);
        //$this->session->set_userdata('pet_owner_remove_pages', json_decode( $site['pet_owner_remove_pages']));
        $this->session->set_userdata('pet_owner_back_text', $site['pet_owner_back_text']);
        $this->session->set_userdata('pet_owner_back_link', $site['pet_owner_back_link']);


        $removeOwnerPages = array();
        if($site['pet_owner_remove_pages']){
            $removeOwnerPagesArray = json_decode( $site['pet_owner_remove_pages'],1);
            foreach( $removeOwnerPagesArray['pages'] as $k=>$v){
                $removeOwnerPages[]=$v;
            }
        }

        $this->session->set_userdata('pet_owner_remove_pages', $removeOwnerPages);

    	return $site;
    }

    function getAll($where=array()) {
    	return $this->Global_model->get("sites",$where);
    }

	function getSingle($where=array()) {
    	return max($this->Global_model->get("sites",$where));
    }

    function getSiteID() {
    	if($this->session->userdata('user_info')){
    		$user = $this->session->userdata('user_info');
    		$siteID = $user['site_id'];
    	}elseif($this->session->userdata('siteID')){
    		$siteID = $this->session->userdata('siteID');
    	}else
    		$siteID = 1;

    	return $siteID;
    }

    function getPublicSiteID() {
    	if($this->session->userdata('siteID')){
    		$siteID = $this->session->userdata('siteID');
    	}else
    		$siteID = 1;

    	return $siteID;
    }
}
