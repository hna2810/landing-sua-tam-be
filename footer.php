<?php
/**
 * Footer Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
</main>

<footer class="footer">
    <div class="container footer-grid">
        <div>
            <h4>Home Care Việt Nam</h4>
            <p>Sản phẩm chăm sóc mẹ &amp; bé dịu nhẹ, an toàn. Đồng hành cùng mẹ trong từng khoảnh khắc chăm con.</p>
            <p style="margin-top:10px">Sữa tắm gội Bon Bon 500ml · Số công bố: 64/26/CBMP-NB</p>
        </div>
        <div>
            <h4>Liên hệ</h4>
            <p>📞 Hotline: <a href="#" data-tel data-tel-text>0901.234.567</a></p>
            <p>🌐 <a href="https://homecarevietnam.com" target="_blank" rel="noopener">homecarevietnam.com</a></p>
        </div>
        <div>
            <h4>Khám phá</h4>
            <p><a href="#quiz" class="js-scroll">Quiz da bé</a></p>
            <p><a href="#vong-quay" class="js-scroll">Vòng quay quà tặng</a></p>
            <p><a href="#dang-ky" class="js-scroll">Đăng ký tư vấn</a></p>
        </div>
    </div>
    <div class="container footer-bottom">© <span id="year"></span> Home Care Việt Nam. Sản phẩm này không phải là thuốc và không có tác dụng thay thế thuốc chữa bệnh.</div>
</footer>

<!-- Floating -->
<div class="float-btns">
    <a href="#" class="float-btn phone" data-tel title="Gọi ngay">📞</a>
    <a href="#" class="float-btn zalo" data-zalo target="_blank" rel="noopener" title="Chat Zalo">Zalo</a>
</div>
<div class="sticky-bar" id="stickyBar">
    <a href="#" class="btn call" data-tel aria-label="Gọi hotline">📞</a>
    <a href="#dang-ky" class="btn btn-primary go js-scroll"><span class="wiggle">🎁</span> Nhận tư vấn &amp; quà</a>
</div>
<div class="toast" id="toast"></div>


<?php wp_footer(); ?>
</body>
</html>
