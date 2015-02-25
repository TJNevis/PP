<?php
	class geo {
		function getURL($url)
		{
			$ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_HEADER, false);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $data = curl_exec($ch);
	        return $data;
		} 
	
		public function getCoordinates($address,$attempts=0){
			$address = str_replace(' ','+',$address);
		 	//$url = 'http://where.yahooapis.com/geocode?q=' . $address . '&flags=J&appid=' . $apiKey;	
		 	$url = 'http://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false';

		 	$data = $this->getURL($url);
		 	
			error_log($data);
			$dataArray = json_decode($data,true);
		 	
			$lat = $dataArray['results'][0]['geometry']['location']['lat'];
			$long = $dataArray['results'][0]['geometry']['location']['lng'];

		 	//$requestCode = $dataArray['ResultSet']['Error'];

		 	//$lat = $dataArray['ResultSet']['Results'][0]['latitude'];
		 	//$long = $dataArray['ResultSet']['Results'][0]['longitude'];
		 	
			error_log(print_r($dataArray['results'],1));

	
			//if ($requestCode == 0){
				
				return array('lat' => $lat, 'long' => $long, 'alt' => 0);
			//}else{
			//	return array('lat' => 0, 'long' => 0, 'alt' => 0);
			//}			
		}
		
		
			


// 		public function getCoordinates($address,$attempts=0){
// 			$address = str_replace(' ','+',$address);
// 			$apiKey = 'dj0yJmk9bE81cXh6ZHpaUG1FJmQ9WVdrOU4ybFJTMHhSTnpRbWNHbzlNekU1TXpVeE1UWXkmcz1jb25zdW1lcnNlY3JldCZ4PTll';
// 		 	$url = 'http://where.yahooapis.com/geocode?q=' . $address . '&flags=J&appid=' . $apiKey;
		 	
// 		 	error_log($url);
		 	
// 		 	$data = $this->getURL($url);
		 	
// 		 	error_log($data);
		 	
// 		 	$dataArray = json_decode($data,true);
		 	
// 		 	error_log(print_r($dataArray,1));
		 	
// 		 	$requestCode = $dataArray['ResultSet']['Error'];
		 	
// 		 	$lat = $dataArray['ResultSet']['Results'][0]['latitude'];
// 		 	$long = $dataArray['ResultSet']['Results'][0]['longitude'];
		 
// //		 	$lat = $dataArray['ResultSet']['Result']['latitude'];
// //		 	$long = $dataArray['ResultSet']['Result']['longitude'];
		 	
// 			if ($lat && $long){
// 				return array('lat' => $lat, 'long' => $long, 'alt' => 0);
// 			}else{
// 				return array('lat' => 0, 'long' => 0, 'alt' => 0);
// 			}			
// 		}
	}; 
?>
