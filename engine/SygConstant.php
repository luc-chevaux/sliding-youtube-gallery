<?php
class SygConstant {
	const SYG_VERSION = '1.2.0';

	// define administration menu constant
	const BE_WELCOME_MESSAGE = 'Il lorem ipsum è un insieme di parole utilizzato da grafici, designer, programmatori e tipografi come testo riempitivo in bozzetti e prove grafiche[1]. È un testo privo di senso, composto da parole in lingua latina (spesso storpiate), riprese pseudocasualmente da uno scritto di Cicerone del 45 a.C.';
	const BE_SUPPORT_PAGE = '<a href="http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/">Support page</a>';
	const BE_DONATION_CODE = '<a href="http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/">Donation</a>';

	// strings message
	const BE_NO_GALLERY_FOUND = 'No gallery found in database';
	
	// methods
	const SYG_METHOD_GALLERY = 'gallery';
	const SYG_METHOD_PAGE = 'page';

	// paths 
	const WP_PLUGIN_PATH = '/wp-content/plugins/sliding-youtube-gallery/';
	const WP_CSS_PATH = '/wp-content/plugins/sliding-youtube-gallery/css/';
	const WP_JS_PATH = '/wp-content/plugins/sliding-youtube-gallery/js/';
	const WP_IMG_PATH = '/wp-content/plugins/sliding-youtube-gallery/img/';
	
	// contexts
	const SYG_CTX_FE = "SYG_CTX_FE";
	const SYG_CTX_BE = "SYG_CTX_BE";
	const SYG_CTX_WS = "SYG_CTX_WS";
	
	// default values for constructors
	const SYG_DESC_DEFAULT_FONT_COLOR = "#ffffff";
	const SYG_THUMB_DEFAULT_BORDER_COLOR = "#efefef";
	const SYG_BOX_DEFAULT_BACKGROUND_COLOR = "#cccccc";
	const SYG_THUMB_DEFAULT_WIDTH = 420;
	const SYG_THUMB_DEFAULT_HEIGHT = 315;
	
	// query, string must be escaped with sprintf and must contain single quotes for strict string parameter
	const SQL_GET_ALL_GALLERIES = 'SELECT id, syg_youtube_username, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM %s';
	const SQL_GET_GALLERY_BY_ID = 'SELECT id, syg_youtube_username, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM %s WHERE id=%d';
	const SQL_DELETE_GALLERY_BY_ID = 'DELETE FROM %s WHERE id = %d';
}
?>