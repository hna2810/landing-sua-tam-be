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
$title     = lx_get_field('lx_pinfo_title', 'option', 'Minh bạch để <span class="hl">mẹ yên tâm</span>');

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

$acf_docs = lx_get_field('lx_pinfo_docs', 'option', array());
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

$default_specs = array(
    array('e' => '🏷️', 'label' => 'Thương hiệu', 'val' => 'Home Care'),
    array('e' => '🇻🇳', 'label' => 'Xuất xứ',     'val' => 'Việt Nam'),
    array('e' => '🧴', 'label' => 'Dung tích',   'val' => '500 ml'),
    array('e' => '📅', 'label' => 'Hạn sử dụng', 'val' => '24 tháng'),
    array('e' => '📜', 'label' => 'Số công bố',  'val' => '64/26/CBMP-NB'),
);

$acf_specs = lx_get_field('lx_pinfo_specs', 'option', array());
$specs = array();
if (!empty($acf_specs) && is_array($acf_specs)) {
    $specs = $acf_specs;
}
if (empty($specs)) {
    $specs = $default_specs;
}

$default_storage = "Để sản phẩm ở nơi khô ráo, thoáng mát.\nTránh ánh nắng mặt trời chiếu trực tiếp.";
$storage = lx_get_field('lx_pinfo_storage', 'option', $default_storage);
if (empty($storage)) {
    $storage = $default_storage;
}

$default_precaution = "Sản phẩm chỉ dùng ngoài da.\nĐể xa tầm tay của trẻ em.";
$precaution = lx_get_field('lx_pinfo_precaution', 'option', $default_precaution);
if (empty($precaution)) {
    $precaution = $default_precaution;
}

$has_info = !empty($specs) || !empty($storage) || !empty($precaution);
?>
<!-- ===== SECTION 11: MINH BẠCH ĐỂ MẸ YÊN TÂM ===== -->
<section class="section pinfo" id="thong-tin">
    <div class="container">
        <?php if (!empty($eyebrow) || !empty($title)) : ?>
            <div class="section-head" data-reveal>
                <?php if (!empty($eyebrow)) : ?>
                    <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if (!empty($title)) : ?>
                    <h2 class="section-title"><?php echo $title; ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="pinfo-grid">
            <?php if (!empty($docs)) : ?>
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
            <?php endif; ?>

            <?php if ($has_info) : ?>
                <div data-reveal>
                    <div class="tabs" role="tablist">
                        <span class="tab-pill" id="tabPill"></span>
                        <?php if (!empty($specs)) : ?>
                            <button class="tab active" role="tab">📦 Thông tin</button>
                        <?php endif; ?>
                        <?php if (!empty($storage)) : ?>
                            <button class="tab <?php echo empty($specs) ? 'active' : ''; ?>" role="tab">🌤️ Bảo quản</button>
                        <?php endif; ?>
                        <?php if (!empty($precaution)) : ?>
                            <button class="tab <?php echo (empty($specs) && empty($storage)) ? 'active' : ''; ?>" role="tab">⚠️ Lưu ý</button>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($specs)) : ?>
                        <div class="tab-panel active">
                            <ul class="spec">
                                <?php foreach ($specs as $sp) : 
                                    $e = !empty($sp['e']) ? $sp['e'] : '🔹';
                                ?>
                                    <li><span class="e"><?php echo esc_html($e); ?></span><span><?php echo esc_html($sp['label']); ?></span><b><?php echo esc_html($sp['val']); ?></b></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($storage)) : 
                        $storage_lines = array_filter(array_map('trim', explode("\n", $storage)));
                    ?>
                        <div class="tab-panel <?php echo empty($specs) ? 'active' : ''; ?>">
                            <ul class="spec">
                                <?php foreach ($storage_lines as $line) : ?>
                                    <li><span class="e">🏠</span><b><?php echo esc_html($line); ?></b></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($precaution)) : 
                        $prec_lines = array_filter(array_map('trim', explode("\n", $precaution)));
                    ?>
                        <div class="tab-panel <?php echo (empty($specs) && empty($storage)) ? 'active' : ''; ?>">
                            <ul class="spec">
                                <?php foreach ($prec_lines as $line) : ?>
                                    <li><span class="e">🧼</span><b><?php echo esc_html($line); ?></b></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
