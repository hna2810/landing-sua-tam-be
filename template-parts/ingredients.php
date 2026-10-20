<?php
/**
 * Ingredients Mini-game Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$bottle_img = lx_get_field('lx_hero_bottle_img', 'option', '');
if (empty($bottle_img)) {
    $bottle_img = LX_THEME_URI . '/assets/img/sua-tam-goi-bon-bon-500ml.webp';
}
?>
<!-- ===== INGREDIENTS GAME ===== -->
<section class="section ingre" id="thanh-phan">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">🧪 Mini game: Pha chế Bon Bon</span>
            <h2 class="section-title">Kéo thành phần <span class="hl">vào lọ</span> nào!</h2>
            <p class="section-sub">Kéo (hoặc chạm) từng thành phần vào lọ để khám phá công thức. Cẩn thận, có những "kẻ lạ mặt" mà Bon Bon không chào đón đâu nhé 😉</p>
        </div>
        <div class="lab" id="lab">
            <div class="chips chips-left">
                <div class="chip" data-ing="0">
                    <span class="ico" style="background:var(--pink-soft)">🌰</span>
                    <div class="chip-content">
                        <span class="chip-title">Dầu hạnh nhân</span>
                        <small>Nuôi dưỡng sâu</small>
                    </div>
                    <span class="chip-badge badge-good">Dưỡng da</span>
                </div>
                <div class="chip bad" data-bad="paraben">
                    <span class="ico">🧪</span>
                    <div class="chip-content">
                        <span class="chip-title">Paraben</span>
                        <small>Chất bảo quản</small>
                    </div>
                    <span class="chip-badge badge-bad">Chất cấm ✕</span>
                </div>
                <div class="chip" data-ing="3">
                    <span class="ico" style="background:#fce7f3"><img src="<?php echo esc_url(LX_THEME_URI . '/assets/img/dau-tam.svg'); ?>" alt="Dâu tằm" width="30" height="30"></span>
                    <div class="chip-content">
                        <span class="chip-title">Dâu tằm</span>
                        <small>Dịu mát &amp; dưỡng ẩm</small>
                    </div>
                    <span class="chip-badge badge-good">Thảo mộc</span>
                </div>
            </div>
            <div class="drop-zone" id="dropZone">
                <div class="drop-ring-glow"></div>
                <div class="drop-ring"></div>
                <div class="drop-hint-label"><span>✨ Thả vào lọ ✨</span></div>
                <div class="lab-bottle-wrap">
                    <div class="lab-bottle" id="labBottle">
                        <img src="<?php echo esc_url($bottle_img); ?>" alt="Sữa tắm gội Bon Bon 500ml" width="827" height="2000" draggable="false" loading="lazy">
                    </div>
                    <div class="lab-bottle-pedestal"></div>
                </div>
                <div class="lab-meter">
                    <div class="lab-meter-pill">
                        <span class="lab-meter-ico">🧪</span>
                        <span class="lab-meter-txt">Công thức: <b id="labCount">0</b>/4</span>
                    </div>
                    <div class="bar"><i id="labBar"></i></div>
                </div>
            </div>
            <div class="chips chips-right">
                <div class="chip" data-ing="1">
                    <span class="ico" style="background:#ece6ff">💊</span>
                    <div class="chip-content">
                        <span class="chip-title">Vitamin E</span>
                        <small>Chống oxy hóa</small>
                    </div>
                    <span class="chip-badge badge-good">Bảo vệ da</span>
                </div>
                <div class="chip bad" data-bad="sulfate">
                    <span class="ico">🚫</span>
                    <div class="chip-content">
                        <span class="chip-title">Gốc Sunfat</span>
                        <small>Chất tẩy rửa mạnh</small>
                    </div>
                    <span class="chip-badge badge-bad">Chất cấm ✕</span>
                </div>
                <div class="chip" data-ing="2">
                    <span class="ico" style="background:var(--primary-light)">💧</span>
                    <div class="chip-content">
                        <span class="chip-title">Aqua &amp; SLES dịu nhẹ</span>
                        <small>Làm sạch nhẹ nhàng</small>
                    </div>
                    <span class="chip-badge badge-good">Dịu nhẹ</span>
                </div>
            </div>
        </div>
        <div class="lab-info" id="labInfo" data-reveal>
            <span class="ico">👆</span>
            <div>
                <h4>Bắt đầu nào!</h4>
                <p>Kéo một thành phần vào lọ Bon Bon để xem công dụng của nó với làn da bé.</p>
            </div>
        </div>
        <div class="lab-done" id="labDone">
            <a href="#dang-ky" class="btn btn-primary js-scroll">🎉 Hoàn thành! Nhận tư vấn &amp; quà ngay</a>
        </div>
    </div>
</section>
