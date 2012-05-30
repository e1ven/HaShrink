<?php
/**
 * Custom widget for latest portfolio
 * @author webinpixels
 * 2012
 */

class wip_latest_portfolio_Widget extends WP_Widget {
	function wip_latest_portfolio_Widget() {
		$widget_ops = array('classname' => 'widget_latest_portfolio', 'description' => __('Latest Portfolio Posts', 'wip') );
		$control_ops = array( 'width' => 400, 'height' => 200);
		$this->WP_Widget('latest_portfolio_thumbnail', 'The Builder - Latest Portfolio', $widget_ops, $control_ops);
	}
 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
		echo $before_widget;
		$title = empty($instance['title']) ? 'Latest Portfolio' : apply_filters('widget_title', $instance['title']);
		$entry_numb = empty($instance['entry_numb']) ? 6 : apply_filters('widget_entry_numb', $instance['entry_numb']);
		$cat = empty($instance['cat']) ? 0 : apply_filters('widget_cat', $instance['cat']);
 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };

		echo wipfr_latest_portfolio_thumbnail( $entry_numb, $cat );
	
		echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['entry_numb'] = strip_tags($new_instance['entry_numb']);
		$instance['cat'] = strip_tags($new_instance['cat']);
 
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'entry_numb' => '', 'cat' => '') );
		$title = strip_tags($instance['title']);
		$entry_numb = strip_tags($instance['entry_numb']);
		$cat = strip_tags($instance['cat']);


	$portfoliocats = wip_get_tax_lists('portfolio-category');
	$portfoliocat_select = "";
	if( ! empty($portfoliocats) && is_array($portfoliocats) ){
		
		foreach( $portfoliocats as $pcatID => $pvalue ){
			$pselected = '';
			if( $cat == $pcatID) $pselected = ' selected="selected"';
			
			$portfoliocat_select .= '<option value="'.$pcatID.'"'.$pselected.'>'. ( ( isset($pvalue['name']) ) ? $pvalue['name'] : '' ) .'</option>';
		
		}
	
	}

?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php print __('Title:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('entry_numb'); ?>"><?php print __('How many posts you want to show:', 'wip'); ?><input class="widefat" id="<?php echo $this->get_field_id('entry_numb'); ?>" name="<?php echo $this->get_field_name('entry_numb'); ?>" type="text" value="<?php echo esc_attr($entry_numb); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('cat'); ?>"><?php print __('Pull From Category?:', 'wip'); ?>
				<select class="widefat" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>">
					<option value="0"><?php print __('Select a category', 'wip'); ?></option>
					<?php echo $portfoliocat_select; ?>
				</select>
				</label></p>
<?php
	}
}
register_widget('wip_latest_portfolio_Widget');