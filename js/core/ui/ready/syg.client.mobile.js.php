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

// Turn off all error reporting
error_reporting(0);

$syg = SygPlugin::getInstance();

$id = $_GET['id'];

$option = $syg->getGallerySettings($id);
extract ($option);
$pluginOpt = $syg->getOptions();
extract ($pluginOpt);

// video format
$wideOrNormal = SygUtil::extractType($syg_youtube_videoformat);
$video_width = SygUtil::extractWidth($syg_youtube_videoformat);
$video_height = ($wideOrNormal == 'n') ? SygUtil::getNormalHeight($video_width) : $height = SygUtil::getWideHeight($video_width);

if (array_key_exists ('ui', $_GET)) $uiType = $_GET['ui'];
if (array_key_exists ('cache', $_GET)) $cache = $_GET['cache'];

// set http header
header('Content-type: text/javascript; charset=utf-8');
header('Expires: '.gmdate("D, d M Y H:i:s", time() + 3600*24*365).' GMT');
?>

jQuery.noConflict();
(function($) {
$(document).on('pageinit', function(){

	if (window.console) console.log('sliding youtube gallery >> start pageinit function');
	
	var options = new Array();
	var gid = new Array();
	
	gid['<?php echo $id; ?>'] = <?php echo $id; ?>;	
	options['plugin_root'] = '<?php echo $syg->getPluginRoot(); ?>'; // string
	options['img_root'] = '<?php echo $syg->getImgRoot(); ?>'; // string
	options['thumbnail_image'] = '<?php echo $syg_thumbnail_image; ?>'; // string
	options['description_show'] = <?php echo (empty($syg_description_show)) ?  "0" : $syg_description_show; ?>; // boolean
	options['description_showduration'] = <?php echo (empty($syg_description_showduration)) ? "0" : $syg_description_showduration; ?>; // boolean
	options['description_showcategories'] = <?php echo (empty($syg_description_showcategories)) ? "0" : $syg_description_showcategories; ?>; // boolean
	options['description_showtags'] = <?php echo (empty($syg_description_showtags)) ? "0" : $syg_description_showtags; ?>; // boolean
	options['description_showratings'] = <?php echo (empty($syg_description_showratings)) ? "0" : $syg_description_showratings; ?>; // boolean
	options['description_length'] = <?php echo $syg_option_description_length; ?>;
	options['json_query_if_url'] = '<?php echo $syg->getJsonQueryIfUrl(); ?>'; // string
	
	options['video_width'] = <?php echo $video_width; ?>; // int
	options['video_height'] = <?php echo $video_height; ?>; // int
	
	<?php if ($cache == 'on') { ?>
		options['cache'] = '<?php echo $cache; ?>';
		<?php 
			$jsonUrl = plugins_url() .
						SygConstant::WP_PLUGIN_PATH .
						SygConstant::WP_CACHE_JSON_REL_DIR .
						$id .
						DIRECTORY_SEPARATOR; 
			$firstPageUrl = $jsonUrl . '1.json';
		?>
		options['jsonUrl'] = '<?php echo $jsonUrl;?>';
	<?php } ?>
		
	<?php if ($uiType == SygConstant::SYG_PLUGIN_COMPONENT_GALLERY) { ?>
		/* video gallery */
		$.fn.sygclient('addFancyBoxSupport', gid['<?php echo $id; ?>'], options);
	<?php } ?>
	
	if (window.console) console.log('sliding youtube gallery >> end pageinit function');

});})(jQuery);