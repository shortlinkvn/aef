<?php
/**
 * Truy vấn lịch trình dùng chung cho trang chủ và trang /programme/.
 *
 * Chưa được gọi ở đâu trong theme — đây là bước chuẩn bị dữ liệu (thêm menu_order,
 * show_on_home, is_key, is_live cho CPT aef_session) trước khi thay mảng slug cứng
 * trong inc/home.php (aef_home_block_programme) bằng truy vấn động. Việc thay thế
 * đó sẽ làm ở một bước riêng, sau khi đã kiểm tra kỹ để không đổi giao diện trang
 * chủ đang chạy thật.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Lấy danh sách phiên trong 1 ngày (taxonomy aef_day), sắp theo menu_order.
 *
 * @param string     $day_slug Slug của term aef_day.
 * @param string|null $room    Giá trị đúng như lưu trong meta 'room' (VD 'Room 01').
 *                             Để trống/null = không lọc theo phòng.
 * @param array      $args     Ghi đè thêm cho WP_Query nếu cần (merge nông, không
 *                             gộp sâu 'meta_query'/'tax_query' — dùng khi chắc chắn
 *                             không xung đột với mặc định bên dưới).
 * @return WP_Query
 */
function aef_schedule_query( $day_slug, $room = null, $args = array() ) {
	$query_args = array(
		'post_type'      => 'aef_session',
		'posts_per_page' => 100,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'aef_day',
				'field'    => 'slug',
				'terms'    => $day_slug,
			),
		),
	);

	if ( null !== $room && '' !== $room ) {
		$query_args['meta_query'] = array(
			array(
				'key'   => 'room',
				'value' => $room,
			),
		);
	}

	$query_args = wp_parse_args( $args, $query_args );

	return new WP_Query( $query_args );
}

/**
 * Danh sách phiên "hiện ở trang chủ" (show_on_home = 1) trong 1 ngày, đã sắp theo
 * menu_order — dùng để thay cho mảng slug cứng trong inc/home.php.
 *
 * @param string $day_slug Slug của term aef_day.
 * @return WP_Post[]
 */
function aef_home_schedule_items( $day_slug ) {
	$q = aef_schedule_query(
		$day_slug,
		null,
		array(
			'meta_query' => array(
				array(
					'key'   => 'show_on_home',
					'value' => '1',
				),
			),
		)
	);

	return $q->posts;
}
