<?php

/**
 * Print homepage layout
 * required class wip_layout_helper,
 *
 * @return homepage content
 */
function wip_get_index_HTML(){
	
	wip_layout_helper::_print_frontpage_layout();
	
}




/**
 * Print blog category dynamically,
 * based on option in add/edit category page
 */
function wip_get_category_HTML(){
	wip_layout_helper::_print_category_layout();
}




/**
 * Print portfolio category dynamically,
 * based on option in add/edit category page
 */
function wip_get_portfolio_category_HTML(){
	wip_layout_helper::_print_portfolio_category_layout();
}



/**
 * return the fullwidth layout module
 * @param $content = generate from _wip.layout.helper.php
 * return HTML layout
 */
function _wipfr_print_fullwidth_module($content){
	global $sidebar_layout, $fullwidth_layout;
	
	echo '<div class="wrap_960">' . "\n";
	echo $content;
	echo '</div><!-- end .wrap_960 -->' . "\n";

}






/**
 * Check the layout style,
 * if none or user do not pick up a style yet, back to default = box
 *
 * @return bool
 */
function _wipfr_is_boxed_layout(){
	
	$layout = ( get_wip_option_by('bd_skinlayout', 'box') == 'box' ) ? true : false;
	
	return $layout;
}






/**
 * return the content + sidebar layout module
 * @param $position = either 'content_sidebar' or 'sidebar_content'
 * @param $pid = the layout ID - uses for take sidebar info
 * @param $content = generate from _wip.layout.helper.php
 *
 * return HTML layout
 */
function _print_contentsidebar_module( $position = 'content_sidebar', $pid, $content, $forpage = false ){
	global $sidebar_layout, $fullwidth_layout;
	
	if( $forpage ){
		global $post;
		$sidebarid = get_option('wip_sidebarid_'.$pid.'_'.$post->ID);
	} else {
		$sidebarid = get_option('wip_sidebarid_'.$pid);
	}
	
	echo '<div class="wrap_960">' . "\n";	
		echo '<div class="area_with_sidebar '.( ($position == 'content_sidebar') ? 'area_left' : 'area_right' ).'">' . "\n";
			echo $content;
		echo '</div>' . "\n";
		
		echo '<div class="sidebar_block '.( ($position == 'content_sidebar') ? 'area_right' : 'area_left' ).'">' . "\n";
		wip_generated_dynamic_sidebar($sidebarid);
		wp_reset_postdata();
		echo '</div>' . "\n";
		
		echo '<div class="clear"></div>' . "\n";
	echo '</div><!-- end .wrap_960 -->' . "\n";
	
}





/**
 * return the content + sidebar layout module
 * @param $position = either 'content_sidebar' or 'sidebar_content'
 * @param $content = generate from _wip.layout.helper.php
 * @param $sidebarid = choosen sidebar
 *
 * return HTML layout
 */
function _print_category_contentsidebar_module( $position = 'content_sidebar', $content, $sidebarid ){
	global $sidebar_layout, $fullwidth_layout;
	
	echo '<div class="wrap_960">' . "\n";	
		echo '<div class="area_with_sidebar '.( ($position == 'content_sidebar') ? 'area_left' : 'area_right' ).'">' . "\n";
			echo $content;
		echo '</div>' . "\n";
		
		echo '<div class="sidebar_block '.( ($position == 'content_sidebar') ? 'area_right' : 'area_left' ).'">' . "\n";
		wip_generated_dynamic_sidebar($sidebarid);
		wp_reset_postdata();
		echo '</div>' . "\n";
		
		echo '<div class="clear"></div>' . "\n";
	echo '</div><!-- end .wrap_960 -->' . "\n";
	
}








/**
 * Check the parent layout type
 * @param $pid = parent layout ID that need to check
 *
 * @return false if error, type layout if success
 */
function _wipfr_check_parentlayout_type($pid, $parentName = 'wipfr_parent_home_layout'){
	
	$parentStruct = get_option($parentName);
	if( ! empty( $parentStruct ) && is_array( $parentStruct ) ){
		foreach( $parentStruct as $id => $key ){
			if( $id == $pid ){
				if( isset($key['type']) ){
					return $key['type'];
				}
			}
		}
	}
	
	return false;
	
}






/**
 * Check if homepage slider active or not
 * @return bool
 */
