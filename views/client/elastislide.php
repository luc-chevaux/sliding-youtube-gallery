<!-- Php Inclusion -->

<!-- Extra Php Code -->
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
<!-- User Message -->

<!-- Css Inclusion -->

<!-- Javascript Inclusion -->

<!-- Gallery -->
<div class="elastislide-wrapper elastislide-vertical syg_video_gallery_loading-<?php echo $gallery->getId();?>" style="max-width: 170px; height: 554px;">
	<div class="elastislide-carousel">
		<ul style="display: block; height: 480px; transition: all 500ms ease-in-out 0s;" id="carousel" class="elastislide-list">
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
			<li style="width: 100%; max-width: 150px; max-height: 160px;">
				<a class="sygVideo-<?php echo $gallery->getId();?>" href="http://www.youtube.com/watch?v=<?php echo $element->getVideoId(); ?>&autoplay=1" title="<?php echo $element->getVideoTitle(); ?>">
					<!-- append video thumbnail -->
					<?php if ($gallery->getDescShow()) { ?>
						<img src="<?php echo $videoThumbnails[$options['syg_option_which_thumb']]['url']; ?>" class="thumbnail-image-<?php echo $gallery->getId();?>" alt="<?php echo $element->getVideoDescription(); ?>" title="<?php echo $element->getVideoDescription(); ?>"/>
					<?php } else { ?>
						<img src="<?php echo $videoThumbnails[$options['syg_option_which_thumb']]['url']; ?>" class="thumbnail-image-<?php echo $gallery->getId();?>" alt="play" title="play"/>
					<?php }?>				
			
					<!-- show overlay button -->
					<?php if ((!$gallery->getCacheOn()) || (!$gallery->isGalleryCached())) { ?>			
						<img class="play-icon-<?php echo $gallery->getId();?>" src="<?php echo $overlayButtonSrc; ?>" alt="play">
					<?php } ?>
					
					<!-- show video duration -->
					<?php if ($gallery->getDescShowDuration()) { ?>
						<span class="video_duration-<?php echo $gallery->getId();?>"><?php echo SygUtil::formatDuration($element->getVideoDuration()); ?></span>
					<?php } ?>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
	<nav>
		<span style="display: none;" class="elastislide-prev">Previous</span>
		<span class="elastislide-next">Next</span>
	</nav>
</div>
<!-- registra script -->
<?php 
// js to include
$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/ready/syg.client.min.js.php?id='.$gallery->getId().'&cache=off'.'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY;
wp_register_script('syg-client-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY, $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-client-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY);
// js to include
$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/loading/gallery.min.js.php?id='.$gallery->getId();
wp_register_script('syg-action-'.$gallery->getId(), $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-action-'.$gallery->getId());
?>