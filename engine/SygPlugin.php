<?php

/**
 * @name Sliding Youtube Gallery Plugin Controller
 * @category Plugin mvc controller
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.3.0
 * 
 * @todo Creare la pagina support con facebook + twitter + mail (milestone v1.4.0)
 * @todo Background image (milesone v1.4.0)
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
	private $jsonQueryIfUrl;

	private $syg = array();

	private $sygYouTube;
	private $sygDao;

	  /*************************/
	 /* CONFIGURATION METHODS */
	/*************************/
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
		$this->setPluginRoot(WP_PLUGIN_URL . SygConstant::WP_PLUGIN_PATH);

		// set the css path
		$this->setCssRoot(WP_PLUGIN_URL . SygConstant::WP_CSS_PATH);

		// set the js path
		$this->setJsRoot(WP_PLUGIN_URL . SygConstant::WP_JS_PATH);

		// set the img path
		$this->setImgRoot(WP_PLUGIN_URL . SygConstant::WP_IMG_PATH);

		// set json query interface url
		$this->setJsonQueryIfUrl(WP_PLUGIN_URL . SygConstant::WP_JQI_URL);

		// set local object
		$this->sygYouTube = new SygYouTube();
		$this->sygDao = new SygDao();
	}

	/**
	 * @name setDefaultOption
	 * @category configuration
	 * @since 1.3.0
	 */
	public function setDefaultOption() {
		if (!get_option('syg_option_apikey'))
			add_option('syg_option_apikey',
					SygConstant::SYG_OPTION_DEFAULT_API_KEY);
		if (!get_option('syg_option_numrec'))
			add_option('syg_option_numrec',
					SygConstant::SYG_OPTION_DEFAULT_NUM_REC);
		if (!get_option('syg_option_pagenumrec'))
			add_option('syg_option_pagenumrec',
					SygConstant::SYG_OPTION_DEFAULT_PAGENUM_REC);
		if (!get_option('syg_option_paginationarea'))
			add_option('syg_option_paginationarea',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATION_AREA);
		if (!get_option('syg_option_paginator_borderradius'))
			add_option('syg_option_paginator_borderradius',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_BORDERRADIUS);
		if (!get_option('syg_option_paginator_bordersize'))
			add_option('syg_option_paginator_bordersize',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_BORDERSIZE);
		if (!get_option('syg_option_paginator_bordercolor'))
			add_option('syg_option_paginator_bordercolor',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_BORDERCOLOR);
		if (!get_option('syg_option_paginator_bgcolor'))
			add_option('syg_option_paginator_bgcolor',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_BGCOLOR);
		if (!get_option('syg_option_paginator_shadowcolor'))
			add_option('syg_option_paginator_shadowcolor',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_SHADOWCOLOR);
		if (!get_option('syg_option_paginator_shadowsize'))
			add_option('syg_option_paginator_shadowsize',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_SHADOWSIZE);
		if (!get_option('syg_option_paginator_fontcolor'))
			add_option('syg_option_paginator_fontcolor',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_FONTCOLOR);
		if (!get_option('syg_option_paginator_fontsize'))
			add_option('syg_option_paginator_fontsize',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_FONTSIZE);
	}

	/**
	 * @name removeOldOption
	 * @category configuration
	 * @since 1.2.5
	 */
	public static function removeOldOption() {
		global $wpdb;

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
		$domain_name = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST']
				: $_SERVER['SERVER_NAME'];

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
	 * @name getViewCtx
	 * @category admin forward
	 * @since 1.0.1
	 * @param $id
	 * @return array $context
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

	  /*****************************/
	 /* END CONFIGURATION METHODS */
	/*****************************/

	  /********************************/
	 /* WORDPRESS PLUGIN ACTION HOOK */
	/********************************/

	/**
	 * @name uninstall
	 * @category uninstall plugin hook
	 * @since 1.0.1
	 */
	public static function uninstall() {
		global $wpdb;

		// get table name
		$galleryTable = $wpdb->prefix . 'syg';
		$styleTable = $wpdb->prefix . 'syg_OLD_V12X';
		$backupTable = $wpdb->prefix . 'syg_styles';

		// remove table
		$dao = new SygDao();
		$dao->removeTable($galleryTable);
		$dao->removeTable($styleTable);
		$dao->removeTable($backupTable);

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
		$target_syg_db_version = SygConstant::SYG_VERSION;

		// get the current db version
		$installed_ver = get_option("syg_db_version");

		if ($installed_ver != $target_syg_db_version) {
			try {
				// create a brand new dao
				$dao = new SygDao();

				// update database structure
				$dao->updateVersion($installed_ver, $target_syg_db_version);

				// set default option
				self::setDefaultOption();

				// add or update db version option
				(!get_option("syg_db_version")) ? add_option("syg_db_version",
								$target_syg_db_version)
						: update_option("syg_db_version",
								$target_syg_db_version);

				// send stat
				self::notify(SygConstant::BE_ACTION_ACTIVATION);
			} catch (Exception $ex) {

			}
		}
	}

	  /************************************/
	 /* END WORDPRESS PLUGIN ACTION HOOK */
	/************************************/

	  /***********************/
	 /* GETTERS AND SETTERS */
	/***********************/
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
	 * @name setJsonQueryIfUrl
	 * @category getters and setters
	 * @since 1.3.0
	 * @param $jsonQueryIfUrl
	 */
	public function setJsonQueryIfUrl($jsonQueryIfUrl) {
		$this->jsonQueryIfUrl = $jsonQueryIfUrl;
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

	/**
	 * @name getJsonQueryIfUrl
	 * @category getters and setters
	 * @since 1.3.0
	 * @return the $jsonQueryIfUrl
	 */
	public function getJsonQueryIfUrl() {
		return $this->jsonQueryIfUrl;
	}

	  /***************************/
	 /* END GETTERS AND SETTER  */
	/***************************/

	  /**************************/
	 /* FRONT END CORE METHODS */
	/**************************/

	/**
	 * @name Get gallery settings returning its DTO
	 * @param $id 
	 * @return array $settings
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
		$settings = $gallery->toDto(true); 
		return $settings;
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

				// put the feed in the view
				$this->data['feed'] = $this->getVideoFeed($gallery);

				// put the gallery settings in the view
				$this->data['gallery'] = $gallery;

				// put component type in the view (javascript optimization)
				$this->data['component_type'] = SygConstant::SYG_PLUGIN_COMPONENT_GALLERY;

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
	 * @name getVideoFeed
	 * @category get a youtube video feed
	 * @since 1.3.0
	 * @param $gallery
	 * @param $start
	 * @param $per_page
	 * @throws Exception
	 * @return mixed $feed
	 */
	public function getVideoFeed(SygGallery $gallery, $start = null,	$per_page = null) {
		$feed = new Zend_Gdata_YouTube_VideoFeed();
		if ($gallery->getGalleryType() == 'feed') {
			$feed = $this->sygYouTube->getUserUploads($gallery, $start, $per_page);
		} else if ($gallery->getGalleryType() == 'list') {
			$feed = $this->sygYouTube->getUserList($gallery, $start, $per_page);
		} else if ($gallery->getGalleryType() == 'playlist') {
			$feed = $this->sygYouTube->getUserPlaylist($gallery, $start, $per_page);
		}
		
		return $feed;
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

				// put the gallery settings in the view
				$this->data['gallery'] = $gallery;

				// number of pages
				$options = $this->getOptions();
				$this->data['options'] = $options;

				// calculate pages
				$this->data['pages'] = ceil(
						$gallery->countGalleryEntry()
								/ $options['syg_option_pagenumrec']);

				// put component type in the view (javascript optimization)
				$this->data['component_type'] = SygConstant::SYG_PLUGIN_COMPONENT_PAGE;

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
	 * @name prepareHeader
	 * @category prepare header with the right js and css inclusion
	 * @since 1.0.1
	 * @param &$view
	 * @param $context
	 */
	private function prepareHeader(&$view, $context = SygConstant::SYG_CTX_FE) {
		// define resources path
		$view['cssPath'] = $this->getCssRoot();
		$view['imgPath'] = $this->getImgRoot();
		$view['jsPath'] = $this->getJsRoot();
		// define plugin url
		$view['pluginUrl'] = $this->getPluginRoot();

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
					$view['jsPath'] . 'SlidingYoutubeGalleryAdmin.js', array(),
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
			$view['sygJsUrl'] = $view['jsPath'] . 'SlidingYoutubeGallery.js';
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
			// include sliding youtube gallery js library
			wp_register_script('sliding-youtube-gallery', $view['sygJsUrl'],
					array(), SygConstant::SYG_VERSION, true);
			wp_enqueue_script('sliding-youtube-gallery');
			// include fancybox js library
			wp_register_script('fancybox', $view['fancybox_js_url'], array(),
					SygConstant::SYG_VERSION, true);
			wp_enqueue_script('fancybox');
			// include easing js library
			wp_register_script('easing', $view['easing_js_url'], array(),
					SygConstant::SYG_VERSION, true);
			wp_enqueue_script('easing');
			// include mousewheel js library
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

	  /******************************/
	 /* END FRONT END CORE METHODS */
	/******************************/

	  /**************************/
	 /* ADMIN SECTION FORWARDS */
	/**************************/

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
			$this->data['redirect_url'] = '?page='
					. SygConstant::BE_ACTION_MANAGE_GALLERIES;
			return $this->render('redirect');
		default:
		// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

			// put galleries in the view
			$galleries = $this->sygDao->getAllSygGalleries();

			// put galleries in the view
			$this->data['galleries'] = $galleries;

			// number of pages
			$options = $this->getOptions();
			$this->data['pages'] = ceil(
					$this->sygDao->getGalleriesCount()
							/ $options['syg_option_numrec']);

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
			$this->data['redirect_url'] = '?page='
					. SygConstant::BE_ACTION_MANAGE_STYLES;
			return $this->render('redirect');
		default:
		// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

			// put galleries in the view
			$styles = $this->sygDao->getAllSygStyles();

			// put galleries in the view
			$this->data['styles'] = $styles;

			// number of pages
			$options = $this->getOptions();
			$this->data['pages'] = ceil(
					$this->sygDao->getStylesCount()
							/ $options['syg_option_numrec']);

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
		$updated = false;
		if (isset($_POST['syg_submit_hidden'])
				&& $_POST['syg_submit_hidden'] == 'Y') {
			// database add/edit settings procedure
			// get posted values
			$data = serialize($_POST);
			try {
				// validate data
				$valid = SygValidate::validateSettings($data);

				(!get_option('syg_option_apikey')) ? add_option(
								'syg_option_apikey',
								$_POST['syg_option_apikey'])
						: update_option('syg_option_apikey',
								$_POST['syg_option_apikey']);
				(!get_option('syg_option_numrec')) ? add_option(
								'syg_option_numrec',
								$_POST['syg_option_numrec'])
						: update_option('syg_option_numrec',
								$_POST['syg_option_numrec']);
				(!get_option('syg_option_pagenumrec')) ? add_option(
								'syg_option_pagenumrec',
								$_POST['syg_option_pagenumrec'])
						: update_option('syg_option_pagenumrec',
								$_POST['syg_option_pagenumrec']);
				(!get_option('syg_option_paginationarea')) ? add_option(
								'syg_option_paginationarea',
								$_POST['syg_option_paginationarea'])
						: update_option('syg_option_paginationarea',
								$_POST['syg_option_paginationarea']);

				(!get_option('syg_option_paginator_borderradius')) ? add_option(
								'syg_option_paginator_borderradius',
								$_POST['syg_option_paginator_borderradius'])
						: update_option('syg_option_paginator_borderradius',
								$_POST['syg_option_paginator_borderradius']);
				(!get_option('syg_option_paginator_bordersize')) ? add_option(
								'syg_option_paginator_bordersize',
								$_POST['syg_option_paginator_bordersize'])
						: update_option('syg_option_paginator_bordersize',
								$_POST['syg_option_paginator_bordersize']);
				(!get_option('syg_option_paginator_bordercolor')) ? add_option(
								'syg_option_paginator_bordercolor',
								$_POST['syg_option_paginator_bordercolor'])
						: update_option('syg_option_paginator_bordercolor',
								$_POST['syg_option_paginator_bordercolor']);
				(!get_option('syg_option_paginator_bgcolor')) ? add_option(
								'syg_option_paginator_bgcolor',
								$_POST['syg_option_paginator_bgcolor'])
						: update_option('syg_option_paginator_bgcolor',
								$_POST['syg_option_paginator_bgcolor']);
				(!get_option('syg_option_paginator_shadowcolor')) ? add_option(
								'syg_option_paginator_shadowcolor',
								$_POST['syg_option_paginator_shadowcolor'])
						: update_option('syg_option_paginator_shadowcolor',
								$_POST['syg_option_paginator_shadowcolor']);
				(!get_option('syg_option_paginator_shadowsize')) ? add_option(
								'syg_option_paginator_shadowsize',
								$_POST['syg_option_paginator_shadowsize'])
						: update_option('syg_option_paginator_shadowsize',
								$_POST['syg_option_paginator_shadowsize']);
				(!get_option('syg_option_paginator_fontcolor')) ? add_option(
								'syg_option_paginator_fontcolor',
								$_POST['syg_option_paginator_fontcolor'])
						: update_option('syg_option_paginator_fontcolor',
								$_POST['syg_option_paginator_fontcolor']);
				(!get_option('syg_option_paginator_fontsize')) ? add_option(
								'syg_option_paginator_fontsize',
								$_POST['syg_option_paginator_fontsize'])
						: update_option('syg_option_paginator_fontsize',
								$_POST['syg_option_paginator_fontsize']);

				$this->data['redirect_url'] = '?page='
						. SygConstant::BE_ACTION_MANAGE_SETTINGS;

				// render adminStyles view
				return $this->render('redirect');
			} catch (SygValidateException $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				$this->data['exception_detail'] = $ex->getProblems();
			} catch (Exception $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
			}
		}

		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

		// get settings
		$options = $this->getOptions();

		// put settings in the view
		$this->data['options'] = $options;

		// render adminSettings view
		return $this->render('adminSettings');
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
			// database add gallery procedure
			// get posted values
			$data = serialize($_POST);

			try {
				// validate data
				$valid = SygValidate::validateGallery($data);

				// create a new gallery
				$gallery = new SygGallery($data);

				// update db
				$this->sygDao->addSygGallery($gallery);

				// updated flag
				$updated = true;

				// updated flag
				$this->data['updated'] = $updated;

				// render adminGallery view
				return $this->forwardToGalleries($updated);
			} catch (SygValidateException $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				$this->data['exception_detail'] = $ex->getProblems();
			} catch (Exception $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
			}
		}

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
				$valid = SygValidate::validateStyle($data);

				// create a new gallery
				$style = new SygStyle($data);

				// update db
				$this->sygDao->addSygStyle($style);

				// updated flag
				$updated = true;

				// updated flag
				$this->data['updated'] = $updated;

				// render adminGallery view
				return $this->forwardToStyles($updated);
			} catch (SygValidateException $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				$this->data['exception_detail'] = $ex->getProblems();
			} catch (Exception $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
			}
		}
		// gallery administration form section
		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

		// put an empty gallery in the view
		$this->data['style'] = new SygStyle();

		// render adminGallery view
		return $this->render('adminStyle');
	}

	/**
	 * @name forwardToEditGallery
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToEditGallery() {
		$updated = false;
		if (isset($_POST['syg_submit_hidden'])
				&& $_POST['syg_submit_hidden'] == 'Y') {

			// database update procedure
			// get posted values
			$data = serialize($_POST);

			try {
				// validate data
				$valid = SygValidate::validateGallery($data);

				// create a new gallery
				$syg = new SygGallery($data);

				// update db
				$this->sygDao->updateSygGallery($syg);

				// updated flag
				$updated = true;

				// updated flag
				$this->data['updated'] = $updated;

				// render adminGallery view
				return $this->forwardToGalleries($updated);
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
		}

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

	/**
	 * @name forwardToEditStyle
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToEditStyle() {
		$updated = false;
		if (isset($_POST['syg_submit_hidden'])
				&& $_POST['syg_submit_hidden'] == 'Y') {

			// database update procedure
			// get posted values
			$data = serialize($_POST);

			try {
				// validate data
				$valid = SygValidate::validateStyle($data);

				// create a new gallery
				$style = new SygStyle($data);

				// update db
				$this->sygDao->updateSygStyle($style);

				// updated flag
				$updated = true;

				// updated flag
				$this->data['updated'] = $updated;

				// render adminStyle view
				return $this->forwardToStyles($updated);

			} catch (SygValidateException $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				$this->data['exception_detail'] = $ex->getProblems();
			} catch (Exception $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
			}
		}

		// get the style id
		$id = (int) $_GET['id'];

		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

		// put style in the view
		$this->data['style'] = $this->sygDao->getSygStyleById($id);

		// render adminStyle view
		return $this->render('adminStyle');

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

	  /******************************/
	 /* END ADMIN SECTION FORWARDS */
	/******************************/

	  /********************/
	 /* SECURITY METHODS */
	/********************/

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
	 * @return array $options
	 */
	public function getOptions() {
		$options = array();
		$options['syg_option_apikey'] = get_option('syg_option_apikey');
		$options['syg_option_numrec'] = get_option('syg_option_numrec');
		$options['syg_option_pagenumrec'] = get_option('syg_option_pagenumrec');
		$options['syg_option_paginationarea'] = get_option('syg_option_paginationarea');
		
		/* paginator options */
		$options['syg_option_paginator_borderradius'] = get_option('syg_option_paginator_borderradius');
		$options['syg_option_paginator_bordersize'] = get_option('syg_option_paginator_bordersize');
		$options['syg_option_paginator_bordercolor'] = get_option('syg_option_paginator_bordercolor');
		$options['syg_option_paginator_bgcolor'] = get_option('syg_option_paginator_bgcolor');
		$options['syg_option_paginator_shadowcolor'] = get_option('syg_option_paginator_shadowcolor');
		$options['syg_option_paginator_fontcolor'] = get_option('syg_option_paginator_fontcolor');
		$options['syg_option_paginator_shadowsize'] = get_option('syg_option_paginator_shadowsize');
		$options['syg_option_paginator_fontsize'] = get_option('syg_option_paginator_fontsize');
		
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

	  /************************/
	 /* END SECURITY METHODS */
	/************************/
}
?>