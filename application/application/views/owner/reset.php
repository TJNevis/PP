<?php if($form){ ?>
<div class="owner_login_wrapper">
	<h2 class="page-title">Password Reset</h2>
	<div class="owner_full">
		
			<h3 class="owner_header">Please enter a new password below.</h3>
			<div class="owner_area">
				<?php
				$attributes = array('class'=>'owner_form');
				echo form_open('',$attributes);
				echo "<div class='input'>";
				echo form_label('Password', 'password');
				$data = array(
	              'name'        => 'password',
	              'id'          => 'password',
	              'value'       => ''
	            );
				echo form_password($data);
				echo "</div><div class='input'>";
				echo form_label('Confirm Password', 'password_conf');
				echo form_password('password_conf', '');
				echo form_hidden('hash', $_GET['h']);
				echo form_hidden('contactID', $_GET['c']);
				echo "</div><div class='input'>";
				echo '<input type="submit" name="mysubmit" value="Reset Password" class="owner_button">';
				echo "</div>";
				echo form_close('');
				?>
			</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".owner_form").validate({
			rules: {
				password: {
					required: true,
					minlength: 5
				},
				password_conf: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				}
			},
			messages: {
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				password_conf: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				}
			}
		});
	});
</script>
<?php } ?>