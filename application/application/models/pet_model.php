<?php
class Pet_model extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        $this->load->library('encrypt');
        $this->load->model('data/User_data');
    }

	/*
	 * Authenticates user with given username and password
	 * Returns False or user data
	 */
	function getPetStatus($pet) {
		$currentStatus = $pet['statuses'][0]['status'];
		

		if(isset($pet['widgets']['34']['widgetPrefs']['petName']))
			$petName = $pet['widgets']['34']['widgetPrefs']['petName']['value'];
		else
			$petName = "Pet Name Not Given";
		
		
		//switch($currentStatus){
		//	case 'Urn Returned':
		//		$statusMessage = "<span class='owner_pet_status_name'>%pet_name%'s</span><span class='owner_pet_status_message'> urn has been delievered.</span>";
		//		break;
		//	default:
				$statusMessage = "<span class='owner_pet_status_message'>%pet_name%'s Status: $currentStatus</span>";
		//}
		
		//if(strpos($currentStatus,"eceived at") > 0)
		//	$statusMessage = "<span class='owner_pet_status_name'>%pet_name% has been</span><span class='owner_pet_status_message'> ".$statusMessage."</span>";
		
		//replace pet name
		$statusMessage = str_replace("%pet_name%",$petName,$statusMessage);
			
		return $statusMessage;
	}
	
	function addCurrentPetFlag($pets) {
		$newPetsArray = array();
		if($pets) {
			foreach($pets as $key=>$p) {
				$newPetsArray[$key]=$p;
				$newPetsArray[$key]['currentPet']=1;
				foreach($p['statuses'] as $s) {
					if(strtolower($s['status'])=="cremation complete" || strtolower($s['status'])=="communal cremation complete" || strtolower($s['status'])=="cancelled")
						$newPetsArray[$key]['currentPet']=0;
				}
			}
		}
		
		return $newPetsArray;
	}
}