<?php

// set header type
header('Content-type: text/css');
// include zend loader
include('../../../../wp-load.php');
// include default values
include('../DefaultValues.php');

?>

/* general styles */

img.thumbnail-image{
	width: <?php echo $syg_thumbnail_width; ?>px;
	heigth: <?php echo $syg_thumbnail_height; ?>px;
	border: <?php echo $syg_thumbnail_bordersize; ?>px <?php echo $syg_thumbnail_bordercolor; ?> solid;	
    border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
    -webkit-border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
    -moz-border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
    max-width: 100%;
    display: block;
}

img.play-icon{
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

span.video_duration {
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

h4.video_title {
	color: <?php echo $syg_description_fontcolor; ?>;
	font-size: 115%;
	font-weight: bold;
	width: 100%;
	border-bottom: <?php echo $syg_thumbnail_bordersize; ?>px <?php echo $syg_thumbnail_bordercolor; ?> solid;
}

h4.video_title a {
	color: inherit;
	text-decoration: none;
}

.syg_video_page_container .video_entry_table {
	width: 100%;
	border-width: 0px 0px 0px 0px;
	margin: 0;
	padding: 0;
}

.video_entry_table td p {
	margin: 0px 0px 3%;
	font-size: 95%;
}

.video_entry_table td span.video_tags {
	font-size: 80%;
	display: block;
}

.video_entry_table td span.video_ratings {
	font-size: 80%;
	display: block;
}

.video_entry_table td span.video_categories {
	font-size: 80%;
	display: block;
}

.syg_video_page_container .video_entry_table td{
	border-width: 0px 0px 0px 0px;
	vertical-align: top;
}

.syg_video_page_thumb {
	width: <?php echo $syg_thumbnail_width; ?>px;
}

.syg_video_page_description {
	
}

/* video-gallery styles */

#syg_video_gallery {
	background-color: <?php echo $syg_box_background; ?>;
	border-radius: <?php echo $syg_box_radius; ?>px;
    -webkit-border-radius: <?php echo $syg_box_radius; ?>px;
    -moz-border-radius: <?php echo $syg_box_radius; ?>px;
    width: <?php echo $syg_box_width; ?>px;
    display: inline-block;
}

div.sc_menu {
	position: relative;
}

ul.sc_menu {	
	width: 50000px;	
	padding: <?php echo $syg_box_padding; ?>px; 
	margin: 0;
	list-style: none;
}

ul.sc_menu li {
	display: block;
	float: left;
	margin-right: <?php echo $syg_thumbnail_distance; ?>px;
}

ul.sc_menu li:last-child {
	margin-right: 0;
}

.sc_menu a:hover span {
	display: block;
}

.sc_menu span.video_title {
	font-weight: bold;
	display: block;
	margin: 3% auto;
	text-align: center;
	font-size: <?php echo $syg_description_fontsize; ?>px;	
	color: <?php echo $syg_description_fontcolor; ?>;
	width: <?php echo $syg_description_width; ?>px;
	margin-bottom: <?php echo $syg_box_padding; ?>px; 
}

.sc_menu a:hover img {
	filter:alpha(opacity=50);	
	opacity: 0.5;
}