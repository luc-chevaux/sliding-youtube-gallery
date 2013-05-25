<div id="syg_status_bar">
	<?php if (isset($this->data['updated']) && $this->data['updated']) { ?>
		<div class="syg_updated"><p><strong>Settings saved.</strong></p></div>
	<?php } ?>
	
	<?php if (isset($this->data['warning']) && $this->data['warning']) {?>
		<div class="syg_updated">
			<p><strong>Information</strong></p>
			<ul>
				<?php $detail = $this->data['warning'];  ?>
				<?php foreach ($detail as $problem) { ?>
					<li><?php echo $problem['field'].' - '.$problem['msg']; ?></li>
				<?php }?>
			</ul>
		</div>
	<?php } ?>
	
	<?php if (isset($this->data['exception']) && $this->data['exception']) {?>
		<div class="syg_error">
			<p><strong><?php echo $this->data['exception_message']; ?></strong></p>
			<ul>
				<?php $detail = $this->data['exception_detail']; ?>
				<?php foreach ($detail as $problem) { ?>
					<li><?php echo $problem['field'].' - '.$problem['msg']; ?></li>
				<?php }?>
			</ul>
		</div>
	<?php } ?>
	
	<div id="loader" style="position: fixed; z-index: 9000; top: 0; left: 0; background: rgba(0,0,0,0.5); width: 100%; height: 100%; display: none;">
		<div style="margin: 20% auto; width: 200px; height: 60px;">
			<img src="<?php echo WP_PLUGIN_URL . SygConstant::WP_PLUGIN_PATH; ?>/img/ui/loader/page-loader.gif"/>
		</div>
	</div>
</div>