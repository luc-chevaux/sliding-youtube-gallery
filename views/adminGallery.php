<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 	
	$gallery = $this->data['gallery'];
	$styles = $this->data['styles'];
?>

<!-- User Message -->
<?php if ($this->data['updated']) {?>
	<div class="updated"><p><strong>Settings saved.</strong></p></div>
<?php } ?>

<?php if ($this->data['exception']) {?>
	<div class="error"><p><strong><?php echo $this->data['exception_message']; ?></strong></p></div>
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
	<input type="hidden" name="id" id="id" value="<?php echo $gallery->getId(); ?>">
	
	<!-- youtube settings -->
	<fieldset>
		Based on channel feed <input type="radio" name="linguaggio" value="html"/>
  		Based on video list <input type="radio" name="linguaggio" value="css"/>
  
  		<br/><br/>
  		
		<!-- user -->
		<legend><strong>YouTube settings</strong></legend>
		<label for="syg_youtube_username">YouTube User: </label><br/>
		<input type="text" id="syg_youtube_username" name="syg_youtube_username" value="<?php echo $gallery->getYtUsername(); ?>" size="30">
		
		<br/><br/>
		
		<!-- video list -->
		<label for="syg_youtube_username">Video list: </label><br/>
		<textarea rows="5" cols="70" id="syg_youtube_videolist" name="syg_youtube_videolist" value=""></textarea>
				
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
		<legend><strong>Select your style</strong></legend>
		<!-- style -->
		<label for="syg_style_id">Style </label>
		<select name="syg_style_id" id="syg_style_id">
			<?php foreach ($styles as $style) { ?>
				<option value="<?php echo $style->getId(); ?>" <?php if ($style->getId() == $gallery->getStyleId()) echo 'selected="selected"'; ?>><?php echo $style->getStyleName(); ?></option>
			<?php } ?>
		</select>
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
	<hr/>
	<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>
</form>
<!-- plugin Menu -->
<?php include 'inc/contextMenu.inc.php'; ?>