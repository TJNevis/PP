<div class="owner_pet_wrapper">
	<h2 class="page-title">Pet Tale</h2>
<?php 
//get logged in user info
$user = $this->session->userdata('user_info');
$site_license = $this->session->userdata('license');

$imageCount=1;
if(isset($images)) {
	foreach($images as $i) {
		if($i['media_type']=='image') {
			$imageCount++;
		}
	}
}
?>
<script type="text/javascript">
var imageFieldCount=<?php echo $imageCount; ?>;

function addImageField() {
	var html;
	html = "<li>";
	html += "<label for='image-"+imageFieldCount+"'>Image "+imageFieldCount+"</label>";
	html += "<input type='file'  class='owner_file_input' name='image-"+imageFieldCount+"' id='image-"+imageFieldCount+"' />";
	html += "</li>";

	jQuery("#images").append(html);
	imageFieldCount++;
}

jQuery(document).ready(function(){
	jQuery("#story_edit").validate();
	
	jQuery("#add-image").click(function(){
		addImageField();
	});

	
	jQuery( "#story_pet_birthday" ).datepicker({
		dateFormat: "yy-mm-dd"
	});

	jQuery( "#story_pet_passdate" ).datepicker({
		dateFormat: "yy-mm-dd"
	});

	//add initial image field
	<?php 
	if( !isset($images) || count($images)==0 )
		echo "addImageField();"; 
	?>
});
</script>
<div class="owner_form">
	<form method="post" id="story_edit" name="story_edit" action="" enctype="multipart/form-data">
		<input type="hidden" value="<?php echo $site_id; ?>" name="site_id" />
		<fieldset>
			<h3>Owner/Author Information</h3>
			<ol>
				<li class="owner_form_helper"><span>First, tell us a little about yourself, so we can credit you send you the link to your story once it's posted.</span></li>
				<li><label for="story_author_first">First Name</label><input type="text" class="required" name="story_author_first" id="story_author_first" value="<?php echo isset($story_author_first) ? $story_author_first : ""; ?>" /></li>
				<li><label for="story_author_last">Last Name</label><input type="text" class="required" name="story_author_last" id="story_author_last" value="<?php echo isset($story_author_last) ? $story_author_last : ""; ?>" /></li>
				<li><label for="story_email">Email Address</label><input type="text" class="required email" name="story_email" id="story_email" value="<?php echo isset($story_email) ? $story_email : ""; ?>" /></li>
				<li><label for="story_city">City</label><input type="text" class="" name="story_city" id="story_city" value="<?php echo isset($story_city) ? $story_city : ""; ?>" /></li>
				<li>
					<label for="story_state">State</label>
					<select name="story_state">
						<option value="">Select a State</option> 
						<?php 
							$states_arr = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois", 'IN'=>"Indiana", 'IA'=>"Iowa",  'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland", 'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma", 'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");
							foreach($states_arr as $key=>$val) {
								if(isset($story_state) && $story_state==$key || $story_state == $val)
									echo "<option value='$key' selected='selected'>$val</option>";
								else
									echo "<option value='$key'>$val</option>";
							}
						?>
					</select>
				</li>
			</ol>
		</fieldset>
		<fieldset>
		
			<h3>Pet Information</h3>
			<ol>
				<li class="owner_form_helper"><span>Next, tell us a about your pet.</span></li>
				<li><label for="story_pet_name">Pet Name</label><input type="text" class="required" name="story_pet_name" id="story_pet_name" value="<?php echo isset($story_pet_name) ? $story_pet_name : ""; ?>" /></li>
				<li><label for="story_pet_birthday">Birthday</label><input type="text" class="" name="story_pet_birthday" id="story_pet_birthday" value="<?php echo isset($story_pet_birthday) ? $story_pet_birthday : ""; ?>" /></li>
				<li><label for="story_pet_passdate">Date of Passage</label><input type="text" class="" name="story_pet_passdate" id="story_pet_passdate" value="<?php echo isset($story_pet_passdate) ? $story_pet_passdate : ""; ?>" /></li>
			</ol>
		</fieldset>
		<fieldset>
			<h3>Pet Tale</h3>
			<ol>
				<li class="owner_form_helper"><span>Next, tell us your pet's story. You may add formatting such as bold and italic. The first 30 words will appear on the front page of this site when your story is chosen randomly to display in the "Pet Tales" sidebar.</span></li>
				<li><label for="story_title">Tale Title</label><input type="text" class="required" name="story_title" id="story_title" value="<?php echo isset($story_title) ? $story_title : ""; ?>" /></li>
				<li><label for="story_body">Tale</label><textarea class="required" name="story_body" id="story_body"><?php echo isset($story_body) ? $story_body : ""; ?></textarea></li>
			</ol>
		</fieldset>
		<fieldset>
			<h3>Media</h3>
			<ol>
				<li class="owner_form_helper"><span>Would you like music to play when your pet's story is displayed?</span></li>
				
				<?php 
					$music_check = isset($story_music) && $story_music==1 ? "checked='checked'" : "";
				?>
				<li><label for="story_music">Music</label><input type="checkbox" class="checkbox" name="story_music" value='1' id="story_music" <?php echo $music_check; ?> /></li>
				<?php 
				$story_youtube = "";
				if(isset($images)) {
					foreach($images as $i) {
						if($i['media_type']=='youtube') {
							$story_youtube = $i['media_file'];
						}
					}
				}
				
				?>
				<li class="owner_form_helper"><span>If you have a video of your pet you my upload it to <a href="http://youtube.com" target="_blank">You Tube</a> add it here to be displayed with the photos. Simpley paste the link the the video below. Example: http://www.youtube.com/watch?v=7bcV-TL9mho</span></li>
				<li><label for="story_youtube">You Tube Video</label><input type="text" class="" name="story_youtube" id="story_youtube" value="<?php echo isset($story_youtube) ? $story_youtube : ""; ?>" /></li>	
			</ol>
			<ol id="images">
				<li class="owner_form_helper"><span>Please attach any pictures that you would like to display with your story. Pictures should be in gif or jpg format, and be less than 80kb each.</span></li>
				<?php 
				$x=1;
				if(isset($images)) {
					foreach($images as $i) {
						if($i['media_type']=='image') {
							$imagePath = "/".$this->config->item('mediaBaseFolder')."/".$this->config->item('storyBaseFolder')."/".$story_id;
							$imageFile = strtolower($i['media_file']);
							
							echo "<li><label for='image-display-$x'>Image $x:</label><img height='150' src='$imagePath/$imageFile' />";
							echo "<p><label for='image-$x'>Update Image $x</label><input class='owner_file_input' type='file' name='image-$x' id='image-$x' /></p>";
							echo "<p><label for='image-delete-$x'>Delete Image $x</label><input type='checkbox' name='image-delete-$x' value='true' /></p>";
							echo "<input type='hidden' name='image-current-$x' value='$imageFile'>";
							echo "</li>";
							$x++;
						}
					}
				}
				?>
				<?php 
				$limits = $this->config->item('limits');
				
				if($limits[$site_license]['petTaleImageUpload']>1 || $limits[$site_license]['petTaleImageUpload']==0) {
				?>
					<br />
					<a href="javascript:void(0);" class="owner_button owner_add" id="add-image" name="add-image"><span>Add Another Image</span></a>
				<?php
				} 
				
				?>
			</ol>
		</fieldset>
		<?php if(isset($tributes)) { ?>
		<fieldset>
			<h3>Messages</h3>
			<ol>
				<li>	
					
					<table id="datatable" class="owner_table" cellpaddin="0" cellspacing="0">
						<thead>
					        <tr>
					            <th>Name</th>
					            <th>Email</th>
					            <th>Message</th>
					            <th>Date</th>
					            <th>Active</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<?php 
					    	
						    	foreach($tributes as $t) {
						    	$tributeMessage = $t['tribute_message'];
						    	$tributeName = $t['tribute_name'];
						    	$tributeEmail = $t['tribute_email'];
						    	$tributeStatus = $t['tribute_status'];
						    	$tributeTimestamp = explode(" ",$t['tribute_timestamp']);
						    	$tributeDateParts = explode("-",$tributeTimestamp[0]);
						    	$tributeDate = $tributeDateParts[1]."/".$tributeDateParts[2]."/".$tributeDateParts[0];
						    	$tributeID = $t['tribute_id'];
						    	
						    	if($tributeStatus=='active')
						    		$tributeStatusCheck="checked='checked'";
						    	else
						    		$tributeStatusCheck="";
						    	?>
						        <tr>
						            <td><?php echo $tributeName ?></td>
						            <td><?php echo $tributeEmail ?></td>
						            <td><?php echo $tributeMessage ?></td>
						            <td><?php echo $tributeDate; ?></td>
						            <td><input class="owner_remove_width" type="checkbox" name="tribute_active[]" value="<?php echo $tributeID?>" <?php echo $tributeStatusCheck ?>></td>
						        </tr>
					        <?php 
						    	} 
						    ?>
				        </tbody>
					</table>
				</li>
			</ol>
		</fieldset>
		<?php  } ?>
		<input type="hidden" value="<?php echo isset($story_id) ? $story_id : ""; ?>" name="story_id" />
		<input type="submit" class="owner_button" value="Save Pet Tale" name="submit" />
	</form>
</div>

</div>