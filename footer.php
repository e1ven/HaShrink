<!-- FOOTER SECTION -->
<div id="footer">

<?php 
if( get_option('bd_footer_widget_off') !== '0' ){
	$GLOBALS['footer_area'] = true;
?>		
	<div id="footer-widget">
		<div class="wrap_960">
		
		<div class="col_wraper">
		
<div class="col_four float_left">		
<?php
	wp_reset_postdata();
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 1') ) : 
?>
	<div class="footer-widget widget_meta">
		<h3 class="footer-widget-title">Meta</h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</div>
<?php endif; wp_reset_query(); ?>
</div>
			
<div class="col_four float_left">		
<?php
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 2') ) : 
?>
	<div class="footer-widget widget_meta">
		<h3 class="footer-widget-title">Meta</h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</div>
<?php endif; wp_reset_query(); ?>
</div>
			
<div class="col_four float_left">			
<?php
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 3') ) : 
?>
	<div class="footer-widget widget_meta">
		<h3 class="footer-widget-title">Meta</h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</div>
<?php endif; wp_reset_query(); ?>
</div>
			
<div class="col_four float_right">			
<?php
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 4') ) : 
?>
	<div class="footer-widget widget_meta">
		<h3 class="footer-widget-title">Meta</h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</div>
<?php endif;  wp_reset_query(); ?>		
</div>
		
			<div class="clear"></div>
		</div>
		
		</div><!-- .wrap_960 -->
	</div><!-- #footer-widget -->
<?php 
$GLOBALS['footer_area'] = false;
} 
?>

		
	<div id="site_bottom">
		<div class="wrap_960">
		<div class="col_wraper">
		
			<div class="col_two float_left">
				<div class="copyright">
					<?php get_wip_copyright(); ?>
				</div>
			</div>
			
			<div class="col_two float_right">
				<?php echo _wip_show_social_link(); ?>
			</div>
			
			<div class="clear"></div>
		</div>
		</div><!-- .wrap_960 -->
	</div><!-- #site_bottom -->
	
</div>
<!-- END FOOTER SECTION -->
	
	
	
</div><!-- #main-site -->
</div><!-- .wrap_990 -->

<?php if (trim(get_option('bd_fs')) <> "" ) { ?> 
<script type="text/javascript">
/* <![CDATA[ */
<?php echo stripslashes(get_option('bd_fs')); ?>
/* ]]> */
</script>
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>