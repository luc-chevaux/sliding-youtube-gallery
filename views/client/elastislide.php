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
<ul id="syg-elastislide-<?php echo $gallery->getId();?>" class="elastislide-list">
	<?php 
	foreach ($feed as $element) {				
		// modify the img path to match local files
		if ($mode == SygConstant::SYG_PLUGIN_FE_CACHING_MODE) {
			$videoThumbnails[$options['syg_option_which_thumb']]['url'] = content_url() .
										SygConstant::WP_CACHE_THUMB_REL_DIR .
										$gallery->getId() . 
										DIRECTORY_SEPARATOR . 
										$element->getVideoId() . '.jpg';
		} else {
			$videoThumbnails = $element->getVideoThumbnails();
		}
	?> 
	<li>
		<a class="sygVideo-<?php echo $gallery->getId();?>" href="http://www.youtube.com/watch?v=<?php echo $element->getVideoId(); ?>" title="<?php echo htmlspecialchars($element->getVideoTitle()); ?>">
			<!-- append video thumbnail -->
			<?php if ($gallery->getDescShow()) { ?>
				<img class="elastislide-img-item" src="<?php echo $videoThumbnails[$options['syg_option_which_thumb']]['url']; ?>" alt="<?php echo htmlspecialchars($element->getVideoDescription()); ?>" title="<?php echo htmlspecialchars($element->getVideoDescription()); ?>"/>
			<?php } else { ?>
				<img class="elastislide-img-item" src="<?php echo $videoThumbnails[$options['syg_option_which_thumb']]['url']; ?>" alt="play" title="play"/>
			<?php }?>
			
			<!-- show video duration -->
			<?php if ($gallery->getDescShowDuration()) { ?>
				<span class="video_duration-<?php echo $gallery->getId();?>"><?php echo SygUtil::formatDuration($element->getVideoDuration()); ?></span>
			<?php } ?>
		</a>
	</li>
	<?php } ?>
</ul>

<?php 
// js to include
$url = plugins_url().'/sliding-youtube-gallery/js/core/ui/ready/syg.client.min.js.php?id='.$gallery->getId().'&cache=off'.'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_ELASTISLIDE;
wp_register_script('syg-elastislide-ready-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_ELASTISLIDE, $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-elastislide-ready-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_ELASTISLIDE);
// js to include
$url = plugins_url().'/sliding-youtube-gallery/js/core/ui/loading/elastislide.min.js.php?id='.$gallery->getId();
wp_register_script('syg-elastislide-loading-'.$gallery->getId(), $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-elastislide-loading-'.$gallery->getId());
?>