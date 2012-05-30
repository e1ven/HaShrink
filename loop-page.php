<?php
/**
 * Template part for page,
 * @author webinpixels
 * @package The_Builder
 */
 
if ( have_posts() ) while ( have_posts() ) : the_post();
	global $post;
	
	wip_layout_helper::_print_page_layout();
	
endwhile;