<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#content_edit").validate();
	jQuery( "input:submit" ).button();
});
</script>
<?php $user = $this->session->userdata('user_info'); ?>
<div class="admin_form">
	<form method="post" id="content_edit" name="content_edit" action="/admin/content/edit" enctype="multipart/form-data">	
	<?php if($user['type']=="super_admin" || $user['type']=="pp_admin") {?>
		<fieldset>
			<legend>Site</legend>
			<ol>
				<li>
					<label for="site_id">Site</label>
					<select name="site_id" id="site_id" />
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
			</ol>
		</fieldset>
			<?php }else{ ?>
				<input type="hidden" value="<?php echo $site_id; ?>" name="site_id" />
			<?php } ?>
		<fieldset>
			<legend>Page Content</legend>
			<ol>
				<?php if($this->session->userdata('siteID') == 16) { ?>
					<?php if($user['type']=="super_admin" || $user['type']=="pp_admin" || !isset($site_page_id) || $type != "internal"){ ?>
						<li><label for="title">Title</label><input type="text" class="required" name="title" id="title" value="<?php echo isset($title) ? $title : ""; ?>" /></li>
					<?php }else{ ?>
						<li><label for="title">Title</label><?php echo isset($title) ? $title : ""; ?></li>
					<?php } ?>
					<?php $content1 = (isset($content)) ? $content: "";?>
					<li><label for="content1">Content</label><?php echo mcedev('content1',$content1); ?></li>
					<?php if(isset($url) && $url=="/") {?>
					<li><label for="title2">Title 2</label><input type="text" class="required" name="title2" id="title2" value="<?php echo isset($title2) ? $title2 : ""; ?>" /></li>
					<li><label for="content2">Content 2</label><?php echo mcedev('content2',$content2); ?></li>
					<li><label for="title3">Title 3</label><input type="text" class="required" name="title3" id="title3" value="<?php echo isset($title3) ? $title3 : ""; ?>" /></li>
					<li><label for="content3">Content 3</label><?php echo mcedev('content3',$content3); ?></li>
					<?php } ?>
				<?php }else{ ?>
					<?php if($user['type']=="super_admin" || $user['type']=="pp_admin" || !isset($site_page_id) || $type != "internal"){ ?>
						<li><label for="title">Title</label><input type="text" class="required" name="title" id="title" value="<?php echo isset($title) ? $title : ""; ?>" /></li>
					<?php }else{ ?>
						<li><label for="title">Title</label><?php echo isset($title) ? $title : ""; ?></li>
					<?php } ?>
					<?php $content1 = (isset($content)) ? $content: "";?>
					<li><label for="content1">Content</label><?php echo mce('content1',$content1); ?></li>
					<?php if(isset($url) && $url=="/") {?>
					<li><label for="title2">Title 2</label><input type="text" class="required" name="title2" id="title2" value="<?php echo isset($title2) ? $title2 : ""; ?>" /></li>
					<li><label for="content2">Content 2</label><?php echo mce('content2',$content2); ?></li>
					<li><label for="title3">Title 3</label><input type="text" class="required" name="title3" id="title3" value="<?php echo isset($title3) ? $title3 : ""; ?>" /></li>
					<li><label for="content3">Content 3</label><?php echo mce('content3',$content3); ?></li>
					<?php } ?>
				<?php } ?>
				
			</ol>
		</fieldset>
		<input type="hidden" value="<?php echo (isset($site_page_id)) ? $site_page_id : ""?>" name="site_page_id" />
		<input type="submit" value="Save" name="submit" />
	</form>
</div>