<?php
/**
 * @author WebInPixels
 * @since 2012
 * Parent file of admin framework
 */

require_once( get_template_directory() . '/framework/php/layout.manager.functions.php' );
require_once( get_template_directory() . '/framework/php/panel.functions.php' );
require_once( get_template_directory() . '/framework/php/metabox.function.php' );
require_once( get_template_directory() . '/framework/php/shortcode.class.php' );
require_once( get_template_directory() . '/framework/php/custom-category-fields.php' );
require_once( get_template_directory() . '/framework/php/custom-portfolio-category-fields.php' );






#call the home manager class
if( !class_exists('wip_home_manager') ) {

	require_once( get_template_directory() . '/framework/php/home.manager.class.php' );
	
}






#call the page manager class
if( !class_exists('wip_page_manager') ) {

	require_once( get_template_directory() . '/framework/php/page.manager.class.php' );
	
}





/**
 * Call the homemanager construct
 */
function call_construct_wip_home_manager(){

	$wip_home_manager = new wip_home_manager;
	
}






/**
 * Call the page content manager construct
 */
function call_construct_wip_page_manager(){

	$wip_page_manager = new wip_page_manager;
	
}






/** call WIPanel class */
function call_construct_WIPanel(){

	$WIPanel = new WIPanel;
	
}







/**
 * Build the layout for portfolio metabox
 */
function call_construct_portfolio_metabox(){

	$WIPmetabox = new WIP_metabox;
	$op = Portfolio_metabox_option();
	return $WIPmetabox->WIP_metabox_builder($op);
	
}







/**
 * Build the layout for blog metabox
 */
function call_construct_blog_metabox(){

	$WIPmetabox = new WIP_metabox;
	$op = Blog_metabox_option();
	return $WIPmetabox->WIP_metabox_builder($op);
	
}







/**
 * ajax process helper for home manager
 */
add_action('wp_ajax_wipProcessLayoutAjax', 'wipfr_ProcessLayoutAjax');
function wipfr_ProcessLayoutAjax(){

	return wip_home_manager::ajaxProcessLayout();
	
}








/**
 * ajax process helper for page content manager
 */
add_action('wp_ajax_wipProcessPageLayoutAjax', 'wipfr_ProcessPageLayoutAjax');
function wipfr_ProcessPageLayoutAjax(){

	return wip_page_manager::ajaxProcessLayout();
	
}









/**
 * register the new admin page and menu 
 */
function do_wip_admin_menu(){
	
	wip_home_manager::_process_layout_save();
	
	add_menu_page(__('Theme Options', 'wip'), __('Theme Options', 'wip'), 'manage_options', 'wip-panel' , 'call_construct_WIPanel');
	add_submenu_page('wip-panel', __('Theme Settings', 'wip'),  __('Theme Settings', 'wip') , 'manage_options', 'wip-panel', 'call_construct_WIPanel');
	add_submenu_page('wip-panel', __('Homepage Manager', 'wip'),  __('Homepage Manager', 'wip') , 'manage_options', 'wip-home-manager', 'call_construct_wip_home_manager');
	//add_submenu_page('wip-panel', __('Icons Manager', 'wip'),  __('Icons Manager', 'wip') , 'manage_wippanel', 'wip-icons', 'call_construct_auzora_menuicon');
	//add_submenu_page('wip-panel', __('Menu Manager', 'wip'),  __('Menu Manager', 'wip') , 'manage_wippanel', 'wip-menus', 'call_construct_auzora_menumanager');

}
add_action('admin_menu', 'do_wip_admin_menu', 3);









/** 
 * print css/stylesheet files for
 * admin sections 
 */
