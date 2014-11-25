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
			'hierarchical' => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'sort' => true,
			'label' => __( 'Position' ),
			'rewrite' => array( 'slug' => 'position' ),
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

add_action( 'restrict_manage_posts', 'my_filter_list' );
function my_filter_list() {
    $screen = get_current_screen();
    global $wp_query;
    if ( $screen->post_type == 'wsc_team' ) {
        wp_dropdown_categories( array(
            'show_option_all' => 'Show All Positions',
            'taxonomy' => 'position',
            'name' => 'position',
            'orderby' => 'name',
            'selected' => ( isset( $wp_query->query['position'] ) ? $wp_query->query['position'] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ) );
    }
}

add_filter( 'parse_query','perform_filtering' );
function perform_filtering( $query ) {
    $qv = &$query->query_vars;
    if ( ( $qv['position'] ) && is_numeric( $qv['position'] ) ) {
        $term = get_term_by( 'id', $qv['position'], 'position' );
        $qv['position'] = $term->slug;
    }
}

/* -------------------------------------------------------------------------- */
add_filter('manage_wsc_team_posts_columns', 'mbe_change_table_column_titles');
function mbe_change_table_column_titles($columns){
	unset($columns['date']);// temporarily remove, to have custom column before date column
	$columns['taxonomy-position'] = 'Position';
	$columns['date'] = 'Date';// readd the date column
	return $columns;
}

add_action('manage_wsc_team_posts_custom_column', 'mbe_change_column_rows', 10, 2);
function mbe_change_column_rows($column_name, $post_id){
	if($column_name == 'YOUR-COLUMN-SLUG'){
		echo get_the_term_list($post_id, 'position', '', ', ', '').PHP_EOL;
	}
}

add_filter('manage_edit-wsc_team_sortable_columns', 'mbe_change_sortable_columns');
function mbe_change_sortable_columns($columns){
	$columns['taxonomy-position'] = 'taxonomy-position';
	return $columns;
}

add_filter('posts_clauses', 'mbe_sort_custom_column', 10, 2);
function mbe_sort_custom_column($clauses, $wp_query){
	global $wpdb;
	if(isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'Position'){
		$clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;
		$clauses['where'] .= "AND (taxonomy = 'position' OR taxonomy IS NULL)";
		$clauses['groupby'] = "object_id";
		$clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC)";
		if(strtoupper($wp_query->get('order')) == 'ASC'){
			$clauses['orderby'] .= 'ASC';
		} else{
			$clauses['orderby'] .= 'DESC';
		}
	}
	return $clauses;
}
