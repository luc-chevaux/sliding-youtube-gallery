<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 	
	$styles = $this->data['styles'];
?>

<!-- User Message -->
<?php if ($this->data['updated']) {?>
	<div class="updated"><p><strong>Settings saved.</strong></p></div>
<?php } ?>

<?php if ($this->data['exception']) {?>
	<div class="error"><p><strong><?php echo $this->data['exception_message']; ?></strong></p></div>
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
<h2 class="webengTitle"><a href="http://blog.webeng.it" target="_new" class="webengRed noDecoration">webEng</a> :: Sliding Youtube Gallery</h2><span><?php echo SygConstant::BE_SUPPORT_PAGE.' | '.SygConstant::BE_DONATION_CODE; ?></span>
<hr/>

<!-- plugin Menu -->
<?php include 'inc/pluginMenu.inc.php'; ?>

<!-- Welcome Message -->
<p class="webengText">
	<?php echo SygConstant::BE_MANAGE_STYLES_MESSAGE; ?>
</p>

<!-- Gallery List -->
<h3><?php echo SygConstant::BE_MENU_MANAGE_STYLES; ?></h3>
<table cellspacing="0" id="galleries_table">
	<tr id="table_header">
		<th class="id">
			<span>ID</span>
		</th>
		<th class="name">
			<span>Name</span>
		</th>
		<th class="details">
			<span>Details</span>
		</th>
		<th class="action">
			<span>Action</span>
		</th>
	</tr>
	<tr id="syg-loading">
		<td colspan="5">
			
		</td>
	</tr>
<?php
$galleries = $this->data['galleries']; 
if (count($styles) == 0) { ?>
	<tr>
		<td colspan="5">
		<?php echo SygConstant::BE_NO_STYLES_FOUND; ?>
		</td>
	</tr>
<?php }
?>
</table>
<ul id="syg-pagination-styles">
	<?php
	// show page links
	for($i=1; $i<=$this->data['pages']; $i++) {
		echo '<li id="'.$i.'">'.$i.'</li>';
	}
	?>
</ul>	
<br/>

<?php require_once 'inc/contextMenu.inc.php'; ?>