<?php
/**
 * How to Use Section Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$eyebrow   = lx_get_field('lx_howto_eyebrow', 'option', '🧴 Tắm gội chuẩn mẹ đảm');
$title     = lx_get_field('lx_howto_title', 'option', 'Tắm bé đúng cách chỉ <span class="hl">3 bước</span>');
$sub       = lx_get_field('lx_howto_sub', 'option', 'Để con yêu tận hưởng trọn vẹn sự dịu êm từ Sữa Tắm Bon Bon.');
$video_url = lx_get_field('lx_howto_video_url', 'option', '');
$poster    = lx_get_image_url('lx_howto_video_poster', '');

$default_steps = array(
    array(
        'step_num' => '1',
        'title'    => 'Bước 1',
        'desc'     => 'Tráng người bé bằng nước ấm sạch để cơ thể con làm quen với nhiệt độ.',
    ),
    array(
        'step_num' => '2',
        'title'    => 'Bước 2',
        'desc'     => 'Lấy một lượng vừa đủ sữa tắm Bon Bon, nhẹ nhàng gội đầu cho con và xả sạch lại với nước.',
    ),
    array(
        'step_num' => '3',
        'title'    => 'Bước 3',
        'desc'     => 'Lấy thêm một lượng sữa tắm vừa phải, thoa đều và massage nhẹ nhàng toàn thân bé, sau đó tắm lại bằng nước sạch.',
    ),
);

$acf_steps = lx_get_field('lx_howto_steps', 'option', array());
$steps = array();
if (!empty($acf_steps) && is_array($acf_steps)) {
    foreach ($acf_steps as $idx => $s) {
        $steps[] = array(
            'step_num' => !empty($s['step_num']) ? $s['step_num'] : (string)($idx + 1),
            'title'    => !empty($s['title']) ? $s['title'] : ('Bước ' . ($idx + 1)),
            'desc'     => !empty($s['desc']) ? $s['desc'] : '',
        );
    }
}
if (empty($steps)) {
    $steps = $default_steps;
}
?>
<!-- ===== SECTION 7: TẮM BÉ ĐÚNG CÁCH ===== -->
<section class="section howto" id="cach-dung">
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

        <div class="howto-grid">
            <?php if (!empty($steps)) : ?>
                <div class="howto-steps">
                    <?php foreach ($steps as $idx => $s) : ?>
                        <button class="hstep <?php echo $idx === 0 ? 'active' : ''; ?>" type="button" data-reveal>
                            <span class="hstep-num"><?php echo esc_html($s['step_num']); ?></span>
                            <span class="hstep-body">
                                <b><?php echo esc_html($s['title']); ?></b>
                                <?php echo esc_html($s['desc']); ?>
                            </span>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="howto-phone" data-reveal>
                <div class="howto-screen">
                    <?php if (!empty($video_url)) : ?>
                        <video src="<?php echo esc_url($video_url); ?>" <?php if (!empty($poster)) : ?>poster="<?php echo esc_url($poster); ?>"<?php endif; ?> playsinline muted loop autoplay controls style="width:100%;height:100%;object-fit:cover;border-radius:28px;"></video>
                    <?php else : ?>
                        <div class="howto-ph"><span class="howto-play">▶</span><span>Video khung hình 9:16</span></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
