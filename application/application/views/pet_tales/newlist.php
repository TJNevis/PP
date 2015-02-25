<script type="text/javascript" src="/js/json2.js"></script>
<script type="text/javascript" src="/js/jquery.blockui.js"></script>
<script type="text/javascript" src="/js/date.format.js"></script>
<script>
	
	//default filter valiues
	var sort = 'date';
	var taleLocation = 'site';
	var keyword = '';	
	var petTales = JSON.parse('<?php echo $featuredTales; ?>');

	console.log(petTales);
	
	function genPetTaleListItem(name,birthDate,passDate,id,photo,display) {
		var item = "<li style='display:"+display+"'><a href='/pet-tales/"+id+"' title='View Pet Tale'>";
		item += "<div class='pet_tale_list_photo'><img src='"+photo+"' alt='' /></div>";
		item += "<div class='pet_tale_list_name'><h4>"+name+"</h4><p>"+birthDate+" &#8211; "+passDate+"</p></div>";
		item += "<a class='pet_tale_list_link' href='/pet-tales/"+id+"' title='View Pet Tale'>View Pet Tale</a>";
		item += "</a></li>";

		return item;
	}

	function showLoader(){
		var item = "<li>";
		item += "<p><strong>Loading...</strong></p>";
		item += "</li>";
		jQuery("#pet_tales_list").html(item);
	}

	function showMore() {
		var count = 0;
		jQuery("#pet_tales_list li:hidden").each(function(){
			if(count<15){
				jQuery(this).show();
			}
			count++;
		});

		var hiddenTales = jQuery("#pet_tales_list").find('li:hidden').length;

		if(hiddenTales < 15)
			jQuery("#pet_tale_show_more_button span").html("Show "+hiddenTales+" More Pet Tales");
		
		if(jQuery("#pet_tales_list li:last").is(":visible")) {
			jQuery("#pet_tale_show_more_button").hide();
		}
	}

	function getPetTales(sort,taleLocation,keyword) {
		
		jQuery("#pet_tale_show_more_button").hide();
		
		showLoader();
		
		jQuery.ajax({
		  type: "POST",
		  url: "/pet-tales/ajax_get_tales",
		  data: { sort:  sort, taleLocation: taleLocation, keyword: keyword }
		}).done(function( json ) {
			var tales = JSON.parse(json);
			var petTalesList = "";
			if(tales.length>0) {
				for (var key in tales) {
					var t = tales[key];

					if(key>15){
						var pateTaleDisplay='none';
						jQuery("#pet_tale_show_more_button").show();
					}else{
						var pateTaleDisplay='';
					}
					
					if(t['story_pet_passdate']!='0000-00-00') {
						var talePassDateArray = t['story_pet_passdate'].split("-");
						var talePassDateString = new Date(talePassDateArray[0], talePassDateArray[1], talePassDateArray[2], 0, 0, 0, 0);
						var talePassDate = dateFormat(talePassDateString, "mmm d, yyyy");
					}else{
						talePassDate = 'Unknown';
					}
	
					if(t['story_pet_birthday']!='0000-00-00') {
						var taleBirthDateArray = t['story_pet_birthday'].split("-");
						var taleBirthDateString = new Date(taleBirthDateArray[0], taleBirthDateArray[1], taleBirthDateArray[2], 0, 0, 0, 0);
						var taleBirthDate = dateFormat(taleBirthDateString, "mmm d, yyyy");
					}else{
						taleBirthDate = 'Unknown';
					}
					
					if(t['media_file']){
						var taleImage = "<?php echo "/".$this->config->item('mediaBaseFolder')."/".$this->config->item('storyBaseFolder')."/" ?>"+t['story_id']+"/"+t['media_file'];
					}else{
						var taleImage = "<?php echo $this->config->item('defaultStoryImage');?>";
					}
					taleImage = taleImage.toLowerCase();
					
	
					
					petTalesList += genPetTaleListItem(t['story_pet_name'],taleBirthDate,talePassDate,t['story_id'],taleImage,pateTaleDisplay);
				}
			}else{
				var item = "<li>";
				item += "<p><strong>No Pet Tales were found.</strong></p>";
				item += "</li>";
				petTalesList +=item;
			}
			
			jQuery("#pet_tales_list").html(petTalesList);
		});
	}

	function petTaleRotator() {
	    var initialFadeIn = 1000;
        var itemInterval = 10000;
    	var numberOfItems = petTales.length;

    	var firstImage = Math.floor(Math.random() * (numberOfItems - 0) + 0);
    	var currentItem = firstImage+1;
    	
    	loadImage(firstImage);
    	
    	var infiniteLoop = setInterval(function(){
    		loadImage(currentItem);
			
    		if(currentItem==numberOfItems) {
    			currentItem=0;
    		}else{
    			currentItem++;
    		}
    	}, itemInterval);
	}

	function loadImage(x){
		
		var currentPetTaleName = petTales[x].story_pet_name;
		var currentStoryID = petTales[x].story_id;

		if(currentPetTaleName.length>6){
			currentPetTaleLinkName = currentPetTaleName.substring(6,0)+'...';
		}else{
			currentPetTaleLinkName = currentPetTaleName;
		}

		
		
		if(!petTales[x].media_file) {
			var currentPetTaleImage = "<?php echo $this->config->item('defaultStoryImage');?>";
		}else{
			var currentPetTaleImage = petTales[x].media_file;
			currentPetTaleImage = '<?php echo "/".$this->config->item('mediaBaseFolder')."/".$this->config->item('storyBaseFolder')."/" ?>'+currentStoryID+'/'+currentPetTaleImage.toLowerCase();
		}

			

		jQuery("#featured_pet_tale_image").fadeOut(400,function(){
			jQuery("#featured_pet_tale_name").html(currentPetTaleName);
			jQuery("#featured_pet_tale_image img").attr('src',currentPetTaleImage);
			jQuery("#featured_pet_tale_link").attr('href','/pet-tales/'+currentStoryID);
			jQuery("#featured_pet_tale_link").html('View '+currentPetTaleLinkName+"'s Story");
			jQuery("#featured_pet_tale_image").fadeIn();
		});
	}

    jQuery(document).ready(function() {
    	petTaleRotator();
        
    	jQuery( "#pet_tale_tabs" ).ctabs();

		jQuery("#pet_tale_sort").change(function(){
			sort = jQuery(this).val();
			getPetTales(sort,taleLocation,keyword);
		});

		jQuery("#pet_tale_location_select").change(function(){
			taleLocation = jQuery(this).val();
			getPetTales(sort,taleLocation,keyword);
		});

		jQuery("#pet_tale_keyword").keyup(function(){
			keyword = jQuery(this).val();
			getPetTales(sort,taleLocation,keyword);
		});

		jQuery("#pet_tale_search_button").click(function(){
			keyword = jQuery("#pet_tale_keyword").val();
			getPetTales(sort,taleLocation,keyword);
		});
    	
    	//load pet tales list
		getPetTales(sort,taleLocation,keyword);

		
    });
