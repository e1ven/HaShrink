<?php

#Always do this - only read on after theme setup! (this function quite slow to work)
function flushRules(){
	global $wp_rewrite;
   	$wp_rewrite->flush_rules();
}

	
/** ===================================================================================================================================== */
add_action('wp_print_scripts', 'wip_register_js');
function wip_register_js(){
	
	#Register the js file for front-end
	if( !is_admin() ){
		
		$woo_lightbox = false;
		if( woocommerce_found() ){
			$woo_lightbox = (get_option('woocommerce_enable_lightbox')=='yes') ? true : false;
		}
		
		
		wp_register_script('easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'),'1.3' );
		wp_register_script('mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.js', array('jquery'),'3.0.6' );
		wp_register_script('scrollPane', get_template_directory_uri() . '/js/jquery.jscrollpane.js', array('jquery', 'mousewheel'),'1.0' );;
		wp_register_script('flowjs', get_template_directory_uri() . '/modules/flowplayer/js/flowplayer-3.2.6.min.js', array('jquery'),'3.2.6' );
		wp_register_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'),'3.1.3' );
		wp_register_script('selectBox', get_template_directory_uri() . '/js/jquery.selectBox.js', array('jquery'));
		wp_register_script('nivoSlider', get_template_directory_uri() . '/js/jquery.nivo.slider.js', array('jquery'),'2.7.1' );
		wp_register_script('global', get_template_directory_uri() . '/js/global.js', array('jquery', 'prettyPhoto'),'1.0' );
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'swfobject' );
		wp_enqueue_script( 'easing' );
		wp_enqueue_script( 'mousewheel' );
		wp_enqueue_script( 'scrollPane' );
		wp_enqueue_script( 'flowjs' );
		wp_enqueue_script( 'prettyPhoto' );
		wp_enqueue_script( 'selectBox' );
		wp_enqueue_script( 'nivoSlider' );
		wp_enqueue_script( 'global' );	
		
		wp_localize_script( 'jquery', 'bdVar', 
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'homeurl' => home_url(),
				'flowurl' => get_template_directory_uri() . '/modules/flowplayer/flowplayer-3.2.7.swf',
				'pp_theme' => get_wip_option_by('bd_pp_style','pp_default'),
				'use_fancy' => ( $woo_lightbox ) ? 'true' : 'false'
			) 
		);
	}
	
}


add_action('wp_print_styles', 'wip_register_style');
function wip_register_style(){
	if( !is_admin() ){
		global $wp_styles, $theBuilder_db_version;
		
		wp_register_style( 'wip_style', get_template_directory_uri() . '/style.css', '', $theBuilder_db_version);
		wp_register_style( 'wip_base', get_template_directory_uri() . '/css/base.css', array('wip_style'), $theBuilder_db_version);
		wp_register_style( 'wip_custom', get_template_directory_uri() . '/css/custom.css', array('wip_style', 'wip_base'), $theBuilder_db_version);
		wp_register_style( 'nivo_slider', get_template_directory_uri() . '/css/nivo-slider.css', '', '2.7.1');
		wp_register_style( 'prettyPhoto', get_template_directory_uri() . '/images/prettyPhoto/prettyPhoto.css', '', '3.1.3');
		wp_register_style( 'ie7-style', get_template_directory_uri() . '/ie7.css', '', $theBuilder_db_version );
		wp_register_style( 'ie8-style', get_template_directory_uri() . '/ie8.css', '', $theBuilder_db_version );
		
		
		wp_enqueue_style( 'wip_style' );
		wp_enqueue_style( 'wip_base' );
		wp_enqueue_style( 'wip_custom' );
		wp_enqueue_style( 'nivo_slider' );
		wp_enqueue_style( 'prettyPhoto' );
		wp_enqueue_style( 'ie7-style' );
		wp_enqueue_style( 'ie8-style' );
		
		$wp_styles->add_data( 'ie7-style', 'conditional', 'IE 7' );
		$wp_styles->add_data( 'ie8-style', 'conditional', 'IE 8' );
	}
}

/** ===================================================================================================================================== */



/**
 * Create a new meta field for blog category,
 * so user can choose the layout for specific categories,
 * left sidebar or right sidebar or Fullwidth, and choose a custom sidebar
 */
 
