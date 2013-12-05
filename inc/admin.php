<?php
/* 
 * Customisations to the Admin Testimonials Listing.
 */

if ( ! defined( 'kbcl_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/**
 * Edit the Admin List Titles for Testimonials.
 */
function kbcl_testimonials_admin_columns( $columns ) {
    
    // Remove All Columns
    unset( $columns );
    
    // Add Required Columns
    $columns['cb'] = '<input type="checkbox" />';
    $columns['details'] = __( 'Details', 'kbcl' );
    $columns['title'] = __( 'Title', 'kbcl' );
    $columns['rating'] = __( 'Rating', 'kbcl' );
    $columns['date'] = __( 'Date', 'kbcl' );
    
    return $columns;
    
}	
add_filter( 'manage_edit-kbcl_testimonials_columns', 'kbcl_testimonials_admin_columns' );

/*
 * Adds which columns should be sortable.
 */
function kbcl_testimonials_sortable_admin_columns( $columns ) {
    
    // Add Required Columns
    $columns['title'] = 'title';
    $columns['date'] = 'date';
    
    return $columns;
    
}	
add_filter( 'manage_edit-kbcl_testimonials_sortable_columns', 'kbcl_testimonials_sortable_admin_columns' );

/*
 * Adds data to the custom admin columns.
 */
function kbcl_testimonials_admin_column_values( $column, $post_id ) {
    
    global $post;
    
    $kbcl_custom_meta = get_post_meta( $post->ID, 'kbcl_testimonials_post_meta', true );
    
    switch ( $column ) {

        case 'details' :
            
            // Prepare Meta
            $name = kbcl_get_review_name();
            $email = kbcl_get_review_email();
            $url = kbcl_get_review_url();
            
            // Output Name
            if ( ! empty ( $name ) && ! empty ( $url ) ) {
                
                echo '<a href="' . $url .'" target="_blank">' . $name . '</a><br>';
                
            } elseif ( ! empty ( $name ) ) {
                
                echo '<span>' . $name . '</span><br>';
                
            }
            
            // Output Email
            if ( ! empty( $email ) ) {
                
                echo '<a href="mailto:' . $email .'">' . $email . '</a>';
                
            }
            
            if ( empty ( $name ) && empty ( $email ) ) {
                
                echo '-';
                
            }
            
        break;
    
        case 'rating' :
            
            if ( kbcl_get_review_rating() ) {
                
                echo kbcl_get_review_rating_stars();
                
            } else {
                
                echo __('Not Rated', 'kbcl');
                
            }
            
        break;

    }
    
}
add_action( 'manage_kbcl_testimonials_posts_custom_column' , 'kbcl_testimonials_admin_column_values', 10, 2 );

/*
 * Adds custom Orderby data
 */
function kbcl_testimonials_admin_column_orderby( $vars ) {
    
    if ( !is_admin() ) {
        return $vars;
    }
    
    if ( ! isset( $vars['orderby'] ) ) {
        return $vars;
    }
    
    if ( 'title' == $vars['orderby'] ) {
	$vars = array_merge( $vars, array(
            'orderby' => 'title'
	));
    }
    
    return $vars;
    
}
add_filter( 'request', 'kbcl_testimonials_admin_column_orderby' );

/**
 * Custom Post Type Archive Pagination Limits.
 */
function kbcl_testimonials_admin_query( $query ) {

    // Testimonials Admin Query
    if ( is_admin() && $query->is_main_query() ) {

        // Set Testimonials per Page as per user option
        if ( isset( $query->query_vars['post_type'] ) && ( 'kbcl_testimonials' == $query->query_vars['post_type'] ) ) {

            // Orders by the Menu Order attribute
            //$query->set('orderby', 'menu_order');
            // Ascending order (1 first, etc).
            //$query->set('order', 'ASC');

            return;
            
        }

    }

}
add_filter( 'pre_get_posts', 'kbcl_testimonials_admin_query', 1 );