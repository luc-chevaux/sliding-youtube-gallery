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
<div id="syg_video_gallery-<?php echo $gallery->getId();?>" class="syg_video_gallery_loading-<?php echo $gallery->getId();?>">
	<div class="sc_menu-<?php echo $gallery->getId();?>">
		<ul class="sc_menu-<?php echo $gallery->getId();?>" style="display: none;">
			<?php 
				foreach ($feed as $element) {
					$videoThumbnails = $element->getVideoThumbnails();	
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

<script>
jQuery(window).load(function() {

	jQuery('#syg_video_gallery-<?php echo $gallery->getId(); ?>')
		.removeClass('syg_video_gallery_loading-<?php echo $gallery->getId(); ?>')
		.addClass('syg_video_gallery-<?php echo $gallery->getId(); ?>');
	
	
	/* remove display none */
	jQuery('.sc_menu-<?php echo $gallery->getId();?>').removeAttr('style');

	jQuery(function($){
		//Get our elements for faster access and set overlay width
		var div = $('div.sc_menu-<?php echo $gallery->getId(); ?>'),
			ul = $('ul.sc_menu-<?php echo $gallery->getId(); ?>'),
			ulPadding = 15;
		
		//Get menu width
		var divWidth = <?php echo $gallery->getBoxWidth(); ?>;
		
		//Remove scrollbars	
		div.css({overflow: 'hidden'});
		
		//Find last image container
		var lastLi = ul.find('li:last-child');
		
		//When user move mouse over menu
		div.mousemove(function(e){
			//As images are loaded ul width increases,
			//so we recalculate it each time
			var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;	
			var left = (e.pageX - div.offset().left) * (ulWidth-divWidth) / divWidth;
			div.scrollLeft(left);
		});
	});
});
</script>