#1. Create a custom table
function _wip_create_custom_taxonomy_table(){
	global $wpdb;
	
	$cat_table_name = $wpdb->prefix . "categorymeta";
	$portfoliocat_table_name = $wpdb->prefix . "portfoliocategorymeta";
	
	if($wpdb->get_var("show tables like '$cat_table_name'") != $cat_table_name) {
		
		$catsql = sprintf('CREATE TABLE IF NOT EXISTS `%scategorymeta` (
		  `meta_id` bigint(20) UNSIGNED NOT NULL auto_increment,
		  `category_id` bigint(20) UNSIGNED NOT NULL,
		  `meta_key` varchar(255),
		  `meta_value` longtext,
		  PRIMARY KEY (`meta_id`)
		)',$wpdb->prefix);

      $wpdb->query($catsql);
	  
	}
	
	
	if($wpdb->get_var("show tables like '$portfoliocat_table_name'") != $portfoliocat_table_name) {
		
		$pcatsql = 'CREATE TABLE IF NOT EXISTS ' . $portfoliocat_table_name . ' (
		  `meta_id` bigint(20) UNSIGNED NOT NULL auto_increment,
		  `portfoliocategory_id` bigint(20) UNSIGNED NOT NULL,
		  `meta_key` varchar(255),
		  `meta_value` longtext,
		  PRIMARY KEY (`meta_id`)
		)';
	

		$wpdb->query($pcatsql);
	}

}




/** tell WordPress about our new meta table */
add_action('init', 'register_customcategorymeta');
function register_customcategorymeta(){
	global $wpdb;
	$wpdb->categorymeta = $wpdb->prefix.'categorymeta';
	$wpdb->portfoliocategorymeta = $wpdb->prefix.'portfoliocategorymeta';
}






/** ===================================================================================================================================== */

/**
 * get option from theme option,
 * since almost the theme option value required in all php files
 * this function will make all easier :)
 *
 * @param $option = the option name
 * @param $default = default value
 *
 * @return string data
 */
function get_wip_option_by($option, $default){
	
	$data = get_option($option);
	$return = ($data != "") ? $data : $default;
	
	return stripslashes($return);
	
}


/** ===================================================================================================================================== */

/**
 * Check if custom menu has been build or not
 * @param $loc = location of the menu
 * @return bool
 */
function wip_have_custom_menu( $loc ){
	
	$locations = get_nav_menu_locations();
	$menu = "";
	
	if( isset( $locations[ $loc ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $loc ] );
	}
	
	if($menu)
		return true;
	else
		return false;
		
}


/** ===================================================================================================================================== */

/**
 * get the file url by $size of attachment/featured image
 * 
 * @param $id = post id,
 * @param $size = the attachment size, depend on how you set the image size
 *
 * @return = the file URL
 */
function get_thumbOri($id, $size='post-thumbnail'){
	$thumb = get_post_thumbnail_id($id);
	$thumbnail = get_template_directory_uri() . '/images/no-thumbnail.png';
	
	if( $thumb ){
		$thumb = wp_get_attachment_image_src($thumb, $size, false);
		
		if( isset($thumb[0]) ) $thumbnail = $thumb[0];
	
	}
	
	return $thumbnail;
}

function wip_get_feature_image_link($id){
	$thumb = get_post_thumbnail_id($id);
	return wp_get_attachment_url($thumb);
}


function wip_get_attached_file( $id ){
	$thumbid = get_post_thumbnail_id($id);
	
	if( !empty($thumbid) && $thumbid != "" ){
		
		if( file_exists( get_attached_file($thumbid) ) ){
			return get_attached_file($thumbid);
		}
	
	}
	
	return false;
}


function wip_print_autoresize( $path, $url, $width, $height, $return_array = false, $default = "" ){
	
	if( !file_exists( $path ) ){
		return $default;
	}
	
	if( $height < 9999 ){
		$imageURL = wip_resize( $path, $url, $width, $height, true );
	} else {
		$imageURL = wip_resize( $path, $url, $width, $height, false );
	}
	
	if( !$return_array ){
		if( isset( $imageURL['url'] ) && $imageURL['url'] != "" ){
			return $imageURL['url'];
		}
	} else {
		$iURL = ( isset( $imageURL['url'] ) && $imageURL['url'] != "" ) ? $imageURL['url'] : '';
		$iPath = ( isset( $imageURL['path'] ) && $imageURL['path'] != "" ) ? $imageURL['path'] : '';
		
		$ireturn = array(
			'url' => $iURL,
			'path' => $iPath
		);
		
		return $ireturn;
	}
	
	return $default;
}




