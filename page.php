<?php get_header(); ?>
	
	<div id="single-page-title">
		<div class="wrap_940">
		<h1><?php single_post_title(); ?></h1>
		</div>
	</div>
	
	<!-- MAIN SECTION -->
	<div id="main-inner-site">
	<?php do_action('wip_before_content'); ?>
		
	<?php get_template_part('loop', 'page'); ?>
		
	</div>
	<!-- END MAIN SECTION -->
	
<?php get_footer(); ?>