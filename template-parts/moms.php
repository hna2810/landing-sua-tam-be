<?php
/**
 * Moms Video Reviews Template (TikTok / Reels Short-Form Video Showcase)
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$eyebrow    = lx_get_field('lx_moms_eyebrow', 'option', '🎬 Video Trải Nghiệm');
$title      = lx_get_field('lx_moms_title', 'option', 'Khoảnh khắc bé yêu & <span class="hl">Review từ các Mẹ</span>');
$sub        = lx_get_field('lx_moms_sub', 'option', 'Chạm vào video để xem · Bấm tim ❤️ hoặc chạm 2 lần để thả tim cho các bé mẹ nhé!');
$acf_videos = lx_get_field('lx_moms_videos', 'option', '__NOT_SET__');

$default_reels = array(
    array(
        'name'        => 'Mẹ Mai (Bé Bơ 4 tháng)',
        'quote'       => 'Bé da nhạy cảm mà dùng Bon Bon êm ru, tắm xong da mềm mướt không hề bị khô rít!',
        'likes'       => 3420,
        'likes_fmt'   => '3.4K',
        'badge'       => '👶 Bé 4 tháng',
        'video_url'   => '',
        'poster'      => '',
        'bg_gradient' => 'linear-gradient(160deg, #d8f1f5 0%, #b3e9f2 100%)',
    ),
    array(
        'name'        => 'Mẹ Quỳnh (Bé Sóc 2 tháng)',
        'quote'       => 'Bọt dính trán bé vẫn cười toe toét, không cay mắt tí nào. Cực kỳ an tâm cho trẻ sơ sinh ❤️',
        'likes'       => 4150,
        'likes_fmt'   => '4.1K',
        'badge'       => '✨ Không cay mắt',
        'video_url'   => '',
        'poster'      => '',
        'bg_gradient' => 'linear-gradient(160deg, #ffe5ec 0%, #ffc0d3 100%)',
    ),
    array(
        'name'        => 'Mẹ Thảo (Bé Tít 6 tháng)',
        'quote'       => 'Gội 4-5 lần là sạch bong mảng cứt trâu trên đầu con, da đầu sạch thơm dịu nhẹ mê ly!',
        'likes'       => 2890,
        'likes_fmt'   => '2.9K',
        'badge'       => '🌿 Sạch cứt trâu',
        'video_url'   => '',
        'poster'      => '',
        'bg_gradient' => 'linear-gradient(160deg, #fff7d6 0%, #ffe99e 100%)',
    ),
    array(
        'name'        => 'Mẹ Lan (Bé Gấu 3 tháng)',
        'quote'       => 'Chai 500ml bự chảng dùng mãi chưa hết nửa chai, tính ra mỗi ngày chưa tới 2.000đ!',
        'likes'       => 5210,
        'likes_fmt'   => '5.2K',
        'badge'       => '🧴 Siêu tiết kiệm',
        'video_url'   => '',
        'poster'      => '',
        'bg_gradient' => 'linear-gradient(160deg, #e4faf0 0%, #bdf6dc 100%)',
    ),
);

$reels = array();
if ($acf_videos === '__NOT_SET__') {
    $reels = $default_reels;
} elseif (!empty($acf_videos) && is_array($acf_videos)) {
    foreach ($acf_videos as $idx => $v) {
        if (!empty($v['video_url']) || !empty($v['name'])) {
            $base = isset($default_reels[$idx]) ? $default_reels[$idx] : $default_reels[0];
            $likes = !empty($v['likes']) ? (int)$v['likes'] : (2500 + $idx * 650);
            $reels[] = array(
                'name'        => !empty($v['name']) ? $v['name'] : $base['name'],
                'quote'       => !empty($v['quote']) ? $v['quote'] : $base['quote'],
                'likes'       => $likes,
                'likes_fmt'   => ($likes >= 1000) ? (round($likes / 1000, 1) . 'K') : (string)$likes,
                'badge'       => !empty($v['baby']) ? ('👶 ' . $v['baby']) : $base['badge'],
                'video_url'   => !empty($v['video_url']) ? $v['video_url'] : '',
                'poster'      => !empty($v['poster']) ? $v['poster'] : '',
                'bg_gradient' => $base['bg_gradient'],
            );
        }
    }
}

if (empty($reels) && empty($title)) {
    return;
}
?>
<!-- ===== SECTION 9: CẢM NHẬN CỦA CÁC MOM (REELS SHOWCASE GỌN ĐẸP) ===== -->
<section class="section moms reels-section" id="cam-nhan">
    <div class="container">
        <?php if (!empty($eyebrow) || !empty($title) || !empty($sub)) : ?>
            <div class="section-head" data-reveal>
                <?php if (!empty($eyebrow)) : ?>
                    <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if (!empty($title)) : ?>
                    <h2 class="section-title"><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php if (!empty($sub)) : ?>
                    <p class="section-sub"><?php echo esc_html($sub); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="reels-slider-wrap" data-reveal>
            <button type="button" class="reel-nav prev" id="reelPrev" aria-label="Xem video trước">❮</button>
            <button type="button" class="reel-nav next" id="reelNext" aria-label="Xem video tiếp">❯</button>

            <div class="mom-row reels-track" id="reelsTrack">
                <?php foreach ($reels as $idx => $r) : ?>
                    <div class="mom-card reel-card" data-reel-index="<?php echo $idx; ?>">
                        <div class="reel-video-container" style="background: <?php echo esc_attr($r['bg_gradient']); ?>;">
                            <!-- Top Bar: Badge & Sound Toggle -->
                            <div class="reel-top-bar">
                                <span class="reel-badge"><?php echo esc_html($r['badge']); ?></span>
                                <button type="button" class="reel-sound-btn js-reel-sound" aria-label="Bật/Tắt âm thanh" title="Bật/Tắt âm">
                                    <span class="sound-icon">🔇</span>
                                </button>
                            </div>

                            <!-- Video Element or Ambient Animated Poster -->
                            <?php if (!empty($r['video_url'])) : ?>
                                <video class="reel-video-el js-reel-video" src="<?php echo esc_url($r['video_url']); ?>" <?php if (!empty($r['poster'])) : ?>poster="<?php echo esc_url($r['poster']); ?>"<?php endif; ?> playsinline loop muted preload="metadata"></video>
                            <?php else : ?>
                                <div class="reel-ambient-bg">
                                    <span class="ambient-bubble b1"></span>
                                    <span class="ambient-bubble b2"></span>
                                    <span class="ambient-bubble b3"></span>
                                    <div class="ambient-baby-badge">
                                        <span class="baby-emoji">👶</span>
                                        <span class="ambient-pulse"></span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Center Play/Pause Button -->
                            <button type="button" class="reel-play-btn js-reel-play" aria-label="Phát video">
                                <span class="play-icon">▶</span>
                            </button>

                            <!-- Big Double Tap Heart Animation -->
                            <div class="reel-big-heart" aria-hidden="true">❤️</div>

                            <!-- Floating Like Button (Góc phải dưới, tinh gọn) -->
                            <div class="reel-like-wrap">
                                <button type="button" class="reel-action-btn btn-like js-reel-like" data-count="<?php echo esc_attr($r['likes']); ?>" data-liked="false" aria-label="Thả tim">
                                    <span class="action-icon heart-icon">🤍</span>
                                    <span class="action-count count-like"><?php echo esc_html($r['likes_fmt']); ?></span>
                                </button>
                            </div>

                            <!-- Bottom Info: Tinh gọn, chỉ tên mẹ + review 2 dòng, cực kỳ thoáng -->
                            <div class="reel-bottom-info">
                                <div class="reel-author-line">
                                    <b class="reel-author-name"><?php echo esc_html($r['name']); ?></b>
                                    <span class="reel-stars" title="5 sao">⭐⭐⭐⭐⭐</span>
                                </div>
                                <p class="reel-caption"><?php echo esc_html($r['quote']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
