<?php
/**
 * Moms Video Reviews Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$title       = lx_get_field('lx_moms_title', 'option', 'Cảm nhận của các Mom');
$acf_videos  = lx_get_field('lx_moms_videos', 'option', array());

$videos = array();
if (!empty($acf_videos) && is_array($acf_videos)) {
    foreach ($acf_videos as $v) {
        if (!empty($v['video_url'])) {
            $videos[] = $v;
        }
    }
}
?>
<!-- ===== SECTION 9: CẢM NHẬN CỦA CÁC MOM ===== -->
<section class="section moms" id="cam-nhan">
    <div class="container">
        <div class="section-head" data-reveal>
            <h2 class="section-title">Cảm nhận của <span class="hl">các Mom</span></h2>
        </div>
        <div class="mom-row">
            <?php if (!empty($videos)) : ?>
                <?php foreach ($videos as $vid) : ?>
                    <div class="mom-card" data-reveal>
                        <div class="mom-video">
                            <video src="<?php echo esc_url($vid['video_url']); ?>" <?php if (!empty($vid['poster'])) : ?>poster="<?php echo esc_url($vid['poster']); ?>"<?php endif; ?> playsinline preload="metadata" controls></video>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="mom-card" data-reveal>
                    <div class="mom-video"><span class="mom-ph"><span class="howto-play">▶</span>Video 9:16</span></div>
                </div>
                <div class="mom-card" data-reveal>
                    <div class="mom-video"><span class="mom-ph"><span class="howto-play">▶</span>Video 9:16</span></div>
                </div>
                <div class="mom-card" data-reveal>
                    <div class="mom-video"><span class="mom-ph"><span class="howto-play">▶</span>Video 9:16</span></div>
                </div>
                <div class="mom-card" data-reveal>
                    <div class="mom-video"><span class="mom-ph"><span class="howto-play">▶</span>Video 9:16</span></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
