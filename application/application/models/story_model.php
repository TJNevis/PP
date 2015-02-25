<?php
class Story_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Global_model');
        $this->load->model('Site_model');
        $this->load->model('Mail_model');
    }
    
    function getSingle($storyID=NULL) {
    	
    	
    	
    	//get tales
    	//if no id specified then pick random
    	if($storyID) {
    		$tale = max($this->Global_model->get('story',array('story_id'=>$storyID,'story_active'=>-1),NULL,1));
    	}else
    		$tale = max($this->getAllActiveTales(NULL,array('story_id'=>'random'),1));
    		
    	

    	//get messages
    	$tale['story_messages'] = $this->getStoryMessages($tale['story_id'],array('tribute_status'=>'active'));
    		
    	//fix dates
    	if($tale['story_pet_birthday'] != '0000-00-00') {
    		$story_pet_birthday_array = explode('-',$tale['story_pet_birthday']);
    		$timestamp = mktime(0,0,0,$story_pet_birthday_array[1],$story_pet_birthday_array[2],$story_pet_birthday_array[0]);
    		$story_pet_birthday = date('F j, Y',$timestamp);
    		$tale['story_pet_birthday'] = $story_pet_birthday;
    	}else{
    		$tale['story_pet_birthday'] = "Not Given";
    	}

    	if($tale['story_pet_passdate'] != '0000-00-00') {
    		$story_pet_passdate_array = explode('-',$tale['story_pet_passdate']);
    		
    		$timestamp = mktime(0,0,0,$story_pet_passdate_array[1],$story_pet_passdate_array[2],$story_pet_passdate_array[0]);
    		$story_pet_passdate = date('F j, Y',$timestamp);
    		
    		$tale['story_pet_passdate'] = $story_pet_passdate;
    	}else{
    		$tale['story_pet_passdate'] = "Not Given";
    	}
    	
    	return $tale;
    }
    
    function getStoryMessages($storyID,$where=array()) {
    	$where['story_id']=$storyID;
    	$messages = $this->Global_model->get('story_tributes',$where);
    	return $messages;
    }
    
    function insertStoryMessage($data=array()) {
    	$tribute = $this->Global_model->insert('story_tributes',$data);
    	return $this->db->insert_id();
    }
    
    function updateStoryMessages($storyID,$tributes,$status) {
   		//deactivate all
    	$data = array('tribute_status'=>'inactive');
    	$this->db->where('story_id', $storyID);
		$this->db->update('story_tributes', $data);
    	
    	//activate new
    	foreach($tributes as $t) {
			if($t) {
				$data = array(
	               'tribute_status' => $status
	            );
	
	            if($status=='active'){
	            	//send tribute updates

					$this->sendStoryUpdate($storyID,$t);
	            }
	            
				$this->db->where('tribute_id', $t);
				$this->db->update('story_tributes', $data);
			}
		}
		return true;
    }
    
	function deleteStoryMessages($storyID,$tributes) {
    	foreach($tributes as $t) {
			if($t) {
				$data = array(
	               'deleted' => true,
					'tribute_status'=>'deleted'
	            );
	
				$this->db->where('tribute_id', $t);
				$this->db->update('story_tributes', $data);
			}
		}
		return true;
    }
    
	function insertStorySubscriber($data=array()) {
    	$this->Global_model->insert('story_subscribers',$data);
    	return $this->db->insert_id();
    }
    
    function emailStoryOwner($storyID,$tributeID) {
    	$story = max($this->getAll(array('story_id'=>$storyID),NULL,1));
    	
    	//get tribute
   		$tribute = max($this->getStoryMessages($storyID,array('tribute_id'=>$tributeID)));
   		
   		$data = array_merge($tribute,$story);

	    $data['url'] = "http://".$_SERVER['SERVER_NAME'];
	    
	    
	    
	    //get template
   		$messageBody = $this->load->view('emails/pet_tale_message_approve',$data,true);
   		$subject = $data['story_pet_name'].$this->lang->line('story_message_approve_email_subject');
   			
    	if($story['story_pet_owner_id']) {
    		//send the message to pet owner
    		$sendMessage = $this->Mail_model->sendHTMLEmail($story['story_email'],'no-reply@petpassages.com',$subject,$messageBody);
    	}
    	
    	$sendAdminMessage = $this->Mail_model->adminMail($subject, $messageBody,"noreply@petpassages.com",true);
 
    	return true;
    }

    function sendApprovalToOwner($storyID) {
        $story = max($this->getAll(array('story_id'=>$storyID),NULL,1));

        $story['url'] = "http://".$_SERVER['SERVER_NAME'];
        
        //get template
        $messageBody = $this->load->view('emails/pet_tale_approve',$story,true);
        $subject = $story['story_pet_name'].$this->lang->line('story_approve_email_subject');
            
        if($story['story_email']) {
            //send the message to pet owner
            $sendMessage = $this->Mail_model->sendHTMLEmail($story['story_email'],'no-reply@petpassages.com',$subject,$messageBody);
        }
 
        return true;
    }


    function getStoryMedia($storyID) {
    	$media = $this->Global_model->get('story_media',array('story_id'=>$storyID));
    	
    	$newMedia = array();
    	if($media) {
			//get first image
			foreach($media as $m) {
				$newMediaItem = $m;
				if($m['media_type']=='image') {
					
					$mediaPath = $this->config->item('serverPath')."/".$this->config->item('mediaBaseFolder')."/".$this->config->item('storyBaseFolder');
					$mediaFile = $m['media_file'];
					
					if(!file_exists("$mediaPath/{$m['story_id']}/$mediaFile")) {
						$mediaFile = strtolower($mediaFile);
					}
//					if(!file_exists("$mediaPath/{$m['story_id']}/$mediaFile")) {
//						$mediaFile = strtoupper($mediaFile);
//					}
					
					$newMediaItem['media_file'] = $mediaFile;
					
					$newMediaItem['story_image'] = "/".$this->config->item('mediaBaseFolder')."/".$this->config->item('storyBaseFolder')."/{$m['story_id']}/$mediaFile";
				}
				$newMedia[]=$newMediaItem;
			}
		}
    	
    	return $newMedia;
    }
    
    function sendStoryUpdate($storyID,$tributeID) {

    	//get story
    	//$story = max($this->getAllActiveTales(array('story_id'=>$storyID),NULL,1));

        $story = max($this->Global_model->get('story',array('story_id'=>$storyID)) );
    	
    	//get tribute
    	$tribute = max($this->getStoryMessages($storyID,array('tribute_id'=>$tributeID)));

    	//get active subscribers
    	$subscribers = $this->getSubscribers($storyID,array('subscriber_status'=>'active'));
    	
    	if(!$tribute['tribute_update_sent'] && $storyID && $tributeID) {
	    	//send updates
	    	foreach ($subscribers as $s) {
				//merge tribute message and subscriber info
	    		$data = array_merge($tribute,$s);
	    		$data = array_merge($data,$story);

	    		$data['url'] = "http://".$_SERVER['SERVER_NAME'];

	    		//get template
	    		$messageBody = $this->load->view('emails/pet_tale_message_update',$data,true);
	    		$subject = $data['story_pet_name'].$this->lang->line('story_message_update_email_subject');
	    		
	    		//send the messages
	    		$sendMessage = $this->Mail_model->sendHTMLEmail($s['subscriber_email'],'no-reply@petpassages.com',$subject,$messageBody);
	    	}
	    	
	    	//update the tribute as sent
	    	$data = array(
               'tribute_update_sent' => true
            );

			$this->db->where('tribute_id', $tributeID);
			$this->db->update('story_tributes', $data);
    	}
    }
    
    function getSubscribers($storyID,$where=array()){
    	$where['story_id']=$storyID;
    	$subscribers = $this->Global_model->get('story_subscribers',$where);
    	return $subscribers;
    }
    
    function updateSubscriber($where=array(),$data=array()) {
    	$this->db->where($where);
		$this->db->update('story_subscribers', $data);
    }
    
    function getNextPrev($story_id,$direction) {
    	
    	
    	
    	if($direction=='prev'){
    		$tale = $this->getAllActiveTales(array('story_id <'=>$story_id),array('story_id'=>'DESC'),1);
    	}else{
    		$tale = $this->getAllActiveTales(array('story_id >'=>$story_id),array('story_id'=>'ASC'),1);
    	}
    	
    	if($tale){
    		return $tale[0];
    	}else{
    		//it at first tale start from end. If at end start from beginning.
    		if($direction=='prev'){
    			$tale = $this->getAllActiveTales(NULL,array('story_id'=>'DESC'),1);
    			return $tale[0];
    		}else{
    			$tale = $this->getAllActiveTales(NULL,array('story_id'=>'ASC'),1);	
    			return $tale[0];
    		}
    	}
    }
    
    function getAdminSingle($where){
    	$story = $this->Global_model->get("story",$where);
    	if($story)
    		return max($story);
    	else
    		return false;
    }
    
    function checkOwnerAccess($ownerID,$storyID) {
    	$story = $this->getAdminSingle(array('story_pet_owner_id'=>$ownerID,'story_id'=>$storyID));
    	
    	if($story )
    		return true;
    	else
    		return false;
    }
    
    function search($sort,$location,$keyword,$limit=NULL) {
    	//set location
    	if($location=='site'){
    		//get tales related to certain site
	    	$site_id = $this->Site_model->getPublicSiteID();
	    	$where = "(site_id = '$site_id' OR site_id = 0)";
	    	
    	}else if($location=='all'){
    		$where = "";
    	}else{
    		if($location==1)
    			$where = "(site_id = '$location' OR site_id = 0)";
    		else
    			$where = "(site_id = '$location')";
    	}
    	
    	if($where)
    		$this->db->where($where);
    	
    	//set sort
    	if($sort=='name') {
    		$this->db->order_by("story_pet_name", "asc");
    	}else{
    		$this->db->order_by("story_pet_passdate", "desc");
    	}
    	
    	//search by keyword
    	if($keyword) {
    		$keywordSubQuery = "(`story_pet_name`  LIKE '%$keyword%' OR  `story_title`  LIKE '%$keyword%' OR  `story_pet_birthday`  LIKE '%$keyword%' OR  `story_pet_passdate`  LIKE '%$keyword%' OR `story_author_first`  LIKE '%$keyword%' OR `story_author_last`  LIKE '%$keyword%')"; 
    		$this->db->where($keywordSubQuery);
    	}
 
    	//active tales
   		$this->db->where('story_active', -1);
   		$this->db->where('story.deleted', 0);	
   		
   		//add an image
   		$this->db->join('story_media', 'story_media.story_id = story.story_id AND media_type =  "image"', 'left');
   		$this->db->group_by("story.story_id");
   		//$this->db->where('media_type', 'image');
   		
   		//run the query
   		$this->db->select('story.*,story_media.media_file,story_media.media_type');
		$this->db->from('story');
   		$query = $this->db->get();

        error_log($this->db->last_query());

	    $tales = $query->result_array(); 
	    
    	return $tales;
    }
    
	function getAll($where=array(),$siteBool,$messageBool=false) {
		$stories = $this->Global_model->get("story",$where,NULL,NULL,$siteBool);
		
		if($messageBool){
			$storiesRet = array();
			foreach($stories as $s){
				$messages['story_messages'] = $this->getStoryMessages($s['story_id']);
				$storiesRet[] = array_merge($s,$messages);
			}
		}else{
			$storiesRet = $stories;
		}
		
    	return $storiesRet;
    }
    
	function getUnApprovedMessages() {
		$this->db->join('story_tributes', 'story_tributes.story_id = story.story_id AND tribute_status = "pending"', 'right');
		$this->db->order_by("story.story_id", "asc");
		$this->db->where('story_tributes.tribute_status', 'pending');
		$this->db->where('story_tributes.deleted', '0');
		$this->db->select('story.story_pet_name,story_tributes.*');
		$this->db->from('story');
   		$query = $this->db->get();	
	    $tales = $query->result_array();
    	return $tales;
    }
    
    function getAllActiveTales($where=array(),$sort=array(),$limit=NULL) {
    	
    	$where['story_active']=-1;
    	
    	//get tales related to certain site
    	$site_id = $this->Site_model->getPublicSiteID();
    	$where['site_id']=$site_id;
    	
    	$tales = $this->Global_model->get('story',$where,$sort,$limit);
    	
    	//get additional tales without a site id
   		$where['site_id']=1;
   		$tales = array_merge($this->Global_model->get('story',$where,$sort,$limit), $tales);

   		
   		
    	return $tales;
    }
    
    function getFeaturedTales() {
    	
    	
    	$this->db->select('story.story_id,story_pet_name,media_file');
    	
		$this->db->from('story');
    	$this->db->where('story.story_active', -1);
		$this->db->where('story.deleted', 0);
    	
    	//get tales related to certain site
    	$site_id = $this->Site_model->getPublicSiteID();
    	$siteSubQuery = "site_id = '$site_id' OR site_id = 0";
    	$this->db->where($siteSubQuery);

    	//add an image
   		$this->db->join('story_media', 'story_media.story_id = story.story_id', 'left');
   		$this->db->group_by("story.story_id");
   		$this->db->where('media_type', 'image');
    	
   		$query = $this->db->get();	
	    $tales = $query->result_array();
   		
        $cleanTales = array();
	    if($tales){
            foreach($tales as $k=>$t){
                foreach($t as $key=>$val) {
                    $newVal = str_replace("'", "&#39;", $val);
                    $cleanTales[$k][$key]=addslashes( trim($newVal) );
                }
            }
        }else{
            $cleanTales[] = array(
                'story_pet_name'=>'',
                'story_title'=>''
            );
        }
                   




    	return $cleanTales;
    }
    
    function getGifts() {
    	$where = array('deleted'=>false);
    	$gifts = $this->Global_model->get('story_gifts',$where);
    	//error_log(print_r($gifts));
    	return $gifts;
    }
}
