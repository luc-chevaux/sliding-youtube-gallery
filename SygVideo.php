<?php 
// include zend loader

// include zend loader
$root = realpath(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"])))));
if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
} else {
	// Before 2.6
	require_once($root.'/wp-config.php');
}

// include default values
include('./DefaultValues.php');
// include default function
include('./DefaultFunction.php');
$id = $_GET['id'];

$type = extractType($syg_youtube_videoformat);
$width = extractWidth($syg_youtube_videoformat);

if ($type == 'n') {
	$height = getHeight($width);
} else {
	$height = getWideHeight($width);
}

?>
<iframe class="youtube-box" width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo "http://www.youtube.com/embed/".$id ?>" frameborder="0" allowfullscreen>
</iframe>
