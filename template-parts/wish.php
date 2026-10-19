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
$acf_cards  = lx_get_field('lx_wish_cards', 'option', '__NOT_SET__');

$default_cards = array(
    array(
        'title' => 'Sạch da',
        'desc'  => 'Làm sạch dịu nhẹ bụi bẩn, mồ hôi trên da bé mà không gây kích ứng.',
        'icon'  => '🛁',
        'image' => '',
        'c1'    => '#e3f7fa',
        'c2'    => '#b8ecf3',
    ),
    array(
        'title' => 'Mềm da',
        'desc'  => 'Dưỡng ẩm, cho da bé mềm mại, mịn màng, không khô ráp sau khi tắm.',
        'icon'  => '☁️',
        'image' => '',
        'c1'    => '#ffe4ec',
        'c2'    => '#ffc9d8',
    ),
    array(
        'title' => 'Thơm ngọt ngào',
        'desc'  => 'Hương thơm dịu nhẹ, bé thơm tho, sạch thoáng sau mỗi lần tắm, gội.',
        'icon'  => '🌸',
        'image' => '',
        'c1'    => '#fff6d6',
        'c2'    => '#ffe7a3',
    ),
);

$cards = array();
if ($acf_cards === '__NOT_SET__') {
    $cards = $default_cards;
} elseif (!empty($acf_cards) && is_array($acf_cards)) {
    $colors = array(
        array('c1' => '#e3f7fa', 'c2' => '#b8ecf3'),
        array('c1' => '#ffe4ec', 'c2' => '#ffc9d8'),
        array('c1' => '#fff6d6', 'c2' => '#ffe7a3'),
    );
    foreach ($acf_cards as $idx => $card) {
        $color = isset($colors[$idx % 3]) ? $colors[$idx % 3] : $colors[0];
        $cards[] = array(
            'title' => !empty($card['title']) ? $card['title'] : ('Mục ' . ($idx + 1)),
            'desc'  => !empty($card['desc']) ? $card['desc'] : '',
            'icon'  => !empty($card['icon']) ? $card['icon'] : '✨',
            'image' => !empty($card['image']) ? $card['image'] : '',
            'c1'    => $color['c1'],
            'c2'    => $color['c2'],
        );
    }
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
                <button class="wish-card" data-reveal type="button" aria-label="<?php echo esc_attr($c['title']); ?>: chạm để lật">
                    <span class="wish-flip">
                        <span class="wish-inner">
                            <span class="wish-face wish-front" style="--c1:<?php echo esc_attr($c['c1']); ?>;--c2:<?php echo esc_attr($c['c2']); ?>">
                                <?php if (!empty($c['image'])) : ?>
                                    <img src="<?php echo esc_url($c['image']); ?>" alt="<?php echo esc_attr($c['title']); ?>">
                                <?php else : ?>
                                    <span class="wish-ph">Ảnh</span>
                                <?php endif; ?>
                                <span class="wish-tap">👆 Chạm để lật</span>
                            </span>
                            <span class="wish-face wish-back" style="--c1:<?php echo esc_attr($c['c1']); ?>;--c2:<?php echo esc_attr($c['c2']); ?>">
                                <span class="wish-emo"><?php echo esc_html($c['icon']); ?></span>
                                <b><?php echo esc_html($c['title']); ?></b>
                                <span><?php echo esc_html($c['desc']); ?></span>
                            </span>
                        </span>
                    </span>
                    <span class="wish-label"><?php echo esc_html($c['title']); ?></span>
                </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <p class="wish-foot" data-reveal>Hơn cả sữa tắm, Bon Bon là "người bạn thân" để bé thật vui trong mỗi giờ tắm 💙</p>
    </div>
</section>
