<?php if($form){ ?>

<div class="owner_login_wrapper">
	<h2 class="page-title">Password Reset</h2>
	<div class="owner_full">
		<h3 class="owner_header">Please enter your email address below.</h3>
		<div class="owner_area">
			<?php
			$attributes = array('class'=>'owner_form');
			echo form_open('',$attributes);
			echo "<div class='input'>";
			echo form_label('Email Address', 'username');
			echo form_input('username', '');
			echo "</div><div class='input'>";
			echo '<input type="submit" name="mysubmit" value="Send Reset Instructions" class="owner_button">';
			echo "</div>";
			echo form_close('');
			?>
		</div>
		
	</div>
</div>
<?php } ?>