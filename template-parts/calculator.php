<?php
/**
 * Savings Calculator Template: "Thước đo tiết kiệm cho mẹ"
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$eyebrow     = lx_get_field('lx_calc_eyebrow', 'option', '💡 Thước đo chi tiêu thông minh');
$title       = lx_get_field('lx_calc_title', 'option', 'Bé dùng được bao lâu? <span class="hl">Tiết kiệm bao nhiêu?</span>');
$sub         = lx_get_field('lx_calc_sub', 'option', 'Chỉ với 1 chai Bon Bon 500ml – Mẹ cùng tính bài toán kinh tế thông minh cho con nhé!');
$price       = (int)lx_get_field('lx_calc_price', 'option', 265000);
$bottle_size = (int)lx_get_field('lx_calc_volume', 'option', 500);
?>
<!-- ===== THƯỚC ĐO TIẾT KIỆM CHO MẸ ===== -->
<section class="section calc-sec" id="tiet-kiem" data-bottle-price="<?php echo esc_attr($price); ?>" data-bottle-ml="<?php echo esc_attr($bottle_size); ?>">
    <div class="container">
        <div class="calc-box" data-reveal>
            <!-- Decorative badge & header -->
            <div class="section-head text-center">
                <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <h2 class="section-title"><?php echo $title; ?></h2>
                <p class="section-sub"><?php echo esc_html($sub); ?></p>
            </div>

            <div class="calc-grid">
                <!-- Left: Controls -->
                <div class="calc-controls">
                    <!-- 1. Age Selection -->
                    <div class="calc-group">
                        <label class="calc-label">
                            <span class="step-num">1</span> Chọn độ tuổi của bé yêu:
                        </label>
                        <div class="calc-age-pills" id="calcAgePills">
                            <button type="button" class="age-pill active" data-age="baby" data-ml="2.5">
                                <span class="age-emoji">👶</span>
                                <div class="age-info">
                                    <strong class="age-title">Sơ sinh</strong>
                                    <span class="age-sub">0 - 6 tháng (1 pump)</span>
                                </div>
                            </button>
                            <button type="button" class="age-pill" data-age="toddler" data-ml="3.5">
                                <span class="age-emoji">🍼</span>
                                <div class="age-info">
                                    <strong class="age-title">Bé tập bò</strong>
                                    <span class="age-sub">6 - 18 tháng (1.5 pump)</span>
                                </div>
                            </button>
                            <button type="button" class="age-pill" data-age="kid" data-ml="5.0">
                                <span class="age-emoji">🏃</span>
                                <div class="age-info">
                                    <strong class="age-title">Bé lớn</strong>
                                    <span class="age-sub">> 18 tháng (2 pumps)</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Bathing Frequency Slider -->
                    <div class="calc-group">
                        <div class="calc-label-row">
                            <label class="calc-label" for="calcFreqSlider">
                                <span class="step-num">2</span> Tần suất tắm mỗi tuần:
                            </label>
                            <span class="calc-freq-badge" id="calcFreqDisplay">7 lần / tuần (Mỗi ngày)</span>
                        </div>
                        <div class="calc-slider-wrap">
                            <input type="range" id="calcFreqSlider" min="3" max="7" value="7" step="1" class="calc-range" aria-label="Tần suất tắm">
                            <div class="calc-range-ticks">
                                <span>3 lần</span>
                                <span>4 lần</span>
                                <span>5 lần</span>
                                <span>6 lần</span>
                                <span>Mỗi ngày</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottle spec highlight -->
                    <div class="calc-spec-pill">
                        <span class="spec-ico">🧴</span>
                        <div class="spec-txt">
                            <b>Dung tích chuẩn 500ml</b> có vòi pump thông minh giúp mẹ lấy đúng lượng dùng, không sợ đổ thừa lãng phí!
                        </div>
                    </div>
                </div>

                <!-- Right: Results Card -->
                <div class="calc-results">
                    <div class="res-card-main">
                        <div class="res-card-badge">✨ KẾT QUẢ TÍNH TOÁN</div>

                        <!-- Metric 1: Duration -->
                        <div class="res-item duration">
                            <div class="res-ico">⏳</div>
                            <div class="res-info">
                                <span class="res-lbl">1 chai 500ml dùng được trong:</span>
                                <div class="res-val-big"><b id="resMonths">5.0</b> <span class="unit">Tháng</span></div>
                                <span class="res-sub-note" id="resBathsNote">(Khoảng ~142 lần tắm gội thơm tho)</span>
                            </div>
                        </div>

                        <div class="res-divider"></div>

                        <!-- Metric 2: Daily Cost -->
                        <div class="res-item cost">
                            <div class="res-ico">💰</div>
                            <div class="res-info">
                                <span class="res-lbl">Chi phí mỗi ngày chăm sóc bé:</span>
                                <div class="res-val-price"><b id="resDailyCost">1.750</b> <span class="unit">đ / ngày</span></div>
                                <span class="res-sub-note">Rẻ hơn 1 chiếc kẹo mút cho con!</span>
                            </div>
                        </div>

                        <div class="res-divider"></div>

                        <!-- Metric 3: Savings compared to 3 single products -->
                        <div class="res-item savings">
                            <div class="res-ico">🎁</div>
                            <div class="res-info">
                                <span class="res-lbl">Tiết kiệm nhờ công thức 3in1:</span>
                                <div class="res-val-save"><b id="resSavings">155.000</b> <span class="unit">đ</span></div>
                                <span class="res-sub-note">Thay thế trọn bộ Sữa tắm + Dầu gội + Dưỡng ẩm</span>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <a href="#dang-ky" class="btn btn-primary calc-cta js-scroll">
                            <span class="wiggle">🎁</span> NHẬN NGAY ƯU ĐÃI TIẾT KIỆM
                        </a>

                        <div class="res-guarantee">
                            <span>✓ Đổi trả 7 ngày</span>
                            <span>✓ Kiểm tra hàng trước khi nhận</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
