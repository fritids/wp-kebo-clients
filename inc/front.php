<?php
/* 
 * Customisations to the Front End
 */

if ( ! defined( 'KBFR_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * Tells WordPress which template file to use
 */
function kbfr_friends_template_redirect( $template ) {

    $post_type = get_query_var( 'post_type' );
    
    // Check Post Type
    if ( empty( $post_type ) || 'kbfr_friends' != $post_type ) {
        return $template;
    }

    /*
     * Check if it is a single Testimonial or not.
     */
    if ( ! is_single() ) {

        // Check the Child Theme
        if ( file_exists( get_stylesheet_directory() . '/archive-kbfr_friends.php' ) ) {

            $template = get_stylesheet_directory() . '/archive-kbfr_friends.php';

        }

        // Check the Parent Theme
        elseif ( file_exists( get_template_directory() . '/archive-kbfr_friends.php' ) ) {

            $template = get_template_directory() . '/archive-kbfr_friends.php';

        }

        // Use the Plugin Files
        else {

            $template = KBFR_PATH . 'templates/archive-kbfr_friends.php';

        }

    } else {

        // Check the Child Theme
        if ( file_exists( get_stylesheet_directory() . '/single-kbfr_friends.php' ) ) {
                
            $template = get_stylesheet_directory() . '/single-kbfr_friends.php';
                
        }
            
        // Check the Parent Theme
        elseif ( file_exists( get_template_directory() . '/single-kbfr_friends.php' ) ) {
                
            $template = get_template_directory() . '/single-kbfr_friends.php';
                
        }
            
        // Use the Plugin Files
        else {
                
            $template = KBFR_PATH . 'templates/single-kbfr_friends.php';
                
       }

    }

    return $template;
    
}
add_filter( 'template_include', 'kbfr_friends_template_redirect' );

/**
 * Testimonial Archive Query.
 */
function kbfr_friends_archive_query( $query ) {

    // Is admin or not main query
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // Set Clients per Page as per user option
    if ( isset( $query->query_vars['post_type'] ) && ( 'kbfr_friends' == $query->query_vars['post_type'] ) ) {

        $options = kbfr_get_plugin_options();
        
        // Orders by the Menu Order attribute
        //$query->set( 'orderby', 'menu_order' );
        // Ascending order (1 first, etc).
        //$query->set( 'order', 'ASC' );
        // User Option for Posts per Page
        $query->set( 'posts_per_archive_page', $options['friends_archive_posts_per_page'] );
        
    }
    
    return;

}
add_filter( 'pre_get_posts', 'kbfr_friends_archive_query', 1 );
