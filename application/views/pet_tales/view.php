<script>
jQuery.fn.simplePage = function( options ) {  

  var page = this;
	
  var settings = jQuery.extend( {
  	items : 'li',
  	count : '4',
  	previous : '.prev-btn',
  	next : '.next-btn'
  }, options);
  
  
  var travel = 0;
  //reset page
  var width = 618;
  page.animate({ 'margin-left': travel }, 700, 'easeOutQuad');
  

  var currentPage = 1;
  var itemCount = page.find(settings.items).length;
  var maxPages = Math.ceil( parseInt(itemCount) / parseInt(settings.count) );

  var nextBtn = jQuery(settings.next);
  var prevBtn = jQuery(settings.previous);
  prevBtn.unbind('click');
  nextBtn.unbind('click');

  nextBtn.show();
  prevBtn.hide();
  
  prevBtn.click(function(){

	  currentPage--;
	  travel = ((currentPage*width)-width)*-1;

	  page.animate({ 'margin-left': travel }, 700, 'easeOutQuad');
	  if(travel==0) {
		  prevBtn.hide();
	  }else{
		  prevBtn.show();
	  }
	  
	  if(currentPage==maxPages) {
		  nextBtn.hide();
	  }else{
		  nextBtn.show();
	  }
	  
	  
  });
  
  nextBtn.click(function(){

	  currentPage++;
	  travel = ((currentPage*width)-width)*-1;


	  page.animate({ 'margin-left': travel }, 700, 'easeOutQuad');

	  
	  
	  if(currentPage==maxPages) {
		  nextBtn.hide();
	  }else{
		  nextBtn.show();
	  }
	  
	  if(travel==0) {
		  prevBtn.hide();
	  }else{
		  prevBtn.show();
	  }
	 
  });
};

    jQuery(document).ready(function() {
    	jQuery( "#pet_tale_tabs" ).ctabs();

    	//pet tale add message
    	jQuery("#pet_tale_message_button").click(function(){
    		jQuery("#pet_tale_message_form form").validate({ errorPlacement: function(error, element) { } });

        	if(jQuery("#pet_tale_message_form form").valid()){
	    		jQuery.ajax({
	   			  type: "POST",
	   			  url: "/pet-tales/addmessage",
	   			  data: jQuery("#pet_tale_message_form form").serialize()
	   			}).done(function( msg ) {
		   			if(msg!='1'){
						jQuery(".pet_tale_message_response").html('There was an error saving your message. Please try again or contact us.');
		   			}else{
		   				resetMessage();
		   			}
	   	    		jQuery("#pet_tale_message_form form").fadeOut('slow',function() {
	   	    			jQuery(".pet_tale_message_response").fadeIn();
	   	        	});
	   			});
        	}
        });

    	//pet tale subscribe
    	jQuery("#pet_tale_subscribe_button").click(function(){
    		jQuery("#pet_tale_subscribe_form form").validate({ errorPlacement: function(error, element) { } });

        	if(jQuery("#pet_tale_subscribe_form form").valid()){
	    		jQuery.ajax({
	   			  type: "POST",
	   			  url: "/pet-tales/addsubscriber",
	   			  data: jQuery("#pet_tale_subscribe_form form").serialize()
	   			}).done(function( msg ) {
		   			if(msg!='1'){
						jQuery(".pet_tale_subscribe_response").html('There was an error saving your message. Please try again or contact us.');
		   			}
	   	    		jQuery("#pet_tale_subscribe_form form").fadeOut('slow',function() {
	   	    			jQuery(".pet_tale_subscribe_response").fadeIn();
	   	        	});
	   			});
        	}
        });

        jQuery("#pet_tale_candle_btn").click(function(){
			if(jQuery(".pet_tale_gifts").is(":hidden")) {
				deactivateGiftTabs();
				initGifts();

				jQuery("#pet_tale_candle_btn").addClass('active');
				
				jQuery(".pet_tale_gifts").slideDown();
				jQuery('.pet_tale_gifts ul').simplePage({
					next: '.pet_tale_gift_next',
					previous: '.pet_tale_gift_prev'
		        });
			}
        });
    });

    function initGifts() {
		jQuery(".pet_tale_gifts ul li a").click(function(){
			//update message top
			var message = jQuery(this).data('message');
			var userMessage = jQuery("#pet_tale_message").val();
			if(!userMessage) {
				userMessage = replaceMessageVars(message);
				jQuery("#pet_tale_message").val(userMessage);
				jQuery("#pet_tale_message").html(userMessage);
			}
			
			//update button
			jQuery("#pet_tale_message_button").html("Lite Candle");

			//update image field
			var image = jQuery(this).data('image');
			jQuery("#pet_tale_message_media").val(image);
			
			//update type
			jQuery("#pet_tale_message_type").val('candle');
			
			//remove all other selected
			jQuery(".pet_tale_gifts ul li a").removeClass('selected');
			jQuery(this).addClass('selected');
		});

		//init cancel btn
		jQuery(".pet_tale_gift_cancel").click(function(){
			resetMessage();
		});
    }

	function resetMessage() {
		if(jQuery(".pet_tale_gifts").is(":visible")) {
			jQuery(".pet_tale_gifts").slideUp();
			jQuery("#pet_tale_candle_btn").removeClass('active');
			jQuery(".pet_tale_gifts ul li a").removeClass('selected');
		}
		
		jQuery("#pet_tale_message_type").val('message');
		jQuery("#pet_tale_message_media").val('');
		jQuery("#pet_tale_message_button").html("Share Message");
	}
    
	function replaceMessageVars(text) {
		text =  text.replace('{petName}','<?php echo $story_pet_name; ?>');
		return text;
	}
    
    function deactivateGiftTabs() {
		jQuery(".pet_tale_gift_chooser li").removeClass('active');
    }
