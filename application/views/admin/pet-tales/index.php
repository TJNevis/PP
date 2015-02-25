<script type="text/javascript">
jQuery(document).ready(function() {
    oTable = jQuery('#datatable').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
    jQuery( "button" ).button();
    jQuery( "button" ).click(function() { window.location="/admin/pet-tales/add" });
});

function confirmDelete(id) {
	var del = confirm("Are you sure you want to delete this pet tale?");
	if(del==true) {
		window.location="/admin/pet-tales/delete/"+id;
	}
}

</script>
<button>Add New Pet Tale</button><br /><br />
<table id="datatable" class="display">
		<thead>
	        <tr>
	        	<th>Pet Name</th>
	            <th>Author Last</th>
	            <th>Author First</th>
	            <th>Title</th>
	            <th>Site</th>
	            <th>Active</th>
	            <th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php 
	    	foreach($tales as $t) {
	    	$storyAuthorLast = $t['story_author_last'];
	    	$storyAuthorFirst = $t['story_author_first'];
	    	$storyTitle = $t['story_title'];
	    	$storyPetName = $t['story_pet_name'];
	    	$siteName = $t['name'];
	    	if($t['story_active']==0)
	    		$storyActive="Inactive";
	    	else
	    		$storyActive="Active";
	    		
	    	$storyID = $t['story_id'];
	    	?>
	        <tr>
	        	<td><?php echo $storyPetName ?></td>
	            <td><?php echo $storyAuthorLast ?></td>
	            <td><?php echo $storyAuthorFirst ?></td>
	            <td><?php echo $storyTitle ?></td>
	            <td><?php echo $siteName; ?></td>
	            <td><?php echo $storyActive ?></td>
	            <td><a href="/admin/pet-tales/edit/<?php echo $storyID; ?>" title="Edit">Edit</a>&nbsp;&nbsp;<a href="javascript:confirmDelete('<?php echo $storyID; ?>');" title="Delete">Delete</a></td>
	        </tr>
	        <?php } ?>
        </tbody>
</table>
<br /><button>Add New Pet Tale</button>