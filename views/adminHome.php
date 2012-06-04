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

<!-- Menu -->
<?php include 'plugin_menu.php'; ?>

<!-- Welcome Message -->
<p class="webengText">
	<?php echo SygConstant::BE_WELCOME_MESSAGE; ?>
</p>

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
if (count($galleries) == 0) { ?>
<tr>
		<td colspan="5">
		<?php echo SygConstant::BE_NO_GALLERY_FOUND; ?>
		</td>
	</tr>
<?php }

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
			<a href="#" onclick="javascript: PreviewGallery('<?php echo $gallery->getId(); ?>');">Preview</a> | <a href="?page=syg-administration-panel&action=edit&id=<?php echo $gallery->getId(); ?>">Edit</a> | <a href="#" onclick="javascript: DeleteGallery('<?php echo $gallery->getId(); ?>');">Delete</a>
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