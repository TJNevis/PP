<?php 
$leftImage = "";
$rightImage = "";
switch($url) {
	case "/" :
		if($image)
			$leftImage = "<img src='/site-images/content/$image' style='float:left; margin:20px 10px 10px 10px;' />";
		break;
	default:
		if($image)
			$rightImage = "<img src='/site-images/content/$image' style='height:300px; float:right; margin:60px 0 10px 30px;' />";
}


?>
<h2 class="page-title"><?php echo $title ?></h2>
<?php if($url=="/") {  ?>
	<?php echo $pet_tale_box; ?>
<?php } ?>
<?php //echo $rightImage; ?>
<?php echo $content ?>

<?php //echo $leftImage; ?>
<h2><?php echo $title2 ?></h2>
<?php echo $content2 ?>

<h2><?php echo $title3 ?></h2>
<?php echo $content3 ?>

<?php
if($_SERVER['SERVER_NAME']!='petpassages.com' && $_SERVER['SERVER_NAME']!='national.petpassages.com' && $_SERVER['SERVER_NAME']!='www.petpassages.com') {
	print <<<EOF
	<p>&nbsp;</p>
	<table style="width: 50%;" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="width: 50%; text-align: left;" valign="top">
<p><strong style="font-size: 10px;">Licensed Affiliate of</strong></p>
<p><a href="http://national.petpassages.com" target="_blank"><img style="width: 150px;" src="../../../site-images/petpassages_logo_small.jpg" alt=""></a></p>
</td>
<td style="width: 50%; text-align: left;" valign="top">
<p><span style="font-size: 10px;">&nbsp;</span></p>
</td>
</tr>
</tbody>
</table>
EOF;
}
?>

<?php if($url=="locations") {  ?>
	<script src='http://maps.google.com/maps?file=api&v=2&key=' type='text/javascript'></script>
<?php } ?>
