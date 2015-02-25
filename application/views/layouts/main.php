<?php 

$site_id = $this->session->userdata('siteID');
$site_name = $this->session->userdata('name');
$site_meta_title = $this->session->userdata('meta_title');
$page_name = $page_info['title'];
$page_meta_title = (isset($page_info['meta_title'])) ? $page_info['meta_title'] : '';
$specific_pages_only = $this->session->userdata('specific_pages_only');
$specific_pages_back_link = $this->session->userdata('specific_pages_back_link');

if(!$site_meta_title)
	$site_meta_title = $site_name;

if(!$page_meta_title)
	$page_meta_title = $page_name;


if($this->session->userdata('template_id'))
	$template_id = $this->session->userdata('template_id');
else 
	$template_id = 1;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo $site_meta_title; ?> - <?php echo $page_meta_title; ?></title>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="<?php echo $site_name; ?> is proud to be able to offer pet loss services to our community with the same high standards we abide by every day for our human family, friends and acquaintances." />
		<meta name="keywords" content="pet loss, pet cremation, pets at peace, pet funeral" />
		<link rel="stylesheet" type="text/css" href="/css/responsive.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/style.css?v=12" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/ui-custom-theme/jquery-ui-1.8.20.custom.css" media="all" />
		<link href='http://fonts.googleapis.com/css?family=Unkempt:700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="/css/ui-custom-theme/table_jui.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/templates/<?php echo $template_id?>.css?v=<?php echo time();?>" media="all" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

		
		<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/jquery.cycle.lite.js"></script>
		<script type="text/javascript" src="/js/jquery.ctabs.js"></script>
		<script type="text/javascript" src="/js/jquery.placeholder.js"></script>
		<script type="text/javascript" src="/js/jquery.validate.js"></script>
		<script type="text/javascript" src="/js/jquery-ui-1.8.20.custom.min.js"></script>
		<script src="/js/galleria-1.2.7.min.js" type="text/javascript"></script>
		<script src="/js/classic/galleria.classic.min.js" type="text/javascript"></script>

		<script type="text/javascript" src="/js/plupload.js"></script>
		<script type="text/javascript" src="/js/plupload.gears.js"></script>
		<script type="text/javascript" src="/js/plupload.silverlight.js"></script>
		<script type="text/javascript" src="/js/plupload.flash.js"></script>
		<script type="text/javascript" src="/js/plupload.browserplus.js"></script>
		<script type="text/javascript" src="/js/plupload.html4.js"></script>
		<script type="text/javascript" src="/js/plupload.html5.js"></script>
		
		<script type="text/javascript" src="/js/jquery.cycle.lite.js"></script>

		<!-- Google Analytic Code for Pet Passages -->
		<script>
  		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  	ga('create', 'UA-57180929-1', 'auto');
	  	ga('send', 'pageview');

		</script>
  	<!-- end google analytics -->

		<?php 
		
		if(!isset($facebook_title)) {
			$facebook_title = "$site_name - $page_name";
		}
		
		if(!isset($facebook_description)) {
			$facebook_description = "$site_name is proud to be able to offer pet loss services to our community with the same high standards we abide by every day for our human family, friends and acquaintances.";
		}
		
		if(!isset($facebook_image)) {
			$facebook_image = "";
		}
		
		if(!isset($facebook_url)) {
			$facebook_url = "";
		}
		
		?>

		<?php 
		if(!$this->session->userdata('pp_popup') && $_SERVER['SERVER_NAME']=="petsatpeace.harrisfuneralhome.com" && $_SERVER['REQUEST_URI']=='/') {
		?>
			  <!--<script type="text/javascript">

			  jQuery(document).ready(function() {
			    jQuery( "#dialog" ).dialog({
			      autoOpen: false,
			      show: {
			        effect: "blind",
			        duration: 500
			      },
			      width: "70%",
			      modal:true
			    });
			 
			    
			      jQuery( "#dialog" ).dialog( "open" );
			  });
			  </script>-->
		<?php
				//$this->session->set_userdata('pp_popup', true);
			}
		?>

		<meta property="og:title" content="<?php echo $facebook_title; ?>"/>
		<meta property="og:image" content="<?php echo $facebook_image; ?>"/>
		<meta property="og:description" content='<?php echo $facebook_description; ?>'/>
		<meta property="og:url" content='<?php echo $facebook_url; ?>'/>
	</head>
	<body>
		<div class="container"><!-- id="container"> -->
			<div id="top">
			</div>
			<div id="header">
				<?php
					//print_r($this->session->all_userdata());
					switch($this->session->userdata('banner_type')){
						case 1:
							$banner_html = "<a class='header_banner' href='/' title='Homepage'><img src='/site-images/banner-2013-2.jpg' alt='Pet Passages' class='img-responsive'></a>";
							break;
						case 2:
							$banner_html = "<a class='header_text' href='/' title='Homepage'>".$this->session->userdata('banner_text')."</a>";
							break;
						case 3:
							$banner_html = "<a class='header_logo' href='/' title='Homepage'><img src='/images/".$this->session->userdata('siteID')."/".$this->session->userdata('logo')."' alt='Pet Passages' class='img-responsive'></a>";
							break;	
						case 4:
							$banner_html = "<a class='header_banner' href='/' title='Homepage'><img src='/images/".$this->session->userdata('siteID')."/".$this->session->userdata('banner_file')."' alt='Pet Passages' class='img-responsive'></a>";
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
							$banner_html = "<a class='header_banner' href='/' title='Homepage'><img src='/site-images/petpassages_header.jpg' alt='Pet Passages' class='img-responsive'></a>";
							break;
					}
					echo $banner_html;
				?>
			</div>
			<div id="nav">
				<?php $domain = ($this->session->userdata('commerce_url')) ? $this->session->userdata('commerce_url') : "commerce.petpassages.com"; ?>
			    <ul class="main-nav">
			    	<?php if($specific_pages_only){ ?>
			    		<li><a href="<?php echo $specific_pages_back_link; ?>" title="Home">Home</a></li>
			    	<?php }else{ ?>
			    		<li><a href="/" title="Home">Home</a></li>
			    		<?php 
			    			if($_SERVER['SERVER_NAME']=="petpassages.com" || $_SERVER['SERVER_NAME']=="national.petpassages.com"){
			    				$commerceTitle = "Pet Urns &amp; <br />Pet Memorial Products";
			    				$commerceClass = "commerce-link";
			    			}else{
								$commerceTitle = "Product Gallery";
			    				$commerceClass = "";
			    			}
			    		?>
			    		<li class='<?php echo $commerceClass; ?>'><a href="http://<?php echo $domain; ?>/pet-memorials/" title="Pet Urns &amp; Pet Memorial Products"><?php echo $commerceTitle; ?></a></li>
			    		<?php 
			    		foreach($navigation as $n):
			    		$title = $n['title'];
			    		$link = $n['url'];
			    		?>
			    		<li><a href="/<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
			    		<?php endforeach;?>
			    		<?php if($this->session->userdata('pet_owner_module')) {?>
			    		<li><a href="/owner" title="Pet Parent Gateway">Pet Parent Gateway</a></li>
			    		<?php } ?>
			    	<?php } ?>

		    	</ul>
		    	<?php if($site_id==1) { ?>
		    		<!-- <ul class="social-nav">
		    			<li><a target="_blank" href="http://www.facebook.com/pages/Pet-Passages/430458513672390" title="Follow Us on Facebook"><img src="/site-images/facebook-icon.png" alt="Facebook"/></a></li>
		    			<li><a target="_blank" href="http://twitter.com/petpassages" title="Follow Us on Twitter"><img src="/site-images/twitter-icon.png" alt="Twitter"/></a></li>
		    		</ul>-->
		    	<?php } ?>
		    	<?php if($this->session->userdata('facebook_link') || $this->session->userdata('twitter_link')) { ?>
		    		<ul class="social-nav">
		    			<?php if($this->session->userdata('facebook_link')) { ?>
		    				<li><a target="_blank" href="<?php echo $this->session->userdata('facebook_link'); ?>" title="Follow Us on Facebook"><img src="/site-images/facebook-icon.png" alt="Facebook"/></a></li>
		    			<?php } ?>
		    			<?php if($this->session->userdata('twitter_link')) { ?>
		    				<li><a target="_blank" href="<?php echo $this->session->userdata('twitter_link'); ?>" title="Follow Us on Twitter"><img src="/site-images/twitter-icon.png" alt="Twitter"/></a></li>
		    			<?php } ?>
		    		</ul>
		    	<?php } ?>
			</div>
			<div id="content">
				<?php 
				// display all messages
				$messages = $this->messages->get(); 
				if (is_array($messages)):
				    foreach ($messages as $type => $msgs):
				        if (count($msgs > 0)):
				            foreach ($msgs as $message):
				                echo ('<span class="' .  $type .'">' . $message . '</span>');
				           endforeach;
				       endif;
				    endforeach;
				endif;
				?>
				<?php echo $content ?>
				<div class="clear"></div>
			</div>
			<div id="footer">
				&copy; Pet Passages, Inc. <?php echo date("Y")?>. All Rights Reserved. | <a href="/terms" title="Term of Use and Privacy Statement">Term of Use and Privacy Statement</a>
			</div>
		</div>
		<!--<div id="dialog" style="display:none;" title="An Open Letter to the Community and Friends of Pets at Peace">
		  <p>We, at Pets at Peace, take great pride in our work as providers of premium remembrance and cremation services for those enduring the loss of their beloved pets.</p>
		  <p>Recently, there has been a great deal of media attention to the apparent lack of integrity within the industry as it relates to the cremation process.  In an effort to insure a thorough understanding we are attaching a link to the NYS Cremation Authorization Form as we feel this site will assist all in understanding the cremation process. <a href="http://www.dos.ny.gov/formscemeteries/1989-f-l.pdf" target="_blank">http://www.dos.ny.gov/formscemeteries/1989-f-l.pdf</a></p>
		  <p>As many of you are aware, in addition to our association with Pets at Peace, we are licensed funeral directors, and we take our responsibility to you very, very seriously.</p>
		  <p>Integrity is the hallmark by which our profession must be guided.  A number of years back, the Rochester community was shocked by the illegal harvesting of human tissue while under the care of a few disreputable funeral directors.  These reprehensible acts wreaked havoc and undeniably besmirched the reputation of the funeral profession.  Just as our goal in the funeral profession is to uphold the highest standards, we set no less an aspiration for pet cremation.  We have a duty to you as the consumer to insure that you are receiving exactly the service that you are paying for.  Anything short of this mark is a disservice to you and to our profession as a whole.</p>
		  <p>With respect to the current controversy highlighted by the local media, the issue should be exclusively relegated to whether the local pet cremation providers are meeting their obligation to you, the consumer.  We, at Pets at Peace, are proud that we have met this burden, not just with the isolated instance mentioned in the media, but with each individual service provided to over thousands of you since our inception in 2009.</p>
		  <p><strong>Furthermore, we would like to invite you to an open house at 7pm on February 5, 2014 at our Pets at Peace facility to show and help you understand what it is we do.</strong></p>
		  <p><strong><a href="javascript:jQuery('#dialog').dialog('close');">Close Window</a></strong></p>
		</div>-->
		
		<!--
		Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. 
		See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
		-->
		<script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 957351516;
			var google_custom_params = window.google_tag_params;
			var google_remarketing_only = true;
			/* ]]> */
			</script>
			<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
			</script>
			<noscript>
			<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/957351516/?value=0&amp;guid=ON&amp;script=0"/>
			</div>
			</noscript> 
		</script>

	</body>
</html>
		
