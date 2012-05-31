<?php
function kb_remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
	$wp_admin_bar->remove_menu('comments');         // Remove the comments link
}
add_action( 'wp_before_admin_bar_render', 'kb_remove_admin_bar_links' );

if (!is_admin()) {
//	wp_deregister_script('admin-bar');
//	wp_deregister_style('admin-bar');
//	remove_action('wp_footer','wp_admin_bar_render',1000);
}
//add_theme_support( 'admin-bar', array( 'callback' => '__return_false') );

remove_filter('atom_service_url','atom_service_url_filter');

add_action('init', 'kb_remove_comment_support');
add_action( 'admin_menu', 'kb_remove_admin_menus' );

function kb_remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );

}
function kb_remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
	remove_menu_page('link-manager.php');
	remove_menu_page('edit.php');
}


remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' ); // Display relational links for the posts adjacent to the current post
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'rel_canonical', 10, 0 ); // start link
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version

function kb_remove_l10n() {
	wp_deregister_script( 'l10n' );
}
add_action( 'wp_print_scripts', 'kb_remove_l10n' );

add_filter( 'login_headerurl', 'namespace_login_headerurl' );
/**
 * Replaces the login header logo URL
 *
 * @param $url
 */
function namespace_login_headerurl( $url ) {
	$url = home_url( '/' );
	return $url;
}

add_filter( 'login_headertitle', 'namespace_login_headertitle' );
/**
 * Replaces the login header logo title
 *
 * @param $title
 */
function namespace_login_headertitle( $title ) {
	$title = get_bloginfo( 'name' );
	return $title;
}

add_action( 'login_head', 'namespace_login_style' );
/**
 * Replaces the login header logo
 */
function namespace_login_style() {
	echo '<style>.login h1 a { display: block;  background-image: url( ' . get_stylesheet_directory_uri() . '/images/logo.png ) !important; }</style>';
}

function custom_admin_footer() {
	echo 'Customised WordPress Content Management System by <a href="http://bloke.org" target="_new">kieranbarnes</a>';
}
add_filter('admin_footer_text', 'custom_admin_footer');


// REMOVE META BOXES FROM DEFAULT POSTS SCREEN
function remove_default_post_screen_metaboxes() {
	remove_meta_box( 'postcustom','post','normal' ); // Custom Fields Metabox
	remove_meta_box( 'formatdiv','post','normal' ); // Custom Fields Metabox
	remove_meta_box( 'tagsdiv-post_tag','post','normal' ); // Custom Fields Metabox
	remove_meta_box( 'postexcerpt','post','normal' ); // Excerpt Metabox
	remove_meta_box( 'commentstatusdiv','post','normal' ); // Comments Metabox
	remove_meta_box( 'trackbacksdiv','post','normal' ); // Talkback Metabox
	remove_meta_box( 'slugdiv','post','normal' ); // Slug Metabox
	remove_meta_box( 'authordiv','post','normal' ); // Author Metabox
}
add_action('admin_menu','remove_default_post_screen_metaboxes');


// REMOVE META BOXES FROM DEFAULT PAGES SCREEN
function remove_default_page_screen_metaboxes() {
	remove_meta_box( 'postcustom','page','normal' ); // Custom Fields Metabox
	remove_meta_box( 'postexcerpt','page','normal' ); // Excerpt Metabox
	remove_meta_box( 'commentstatusdiv','page','normal' ); // Comments Metabox
	remove_meta_box( 'trackbacksdiv','page','normal' ); // Talkback Metabox
	remove_meta_box( 'slugdiv','page','normal' ); // Slug Metabox
	remove_meta_box( 'authordiv','page','normal' ); // Author Metabox
}
add_action('admin_menu','remove_default_page_screen_metaboxes');

global $user_login;
get_currentuserinfo();
if (!current_user_can('update_plugins')) { // checks to see if current user can update plugins
	add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
	add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}


function kb_remove_dashboard_widgets() {
	// Globalize the metaboxes array, this holds all the widgets for wp-admin

	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
}

add_action('wp_dashboard_setup', 'kb_remove_dashboard_widgets' );

?>
