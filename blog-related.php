<?php
/**
 * Template part for
 * display related blog in single.php
 * @author webinpixels
 */
?>

<?php 
global $post, $wp_query; 
$postID = $post->ID;

if( !is_object($postID) )
	$postID = (int) $postID;

$post_terms = get_the_category($post->ID);

if( $post_terms ):

	$category_ids = array();
	foreach($post_terms as $individual_category) 
		$category_ids[] = $individual_category->term_id;

$args=array(
	'category__in' 		=> $category_ids,
	'post_status'		=> 'publish',
	'showposts'			=> 4,
	'ignore_sticky_posts'=>1,
	'post__not_in'		=> array('', $postID),
	'orderby' => 'rand',
	'paged'				=>false,
);
query_posts($args);

if(have_posts()):
?>

<div id="blog-related">
	<h2><span><?php _e('Related Posts', 'wip'); ?></span></h2>
<div class="col_wraper no_margin">
<?php
$intloop = 0;							
while (have_posts()): the_post();
$intloop++;
global $post;

	$colImage = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
				wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 160, 104 )
				:
				get_template_directory_uri() . '/images/no-preview.jpg';


	$specialStyle = "";
	if( ( $intloop == 1 ) || ( $intloop % 4 == 1 ) ){
		$specialStyle = " no_margin_left";
	}
	if( $intloop % 4 == 0 ){
		$specialStyle = " no_margin_right";
	}
?>
<div class="column-blog-lists col_four float_left<?php echo $specialStyle; ?>">

	<div class="column-blog-thumbnail">
	<a href="<?php the_permalink(); ?>" title="<?php printf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ); ?>">
		<img src="<?php echo $colImage; ?>" alt="<?php the_title_attribute(); ?>"/>
	</a>
	</div>

	<h3 class="blog-list-title">
		<a href="<?php the_permalink(); ?>" title="<?php printf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ); ?>">
			<?php echo limit_text(get_the_title(), 24 ); ?>
		</a>
	</h3>

	<span class="meta-blog-lists">
		<?php print __('By', 'wip'); ?> <?php the_author_posts_link(); ?> &ndash; <?php printf( __('On %1$s', 'wip'), get_the_time('F d, Y', $post->ID) ); ?>
	</span>

</div>

<?php
	if( $intloop % 4 == 0 ) echo '<div class="clear"></div>' . "\n";

	endwhile;

	if( $intloop % 4 != 0 ) echo '<div class="clear"></div>' . "\n";				
?>
</div>
</div><!-- blog-related -->

<?php endif; //if related posts found ?>
<?php wp_reset_query(); ?>
<?php endif; //if post have category ?>