<script type="text/javascript">
jQuery(document).ready(function(){
		jQuery("#contact_form").validate();
	});
</script>
<h2 class="page-title">Contact Us</h2>
<p><?php echo $content; ?></p>
<?php if($form) { ?>
<form action="" method="post" name="contact_form" id="contact_form">
	<table width="885" border="1" cellpadding="40" cellspacing="0" class="pet_tale_form">        
		<tr>          
			<td>            
				<table width="780" cellspacing="10" cellpadding="5">              
				<tr>                
					<td colspan="3" bgcolor="#5D7B97" class="formheads_container"><span class="formheads">Send us an email.</span></td>              
				</tr>                         
				<tr>                
					<td width="35%" valign="middle"  class="formtag_container"><div align="right" class="formtags">Name:</div></td>                
					<td width="65%" valign="middle"  class="formtag_container"><input name="name" class="required" type="text" size="50" value="" />                
						<span class="forminfo">(required)</span>
					</td>              
				</tr>            
				<tr>                
					<td width="35%" valign="middle"  class="formtag_container"><div align="right" class="formtags">Email Address:</div></td>                
					<td width="65%" valign="middle"  class="formtag_container"><input name="email" class="required email" type="text" size="50" value="" />                
						<span class="forminfo">(required)</span>
					</td>              
				</tr>  
				<tr>                
					<td width="35%" valign="middle"  class="formtag_container"><div align="right" class="formtags">Phone Number:</div></td>                
					<td width="65%" valign="middle"  class="formtag_container"><input name="phone" class="" type="text" size="50" value="" />                
					</td>              
				</tr> 
				<?php if(isset($locations)) {?>
				<tr>                
					<td width="35%" valign="middle"  class="formtag_container"><div align="right" class="formtags">Affiliated Funeral Home:</div></td>                
					<td width="65%" valign="middle"  class="formtag_container">
						<select name="franchisee" class="required">
							<option value="">Please Choose a Funeral Home</option>

							<?php foreach($locations as $l) {?>
								
								<option value="<?php echo $l['site_id']; ?>"><?php echo $l['name']; ?></option>
							<?php } ?>
							<option value="NA">I am not currenly affiliated with any funeral homes.</option>
						</select>
						<span class="forminfo">(required)</span>
					</td>              
				</tr>    
				<?php } ?>
				<tr>                
					<td width="35%" valign="middle"  class="formtag_container"><div align="right" class="formtags">Your Message:</div></td>                
					<td width="65%" valign="middle"  class="formtag_container">
						<textarea class="required" name="comments" rows='15' cols='60'></textarea>                
						<span class="forminfo">(required)</span>
					</td>              
				</tr>                             
				<tr>                
					<td></td>                
					<td>    
						<style>
							.styleTextField {
							  display: none;
							}
						</style>
						<div class="styleTextField"><input name="url" type="text" value=""/></div>
						<input type="hidden" name="attempted" value="completed">
						<input type="submit" name="submit" id="submit" value="Send Email" class="pet_tales_add" />
					</td>              
				</tr>            
			</table>          
		</td>        
	</tr>      
</table>
<?php } ?>