/**
 * Create grayscale version of image
 * uses wp_load_image();
 *
 * @param $path -  path of original image
 * @param $url - url of original image
 *
 * @return grayscale image version url
 */
function wip_print_grayscale_autoresize( $path, $url ){
	
	if( file_exists($path) ){
	
		$file_info = pathinfo( $path );
		$extension = '.'. $file_info['extension'];
		$nameAndExt = $file_info['filename'] . '.' . $file_info['extension'];
		// the image path without the extension
		$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];
		$newnameAndExt = $file_info['filename'] . '-grayscale' . $extension;
		$grayscale_img_path = $no_ext_path.'-grayscale'.$extension;
		
		if( !file_exists( $grayscale_img_path ) ) {
			list($orig_w, $orig_h, $orig_type) = @getimagesize($path);
			$image = wp_load_image($path);
			imagefilter($image, IMG_FILTER_GRAYSCALE);

			switch ($orig_type) {
				case IMAGETYPE_GIF:
					imagegif( $image, $grayscale_img_path );
					break;
				case IMAGETYPE_PNG:
					imagepng( $image, $grayscale_img_path );
					break;
				case IMAGETYPE_JPEG:
					imagejpeg( $image, $grayscale_img_path );
					break;
			}
			imagedestroy($image);
		}
		
		$toReturn = str_replace( $nameAndExt, $newnameAndExt, $url);
		
		return $toReturn;
	}
	
	return false;
}


/**
 * Displaying featured image (if any)
 * if not, show the alert image
 *
 * @param $pid = post id,
 * @param $size = size of image, Check the aisya_setup() function at very first line to get idea
 * @param $alert = (bool) true/false - if set true then will returning boolean data
 */
function alert_no_thumbnail($pid, $size, $alert = false){
	$thumbnail = get_thumbOri($pid, $size);
	$has = true;
	
	if($thumbnail == ""){
		$thumbnail = get_template_directory_uri() . '/images/no-'.$size.'.jpg';
		$has = false;
	}
	
	if(!$alert) {
		return $thumbnail;
	} else {
		return (bool) $has;
	}
	
}

/** ===================================================================================================================================== */


/**
 * remove all space/change space with underscore
 */
function removeAllwhiteSpace($string){
	
	$sPattern = '/\s*/m';
	$sReplace = '';
	
	$string = str_replace(" ", "_", $string);
	$output = preg_replace( $sPattern, $sReplace, $string );
	
	return strtolower($output);
	
}


function WIPtakeOnlyInt($string, $concat = false) {
    $length = strlen($string);   
    for ($i = 0, $int = '', $concat_flag = true; $i < $length; $i++) {
        if (is_numeric($string[$i]) && $concat_flag) {
            $int .= $string[$i];
        } elseif(!$concat && $concat_flag && strlen($int) > 0) {
            $concat_flag = false;
        }       
    }
   
    return (int) $int;
}


/** ===================================================================================================================================== */

/**
 * Get content for the blog lists,
 * @param $beforemore bool
 * Return content if <!--more--> tag exist than pull the data before it's
 * if not return the excerpt.
 */
function wip_blog_printcontent($beforemore = true, $echo = true){
	global $post;
	
	$morestring = '<!--more-->';
	if( preg_match('/<!--more(.*?)?-->/', $post->post_content ) ) {
		if( $beforemore ){
			$explodemore = explode($morestring, $post->post_content);
			$content = apply_filters('the_content',$explodemore[0]);
		} else {
			$content = get_the_content();
		}
	} else {
		$ct = str_replace('[', '', get_the_excerpt());
		$ct = str_replace(']', '', $ct);
		
		$content = wpautop( strip_tags($ct) );
	}
	
	if(!$echo) return $content;
	
	echo $content;
}


/** ===================================================================================================================================== */

/**
 * Helper for our shortcodes!
 * change <!-- clear --> tags with '<div class"clear"></div>'
 * to cleared any floated content
 *
 * and change <!-- divider --> tags with '<div class="divider"></div>'
 * to show the divider lines
 */
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'changeclear', -10000);
function changeclear($content){
	
	$new_content = '';
	$reg = "/<!--clear(.*?)?-->/";
	$reg2 = "/<!--divider(.*?)?-->/";
	
	if (preg_match($reg, $content)) {
			$content = preg_replace( $reg, "<div class=\"clear\"></div>", $content);	
	}
	if (preg_match($reg2, $content)) {
			$content = preg_replace( $reg2, "<div class=\"dividers divider_style_1\"></div>", $content);	
	}
	
	$new_content = $content;
		
	$new_content = wptexturize(wpautop($new_content));
	
	return $new_content;
}

