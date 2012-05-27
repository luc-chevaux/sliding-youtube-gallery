<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 	
	$gallery = $this->data['gallery'];
?>

<!-- User Message -->
<?php if ($this->data['updated']) {?>
	<div class="updated"><p><strong>Settings saved.</strong></p></div>
<?php } ?>

<!-- Css Inclusion -->
<style type="text/css">
@import url('<?php echo $this->data['cssAdminUrl']; ?>');
@import url('<?php echo $this->data['cssColorPicker']; ?>');
</style>

<!-- Javascript Inclusion -->
<script type="text/javascript" src="<?php echo $this->data['jsAdminUrl']; ?>"></script>
<script type="text/javascript" src="<?php echo $this->data['jsColorPickerUrl']; ?>"></script>

<!-- Title Page -->
<div class="wrap">
	<div id="icon-options-general" class="icon32">
	<br/>
</div>
<h2 class="webengTitle"><a href="http://blog.webeng.it" target="_new" class="webengRed noDecoration">webEng</a> :: Sliding Youtube Gallery</h2><span><?php echo SygConstant::BE_SUPPORT_PAGE.' | '.SygConstant::BE_DONATION_CODE; ?></span>
<hr/>

<!-- Welcome Message -->
<p class="webengText">
	<?php echo SygConstant::BE_WELCOME_MESSAGE; ?>
</p>

