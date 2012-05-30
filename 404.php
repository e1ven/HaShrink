<?php get_header(); ?>

	<div id="single-page-title">
		<div class="wrap_930">
		<h1><?php _e('404 - Page couldn\'t be found', 'wip'); ?></h1>
		</div>
	</div>
	

	<!-- MAIN SECTION -->
	<div id="main-inner-site">
	<?php do_action('wip_before_content'); ?>
		<div class="wrap_930">
			<p class="search-fail"><?php _e('Sorry, the page you are looking for might have been removed, had its name changed, or is temporarily unavailable. Please try the following:', 'wip'); ?></p>
			<ul>
				<li><?php print __('Make sure that the Web site address displayed in the address bar of your browser is spelled and formatted correctly', 'wip'); ?></li>
				<li><?php print __('Go to our website\'s home page, and navigate to the content in question', 'wip'); ?></li>
				<li><?php print __('Please use the menus or the search box to find what you are looking for', 'wip'); ?></li>
			</ul>		

		</div>
	</div>
	<!-- END MAIN SECTION -->

<?php get_footer(); ?>