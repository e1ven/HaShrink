<?php
get_header(); 

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>

	<div id="single-page-title">
		<div class="wrap_930">
		<h1><?php echo $term->name; ?></h1>
		</div>
	</div>
	
	

	<!-- MAIN SECTION -->
	<div id="main-inner-site">
		<?php do_action('wip_before_content'); ?>
		<?php wip_get_portfolio_category_HTML(); ?>
	</div>
	<!-- END MAIN SECTION -->

<?php get_footer(); ?>