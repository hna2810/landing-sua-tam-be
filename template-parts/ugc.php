<?php
/**
 * UGC Customer Photos Wall Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$title   = lx_get_field('lx_ugc_title', 'option', 'Hàng ngàn mẹ bỉm đã tin dùng Bon Bon');
$sub     = lx_get_field('lx_ugc_sub', 'option', 'Các mẹ gửi hình ảnh khoe bé cùng Bon Bon trên khắp 3 miền');
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
        <div class="section-head" data-reveal>
            <h2 class="section-title">Hàng ngàn mẹ bỉm đã tin dùng <span class="hl">Bon Bon</span></h2>
            <p class="section-sub"><?php echo esc_html($sub); ?></p>
        </div>
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
                                $idx = ($col * 5 + $i) % (max(1, count($images)));
                                $h = $heights[($i + $col) % count($heights)];
                                $img_src = !empty($images) ? $images[$idx] : '';
                        ?>
                            <div class="ugc-tile" style="--h:<?php echo $h; ?>">
                                <?php if (!empty($img_src)) : ?>
                                    <img src="<?php echo esc_url($img_src); ?>" alt="Bé dùng sữa tắm Bon Bon" loading="lazy">
                                <?php else : ?>
                                    <span>Ảnh</span>
                                <?php endif; ?>
                            </div>
                        <?php 
                            endfor;
                        endfor; 
                        ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
