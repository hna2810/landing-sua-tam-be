<?php
/**
 * Order Form & Offer Section Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$offer_badge = lx_get_field('lx_offer_badge', 'option', 'ƯU ĐÃI TẶNG MẸ');
$bottle_img  = lx_get_image_url('lx_offer_bottle_img', LX_THEME_URI . '/assets/img/sua-tam-goi-bon-bon-500ml.webp');
$lion_img    = lx_get_image_url('lx_offer_lion_img', LX_THEME_URI . '/assets/img/su-tu-bon-bon.webp');
?>
<!-- ===== FORM ĐẶT HÀNG ===== -->
<section class="section form-sec" id="dang-ky">
    <span class="fs-bub b1"></span><span class="fs-bub b2"></span><span class="fs-bub b3"></span><span class="fs-bub b4"></span><span class="fs-bub b5"></span>
    <div class="container order-wrap">
        <div class="order-side" data-reveal>
            <?php if (!empty($offer_badge)) : ?>
                <h2 class="order-title"><?php echo esc_html($offer_badge); ?></h2>
            <?php endif; ?>
            <div class="order-price"><b id="opPrice">—</b><s id="opOld"></s><span class="order-off" id="opOff" hidden></span></div>
            <div class="order-cd">
                <span class="lbl">⏰ Ưu đãi kết thúc sau:</span>
                <div class="cd-row">
                    <div class="cd-box"><b id="cdH">00</b><small>GIỜ</small></div><i>:</i>
                    <div class="cd-box"><b id="cdM">00</b><small>PHÚT</small></div><i>:</i>
                    <div class="cd-box"><b id="cdS">00</b><small>GIÂY</small></div>
                </div>
            </div>
            <div class="order-img">
                <span class="order-glow"></span>
                <?php if (!empty($bottle_img)) : ?>
                    <img class="oi-bottle" src="<?php echo esc_url($bottle_img); ?>" alt="Sữa tắm gội Bon Bon 500ml" width="827" height="2000" loading="lazy">
                <?php endif; ?>
                <?php if (!empty($lion_img)) : ?>
                    <img class="oi-lion" src="<?php echo esc_url($lion_img); ?>" alt="Sư tử Bon Bon" width="400" height="400" loading="lazy">
                <?php endif; ?>
            </div>
            <ul class="order-trust">
                <li>🚚 Giao hàng toàn quốc</li>
                <li>💬 Tư vấn miễn phí</li>
                <li>✅ Chính hãng Home Care</li>
            </ul>
        </div>

        <div class="order-card" data-reveal>
            <!-- Banner Quà tặng vòng quay may mắn trên đầu form -->
            <div class="order-gift-banner" id="orderGiftBanner">
                <div class="gift-banner-left">
                    <span class="gift-banner-badge">🎁 QUÀ TẶNG VÒNG QUAY</span>
                    <div class="gift-banner-main">
                        <span class="gift-banner-ico">🎉</span>
                        <div class="gift-banner-info">
                            <span class="gift-banner-lbl">Quà tặng của mẹ:</span>
                            <strong class="gift-banner-name" id="orderGiftText">Vịt tắm cute</strong>
                        </div>
                    </div>
                </div>
                <a href="#vong-quay" class="btn-change-gift js-scroll" id="btnChangeGift">Đổi quà 🎡</a>
            </div>

            <div id="formContent">
                <form id="leadForm" novalidate>
                    <div class="field">
                        <label for="fName">Họ tên <em>*</em></label>
                        <input class="input" id="fName" name="name" type="text" autocomplete="name" placeholder="VD: Nguyễn Thị Lan">
                        <div class="err" id="eName">Mẹ ơi, cho Bon Bon xin tên nhé!</div>
                    </div>
                    <div class="field">
                        <label for="fPhone">Số điện thoại <em>*</em></label>
                        <input class="input" id="fPhone" name="phone" type="tel" inputmode="numeric" autocomplete="tel" placeholder="VD: 0901 234 567">
                        <div class="err" id="ePhone">Số điện thoại chưa đúng (10 số, bắt đầu bằng 0).</div>
                    </div>
                    <div class="field">
                        <label for="fAddr">Địa chỉ nhận hàng</label>
                        <input class="input" id="fAddr" name="address" type="text" autocomplete="street-address" placeholder="VD: Số 123, đường ABC, Hà Nội">
                    </div>
                    <!-- Trường quà tặng người dùng quay được đưa vào form -->
                    <div class="field field-gift">
                        <label for="fGiftDisplay">🎁 Quà tặng kèm theo đơn</label>
                        <div class="gift-field-box">
                            <span class="gift-field-ico">🎁</span>
                            <input class="input input-gift" id="fGiftDisplay" type="text" readonly value="Vịt tắm cute" aria-label="Quà tặng kèm theo đơn">
                            <span class="gift-tag-free">MIỄN PHÍ</span>
                        </div>
                    </div>
                    <input type="hidden" name="gift" id="hGift" value="Vịt tắm cute">
                    <input type="hidden" name="source" id="hSource">
                    <button type="submit" class="btn btn-pink btn-block order-btn" id="submitBtn"><span class="wiggle">🎁</span> ĐẶT HÀNG NGAY!</button>
                    <p class="consent">🔒 Thông tin của mẹ được bảo mật, Home Care gọi xác nhận trước khi giao hàng.</p>
                </form>
            </div>
            <div class="form-success" id="formSuccess">
                <span class="big">🥳</span>
                <h3>Đặt hàng thành công!</h3>
                <p>Cảm ơn mẹ <b id="sName"></b>. Home Care sẽ gọi số <b id="sPhone"></b> để xác nhận đơn <b id="sPkg"></b> sớm nhất nhé!</p>
                <a href="#" class="btn btn-primary" data-zalo target="_blank" rel="noopener">💬 Chat Zalo với Home Care</a>
            </div>
        </div>
    </div>
</section>
