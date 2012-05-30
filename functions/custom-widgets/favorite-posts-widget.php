<?php
/**
 * Custom widget for most commented blog posts
 * @author webinpixels
 * 2012
 */
class wip_popular_posts_Widget extends WP_Widget {
	function wip_popular_posts_Widget() {
		$widget_ops = array('classname' => 'widget_popular_posts', 'description' => __('Most Commented Blog Posts', 'wip') );
		$control_ops = array( 'width' => 400, 'height' => 200);
		$this->WP_Widget('popular_posts_blog', 'The Builder - Most Commented Blog', $widget_ops, $control_ops);
	}
 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
		echo $before_widget;
		$title = empty($instance['title']) ? 'Most Commented' : apply_filters('widget_title', $instance['title']);
		$entry_numb = empty($instance['entry_numb']) ? 5 : apply_filters('widget_entry_numb', $instance['entry_numb']);
		$use_thumbnail = empty($instance['use_thumbnail']) ? false : true;
		$use_excerpt = empty($instance['use_excerpt']) ? false : true;
 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };

		$e_length = 74;
		if( $use_thumbnail ) $e_length = 45;

		echo wipfr_most_commented_blog( $entry_numb, $use_thumbnail, $use_excerpt, $e_length );
	
		echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['entry_numb'] = strip_tags($new_instance['entry_numb']);
		$instance['use_thumbnail'] = strip_tags($new_instance['use_thumbnail']);
		$instance['use_excerpt'] = strip_tags($new_instance['use_excerpt']);
 
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'entry_numb' => '', 'use_thumbnail' => '', 'use_excerpt' => '') );
		$title = strip_tags($instance['title']);
		$entry_numb = strip_tags($instance['entry_numb']);
		$use_thumbnail = strip_tags($instance['use_thumbnail']);
		$use_excerpt = strip_tags($instance['use_excerpt']);

?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php print __('Title:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('entry_numb'); ?>"><?php print __('How many posts you want to show:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('entry_numb'); ?>" name="<?php echo $this->get_field_name('entry_numb'); ?>" type="text" value="<?php echo esc_attr($entry_numb); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('use_thumbnail'); ?>"><?php print __('Show Thumbnail:', 'wip'); ?><br/><input id="<?php echo $this->get_field_id('use_thumbnail'); ?>" name="<?php echo $this->get_field_name('use_thumbnail'); ?>" type="checkbox" style="margin-right: 8px;" <?php if($use_thumbnail) echo " checked"; ?>> <small><?php print __('Check this box to display the thumbnail', 'wip'); ?></small></input></label></p>
			<p><label for="<?php echo $this->get_field_id('use_excerpt'); ?>"><?php print __('Show Excerpt:', 'wip'); ?><br/><input id="<?php echo $this->get_field_id('use_excerpt'); ?>" name="<?php echo $this->get_field_name('use_excerpt'); ?>" type="checkbox" style="margin-right: 8px;" <?php if($use_excerpt) echo " checked"; ?>> <small><?php print __('Check this box to display the excerpt', 'wip'); ?></small></input></label></p>
<?php
	}
}
register_widget('wip_popular_posts_Widget');