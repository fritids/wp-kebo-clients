<?php
/* 
 * Customisations to the Admin Clients Listing.
 */

if ( ! defined( 'KBCL_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/**
 * Edit the Admin List Titles for Clients.
 */
function kbcl_clients_admin_columns( $columns ) {
    
    // Remove All Columns
    unset( $columns );
    
    // Add Required Columns
    $columns['cb'] = '<input type="checkbox" />';
    $columns['title'] = __( 'Client Name', 'kbcl' );
    $columns['date'] = __( 'Date', 'kbcl' );
    
    return $columns;
    
}	
add_filter( 'manage_edit-kbcl_clients_columns', 'kbcl_clients_admin_columns' );

/*
 * Adds which columns should be sortable.
 */
function kbcl_clients_sortable_admin_columns( $columns ) {
    
    // Add Required Columns
    $columns['title'] = 'title';
    $columns['date'] = 'date';
    
    return $columns;
    
}	
add_filter( 'manage_edit-kbcl_clients_sortable_columns', 'kbcl_clients_sortable_admin_columns' );

/*
 * Adds data to the custom admin columns.
 */
function kbcl_clients_admin_column_values( $column, $post_id ) {
    
    global $post;
    
    switch ( $column ) {

        // Add Custom Column Data

    }
    
}
add_action( 'manage_kbcl_clients_posts_custom_column' , 'kbcl_clients_admin_column_values', 10, 2 );

/*
 * Adds custom Orderby data
 */
function kbcl_clients_admin_column_orderby( $vars ) {
    
    if ( ! is_admin() ) {
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
add_filter( 'request', 'kbcl_clients_admin_column_orderby' );

/**
 * Custom Post Type Archive Pagination Limits.
 */
function kbcl_clients_admin_query( $query ) {

    // Clients Admin Query
    if ( is_admin() && $query->is_main_query() ) {

        // Set Clients per Page as per user option
        if ( isset( $query->query_vars['post_type'] ) && ( 'kbcl_clients' == $query->query_vars['post_type'] ) ) {

            // Orders by the Menu Order attribute
            //$query->set('orderby', 'menu_order');
            // Ascending order (1 first, etc).
            //$query->set('order', 'ASC');

            return;
            
        }

    }

}
add_filter( 'pre_get_posts', 'kbcl_clients_admin_query', 1 );