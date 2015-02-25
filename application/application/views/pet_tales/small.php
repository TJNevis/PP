<?php 
if(strlen($story_body)>220) {
	$story_body = substr($story_body,0,220)."...";
}
?>

<div class='petstory'>
  <table width='290' border='0' cellpadding='0' cellspacing='0' bgcolor='#ECE6B1'>
    <tr><td colspan='3' align='left' valign='top' border='0'><img src='/site-images/frame_top.jpg'></td></tr>
    <tr>
      <td width='22'  align='left' valign='top' border='0' background='/site-images/frame_left.jpg'>&nbsp;</td>
      <td width='245' align='left' valign='top'><p align='center'><span class="small_tale_box_title">Pet Tales</span><span class="small_tale_box_tm">&#8482;</span></p>
      	<?php if(isset($story_image_file)) { ?>
			<table width='180' align='center' cellpadding='10' cellspacing='2' class="small_pet_tale_box_image">
			<tr><td><div align='center'><img src="/images/story/<?php echo $story_id; ?>/<?php echo $story_image_file; ?>" width="170" /></div></td></tr></table>
		<?php } ?>
		<p class='petstory_samp'><?php echo $story_body; ?></p>
		<div align='right'><a href='/pet-tales/<?php echo $story_id; ?>' class='petstory_more'>Read More...</a></div>
		<p align='center'><a class="small_tale_share_btn" href="/pet-tales/add">Share Your Story</a></p>
      </td>
      <td width='23'  align='left' valign='top' border='0' background='/site-images/frame_right.jpg'>&nbsp;</td>
    </tr>
    <tr valign='top'><td height='16' colspan='3' align='left' border='0'><img src='/site-images/frame_bottom.jpg'></td></tr>
  </table>
</div>
