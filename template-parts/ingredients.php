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
                <div class="chip" data-ing="0"><span class="ico" style="background:var(--pink-soft)">🌰</span><div>Dầu hạnh nhân<small>Nuôi dưỡng sâu</small></div></div>
                <div class="chip bad" data-bad="paraben"><span class="ico">🧪</span><div>Paraben<small>Chất bảo quản</small></div></div>
                <div class="chip" data-ing="3"><span class="ico" style="background:#fce7f3"><img src="<?php echo esc_url(LX_THEME_URI . '/assets/img/dau-tam.svg'); ?>" alt="Dâu tằm" width="28" height="28"></span><div>Dâu tằm<small>Dịu mát &amp; dưỡng ẩm</small></div></div>
            </div>
            <div class="drop-zone" id="dropZone">
                <!-- Vòng phát sáng & chuyển động nghệ thuật quanh chai sữa tắm -->
                <div class="lab-ring-wrap" aria-hidden="true">
                    <div class="lab-ring-aura"></div>
                    <svg class="lab-ring-svg" viewBox="0 0 440 440">
                        <defs>
                            <linearGradient id="labRingGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#4cc0d3" stop-opacity="1"/>
                                <stop offset="40%" stop-color="#7ee4f4" stop-opacity="0.95"/>
                                <stop offset="80%" stop-color="#ffb5c8" stop-opacity="0.8"/>
                                <stop offset="100%" stop-color="#4cc0d3" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="labRingGrad2" x1="100%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#ff8fab" stop-opacity="1"/>
                                <stop offset="50%" stop-color="#ffe08a" stop-opacity="0.9"/>
                                <stop offset="100%" stop-color="#4cc0d3" stop-opacity="0.2"/>
                            </linearGradient>
                            <filter id="labRingGlow" x="-30%" y="-30%" width="160%" height="160%">
                                <feGaussianBlur stdDeviation="4" result="blur"/>
                                <feMerge>
                                    <feMergeNode in="blur"/>
                                    <feMergeNode in="SourceGraphic"/>
                                </feMerge>
                            </filter>
                        </defs>
                        <!-- Vòng tròn nền mờ mềm -->
                        <circle class="lring-bg" cx="220" cy="220" r="195"/>
                        <!-- Vòng quỹ đạo nét đứt thanh nhã ngược chiều kim đồng hồ -->
                        <circle class="lring-track-outer" cx="220" cy="220" r="202"/>
                        <!-- Vòng quỹ đạo nét đứt chính -->
                        <circle class="lring-track" cx="220" cy="220" r="185"/>
                        <!-- Vòng quỹ đạo phụ phía trong -->
                        <circle class="lring-track-inner" cx="220" cy="220" r="168"/>
                        <!-- Cung sáng chính chuyển màu chạy vòng quanh chai -->
                        <circle class="lring-arc lring-arc-1" cx="220" cy="220" r="185" filter="url(#labRingGlow)"/>
                        <circle class="lring-arc lring-arc-2" cx="220" cy="220" r="185" filter="url(#labRingGlow)"/>
                        <!-- Cung sáng hồng ngọc lướt ngược -->
                        <circle class="lring-arc lring-arc-pink" cx="220" cy="220" r="202" filter="url(#labRingGlow)"/>
                        <!-- Các hạt bong bóng phát sáng (ngọc trai) di chuyển quanh quỹ đạo -->
                        <circle class="lring-dot lring-dot-1" cx="405" cy="220" r="6.5" filter="url(#labRingGlow)"/>
                        <circle class="lring-dot lring-dot-2" cx="35" cy="220" r="5.5" filter="url(#labRingGlow)"/>
                        <circle class="lring-dot lring-dot-3" cx="220" cy="35" r="5" filter="url(#labRingGlow)"/>
                        <circle class="lring-dot lring-dot-4" cx="220" cy="405" r="4.5"/>
                        <!-- Hạt bong bóng nhỏ lấp lánh phụ trợ -->
                        <circle class="lring-sparkle sp-1" cx="360" cy="110" r="3.5"/>
                        <circle class="lring-sparkle sp-2" cx="80" cy="330" r="3"/>
                        <circle class="lring-sparkle sp-3" cx="100" cy="130" r="3.5"/>
                        <circle class="lring-sparkle sp-4" cx="340" cy="330" r="3"/>
                    </svg>
                </div>
                <div class="lab-bottle" id="labBottle">
                    <img src="<?php echo esc_url($bottle_img); ?>" alt="Sữa tắm gội Bon Bon 500ml" width="827" height="2000" draggable="false" loading="lazy">
                </div>
                <div class="lab-meter">Công thức: <span id="labCount">0</span>/4<div class="bar"><i id="labBar"></i></div></div>
            </div>
            <div class="chips chips-right">
                <div class="chip" data-ing="1"><span class="ico" style="background:#ece6ff">💊</span><div>Vitamin E<small>Chống oxy hóa</small></div></div>
                <div class="chip bad" data-bad="sulfate"><span class="ico">🚫</span><div>Gốc Sunfat<small>Chất tẩy rửa mạnh</small></div></div>
                <div class="chip" data-ing="2"><span class="ico" style="background:var(--primary-light)">💧</span><div>Aqua &amp; SLES dịu nhẹ<small>Làm sạch nhẹ nhàng</small></div></div>
            </div>
        </div>
        <div class="lab-info" id="labInfo" data-reveal>
            <span class="ico">👆</span>
            <div><h4>Bắt đầu nào!</h4><p>Kéo một thành phần vào lọ Bon Bon để xem công dụng của nó với làn da bé.</p></div>
        </div>
        <div class="lab-done" id="labDone">
            <a href="#dang-ky" class="btn btn-primary js-scroll">🎉 Hoàn thành! Nhận tư vấn &amp; quà ngay</a>
        </div>
    </div>
</section>
