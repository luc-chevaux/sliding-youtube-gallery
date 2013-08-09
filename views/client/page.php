<?php 
// gallery data retreival
$gallery = $this->data['gallery'];
$options = $this->data['options'];

// gallery settings 
$thumbImage = $gallery->getSygStyle()->getThumbImage();
$overlayButtonSrc = (!empty($thumbImage)) ? $this->data['imgPath'] . '/button/play-the-video_' . $gallery->getSygStyle()->getThumbImage() .'.png' : $this->data['imgPath'] . '/button/play-the-video_1.png'; 
?>

<div id="syg_video_page-<?php echo $gallery->getId();?>" class="syg_video_gallery_loading-<?php echo $gallery->getId();?>">
	<div class="syg_video_page_container-<?php echo $gallery->getId();?>" id="syg_video_page_container-<?php echo $gallery->getId();?>">
		
		<?php 
		if (($options['syg_option_paginationarea'] == 'top') || ($options['syg_option_paginationarea'] == 'both')) {
			$paginator_area = 'top';
			include 'inc/paginator.inc.php';
		} 
		?>
		
		<div id="syg_video_container-<?php echo $gallery->getId();?>" style="display: none;">
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

<?php
// js to include
$url = plugins_url().'/sliding-youtube-gallery/js/core/ui/ready/syg.client.min.js.php?id='.$gallery->getId().'&cache=off'.'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_PAGE;
wp_register_script('syg-page-ready-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_PAGE, $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-page-ready-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_PAGE);
// js to include
$url = plugins_url().'/sliding-youtube-gallery/js/core/ui/loading/page.min.js.php?id='.$gallery->getId();
wp_register_script('syg-page-loading-'.$gallery->getId(), $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-page-loading-'.$gallery->getId());
?>