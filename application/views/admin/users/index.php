<script type="text/javascript">
jQuery(document).ready(function() {
    oTable = jQuery('#datatable').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
    jQuery( "button" ).button();
    jQuery( "button" ).click(function() { window.location="/admin/users/add" });
});

function confirmDelete(id) {
	var del = confirm("Are you sure you want to delete this user?");
	if(del==true) {
		window.location="/admin/users/delete/"+id;
	}
}

</script>
<button>Add New User</button><br /><br />
<table id="datatable" class="display">
		<thead>
	        <tr>
	            <th>Name</th>
	            <th>Username</th>
	            <th>Site</th>
	            <th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php 
	    	$user = $this->session->userdata('user_info');
	    	if($user['type'] != 'super_admin')
	    		$hideSupers=true;
	    	else
	    		$hideSupers=false;
	    	foreach($users as $u) {
	    	$user_id = $u['user_id'];
	    	$username = stripslashes($u['username']);
	    	$site_name = stripslashes($u['name']);
	    	$name = stripslashes($u['first_name'] . " " . $u['last_name']);
	    	if($hideSupers && $u['type'] == 'super_admin') {
	    		continue;
	    	}
	    	?>
	        <tr>
	            <td><?php echo $name ?></td>
	            <td><?php echo $username ?></td>
	            <td><?php echo $site_name?></td>
	            <td><?php if($user['type'] == 'pp_admin' || $user['type'] == 'super_admin' || $user['type'] == 'admin') { ?><a href="/admin/users/edit/<?php echo $user_id; ?>" title="Edit">Edit</a><?php } ?>&nbsp;&nbsp;<?php if(($user['type'] == 'pp_admin' || $user['type'] == 'super_admin' || $user['type'] == 'admin') && $user['user_id'] != $user_id) { ?><a href="javascript:confirmDelete('<?php echo $user_id; ?>');" title="Delete">Delete</a><?php } ?></td>
	        </tr>
	        <?php } ?>
        </tbody>
</table>
<br /><button>Add New User</button>