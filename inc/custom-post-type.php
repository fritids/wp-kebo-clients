<?php
/*
 * Registers the Clients Custom Post Type
 */

if ( ! defined( 'KBFR_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * Register the Clients CPT (Custom Post Type)
 */
function kbfr_create_friends_cpt() {
    
    $options = kbfr_get_plugin_options();
    
    /*
     * Set the Labels to be used for the CPT
     */
    $labels = array(
        'name' => __('Friends', 'kbfr'),
        'menu_name' => __('Friends', 'kbfr'),
        'singular_name' => __('Friend', 'kbfr'),
        'all_items' => __('All Friends', 'kbfr'),
        'add_new' => _x('Add New', 'kbfr'),
        'add_new_item' => __('Add New Friend', 'kbfr'),
        'edit' => __('Edit', 'kbfr'),
        'edit_item' => __('Edit Friend', 'kbfr'),
        'new_item' => __('New Friend', 'kbfr'),
        'view' => __('View', 'kbfr'),
        'view_item' => __('View Friend', 'kbfr'),
        'search_items' => __('Search Friends', 'kbfr'),
        'not_found' => __('No Friends Found', 'kbfr'),
        'not_found_in_trash' => __('No Friends Found in Trash', 'kbfr'),
        'parent' => __('Parent Friend', 'kbfr'),
        'parent_item_colon' => __('Friend:', 'kbfr')
    );
    
    /*
     * Prepare the args used to register the CPT
     */
    $args = array(
        'labels' => $labels,
        'description' => __('Friends', 'kbfr'),
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => false,
        'show_in_menu' => true, // Visible as Top Level Menu
        'show_in_admin_bar',
        'menu_position' => 99, // 99+ for bottom of list
        'capability_type' => 'post',
        'hierarchical' => false,
        // Can Contain 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions'
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies' => array(''),
        'menu_icon' => '',
        'rewrite' => array(
            'slug' => $options['friends_archive_page_slug'], // TODO: change to dynamic $slug
            'feeds' => true, // rss feeds
            'pages' => true, // prepares for pagination
            'with_front' => false // use url prefix like /blog etc.
        ),
        'has_archive' => true,
        'can_export' => true // can be exported
    );

    // Register the CPT
    register_post_type( 'kbfr_friends', $args );
    
}
add_action( 'init', 'kbfr_create_friends_cpt', 1 );

/*
 * Friends CPT Meta
 */
function kbfr_friends_add_friend_meta() {
    
    add_meta_box(
        'kbfr_friends_post_meta',
        __('Friend Details', 'kbfr'),
        'kbfr_friends_details_render',
        'kbfr_friends',
        'side',
        'core'
    );
    
}
add_action( 'admin_init', 'kbfr_friends_add_friend_meta' );

function kbfr_friends_details_render() {
    
    $kbfr_custom_meta = get_post_meta( get_the_ID(), '_kbfr_friends_meta_details', true );
    
    // Defaults if not set
    $url = ( isset( $kbte_custom_meta['friend_url'] ) ) ? $kbte_custom_meta['friend_url'] : '' ;
    ?>
    <div class="kpostmeta">
        
        <p>
            <label for="kbfr_friend_url"><strong><?php echo __('URL: (optional)', 'kbfr'); ?></strong></label>
        </p>
        
        <p>
            <input type="text" id="kbfr_friend_url" name="kbfr_friend_url" value="<?php echo $url; ?>" />
        </p>
        
        <?php wp_nonce_field( 'kebo_friends_meta-site', 'kbfr-friends-meta' ); ?>
        
    </div>
    <?php
    
}

function kbfr_save_friends_friend_details( $post_id ) {
    
    // Check Post Type
    if ( isset( $_POST['post_type'] ) && isset( $_REQUEST['kbfr-friends-meta'] ) ) {
        
        if ( 'kbfr_friends' == $_POST['post_type'] ) {

            // Avoid autosave overwriting meta.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
                return $post_id; 
            
            // Check for valid Nonse.
            $nonce = $_REQUEST['kbfr-friends-meta'];
            
            if ( wp_verify_nonce( $nonce, 'kebo_friends_meta-site' ) ) {

                $data = array();
                
                // Store data in post meta table if present in post data
                if ( isset( $_POST['kbfr_friend_url'] ) && ! empty( $_POST['kbfr_friend_url'] ) && filter_var( $_POST['kbfr_friend_url'], FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED ) ) {
                    
                    $data['friend_url'] = $_POST['kbfr_friend_url'];
                    
                }
                
                // Update Combined Details
                update_post_meta( $post_id, '_kbfr_friends_meta_details', $data );

            }
            
        }
        
    }
    
}
add_action( 'save_post', 'kbfr_save_friends_friend_details', 10, 2 );