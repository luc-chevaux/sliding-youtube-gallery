<?php

/**
 * Plugin name: Sliding Youtube Gallery
 * Plugin URI: http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/
 * Author: webeng
 * Author URI: http://blog.webeng.it/
 * Version: 1.2.0
 * Description: Sliding YouTube Gallery is a WordPress plugin, that gives you a fast way for adding video from a youtube user’s channel. User can choose to display the videos in a fully customizable sliding gallery or in a video page.
 */

$lib_path = ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/lib';
set_include_path (get_include_path() . PATH_SEPARATOR . $lib_path);

// include required wordpress object
require_once (ABSPATH . 'wp-admin/includes/plugin.php');
require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

// include engine
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygPlugin.php');
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygConstant.php');
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygDao.php');
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygGallery.php');
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygUtil.php');
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygYouTube.php');

function activate() {SygPlugin::activation();}
function deactivate() {SygPlugin::deactivation();}
function uninstall() {SygPlugin::uninstall();}

register_activation_hook(ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/SlidingYoutubeGallery.php', 'activate');
register_deactivation_hook(ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/SlidingYoutubeGallery.php', 'deactivate');
register_uninstall_hook(ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/SlidingYoutubeGallery.php', 'uninstall');

// run the plugin
$syg = SygPlugin::getInstance();
?>
