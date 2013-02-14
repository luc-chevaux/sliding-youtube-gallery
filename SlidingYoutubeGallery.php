<?php

/**
 * Plugin name: Sliding Youtube Gallery
 * Plugin URI: http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/
 * Author: webeng
 * Author URI: http://blog.webeng.it/
 * Version: 1.4.1
 * Description: Sliding YouTube Gallery is a WordPress plugin, that gives you a fast way for adding video from a youtube user’s channel. User can choose to display the videos in a fully customizable sliding gallery or in a video page.
 */

// include required wordpress object
require_once(ABSPATH . 'wp-admin/includes/plugin.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

define('SYG_PATH', plugin_dir_path(__FILE__));

// library path
$lib_path = SYG_PATH . 'engine/lib';

// set include path
set_include_path(get_include_path() . PATH_SEPARATOR . $lib_path);

// include engine
require_once(SYG_PATH . 'engine/SygPlugin.php');
require_once(SYG_PATH . 'engine/SygConstant.php');
require_once(SYG_PATH . 'engine/SygDao.php');
require_once(SYG_PATH . 'engine/SygGallery.php');
require_once(SYG_PATH . 'engine/SygUtil.php');
require_once(SYG_PATH . 'engine/SygYouTube.php');
require_once(SYG_PATH . 'engine/SygStyle.php');
require_once(SYG_PATH . 'engine/SygValidate.php');

define('SYG_URL', WP_PLUGIN_URL . SygConstant::WP_PLUGIN_PATH);

// register activation hook
register_activation_hook(SYG_PATH . '/SlidingYoutubeGallery.php', 'activate');
		
// register deactivation hook
register_deactivation_hook(SYG_PATH . '/SlidingYoutubeGallery.php',	'deactivate');
		
// register uninstall hook
register_uninstall_hook(SYG_PATH . 'SlidingYoutubeGallery.php', 'uninstall');

// backend and frontend code
if (!is_admin()) {
	// front end code block
	// add shortcodes
	add_shortcode('syg_gallery', 'getGallery');
	add_shortcode('syg_page', 'getVideoPage');
	add_shortcode('syg_carousel', 'getVideoCarousel');
} else {
	// add cookie
	add_action('init', 'checkRole');
	
	// plugin update function callback
	add_action('admin_init', 'sygCheckUpdateProcess');
	
	// back end code block
	// attach the admin menu to the hook
	add_action('admin_menu', 'SlidingYoutubeGalleryAdmin');
	
	// add admin notices
	add_action('admin_notices', 'sygNotice');
}

add_action('wp_print_scripts','getPluginOptions');
add_action('syg_rebuild_cache','rebuildCache');

/* FRONT END METHODS */

/**
 * Get a js option file
 * @return js
 */
function getPluginOptions() {
	$syg = SygPlugin::getInstance();
	echo $syg->getJsOptions();
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

/**
 * Get a video carousel
 * @param unknown_type $atts
 */
function getVideoCarousel($atts) {
	$syg = SygPlugin::getInstance();
	return $syg->getVideoCarousel($atts);
}

/* BACK END METHODS */

function sygNotice () {
	$syg = SygPlugin::getInstance();
	$syg->sygNotice();
	return true;
}

function sygCheckUpdateProcess() {
	SygPlugin::checkUpdateProcess();
}

// Sliding youtube gallery options page
function SlidingYoutubeGalleryAdmin() {
	global $wp_version;

	$syg = SygPlugin::getInstance();

	// Add first level menu page
	add_menu_page('Sliding YouTube Gallery', 'SYG gallery', 'edit_posts', 'syg-administration-panel', '', SYG_URL . 'img/ui/webeng.png');
						
	// Add second level menu page
	add_submenu_page('syg-administration-panel', SygConstant::BE_MENU_MANAGE_GALLERIES,
			SygConstant::BE_MENU_MANAGE_GALLERIES, 'edit_posts', SygConstant::BE_ACTION_MANAGE_GALLERIES,
			'manageGalleries');
	add_submenu_page('syg-administration-panel', SygConstant::BE_MENU_MANAGE_STYLES,
			SygConstant::BE_MENU_MANAGE_STYLES, 'edit_pages', SygConstant::BE_ACTION_MANAGE_STYLES,
			'manageStyles');
	add_submenu_page('syg-administration-panel', SygConstant::BE_MENU_MANAGE_SETTINGS,
			SygConstant::BE_MENU_MANAGE_SETTINGS, 'manage_options', SygConstant::BE_ACTION_MANAGE_SETTINGS,
			'manageSettings');
	add_submenu_page('syg-administration-panel', SygConstant::BE_MENU_CONTACTS_AND_SUPPORT,
			SygConstant::BE_MENU_CONTACTS_AND_SUPPORT, 'edit_posts', SygConstant::BE_ACTION_CONTACTS,
			'getSupport');

	// remove menu duplicated by wordpress
	if (version_compare($wp_version, '3.1', '<')) {
		unset($GLOBALS['submenu']['syg-administration-panel'][0]);
	} else {
		remove_submenu_page('syg-administration-panel',	'syg-administration-panel');
	}
}

/**
 * Plugin gallery administration
 * @return null
 */
function manageGalleries() {
	$syg = SygPlugin::getInstance();
	
	if (isset($_GET['action']) && $_GET['action'] == 'cache_rebuild') {
		wp_schedule_single_event(time() + 5, 'syg_rebuild_cache');
	}
	
	echo $syg->forwardToGalleries();
}

/**
 * Plugin styles administration
 * @return null
 */
function manageStyles() {
	$syg = SygPlugin::getInstance();
	echo $syg->forwardToStyles();
}

/**
 * Plugin settings administration
 * @return null
 */
function manageSettings() {
	$syg = SygPlugin::getInstance();
	echo $syg->forwardToSettings();
}

/**
 * Plugin get support
 * @return null
 */
function getSupport() {
	$syg = SygPlugin::getInstance();
	echo $syg->forwardToSupport();
}

/**
 * Plugin rebuild cache
 * @return null
 */
function rebuildCache() {
	$syg = SygPlugin::getInstance();
	$syg->rebuildCache();
}

function checkRole () {
	// set status cookie
	if ($_COOKIE['syg-role'] != SygPlugin::getCurrentUserRole()) {
		setcookie('syg-role', SygPlugin::getCurrentUserRole(), time() + 86400, get_admin_url().'admin.php');
	}
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
