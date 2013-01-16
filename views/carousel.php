<?php
// gallery data retreival
$feed = $this->data['feed'];
$gallery = $this->data['gallery'];
$mode = $this->data['mode'];
$options = $this->data['options'];

// gallery settings 
$thumbImage = $gallery->getSygStyle()->getThumbImage();
$overlayButtonSrc = (!empty($thumbImage)) ? $this->data['imgPath'] . '/button/play-the-video_' . $gallery->getSygStyle()->getThumbImage() .'.png' : $this->data['imgPath'] . '/button/play-the-video_1.png'; 
?>
<div id="syg_video_carousel-<?php echo $gallery->getId();?>" class="syg_video_carousel_loading-<?php echo $gallery->getId();?>">
	<div id="hidden-carousel-layer_<?php echo $gallery->getId();?>" style="display: none">
		<?php
		foreach ($feed as $element) {				
			// modify the img path to match local files
			if ($mode == SygConstant::SYG_PLUGIN_FE_CACHING_MODE) {
				$videoThumbnails[$options['syg_option_which_thumb']]['url'] = WP_PLUGIN_URL . 
											SygConstant::WP_PLUGIN_PATH .
											SygConstant::WP_CACHE_THUMB_REL_DIR .
											$gallery->getId() . 
											DIRECTORY_SEPARATOR . 
											$element->getVideoId() . '.jpg';
			} else {
				$videoThumbnails = $element->getVideoThumbnails();
			}
		?>
		<a class="sygVideo" href="http://www.youtube.com/watch?v=<?php echo $element->getVideoId(); ?>">
			<?php if ($gallery->getDescShow()) { ?>
				<img class="cloudcarousel carousel-thumb-image-<?php echo $gallery->getId();?>" src="<?php echo $videoThumbnails[$options['syg_option_which_thumb']]['url']; ?>" alt="<?php echo $element->getVideoDescription(); ?>" title="<?php echo $element->getVideoTitle(); ?>"/>
			<?php } else { ?>
				<img class="cloudcarousel carousel-thumb-image-<?php echo $gallery->getId();?>" src="<?php echo $videoThumbnails[$options['syg_option_which_thumb']]['url']; ?>" alt="play" title="<?php echo $element->getVideoTitle(); ?>"/>
			<?php } ?>
			
			<!-- show overlay button -->
			<?php if (!$gallery->getCacheOn()) { ?>			
				<img class="play-icon-<?php echo $gallery->getId();?>" src="<?php echo $overlayButtonSrc; ?>" alt="play">
			<?php } ?>		
		</a>
		<?php } ?>
		
		<?php if ($options['syg_option_carousel_autorotate'] == 'no') { ?>
			<div id="left-carousel-button-<?php echo $gallery->getId();?>">
				<img src="<?php echo WP_PLUGIN_URL.'/sliding-youtube-gallery/img/ui/carousel/25/left.png'; ?>">
			</div>
			<div id="right-carousel-button-<?php echo $gallery->getId();?>">
				<img src="<?php echo WP_PLUGIN_URL.'/sliding-youtube-gallery/img/ui/carousel/25/right.png'; ?>">
			</div>
		<?php } ?>
		
		<p id="carousel-title-<?php echo $gallery->getId(); ?>"></p>
	</div>
</div>

<?php 
// js to include
$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/ready/syg.client.min.js.php?id='.$gallery->getId().'&cache=off'.'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL;
wp_register_script('syg-client-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL, $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-client-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL);
// js to include
$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/loading/carousel.min.js.php?id='.$gallery->getId();
wp_register_script('syg-action-'.$gallery->getId(), $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-action-'.$gallery->getId());
?>