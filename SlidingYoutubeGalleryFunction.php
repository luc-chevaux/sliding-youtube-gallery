<?php
/*
 * add action
 */
add_action('admin_menu', 'SlidingYoutubeGalleryAdmin');
add_action('init', 'check_for_zend_gdata_interfaces');

/*
 * admin hook to wp
 */
function SlidingYoutubeGalleryAdmin() {
	add_options_page('SlidingYoutubeGallery Options', 'SlidingYoutubeGallery', 'manage_options', 'syg-administration-panel', 'sygAdminMain');
}

/*
 * do the option inventory
 */
function optionInventory() {
	$syg = array();
	$syg['yt_user']['opt'] = 'syg_youtube_username';
	$syg['yt_videoformat']['opt'] = 'syg_youtube_videoformat';
	$syg['yt_maxvideocount']['opt'] = 'syg_youtube_maxvideocount';
	$syg['th_height']['opt'] = 'syg_thumbnail_height';
	$syg['th_width']['opt'] = 'syg_thumbnail_width';
	$syg['th_bordersize']['opt'] = 'syg_thumbnail_bordersize';
	$syg['th_bordercolor']['opt'] = 'syg_thumbnail_bordercolor';
	$syg['th_borderradius']['opt'] = 'syg_thumbnail_borderradius';
	$syg['th_distance']['opt'] = 'syg_thumbnail_distance';
	$syg['th_overlaysize']['opt'] = 'syg_thumbnail_overlaysize';
	$syg['th_image']['opt'] = 'syg_thumbnail_image';
	$syg['th_top']['opt'] = 'syg_thumbnail_top';
    $syg['th_left']['opt'] = 'syg_thumbnail_left';
    $syg['th_buttonopacity']['opt'] = 'syg_thumbnail_buttonopacity';
    $syg['box_width']['opt'] = 'syg_box_width';
    $syg['box_background']['opt'] = 'syg_box_background';
    $syg['box_radius']['opt'] = 'syg_box_radius';
    $syg['box_padding']['opt'] = 'syg_box_padding';
    $syg['desc_width']['opt'] = 'syg_description_width';
    $syg['desc_fontcolor']['opt'] = 'syg_description_fontcolor';
    $syg['desc_fontsize']['opt'] = 'syg_description_fontsize';
    $syg['desc_showdescription']['opt'] = 'syg_description_show';
    $syg['desc_showduration']['opt'] = 'syg_description_showduration';
	$syg['desc_showtags']['opt'] = 'syg_description_showtags';
	$syg['desc_showratings']['opt'] = 'syg_description_showratings';
	$syg['desc_showcat']['opt'] = 'syg_description_showcategories'; 
	
    $syg['hiddenfield']['opt'] = 'syg_submit_hidden';
    return $syg;
}

/*
 * function used to get option value
 */
function getOptionValues($syg) {
	foreach ($syg as $key => $value) {
		$syg[$key]['val'] = get_option($value['opt']);
	}
	return $syg;
}

/*
 * function used to get posted value
 */
function getPostedValues($syg) {
	foreach ($syg as $key => $value) {
		$syg[$key]['val'] = $_POST[$value['opt']];
	}
	return $syg;
}

/*
 * function used to update option
 */
function updateOptions($syg) {
	// update generic option
	foreach ($syg as $key => $value) {
		update_option($value['opt'], $value['val']);
	}
	
	// update calculated option
	$img_width = $syg['th_overlaysize']['val'];
    $img_height = $syg['th_overlaysize']['val'];
    
    $perc_occ_w = $img_width / ($syg['th_width']['val'] + ($syg['th_bordersize']['val']*2));
	$syg['th_left']['val'] = 50 - ($perc_occ_w / 2 * 100);
	
	$perc_occ_h = $img_height / ($syg['th_height']['val'] + ($syg['th_bordersize']['val']*2));
	$syg['th_top']['val'] = 50 - ($perc_occ_h / 2 * 100);
		
	update_option($syg['th_top']['opt'], $syg['th_top']['val']);
	update_option($syg['th_left']['opt'], $syg['th_left']['val']);
	
	return $syg;
}

/*
 * function used to generate admin form
 */
