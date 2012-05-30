<?php get_header(); ?>

<?php if( !_wipfr_homeslider_inactive() ): ?>
	<!-- SLIDER -->
	<div id="slider_wraper">
		<div class="wrap_940">
		<?php wip_get_nivo_images(); ?>	
		</div><!-- .wrap_940 -->
	</div>
	<!-- END SLIDER -->
<?php endif; ?>	
	
	<!-- MAIN SECTION -->
	<div id="main-inner-site"<?php if( _wipfr_homeslider_inactive() ) echo ' class="no-slider"'; ?>>
		
	<?php wip_get_index_HTML(); ?>
		
	</div>
	<!-- END MAIN SECTION -->
	
<?php get_footer(); ?>