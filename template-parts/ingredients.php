<?php if (!defined('ABSPATH')) exit; ?>
<!-- ===== INGREDIENTS GAME ===== -->
<section class="section ingre" id="thanh-phan">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">🧪 Mini game: Pha chế Bon Bon</span>
            <h2 class="section-title">Kéo thành phần <span class="hl">vào lọ</span> nào!</h2>
            <p class="section-sub">Kéo (hoặc chạm) từng thành phần vào lọ để khám phá công thức. Cẩn thận, có một "kẻ lạ mặt" mà Bon Bon không chào đón đâu nhé 😉</p>
        </div>
        <div class="lab" id="lab">
            <div class="chips chips-left">
                <div class="chip" data-ing="0"><span class="ico" style="background:var(--pink-soft)">🌰</span><div>Dầu hạnh nhân<small>Nuôi dưỡng sâu</small></div></div>
                <div class="chip bad" data-ing="3"><span class="ico">🧪</span><div>Paraben<small>Chất bảo quản</small></div></div>
            </div>
            <div class="drop-zone" id="dropZone">
                <div class="drop-ring"></div>
                <div class="lab-bottle" id="labBottle" data-bottle="lab"></div>
                <div class="lab-meter">Công thức: <span id="labCount">0</span>/3<div class="bar"><i id="labBar"></i></div></div>
            </div>
            <div class="chips chips-right">
                <div class="chip" data-ing="1"><span class="ico" style="background:#ece6ff">💊</span><div>Vitamin E<small>Chống oxy hóa</small></div></div>
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
        <p class="lab-note">* Thành phần nổi bật, xem nhãn sản phẩm để biết bảng thành phần đầy đủ.</p>
    </div>
</section>
