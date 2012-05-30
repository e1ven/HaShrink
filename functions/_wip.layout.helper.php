<?php

if( ! class_exists('wip_layout_helper') ){

Class wip_layout_helper{
	
	var $post_id;
	var $location;
	var $layout;
	var $fullwidth_layout;
	var $sidebar_layout;
	
	function wip_layout_helper(){
		
		$this->location = array();
		
	}
	
	
	/**
	 * Homepage Layout Structure
	 * @param : none;
	 * @return layout structure if exists || error message
	 */
	function _print_frontpage_layout(){
		
		$return = "";
		$parentLayout = get_option('wipfr_parent_home_layout');
		
		if( ! empty($parentLayout) && is_array($parentLayout) ){
			
			foreach( $parentLayout as $pid => $key ){
				if( isset( $key['type'] ) ):
					
					switch( $key['type'] ):

						case 'fullwidth':
							wip_layout_helper::_delete_global_layout();
							wip_layout_helper::_make_global_fullwidth();
							
							_wipfr_print_fullwidth_module( wip_layout_helper::_get_frontend_content_db($pid) );
							
							wip_layout_helper::_delete_global_layout();
							break;
						
						case 'sidebar_content':
							wip_layout_helper::_delete_global_layout();
							wip_layout_helper::_make_global_sidebar();
							
							_print_contentsidebar_module( 'sidebar_content', $pid, wip_layout_helper::_get_frontend_content_db($pid) );
							
							wip_layout_helper::_delete_global_layout();
							break;
							
						case 'content_sidebar':
							wip_layout_helper::_delete_global_layout();
							wip_layout_helper::_make_global_sidebar();
							
							_print_contentsidebar_module( 'content_sidebar', $pid, wip_layout_helper::_get_frontend_content_db($pid));
							
							wip_layout_helper::_delete_global_layout();
							break;
					
					endswitch;
				
				endif;
			}
		
		} else {
			printf( __('Please create the homepage layout at <a href="%s">Homepage manager</a> page!', 'wip'), admin_url('admin.php?page=wip-home-manager') );
		}
	

	}
	
	
	
	
	function _print_category_layout(){
		global $wp_query;
		
		$cate_id = $wp_query->get_queried_object_id();
		
		$choosen_layout = get_metadata('category', $cate_id, 'cat_layout_type', true);
		$choosen_layout = ( $choosen_layout != '' ) ? $choosen_layout : 'content-sidebar';
		
		$selected_sidebar = get_metadata('category', $cate_id, 'cat_custom_sidebar', true);
		$selected_sidebar = ( $selected_sidebar != '' ) ? $selected_sidebar : 'Default Sidebar';
		
		$layout_type = get_metadata('category', $cate_id, 'cat_content_type', true);
		$layout_type = ( $layout_type != '' ) ? $layout_type : 'default';
		
		$column_number = get_metadata('category', $cate_id, 'cat_column_number', true);
		$column_number = ( $column_number != '' ) ? intval($column_number) : 3;
		
		switch( $choosen_layout ):

			case 'fullwidth':
				wip_layout_helper::_delete_global_layout();
				wip_layout_helper::_make_global_fullwidth();
				
				_wipfr_print_fullwidth_module( wip_layout_helper::_print_blog_category_lists( $layout_type, $column_number ) );
				
				wip_layout_helper::_delete_global_layout();
				break;
			
			case 'sidebar-content':
				wip_layout_helper::_delete_global_layout();
				wip_layout_helper::_make_global_sidebar();
				
				_print_category_contentsidebar_module( 'sidebar_content', wip_layout_helper::_print_blog_category_lists( $layout_type, $column_number ), $selected_sidebar );
				
				wip_layout_helper::_delete_global_layout();
				break;
				
			case 'content-sidebar':
				wip_layout_helper::_delete_global_layout();
				wip_layout_helper::_make_global_sidebar();
				
				_print_category_contentsidebar_module( 'content_sidebar', wip_layout_helper::_print_blog_category_lists( $layout_type, $column_number ), $selected_sidebar );
				
				wip_layout_helper::_delete_global_layout();
				break;
		
		endswitch;
	
	}
	
	
	
	
	
	
	function _print_portfolio_category_layout(){
		global $wp_query;
		
		$cate_id = $wp_query->get_queried_object_id();

		$choosen_layout = get_metadata('portfoliocategory', $cate_id, 'cat_layout_type', true);
		$choosen_layout = ( $choosen_layout != '' ) ? $choosen_layout : 'content-sidebar';
		
		$selected_sidebar = get_metadata('portfoliocategory', $cate_id, 'cat_custom_sidebar', true);
		$selected_sidebar = ( $selected_sidebar != '' ) ? $selected_sidebar : 'Default Sidebar';
		
		$column_number = get_metadata('portfoliocategory', $cate_id, 'cat_column_number', true);
		$column_number = ( $column_number != '' ) ? intval($column_number) : 3;		


		switch( $choosen_layout ):

			case 'fullwidth':
				wip_layout_helper::_delete_global_layout();
				wip_layout_helper::_make_global_fullwidth();
				
				_wipfr_print_fullwidth_module( wip_layout_helper::_print_portfolio_category_lists( $layout_type, $column_number ) );
				
				wip_layout_helper::_delete_global_layout();
				break;
			
			case 'sidebar-content':
				wip_layout_helper::_delete_global_layout();
				wip_layout_helper::_make_global_sidebar();
				
				_print_category_contentsidebar_module( 'sidebar_content', wip_layout_helper::_print_portfolio_category_lists( $layout_type, $column_number ), $selected_sidebar );
				
				wip_layout_helper::_delete_global_layout();
				break;
				
			case 'content-sidebar':
				wip_layout_helper::_delete_global_layout();
				wip_layout_helper::_make_global_sidebar();
				
				_print_category_contentsidebar_module( 'content_sidebar', wip_layout_helper::_print_portfolio_category_lists( $layout_type, $column_number ), $selected_sidebar );
				
				wip_layout_helper::_delete_global_layout();
				break;
		
		endswitch;		
	}
	
	
	
	function _print_page_layout(){
		global $post;
		
		$return = "";
		$parentLayout = get_post_meta( $post->ID, '_wipfr_page_parent_layout', true);	
		
		if( ! empty($parentLayout) && is_array($parentLayout) ){
			
			foreach( $parentLayout as $pid => $key ){
				if( isset( $key['type'] ) ):
					
					switch( $key['type'] ):

						case 'fullwidth':
							wip_layout_helper::_delete_global_layout();
							wip_layout_helper::_make_global_fullwidth();
							
							_wipfr_print_fullwidth_module( wip_layout_helper::_get_frontend_content_db($pid, true) );
							
							wip_layout_helper::_delete_global_layout();
							break;
						
						case 'sidebar_content':
							wip_layout_helper::_delete_global_layout();
							wip_layout_helper::_make_global_sidebar();
							
							_print_contentsidebar_module( 'sidebar_content', $pid, wip_layout_helper::_get_frontend_content_db($pid, true), true );
							
							wip_layout_helper::_delete_global_layout();
							break;
							
						case 'content_sidebar':
							wip_layout_helper::_delete_global_layout();
							wip_layout_helper::_make_global_sidebar();
							
							_print_contentsidebar_module( 'content_sidebar', $pid, wip_layout_helper::_get_frontend_content_db($pid, true), true);
							
							wip_layout_helper::_delete_global_layout();
							break;
					
					endswitch;
				
				endif;
			}
		
		} else {
		
			#fullwidth for cart and checkout page
			#if user do not setup the page content manager
			if( woocommerce_found() && (  ( $post->ID == (int) woocommerce_get_page_id('cart') ) || ( $post->ID == (int) woocommerce_get_page_id('checkout') ) || ( $post->ID == (int) woocommerce_get_page_id('view_order') )  ) ){
			
				wip_layout_helper::_delete_global_layout();
				wip_layout_helper::_make_global_fullwidth();

				$content = '<div class="page_content">' . "\n";
				$content .= apply_filters('the_content', get_the_content($post->ID) );
				$content .= '<div class="clear"></div>' . "\n";
				$content .= '</div>' . "\n";				
				
				$f_content = '<div class="wrap_940">' . "\n";
				$f_content .= $content;
				$f_content .= '</div><!-- end .wrap_940 -->' . "\n";
				
				_wipfr_print_fullwidth_module( $f_content );
			
				wip_layout_helper::_delete_global_layout();
			
			} else {
				
				wip_layout_helper::_delete_global_layout();
				wip_layout_helper::_make_global_sidebar();

				$content = '<div class="page_content">' . "\n";
				$content .= apply_filters('the_content', get_the_content($post->ID) );
				$content .= '<div class="clear"></div>' . "\n";
				$content .= '</div>' . "\n";				
				
				_print_contentsidebar_module( 'content_sidebar', $pid, $content, true);
			
				wip_layout_helper::_delete_global_layout();
			
			}
			
		

		}
	
	}
	
	
	public function _make_global_fullwidth(){
		$GLOBALS['fullwidth_layout'] = true;
	}
	
	public function _make_global_sidebar(){
		$GLOBALS['sidebar_layout'] = true;
	}
	
	public function _delete_global_layout(){
		$GLOBALS['sidebar_layout'] = false;
		$GLOBALS['fullwidth_layout'] = false;
	}
	
	
	
	
	function _get_frontend_content_db( $parentID, $forpage = false ){
	
		if( $forpage ){
			global $post;
			$contentStruct = get_post_meta( $post->ID, '_wipfr_page_content_layout', true);
		} else {
			$contentStruct = get_option( 'wipfr_parent_home_content' );
		}
		
		$content = "";
		if( ! empty( $contentStruct ) && is_array( $contentStruct ) ){
		
			foreach( $contentStruct as $id => $c ):
			
				if( isset($c['parent']) && ( $c['parent'] == $parentID ) ){
					$thisID = isset( $c['id'] ) ? $c['id'] : '';
					$type = isset( $c['type'] ) ? $c['type'] : '';
					if( $thisID != "" && $type != "" ){
					
						if( substr($type, -3) == 'col' ){
						
							switch($type):
							
								case '4col':
								case '3col':
								case '2col':
									
									$insidecol = array();
									foreach( $c['field'] as $z => $t ){
										
										$col_content_type = '';
										if(isset( $t['content'] )) $col_content_type = $t['content'];
										
										$fields = array();
										foreach( $t as $name => $value ){
											if( $name != 'content' ){
												$fields[] = $value;
											}
										}
										
										if($col_content_type != ''){
											$insidecol[] = wip_layout_helper::_content_for_column( $col_content_type,$fields);
										} else {
											$insidecol[] = "";
										}
										
									}
									
									$colong = intval(str_replace( 'col', '', $type ));
									
									$content .= wip_layout_helper::_columns_module_print( $colong, $insidecol );
									
									break;
									
									
									
								case '1_2_3col':
								case '2_1_3col':
								case '1_1_2_4col':
								case '1_2_1_4col':
								case '2_1_1_4col':
								case '1_3_4col':
								case '3_1_4col':
									
									
									$colConcept = wip_layout_helper::_get_columnmix_concept($type);
									
									$insidecol = array();
									foreach( $c['field'] as $z => $t ){
										
										$col_content_type = '';
										if(isset( $t['content'] )) $col_content_type = $t['content'];
										
										$fields = array();
										foreach( $t as $name => $value ){
											if( $name != 'content' ){
												$fields[] = $value;
											}
										}
										
										if($col_content_type != ''){
											$insidecol[] = wip_layout_helper::_content_for_column( $col_content_type,$fields);
										} else {
											$insidecol[] = "";
										}
										
									}
									
									$content .= wip_layout_helper::_mix_columns_module_print( $type, $colConcept, $insidecol );
								
									break;
									
							
							endswitch;
						
						} else {
						
							switch($type):
							
								case 'divider1':
								case 'divider2':
										
										$divider_class = ( $type == 'divider1' ) ? 'divider_style_1' : 'divider_style_2';
										$fields = array();
										foreach( $c['field'] as $value ){
											$fields[] = $value;
										}
										
										$divider_title = ( isset($fields[0]) && $fields[0] != "" ) ? stripslashes($fields[0]) : '';
										$divider_title_color = ( isset($fields[1]) && $fields[1] != "" ) ? '#'.$fields[1] : '';
										$divider_title_bg = ( isset($fields[2]) && $fields[2] != "" ) ? '#'.$fields[2] : '';
										$divider_top_link = ( isset($fields[3]) && $fields[3] !== "" ) ? true : false;
										
										if( $divider_title != '' ) $divider_class .= ' with_title';

										$print_divider_top_link = ( !$divider_top_link  ) ? "" : '<a href="#top" title="'.__('back to top', 'wip').'">'.__('top','wip').' &uarr;</a>';
										$print_divider_title = "&nbsp;";
										if( $divider_title != "" ){
											$print_divider_title = "<span class=\"divider_title\" style=\"background-color:{$divider_title_bg};color:{$divider_title_color}\">{$divider_title}</span>";
										}
										
										$content .= "<div class=\"dividers {$divider_class}\">{$print_divider_title}{$print_divider_top_link}</div>" . "\n";
										
									break;
									
								case 'paragraph-text':
									
									$content .= '<div class="wrap_940 plus_padding">' . "\n";
									
										$fields = array();
										foreach( $c['field'] as $value ){
											$fields[] = $value;
										}
										
										$content .= ( isset($fields[0]) && $fields[0] != "" ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
										$content .= ( isset($fields[1]) && $fields[1] != "" ) ?
													( ( isset($fields[2]) && $fields[2] !== '' ) ? apply_filters('the_content', stripslashes( wptexturize($fields[1]))  ) : stripslashes(wptexturize($fields[1]))  ): '';
									
									$content .= '</div><!-- end .wrap_940 -->' . "\n";
									
									break;
									
									
								case 'tagline':
									
									$fields = array();
									foreach( $c['field'] as $value ){
										$fields[] = $value;
									}
									
									$content .= '<style type="text/css">';
									$content .= "#tagline_canvas_{$thisID}{color:#".$fields[1].";font-style:".$fields[2].";font-weight:".$fields[3].";text-transform:".$fields[4].";}";
									$content .= '</style>' . "\n";
									
									$content .= '<div class="block_full">' . "\n";
										
										$content .= ( isset($fields[0]) && $fields[0] != "" ) ? '<h1 class="message_block" id="tagline_canvas_'.$thisID.'">'.stripslashes(wptexturize($fields[0])).'</h1>' . "\n" : '';
										
									$content .= '</div><!-- end .block_full -->' . "\n";
								
									break;
									
									
								case 'taglinebutton':
									
									global $sidebar_layout, $fullwidth_layout;
									
									$fields = array();
									foreach( $c['field'] as $value ){
										$fields[] = $value;
									}
									
									$content .= '<style type="text/css">' . "\n";
									$content .= "#tagline_button_{$thisID}{background-color:#".$fields[6]."; border: 1px solid #".$fields[6]."}" . "\n";
									$content .= "#tagline_canvas_{$thisID}{color:#".$fields[7].";font-style:".$fields[8].";font-weight:".$fields[9].";text-transform:".$fields[10].";}" . "\n";
									$content .= "#button_tagline_{$thisID}{background-color:#".$fields[3].";border:1px solid #".$fields[4].";color:#".$fields[5].";}" . "\n";
									$content .= '</style>' . "\n";
									
									$content .= '<div class="block_full for_tagline_button">' . "\n";
									$content .= '<div class="tagline-button" id="tagline_button_'.$thisID.'">' . "\n";
										
										$content .= ( isset($fields[0]) && $fields[0] != "" ) ? '<h1 class="message_block" id="tagline_canvas_'.$thisID.'">'.stripslashes(wptexturize($fields[0])).'</h1>' . "\n" : '';
										
										if( $sidebar_layout ){
											$content .= '<p class="button_tagline_wrap">';
										}
										
										$content .= '<a id="button_tagline_'.$thisID.'" class="button_tagline" href="'.( ( isset($fields[1]) && $fields[1] != "" ) ? stripslashes($fields[1]) : '#' ).'">'.( ( isset($fields[2]) && $fields[2] != "" ) ? stripslashes(wptexturize($fields[2])) : 'Button Text' ).'</a>' . "\n";
										
										if( $sidebar_layout ){
											$content .= '</p>' . "\n";
										}
										
										
									$content .= '<div class="clear"></div>' . "\n";
									$content .= '</div><!-- end .tagline-button -->' . "\n";
									$content .= '</div><!-- end .block_full -->' . "\n";
								
									break;
									
									
								case 'single-page':
								
									global $sidebar_layout, $fullwidth_layout;
									
									$fields = array();
									foreach( $c['field'] as $value ){
										$fields[] = $value;
									}
									
									if( $fullwidth_layout ) $content .= '<div class="wrap_940">' . "\n";
									
									$content .= '<div class="page_content">' . "\n";
									$content .= wip_layout_helper::_print_single_page( $fields[0], $fields[1] );
									$content .= '</div>' . "\n";
									
									if( $fullwidth_layout ) $content .= '</div><!-- end .wrap_940 -->' . "\n";
									
									break;
									
									
								case 'single-page-content':
									
									global $sidebar_layout, $fullwidth_layout;
									

									if( $fullwidth_layout ) $content .= '<div class="wrap_940">' . "\n";
									
									$content .= '<div class="page_content">' . "\n";
									$content .= apply_filters('the_content', get_the_content($post->ID) );
									$content .= '<div class="clear"></div>' . "\n";
									$content .= '</div>' . "\n";
									
									if( $fullwidth_layout ) $content .= '</div><!-- end .wrap_940 -->' . "\n";
									
									break;
									
									
								case 'blog-lists':
									
									$fields = array();
									foreach( $c['field'] as $value ){
										$fields[] = $value;
									}
									
									$usePag = ( isset($fields[2]) && $fields[2] != "" ) ? true : false;
									$excerpt = ( isset($fields[4]) && $fields[4] == "full" ) ? false : true;
									
									$content .= ( isset($fields[5]) && $fields[5] != "" ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[5])).'</h3>' . "\n" : '';
									$content .= wip_layout_helper::_print_blog_lists( $fields[0], intval($fields[3]), $fields[1], $usePag, $excerpt );
								
									break;
									
									
								case 'portfolio-lists':
									
									$fields = array();
									foreach( $c['field'] as $value ){
										$fields[] = $value;
									}
									
									$columnNumber = ( isset($fields[0]) && $fields[0] != "" ) ? intval($fields[0]) : 4;
									$showPosts = ( isset($fields[1]) && $fields[1] != "" ) ? intval($fields[1]) : 4;
									$usePag = ( isset($fields[2]) && $fields[2] != "" ) ? true : false;
									$showFeatured = ( isset($fields[4]) && $fields[4] != "" ) ? true : false;
									$catID = ( isset($fields[3]) && ( $fields[3] == 'all' ) ) ? 0 : intval($fields[3]);
									
									$content .= ( isset($fields[5]) && $fields[5] != "" ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[5])).'</h3>' . "\n" : '';
									$content .= wip_layout_helper::_print_portfolio_lists( $columnNumber, $showPosts, $usePag, $catID, $showFeatured );
								
									break;


								case 'product-lists':
									
									$fields = array();
									foreach( $c['field'] as $value ){
										$fields[] = $value;
									}
									
									$usePag = ( isset($fields[2]) && $fields[2] != "" ) ? true : false;
									$catID = ( isset($fields[3]) && ( $fields[3] == 'all' ) ) ? 0 : intval($fields[3]);
									$showFeatured = ( isset($fields[4]) && $fields[4] != "" ) ? true : false;
									$postNumber = ( isset($fields[1]) && $fields[1] != "" ) ? $fields[1] : 4;
									$columns = ( isset($fields[0]) && $fields[0] != "" ) ? $fields[0] : 4;

									if( woocommerce_found() ){
										$content .= ( isset($fields[5]) && $fields[5] != "" ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[5])).'</h3>' . "\n" : '';
										$content .= _wip_show_product_lists_for_manager( $columns, intval($postNumber), $catID, $showFeatured, $usePag );
									} else {
										$content .= __('Please activate WooCommerce Plugin!', 'wip');
									}
										
								
									break;
									
									
							
							endswitch;
						
						}
					
					}
				}
				
			endforeach;
		
		}
		
		return $content;
		
	}
	
	
	
	function _content_for_column( $type, $fields = "" ){
		$colContent = "";
		
		switch( $type ):
			
			case 'paragraph-text':
				
				$colContent .= ( ($fields != "") && (is_array($fields)) && (isset($fields[0]) && $fields[0] != "" ) ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
				$colContent .= ( ($fields != "") && 
								(is_array($fields)) && 
								(isset($fields[1]) && $fields[1] != "" ) 
								) ? ( ( isset($fields[2]) && $fields[2] !== '' ) ? apply_filters('the_content', stripslashes( wptexturize($fields[1]))  ) : stripslashes(wptexturize($fields[1]))  ): '';
				
				break;
				
			case 'latest-post':
			
				$count = ( ($fields != "") && (is_array($fields)) && (isset($fields[1]) && $fields[1] != "" ) ) ? $fields[1] : 5;
				$usethumbnail = ( ($fields != "") && (is_array($fields)) && ( isset($fields[2]) && $fields[2] !== "") ) ? true : false;
				$showexcerpt = ( ($fields != "") && (is_array($fields)) && ( isset($fields[3]) && $fields[3] !== "") ) ? true : false;
				
				$colContent .= ( ($fields != "") && (is_array($fields)) && (isset($fields[0]) && $fields[0] != "" ) ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
				$colContent .= wipfr_latest_blog( $count, $usethumbnail, $showexcerpt );
				
				break;
				
			case 'latest-portfolio-thumbnail':
			
				$count = ( ($fields != "") && (is_array($fields)) && (isset($fields[1]) && $fields[1] != "" ) ) ? $fields[1] : 6;
				$catID = ( isset($fields[2]) && ( $fields[2] == 'all' ) ) ? 0 : intval($fields[2]);
				
				$colContent .= ( ($fields != "") && (is_array($fields)) && (isset($fields[0]) && $fields[0] != "" ) ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
				$colContent .= wipfr_latest_portfolio_thumbnail( $count, $catID );
				
				break;
				
				
			case 'latest-product':
			
				$count = ( ($fields != "") && (is_array($fields)) && (isset($fields[1]) && $fields[1] != "" ) ) ? $fields[1] : 6;
				$catID = ( isset($fields[2]) && ( $fields[2] == 'all' ) ) ? 0 : intval($fields[2]);
				$featured = ( ($fields != "") && (is_array($fields)) && (isset($fields[3]) && $fields[3] != "" ) ) ? true : false;
				
				$colContent .= ( ($fields != "") && (is_array($fields)) && (isset($fields[0]) && $fields[0] != "" ) ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
				
				if( woocommerce_found() ){
					
					$colContent .= _wip_latest_woo_product( $count, $catID, $featured );
				
				} else {
					$colContent .= __('Please activate WooCommerce Plugin!', 'wip');
				}
				
				
				break;

				
			case 'latest-post-column':
			
				$count = ( ($fields != "") && (is_array($fields)) && (isset($fields[1]) && $fields[1] != "" ) ) ? $fields[1] : 3;
				
				$colContent .= ( ($fields != "") && (is_array($fields)) && (isset($fields[0]) && $fields[0] != "" ) ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
				$colContent .= wip_layout_helper::_print_column_blog_lists( $count );
				
				break;
				
			case 'latest-tweet':
			
				$count = ( ($fields != "") && (is_array($fields)) && (isset($fields[2]) && $fields[2] != "" ) ) ? $fields[2] :4;
				$twitterUser = ( ($fields != "") && (is_array($fields)) && ( isset($fields[1]) && $fields[1] !== "") ) ? esc_attr($fields[1]) : '';
				
				$colContent .= ( ($fields != "") && (is_array($fields)) && (isset($fields[0]) && $fields[0] != "" ) ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
					
				if( $twitterUser != "" ){
					$colContent .= _wip_display_tweets( $twitterUser, $count);
				} else {
					$colContent .= __('Cannot process request! Twitter username is blank!', 'wip');
				}
				
				break;
				
			case 'flickr-photo':
			
				$count = ( ($fields != "") && (is_array($fields)) && (isset($fields[2]) && $fields[2] != "" ) ) ? $fields[2] : 9;
				$flickrID = ( ($fields != "") && (is_array($fields)) && ( isset($fields[1]) && $fields[1] !== "") ) ? esc_attr($fields[1]) : '';
				
				$colContent .= ( ($fields != "") && (is_array($fields)) && (isset($fields[0]) && $fields[0] != "" ) ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
					
				if( $flickrID != "" ){
					$colContent .= wip_display_flickr( $flickrID, $count);
				} else {
					$colContent .= __('Cannot process request! Please enter your Flickr ID!', 'wip');
				}
				
				break;
				
			case 'box-testimonial':
				
				$colContent .= ( ($fields != "") && (is_array($fields)) && (isset($fields[0]) && $fields[0] != "" ) ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
				$colContent .= ( ($fields != "") && 
								(is_array($fields)) && 
								(isset($fields[1]) && $fields[1] != "" ) 
								) ? wpautop( stripslashes( wptexturize( '<span class="before_quote">&#8220;</span>' . $fields[1] . '<span class="after_quote">&#8222;</span>' )) ) : '';
				$colContent .= ( ($fields != "") && 
								(is_array($fields)) && 
								(isset($fields[2]) && $fields[2] != "" ) 
								) ? stripslashes( wptexturize( '<span class="testi_writer">&#8212; ' . $fields[2] . '</span>' )) : '<span class="testi_writer">&#8212; No Body</span>';
				break;
				
				
			case 'latest-product-column':
			
				$count = ( ($fields != "") && (is_array($fields)) && (isset($fields[1]) && $fields[1] != "" ) ) ? $fields[1] : 3;
				$prodCat = ( isset($fields[2]) && ( $fields[2] == 'all' ) ) ? 0 : intval($fields[2]);
				$featured = ( ($fields != "") && (is_array($fields)) && (isset($fields[3]) && $fields[3] != "" ) ) ? true : false;
				
				$colContent .= ( ($fields != "") && (is_array($fields)) && (isset($fields[0]) && $fields[0] != "" ) ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
				
				if( woocommerce_found() ){
					$colContent .= _wip_show_product_lists_for_manager( 34, $count, $prodCat, $featured, false );
				} else {
					$colContent .= __('Please activate WooCommerce Plugin!', 'wip');
				}
				break;
				
				
			case 'latest-portfolio-column':
			
				$count = ( ($fields != "") && (is_array($fields)) && (isset($fields[1]) && $fields[1] != "" ) ) ? $fields[1] : 3;
				$portCat = ( isset($fields[2]) && ( $fields[2] == 'all' ) ) ? 0 : intval($fields[2]);

				$colContent .= ( isset($fields[0]) && $fields[0] != "" ) ? '<h3 class="section_title">'.stripslashes(esc_attr($fields[0])).'</h3>' . "\n" : '';
				$colContent .= wip_layout_helper::_print_column_portfolio_lists( $count, $portCat );
				
				break;
				
		
		endswitch;
		
		
		return $colContent;
	}
	
	
	
	function _columns_module_print( $colNumber, $content = "" ){
	global $sidebar_layout, $fullwidth_layout;
	
		$return = '<div class="col_wraper">' . "\n";
		
		$colClass = "col_four";
		switch( $colNumber ){
			case 4:
				$colClass = "col_four";
				break;
				
			case 3:
				$colClass = "col_three";
				break;
				
			case 2:
				$colClass = "col_two";
				break;
		}
		
		
		$a = 0;
		for( $a = 1; $a <= $colNumber; $a++ ){
			
			$moreC = "";
			if( ! $fullwidth_layout ){
				if( $a == 1 ){
					$moreC = ' no_margin_left';
				}
				
				if( $a == $colNumber ){
					$moreC = ' no_margin_right';
				}
			}
			
			$return .= '<div class="'.$colClass.$moreC.' float_left">' . "\n";
			if( $content != "" && is_array( $content ) ){
				if( isset( $content[$a-1] ) && ( $content[$a-1] != "" ) ){
					$return .= $content[$a-1];
				}
			}
			$return .= '</div>' . "\n";
		}
		
		$return .= '<div class="clear"></div>' . "\n";
		$return .= '</div>' . "\n";
		
		return $return;
	
	}
	
	
	function _mix_columns_module_print( $columnID, $args, $content = "" ){
	global $sidebar_layout, $fullwidth_layout;
	
		$return = '<div class="col_wraper">' . "\n";
		
		$a = 0;
		foreach( $args as $c ){
		$a++;
			$class = "";
			$moreC = "";
			
			if( substr($columnID, -4) == '3col' ){
				$class = ( $c == '1/3' ) ? 'col_three' : 'col_twothree';
			} else if( substr($columnID, -4) == '4col' ){
				switch ( $c ){
					case '1/4':
						$class = 'col_four';
						break;
					case '2/4':
						$class = 'col_twofourth';
						break;
					case '3/4':
						$class = 'col_threefourth';
						break;
				}
			}
			
			
			if( ! $fullwidth_layout ){
				if( $a == 1 ){
					$moreC = ' no_margin_left';
				}
				
				if( $a == count($args) ){
					$moreC = ' no_margin_right';
				}
			}
			
			$return .= '<div class="'.$class.$moreC.' float_left">' . "\n";
			if( $content != "" && is_array( $content ) ){
				if( isset( $content[$a-1] ) && ( $content[$a-1] != "" ) ){
					$return .= $content[$a-1];
				}
			}
			$return .= '</div>' . "\n";
			
			
		}
		
		$return .= '<div class="clear"></div>' . "\n";
		$return .= '</div>' . "\n";
		
		return $return;
	}
	
	
	
	function _print_single_page( $pageID, $showtitle = true ){
		global $wpdb;
		
		$pageContent = "";
		
		if( $pageID !== '0' ){
			
			if( $showtitle ) $pageContent .= '<h2>'.get_the_title($pageID).'</h2>' . "\n";
			
				query_posts('page_id=' . $pageID . '' ); 
				while (have_posts()): the_post();
				
				$pageContent .= apply_filters('the_content', get_the_content());
				
				endwhile; wp_reset_query(); 
				
				$pageContent .= '<div class="clear"></div>' . "\n";
				
		}
		
		return $pageContent;
	
	}

	
	
	function _print_portfolio_lists( $columnNumber, $showPosts, $usePag, $catID, $showFeatured = false ){
		
		global $wpdb, $wp_query, $sidebar_layout, $fullwidth_layout;
		$parentLayout = ( $fullwidth_layout ) ? 'fullwidth' : 'content-sidebar';
		$paged = ( $usePag ) ? ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ) : false;
		$content = '';
		
		$args = array(
			'post_type'	=> 'portfolio-item',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => $showPosts,
			'paged' => $paged
		);

		if( (!$showFeatured) && ($catID && $catID != "" && $catID !== 0) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio-category',
					'field' => 'id',
					'terms' => intval($catID),
					'operator' => 'IN'
				)
			);
		}
		
		if( $showFeatured ){
			$args['post__in'] = get_option('wip_featured_portfolio');
		}
		
		
			$portfolioquery = new WP_Query( $args );
			
			if( $portfolioquery->have_posts() ):
			
			$content .= '<div class="col_wraper no_margin">' . "\n";
			$intloop = 0;
			
			while ( $portfolioquery->have_posts()): $portfolioquery->the_post();
			$intloop++;
			global $post;
		
				
				$colClass = 'col_four';
				$imgArray = "";
				$colImage = "";
				$specialStyle = "";
				
				if( $parentLayout == 'fullwidth' ){
				
						switch( $columnNumber ){
							case '4':
							
								$colClass = 'col_four';
												
								$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
											wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 168, true ) : '';
								
								$colImage = ( is_array( $imgArray ) ) ? 
											$imgArray['url']
											:
											get_template_directory_uri() . '/images/no-preview.jpg';
											
								$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';
												
												
								break;
							case '3':
							
								$colClass = 'col_three';
												
								$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
											wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 300, 230, true ) : '';
								
								$colImage = ( is_array( $imgArray ) ) ? 
											$imgArray['url']
											:
											get_template_directory_uri() . '/images/no-preview.jpg';
											
								$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';
								
								break;
							case '2':
							
								$colClass = 'col_two';
												
								$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
											wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 460, 350, true ) : '';
								
								$colImage = ( is_array( $imgArray ) ) ? 
											$imgArray['url']
											:
											get_template_directory_uri() . '/images/no-preview.jpg';
											
								$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';	
												
								break;
						}
				
				} else {
				
					if( ( $intloop == 1 ) || ( $intloop % $columnNumber == 1 ) ){
						$specialStyle = " no_margin_left";
					}
					if( $intloop % $columnNumber == 0 ){
						$specialStyle = " no_margin_right";
					}
				
				
							switch( $columnNumber ){
								case '4':
										$colClass = 'col_four';
													
										$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 160, 122, true ) : '';
										
										$colImage = ( is_array( $imgArray ) ) ? 
													$imgArray['url']
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
													
										$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';			
													
									break;
								case '3':
										$colClass = 'col_three';
													
										$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 168, true ) : '';
										
										$colImage = ( is_array( $imgArray ) ) ? 
													$imgArray['url']
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
													
										$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';	
													
									break;
								case '2':
										$colClass = 'col_two';
													
										$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 340, 260, true ) : '';
										
										$colImage = ( is_array( $imgArray ) ) ? 
													$imgArray['url']
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
													
										$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';
													
													
									break;
							}
				
				
				}
				
				
				$content .= '<div class="'.$colClass.' float_left'.$specialStyle.'">' . "\n";
				
						$content .= '<div class="portfolio-thumbnail">' . "\n";
						$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
						$content .= '<img class="portfolio-grayscale" src="'.$colImageGrayscale.'" alt="'. the_title_attribute('echo=0') .'"/>';
						$content .= '<img class="portfolio-original" src="'.$colImage.'" alt="'. the_title_attribute('echo=0') .'"/>';
						$content .= '</a>' . "\n";
						$content .= '</div>' . "\n";
						
						$content .= '<h3 class="portfolio-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";

						if ($post->post_excerpt){
							$content .= wpautop(wptexturize($post->post_excerpt));
						}				
				$content .= '</div>' . "\n";
		
		
		
				if( $intloop % $columnNumber == 0 ) $content .= '<div class="clear"></div>' . "\n";
				
				
			endwhile;
				
				if( $intloop % $columnNumber != 0 ) $content .= '<div class="clear"></div>' . "\n";
				
				$content .= '</div><!-- end .col_wraper -->' . "\n";
				
				$content .= ( $usePag ) ? wip_pagenavi( $args, false, '<div class="pagination_wrap">', '</div>' ) : '';

			else:
			
				$content .= __('No Posts Found!', 'wip');
			
			endif;
			wp_reset_postdata();
			
			
		return $content;
			
	}
	
	
	
	
	
	function _print_portfolio_category_lists( $layout_type, $columnNumber = 4 ){
		global $wpdb, $wp_query, $sidebar_layout, $fullwidth_layout;
		$parentLayout = ( $fullwidth_layout ) ? 'fullwidth' : 'content-sidebar';

		$content = '';	
	
			
			if( have_posts() ):
			
			$content .= '<div class="col_wraper no_margin">' . "\n";
			$intloop = 0;
			
			while ( have_posts()): the_post();
			$intloop++;
			global $post;
		
				
				$colClass = 'col_four';
				$imgArray = "";
				$colImage = "";
				$specialStyle = "";
				

				
				if( $parentLayout == 'fullwidth' ){
				
						switch( $columnNumber ){
							case '4':
							
								$colClass = 'col_four';
												
								$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
											wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 168, true ) : '';
								
								$colImage = ( is_array( $imgArray ) ) ? 
											$imgArray['url']
											:
											get_template_directory_uri() . '/images/no-preview.jpg';
											
								$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';
												
												
								break;
							case '3':
							
								$colClass = 'col_three';
												
								$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
											wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 300, 230, true ) : '';
								
								$colImage = ( is_array( $imgArray ) ) ? 
											$imgArray['url']
											:
											get_template_directory_uri() . '/images/no-preview.jpg';
											
								$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';
								
								break;
							case '2':
							
								$colClass = 'col_two';
												
								$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
											wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 460, 350, true ) : '';
								
								$colImage = ( is_array( $imgArray ) ) ? 
											$imgArray['url']
											:
											get_template_directory_uri() . '/images/no-preview.jpg';
											
								$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';	
												
								break;
						}
				
				} else {
				
				if( ( $intloop == 1 ) || ( $intloop % intval($columnNumber) == 1 ) ){
					$specialStyle = " no_margin_left";
				}
				if( $intloop % intval($columnNumber) == 0 ){
					$specialStyle = " no_margin_right";
				}
				
				
							switch( $columnNumber ){
								case '4':
										$colClass = 'col_four';
													
										$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 160, 122, true ) : '';
										
										$colImage = ( is_array( $imgArray ) ) ? 
													$imgArray['url']
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
													
										$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';			
													
									break;
								case '3':
										$colClass = 'col_three';
													
										$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 168, true ) : '';
										
										$colImage = ( is_array( $imgArray ) ) ? 
													$imgArray['url']
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
													
										$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';	
													
									break;
								case '2':
										$colClass = 'col_two';
													
										$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 340, 260, true ) : '';
										
										$colImage = ( is_array( $imgArray ) ) ? 
													$imgArray['url']
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
													
										$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';
													
													
									break;
							}
				
				
				}
				
				
				$content .= '<div class="'.$colClass.' float_left'.$specialStyle.'">' . "\n";
				
						$content .= '<div class="portfolio-thumbnail">' . "\n";
						$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
						$content .= '<img class="portfolio-grayscale" src="'.$colImageGrayscale.'" alt="'. the_title_attribute('echo=0') .'"/>';
						$content .= '<img class="portfolio-original" src="'.$colImage.'" alt="'. the_title_attribute('echo=0') .'"/>';
						$content .= '</a>' . "\n";
						$content .= '</div>' . "\n";
						
						$content .= '<h3 class="portfolio-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";

						if ($post->post_excerpt){
							$content .= wpautop(wptexturize($post->post_excerpt));
						}				
				$content .= '</div>' . "\n";
		
		
		
				if( $intloop % $columnNumber == 0 ) $content .= '<div class="clear"></div>' . "\n";
				
				
			endwhile;
				
				if( $intloop % $columnNumber != 0 ) $content .= '<div class="clear"></div>' . "\n";
				
				$content .= '</div><!-- end .col_wraper -->' . "\n";
				
				$content .= wip_pagenavi( '', false, '<div class="pagination_wrap">', '</div>' );

			else:
			
				$content .= __('No Posts Found!', 'wip');
			
			endif;
			wp_reset_postdata();
			
			
		return $content;
	}
	
	
	
	
	
	function _print_blog_lists( $layout_type, $column = 4, $post_per_page = 5, $pagination = false, $excerpt = true ){
	global $wpdb, $wp_query, $sidebar_layout, $fullwidth_layout;
	
	$parentLayout = ( $fullwidth_layout ) ? 'fullwidth' : 'content-sidebar';
	
	$content = '';

			if( $parentLayout == 'fullwidth' ){
				
				switch( $layout_type ){
					
					case 'default-fullwidth':
					case 'default':
						
							$content .= '<div class="wrap_940 plus_padding">' . "\n";

							$paged = ( $pagination ) ? ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ) : false;
							
							$args = array(
								'posts_per_page' => $post_per_page,
								'paged' => $paged
							);
							$blogquery = new WP_Query( $args );
							
							if( $blogquery->have_posts() ):
							while ( $blogquery->have_posts()): $blogquery->the_post();
							global $post;
							
							
							$ccat = get_the_category();
							$ct='';
							foreach($ccat as $a => $cct){
								
								if( $a != 0 ){ $ct .= ', '; }
								$ct .= '<a href="'.get_category_link($cct->term_id ).'">'.$cct->cat_name.'</a>';
							}
							
							$num_comments = get_comments_number();
							$write_comments = "";
							if ( comments_open() ){
								  if($num_comments == 0){
									  $comments = __('0 Comments', 'wip');
								  }
								  elseif($num_comments > 1){
									  $comments = $num_comments. __(' Comments', 'wip');
								  }
								  else{
									   $comments = __('1 Comment', 'wip');
								  }
							 $write_comments = '<a href="' . get_comments_link($post->ID) .'">'. $comments.'</a>';
							}
							else {
								$write_comments = __('Comment Off', 'wip');
							}
							
							$content .= '<div class="fullwidth-blog-lists">' . "\n";	
								/** post with thumbnail */
								if( has_post_thumbnail() && wip_get_attached_file($post->ID) ){
								
									$content .= '<div class="fullwidth-blog-excerpt">' . "\n";
									$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ).'
												&ndash;
												'.__('In', 'wip').' '.$ct.'
												'.__('With', 'wip').' '.$write_comments .'
												</span>' . "\n";
									$content .= wpautop( str_replace('[...]', '...', get_the_excerpt()) );
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'.__('Continue Reading', 'wip').' &rarr;</a>' . "\n";
									$content .= '</div>' . "\n";
								
									$content .= '<div class="fullwidth-blog-thumbnail">' . "\n";
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
									$content .= '<img src="'. wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 460, 220 ) .'" alt="'. the_title_attribute('echo=0') .'"/>';
									$content .= '</a>' . "\n";
									$content .= '</div>' . "\n";
									
									$content .= '<div class="clear"></div>' . "\n";
									
								} else {
								
									$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ).'
												&ndash;
												'.__('In', 'wip').' '.$ct.'
												'.__('With', 'wip').' '.$write_comments .'
												</span>' . "\n";
									$content .= wpautop( str_replace('[...]', '...', get_the_excerpt()) );
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'.__('Continue Reading', 'wip').' &rarr;</a>' . "\n";
								
								}
							
							$content .= '</div>' . "\n";
							
							
							endwhile;
							
								$content .= ( $pagination ) ? wip_pagenavi( $args, false ) : '';
							
							else:
							
								$content .= __('No Posts Found!', 'wip');
							
							endif;
							wp_reset_postdata();
							
							$content .= '</div><!-- end .wrap_940 -->' . "\n";
					
						break;
						
						
					case 'column':
							
							$paged = ( $pagination ) ? ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ) : false;
							
							$args = array(
								'posts_per_page' => $post_per_page,
								'paged' => $paged
							);
							$blogquery = new WP_Query( $args );
							
							if( $blogquery->have_posts() ):
							
							$content .= '<div class="col_wraper no_margin">' . "\n";
							$intloop = 0;
							
							while ($blogquery->have_posts()): $blogquery->the_post();
							
							$intloop++;
							global $post;
							
							
							$colClass = 'col_four';
							$colImage = "";
							switch( $column ){
								case '4':
										$colClass = 'col_four';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 120 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
								case '3':
										$colClass = 'col_three';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 300, 166 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
								case '2':
										$colClass = 'col_two';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 460, 258 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
							}
							
							
							$ccat = get_the_category();
							$ct='';
							foreach($ccat as $a => $cct){
								
								if( $a != 0 ){ $ct .= ', '; }
								$ct .= '<a href="'.get_category_link($cct->term_id ).'">'.$cct->cat_name.'</a>';
							}
							
							$num_comments = get_comments_number();
							$write_comments = "";
							if ( comments_open() ){
								  if($num_comments == 0){
									  $comments = __('0 Comments', 'wip');
								  }
								  elseif($num_comments > 1){
									  $comments = $num_comments. __(' Comments', 'wip');
								  }
								  else{
									   $comments = __('1 Comment', 'wip');
								  }
							 $write_comments = '<a href="' . get_comments_link($post->ID) .'">'. $comments.'</a>';
							}
							else {
								$write_comments = __('Comment Off', 'wip');
							}
							
							$content .= '<div class="full-column-blog-lists '.$colClass.' float_left">' . "\n";
							
							
									$content .= '<div class="full-column-blog-thumbnail">' . "\n";
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
									$content .= '<img src="'.$colImage.'" alt="'. the_title_attribute('echo=0') .'"/>';
									$content .= '</a>' . "\n";
									$content .= '</div>' . "\n";
									
									$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";
								
								if( $column == '4' ){
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ) .'</span>' . "\n";
								} else {
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ).'
												&ndash;
												'.__('In', 'wip').' '.$ct.'
												'.__('With', 'wip').' '.$write_comments .'
												</span>' . "\n";
								}
								
								if( $column == '2' ){
									$content .= wpautop( str_replace('[...]', '...', get_the_excerpt()) );
								} else {
									$content .= wpautop( limit_text( get_the_excerpt(), 120, '...') );
								}
							
							
							$content .= '</div>' . "\n";
							
							
							if( $intloop % $column == 0 ) $content .= '<div class="clear"></div>' . "\n";
							
							endwhile;
								
								if( $intloop % $column != 0 ) $content .= '<div class="clear"></div>' . "\n";
								
								$content .= '</div><!-- end .col_wraper -->' . "\n";
								
								$content .= ( $pagination ) ? wip_pagenavi( $args, false, '<div class="pagination_wrap">', '</div>' ) : '';
							
							else:
							
								$content .= __('No Posts Found!', 'wip');
							
							endif;
							wp_reset_postdata();
							
							
					
						break;
				
				
				}
			
			
			} else { /** if content use sidebar */
			
			
				switch( $layout_type ){
					
					case 'default':
					case 'default-fullwidth':
							
							$paged = ( $pagination ) ? ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ) : false;
							
							$args = array(
								'posts_per_page' => $post_per_page,
								'paged' => $paged
							);
							$blogquery = new WP_Query( $args );
							
							if( $blogquery->have_posts() ):
							while ($blogquery->have_posts()): $blogquery->the_post();
							global $post;
							
							
							$ccat = get_the_category();
							$ct='';
							foreach($ccat as $a => $cct){
								
								if( $a != 0 ){ $ct .= ', '; }
								$ct .= '<a href="'.get_category_link($cct->term_id ).'">'.$cct->cat_name.'</a>';
							}
							
							$num_comments = get_comments_number();
							$write_comments = "";
							if ( comments_open() ){
								  if($num_comments == 0){
									  $comments = __('0 Comments', 'wip');
								  }
								  elseif($num_comments > 1){
									  $comments = $num_comments. __(' Comments', 'wip');
								  }
								  else{
									   $comments = __('1 Comment', 'wip');
								  }
							 $write_comments = '<a href="' . get_comments_link($post->ID) .'">'. $comments.'</a>';
							}
							else {
								$write_comments = __('Comment Off', 'wip');
							}

							$the_full_content = apply_filters('the_content', get_the_content());
							
							$content .= '<div class="standard-blog-lists">' . "\n";	
								/** post with thumbnail */
								if( has_post_thumbnail() && wip_get_attached_file($post->ID) ){
								
									$content .= '<div class="standard-blog-thumbnail">' . "\n";
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
									$content .= '<img src="'. wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 700, 260 ) .'" alt="'. the_title_attribute('echo=0') .'"/>';
									$content .= '</a>' . "\n";
									$content .= '</div>' . "\n";
									
								}
								
									$content .= '<div class="standard-blog-excerpt">' . "\n";
									$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ).'
												&ndash;
												'.__('In', 'wip').' '.$ct.'
												'.__('With', 'wip').' '.$write_comments .'
												</span>' . "\n";
									$content .= ( $excerpt ) ? wpautop( str_replace('[...]', '...', get_the_excerpt()) ) : $the_full_content;
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'.__('Continue Reading', 'wip').' &rarr;</a>' . "\n";
									$content .= '</div>' . "\n";
							
							$content .= '</div>' . "\n";
							
							
							endwhile;
							
								$content .= ( $pagination ) ? wip_pagenavi( $args, false ) : '';
							
							else:
							
								$content .= __('No Posts Found!', 'wip');
							
							endif;
							wp_reset_postdata();
					
						break;
						
						
						
					case 'column':
					
							
							$paged = ( $pagination ) ? ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ) : false;
							
							$args = array(
								'posts_per_page' => $post_per_page,
								'paged' => $paged
							);
							$blogquery = new WP_Query( $args );
							
							if( $blogquery->have_posts() ):
							
							$content .= '<div class="col_wraper no_margin">' . "\n";
							
							$intloop = 0;
							
							while ($blogquery->have_posts()): $blogquery->the_post();
							
							$intloop++;
							global $post;
							
							
							$colClass = 'col_four';
							$colImage = "";
							switch( $column ){
								case '4':
										$colClass = 'col_four';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 160, 104 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
								case '3':
										$colClass = 'col_three';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 126 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
								case '2':
										$colClass = 'col_two';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 340, 192 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
							}
							
							
							$ccat = get_the_category();
							$ct='';
							foreach($ccat as $a => $cct){
								
								if( $a != 0 ){ $ct .= ', '; }
								$ct .= '<a href="'.get_category_link($cct->term_id ).'">'.$cct->cat_name.'</a>';
							}
							
							$num_comments = get_comments_number();
							$write_comments = "";
							if ( comments_open() ){
								  if($num_comments == 0){
									  $comments = __('0 Comments', 'wip');
								  }
								  elseif($num_comments > 1){
									  $comments = $num_comments. __(' Comments', 'wip');
								  }
								  else{
									   $comments = __('1 Comment', 'wip');
								  }
							 $write_comments = '<a href="' . get_comments_link($post->ID) .'">'. $comments.'</a>';
							}
							else {
								$write_comments = __('Comment Off', 'wip');
							}
							
							$specialStyle = "";
							if( ( $intloop == 1 ) || ( $intloop % $column == 1 ) ){
								$specialStyle = " no_margin_left";
							}
							if( $intloop % $column == 0 ){
								$specialStyle = " no_margin_right";
							}
							
							$blogtitle = get_the_title();
							if( $column == '4' ){
								$blogtitle = limit_text( get_the_title(), 25);
							}
							
							$content .= '<div class="column-blog-lists '.$colClass.' float_left'.$specialStyle.'">' . "\n";
							
							
									$content .= '<div class="column-blog-thumbnail">' . "\n";
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
									$content .= '<img src="'.$colImage.'" alt="'. the_title_attribute('echo=0') .'"/>';
									$content .= '</a>' . "\n";
									$content .= '</div>' . "\n";
									
									$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. $blogtitle .'</a></h3>' . "\n";
								
								if( $column == '4' || $column == '3' ){
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ) .'</span>' . "\n";
								} else {
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ).'
												&ndash;
												'.__('In', 'wip').' '.$ct.'
												'.__('With', 'wip').' '.$write_comments .'
												</span>' . "\n";
								}
								
								
								if( $column != '4' ){
									if( $column == '2' ){
										$content .= wpautop( str_replace('[...]', '...', get_the_excerpt()) );
									} else {
										$content .= wpautop( limit_text( get_the_excerpt(), 120, '...') );
									}
								}

							
							
							$content .= '</div>' . "\n";
							
							
							if( $intloop % $column == 0 ) $content .= '<div class="clear"></div>' . "\n";
							
							endwhile;
								
								if( $intloop % $column != 0 ) $content .= '<div class="clear"></div>' . "\n";
								
								$content .= '</div><!-- end .col_wraper -->' . "\n";
								
								$content .= ( $pagination ) ? wip_pagenavi( $args, false, '<div class="pagination_wrap">', '</div>' ) : '';
							
							else:
							
								$content .= __('No Posts Found!', 'wip');
							
							endif;
							wp_reset_postdata();
							
							
					
						break;
						
						
				}
			
			}

		
		return $content;
	
	}
	
	
	
	function _print_column_blog_lists( $count = 3 ){
	global $wpdb, $wp_query, $sidebar_layout, $fullwidth_layout;
		
		$parentLayout = ( $fullwidth_layout ) ? 'fullwidth' : 'content-sidebar';
		
		$content = '';
		$args = array(
			'posts_per_page' => $count,
			'paged' => false
		);
		$blogquery = new WP_Query( $args );
		
		if( $blogquery->have_posts() ):
		
		$content .= '<div class="col_wraper no_margin">' . "\n";
		
		$intloop = 0;
		
		while ($blogquery->have_posts()): $blogquery->the_post();
		
		$intloop++;
		global $post;

			
			$specialStyle = "";
			if( ( $intloop == 1 ) || ( $intloop % 3 == 1 ) ){
				$specialStyle = " no_margin_left";
			}
			if( $intloop % 3 == 0 ){
				$specialStyle = " no_margin_right";
			}
			
			$colImage = "";
			
			switch($parentLayout){
				
				case 'fullwidth':
				
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
							wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 120 )
							:
							get_template_directory_uri() . '/images/no-preview.jpg';
					
					break;
					
				case 'content-sidebar':
				
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
							wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 160, 104 )
							:
							get_template_directory_uri() . '/images/no-preview.jpg';
				
					break;
			
			}
			
			$content .= '<div class="column-blog-lists col_four float_left'.$specialStyle.'">' . "\n";
			
			
					$content .= '<div class="'. ( ($parentLayout == 'fullwidth' ) ? 'full-' : ''  ) .'column-blog-thumbnail">' . "\n";
					$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
					$content .= '<img src="'.$colImage.'" alt="'. the_title_attribute('echo=0') .'"/>';
					$content .= '</a>' . "\n";
					$content .= '</div>' . "\n";
					
					$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";

					$content .= '<span class="meta-blog-lists">
								'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
								&ndash;
								'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ) .'</span>' . "\n";
				
				

					$content .= wpautop( limit_text( get_the_excerpt(), 120, '...') );
			
			$content .= '</div>' . "\n";
			
			
			if( $intloop % 3 == 0 ) $content .= '<div class="clear"></div>' . "\n";
			
		endwhile;
				
			if( $intloop % 3 != 0 ) $content .= '<div class="clear"></div>' . "\n";
				
			$content .= '</div><!-- end .col_wraper -->' . "\n";
			
		else:
			
			$content .= __('No Posts Found!', 'wip');
			
		endif;
		wp_reset_postdata();

			
		return $content;
	
	}
	
	
	
	
	
	
	
	function _print_blog_category_lists( $layout_type, $column = 4 ){
	global $wpdb, $wp_query, $sidebar_layout, $fullwidth_layout;
	
	$parentLayout = ( $fullwidth_layout ) ? 'fullwidth' : 'content-sidebar';
	
	$content = '';

			if( $parentLayout == 'fullwidth' ){
				
				switch( $layout_type ){

					case 'default':
						
							$content .= '<div class="wrap_940 plus_padding">' . "\n";

							if( have_posts()):
							while (have_posts()): the_post();
							global $post;
							
							
							$ccat = get_the_category();
							$ct='';
							foreach($ccat as $a => $cct){
								
								if( $a != 0 ){ $ct .= ', '; }
								$ct .= '<a href="'.get_category_link($cct->term_id ).'">'.$cct->cat_name.'</a>';
							}
							
							$num_comments = get_comments_number();
							$write_comments = "";
							if ( comments_open() ){
								  if($num_comments == 0){
									  $comments = __('0 Comments', 'wip');
								  }
								  elseif($num_comments > 1){
									  $comments = $num_comments. __(' Comments', 'wip');
								  }
								  else{
									   $comments = __('1 Comment', 'wip');
								  }
							 $write_comments = '<a href="' . get_comments_link($post->ID) .'">'. $comments.'</a>';
							}
							else {
								$write_comments = __('Comment Off', 'wip');
							}
							
							$content .= '<div class="fullwidth-blog-lists">' . "\n";	
								/** post with thumbnail */
								if( has_post_thumbnail() && wip_get_attached_file($post->ID) ){
								
									$content .= '<div class="fullwidth-blog-excerpt">' . "\n";
									$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ).'
												&ndash;
												'.__('In', 'wip').' '.$ct.'
												'.__('With', 'wip').' '.$write_comments .'
												</span>' . "\n";
									$content .= wpautop( str_replace('[...]', '...', get_the_excerpt()) );
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'.__('Continue Reading', 'wip').' &rarr;</a>' . "\n";
									$content .= '</div>' . "\n";
								
									$content .= '<div class="fullwidth-blog-thumbnail">' . "\n";
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
									$content .= '<img src="'. wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 460, 220 ) .'" alt="'. the_title_attribute('echo=0') .'"/>';
									$content .= '</a>' . "\n";
									$content .= '</div>' . "\n";
									
									$content .= '<div class="clear"></div>' . "\n";
									
								} else {
								
									$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ).'
												&ndash;
												'.__('In', 'wip').' '.$ct.'
												'.__('With', 'wip').' '.$write_comments .'
												</span>' . "\n";
									$content .= wpautop( str_replace('[...]', '...', get_the_excerpt()) );
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'.__('Continue Reading', 'wip').' &rarr;</a>' . "\n";
								
								}
							
							$content .= '</div>' . "\n";
							
							
							endwhile;
							
								$content .= wip_pagenavi( '', false );
							
							else:
							
								$content .= __('No Posts Found!', 'wip');
							
							endif;
							wp_reset_postdata();
							
							$content .= '</div><!-- end .wrap_940 -->' . "\n";
					
						break;
						
						
					case 'column':
							
							if( have_posts()):
							
							$content .= '<div class="col_wraper no_margin">' . "\n";
							$intloop = 0;
							
							while (have_posts()): the_post();						
							$intloop++;
							global $post;
							
							
							$colClass = 'col_four';
							$colImage = "";
							switch( $column ){
								case '4':
										$colClass = 'col_four';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 120 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
								case '3':
										$colClass = 'col_three';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 300, 166 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
								case '2':
										$colClass = 'col_two';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 460, 258 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
							}
							
							
							$ccat = get_the_category();
							$ct='';
							foreach($ccat as $a => $cct){
								
								if( $a != 0 ){ $ct .= ', '; }
								$ct .= '<a href="'.get_category_link($cct->term_id ).'">'.$cct->cat_name.'</a>';
							}
							
							$num_comments = get_comments_number();
							$write_comments = "";
							if ( comments_open() ){
								  if($num_comments == 0){
									  $comments = __('0 Comments', 'wip');
								  }
								  elseif($num_comments > 1){
									  $comments = $num_comments. __(' Comments', 'wip');
								  }
								  else{
									   $comments = __('1 Comment', 'wip');
								  }
							 $write_comments = '<a href="' . get_comments_link($post->ID) .'">'. $comments.'</a>';
							}
							else {
								$write_comments = __('Comment Off', 'wip');
							}
							
							$content .= '<div class="full-column-blog-lists '.$colClass.' float_left">' . "\n";
							
							
									$content .= '<div class="full-column-blog-thumbnail">' . "\n";
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
									$content .= '<img src="'.$colImage.'" alt="'. the_title_attribute('echo=0') .'"/>';
									$content .= '</a>' . "\n";
									$content .= '</div>' . "\n";
									
									$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";
								
								if( $column == '4' ){
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ) .'</span>' . "\n";
								} else {
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ).'
												&ndash;
												'.__('In', 'wip').' '.$ct.'
												'.__('With', 'wip').' '.$write_comments .'
												</span>' . "\n";
								}
								
								if( $column == '2' ){
									$content .= wpautop( str_replace('[...]', '...', get_the_excerpt()) );
								} else {
									$content .= wpautop( limit_text( get_the_excerpt(), 120, '...') );
								}
							
							
							$content .= '</div>' . "\n";
							
							
							if( $intloop % $column == 0 ) $content .= '<div class="clear"></div>' . "\n";
							
							endwhile;
								
								if( $intloop % $column != 0 ) $content .= '<div class="clear"></div>' . "\n";
								
								$content .= '</div><!-- end .col_wraper -->' . "\n";
								
								$content .= wip_pagenavi( '', false, '<div class="pagination_wrap">', '</div>' );
							
							else:
							
								$content .= __('No Posts Found!', 'wip');
							
							endif;
							wp_reset_postdata();
							
							
					
						break;
				
				
				}
			
			
			} else { /** if content use sidebar */
			
			
				switch( $layout_type ){
					
					case 'default':
					case 'default-fullwidth':
							
							if( have_posts()):
							while (have_posts()): the_post();
							global $post;
							
							
							$ccat = get_the_category();
							$ct='';
							foreach($ccat as $a => $cct){
								
								if( $a != 0 ){ $ct .= ', '; }
								$ct .= '<a href="'.get_category_link($cct->term_id ).'">'.$cct->cat_name.'</a>';
							}
							
							$num_comments = get_comments_number();
							$write_comments = "";
							if ( comments_open() ){
								  if($num_comments == 0){
									  $comments = __('0 Comments', 'wip');
								  }
								  elseif($num_comments > 1){
									  $comments = $num_comments. __(' Comments', 'wip');
								  }
								  else{
									   $comments = __('1 Comment', 'wip');
								  }
							 $write_comments = '<a href="' . get_comments_link($post->ID) .'">'. $comments.'</a>';
							}
							else {
								$write_comments = __('Comment Off', 'wip');
							}
							
							$content .= '<div class="standard-blog-lists">' . "\n";	
								/** post with thumbnail */
								if( has_post_thumbnail() && wip_get_attached_file($post->ID) ){
								
									$content .= '<div class="standard-blog-thumbnail">' . "\n";
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
									$content .= '<img src="'. wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 700, 260 ) .'" alt="'. the_title_attribute('echo=0') .'"/>';
									$content .= '</a>' . "\n";
									$content .= '</div>' . "\n";
									
								}
								
									$content .= '<div class="standard-blog-excerpt">' . "\n";
									$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ).'
												&ndash;
												'.__('In', 'wip').' '.$ct.'
												'.__('With', 'wip').' '.$write_comments .'
												</span>' . "\n";
									$content .= wpautop( str_replace('[...]', '...', get_the_excerpt()) );
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'.__('Continue Reading', 'wip').' &rarr;</a>' . "\n";
									$content .= '</div>' . "\n";
							
							$content .= '</div>' . "\n";
							
							
							endwhile;
							
								$content .= wip_pagenavi( '', false );
							
							else:
							
								$content .= __('No Posts Found!', 'wip');
							
							endif;
							wp_reset_postdata();
					
						break;
						
						
						
					case 'column':
					
							
							if( have_posts()):
							
							$content .= '<div class="col_wraper no_margin">' . "\n";
							
							$intloop = 0;
							
							while (have_posts()): the_post();
							
							$intloop++;
							global $post;
							
							
							$colClass = 'col_four';
							$colImage = "";
							switch( $column ){
								case '4':
										$colClass = 'col_four';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 160, 104 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
								case '3':
										$colClass = 'col_three';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 126 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
								case '2':
										$colClass = 'col_two';
										$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
													wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 340, 192 )
													:
													get_template_directory_uri() . '/images/no-preview.jpg';
									break;
							}
							
							
							$ccat = get_the_category();
							$ct='';
							foreach($ccat as $a => $cct){
								
								if( $a != 0 ){ $ct .= ', '; }
								$ct .= '<a href="'.get_category_link($cct->term_id ).'">'.$cct->cat_name.'</a>';
							}
							
							$num_comments = get_comments_number();
							$write_comments = "";
							if ( comments_open() ){
								  if($num_comments == 0){
									  $comments = __('0 Comments', 'wip');
								  }
								  elseif($num_comments > 1){
									  $comments = $num_comments. __(' Comments', 'wip');
								  }
								  else{
									   $comments = __('1 Comment', 'wip');
								  }
							 $write_comments = '<a href="' . get_comments_link($post->ID) .'">'. $comments.'</a>';
							}
							else {
								$write_comments = __('Comment Off', 'wip');
							}
							
							$specialStyle = "";
							if( ( $intloop == 1 ) || ( $intloop % $column == 1 ) ){
								$specialStyle = " no_margin_left";
							}
							if( $intloop % $column == 0 ){
								$specialStyle = " no_margin_right";
							}
							
							$blogtitle = get_the_title();
							if( $column == '4' ){
								$blogtitle = limit_text( get_the_title(), 25);
							}
							
							$content .= '<div class="column-blog-lists '.$colClass.' float_left'.$specialStyle.'">' . "\n";
							
							
									$content .= '<div class="column-blog-thumbnail">' . "\n";
									$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
									$content .= '<img src="'.$colImage.'" alt="'. the_title_attribute('echo=0') .'"/>';
									$content .= '</a>' . "\n";
									$content .= '</div>' . "\n";
									
									$content .= '<h3 class="blog-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. $blogtitle .'</a></h3>' . "\n";
								
								if( $column == '4' || $column == '3' ){
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ) .'</span>' . "\n";
								} else {
									$content .= '<span class="meta-blog-lists">
												'.__('By', 'wip').' <a href="'.get_author_posts_url( get_the_author_meta('ID') ).'">'.get_the_author_meta('display_name').'</a>
												&ndash;
												'.__('On', 'wip').' '.sprintf( __('%1$s', 'wip'), get_the_time('F d, Y', $post->ID) ).'
												&ndash;
												'.__('In', 'wip').' '.$ct.'
												'.__('With', 'wip').' '.$write_comments .'
												</span>' . "\n";
								}
								
								
								if( $column != '4' ){
									if( $column == '2' ){
										$content .= wpautop( str_replace('[...]', '...', get_the_excerpt()) );
									} else {
										$content .= wpautop( limit_text( get_the_excerpt(), 120, '...') );
									}
								}

							
							
							$content .= '</div>' . "\n";
							
							
							if( $intloop % $column == 0 ) $content .= '<div class="clear"></div>' . "\n";
							
							endwhile;
								
								if( $intloop % $column != 0 ) $content .= '<div class="clear"></div>' . "\n";
								
								$content .= '</div><!-- end .col_wraper -->' . "\n";
								
								$content .= wip_pagenavi( '', false, '<div class="pagination_wrap">', '</div>' );
							
							else:
							
								$content .= __('No Posts Found!', 'wip');
							
							endif;
							wp_reset_postdata();
							
							
					
						break;
						
						
				}
			
			}

		
		return $content;
	
	
	
	}
	
	
	
	
	
	
	
	function _print_column_portfolio_lists( $count, $catID ){
	
	$content = "";
	$args = array(
		'post_type'	=> 'portfolio-item',
		'post_status' => 'publish',
		'ignore_sticky_posts'	=> 1,
		'posts_per_page' => $count,
		'paged' => false
	);

	if( $catID && $catID != "" && $catID !== 0 ){
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'portfolio-category',
				'field' => 'id',
				'terms' => intval($catID),
				'operator' => 'IN'
			)
		);
	}
	
		$pQuery = new WP_Query( $args );
		
		if( $pQuery->have_posts() ):
		
		$content .= '<div class="col_wraper no_margin">' . "\n";
		
		$intloop = 0;
		
		while ($pQuery->have_posts()): $pQuery->the_post();
		
		$intloop++;
		global $post;
		
			$specialStyle = "";
			if( ( $intloop == 1 ) || ( $intloop % 3 == 1 ) ){
				$specialStyle = " no_margin_left";
			}
			if( $intloop % 3 == 0 ){
				$specialStyle = " no_margin_right";
			}
			
			$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 168, true ) : '';
			
			$colImage = ( is_array( $imgArray ) ) ? 
						$imgArray['url']
						:
						get_template_directory_uri() . '/images/no-preview.jpg';
						
			$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';
		
		
			$content .= '<div class="col_four float_left'.$specialStyle.'">' . "\n";
			
					$content .= '<div class="portfolio-thumbnail">' . "\n";
					$content .= '<a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">' . "\n";
					$content .= '<img class="portfolio-grayscale" src="'.$colImageGrayscale.'" alt="'. the_title_attribute('echo=0') .'"/>';
					$content .= '<img class="portfolio-original" src="'.$colImage.'" alt="'. the_title_attribute('echo=0') .'"/>';
					$content .= '</a>' . "\n";
					$content .= '</div>' . "\n";
					
					$content .= '<h3 class="portfolio-list-title"><a href="'. get_permalink($post->ID) .'" title="'. sprintf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ) .'">'. get_the_title() .'</a></h3>' . "\n";

					if ($post->post_excerpt){
						$content .= wpautop(wptexturize($post->post_excerpt));
					}
			
			$content .= '</div>' . "\n";
		
		
		
			if( $intloop % 3 == 0 ) $content .= '<div class="clear"></div>' . "\n";
			
		endwhile;
				
			if( $intloop % 3 != 0 ) $content .= '<div class="clear"></div>' . "\n";
				
			$content .= '</div><!-- end .col_wraper -->' . "\n";
			
		else:
			
			$content .= __('No Posts Found!', 'wip');
			
		endif;
		wp_reset_postdata();

			
		return $content;
	
	}
	
	
	function _get_columnmix_concept($type){
		
		$colConcept = "";
		
		switch($type){
			case '1_2_3col':	
				$colConcept = array('1/3','2/3');
				break;
				
			case '2_1_3col':	
				$colConcept = array('2/3','1/3');
				break;
				
			case '1_1_2_4col':	
				$colConcept = array('1/4','1/4','2/4');
				break;
				
			case '1_2_1_4col':
				$colConcept = array('1/4','2/4','1/4');
				break;
				
			case '2_1_1_4col':
				$colConcept = array('2/4','1/4','1/4');
				break;
				
			case '1_3_4col':		
				$colConcept = array('1/4','3/4');
				break;
				
			case '3_1_4col':
				$colConcept = array('3/4','1/4');
				break;
		}
	
		return $colConcept;
	}
	

}


}
?>