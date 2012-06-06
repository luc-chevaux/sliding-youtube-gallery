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

<div id="syg_video_page-<?php echo $gallery->getId();?>">
	<div class="syg_video_page_container-<?php echo $gallery->getId();?>" id="<?php echo $gallery->getId();?>">
		<?php 
			foreach ($feed as $element) {
				$videoThumbnails = $element->getVideoThumbnails();	
		?> 
		<table class="video_entry_table-<?php echo $gallery->getId();?>">
			<tr>
				<td class="syg_video_page_thumb-<?php echo $gallery->getId();?>">
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
				</td>
				<td class="syg_video_page_description">
					<h4 class="video_title"><a href="<?php echo $element->getVideoWatchPageUrl(); ?>" target="_blank"><?php echo $element->getVideoTitle(); ?></a></h4>
					<?php if ($gallery->getDescShow()) { ?>
						<p><?php echo $element->getVideoDescription(); ?></p>
					<?php }?>
					
					<?php if ($gallery->getDescShowCategories()) { ?>
						<span class="video_categories"><i>Category:</i>&nbsp;&nbsp; <?php echo $element->getVideoCategory(); ?></span>
					<?php } ?>

					<?php if ($gallery->getDescShowTags()) { ?>
						<span class="video_tags"><i>Tags:</i>&nbsp;&nbsp;
						<?php
							foreach ($element->getVideoTags() as $key => $value) {
								$html .= $value." | ";
							}
						?>
						</span>
					<?php } ?>

					<?php if ($gallery->getDescShowRatings()) { ?>
						<?php if ($element->getVideoRatingInfo()) { 
								$rating = $element->getVideoRatingInfo();?>
							<span class="video_ratings">
							<i>Average:</i>&nbsp;&nbsp;<?php echo $rating['average'];?>
							&nbsp;&nbsp;
							<i>Raters:</i>&nbsp;&nbsp;<?php echo $rating['numRaters'];?>
							</span>
						<?php } else { ?>
							<span class="video_ratings">
							<i>Rating not available</i>
							</span>
						<?php } ?>
					<?php } ?>
				</td>
			</tr>
		</table>
		<?php } ?>
	</div>
</div>