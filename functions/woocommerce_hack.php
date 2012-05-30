<?php
# Only call all functions below, if only WooCommerce is active
if( woocommerce_found() ):
	global $wpdb, $wp_query, $woocommerce;
	
if(!is_admin()){
	define('WOOCOMMERCE_USE_CSS', false);
}

add_action('wp_print_styles', 'wip_woo_custom_css');
function wip_woo_custom_css(){
	if(!is_admin()){
		wp_register_style( 'wip_woocommerce', get_template_directory_uri() . '/css/woocommerce_custom.css', array('wip_base'), '1.0');
		wp_enqueue_style( 'wip_woocommerce' );
	}
}


/**
 * throw global variable if single product page detected!
 * helps alot to define the layout!
 */
add_filter('wp_head', 'wip_detect_single_product');
function wip_detect_single_product(){
	global $query, $wp_query;
	
	if( ( is_single() && get_post_type() == 'product' ) || ( is_page( woocommerce_get_page_id('cart') ) ) ){
		$GLOBALS['wip_woo_single'] = true;
	}
	else {
		$GLOBALS['wip_woo_single'] = false; //reset
	}
}


# remove action
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);	#remove thumbnail
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10); 				#remove original place for price, we will move this component into another place
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);		#remove on-sale notice
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);				#remove add-to-cart button
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);					#remove default "open" container
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);					#remove default "close" container
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);											#remove call sidebar function from woocommerce
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);								#remove breadcrumb
remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );									#remove filtering option, move it on top
remove_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );										#remove woocommerce pagination
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);			#remove default related product

# change the default with theme functions
add_action( 'woocommerce_before_main_content', '_wip_output_content_wrapper', 10);								#add "open" container
add_action( 'woocommerce_before_shop_loop', '_wip_output_before_shop_loop_item_archive', 10);					#since woocommerce hardcoded the page title, we need this to wrap it, to match our theme style
add_action( 'wip_woocommerce_after_before_main_content', 'woocommerce_catalog_ordering', 20, 0);				#move filter to the top
add_action( 'woocommerce_after_main_content', '_wip_output_content_wrapper_end', 10);							#add "close" container
add_action( 'woocommerce_before_shop_loop_item', '_wip_dynamically_call_product_thumbnail', 10); 				#theme thumbnail function
add_action('woocommerce_before_shop_loop_item', '_wip_cache_start_get_title_on_lists', 20);
add_action('woocommerce_after_shop_loop_item', '_wip_cache_end_get_title_on_lists', 5);
add_action( 'woocommerce_before_shop_loop', '_wip_autodetect_parent_layout', 10);								#detect parent layout, this theme is NO, NEVER use % for column width of layout!!!!!
add_action( 'woocommerce_after_shop_loop', create_function('', 'echo "</div>";'), 10);							#close the div
add_action( 'woocommerce_pagination', '_wip_pagenavi_for_woo', 10 );											#add pagination
add_action( 'woocommerce_after_single_product_summary', '_wip_woo_related_products', 20);						#add related products

add_filter('loop_shop_per_page', create_function('$cols', 'return intval( get_wip_option_by("bd_shoppage_postperpage", 12) );'));



function _wip_output_content_wrapper(){
	//query_posts( $prodQuery );
	
	if( is_tax('product_cat') || 
		is_tax('product_tag') || 
		( is_post_type_archive('product') ||  is_page( woocommerce_get_page_id('shop') ))
	){
	global $woocommerce_loop;
	
	$woocommerce_loop['columns'] = $woocommerce_loop['wip_cols'] = intval( get_wip_option_by('bd_shoppage_columns', 4) );
	$woocommerce_loop['parent_layout'] = get_wip_option_by('bd_shoppage_layout', 'content-sidebar');
	
		ob_start();
	}
	
	
	if( is_singular('product') ){
		
		echo '<!-- MAIN SECTION -->
		<div id="main-inner-site">' . "\n";
		do_action('wip_before_content');
		echo '<div class="wrap_960">' . "\n";
		
		echo '<div class="wip-product-single-page">' . "\n";
		
	}
	
}


