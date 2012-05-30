<?php
/**
 * Custom menu helper file
 * modif the result of menu, 
 * the HTML, will help alot when people turn off their browser javascript
 */
function _wip_print_main_menu(){
	global $wp_query;

	$queried_object = $wp_query->get_queried_object();
	$queried_object_id = (int) $wp_query->queried_object_id;
	
	$locations = get_nav_menu_locations();
	$menu = wp_get_nav_menu_object( $locations[ 'main' ] );
	$menu_items = wp_get_nav_menu_items( $menu->term_id );

	$front_page_url = home_url();
	
	_wp_menu_item_classes_by_context( $menu_items );
	
	/* return 1st, the Ul */
	$return = '<ul id="main-nav">' . "\n";
	
	$menunu = array();
	foreach( (array) $menu_items as $key => $menu_item ){
	
		$menunu[ (int) $menu_item->db_id ] = $menu_item;
	
	}
	unset($menu_items);
	
	
	$rep = array();
	foreach ( $menunu as $d => $m ){
		if($m->menu_item_parent == '0'){
			$rep[] = $m;
		}
	};
	
	
	
	$a = 0;
	foreach ( $menunu as $i => $men ){
		
		if($men->menu_item_parent == '0'){
			$a++;
			
			$liClass = '';
			$arrow = '';
			$aClass = '';
			if( _wip_detect_menu_child($i, false) ) {
				$liClass = ' class="haschild';
				$arrow = '<span class="menu-arrow"></span>';
			}	
			
			if( $a == count($rep) ){
				
				if( _wip_detect_menu_child($i, false) ) {	
					$liClass .= ' main-nav-last"';
				} else {
					$liClass = ' class="main-nav-last"';
				}
				
				$aClass = 'main-nav-last-item ';
			
			} else {
			
				if( _wip_detect_menu_child($i, false) )	$liClass .= '"';
			
			}
			
			if( $queried_object_id == $men->object_id &&
				(
					( 'post_type' == $men->type && $wp_query->is_singular ) ||
					( 'taxonomy' == $men->type && ( $wp_query->is_category || $wp_query->is_tag || $wp_query->is_tax ) )
				) ||
				( woocommerce_found() && ( is_shop() && $men->object_id == (int) woocommerce_get_page_id('shop') ) )
			) {

				$aClass .= 'pageactive ';
			
			} elseif ( 'custom' == $men->object ) {
				$_root_relative_current = untrailingslashit( $_SERVER['REQUEST_URI'] );
				$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_root_relative_current;
				$raw_item_url = strpos( $men->url, '#' ) ? substr( $men->url, 0, strpos( $men->url, '#' ) ) : $men->url;
				$item_url = untrailingslashit( $raw_item_url );
				$_indexless_current = untrailingslashit( preg_replace( '/index.php$/', '', $current_url ) );

				if ( $raw_item_url && in_array( $item_url, array( $current_url, $_indexless_current, $_root_relative_current ) ) ) {
					$aClass .= 'pageactive ';
				} elseif ( $item_url == $front_page_url && is_front_page() ) {
					$aClass .= 'pageactive ';
				}

			}

			$return .= '<li'.$liClass.'>' . "\n";
				$href = esc_attr($men->url);
				$target = ( $men->target != "" ) ? ' target="'.esc_attr($men->target).'"' : '';

				$return .= '<a class="'.$aClass.'wip-menu-' . $men->type . '-' . $men->object_id . '" href="'. $href .'"'.$target.'>' . esc_attr($men->title) . $arrow . '</a>' . "\n";

				if( _wip_detect_menu_child($i, false) ){
					$return .= _wip_detect_menu_child($i, true);
				}
			$return .= '</li>' . "\n";
		}
	
	}
	
	unset($menunu);
	
	$return .= '</ul>' . "\n";
	
	echo $return;

}



/**
 * Detect if the li has ul child (based on custom menu data)
 */
function _wip_detect_menu_child($parent, $echo = false){
	global $wp_query;

	$queried_object = $wp_query->get_queried_object();
	$queried_object_id = (int) $wp_query->queried_object_id;
	
	$parent = ($parent != "") ? $parent : '0';

	$front_page_url = home_url();

	$locations = get_nav_menu_locations();
	$menu = wp_get_nav_menu_object( $locations[ 'main' ] );
	$menu_items = wp_get_nav_menu_items( $menu->term_id );
	
	_wp_menu_item_classes_by_context( $menu_items );
	
	$menu_next = array();
	foreach( (array) $menu_items as $key => $menu_item ){
		if($menu_item->menu_item_parent == $parent)
			$menu_next[ (int) $menu_item->db_id ] = $menu_item;
	}
	unset ($menu_items);
	
	if( !$echo ){
		if( !empty($menu_next) )
			return true;
		else
			return false;
	} else {
		$child_ul = '<ul class="child">' . "\n";
		$ret = '';
		$c = 0;
			foreach ( $menu_next as $i => $mnn ){
			$c++;

				$liClass = '';
				$arrow = '';
				$aClass = '';
				
				if( _wip_detect_menu_child($i, false) ) {
					$liClass = ' class="haschild';
					$arrow = '<span class="menu-arrow"></span>';
				}

				if( _wip_detect_menu_child($i, false) && $c == count($menu_next) ){
					$liClass .= ' droplast"'; 
				} else if( !_wip_detect_menu_child($i, false) && ( $c == count($menu_next) ) ) {
					$liClass = ' class="droplast"';
				} else if(_wip_detect_menu_child($i, false) && $c != count($menu_next)){
					$liClass .= '"';
				}
				
				if( $queried_object_id == $mnn->object_id &&
					(
						( 'post_type' == $mnn->type && $wp_query->is_singular ) ||
						( 'taxonomy' == $mnn->type && ( $wp_query->is_category || $wp_query->is_tag || $wp_query->is_tax ) )
					) ||
					( woocommerce_found() && ( is_shop() && $mnn->object_id == (int) woocommerce_get_page_id('shop') ) )
				) {
					$aClass .= 'pageactive ';
				} elseif ( 'custom' == $mnn->object ) {
					$_root_relative_current = untrailingslashit( $_SERVER['REQUEST_URI'] );
					$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_root_relative_current;
					$raw_item_url = strpos( $mnn->url, '#' ) ? substr( $mnn->url, 0, strpos( $mnn->url, '#' ) ) : $mnn->url;
					$item_url = untrailingslashit( $raw_item_url );
					$_indexless_current = untrailingslashit( preg_replace( '/index.php$/', '', $current_url ) );

					if ( $raw_item_url && in_array( $item_url, array( $current_url, $_indexless_current, $_root_relative_current ) ) ) {
						$aClass .= 'pageactive ';
					} elseif ( $item_url == $front_page_url && is_front_page() ) {
						$aClass .= 'pageactive ';
					}

				}

				
				$ret .= '<li'.$liClass.'>' . "\n";
				
				$href = esc_attr($mnn->url);
				$target = ( $mnn->target != "" ) ? ' target="'.esc_attr($mnn->target).'"' : '';

					$ret .= '<a class="'.$aClass.'wip-menu-' . $mnn->type . '-' . $mnn->object_id . '" href="'.$href.'"'.$target.'>' . esc_attr($mnn->title) . $arrow . '</a>' . "\n";
				
				if( _wip_detect_menu_child($i, false) ){
					$ret .= _wip_detect_menu_child($i, true);
				}
				
				$ret .= '</li>' . "\n";
			}
			unset ($menu_next);
		$child_ul_close = '</ul>' . "\n";
		
		if( !empty($ret) )
			return $child_ul . $ret . $child_ul_close;
	}
}
?>