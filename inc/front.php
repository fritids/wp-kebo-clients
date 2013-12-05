<?php
/* 
 * Customisations to the Front End
 */

if ( ! defined( 'KBCL_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * Tells WordPress which template file to use
 */
function kbcl_clients_template_redirect( $template ) {

    $post_type = get_query_var( 'post_type' );
    
    // Check Post Type
    if ( empty( $post_type ) || 'kbcl_clients' != $post_type ) {
        return $template;
    }

    /*
     * Check if it is a single Testimonial or not.
     */
    if ( ! is_single() ) {

        // Check the Child Theme
        if ( file_exists( get_stylesheet_directory() . '/archive-kbcl_clients.php' ) ) {

            $template = get_stylesheet_directory() . '/archive-kbcl_clients.php';

        }

        // Check the Parent Theme
        elseif ( file_exists( get_template_directory() . '/archive-kbcl_clients.php' ) ) {

            $template = get_template_directory() . '/archive-kbcl_clients.php';

        }

        // Use the Plugin Files
        else {

            $template = kbcl_PATH . 'templates/archive-kbcl_clients.php';

        }

    } else {

        // Check the Child Theme
        if ( file_exists( get_stylesheet_directory() . '/single-kbcl_clients.php' ) ) {
                
            $template = get_stylesheet_directory() . '/single-kbcl_clients.php';
                
        }
            
        // Check the Parent Theme
        elseif ( file_exists( get_template_directory() . '/single-kbcl_clients.php' ) ) {
                
            $template = get_template_directory() . '/single-kbcl_clients.php';
                
        }
            
        // Use the Plugin Files
        else {
                
            $template = kbcl_PATH . 'templates/single-kbcl_clients.php';
                
       }

    }

    return $template;
    
}
add_filter( 'template_include', 'kbcl_clients_template_redirect' );

/**
 * Testimonial Archive Query.
 */
function kbcl_clients_archive_query( $query ) {

    // Is admin or not main query
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // Set Clients per Page as per user option
    if ( isset( $query->query_vars['post_type'] ) && ( 'kbcl_clients' == $query->query_vars['post_type'] ) ) {

        $options = kbcl_get_plugin_options();
        
        // Orders by the Menu Order attribute
        //$query->set( 'orderby', 'menu_order' );
        // Ascending order (1 first, etc).
        //$query->set( 'order', 'ASC' );
        // User Option for Posts per Page
        $query->set( 'posts_per_archive_page', $options['clients_archive_posts_per_page'] );
        
    }
    
    return;

}
add_filter( 'pre_get_posts', 'kbcl_clients_archive_query', 1 );