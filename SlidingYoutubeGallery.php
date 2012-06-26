<?php

/**
 * Plugin name: Sliding Youtube Gallery
 * Plugin URI: http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/
 * Author: webeng
 * Author URI: http://blog.webeng.it/
 * Version: 1.2.4
 * Description: Sliding YouTube Gallery is a WordPress plugin, that gives you a fast way for adding video from a youtube user’s channel. User can choose to display the videos in a fully customizable sliding gallery or in a video page.
 */

// library path
$lib_path = WP_PLUGIN_DIR.'/sliding-youtube-gallery/engine/lib';

// set include path
set_include_path (get_include_path() . PATH_SEPARATOR . $lib_path);

// include required wordpress object
require_once (ABSPATH . 'wp-admin/includes/plugin.php');
require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

// include engine
require_once (WP_PLUGIN_DIR.'/sliding-youtube-gallery/engine/SygPlugin.php');
require_once (WP_PLUGIN_DIR.'/sliding-youtube-gallery/engine/SygConstant.php');
require_once (WP_PLUGIN_DIR.'/sliding-youtube-gallery/engine/SygDao.php');
require_once (WP_PLUGIN_DIR.'/sliding-youtube-gallery/engine/SygGallery.php');
require_once (WP_PLUGIN_DIR.'/sliding-youtube-gallery/engine/SygUtil.php');
require_once (WP_PLUGIN_DIR.'/sliding-youtube-gallery/engine/SygYouTube.php');

// register activation hook
register_activation_hook(WP_PLUGIN_DIR.'/sliding-youtube-gallery/SlidingYoutubeGallery.php', 'activate');
register_deactivation_hook(WP_PLUGIN_DIR.'/sliding-youtube-gallery/SlidingYoutubeGallery.php', 'deactivate');
register_uninstall_hook(WP_PLUGIN_DIR.'/sliding-youtube-gallery/SlidingYoutubeGallery.php', 'uninstall');

// backend and frontend code
if(!is_admin()) {
	// front end code block
	// add shortcodes
	add_shortcode('syg_gallery', 'getGallery');
	add_shortcode('syg_page', 'getVideoPage');
}else {
	// back end code block
	// attach the admin menu to the hook
	add_action('admin_menu', 'SlidingYoutubeGalleryAdmin');
}

/**
 * Get a video gallery
 * @param $atts, list of shortcode attributes
 * @return null
 */
function getGallery($atts) {
	$syg = SygPlugin::getInstance();
	return $syg->getGallery($atts);
}

/**
 * Get a video page
 * @param $atts
 */
function getVideoPage($atts) {
	$syg = SygPlugin::getInstance();
	return $syg->getVideoPage($atts);
}

// Sliding youtube gallery options page
function SlidingYoutubeGalleryAdmin () {
	$syg = SygPlugin::getInstance();
	add_options_page('Sliding YouTube Gallery', 'YouTube Gallery', 'manage_options', 'syg-administration-panel', 'sygAdminHome');
}

/**
 * Plugin administration homepage
 * @return null
 */
function sygAdminHome() {
	$syg = SygPlugin::getInstance();
	echo $syg->sygAdminHome();
}

/**
 * Wordpress activation callback function
 * @return null
 */
function activate() {
	SygPlugin::activation();
}

/**
 * Wordpress deactivation callback function
 * @return null
 */
function deactivate() {
	SygPlugin::deactivation();
}

/**
 * Wordpress uninstall callback function
 * @return null
 */
function uninstall() {
	SygPlugin::uninstall();
}
?>
