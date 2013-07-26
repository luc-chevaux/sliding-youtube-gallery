<?php
require_once('./inc/cssIf.php');
?>

.syg_video_gallery-<?php echo $id; ?>, .syg_video_carousel-<?php echo $id; ?> {
    background-color: <?php echo $syg_box_background; ?>;
    border-radius: <?php echo $syg_box_radius; ?>px;
    -webkit-border-radius: <?php echo $syg_box_radius; ?>px;
    -moz-border-radius: <?php echo $syg_box_radius; ?>px;
    width: <?php echo $syg_box_width; ?>px;
    display: inline-block;
}

.syg_video_carousel-<?php echo $id; ?> {
    height: <?php echo $heightRatio; ?>px;
    margin: <?php echo $syg_box_padding; ?>px 0px <?php echo $syg_box_padding; ?>px 0px;
}

#hidden-carousel-layer_<?php echo $id; ?> {
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
}

#carousel-title-area-<?php echo $id; ?> {
    position: absolute !important;
    top: <?php echo $syg_box_padding; ?>px !important;
    right: <?php echo $syg_box_padding; ?>px !important;
    left: <?php echo $syg_box_padding; ?>px !important;

    height: <?php echo ceil($heightRatio*0.13); ?>px !important;
    width: <?php echo ceil($syg_box_width-$syg_box_padding*2); ?>px;

    margin: 0 auto !important;
    padding: 0px !important;
    z-index: 10000;
    border: 0px black solid !important;
}

#carousel-titleblock-<?php echo $id; ?> {
 /**/
    height: <?php echo ceil($heightRatio*0.13); ?>px !important;
    display: inline-block;
    width: <?php echo ceil($syg_box_width-$syg_box_padding*2); ?>px;
    text-align: center;
    padding: 0px !important;
    border: 0px black solid !important;
}

#carousel-title-<?php echo $id; ?> {
    text-shadow: -1px 0 black,
                 0 1px black,
                 1px 0 black,
                 0 -1px black,
                 0px 0px 30px <?php echo $syg_thumbnail_bordercolor; ?>;
    font-size: <?php echo ceil ($syg_description_fontsize*1.8); ?>px;
    color: <?php echo $syg_description_fontcolor; ?>;
    font-weight: bold;
line-height: normal;
}

a.sygVideo-<?php echo $id; ?> {
    display: block;
    position:relative;
    text-decoration: none;
}

img.carousel-thumb-image-<?php echo $id; ?> {
    border: <?php echo $syg_thumbnail_bordersize; ?>px <?php echo $syg_thumbnail_bordercolor; ?> solid;
    border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
    -webkit-border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
    -moz-border-radius: <?php echo $syg_thumbnail_borderradius; ?>px;
    max-width: 100%;
    display: block;
    background-color: transparent !important;
    padding: 0 !important;
    margin: 0 !important;
}

#left-carousel-button-<?php echo $id; ?> {
    filter:alpha(opacity=30);
    position: absolute;
    left: <?php echo $syg_box_padding; ?>px;
    bottom: <?php echo ceil($heightRatio/2 - 25);?>px;
    display: inline;
    z-index: 1000;
}

#right-carousel-button-<?php echo $id; ?> {
    filter:alpha(opacity=30);
    position: absolute;
    right: <?php echo $syg_box_padding; ?>px;
    bottom: <?php echo ceil($heightRatio/2 - 25);?>px;
    display: inline;
    z-index: 1000;
}

#left-carousel-button-<?php echo $id; ?> img, #right-carousel-button-<?php echo $id; ?> img {
    border: 0 !important;
    background: transparent !important;
    margin: 0;
    padding: 0;
    opacity: 0.3;
}

