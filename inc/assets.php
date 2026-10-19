<?php
/**
 * Enqueue Styles and Scripts
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add preconnect resource hints for Google Fonts
 *
 * @param array  $urls
 * @param string $relation_type
 * @return array
 */
function lx_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array('href' => 'https://fonts.googleapis.com');
        $urls[] = array('href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous');
    }
    return $urls;
}
add_filter('wp_resource_hints', 'lx_resource_hints', 10, 2);

/**
 * Enqueue scripts and styles
 */
function lx_enqueue_scripts() {
    // Google Fonts: Baloo 2 & Nunito
    wp_enqueue_style(
        'lx-landing-fonts',
        'https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Main Theme CSS
    wp_enqueue_style(
        'lx-landing-main',
        LX_THEME_URI . '/assets/css/main.css',
        array(),
        LX_THEME_VERSION
    );

    // GSAP 3.12.5 libraries (Self-hosted locally for reliability & compatibility on iOS/Safari)
    wp_enqueue_script('gsap', LX_THEME_URI . '/assets/js/vendor/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('gsap-scroll-trigger', LX_THEME_URI . '/assets/js/vendor/ScrollTrigger.min.js', array('gsap'), '3.12.5', true);
    wp_enqueue_script('gsap-scroll-to', LX_THEME_URI . '/assets/js/vendor/ScrollToPlugin.min.js', array('gsap'), '3.12.5', true);
    wp_enqueue_script('gsap-draggable', LX_THEME_URI . '/assets/js/vendor/Draggable.min.js', array('gsap'), '3.12.5', true);

    // Main Theme JS
    wp_enqueue_script(
        'lx-landing-main',
        LX_THEME_URI . '/assets/js/main.js',
        array('gsap', 'gsap-scroll-trigger', 'gsap-scroll-to', 'gsap-draggable'),
        LX_THEME_VERSION,
        true
    );

    // Localize CONFIG for front-end JS
    $default_gifts = array(
        array('label' => 'Giảm 20%',      'color' => '#ffb5c8', 'weight' => 2),
        array('label' => 'Khăn tắm xinh', 'color' => '#fff6d6', 'weight' => 3),
        array('label' => 'Freeship',      'color' => '#b8f0d8', 'weight' => 3),
        array('label' => 'Giảm 30%',      'color' => '#d9cbff', 'weight' => 1),
        array('label' => 'Vịt tắm cute',  'color' => '#e3f7fa', 'weight' => 3),
        array('label' => 'Mua 2 tặng 1',  'color' => '#ffe08a', 'weight' => 1),
    );

    $acf_gifts = lx_get_field('lx_wheel_gifts', 'option', array());
    $gifts = array();
    if (!empty($acf_gifts) && is_array($acf_gifts)) {
        foreach ($acf_gifts as $g) {
            if (!empty($g['label'])) {
                $gifts[] = array(
                    'label'  => $g['label'],
                    'color'  => !empty($g['color']) ? $g['color'] : '#ffb5c8',
                    'weight' => !empty($g['weight']) ? (int)$g['weight'] : 1,
                );
            }
        }
    }
    if (empty($gifts)) {
        $gifts = $default_gifts;
    }

    $offer_label = lx_get_field('lx_offer_label', 'option', 'Sữa tắm Bon Bon');
    if (empty($offer_label) || strpos($offer_label, 'Combo 299K') !== false) {
        $offer_label = 'Sữa tắm Bon Bon';
    }

    $offer = array(
        'label' => $offer_label,
        'price' => (int)lx_get_field('lx_offer_price', 'option', 159000),
        'old'   => (int)lx_get_field('lx_offer_old_price', 'option', 315000),
    );

    $acf_reviews = lx_get_field('lx_reviews_list', 'option', array());
    $reviews = array();
    if (!empty($acf_reviews) && is_array($acf_reviews)) {
        foreach ($acf_reviews as $r) {
            if (!empty($r['name']) && !empty($r['text'])) {
                $reviews[] = array(
                    'name'   => $r['name'],
                    'time'   => !empty($r['time']) ? $r['time'] : 'Gần đây',
                    'stars'  => !empty($r['stars']) ? (int)$r['stars'] : 5,
                    'text'   => $r['text'],
                    'photos' => !empty($r['photos']) ? (array)$r['photos'] : array(),
                    'sample' => false,
                );
            }
        }
    }

    $js_config = array(
        'themeUri'         => LX_THEME_URI,
        'hotline'          => lx_get_field('lx_hotline', 'option', '0901234567'),
        'hotlineFormatted' => lx_get_field('lx_hotline_formatted', 'option', '0901.234.567'),
        'zalo'             => lx_get_field('lx_zalo', 'option', '0901234567'),
        'webhookUrl'       => lx_get_field('lx_webhook_url', 'option', ''),
        'ajaxUrl'          => admin_url('admin-ajax.php'),
        'nonce'            => wp_create_nonce('lx_lead_nonce'),
        'offer'            => $offer,
        'gifts'            => $gifts,
        'reviews'          => !empty($reviews) ? $reviews : null,
    );

    wp_localize_script('lx-landing-main', 'BONBON_CONFIG', $js_config);
}
add_action('wp_enqueue_scripts', 'lx_enqueue_scripts');
