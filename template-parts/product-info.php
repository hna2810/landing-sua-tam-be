<?php
/**
 * Product Info & Legal Documents Template
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$eyebrow   = lx_get_field('lx_pinfo_eyebrow', 'option', '📋 Minh bạch & An tâm');
$title     = lx_get_field('lx_pinfo_title', 'option', 'Minh bạch để mẹ yên tâm');

$acf_docs  = lx_get_field('lx_pinfo_docs', 'option', array());
$default_docs = array(
    array(
        'name'  => 'Kiểm định & Công bố',
        'ico'   => '📄',
        'image' => '',
        'ph'    => 'Ảnh giấy kiểm định / công bố',
    ),
    array(
        'name'  => 'Tem chống hàng giả',
        'ico'   => '🛡️',
        'image' => '',
        'ph'    => 'Ảnh tem chống hàng giả',
    ),
);

$docs = array();
if (!empty($acf_docs) && is_array($acf_docs)) {
    foreach ($acf_docs as $idx => $d) {
        $docs[] = array(
            'name'  => !empty($d['name']) ? $d['name'] : ('Chứng nhận ' . ($idx + 1)),
            'ico'   => ($idx === 0) ? '📄' : '🛡️',
            'image' => !empty($d['image']) ? $d['image'] : '',
            'ph'    => !empty($d['name']) ? $d['name'] : 'Ảnh chứng nhận',
        );
    }
}
if (empty($docs)) {
    $docs = $default_docs;
}

$acf_specs = lx_get_field('lx_pinfo_specs', 'option', array());
$default_specs = array(
    array('e' => '🏷️', 'label' => 'Thương hiệu', 'val' => 'Home Care'),
    array('e' => '🇻🇳', 'label' => 'Xuất xứ',     'val' => 'Việt Nam'),
    array('e' => '🧴', 'label' => 'Dung tích',   'val' => '500 ml'),
    array('e' => '📅', 'label' => 'Hạn sử dụng', 'val' => '24 tháng'),
    array('e' => '📜', 'label' => 'Số công bố',  'val' => '64/26/CBMP-NB'),
);
$specs = (!empty($acf_specs) && is_array($acf_specs)) ? $acf_specs : $default_specs;

$storage = lx_get_field('lx_pinfo_storage', 'option', '');
$precaution = lx_get_field('lx_pinfo_precaution', 'option', '');
?>
<!-- ===== SECTION 11: MINH BẠCH ĐỂ MẸ YÊN TÂM ===== -->
<section class="section pinfo" id="thong-tin">
    <div class="container">
        <div class="section-head" data-reveal>
            <h2 class="section-title">Minh bạch để <span class="hl">mẹ yên tâm</span></h2>
        </div>
        <div class="pinfo-grid">
            <div class="pinfo-docs">
                <?php foreach ($docs as $d) : ?>
                    <button class="doc-card" type="button" data-reveal <?php if (!empty($d['image'])) echo 'data-src="' . esc_url($d['image']) . '"'; ?>>
                        <span class="doc-img">
                            <?php if (!empty($d['image'])) : ?>
                                <img src="<?php echo esc_url($d['image']); ?>" alt="<?php echo esc_attr($d['name']); ?>" loading="lazy">
                            <?php else : ?>
                                <span class="doc-ph"><?php echo esc_html($d['ph']); ?></span>
                            <?php endif; ?>
                        </span>
                        <span class="doc-label"><span class="doc-ico"><?php echo esc_html($d['ico']); ?></span><?php echo esc_html($d['name']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
            <div data-reveal>
                <div class="tabs" role="tablist">
                    <span class="tab-pill" id="tabPill"></span>
                    <button class="tab active" role="tab">📦 Thông tin</button>
                    <button class="tab" role="tab">🌤️ Bảo quản</button>
                    <button class="tab" role="tab">⚠️ Lưu ý</button>
                </div>
                <div class="tab-panel active">
                    <ul class="spec">
                        <?php foreach ($specs as $sp) : 
                            $e = !empty($sp['e']) ? $sp['e'] : '🔹';
                        ?>
                            <li><span class="e"><?php echo esc_html($e); ?></span><span><?php echo esc_html($sp['label']); ?></span><b><?php echo esc_html($sp['val']); ?></b></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="tab-panel">
                    <ul class="spec">
                        <?php if (!empty($storage)) : 
                            $storage_lines = array_filter(array_map('trim', explode("\n", $storage)));
                            foreach ($storage_lines as $line) :
                        ?>
                            <li><span class="e">🏠</span><b><?php echo esc_html($line); ?></b></li>
                        <?php 
                            endforeach;
                        else : ?>
                            <li><span class="e">🏠</span><b>Để sản phẩm ở nơi khô ráo, thoáng mát.</b></li>
                            <li><span class="e">☀️</span><b>Tránh ánh nắng mặt trời chiếu trực tiếp.</b></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="tab-panel">
                    <ul class="spec">
                        <?php if (!empty($precaution)) : 
                            $prec_lines = array_filter(array_map('trim', explode("\n", $precaution)));
                            foreach ($prec_lines as $line) :
                        ?>
                            <li><span class="e">🧼</span><b><?php echo esc_html($line); ?></b></li>
                        <?php 
                            endforeach;
                        else : ?>
                            <li><span class="e">🧼</span><b>Sản phẩm chỉ dùng ngoài da.</b></li>
                            <li><span class="e">🙅</span><b>Để xa tầm tay của trẻ em.</b></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="lightbox" id="lightbox" hidden><button class="lb-close" type="button" aria-label="Đóng">×</button><div class="lb-body" id="lbBody"></div></div>
