<?php
$ownerInfo = $this->session->userdata('owner_info');

if($this->session->userdata('template_id'))
	$template_id = $this->session->userdata('template_id');
else 
	$template_id = 1;

?>
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
		<link rel="stylesheet" type="text/css" href="/css/templates/<?php echo $template_id?>.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/embed.css" media="all" />
		
		
		<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/jquery.validate.js"></script>
		<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="/js/jquery-ui-1.8.20.custom.min.js"></script>
		<script type="text/javascript" src="/js/jquery.simplePage.js"></script>
		
		<script type="text/javascript" src="/js/plupload.js"></script>
		<script type="text/javascript" src="/js/plupload.gears.js"></script>
		<script type="text/javascript" src="/js/plupload.silverlight.js"></script>
		<script type="text/javascript" src="/js/plupload.flash.js"></script>
		<script type="text/javascript" src="/js/plupload.browserplus.js"></script>
		<script type="text/javascript" src="/js/plupload.html4.js"></script>
		<script type="text/javascript" src="/js/plupload.html5.js"></script>
		<script type="text/javascript" src="/js/jquery.cycle.lite.js"></script>
		<script type="text/javascript">
			var limits = '<?php echo json_encode( $this->config->item('limits') ); ?>';
		</script>
		
	</head>
	<body>
		<div id="container">
			<div id="content">
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery(".success").each(function(){
							jQuery(this).addClass("ui-state-highlight");
						});
						jQuery(".error").each(function(){
							jQuery(this).addClass("ui-state-error");
						});

						jQuery(".owner_table tbody tr td:first-child").addClass('first');
						
						jQuery(".owner_table tbody tr:odd").addClass('odd');
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
				

				$commerceURL = ($this->session->userdata('commerce_url')) ? $this->session->userdata('commerce_url') : "commerce.petpassages.com";


				?>
				
				
				<div class="owner_wrapper">
					<?php if($tabs) {?>

						<div class="owner_tabs"><div class="owner_top_fade"><div class="owner_bottom_fade">
							<div class="owner_name">
								Logged in as, <?php echo str_replace(" ","&nbsp;",$ownerInfo['owner_name'])?>
							</div>
							<ul>
								<?php 
								$owner_nav = array(
									0=>array('link'=>'/owner','title'=>'Welcome'),
									1=>array('link'=>'/owner/understanding','title'=>'Understand <br />Secure Passages&#8482;'),
									2=>array('link'=>'/owner/pet','title'=>"Current Pet's Passage"),
									3=>array('link'=>'/owner/pet/all','title'=>'My Pets'),
									4=>array('link'=>'/owner/pet-tales','title'=>'My Pet Tales'),
									5=>array('link'=>'http://'.$commerceURL.'/pet-memorials?embed=true','title'=>'Pet Memorial Products'),
									6=>array('link'=>'/owner/children','title'=>'Children & Pet Loss'),
									7=>array('link'=>'/owner/account','title'=>'My Account'),
									8=>array('link'=>'/owner/logout?embed=true','title'=>'Logout')
								
								);
								
								$thisPage = $_SERVER['REQUEST_URI'];
								if(substr($thisPage,-1)=='/')
									$thisPage = substr($thisPage, 0, -1);
								
								foreach($owner_nav as $on){
									if($on['link']==$thisPage)
										$class='active';
									else
										$class='';
									
									if(strpos($thisPage,"/pet/")>0 && is_numeric(substr($thisPage, -1)) && $on['link']=='/owner/pet')
										$class='active';
									
									if(strpos($thisPage,"/pet-tales")>0 && is_numeric(substr($thisPage, -1)) && $on['link']=='/owner/pet-tales')
										$class='active';	
									
									echo "<li class='$class'><a href='{$on['link']}' title='{$on['title']}'>{$on['title']}</a></li>";
								}
								?>
							</ul>
						</div></div></div>
					<?php 
						$contentClass="owner_has_tabs";
					}else{
						$contentClass="owner_no_tabs";
					}
					?>
					
					
					<div class="owner_content <?php echo $contentClass?>">
						<?php echo $content ?>
					</div>
				</div>

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