function WIPanel_print_styles()
{
	global $wp_version;
	
	wp_register_style( 'panel', get_template_directory_uri() . '/framework/stylesheet/panel.css', '', '1.0');
	wp_register_style( 'WIPanel', get_template_directory_uri() . '/framework/stylesheet/wip-panel.css', '', '1.0');
	wp_register_style( 'CP', get_template_directory_uri() . '/framework/stylesheet/color_picker/css/colorpicker.css', '', '1.0');
	
	wp_enqueue_style( 'panel' );
	wp_enqueue_style( 'WIPanel' );
	wp_enqueue_style( 'CP' );
	
}






/** 
 * print css/stylesheet files for
 * metabox sections 
 */
function WIPmetabox_print_styles(){
	wp_register_style( 'wip-metabox', get_template_directory_uri() . '/framework/stylesheet/metabox.css', '', '1.0');
	wp_register_style( 'CPM', get_template_directory_uri() . '/framework/stylesheet/color_picker/css/colorpicker.css', '', '1.0');
	
	wp_enqueue_style( 'wip-metabox' );
	wp_enqueue_style( 'CPM' );
}









/** 
 * print javascript files for
 * admin sections 
 */
function WIPanel_print_scripts()
{
	global $wp_version;
	
	wp_register_script( 'uploadify', get_template_directory_uri() . '/framework/js/uploadify/jquery.uploadify.v2.1.4.js', '', '2.1.4');
	wp_register_script( 'CPicker', get_template_directory_uri() . '/framework/js/colorpicker.js', '', '1.0');
	wp_register_script( 'eye', get_template_directory_uri() . '/framework/js/eye.js', '', '1.0');
	wp_register_script( 'ut', get_template_directory_uri() . '/framework/js/utils.js', '', '1.0');
	wp_register_script( 'WIPanel', get_template_directory_uri() . '/framework/js/WIPanel.js', '', $wp_version);
	wp_register_script( 'WIPmanager', get_template_directory_uri() . '/framework/js/core.manager.js', '', $wp_version);
	
	wp_enqueue_script( array("jquery", "jquery-ui-core", "interface", "jquery-ui-sortable", "wp-lists") );
	wp_enqueue_script( 'swfobject' );
	wp_enqueue_script( 'uploadify' );
	wp_enqueue_script( 'CPicker' );
	wp_enqueue_script( 'eye' );
	wp_enqueue_script( 'ut' );
	wp_enqueue_script( 'WIPanel' );
	wp_enqueue_script( 'WIPmanager' );
	
	wp_localize_script( 'jquery', 'wip', 
		array( 
			'up_uploader' => get_template_directory_uri() . '/framework/js/uploadify/uploadify.swf',
			'up_cancel' => get_template_directory_uri() . '/framework/js/uploadify/cancel.png',
			'up_maxsize' => _panel_return_bytes(ini_get('post_max_size')),
			'up_buttonimageupload' => get_template_directory_uri() . '/framework/images/button-upload-image.png'
		) 
	);

}






/** 
 * print javascript files for
 * metabox sections 
 */
