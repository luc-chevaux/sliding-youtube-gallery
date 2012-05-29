<!-- Php Inclusion -->

<!-- Extra Php Code -->

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

<!-- Welcome Message -->
<p class="webengText">
	<?php echo SygConstant::BE_WELCOME_MESSAGE; ?>
</p>


<!-- General Setting -->
<h3>General Settings</h3>
<p>Here you can set the SlidingYoutubeGallery default behavior.</p>
<form name="form1" method="post" action="">
	<fieldset>
		<legend><strong>YouTube settings</strong></legend>
		<label for="developer_key">Developer Key: </label>
		<input type="text" id="developer_key" name="developer_key" value="" size="20">
	</fieldset>
</form>

<!-- navigation -->
<a href="options-general.php?page=syg-administration-panel&action=add" class="button-primary">Add new Gallery</a>
<a href="options-general.php?page=syg-administration-panel&action=add" class="button-primary">General Settings</a>
<a href="options-general.php?page=syg-administration-panel&action=add" class="button-primary">Contact Developer</a>
<a href="options-general.php?page=syg-administration-panel&action=add" class="button-primary">Donate!</a>