<!-- Php Inclusion -->

<!-- Extra Php Code -->
<?php 	
	$styles = $this->data['styles'];
?>

<!-- Css Inclusion -->
<style type="text/css">
@import url('<?php echo $this->data['cssAdminUrl']; ?>');
@import url('<?php echo $this->data['cssColorPicker']; ?>');
</style>

<!-- Title Page -->
<div class="wrap">
	<?php require_once 'inc/header.inc.php'; ?>
	<div id="syg-plugin-area">
	
		<!-- User Message -->
		<?php include 'inc/statusBar.inc.php'; ?>
	
		<!-- Gallery List -->
		<h3><?php echo SygConstant::BE_MENU_MANAGE_STYLES; ?></h3>
		
		<!-- Style List -->
		<table cellspacing="0" id="galleries_table">
			<tr id="table_header">
				<th class="id">
					<span>ID</span>
				</th>
				<th class="name">
					<span>NAME</span>
				</th>
				<th class="details">
					<span>DETAILS</span>
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
		if (count($styles) == 0) { ?>
			<tr>
				<td colspan="5">
				<?php echo SygConstant::BE_NO_STYLES_FOUND; ?>
				</td>
			</tr>
		<?php }
		?>
		</table>
		<div id="paginator-area">
			<ul id="syg-pagination-styles">
				<?php
				// show page links
				for($i=1; $i<=$this->data['pages']; $i++) {
					echo ($i == 1) ? '<li id="'.$i.'" class="current_page">'.$i.'</li>' : '<li id="'.$i.'">'.$i.'</li>';
				}
				?>
			</ul>	
		</div>
		
		<?php require_once 'inc/contextMenu.inc.php'; ?>
	</div>
</div>