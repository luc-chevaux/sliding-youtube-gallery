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

// set http header
header('Content-type: text/javascript; charset=utf-8');
header('Expires: '.gmdate("D, d M Y H:i:s", time() + 3600*24*365).' GMT');
?>
jQuery.noConflict();
(function($) {
$(window).load(function() {
	if (window.console) console.log('elastislide loading function >> start');
	
	$('#syg-elastislide-<?php echo $id; ?>').elastislide();
	
	if ($.fn.sygclient('isMobileBrowser')) {
		$.mobile.hidePageLoadingMsg();
	}
	
	if (window.console) console.log('elastislide loading function >> end');
});})(jQuery);