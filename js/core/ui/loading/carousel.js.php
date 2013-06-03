<?php
// da verificare se tutti questi include servono
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
	if (window.console) console.log('carousel loading function >> start');
	
	jQuery('#syg_video_carousel-<?php echo $id; ?>')
		.removeClass('syg_video_carousel_loading-<?php echo $id; ?>')
		.addClass('syg_video_carousel-<?php echo $id; ?>');
		
	/* remove display none */
	jQuery('#hidden-carousel-layer_<?php echo $id;?>').removeAttr('style');	
	
	jQuery("#left-carousel-button-<?php echo $id; ?>").on('mouseenter', function () {
	    jQuery(this).find('.left-carousel-button-<?php echo $id; ?>').fadeTo('fast', 1);
	});
	
	jQuery("#left-carousel-button-<?php echo $id; ?>").on('mouseleave', function () {
	    jQuery(this).find('.left-carousel-button-<?php echo $id; ?>').fadeTo('slow', 0.3);
	});
	
	jQuery("#right-carousel-button-<?php echo $id; ?>").on('mouseenter', function () {
	   jQuery(this).find('.right-carousel-button-<?php echo $id; ?>').fadeTo('fast', 1);
	});
	
	jQuery("#right-carousel-button-<?php echo $id; ?>").on('mouseleave', function () {
	   jQuery(this).find('.right-carousel-button-<?php echo $id; ?>').fadeTo('slow', 0.3);
	});
	
	if (jQuery.fn.sygclient('isMobileBrowser', this)) {
		$(document).bind("mobileinit", function(){
  			$.mobile.loadingMessage = false;
		});
	}
	
	if (window.console) console.log('carousel loading function >> end');
});