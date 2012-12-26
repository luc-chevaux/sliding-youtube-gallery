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
		if (($options['syg_option_paginationarea'] == 'top') || ($options['syg_option_paginationarea'] == 'both')) {
			$paginator_area = 'top';
			include 'inc/paginator.inc.php';
		} 
		?>
		
		<div id="syg_video_container-<?php echo $gallery->getId();?>">
			<div id="hook"></div>
		</div>
		
		<?php 
		if (($options['syg_option_paginationarea'] == 'bottom') || ($options['syg_option_paginationarea'] == 'both')) {
			$paginator_area = 'bottom';
			include 'inc/paginator.inc.php'; 
		}
		?>
	</div>
</div>

<!-- registra script -->
<?php 
// js to include
$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/ready/syg.client.js.php?id='.$gallery->getId().'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_PAGE;
wp_register_script('syg-client-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_PAGE, $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-client-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_PAGE);
?>