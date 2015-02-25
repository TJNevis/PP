<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#user_edit").validate({
		rules: {
			password: {
				minlength: 5
			},
			password_conf: {
				equalTo: "#password"
			}
		},
		messages: {
			password: {
				minlength: "Your password must be at least 8 characters long"
			},
			password_conf: {
				equalTo: "Passwords do not match."
			}
		}
	});
	jQuery( "input:submit" ).button();
});
</script>
<?php $user = $this->session->userdata('user_info'); ?>
<div class="admin_form">
	<form method="post" id="user_edit" name="user_edit" action="/admin/users/edit" enctype="multipart/form-data">
		<fieldset>
			<legend>User Information</legend>
			<ol>
				<?php if($user['type']=="super_admin" || $user['type']=="pp_admin") {?>
				<li>
					<label for="site">Site</label>
					<select name="site_id" id="site" />
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
				<?php 
					if($user['type']=="super_admin")
						$type_arr = array('admin'=>"Site Administrator",'user'=>"Site Editor",'pp_admin'=>"Pet Passages Administrator",'super_admin'=>"Pet Passages Super Administrator");
					else
						$type_arr = array('admin'=>"Site Administrator",'user'=>"Site Editor");
				}else{
					$type_arr = array('admin'=>"Site Administrator",'user'=>"Site Editor");
					echo "<input type='hidden' value='$site_id' name='site_id' />";
				}
				
				?>
				<li>
					<label for="type">User Type</label>
					<select name="type" class="required" id="license"/>
						<option value="">Select a User Type</option> 
						<?php 
							foreach($type_arr as $key=>$val) {
								if(isset($type) && $type==$key) {
									echo "<option value='$key' selected='selected'>$val</option>";
								}else{
									echo "<option value='$key'>$val</option>";
								}
							}
						?>
					</select>
				</li>
				<li><label for="first_name">First Name</label><input type="text" class="required" name="first_name" id="first_name" value="<?php echo isset($first_name) ? $first_name : ""; ?>" /></li>
				<li><label for="last_name">Last Name</label><input type="text" class="required" name="last_name" id="last_name" value="<?php echo isset($last_name) ? $last_name : ""; ?>" /></li>
				<li><label for="email_address">Email</label><input type="text" class="required" name="email_address" id="email_address" value="<?php echo isset($email_address) ? $email_address: ""; ?>" /></li>
			</ol>
		</fieldset>
		
		<fieldset>
			<legend>Login Information</legend>
			<ol>
				<li><label for="username">Username</label><input type="text" class="required alphanumeric" name="username" id="username" value="<?php echo isset($username) ? $username : ""; ?>" /></li>
				<li><label for="password">Password</label><input type="password" class="<?php echo (isset($user_id)) ? "" : "required"; ?>" name="password" id="password" value="" /></li>
				<li><label for="password_conf">Confirm Password</label><input type="password" class="<?php echo (isset($user_id)) ? "" : "required"; ?>" name="password_conf" id="password_conf" value="" /></li>
			</ol>
		</fieldset>
		<input type="hidden" value="<?php echo isset($user_id) ? $user_id : ""; ?>" name="user_id" />
		<input type="submit" value="Save" name="submit" />
	</form>
</div>