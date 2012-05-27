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
	
}
?>