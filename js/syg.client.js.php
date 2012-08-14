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
?>

/************************************************
 # jQuery on ready function:					#
 # load fancybox and visual effects				# 
 ************************************************/ 

jQuery(document).ready(function($){
	gid = <?php echo $id; ?>
	
	options['plugin_root']
	options['description_show']
	options['video_thumbnail']
	options['img_root']
	options['description_showduration']
	options['description_showcategories']
	options['description_showtags']
	options['description_showratings']
	options['json_query_if_url']
	options['width']
	options['height']
		
	// load if page contains a list
	if ($('#syg_video_container-' + gid).length){
		/* video page */
		// loading images
		$.displayLoad(gid);
		
		// get the data
		$.getJSON(options['json_query_if_url'] + '?query=videos&page_number=1&id=' + gid, function (data) {$.loadData(data, gid, options);});
		
		// add pagination events
		$.addPaginationClickEvent(gid, options);
	} else {
		/* video gallery */
		$.addFancyBoxSupport(gid, options);
	}
});  