function generateSygAdminForm($syg, $updated = false) {
	// check if plugin has updated something
	if ($updated) {
		echo '<div class="updated"><p><strong>Settings saved.</strong></p></div>';
	}
	
	// define some dir alias
	$homeRoot = home_url();
	$cssPath = $homeRoot . '/wp-content/plugins/sliding-youtube-gallery/css/';
	$imgPath = $homeRoot . '/wp-content/plugins/sliding-youtube-gallery/images/';
	$jsPath = $homeRoot . '/wp-content/plugins/sliding-youtube-gallery/js/';
	
	// define css to include
	$cssAdminUrl = $cssPath . 'admin.css';
    $cssColorPicker = $cssPath . 'colorpicker.css';

    // css inclusion
    echo '<style type="text/css">';
	echo '@import url('.$cssAdminUrl.');';
	echo '</style>';
	echo '<style type="text/css">';
	echo '@import url('.$cssColorPicker.');';
	echo '</style>';
	
	// begin admin form section
	echo '<div class="wrap">';
	echo '<div id="icon-options-general" class="icon32"><br/></div><h2>Sliding Youtube Gallery | by <a href="http://blog.webeng.it" target="_new">WebEng</a></h2>';
	echo '<hr/>';
	
	echo SygConstant::BE_WELCOME_MESSAGE;
	
	// begin gallery list section
	echo '<h3>Manage your gallery</h3>';
	echo "<table>";
	
	echo "<th>";
	echo "<td>";
	echo "Gallery ID";
	echo "</td>";
	echo "<td>";
	echo "Gallery User";
	echo "</td>";
	echo "<td>";
	echo "Action";
	echo "</td>";
	echo "</th>";
	
	
	echo "<tr>";
	echo "<td>";
	
	echo "</td>";
	echo "<td>";
	
	echo "</td>";
	echo "<td>";
	
	echo "</td>";
	echo "</tr>";
	
	echo "</table>";
	echo '<p>Here you can set the SlidingYoutubeGallery default behavior.</p>';
	echo '<form name="form1" method="post" action="">';
	echo '<input type="hidden" name="'.$syg['hiddenfield']['opt'].'" value="Y">';
	
	// youtube settings
	echo '<fieldset>';
    echo '<legend><strong>YouTube settings</strong></legend>';
	echo '<label for="'.$syg['yt_user']['opt'].'">YouTube User: </label>';
	echo '<input type="text" id="'.$syg['yt_user']['opt'].'" name="'.$syg['yt_user']['opt'].'" value="'.$syg['yt_user']['val'].'" size="30">';
	echo '<label for="'.$syg['desc_showduration']['opt'].'">Duration </label>';
	$chk_duration = ($syg['desc_showduration']['val'] == "1") ? '<input type="checkbox" name="'.$syg['desc_showduration']['opt'].'" id="'.$syg['desc_showduration']['opt'].'" value="1" checked="checked">' : '<input type="checkbox" name="'.$syg['desc_showduration']['opt'].'" id="'.$syg['desc_showduration']['opt'].'" value="1">'; 
	echo $chk_duration;
	echo '<label for="'.$syg['desc_showdescription']['opt'].'">Description </label>';
	$chk_desc = ($syg['desc_showdescription']['val'] == "1") ? '<input type="checkbox" name="'.$syg['desc_showdescription']['opt'].'" id="'.$syg['desc_showdescription']['opt'].'" value="1" checked="checked">' : '<input type="checkbox" name="'.$syg['desc_showdescription']['opt'].'" id="'.$syg['desc_showdescription']['opt'].'" value="1">';
	echo $chk_desc;
	echo '<label for="'.$syg['desc_showtags']['opt'].'">Tags </label>';
	$chk_tags = ($syg['desc_showtags']['val'] == "1") ? '<input type="checkbox" name="'.$syg['desc_showtags']['opt'].'" id="'.$syg['desc_showtags']['opt'].'" value="1" checked="checked">' : '<input type="checkbox" name="'.$syg['desc_showtags']['opt'].'" id="'.$syg['desc_showtags']['opt'].'" value="1">';
	echo $chk_tags;
	echo '<label for="'.$syg['desc_showratings']['opt'].'">Ratings </label>';
	$chk_showratings = ($syg['desc_showratings']['val'] == "1") ? '<input type="checkbox" name="'.$syg['desc_showratings']['opt'].'" id="'.$syg['desc_showratings']['opt'].'" value="1" checked="checked">' : '<input type="checkbox" name="'.$syg['desc_showratings']['opt'].'" id="'.$syg['desc_showratings']['opt'].'" value="1">';
	echo $chk_showratings;
	echo '<label for="'.$syg['desc_showcat']['opt'].'">Categories </label>';
	$chk_showcat = ($syg['desc_showcat']['val'] == "1") ? '<input type="checkbox" name="'.$syg['desc_showcat']['opt'].'" id="'.$syg['desc_showcat']['opt'].'" value="1" checked="checked">' : '<input type="checkbox" name="'.$syg['desc_showcat']['opt'].'" id="'.$syg['desc_showcat']['opt'].'" value="1">';
	echo $chk_showcat;
	echo "<br/><br/>";
	echo '<label for="'.$syg['yt_videoformat']['opt'].'">Video Format: </label>';
	($syg['yt_videoformat']['val'] == "420n") ? $syg_vf_opt_1 = '<option value="420n" selected="selected">420 X 315 (normal)</option>' : $syg_vf_opt_1 = '<option value="420n">420 X 315 (normal)</option>';
	($syg['yt_videoformat']['val'] == "480n") ? $syg_vf_opt_2 = '<option value="480n" selected="selected">480 X 360 (normal)</option>' : $syg_vf_opt_2 = '<option value="480n">480 X 360 (normal)</option>';
	($syg['yt_videoformat']['val'] == "640n") ? $syg_vf_opt_3 = '<option value="640n" selected="selected">640 X 480 (normal)</option>' : $syg_vf_opt_3 = '<option value="640n">640 X 480 (normal)</option>';
	($syg['yt_videoformat']['val'] == "960n") ? $syg_vf_opt_4 = '<option value="960n" selected="selected">960 X 720 (normal)</option>' : $syg_vf_opt_4 = '<option value="960n">960 X 720 (normal)</option>';
	($syg['yt_videoformat']['val'] == "560w") ? $syg_vf_opt_5 = '<option value="560w" selected="selected">560 X 315 (wide)</option>' : $syg_vf_opt_5 = '<option value="560w">560 X 315 (wide)</option>';
	($syg['yt_videoformat']['val'] == "640w") ? $syg_vf_opt_6 = '<option value="640w" selected="selected">640 X 360 (wide)</option>' : $syg_vf_opt_6 = '<option value="640w">640 X 360 (wide)</option>';
	($syg['yt_videoformat']['val'] == "853w") ? $syg_vf_opt_7 = '<option value="853w" selected="selected">853 X 480 (wide)</option>' : $syg_vf_opt_7 = '<option value="853w">853 X 480 (wide)</option>';
	($syg['yt_videoformat']['val'] == "1280w") ? $syg_vf_opt_8 = '<option value="1280w" selected="selected">1280 X 720 (wide)</option>' : $syg_vf_opt_8 = '<option value="1280w">1280 X 720 (wide)</option>';
	echo '<select id="'.$syg['yt_videoformat']['opt'].'" name="'.$syg['yt_videoformat']['opt'].'">';
	echo $syg_vf_opt_1;
	echo $syg_vf_opt_2;
	echo $syg_vf_opt_3;
	echo $syg_vf_opt_4;
	echo $syg_vf_opt_5;
	echo $syg_vf_opt_6;
	echo $syg_vf_opt_7;
	echo $syg_vf_opt_8;
	echo '</select>';
	echo '<label for="'.$syg['yt_maxvideocount']['opt'].'">Maximum Video Count: </label>';
	echo '<input type="text" id="'.$syg['yt_maxvideocount']['opt'].'" name="'.$syg['yt_maxvideocount']['opt'].'" value="'.$syg['yt_maxvideocount']['val'].'" size="10">';
	echo '</fieldset>';
	
	// thumbnail appereance
	echo '<fieldset>';
	echo '<legend><strong>Thumbnail appereance</strong></legend>';
	echo '<label for="'.$syg['th_height']['opt'].'">Height: </label>';
	echo '<input onchange="calculateNewWidth();" type="text" id="'.$syg['th_height']['opt'].'" name="'.$syg['th_height']['opt'].'" value="'.$syg['th_height']['val'].'" size="10">';
	echo '<label for="'.$syg['th_width']['opt'].'">Width: </label>';
	echo '<input onchange="calculateNewHeight();" type="text" id="'.$syg['th_width']['opt'].'" name="'.$syg['th_width']['opt'].'" value="'.$syg['th_width']['val'].'" size="10">';
	echo '<label for="'.$syg['th_bordersize']['opt'].'">Border Size: </label>';
	echo '<input type="text" id="'.$syg['th_bordersize']['opt'].'" name="'.$syg['th_bordersize']['opt'].'" value="'.$syg['th_bordersize']['val'].'" size="10">';
	echo '<br/><br/>';
	echo '<label for="'.$syg['th_borderradius']['opt'].'">Border Radius: </label>';
	echo '<input type="text" id="'.$syg['th_borderradius']['opt'].'" name="'.$syg['th_borderradius']['opt'].'" value="'.$syg['th_borderradius']['val'].'" size="10">';
	echo '<label for="'.$syg['th_distance']['opt'].'">Distance: </label>';
	echo '<input type="text" id="'.$syg['th_distance']['opt'].'" name="'.$syg['th_distance']['opt'].'" value="'.$syg['th_distance']['val'].'" size="10">';
	echo '<label for="'.$syg['th_bordercolor']['opt'].'">Border Color: </label>';
	echo '<input onchange="updateColorPicker(\'thumb_bordercolor_selector\',this)" type="text" id="'.$syg['th_bordercolor']['opt'].'" name="'.$syg['th_bordercolor']['opt'].'" value="'.$syg['th_bordercolor']['val'].'" size="10">';
	echo '<div id="thumb_bordercolor_selector">';
	echo '<div style="background-color: #333333;"></div>';
	echo '</div>';
	echo '<br/><br/>';
	echo '<label for="'.$syg['th_overlaysize']['opt'].'">Button size: </label>';
	($syg['th_overlaysize']['val'] == "16") ? $syg_to_opt_1 = '<option value="16" selected="selected">16</option>' : $syg_to_opt_1 = '<option value="16">16</option>';
	($syg['th_overlaysize']['val'] == "32") ? $syg_to_opt_2 = '<option value="32" selected="selected">32</option>' : $syg_to_opt_2 = '<option value="32">32</option>';
	($syg['th_overlaysize']['val'] == "64") ? $syg_to_opt_3 = '<option value="64" selected="selected">64</option>' : $syg_to_opt_3 = '<option value="64">64</option>';
	($syg['th_overlaysize']['val'] == "128") ? $syg_to_opt_4 = '<option value="128" selected="selected">128</option>' : $syg_to_opt_4 = '<option value="128">128</option>';
	echo '<select id="'.$syg['th_overlaysize']['opt'].'" name="'.$syg['th_overlaysize']['opt'].'">';
	echo $syg_to_opt_1;
	echo $syg_to_opt_2;
	echo $syg_to_opt_3;
	echo $syg_to_opt_4;
	echo '</select>';
	echo '<label for="'.$syg['th_image']['opt'].'">Image: </label>';
	($syg['th_image']['val'] == 1) ? $syg_ty_opt_1 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="1" checked="checked">' : $syg_ty_opt_1 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="1">';
	($syg['th_image']['val'] == 2) ? $syg_ty_opt_2 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="2" checked="checked">' : $syg_ty_opt_2 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="2">';
	($syg['th_image']['val'] == 3) ? $syg_ty_opt_3 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="3" checked="checked">' : $syg_ty_opt_3 = '<input type="radio" id="'.$syg['th_image']['opt'].'" name="'.$syg['th_image']['opt'].'" value="3">';
	echo $syg_ty_opt_1;
	echo '<img width="32" src="'. $imgPath . '/button/play-the-video_1.png'.'"/>';
	echo $syg_ty_opt_2;
	echo '<img width="32" src="'. $imgPath . '/button/play-the-video_2.png'.'"/>';
	echo $syg_ty_opt_3;
	echo '<img width="32" src="'. $imgPath . '/button/play-the-video_3.png'.'"/>';
	echo '<label for="'.$syg['th_buttonopacity']['opt'].'">Button opacity: </label>';
	echo '<input type="text" id="'.$syg['th_buttonopacity']['opt'].'" name="'.$syg['th_buttonopacity']['opt'].'" value="'.$syg['th_buttonopacity']['val'].'" size="10">';
	echo '</fieldset>';
	
	// javascript inclusion
	$js_url = $jsPath . '/admin.js';
    $js_color_picker = $jsPath . '/colorpicker.js';
	echo '<script type="text/javascript" src="'.$js_url.'"></script>';
	echo '<script type="text/javascript" src="'.$js_color_picker.'"></script>';
	
	// box and description appereance
	echo '<fieldset>';
	echo '<legend><strong>Box and description appereance</strong></legend>';
	echo '<label for="'.$syg['box_width']['opt'].'">Box width: </label>';
	echo '<input type="text" id="'.$syg['box_width']['opt'].'" name="'.$syg['box_width']['opt'].'" value="'.$syg['box_width']['val'].'" size="10">';
	echo '<label for="'.$syg['box_radius']['opt'].'">Box Radius: </label>';
	echo '<input type="text" id="'.$syg['box_radius']['opt'].'" name="'.$syg['box_radius']['opt'].'" value="'.$syg['box_radius']['val'].'" size="10">';
	echo '<label for="'.$syg['box_padding']['opt'].'">Box Padding: </label>';
	echo '<input type="text" id="'.$syg['box_padding']['opt'].'" name="'.$syg['box_padding']['opt'].'" value="'.$syg['box_padding']['val'].'" size="10">';
	echo '<label for="'.$syg['box_background']['opt'].'">Background color: </label>';
	echo '<input onchange="updateColorPicker(\'box_backgroundcolor_selector\',this)" type="text" id="'.$syg['box_background']['opt'].'" name="'.$syg['box_background']['opt'].'" value="'.$syg['box_background']['val'].'" size="10">';
	echo '<div id="box_backgroundcolor_selector">';
	echo '<div style="background-color: #efefef;"></div>';
	echo '</div>';
	echo '<br/><br/>';
	echo '<label for="'.$syg['desc_fontsize']['opt'].'">Font size: </label>';
	echo '<input type="text" id="'.$syg['desc_fontsize']['opt'].'" name="'.$syg['desc_fontsize']['opt'].'" value="'.$syg['desc_fontsize']['val'].'" size="10">';
	echo '<label for="'.$syg['desc_fontcolor']['opt'].'">Font color: </label>';
	echo '<input onchange="updateColorPicker(\'desc_fontcolor_selector\',this)" type="text" id="'.$syg['desc_fontcolor']['opt'].'" name="'.$syg['desc_fontcolor']['opt'].'" value="'.$syg['desc_fontcolor']['val'].'" size="10">';
	echo '<div id="desc_fontcolor_selector">';
	echo '<div style="background-color: #333333;"></div>';
	echo '</div>';
	echo '</fieldset>';
	
	echo '<hr/>';
	echo '<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>';
	echo '</form>';
	echo '</div>';
}

