<?php

// include zend loader
$root = realpath(dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"])))))))));

if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
} else {
	// Before 2.6
	require_once($root.'/wp-config.php');
}

// include required wordpress object
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( WP_PLUGIN_DIR . '/sliding-youtube-gallery/engine/SygPlugin.php');

$syg = SygPlugin::getInstance();
$option = $syg->getGallerySettings($_GET['id']);
extract ($option);
?>
jQuery(window).load(function($) {
	if (window.console) console.log('elastislide loading function >> start');
	
	jQuery('#syg-elastislide-<?php echo $id; ?>').elastislide();
	
	if (jQuery.fn.sygclient('isMobileBrowser', this)) {
		$(document).bind("mobileinit", function(){
  			$.mobile.loadingMessage = false;
		});
	}
	
	if (window.console) console.log('elastislide loading function >> end');
});