<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#share_pet_tale").validate();
		 jQuery.validator.addMethod("multiemail", function(value, element) {
             if (this.optional(element)) {
                 return true;
             }
             var emails = value.split( new RegExp( "\\s*,\\s*", "gi" ) );
             valid = true;
             for(var i in emails) {
                 value = emails[i];
                 valid=valid && jQuery.validator.methods.email.call(this, value,element);
             }
             return valid;
         }, "Please separate email addresses with commas.");
	});
</script>
<?php if($form) {?>
<h2 class="page-title">In Memory</h2>
<p>To share this Pet Tale with others please complete and send the form below...</p>
<form action="" method="post" name="share_pet_tale" id="share_pet_tale">
	<table width="885" border="1" cellpadding="40" cellspacing="0" class="pet_tale_form">        
		<tr>          
			<td>            
				<table width="780" cellspacing="10" cellpadding="5">              
					<tr>                
						<td colspan="3" bgcolor="#5D7B97" class="formheads_container"><span class="formheads">Send This Pet Tale to Others...</span></td>              
					</tr>              
					<tr>                
						<td width="19%" valign="top"></td>                
						<td width="26%" valign="middle" class="formtag_container"><div align="right" class="formtags">Pet Tale:</div></td>                
						<td>    
						<table width="100%">
							<tr>    
								<td>
									<?php echo $story_pet_name; ?><br>                  
									<?php echo $story_author_first; ?><?php echo $story_author_last; ?><br>                  
									<?php echo $story_title; ?><br>                  
									<input type="hidden" name="tale_id" value="<?php echo $story_id; ?>">                  
									<input type="hidden" name="tale_pet" value="<?php echo $story_pet_name; ?>">                  
									<input type="hidden" name="tale_author" value="<?php echo $story_author_first; ?><?php echo $story_author_last; ?>">                  
									<input type="hidden" name="tale_title" value="<?php echo $story_title; ?>">                                 
									<a target='new' href='/pet-tales/<?php echo $story_id; ?>'>View Pet Tale</a><br>                  
								</td>
								<?php if(file_exists("/var/www/vhosts/".APPLICATION_BASE_URL."/httpdocs/images/story/$story_id/story_pic1.jpg")) {?>                  
									<td align="right"><img src="/images/story/<?php echo $story_id; ?>/story_pic1.jpg" width="170" /></td>  
								<?php } ?>                
							</tr>
						</table>                
					</td>              
				</tr>              
				<tr>                
					<td width="19%" rowspan="6" valign="top"><span class="formdesc"><br><br><br><br>*Please separate multiple e-mail addresses with commas.<br><br>*Limited to 20 addresses.</span></td>                
					<td width="26%" valign="middle"  class="formtag_container"><div align="right" class="formtags">Your Email Address:</div></td>                
					<td width="55%" valign="middle"  class="formtag_container"><input name="tale_email_from" class="required email" type="text" size="50" value="" />                
						<span class="forminfo">(required)</span>
					</td>              
				</tr>              
				<tr>                
					<td width="26%" valign="middle"  class="formtag_container"><div align="right" class="formtags">Send Me a Copy:</div></td>                
					<td width="55%" valign="middle"  class="formtag_container"><input type='checkbox' value='true' name="tale_ccfrom_check" CHECKED></td>              
				</tr>                           
				<tr>                
					<td width="26%" valign="middle"  class="formtag_container"><div align="right" class="formtags">Recipient's E-Mail*:</div></td>                
					<td width="55%" valign="middle"  class="formtag_container">
						<textarea class="required multiemail" name="tale_email_to" rows='5' cols='60'></textarea><span class="forminfo">(required)</span>
					</td>              
				</tr>              
				<tr>                
					<td width="26%" valign="middle"  class="formtag_container"><div align="right" class="formtags">Your Message:</div></td>                
					<td width="55%" valign="middle"  class="formtag_container">
						<textarea class="required" name="tale_email_message" rows='15' cols='60'></textarea>                
						<span class="forminfo">(required)</span>
					</td>              
				</tr>              
				<tr>                
					<td></td>                
					<td></td>              
				</tr>              
				<tr>                
					<td></td>                
					<td>
						<p>When you click send, the Pet Tale information above will be appended your message.<br><br>Thank you for sharing this Pet Tale with others.</p><br>                
						<input type="submit" name="submit" id="submit" value="Submit" class="pet_tales_add" />
					</td>              
				</tr>            
			</table>          
		</td>        
	</tr>      
</table>
<?php } ?>