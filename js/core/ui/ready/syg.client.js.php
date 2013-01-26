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
	options['description_show'] = <?php echo $syg_description_show; ?>; // boolean
	options['description_showduration'] = <?php echo $syg_description_showduration; ?>; // boolean
	options['description_showcategories'] = <?php echo $syg_description_showcategories; ?>; // boolean
	options['description_showtags'] = <?php echo $syg_description_showtags; ?>; // boolean
	options['description_showratings'] = <?php echo $syg_description_showratings; ?>; // boolean
	
	options['json_query_if_url'] = '<?php echo $syg->getJsonQueryIfUrl(); ?>'; // string
	
	options['video_width'] = <?php echo $video_width; ?>; // int
	options['video_height'] = <?php echo $video_height; ?>; // int
	
	<?php if ($cache == 'on') { ?>
		options['cache'] = '<?php echo $cache; ?>';
		<?php 
		$jsonUrl = WP_PLUGIN_URL . 
					SygConstant::WP_PLUGIN_PATH .
					SygConstant::WP_CACHE_JSON_REL_DIR .
					$id .
					DIRECTORY_SEPARATOR; 
		$firstPageUrl = $jsonUrl . '1.json';
		?>
		options['jsonUrl'] = '<?php echo $jsonUrl;?>';
	<?php } ?>
		
	<?php if ($uiType == SygConstant::SYG_PLUGIN_COMPONENT_PAGE) { ?>		
		/* video page */
		// loading images
		$.displayLoad(gid['<?php echo $id; ?>']);
		<?php if ($cache == 'on') { ?>			
			// get the data
			$.getJSON('<?php echo $firstPageUrl; ?>', function (data) {$.loadData(data, gid['<?php echo $id; ?>'], options);});
		<?php } else { ?>
			// get the data
			$.getJSON(options['json_query_if_url'] + '?query=videos&page_number=1&id=' + gid['<?php echo $id; ?>'], function (data) {$.loadData(data, gid['<?php echo $id; ?>'], options);});
		<?php } ?>
		// add pagination events
		$.addPaginationClickEvent(gid['<?php echo $id; ?>'], options);
	<?php } else if ($uiType == SygConstant::SYG_PLUGIN_COMPONENT_GALLERY) { ?>
		/* video gallery */
		$.addFancyBoxSupport(gid['<?php echo $id; ?>'], options);
	<?php } else if ($uiType == SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL) { ?>				   
		// This initialises carousels on the container elements specified, in this case, carousel1.
		$('#syg_video_carousel-' + gid['<?php echo $id; ?>']).CloudCarousel({
			minScale: <?php echo $syg_option_carousel_minscale; ?>,
			reflHeight: <?php echo $syg_option_carousel_reflheight; ?>,
			reflGap: <?php echo $syg_option_carousel_reflgap; ?>, 
			speed: <?php echo $syg_option_carousel_speed; ?>,
			mouseWheel: true, 
			FPS: <?php echo $syg_option_carousel_fps; ?>,
			xPos: <?php echo ceil($syg_box_width/2); ?>, // half the height of container.
			yPos: <?php echo ceil((($syg_thumbnail_height*2.5)/2)/2); ?>, // half the width of the container.
			yRadius: <?php echo ceil($syg_thumbnail_height*2.5/6); ?>, // da 0 a 100 Height of container / 6
			xRadius: <?php echo ceil($syg_box_width/2.3); ?>, // percentuale al container Width of container / 2.3
			autoRotate: '<?php echo $syg_option_carousel_autorotate; ?>',
			<?php if ($syg_option_carousel_autorotate == "yes") { ?>
			autoRotateDelay: <?php echo $syg_option_carousel_delay; ?>,
			<?php } else { ?>
			buttonLeft: $("#left-carousel-button-<?php echo $id; ?>"),
			buttonRight: $("#right-carousel-button-<?php echo $id; ?>"),
			<?php } ?>
			titleBox: $("#carousel-title-<?php echo $id; ?>")
		});
		$.addFancyBoxSupport(gid['<?php echo $id; ?>'], options);
	<?php } ?>
});  