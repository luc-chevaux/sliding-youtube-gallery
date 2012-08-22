<?php

/**
 * Sliding Youtube Gallery Constant Class
 *
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.5
 */

class SygConstant {
	/**
	 * Plugin configuration
	 */
	const SYG_VERSION = '1.3.0';
	const SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED = 4;

	/**
	 * Plugin running contexts
	 */
	const SYG_CTX_FE = "SYG_CTX_FE";
	const SYG_CTX_BE = "SYG_CTX_BE";
	const SYG_CTX_WS = "SYG_CTX_WS";

	/**
	 * Plugin component type 
	 */
	const SYG_PLUGIN_COMPONENT_GALLERY = 'gallery';
	const SYG_PLUGIN_COMPONENT_PAGE = 'page';
	/**
	 * Plugin running action
	 */
	const BE_ACTION_MANAGE_GALLERIES = 'syg-manage-galleries';
	const BE_ACTION_MANAGE_STYLES = 'syg-manage-styles';
	const BE_ACTION_MANAGE_SETTINGS = 'syg-manage-settings';
	const BE_ACTION_CONTACTS = 'syg-contacts';

	/**
	 * Notification details
	 */
	const BE_ACTION_UNINSTALL = 'uninstall';
	const BE_ACTION_ACTIVATION = 'activation';
	const BE_ACTION_DEACTIVATION = 'deactivation';
	const BE_EMAIL_NOTIFIED = 'subscription@webeng.it';

	/**
	 * Static and general URI
	 */
	const WP_PLUGIN_PATH = '/sliding-youtube-gallery/';
	const WP_CSS_PATH = '/sliding-youtube-gallery/css/';
	const WP_JS_PATH = '/sliding-youtube-gallery/js/';
	const WP_IMG_PATH = '/sliding-youtube-gallery/img/';
	const WP_JQI_URL = '/sliding-youtube-gallery/engine/data/data.php';

	/**
	 * User interface images url
	 */

	const BE_ICON_VIDEO_GALLERY = '../wp-content/plugins/sliding-youtube-gallery/img/ui/admin/custom_gallery.png';

	/**
	 * Sql query
	 */
	const SQL_GET_ALL_GALLERIES = 'SELECT id, syg_youtube_src, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_youtube_disablerel, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_style_id, syg_gallery_type, syg_gallery_name, syg_gallery_details FROM %s LIMIT %d, %d';
	
	// transitory variable
	const SQL_GET_ALL_GALLERIES_1_2_X = 'SELECT id, syg_youtube_username, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM %s LIMIT %d, %d';
	
	const SQL_GET_ALL_STYLES = 'SELECT id, syg_style_name, syg_style_details, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM %s LIMIT %d, %d';
	const SQL_GET_GALLERY_BY_ID = 'SELECT id, syg_youtube_src, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_youtube_disablerel, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_style_id, syg_gallery_type, syg_gallery_name, syg_gallery_details FROM %s WHERE id=%d';
	const SQL_GET_STYLE_BY_ID = 'SELECT id, syg_style_name, syg_style_details, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM %s WHERE id=%d';
	const SQL_DELETE_GALLERY_BY_ID = 'DELETE FROM %s WHERE id = %d';
	const SQL_DELETE_STYLE_BY_ID = 'DELETE FROM %s WHERE id = %d';
	const SQL_COUNT_QUERY = 'SELECT COUNT(*) AS CNT FROM %s';
	const SQL_CREATE_TABLE_1_2_X = 'CREATE TABLE IF NOT EXISTS %s (
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

	const SQL_CREATE_TABLE_STYLES_1_3_X = 'CREATE TABLE IF NOT EXISTS %s (
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
	
	const SQL_CREATE_TABLE_GALLERIES_1_3_X = 'CREATE TABLE IF NOT EXISTS %s (
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
	
