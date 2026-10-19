<?php
/**
 * Moms Video Reviews Template (TikTok / Reels Short-Form Video Showcase)
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$eyebrow    = lx_get_field('lx_moms_eyebrow', 'option', '🎬 Mom Review TikTok & Reels');
$title      = lx_get_field('lx_moms_title', 'option', 'Khoảnh khắc bé yêu & <span class="hl">Trải nghiệm của Mẹ</span>');
$sub        = lx_get_field('lx_moms_sub', 'option', 'Bấm xem các mẹ bỉm tắm bé cùng Bon Bon · Chạm đúp (2 lần) để thả tim cho các bé nhé!');
$acf_videos = lx_get_field('lx_moms_videos', 'option', array());

$default_reels = array(
    array(
        'name'     => 'Mẹ Mai & Bé Bơ',
        'handle'   => '@me_mai_be_bo',
        'baby'     => 'Bé 4 tháng',
        'quote'    => 'Bé nhà mình da nhạy cảm cực kỳ, đổi sang Bon Bon cái êm ru. Tắm xong da mướt rượt, không hề bị rít hay khô ráp gì luôn!',
        'tags'     => '#tamgoidiuem #khongcaymat #bonbon',
        'likes'    => 3420,
        'likes_fmt'=> '3.4K',
        'comments' => 186,
        'comment_hl'=> 'Mẹ Nhím: "Công nhận mùi thảo mộc dịu nhẹ mê thật sự ạ! ⭐⭐⭐⭐⭐"',
        'video_url'=> '',
        'poster'   => '',
        'bg_color' => 'linear-gradient(160deg, #dcf0f4 0%, #b8ecf3 100%)',
        'badge'    => '🔥 Hot Review',
    ),
    array(
        'name'     => 'Mẹ Quỳnh & Bé Sóc',
        'handle'   => '@quynh_soc_nho',
        'baby'     => 'Bé 2 tháng',
        'quote'    => 'Lúc đầu sợ cay mắt con, sau thử cho bọt dính trán bé vẫn cười toe toét. Cực kỳ an tâm cho trẻ sơ sinh nhé các mom ơi ❤️',
        'tags'     => '#tresosinh #khongcaymat #homecare',
        'likes'    => 4150,
        'likes_fmt'=> '4.1K',
        'comments' => 245,
        'comment_hl'=> 'Mẹ Bắp: "Bé nhà mình gội đầu không bao giờ khóc nữa! ⭐⭐⭐⭐⭐"',
        'video_url'=> '',
        'poster'   => '',
        'bg_color' => 'linear-gradient(160deg, #ffe4ec 0%, #ffc2d4 100%)',
        'badge'    => '👶 Bé sơ sinh',
    ),
    array(
        'name'     => 'Mẹ Thảo & Bé Tít',
        'handle'   => '@thao_me_tit',
        'baby'     => 'Bé 6 tháng',
        'quote'    => 'Mảng cứt trâu trên đầu bé gội tầm 4-5 lần là sạch bong nhẹ nhàng, không cần phải cạy hay bôi dầu dừa lích kích nữa.',
        'tags'     => '#sachcuttrau #dauhanhnhan #bonbon',
        'likes'    => 2890,
        'likes_fmt'=> '2.9K',
        'comments' => 132,
        'comment_hl'=> 'Mẹ Cún: "Em cũng trị sạch cứt trâu cho con nhờ Bon Bon đó! ⭐⭐⭐⭐⭐"',
        'video_url'=> '',
        'poster'   => '',
        'bg_color' => 'linear-gradient(160deg, #fff6d6 0%, #ffeaa7 100%)',
        'badge'    => '✨ Sạch cứt trâu',
    ),
    array(
        'name'     => 'Mẹ Lan & Bé Gấu',
        'handle'   => '@me_gau_con',
        'baby'     => 'Bé 3 tháng',
        'quote'    => 'Chai 500ml bự chảng dùng hơn 4 tháng mới hết nửa chai, tính ra mỗi ngày có nghìn rưỡi hai nghìn mà con thơm tho cả ngày.',
        'tags'     => '#tietkiem #chai500ml #bonbonhomecare',
        'likes'    => 5210,
        'likes_fmt'=> '5.2K',
        'comments' => 318,
        'comment_hl'=> 'Mẹ Đậu: "Đáng đồng tiền bát gạo lắm mom ơi, bọt xốp mịn siêu thích! ⭐⭐⭐⭐⭐"',
        'video_url'=> '',
        'poster'   => '',
        'bg_color' => 'linear-gradient(160deg, #e6fbf2 0%, #c3f7e0 100%)',
        'badge'    => '⭐ Đánh giá 5 sao',
    ),
);

$reels = array();
if (!empty($acf_videos) && is_array($acf_videos)) {
    foreach ($acf_videos as $idx => $v) {
        if (!empty($v['video_url']) || !empty($v['name'])) {
            $base = isset($default_reels[$idx]) ? $default_reels[$idx] : $default_reels[0];
            $likes = !empty($v['likes']) ? (int)$v['likes'] : (2500 + $idx * 650);
            $reels[] = array(
                'name'      => !empty($v['name']) ? $v['name'] : $base['name'],
                'handle'    => !empty($v['handle']) ? $v['handle'] : ('@' . sanitize_title(!empty($v['name']) ? $v['name'] : 'me_be')),
                'baby'      => !empty($v['baby']) ? $v['baby'] : $base['baby'],
                'quote'     => !empty($v['quote']) ? $v['quote'] : $base['quote'],
                'tags'      => $base['tags'],
                'likes'     => $likes,
                'likes_fmt' => ($likes >= 1000) ? (round($likes / 1000, 1) . 'K') : (string)$likes,
                'comments'  => 120 + $idx * 45,
                'comment_hl'=> $base['comment_hl'],
                'video_url' => !empty($v['video_url']) ? $v['video_url'] : '',
                'poster'    => !empty($v['poster']) ? $v['poster'] : '',
                'bg_color'  => $base['bg_color'],
                'badge'     => $base['badge'],
            );
        }
    }
}
if (empty($reels)) {
    $reels = $default_reels;
}
?>
<!-- ===== SECTION 9: CẢM NHẬN CỦA CÁC MOM (TIKTOK / REELS SHOWCASE) ===== -->
<section class="section moms reels-section" id="cam-nhan">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
            <h2 class="section-title"><?php echo $title; ?></h2>
            <p class="section-sub"><?php echo esc_html($sub); ?></p>
        </div>

        <div class="reels-slider-wrap" data-reveal>
            <button type="button" class="reel-nav prev" id="reelPrev" aria-label="Xem video trước">❮</button>
            <button type="button" class="reel-nav next" id="reelNext" aria-label="Xem video tiếp">❯</button>

            <div class="mom-row reels-track" id="reelsTrack">
                <?php foreach ($reels as $idx => $r) : ?>
                    <div class="mom-card reel-card" data-reel-index="<?php echo $idx; ?>">
                        <div class="mom-video reel-video-container" style="background: <?php echo esc_attr($r['bg_color']); ?>;">
                            <!-- Top Bar: Badge & Sound Toggle -->
                            <div class="reel-top-bar">
                                <span class="reel-badge"><span class="reel-dot"></span> <?php echo esc_html($r['badge']); ?></span>
                                <button type="button" class="reel-sound-btn js-reel-sound" aria-label="Bật/Tắt âm thanh" title="Bật/Tắt âm">
                                    <span class="sound-icon">🔇</span>
                                </button>
                            </div>

                            <!-- Video Element or Animated Simulation -->
                            <?php if (!empty($r['video_url'])) : ?>
                                <video class="reel-video-el js-reel-video" src="<?php echo esc_url($r['video_url']); ?>" <?php if (!empty($r['poster'])) : ?>poster="<?php echo esc_url($r['poster']); ?>"<?php endif; ?> playsinline loop muted preload="metadata"></video>
                            <?php else : ?>
                                <div class="reel-fake-video">
                                    <div class="reel-bubbles-anim" aria-hidden="true">
                                        <span class="rb-bubble b1"></span>
                                        <span class="rb-bubble b2"></span>
                                        <span class="rb-bubble b3"></span>
                                        <span class="rb-bubble b4"></span>
                                    </div>
                                    <div class="reel-center-illustration">
                                        <div class="reel-baby-avatar">👶</div>
                                        <span class="reel-baby-name"><?php echo esc_html($r['baby']); ?></span>
                                        <span class="reel-playing-indicator">
                                            <span></span><span></span><span></span><span></span>
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Big Play/Pause Center Button -->
                            <button type="button" class="reel-play-btn js-reel-play" aria-label="Phát video">
                                <span class="play-icon">▶</span>
                            </button>

                            <!-- Double Tap Big Beating Heart Overlay -->
                            <div class="reel-big-heart" aria-hidden="true">❤️</div>

                            <!-- Vertical Right Action Bar (TikTok / Reels style) -->
                            <div class="reel-actions">
                                <!-- Like / Heart -->
                                <button type="button" class="reel-action-btn btn-like js-reel-like" data-count="<?php echo esc_attr($r['likes']); ?>" data-liked="false" aria-label="Thả tim">
                                    <span class="action-icon heart-icon">🤍</span>
                                    <span class="action-count count-like"><?php echo esc_html($r['likes_fmt']); ?></span>
                                </button>

                                <!-- Comments -->
                                <button type="button" class="reel-action-btn btn-comment js-reel-comment" data-comment="<?php echo esc_attr($r['comment_hl']); ?>" aria-label="Bình luận">
                                    <span class="action-icon">💬</span>
                                    <span class="action-count"><?php echo esc_html($r['comments']); ?></span>
                                </button>

                                <!-- Share -->
                                <button type="button" class="reel-action-btn btn-share js-reel-share" aria-label="Chia sẻ">
                                    <span class="action-icon">↗️</span>
                                    <span class="action-count">Chia sẻ</span>
                                </button>
                            </div>

                            <!-- Bottom Info (Author & Caption) -->
                            <div class="reel-bottom-info">
                                <div class="reel-author">
                                    <span class="reel-avatar">👩‍🍼</span>
                                    <div class="reel-meta">
                                        <b class="reel-author-name"><?php echo esc_html($r['name']); ?></b>
                                        <span class="reel-handle"><?php echo esc_html($r['handle']); ?> <i class="reel-verified" title="Đã xác thực mua hàng">✓</i></span>
                                    </div>
                                </div>
                                <p class="reel-caption"><?php echo esc_html($r['quote']); ?></p>
                                <div class="reel-tags"><?php echo esc_html($r['tags']); ?></div>
                                <div class="reel-audio-bar">
                                    <span class="reel-disc">💿</span>
                                    <span class="reel-audio-title">Âm thanh gốc - Bon Bon Tắm Bé Dịu Êm</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
