<?php

include_once 'Zend/Loader.php';
if (!class_exists('SanityPluginFramework')) require_once($plugin_path.'Sanity/sanity.php');

class SlidingYouTubeGalleryPlugin extends SanityPluginFramework {

	private static $instance = null;
	
	public static function getInstance() {
		if(self::$instance == null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	private $homeRoot;
	private $pluginRoot;
	private $jsRoot;
	private $cssRoot;
	private $imgRoot;
	
	private $syg = array();
	
	private $sygYouTube;
	private $sygDao;
	
	public function __construct() {
		
		$me =  ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SlidingYouTubeGalleryPlugin.php';
		
		parent::__construct(dirname($me));
		
		// set environment
		$this->setEnvironment();
		
		// attach the admin menu to the hook
		add_action('admin_menu', array($this, 'SlidingYoutubeGalleryAdmin'));
		
		// check for zend gdata interface on init
		add_action('init', array($this, 'checkZendGData'));
		
		// register activation hook
		register_activation_hook(__FILE__, array($this, 'activation'));

		// front end code block
		if(!is_admin()) {
			// set front end option
			$this->setFrontEndOption();

			// add shortcodes
			add_shortcode('syg_gallery', array($this, 'getGallery'));
			add_shortcode('syg_page', array($this, 'getVideoPage'));
		}
	}
	
	// getters and setters
	
	private function setEnvironment() {
		// set home root
		$this->homeRoot = home_url();
		
		// set the plugin path
		$this->setPluginRoot(SygConstant::WP_PLUGIN_PATH);
		
		// set the css path
		$this->setCssRoot(SygConstant::WP_CSS_PATH);
		
		// set the js path
		$this->setJsRoot(SygConstant::WP_JS_PATH);
		
		// set the img path
		$this->setImgRoot(SygConstant::WP_IMG_PATH);
		
		// set local object
		$this->sygYouTube = new SygYouTube();
		$this->sygDao = new SygDao();
	}
	
	public function getOption() {
		/* YouTube default values */
		$option = array();
		// default video format
		$option['syg_youtube_videoformat'] = get_option('syg_youtube_videoformat') != '' ? get_option('syg_youtube_videoformat') : "480n";
		// default max video count
		$option['syg_youtube_maxvideocount'] = get_option('syg_youtube_maxvideocount') != '' ? get_option('syg_youtube_maxvideocount') : "15";
		
		/* box default values*/
		// default main box width
		$option['syg_box_width'] = get_option('syg_box_width') != '' ? get_option('syg_box_width') : "550";
		// default main box background color
		$option['syg_box_background'] = get_option('syg_box_background') != '' ? get_option('syg_box_background') : "#efefef";
		// default box radius pixel
		$option['syg_box_radius'] = get_option('syg_box_radius') != '' ? get_option('syg_box_radius') : "10";
		// default box padding pixel
		$option['syg_box_padding'] = get_option('syg_box_padding') != '' ? get_option('syg_box_padding') : "10";
		
		/* thumbnail default values*/
		// default thumbnail height
		$option['syg_thumbnail_height'] = get_option('syg_thumbnail_height') != '' ? get_option('syg_thumbnail_height') : "100";
		// default thumbnail width
		$option['syg_thumbnail_width'] = get_option('syg_thumbnail_width') != '' ? get_option('syg_thumbnail_width') : "133";
		// default thumbnail border size
		$option['syg_thumbnail_bordersize'] = get_option('syg_thumbnail_bordersize') != '' ? get_option('syg_thumbnail_bordersize') : "3";
		// default thumbnail border color
		$option['syg_thumbnail_bordercolor'] = get_option('syg_thumbnail_bordercolor') != '' ? get_option('syg_thumbnail_bordercolor') : "#333333";
		// default thumbnail border radius
		$option['syg_thumbnail_borderradius'] = get_option('syg_thumbnail_borderradius') != '' ? get_option('syg_thumbnail_borderradius') : "10";
		// default thumbnail overlay size
		$option['syg_thumbnail_overlaysize'] = get_option('syg_thumbnail_overlaysize') != '' ? get_option('syg_thumbnail_overlaysize') : "32";
		// default overlay button
		$option['syg_thumbnail_image'] = get_option('syg_thumbnail_image') != '' ? get_option('syg_thumbnail_image') : "1";
		// default thumbnail border size
		$option['syg_thumbnail_bordersize'] = get_option('syg_thumbnail_bordersize') != '' ? get_option('syg_thumbnail_bordersize') : "3";
		// default thumbnail distance
		$option['syg_thumbnail_distance'] = get_option('syg_thumbnail_distance') != '' ? get_option('syg_thumbnail_distance') : "10";
		// default thumbnail button opacity
		$option['syg_thumbnail_buttonopacity'] = get_option('syg_thumbnail_buttonopacity') != '' ? get_option('syg_thumbnail_buttonopacity') : "0.50";
		// update calculated option
		$option['perc_occ_w'] = $option['syg_thumbnail_overlaysize'] / ($option['syg_thumbnail_width'] + ($option['syg_thumbnail_bordersize']*2));
		$option['default_left'] = 50 - ($perc_occ_w / 2 * 100);
		$option['perc_occ_h'] = $option['syg_thumbnail_overlaysize'] / ($option['syg_thumbnail_height'] + ($option['syg_thumbnail_bordersize']*2));
		$option['default_top'] = 50 - ($perc_occ_h / 2 * 100);
		// default thumbnail top position
		$option['syg_thumbnail_top'] = get_option('syg_thumbnail_top') != '' ? get_option('syg_thumbnail_top') : $option['default_top'];
		// default thumbnail left position
		$option['syg_thumbnail_left'] = get_option('syg_thumbnail_left') != '' ? get_option('syg_thumbnail_left') : $option['default_left'];
		
		/* thumbnail description */
		// default description width
		$option['syg_description_width'] = get_option('syg_description_width') != '' ? get_option('syg_description_width') : $option['syg_thumbnail_width'];
		// default description font size
		$option['syg_description_fontsize'] = get_option('syg_description_fontsize') != '' ? get_option('syg_description_fontsize') : "12";
		// default description font color
		$option['syg_description_fontcolor'] = get_option('syg_description_fontcolor') != '' ? get_option('syg_description_fontcolor') : "#333333";
		// default show video description
		$option['syg_description_show'] = get_option('syg_description_show') != '' ? get_option('syg_description_show') : "false";
		// default show video duration
		$option['syg_description_showduration'] = get_option('syg_description_showduration') != '' ? get_option('syg_description_showduration') : "false";
		// default show video tags
		$option['syg_description_showtags'] = get_option('syg_description_showtags') != '' ? get_option('syg_description_showtags') : "false";
		// default show video ratings
		$option['syg_description_showratings'] = get_option('syg_description_showratings') != '' ? get_option('syg_description_showratings') : "false";
		// default show video categories
		$option['syg_description_showcategories'] = get_option('syg_description_showcategories') != '' ? get_option('syg_description_showcategories') : "false";
		
		return $option;
	}
	/**
	 * @param field_type $homeRoot
	 */
	private function setHomeRoot($homeRoot) {
		$this->homeRoot = $homeRoot;
	}

	/**
	 * @param field_type $pluginRoot
	 */
	private function setPluginRoot($pluginRoot) {
		$this->pluginRoot = $pluginRoot;
	}

	/**
	 * @param string $jsRoot
	 */
	private function setJsRoot($jsRoot) {
		$this->jsRoot = $jsRoot;
	}
	
	/**
	 * @param string $cssRoot
	 */
	private function setCssRoot($cssRoot) {
		$this->cssRoot = $cssRoot;
	}
	
	/**
	 * @param string $imgRoot
	 */
	private function setImgRoot($imgRoot) {
		$this->imgRoot = $imgRoot;
	}
	
	/**
	 * @return the $homeRoot
	 */
	public function getHomeRoot() {
		return $this->homeRoot;
	}
	
	/**
	 * @return the $pluginRoot
	 */
	public function getPluginRoot() {
		return $this->pluginRoot;
	}
	/**
	 * @return the $jsRoot
	 */
	public function getJsRoot() {
		return $this->jsRoot;
	}
	
	/**
	 * @return the $cssRoot
	 */
	public function getCssRoot() {
		return $this->cssRoot;
	}
	
	/**
	 * @return the $imgRoot
	 */
	public function getImgRoot() {
		return $this->imgRoot;
	}

	// activation function
	private function activation() {
		global $wpdb;

		// must create table if not exists
	}

	private function setFrontEndOption() {
		
		// get the resources url
		$sygCssUrl = $this->cssRoot . 'SlidingYoutubeGallery.css.php';
		$sygJsUrl =  $this->jsRoot . 'SlidingYoutubeGallery.js.php';

		// external
		$fancybox_js_url = $this->jsRoot . '/fancybox/jquery.fancybox-1.3.4.pack.js';
		$easing_js_url = $this->jsRoot . '/fancybox/jquery.easing-1.3.pack.js';
		$mousewheel_js_url = $this->jsRoot . '/fancybox/jquery.mousewheel-3.0.4.pack.js';
		$fancybox_css_url = $this->jsRoot. '/fancybox/jquery.fancybox-1.3.4.css';

		// register styles
		wp_register_style('sliding-youtube-gallery', $sygCssUrl, array(), SygConstant::SYG_VERSION, 'screen');
		wp_enqueue_style('sliding-youtube-gallery');
		wp_register_style('fancybox', $fancybox_css_url, array(), SygConstant::SYG_VERSION, 'screen');
		wp_enqueue_style('fancybox');

		// load the local copy of jQuery in the footer
		wp_enqueue_script('jquery');

		// load our own scripts
		wp_register_script('sliding-youtube-gallery', $sygJsUrl, array(), SygConstant::SYG_VERSION, true);
		wp_enqueue_script('sliding-youtube-gallery');
		wp_register_script('fancybox', $fancybox_js_url, array(), SygConstant::SYG_VERSION, true);
		wp_enqueue_script('fancybox');
		wp_register_script('easing', $easing_js_url, array(), SygConstant::SYG_VERSION, true);
		wp_enqueue_script('easing');
		wp_register_script('mousewheel', $mousewheel_js_url, array(), SygConstant::SYG_VERSION, true);
		wp_enqueue_script('mousewheel');

	}
	
	/*
	 * check for zend gdata interface
	*/
	public function checkZendGData () {
		if (defined('WP_ZEND_GDATA_INTERFACES') && constant('WP_ZEND_GDATA_INTERFACES')) {
			$paths = explode(PATH_SEPARATOR, get_include_path());
			foreach ($paths as $path) {
				if (file_exists("$path/Zend/Loader.php")) {
					define('WP_ZEND_GDATA_INTERFACES', true);
					return true;
				}else{
					return false;
				}
			}
		}else{
			define('WP_ZEND_GDATA_INTERFACES', false);
			add_action( 'admin_notices', array($this, 'zendGDataNotFound'));
		}
	}
	
	private function zendGDataNotFound() {
		echo "<div id=\"message\" class=\"error\">Error: You must install and activate Zend GData Interfaces before running Sliding YouTube Gallery.</div>";
	}

	// sliding youtube gallery
	function getGallery() {
		try {
			$username = get_option ( 'syg_youtube_username' );
			$videoFeed = $this->sygYouTube->getuserUploads ( $username );
			$html = '<div id="syg_video_gallery"><div class="sc_menu">';
			$html .= '<ul class="sc_menu">';
			$html .= $this->sygYouTube->getEntireFeed ( $videoFeed, 1, SygConstant::SYG_METHOD_GALLERY );
			$html .= '</ul>';
			$html .= '</div></div>';
		} catch (Exception $ex) {
			$html = '<strong>SlidingYoutubeGallery Exception:</strong><br/>'.$ex->getMessage();
		}

		return $html;
	}

	// sliding video page
	function getVideoPage() {
		try {
			// variables for the field and option names
			$username = get_option('syg_youtube_username');
			$videoFeed =  $this->sygYouTube->getuserUploads($username);
			$html  = '<div id="syg_video_page">';
			$html .= $this->sygYouTube->getEntireFeed ( $videoFeed, 1, SygConstant::SYG_METHOD_PAGE );
			$html .= '</div>';
		} catch (Exception $ex) {
			$html = '<strong>SlidingYoutubeGallery Exception:</strong><br/>'.$ex->getMessage();
		}

		return $html;
	}

	// video page short code
	function syg_display_page() {
		$html = $this->getVideoPage();
		echo $html;
	}

	// video gallery short code
	function syg_display_gallery() {
		$html = $this->getGallery();
		echo $html;
	}
	
	/*
	 * admin hook to wp
	*/
	function SlidingYoutubeGalleryAdmin() {
		add_options_page('SlidingYoutubeGallery Options', 'SlidingYoutubeGallery', 'manage_options', 'syg-administration-panel', array($this, 'sygAdminHome'));
	}
	
	/*
	 * do the option inventory
	*/
	private function optionInventory() {
		
		$this->syg['yt_user']['opt'] = 'syg_youtube_username';
		$this->syg['yt_videoformat']['opt'] = 'syg_youtube_videoformat';
		$this->syg['yt_maxvideocount']['opt'] = 'syg_youtube_maxvideocount';
		$this->syg['th_height']['opt'] = 'syg_thumbnail_height';
		$this->syg['th_width']['opt'] = 'syg_thumbnail_width';
		$this->syg['th_bordersize']['opt'] = 'syg_thumbnail_bordersize';
		$this->syg['th_bordercolor']['opt'] = 'syg_thumbnail_bordercolor';
		$this->syg['th_borderradius']['opt'] = 'syg_thumbnail_borderradius';
		$this->syg['th_distance']['opt'] = 'syg_thumbnail_distance';
		$this->syg['th_overlaysize']['opt'] = 'syg_thumbnail_overlaysize';
		$this->syg['th_image']['opt'] = 'syg_thumbnail_image';
		$this->syg['th_top']['opt'] = 'syg_thumbnail_top';
		$this->syg['th_left']['opt'] = 'syg_thumbnail_left';
		$this->syg['th_buttonopacity']['opt'] = 'syg_thumbnail_buttonopacity';
		$this->syg['box_width']['opt'] = 'syg_box_width';
		$this->syg['box_background']['opt'] = 'syg_box_background';
		$this->syg['box_radius']['opt'] = 'syg_box_radius';
		$this->syg['box_padding']['opt'] = 'syg_box_padding';
		$this->syg['desc_width']['opt'] = 'syg_description_width';
		$this->syg['desc_fontcolor']['opt'] = 'syg_description_fontcolor';
		$this->syg['desc_fontsize']['opt'] = 'syg_description_fontsize';
		$this->syg['desc_showdescription']['opt'] = 'syg_description_show';
		$this->syg['desc_showduration']['opt'] = 'syg_description_showduration';
		$this->syg['desc_showtags']['opt'] = 'syg_description_showtags';
		$this->syg['desc_showratings']['opt'] = 'syg_description_showratings';
		$this->syg['desc_showcat']['opt'] = 'syg_description_showcategories';
	
		$this->syg['hiddenfield']['opt'] = 'syg_submit_hidden';
	}
	
	/*
	 * function used to get option value
	*/
	private function getOptionValues($syg) {
		foreach ($this->syg as $key => $value) {
			$this->syg[$key]['val'] = get_option($value['opt']);
		}
	}
	
	/*
	 * function used to get posted value
	*/
	private function getPostedValues($syg) {
		foreach ($this->syg as $key => $value) {
			$this->syg[$key]['val'] = $_POST[$value['opt']];
		}
		return $syg;
	}
	
	/*
	 * function used to update option
	*/
	function updateOptions($syg) {
		// update generic option
		foreach ($syg as $key => $value) {
			update_option($value['opt'], $value['val']);
		}
	
		
	
		update_option($syg['th_top']['opt'], $syg['th_top']['val']);
		update_option($syg['th_left']['opt'], $syg['th_left']['val']);
	
		return $syg;
	}
	
	/*
	 * main function for admin interface
	*/
	function sygAdminHome() {
		// updated flag
		$updated = false;
	
		// check if user has permission to manage options
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
				
		// option inventory
		$syg = $this->optionInventory();
	
		if( isset($_POST[$syg['hiddenfield']['opt']]) && $_POST[$syg['hiddenfield']['opt']] == 'Y' ) {
			// get posted values
			$syg = getPostedValues($syg);
			 
			// update options
			$syg = updateOptions($syg);
	
			// updated flag
			$updated = true;
		}else{
			// get option values
			$syg = $this->getOptionValues($syg);
		}
	
		$this->data['updated'] = $updated;
		
		// define css to include
		$cssPath = $this->homeRoot . '/wp-content/plugins/sliding-youtube-gallery/css/';
		$jsPath = $this->homeRoot . '/wp-content/plugins/sliding-youtube-gallery/js/';
		
		$this->data['cssAdminUrl'] = $cssPath . 'admin.css';
		$this->data['cssColorPicker'] = $cssPath . 'colorpicker.css';
		
		// put galleries in the view
		$galleries = $this->sygDao->getAllSyg(); 
		
		// add additional information to galleries
		foreach ($galleries as $key => $value) {
				$galleries[$key]->setUserProfile ($this->sygYouTube->getUserProfile($value->getYtUsername()));
		}
		
		$this->data['galleries'] = $galleries;
				
		$this->render('adminHome');
	}
}

/*echo '<form name="form1" method="post" action="">';
 echo '<input type="hidden" name="'.$syg['hiddenfield']['opt'].'" value="Y">';

// youtube settings
echo '<fieldset>';
echo '<legend><strong>YouTube settings</strong></legend>';
echo '<label for="'.$syg['yt_user']['opt'].'">YouTube User: </label>';
echo '<input type="text" id="'.$syg['yt_user']['opt'].'" name="'.$syg['yt_user']['opt'].'" value="'.$syg['yt_user']['val'].'" size="30">';
echo '<label for="'.$syg['desc_showduration']['opt'].'">Duration </label>';
$chk_duration = ($syg['desc_showduration']['val'] == "1") ? '<input type="checkbox" name="'.$syg['desc_showduration']['opt'].'" id="'.$syg['desc_showduration']['opt'].'" value="1" checked="checked">' : '<input type="checkbox" name="'.$syg['desc_showduration']['opt'].'" id="'.$syg['desc_showduration']['opt'].'" value="1">';
echo $chk_duration;
echo '<label for="'.$syg['desc_showdescription']['opt'].'">Description </label>';
$chk_desc = ($syg['desc_showdescription']['val'] == "1") ? '<input type="checkbox" name="'.$syg['desc_showdescription']['opt'].'" id="'.$syg['desc_showdescription']['opt'].'" value="1" checked="checked">' : '<input type="checkbox" name="'.$syg['desc_showdescription']['opt'].'" id="'.$syg['desc_showdescription']['opt'].'" value="1">';
echo $chk_desc;
echo '<label for="'.$syg['desc_showtags']['opt'].'">Tags </label>';
$chk_tags = ($syg['desc_showtags']['val'] == "1") ? '<input type="checkbox" name="'.$syg['desc_showtags']['opt'].'" id="'.$syg['desc_showtags']['opt'].'" value="1" checked="checked">' : '<input type="checkbox" name="'.$syg['desc_showtags']['opt'].'" id="'.$syg['desc_showtags']['opt'].'" value="1">';
echo $chk_tags;
echo '<label for="'.$syg['desc_showratings']['opt'].'">Ratings </label>';
$chk_showratings = ($syg['desc_showratings']['val'] == "1") ? '<input type="checkbox" name="'.$syg['desc_showratings']['opt'].'" id="'.$syg['desc_showratings']['opt'].'" value="1" checked="checked">' : '<input type="checkbox" name="'.$syg['desc_showratings']['opt'].'" id="'.$syg['desc_showratings']['opt'].'" value="1">';
echo $chk_showratings;
echo '<label for="'.$syg['desc_showcat']['opt'].'">Categories </label>';
$chk_showcat = ($syg['desc_showcat']['val'] == "1") ? '<input type="checkbox" name="'.$syg['desc_showcat']['opt'].'" id="'.$syg['desc_showcat']['opt'].'" value="1" checked="checked">' : '<input type="checkbox" name="'.$syg['desc_showcat']['opt'].'" id="'.$syg['desc_showcat']['opt'].'" value="1">';
echo $chk_showcat;
echo "<br/><br/>";
echo '<label for="'.$syg['yt_videoformat']['opt'].'">Video Format: </label>';
($syg['yt_videoformat']['val'] == "420n") ? $syg_vf_opt_1 = '<option value="420n" selected="selected">420 X 315 (normal)</option>' : $syg_vf_opt_1 = '<option value="420n">420 X 315 (normal)</option>';
($syg['yt_videoformat']['val'] == "480n") ? $syg_vf_opt_2 = '<option value="480n" selected="selected">480 X 360 (normal)</option>' : $syg_vf_opt_2 = '<option value="480n">480 X 360 (normal)</option>';
($syg['yt_videoformat']['val'] == "640n") ? $syg_vf_opt_3 = '<option value="640n" selected="selected">640 X 480 (normal)</option>' : $syg_vf_opt_3 = '<option value="640n">640 X 480 (normal)</option>';
($syg['yt_videoformat']['val'] == "960n") ? $syg_vf_opt_4 = '<option value="960n" selected="selected">960 X 720 (normal)</option>' : $syg_vf_opt_4 = '<option value="960n">960 X 720 (normal)</option>';
($syg['yt_videoformat']['val'] == "560w") ? $syg_vf_opt_5 = '<option value="560w" selected="selected">560 X 315 (wide)</option>' : $syg_vf_opt_5 = '<option value="560w">560 X 315 (wide)</option>';
($syg['yt_videoformat']['val'] == "640w") ? $syg_vf_opt_6 = '<option value="640w" selected="selected">640 X 360 (wide)</option>' : $syg_vf_opt_6 = '<option value="640w">640 X 360 (wide)</option>';
($syg['yt_videoformat']['val'] == "853w") ? $syg_vf_opt_7 = '<option value="853w" selected="selected">853 X 480 (wide)</option>' : $syg_vf_opt_7 = '<option value="853w">853 X 480 (wide)</option>';
($syg['yt_videoformat']['val'] == "1280w") ? $syg_vf_opt_8 = '<option value="1280w" selected="selected">1280 X 720 (wide)</option>' : $syg_vf_opt_8 = '<option value="1280w">1280 X 720 (wide)</option>';
echo '<select id="'.$syg['yt_videoformat']['opt'].'" name="'.$syg['yt_videoformat']['opt'].'">';
echo $syg_vf_opt_1;
echo $syg_vf_opt_2;
echo $syg_vf_opt_3;
echo $syg_vf_opt_4;
echo $syg_vf_opt_5;
echo $syg_vf_opt_6;
echo $syg_vf_opt_7;
echo $syg_vf_opt_8;
echo '</select>';
echo '<label for="'.$syg['yt_maxvideocount']['opt'].'">Maximum Video Count: </label>';
echo '<input type="text" id="'.$syg['yt_maxvideocount']['opt'].'" name="'.$syg['yt_maxvideocount']['opt'].'" value="'.$syg['yt_maxvideocount']['val'].'" size="10">';
echo '</fieldset>';

// thumbnail appereance
echo '<fieldset>';
echo '<legend><strong>Thumbnail appereance</strong></legend>';
echo '<label for="'.$syg['th_height']['opt'].'">Height: </label>';
echo '<input onchange="calculateNewWidth();" type="text" id="'.$syg['th_height']['opt'].'" name="'.$syg['th_height']['opt'].'" value="'.$syg['th_height']['val'].'" size="10">';
echo '<label for="'.$syg['th_width']['opt'].'">Width: </label>';
echo '<input onchange="calculateNewHeight();" type="text" id="'.$syg['th_width']['opt'].'" name="'.$syg['th_width']['opt'].'" value="'.$syg['th_width']['val'].'" size="10">';
echo '<label for="'.$syg['th_bordersize']['opt'].'">Border Size: </label>';
echo '<input type="text" id="'.$syg['th_bordersize']['opt'].'" name="'.$syg['th_bordersize']['opt'].'" value="'.$syg['th_bordersize']['val'].'" size="10">';
echo '<br/><br/>';
echo '<label for="'.$syg['th_borderradius']['opt'].'">Border Radius: </label>';
echo '<input type="text" id="'.$syg['th_borderradius']['opt'].'" name="'.$syg['th_borderradius']['opt'].'" value="'.$syg['th_borderradius']['val'].'" size="10">';
echo '<label for="'.$syg['th_distance']['opt'].'">Distance: </label>';
echo '<input type="text" id="'.$syg['th_distance']['opt'].'" name="'.$syg['th_distance']['opt'].'" value="'.$syg['th_distance']['val'].'" size="10">';
echo '<label for="'.$syg['th_bordercolor']['opt'].'">Border Color: </label>';
echo '<input onchange="updateColorPicker(\'thumb_bordercolor_selector\',this)" type="text" id="'.$syg['th_bordercolor']['opt'].'" name="'.$syg['th_bordercolor']['opt'].'" value="'.$syg['th_bordercolor']['val'].'" size="10">';
echo '<div id="thumb_bordercolor_selector">';
echo '<div style="background-color: #333333;"></div>';
echo '</div>';
echo '<br/><br/>';
echo '<label for="'.$syg['th_overlaysize']['opt'].'">Button size: </label>';
($syg['th_overlaysize']['val'] == "16") ? $syg_to_opt_1 = '<option value="16" selected="selected">16</option>' : $syg_to_opt_1 = '<option value="16">16</option>';
($syg['th_overlaysize']['val'] == "32") ? $syg_to_opt_2 = '<option value="32" selected="selected">32</option>' : $syg_to_opt_2 = '<option value="32">32</option>';
($syg['th_overlaysize']['val'] == "64") ? $syg_to_opt_3 = '<option value="64" selected="selected">64</option>' : $syg_to_opt_3 = '<option value="64">64</option>';
($syg['th_overlaysize']['val'] == "128") ? $syg_to_opt_4 = '<option value="128" selected="selected">128</option>' : $syg_to_opt_4 = '<option value="128">128</option>';
echo '<select id="'.$syg['th_overlaysize']['opt'].'" name="'.$syg['th_overlaysize']['opt'].'">';
echo $syg_to_opt_1;
echo $syg_to_opt_2;
echo $syg_to_opt_3;
echo $syg_to_opt_4;
echo '</select>';
echo '<label for="'.$syg['th_image']['opt'].'">Image: </label>';
($syg['th_image']['val'] == 1) ? $syg_ty_opt_1 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="1" checked="checked">' : $syg_ty_opt_1 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="1">';
($syg['th_image']['val'] == 2) ? $syg_ty_opt_2 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="2" checked="checked">' : $syg_ty_opt_2 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="2">';
($syg['th_image']['val'] == 3) ? $syg_ty_opt_3 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="3" checked="checked">' : $syg_ty_opt_3 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="3">';
echo $syg_ty_opt_1;
echo '<img width="32" src="'. $imgPath . '/button/play-the-video_1.png'.'"/>';
echo $syg_ty_opt_2;
echo '<img width="32" src="'. $imgPath . '/button/play-the-video_2.png'.'"/>';
echo $syg_ty_opt_3;
echo '<img width="32" src="'. $imgPath . '/button/play-the-video_3.png'.'"/>';
echo '<label for="'.$syg['th_buttonopacity']['opt'].'">Button opacity: </label>';
echo '<input type="text" id="'.$syg['th_buttonopacity']['opt'].'" name="'.$syg['th_buttonopacity']['opt'].'" value="'.$syg['th_buttonopacity']['val'].'" size="10">';
echo '</fieldset>';

// javascript inclusion
$js_url = $jsPath . '/admin.js';
$js_color_picker = $jsPath . '/colorpicker.js';
echo '<script type="text/javascript" src="'.$js_url.'"></script>';
echo '<script type="text/javascript" src="'.$js_color_picker.'"></script>';

// box and description appereance
echo '<fieldset>';
echo '<legend><strong>Box and description appereance</strong></legend>';
echo '<label for="'.$syg['box_width']['opt'].'">Box width: </label>';
echo '<input type="text" id="'.$syg['box_width']['opt'].'" name="'.$syg['box_width']['opt'].'" value="'.$syg['box_width']['val'].'" size="10">';
echo '<label for="'.$syg['box_radius']['opt'].'">Box Radius: </label>';
echo '<input type="text" id="'.$syg['box_radius']['opt'].'" name="'.$syg['box_radius']['opt'].'" value="'.$syg['box_radius']['val'].'" size="10">';
echo '<label for="'.$syg['box_padding']['opt'].'">Box Padding: </label>';
echo '<input type="text" id="'.$syg['box_padding']['opt'].'" name="'.$syg['box_padding']['opt'].'" value="'.$syg['box_padding']['val'].'" size="10">';
echo '<label for="'.$syg['box_background']['opt'].'">Background color: </label>';
echo '<input onchange="updateColorPicker(\'box_backgroundcolor_selector\',this)" type="text" id="'.$syg['box_background']['opt'].'" name="'.$syg['box_background']['opt'].'" value="'.$syg['box_background']['val'].'" size="10">';
echo '<div id="box_backgroundcolor_selector">';
echo '<div style="background-color: #efefef;"></div>';
echo '</div>';
echo '<br/><br/>';
echo '<label for="'.$syg['desc_fontsize']['opt'].'">Font size: </label>';
echo '<input type="text" id="'.$syg['desc_fontsize']['opt'].'" name="'.$syg['desc_fontsize']['opt'].'" value="'.$syg['desc_fontsize']['val'].'" size="10">';
echo '<label for="'.$syg['desc_fontcolor']['opt'].'">Font color: </label>';
echo '<input onchange="updateColorPicker(\'desc_fontcolor_selector\',this)" type="text" id="'.$syg['desc_fontcolor']['opt'].'" name="'.$syg['desc_fontcolor']['opt'].'" value="'.$syg['desc_fontcolor']['val'].'" size="10">';
echo '<div id="desc_fontcolor_selector">';
echo '<div style="background-color: #333333;"></div>';
echo '</div>';
echo '</fieldset>';

echo '<hr/>';
echo '<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>';
echo '</form>';*/

?>