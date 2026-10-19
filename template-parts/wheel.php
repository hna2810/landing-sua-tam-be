<?php
/**
 * Lucky Wheel Section Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$eyebrow = lx_get_field('lx_wheel_eyebrow', 'option', '🎡 Vòng quay may mắn');
$title   = lx_get_field('lx_wheel_title', 'option', 'Quay là trúng, <span class="hl">100% có quà!</span>');
$sub     = lx_get_field('lx_wheel_sub', 'option', 'Mỗi mẹ có 1 lượt quay. Phần quà được gửi kèm đơn hàng khi mẹ đặt mua bên dưới.');
?>
<!-- ===== WHEEL ===== -->
<section class="section wheel-sec" id="vong-quay">
    <div class="container wheel-grid">
        <div class="wheel-copy" data-reveal>
            <?php if (!empty($eyebrow)) : ?>
                <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
            <?php endif; ?>
            <?php if (!empty($title)) : ?>
                <h2 class="section-title"><?php echo $title; ?></h2>
            <?php endif; ?>
            <?php if (!empty($sub)) : ?>
                <p class="section-sub"><?php echo esc_html($sub); ?></p>
            <?php endif; ?>
            <ul>
                <li><span>🎁</span> Quà được giữ trong 24 giờ</li>
                <li><span>📞</span> Chuyên viên gọi lại xác nhận quà</li>
                <li><span>🚚</span> Giao hàng toàn quốc</li>
            </ul>
            <div class="wheel-result" id="wheelResult">🎉 Chúc mừng mẹ đã trúng: <b id="wheelPrize"></b><br><small>Điền form bên dưới để nhận quà nhé!</small></div>
            <a href="#dang-ky" class="btn btn-pink js-scroll" id="wheelCta">🎁 Nhận quà của tôi</a>
        </div>
        <div data-reveal>
            <div class="wheel-wrap">
                <div class="wheel-pointer">🔻</div>
                <div class="wheel" id="wheel"></div>
                <button class="wheel-center" id="wheelSpin">QUAY<br>NGAY</button>
            </div>
        </div>
    </div>
</section>
