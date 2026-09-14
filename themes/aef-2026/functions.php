<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aef_lang() {
	if ( isset( $_GET['lang'] ) && in_array( $_GET['lang'], array( 'vi', 'en' ), true ) ) {
		return $_GET['lang'];
	}
	if ( ! empty( $_COOKIE['aef_lang'] ) && in_array( $_COOKIE['aef_lang'], array( 'vi', 'en' ), true ) ) {
		return $_COOKIE['aef_lang'];
	}
	$s = function_exists( 'aef_settings' ) ? aef_settings() : array();
	return ( isset( $s['default_lang'] ) && $s['default_lang'] === 'vi' ) ? 'vi' : 'en';
}

function aef_t( $pair ) {
	$l = aef_lang();
	if ( is_array( $pair ) ) {
		if ( isset( $pair[ $l ] ) ) {
			return $pair[ $l ];
		}
		return reset( $pair );
	}
	return $pair;
}

function aef_img( $file ) {
	return get_template_directory_uri() . '/assets/' . ltrim( $file, '/' );
}

function aef_illustration_credit() {
	return aef_t( array( 'en' => 'Illustration', 'vi' => 'Ảnh minh họa' ) );
}

function aef_story_image( $post_id, $size = 'large' ) {
	$post_id = absint( $post_id );
	$thumb   = get_the_post_thumbnail_url( $post_id, $size );
	if ( $thumb ) {
		return $thumb;
	}
	$slug = get_post_field( 'post_name', $post_id );
	$kind = function_exists( 'aef_meta' ) ? aef_meta( $post_id, 'story_kind', 'news' ) : 'news';
	$by_slug = array(
		'aef-2026-forum-week'           => 'plenary.jpg',
		'aef-2026-forum-week-programme' => 'ceo500.jpg',
		'working-as-press-at-aef-2026'  => 'youth.jpg',
		'aef-2025-official-recap'       => 'expo.jpg',
	);
	$by_kind = array(
		'news'     => 'visual/forum-hall.jpg',
		'press'    => 'youth.jpg',
		'video'    => 'plenary.jpg',
		'document' => 'visual/pillar-cooperation.jpg',
	);
	$file = isset( $by_slug[ $slug ] ) ? $by_slug[ $slug ] : ( isset( $by_kind[ $kind ] ) ? $by_kind[ $kind ] : 'visual/forum-hall.jpg' );
	return aef_img( $file );
}

function aef_edition_image( $year ) {
	$map = array(
		'2026' => 'visual/forum-hall.jpg',
		'2025' => 'plenary.jpg',
		'2024' => 'expo.jpg',
		'2023' => 'youth.jpg',
		'2022' => 'ceo500.jpg',
		'2021' => 'hall.jpg',
		'2020' => 'visual/hcmc-dusk.jpg',
		'2019' => 'bridge.jpg',
		'2018' => 'skyline.jpg',
	);
	$year = (string) $year;
	return aef_img( isset( $map[ $year ] ) ? $map[ $year ] : 'visual/hcmc-dusk.jpg' );
}

function aef_logo( $file ) {
	return get_template_directory_uri() . '/assets/logos/' . ltrim( $file, '/' );
}

function aef_c4ir_mark( $on_dark = false ) {
	$file = $on_dark ? 'vietnam-c4ir-on-dark.png' : 'vietnam-c4ir.png';
	$url  = aef_logo( $file );
	$path = get_template_directory() . '/assets/logos/' . $file;
	$ver  = file_exists( $path ) ? (string) filemtime( $path ) : '2';
	return $url . '?v=' . rawurlencode( $ver );
}

require_once get_template_directory() . '/inc/reference.php';
require_once get_template_directory() . '/inc/travel.php';
require_once get_template_directory() . '/inc/editions.php';
require_once get_template_directory() . '/inc/media.php';
require_once get_template_directory() . '/inc/home.php';

function aef_session_lang( $post_id = 0 ) {
	$en = $post_id ? aef_meta( $post_id, 'lang_en' ) : '';
	$vi = $post_id ? aef_meta( $post_id, 'lang_vi' ) : '';
	if ( aef_lang() === 'vi' ) {
		return $vi ? $vi : 'Tiếng Việt · Tiếng Anh';
	}
	return $en ? $en : 'Vietnamese · English';
}

function aef_lang_link( $lang ) {
	return esc_url( add_query_arg( 'lang', $lang ) );
}

function aef_meta( $post_id, $key, $fallback = '' ) {
	$v = get_post_meta( $post_id, $key, true );
	return $v !== '' && $v !== false ? $v : $fallback;
}

function aef_editions_query( $args = array() ) {
	$defaults = array(
		'post_type'      => 'aef_edition',
		'posts_per_page' => 20,
		'orderby'        => 'name',
		'order'          => 'DESC',
	);
	return new WP_Query( array_merge( $defaults, $args ) );
}

function aef_speaker_public_args( $args = array() ) {
	$defaults = array(
		'post_type'      => 'aef_speaker',
		'posts_per_page' => 80,
		'orderby'        => 'menu_order title',
	);
	return array_merge( $defaults, $args );
}

function aef_looks_vietnamese( $text ) {
	return is_string( $text ) && (bool) preg_match( '/[ĂÂÊÔƠƯĐăâêôơưđÁÀẢÃẠẮẰẲẴẶẤẦẨẪẬÉÈẺẼẸẾỀỂỄỆÍÌỈĨỊÓÒỎÕỌỐỒỔỖỘỚỜỞỠỢÚÙỦŨỤỨỪỬỮỰÝỲỶỸỴáàảãạắằẳẵặấầẩẫậéèẻẽẹếềểễệíìỉĩịóòỏõọốồổỗộớờởỡợúùủũụứừửữựýỳỷỹỵ]/u', $text );
}

function aef_bilingual_title( $post_id ) {
	$l  = aef_lang();
	$en = get_post_meta( $post_id, 'title_en', true );
	$vi = get_post_meta( $post_id, 'title_vi', true );
	$wp = get_the_title( $post_id );
	if ( 'vi' === $l ) {
		return $vi ? $vi : $wp;
	}
	if ( $en ) {
		return $en;
	}
	if ( $wp && ! aef_looks_vietnamese( $wp ) ) {
		return $wp;
	}
	return $en ? $en : $wp;
}

function aef_bilingual_excerpt( $post_id ) {
	$l   = aef_lang();
	$en  = get_post_meta( $post_id, 'excerpt_en', true );
	$vi  = get_post_meta( $post_id, 'excerpt_vi', true );
	$post = get_post( $post_id );
	$raw  = $post ? $post->post_excerpt : '';
	if ( 'vi' === $l ) {
		return $vi ? $vi : $raw;
	}
	if ( $en ) {
		return $en;
	}
	if ( $raw && ! aef_looks_vietnamese( $raw ) ) {
		return $raw;
	}
	return '';
}

function aef_bilingual_content( $post_id ) {
	$l  = aef_lang();
	$en = get_post_meta( $post_id, 'content_en', true );
	$vi = get_post_meta( $post_id, 'content_vi', true );
	$post = get_post( $post_id );
	$raw  = $post ? $post->post_content : '';
	if ( 'vi' === $l ) {
		return $vi ? $vi : $raw;
	}
	return $en ? $en : $raw;
}

function aef_menu_item_title( $item ) {
	$en = get_post_meta( $item->ID, '_aef_title_en', true );
	$vi = get_post_meta( $item->ID, '_aef_title_vi', true );
	if ( function_exists( 'aef_lang' ) && 'vi' === aef_lang() ) {
		if ( $vi ) {
			return $vi;
		}
		return $item->title;
	}
	if ( $en ) {
		return $en;
	}
	return $item->title;
}

class AEF_Nav_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$wrap  = is_object( $args ) && ! empty( $args->aef_wrap );
		$class = $wrap ? 'nav-link' : '';
		$title = aef_menu_item_title( $data_object );
		if ( $wrap ) {
			$output .= '<div class="nav-item">';
		}
		$output .= '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $data_object->url ) . '">' . esc_html( $title ) . '</a>';
		if ( $wrap ) {
			$output .= '</div>';
		}
	}
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
}

function aef_render_menu( $location, $wrap = false ) {
	if ( ! has_nav_menu( $location ) ) {
		return false;
	}
	wp_nav_menu(
		array(
			'theme_location' => $location,
			'container'      => false,
			'fallback_cb'    => false,
			'items_wrap'     => '%3$s',
			'depth'          => 1,
			'walker'         => new AEF_Nav_Walker(),
			'aef_wrap'       => $wrap,
		)
	);
	return true;
}

add_action( 'init', 'aef_retire_public_draft', 39 );
function aef_retire_public_draft() {
	if ( get_option( 'aef_retire_public_draft_v1' ) ) {
		return;
	}
	$chrome = get_option( 'aef_chrome', array() );
	if ( ! is_array( $chrome ) ) {
		$chrome = array();
	}
	$chrome['ribbon_on'] = '0';
	update_option( 'aef_chrome', $chrome );

	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$copy['home_programme_note_en'] = '';
	$copy['home_programme_note_vi'] = '';
	update_option( 'aef_copy', $copy );

	$set = get_option( 'aef_settings', array() );
	if ( is_array( $set ) ) {
		$set['programme_status'] = 'live';
		update_option( 'aef_settings', $set );
	}
	update_option( 'aef_retire_public_draft_v1', '1' );
}

add_action( 'init', 'aef_retire_public_draft_v2', 39 );
function aef_retire_public_draft_v2() {
	if ( get_option( 'aef_retire_public_draft_v2' ) ) {
		return;
	}
	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$copy['home_edition_lead_en'] = 'Figures from Organising Committee materials for the 2025 edition.';
	$copy['home_edition_lead_vi'] = 'Số liệu theo tư liệu Ban Tổ chức cho kỳ 2025.';
	update_option( 'aef_copy', $copy );
	update_option( 'aef_retire_public_draft_v2', '1' );
}

add_action( 'init', 'aef_editorial_local_v1', 41 );
function aef_editorial_local_v1() {
	if ( get_option( 'aef_editorial_local_v1' ) ) {
		return;
	}
	if ( ! function_exists( 'aef_default_copy' ) ) {
		return;
	}
	$defaults = aef_default_copy();
	$copy     = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$overwrite = array(
		'block_intro', 'block_figures', 'block_side', 'block_close',
		'home_hero_lead_en', 'home_hero_lead_vi',
		'home_hero_cta2_en', 'home_hero_cta2_vi',
		'home_intro_eyebrow_en', 'home_intro_eyebrow_vi',
		'home_intro_title_en', 'home_intro_title_vi',
		'home_intro_lead_en', 'home_intro_lead_vi',
		'home_figures_title_en', 'home_figures_title_vi',
		'home_fig_1_n', 'home_fig_1_en', 'home_fig_1_vi',
		'home_fig_2_n', 'home_fig_2_en', 'home_fig_2_vi',
		'home_fig_3_n', 'home_fig_3_en', 'home_fig_3_vi',
		'home_fig_4_n', 'home_fig_4_n_en', 'home_fig_4_n_vi', 'home_fig_4_en', 'home_fig_4_vi',
		'home_theme_eyebrow_en', 'home_theme_eyebrow_vi',
		'home_theme_title_en', 'home_theme_title_vi',
		'home_theme_lead_en', 'home_theme_lead_vi',
		'home_pillars_title_en', 'home_pillars_title_vi',
		'home_pillars_lead_en', 'home_pillars_lead_vi',
		'home_programme_overline_en', 'home_programme_overline_vi',
		'home_programme_title_en', 'home_programme_title_vi',
		'home_programme_lead_en', 'home_programme_lead_vi',
		'home_speakers_title_en', 'home_speakers_title_vi',
		'home_speakers_lead_en', 'home_speakers_lead_vi',
		'home_speakers_cta_en', 'home_speakers_cta_vi',
		'home_side_title_en', 'home_side_title_vi',
		'home_side_lead_en', 'home_side_lead_vi',
		'home_side_1_en', 'home_side_1_vi',
		'home_side_2_en', 'home_side_2_vi',
		'home_side_3_en', 'home_side_3_vi',
		'home_side_4_en', 'home_side_4_vi',
		'home_side_5_en', 'home_side_5_vi',
		'home_side_6_en', 'home_side_6_vi',
		'home_side_7_en', 'home_side_7_vi',
		'home_close_title_en', 'home_close_title_vi',
		'home_close_lead_en', 'home_close_lead_vi',
		'home_close_cta1_en', 'home_close_cta1_vi',
		'home_close_cta2_en', 'home_close_cta2_vi',
	);
	foreach ( $overwrite as $key ) {
		if ( isset( $defaults[ $key ] ) ) {
			$copy[ $key ] = $defaults[ $key ];
		}
	}
	$copy['block_intro']   = '1';
	$copy['block_figures'] = '1';
	$copy['block_side']    = '1';
	$copy['block_close']   = '1';
	update_option( 'aef_copy', $copy );

	if ( function_exists( 'aef_home_default_order' ) ) {
		update_option( 'aef_home_order', aef_home_default_order() );
	}

	if ( function_exists( 'aef_about_defaults' ) ) {
		$about     = get_option( 'aef_about', array() );
		$a_default = aef_about_defaults();
		if ( ! is_array( $about ) ) {
			$about = array();
		}
		$a_keys = array(
			'about_title_en', 'about_title_vi', 'about_deck_en', 'about_deck_vi',
			'about_lead_en', 'about_lead_vi', 'about_body_en', 'about_body_vi',
			'about_quote_en', 'about_quote_vi',
			'about_why_h_en', 'about_why_h_vi', 'about_why_p_en', 'about_why_p_vi',
			'about_vn_h_en', 'about_vn_h_vi', 'about_vn_p_en', 'about_vn_p_vi',
			'about_city_h_en', 'about_city_h_vi', 'about_city_p_en', 'about_city_p_vi',
			'about_theme_h_en', 'about_theme_h_vi', 'about_theme_p_en', 'about_theme_p_vi',
			'about_values_h_en', 'about_values_h_vi',
			'about_v1_h_en', 'about_v1_h_vi', 'about_v1_p_en', 'about_v1_p_vi',
			'about_v2_h_en', 'about_v2_h_vi', 'about_v2_p_en', 'about_v2_p_vi',
			'about_v3_h_en', 'about_v3_h_vi', 'about_v3_p_en', 'about_v3_p_vi',
			'about_v4_h_en', 'about_v4_h_vi', 'about_v4_p_en', 'about_v4_p_vi',
			'about_v5_h_en', 'about_v5_h_vi', 'about_v5_p_en', 'about_v5_p_vi',
			'about_annual_h_en', 'about_annual_h_vi',
		);
		foreach ( $a_keys as $key ) {
			if ( isset( $a_default[ $key ] ) ) {
				$about[ $key ] = $a_default[ $key ];
			}
		}
		update_option( 'aef_about', $about );
	}

	update_option( 'aef_editorial_local_v1', '1' );
}

add_action( 'init', 'aef_khung_2026_v1', 42 );
function aef_khung_2026_v1() {
	if ( get_option( 'aef_khung_2026_v1' ) ) {
		return;
	}
	if ( ! function_exists( 'aef_default_settings' ) ) {
		return;
	}

	$set = get_option( 'aef_settings', array() );
	if ( ! is_array( $set ) ) {
		$set = array();
	}
	$d = aef_default_settings();
	foreach ( array( 'official_name_en', 'official_name_vi', 'positioning_en', 'positioning_vi', 'theme_en', 'theme_vi', 'week_dates', 'main_dates', 'programme_updated' ) as $key ) {
		if ( isset( $d[ $key ] ) ) {
			$set[ $key ] = $d[ $key ];
		}
	}
	update_option( 'aef_settings', $set );
	update_option( 'blogdescription', $d['positioning_en'] );

	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$cd = function_exists( 'aef_default_copy' ) ? aef_default_copy() : array();
	foreach ( array(
		'home_fig_3_n', 'home_fig_3_en', 'home_fig_3_vi',
		'home_programme_lead_en', 'home_programme_lead_vi',
		'home_side_lead_en', 'home_side_lead_vi',
	) as $key ) {
		if ( isset( $cd[ $key ] ) ) {
			$copy[ $key ] = $cd[ $key ];
		}
	}
	update_option( 'aef_copy', $copy );

	$about = get_option( 'aef_about', array() );
	if ( ! is_array( $about ) ) {
		$about = array();
	}
	$ad = function_exists( 'aef_about_defaults' ) ? aef_about_defaults() : array();
	foreach ( array( 'about_body_en', 'about_body_vi' ) as $key ) {
		if ( isset( $ad[ $key ] ) ) {
			$about[ $key ] = $ad[ $key ];
		}
	}
	update_option( 'aef_about', $about );

	$coming = get_option( 'aef_coming', array() );
	if ( ! is_array( $coming ) ) {
		$coming = array();
	}
	$coming['coming_pos_en']      = $d['positioning_en'];
	$coming['coming_pos_vi']      = $d['positioning_vi'];
	$coming['coming_theme_en']    = $d['theme_en'];
	$coming['coming_theme_vi']    = $d['theme_vi'];
	$coming['coming_meta1_value'] = $d['week_dates'];
	update_option( 'aef_coming', $coming );

	$days = array(
		'thematic'   => array(
			'27.10',
			'Phát biểu khai mạc của Phó Chủ tịch UBND Thành phố, sau đó 15 phiên thảo luận chuyên đề song song.',
			'Opening remarks by the Vice Chairman of the City People’s Committee, then 15 parallel thematic sessions.',
		),
		'high-level' => array(
			'28.10',
			'Buổi sáng: phiên toàn thể cấp cao (truyền hình trực tiếp) và đối thoại cùng Thủ tướng. Buổi chiều: tham luận chuyên sâu và đối thoại cấp Bộ, có Phó Thủ tướng Chính phủ; phát biểu cảm ơn của Chủ tịch UBND Thành phố.',
			'Morning: high-level plenary (live) and dialogue with the Prime Minister. Afternoon: in-depth presentations and ministerial dialogue, with the Deputy Prime Minister; closing message from the Chairman of the City People’s Committee.',
		),
		'side'       => array(
			'26–29.10',
			'Hội thảo song phương, không gian hợp tác, trình diễn công nghệ, kết nối đầu tư, mạng lưới C4IR và tham quan thực địa.',
			'Bilateral seminars, cooperation space, technology demonstration, investment matching, C4IR network and field visits.',
		),
	);
	foreach ( $days as $slug => $row ) {
		$term = get_term_by( 'slug', $slug, 'aef_day' );
		if ( $term && ! is_wp_error( $term ) ) {
			wp_update_term( $term->term_id, 'aef_day', array( 'description' => $row[1] ) );
			update_term_meta( $term->term_id, 'when', $row[0] );
			update_term_meta( $term->term_id, 'note_en', $row[2] );
		}
	}

	$venue = 'Thiskyhall, Sala';

	aef_khung_upsert_session(
		'27-oct-opening',
		'thematic',
		'Phát biểu khai mạc của Phó Chủ tịch UBND Thành phố Hồ Chí Minh',
		'Opening remarks by the Vice Chairman of the Ho Chi Minh City People’s Committee',
		'08:00 – 08:20',
		$venue,
		'Phát biểu khai mạc trước các phiên thảo luận chuyên đề song song ngày 27/10.',
		'Opening remarks before the parallel thematic sessions on 27 October.',
		'Phát biểu khai mạc',
		'Opening remarks',
		'publish'
	);
	aef_khung_upsert_session(
		'27-oct-parallels',
		'thematic',
		'15 phiên thảo luận chuyên đề song song',
		'15 parallel thematic sessions',
		'08:30 – 17:30',
		$venue,
		'Ngày 27 tháng 10 gồm các phiên thảo luận chuyên đề tổ chức song song tại Thiskyhall.',
		'27 October comprises parallel thematic sessions at Thiskyhall.',
		'Phiên thảo luận chuyên đề',
		'Thematic sessions',
		'publish'
	);

	$draft_27 = array(
		'repositioning-vietnam-asean',
		'financial-innovation-ifc',
		'advanced-manufacturing',
		'ai-megacity-governance',
		'digital-economy-policy',
		'industrial-ai',
		'ai-workforce-readiness',
		'data-security-quantum',
		'smart-agriculture',
		'smart-manufacturing-logistics',
		'sovereign-ai',
		'esg-corporate-strategy',
		'esg-circular-economy',
		'dual-use-industries',
		'green-consumption',
		'quantum-ecosystem',
		'low-altitude-economy',
		'global-future-leaders',
	);
	foreach ( $draft_27 as $slug ) {
		$p = get_page_by_path( $slug, OBJECT, 'aef_session' );
		if ( $p ) {
			wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'draft' ) );
		}
	}

	aef_khung_upsert_session(
		'high-level-plenary',
		'high-level',
		'Phiên Toàn thể cấp cao',
		'High-level plenary',
		'08:30 – 10:30',
		$venue,
		'Phiên Toàn thể cấp cao (truyền hình trực tiếp), với phát biểu của Thủ tướng Chính phủ, Bí thư Thành ủy TP.HCM và các Lãnh đạo Chính phủ, WEF, tổ chức quốc tế lớn.',
		'High-level plenary (live broadcast), with remarks by the Prime Minister, the Secretary of the Ho Chi Minh City Party Committee, and leaders of the Government, the World Economic Forum and major international organisations.',
		'Phiên toàn thể cấp cao',
		'High-level plenary',
		'publish'
	);
	aef_khung_upsert_session(
		'pm-dialogue',
		'high-level',
		'Đối thoại cùng Thủ tướng Chính phủ Việt Nam',
		'Dialogue with the Prime Minister of Viet Nam',
		'10:30 – 11:30',
		$venue,
		'Đối thoại cùng Thủ tướng Chính phủ Việt Nam (truyền hình trực tiếp).',
		'Dialogue with the Prime Minister of Viet Nam (live broadcast).',
		'Đối thoại cấp cao',
		'High-level dialogue',
		'publish'
	);
	aef_khung_upsert_session(
		'ministerial-dialogue',
		'high-level',
		'Phiên tham luận chuyên sâu và Đối thoại giữa Lãnh đạo cấp Bộ các nước',
		'In-depth presentations and ministerial-level dialogue',
		'14:00 – 17:30',
		$venue,
		"Buổi chiều gồm phát biểu của Phó Thủ tướng Chính phủ và hai phần:\n\nPhần 1: Tham luận chuyên sâu (4–5 bài).\n\nPhần 2: Đối thoại cấp Bộ — Khung hợp tác trong kỷ nguyên mới, đối thoại trực tiếp giữa Lãnh đạo cấp Bộ các nước, trong đó có Việt Nam.\n\nKết thúc bằng phát biểu cảm ơn, truyền tải thông điệp của Chủ tịch UBND Thành phố.",
		"The afternoon opens with remarks by the Deputy Prime Minister, then two parts:\n\nPart 1: In-depth presentations (4–5 papers).\n\nPart 2: Ministerial dialogue — Cooperation framework in a new era, a direct exchange among ministerial-level leaders, including Viet Nam.\n\nThe block closes with thanks and a message from the Chairman of the Ho Chi Minh City People’s Committee.",
		'Đối thoại chính sách',
		'Policy dialogue',
		'publish'
	);

	foreach ( array( 'secretary-remarks', 'in-depth-panels', 'closing-session', 'chairman-remarks', 'investment-roundtable' ) as $slug ) {
		$p = get_page_by_path( $slug, OBJECT, 'aef_session' );
		if ( $p ) {
			wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'draft' ) );
		}
	}

	$side_slugs = array( 'collaboration-roads', 'bilateral-seminars', 'tea-and-tech', 'welcome-reception', 'c4ir-network-meeting', 'field-visits' );
	foreach ( $side_slugs as $slug ) {
		$p = get_page_by_path( $slug, OBJECT, 'aef_session' );
		if ( $p ) {
			update_post_meta( $p->ID, 'time', '26 – 29.10' );
		}
	}

	update_option( 'aef_khung_2026_v1', '1' );
}

