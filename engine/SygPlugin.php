<?php

/**
 * Sliding Youtube Gallery Plugin Controller
 * 
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2
 * 
 * @todo Inserire statistiche di attivazione, disattivazione, aggiornamento e nuova installazione
 * @todo Sistemare la visualizzazione e la action di youtube page gallery
 * @todo Preview
 * @todo Navigator
 * @todo YouTube api key option
 * @todo Aggiornare la documentazione
 * @todo Aggiungere opzione disabilita video correlati
 * @todo Background image
 * @todo widget wordpress + Implementare scroll verticale
 * @todo down scrolling
 * @todo Creare e separare una gestione degli stili
 * @todo Creare la pagina support con facebook + twitter + mail
 * @todo Creare la pagina contact con invio mail
 */

include_once 'Zend/Loader.php';
if (!class_exists('SanityPluginFramework')) require_once($plugin_path.'Sanity/sanity.php');

class SygPlugin extends SanityPluginFramework {

	private static $instance = null;
	
	/**
	 * Return current instance of the plugin
	 * @return self::$instance
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
	
	/**
	 * Plugin constructor
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
			// add shortcodes
			add_shortcode('syg_gallery', array($this, 'getGallery'));
			add_shortcode('syg_page', array($this, 'getVideoPage'));
		}
	}
	
	/**
	 * Set the plugin environment
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

	/**
	 * Activation plugin hook
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
		$gallery = $dao->getSygById($id);
		
		// set youtube profile object in the gallery
		$gallery->setUserProfile ($this->sygYouTube->getUserProfile($gallery->getYtUsername()));
		
		// return gallery in dto format
		return $gallery->toDto(true);	
	}
	
	/**
	 * Get gallery wordpress hook function
	 * @param $attributes 
	 * @return null
	 */
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
					if ($i == $gallery->getYtMaxVideoCount()) break;
				}
				
				// put the feed in the view
				$this->data['feed'] = $feed;
				
				// put the gallery settings in the view
				$this->data['gallery'] = $gallery;
				
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
				
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

	/**
	 * Get page wordpress hook function
	 * @param $attributes 
	 * @return null
	 */
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
	
	/**
	 * Sliding YouTube Gallery admin menu hook
	 * @param $attributes 
	 * @return null
	 */
	function SlidingYoutubeGalleryAdmin() {
		add_options_page('SlidingYoutubeGallery Options', 'YouTube Gallery', 'manage_options', 'syg-administration-panel', array($this, 'sygAdminHome'));
	}
	
	/**
	 * Plugin administration hook function
	 * @return null
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
			case 'edit': $this->forwardToEdit(); break;
			case 'add':	 $this->forwardToAdd();	break;
			case 'delete': $this->forwardToDelete(); break;
			case 'settings': $this->forwardToSettings(); break;
			case 'contact': $this->forwardToContact(); break;
			case 'support': $this->forwardToSupport(); break;
			case 'query': $this->forwardToPaginationService(); break;
			case null: $this->forwardToHome();	break;
			default: break;
		}
	}
	
	/**
	 * Prepare HTML Headers with css/js injection
	 * @return null
	 */
	private function prepareHeader(&$view, $context = SygConstant::SYG_CTX_FE) {
		switch ($context) {
			case SygConstant::SYG_CTX_BE:
				// define resources path
				$view['cssPath'] = $this->getCssRoot();
				$view['imgPath'] = $this->getImgRoot();
				$view['jsPath'] = $this->getJsRoot();
				
				// css to include
				$view['cssAdminUrl'] = $view['cssPath'] . 'admin.css';
				$view['cssColorPicker'] = $view['cssPath'] . 'colorpicker.css';
				
				// javascript dependencies injection
				wp_enqueue_script('jquery');
				
				// js to include
				wp_register_script('sliding-youtube-gallery-admin', $view['jsPath'] . 'admin.js', array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('sliding-youtube-gallery-admin');
				wp_register_script('sliding-youtube-gallery-colorpicker', $view['jsPath'] . 'colorpicker.js', array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('sliding-youtube-gallery-colorpicker');
				
				break;
			case SygConstant::SYG_CTX_FE:
				// define resources path
				$view['cssPath'] = $this->getCssRoot();
				$view['imgPath'] = $this->getImgRoot();
				$view['jsPath'] = $this->getJsRoot();
				
				// define plugin url
				$view['pluginUrl'] = $this->homeRoot . $this->getPluginRoot();
				
				// define plugin resources url in the view
				$gallery = $view['gallery'];
				$view['sygCssUrl_'.$gallery->getId()] = $view['cssPath'] . 'SlidingYoutubeGallery.css.php?id=' . $gallery->getId();
				$view['sygJsUrl_'.$gallery->getId()] = $view['jsPath'] . 'SlidingYoutubeGallery.js.php?id=' . $gallery->getId();
				
				// define presentation plugin resources
				$view['fancybox_js_url'] = $view['jsPath'] . '/fancybox/jquery.fancybox-1.3.4.pack.js';
				$view['easing_js_url'] = $view['jsPath'] . '/fancybox/jquery.easing-1.3.pack.js';
				$view['mousewheel_js_url'] = $view['jsPath'] . '/fancybox/jquery.mousewheel-3.0.4.pack.js';
				$view['fancybox_css_url'] = $view['jsPath'] . '/fancybox/jquery.fancybox-1.3.4.css';
				
				// css injection
				wp_register_style('sliding-youtube-gallery-'.$gallery->getId(), $view['sygCssUrl_'.$gallery->getId()], array(), SygConstant::SYG_VERSION, 'screen');
				wp_enqueue_style('sliding-youtube-gallery-'.$gallery->getId());
				wp_register_style('fancybox', $view['fancybox_css_url'], array(), SygConstant::SYG_VERSION, 'screen');
				wp_enqueue_style('fancybox');
				
				// javascript dependencies injection
				wp_enqueue_script('jquery');
				// javascript dependencies injection
				wp_register_script('sliding-youtube-gallery-'.$gallery->getId(), $view['sygJsUrl_'.$gallery->getId()], array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('sliding-youtube-gallery-'.$gallery->getId());
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
	
	/**
	 * Action Forward to setting page
	 * @return null
	 */
	private function forwardToSettings() {
		// prepare header 
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
		
		// render generalSettings view
		$this->render('generalSettings');
	}
	
	/**
	 * Action Forward to add gallery
	 * @return null
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
	
	/**
	 * Action Forward to edit gallery
	 * @return null
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
	
	/**
	 * Action Forward to edit gallery
	 * @return null
	 */
	private function forwardToDelete() {
		// get the gallery id
		$id = (int) $_GET['id'];
		
		// delete gallery
		$this->sygDao->deleteSyg($this->sygDao->getSygById($id));
		
		die();
	}
	
	/**
	 * Action Forward to contact page
	 * @return null
	 */
	private function forwardToContact() {
		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
	
		// render contact view
		$this->render('contact');
	}
	
	/**
	 * Action Forward to donation page
	 * @return null
	 */
	private function forwardToSupport() {
		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
	
		// render contact view
		$this->render('support');
	}
	
	/**
	 * Action Forward to homepage
	 * @return null
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
	
	/**
	 * Action Forward to pagination service
	 * @return null
	 */
	private function forwardToPaginationService() {
		// http://www.9lessons.info/2010/10/pagination-with-jquery-php-ajax-and.html
		
		if($_POST['page_number']) {
			$page_number = $_POST['page_number'];
			$current_page = $page_number;
			$page_number -= 1;
			
			$per_page = SygConstant::SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED; // Per page records
			
			$previous_btn = true;
			$next_btn = true;
			$first_btn = true;
			$last_btn = true;
			
			$start = $page_number * $per_page;
			
			$galleries = $this->sygDao->getAllSyg('', $start, $per_page);
			
			$msg = "";
			while ($row = mysql_fetch_array($result_pag_data))
			{
				$htmlmsg=htmlentities($row['message']); //HTML entries filter
				$msg .= "<li><b>" . $row['msg_id'] . "</b> " . $htmlmsg . "</li>";
			}
			$msg = "<div class='data'><ul>" . $msg . "</ul></div>"; // Content for Data
			
			/* -----Total count--- */
			
			$query_pag_num = "SELECT COUNT(*) AS count FROM messages"; // Total records
			$result_pag_num = mysql_query($query_pag_num);
			$row = mysql_fetch_array($result_pag_num);
			$count = $row['count'];
			$no_of_paginations = ceil($count / $per_page);
			/* -----Calculating the starting and endign values for the loop----- */
		}
	}
}
?>