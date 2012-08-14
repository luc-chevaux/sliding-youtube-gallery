<?php

// set header type
header('Content-type: text/javascript');

// include zend loader
$root = realpath(dirname(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"]))))));

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

$id = $_GET['id'];

$option = $syg->getGallerySettings($id);
extract ($option);

$type = SygUtil::extractType($syg_youtube_videoformat);
$width = SygUtil::extractWidth($syg_youtube_videoformat);

if ($type == 'n') {
	$height = SygUtil::getNormalHeight($width);
} else {
	$height = SygUtil::getWideHeight($width);
}

$width += 20;
$height += 20;

$uiType = $_GET['ui'];

?>

/************************************************
 # jQuery on ready function:					#
 # load fancybox and visual effects				# 
 ************************************************/ 

jQuery(document).ready(function($){
	var options = new Array();
	var gid = new Array();
	
	gid['<?php echo $id; ?>'] = <?php echo $id; ?>;	
	options['plugin_root'] = '<?php echo $syg->getPluginRoot(); ?>'; // string
	options['img_root'] = '<?php echo $syg->getImgRoot(); ?>'; // string
	options['thumbnail_image'] = '<?php echo $syg_thumbnail_image; ?>'; // string
	options['description_show'] = <?php echo (boolean)$syg_description_show; ?>; // boolean
	options['description_showduration'] = <?php echo (boolean)$syg_description_showduration; ?>; // boolean
	options['description_showcategories'] = <?php echo (boolean)$syg_description_showcategories; ?>; // boolean
	options['description_showtags'] = <?php echo (boolean)$syg_description_showtags; ?>; // boolean
	options['description_showratings'] = <?php echo (boolean)$syg_description_showratings; ?>; // boolean
	
	options['json_query_if_url'] = '<?php echo $syg->getJsonQueryIfUrl(); ?>'; // string
	
	options['width'] = <?php echo $width; ?>; // int
	options['height'] = <?php echo $height; ?>; // int
		
	<?php if ($uiType == SygConstant::SYG_PLUGIN_COMPONENT_PAGE) { ?>		
		/* video page */
		// loading images
		$.displayLoad(gid['<?php echo $id; ?>']);
		
		// get the data
		$.getJSON(options['json_query_if_url'] + '?query=videos&page_number=1&id=' + gid['<?php echo $id; ?>'], function (data) {$.loadData(data, gid['<?php echo $id; ?>'], options);});
		
		// add pagination events
		$.addPaginationClickEvent(gid['<?php echo $id; ?>'], options);
	<?php } else if ($uiType == SygConstant::SYG_PLUGIN_COMPONENT_GALLERY) { ?>
		/* video gallery */
		$.addFancyBoxSupport(gid['<?php echo $id; ?>'], options);
	<?php }?>
});  