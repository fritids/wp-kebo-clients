<?php
/*
 * Registers the Clients Custom Post Type
 */

if ( ! defined( 'KBFR_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * Register the Clients CPT (Custom Post Type)
 */
function kbfr_create_friends_cpt() {
    
    $options = kbfr_get_plugin_options();
    
    /*
     * Set the Labels to be used for the CPT
     */
    $labels = array(
        'name' => __('Friends', 'kbfr'),
        'menu_name' => __('Friends', 'kbfr'),
        'singular_name' => __('Friend', 'kbfr'),
        'all_items' => __('All Friends', 'kbfr'),
        'add_new' => _x('Add New', 'kbfr'),
        'add_new_item' => __('Add New Friend', 'kbfr'),
        'edit' => __('Edit', 'kbfr'),
        'edit_item' => __('Edit Friend', 'kbfr'),
        'new_item' => __('New Friend', 'kbfr'),
        'view' => __('View', 'kbfr'),
        'view_item' => __('View Friend', 'kbfr'),
        'search_items' => __('Search Friends', 'kbfr'),
        'not_found' => __('No Friends Found', 'kbfr'),
        'not_found_in_trash' => __('No Friends Found in Trash', 'kbfr'),
        'parent' => __('Parent Friend', 'kbfr'),
        'parent_item_colon' => __('Friend:', 'kbfr')
    );
    
    /*
     * Prepare the args used to register the CPT
     */
    $args = array(
        'labels' => $labels,
        'description' => __('Friends', 'kbfr'),
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => false,
        'show_in_menu' => true, // Visible as Top Level Menu
        'show_in_admin_bar',
        'menu_position' => 99, // 99+ for bottom of list
        'capability_type' => 'post',
        'hierarchical' => false,
        // Can Contain 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions'
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies' => array(''),
        'menu_icon' => '',
        'rewrite' => array(
            'slug' => $options['friends_archive_page_slug'], // TODO: change to dynamic $slug
            'feeds' => true, // rss feeds
            'pages' => true, // prepares for pagination
            'with_front' => false // use url prefix like /blog etc.
        ),
        'has_archive' => true,
        'can_export' => true // can be exported
    );

    // Register the CPT
    register_post_type( 'kbfr_friends', $args );
    
}
add_action( 'init', 'kbfr_create_friends_cpt', 1 );
