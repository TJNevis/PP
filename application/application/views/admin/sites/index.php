<?php $user = $this->session->userdata('user_info'); ?>
<script type="text/javascript">
jQuery(document).ready(function() {
    oTable = jQuery('#datatable').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
    jQuery( "button" ).button();
    jQuery( "button" ).click(function() { window.location="/admin/sites/add" });
});

function confirmDelete(id) {
	var del = confirm("Are you sure you want to delete this site?");
	if(del==true) {
		window.location="/admin/sites/delete/"+id;
	}
}

</script>

<?php if($user['type']=="super_admin") { ?>
<button>Add New Site</button><br /><br />
<?php } ?>
<table id="datatable" class="display">
		<thead>
	        <tr>
	            <th>Site Name</th>
	            <th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php 
	    	foreach($sites as $s) {
	    	$site_id = $s['site_id'];
	    	$site_name = stripslashes($s['name']);
	    	?>
	        <tr>
	            <td><?php echo $site_name ?></td>
	            <td><a href="/admin/sites/edit/<?php echo $site_id; ?>" title="Edit">Edit</a><?php if($user['type']=="super_admin") { ?>&nbsp;&nbsp;<a href="javascript:confirmDelete('<?php echo $site_id; ?>');" title="Delete">Delete</a><?php } ?></td>
	        </tr>
	        <?php } ?>
        </tbody>
</table>
<?php if($user['type']=="super_admin") { ?>
<br /><button>Add New Site</button>
<?php } ?>