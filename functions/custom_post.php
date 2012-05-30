<?php
add_action('init', 'builder_custom_post');
function builder_custom_post() 
{

  $labels = array(
    'name' => _x('Portfolio', 'post type general name', 'wip'),
    'singular_name' => _x('Portfolio', 'post type singular name', 'wip'),
    'add_new' => _x('Add New', 'portfolio', 'wip'),
    'add_new_item' => __('Add New portfolio', 'wip'),
    'edit_item' => __('Edit Portfolio', 'wip'),
    'edit' => _x('Edit', 'portfolio', 'wip'),
    'new_item' => __('New Portfolio', 'wip'),
    'view_item' => __('View Portfolio', 'wip'),
    'search_items' => __('Search Portfolios', 'wip'),
    'not_found' =>  __('No portfolios found', 'wip'),
    'not_found_in_trash' => __('No portfolios found in Trash', 'wip'), 
    'view' =>  __('View Portfolio', 'wip'),
    'parent_item_colon' => ''
  );
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
	'_edit_link' => 'post.php?post=%d',
	'capability_type' => 'post',
	'hierarchical' => false,
    'supports' => array('title','editor','thumbnail','excerpt')
  ); 
  
  register_post_type('portfolio-item',$args);
  
}

/** ===================================================================================================================================== */

//hook into the init action
add_action( 'init', 'create_builder_portoflio_taxonomies', 0 );
//create a taxonomie
function create_builder_portoflio_taxonomies() 
{
  // Add new taxonomy, make it hierarchical (works like post categories)
  $labels = array(
    'name' => _x( 'Portfolio Category', 'taxonomy general name', 'wip' ),
    'singular_name' => _x( 'Portfolio Category', 'taxonomy singular name', 'wip' ),
    'search_items' =>  __( 'Search Portfolio Categories', 'wip' ),
    'popular_items' => __( 'Popular Portfolio Categories', 'wip' ),
    'all_items' => __( 'All Portfolio Categories', 'wip' ),
    'parent_item' => __( 'Parent Portfolio Category', 'wip' ),
    'parent_item_colon' => __( 'Parent Portfolio Category:', 'wip' ),
    'edit_item' => __( 'Edit Portfolio Category', 'wip' ), 
    'update_item' => __( 'Update Portfolio Category', 'wip' ),
    'add_new_item' => __( 'Add New Portfolio Category', 'wip' ),
    'new_item_name' => __( 'New Portfolio Category Name', 'wip' ),
  ); 	

  register_taxonomy('portfolio-category',array('portfolio-item'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( "slug" => "portfolio-category" ),
  ));
}

/** ===================================================================================================================================== */

add_filter("manage_edit-portfolio-item_columns", "portfolioitem_edit_columns");
add_action("manage_posts_custom_column",  "portfolioitem_custom_columns");

function portfolioitem_edit_columns($columns){
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			"portfolio-categories" => "Categories",
		);

		return $columns;
}

function portfolioitem_custom_columns($column){
		global $post;
		switch ($column)
		{
				
			case "portfolio-categories":
				echo get_the_term_list($post->ID, 'portfolio-category', '', ', ','');
				break;
		}
}