function _wipfr_homeslider_inactive(){
	$homeStruc = get_option( 'wipfr_parent_home_layout');
	
	if( !empty($homeStruc) && is_array($homeStruc) ){
		foreach( $homeStruc as $pid => $key ){
			if( $pid == '0' ){
				
				if( isset($key['type']) && $key['type'] == '1' ) return true;
			
			}
		}
	}
	
	return false;
}





/**
 * Detect if top bar is needed to show or not (based on user setting)
 * @return bool
 */
function top_bar_is_need_to_show(){

	$show = true;
	
	if( ( get_option('bd_top_search_off') === '0' ) && ( get_option('bd_top_links_beforesearch_off') === '0' ) ){
		$show = false;
	}
	
	if( !woocommerce_found() && ( get_option('bd_top_search_off') === '0' ) ){
		$show = false;
	}
	
	
	return $show;
}






/**
 * Show the top search form
 */
function _wip_show_top_search_form(){

	if( get_option('bd_top_search_off') === '1' ):
?>
<div id="search-form-top">
	<form method="get" id="wip-search-form" action="<?php echo home_url(); ?>/">
		<input id="wip-searchbox" type="text" value="<?php print __('Search site', 'wip'); ?>"  name="s" placeholder="<?php print __('Search site', 'wip'); ?>" />
	</form>
</div><!-- #search-form-top -->
<?php
	endif;
}







/**
 * Show latest blog listing
 * @param $count = number of posts
 * @param $thumbnail = show thumbnail or not, default true
 * @param $excerpt = show excerpt or not, default true
 * @param $excerptlength = length of excerpt text
 *
 * @return lists
 */
function wipfr_latest_blog( $count = 5, $thumbnail = true, $excerpt = true, $excerptlength = 55){

	$return = '<ul class="news_widget_style">' . "\n";
	$args=array(
		'post_type' 		=> 'post',
		'post_status'		=> 'publish',
		'showposts'			=> $count,
		'ignore_sticky_posts'=> 1,
		'paged'				=> false,
	);
	query_posts($args);
	$i = 0;						
	while (have_posts()): the_post();
	$i++;
	global $post;
	
		$img = get_thumbOri($post->ID);
		if( !has_post_thumbnail($post->ID)) $img = get_template_directory_uri() . "/images/no-post-thumbnail.jpg";

			$return .= '<li'.( (!$thumbnail) ? '' : ' class="news_widget_style_with_thumbnail"').'>';
				$return .= '<h3><a href="' . get_permalink($post->ID) . '" title="'. sprintf(__('permanent link to %s', 'wip'), the_title_attribute('echo=0')) .'">' . get_the_title($post->ID) . '</a></h3>' . "\n";
				
				if($thumbnail) $return .= '<img class="news_widget_style_thumbnail" src="' . $img . '" alt="'.the_title_attribute('echo=0').'" />' . "\n";
				
				if($excerpt) $return .= wpautop( limit_text( get_the_excerpt(), $excerptlength, '...' ) ) . "\n";

			$return .= '</li>' . "\n";

	endwhile;
	wp_reset_query();
	$return .= '</ul>' . "\n";
	
	return $return;

}








/**
 * Show most commented blog listing
 * @param $count = number of posts
 * @param $thumbnail = show thumbnail or not, default true
 * @param $excerpt = show excerpt or not, default true
 * @param $excerptlength = length of excerpt text
 *
 * @return lists
 */
function wipfr_most_commented_blog( $count = 5, $thumbnail = true, $excerpt = true, $excerptlength = 55){
	global $wpdb;
	
	$return = "";
    $result = "SELECT * FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY comment_count DESC LIMIT 0 , $count";
	$popularposts = $wpdb->get_results($result, OBJECT);
	
	if($popularposts){
	
		$return = '<ul class="news_widget_style">' . "\n";
		
		global $post;
		foreach ($popularposts as $post):
		setup_postdata($post);
		
		
			$img = get_thumbOri($post->ID);
			if( !has_post_thumbnail($post->ID)) $img = get_template_directory_uri() . "/images/no-post-thumbnail.jpg";

				$return .= '<li'.( (!$thumbnail) ? '' : ' class="news_widget_style_with_thumbnail"').'>';
					$return .= '<h3><a href="' . get_permalink($post->ID) . '" title="'. sprintf(__('permanent link to %s', 'wip'), the_title_attribute('echo=0')) .'">' . get_the_title($post->ID) . '</a></h3>' . "\n";
					
					if($thumbnail) $return .= '<img class="news_widget_style_thumbnail" src="' . $img . '" alt="'.the_title_attribute('echo=0').'" />' . "\n";
					
					if($excerpt) $return .= wpautop( limit_text( get_the_excerpt(), $excerptlength, '...' ) ) . "\n";

				$return .= '</li>' . "\n";

		endforeach;
		wp_reset_query();
		$return .= '</ul>' . "\n";
	
	} else {
	
		$return = __('No Posts that match your criteria!', 'wip');
	
	}
	
	return $return;

}