/** ===================================================================================================================================== */

/**
 * cut the string!
 */
function wip_limit_string( $string, $limit = 27, $more = "" )
{

	if ($more != ""){
		
		$moretext = $more;
	
	} else {
		
		$moretext = "";
	
	}
	
  #figure out the total length of the string
  if( strlen($string)>$limit )
  {
    # cut the text
    $string = substr( $string,0,$limit );
	$string = $string . $more;
	
  }
  
  # return the processed string
  return $string;
  
}


function limit_text( $text, $limit, $more = '...' )
{
  // figure out the total length of the string
  if( strlen($text)>$limit )
  {
    # cut the text
    $text = substr( $text,0,$limit );
    # lose any incomplete word at the end
    $text = substr( $text,0,-(strlen(strrchr($text,' '))) );
	$text = $text . $more;
  }
  // return the processed string
  return $text;
}

/** ===================================================================================================================================== */

/**
 * Comment and ping lists
 */
function pro_comments($comment, $args, $depth){
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_entries">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 60 ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<div class="comment_waiting"><?php _e( 'Your comment is awaiting moderation.', 'wip' ); ?></em></div>
		<?php endif; ?>

		<div class="comment-meta commentmetadata">
			<?php
				printf( ( '%s' ), sprintf( '<strong class="fn">%s</strong>', get_comment_author_link() ) );
				/* translators: 1: date, 2: time */
				printf( __( '&#8212; %1$s at %2$s', 'wip' ), get_comment_date(),  get_comment_time() ); 
			?>
			
			<?php edit_comment_link( __( '(Edit)', 'wip' ), ' ' );?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'wip' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'wip'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}

/** ===================================================================================================================================== */


/**
 * calculate brightness or darkness of color (usefull for auto gradient)
 * take from http://stackoverflow.com/questions/3511094/generate-gradient-color-from-php
 */
function colourBrightness($hex, $percent) {
 // Work out if hash given
 $hash = '';
 if (stristr($hex,'#')) {
  $hex = str_replace('#','',$hex);
  $hash = '#';
 }
 /// HEX TO RGB
 $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
 //// CALCULATE
 for ($i=0; $i<3; $i++) {
  // See if brighter or darker
  if ($percent > 0) {
   // Lighter
   $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
  } else {
   // Darker
   $positivePercent = $percent - ($percent*2);
   $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
  }
  // In case rounding up causes us to go to 256
  if ($rgb[$i] > 255) {
   $rgb[$i] = 255;
  }
 }
 //// RBG to Hex
 $hex = '';
 for($i=0; $i < 3; $i++) {
  // Convert the decimal digit to hex
  $hexDigit = dechex($rgb[$i]);
  // Add a leading zero if necessary
  if(strlen($hexDigit) == 1) {
  $hexDigit = "0" . $hexDigit;
  }
  // Append to the hex string
  $hex .= $hexDigit;
 }
 return $hash.$hex;
}



function wip_fromHex_to_rgb($color){

	 $rgb = array(hexdec(substr($color,0,2)), hexdec(substr($color,2,2)), hexdec(substr($color,4,2)));

	return implode($rgb, ',');

}

/** ===================================================================================================================================== */


/**
 * get page data (use this in theme option for select page option :)
 */
function retrieve_page_data($byid = false, $use_temp = true){
	$fit_pages_obj = get_pages('sort_column=post_parent,menu_order');
	if($byid){
		
		$fit_pages = array();
		
		foreach ($fit_pages_obj as $fit_page) {
			$fit_pages[$fit_page->ID] = $fit_page->ID;
		}
		
		if( $use_temp ){ $fit_pages_tmp = array_unshift($fit_pages, "0"); }
	
	} else {
		
		$fit_pages = array();
		
		if( ! $use_temp ){ $fit_pages[0] = __('Select a page:', 'wip'); }
		
		foreach ($fit_pages_obj as $fit_page) {
			$fit_pages[$fit_page->ID] = $fit_page->post_title;
		}
		
		if( $use_temp ){ $fit_pages_tmp = array_unshift($fit_pages, __('Select a page:', 'wip') ); }
	
	}
	
	return $fit_pages;
}


