<?php
/**
 * Custom widget for flickr
 * @author webinpixels
 * 2012
 */

class wip_flickrWidget extends WP_Widget {
	function wip_flickrWidget() {
		$widget_ops = array('classname' => 'flickr_widget', 'description' => __('Flickr images.', 'wip') );
		$control_ops = array( 'width' => 400, 'height' => 200);
		$this->WP_Widget('flickr_widget', 'The Builder - Flickr', $widget_ops, $control_ops);
	}
 


	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
	
	$title = empty($instance['title']) ? 'Photos on Flickr' : apply_filters('widget_title', $instance['title']);
	$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
	$number = empty($instance['number']) ? 9 : apply_filters('widget_number', $instance['number']);

	echo $before_widget;
	echo $before_title . $title . $after_title;
	
	echo wip_display_flickr( $id, $number );

	echo $after_widget;
	}



	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['number'] = stripslashes($new_instance['number']);
		
		return $instance;
	}


	

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'id' => '', 'number' => '' ) );
		$title = strip_tags($instance['title']);
		$id = strip_tags($instance['id']);
		$number = strip_tags($instance['number']);

?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php print __('Title:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('id'); ?>"><?php printf( __('Flickr id <a href="%s" target="_blank">idgettr</a>', 'wip'), 'http://idgettr.com/'); ?>:<input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo esc_attr($id); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php print __('Number of photos you want to show:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
			
<?php
	}
}
register_widget('wip_flickrWidget');