	const SQL_COPY_TABLE = 'CREATE TABLE %s LIKE %s';
	const SQL_COPY_DATA = 'INSERT INTO %s SELECT * FROM %s';
	const SQL_CHECK_TABLE_EXIST = 'SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = %s AND table_name = %s';
	const SQL_CHECK_AUTO_INCREMENT = 'SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_schema = %s AND table_name = %s';
	const SQL_REMOVE_TABLE = 'DROP TABLE %s';
	const SQL_SET_AUTOINCREMENT = 'ALTER TABLE %s AUTO_INCREMENT = %d';
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
	 * GUI constants
	 */

	// user message
	const BE_SUPPORT_PAGE = '<a href="http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/">Support page</a>';
	const BE_DONATION_CODE = '<a href="http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/">Donation</a>';
	const BE_NO_GALLERY_FOUND = 'No gallery found in database';
	const BE_NO_STYLES_FOUND = 'No styles found in database';

	// @todo da rivedere
	const BE_WELCOME_MESSAGE = 'Sliding YouTube Gallery is a nice plugin, that gives you a fast way, to add video galleries in your blog directly from a youtube user\'s channel!';
	const BE_MANAGE_GALLERY_MESSAGE = 'Height, width, border radius, border size, distance, padding and font size are treated as generic integer. You don\'t need to add px, em or other css suffix.<br/> Button opacity is a float between 0 and 1 (e.g. 0.5).';
	const BE_CONTACT_MESSAGE = 'Il lorem ipsum è un insieme di parole utilizzato da grafici, designer, programmatori e tipografi come testo riempitivo in bozzetti e prove grafiche[1]. È un testo privo di senso, composto da parole in lingua latina (spesso storpiate), riprese pseudocasualmente da uno scritto di Cicerone del 45 a.C.';
	const BE_DONATE_MESSAGE = 'Sliding YouTube Gallery is a nice plugin, that gives you a fast way, to add video galleries in your blog directly from a youtube user\'s channel!';

	// general menu
	const BE_MENU_HOME = 'Home';
	const BE_MENU_MANAGE_GALLERIES = 'Manage Galleries';
	const BE_MENU_MANAGE_STYLES = 'Manage Styles';
	const BE_MENU_MANAGE_SETTINGS = 'General Settings';
	const BE_MENU_CONTACTS_AND_SUPPORT = 'Contact & Support';

	// context menu
	const BE_MENU_ADD_NEW_STYLE = 'Add new Style';
	const BE_MENU_ADD_NEW_GALLERY = 'Add new Gallery';
	const BE_MENU_JUMP_TO_HOME = 'Jump to Home';

	/**
	 * Exceptions
	 */

	const MSG_EX_STYLE_NOT_VALID = 'An error was found while updating your style.';
	const COD_EX_STYLE_NOT_VALID = '1001';
	const MSG_EX_GALLERY_NOT_VALID = 'An error was found while updating your gallery.';
	const COD_EX_GALLERY_NOT_VALID = '1002';
	const MSG_EX_SETTING_NOT_VALID = 'An error was found while updating plugin settings.';
	const COD_EX_SETTING_NOT_VALID = '1003';

	const BE_VALIDATE_USER_NOT_FOUND = 'There was an error in your request. YouTube user does not exist.';
	const BE_VALIDATE_NOT_A_INTEGER = '%s is not an integer value';
	const BE_VALIDATE_NOT_LESS_VALUE = 'value is not less than %d';
	const BE_VALIDATE_NOT_A_FLOAT = '%s is not a float value';
	const BE_VALIDATE_NOT_IN_RANGE = '%s is not between %s and %s';
	const BE_VALIDATE_NOT_A_VALID_YT_USER = '%s is not a valid youtube user';
	const BE_VALIDATE_NOT_A_VALID_VIDEO = '%s is not a valid youtube video';
	const BE_VALIDATE_NOT_A_VALID_PLAYLIST = '%s is not a valid youtube playlist';
}
?>