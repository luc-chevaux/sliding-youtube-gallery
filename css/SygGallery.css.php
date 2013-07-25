<?php
require_once('./inc/cssIf.php');
?>

.syg_video_gallery-<?php echo $id; ?> {
    background-color: <?php echo $syg_box_background; ?>;
    border-radius: <?php echo $syg_box_radius; ?>px;
    -webkit-border-radius: <?php echo $syg_box_radius; ?>px;
    -moz-border-radius: <?php echo $syg_box_radius; ?>px;
    width: <?php echo $syg_box_width; ?>px;
    display: inline-block;
    margin: <?php echo $syg_box_padding; ?>px 0px <?php echo $syg_box_padding; ?>px 0px;
}

/* style to remove after loading */
.syg_video_gallery_loading-<?php echo $id; ?>, .syg_video_carousel_loading-<?php echo $id; ?> {
    background-image: url('../img/ui/loader.gif');
    background-repeat: no-repeat;
    background-position:center;
    height: 100px !important;
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
    margin: 0px <?php echo $syg_thumbnail_distance; ?>px 0px 0px !important;
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
    line-height: 1.5;
}

.sc_menu-<?php echo $id; ?> a:hover img {
    filter:alpha(opacity=50);
    opacity: 0.5;
}

a.sygVideo-<?php echo $id; ?> {
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

img.play-icon-<?php echo $id; ?>{
    border: 0;
    display: block;
    visibility:visible;
    position:absolute;
    left:<?php echo $syg_thumbnail_left; ?>%;
    top:<?php echo $syg_thumbnail_top; ?>%;
    width: <?php echo $syg_thumbnail_overlaysize; ?>px;
    height: <?php echo $syg_thumbnail_overlaysize; ?>px;
    background-color: transparent !important;
    padding: 0 !important;
    margin: 0 !important;
    opacity: <?php echo $syg_thumbnail_buttonopacity; ?>;
    filter:alpha(opacity=<?php echo $syg_thumbnail_buttonopacity*100;?>);
}