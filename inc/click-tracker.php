<?php
/**
 * Click Tracker, Interactive Events & Order Leads Manager in WordPress Admin
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Redirect shortcuts /wp-admin/lx-click-stats or /lx-click-stats to correct admin page
 */
function lx_redirect_stats_shortcut() {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    if (strpos($request_uri, 'lx-click-stats') !== false && strpos($request_uri, 'admin.php') === false) {
        wp_safe_redirect(admin_url('admin.php?page=lx-click-stats'));
        exit;
    }
}
add_action('init', 'lx_redirect_stats_shortcut', 1);

/**
 * Add Shortcut to WordPress Admin Bar (Thanh menu đen ở trên cùng)
 */
function lx_add_stats_admin_bar($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    $wp_admin_bar->add_node(array(
        'id'    => 'lx_stats_shortcut',
        'title' => '<span class="ab-icon dashicons dashicons-chart-area" style="top:2px;"></span> <span class="ab-label" style="font-weight:700; color:#38bdf8;">📊 Thống Kê & Đơn Hàng</span>',
        'href'  => admin_url('admin.php?page=lx-click-stats'),
        'meta'  => array('title' => 'Xem Thống Kê Tương Tác, Click và Đơn Hàng'),
    ));
}
add_action('admin_bar_menu', 'lx_add_stats_admin_bar', 100);

/**
 * Handle AJAX tracking from frontend (Contact clicks & Interactive events)
 */
function lx_handle_track_event() {
    $type   = isset($_REQUEST['type']) ? sanitize_key($_REQUEST['type']) : '';
    $label  = isset($_REQUEST['label']) ? sanitize_text_field(wp_unslash($_REQUEST['label'])) : '';
    $detail = isset($_REQUEST['detail']) ? sanitize_text_field(wp_unslash($_REQUEST['detail'])) : '';

    $allowed_types = array(
        'hotline',
        'zalo',
        'bubble_pop',
        'compare_drag',
        'ingredient_game',
        'video_play',
        'wheel_spin',
    );

    if (!in_array($type, $allowed_types, true)) {
        wp_send_json_error(array('message' => 'Invalid event type'));
    }

    $today        = current_time('Y-m-d');
    $now          = current_time('d/m/Y H:i:s');
    $page         = isset($_REQUEST['page']) ? esc_url_raw($_REQUEST['page']) : home_url('/');
    $fbclid       = isset($_REQUEST['fbclid']) ? sanitize_text_field($_REQUEST['fbclid']) : '';
    $utm_source   = isset($_REQUEST['utm_source']) ? sanitize_text_field($_REQUEST['utm_source']) : '';
    $utm_campaign = isset($_REQUEST['utm_campaign']) ? sanitize_text_field($_REQUEST['utm_campaign']) : '';
    $user_agent   = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '';
    $ip           = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field($_SERVER['REMOTE_ADDR']) : '';

    // Khóa chống lặp (Deduplication): Trong vòng 2 giây, cùng 1 IP gửi cùng loại sự kiện thì bỏ qua
    $dedup_key = 'lx_trk_' . md5($ip . '_' . $type . '_' . substr($detail, 0, 20));
    if (get_transient($dedup_key)) {
        if (!empty($_GET['_t'])) {
            header('Content-Type: image/gif');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
            exit;
        }
        wp_send_json_success(array('recorded' => false, 'note' => 'deduplicated'));
    }
    set_transient($dedup_key, 1, 2);

    $entry = array(
        'time'         => $now,
        'date'         => $today,
        'type'         => $type,
        'label'        => $label,
        'detail'       => $detail,
        'page'         => $page,
        'fbclid'       => $fbclid,
        'utm_source'   => $utm_source,
        'utm_campaign' => $utm_campaign,
        'user_agent'   => $user_agent,
        'ip'           => $ip,
    );

    // 1. Phân loại và lưu trữ theo nhóm sự kiện
    if ($type === 'hotline' || $type === 'zalo') {
        // Cập nhật thống kê Click Hotline & Zalo
        $stats = get_option('lx_click_stats_summary', array(
            'total_hotline' => 0,
            'total_zalo'    => 0,
            'by_date'       => array(),
        ));
        if (!is_array($stats)) {
            $stats = array('total_hotline' => 0, 'total_zalo' => 0, 'by_date' => array());
        }
        if (!isset($stats['by_date']) || !is_array($stats['by_date'])) {
            $stats['by_date'] = array();
        }
        if (!isset($stats['by_date'][$today])) {
            $stats['by_date'][$today] = array('hotline' => 0, 'zalo' => 0);
        }

        if ($type === 'hotline') {
            $stats['total_hotline'] = intval(isset($stats['total_hotline']) ? $stats['total_hotline'] : 0) + 1;
            $stats['by_date'][$today]['hotline'] = intval(isset($stats['by_date'][$today]['hotline']) ? $stats['by_date'][$today]['hotline'] : 0) + 1;
        } else {
            $stats['total_zalo'] = intval(isset($stats['total_zalo']) ? $stats['total_zalo'] : 0) + 1;
            $stats['by_date'][$today]['zalo'] = intval(isset($stats['by_date'][$today]['zalo']) ? $stats['by_date'][$today]['zalo'] : 0) + 1;
        }
        update_option('lx_click_stats_summary', $stats, false);

        // Lưu nhật ký click
        $logs = get_option('lx_click_stats_logs', array());
        if (!is_array($logs)) {
            $logs = array();
        }
        array_unshift($logs, $entry);
        if (count($logs) > 300) {
            $logs = array_slice($logs, 0, 300);
        }
        update_option('lx_click_stats_logs', $logs, false);
    } else {
        // Cập nhật thống kê Sự kiện Tương tác (Interactive Events)
        $int_stats = get_option('lx_interactive_stats_summary', array(
            'total_bubble'     => 0,
            'total_compare'    => 0,
            'total_ingredient' => 0,
            'total_video'      => 0,
            'total_wheel'      => 0,
            'by_date'          => array(),
        ));
        if (!is_array($int_stats)) {
            $int_stats = array(
                'total_bubble'     => 0,
                'total_compare'    => 0,
                'total_ingredient' => 0,
                'total_video'      => 0,
                'total_wheel'      => 0,
                'by_date'          => array(),
            );
        }
        if (!isset($int_stats['by_date']) || !is_array($int_stats['by_date'])) {
            $int_stats['by_date'] = array();
        }
        if (!isset($int_stats['by_date'][$today])) {
            $int_stats['by_date'][$today] = array(
                'bubble'     => 0,
                'compare'    => 0,
                'ingredient' => 0,
                'video'      => 0,
                'wheel'      => 0,
            );
        }

        switch ($type) {
            case 'bubble_pop':
                $int_stats['total_bubble'] = intval(isset($int_stats['total_bubble']) ? $int_stats['total_bubble'] : 0) + 1;
                $int_stats['by_date'][$today]['bubble'] = intval(isset($int_stats['by_date'][$today]['bubble']) ? $int_stats['by_date'][$today]['bubble'] : 0) + 1;
                break;
            case 'compare_drag':
                $int_stats['total_compare'] = intval(isset($int_stats['total_compare']) ? $int_stats['total_compare'] : 0) + 1;
                $int_stats['by_date'][$today]['compare'] = intval(isset($int_stats['by_date'][$today]['compare']) ? $int_stats['by_date'][$today]['compare'] : 0) + 1;
                break;
            case 'ingredient_game':
                $int_stats['total_ingredient'] = intval(isset($int_stats['total_ingredient']) ? $int_stats['total_ingredient'] : 0) + 1;
                $int_stats['by_date'][$today]['ingredient'] = intval(isset($int_stats['by_date'][$today]['ingredient']) ? $int_stats['by_date'][$today]['ingredient'] : 0) + 1;
                break;
            case 'video_play':
                $int_stats['total_video'] = intval(isset($int_stats['total_video']) ? $int_stats['total_video'] : 0) + 1;
                $int_stats['by_date'][$today]['video'] = intval(isset($int_stats['by_date'][$today]['video']) ? $int_stats['by_date'][$today]['video'] : 0) + 1;
                break;
            case 'wheel_spin':
                $int_stats['total_wheel'] = intval(isset($int_stats['total_wheel']) ? $int_stats['total_wheel'] : 0) + 1;
                $int_stats['by_date'][$today]['wheel'] = intval(isset($int_stats['by_date'][$today]['wheel']) ? $int_stats['by_date'][$today]['wheel'] : 0) + 1;
                break;
        }
        update_option('lx_interactive_stats_summary', $int_stats, false);

        // Lưu nhật ký tương tác
        $int_logs = get_option('lx_interactive_stats_logs', array());
        if (!is_array($int_logs)) {
            $int_logs = array();
        }
        array_unshift($int_logs, $entry);
        if (count($int_logs) > 500) {
            $int_logs = array_slice($int_logs, 0, 500);
        }
        update_option('lx_interactive_stats_logs', $int_logs, false);
    }

    if (!empty($_GET['_t'])) {
        header('Content-Type: image/gif');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
        exit;
    }

    wp_send_json_success(array('recorded' => true, 'type' => $type));
}
add_action('wp_ajax_nopriv_lx_track_event', 'lx_handle_track_event');
add_action('wp_ajax_lx_track_event', 'lx_handle_track_event');
add_action('wp_ajax_nopriv_lx_track_click', 'lx_handle_track_event');
add_action('wp_ajax_lx_track_click', 'lx_handle_track_event');

