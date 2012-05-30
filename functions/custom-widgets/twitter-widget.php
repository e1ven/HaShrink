<?php
/**
 * Custom widget for twitter
 * @author webinpixels
 * 2012
 */

class wip_twitterWidgets extends WP_Widget {
	function wip_twitterWidgets() {
		$widget_ops = array('classname' => 'twitter_widget', 'description' => __('Twitter Updates.', 'wip') );
		$control_ops = array( 'width' => 400, 'height' => 200);
		$this->WP_Widget('twitter_widget', 'The Builder - Twitter', $widget_ops, $control_ops);
	}
	



	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
	 
		echo $before_widget;
		$title = empty($instance['title']) ? 'Twitter updates' : apply_filters('widget_title', $instance['title']);
		$uname = empty($instance['uname']) ? '' : apply_filters('widget_uname', $instance['uname']);
		$number = empty($instance['number']) ? 6 : apply_filters('widget_number', $instance['number']);


		echo $before_title; 
		echo $title;
		echo $after_title;

		echo _wip_display_tweets( $uname, $number ); 

		echo $after_widget;
	}	





	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['uname'] = strip_tags($new_instance['uname']);
		$instance['number'] = stripslashes($new_instance['number']);
		
		return $instance;
	}


	
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'uname' => '', 'number' => '' ) );
		$title = strip_tags($instance['title']);
		$uname = strip_tags($instance['uname']);
		$number = strip_tags($instance['number']);
	?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php print __('Title:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('uname'); ?>"><?php print __('Twitter username:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('uname'); ?>" name="<?php echo $this->get_field_name('uname'); ?>" type="text" value="<?php echo esc_attr($uname); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php print __('How many updates want to show:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
	<?php		
	}
}
register_widget('wip_twitterWidgets');