function aef_khung_upsert_session( $slug, $day, $title_vi, $title_en, $time, $room, $sum_vi, $sum_en, $kind_vi, $kind_en, $status ) {
	$existing = get_page_by_path( $slug, OBJECT, 'aef_session' );
	$data     = array(
		'post_title'   => $title_vi,
		'post_name'    => $slug,
		'post_status'  => $status,
		'post_type'    => 'aef_session',
		'post_content' => $sum_vi,
		'post_excerpt' => $sum_vi,
	);
	if ( $existing ) {
		$data['ID'] = $existing->ID;
		$id         = wp_update_post( $data );
	} else {
		$id = wp_insert_post( $data );
	}
	if ( ! $id || is_wp_error( $id ) ) {
		return 0;
	}
	update_post_meta( $id, 'title_vi', $title_vi );
	update_post_meta( $id, 'title_en', $title_en );
	update_post_meta( $id, 'content_en', $sum_en );
	update_post_meta( $id, 'excerpt_en', $sum_en );
	update_post_meta( $id, 'excerpt_vi', $sum_vi );
	update_post_meta( $id, 'time', $time );
	update_post_meta( $id, 'room', $room );
	update_post_meta( $id, 'kind', $kind_vi );
	update_post_meta( $id, 'kind_en', $kind_en );
	if ( $day ) {
		wp_set_object_terms( $id, $day, 'aef_day' );
	}
	return $id;
}

add_action( 'init', 'aef_khung_2508_v1', 43 );
function aef_khung_2508_v1() {
	if ( get_option( 'aef_khung_2508_v1' ) ) {
		return;
	}
	if ( ! function_exists( 'aef_khung_upsert_session' ) ) {
		return;
	}

	$set = get_option( 'aef_settings', array() );
	if ( ! is_array( $set ) ) {
		$set = array();
	}
	$set['programme_updated'] = '23/08/2026';
	update_option( 'aef_settings', $set );

	$thematic = get_term_by( 'slug', 'thematic', 'aef_day' );
	if ( $thematic && ! is_wp_error( $thematic ) ) {
		wp_update_term(
			$thematic->term_id,
			'aef_day',
			array( 'description' => 'Phát biểu khai mạc của Phó Chủ tịch UBND Thành phố (08:00–08:30), sau đó 15 phiên thảo luận chuyên đề song song tại ba phòng. Khu trình diễn giải pháp công nghệ mới cả ngày.' )
		);
		update_term_meta( $thematic->term_id, 'note_en', 'Opening remarks by a Vice Chairman of the City People’s Committee (08:00–08:30), then 15 parallel thematic sessions in three rooms. Rising Star Arena runs all day.' );
	}

	$venue = 'Thiskyhall, Sala';
	$kind  = array( 'Phiên chuyên đề', 'Thematic session' );

	aef_khung_upsert_session(
		'27-oct-opening',
		'thematic',
		'Phát biểu khai mạc của Phó Chủ tịch UBND Thành phố Hồ Chí Minh',
		'Opening remarks by a Vice Chairman of the Ho Chi Minh City People’s Committee',
		'08:00 – 08:30',
		$venue,
		'Phát biểu khai mạc chương trình các phiên thảo luận chuyên đề ngày 27/10, trước 15 phiên song song tại ba phòng.',
		'Opening remarks for the 27 October thematic programme, before 15 parallel sessions in three rooms.',
		'Phát biểu khai mạc',
		'Opening remarks',
		'publish'
	);

	$publish = array(
		array( 'repositioning-vietnam-asean', 'Định vị Việt Nam và ASEAN trong chuỗi giá trị toàn cầu', 'Repositioning Viet Nam and ASEAN in Global Value Chains', '08:30 – 10:00', 'Room 01', 'Khi chuỗi cung ứng được tái cấu trúc, Việt Nam và ASEAN đứng trước cơ hội tái định vị vai trò trong mạng lưới sản xuất, thương mại và đầu tư toàn cầu.', 'As supply chains are restructured, Viet Nam and ASEAN have an opportunity to reposition their role in global production, trade and investment networks.' ),
		array( 'financial-innovation-ifc', 'Kết nối Trung tâm Tài chính Quốc tế Việt Nam với dòng vốn quốc tế trong giai đoạn phát triển mới', 'Connecting the Vietnam International Financial Centre with International Capital Flows in the New Development Phase', '08:30 – 10:00', 'Room 02', 'Thảo luận điều kiện và cơ chế kết nối Trung tâm Tài chính Quốc tế Việt Nam với hệ sinh thái tài chính, đầu tư và dòng vốn toàn cầu.', 'On the conditions and mechanisms for connecting Viet Nam’s International Financial Centre with global finance, investment and capital flows.' ),
		array( 'advanced-manufacturing', 'Sản xuất tiên tiến: công nghệ và năng lực cạnh tranh của doanh nghiệp Việt', 'Advanced Manufacturing: Reshaping the Competitiveness of Vietnamese Enterprises', '08:30 – 10:00', 'Room 03', 'Công nghệ và năng lực cạnh tranh của doanh nghiệp Việt Nam trong sản xuất tiên tiến.', 'Technology and the competitiveness of Vietnamese firms in advanced manufacturing.' ),
		array( 'esg-corporate-strategy', 'ESG: Tiêu chuẩn Môi trường, Xã hội và Quản trị', 'ESG: Environmental, Social and Governance Standards', '10:15 – 11:45', 'Room 01', "Phiên gồm ba nội dung:\n• ESG trong chiến lược phát triển doanh nghiệp;\n• ESG và kinh tế tuần hoàn: khung chiến lược cho hệ sinh thái giá trị toàn cầu;\n• Tiêu dùng xanh và thị trường tiêu dùng bền vững.", "The session covers three strands:\n• ESG as a pillar of sustainable corporate strategy;\n• ESG and the circular economy: a strategic framework for global value ecosystems;\n• Green consumption and sustainable consumer markets." ),
		array( 'digital-economy-policy', 'Khung chính sách phát triển kinh tế số', 'A Policy Framework for the Digital Economy', '10:15 – 11:45', 'Room 02', 'Những yêu cầu chính sách mới khi kinh tế số ngày càng trở thành một cấu phần quan trọng của mô hình tăng trưởng.', 'The new policy requirements as the digital economy becomes a core part of the growth model.' ),
		array( 'smart-manufacturing-logistics', 'Sản xuất thông minh, logistics và dòng vốn cho tăng trưởng', 'Smart Manufacturing, Logistics and Capital Flows for Growth', '10:15 – 11:45', 'Room 03', 'Sản xuất thông minh, logistics và dòng vốn cho tăng trưởng.', 'Smart manufacturing, logistics and capital flows for growth.' ),
		array( 'ai-workforce-readiness', 'Từ triển khai AI đến chuẩn bị nguồn nhân lực cho tương lai ngành sản xuất Việt Nam', "From AI Deployment to Workforce Readiness for Viet Nam's Manufacturing Future", '13:30 – 14:30', 'Room 01', 'Khoảng cách giữa ứng dụng AI trong sản xuất và mức độ sẵn sàng của lực lượng lao động.', 'The gap between AI use in manufacturing and workforce readiness.' ),
		array( 'data-security-quantum', 'An toàn dữ liệu và an ninh mạng trong kỷ nguyên lượng tử', 'Data Security and Cyber Resilience in the Quantum Era', '13:30 – 14:30', 'Room 02', 'Năng lực bảo vệ dữ liệu và hệ thống số khi tiến bộ công nghệ tạo ra cơ hội và thách thức an ninh mới.', 'Protecting data and digital systems as new technologies create both opportunity and security challenges.' ),
		array( 'smart-agriculture', 'Nông nghiệp thông minh và chuỗi giá trị nông sản bền vững', 'Smart Agriculture and Sustainable Agrifood Value Chains', '13:30 – 14:30', 'Room 03', 'Nông nghiệp thông minh và chuỗi giá trị nông sản bền vững.', 'Smart agriculture and sustainable agrifood value chains.' ),
		array( 'industrial-ai', 'Ứng dụng AI', 'AI Applications', '14:45 – 16:15', 'Room 01', "Phiên gồm hai nội dung:\n• Trí tuệ nhân tạo trong công nghiệp: năng suất và tối ưu vận hành nhà máy;\n• Trí tuệ nhân tạo và quản trị siêu đô thị.", "The session covers two strands:\n• Industrial AI: productivity and factory optimisation;\n• Artificial intelligence and megacity governance." ),
		array( 'sovereign-ai', 'Năng lực tự chủ về trí tuệ nhân tạo', 'Sovereign AI Capability', '14:45 – 16:15', 'Room 02', 'Năng lực tự chủ về trí tuệ nhân tạo.', 'Sovereign AI capability.' ),
		array( 'dual-use-industries', 'Công nghiệp lưỡng dụng và các ngành công nghệ chiến lược', 'Dual-Use Industries and Strategic Technologies', '14:45 – 16:15', 'Room 03', 'Công nghiệp lưỡng dụng và các ngành công nghệ chiến lược.', 'Dual-use industries and strategic technologies.' ),
		array( 'quantum-ecosystem', 'Phát triển hệ sinh thái công nghệ lượng tử', 'Building a Quantum Technology Ecosystem', '16:30 – 18:00', 'Room 01', 'Điều kiện để từng bước hình thành năng lực nghiên cứu, phát triển, ứng dụng và kết nối hệ sinh thái công nghệ lượng tử.', 'The conditions for building research, development, application and ecosystem links in quantum technology.' ),
		array( 'low-altitude-economy', 'Kinh tế tầm thấp và các ngành kinh tế mới', 'The Low-Altitude Economy and Emerging Industries', '16:30 – 18:00', 'Room 02', 'Kinh tế tầm thấp và các ngành kinh tế mới.', 'The low-altitude economy and emerging industries.' ),
		array( 'global-future-leaders', 'Vai trò lãnh đạo doanh nghiệp trẻ và tương lai toàn cầu', 'Global Future Leaders Summit', '16:30 – 18:00', 'Room 03', 'Hợp tác quốc tế của cộng đồng doanh nghiệp và các lãnh đạo doanh nghiệp trẻ toàn cầu.', 'International cooperation among firms and young global business leaders.' ),
	);
	foreach ( $publish as $row ) {
		aef_khung_upsert_session( $row[0], 'thematic', $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $kind[0], $kind[1], 'publish' );
	}

	aef_khung_upsert_session(
		'rising-star-arena',
		'thematic',
		'Khu vực trình diễn giải pháp công nghệ mới và đổi mới sáng tạo',
		'Rising Star Arena',
		'All day',
		$venue,
		'Tạo không gian để các trung tâm đổi mới sáng tạo, trung tâm khoa học công nghệ và doanh nghiệp trong nước và quốc tế giới thiệu, trình diễn các công nghệ, giải pháp và mô hình đổi mới sáng tạo đã được chứng minh trong các lĩnh vực công nghệ chiến lược. Mỗi phiên 45 phút. Thiskyhall, 10 Mai Chí Thọ, Sala.',
		'A dedicated space for innovation centres, science and technology centres, and Vietnamese and international enterprises to showcase proven technologies, solutions and innovation models in strategic technology sectors. 45 minutes per session. Thiskyhall, 10 Mai Chi Tho, Sala.',
		'Trình diễn công nghệ',
		'Technology showcase',
		'publish'
	);
	aef_khung_upsert_session(
		'official-reception',
		'thematic',
		'Tiệc chiêu đãi của Lãnh đạo Chính phủ và Thành phố Hồ Chí Minh',
		'Welcome dinner hosted by the Government and the Ho Chi Minh City leadership',
		'18:30 – 20:00',
		'Thành phố Hồ Chí Minh',
		'Tiệc chiêu đãi do Lãnh đạo Chính phủ và Thành phố Hồ Chí Minh chủ trì, dành cho đại biểu theo thư mời của Ban Tổ chức.',
		'A reception hosted by the Government and the leadership of Ho Chi Minh City, for delegates invited by the Organising Committee.',
		'Chiêu đãi chính thức',
		'Official reception',
		'publish'
	);
	aef_khung_upsert_session(
		'business-networking-dinner',
		'thematic',
		'Tiệc tối kết nối doanh nghiệp',
		'Business networking dinner',
		'18:30 – 20:00',
		$venue,
		'Tiệc tối kết nối doanh nghiệp tại Thiskyhall, dành cho đại biểu theo thư mời của Ban Tổ chức.',
		'A business dinner at Thiskyhall, for delegates invited by the Organising Committee.',
		'Kết nối doanh nghiệp',
		'Business networking',
		'publish'
	);

	foreach ( array( '27-oct-parallels', 'esg-circular-economy', 'green-consumption', 'ai-megacity-governance' ) as $slug ) {
		$p = get_page_by_path( $slug, OBJECT, 'aef_session' );
		if ( $p ) {
			wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'draft' ) );
		}
	}

	aef_khung_upsert_session(
		'high-level-plenary',
		'high-level',
		'Phiên Toàn thể cấp cao',
		'High-level plenary',
		'08:30 – 10:30',
		$venue,
		'Phiên Toàn thể cấp cao với chủ đề Sự hội tụ của các cực tăng trưởng mới toàn cầu. Phiên dành cho toàn thể đại biểu; chương trình được truyền hình trực tiếp.',
		'High-level plenary on the theme The Convergence of New Global Growth Engines. Open to all Forum delegates; the session is broadcast live.',
		'Phiên toàn thể cấp cao',
		'High-level plenary',
		'publish'
	);
	aef_khung_upsert_session(
		'pm-dialogue',
		'high-level',
		'Đối thoại cùng Thủ tướng Chính phủ Việt Nam',
		'Dialogue with the Prime Minister of Viet Nam',
		'10:30 – 11:30',
		$venue,
		'Chủ đề: Định vị Việt Nam trong tương lai toàn cầu. Truyền hình trực tiếp. Toàn thể đại biểu. Hình thức: đối thoại trực tiếp trên sân khấu giữa Thủ tướng Chính phủ Việt Nam và lãnh đạo/chuyên gia cấp cao của Diễn đàn Kinh tế Thế giới.',
		'Theme: Positioning Viet Nam in the Future Global Landscape. Live broadcast. Open to all Forum delegates. Format: live on-stage dialogue between the Prime Minister of Viet Nam and a senior leader or expert of the World Economic Forum.',
		'Đối thoại cấp cao',
		'High-level dialogue',
		'publish'
	);
	aef_khung_upsert_session(
		'ministerial-dialogue',
		'high-level',
		'Phiên tham luận chuyên sâu và Đối thoại giữa Lãnh đạo cấp Bộ các nước',
		'In-depth presentations and dialogue among ministerial-level leaders',
		'14:00 – 17:30',
		$venue,
		'Phiên dành cho toàn thể đại biểu. Nội dung gồm tham luận về các xu hướng toàn cầu và đối thoại giữa lãnh đạo cấp Bộ các nước về khung hợp tác trong kỷ nguyên mới.',
		'Open to all Forum delegates. The session comprises presentations on global trends and a dialogue among ministerial-level leaders on cooperation in a new era.',
		'Đối thoại chính sách',
		'Policy dialogue',
		'publish'
	);
	aef_khung_upsert_session(
		'gala-dinner',
		'high-level',
		'Tiệc Gala Dinner',
		'Gala dinner',
		'17:30 – 20:00',
		$venue,
		'Tiệc Gala Dinner sau chương trình cấp cao ngày 28/10 tại Thiskyhall.',
		'Gala dinner after the 28 October high-level programme, at Thiskyhall.',
		'Giao lưu và kết nối',
		'Networking',
		'publish'
	);

	aef_khung_upsert_session(
		'ceo-500-tea-connect',
		'pre',
		'CEO 500 — TEA CONNECT',
		'CEO 500 — TEA CONNECT',
		'14:00 – 16:30',
		$venue,
		'Chủ đề: Góc nhìn mới từ bài toán FDI – Công nghệ – Dòng chảy tài chính toàn cầu. Diễn ra ngày 26/10/2026.',
		'Theme: New Perspectives on FDI, Technology, and Global Financial Flows. Takes place on 26 October 2026.',
		'Đối thoại và kết nối đầu tư',
		'Investment dialogue',
		'publish'
	);

	$bilat = get_page_by_path( 'bilateral-seminars', OBJECT, 'aef_session' );
	if ( $bilat ) {
		$vi = 'Hội thảo song phương giữa Thành phố Hồ Chí Minh, các Bộ, ngành, địa phương và đối tác quốc tế như Trung Quốc, Ấn Độ, Israel, Canada. Diễn ra trong chuỗi hoạt động bên lề 26–29/10/2026.';
		$en = 'Bilateral workshops between Ho Chi Minh City, ministries, localities and international partners such as China, India, Israel and Canada. Part of the side programme, 26–29 October 2026.';
		wp_update_post( array( 'ID' => $bilat->ID, 'post_content' => $vi, 'post_excerpt' => $vi ) );
		update_post_meta( $bilat->ID, 'content_en', $en );
		update_post_meta( $bilat->ID, 'excerpt_en', $en );
		update_post_meta( $bilat->ID, 'excerpt_vi', $vi );
		update_post_meta( $bilat->ID, 'time', '26 – 29.10' );
	}

	update_option( 'aef_khung_2508_v1', '1' );
}

function aef_session_duration_label( $id ) {
	$time = (string) aef_meta( $id, 'time' );
	if ( preg_match( '/(\d{1,2}):(\d{2})\s*[–\-]\s*(\d{1,2}):(\d{2})/u', $time, $m ) ) {
		$mins = ( (int) $m[3] * 60 + (int) $m[4] ) - ( (int) $m[1] * 60 + (int) $m[2] );
		if ( $mins < 1 ) {
			return aef_t( array( 'en' => 'All day', 'vi' => 'Cả ngày' ) );
		}
		if ( $mins >= 60 ) {
			$h = (int) floor( $mins / 60 );
			$r = $mins % 60;
			if ( 'en' === aef_lang() ) {
				return $r ? $h . ' h ' . $r . ' min' : $h . ' h';
			}
			return $r ? $h . ' giờ ' . $r . ' phút' : $h . ' giờ';
		}
		return $mins . ' ' . aef_t( array( 'en' => 'min', 'vi' => 'phút' ) );
	}
	if ( false !== stripos( $time, 'Cả ngày' ) || false !== stripos( $time, 'All day' ) ) {
		return aef_t( array( 'en' => 'All day', 'vi' => 'Cả ngày' ) );
	}
	return $time ? $time : aef_t( array( 'en' => 'All day', 'vi' => 'Cả ngày' ) );
}

function aef_session_kind_chip( $id ) {
	$kind = trim( (string) aef_session_kind( $id ) );
	if ( $kind ) {
		return $kind;
	}
	$slug = get_post_field( 'post_name', $id );
	$map  = array(
		'high-level-plenary' => array( 'en' => 'Plenary', 'vi' => 'Phiên toàn thể' ),
		'pm-dialogue'        => array( 'en' => 'Dialogue', 'vi' => 'Đối thoại' ),
		'rising-star-arena'  => array( 'en' => 'Rising Star', 'vi' => 'Rising Star' ),
	);
	if ( isset( $map[ $slug ] ) ) {
		return aef_t( $map[ $slug ] );
	}
	$b = aef_prog_room_bucket( $id );
	if ( in_array( $b, array( '1', '2', '3' ), true ) ) {
		return aef_t( array( 'en' => 'Thematic', 'vi' => 'Chuyên đề' ) );
	}
	return aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) );
}

