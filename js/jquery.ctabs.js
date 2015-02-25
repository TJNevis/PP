(function( $ ){
	$.fn.ctabs = function() {
		var tabHandle = '.pt_tab';
		var tabContent ='.pt_tab_content';
		var activeTabClass = 'pt_tab_active';
		
		//hide all tabs except 1
		$(tabContent).hide();
		$(tabContent+":first").show();
		$(tabHandle+":first").addClass( activeTabClass );
		
		$(tabHandle).click(function(){
			//remove other active tabs
			$(tabHandle).removeClass( activeTabClass );
			
			//activate tab
			$(this).addClass( activeTabClass );
			
			//hide tabs
			$(tabContent).hide();
			
			//add hash location for direct link
			window.location.hash = $(this).attr('id');
			
			//show tab
			var activeTabContent = "#"+$(this).attr('id')+"-content";
			$(activeTabContent).show();
		});
		
		//if there is a hash tab show that one
		if(window.location.hash) {
			$(window.location.hash).click();
		}
		
	};
})( jQuery );