function _wip_output_before_shop_loop_item_archive(){
	global $sidebar_layout, $fullwidth_layout, $wip_woo_single;
	
	if( !$wip_woo_single && !$sidebar_layout && !$fullwidth_layout ){
	global $query, $woocommerce, $woocommerce_loop;
	
	$ct = "";
	$cts = "";
	$title = "";
	
		if( is_tax('product_cat') || 
			is_tax('product_tag') || 
			( is_post_type_archive('product') ||  is_page( woocommerce_get_page_id('shop') ))
		  ) 
		{
		
		
			$ct = ob_get_clean();
			$cts = preg_replace('/(<h1 class="page-title">.+?)+(<\/h1>)/i', '', $ct);
			$title = preg_match_all("|<[^>]+>(.*)</[^>]+>|U", $ct, $out, PREG_PATTERN_ORDER);
			
			
			
			echo '<div id="single-page-title">' . "\n";
			echo '<div class="wrap_940">' . "\n";
			
			
			
			if( isset( $out[0][0] ) ) echo $out[0][0] . "\n";
			
			
			if( get_option('bd_top_productsearch_off') !== '0' ){
				echo '<form role="search" method="get" id="top_product_searchform" action="'. esc_url( home_url() ) .'">
					<div>
						<input type="text" value="'. get_search_query() .'" name="s" id="top_product_s" placeholder="'. __('Search for products', 'wip') .'" />
						<input type="hidden" name="post_type" value="product" />
					</div>
				</form>' . "\n";
			}
			
			echo '<div class="clear"></div>' . "\n";
			echo '</div>' . "\n"; // close wrap_930
			echo '</div>' . "\n"; // close single-page-title
		
		}
		

		echo '<!-- MAIN SECTION -->
		<div id="main-inner-site">' . "\n";
		do_action('wip_before_content');
		echo '<div class="wrap_960">' . "\n";
		
		if( $woocommerce_loop['parent_layout'] != 'fullwidth' ){
			echo '<div class="area_with_sidebar '. ( ( $woocommerce_loop['parent_layout'] == 'content-sidebar' ) ? 'area_left' : 'area_right' ) .'">' . "\n";
		}
		
		
		if( $cts != "" ) echo $cts;
		
		do_action('wip_woocommerce_after_before_main_content'); //place the product filter option here
		echo "\n";
		
	}
	
}



function _wip_output_content_wrapper_end(){
	global $woocommerce_loop, $wip_woo_single;
	
	if( !$wip_woo_single && $woocommerce_loop['parent_layout'] != 'fullwidth' ){
		echo '</div><!-- end .area_with_sidebar -->' . "\n";
		
		/** we have remove woocommerce_get_sidebar() and call sidebar right from here */
		echo '<div class="sidebar_block '. ( ( $woocommerce_loop['parent_layout'] == 'content-sidebar' ) ? 'area_right' : 'area_left' ) .'">' . "\n";
		wip_generated_dynamic_sidebar( get_wip_option_by('bd_shoppage_sidebar', 'Default Sidebar') );
		wp_reset_postdata(); #woocommerce not reset it's query in lots of widgets!!!
		echo '</div>' . "\n";
		echo '<div class="clear"></div>' . "\n";
	}

	if( $wip_woo_single ){
		echo '<div class="clear"></div>' . "\n";
		echo '</div><!-- end .wip-product-single-page -->' . "\n";
	}

	wip_layout_helper::_delete_global_layout();//reset global layout
	
		
	echo '</div><!-- end .wrap_960 -->' . "\n";
	echo '</div><!-- end MAIN SECTION -->' . "\n";
}


/** single action hack! */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_after_single_product', 'woocommerce_upsell_display');
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

