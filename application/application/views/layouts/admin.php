<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Pet Passages</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="Pet Passages" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/admin.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/ui-custom-theme/jquery-ui-1.8.20.custom.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/ui-custom-theme/table_jui.css" media="all" />
		
		<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/jquery.validate.js"></script>
		<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="/js/jquery-ui-1.8.20.custom.min.js"></script>
		
		<script type="text/javascript" src="/js/plupload.js"></script>
		<script type="text/javascript" src="/js/plupload.gears.js"></script>
		<script type="text/javascript" src="/js/plupload.silverlight.js"></script>
		<script type="text/javascript" src="/js/plupload.flash.js"></script>
		<script type="text/javascript" src="/js/plupload.browserplus.js"></script>
		<script type="text/javascript" src="/js/plupload.html4.js"></script>
		<script type="text/javascript" src="/js/plupload.html5.js"></script>
		<script type="text/javascript">
			var limits = '<?php echo json_encode( $this->config->item('limits') ); ?>';
		</script>
		
	</head>
	<body>
		<div id="container">
			<div id="top">
				<?php 
				$user = $this->session->userdata('user_info');
				$perms = $this->config->item('access');
				if($this->session->userdata('logged_in')){ 
				?>
					<ul>
						<li>Welcome <?php echo $user['first_name']." ".$user['last_name'];?></li>
						<li><a href="/admin/users/edit/<?php echo $user['user_id']; ?>" title="My Account">My Account</a></li>
						<li><a href="/admin/logout" title="Logout">Logout</a></li>
					</ul>
				<?php } ?>
			</div>
			<div id="header">
				<img src="/site-images/banner-2013-2.jpg" alt="Pet Passages" />
			</div>
			<div id="nav">
			    <ul id="nav">
		    		<li><a href="/admin" title="Home">Home</a></li>
		    		<?php if($this->session->userdata('logged_in')){  ?>
			    		<?php if(in_array('sites',$perms[$user['type']])) {?>
			    			<li><a href="/admin/sites" title="Sites">Site Settings</a></li>
			    		<?php } ?>
			    		<?php if(in_array('content',$perms[$user['type']])) {?>
			    			<li><a href="/admin/content" title="Content">Content</a></li>
			    		<?php } ?>
			    		<?php if(in_array('locations',$perms[$user['type']])) {?>
			    			<li><a href="/admin/locations" title="Locations">Locations</a></li>
			    		<?php  } ?>
			    		<?php if(in_array('pet-tales',$perms[$user['type']])) {?>
			    			<li><a href="/admin/pet-tales" title="Pet Tales">Pet Tales</a></li>
			    		<?php } ?>
			    		<?php if(in_array('pet-tales-mass-update',$perms[$user['type']])) {?>
			    			<li><a href="/admin/pet-tales/massupdate" title="Pet Tales Mass Update">Pet Tales Mass Update</a></li>
			    		<?php } ?>
			    		<?php if(in_array('users',$perms[$user['type']])) {?>
			    			<li><a href="/admin/users" title="Users">Users</a></li>
			    		<?php } ?>
			    	<?php } ?>
		    	</ul>
			</div>
			<div id="content">
				<div id="breadcrumbs"><?php echo set_breadcrumb(); ?></div>
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery(".success").each(function(){
							jQuery(this).addClass("ui-state-highlight");
						});
						jQuery(".error").each(function(){
							jQuery(this).addClass("ui-state-error");
						});
					});

					
				</script>
				<?php 
				// display all messages
				$messages = $this->messages->get(); 
				if (is_array($messages)):
				    foreach ($messages as $type => $msgs):
				        if (count($msgs > 0)):
				            foreach ($msgs as $message):
				                echo ('<div class="' .  $type .'">' . $message . '</div>');
				           endforeach;
				       endif;
				    endforeach;
				endif;
				?>
				<?php echo $content ?>
			</div>
			<div id="footer">
				&copy; Pet Passages, Inc. <?php echo date("Y")?>. All Rights Reserved. | <a href="#" title="Provider Login">Provider Login</a> | <a href="/terms" title="Term of Use and Privacy Statement">Term of Use and Privacy Statement</a>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34126214-1']);
  _gaq.push(['_setDomainName', 'petpasssages.com']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>