/**
 * Handle Export CSV for click stats
 */
function lx_handle_export_click_stats_csv() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'lx-landing'));
    }
    check_admin_referer('lx_export_clicks_action', 'lx_export_clicks_nonce');

    $logs = get_option('lx_click_stats_logs', array());
    if (!is_array($logs)) {
        $logs = array();
    }

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="thong-ke-click-bon-bon-' . date('Y-m-d') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // UTF-8 BOM
    echo "\xEF\xBB\xBF";

    $output = fopen('php://output', 'w');
    fputcsv($output, array('Thời gian', 'Kênh liên hệ', 'Trang web', 'Mã Fbclid', 'UTM Source', 'UTM Campaign', 'Thiết bị', 'Địa chỉ IP'));

    foreach ($logs as $row) {
        $type_text = (isset($row['type']) && $row['type'] === 'hotline') ? 'Hotline (Gọi điện)' : 'Zalo (Nhắn tin)';
        fputcsv($output, array(
            isset($row['time']) ? $row['time'] : '',
            $type_text,
            isset($row['page']) ? $row['page'] : '',
            isset($row['fbclid']) ? $row['fbclid'] : '',
            isset($row['utm_source']) ? $row['utm_source'] : '',
            isset($row['utm_campaign']) ? $row['utm_campaign'] : '',
            isset($row['user_agent']) ? $row['user_agent'] : '',
            isset($row['ip']) ? $row['ip'] : '',
        ));
    }

    fclose($output);
    exit;
}
add_action('admin_post_lx_export_click_stats', 'lx_handle_export_click_stats_csv');

/**
 * Handle Export CSV for Interactive Events
 */
function lx_handle_export_interactive_stats_csv() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'lx-landing'));
    }
    check_admin_referer('lx_export_events_action', 'lx_export_events_nonce');

    $logs = get_option('lx_interactive_stats_logs', array());
    if (!is_array($logs)) {
        $logs = array();
    }

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="tuong-tac-nguoi-dung-bon-bon-' . date('Y-m-d') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    echo "\xEF\xBB\xBF";

    $output = fopen('php://output', 'w');
    fputcsv($output, array('Thời gian', 'Hành vi tương tác', 'Chi tiết hành động', 'Trang web', 'Mã Fbclid', 'UTM Source', 'UTM Campaign', 'Thiết bị', 'Địa chỉ IP'));

    $type_names = array(
        'bubble_pop'      => 'Ấn bong bóng (Hero)',
        'compare_drag'    => 'Kéo thanh so sánh',
        'ingredient_game' => 'Pha chế thành phần vào lọ',
        'video_play'      => 'Xem Video cảm nhận',
        'wheel_spin'      => 'Quay vòng quay may mắn',
    );

    foreach ($logs as $row) {
        $t = isset($row['type']) ? $row['type'] : '';
        $type_text = isset($type_names[$t]) ? $type_names[$t] : $t;

        fputcsv($output, array(
            isset($row['time']) ? $row['time'] : '',
            $type_text,
            isset($row['detail']) ? $row['detail'] : '',
            isset($row['page']) ? $row['page'] : '',
            isset($row['fbclid']) ? $row['fbclid'] : '',
            isset($row['utm_source']) ? $row['utm_source'] : '',
            isset($row['utm_campaign']) ? $row['utm_campaign'] : '',
            isset($row['user_agent']) ? $row['user_agent'] : '',
            isset($row['ip']) ? $row['ip'] : '',
        ));
    }

    fclose($output);
    exit;
}
add_action('admin_post_lx_export_interactive_stats', 'lx_handle_export_interactive_stats_csv');

/**
 * Handle Export CSV for Order Leads
 */