</script>

<div id='fb-root'></div>
<script src='http://connect.facebook.net/en_US/all.js'></script>

<div class="pet_tale_container">
	<div class="pet_tale_left_column">
		<a class="pet_tale_image" href="#photos-and-videos" name="View more photos & videos"><img src="<?php echo $story_image;?>" /></a>
		<h3>Share <?php echo $story_pet_name; ?>'s Story</h3>
		<ul class="pet_tale_social">
			<li><a class="pet_tale_facebook" href="#" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u=http://<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>','sharer','toolbar=0,status=0,width=580,height=325')" title="Share on Facebook">Share on Facebook</a></li>
			    <script> 
			  //     FB.init({appId: "344453545633322", status: true, cookie: true});
			
			  //     function postToFeed() {
			
			  //       // calling the API ...
			  //       var obj = {
			  //         method: 'feed',
			  //         redirect_uri: 'http://<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>',
			  //         link: 'http://<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>',
					// <?php if(isset($share_image)){?>
				 //      picture: '<?php echo $share_image;?>',
				 //    <?php } ?>
			  //         name: '<?php echo $share_title;?>',

			  //         description: '<?php echo $share_description;?>'
			  //       };
			
			  //       function callback(response) {
			  //         document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
			  //       }
			
			  //       FB.ui(obj, callback);
			  //     }
			    
			    </script>
			    
			<li><a data-url="<?php echo $share_url?>" data-text="<?php echo $share_title?>" class="pet_tale_twitter twitter-share-button" href="https://twitter.com/share?url=<?php echo $share_url?>&text=<?php echo $share_title?>%20%23petpassages" target="_blank" title="Share on Twitter">Share on Twitter</a></li>
			
			<li><a class="pet_tale_google" href="https://plus.google.com/share?url=<?php echo $share_url?>" target="_blank" title="Share on Google +">Share on Google +</a></li>
			<li><a class="pet_tale_email" href="/pet-tales/share/<?php echo $story_id; ?>" title="Share via Email">Share via Email</a></li>
		</ul>
		<div class="pet_tale_left_buttons">
			<!--<a class="pet_tale_button pet_tale_print pet_tale_button_light" href="#" title="Print this Pet Tale"><span>Print</span></a>  -->
			<?php 
				if($story_music){
					print <<<EOF
						<a id="pet_tale_audio_btn" class="pet_tale_button pet_tale_audio pet_tale_button_light" href="javascript:mute();"><span>Mute Music</span></a>
						<div class="audio_container">
							<audio id='player2' src='$story_music_file' type='audio/mp3' autoplay='true' controls='controls'>
								<!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
							    <source type="audio/mp3" src="$story_music_file.mp4" />
							    <object width="1" height="1" type="application/x-shockwave-flash" data="/js/flashmediaelement.swf">
							       <param name="movie" value="/js/flashmediaelement.swf">
							       <param name="flashvars" value="controls=true&amp;file=$story_music_file">
							    </object>
							</audio>
							<script>
							jQuery('audio,video').mediaelementplayer({
								audioHeight: 20,
								success: function(mediaElement, domObject) {
							        if (mediaElement.pluginType == 'flash') {
							            mediaElement.addEventListener('canplay', function() {
							                // Player is ready
							                mediaElement.play();
							            }, false);
							        }
							    }
							});
							function mute() {
								if(jQuery("audio").prop('muted')) {
									jQuery("audio").prop('muted', false);
									jQuery("#pet_tale_audio_btn span").html('Mute Music');
									jQuery("#pet_tale_audio_btn").removeClass('pet_tale_mute');
									jQuery("#pet_tale_audio_btn").addClass('pet_tale_audio');
								}else{
									jQuery("audio").prop('muted', true);
									jQuery("#pet_tale_audio_btn span").html('Unmute Music');
									jQuery("#pet_tale_audio_btn").removeClass('pet_tale_audio');
									jQuery("#pet_tale_audio_btn").addClass('pet_tale_mute');
								}
							}
							</script>
						</div>
EOF;
				}?>
			<a class="pet_tale_button pet_tale_search pet_tale_button_light" href="/pet-tales" title="Search Pet Tales"><span>Search Pet Tales</span></a>
			<a class="pet_tale_button pet_tale_paw pet_tale_button_dark" href="/pet-tales/add" title="Create a Pet Tale"><span>Create a Pet Tale</span></a>
		</div>
	</div>	
	<div class="pet_tale_right_column">
		<div class="pet_tale_title">
			<h2><?php echo $story_pet_name; ?></h2>
			<?php if($story_pet_birthday!='Not Given' || $story_pet_passdate!='Not Given') {?>
				<p class="pet_tale_birthday"><?php echo $story_pet_birthday; ?> - <?php echo $story_pet_passdate; ?><p>
			<?php } ?>
		</div>
		<div class="pet_tale_top_buttons">
			<?php if($story_next) {?>
				<a class="pet_tale_button pet_tale_button_light pet_tale_next" href="/pet-tales/<?php echo $story_next['story_id']; ?>" title="Next Pet Tale"><span>Next Pet Tale</span></a>
			<?php } ?>
		</div>
		<div id="pet_tale_tabs" class="pet_tale_tabs">
		    <ul class='pet_tale_tabs_list'>
		    	<?php 
		    		if(strlen($story_pet_name) > 20)
		    			$petNameTab = substr($story_pet_name,0,20)."...";
		    		else
		    			$petNameTab = $story_pet_name;
		    	?>
				<li><a class="pt_tab pt_tab_active" id="pet-tale" href="javascript:void(0);"><?php echo $petNameTab?>'s Tale</a></li>
				<li><a class="pt_tab" id="message-wall" href="javascript:void(0);">Message Wall</a></li>
				<li><a class="pt_tab" id="photos-and-videos" href="javascript:void(0);">Photos & Videos</a></li>
				<li><a class="pt_tab" id="subscribe-to-messages" href="javascript:void(0);">Subscribe</a></li>
				<li><a class="pt_tab" style="display:none;" id="unsubscribe" href="javascript:void(0);">Unsubscribe</a></li>
			</ul>
			<div class="pt_tab_content" id="pet-tale-content">
			 	<h4><?php echo $story_title; ?></h4>
		        <p><?php echo $story_body; ?></p>
		    </div>
		    <div class="pt_tab_content pt_tab_message_content" id="message-wall-content">
		        <div class="pet_tale_message_form" id="pet_tale_message_form">
		        	<form name="message_form" id="message_form" method="post" action="">
		        		<div class="pet_tale_message_fields">
			       			<textarea class="pet_tale_form_field required" name="pet_tale_message" id="pet_tale_message" placeholder="Share your own message here..."></textarea>
			       			<input class="pet_tale_form_field required" type="text" name="pet_tale_message_name" placeholder="Name" />
			       			<input class="pet_tale_form_field required email" type="text" name="pet_tale_message_email" placeholder="Email Address" />
			       			<input type="hidden" name="story_id" value="<?php echo $story_id; ?>" />
			       			<input type="hidden" id="pet_tale_message_media" name="pet_tale_message_media" value="" />
			       			<input type="hidden" id="pet_tale_message_type" name="pet_tale_message_type" value="message" />
			       			<a href="javascript:void(0)" id="pet_tale_message_button" class="pet_tale_button pet_tale_button_dark">Share Message</a>
			       		</div>
		       			<ul class="pet_tale_gift_chooser">
		       				<li><a href="javascript:void(0);" id='pet_tale_candle_btn'>Light a Candle</a></li>
		       			</ul>
		       			<div class="pet_tale_gifts">
		       				<ul>			
		    					<?php 
		    						$x=1;
		    						foreach($gifts as $g) {
		    							if($x%4==0)
		    								$class="last";
		    							else
		    								$class = "";
		    								
		    							echo "<li class='$class'><a href='javascript:void(0);' data-message='{$g['gift_message']}' data-image='{$g['gift_image']}' title='Click to light candle'><img src='/images/candles/{$g['gift_image']}' /></a></li>";	
		    							$x++;
		    						}
		    						
		    					?>
		    				</ul>
		    				<a class="pet_tale_gift_next pet_tale_button pet_tale_button_light pet_tale_button_noicon" href="javascript:void(0);"><span>Next</span></a>
		    				<a class="pet_tale_gift_cancel pet_tale_button pet_tale_button_light pet_tale_button_noicon" href="javascript:void(0);"><span>Cancel</span></a>
		    				<a class="pet_tale_gift_prev pet_tale_button pet_tale_button_light pet_tale_button_noicon" href="javascript:void(0);"><span>Previous</span></a>
		       			</div>
		       		</form>
		       		<div class="pet_tale_message_response">Thanks for sharing your message. Your message will be shown on this page within 24-48hrs if it is approved.</div>
		        </div>
		        <div class="pet_tale_messages">
		        	<ul>
			        	<?php 
			        	if($story_messages) {
					        foreach($story_messages as $sm) {
				        		echo "<li><div class='pet_tale_messsage_box'>";
				        		
				        		if($sm['tribute_type']=='candle')
				        			echo "<div class='pet_tale_messsage_image'><img src='/images/candles/{$sm['tribute_media']}' /></div>";
				        		
				        		echo "<p>{$sm['tribute_message']}</p><span>&#8212;{$sm['tribute_name']}</span></div></li>";
				        	}
			        	}else{
				        	echo "<li><div class='pet_tale_messsage_box'><p>Be the first to share a message about $story_pet_name.</p></div></li>";
				        }
			        	?>
		        	</ul>
		        </div>
		    </div>
		    <div class="pt_tab_content" id="photos-and-videos-content">
		    	<?php if(isset($media_list) && count($media_list) > 0) {?>
					<div id="gallery_container" class="pet_tales_gallery" style="height:390px;">
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
										
										//echo '<a href="/images/story/'.$story_id.'/'.$media_file.'"><img src="/images/story/'.$story_id.'/'.$media_file.'" /></a>';
										echo '<img src="/images/story/'.$story_id.'/'.$media_file.'" />';
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
					    	    autoplay: 5000,
					    	    height: .67,
					    	    debug: false,
					    	    wait:true,
					    	    width: 588
					    });
					</script>
				<?php }else{ ?>
					<p class="pet_tale_no_media"><img src="<?php echo $story_image;?>" /><br/>No photos or videos have been added.</p>
				<?php } ?>

		    </div>
		     <div class="pt_tab_content pt_tab_subscribe_content" id="subscribe-to-messages-content">
		        <div class="pet_tale_subscribe">Subscribe to <?php echo $story_pet_name; ?>'s tale to receive updates when new messages have been added to the message wall. We take privacy seriously and do not share your personal information with anyone. Fill in the form below to subscribe.</div>
		        <div class="pet_tale_message_form" id="pet_tale_subscribe_form">
		        	<form name="message_form" id="message_form" class="pet_tale_subscribe_form" method="post" action="">
		       			<div class="pet_tale_message_fields">
			       			<input class="pet_tale_form_field required" type="text" name="pet_tale_subscribe_name" placeholder="Name" />
			       			<input class="pet_tale_form_field required email" type="text" name="pet_tale_subscribe_email" placeholder="Email Address" />
			       			<input type="hidden" name="story_id" value="<?php echo $story_id; ?>" />
			       			<a href="javascript:void(0)" id="pet_tale_subscribe_button" class="pet_tale_button pet_tale_subscribe_button pet_tale_button_dark">Subscribe</a>
			       		</div>
		       		</form>
		       		<div class="pet_tale_subscribe_response">Your are now subscribed to this Pet Tale. Updates will be delievered to the email address you provided.</div>
		        </div>
		    </div>
		    <div class="pt_tab_content pt_tab_unsubscribe_content" id="unsubscribe-content">
		        You have been successfully unsubscribed from this pet tale.
		    </div>
		</div>
	</div>
</div>
