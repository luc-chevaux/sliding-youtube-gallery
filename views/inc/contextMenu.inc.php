<hr/>
<p>
<?php if ($_GET['page'] == 'syg-manage-styles') { ?>
	<a href="admin.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_STYLES; ?>&action=add" class="button-secondary">
		<?php echo SygConstant::BE_MENU_ADD_NEW_STYLE; ?>
	</a>
	&nbsp;
<?php } ?>

<?php if ($_GET['page'] == 'syg-manage-galleries') { ?>
	<a href="admin.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_GALLERIES; ?>&action=add" class="button-secondary">
		<?php echo SygConstant::BE_MENU_ADD_NEW_GALLERY; ?>
	</a>
	&nbsp;
<?php } ?>
	<a href="admin.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_GALLERIES; ?>" class="button-secondary">
		<?php echo SygConstant::BE_MENU_JUMP_TO_HOME; ?>
	</a>
	&nbsp;
</p>