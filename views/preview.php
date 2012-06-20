<?php 
	require_once './inc/getWpEnvironment.inc.php';
	require_once './inc/getExtractedGallery.inc.php';
?>
<?php 
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<style type="text/css">
		#loading-level {
		   background: url(../img/ui/loader.gif) no-repeat center center;
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
	<script type="text/javascript" src="../../../../wp-includes/js/jquery/jquery.js"></script>
</head>
<body>
	<div id="loading-level"></div>
	<div id="loading-wrapper">
		<?php 
		$syg->getGallery(array('id' => $id));
		?>
	</div>
	<div id="loading-footer">
		<style type="text/css">
			@import url('<?php echo $view['sygCssUrl_'.$id]; ?>');
			@import url('<?php echo $view['fancybox_css_url']; ?>');
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
		<script type="text/javascript" src="<?php echo $view['fancybox_js_url']; ?>"></script>
		<script type="text/javascript" src="<?php echo $view['easing_js_url']; ?>"></script>
		<script type="text/javascript" src="<?php echo $view['mousewheel_js_url']; ?>"></script>
		<script type="text/javascript" src="<?php echo $view['sygJsUrl_'.$id]; ?>"></script>
	</div>
</body>
</html>