function aef_prog_srow( $sid, $day_slug ) {
	$people = function_exists( 'aef_session_people' ) ? aef_session_people( $sid ) : array();
	$hay    = strtolower( aef_bilingual_title( $sid ) . ' ' . aef_session_short( $sid ) );
	$slug   = get_post_field( 'post_name', $sid );
	$live   = in_array( $slug, array( 'high-level-plenary', 'pm-dialogue' ), true );
	$time   = (string) aef_meta( $sid, 'time' );
	$start  = $time;
	$end    = '';
	if ( preg_match( '/(\d{1,2}:\d{2})\s*[–\-]\s*(\d{1,2}:\d{2})/u', $time, $m ) ) {
		$start = $m[1];
		$end   = $m[2];
	}
	$sub = array();
	$room = function_exists( 'aef_place_label' ) ? aef_place_label( aef_meta( $sid, 'room' ) ) : aef_meta( $sid, 'room' );
	if ( $room ) {
		$sub[] = $room;
	}
	$short = wp_trim_words( aef_session_short( $sid ), 18 );
	if ( $short ) {
		$sub[] = $short;
	}
	?>
	<a class="pg-srow agenda-card<?php echo $live ? ' is-live' : ''; ?>" href="<?php echo esc_url( get_permalink( $sid ) ); ?>" data-day="<?php echo esc_attr( $day_slug ); ?>" data-room="<?php echo esc_attr( aef_meta( $sid, 'room' ) ); ?>" data-q="<?php echo esc_attr( $hay ); ?>">
	  <div class="when"><b><?php echo esc_html( $start ? $start : '—' ); ?></b><small><?php echo esc_html( $end ? $end . ' · ' . aef_session_duration_label( $sid ) : aef_session_duration_label( $sid ) ); ?></small></div>
	  <div class="what">
	    <div class="pg-chips">
	      <span class="pg-chip"><?php echo esc_html( aef_session_kind_chip( $sid ) ); ?></span>
	      <?php if ( $live ) : ?><span class="live"><?php echo esc_html( aef_t( array( 'en' => 'Live broadcast', 'vi' => 'Truyền hình trực tiếp' ) ) ); ?></span><?php endif; ?>
	    </div>
	    <b><?php echo esc_html( aef_bilingual_title( $sid ) ); ?></b>
	    <span><?php echo esc_html( implode( ' · ', $sub ) ); ?></span>
	  </div>
	  <div class="arrow">→</div>
	</a>
	<?php
}

function aef_prog_pgrid( $buckets, $day_slug ) {
	$slots  = array(
		array( '08:30', '10:00' ),
		array( '10:15', '11:45' ),
		array( '13:30', '14:30' ),
		array( '14:45', '16:15' ),
		array( '16:30', '18:00' ),
	);
	$heads  = array(
		'1' => array( aef_t( array( 'en' => 'Room 01', 'vi' => 'Phòng 01' ) ), aef_t( array( 'en' => 'Value chains · AI · Quantum', 'vi' => 'Chuỗi giá trị · AI · Lượng tử' ) ) ),
		'2' => array( aef_t( array( 'en' => 'Room 02', 'vi' => 'Phòng 02' ) ), aef_t( array( 'en' => 'Finance · Digital economy · Sovereignty', 'vi' => 'Tài chính · Kinh tế số · Tự chủ' ) ) ),
		'3' => array( aef_t( array( 'en' => 'Room 03', 'vi' => 'Phòng 03' ) ), aef_t( array( 'en' => 'Manufacturing · Sustainability · Next generation', 'vi' => 'Sản xuất · Bền vững · Thế hệ mới' ) ) ),
	);
	$wef_co = array( 'repositioning-vietnam-asean', 'ai-workforce-readiness' );
	$find   = static function ( $ids, $start ) {
		foreach ( $ids as $sid ) {
			if ( 0 === strpos( (string) aef_meta( $sid, 'time' ), $start ) ) {
				return $sid;
			}
		}
		return 0;
	};
	echo '<div class="pg-pwrap"><div class="pg-pgrid">';
	echo '<div class="pg-ph"></div>';
	foreach ( array( '1', '2', '3' ) as $rk ) {
		echo '<div class="pg-ph"><b>' . esc_html( $heads[ $rk ][0] ) . '</b><small>' . esc_html( $heads[ $rk ][1] ) . '</small></div>';
	}
	foreach ( $slots as $sl ) {
		$d = ( (int) substr( $sl[1], 0, 2 ) * 60 + (int) substr( $sl[1], 3, 2 ) ) - ( (int) substr( $sl[0], 0, 2 ) * 60 + (int) substr( $sl[0], 3, 2 ) );
		echo '<div class="pg-pt"><b>' . esc_html( $sl[0] ) . '</b><small>' . esc_html( $sl[1] . ' · ' . $d . '′' ) . '</small></div>';
		foreach ( array( '1', '2', '3' ) as $rk ) {
			$sid = $find( isset( $buckets[ $rk ] ) ? $buckets[ $rk ] : array(), $sl[0] );
			if ( ! $sid ) {
				echo '<div class="pg-empty"></div>';
				continue;
			}
			$slug = get_post_field( 'post_name', $sid );
			$wef  = in_array( $slug, $wef_co, true );
			echo '<a class="pg-pc agenda-card' . ( $wef ? ' wef' : '' ) . '" href="' . esc_url( get_permalink( $sid ) ) . '" data-day="' . esc_attr( $day_slug ) . '" data-room="' . esc_attr( aef_meta( $sid, 'room' ) ) . '" data-q="' . esc_attr( strtolower( aef_bilingual_title( $sid ) ) ) . '">';
			if ( $wef ) {
				echo '<span class="by">' . esc_html( aef_t( array( 'en' => 'WEF co-chair (this session)', 'vi' => 'Đồng chủ trì WEF (phiên này)' ) ) ) . '</span>';
			}
			echo '<b>' . esc_html( aef_bilingual_title( $sid ) ) . '</b>';
			echo '<span>' . esc_html( wp_trim_words( aef_session_short( $sid ), 14 ) ) . '</span>';
			echo '</a>';
		}
	}
	echo '</div></div>';
}

function aef_prog_room_bucket( $id ) {
	$slug = get_post_field( 'post_name', $id );
	if ( 'rising-star-arena' === $slug ) {
		return 'arena';
	}
	if ( in_array( $slug, array( '27-oct-opening', 'official-reception', 'business-networking-dinner', 'high-level-plenary', 'pm-dialogue', 'ministerial-dialogue', 'gala-dinner' ), true ) ) {
		return 'full';
	}
	$r = (string) aef_meta( $id, 'room' );
	if ( preg_match( '/01|Phòng\s*1|Room\s*1/iu', $r ) ) {
		return '1';
	}
	if ( preg_match( '/02|Phòng\s*2|Room\s*2/iu', $r ) ) {
		return '2';
	}
	if ( preg_match( '/03|Phòng\s*3|Room\s*3/iu', $r ) ) {
		return '3';
	}
	return 'full';
}

function aef_place_label( $room ) {
	$room = trim( (string) $room );
	$norm = function_exists( 'mb_strtolower' ) ? mb_strtolower( $room ) : strtolower( $room );
	$tbc  = array( '', '—', '-', 'tbd', 'tbc', 'to be confirmed', 'đang xác nhận', 'chua xac nhan', 'chưa xác nhận' );
	if ( in_array( $norm, $tbc, true ) ) {
		return aef_t( array( 'en' => 'To be confirmed', 'vi' => 'Đang xác nhận' ) );
	}
	if ( function_exists( 'aef_lang' ) && 'en' === aef_lang() && $room ) {
		$room = preg_replace( '/^Phòng\s+/u', 'Room ', $room );
	}
	return $room;
}

add_action( 'init', 'aef_khung_1009_v1', 44 );
function aef_khung_1009_v1() {
	if ( get_option( 'aef_khung_1009_v1' ) ) {
		return;
	}
	if ( ! function_exists( 'aef_khung_upsert_session' ) ) {
		return;
	}

	$set = get_option( 'aef_settings', array() );
	if ( ! is_array( $set ) ) {
		$set = array();
	}
	$set['programme_updated'] = '10/09/2026';
	update_option( 'aef_settings', $set );

	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$copy['home_programme_lead_vi'] = 'Diễn đàn chính ngày 27–28 tháng 10 năm 2026 tại Thiskyhall, Thành phố Hồ Chí Minh. Ngày 27/10: khai mạc, 15 phiên chuyên đề song song và khu trình diễn công nghệ. Ngày 28/10: phiên toàn thể cấp cao, đối thoại cùng Thủ tướng và đối thoại cấp Bộ. Hoạt động bên lề từ 26 đến 29 tháng 10.';
	$copy['home_programme_lead_en'] = 'The main forum is on 27–28 October 2026 at Thiskyhall, Ho Chi Minh City. 27 October: opening remarks, 15 parallel thematic sessions and the technology demonstration area. 28 October: high-level plenary, dialogue with the Prime Minister and the ministerial dialogue. Side events run from 26 to 29 October.';
	$copy['home_side_lead_vi']      = 'Tuần Diễn đàn từ 26 đến 29 tháng 10 năm 2026. Cùng hai ngày chính 27–28/10: Collaboration Roads và GRECO 2026; CEO 500 — TEA CONNECT; Diễn đàn công nghệ Việt Nam – Ấn Độ; hội nghị chuyển đổi kép; Open Innovation Day 2026; các hội thảo xúc tiến và họp mặt Mạng lưới C4IR.';
	$copy['home_side_lead_en']      = 'Forum week runs from 26 to 29 October 2026. Alongside 27–28 October: Collaboration Roads and GRECO 2026; CEO 500 — TEA CONNECT; the Viet Nam–India Future Technology Forum; the dual-transition conference; Open Innovation Day 2026; investment seminars and the C4IR Network meeting.';
	$copy['home_side_title_vi']     = 'Chuỗi bốn ngày quanh diễn đàn chính';
	$copy['home_side_title_en']     = 'A four-day city programme around the main Forum';
	update_option( 'aef_copy', $copy );

	$thematic = get_term_by( 'slug', 'thematic', 'aef_day' );
	if ( $thematic && ! is_wp_error( $thematic ) ) {
		wp_update_term(
			$thematic->term_id,
			'aef_day',
			array( 'description' => 'Phát biểu khai mạc của Phó Chủ tịch UBND Thành phố (08:00–08:30), sau đó 15 phiên thảo luận chuyên đề song song tại ba phòng. Khu trình diễn giải pháp công nghệ mới cả ngày.' )
		);
		update_term_meta( $thematic->term_id, 'when', '27.10' );
		update_term_meta( $thematic->term_id, 'note_en', 'Opening remarks by a Vice Chairman of the City People’s Committee (08:00–08:30), then 15 parallel thematic sessions in three rooms. Rising Star Arena runs all day.' );
	}
	$high = get_term_by( 'slug', 'high-level', 'aef_day' );
	if ( $high && ! is_wp_error( $high ) ) {
		wp_update_term(
			$high->term_id,
			'aef_day',
			array( 'description' => 'Buổi sáng: phiên toàn thể cấp cao (truyền hình trực tiếp) và đối thoại cùng Thủ tướng. Buổi chiều: tham luận chuyên sâu và đối thoại cấp Bộ; phát biểu cảm ơn của Chủ tịch UBND Thành phố.' )
		);
		update_term_meta( $high->term_id, 'when', '28.10' );
		update_term_meta( $high->term_id, 'note_en', 'Morning: high-level plenary (live) and dialogue with the Prime Minister. Afternoon: in-depth presentations and ministerial dialogue; closing message from the Chairman of the City People’s Committee.' );
	}
	$side = get_term_by( 'slug', 'side', 'aef_day' );
	if ( $side && ! is_wp_error( $side ) ) {
		wp_update_term(
			$side->term_id,
			'aef_day',
			array( 'description' => 'Collaboration Roads và GRECO 2026 (26–29/10); các hội thảo và họp mặt ngày 29/10. Địa điểm cụ thể của một số hoạt động: Đang xác nhận.' )
		);
		update_term_meta( $side->term_id, 'when', '26–29.10' );
		update_term_meta( $side->term_id, 'note_en', 'Collaboration Roads and GRECO 2026 (26–29 October); seminars and the C4IR Network meeting on 29 October. Some venues: to be confirmed.' );
	}
	$pre = get_term_by( 'slug', 'pre', 'aef_day' );
	if ( $pre && ! is_wp_error( $pre ) ) {
		wp_update_term(
			$pre->term_id,
			'aef_day',
			array( 'description' => 'CEO 500 — TEA CONNECT, Diễn đàn công nghệ Việt Nam – Ấn Độ, hội nghị chuyển đổi kép và Open Innovation Day 2026.' )
		);
		update_term_meta( $pre->term_id, 'when', '26.10' );
		update_term_meta( $pre->term_id, 'note_en', 'CEO 500 — TEA CONNECT, the Viet Nam–India Future Technology Forum, the dual-transition conference and Open Innovation Day 2026.' );
	}

	$hall = 'Thiskyhall, Sala';
	$tbc  = 'Đang xác nhận';
	$kind = array( 'Phiên chuyên đề', 'Thematic session' );

	$fill = static function ( $id, $date_label ) {
		if ( ! $id ) {
			return;
		}
		update_post_meta( $id, 'date_label', $date_label );
		$vi = get_post_meta( $id, 'excerpt_vi', true );
		$en = get_post_meta( $id, 'excerpt_en', true );
		if ( $vi ) {
			update_post_meta( $id, 'short_vi', $vi );
			update_post_meta( $id, 'long_vi', $vi );
			update_post_meta( $id, 'content_vi', $vi );
		}
		if ( $en ) {
			update_post_meta( $id, 'short_en', $en );
			update_post_meta( $id, 'long_en', $en );
		}
	};

	$id = aef_khung_upsert_session(
		'27-oct-opening',
		'thematic',
		'Phát biểu khai mạc của Phó Chủ tịch UBND Thành phố Hồ Chí Minh',
		'Opening remarks by a Vice Chairman of the Ho Chi Minh City People’s Committee',
		'08:00 – 08:30',
		$hall,
		'Phát biểu khai mạc chương trình các phiên thảo luận chuyên đề ngày 27/10, trước 15 phiên song song tại ba phòng.',
		'Opening remarks for the 27 October thematic programme, before 15 parallel sessions in three rooms.',
		'Phát biểu khai mạc',
		'Opening remarks',
		'publish'
	);
	$fill( $id, '27.10.2026' );

	$thematic_rows = array(
		array( 'repositioning-vietnam-asean', 'Định vị Việt Nam và ASEAN trong chuỗi giá trị toàn cầu', 'Repositioning Viet Nam and ASEAN in Global Value Chains', '08:30 – 10:00', 'Phòng 01', 'Khi chuỗi cung ứng được tái cấu trúc, Việt Nam và ASEAN đứng trước cơ hội tái định vị vai trò trong mạng lưới sản xuất, thương mại và đầu tư toàn cầu.', 'As supply chains are restructured, Viet Nam and ASEAN have an opportunity to reposition their role in global production, trade and investment networks.' ),
		array( 'financial-innovation-ifc', 'Thu hút dòng vốn quốc tế vào Trung tâm tài chính quốc tế Việt Nam tại Thành phố Hồ Chí Minh trong giai đoạn phát triển mới', 'Connecting the Viet Nam International Financial Centre with International Capital Flows in the New Development Phase', '08:30 – 10:00', 'Phòng 02', 'Thảo luận điều kiện và cơ chế kết nối Trung tâm tài chính quốc tế Việt Nam tại Thành phố Hồ Chí Minh với dòng vốn quốc tế trong giai đoạn phát triển mới.', 'On connecting Viet Nam’s International Financial Centre in Ho Chi Minh City with international capital flows in the new development phase.' ),
		array( 'advanced-manufacturing', 'Sản xuất tiên tiến: công nghệ và năng lực cạnh tranh của doanh nghiệp Việt', 'Advanced Manufacturing: Reshaping the Competitiveness of Vietnamese Enterprises', '08:30 – 10:00', 'Phòng 03', 'Công nghệ và năng lực cạnh tranh của doanh nghiệp Việt Nam trong sản xuất tiên tiến.', 'Technology and the competitiveness of Vietnamese firms in advanced manufacturing.' ),
		array( 'esg-corporate-strategy', 'ESG: Tiêu chuẩn Môi trường, Xã hội và Quản trị', 'ESG: Environmental, Social and Governance Standards', '10:15 – 11:45', 'Phòng 01', "Phiên gồm ba nội dung:\n• ESG trong chiến lược phát triển doanh nghiệp;\n• ESG và kinh tế tuần hoàn: khung chiến lược cho hệ sinh thái giá trị toàn cầu;\n• Tiêu dùng xanh và thị trường tiêu dùng bền vững.", "The session covers three strands:\n• ESG as a pillar of sustainable corporate strategy;\n• ESG and the circular economy: a strategic framework for global value ecosystems;\n• Green consumption and sustainable consumer markets." ),
		array( 'digital-economy-policy', 'Khung chính sách phát triển kinh tế số', 'A Policy Framework for the Digital Economy', '10:15 – 11:45', 'Phòng 02', 'Những yêu cầu chính sách khi kinh tế số trở thành cấu phần quan trọng của mô hình tăng trưởng.', 'The new policy requirements as the digital economy becomes a core part of the growth model.' ),
		array( 'smart-manufacturing-logistics', 'Sản xuất thông minh, logistics xanh - Động lực thu hút dòng vốn cho tăng trưởng', 'Smart Manufacturing and Green Logistics: Drivers of Capital Flows for Growth', '10:15 – 11:45', 'Phòng 03', 'Sản xuất thông minh và logistics xanh như động lực thu hút dòng vốn cho tăng trưởng.', 'Smart manufacturing and green logistics as drivers of capital flows for growth.' ),
		array( 'ai-workforce-readiness', 'Từ triển khai AI đến chuẩn bị nguồn nhân lực cho tương lai ngành sản xuất Việt Nam', 'AI Deployment and Viet Nam’s Manufacturing Workforce', '13:30 – 14:30', 'Phòng 01', 'Khoảng cách giữa ứng dụng AI trong sản xuất và mức độ sẵn sàng của lực lượng lao động.', 'The gap between AI use in manufacturing and workforce readiness.' ),
		array( 'data-security-quantum', 'An toàn dữ liệu và an ninh mạng trong kỷ nguyên lượng tử', 'Data Security and Cyber Resilience in the Quantum Era', '13:30 – 14:30', 'Phòng 02', 'Năng lực bảo vệ dữ liệu và hệ thống số khi công nghệ tạo ra cơ hội và thách thức an ninh mới.', 'Protecting data and digital systems as new technologies create both opportunity and security challenges.' ),
		array( 'smart-agriculture', 'Nông nghiệp thông minh và chuỗi giá trị nông sản bền vững', 'Smart Agriculture and Sustainable Agrifood Value Chains', '13:30 – 14:30', 'Phòng 03', 'Nông nghiệp thông minh và chuỗi giá trị nông sản bền vững.', 'Smart agriculture and sustainable agrifood value chains.' ),
		array( 'industrial-ai', 'Ứng dụng AI', 'AI Applications', '14:45 – 16:15', 'Phòng 01', "Phiên gồm hai nội dung:\n• Trí tuệ nhân tạo và quản trị siêu đô thị;\n• Trí tuệ nhân tạo trong công nghiệp: năng suất và tối ưu vận hành nhà máy.", "The session covers two strands:\n• Artificial intelligence and megacity governance;\n• Industrial AI: productivity and factory optimisation." ),
		array( 'sovereign-ai', 'Năng lực tự chủ về trí tuệ nhân tạo', 'Sovereign AI Capability', '14:45 – 16:15', 'Phòng 02', 'Năng lực tự chủ về trí tuệ nhân tạo.', 'Sovereign AI capability.' ),
		array( 'dual-use-industries', 'Công nghiệp lưỡng dụng và các ngành công nghệ chiến lược', 'Dual-Use Industries and Strategic Technologies', '14:45 – 16:15', 'Phòng 03', 'Công nghiệp lưỡng dụng và các ngành công nghệ chiến lược.', 'Dual-use industries and strategic technologies.' ),
		array( 'quantum-ecosystem', 'Phát triển hệ sinh thái công nghệ lượng tử', 'Building a Quantum Technology Ecosystem', '16:30 – 18:00', 'Phòng 01', 'Điều kiện để hình thành năng lực nghiên cứu, phát triển, ứng dụng và kết nối hệ sinh thái công nghệ lượng tử.', 'The conditions for building research, development, application and ecosystem links in quantum technology.' ),
		array( 'low-altitude-economy', 'Kinh tế tầm thấp và các ngành kinh tế mới', 'The Low-Altitude Economy and Emerging Industries', '16:30 – 18:00', 'Phòng 02', 'Kinh tế tầm thấp và các ngành kinh tế mới.', 'The low-altitude economy and emerging industries.' ),
		array( 'global-future-leaders', 'Vai trò lãnh đạo doanh nghiệp trẻ và tương lai toàn cầu', 'Global Future Leaders Summit', '16:30 – 18:00', 'Phòng 03', 'Hợp tác quốc tế của cộng đồng doanh nghiệp và các lãnh đạo doanh nghiệp trẻ toàn cầu.', 'International cooperation among firms and young global business leaders.' ),
	);
	foreach ( $thematic_rows as $row ) {
		$id = aef_khung_upsert_session( $row[0], 'thematic', $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $kind[0], $kind[1], 'publish' );
		$fill( $id, '27.10.2026' );
	}

	$id = aef_khung_upsert_session(
		'rising-star-arena',
		'thematic',
		'Khu vực trình diễn giải pháp công nghệ mới và đổi mới sáng tạo',
		'Rising Star Arena',
		'Cả ngày',
		$hall,
		'Tạo không gian để các trung tâm đổi mới sáng tạo, trung tâm khoa học công nghệ và doanh nghiệp trong nước và quốc tế giới thiệu, trình diễn các công nghệ, giải pháp và mô hình đổi mới sáng tạo đã được chứng minh trong các lĩnh vực công nghệ chiến lược. Mỗi phiên 45 phút. Thiskyhall, 10 Mai Chí Thọ, Sala.',
		'A dedicated space for innovation centres, science and technology centres, and Vietnamese and international enterprises to showcase proven technologies, solutions and innovation models in strategic technology sectors. 45 minutes per session. Thiskyhall, 10 Mai Chi Tho, Sala.',
		'Trình diễn công nghệ',
		'Technology showcase',
		'publish'
	);
	$fill( $id, '27.10.2026' );

	$id = aef_khung_upsert_session(
		'official-reception',
		'thematic',
		'Tiệc chiêu đãi của Lãnh đạo Chính phủ và Thành phố Hồ Chí Minh',
		'Welcome dinner hosted by the Government and the Ho Chi Minh City leadership',
		'18:30 – 20:00',
		$tbc,
		'Tiệc chiêu đãi do Lãnh đạo Chính phủ và Thành phố Hồ Chí Minh chủ trì, dành cho đại biểu theo thư mời. Địa điểm: Đang xác nhận.',
		'A reception hosted by the Government and the leadership of Ho Chi Minh City, for invited delegates. Venue: to be confirmed.',
		'Chiêu đãi chính thức',
		'Official reception',
		'publish'
	);
	$fill( $id, '27.10.2026' );

	$id = aef_khung_upsert_session(
		'business-networking-dinner',
		'thematic',
		'Tiệc tối kết nối doanh nghiệp',
		'Business networking dinner',
		'18:30 – 20:00',
		$tbc,
		'Tiệc tối kết nối doanh nghiệp, dành cho đại biểu theo thư mời. Địa điểm: Đang xác nhận.',
		'A business dinner for invited delegates. Venue: to be confirmed.',
		'Kết nối doanh nghiệp',
		'Business networking',
		'publish'
	);
	$fill( $id, '27.10.2026' );

	$id = aef_khung_upsert_session(
		'high-level-plenary',
		'high-level',
		'Phiên Toàn thể cấp cao',
		'High-level plenary',
		'08:30 – 10:30',
		$hall,
		'Chủ đề: Sự hội tụ của các cực tăng trưởng mới toàn cầu. Truyền hình trực tiếp. Toàn thể đại biểu. Phát biểu chào mừng và định hướng của Thủ tướng Chính phủ (15 phút); phát biểu chào mừng của Bí thư Thành ủy Thành phố Hồ Chí Minh (10 phút); phát biểu của lãnh đạo Chính phủ các nước, lãnh đạo Diễn đàn Kinh tế Thế giới và các tổ chức quốc tế lớn (danh sách và số lượng: Đang xác nhận).',
		'Theme: The Convergence of New Global Growth Engines. Live broadcast. Open to all Forum delegates. Special address by the Prime Minister (15 minutes); welcome remarks by the Secretary of the Ho Chi Minh City Party Committee (10 minutes); remarks by government leaders of other countries, leaders of the World Economic Forum and major international organisations (list and number: to be confirmed).',
		'Phiên toàn thể cấp cao',
		'High-level plenary',
		'publish'
	);
	$fill( $id, '28.10.2026' );

	$id = aef_khung_upsert_session(
		'pm-dialogue',
		'high-level',
		'Đối thoại cùng Thủ tướng Chính phủ Việt Nam',
		'Dialogue with the Prime Minister of Viet Nam',
		'10:30 – 11:30',
		$hall,
		'Chủ đề: Định vị Việt Nam trong tương lai toàn cầu. Truyền hình trực tiếp. Toàn thể đại biểu. Hình thức: đối thoại trực tiếp trên sân khấu giữa Thủ tướng Chính phủ Việt Nam và lãnh đạo/chuyên gia cấp cao của Diễn đàn Kinh tế Thế giới.',
		'Theme: Positioning Viet Nam in the Future Global Landscape. Live broadcast. Open to all Forum delegates. Format: live on-stage dialogue between the Prime Minister of Viet Nam and a senior leader or expert of the World Economic Forum.',
		'Đối thoại cấp cao',
		'High-level dialogue',
		'publish'
	);
	$fill( $id, '28.10.2026' );

	$id = aef_khung_upsert_session(
		'ministerial-dialogue',
		'high-level',
		'Phiên tham luận chuyên sâu và Đối thoại giữa Lãnh đạo cấp Bộ các nước',
		'In-depth presentations and ministerial-level dialogue',
		'14:00 – 17:30',
		$hall,
		"Toàn thể đại biểu. Phát biểu chào mừng và định hướng của Phó Thủ tướng Chính phủ (15 phút).\n\nTham luận chuyên sâu về các xu hướng toàn cầu (90 phút; số lượng tham luận: Đang xác nhận).\n\nĐối thoại giữa lãnh đạo cấp Bộ (Bộ trưởng/Thứ trưởng) các nước về chủ đề Khung hợp tác trong kỷ nguyên mới (90 phút). Lãnh đạo Bộ Tài chính Việt Nam tham gia cùng đối thoại.\n\nChủ tịch UBND Thành phố Hồ Chí Minh phát biểu cảm ơn và truyền tải thông điệp của Thành phố sau Diễn đàn (15 phút).",
		"Open to all Forum delegates. Special address by the Deputy Prime Minister (15 minutes).\n\nIn-depth discussion of global trends (90 minutes; number of presentations: to be confirmed).\n\nDialogue among ministerial-level leaders on Collaboration Frameworks in a New Era (90 minutes). A leader of Viet Nam’s Ministry of Finance takes part.\n\nClosing remarks by the Chairman of the Ho Chi Minh City People’s Committee (15 minutes).",
		'Đối thoại chính sách',
		'Policy dialogue',
		'publish'
	);
	$fill( $id, '28.10.2026' );

	$id = aef_khung_upsert_session(
		'gala-dinner',
		'high-level',
		'Tiệc Gala Dinner',
		'Gala dinner',
		'17:30 – 20:00',
		$tbc,
		'Tiệc Gala Dinner sau chương trình cấp cao ngày 28/10. Địa điểm: Đang xác nhận.',
		'Gala dinner after the 28 October high-level programme. Venue: to be confirmed.',
		'Giao lưu và kết nối',
		'Networking',
		'publish'
	);
	$fill( $id, '28.10.2026' );

	$id = aef_khung_upsert_session(
		'ceo-500-tea-connect',
		'pre',
		'CEO 500 — TEA CONNECT',
		'CEO 500 — TEA CONNECT',
		'14:00 – 16:30',
		$hall,
		'Chủ đề: Góc nhìn mới từ bài toán FDI – Công nghệ – Dòng chảy tài chính toàn cầu. Ngày 26/10/2026 tại Thiskyhall, 10 Mai Chí Thọ, Sala.',
		'Theme: New Perspectives on FDI, Technology and Global Financial Flows. 26 October 2026 at Thiskyhall, 10 Mai Chi Tho, Sala.',
		'Đối thoại và kết nối đầu tư',
		'Investment dialogue',
		'publish'
	);
	$fill( $id, '26.10.2026' );

	$id = aef_khung_upsert_session(
		'vietnam-india-future-tech',
		'pre',
		'Diễn đàn Công nghệ Tương lai Việt Nam – Ấn Độ',
		'Viet Nam – India Future Technology Forum 2026',
		'08:30 – 11:30',
		$tbc,
		'Tạo không gian kết nối Việt Nam và Ấn Độ về công nghệ mới, nguồn nhân lực, tập đoàn và hợp tác kinh tế. Địa điểm: Đang xác nhận.',
		'A platform for Viet Nam–India cooperation in emerging technologies, talent, corporations and economic partnership. Venue: to be confirmed.',
		'Sự kiện bên lề',
		'Side event',
		'publish'
	);
	$fill( $id, '26.10.2026' );

	$id = aef_khung_upsert_session(
		'dual-transition-conference',
		'pre',
		'Hội nghị giải pháp thúc đẩy chuyển đổi kép cho công nghiệp trọng điểm',
		'Dual Transition Conference for Key Industrial Sectors',
		'07:30 – 17:00',
		$tbc,
		'Đối thoại đa bên giữa cơ quan quản lý, giới học thuật, doanh nghiệp và đối tác quốc tế về chuyển đổi số và chuyển đổi xanh, hướng đến trung hòa carbon. Địa điểm: Đang xác nhận.',
		'A multi-stakeholder dialogue on digital and green transition in Viet Nam’s key industrial sectors, towards carbon neutrality. Venue: to be confirmed.',
		'Sự kiện bên lề',
		'Side event',
		'publish'
	);
	$fill( $id, '26.10.2026' );

	$id = aef_khung_upsert_session(
		'oid-2026',
		'pre',
		'Ngày Đổi mới Sáng tạo Mở 2026 — Open Innovation Day',
		'Open Innovation Day 2026 (OID 2026)',
		'08:30 – 17:00',
		$hall,
		'Chủ đề: Thành phố Công nghiệp thế hệ mới. Kết nối công nghệ, hạ tầng, sản xuất, năng lượng, logistics và nguồn vốn. Thiskyhall, 10 Mai Chí Thọ, Sala.',
		'Theme: The Next-Generation Industrial City. Connecting technology, infrastructure, manufacturing, energy, logistics and capital. Thiskyhall, 10 Mai Chi Tho, Sala.',
		'Sự kiện bên lề',
		'Side event',
		'publish'
	);
	$fill( $id, '26.10.2026' );

	$id = aef_khung_upsert_session(
		'collaboration-roads',
		'side',
		'Không gian hợp tác Collaboration Roads và GRECO 2026',
		'Collaboration Roads and GRECO 2026',
		'26 – 29.10',
		'Nguyễn Huệ – Tôn Đức Thắng – Lê Lợi – Đồng Khởi',
		'Không gian hợp tác từ 26–29/10/2026 trên bốn trục Nguyễn Huệ, Tôn Đức Thắng, Lê Lợi và Đồng Khởi: hội nghị, hội thảo, trưng bày, triển lãm, giới thiệu sáng kiến và mô hình hợp tác, cùng Triển lãm không gian giới thiệu sản phẩm, dịch vụ tăng trưởng xanh Thành phố Hồ Chí Minh lần thứ 4 năm 2026 (GRECO 2026).',
		'Collaboration Roads runs from 26 to 29 October 2026 along Nguyen Hue, Ton Duc Thang, Le Loi and Dong Khoi, with conferences, seminars, showcases and exhibitions of collaboration models, alongside the 4th Ho Chi Minh City Green Growth Exhibition (GRECO 2026).',
		'Sự kiện bên lề',
		'Side event',
		'publish'
	);
	$fill( $id, '26–29.10.2026' );

	$id = aef_khung_upsert_session(
		'field-visits',
		'side',
		'Tham quan, trải nghiệm văn hóa và khảo sát khu công nghiệp',
		'Cultural experience and industrial park visits',
		'08:00 – 11:30',
		$tbc,
		'Chương trình ngày 29/10 nhằm giới thiệu môi trường đầu tư, hệ sinh thái sản xuất – công nghệ và giá trị văn hóa của Thành phố. Địa điểm cụ thể: Đang xác nhận.',
		'On 29 October, visits to selected cultural sites, industrial parks and technology hubs in Ho Chi Minh City. Specific sites: to be confirmed.',
		'Sự kiện bên lề',
		'Side event',
		'publish'
	);
	$fill( $id, '29.10.2026' );

	$id = aef_khung_upsert_session(
		'vietnam-israel-innovation-day',
		'side',
		'Việt Nam – Israel Innovation Day',
		'Viet Nam–Israel Innovation Day',
		'08:30 – 11:30',
		$tbc,
		'Dành cho doanh nghiệp, viện nghiên cứu và trung tâm đổi mới sáng tạo: phát biểu, keynote và chia sẻ kinh nghiệm về khoa học, công nghệ và đổi mới sáng tạo. Địa điểm: Đang xác nhận.',
		'For businesses, research institutes and innovation centres: speeches, keynotes and experience-sharing on science, technology and innovation. Venue: to be confirmed.',
		'Sự kiện bên lề',
		'Side event',
		'publish'
	);
	$fill( $id, '29.10.2026' );

	$id = aef_khung_upsert_session(
		'vietnam-china-investment',
		'side',
		'Hội thảo xúc tiến đầu tư Việt Nam – Trung Quốc',
		'Viet Nam–China Investment Promotion Seminar',
		'09:00 – 11:30',
		$tbc,
		'Trao đổi cơ hội hợp tác, kết nối doanh nghiệp, công nghệ và đầu tư giữa hai bên. Địa điểm: Đang xác nhận.',
		'Opportunities for cooperation and connections between businesses, technology stakeholders and investors from Viet Nam and China. Venue: to be confirmed.',
		'Sự kiện bên lề',
		'Side event',
		'publish'
	);
	$fill( $id, '29.10.2026' );

	$id = aef_khung_upsert_session(
		'nordic-investment',
		'side',
		'Hội thảo xúc tiến đầu tư dành cho doanh nghiệp Bắc Âu',
		'Investment Promotion Seminar for Nordic Businesses',
		'14:00 – 16:30',
		$tbc,
		'Giới thiệu môi trường đầu tư, lĩnh vực ưu tiên và cơ hội hợp tác đầu tư tại Thành phố Hồ Chí Minh. Địa điểm: Đang xác nhận.',
		'Ho Chi Minh City’s investment environment, priority sectors and opportunities for investment cooperation. Venue: to be confirmed.',
		'Sự kiện bên lề',
		'Side event',
		'publish'
	);
	$fill( $id, '29.10.2026' );

	$id = aef_khung_upsert_session(
		'c4ir-network-meeting',
		'side',
		'Họp mặt thường niên Mạng lưới các Trung tâm C4IR toàn cầu',
		'Annual Meeting of the Global Network of C4IRs',
		'17:30 – 22:00',
		$tbc,
		'Kết nối các Trung tâm C4IR, trao đổi định hướng hợp tác, chia sẻ kinh nghiệm và thúc đẩy sáng kiến chung về công nghệ, đổi mới sáng tạo và chuyển đổi công nghiệp. Địa điểm: Đang xác nhận.',
		'C4IRs from the global network discuss cooperation priorities, share experience and advance joint initiatives in technology, innovation and industrial transformation. Venue: to be confirmed.',
		'Sự kiện bên lề',
		'Side event',
		'publish'
	);
	$fill( $id, '29.10.2026' );

	foreach ( array(
		'27-oct-parallels',
		'esg-circular-economy',
		'green-consumption',
		'ai-megacity-governance',
		'investment-roundtable',
		'secretary-remarks',
		'in-depth-panels',
		'closing-session',
		'chairman-remarks',
		'tea-and-tech',
		'welcome-reception',
		'bilateral-seminars',
	) as $slug ) {
		$p = get_page_by_path( $slug, OBJECT, 'aef_session' );
		if ( $p ) {
			wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'draft' ) );
		}
	}

	update_option( 'aef_khung_1009_v1', '1' );
}

