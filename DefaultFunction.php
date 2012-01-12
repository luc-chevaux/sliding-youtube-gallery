<?php
/* function to mantain the aspect ratio normal
 * when width has been changed
*/
function getHeight($width) {
	$new_height = round($width * 480 / 640);
	return $new_height;
}

/* function to mantain the aspect ratio wide
 * when width has been changed
*/
function getWideHeight($width) {
	$new_height = round($width * 360 / 640);
	return $new_height;
}

/* function to extract type
*/
function extractType($width) {
	$start = 0;
	$stop = strlen($width)-1;
	$type = substr($width, $stop, 1);
	return $type;
}

/* function to extract width
*/
function extractWidth($width) {
	$start = 0;
	$stop = strlen($width)-1;
	$width = substr($width, $start, $stop);
	return $width;
}
?>