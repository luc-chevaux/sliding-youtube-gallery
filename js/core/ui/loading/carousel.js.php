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
	
	if (window.console) console.log('carousel loading function >> start');
	
	$('#syg_video_carousel-<?php echo $id; ?>').removeClass('syg_video_carousel_loading-<?php echo $id; ?>');
	$('#syg_video_carousel-<?php echo $id; ?>').addClass('syg_video_carousel-<?php echo $id; ?>');
	
	/* remove display none */
	$('#hidden-carousel-layer_<?php echo $id;?>').removeAttr('style');	
	
	$("#left-carousel-button-<?php echo $id; ?>").on('mouseenter', function () {
	    $(this).find('.left-carousel-button-<?php echo $id; ?>').fadeTo('fast', 1);
	});
	
	$("#left-carousel-button-<?php echo $id; ?>").on('mouseleave', function () {
	    $(this).find('.left-carousel-button-<?php echo $id; ?>').fadeTo('slow', 0.3);
	});
	
	$("#right-carousel-button-<?php echo $id; ?>").on('mouseenter', function () {
	   $(this).find('.right-carousel-button-<?php echo $id; ?>').fadeTo('fast', 1);
	});
	
	$("#right-carousel-button-<?php echo $id; ?>").on('mouseleave', function () {
	   $(this).find('.right-carousel-button-<?php echo $id; ?>').fadeTo('slow', 0.3);
	});
	
	if (window.console) console.log('carousel loading function >> end');
});})(jQuery);