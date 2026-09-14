<?php
/**
 * Plugin Name: AEF Migrate — cờ hiển thị trang chủ + thứ tự phiên
 * Description: Di trú CHẠY 1 LẦN DUY NHẤT: gán menu_order, show_on_home, is_key, is_live
 *              cho đúng các phiên đang được liệt kê cứng trong inc/home.php
 *              (aef_home_block_programme), để chuẩn bị chuyển khối lịch trình trang chủ
 *              sang truy vấn động (aef_schedule_query) thay vì mảng slug hard-code.
 *              KHÔNG đụng tới trường 'room' — dữ liệu đó do người biên tập tự quản,
 *              không có cách nào suy ra an toàn từ file này.
 *              An toàn khi chạy nhiều lần: có cờ chặn (option aef_schedule_flags_v1),
 *              giống hệt cách aef_khung_2508_v1() trong functions.php đã làm.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'aef_schedule_flags_v1', 44 );
function aef_schedule_flags_v1() {
	if ( get_option( 'aef_schedule_flags_v1' ) ) {
		return;
	}

	// Đúng nội dung mảng cứng hiện có trong inc/home.php (hàm aef_home_block_programme),
	// bỏ 2 dòng "_thematic" / "_arena" vì đó là thẻ liên kết tổng hợp, không phải 1 phiên thật.
	$days = array(
		'26' => array( 'dual-transition-conference', 'vietnam-india-future-tech', 'oid-2026', 'ceo-500-tea-connect' ),
		'27' => array( '27-oct-opening', 'official-reception', 'business-networking-dinner' ),
		'28' => array( 'high-level-plenary', 'pm-dialogue', 'ministerial-dialogue', 'gala-dinner' ),
		'29' => array( 'vietnam-israel-innovation-day', 'vietnam-china-investment', 'nordic-investment', 'field-visits', 'c4ir-network-meeting' ),
	);
	$key_slugs  = array( 'ceo-500-tea-connect', 'high-level-plenary', 'pm-dialogue', 'official-reception', 'c4ir-network-meeting' );
	$live_slugs = array( 'high-level-plenary', 'pm-dialogue' );

	$done   = 0;
	$missed = array();

	foreach ( $days as $day_num => $slugs ) {
		$order = 0;
		foreach ( $slugs as $slug ) {
			$post = get_page_by_path( $slug, OBJECT, 'aef_session' );
			if ( ! $post ) {
				$missed[] = $slug;
				continue;
			}
			update_post_meta( $post->ID, 'show_on_home', '1' );
			update_post_meta( $post->ID, 'is_key', in_array( $slug, $key_slugs, true ) ? '1' : '0' );
			update_post_meta( $post->ID, 'is_live', in_array( $slug, $live_slugs, true ) ? '1' : '0' );
			if ( (int) $post->menu_order !== $order ) {
				wp_update_post(
					array(
						'ID'         => $post->ID,
						'menu_order' => $order,
					)
				);
			}
			++$order;
			++$done;
		}
	}

	update_option(
		'aef_schedule_flags_v1',
		array(
			'done_at' => current_time( 'mysql' ),
			'done'    => $done,
			'missed'  => $missed,
		)
	);

	if ( $missed ) {
		add_action(
			'admin_notices',
			function () use ( $missed ) {
				echo '<div class="notice notice-warning"><p><strong>Di trú lịch trình AEF:</strong> không tìm thấy phiên với slug: ' . esc_html( implode( ', ', $missed ) ) . ' — kiểm tra lại đường dẫn (slug) của các phiên này, rồi vào Cài đặt kỳ → xoá option <code>aef_schedule_flags_v1</code> để chạy lại nếu cần.</p></div>';
			}
		);
	} else {
		add_action(
			'admin_notices',
			function () use ( $done ) {
				echo '<div class="notice notice-success is-dismissible"><p><strong>Di trú lịch trình AEF:</strong> đã gán thứ tự và cờ hiển thị trang chủ cho ' . intval( $done ) . ' phiên.</p></div>';
			}
		);
	}
}
