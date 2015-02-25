<div class="owner_pet_wrapper">
	<h2 class="page-title">My Account</h2>
	<div class="owner_form">
		<form method="post" id="account_edit" name="account_edit" action="" enctype="multipart/form-data">
			<fieldset>
				<h3>Your Information</h3>
				<?php //print_r($account);?>
				<ol>
					<li class="owner_form_helper"><span>Below is the account information we have on record. Please update any information as needed.</span></li>
					<li><label for="account_name">First Name: </label><span><input type="text" name="firstName" value="<?php echo $account['firstName']?>" /></li>
					<li><label for="account_name">Last Name: </label><span><input type="text" name="lastName" value="<?php echo $account['lastName']?>" /></li>
					<?php 
					$excludePrefs = array('salutation','calendarEmail');
					


					foreach($account['prefs'] as $key=>$val) { 
						if(!in_array($key,$excludePrefs)) {
							if(in_array($key, array('pWork','pHome','pFax','pCell'))){
								
								if($val['value']){
									$valArray = explode("x", $val['value']);
									if(isset($valArray[1])){
										$extension = trim($valArray[1]);
										$val['value'] = trim($valArray[0]);	
									}else
										$extension = "";
								}else{
									$extension = "";
								}
								$extField = " x <input type='' style='width:40px;' name='ext_$key' value='$extension' />";

							}else{
								$extField = "";
							}
							?>
							<li><label for="<?php echo $key?>"><?php echo $val['name']?>: </label><span><input type="text" name="pref_<?php echo $key;?>" value="<?php echo $val['value']?>"><?php echo $extField; ?></li>	
						<?php 	
						} 
					}
					?>
					<li><label for="password">Password: </label><input type="password" name="password" id="password" /></li>
					<li><label for="password_conf">Confirm Password: </label><input type="password" name="password_conf" /></li>
					
					<br />
					<input type="submit" class="owner_button" value="Update Account Information" name="submit" />
					<br />
					<br />
					<li class="owner_form_helper"><span><strong>Looking for online payment?</strong> Go to My Pets of the left, then click your pet's passage. On your pet information page click Make a Payment.</span></li>
				</ol>

			</fieldset>	
		</form>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#account_edit").validate({
			rules: {
				password: {
					minlength: 5
				},
				password_conf: {
					minlength: 5,
					equalTo: "#password"
				}
			},
			messages: {
				password: {
					minlength: "Your password must be at least 5 characters long"
				},
				password_conf: {
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				}
			}
		});
	});
</script>