<?php
/**
 * Custom widget for displaying a testimonial
 * @author webinpixels
 * 2012
 */

class wip_testiWidget extends WP_Widget {
	function wip_testiWidget() {
		$widget_ops = array('classname' => 'wip_testimonial_widget', 'description' => __('Display a testimonial.', 'wip') );
		$control_ops = array( 'width' => 400, 'height' => 200);
		$this->WP_Widget('wip_testimonial_widget', 'The Builder - Testimonial', $widget_ops, $control_ops);
	}
 


	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
	
	$title = empty($instance['title']) ? 'Testimonial' : apply_filters('widget_title', $instance['title']);
	$testi_text = empty($instance['testi_text']) ? '' : apply_filters('widget_testi_text', $instance['testi_text']);
	$testi_author = empty($instance['testi_author']) ? '' : apply_filters('widget_testi_author', $instance['testi_author']);

	echo $before_widget;
	echo $before_title . $title . $after_title;
	
	if( !empty($testi_text) ){
		echo wpautop( stripslashes( wptexturize( '<span class="before_quote">&#8220;</span>' . $testi_text . '<span class="after_quote">&#8222;</span>' )) );
	}

	if( !empty($testi_author) ){
		echo stripslashes( wptexturize( '<span class="testi_writer">&#8212; ' . $testi_author . '</span>' ));
	}

	echo $after_widget;
	}



	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['testi_text'] = stripslashes($new_instance['testi_text']);
		$instance['testi_author'] = stripslashes($new_instance['testi_author']);
		
		return $instance;
	}


	

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'testi_text' => '', 'testi_author' => '' ) );
		$title = strip_tags($instance['title']);
		$testi_text = stripslashes($instance['testi_text']);
		$testi_author = stripslashes($instance['testi_author']);

?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php print __('Title:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('testi_text'); ?>"><?php print __('Testimonial text:', 'wip'); ?>:
				<textarea class="widefat" id="<?php echo $this->get_field_id('testi_text'); ?>" name="<?php echo $this->get_field_name('testi_text'); ?>" rows="16" cols="10"><?php echo esc_textarea($testi_text); ?></textarea>
				</label></p>
			<p><label for="<?php echo $this->get_field_id('testi_author'); ?>"><?php print __('Testimonial Source/Author:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('testi_author'); ?>" name="<?php echo $this->get_field_name('testi_author'); ?>" type="text" value="<?php echo esc_attr($testi_author); ?>" /></label></p>
			
<?php
	}
}
register_widget('wip_testiWidget');