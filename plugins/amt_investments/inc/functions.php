<?php

// -- register install script
register_activation_hook(__FILE__, 'amt_wsc_investments_install');

// -- register the deactivation script
register_deactivation_hook(__FILE__, 'amt_wsc_investments_deactivate');

// -- runs when plug-in is installed
function amt_wsc_investments_install(){
}

// -- run on uninstall deletes options
function amt_wsc_investments_deactivate() {
	// -- delete options
	// -- delete_option('total_columns');
}

// Load our custom assets.
add_action( 'admin_enqueue_scripts', 'amt_wsc_investments_assets');

function amt_wsc_investments_assets(){

}

// -- Set up the post types
add_action('init', 'amt_wsc_investments_regiser_post_types');

// -- Register Post Types function
function amt_wsc_investments_regiser_post_types(){

	// -- set arguments for the portfolio_page post type
	$amt_wsc_investments_args = array(
		'public' => true,
		'query_var' => 'wsc_investments',
		'rewrite' => array(
				'slug' => 'investments/investment',
				'with_front' => false
		),
		'supports' => array(
			'title',
			'page-attributes',
		),
		'labels' => array(
			'name' => 'Investments',
			'singular_name' => 'Investment',
			'add_new' => 'Add an Investment',
			'add_new_item' => 'Add an Investment',
			'edit_item' => 'Edit an Investment',
			'new_item' => 'New Investment',
			'view_item' => 'View Investments',
			'search_items' => 'Search Investments ',
			'not_found' => 'No Investments Found',
			'not_found_in_trash' => 'No Investments Found in Trash'
		),
		'capability_type' => 'post',
		'hierarchical' => true,
        // 'register_meta_box_cb' => 'add_portfolio_metaboxes',
        'taxonomies' => array( ),
        'has_archive'   => true
	);

	// -- register the portfolio post type
	register_post_type( 'wsc_investments', $amt_wsc_investments_args );
}
