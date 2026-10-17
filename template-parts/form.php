<?php if (!defined('ABSPATH')) exit; ?>
<!-- ===== FORM ===== -->
<section class="section form-sec" id="dang-ky">
    <div class="container form-wrap">
        <div class="form-side" data-reveal>
            <span class="eyebrow">🎀 Ưu đãi dành riêng cho mẹ</span>
            <h2>Đăng ký nhận <span class="hl">tư vấn &amp; quà</span> miễn phí</h2>
            <p class="section-sub">Chỉ mất 20 giây. Chuyên viên Home Care sẽ gọi lại tư vấn cách chăm da phù hợp cho bé.</p>
            <ul class="gift-list">
                <li><span class="e">👩‍⚕️</span><div>Tư vấn 1-1 miễn phí<small>Chăm sóc da theo độ tuổi của bé</small></div></li>
                <li><span class="e">🎁</span><div>Quà tặng kèm hấp dẫn<small>Kèm phần quà từ vòng quay may mắn</small></div></li>
                <li><span class="e">🚚</span><div>Giao hàng toàn quốc<small>Kiểm tra hàng trước khi thanh toán</small></div></li>
            </ul>
            <div class="countdown" id="countdown">
                <span class="lbl">⏰ Ưu đãi hôm nay kết thúc sau:</span>
                <div class="cd-box"><b id="cdH">00</b><small>Giờ</small></div>
                <div class="cd-box"><b id="cdM">00</b><small>Phút</small></div>
                <div class="cd-box"><b id="cdS">00</b><small>Giây</small></div>
            </div>
        </div>

        <div class="form-card" data-reveal>
            <div id="formContent">
                <h3>Nhận quà cho bé 🎁</h3>
                <p class="sub">Điền thông tin, Home Care gọi lại ngay!</p>
                <div class="won-banner" id="wonBanner">🎉 <span>Quà của mẹ: <b id="wonText"></b></span></div>
                <form id="leadForm" novalidate>
                    <div class="field">
                        <label for="fName">Họ tên mẹ <em>*</em></label>
                        <input class="input" id="fName" name="name" type="text" autocomplete="name" placeholder="VD: Nguyễn Thu Hà">
                        <div class="err" id="eName">Mẹ ơi, cho Bon Bon xin tên nhé!</div>
                    </div>
                    <div class="field">
                        <label for="fPhone">Số điện thoại <em>*</em></label>
                        <input class="input" id="fPhone" name="phone" type="tel" inputmode="numeric" autocomplete="tel" placeholder="VD: 0901 234 567">
                        <div class="err" id="ePhone">Số điện thoại chưa đúng (10 số, bắt đầu bằng 0).</div>
                    </div>
                    <div class="field">
                        <span class="lbl">Bé nhà mẹ bao nhiêu tuổi?</span>
                        <div class="chip-row" id="ageRow">
                            <label class="chip-opt"><input type="radio" name="baby_age" value="0-6 tháng"><span>👶 0-6 tháng</span></label>
                            <label class="chip-opt"><input type="radio" name="baby_age" value="6-12 tháng"><span>🍼 6-12 tháng</span></label>
                            <label class="chip-opt"><input type="radio" name="baby_age" value="1-3 tuổi"><span>🧸 1-3 tuổi</span></label>
                            <label class="chip-opt"><input type="radio" name="baby_age" value="Trên 3 tuổi"><span>🎒 Trên 3 tuổi</span></label>
                        </div>
                    </div>
                    <div class="field">
                        <span class="lbl">Mẹ đang quan tâm điều gì? <small style="font-weight:600;color:var(--text-soft)">(chọn nhiều)</small></span>
                        <div class="chip-row" id="concernRow">
                            <label class="chip-opt"><input type="checkbox" name="concern" value="Cứt trâu"><span>👶 Cứt trâu</span></label>
                            <label class="chip-opt"><input type="checkbox" name="concern" value="Rôm sảy"><span>🥵 Rôm sảy</span></label>
                            <label class="chip-opt"><input type="checkbox" name="concern" value="Da khô"><span>🌵 Da khô</span></label>
                            <label class="chip-opt"><input type="checkbox" name="concern" value="Da nhạy cảm"><span>🥺 Da nhạy cảm</span></label>
                            <label class="chip-opt"><input type="checkbox" name="concern" value="Cay mắt khi gội"><span>😭 Cay mắt khi gội</span></label>
                            <label class="chip-opt"><input type="checkbox" name="concern" value="Tìm sữa tắm 2in1"><span><i class="bb"></i> Tìm loại 2in1</span></label>
                        </div>
                    </div>
                    <div class="field">
                        <label for="fTime">Thời gian thuận tiện để gọi</label>
                        <select class="input" id="fTime" name="call_time">
                            <option value="Bất kỳ lúc nào">Bất kỳ lúc nào</option>
                            <option value="Sáng (8h-11h)">Sáng (8h - 11h)</option>
                            <option value="Trưa (11h-14h)">Trưa (11h - 14h)</option>
                            <option value="Chiều (14h-18h)">Chiều (14h - 18h)</option>
                            <option value="Tối (18h-21h)">Tối (18h - 21h)</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="fNote">Mẹ muốn hỏi thêm gì không?</label>
                        <textarea class="input" id="fNote" name="note" placeholder="VD: Bé hay bị rôm sảy ở lưng..."></textarea>
                    </div>
                    <input type="hidden" name="quiz_result" id="hQuiz">
                    <input type="hidden" name="gift" id="hGift">
                    <input type="hidden" name="source" id="hSource">
                    <button type="submit" class="btn btn-primary btn-block" id="submitBtn"><span class="wiggle">🎁</span> NHẬN TƯ VẤN &amp; QUÀ NGAY</button>
                    <p class="consent">🔒 Thông tin của mẹ được bảo mật và chỉ dùng để tư vấn sản phẩm.</p>
                </form>
            </div>
            <div class="form-success" id="formSuccess">
                <span class="big">🥳</span>
                <h3>Đăng ký thành công!</h3>
                <p>Cảm ơn mẹ <b id="sName"></b>. Chuyên viên Home Care sẽ gọi lại số <b id="sPhone"></b> sớm nhất để tư vấn và xác nhận quà cho bé nhé!</p>
                <a href="#" class="btn btn-primary" data-zalo target="_blank" rel="noopener">💬 Chat Zalo để được tư vấn ngay</a>
            </div>
        </div>
    </div>
</section>
