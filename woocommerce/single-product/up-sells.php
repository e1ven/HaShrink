<?php
/**
 * Up-sells
 */

global $product, $woocommerce_loop;
$woocommerce_loop['parent_layout'] = 'fullwidth';
$woocommerce_loop['wip_cols'] = 56;

$upsells = $product->get_upsells();
if (sizeof($upsells)==0) return;
?>
<div class="upsells products">
	<h2><span><?php _e('You may also like&hellip;', 'wip') ?></span></h2>
	<?php
	$args = array(
		'post_type'	=> 'product',
		'ignore_sticky_posts'	=> 1,
		'posts_per_page' => 3,
		'orderby' => 'rand',
		'post__in' => $upsells
	);
	query_posts($args);
	woocommerce_get_template_part( 'loop', 'shop' );
	wp_reset_query();
	?>
</div>