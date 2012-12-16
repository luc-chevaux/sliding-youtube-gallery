<!-- Php Inclusion -->

<!-- Extra Php Code -->

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

<!-- Title Page -->
<h3>Manage your gallery</h3>

<!-- Gallery List -->
<table cellspacing="0" id="galleries_table">
	<tr id="table_header">
		<th class="id">
			<span>ID</span>
		</th>
		<th class="user_pic">
			<span>AVATAR</span>
		</th>
		<th class="name">
			<span>NAME</span>
		</th>
		<th class="details">
			<span>DETAILS</span>
		</th>
		<th class="type">
			<span>TYPE</span>
		</th>
		<th class="cached">
			<span>CACHED</span>
		</th>
		<th class="action">
			<span>ACTION</span>
		</th>
	</tr>
	<tr id="syg-loading">
		<td colspan="5">
			
		</td>
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
?>
</table>
<ul id="syg-pagination-galleries">
	<?php
	// show page links
	for($i=1; $i<=$this->data['pages']; $i++) {
		echo ($i == 1) ? '<li id="'.$i.'" class="current_page">'.$i.'</li>' : '<li id="'.$i.'">'.$i.'</li>';
	}
	?>
</ul>	
<br/><br/>
<?php require_once 'inc/contextMenu.inc.php'; ?>