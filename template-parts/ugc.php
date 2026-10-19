<?php
/**
 * UGC Customer Photos Wall Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$eyebrow  = lx_get_field('lx_ugc_eyebrow', 'option', '📸 Khoảnh khắc đáng yêu');
$title    = lx_get_field('lx_ugc_title', 'option', 'Hàng ngàn mẹ bỉm đã tin dùng <span class="hl">Bon Bon</span>');
$sub      = lx_get_field('lx_ugc_sub', 'option', 'Các mẹ gửi hình ảnh khoe bé cùng Bon Bon trên khắp 3 miền');
$acf_imgs = lx_get_field('lx_ugc_images', 'option', array());

$images = array();
if (!empty($acf_imgs) && is_array($acf_imgs)) {
    foreach ($acf_imgs as $item) {
        if (!empty($item['image'])) {
            $images[] = $item['image'];
        }
    }
}

$heights = array(1.25, 1, 1.4, 1.1, 1.3);
?>
<!-- ===== SECTION 8: ĐÁNH GIÁ / ẢNH KHÁCH HÀNG ===== -->
<section class="section ugc" id="danh-gia">
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

        <?php if (!empty($images)) : ?>
            <div class="ugc-wall" data-reveal>
                <?php for ($col = 0; $col < 4; $col++) : 
                    $is_rev = ($col % 2 === 1) ? 'rev' : '';
                ?>
                    <div class="ugc-col <?php echo $is_rev; ?>">
                        <div class="ugc-track">
                            <?php 
                            // Repeat twice for seamless infinite scroll
                            for ($repeat = 0; $repeat < 2; $repeat++) :
                                for ($i = 0; $i < 5; $i++) :
                                    $idx = ($col * 5 + $i) % count($images);
                                    $h = $heights[($i + $col) % count($heights)];
                                    $img_src = $images[$idx];
                            ?>
                                <div class="ugc-tile" style="--h:<?php echo $h; ?>">
                                    <img src="<?php echo esc_url($img_src); ?>" alt="Bé dùng sữa tắm Bon Bon" loading="lazy">
                                </div>
                            <?php 
                                endfor;
                            endfor; 
                            ?>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
