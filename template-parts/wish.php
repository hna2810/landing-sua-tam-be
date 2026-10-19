<?php
/**
 * Wish Section (3D Flip Cards) Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$wish_title = lx_get_field('lx_wish_title', 'option', 'Mẹ muốn da con yêu thế nào?');
$acf_cards  = lx_get_field('lx_wish_cards', 'option', array());

$default_cards = array(
    array(
        'title' => 'Sạch da',
        'desc'  => 'Làm sạch dịu nhẹ bụi bẩn, mồ hôi trên da bé mà không gây kích ứng.',
        'image' => 'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/sach-da.png',
        'c1'    => '#e3f7fa',
        'c2'    => '#b8ecf3',
    ),
    array(
        'title' => 'Mềm da',
        'desc'  => 'Dưỡng ẩm, cho da bé mềm mại, mịn màng, không khô ráp sau khi tắm.',
        'image' => 'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/da-be-mem.png',
        'c1'    => '#ffe4ec',
        'c2'    => '#ffc9d8',
    ),
    array(
        'title' => 'Thơm ngọt ngào',
        'desc'  => 'Hương thơm dịu nhẹ, bé thơm tho, sạch thoáng sau mỗi lần tắm, gội.',
        'image' => 'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/da-be-thom.png',
        'c1'    => '#fff6d6',
        'c2'    => '#ffe7a3',
    ),
);

$cards = array();
if (!empty($acf_cards) && is_array($acf_cards)) {
    $colors = array(
        array('c1' => '#e3f7fa', 'c2' => '#b8ecf3'),
        array('c1' => '#ffe4ec', 'c2' => '#ffc9d8'),
        array('c1' => '#fff6d6', 'c2' => '#ffe7a3'),
    );
    foreach ($acf_cards as $idx => $card) {
        $color = isset($colors[$idx % 3]) ? $colors[$idx % 3] : $colors[0];
        $default_item = isset($default_cards[$idx]) ? $default_cards[$idx] : array();
        $cards[] = array(
            'title' => !empty($card['title']) ? $card['title'] : (isset($default_item['title']) ? $default_item['title'] : ('Mục ' . ($idx + 1))),
            'desc'  => !empty($card['desc']) ? $card['desc'] : (isset($default_item['desc']) ? $default_item['desc'] : ''),
            'image' => !empty($card['image']) ? $card['image'] : (isset($default_item['image']) ? $default_item['image'] : ''),
            'c1'    => $color['c1'],
            'c2'    => $color['c2'],
        );
    }
}
if (empty($cards)) {
    $cards = $default_cards;
}

if (empty($cards) && empty($wish_title)) {
    return;
}
?>
<!-- ===== WISH (section 2) ===== -->
<section class="section wish" id="van-de">
    <div class="container">
        <?php if (!empty($wish_title)) : ?>
            <div class="section-head" data-reveal>
                <h2 class="section-title"><?php echo $wish_title; ?></h2>
            </div>
        <?php endif; ?>
        <?php if (!empty($cards)) : ?>
            <div class="wish-grid">
            <?php foreach ($cards as $c) : ?>
                <div class="wish-card" data-reveal style="--c1:<?php echo esc_attr($c['c1']); ?>;--c2:<?php echo esc_attr($c['c2']); ?>">
                    <div class="wish-img-wrap">
                        <?php if (!empty($c['image'])) : ?>
                            <img src="<?php echo esc_url($c['image']); ?>" alt="<?php echo esc_attr($c['title']); ?>" loading="lazy">
                        <?php else : ?>
                            <span class="wish-ph">Ảnh</span>
                        <?php endif; ?>
                    </div>
                    <div class="wish-body">
                        <h3 class="wish-title"><?php echo esc_html($c['title']); ?></h3>
                        <?php if (!empty($c['desc'])) : ?>
                            <p class="wish-desc"><?php echo esc_html($c['desc']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <p class="wish-foot" data-reveal>Hơn cả sữa tắm, Bon Bon là "người bạn thân" để bé thật vui trong mỗi giờ tắm 💙</p>
    </div>
</section>
