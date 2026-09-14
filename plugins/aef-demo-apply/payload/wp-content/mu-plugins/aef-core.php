<?php
/**
 * Plugin Name: AEF 2026 Core
 * Description: CPT, cài đặt kỳ, rewrite và ranh giới aef.vn / invite. Không chứa form đăng ký.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'aef_register_types' );
function aef_register_types() {
	register_post_type( 'aef_session', array(
		'labels'       => array( 'name' => 'Phiên', 'singular_name' => 'Phiên' ),
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-schedule',
		'supports'     => array( 'title', 'editor', 'excerpt', 'custom-fields' ),
		'rewrite'      => array( 'slug' => '2026/sessions' ),
		'has_archive'  => '2026/programme',
	) );

	register_taxonomy( 'aef_day', 'aef_session', array(
		'labels'       => array( 'name' => 'Lớp chương trình' ),
		'public'       => true,
		'hierarchical' => true,
		'rewrite'      => array( 'slug' => '2026/programme/day' ),
	) );

	register_post_type( 'aef_speaker', array(
		'labels'       => array( 'name' => 'Diễn giả', 'singular_name' => 'Diễn giả' ),
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-groups',
		'supports'     => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'rewrite'      => array( 'slug' => '2026/speakers' ),
		'has_archive'  => '2026/speakers',
	) );

	register_taxonomy( 'aef_speaker_cat', 'aef_speaker', array(
		'labels'       => array( 'name' => 'Nhóm diễn giả' ),
		'public'       => true,
		'hierarchical' => true,
	) );

	register_post_type( 'aef_story', array(
		'labels'       => array( 'name' => 'Tin / Thông cáo' ),
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-megaphone',
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'rewrite'      => array( 'slug' => '2026/media' ),
		'has_archive'  => '2026/media',
	) );

	register_post_type( 'aef_support', array(
		'labels'       => array( 'name' => 'Bài hỗ trợ' ),
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-sos',
		'supports'     => array( 'title', 'editor', 'excerpt', 'custom-fields' ),
		'rewrite'      => array( 'slug' => '2026/support/item' ),
	) );

	register_taxonomy( 'aef_audience', 'aef_support', array(
		'labels'       => array( 'name' => 'Đối tượng' ),
		'public'       => true,
		'hierarchical' => true,
	) );

	register_post_type( 'aef_edition', array(
		'labels'       => array( 'name' => 'Các kỳ' ),
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-backup',
		'supports'     => array( 'title', 'editor', 'custom-fields' ),
		'rewrite'      => array( 'slug' => 'editions' ),
		'has_archive'  => 'editions',
	) );

	add_rewrite_rule( '^2026/?$', 'index.php?pagename=home-2026', 'top' );
	add_rewrite_rule( '^2026/support/media/?$', 'index.php?pagename=media-support', 'top' );
	add_rewrite_rule( '^2026/support/?$', 'index.php?pagename=support', 'top' );
	add_rewrite_rule( '^2026/delegates/([^/]+)/?$', 'index.php?pagename=delegates/$matches[1]', 'top' );
	add_rewrite_rule( '^2026/delegates/?$', 'index.php?pagename=delegates', 'top' );
	add_rewrite_rule( '^2026/partners/?$', 'index.php?pagename=partners', 'top' );
	add_rewrite_rule( '^2026/travel/?$', 'index.php?pagename=travel', 'top' );
	add_rewrite_rule( '^topics/?$', 'index.php?pagename=topics', 'top' );
	add_rewrite_rule( '^about/?$', 'index.php?pagename=about', 'top' );
}

add_filter( 'pre_option_show_on_front', function () {
	return 'page';
} );

add_action( 'after_setup_theme', 'aef_theme_supports' );
function aef_theme_supports() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menus( array(
		'primary' => 'Menu chính',
		'footer_forum' => 'Footer — Diễn đàn',
		'footer_support' => 'Footer — Hỗ trợ',
		'footer_follow' => 'Footer — Theo dõi',
	) );
}

add_action( 'admin_menu', 'aef_settings_menu' );
function aef_settings_menu() {
	add_options_page( 'AEF 2026', 'AEF 2026', 'manage_options', 'aef-2026', 'aef_settings_page' );
}

function aef_default_settings() {
	return array(
		'year'           => '2026',
		'default_lang'   => 'en',
		'official_name_vi' => 'Diễn đàn Kinh tế Mùa thu năm 2026 - Sự hội tụ của các cực tăng trưởng toàn cầu',
		'official_name_en' => 'The Autumn Economic Forum 2026 - The Convergence of Global Growth Poles',
		'theme_vi'       => 'Tinh thần hợp tác trong kỷ nguyên mới',
		'theme_en'       => 'Collaboration in a New Era',
		'theme_lead_vi'  => 'Bốn trụ cột là khung tư duy xuyên suốt, được lồng ghép vào nội dung và cách đặt vấn đề của các phiên — không phải bốn phiên độc lập.',
		'theme_lead_en'  => 'The four pillars are a thinking frame that runs through the sessions. They are not four separate sessions.',
		'axis_1_en'      => 'The role of megacities',
		'axis_1_vi'      => 'Vai trò của các siêu đô thị',
		'axis_2_en'      => 'Frontier technology and the innovation ecosystem',
		'axis_2_vi'      => 'Công nghệ đột phá và hệ sinh thái đổi mới sáng tạo',
		'axis_3_en'      => 'Cooperation models in a new era',
		'axis_3_vi'      => 'Các mô hình hợp tác trong kỷ nguyên mới',
		'axis_4_en'      => 'The pioneering role of the private sector',
		'axis_4_vi'      => 'Vai trò tiên phong của khu vực tư nhân',
		'week_dates'     => '25–30.10.2026',
		'main_dates'     => '27–28.10',
		'city_vi'        => 'TP. Hồ Chí Minh',
		'city_en'        => 'Ho Chi Minh City',
		'venue_vi'       => 'Thiskyhall, 10 Mai Chí Thọ, Sala, phường An Khánh',
		'venue_en'       => 'Thiskyhall, 10 Mai Chi Tho, Sala, An Khanh',
		'invite_url'     => '',
		'register_path'  => '/2026/delegates/how-to-register/',
		'programme_status' => 'draft',
		'programme_updated' => '13/08/2026',
		'host_1_name_vi' => 'Chính phủ Việt Nam',
		'host_1_role_vi' => 'Cơ quan chỉ đạo',
		'host_1_name_en' => 'Government of Viet Nam',
		'host_1_role_en' => 'Directing authority',
		'host_2_name_vi' => 'UBND Thành phố Hồ Chí Minh',
		'host_2_role_vi' => 'Đơn vị chủ trì',
		'host_2_name_en' => "People's Committee of Ho Chi Minh City",
		'host_2_role_en' => 'Convening authority',
		'host_3_name_vi' => 'HCMC C4IR · WEF',
		'host_3_role_vi' => 'Đơn vị thực hiện · phối hợp WEF',
		'host_3_name_en' => 'HCMC C4IR · WEF',
		'host_3_role_en' => 'Implementing centre · cooperating with WEF',
	);
}

function aef_settings() {
	$saved = get_option( 'aef_settings', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	return array_merge( aef_default_settings(), $saved );
}

function aef_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_POST['aef_save'] ) && check_admin_referer( 'aef_settings' ) ) {
		$keys = array_keys( aef_default_settings() );
		$out  = array();
		foreach ( $keys as $key ) {
			$out[ $key ] = isset( $_POST[ $key ] ) ? wp_kses_post( wp_unslash( $_POST[ $key ] ) ) : '';
		}
		update_option( 'aef_settings', $out );
		echo '<div class="updated"><p>Đã lưu.</p></div>';
	}
	$s = aef_settings();
	echo '<div class="wrap"><h1>AEF 2026 — Cài đặt kỳ</h1>';
	echo '<p>Đổi ngày, chủ đề, nhãn host tại đây. Không hard-code trong theme.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'aef_settings' );
	$fields = array(
		'default_lang' => 'Ngôn ngữ mặc định (en|vi)',
		'official_name_en' => 'Full official name — EN',
		'official_name_vi' => 'Tên đầy đủ — VI',
		'theme_en' => 'Theme — English (official wording)',
		'theme_vi' => 'Chủ đề — tiếng Việt (nguyên văn)',
		'theme_lead_en' => 'Theme lead — EN',
		'theme_lead_vi' => 'Đoạn dẫn chủ đề — VI',
		'axis_1_en' => 'Axis 01 — EN',
		'axis_1_vi' => 'Trục 01 — VI',
		'axis_2_en' => 'Axis 02 — EN',
		'axis_2_vi' => 'Trục 02 — VI',
		'axis_3_en' => 'Axis 03 — EN',
		'axis_3_vi' => 'Trục 03 — VI',
		'axis_4_en' => 'Axis 04 — EN',
		'axis_4_vi' => 'Trục 04 — VI',
		'week_dates' => 'Forum week',
		'main_dates' => 'Main forum dates',
		'venue_en' => 'Venue — EN',
		'venue_vi' => 'Địa điểm — VI',
		'invite_url' => 'invite.aef.vn URL (empty = not linked)',
		'register_path' => 'How-to-register path',
		'programme_status' => 'Programme status (draft|approved)',
		'programme_updated' => 'Programme updated on',
		'host_1_name_en' => 'Host 1 — name EN',
		'host_1_role_en' => 'Host 1 — role EN',
		'host_1_name_vi' => 'Host 1 — tên VI',
		'host_1_role_vi' => 'Host 1 — vai trò VI',
		'host_2_name_en' => 'Host 2 — name EN',
		'host_2_role_en' => 'Host 2 — role EN',
		'host_2_name_vi' => 'Host 2 — tên VI',
		'host_2_role_vi' => 'Host 2 — vai trò VI',
		'host_3_name_en' => 'Host 3 — name EN',
		'host_3_role_en' => 'Host 3 — role EN',
		'host_3_name_vi' => 'Host 3 — tên VI',
		'host_3_role_vi' => 'Host 3 — vai trò VI',
	);
	foreach ( $fields as $key => $label ) {
		echo '<p><label><strong>' . esc_html( $label ) . '</strong><br>';
		if ( strpos( $key, 'lead' ) !== false ) {
			echo '<textarea name="' . esc_attr( $key ) . '" class="large-text" rows="3">' . esc_textarea( $s[ $key ] ) . '</textarea></label></p>';
		} else {
			echo '<input type="text" name="' . esc_attr( $key ) . '" value="' . esc_attr( $s[ $key ] ) . '" class="large-text"></label></p>';
		}
	}
	submit_button( 'Lưu', 'primary', 'aef_save' );
	echo '</form></div>';
}

function aef_default_copy() {
	return array(
		'block_hero'     => '1',
		'block_theme'    => '1',
		'block_hosts'    => '1',
		'block_week'     => '0',
		'block_journey'  => '1',
		'block_featured' => '1',
		'block_outcomes' => '1',
		'block_audience' => '1',
		'block_edition'  => '1',
		'block_speakers' => '1',
		'block_partners' => '1',
		'block_support'  => '1',
		'home_week_eyebrow_en' => 'Forum week',
		'home_week_eyebrow_vi' => 'Tuần Diễn đàn',
		'home_week_title_en'   => 'Four programme layers',
		'home_week_title_vi'   => 'Bốn lớp chương trình',
		'home_week_lead_en'    => 'The homepage shows the week’s structure. Times, rooms and access sit on the Programme page.',
		'home_week_lead_vi'    => 'Trang chủ chỉ hiện cấu trúc tuần lễ. Giờ, phòng và quyền tiếp cận nằm ở trang Chương trình.',
		'home_week_cta_en'     => 'Full programme',
		'home_week_cta_vi'     => 'Chương trình đầy đủ',
		'home_edition_eyebrow_en' => 'The 2025 edition',
		'home_edition_eyebrow_vi' => 'Kỳ năm 2025',
		'home_edition_title_en'   => 'The most recent Forum, in figures',
		'home_edition_title_vi'   => 'Kỳ gần nhất, qua một số liệu',
		'home_edition_lead_en'    => 'Figures retained from Organising Committee materials, pending a single official source before publication.',
		'home_edition_lead_vi'    => 'Số liệu giữ theo tư liệu Ban Tổ chức, chờ thống nhất một nguồn trước khi công bố.',
		'home_stat_1_n' => '1,800+',
		'home_stat_1_en' => 'delegates at the most recent edition',
		'home_stat_1_vi' => 'đại biểu tại kỳ gần nhất',
		'home_stat_2_n' => '~100',
		'home_stat_2_en' => 'international delegations',
		'home_stat_2_vi' => 'đoàn khách quốc tế',
		'home_stat_3_n' => '16',
		'home_stat_3_en' => 'memoranda of understanding announced',
		'home_stat_3_vi' => 'bản ghi nhớ hợp tác được công bố',
		'home_stat_4_n' => '15',
		'home_stat_4_en' => 'specialised events',
		'home_stat_4_vi' => 'sự kiện chuyên môn',
		'home_speakers_eyebrow_en' => 'Speakers',
		'home_speakers_eyebrow_vi' => 'Diễn giả',
		'home_speakers_title_en'   => 'People who will shape the dialogue',
		'home_speakers_title_vi'   => 'Những người sẽ định hình đối thoại',
		'home_speakers_lead_en'    => 'Cards below are visual placeholders. Names and portraits are published only after written confirmation — replace each card in wp-admin.',
		'home_speakers_lead_vi'    => 'Các thẻ dưới đây là mô hình trình bày. Tên và ảnh chỉ công bố sau xác nhận bằng văn bản — thay từng thẻ trong wp-admin.',
		'home_support_eyebrow_en' => 'Support Centre',
		'home_support_eyebrow_vi' => 'Trung tâm Hỗ trợ',
		'home_support_title_en'   => 'Two routes, one centre',
		'home_support_title_vi'   => 'Hai lộ trình, một trung tâm',
		'home_support_lead_en'    => 'Practical information for delegates and for journalists is kept separate, including venue plans and arrival sequences.',
		'home_support_lead_vi'    => 'Thông tin thực hành dành cho đại biểu và cho phóng viên được tách riêng, gồm sơ đồ địa điểm và luồng di chuyển.',
		'home_hero_cta1_en' => 'Explore the programme',
		'home_hero_cta1_vi' => 'Khám phá chương trình',
		'home_hero_cta2_en' => 'About AEF 2026',
		'home_hero_cta2_vi' => 'Tìm hiểu về AEF 2026',
		'home_meta_week_en' => 'Forum week',
		'home_meta_week_vi' => 'Tuần Diễn đàn',
		'home_meta_main_en' => 'Main forum',
		'home_meta_main_vi' => 'Diễn đàn chính',
		'home_meta_city_en' => 'Host city',
		'home_meta_city_vi' => 'Thành phố chủ nhà',
	);
}

function aef_copy_all() {
	$saved = get_option( 'aef_copy', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	return array_merge( aef_default_copy(), $saved );
}

function aef_copy( $key ) {
	$all  = aef_copy_all();
	$lang = function_exists( 'aef_lang' ) ? aef_lang() : 'en';
	$try  = $key . '_' . $lang;
	if ( isset( $all[ $try ] ) && $all[ $try ] !== '' ) {
		return $all[ $try ];
	}
	$fallback = $key . '_' . ( 'vi' === $lang ? 'en' : 'vi' );
	if ( isset( $all[ $fallback ] ) && $all[ $fallback ] !== '' ) {
		return $all[ $fallback ];
	}
	return isset( $all[ $key ] ) ? $all[ $key ] : '';
}

function aef_block_on( $id ) {
	$all = aef_copy_all();
	$key = 'block_' . $id;
	return ! isset( $all[ $key ] ) || '0' !== (string) $all[ $key ];
}

add_filter( 'wp_sitemaps_enabled', '__return_true' );
add_filter( 'users_can_register', '__return_false' );
add_filter( 'xmlrpc_enabled', '__return_false' );

add_action( 'template_redirect', 'aef_handle_lang' );
function aef_handle_lang() {
	if ( isset( $_GET['lang'] ) && in_array( $_GET['lang'], array( 'vi', 'en' ), true ) ) {
		setcookie( 'aef_lang', $_GET['lang'], time() + YEAR_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), true );
	}
}
