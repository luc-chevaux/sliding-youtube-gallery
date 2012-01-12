<?php
/* YouTube default values */
// default video format
$syg_youtube_videoformat = get_option('syg_youtube_videoformat') != '' ? get_option('syg_youtube_videoformat') : "480n";
// default max video count
$syg_youtube_maxvideocount = get_option('syg_youtube_maxvideocount') != '' ? get_option('syg_youtube_maxvideocount') : "15";

/* box default values*/
// default main box width
$syg_box_width = get_option('syg_box_width') != '' ? get_option('syg_box_width') : "550";
// default main box background color
$syg_box_background = get_option('syg_box_background') != '' ? get_option('syg_box_background') : "#efefef";
// default box radius pixel
$syg_box_radius = get_option('syg_box_radius') != '' ? get_option('syg_box_radius') : "10";
// default box padding pixel
$syg_box_padding = get_option('syg_box_padding') != '' ? get_option('syg_box_padding') : "10";

/* thumbnail default values*/
// default thumbnail height
$syg_thumbnail_height = get_option('syg_thumbnail_height') != '' ? get_option('syg_thumbnail_height') : "100";
// default thumbnail width
$syg_thumbnail_width = get_option('syg_thumbnail_width') != '' ? get_option('syg_thumbnail_width') : "133";
// default thumbnail border size
$syg_thumbnail_bordersize = get_option('syg_thumbnail_bordersize') != '' ? get_option('syg_thumbnail_bordersize') : "3";
// default thumbnail border color
$syg_thumbnail_bordercolor = get_option('syg_thumbnail_bordercolor') != '' ? get_option('syg_thumbnail_bordercolor') : "#333333";
// default thumbnail border radius
$syg_thumbnail_borderradius = get_option('syg_thumbnail_borderradius') != '' ? get_option('syg_thumbnail_borderradius') : "10";
// default thumbnail overlay size
$syg_thumbnail_overlaysize = get_option('syg_thumbnail_overlaysize') != '' ? get_option('syg_thumbnail_overlaysize') : "32";
// default overlay button
$syg_thumbnail_image = get_option('syg_thumbnail_image') != '' ? get_option('syg_thumbnail_image') : "1";
// default thumbnail border size
$syg_thumbnail_bordersize = get_option('syg_thumbnail_bordersize') != '' ? get_option('syg_thumbnail_bordersize') : "3";
// default thumbnail distance
$syg_thumbnail_distance = get_option('syg_thumbnail_distance') != '' ? get_option('syg_thumbnail_distance') : "10";
// default thumbnail button opacity
$syg_thumbnail_buttonopacity = get_option('syg_thumbnail_buttonopacity') != '' ? get_option('syg_thumbnail_buttonopacity') : "0.50";
// update calculated option
$perc_occ_w = $syg_thumbnail_overlaysize / ($syg_thumbnail_width + ($syg_thumbnail_bordersize*2));
$default_left = 50 - ($perc_occ_w / 2 * 100);
$perc_occ_h = $syg_thumbnail_overlaysize / ($syg_thumbnail_height + ($syg_thumbnail_bordersize*2));
$default_top = 50 - ($perc_occ_h / 2 * 100);
// default thumbnail top position 
$syg_thumbnail_top = get_option('syg_thumbnail_top') != '' ? get_option('syg_thumbnail_top') : $default_top;
// default thumbnail left position
$syg_thumbnail_left = get_option('syg_thumbnail_left') != '' ? get_option('syg_thumbnail_left') : $default_left;

/* thumbnail description */
// default description width
$syg_description_width = get_option('syg_description_width') != '' ? get_option('syg_description_width') : $syg_thumbnail_width;
// default description font size
$syg_description_fontsize = get_option('syg_description_fontsize') != '' ? get_option('syg_description_fontsize') : "12";
// default description font color
$syg_description_fontcolor = get_option('syg_description_fontcolor') != '' ? get_option('syg_description_fontcolor') : "#333333";
// default show video description
$syg_description_show = get_option('syg_description_show') != '' ? get_option('syg_description_show') : "false";
// default show video duration
$syg_description_showduration = get_option('syg_description_showduration') != '' ? get_option('syg_description_showduration') : "false";
// default show video tags
$syg_description_showtags = get_option('syg_description_showtags') != '' ? get_option('syg_description_showtags') : "false";
// default show video ratings
$syg_description_showratings = get_option('syg_description_showratings') != '' ? get_option('syg_description_showratings') : "false";
// default show video categories
$syg_description_showcategories = get_option('syg_description_showcategories') != '' ? get_option('syg_description_showcategories') : "false";
?>