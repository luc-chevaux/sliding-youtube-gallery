<?php

/**
 * @name Sliding Youtube Gallery Constant Class
 * @category Sliding Youtube Gallery Constant Object
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.4.4
 */

class SygConstant {
	/**
	 * Plugin configuration
	 */
	const SYG_VERSION = '1.4.0';
	const SYG_DEV_KEY = 'AI39si6mNwVCtzfMFh7__lYnzq6H180Fpd3fQwXdyykuPKCKDfxnmVG09D3L-xxv8X8XoyHEzXmMI0c9qACLik_6ocXRKcmQ7A';
	
	/**
	 * Plugin option inventory
	 */
	public static $SYG_PLUGIN_OPTIONS = array ('syg_option_description_length' 		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_DESCRIPTION_LENGTH, 'TYPE' => 'TEXT'), 
												  'syg_option_askcache' 				=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_ASKCACHE, 'TYPE' => 'CHECKBOX'), 
												  'syg_option_numrec' 					=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_NUM_REC, 'TYPE' => 'TEXT'), 
												  'syg_option_use_fb2' 					=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_USE_FB2, 'TYPE' => 'CHECKBOX'), 
												  'syg_option_use_fb2_url' 				=> array('DEFAULT' => '', 'TYPE' => 'TEXT'),
												  'syg_option_which_thumb' 				=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_WHICH_THUMB, 'TYPE' => 'RADIO'),
												  'syg_option_youtube_autohide'			=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_YOUTUBE_AUTOHIDE, 'TYPE' => 'SELECT'),
												  'syg_option_youtube_autoplay'			=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_YOUTUBE_AUTOPLAY, 'TYPE' => 'SELECT'),
												  'syg_option_youtube_ccloadpolicy'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_YOUTUBE_CCLOADPOLICY, 'TYPE' => 'SELECT'),
												  'syg_option_youtube_controls'			=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_YOUTUBE_CONTROLS, 'TYPE' => 'SELECT'),
												  'syg_option_youtube_disablekb'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_YOUTUBE_DISABLEKB, 'TYPE' => 'SELECT'),
												  'syg_option_youtube_ivloadpolicy'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_YOUTUBE_IVLOADPOLICY, 'TYPE' => 'SELECT'),
												  'syg_option_youtube_modestbranding'	=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_YOUTUBE_MODESTBRANDING, 'TYPE' => 'SELECT'),
												  'syg_option_youtube_rel'				=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_YOUTUBE_REL, 'TYPE' => 'SELECT'),
												  'syg_option_youtube_showinfo'			=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_YOUTUBE_SHOWINFO, 'TYPE' => 'SELECT'),
												  'syg_option_youtube_theme'			=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_YOUTUBE_THEME, 'TYPE' => 'SELECT'),
												  'syg_option_paginationarea'			=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_PAGINATION_AREA, 'TYPE' => 'SELECT'),
												  'syg_option_pagenumrec'				=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_PAGENUM_REC, 'TYPE' => 'TEXT'),
												  'syg_option_paginator_borderradius'	=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_PAGINATOR_BORDERRADIUS, 'TYPE' => 'TEXT'),
												  'syg_option_paginator_bordersize'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_PAGINATOR_BORDERSIZE, 'TYPE' => 'TEXT'),
												  'syg_option_paginator_shadowsize'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_PAGINATOR_SHADOWSIZE, 'TYPE' => 'TEXT'),
												  'syg_option_paginator_fontsize'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_PAGINATOR_FONTSIZE, 'TYPE' => 'TEXT'),
												  'syg_option_paginator_bordercolor'	=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_PAGINATOR_BORDERCOLOR, 'TYPE' => 'TEXT'),
												  'syg_option_paginator_bgcolor'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_PAGINATOR_BGCOLOR, 'TYPE' => 'TEXT'),
												  'syg_option_paginator_shadowcolor'	=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_PAGINATOR_SHADOWCOLOR, 'TYPE' => 'TEXT'),
												  'syg_option_paginator_fontcolor'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_PAGINATOR_FONTCOLOR, 'TYPE' => 'TEXT'),
												  'syg_option_carousel_autorotate'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_CAROUSEL_AUTOROTATE, 'TYPE' => 'SELECT'),
												  'syg_option_carousel_delay'			=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_CAROUSEL_DELAY, 'TYPE' => 'SELECT'),
												  'syg_option_carousel_fps'				=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_CAROUSEL_FPS, 'TYPE' => 'SELECT'),
												  'syg_option_carousel_speed'			=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_CAROUSEL_SPEED, 'TYPE' => 'TEXT'),
												  'syg_option_carousel_minscale'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_CAROUSEL_MINSCALE, 'TYPE' => 'SELECT'),
												  'syg_option_carousel_reflheight'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_CAROUSEL_REFLHEIGHT, 'TYPE' => 'TEXT'),
												  'syg_option_carousel_reflgap'			=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_CAROUSEL_REFLGAP, 'TYPE' => 'TEXT'),
												  'syg_option_carousel_reflopacity'		=> array('DEFAULT' => self::SYG_OPTION_DEFAULT_CAROUSEL_REFLOPACITY, 'TYPE' => 'TEXT')
												);
	
	/**
	 * Plugin running contexts
	 */
	const SYG_CTX_FE = 'SYG_CTX_FE';
	const SYG_CTX_BE = 'SYG_CTX_BE';
	const SYG_CTX_WS = 'SYG_CTX_WS';

	/**
	 * Plugin component type 
	 */
	const SYG_PLUGIN_COMPONENT_GALLERY = 'gallery';
	const SYG_PLUGIN_COMPONENT_PAGE = 'page';
	const SYG_PLUGIN_COMPONENT_CAROUSEL = 'carousel';
	const SYG_PLUGIN_COMPONENT_ELASTISLIDE = "elastislide";
	
	/**
	 * Front end methods running mode
	 */
	const SYG_PLUGIN_FE_CACHING_MODE = 'caching_mode';
	const SYG_PLUGIN_FE_NORMAL_MODE = 'normal_mode';	
	
	/**
	 * Plugin running action
	 */
	const BE_ACTION_MANAGE_GALLERIES = 'syg-manage-galleries';
	const BE_ACTION_MANAGE_STYLES = 'syg-manage-styles';
	const BE_ACTION_MANAGE_SETTINGS = 'syg-manage-settings';
	const BE_ACTION_CONTACTS = 'syg-contacts';

	/**
	 * Notification configuration
	 */
	const BE_ACTION_UNINSTALL = 'uninstall';
	const BE_ACTION_ACTIVATION = 'activation';
	const BE_ACTION_DEACTIVATION = 'deactivation';

	/**
	 * Static and general URI
	 */
	const WP_PLUGIN_PATH = '/sliding-youtube-gallery/';
	const WP_CSS_PATH = '/sliding-youtube-gallery/css/';
	const WP_JS_PATH = '/sliding-youtube-gallery/js/';
	const WP_IMG_PATH = '/sliding-youtube-gallery/img/';
	const WP_JQI_URL = '/sliding-youtube-gallery/engine/data/data.php';
	const WP_JQI_ADMIN_URL = '/sliding-youtube-gallery/engine/data/admin.php';
	const WP_CACHE_DIR = '/sliding-youtube-gallery/cache/';
	const WP_CACHE_THUMB_REL_DIR = '/cache/thumb/';
	const WP_CACHE_HTML_REL_DIR = '/cache/html/';
	const WP_CACHE_JSON_REL_DIR = '/cache/json/';
	const WP_CACHE_JS_REL_DIR = '/cache/js/';
	
	/**
	 * UI images url
	 */
	const BE_ICON_VIDEO_GALLERY = '/plugins/sliding-youtube-gallery/img/ui/admin/custom_gallery.png';

	/**
	 * Table name
	 */
	public static function getDatabasePrefix() {
		global $wpdb;
		return $wpdb->prefix;
	}
	
	public static function getTblGalleriesName() {
		return SygConstant::getDatabasePrefix().'syg';
	}
	
	public static function getTblStylesName () {
		return SygConstant::getDatabasePrefix().'syg_styles';
	}
	
	public static function getTblGalleriesName12X() {
		return self::getTblGalleriesName().'_OLD_V12X';
	}
	
	/**
	 * Sql query
	 */
	public static function sqlGetAllGalleries () { 
		$query = 'SELECT id, syg_youtube_src, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_youtube_disablerel, syg_youtube_cacheon, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_style_id, syg_gallery_type, syg_gallery_name, syg_gallery_details FROM '.self::getTblGalleriesName().' LIMIT %d, %d';
		return $query;
	}
	
	public static function sqlGetGalleryByStyleId () {
		$query = 'SELECT id, syg_youtube_src, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_youtube_disablerel, syg_youtube_cacheon, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_style_id, syg_gallery_type, syg_gallery_name, syg_gallery_details FROM '.self::getTblGalleriesName().' WHERE syg_style_id=%d';
		return $query;
	}
	
	public static function sqlGetCachedGalleryByStyleId () {
		$query = 'SELECT id, syg_youtube_src, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_youtube_disablerel, syg_youtube_cacheon, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_style_id, syg_gallery_type, syg_gallery_name, syg_gallery_details FROM '.self::getTblGalleriesName().' WHERE syg_style_id=%d AND syg_youtube_cacheon=%d';
		return $query;
	}
	
	public static function sqlGetAllCachedGallery () {
		$query = 'SELECT id, syg_youtube_src, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_youtube_disablerel, syg_youtube_cacheon, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_style_id, syg_gallery_type, syg_gallery_name, syg_gallery_details FROM '.self::getTblGalleriesName().' WHERE syg_youtube_cacheon = 1 AND id >= %d AND id <= %d';
		return $query;
	}
	
	// transitory query
	public static function sqlGetAllGalleries12X () {
		$query = 'SELECT id, syg_youtube_username, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM '.self::getTblGalleriesName12X().' LIMIT %d, %d';
		return $query;
	}
	
	public static function sqlGetAllStyles () {
		$query = 'SELECT id, syg_style_name, syg_style_details, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM '.self::getTblStylesName().' LIMIT %d, %d';
		return $query;
	}
	
	public static function sqlGetGalleryById () {
		$query = 'SELECT id, syg_youtube_src, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_youtube_disablerel, syg_youtube_cacheon, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_style_id, syg_gallery_type, syg_gallery_name, syg_gallery_details FROM '.self::getTblGalleriesName().' WHERE id=%d';
		return $query;
	}
	
	public static function sqlGetStyleById () {
		$query = 'SELECT id, syg_style_name, syg_style_details, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM '.self::getTblStylesName().' WHERE id=%d';
		return $query;
	}
	
	public static function sqlDeleteGalleryById () {
		$query = 'DELETE FROM '.self::getTblGalleriesName().' WHERE id = %d';
		return $query;
	}
	
	public static function sqlDeleteStyleById () {
		$query = 'DELETE FROM '.self::getTblStylesName().' WHERE id = %d';
		return $query;
	}
	
	public static function sqlCountQuery ($table) {
		$query = sprintf('SELECT COUNT(*) AS CNT FROM %s', $table);
		return $query;
	}
	
	public static function sqlCreateTable12X () {
		$query = 'CREATE TABLE IF NOT EXISTS '.self::getTblGalleriesName12X().' (
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
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
		return $query;
	}

	public static function sqlCreateTableStyles13X () {
		$query = 'CREATE TABLE IF NOT EXISTS '.self::getTblStylesName().' (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`syg_style_name` varchar(255) NOT NULL,
		`syg_style_details` text NOT NULL,
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
		`syg_box_width` int(11) NOT NULL,
		`syg_box_background` varchar(255) NOT NULL,
		`syg_box_radius` int(11) NOT NULL,
		`syg_box_padding` int(11) NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
		return $query;
	}
	
	public static function sqlCreateTableGalleries13X () { 
		$query = 'CREATE TABLE IF NOT EXISTS '.self::getTblGalleriesName().' (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`syg_youtube_src` text NOT NULL,
		`syg_youtube_videoformat` varchar(255) NOT NULL,
		`syg_youtube_maxvideocount` int(11) NOT NULL,
		`syg_youtube_disablerel` tinyint(1) NOT NULL,
		`syg_description_show` tinyint(1) NOT NULL,
		`syg_description_showduration` tinyint(1) NOT NULL,
		`syg_description_showtags` tinyint(1) NOT NULL,
		`syg_description_showratings` tinyint(1) NOT NULL,
		`syg_description_showcategories` tinyint(1) NOT NULL,
		`syg_style_id` int(11) NOT NULL,
		`syg_gallery_type` enum(\'feed\',\'list\',\'playlist\') NOT NULL,
		`syg_gallery_name` varchar(255) NOT NULL,
		`syg_gallery_details` text NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=%d;';
		return $query;
	}
	
	public static function sqlAlterSygCache14X () {
		$query = 'ALTER TABLE '.self::getTblGalleriesName().' ADD `syg_youtube_cacheon` BOOLEAN NOT NULL AFTER `syg_youtube_disablerel`;';
		return $query;
	}
	
	public static function sqlCopyTable ($tarTable, $srcTable) {
		$query = sprintf('CREATE TABLE %s LIKE %s', $tarTable, $srcTable);
		return $query;
	}
	
	public static function sqlCopyData ($tarTable, $srcTable) {
		$query = sprintf ('INSERT INTO %s SELECT * FROM %s', $tarTable, $srcTable);
		return $query;
	}
	
	public static function sqlCheckTableExist ($db, $table) {
		$query = sprintf ('SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = \'%s\' AND table_name = \'%s\'', $db, $table);
		return $query;
	}
	
	public static function sqlCheckAutoIncrement ($db, $table) {
		$query = sprintf ('SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_schema = \'%s\' AND table_name = \'%s\'', $db, $table);
		return $query;
	}
	
	public static function sqlRemoveTable ($table) {
		$query = 'DROP TABLE '.$table;
		return $query;
	}
	
	public static function sqlSetAutoIncrement ($table) {
		$query = 'ALTER TABLE '.$table.' AUTO_INCREMENT = %d';
		return $query;
	}
	
	/**
	 * Default values for gallery
	 */

	/**
	 * Default values for styles
	 */
	const SYG_DESC_DEFAULT_FONT_COLOR = "#ffffff";
	const SYG_THUMB_DEFAULT_BORDER_COLOR = "#efefef";
	const SYG_BOX_DEFAULT_BACKGROUND_COLOR = "#cccccc";
	const SYG_THUMB_DEFAULT_WIDTH = 200;
	const SYG_THUMB_DEFAULT_HEIGHT = 150;
	const SYG_THUMB_DEFAULT_IMAGE = 1;
	
	/**
	 * Default styles for paginator
	 */
	const SYG_OPTION_DEFAULT_PAGINATOR_BORDERRADIUS = '5';
	const SYG_OPTION_DEFAULT_PAGINATOR_BORDERSIZE = '2';
	const SYG_OPTION_DEFAULT_PAGINATOR_BORDERCOLOR = '#CCCCCC';
	const SYG_OPTION_DEFAULT_PAGINATOR_BGCOLOR = '#3B393B';
	const SYG_OPTION_DEFAULT_PAGINATOR_SHADOWCOLOR = '#000000';
	const SYG_OPTION_DEFAULT_PAGINATOR_SHADOWSIZE = '5';
	const SYG_OPTION_DEFAULT_PAGINATOR_FONTCOLOR = '#FFFFFF';
	const SYG_OPTION_DEFAULT_PAGINATOR_FONTSIZE = '11';
	
	/**
	 * Plugin Default options
	 */
	const SYG_OPTION_DEFAULT_WHICH_THUMB = '2';
	const SYG_OPTION_DEFAULT_NUM_REC = '5';
	const SYG_OPTION_DEFAULT_USE_FB2 = '0';
	const SYG_OPTION_DEFAULT_PAGENUM_REC = '5';
	const SYG_OPTION_DEFAULT_PAGINATION_AREA = 'both';	
	const SYG_OPTION_DEFAULT_DESCRIPTION_LENGTH = 200;
	const SYG_OPTION_DEFAULT_ASKCACHE = 1;
	
	/**
	 * YouTube default options
	 */
	const SYG_OPTION_YT_QUERY_RESULTS = 50;
	
	/**
	 * 3d Carousel default option
	 */
	const SYG_OPTION_DEFAULT_CAROUSEL_AUTOROTATE = 'no';
	const SYG_OPTION_DEFAULT_CAROUSEL_DELAY = 1500;
	const SYG_OPTION_DEFAULT_CAROUSEL_FPS = 30;
	const SYG_OPTION_DEFAULT_CAROUSEL_SPEED = 0.2;
	const SYG_OPTION_DEFAULT_CAROUSEL_MINSCALE = 0.5;
	const SYG_OPTION_DEFAULT_CAROUSEL_REFLHEIGHT = 0;
	const SYG_OPTION_DEFAULT_CAROUSEL_REFLGAP = 0;
	const SYG_OPTION_DEFAULT_CAROUSEL_REFLOPACITY = 0.5;
	
	/**
	 * YouTube Settings
	 */
	const SYG_OPTION_DEFAULT_YOUTUBE_AUTOHIDE = 2;
	const SYG_OPTION_DEFAULT_YOUTUBE_AUTOPLAY = 0;
	const SYG_OPTION_DEFAULT_YOUTUBE_CCLOADPOLICY = 0;
	const SYG_OPTION_DEFAULT_YOUTUBE_CONTROLS = 1;
	const SYG_OPTION_DEFAULT_YOUTUBE_DISABLEKB = 0;
	const SYG_OPTION_DEFAULT_YOUTUBE_IVLOADPOLICY = 1;
	const SYG_OPTION_DEFAULT_YOUTUBE_MODESTBRANDING = 0;
	const SYG_OPTION_DEFAULT_YOUTUBE_REL = 1;
	const SYG_OPTION_DEFAULT_YOUTUBE_SHOWINFO = 1;
	const SYG_OPTION_DEFAULT_YOUTUBE_THEME = 'dark';
	
	/**
	 * GUI constants
	 */
	// user message
	const BE_NO_GALLERY_FOUND_ADM_WRN = 'Hey! There\'s no youtube gallery in your blog. Why don\'t you create one <a href="?page=syg-manage-galleries">here?</a><br/>';
	const BE_NO_STYLES_FOUND_ADM_WRN = 'Before you create a new gallery, you must create your first theme. Create <a href="?page=syg-manage-styles&action=add">here!</a><br/>';
	const BE_FS_NOT_WRITEABLE = 'Your caching directory is not writeable. Deactivating then activating the plugin should fix the problem.<br/>If the problem persists, try to manually chmod 755 /cache directory and the other folders inside.';
	const BE_WRONG_SETTINGS_ADM_WRN = 'Something is going wrong with your current settings. <a href="?page=syg-manage-settings">Go to settings.</a><br/>';
	const BE_SUPPORT_PAGE = '<a href="http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/">Support page</a>';
	const BE_DONATION_CODE = '<a href="http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/">Donation</a>';
	const BE_NO_GALLERY_FOUND = 'No gallery found in database';
	const BE_NO_STYLES_FOUND = 'No styles found in database';
	const BE_WELCOME_MESSAGE = 'Sliding YouTube Gallery is a nice plugin, that gives you a fast way, to add video galleries in your blog directly from a youtube user\'s channel!';
	const BE_MANAGE_STYLE_MESSAGE = 'Height, width, border radius, border size, distance, padding and font size are treated as generic integer. You don\'t need to add px, em or other css suffix.<br/> Button opacity is a float between 0 and 1 (e.g. 0.5).';
	
	// helpers
	const BE_CACHE_HELP = '<h3>Using cache</h3><p>Caching gallery content is useful to speed up the loading process, especially when you\'re displaying a gallery which has a great number of videos or as a part of a multiple gallery page.</p><p>Once a gallery is cached, if its source will be changed externally, you have to force re-caching manually, by clicking on the lightening icon in the galleries list.</p><p><strong>Clicking this option will start the cache process immediately after saving.</strong></p>';
	const BE_REBUILD_CACHE_HELP = '<h3>Rebuild Cache</h3><p>If you have updated your youtube sources externally or you have just updated the plugin, this feature let you rebuild all the cached gallery content locally. All the downloaded content could be finded in your cache folder under the plugin directory root.</p><p><strong>For a successful use of this feature, your wp-cron has to work correctly.</strong></p><p>The scheduled tasks will have a timing gap (180 seconds between each task) to avoid youtube blocking your request with the response {too_much_request}, then it\'s better to execute this when you start a work session to ensure that the tasks will be completed.</p><p>In order to avoid a big loading of your server, use this only when you have to regenerate a considerable number of galleries, else it\'s preferable to run caching in single gallery mode by clicking on the lightening icon.';
	const BE_AUTOHIDE_HELP = 'This parameter indicates whether the video controls will automatically hide after a video begins playing. The default behavior (<code>autohide=2</code>) is for the video progress bar to fade out while the player controls (play button, volume control, etc.) remain visible.<ul><li>If this parameter is set to <code>1</code>, then the video progress bar and the player controls will slide out of view a couple of seconds after the video starts playing. They will only reappear if the user moves her mouse over the video player or presses a key on her keyboard.</li> <li>If this parameter is set to <code>0</code>, the video progress bar and the video player controls will be visible throughout the video and in fullscreen.</li></ul>';
	const BE_AUTOPLAY_HELP = 'Sets whether or not the initial video will autoplay when the player loads.';
	const BE_CCPOLICY_HELP = 'Default is based on user preference. Setting to <code>1</code> will cause closed captions to be shown by default, even if the user has turned captions off.';
	const BE_CONTROLS_HELP = 'This parameter indicates whether the video player controls will display. For AS3 players, it also defines when the Flash player will load:</p><ul><li><code>controls=0</code> – Player controls do not display in the player. For AS3 players, the Flash player loads immediately.</li><li><code>controls=1</code> – Player controls display in the player. For AS3 players, the Flash player loads immediately.</li><li><code>controls=2</code> – Player controls display in the player. For AS3 players, the Flash player loads afer the user initiates the video playback.</li></ul><p><strong>Note:</strong> The parameter values <code>1</code> and <code>2</code> are intended to provide an identical user experience, but <code>controls=2</code> provides a performance improvement over <code>controls=1</code>.</p>';
	const BE_DISABLEKB_HELP = 'Setting to <code>1</code> will disable the player keyboard controls. Keyboard controls are as follows:<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Spacebar: Play / Pause<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Arrow Left: Jump back 10% in the current video<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Arrow Right: Jump ahead 10% in the current video<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Arrow Up: Volume up<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Arrow Down: Volume Down';
	const BE_IVLOADPOLICY_HELP = 'Values: <code>1</code> or <code>3</code>. Default is <code>1</code>. Setting to <code>1</code> will cause video annotations to be shown by default, whereas setting to <code>3</code> will cause video annotation to not be shown by default.';
	const BE_MODESTBRANDING_HELP = 'This parameter lets you use a YouTube player that does not show a YouTube logo. Set the parameter value to <code>1</code> to prevent the YouTube logo from displaying in the control bar. Note that a small <code>YouTube</code> text label will still display in the upper-right corner of a paused video when the user\'s mouse pointer hovers over the player.<br><br>';
	const BE_REL_HELP = 'This parameter indicates whether the player should show related videos when playback of the initial video ends.';
	const BE_SHOWINFO_HELP = 'The parameter\'s default value is <code>1</code>. If you set the parameter value to <code>0</code>, then the player will not display information like the video title and uploader before the video starts playing.<br><br>If the player is loading a playlist, and you explicitly set the parameter value to <code>1</code>, then, upon loading, the player will also display thumbnail images for the videos in the playlist. Note that this functionality is only supported for the AS3 player since that is the only player that can load a playlist.';
	const BE_THEME_HELP = 'This parameter indicates whether the embedded player will display player controls (like a \'play\' button or volume control) within a dark or light control bar. Valid parameter values are <code>dark</code> and <code>light</code>, and, by default, the player will display player controls using the <code>dark</code> theme.';
	
	// general menu
	const BE_MENU_HOME = 'Home';
	const BE_MENU_MANAGE_GALLERIES = 'Galleries';
	const BE_MENU_MANAGE_STYLES = 'Themes';
	const BE_MENU_MANAGE_SETTINGS = 'Options';
	const BE_MENU_CONTACTS_AND_SUPPORT = 'Support';

	// context menu
	const BE_MENU_ADD_NEW_STYLE = 'Add new Theme';
	const BE_MENU_ADD_NEW_GALLERY = 'Add new Gallery';
	const BE_MENU_JUMP_TO_HOME = 'Jump to Home';
	const BE_MENU_REBUILD_CACHE = 'Rebuild cache';

	// page title
	const BE_TITLE_EDIT_GALLERY = 'Gallery editor';
	const BE_TITLE_EDIT_STYLE = 'Theme editor';
	const BE_TITLE_EDIT_SETTINGS = 'Options';
	
	/**
	 * Exceptions
	 */
	const MSG_EX_STYLE_NOT_VALID = 'An error was found while updating your style.';
	const COD_EX_STYLE_NOT_VALID = '1001';
	
	const MSG_EX_GALLERY_NOT_VALID = 'An error was found while updating your gallery.';
	const COD_EX_GALLERY_NOT_VALID = '1002';
	
	const MSG_EX_SETTING_NOT_VALID = 'An error was found while updating plugin settings.';
	const COD_EX_SETTING_NOT_VALID = '1003';
	
	const MSG_EX_GALLERY_NOT_FOUND = 'Opss... Gallery not found, please check your ID!';
	const COD_EX_GALLERY_NOT_FOUND = '1004';
	
	const MSG_EX_GALLERY_NOT_CACHED = 'To enable 3d cloud carousel for this gallery, you must cache the content of this gallery. Please login in the admin area and check the cache content option.';
	const COD_EX_GALLERY_NOT_CACHED = '1005';
	/**
	 * Validation message
	 */
	const BE_VALIDATE_USER_NOT_FOUND = 'There was an error in your request. YouTube user does not exist.';
	const BE_VALIDATE_STRING_NOT_EMPTY = 'Must be a not empty string.';
	const BE_VALIDATE_NOT_A_INTEGER = '%s is not an integer value.';
	const BE_VALIDATE_NOT_LESS_VALUE = 'You entered %d. Its value must be less or equal than %d.';
	const BE_VALIDATE_NOT_MAJOR_VALUE = 'You entered %d. Its value must be major or equal than %d.';
	const BE_VALIDATE_LESS_VALUE = 'Can\'t be less than %d.';
	const BE_VALIDATE_NOT_A_VALID_URL = 'Url that you\'ve entered is not correct.';
	const BE_VALIDATE_FANCYBOX2_NOT_FOUND = 'Fancybox2 not found in path %s. Please check if the url provided has fancybox2 inside.';
	const BE_VALIDATE_NOT_A_FLOAT = '%s is not a float value.';
	const BE_VALIDATE_NOT_IN_RANGE = '%s is not between %s and %s.';
	const BE_VALIDATE_NOT_A_VALID_YT_USER = '%s is not a valid youtube user.';
	const BE_VALIDATE_NOT_A_VALID_YT_URL = '%s is not a valid youtube url.';
	const BE_VALIDATE_NOT_A_VALID_VIDEO = '%s is not a valid youtube video.';
	const BE_VALIDATE_NOT_A_VALID_VIDEO_EXT = '%s is not a valid youtube video. Exception %s was raised.';
	const BE_VALIDATE_NOT_A_VALID_PLAYLIST = '%s youtube playlist does not exist.';
	const BE_VALIDATE_NOT_A_VALID_PLAYLIST_URL = '%s is not a valid playlist url.';
	const BE_VALIDATE_OVERLAY_BAD_DIMENSION = 'Size %d for overlay button is not proportional to %s value that is %d. Please consider to use a lower value.';
	
	/**
	 * Forms label
	 */
	const syg_thumbnail_height = 'Height';
	const syg_thumbnail_width = 'Width';
	const syg_thumbnail_bordersize = 'Border size';
	const syg_thumbnail_borderradius = 'Border radius';
	const syg_thumbnail_distance = 'Distance';
	const syg_thumbnail_buttonopacity = 'Button opacity';
	const syg_thumbnail_overlaysize = 'Button size';
	
	const syg_box_width = 'Box width';
	const syg_box_radius = 'Box radius';
	const syg_box_padding = 'Box padding';
	
	const syg_description_fontsize = 'Font size';
	const syg_style_name = 'Name';
	
	const syg_youtube_maxvideocount = 'Maximum Video Count';
	const syg_youtube_src = '';
	const syg_youtube_src_feed = 'YouTube user';
	const syg_youtube_src_list = 'Video list';
	const syg_youtube_src_playlist = 'YouTube playlist';
	
	const syg_option_numrec = 'Number of records displayed';
	const syg_option_pagenumrec = 'Number of records in page';
	const syg_option_use_fb2_url = 'Fancybox2 inclusion url';
	const syg_option_paginator_borderradius = 'Border Radius';
	const syg_option_paginator_bordersize = 'Border Size';
	const syg_option_paginator_shadowsize = 'Shadow Size';
	const syg_option_paginator_fontsize = 'Font Size';
	
	const syg_option_carousel_autorotate = 'Auto rotate';
	const syg_option_carousel_delay = 'Auto rotate delay';
	const syg_option_carousel_fps = 'Frame per seconds';
	const syg_option_carousel_speed = 'Carousel speed';
	const syg_option_carousel_minscale = 'Min scale';
	const syg_option_carousel_reflheight = 'Reflection height';
	const syg_option_carousel_reflgap = 'Reflection gap';
	const syg_option_carousel_reflopacity = 'Reflection opacity';
	
}
?>