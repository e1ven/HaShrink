<?php get_header(); ?>

	<!-- MAIN SECTION -->
	<div id="main-inner-site">
	
	<?php do_action('wip_before_content'); ?>
	
	<div class="wrap_940">
	
<?php
if( have_posts()):
while (have_posts()): the_post();
global $post;
?>

<div id="single-portfolio-entry">

	<h1 class="single-portfolio-title"><?php the_title(); ?></h1>

	<div class="single-portfolio-content col_four no_margin_left float_left">
		<?php the_content(); ?>
	</div>

	<div class="single-portfolio-object col_threefourth no_margin_right float_right">
		<?php _wip_print_portfolio_object(); ?>
	</div>

	<div class="clear"></div>

</div>

<?php 
	if( get_option('bd_portfolio_related_off') !== '0' ) get_template_part('portfolio', 'related');
?>


<?php
endwhile;
endif;
wp_reset_query();
?>

	</div><!-- end .wrap_930 -->
	</div>
	<!-- END MAIN SECTION -->

<?php get_footer(); ?>