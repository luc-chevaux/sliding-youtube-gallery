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
require_once( ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygPlugin.php');

$syg = SygPlugin::getInstance();
$option = $syg->getGallerySettings($_GET['id']);
extract ($option);
?>
jQuery(window).load(function() {

	jQuery('#syg_video_page-<?php echo $id; ?>')
		.removeClass('syg_video_gallery_loading-<?php echo $id; ?>');
		
	jQuery('#paginator-top-<?php echo $id; ?>')
		.removeAttr("style");
		
	jQuery('#paginator-bottom-<?php echo $id; ?>')
		.removeAttr("style");
});