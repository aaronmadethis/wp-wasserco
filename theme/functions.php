<?php

/* ================================================================================
ADD THUMBNAIL SUPPORT AND ADDITIONAL IMAGE SIZES
================================================================================ */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 800, 800, true ); // default Post Thumbnail dimensions (cropped)
}	
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'fullscreen', 2880, 1800, false );
	add_image_size( 'team_bio', 304, 394, true );
	add_image_size( 'investment_big', 634, 382, false );
	add_image_size( 'investment_small', 468, 322, false );
}

/* ================================================================================
ADD MENUS AND POST FORMAT SUPPORT
================================================================================ */
if ( ! function_exists( 'amt_wp_setup' ) ) {

	function amt_wp_setup() {
		register_nav_menus( array( 'main' => 'Home Menu' ) );

		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat') );
	}

}

add_action( 'after_setup_theme', 'amt_wp_setup' );

/* ================================================================================
HELP WITH EMAIL FORM
================================================================================ */
add_filter( 'wp_mail_from', 'my_mail_from' );
function my_mail_from( $email ) {
    return "info@wasserco.com";
}

add_filter( 'wp_mail_from_name', 'my_mail_from_name' );
function my_mail_from_name( $name ){
    return "Wasserstein & Co";
}

/* ================================================================================
CREATE OPTIONS PAGE
================================================================================ */
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Site Settings',
		'menu_title'	=> 'Site Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}


/* ================================================================================
REMOVE POSTS AND COMMENTS FROM ADMIN
================================================================================ */
function remove_menus(){
	remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );

/* ================================================================================
CREATE A MULTI-COLUMN LIST OUT OF ONE LIST
================================================================================ */
function create_columns($html){
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	foreach($dom->getElementsByTagName('p') as $node){
	    //$array[] = $dom->saveHTML($node);
	    $array[] = $node->nodeValue;
	}
	$result = count($array);
	$col_length = $result / 2;
	$col_length = ceil( $col_length );
	$html='<ul class="no_1">';

	$counter = 0;
	foreach ($array as $key => $value) {
		if($counter == $col_length ){
			$html .= '</ul>';
			$html .= '<ul class="no_2">';
			$counter = 0;
		}
		$html .= '<li>' . $value . '</li>';
		++$counter;
	}
	$html .= '</ul>';

	//print_r($array);
	return $html;
}

/* ================================================================================
HOME PAGE HEADER TITLE - HACK FOR CUSTOM HOME PAGE
================================================================================ */
add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );
function baw_hack_wp_title_for_home( $title )
{
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Home', 'theme_domain' ) . ' | ' . get_bloginfo( 'description' );
  }
  return $title;
}

/* ================================================================================
FACEBOOK SHARING FOR HEADER
================================================================================ */
function get_facebook_share_meta($post){
	$theme_dir_path = get_stylesheet_directory_uri();
	
	if( is_single($post) ){
		$fb_meta = array();
		$fb_meta['title'] = $post->post_title;
		$fb_meta['description'] = $post->post_excerpt;
		$fb_meta['type'] = 'website';
		$fb_meta['url'] = get_permalink( $post->ID );

		$image_id = get_post_thumbnail_id($post->ID);
		$share_img = wp_get_attachment_image_src($image_id, 'post-thumbnail');
		if(!$share_img){
			$fb_meta['image'] = $theme_dir_path . "/images/facebook-img.jpg";
		}else{
			$fb_meta['image'] = $share_img[0];
		}
		
	}else{
		$fb_meta = array();
		$fb_meta['title'] = "Ovation Chicago";
		$fb_meta['description'] = "Event space in Chicago Illinois. Tell only your closest friends.";
		$fb_meta['type'] = 'website';
		$fb_meta['url'] = 'http://ovationchicago.com/';
		$fb_meta['image'] = $theme_dir_path . "/images/facebook-img.jpg";
	}
	return $fb_meta;
}

/* ================================================================================
BETTER POST IMAGE THUMBNAIL
* checks for post featured image first
* if no featured image attempt to scrape the post for the first image
* if no image in the post then use a general placeholder image
================================================================================ */
function ap_better_thunbnails( $post_id, $img_size ){
	if( has_post_thumbnail( $post_id ) ){
		$image_id = get_post_thumbnail_id($post_id);
		$thumb = wp_get_attachment_image_src($image_id, $img_size);
		return $thumb;
	}else{
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $post_id
		);
		$attachments = get_posts( $args );
		if ( $attachments ) {
			$image_id = $attachments[0]->ID;
			$thumb = wp_get_attachment_image_src($image_id, $img_size);
			return $thumb;
		}else{
			$image_id = get_field('placeholder_image', 'options');
			$thumb = wp_get_attachment_image_src($image_id, $img_size);
			return $thumb;
		}
	}
}

