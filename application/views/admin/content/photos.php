<div id="photo-list-container">
	<ul id="photo-list">
	<?php 
	foreach($photos as $p) {
		$photo_id = $p['photo_id'];
		$photo = "<img src='/images/photos/$photo_id.jpg' />";
		echo "<li><a id='$photo_id' class='photo-link'>$photo</a></li>";
	}
	?>
	</ul>
</div>