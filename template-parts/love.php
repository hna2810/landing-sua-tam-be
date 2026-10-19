<?php
/**
 * Brand Love & Care Section Template (Yêu Con - Mẹ Chọn Bon Bon)
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$title_1        = lx_get_field('lx_love_title_1', 'option', 'YÊU CON -');
$title_2        = lx_get_field('lx_love_title_2', 'option', 'MẸ CHỌN BON BON');
$mascot_img     = lx_get_field('lx_love_mascot_img', 'option', '');
$content        = lx_get_field('lx_love_content', 'option', 'Bon Bon đồng hành cùng mẹ từ những ngày đầu đời của bé, từ tắm bé, massage đến chăm sóc da và rốn tại nhà và trung tâm. Với sự chăm chút nhẹ nhàng và các thành phần được lựa chọn phù hợp, Bon Bon cùng mẹ nâng niu làn da non nớt, chăm sóc bé yêu mỗi ngày. Bon Bon còn đồng hành cùng mẹ tại các hội thảo tiền sản và bệnh viện Sản – Nhi trên khắp ba miền Bắc – Trung – Nam.');
$highlight_text = lx_get_field('lx_love_highlight', 'option', 'Bon Bon - Dịu dàng chăm bé, trọn vẹn yêu thương.');

if (empty($mascot_img)) {
    $mascot_img = LX_THEME_URI . '/assets/img/su-tu-bon-bon.webp';
}
?>
<!-- ===== BRAND LOVE (YÊU CON - MẸ CHỌN BON BON) ===== -->
<section class="section love-sec" id="yeu-con">
    <div class="container">
        <div class="love-mascot" data-reveal>
            <div class="love-mascot-wrap">
                <span class="love-bub b1"></span>
                <span class="love-bub b2"></span>
                <span class="love-bub b3"></span>
                <span class="love-duck-toy">🐥</span>
                <img src="<?php echo esc_url($mascot_img); ?>" alt="Sư tử Bon Bon" width="220" height="220" loading="lazy">
            </div>
            <h2 class="love-title">
                <span><?php echo esc_html($title_1); ?></span>
                <span class="hl"><?php echo esc_html($title_2); ?></span>
            </h2>
            <svg class="love-wave" viewBox="0 0 70 12" aria-hidden="true">
                <path d="M2 6 Q 18 0 35 6 T 68 6" fill="none" stroke="#4cc0d3" stroke-width="3.5" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="love-card" data-reveal>
            <span class="love-quote-icon" aria-hidden="true">“</span>
            <div class="love-card-content">
                <p><?php echo nl2br(esc_html($content)); ?></p>
                <?php if (!empty($highlight_text)) : ?>
                    <p class="love-highlight"><?php echo esc_html($highlight_text); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
