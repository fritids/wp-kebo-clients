<?php
/*
 * Registers the Testimonials Custom Post Type
 */

if ( ! defined( 'kbcl_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * Register the Testimonials CPT (Custom Post Type)
 */
function kbcl_create_testimonials_cpt() {
    
    $options = kbcl_get_plugin_options();
    
    /*
     * Set the Labels to be used for the CPT
     */
    $labels = array(
        'name' => __('Testimonials', 'kbcl'),
        'menu_name' => __('Testimonials', 'kbcl'),
        'singular_name' => __('Testimonial', 'kbcl'),
        'all_items' => __('All Testimonials', 'kbcl'),
        'add_new' => _x('Add New', 'kbcl'),
        'add_new_item' => __('Add New Testimonial', 'kbcl'),
        'edit' => __('Edit', 'kbcl'),
        'edit_item' => __('Edit Testimonial', 'kbcl'),
        'new_item' => __('New Testimonial', 'kbcl'),
        'view' => __('View', 'kbcl'),
        'view_item' => __('View Testimonial', 'kbcl'),
        'search_items' => __('Search Testimonials', 'kbcl'),
        'not_found' => __('No Testimonials Found', 'kbcl'),
        'not_found_in_trash' => __('No Testimonials Found in Trash', 'kbcl'),
        'parent' => __('Parent Testimonial', 'kbcl'),
        'parent_item_colon' => __('Testimonial:', 'kbcl')
    );
    
    /*
     * Prepare the args used to register the CPT
     */
    $args = array(
        'labels' => $labels,
        'description' => __('Testimonials', 'kbcl'),
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => false,
        'show_in_menu' => true, // Visible as Top Level Menu
        'show_in_admin_bar',
        'menu_position' => 20.83841, // TODO??
        'capability_type' => 'post',
        'hierarchical' => false,
        // Can Contain 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions'
        'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'taxonomies' => array(''),
        'menu_icon' => '',
        'rewrite' => array(
            'slug' => $options['testimonials_archive_page_slug'], // TODO: change to dynamic $slug
            'feeds' => true, // rss feeds
            'pages' => true, // prepares for pagination
            'with_front' => false // use url prefix like /blog etc.
        ),
        'has_archive' => true,
        'can_export' => true // can be exported
    );

    // Register the CPT
    register_post_type( 'kbcl_testimonials', $args );
    
}
add_action( 'init', 'kbcl_create_testimonials_cpt' );
