<?php
/**
 * Hero Section Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$hero_badge    = lx_get_field('lx_hero_badge', 'option', '🌿 Sữa tắm gội 2in1 cho bé');
$hero_title    = lx_get_field('lx_hero_title', 'option', 'ÍT BỌT DỊU ÊM, MỀM MỊN DA BÉ');
$hero_desc     = lx_get_field('lx_hero_subtitle', 'option', 'Công thức thảo mộc tự nhiên, làm sạch dịu nhẹ — tắm & gội tiện lợi cho bé yêu từ sơ sinh.');
$hero_cta      = lx_get_field('lx_hero_btn_text', 'option', 'Chạm để cảm nhận da bé!');
$hero_subnote  = lx_get_field('lx_hero_subnote', 'option', 'Dịu nhẹ như vòng tay mẹ');
$lion_bubble   = lx_get_field('lx_hero_lion_bubble', 'option', 'Mẹ ơi, con thích tắm lắm! 🦁');
$bottle_img    = lx_get_image_url('lx_hero_bottle_img', LX_THEME_URI . '/assets/img/sua-tam-goi-bon-bon-500ml.webp');
$lion_img      = lx_get_image_url('lx_hero_lion_img', LX_THEME_URI . '/assets/img/su-tu-bon-bon.webp');
?>
<!-- ===== HERO ===== -->
<section class="hero" id="top">
    <div class="hero-bubbles" id="heroBubbles"></div>
    <div class="container hero-grid">
        <div class="hero-copy">
            <?php if (!empty($hero_badge)) : ?>
                <span class="pill" data-hero><span class="dot"></span> <?php echo esc_html($hero_badge); ?></span>
            <?php endif; ?>

            <?php if (!empty($hero_title)) : ?>
                <h1 class="hero-title">
                    <?php
                    if (strpos($hero_title, '<span') !== false || strpos($hero_title, '<br') !== false) {
                        echo $hero_title;
                    } else {
                        $words = explode(' ', trim($hero_title));
                        if (count($words) >= 4) {
                            $half = (int)ceil(count($words) / 2);
                            $l1 = implode(' ', array_slice($words, 0, $half));
                            $l2 = implode(' ', array_slice($words, $half));
                            echo '<span class="line"><span>' . esc_html($l1) . '</span></span>';
                            echo '<span class="line"><span class="hl">' . esc_html($l2) . '</span></span>';
                        } else {
                            echo '<span class="line"><span>' . esc_html($hero_title) . '</span></span>';
                        }
                    }
                    ?>
                </h1>
            <?php endif; ?>

            <?php if (!empty($hero_desc)) : ?>
                <p class="hero-desc" data-hero><?php echo esc_html($hero_desc); ?></p>
            <?php endif; ?>

            <?php if (!empty($hero_cta)) : ?>
                <div class="hero-ctas" data-hero>
                    <a href="#van-de" class="btn btn-primary js-scroll magnetic"><span class="wiggle">👶</span> <?php echo esc_html($hero_cta); ?></a>
                </div>
            <?php endif; ?>

            <div class="pop-hint" data-hero><i class="bb"></i> Thử chạm vào bong bóng xem! Đã bóp: <b id="popCount">0</b></div>
        </div>
        <div class="hero-visual">
            <div class="hero-blob"></div>
            <?php if (!empty($bottle_img)) : ?>
                <div class="hero-bottle" id="heroBottle" title="Kéo thử lọ Bon Bon nè!">
                    <img src="<?php echo esc_url($bottle_img); ?>" alt="Sữa tắm gội Bon Bon 500ml" width="827" height="2000" draggable="false">
                </div>
            <?php endif; ?>
            <?php if (!empty($lion_img)) : ?>
                <div class="hero-duck" id="heroDuck" title="<?php echo esc_attr(!empty($lion_bubble) ? $lion_bubble : 'Chạm vào sư tử Bon Bon!'); ?>" <?php if (!empty($lion_bubble)) : ?>data-bubble="<?php echo esc_attr($lion_bubble); ?>"<?php endif; ?>>
                    <img src="<?php echo esc_url($lion_img); ?>" alt="Sư tử Bon Bon" width="400" height="400" draggable="false">
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1440 90" preserveAspectRatio="none"><path fill="#4cc0d3" d="M0,40 C240,90 480,0 720,30 C960,60 1200,10 1440,40 L1440,90 L0,90 Z"/></svg>
    </div>
</section>
