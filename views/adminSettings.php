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
	<div id="icon-options-general" class="icon32">
	<br/>
</div>
<h2 class="webengTitle"><a href="http://blog.webeng.it" target="_new" class="webengRed noDecoration">webEng</a> :: Sliding Youtube Gallery</h2><span><?php echo SygConstant::BE_SUPPORT_PAGE.' | '.SygConstant::BE_DONATION_CODE; ?></span>
<hr/>

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
		<input type="text" id="syg_option_numrec" name="syg_option_numrec" value="<?php echo $options['syg_option_numrec']; ?>" size="20">
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
		<input type="text" id="syg_option_pagenumrec" name="syg_option_pagenumrec" value="<?php echo $options['syg_option_pagenumrec']; ?>" size="20">
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
	
	<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>
</form>
<?php require_once 'inc/contextMenu.inc.php'; ?>