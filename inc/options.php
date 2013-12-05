<?php
/* 
 * Options API
 */

if ( ! defined( 'KBCL_VERSION' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/**
 * Register the form setting for our kebo_options array.
 */
function kbcl_plugin_options_init() {
    
    // Get Options
    $options = kbcl_get_plugin_options();
    
    register_setting(
            'kbcl_options', // Options group
            'kbcl_plugin_options', // Database option
            'kbcl_plugin_options_validate' // The sanitization callback,
    );

    /**
     * Section - General
     */
    add_settings_section(
            'kbcl_testimonials_general', // Unique identifier for the settings section
            __('General', 'kbcl'), // Section title
            '__return_false', // Section callback (we don't want anything)
            'kbcl-testimonials' // Menu slug
    );
    
    /**
     * General - Visual Style
     */
    add_settings_field(
            'testimonials_general_visual_style', // Unique identifier for the field for this section
            __('Visual Style', 'kbcl'), // Setting field label
            'kbcl_options_render_visual_style_dropdown', // Function that renders the settings field
            'kbcl-testimonials', // Menu slug
            'kbcl_testimonials_general', // Settings section.
            array( // Args to pass to render function
                'name' => 'testimonials_general_visual_style',
                'help_text' => __('Set to none to prevent the default stylesheet being enqueued.', 'kbcl')
            ) 
    );
    
    /**
     * Section - Archive Options
     */
    add_settings_section(
            'kbcl_testimonials_archive', // Unique identifier for the settings section
            __('Archive Page', 'kbcl'), // Section title
            '__return_false', // Section callback (we don't want anything)
            'kbcl-testimonials' // Menu slug
    );
    
    /**
     * General - Page Title
     */
    add_settings_field(
            'testimonials_archive_page_title', // Unique identifier for the field for this section
            __('Page Title', 'kbcl'), // Setting field label
            'kbcl_options_render_text_input', // Function that renders the settings field
            'kbcl-testimonials', // Menu slug
            'kbcl_testimonials_archive', // Settings section.
            array( // Args to pass to render function
                'name' => 'testimonials_archive_page_title',
                'help_text' => __('Title of Testimonials page.', 'kbcl')
            )
    );
    
    /**
     * General - Page Slug
     */
    add_settings_field(
            'testimonials_archive_page_slug', // Unique identifier for the field for this section
            __('Page Slug', 'kbcl'), // Setting field label
            'kbcl_options_render_text_input', // Function that renders the settings field
            'kbcl-testimonials', // Menu slug
            'kbcl_testimonials_archive', // Settings section.
            array( // Args to pass to render function
                'name' => 'testimonials_archive_page_slug',
                'help_text' => __('Slug of Testimonials page.', 'kbcl')
            )
    );
    
    /**
     * General - Posts Per Page
     */
    add_settings_field(
            'testimonials_archive_posts_per_page', // Unique identifier for the field for this section
            __('Testimonials Per Page', 'kbcl'), // Setting field label
            'kbcl_options_render_text_input', // Function that renders the settings field
            'kbcl-testimonials', // Menu slug
            'kbcl_testimonials_archive', // Settings section.
            array( // Args to pass to render function
                'name' => 'testimonials_archive_posts_per_page',
                'label_text' => __('Must be between 1-50.', 'kbcl'),
                'help_text' => __('Number of Testimonials to show per page. Set to -1 to display all on a single page.', 'kbcl')
            )
    );
    
    /**
     * General - Content Before
     */
    add_settings_field(
            'testimonials_archive_page_content_before', // Unique identifier for the field for this section
            __('Content Before Testimonials', 'kbcl'), // Setting field label
            'kbcl_options_render_textarea', // Function that renders the settings field
            'kbcl-testimonials', // Menu slug
            'kbcl_testimonials_archive', // Settings section.
            array( // Args to pass to render function
                'name' => 'testimonials_archive_page_content_before',
                'help_text' => __('Content to display before Testimonials', 'kbcl')
            )
    );

}
add_action( 'admin_init', 'kbcl_plugin_options_init' );

/**
 * Change the capability required to save the 'kbcl_options' options group.
 */
function kbcl_plugin_option_capability( $capability ) {
    
    return 'manage_options';
    
}
add_filter( 'option_page_capability_kbcl_options', 'kbcl_plugin_option_capability' );

/**
 * Returns the options array for kebo.
 */
function kbcl_get_plugin_options() {
    
    $saved = (array) get_option( 'kbcl_plugin_options' );
    
    $defaults = array(
        // Section - Testimonials - General
        'testimonials_general_visual_style' => 'default',
        'testimonials_archive_page_title' => __('Testimonials', 'kbcl'),
        'testimonials_archive_page_slug' => __('testimonials', 'kbcl'),
        'testimonials_archive_posts_per_page' => 10,
        'testimonials_archive_page_content_before' => null
    );

    $defaults = apply_filters( 'kbcl_get_plugin_options', $defaults );

    $options = wp_parse_args( $saved, $defaults );
    $options = array_intersect_key( $options, $defaults );

    return $options;
    
}

/**
 * Renders the text input setting field.
 */
function kbcl_options_render_text_input( $args ) {
    
    $options = kbcl_get_plugin_options();
    
    $name = esc_attr( $args['name'] );
    
    $label_text = ( $args['label_text'] ) ? esc_attr( $args['label_text'] ) : '' ;
    
    $help_text = ( $args['help_text'] ) ? esc_html( $args['help_text'] ) : null;
        
    ?>
    <label class="description" for="<?php echo $name; ?>">
        <input type="text" name="kbcl_plugin_options[<?php echo $name; ?>]" id="<?php echo $name; ?>" value="<?php echo esc_attr( $options[ $name ] ); ?>" />
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
function kbcl_options_radio_buttons_boolean() {
    
    $radio_buttons = array(
        'yes' => array(
            'value' => 'yes',
            'label' => __('On', 'kbso')
        ),
        'no' => array(
            'value' => 'no',
            'label' => __('Off', 'kbso')
        ),
    );

    return apply_filters( 'kbcl_options_radio_buttons_boolean', $radio_buttons );
    
}

/**
 * Returns an array of select inputs for the Visual Style dropdown.
 */
function kbcl_options_visual_style_dropdown() {
    
    $dropdown = array(
        'default' => array(
            'value' => 'default',
            'label' => __('Default', 'kbcl')
        ),
        'none' => array(
            'value' => 'none',
            'label' => __('None', 'kbcl')
        ),
    );

    return apply_filters( 'kbcl_options_visual_style_dropdown', $dropdown );
    
}

/**
 * Renders the Theme dropdown.
 */
function kbcl_options_render_visual_style_dropdown( $args ) {
    
    $options = kbcl_get_plugin_options();
    
    $name = esc_attr( $args['name'] );
    
    ?>
    <select id="<?php echo $name; ?>[<?php echo $dropdown['value']; ?>]" name="kbcl_plugin_options[<?php echo $name; ?>]">
    <?php
    foreach ( kbcl_options_visual_style_dropdown() as $dropdown ) {
        
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
function kbcl_options_render_textarea( $args ) {
    
    $options = kbcl_get_plugin_options();
    
    $name = esc_attr( $args['name'] );
    
    $help_text = ( $args['help_text'] ) ? esc_html( $args['help_text'] ) : null;
    
    $args = array(
        'wpautop' => true, // Use of wpautop for this data.
        'media_buttons' => false, // Show/Hide the Media Button
        'textarea_name' => 'kbcl_plugin_options[' . $name . ']', // name attribute of the textarea
        'tabindex' => 'none', // Tab Index for this Element 
    );
    ?>
        
    <div style="max-width: 800px;">
        <?php wp_editor( esc_textarea( $options[ $name ] ), 'kbcl_plugin_options[' . $name . ']', $args ); ?>
    </div>
        
    <?php if ( $help_text ) { ?>
        <span class="howto"><?php echo esc_html( $help_text ); ?></span>
    <?php } ?>

    <?php
        
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 */
function kbcl_plugin_options_validate( $input ) {
    
    $output = array();
    
    // General Section
    if ( isset( $input['testimonials_general_visual_style'] ) && array_key_exists( $input['testimonials_general_visual_style'], kbcl_options_visual_style_dropdown() ) ) {
        $output['testimonials_general_visual_style'] = $input['testimonials_general_visual_style'];
    }
    
    // Archive Section
    if ( isset( $input['testimonials_archive_page_title'] ) && ! empty( $input['testimonials_archive_page_title'] ) ) {
	$output['testimonials_archive_page_title'] = sanitize_title( $input['testimonials_archive_page_title'] );
    }
    
    if ( isset( $input['testimonials_archive_page_slug'] ) && ! empty( $input['testimonials_archive_page_slug'] ) ) {
	$output['testimonials_archive_page_slug'] = wp_unique_post_slug( $input['testimonials_archive_page_slug'] );
    }
    
    if ( isset( $input['testimonials_archive_posts_per_page'] ) && is_numeric( $input['testimonials_archive_posts_per_page'] ) ) {

        // If 'count' is above 50 reset to 50.
        if ( 50 <= intval( $input['testimonials_archive_posts_per_page'] ) ) {
            $input['testimonials_archive_posts_per_page'] = 50;
        }

        // If 'count' is below 1 reset to 1.
        if ( 1 >= intval( $input['testimonials_archive_posts_per_page'] ) && -1 != intval( $input['testimonials_archive_posts_per_page'] ) ) {
            $input['testimonials_archive_posts_per_page'] = 10;
        }

        // Update 'count' using intval to remove decimals.
        $output['testimonials_archive_posts_per_page'] = intval( $input['testimonials_archive_posts_per_page'] );
        
    }
    
    if ( isset( $input['testimonials_archive_page_content_before'] ) && ! empty( $input['testimonials_archive_page_content_before'] ) ) {
	$output['testimonials_archive_page_content_before'] = wp_filter_post_kses( $input['testimonials_archive_page_content_before'] );
    }
    
    $options = kbcl_get_plugin_options();
    
    // Combine Inputs with currently Saved data, for multiple option page compability
    $options = wp_parse_args( $input, $options );
    
    return apply_filters( 'kbcl_plugin_options_validate', $options, $output );
    
}