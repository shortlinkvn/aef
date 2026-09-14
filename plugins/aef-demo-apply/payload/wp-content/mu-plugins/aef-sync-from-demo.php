<?php
/**
 * Import editorial from DEMO CHATGPT programme-data.json into aef_session meta.
 * Does not invent speakers. Does not change official 25–30 / 27–28 calendar.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aef_demo_slug_map() {
	return array(
		'AEF27-R1-S1'    => 'repositioning-vietnam-asean',
		'AEF27-R2-S1'    => 'financial-innovation-ifc',
		'AEF27-R3-S1'    => 'advanced-manufacturing',
		'AEF27-R1-S2'    => 'ai-megacity-governance',
		'AEF27-R2-S2'    => 'digital-economy-policy',
		'AEF27-R3-S2'    => 'industrial-ai',
		'AEF27-R1-S3'    => 'ai-workforce-readiness',
		'AEF27-R2-S3'    => 'data-security-quantum',
		'AEF27-R3-S3'    => 'smart-agriculture',
		'AEF27-R1-S4'    => 'smart-manufacturing-logistics',
		'AEF27-R2-S4'    => 'sovereign-ai',
		'AEF27-R3-S4'    => 'esg-corporate-strategy',
		'AEF27-R1-S5'    => 'esg-circular-economy',
		'AEF27-R2-S5'    => 'dual-use-industries',
		'AEF27-R3-S5'    => 'green-consumption',
		'AEF27-R1-S6'    => 'quantum-ecosystem',
		'AEF27-R2-S6'    => 'low-altitude-economy',
		'AEF27-R3-S6'    => 'global-future-leaders',
		'AEF26-CEO500'   => 'ceo-500-tea-connect',
		'AEF27-RISING'   => 'rising-star-arena',
		'AEF27-RECEPTION'=> 'official-reception',
		'AEF27-BIZDINNER'=> 'business-networking-dinner',
		'AEF28-INVEST'   => 'investment-roundtable',
		'AEF28-OPENING'  => 'secretary-remarks',
		'AEF28-PLENARY'  => 'high-level-plenary',
		'AEF28-GLOBAL'   => 'in-depth-panels',
		'AEF28-MINISTERIAL' => 'ministerial-dialogue',
		'AEF28-PM'       => 'pm-dialogue',
		'AEF28-CLOSING1' => 'closing-session',
		'AEF28-CLOSING2' => 'chairman-remarks',
		'AEF28-GALA'     => 'gala-dinner',
	);
}

function aef_demo_json_path() {
	$theme = get_template_directory() . '/assets/data/programme-data.json';
	if ( file_exists( $theme ) ) {
		return $theme;
	}
	return dirname( __DIR__ ) . '/wp-content/themes/aef-2026/assets/data/programme-data.json';
}

function aef_demo_en() {
	static $en = null;
	if ( $en !== null ) {
		return $en;
	}
	$path = dirname( aef_demo_json_path() ) . '/programme-editorial-en.php';
	$en   = file_exists( $path ) ? include $path : array();
	return is_array( $en ) ? $en : array();
}

function aef_demo_upsert_page( $slug, $title_vi, $title_en, $excerpt_vi, $content_vi, $content_en = '' ) {
	if ( function_exists( 'aef_upsert_page' ) && ! defined( 'AEF_RUNNING_SEED' ) ) {
		return aef_upsert_page( $slug, $title_vi, $title_en, $excerpt_vi, $content_vi, $content_en );
	}
	$existing = get_page_by_path( $slug );
	$data     = array(
		'post_title'   => $title_vi,
		'post_name'    => $slug,
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_excerpt' => $excerpt_vi,
		'post_content' => $content_vi,
	);
	if ( $existing ) {
		$data['ID'] = $existing->ID;
		$id         = wp_update_post( $data );
	} else {
		$id = wp_insert_post( $data );
	}
	if ( $id && ! is_wp_error( $id ) ) {
		update_post_meta( $id, 'title_en', $title_en );
		update_post_meta( $id, 'content_en', $content_en ? $content_en : $content_vi );
	}
	return $id;
}

function aef_ensure_topics_page() {
	aef_demo_upsert_page(
		'topics',
		'Bốn trụ cột',
		'Four content pillars',
		'Mỗi trụ cột mở ra một chuỗi câu hỏi chính sách và cơ hội hợp tác.',
		'Mỗi trụ cột mở ra một chuỗi câu hỏi chính sách và cơ hội hợp tác, được triển khai xuyên suốt các phiên thảo luận và hoạt động bên lề. Bốn trụ cột là khung tư duy, không phải bốn phiên riêng.',
		'Each pillar opens a set of policy questions and cooperation opportunities that run through the sessions and side events. The four pillars are a thinking frame, not four separate sessions.'
	);
	$partners = get_page_by_path( 'partners' );
	if ( ! $partners ) {
		aef_demo_upsert_page(
			'partners',
			'Đơn vị & đối tác',
			'Organisations & partners',
			'Hệ thống nhận diện được trình bày theo vai trò. Phân hạng chờ Ban Tổ chức duyệt.',
			'Hệ thống nhận diện được trình bày theo vai trò. Toàn bộ danh sách và phân hạng cần được Ban Tổ chức duyệt trước công bố.',
			'Identity is shown by role. The full list and any tiers need Organising Committee approval before public release.'
		);
	}
}

function aef_sync_from_demo() {
	aef_ensure_topics_page();
	$path = aef_demo_json_path();
	if ( ! file_exists( $path ) ) {
		return 0;
	}
	$data = json_decode( file_get_contents( $path ), true );
	if ( ! is_array( $data ) ) {
		return 0;
	}
	$map = aef_demo_slug_map();
	$en  = aef_demo_en();
	$n   = 0;
	$items = array();
	if ( ! empty( $data['sessions'] ) ) {
		foreach ( $data['sessions'] as $row ) {
			$row['kind_vi'] = 'Phiên chuyên đề';
			$row['kind_en'] = 'Thematic session';
			$items[] = $row;
		}
	}
	if ( ! empty( $data['events'] ) ) {
		foreach ( $data['events'] as $row ) {
			$row['kind_vi'] = isset( $row['type'] ) ? $row['type'] : 'Sự kiện';
			$row['kind_en'] = isset( $row['type'] ) ? $row['type'] : 'Event';
			$items[] = $row;
		}
	}
	foreach ( $items as $row ) {
		if ( empty( $row['id'] ) || empty( $map[ $row['id'] ] ) ) {
			continue;
		}
		$post = get_page_by_path( $map[ $row['id'] ], OBJECT, 'aef_session' );
		if ( ! $post ) {
			continue;
		}
		$id = $post->ID;
		$e  = isset( $en[ $row['id'] ] ) ? $en[ $row['id'] ] : array();
		update_post_meta( $id, 'session_id', $row['id'] );
		update_post_meta( $id, 'date_label', isset( $row['date'] ) ? $row['date'] : '' );
		update_post_meta( $id, 'kind', aef_lang_is_vi() ? $row['kind_vi'] : $row['kind_en'] );
		update_post_meta( $id, 'kind_vi', $row['kind_vi'] );
		update_post_meta( $id, 'kind_en', $row['kind_en'] );
		if ( ! empty( $row['tags'] ) && is_array( $row['tags'] ) ) {
			update_post_meta( $id, 'tags', implode( ', ', $row['tags'] ) );
		}
		if ( ! empty( $row['short'] ) ) {
			update_post_meta( $id, 'short_vi', $row['short'] );
		}
		if ( ! empty( $row['long'] ) ) {
			update_post_meta( $id, 'long_vi', $row['long'] );
		}
		if ( ! empty( $row['questions'] ) && is_array( $row['questions'] ) ) {
			update_post_meta( $id, 'questions_vi', implode( "\n", $row['questions'] ) );
		}
		if ( ! empty( $e['short'] ) ) {
			update_post_meta( $id, 'short_en', $e['short'] );
		} elseif ( ! empty( $row['short'] ) ) {
			update_post_meta( $id, 'short_en', $row['short'] );
		}
		if ( ! empty( $e['long'] ) ) {
			update_post_meta( $id, 'long_en', $e['long'] );
		} elseif ( ! empty( $row['long'] ) ) {
			update_post_meta( $id, 'long_en', $row['long'] );
		}
		if ( ! empty( $e['questions'] ) && is_array( $e['questions'] ) ) {
			update_post_meta( $id, 'questions_en', implode( "\n", $e['questions'] ) );
		} elseif ( ! empty( $row['questions'] ) && is_array( $row['questions'] ) ) {
			update_post_meta( $id, 'questions_en', implode( "\n", $row['questions'] ) );
		}
		if ( ! empty( $row['en'] ) ) {
			update_post_meta( $id, 'title_en', $row['en'] );
		}
		if ( ! empty( $row['vi'] ) ) {
			update_post_meta( $id, 'title_vi', $row['vi'] );
		}
		$n++;
	}
	aef_apply_contentweb_copy();
	flush_rewrite_rules( false );
	return $n;
}

function aef_apply_contentweb_copy() {
	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$copy['home_hero_cta1_en'] = 'Explore the programme';
	$copy['home_hero_cta1_vi'] = 'Khám phá chương trình';
	$copy['home_hero_cta2_en'] = 'About AEF 2026';
	$copy['home_hero_cta2_vi'] = 'Tìm hiểu về AEF 2026';
	$copy['block_outcomes']    = '1';
	$copy['block_audience']    = '1';
	$copy['block_week']        = '0';
	update_option( 'aef_copy', $copy );

	if ( function_exists( 'aef_demo_upsert_page' ) ) {
		aef_demo_upsert_page(
			'travel',
			'Cẩm nang đi lại',
			'Travel kit',
			'Địa điểm, lưu trú, di chuyển và gợi ý thành phố cho đại biểu AEF 2026.',
			'Dự thảo. Danh sách khách sạn là tham khảo khu trung tâm, không phải danh sách Ban Tổ chức.',
			'Draft. The hotel list is a central-city reference, not the Organising Committee list.'
		);
	}

	$set = aef_settings();
	$set['theme_lead_vi']  = 'Bốn trụ cột là khung tư duy xuyên suốt, được lồng ghép vào nội dung và cách đặt vấn đề của các phiên — không phải bốn phiên độc lập.';
	$set['theme_lead_en']  = 'The four pillars are a thinking frame that runs through the sessions. They are not four separate sessions.';
	$set['host_3_role_vi'] = 'Đơn vị thực hiện · phối hợp WEF';
	$set['host_3_role_en'] = 'Implementing centre · cooperating with WEF';
	update_option( 'aef_settings', $set );

	foreach ( array(
		'thematic' => array(
			'Mười tám phiên song song tại ba phòng, Rising Star Arena cả ngày (mỗi phiên 45 phút).',
			'Eighteen parallel sessions in three rooms, plus the Rising Star Arena all day (45 minutes each).',
		),
		'high-level' => array(
			'Gặp gỡ nhà đầu tư, phiên toàn thể, tham luận chuyên sâu, đối thoại Bộ trưởng, đối thoại cùng Thủ tướng và Gala.',
			'Investment roundtable, high-level plenary, in-depth panels, ministerial dialogue, dialogue with the Prime Minister, and Gala.',
		),
	) as $slug => $notes ) {
		$term = get_term_by( 'slug', $slug, 'aef_day' );
		if ( $term && ! is_wp_error( $term ) ) {
			wp_update_term( $term->term_id, 'aef_day', array( 'description' => $notes[0] ) );
			update_term_meta( $term->term_id, 'note_en', $notes[1] );
		}
	}
}

function aef_lang_is_vi() {
	return function_exists( 'aef_lang' ) && aef_lang() === 'vi';
}
