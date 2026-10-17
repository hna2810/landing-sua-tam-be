<?php
/**
 * Helper functions
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get ACF field value safely with fallback
 *
 * @param string $selector Field name.
 * @param mixed  $post_id  Post ID or 'option'.
 * @param mixed  $default  Default fallback value.
 * @return mixed
 */
function lx_get_field($selector, $post_id = 'option', $default = '') {
    if (function_exists('get_field')) {
        $val = get_field($selector, $post_id);
        if ($val !== null && $val !== '' && $val !== false) {
            return $val;
        }
    }
    return $default;
}

/**
 * Get image URL from ACF field safely
 *
 * @param string $selector Field name.
 * @param string $default  Fallback URL.
 * @param mixed  $post_id  Post ID or 'option'.
 * @return string
 */
function lx_get_image_url($selector, $default = '', $post_id = 'option') {
    $img = lx_get_field($selector, $post_id, null);
    if (!$img) {
        return $default;
    }
    if (is_array($img) && isset($img['url'])) {
        return $img['url'];
    }
    if (is_numeric($img)) {
        $url = wp_get_attachment_image_url((int)$img, 'full');
        return $url ? $url : $default;
    }
    if (is_string($img)) {
        return $img;
    }
    return $default;
}