/*
 * main function for admin interface 
 */
function sygAdminMain() {
	// updated flag
	$updated = false;
	
	// check if user has permission to manage options
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
    
	// option inventory
	$syg = optionInventory();
	
    if( isset($_POST[$syg['hiddenfield']['opt']]) && $_POST[$syg['hiddenfield']['opt']] == 'Y' ) {
    	// get posted values
    	$syg = getPostedValues($syg);
    	
        // update options
        $syg = updateOptions($syg);
        
        // updated flag
		$updated = true;
    }else{
    	// get option values
		$syg = getOptionValues($syg);
    }
    
    generateSygAdminForm($syg, $updated);
}

/*
 * convert second to time
 */
function Sec2Time($time){
  if(is_numeric($time)){
    $value = array(
      "years" => 0, "days" => 0, "hours" => 0,
      "minutes" => 0, "seconds" => 0,
    );
    if($time >= 31556926){
      $value["years"] = floor($time/31556926);
      $time = ($time%31556926);
    }
    if($time >= 86400){
      $value["days"] = floor($time/86400);
      $time = ($time%86400);
    }
    if($time >= 3600){
      $value["hours"] = floor($time/3600);
      $time = ($time%3600);
    }
    if($time >= 60){
      $value["minutes"] = floor($time/60);
      $time = ($time%60);
    }
    $value["seconds"] = floor($time);
    return (array) $value;
  }else{
    return (bool) FALSE;
  }
}

