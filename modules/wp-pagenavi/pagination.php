<?php

/* WP-PageNavi */

function jnn_round($num, $tonearest) {
   return floor($num/$tonearest)*$tonearest;
}

/**
 * Change the function name, minimalize the conflict when user define to use the original plugin :)
 */
function wip_pagenavi( $custom = "", $echo = true, $before = "", $after = "") {
	
	global $wpdb, $wp_query;
	$befored = $before;
	$aftered = $after;
	$wippagenavi = '';
	
	$wp_query_custom = $wp_query;
	if( is_array( $custom ) ){
		$wp_query_custom = new WP_Query( $custom );
	}
	
	if (!is_single()) {
		$request = $wp_query_custom->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$numposts = $wp_query_custom->found_posts;
		$max_page = $wp_query_custom->max_num_pages;
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$pages_to_show = intval(5);
		$larger_page_to_show = intval(3);
		$larger_page_multiple = intval(10);
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		$larger_per_page = $larger_page_to_show*$larger_page_multiple;
		$larger_start_page_start = (jnn_round($start_page, 10) + $larger_page_multiple) - $larger_per_page;
		$larger_start_page_end = jnn_round($start_page, 10) + $larger_page_multiple;
		$larger_end_page_start = jnn_round($end_page, 10) + $larger_page_multiple;
		$larger_end_page_end = jnn_round($end_page, 10) + ($larger_per_page);
		if($larger_start_page_end - $larger_page_multiple == $start_page) {
			$larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
			$larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
		}
		if($larger_start_page_start <= 0) {
			$larger_start_page_start = $larger_page_multiple;
		}
		if($larger_start_page_end > $max_page) {
			$larger_start_page_end = $max_page;
		}
		if($larger_end_page_end > $max_page) {
			$larger_end_page_end = $max_page;
		}
		if($max_page > 1) {
			$pages_text = sprintf( __('Page %1$s of %2$s', 'wip'), number_format_i18n($paged), number_format_i18n($max_page) );
			$wippagenavi .= $befored.'<div class="wip-pagenavi">'."\n";

					if(!empty($pages_text)) {
						$wippagenavi .= '<div class="pagination_text">'.$pages_text.'</div>';
					}
					
					$wippagenavi .= '<div class="pagination_content">';
					
					if ($start_page >= 2 && $pages_to_show < $max_page) {
						$first_page_text = __('First', 'wip');
						$wippagenavi .= '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'">'.$first_page_text.'</a>';
							$wippagenavi .= '<span class="extend">...</span>';
					}
					if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
						for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), addslashes("%PAGE_NUMBER%") );
							$wippagenavi .= '<a href="'.esc_url(get_pagenum_link($i)).'" class="page" title="'.$page_text.'">'.$page_text.'</a>';
						}
					}
					$wippagenavi .= get_previous_posts_link( addslashes('&laquo;') );
					for($i = $start_page; $i  <= $end_page; $i++) {						
						if($i == $paged) {
							$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), addslashes("%PAGE_NUMBER%") );
							$wippagenavi .= '<span class="current">'.$current_page_text.'</span>';
						} else {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), addslashes("%PAGE_NUMBER%") );
							$wippagenavi .= '<a href="'.esc_url(get_pagenum_link($i)).'" class="page" title="'.$page_text.'">'.$page_text.'</a>';
						}
					}
					$wippagenavi .= get_next_posts_link( addslashes('&raquo;'), $max_page);
					if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
						for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), addslashes("%PAGE_NUMBER%") );
							$wippagenavi .= '<a href="'.esc_url(get_pagenum_link($i)).'" class="page" title="'.$page_text.'">'.$page_text.'</a>';
						}
					}
					if ($end_page < $max_page) {
						$wippagenavi .= '<span class="extend">...</span>';
						$last_page_text = __('Last', 'wip');
						$wippagenavi .= '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="'.$last_page_text.'">'.$last_page_text.'</a>';
					}
					$wippagenavi .= '</div>' . "\n";
					
				$wippagenavi .= '<div class="clear"></div>';
			$wippagenavi .= '</div>'.$aftered."\n";
			
		}
	}
	
	if( $echo ){
		echo $wippagenavi;
	} else {
		return $wippagenavi;
	}
}

?>