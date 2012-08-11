<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 	
	$options = $this->data['options'];
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
		<label for="developer_key">Developer Key (not necessary): </label>
		<input type="text" id="syg_option_apikey" name="syg_option_apikey" value="<?php echo $options['syg_option_apikey']; ?>" size="20">
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
		
		<label for="syg_option_pagenumrec">Number of records displayed: </label>
		<input type="text" id="syg_option_pagenumrec" name="syg_option_pagenumrec" value="<?php echo $options['syg_option_pagenumrec']; ?>" size="20">
	</fieldset>
	<hr/>
	<input type="submit" id="Submit" name="Submit" class="button-primary" value="Save Changes"/>
</form>
<?php require_once 'inc/contextMenu.inc.php'; ?>