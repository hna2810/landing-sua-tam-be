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
    $val = null;
    if (function_exists('get_field')) {
        $val = get_field($selector, $post_id);
    }
    if ($val === null || $val === false || $val === '') {
        $opt_key = ($post_id === 'option') ? 'options_' . $selector : $selector;
        $db_raw = get_option($opt_key, null);
        if ($db_raw === null && $post_id === 'option') {
            $db_raw = get_option($selector, null);
        }
        if ($db_raw !== null && $db_raw !== '' && $db_raw !== false) {
            $val = maybe_unserialize($db_raw);
        }
    }

    if ($val !== null && $val !== false && $val !== '' && (!is_array($val) || !empty($val))) {
        return $val;
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
    $img = lx_get_field($selector, $post_id, '');
    if (empty($img)) {
        return $default;
    }
    if (is_array($img) && isset($img['url'])) {
        return !empty($img['url']) ? $img['url'] : $default;
    }
    if (is_numeric($img)) {
        $url = wp_get_attachment_image_url((int)$img, 'full');
        return $url ? $url : $default;
    }
    if (is_string($img) && trim($img) !== '') {
        return $img;
    }
    return $default;
}
