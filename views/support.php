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

<h2>What you can do?</h2>
<p><strong>If you're a blogger</strong> and you like this plugin, you may write a small article about this plugin. It would be amazing for my effort!
<p><strong>If you're a WP or PHP developer</strong> and you like the plugin idea, if you have some time you can contribute to this plugin! Sometimes two developer is better than one, right?
<p>Anyway, if you only want to use the plugin without partecipate, You may support me buying me a beer! Donation is always good. You can donate over my blog.</p>
<hr/>
<p class="webengText">Thank you for downloading! Enjoy WP and OpenSource!</p>
<p class="webengText">Luca</p>
