<?php
/**
 * Hero Section Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$hero_badge    = lx_get_field('lx_hero_badge', 'option', 'Sữa tắm gội cho bé Bon Bon');
$hero_title    = lx_get_field('lx_hero_title', 'option', 'ÍT BỌT DỊU ÊM, MỀM MỊN DA BÉ');
$hero_desc     = lx_get_field('lx_hero_subtitle', 'option', 'Ngừa da hăm, viêm da, chàm sữa.');
$hero_cta      = lx_get_field('lx_hero_btn_order_text', 'option', 'Chạm để cảm nhận da bé!');
$bottle_img    = lx_get_field('lx_hero_bottle_img', 'option', '');
$lion_img      = lx_get_field('lx_hero_lion_img', 'option', '');

if (empty($bottle_img)) {
    $bottle_img = LX_THEME_URI . '/assets/img/sua-tam-goi-bon-bon-500ml.webp';
}
if (empty($lion_img)) {
    $lion_img = LX_THEME_URI . '/assets/img/su-tu-bon-bon.webp';
}
?>
<!-- ===== HERO ===== -->
<section class="hero" id="top">
    <div class="hero-bubbles" id="heroBubbles"></div>
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="pill" data-hero><span class="dot"></span> <?php echo esc_html($hero_badge); ?></span>
            <h1 class="hero-title">
                <span class="line"><span>ÍT BỌT DỊU ÊM,</span></span>
                <span class="line"><span class="hl">MỀM MỊN <span class="hl-pink">DA BÉ</span></span></span>
            </h1>
            <p class="hero-desc" data-hero><?php echo esc_html($hero_desc); ?></p>
            <div class="hero-ctas" data-hero>
                <a href="#dang-ky" class="btn btn-primary js-scroll magnetic"><span class="wiggle">👶</span> <?php echo esc_html($hero_cta); ?></a>
            </div>
            <div class="pop-hint" data-hero><i class="bb"></i> Thử chạm vào bong bóng xem! Đã bóp: <b id="popCount">0</b></div>
        </div>
        <div class="hero-visual">
            <div class="hero-blob"></div>
            <span class="hero-star" style="top:6%;right:18%">✨</span>
            <span class="hero-star" style="bottom:22%;left:-2%">⭐</span>
            <span class="hero-star" style="top:30%;left:12%">💖</span>
            <div class="hero-bottle" id="heroBottle" title="Kéo thử lọ Bon Bon nè!">
                <img src="<?php echo esc_url($bottle_img); ?>" alt="Sữa tắm gội Bon Bon 500ml" width="827" height="2000" draggable="false">
            </div>
            <div class="hero-duck" id="heroDuck" title="Chạm vào sư tử Bon Bon!">
                <img src="<?php echo esc_url($lion_img); ?>" alt="Sư tử Bon Bon" width="400" height="400" draggable="false">
            </div>
        </div>
    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1440 90" preserveAspectRatio="none"><path fill="#4cc0d3" d="M0,40 C240,90 480,0 720,30 C960,60 1200,10 1440,40 L1440,90 L0,90 Z"/></svg>
    </div>
</section>
