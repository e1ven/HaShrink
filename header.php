<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;
	
	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'wip' ), max( $paged, $page ) );

?></title>
	
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="shortcut icon" href="<?php echo wip_get_uploaded_image_url('bd_favicon', get_template_directory_uri() . '/favicon.ico'); ?>" type="<?php echo wip_get_uploaded_image_type('bd_favicon', 'image/x-icon'); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php
if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
wp_head();
if (trim(get_option('bd_hs')) <> "" ) { ?> 
<script type="text/javascript">
/* <![CDATA[ */
<?php echo stripslashes(get_option('bd_hs')); ?>
/* ]]> */
</script>
<?php } ?>

</head>

<body <?php body_class(); ?>>

<?php #add boxed_layout class if boxed layout choosen ?>
<div class="wrap_990<?php if( _wipfr_is_boxed_layout() ) echo ' boxed_layout'; ?>">

<div id="main-site">


	<!-- TOP SECTION -->
	<div id="top">
		
		<div class="wrap_940">
		
			<div id="top-inner"<?php _wip_top_inner_logo_class(); ?>>
				<a id="site-logo"<?php _wip_logo_floated_class(); ?> href="<?php echo home_url(); ?>/"><img src="<?php echo wip_get_uploaded_image_url('bd_logo', get_template_directory_uri() . '/images/default-logo.png'); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>

<?php 
if( woocommerce_found() && get_option('bd_top_shoppingcart_off') !== '0' ):
	echo _wip_top_cart(); #show top cart, only show when woocommerce active 
endif; 
?>

<?php if( top_bar_is_need_to_show() ): ?>
<div id="top-utilitize"<?php echo _wip_logo_on_right(); ?>>
	<?php wip_show_top_commerce_link(); #show additional links before search bar, only show when woocommerce active ?>

	<?php _wip_show_top_search_form(); ?>
</div>
<?php endif; ?>

		
				<div class="clear"></div>
			</div>

		</div><!-- .wrap_940 -->
		
	</div>
	<!-- END TOP -->
	
	
	<!-- NAVIGATION -->
	<div id="site-nav">
		
		<div class="wraper_990">
		
			<div id="main-navigation">
<?php if ( !wip_have_custom_menu('main') ): ?>
<ul id="main-nav">
	<li><a href="<?php echo get_admin_url(); ?>nav-menus.php"><?php print __('Build menu', 'wip'); ?></a></li>
	<li class="main-nav-last"><a class="main-nav-last-item" href="http://en.support.wordpress.com/menus/" target="_blank"><?php print __('Learn custom menu', 'wip'); ?></a></li>
</ul>
<?php 
else :
_wip_print_main_menu();
endif;
?>
				
			</div>
			
		</div><!-- .wrap_990 -->
		
	</div>
	<!-- END NAVIGATION -->