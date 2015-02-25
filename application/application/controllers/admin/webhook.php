<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webhook extends PP_Controller {

	function __construct(){
		
		parent::__construct();
		if(!$this->session->userdata('logged_in') && $this->uri->segment(2) != "login"){
        	redirect('admin/login');
		}
		
		$user = $this->session->userdata('user_info');
		$access = $this->config->item('access');
		
		if(!in_array("sites",$access[$user['type']])) {
			redirect("admin/noaccess/");
		}

	}

	public function stripe() {
		$siteID = $this->input->get('state');
		$code = $this->input->get('code');
		$error = $this->input->get('error');

		if($code && $siteID){
			if(!$error){
				//get access token
				$url = "https://connect.stripe.com/oauth/token";
				$this->curl->create($url);

				//Options
				$post = array(
					'client_secret'=>$this->config->item('stripe_live_private_key'),
					'code'=>$code,
					'grant_type'=>"authorization_code"
				);
				$this->curl->post($post);
				$this->curl->options(array(CURLOPT_RETURNTRANSFER=>true));
						
				$ret = json_decode( $this->curl->execute() );
				$access_token = $ret->access_token;
				$publishable_key = $ret->stripe_publishable_key;

				//save access token
				$data['stripe'] = $access_token;
				$data['stripe_public_key'] = $publishable_key;
				$this->Global_model->update("sites",$data,array("site_id"=>$siteID));

				$this->messages->add("Stripe account successfully added.", 'success');
			}else
				$this->messages->add($error, 'error');

			redirect("admin/sites/edit/$siteID");
		}else
			redirect("admin/noaccess");
	}

}