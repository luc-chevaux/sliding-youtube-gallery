<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 	
	$style = $this->data['style'];
?>

<!-- User Message -->
<?php if ($this->data['updated']) {?>
	<div class="updated"><p><strong>Settings saved.</strong></p></div>
<?php } ?>

<?php if ($this->data['exception']) {?>
	<div class="error">
		<p>
			<strong><?php echo $this->data['exception_message']; ?></strong>
			<ul>
				<?php foreach ($this->data['exception_detail'] as $problem) { ?>
					<li><?php echo $problem['field'].' - '.$problem['msg']; ?></li>
				<?php }?>
			</ul>
		</p>
	</div>
<?php } ?>

<!-- Css Inclusion -->
<style type="text/css">
@import url('<?php echo $this->data['cssAdminUrl']; ?>');
@import url('<?php echo $this->data['cssColorPicker']; ?>');
</style>

<!-- Title Page -->
<div class="wrap">
	<div id="icon-options-general" class="icon32">
	<br/>
</div>
<h2 class="webengTitle"><a href="http://blog.webeng.it" target="_new" class="webengRed noDecoration">webEng</a> :: Sliding Youtube Gallery</h2><span><?php echo SygConstant::BE_SUPPORT_PAGE.' | '.SygConstant::BE_DONATION_CODE; ?></span>
<hr/>

<!-- Welcome Message -->
<p class="webengText">
	<?php echo SygConstant::BE_MANAGE_GALLERY_MESSAGE; ?>
</p>

