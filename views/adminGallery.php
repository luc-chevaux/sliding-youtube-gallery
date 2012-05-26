<?php 	
	$gallery = new SygGallery();
?>
	<form name="form1" method="post" action="">
		<input type="hidden" name=" -- da completare --" value="Y">

		<!-- youtube settings -->
		<fieldset>
			<!-- user -->
			<legend><strong>YouTube settings</strong></legend>
			<label for="syg_youtube_username">YouTube User: </label>
			<input type="text" id="syg_youtube_username" name="syg_youtube_username" value="<?php echo $gallery->getYtUsername(); ?>" size="30">

			<!-- duration -->
			<label for="syg_description_showduration">Duration </label>
			<input type="checkbox" name="syg_description_showduration" id="syg_description_showduration" value="1" <?php if ($gallery->getDescShowDuration()) echo 'checked="checked"';?>>

			<!-- description -->
			<label for="syg_description_show">Description </label>
			<input type="checkbox" name="syg_description_show" id="syg_description_show" value="1" <?php if ($gallery->getDescShow()) echo 'checked="checked"';?>>

			<!-- tags -->
			<label for="syg_description_showtags">Tags </label>
			<input type="checkbox" name="syg_description_showtags" id="syg_description_showtags" value="1" <?php if ($gallery->getDescShowTags()) echo 'checked="checked"';?>>

			<!-- ratings -->
			<label for="syg_description_showratings">Ratings </label>'
			<input type="checkbox" name="syg_description_showratings" id="syg_description_showratings" value="1" <?php if ($gallery->getDescShowRatings()) echo 'checked="checked"';?>>

			<!-- categories -->
			<label for="syg_description_showcategories">Categories </label>
			<input type="checkbox" name="syg_description_showcategories" id="syg_description_showcategories" value="1" <?php if ($gallery->getDescShowCategories()) echo 'checked="checked"';?>>
			
			<br/><br/>

			<!-- video format -->
			<label for="syg_youtube_videoformat">Video Format: </label>
			<select id="'.$syg['yt_videoformat']['opt'].'" name="'.$syg['yt_videoformat']['opt'].'">
				<option value="420n" <?php if ($gallery->getYtVideoFormat() == '420n') echo 'selected="selected"'; ?>>420 X 315 (normal)</option>
				<option value="480n" <?php if ($gallery->getYtVideoFormat() == '480n') echo 'selected="selected"'; ?>>480 X 360 (normal)</option>
				<option value="640n" <?php if ($gallery->getYtVideoFormat() == '640n') echo 'selected="selected"'; ?>>640 X 480 (normal)</option>
				<option value="960n" <?php if ($gallery->getYtVideoFormat() == '960n') echo 'selected="selected"'; ?>>960 X 720 (normal)</option>
				<option value="560w" <?php if ($gallery->getYtVideoFormat() == '560w') echo 'selected="selected"'; ?>>560 X 315 (wide)</option>
				<option value="640w" <?php if ($gallery->getYtVideoFormat() == '640w') echo 'selected="selected"'; ?>>640 X 360 (wide)</option>
				<option value="853w" <?php if ($gallery->getYtVideoFormat() == '853w') echo 'selected="selected"'; ?>>853 X 480 (wide)</option>
				<option value="1280w" <?php if ($gallery->getYtVideoFormat() == '1280w') echo 'selected="selected"'; ?>>1280 X 720 (wide)</option>
			</select>
			
			<!-- video count -->
			<label for="syg_youtube_maxvideocount">Maximum Video Count: </label>
			<input type="text" id="syg_youtube_maxvideocount" name="syg_youtube_maxvideocount" value="<?php echo $gallery->getYtMaxVideoCount(); ?>" size="10">
		</fieldset>
		
		<!-- thumbnail appereance -->
		<fieldset>
			<legend><strong>Thumbnail appereance</strong></legend>
			
			<label for="syg_thumbnail_height">Height: </label>
			<input onchange="calculateNewWidth();" type="text" id="syg_thumbnail_height" name="syg_thumbnail_height" value="<?php echo $gallery->getThumbHeight(); ?>" size="10">
			
			<label for="">Width: </label>
			<input onchange="calculateNewHeight();" type="text" id="syg_thumbnail_width" name="syg_thumbnail_width" value="<?php echo $gallery->getThumbWidth(); ?>" size="10">
			
			<label for="'.$syg['th_bordersize']['opt'].'">Border Size: </label>
			<input type="text" id="'.$syg['th_bordersize']['opt'].'" name="'.$syg['th_bordersize']['opt'].'" value="'.$syg['th_bordersize']['val'].'" size="10">
			
			<br/><br/>

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
<fieldset>';
<legend><strong>Box and description appereance</strong></legend>';
<label for="'.$syg['box_width']['opt'].'">Box width: </label>';
<input type="text" id="'.$syg['box_width']['opt'].'" name="'.$syg['box_width']['opt'].'" value="'.$syg['box_width']['val'].'" size="10">';
<label for="'.$syg['box_radius']['opt'].'">Box Radius: </label>';
<input type="text" id="'.$syg['box_radius']['opt'].'" name="'.$syg['box_radius']['opt'].'" value="'.$syg['box_radius']['val'].'" size="10">';
<label for="'.$syg['box_padding']['opt'].'">Box Padding: </label>';
<input type="text" id="'.$syg['box_padding']['opt'].'" name="'.$syg['box_padding']['opt'].'" value="'.$syg['box_padding']['val'].'" size="10">';
<label for="'.$syg['box_background']['opt'].'">Background color: </label>';
<input onchange="updateColorPicker(\'box_backgroundcolor_selector\',this)" type="text" id="'.$syg['box_background']['opt'].'" name="'.$syg['box_background']['opt'].'" value="'.$syg['box_background']['val'].'" size="10">';
<div id="box_backgroundcolor_selector">';
<div style="background-color: #efefef;"></div>';
</div>';
<br/><br/>';
<label for="'.$syg['desc_fontsize']['opt'].'">Font size: </label>';
<input type="text" id="'.$syg['desc_fontsize']['opt'].'" name="'.$syg['desc_fontsize']['opt'].'" value="'.$syg['desc_fontsize']['val'].'" size="10">';
<label for="'.$syg['desc_fontcolor']['opt'].'">Font color: </label>';
<input onchange="updateColorPicker(\'desc_fontcolor_selector\',this)" type="text" id="'.$syg['desc_fontcolor']['opt'].'" name="'.$syg['desc_fontcolor']['opt'].'" value="'.$syg['desc_fontcolor']['val'].'" size="10">';
<div id="desc_fontcolor_selector">';
<div style="background-color: #333333;"></div>';
</div>';
</fieldset>';

<hr/>';
<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>';
</form>';