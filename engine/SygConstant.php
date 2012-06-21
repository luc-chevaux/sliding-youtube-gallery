<?php

/**
 * Sliding Youtube Gallery Constant Class
 *
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.1
 */

class SygConstant {
	const SYG_VERSION = '1.2.0';

	/**
	 * Plugin configuration
	 */
	const SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED = 5;
	
	/**
	 * Validation
	 */
	const BE_VALIDATE_USER_NOT_FOUND = 'There was an error in your request. YouTube user does not exist.';

	/**
	 * Notification
	 */
	const BE_ACTION_UNINSTALL = 'uninstall';
	const BE_ACTION_ACTIVATION = 'activation';
	const BE_ACTION_DEACTIVATION = 'deactivation';
	const BE_EMAIL_NOTIFIED = 'subscription@webeng.it';
	
	/**
	 * Static and general URI
	 */
	const WP_PLUGIN_PATH = '/wp-content/plugins/sliding-youtube-gallery/';
	const WP_CSS_PATH = '/sliding-youtube-gallery/css/';
	const WP_JS_PATH = '/sliding-youtube-gallery/js/';
	const WP_IMG_PATH = '/sliding-youtube-gallery/img/';

	/**
	 * Plugin running contexts
	 */
	const SYG_CTX_FE = "SYG_CTX_FE";
	const SYG_CTX_BE = "SYG_CTX_BE";
	const SYG_CTX_WS = "SYG_CTX_WS";

	/**
	 * Sql query
	 */
	const SQL_GET_ALL_GALLERIES = 'SELECT id, syg_youtube_username, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM %s LIMIT %d, %d';
	const SQL_GET_GALLERY_BY_ID = 'SELECT id, syg_youtube_username, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM %s WHERE id=%d';
	const SQL_DELETE_GALLERY_BY_ID = 'DELETE FROM %s WHERE id = %d';
	const SQL_COUNT_GALLERY = 'SELECT COUNT(*) AS CNT FROM %s';

	/**
	 * Default values for a gallery
	 */
	const SYG_DESC_DEFAULT_FONT_COLOR = "#ffffff";
	const SYG_THUMB_DEFAULT_BORDER_COLOR = "#efefef";
	const SYG_BOX_DEFAULT_BACKGROUND_COLOR = "#cccccc";
	const SYG_THUMB_DEFAULT_WIDTH = 200;
	const SYG_THUMB_DEFAULT_HEIGHT = 150;

	/**
	 * GUI constants
	 */
	const BE_WELCOME_MESSAGE = 'Sliding YouTube Gallery is a nice plugin, that gives you a fast way, to add video galleries in your blog directly from a youtube user\'s channel!';
	const BE_MANAGE_GALLERY_MESSAGE = 'Height, width, border radius, border size, distance, padding and font size are treated as generic integer. You don\'t need to add px, em or other css suffix.<br/> Button opacity is a float between 0 and 1 (e.g. 0.5).';
	const BE_CONTACT_MESSAGE = 'Il lorem ipsum è un insieme di parole utilizzato da grafici, designer, programmatori e tipografi come testo riempitivo in bozzetti e prove grafiche[1]. È un testo privo di senso, composto da parole in lingua latina (spesso storpiate), riprese pseudocasualmente da uno scritto di Cicerone del 45 a.C.';
	const BE_DONATE_MESSAGE = 'Sliding YouTube Gallery is a nice plugin, that gives you a fast way, to add video galleries in your blog directly from a youtube user\'s channel!';
	const BE_SUPPORT_PAGE = '<a href="http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/">Support page</a>';
	const BE_DONATION_CODE = '<a href="http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/">Donation</a>';
	const BE_NO_GALLERY_FOUND = 'No gallery found in database';
	const BE_MENU_ADD_NEW_GALLERY = 'Add new Gallery';
	const BE_MENU_CONTACT = 'Contact';
	const BE_MENU_SETTINGS = 'Settings';
	const BE_MENU_SUPPORT_THE_PLUGIN = 'Support Plugin Development';
	const BE_MENU_HOME = 'Galleries';
}
?>