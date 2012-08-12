<?php if ($this->data['updated']) {?>
	<div class="updated"><p><strong>Settings saved.</strong></p></div>
<?php } ?>

<?php if ($this->data['exception']) {?>
	<div class="error">
		<p>
			<strong><?php echo $this->data['exception_message']; ?></strong>
			<ul>
				<?php $detail = $this->data['exception_detail']; ?>
				<?php foreach ($detail as $problem) { ?>
					<li><?php echo $problem['field'].' - '.$problem['msg']; ?></li>
				<?php }?>
			</ul>
		</p>
	</div>
<?php } ?>