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
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => __('Cài đặt Landing Page', 'lx-landing'),
        'menu_title' => __('Cài đặt Landing Page', 'lx-landing'),
        'menu_slug'  => 'lx-landing-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-generic',
        'position'   => 59,
    ));
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
        'title' => __('Cấu hình Landing Page Sữa Tắm Bon Bon', 'lx-landing'),
        'fields' => array(
            // Tab 1: Thông tin liên hệ
            array(
                'key' => 'field_tab_contact',
                'label' => __('Liên hệ & Nhận đơn', 'lx-landing'),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lx_hotline',
                'label' => __('Số điện thoại Hotline (liền số)', 'lx-landing'),
                'name' => 'lx_hotline',
                'type' => 'text',
                'default_value' => '0901234567',
                'instructions' => __('Dùng cho link tel: và nút gọi nhanh (VD: 0901234567).', 'lx-landing'),
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
                'label' => __('Số điện thoại Zalo', 'lx-landing'),
                'name' => 'lx_zalo',
                'type' => 'text',
                'default_value' => '0901234567',
                'instructions' => __('Số Zalo nhận tin nhắn từ nút chat (VD: 0901234567).', 'lx-landing'),
            ),
            array(
                'key' => 'field_lx_lead_email',
                'label' => __('Email nhận thông báo đơn mới', 'lx-landing'),
                'name' => 'lx_lead_email',
                'type' => 'email',
                'default_value' => 'thanhlyhrhomecare@gmail.com',
                'instructions' => __('Hệ thống sẽ gửi email báo ngay khi có mẹ điền form tư vấn.', 'lx-landing'),
            ),
            array(
                'key' => 'field_lx_webhook_url',
                'label' => __('Webhook URL nhận Lead (Pancake / Google Sheet)', 'lx-landing'),
                'name' => 'lx_webhook_url',
                'type' => 'url',
                'instructions' => __('Nhập Webhook URL để tự động đẩy thông tin lead sang Pancake CRM hoặc Google Sheet.', 'lx-landing'),
            ),

            // Tab 2: Tracking Pixels
            array(
                'key' => 'field_tab_tracking',
                'label' => __('Mã Tracking (Meta / Google / TikTok)', 'lx-landing'),
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

            // Tab 3: Vòng quay may mắn
            array(
                'key' => 'field_tab_wheel',
                'label' => __('Vòng quay may mắn', 'lx-landing'),
                'type' => 'tab',
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
