<?php
/**
 * Plugin Name: Auto Image Sizes
 * Description: Automatically adjusts the `sizes` attribute of lazy-loaded images in WordPress for better responsiveness.
 * Version: 1.0
 * Author: Shubham Sawarkar
 * Author URI: https://github.com/Shubham2D
 * License: MIT
 */

if (!defined('ABSPATH')) exit; // Prevent direct access

/**
 * Modify `sizes` attribute in WordPress image attributes
 */
add_filter( 'wp_get_attachment_image_attributes', function( $attr ) {
    if ( ! isset( $attr['loading'] ) || 'lazy' !== $attr['loading'] || ! isset( $attr['sizes'] ) ) {
        return $attr;
    }
    
    // Skip if 'auto' is already in sizes.
    if ( false !== strpos( $attr['sizes'], 'auto,' ) ) {
        return $attr;
    }

    // Prepend 'auto,' to the 'sizes' attribute.
    $attr['sizes'] = 'auto, ' . $attr['sizes'];

    return $attr;
});

/**
 * Modify `sizes` attribute in content image tags
 */
add_filter( 'wp_content_img_tag', function( $html ) {
    if (false === strpos($html, 'loading="lazy"') || (false === strpos($html, 'sizes="') || false !== strpos($html, 'sizes="auto,'))) {
        return $html;
    }

    // Modify the 'sizes' attribute in the HTML <img> tag
    $html = str_replace( 'sizes="', 'sizes="auto, ', $html );

    return $html;
});