<?php 
if($this->session->userdata('contact_email'))
	$contactEmail = $this->session->userdata('contact_email');
else
	$contactEmail = $this->config->item('defaultContactEmail');
?>

<div class="owner_login_wrapper">
	<h2 class="page-title">Pet Parent Gateway Login</h2>
	<div class="owner_full">
		<h3 class="owner_header">Enter a username and password.</h3>
		<div class="owner_area">
			<?php
			$attributes = array('class'=>'owner_form');
			echo form_open('',$attributes);
			echo "<div class='input'>";
			echo form_label('Username', 'username');
			echo form_input('username', '');
			echo "</div><div class='input'>";
			echo form_label('Password', 'password');
			echo form_password('password', '');
			echo "</div><div class='input'>";
			
			echo '<input type="submit" name="mysubmit" value="Login" class="owner_button">';
			echo "</div><p><a href='/owner/forgot'>Forgot password?</a></p><div class='input'>";
			echo '<div class="owner_form_helper"><span>In order to access the Pet Parent Gateway, you will need the username and password which you received in an e-mail from us. If you have forgotten your username or password or have any other questions regarding the Pet Parent Gateway please feel free to <a href="mailto:'.$contactEmail.'">contact us</a>.</span></div>';
			
			echo "</div>";
			echo form_close('');
			?>
		</div>
		
	</div>
</div>