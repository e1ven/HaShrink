<?php
/**
 * Template part for
 * display related portfolio in single-portfolio-item.php
 * @author webinpixels
 */
?>

<?php 
global $post, $wp_query; 
$postID = $post->ID;

if( !is_object($postID) )
	$postID = (int) $postID;

$post_terms = wp_get_post_terms( $postID, 'portfolio-category');

if( $post_terms ):
	$cats_array = array(0);
	foreach ($post_terms as $term) $cats_array[] = $term->term_id;

$args=array(
	'post_type' 		=> 'portfolio-item',
	'post_status'		=> 'publish',
	'showposts'			=> 4,
	'ignore_sticky_posts'=>1,
	'post__not_in'		=> array('', $postID),
	'orderby' 			=> 'rand',
	'paged'				=>false,
	'tax_query'			=> array(
				array(
					'taxonomy' 	=> 'portfolio-category',
					'field' 	=> 'id',
					'terms' 	=> $cats_array,
					'operator' => 'IN'
				)
		)
);
query_posts($args);

if(have_posts()):
?>
<div id="portfolio-related">
<h2><span><?php _e('Related Projects', 'wip'); ?></span></h2>
<div class="col_wraper no_margin">

<?php
$intloop = 0;							
while (have_posts()): the_post();
$intloop++;
global $post;

	$imgArray = ( has_post_thumbnail() && wip_get_attached_file($post->ID) ) ? 
				wip_print_autoresize( wip_get_attached_file($post->ID), get_thumbOri($post->ID, 'full'), 220, 168, true ) : '';
	
	$colImage = ( is_array( $imgArray ) ) ? 
				$imgArray['url']
				:
				get_template_directory_uri() . '/images/no-preview.jpg';
				
	$colImageGrayscale =( is_array( $imgArray ) && isset( $imgArray['path'] ) ) ? wip_print_grayscale_autoresize( $imgArray['path'], $imgArray['url'] ) : '';


	$specialStyle = "";
	if( ( $intloop == 1 ) || ( $intloop % 4 == 1 ) ){
		$specialStyle = " no_margin_left";
	}
	if( $intloop % 4 == 0 ){
		$specialStyle = " no_margin_right";
	}
?>

<div class="col_four float_left<?php echo $specialStyle; ?>">
	<div class="portfolio-thumbnail">
		<a href="<?php echo the_permalink(); ?>" title="<?php printf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ); ?>">
			<img class="portfolio-grayscale" src="<?php echo $colImageGrayscale; ?>" alt="<?php the_title_attribute(); ?>"/>
			<img class="portfolio-original" src="<?php echo $colImage; ?>" alt="<?php the_title_attribute(); ?>"/>
		</a>
	</div>

	<h3 class="portfolio-list-title">
		<a href="<?php the_permalink(); ?>" title="<?php printf( __('Permanent Link to %s', 'wip'), the_title_attribute('echo=0') ); ?>">
			<?php the_title(); ?>
		</a>
	</h3>
	
	<?php
	if ($post->post_excerpt){
		$content .= wpautop(wptexturize($post->post_excerpt));
	}
	?>
</div>

<?php
	if( $intloop % 4 == 0 ) echo '<div class="clear"></div>' . "\n";

	endwhile;

	if( $intloop % 4 != 0 ) echo '<div class="clear"></div>' . "\n";				
?>
</div>
</div>
<?php endif; //if related posts found ?>
<?php wp_reset_query(); ?>
<?php endif; //if portfolio have taxonomy ?>