/**
 * Show latest portfolio thumbnail!
 */
function wipfr_latest_portfolio_thumbnail( $count, $catID = 0 ){
	
	$return = '<ul class="latest_portfolio_thumbnail">' . "\n";
	$args=array(
		'post_type'	=> 'portfolio-item',
		'post_status' => 'publish',
		'ignore_sticky_posts'=> 1,
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
		
		while ($pQuery->have_posts()): $pQuery->the_post();
		global $post;
		
			$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 85, 85, true ) : '';
			
			$colImage = ( is_array( $imgArray ) ) ? 
						$imgArray['url']
						:
						get_template_directory_uri() . '/images/default-portfolio-85x85.jpg';
						
			$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';
			
			
			$return .= '<li class="portfolio_widget_item">' . "\n";
					$return .= '<a class="portfolio_widget_thumbnail" href="'.get_permalink($post->ID).'" title="'.the_title_attribute('echo=0').'">' . "\n";
						$return .= '<img class="portfolio_widget_thumbnail_gray" src="'.$colImageGrayscale.'" alt="'.the_title_attribute('echo=0').'" />';
						$return .= '<img class="portfolio_widget_thumbnail_default" src="'.$colImage.'" alt="'.the_title_attribute('echo=0').'" />';
					$return .= '</a>' . "\n";
			$return .= '</li>' . "\n";
			
		endwhile;
		
	else:
		
		
	endif;
	wp_reset_postdata();
	
	$return .= '</ul>' . "\n";
	$return .= '<div class="clear"></div>' . "\n";
	
	return $return;
	
}








/**
 * Show twitter updates
 * @param $username = twitter username
 * @param $number = how much data should display
 *
 * return lists
 */
function _wip_display_tweets( $username, $number ){
	
	if( file_exists( ABSPATH . WPINC . '/class-simplepie.php') ) {
		require_once(ABSPATH . WPINC . '/class-simplepie.php');
	} else {
		return __('You are not using latest WordPress version! Please update your WordPress!', 'wip');
		break;
	}
	
	$upload = wp_upload_dir();
	$cachefile = $upload['basedir'];
	$cached_time = 300;
	
	$tweet_url = 'http://search.twitter.com/search.atom?q=from:'.$username;
	//if( is_ssl() ) $tweet_url = preg_replace('|^http://|', 'https://', $tweet_url);
	$feed = new SimplePie( $tweet_url, $cachefile, $cached_time );
	
	$result = "";
	
	if( $feed && !is_wp_error($feed) ) {
		$result = '
			<ul class="builder_latest_tweet">' . "\n";
			
		foreach ($feed->get_items(0, $number) as $item){
			
			$time = strtotime( $item->get_date('Y-m-d H:i:s') );
			if ((abs(time() - $time)) < 86400) :
				$time = human_time_diff($time) . ' ago';
			else :
				$time = relativeTime( $item->get_date('Y-m-d H:i:s') );
			endif;
			
			$t_link = $item->get_permalink();
			if( is_ssl() ) $t_link = preg_replace('|^http://|', 'https://', $t_link);
			
			$_desc = $item->get_description();
			if( is_ssl() ) $_desc = preg_replace('/http[s]*:/', 'https:', $_desc);
			
			$result .= '<li>' . "\n";
				$result .= '<span class="twitter-text">' . $_desc . '</span>';		
				// Display date/time
				$result .= '<span class="twitter-date"><a href="'.$t_link.'" target="_blank">' . $time . '</a></span>';
			$result .= '</li>' . "\n";
		}
		
		$result .= '</ul>' . "\n";
	}
	else {
		$result = __('Twitter seems too busy, cannot connect to twitter right now! Please try again later!', 'wip');
	}
	
	return $result;
	
}








