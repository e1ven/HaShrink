<?php get_header(); ?>
	
	<!-- MAIN SECTION -->
	<div id="main-inner-site">
	<?php do_action('wip_before_content'); ?>
	
	<?php get_template_part('loop', 'single'); ?>
		
	</div>
	<!-- END MAIN SECTION -->

<?php get_footer(); ?>