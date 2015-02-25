<?php 
function mcedev($name,$value,$mode='simple') {
	$ret=<<<EOF
	<script type="text/javascript" src="/js/tinymce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
		        // General options
		        mode : "textareas",
		        theme : "advanced",
		        editor_selector :"mce",
		        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advimage",
		
		        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,image,|,code",
		        theme_advanced_buttons2 : "",
		        theme_advanced_buttons3 : "",
		        theme_advanced_buttons4 : "",
		        theme_advanced_toolbar_location : "top",
		        theme_advanced_toolbar_align : "left",
		        theme_advanced_statusbar_location : "bottom",
		        theme_advanced_resizing : true
		});
	</script>
	<textarea class="mce" id="$name" name="$name">$value</textarea>dev
EOF;
	return $ret;
}
?>