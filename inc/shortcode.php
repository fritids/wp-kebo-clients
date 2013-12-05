<?php
/* 
 * Shortcode to display the Clients
 */

if ( ! defined( 'KBCL_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * Register Shortcode to output Clients
 */
function kbcl_clients_shortcode( $atts ) {
    
    /*
     * Prepare Args
     */
    extract( shortcode_atts( array(
        'foo' => 'no foo',
        'baz' => 'default baz'
    ), $atts ) );
    
    $output = '';
    
    return $output;
    
}
add_shortcode( 'kebo_clients', 'kbcl_clients_shortcode' );