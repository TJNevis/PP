<?php
class Api_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Global_model');
    }
    
	function auth($username,$password){
		//do auth request
		$url = $this->config->item('apiUrl').'/api/auth';
		$ret = $this->curl->simple_post($url, array('username'=>$username,'password'=>$password));
	
		error_log($ret);
	
		//parse json
		$ret = json_decode($ret,true);
		
		if($ret['auth']=='true') {
			//add api key to session and use as auth for all api calls
			$session=array(
					'api_key'=>$ret['key']
			);
				
			$this->Global_model->addToSession($session);

			return true;
		}else{
			return false;
		}
	}
	
	function get($url){
		$apiKey = $this->session->userdata('api_key');
		$this->curl->create($url);

		//Options
		$this->curl->options(array(CURLOPT_HTTPHEADER => array("X-API-KEY: $apiKey"),CURLOPT_RETURNTRANSFER=>true));
				
		$ret = $this->curl->execute();
		return $ret;
		
	}

	function post($url,$data,$key=true){

		error_log("saving2...".http_build_query($data));

		$apiKey = $this->session->userdata('api_key');

		$this->curl->create($url);


		//Options
		if($key)
			$this->curl->options(array(CURLOPT_HTTPHEADER => array("X-API-KEY: $apiKey"),CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST => true, CURLOPT_POSTFIELDS=>urldecode(http_build_query($data))));
		else
			$this->curl->options(array(CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST => true, CURLOPT_POSTFIELDS=>http_build_query($data)));
				
		$ret = $this->curl->execute();

		error_log("POST API RETURN: ".$ret);

		return $ret;
		
	}
	
	function gettest($url){
		$apiKey = "ea45912f6ae6634d5b9d2c78181dcc4f50653d65";
		$this->curl->create($url);

		//Options
		$this->curl->options(array(CURLOPT_HTTPHEADER => array("X-API-KEY: $apiKey"),CURLOPT_RETURNTRANSFER=>true));
				
		$ret = $this->curl->execute();
		return $ret;
		
	}
}
