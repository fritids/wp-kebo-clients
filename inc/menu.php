<?php
/* 
 * Settings Menu Page
 */

if ( ! defined( 'KBFR_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * Register plugin settings page inside the Settings menu.
 */
function kbfr_friends_settings_page() {

    add_submenu_page(
            'edit.php?post_type=kbfr_friends', // Parent
            __('Settings', 'kbfr'), // Page Title
            __('Settings', 'kbfr'), // Menu Title
            'manage_options', // Capability
            'kbfr-friends', // Menu Slug
            'kbfr_friends_settings_page_render' // Render Function
    );

}
add_action('admin_menu', 'kbfr_friends_settings_page');


/**
 * Renders the Twitter Feed Options page.
 */
function kbfr_friends_settings_page_render() {
    
    ?>
    <div class="wrap">
        
        <?php screen_icon('options-general'); ?>
        <h2><?php _e('Friends - Settings', 'kbfr'); ?></h2>
        <?php settings_errors( 'kbfr-friends' ); ?>

        <form method="post" action="options.php">
            <?php
            settings_fields('kbfr_options');
            do_settings_sections('kbfr-friends');
            submit_button();
            ?>
        </form>
        
    </div>

    <?php
    
}