<?php 
$user = $this->session->userdata('user_info'); 
$perms = $this->config->item('access');
?>
<script>
jQuery(document).ready(function() {
    jQuery( "button" ).button();
    jQuery( "button" ).css({ width: '230px' });
    jQuery( "#sites-btn" ).click(function() { window.location="/admin/sites" });
    jQuery( "#content-btn" ).click(function() { window.location="/admin/content" });
    jQuery( "#locations-btn" ).click(function() { window.location="/admin/locations" });
    jQuery( "#tales-btn" ).click(function() { window.location="/admin/pet-tales" });
    jQuery( "#mass-tales-btn" ).click(function() { window.location="/admin/pet-tales/massupdate" });
    jQuery( "#users-btn" ).click(function() { window.location="/admin/users" });
});
</script>
<p>Please choose from one of the below options.</p>
<p>
<?php if(in_array('sites',$perms[$user['type']])) {?>
	<button class='home-btn' id='sites-btn'>Site Settings</button>
<?php } ?>
<?php if(in_array('content',$perms[$user['type']])) {?>
	<button class='home-btn' id='content-btn'>Edit Website Content</button>
<?php } ?>
<?php if(in_array('locations',$perms[$user['type']])) {?>
	<button class='home-btn' id='locations-btn'>Edit Locations</button>
<?php } ?>
</p>
<p>
<?php if(in_array('pet-tales',$perms[$user['type']])) {?>
	<button class='home-btn' id='tales-btn'>Edit Pet Tales</button>
<?php } ?>
<?php if(in_array('pet-tales-mass-update',$perms[$user['type']])) {?>
	<button class='home-btn' id='mass-tales-btn'>Mass Update Pet Tales</button>
<?php } ?>
<?php if(in_array('users',$perms[$user['type']])) {?>
<button class='home-btn' id='users-btn'>Edit Users</button>
<?php } ?>
</p>