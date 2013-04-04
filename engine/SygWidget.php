<?php 
class SygWidget extends WP_Widget{
	function SygWidget() {  
        $widget_ops = array( 'classname' => 'example', 'description' => __('A widget that displays the authors name ', 'example') );  
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );  
        $this->WP_Widget( 'example-widget', __('Sliding Youtube Gallery', 'example'), $widget_ops, $control_ops );  
    }  
	
	public function widget( $args, $instance ) {
		// outputs the content of the widget
	}
	
	public function form( $instance ) {
		// outputs the options form on admin
	}
	
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}
?>