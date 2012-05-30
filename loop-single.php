<?php
/**
 * Template part for single blog,
 * @author webinpixels
 * @package The_Builder
 */
global $post;

$position = get_post_meta( $post->ID, '_bd_post_layout', true);
$sidebarid = get_post_meta( $post->ID, '_bd_sidebar_use', true);
?>

<div class="wrap_960">
<div class="area_with_sidebar <?php if ( $position == 'sidebar-content') { echo 'area_right'; } else { echo 'area_left'; } ?>">

<?php
if( have_posts()):
while (have_posts()): the_post();
?>
	<div class="single-blog-entry">

	<h1 class="single-blog-title"><?php the_title(); ?></h1>
	<span class="meta-blog-lists"><?php print __('By', 'wip'); ?> <?php the_author_posts_link(); ?>
				&ndash;
				<?php printf( __('On %1$s', 'wip'), get_the_time('F d, Y', $post->ID) ); ?>
				&ndash;
				<?php print __('In', 'wip'); ?> <?php the_category(', '); ?>
				<?php print __('With', 'wip'); ?> <?php comments_popup_link( __('No comment', 'wip'), __('1 Comment', 'wip'), __('% Comments', 'wip') ); ?>
				</span>
	
	<?php
	#if user set the featured images for this post!
	if( has_post_thumbnail() && wip_get_attached_file($post->ID) ){
		echo '<div class="single-full-blog-thumbnail">' . "\n";
		echo '<img src="'. wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 700, 9999, false ) .'" alt="'. the_title_attribute('echo=0') .'"/>';
		echo '</div>' . "\n";
	}
	?>
	
	<div class="single-blog-entry-content">
	
	<?php the_content(); ?>

		<div class="clear"></div>
	</div>

	<?php 
		if( get_option('bd_blog_related_off') !== '0' ) get_template_part('blog', 'related'); 
	?>


	<?php comments_template( '', true ); ?>

	</div>

<?php
endwhile;
endif;
wp_reset_query();
?>

</div>

<div class="sidebar_block <?php if ($position == 'sidebar-content') { echo 'area_left'; } else { echo 'area_right'; } ?>">
<?php
wip_generated_dynamic_sidebar($sidebarid);
wp_reset_postdata();
?>
</div>
	
<div class="clear"></div>
</div><!-- end .wrap_960 -->