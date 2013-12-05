<?php
/* 
 * Kebo Clients - Post Meta
 */

if ( ! defined( 'KBCL_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/*
 * 
 */
function kbcl_clients_add_client_meta() {
    
    add_meta_box(
        'kbcl_clients_post_meta',
        __('Testimonial Details', 'kbcl'),
        'kbcl_clients_client_details_render',
        'kbcl_clients',
        'side',
        'core'
    );
    
}
add_action( 'admin_init', 'kbcl_clients_add_client_meta' );

function kbcl_clients_client_details_render() {
    
    $custom_post_meta = get_post_meta( get_the_ID(), 'kbcl_clients_post_meta', true );
    
    // Defaults if not set
    $name = ( isset( $custom_post_meta['client_name'] ) ) ? $custom_post_meta['client_name'] : '' ;
    $email = ( isset( $custom_post_meta['client_email'] ) ) ? $custom_post_meta['client_email'] : '' ;
    $url = ( isset( $custom_post_meta['client_url'] ) ) ? $custom_post_meta['client_url'] : '' ;
    ?>
    <div class="kpostmeta">
        
        <p>
            <label for="kbcl_client_name"><strong><?php echo __('Name: (optional)', 'kbcl'); ?></strong></label>
        </p>
        
        <p>
            <input type="text" id="kbcl_client_name" name="kbcl_client_name" value="<?php echo $name; ?>" />
        </p>
        
        <p>
            <label for="kbcl_client_email"><strong><?php echo __('Email: (optional)', 'kbcl'); ?></strong></label>
        </p>
        
        <p>
            <input type="text" id="kbcl_client_email" name="kbcl_client_email" value="<?php echo $email; ?>" />
        </p>
        
        <p>
            <label for="kbcl_client_url"><strong><?php echo __('URL: (optional)', 'kbcl'); ?></strong></label>
        </p>
        
        <p>
            <input type="text" id="kbcl_client_url" name="kbcl_client_url" value="<?php echo $url; ?>" />
        </p>
        
        <?php wp_nonce_field( 'kebo_clients_meta-site', 'kbcl-clients-meta' ); ?>
        
    </div>
    <?php
    
}

function kbcl_save_clients_client_details( $post_id ) {
    
    // Check Post Type
    if ( isset( $_POST['post_type'] ) ) {
        
        if ( 'kbcl_clients' == $_POST['post_type'] ) {

            // Avoid autosave overwriting meta.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
                return $post_id; 
            
            // Check for valid Nonse.
            $nonce = $_REQUEST['kbcl-clients-meta'];
            
            if ( wp_verify_nonce( $nonce, 'kebo_clients_meta-site' ) ) {

                $data = array();
                
                // Store data in post meta table if present in post data
                if ( isset( $_POST['kbcl_client_name'] ) && ! empty( $_POST['kbcl_client_name'] ) ) {
                    
                    $data['client_name'] = $_POST['kbcl_client_name'];
                    
                }
                
                // Store data in post meta table if present in post data
                if ( isset( $_POST['kbcl_client_email'] ) && ! empty( $_POST['kbcl_client_email'] ) && is_email( $_POST['kbcl_client_email'] ) ) {
                    
                    $data['client_email'] = $_POST['kbcl_client_email'];
                    
                }
                
                // Store data in post meta table if present in post data
                if ( isset( $_POST['kbcl_client_url'] ) && ! empty( $_POST['kbcl_client_url'] ) && filter_var( $_POST['kbcl_client_url'], FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED ) ) {
                    
                    $data['client_url'] = $_POST['kbcl_client_url'];
                    
                }
                
                // Store data in post meta table if present in post data
                if ( isset( $_POST['kbcl_client_rating'] ) && ! empty( $_POST['kbcl_client_rating'] ) ) {
                    
                    $data['client_rating'] = absint( $_POST['kbcl_client_rating'] );
                    
                }
                
                update_post_meta( $post_id, 'kbcl_clients_post_meta', $data );

            }
            
        }
        
    }
    
}
add_action( 'save_post', 'kbcl_save_clients_client_details', 10, 2 );