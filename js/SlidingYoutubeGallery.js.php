<?php
// set header type
header('Content-type: text/javascript');
// include zend loader
$root = realpath(dirname(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"]))))));
if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
} else {
	// Before 2.6
	require_once($root.'/wp-config.php');
}
// include default values
include('../DefaultValues.php');
// include default function
include('../DefaultFunction.php');

$type = SygUtil::extractType($syg_youtube_videoformat);
$width = SygUtil::extractWidth($syg_youtube_videoformat);

if ($type == 'n') {
	$height = SygUtil::getNormalHeight($width);
} else {
	$height = SygUtil::getWideHeight($width);
}
$width += 20;
$height += 20;
?>

jQuery.noConflict();

jQuery(function($){
	//Get our elements for faster access and set overlay width
	var div = $('div.sc_menu'),
		ul = $('ul.sc_menu'),
		ulPadding = 15;
	
	//Get menu width
	var divWidth = div.width();

	//Remove scrollbars	
	div.css({overflow: 'hidden'});
	
	//Find last image container
	var lastLi = ul.find('li:last-child');
	
	//When user move mouse over menu
	div.mousemove(function(e){
		//As images are loaded ul width increases,
		//so we recalculate it each time
		var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;	
		var left = (e.pageX - div.offset().left) * (ulWidth-divWidth) / divWidth;
		div.scrollLeft(left);
	});
});

jQuery(document).ready(function($){
        $(".sygVideo").fancybox({
             'width' : <?php echo $width; ?>,  
             'height' : <?php echo $height; ?>,
             'autoScale' : true,  
             'transitionIn' : 'none',  
             'transitionOut' : 'none',  
             'type' : 'iframe',  
             'hideOnOverlayClick' : false,
	     	 'autoDimensions' : false,
	     	 'padding' : 0
         });  
    });  
