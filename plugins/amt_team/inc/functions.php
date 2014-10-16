<?php

// -- register install script
register_activation_hook(__FILE__, 'amt_wsc_team_install');

// -- register the deactivation script
register_deactivation_hook(__FILE__, 'amt_wsc_team_deactivate');

// -- runs when plug-in is installed
function amt_wsc_team_install(){
}

// -- run on uninstall deletes options
function amt_wsc_team_deactivate() {
	// -- delete options
	// -- delete_option('total_columns');
}

// Load our custom assets.
add_action( 'admin_enqueue_scripts', 'amt_wsc_team_assets');

function amt_wsc_team_assets(){

}

// -- Set up the post types
add_action('init', 'amt_wsc_team_regiser_post_types');

// -- Register Post Types function
function amt_wsc_team_regiser_post_types(){

	// -- set arguments for the portfolio_page post type
	$amt_wsc_team_args = array(
		'public' => true,
		'query_var' => 'wsc_team',
		'rewrite' => array(
				'slug' => 'team/team-member',
				'with_front' => false
		),
		'supports' => array(
			'title',
			'page-attributes',
		),
		'labels' => array(
			'name' => 'Team',
			'singular_name' => 'Team',
			'add_new' => 'Add a Team Member',
			'add_new_item' => 'Add a Team Member',
			'edit_item' => 'Edit a Team Member',
			'new_item' => 'New team Member',
			'view_item' => 'View Team Members',
			'search_items' => 'Search Team Members',
			'not_found' => 'No Team Members Found',
			'not_found_in_trash' => 'No Team Members Found in Trash'
		),
		'capability_type' => 'post',
		'hierarchical' => true,
        // 'register_meta_box_cb' => 'add_portfolio_metaboxes',
        'taxonomies' => array( 'position' ),
        'has_archive'   => true
	);

	// -- register the portfolio post type
	register_post_type( 'wsc_team', $amt_wsc_team_args );
}


function position_init() {
	// create a new taxonomy
	register_taxonomy(
		'position',
		'wsc_team',
		array(
			'label' => __( 'Position' ),
			'rewrite' => array( 'slug' => 'position' ),
			'hierarchical' => true,
			'sort' => true,
			'capabilities' => array(
				'assign_terms',
				'edit_terms',
				'manage_terms',
				'delete_terms'
			)
		)
	);
}
add_action( 'init', 'position_init' );
