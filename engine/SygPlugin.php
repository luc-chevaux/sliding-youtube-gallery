<?php

/**
 * @name Sliding Youtube Gallery Plugin Controller
 * @category Plugin mvc controller
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.4.4
 * 
 * @todo Background image (milestone v1.4.0)
 * @todo widget wordpress + Implementare scroll verticale (milestone v1.4.0)
 */

include_once 'Zend/Loader.php';

if (!class_exists('SanityPluginFramework')) require_once(SYG_PATH . 'engine/lib/Sanity/sanity.php');

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
	
	// this attribute set the json query interface script url (data.php)
	private $jsonQueryIfUrl;
	private $jsonQueryIfAdminUrl;

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
		$me = SYG_PATH . '/engine/SlidingYouTubeGalleryPlugin.php';

		parent::__construct(dirname($me));

		// set environment
		$this->setEnvironment();
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
		
		// set json query interface admin url
		$this->setJsonQueryIfAdminUrl(WP_PLUGIN_URL . SygConstant::WP_JQI_ADMIN_URL);

		// set local object
		$this->sygYouTube = new SygYouTube();
		$this->sygDao = new SygDao();
	}

	/**
	 * @name setDefaultOption
	 * @category configuration
	 * @since 1.3.0
	 * @todo gestire le opzioni in opportuna mappa per ciclarla
	 */
	public static function setDefaultOption() {
		foreach (SygConstant::$SYG_PLUGIN_OPTIONS as $key => $value) {
			if (!get_option($key)) add_option($key, $value['DEFAULT']);
		}
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
			$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_GALLERY);
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

	public function rebuildCache($id) {
		$gallery = $this->sygDao->getSygGalleryById($id, 'OBJECT');
		$gallery->cacheGallery();
	}
	
	/**
	 * @name sygNotice
	 * @category display admin notices in wordpress dashboard
	 * @since 1.3.3
	 * @todo aggiungere check permission filesystem
	 */
	public function sygNotice() {
		global $pagenow;
		// $this->printTasks();
		if (($pagenow == 'admin.php')
				&& (($_GET['page'] == SygConstant::BE_ACTION_MANAGE_STYLES)
					|| ($_GET['page'] == SygConstant::BE_ACTION_MANAGE_GALLERIES)
					|| ($_GET['page'] == SygConstant::BE_ACTION_MANAGE_SETTINGS)
					|| ($_GET['page'] == SygConstant::BE_ACTION_CONTACTS)) 
				&& !(isset($_POST['syg_submit_hidden'])	&& $_POST['syg_submit_hidden'] == 'Y')) {

			$checkStyles = (bool) $this->sygDao->getStylesCount();
			$checkGallery = (bool) $this->sygDao->getGalleriesCount();
			$checkFSPermission = (bool) (is_writable(WP_PLUGIN_DIR . SygConstant::WP_CACHE_DIR) && 
										 is_writable(WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_HTML_REL_DIR) && 
										 is_writable(WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_THUMB_REL_DIR) &&
										 is_writable(WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_JSON_REL_DIR) && 
										 is_writable(WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_JS_REL_DIR));
			
			// define a warning array
			$warning = array();
			
			// check if gallery exist
			if (!$checkGallery) {
				array_push($warning, array('field' => '', 'msg' => SygConstant::BE_NO_GALLERY_FOUND_ADM_WRN));
			}
			
			// check if style exist
			if (!$checkStyles) {
				array_push($warning, array('field' => '', 'msg' => SygConstant::BE_NO_STYLES_FOUND_ADM_WRN));
			}
			
			if (!$checkFSPermission) {
				array_push($warning, array('field' => '', 'msg' => SygConstant::BE_FS_NOT_WRITEABLE));
			}
			
			// place warnings in the view
			$this->data['warning'] = $warning;
			
			// try to validate options
			try {
				$checkOptions = (bool) SygValidate::validateSettings(serialize(SygPlugin::getInstance()->getOptions()));
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
	}


	/**
	 * @name printTasks
	 * @category debug function
	 * @since 1.4.0
	 */
	public function printTasks() {
		print_r(_get_cron_array());
	}
	
	/**
	 * @name checkUpdateProcess
	 * @category check update process
	 * @since 1.3.3
	 */
	public static function checkUpdateProcess() {
		global $wpdb;
		global $syg_db_version;
		// set db version
		$target_syg_db_version = SygConstant::SYG_VERSION;
		
		// get the current db version
		$installed_ver = get_option("syg_db_version");
		
		// chmod all the cache directories to ensure that is writeable
		$stat = stat(WP_PLUGIN_DIR . SygConstant::WP_CACHE_DIR);

		if ((getmygid() == $stat['gid']) || ($stat['gid'] == 0)) {
			chmod ( WP_PLUGIN_DIR . SygConstant::WP_CACHE_DIR, 0755 );
			chmod ( WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_HTML_REL_DIR, 0755 );
			chmod ( WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_THUMB_REL_DIR, 0755 );
			chmod ( WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_JSON_REL_DIR, 0755 );
			chmod ( WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_JS_REL_DIR, 0755);
		}
		
		if ($installed_ver != $target_syg_db_version) {
			try {
				// create a brand new dao
				$dao = new SygDao();
		
				// update database structure
				$dao->updateVersion($installed_ver, $target_syg_db_version);
		
				// add or update db version option
				(!get_option("syg_db_version")) ? add_option("syg_db_version",
						$target_syg_db_version)
						: update_option("syg_db_version",
								$target_syg_db_version);
			} catch (Exception $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
			}
		}
	}
	
	/**
	 * @name uninstall
	 * @category uninstall plugin hook
	 * @since 1.0.1
	 */
	public static function uninstall() {
		global $wpdb;
		
		// check if admin
		if (is_admin()) {
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
		}
	}

	/**
	 * @name deactivation
	 * @category deactivation plugin hook
	 * @since 1.0.1
	 */
	public static function deactivation() {
		// check if admin
		if (is_admin()) {
			null;
		}
	}

	/**
	 * @name activation
	 * @category deactivation plugin hook
	 * @since 1.0.1
	 */
	public static function activation() {
		// check if admin
		if (is_admin()) {
			self::checkUpdateProcess();
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
	private function setJsonQueryIfUrl($jsonQueryIfUrl) {
		$this->jsonQueryIfUrl = $jsonQueryIfUrl;
	}

	/**
	 * @param field_type $jsonQueryIfAdminUrl
	 */
	public function setJsonQueryIfAdminUrl($jsonQueryIfAdminUrl) {
		$this->jsonQueryIfAdminUrl = $jsonQueryIfAdminUrl;
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
	
	/**
	 * @return the $jsonQueryIfAdminUrl
	 */
	public function getJsonQueryIfAdminUrl() {
		return $this->jsonQueryIfAdminUrl;
	}
	
	/**
	 * @name getCurrentUserRole
	 * @category returns the translated role of the current user
	 * @return string The name of the current role
	 */
	public static function getCurrentUserRole() {
		global $wp_roles;
		$current_user = wp_get_current_user();
		$roles = $current_user->roles;
		$role = array_shift($roles);
		return isset($wp_roles->role_names[$role]) ? $wp_roles->role_names[$role] : false;
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

		if ($id == 0) {
			// generate a fake gallery
			$gallery = new SygGallery();
		} else {
			// get the gallery
			$dao = new SygDao();
			$gallery = $dao->getSygGalleryById($id);
		}
		
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
	public function getGallery($attributes, $mode = SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
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
				
				// put component type in the view (javascript optimization)
				$this->data['component_type'] = SygConstant::SYG_PLUGIN_COMPONENT_GALLERY;
				
				// put mode option in the view context
				$this->data['mode'] = $mode;
				
				// put the options in the view context
				$this->data['options'] = $this->getOptions();
				
				if ($gallery->isGalleryCached() && $mode == SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {					
					// set front end option
					$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_GALLERY);
					
					// render cache files
					return $this->cacheRender($gallery->getId(), SygConstant::SYG_PLUGIN_COMPONENT_GALLERY);
				} else {
					// put the feed in the view
					$this->data['feed'] = $this->sygYouTube->getVideoFeed($gallery);
		
					// set front end option
					$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_GALLERY);
					
					// render gallery snippet code
					return $this->render('client/'.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY);
				}
			} catch (SygGalleryNotFoundException $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_GALLERY);
				return $this->render('exception');
			} catch (Exception $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_GALLERY);
				return $this->render('exception');
			}
		}
	}

	/**
	 * @name getPage
	 * @category get a video page
	 * @since 1.0.1
	 * @param $attributes
	 * @return $output
	 */
	public function getPage($attributes, $mode = SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
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
				
				// get options
				$options = $this->getOptions();
				
				// number of pages
				$this->data['options'] = $options;
					
				// calculate pages
				$this->data['pages'] = ceil(
						$gallery->countGalleryEntry()
						/ $options['syg_option_pagenumrec']);
					
				// put component type in the view (javascript optimization)
				$this->data['component_type'] = SygConstant::SYG_PLUGIN_COMPONENT_PAGE;
					
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_PAGE);
				
				if ($gallery->isGalleryCached() && $mode == SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
					return $this->cacheRender($gallery->getId(), SygConstant::SYG_PLUGIN_COMPONENT_PAGE);
				} else {					
					// render gallery snippet code
					return $this->render('client/'.SygConstant::SYG_PLUGIN_COMPONENT_PAGE);
				}
			}  catch (SygGalleryNotFoundException $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_PAGE);
				return $this->render('exception');
			} catch (Exception $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_PAGE);
				return $this->render('exception');
			}
		}
	}

	/**
	 * @name getCarousel
	 * @category get a video carousel
	 * @since 1.0.1
	 * @param $attributes
	 * @return $output
	 */
	public function getCarousel($attributes, $mode = SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
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
		
				// put component type in the view (javascript optimization)
				$this->data['component_type'] = SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL;
		
				// put mode option in the view context
				$this->data['mode'] = $mode;
		
				// put the options in the view context
				$this->data['options'] = $this->getOptions();
				
				if ($gallery->isGalleryCached() && $mode == SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
					// set front end option
					$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_CAROUSEL);
						
					// render cache files
					return $this->cacheRender($gallery->getId(), SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL);
				} else if ($mode == SygConstant::SYG_PLUGIN_FE_CACHING_MODE) {
					return $this->render('client/'.SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL);
				} else {
					$this->data['exception'] = true;
					$this->data['exception_message'] = SygConstant::MSG_EX_GALLERY_NOT_CACHED;
					// set front end option
					$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_CAROUSEL);
					return $this->render('exception');
				}
			} catch (SygGalleryNotFoundException $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_CAROUSEL);
				return $this->render('exception');
			} catch (Exception $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_CAROUSEL);
				return $this->render('exception');
			}
		}
	}
	
	/**
	 * @name getElastislide
	 * @category get a video elastislide
	 * @since 1.5.0
	 * @param $attributes
	 * @return $output
	 */
	public function getElastislide($attributes, $mode = SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
		// extract shortcode attributes	
		extract(shortcode_atts(array('id' => null, 'type' => 'horizontal'), $attributes));
	
		if (!empty($id)) {
			try {
				// get the gallery
				$dao = new SygDao();
				$gallery = $dao->getSygGalleryById($id);
	
				// put the gallery settings in the view
				$this->data['gallery'] = $gallery;
	
				// put component type in the view (javascript optimization)
				$this->data['component_type'] = SygConstant::SYG_PLUGIN_COMPONENT_ELASTISLIDE;
	
				// put mode option in the view context
				$this->data['mode'] = $mode;
	
				// put the options in the view context
				$this->data['options'] = $this->getOptions();
	
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_ELASTISLIDE);
				
				if ($gallery->isGalleryCached() && $mode == SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {	
					// render cache files
					return $this->cacheRender($gallery->getId(), SygConstant::SYG_PLUGIN_COMPONENT_ELASTISLIDE);
				} else {
					// put the feed in the view
					$this->data['feed'] = $this->sygYouTube->getVideoFeed($gallery);
					
					return $this->render('client/'.SygConstant::SYG_PLUGIN_COMPONENT_ELASTISLIDE);
				}
			} catch (SygGalleryNotFoundException $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_ELASTISLIDE);
				return $this->render('exception');
			} catch (Exception $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_SHORTAG_ELASTISLIDE);
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
	private function prepareHeader(&$view, $shortag = null) {
		// define resources path
		$view['cssPath'] = $this->getCssRoot();
		$view['imgPath'] = $this->getImgRoot();
		$view['jsPath'] = $this->getJsRoot();
		$view['pluginUrl'] = $this->getPluginRoot();
		
		// get options
		$options = $this->getOptions();
		
		// detect if client is a mobile browser
		$detect = new Mobile_Detect();
		$conditions['mobile'] = (bool) $detect->isMobile();
		
		// fix index
		if (empty($view['gallery'])) {
			$galleryId = 0;
		} else {
			$gallery = $view['gallery'];
			$galleryId = $gallery->getId();
		}
		
		// use simplexmlelement to parse header injection configuration file 
		$headInjObject = simplexml_load_file($view['pluginUrl'].'/engine/conf/headerInjection.xml');
		// find library to include
		$libs = $headInjObject->xpath('/headerInjection/enqueueList[@shortag=\''.$shortag.'\']/library');
		
		// scan libs array and include the right resources
		foreach ($libs as $value) {
			 $attributes = $value->attributes();
			 $lib_to_include = (String)$attributes['name'];
			 $ver_to_include = (String)$attributes['version'];
			 
			 if (!empty($ver_to_include)) {
			 	$resource =  $headInjObject->xpath('/headerInjection/libraries/library[@name=\''.$lib_to_include.'\' and @version=\''.$ver_to_include.'\']/resource');
			 } else {
			 	$resource =  $headInjObject->xpath('/headerInjection/libraries/library[@name=\''.$lib_to_include.'\']/resource');
			 }
			
			 foreach ($resource as $key => $value) {
			 	$res = new SygResourceAdapter($value, $galleryId, $conditions);
			 	$res->enqueue();
			 }
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
		// if we've updated a record set action to null
		if ($updated == true) { 
			$action = 'redirect';
		} elseif (isset($_GET['action'])) { 
			$action = $_GET['action'];
		} else {
			$action = 'default';
		}

		// determine wich action to call
		switch ($action) {
			case 'add':
				return $this->forwardToAddGallery();
			case 'edit':
				return $this->forwardToEditGallery();
			case 'delete':
				return $this->forwardToDeleteGallery();
			case 'cache':
				return $this->forwardToCacheGallery();
			case 'redirect':
				$this->data['redirect_url'] = '?page=' . SygConstant::BE_ACTION_MANAGE_GALLERIES . '&modified='.$_GET['id'];
				return $this->render('redirect');
			default:
				// prepare header
				$this->prepareHeader($this->data, SygConstant::SYG_ADMIN);
	
				// instantiate dao
				$dao = new SygDao();
				
				// put styles count in the view
				$this->data['stylesCount'] = $dao->getStylesCount();
				
				// number of pages
				$options = $this->getOptions();
				$this->data['pages'] = ceil($this->sygDao->getGalleriesCount() / $options['syg_option_numrec']);
	
				// render admin/Galleries view
				return $this->render('admin/Galleries');
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
		// if we've updated a record set action to null
		if ($updated == true) { 
			$action = 'redirect';
		} elseif (isset($_GET['action'])) { 
			$action = $_GET['action'];
		} else {
			$action = 'default';
		}

		// determine wich action to call
		switch ($action) {
			case 'add':
				return $this->forwardToAddStyle();
			case 'edit':
				return $this->forwardToEditStyle();
			case 'delete':
				return $this->forwardToDeleteStyle();
			case 'cache':
				// get the style id
				$id = (int) $_GET['id'];
				$galleries = $this->sygDao->getSygCachedGalleriesByStyleId($id);
				
				for ($i=0; $i<count($galleries); $i++) {
					$gallery = $galleries[$i];
					if ($gallery->getCacheOn()) {
						$gallery->cacheGallery();
					}
				}
		
				break;
			case 'redirect':
				$this->data['redirect_url'] = '?page='
						. SygConstant::BE_ACTION_MANAGE_STYLES . '&modified='.$_GET['id'];
				return $this->render('redirect');
			default:
				// prepare header
				$this->prepareHeader($this->data, SygConstant::SYG_ADMIN);
	
				// put galleries in the view
				$styles = $this->sygDao->getAllSygStyles();
	
				// put galleries in the view
				$this->data['styles'] = $styles;
	
				// number of pages
				$options = $this->getOptions();
				$this->data['pages'] = ceil(
						$this->sygDao->getStylesCount()
								/ $options['syg_option_numrec']);
	
				// render admin/Styles view
				return $this->render('admin/Styles');
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
		if (is_admin()) {
			// if we've updated a record set action to null
			$action = ($updated == true) ? 'redirect' : (isset( $_GET['action']) ? $_GET['action'] : 'default');
			// determine wich action to call
			switch ($action) {
				case 'cache':
					// update cached gallery
					$galleries = $this->sygDao->getAllCachedGallery();
					for ($i=0; $i<count($galleries); $i++) {
						$gallery = $galleries[$i];
						$gallery->cacheGallery();
					}
					break;
				default:
					if (isset($_POST['syg_submit_hidden'])
							&& $_POST['syg_submit_hidden'] == 'Y') {
						// database add/edit settings procedure
						// get posted values
						$data = serialize($_POST);
						try {
							// validate data
							$valid = SygValidate::validateSettings($data);
					
							// write options
							foreach (SygConstant::$SYG_PLUGIN_OPTIONS as $key => $value) {
								if (get_option($key) === false) {
									$optionValue = (!empty($_POST[$key])) ? $_POST[$key] : $value['DEFAULT'];
									add_option($key, $optionValue);
								} else {
									$optionValue = (($value['TYPE'] == 'CHECKBOX') && (empty($_POST[$key]))) ? 0 : $_POST[$key];
									update_option($key, $optionValue);
								}
							}
							
							$this->data['redirect_url'] = '?page=' . SygConstant::BE_ACTION_MANAGE_SETTINGS . '&modified=true';
							
							// render redirect view
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
					break;	
			}
			
			// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_ADMIN);
	
			// get settings
			$options = $this->getOptions();
	
			// put settings in the view
			$this->data['options'] = $options;
	
			// render admin/Settings view
			return $this->render('admin/Settings');
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
		if (!empty($_POST) && check_admin_referer('gallery','nonce_field')) {
			if (isset($_POST['syg_submit_hidden'])	&& $_POST['syg_submit_hidden'] == 'Y') {
				// database add gallery procedure
				// get posted values
				$data = serialize($_POST);
	
				try {
					// validate data
					$valid = SygValidate::validateGallery($data);
	
					// create a new gallery
					$gallery = new SygGallery($data);
	
					// update db
					$id = $this->sygDao->addSygGallery($gallery);
	
					// reload the gallery
					$gallery = $this->sygDao->getSygGalleryById($id);
					
					// updated flag
					$updated = true;
	
					// updated flag
					$this->data['updated'] = $updated;
	
					if ($gallery->getCacheOn()) {
						// cache gallery
						$gallery->cacheGallery();
					}
					
					// render updated view
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
		}
			
		// gallery administration form section
		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_ADMIN);

		// put an empty gallery in the view
		$this->data['gallery'] = new SygGallery();

		// put styles to populate combo
		$this->data['styles'] = $this->sygDao->getAllSygStyles();

		// render Gallery view
		return $this->render('admin/Gallery');
	}

	/**
	 * @name forwardToAddStyle
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToAddStyle() {
		$updated = false;
		if (!empty($_POST) && check_admin_referer('style','nonce_field')) {
			if (isset($_POST['syg_submit_hidden']) && $_POST['syg_submit_hidden'] == 'Y') {
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
	
					// render updated view
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
		}
		// gallery administration form section
		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_ADMIN);

		// put an empty gallery in the view
		$this->data['style'] = new SygStyle();

		// render Style view
		return $this->render('admin/Style');
	}

	/**
	 * @name forwardToEditGallery
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToEditGallery() {
		$updated = false;
		if (!empty($_POST) && check_admin_referer('gallery','nonce_field')) {
			if (isset($_POST['syg_submit_hidden'])	&& $_POST['syg_submit_hidden'] == 'Y') {
				// database update procedure
				// get posted values
				$data = serialize($_POST);
	
				try {
					// validate data
					$valid = SygValidate::validateGallery($data);
	
					// create a new gallery
					$gallery = new SygGallery($data);
					
					// update db
					$this->sygDao->updateSygGallery($gallery);
	
					// updated flag
					$updated = true;
	
					// updated flag
					$this->data['updated'] = $updated;
					
					if (!$gallery->getCacheOn()) {
						$gallery->removeFromCache();
					}
					
					// render updated view
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
		}
		// get the gallery id
		$id = (int) $_GET['id'];

		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_ADMIN);

		// put gallery in the view
		$this->data['gallery'] = $this->sygDao->getSygGalleryById($id);

		// put styles to populate combo
		$this->data['styles'] = $this->sygDao->getAllSygStyles();

		// render admin/Gallery view
		return $this->render('admin/Gallery');
	}

	/**
	 * @name forwardToEditStyle
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToEditStyle() {
		$updated = false;
		if (!empty($_POST) && check_admin_referer('style','nonce_field')) {
			if (isset($_POST['syg_submit_hidden'])	&& $_POST['syg_submit_hidden'] == 'Y') {
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
	
					// render updated view
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
		}
		// get the style id
		$id = (int) $_GET['id'];

		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_ADMIN);

		// put style in the view
		$this->data['style'] = $this->sygDao->getSygStyleById($id);

		// render Style view
		return $this->render('admin/Style');

	}

	/**
	 * @name forwardToDeleteGallery
	 * @category admin forward
	 * @since 1.0.1
	 */
	public function forwardToDeleteGallery() {
		if (current_user_can('delete_pages')) {
			// get the gallery id
			$id = (int) $_GET['id'];
			
			// get the gallery
			$gallery = $this->sygDao->getSygGalleryById($id);
			
			// remove file from cache
			$gallery->removeFromCache();
			
			// delete gallery
			$this->sygDao->deleteSygGallery($gallery);
			
			die();
		}
	}
	
	/**
	 * @name forwardToCacheGallery
	 * @category admin forward
	 * @since 1.4.0
	 */
	public function forwardToCacheGallery() {
		if (current_user_can('edit_posts')) {
			// get the gallery id
			$id = (int) $_GET['id'];
			
			// get the gallery
			$gallery = $this->sygDao->getSygGalleryById($id);
			
			// cache gallery
			$gallery->cacheGallery();
			
			die();
		}
	}

	/**
	 * @name forwardToDeleteStyle
	 * @category admin forward
	 * @since 1.0.1
	 */
	public function forwardToDeleteStyle() {
		if (current_user_can('delete_pages')) {
			// get the gallery id
			$id = (int) $_GET['id'];
	
			// delete gallery
			$this->sygDao->deleteSygStyle($this->sygDao->getSygStyleById($id));
	
			die();
		}
	}

	/**
	 * @name forwardToSupport
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToSupport() {
		if (current_user_can('edit_posts')) {
			// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_ADMIN);
	
			// render admin/Support view
			return $this->render('admin/Support');
		}
	}

	/******************************/
	/* END ADMIN SECTION FORWARDS */
	/******************************/

	/********************/
	/* SECURITY METHODS */
	/********************/

	/**
	 * @name getOptions
	 * @category get plugin options
	 * @since 1.3.0
	 * @return array $options
	 */
	public function getOptions() {
		$options = array();
		
		/* load options scanning array of options */
		foreach (SygConstant::$SYG_PLUGIN_OPTIONS as $key => $value) {
			$options[$key] = get_option($key);
		}
		
		/*********************************
		 * additional javascript options *
		**********************************/
		$options['syg_option_plugin_url'] = WP_PLUGIN_URL;
		$options['syg_option_fancybox_url_suffix'] = $this->getFBUrlSuffix();
		
		return $options;
	}
	
	/**
	 * @name getFBUrlSuffix
	 * @category get youtube suffix options
	 * @since 1.5.0
	 * @return $suffix
	 */
	public function getFBUrlSuffix() {
		$suffix = '?';
		$suffix .= 'autohide='. get_option('syg_option_youtube_autohide');
		$suffix .= '&autoplay=' . get_option('syg_option_youtube_autoplay');
		$suffix .= '&cc_load_policy=' . get_option('syg_option_youtube_ccloadpolicy');
		$suffix .= '&controls=' . get_option('syg_option_youtube_controls');
		$suffix .= '&disablekb=' . get_option('syg_option_youtube_disablekb');
		$suffix .= '&iv_load_policy=' . get_option('syg_option_youtube_ivloadpolicy');
		$suffix .= '&modestbranding=' . get_option('syg_option_youtube_modestbranding');
		$suffix .= '&rel=' . get_option('syg_option_youtube_rel');
		$suffix .= '&showinfo=' . get_option('syg_option_youtube_showinfo');
		$suffix .= '&theme=' . get_option('syg_option_youtube_theme');
		return $suffix;
	}
	
	public function getJsOptions() {
		$this->data['syg_options'] = json_encode($this->getOptions());
		// render jsOption view
		return $this->render('client/jsOption');
	}

	/************************/
	/* END SECURITY METHODS */
	/************************/
}
?>