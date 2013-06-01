<?php 
$gallery_id = $_GET['gallery_id'];
$syg = SygPlugin::getInstance();
$option = $syg->getGallerySettings($gallery_id);

extract ($option);
$type = SygUtil::extractType($syg_youtube_videoformat);
$width = SygUtil::extractWidth($syg_youtube_videoformat);

if ($type == 'n') {
	$height = SygUtil::getNormalHeight($width);
} else {
	$height = SygUtil::getWideHeight($width);
}

$view = $syg->getViewCtx($gallery_id);

?>