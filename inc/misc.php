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
    
    global $pagenow, $wp_rewrite;

    if ( 'options-general.php' != $pagenow ) {
        return;
    }
    
    /*
     * If the plugin settings have been updated flush rewrite rules
     */
    if ( isset( $_GET['page'] ) && ( 'kbcl-testimonials' == $_GET['page'] ) && isset( $_GET['settings-updated'] ) ) {
        $wp_rewrite->flush_rules();
    }
    
}
add_filter( 'admin_init', 'kbcl_flush_rewrite_rules' );

/*
 * Helper Function - Returns Page Title
 */
function kbcl_get_page_title() {
    
    $options = kbcl_get_plugin_options();
    
    $title = $options['testimonials_archive_page_title'];
    
    return esc_html( $title );
    
}

/*
 * Helper Function - Returns Reviewer Name
 */
function kbcl_get_review_name() {
    
    global $post;
    
    $kbcl_custom_meta = get_post_meta( $post->ID, 'kbcl_testimonials_post_meta', true );
    
    $name = ( isset( $kbcl_custom_meta['reviewer_name'] ) ) ? $kbcl_custom_meta['reviewer_name'] : '' ;
    
    return esc_html( $name );
    
}