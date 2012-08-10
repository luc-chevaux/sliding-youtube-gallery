<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 
// gallery data retreival
$feed = $this->data['feed'];
$gallery = $this->data['gallery'];

// gallery settings 
$thumbImage = $gallery->getSygStyle()->getThumbImage();
$overlayButtonSrc = (!empty($thumbImage)) ? $this->data['imgPath'] . '/button/play-the-video_' . $gallery->getSygStyle()->getThumbImage() .'.png' : $this->data['imgPath'] . '/button/play-the-video_1.png'; 
?>
<!-- User Message -->

<!-- Css Inclusion -->

<!-- Javascript Inclusion -->

<!-- Gallery -->

<div id="syg_video_page-<?php echo $gallery->getId();?>">
	<div class="syg_video_page_container-<?php echo $gallery->getId();?>" id="<?php echo $gallery->getId();?>">
		<ul id="syg-page-pagination">
			<?php
			// show page links
			for($i=1; $i<=$this->data['pages']; $i++) {
				echo ($i == 1) ? '<li id="'.$i.'" class="current_page">'.$i.'</li>' : '<li id="'.$i.'">'.$i.'</li>';
			}
			?>
		</ul>
		
		<div id="syg_video_container">
			<div id="hook"></div>
		</div>
		
		<ul id="syg-page-pagination">
			<?php
			// show page links
			for($i=1; $i<=$this->data['pages']; $i++) {
				echo ($i == 1) ? '<li id="'.$i.'" class="current_page">'.$i.'</li>' : '<li id="'.$i.'">'.$i.'</li>';
			}
			?>
		</ul>	
	</div>
</div>