
<script type="text/javascript">
	function submitForm() {
		if(jQuery("#new_pet_tale").valid()){
	        if (uploader.files.length > 0) {
	            // When all files are uploaded submit form
	            uploader.bind('StateChanged', function() {
	                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
	                    $('form')[0].submit();
	                }
	            });
	                
	            uploader.start();
	            jQuery("#submit-area").html("Uploading files...");
	        }else{
				//no files to upload
				jQuery("#new_pet_tale").submit();
	        }
		}
	}
	
	jQuery(document).ready(function(){
		jQuery("#new_pet_tale").validate();

		jQuery("#submit_btn").click(function(){
			submitForm();
		});
		
		jQuery( "#tale_pet_birthday" ).datepicker({
			dateFormat: "yy-mm-dd"
		});

		jQuery( "#tale_pet_datepassed" ).datepicker({
			dateFormat: "yy-mm-dd"
		});
		
	});
</script>
<?php if($form) { ?>
<p>If you have a story to tell that celebrates the life of a beloved pet, we'd like to share it with others.</p> 
<form action="" method="post" id="new_pet_tale" name="new_pet_tale">  
     <table  border="1" cellpadding="40" cellspacing="0" class="pet_tale_form">
		<tr>
			<td>            
				<table width="100%" cellspacing="10" cellpadding="5">
					<tr>
						<td colspan="3" class="formheads_container"><span class="formheads">About You</span></td>  
                    </tr>
					<tr>                 
						<td width="19%" rowspan="5" valign="top">
							<span class="formdesc">First, tell us a little about yourself, so we can credit you send you the link to your story once it's posted.</span>
						</td>     
                        <td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Pet's Person<br>First Name:</div></td>            
                        <td width="55%" valign="middle" class="formtag_container"><input name="tale_owner_first" type="text" class="required" size="35" value="<?php echo (isset($_POST['tale_owner_first'])) ? $_POST['tale_owner_first'] : ''; ?>" /><span class="forminfo">(required)</span><br /><label for="tale_owner_first" class="error">This field is required.</label></td>
					</tr>
					<tr>                 
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Pet's Person<br>Last Name:</div></td>      
						<td width="55%" valign="middle" class="formtag_container"><input name="tale_owner_last" type="text" class="required" size="35" value="<?php echo (isset($_POST['tale_owner_last'])) ? $_POST['tale_owner_last'] : ''; ?>" /><span class="forminfo">(required)</span><br /><label for="tale_owner_last" class="error">This field is required.</label></td>
					</tr>
					<tr>            
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Pet's Person's<br>Email:</div></td>               
						<td width="55%" valign="middle" class="formtag_container"><input name="tale_owner_email" class="required email" type="text" size="35" value="<?php echo (isset($_POST['tale_owner_email'])) ? $_POST['tale_owner_email'] : ''; ?>" /><span class="forminfo">(required)</span><br /><label for="tale_owner_email" class="error">This field is required.</label></td>
					</tr>
					<tr>            
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">City:</div></td>    
                        <td width="55%" valign="middle" class="formtag_container"><input name="tale_owner_city" type="text" size="35" value="<?php echo (isset($_POST['tale_owner_city'])) ? $_POST['tale_owner_city'] : ''; ?>" /></span></td>       
					</tr>
					<tr>                  
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">State:</div></td>                  
						<td width="55%" valign="middle" class="formtag_container">
							<select name='tale_owner_state'>
								<?php 
								if(isset($_POST['tale_owner_state']))
									echo "<option value='{$_POST['tale_owner_state']}'>{$_POST['tale_owner_state']}</option>";
								?>
								<option value="AL">Alabama</option>
								<option value="AK">Alaska</option>
								<option value="AZ">Arizona</option>
								<option value="AR">Arkansas</option>
								<option value="CA">California</option>
								<option value="CO">Colorado</option>
								<option value="CT">Connecticut</option>
								<option value="DE">Delaware</option>
								<option value="DC">District of Columbia</option>
								<option value="FL">Florida</option>
								<option value="GA">Georgia</option>
								<option value="HI">Hawaii</option>
								<option value="ID">Idaho</option>
								<option value="IL">Illinois</option>
								<option value="IN">Indiana</option>
								<option value="IA">Iowa</option>
								<option value="KS">Kansas</option>
								<option value="KY">Kentucky</option>
								<option value="LA">Louisiana</option>
								<option value="ME">Maine</option>
								<option value="MD">Maryland</option>
								<option value="MA">Massachusetts</option>
								<option value="MI">Michigan</option>
								<option value="MN">Minnesota</option>
								<option value="MS">Mississippi</option>
								<option value="MO">Missouri</option>
								<option value="MT">Montana</option>
								<option value="NE">Nebraska</option>
								<option value="NV">Nevada</option>
								<option value="NH">New Hampshire</option>
								<option value="NJ">New Jersey</option>
								<option value="NM">New Mexico</option>
								<option value="NY">New York</option>
								<option value="NC">North Carolina</option>
								<option value="ND">North Dakota</option>
								<option value="OH">Ohio</option>
								<option value="OK">Oklahoma</option>
								<option value="OR">Oregon</option>
								<option value="PA">Pennsylvania</option>
								<option value="RI">Rhode Island</option>
								<option value="SC">South Carolina</option>
								<option value="SD">South Dakota</option>
								<option value="TN">Tennessee</option>
								<option value="TX">Texas</option>
								<option value="UT">Utah</option>
								<option value="VT">Vermont</option>
								<option value="VA">Virginia</option>
								<option value="WA">Washington</option>
								<option value="WV">West Virginia</option>
								<option value="WI">Wisconsin</option>
								<option value="WY">Wyoming</option>
      						</select>
      					</td>
      				</tr>
      				<tr>                
						<td colspan="3" class="formheads_container"><span class="formheads">About Your Pet</span></td>
					</tr>
					<tr>
						<td width="19%" rowspan="3" valign="top"><span class="formdesc">Next, tell us a about your pet.</span></td>              
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Pet Name:</div></td>                
    					<td width="55%" valign="middle" class="formtag_container"><input name="tale_pet_name" id="tale_pet_name" class="required" type="text" size="35" value="<?php echo (isset($_POST['tale_pet_name'])) ? $_POST['tale_pet_name'] : ''; ?>" /><span class="forminfo">(required)</span><br /><label for="tale_pet_name" class="error">This field is required.</label></td>              
    				</tr>
		            <tr>                
    					<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Birthday:</div></td>                
    					<td width="55%" valign="middle" class="formtag_container"><input name="tale_pet_birthday" id="tale_pet_birthday" type="text" size="35" value="<?php echo (isset($_POST['tale_pet_birthday'])) ? $_POST['tale_pet_birthday'] : ''; ?>" /></td>
 				    </tr>
 				    <tr>                
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Date of Passage:</div></td>                
    					<td width="55%" valign="middle" class="formtag_container"><input name="tale_pet_datepassed" id="tale_pet_datepassed" type="text" size="35" value="<?php echo (isset($_POST['tale_pet_datepassed'])) ? $_POST['tale_pet_datepassed'] : ''; ?>" /></td>
    				</tr>
    				<tr>                
    					<td colspan="3" class="formheads_container"><span class="formheads">Your Pet Tale</span></td>
					</tr>
					<tr>                
   						<td width="19%" rowspan="2" valign="top"><span class="formdesc">Next, tell us your pet's story. You may add formatting such as bold and italic. The first 30 words will appear on the front page of this site when your story is chosen randomly to display in the "Pet Tales" sidebar.</span></td>
   						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Tale Title:</div></td>
   						<td width="55%" valign="middle" class="formtag_container"><input name="tale_title" class="required" type="text" size="35" value="<?php echo (isset($_POST['tale_title'])) ? $_POST['tale_title'] : ''; ?>" /><span class="forminfo">(required)</span><br /><label for="tale_title" class="error">This field is required.</label></td>
					</tr>
					<tr>
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Tale:</div></td>
						<td width="55%" valign="middle" class="formtag_container"><textarea class="required" name="tale_pet_story"><?php echo (isset($_POST['tale_pet_story'])) ? $_POST['tale_pet_story'] : ''; ?></textarea><span class="forminfo">(required)</span><br /><label for="tale_pet_story" class="error">This field is required.</label></td>              
					</tr>              
					<tr>                
						<td colspan="3" class="formheads_container"><span class="formheads">Pictures, Music & Video</span></td>              
					</tr>              
					<tr>                
						<td width="19%" rowspan="1" valign="top"><span class="formdesc">Please attach any pictures that you would like to display with your story. Pictures should be in gif or jpg format, and be less than 80kb each.</span></td>                      
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Upload:</div></td>                      
						<td width="55%" valign="middle" class="formtag_container">          
						    <div id="tale_container">     
						    	<div id="filelist"></div>       
						    	<a id="pickfiles" href="javascript:;">Click Here to Select Files</a>
								<input name="story_pic1" id="story_pic1_input" type="hidden" value="<?php echo (isset($_POST['story_pic1'])) ? $_POST['story_pic1'] : ''; ?>" />
								<input name="story_pic2" id="story_pic2_input" type="hidden" value="<?php echo (isset($_POST['story_pic2'])) ? $_POST['story_pic2'] : ''; ?>" />
								<input name="story_pic3" id="story_pic3_input" type="hidden" value="<?php echo (isset($_POST['story_pic3'])) ? $_POST['story_pic3'] : ''; ?>" />
								<input name="story_pic4" id="story_pic4_input" type="hidden" value="<?php echo (isset($_POST['story_pic4'])) ? $_POST['story_pic4'] : ''; ?>" />
								<input name="story_pic5" id="story_pic5_input" type="hidden" value="<?php echo (isset($_POST['story_pic5'])) ? $_POST['story_pic5'] : ''; ?>" />
								<input name="story_pic6" id="story_pic6_input" type="hidden" value="<?php echo (isset($_POST['story_pic6'])) ? $_POST['story_pic6'] : ''; ?>" />
								<input name="story_pic7" id="story_pic7_input" type="hidden" value="<?php echo (isset($_POST['story_pic7'])) ? $_POST['story_pic7'] : ''; ?>" />
								<input name="story_pic8" id="story_pic8_input" type="hidden" value="<?php echo (isset($_POST['story_pic8'])) ? $_POST['story_pic8'] : ''; ?>" />
								<input name="story_pic9" id="story_pic9_input" type="hidden" value="<?php echo (isset($_POST['story_pic9'])) ? $_POST['story_pic9'] : ''; ?>" />
								<input name="story_pic10" id="story_pic10_input" type="hidden" value="<?php echo (isset($_POST['story_pic10'])) ? $_POST['story_pic10'] : ''; ?>" />
							</div>  
						    <script type="text/javascript">  
						    // Custom example logic
							var uploadActivity = new Array();
						    var currentFile = 1;  
						    function $(id) {  
						        return document.getElementById(id);  
						    }  
						    var uploader = new plupload.Uploader({
						        runtimes : 'gears,html5,flash,silverlight,browserplus',
						        browse_button : 'pickfiles',
						        container: 'tale_container',
						        max_file_size : '10mb',
						        multi_selection:false,
						        url : '../pet-tales/upload',
						        unique_names : true,
						        resize : {width : 320, height : 240, quality : 90},
						        flash_swf_url : '/js/plupload.flash.swf',
						        silverlight_xap_url : '/js/plupload.silverlight.xap',
						        filters : [   {title : "Image files", extensions : "jpg,gif,png,jpeg"},   {title : "Zip files", extensions : "zip"}  ]
						    });
						    
						    uploader.bind('Init', function(up, params) {
						        //$('filelist').innerHTML = "<div>Current runtime: " + params.runtime + "</div>";
						    });  uploader.init();
						
						    uploader.bind('FilesAdded', function(up, files) {
						    	
//						        for (var i in files) {
//						            $('filelist').innerHTML += '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
//						        }

						        if (uploader.files.length == 2) {
						        	uploader.removeFile(uploader.files[0]);
						        	alert("Limit of 1 photo reached.");
						        }else{
						        	$('filelist').innerHTML += '<div id="' + files[0].id + '">' + files[0].name + ' (' + plupload.formatSize(files[0].size) + ') <b></b></div>';
						        }
							    
						    });   
						
						    uploader.bind('UploadProgress', function(up, file) {  
						        $(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";  
						    });  
						
						    uploader.bind('FileUploaded', function(up, file, response){  
						        if(currentFile <= 10){
						            $('story_pic'+currentFile+'_input').value=response.response;      
						            currentFile++;    
						        }
						        if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
						        	jQuery("#new_pet_tale").submit();
						        }
						    });      
						    
						    </script>       
						</td>              
					</tr>   
					<tr>                
						<td width="19%" rowspan="1" valign="top"><span class="formdesc">If you have a video of your pet you my upload it to <a href="http://youtube.com" target="_blank">You Tube</a> add it here to be displayed with the photos.</span></td>                  
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">You Tube Video:</div></td>               
						<td width="55%" valign="middle" class="formtag_container"><input name="story_youtube" id="story_youtube" class="" type="text" size="35" value="<?php echo (isset($_POST['story_youtube'])) ? $_POST['story_youtube'] : ''; ?>" /><br /><span class="forminfo">&nbsp;Only paste the link the the video here. <br />&nbsp;Example: http://www.youtube.com/watch?v=7bcV-TL9mho</span></td>                            
					</tr>                  
					<tr>         
						<td width="19%" rowspan="1" valign="top"><span class="formdesc">Would you like music to play when your pet's story is displayed?</span></td>                  
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Music:</div></td>               
						<td width="55%" valign="middle" class="formtag_container"><input type='checkbox' value='true' name="music_check" CHECKED></td>              
					</tr>   
					<tr>         
						<td width="19%" rowspan="1" valign="top"><span class="formdesc">Please enter the text you see for human verification.</span></td>                  
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Human Verification:</div></td>               
						<td width="55%" valign="middle" class="formtag_container"><?php echo $recaptcha_html; ?></td>              
					</tr>                 
					<tr>            
						<td></td>            
						<td></td>           
						<td><p>When you click submit, your story and photos will be sent to our memory album. It will appear on the site after it has been approved by our site administrator. Thank you for sharing your story with us, and with others.</p><br /><br />
						<div id="submit-area"><input type="button" name="add" id="submit_btn"  class="pet_tales_add" value="Submit"  /></div></td>         
					</tr>          
				</table>          
			</td>        
		</tr>        
	</table>
</form>
<?php } ?>