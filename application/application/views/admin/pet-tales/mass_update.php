<?php 
//get logged in user info
$user = $this->session->userdata('user_info');
$site = $this->session->userdata('site_info');

?>
<script type="text/javascript">


jQuery(document).ready(function(){
	jQuery( "input:submit,input:button" ).button();
	
	var oTable = jQuery('#datatable1').dataTable({
	    "bPaginate": false,
	    "bJQueryUI": true,
	    "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,1,2,3,4 ] }
         ]
	});

	var oTable2 = jQuery('#datatable2').dataTable({
	    "bPaginate": false,
	    "bJQueryUI": true,
	    "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,1,2,3,4,5 ] }
         ]
	});

	jQuery('.check_all_story_active').click(function () {
		jQuery('.story_check_active').attr('checked', this.checked);
    });

	jQuery('.check_all_tribute_active').click(function () {
		jQuery('.tribute_check_active').attr('checked', this.checked);
    });

	jQuery('.check_all_story_delete').click(function () {
		jQuery('.story_check_delete').attr('checked', this.checked);
    });

	jQuery('.check_all_tribute_delete').click(function () {
		jQuery('.tribute_check_delete').attr('checked', this.checked);
    });


});
</script>
<div class="admin_form">
	<form method="post" id="story_edit" name="story_edit" action="" enctype="multipart/form-data">
		<fieldset>
			<legend>Stories</legend>
			<table id="datatable1" class="display">
				<thead>
			        <tr>
			        	<th>Title</th>
			            <th>Pet Name</th>
			            <th>Story</th>
			            <th class='checkbox_cell'>Active<br /><input name="checkall" type="checkbox" class="check_all_story_active" value="ON" /></th>
			            <th class="tribute_delete_heading checkbox_cell">Delete<br /><input name="checkall" type="checkbox" class="checkall check_all_story_delete" value="ON" /></th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php 
			    	foreach($stories as $s) {
			    	$storyPetName = $s['story_pet_name'];
			    	$storyTitle = $s['story_title'];
			    	$storyBody = substr(strip_tags($s['story_body']),0,200).'...';
			    	$storyID = $s['story_id'];
			    	?>
			        <tr>
			        	<td><a href="/admin/pet-tales/edit/<?php echo $storyID ?>" target="_blank"><?php echo $storyTitle ?></a></td>
			            <td><?php echo $storyPetName ?></td>
			            <td><?php echo $storyBody ?></td>
			            <td class='checkbox_cell'><input type="checkbox" name="story_active[]" class="story_check_active" value="<?php echo $storyID?>"></td>
			            <td class='checkbox_cell'><input type="checkbox" class="tribute_delete story_check_delete" name="story_delete[]" value="<?php echo $storyID?>"></td>
			        </tr>
			        <?php } ?>
		        </tbody>
		</table>	
		</fieldset>
		<fieldset>
			<legend>Messages</legend>
			<table id="datatable2" class="display">
				<thead>
			        <tr>
			        	<th>Pet Name</th>
			            <th>Name</th>
			            <th>Message</th>
			            <th>Date</th>
			            <th class='checkbox_cell'>Active<br /><input name="checkall" type="checkbox" class="check_all_tribute_active" value="ON" /></th>
			            <th class="tribute_delete_heading checkbox_cell">Delete<br /><input name="checkall" type="checkbox" class="check_all_tribute_delete" value="ON" /></th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php 
			    	foreach($tributes as $t) {
			    	$storyPetName = $t['story_pet_name'];
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
			        	<td><?php echo $storyPetName ?></td>
			            <td><?php echo $tributeName ?></td>
			            <td><?php echo $tributeMessage ?></td>
			            <td><?php echo $tributeDate; ?></td>
			            <td class='checkbox_cell'><input type="checkbox" name="tribute_active[]" class="tribute_check_active" value="<?php echo $tributeID?>" <?php echo $tributeStatusCheck ?>></td>
			            <td class='checkbox_cell'><input type="checkbox" class="tribute_delete tribute_check_delete" name="tribute_delete[]" value="<?php echo $tributeID?>"></td>
			        </tr>
			        <?php } ?>
		        </tbody>
		</table>	
		</fieldset>
		<input type="hidden" value="True" name="completed" />
		<input type="submit" value="Save" name="submit" />
	</form>
</div>
