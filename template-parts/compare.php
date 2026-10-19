<?php
/**
 * Compare Section Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$eyebrow      = lx_get_field('lx_compare_eyebrow', 'option', '↔️ Kéo để so sánh');
$title        = lx_get_field('lx_compare_title', 'option', 'Khác biệt nằm ở <span class="hl">sự dịu nhẹ</span>');
$sub          = lx_get_field('lx_compare_sub', 'option', 'Kéo nút tròn sang trái/phải để xem sự khác biệt.');

$normal_title = lx_get_field('lx_compare_normal_title', 'option', 'Sữa tắm thông thường');
$normal_pts   = lx_get_field('lx_compare_normal_points', 'option', '__NOT_SET__');
$normal_img   = lx_get_image_url('lx_compare_normal_img', '');

$bonbon_title = lx_get_field('lx_compare_bonbon_title', 'option', 'Sữa tắm gội Bon Bon');
$bonbon_pts   = lx_get_field('lx_compare_bonbon_points', 'option', '__NOT_SET__');
$bonbon_img   = lx_get_image_url('lx_compare_bonbon_img', '');

$note         = lx_get_field('lx_compare_note', 'option', '* So sánh mang tính minh họa, trải nghiệm có thể khác nhau tùy làn da mỗi bé.');

if ($normal_pts === '__NOT_SET__') {
    $normal_points = array(
        '<i class="bb"></i> Nhiều bọt, khó xả sạch',
        '<i>😣</i> Dễ cay mắt khi gội',
        '<i>🌵</i> Da dễ khô ráp sau tắm',
        '<i>🧴</i> Phải mua riêng dầu gội',
    );
} else {
    $normal_points = array_filter(array_map('trim', explode("\n", (string)$normal_pts)));
}

if ($bonbon_pts === '__NOT_SET__') {
    $bonbon_points = array(
        '<i>😊</i> Ít bọt, không cay mắt',
        '<i>🚫</i> Không chứa Paraben',
        '<i>⚖️</i> pH cân bằng, giữ ẩm da',
        '<i>✨</i> 2in1: tắm &amp; gội',
    );
} else {
    $bonbon_points = array_filter(array_map('trim', explode("\n", (string)$bonbon_pts)));
}
?>
<!-- ===== COMPARE ===== -->
<section class="section compare-sec" id="so-sanh">
    <div class="container">
        <?php if (!empty($eyebrow) || !empty($title) || !empty($sub)) : ?>
            <div class="section-head" data-reveal>
                <?php if (!empty($eyebrow)) : ?>
                    <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if (!empty($title)) : ?>
                    <h2 class="section-title"><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php if (!empty($sub)) : ?>
                    <p class="section-sub"><?php echo esc_html($sub); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="compare" id="compare" data-reveal>
            <div class="cmp-layer cmp-normal">
                <div class="cmp-col">
                    <?php if (!empty($normal_title)) : ?>
                        <h3><?php echo esc_html($normal_title); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($normal_points)) : ?>
                        <ul>
                            <?php foreach ($normal_points as $pt) : ?>
                                <li><?php echo $pt; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if (!empty($normal_img)) : ?>
                        <div class="cmp-photo">
                            <img src="<?php echo esc_url($normal_img); ?>" alt="<?php echo esc_attr($normal_title); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="cmp-layer cmp-bonbon" id="cmpTop">
                <div class="cmp-col">
                    <?php if (!empty($bonbon_title)) : ?>
                        <h3><?php echo esc_html($bonbon_title); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($bonbon_points)) : ?>
                        <ul>
                            <?php foreach ($bonbon_points as $pt) : ?>
                                <li><?php echo $pt; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if (!empty($bonbon_img)) : ?>
                        <div class="cmp-photo">
                            <img src="<?php echo esc_url($bonbon_img); ?>" alt="<?php echo esc_attr($bonbon_title); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <span class="cmp-tag l">Thông thường</span>
            <span class="cmp-tag r">Bon Bon 💙</span>
            <div class="cmp-handle" id="cmpHandle"><div class="cmp-knob" aria-label="Kéo để so sánh">↔</div></div>
        </div>
        <p class="compare-hint" data-reveal>👈 Kéo thử nhé 👉</p>
        <?php if (!empty($note)) : ?>
            <p class="compare-note"><?php echo esc_html($note); ?></p>
        <?php endif; ?>
    </div>
</section>