/** ===================================================================================================================================== */

/**
 * get category data
 */
function retrieve_cat_data($byid = false){
	$massive_categories_obj = get_categories('hide_empty=0');

	if($byid):
		$massive_categories = array();  
		foreach ($massive_categories_obj as $massive_cat) {
			$massive_categories[$massive_cat->cat_ID] = $massive_cat->cat_ID;
		}
		$categories_tmp = array_unshift($massive_categories, "0" ); 
	else:
		$massive_categories = array();  
		foreach ($massive_categories_obj as $massive_cat) {
			$massive_categories[$massive_cat->cat_ID] = $massive_cat->cat_name;
		}
		$categories_tmp = array_unshift($massive_categories, __('Select a category:', 'wip') );  	
	endif;
	
	return $massive_categories;
}

/** ===================================================================================================================================== */

/**
 * get the taxonomy lists, mostly used in theme option as select option values
 * @param $taxonomy = taxonomy name @default 'portfolio-category' most used taxonomy in my themes
 * @return object array
 */
function wip_get_tax_lists( $taxonomy = 'portfolio-category' ){
	$taxos_args = array(
		'taxonomy'     => $taxonomy,
		'orderby'      => 'name',
		'show_count'   => 0,
		'pad_counts'   => false,
		'hierarchical' => 0,
		'title_li'     => ''
	);
	#use get_categories and get all details via array
	$taxosObj = get_categories($taxos_args);

	$taxOb = array();
	foreach ($taxosObj as $taxoObj) {
		
		$taxOb[$taxoObj->term_id] = array(
			'name' => $taxoObj->name,
			'id' => $taxoObj->term_id
		);
	
	}


	return $taxOb;
}


/** ===================================================================================================================================== */

function get_custom_sidebar_array(){
	
	$sidebars = get_option('bd_sidebar_gen');
	
	$sidebarOption = array();
	
	if( !empty($sidebars) && is_array($sidebars) ){
		
		foreach( $sidebars as $sidebar):
		
			$sidebarOption[$sidebar] = $sidebar;
		
		endforeach;
		
		$sidebarOption_tmp = array_unshift( $sidebarOption, 'Default Sidebar');
	
	} else {
		
		$sidebarOption['Default Sidebar'] = 'Default Sidebar';
	
	}
	
	return $sidebarOption;

}


/** ===================================================================================================================================== */


function _wipfr_font_lists_array( $fontSource = 'google', $type = 'css-name' ){
	
	$custom = wip_get_google_font_lists();
	$standard = standardFont();
	
	
	$fontFamilyGoogle = array();
	$fontNameGoogle = array();
	$cssNameGoogle = array();
	foreach( $custom as $font ){
		$fontFamilyGoogle[] = $font['font-family'];
		$fontNameGoogle[] = $font['font-name'];
		$cssNameGoogle[] = $font['css-name'];
	}
	
	
	$fontFamilyStandard = array();
	$fontNameStandard = array();
	$cssNameStandard = array();
	foreach( $standard as $sfont ){
		$fontFamilyStandard[] = $sfont['font-family'];
		$fontNameStandard[] = $sfont['font-name'];
		$cssNameStandard[] = $sfont['css-name'];
	}
	
	$return = "";
	switch($fontSource){
		case 'google':
			switch( $type ){
				case 'font-family':
					
					$return = $fontFamilyGoogle;
					
					break;
				case 'font-name':
					
					$return = $fontNameGoogle;
					
					break;
				case 'css-name':
					
					$return = $cssNameGoogle;
					
					break;	
			}
		break;
		
		case 'standard':
			switch( $type ){
				case 'font-family':
					
					$return = $fontFamilyStandard;
					
					break;
				case 'font-name':
					
					$return = $fontNameStandard;
					
					break;
				case 'css-name':
					
					$return = $cssNameStandard;
					
					break;	
			}
		break;
	}
	
	return $return;
	
}



function get_font_embed_css( $font_name ){
	
	$standard_font_array = _standardFontnameArray();
	$custom = wip_get_google_font_lists();
	$embed = "";
	
	/** no need embed for standard font */
	if( in_array($font_name, $standard_font_array) ){
		return $embed;
	}
	
	foreach( $custom as $font ){
		if( $font['font-name'] == $font_name ){
			$embed = '@import url(http://fonts.googleapis.com/css?family='.$font['css-name'].');';
		}
	}
	
	return $embed;

}