add_action( 'woocommerce_before_single_product', 'woocommerce_template_single_title', 20 );
add_action( 'woocommerce_before_single_product', 'woocommerce_template_single_meta', 25 );
add_action( 'woocommerce_before_single_product_summary', '_wip_single_product_before_gallery', 5);
add_action( 'woocommerce_before_single_product_summary', '_wip_single_product_before_summary', 25);
add_action( 'woocommerce_after_single_product_summary', '_wip_single_product_before_tabs', 5);
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 25);
add_action( 'woocommerce_product_tabs', '_wip_product_gallery_tab', 15 );
add_action( 'woocommerce_product_tab_panels', '_wip_product_gallery_panel', 15 );
add_action( 'woocommerce_before_add_to_cart_button', '_wip_simple_product_button_wrap_start', 10);
add_action( 'woocommerce_after_add_to_cart_button', '_wip_simple_product_button_wrap_end', 10);

add_filter('single_add_to_cart_text', '_wip_single_addtocart_text');


function _wip_single_addtocart_text(){
	return '<span>'.__('Add to cart', 'wip').'</span>';
}



function _wip_simple_product_button_wrap_start(){
	global $product;
	if( $product->product_type == 'simple' ){
		echo '<div class="variations_button">' . "\n";
	}
}


function _wip_simple_product_button_wrap_end(){
	global $product;
	if( $product->product_type == 'simple' ){
		echo '</div>' . "\n";
	}
}


function _wip_single_product_before_gallery(){
	global $post, $product;

	$ribbon = get_wip_option_by('bd_single_shoppage_price', 'dark');

	echo '<div id="product_gallery_and_summary">' . "\n";
	echo '<div class="woo_product_gallery gallery-on-left">' . "\n";
	
	echo '<div itemprop="price" id="woo_price_ribbon" class="'.$ribbon.'">'. $product->get_price_html() .'</div>' . "\n";
}

function _wip_single_product_before_summary(){

	echo '</div><!-- close .woo_product_gallery -->' . "\n";
	echo '<div class="woo_product_content float_right">' . "\n";

}

function _wip_single_product_before_tabs(){
		echo '</div><!-- close .woo_product_content -->' . "\n";
	echo '<div class="clear"></div>' . "\n";
	echo '</div><!-- close #product_gallery_and_summary -->' . "\n";
}



function _wip_product_gallery_tab(){
	echo '<li><a href="#tab-gallery">' . __('Gallery', 'wip') . '</a></li>' . "\n";
}



function _wip_product_gallery_panel(){
	global $post, $woocommerce;
?>
<div class="panel" id="tab-gallery">

	<h2><?php print __('Product Gallery', 'wip'); ?></h2>
	
	<?php

		$thumb_id = get_post_thumbnail_id();
		$small_thumbnail_size = apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail');
		$args = array(
			'post_type' 	=> 'attachment',
			'numberposts' 	=> -1,
			'post_status' 	=> null,
			'post_parent' 	=> $post->ID,
			'post__not_in'	=> array($thumb_id),
			'post_mime_type'=> 'image',
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC'
		);
		$attachments = get_posts($args);

		if( $attachments ){
		
		echo '<div class="product-gallery-thumbnail">' . "\n";
		echo '<ul>' . "\n";
			$columns = 6;
			$loop = 0;
			foreach ( $attachments as $attachment ) :
				
				if (get_post_meta($attachment->ID, '_woocommerce_exclude_image', true)==1) continue;
				
				$loop++;

				$_post = & get_post( $attachment->ID );
				$url = wp_get_attachment_url($_post->ID);
				$path = get_attached_file($_post->ID);
				$post_title = esc_attr($_post->post_title);
				
				if( file_exists($path) ){
					$image = wip_resize($path, $url, 140, 140, true);

					echo '<li class="normal ';
					if ($loop==1 || ($loop-1)%$columns==0) echo ' first';
					if ($loop%$columns==0) echo ' last';
					echo '">';
					echo '<a href="'.$url.'" title="'.$post_title.'" rel="thumbnails" class="zoom">';
					echo '<img src="'.$image['url'].'" alt="'.$post_title.'"/></a></li>';
				}

			endforeach;

		echo '</ul>' . "\n";
		echo '<div class="clear"></div>' . "\n";
		echo '</div>' . "\n";
			//woocommerce_show_product_thumbnails();
		} else {

			print '<p class="no_gallery"><em>' . __('No Galleries', 'wip') . '</em></p>';
		}
	?>

</div>
<?php
}




