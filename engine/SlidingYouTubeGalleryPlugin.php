<?php

include_once 'Zend/Loader.php';
if (!class_exists('SanityPluginFramework')) require_once($plugin_path.'Sanity/sanity.php');

class SlidingYouTubeGalleryPlugin extends SanityPluginFramework {

	private static $instance = null;
	
	/* Return current instance of the plugin
	 * @param null
	 * @return null
	 */
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
	
	/* Construct an instance of the plugin
	 * @param null
	 * @return null
	 */
	public function __construct() {
		
		$me =  ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SlidingYouTubeGalleryPlugin.php';
		
		parent::__construct(dirname($me));
		
		// set environment
		$this->setEnvironment();
		
		// attach the admin menu to the hook
		add_action('admin_menu', array($this, 'SlidingYoutubeGalleryAdmin'));
		
		// register activation hook
		register_activation_hook(__FILE__, array($this, 'activation'));

		// front end code block
		if(!is_admin()) {
			// set front end option
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
			// add shortcodes
			add_shortcode('syg_gallery', array($this, 'getGallery'));
			add_shortcode('syg_page', array($this, 'getVideoPage'));
		}
	}
	
	/* Set the plugin environment
	 * @param null
	 * @return null
	 */
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

	/* Activation function of the plugin
	 * @param null
	 * @return null
	 */
	private function activation() {
		global $wpdb;
		global $syg_db_version;
	
		// set db version
		$syg_db_version = "1.0";
	
		// get the current db version
		$installed_ver = get_option( "syg_db_version" );
	
		if( $installed_ver != $syg_db_version ) {
			// set the table name
			$table_name = $wpdb->prefix . "syg";
				
			// must create table if not exists
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`syg_youtube_username` varchar(255) NOT NULL,
			`syg_youtube_videoformat` varchar(255) NOT NULL,
			`syg_youtube_maxvideocount` int(11) NOT NULL,
			`syg_thumbnail_height` int(11) NOT NULL,
			`syg_thumbnail_width` int(11) NOT NULL,
			`syg_thumbnail_bordersize` int(11) NOT NULL,
			`syg_thumbnail_bordercolor` varchar(255) NOT NULL,
			`syg_thumbnail_borderradius` int(11) NOT NULL,
			`syg_thumbnail_distance` int(11) NOT NULL,
			`syg_thumbnail_overlaysize` int(11) NOT NULL,
			`syg_thumbnail_image` varchar(255) NOT NULL,
			`syg_thumbnail_buttonopacity` float NOT NULL,
			`syg_description_width` int(11) NOT NULL,
			`syg_description_fontsize` int(11) NOT NULL,
			`syg_description_fontcolor` varchar(255) NOT NULL,
			`syg_description_show` tinyint(1) NOT NULL,
			`syg_description_showduration` tinyint(1) NOT NULL,
			`syg_description_showtags` tinyint(1) NOT NULL,
			`syg_description_showratings` tinyint(1) NOT NULL,
			`syg_description_showcategories` tinyint(1) NOT NULL,
			`syg_box_width` int(11) NOT NULL,
			`syg_box_background` varchar(255) NOT NULL,
			`syg_box_radius` int(11) NOT NULL,
			`syg_box_padding` int(11) NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
				
			// run the dbDelta function
			dbDelta($sql);
				
			// add or update db version option
			(!get_option("syg_db_version")) ? add_option("syg_db_version", $syg_db_version) : update_option("syg_db_version", $syg_db_version);
		}
	}
	