function WIPmetabox_print_scripts()
{
	global $wp_version;

	wp_register_script( 'CPicker', get_template_directory_uri() . '/framework/js/colorpicker.js', '', '1.0');
	wp_register_script( 'eye', get_template_directory_uri() . '/framework/js/eye.js', '', '1.0');
	wp_register_script( 'ut', get_template_directory_uri() . '/framework/js/utils.js', '', '1.0');
	wp_register_script( 'WIPpagemanager', get_template_directory_uri() . '/framework/js/core.pagemanager.js', '', $wp_version);
	wp_register_script( 'ajaxuploadpost', get_template_directory_uri() . '/framework/js/uploadify/jquery.uploadify.v2.1.4.js', '', '2.1.4');
	wp_register_script( 'WIPmetaboxjs', get_template_directory_uri() . '/framework/js/metabox.js', '', '1.0');
	wp_register_script( 'flowpadmin', get_template_directory_uri() . '/modules/flowplayer/js/flowplayer-3.2.6.min.js', '', '1.0');
	
	wp_enqueue_script( array("jquery", "jquery-ui-core", "interface", "jquery-ui-sortable", "wp-lists") );
	wp_enqueue_script( 'swfobject' );
	wp_enqueue_script( 'CPicker' );
	wp_enqueue_script( 'eye' );
	wp_enqueue_script( 'ut' );
	wp_enqueue_script( 'WIPpagemanager' );
	wp_enqueue_script( 'ajaxuploadpost' );
	wp_enqueue_script( 'WIPmetaboxjs' );
	wp_enqueue_script( 'flowpadmin' );
	wp_localize_script( 'WIPmetaboxjs', 'bdVar', 
		array( 
			'flowurl' => get_template_directory_uri() . '/modules/flowplayer/flowplayer-3.2.7.swf',
			'up_uploader' => get_template_directory_uri() . '/framework/js/uploadify/uploadify.swf',
			'up_cancel' => get_template_directory_uri() . '/framework/js/uploadify/cancel.png',
			'up_maxsize' => _panel_return_bytes(ini_get('post_max_size')),
			'up_buttonimageupload' => get_template_directory_uri() . '/framework/images/button-upload-image.png'
		) 
	);

}





/**
 * Save the metabox : portfolio and blog custom post data
 */
function wip_save_post_metabox( $postID, $post ){
	global $wpdb;
	
	if ( !$_POST ) return $postID;
	if ( is_int( wp_is_post_revision( $postID ) ) ) return;
	if ( is_int( wp_is_post_autosave( $postID ) ) ) return;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if ( !current_user_can( 'edit_post', $postID )) return $postID;
	
	
	if( ('portfolio-item' == $_POST['post_type']) && ( isset($_POST['update']) || isset($_POST['save']) || isset($_POST['publish']) ) ){
		
		$op = Portfolio_metabox_option();
		
		foreach($op as $meta_page) {			
			
			if( isset($meta_page['id']) && ( $meta_page['id'] == "_wip_bd_portfolio") ){
		
				$Portfoliodata = isset( $_POST['_wip_bd_portfolio'] ) ? $_POST['_wip_bd_portfolio'] : '';
				$PpreviousValue = get_post_meta( $postID, '_wip_bd_portfolio', true);
				
				if( $PpreviousValue != "" && ($PpreviousValue != $Portfoliodata) ){
					
					$portfolios = get_option('bd_portfolio_data');
							
					if( !empty( $portfolios ) ){
					
						if( array_key_exists( $PpreviousValue, $portfolios ) ){
							$thisPort = $portfolios[$PpreviousValue];
							
							if( isset( $thisPort['image'] ) && is_array($thisPort['image']) ){
								$uploadPath = wp_upload_dir();
								$imageDir = $uploadPath['basedir'] . $thisPort['image']['subdir'] . '/' . $thisPort['image']['image'];
								$imageUrl = $uploadPath['baseurl'] . $thisPort['image']['subdir'] . '/'. $thisPort['image']['image'];
								
								if( file_exists($imageDir) ){
									$thumbs = wip_resize( $imageDir, $imageUrl, 215, 99999, false );
									
									if( file_exists($thumbs['path']) ) unlink( $thumbs['path'] );
									
									unlink( $imageDir); 
								}
							}
						}
						
						unset( $portfolios[$PpreviousValue] );
						update_option( 'bd_portfolio_data' , $portfolios );		
					}
		
				}
				
			}
			
			
		
			if( isset($meta_page['id']) && ( $meta_page['id'] == "_wip_make_featured") ){
				$makeF = isset( $_POST['_wip_make_featured'] ) ? $_POST['_wip_make_featured'] : '0';
				$makeF = (bool) $makeF;
				
				$sticky = get_option('wip_featured_portfolio');
				$countS = count($sticky);
				
				if( is_array($sticky) && in_array( $postID, $sticky ) ){
					foreach ($sticky as $k => $v){
						if ($sticky[$k] == $post_id){
							unset($sticky[$k]);
						}
					}
					$newstick = array_values($sticky);
					
					if( $countS == "1" ) {
						delete_option('wip_featured_portfolio');
					} else {
						update_option('wip_featured_portfolio', $newstick);
					}
				}
				
				if( $makeF ){
					if( is_array($sticky) ){
						$ns[] = $postID;
						$ss = array_merge( (array) $sticky, (array) $ns );
					} else {
						$ss[] = $postID;
					}
					
					update_option('wip_featured_portfolio', $ss);
				}
			
			}

			
				
			$data = "";
			if( isset($_POST[$meta_page['id']]) ) $data = $_POST[$meta_page['id']];
		
			if(get_post_meta($postID, $meta_page['id']) == "")
			add_post_meta($postID, $meta_page['id'], $data, true);
			
			elseif($data != get_post_meta($postID, $meta_page['id'], true))
			update_post_meta($postID, $meta_page['id'], $data);
			
			elseif($data == "")
			delete_post_meta($postID, $meta_page['id'], get_post_meta($postID, $meta_page['id'], true));
			
			

		} /** endforeach */
	
	} /** endif portfolio-item = post_type */
	else if( ('post' == $_POST['post_type']) && ( isset($_POST['update']) || isset($_POST['save']) || isset($_POST['publish']) ) ){
	
		$bop = Blog_metabox_option();
		foreach($bop as $meta_blog) {
		
			$data = "";
			if( isset($_POST[$meta_blog['id']]) ) $data = $_POST[$meta_blog['id']];
		
			if(get_post_meta($postID, $meta_blog['id']) == "")
			add_post_meta($postID, $meta_blog['id'], $data, true);
			
			elseif($data != get_post_meta($postID, $meta_blog['id'], true))
			update_post_meta($postID, $meta_blog['id'], $data);
			
			elseif($data == "")
			delete_post_meta($postID, $meta_blog['id'], get_post_meta($postID, $meta_blog['id'], true));
		
		}
	}
	
	
	
}




