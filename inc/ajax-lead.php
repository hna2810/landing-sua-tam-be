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

    // Process gift and note
    $gift      = isset($_POST['gift']) ? sanitize_text_field(wp_unslash($_POST['gift'])) : '';
    $user_note = isset($_POST['note']) ? sanitize_textarea_field(wp_unslash($_POST['note'])) : '';

    // Gói sản phẩm (Mặc định: Sữa tắm Bon Bon)
    $package_raw = isset($_POST['package']) ? sanitize_text_field(wp_unslash($_POST['package'])) : '';
    if (empty($package_raw) || strpos($package_raw, 'Combo 299K') !== false) {
        $package = 'Sữa tắm Bon Bon';
    } else {
        $package = $package_raw;
    }

    $created_at = current_time('d/m/Y H:i:s');

    // Quà tặng lưu vào cột ghi chú
    $note_content = '';
    if (!empty($gift)) {
        $note_content = 'Quà tặng: ' . $gift;
    }
    if (!empty($user_note)) {
        if (!empty($note_content)) {
            if (strpos($user_note, $gift) === false) {
                $note_content .= ' | ' . $user_note;
            } else {
                $note_content = $user_note;
            }
        } else {
            $note_content = $user_note;
        }
    }

    $lead = array(
        'name'        => $name,
        'phone'       => $phone,
        'address'     => isset($_POST['address']) ? sanitize_text_field(wp_unslash($_POST['address'])) : '',
        'package'     => $package,
        'price'       => isset($_POST['price']) ? sanitize_text_field(wp_unslash($_POST['price'])) : '159000',
        'baby_age'    => isset($_POST['baby_age']) ? sanitize_text_field(wp_unslash($_POST['baby_age'])) : '',
        'concern'     => isset($_POST['concern']) ? sanitize_text_field(wp_unslash($_POST['concern'])) : '',
        'call_time'   => isset($_POST['call_time']) ? sanitize_text_field(wp_unslash($_POST['call_time'])) : '',
        'note'        => $note_content,
        'quiz_result' => isset($_POST['quiz_result']) ? sanitize_text_field(wp_unslash($_POST['quiz_result'])) : '',
        'gift'        => $gift,
        'source'      => isset($_POST['source']) ? sanitize_text_field(wp_unslash($_POST['source'])) : '',
        'page'        => isset($_POST['page']) ? esc_url_raw(wp_unslash($_POST['page'])) : home_url('/'),
        'product'     => $package,
        'created_at'  => $created_at,
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

    // 2. Send email notification (Gửi thông báo về mail)
    $to_email = lx_get_field('lx_lead_email', 'option', 'tuyenhomecare@gmail.com');
    if (empty($to_email) || !is_email($to_email) || $to_email === 'danghuy.homecare@gmail.com' || $to_email === 'thanhlyhrhomecare@gmail.com') {
        $to_email = 'tuyenhomecare@gmail.com';
        update_option('options_lx_lead_email', 'tuyenhomecare@gmail.com');
        update_option('lx_lead_email', 'tuyenhomecare@gmail.com');
        if (function_exists('update_field')) {
            @update_field('lx_lead_email', 'tuyenhomecare@gmail.com', 'option');
        }
    }

    $site_name   = 'Sữa Tắm Gội Bon Bon';
    $host_domain = wp_parse_url(home_url(), PHP_URL_HOST);
    if (empty($host_domain)) {
        $host_domain = 'suatambe.bonbonhomecare.vn';
    }
    $from_email  = 'noreply@' . $host_domain;

    $subject = sprintf('[ĐƠN MỚI] Sữa Tắm Bon Bon - %s (%s)', $lead['name'], $lead['phone']);

    $price_display = '';
    if (!empty($lead['price'])) {
        $price_display = is_numeric($lead['price']) ? number_format((float)$lead['price'], 0, ',', '.') . 'đ' : $lead['price'];
    }

    $message = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:20px;background:#f4f7f9;font-family:Arial,Helvetica,sans-serif;">';
    $message .= '<div style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,0.06);border:1px solid #e2e8f0;">';
    $message .= '<div style="background:linear-gradient(135deg,#4cc0d3,#2ea3b6);padding:24px 20px;text-align:center;color:#ffffff;">';
    $message .= '<h2 style="margin:0;font-size:22px;letter-spacing:0.5px;">🎉 CÓ ĐƠN ĐẶT HÀNG MỚI!</h2>';
    $message .= '<p style="margin:6px 0 0;font-size:14px;opacity:0.92;">Hệ thống Landing Page Sữa Tắm Gội Bon Bon Cho Bé</p>';
    $message .= '</div>';
    $message .= '<div style="padding:24px 20px;">';
    $message .= '<table style="width:100%;border-collapse:collapse;font-size:14px;line-height:1.6;">';
    $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#64748b;width:140px;">👤 <b>Họ tên mẹ:</b></td><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#1e293b;font-weight:700;font-size:16px;">' . esc_html($lead['name']) . '</td></tr>';
    $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#64748b;">📞 <b>Số điện thoại:</b></td><td style="padding:10px 0;border-bottom:1px solid #edf2f7;"><a href="tel:' . esc_attr($lead['phone']) . '" style="color:#4cc0d3;font-weight:700;font-size:16px;text-decoration:none;">' . esc_html($lead['phone']) . '</a></td></tr>';
    if (!empty($lead['address'])) {
        $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#64748b;">📍 <b>Địa chỉ nhận:</b></td><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#1e293b;">' . esc_html($lead['address']) . '</td></tr>';
    }
    if (!empty($lead['package'])) {
        $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#64748b;">📦 <b>Gói sản phẩm:</b></td><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#1e293b;font-weight:600;">' . esc_html($lead['package']) . '</td></tr>';
    }
    if (!empty($price_display)) {
        $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#64748b;">💰 <b>Tổng tiền:</b></td><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#e11d48;font-weight:700;font-size:16px;">' . esc_html($price_display) . '</td></tr>';
    }
    if (!empty($lead['gift'])) {
        $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#64748b;">🎁 <b>Quà tặng may mắn:</b></td><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#d97706;font-weight:700;font-size:15px;">🎉 ' . esc_html($lead['gift']) . '</td></tr>';
    }
    if (!empty($lead['note'])) {
        $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#64748b;">📝 <b>Ghi chú:</b></td><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#1e293b;">' . esc_html($lead['note']) . '</td></tr>';
    }
    $message .= '<tr><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#64748b;">⏰ <b>Thời gian đặt:</b></td><td style="padding:10px 0;border-bottom:1px solid #edf2f7;color:#64748b;">' . esc_html($lead['created_at']) . '</td></tr>';
    $message .= '</table>';
    $message .= '</div>';
    $message .= '<div style="background:#f8fafc;padding:14px 20px;text-align:center;font-size:12px;color:#94a3b8;border-top:1px solid #edf2f7;">';
    $message .= 'Email tự động từ hệ thống Bon Bon Home Care &bull; Vui lòng liên hệ xác nhận đơn sớm với khách hàng.';
    $message .= '</div></div></body></html>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $to_email,
    );

    $filter_from = function() use ($from_email) { return $from_email; };
    $filter_name = function() use ($site_name) { return $site_name; };
    add_filter('wp_mail_from', $filter_from);
    add_filter('wp_mail_from_name', $filter_name);

    @wp_mail($to_email, $subject, $message, $headers);

    remove_filter('wp_mail_from', $filter_from);
    remove_filter('wp_mail_from_name', $filter_name);

    // 3. Forward to external webhook (duy nhất 1 lần từ server để chống lặp đơn)
    $webhook_url = lx_get_field('lx_webhook_url', 'option', '');
    if (!empty($webhook_url)) {
        $webhook_payload = array(
            'time'        => $created_at,
            'created_at'  => $created_at,
            'date'        => $created_at,
            'timestamp'   => $created_at,
            'name'        => $lead['name'],
            'phone'       => $lead['phone'],
            'address'     => $lead['address'],
            'package'     => 'Sữa tắm Bon Bon',
            'product'     => 'Sữa tắm Bon Bon',
            'Gói'         => 'Sữa tắm Bon Bon',
            'goi'         => 'Sữa tắm Bon Bon',
            'Sản phẩm'    => 'Sữa tắm Bon Bon',
            'san_pham'    => 'Sữa tắm Bon Bon',
            'price'       => !empty($lead['price']) ? $lead['price'] : 159000,
            'note'        => $note_content,
            'ghi_chu'     => $note_content,
            'Ghi chú'     => $note_content,
            'ghichu'      => $note_content,
            'note2'       => '',
            'ghi_chu_2'   => '',
            'GHI CHÚ 2'   => '',
            'gift'        => $gift,
            'quatang'     => $gift,
            'Quà tặng'    => $gift,
            'source'      => $lead['source'],
            'page'        => $lead['page'],
            'admin_email' => $to_email,
            'to_email'    => $to_email,
        );

        @wp_remote_post($webhook_url, array(
            'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
            'body'        => wp_json_encode($webhook_payload),
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

/**
 * Diagnostic test mail endpoint
 */
function lx_test_mail_diagnostic() {
    $to = isset($_GET['to']) ? sanitize_email($_GET['to']) : lx_get_field('lx_lead_email', 'option', 'tuyenhomecare@gmail.com');
    if (empty($to) || !is_email($to) || $to === 'danghuy.homecare@gmail.com' || $to === 'thanhlyhrhomecare@gmail.com') {
        $to = 'tuyenhomecare@gmail.com';
        update_option('options_lx_lead_email', 'tuyenhomecare@gmail.com');
        update_option('lx_lead_email', 'tuyenhomecare@gmail.com');
        if (function_exists('update_field')) {
            @update_field('lx_lead_email', 'tuyenhomecare@gmail.com', 'option');
        }
    }
    $err_msg = '';
    add_action('wp_mail_failed', function($wp_error) use (&$err_msg) {
        if (is_wp_error($wp_error)) {
            $err_msg = $wp_error->get_error_message();
        }
    });

    $host_domain = wp_parse_url(home_url(), PHP_URL_HOST);
    if (empty($host_domain)) {
        $host_domain = 'suatambe.bonbonhomecare.vn';
    }
    $from_email = 'noreply@' . $host_domain;
    $site_name  = 'Sữa Tắm Gội Bon Bon';

    $filter_from = function() use ($from_email) { return $from_email; };
    $filter_name = function() use ($site_name) { return $site_name; };
    add_filter('wp_mail_from', $filter_from);
    add_filter('wp_mail_from_name', $filter_name);

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $to,
    );
    $res = wp_mail($to, '[TEST] Thông báo đơn hàng từ Sữa Tắm Bon Bon', '<div style="padding:20px;font-family:sans-serif;"><h3>✅ Test gửi mail thành công!</h3><p>Hệ thống thông báo đơn hàng của Sữa Tắm Bon Bon đã sẵn sàng.</p></div>', $headers);

    remove_filter('wp_mail_from', $filter_from);
    remove_filter('wp_mail_from_name', $filter_name);

    wp_send_json(array(
        'mail_sent'      => $res,
        'to'             => $to,
        'from_email'     => $from_email,
        'admin_email'    => get_option('admin_email'),
        'acf_lead_email' => lx_get_field('lx_lead_email', 'option'),
        'webhook_url'    => lx_get_field('lx_webhook_url', 'option'),
        'error'          => $err_msg,
    ));
}
add_action('wp_ajax_lx_test_mail', 'lx_test_mail_diagnostic');
add_action('wp_ajax_nopriv_lx_test_mail', 'lx_test_mail_diagnostic');
