<h2 class="page-title">In Memory</h2>
<p>Please use this feature to search all of the Pet Tales. You can enter all or a portion of a Pet or Author's name in the search field to narrow the listings.</p>



<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    oTable = jQuery('#datatable').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });

    jQuery(".story").each(function(){	
    	jQuery(this).hover(function(){
    		jQuery(this).addClass="story-hover";
		},
		function(){
			jQuery(this).removeClass="story-hover";
    	});	
        
		var story_id = jQuery(this).attr('id');
		jQuery(this).click(function(){
			window.location = "/pet-tales/"+story_id;
		});
    });
});

function confirmDelete(id) {
	var del = confirm("Are you sure you want to delete this pet tale?");
	if(del==true) {
		window.location="/admin/pet-tales/delete/"+id;
	}
}
</script>

<table id="datatable" class="display">
		<thead>
	        <tr>
	            <th>Author</th>
	            <th>State</th>
	            <th>Title</th>
				<th>Picture</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php 
	    	foreach($tales as $t) {
		    	$storyAuthorLast = $t['story_author_last'];
		    	$storyAuthorFirst = $t['story_author_first'];
		    	$storyState = $t['story_state'];
		    	$storyTitle = $t['story_title'];
		    	$storyID = $t['story_id'];
	    	?>
	        <tr class='story' id='<?php echo $storyID;?>'>
	            <td><a href="/pet-tales/<?php echo $storyID; ?>" title="Click to view this pet tail"><?php echo $storyAuthorFirst . " " . $storyAuthorLast ?></a></td>
	            <td><?php echo $storyState ?></td>
	            <td><?php echo $storyTitle; ?></td>
	            <td></td>
	        </tr>
	        <?php } ?>
        </tbody>
</table>