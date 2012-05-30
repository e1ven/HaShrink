<?php get_header(); ?>

	<div id="single-page-title">
		<div class="wrap_930">
		<h1><?php printf( __('Search results for: %1$s', 'wip'), get_search_query() ); ?></h1>
		</div>
	</div>
	

	<!-- MAIN SECTION -->
	<div id="main-inner-site">
	<?php do_action('wip_before_content'); ?>
	
		<div class="wrap_960">
		
			<div class="area_with_sidebar area_left">
		
		<?php if( have_posts()): ?>	
			<?php while (have_posts()): the_post(); ?>

				<div class="standard-blog-lists">	
				<?php
					if( has_post_thumbnail() && wip_get_attached_file($post->ID) ){
				?>			
					<div class="standard-blog-thumbnail">
						<a href="<?php the_permalink(); ?>" title="<?php printf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ); ?>">
							<img src="<?php echo wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 690, 250 ); ?>" alt="<?php the_title_attribute(); ?>"/>
						</a>
					</div>			
				<?php } ?>
								
					<div class="standard-blog-excerpt">
						<h3 class="blog-list-title">
							<a href="<?php the_permalink(); ?>" title="<?php printf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ); ?>"><?php the_title(); ?></a>
						</h3>
						<span class="meta-blog-lists"><?php print __('By', 'wip'); ?> <?php the_author_posts_link(); ?>
									&ndash;
									<?php printf( __('On %1$s', 'wip'), get_the_time('F d, Y', $post->ID) ); ?>
									&ndash;
									<?php print __('In', 'wip'); ?> <?php the_category(', '); ?>
									<?php print __('With', 'wip'); ?> <?php comments_popup_link( __('No comment', 'wip'), __('1 Comment', 'wip'), __('% Comments', 'wip') ); ?>
									</span>
						
						<?php echo wpautop( str_replace('[...]', '...', get_the_excerpt()) ); ?>

						<a href="<?php the_permalink(); ?>" title="<?php printf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ); ?>"><?php print __('Continue Reading', 'wip'); ?> &rarr;</a>
					</div>
							
				</div>


			<?php endwhile; ?>

			<?php wip_pagenavi(); ?>

		<?php else: ?>

			<p class="search-fail"><?php _e('Sorry, but nothing matched with your search criteria. Please try again with some different keywords.', 'wip'); ?></p>

		<?php endif; wp_reset_query(); ?>		
			</div>


			<div class="sidebar_block area_right">
			<?php
				wip_generated_dynamic_sidebar('Default Sidebar');
				wp_reset_postdata();
			?>
			</div>

			<div class="clear"></div>

		</div><!-- end .wrap_960 -->
	</div>
	<!-- END MAIN SECTION -->


<?php get_footer(); ?>