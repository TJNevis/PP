<?php 
header ("Content-Type:text/xml");
echo "<?xml version='1.0' encoding='utf-8'?><playlist version='1' xmlns='http://xspf.org/ns/0/'>\n";
echo "<trackList>";
foreach ($media as $m) {
	if($m['media_type']=="image"){
		echo "<track><location>/images/story/".$m['story_id']."/".$m['media_file']."</location></track>";
	}
}
echo "</trackList></playlist>";