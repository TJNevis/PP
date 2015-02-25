<script type="text/javascript">
function banner_fields(type) {
	 jQuery("#custom_text").hide();
	 jQuery("#licensee_logo").hide();
	 jQuery("#custom_banner").hide();
	 jQuery("#current_banner").hide();
	 jQuery("#current_logo").hide();
	 jQuery("#banner_chooser").hide();
	 
	 switch(type) {
	 	case '1':
		 	//jQuery("#custom_text").show();
		 	break;
	 	case '2':
		 	jQuery("#custom_text").show();
		 	break;
	 	case '3':
	 		jQuery("#licensee_logo").show();
	 		jQuery("#current_logo").show();
	 		break;
	 	case '4':
	 		jQuery("#custom_banner").show();
	 		jQuery("#current_banner").show();
	 		break;
	 	case '5':
	 		jQuery("#current_logo").show();
	 		jQuery("#licensee_logo").show();
	 		jQuery("#banner_chooser").show();
	 		break;
	 }
}

jQuery(document).ready(function(){
	jQuery("#site_edit").validate();
	jQuery( "input:submit" ).button();

	jQuery("#banner_type").change( function(){
		banner_fields(jQuery(this).val());
	});

	banner_fields('<?php echo isset($banner_type) ? $banner_type : ""; ?>');

	jQuery(".template_item").click(function(){

		//get the template id
		var template_id = jQuery(this).attr('id');

		//set hidden field
		jQuery("#template_id").val(template_id);

		//remove styles of others
		jQuery(".template_item").removeClass("template_preview_selected");
		jQuery(".template_item").addClass("template_preview");

		//add selected class to this one
		jQuery(this).removeClass("template_preview");
		jQuery(this).addClass("template_preview_selected");
		
	});

	jQuery(".banner_item").click(function(){
		<?php if($license=='professional') {?>
			//get the banner id
			var banner_id = jQuery(this).attr('id');

			if(jQuery("#banner_item_check_"+banner_id).prop("checked")==true) {
				//item needs to be unchecked
				jQuery("#banner_item_check_"+banner_id).prop("checked", false);
				jQuery(this).removeClass("banner_preview_selected");
				jQuery(this).addClass("banner_preview");
			}else{
				//item needs to be checked
				jQuery("#banner_item_check_"+banner_id).prop("checked", true);
				jQuery(this).addClass("banner_preview_selected");
				jQuery(this).removeClass("banner_preview");
			}
		<?php }else{ ?>
			//get the banner id
			var banner_id = jQuery(this).attr('id');

			//remove checks
			jQuery(".banner_item_checkbox").prop("checked", false);
			
			//check the new banner
			jQuery("#banner_item_check_"+banner_id).prop("checked", true);
			
			//remove styles of others
			jQuery(".banner_item").removeClass("banner_preview_selected");
			jQuery(".banner_item").addClass("banner_preview");
	
			//add selected class to this one
			jQuery(this).removeClass("banner_preview");
			jQuery(this).addClass("banner_preview_selected");
		<?php } ?>
		
	});
});

