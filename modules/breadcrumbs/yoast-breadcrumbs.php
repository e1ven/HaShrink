<?php /*
Plugin Name:  Yoast Breadcrumbs
Plugin URI:   http://yoast.com/wordpress/breadcrumbs/
Description:  Outputs a fully customizable breadcrumb path.
Version:      0.8.5
Author:       Joost de Valk
Author URI:   http://yoast.com/

Copyright (C) 2008-2010, Joost de Valk
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Joost de Valk or Yoast nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.*/

if (!function_exists('yoast_breadcrumb_cb')) {

	function yoast_breadcrumb_cb($prefix = '<div class="breadcrumbs">', $suffix = '</div><div class="clear"></div>', $display = true) {
		global $wpdb, $wp_query, $post, $query_string;
		
	// Load some defaults
	$br_opt 						= array();
	$br_opt['home'] 				= __('Home', 'wip');
	$br_opt['blog'] 				= __('Blog', 'wip');
	$br_opt['sep'] 					= '<span class="bread-divider">&raquo;</span>';
	$br_opt['prefix']				= __('You are here:', 'wip');
	$br_opt['boldlast'] 			= true;
	$br_opt['nofollowhome'] 		= false;
	$br_opt['singleparent'] 		= 0;
	$br_opt['singlecatprefix']		= true;
	$br_opt['archiveprefix'] 		= __('Archives for', 'wip');
	$br_opt['searchprefix'] 		= __('Search results for', 'wip');

		if (!function_exists('yoast_get_category_parents')) {
			
			// Copied and adapted from WP source
			function yoast_get_category_parents($id, $link = FALSE, $separator = '/', $nicename = FALSE){
				$chain = '';
				$parent = &get_category($id);
				if ( is_wp_error( $parent ) )
				   return $parent;

				if ( $nicename )
				   $name = $parent->slug;
				else
				   $name = $parent->name;

				if ( $parent->parent && ($parent->parent != $parent->term_id) )
				   $chain .= get_category_parents($parent->parent, true, $separator, $nicename);

				$chain .= bold_take_not($name);
				return $chain;
			}

		}
		
			function WIPTakeTaxonomyParent( $id, $taxName='category', $separator ){
				
				if( $id == '' ) $id = 0;
				
				if ( ! is_object( $id ) )
					$id = (int) $id;
					
				if( $taxName == '' ) return $id;
				
				$parents = get_term_by('id', $id, $taxName);
				$parent = '';
				
				if( $parents->parent && ( $parents->parent != $id ) ){
					
					$par = get_term_by('id', $parents->parent, $taxName);
					
					if( WIPTakeTaxonomyParent($par->term_id, $taxName, '' ) ){
						$parent = WIPTakeTaxonomyParent($par->term_id, $taxName, $separator );
					}
					
					$parent .= '<a href="'. get_term_link( (int)$parents->parent, $taxName ) .'">' . $par->name . '</a> ';
					if($separator) $parent .= $separator;
					
					return $parent;
				}
				
				return false;
			}
			
$prepend = '';

if ( woocommerce_found() && 
		( get_option('woocommerce_prepend_shop_page_to_urls')=="yes" 
		  && woocommerce_get_page_id('shop') 
		  && get_option('page_on_front') !== woocommerce_get_page_id('shop') 
		 )
	) $prepend =  '<a href="' . get_permalink( woocommerce_get_page_id('shop') ) . '">' . get_the_title( woocommerce_get_page_id('shop') ) . '</a> ' . $br_opt['sep'];
		
		$nofollow = ' ';
		if ($br_opt['nofollowhome']) {
			$nofollow = ' rel="nofollow" ';
		}
		
		$on_front = get_option('show_on_front');
		
		if ($on_front == "page") {
			
			$homelink = '<a'.$nofollow.'href="'.get_permalink(get_option('page_on_front')).'" class="breadcrumb_home">'.$br_opt['home'].'</a>';
			$bloglink = $homelink.$br_opt['sep'].' <a href="'.get_permalink(get_option('page_for_posts')).'">'.$br_opt['blog'].'</a>';
		
		} else {
		
			$homelink = '<a'.$nofollow.'href="'.home_url().'" class="breadcrumb_home" title="' . __('Homepage', 'wip') . '">'.$br_opt['home'].'</a>';
			$bloglink = $homelink;
		
		}
			
		if ( ($on_front == "page" && is_front_page()) || ($on_front == "posts" && is_home()) ) {
			
			$output = bold_take_not($br_opt['home']);
		
		} elseif ( $on_front == "page" && is_home() ) {
			
			$output = $homelink.$br_opt['sep'].bold_take_not($br_opt['blog']);
		
		} elseif ( !is_page() ) {
			
			$output = $bloglink.$br_opt['sep'];
			
			if ( ( is_single() || is_category() || is_tag() || is_date() || is_author() ) && $br_opt['singleparent'] != false) {
				$output .= '<a href="'.get_permalink($br_opt['singleparent']).'">'.get_the_title($br_opt['singleparent']).'</a> '.$br_opt['sep'];
			} 
			
			if (is_single() && $br_opt['singlecatprefix']) {
				
				$p_type = get_post_type();
				
				if($p_type == "post"){

					
					$cats = get_the_category();
					$cat = $cats[0];
					if ( is_object($cat) ) {

						if( WIPTakeTaxonomyParent( $cat->term_id, 'category', '') ){
							$output .= WIPTakeTaxonomyParent( $cat->term_id, 'category', $br_opt['sep']);
						}

						$output .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a>'.$br_opt['sep']; 
					}
				
				} else if($p_type == "product"){
					
					$output .= $prepend;
					
					$trm = wp_get_object_terms( $post->ID, 'product_cat');
					$trms = $trm[0];
					$tera = get_term_by('id', $trms->term_id, 'product_cat');
					$tera_link = get_term_link((int) $trms->term_id, 'product_cat');
					
					if($trm){
					
						if( WIPTakeTaxonomyParent( $tera->term_id, 'product_cat', '') ){
							$output .= WIPTakeTaxonomyParent( $tera->term_id, 'product_cat', $br_opt['sep']);
						}
					
						$output .= '<a href="'. $tera_link .'">' . $tera->name . '</a>';
						$output .= $br_opt['sep'];
					}
					
				} else if($p_type == "portfolio-item"){
					
					$trm = wp_get_object_terms( $post->ID, 'portfolio-category');
					$trms = $trm[0];
					$tera = get_term_by('id', $trms->term_id, 'portfolio-category');
					$tera_link = get_term_link((int) $trms->term_id, 'portfolio-category');
					
					if($trm){
					
						if( WIPTakeTaxonomyParent( $tera->term_id, 'portfolio-category', '') ){
							$output .= WIPTakeTaxonomyParent( $tera->term_id, 'portfolio-category', $br_opt['sep']);
						}
					
						$output .= '<a href="'. $tera_link .'">' . $tera->name . '</a>';
						$output .= $br_opt['sep'];
					}
					
				}
				
			} elseif ( woocommerce_found() && 
						(is_post_type_archive('product') && get_option('page_on_front') !== woocommerce_get_page_id('shop') ) 
						){
						$_name = woocommerce_get_page_id('shop') ? get_the_title( woocommerce_get_page_id('shop') ) : ucwords(get_option('woocommerce_shop_slug'));
							
							if( is_search() ){
								$output .= '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>'.$br_opt['sep'];
								$output .= bold_take_not( sprintf( __('Search results for &ldquo;%s&ldquo;', 'woocommerce'), get_search_query() ) );
							} else {
								$output .= bold_take_not($_name);
							}
						}
			
			if ( is_category() ) {
				
				$cat = intval( get_query_var('cat') );
				$output .= yoast_get_category_parents($cat, false, $br_opt['sep']);
			
			} elseif ( is_tag() ) {
				
				$output .= bold_take_not($br_opt['archiveprefix'].single_cat_title('',false));
			
			} elseif ( is_date() ) { 
				
				$output .= bold_take_not($br_opt['archiveprefix'].single_month_title(' ',false));
			
			} elseif ( is_author() ) { 
				
				$user = wp_title("",false);
				$output .= bold_take_not($br_opt['archiveprefix'].$user);
			
			} elseif ( is_search() ) {
				
				if( !is_post_type_archive('product') ) $output .= bold_take_not($br_opt['searchprefix'].'"'.stripslashes(strip_tags(get_search_query())).'"');
			
			} else if ( is_tax('product_cat') ) {
				
				$output .= $prepend;
				$termos = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				
				if( WIPTakeTaxonomyParent( $termos->term_id, 'product_cat', '') ){
					$output .= WIPTakeTaxonomyParent( $termos->term_id, 'product_cat', $br_opt['sep']);
				}

				$output .= bold_take_not($termos->name);
			
			} else if ( is_tax('product_tag') ) {
				$output .= $prepend;
				$queried_object = $wp_query->get_queried_object();

				$output .= bold_take_not($queried_object->name);
			
			} else if ( is_tax('portfolio-category') ) {
				
				$termos = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				
				if( WIPTakeTaxonomyParent( $termos->term_id, 'portfolio-category', '') ){
					$output .= WIPTakeTaxonomyParent( $termos->term_id, 'portfolio-category', $br_opt['sep']);
				}

				$output .= bold_take_not($termos->name);
			
			} else {
				
				if( !is_post_type_archive('product') ) $output .= bold_take_not(get_the_title());
			
			}
			
		} else {
			
			$post = $wp_query->get_queried_object();
			
			if( $post->post_type == 'page' ){
					// If this is a top level Page, it's simple to output the breadcrumb
					if ( 0 == $post->post_parent ) {
						
						$output = $homelink . $br_opt['sep'] . bold_take_not(get_the_title());
					
					} else {
						
						if (isset($post->ancestors)) {
							
							if (is_array($post->ancestors))
								$ancestors = array_values($post->ancestors);
							else 
								$ancestors = array($post->ancestors);				
						
						} else {
							
							$ancestors = array($post->post_parent);
						
						}

						// Reverse the order so it's oldest to newest
						$ancestors = array_reverse($ancestors);

						// Add the current Page to the ancestors list (as we need it's title too)
						$ancestors[] = $post->ID;

						$links = array();			
						foreach ( $ancestors as $ancestor ) {
							
							$tmp  = array();
							$tmp['title'] 	= strip_tags( get_the_title( $ancestor ) );
							$tmp['url'] 	= get_permalink($ancestor);
							$tmp['cur'] = false;
							if ($ancestor == $post->ID) {
								$tmp['cur'] = true;
							}
							$links[] = $tmp;
						
						}

						$output = $homelink;
						foreach ( $links as $link ) {
							
							$output .= ' '.$br_opt['sep'].' ';
							if (!$link['cur']) {
								$output .= '<a href="'.$link['url'].'">'.$link['title'].'</a>';
							} else {
								$output .= bold_take_not($link['title']);
							}
							
						}
						
					}
					
			}
			
		}
		
		if ($br_opt['prefix'] != "") {
			$output = $br_opt['prefix']." ".$output;
		}
		
		if ($display) {
			
			echo $prefix.$output.$suffix;
		
		} else {
			
			return $prefix.$output.$suffix;
		
		}
	}

}


if (!function_exists('bold_take_not')) {
	function bold_take_not($input) {
		return '<strong>'.$input.'</strong>';	
	}		
}

?>