/* ================================================================================
CREATE A MULTI-COLUMN TEXT OUT OF ONE TEXT
================================================================================ */
function create_text_columns($html, $num_col){
	//count number of characters
	$base_char_leng = strlen($html);

	$halfway = $base_char_leng / 2;

	//divide number of characters by number of desired columns
	$char_per_col = $base_char_leng / $num_col;

	//find the closest space
	$first_p = strpos($html, '</p>', $char_per_col);
	$pos = strpos($html, '</p>', $char_per_col);
	if ($pos === false) {
		//no paragraph tags
		$char_per_col = $char_per_col + 90;
		$pos = strpos($html, ' ', $char_per_col);
		//$pos = $pos + 90;

		$first_col = substr($html, 0, $pos);
		$second_col = substr($html, $pos + 1);
		$bug = 1;

	}elseif ( $pos < $halfway && $pos > ($halfway - 20) ) {
		//paragraph break is close to the middle
		//find the closes space starting from the middle
		$char_per_col = $char_per_col + 90;
		$pos = strpos($html, ' ', $char_per_col);
		//$pos = $pos + 90;

		$first_col = substr($html, 0, $pos);
		$first_col .= htmlentities('</p>');
		$second_col = substr($html, $pos + 1);
		$second_col = htmlentities('<p>') . $second_col;
		$bug = 3;

	}elseif ( ($base_char_leng - $pos) <= 5 ) {
		//paragraph break is at the end
		//find the closes space starting from the middle
		$pos = strpos($html, '. ', ($char_per_col + 70) );
		//$pos = $pos + 90;

		$first_col = substr($html, 0, ($pos+2));
		$first_col .= htmlentities('</p>');
		$second_col = substr($html, $pos + 1);
		$second_col = htmlentities('<p>') . $second_col;
		$bug = 4;

	}else{
		$pos = $pos + 4;
		$first_col = substr($html, 0, $pos);
		$second_col = substr($html, $pos + 1);
		$bug = 5;

	}
	
	$result = array();
	$result[] = $first_col;
	$result[] = $second_col;
	$result['bug'] = $bug;
	$result['base_char_leng'] = $base_char_leng;
	$result['pos'] = $pos;
	//$result['raw'] = $html;
	//$result['first_p'] = $first_p;

	return $result;

}

/* ================================================================================
BREADCRUMB
================================================================================ */
function the_breadcrumb($p_id) {
    $post = get_post($p_id);
    $html = '<ul class="wp_breadcrumb clearfix">';
    if (!is_home()) {
        $html .= '<li><a href="';
        $html .= get_option('home');
        $html .= '">';
        $html .= 'Wasserstein & Co.';
        $html .= '</a></li><li class="breaker"> | </li>';
		if (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                	if($ancestor == 10){
                		$anc_title = "Wasserstein Partners";
                	}else if($ancestor == 28){
                		$anc_title = "WDO";
                	}else{
                		$anc_title = get_the_title($ancestor);
                	}
                    $output = '<li><a href="'.get_permalink($ancestor).'" title="'.$anc_title.'">'.$anc_title.'</a></li> <li class="breaker"> | </li>';
                }
                $html .= $output;
                $html .= '<li><strong title="'.$title.'"> '.$title.'</strong></li>';
            } else {
                $html .= '<li><strong> '.get_the_title().'</strong></li>';
            }
        } elseif( is_single() ){
        	if( get_post_type( $post->ID ) == 'wsc_press'){
        		$title = get_the_title();
        		$anc_title = "Press Releases";
        		$ancestor = get_page_by_title( $anc_title);

        		$html .= '<li><a href="'.get_permalink(10).'" title="Wasserstein Partners">Wasserstein Partners</a></li> <li class="breaker"> | </li>';
        		$html .= '<li><a href="'.get_permalink($ancestor->ID).'" title="'.$anc_title.'">'.$anc_title.'</a></li> <li class="breaker"> | </li>';
        		$html .= '<li><strong title="'.$title.'"> '.$title.'</strong></li>';
        	}elseif(get_post_type( $post->ID ) == 'wdo_news'){
        		$title = get_the_title();
        		$anc_title = "News";
        		$ancestor = get_page_by_title( $anc_title);

        		$html .= '<li><a href="'.get_permalink(28).'" title="WDO">WDO</a></li> <li class="breaker"> | </li>';
        		$html .= '<li><a href="'.get_permalink($ancestor->ID).'" title="'.$anc_title.'">'.$anc_title.'</a></li> <li class="breaker"> | </li>';
        		$html .= '<li><strong title="'.$title.'"> '.$title.'</strong></li>';
        	}else{
        		$html .= '<li><strong> '.get_the_title().'</strong></li>';
        	}
        }
    }
    $html .= '</ul>';
    echo $html;
}