/** checkout page additional hack! */
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 4 );
add_action( 'woocommerce_before_checkout_form', '_wip_checkout_tab_process', 5 );



function _wip_checkout_tab_process(){
	echo '<div id="woo_checkout_tab_process">' . "\n";
	echo '<ul id="checkout_tab_process">' . "\n";

	if( get_option('woocommerce_enable_signup_and_login_from_checkout')=="yes" ){
		if( is_user_logged_in() ) {
			?>
			<li class="tolog process_done"><span class="checkout_process_label"><?php print __('Log In', 'wip'); ?></span></li>
			<?php
		} else {
			?>
			<li class="tolog process_active"><a href="#checkout_login" data="process-0"><span class="checkout_process_label"><?php print __('Log In', 'wip'); ?></a></span></li>
			<?php
		}
	}

	echo '<li class="process_active"><a href="#customer_details" data="process-1"><span class="checkout_process_label">' . __('Billing Address', 'wip') . '</a></span></li>' . "\n";
	echo '<li class="process_active"><a href="#shiptobilling" data="process-2"><span class="checkout_process_label">'. __('Shipping Address', 'wip') .'</a></span></li>' . "\n";
	echo '<li class="process_active"><a href="#payment" data="process-3"><span class="checkout_process_label">'. __('Payment Method', 'wip') .'</a></span></li>' . "\n";
	echo '<li class="process_active"><a href="#order_review" data="process-4"><span class="checkout_process_label">'. __('Order Review', 'wip') .'</a></span></li>' . "\n";

	echo '</ul>' . "\n";
	echo '</div>' . "\n";
	echo '<div id="woo_checkout_process_bar"><span class="process_bar"></span></div>' . "\n";
}











function _wip_pagenavi_for_woo(){
	wip_pagenavi('', true, '<div class="pagination_wrap">', '</div>');
}



function _wip_woo_related_products(){
	woocommerce_related_products( 3, 3 );
}


/**
 * Call product lists, use this on homepage manager and page content manager
 * @uses global $woocommerce_loop
 */
function _wip_show_product_lists_for_manager( $col = 4, $postNumber = 4, $catID = 0, $featured = false, $pagination = false){
	global $woocommerce_loop, $sidebar_layout, $fullwidth_layout;
	wp_reset_query();
	$content = "";
	$woocol = $col;
	$toocol = $col;
	if( $col == 34 ){
		$woocol = 3;
		$toocol = 4;
	}
	$woocommerce_loop['columns'] = $woocol;
	$paged = ( $pagination ) ? ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ) : false;
	$parentLayout = ( $fullwidth_layout ) ? 'fullwidth' : 'content-sidebar';
	
	$args = array(
		'post_type'	=> 'product',
		'post_status' => 'publish',
		'ignore_sticky_posts'	=> 1,
		'posts_per_page' => $postNumber,
		'paged' => $paged
	);

	$args['meta_query'] = array(
		  array(
			  'key' => '_visibility',
			  'value' => array('catalog', 'visible'),
			  'compare' => 'IN'
		  )
	  );

	if( !$featured && ( $catID && $catID != "" && $catID !== 0 ) ){
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'id',
				'terms' => intval($catID),
				'operator' => 'IN'
			)
		);
	}

	if( $featured ){
		$args['meta_key'] = '_featured';
		$args['meta_value'] = 'yes';
	}


	$colClass = 'col_four float_left';
	switch( $col ){
		case '5':
				$colClass = 'col_five float_left';
			break;
		case '4':
		case '34':
				$colClass = 'col_four float_left';
			break;
		case '3':
				$colClass = 'col_three float_left';
			break;
		case '2':
				$colClass = 'col_two float_left';
			break;
	}

	#sent new variable via $woocommerce_loop
	$woocommerce_loop['wip_cols'] = $toocol;
	$woocommerce_loop['parent_layout'] = $parentLayout;


	//$product_query = new WP_Query( $args );
	query_posts($args);
	ob_start();
	woocommerce_get_template_part( 'loop', 'shop' );
	$woo_loop = ob_get_clean();
	$woo_loop = str_replace('class="product ', 'class="'.$colClass.' ', $woo_loop);

	$content .= '<div class="product_wraper">' . "\n";
	$content .= '<div class="col_wraper no_margin">' . "\n";
	$content .= $woo_loop;
	$content .= ( $pagination ) ? wip_pagenavi( $args, false, '<div class="pagination_wrap">', '</div>') : '';
	$content .= '</div>' . "\n";
	$content .= '</div>' . "\n";


	wp_reset_query();
	return $content;

}



