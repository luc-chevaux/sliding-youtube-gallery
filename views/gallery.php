<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php
// gallery data retreival
$feed = $this->data['feed'];
$gallery = $this->data['gallery'];
$mode = $this->data['mode'];

// gallery settings 
$thumbImage = $gallery->getSygStyle()->getThumbImage();
$overlayButtonSrc = (!empty($thumbImage)) ? $this->data['imgPath'] . '/button/play-the-video_' . $gallery->getSygStyle()->getThumbImage() .'.png' : $this->data['imgPath'] . '/button/play-the-video_1.png'; 
?>
<!-- User Message -->

<!-- Css Inclusion -->

<!-- Javascript Inclusion -->

<!-- Gallery -->
<div id="syg_video_gallery-<?php echo $gallery->getId();?>" class="syg_video_gallery_loading-<?php echo $gallery->getId();?>">
	<div class="sc_menu-<?php echo $gallery->getId();?>">
		<ul class="sc_menu-<?php echo $gallery->getId();?>" style="display: none;">
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
				<!-- gallery code -->
				<li>
					<a class="sygVideo" href="<?php echo $this->data['pluginUrl']; ?>views/player.php?id=<?php echo $gallery->getId();?>&video=<?php echo $element->getVideoId(); ?>">
						<!-- append video thumbnail -->
						<?php if ($gallery->getDescShow()) { ?>
							<img src="<?php echo $videoThumbnails[1]['url']; ?>" class="thumbnail-image-<?php echo $gallery->getId();?>" alt="<?php echo $element->getVideoDescription(); ?>" title="<?php echo $element->getVideoDescription(); ?>"/>
						<?php } else { ?>
							<img src="<?php echo $videoThumbnails[1]['url']; ?>" class="thumbnail-image-<?php echo $gallery->getId();?>" alt="play" title="play"/>
						<?php }?>				
				
						<!-- show overlay button -->			
						<img class="play-icon-<?php echo $gallery->getId();?>" src="<?php echo $overlayButtonSrc; ?>" alt="play">
				
						<!-- show video duration -->
						<?php if ($gallery->getDescShowDuration()) { ?>
							<span class="video_duration-<?php echo $gallery->getId();?>"><?php echo SygUtil::formatDuration($element->getVideoDuration()); ?></span>
						<?php } ?>
					</a>
					<!-- show video title -->
					<span class="video_title-<?php echo $gallery->getId();?>"><?php echo $element->getVideoTitle(); ?></span>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>

<!-- registra script -->
<?php 
// js to include
$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/ready/syg.client.min.js.php?id='.$gallery->getId().'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY;
wp_register_script('syg-client-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY, $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-client-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY);
// js to include
$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/loading/gallery.min.js.php?id='.$gallery->getId();
wp_register_script('syg-action-'.$gallery->getId(), $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-action-'.$gallery->getId());
?>