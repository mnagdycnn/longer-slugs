<?php
/**
 * Plugin Name: Longer Slugs
 * Description: Allows longer slugs (post_name) up to 3000 characters instead of the default 200 character limit.
 * Version: 1.0
 * Author: Your Name Here
 */

function longer_slugs_add_filter() {
    add_filter( 'sanitize_title', 'longer_slugs_sanitize_title', 1, 3 );
}

function longer_slugs_remove_filter() {
    remove_filter( 'sanitize_title', 'longer_slugs_sanitize_title', 1 );
}

function longer_slugs_sanitize_title( $title, $raw_title = '', $context = 'display' ) {
    if ( $context == 'save' ) {
        // Increase the maximum length of the slug to 3000 characters.
        $max_length = 3000;

        // Remove accents and other diacritics from the title.
        $title = remove_accents( $title );

        // Replace non-alphanumeric characters with hyphens.
        $title = preg_replace( '/[^a-zA-Z0-9\-]/', '-', $title );

        // Trim the title to the maximum length.
        $title = substr( $title, 0, $max_length );

        return $title;
    }

    return $title;
}

register_activation_hook( __FILE__, 'longer_slugs_activate' );
register_deactivation_hook( __FILE__, 'longer_slugs_deactivate' );

function longer_slugs_activate() {
    // Add the filter to allow longer slugs.
    longer_slugs_add_filter();
}

function longer_slugs_deactivate() {
    // Remove the filter that allows longer slugs.
    longer_slugs_remove_filter();
}
