<?php

/**
 * Sliding Youtube Gallery Plugin Controller
 * 
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.5
 * 
 * @todo Creare la pagina support con facebook + twitter + mail (milestone v1.3.0)
 * @todo Background image (milesone v1.3.0)
 * @todo Paginazione gallerie pagina (milestone v1.3.0)
 * @todo Creare la pagina contact con invio mail (milestone v1.3.0)
 * @todo Creare il servizio di validazione dei form (milestone v1.3.0)
 * @todo Aggiungere opzione disabilita video correlati (milestone v1.3.0)
 * @todo Creare il codice di aggiornamento del database (milestone v1.3.0)
 * @todo Superare piano di test back-end (milestone v1.3.0)
 * @todo Superare piano di test front end (milestone v1.3.0)
 * 
 * @todo widget wordpress + Implementare scroll verticale (milestone v1.4)
 */

include_once 'Zend/Loader.php';

if (!class_exists('SanityPluginFramework'))
	require_once(WP_PLUGIN_DIR
			. '/sliding-youtube-gallery/engine/lib/Sanity/sanity.php');

class SygPlugin extends SanityPluginFramework {

	private static $instance = null;

	/**
	 * @name getInstance
	 * @category pattern
	 * @since 1.2.5
	 * @return $instance
	 */
	public static function getInstance() {
		if (self::$instance == null) {
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

	/**
	 * @name __construct
	 * @category construct SygPlugin object
	 * @since 1.0.1
	 */
	public function __construct() {
		$me = ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SlidingYouTubeGalleryPlugin.php';

		parent::__construct(dirname($me));

		// set environment
		$this->setEnvironment();

		// front end code block
		if (!is_admin()) {
			// add shortcodes
			add_shortcode('syg_gallery', array($this, 'getGallery'));
			add_shortcode('syg_page', array($this, 'getVideoPage'));
		}
	}

	/**
	 * @name setEnvironment
	 * @category configuration
	 * @since 1.0.1
	 */
	private function setEnvironment() {
		// set home root
		$this->homeRoot = site_url();

		// set the plugin path
		$this->setPluginRoot(SygConstant::WP_PLUGIN_PATH);

		// set the css path
		$this->setCssRoot(WP_PLUGIN_URL . SygConstant::WP_CSS_PATH);

		// set the js path
		$this->setJsRoot(WP_PLUGIN_URL . SygConstant::WP_JS_PATH);

		// set the img path
		$this->setImgRoot(WP_PLUGIN_URL . SygConstant::WP_IMG_PATH);

		// set local object
		$this->sygYouTube = new SygYouTube();
		$this->sygDao = new SygDao();
	}

	/**
	 * @name removeOldOption
	 * @category configuration
	 * @since 1.2.5
	 */
	private static function removeOldOption() {
		global $wpdb;

		// get the table name
		$syg_table_name = $wpdb->prefix . "syg";

		$syg_youtube_username = get_option('syg_youtube_username');
		$syg_youtube_videoformat = get_option('syg_youtube_videoformat');
		$syg_youtube_maxvideocount = get_option('syg_youtube_maxvideocount');
		$syg_thumbnail_height = get_option('syg_thumbnail_height');
		$syg_thumbnail_width = get_option('syg_thumbnail_width');
		$syg_thumbnail_bordersize = get_option('syg_thumbnail_bordersize');
		$syg_thumbnail_bordercolor = get_option('syg_thumbnail_bordercolor');
		$syg_thumbnail_borderradius = get_option('syg_thumbnail_borderradius');
		$syg_thumbnail_distance = get_option('syg_thumbnail_distance');
		$syg_thumbnail_overlaysize = get_option('syg_thumbnail_overlaysize');
		$syg_thumbnail_image = get_option('syg_thumbnail_image');
		$syg_thumbnail_buttonopacity = get_option('syg_thumbnail_buttonopacity');
		$syg_description_width = get_option('syg_description_width');
		$syg_description_fontsize = get_option('syg_description_fontsize');
		$syg_description_fontcolor = get_option('syg_description_fontcolor');
		$syg_description_show = get_option('syg_description_show');
		$syg_description_showduration = get_option('syg_description_showduration');
		$syg_description_showtags = get_option('syg_description_showtags');
		$syg_description_showratings = get_option('syg_description_showratings');
		$syg_description_showcategories = get_option('syg_description_showcategories');
		$syg_box_width = get_option('syg_box_width');
		$syg_box_background = get_option('syg_box_background');
		$syg_box_radius = get_option('syg_box_radius');
		$syg_box_padding = get_option('syg_box_padding');

		$wpdb->insert($syg_table_name,
			array('syg_box_background' => $syg_box_background,
				'syg_box_padding' => $syg_box_padding,
				'syg_box_radius' => $syg_box_radius,
				'syg_box_width' => $syg_box_width,
				'syg_description_fontcolor' => $syg_description_fontcolor,
				'syg_description_fontsize' => $syg_description_fontsize,
				'syg_description_show' => $syg_description_show,
				'syg_description_showcategories' => $syg_description_showcategories,
				'syg_description_showduration' => $syg_description_showduration,
				'syg_description_showratings' => $syg_description_showratings,
				'syg_description_showtags' => $syg_description_showtags,
				'syg_description_width' => $syg_description_width,
				'syg_thumbnail_bordercolor' => $syg_thumbnail_bordercolor,
				'syg_thumbnail_borderradius' => $syg_thumbnail_borderradius,
				'syg_thumbnail_bordersize' => $syg_thumbnail_bordersize,
				'syg_thumbnail_buttonopacity' => $syg_thumbnail_buttonopacity,
				'syg_thumbnail_distance' => $syg_thumbnail_distance,
				'syg_thumbnail_height' => $syg_thumbnail_height,
				'syg_thumbnail_image' => $syg_thumbnail_image,
				'syg_thumbnail_width' => $syg_thumbnail_width,
				'syg_thumbnail_overlaysize' => $syg_thumbnail_overlaysize,
				'syg_youtube_maxvideocount' => $syg_youtube_maxvideocount,
				'syg_youtube_videoformat' => $syg_youtube_videoformat,
				'syg_youtube_username' => $syg_youtube_username),
				SygGallery::getRsType());

		if ($wpdb->insert_id) {
			delete_option('syg_youtube_username');
			delete_option('syg_youtube_videoformat');
			delete_option('syg_youtube_maxvideocount');
			delete_option('syg_thumbnail_height');
			delete_option('syg_thumbnail_width');
			delete_option('syg_thumbnail_bordersize');
			delete_option('syg_thumbnail_bordercolor');
			delete_option('syg_thumbnail_borderradius');
			delete_option('syg_thumbnail_top');
			delete_option('syg_thumbnail_left');
			delete_option('syg_thumbnail_distance');
			delete_option('syg_thumbnail_overlaysize');
			delete_option('syg_thumbnail_image');
			delete_option('syg_thumbnail_buttonopacity');
			delete_option('syg_description_width');
			delete_option('syg_description_fontsize');
			delete_option('syg_description_fontcolor');
			delete_option('syg_description_show');
			delete_option('syg_description_showduration');
			delete_option('syg_description_showtags');
			delete_option('syg_description_showratings');
			delete_option('syg_description_showcategories');
			delete_option('syg_box_width');
			delete_option('syg_box_background');
			delete_option('syg_box_radius');
			delete_option('syg_box_padding');
			delete_option('syg_submit_hidden');
		}
	}

	/**
	 * @name notify
	 * @category send statistics and data to plugin developer 
	 * @since 1.2.5
	 * @param $action
	 */
	private static function notify($action = null) {
		$domain_name = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];

		if (SygUtil::isCurlInstalled()) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,
					'http://www.webeng.it/stats.php?module_name=syg&action='
							. $action . '&domain=' . $domain_name);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec();
			curl_close($ch);
		} else {
			wp_mail(SygConstant::BE_EMAIL_NOTIFIED,
					$domain_name . " has just " . $action,
					$domain_name . " has just " . $action);
		}
	}

	/**
	 * @name uninstall
	 * @category uninstall plugin hook
	 * @since 1.0.1
	 */
	public static function uninstall() {
		global $wpdb;

		// remove table
		$syg_table_name = $wpdb->prefix . "syg";

		// must create table if not exists
		$sql = "DROP TABLE IF EXISTS " . $syg_table_name . "";

		// execute clean 
		$wpdb->query($sql);

		// remove options
		delete_option("syg_db_version");

		// send stat
		self::notify(SygConstant::BE_ACTION_UNINSTALL);
	}

	/**
	 * @name deactivation
	 * @category deactivation plugin hook
	 * @since 1.0.1
	 */
	public static function deactivation() {
		// send stat
		self::notify(SygConstant::BE_ACTION_DEACTIVATION);
	}

	/**
	 * @name activation
	 * @category deactivation plugin hook
	 * @since 1.0.1
	 */
	public static function activation() {
		global $wpdb;
		global $syg_db_version;

		// set db version
		$syg_db_version = SygConstant::SYG_VERSION;

		// get the current db version
		$installed_ver = get_option("syg_db_version");

		if ($installed_ver != $syg_db_version) {
			// set the table name
			$syg_table_name = $wpdb->prefix . "syg";

			//$this->sygDao->createTable12x();

			// transitory method
			if (get_option('syg_youtube_username'))
				self::removeOldOption();

			// add or update db version option
			(!get_option("syg_db_version")) ? add_option("syg_db_version",
							$syg_db_version)
					: update_option("syg_db_version", $syg_db_version);

			// send stat
			self::notify(SygConstant::BE_ACTION_ACTIVATION);
		}
	}

	/* GETTERS AND SETTERS */

	/**
	 * @name setHomeRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $homeRoot
	 */
	private function setHomeRoot($homeRoot) {
		$this->homeRoot = $homeRoot;
	}

	/**
	 * @name setPluginRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $pluginRoot
	 */
	private function setPluginRoot($pluginRoot) {
		$this->pluginRoot = $pluginRoot;
	}

	/**
	 * @name setJsRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $jsRoot
	 */
	private function setJsRoot($jsRoot) {
		$this->jsRoot = $jsRoot;
	}

	/**
	 * @name setCssRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $cssRoot
	 */
	private function setCssRoot($cssRoot) {
		$this->cssRoot = $cssRoot;
	}

	/**
	 * @name setImgRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $imgRoot
	 */
	private function setImgRoot($imgRoot) {
		$this->imgRoot = $imgRoot;
	}

	/**
	 * @name getHomeRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $homeRoot
	 */
	public function getHomeRoot() {
		return $this->homeRoot;
	}

	/**
	 * @name getPluginRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $homeRoot
	 */
	public function getPluginRoot() {
		return $this->pluginRoot;
	}
	
	/**
	 * @name getJsRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $jsRoot
	 */
	public function getJsRoot() {
		return $this->jsRoot;
	}

	/**
	 * @name getCssRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $cssRoot
	 */
	public function getCssRoot() {
		return $this->cssRoot;
	}

	/**
	 * @name getImgRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $imgRoot
	 */
	public function getImgRoot() {
		return $this->imgRoot;
	}

	/* END GETTERS AND SETTER */

	/**
	 * Get gallery settings returning its DTO
	 * @param $id 
	 * @return array
	 */
	public function getGallerySettings($id = null) {
		// cast id to an int
		$id = (int) $id;

		// get the gallery
		$dao = new SygDao();
		$gallery = $dao->getSygGalleryById($id);

		// set youtube profile object in the gallery
		// $gallery->setUserProfile ($this->sygYouTube->getUserProfile($gallery->getYtUsername()));

		// return gallery in dto format
		return $gallery->toDto(true);
	}

	/**
	 * @name getGallery
	 * @category get a sliding youtube gallery
	 * @since 1.0.1
	 * @param $attributes
	 * @return $output
	 */
	function getGallery($attributes) {
		foreach ($attributes as $key => $var) {
			$attributes[$key] = (int) $var;
		}

		extract(shortcode_atts(array('id' => null), $attributes));

		if (!empty($id)) {
			try {
				// get the gallery
				$dao = new SygDao();
				$gallery = $dao->getSygGalleryById($id);

				
				if ($gallery->getGalleryType() == 'feed') {
					// get video feed from youtube 
					$videoFeed = $this->sygYouTube
							->getuserUploads($gallery->getYtSrc());
	
					// truncate video feed
					// create new feed
					$counter = 1;
					$feed = new Zend_Gdata_YouTube_VideoFeed();
					foreach ($videoFeed as $videoEntry) {
						$feed->addEntry($videoEntry);
						$i++;
						if ($i == $gallery->getYtMaxVideoCount())
							break;
					}
				} else if ($gallery->getGalleryType() == 'list') {
					$list_of_videos = preg_split( '/\r\n|\r|\n/', $gallery->getYtSrc());
					
					$feed = new Zend_Gdata_YouTube_VideoFeed();
					foreach ($list_of_videos as $key => $value) {
						$list_of_videos[$key] = str_replace ('v=', '', parse_url($value, PHP_URL_QUERY));
						$videoEntry = $this->sygYouTube->getVideoEntry($list_of_videos[$key]);
						$feed->addEntry($videoEntry);
					}
				} else if ($gallery->getGalleryType() == 'playlist') {
					$playlist_id = str_replace ('list=PL', '', parse_url($gallery->getYtSrc(), PHP_URL_QUERY));
					$content = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/playlists/'.$playlist_id.'/?v=2&alt=json&feature=plcp'));
					$feed_to_object = $content->feed->entry;
					
					if(count($feed_to_object)) {
						
						$feed = new Zend_Gdata_YouTube_VideoFeed();
						foreach($feed_to_object as $item) { 
							//var_dump($item);
							$videoId = $item->{'media$group'}->{'yt$videoid'}->{'$t'};
							$videoEntry = $this->sygYouTube->getVideoEntry($videoId);
							$feed->addEntry($videoEntry);
						} 
					}
				}


				// put the feed in the view
				$this->data['feed'] = $feed;

				// put the gallery settings in the view
				$this->data['gallery'] = $gallery;

				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);

				// render gallery snippet code
				return $this->render('gallery');
			} catch (Exception $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				return $this->render('exception');
			}
		}
	}

	/**
	 * @name getVideoPage
	 * @category get a video page
	 * @since 1.0.1
	 * @param $attributes
	 * @return $output
	 */
	function getVideoPage($attributes) {
		foreach ($attributes as $key => $var) {
			$attributes[$key] = (int) $var;
		}

		extract(shortcode_atts(array('id' => null), $attributes));

		if (!empty($id)) {
			try {
				// get the gallery
				$dao = new SygDao();
				$gallery = $dao->getSygGalleryById($id);

				// get video feed from youtube 
				$videoFeed = $this->sygYouTube
						->getuserUploads($gallery->getYtSrc());

				// truncate video feed
				// create new feed
				$counter = 1;
				$feed = new Zend_Gdata_YouTube_VideoFeed();
				foreach ($videoFeed as $videoEntry) {
					$feed->addEntry($videoEntry);
					$i++;
					if ($i == $gallery->getYtMaxVideoCount())
						break;
				}

				// put the feed in the view
				$this->data['feed'] = $feed;

				// put the gallery settings in the view
				$this->data['gallery'] = $gallery;

				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);

				// render gallery snippet code
				return $this->render('page');
			} catch (Exception $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				return $this->render('exception');
			}
		}
	}

	/**
	 * @name getVideoPage
	 * @category prepare header with the right js and css inclusion
	 * @since 1.0.1
	 * @param &$view, $context
	 */
	private function prepareHeader(&$view, $context = SygConstant::SYG_CTX_FE) {
		// define resources path
		$view['cssPath'] = $this->getCssRoot();
		$view['imgPath'] = $this->getImgRoot();
		$view['jsPath'] = $this->getJsRoot();
		// define plugin url
		$view['pluginUrl'] = $this->homeRoot . $this->getPluginRoot();

		switch ($context) {
		case SygConstant::SYG_CTX_BE:
		// css to include
			$view['cssAdminUrl'] = $view['cssPath'] . 'admin.css';
			$view['cssColorPicker'] = $view['cssPath'] . 'colorpicker.css';

			// define presentation plugin resources
			$view['fancybox_js_url'] = $view['jsPath']
					. '/fancybox/jquery.fancybox-1.3.4.pack.js';
			$view['easing_js_url'] = $view['jsPath']
					. '/fancybox/jquery.easing-1.3.pack.js';
			$view['mousewheel_js_url'] = $view['jsPath']
					. '/fancybox/jquery.mousewheel-3.0.4.pack.js';
			$view['fancybox_css_url'] = $view['jsPath']
					. '/fancybox/jquery.fancybox-1.3.4.css';

			wp_register_style('fancybox', $view['fancybox_css_url'], array(),
					SygConstant::SYG_VERSION, 'screen');
			wp_enqueue_style('fancybox');

			// javascript dependencies injection
			wp_enqueue_script('jquery');

			// js to include
			wp_register_script('sliding-youtube-gallery-admin',
					$view['jsPath'] . 'admin.js', array(),
					SygConstant::SYG_VERSION, true);
			wp_enqueue_script('sliding-youtube-gallery-admin');
			
			wp_register_script('sliding-youtube-gallery-colorpicker',
					$view['jsPath'] . 'colorpicker.js', array(),
					SygConstant::SYG_VERSION, true);
			wp_enqueue_script('sliding-youtube-gallery-colorpicker');

			wp_register_script('fancybox', $view['fancybox_js_url'], array(),
					SygConstant::SYG_VERSION, true);
			wp_enqueue_script('fancybox');
			wp_register_script('easing', $view['easing_js_url'], array(),
					SygConstant::SYG_VERSION, true);
			wp_enqueue_script('easing');
			wp_register_script('mousewheel', $view['mousewheel_js_url'],
					array(), SygConstant::SYG_VERSION, true);
			wp_enqueue_script('mousewheel');
			break;
		case SygConstant::SYG_CTX_FE:
		// define plugin resources url in the view
			$gallery = $view['gallery'];
			$view['sygCssUrl_' . $gallery->getId()] = $view['cssPath']
					. 'SlidingYoutubeGallery.css.php?id=' . $gallery->getId();
			$view['sygJsUrl_' . $gallery->getId()] = $view['jsPath']
					. 'SlidingYoutubeGallery.js.php?id=' . $gallery->getId();

			// define presentation plugin resources
			$view['fancybox_js_url'] = $view['jsPath']
					. '/fancybox/jquery.fancybox-1.3.4.pack.js';
			$view['easing_js_url'] = $view['jsPath']
					. '/fancybox/jquery.easing-1.3.pack.js';
			$view['mousewheel_js_url'] = $view['jsPath']
					. '/fancybox/jquery.mousewheel-3.0.4.pack.js';
			$view['fancybox_css_url'] = $view['jsPath']
					. '/fancybox/jquery.fancybox-1.3.4.css';

			// css injection
			wp_register_style('sliding-youtube-gallery-' . $gallery->getId(),
					$view['sygCssUrl_' . $gallery->getId()], array(),
					SygConstant::SYG_VERSION, 'screen');
			wp_enqueue_style('sliding-youtube-gallery-' . $gallery->getId());
			wp_register_style('fancybox', $view['fancybox_css_url'], array(),
					SygConstant::SYG_VERSION, 'screen');
			wp_enqueue_style('fancybox');

			// javascript dependencies injection
			wp_enqueue_script('jquery');

			// js to include
			wp_register_script('sliding-youtube-gallery-' . $gallery->getId(),
					$view['sygJsUrl_' . $gallery->getId()], array(),
					SygConstant::SYG_VERSION, true);
			wp_enqueue_script('sliding-youtube-gallery-' . $gallery->getId());
			wp_register_script('fancybox', $view['fancybox_js_url'], array(),
					SygConstant::SYG_VERSION, true);
			wp_enqueue_script('fancybox');
			wp_register_script('easing', $view['easing_js_url'], array(),
					SygConstant::SYG_VERSION, true);
			wp_enqueue_script('easing');
			wp_register_script('mousewheel', $view['mousewheel_js_url'],
					array(), SygConstant::SYG_VERSION, true);
			wp_enqueue_script('mousewheel');
			break;
		case SygConstant::SYG_CTX_WS:
			break;
		default:
			break;
		}
	}

	/**
	 * @name forwardToGalleries
	 * @category admin forward
	 * @since 1.0.1
	 * @param $updated
	 * @return $output
	 */
	public function forwardToGalleries($updated = false) {
		$output = '';
		
		// if we've updated a record set action to null
		$action = ($updated == true) ? 'redirect' : $_GET['action'];
		
		// determine wich action to call
		switch ($action) {
			case 'add':
				return $this->forwardToAddGallery();
			case 'edit':
				return $this->forwardToEditGallery();
			case 'delete':
				return $this->forwardToDeleteGallery();
			case 'redirect':
				$this->data['redirect_url'] = '?page='.SygConstant::BE_ACTION_MANAGE_GALLERIES;
				return $this->render('redirect');
			default:
				// prepare header
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
				
				// put galleries in the view
				$galleries = $this->sygDao->getAllSygGalleries();

				// put galleries in the view
				$this->data['galleries'] = $galleries;
		
				// number of pages
				$this->data['pages'] = ceil(
						$this->sygDao->getGalleriesCount()
						/ SygConstant::SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED);
		
				// generate token
				$_SESSION['request_token'] = $this->getAuthToken();
		
				// render adminStyles view
				return $this->render('adminGalleries');
		}
	}

	/**
	 * @name forwardToStyles
	 * @category admin forward
	 * @since 1.0.1
	 * @param $updated
	 * @return $output
	 */
	public function forwardToStyles($updated = false) {
		$output = '';
		
		// if we've updated a record set action to null
		$action = ($updated == true) ? 'redirect' : $_GET['action'];
		
		// determine wich action to call
		switch ($action) {
			case 'add':
				return $this->forwardToAddStyle();
			case 'edit':
				return $this->forwardToEditStyle();
			case 'delete':
				return $this->forwardToDeleteStyle(); 
			case 'redirect':
				$this->data['redirect_url'] = '?page='.SygConstant::BE_ACTION_MANAGE_STYLES;
				return $this->render('redirect');
			default:
				// prepare header
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
				
				// put galleries in the view
				$styles = $this->sygDao->getAllSygStyles();
				
				// put galleries in the view
				$this->data['styles'] = $styles;
				
				// number of pages
				$this->data['pages'] = ceil(
						$this->sygDao->getStylesCount()
						/ SygConstant::SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED);
				
				// generate token
				$_SESSION['request_token'] = $this->getAuthToken();
				
				// render adminStyles view
				return $this->render('adminStyles');
		}
	}

	/**
	 * @name forwardToSettings
	 * @category admin forward
	 * @since 1.0.1
	 * @param $updated
	 * @return $output
	 */
	public function forwardToSettings($updated = false) {
		$output = '';
		
		if (isset($_POST['syg_submit_hidden'])	&& $_POST['syg_submit_hidden'] == 'Y') {
			
			(!get_option('syg_option_apikey')) ? add_option ('syg_option_apikey', $_POST['syg_option_apikey']) : update_option ('syg_option_apikey', $_POST['syg_option_apikey']);
			(!get_option('syg_option_numrec')) ? add_option ('syg_option_numrec', $_POST['syg_option_numrec']) : update_option ('syg_option_numrec', $_POST['syg_option_numrec']);
			
			$this->data['redirect_url'] = '?page='.SygConstant::BE_ACTION_MANAGE_SETTINGS;

			// render adminStyles view
			return $this->render('redirect');
		} else {
			// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
			
			// get settings
			$options = $this->getOptions();
			
			// put settings in the view
			$this->data['options'] = $options;
			
			// render adminSettings view
			return $this->render('adminSettings');
		}
	}

	/**
	 * @name forwardToAddGallery
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToAddGallery() {
		
			$updated = false;
			
			if (isset($_POST['syg_submit_hidden'])
					&& $_POST['syg_submit_hidden'] == 'Y') {
				// database add style procedure
				// get posted values
				$data = serialize($_POST);
			
				try {
					// validate data
					//SygValidate::getInstance().validateGallery($data);
					//// check youtube user
					//$valid = $this->sygYouTube
					//->getUserProfile($_POST['syg_youtube_username']);
			
					// create a new gallery
					$gallery = new SygGallery($data);
			
					// update db
					$this->sygDao->addSygGallery($gallery);
			
					// updated flag
					$updated = true;
			
					// updated flag
					$this->data['updated'] = $updated;
				} catch (SygValidateException $ex) {
					// set the error
					$this->data['exception'] = true;
					$this->data['exception_message'] = $ex->getMessage();
					$this->data['exception_detail'] = $ex->getProblemFound();
				} catch (Exception $ex) {
					// set the error
					$this->data['exception'] = true;
					$this->data['exception_message'] = $ex->getMessage();
				}
			
				// render adminGallery view
				return $this->forwardToGalleries($updated);
			} else {
				// gallery administration form section
				// prepare header
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
			
				// put an empty gallery in the view
				$this->data['gallery'] = new SygGallery();
				
				// put styles to populate combo
				$this->data['styles'] = $this->sygDao->getAllSygStyles();
			
				// render adminGallery view
				return $this->render('adminGallery');
			}	
			
	}

	/**
	 * @name forwardToAddStyle
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToAddStyle() {

		$updated = false;

		if (isset($_POST['syg_submit_hidden'])
				&& $_POST['syg_submit_hidden'] == 'Y') {
			// database add style procedure
			// get posted values
			$data = serialize($_POST);

			try {
				// validate data
				//SygValidate::getInstance().validateStyle($data);

				// create a new gallery
				$style = new SygStyle($data);

				// update db
				$this->sygDao->addSygStyle($style);

				// updated flag
				$updated = true;

				// updated flag
				$this->data['updated'] = $updated;
			} catch (SygValidateException $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				$this->data['exception_detail'] = $ex->getProblemFound();
			} catch (Exception $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
			}

			// render adminGallery view
			return $this->forwardToStyles($updated);
		} else {
			// gallery administration form section
			// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

			// put an empty gallery in the view
			$this->data['style'] = new SygStyle();

			// render adminGallery view
			return $this->render('adminStyle');
		}
	}

	/**
	 * @name forwardToEditGallery
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToEditGallery() {
		if (isset($_POST['syg_submit_hidden'])
				&& $_POST['syg_submit_hidden'] == 'Y') {
			// database update procedure
			// get posted values
			$data = serialize($_POST);

			// validate posted values (to implement)
			$valid = true;

			if ($valid) {
				// create a new gallery
				$syg = new SygGallery($data);

				// update db
				$this->sygDao->updateSygGallery($syg);

				// updated flag
				$updated = true;

				// updated flag
				$this->data['updated'] = $updated;
			} else {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = SygConstant::BE_VALIDATE_USER_NOT_FOUND;
			}

			// render adminGallery view
			return $this->forwardToGalleries($updated);
		} else {
			// get the gallery id
			$id = (int) $_GET['id'];

			// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

			// put gallery in the view
			$this->data['gallery'] = $this->sygDao->getSygGalleryById($id);

			// put styles to populate combo
			$this->data['styles'] = $this->sygDao->getAllSygStyles();
			
			// render adminGallery view
			return $this->render('adminGallery');
		}
	}
	
	/**
	 * @name forwardToEditStyle
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToEditStyle() {
		if (isset($_POST['syg_submit_hidden'])
				&& $_POST['syg_submit_hidden'] == 'Y') {
			// database update procedure
			// get posted values
			$data = serialize($_POST);
	
			// validate posted values (to implement)
			$valid = true;
	
			if ($valid) {
				// create a new gallery
				$style = new SygStyle($data);
	
				// update db
				$this->sygDao->updateSygStyle($style);
	
				// updated flag
				$updated = true;
	
				// updated flag
				$this->data['updated'] = $updated;
			} else {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = SygConstant::BE_VALIDATE_USER_NOT_FOUND;
			}
	
			// render adminStyle view
			return $this->forwardToStyles($updated);
		} else {
			// get the style id
			$id = (int) $_GET['id'];
	
			// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
	
			// put style in the view
			$this->data['style'] = $this->sygDao->getSygStyleById($id);

			// render adminStyle view
			return $this->render('adminStyle');
		}
	}

	/**
	 * @name forwardToDeleteGallery
	 * @category admin forward
	 * @since 1.0.1
	 */
	public function forwardToDeleteGallery() {
		// get the gallery id
		$id = (int) $_GET['id'];
		
		// delete gallery
		$this->sygDao->deleteSygGallery($this->sygDao->getSygGalleryById($id));

		die();
	}
	
	/**
	 * @name forwardToDeleteStyle
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToDeleteStyle() {
		// get the gallery id
		$id = (int) $_GET['id'];
	
		// delete gallery
		$this->sygDao->deleteSygStyle($this->sygDao->getSygStyleById($id));
	
		die();
	}

	/**
	 * @name forwardToSupport
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToSupport() {
		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

		// render contact view
		return $this->render('adminSupport');
	}

	/**
	 * @name getAuthToken
	 * @category admin forward
	 * @since 1.0.1
	 * @return $token
	 */
	private function getAuthToken() {
		return $token;
	}

	/**
	 * @name getOptions
	 * @category get plugin options
	 * @since 1.3.0
	 * @return $settings
	 */
	public function getOptions() {
		$options = array();
		$options['syg_option_apikey'] = get_option('syg_option_apikey');
		$options['syg_option_numrec'] = get_option('syg_option_numrec');
		
		return $options;
	}
	
	/**
	 * @name verifyAuthToken
	 * @category admin forward
	 * @since 1.0.1
	 * @return $authorized
	 */
	public function verifyAuthToken($str) {
		return true;
	}

	/**
	 * @name getViewCtx
	 * @category admin forward
	 * @since 1.0.1
	 * @param $id
	 * @return $context
	 */
	public function getViewCtx($id = null) {
		if (is_int((int) $id)) {
			$dao = new SygDao();
			$this->data['gallery'] = $dao->getSygGalleryById($id);
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
			return $this->data;
		}
		return false;
	}
}
?>