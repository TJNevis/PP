<script src='http://maps.google.com/maps?file=api&v=2&key=' type='text/javascript'></script>
<div align="left">
<table border="0" cellspacing="0" cellpadding="0" width="880">
	<tr>
		<td width="650" valign="top">
			<div id="map" style="width: 650px; height: 600px"></div>
		</td>
        <td width="230" bgcolor="#ffffff" valign="top" align="left">
        	<div class="location_list" id="sidebar">
        		<?php 
        		$x=0;
        		foreach($locations as $l) {
        		
        		?>
        		<span class='location_name'>
        			<a class='listlink' href="javascript:myclick('<?php echo $x?>')"><?php echo $l['loc_name']?></a>
        		</span><br />
        		<span class='location_address'>
        			<a href='<?php echo $l['loc_website']; ?>' target='_blank'>Visit Website</a>
        			<br />
        		</span>
        		<span class='location_address'><?php echo $l['loc_address1']; ?><br /><?php echo ($l['loc_address2']) ? $l['loc_address2']."<br />" : ""; ?><?php echo $l['loc_city']; ?>, <?php echo $l['loc_state']; ?> <?php echo $l['loc_zip']; ?><br />Phone: </span><span class='location_phone'><?php echo $l['loc_phone']; ?></span>
        		<br><br>
        		<?php 
        		$x++;
        		} 
        		?>
        	</div>
       </td>
	</tr>
	<tr colspan="2" align="right"><td><a href='http://national.petpassages.com/locations'>Return to National Directory Map</a></tr></tr>
      </table>	
      <script type="text/javascript">
        //<![CDATA[
            var i = 0;
            var gmarkers = [];
            var htmls = [];
            var to_htmls = [];
            var from_htmls = [];

            function createMarker(point,name,html,address) {
				var marker = new GMarker(point);

            	GEvent.addListener(marker, "click", function() {
              marker.openInfoWindowHtml(html);
            });
            gmarkers[i] = marker;
            i++;
            return marker;
          }

        // This function picks up the click and opens the corresponding info window
        function myclick(i) { gmarkers[i].openInfoWindowHtml(htmls[i]); }

        // functions that open the directions forms
        function tohere(i) { gmarkers[i].openInfoWindowHtml(to_htmls[i]); }
        
        function fromhere(i) { gmarkers[i].openInfoWindowHtml(from_htmls[i]); }
              
	function fitMap( map, gmarkers ) {
	   var bounds = new GLatLngBounds();
	   for (var i=0; i< gmarkers.length; i++) { bounds.extend(gmarkers[i].getLatLng()) }

		if (gmarkers.length <= 1) {
		  map.setZoom(10);
		} else {
		 map.setZoom(map.getBoundsZoomLevel(bounds));
		}     
	   
	   map.setCenter(bounds.getCenter());
	}

        if (GBrowserIsCompatible()) {
            // create the map
            var map = new GMap2(document.getElementById("map"));
            map.addControl(new GLargeMapControl());
            map.addControl(new GMapTypeControl());
            map.setCenter(new GLatLng(27.75,-82.6),10);
       		<?php 
       		$x=0;
       		foreach($locations as $l) {
       		$l['loc_body'] = str_replace("\n","",$l['loc_body']);
       		$l['loc_body'] = str_replace("\r","",$l['loc_body']);
       		?>
			    htmls[<?php echo $x?>]="<div class='location_container'><div class='location_details'><span class='location_name'><?php echo ascii_to_entities($l['loc_name'])?></span><div class='location_pic'><? if($l['loc_pic_path']) { ?><img src='/images/locations/<?php echo $l['loc_pic_path']; ?>' width='100' /><? } ?></div><p><br /><span class='location_address'><a href='<?php echo $l['loc_website']; ?>' target='_blank'>Visit Website</a><br /><?php echo $l['loc_address1']; ?><br /><?php echo ($l['loc_address2']) ? $l['loc_address2']."<br />" : ""; ?><?php echo $l['loc_city']; ?>, <?php echo $l['loc_state']; ?> <?php echo $l['loc_zip']; ?><br>Phone: <?php echo $l['loc_phone']; ?></span></p><span class='location_name'><?php echo ($l['loc_head']) ? $l['loc_head'] : $l['loc_city'].", ".$l['loc_state']; ?><br></span><p class='location_text'><?php echo strip_tags($l['loc_body']); ?><br><br></span></p><br>Directions: <a href='javascript:tohere(<?php echo $x?>);'>To here</a> - <a href='javascript:fromhere(<?php echo $x?>);'>From here</a><br><br></div>";
				to_htmls[<?php echo $x?>]="<div class='location_container'><div class='location_details'><span class='location_name'><?php echo ascii_to_entities($l['loc_name'])?></span><div class='location_pic'><img src='/images/locations/<?php echo $l['loc_pic_path']; ?>' width='100' /></div><p><br /><span class='location_address'><a href='<?php echo $l['loc_website']; ?>' target='_blank'>Visit Website</a><br /><?php echo $l['loc_address1']; ?><br /><?php echo ($l['loc_address2']) ? $l['loc_address2']."<br />" : ""; ?><?php echo $l['loc_city']; ?>, <?php echo $l['loc_state']; ?> <?php echo $l['loc_zip']; ?><br>Phone: <?php echo $l['loc_phone']; ?></span></p><span class='location_name'><?php echo ($l['loc_head']) ? $l['loc_head'] : $l['loc_city'].", ".$l['loc_state']; ?><br></span><p class='location_text'><?php echo strip_tags($l['loc_body']); ?><br><br></span></p><br>Directions: <b>To here</b> - <a href='javascript:fromhere(<?php echo $x?>)'>From here</a><br>Start address:<form action='http://maps.google.com/maps' method='get' target='_blank'><input type='text' SIZE=40 MAXLENGTH=40 name='saddr' id='saddr' value='' /><br><INPUT value='Get Directions' TYPE='SUBMIT'><input type='hidden' name='daddr' value='<?php echo $l['loc_address1']; ?> <?php echo $l['loc_city']; ?>, <?php echo $l['loc_state']; ?> <?php echo $l['loc_zip']; ?>' /><br><br></div>";
				from_htmls[<?php echo $x?>]="<div class='location_container'><div class='location_details'><span class='location_name'><?php echo ascii_to_entities($l['loc_name'])?></span><div class='location_pic'><img src='/images/locations/<?php echo $l['loc_pic_path']; ?>' width='100' /></div><p><br /><span class='location_address'><a href='<?php echo $l['loc_website']; ?>' target='_blank'>Visit Website</a><br /><?php echo $l['loc_address1']; ?><br /><?php echo ($l['loc_address2']) ? $l['loc_address2']."<br />" : ""; ?><?php echo $l['loc_city']; ?>, <?php echo $l['loc_state']; ?> <?php echo $l['loc_zip']; ?><br>Phone: <?php echo $l['loc_phone']; ?></span></p><span class='location_name'><?php echo ($l['loc_head']) ? $l['loc_head'] : $l['loc_city'].", ".$l['loc_state']; ?><br></span><p class='location_text'><?php echo strip_tags($l['loc_body']); ?><br><br></span></p><br>Directions: <a href='javascript:tohere(<?php echo $x?>)'>To here</a> - <b>From here</b><br>End address:<form action='http://maps.google.com/maps' method='get' target='_blank'><input type='text' SIZE=40 MAXLENGTH=40 name='daddr' id='daddr' value='' /><br><INPUT value='Get Directions' TYPE='SUBMIT'><input type='hidden' name='saddr' value='<?php echo $l['loc_address1']; ?> <?php echo $l['loc_city']; ?>, <?php echo $l['loc_state']; ?> <?php echo $l['loc_zip']; ?>' /><br><br></div>";
				var point = new GLatLng(<?php echo $l['loc_lat']; ?>,<?php echo $l['loc_lng']; ?>);
				var marker = createMarker(point,"<?php echo ascii_to_entities($l['loc_name'])?>, <?php echo $l['loc_state']; ?>",htmls[<?php echo $x?>],'<?php echo $l['loc_address1']; ?>, <?php echo $l['loc_state']; ?> <?php echo $l['loc_zip']; ?>');
				map.addOverlay(marker);
     		<?php 
       		$x++;
       		} 
       		?>
            fitMap(map,gmarkers);
          }
          else { alert("Sorry, the Google Maps API is not compatible with this browser"); 
        }
        //]]>
      </script>
    </div>
