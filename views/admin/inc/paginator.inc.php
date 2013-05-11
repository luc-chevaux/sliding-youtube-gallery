<div id="paginator-<?php echo $paginator_area.'-'.$gallery->getId(); ?>" style="display: none;">			
	<ul id="pagination-<?php echo $paginator_area.'-'.$gallery->getId(); ?>">
		<?php
		// show page links
		for($i=1; $i<=$this->data['pages']; $i++) {
			echo ($i == 1) ? '<li id="'.$paginator_area.'-'.$i.'" class="current_page">'.$i.'</li>' : '<li id="'.$paginator_area.'-'.$i.'">'.$i.'</li>';
		}
		?>
	</ul>
</div>