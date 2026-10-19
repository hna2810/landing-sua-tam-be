<?php
/**
 * Template part: Brand Story Section (Yêu con - Mẹ chọn Bon Bon)
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$story_title = lx_get_field('lx_story_title', 'option', '');
if (empty($story_title)) {
    $title_1 = lx_get_field('lx_love_title_1', 'option', 'YÊU CON -');
    $title_2 = lx_get_field('lx_love_title_2', 'option', 'MẸ CHỌN BON BON');
    $story_title = $title_1 . '<br><span class="hl">' . $title_2 . '</span>';
}

$default_story_paragraph = 'Bon Bon đồng hành cùng mẹ từ những ngày đầu đời của bé, từ tắm bé, massage đến chăm sóc da và rốn tại nhà và trung tâm. Với sự chăm chút nhẹ nhàng và các thành phần được lựa chọn phù hợp, Bon Bon cùng mẹ nâng niu làn da non nớt, chăm sóc bé yêu mỗi ngày. Bon Bon còn đồng hành cùng mẹ tại các hội thảo tiền sản và bệnh viện Sản – Nhi trên khắp ba miền Bắc – Trung – Nam.';
$default_story_highlight = 'Bon Bon - Dịu dàng chăm bé, trọn vẹn yêu thương.';

$raw_story_paragraph = lx_get_field('lx_story_paragraph', 'option', '');
if (empty($raw_story_paragraph)) {
    $raw_story_paragraph = lx_get_field('lx_love_content', 'option', '');
}

$story_highlight = lx_get_field('lx_story_tagline', 'option', '');
if (empty($story_highlight)) {
    $story_highlight = lx_get_field('lx_love_highlight', 'option', $default_story_highlight);
}
if (empty($story_highlight)) {
    $story_highlight = $default_story_highlight;
}

if (!empty($raw_story_paragraph)) {
    // Tự động tách câu slogan nếu người dùng có gõ chung vào ô đoạn văn
    if (mb_strpos($raw_story_paragraph, $story_highlight) !== false) {
        $story_paragraph = trim(str_replace($story_highlight, '', $raw_story_paragraph));
    } else {
        $story_paragraph = trim($raw_story_paragraph);
    }
} else {
    $story_paragraph = $default_story_paragraph;
}

$mascot_img = lx_get_field('lx_story_mascot', 'option', '');
if (empty($mascot_img)) {
    $mascot_img = lx_get_field('lx_love_mascot_img', 'option', '');
}
if (empty($mascot_img)) {
    $mascot_img = LX_THEME_URI . '/assets/img/su-tu-bon-bon.webp';
}
?>
<!-- 12. CÂU CHUYỆN THƯƠNG HIỆU: YÊU CON - MẸ CHỌN BON BON -->
<section class="sec story" id="story">
    <div class="container">
        <div class="story-hero" data-reveal>
            <img src="<?php echo esc_url($mascot_img); ?>" alt="Sư tử Bon Bon" class="story-mascot" aria-hidden="true" loading="lazy">
            <div class="sec-head">
                <h2 class="sec-title section-title"><?php echo $story_title; ?></h2>
            </div>
        </div>

        <!-- Khung nền trắng, chữ xanh, hiệu ứng chữ gõ từ từ -->
        <div class="story-typewriter-box" id="storyTypewriterBox" 
             data-body="<?php echo esc_attr($story_paragraph); ?>" 
             data-highlight="<?php echo esc_attr($story_highlight); ?>"
             data-reveal>
            <span class="story-card-decor-quote" aria-hidden="true">“</span>
            <div class="story-typewriter-inner">
                <p class="story-typewriter-text" id="storyTypewriterTarget">
                    <span class="typewriter-text"><?php echo esc_html($story_paragraph); ?></span>
                </p>
                <div class="story-typewriter-highlight" id="storyTypewriterHighlight">
                    <strong class="typewriter-highlight-text"><?php echo esc_html($story_highlight); ?></strong>
                    <span class="typewriter-cursor" aria-hidden="true">|</span>
                </div>
            </div>
        </div>
    </div>
</section>