function lx_handle_export_order_leads_csv() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'lx-landing'));
    }
    check_admin_referer('lx_export_leads_action', 'lx_export_leads_nonce');

    global $wpdb;
    $orders = lx_get_unified_orders_list();

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="danh-sach-don-hang-sua-tam-bon-bon-' . date('Y-m-d') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    echo "\xEF\xBB\xBF";

    $output = fopen('php://output', 'w');
    fputcsv($output, array('ID', 'Thời gian đặt', 'Họ và tên', 'Số điện thoại', 'Địa chỉ giao hàng', 'Gói sản phẩm', 'Quà tặng', 'Ghi chú', 'Nguồn quảng cáo', 'Trang đặt hàng'));

    if (!empty($orders)) {
        foreach ($orders as $order) {
            fputcsv($output, array(
                $order['id'],
                $order['date'],
                $order['name'],
                $order['phone'],
                $order['address'],
                $order['package'],
                $order['gift'],
                $order['note'],
                $order['is_fb'] ? 'Facebook Ads' : 'Trực tiếp / Khác',
                $order['url'],
            ));
        }
    }

    fclose($output);
    exit;
}
add_action('admin_post_lx_export_order_leads', 'lx_handle_export_order_leads_csv');

/**
 * Handle Reset Click Stats
 */
function lx_handle_reset_click_stats() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền.', 'lx-landing'));
    }
    check_admin_referer('lx_reset_clicks_action', 'lx_reset_clicks_nonce');

    update_option('lx_click_stats_summary', array(
        'total_hotline' => 0,
        'total_zalo'    => 0,
        'by_date'       => array(),
    ), false);
    update_option('lx_click_stats_logs', array(), false);

    wp_safe_redirect(add_query_arg(array('page' => 'lx-click-stats', 'tab' => 'clicks', 'reset' => '1'), admin_url('admin.php')));
    exit;
}
add_action('admin_post_lx_reset_click_stats', 'lx_handle_reset_click_stats');

/**
 * Handle Reset Interactive Stats
 */
function lx_handle_reset_interactive_stats() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền.', 'lx-landing'));
    }
    check_admin_referer('lx_reset_events_action', 'lx_reset_events_nonce');

    update_option('lx_interactive_stats_summary', array(
        'total_bubble'     => 0,
        'total_compare'    => 0,
        'total_ingredient' => 0,
        'total_video'      => 0,
        'total_wheel'      => 0,
        'by_date'          => array(),
    ), false);
    update_option('lx_interactive_stats_logs', array(), false);

    wp_safe_redirect(add_query_arg(array('page' => 'lx-click-stats', 'tab' => 'interactions', 'reset' => '1'), admin_url('admin.php')));
    exit;
}
add_action('admin_post_lx_reset_interactive_stats', 'lx_handle_reset_interactive_stats');

/**
 * Get unified orders list from both lx_leads_list and cf7db_gsheet_forms
 */
function lx_get_unified_orders_list() {
    global $wpdb;
    $orders = array();
    $seen_phones_times = array();

    // 1. Lấy từ lx_leads_list (được lưu trực tiếp từ form AJAX)
    $leads = get_option('lx_leads_list', array());
    if (!empty($leads) && is_array($leads)) {
        $idx = count($leads);
        foreach ($leads as $l) {
            $phone = isset($l['phone']) ? $l['phone'] : '';
            $date  = isset($l['created_at']) ? $l['created_at'] : '';
            $key   = $phone . '_' . $date;
            $seen_phones_times[$key] = true;

            $url   = isset($l['page']) ? $l['page'] : '';
            $is_fb = (stripos($url, 'fbclid') !== false || stripos(isset($l['source']) ? $l['source'] : '', 'fb') !== false);

            $orders[] = array(
                'id'      => 'AJAX-' . $idx--,
                'date'    => $date,
                'name'    => isset($l['name']) ? $l['name'] : '',
                'phone'   => $phone,
                'address' => isset($l['address']) ? $l['address'] : '',
                'package' => isset($l['package']) ? $l['package'] : (isset($l['product']) ? $l['product'] : 'Sữa tắm Bon Bon'),
                'gift'    => isset($l['gift']) ? $l['gift'] : '',
                'note'    => isset($l['note']) ? $l['note'] : '',
                'is_fb'   => $is_fb,
                'url'     => $url,
            );
        }
    }

    // 2. Lấy bổ sung từ bảng CF7DB (nếu có sử dụng Contact Form 7)
    $table = $wpdb->prefix . 'cf7db_gsheet_forms';
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table}'") === $table) {
        $raw_cf7 = $wpdb->get_results("SELECT id, value, date FROM {$table} ORDER BY id DESC", ARRAY_A);
        if (!empty($raw_cf7)) {
            foreach ($raw_cf7 as $ro) {
                $val = @unserialize($ro['value']);
                if (!is_array($val)) {
                    $val = array();
                }
                $phone = isset($val['your-phone']) ? $val['your-phone'] : '';
                $date  = isset($ro['date']) ? $ro['date'] : '';
                $key   = $phone . '_' . $date;

                // Tránh trùng đơn đã có trong danh sách
                if (isset($seen_phones_times[$key])) {
                    continue;
                }
                $seen_phones_times[$key] = true;

                $url   = isset($val['url']) ? $val['url'] : '';
                $is_fb = (stripos($url, 'fbclid') !== false);
                $pkg   = is_array(isset($val['package']) ? $val['package'] : null) ? implode(', ', $val['package']) : (isset($val['package']) ? $val['package'] : 'Sữa tắm Bon Bon');

                $orders[] = array(
                    'id'      => 'CF7-' . $ro['id'],
                    'date'    => $date,
                    'name'    => isset($val['your-name']) ? $val['your-name'] : '',
                    'phone'   => $phone,
                    'address' => isset($val['your-address']) ? $val['your-address'] : '',
                    'package' => $pkg,
                    'gift'    => isset($val['gift']) ? $val['gift'] : (isset($val['your-gift']) ? $val['your-gift'] : ''),
                    'note'    => isset($val['your-message']) ? $val['your-message'] : '',
                    'is_fb'   => $is_fb,
                    'url'     => $url,
                );
            }
        }
    }

    return $orders;
}

/**
 * Register Top-Level Menu & Submenu in WordPress Admin
 */
function lx_register_click_stats_menu() {
    add_menu_page(
        'Thống Kê & Đơn Hàng',
        'Thống Kê & Đơn',
        'manage_options',
        'lx-click-stats',
        'lx_render_click_stats_page',
        'dashicons-chart-area',
        3
    );

    add_submenu_page(
        'lx-landing-settings',
        'Thống Kê & Đơn Hàng',
        'Thống Kê & Đơn Hàng',
        'manage_options',
        'lx-click-stats',
        'lx_render_click_stats_page'
    );
}
add_action('admin_menu', 'lx_register_click_stats_menu', 20);

/**
 * Register Dashboard Widget
 */
function lx_register_dashboard_click_widget() {
    wp_add_dashboard_widget(
        'lx_dashboard_click_stats',
        '📊 Thống Kê Nhanh (Đơn Hàng, Click & Tương Tác)',
        'lx_render_dashboard_click_widget'
    );
}
add_action('wp_dashboard_setup', 'lx_register_dashboard_click_widget');

