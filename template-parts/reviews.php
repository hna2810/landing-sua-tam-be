<?php
/**
 * Customer Reviews Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$title = lx_get_field('lx_reviews_title', 'option', 'ĐÁNH GIÁ <span class="hl">SẢN PHẨM</span>');
?>
<!-- ===== ĐÁNH GIÁ SẢN PHẨM ===== -->
<section class="section rv" id="danh-gia-sp">
    <div class="container">
        <div class="section-head" data-reveal>
            <?php if (!empty($title)) : ?>
                <h2 class="section-title rv-title"><?php echo $title; ?></h2>
            <?php endif; ?>
            <svg class="rv-wave" viewBox="0 0 80 14" aria-hidden="true"><path d="M2 7 Q 12 0 22 7 T 42 7 T 62 7 T 78 7" fill="none" stroke="#4cc0d3" stroke-width="3.5" stroke-linecap="round"/></svg>
        </div>
        <div class="rv-bar" data-reveal>
            <div class="rv-score"><b id="rvAvg">0</b><span>trên 5</span><i class="rv-stars" id="rvAvgStars"></i></div>
            <div class="rv-filters" id="rvFilters"></div>
        </div>
        <p class="rv-sample-note" id="rvSampleNote" hidden>⚠️ Đang hiển thị đánh giá mẫu. Thay bằng đánh giá thật của khách trong <code>CONFIG.reviews</code> trước khi chạy quảng cáo.</p>
        <div class="rv-grid" id="rvGrid"></div>
        <div class="rv-more"><button class="btn btn-ghost" type="button" id="rvMore" hidden>Xem thêm đánh giá</button></div>
    </div>
</section>
