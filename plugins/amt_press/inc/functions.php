<?php

// -- register install script
register_activation_hook(__FILE__, 'amt_wsc_press_install');

// -- register the deactivation script
register_deactivation_hook(__FILE__, 'amt_wsc_press_deactivate');

// -- runs when plug-in is installed
function amt_wsc_press_install(){
}

// -- run on uninstall deletes options
function amt_wsc_press_deactivate() {
	// -- delete options
	// -- delete_option('total_columns');
}

// Load our custom assets.
add_action( 'admin_enqueue_scripts', 'amt_wsc_press_assets');

function amt_wsc_press_assets(){

}

// -- Set up the post types
add_action('init', 'amt_wsc_press_regiser_post_types');

// -- Register Post Types function
function amt_wsc_press_regiser_post_types(){

	// -- set arguments for the portfolio_page post type
	$amt_wsc_press_args = array(
		'public' => true,
		'query_var' => 'wsc_press',
		'rewrite' => array(
				'slug' => 'press/press-release',
				'with_front' => false
		),
		'supports' => array(
			'title',
			'page-attributes',
			'editor' 
		),
		'labels' => array(
			'name' => 'Press',
			'singular_name' => 'Press',
			'add_new' => 'Add a Press Release',
			'add_new_item' => 'Add a Press Release',
			'edit_item' => 'Edit a Press Release',
			'new_item' => 'New Press Release',
			'view_item' => 'View Press Releases',
			'search_items' => 'Search Press Releases',
			'not_found' => 'No Press Releases Found',
			'not_found_in_trash' => 'No Press Releases Found in Trash'
		),
		'capability_type' => 'post',
		'hierarchical' => true,
        // 'register_meta_box_cb' => 'add_portfolio_metaboxes',
        'taxonomies' => array( 'category', 'post_tag' ),
        'has_archive'   => true
	);

	// -- register the portfolio post type
	register_post_type( 'wsc_press', $amt_wsc_press_args );
}

