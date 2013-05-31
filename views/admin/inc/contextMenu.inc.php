<hr/>
<span>
<?php if ($_GET['page'] == 'syg-manage-styles') { ?>
	<a href="admin.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_STYLES; ?>&action=add" class="button-secondary syg_page_submit" title="<?php echo SygConstant::BE_MENU_ADD_NEW_STYLE; ?>">
		<?php echo SygConstant::BE_MENU_ADD_NEW_STYLE; ?>
	</a>
	&nbsp;
<?php } ?>

<?php if ($_GET['page'] == 'syg-manage-galleries') { ?>
	<?php if ($this->data['stylesCount']) { ?>
		<a href="admin.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_GALLERIES; ?>&action=add" title="<?php echo SygConstant::BE_MENU_ADD_NEW_GALLERY; ?>" class="button-secondary syg_page_submit">
			<?php echo SygConstant::BE_MENU_ADD_NEW_GALLERY; ?>
		</a>
		&nbsp;
		<a href="admin.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_GALLERIES; ?>&action=cache_rebuild" title="<?php echo SygConstant::BE_REBUILD_CACHE_HELP; ?>" class="button-secondary syg_page_submit">
			<?php echo SygConstant::BE_MENU_REBUILD_CACHE; ?>
		</a>
		&nbsp;
	<?php } else { ?>
		<a href="admin.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_STYLES; ?>&action=add" title="<?php echo SygConstant::BE_MENU_ADD_NEW_STYLE_FIRST; ?>" class="button-secondary syg_page_submit">
			<?php echo SygConstant::BE_MENU_ADD_NEW_STYLE_FIRST; ?>
		</a>
		&nbsp;
	<?php }?>
<?php } ?>
	<a href="admin.php?page=<?php echo SygConstant::BE_ACTION_MANAGE_GALLERIES; ?>" title="<?php echo SygConstant::BE_MENU_JUMP_TO_HOME; ?>" class="button-secondary syg_page_submit">
		<?php echo SygConstant::BE_MENU_JUMP_TO_HOME; ?>
	</a>
	&nbsp;
</span>