<script type="text/javascript">
jQuery(document).ready(function() {
    oTable = jQuery('#datatable').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
    jQuery( "button" ).button();
    jQuery( "button" ).click(function() { window.location="/admin/content/add" });
});

function confirmDelete(id) {
	var del = confirm("Are you sure you want to delete this page?");
	if(del==true) {
		window.location="/admin/content/delete/"+id;
	}
}

</script>
<?php 
$site = $this->session->userdata('site_info');
?>
<?php if($site['license']=='professional') {?>
<button>Add New Page</button><br /><br />
<?php } ?>
<table id="datatable" class="display">
		<thead>
	        <tr>
	            <th>Title</th>
	            <th>Site</th>
	            <th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php 
	    	foreach($pages as $p) {
	    	$type = $p['type'];
	    	$title = $p['title'];
	    	$site_name = $p['name'];
			$sitePageID = $p['site_page_id'];
	    	?>
	        <tr>
	            <td><?php echo $title ?></td>
	            <td><?php echo $site_name ?></td>
	            <td><a href="/admin/content/edit/<?php echo $sitePageID; ?>" title="Edit">Edit</a>&nbsp;&nbsp;<?php if($type!="internal") { ?><a href="javascript:confirmDelete('<?php echo $sitePageID; ?>');" title="Delete">Delete</a><?php } ?></td>
	        </tr>
	        <?php } ?>
        </tbody>
</table>
<?php if($site['license']=='professional') {?>
<br /><button>Add New Page</button>
<?php } ?>