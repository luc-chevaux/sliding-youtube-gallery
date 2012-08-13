<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 
// gallery data retreival
$feed = $this->data['feed'];
$gallery = $this->data['gallery'];
$options = $this->data['options'];

// gallery settings 
$thumbImage = $gallery->getSygStyle()->getThumbImage();
$overlayButtonSrc = (!empty($thumbImage)) ? $this->data['imgPath'] . '/button/play-the-video_' . $gallery->getSygStyle()->getThumbImage() .'.png' : $this->data['imgPath'] . '/button/play-the-video_1.png'; 
?>
<!-- User Message -->

<!-- Css Inclusion -->

<!-- Javascript Inclusion -->

<!-- Gallery -->

<div id="syg_video_page-<?php echo $gallery->getId();?>">
	<div class="syg_video_page_container-<?php echo $gallery->getId();?>" id="syg_video_page_container-<?php echo $gallery->getId();?>">
		
		<?php 
		$paginator_area = 'top';
		include 'inc/paginator.inc.php'; 
		?>
		
		<div id="syg_video_container">
			<div id="hook"></div>
		</div>
		
		<?php 
		$paginator_area = 'bottom';
		include 'inc/paginator.inc.php'; 
		?>
	</div>
</div>