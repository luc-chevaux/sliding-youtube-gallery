<!-- Php Inclusion -->

<!-- Extra Php Code -->

<!-- User Message -->

<!-- Css Inclusion -->
<style type="text/css">
@import url('<?php echo $this->data['cssAdminUrl']; ?>');
</style>

<!-- Javascript Inclusion -->
<script type="text/javascript" src="<?php echo $this->data['jsAdminUrl']; ?>"></script>

<!-- Title Page -->
<div class="wrap">
	<div id="icon-options-general" class="icon32">
	<br/>
</div>
<h2 class="webengTitle"><a href="http://blog.webeng.it" target="_new" class="webengRed noDecoration">webEng</a> :: Sliding Youtube Gallery</h2><span><?php echo SygConstant::BE_SUPPORT_PAGE.' | '.SygConstant::BE_DONATION_CODE; ?></span>
<hr/>

<!-- Welcome Message -->
<p class="webengText">
	<?php echo SygConstant::BE_DONATE_MESSAGE; ?>
</p>

<!-- Menu -->
<?php include 'plugin_menu.php'; ?>

<h2>Donate!</h2>