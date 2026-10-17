<?php
/**
 * Cleanup header and optimize performance
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

// Remove unnecessary header links
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

// Disable emojis for performance
function lx_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'lx_disable_emojis');

// Disable wp-embed script
function lx_disable_embed() {
    wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'lx_disable_embed');
