<hr/>
<p>

<?php if ($_GET['page'] == 'syg-manage-styles') { ?>
	<a href="options-general.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_STYLES; ?>&action=add" class="button-primary">
		<?php echo SygConstant::BE_MENU_ADD_NEW_STYLE; ?>
	</a>
<?php } ?>

<?php if ($_GET['page'] == 'syg-manage-galleries') { ?>
	<a href="options-general.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_GALLERIES; ?>&action=add" class="button-primary">
		<?php echo SygConstant::BE_MENU_ADD_NEW_GALLERY; ?>
	</a>
<?php } ?>

	<a href="options-general.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_GALLERIES; ?>" class="button-primary">
		<?php echo SygConstant::BE_MENU_JUMP_TO_HOME; ?>
	</a>
	
</p>