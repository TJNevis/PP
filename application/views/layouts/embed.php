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
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="<?php echo $site_name; ?> is proud to be able to offer pet loss services to our community with the same high standards we abide by every day for our human family, friends and acquaintances." />
		<meta name="keywords" content="pet loss, pet cremation, pets at peace, pet funeral" />
		<link rel="stylesheet" type="text/css" href="/css/style.css?v=9" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/ui-custom-theme/jquery-ui-1.8.20.custom.css" media="all" />
		<link href='http://fonts.googleapis.com/css?family=Unkempt:700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="/css/ui-custom-theme/table_jui.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/templates/<?php echo $template_id?>.css?v=<?php echo time();?>" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/embed.css" media="all" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		
		
		<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/jquery.cycle.lite.js"></script>
		<script type="text/javascript" src="/js/jquery.ctabs.js"></script>
		<script type="text/javascript" src="/js/jquery.placeholder.js"></script>
		<script type="text/javascript" src="/js/jquery.validate.js"></script>
		<script type="text/javascript" src="/js/jquery-ui-1.8.20.custom.min.js"></script>

		<script type="text/javascript" src="/js/plupload.js"></script>
		<script type="text/javascript" src="/js/plupload.gears.js"></script>
		<script type="text/javascript" src="/js/plupload.silverlight.js"></script>
		<script type="text/javascript" src="/js/plupload.flash.js"></script>
		<script type="text/javascript" src="/js/plupload.browserplus.js"></script>
		<script type="text/javascript" src="/js/plupload.html4.js"></script>
		<script type="text/javascript" src="/js/plupload.html5.js"></script>
		
		<script type="text/javascript" src="/js/jquery.cycle.lite.js"></script>
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

		<meta property="og:title" content="<?php echo $facebook_title; ?>"/>
		<meta property="og:image" content="<?php echo $facebook_image; ?>"/>
		<meta property="og:description" content='<?php echo $facebook_description; ?>'/>
		<meta property="og:url" content='<?php echo $facebook_url; ?>'/>
	</head>
	<body>
		<div id="container">
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

	jQuery(document).ready(function(){
		jQuery('input, textarea').placeholder();
	});
  
</script>
	
 <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/easyXDM/2.4.17.1/easyXDM.min.js"></script>
<script type="text/javascript">
var socket = new easyXDM.Socket({
    onReady:  function(){
        socket.postMessage(document.body.scrollHeight)
   }
});
</script>
	