function aef_fill_session_copy( $slug, $short_vi, $short_en, $long_vi = '', $long_en = '' ) {
	$p = get_page_by_path( $slug, OBJECT, 'aef_session' );
	if ( ! $p ) {
		return;
	}
	$id = $p->ID;
	$long_vi = $long_vi ? $long_vi : $short_vi;
	$long_en = $long_en ? $long_en : $short_en;
	update_post_meta( $id, 'excerpt_vi', $short_vi );
	update_post_meta( $id, 'excerpt_en', $short_en );
	update_post_meta( $id, 'short_vi', $short_vi );
	update_post_meta( $id, 'short_en', $short_en );
	update_post_meta( $id, 'long_vi', $long_vi );
	update_post_meta( $id, 'long_en', $long_en );
	update_post_meta( $id, 'content_vi', $long_vi );
	update_post_meta( $id, 'content_en', $long_en );
	wp_update_post( array( 'ID' => $id, 'post_content' => $long_vi, 'post_excerpt' => $short_vi ) );
}

add_action( 'init', 'aef_html10_copy_v1', 45 );
function aef_html10_copy_v1() {
	if ( get_option( 'aef_html10_copy_v1' ) ) {
		return;
	}

	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$copy['home_intro_eyebrow_vi'] = 'Bối cảnh và định vị';
	$copy['home_intro_eyebrow_en'] = 'Context and positioning';
	$copy['home_intro_title_vi']   = 'Khi các cực tăng trưởng dịch chuyển, đối thoại là hạ tầng của lòng tin';
	$copy['home_intro_title_en']   = 'As growth engines shift, dialogue becomes the infrastructure of trust';
	$copy['home_intro_lead_vi']    = "Kinh tế toàn cầu đang được tái cấu trúc dưới tác động của biến động địa chính trị, đột phá công nghệ và làn sóng chuyển đổi xanh. Chuỗi giá trị được thiết lập lại theo hướng đa dạng hóa, khu vực hóa và chống chịu; các cực tăng trưởng mới dịch chuyển về châu Á, châu Phi và Mỹ La-tinh, với các siêu đô thị trở thành trung tâm điều phối dòng vốn, công nghệ và đổi mới sáng tạo.\n\nViệt Nam bước vào kỷ nguyên phát triển mới với mục tiêu tăng trưởng GDP trên 10%/năm và kinh tế số đạt 30% GDP vào năm 2030, trên nền hạ tầng mềm của quan hệ ngoại giao với 193 quốc gia, 30 đối tác chiến lược và 16 hiệp định FTA. Thành phố Hồ Chí Minh — đầu tàu kinh tế, trung tâm đổi mới sáng tạo — hội tụ điều kiện để trở thành điểm đến của các nguồn lực tăng trưởng mới.";
	$copy['home_intro_lead_en']    = "The global economy is being restructured under the pressure of geopolitical volatility, technological breakthroughs and the green transition. Value chains are being rebuilt for diversification, regionalisation and resilience; new growth engines are shifting towards Asia, Africa and Latin America, with megacities emerging as coordinating hubs for capital, technology and innovation.\n\nViet Nam enters a new era of development, targeting GDP growth above 10% per year and a digital economy of 30% of GDP by 2030, on the soft infrastructure of diplomatic relations with 193 countries, 30 strategic partners and 16 FTAs. Ho Chi Minh City — the country’s economic locomotive and innovation hub — is positioned to become a destination for new growth resources.";
	$copy['home_theme_lead_vi']    = "“Từ ứng phó với biến động sang chủ động kiến tạo quan hệ đối tác, xây dựng lòng tin và cùng phát triển giải pháp cho các động lực tăng trưởng mới.”\n\nBốn trụ cột không tổ chức thành các phiên riêng biệt mà được lồng ghép vào cách đặt vấn đề và định hướng thảo luận của từng phiên, bảo đảm gắn kết giữa bối cảnh toàn cầu, yêu cầu phát triển của Việt Nam và các kết quả hợp tác cụ thể.";
	$copy['home_theme_lead_en']    = "“From responding to volatility to proactively building partnerships, trust and shared solutions for new growth engines.”\n\nThe four pillars are not organised as separate sessions; they are woven into the framing and direction of every session, linking the global context, Viet Nam’s development priorities and the concrete cooperation outcomes the Forum pursues.";
	$copy['home_pillars_title_vi'] = 'Bốn trụ cột nội dung';
	$copy['home_pillars_title_en'] = 'Four content pillars';
	$copy['home_pillars_lead_vi']  = 'Trên nền khung tư duy bốn trụ cột, các phiên chuyên đề ngày 27/10 được sắp xếp thành ba nhóm nội dung theo mạch triển khai của chương trình: chuyển dịch mô hình kinh tế toàn cầu; thể chế, tài chính và công nghệ chiến lược; hợp tác quốc tế vì mô hình tăng trưởng mới.';
	$copy['home_pillars_lead_en']  = 'Building on the four pillars, the thematic sessions on 27 October are organised into three content streams: shifts in the global economic model; institutions, finance and strategic technologies; and international cooperation for a new growth model.';
	$copy['home_hero_lead_vi']     = 'Chủ đề năm 2026: Tinh thần hợp tác trong kỷ nguyên mới. Diễn đàn đối thoại chính sách cấp cao do Ủy ban nhân dân Thành phố Hồ Chí Minh chủ trì.';
	$copy['home_hero_lead_en']     = '2026 theme: Collaboration in a New Era. A high-level policy dialogue convened by the People’s Committee of Ho Chi Minh City.';
	$copy['home_city_lead_vi']     = 'Diễn đàn chính diễn ra tại Thiskyhall, số 10 Mai Chí Thọ, phường An Khánh, Thành phố Hồ Chí Minh — trung tâm mới của dòng vốn, tri thức và mạng lưới hợp tác quốc tế.';
	$copy['home_city_lead_en']     = 'The main Forum takes place at Thiskyhall, 10 Mai Chi Tho Street, An Khanh Ward, Ho Chi Minh City — a new centre of capital, knowledge and international cooperation networks.';
	update_option( 'aef_copy', $copy );

	$about = get_option( 'aef_about', array() );
	if ( ! is_array( $about ) ) {
		$about = array();
	}
	$about['about_deck_vi']  = 'Do Ủy ban nhân dân Thành phố Hồ Chí Minh chủ trì.';
	$about['about_deck_en']  = 'Convened by the People’s Committee of Ho Chi Minh City.';
	$about['about_quote_vi'] = 'Từ ứng phó với biến động sang chủ động kiến tạo quan hệ đối tác, xây dựng lòng tin và cùng phát triển giải pháp cho các động lực tăng trưởng mới.';
	$about['about_quote_en'] = 'From responding to volatility to proactively building partnerships, trust and shared solutions for new growth engines.';
	$about['about_why_h_vi'] = 'Khi các cực tăng trưởng dịch chuyển, đối thoại là hạ tầng của lòng tin';
	$about['about_why_h_en'] = 'As growth engines shift, dialogue becomes the infrastructure of trust';
	$about['about_why_p_vi'] = "Kinh tế toàn cầu đang được tái cấu trúc dưới tác động của biến động địa chính trị, đột phá công nghệ và làn sóng chuyển đổi xanh. Chuỗi giá trị được thiết lập lại theo hướng đa dạng hóa, khu vực hóa và chống chịu; các cực tăng trưởng mới dịch chuyển về châu Á, châu Phi và Mỹ La-tinh, với các siêu đô thị trở thành trung tâm điều phối dòng vốn, công nghệ và đổi mới sáng tạo.\n\nViệt Nam bước vào kỷ nguyên phát triển mới với mục tiêu tăng trưởng GDP trên 10%/năm và kinh tế số đạt 30% GDP vào năm 2030. Thành phố Hồ Chí Minh — đầu tàu kinh tế, trung tâm đổi mới sáng tạo — hội tụ điều kiện để trở thành điểm đến của các nguồn lực tăng trưởng mới.";
	$about['about_why_p_en'] = "The global economy is being restructured under the pressure of geopolitical volatility, technological breakthroughs and the green transition. Value chains are being rebuilt for diversification, regionalisation and resilience; new growth engines are shifting towards Asia, Africa and Latin America, with megacities emerging as coordinating hubs for capital, technology and innovation.\n\nViet Nam enters a new era of development, targeting GDP growth above 10% per year and a digital economy of 30% of GDP by 2030. Ho Chi Minh City — the country’s economic locomotive and innovation hub — is positioned to become a destination for new growth resources.";
	$about['about_theme_p_vi'] = 'Hợp tác trong kỷ nguyên mới không chỉ là mở rộng các mối quan hệ sẵn có. Đó là khả năng cùng nhận diện vấn đề, chia sẻ tri thức, kết nối nguồn lực và xây dựng những cơ chế hành động phù hợp với một thế giới đang thay đổi nhanh chóng. Chủ đề AEF 2026 thể hiện sự chuyển dịch từ ứng phó với biến động sang chủ động kiến tạo quan hệ đối tác.';
	$about['about_theme_p_en'] = 'Collaboration in a New Era is not only widening existing relationships. It is the ability to identify problems together, share knowledge, connect resources and build ways of acting that fit a world changing quickly. The 2026 theme marks a shift from reacting to volatility toward actively building partnerships.';
	update_option( 'aef_about', $about );

	$topics = get_option( 'aef_topics', array() );
	if ( ! is_array( $topics ) ) {
		$topics = array();
	}
	$topics['topics_title_vi'] = 'Bốn trụ cột nội dung';
	$topics['topics_title_en'] = 'Four content pillars';
	$topics['topics_deck_vi']  = 'Bốn trụ cột không tổ chức thành các phiên riêng biệt mà được lồng ghép vào cách đặt vấn đề và định hướng thảo luận của từng phiên, bảo đảm gắn kết giữa bối cảnh toàn cầu, yêu cầu phát triển của Việt Nam và các kết quả hợp tác cụ thể.';
	$topics['topics_deck_en']  = 'The four pillars are not organised as separate sessions; they are woven into the framing and direction of every session, linking the global context, Viet Nam’s development priorities and the concrete cooperation outcomes the Forum pursues.';
	$topics['p1_card_vi']      = 'Siêu đô thị như trung tâm điều phối dòng vốn, công nghệ và hệ sinh thái đổi mới sáng tạo; kinh nghiệm tái cấu trúc kinh tế đô thị trong kỷ nguyên mới.';
	$topics['p1_card_en']      = 'Megacities as coordinating hubs for capital, technology and innovation ecosystems; lessons in restructuring urban economies for a new era.';
	$topics['p2_card_vi']      = 'Trí tuệ nhân tạo, công nghệ lượng tử, sản xuất thông minh và các công nghệ chiến lược tái định hình lợi thế cạnh tranh quốc gia.';
	$topics['p2_card_en']      = 'Artificial intelligence, quantum technology, smart manufacturing and strategic technologies reshaping national competitiveness.';
	$topics['p3_card_vi']      = 'Khuôn khổ hợp tác mới giữa quốc gia, địa phương, doanh nghiệp và tổ chức quốc tế nhằm điều phối, huy động nguồn lực xuyên biên giới.';
	$topics['p3_card_en']      = 'New frameworks for cooperation among nations, cities, businesses and international organisations to coordinate and mobilise resources across borders.';
	$topics['p4_card_vi']      = 'Doanh nghiệp, tập đoàn, định chế tài chính và lãnh đạo doanh nghiệp trẻ toàn cầu dẫn dắt tăng trưởng và đổi mới sáng tạo.';
	$topics['p4_card_en']      = 'Enterprises, corporations, financial institutions and young global business leaders driving growth and innovation.';
	update_option( 'aef_topics', $topics );

	$rows = array(
		'repositioning-vietnam-asean' => array(
			'Chuỗi giá trị toàn cầu đang được thiết lập lại theo hướng đa dạng hóa và khu vực hóa; phiên thảo luận vị trí mới của Việt Nam và ASEAN trong cấu trúc này.',
			'Global value chains are being rebuilt for diversification and regionalisation; the session examines the new position of Viet Nam and ASEAN in this structure.',
			"Thảo luận kinh nghiệm tái cấu trúc nền kinh tế của các quốc gia và siêu đô thị; các tiêu chí lựa chọn điểm đến đầu tư mới (an toàn, linh hoạt, liên kết chiến lược) và cách Việt Nam – ASEAN nâng cấp vai trò trong chuỗi giá trị toàn cầu.",
			'Discussion of economic restructuring experience of nations and megacities; the new criteria for investment destinations (security, flexibility, strategic links) and how Viet Nam and ASEAN can upgrade their role in global value chains.',
		),
		'esg-corporate-strategy'      => array(
			'Tiêu chuẩn ESG đang trở thành điều kiện gia nhập thị trường thế giới. Phiên gồm ba nội dung: ESG trong chiến lược phát triển doanh nghiệp; ESG và kinh tế tuần hoàn; tiêu dùng xanh và thị trường tiêu dùng bền vững.',
			'ESG standards are becoming conditions for entering global markets. The session covers three strands: ESG as a pillar of corporate strategy; ESG and the circular economy; green consumption and sustainable consumer markets.',
			'Kinh nghiệm quốc tế về khung báo cáo ESG, tài chính xanh và mô hình kinh tế tuần hoàn; vai trò của định chế tài chính và trường đại học trong nâng cao năng lực doanh nghiệp.',
			'International experience with ESG reporting frameworks, green finance and circular economy models; the role of financial institutions and universities in building enterprise capability.',
		),
		'ai-workforce-readiness'      => array(
			'Trí tuệ nhân tạo và tự động hóa đang làm giảm ưu thế lao động giá rẻ; phiên thảo luận chiến lược nhân lực cho ngành sản xuất Việt Nam.',
			'AI and automation are eroding the advantage of low-cost labour; the session discusses workforce strategy for Viet Nam’s manufacturing sector.',
			'Từ kinh nghiệm triển khai AI trong nhà máy đến yêu cầu kỹ năng mới, mô hình hợp tác doanh nghiệp – trường đào tạo và chính sách chuẩn bị nhân lực cho sản xuất thông minh.',
			'From AI deployment on the factory floor to new skill requirements, enterprise–training partnerships and policies preparing the workforce for smart manufacturing.',
		),
		'industrial-ai'               => array(
			'Siêu đô thị là trung tâm điều phối dòng vốn và công nghệ. Phiên gồm hai nội dung: trí tuệ nhân tạo và quản trị siêu đô thị; trí tuệ nhân tạo trong công nghiệp — năng suất và tối ưu vận hành nhà máy.',
			'Megacities are coordinating hubs for capital and technology. The session covers two strands: artificial intelligence and megacity governance; industrial AI — productivity and factory optimisation.',
			'Kinh nghiệm quốc tế và bài toán của Thành phố Hồ Chí Minh: dữ liệu đô thị, hạ tầng số, AI trong điều hành và trong các ngành công nghiệp chiến lược.',
			'International experience and the challenges of Ho Chi Minh City: urban data, digital infrastructure, AI in city operations and in strategic industries.',
		),
		'quantum-ecosystem'           => array(
			'Công nghệ lượng tử là công nghệ chiến lược tái định hình lợi thế cạnh tranh; phiên bàn về lộ trình phát triển hệ sinh thái lượng tử.',
			'Quantum technology is a strategic technology reshaping competitive advantage; the session addresses pathways to a quantum ecosystem.',
			'Kinh nghiệm xây dựng chiến lược lượng tử quốc gia, hợp tác nghiên cứu – doanh nghiệp, đào tạo nhân lực và ứng dụng lượng tử trong quản trị siêu đô thị.',
			'Experience in building national quantum strategies, research–industry partnerships, talent development and quantum applications in megacity governance.',
		),
		'financial-innovation-ifc'    => array(
			'Phiên chuyên đề về thu hút dòng vốn quốc tế vào Trung tâm tài chính quốc tế Việt Nam tại Thành phố Hồ Chí Minh trong giai đoạn phát triển mới.',
			'A thematic session on attracting international capital to Viet Nam’s International Financial Centre in Ho Chi Minh City in its new phase of development.',
			'Kinh nghiệm của các trung tâm tài chính quốc tế; khung thể chế, sản phẩm và hạ tầng cần thiết; vai trò của định chế tài chính, quỹ đầu tư và Ngân hàng Nhà nước trong khơi thông dòng vốn.',
			'Lessons from international financial centres; the institutional framework, products and infrastructure required; the role of financial institutions, investment funds and the State Bank in unlocking capital flows.',
		),
		'digital-economy-policy'      => array(
			'Với mục tiêu kinh tế số đạt 30% GDP vào năm 2030, phiên bàn về khung chính sách và thể chế cho kinh tế số.',
			'With a target of a digital economy at 30% of GDP by 2030, the session discusses policy and institutional frameworks for the digital economy.',
			'So sánh khung chính sách kinh tế số của các quốc gia; dữ liệu, nền tảng số, thuế và cạnh tranh; các cơ chế thử nghiệm (sandbox) và hợp tác công – tư.',
			'Comparison of digital economy policy frameworks; data, digital platforms, taxation and competition; regulatory sandboxes and public–private cooperation.',
		),
		'data-security-quantum'       => array(
			'Máy tính lượng tử đặt ra thách thức với hạ tầng mật mã hiện hành; phiên bàn về an toàn dữ liệu và an ninh mạng.',
			'Quantum computing challenges today’s cryptographic infrastructure; the session addresses data security and cybersecurity.',
			'Lộ trình chuyển đổi sang mật mã hậu lượng tử, bảo vệ dữ liệu quốc gia và doanh nghiệp, hợp tác quốc tế về an ninh mạng.',
			'Migration pathways to post-quantum cryptography, protection of national and enterprise data, and international cooperation on cybersecurity.',
		),
		'sovereign-ai'                => array(
			'Phiên thảo luận về năng lực tự chủ về trí tuệ nhân tạo — hạ tầng tính toán, dữ liệu, mô hình và nhân lực.',
			'A session on sovereign AI capabilities — computing infrastructure, data, models and talent.',
			'Kinh nghiệm các quốc gia xây dựng năng lực AI tự chủ; cân bằng giữa hợp tác quốc tế và an ninh; ứng dụng lưỡng dụng và tiêu chuẩn AI có trách nhiệm.',
			'Experience of nations building sovereign AI capability; balancing international cooperation and security; dual-use applications and responsible AI standards.',
		),
		'low-altitude-economy'        => array(
			'Kinh tế tầm thấp (drone, eVTOL) và các ngành kinh tế mới như động lực tăng trưởng cho siêu đô thị.',
			'The low-altitude economy (drones, eVTOL) and emerging industries as growth drivers for megacities.',
			'Khung pháp lý, hạ tầng và ứng dụng của kinh tế tầm thấp; kinh nghiệm quốc tế và cơ hội cho Thành phố Hồ Chí Minh trong không gian phát triển mới.',
			'Legal frameworks, infrastructure and applications of the low-altitude economy; international experience and opportunities for Ho Chi Minh City in its new development space.',
		),
		'advanced-manufacturing'      => array(
			'Phiên bàn về công nghệ sản xuất tiên tiến và năng lực cạnh tranh của doanh nghiệp Việt Nam trong chuỗi cung ứng toàn cầu.',
			'A session on advanced manufacturing technologies and the competitiveness of Vietnamese enterprises in global supply chains.',
			'Tiếp nối Tuyên bố chung TP.HCM – WEF năm 2025 về sản xuất thông minh và chuyển đổi công nghiệp có trách nhiệm; công nghệ, tiêu chuẩn và mô hình nâng cấp doanh nghiệp.',
			'Following the 2025 HCMC–WEF Joint Statement on smart manufacturing and responsible industrial transformation; technologies, standards and enterprise upgrading models.',
		),
		'smart-manufacturing-logistics' => array(
			'Kết nối sản xuất thông minh với logistics xanh trong không gian phát triển mới của Thành phố.',
			'Linking smart manufacturing with green logistics in the City’s new development space.',
			'Hạ tầng logistics, cảng và khu công nghiệp thế hệ mới; số hóa chuỗi cung ứng và giảm phát thải trong vận tải, kho bãi.',
			'Logistics infrastructure, ports and next-generation industrial parks; supply chain digitalisation and emission reduction in transport and warehousing.',
		),
		'smart-agriculture'           => array(
			'Ứng dụng công nghệ trong nông nghiệp và xây dựng chuỗi giá trị nông sản bền vững, đáp ứng tiêu chuẩn thị trường quốc tế.',
			'Technology in agriculture and building sustainable agri-food value chains that meet international market standards.',
			'Nông nghiệp chính xác, truy xuất nguồn gốc, tài chính cho nông hộ và doanh nghiệp; kết nối vùng nguyên liệu với trung tâm chế biến, xuất khẩu.',
			'Precision agriculture, traceability, finance for farmers and agribusinesses; linking production regions with processing and export hubs.',
		),
		'dual-use-industries'         => array(
			'Phiên bàn về phát triển công nghiệp lưỡng dụng và các công nghệ chiến lược phục vụ mô hình tăng trưởng mới.',
			'A session on developing dual-use industries and strategic technologies serving the new growth model.',
			'Kinh nghiệm quốc tế về công nghiệp lưỡng dụng; hợp tác nghiên cứu, chuyển giao và thương mại hóa công nghệ chiến lược; vai trò của doanh nghiệp tư nhân.',
			'International experience in dual-use industries; research cooperation, transfer and commercialisation of strategic technologies; the role of private enterprises.',
		),
		'global-future-leaders'       => array(
			'Hợp tác quốc tế của cộng đồng doanh nghiệp và các lãnh đạo doanh nghiệp trẻ toàn cầu trong kỷ nguyên mới.',
			'International collaboration among the business community and young global business leaders in the new era.',
			'Thế hệ lãnh đạo doanh nghiệp trẻ và các mạng lưới toàn cầu; đổi mới sáng tạo, khởi nghiệp và trách nhiệm xã hội; kết nối doanh nghiệp trẻ Việt Nam với thế giới.',
			'The new generation of business leaders and global networks; innovation, entrepreneurship and social responsibility; connecting young Vietnamese entrepreneurs with the world.',
		),
		'27-oct-opening'              => array(
			'Phát biểu khai mạc chương trình các phiên thảo luận chuyên đề ngày 27/10, trước 15 phiên song song tại ba phòng.',
			'Opening remarks for the 27 October thematic programme, before 15 parallel sessions in three rooms.',
			'',
			'',
		),
		'rising-star-arena'           => array(
			'Tạo không gian để các trung tâm đổi mới sáng tạo, trung tâm khoa học công nghệ và doanh nghiệp trong nước và quốc tế giới thiệu, trình diễn các công nghệ, giải pháp và mô hình đổi mới sáng tạo đã được chứng minh trong các lĩnh vực công nghệ chiến lược. Mỗi phiên 45 phút tại Thiskyhall. Danh sách đơn vị trình diễn: Đang xác nhận.',
			'A space for innovation centres, science and technology centres and domestic and international enterprises to present proven technologies, solutions and innovation models in strategic technology fields. 45 minutes per session at Thiskyhall. Presenting organisations: to be confirmed.',
			'Kết nối doanh nghiệp, nhà khởi nghiệp, viện nghiên cứu, trường đại học, nhà đầu tư và cơ quan quản lý nhằm thúc đẩy chuyển giao công nghệ, thương mại hóa kết quả nghiên cứu, thu hút đầu tư và hình thành các chương trình, dự án hợp tác sau Diễn đàn.',
			'Connecting enterprises, entrepreneurs, research institutes, universities, investors and regulators to promote technology transfer, commercialisation of research, investment attraction and post-Forum cooperation programmes and projects.',
		),
		'official-reception'          => array(
			'Tiệc chiêu đãi do Lãnh đạo Chính phủ và Thành phố Hồ Chí Minh chủ trì, dành cho đại biểu theo thư mời. Địa điểm: Đang xác nhận.',
			'A reception hosted by the Government and the leadership of Ho Chi Minh City, for invited delegates. Venue: to be confirmed.',
			'Tăng cường quan hệ đối ngoại, thúc đẩy trao đổi, kết nối và mở rộng hợp tác giữa Lãnh đạo Chính phủ Việt Nam với lãnh đạo các quốc gia, tổ chức quốc tế, các tập đoàn, doanh nghiệp và đối tác chiến lược.',
			'Strengthening external relations and expanding cooperation between Viet Nam’s Government leaders and leaders of nations, international organisations, corporations and strategic partners.',
		),
		'business-networking-dinner'  => array(
			'Diễn ra song song với tiệc chiêu đãi; kết nối cộng đồng doanh nghiệp, nhà đầu tư, quỹ đầu tư, định chế tài chính và Mạng lưới C4IR toàn cầu. Địa điểm: Đang xác nhận.',
			'Held in parallel with the reception; connecting the business community, investors, funds, financial institutions and the C4IR Global Network. Venue: to be confirmed.',
			'Thúc đẩy trao đổi cơ hội hợp tác, xúc tiến đầu tư, kết nối cung – cầu công nghệ và hình thành các sáng kiến, dự án hợp tác sau Diễn đàn.',
			'Promoting exchange on cooperation opportunities, investment promotion, technology supply–demand matching and the formation of post-Forum initiatives and projects.',
		),
		'high-level-plenary'          => array(
			'Chủ đề: Sự hội tụ của các cực tăng trưởng mới toàn cầu. Chương trình trọng tâm của Diễn đàn; Thủ tướng Chính phủ chủ trì và phát biểu định hướng. Truyền hình trực tiếp.',
			'Theme: The Convergence of New Global Growth Engines. The centrepiece of the Forum, chaired and keynoted by the Prime Minister of Viet Nam. Broadcast live.',
			'Phiên toàn thể cấp cao quy tụ Việt Nam và các quốc gia, tổ chức quốc tế, doanh nghiệp và chuyên gia toàn cầu nhằm tăng cường đối thoại chính sách, chia sẻ kinh nghiệm quốc tế và thúc đẩy hợp tác giữa Chính phủ, doanh nghiệp và các đối tác phát triển. Phát biểu của lãnh đạo Diễn đàn Kinh tế Thế giới và các tổ chức quốc tế lớn: Đang xác nhận danh sách.',
			'The High-Level Plenary brings together Viet Nam and partner nations, international organisations, businesses and global experts to strengthen policy dialogue, share international experience and promote cooperation among governments, businesses and development partners. Remarks by leaders of the World Economic Forum and major international organisations: list to be confirmed.',
		),
		'pm-dialogue'                 => array(
			'Chủ đề: Định vị Việt Nam trong tương lai toàn cầu. Trao đổi trực tiếp trên sân khấu giữa Thủ tướng Chính phủ Việt Nam và lãnh đạo/chuyên gia cấp cao của Diễn đàn Kinh tế Thế giới. Truyền hình trực tiếp.',
			'Theme: Positioning Viet Nam in the Future Global Landscape. An on-stage conversation between the Prime Minister of Viet Nam and a senior leader or expert of the World Economic Forum. Broadcast live.',
			'Thủ tướng Chính phủ trao đổi với cộng đồng quốc tế về tầm nhìn, định hướng phát triển của Việt Nam trong việc xây dựng mô hình tăng trưởng mới.',
			'The Prime Minister engages the international community on Viet Nam’s vision and development direction in building a new growth model.',
		),
		'ministerial-dialogue'        => array(
			'Phần tham luận chuyên sâu về các xu hướng toàn cầu và đối thoại giữa lãnh đạo cấp Bộ các nước về khung hợp tác trong kỷ nguyên mới. Phó Thủ tướng Chính phủ chủ trì.',
			'In-depth presentations on global trends and a dialogue among ministerial-level leaders on collaboration frameworks in a new era. Chaired by a Deputy Prime Minister.',
			"Các xu hướng phát triển của kinh tế thế giới, chuyển dịch mô hình tăng trưởng, khoa học, công nghệ, đổi mới sáng tạo, chuyển đổi số, chuyển đổi xanh và các động lực tăng trưởng mới. Số lượng tham luận: Đang xác nhận.\n\nĐối thoại tập trung vào các chính sách, giải pháp và khuôn khổ hợp tác mới giữa các nước, các địa phương nhằm cùng nâng cao năng lực cạnh tranh, hợp tác phát triển khoa học – công nghệ và đổi mới sáng tạo, điều phối và huy động nguồn lực quốc tế. Lãnh đạo Bộ Tài chính Việt Nam tham gia đối thoại. Chủ tịch UBND Thành phố Hồ Chí Minh phát biểu cảm ơn (15 phút).",
			"Trends in the world economy, shifting growth models, science, technology, innovation, digital and green transformation and new growth engines. Number of presentations: to be confirmed.\n\nThe dialogue focuses on policies, solutions and new cooperation frameworks among nations and localities to jointly raise competitiveness, cooperate in science, technology and innovation, and mobilise international resources. The leadership of Viet Nam’s Ministry of Finance joins the dialogue. Closing remarks by the Chairman of the Ho Chi Minh City People’s Committee (15 minutes).",
		),
		'gala-dinner'                 => array(
			'Tiệc Gala sau chương trình cấp cao ngày 28/10. Địa điểm: Đang xác nhận.',
			'Gala dinner after the 28 October high-level programme. Venue: to be confirmed.',
			'Toàn thể đại biểu trong nước và quốc tế tham dự; chương trình nghệ thuật và giao lưu.',
			'All domestic and international delegates attend; artistic programme and networking.',
		),
		'ceo-500-tea-connect'         => array(
			'“Góc nhìn mới từ bài toán FDI – Công nghệ – Dòng chảy tài chính toàn cầu”. Đối thoại và kết nối đầu tư cấp cao giữa lãnh đạo Chính phủ, Thành phố với mạng lưới doanh nghiệp.',
			'“New Perspectives on FDI, Technology and Global Financial Flows”. A high-level investment dialogue between Government and City leaders and the business network.',
			'Chương trình tập trung trao đổi về xu hướng dịch chuyển dòng vốn, công nghệ và tài chính toàn cầu; nhận diện cơ hội hợp tác, thu hút đầu tư, chuyển giao công nghệ và kết nối nguồn lực phục vụ phát triển các ngành kinh tế chiến lược của Việt Nam và Thành phố Hồ Chí Minh.',
			'The programme addresses shifts in global capital, technology and financial flows; identifying cooperation opportunities, investment attraction, technology transfer and resource connections for the strategic sectors of Viet Nam and Ho Chi Minh City.',
		),
		'vietnam-india-future-tech'   => array(
			'Hội thảo song phương về hợp tác công nghiệp tương lai giữa Việt Nam và Ấn Độ trong khuôn khổ Diễn đàn. Địa điểm: Đang xác nhận.',
			'A bilateral forum on future industries cooperation between Viet Nam and India, held within the framework of the Forum. Venue: to be confirmed.',
			'Trao đổi về hợp tác trong các ngành công nghiệp tương lai — công nghệ thông tin, sản xuất tiên tiến, năng lượng và đổi mới sáng tạo — giữa Thành phố Hồ Chí Minh, các Bộ, ngành và đối tác Ấn Độ.',
			'Exchange on cooperation in future industries — information technology, advanced manufacturing, energy and innovation — between Ho Chi Minh City, ministries and Indian partners.',
		),
		'dual-transition-conference'  => array(
			'Hội nghị chuyên đề về chuyển đổi số và chuyển đổi xanh cho mô hình tăng trưởng mới. Địa điểm: Đang xác nhận.',
			'A thematic conference on digital and green transformation for the new growth model. Venue: to be confirmed.',
			'Hội nghị tập trung vào kinh nghiệm quốc tế và giải pháp thực tiễn để doanh nghiệp Việt Nam đồng thời chuyển đổi số và chuyển đổi xanh, đáp ứng các tiêu chuẩn ESG đang trở thành điều kiện gia nhập thị trường thế giới.',
			'The conference focuses on international experience and practical solutions enabling Vietnamese enterprises to pursue digital and green transformation simultaneously, meeting the ESG standards that are becoming conditions for entering global markets.',
		),
		'oid-2026'                    => array(
			'Ngày hội đổi mới sáng tạo mở kết nối doanh nghiệp, startup, viện nghiên cứu, trường đại học và nhà đầu tư. Chủ đề: Thành phố Công nghiệp thế hệ mới. Thiskyhall, Sala.',
			'An open innovation day connecting enterprises, start-ups, research institutes, universities and investors. Theme: The Next-Generation Industrial City. Thiskyhall, Sala.',
			'Không gian để các trung tâm đổi mới sáng tạo, doanh nghiệp và startup giới thiệu bài toán, giải pháp và cơ hội hợp tác; thúc đẩy thương mại hóa kết quả nghiên cứu và thu hút đầu tư.',
			'A space for innovation centres, enterprises and start-ups to present challenges, solutions and cooperation opportunities; promoting commercialisation of research and attracting investment.',
		),
		'collaboration-roads'         => array(
			'Không gian hợp tác từ 26–29/10/2026 trên bốn trục Nguyễn Huệ, Tôn Đức Thắng, Lê Lợi và Đồng Khởi, cùng Triển lãm tăng trưởng xanh Thành phố Hồ Chí Minh lần thứ 4 (GRECO 2026).',
			'A cooperation space from 26 to 29 October 2026 along Nguyen Hue, Ton Duc Thang, Le Loi and Dong Khoi, alongside the 4th Ho Chi Minh City Green Growth Exhibition (GRECO 2026).',
			'Kết hợp hội nghị, hội thảo, trưng bày, triển lãm, giới thiệu sáng kiến, sản phẩm, dịch vụ và mô hình hợp tác tiêu biểu.',
			'Combining conferences, seminars, showcases and exhibitions of initiatives, products, services and collaboration models.',
		),
		'field-visits'                => array(
			'Khảo sát khu công nghệ cao, trung tâm đổi mới sáng tạo, doanh nghiệp tiêu biểu; trải nghiệm văn hóa – lịch sử của Thành phố. Địa điểm cụ thể: Đang xác nhận.',
			'Visits to the high-tech park, innovation centres and leading enterprises; cultural and historical experiences in the City. Specific sites: to be confirmed.',
			'Chương trình dành cho đại biểu nhằm giới thiệu năng lực công nghệ, hệ sinh thái đổi mới sáng tạo và bản sắc văn hóa của Thành phố Hồ Chí Minh.',
			'A programme for delegates showcasing the technological capabilities, innovation ecosystem and cultural identity of Ho Chi Minh City.',
		),
		'vietnam-israel-innovation-day' => array(
			'Hội thảo song phương về đổi mới sáng tạo giữa Việt Nam và Israel. Địa điểm: Đang xác nhận.',
			'A bilateral innovation workshop between Viet Nam and Israel. Venue: to be confirmed.',
			'Kết nối hệ sinh thái đổi mới sáng tạo Việt Nam với Israel trong các lĩnh vực công nghệ chiến lược, nông nghiệp công nghệ cao, an ninh mạng và khởi nghiệp.',
			'Connecting Viet Nam’s innovation ecosystem with Israel in strategic technologies, high-tech agriculture, cybersecurity and entrepreneurship.',
		),
		'vietnam-china-investment'    => array(
			'Hội thảo xúc tiến đầu tư, công nghệ với các đối tác Trung Quốc. Địa điểm: Đang xác nhận.',
			'An investment and technology promotion workshop with Chinese partners. Venue: to be confirmed.',
			'Giới thiệu cơ hội đầu tư của Thành phố Hồ Chí Minh trong không gian phát triển mới; kết nối doanh nghiệp, khu công nghiệp và đối tác Trung Quốc.',
			'Presenting Ho Chi Minh City’s investment opportunities in its new development space; connecting enterprises, industrial parks and Chinese partners.',
		),
		'nordic-investment'           => array(
			'Kết nối đầu tư với các đối tác khu vực Bắc Âu. Địa điểm: Đang xác nhận.',
			'Investment connections with partners from the Nordic region. Venue: to be confirmed.',
			'Hợp tác về năng lượng sạch, kinh tế tuần hoàn, đô thị bền vững và đổi mới sáng tạo với các đối tác Bắc Âu.',
			'Cooperation on clean energy, the circular economy, sustainable cities and innovation with Nordic partners.',
		),
		'c4ir-network-meeting'        => array(
			'Chương trình họp mặt thường niên Mạng lưới các Trung tâm Cách mạng công nghiệp lần thứ tư (C4IR). Địa điểm: Đang xác nhận.',
			'The annual gathering of the Centre for the Fourth Industrial Revolution (C4IR) Network. Venue: to be confirmed.',
			'Trao đổi giữa các trung tâm C4IR trên thế giới về các sáng kiến chung, chia sẻ kinh nghiệm quản trị công nghệ và định hướng hợp tác trong năm tiếp theo.',
			'Exchange among C4IR centres worldwide on joint initiatives, technology governance experience and cooperation directions for the coming year.',
		),
	);
	foreach ( $rows as $slug => $row ) {
		aef_fill_session_copy( $slug, $row[0], $row[1], $row[2], $row[3] );
	}

	update_option( 'aef_html10_copy_v1', '1' );
}

