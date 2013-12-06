<?php
/*
 * Registers the Clients Custom Post Type
 */

if ( ! defined( 'KBCL_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * Register the Clients CPT (Custom Post Type)
 */
function kbcl_create_clients_cpt() {
    
    $options = kbcl_get_plugin_options();
    
    /*
     * Set the Labels to be used for the CPT
     */
    $labels = array(
        'name' => __('Clients', 'kbcl'),
        'menu_name' => __('Clients', 'kbcl'),
        'singular_name' => __('Client', 'kbcl'),
        'all_items' => __('All Clients', 'kbcl'),
        'add_new' => _x('Add New', 'kbcl'),
        'add_new_item' => __('Add New Client', 'kbcl'),
        'edit' => __('Edit', 'kbcl'),
        'edit_item' => __('Edit Client', 'kbcl'),
        'new_item' => __('New Client', 'kbcl'),
        'view' => __('View', 'kbcl'),
        'view_item' => __('View Client', 'kbcl'),
        'search_items' => __('Search Clients', 'kbcl'),
        'not_found' => __('No Clients Found', 'kbcl'),
        'not_found_in_trash' => __('No Clients Found in Trash', 'kbcl'),
        'parent' => __('Parent Client', 'kbcl'),
        'parent_item_colon' => __('Client:', 'kbcl')
    );
    
    /*
     * Prepare the args used to register the CPT
     */
    $args = array(
        'labels' => $labels,
        'description' => __('Clients', 'kbcl'),
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
            'slug' => $options['clients_archive_page_slug'], // TODO: change to dynamic $slug
            'feeds' => true, // rss feeds
            'pages' => true, // prepares for pagination
            'with_front' => false // use url prefix like /blog etc.
        ),
        'has_archive' => true,
        'can_export' => true // can be exported
    );

    // Register the CPT
    register_post_type( 'kbcl_clients', $args );
    
}
add_action( 'init', 'kbcl_create_clients_cpt', 1 );