/**
 * Render Dashboard Widget Content
 */
function lx_render_dashboard_click_widget() {
    $stats = get_option('lx_click_stats_summary', array(
        'total_hotline' => 0,
        'total_zalo'    => 0,
        'by_date'       => array(),
    ));

    $int_stats = get_option('lx_interactive_stats_summary', array(
        'total_bubble'     => 0,
        'total_compare'    => 0,
        'total_ingredient' => 0,
        'total_video'      => 0,
        'total_wheel'      => 0,
        'by_date'          => array(),
    ));

    $today         = current_time('Y-m-d');
    $today_hotline = intval(isset($stats['by_date'][$today]['hotline']) ? $stats['by_date'][$today]['hotline'] : 0);
    $today_zalo    = intval(isset($stats['by_date'][$today]['zalo']) ? $stats['by_date'][$today]['zalo'] : 0);
    $total_hotline = intval(isset($stats['total_hotline']) ? $stats['total_hotline'] : 0);
    $total_zalo    = intval(isset($stats['total_zalo']) ? $stats['total_zalo'] : 0);

    $today_bubble  = intval(isset($int_stats['by_date'][$today]['bubble']) ? $int_stats['by_date'][$today]['bubble'] : 0);
    $today_compare = intval(isset($int_stats['by_date'][$today]['compare']) ? $int_stats['by_date'][$today]['compare'] : 0);
    $today_ingre   = intval(isset($int_stats['by_date'][$today]['ingredient']) ? $int_stats['by_date'][$today]['ingredient'] : 0);
    $today_video   = intval(isset($int_stats['by_date'][$today]['video']) ? $int_stats['by_date'][$today]['video'] : 0);
    $today_wheel   = intval(isset($int_stats['by_date'][$today]['wheel']) ? $int_stats['by_date'][$today]['wheel'] : 0);

    $orders = lx_get_unified_orders_list();
    $total_orders = count($orders);
    ?>
    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:10px; margin-bottom:14px; text-align:center;">
        <div style="background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:8px;">
            <div style="font-size:11px; color:#be123c; font-weight:700;">🛒 ĐƠN FORM</div>
            <div style="font-size:20px; font-weight:800; color:#e11d48; margin:2px 0;"><?php echo $total_orders; ?></div>
            <div style="font-size:11px; color:#64748b;">Đã lưu hệ thống</div>
        </div>
        <div style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px; padding:8px;">
            <div style="font-size:11px; color:#0369a1; font-weight:700;">📞 HOTLINE</div>
            <div style="font-size:20px; font-weight:800; color:#0284c7; margin:2px 0;"><?php echo $total_hotline; ?></div>
            <div style="font-size:11px; color:#64748b;">Hôm nay: <strong><?php echo $today_hotline; ?></strong></div>
        </div>
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:8px;">
            <div style="font-size:11px; color:#15803d; font-weight:700;">💬 ZALO</div>
            <div style="font-size:20px; font-weight:800; color:#16a34a; margin:2px 0;"><?php echo $total_zalo; ?></div>
            <div style="font-size:11px; color:#64748b;">Hôm nay: <strong><?php echo $today_zalo; ?></strong></div>
        </div>
    </div>
    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px; margin-bottom:12px; font-size:12px;">
        <div style="font-weight:700; color:#334155; margin-bottom:6px;">🎮 Tương tác khách hôm nay:</div>
        <div style="display:flex; flex-wrap:wrap; gap:8px;">
            <span>🎈 Ấn bóng: <strong><?php echo $today_bubble; ?></strong></span>
            <span>↔️ Kéo so sánh: <strong><?php echo $today_compare; ?></strong></span>
            <span>🧪 Pha chế: <strong><?php echo $today_ingre; ?></strong></span>
            <span>▶️ Xem video: <strong><?php echo $today_video; ?></strong></span>
            <span>🎡 Quay thưởng: <strong><?php echo $today_wheel; ?></strong></span>
        </div>
    </div>
    <div style="text-align:right;">
        <a href="<?php echo esc_url(admin_url('admin.php?page=lx-click-stats')); ?>" class="button button-primary">Xem chi tiết & Xuất dữ liệu &rarr;</a>
    </div>
    <?php
}

/**
 * Render Click Stats, Interactive Events & Orders Page in WP Admin
 */
