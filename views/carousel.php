<?php
// gallery data retreival
$feed = $this->data['feed'];
$gallery = $this->data['gallery'];
$mode = $this->data['mode'];

// gallery settings 
$thumbImage = $gallery->getSygStyle()->getThumbImage();
$overlayButtonSrc = (!empty($thumbImage)) ? $this->data['imgPath'] . '/button/play-the-video_' . $gallery->getSygStyle()->getThumbImage() .'.png' : $this->data['imgPath'] . '/button/play-the-video_1.png'; 
?>
<div id="syg_video_carousel-<?php echo $gallery->getId();?>" class="syg_video_gallery_loading-<?php echo $gallery->getId();?>" style="width:100%; height:100%;background:red;overflow:scroll;">
	<?php
		foreach ($feed as $element) {				
			// modify the img path to match local files
			if ($mode == SygConstant::SYG_PLUGIN_FE_CACHING_MODE) {
				$videoThumbnails[1]['url'] = WP_PLUGIN_URL . 
											SygConstant::WP_PLUGIN_PATH .
											SygConstant::WP_CACHE_THUMB_REL_DIR .
											$gallery->getId() . 
											DIRECTORY_SEPARATOR . 
											$element->getVideoId() . '.jpg';
			} else {
				$videoThumbnails = $element->getVideoThumbnails();
			}
		?>
		<a class="sygVideo" href="<?php echo $this->data['pluginUrl']; ?>views/player.php?id=<?php echo $gallery->getId();?>&video=<?php echo $element->getVideoId(); ?>">
			<?php if ($gallery->getDescShow()) { ?>
				<img class="cloudcarousel" src="<?php echo $videoThumbnails[1]['url']; ?>" class="thumbnail-image-<?php echo $gallery->getId();?>" alt="<?php echo $element->getVideoDescription(); ?>" title="<?php echo $element->getVideoDescription(); ?>"/>
			<?php } else { ?>
				<img class="cloudcarousel" src="<?php echo $videoThumbnails[1]['url']; ?>" class="thumbnail-image-<?php echo $gallery->getId();?>" alt="play" title="play"/>
			<?php } ?>		
		</a>
	<?php } ?>
</div>

<input id="left-but"  type="button" value="Left" />
<input id="right-but" type="button" value="Right" />

<!-- <p id="title-text"></p>
<p id="alt-text"></p> -->

<?php 
// js to include
$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/ready/syg.client.min.js.php?id='.$gallery->getId().'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL;
wp_register_script('syg-client-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL, $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-client-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL);
// js to include
$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/loading/carousel.min.js.php?id='.$gallery->getId();
wp_register_script('syg-action-'.$gallery->getId(), $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-action-'.$gallery->getId());
?>