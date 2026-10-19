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
        'quote'       => '',
        'likes'       => 12800,
        'likes_fmt'   => '12.8K',
        'badge'       => '',
        'video_url'   => '',
        'poster'      => '',
        'bg_gradient' => 'linear-gradient(160deg, #d8f1f5 0%, #b3e9f2 100%)',
    ),
    array(
        'name'        => 'Mẹ Quỳnh (Bé Sóc 2 tháng)',
        'quote'       => '',
        'likes'       => 15400,
        'likes_fmt'   => '15.4K',
        'badge'       => '',
        'video_url'   => '',
        'poster'      => '',
        'bg_gradient' => 'linear-gradient(160deg, #ffe5ec 0%, #ffc0d3 100%)',
    ),
    array(
        'name'        => 'Mẹ Thảo (Bé Tít 6 tháng)',
        'quote'       => '',
        'likes'       => 18600,
        'likes_fmt'   => '18.6K',
        'badge'       => '',
        'video_url'   => '',
        'poster'      => '',
        'bg_gradient' => 'linear-gradient(160deg, #fff7d6 0%, #ffe99e 100%)',
    ),
    array(
        'name'        => 'Mẹ Lan (Bé Gấu 3 tháng)',
        'quote'       => '',
        'likes'       => 14200,
        'likes_fmt'   => '14.2K',
        'badge'       => '',
        'video_url'   => '',
        'poster'      => '',
        'bg_gradient' => 'linear-gradient(160deg, #e4faf0 0%, #bdf6dc 100%)',
    ),
);

$acf_videos = lx_get_field('lx_moms_videos', 'option', array());
$reels = array();
if (!empty($acf_videos) && is_array($acf_videos)) {
    foreach ($acf_videos as $idx => $v) {
        if (!empty($v['video_url']) || !empty($v['name'])) {
            $base = isset($default_reels[$idx]) ? $default_reels[$idx] : $default_reels[0];
            $raw_likes = !empty($v['likes']) ? (int)$v['likes'] : 0;
            // Đảm bảo số tim luôn trên 10K theo yêu cầu
            if ($raw_likes < 10000) {
                $likes = 12500 + $idx * 2300;
            } else {
                $likes = $raw_likes;
            }
            $v_url = !empty($v['video_url']) ? trim($v['video_url']) : '';
            $yt_id = !empty($v_url) ? lx_get_youtube_id($v_url) : false;
            $poster = !empty($v['poster']) ? $v['poster'] : ($yt_id ? lx_get_youtube_thumbnail($yt_id) : '');
            $reels[] = array(
                'name'        => !empty($v['name']) ? $v['name'] : $base['name'],
                'quote'       => '',
                'likes'       => $likes,
                'likes_fmt'   => ($likes >= 1000) ? (round($likes / 1000, 1) . 'K') : (string)$likes,
                'badge'       => '',
                'video_url'   => $v_url,
                'yt_id'       => $yt_id,
                'poster'      => $poster,
                'bg_gradient' => $base['bg_gradient'],
            );
        }
    }
}
if (empty($reels)) {
    $reels = $default_reels;
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
                <?php foreach ($reels as $idx => $r) : 
                    $is_yt = !empty($r['yt_id']);
                ?>
                    <div class="mom-card reel-card <?php echo $is_yt ? 'has-yt' : ''; ?>" data-reel-index="<?php echo $idx; ?>" <?php if ($is_yt) : ?>data-yt-id="<?php echo esc_attr($r['yt_id']); ?>"<?php endif; ?>>
                        <div class="reel-video-container" style="background: <?php echo esc_attr($r['bg_gradient']); ?>;">
                            <!-- Sound Toggle for MP4 only (no badge) -->
                            <?php if (!$is_yt && !empty($r['video_url'])) : ?>
                                <div class="reel-top-bar" style="justify-content: flex-end;">
                                    <button type="button" class="reel-sound-btn js-reel-sound" aria-label="Bật/Tắt âm thanh" title="Bật/Tắt âm">
                                        <span class="sound-icon">🔇</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <!-- Video Element or Ambient Animated Poster -->
                            <?php if ($is_yt) : ?>
                                <?php if (!empty($r['poster'])) : ?>
                                    <img class="reel-video-el js-reel-poster-img" src="<?php echo esc_url($r['poster']); ?>" alt="<?php echo esc_attr($r['name']); ?>" style="object-fit:cover;" loading="lazy">
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
                            <?php elseif (!empty($r['video_url'])) : ?>
                                <video class="reel-video-el js-reel-video" src="<?php echo esc_url($r['video_url']); ?>" <?php if (!empty($r['poster'])) : ?>poster="<?php echo esc_url($r['poster']); ?>"<?php endif; ?> playsinline loop muted preload="metadata"></video>
                            <?php elseif (!empty($r['poster'])) : ?>
                                <img class="reel-video-el" src="<?php echo esc_url($r['poster']); ?>" alt="<?php echo esc_attr($r['name']); ?>" style="object-fit:cover;" loading="lazy">
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

                            <!-- Floating Like Button (Góc phải dưới - DUY NHẤT ĐƯỢC GIỮ LẠI) -->
                            <div class="reel-like-wrap">
                                <button type="button" class="reel-action-btn btn-like js-reel-like" data-count="<?php echo esc_attr($r['likes']); ?>" data-liked="false" aria-label="Thả tim">
                                    <span class="action-icon heart-icon">🤍</span>
                                    <span class="action-count count-like"><?php echo esc_html($r['likes_fmt']); ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
