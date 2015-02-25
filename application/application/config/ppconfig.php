<?php 
$config['serverPath'] = '/var/www/vhosts/petpassages.com/httpdocs';
$config['apiUrl'] = 'https://api.petpassages.com';
$config['apiKey'] = '1Lc9EUEiV6nsJ5t350M0I4XW6Zr6oivC';

$config['activeCampaignKey'] = "b166a75e87f44dac23157a742cc55ce7402fc805fae31ff2fd820f40ae47081dc9589c9f";
$config['activeCampaignList'] = "1";
$config['activeCampaignUrl'] = "https://petpassages.api-us1.com/admin/api.php";

$config['defaultContactEmail'] = 'support@petpassages.com';

$config['mediaBaseFolder'] = 'images';
$config['storyBaseFolder'] = 'story';

$config['defaultStoryImage'] = '/site-images/no-image.jpg';

$config['locationImageWidth'] = '200';
$config['locationImageHeight'] = '200';

$config['logoWidth'] = '210';
$config['logoHeight'] = '210';

//opens access to different sections of the admin based on user type
$config['access'] = array(
	"admin"=>array('sites','users','content','pet-tales','locations','owner'),
	"user"=>array('content','pet-tales','locations'),
	"pp_admin"=>array('sites','users','content','pet-tales','locations','pet-tales-mass-update','owner'),
	"super_admin"=>array('sites','users','content','pet-tales','locations','pet-tales-mass-update','owner')
);

//turns on the security checking feature to check whether a user has access to edit a particular item
$config['securityCheck'] = array(
	"admin"=>1,
	"user"=>1,
	"pp_admin"=>0,
	"super_admin"=>0
);

//available pet owner permissions
$config['ownerPermissions'] = array(
	'welcome_page_text',
	'understanding_passages',
	'print_certificate',
	'create_pet_tale',
	'status_message_text',
	'pet_tales_text',
	'grievance_emails'
);

$config['welcome_page_text_default'] =<<<EOF
<p>
<img src="/site-images/owner-2.png" style="float:right; margin:0 0 5px 0;" />The Gateway is designed to provide you, The Pet Parent, with the ability to access many heartwarming features (gateways) that can help you memorialize your pet and help guide you through your loss. It is important for you to know that this Gateway location is only for you and your pets, so in a sense, it is what you make of it and therefore is unique to you. It is here where you have the option of knowing the status of where your pet is at any time while in our care; from when they pass away, to knowing when their cremated remains will be ready for you to receive, we call this Secure Passages&#8482;.</p><p><img src="/site-images/owner-1.png" style="float:left; margin:0 5px 5px 0;" /> The Pet Parents Gateway will also introduce you to many other wonderful services and features, so we encourage you to take the time and get acquainted with your Gateway and visit as often as you would like. Please know that we are here for you and should you have any questions or concerns please don't hesitate to call on our caring staff. On behalf of all us at Pets at Peace by Harris Funeral Home, please accept our most sincere condolences on the loss of your pet.</p>
EOF;

$config['status_message_text_default'] =<<<EOF
			<ol>
				<li><strong>Ready for Pickup:</strong> {company_name} has been notified and our Pet Care Specialists will arrive shortly to transfer you pet into our care.</li>
				<li><strong>Picked Up:</strong> A {company_name} Pet Care Specialist has transferred your pet into our care and is in transit back to our facility.</li>
				<li><strong>Received at {company_name}:</strong> Your pet is in our care at {company_name}.</li>
				<li><strong>Cremation Completed:</strong> Your pet has been cremated and a {company_name} Pet Care Coordinator is contacting you to coordinate payment and the return of your pet to you.</li>
				<li><strong>Urn Ready for Return:</strong> Payment and return details have been established and your pet is in transit to the location you have designated.</li>
				<li><strong>Urn Returned:</strong> Your pet has been returned.</li>
				<li><strong>Waiting for Payment:</strong> {company_name} has contacted you or has left message for you to contact us and arrange for payment and/or return details.</li>
				<li><strong>Waiting for owner to pick up:</strong> We have contacted you and you have indicated that you will pick up your pet's urn at one of our locations.</li>
			</ol>
EOF;

$config['pet_tales_text_default'] =<<<EOF
			We know from firsthand experience that pets are a part of the family and losing them can be extremely difficult. As funeral professionals, we are educated to understand that by sharing the life story of your pet, you not only honor their life and preserve their memory but the process of memorializing them can help the healing process. Here, you will find a wonderful tribute page called "Pet Tales" for you to upload photos and stories of your pet that will be shared with others.
EOF;

//stock photo options available to each license type
$config['imageOptions'] = array(
	"basic"=>array(
		'basic1.jpg',
		'basic2.jpg'
	),
	"standard"=>array(),
	"professional"=>array()
);

//limits on various features based on license type
$config['limits'] = array(
	"basic"=>array(
		'petTaleImageUpload'=>1,
		'petTaleCharacterLimit'=>1000
	),
	"standard"=>array(
		'petTaleImageUpload'=>5,
		'petTaleCharacterLimit'=>4000
	),
	"professional"=>array(
		'petTaleImageUpload'=>10,
		'petTaleCharacterLimit'=>10000
	)
);