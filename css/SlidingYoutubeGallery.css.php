<?php

// set header type
header('Content-type: text/css');

// include wp loader
$root = realpath(dirname(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"]))))));

if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
} else {
	// Before 2.6
	require_once($root.'/wp-config.php');
}

// include required wordpress object
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygPlugin.php');

$syg = SygPlugin::getInstance();
$id = $_GET['id'];
$option = $syg->getGallerySettings($id);
extract ($option);
?>

/* general styles */

img.thumbnail-image-<?php echo $id; ?> {
	width: <?php echo $syg_thumbnail_width; ?>px;
	heigth: <?php echo $syg_thumbnail_height; ?>px;
	border: <?php echo $syg_thumbnail_bordersize; ?>px <?php echo $syg_thumbnail_bordercolor; ?> solid;	
    border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
    -webkit-border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
    -moz-border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
    max-width: 100%;
    display: block;
}

img.play-icon-<?php echo $id; ?>{
	border: 0;
	display: block;
	visibility:visible;
	position:absolute;
	left:<?php echo $syg_thumbnail_left; ?>%;
	top:<?php echo $syg_thumbnail_top; ?>%;
	width: <?php echo $syg_thumbnail_overlaysize; ?>px;
	height: <?php echo $syg_thumbnail_overlaysize; ?>px;
}

a.sygVideo {
	display: block;
	position:relative;
	text-decoration: none;
}

span.video_duration-<?php echo $id; ?> {
	border: 0;
	display: block;
	visibility:visible;
	position:absolute;
	right: 6%;
	bottom: 8%;
	line-height: 1;
	margin: 0;
	width: auto;
	padding: 3px;
	color: white;
	background-color: #000;
}

/* video-page styles */

h4.video_title-<?php echo $id; ?> {
	color: <?php echo $syg_description_fontcolor; ?>;
	font-size: 115%;
	font-weight: bold;
	width: 100%;
	border-bottom: <?php echo $syg_thumbnail_bordersize; ?>px <?php echo $syg_thumbnail_bordercolor; ?> solid;
}

h4.video_title-<?php echo $id; ?> a {
	color: inherit;
	text-decoration: none;
}

.syg_video_page_container-<?php echo $id; ?> .video_entry_table-<?php echo $id; ?> {
	width: 100%;
	border-width: 0px 0px 0px 0px;
	margin: 0;
	padding: 0;
}

.video_entry_table-<?php echo $id; ?> td p {
	margin: 0px 0px 3%;
	font-size: 95%;
}

.video_entry_table-<?php echo $id; ?> td span.video_tags {
	font-size: 80%;
	display: block;
}

.video_entry_table-<?php echo $id; ?> td span.video_ratings {
	font-size: 80%;
	display: block;
}

.video_entry_table-<?php echo $id; ?> td span.video_categories {
	font-size: 80%;
	display: block;
}

.syg_video_page_container-<?php echo $id; ?> .video_entry_table-<?php echo $id; ?> td{
	border-width: 0px 0px 0px 0px;
	vertical-align: top;
}

.syg_video_page_thumb-<?php echo $id; ?> {
	width: <?php echo $syg_thumbnail_width; ?>px;
}

.syg_video_page_description {
	
}

/* video-gallery styles */

/* style to remove after loading */
.syg_video_gallery_loading-<?php echo $id; ?> {
	background-image: url('../img/ui/loader.gif');
	background-repeat: no-repeat;
	background-position:center;
	height: 100px !important;
}

.syg_video_gallery-<?php echo $id; ?> {
	background-color: <?php echo $syg_box_background; ?>;
	border-radius: <?php echo $syg_box_radius; ?>px;
    -webkit-border-radius: <?php echo $syg_box_radius; ?>px;
    -moz-border-radius: <?php echo $syg_box_radius; ?>px;
    width: <?php echo $syg_box_width; ?>px;
    display: inline-block;
}

div.sc_menu-<?php echo $id; ?> {
	position: relative;
}

ul.sc_menu-<?php echo $id; ?> {	
	width: 50000px;	
	padding: <?php echo $syg_box_padding; ?>px; 
	margin: 0;
	list-style: none;
}

ul.sc_menu-<?php echo $id; ?> li {
	display: block;
	float: left;
	margin-right: <?php echo $syg_thumbnail_distance; ?>px;
}

ul.sc_menu-<?php echo $id; ?> li:last-child {
	margin-right: 0;
}

.sc_menu-<?php echo $id; ?> a:hover span {
	display: block;
}

.sc_menu-<?php echo $id; ?> span.video_title-<?php echo $id; ?> {
	font-weight: bold;
	display: block;
	margin: 3% auto;
	text-align: center;
	font-size: <?php echo $syg_description_fontsize; ?>px;	
	color: <?php echo $syg_description_fontcolor; ?>;
	width: <?php echo $syg_description_width; ?>px;
	margin-bottom: <?php echo $syg_box_padding; ?>px; 
}

.sc_menu-<?php echo $id; ?> a:hover img {
	filter:alpha(opacity=50);	
	opacity: 0.5;
}

#gallery-title {

}