add_action( 'init', 'aef_roles_html12_v1', 46 );
function aef_roles_html12_v1() {
	if ( get_option( 'aef_roles_html12_v1' ) ) {
		return;
	}
	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$copy['home_speakers_eyebrow_vi'] = 'Diễn giả';
	$copy['home_speakers_eyebrow_en'] = 'Speakers';
	$copy['home_speakers_title_vi']   = 'Diễn giả AEF 2026';
	$copy['home_speakers_title_en']   = 'AEF 2026 speakers';
	$copy['home_speakers_lead_vi']    = 'Danh sách được công bố khi Ban Tổ chức xác nhận. Vai trò tại phiên gồm chủ trì, phát biểu đề dẫn, chào mừng, đối thoại, tham luận, điều phối viên và diễn giả tọa đàm — không chỉ hai loại điều phối / panelist.';
	$copy['home_speakers_lead_en']    = 'Names are published when the Organising Committee confirms them. Session roles include chair, keynote, welcome remarks, dialogue, presenter, moderator and panelist — not only moderator and panelist.';
	update_option( 'aef_copy', $copy );

	$panel_vi = 'Tọa đàm: 1 điều phối viên và 3–4 diễn giả tọa đàm. Danh sách: Đang xác nhận.';
	$panel_en = 'Panel: one moderator and 3–4 panelists. List: to be confirmed.';
	$q        = new WP_Query(
		array(
			'post_type'      => 'aef_session',
			'posts_per_page' => 80,
			'post_status'    => 'any',
		)
	);
	$fmt      = array(
		'27-oct-opening'             => array( 'Phát biểu khai mạc.', 'Opening remarks.' ),
		'rising-star-arena'          => array( 'Trình diễn giải pháp, mỗi lượt 45 phút. Đơn vị trình diễn: Đang xác nhận.', 'Technology showcase, 45 minutes per slot. Presenting organisations: to be confirmed.' ),
		'official-reception'         => array( 'Tiệc chiêu đãi theo thư mời.', 'Invitation-only reception.' ),
		'business-networking-dinner' => array( 'Tiệc kết nối doanh nghiệp theo thư mời.', 'Invitation-only business dinner.' ),
		'high-level-plenary'         => array( 'Phiên toàn thể, truyền hình trực tiếp. Chủ trì, phát biểu đề dẫn, chào mừng. Danh sách: Đang xác nhận.', 'Plenary, broadcast live. Chair, keynote, welcome remarks. List: to be confirmed.' ),
		'pm-dialogue'                => array( 'Đối thoại trực tiếp trên sân khấu. Chủ trì và đối tác đối thoại: Đang xác nhận nhân sự.', 'Live on-stage dialogue. Chair and dialogue partner: to be confirmed.' ),
		'ministerial-dialogue'       => array( 'Phát biểu đề dẫn, tham luận chuyên sâu, tọa đàm cấp Bộ, phát biểu cảm ơn. Số lượng tham luận: Đang xác nhận.', 'Keynote, in-depth presentations, ministerial panel, closing remarks. Number of presentations: to be confirmed.' ),
		'gala-dinner'                => array( 'Tiệc Gala theo thư mời.', 'Invitation-only gala.' ),
		'ceo-500-tea-connect'        => array( 'Đối thoại và kết nối đầu tư cấp cao.', 'High-level investment dialogue.' ),
	);
	while ( $q->have_posts() ) {
		$q->the_post();
		$id   = get_the_ID();
		$slug = $q->post->post_name;
		$room = (string) get_post_meta( $id, 'room', true );
		if ( isset( $fmt[ $slug ] ) ) {
			update_post_meta( $id, 'format_vi', $fmt[ $slug ][0] );
			update_post_meta( $id, 'format_en', $fmt[ $slug ][1] );
		} elseif ( preg_match( '/Phòng\s*0?[123]|Room\s*0?[123]/iu', $room ) ) {
			update_post_meta( $id, 'format_vi', $panel_vi );
			update_post_meta( $id, 'format_en', $panel_en );
		}
	}
	wp_reset_postdata();
	update_option( 'aef_roles_html12_v1', '1' );
}

