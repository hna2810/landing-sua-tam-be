<?php
/**
 * AJAX Lead Submission Handler
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle AJAX Lead Form Submission
 */
function lx_handle_ajax_lead() {
    // Basic verification
    $name  = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $phone = isset($_POST['phone']) ? preg_replace('/[^\d]/', '', (string)$_POST['phone']) : '';

    if (empty($name) || strlen($name) < 2) {
        wp_send_json_error(array('message' => 'Vui lòng nhập họ tên hợp lệ.'), 400);
    }

    if (empty($phone) || !preg_match('/^0[3|5|7|8|9]\d{8}$/', $phone)) {
        wp_send_json_error(array('message' => 'Số điện thoại không hợp lệ (10 số, bắt đầu bằng 0).'), 400);
    }

    $lead = array(
        'name'        => $name,
        'phone'       => $phone,
        'address'     => isset($_POST['address']) ? sanitize_text_field(wp_unslash($_POST['address'])) : '',
        'package'     => isset($_POST['package']) ? sanitize_text_field(wp_unslash($_POST['package'])) : '',
        'price'       => isset($_POST['price']) ? sanitize_text_field(wp_unslash($_POST['price'])) : '',
        'baby_age'    => isset($_POST['baby_age']) ? sanitize_text_field(wp_unslash($_POST['baby_age'])) : '',
        'concern'     => isset($_POST['concern']) ? sanitize_text_field(wp_unslash($_POST['concern'])) : '',
        'call_time'   => isset($_POST['call_time']) ? sanitize_text_field(wp_unslash($_POST['call_time'])) : '',
        'note'        => isset($_POST['note']) ? sanitize_textarea_field(wp_unslash($_POST['note'])) : '',
        'quiz_result' => isset($_POST['quiz_result']) ? sanitize_text_field(wp_unslash($_POST['quiz_result'])) : '',
        'gift'        => isset($_POST['gift']) ? sanitize_text_field(wp_unslash($_POST['gift'])) : '',
        'source'      => isset($_POST['source']) ? sanitize_text_field(wp_unslash($_POST['source'])) : '',
        'page'        => isset($_POST['page']) ? esc_url_raw(wp_unslash($_POST['page'])) : home_url('/'),
        'product'     => 'Sữa tắm gội Bon Bon',
        'created_at'  => current_time('mysql'),
        'ip'          => isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '',
    );

    // 1. Store in WP Options (rolling list of 200 leads)
    $leads = get_option('lx_leads_list', array());
    if (!is_array($leads)) {
        $leads = array();
    }
    array_unshift($leads, $lead);
    if (count($leads) > 200) {
        $leads = array_slice($leads, 0, 200);
    }
    update_option('lx_leads_list', $leads, false);

    // 2. Send email notification
    $to_email = lx_get_field('lx_lead_email', 'option', 'thanhlyhrhomecare@gmail.com');
    if (empty($to_email) || !is_email($to_email)) {
        $to_email = get_option('admin_email');
    }

    $subject = sprintf('[Sữa Tắm Bon Bon] Đơn đặt hàng mới từ mẹ %s - %s', $lead['name'], $lead['phone']);
    $message = "MẸ ĐĂNG KÝ SỮA TẮM GỘI BON BON:\n\n";
    $message .= "Họ tên mẹ: " . $lead['name'] . "\n";
    $message .= "Số điện thoại: " . $lead['phone'] . "\n";
    if (!empty($lead['address'])) {
        $message .= "Địa chỉ giao hàng: " . $lead['address'] . "\n";
    }
    if (!empty($lead['package'])) {
        $message .= "Gói sản phẩm: " . $lead['package'] . "\n";
    }
    if (!empty($lead['price'])) {
        $message .= "Giá ưu đãi: " . number_format((float)$lead['price'], 0, ',', '.') . "đ\n";
    }
    if (!empty($lead['gift'])) {
        $message .= "Quà tặng kèm: " . $lead['gift'] . "\n";
    }
    if (!empty($lead['baby_age'])) {
        $message .= "Tuổi của bé: " . $lead['baby_age'] . "\n";
    }
    if (!empty($lead['concern'])) {
        $message .= "Mẹ quan tâm: " . $lead['concern'] . "\n";
    }
    if (!empty($lead['call_time'])) {
        $message .= "Giờ gọi thuận tiện: " . $lead['call_time'] . "\n";
    }
    if (!empty($lead['note'])) {
        $message .= "Ghi chú thêm: " . $lead['note'] . "\n";
    }
    $message .= "\nNguồn truy cập: " . $lead['source'] . "\n";
    $message .= "Thời gian: " . $lead['created_at'] . "\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');
    @wp_mail($to_email, $subject, $message, $headers);

    // 3. Forward to external webhook if configured
    $webhook_url = lx_get_field('lx_webhook_url', 'option', '');
    if (!empty($webhook_url)) {
        @wp_remote_post($webhook_url, array(
            'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
            'body'        => wp_json_encode($lead),
            'timeout'     => 15,
            'blocking'    => false,
        ));
    }

    wp_send_json_success(array(
        'message' => 'Đăng ký thành công! Chuyên viên Bon Bon sẽ liên hệ với mẹ sớm nhất.',
        'data'    => $lead,
    ));
}
add_action('wp_ajax_lx_submit_lead', 'lx_handle_ajax_lead');
add_action('wp_ajax_nopriv_lx_submit_lead', 'lx_handle_ajax_lead');
