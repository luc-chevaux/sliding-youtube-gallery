<?php
	error_reporting(0);
	require_once 'inc/getWpEnvironment.inc.php';
	require_once 'inc/getExtractedGallery.inc.php';
	
	// gallery loading 
	$galleryLoadingJs = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/loading/gallery.js.php?id='.$gallery_id;
	if (array_key_exists('params', $_GET)) {
		$galleryLoadingJs .= '&params='.urlencode($_GET['params']);
	}
	
	// gallery css
	$galleryCss = WP_PLUGIN_URL.'/sliding-youtube-gallery/css/SygClient.css.php?id=' . $gallery_id;
	if (array_key_exists('params', $_GET)) {
		$galleryCss .= '&params=' . urlencode($_GET['params']);
	}
?>
<?php 
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style type="text/css">
		#loading-level {
		   background: url(../../img/ui/loader.gif) no-repeat center center;
		   height: 100px;
		   width: 100px;
		   position: fixed;
		   z-index: 1000;
		   left: 50%;
		   top: 50%;
		   margin: -25px 0 0 -25px;
		}
		
		#loading-wrapper {display: none;}
	</style>
	<script type="text/javascript" src="../../../../../wp-includes/js/jquery/jquery.js"></script>
	<script type="text/javascript" src="<?php echo WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/lib/syg.lib.client.min.js.php'; ?>"></script>
	<script type="text/javascript" src="<?php echo $galleryLoadingJs; ?>"></script>
</head>
<body>
	<div id="loading-level"></div>
	<div id="loading-wrapper">
		<?php 
		echo $syg->getGallery(array('id' => $gallery_id));
		?>
	</div>
	<div id="loading-footer">
		<style type="text/css">
			@import url('<?php echo $galleryCss; ?>');			
			@import url('<?php echo WP_PLUGIN_URL.'/sliding-youtube-gallery/js/3rdParty/fancybox/jquery.fancybox-1.3.4.css'; ?>');
		</style>		
		<script type="text/javascript">
		jQuery.noConflict();
		jQuery(function($) {
			$('#loading-wrapper').hide();
			$(window).load(function(){
		  		$('#loading-level').fadeOut(2000);
		  		$('#loading-level').remove();
		  		$('#loading-wrapper').show();
		  		$('#loading-wrapper').css("display", "inline");
			});
		});
		</script>
		<script type="text/javascript" src="<?php echo WP_PLUGIN_URL.'/sliding-youtube-gallery/js/3rdParty/fancybox/jquery.fancybox-1.3.4.pack.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo WP_PLUGIN_URL.'/sliding-youtube-gallery/js/3rdParty/fancybox/jquery.easing-1.3.pack.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo WP_PLUGIN_URL.'/sliding-youtube-gallery/js/3rdParty/fancybox/jquery.mousewheel-3.0.4.pack.js'; ?>"></script>
	</div>
</body>
</html>