function get_font_family_by_name( $font_name ){

	$standard_font_array = _standardFontnameArray();
	$standard = standardFont();
	$custom = wip_get_google_font_lists();
	$font_family = "";
	
	if( in_array($font_name, $standard_font_array) ){
		foreach( $standard as $sfont ){
			if( $sfont['font-name'] == $font_name ){
				$font_family = $sfont['font-family'];
			}
		}
	} else {
		foreach( $custom as $font ){
			if( $font['font-name'] == $font_name ){
				$font_family = $font['font-family'];
			}
		}
	}
	
	return $font_family;

}


/** ===================================================================================================================================== */


function wip_resize( $image_path, $img_url, $width, $height, $crop = false ) {

	$file_path = $image_path;
		
	$orig_size = getimagesize( $file_path );
	
	$image_src = array();
	$image_src[0] = $img_url;
	$image_src[1] = $orig_size[0];
	$image_src[2] = $orig_size[1];

	
	$file_info = pathinfo( $file_path );
	$extension = '.'. $file_info['extension'];

	// the image path without the extension
	$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

	$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

	if ( $image_src[1] > $width || $image_src[2] > $height ) {

		// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
		if ( file_exists( $cropped_img_path ) ) {

			$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
			
			$vt_image = array (
				'url' => $cropped_img_url,
				'path' => $cropped_img_path,
				'width' => $width,
				'height' => $height
			);
			
			return $vt_image;
		}

		// $crop = false
		if ( $crop == false ) {
		
			// calculate the size proportionaly
			$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
			$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;			

			// checking if the file already exists
			if ( file_exists( $resized_img_path ) ) {
			
				$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

				$vt_image = array (
					'url' => $resized_img_url,
					'path' => $resized_img_path,
					'width' => $proportional_size[0],
					'height' => $proportional_size[1]
				);
				
				return $vt_image;
			}
		}

		// no cache files - let's finally resize it
		$new_img_path = image_resize( $file_path, $width, $height, $crop );
		$new_img_size = getimagesize( $new_img_path );
		$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

		// resized output
		$vt_image = array (
			'url' => $new_img,
			'path' => $new_img_path,
			'width' => $new_img_size[0],
			'height' => $new_img_size[1]
		);
		
		return $vt_image;
		
	}
	
	// default output - without resizing
	$vt_image = array (
		'url' => $image_src[0],
		'path' => $file_path,
		'width' => $image_src[1],
		'height' => $image_src[2]
	);
	
	return $vt_image;

}



/** ===================================================================================================================================== */

/**
 * Clone of wp_handle_upload function
 * with this function, we allowed to define the upload_path and upload_url
 */
