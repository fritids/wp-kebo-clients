<?php
/* 
 * Options API
 */

if ( ! defined( 'KBFR_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/**
 * Register the form setting for our kebo_options array.
 */
function kbfr_plugin_options_init() {
    
    // Get Options
    $options = kbfr_get_plugin_options();
    
    register_setting(
            'kbfr_options', // Options group
            'kbfr_plugin_options', // Database option
            'kbfr_plugin_options_validate' // The sanitization callback,
    );

    /**
     * Section - General
     */
    add_settings_section(
            'kbfr_friends_general', // Unique identifier for the settings section
            __('General', 'kbfr'), // Section title
            '__return_false', // Section callback (we don't want anything)
            'kbfr-friends' // Menu slug
    );
    
    /**
     * General - Visual Style
     */
    add_settings_field(
            'friends_general_visual_style', // Unique identifier for the field for this section
            __('Visual Style', 'kbfr'), // Setting field label
            'kbfr_options_render_visual_style_dropdown', // Function that renders the settings field
            'kbfr-friends', // Menu slug
            'kbfr_friends_general', // Settings section.
            array( // Args to pass to render function
                'name' => 'friends_general_visual_style',
                'help_text' => __('Set to none to prevent the default stylesheet being enqueued.', 'kbfr')
            ) 
    );
    
    /**
     * Section - Archive Options
     */
    add_settings_section(
            'kbfr_friends_archive', // Unique identifier for the settings section
            __('Archive Page', 'kbfr'), // Section title
            '__return_false', // Section callback (we don't want anything)
            'kbfr-friends' // Menu slug
    );
    
    /**
     * General - Page Title
     */
    add_settings_field(
            'friends_archive_page_title', // Unique identifier for the field for this section
            __('Page Title', 'kbfr'), // Setting field label
            'kbfr_options_render_text_input', // Function that renders the settings field
            'kbfr-friends', // Menu slug
            'kbfr_friends_archive', // Settings section.
            array( // Args to pass to render function
                'name' => 'friends_archive_page_title',
                'help_text' => __('Title of Clients page.', 'kbfr')
            )
    );
    
    /**
     * General - Page Slug
     */
    add_settings_field(
            'friends_archive_page_slug', // Unique identifier for the field for this section
            __('Page Slug', 'kbfr'), // Setting field label
            'kbfr_options_render_text_input', // Function that renders the settings field
            'kbfr-friends', // Menu slug
            'kbfr_friends_archive', // Settings section.
            array( // Args to pass to render function
                'name' => 'friends_archive_page_slug',
                'help_text' => __('Slug of Clients page.', 'kbfr')
            )
    );
    
    /**
     * General - Posts Per Page
     */
    add_settings_field(
            'friends_archive_posts_per_page', // Unique identifier for the field for this section
            __('Friends Per Page', 'kbfr'), // Setting field label
            'kbfr_options_render_text_input', // Function that renders the settings field
            'kbfr-friends', // Menu slug
            'kbfr_friends_archive', // Settings section.
            array( // Args to pass to render function
                'name' => 'friends_archive_posts_per_page',
                'label_text' => __('Must be between 1-50.', 'kbfr'),
                'help_text' => __('Number of Clients to show per page. Set to -1 to display all on a single page.', 'kbfr')
            )
    );
    
    /**
     * General - Content Before
     */
    add_settings_field(
        'friends_archive_page_content_before', // Unique identifier for the field for this section
        __('Content Before Friends', 'kbfr'), // Setting field label
        'kbfr_options_render_textarea', // Function that renders the settings field
        'kbfr-friends', // Menu slug
        'kbfr_friends_archive', // Settings section.
        array( // Args to pass to render function
            'name' => 'friends_archive_page_content_before',
            'help_text' => __('Content to display before Friends.', 'kbfr')
        )
    );

}
add_action( 'admin_init', 'kbfr_plugin_options_init' );

/**
 * Change the capability required to save the 'kbcl_options' options group.
 */
function kbfr_plugin_option_capability( $capability ) {
    
    return 'manage_options';
    
}
add_filter( 'option_page_capability_kbfr_options', 'kbfr_plugin_option_capability' );

/**
 * Returns the options array for kebo.
 */
function kbfr_get_plugin_options() {
    
    $saved = (array) get_option( 'kbfr_plugin_options' );
    
    $defaults = array(
        
        // Section - Clients - General
        'friends_general_visual_style' => 'default',
        
        // Section - Archive - General
        'friends_archive_page_title' => __('Friends', 'kbfr'),
        'friends_archive_page_slug' => __('friends', 'kbfr'),
        'friends_archive_posts_per_page' => 10,
        'friends_archive_page_content_before' => null
        
    );

    $defaults = apply_filters( 'kbfr_get_plugin_options', $defaults );

    $options = wp_parse_args( $saved, $defaults );
    $options = array_intersect_key( $options, $defaults );

    return $options;
    
}

/**
 * Renders the text input setting field.
 */
function kbfr_options_render_text_input( $args ) {
    
    $options = kbfr_get_plugin_options();
    
    $name = esc_attr( $args['name'] );
    
    $label_text = ( $args['label_text'] ) ? esc_attr( $args['label_text'] ) : '' ;
    
    $help_text = ( $args['help_text'] ) ? esc_html( $args['help_text'] ) : null;
        
    ?>
    <label class="description" for="<?php echo $name; ?>">
        <input type="text" name="kbfr_plugin_options[<?php echo $name; ?>]" id="<?php echo $name; ?>" value="<?php echo esc_attr( $options[ $name ] ); ?>" />
        <?php echo $label_text; ?>
    </label>
    <?php if ( $help_text ) { ?>
        <span class="howto"><?php echo esc_html( $help_text ); ?></span>
    <?php } ?>
    <?php
        
}

/**
 * Returns an array of radio options for Yes/No.
 */
function kbfr_options_radio_buttons_boolean() {
    
    $radio_buttons = array(
        'yes' => array(
            'value' => 'yes',
            'label' => __('On', 'kbfr')
        ),
        'no' => array(
            'value' => 'no',
            'label' => __('Off', 'kbfr')
        ),
    );

    return apply_filters( 'kbfr_options_radio_buttons_boolean', $radio_buttons );
    
}

/**
 * Returns an array of select inputs for the Visual Style dropdown.
 */
function kbfr_options_visual_style_dropdown() {
    
    $dropdown = array(
        'default' => array(
            'value' => 'default',
            'label' => __('Default', 'kbfr')
        ),
        'none' => array(
            'value' => 'none',
            'label' => __('None', 'kbfr')
        ),
    );

    return apply_filters( 'kbfr_options_visual_style_dropdown', $dropdown );
    
}

/**
 * Renders the Theme dropdown.
 */
function kbfr_options_render_visual_style_dropdown( $args ) {
    
    $options = kbfr_get_plugin_options();
    
    $name = esc_attr( $args['name'] );
    
    ?>
    <select id="<?php echo $name; ?>[<?php echo $dropdown['value']; ?>]" name="kbfr_plugin_options[<?php echo $name; ?>]">
    <?php
    foreach ( kbfr_options_visual_style_dropdown() as $dropdown ) {
        
        ?>
        <option value="<?php echo esc_attr( $dropdown['value'] ); ?>" <?php selected( $dropdown['value'], $options[ $name ] ); ?>>
            <?php echo esc_html( $dropdown['label'] ); ?>
        </option>
        <?php
        
    }
    ?>
    </select>    
    <?php
        
}

/**
 * Renders a textarea field.
 */
function kbfr_options_render_textarea( $args ) {
    
    $options = kbfr_get_plugin_options();
    
    $name = esc_attr( $args['name'] );
    
    $help_text = ( $args['help_text'] ) ? esc_html( $args['help_text'] ) : null;
    
    $args = array(
        'wpautop' => true, // Use of wpautop for this data.
        'media_buttons' => false, // Show/Hide the Media Button
        'textarea_name' => 'kbfr_plugin_options[' . $name . ']', // name attribute of the textarea
        'tabindex' => 'none', // Tab Index for this Element 
    );
    ?>
        
    <div style="max-width: 800px;">
        <?php wp_editor( esc_textarea( $options[ $name ] ), 'kbfr_plugin_options[' . $name . ']', $args ); ?>
    </div>
        
    <?php if ( $help_text ) { ?>
        <span class="howto"><?php echo esc_html( $help_text ); ?></span>
    <?php } ?>

    <?php
        
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 */
function kbfr_plugin_options_validate( $input ) {
    
    $options = kbfr_get_plugin_options();
    
    $output = array();
    
    // General Section
    if ( isset( $input['friends_general_visual_style'] ) && array_key_exists( $input['friends_general_visual_style'], kbfr_options_visual_style_dropdown() ) ) {
        $output['friends_general_visual_style'] = $input['friends_general_visual_style'];
    }
    
    // Archive Section
    if ( isset( $input['friends_archive_page_title'] ) && ! empty( $input['friends_archive_page_title'] ) ) {
	$output['friends_archive_page_title'] = sanitize_title( $input['friends_archive_page_title'] );
    }
    
    if ( isset( $input['friends_archive_page_slug'] ) && ! empty( $input['friends_archive_page_slug'] ) ) {
	$output['friends_archive_page_slug'] = wp_unique_post_slug( $input['friends_archive_page_slug'] );
    }
    
    if ( isset( $input['friends_archive_posts_per_page'] ) && is_numeric( $input['friends_archive_posts_per_page'] ) ) {

        // If 'count' is above 50 reset to 50.
        if ( 50 <= intval( $input['friends_archive_posts_per_page'] ) ) {
            $input['friends_archive_posts_per_page'] = 50;
        }

        // If 'count' is below 1 reset to 1.
        if ( 1 >= intval( $input['friends_archive_posts_per_page'] ) && -1 != intval( $input['friends_archive_posts_per_page'] ) ) {
            $input['friends_archive_posts_per_page'] = 10;
        }

        // Update 'count' using intval to remove decimals.
        $output['friends_archive_posts_per_page'] = intval( $input['friends_archive_posts_per_page'] );
        
    }
    
    if ( isset( $input['friends_archive_page_content_before'] ) && ! empty( $input['friends_archive_page_content_before'] ) ) {
	$output['friends_archive_page_content_before'] = wp_filter_post_kses( $input['friends_archive_page_content_before'] );
    }
    
    // Flush Rules to ensure slug is correct
    kbfr_flush_rewrite_rules();
    
    // Combine Inputs with currently Saved data, for multiple option page compability
    $options = wp_parse_args( $input, $options );
    
    return apply_filters( 'kbfr_plugin_options_validate', $options, $output );
    
}