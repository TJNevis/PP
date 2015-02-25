<?php
class Geo_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Global_model');
        $this->load->model('Site_model');
    }

    function checkIP(){
    error_log($_SERVER['SERVER_NAME']);
	if($_SERVER['SERVER_NAME']=='petpassages.com'){		

		$ipAddress = $_SERVER['REMOTE_ADDR'];

		// if($ipAddress == '107.10.155.96')
		// 	$ipAddress = "24.39.231.25";

		$lookup =  $this->Global_model->get('ip_locations',array('ip_address'=>$ipAddress));
	
		if($lookup)
			$ipExpiration = $lookup[0]['date_inserted']+(60*60*24*365); // expires after 365 days.
		else
			$ipExpiration = 0;		

		//if entry exists
		if($lookup && $ipExpiration>time()){
			$zipCode = $lookup[0]['postcode'];
		}else{
			//if entry does not exist create new entry
			$apiLookup = $this->getLocationData($ipAddress);

			//insert new location
			$data = array(
				'ip_address' => $ipAddress,
				'country' => $apiLookup[0],
				'state' => $apiLookup[1],
				'city' => $apiLookup[2],
				'postcode' => $apiLookup[3],
				'latitude' => $apiLookup[4],
				'longitude' => $apiLookup[5],
				'isp' => $apiLookup[8],
				'organization' => $apiLookup[9],
				'speed' => '',
				'date_inserted' => time()
			);

			if(!$apiLookup[3]){
				$zipCode = $this->getZipByCityState($data['city'],$data['state']);
			}else{
				$zipCode = $apiLookup[3];
			}

			$data['postcode'] = $zipCode;
			$this->insertIP($data);
		}

		//if($ipAddress == '107.10.155.96')
		//	$zipCode = '44691';

		//using zip code lookup relevent location
		$siteID = $this->getSiteIDByZip($zipCode);

		if($siteID){
			$data = array("site_id"=>$siteID);
    		$site = $this->Global_model->get("sites",$data);

    		//redirect to site
    		$url = "http://".$site[0]['domain'];
    		header("location: $url");
		}
	}
    	return true;
    }

    function getSiteIDByZip($zipCode){
    	$zipLookup = $this->Global_model->get('zip_codes',array('zip_code'=>$zipCode, 'deleted !='=>true));
    	if($zipLookup)
    		return $zipLookup[0]['site_id'];
    	else
    		return false;
    }

	function insertIP($data){
		return $this->Global_model->insert('ip_locations',$data);
	}    

	function getZipByCityState($city,$state){
   		$zipLookup = $this->Global_model->get('zip_lookup',array('city'=>$city, 'region'=>$state, 'deleted !='=>true));
    	if($zipLookup)
    		return $zipLookup[0]['postal_code'];
    	else
    		return false;
	}

	function getLocationData($ipAddress){
		$licenseKey = "vvy9T6eD5diP";
		$url = "https://geoip.maxmind.com/f?i=$ipAddress&l=$licenseKey";

		$this->curl->create($url);
		$this->curl->options(array(CURLOPT_RETURNTRANSFER=>true));
		
		$ret = $this->curl->execute();

		//prarse result
		$result = str_getcsv($ret);

		return $result;		
		//Array ( [0] => US [1] => OH [2] => Wooster [3] => 44691 [4] => 40.807701 [5] => -81.973000 [6] => 510 [7] => 330 [8] => Massillon Cable Communications [9] => Massillon Cable Communications )
	}

}
