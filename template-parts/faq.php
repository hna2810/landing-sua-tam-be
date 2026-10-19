<?php
/**
 * FAQ & Help Section Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$title       = lx_get_field('lx_faq_title', 'option', 'Mẹ thường hỏi');
$acf_faqs    = lx_get_field('lx_faq_items', 'option', array());
$lion_img    = lx_get_field('lx_hero_lion_img', 'option', '');
$hotline_fmt = lx_get_field('lx_hotline_formatted', 'option', '0901.234.567');

if (empty($lion_img)) {
    $lion_img = LX_THEME_URI . '/assets/img/su-tu-bon-bon.webp';
}

$default_faqs = array(
    array(
        'q' => 'Sữa tắm Bon Bon có dùng được cho trẻ sơ sinh không?',
        'a' => 'Có. Bon Bon có công thức dịu nhẹ, cân bằng độ pH, không chứa Paraben, phù hợp cho cả làn da nhạy cảm của trẻ sơ sinh và trẻ nhỏ.',
    ),
    array(
        'q' => 'Sữa tắm gội này có làm cay mắt bé không?',
        'a' => 'Không. Bon Bon dùng công thức ít bọt, dịu nhẹ, không gây cay mắt, giúp bé luôn thoải mái, thư giãn khi tắm.',
    ),
    array(
        'q' => 'Có hỗ trợ làm sạch cứt trâu không?',
        'a' => 'Có. Nhờ dầu hạnh nhân và các dưỡng chất, sản phẩm giúp làm mềm và làm sạch nhẹ nhàng các mảng viêm da tiết bã (cứt trâu) và màng ối trên da bé hằng ngày.',
    ),
    array(
        'q' => 'Dùng hằng ngày có bị khô da không?',
        'a' => 'Không. Độ pH cân bằng cùng dầu hạnh nhân và Vitamin E giúp nuôi dưỡng màng ẩm tự nhiên, da bé mềm mại, không khô ráp sau khi tắm.',
    ),
    array(
        'q' => 'Đặt hàng xong thì sao?',
        'a' => 'Home Care sẽ gọi lại số điện thoại mẹ để lại để xác nhận đơn, địa chỉ nhận hàng và quà tặng trước khi giao.',
    ),
    array(
        'q' => 'Bao lâu thì được gọi lại?',
        'a' => 'Trong giờ hành chính, chuyên viên Home Care sẽ liên hệ lại sớm nhất có thể. Cần gấp, mẹ gọi hotline hoặc nhắn Zalo ở góc màn hình nhé.',
    ),
);

$faqs = array();
if (!empty($acf_faqs) && is_array($acf_faqs)) {
    foreach ($acf_faqs as $f) {
        if (!empty($f['q']) && !empty($f['a'])) {
            $faqs[] = array('q' => $f['q'], 'a' => $f['a']);
        }
    }
}
if (empty($faqs)) {
    $faqs = $default_faqs;
}
?>
<!-- ===== FAQ ===== -->
<section class="section faq" id="hoi-dap">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">❓ Hỏi đáp</span>
            <h2 class="section-title">Mẹ thường <span class="hl">hỏi</span></h2>
        </div>
        <div class="faq-wrap">
            <div class="faq-list">
                <?php foreach ($faqs as $item) : ?>
                    <div class="faq-item" data-reveal>
                        <button class="faq-q"><?php echo esc_html($item['q']); ?><span class="pm">+</span></button>
                        <div class="faq-a"><p><?php echo esc_html($item['a']); ?></p></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <aside class="faq-help" data-reveal>
                <img src="<?php echo esc_url($lion_img); ?>" alt="Sư tử Bon Bon" width="400" height="400" loading="lazy">
                <h3>Mẹ vẫn còn băn khoăn?</h3>
                <p>Chuyên viên Home Care luôn sẵn sàng tư vấn miễn phí cách chăm da cho bé.</p>
                <a href="#" class="btn btn-zalo" data-zalo target="_blank" rel="noopener">💬 Chat Zalo ngay</a>
                <a href="#" class="btn btn-primary" data-tel>📞 Gọi <span data-tel-text><?php echo esc_html($hotline_fmt); ?></span></a>
                <span class="hotline">Hotline: <b data-tel-text><?php echo esc_html($hotline_fmt); ?></b></span>
            </aside>
        </div>
    </div>
</section>