/**
 * Change the date format into ...time ago
 *
 * @return new date format (string)
 */
function relativeTime($date)
	{
    if(empty($date)) {
        return __('No date provided', 'wip');
    }
   
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
   
    $now             = time();
    $unix_date       = strtotime($date);
   
       // check validity of date
    if(empty($unix_date)) {   
        return __('Bad date', 'wip');
    }

    // is it future date or past date
    if($now > $unix_date) {   
        $difference     = $now - $unix_date;
        $tense         = "ago";
       
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
   
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
   
    $difference = round($difference);
   
    if($difference != 1) {
        $periods[$j].= "s";
    }
   
    return "$difference $periods[$j] {$tense}";
}








/**
 * Show the Flickr image lists
 * @param $id = flickr ID
 * @param $count = number of photos
 *
 * @return HTML of photo lists
 */
function wip_display_flickr( $id, $count = 9 ){

	if( file_exists( ABSPATH . WPINC . '/class-simplepie.php') ) {
		require_once(ABSPATH . WPINC . '/class-simplepie.php');
	} else {
		return __('You are not using latest WordPress version! Please update your WordPress!', 'wip');
		break;
	}

	$upload = wp_upload_dir();
	
	$cachefile = $upload['basedir'];
	$flickr_rss_url = 'http://flickr.com/services/feeds/photos_public.gne?id='.$id.'&format=rss_200';
	
	$feed = new SimplePie( $flickr_rss_url, $cachefile );
	
	$out = '';
	if( $feed && !is_wp_error($feed) ) {
		
		$feed->handle_content_type();
		
		$out = '<ul class="flickr-image">' . "\n";
		
		$photos = $feed->get_items(0, $count);
		
		foreach ( $photos as $item) {
			if ($enclosure = $item->get_enclosure()){
			
				$url = preg_match_all('/<img src="([^"]*)"([^>]*)>/i', $item->get_description(), $m);
				$url = $m[1][0];
				
				$url = explode('/', $url);
				$photo = array_pop($url);
				
				$f_link = $item->get_permalink();
				if( is_ssl() ) $f_link = preg_replace('|^http://|', 'https://', $f_link);
				
				$r = preg_replace('/(_(s|t|m|b))?\./i', '_s.', $photo);
				$url[] = $r;
				$thumb = implode('/', $url);
				$out .= "<li><a href='{$f_link}' target='_blank' title='{$enclosure->get_title()}'><img alt='{$enclosure->get_title()}' src='{$thumb}'/></a></li>" . "\n";
			}
		}
		
		$out .= '</ul>' . "\n";
		$out .= '<div class="clear"></div>' . "\n";

	} else {
	
		$out = '<em>' . __('Cannot connect to Flickr or seems no internet connection detected!', 'wip') . '</em>';
	
	}
	
	return $out;

}








/**
 * get the image url from uploaded image via theme option
 * @param $optionID = option name
 * @param $default = default value
 *
 * uses wp_upload_dir(); // incase user move their site into new host/domain and keep the old database and all image file under wp-content/uploads
 * @return image url
 */
function wip_get_uploaded_image_url( $optionID, $default = "" ){
	
	$option = get_option( $optionID );
	
	if( ($option != "") && is_array($option) ){
		$uploadPath = wp_upload_dir();

		$imageUrl = $uploadPath['baseurl'] . $option['subdir'] . '/'. $option['image'];
		
		return $imageUrl;
	}
	
	return $default;
}







/**
 * get image type from uploaded image in theme option
 */
function wip_get_uploaded_image_type( $optionID, $default = "" ){
	
	$option = get_option( $optionID );
	
	if( ($option != "") && is_array($option) ){
		$imageType = isset($option['type']) ? $option['type'] : $default;
		
		return $imageType;
	}
	
	return $default;
}







/*
Get Copyright text
*/
function get_wip_copyright()
{
	$cp = stripslashes( get_option('bd_ct') );

	$copyright = ( $cp != "") ? $cp : 'Copyright &copy; ' . date("Y") . ' . ' . get_bloginfo('name') . ' . All Rights Reserved';
	echo wptexturize($copyright);
}







/**
 * Dinamycally get the top value for search form area,
 * to do : get the height value of logo - height of search container / 2
 * 
 * @return string top value in pixels
 * note: not used now, maybe we need this function on next version
 */
function get_topvalue_form_value(){

	$logoHeight = get_wip_option_by('height_of_bd_logo', 80);

	$topValue = ( $logoHeight - 30 )/2;

	echo $topValue+30 . 'px';
}






/**
 * Show the top link,
 * right before the search form,
 * only show if woocommerce active
 */
function wip_show_top_commerce_link(){

	$link = "";
	if( woocommerce_found() && get_option('bd_top_links_beforesearch_off') !== '0' ){

		$link = '<ul class="top_commerce_link">' . "\n";

			$link .= '<li><a href="'.get_permalink(woocommerce_get_page_id('myaccount')).'">'. ( is_user_logged_in() ? get_the_title(woocommerce_get_page_id('myaccount')) : __('Log In', 'wip') ) .'</a></li>' . "\n";
			$link .= '<li><a href="'.get_permalink(woocommerce_get_page_id('cart')).'">'. get_the_title(woocommerce_get_page_id('cart')) .'</a></li>' . "\n";
			$link .= '<li><a href="'.get_permalink(woocommerce_get_page_id('checkout')).'">'. get_the_title(woocommerce_get_page_id('checkout')) .'</a></li>' . "\n";
			if( is_user_logged_in() ) $link .= '<li><a href="'.wp_logout_url( home_url().'/' ).'">'. __('Sign Out', 'wip') .'</a></li>' . "\n";

		$link .= '</ul>' . "\n";

	}

	echo $link;

}






/**
 * get number of item in shopping cart
 * note: not used now, maybe we need this function on next version
 */
function _wip_get_currentCart_number(){
	if( woocommerce_found() ){
		global $woocommerce;
		return sizeof($woocommerce->cart->get_cart());
	}

	return false;
}






/**
 * generated logo container and image class
 * based on position of the logo | left | center | right
 */
function _wip_top_inner_logo_class(){
	$class = '';
	if( get_option('bd_logo_position') == 'center' ) {
		$class = ' class="logo-center"';
	}

	echo $class;
}



function _wip_logo_on_right(){
	$class = "";
	if( get_option('bd_logo_position') == 'right' ) $class = ' class="logo_on_right"';

	return $class;
}



function _wip_logo_floated_class(){
	$class = ' class="on_left"';
	if( get_option('bd_logo_position') == 'right' ) $class = ' class="on_right"';
	if( get_option('bd_logo_position') == 'center' ) $class = ' class="on_center"';
	
	echo $class;
}





/**
 * Print portfolio object
 * use in single portfolio page
 */
function _wip_print_portfolio_object(){
	global $post;
	
	$isThere = false;
	$imageUrl = "";
	$video = "";
	$type = "";
	$preview = "";
	$vidType = "";
	
	$postID = $post->ID;
	if( !is_object($postID) )
		$postID = (int) $postID;
	
	$portfolioObjectID = get_post_meta( $postID, '_wip_bd_portfolio', true);
	
	$portfolioData = get_option('bd_portfolio_data');
	
	
	
		if( !empty($portfolioData) ){
			
			if( array_key_exists( $portfolioObjectID, $portfolioData ) ){
			
				$port = $portfolioData[$portfolioObjectID];
				
					if( $port['type'] == 'image' ){
						
						if( isset($port['image']) && is_array($port['image']) ){
							$isThere = true;
							$type = 'image';
							
							$uploadPath = wp_upload_dir();
							$imageDir = $uploadPath['basedir'] . $port['image']['subdir'] . '/' . $port['image']['image'];
							$imageUrl = $uploadPath['baseurl'] . $port['image']['subdir'] . '/'. $port['image']['image'];	
							
							$preview = wip_print_autoresize( $imageDir, $imageUrl, 700, 9999, false );
							
						}
					
					} elseif( $port['type'] == 'video' ) {
						
						if( $port['video'] != "" ){
							$isThere = true;
							$type = 'video';
							
							$video = $port['video'];
							$vidType = typeOflink( $video );
						}
					}
			}
		}


		if( !$isThere ){
			print '<p>' . __('Please set your portfolio object, by uploading an image or enter a video URL in custom metabox under the text editor!', 'wip') . '</p>';
		}
		
		
		if( $type !== "" ){
		
			if( $type == 'image' ){
		
				echo '<a href="'.$imageUrl.'" rel="prettyPhoto" title="'.the_title_attribute('echo=0').'"><img src="'.$preview.'" alt="'.the_title_attribute('echo=0').'" /></a>' . "\n";
			
			}
			else if( $type == 'video' ){
			
				echo WIPobjectPrint($video, $vidType, '700', '525', 'false' );
			
			}
		
		
		}
		
		return false;
}







/**
 * This is function to display objects (video)
 * 
 * @param $url --> the url of data (vimeo, flash, youtube, .mov)
 * @param $type = type of data (it can be youtube, vimeo, etc)
 * @param $width = width of object
 * @param $height = height of object
 * @return data string
 */
function WIPobjectPrint($url, $type, $width, $height, $autoplay, $widget = false){
	$return = "";
	
	$floUR = 'bdVar.flowurl';
	
	$flash 	= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="{width}" height="{height}">
		<param name="wmode" value="transparent" />
		<param name="allowfullscreen" value="true" />
		<param name="allowscriptaccess" value="always" />
		<param name="movie" value="{path}" />
		<embed src="{path}" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="{width}" height="{height}" wmode="transparent">
		</embed>
		</object>';
	
	$vimeo	= '<iframe src="http://player.vimeo.com/video/{path}?title=0&amp;byline=0&amp;portrait=0&amp;autoplay={autoplay}&amp;color='.get_wip_option_by('bd_general_link_color', '28a3d1').'" width="{width}" height="{height}" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	
	$flow_p = '<div style="width:{width}px;height:{height}px;" id="{id}"></div>' . "\n" .
				'<script language="javascript">' . "\n" . '
				/* <![CDATA[ */' . "\n" . '
				$f("{id}", '.$floUR.', {
					clip:{
						url : "{path}",
						autoPlay: {autos},
						autoBuffering: true,
						wmode : "transparent"
					}
				});' . "\n" . '
				/* ]]> */' . "\n" . '
				</script>' . "\n";
	
	$quicktime 	= '<object classid="clsid:02bf25d5-8c17-4b23-bc80-d3488abddc6b" codebase="http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0" height="{height}" width="{width}">
		<param name="src" value="{path}"/>
		<param name="autoplay" value="{autoplay}"/>
		<param name="scale" value="tofit"/>
		<param name="type" value="video/quicktime"/>
		<embed src="{path}" scale="tofit" height="{height}" width="{width}" autoplay="{autoplay}" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/">
		</embed>
		</object>';

	switch ( $type ) {
		case "youtube":
			
			if($autoplay == "true") $autoplay = "1";
			if($autoplay == "false") $autoplay = "0";
		
			$parsed_url = parse_url($url);
			$mov = "";
			if( isset( $parsed_url['query'] ) ){
				
				parse_str($parsed_url['query'], $parsed_query);
				
				if( isset( $parsed_query['v'] ) ) $mov = $parsed_query['v'];
			
			}
			
			$movie = 'http://www.youtube.com/v/' . $mov . '?version=3&amp;feature=player_detailpage&amp;color=white&amp;autoplay={autoplay}';
			$movie = str_replace('{autoplay}', $autoplay, $movie);
			
			$return = str_replace('{path}', $movie, $flash);
			$return = str_replace('{width}', $width, $return);
			$return = str_replace('{height}', $height, $return);
		break;
		case "vimeo":
			$mov = str_replace('/www.', '/', $url);
			$mov = str_replace('http://vimeo.com/', '', $mov);
			$movie = $mov;
			
			$return = str_replace('{path}', $movie, $vimeo);
			$return = str_replace('{width}', $width, $return);
			$return = str_replace('{height}', $height, $return);
			$return = str_replace('{autoplay}', $autoplay, $return);
		break;
		case "quicktime":
			$movie = $url;
			
			$return = str_replace('{path}', $movie, $quicktime);
			$return = str_replace('{width}', $width, $return);
			$return = str_replace('{height}', $height, $return);
			$return = str_replace('{autoplay}', $autoplay, $return);
		break;
		case "flash":
			$movie = $url;
			
			$return = str_replace('{path}', $movie, $flash);
			$return = str_replace('{width}', $width, $return);
			$return = str_replace('{height}', $height, $return);
		break;
		case "flowplayer":
			$movie = $url;
			
			$return = str_replace('{path}', $movie, $flow_p);
			$return = str_replace('{autos}', $autoplay, $return);
			$return = str_replace('{id}', takeid($movie, $widget), $return);
			$return = str_replace('{width}', $width, $return);
			$return = str_replace('{height}', $height, $return);
			
		break;
		case "image":
			$return = '<img src="'.$url.'" alt="" />';
		break;
	}
	
	return $return;
}






/**
 * generate unique ID for flowplayer
 */
function takeid($url, $widget = false){
	if( $widget ){
		return "widget-flow" . md5($url);
	}
	
	return "flow" . md5($url);
}








/**
 * Detect the type of link (uses on portfolio/blog posts)
 * @param $link --> the URL that need to be check
 *
 * @return type of link (string)
 */
function typeOflink($link) {
   
	if( preg_match('#^http:\/\/(.*)\.(jpg|jpeg|png|gif)$#i', $link) )
    {
	
        $type = 'image';
		
    } else if( stringExist( strtolower($link) , array('.mov','.3gp')) ) {
	
		$type = 'quicktime';
		
	} else if( stringExist( strtolower($link) , array('.mp4','.flv')) ) {
	
		$type = 'flowplayer';
		
	} else if( stringExist( strtolower($link) , array('.swf','')) ){
	
		$type = 'flash';
		
    } else {
	
        if( getDomainName($link) == "youtube.com" ){
			$type = 'youtube';
		} else if( getDomainName($link) == "vimeo.com" ){
			$type = 'vimeo';
		} else if( getDomainName($link) == "megavideo.com" ){
			$type = 'megavideo';
		}
		
    }
	
    return $type;
}








/**
 * Get the domain name from URL,
 * @param $link = URL
 *
 * @return the domain name (e.g. youtube.com)
 */
function getDomainName($link){
	preg_match('@^(?:http://)?([^/]+)@i', $link, $matches);
	$host = $matches[1];

	// get last two segments of host name
	preg_match('/[^.]+\.[^.]+$/', $host, $matches);
	return strtolower($matches[0]);
}








/**
 * Check if string exist on given words
 * @param $string = string that need to look up
 * @param $words = original string
 *
 * return bool
 */
function stringExist(&$string, $words) {
    foreach($words as &$word) {
        if(stripos($string, $word) !== false) {
            return true;
        }
    }
    return false;
}




add_filter('pre_get_posts', '_wip_tryTochange_postsPerPage');
function _wip_tryTochange_postsPerPage($query) {
	$http_get = ('GET' == $_SERVER['REQUEST_METHOD']);
	
	
	if( get_query_var('post_type') != 'product' && !$query->is_tax( 'product_cat' ) && !$query->is_tax( 'product_tag' ) ){
	
		if( $query->is_main_query() ){
		
			if ( $query->is_category || $query->is_tag || $query->is_date || $query->is_year || $query->is_month || $query->is_day || $query->is_time || $query->is_archive ){
				
				$query->query_vars['posts_per_page'] =  intval( get_wip_option_by('bd_blocat_postperpage', 5) );
			
			}
			
			if( $query->is_tax ){
				
				$query->query_vars['posts_per_page'] = intval( get_wip_option_by('bd_portfoliocat_postperpage', 12) );
			
			}
			
			if( $query->is_search ){
			
				$query->query_vars['posts_per_page'] = intval( get_wip_option_by('bd_search_postperpage', 6) );
			
			}
		
			return $query;
			
		}
	}
}






/** show social links and icon lists */
function _wip_show_social_link(){
	$data = get_option('bd_fan_icons');
	$path_info = wp_upload_dir();
	
	if( !is_array($data) ) return false;
	
	$links = '<ul class="builder_social_icons">' . "\n";
	foreach( $data as $d ){
		$iconImg = $d['icon'];
		$ic =  $path_info['baseurl'] . $iconImg['subdir'] . '/' . $iconImg['file'];
		
		$links .= '<li>' . "\n";
		$links .= '<a href="'.$d['link'].'" title="'.$d['text'].'" target="_blank"><img src="'.$ic.'" alt="'.$d['text'].'" /></a>' . "\n";
		$links .= '</li>' . "\n";
	}
	$links .= '</ul>' ."\n";
	
	return $links;
}