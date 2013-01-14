<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 	
	$gallery = $this->data['gallery'];
	$styles = $this->data['styles'];
?>

<!-- Css Inclusion -->
<style type="text/css">
@import url('<?php echo $this->data['cssAdminUrl']; ?>');
@import url('<?php echo $this->data['cssColorPicker']; ?>');
</style>

<!-- Title Page -->
<div class="wrap">
	<?php require_once 'inc/header.inc.php'; ?>
	<div id="syg-plugin-area">
		
		<!-- User Message -->
		<?php include 'inc/statusBar.inc.php'; ?>
	
		<!-- Gallery Form -->
		<form name="form1" method="post" action="">
			<input type="hidden" name="syg_submit_hidden" value="Y"/>
			<input type="hidden" name="id" id="id" value="<?php echo $gallery->getId(); ?>"/>
			
			<!-- Define your new gallery -->
			<fieldset>
				<legend>Define your new gallery</legend>
				
				<!-- style name -->
				<label for="syg_gallery_name"><strong>Name</strong></label>
				<input type="text" id="syg_gallery_name" name="syg_gallery_name" value="<?php echo $gallery->getGalleryName(); ?>" size="15"/>
				
				<!-- style details -->
				<label for="syg_gallery_details"><strong>Details</strong></label>
				<input type="text" id="syg_gallery_details" name="syg_gallery_details" value="<?php echo $gallery->getGalleryDetails(); ?>" size="50"/>
			</fieldset>
			
			<!-- youtube settings -->
			<fieldset>
				<legend><strong>Gallery content</strong></legend>
				
				Channel feed <input id="feed" type="radio" name="syg_gallery_type" value="feed" <?php if ($gallery->getGalleryType() == 'feed') echo 'checked="checked"'; ?> />
		  		Explicit video list <input id="list" type="radio" name="syg_gallery_type" value="list" <?php if ($gallery->getGalleryType() == 'list') echo 'checked="checked"'; ?> />
		  		YouTube playlist <input id="playlist" type="radio" name="syg_gallery_type" value="playlist" <?php if ($gallery->getGalleryType() == 'playlist') echo 'checked="checked"'; ?> />
		  		<br/><br/>
		  		
				<!-- user -->
				<div id="syg_youtube_username_panel">
					<label for="syg_youtube_src">YouTube User [enter the name of the user you want to dispay gallery (e.g. acdc)]: </label><br/>
					<input type="text" id="syg_youtube_username" name="syg_youtube_src" value="<?php if ($gallery->getGalleryType() == 'feed') echo $gallery->getYtSrc(); ?>" size="30"/>
				</div>
				
				<!-- video list -->
				<div id="syg_youtube_list_panel">
					<label for="syg_youtube_src">Video list [enter a list of valid video url in each line (e.g. http://www.youtube.com/watch?v=xRQnJyP77tY)]: </label><br/>
					<textarea rows="5" cols="70" id="syg_youtube_videolist" name="syg_youtube_src"><?php if ($gallery->getGalleryType() == 'list') echo $gallery->getYtSrc(); ?></textarea>
				</div>
		
				<!-- user -->
				<div id="syg_youtube_playlist_panel">
					<label for="syg_youtube_src">YouTube playlist [enter the standard youtube url for playlist (e.g. http://www.youtube.com/playlist?list=PLB53095C7A4A6F63D)]: </label><br/>
					<input type="text" id="syg_youtube_playlist" name="syg_youtube_src" value="<?php if ($gallery->getGalleryType() == 'playlist') echo $gallery->getYtSrc(); ?>" size="30"/>
				</div>
				
				<br/>
				
				<!-- video count -->
				<label for="syg_youtube_maxvideocount">Maximum Video Count: </label>
				<input type="text" id="syg_youtube_maxvideocount" name="syg_youtube_maxvideocount" value="<?php echo $gallery->getYtMaxVideoCount(); ?>" size="10"/>
				
				<!-- related videos -->
				<label for="syg_youtube_disablerel">Disable related videos</label>
				<input type="checkbox" name="syg_youtube_disablerel" id="syg_youtube_disablerel" value="1" <?php if ($gallery->getYtDisableRelatedVideo()) echo 'checked="checked"';?>/>
				
				<!-- cache the content -->
				<label for="syg_youtube_cacheon">Cache content for this gallery *</label>
				<input type="checkbox" name="syg_youtube_cacheon" id="syg_youtube_cacheon" value="1" <?php if ($gallery->getCacheOn()) echo 'checked="checked"';?>/>
			</fieldset>
			
			<!-- description appereance -->
			<fieldset>
				<legend><strong>Layouts and styles</strong></legend>
				
				<!-- style -->
				<a target="_blank" href="admin.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_STYLES; ?>&action=edit&id=<?php echo $gallery->getStyleId(); ?>">Edit current style</a> | 
				<label for="syg_style_id">Style </label>
				<select name="syg_style_id" id="syg_style_id">
					<?php foreach ($styles as $style) { ?>
						<option value="<?php echo $style->getId(); ?>" <?php if ($style->getId() == $gallery->getStyleId()) echo 'selected="selected"'; ?>><?php echo $style->getStyleName(); ?></option>
					<?php } ?>
				</select>
				
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
			</fieldset>
			
			<!-- description appereance -->
			<fieldset>
				<legend><strong>Meta Information</strong></legend>
				<!-- duration -->
				<label for="syg_description_showduration">Duration </label>
				<input type="checkbox" name="syg_description_showduration" id="syg_description_showduration" value="1" <?php if ($gallery->getDescShowDuration()) echo 'checked="checked"';?>/>
		
				<!-- description -->
				<label for="syg_description_show">Description </label>
				<input type="checkbox" name="syg_description_show" id="syg_description_show" value="1" <?php if ($gallery->getDescShow()) echo 'checked="checked"';?>/>
		
				<!-- tags -->
				<label for="syg_description_showtags">Tags </label>
				<input type="checkbox" name="syg_description_showtags" id="syg_description_showtags" value="1" <?php if ($gallery->getDescShowTags()) echo 'checked="checked"';?>/>
		
				<!-- ratings -->
				<label for="syg_description_showratings">Ratings </label>
				<input type="checkbox" name="syg_description_showratings" id="syg_description_showratings" value="1" <?php if ($gallery->getDescShowRatings()) echo 'checked="checked"';?>/>
		
				<!-- categories -->
				<label for="syg_description_showcategories">Categories </label>
				<input type="checkbox" name="syg_description_showcategories" id="syg_description_showcategories" value="1" <?php if ($gallery->getDescShowCategories()) echo 'checked="checked"';?>/>
			</fieldset>
			<hr/>
			<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>
		</form>
		<!-- plugin Menu -->
		<?php include 'inc/contextMenu.inc.php'; ?>
		<?php echo SygConstant::BE_CACHE_GALLERY_WARNING; ?>
	</div>
</div>