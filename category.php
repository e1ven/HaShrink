<?php get_header(); ?>

	<div id="single-page-title">
		<div class="wrap_930">
		<h1><?php single_cat_title( '', true); ?></h1>
		</div>
	</div>
	
	<!-- MAIN SECTION -->
	<div id="main-inner-site">
	<?php do_action('wip_before_content'); ?>
	<?php wip_get_category_HTML(); ?>
	</div>
	<!-- END MAIN SECTION -->

<?php get_footer(); ?>