	/* GETTERS AND SETTERS */
	
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
		return $this->homeRoot.$this->jsRoot;
	}
	
	/**
	 * @return the $cssRoot
	 */
	public function getCssRoot() {
		return $this->homeRoot.$this->cssRoot;
	}
	
	/**
	 * @return the $imgRoot
	 */
	public function getImgRoot() {
		return $this->homeRoot.$this->imgRoot;
	}

	// sliding youtube gallery
	function getGallery($attributes) {
		extract(shortcode_atts(array('id' => null), $attributes));
		if (!empty($id)) {
			try {
				// get the gallery
				$dao = new SygDao();
				$gallery = $dao->getSygById($id);
				$gallery->setUserProfile ($this->sygYouTube->getUserProfile($gallery->getYtUsername()));

				// get video feed from youtube 
				$videoFeed = $this->sygYouTube->getuserUploads($gallery->getYtUsername());
				
				// truncate video feed
				// create new feed
				$counter = 1;
				$feed = new Zend_Gdata_YouTube_VideoFeed();
				foreach ($videoFeed as $videoEntry) {
					$feed->addEntry($videoEntry);
					$i++;
					if ($i > $gallery->getYtMaxVideoCount()) break;
				}
				
				// put the feed in the view
				$this->data['feed'] = $feed;
				
				// put the gallery settings in the view
				$this->data['gallery'] = $gallery;
				
				// render gallery snippet code
				$this->render('gallery');		
			} catch (Exception $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				$this->render('exception');
			}	
		}

		return $html;
	}

	// sliding video page
	function getVideoPage($attributes) {
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
		add_options_page('SlidingYoutubeGallery Options', 'YouTube Gallery', 'manage_options', 'syg-administration-panel', array($this, 'sygAdminHome'));
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
	 * @param null
	 * @return Simple action controller
	 */
	function sygAdminHome() {
		// updated flag
		$updated = false;
	
		// check if user has permission to manage options
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}

		// determine wich action to call
		switch ($_GET['action']) {
			case 'edit':
				$this->forwardToEdit();
				break;
			case 'add':				
				$this->forwardToAdd();
				break;
			case 'delete':
				$this->forwardToDelete();
				break;
			case 'settings':
				$this->forwardToSettings();
				break;
			case null:
				$this->forwardToHome();
				break;
			default:
				break;
		}
	}
	
	/*
	 * @param null
	 * @return Inject css, js and img path with other information used by view
	 */
	private function prepareHeader(&$view, $context) {
		switch ($context) {
			case SygConstant::SYG_CTX_BE:
				// define resources path
				$view['cssPath'] = $this->getCssRoot();
				$view['imgPath'] = $this->getImgRoot();
				$view['jsPath'] = $this->getJsRoot();
				
				// css to include
				$view['cssAdminUrl'] = $view['cssPath'] . 'admin.css';
				$view['cssColorPicker'] = $view['cssPath'] . 'colorpicker.css';
				
				// js to include
				$view['jsAdminUrl'] = $view['jsPath'] . 'admin.js';
				$view['jsColorPickerUrl'] = $view['jsPath'] . 'colorpicker.js';
				
				break;
			case SygConstant::SYG_CTX_FE:
				// define resources path
				$view['cssPath'] = $this->getCssRoot();
				$view['imgPath'] = $this->getImgRoot();
				$view['jsPath'] = $this->getJsRoot();
				$view['pluginPath'] = $this->getPluginRoot();
				
				// define plugin resources url in the view
				$view['sygCssUrl'] = $view['cssPath'] . 'SlidingYoutubeGallery.css.php';
				$view['sygJsUrl'] = $view['jsPath'] . 'SlidingYoutubeGallery.js.php';
				
				// define presentation plugin resources
				$view['fancybox_js_url'] = $view['jsPath'] . '/fancybox/jquery.fancybox-1.3.4.pack.js';
				$view['easing_js_url'] = $view['jsPath'] . '/fancybox/jquery.easing-1.3.pack.js';
				$view['mousewheel_js_url'] = $view['jsPath'] . '/fancybox/jquery.mousewheel-3.0.4.pack.js';
				$view['fancybox_css_url'] = $view['cssPath'] . '/fancybox/jquery.fancybox-1.3.4.css';
				
				// css injection
				wp_register_style('sliding-youtube-gallery', $view['sygCssUrl'], array(), SygConstant::SYG_VERSION, 'screen');
				wp_enqueue_style('sliding-youtube-gallery');
				wp_register_style('fancybox', $view['fancybox_css_url'], array(), SygConstant::SYG_VERSION, 'screen');
				wp_enqueue_style('fancybox');
				
				// javascript injection
				// dependencies
				wp_enqueue_script('jquery');
				// scripts
				wp_register_script('sliding-youtube-gallery', $view['sygJsUrl'], array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('sliding-youtube-gallery');
				wp_register_script('fancybox', $view['fancybox_js_url'], array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('fancybox');
				wp_register_script('easing', $view['easing_js_url'], array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('easing');
				wp_register_script('mousewheel', $view['mousewheel_js_url'], array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('mousewheel');
				break;
			case SygConstant::SYG_CTX_WS:
				break;
			default:
				break;
		}  
	}
	
	/*
	 * @param null
	 * @return Return a redirect to plugin admin homepage
	 */
	private function forwardToSettings() {
		// prepare header 
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
		
		// render generalSettings view
		$this->render('generalSettings');
	}
	
	/*
	 * @param null
	 * @return Return a redirect to gallery adding section
	 */
	private function forwardToAdd() {
		
		$updated = false;
		
		if( isset($_POST['syg_submit_hidden']) && $_POST['syg_submit_hidden'] == 'Y' ) {
			// database add procedure
			// get posted values
			$data = serialize($_POST);
			
			// create a new gallery
			$syg = new SygGallery($data);
			
			// update db
			$this->sygDao->addSyg($syg);
		
			// updated flag
			$updated = true;
			
			// updated flag
			$this->data['updated'] = $updated;
			
			// render adminGallery view
			$this->forwardToHome();
		}else{
			// gallery administration form section
			// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
			
			// put an empty gallery in the view
			$this->data['gallery'] = new SygGallery();
			
			// render adminGallery view
			$this->render('adminGallery');
		}
	}
	
	/*
	 * @param null
	 * @return Return a redirect to gallery editing section
	 */
	private function forwardToEdit() {
		if( isset($_POST['syg_submit_hidden']) && $_POST['syg_submit_hidden'] == 'Y' ) {
			// database update procedure
			// get posted values
			$data = serialize($_POST);
				
			// create a new gallery
			$syg = new SygGallery($data);
			
			// update db
			$this->sygDao->updateSyg($syg);
			
			// updated flag
			$updated = true;
				
			// updated flag
			$this->data['updated'] = $updated;
				
			// render adminGallery view
			$this->forwardToHome();
		} else {
			// get the gallery id
			$id = (int) $_GET['id'];
			
			// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
			
			// put gallery in the view
			$this->data['gallery'] = $this->sygDao->getSygById($id);
			
			// render adminGallery view
			$this->render('adminGallery');
		}
	}
	
	/*
	 * @param null
	 * @return Return a redirect to plugin admin homepage
	 */
	private function forwardToHome() {
		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
		
		// put galleries in the view
		$galleries = $this->sygDao->getAllSyg();
		
		// add additional information to galleries
		foreach ($galleries as $key => $value) {
			$galleries[$key]->setUserProfile ($this->sygYouTube->getUserProfile($value->getYtUsername()));
		}
		
		// put galleries in the view
		$this->data['galleries'] = $galleries;
		
		// render adminHome view
		$this->render('adminHome');
	}
}
?>