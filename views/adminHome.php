<!-- Php Inclusion -->

<!-- User Message -->
<?php if ($this->data['updated']) {?>
	<div class="updated"><p><strong>Settings saved.</strong></p></div>
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
<h2 class="webengTitle">Sliding Youtube Gallery :: <a href="http://blog.webeng.it" target="_new" class="webengRed noDecoration">webEng</a></h2>
<hr/>

<!-- Welcome Message -->
<p class="webengText">
	<?php echo SygConstant::BE_WELCOME_MESSAGE; ?>
</p>

<?php echo SygConstant::BE_SUPPORT_PAGE.' | '.SygConstant::BE_DONATION_CODE; ?>

<!-- Gallery List -->
<h3>Manage your gallery</h3>
<table cellspacing="0" id="galleries_table">
	<tr>
		<th class="id">
			<span>ID</span>
		</th>
		<th class="user_pic">
			<span>Avatar</span>
		</th>
		<th class="user">
			<span>Details</span>
		</th>
		<th class="type">
			<span>Type</span>
		</th>
		<th class="action">
			<span>Action</span>
		</th>
	</tr>
<?php
$galleries = $this->data['galleries']; 
foreach ($galleries as $gallery) {
?>
	<tr>
		<td>
			<?php echo $gallery->getId(); ?>
		</td>
		<td>
			<img src="<?php echo $gallery->getUserProfile()->getThumbnail()->getUrl(); ?>" class="user_pic"></img>
		</td>
		<td>
			<?php echo $gallery->getYtUsername(); ?>
		</td>
		<td>
			User Channel
		</td>
		<td>
			<a href="#" onclick="javascript: Preview('<?php echo $gallery->getId(); ?>');">Preview</a> | <a href="?page=syg-administration-panel&id=<?php echo $gallery->getId(); ?>">Edit</a> | <a href="#" onclick="javascript: Delete('<?php echo $gallery->getId(); ?>');">Delete</a>
		</td>
	</tr>
<?php } ?>
	<tr class="navigation">
		<td colspan="5" class="navigation">
			<< | >>
		</td>
	</tr>
</table>	
<br/>
<input type="submit" id="Submit" name="Submit" class="button-primary" value="Add new Gallery"/>

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