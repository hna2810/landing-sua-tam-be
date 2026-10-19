<?php
/**
 * ACF Options Page and Fields Registration
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF Options Page
 */
function lx_register_acf_options_page() {
    static $registered = false;
    if ($registered) {
        return;
    }
    if (function_exists('acf_add_options_page')) {
        $registered = true;
        acf_add_options_page(array(
            'page_title' => __('Cài đặt Landing Page', 'lx-landing'),
            'menu_title' => __('Cài đặt Landing Page', 'lx-landing'),
            'menu_slug'  => 'lx-landing-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'icon_url'   => 'dashicons-admin-generic',
            'position'   => 3,
        ));
    }
}
add_action('acf/init', 'lx_register_acf_options_page');
if (function_exists('acf_add_options_page')) {
    lx_register_acf_options_page();
}

/**
 * Register ACF Fields for Theme Settings
 */
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_lx_landing_settings',
        'title' => __('Cấu hình Landing Page Sữa Tắm Gội Bon Bon', 'lx-landing'),
        'fields' => array(
            // ================= TAB 1: LIÊN HỆ & CHUNG =================
            array(
                'key' => 'field_tab_general',
                'label' => __('1. Thông tin chung & Liên hệ', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_hotline',
                'label' => __('Số Hotline (liền số)', 'lx-landing'),
                'name' => 'lx_hotline',
                'type' => 'text',
                'default_value' => '0901234567',
                'instructions' => __('Dùng cho liên kết tel: và nút gọi nhanh (VD: 0901234567).', 'lx-landing'),
            ),
            array(
                'key' => 'field_lx_hotline_formatted',
                'label' => __('Hotline hiển thị', 'lx-landing'),
                'name' => 'lx_hotline_formatted',
                'type' => 'text',
                'default_value' => '0901.234.567',
                'instructions' => __('Số điện thoại hiển thị trên giao diện (VD: 0901.234.567).', 'lx-landing'),
            ),
            array(
                'key' => 'field_lx_zalo',
                'label' => __('Số Zalo tư vấn', 'lx-landing'),
                'name' => 'lx_zalo',
                'type' => 'text',
                'default_value' => '0901234567',
                'instructions' => __('Số Zalo nhận tin nhắn từ nút chat và nút hỗ trợ.', 'lx-landing'),
            ),
            array(
                'key' => 'field_lx_lead_email',
                'label' => __('Email nhận thông báo đơn mới', 'lx-landing'),
                'name' => 'lx_lead_email',
                'type' => 'email',
                'default_value' => 'thanhlyhrhomecare@gmail.com',
                'instructions' => __('Hệ thống sẽ gửi email báo ngay khi có mẹ đặt hàng.', 'lx-landing'),
            ),
            array(
                'key' => 'field_lx_webhook_url',
                'label' => __('Webhook URL nhận đơn (Google Sheet / CRM)', 'lx-landing'),
                'name' => 'lx_webhook_url',
                'type' => 'url',
                'instructions' => __('URL Webhook để tự động đẩy dữ liệu sang Google Sheet hoặc Pancake CRM.', 'lx-landing'),
            ),
            array(
                'key' => 'field_lx_work_hours',
                'label' => __('Khung giờ hỗ trợ', 'lx-landing'),
                'name' => 'lx_work_hours',
                'type' => 'text',
                'default_value' => '8h00 - 21h00 hàng ngày',
            ),
            array(
                'key' => 'field_lx_footer_logo',
                'label' => __('Ảnh Logo Chân trang (Footer)', 'lx-landing'),
                'name' => 'lx_footer_logo',
                'type' => 'image',
                'instructions' => __('Logo hiển thị ở chân trang footer (để trống sẽ dùng Logo Bon Bon mặc định).', 'lx-landing'),
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_lx_footer_title',
                'label' => __('Tiêu đề / Slogan Footer', 'lx-landing'),
                'name' => 'lx_footer_title',
                'type' => 'text',
                'default_value' => 'Bon Bon - Nâng Niu Làn Da Bé',
            ),
            array(
                'key' => 'field_lx_footer_company',
                'label' => __('Tên công ty Footer', 'lx-landing'),
                'name' => 'lx_footer_company',
                'type' => 'text',
                'default_value' => 'CÔNG TY TNHH CHĂM SÓC MẸ VÀ BÉ TẠI NHÀ HOME CARE',
            ),
            array(
                'key' => 'field_lx_footer_address',
                'label' => __('Địa chỉ doanh nghiệp Footer', 'lx-landing'),
                'name' => 'lx_footer_address',
                'type' => 'text',
                'default_value' => 'Địa chỉ: 20 Huy Du, Phường Từ Liêm, TP Hà Nội, Việt Nam.',
            ),
            array(
                'key' => 'field_lx_footer_tax',
                'label' => __('Mã số doanh nghiệp Footer', 'lx-landing'),
                'name' => 'lx_footer_tax',
                'type' => 'text',
                'default_value' => 'Mã số doanh nghiệp: 0107375668 do Sở Kế hoạch & Đầu tư TP Hà Nội cấp lần đầu ngày 29/03/2016',
            ),

            // ================= TAB 2: HERO SECTION =================
            array(
                'key' => 'field_tab_hero',
                'label' => __('2. Phần mở đầu (Hero)', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_hero_badge',
                'label' => __('Huy hiệu nổi bật', 'lx-landing'),
                'name' => 'lx_hero_badge',
                'type' => 'text',
                'default_value' => '🌿 Sữa tắm gội 2in1 cho bé',
            ),
            array(
                'key' => 'field_lx_hero_title',
                'label' => __('Tiêu đề chính', 'lx-landing'),
                'name' => 'lx_hero_title',
                'type' => 'text',
                'default_value' => 'ÍT BỌT DỊU ÊM, MỀM MỊN DA BÉ',
            ),
            array(
                'key' => 'field_lx_hero_subtitle',
                'label' => __('Mô tả ngắn', 'lx-landing'),
                'name' => 'lx_hero_subtitle',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Công thức thảo mộc tự nhiên, làm sạch dịu nhẹ — tắm & gội tiện lợi cho bé yêu từ sơ sinh.',
            ),
            array(
                'key' => 'field_lx_hero_subnote',
                'label' => __('Dòng ghi chú nhỏ dưới nút', 'lx-landing'),
                'name' => 'lx_hero_subnote',
                'type' => 'text',
                'default_value' => 'Dịu nhẹ như vòng tay mẹ',
            ),
            array(
                'key' => 'field_lx_hero_lion_bubble',
                'label' => __('Bong bóng thoại chú sư tử', 'lx-landing'),
                'name' => 'lx_hero_lion_bubble',
                'type' => 'text',
                'default_value' => 'Mẹ ơi, con thích tắm lắm! 🦁',
            ),
            array(
                'key' => 'field_lx_hero_bottle_img',
                'label' => __('Ảnh chai sản phẩm Hero (tùy chọn)', 'lx-landing'),
                'name' => 'lx_hero_bottle_img',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_lx_hero_lion_img',
                'label' => __('Ảnh linh vật sư tử (tùy chọn)', 'lx-landing'),
                'name' => 'lx_hero_lion_img',
                'type' => 'image',
                'return_format' => 'url',
            ),

            // ================= TAB 3: WISH CARDS (MONG MUỐN) =================
            array(
                'key' => 'field_tab_wish',
                'label' => __('3. Thẻ mong muốn (Lật 3D)', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_wish_title',
                'label' => __('Tiêu đề khối', 'lx-landing'),
                'name' => 'lx_wish_title',
                'type' => 'text',
                'default_value' => 'Mẹ muốn da con yêu thế nào?',
            ),
            array(
                'key' => 'field_lx_wish_cards',
                'label' => __('Danh sách 3 thẻ lật', 'lx-landing'),
                'name' => 'lx_wish_cards',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm thẻ', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_wish_title',
                        'label' => __('Tiêu đề thẻ', 'lx-landing'),
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_wish_desc',
                        'label' => __('Nội dung giải thích mặt sau', 'lx-landing'),
                        'name' => 'desc',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                    array(
                        'key' => 'field_wish_icon',
                        'label' => __('Biểu tượng Emoji', 'lx-landing'),
                        'name' => 'icon',
                        'type' => 'text',
                        'default_value' => '🛁',
                    ),
                    array(
                        'key' => 'field_wish_image',
                        'label' => __('Ảnh mặt trước (nếu có)', 'lx-landing'),
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),

            // ================= TAB 4: SO SÁNH =================
            array(
                'key' => 'field_tab_compare',
                'label' => __('4. Kéo so sánh', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_compare_eyebrow',
                'label' => __('Huy hiệu nhỏ', 'lx-landing'),
                'name' => 'lx_compare_eyebrow',
                'type' => 'text',
                'default_value' => '↔️ Kéo để so sánh',
            ),
            array(
                'key' => 'field_lx_compare_title',
                'label' => __('Tiêu đề khối', 'lx-landing'),
                'name' => 'lx_compare_title',
                'type' => 'text',
                'default_value' => 'Khác biệt nằm ở sự dịu nhẹ',
            ),
            array(
                'key' => 'field_lx_compare_sub',
                'label' => __('Mô tả hướng dẫn', 'lx-landing'),
                'name' => 'lx_compare_sub',
                'type' => 'text',
                'default_value' => 'Kéo nút tròn sang trái/phải để xem sự khác biệt.',
            ),
            array(
                'key' => 'field_lx_compare_normal_title',
                'label' => __('Tiêu đề bên Trái (Thông thường)', 'lx-landing'),
                'name' => 'lx_compare_normal_title',
                'type' => 'text',
                'default_value' => 'Sữa tắm thông thường',
            ),
            array(
                'key' => 'field_lx_compare_normal_points',
                'label' => __('Các điểm bên Trái (mỗi dòng 1 ý)', 'lx-landing'),
                'name' => 'lx_compare_normal_points',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => "Nhiều bọt, khó xả sạch\nDễ cay mắt khi gội\nDa dễ khô ráp sau tắm\nPhải mua riêng dầu gội",
            ),
            array(
                'key' => 'field_lx_compare_normal_img',
                'label' => __('Ảnh bên Trái (tùy chọn)', 'lx-landing'),
                'name' => 'lx_compare_normal_img',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_lx_compare_bonbon_title',
                'label' => __('Tiêu đề bên Phải (Bon Bon)', 'lx-landing'),
                'name' => 'lx_compare_bonbon_title',
                'type' => 'text',
                'default_value' => 'Sữa tắm gội Bon Bon',
            ),
            array(
                'key' => 'field_lx_compare_bonbon_points',
                'label' => __('Các điểm bên Phải (mỗi dòng 1 ý)', 'lx-landing'),
                'name' => 'lx_compare_bonbon_points',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => "Ít bọt, không cay mắt\nKhông chứa Paraben\npH cân bằng, giữ ẩm da\n2in1: tắm & gội tiện lợi",
            ),
            array(
                'key' => 'field_lx_compare_bonbon_img',
                'label' => __('Ảnh bên Phải (tùy chọn)', 'lx-landing'),
                'name' => 'lx_compare_bonbon_img',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_lx_compare_note',
                'label' => __('Ghi chú dưới khối so sánh', 'lx-landing'),
                'name' => 'lx_compare_note',
                'type' => 'text',
                'default_value' => '* So sánh mang tính minh họa, trải nghiệm có thể khác nhau tùy làn da mỗi bé.',
            ),

            // ================= TAB 5: CÔNG DỤNG 3IN1 =================
            array(
                'key' => 'field_tab_uses',
                'label' => __('5. Công dụng 3 trong 1', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_uses_eyebrow',
                'label' => __('Huy hiệu nhỏ', 'lx-landing'),
                'name' => 'lx_uses_eyebrow',
                'type' => 'text',
                'default_value' => '🌟 Đa năng cho mẹ & bé',
            ),
            array(
                'key' => 'field_lx_uses_title',
                'label' => __('Tiêu đề khối', 'lx-landing'),
                'name' => 'lx_uses_title',
                'type' => 'text',
                'default_value' => 'Công dụng 3 trong 1',
            ),
            array(
                'key' => 'field_lx_uses_mom_img',
                'label' => __('Ảnh Mẹ tắm bé trung tâm (tùy chọn)', 'lx-landing'),
                'name' => 'lx_uses_mom_img',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_lx_uses_bottle_img',
                'label' => __('Ảnh Chai sữa tắm 500ml trung tâm (tùy chọn)', 'lx-landing'),
                'name' => 'lx_uses_bottle_img',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_lx_uses_list',
                'label' => __('Danh sách 3 công dụng', 'lx-landing'),
                'name' => 'lx_uses_list',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm công dụng', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_uses_title',
                        'label' => __('Tên công dụng', 'lx-landing'),
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_uses_desc',
                        'label' => __('Mô tả chi tiết', 'lx-landing'),
                        'name' => 'desc',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                    array(
                        'key' => 'field_uses_icon',
                        'label' => __('Biểu tượng Emoji', 'lx-landing'),
                        'name' => 'icon',
                        'type' => 'text',
                        'default_value' => '🛁',
                    ),
                ),
            ),

            // ================= TAB 6: HƯỚNG DẪN CÁCH DÙNG (VIDEO 9:16) =================
            array(
                'key' => 'field_tab_howto',
                'label' => __('6. Cách dùng & Video 9:16', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_howto_eyebrow',
                'label' => __('Huy hiệu nhỏ', 'lx-landing'),
                'name' => 'lx_howto_eyebrow',
                'type' => 'text',
                'default_value' => '🧴 Tắm gội chuẩn mẹ đảm',
            ),
            array(
                'key' => 'field_lx_howto_title',
                'label' => __('Tiêu đề khối', 'lx-landing'),
                'name' => 'lx_howto_title',
                'type' => 'text',
                'default_value' => '3 bước tắm gội dịu êm cho bé',
            ),
            array(
                'key' => 'field_lx_howto_video_url',
                'label' => __('URL Video hướng dẫn (MP4 khung 9:16)', 'lx-landing'),
                'name' => 'lx_howto_video_url',
                'type' => 'url',
                'instructions' => __('Tải lên Media Library rồi copy link mp4 dán vào đây.', 'lx-landing'),
            ),
            array(
                'key' => 'field_lx_howto_video_poster',
                'label' => __('Ảnh bìa Video (Poster)', 'lx-landing'),
                'name' => 'lx_howto_video_poster',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_lx_howto_steps',
                'label' => __('3 bước tắm gội', 'lx-landing'),
                'name' => 'lx_howto_steps',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm bước', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_howto_step_num',
                        'label' => __('Số thứ tự bước (VD: 01)', 'lx-landing'),
                        'name' => 'step_num',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_howto_title',
                        'label' => __('Tên bước', 'lx-landing'),
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_howto_desc',
                        'label' => __('Nội dung hướng dẫn', 'lx-landing'),
                        'name' => 'desc',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                    array(
                        'key' => 'field_howto_hint',
                        'label' => __('Ghi chú mẹo nhỏ', 'lx-landing'),
                        'name' => 'hint',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_howto_badge',
                        'label' => __('Huy hiệu nhỏ trên card video', 'lx-landing'),
                        'name' => 'badge',
                        'type' => 'text',
                    ),
                ),
            ),

            // ================= TAB 7: HÌNH ẢNH KHÁCH HÀNG (UGC) =================
            array(
                'key' => 'field_tab_ugc',
                'label' => __('7. Ảnh thực tế khách hàng', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_ugc_eyebrow',
                'label' => __('Huy hiệu nhỏ', 'lx-landing'),
                'name' => 'lx_ugc_eyebrow',
                'type' => 'text',
                'default_value' => '📸 Khoảnh khắc bé yêu',
            ),
            array(
                'key' => 'field_lx_ugc_title',
                'label' => __('Tiêu đề khối', 'lx-landing'),
                'name' => 'lx_ugc_title',
                'type' => 'text',
                'default_value' => 'Hàng ngàn mẹ đã tin dùng',
            ),
            array(
                'key' => 'field_lx_ugc_sub',
                'label' => __('Mô tả phụ', 'lx-landing'),
                'name' => 'lx_ugc_sub',
                'type' => 'text',
                'default_value' => 'Ảnh chụp thực tế từ các mẹ bỉm trên toàn quốc',
            ),
            array(
                'key' => 'field_lx_ugc_images',
                'label' => __('Danh sách ảnh khách hàng (tự động cuộn 3 cột)', 'lx-landing'),
                'name' => 'lx_ugc_images',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm ảnh', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_ugc_image',
                        'label' => __('Chọn ảnh chụp thực tế', 'lx-landing'),
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),

            // ================= TAB 8: VIDEO REVIEW MẸ BỈM =================
            array(
                'key' => 'field_tab_moms',
                'label' => __('8. Video Mom Reviews (9:16)', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_moms_eyebrow',
                'label' => __('Huy hiệu nhỏ', 'lx-landing'),
                'name' => 'lx_moms_eyebrow',
                'type' => 'text',
                'default_value' => '🎥 Video chân thực',
            ),
            array(
                'key' => 'field_lx_moms_title',
                'label' => __('Tiêu đề khối', 'lx-landing'),
                'name' => 'lx_moms_title',
                'type' => 'text',
                'default_value' => 'Mẹ bỉm nói gì về Bon Bon?',
            ),
            array(
                'key' => 'field_lx_moms_videos',
                'label' => __('Danh sách video review', 'lx-landing'),
                'name' => 'lx_moms_videos',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm Video Review', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_mom_name',
                        'label' => __('Tên mẹ (VD: Mẹ Mai & Bé Bơ)', 'lx-landing'),
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_mom_baby',
                        'label' => __('Tuổi bé (VD: 6 tháng)', 'lx-landing'),
                        'name' => 'baby',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_mom_quote',
                        'label' => __('Trích dẫn ngắn gọn', 'lx-landing'),
                        'name' => 'quote',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_mom_video_url',
                        'label' => __('URL Video MP4 (khung 9:16)', 'lx-landing'),
                        'name' => 'video_url',
                        'type' => 'url',
                    ),
                    array(
                        'key' => 'field_mom_poster',
                        'label' => __('Ảnh bìa video (Poster)', 'lx-landing'),
                        'name' => 'poster',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),

            // ================= TAB 9: ĐIỂM BÁN =================
            array(
                'key' => 'field_tab_stores',
                'label' => __('9. Hệ thống điểm bán', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_stores_eyebrow',
                'label' => __('Huy hiệu nhỏ', 'lx-landing'),
                'name' => 'lx_stores_eyebrow',
                'type' => 'text',
                'default_value' => '🏪 Hệ thống điểm bán',
            ),
            array(
                'key' => 'field_lx_stores_title',
                'label' => __('Tiêu đề khối', 'lx-landing'),
                'name' => 'lx_stores_title',
                'type' => 'text',
                'default_value' => 'Gần 100+ nhà thuốc & shop mẹ bé',
            ),
            array(
                'key' => 'field_lx_stores_list',
                'label' => __('Danh sách điểm bán (Slider)', 'lx-landing'),
                'name' => 'lx_stores_list',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm điểm bán', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_store_name',
                        'label' => __('Tên nhà thuốc / cửa hàng', 'lx-landing'),
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_store_address',
                        'label' => __('Địa chỉ hoặc Khu vực', 'lx-landing'),
                        'name' => 'address',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_store_photo',
                        'label' => __('Ảnh cửa hàng thực tế', 'lx-landing'),
                        'name' => 'photo',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),

            // ================= TAB 10: THÔNG TIN PHÁP LÝ & GIẤY TỜ =================
            array(
                'key' => 'field_tab_pinfo',
                'label' => __('10. Pháp lý & Thông số', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_pinfo_eyebrow',
                'label' => __('Huy hiệu nhỏ', 'lx-landing'),
                'name' => 'lx_pinfo_eyebrow',
                'type' => 'text',
                'default_value' => '📋 Minh bạch & An tâm',
            ),
            array(
                'key' => 'field_lx_pinfo_title',
                'label' => __('Tiêu đề khối', 'lx-landing'),
                'name' => 'lx_pinfo_title',
                'type' => 'text',
                'default_value' => 'Thông tin sản phẩm & Pháp lý',
            ),
            array(
                'key' => 'field_lx_pinfo_docs',
                'label' => __('Ảnh Giấy tờ pháp lý & Chứng nhận', 'lx-landing'),
                'name' => 'lx_pinfo_docs',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm giấy chứng nhận', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_doc_name',
                        'label' => __('Tên chứng nhận (VD: Giấy công bố 64/26/CBMP-NB)', 'lx-landing'),
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_doc_image',
                        'label' => __('Ảnh chụp giấy tờ', 'lx-landing'),
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),
            array(
                'key' => 'field_lx_pinfo_specs',
                'label' => __('Bảng thông số chi tiết (Dung tích, xuất xứ...)', 'lx-landing'),
                'name' => 'lx_pinfo_specs',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm dòng thông số', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_spec_label',
                        'label' => __('Tên mục', 'lx-landing'),
                        'name' => 'label',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_spec_val',
                        'label' => __('Giá trị', 'lx-landing'),
                        'name' => 'val',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_lx_pinfo_storage',
                'label' => __('Hướng dẫn bảo quản', 'lx-landing'),
                'name' => 'lx_pinfo_storage',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Nơi khô ráo thoáng mát, tránh ánh nắng trực tiếp. Đậy kín nắp sau khi sử dụng.',
            ),
            array(
                'key' => 'field_lx_pinfo_precaution',
                'label' => __('Lưu ý khi sử dụng', 'lx-landing'),
                'name' => 'lx_pinfo_precaution',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Tránh để sản phẩm tiếp xúc trực tiếp vào mắt trẻ. Nếu vô tình dính vào mắt, hãy rửa sạch ngay bằng nước ấm.',
            ),

            // ================= TAB 10b: THƯỚC ĐO TIẾT KIỆM (CALCULATOR) =================
            array(
                'key' => 'field_tab_calc',
                'label' => __('10b. Thước đo tiết kiệm (Calculator)', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_calc_eyebrow',
                'label' => __('Huy hiệu nhỏ', 'lx-landing'),
                'name' => 'lx_calc_eyebrow',
                'type' => 'text',
                'default_value' => '💡 Thước đo chi tiêu thông minh',
            ),
            array(
                'key' => 'field_lx_calc_title',
                'label' => __('Tiêu đề khối', 'lx-landing'),
                'name' => 'lx_calc_title',
                'type' => 'text',
                'default_value' => 'Bé dùng được bao lâu? <span class="hl">Tiết kiệm bao nhiêu?</span>',
            ),
            array(
                'key' => 'field_lx_calc_sub',
                'label' => __('Mô tả phụ', 'lx-landing'),
                'name' => 'lx_calc_sub',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Chỉ với 1 chai Bon Bon 500ml – Mẹ cùng tính bài toán kinh tế thông minh cho con nhé!',
            ),
            array(
                'key' => 'field_lx_calc_price',
                'label' => __('Giá chai tính toán (VNĐ)', 'lx-landing'),
                'name' => 'lx_calc_price',
                'type' => 'number',
                'default_value' => 265000,
            ),
            array(
                'key' => 'field_lx_calc_volume',
                'label' => __('Dung tích chai (ml)', 'lx-landing'),
                'name' => 'lx_calc_volume',
                'type' => 'number',
                'default_value' => 500,
            ),

            // ================= TAB 11: VÒNG QUAY MAY MẮN =================
            array(
                'key' => 'field_tab_wheel',
                'label' => __('11. Vòng quay may mắn', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_wheel_title',
                'label' => __('Tiêu đề vòng quay', 'lx-landing'),
                'name' => 'lx_wheel_title',
                'type' => 'text',
                'default_value' => 'Vòng quay may mắn',
            ),
            array(
                'key' => 'field_lx_wheel_sub',
                'label' => __('Mô tả vòng quay', 'lx-landing'),
                'name' => 'lx_wheel_sub',
                'type' => 'text',
                'default_value' => '100% trúng quà cho mẹ & bé',
            ),
            array(
                'key' => 'field_lx_wheel_gifts',
                'label' => __('Danh sách quà tặng vòng quay', 'lx-landing'),
                'name' => 'lx_wheel_gifts',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm phần quà', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_gift_label',
                        'label' => __('Tên phần quà', 'lx-landing'),
                        'name' => 'label',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_gift_color',
                        'label' => __('Mã màu ô quay', 'lx-landing'),
                        'name' => 'color',
                        'type' => 'text',
                        'default_value' => '#ffb5c8',
                    ),
                    array(
                        'key' => 'field_gift_weight',
                        'label' => __('Tỷ lệ trúng (trọng số)', 'lx-landing'),
                        'name' => 'weight',
                        'type' => 'number',
                        'default_value' => 1,
                    ),
                ),
            ),

            // ================= TAB 12: ƯU ĐÃI & FORM ĐẶT HÀNG =================
            array(
                'key' => 'field_tab_offer',
                'label' => __('12. Ưu đãi & Đặt hàng', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_offer_badge',
                'label' => __('Huy hiệu ưu đãi', 'lx-landing'),
                'name' => 'lx_offer_badge',
                'type' => 'text',
                'default_value' => '⚡ Ưu đãi hôm nay',
            ),
            array(
                'key' => 'field_lx_offer_label',
                'label' => __('Tên gói sản phẩm ưu đãi', 'lx-landing'),
                'name' => 'lx_offer_label',
                'type' => 'text',
                'default_value' => 'Combo 299K BIGSIZE tắm gội + Kem bôi',
            ),
            array(
                'key' => 'field_lx_offer_price',
                'label' => __('Giá ưu đãi (VNĐ)', 'lx-landing'),
                'name' => 'lx_offer_price',
                'type' => 'number',
                'default_value' => 299000,
            ),
            array(
                'key' => 'field_lx_offer_old_price',
                'label' => __('Giá gốc (VNĐ)', 'lx-landing'),
                'name' => 'lx_offer_old_price',
                'type' => 'number',
                'default_value' => 455000,
            ),
            array(
                'key' => 'field_lx_offer_bottle_img',
                'label' => __('Ảnh chai trong khối ưu đãi (tùy chọn)', 'lx-landing'),
                'name' => 'lx_offer_bottle_img',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_lx_offer_lion_img',
                'label' => __('Ảnh sư tử trong khối ưu đãi (tùy chọn)', 'lx-landing'),
                'name' => 'lx_offer_lion_img',
                'type' => 'image',
                'return_format' => 'url',
            ),

            // ================= TAB 13: ĐÁNH GIÁ SẢN PHẨM =================
            array(
                'key' => 'field_tab_reviews',
                'label' => __('13. Đánh giá sản phẩm', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_reviews_score',
                'label' => __('Điểm đánh giá trung bình', 'lx-landing'),
                'name' => 'lx_reviews_score',
                'type' => 'text',
                'default_value' => '4.9',
            ),
            array(
                'key' => 'field_lx_reviews_count',
                'label' => __('Số lượt đánh giá hiển thị', 'lx-landing'),
                'name' => 'lx_reviews_count',
                'type' => 'text',
                'default_value' => '1.248',
            ),
            array(
                'key' => 'field_lx_reviews_list',
                'label' => __('Danh sách bình luận của khách', 'lx-landing'),
                'name' => 'lx_reviews_list',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm đánh giá', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_rv_name',
                        'label' => __('Tên mẹ (VD: Mẹ Bin)', 'lx-landing'),
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_rv_time',
                        'label' => __('Thời gian (VD: 2 ngày trước)', 'lx-landing'),
                        'name' => 'time',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_rv_stars',
                        'label' => __('Số sao (1 đến 5)', 'lx-landing'),
                        'name' => 'stars',
                        'type' => 'number',
                        'default_value' => 5,
                    ),
                    array(
                        'key' => 'field_rv_text',
                        'label' => __('Nội dung nhận xét', 'lx-landing'),
                        'name' => 'text',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),

            // ================= TAB 14: CÂU HỎI THƯỜNG GẶP (FAQ) =================
            array(
                'key' => 'field_tab_faq',
                'label' => __('14. Câu hỏi thường gặp (FAQ)', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_faq_title',
                'label' => __('Tiêu đề khối FAQ', 'lx-landing'),
                'name' => 'lx_faq_title',
                'type' => 'text',
                'default_value' => 'Mẹ hỏi — Bon Bon trả lời',
            ),
            array(
                'key' => 'field_lx_faq_items',
                'label' => __('Danh sách câu hỏi & trả lời', 'lx-landing'),
                'name' => 'lx_faq_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Thêm câu hỏi', 'lx-landing'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_faq_q',
                        'label' => __('Câu hỏi', 'lx-landing'),
                        'name' => 'q',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_faq_a',
                        'label' => __('Câu trả lời', 'lx-landing'),
                        'name' => 'a',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),

            // ================= TAB 15: TRACKING =================
            array(
                'key' => 'field_tab_tracking',
                'label' => __('15. Mã Tracking (Pixel / GA4)', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_fb_pixel_id',
                'label' => __('Meta (Facebook) Pixel ID', 'lx-landing'),
                'name' => 'lx_fb_pixel_id',
                'type' => 'text',
                'instructions' => __('Nhập mã Facebook Pixel (VD: 1176118477928520).', 'lx-landing'),
            ),
            array(
                'key' => 'field_lx_ga4_id',
                'label' => __('Google Analytics 4 Measurement ID', 'lx-landing'),
                'name' => 'lx_ga4_id',
                'type' => 'text',
                'instructions' => __('Nhập ID Google Analytics (VD: G-DS38TS5KPW).', 'lx-landing'),
            ),
            array(
                'key' => 'field_lx_tiktok_pixel_id',
                'label' => __('TikTok Pixel ID', 'lx-landing'),
                'name' => 'lx_tiktok_pixel_id',
                'type' => 'text',
                'instructions' => __('Nhập mã TikTok Pixel (nếu có chạy quảng cáo TikTok).', 'lx-landing'),
            ),

            // ================= TAB 16: CÂU CHUYỆN THƯƠNG HIỆU =================
            array(
                'key' => 'field_tab_story',
                'label' => __('16. Câu chuyện: Yêu con - Mẹ chọn Bon Bon', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_story_title',
                'label' => __('Tiêu đề Câu chuyện thương hiệu', 'lx-landing'),
                'name' => 'lx_story_title',
                'type' => 'text',
                'default_value' => 'YÊU CON -<br><span class="hl">MẸ CHỌN BON BON</span>',
            ),
            array(
                'key' => 'field_lx_story_mascot',
                'label' => __('Ảnh Sư tử / Linh vật Bon Bon (tùy chọn)', 'lx-landing'),
                'name' => 'lx_story_mascot',
                'type' => 'image',
                'instructions' => __('Để trống sẽ dùng linh vật Sư tử Bon Bon mặc định.', 'lx-landing'),
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_lx_story_paragraph',
                'label' => __('Đoạn văn Câu chuyện thương hiệu (Khung chữ gõ)', 'lx-landing'),
                'name' => 'lx_story_paragraph',
                'type' => 'textarea',
                'rows' => 5,
                'default_value' => "Bon Bon đồng hành cùng mẹ từ những ngày đầu đời của bé, từ tắm bé, massage đến chăm sóc da và rốn tại nhà và trung tâm. Với sự chăm chút nhẹ nhàng và các thành phần được lựa chọn phù hợp, Bon Bon cùng mẹ nâng niu làn da non nớt, chăm sóc bé yêu mỗi ngày. Bon Bon còn đồng hành cùng mẹ tại các hội thảo tiền sản và bệnh viện Sản – Nhi trên khắp ba miền Bắc – Trung – Nam.",
            ),
            array(
                'key' => 'field_lx_story_tagline',
                'label' => __('Câu slogan nhấn mạnh (Dòng riêng nổi bật)', 'lx-landing'),
                'name' => 'lx_story_tagline',
                'type' => 'text',
                'default_value' => 'Bon Bon - Dịu dàng chăm bé, trọn vẹn yêu thương.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'lx-landing-settings',
                ),
            ),
        ),
    ));
});