//Action Hook Single Content
add_action('amt_create_breadcrumb', 'the_breadcrumb', 10);

/* ================================================================================
HOOKS AND ACTIONS - LAYOUTS
================================================================================ */
//Condition enable portfolio template
function amt_check_portfolio_template(){
	$switch = false;
	
	if(is_singular('post')){

		//** get portfolio template meta
		$portfolio = get_field('post_type', get_the_ID() );
		
		if($portfolio ){
			$switch = true;
		}
	}

	return $switch;
	
}

//Action Hook Single Content
add_action('amt_interface_single_content', 'amt_interface_single_portfolio', 10);

//Template Single portfolio
function amt_interface_single_portfolio(){
	if(amt_check_portfolio_template()){
		amt_get_template_part('single', 'portfolio');
	}else{
		amt_get_template_part('single', 'blog');
	}
}

//UX Theme Get Template
function amt_get_template_part($key, $name){
	get_template_part('template/' . $key, $name);
}


/* ================================================================================
AJAX INVESTMENTS
================================================================================ */
add_action("wp_ajax_nopriv_amt_investments_overlay", "amt_investments_overlay");
add_action("wp_ajax_amt_investments_overlay", "amt_investments_overlay");

function amt_investments_overlay(){
	$page_id = $_REQUEST['the_id'];
	$logo = wp_get_attachment_image_src( get_field('logo', $page_id), 'full' );
	$img_pri = wp_get_attachment_image_src( get_field('image', $page_id), 'full' );
	$img_sec = wp_get_attachment_image_src( get_field('second_image', $page_id), 'full' );
	$title = get_the_title($page_id);
	$init = get_field('initial_investment', $page_id);
	$entry = get_field('entry', $page_id);
	$exit = get_field('exit', $page_id);
	$url = get_field('url', $page_id);
	$text = get_field('full_description', $page_id);

	$result = array(
		'logo' => $logo,
		'img_pri' => $img_pri,
		'img_sec' => $img_sec,
		'title' => $title,
		'init' => $init,
		'entry' => $entry,
		'exit' => $exit,
		'url' => $url,
		'text' => $text
		);

	$result = json_encode( $result );
    echo $result;

	die();
}

/* ================================================================================
COUNTS THE NUMBER OF DATABASE HITS PER PAGE
================================================================================ 
add_action( 'wp_footer', 'tcb_note_server_side_page_speed' );
function tcb_note_server_side_page_speed() {
	date_default_timezone_set( get_option( 'timezone_string' ) );
	$content  = '[ ' . date( 'Y-m-d H:i:s T' ) . ' ] ';
	$content .= 'Page created in ';
	$content .= timer_stop( $display = 0, $precision = 2 );
	$content .= ' seconds from ';
	$content .= get_num_queries();
	$content .= ' queries';
	if( ! current_user_can( 'administrator' ) ) $content = "<!-- $content -->";
	echo $content;
}
*/

/* ================================================================================
FUNCTIONS FOR ADDING JAVASCRIPTS
================================================================================ */
add_action( 'template_redirect', 'my_script_enqueuer' );

function my_script_enqueuer() {
	$display_script_url = get_bloginfo('template_directory') . '/js/display-0.1.js';
	wp_register_script( 'display_script', $display_script_url  );
	$protocol = isset( $_SERVER["HTTPS"] ) ? 'https://' : 'http://';
	$params = array( 'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ) );
	wp_localize_script( 'display_script', 'amt_investment_full', $params );

	wp_enqueue_script('jquery');

	$modernizr_url = get_bloginfo('template_directory') . '/js/modernizr.custom.97178.js';
	wp_enqueue_script('modernizr', $modernizr_url);

	$bootstrap_url = get_bloginfo('template_directory') . '/js/bootstrap.min.js';
	wp_enqueue_script('bootstrap', $bootstrap_url, array('jquery', 'modernizr'), '', true);

	//$slicknav_url = get_bloginfo('template_directory') . '/js/jquery.slicknav.min.js';
	//wp_enqueue_script('slicknav', $slicknav_url, array('jquery', 'modernizr'), '', true);

	$plugins = get_bloginfo('template_directory') . '/js/plugins-0.1.js';
	wp_enqueue_script('plugins', $plugins, array('jquery', 'modernizr'), '', true);
	wp_enqueue_script('display_script', '', array('jquery', 'modernizr', 'plugins'), '', true);

	wp_enqueue_style( 'bootstrap_css', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'slicknav_css', get_template_directory_uri() . '/css/slicknav.css' );

}

?>