<?php if (($options['syg_option_paginationarea'] == 'top') || ($options['syg_option_paginationarea'] == 'bottom') || ($options['syg_option_paginationarea'] == 'both')) { ?>
	<div id="paginator-<?php echo $paginator_area; ?>">			
		<ul id="syg-page-pagination">
			<?php
			// show page links
			for($i=1; $i<=$this->data['pages']; $i++) {
				echo ($i == 1) ? '<li id="'.$paginator_area.'-'.$i.'" class="current_page">'.$i.'</li>' : '<li id="'.$paginator_area.'-'.$i.'">'.$i.'</li>';
			}
			?>
		</ul>
	</div>
<?php } ?>