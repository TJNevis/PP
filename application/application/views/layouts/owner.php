<?php
$ownerInfo = $this->session->userdata('owner_info');
$ownerSettings = $this->session->userdata('owner_settings');

$pet_owner_back_text = $this->session->userdata('pet_owner_back_text');
$pet_owner_back_link = $this->session->userdata('pet_owner_back_link');

if($this->session->userdata('template_id'))
	$template_id = $this->session->userdata('template_id');
else
	$template_id = 1;

//error_log(print_r($this->session->userdata('pet_owner_remove_pages'),1));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Pet Passages</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="Pet Passages" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" type="text/css" href="/css/style.css?v=1" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/admin.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/ui-custom-theme/jquery-ui-1.8.20.custom.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/ui-custom-theme/table_jui.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/templates/<?php echo $template_id?>.css" media="all" />

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
		<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
		<script type="text/javascript">
			var limits = '<?php echo json_encode( $this->config->item('limits') ); ?>';

		</script>

	</head>
	<body>
		<div id="container">
			<div id="top">
			</div>
			<div id="header">
				<div id="header">
				<?php
					$commerceURL = ($this->session->userdata('commerce_url')) ? $this->session->userdata('commerce_url') : "commerce.petpassages.com";
					switch($this->session->userdata('banner_type')){
						case 1:
							$banner_html = "<a class='header_banner' href='/' title='Homepage'><img src='/site-images/banner-2013-2.jpg' alt='Pet Passages'></a>";
							break;
						case 2:
							$banner_html = "<a class='header_text' href='/' title='Homepage'>".$this->session->userdata('banner_text')."</a>";
							break;
						case 3:
							$banner_html = "<a class='header_logo' href='/' title='Homepage'><img src='/images/".$this->session->userdata('siteID')."/".$this->session->userdata('logo')."' alt='Pet Passages'></a>";
							break;
						case 4:
							$banner_html = "<a class='header_banner' href='/' title='Homepage'><img src='/images/".$this->session->userdata('siteID')."/".$this->session->userdata('banner_file')."' alt='Pet Passages'></a>";
							break;
						case 5:

							if(strpos($this->session->userdata('banner_id'),",")>0){
								$banner_html = "
								<script type='text/javascript'>
								jQuery(document).ready(function() {
								    jQuery('.header_slideshow').cycle({
										fx: 'fade'
									});
								});
								</script>
								";
								$banner_html .= "<div class='header_slideshow'>";
								$banners = explode(",",$this->session->userdata('banner_id'));
								foreach($banners as $b) {
									$banner_html .= "<img src='/images/banners/$b.jpg' alt='' />";
								}
								$banner_html .= "</div>";
								$banner_html .= "<a class='header_banner_stock_logo' href='/' style='background:transparent url(/images/".$this->session->userdata('siteID')."/".$this->session->userdata('logo').") no-repeat 0 50%;' class='header_banner_stock_logo' title='Pet Passages' ><img src='/images/spacer.png' alt='Pet Passages'></a>";
							}else{
								$banner_html = "<div style='background:transparent url(/images/banners/".$this->session->userdata('banner_id').".jpg) no-repeat 0 0;' class='header_banner_stock'><a href='/' style='background:transparent url(/images/".$this->session->userdata('siteID')."/".$this->session->userdata('logo').") no-repeat 0 50%;' class='header_banner_stock_logo' title='Pet Passages' ><img src='/images/spacer.png' alt='Pet Passages'></a></div>";
							}
							break;
						default:
							$banner_html = "<a class='header_banner' href='/' title='Homepage'><img src='/site-images/petpassages_header.jpg' alt='Pet Passages'></a>";
							break;
					}
					echo $banner_html;
				?>
			</div>
			</div>
			<div id="nav">
			    <ul id="nav">
		    		<li>
						<?php $linkText = $pet_owner_back_text ?: 'Back To Website'; ?>
						<?php $linkURL = $pet_owner_back_link ?: (
							$this->session->userdata('domain') ? 'http://'.$this->session->userdata('domain') : '/'
						); ?>
						<a href="<?=$linkURL?>" title="<?=$linkText?>"><?=$linkText?></a>
					</li>
		    	</ul>
			</div>
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
									0=>array('link'=>'/owner','title'=>'Welcome', 'key'=>'welcome'),
									1=>array('link'=>'/owner/understanding','title'=>'Understand <br />Secure Passages&#8482;', 'key'=>'understanding_passages'),
									2=>array('link'=>'/owner/pet','title'=>"Current Pet's Passage", 'key'=>'current_pet_passage'),
									3=>array('link'=>'/owner/pet/all','title'=>'My Pets', 'key'=>'my_pets'),
									4=>array('link'=>'/owner/pet-tales','title'=>'My Pet Tales', 'key'=>'create_pet_tale'),
									5=>array('link'=>'http://'.$commerceURL.'/pet-memorials','title'=>'Pet Memorial Products', 'key'=>'products'),
									6=>array('link'=>'/owner/children','title'=>'Children & Pet Loss', 'key'=>'children'),
									7=>array('link'=>'/owner/account','title'=>'My Account', 'key'=>'my_account'),
									8=>array('link'=>'/owner/logout','title'=>'Logout', 'key'=>'logout')

								);

								//if($ownerSettings['grievance_emails']!="Off"){
									$owner_nav_new = array_splice($owner_nav,7,0, array(array('link'=>'/owner/subscription','title'=>'10 Days of Grieving', 'key'=>'subscription')));
								//}

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

									if($on['title']=="Pet Memorial Products")
										$target="_blank";
									else
										$target="";


									$ownerSettings = $this->session->userdata('owner_settings');

									if(isset($ownerSettings[ $on['key'] ]) && $ownerSettings[ $on['key'] ]=='Off') {

									}else{
										echo "<li class='$class'><a target='{$target}' href='{$on['link']}' title='{$on['title']}'>{$on['title']}</a></li>";
									}
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
