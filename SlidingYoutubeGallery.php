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

define ('SYG_METHOD_GALLERY','gallery');
define ('SYG_METHOD_PAGE','page');
 
require_once 'SlidingYoutubeGalleryFunction.php';
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygConstant.php');
require_once( ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygGallery.php');

// define activation hook
register_activation_hook(__FILE__, 'slidingYoutubeGalleryActivation' );

// activation function
function slidingYoutubeGalleryActivation() {
	global $wpdb;
	include 'DefaultValues.php';
	add_option('syg_youtube_username', '');
	add_option('syg_youtube_videoformat', $syg_youtube_videoformat);
	add_option('syg_youtube_maxvideocount', $syg_youtube_videoformat);
	add_option('syg_thumbnail_height', $syg_thumbnail_height);
	add_option('syg_thumbnail_width', $syg_thumbnail_width);
	add_option('syg_thumbnail_bordersize', $syg_thumbnail_bordersize);
	add_option('syg_thumbnail_bordercolor', $syg_thumbnail_bordercolor);
	add_option('syg_thumbnail_borderradius', $syg_thumbnail_borderradius);
	add_option('syg_thumbnail_top', $syg_thumbnail_top);
	add_option('syg_thumbnail_left', $syg_thumbnail_left);
	add_option('syg_thumbnail_bordersize', $syg_thumbnail_bordersize);
	add_option('syg_thumbnail_distance', $syg_thumbnail_distance);
	add_option('syg_thumbnail_overlaysize', $syg_thumbnail_overlaysize);
	add_option('syg_thumbnail_image', $syg_thumbnail_image);
	add_option('syg_thumbnail_buttonopacity', $syg_thumbnail_buttonopacity);
	add_option('syg_description_width', $syg_description_width);
	add_option('syg_description_fontsize', $syg_description_fontsize);
	add_option('syg_description_fontcolor', $syg_description_fontcolor);
	add_option('syg_description_show', $syg_description_show);
	add_option('syg_description_showduration', $syg_description_showduration);
	add_option('syg_description_showtags', $syg_description_showtags);
	add_option('syg_description_showratings', $syg_description_showratings);
	add_option('syg_description_showcategories', $syg_description_showcategories);
	add_option('syg_box_width', $syg_box_width);
	add_option('syg_box_background', $syg_box_background);
	add_option('syg_box_radius', $syg_box_radius);
	add_option('syg_box_padding', $syg_box_padding);
	add_option('syg_submit_hidden', 'N');
}

function setSygFrontEndOption() {
	define('SYG_VERSION', '1.2.0');
	
	// define some dir alias
	$homeRoot = home_url();
	$cssPath = $homeRoot . '/wp-content/plugins/sliding-youtube-gallery/css/';
	$imgPath = $homeRoot . '/wp-content/plugins/sliding-youtube-gallery/images/';
	$jsPath = $homeRoot . '/wp-content/plugins/sliding-youtube-gallery/js/';
	
	// get the resources url
	$css_url = $cssPath . 'SlidingYoutubeGallery.css.php';
	$js_url =  $jsPath . 'SlidingYoutubeGallery.js.php';
	
	$fancybox_js_url = $jsPath. '/fancybox/jquery.fancybox-1.3.4.pack.js';
	$easing_js_url = $jsPath . '/fancybox/jquery.easing-1.3.pack.js';
	$mousewheel_js_url = $jsPath . '/fancybox/jquery.mousewheel-3.0.4.pack.js';
	$fancybox_css_url = $jsPath . '/fancybox/jquery.fancybox-1.3.4.css';
	
	// register styles
	wp_register_style('sliding-youtube-gallery', $css_url, array(), SYG_VERSION, 'screen');
	wp_enqueue_style('sliding-youtube-gallery');
	wp_register_style('fancybox', $fancybox_css_url, array(), SYG_VERSION, 'screen');
	wp_enqueue_style('fancybox');
	
	// load the local copy of jQuery in the footer
	wp_enqueue_script('jquery');
	
	// load our own scripts
	wp_register_script('sliding-youtube-gallery', $js_url, array(), SYG_VERSION, true);
	wp_enqueue_script('sliding-youtube-gallery');
	wp_register_script('fancybox', $fancybox_js_url, array(), SYG_VERSION, true);
	wp_enqueue_script('fancybox');
	wp_register_script('easing', $easing_js_url, array(), SYG_VERSION, true);
	wp_enqueue_script('easing');
	wp_register_script('mousewheel', $mousewheel_js_url, array(), SYG_VERSION, true);
	wp_enqueue_script('mousewheel');
	
}

// sliding youtube gallery
function syg_getSlidingYoutubeGallery() {
	require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
	try {
		Zend_Loader::loadClass('Zend_Gdata_YouTube');
		$yt = new Zend_Gdata_YouTube();
		$html = getSygVideoGallery();
	} catch (Exception $ex) {
		$html = '<strong>SlidingYoutubeGallery Exception:</strong><br/>'.$ex->getMessage();
	}

	return $html;
}

// sliding video page
function syg_getVideoPage() {
	require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
	try {
		Zend_Loader::loadClass('Zend_Gdata_YouTube');
		$yt = new Zend_Gdata_YouTube();
		$html = getSygVideoPage();
	} catch (Exception $ex) {
		$html = '<strong>SlidingYoutubeGallery Exception:</strong><br/>'.$ex->getMessage();
	}

	return $html;
}

// video page short code
function syg_display_page() {
	$html = syg_getVideoPage();
	echo $html;
}

// video gallery short code
function syg_display_gallery() {
	$html = syg_getSlidingYoutubeGallery();
	echo $html;
}

// front end code block
if(!is_admin()) {
	// set front end option
	setSygFrontEndOption();
	
	// add shortcode
	add_shortcode('syg_gallery', 'syg_getSlidingYoutubeGallery');
	add_shortcode('syg_page', 'syg_getVideoPage');
}
?>
