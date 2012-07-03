<?php 
	// include wp loader
	$root = realpath(dirname(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"]))))));
	
	if (file_exists($root.'/wp-load.php')) {
		// WP 2.6
		require_once($root.'/wp-load.php');
	} else {
		// Before 2.6
		require_once($root.'/wp-config.php');
	}
	
	// include required wordpress object
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	require_once( ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygPlugin.php');
?>
<!-- Extra Php Code -->

<!-- User Message -->

<!-- Css Inclusion -->

<!-- Javascript Inclusion -->

<!-- Player -->
<?php 
$id = $_GET['id'];
$video = $_GET['video'];
$syg = SygPlugin::getInstance();
$option = $syg->getGallerySettings($_GET['id']);
extract ($option);

$type = SygUtil::extractType($syg_youtube_videoformat);
$width = SygUtil::extractWidth($syg_youtube_videoformat);

if ($type == 'n') {
	$height = SygUtil::getNormalHeight($width);
} else {
	$height = SygUtil::getWideHeight($width);
}

?>
<iframe class="youtube-box" width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo "http://www.youtube.com/embed/".$video ?>" frameborder="0" allowfullscreen>
</iframe>
