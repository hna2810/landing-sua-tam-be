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
    if ($post_id === 'option') {
        $opt_key = 'options_' . $selector;
        $db_raw = get_option($opt_key, '__NOT_SET__');
        if ($db_raw === '__NOT_SET__') {
            $db_raw = get_option($selector, '__NOT_SET__');
        }

        // Nếu option CHƯA TỪNG tồn tại trong database -> trả về giá trị mặc định ban đầu
        if ($db_raw === '__NOT_SET__') {
            return $default;
        }

        // Nếu option ĐÃ CÓ trong database (người dùng đã lưu, kể cả khi xóa rỗng "")
        if (function_exists('get_field')) {
            $val = get_field($selector, 'option');
            if ($val !== null) {
                return $val;
            }
        }

        return maybe_unserialize($db_raw);
    }

    if (function_exists('get_field')) {
        $val = get_field($selector, $post_id);
        if ($val !== null) {
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
    $img = lx_get_field($selector, $post_id, '__NOT_SET__');
    if ($img === '__NOT_SET__') {
        return $default;
    }
    if (empty($img)) {
        return '';
    }
    if (is_array($img) && isset($img['url'])) {
        return $img['url'];
    }
    if (is_numeric($img)) {
        $url = wp_get_attachment_image_url((int)$img, 'full');
        return $url ? $url : '';
    }
    if (is_string($img)) {
        return $img;
    }
    return '';
}