add_action( 'init', 'aef_html12_speakers_v1', 47 );
function aef_html12_speakers_v1() {
	if ( get_option( 'aef_html12_speakers_v1' ) ) {
		return;
	}
	$cards = array(
		array(
			'slug'     => 'html-pm',
			'country'  => 'VN',
			'order'    => 1,
			'vi'       => 'Thủ tướng Chính phủ Lê Minh Hưng',
			'en'       => 'H.E. Mr Le Minh Hung, Prime Minister of Viet Nam',
			'role_vi'  => 'Thủ tướng Chính phủ nước Cộng hòa xã hội chủ nghĩa Việt Nam',
			'role_en'  => 'Prime Minister of the Socialist Republic of Viet Nam',
			'org_vi'   => 'Chính phủ Việt Nam',
			'org_en'   => 'Government of Viet Nam',
			'bio_vi'   => "Thủ tướng Chính phủ Lê Minh Hưng chủ trì và phát biểu định hướng tại Phiên Toàn thể cấp cao với chủ đề “Sự hội tụ của các cực tăng trưởng mới toàn cầu”, và chủ trì Phiên Đối thoại cùng Thủ tướng Chính phủ Việt Nam với chủ đề “Định vị Việt Nam trong tương lai toàn cầu”.\n\nTrong khuôn khổ Diễn đàn, Thủ tướng trao đổi với cộng đồng quốc tế về tầm nhìn và định hướng phát triển của Việt Nam trong việc xây dựng mô hình tăng trưởng mới.",
			'bio_en'   => "Prime Minister Le Minh Hung chairs and delivers the keynote at the High-Level Plenary on “The Convergence of New Global Growth Engines”, and chairs the Dialogue with the Prime Minister of Viet Nam on “Positioning Viet Nam in the Future Global Landscape”.\n\nWithin the Forum, the Prime Minister engages the international community on Viet Nam’s vision and development direction in building a new growth model.",
		),
		array(
			'slug'     => 'html-dpm',
			'country'  => 'VN',
			'order'    => 2,
			'vi'       => 'Phó Thủ tướng Chính phủ',
			'en'       => 'Deputy Prime Minister of Viet Nam',
			'role_vi'  => 'Phó Thủ tướng Chính phủ (đang xác nhận nhân sự)',
			'role_en'  => 'Deputy Prime Minister (to be confirmed)',
			'org_vi'   => 'Chính phủ Việt Nam',
			'org_en'   => 'Government of Viet Nam',
			'bio_vi'   => "Theo Đề án tổ chức Diễn đàn, một đồng chí Phó Thủ tướng Chính phủ được đề xuất chủ trì các hoạt động trọng tâm: tiệc chiêu đãi tối 27/10 và phiên chiều 28/10 (tham luận chuyên sâu và đối thoại cấp Bộ).\n\nNhân sự và tiểu sử chính thức sẽ được cập nhật khi có quyết định phân công. Địa điểm tiệc chiêu đãi: Đang xác nhận.",
			'bio_en'   => "Under the Forum Project Proposal, a Deputy Prime Minister is proposed to chair key activities: the 27 October reception and the 28 October afternoon session (in-depth presentations and ministerial dialogue).\n\nThe appointee and official biography will be updated once the assignment is decided. Reception venue: to be confirmed.",
		),
		array(
			'slug'     => 'html-wef',
			'country'  => 'CH',
			'order'    => 3,
			'vi'       => 'Lãnh đạo cấp cao Diễn đàn Kinh tế Thế giới',
			'en'       => 'Senior Leadership, World Economic Forum',
			'role_vi'  => 'Lãnh đạo cấp cao WEF (đang xác nhận)',
			'role_en'  => 'Senior WEF Leadership (to be confirmed)',
			'org_vi'   => 'Diễn đàn Kinh tế Thế giới (WEF), Geneva',
			'org_en'   => 'World Economic Forum (WEF), Geneva',
			'bio_vi'   => "Lãnh đạo cấp cao WEF tham dự và phát biểu tại Phiên Toàn thể cấp cao ngày 28/10, đồng thời tham gia đối thoại cùng Thủ tướng Chính phủ Việt Nam trong phiên “Định vị Việt Nam trong tương lai toàn cầu”.\n\nNhân sự cụ thể và tiểu sử sẽ được cập nhật khi WEF xác nhận đoàn tham dự.",
			'bio_en'   => "Senior WEF leadership attends and speaks at the High-Level Plenary on 28 October and joins the Prime Minister of Viet Nam in the Dialogue on “Positioning Viet Nam in the Future Global Landscape”.\n\nThe delegation and biographies will be updated once confirmed by WEF.",
		),
		array(
			'slug'     => 'html-hcmc',
			'country'  => 'VN',
			'order'    => 4,
			'vi'       => 'Lãnh đạo Ủy ban nhân dân Thành phố Hồ Chí Minh',
			'en'       => 'Leadership of the Ho Chi Minh City People’s Committee',
			'role_vi'  => 'Lãnh đạo UBND Thành phố Hồ Chí Minh — cơ quan chủ trì Diễn đàn',
			'role_en'  => 'Leadership of the HCMC People’s Committee — Forum host',
			'org_vi'   => 'Ủy ban nhân dân Thành phố Hồ Chí Minh',
			'org_en'   => 'Ho Chi Minh City People’s Committee',
			'bio_vi'   => "Ủy ban nhân dân Thành phố Hồ Chí Minh là địa phương chủ trì tổ chức Diễn đàn Kinh tế Mùa thu năm 2026: chủ trì xây dựng và triển khai Kế hoạch tổng thể, đầu mối điều phối giữa các Bộ, ngành, địa phương và đối tác quốc tế.\n\nLãnh đạo Thành phố tham dự các hoạt động cụ thể sẽ được cập nhật theo phân công của Ban Tổ chức.",
			'bio_en'   => "The Ho Chi Minh City People’s Committee hosts the Autumn Economic Forum 2026: it develops and implements the master plan and coordinates among ministries, localities and international partners.\n\nCity leaders attending specific activities will be updated according to the Organising Committee’s assignments.",
		),
		array(
			'slug'     => 'html-mof',
			'country'  => 'VN',
			'order'    => 5,
			'vi'       => 'Lãnh đạo Bộ Tài chính',
			'en'       => 'Leadership of the Ministry of Finance',
			'role_vi'  => 'Lãnh đạo Bộ Tài chính Việt Nam (đang xác nhận)',
			'role_en'  => 'Leadership of Viet Nam’s Ministry of Finance (to be confirmed)',
			'org_vi'   => 'Bộ Tài chính',
			'org_en'   => 'Ministry of Finance of Viet Nam',
			'bio_vi'   => "Bộ Tài chính cử Lãnh đạo Bộ tham gia tọa đàm cấp Bộ ngày 28/10 với chủ đề “Khung hợp tác trong kỷ nguyên mới”; phối hợp nội dung phiên Trung tâm tài chính quốc tế ngày 27/10; phối hợp tổ chức CEO 500 — TEA CONNECT.\n\nNhân sự sẽ được cập nhật khi Bộ Tài chính xác nhận.",
			'bio_en'   => "The Ministry of Finance assigns a member of its leadership to the 28 October ministerial dialogue on “Collaboration Frameworks in a New Era”; supports the International Financial Centre session on 27 October; and co-organises CEO 500 — TEA CONNECT.\n\nThe appointee will be updated once confirmed by the Ministry.",
		),
		array(
			'slug'     => 'html-mofa',
			'country'  => 'VN',
			'order'    => 6,
			'vi'       => 'Lãnh đạo Bộ Ngoại giao',
			'en'       => 'Leadership of the Ministry of Foreign Affairs',
			'role_vi'  => 'Lãnh đạo Bộ Ngoại giao Việt Nam (đang xác nhận)',
			'role_en'  => 'Leadership of Viet Nam’s Ministry of Foreign Affairs (to be confirmed)',
			'org_vi'   => 'Bộ Ngoại giao',
			'org_en'   => 'Ministry of Foreign Affairs of Viet Nam',
			'bio_vi'   => "Bộ Ngoại giao phối hợp tổ chức CEO 500 — TEA CONNECT; chủ trì công tác đối ngoại, lễ tân và các hoạt động tiếp xúc song phương, đa phương của Lãnh đạo Chính phủ trong thời gian Diễn đàn.\n\nNhân sự sẽ được cập nhật khi Bộ Ngoại giao xác nhận.",
			'bio_en'   => "The Ministry of Foreign Affairs co-organises CEO 500 — TEA CONNECT and leads external relations, protocol and bilateral and multilateral engagements of Government leaders during the Forum.\n\nThe appointee will be updated once confirmed by the Ministry.",
		),
		array(
			'slug'     => 'html-ministers',
			'country'  => '',
			'order'    => 7,
			'vi'       => 'Bộ trưởng/Thứ trưởng các nước đối tác',
			'en'       => 'Ministers and Vice-Ministers of Partner Countries',
			'role_vi'  => 'Lãnh đạo cấp Bộ các quốc gia đối tác (đang vận động, xác nhận)',
			'role_en'  => 'Ministerial-level leaders of partner countries (being engaged and confirmed)',
			'org_vi'   => 'Các quốc gia đối tác',
			'org_en'   => 'Partner countries',
			'bio_vi'   => "Đối thoại giữa lãnh đạo cấp Bộ các nước là điểm nhấn phiên chiều 28/10, hình thức tọa đàm trên sân khấu với chủ đề “Khung hợp tác trong kỷ nguyên mới”.\n\nDanh sách Bộ trưởng/Thứ trưởng sẽ được cập nhật khi các nước xác nhận.",
			'bio_en'   => "The ministerial dialogue is the highlight of the 28 October afternoon, staged as an on-stage panel on “Collaboration Frameworks in a New Era”.\n\nThe list of ministers and vice-ministers will be updated as countries confirm.",
		),
		array(
			'slug'     => 'html-intl',
			'country'  => '',
			'order'    => 8,
			'vi'       => 'Lãnh đạo, chuyên gia các tổ chức quốc tế và đa phương',
			'en'       => 'Leaders and Experts of International and Multilateral Organisations',
			'role_vi'  => 'Diễn giả tham luận chuyên sâu (đang xác nhận)',
			'role_en'  => 'In-depth presentation speakers (to be confirmed)',
			'org_vi'   => 'Tổ chức quốc tế, đa phương và tổ chức chuyên môn',
			'org_en'   => 'International, multilateral and specialised organisations',
			'bio_vi'   => "Phần tham luận chuyên sâu về các xu hướng toàn cầu do lãnh đạo, chuyên gia các tổ chức quốc tế, đa phương và chuyên môn có uy tín trình bày.\n\nDanh sách diễn giả sẽ được cập nhật khi Ban Tổ chức xác nhận.",
			'bio_en'   => "In-depth presentations on global trends are delivered by leaders and experts of reputable international, multilateral and specialised organisations.\n\nThe speaker list will be updated once confirmed by the Organising Committee.",
		),
		array(
			'slug'     => 'html-c4ir',
			'country'  => '',
			'order'    => 9,
			'vi'       => 'Đại diện Mạng lưới C4IR toàn cầu',
			'en'       => 'Representatives of the C4IR Global Network',
			'role_vi'  => 'Lãnh đạo các Trung tâm Cách mạng công nghiệp lần thứ tư (đang xác nhận)',
			'role_en'  => 'Leaders of Centres for the Fourth Industrial Revolution (to be confirmed)',
			'org_vi'   => 'Mạng lưới C4IR',
			'org_en'   => 'C4IR Network',
			'bio_vi'   => "Đại diện mạng lưới tham dự Tiệc tối kết nối doanh nghiệp tối 27/10 và Họp mặt thường niên Mạng lưới C4IR ngày 29/10.\n\nDanh sách thành viên mạng lưới tham dự sẽ được cập nhật khi xác nhận.",
			'bio_en'   => "Network representatives attend the Business Networking Dinner on 27 October and the C4IR Network Annual Gathering on 29 October.\n\nThe list of attending members will be updated once confirmed.",
		),
	);

	$ids = array();
	foreach ( $cards as $c ) {
		$existing = get_page_by_path( $c['slug'], OBJECT, 'aef_speaker' );
		$data     = array(
			'post_title'   => $c['en'],
			'post_name'    => $c['slug'],
			'post_status'  => 'publish',
			'post_type'    => 'aef_speaker',
			'post_excerpt' => $c['role_en'] . ' — ' . $c['org_en'],
			'post_content' => $c['bio_en'],
			'menu_order'   => $c['order'],
		);
		if ( $existing ) {
			$data['ID'] = $existing->ID;
			$id         = wp_update_post( $data );
		} else {
			$id = wp_insert_post( $data );
		}
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		update_post_meta( $id, 'title_en', $c['en'] );
		update_post_meta( $id, 'title_vi', $c['vi'] );
		update_post_meta( $id, 'excerpt_en', $c['role_en'] . ' — ' . $c['org_en'] );
		update_post_meta( $id, 'excerpt_vi', $c['role_vi'] . ' — ' . $c['org_vi'] );
		update_post_meta( $id, 'content_en', $c['bio_en'] );
		update_post_meta( $id, 'content_vi', $c['bio_vi'] );
		update_post_meta( $id, 'role_en', $c['role_en'] );
		update_post_meta( $id, 'role_vi', $c['role_vi'] );
		update_post_meta( $id, 'org_en', $c['org_en'] );
		update_post_meta( $id, 'org_vi', $c['org_vi'] );
		update_post_meta( $id, 'country', $c['country'] );
		update_post_meta( $id, 'is_mockup', '' );
		$ids[ $c['slug'] ] = (int) $id;
	}

	$set = static function ( $session_slug, $rows ) use ( $ids ) {
		$session = get_page_by_path( $session_slug, OBJECT, 'aef_session' );
		if ( ! $session ) {
			return;
		}
		$people = array();
		$seen   = array();
		foreach ( $rows as $row ) {
			$spk_slug = $row[0];
			$role     = $row[1];
			if ( empty( $ids[ $spk_slug ] ) || isset( $seen[ $spk_slug ] ) ) {
				continue;
			}
			$seen[ $spk_slug ] = true;
			$people[]          = array(
				'id'   => $ids[ $spk_slug ],
				'role' => $role,
			);
		}
		delete_post_meta( $session->ID, 'aef_person' );
		foreach ( $people as $row ) {
			add_post_meta( $session->ID, 'aef_person', $row['id'] );
		}
		update_post_meta( $session->ID, 'aef_people', $people );
	};

	$set( 'high-level-plenary', array( array( 'html-pm', 'chair' ), array( 'html-pm', 'keynote' ), array( 'html-wef', 'speaker' ) ) );
	$set( 'pm-dialogue', array( array( 'html-pm', 'chair' ), array( 'html-wef', 'dialogue' ) ) );
	$set( 'ministerial-dialogue', array( array( 'html-dpm', 'chair' ), array( 'html-dpm', 'keynote' ), array( 'html-intl', 'presenter' ), array( 'html-wef', 'presenter' ), array( 'html-mof', 'panelist' ), array( 'html-ministers', 'panelist' ), array( 'html-hcmc', 'closing' ) ) );
	$set( 'official-reception', array( array( 'html-dpm', 'chair' ), array( 'html-hcmc', 'co_chair' ), array( 'html-wef', 'speaker' ) ) );
	$set( 'business-networking-dinner', array( array( 'html-c4ir', 'speaker' ) ) );
	$set( 'ceo-500-tea-connect', array( array( 'html-hcmc', 'chair' ), array( 'html-mofa', 'co_chair' ), array( 'html-mof', 'speaker' ) ) );
	$set( 'financial-innovation-ifc', array( array( 'html-mof', 'speaker' ) ) );
	$set( 'repositioning-vietnam-asean', array( array( 'html-wef', 'co_chair' ) ) );
	$set( 'ai-workforce-readiness', array( array( 'html-wef', 'co_chair' ) ) );
	$set( 'c4ir-network-meeting', array( array( 'html-c4ir', 'speaker' ), array( 'html-wef', 'speaker' ) ) );
	$set( '27-oct-opening', array( array( 'html-hcmc', 'welcome' ) ) );

	$mocks = get_posts(
		array(
			'post_type'      => 'aef_speaker',
			'posts_per_page' => 200,
			'post_status'    => 'publish',
		)
	);
	foreach ( $mocks as $p ) {
		if ( 0 === strpos( $p->post_name, 'html-' ) ) {
			continue;
		}
		if ( '1' === (string) get_post_meta( $p->ID, 'is_mockup', true ) ) {
			wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'draft' ) );
		}
	}

	update_option( 'aef_html12_speakers_v1', '1' );
}

