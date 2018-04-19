<?php

/** Includes all wordpress event handling, with the exception of events related to setting up custom columns **/

add_action('wp_enqueue_scripts', 'load_css_and_js' );
add_action( 'init', 'createDestinationCustomPostType' );
add_action( 'init', 'createPlaceCustomPostType' );
add_action( 'init', 'createTeamMemberCustomPostType' );
add_action( 'init', 'createRegionTaxonomy' );
add_action( 'init', 'createPlaceTypeTaxonomy' );
//add_action( 'init', 'removePagesEditor' );
add_action( 'admin_head', 'removePagesEditor' );
add_action('acf/init', 'advancedCustomFieldsInit');
add_filter('show_admin_bar', '__return_false');
add_filter( 'img_caption_shortcode', 'my_img_caption_shortcode', 10, 3 );

function my_img_caption_shortcode( $empty, $attr, $content ){

	$attr = shortcode_atts( array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => ''
	), $attr );

	if ( 1 > (int) $attr['width'] || empty( $attr['caption'] ) ) {
		return '';
	}

	if ( $attr['id'] ) {
		$attr['id'] = 'id="' . esc_attr( $attr['id'] ) . '" ';
	}

	return '<div ' . $attr['id']
	. 'class="post-image">'
	. do_shortcode( $content )
	. '<p class="wp-caption-text">' . $attr['caption'] . '</p>'
	. '</div>';

}


function load_css_and_js() {

	//Load ccs
	wp_enqueue_style( 'bootstrap-min', get_stylesheet_directory_uri().'/css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome-min', get_stylesheet_directory_uri().'/css/font-awesome-4.6.3/css/font-awesome.min.css' );
	wp_enqueue_style( 'site-styles', get_stylesheet_directory_uri().'/css/site-styles.less' );
	wp_enqueue_style( 'site-header-styles', get_stylesheet_directory_uri().'/css/site-header-styles.less' );
	wp_enqueue_style( 'front-page-styles', get_stylesheet_directory_uri().'/css/front-page-styles.less' );
	wp_enqueue_style( 'footer-styles', get_stylesheet_directory_uri().'/css/footer-styles.less' );
	wp_enqueue_style( 'post-box-styles', get_stylesheet_directory_uri().'/css/post-box-styles.less' );
	wp_enqueue_style( 'post-styles', get_stylesheet_directory_uri().'/css/post-styles.less' );
	wp_enqueue_style( 'destination-styles', get_stylesheet_directory_uri().'/css/destination-styles.less' );
	wp_enqueue_style( 'carousel-styles', get_stylesheet_directory_uri().'/css/carousel-styles.less' );
	wp_enqueue_style( 'item-box-styles', get_stylesheet_directory_uri().'/css/item-box-styles.less' );
	wp_enqueue_style( 'place-styles', get_stylesheet_directory_uri().'/css/place-styles.less' );
	wp_enqueue_style( 'slick.css', get_stylesheet_directory_uri().'/css/slick.css' );
	wp_enqueue_style( 'slick-theme.css', get_stylesheet_directory_uri().'/css/slick-theme.css' );
	wp_enqueue_style( 'lightbox-styles.css', get_stylesheet_directory_uri().'/css/lightbox.css' );

	//Load javascript
	wp_enqueue_script( 'jquery-min', get_stylesheet_directory_uri().'/js/jquery-3.1.1.min.js');
	wp_enqueue_script( 'bootstrap-min', get_stylesheet_directory_uri().'/js/bootstrap.min.js');
	wp_enqueue_script( 'site-javascript', get_stylesheet_directory_uri().'/js/site_javascript.js');
	wp_enqueue_script( 'slick', get_stylesheet_directory_uri().'/js/slick.min.js');
	wp_enqueue_script( 'object-fit', get_stylesheet_directory_uri().'/js/ofi.browser.js');
	wp_enqueue_script( 'light-box', get_stylesheet_directory_uri().'/js/lightbox.js');
	wp_enqueue_script( 'clamp', get_stylesheet_directory_uri().'/js/clamp.js');
}

function removePagesEditor(){

    global $pagenow;
    if( !( 'post.php' == $pagenow ) ) return;

    global $post;
    // Get the Post ID.
    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
    if( !isset( $post_id ) ) return;

	  // Hide the editor on the page titled 'Homepage'
	  $pageName = get_the_title($post_id);

	  if($pageName == 'All Posts' || $pageName == 'Destinations' || $pageName == 'Team Members'){ 
	    remove_post_type_support('page', 'editor');
	  }

}   

