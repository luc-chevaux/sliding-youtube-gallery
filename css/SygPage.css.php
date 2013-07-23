<?php
require_once('./inc/cssIf.php');
?>

#syg_video_container-<?php echo $id; ?> {
clear: both;
display: inline-block;
width: 100%;
height: 100px;
/*margin-top: <?php echo ceil($syg_box_padding*0.25); ?>px;*/
text-align: center;
position:relative;
}

#syg_video_page-<?php echo $id; ?> {
background-color: <?php echo $syg_box_background; ?>;
border-radius: <?php echo $syg_box_radius; ?>px;
-webkit-border-radius: <?php echo $syg_box_radius; ?>px;
-moz-border-radius: <?php echo $syg_box_radius; ?>px;
display: inline-block;
padding: <?php echo $syg_box_padding; ?>px;
width: <?php echo ($syg_box_width-(2*$syg_box_padding)); ?>px;
}

.syg_video_page_container-<?php echo $id; ?> .video_entry_table-<?php echo $id; ?> {
width: 100%;
border-width: 0px 0px 0px 0px;
margin: 0;
padding: 0;
background-color: transparent !important;
}

.syg_video_page_container-<?php echo $id; ?> .video_entry_table-<?php echo $id; ?> td {
border-width: 0px 0px 0px 0px;
vertical-align: top;
color: <?php echo $syg_description_fontcolor; ?>;
font-size: <?php echo $syg_description_fontsize; ?>px;
}

.syg_video_page_container-<?php echo $id; ?> {
display: inline-block;
width: 100%;
height: 100%;
}

/* pagination */

#paginator-top-<?php echo $id; ?>, #paginator-bottom-<?php echo $id; ?> {
display: inline-block;
float: right;
clear: both;
padding: 0;
}

#paginator-top-<?php echo $id; ?> {
margin: 0px 0px 0px 0px;
}

#paginator-bottom-<?php echo $id; ?> {
margin: 0px 0px 0px 0px;
}

#pagination-top-<?php echo $id; ?>, #pagination-bottom-<?php echo $id; ?> {
text-align:center;
margin: 0;
padding: 0;
}

#pagination-top-<?php echo $id; ?> li, #pagination-bottom-<?php echo $id; ?> li {
list-style: none;
float: left;
line-height: 1;
margin-left: <?php echo ceil($syg_box_padding/2); ?>px;
padding: <?php echo intval($syg_box_padding*0.2); ?>px;

box-shadow: 0 0 <?php echo $syg_option_paginator_shadowsize; ?>px <?php echo $syg_option_paginator_shadowcolor; ?>;
background-color: <?php echo $syg_option_paginator_bgcolor; ?>;
color: <?php echo $syg_option_paginator_fontcolor; ?>;
border-radius: <?php echo $syg_option_paginator_borderradius; ?>px;
border: <?php echo $syg_option_paginator_bordersize; ?>px <?php echo $syg_option_paginator_bordercolor;?> solid;
font-size: <?php echo $syg_option_paginator_fontsize; ?>px;

height: <?php echo $syg_option_paginator_fontsize; ?>px;
width: <?php echo $syg_option_paginator_fontsize; ?>px;
}

#pagination-top-<?php echo $id; ?> li:hover, #pagination-bottom-<?php echo $id; ?> li:hover {
cursor: pointer;
}

#hook {
position:absolute;
top:50%;
height: 50px;
width: 50%;
margin-top: -25px;
margin-left: 25%;
background: url('../img/ui/loader/loader_flat_1.gif') no-repeat;
background-position: center center;
}

.current_page {
color: <?php echo $syg_option_paginator_fontcolor; ?> !important;
}

/* end pagination */

.video_entry_table-<?php echo $id; ?> td {
padding: <?php echo ceil ($syg_box_padding/2); ?>px <?php echo ceil ($syg_box_padding); ?>px 0 0;
text-align: left;
}

.video_entry_table-<?php echo $id; ?> td p {
margin: 0px 0px 3%;
font-size: 95%;
}

.video_entry_table-<?php echo $id; ?> td span.video_tags {
font-size: 80%;
float: right;
color: <?php echo $jollyColor; ?>;
margin: <?php echo ceil ($syg_box_padding/6); ?>px <?php echo ceil ($syg_box_padding/6); ?>px 0px 0px;
}

.video_entry_table-<?php echo $id; ?> td span.video_ratings {
font-size: 80%;
float: right;
color: <?php echo $jollyColor; ?>;
margin: <?php echo ceil ($syg_box_padding/6); ?>px <?php echo ceil ($syg_box_padding/6); ?>px 0px 0px;
}

.video_entry_table-<?php echo $id; ?> td span.video_categories {
font-size: 80%;
float: right;
color: <?php echo $jollyColor; ?>;
margin: <?php echo ceil ($syg_box_padding/6); ?>px <?php echo ceil ($syg_box_padding/6); ?>px 0px 0px;
}

.syg_video_page_thumb-<?php echo $id; ?> {
width: <?php echo $syg_thumbnail_width; ?>px;
text-align: left !important;
}

a.sygVideo-<?php echo $id; ?> {
display: block;
position:relative;
text-decoration: none;
}

img.thumbnail-image-<?php echo $id; ?> {
width: <?php echo $syg_thumbnail_width; ?>px;
height: <?php echo $syg_thumbnail_height; ?>px;
border: <?php echo $syg_thumbnail_bordersize; ?>px <?php echo $syg_thumbnail_bordercolor; ?> solid !important;
border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
-webkit-border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
-moz-border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
max-width: 100%;
display: block;
padding: 0 !important;
margin: 0 !important;
}

.textual_video_description {
display: inline-block;
line-height: 1.5 !important;
margin: 0px 0px 0px 0px !important;
padding: 0px 0px 0px 0px !important;
}

h4.video_title-<?php echo $id; ?> {
color: <?php echo $syg_description_fontcolor; ?>;
font-size: 130%;
font-weight: bold;
width: 100%;
line-height: 1.5;
border-bottom: <?php echo ceil ($syg_thumbnail_bordersize/2); ?>px <?php echo $syg_thumbnail_bordercolor; ?> solid;
margin: 0 auto !important;
}

h4.video_title-<?php echo $id; ?> a:link, h4.video_title-<?php echo $id; ?> a:visited, h4.video_title-<?php echo $id; ?> a:hover {
color: <?php echo $syg_thumbnail_bordercolor; ?> !important;
text-decoration: none !important;
}

.syg_video_page_description {
padding: <?php echo ceil ($syg_box_padding/2); ?>px 0px 0px 0px !important;
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

.syg_gallery_error {
border: 1px #bc0f11 solid;
padding: 5px;
margin: 5px;
background-color: #ed0000;
color: white;
}

.syg_gallery_error h2 {
font-size: 18px;
margin: 0;
padding: 0;
border-bottom: 1px #bc0f11 solid;
color: white;
}

.syg_gallery_error p {
margin: 3px 0px 3px 0px;
padding: 0;
font-size: 14px;
font-weight: bold;
}

