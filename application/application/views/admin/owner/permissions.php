<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery( "input:submit" ).button();
});
</script>
<?php $user = $this->session->userdata('user_info'); ?>
<div class="admin_form">
	<form method="post" id="owner_edit" name="owner_edit" action="" enctype="multipart/form-data">	
		<fieldset>
			<input type="hidden" value="<?php echo $site_id; ?>" name="site_id" />
			<legend>Welcome Page</legend>
			<ol>
				<?php
				if(!$settings['welcome_page_text'])
					$settings['welcome_page_text'] = $this->config->item('welcome_page_text_default');
				?>
				<li><label for="welcome_page_text">Welcome Page Text</label><?php echo mce('welcome_page_text',$settings['welcome_page_text']); ?></li>	
				<li>
					<label for="grievance_emails">10 Days of Grieving Popup</label>
					<select name="grievance_emails">
						<?php 
						$optionArray = array('On','Off');
						foreach ($optionArray as $option) {
							if($option==$settings['grievance_emails'])
								$selected='selected="selected"';
							else
								$selected='';
							echo "<option value='$option' $selected>$option</option>";
						}
						?>
					</select>
				</li>
			</ol>
		</fieldset>
		<fieldset>
			<legend>Understanding Secure Passages</legend>
			<ol>
				<li>
					<label for="understanding_passages">Understanding Secure Passages</label>
					<select name="understanding_passages">
						<?php 
						$optionArray = array('On','Off');
						foreach ($optionArray as $option) {

							if($option==$settings['understanding_passages'])
								$selected='selected="selected"';
							else
								$selected='';

							echo "<option value='$option' $selected>$option</option>";
						}
						?>
					</select>
				</li>	
			</ol>
		</fieldset>
		<fieldset>
			<legend>Current Pet's Passage</legend>
			<ol>
				<li>
					<label for="print_certificate">Print Certificate</label>
					<select name="print_certificate">
						<?php 
						$optionArray = array('On','Off');
						foreach ($optionArray as $option) {
							if($option==$settings['print_certificate'])
								$selected='selected="selected"';
							else
								$selected='';

							echo "<option value='$option' $selected>$option</option>";
						}
						?>
					</select>
				</li>	
				<li>
					<label for="create_pet_tale">Create a Pet Tale</label>
					<select name="create_pet_tale">
						<?php 
						$optionArray = array('On','Off');
						foreach ($optionArray as $option) {
							if($option==$settings['create_pet_tale'])
								$selected='selected="selected"';
							else
								$selected='';

							echo "<option value='$option' $selected>$option</option>";
						}
						?>
					</select>
				</li>
				<?php
				if(!$settings['status_message_text'])
					$settings['status_message_text'] = $this->config->item('status_message_text_default');
				?>
				<li><label for="status_message_text">Understanding Status Messages Text <br /><br />{company_name} will be replaced with actual company name.</label><?php echo mce('status_message_text',$settings['status_message_text']); ?></li>	
			</ol>
		</fieldset>
		<fieldset>
			<legend>My Pet Tales</legend>
			<ol>
				<?php
				if(!$settings['pet_tales_text'])
					$settings['pet_tales_text'] = $this->config->item('pet_tales_text_default');
				?>
				<li><label for="pet_tales_text">My Pet Tales Text</label><?php echo mce('pet_tales_text',$settings['pet_tales_text']); ?></li>	
			</ol>
		</fieldset>
		<input type="submit" value="Save" name="submit" />
	</form>
</div>