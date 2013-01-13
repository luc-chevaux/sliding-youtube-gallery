<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 	
	$options = $this->data['options'];
?>

<!-- User Message -->
<?php include 'inc/statusBar.inc.php'; ?>

<!-- Css Inclusion -->
<style type="text/css">
@import url('<?php echo $this->data['cssAdminUrl']; ?>');
@import url('<?php echo $this->data['cssColorPicker']; ?>');
</style>

<!-- Javascript Inclusion -->

<!-- Title Page -->
<div class="wrap">
	<?php require_once 'inc/header.inc.php'; ?>
	<div id="syg-plugin-area">
		<!-- General Setting -->
		<h3>General Settings</h3>
		<form name="form1" method="post" action="">
			<input type="hidden" name="syg_submit_hidden" value="Y">
			
			<!-- youtube settings -->
			<fieldset>
				<legend><strong>YouTube settings</strong></legend>
				<label for="developer_key">Developer Key (Experimental not necessary): </label>
				<input type="text" id="syg_option_apikey" name="syg_option_apikey" value="<?php echo $options['syg_option_apikey']; ?>" size="20">
			
				<br/><br/>
				<label for="syg_option_which_thumb"></label>
				<input type="radio" name="syg_option_which_thumb" value="0" <?php if ($options['syg_option_which_thumb'] == "0") echo 'checked="checked"'; ?>/> Default thumbnail (120px X 90px) 
				<input type="radio" name="syg_option_which_thumb" value="1" <?php if ($options['syg_option_which_thumb'] == "1") echo 'checked="checked"'; ?>/> Medium quality thumbnail (320px X 180px)
				<input type="radio" name="syg_option_which_thumb" value="2" <?php if ($options['syg_option_which_thumb'] == "2") echo 'checked="checked"'; ?>/> High quality thumbnail (480px X 360px) 
				<input type="radio" name="syg_option_which_thumb" value="3" <?php if ($options['syg_option_which_thumb'] == "3") echo 'checked="checked"'; ?>/> Super definition (640px X 480px) 
			</fieldset>
			
			<!-- plugin admin settings -->
			<fieldset>
				<legend><strong>Plugin admin settings</strong></legend>
				<label for="syg_option_numrec">Number of records displayed: </label>
				<input type="text" id="syg_option_numrec" name="syg_option_numrec" value="<?php echo $options['syg_option_numrec']; ?>" size="3">
			</fieldset>
			
			<!-- video page settings -->
			<fieldset>
				<legend><strong>Video page settings</strong></legend>
				
				<label for="syg_option_paginationarea">Pagination display area: </label>
				<select id="syg_option_paginationarea" name="syg_option_paginationarea">
					<option value="top" <?php if ($options['syg_option_paginationarea'] == 'top') echo 'selected="selected"'; ?>>Top</option>
					<option value="bottom" <?php if ($options['syg_option_paginationarea'] == 'bottom') echo 'selected="selected"'; ?>>Bottom</option>
					<option value="both" <?php if ($options['syg_option_paginationarea'] == 'both') echo 'selected="selected"'; ?>>Both</option>			
				</select>
				
				<br/><br/>
				
				<label for="syg_option_pagenumrec">Number of records in page: </label>
				<input type="text" id="syg_option_pagenumrec" name="syg_option_pagenumrec" value="<?php echo $options['syg_option_pagenumrec']; ?>" size="3">
			</fieldset>
			<hr/>
			
			<!-- paginator settings -->
			<fieldset>
				<legend><strong>Paginator style settings</strong></legend>
				
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
			<hr/>
			
			<!-- paginator settings -->
			<fieldset>
				<legend><strong>3d Carousel settings</strong></legend>
				
				<!-- carousel autorotate videos -->
				<label for="syg_option_carousel_autorotate">Autorotate</label>
				<select id="syg_option_carousel_autorotate" name="syg_option_carousel_autorotate">
					<option value="yes" <?php if ($options['syg_option_carousel_autorotate'] == 'yes') echo 'selected="selected"'; ?>>Yes</option>
					<option value="no" <?php if ($options['syg_option_carousel_autorotate'] == 'no') echo 'selected="selected"'; ?>>No</option>		
				</select>
				
				<!-- carousel autorotate delay videos -->
				<label for="syg_option_carousel_delay">Autorotate delay</label>
				<select id="syg_option_carousel_delay" name="syg_option_carousel_delay">
					<option value="1000" <?php if ($options['syg_option_carousel_delay'] == 1000) echo 'selected="selected"'; ?>>1000</option>
					<option value="1250" <?php if ($options['syg_option_carousel_delay'] == 1250) echo 'selected="selected"'; ?>>1250</option>
					<option value="1500" <?php if ($options['syg_option_carousel_delay'] == 1500) echo 'selected="selected"'; ?>>1500</option>		
					<option value="1750" <?php if ($options['syg_option_carousel_delay'] == 1750) echo 'selected="selected"'; ?>>1750</option>
					<option value="2000" <?php if ($options['syg_option_carousel_delay'] == 2000) echo 'selected="selected"'; ?>>2000</option>
					<option value="2500" <?php if ($options['syg_option_carousel_delay'] == 2500) echo 'selected="selected"'; ?>>2500</option>
					<option value="3000" <?php if ($options['syg_option_carousel_delay'] == 3000) echo 'selected="selected"'; ?>>3000</option>
				</select>
				
				<!-- carousel frame per seconds -->
				<label for="syg_option_carousel_fps">Frame per seconds</label>
				<select id="syg_option_carousel_fps" name="syg_option_carousel_fps">
					<option value="15" <?php if ($options['syg_option_carousel_fps'] == 15) echo 'selected="selected"'; ?>>15</option>
					<option value="30" <?php if ($options['syg_option_carousel_fps'] == 30) echo 'selected="selected"'; ?>>30</option>
					<option value="45" <?php if ($options['syg_option_carousel_fps'] == 45) echo 'selected="selected"'; ?>>45</option>
					<option value="60" <?php if ($options['syg_option_carousel_fps'] == 60) echo 'selected="selected"'; ?>>60</option>
				</select>
				
				<!-- carousel rotation speed -->
				<label for="syg_option_carousel_speed">Speed</label>
				<input type="text" name="syg_option_carousel_speed" id="syg_option_carousel_speed" size="3" value="<?php echo $options['syg_option_carousel_speed']; ?>"/>
				<br/><br/>
				
				<!-- carousel image minScale -->
				<label for="syg_option_carousel_minscale">Minscale</label>
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
				<label for="syg_option_carousel_reflheight">Reflection Height</label>
				<input type="text" name="syg_option_carousel_reflheight" id="syg_option_carousel_reflheight" size="3" value="<?php echo $options['syg_option_carousel_reflheight']; ?>"/>
				
				<!-- carousel image reflection height -->
				<label for="syg_option_carousel_reflgap">Reflection Gap</label>
				<input type="text" name="syg_option_carousel_reflgap" id="syg_option_carousel_reflgap" size="3" value="<?php echo $options['syg_option_carousel_reflgap']; ?>"/>
				
				<!-- carousel image reflection opacity -->
				<label for="syg_option_carousel_reflopacity">Reflection Opacity</label>
				<input type="text" name="syg_option_carousel_reflopacity" id="syg_option_carousel_reflopacity" size="3" value="<?php echo $options['syg_option_carousel_reflopacity']; ?>"/>
				
			</fieldset>
			<hr/>
	
			<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>
		</form>
		<?php require_once 'inc/contextMenu.inc.php'; ?>
	</div>
</div>