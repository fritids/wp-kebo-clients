<?php
/* 
 * Settings Menu Page
 */

if ( ! defined( 'KBCL_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * Register plugin settings page inside the Settings menu.
 */
function kbcl_clients_settings_page() {

    add_submenu_page(
            'edit.php?post_type=kbcl_clients', // Parent
            __('Settings', 'kbcl'), // Page Title
            __('Settings', 'kbcl'), // Menu Title
            'manage_options', // Capability
            'kbcl-clients', // Menu Slug
            'kbcl_clients_settings_page_render' // Render Function
    );

}
add_action('admin_menu', 'kbcl_clients_settings_page');


/**
 * Renders the Twitter Feed Options page.
 */
function kbcl_clients_settings_page_render() {
    
    ?>
    <div class="wrap">
        
        <?php screen_icon('options-general'); ?>
        <h2><?php _e('Clients - Settings', 'kbcl'); ?></h2>
        <?php settings_errors( 'kbcl-clients' ); ?>

        <form method="post" action="options.php">
            <?php
            settings_fields('kbcl_options');
            do_settings_sections('kbcl-clients');
            submit_button();
            ?>
        </form>
        
    </div>

    <?php
    
}