function wip_handle_upload( &$file, $overrides = false, $time = null, $upload_path = "", $upload_url = "" ) {
	// The default error handler.
	if ( ! function_exists( 'wip_handle_upload_error' ) ) {
		function wip_handle_upload_error( &$file, $message ) {
			return array( 'error'=>$message );
		}
	}

	$file = apply_filters( 'wp_handle_upload_prefilter', $file );

	// You may define your own function and pass the name in $overrides['upload_error_handler']
	$upload_error_handler = 'wip_handle_upload_error';

	// You may have had one or more 'wp_handle_upload_prefilter' functions error out the file.  Handle that gracefully.
	if ( isset( $file['error'] ) && !is_numeric( $file['error'] ) && $file['error'] )
		return $upload_error_handler( $file, $file['error'] );

	// You may define your own function and pass the name in $overrides['unique_filename_callback']
	$unique_filename_callback = null;

	// $_POST['action'] must be set and its value must equal $overrides['action'] or this:
	$action = 'wip_handle_upload';

	// Courtesy of php.net, the strings that describe the error indicated in $_FILES[{form field}]['error'].
	$upload_error_strings = array( false,
		__( "The uploaded file exceeds the upload_max_filesize directive in php.ini.", 'wip' ),
		__( "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.", 'wip' ),
		__( "The uploaded file was only partially uploaded.", 'wip' ),
		__( "No file was uploaded.", 'wip' ),
		'',
		__( "Missing a temporary folder.", 'wip' ),
		__( "Failed to write file to disk.", 'wip' ),
		__( "File upload stopped by extension.", 'wip' ));

	// All tests are on by default. Most can be turned off by $overrides[{test_name}] = false;
	$test_form = true;
	$test_size = true;
	$test_upload = true;

	// If you override this, you must provide $ext and $type!!!!
	$test_type = true;
	$mimes = false;

	// Install user overrides. Did we mention that this voids your warranty?
	if ( is_array( $overrides ) )
		extract( $overrides, EXTR_OVERWRITE );

	// A correct form post will pass this test.
	if ( $test_form && (!isset( $_POST['action'] ) || ($_POST['action'] != $action ) ) )
		return call_user_func($upload_error_handler, $file, __( 'Invalid form submission.', 'wip' ));

	// A successful upload will pass this test. It makes no sense to override this one.
	if ( $file['error'] > 0 )
		return call_user_func($upload_error_handler, $file, $upload_error_strings[$file['error']] );

	// A non-empty file will pass this test.
	if ( $test_size && !($file['size'] > 0 ) ) {
		if ( is_multisite() )
			$error_msg = __( 'File is empty. Please upload something more substantial.', 'wip' );
		else
			$error_msg = __( 'File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.', 'wip' );
		return call_user_func($upload_error_handler, $file, $error_msg);
	}

	// A properly uploaded file will pass this test. There should be no reason to override this one.
	if ( $test_upload && ! @ is_uploaded_file( $file['tmp_name'] ) )
		return call_user_func($upload_error_handler, $file, __( 'Specified file failed upload test.', 'wip' ));

	// A correct MIME type will pass this test. Override $mimes or use the upload_mimes filter.
	if ( $test_type ) {
		$wp_filetype = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'], $mimes );

		extract( $wp_filetype );

		// Check to see if wp_check_filetype_and_ext() determined the filename was incorrect
		if ( $proper_filename )
			$file['name'] = $proper_filename;

		if ( ( !$type || !$ext ) && !current_user_can( 'unfiltered_upload' ) )
			return call_user_func($upload_error_handler, $file, __( 'Sorry, this file type is not permitted for security reasons.', 'wip' ));

		if ( !$ext )
			$ext = ltrim(strrchr($file['name'], '.'), '.');

		if ( !$type )
			$type = $file['type'];
	} else {
		$type = '';
	}

	// A writable uploads dir will pass this test. Again, there's no point overriding this one.
	if ( ! ( ( $uploads = wip_check_upload_dir($upload_path) ) && false === $uploads['error'] ) )
		return call_user_func($upload_error_handler, $file, $uploads['error'] );

	$filename = wp_unique_filename( $upload_path, $file['name'], $unique_filename_callback );

	$tmp_file = wp_tempnam($filename, $upload_path);

	// Move the file to the uploads dir
	if ( false === @ move_uploaded_file( $file['tmp_name'], $tmp_file ) )
		return $upload_error_handler( $file, sprintf( __('The uploaded file could not be moved to %s.', 'wip' ), $upload_path ) );

	// Copy the temporary file into its destination
	$new_file = $upload_path . "/$filename";
	copy( $tmp_file, $new_file );
	unlink($tmp_file);

	// Set correct file permissions
	$stat = stat( dirname( $new_file ));
	$perms = $stat['mode'] & 0000666;
	@ chmod( $new_file, $perms );

	// Compute the URL
	$url = $upload_url . "/$filename";

	if ( is_multisite() )
		delete_transient( 'dirsize_cache' );
	
	$throwed = array(
		'file' => $new_file, 'url' => $url, 'type' => $type, 'filename' => $filename
	);
	
	return $throwed;
}


function wip_check_upload_dir($path){
	$handle = sprintf(__('Cannnot find the path: %s!', 'wip'), $path );
	$stat = stat( $path );
	$perms = $stat['mode'] & 0000755;
	
	if( is_dir($path) ):
	
		if( is_writable($path) ){
			
			$handle = false;
		
		} else {
			if( !(@ chmod( $path, $perms )) ){	
				$handle = sprintf(__('Wrong path: %s or this path is protected by your server!', 'wip'), $path );
			}
		}
		
	endif;
	
	$return['error'] = $handle;
	
	return $return;

}



/*
get only file name,remove the extension
*/
function get_icons_name($icons){
	$ext = getExtension($icons);
	$ico = str_replace("." . $ext , "", $icons);
	return $ico;
}



/*
get extension (file type) of image
*/
function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}

?>