</script>
<?php 
//	if(strlen($featuredTale['story_pet_name']) > 10)
//		$petNameButton = substr($featuredTale['story_pet_name'],0,6)."...";
//	else
//		$petNameButton = $featuredTale['story_pet_name'];
?>

<div id='fb-root'></div>
<script src='http://connect.facebook.net/en_US/all.js'></script>

<div class="pet_tale_container">
	<div class="pet_tale_left_column">
		<h3 class="pet_tale_featured_title">Featured Pet Tales</h3>
		<a class="pet_tale_image" id="featured_pet_tale_image" href="#photos-and-videos" name="View more photos & videos"><img src="<?php echo $this->config->item('defaultStoryImage');?>" /></a>
		<h3 id="featured_pet_tale_name">Loading...</h3>
		<div class="pet_tale_left_buttons">
			<a id="featured_pet_tale_link" class="pet_tale_button pet_tale_search pet_tale_button_light" href="" title="View Pet Tale"><span>Loading...</span></a>
			<a class="pet_tale_button pet_tale_paw pet_tale_button_dark" href="/pet-tales/add" title="Create a Pet Tale"><span>Create a Pet Tale</span></a>
		</div>
	</div>	
	<div class="pet_tale_right_column">
		<h2 class="page-title">In Memory</h2>
		<?php echo $page_info['content']; ?>
		<div class="pet_tale_search_box">
			<form name="pet_tale_search_form" id="pet_tale_search_form" method="post" action="">
       			<input class="pet_tale_form_field required" type="text" name="pet_tale_keyword" id="pet_tale_keyword" placeholder="Search" />
       			<a href="javascript:void(0)" id="pet_tale_search_button" class="pet_tale_button pet_tale_button_light">Search</a>
       		</form>
       		<div class="pet_tale_filters">
       			<ul>
       				<li>
       					<label for="pet_tale_sort">Sort By</label>
		       			<select name="pet_tale_sort" id="pet_tale_sort" class="pet_tale_sort">
		       				<option value="date" selected="selected">Passage Date</option>
		       				<option value="name">Pet Name</option>
		       			</select>
		       		</li>
		       		<li>
		       			<label for="pet_tale_location">Location</label>
		       			<select name="pet_tale_location_select" class="pet_tale_location_select" id="pet_tale_location_select">
		       				<?php foreach($locations as $l) {?>
		       					<?php echo "<option value='{$l['site_id']}'>{$l['name']}</option>"?>
		       				<?php } ?>
		       			</select>
		       		</li>
		       	</ul>
       		</div>
       	</div>
       	<div class="pet_tale_list_container">
   			<ul id="pet_tales_list" class="pet_tales_list"><li><p><strong>Loading...</strong></p></li></ul>
   			<div class="pet_tale_show_more">
   				<a class="pet_tale_button pet_tale_paw pet_tale_button_dark" id="pet_tale_show_more_button" href="javascript:showMore();" title="Show More Pet Tales"><span>Show 15 More Pet Tales</span></a>
   			</div>
   		</div>
	</div>
</div>
