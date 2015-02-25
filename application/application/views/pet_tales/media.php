<script src="/js/galleria-1.2.7.min.js"></script>

<div id="gallery_container">
	<?php 
		foreach ($media_list as $m) {
			$media_file = $m['media_file'];

			
			switch($m['media_type']){
				case 'image':
					if(!file_exists("/var/www/vhosts/".APPLICATION_BASE_URL."/httpdocs/images/story/$story_id/$media_file")) {
						$media_file = strtolower($media_file);
					}
					if(!file_exists("/var/www/vhosts/".APPLICATION_BASE_URL."/httpdocs/images/story/$story_id/$media_file")) {
						$media_file = strtoupper($media_file);
					}
					
					echo '<a href="/images/story/'.$story_id.'/'.$media_file.'"><img src="/images/story/'.$story_id.'/'.$media_file.'" /></a>';
					break;
				case 'youtube':
					echo "<a href='$media_file'><img src='/site-images/play.png' /></a>";
					break;
			}
		}
	?>
</div>

<script>
    // Load the classic theme
    Galleria.loadTheme('/js/classic/galleria.classic.min.js');

    // Initialize Galleria
    Galleria.run('#gallery_container', {
    	    autoplay: 5000
    });
</script>
