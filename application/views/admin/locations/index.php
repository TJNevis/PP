<script type="text/javascript">
jQuery(document).ready(function() {
    oTable = jQuery('#datatable').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
    jQuery( "button" ).button();
    jQuery( "button" ).click(function() { window.location="/admin/locations/add" });
});

function confirmDelete(id) {
	var del = confirm("Are you sure you want to delete this location?");
	if(del==true) {
		window.location="/admin/locations/delete/"+id;
	}
}

</script>
<button>Add New Location</button><br /><br />
<table id="datatable" class="display">
		<thead>
	        <tr>
	            <th>Location Name</th>
	            <th>Location Address</th>
	            <th>Site</th>
	            <th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php 
	    	foreach($locations as $l) {
	    	$loc_location_id = $l['loc_location_id'];
	    	$loc_name = stripslashes($l['loc_name']);
	    		
	    	$loc_address = $l['loc_address1'];
	    	if($l['loc_address2'])
	    		$loc_address .= ", ".$l['loc_address2'];
	    	$loc_address .= ", ".$l['loc_city'];
	    	$loc_address .= ", ".$l['loc_state'];
	    	$loc_address .= " ".$l['loc_zip'];
	    	
	    	$loc_transfer = ($l['loc_type_transfer'] == '1' ? 'true' : 'false');
	    	$loc_urn = ($l['loc_type_urn'] == '1' ? 'true' : 'false');
	    	$loc_web = ($l['loc_type_web'] == '1' ? 'true' : 'false');
	    	
	    	$site_name = $l['name'];
	    	?>
	        <tr>
	            <td><?php echo $loc_name ?></td>
	            <td><?php echo $loc_address ?></td>
	            <td><?php echo $site_name; ?></td>
	            <td><a href="/admin/locations/edit/<?php echo $loc_location_id; ?>" title="Edit">Edit</a>&nbsp;&nbsp;<a href="javascript:confirmDelete('<?php echo $loc_location_id; ?>');" title="Delete">Delete</a></td>
	        </tr>
	        <?php } ?>
        </tbody>
</table>
<br /><button>Add New Location</button>