</script>
<?php $user = $this->session->userdata('user_info'); ?>
<div class="admin_form">
	<form method="post" id="site_edit" name="site_edit" action="/admin/sites/edit" enctype="multipart/form-data">
		<?php if($user['type']=="super_admin") {?>
		<fieldset>
			<legend>Site</legend>
			<ol>
				<li><label for="name">Site Name</label><input type="text" class="required" name="name" id="name" value="<?php echo isset($name) ? $name : ""; ?>" /></li>
				<li>
					<label for="license">License Type</label>
					<select name="license" class="required" id="license"/>
						<option value="">Select a License</option> 
						<?php 
							$license_arr = array('basic'=>"Basic",'standard'=>"Standard",'professional'=>"Professional");
							foreach($license_arr as $key=>$val) {
								if(isset($license) && $license==$key) {
									echo "<option value='$key' selected='selected'>$val</option>";
								}else{
									echo "<option value='$key'>$val</option>";
								}
							}
						?>
					</select>
				</li>
				<li><label for="domain">Domain Name</label><input type="text" name="domain" id="domain" value="<?php echo isset($domain) ? $domain : ""; ?>" /></li>
				<li><label for="commerce_url">Commerce URL</label><input type="text" name="commerce_url" id="commerce_url" value="<?php echo isset($commerce_url) ? $commerce_url : ""; ?>" /></li>
				<li><label for="affiliate_code">Commerce Affiliate Code</label><input type="text" name="affiliate_code" id="affiliate_code" value="<?php echo isset($affiliate_code) ? $affiliate_code : ""; ?>" /></li>
				<li><label for="facebook_link">Facebook URL</label><input type="text" name="facebook_link" id="facebook_link" value="<?php echo isset($facebook_link) ? $facebook_link : ""; ?>" /></li>
				<li><label for="twitter_link">Twitter URL</label><input type="text" name="twitter_link" id="twitter_link" value="<?php echo isset($twitter_link) ? $twitter_link : ""; ?>" /></li>
				<li><label for="contact_email">Contact Email</label><input type="text" name="contact_email" id="contact_email" value="<?php echo isset($contact_email) ? $contact_email : ""; ?>" /></li>
				<li><label for="contact_phone">Contact Phone</label><input type="text" name="contact_phone" id="contact_phone" value="<?php echo isset($contact_phone) ? $contact_phone : ""; ?>" /></li>
				<li><label for="pet_owner_module">Pet Parent Gateway</label>
					<select name="pet_owner_module" id="pet_owner_module">
						<option value="0" <?php echo (isset($pet_owner_module) && $pet_owner_module==0) ? 'selected="selected"' : '' ?>>Off</option>
						<option value="1" <?php echo (isset($pet_owner_module) && $pet_owner_module==1) ? 'selected="selected"' : '' ?>>On</option>
					</select>
				</li>
			</ol>
		</fieldset>
		<?php  }?>
		<fieldset>
			<legend>Site Look</legend>
			<ol>
				<li>
					<label class="template_label" for="template">Template</label>
					<?php 
					foreach ($templates as $t) {
						$template_item_id = $t['template_id'];
						if(isset($template_id) && $template_item_id==$template_id)
							$class="template_preview_selected";
						else
							$class="template_preview";	
					?>
						<a class="<?php echo $class ?> template_item" id="<?php echo $template_item_id; ?>" href="javascript:void()" title="Click to choose this template."><img src="/images/templates/<?php echo $template_item_id; ?>/<?php echo $template_item_id; ?>.jpg" alt="Template <?php echo $template_item_id; ?>"/></a>
					<?php } ?>
					<input type="hidden" name="template_id" id="template_id" value="<?php echo (isset($template_id)) ? $template_id : ""; ?>" />
				</li>
				<li>
					<label for="banner_type">Banner Type</label>
					<select name="banner_type" id="banner_type"/>
						<?php 
							$banner_arr = array('1'=>"PetPassages Standard Banner",'5'=>"Choose a Banner and Add My Logo",'4'=>"Custom Banner");
							foreach($banner_arr as $key=>$val) {
								if(isset($banner_type) && $banner_type==$key) {
									echo "<option value='$key' selected='selected'>$val</option>";
								}else{
									echo "<option value='$key'>$val</option>";
								}
							}
						?>
					</select>
				</li>
				<li id="current_logo"><label for="current_banner">Current Logo</label><img width="150" src="/images/<?php echo isset($site_id) ? $site_id : ""; ?>/<?php echo isset($logo) ? $logo : ""; ?>" /></li>
				<li id="current_banner"><label for="current_banner">Current Banner</label><img height="150" src="/images/<?php echo isset($site_id) ? $site_id : "";?>/<?php echo isset($banner_file) ? $banner_file : ""; ?>" /></li>
				<li id="licensee_logo"><label for="logo">Licensee Logo</label><input type="file" class="" name="logo" id="logo" /></li>
				<li id="custom_banner"><label for="banner_file">Custom Banner</label><input type="file" class="" name="banner_file" id="banner_file" /></li>
				<li id="banner_chooser">
					<label for="banner">Choose Banner</label>
					<div class="banner_list">
					<?php

					if($license=="professional") {
						echo "<p>You may choose mutiple to create a rotating slideshow of each of the banners.</p>";
					}
					
					//set default
					if(!isset($banner_id) || !$banner_id)
						$banner_id = 1;
					
					foreach ($banners as $b) {
						$banner_item_id = $b['banner_id'];

						//if multiple banners are selected we want to check the box
						
						if(isset($banner_id) && is_array($banner_id)) {
							if(in_array($banner_item_id,$banner_id)) {
								$banner_check = "checked='checked'";
								$class="banner_preview_selected";
							}else{
								$banner_check = "";
								$class="banner_preview";
							}
						}else{
							if($banner_item_id==$banner_id) {
								$banner_check = "checked='checked'";
								$class="banner_preview_selected";
							}else{
								$class="banner_preview";
								$banner_check = "";
							}
						}
					?>
						<a class="<?php echo $class ?> banner_item" id="<?php echo $banner_item_id; ?>" href="javascript:void()" title="Click to choose this banner"><img src="/images/banners/previews/<?php echo $banner_item_id; ?>.jpg" alt="Banner <?php echo $banner_item_id; ?>"/>
						<input type="checkbox" class="banner_item_checkbox" id="banner_item_check_<?php echo $banner_item_id;?>" value="<?php echo $banner_item_id; ?>" name="banner_item_check[]" <?php echo $banner_check; ?> /></a>
					<?php } ?>
					</div>
					<input type="hidden" name="banner_id" id="banner_id" value="<?php echo (isset($banner_id)) ? $banner_id : ""; ?>" />
				</li>
			</ol>
		</fieldset>
		<?php if(isset($site_id) ) { ?>
			<fieldset>
				<legend>Pet Parent Gateway Settings</legend>
					<ol>
					<?php 
					$perms = $this->config->item('access');
					if(in_array('owner',$perms[$user['type']]) && isset($site_id)) {?>
   					 <li id="stripe_connect"><label>Pet Parent Gateway</label><a href="/admin/owner/settings/<?php echo $site_id; ?>">Edit Settings</a></li>
					<?php } ?>
				
					<?php if(isset($stripe) && $stripe) { ?>
						<li id="stripe_connect"><label for="stripe_connect">Stripe Connect</label><strong>Account Connected</strong></li>
					<?php }else{ ?>
						<li id="stripe_connect"><label for="stripe_connect">Stripe Connect</label><a href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id=ca_2dDD1dDModvZNWHbAkAdEqtD5dZzkuCm&state=<?php echo $site_id ?>&scope=read_write&stripe_user[email]=<?php echo $user['email_address']; ?>&stripe_user[url]=<?php echo isset($domain) ? urlencode( "http://".$domain ) : ""; ?>"><img src="/images/stripe-blue.png" alt="Connect Stripe Account" /></a></li>
					<?php } ?>	
				</ol>
			</fieldset>
		<?php } ?>
		<input type="hidden" value="<?php echo isset($site_id) ? $site_id : ""; ?>" name="site_id" />
		<input type="submit" value="Save" name="submit" />
	</form>
</div>
