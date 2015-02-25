<?php 
$ownerInfo = $this->session->userdata('owner_info');
$ownerSettings = $this->session->userdata('owner_settings');
?>
<div class="owner_pet_wrapper">
	<h2 class="page-title">Welcome to the Pet Parents Gateway,</h2>
	<p>

<?php 
	if($ownerSettings['welcome_page_text']){
		$welcomeText = $ownerSettings['welcome_page_text'];
	}else{
		$welcomeText = $this->config->item('welcome_page_text_default');
	}
	echo $welcomeText;
?>
</div>
<div class="owner_subscribe_model_overlay">
	<div class="owner_subscribe_model">
		<h1>Subscribe to 10 Days of Grieving</h1>
		<p>Receive ten heartwarming tips and encouragement <br />to help with the loss of your pet.</p>
		<img src="/images/grieving-tip-preview.jpg" />
		<a class="owner_subscribe_model_subscribe_btn" href="javascript:opt('true');" title="Subscribe">Subscribe</a>
		<a class="owner_subscribe_model_cancel_btn" href="javascript:opt('false');" title="Subscribe">No Thanks</a>
		<span class="owner_subscribe_help_text">You can always subscribe at a later time in the 10 Days of Grieving tab.</span>
	</div>
</div>

<script type="text/javascript">
function subscribeModel(){
	var subscribed;
	//check subscription
	jQuery.post('/owner/check_subscribe',{opt:opt,email:"<?php echo $ownerInfo['owner_email']; ?>"}).done(function(ret){
		
		if(ret==0){
			jQuery(document).ready(function(){
				setTimeout(function(){
					jQuery(".owner_subscribe_model_overlay").fadeIn('slow');
				},500);
			});
		}
	});
}

function opt(opt){
	jQuery.post('/owner/subscribe',{opt:opt,email:"<?php echo $ownerInfo['owner_email']; ?>"});
	jQuery(".owner_subscribe_model_overlay").fadeOut('slow');
}


<?php 
if($ownerSettings['grievance_emails']!="Off"){
	echo "subscribeModel();";
}
?>
</script>