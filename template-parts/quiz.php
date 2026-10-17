<?php if (!defined('ABSPATH')) exit; ?>
<!-- ===== QUIZ ===== -->
<section class="section quiz-sec" id="quiz">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">🧸 Quiz 30 giây</span>
            <h2 class="section-title">Da bé nhà mình <span class="hl">cần gì?</span></h2>
            <p class="section-sub">Trả lời 4 câu hỏi nhỏ để nhận gợi ý chăm da phù hợp cho bé và ưu đãi riêng.</p>
        </div>
        <div class="quiz" id="quizBox" data-reveal>
            <div class="quiz-top"><span id="qLabel">Câu 1/4</span><div class="quiz-bar"><i id="qBar"></i></div><span>🎁</span></div>

            <div class="q-step active" data-q="age">
                <h3>Bé nhà mẹ bao nhiêu tuổi?</h3>
                <div class="q-opts">
                    <button class="q-opt" data-v="0-6 tháng"><span class="e">👶</span>0 - 6 tháng</button>
                    <button class="q-opt" data-v="6-12 tháng"><span class="e">🍼</span>6 - 12 tháng</button>
                    <button class="q-opt" data-v="1-3 tuổi"><span class="e">🧸</span>1 - 3 tuổi</button>
                    <button class="q-opt" data-v="Trên 3 tuổi"><span class="e">🎒</span>Trên 3 tuổi</button>
                </div>
            </div>
            <div class="q-step" data-q="skin">
                <h3>Da bé hay gặp tình trạng nào nhất?</h3>
                <div class="q-opts">
                    <button class="q-opt" data-v="Cứt trâu" data-t="cradle"><span class="e">👶</span>Cứt trâu, màng ối</button>
                    <button class="q-opt" data-v="Da khô" data-t="dry"><span class="e">🌵</span>Da khô, sần</button>
                    <button class="q-opt" data-v="Da nhạy cảm" data-t="sensitive"><span class="e">🥺</span>Dễ kích ứng</button>
                    <button class="q-opt" data-v="Da bình thường" data-t="normal"><span class="e">😊</span>Bình thường</button>
                </div>
            </div>
            <div class="q-step" data-q="bath">
                <h3>Khi gội đầu, bé thường...</h3>
                <div class="q-opts">
                    <button class="q-opt" data-v="Khóc, sợ cay mắt"><span class="e">😭</span>Khóc vì cay mắt</button>
                    <button class="q-opt" data-v="Hơi quấy"><span class="e">😕</span>Hơi quấy một chút</button>
                    <button class="q-opt" data-v="Hợp tác"><span class="e">😄</span>Hợp tác vui vẻ</button>
                    <button class="q-opt" data-v="Chưa gội thường xuyên"><span class="e">🤷</span>Ít khi gội</button>
                </div>
            </div>
            <div class="q-step" data-q="priority">
                <h3>Mẹ ưu tiên điều gì nhất ở sữa tắm?</h3>
                <div class="q-opts">
                    <button class="q-opt" data-v="An toàn, dịu nhẹ"><span class="e">🛡️</span>An toàn, dịu nhẹ</button>
                    <button class="q-opt" data-v="Tiện lợi 2in1"><span class="e">⚡</span>Tiện lợi 2in1</button>
                    <button class="q-opt" data-v="Mùi thơm dễ chịu"><span class="e">🌸</span>Mùi thơm dễ chịu</button>
                    <button class="q-opt" data-v="Giá hợp lý"><span class="e">💰</span>Giá hợp lý</button>
                </div>
            </div>

            <div class="q-loading" id="qLoading"><span class="spin"><i class="bb"></i></span><h3 style="margin-top:14px">Đang phân tích làn da bé...</h3></div>

            <div class="q-result" id="qResult">
                <span class="badge" id="rEmoji">🌸</span>
                <h3 id="rTitle">Bé có làn da nhạy cảm</h3>
                <span class="type" id="rType">Cần làm sạch dịu nhẹ</span>
                <ul class="q-tips" id="rTips"></ul>
                <a href="#dang-ky" class="btn btn-primary btn-block js-scroll">🎁 Nhận tư vấn riêng cho bé &amp; quà tặng</a>
                <button class="q-back" id="qRestart" style="display:block;margin:16px auto 0">↺ Làm lại quiz</button>
            </div>
            <button class="q-back" id="qBack" style="display:none">← Quay lại</button>
        </div>
    </div>
</section>
