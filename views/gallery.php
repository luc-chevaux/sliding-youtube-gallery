<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 
// gallery data retreival
$feed = $this->data['feed'];
$gallery = $this->data['gallery'];

// gallery settings 
$thumbImage = $gallery->getThumbImage();
$overlayButtonSrc = (!empty($thumbImage)) ? $this->data['imgPath'] . '/button/play-the-video_' . $gallery->getThumbImage() .'.png' : $this->data['imgPath'] . '/button/play-the-video_1.png'; 
?>
<!-- User Message -->

<!-- Css Inclusion -->

<!-- Javascript Inclusion -->

<!-- Gallery -->
<div id="syg_video_gallery">
	<div class="sc_menu">
		<ul class="sc_menu">
			<?php 
				foreach ($feed as $element) {
					$videoThumbnails = $element->getVideoThumbnails();	
				?> 
				<!-- gallery code -->
				<li>
					<a class="sygVideo" href="<?php echo $this->data['pluginUrl']; ?>views/player.php?id=<?php echo $gallery->getId();?>&video=<?php echo $element->getVideoId(); ?>">
						<!-- append video thumbnail -->
						<?php if ($gallery->getDescShow()) { ?>
							<img src="<?php echo $videoThumbnails[1]['url']; ?>" class="thumbnail-image" alt="<?php echo $element->getVideoDescription(); ?>" title="<?php echo $element->getVideoDescription(); ?>"/>
						<?php } else { ?>
							<img src="<?php echo $videoThumbnails[1]['url']; ?>" class="thumbnail-image" alt="play" title="play"/>
						<?php }?>				
				
						<!-- show overlay button -->			
						<img class="play-icon" src="<?php echo $overlayButtonSrc; ?>" alt="play">
				
						<!-- show video duration -->
						<?php if ($gallery->getDescShowDuration()) { ?>
							<span class="video_duration"><?php echo SygUtil::formatDuration($element->getVideoDuration()); ?></span>
						<?php } ?>
					</a>
					<!-- show video title -->
					<span class="video_title"><?php echo $element->getVideoTitle(); ?></span>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>