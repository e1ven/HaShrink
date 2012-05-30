<?php
/**
 * Custom widget for displaying a video
 * @author webinpixels
 * 2012
 */

class wip_videoWidget extends WP_Widget {
	function wip_videoWidget() {
		$widget_ops = array('classname' => 'wip_video_widget', 'description' => __('Display a video.', 'wip') );
		$control_ops = array( 'width' => 400, 'height' => 200);
		$this->WP_Widget('wip_video_widget', 'The Builder - Video', $widget_ops, $control_ops);
	}
 


	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
	
	$title = empty($instance['title']) ? 'Video' : apply_filters('widget_title', $instance['title']);
	$video = empty($instance['video']) ? '' : apply_filters('widget_video', $instance['video']);

		if(! empty($video) ){
			global $footer_area;


			$width = 190;
			$height = 144;
			if( $footer_area ){
				$width = 220;
				$height= 165;
			}

			echo $before_widget;
			echo $before_title . $title . $after_title;
			
			$vidType = typeOflink( $video );
			$allowed_video = array('youtube','vimeo','quicktime','flowplayer','flash');

			if( in_array( $vidType, $allowed_video ) ){
				echo '<div class="widget_video">' . "\n";
				echo WIPobjectPrint($video, $vidType, $width, $height, 'false', true );
				echo '</div>' . "\n";
			} else {
				print __('Unsuported video format', 'wip');
			}

			echo $after_widget;
		}
	}



	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['video'] = strip_tags($new_instance['video']);
		
		return $instance;
	}


	

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'video' => '' ) );
		$title = strip_tags($instance['title']);
		$video = strip_tags($instance['video']);

?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php print __('Title:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('video'); ?>"><?php print __('Video URL:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('video'); ?>" name="<?php echo $this->get_field_name('video'); ?>" type="text" value="<?php echo esc_attr($video); ?>" />
			<small><?php print __('Enter the URL of the video, include the http://. Supported video : youtube, vimeo, mp4, .flv, .3gp, .mov', 'wip'); ?></small>
			</label></p>
			
<?php
	}
}
register_widget('wip_videoWidget');