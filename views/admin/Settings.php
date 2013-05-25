<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 	
	$options = $this->data['options'];
?>

<!-- Css Inclusion -->
<style type="text/css">
@import url('<?php echo $this->data['cssAdminUrl']; ?>');
@import url('<?php echo $this->data['cssColorPicker']; ?>');
</style>

<!-- Javascript Inclusion -->

<!-- Title Page -->
<div class="syg-wrap-settings wrap">
	<?php require_once 'inc/header.inc.php'; ?>
	<div id="syg-plugin-area">
		
		<!-- User Message -->
		<?php include 'inc/statusBar.inc.php'; ?>

		<!-- Title Page -->
		<h3><?php echo SygConstant::BE_TITLE_EDIT_SETTINGS; ?></h3>
		
		<form id="syg_settings_form" name="syg_settings_form" method="post" action="">
			<?php wp_nonce_field('settings','nonce_field'); ?>
			<input type="hidden" name="syg_submit_hidden" value="Y">
			
			<!-- general settings -->
			<fieldset>
				<legend><strong>General settings</strong></legend>
				<!-- limit word count -->
				<label for="syg_option_description_length">Limit description length up to: </label>
				<select id="syg_option_description_length" name="syg_option_description_length">
					<option value="100" <?php if ($options['syg_option_description_length'] == 100) echo 'selected="selected"'; ?>>100</option>
					<option value="150" <?php if ($options['syg_option_description_length'] == 150) echo 'selected="selected"'; ?>>150</option>
					<option value="200" <?php if ($options['syg_option_description_length'] == 200) echo 'selected="selected"'; ?>>200</option>
					<option value="250" <?php if ($options['syg_option_description_length'] == 250) echo 'selected="selected"'; ?>>250</option>
					<option value="300" <?php if ($options['syg_option_description_length'] == 300) echo 'selected="selected"'; ?>>300</option>
					<option value="350" <?php if ($options['syg_option_description_length'] == 350) echo 'selected="selected"'; ?>>350</option>
					<option value="400" <?php if ($options['syg_option_description_length'] == 400) echo 'selected="selected"'; ?>>400</option>
				</select>
				
				<!-- number of records displayed -->
				<label for="syg_option_askcache">Ask for cache content after saving</label>
				<input type="checkbox" name="syg_option_askcache" id="syg_option_askcache" value="1" <?php if ($options['syg_option_askcache'] == "1") echo 'checked="checked"';?>/>
				
				<!-- number of records displayed -->
				<label for="syg_option_numrec">Number of records displayed: </label>
				<input type="text" id="syg_option_numrec" name="syg_option_numrec" value="<?php echo $options['syg_option_numrec']; ?>" size="3">
				
				<br/><br/>
				<!-- use fancybox2 according to new licences -->
				<label for="syg_option_use_fb2">Display gallery with Fancybox2</label>
				<input type="checkbox" name="syg_option_use_fb2" id="syg_option_use_fb2" value="1" <?php if ($options['syg_option_use_fb2'] == "1") echo 'checked="checked"';?>/> <small>(You must agree with owner's <a href="http://fancyapps.com/fancybox/#license" target="_new">license</a>)</small>
				
				<div id="syg_option_use_fb2_desc" <?php if ($options['syg_option_use_fb2'] == "0") echo 'style="display:none;"'; ?>> Fancybox2 inclusion url: <small>(use http://)</small> : <input type="text" id="syg_option_use_fb2_url" name="syg_option_use_fb2_url" value="<?php echo $options['syg_option_use_fb2_url']; ?>" value="<?php echo $options['syg_option_use_fb2_url']; ?>" size="40" <?php if ($options['syg_option_use_fb2'] == NULL) echo 'style="display:none;"'; ?>></div>
			</fieldset>
			
			<!-- youtube settings -->
			<fieldset>
				<legend><strong>YouTube embed settings</strong></legend>
				<label for="syg_option_which_thumb"></label>
				<input type="radio" name="syg_option_which_thumb" value="0" <?php if ($options['syg_option_which_thumb'] == "0") echo 'checked="checked"'; ?>/> Default thumbnail (120px X 90px) 
				<input type="radio" name="syg_option_which_thumb" value="1" <?php if ($options['syg_option_which_thumb'] == "1") echo 'checked="checked"'; ?>/> Medium quality thumbnail (320px X 180px)
				<input type="radio" name="syg_option_which_thumb" value="2" <?php if ($options['syg_option_which_thumb'] == "2") echo 'checked="checked"'; ?>/> High quality thumbnail (480px X 360px) 
				<input type="radio" name="syg_option_which_thumb" value="3" <?php if ($options['syg_option_which_thumb'] == "3") echo 'checked="checked"'; ?>/> Super definition (640px X 480px) 
				
				<br/><br/>
				
				<!-- autohide -->
				<label for="syg_option_youtube_autohide">Autohide</label> <div class="syg_help" title="<?php echo SygConstant::BE_AUTOHIDE_HELP; ?>"></div>
				<select id="syg_option_youtube_autohide" name="syg_option_youtube_autohide">
					<option value="0" <?php if ($options['syg_option_youtube_autohide'] == 0) echo 'selected="selected"'; ?>>0</option>
					<option value="1" <?php if ($options['syg_option_youtube_autohide'] == 1) echo 'selected="selected"'; ?>>1</option>
					<option value="2" <?php if ($options['syg_option_youtube_autohide'] == 2) echo 'selected="selected"'; ?>>2</option>			
				</select>
				
				<!-- autoplay -->
				<label for="syg_option_youtube_autoplay">Autoplay</label> <div class="syg_help" title="<?php echo SygConstant::BE_AUTOPLAY_HELP; ?>"></div>
				<input type="checkbox" name="syg_option_youtube_autoplay" id="syg_option_youtube_autoplay" value="1" <?php if ($options['syg_option_youtube_autoplay'] == 1) echo 'checked="checked"';?>/>
				
				<!-- cc_load_policy -->
				<label for="syg_option_youtube_ccloadpolicy">Closed caption load policy</label> <div class="syg_help" title="<?php echo SygConstant::BE_CCPOLICY_HELP;?>"></div>
				<input type="checkbox" name="syg_option_youtube_ccloadpolicy" id="syg_option_youtube_ccloadpolicy" value="1" <?php if ($options['syg_option_youtube_ccloadpolicy'] == 1) echo 'checked="checked"';?>/>
				
				<!-- controls -->
				<label for="syg_option_youtube_controls">Controls</label> <div class="syg_help" title="<?php echo SygConstant::BE_CONTROLS_HELP;?>"></div>
				<select id="syg_option_youtube_controls" name="syg_option_youtube_controls">
					<option value="0" <?php if ($options['syg_option_youtube_controls'] == 0) echo 'selected="selected"'; ?>>0</option>
					<option value="1" <?php if ($options['syg_option_youtube_controls'] == 1) echo 'selected="selected"'; ?>>1</option>
					<option value="2" <?php if ($options['syg_option_youtube_controls'] == 2) echo 'selected="selected"'; ?>>2</option>			
				</select>
				
				<!-- disablekb -->
				<label for="syg_option_youtube_disablekb">Disable keyboard</label> <div class="syg_help" title="<?php echo SygConstant::BE_DISABLEKB_HELP;?>"></div>
				<input type="checkbox" name="syg_option_youtube_disablekb" id="syg_option_youtube_disablekb" value="1" <?php if ($options['syg_option_youtube_disablekb'] == 1) echo 'checked="checked"';?>/>
				
				<br/><br/>
				
				<!-- iv_load_policy -->
				<label for="syg_option_youtube_ivloadpolicy">Video annotation</label> <div class="syg_help" title="<?php echo SygConstant::BE_IVLOADPOLICY_HELP;?>"></div>
				<select id="syg_option_youtube_ivloadpolicy" name="syg_option_youtube_ivloadpolicy">
					<option value="1" <?php if ($options['syg_option_youtube_ivloadpolicy'] == 1) echo 'selected="selected"'; ?>>1</option>
					<option value="3" <?php if ($options['syg_option_youtube_ivloadpolicy'] == 3) echo 'selected="selected"'; ?>>3</option>			
				</select>
				
				<!-- modestbranding -->
				<label for="syg_option_youtube_modestbranding">Video annotation</label> <div class="syg_help" title="<?php echo SygConstant::BE_MODESTBRANDING_HELP;?>"></div>
				<input type="checkbox" name="syg_option_youtube_modestbranding" id="syg_option_youtube_modestbranding" value="1" <?php if ($options['syg_option_youtube_modestbranding'] == 1) echo 'checked="checked"';?>/>
				
				<!-- rel -->
				<label for="syg_option_youtube_rel">Display related video</label> <div class="syg_help" title="<?php echo SygConstant::BE_REL_HELP;?>"></div>
				<input type="checkbox" name="syg_option_youtube_rel" id="syg_option_youtube_rel" value="1" <?php if ($options['syg_option_youtube_rel'] == 1) echo 'checked="checked"';?>/>
				
				<!-- showinfo -->
				<label for="syg_option_youtube_showinfo">Show info</label> <div class="syg_help" title="<?php echo SygConstant::BE_SHOWINFO_HELP;?>"></div>
				<input type="checkbox" name="syg_option_youtube_showinfo" id="syg_option_youtube_showinfo" value="1" <?php if ($options['syg_option_youtube_showinfo'] == 1) echo 'checked="checked"';?>/>
			
				<!-- theme -->
				<label for="syg_option_youtube_theme">Player theme</label> <div class="syg_help" title="<?php echo SygConstant::BE_THEME_HELP;?>"></div>
				<select id="syg_option_youtube_theme" name="syg_option_youtube_theme">
					<option value="dark" <?php if ($options['syg_option_youtube_theme'] == 'dark') echo 'selected="selected"'; ?>>dark</option>
					<option value="light" <?php if ($options['syg_option_youtube_theme'] == 'light') echo 'selected="selected"'; ?>>light</option>			
				</select>
			</fieldset>
			
			<!-- video page settings -->
			<fieldset>
				<legend><strong>Video page component settings</strong></legend>
				
				<label for="syg_option_paginationarea">Pagination display area: </label>
				<select id="syg_option_paginationarea" name="syg_option_paginationarea">
					<option value="top" <?php if ($options['syg_option_paginationarea'] == 'top') echo 'selected="selected"'; ?>>Top</option>
					<option value="bottom" <?php if ($options['syg_option_paginationarea'] == 'bottom') echo 'selected="selected"'; ?>>Bottom</option>
					<option value="both" <?php if ($options['syg_option_paginationarea'] == 'both') echo 'selected="selected"'; ?>>Both</option>			
				</select>
				
				<!-- number of records in page -->
				<label for="syg_option_pagenumrec">Number of records in page: </label>
				<input type="text" id="syg_option_pagenumrec" name="syg_option_pagenumrec" value="<?php echo $options['syg_option_pagenumrec']; ?>" size="3">
				
				<br/><br/>
				
				<!-- border radius -->
				<label for="syg_option_paginator_borderradius">Border Radius: </label>
				<input type="text" id="syg_option_paginator_borderradius" name="syg_option_paginator_borderradius" value="<?php echo $options['syg_option_paginator_borderradius']; ?>" size="3">
				
				<!-- border size -->
				<label for="syg_option_paginator_bordersize">Border Size: </label>
				<input type="text" id="syg_option_paginator_bordersize" name="syg_option_paginator_bordersize" value="<?php echo $options['syg_option_paginator_bordersize']; ?>" size="3">
				
				<!-- shadow size -->
				<label for="syg_option_paginator_shadowsize">Shadow Size: </label>
				<input type="text" id="syg_option_paginator_shadowsize" name="syg_option_paginator_shadowsize" value="<?php echo $options['syg_option_paginator_shadowsize']; ?>" size="3">
				
				<!-- font size -->
				<label for="syg_option_paginator_fontsize">Font Size: </label>
				<input type="text" id="syg_option_paginator_fontsize" name="syg_option_paginator_fontsize" value="<?php echo $options['syg_option_paginator_fontsize']; ?>" size="3">
				
				<br/><br/>
				
				<!-- border color -->
				<label for="syg_option_paginator_bordercolor">Border Color: </label>
				<input onchange="updateColorPicker(\'paginator_bordercolor_selector\',this)" type="hidden" id="syg_option_paginator_bordercolor" name="syg_option_paginator_bordercolor" value="<?php echo $options['syg_option_paginator_bordercolor']; ?>" size="3">
				<div id="paginator_bordercolor_selector">
					<div style="background-color: #efefef;"></div>
				</div>
				
				<!-- background color -->
				<label for="syg_option_paginator_bgcolor">Background Color: </label>
				<input onchange="updateColorPicker(\'paginator_bgcolor_selector\',this)" type="hidden" id="syg_option_paginator_bgcolor" name="syg_option_paginator_bgcolor" value="<?php echo $options['syg_option_paginator_bgcolor']; ?>" size="3">
				<div id="paginator_bgcolor_selector">
					<div style="background-color: #efefef;"></div>
				</div>
				
				<!-- shadow color -->
				<label for="syg_option_paginator_shadowcolor">Shadow Color: </label>
				<input onchange="updateColorPicker(\'paginator_shadowcolor_selector\',this)" type="hidden" id="syg_option_paginator_shadowcolor" name="syg_option_paginator_shadowcolor" value="<?php echo $options['syg_option_paginator_shadowcolor']; ?>" size="3">
				<div id="paginator_shadowcolor_selector">
					<div style="background-color: #efefef;"></div>
				</div>
				
				<!-- font color -->
				<label for="syg_option_paginator_fontcolor">Font Color: </label>
				<input onchange="updateColorPicker(\'paginator_fontcolor_selector\',this)" type="hidden" id="syg_option_paginator_fontcolor" name="syg_option_paginator_fontcolor" value="<?php echo $options['syg_option_paginator_fontcolor']; ?>" size="3">
				<div id="paginator_fontcolor_selector">
					<div style="background-color: #efefef;"></div>
				</div>
			</fieldset>
			
			<!-- 3d carousel component settings -->
			<fieldset>
				<legend><strong>3d Carousel component settings</strong></legend>
				
				<!-- carousel autorotate videos -->
				<label for="syg_option_carousel_autorotate">Auto rotate: </label>
				<select id="syg_option_carousel_autorotate" name="syg_option_carousel_autorotate">
					<option value="yes" <?php if ($options['syg_option_carousel_autorotate'] == 'yes') echo 'selected="selected"'; ?>>Yes</option>
					<option value="no" <?php if ($options['syg_option_carousel_autorotate'] == 'no') echo 'selected="selected"'; ?>>No</option>		
				</select>
				
				<!-- carousel autorotate delay videos -->
				<label for="syg_option_carousel_delay">Auto rotate delay: </label>
				<select id="syg_option_carousel_delay" name="syg_option_carousel_delay">
					<option value="500" <?php if ($options['syg_option_carousel_delay'] == 500) echo 'selected="selected"'; ?>>500</option>
					<option value="750" <?php if ($options['syg_option_carousel_delay'] == 750) echo 'selected="selected"'; ?>>750</option>
					<option value="1000" <?php if ($options['syg_option_carousel_delay'] == 1000) echo 'selected="selected"'; ?>>1000</option>
					<option value="1250" <?php if ($options['syg_option_carousel_delay'] == 1250) echo 'selected="selected"'; ?>>1250</option>
					<option value="1500" <?php if ($options['syg_option_carousel_delay'] == 1500) echo 'selected="selected"'; ?>>1500</option>		
					<option value="1750" <?php if ($options['syg_option_carousel_delay'] == 1750) echo 'selected="selected"'; ?>>1750</option>
					<option value="2000" <?php if ($options['syg_option_carousel_delay'] == 2000) echo 'selected="selected"'; ?>>2000</option>
					<option value="2500" <?php if ($options['syg_option_carousel_delay'] == 2500) echo 'selected="selected"'; ?>>2500</option>
					<option value="3000" <?php if ($options['syg_option_carousel_delay'] == 3000) echo 'selected="selected"'; ?>>3000</option>
				</select>
				
				<!-- carousel frame per seconds -->
				<label for="syg_option_carousel_fps">Frame per seconds: </label>
				<select id="syg_option_carousel_fps" name="syg_option_carousel_fps">
					<option value="15" <?php if ($options['syg_option_carousel_fps'] == 15) echo 'selected="selected"'; ?>>15</option>
					<option value="30" <?php if ($options['syg_option_carousel_fps'] == 30) echo 'selected="selected"'; ?>>30</option>
					<option value="45" <?php if ($options['syg_option_carousel_fps'] == 45) echo 'selected="selected"'; ?>>45</option>
					<option value="60" <?php if ($options['syg_option_carousel_fps'] == 60) echo 'selected="selected"'; ?>>60</option>
				</select>
				
				<!-- carousel rotation speed -->
				<label for="syg_option_carousel_speed">Carousel speed: </label>
				<input type="text" name="syg_option_carousel_speed" id="syg_option_carousel_speed" size="3" value="<?php echo $options['syg_option_carousel_speed']; ?>"/>
				<br/><br/>
				
				<!-- carousel image minScale -->
				<label for="syg_option_carousel_minscale">Min scale: </label>
				<select id="syg_option_carousel_minscale" name="syg_option_carousel_minscale">
					<option value="0.25" <?php if ($options['syg_option_carousel_minscale'] == 0.25) echo 'selected="selected"'; ?>>0.25</option>
					<option value="0.50" <?php if ($options['syg_option_carousel_minscale'] == 0.50) echo 'selected="selected"'; ?>>0.50</option>
					<option value="0.60" <?php if ($options['syg_option_carousel_minscale'] == 0.60) echo 'selected="selected"'; ?>>0.60</option>
					<option value="0.70" <?php if ($options['syg_option_carousel_minscale'] == 0.70) echo 'selected="selected"'; ?>>0.70</option>
					<option value="0.80" <?php if ($options['syg_option_carousel_minscale'] == 0.80) echo 'selected="selected"'; ?>>0.80</option>
					<option value="0.90" <?php if ($options['syg_option_carousel_minscale'] == 0.90) echo 'selected="selected"'; ?>>0.90</option>
					<option value="1" <?php if ($options['syg_option_carousel_minscale'] == 1) echo 'selected="selected"'; ?>>1</option>
				</select>
				
				<!-- carousel image reflection height -->
				<label for="syg_option_carousel_reflheight">Reflection height: </label>
				<input type="text" name="syg_option_carousel_reflheight" id="syg_option_carousel_reflheight" size="3" value="<?php echo $options['syg_option_carousel_reflheight']; ?>"/>
				
				<!-- carousel image reflection height -->
				<label for="syg_option_carousel_reflgap">Reflection gap: </label>
				<input type="text" name="syg_option_carousel_reflgap" id="syg_option_carousel_reflgap" size="3" value="<?php echo $options['syg_option_carousel_reflgap']; ?>"/>
				
				<!-- carousel image reflection opacity -->
				<label for="syg_option_carousel_reflopacity">Reflection opacity: </label>
				<input type="text" name="syg_option_carousel_reflopacity" id="syg_option_carousel_reflopacity" size="3" value="<?php echo $options['syg_option_carousel_reflopacity']; ?>"/>
				
			</fieldset>
			<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>
		</form>
		<?php require_once 'inc/contextMenu.inc.php'; ?>
	</div>
</div>