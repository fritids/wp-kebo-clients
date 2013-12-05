<?php
/* 
 * Customisations to the Front End
 */

if ( ! defined( 'kbcl_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * Tells WordPress which template file to use
 */
function kbcl_testimonials_template_redirect( $template ) {

    $post_type = get_query_var( 'post_type' );
    
    // Check Post Type
    if ( empty( $post_type ) || 'kbcl_testimonials' != $post_type ) {
        return $template;
    }

    /*
     * Check if it is a single Testimonial or not.
     */
    if ( ! is_single() ) {

        // Check the Child Theme
        if ( file_exists( get_stylesheet_directory() . '/archive-kbcl_testimonials.php' ) ) {

            $template = get_stylesheet_directory() . '/archive-kbcl_testimonials.php';

        }

        // Check the Parent Theme
        elseif ( file_exists( get_template_directory() . '/archive-kbcl_testimonials.php' ) ) {

            $template = get_template_directory() . '/archive-kbcl_testimonials.php';

        }

        // Use the Plugin Files
        else {

            $template = kbcl_PATH . 'templates/archive-kbcl_testimonials.php';

        }

    } else {

        // Check the Child Theme
        if ( file_exists( get_stylesheet_directory() . '/single-kbcl_testimonials.php' ) ) {
                
            $template = get_stylesheet_directory() . '/single-kbcl_testimonials.php';
                
        }
            
        // Check the Parent Theme
        elseif ( file_exists( get_template_directory() . '/single-kbcl_testimonials.php' ) ) {
                
            $template = get_template_directory() . '/single-kbcl_testimonials.php';
                
        }
            
        // Use the Plugin Files
        else {
                
            $template = kbcl_PATH . 'templates/single-kbcl_testimonials.php';
                
       }

    }

    return $template;
    
}
add_filter( 'template_include', 'kbcl_testimonials_template_redirect' );

/**
 * Testimonial Archive Query.
 */
function kbcl_testimonials_archive_query( $query ) {

    // Is admin or not main query
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // Set Testimonials per Page as per user option
    if ( isset( $query->query_vars['post_type'] ) && ( 'kbcl_testimonials' == $query->query_vars['post_type'] ) ) {

        $options = kbcl_get_plugin_options();
        
        // Orders by the Menu Order attribute
        //$query->set( 'orderby', 'menu_order' );
        // Ascending order (1 first, etc).
        //$query->set( 'order', 'ASC' );
        // User Option for Posts per Page
        $query->set( 'posts_per_archive_page', $options['testimonials_archive_posts_per_page'] );
        
    }
    
    return;

}
add_filter( 'pre_get_posts', 'kbcl_testimonials_archive_query', 1 );