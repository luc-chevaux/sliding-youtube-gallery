<div id="syg_video_gallery">
	<div class="sc_menu">
		<ul class="sc_menu">
			<!-- gallery code -->
			<li>
			<a class="sygVideo" href="' . $pluginUrl . 'SygVideo.php'.'?id='.$video_id.'">
	
			// append video thumbnail
			(get_option('syg_description_show')) ? 
			
			<img src="'.$videoThumbnails[1]['url'].'" class="thumbnail-image" alt="'.$videoEntry->getVideoDescription().'" title="'.$videoEntry->getVideoDescription().'"/>
			<!-- o -->
			<img src="'.$videoThumbnails[1]['url'].'" class="thumbnail-image" alt="play" title="play"/>
			
			// append overlay button
			$syg_thumb_image = get_option('syg_thumbnail_image') != '' ? 
			
			$imgPath . '/button/play-the-video_' . get_option('syg_thumbnail_image').'.png'
			$imgPath . '/images/button/play-the-video_1.png';
		
			$html .= '<img class="play-icon" src="'.$syg_thumb_image.'" alt="play">';
			
			// append video duration
			if (get_option('syg_description_showduration')) {
				$duration = Sec2Time($videoEntry->getVideoDuration());
				$video_duration .= ($duration['hours'] > 0) ? $duration['hours'].':' : '';
				$video_duration .= ($duration['minutes'] > 0) ? $duration['minutes'].':' : '0:';
				$video_duration .= str_pad($duration['seconds'], 2, '0', STR_PAD_LEFT);
				$html .= '<span class="video_duration">'.$video_duration.'</span>';
			}
			
			</a>

			// append video title
			<span class="video_title">'.$videoEntry->getVideoTitle().'</span>
			</li>
		</ul>
	</div>
</div>