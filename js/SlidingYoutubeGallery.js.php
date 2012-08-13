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

// include required wordpress object
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( ABSPATH . 'wp-content/plugins/sliding-youtube-gallery/engine/SygPlugin.php');

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

$width += 20;
$height += 20;

?>
    
jQuery.noConflict();

(function($){
	/**
	 * function applied to selector
	 *
	 * $.fn.calculateNewWidth = function() {
	 * return true;
	 * };
	 */
	
	$.extend({
		
		/**
		 * function to display splash image
		 */
		displayLoad : function () {
			$('table[class^=video_entry_table-]').remove();
			$('#syg_video_container').css('height', '100px');
			$('#syg_video_container #hook').fadeIn(900,0);			
		},
	
		/**
		 * function to hide splash image
		 */
		hideLoad : function () {
			$('#syg_video_container #hook').fadeOut('fast');
			$('#syg_video_container').css('height', 'auto');
		},
		
		/* 
		 * function that loads the data in the table
		 */ 
		loadData : function (data) {
			data = $.parseJSON(JSON.stringify(data));
			var html;
			
			$('table[class^=video_entry_table-]').remove();
		
			$.hideLoad();
			$.each(data, function(key, val) {
				html = '<table class="video_entry_table-<?php echo $_GET['id'];?>">';
				html = html + '<tr>';
				
				html = html + '<td class="syg_video_page_thumb-<?php echo $_GET['id'];?>">';
				html = html + '<a class="sygVideo" href="<?php echo $syg->getPluginRoot(); ?>views/player.php?id=<?php echo $_GET['id'];?>&video=' + val.video_id + '">';
				<?php if ($syg_description_show) { ?>
					html = html + '<img src="' + val.video_thumbshot + '" class="thumbnail-image-<?php echo $_GET['id'];?>" alt="' + val.video_description + '" title="' + val.video_description + '"/>';
				<?php } else { ?>
					html = html + '<img src="<?php echo $videoThumbnails[1]['url']; ?>" class="thumbnail-image-<?php echo $_GET['id'];?>" alt="play" title="play"/>';
				<?php }?>
				
				<?php 
				$thumbImage = $option['syg_thumbnail_image'];
				$overlayButtonSrc = (!empty($thumbImage)) ? $syg->getImgRoot() . '/button/play-the-video_' . $thumbImage .'.png' : $syg->getImgRoot() . '/button/play-the-video_1.png';
				?>
				
				html = html + '<img class="play-icon-<?php echo $_GET['id'];?>" src="<?php echo $overlayButtonSrc; ?>" alt="play">';
				
				<?php if ($syg_description_showduration) { ?>
					html = html + '<span class="video_duration-<?php echo $_GET['id']; ?>">' + val.video_duration + '</span>';
				<?php } ?>
				html = html + '</a>';
				html = html + '</td>';
				
				html = html + '<td class="syg_video_page_description">';
				html = html + '<h4 class="video_title-<?php echo $_GET['id']; ?>"><a href="' + val.video_watch_page_url + '" target="_blank">' + val.video_title + '</a></h4>';
				<?php if ($syg_description_show) { ?>
					html = html + '<p>' + val.video_description + '</p>';
				<?php }?>
					
				<?php if ($syg_description_showcategories) { ?>
					html = html + '<span class="video_categories"><i>Category:</i>&nbsp;&nbsp; ' + val.video_category + '</span>';
				<?php } ?>
				<?php if ($syg_description_showtags) { ?>
					html = html + '<span class="video_tags"><i>Tags:</i>&nbsp;&nbsp;';
					tags = val.video_tags;
					for(var i in tags) {
    					html = html + tags[i] + ' | '; 
					}
					html = html + '</span>';
				<?php } ?>
				<?php if ($syg_description_showratings) { ?>
						rating = val.video_ratings;
						if (rating) {
							html = html + '<span class="video_ratings">';
							html = html + '<i>Average:</i>&nbsp;&nbsp;' + rating['average'];
							html = html + '&nbsp;&nbsp;';
							html = html + '<i>Raters:</i>&nbsp;&nbsp;' + rating['numraters'];
							html = html + '</span>';
						} else {
							html = html + '<span class="video_ratings">';
							html = html + '<i>Rating not available</i>';
							html = html + '</span>';
						}
				<?php } ?>
				html = html + '</td>';
				html = html + '</tr>';
				html = html + '</table>';
				
				$('#syg_video_container #hook').after(html);
			});
			
			// add fancybox
			$.addFancyBoxSupport();
		},
		  
		/**
		 * function that add pagination event per table
		 */
		addPaginationClickEvent : function () {
			// add galleries pagination click event
			
			/* top pagination */
			$('#pagination-top-<?php echo $_GET['id']; ?> li').click(function(){
				
				$.displayLoad();
				// css styles
				$('#pagination-top-<?php echo $_GET['id']; ?> li')
					.attr({'class' : 'other_page'});
				
				var buttonPressed = $(this).attr('id');
				var button =  buttonPressed.replace('top-','');
				
				$('#top-' + button).attr({'class' : 'current_page'});
				
				// loading data
				var pageNum = button;
				$.getJSON('<?php echo $syg->getJsonQueryIfUrl(); ?>?query=videos&page_number=' + pageNum + '&id=<?php echo $_GET['id']?>', function (data) {$.loadData(data);});
			});
			
			/* bottom pagination */
			$('#pagination-bottom-<?php echo $_GET['id']; ?> li').click(function(){
				
				$.displayLoad();
				// css styles
				$('#pagination-bottom-<?php echo $_GET['id']; ?> li')
					.attr({'class' : 'other_page'});
				
				var buttonPressed = $(this).attr('id');
				var button =  buttonPressed.replace('bottom-','');
				
				$('#bottom-' + button).attr({'class' : 'current_page'});
				
				// loading data
				var pageNum = button;
				$.getJSON('<?php echo $syg->getJsonQueryIfUrl(); ?>?query=videos&page_number=' + pageNum + '&id=<?php echo $_GET['id']?>', function (data) {$.loadData(data);});
			});
		},
		
		/**
		 * function that add pagination event per table
		 */
		addFancyBoxSupport : function () {
			// add fancybox to each sygVideo css class
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
		},
		
		getQParam : function (name) {
			name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
			var regexS = "[\\?&]" + name + "=([^&#]*)";
			var regex = new RegExp(regexS);
			var results = regex.exec(window.location.search);
			if(results == null)
				return "";
			else
				return decodeURIComponent(results[1].replace(/\+/g, " "));
			}
		});
})(jQuery);

/************************************************
 # jQuery on ready function:					#
 # load fancybox and visual effects				# 
 ************************************************/ 

jQuery(document).ready(function($){	
	// load if page contains a list
	if ($('#syg_video_container').length){
		/* video page */
		// loading images
		$.displayLoad();
		
		// get the data
		$.getJSON('<?php echo $syg->getJsonQueryIfUrl(); ?>?query=videos&page_number=1&id=<?php echo $_GET['id']; ?>', function (data) {$.loadData(data);});
		
		// add pagination events
		$.addPaginationClickEvent();
	} else {
		/* video gallery */
		$.addFancyBoxSupport();
	}
});  