<?php
/**
 * Stores & Hospital Presence Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$title       = lx_get_field('lx_stores_title', 'option', 'Hiện diện tại các bệnh viện, nhà thuốc, cửa hàng mẹ bé');
$acf_stores  = lx_get_field('lx_stores_list', 'option', array());

$stores = array();
if (!empty($acf_stores) && is_array($acf_stores)) {
    foreach ($acf_stores as $s) {
        if (!empty($s['photo'])) {
            $stores[] = $s;
        }
    }
}
?>
<!-- ===== SECTION 10: HIỆN DIỆN TẠI CÁC ĐIỂM BÁN ===== -->
<section class="section stores" id="diem-ban">
    <div class="container">
        <div class="section-head" data-reveal>
            <h2 class="section-title">Hiện diện tại các bệnh viện, nhà thuốc, <span class="hl">cửa hàng mẹ bé</span></h2>
        </div>
        <div class="store-slider" data-reveal>
            <button class="store-nav prev" type="button" aria-label="Ảnh trước">←</button>
            <div class="store-track" id="storeTrack">
                <?php if (!empty($stores)) : ?>
                    <?php foreach ($stores as $idx => $st) : ?>
                        <div class="store-slide">
                            <img src="<?php echo esc_url($st['photo']); ?>" alt="<?php echo !empty($st['name']) ? esc_attr($st['name']) : ('Điểm bán ' . ($idx + 1)); ?>" loading="lazy">
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="store-slide"><span>Ảnh slider 1</span></div>
                    <div class="store-slide"><span>Ảnh slider 2</span></div>
                    <div class="store-slide"><span>Ảnh slider 3</span></div>
                    <div class="store-slide"><span>Ảnh slider 4</span></div>
                    <div class="store-slide"><span>Ảnh slider 5</span></div>
                    <div class="store-slide"><span>Ảnh slider 6</span></div>
                    <div class="store-slide"><span>Ảnh slider 7</span></div>
                    <div class="store-slide"><span>Ảnh slider 8</span></div>
                <?php endif; ?>
            </div>
            <button class="store-nav next" type="button" aria-label="Ảnh sau">→</button>
        </div>
        <div class="store-dots" id="storeDots"></div>
    </div>
</section>
