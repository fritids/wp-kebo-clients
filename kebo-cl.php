<?php
/*
 * Plugin Name: Kebo Clients
 * Plugin URI: http://kebopowered.com/plugins/kebo-clients/
 * Description: Easiest way to add great looking Clients List to your website.
 * Version: 0.5.0
 * Author: Kebo
 * Author URI: http://kebopowered.com
 * Text Domain: kbcl
 * Domain Path: languages
 */

// Block direct access
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Sorry, no direct access.' );
}

define( 'KBCL_VERSION', '0.5.0' );
define( 'KBCL_URL', plugin_dir_url(__FILE__) );
define( 'KBCL_PATH', plugin_dir_path(__FILE__) );

/*
 * Load textdomain early, as we need it for the PHP version check.
 */
function kbcl_load_textdomain() {
    
    load_plugin_textdomain( 'kbcl', false, KBSO_PATH . '/languages' );
    
}
add_filter( 'wp_loaded', 'kbcl_load_textdomain' );

/*
 * Check for the required version of PHP
 */
if ( version_compare( PHP_VERSION, '5.2', '<' ) ) {
    
    if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
        
        require_once ABSPATH . '/wp-admin/includes/plugin.php';
        deactivate_plugins(__FILE__);
        wp_die( __( 'Kebo Clients requires PHP 5.2 or higher, as does WordPress 3.2 and higher.', 'kbcl' ) );
        
    } else {
        
        return;
        
    }
    
}

/*
 * Load Relevant Internal Files
 */
function kbcl_plugin_setup() {

    /*
     * Include Options.
     */
    require_once( KBCL_PATH . 'inc/options.php' );
    
    /*
     * Include Custom Post Type.
     */
    require_once( KBCL_PATH . 'inc/custom-post-type.php' );
    
    /*
     * Include Meta Functions.
     */
    require_once( KBCL_PATH . 'inc/meta.php' );
    
    /*
     * Include Shortcode.
     */
    require_once( KBCL_PATH . 'inc/shortcode.php' );
    
    /*
     * Include Widget.
     */
    require_once( KBCL_PATH . 'inc/widget.php' );
    
    if ( is_admin() ) {
    
        /*
         * Include Admin Customisations.
         */
        require_once( KBCL_PATH . 'inc/admin.php' );
        
        /*
         * Include Menu Page.
         */
        require_once( KBCL_PATH . 'inc/menu.php' );
    
    } else {
        
        /*
         * Include Frontend Customisations.
         */
        require_once( KBCL_PATH . 'inc/front.php' );
        
        /*
         * Include Pagination.
         */
        require_once( KBCL_PATH . 'inc/pagination.php' );
        
    }
    
    /*
     * Include Misc Functions.
     */
    require_once( KBCL_PATH . 'inc/misc.php' );
    
}
add_action( 'plugins_loaded', 'kbcl_plugin_setup', 15 );


/**
 * Register plugin scripts and styles.
 */
function kbcl_register_files() {

    // Register Styles
    wp_register_style( 'kbcl-front', KBCL_URL . 'assets/css/front.css', array(), KBCL_VERSION, 'all' );
    wp_register_style( 'kbcl-admin', KBCL_URL . 'assets/css/admin.css', array(), KBCL_VERSION, 'all' );
        
    // Register Scripts
    wp_register_script( 'responsive-slides', KBCL_URL . 'assets/js/vendor/responsiveslides.min.js', array( 'jquery' ), KBCL_VERSION, false );
        
}
add_action( 'wp_enqueue_scripts', 'kbcl_register_files' );
add_action( 'admin_enqueue_scripts', 'kbcl_register_files' );
    
/**
 * Enqueue frontend plugin scripts and styles.
 */
function kbcl_enqueue_frontend() {
    
    global $post;
    
    if ( isset( $post->post_type ) && 'kbcl_clients' == $post->post_type ) {
        
        $options = kbcl_get_plugin_options();
        
        if ( 'none' != $options['clients_general_visual_style'] ) {
        
            wp_enqueue_style( 'kbcl-front' );
        
        }
        
    }
        
}
add_action( 'wp_enqueue_scripts', 'kbcl_enqueue_frontend' );
    
/**
 * Enqueue backend plugin scripts and styles.
 */
function kbcl_enqueue_backend( $hook_suffix ) {
        
    // Enqueue on all pages
    wp_enqueue_style( 'kbcl-admin' );
    
    // TODO: Only enqueue on required pages
        
}
add_action( 'admin_enqueue_scripts', 'kbcl_enqueue_backend' );

/**
 * Add a link to the plugin screen, to allow users to jump straight to the settings page.
 */
function kbcl_add_plugin_link( $links ) {
    
    $links[] = '<a href="' . admin_url( 'edit.php?post_type=kbcl_clients&page=kbcl-clients' ) . '">' . __( 'Settings', 'kbcl' ) . '</a>';
    return $links;
    
}
add_filter( 'plugin_action_links_kebo-cl/kebo-cl.php', 'kbcl_add_plugin_link' );

/**
 * Adds a WordPress Pointer to Kebo Clients options page.
 */
function kbcl_pointer_script_style() {

    // Assume pointer shouldn't be shown
    $enqueue_pointer_script_style = false;

    // Get array list of dismissed pointers for current user and convert it to array
    $dismissed_pointers = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    // Check if our pointer is not among dismissed ones
    if ( ! in_array( 'kbcl_install_pointer', $dismissed_pointers ) ) {
        
        $enqueue_pointer_script_style = true;

        // Add footer scripts using callback function
        add_action( 'admin_print_footer_scripts', 'kbcl_pointer_script_style' );
        
    }

    // Enqueue pointer CSS and JS files, if needed
    if ( $enqueue_pointer_script_style ) {
        
        wp_enqueue_style( 'wp-pointer' );
        wp_enqueue_script( 'wp-pointer' );
        
    }
    
}
add_action( 'admin_enqueue_scripts', 'kbcl_pointer_script_style' );