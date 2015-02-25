<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#location_edit").validate();
	jQuery( "input:submit" ).button();
});

</script>
<?php $user = $this->session->userdata('user_info'); ?>
<div class="admin_form">
	<form method="post" id="location_edit" name="location_edit" action="/admin/locations/edit" enctype="multipart/form-data">
		
	<?php if($user['type']=="super_admin" || $user['type']=="pp_admin") {?>
		<fieldset>
			<legend>Site</legend>
			<ol>
				<li>
					<label for="site_id">Site</label>
					<select name="site_id" id="site_id" />
						<option value="">Select a Site</option> 
						<?php 
							foreach($sites as $s) {
								$db_site_id = $s['site_id'];
								$site_name = $s['name'];
								if(isset($site_id) && $site_id==$db_site_id) {
									echo "<option value='$db_site_id' selected='selected'>$site_name</option>";
								}else{
									echo "<option value='$db_site_id'>$site_name</option>";
								}
							}
						?>
					</select>
				</li>
			</ol>
		</fieldset>
			<?php }else{ ?>
				<input type="hidden" value="<?php echo $site_id; ?>" name="site_id" />
			<?php } ?>
	
		<fieldset>
			<legend>Location</legend>
			<ol>
				<li><label for="loc_name">Location Name</label><input type="text" class="required" name="loc_name" id="loc_name" value="<?php echo isset($loc_name) ? $loc_name : ""; ?>" /></li>
				<li><label for="loc_phone">Location Phone</label><input type="text" class="required" name="loc_phone" id="loc_phone" value="<?php echo isset($loc_phone) ? $loc_phone : ""; ?>" /></li>
			</ol>
		</fieldset>
		
		<!-- <fieldset>
			<legend>Location Types</legend>
			<ol>
				<?php 
					$transfer_check = isset($loc_type_transfer) && $loc_type_transfer==1 ? "checked='checked'" : "";
					$urn_check = isset($loc_type_urn) && $loc_type_urn==1 ? "checked='checked'" : "";
				?>
				<li><label for="loc_type_transfer">Transfer Location</label><input type="checkbox" class="checkbox" name="loc_type_transfer" value='1' id="loc_type_transfer" <?php echo $transfer_check?> /></li>
				<li><label for="loc_type_urn">Urn Pickup/Drop-off Location</label><input type="checkbox" class="checkbox" name="loc_type_urn" value='1' id="loc_type_urn" <?php echo $urn_check ?> /></li>
			</ol>
		</fieldset>-->
		
		<fieldset>
			<legend>Mailing Address</legend>
			<ol>
				<li><label for="loc_address1">Address Line 1</label><input type="text" class="required" name="loc_address1" id="loc_address1" value="<?php echo isset($loc_address1) ? $loc_address1 : ""; ?>" /></li>
				<li><label for="loc_address2">Address Line 2</label><input type="text" name="loc_address2" id="loc_address2" value="<?php echo isset($loc_address2) ? $loc_address2 : ""; ?>" /></li>
				<li><label for="loc_city">City</label><input type="text" class="required" name="loc_city" id="loc_city" value="<?php echo isset($loc_city) ? $loc_city : ""; ?>" /></li>
				<li>
					<label for="loc_state">State</label>
					<select name="loc_state" class="required">
						<option value="">Select a State</option> 
						<?php 
							$states_arr = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois", 'IN'=>"Indiana", 'IA'=>"Iowa",  'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland", 'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma", 'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");
							foreach($states_arr as $key=>$val) {
								if(isset($loc_state)) {
									if($loc_state==$key)
										echo "<option value='$key' selected='selected'>$val</option>";
								}else{
									echo "<option value='$key'>$val</option>";
								}
							}
						?>
					</select>
				</li>
				<li><label for="loc_zip">Zip</label><input type="text" class="required" name="loc_zip" id="loc_zip" value="<?php echo isset($loc_zip) ? $loc_zip : ""; ?>" /></li>
			</ol>
		</fieldset>
		
		<!-- <fieldset>
			<legend>Administrative Information</legend>
			<ol>
				<li><label for="loc_transfer_fee">Location Transfer Fee</label><input type="text" class="" name="loc_transfer_fee" id="loc_transfer_fee" value="<?php echo isset($loc_transfer_fee) ? $loc_transfer_fee : "0.00"; ?>" /></li>
				<li><label for="loc_notes">Location Notes</label><textarea class="" name="loc_notes" id="loc_notes"><?php echo isset($loc_notes) ? $loc_notes : ""; ?></textarea></li>
			</ol>
		</fieldset>-->
		
		<fieldset>
			<legend>Additional Information</legend>
			<ol>
				<!--<?php 
					$web_check = isset($loc_type_web) && $loc_type_web==1 ? "checked='checked'" : "";
				?>
				<li><label for="loc_type_website">Website Location</label><input type="checkbox" class="checkbox" name="loc_type_web" value='1' id="loc_type_web" <?php echo $web_check; ?> /></li>-->
				<li><label for="loc_website">Location Website</label><input type="text" name="loc_website" id="loc_website" value="<?php echo isset($loc_website) ? $loc_website : ""; ?>" /></li>
				
				<?php if(isset($loc_pic_path) && strlen($loc_pic_path)>0) {?>
					<li><label for="loc_image">Current Image</label><img src="/images/locations/<?php echo isset($loc_pic_path) ? $loc_pic_path : ""; ?>" /></li>
				<?php } ?>
				<li><label for="loc_pic_path">Location Image</label><input type="file" class="" name="loc_pic_path" id="loc_pic_path" /></li>
				<li><label for="loc_head">Location Head</label><input type="text" class="" name="loc_head" id="loc_head" value="<?php echo isset($loc_head) ? $loc_head : ""; ?>" /></li>
				<?php 
					$loc_body = isset($loc_body) ? $loc_body : "";
				?>
				<li><label for="loc_body">Location Body</label><?php echo mce('loc_body',$loc_body); ?></li>
			</ol>
		</fieldset>
		<input type="hidden" value="<?php echo (isset($loc_location_id)) ? $loc_location_id : "" ?>" name="loc_location_id" />
		<input type="submit" value="Save" name="submit" />
	</form>
</div>