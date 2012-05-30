<?php
/**
 * Portfolio metabox option
 */
function Portfolio_metabox_option(){
	
	global $post;
	
	$PortOp = array(
	
		'sticky_portfolio' => array(
			'type' => 'featured',
			'id'	=> '_wip_make_featured',
			'label' => __('Featured Project?', 'wip'),
			'desc' => __('Turn on/off this post as featured project!', 'wip')
		),
		
		'portfolio' => array(
			'type' => 'portfolio-data',
			'id'	=> '_wip_bd_portfolio',
			'label' => __('Portfolio Object', 'wip'),
			'desc' => __('Choose between image or video - upload your image by press the "UPLOAD" button or enter the video URL', 'wip')
		),

	
	);
	
	return $PortOp;
}







/**
 * Blog metabox option
 */
function Blog_metabox_option(){

	global $post;
	
	$PortOp = array(

		'sidebar' => array(
			'type' => 'select',
			'id'	=> '_bd_sidebar_use',
			'label' => __('Select a sidebar', 'wip'),
			'desc' => __('Select a sidebar for this post', 'wip'),
			'std' => 'Default',
			'option' => get_custom_sidebar_array()
		),
		
		'layout' => array(
			'type' => 'layout',
			'id'	=> '_bd_post_layout',
			'label' => __('Select the layout', 'wip'),
			'desc' => '',
			'std' => 'content-sidebar'
		),
	
	);
	
	return $PortOp;

}