<!-- Gallery Form -->
<form name="form1" method="post" action="">
	<input type="hidden" name="syg_submit_hidden" value="Y">

	<!-- youtube settings -->
	<fieldset>
		<!-- user -->
		<legend><strong>YouTube settings</strong></legend>
		<label for="syg_youtube_username">YouTube User: </label>
		<input type="text" id="syg_youtube_username" name="syg_youtube_username" value="<?php echo $gallery->getYtUsername(); ?>" size="30">
				
		<br/><br/>

		<!-- video format -->
		<label for="syg_youtube_videoformat">Video Format: </label>
		<select id="syg_youtube_videoformat" name="syg_youtube_videoformat">
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
	
	<!-- description appereance -->
	<fieldset>
		<legend><strong>Meta Information</strong></legend>
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
		<label for="syg_description_showratings">Ratings </label>
		<input type="checkbox" name="syg_description_showratings" id="syg_description_showratings" value="1" <?php if ($gallery->getDescShowRatings()) echo 'checked="checked"';?>>

		<!-- categories -->
		<label for="syg_description_showcategories">Categories </label>
		<input type="checkbox" name="syg_description_showcategories" id="syg_description_showcategories" value="1" <?php if ($gallery->getDescShowCategories()) echo 'checked="checked"';?>>
	</fieldset>
	
	<!-- thumbnail appereance -->
	<fieldset>
		<legend><strong>Thumbnail appereance</strong></legend>
		
		<!-- thumbnail height -->
		<label for="syg_thumbnail_height">Height: </label>
		<input onchange="calculateNewWidth();" type="text" id="syg_thumbnail_height" name="syg_thumbnail_height" value="<?php echo $gallery->getThumbHeight(); ?>" size="10">
		
		<!-- thumbnail width -->
		<label for="">Width: </label>
		<input onchange="calculateNewHeight();" type="text" id="syg_thumbnail_width" name="syg_thumbnail_width" value="<?php echo $gallery->getThumbWidth(); ?>" size="10">
		
		<!-- thumbnail bordersize -->
		<label for="syg_thumbnail_bordersize">Border Size: </label>
		<input type="text" id="syg_thumbnail_bordersize" name="syg_thumbnail_bordersize" value="<?php echo $gallery->getThumbBorderSize(); ?>" size="10">
		
		<br/><br/>

		<!-- thumbnail borderradius -->
		<label for="syg_thumbnail_borderradius">Border Radius: </label>
		<input type="text" id="syg_thumbnail_borderradius" name="syg_thumbnail_borderradius" value="<?php echo $gallery->getThumbBorderRadius(); ?>" size="10">
		
		<!-- distance -->
		<label for="syg_thumbnail_distance">Distance: </label>
		<input type="text" id="syg_thumbnail_distance" name="syg_thumbnail_distance" value="<?php echo $gallery->getThumbDistance(); ?>" size="10">
		
		<!-- border color -->
		<label for="syg_thumbnail_bordercolor">Border Color: </label>
		<input onchange="updateColorPicker(\'thumb_bordercolor_selector\',this)" type="hidden" id="syg_thumbnail_bordercolor" name="syg_thumbnail_bordercolor" value="<?php echo $gallery->getThumbBorderColor(); ?>" size="10">
		
		<!-- color picker -->
		<div id="thumb_bordercolor_selector">
		<div style="background-color: #333333;"></div>
		</div>
		
		<br/><br/>
	</fieldset>
	
	<fieldset>
		<legend><strong>Play Button Appereance</strong></legend>
		<!-- button size -->
		<label for="syg_thumbnail_overlaysize">Button size: </label>
			<select id="syg_thumbnail_overlaysize" name="syg_thumbnail_overlaysize">
			<option value="16" <?php if ($gallery->getThumbOverlaySize() == '16') echo 'selected="selected"'; ?>>16</option>
			<option value="32" <?php if ($gallery->getThumbOverlaySize() == '32') echo 'selected="selected"'; ?>>32</option>
			<option value="64" <?php if ($gallery->getThumbOverlaySize() == '64') echo 'selected="selected"'; ?>>64</option>
			<option value="128" <?php if ($gallery->getThumbOverlaySize() == '128') echo 'selected="selected"'; ?>>128</option>
		</select>

		<!-- overlay button image -->
		<label for="syg_thumbnail_image">Image: </label>
		<input type="radio" id="syg_thumbnail_image" name="syg_thumbnail_image" value="1" <?php if ($gallery->getThumbImage() == 1) echo 'checked="checked"'; ?>>
		<img width="32" src="<?php echo $this->data['imgPath'] . '/button/play-the-video_1.png'; ?>"/>
		<input type="radio" id="syg_thumbnail_image" name="syg_thumbnail_image" value="2" <?php if ($gallery->getThumbImage() == 2) echo 'checked="checked"'; ?>>
		<img width="32" src="<?php echo $this->data['imgPath'] . '/button/play-the-video_2.png'; ?>"/>	
		<input type="radio" id="syg_thumbnail_image" name="syg_thumbnail_image" value="3" <?php if ($gallery->getThumbImage() == 3) echo 'checked="checked"'; ?>>
		<img width="32" src="<?php echo $this->data['imgPath'] . '/button/play-the-video_3.png'; ?>"/>
		
		<!-- overlay button opacity -->
		<label for="syg_thumbnail_buttonopacity">Button opacity: </label>
		<input type="text" id="syg_thumbnail_buttonopacity" name="syg_thumbnail_buttonopacity" value="<?php echo $gallery->getThumbButtonOpacity(); ?>" size="10">
	</fieldset>

	<!-- box and description appereance -->
	<fieldset>
		<legend><strong>Box and description appereance</strong></legend>
	
		<!-- box width -->
		<label for="syg_box_width">Box width: </label>
		<input type="text" id="syg_box_width" name="syg_box_width" value="<?php echo $gallery->getBoxWidth(); ?>" size="10">
	
		<!-- box radius -->
		<label for="syg_box_radius">Box Radius: </label>
		<input type="text" id="syg_box_radius" name="syg_box_radius" value="<?php echo $gallery->getBoxRadius(); ?>" size="10">

		<!-- box padding -->
		<label for="syg_box_padding">Box Padding: </label>
		<input type="text" id="syg_box_padding" name="syg_box_padding" value="<?php echo $gallery->getBoxPadding(); ?>" size="10">

		<!-- background color -->
		<label for="syg_box_background">Background color: </label>
		<input onchange="updateColorPicker(\'box_backgroundcolor_selector\',this)" type="hidden" id="syg_box_background" name="syg_box_background" value="<?php echo $gallery->getBoxBackground(); ?>" size="10">

		<div id="box_backgroundcolor_selector">
			<div style="background-color: #efefef;"></div>
		</div>
	
		<br/><br/>

		<!-- description font size -->
		<label for="syg_description_fontsize">Font size: </label>
		<input type="text" id="syg_description_fontsize" name="syg_description_fontsize" value="<?php echo $gallery->getDescFontSize(); ?>" size="10">
		
		<!-- description font color -->
		<label for="syg_description_fontcolor">Font color: </label>
		<input onchange="updateColorPicker(\'desc_fontcolor_selector\',this)" type="hidden" id="syg_description_fontcolor" name="syg_description_fontcolor" value="<?php echo $gallery->getDescFontColor(); ?>" size="10">
		
		<div id="desc_fontcolor_selector">
			<div style="background-color: #333333;"></div>
			</div>
	</fieldset>
	<hr/>
	<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>
</form>