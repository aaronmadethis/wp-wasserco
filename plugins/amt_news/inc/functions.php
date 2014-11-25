<?php

// -- register install script
register_activation_hook(__FILE__, 'amt_wdo_news_install');

// -- register the deactivation script
register_deactivation_hook(__FILE__, 'amt_wdo_news_deactivate');

// -- runs when plug-in is installed
function amt_wdo_news_install(){
}

// -- run on uninstall deletes options
function amt_wdo_news_deactivate() {
	// -- delete options
	// -- delete_option('total_columns');
}

// Load our custom assets.
add_action( 'admin_enqueue_scripts', 'amt_wdo_news_assets');

function amt_wdo_news_assets(){

}

// -- Set up the post types
add_action('init', 'amt_wdo_news_regiser_post_types');

// -- Register Post Types function
function amt_wdo_news_regiser_post_types(){

	// -- set arguments for the portfolio_page post type
	$amt_wdo_news_args = array(
		'public' => true,
		'query_var' => 'wdo_news',
		'rewrite' => array(
				'slug' => 'news/news-release',
				'with_front' => false
		),
		'supports' => array(
			'title',
			'page-attributes',
			'editor' 
		),
		'labels' => array(
			'name' => 'News',
			'singular_name' => 'News',
			'add_new' => 'Add News',
			'add_new_item' => 'Add News',
			'edit_item' => 'Edit News',
			'new_item' => 'New News',
			'view_item' => 'View News',
			'search_items' => 'Search News',
			'not_found' => 'No News Found',
			'not_found_in_trash' => 'No News Found in Trash'
		),
		'capability_type' => 'post',
		'hierarchical' => true,
        // 'register_meta_box_cb' => 'add_portfolio_metaboxes',
        'taxonomies' => array( 'category', 'post_tag' ),
        'has_archive' => true
	);

	// -- register the portfolio post type
	register_post_type( 'wdo_news', $amt_wdo_news_args );
}

