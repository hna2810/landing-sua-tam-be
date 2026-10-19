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

/**
 * Extract YouTube Video ID from any YouTube URL format
 *
 * Supports:
 * - youtube.com/shorts/{id}
 * - youtube.com/watch?v={id}
 * - youtu.be/{id}
 * - youtube.com/embed/{id}
 * - youtube.com/v/{id}
 * - youtube.com/live/{id}
 * - Direct 11-char ID
 *
 * @param string $url Video URL or ID.
 * @return string|false 11-character video ID, or false if not YouTube.
 */
function lx_get_youtube_id($url) {
    if (empty($url) || !is_string($url)) {
        return false;
    }
    $url = trim($url);

    // Direct 11-character ID
    if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
        return $url;
    }

    // Prepend protocol if missing for proper URL parsing
    $check_url = $url;
    if (!preg_match('#^https?://#i', $check_url)) {
        $check_url = 'https://' . $check_url;
    }

    $parsed = function_exists('wp_parse_url') ? wp_parse_url($check_url) : parse_url($check_url);
    if (empty($parsed) || empty($parsed['host'])) {
        if (preg_match('/(?:shorts\/|v\/|embed\/|live\/|[?&]v=)([a-zA-Z0-9_-]{11})/i', $url, $m)) {
            return $m[1];
        }
        return false;
    }

    $host = strtolower($parsed['host']);
    $path = isset($parsed['path']) ? $parsed['path'] : '';

    // Check youtu.be shortlinks
    if (strpos($host, 'youtu.be') !== false) {
        $parts = explode('/', trim($path, '/'));
        if (!empty($parts[0]) && preg_match('/^[a-zA-Z0-9_-]{11}$/', $parts[0])) {
            return $parts[0];
        }
    }

    // Check youtube.com and youtube-nocookie.com
    if (strpos($host, 'youtube.com') !== false || strpos($host, 'youtube-nocookie.com') !== false) {
        if (preg_match('#/(?:shorts|embed|v|live)/([a-zA-Z0-9_-]{11})#i', $path, $m)) {
            return $m[1];
        }
        if (!empty($parsed['query'])) {
            $query_args = array();
            if (function_exists('wp_parse_str')) {
                wp_parse_str($parsed['query'], $query_args);
            } else {
                parse_str($parsed['query'], $query_args);
            }
            if (!empty($query_args['v']) && is_string($query_args['v']) && preg_match('/^[a-zA-Z0-9_-]{11}$/', $query_args['v'])) {
                return $query_args['v'];
            }
        }
    }

    // Generic regex fallback
    if (preg_match('/(?:shorts\/|v\/|embed\/|live\/|[?&]v=)([a-zA-Z0-9_-]{11})/i', $url, $m)) {
        return $m[1];
    }

    return false;
}

/**
 * Get YouTube video thumbnail image URL
 *
 * @param string $yt_id YouTube video ID.
 * @param string $quality Quality: hqdefault, mqdefault, maxresdefault.
 * @return string
 */
function lx_get_youtube_thumbnail($yt_id, $quality = 'hqdefault') {
    if (empty($yt_id)) {
        return '';
    }
    return 'https://img.youtube.com/vi/' . rawurlencode($yt_id) . '/' . $quality . '.jpg';
}