add_action( 'init', 'aef_html12_more_v1', 48 );
function aef_html12_more_v1() {
	if ( get_option( 'aef_html12_more_v1' ) ) {
		return;
	}
	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$copy['home_week_eyebrow_vi']     = 'Khung chương trình';
	$copy['home_week_eyebrow_en']     = 'Programme framework';
	$copy['home_week_title_vi']       = 'Bốn ngày, một mạch hội tụ';
	$copy['home_week_title_en']       = 'Four days, one path of convergence';
	$copy['home_week_lead_vi']        = 'Ngày 26/10 là tiền diễn đàn; 27/10 chiều sâu chuyên đề và Rising Star Arena; 28/10 đối thoại chiến lược cấp cao; 29/10 hội thảo và họp mặt mạng lưới. Chọn một ngày để xem nội dung, diễn giả và thời lượng.';
	$copy['home_week_lead_en']        = '26 October is pre-Forum; 27 October is thematic depth and the Rising Star Arena; 28 October is high-level strategic dialogue; 29 October is seminars and the network gathering. Select a day for content, speakers and duration.';
	$copy['home_outcomes_eyebrow_vi'] = 'Mục tiêu và kết quả kỳ vọng';
	$copy['home_outcomes_eyebrow_en'] = 'Objectives and expected outcomes';
	$copy['home_outcomes_title_vi']   = 'Từ đối thoại đến hành động';
	$copy['home_outcomes_title_en']   = 'From dialogue to action';
	$copy['home_outcomes_lead_vi']    = 'Phát huy kết quả Diễn đàn năm 2025, trong đó có Tuyên bố chung giữa Thành phố Hồ Chí Minh và WEF về sản xuất thông minh và chuyển đổi công nghiệp có trách nhiệm.';
	$copy['home_outcomes_lead_en']    = 'Building on the outcomes of the 2025 Forum, including the Joint Statement between Ho Chi Minh City and WEF on smart manufacturing and responsible industrial transformation.';
	$copy['home_fig_1_n']             = '~2.000';
	$copy['home_fig_1_vi']            = 'đại biểu trong nước và quốc tế dự kiến';
	$copy['home_fig_1_en']            = 'domestic and international delegates expected';
	$copy['home_fig_2_n']             = '02';
	$copy['home_fig_2_vi']            = 'ngày diễn đàn chính (27–28/10)';
	$copy['home_fig_2_en']            = 'main Forum days (27–28 October)';
	$copy['home_fig_3_n']             = '15';
	$copy['home_fig_3_vi']            = 'phiên chuyên đề song song tại 3 phòng';
	$copy['home_fig_3_en']            = 'parallel thematic sessions across 3 rooms';
	$copy['home_fig_4_n']             = '—';
	$copy['home_fig_4_n_vi']          = '—';
	$copy['home_fig_4_n_en']          = '—';
	$copy['home_fig_4_vi']            = 'lượt Rising Star Arena — Đang xác nhận';
	$copy['home_fig_4_en']            = 'Rising Star Arena slots — to be confirmed';
	$copy['home_programme_title_vi']  = 'Bốn ngày, một mạch hội tụ';
	$copy['home_programme_title_en']  = 'Four days, one path of convergence';
	$copy['home_side_title_vi']       = 'Không gian hợp tác bên lề Diễn đàn';
	$copy['home_side_title_en']       = 'Collaboration spaces alongside the Forum';
	update_option( 'aef_copy', $copy );

	$leads = array(
		'dual-transition-conference'    => array( 'HCMC C4IR', 'HCMC C4IR' ),
		'vietnam-india-future-tech'     => array( 'UBND TP.HCM, HCMC C4IR', 'HCMC People’s Committee, HCMC C4IR' ),
		'oid-2026'                      => array( 'HCMC C4IR', 'HCMC C4IR' ),
		'ceo-500-tea-connect'           => array( 'UBND TP.HCM chủ trì; phối hợp Bộ Ngoại giao, Bộ Tài chính', 'HCMC People’s Committee, with the Ministry of Foreign Affairs and the Ministry of Finance' ),
		'repositioning-vietnam-asean'   => array( 'Bộ Công Thương', 'Ministry of Industry and Trade' ),
		'esg-corporate-strategy'        => array( 'Bộ Tài chính, ĐHQG-HCM', 'Ministry of Finance and VNU-HCM' ),
		'ai-workforce-readiness'        => array( 'Bộ Công Thương', 'Ministry of Industry and Trade' ),
		'industrial-ai'                 => array( 'Bộ Khoa học và Công nghệ', 'Ministry of Science and Technology' ),
		'quantum-ecosystem'             => array( 'Bộ Khoa học và Công nghệ', 'Ministry of Science and Technology' ),
		'financial-innovation-ifc'      => array( 'Bộ Tài chính, Ngân hàng Nhà nước Việt Nam', 'Ministry of Finance and the State Bank of Viet Nam' ),
		'digital-economy-policy'        => array( 'Bộ Khoa học và Công nghệ', 'Ministry of Science and Technology' ),
		'data-security-quantum'         => array( 'Bộ Công an', 'Ministry of Public Security' ),
		'sovereign-ai'                  => array( 'Bộ Quốc phòng, Bộ Khoa học và Công nghệ', 'Ministry of National Defence and the Ministry of Science and Technology' ),
		'low-altitude-economy'          => array( 'Bộ Quốc phòng, Bộ Xây dựng', 'Ministry of National Defence and the Ministry of Construction' ),
		'advanced-manufacturing'        => array( 'Bộ Công Thương', 'Ministry of Industry and Trade' ),
		'smart-manufacturing-logistics' => array( 'Bộ Xây dựng', 'Ministry of Construction' ),
		'smart-agriculture'             => array( 'Bộ Nông nghiệp và Môi trường', 'Ministry of Agriculture and Environment' ),
		'dual-use-industries'           => array( 'Bộ Công an', 'Ministry of Public Security' ),
		'global-future-leaders'         => array( 'Đang xác nhận', 'To be confirmed' ),
		'rising-star-arena'             => array( 'HCMC C4IR', 'HCMC C4IR' ),
		'official-reception'            => array( 'Phó Thủ tướng Chính phủ chủ trì', 'Chaired by a Deputy Prime Minister' ),
		'business-networking-dinner'    => array( 'UBND TP.HCM, HCMC C4IR', 'HCMC People’s Committee, HCMC C4IR' ),
		'high-level-plenary'            => array( 'Thủ tướng Chính phủ chủ trì', 'Chaired by the Prime Minister' ),
		'pm-dialogue'                   => array( 'Thủ tướng Chính phủ chủ trì; phối hợp WEF tại phiên này', 'Chaired by the Prime Minister; WEF joins this session' ),
		'ministerial-dialogue'          => array( 'Phó Thủ tướng Chính phủ chủ trì', 'Chaired by a Deputy Prime Minister' ),
		'gala-dinner'                   => array( 'UBND TP.HCM', 'HCMC People’s Committee' ),
		'vietnam-israel-innovation-day' => array( 'HCMC C4IR', 'HCMC C4IR' ),
		'vietnam-china-investment'      => array( 'HCMC C4IR', 'HCMC C4IR' ),
		'nordic-investment'             => array( 'HCMC C4IR', 'HCMC C4IR' ),
		'field-visits'                  => array( 'UBND TP.HCM', 'HCMC People’s Committee' ),
		'c4ir-network-meeting'          => array( 'HCMC C4IR', 'HCMC C4IR' ),
		'27-oct-opening'                => array( 'Phó Chủ tịch UBND Thành phố Hồ Chí Minh', 'A Vice Chairman of the Ho Chi Minh City People’s Committee' ),
		'collaboration-roads'           => array( 'UBND TP.HCM', 'HCMC People’s Committee' ),
	);
	$aud_all_vi = 'Toàn thể đại biểu trong nước và quốc tế tham dự Diễn đàn.';
	$aud_all_en = 'All domestic and international Forum delegates.';
	$aud_inv_vi = 'Đại biểu theo thư mời của Ban Tổ chức.';
	$aud_inv_en = 'Delegates invited by the Organising Committee.';
	foreach ( $leads as $slug => $pair ) {
		$p = get_page_by_path( $slug, OBJECT, 'aef_session' );
		if ( ! $p ) {
			continue;
		}
		update_post_meta( $p->ID, 'lead_vi', $pair[0] );
		update_post_meta( $p->ID, 'lead_en', $pair[1] );
		if ( in_array( $slug, array( 'high-level-plenary', 'pm-dialogue', 'ministerial-dialogue' ), true ) ) {
			update_post_meta( $p->ID, 'audience_vi', $aud_all_vi );
			update_post_meta( $p->ID, 'audience_en', $aud_all_en );
		} elseif ( in_array( $slug, array( 'official-reception', 'business-networking-dinner', 'gala-dinner' ), true ) ) {
			update_post_meta( $p->ID, 'audience_vi', $aud_inv_vi );
			update_post_meta( $p->ID, 'audience_en', $aud_inv_en );
		}
	}
	update_option( 'aef_html12_more_v1', '1' );
}

add_action( 'init', 'aef_html12_pillars_v1', 49 );
function aef_html12_pillars_v1() {
	if ( get_option( 'aef_html12_pillars_v1' ) ) {
		return;
	}
	$topics = get_option( 'aef_topics', array() );
	if ( ! is_array( $topics ) ) {
		$topics = array();
	}
	$topics['p1_title_vi'] = 'Vai trò của các siêu đô thị';
	$topics['p1_title_en'] = 'The role of megacities';
	$topics['p1_card_vi']  = 'Siêu đô thị như trung tâm điều phối dòng vốn, công nghệ và hệ sinh thái đổi mới sáng tạo; kinh nghiệm tái cấu trúc kinh tế đô thị trong kỷ nguyên mới.';
	$topics['p1_card_en']  = 'Megacities as coordinating hubs for capital, technology and innovation ecosystems; lessons in restructuring urban economies for a new era.';
	$topics['p2_title_vi'] = 'Công nghệ đột phá và hệ sinh thái đổi mới sáng tạo';
	$topics['p2_title_en'] = 'Breakthrough technologies and innovation ecosystems';
	$topics['p2_card_vi']  = 'Trí tuệ nhân tạo, công nghệ lượng tử, sản xuất thông minh và các công nghệ chiến lược tái định hình lợi thế cạnh tranh quốc gia.';
	$topics['p2_card_en']  = 'Artificial intelligence, quantum technology, smart manufacturing and strategic technologies reshaping national competitiveness.';
	$topics['p3_title_vi'] = 'Các mô hình hợp tác trong kỷ nguyên mới';
	$topics['p3_title_en'] = 'Collaboration models in the new era';
	$topics['p3_card_vi']  = 'Khuôn khổ hợp tác mới giữa quốc gia, địa phương, doanh nghiệp và tổ chức quốc tế nhằm điều phối, huy động nguồn lực xuyên biên giới.';
	$topics['p3_card_en']  = 'New frameworks for cooperation among nations, cities, businesses and international organisations to coordinate and mobilise resources across borders.';
	$topics['p4_title_vi'] = 'Vai trò tiên phong của khu vực tư nhân';
	$topics['p4_title_en'] = 'The pioneering role of the private sector';
	$topics['p4_card_vi']  = 'Doanh nghiệp, tập đoàn, định chế tài chính và lãnh đạo doanh nghiệp trẻ toàn cầu dẫn dắt tăng trưởng và đổi mới sáng tạo.';
	$topics['p4_card_en']  = 'Enterprises, corporations, financial institutions and young global business leaders driving growth and innovation.';
	update_option( 'aef_topics', $topics );
	update_option( 'aef_html12_pillars_v1', '1' );
}

add_action( 'init', 'aef_home_html12_order_v1', 50 );
function aef_home_html12_order_v1() {
	if ( get_option( 'aef_home_html12_order_v1' ) ) {
		return;
	}
	update_option(
		'aef_home_order',
		array( 'hero', 'figures', 'intro', 'hosts', 'theme', 'programme', 'side', 'partners', 'media', 'outcomes', 'city', 'speakers', 'support', 'close', 'week', 'audience', 'edition' )
	);
	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$copy['block_figures']  = '1';
	$copy['block_city']     = '1';
	$copy['block_week']     = '0';
	$copy['block_audience'] = '0';
	update_option( 'aef_copy', $copy );
	update_option( 'aef_home_html12_order_v1', '1' );
}

add_action( 'init', 'aef_ensure_travel_page_v1', 51 );
function aef_ensure_travel_page_v1() {
	if ( get_option( 'aef_travel_page_v1' ) ) {
		return;
	}
	$p = get_page_by_path( 'travel' );
	if ( ! $p ) {
		$id = wp_insert_post(
			array(
				'post_title'   => 'Cẩm nang đi lại',
				'post_name'    => 'travel',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
				'post_excerpt' => 'Địa điểm, lưu trú, sân bay và thành phố.',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, 'title_en', 'Travel kit' );
			update_post_meta( $id, 'excerpt_en', 'Venue, stay, airport and the city.' );
			update_post_meta( $id, 'excerpt_vi', 'Địa điểm, lưu trú, sân bay và thành phố.' );
		}
	} elseif ( 'publish' !== $p->post_status ) {
		wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'publish', 'post_name' => 'travel' ) );
	}
	flush_rewrite_rules( false );
	update_option( 'aef_travel_page_v1', '1' );
}

add_action( 'init', 'aef_backfill_page_i18n', 40 );
function aef_backfill_page_i18n() {
	if ( get_option( 'aef_page_excerpt_en_v1' ) ) {
		return;
	}
	$pages = array(
		'topics'   => array(
			'title_en'    => 'Four content pillars',
			'excerpt_en'  => 'Each pillar opens a set of policy questions and cooperation opportunities that run through the sessions and side events. The four pillars are a thinking frame, not four separate sessions.',
		),
		'partners' => array(
			'title_en'    => 'Partners',
			'excerpt_en'  => 'Identity is shown by role. The full list and any tiers need Organising Committee approval before public release.',
		),
	);
	foreach ( $pages as $slug => $meta ) {
		$p = get_page_by_path( $slug );
		if ( ! $p ) {
			continue;
		}
		foreach ( $meta as $key => $val ) {
			if ( ! get_post_meta( $p->ID, $key, true ) ) {
				update_post_meta( $p->ID, $key, $val );
			}
		}
		if ( ! get_post_meta( $p->ID, 'excerpt_vi', true ) && $p->post_excerpt ) {
			update_post_meta( $p->ID, 'excerpt_vi', $p->post_excerpt );
		}
	}
	update_option( 'aef_page_excerpt_en_v1', '1' );
}

add_action( 'wp_enqueue_scripts', 'aef_assets' );
function aef_assets() {
	$css = get_template_directory() . '/assets/site.css';
	$js  = get_template_directory() . '/assets/front.js';
	wp_enqueue_style( 'aef-site', get_template_directory_uri() . '/assets/site.css', array(), (string) ( file_exists( $css ) ? filemtime( $css ) : '1.5.35' ) );
	wp_enqueue_style( 'aef-theme', get_stylesheet_uri(), array( 'aef-site' ), '1.5.4' );
	wp_enqueue_script( 'aef-front', get_template_directory_uri() . '/assets/front.js', array(), (string) ( file_exists( $js ) ? filemtime( $js ) : '1.0.5' ), true );
}

add_action( 'wp_enqueue_scripts', 'aef_enqueue_custom_css', 50 );
function aef_enqueue_custom_css() {
	if ( ! function_exists( 'aef_custom_css_on' ) || ! aef_custom_css_on() ) {
		return;
	}
	$css = function_exists( 'aef_custom_css' ) ? aef_custom_css() : '';
	$css = trim( $css );
	if ( '' === $css ) {
		return;
	}
	wp_register_style( 'aef-custom', false, array( 'aef-site', 'aef-theme' ), null );
	wp_enqueue_style( 'aef-custom' );
	wp_add_inline_style( 'aef-custom', $css );
}

add_filter( 'document_title_parts', 'aef_title_parts' );
function aef_title_parts( $parts ) {
	$parts['site'] = 'AEF 2026';
	if ( is_singular() ) {
		$t = aef_bilingual_title( get_queried_object_id() );
		if ( $t ) {
			$parts['title'] = $t;
		}
	}
	return $parts;
}