/**
 * dynamically call post thumbnail,
 * size was based on column number, and parent layout
 * so, no more resize the image via css, we do the right thing!
 */
function _wip_dynamically_call_product_thumbnail(){
	global $post, $product, $woocommerce_loop, $sidebar_layout, $fullwidth_layout;
	
	$col = ( isset($woocommerce_loop['wip_cols'])) ? $woocommerce_loop['wip_cols'] : $woocommerce_loop['columns'];
	$parentLayout = ( isset($woocommerce_loop['parent_layout']) && ( $woocommerce_loop['parent_layout'] != "" ) ) ? $woocommerce_loop['parent_layout'] : '';
	$parentLayout = (  $parentLayout == "" ) ? ( ( $fullwidth_layout ) ? 'fullwidth' : 'content-sidebar' ) : $parentLayout;

	$colImage = "";
	if( 'fullwidth' == $parentLayout ){
		switch( $col ){
			case '5':
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
								wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 162, 162 )
								:
								get_template_directory_uri() . '/images/no-preview.jpg';
				break;
			case '56':
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
								wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 120, 120 )
								:
								get_template_directory_uri() . '/images/no-preview.jpg';
				break;
			case '4':
			case '34':
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
								wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 210, 210 )
								:
								get_template_directory_uri() . '/images/no-preview.jpg';
				break;
			case '3':
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
								wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 290, 290 )
								:
								get_template_directory_uri() . '/images/no-preview.jpg';
				break;
			case '2':
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
								wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 450, 450 )
								:
								get_template_directory_uri() . '/images/no-preview.jpg';
				break;
		}
	} else {
		switch( $col ){
			case '5':
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
								wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 114, 114 )
								:
								get_template_directory_uri() . '/images/no-preview.jpg';
				break;
			case '4':
			case '34':
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
								wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 150, 150 )
								:
								get_template_directory_uri() . '/images/no-preview.jpg';
				break;
			case '3':
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
								wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 210, 210 )
								:
								get_template_directory_uri() . '/images/no-preview.jpg';
				break;
			case '2':
					$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
								wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 330, 330 )
								:
								get_template_directory_uri() . '/images/no-preview.jpg';
				break;
		}
	}

	$woo_product = &new woocommerce_product( $post->ID );

	echo '<div class="product_lists_thumbnail">' . "\n";
	echo '<a class="product_lists_thumbnail_wrap" href="'.get_permalink($post->ID).'" title="'.the_title_attribute('echo=0').'">' ."\n";
	echo '<img src="' . $colImage . '" alt="'.the_title_attribute('echo=0').'" />' . "\n";
	if ($product->is_on_sale()):
	echo apply_filters('woocommerce_sale_flash', '<span class="onsale" title="'.__('Sale!', 'wip').'">'.__('Sale!', 'wip').'</span>', $post, $product);
	endif;
	echo '</a>' . "\n";
	

	_wip_generate_product_title_on_lists();

	echo '<span class="product_list_price">';
	
	if ($price_html = $product->get_price_html()) :
	echo  strip_tags( $price_html, '<del><span>');
	endif;

	_wip_loop_addtocart_button();

	echo '</span>' . "\n";
	echo '</div>' . "\n";
}