/*
 * return html for a video entry in a gallery
 */
function getGalleryVideoEntry($videoEntry) {
	// define some dir alias
	$homeRoot = home_url();
	$imgPath = $homeRoot . '/wp-content/plugins/sliding-youtube-gallery/images/';
	$pluginUrl = $homeRoot . '/wp-content/plugins/sliding-youtube-gallery/';
	
	// get video thumbnails from youtube
	$videoThumbnails = $videoEntry->getVideoThumbnails();
	$video_id = $videoEntry->getVideoId();
	$html .= '<li><a class="sygVideo" href="' . $pluginUrl . 'SygVideo.php'.'?id='.$video_id.'">';
	
	// append video thumbnail
	$html .= (get_option('syg_description_show')) ? '<img src="'.$videoThumbnails[1]['url'].'" class="thumbnail-image" alt="'.$videoEntry->getVideoDescription().'" title="'.$videoEntry->getVideoDescription().'"/>' : '<img src="'.$videoThumbnails[1]['url'].'" class="thumbnail-image" alt="play" title="play"/>';
	// append overlay button
	$syg_thumb_image = get_option('syg_thumbnail_image') != '' ? $imgPath . '/button/play-the-video_' . get_option('syg_thumbnail_image').'.png' : $imgPath . '/images/button/play-the-video_1.png';
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
	// append video title
	$html .= '<span class="video_title">'.$videoEntry->getVideoTitle().'</span>';
	$html .= "</li>";
	
	return $html;
}

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