function aef_opener( $eyebrow, $title, $desc = '', $img = '', $credit = '', $extra = '' ) {
	ob_start();
	$cover = $img ? ' on-dark has-cover' : '';
	if ( $extra ) {
		$cover .= ' ' . sanitize_html_class( $extra );
	}
	?>
	<header class="page-opener<?php echo esc_attr( $cover ); ?>">
		<?php if ( $img ) : ?>
			<div class="opener-photo" style="background-image:url('<?php echo esc_url( $img ); ?>')"></div>
		<?php endif; ?>
		<div class="shell">
			<?php if ( $eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<?php echo function_exists( 'aef_title_lines_html' ) ? aef_title_lines_html( $title, 'h1' ) : ( '<h1>' . esc_html( $title ) . '</h1>' ); ?>
			<?php if ( $desc ) : ?>
				<p class="lead"><?php echo esc_html( $desc ); ?></p>
			<?php endif; ?>
			<?php if ( $credit && $img ) : ?>
				<p class="opener-credit"><?php echo esc_html( $credit ); ?></p>
			<?php endif; ?>
		</div>
	</header>
	<?php
	return ob_get_clean();
}

function aef_phero( $crumbs, $title, $desc = '', $img = '' ) {
	$html  = '<section class="phero on-dark' . ( $img ? ' tall' : '' ) . '">';
	if ( $img ) {
		$html .= '<div class="phero-photo" style="background-image:url(\'' . esc_url( $img ) . '\')"></div>';
	}
	$html .= '<svg class="phero-art" viewBox="0 0 1440 400" preserveAspectRatio="xMidYMid slice" aria-hidden="true" style="z-index:1"><path d="M-60 440 C 340 400 760 300 1080 130 C 1200 66 1300 20 1460 -40" stroke="rgba(255,255,255,.32)" stroke-width="2" fill="none"/></svg>';
	$html .= '<div class="shell"><div class="crumb">';
	foreach ( $crumbs as $c ) {
		if ( ! empty( $c[1] ) ) {
			$html .= '<a href="' . esc_url( $c[1] ) . '">' . esc_html( $c[0] ) . '</a><span>/</span>';
		} else {
			$html .= '<span>' . esc_html( $c[0] ) . '</span>';
		}
	}
	$html .= '</div><h1>' . esc_html( $title ) . '</h1>';
	if ( $desc ) {
		$html .= '<p>' . esc_html( $desc ) . '</p>';
	}
	$html .= '</div></section>';
	return $html;
}

function aef_maps() {
	$s = aef_settings();
	ob_start();
	?>
	<section class="blk venue-system">
		<div class="shell">
			<div class="hd rv"><div>
				<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Venue', 'vi' => 'Địa điểm' ) ) ); ?></p>
				<h2><?php echo aef_lang() === 'vi' ? 'Bản đồ và<br>lối vào sự kiện' : 'Map and<br>arrival'; ?></h2>
			</div>
			<p class="lead"><?php echo esc_html( aef_t( array(
				'en' => 'Thiskyhall, 10 Mai Chi Tho, Sala, An Khanh. Access and transfer follow the Organising Committee’s guidance for delegates and accredited press.',
				'vi' => 'Thiskyhall, số 10 Mai Chí Thọ, Sala, phường An Khánh. Lối vào và đưa đón thực hiện theo hướng dẫn của Ban Tổ chức dành cho đại biểu và phóng viên đã được cấp thẻ.',
			) ) ); ?></p></div>
			<div class="venue-layout">
				<div class="venue-map rv" role="img" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Illustrative venue map', 'vi' => 'Bản đồ minh họa' ) ) ); ?>">
					<div class="route-line"></div>
					<button class="map-node venue" type="button"><b>AEF</b><span>Thiskyhall Sala</span></button>
					<button class="map-node press" type="button"><b>M</b><span><?php echo esc_html( aef_t( array( 'en' => 'Media', 'vi' => 'Báo chí' ) ) ); ?></span></button>
					<button class="map-node hotel" type="button"><b>H</b><span><?php echo esc_html( aef_t( array( 'en' => 'Hotels', 'vi' => 'Lưu trú' ) ) ); ?></span></button>
					<p class="map-disclosure"><?php echo esc_html( aef_t( array( 'en' => 'Schematic diagram, not for navigation', 'vi' => 'Sơ đồ minh họa, không dùng để dẫn đường' ) ) ); ?></p>
				</div>
				<div class="venue-legend rv">
					<div><span>01</span><h3><?php echo esc_html( aef_t( array( 'en' => 'Delegate arrival', 'vi' => 'Đại biểu đến sự kiện' ) ) ); ?></h3><p><?php echo esc_html( aef_t( array( 'en' => 'Drop-off → security → check-in → badge → approved session.', 'vi' => 'Điểm trả khách → an ninh → check-in → nhận thẻ → phiên được duyệt.' ) ) ); ?></p></div>
					<div><span>02</span><h3><?php echo esc_html( aef_t( array( 'en' => 'Media arrival', 'vi' => 'Báo chí đến tác nghiệp' ) ) ); ?></h3><p><?php echo esc_html( aef_t( array( 'en' => 'Dedicated entrance → accreditation → Media Centre → press areas.', 'vi' => 'Lối riêng → nhận thẻ tác nghiệp → Trung tâm Báo chí → khu vực tác nghiệp.' ) ) ); ?></p></div>
					<div><span>03</span><h3><?php echo esc_html( aef_t( array( 'en' => 'Accommodation', 'vi' => 'Lưu trú' ) ) ); ?></h3><p><?php echo esc_html( aef_t( array( 'en' => 'Approved hotel list, distance, travel time and shuttle route.', 'vi' => 'Danh sách khách sạn, khoảng cách, thời gian và tuyến shuttle đã xác nhận.' ) ) ); ?></p></div>
				</div>
			</div>
			<div class="floor-plan rv">
				<p class="map-disclosure" style="position:static;margin:0 0 14px"><?php echo esc_html( aef_t( array( 'en' => 'Illustrative floor plan — not for navigation', 'vi' => 'Sơ đồ tầng minh họa — không dùng để di chuyển' ) ) ); ?></p>
				<div class="floor-grid">
					<div class="floor-cell span2"><?php echo esc_html( aef_t( array( 'en' => 'Plenary hall', 'vi' => 'Hội trường toàn thể' ) ) ); ?></div>
					<div class="floor-cell"><?php echo esc_html( aef_t( array( 'en' => 'Room 01', 'vi' => 'Phòng 01' ) ) ); ?></div>
					<div class="floor-cell"><?php echo esc_html( aef_t( array( 'en' => 'Room 02', 'vi' => 'Phòng 02' ) ) ); ?></div>
					<div class="floor-cell"><?php echo esc_html( aef_t( array( 'en' => 'Room 03', 'vi' => 'Phòng 03' ) ) ); ?></div>
					<div class="floor-cell">Rising Star Arena</div>
					<div class="floor-cell"><?php echo esc_html( aef_t( array( 'en' => 'Delegate entrance', 'vi' => 'Lối Đại biểu' ) ) ); ?></div>
					<div class="floor-cell"><?php echo esc_html( aef_t( array( 'en' => 'Media entrance', 'vi' => 'Lối Báo chí' ) ) ); ?></div>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function aef_travel_kit() {
	$s = aef_settings();
	ob_start();
	?>
	<section class="blk mist travel-kit">
		<div class="shell">
			<div class="hd rv"><div>
				<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Plan the visit', 'vi' => 'Lên kế hoạch chuyến đi' ) ) ); ?></p>
				<h2><?php echo aef_lang() === 'vi' ? 'Địa điểm, lưu trú<br>và di chuyển' : 'Venue, stay<br>and arrival'; ?></h2>
			</div>
			<p class="lead"><?php echo esc_html( aef_t( array(
				'en' => 'The main forum is held at Thiskyhall, 10 Mai Chi Tho, Sala, An Khanh, Ho Chi Minh City. Hotel and transfer arrangements are issued by the Organising Committee.',
				'vi' => 'Diễn đàn chính được tổ chức tại Thiskyhall, số 10 Mai Chí Thọ, Sala, phường An Khánh, Thành phố Hồ Chí Minh. Phương án lưu trú và đưa đón do Ban Tổ chức thông báo.',
			) ) ); ?></p></div>
			<div class="travel-grid">
				<a class="travel-card rv" href="<?php echo esc_url( home_url( '/travel/#venue' ) ); ?>">
					<small>01</small>
					<h3><?php echo esc_html( aef_t( array( 'en' => 'Venue', 'vi' => 'Địa điểm' ) ) ); ?></h3>
					<p><?php echo esc_html( aef_t( array( 'vi' => $s['venue_vi'], 'en' => $s['venue_en'] ) ) ); ?></p>
					<span><?php echo esc_html( aef_t( array( 'en' => 'Access and floor plan', 'vi' => 'Lối vào và sơ đồ' ) ) ); ?> →</span>
				</a>
				<a class="travel-card rv" href="<?php echo esc_url( home_url( '/travel/#stay' ) ); ?>">
					<small>02</small>
					<h3><?php echo esc_html( aef_t( array( 'en' => 'Stay', 'vi' => 'Lưu trú' ) ) ); ?></h3>
					<p><?php echo esc_html( aef_t( array(
						'en' => 'A reference list of hotels near Thiskyhall. This page is not a booking service.',
						'vi' => 'Danh sách khách sạn tham khảo gần Thiskyhall. Trang này không phải dịch vụ đặt phòng.',
					) ) ); ?></p>
					<span><?php echo esc_html( aef_t( array( 'en' => 'Hotel list', 'vi' => 'Danh sách khách sạn' ) ) ); ?> →</span>
				</a>
				<a class="travel-card rv" href="<?php echo esc_url( home_url( '/travel/#move' ) ); ?>">
					<small>03</small>
					<h3><?php echo esc_html( aef_t( array( 'en' => 'Move', 'vi' => 'Di chuyển' ) ) ); ?></h3>
					<p><?php echo esc_html( aef_t( array(
						'en' => 'Airport arrival, shuttle services and on-site access follow the Organising Committee’s guidance for delegates.',
						'vi' => 'Việc đến sân bay, xe trung chuyển và lối vào sự kiện thực hiện theo hướng dẫn của Ban Tổ chức dành cho đại biểu.',
					) ) ); ?></p>
					<span><?php echo esc_html( aef_t( array( 'en' => 'Transport notes', 'vi' => 'Hướng dẫn di chuyển' ) ) ); ?> →</span>
				</a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function aef_nav_link_html( $url, $label, $note = '' ) {
	$html  = '<a href="' . esc_url( $url ) . '"><strong>' . esc_html( $label ) . '</strong>';
	if ( $note ) {
		$html .= '<small>' . esc_html( $note ) . '</small>';
	}
	$html .= '</a>';
	return $html;
}

function aef_primary_nav() {
	$prog = home_url( '/programme/' );
	$about = home_url( '/about/' );
	echo '<div class="nav-item has-drop">';
	echo '<a class="nav-link" href="' . esc_url( $about ) . '">' . esc_html( aef_t( array( 'en' => 'About', 'vi' => 'Giới thiệu' ) ) ) . '</a>';
	echo '<div class="nav-drop">';
	echo aef_nav_link_html( $about, aef_t( array( 'en' => 'About the Forum', 'vi' => 'Về Diễn đàn' ) ), aef_t( array( 'en' => 'Positioning, theme and hosts', 'vi' => 'Định vị, chủ đề và đơn vị tổ chức' ) ) );
	echo aef_nav_link_html( $about . '#oc', aef_t( array( 'en' => 'Organising Committee', 'vi' => 'Ban Tổ chức' ) ), aef_t( array( 'en' => 'Structure by position', 'vi' => 'Cơ cấu theo chức danh' ) ) );
	echo aef_nav_link_html( home_url( '/topics/' ), aef_t( array( 'en' => 'Four pillars', 'vi' => 'Bốn trụ cột' ) ), aef_t( array( 'en' => 'The thinking frame of 2026', 'vi' => 'Khung tư duy năm 2026' ) ) );
	echo '</div></div>';

	echo '<div class="nav-item has-drop">';
	echo '<a class="nav-link" href="' . esc_url( $prog ) . '">' . esc_html( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ) ) . '</a>';
	echo '<div class="nav-drop">';
	echo aef_nav_link_html( $prog, aef_t( array( 'en' => 'Full programme', 'vi' => 'Toàn bộ chương trình' ) ), aef_t( array( 'en' => '26–29 October, by time', 'vi' => '26–29/10, theo thời gian' ) ) );
	echo aef_nav_link_html( $prog . '?view=main', aef_t( array( 'en' => 'Main Forum 27–28 Oct', 'vi' => 'Diễn đàn chính 27–28/10' ) ), aef_t( array( 'en' => 'Thematic day and high-level day', 'vi' => 'Ngày chuyên đề và ngày cấp cao' ) ) );
	echo aef_nav_link_html( $prog . '?view=thematic', aef_t( array( 'en' => 'Thematic sessions', 'vi' => 'Phiên chuyên đề' ) ), aef_t( array( 'en' => '15 sessions in 3 rooms, 27 Oct', 'vi' => '15 phiên tại 3 phòng, 27/10' ) ) );
	echo aef_nav_link_html( $prog . '?view=arena', 'Rising Star Arena', aef_t( array( 'en' => 'Technology showcase, 27 Oct', 'vi' => 'Trình diễn công nghệ, 27/10' ) ) );
	echo aef_nav_link_html( $prog . '?view=side', aef_t( array( 'en' => 'Side events', 'vi' => 'Bên lề' ) ), aef_t( array( 'en' => '26–29 Oct around the Forum', 'vi' => '26–29/10 quanh diễn đàn chính' ) ) );
	echo aef_nav_link_html( home_url( '/delegates/how-to-register/' ), aef_t( array( 'en' => 'How to attend', 'vi' => 'Cách tham dự' ) ), aef_t( array( 'en' => 'By invitation, not a form on aef.vn', 'vi' => 'Theo thư mời, không form trên aef.vn' ) ) );
	echo '</div></div>';

	echo '<div class="nav-item"><a class="nav-link" href="' . esc_url( home_url( '/speakers/' ) ) . '">' . esc_html( aef_t( array( 'en' => 'Speakers', 'vi' => 'Diễn giả' ) ) ) . '</a></div>';
	echo '<div class="nav-item"><a class="nav-link" href="' . esc_url( home_url( '/2026/partners/' ) ) . '">' . esc_html( aef_t( array( 'en' => 'Partners', 'vi' => 'Đối tác' ) ) ) . '</a></div>';
	echo '<div class="nav-item"><a class="nav-link" href="' . esc_url( home_url( '/2026/media/' ) ) . '">' . esc_html( aef_t( array( 'en' => 'Media', 'vi' => 'Truyền thông' ) ) ) . '</a></div>';
}

function aef_mega_link( $path, $title, $desc ) {
	echo '<a class="mega-link" href="' . esc_url( home_url( $path ) ) . '"><strong>' . esc_html( aef_t( $title ) ) . '</strong><span>' . esc_html( aef_t( $desc ) ) . '</span></a>';
}

function aef_mega_bar() {
	$s = aef_settings();
	?>
	<div class="mega" id="aef-mega" hidden>
	  <div class="mega-track">
	    <section class="mega-panel" data-panel="about">
	      <div class="shell mega-grid">
	        <div class="mega-intro">
	          <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'The Forum', 'vi' => 'Diễn đàn' ) ) ); ?></p>
	          <h3><?php echo esc_html( aef_t( array( 'en' => 'History, role and editions', 'vi' => 'Lịch sử, vai trò và các kỳ' ) ) ); ?></h3>
	          <p><?php echo esc_html( aef_t( array( 'en' => 'From the Ho Chi Minh City Economic Forum in 2018 to AEF today.', 'vi' => 'Từ Diễn đàn Kinh tế TP.HCM năm 2018 đến AEF hiện nay.' ) ) ); ?></p>
	        </div>
	        <div class="mega-cols">
	          <?php
				aef_mega_link( '/about/', array( 'en' => 'About the Forum', 'vi' => 'Về Diễn đàn' ), array( 'en' => 'Purpose, organisation and the three annual pillars.', 'vi' => 'Mục đích, mô hình tổ chức và ba trụ cột thường niên.' ) );
				aef_mega_link( '/editions/', array( 'en' => 'Past editions', 'vi' => 'Các kỳ đã diễn ra' ), array( 'en' => 'Archives from 2018 to 2025, each with its own address.', 'vi' => 'Tư liệu 2018–2025, mỗi kỳ một địa chỉ riêng.' ) );
				aef_mega_link( '/editions/2025/', array( 'en' => 'AEF 2025', 'vi' => 'AEF 2025' ), array( 'en' => 'The most recent edition in figures and imagery.', 'vi' => 'Kỳ gần nhất qua số liệu và hình ảnh.' ) );
	          ?>
	        </div>
	      </div>
	    </section>
	    <section class="mega-panel" data-panel="topics">
	      <div class="shell mega-grid">
	        <div class="mega-intro">
	          <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Thinking frame', 'vi' => 'Khung tư duy' ) ) ); ?></p>
	          <h3><?php echo esc_html( aef_t( array( 'en' => 'Four content pillars', 'vi' => 'Bốn trụ cột nội dung' ) ) ); ?></h3>
	          <p><?php echo esc_html( aef_t( array( 'en' => 'These four questions run through the week. They are not four separate sessions.', 'vi' => 'Bốn câu hỏi này xuyên suốt tuần lễ. Chúng không phải bốn phiên riêng.' ) ) ); ?></p>
	        </div>
	        <div class="mega-cols">
	          <?php
				foreach ( aef_pillars() as $pillar ) {
					aef_mega_link( '/topics/#pillar-' . $pillar['slug'], $pillar['title'], $pillar['kicker'] );
				}
	          ?>
	        </div>
	      </div>
	    </section>
	    <section class="mega-panel" data-panel="programme">
	      <div class="shell mega-grid">
	        <div class="mega-intro">
	          <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Theme', 'vi' => 'Chủ đề' ) ) ); ?></p>
	          <h3><?php echo esc_html( aef_t( array( 'vi' => $s['theme_vi'], 'en' => $s['theme_en'] ) ) ); ?></h3>
	          <p><?php echo esc_html( aef_t( array( 'en' => 'Four programme layers across Forum week.', 'vi' => 'Bốn lớp chương trình trong tuần Diễn đàn.' ) ) ); ?></p>
	        </div>
	        <div class="mega-cols">
	          <?php
				aef_mega_link( '/programme/', array( 'en' => 'Full schedule', 'vi' => 'Lịch đầy đủ' ), array( 'en' => 'Times, rooms and access by day.', 'vi' => 'Giờ, phòng và quyền tiếp cận theo ngày.' ) );
				aef_mega_link( '/topics/', array( 'en' => 'Four content pillars', 'vi' => 'Bốn trụ cột nội dung' ), array( 'en' => 'The thinking frame that runs through the week.', 'vi' => 'Khung tư duy xuyên suốt tuần lễ.' ) );
				aef_mega_link( '/sessions/high-level-plenary/', array( 'en' => 'High-level plenary', 'vi' => 'Phiên toàn thể cấp cao' ), array( 'en' => 'The central session of the Forum.', 'vi' => 'Phiên trung tâm của Diễn đàn.' ) );
	          ?>
	        </div>
	      </div>
	    </section>
	    <section class="mega-panel" data-panel="speakers">
	      <div class="shell mega-grid">
	        <div class="mega-intro">
	          <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'People', 'vi' => 'Người tham gia' ) ) ); ?></p>
	          <h3><?php echo esc_html( aef_t( array( 'en' => 'Speakers', 'vi' => 'Diễn giả' ) ) ); ?></h3>
	          <p><?php echo esc_html( aef_t( array( 'en' => 'Government, international organisations, business, research and innovation at AEF 2026.', 'vi' => 'Khu vực nhà nước, tổ chức quốc tế, doanh nghiệp, nghiên cứu và đổi mới sáng tạo tại AEF 2026.' ) ) ); ?></p>
	        </div>
	        <div class="mega-cols">
	          <?php
				aef_mega_link( '/speakers/', array( 'en' => 'All speakers', 'vi' => 'Toàn bộ diễn giả' ), array( 'en' => 'Directory by role — government, international, business, research.', 'vi' => 'Danh mục theo nhóm — chính phủ, quốc tế, doanh nghiệp, nghiên cứu.' ) );
	          ?>
	        </div>
	      </div>
	    </section>
	    <section class="mega-panel" data-panel="media">
	      <div class="shell mega-grid">
	        <div class="mega-intro">
	          <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Follow', 'vi' => 'Theo dõi' ) ) ); ?></p>
	          <h3><?php echo esc_html( aef_t( array( 'en' => 'Public media', 'vi' => 'Truyền thông công khai' ) ) ); ?></h3>
	          <p><?php echo esc_html( aef_t( array( 'en' => 'News, statements, photography and replay. Accreditation sits in Support.', 'vi' => 'Tin, thông cáo, ảnh và xem lại. Tác nghiệp nằm ở Hỗ trợ.' ) ) ); ?></p>
	        </div>
	        <div class="mega-cols">
	          <?php
				aef_mega_link( '/2026/media/', array( 'en' => 'News & releases', 'vi' => 'Tin và thông cáo' ), array( 'en' => 'Official public updates.', 'vi' => 'Cập nhật công khai chính thức.' ) );
				aef_mega_link( '/2026/support/media/', array( 'en' => 'Working as press', 'vi' => 'Tác nghiệp báo chí' ), array( 'en' => 'Accreditation, interviews, press rooms.', 'vi' => 'Đăng ký tác nghiệp, phỏng vấn, trung tâm báo chí.' ) );
	          ?>
	        </div>
	      </div>
	    </section>
	    <section class="mega-panel" data-panel="support">
	      <div class="shell mega-grid">
	        <div class="mega-intro">
	          <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Attend', 'vi' => 'Tham dự' ) ) ); ?></p>
	          <h3><?php echo esc_html( aef_t( array( 'en' => 'Two routes, one centre', 'vi' => 'Hai lộ trình, một trung tâm' ) ) ); ?></h3>
	          <p><?php echo esc_html( aef_t( array( 'en' => 'Delegates and media have separate arrival sequences, including plans and maps.', 'vi' => 'Đại biểu và báo chí có luồng riêng, gồm sơ đồ và bản đồ.' ) ) ); ?></p>
	        </div>
	        <div class="mega-cols">
	          <?php
				aef_mega_link( '/2026/delegates/', array( 'en' => 'Delegates', 'vi' => 'Đại biểu' ), array( 'en' => 'Eligibility, registration, visa, badge.', 'vi' => 'Điều kiện, đăng ký, thị thực, thẻ.' ) );
				aef_mega_link( '/2026/support/media/', array( 'en' => 'Media operations', 'vi' => 'Nghiệp vụ báo chí' ), array( 'en' => 'How journalists work on site.', 'vi' => 'Cách phóng viên tác nghiệp tại chỗ.' ) );
				aef_mega_link( '/travel/', array( 'en' => 'Travel kit', 'vi' => 'Cẩm nang đi lại' ), array( 'en' => 'Venue, stay, airport and the city.', 'vi' => 'Địa điểm, lưu trú, sân bay và thành phố.' ) );
				aef_mega_link( aef_settings()['register_path'], array( 'en' => 'How to register', 'vi' => 'Cách đăng ký' ), array( 'en' => 'Information page, then the separate portal.', 'vi' => 'Trang hướng dẫn, rồi cổng riêng.' ) );
	          ?>
	        </div>
	      </div>
	    </section>
	  </div>
	</div>
	<?php
}
