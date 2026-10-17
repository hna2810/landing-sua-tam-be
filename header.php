<?php
/**
 * Header Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$fb_pixel_id = lx_get_field('lx_fb_pixel_id', 'option', '');
$ga4_id      = lx_get_field('lx_ga4_id', 'option', '');
$tiktok_id   = lx_get_field('lx_tiktok_pixel_id', 'option', '');
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4cc0d3">
    <link rel="icon" href="https://cdn.hstatic.net/themes/200001066686/1001439050/14/favicon.png" type="image/png">
    <title><?php
        $site_name = get_bloginfo('name');
        $default_seo = 'Sữa Tắm Gội Bon Bon Cho Bé - Dịu Nhẹ, Không Cay Mắt | Home Care Việt Nam';
        echo esc_html($default_seo);
    ?></title>
    <meta name="description" content="Sữa tắm gội 2in1 Bon Bon cho bé: không cay mắt, không Paraben, pH cân bằng, dùng được cho trẻ sơ sinh. Đăng ký nhận tư vấn miễn phí &amp; quà tặng dành cho mẹ.">
    <meta property="og:title" content="Sữa Tắm Gội Bon Bon - Nâng niu làn da bé từ những ngày đầu đời">
    <meta property="og:description" content="Làm quiz 30 giây để biết bé cần chăm da thế nào và nhận quà tặng từ Home Care Việt Nam.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>">
    <script>document.documentElement.classList.add('js');</script>

<?php if (!empty($fb_pixel_id)) : ?>
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?php echo esc_js($fb_pixel_id); ?>');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=<?php echo esc_attr($fb_pixel_id); ?>&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
<?php endif; ?>

<?php if (!empty($ga4_id)) : ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga4_id); ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo esc_js($ga4_id); ?>');
    </script>
<?php endif; ?>

<?php if (!empty($tiktok_id)) : ?>
    <!-- TikTok Pixel Code -->
    <script>
    !function (w, d, t) {
      w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};
      ttq.load('<?php echo esc_js($tiktok_id); ?>');
      ttq.page();
    }(window, document, 'ttq');
    </script>
<?php endif; ?>

<?php wp_head(); ?>
</head>
<body <?php body_class('lx_landing_theme'); ?>>
<?php wp_body_open(); ?>

<!-- Scroll progress with duck -->
<div class="progress" aria-hidden="true">
    <div class="progress-bar" id="progressBar"></div>
    <div class="progress-duck" id="progressDuck">🐥</div>
</div>

<!-- ===== HEADER ===== -->
<header class="header" id="header">
    <div class="container header-inner">
        <a href="#top" class="logo js-scroll">
            <img src="https://cdn.hstatic.net/themes/200001066686/1001439050/14/logo.png" alt="Home Care Việt Nam" onerror="this.style.display='none'">
            <span class="logo-text">Bon Bon<small>by Home Care Việt Nam</small></span>
        </a>
        <nav class="nav">
            <a href="#van-de" class="js-scroll"><?php _e('Mẹ lo gì?', 'lx-landing'); ?></a>
            <a href="#thanh-phan" class="js-scroll"><?php _e('Thành phần', 'lx-landing'); ?></a>
            <a href="#quiz" class="js-scroll"><?php _e('Quiz da bé', 'lx-landing'); ?></a>
            <a href="#vong-quay" class="js-scroll"><?php _e('Quà tặng', 'lx-landing'); ?></a>
            <a href="#hoi-dap" class="js-scroll"><?php _e('Hỏi đáp', 'lx-landing'); ?></a>
        </nav>
        <a href="#dang-ky" class="btn btn-primary header-cta js-scroll">🎁 <?php _e('Nhận quà', 'lx-landing'); ?></a>
    </div>
</header>

<main>
