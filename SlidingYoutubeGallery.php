<?php

/**
 * Plugin name: Sliding Youtube Gallery
 * Plugin URI: http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/
 * Author: webeng
 * Author URI: http://blog.webeng.it/
 * Version: 1.0.1
 * Description: Sliding YouTube Gallery is a WordPress plugin, that gives you a fast way for adding video from a youtube user’s channel. User can choose to display the videos in a fully customizable sliding gallery or in a video page.
 */

/*
@todo renderlo in qualche modo indipendente dalla piattaforma
@todo memorizzare le combinazioni e richiamarle con un id
@todo widget wordpress
@todo down scrolling
@todo background image
@todo filter by tags
*/

$lib_path = ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/lib';
set_include_path (get_include_path() . PATH_SEPARATOR . $lib_path);

// include required wordpress object
require_once (ABSPATH . 'wp-admin/includes/plugin.php');
require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

// include engine
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SlidingYouTubeGalleryPlugin.php');
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygConstant.php');
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygDao.php');
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygGallery.php');
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygUtil.php');
require_once (ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygYouTube.php');

// run the plugin
$syg = SlidingYouTubeGalleryPlugin::getInstance();
?>
