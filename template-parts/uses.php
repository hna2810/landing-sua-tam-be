<?php
/**
 * Uses 3in1 Section Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$eyebrow    = lx_get_field('lx_uses_eyebrow', 'option', '✨ Một chai, ba công dụng');
$title      = lx_get_field('lx_uses_title', 'option', 'Công dụng 3 trong 1');
$mom_img    = lx_get_image_url('lx_uses_mom_img', LX_THEME_URI . '/assets/img/me-tam-be.webp');
$bottle_img = lx_get_image_url('lx_uses_bottle_img', LX_THEME_URI . '/assets/img/sua-tam-goi-bon-bon-500ml.webp');

$acf_uses = lx_get_field('lx_uses_list', 'option', array());
$default_uses = array(
    array(
        'num'   => '01',
        'title' => 'Làm sạch & bảo vệ',
        'desc'  => 'Làm sạch dịu nhẹ, chăm sóc và bảo vệ da bé, ngăn ngừa và cải thiện tình trạng: rôm sảy, mẩn ngứa, mụn kê, hăm da, chàm sữa, viêm da ở trẻ sơ sinh và trẻ nhỏ.',
    ),
    array(
        'num'   => '02',
        'title' => 'Không kích ứng',
        'desc'  => 'Loại bỏ bụi bẩn, mồ hôi mà không gây kích ứng.',
    ),
    array(
        'num'   => '03',
        'title' => 'Dưỡng ẩm, thơm dịu',
        'desc'  => 'Dưỡng ẩm, cho da bé mềm mại, mịn màng, thơm dịu. Đem lại cảm giác thoải mái, sạch thoáng cho bé sau khi tắm, gội.',
    ),
);

$uses = array();
if (!empty($acf_uses) && is_array($acf_uses)) {
    foreach ($acf_uses as $idx => $u) {
        $num = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
        $uses[] = array(
            'num'   => $num,
            'title' => !empty($u['title']) ? $u['title'] : '',
            'desc'  => !empty($u['desc']) ? $u['desc'] : '',
        );
    }
}
if (empty($uses)) {
    $uses = $default_uses;
}

if (empty($uses) && empty($title)) {
    return;
}
?>
<!-- ===== CÔNG DỤNG 3 TRONG 1 (section 5) ===== -->
<section class="section uses" id="cong-dung">
    <span class="uses-bigthree" aria-hidden="true">3</span>
    <div class="container">
        <?php if (!empty($eyebrow) || !empty($title)) : ?>
            <div class="section-head" data-reveal>
                <?php if (!empty($eyebrow)) : ?>
                    <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if (!empty($title)) : ?>
                    <h2 class="section-title"><?php echo $title; ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="uses-grid">
            <div class="uses-visual" data-reveal>
                <!-- Vòng màu #4cc0d3 chuyển động xung quanh ảnh (thay thế text cũ) -->
                <div class="uses-ring-wrap" aria-hidden="true">
                    <svg class="uses-ring-svg" viewBox="0 0 240 240">
                        <defs>
                            <linearGradient id="usesRingGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#4cc0d3" stop-opacity="1"/>
                                <stop offset="50%" stop-color="#2a9fb3" stop-opacity="0.9"/>
                                <stop offset="85%" stop-color="#7ee4f4" stop-opacity="0.3"/>
                                <stop offset="100%" stop-color="#4cc0d3" stop-opacity="0"/>
                            </linearGradient>
                            <filter id="usesRingGlow" x="-30%" y="-30%" width="160%" height="160%">
                                <feGaussianBlur stdDeviation="3.5" result="blur"/>
                                <feMerge>
                                    <feMergeNode in="blur"/>
                                    <feMergeNode in="SourceGraphic"/>
                                </feMerge>
                            </filter>
                        </defs>
                        <!-- Vòng nét đứt mờ phụ trợ -->
                        <circle class="ring-track" cx="120" cy="120" r="106"/>
                        <!-- Cung chính màu #4cc0d3 phát sáng chạy quanh ảnh -->
                        <circle class="ring-arc ring-arc-1" cx="120" cy="120" r="106" filter="url(#usesRingGlow)"/>
                        <circle class="ring-arc ring-arc-2" cx="120" cy="120" r="106" filter="url(#usesRingGlow)"/>
                        <!-- Các hạt ngọc phát sáng chạy cùng vòng -->
                        <circle class="ring-dot ring-dot-1" cx="226" cy="120" r="5.5" filter="url(#usesRingGlow)"/>
                        <circle class="ring-dot ring-dot-2" cx="14" cy="120" r="4.5" filter="url(#usesRingGlow)"/>
                        <circle class="ring-dot ring-dot-3" cx="120" cy="14" r="3.5"/>
                    </svg>
                </div>
                <div class="uses-photo">
                    <?php if (!empty($mom_img)) : ?>
                        <img src="<?php echo esc_url($mom_img); ?>" alt="Mẹ tắm cho bé bằng sữa tắm gội Bon Bon" width="504" height="504" loading="lazy">
                    <?php endif; ?>
                </div>
                <?php if (!empty($bottle_img)) : ?>
                    <img class="uses-bottle" src="<?php echo esc_url($bottle_img); ?>" alt="Sữa tắm gội Bon Bon 500ml" width="827" height="2000" loading="lazy" draggable="false">
                <?php endif; ?>
                <span class="uses-chip c1"><b>1</b> Tắm</span>
                <span class="uses-chip c2"><b>2</b> Gội</span>
                <span class="uses-chip c3"><b>3</b> Dưỡng</span>
            </div>
            <div class="uses-list">
                <p class="uses-lead" data-reveal><span class="bb"></span> Dùng để tắm, gội toàn thân hằng ngày.</p>
                <?php if (!empty($uses)) : ?>
                    <div class="uses-track">
                        <span class="uses-line"><i id="usesLineFill"></i></span>
                        <?php foreach ($uses as $u) : ?>
                            <button class="use-item" type="button">
                                <span class="use-num"><?php echo esc_html($u['num']); ?></span>
                                <span class="use-body">
                                    <b><?php echo esc_html($u['title']); ?></b>
                                    <?php echo esc_html($u['desc']); ?>
                                </span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="uses-cta" data-reveal>
            <a href="#dang-ky" class="btn btn-pink js-scroll magnetic">Mẹ muốn thử cho bé? <span class="wiggle">→</span></a>
        </div>
    </div>
</section>