function getEntireFeed($videoFeed, $counter, $method) {
	$stop = get_option ( 'syg_youtube_maxvideocount' );
	foreach ( $videoFeed as $videoEntry ) {
		if ($method == SYG_METHOD_GALLERY) {
			$html .= getGalleryVideoEntry ($videoEntry);
		} else if ($method == SYG_METHOD_PAGE) {
			$html .= getPageVideoEntry ($videoEntry);
		}
		
		if ($counter >= $stop) {
			break;
		} else {
			$counter ++;
		}
	}

	// See whether we have another set of results
	if ($counter < $stop) {
		try {
			$videoFeed = $videoFeed->getNextFeed ();
		} catch ( Zend_Gdata_App_Exception $e ) {
			return $html;
		}

		if ($videoFeed) {
			$html .= getEntireFeed ( $videoFeed, $counter, $method );
		}
	}
	return $html;
}

/*
 * return html for a sliding video gallery
 */
function getSygVideoGallery() {
	// variables for the field and option names
	$username = get_option ( 'syg_youtube_username' );
	$yt = new Zend_Gdata_YouTube ();
	$yt->setMajorProtocolVersion ( 2 );
	$videoFeed = $yt->getuserUploads ( $username );
	$html = '<div id="syg_video_gallery"><div class="sc_menu">';
	$html .= '<ul class="sc_menu">';
	$html .= getEntireFeed ( $videoFeed, 1, SYG_METHOD_GALLERY );
	$html .= '</ul>';
	$html .= '</div></div>';

	return $html;
}

