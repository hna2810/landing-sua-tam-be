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
$mom_img    = lx_get_field('lx_uses_mom_img', 'option', '');
$bottle_img = lx_get_field('lx_uses_bottle_img', 'option', '');

if (empty($mom_img)) {
    $mom_img = LX_THEME_URI . '/assets/img/me-tam-be.webp';
}
if (empty($bottle_img)) {
    $bottle_img = LX_THEME_URI . '/assets/img/sua-tam-goi-bon-bon-500ml.webp';
}

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
?>
<!-- ===== CÔNG DỤNG 3 TRONG 1 (section 5) ===== -->
<section class="section uses" id="cong-dung">
    <span class="uses-bigthree" aria-hidden="true">3</span>
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
            <h2 class="section-title">Công dụng <span class="hl">3 trong 1</span></h2>
        </div>
        <div class="uses-grid">
            <div class="uses-visual" data-reveal>
                <svg class="uses-ring" viewBox="0 0 200 200" aria-hidden="true">
                    <defs><path id="usesCircle" d="M100,100 m-82,0 a82,82 0 1,1 164,0 a82,82 0 1,1 -164,0"/></defs>
                    <text><textPath href="#usesCircle" textLength="508" lengthAdjust="spacing">TẮM • GỘI • DƯỠNG ẨM • BON BON 3 TRONG 1 • TẮM • GỘI • DƯỠNG ẨM • BON BON •</textPath></text>
                </svg>
                <div class="uses-photo">
                    <img src="<?php echo esc_url($mom_img); ?>" alt="Mẹ tắm cho bé bằng sữa tắm gội Bon Bon" width="504" height="504" loading="lazy">
                </div>
                <img class="uses-bottle" src="<?php echo esc_url($bottle_img); ?>" alt="Sữa tắm gội Bon Bon 500ml" width="827" height="2000" loading="lazy" draggable="false">
                <span class="uses-chip c1"><b>1</b> Tắm</span>
                <span class="uses-chip c2"><b>2</b> Gội</span>
                <span class="uses-chip c3"><b>3</b> Dưỡng</span>
            </div>
            <div class="uses-list">
                <p class="uses-lead" data-reveal><span class="bb"></span> Dùng để tắm, gội toàn thân hằng ngày.</p>
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
            </div>
        </div>
        <div class="uses-cta" data-reveal>
            <a href="#dang-ky" class="btn btn-pink js-scroll magnetic">Mẹ muốn thử cho bé? <span class="wiggle">→</span></a>
        </div>
    </div>
</section>