<!-- Gallery Form -->
<form name="form1" method="post" action="">
	<input type="hidden" name="syg_submit_hidden" value="Y">
	<input type="hidden" name="id" id="id" value="<?php echo $style->getId(); ?>">

	<!-- Define your new style -->
	<fieldset>
		<legend>Define your new style</legend>
		
		<!-- style name -->
		<label for="syg_style_name"><strong>Name</strong></label>
		<input type="text" id="syg_style_name" name="syg_style_name" value="<?php echo $style->getStyleName(); ?>" size="15"/>
		
		<!-- style details -->
		<label for="syg_style_details"><strong>Details</strong></label>
		<input type="text" id="syg_style_details" name="syg_style_details" value="<?php echo $style->getStyleDetails(); ?>" size="50"/>
	</fieldset>
	
	<!-- thumbnail appereance -->
	<fieldset>
		<legend><strong>Thumbnail appereance</strong></legend>
		
		<!-- thumbnail height -->
		<label for="syg_thumbnail_height">Height: </label>
		<input type="text" id="syg_thumbnail_height" name="syg_thumbnail_height" value="<?php echo $style->getThumbHeight(); ?>" size="3"/>
		
		<!-- thumbnail width -->
		<label for="syg_thumbnail_width">Width: </label>
		<input type="text" id="syg_thumbnail_width" name="syg_thumbnail_width" value="<?php echo $style->getThumbWidth(); ?>" size="3"/>
		
		<!-- thumbnail bordersize -->
		<label for="syg_thumbnail_bordersize">Border Size: </label>
		<input type="text" id="syg_thumbnail_bordersize" name="syg_thumbnail_bordersize" value="<?php echo $style->getThumbBorderSize(); ?>" size="3"/>
	
		<!-- thumbnail borderradius -->
		<label for="syg_thumbnail_borderradius">Border Radius: </label>
		<input type="text" id="syg_thumbnail_borderradius" name="syg_thumbnail_borderradius" value="<?php echo $style->getThumbBorderRadius(); ?>" size="3"/>
		
		<!-- distance -->
		<label for="syg_thumbnail_distance">Distance: </label>
		<input type="text" id="syg_thumbnail_distance" name="syg_thumbnail_distance" value="<?php echo $style->getThumbDistance(); ?>" size="3"/>
		
		<!-- border color -->
		<label for="syg_thumbnail_bordercolor">Border Color: </label>
		<input onchange="updateColorPicker(\'thumb_bordercolor_selector\',this)" type="hidden" id="syg_thumbnail_bordercolor" name="syg_thumbnail_bordercolor" value="<?php echo $style->getThumbBorderColor(); ?>" size="5"/>
		
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
			<option value="16" <?php if ($style->getThumbOverlaySize() == '16') echo 'selected="selected"'; ?>>16</option>
			<option value="32" <?php if ($style->getThumbOverlaySize() == '32') echo 'selected="selected"'; ?>>32</option>
			<option value="64" <?php if ($style->getThumbOverlaySize() == '64') echo 'selected="selected"'; ?>>64</option>
			<option value="128" <?php if ($style->getThumbOverlaySize() == '128') echo 'selected="selected"'; ?>>128</option>
		</select>
	
		<!-- overlay button image -->
		<label for="syg_thumbnail_image">Image: </label>
		<input type="radio" id="syg_thumbnail_image" name="syg_thumbnail_image" value="1" <?php if ($style->getThumbImage() == 1) echo 'checked="checked"'; ?>/>
		<img width="32" src="<?php echo $this->data['imgPath'] . '/button/play-the-video_1.png'; ?>"/>
		<input type="radio" id="syg_thumbnail_image" name="syg_thumbnail_image" value="2" <?php if ($style->getThumbImage() == 2) echo 'checked="checked"'; ?>/>
		<img width="32" src="<?php echo $this->data['imgPath'] . '/button/play-the-video_2.png'; ?>"/>	
		<input type="radio" id="syg_thumbnail_image" name="syg_thumbnail_image" value="3" <?php if ($style->getThumbImage() == 3) echo 'checked="checked"'; ?>/>
		<img width="32" src="<?php echo $this->data['imgPath'] . '/button/play-the-video_3.png'; ?>"/>
		
		<!-- overlay button opacity -->
		<label for="syg_thumbnail_buttonopacity">Button opacity: </label>
		<input type="text" id="syg_thumbnail_buttonopacity" name="syg_thumbnail_buttonopacity" value="<?php echo $style->getThumbButtonOpacity(); ?>" size="5"/>
	</fieldset>

	<!-- box and description appereance -->
	<fieldset>
		<legend><strong>Box and description appereance</strong></legend>
		
		<!-- box width -->
		<label for="syg_box_width">Box width: </label>
		<input type="text" id="syg_box_width" name="syg_box_width" value="<?php echo $style->getBoxWidth(); ?>" size="5"/>
	
		<!-- box radius -->
		<label for="syg_box_radius">Box Radius: </label>
		<input type="text" id="syg_box_radius" name="syg_box_radius" value="<?php echo $style->getBoxRadius(); ?>" size="5"/>
	
		<!-- box padding -->
		<label for="syg_box_padding">Box Padding: </label>
		<input type="text" id="syg_box_padding" name="syg_box_padding" value="<?php echo $style->getBoxPadding(); ?>" size="5"/>
	
		<!-- background color -->
		<label for="syg_box_background">Background color: </label>
		<input onchange="updateColorPicker(\'box_backgroundcolor_selector\',this)" type="hidden" id="syg_box_background" name="syg_box_background" value="<?php echo $style->getBoxBackground(); ?>" size="5"/>
	
		<div id="box_backgroundcolor_selector">
			<div style="background-color: #efefef;"></div>
		</div>
	
		<br/><br/>
	
		<!-- description font size -->
		<label for="syg_description_fontsize">Font size: </label>
		<input type="text" id="syg_description_fontsize" name="syg_description_fontsize" value="<?php echo $style->getDescFontSize(); ?>" size="5"/>
		
		<!-- description font color -->
		<label for="syg_description_fontcolor">Font color: </label>
		<input onchange="updateColorPicker(\'desc_fontcolor_selector\',this)" type="hidden" id="syg_description_fontcolor" name="syg_description_fontcolor" value="<?php echo $style->getDescFontColor(); ?>" size="5"/>
		
		<div id="desc_fontcolor_selector">
			<div style="background-color: #333333;"></div>
		</div>
	</fieldset>
	<hr/>
	<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>
</form>

<!-- plugin Menu -->
<?php include 'inc/contextMenu.inc.php'; ?>