/*
 * return html for a video page
*/
function getSygVideoPage() {
	// variables for the field and option names
	$username = get_option('syg_youtube_username');
	$yt = new Zend_Gdata_YouTube();
	$yt->setMajorProtocolVersion(2);
	$videoFeed = $yt->getuserUploads($username);
	$html  = '<div id="syg_video_page">';
	$html .= getEntireFeed ( $videoFeed, 1, SYG_METHOD_PAGE );
	$html .= '</div>';

	return $html;
}

/*
 * check for zend gdata interface
 */
function check_for_zend_gdata_interfaces() {
	if (defined('WP_ZEND_GDATA_INTERFACES') && constant('WP_ZEND_GDATA_INTERFACES')) {
		$paths = explode(PATH_SEPARATOR, get_include_path());
		foreach ($paths as $path) {
			if (file_exists("$path/Zend/Loader.php")) {
				define('WP_ZEND_GDATA_INTERFACES', true);
				return true;
	    	}else{
	    		return false;
	    	}
		}
	}else{
		define('WP_ZEND_GDATA_INTERFACES', false);
		add_action( 'admin_notices', 'zend_gdata_not_found' );
	}
}

function zend_gdata_not_found() {
	echo "<div id=\"message\" class=\"error\">Error: You must install and activate Zend GData Interfaces before running Sliding YouTube Gallery.</div>";
}
?>