function lx_render_click_stats_page() {
    $stats = get_option('lx_click_stats_summary', array(
        'total_hotline' => 0,
        'total_zalo'    => 0,
        'by_date'       => array(),
    ));

    $int_stats = get_option('lx_interactive_stats_summary', array(
        'total_bubble'     => 0,
        'total_compare'    => 0,
        'total_ingredient' => 0,
        'total_video'      => 0,
        'total_wheel'      => 0,
        'by_date'          => array(),
    ));

    $today         = current_time('Y-m-d');
    $today_hotline = intval(isset($stats['by_date'][$today]['hotline']) ? $stats['by_date'][$today]['hotline'] : 0);
    $today_zalo    = intval(isset($stats['by_date'][$today]['zalo']) ? $stats['by_date'][$today]['zalo'] : 0);
    $total_hotline = intval(isset($stats['total_hotline']) ? $stats['total_hotline'] : 0);
    $total_zalo    = intval(isset($stats['total_zalo']) ? $stats['total_zalo'] : 0);
    $total_clicks  = $total_hotline + $total_zalo;

    $total_bubble  = intval(isset($int_stats['total_bubble']) ? $int_stats['total_bubble'] : 0);
    $total_compare = intval(isset($int_stats['total_compare']) ? $int_stats['total_compare'] : 0);
    $total_ingre   = intval(isset($int_stats['total_ingredient']) ? $int_stats['total_ingredient'] : 0);
    $total_video   = intval(isset($int_stats['total_video']) ? $int_stats['total_video'] : 0);
    $total_wheel   = intval(isset($int_stats['total_wheel']) ? $int_stats['total_wheel'] : 0);

    $today_bubble  = intval(isset($int_stats['by_date'][$today]['bubble']) ? $int_stats['by_date'][$today]['bubble'] : 0);
    $today_compare = intval(isset($int_stats['by_date'][$today]['compare']) ? $int_stats['by_date'][$today]['compare'] : 0);
    $today_ingre   = intval(isset($int_stats['by_date'][$today]['ingredient']) ? $int_stats['by_date'][$today]['ingredient'] : 0);
    $today_video   = intval(isset($int_stats['by_date'][$today]['video']) ? $int_stats['by_date'][$today]['video'] : 0);
    $today_wheel   = intval(isset($int_stats['by_date'][$today]['wheel']) ? $int_stats['by_date'][$today]['wheel'] : 0);

    $by_date = isset($stats['by_date']) && is_array($stats['by_date']) ? $stats['by_date'] : array();
    krsort($by_date);

    $int_by_date = isset($int_stats['by_date']) && is_array($int_stats['by_date']) ? $int_stats['by_date'] : array();
    krsort($int_by_date);

    $logs = get_option('lx_click_stats_logs', array());
    if (!is_array($logs)) {
        $logs = array();
    }

    $int_logs = get_option('lx_interactive_stats_logs', array());
    if (!is_array($int_logs)) {
        $int_logs = array();
    }

    $orders = lx_get_unified_orders_list();
    $total_orders = count($orders);

    $orders_today = 0;
    $orders_yesterday = 0;
    $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($today)));

    foreach ($orders as $o) {
        $odate = '';
        if (!empty($o['date'])) {
            $parts = explode(' ', $o['date']);
            $first_part = $parts[0];
            // Nếu lưu theo d/m/Y
            if (strpos($first_part, '/') !== false) {
                $dp = explode('/', $first_part);
                if (count($dp) === 3) {
                    $odate = $dp[2] . '-' . $dp[1] . '-' . $dp[0];
                }
            } else {
                $odate = $first_part;
            }
        }
        if ($odate === $today) {
            $orders_today++;
        } elseif ($odate === $yesterday) {
            $orders_yesterday++;
        }
    }

    $current_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'orders';
    ?>
    <div class="wrap" style="max-width:1340px;">
        <h1 style="display:flex; align-items:center; gap:10px; margin-bottom:18px;">
            <span class="dashicons dashicons-chart-area" style="font-size:32px; width:32px; height:32px; color:#0284c7;"></span>
            Trung Tâm Thống Kê & Quản Lý Đơn Hàng (Sữa Tắm Bon Bon)
        </h1>

        <?php if (!empty($_GET['reset'])) : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Đã làm mới dữ liệu thống kê thành công!</strong></p>
            </div>
        <?php endif; ?>

        <!-- TOP STATS CARDS -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:14px; margin-bottom:24px;">
            <!-- Tổng đơn hàng Card -->
            <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:14px 18px; box-shadow:0 1px 3px rgba(0,0,0,0.05); border-left:4px solid #e11d48;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Tổng Đơn Điền Form</span>
                    <span class="dashicons dashicons-cart" style="color:#e11d48; font-size:22px;"></span>
                </div>
                <div style="font-size:28px; font-weight:800; color:#0f172a; margin:4px 0 2px 0;"><?php echo number_format_i18n($total_orders); ?></div>
                <div style="font-size:12px; color:#64748b;">
                    Hôm nay: <strong style="color:#e11d48;"><?php echo $orders_today; ?></strong> | Hôm qua: <strong><?php echo $orders_yesterday; ?></strong>
                </div>
            </div>

            <!-- Hotline Card -->
            <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:14px 18px; box-shadow:0 1px 3px rgba(0,0,0,0.05); border-left:4px solid #0284c7;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Click Gọi Hotline</span>
                    <span class="dashicons dashicons-phone" style="color:#0284c7; font-size:22px;"></span>
                </div>
                <div style="font-size:28px; font-weight:800; color:#0f172a; margin:4px 0 2px 0;"><?php echo number_format_i18n($total_hotline); ?></div>
                <div style="font-size:12px; color:#64748b;">
                    Hôm nay: <strong style="color:#0284c7;"><?php echo $today_hotline; ?></strong> lượt
                </div>
            </div>

            <!-- Zalo Card -->
            <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:14px 18px; box-shadow:0 1px 3px rgba(0,0,0,0.05); border-left:4px solid #16a34a;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Click Chat Zalo</span>
                    <span class="dashicons dashicons-format-chat" style="color:#16a34a; font-size:22px;"></span>
                </div>
                <div style="font-size:28px; font-weight:800; color:#0f172a; margin:4px 0 2px 0;"><?php echo number_format_i18n($total_zalo); ?></div>
                <div style="font-size:12px; color:#64748b;">
                    Hôm nay: <strong style="color:#16a34a;"><?php echo $today_zalo; ?></strong> lượt
                </div>
            </div>

            <!-- Bubble Pop Card (Ấn bóng) -->
            <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:14px 18px; box-shadow:0 1px 3px rgba(0,0,0,0.05); border-left:4px solid #f43f5e;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">🎈 Ấn Bong Bóng</span>
                    <span style="font-size:18px;">🫧</span>
                </div>
                <div style="font-size:28px; font-weight:800; color:#0f172a; margin:4px 0 2px 0;"><?php echo number_format_i18n($total_bubble); ?></div>
                <div style="font-size:12px; color:#64748b;">
                    Hôm nay: <strong style="color:#f43f5e;"><?php echo $today_bubble; ?></strong> lượt
                </div>
            </div>

            <!-- Compare Slider Card (Kéo so sánh) -->
            <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:14px 18px; box-shadow:0 1px 3px rgba(0,0,0,0.05); border-left:4px solid #8b5cf6;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">↔️ Kéo So Sánh</span>
                    <span style="font-size:18px;">⚡</span>
                </div>
                <div style="font-size:28px; font-weight:800; color:#0f172a; margin:4px 0 2px 0;"><?php echo number_format_i18n($total_compare); ?></div>
                <div style="font-size:12px; color:#64748b;">
                    Hôm nay: <strong style="color:#8b5cf6;"><?php echo $today_compare; ?></strong> lượt
                </div>
            </div>

            <!-- Ingredient Mini Game Card (Pha chế) -->
            <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:14px 18px; box-shadow:0 1px 3px rgba(0,0,0,0.05); border-left:4px solid #10b981;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">🧪 Kéo/Chạm Thành Phần</span>
                    <span style="font-size:18px;">🧴</span>
                </div>
                <div style="font-size:28px; font-weight:800; color:#0f172a; margin:4px 0 2px 0;"><?php echo number_format_i18n($total_ingre); ?></div>
                <div style="font-size:12px; color:#64748b;">
                    Hôm nay: <strong style="color:#10b981;"><?php echo $today_ingre; ?></strong> lượt
                </div>
            </div>

            <!-- Video Play Card (Play video) -->
            <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:14px 18px; box-shadow:0 1px 3px rgba(0,0,0,0.05); border-left:4px solid #f97316;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">▶️ Xem Video Reels</span>
                    <span style="font-size:18px;">🎬</span>
                </div>
                <div style="font-size:28px; font-weight:800; color:#0f172a; margin:4px 0 2px 0;"><?php echo number_format_i18n($total_video); ?></div>
                <div style="font-size:12px; color:#64748b;">
                    Hôm nay: <strong style="color:#f97316;"><?php echo $today_video; ?></strong> lượt
                </div>
            </div>

            <!-- Wheel Spin Card (Quay vòng quay) -->
            <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:14px 18px; box-shadow:0 1px 3px rgba(0,0,0,0.05); border-left:4px solid #eab308;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">🎡 Quay Vòng Quay</span>
                    <span style="font-size:18px;">🎁</span>
                </div>
                <div style="font-size:28px; font-weight:800; color:#0f172a; margin:4px 0 2px 0;"><?php echo number_format_i18n($total_wheel); ?></div>
                <div style="font-size:12px; color:#64748b;">
                    Hôm nay: <strong style="color:#ca8a04;"><?php echo $today_wheel; ?></strong> lượt
                </div>
            </div>
        </div>

        <!-- NAVIGATION TABS -->
        <h2 class="nav-tab-wrapper" style="margin-bottom:20px;">
            <a href="<?php echo esc_url(admin_url('admin.php?page=lx-click-stats&tab=orders')); ?>" class="nav-tab <?php echo ($current_tab === 'orders') ? 'nav-tab-active' : ''; ?>" style="font-weight:700; font-size:14px;">
                🛒 Danh Sách Đơn Điền Form (<?php echo $total_orders; ?>)
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=lx-click-stats&tab=interactions')); ?>" class="nav-tab <?php echo ($current_tab === 'interactions') ? 'nav-tab-active' : ''; ?>" style="font-weight:700; font-size:14px;">
                🎮 Tương Tác Khách Hàng (Ấn bóng, Kéo, Pha chế, Video, Vòng quay)
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=lx-click-stats&tab=clicks')); ?>" class="nav-tab <?php echo ($current_tab === 'clicks') ? 'nav-tab-active' : ''; ?>" style="font-weight:700; font-size:14px;">
                📞 Thống Kê Click Hotline & Zalo
            </a>
        </h2>

        <?php if ($current_tab === 'orders') : ?>
            <!-- ================= TAB 1: ĐƠN HÀNG ================= -->
            <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:12px;">
                    <div>
                        <h3 style="margin:0 0 4px 0; font-size:16px; color:#0f172a;">Lịch Sử Đơn Đặt Hàng Bon Bon</h3>
                        <p style="margin:0; font-size:12px; color:#64748b;">Dữ liệu đơn hàng được lưu tự động từ biểu mẫu đặt hàng của landing page.</p>
                    </div>
                    <div>
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <input type="hidden" name="action" value="lx_export_order_leads">
                            <?php wp_nonce_field('lx_export_leads_action', 'lx_export_leads_nonce'); ?>
                            <button type="submit" class="button button-primary button-large" style="display:flex; align-items:center; gap:6px;">
                                <span class="dashicons dashicons-download" style="margin-top:3px;"></span>
                                <strong>Xuất File Excel (CSV) Đơn Hàng</strong>
                            </button>
                        </form>
                    </div>
                </div>

                <div style="overflow-x:auto;">
                    <table class="widefat striped" style="border:none;">
                        <thead>
                            <tr style="background:#f8fafc;">
                                <th style="font-size:12px; width:70px;">Mã</th>
                                <th style="font-size:12px; width:140px;">Thời gian</th>
                                <th style="font-size:12px; width:160px;">Khách hàng</th>
                                <th style="font-size:12px; width:130px;">Số điện thoại</th>
                                <th style="font-size:12px;">Địa chỉ giao hàng</th>
                                <th style="font-size:12px; width:200px;">Gói đặt mua</th>
                                <th style="font-size:12px; width:160px;">Quà tặng vòng quay</th>
                                <th style="font-size:12px; width:100px;">Nguồn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orders)) : ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; padding:30px; color:#94a3b8;">Chưa có đơn hàng nào.</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($orders as $order) : ?>
                                    <tr>
                                        <td style="font-size:12px; color:#94a3b8; font-weight:700;">#<?php echo esc_html($order['id']); ?></td>
                                        <td style="font-size:12px; white-space:nowrap;"><?php echo esc_html($order['date']); ?></td>
                                        <td style="font-size:13px; font-weight:700; color:#0f172a;"><?php echo esc_html($order['name']); ?></td>
                                        <td>
                                            <a href="tel:<?php echo esc_attr($order['phone']); ?>" style="font-size:13px; font-weight:700; color:#0284c7; text-decoration:none;">
                                                📞 <?php echo esc_html($order['phone']); ?>
                                            </a>
                                        </td>
                                        <td style="font-size:12px; color:#334155;">
                                            <?php echo !empty($order['address']) ? esc_html($order['address']) : '<span style="color:#cbd5e1;">(Chưa nhập)</span>'; ?>
                                        </td>
                                        <td style="font-size:12px;">
                                            <span style="display:inline-block; padding:3px 8px; border-radius:6px; background:#fef2f2; color:#b91c1c; font-weight:700;">
                                                <?php echo esc_html($order['package']); ?>
                                            </span>
                                        </td>
                                        <td style="font-size:12px;">
                                            <?php if (!empty($order['gift'])) : ?>
                                                <span style="display:inline-block; padding:3px 8px; border-radius:6px; background:#fef3c7; color:#92400e; font-weight:700;">
                                                    🎁 <?php echo esc_html($order['gift']); ?>
                                                </span>
                                            <?php else : ?>
                                                <span style="color:#cbd5e1;">(Không có)</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($order['is_fb']) : ?>
                                                <span style="display:inline-block; padding:2px 8px; border-radius:12px; background:#dbeafe; color:#1d4ed8; font-size:11px; font-weight:700;">FB Ads</span>
                                            <?php else : ?>
                                                <span style="display:inline-block; padding:2px 8px; border-radius:12px; background:#f1f5f9; color:#64748b; font-size:11px;">Direct/Web</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php elseif ($current_tab === 'interactions') : ?>
            <!-- ================= TAB 2: TƯƠNG TÁC NGƯỜI DÙNG ================= -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:12px;">
                <div style="display:flex; gap:8px;">
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                        <input type="hidden" name="action" value="lx_export_interactive_stats">
                        <?php wp_nonce_field('lx_export_events_action', 'lx_export_events_nonce'); ?>
                        <button type="submit" class="button button-primary" style="display:flex; align-items:center; gap:4px;">
                            <span class="dashicons dashicons-download" style="margin-top:2px;"></span>
                            <strong>Xuất File CSV Tương Tác</strong>
                        </button>
                    </form>
                </div>
                <div>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" onsubmit="return confirm('Bạn có chắc chắn muốn đặt lại dữ liệu tương tác người dùng?');">
                        <input type="hidden" name="action" value="lx_reset_interactive_stats">
                        <?php wp_nonce_field('lx_reset_events_action', 'lx_reset_events_nonce'); ?>
                        <button type="submit" class="button" style="color:#e11d48;">
                            <span class="dashicons dashicons-trash" style="margin-top:2px;"></span> Đặt lại số liệu tương tác
                        </button>
                    </form>
                </div>
            </div>

            <div style="display:grid; grid-template-columns: 380px 1fr; gap:20px;">
                <!-- Cột thống kê tương tác theo ngày -->
                <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:16px; box-shadow:0 1px 3px rgba(0,0,0,0.05); height:fit-content;">
                    <h3 style="margin-top:0; font-size:15px; border-bottom:1px solid #f1f5f9; padding-bottom:8px;">📅 Tương Tác Theo Ngày</h3>
                    <?php if (empty($int_by_date)) : ?>
                        <p style="color:#94a3b8; font-size:13px; text-align:center; padding:20px 0;">Chưa có dữ liệu tương tác nào.</p>
                    <?php else : ?>
                        <table class="widefat striped" style="border:none;">
                            <thead>
                                <tr>
                                    <th style="font-size:11px;">Ngày</th>
                                    <th style="font-size:11px; text-align:center;" title="Ấn bóng">🎈 Bóng</th>
                                    <th style="font-size:11px; text-align:center;" title="Kéo so sánh">↔️ Kéo</th>
                                    <th style="font-size:11px; text-align:center;" title="Pha chế">🧪 Chế</th>
                                    <th style="font-size:11px; text-align:center;" title="Play video">▶️ Video</th>
                                    <th style="font-size:11px; text-align:center;" title="Quay thưởng">🎡 Quay</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($int_by_date as $date => $counts) : 
                                    $b = intval(isset($counts['bubble']) ? $counts['bubble'] : 0);
                                    $c = intval(isset($counts['compare']) ? $counts['compare'] : 0);
                                    $g = intval(isset($counts['ingredient']) ? $counts['ingredient'] : 0);
                                    $v = intval(isset($counts['video']) ? $counts['video'] : 0);
                                    $w = intval(isset($counts['wheel']) ? $counts['wheel'] : 0);
                                    $display_date = date('d/m/Y', strtotime($date));
                                    if ($date === $today) {
                                        $display_date .= ' (Hôm nay)';
                                    }
                                ?>
                                    <tr>
                                        <td style="font-size:11px; font-weight:600;"><?php echo esc_html($display_date); ?></td>
                                        <td style="font-size:11px; text-align:center; color:#f43f5e; font-weight:700;"><?php echo $b; ?></td>
                                        <td style="font-size:11px; text-align:center; color:#8b5cf6; font-weight:700;"><?php echo $c; ?></td>
                                        <td style="font-size:11px; text-align:center; color:#10b981; font-weight:700;"><?php echo $g; ?></td>
                                        <td style="font-size:11px; text-align:center; color:#f97316; font-weight:700;"><?php echo $v; ?></td>
                                        <td style="font-size:11px; text-align:center; color:#ca8a04; font-weight:700;"><?php echo $w; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

                <!-- Cột nhật ký tương tác gần nhất -->
                <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:16px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="margin-top:0; font-size:15px; border-bottom:1px solid #f1f5f9; padding-bottom:8px;">
                        📝 Nhật Ký 50 Lượt Tương Tác Gần Nhất
                    </h3>
                    <?php if (empty($int_logs)) : ?>
                        <p style="color:#94a3b8; font-size:13px; text-align:center; padding:40px 0;">
                            Chưa có sự kiện tương tác nào được ghi nhận.<br>
                            <small style="color:#cbd5e1;">Hệ thống sẽ tự động cập nhật ngay khi khách hàng bấm bóng, kéo so sánh, chọn thành phần, phát video hoặc quay thưởng trên trang.</small>
                        </p>
                    <?php else : 
                        $recent_int = array_slice($int_logs, 0, 50);
                    ?>
                        <div style="overflow-x:auto;">
                            <table class="widefat striped" style="border:none;">
                                <thead>
                                    <tr>
                                        <th style="font-size:12px; width:130px;">Thời gian</th>
                                        <th style="font-size:12px; width:150px;">Hành vi tương tác</th>
                                        <th style="font-size:12px;">Chi tiết hành động</th>
                                        <th style="font-size:12px; width:140px;">Thiết bị</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_int as $entry) : 
                                        $t = isset($entry['type']) ? $entry['type'] : '';
                                        $badge_bg = '#f1f5f9'; $badge_col = '#475569'; $badge_label = 'Tương tác';
                                        switch ($t) {
                                            case 'bubble_pop':
                                                $badge_bg = '#ffe4e6'; $badge_col = '#e11d48'; $badge_label = '🎈 Ấn bong bóng';
                                                break;
                                            case 'compare_drag':
                                                $badge_bg = '#ede9fe'; $badge_col = '#6d28d9'; $badge_label = '↔️ Kéo so sánh';
                                                break;
                                            case 'ingredient_game':
                                                $badge_bg = '#d1fae5'; $badge_col = '#047857'; $badge_label = '🧪 Pha chế thành phần';
                                                break;
                                            case 'video_play':
                                                $badge_bg = '#ffedd5'; $badge_col = '#c2410c'; $badge_label = '▶️ Xem video';
                                                break;
                                            case 'wheel_spin':
                                                $badge_bg = '#fef08a'; $badge_col = '#854d0e'; $badge_label = '🎡 Quay vòng quay';
                                                break;
                                        }
                                    ?>
                                        <tr>
                                            <td style="font-size:12px; white-space:nowrap;"><?php echo esc_html(isset($entry['time']) ? $entry['time'] : ''); ?></td>
                                            <td>
                                                <span style="display:inline-block; padding:2px 8px; border-radius:12px; background:<?php echo $badge_bg; ?>; color:<?php echo $badge_col; ?>; font-weight:700; font-size:11px;">
                                                    <?php echo esc_html($badge_label); ?>
                                                </span>
                                            </td>
                                            <td style="font-size:12px; font-weight:600; color:#1e293b;">
                                                <?php echo esc_html(isset($entry['detail']) ? $entry['detail'] : ''); ?>
                                                <?php if (!empty($entry['utm_source'])) : ?>
                                                    <span style="font-size:11px; color:#64748b; margin-left:6px;">[<?php echo esc_html($entry['utm_source']); ?>]</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="font-size:11px; color:#64748b; white-space:nowrap;">
                                                <?php 
                                                $ua = isset($entry['user_agent']) ? $entry['user_agent'] : '';
                                                if (stripos($ua, 'iPhone') !== false) {
                                                    echo '📱 iPhone (iOS)';
                                                } elseif (stripos($ua, 'Android') !== false) {
                                                    echo '📱 Android Mobile';
                                                } elseif (stripos($ua, 'Windows') !== false) {
                                                    echo '💻 Windows PC';
                                                } elseif (stripos($ua, 'Mac') !== false) {
                                                    echo '💻 Mac Desktop';
                                                } else {
                                                    echo '🌐 Trình duyệt web';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php else : ?>
            <!-- ================= TAB 3: CLICK HOTLINE & ZALO ================= -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <div style="display:flex; gap:8px;">
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                        <input type="hidden" name="action" value="lx_export_click_stats">
                        <?php wp_nonce_field('lx_export_clicks_action', 'lx_export_clicks_nonce'); ?>
                        <button type="submit" class="button button-primary" style="display:flex; align-items:center; gap:4px;">
                            <span class="dashicons dashicons-download" style="margin-top:2px;"></span> Xuất File CSV Click
                        </button>
                    </form>
                </div>
                <div>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" onsubmit="return confirm('Bạn có chắc chắn muốn đặt lại toàn bộ số liệu thống kê click?');">
                        <input type="hidden" name="action" value="lx_reset_click_stats">
                        <?php wp_nonce_field('lx_reset_clicks_action', 'lx_reset_clicks_nonce'); ?>
                        <button type="submit" class="button" style="color:#e11d48;">
                            <span class="dashicons dashicons-trash" style="margin-top:2px;"></span> Đặt lại số liệu click
                        </button>
                    </form>
                </div>
            </div>

            <div style="display:grid; grid-template-columns: 320px 1fr; gap:20px;">
                <!-- Cột thống kê theo ngày -->
                <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:16px; box-shadow:0 1px 3px rgba(0,0,0,0.05); height:fit-content;">
                    <h3 style="margin-top:0; font-size:15px; border-bottom:1px solid #f1f5f9; padding-bottom:8px;">📅 Lượt Click Theo Ngày</h3>
                    <?php if (empty($by_date)) : ?>
                        <p style="color:#94a3b8; font-size:13px; text-align:center; padding:20px 0;">Chưa có dữ liệu lượt click nào.</p>
                    <?php else : ?>
                        <table class="widefat striped" style="border:none;">
                            <thead>
                                <tr>
                                    <th style="font-size:12px;">Ngày</th>
                                    <th style="font-size:12px; text-align:center;">Hotline</th>
                                    <th style="font-size:12px; text-align:center;">Zalo</th>
                                    <th style="font-size:12px; text-align:right;">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($by_date as $date => $counts) : 
                                    $h = intval(isset($counts['hotline']) ? $counts['hotline'] : 0);
                                    $z = intval(isset($counts['zalo']) ? $counts['zalo'] : 0);
                                    $display_date = date('d/m/Y', strtotime($date));
                                    if ($date === $today) {
                                        $display_date .= ' (Hôm nay)';
                                    }
                                ?>
                                    <tr>
                                        <td style="font-size:12px; font-weight:600;"><?php echo esc_html($display_date); ?></td>
                                        <td style="font-size:12px; text-align:center; color:#0284c7; font-weight:700;"><?php echo $h; ?></td>
                                        <td style="font-size:12px; text-align:center; color:#16a34a; font-weight:700;"><?php echo $z; ?></td>
                                        <td style="font-size:12px; text-align:right; font-weight:700;"><?php echo $h + $z; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

                <!-- Cột chi tiết nhật ký click -->
                <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:16px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="margin-top:0; font-size:15px; border-bottom:1px solid #f1f5f9; padding-bottom:8px;">
                        📝 Nhật Ký 50 Lượt Click Gần Nhất
                    </h3>
                    <?php if (empty($logs)) : ?>
                        <p style="color:#94a3b8; font-size:13px; text-align:center; padding:40px 0;">
                            Chưa có lượt click nào được ghi nhận.<br>
                            <small style="color:#cbd5e1;">Hệ thống sẽ tự động cập nhật ngay khi khách hàng bấm Hotline hoặc Zalo trên trang web.</small>
                        </p>
                    <?php else : 
                        $recent_logs = array_slice($logs, 0, 50);
                    ?>
                        <div style="overflow-x:auto;">
                            <table class="widefat striped" style="border:none;">
                                <thead>
                                    <tr>
                                        <th style="font-size:12px;">Thời gian</th>
                                        <th style="font-size:12px;">Kênh</th>
                                        <th style="font-size:12px;">Nguồn Ads / Fbclid</th>
                                        <th style="font-size:12px;">Thiết bị</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_logs as $entry) : 
                                        $is_hotline = (isset($entry['type']) && $entry['type'] === 'hotline');
                                    ?>
                                        <tr>
                                            <td style="font-size:12px; white-space:nowrap;"><?php echo esc_html(isset($entry['time']) ? $entry['time'] : ''); ?></td>
                                            <td>
                                                <?php if ($is_hotline) : ?>
                                                    <span style="display:inline-block; padding:2px 8px; border-radius:12px; background:#e0f2fe; color:#0369a1; font-weight:700; font-size:11px;">📞 HOTLINE</span>
                                                <?php else : ?>
                                                    <span style="display:inline-block; padding:2px 8px; border-radius:12px; background:#dcfce7; color:#15803d; font-weight:700; font-size:11px;">💬 ZALO</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="font-size:12px;">
                                                <?php 
                                                $ads_info = array();
                                                if (!empty($entry['fbclid'])) {
                                                    $ads_info[] = '<span title="' . esc_attr($entry['fbclid']) . '" style="color:#1d4ed8; font-family:monospace;">fbclid: ' . esc_html(substr($entry['fbclid'], 0, 15)) . '...</span>';
                                                }
                                                if (!empty($entry['utm_source'])) {
                                                    $ads_info[] = 'source: <strong>' . esc_html($entry['utm_source']) . '</strong>';
                                                }
                                                if (!empty($entry['utm_campaign'])) {
                                                    $ads_info[] = 'campaign: ' . esc_html($entry['utm_campaign']);
                                                }
                                                if (empty($ads_info)) {
                                                    echo '<span style="color:#94a3b8;">Trực tiếp / Không qua Ads</span>';
                                                } else {
                                                    echo implode(' | ', $ads_info);
                                                }
                                                ?>
                                            </td>
                                            <td style="font-size:11px; color:#64748b; max-width:260px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="<?php echo esc_attr(isset($entry['user_agent']) ? $entry['user_agent'] : ''); ?>">
                                                <?php 
                                                $ua = isset($entry['user_agent']) ? $entry['user_agent'] : '';
                                                if (stripos($ua, 'iPhone') !== false) {
                                                    echo '📱 iPhone (iOS)';
                                                } elseif (stripos($ua, 'Android') !== false) {
                                                    echo '📱 Android Mobile';
                                                } elseif (stripos($ua, 'Windows') !== false) {
                                                    echo '💻 Windows PC';
                                                } elseif (stripos($ua, 'Mac') !== false) {
                                                    echo '💻 Mac Desktop';
                                                } else {
                                                    echo '🌐 Trình duyệt web';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
