<?php
/*
 * return html for a video entry in a page
*/
function getPageVideoEntry($videoEntry) {
	// define some dir alias
	$homeRoot = home_url();
	$imgPath = $homeRoot . '/wp-content/plugins/sliding-youtube-gallery/images/';
	$pluginUrl = $homeRoot . '/wp-content/plugins/sliding-youtube-gallery/';

	// get video thumbnails from youtube
	$videoThumbnails = $videoEntry->getVideoThumbnails();
	$video_id = $videoEntry->getVideoId();
	$html .= '<div class="syg_video_page_container" id="'.$video_id.'">';
	$html .= '<table class="video_entry_table">';
	$html .= '<tr>';
	$html .= '<td class="syg_video_page_thumb">';
	$html .= '<a class="sygVideo" href="'. $pluginUrl . 'SygVideo.php'.'?id='.$video_id.'">';
	$html .= (get_option('syg_description_show')) ? '<img src="'.$videoThumbnails[1]['url'].'" class="thumbnail-image" alt="'.$videoEntry->getVideoDescription().'" title="'.$videoEntry->getVideoDescription().'"/>' : '<img src="'.$videoThumbnails[1]['url'].'" class="thumbnail-image" alt="play" title="play"/>';
	// append overlay button
	$syg_thumb_image = get_option('syg_thumbnail_image') != '' ? $imgPath . '/button/play-the-video_'.get_option('syg_thumbnail_image').'.png' : $imgPath .'/images/button/play-the-video_1.png';
	$html .= '<img class="play-icon" src="'.$syg_thumb_image.'" alt="play">';
	// append video duration
	if (get_option('syg_description_showduration')) {
		$duration = Sec2Time($videoEntry->getVideoDuration());
		$video_duration .= ($duration['hours'] > 0) ? $duration['hours'].':' : '';
		$video_duration .= ($duration['minutes'] > 0) ? $duration['minutes'].':' : '0:';
		$video_duration .= str_pad($duration['seconds'], 2, '0', STR_PAD_LEFT);
		$html .= '<span class="video_duration">'.$video_duration.'</span>';
	}
	$html .= '</a>';
	$html .= '</td>';
	$html .= '<td class="syg_video_page_description">';
	$html .= '<h4 class="video_title"><a href="'.$videoEntry->getVideoWatchPageUrl().'" target="_blank">'.$videoEntry->getVideoTitle().'</a></h4>';

	if (get_option('syg_description_show')) {
		$html .= '<p>'.$videoEntry->getVideoDescription().'</p>';
	}

	if (get_option('syg_description_showcategories')) {
		$html .= '<span class="video_categories"><i>Category:</i>&nbsp;&nbsp;';
		$html .= $videoEntry->getVideoCategory();
		$html .= '</span> ';
	}

	if (get_option('syg_description_showtags')) {
		$html .= '<span class="video_tags"><i>Tags:</i>&nbsp;&nbsp;';
		foreach ($videoEntry->getVideoTags() as $key => $value) {
			$html .= $value." | ";
		}
		$html .= '</span>';
	}

	if (get_option('syg_description_showratings')) {
		if ($videoEntry->getVideoRatingInfo()) {
			$html .= '<span class="video_ratings">';
			$rating = $videoEntry->getVideoRatingInfo();
			$html .= "<i>Average:</i>&nbsp;&nbsp;".$rating['average'];
			$html .= '&nbsp;&nbsp;';
			$html .= '<i>Raters:</i>&nbsp;&nbsp;'.$rating['numRaters'];
			$html .= '</span>';
		}else{
			$html .= '<span class="video_ratings">';
			$html .= '<i>Rating not available</i>';
			$html .= '</span>';
		}
	}

	$html .= '</td>';
	$html .= '</tr>';
	$html .= '</table>';
	$html .= '</div>';

	return $html;
}
?>