function _wip_autodetect_parent_layout(){
	global $woocommerce_loop, $sidebar_layout, $fullwidth_layout;
	
	$col = ( isset($woocommerce_loop['wip_cols'])) ? $woocommerce_loop['wip_cols'] : $woocommerce_loop['columns'];
	$parentLayout = ( isset($woocommerce_loop['parent_layout']) ) ? $woocommerce_loop['parent_layout'] : '';
	$parentLayout = (  $parentLayout == "" ) ? ( ( $fullwidth_layout ) ? 'fullwidth' : 'content-sidebar' ) : $parentLayout;
	
	if( 'fullwidth' == $parentLayout ){
		
		echo '<div class="fullwidth-auto-column-'.$col.'">' . "\n";
	
	} else {
	
		echo '<div class="usesidebar-auto-column-'.$col.'">' . "\n";
	
	}
	
}




function _wip_generate_product_title_on_lists(){
	global $post, $product;

	echo '<h3 class="product-title-on-lists">' . "\n";
	echo '<a href="'.get_permalink($post->ID).'" title="'. the_title_attribute('echo=0') .'">'.get_the_title().'</a>' . "\n"; 
	echo '</h3>' . "\n";
}



/**
 * add to cart button on product lists
 */
function _wip_loop_addtocart_button(){
	ob_start();
	woocommerce_get_template('loop/add-to-cart.php');
	$woo_button = ob_get_clean();


	echo '<span class="product_list_button">'.$woo_button.'</span>' . "\n";

}





function _wip_cache_start_get_title_on_lists(){
	ob_start();
}


function _wip_cache_end_get_title_on_lists(){
	ob_get_clean();
}




/**
 * top shopping cart
 */
function _wip_top_cart(){
	global $woocommerce;
	$subTotal = $woocommerce->cart->get_cart_subtotal();
	$cartpage = get_permalink(woocommerce_get_page_id('cart'));
	
	ob_start();
    the_widget('WooCommerce_Widget_Cart', array(
    		'title' => __('Shopping Cart', 'wip')
    	), 
    	array(
			'widget_id'=>'wip-top-cart',
			'before_title' => '<h3 id="wip_topcart_title">',
			'after_title' => '</h3>',
			'before_widget' => '',
			'after_widget' => ''
    ));
    $woo_cart = ob_get_clean();

	$top_cart = '<div id="wip_woo_cart"'._wip_logo_on_right().'>' . "\n";
	$top_cart .= '<a class="wip_woo_inner_cart" href="' . $cartpage . '"><span class="top_cart_text">'. __('Shopping Cart', 'wip') .' &mdash; '. $subTotal .'</span></a>' . "\n";
	$top_cart .= '<div class="wip_woo_cart_drop">' . "\n";
	$top_cart .= str_replace(' &rarr;', '', $woo_cart);
	$top_cart .= '</div>' . "\n";
	$top_cart .= '</div>' . "\n";

	return $top_cart;

}


function _wip_latest_woo_product( $number, $catID, $featured ){
	
	$pr = "";
	
	ob_start();
	
	$query_args = array('posts_per_page' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'post_type' => 'product');
	$query_args['meta_query'] = array(
		  array(
			  'key' => '_visibility',
			  'value' => array('catalog', 'visible'),
			  'compare' => 'IN'
		  )
	  );

	if( !$featured && ( $catID && $catID != "" && $catID !== 0 ) ){
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'id',
				'terms' => intval($catID),
				'operator' => 'IN'
			)
		);
	}

	if( $featured ){
		$args['meta_key'] = '_featured';
		$args['meta_value'] = 'yes';
	}
	
	$r = new WP_Query($query_args);
	if ($r->have_posts()) :
	
	echo '<ul class="product_list_widget">' . "\n";
	while ($r->have_posts()) : $r->the_post(); global $post, $product;
	
		$img = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
					wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 70, 70 )
					:
					get_template_directory_uri() . '/images/no-preview.jpg';
?>
		<li><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
			<img src="<?php echo $img; ?>" alt="<?php the_title_attribute(); ?>"/>
			<?php if ( get_the_title() ) the_title(); else the_ID(); ?>
		</a> <?php echo $product->get_price_html(); ?></li>
<?php 
	endwhile;
	
	echo '</ul>' . "\n";
	
	endif;
	wp_reset_postdata();
	
	$woo_product = ob_get_clean();
	
	return $woo_product;
}



endif;
?>