<?php
/**
 * Parent file of the theme's functions file
 * @author webinpixels
 * @since version 1.0
 * @package WordPress
 * @subpackage The Builder WordPress Theme
 */
 

/*adding version, need this to upgrade later*/
$theBuilder_db_version = "1.0";/* current db versions */
global $theBuilder_db_version;

/**
 * DEFINE SOME FUNTIONS AND MODULES PATH
 */
define("BUILDER_FRAMEWORK", get_template_directory() . '/framework/');
define('BUILDER_FUNCTIONS', get_template_directory() . '/functions');
define('BUILDER_MODULES', get_template_directory() . '/modules');


/**
 * Detect if Woocommerce plugin is activated or not
 * will use this a lot, place it on parent file
 * reduce some conflict functions!
 * DO NOT DELETE THIS FUNCTION!!!!
 */
function woocommerce_found(){
	if ( !class_exists( 'Woocommerce' ) )
		return false;
	
	
	return true;
}


/**
 * doing some setup for our theme
 * run after theme setup process
 */
add_action( 'after_setup_theme', 'theBuilder_new_setup' );
if ( ! function_exists( 'theBuilder_new_setup' ) ):

function theBuilder_new_setup()
{
	global $theBuilder_db_version;
	
	if ( ! isset( $content_width ) ) $content_width = 940;
	
	#add custom css for editor (tinyMCE)
	add_editor_style();
	
	#add post-thumbnails and post-formats
	add_theme_support( 'post-thumbnails', array( 'post', 'portfolio-item', 'product' ) );
	
	#register default image sizes
	set_post_thumbnail_size( 80, 80, true );
	
	#Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	#use one menu location
	register_nav_menus( array(
		'main' => 'Main Navigation',
	) );
	
	# load the languange folder
	# use get_template_directory() instead TEMPLATEPATH - it will be deprecated in future version of WordPress
	load_theme_textdomain( 'wip', get_template_directory() . '/langs' );
	$locale = get_locale();
	$locale_file = get_template_directory() . "/langs/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	//add_filter( 'show_admin_bar', '__return_false' );
	add_filter( 'wp_loaded', 'flushRules' ); #refresh the rules, in some cases this is help some error on custom permalink struc
	update_option('theBuilder_db_version', $theBuilder_db_version);
	add_action('init', '_wip_create_custom_taxonomy_table', 5);
	add_action('wip_before_content', 'yoast_breadcrumb_cb', 20, 0);
}

endif;


require_once(BUILDER_MODULES . '/google_font/google_font.php');
require_once(BUILDER_MODULES . '/gradient/class.gradient_image.php');
require_once(BUILDER_FUNCTIONS . '/theme_setup.php');
require_once(BUILDER_FUNCTIONS . '/theme_functions.php');
require_once(BUILDER_FUNCTIONS . '/woocommerce_hack.php');
require_once(BUILDER_FUNCTIONS . '/custom_post.php');



if(is_admin()):
	require_once(BUILDER_FRAMEWORK . '/wip.framework.php');
endif;


require_once(BUILDER_FUNCTIONS . '/_wip.layout.helper.php');
require_once(BUILDER_FUNCTIONS . '/custom_menu_helper.php');
require_once(BUILDER_FUNCTIONS . '/widget.php');
require_once(BUILDER_FUNCTIONS . '/homepage_slider_helper.php');
require_once(BUILDER_FUNCTIONS . '/shortcode.helper.php');
require_once(BUILDER_FUNCTIONS . '/contact_ajax.php');


require_once(BUILDER_MODULES . '/wp-pagenavi/pagination.php');
require_once(BUILDER_MODULES . '/sidebar-generator/sidebar-generator.php');
require_once(BUILDER_MODULES . '/breadcrumbs/yoast-breadcrumbs.php');
?>