function createDestinationCustomPostType() {

	$labels = array(
		'name'               => 'Destination',
		'singular_name'      => 'Destination',
		'menu_name'          => 'Destination',
		'name_admin_bar'     => 'Destination',
		'add_new'            => 'Add Destination',
		'add_new_item'       => 'Add New Destination',
		'new_item'           => 'New Destination',
		'edit_item'          => 'Edit Destination',
		'view_item'          => 'View Destination',
		'all_items'          => 'All Destinations',
		'search_items'       => 'Search Destinations',
		'parent_item_colon'  => 'Parent Destination:',
		'not_found'          => 'No destinations found.',
		'not_found_in_trash' => 'No destination found in Trash.'
	);

	$args = array( 
		'public'      => true, 
		'labels'      => $labels,
		'description' => 'Post type for a destination',
		'menu_icon'   => 'dashicons-palmtree',
		'has_archive' => true,
		'supports'    => array('title','author','thumbnail', 'comments')
	);
	
	register_post_type( 'destination', $args );

	//Some fancy magic needed to get Wordpress to load custom page templates
	flush_rewrite_rules();
}

function createPlaceCustomPostType(){

	$labels = array(
		'name'               => 'Place',
		'singular_name'      => 'Place',
		'menu_name'          => 'Place',
		'name_admin_bar'     => 'Place',
		'add_new'            => 'Add Place',
		'add_new_item'       => 'Add New Place',
		'new_item'           => 'New Place',
		'edit_item'          => 'Edit Place',
		'view_item'          => 'View Place',
		'all_items'          => 'All Places',
		'search_items'       => 'Search Places',
		'parent_item_colon'  => 'Parent Place:',
		'not_found'          => 'No places found.',
		'not_found_in_trash' => 'No places found in Trash.'
	);

	$args = array( 
		'public'      => true, 
		'labels'      => $labels,
		'description' => 'Post type for a place',
		'menu_icon'   => 'dashicons-location-alt',
		'supports'    => array('title','author','thumbnail', 'comments')
	);
	
	register_post_type( 'place', $args );

	//Some fancy magic needed to get Wordpress to load custom page templates
	flush_rewrite_rules();

}

function createTeamMemberCustomPostType(){

	$labels = array(
		'name'               => 'Team Member',
		'singular_name'      => 'Team Member',
		'menu_name'          => 'Team Member',
		'name_admin_bar'     => 'Team Member',
		'add_new'            => 'Add Team Member',
		'add_new_item'       => 'Add New Team Member',
		'new_item'           => 'New Team Member',
		'edit_item'          => 'Edit Team Member',
		'view_item'          => 'View Team Member',
		'all_items'          => 'All Team Members',
		'search_items'       => 'Search Team Members',
		'parent_item_colon'  => 'Parent Team Member:',
		'not_found'          => 'No team members found.',
		'not_found_in_trash' => 'No team members found in Trash.'
	);

	$args = array( 
		'public'      => true, 
		'labels'      => $labels,
		'description' => 'Post type for team members',
		'menu_icon'   => 'dashicons-groups',
		'supports'    => array('title', 'thumbnail')
	);
	
	register_post_type( 'team_member', $args );

	//Some fancy magic needed to get Wordpress to load custom page templates
	flush_rewrite_rules();

}

function createRegionTaxonomy() {

	$labels = array(
		'name'                           => 'Region',
		'search_items'                   => 'Search Regions',
		'all_items'                      => 'All Regions',
		'edit_item'                      => 'Edit Region',
		'update_item'                    => 'Update Region',
		'add_new_item'                   => 'Add New Region',
		'new_item_name'                  => 'New Region Name',
		'menu_name'                      => 'Region',
		'view_item'                      => 'View Region',
		'popular_items'                  => 'Popular Region',
		'separate_items_with_commas'     => 'Separate regions with commas',
		'add_or_remove_items'            => 'Add or remove regions',
		'choose_from_most_used'          => 'Choose from the most used regions',
		'not_found'                      => 'No regions found'
	);

	register_taxonomy(
		'region',
		'destination',
		array(
			'label' => 'Region',
			'hierarchical' => true,
			'labels' => $labels
		)
	);
}

function createPlaceTypeTaxonomy() {

	$labels = array(
		'name'                           => 'Place Type',
		'search_items'                   => 'Search Place Types',
		'all_items'                      => 'All Place Types',
		'edit_item'                      => 'Edit Place Type',
		'update_item'                    => 'Update Place Type',
		'add_new_item'                   => 'Add New Place Type',
		'new_item_name'                  => 'New Place Type Name',
		'menu_name'                      => 'Place Type',
		'view_item'                      => 'View Place Type',
		'popular_items'                  => 'Popular Place Type',
		'separate_items_with_commas'     => 'Separate place type with commas',
		'add_or_remove_items'            => 'Add or remove place types',
		'choose_from_most_used'          => 'Choose from the most used place types',
		'not_found'                      => 'No place type found'
	);

	register_taxonomy(
		'place_type',
		'place',
		array(
			'label' => 'Place Type',
			'hierarchical' => true,
			'labels' => $labels
		)
	);
}

function advancedCustomFieldsInit() {
	
	acf_update_setting('google_api_key', 'AIzaSyBXL08t8b84vaMnb1D0X4Q0vga0JH-EgGA');
}

function excerpt_error_message_redirect($location) {
  remove_filter('redirect_post_location', __FILTER__, '99');
  return add_query_arg('excerpt_required', 1, $location);
}

?>
