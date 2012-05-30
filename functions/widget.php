<?php
/**
 * Register the widgets placement
 */
if ( function_exists('register_sidebar') ){
	register_sidebar(array(
		'name'=>'Default Sidebar',
			'before_widget' => '<div class="sidebarbox %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="sidebar-title"><span>',
			'after_title' => '</span></h3>',
		));
	
	register_sidebar(array(
		'name'=>'Footer 1',
			'before_widget' => '<div class="footer-widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="footer-widget-title">',
			'after_title' => '</h3>',
		));
		
	register_sidebar(array(
		'name'=>'Footer 2',
			'before_widget' => '<div class="footer-widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="footer-widget-title">',
			'after_title' => '</h3>',
		));
	
	register_sidebar(array(
		'name'=>'Footer 3',
			'before_widget' => '<div class="footer-widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="footer-widget-title">',
			'after_title' => '</h3>',
		));
		
	register_sidebar(array(
		'name'=>'Footer 4',
			'before_widget' => '<div class="footer-widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="footer-widget-title">',
			'after_title' => '</h3>',
		));
}


require_once(BUILDER_FUNCTIONS . '/custom-widgets/twitter-widget.php');
require_once(BUILDER_FUNCTIONS . '/custom-widgets/flickr-widget.php');
require_once(BUILDER_FUNCTIONS . '/custom-widgets/recentposts-widget.php');
require_once(BUILDER_FUNCTIONS . '/custom-widgets/favorite-posts-widget.php');
require_once(BUILDER_FUNCTIONS . '/custom-widgets/latest-portfolio-widget.php');
require_once(BUILDER_FUNCTIONS . '/custom-widgets/testimonial-widget.php');
require_once(BUILDER_FUNCTIONS . '/custom-widgets/video-widget.php');