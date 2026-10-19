<?php
/**
 * Include theme modules
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$modules = array(
    'helpers.php',
    'cleanup.php',
    'assets.php',
    'ajax-lead.php',
    'acf-options.php',
    'click-tracker.php',
);

foreach ($modules as $file) {
    $path = LX_THEME_DIR . '/inc/' . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}
