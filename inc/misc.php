<?php
/* 
 * Kebo Testimonials - Misc/Helper Functions
 */

if ( ! defined( 'KBCL_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/**
 * Flush Rewrite Rules.
 * Use if slug changes or plugin is installed/uninstalled.
 */
function kbcl_flush_rewrite_rules() {
    
    if ( function_exists( 'flush_rewrite_rules' ) ) {
        
        flush_rewrite_rules();
        
    } else {
        
        global $pagenow, $wp_rewrite;

        $wp_rewrite->flush_rules();
    
    }
    
}
add_filter( 'admin_init', 'kbcl_flush_rewrite_rules' );
register_activation_hook( __FILE__, 'kbcl_flush_rewrite_rules' );
register_deactivation_hook( __FILE__, 'kbcl_flush_rewrite_rules' );

/*
 * Helper Function - Returns Page Title
 */
function kbcl_get_page_title() {
    
    $options = kbcl_get_plugin_options();
    
    $title = $options['clients_archive_page_title'];
    
    return esc_html( $title );
    
}

/*
 * Helper Function - Returns Page Content Before
 */
function kbcl_get_page_content_before() {
    
    $options = kbcl_get_plugin_options();
    
    $content = $options['clients_archive_page_content_before'];
    
    return wp_filter_post_kses( $content );
    
}