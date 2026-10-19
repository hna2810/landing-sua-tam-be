<?php
/**
 * Footer template for LX Landing Theme
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$default_logo = LX_THEME_URI . '/assets/img/logo-bon-bon.png';
$footer_logo  = lx_get_image_url('lx_footer_logo', $default_logo);

$footer_title   = lx_get_field('lx_footer_title', 'option', 'Bon Bon - Nâng Niu Làn Da Bé');
$footer_company = lx_get_field('lx_footer_company', 'option', 'CÔNG TY TNHH CHĂM SÓC MẸ VÀ BÉ TẠI NHÀ HOME CARE');
$footer_address = lx_get_field('lx_footer_address', 'option', 'Địa chỉ: 20 Huy Du, Phường Từ Liêm, TP Hà Nội, Việt Nam.');
$footer_tax     = lx_get_field('lx_footer_tax', 'option', 'Mã số doanh nghiệp: 0107375668 do Sở Kế hoạch & Đầu tư TP Hà Nội cấp lần đầu ngày 29/03/2016');
$hotline         = lx_get_field('lx_hotline', 'option', '0901234567');
$hotline_display = lx_get_field('lx_hotline_formatted', 'option', '0901.234.567');
if (empty($hotline_display) && !empty($hotline)) {
    $hotline_display = $hotline;
}
if (empty($hotline) && !empty($hotline_display)) {
    $hotline = preg_replace('/[^0-9]/', '', $hotline_display);
}
?>
</main>

<footer class="footer">
    <div class="container">
        <?php if (!empty($footer_logo)) : ?>
            <div class="footer-logo-wrap">
                <img src="<?php echo esc_url($footer_logo); ?>" alt="Bon Bon" class="footer-logo" loading="lazy">
            </div>
        <?php endif; ?>

        <?php if (!empty($footer_title)) : ?>
            <h4 class="footer-title"><?php echo esc_html($footer_title); ?></h4>
        <?php endif; ?>

        <?php if (!empty($hotline_display)) : ?>
            <p class="footer-hotline">
                Hotline: <a href="tel:<?php echo htmlspecialchars(strip_tags($hotline), ENT_QUOTES, 'UTF-8'); ?>" class="js-hotline" data-tel><span data-tel-text><?php echo htmlspecialchars(strip_tags($hotline_display), ENT_QUOTES, 'UTF-8'); ?></span></a>
            </p>
        <?php endif; ?>

        <?php if (!empty($footer_company)) : ?>
            <p class="footer-company"><?php echo esc_html($footer_company); ?></p>
        <?php endif; ?>

        <?php if (!empty($footer_address)) : ?>
            <p class="footer-address"><?php echo esc_html($footer_address); ?></p>
        <?php endif; ?>

        <?php if (!empty($footer_tax)) : ?>
            <p class="footer-tax"><?php echo esc_html($footer_tax); ?></p>
        <?php endif; ?>

        <div class="footer-copy">
            &copy; <span id="year"><?php echo date('Y'); ?></span> Home Care. All rights reserved.
        </div>
    </div>
</footer>

<!-- Floating -->
<div class="float-btns">
    <a href="#" class="float-btn phone" data-tel title="Gọi ngay">📞</a>
    <a href="#" class="float-btn zalo" data-zalo target="_blank" rel="noopener" title="Chat Zalo">Zalo</a>
</div>
<div class="sticky-bar" id="stickyBar">
    <a href="#" class="btn call" data-tel aria-label="Gọi hotline">📞</a>
    <a href="#dang-ky" class="btn btn-primary go js-scroll"><span class="wiggle">🎁</span> <?php _e('Đặt hàng ngay', 'lx-landing'); ?></a>
</div>
<div class="toast" id="toast"></div>

<?php wp_footer(); ?>
</body>
</html>