/** call metabox the actions */
add_action('add_meta_boxes', 'builder_create_metabox');
add_action('save_post', array('wip_page_manager','_process_layout_save'), 1, 2);
add_action('save_post', 'wip_save_post_metabox', 1, 2);




/**
 * add_meta_box
 */
function builder_create_metabox() 
{
	if ( function_exists('add_meta_box') ) 
	{
		add_meta_box( 'new-meta-page', __('Page Content Manager', 'wip'), 'call_construct_wip_page_manager', 'page', 'normal', 'high' );
		add_meta_box( 'new-meta-portfolio', __('Portfolio Options', 'wip'), 'call_construct_portfolio_metabox', 'portfolio-item', 'normal', 'high' );
		add_meta_box( 'new-meta-blog', __('Options', 'wip'), 'call_construct_blog_metabox', 'post', 'normal', 'high' );
	}
	
}






/** Convert value into bytes */
function _panel_return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}





/**
 * call the action to print the style and scripts 
 * to minimalize the conflict to any plugins,
 * we only call these scripts and stylesheet in specific admin pages
 */
if(is_admin() && isset($_GET['page']) && ( $_GET['page']  == 'wip-panel' || $_GET['page']  == 'wip-home-manager' || $_GET['page']  == 'wip-template-manager' ) ){
	add_action('admin_print_scripts', 'WIPanel_print_scripts');
	add_action('admin_print_styles', 'WIPanel_print_styles');
}






if( ( is_admin() && isset($_GET['post']) && $_GET['post'] != '' ) ||  ( is_admin() && isset($_GET['post_type']) && $_GET['post_type'] != '' ) || basename($_SERVER['PHP_SELF']) == "post-new.php" ){
	add_action('admin_print_scripts', 'WIPmetabox_print_scripts');
	add_action('admin_print_styles', 'WIPmetabox_print_styles');
}