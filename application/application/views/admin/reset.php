<?php if($form) {?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#reset-form").validate({
			rules: {
				password: {
					required: true
				},
				conf_password: {
					equalTo: "#password"
				}
			},
			messages: {
				password: {
					required: "Password is required."
				},
				conf_password: {
					equalTo: "Passwords do not match."
				}
			}
		});
	});
	</script>
	<div class="admin_form">
	<fieldset>
		<legend>Reset Password</legend>
	
	
	<?php
	$attributes = array('class' => '', 'id' => 'reset-form');
	echo "<ol>";
	echo form_open('',$attributes);
	echo "<li>";
	echo form_label('New Password', 'password');
	$data = array(
	  'name'        => 'password',
	  'id'          => 'password',
	  'value'       => '');
	echo form_password($data);
	echo "</li><li>";
	echo form_label('Confirm New Password', 'conf_password');
	$data = array(
	  'name'        => 'conf_password',
	  'id'          => 'conf_password',
	  'value'       => '');
	echo form_password($data);
	echo "</li><br />";
	echo form_submit('mysubmit', 'Reset Password');
	echo "";
	echo form_close('');
	?>
	</ol>
	</fieldset>
<?php } ?>