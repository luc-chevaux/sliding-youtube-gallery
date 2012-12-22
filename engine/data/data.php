<?php 
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . 'GMT' );
header('Cache-Control: no-cache, must-revalidate' );
header('Pragma: no-cache' );
header('Content-type: application/json; charset=utf-8');

// include wp loader
$root = realpath(dirname(dirname(dirname(dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME'])))))));

if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
} else {
	// Before 2.6
	require_once($root.'/wp-config.php');
}

// include required wordpress object
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

require_once ('../SygPlugin.php');
require_once ('../SygYouTube.php');
require_once ('../SygConstant.php');
require_once ('../SygDao.php');
require_once ('../SygGallery.php');
require_once ('../SygUtil.php');

// Turn off all error reporting
error_reporting(0);
ini_set('display_errors', 0);

$plugin = SygPlugin::getInstance();

if ($plugin->verifyAuthToken($_SESSION['request_token'])) {
	if ($_GET['table']) {
		switch ($_GET['table']) {
			case 'galleries': 
				if($_GET['page_number']) {
					$page_number = $_GET['page_number'];
					$current_page = $page_number;
					$page_number -= 1;
					$options = $plugin->getOptions();
					$per_page = $options['syg_option_numrec']; // Per page records
					$start = $page_number * $per_page;
					$dao = new SygDao();
					$galleries = $dao->getAllSygGalleries('OBJECT', $start, $per_page);
					$gallery_to_json = array();
					foreach ($galleries as $gallery) {
						array_push($gallery_to_json, $gallery->getJsonData());
					}
					echo json_encode ($gallery_to_json);
				}
				break;
			case 'styles':
				if($_GET['page_number']) {
					$page_number = $_GET['page_number'];
					$current_page = $page_number;
					$page_number -= 1;
					$options = $plugin->getOptions();
					$per_page = $options['syg_option_numrec']; // Per page records
					$start = $page_number * $per_page;
					$dao = new SygDao();
					$styles = $dao->getAllSygStyles('OBJECT', $start, $per_page);
					$style_to_json = array();
					foreach ($styles as $style) {
						array_push($style_to_json, $style->getJsonData());
					}
					echo json_encode ($style_to_json);
				}
				break;
		}
	} elseif ($_GET['query']) {
		switch ($_GET['query']) {
			case 'videos':
				if($_GET['page_number']) {
					$mode = $_GET['mode'];
					$page_number = $_GET['page_number'];
					$current_page = $page_number;
					$page_number -= 1;		
					$options = $plugin->getOptions();
					$per_page = $options['syg_option_pagenumrec']; // Per page records
					$start = $page_number * $per_page;
					$dao = new SygDao();
					$gallery = $dao->getSygGalleryById($_GET['id']);
					$youtube = new SygYouTube();
					$videos = $youtube->getVideoFeed($gallery, $start, $per_page);
					
					$videos_to_json = array();
					foreach ($videos as $entry) {
						$element['video_id'] = $entry->getVideoId();
						$element['video_description'] = $entry->getVideoDescription();
						$element['video_duration'] = SygUtil::formatDuration($entry->getVideoDuration());
						$element['video_watch_page_url'] = $entry->getVideoWatchPageUrl();
						$element['video_title'] = $entry->getVideoTitle();
						$element['video_category'] =$entry->getVideoCategory();
						$element['video_tags'] = $entry->getVideoTags();
						$element['video_rating_info'] = $entry->getVideoRatingInfo();
						$thumbnails = $entry->getVideoThumbnails();
						$element['video_thumbshot'] = $thumbnails[1]['url'];
						// modify the img path to match local files
						if ($mode == SygConstant::SYG_PLUGIN_FE_CACHING_MODE) {
							$element['video_thumbshot'] = WP_PLUGIN_URL .
														SygConstant::WP_PLUGIN_PATH .
														SygConstant::WP_CACHE_THUMB_REL_DIR .
														$gallery->getId() . 
														DIRECTORY_SEPARATOR . 
														$entry->getVideoId() . '.jpg';
						}
						
						array_push($videos_to_json, $element);
					}
					echo json_encode (array_reverse($videos_to_json));
				}
				break;
			default: 
				NULL; 
				break;
		}
	}
}
?>