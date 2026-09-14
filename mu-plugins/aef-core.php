<?php
/**
 * Plugin Name: AEF 2026 Core
 * Description: CPT, cài đặt kỳ, rewrite và ranh giới aef.vn / invite. Không chứa form đăng ký.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'DISALLOW_FILE_MODS' ) && defined( 'AEF_DB_ENGINE' ) && 'mysql' === AEF_DB_ENGINE ) {
	define( 'DISALLOW_FILE_MODS', true );
}

add_action( 'init', 'aef_register_types' );
function aef_register_types() {
	register_post_type( 'aef_session', array(
		'labels'       => array( 'name' => 'Phiên', 'singular_name' => 'Phiên' ),
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-schedule',
		'supports'     => array( 'title', 'editor', 'excerpt', 'custom-fields' ),
		'rewrite'      => array( 'slug' => 'sessions' ),
		'has_archive'  => 'programme',
	) );

	register_taxonomy( 'aef_day', 'aef_session', array(
		'labels'       => array( 'name' => 'Lớp chương trình' ),
		'public'       => true,
		'hierarchical' => true,
		'rewrite'      => array( 'slug' => 'programme/day' ),
	) );

	register_post_type( 'aef_speaker', array(
		'labels'       => array( 'name' => 'Diễn giả', 'singular_name' => 'Diễn giả' ),
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-groups',
		'supports'     => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'rewrite'      => array( 'slug' => 'speakers' ),
		'has_archive'  => 'speakers',
	) );

	register_taxonomy( 'aef_speaker_cat', 'aef_speaker', array(
		'labels'       => array( 'name' => 'Nhóm diễn giả' ),
		'public'       => true,
		'hierarchical' => true,
	) );

	register_post_type( 'aef_story', array(
		'labels'       => array(
			'name'          => 'Tin / Thông cáo',
			'singular_name' => 'Bài',
			'add_new_item'  => 'Thêm tin / thông cáo',
		),
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-megaphone',
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'rewrite'      => array( 'slug' => '2026/media' ),
		'has_archive'  => '2026/media',
	) );

	register_post_type( 'aef_partner', array(
		'labels'       => array(
			'name'          => 'Đối tác',
			'singular_name' => 'Đối tác',
			'add_new_item'  => 'Thêm đối tác',
		),
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-groups',
		'supports'     => array( 'title', 'thumbnail', 'page-attributes', 'custom-fields' ),
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
	add_rewrite_rule( '^travel/?$', 'index.php?pagename=travel', 'top' );
	add_rewrite_rule( '^topics/?$', 'index.php?pagename=topics', 'top' );
	add_rewrite_rule( '^about/?$', 'index.php?pagename=about', 'top' );
	add_rewrite_rule( '^programme/?$', 'index.php?post_type=aef_session', 'top' );
	add_rewrite_rule( '^programme/page/([0-9]+)/?$', 'index.php?post_type=aef_session&paged=$matches[1]', 'top' );
	add_rewrite_rule( '^speakers/?$', 'index.php?post_type=aef_speaker', 'top' );
	add_rewrite_rule( '^speakers/page/([0-9]+)/?$', 'index.php?post_type=aef_speaker&paged=$matches[1]', 'top' );
	add_rewrite_rule( '^coming-soon/?$', 'index.php?aef_coming=1', 'top' );
}

add_action( 'template_redirect', 'aef_short_url_redirects', 1 );
function aef_short_url_redirects() {
	if ( is_admin() ) {
		return;
	}
	$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : '';
	if ( ! is_string( $path ) || '' === $path ) {
		return;
	}
	$home = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	if ( is_string( $home ) && '/' !== $home && 0 === strpos( $path, untrailingslashit( $home ) ) ) {
		$path = substr( $path, strlen( untrailingslashit( $home ) ) );
		if ( '' === $path ) {
			$path = '/';
		}
	}
	$path = untrailingslashit( $path );
	$map  = array(
		'/2026/programme' => '/programme/',
		'/2026/speakers'  => '/speakers/',
		'/2026/travel'    => '/travel/',
	);
	$dest = '';
	if ( isset( $map[ $path ] ) ) {
		$dest = $map[ $path ];
	} elseif ( preg_match( '#^/2026/sessions/(.+)$#', $path, $m ) ) {
		$dest = '/sessions/' . trim( $m[1], '/' ) . '/';
	} elseif ( preg_match( '#^/2026/speakers/(.+)$#', $path, $m ) ) {
		$dest = '/speakers/' . trim( $m[1], '/' ) . '/';
	}
	if ( ! $dest ) {
		return;
	}
	$qs = isset( $_SERVER['QUERY_STRING'] ) && '' !== $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
	wp_safe_redirect( home_url( $dest ) . $qs, 301 );
	exit;
}

add_action( 'init', 'aef_short_urls_migrate', 99 );
function aef_short_urls_migrate() {
	if ( '1' === (string) get_option( 'aef_short_urls_v1' ) ) {
		return;
	}
	$repl = array(
		'/2026/programme/' => '/programme/',
		'/2026/speakers/'  => '/speakers/',
		'/2026/sessions/'  => '/sessions/',
	);
	foreach ( array( 'aef_chrome', 'aef_topics', 'aef_inner', 'aef_copy' ) as $opt ) {
		$val = get_option( $opt );
		if ( ! $val ) {
			continue;
		}
		$json = wp_json_encode( $val );
		if ( ! is_string( $json ) ) {
			continue;
		}
		$new = strtr( $json, $repl );
		if ( $new !== $json ) {
			$decoded = json_decode( $new, true );
			if ( is_array( $decoded ) ) {
				update_option( $opt, $decoded );
			}
		}
	}
	$items = get_posts(
		array(
			'post_type'      => 'nav_menu_item',
			'posts_per_page' => 200,
			'post_status'    => 'any',
		)
	);
	foreach ( $items as $item ) {
		$url = get_post_meta( $item->ID, '_menu_item_url', true );
		if ( ! $url ) {
			continue;
		}
		$new = strtr( $url, $repl );
		if ( $new !== $url ) {
			update_post_meta( $item->ID, '_menu_item_url', $new );
		}
	}
	flush_rewrite_rules( false );
	update_option( 'aef_short_urls_v1', '1' );
}

add_filter( 'pre_option_show_on_front', function () {
	return 'page';
} );

add_action( 'after_setup_theme', 'aef_theme_supports' );
function aef_theme_supports() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menus( array(
		'primary'        => 'Header — Menu chính (EN/VI)',
		'footer_forum'   => 'Footer — AEF 2026',
		'footer_support' => 'Footer — Attend',
		'footer_follow'  => 'Footer — Institutional',
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
		'official_name_vi' => 'Diễn đàn Kinh tế Mùa thu năm 2026 - Sự hội tụ của các cực tăng trưởng mới toàn cầu',
		'official_name_en' => 'The Autumn Economic Forum 2026 - The Convergence Of New Global Growth Engines',
		'positioning_vi' => 'Sự hội tụ của các cực tăng trưởng mới toàn cầu',
		'positioning_en' => 'The Convergence Of New Global Growth Engines',
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
		'week_dates'     => '26–29.10.2026',
		'main_dates'     => '27–28.10',
		'city_vi'        => 'TP. Hồ Chí Minh',
		'city_en'        => 'Ho Chi Minh City',
		'venue_vi'       => 'Thiskyhall, 10 Mai Chí Thọ, Sala, phường An Khánh',
		'venue_en'       => 'Thiskyhall, 10 Mai Chi Tho, Sala, An Khanh',
		'invite_url'     => '',
		'register_path'  => '/2026/delegates/how-to-register/',
		'programme_status' => 'live',
		'programme_updated' => '25/08/2026',
		'host_1_name_vi' => 'Chính phủ Việt Nam',
		'host_1_role_vi' => 'Cơ quan chỉ đạo',
		'host_1_name_en' => 'Government of Viet Nam',
		'host_1_role_en' => 'Directing authority',
		'host_2_name_vi' => 'UBND Thành phố Hồ Chí Minh',
		'host_2_role_vi' => 'Đơn vị chủ trì',
		'host_2_name_en' => "People's Committee of Ho Chi Minh City",
		'host_2_role_en' => 'Convening authority',
		'host_3_name_vi' => 'HCMC C4IR',
		'host_3_role_vi' => 'Đơn vị thực hiện',
		'host_3_name_en' => 'HCMC C4IR',
		'host_3_role_en' => 'Implementing centre',
	);
}

function aef_marks_wef( $text ) {
	$t = mb_strtolower( trim( (string) $text ) );
	if ( '' === $t ) {
		return false;
	}
	if ( false !== strpos( $t, 'world economic forum' ) || false !== strpos( $t, 'diễn đàn kinh tế thế giới' ) ) {
		return true;
	}
	return (bool) preg_match( '/\bwef\b/u', $t );
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
		'positioning_en' => 'Positioning line — EN (hero H1)',
		'positioning_vi' => 'Dòng định vị — VI (hero H1)',
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
		'block_hero'       => '1',
		'home_hero_bg_id'  => '0',
		'home_hero_fx_on'  => '0',
		'home_hero_fx'     => 'rise',
		'home_intro_bg_id' => '0',
		'home_figures_bg_id'   => '0',
		'home_theme_bg_id'     => '0',
		'home_pillars_bg_id'   => '0',
		'home_hosts_bg_id'     => '0',
		'home_week_bg_id'      => '0',
		'home_programme_bg_id' => '0',
		'home_city_bg_id'      => '0',
		'home_outcomes_bg_id'  => '0',
		'home_audience_bg_id'  => '0',
		'home_edition_bg_id'   => '0',
		'home_speakers_bg_id'  => '0',
		'home_side_bg_id'      => '0',
		'home_partners_bg_id'  => '0',
		'home_close_bg_id'     => '0',
		'home_support_bg_id'   => '0',
		'block_intro'      => '1',
		'block_figures'    => '1',
		'block_theme'      => '1',
		'block_hosts'      => '1',
		'block_week'       => '0',
		'block_programme'  => '1',
		'block_journey'    => '1',
		'block_featured'   => '1',
		'block_city'       => '1',
		'block_outcomes'   => '1',
		'block_audience'   => '1',
		'block_edition'    => '1',
		'block_speakers'   => '1',
		'block_media'      => '1',
		'block_side'       => '1',
		'block_partners'   => '1',
		'block_close'      => '1',
		'block_support'    => '1',
		'home_city_eyebrow_en' => 'Host city',
		'home_city_eyebrow_vi' => 'Thành phố chủ nhà',
		'home_city_title_en'   => 'A new development space, a new connection point',
		'home_city_title_vi'   => 'Một không gian phát triển mới, một điểm kết nối mới',
		'home_city_lead_en'    => 'As Viet Nam’s economic lead and a centre of finance, trade, science, technology and innovation, Ho Chi Minh City can connect capital, technology, knowledge and international business networks. The main forum days are at Thiskyhall, Sala.',
		'home_city_lead_vi'    => 'Với vai trò đầu tàu kinh tế, trung tâm tài chính, thương mại, khoa học – công nghệ và đổi mới sáng tạo của Việt Nam, Thành phố Hồ Chí Minh có điều kiện để kết nối các dòng vốn, công nghệ, tri thức và mạng lưới doanh nghiệp quốc tế. Hai ngày diễn đàn chính tại Thiskyhall, Sala.',
		'home_city_cta_en'     => 'Plan your visit',
		'home_city_cta_vi'     => 'Lên kế hoạch chuyến đi',
		'home_theme_eyebrow_en' => '2026 theme',
		'home_theme_eyebrow_vi' => 'Chủ đề 2026',
		'home_theme_title_en'   => 'Collaboration in a New Era',
		'home_theme_title_vi'   => 'Tinh thần hợp tác trong kỷ nguyên mới',
		'home_theme_lead_en'    => "AEF 2026 takes collaboration as the working method of the Forum: not only among countries, but among cities, firms, universities, investors and international organisations.\n\nThe aim is to turn dialogue into partnerships, programmes and projects that can continue after 27–28 October.",
		'home_theme_lead_vi'    => "AEF 2026 lấy hợp tác làm cách làm việc của Diễn đàn: không chỉ giữa các quốc gia, mà giữa đô thị, doanh nghiệp, viện trường, nhà đầu tư và tổ chức quốc tế.\n\nMục tiêu là chuyển đối thoại thành quan hệ đối tác, chương trình và dự án có thể tiếp tục sau các ngày 27–28 tháng 10.",
		'home_pillars_title_en' => 'The focus questions of AEF 2026',
		'home_pillars_title_vi' => 'Những vấn đề trọng tâm của AEF 2026',
		'home_pillars_lead_en'  => 'The AEF 2026 programme is built on four content pillars that run through the week, joining the global economic setting to the new development needs of Viet Nam and Ho Chi Minh City.',
		'home_pillars_lead_vi'  => 'Chương trình AEF 2026 được xây dựng trên bốn trụ cột nội dung xuyên suốt, kết nối bối cảnh kinh tế toàn cầu với những yêu cầu phát triển mới của Việt Nam và Thành phố Hồ Chí Minh.',
		'home_intro_eyebrow_en' => '',
		'home_intro_eyebrow_vi' => '',
		'home_intro_title_en'   => 'The Autumn Economic Forum',
		'home_intro_title_vi'   => 'Diễn đàn Kinh tế Mùa thu',
		'home_intro_lead_en'    => "The Autumn Economic Forum is Viet Nam’s annual international economic meeting, held in Ho Chi Minh City.\n\nIt provides a setting for government, localities, firms, international organisations and academia to exchange views on growth, technology, finance and cooperation.\n\nAEF 2026 is convened under the theme Collaboration in a New Era, with the positioning The Convergence of New Global Growth Engines.",
		'home_intro_lead_vi'    => "Diễn đàn Kinh tế Mùa thu là hội nghị kinh tế quốc tế thường niên của Việt Nam, tổ chức tại Thành phố Hồ Chí Minh.\n\nDiễn đàn là nơi cơ quan nhà nước, địa phương, doanh nghiệp, tổ chức quốc tế và giới học thuật trao đổi về tăng trưởng, công nghệ, tài chính và hợp tác.\n\nAEF 2026 lấy chủ đề Tinh thần hợp tác trong kỷ nguyên mới, với định vị Sự hội tụ của các cực tăng trưởng mới toàn cầu.",
		'home_figures_title_en' => 'AEF 2026 in figures',
		'home_figures_title_vi' => 'AEF 2026 trong những con số',
		'home_fig_1_n' => '02',
		'home_fig_1_en' => 'days of the main forum',
		'home_fig_1_vi' => 'ngày diễn đàn chính',
		'home_fig_2_n' => '~2,000',
		'home_fig_2_en' => 'delegates from Viet Nam and abroad',
		'home_fig_2_vi' => 'đại biểu trong nước và quốc tế',
		'home_fig_3_n' => '15',
		'home_fig_3_en' => 'parallel sessions on 27 October',
		'home_fig_3_vi' => 'phiên thảo luận chuyên đề song song ngày 27/10',
		'home_fig_4_n' => 'Many',
		'home_fig_4_n_en' => 'Many',
		'home_fig_4_n_vi' => 'Nhiều',
		'home_fig_4_en' => 'governments · business · international organisations · academia · innovation ecosystems',
		'home_fig_4_vi' => 'Chính phủ · Doanh nghiệp · Tổ chức quốc tế · Giới học thuật · Hệ sinh thái đổi mới sáng tạo',
		'home_week_eyebrow_en' => 'Forum week',
		'home_week_eyebrow_vi' => 'Tuần Diễn đàn',
		'home_week_title_en'   => 'Four programme layers',
		'home_week_title_vi'   => 'Bốn lớp chương trình',
		'home_week_lead_en'    => 'Times, rooms and access for each session are set out on the Programme page.',
		'home_week_lead_vi'    => 'Thời gian, phòng họp và quyền tham dự từng phiên được nêu tại trang Chương trình.',
		'home_week_cta_en'     => 'Full programme',
		'home_week_cta_vi'     => 'Chương trình đầy đủ',
		'home_programme_overline_en' => 'Programme framework',
		'home_programme_overline_vi' => 'Khung chương trình',
		'home_programme_title_en'    => 'Four days, one path of convergence',
		'home_programme_title_vi'    => 'Bốn ngày, một mạch hội tụ',
		'home_programme_lead_en'     => 'All activities are listed in chronological order. 27 October is devoted to thematic depth and innovation networking; 28 October to high-level strategic dialogue. Select an activity to see its content, speakers and duration.',
		'home_programme_lead_vi'     => 'Các hoạt động được sắp xếp theo trình tự thời gian. Ngày 27/10 dành cho chiều sâu chuyên đề và kết nối đổi mới sáng tạo; ngày 28/10 là các phiên đối thoại chiến lược cấp cao. Chọn một hoạt động để xem nội dung, diễn giả và thời lượng.',
		'home_programme_note_en'     => '',
		'home_programme_note_vi'     => '',
		'home_edition_eyebrow_en' => 'The 2025 edition',
		'home_edition_eyebrow_vi' => 'Kỳ năm 2025',
		'home_edition_title_en'   => 'The most recent Forum, in figures',
		'home_edition_title_vi'   => 'Kỳ gần nhất, qua một số liệu',
		'home_edition_lead_en'    => 'Figures from Organising Committee materials for the 2025 edition.',
		'home_edition_lead_vi'    => 'Số liệu theo tư liệu Ban Tổ chức cho kỳ 2025.',
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
		'home_speakers_title_en'   => 'AEF 2026 speakers',
		'home_speakers_title_vi'   => 'Diễn giả AEF 2026',
		'home_speakers_lead_en'    => 'Leaders, policymakers, executives and specialists taking part in the thematic sessions and the high-level programme.',
		'home_speakers_lead_vi'    => 'Lãnh đạo, nhà hoạch định chính sách, doanh nhân và chuyên gia tham gia các phiên thảo luận chuyên đề và chương trình cấp cao.',
		'home_speakers_cta_en'     => 'All speakers',
		'home_speakers_cta_vi'     => 'Toàn bộ diễn giả',
		'home_side_title_en'       => 'Collaboration spaces alongside the Forum',
		'home_side_title_vi'       => 'Không gian hợp tác bên lề Diễn đàn',
		'home_side_lead_en'        => 'Beyond the main programme, the Forum opens Collaboration Roads combining conferences, roundtables, exhibitions, technology showcases, investment matchmaking and cultural exchange. Select an activity for details.',
		'home_side_lead_vi'        => 'Bên cạnh chương trình chính, Diễn đàn mở ra các không gian hợp tác (Collaboration Roads) kết hợp hội nghị, tọa đàm, triển lãm, trình diễn công nghệ, kết nối đầu tư và giao lưu văn hóa. Chọn một hoạt động để xem chi tiết.',
		'home_side_1_en' => 'Bilateral seminars and dialogues',
		'home_side_1_vi' => 'Hội thảo và đối thoại song phương',
		'home_side_2_en' => 'Cooperation space',
		'home_side_2_vi' => 'Không gian hợp tác',
		'home_side_3_en' => 'Technology demonstration',
		'home_side_3_vi' => 'Trình diễn công nghệ',
		'home_side_4_en' => 'Investment matching',
		'home_side_4_vi' => 'Kết nối đầu tư',
		'home_side_5_en' => 'C4IR Network activities',
		'home_side_5_vi' => 'Hoạt động Mạng lưới C4IR',
		'home_side_6_en' => 'Field visits',
		'home_side_6_vi' => 'Tham quan thực địa',
		'home_side_7_en' => 'Cultural experience',
		'home_side_7_vi' => 'Trải nghiệm văn hóa',
		'home_close_title_en' => 'Attend AEF 2026',
		'home_close_title_vi' => 'Tham dự AEF 2026',
		'home_close_lead_en'  => 'Registration follows an invitation and review by the Organising Committee. Programme and attendance notes are published on this site.',
		'home_close_lead_vi'  => 'Việc đăng ký thực hiện theo thư mời và xét duyệt của Ban Tổ chức. Chương trình và thông tin tham dự được công bố trên cổng này.',
		'home_close_cta1_en'  => 'Explore the programme',
		'home_close_cta1_vi'  => 'Khám phá chương trình',
		'home_close_cta2_en'  => 'How to attend',
		'home_close_cta2_vi'  => 'Thông tin tham dự',
		'home_support_eyebrow_en' => 'Support Centre',
		'home_support_eyebrow_vi' => 'Trung tâm Hỗ trợ',
		'home_support_title_en'   => 'One centre, three routes',
		'home_support_title_vi'   => 'Một trung tâm, ba lối đi',
		'home_support_lead_en'    => 'Delegates, journalists and visitors each follow a separate path: registration and access, press working rules, and the city kit for Thiskyhall and Sala.',
		'home_support_lead_vi'    => 'Đại biểu, nhà báo và khách mỗi bên một lối: đăng ký và quyền vào cửa, quy định tác nghiệp, và cẩm nang Thiskyhall – Sala.',
		'home_media_eyebrow_en'   => 'Media',
		'home_media_eyebrow_vi'   => 'Truyền thông',
		'home_media_title_en'     => 'News',
		'home_media_title_vi'     => 'Tin tức',
		'home_media_lead_en'      => 'Official public information of AEF 2026, with a working note for the press.',
		'home_media_lead_vi'      => 'Thông tin công khai chính thức của AEF 2026, kèm đầu mối dành cho báo chí.',
		'home_media_cta_en'       => 'All news',
		'home_media_cta_vi'       => 'Mọi tin tức',
		'home_hero_lead_en' => 'The Autumn Economic Forum 2026 is convened by the People’s Committee of Ho Chi Minh City. The Forum gathers delegates from government, business, international organisations and academia.',
		'home_hero_lead_vi' => 'Diễn đàn Kinh tế Mùa thu năm 2026 do Ủy ban nhân dân Thành phố Hồ Chí Minh chủ trì. Diễn đàn quy tụ đại biểu từ khu vực nhà nước, doanh nghiệp, tổ chức quốc tế và giới học thuật.',
		'home_hero_cta1_en' => 'Explore the programme',
		'home_hero_cta1_vi' => 'Khám phá chương trình',
		'home_hero_cta2_en' => 'Register',
		'home_hero_cta2_vi' => 'Đăng ký tham dự',
		'home_meta_week_en' => 'Forum week',
		'home_meta_week_vi' => 'Tuần Diễn đàn',
		'home_meta_main_en' => 'Main forum',
		'home_meta_main_vi' => 'Diễn đàn chính',
		'home_meta_city_en' => 'Host city',
		'home_meta_city_vi' => 'Thành phố chủ nhà',
		'home_hosts_eyebrow_en' => '',
		'home_hosts_eyebrow_vi' => '',
		'home_hosts_title_en'   => '',
		'home_hosts_title_vi'   => '',
		'home_hosts_lead_en'    => '',
		'home_hosts_lead_vi'    => '',
		'home_hosts_3_role_en'  => 'Implementing centre',
		'home_hosts_3_role_vi'  => 'Đơn vị thực hiện',
		'home_hosts_3_name_en'  => 'HCMC C4IR',
		'home_hosts_3_name_vi'  => 'HCMC C4IR',
		'home_hosts_4_role_en'  => '',
		'home_hosts_4_role_vi'  => '',
		'home_hosts_4_name_en'  => '',
		'home_hosts_4_name_vi'  => '',
		'home_programme_cta_en' => 'Full programme',
		'home_programme_cta_vi' => 'Xem chương trình tổng thể',
		'home_pillars_cta_en'   => 'Four content pillars',
		'home_pillars_cta_vi'   => 'Bốn trụ cột nội dung',
		'home_outcomes_eyebrow_en' => 'From dialogue to action',
		'home_outcomes_eyebrow_vi' => 'Từ đối thoại đến hành động',
		'home_outcomes_title_en'   => 'Connections that continue after the Forum',
		'home_outcomes_title_vi'   => 'Những kết nối tiếp tục sau Diễn đàn',
		'home_outcomes_lead_en'    => 'AEF 2026 is not aimed only at exchanges across the two main days. Activities are designed to help form policy recommendations, connect investment, technology and finance, widen partnerships and create the conditions for initiatives that can continue after the event — when they meet the required conditions.',
		'home_outcomes_lead_vi'    => 'AEF 2026 không chỉ hướng tới những cuộc trao đổi trong hai ngày diễn đàn chính. Các hoạt động được định hướng để góp phần hình thành khuyến nghị chính sách, kết nối đầu tư – công nghệ – tài chính, mở rộng quan hệ hợp tác và tạo nền tảng cho những sáng kiến có thể tiếp tục sau sự kiện — khi đủ điều kiện.',
		'home_audience_eyebrow_en' => 'Who takes part',
		'home_audience_eyebrow_vi' => 'Người tham dự',
		'home_audience_title_en'   => 'Participants',
		'home_audience_title_vi'   => 'Thành phần tham dự',
		'home_audience_lead_en'    => 'The Forum is intended for representatives of government, localities, firms, international organisations, research institutes and universities, as confirmed by the Organising Committee.',
		'home_audience_lead_vi'    => 'Diễn đàn dành cho đại diện cơ quan nhà nước, địa phương, doanh nghiệp, tổ chức quốc tế, viện nghiên cứu và trường đại học, theo xác nhận của Ban Tổ chức.',
		'home_edition_cta_en'      => 'The 2025 edition in full',
		'home_edition_cta_vi'      => 'Toàn cảnh kỳ 2025',
		'home_partners_eyebrow_en' => 'Partners',
		'home_partners_eyebrow_vi' => 'Đối tác',
		'home_partners_title_en'   => 'Connecting resources|for AEF 2026',
		'home_partners_title_vi'   => 'Kết nối nguồn lực|cho AEF 2026',
		'home_partners_lead_en'    => 'Governments, cities, firms and institutions that shape the Forum week.',
		'home_partners_lead_vi'    => 'Chính phủ, đô thị, doanh nghiệp và tổ chức đồng hành cùng tuần lễ Diễn đàn.',
		'home_partners_cta_en'     => 'Organisations & partners',
		'home_partners_cta_vi'     => 'Đơn vị & đối tác',
		'home_support_cta_en'      => 'Travel kit',
		'home_support_cta_vi'      => 'Cẩm nang đi lại',
	);
}

function aef_copy_all() {
	$saved = get_option( 'aef_copy', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	return array_merge( aef_default_copy(), $saved );
}

function aef_sanitize_custom_css( $css ) {
	$css = is_string( $css ) ? $css : '';
	$css = str_replace( "\0", '', $css );
	$css = preg_replace( '#</\s*textarea#i', '', $css );
	$css = wp_strip_all_tags( $css );
	$css = preg_replace( '/expression\s*\(/i', '', $css );
	$css = preg_replace( '/javascript\s*:/i', '', $css );
	$css = preg_replace( '/-moz-binding\s*:/i', '', $css );
	return is_string( $css ) ? $css : '';
}

function aef_custom_css() {
	$css = get_option( 'aef_custom_css', '' );
	return is_string( $css ) ? $css : '';
}

function aef_custom_css_on() {
	$on = get_option( 'aef_custom_css_on', '0' );
	return '1' === (string) $on;
}

function aef_copy( $key ) {
	$all  = aef_copy_all();
	$lang = function_exists( 'aef_lang' ) ? aef_lang() : 'en';
	$try  = $key . '_' . $lang;
	if ( isset( $all[ $try ] ) && $all[ $try ] !== '' ) {
		return $all[ $try ];
	}
	return isset( $all[ $key ] ) ? $all[ $key ] : '';
}

function aef_has_copy( $key ) {
	return '' !== trim( (string) aef_copy( $key ) );
}

function aef_paras_html( $text, $first_class = '' ) {
	$text = trim( (string) $text );
	if ( '' === $text ) {
		return '';
	}
	$parts = preg_split( '/\n\s*\n/u', $text );
	$html  = '';
	$i     = 0;
	foreach ( $parts as $p ) {
		$p = trim( $p );
		if ( '' === $p ) {
			continue;
		}
		$class = ( 0 === $i && $first_class ) ? ' class="' . esc_attr( $first_class ) . '"' : '';
		$html .= '<p' . $class . '>' . nl2br( esc_html( $p ) ) . '</p>';
		$i++;
	}
	return $html;
}

function aef_register_url() {
	$s    = function_exists( 'aef_settings' ) ? aef_settings() : array();
	$path = isset( $s['register_path'] ) ? trim( (string) $s['register_path'] ) : '';
	if ( '' === $path ) {
		$path = '/2026/delegates/how-to-register/';
	}
	return home_url( $path );
}

function aef_block_on( $id ) {
	$all = aef_copy_all();
	if ( 'programme' === $id ) {
		foreach ( array( 'programme', 'journey', 'featured' ) as $alias ) {
			$key = 'block_' . $alias;
			if ( isset( $all[ $key ] ) && '1' === (string) $all[ $key ] ) {
				return true;
			}
			if ( isset( $all[ $key ] ) && '0' === (string) $all[ $key ] ) {
				continue;
			}
		}
		return ! isset( $all['block_programme'] ) || '0' !== (string) $all['block_programme'];
	}
	$key = 'block_' . $id;
	return ! isset( $all[ $key ] ) || '0' !== (string) $all[ $key ];
}

function aef_hero_fx_defs() {
	return array(
		'rise' => array(
			'label' => 'Dải sáng vươn lên',
			'help'  => 'Vệt sáng từ dưới–trái lên trên–phải. Chỉ vẽ trên lớp hiệu ứng, không đổi ảnh nền.',
		),
	);
}

function aef_hero_fx() {
	$all = aef_copy_all();
	if ( empty( $all['home_hero_fx_on'] ) || '1' !== (string) $all['home_hero_fx_on'] ) {
		return '';
	}
	$slug = isset( $all['home_hero_fx'] ) ? sanitize_key( $all['home_hero_fx'] ) : '';
	$defs = aef_hero_fx_defs();
	return isset( $defs[ $slug ] ) ? $slug : '';
}

function aef_home_block_defs() {
	return array(
		'hero'      => array(
			'label'  => 'Hero',
			'help'   => 'Tên diễn đàn, chủ đề, ngày, hai nút. Ảnh nền chọn từ thư viện (để trống = KV mặc định). Hiệu ứng là lớp riêng, bật/tắt bên dưới — không đụng ảnh nền. Ô chữ trống = ẩn.',
			'image'  => array(
				'home_hero_bg_id' => 'Ảnh nền Hero',
			),
			'fields' => array(
				'home_hero_lead' => 'Đoạn dưới chủ đề',
				'home_hero_cta1' => 'Nút chương trình',
				'home_hero_cta2' => 'Nút đăng ký',
				'home_meta_week' => 'Nhãn tuần lễ',
				'home_meta_main' => 'Nhãn diễn đàn chính',
				'home_meta_city' => 'Nhãn thành phố',
			),
		),
		'intro'     => array(
			'label'  => 'Giới thiệu nhanh',
			'help'   => 'Cụm “Nơi những động lực tăng trưởng mới gặp nhau”. Đổi ảnh nền ngay dưới đây — khác ảnh Hero. Ô chữ trống = ẩn.',
			'image'  => array(
				'home_intro_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_intro_eyebrow' => 'Eyebrow (để trống = ẩn)',
				'home_intro_title'   => 'Tiêu đề',
				'home_intro_lead'    => 'Đoạn dẫn (xuống dòng trắng = đoạn mới)',
			),
		),
		'figures'   => array(
			'label'  => 'Số liệu AEF 2026',
			'help'   => '02 ngày / ~2.000 / 15 phiên / nhóm đại biểu. Không dùng số liệu kỳ 2025. Ô trống = ẩn. Ảnh nền trống = nền xám hiện tại.',
			'image'  => array(
				'home_figures_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_figures_title' => 'Tiêu đề',
			),
			'figures' => true,
		),
		'theme'     => array(
			'label'  => 'Chủ đề & bốn trụ cột',
			'help'   => 'Thân chủ đề + bốn trụ. Ô trống = ẩn. Ảnh nền trống = giữ nền CSS.',
			'image'  => array(
				'home_theme_bg_id'   => 'Ảnh nền khối chủ đề',
				'home_pillars_bg_id' => 'Ảnh nền khối bốn trụ',
			),
			'fields' => array(
				'home_theme_eyebrow' => 'Eyebrow chủ đề (để trống = ẩn)',
				'home_theme_title'   => 'Tiêu đề chủ đề',
				'home_theme_lead'    => 'Đoạn chủ đề',
				'home_pillars_title' => 'Tiêu đề bốn trụ',
				'home_pillars_lead'  => 'Đoạn dẫn bốn trụ',
				'home_pillars_cta'   => 'Nút bốn trụ',
			),
		),
		'hosts'     => array(
			'label'  => 'Vai trò tổ chức',
			'help'   => 'Host 1–2 sửa ở Cài đặt kỳ. C4IR / WEF và tiêu đề khối sửa ở đây. Ảnh nền trống = nền trắng.',
			'image'  => array(
				'home_hosts_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_hosts_eyebrow' => 'Eyebrow (để trống = ẩn)',
				'home_hosts_title'   => 'Tiêu đề (để trống = ẩn)',
				'home_hosts_lead'    => 'Đoạn dẫn (để trống = ẩn)',
				'home_hosts_3_role'  => 'C4IR — vai trò',
				'home_hosts_3_name'  => 'C4IR — tên',
				'home_hosts_4_role'  => 'WEF — vai trò',
				'home_hosts_4_name'  => 'WEF — tên',
			),
		),
		'week'      => array(
			'label'  => 'Bốn lớp tuần lễ',
			'help'   => 'Thẻ 26–29/10. Mặc định đang ẩn. Ảnh nền trống = giữ nền CSS.',
			'image'  => array(
				'home_week_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_week_eyebrow' => 'Eyebrow',
				'home_week_title'   => 'Tiêu đề',
				'home_week_lead'    => 'Đoạn dẫn',
				'home_week_cta'     => 'Nút',
			),
		),
		'programme' => array(
			'label'  => 'Chương trình 26–28',
			'help'   => 'Tiêu đề: gõ | để xuống dòng; bọc *chữ* để nhấn màu cyan. Ô trống = ẩn. Ảnh nền trống = nền xanh đậm hiện tại.',
			'image'  => array(
				'home_programme_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_programme_overline' => 'Eyebrow (để trống = ẩn)',
				'home_programme_title'    => 'Tiêu đề (dùng | để xuống dòng)',
				'home_programme_lead'     => 'Đoạn dẫn',
				'home_programme_note'     => 'Ghi chú (để trống = ẩn)',
				'home_programme_cta'      => 'Nút xem chương trình',
			),
		),
		'city'      => array(
			'label'  => 'Thành phố chủ nhà',
			'help'   => 'Dải ảnh + nút sang Travel. Ảnh nền trống = phố chạng vạng (hcmc-dusk).',
			'image'  => array(
				'home_city_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_city_eyebrow' => 'Eyebrow',
				'home_city_title'   => 'Tiêu đề',
				'home_city_lead'    => 'Đoạn dẫn',
				'home_city_cta'     => 'Nút',
			),
		),
		'outcomes'  => array(
			'label'  => 'Từ đối thoại đến hành động',
			'help'   => 'Lưới kết quả hướng tới. Ô trống = ẩn. Ảnh nền trống = giữ nền CSS.',
			'image'  => array(
				'home_outcomes_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_outcomes_eyebrow' => 'Eyebrow',
				'home_outcomes_title'   => 'Tiêu đề',
				'home_outcomes_lead'    => 'Đoạn dẫn',
			),
		),
		'audience'  => array(
			'label'  => 'Nhóm người tham dự',
			'help'   => 'Nhóm dự kiến, không phải danh sách khách. Ảnh nền trống = nền xám hiện tại.',
			'image'  => array(
				'home_audience_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_audience_eyebrow' => 'Eyebrow',
				'home_audience_title'   => 'Tiêu đề',
				'home_audience_lead'    => 'Đoạn dẫn',
			),
		),
		'edition'   => array(
			'label'  => 'Kỳ 2025',
			'help'   => 'Số liệu và ảnh kỳ trước. Ảnh nền áp cho dải số liệu tối. Trống = nền deep hiện tại.',
			'image'  => array(
				'home_edition_bg_id' => 'Ảnh nền dải số liệu',
			),
			'fields' => array(
				'home_edition_eyebrow' => 'Eyebrow',
				'home_edition_title'   => 'Tiêu đề',
				'home_edition_lead'    => 'Đoạn dẫn',
				'home_edition_cta'     => 'Nút',
			),
			'stats'  => true,
		),
		'speakers'  => array(
			'label'  => 'Diễn giả',
			'help'   => '8 thẻ từ mục Diễn giả. Tên chỉ công bố sau xác nhận. Ô trống = ẩn. Ảnh nền trống = giữ nền CSS.',
			'image'  => array(
				'home_speakers_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_speakers_eyebrow' => 'Eyebrow',
				'home_speakers_title'   => 'Tiêu đề',
				'home_speakers_lead'    => 'Đoạn dẫn',
				'home_speakers_cta'     => 'Nút',
			),
		),
		'media'     => array(
			'label'  => 'Tin tức',
			'help'   => 'Tin mới nhất từ mục Tin / thông cáo, video (hoặc phim tổng kết 2025) và đầu mối báo chí.',
			'image'  => array(),
			'fields' => array(
				'home_media_eyebrow' => 'Eyebrow',
				'home_media_title'   => 'Tiêu đề',
				'home_media_lead'    => 'Đoạn dẫn',
				'home_media_cta'     => 'Nút mọi tin',
			),
		),
		'side'      => array(
			'label'  => 'Hoạt động bên lề',
			'help'   => 'Chuỗi 26–29/10 theo khung: CEO 500, hội thảo song phương, không gian hợp tác, trình diễn công nghệ, C4IR, thực địa. Sửa tiêu đề và đoạn dẫn.',
			'image'  => array(
				'home_side_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_side_title' => 'Tiêu đề',
				'home_side_lead'  => 'Đoạn dẫn',
			),
		),
		'partners'  => array(
			'label'  => 'Đối tác',
			'help'   => 'Carousel logo: AEF Content → Logo trang chủ. Chữ và ảnh nền khối sửa ở đây. Ảnh nền trống = nền xám hiện tại.',
			'image'  => array(
				'home_partners_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_partners_eyebrow' => 'Eyebrow',
				'home_partners_title'   => 'Tiêu đề (dùng | để xuống dòng)',
				'home_partners_lead'    => 'Đoạn dẫn',
				'home_partners_cta'     => 'Nút danh sách đối tác',
			),
		),
		'close'     => array(
			'label'  => 'CTA cuối trang',
			'help'   => 'Hai nút: chương trình và thông tin tham dự. Ô trống = ẩn nút. Ảnh nền trống = nền xanh đậm hiện tại.',
			'image'  => array(
				'home_close_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_close_title' => 'Tiêu đề',
				'home_close_lead'  => 'Đoạn dẫn',
				'home_close_cta1'  => 'Nút chương trình',
				'home_close_cta2'  => 'Nút tham dự',
			),
		),
		'support'   => array(
			'label'  => 'Trung tâm Hỗ trợ',
			'help'   => 'Ba lối: Đại biểu, Báo chí, Cẩm nang. Hiện trên trang chủ.',
			'image'  => array(
				'home_support_bg_id' => 'Ảnh nền khối này',
			),
			'fields' => array(
				'home_support_eyebrow' => 'Eyebrow',
				'home_support_title'   => 'Tiêu đề',
				'home_support_lead'    => 'Đoạn dẫn',
				'home_support_cta'     => 'Nút',
			),
		),
	);
}

function aef_home_default_order() {
	return array_keys( aef_home_block_defs() );
}

function aef_home_order() {
	$defs   = aef_home_block_defs();
	$saved  = get_option( 'aef_home_order', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	$norm = array();
	foreach ( $saved as $id ) {
		if ( 'journey' === $id || 'featured' === $id ) {
			$id = 'programme';
		}
		if ( isset( $defs[ $id ] ) && ! in_array( $id, $norm, true ) ) {
			$norm[] = $id;
		}
	}
	foreach ( array_keys( $defs ) as $id ) {
		if ( ! in_array( $id, $norm, true ) ) {
			$norm[] = $id;
		}
	}
	return $norm;
}

function aef_about_defaults() {
	return array(
		'about_eyebrow_en' => 'AEF 2026',
		'about_eyebrow_vi' => 'AEF 2026',
		'about_title_en'   => 'About the Autumn Economic Forum',
		'about_title_vi'   => 'Về Diễn đàn Kinh tế Mùa thu',
		'about_deck_en'    => 'Convened by the People’s Committee of Ho Chi Minh City.',
		'about_deck_vi'    => 'Do Ủy ban nhân dân Thành phố Hồ Chí Minh chủ trì.',
		'about_credit_en'  => 'Reference image',
		'about_credit_vi'  => 'Ảnh minh họa',
		'about_opener_id'  => '',
		'about_lead_en'    => 'The Autumn Economic Forum is Viet Nam’s annual international economic meeting, held in Ho Chi Minh City.',
		'about_lead_vi'    => 'Diễn đàn Kinh tế Mùa thu là hội nghị kinh tế quốc tế thường niên của Việt Nam, được tổ chức tại Thành phố Hồ Chí Minh.',
		'about_body_en'    => "The 2026 positioning is The Convergence of New Global Growth Engines. The Forum addresses shifts in growth, the role of emerging economies and cities, and the bearing of science, technology, finance and the green transition on development.\n\nIt is a working meeting: to connect resources, encourage investment and technology cooperation, and support programmes that can continue after the Forum.\n\nHeld in Ho Chi Minh City, AEF 2026 links Viet Nam’s development agenda with regional and international partners.",
		'about_body_vi'    => "Định vị năm 2026 là Sự hội tụ của các cực tăng trưởng mới toàn cầu. Diễn đàn bàn về sự dịch chuyển của tăng trưởng, vai trò của các nền kinh tế mới nổi và đô thị, cùng tác động của khoa học, công nghệ, tài chính và chuyển đổi xanh đối với phát triển.\n\nĐây là hội nghị làm việc: kết nối nguồn lực, thúc đẩy đầu tư và hợp tác công nghệ, hỗ trợ các chương trình có thể tiếp tục sau Diễn đàn.\n\nTổ chức tại Thành phố Hồ Chí Minh, AEF 2026 gắn chương trình phát triển của Việt Nam với các đối tác khu vực và quốc tế.",
		'about_quote_en'   => '',
		'about_quote_vi'   => '',
		'about_why_h_en'   => 'A world in which new growth engines are taking shape',
		'about_why_h_vi'   => 'Một thế giới đang hình thành những động lực tăng trưởng mới',
		'about_why_p_en'   => "The world economy is going through a restructuring that goes beyond ordinary cyclical swings.\n\nGeopolitical competition now extends into technology, trade, investment and supply chains. Firms and economies increasingly have to weigh efficiency, security, resilience and strategic relationships at the same time.\n\nAt the same time, the centre of gravity of growth is shifting more strongly toward emerging economies; large cities are becoming nodes of capital, technology, talent and innovation; and artificial intelligence, automation, digital infrastructure and sustainability requirements are changing the standards of competition.\n\nThese shifts create a need for new spaces of dialogue: able to connect many actors, build trust, and turn policy exchange into concrete cooperation.\n\nAEF was formed in that setting.",
		'about_why_p_vi'   => "Kinh tế thế giới đang trải qua một quá trình tái cấu trúc vượt ra ngoài những biến động chu kỳ thông thường.\n\nCạnh tranh địa chính trị mở rộng sang công nghệ, thương mại, đầu tư và chuỗi cung ứng. Các doanh nghiệp và nền kinh tế ngày càng phải cân nhắc đồng thời hiệu quả, an toàn, khả năng chống chịu và quan hệ chiến lược.\n\nSong song với đó, trọng tâm tăng trưởng đang dịch chuyển mạnh hơn về các nền kinh tế mới nổi; các đô thị lớn trở thành đầu mối tập trung vốn, công nghệ, nhân lực và đổi mới sáng tạo; còn trí tuệ nhân tạo, tự động hóa, hạ tầng số và các yêu cầu về phát triển bền vững đang thay đổi các tiêu chuẩn cạnh tranh.\n\nNhững chuyển dịch này đặt ra nhu cầu về các không gian đối thoại mới: có khả năng kết nối nhiều chủ thể, xây dựng lòng tin và biến trao đổi chính sách thành những sáng kiến hợp tác cụ thể.\n\nAEF được hình thành trong bối cảnh đó.",
		'about_vn_h_en'    => 'Why Viet Nam',
		'about_vn_h_vi'    => 'Vì sao Việt Nam?',
		'about_vn_p_en'    => "Viet Nam is entering a new development phase that requires a stronger renewal of the growth model, with science, technology, innovation, digital transformation and international integration as important engines.\n\nAfter nearly four decades of Đổi mới, Viet Nam has built a wide network of economic and external relations, joined international value chains more deeply, and become an increasingly important destination for capital, technology and production.\n\nThe next phase sets a higher bar: not only to take part, but to strengthen connecting capacity, form new engines, and contribute more to regional and global cooperation frameworks.\n\nAEF creates a space for Viet Nam to talk with international partners on precisely these questions.",
		'about_vn_p_vi'    => "Việt Nam đang bước vào một giai đoạn phát triển mới với yêu cầu đổi mới mạnh mẽ mô hình tăng trưởng, lấy khoa học, công nghệ, đổi mới sáng tạo, chuyển đổi số và hội nhập quốc tế làm những động lực quan trọng.\n\nSau gần bốn thập kỷ Đổi mới, Việt Nam đã xây dựng mạng lưới quan hệ kinh tế và đối ngoại rộng khắp, tham gia sâu vào các chuỗi giá trị quốc tế và trở thành một điểm đến ngày càng quan trọng của các dòng vốn, công nghệ và sản xuất.\n\nGiai đoạn phát triển tiếp theo đặt ra yêu cầu cao hơn: không chỉ tham gia mà còn tăng cường năng lực kết nối, chủ động hình thành các động lực mới và đóng góp nhiều hơn vào những khuôn khổ hợp tác khu vực và toàn cầu.\n\nAEF tạo ra một không gian để Việt Nam trao đổi với các đối tác quốc tế về chính những vấn đề này.",
		'about_city_h_en'  => 'Why Ho Chi Minh City',
		'about_city_h_vi'  => 'Vì sao Thành phố Hồ Chí Minh?',
		'about_city_p_en'  => "In the national development strategy, Ho Chi Minh City is Viet Nam’s economic lead and a major centre of finance, trade, science and technology, and innovation.\n\nThe City’s new development space makes it possible to connect strengths in finance, industry, logistics, seaports, science and technology and innovation in a larger ecosystem.\n\nTogether with its business community, research institutes, universities and skilled workforce, the City can become a meeting point for capital, technology, knowledge and international cooperation.\n\nAEF is part of the work of building Ho Chi Minh City as a convergence point of those networks.",
		'about_city_p_vi'  => "Trong chiến lược phát triển quốc gia, Thành phố Hồ Chí Minh giữ vai trò đầu tàu kinh tế, trung tâm tài chính, thương mại, khoa học – công nghệ và đổi mới sáng tạo quan trọng của Việt Nam.\n\nKhông gian phát triển mới của Thành phố tạo điều kiện kết nối những thế mạnh về tài chính, công nghiệp, logistics, cảng biển, khoa học – công nghệ và đổi mới sáng tạo trong một hệ sinh thái có quy mô lớn hơn.\n\nCùng với cộng đồng doanh nghiệp, viện nghiên cứu, trường đại học và nguồn nhân lực chất lượng cao, Thành phố có điều kiện để trở thành một điểm kết nối các dòng vốn, công nghệ, tri thức và sáng kiến hợp tác quốc tế.\n\nAEF là một phần trong quá trình xây dựng Thành phố Hồ Chí Minh thành điểm hội tụ của những mạng lưới đó.",
		'about_theme_h_en' => 'The 2026 theme',
		'about_theme_h_vi' => 'Chủ đề năm 2026',
		'about_theme_p_en' => 'Collaboration in a New Era is not only widening existing relationships. It is the ability to identify problems together, share knowledge, connect resources and build ways of acting that fit a world changing quickly. The 2026 theme marks a shift from reacting to volatility toward actively building partnerships.',
		'about_theme_p_vi' => 'Hợp tác trong kỷ nguyên mới không chỉ là mở rộng các mối quan hệ sẵn có. Đó là khả năng cùng nhận diện vấn đề, chia sẻ tri thức, kết nối nguồn lực và xây dựng những cơ chế hành động phù hợp với một thế giới đang thay đổi nhanh chóng. Chủ đề AEF 2026 thể hiện sự chuyển dịch từ ứng phó với biến động sang chủ động kiến tạo quan hệ đối tác.',
		'about_figure_id'  => '',
		'about_figure_cap_en' => 'Ho Chi Minh City, host city of the Forum.',
		'about_figure_cap_vi' => 'Thành phố Hồ Chí Minh, thành phố đăng cai Diễn đàn.',
		'about_origin_p_en' => "The Forum began in 2018 as the Ho Chi Minh City Economic Forum. From 2025 it has been convened under the direct direction of the Prime Minister of Viet Nam, under the name Autumn Economic Forum.\n\nIt is not a policy exchange alone. It is a mechanism to turn technology trends, innovation and global resources into cooperation programmes and investment projects.",
		'about_origin_p_vi' => "Diễn đàn bắt đầu năm 2018 với tên Diễn đàn Kinh tế Thành phố Hồ Chí Minh. Từ năm 2025, Diễn đàn được tổ chức dưới sự chỉ đạo trực tiếp của Thủ tướng Chính phủ, và mang tên Diễn đàn Kinh tế Mùa thu.\n\nĐây không chỉ là nơi trao đổi chính sách, mà là cơ chế chuyển hóa các xu hướng công nghệ, sáng kiến đổi mới sáng tạo và nguồn lực toàn cầu thành chương trình hợp tác và dự án đầu tư.",
		'about_values_h_en' => 'Aims of AEF 2026',
		'about_values_h_vi' => 'Mục tiêu của AEF 2026',
		'about_v1_h_en' => 'Connect resources',
		'about_v1_h_vi' => 'Kết nối nguồn lực',
		'about_v1_p_en' => 'Promote solutions, agreements and cooperation projects in investment, finance, science and technology, innovation, workforce development and sustainable development.',
		'about_v1_p_vi' => 'Thúc đẩy các giải pháp, thỏa thuận và dự án hợp tác về đầu tư, tài chính, khoa học – công nghệ, đổi mới sáng tạo, phát triển nguồn nhân lực và phát triển bền vững.',
		'about_v2_h_en' => 'Dialogue and policy recommendations',
		'about_v2_h_vi' => 'Đối thoại và khuyến nghị chính sách',
		'about_v2_p_en' => 'Create a space for exchange among public authorities, firms, international organisations and specialists, contributing to research and policymaking.',
		'about_v2_p_vi' => 'Tạo không gian trao đổi giữa cơ quan quản lý, doanh nghiệp, tổ chức quốc tế và giới chuyên gia, đóng góp cho quá trình nghiên cứu và hoạch định chính sách.',
		'about_v3_h_en' => 'Shape new growth engines',
		'about_v3_h_vi' => 'Kiến tạo những động lực tăng trưởng mới',
		'about_v3_p_en' => 'Discuss new economic models and development engines linked to technology, digital transformation, the green transition, the private sector and competitiveness.',
		'about_v3_p_vi' => 'Thảo luận các mô hình kinh tế và động lực phát triển mới gắn với công nghệ, chuyển đổi số, chuyển đổi xanh, kinh tế tư nhân và năng lực cạnh tranh.',
		'about_v4_h_en' => 'Advance new cooperation models',
		'about_v4_h_vi' => 'Thúc đẩy các mô hình hợp tác mới',
		'about_v4_p_en' => 'Strengthen links among government, localities, firms, universities and international networks, and promote public–private and multilateral cooperation.',
		'about_v4_p_vi' => 'Tăng cường kết nối giữa Chính phủ, địa phương, doanh nghiệp, viện trường và mạng lưới quốc tế, thúc đẩy hợp tác công – tư và các mô hình hợp tác đa phương.',
		'about_v5_h_en' => 'Build an annual dialogue platform',
		'about_v5_h_vi' => 'Xây dựng một nền tảng đối thoại thường niên',
		'about_v5_p_en' => 'Step by step, develop AEF as an annual international meeting point in Viet Nam on the economy, science and technology, finance, investment, innovation and sustainable development.',
		'about_v5_p_vi' => 'Từng bước phát triển AEF thành một điểm kết nối quốc tế thường niên của Việt Nam về kinh tế, khoa học – công nghệ, tài chính, đầu tư, đổi mới sáng tạo và phát triển bền vững.',
		'about_pillars_link_en' => 'Explore the four content pillars',
		'about_pillars_link_vi' => 'Khám phá bốn trụ cột nội dung',
		'about_annual_h_en' => '',
		'about_annual_h_vi' => '',
		'about_annual_p_en' => 'The Forum is being positioned as the third of three annual meetings that together carry the cooperation agenda through the year.',
		'about_annual_p_vi' => 'Diễn đàn đang được định vị là trụ cột thứ ba trong ba hội nghị thường niên cùng nối chương trình hợp tác xuyên suốt năm.',
		'about_a1_h_en' => 'WEF Annual Meeting, Davos',
		'about_a1_h_vi' => 'Hội nghị thường niên WEF tại Davos',
		'about_a1_p_en' => 'January · the global agenda-setting meeting',
		'about_a1_p_vi' => 'Tháng 1 · hội nghị định hình chương trình nghị sự toàn cầu',
		'about_a2_h_en' => 'Annual Meeting of the New Champions',
		'about_a2_h_vi' => 'Hội nghị Thường niên các Nhà Tiên phong',
		'about_a2_p_en' => 'Mid-year · growth economies and emerging industries',
		'about_a2_p_vi' => 'Giữa năm · các nền kinh tế tăng trưởng và ngành công nghiệp mới nổi',
		'about_a3_h_en' => 'Autumn Economic Forum',
		'about_a3_h_vi' => 'Diễn đàn Kinh tế Mùa thu',
		'about_a3_p_en' => 'October · Ho Chi Minh City',
		'about_a3_p_vi' => 'Tháng 10 · Thành phố Hồ Chí Minh',
		'about_hosts_h_en' => 'Organisation',
		'about_hosts_h_vi' => 'Mô hình tổ chức',
		'about_hosts_p_en' => 'Directed by the Government of Viet Nam. Convened by the People’s Committee of Ho Chi Minh City. HCMC C4IR is the implementing centre.',
		'about_hosts_p_vi' => 'Chính phủ Việt Nam chỉ đạo. UBND Thành phố Hồ Chí Minh chủ trì. HCMC C4IR là đơn vị thực hiện.',
		'about_editions_h_en' => 'Explore every edition',
		'about_editions_h_vi' => 'Khám phá từng kỳ Diễn đàn',
		'about_fact_est' => '2018',
		'about_fact_count_en' => 'Six, 2018 to 2025',
		'about_fact_count_vi' => 'Sáu kỳ, 2018 – 2025',
		'about_mail_general' => 'contact@aef.vn',
		'about_mail_delegates' => 'support@aef.vn',
		'about_mail_press' => 'press@aef.vn',
		'about_block_story'    => '1',
		'about_block_why'      => '1',
		'about_block_theme'    => '1',
		'about_block_aims'     => '1',
		'about_block_annual'   => '0',
		'about_block_hosts'    => '1',
		'about_block_editions' => '1',
		'about_block_facts'    => '1',
		'about_story_bg_id'    => '',
		'about_why_bg_id'      => '',
		'about_theme_bg_id'    => '',
		'about_aims_bg_id'     => '',
		'about_annual_bg_id'   => '',
		'about_hosts_bg_id'    => '',
		'about_editions_bg_id' => '',
		'about_fact_est_label_en'   => 'Established',
		'about_fact_est_label_vi'   => 'Khởi đầu',
		'about_fact_count_label_en' => 'Editions held',
		'about_fact_count_label_vi' => 'Số kỳ đã tổ chức',
		'about_fact_city_label_en'  => 'Host city',
		'about_fact_city_label_vi'  => 'Thành phố chủ nhà',
		'about_fact_venue_label_en' => 'Venue',
		'about_fact_venue_label_vi' => 'Địa điểm',
		'about_mail_general_label_en'   => 'General enquiries',
		'about_mail_general_label_vi'   => 'Liên hệ chung',
		'about_mail_delegates_label_en' => 'Delegates',
		'about_mail_delegates_label_vi' => 'Đại biểu',
		'about_mail_press_label_en'     => 'Media',
		'about_mail_press_label_vi'     => 'Báo chí',
		'about_facts_cta_en' => 'The 2025 edition',
		'about_facts_cta_vi' => 'Kỳ năm 2025',
	);
}

function aef_about_all() {
	$saved = get_option( 'aef_about', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	$defaults = aef_about_defaults();
	$all      = array_merge( $defaults, $saved );
	if ( ! array_key_exists( 'about_hosts_p_vi', $saved ) ) {
		$all['about_block_hosts'] = '1';
		if ( '' === trim( (string) $all['about_hosts_h_vi'] ) || 'Ai làm gì' === $all['about_hosts_h_vi'] ) {
			$all['about_hosts_h_vi'] = $defaults['about_hosts_h_vi'];
			$all['about_hosts_h_en'] = $defaults['about_hosts_h_en'];
		}
	}
	return $all;
}

function aef_about( $key ) {
	$all  = aef_about_all();
	$lang = function_exists( 'aef_lang' ) ? aef_lang() : 'en';
	$try  = $key . '_' . $lang;
	if ( isset( $all[ $try ] ) && $all[ $try ] !== '' ) {
		return $all[ $try ];
	}
	return isset( $all[ $key ] ) ? $all[ $key ] : '';
}

function aef_about_bg( $key ) {
	$all = aef_about_all();
	$id  = isset( $all[ $key ] ) ? absint( $all[ $key ] ) : 0;
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	return '';
}

function aef_about_image( $slot, $fallback_file ) {
	$all = aef_about_all();
	$id  = isset( $all[ 'about_' . $slot . '_id' ] ) ? absint( $all[ 'about_' . $slot . '_id' ] ) : 0;
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'large' );
		if ( $url ) {
			return $url;
		}
	}
	return function_exists( 'aef_img' ) ? aef_img( $fallback_file ) : $fallback_file;
}

function aef_about_block_defs() {
	return array(
		'story'    => array(
			'label'  => 'AEF là gì',
			'help'   => 'Đoạn dẫn, thân, trích dẫn, ảnh trong bài. Cột sự kiện hiện nếu khối “Cột thông tin” đang bật.',
			'image'  => array( 'about_story_bg_id' => 'Ảnh nền khối' ),
			'fields' => array(
				'about_lead'       => 'Đoạn dẫn',
				'about_body'       => 'Đoạn thân',
				'about_origin_p'   => 'Nguồn gốc Diễn đàn (sau đoạn thân)',
				'about_quote'      => 'Trích dẫn (để trống = ẩn)',
				'about_figure_cap' => 'Chú thích ảnh trong bài',
			),
			'ids'    => array( 'about_figure_id' => 'Ảnh trong bài' ),
		),
		'why'      => array(
			'label'  => 'Vì sao AEF / Việt Nam / TP.HCM',
			'help'   => 'Ba chương. Ô tiêu đề trống = ẩn chương đó.',
			'image'  => array( 'about_why_bg_id' => 'Ảnh nền khối' ),
			'fields' => array(
				'about_why_h'  => 'Vì sao AEF — tiêu đề',
				'about_why_p'  => 'Vì sao AEF — đoạn',
				'about_vn_h'   => 'Vì sao Việt Nam — tiêu đề',
				'about_vn_p'   => 'Vì sao Việt Nam — đoạn',
				'about_city_h' => 'Vì sao TP.HCM — tiêu đề',
				'about_city_p' => 'Vì sao TP.HCM — đoạn',
			),
		),
		'theme'    => array(
			'label'  => 'Chủ đề 2026',
			'help'   => 'Ô trống = ẩn khối.',
			'image'  => array( 'about_theme_bg_id' => 'Ảnh nền khối' ),
			'fields' => array(
				'about_theme_h' => 'Tiêu đề',
				'about_theme_p' => 'Đoạn',
			),
		),
		'aims'     => array(
			'label'  => 'Mục tiêu AEF 2026',
			'help'   => 'Năm thẻ. Ô tiêu đề thẻ trống = ẩn thẻ đó.',
			'image'  => array( 'about_aims_bg_id' => 'Ảnh nền khối' ),
			'fields' => array(
				'about_values_h'     => 'Tiêu đề nhóm',
				'about_v1_h'         => '01 — tiêu đề',
				'about_v1_p'         => '01 — đoạn',
				'about_v2_h'         => '02 — tiêu đề',
				'about_v2_p'         => '02 — đoạn',
				'about_v3_h'         => '03 — tiêu đề',
				'about_v3_p'         => '03 — đoạn',
				'about_v4_h'         => '04 — tiêu đề',
				'about_v4_p'         => '04 — đoạn',
				'about_v5_h'         => '05 — tiêu đề',
				'about_v5_p'         => '05 — đoạn',
				'about_pillars_link' => 'Nút sang chuyên đề',
			),
		),
		'annual'   => array(
			'label'  => 'Ba trụ cột thường niên',
			'help'   => 'Mặc định ẩn. Bật rồi điền tiêu đề nhóm.',
			'image'  => array( 'about_annual_bg_id' => 'Ảnh nền khối' ),
			'fields' => array(
				'about_annual_h' => 'Tiêu đề nhóm',
				'about_annual_p' => 'Đoạn dẫn',
				'about_a1_h'     => 'Davos — tên',
				'about_a1_p'     => 'Davos — dòng phụ',
				'about_a2_h'     => 'New Champions — tên',
				'about_a2_p'     => 'New Champions — dòng phụ',
				'about_a3_h'     => 'AEF — tên',
				'about_a3_p'     => 'AEF — dòng phụ',
			),
		),
		'hosts'    => array(
			'label'  => 'Mô hình tổ chức',
			'help'   => 'Tiêu đề và đoạn mô tả sửa tại đây. Bốn chủ thể: 1–2 lưu vào Cài đặt kỳ, C4IR/WEF lưu vào Trang chủ.',
			'image'  => array( 'about_hosts_bg_id' => 'Ảnh nền khối' ),
			'fields' => array(
				'about_hosts_h' => 'Tiêu đề',
				'about_hosts_p' => 'Đoạn mô tả',
			),
		),
		'editions' => array(
			'label'  => 'Các kỳ Diễn đàn',
			'help'   => 'Danh sách lấy từ CPT Editions.',
			'image'  => array( 'about_editions_bg_id' => 'Ảnh nền khối' ),
			'fields' => array(
				'about_editions_h' => 'Tiêu đề danh sách kỳ',
			),
		),
		'facts'    => array(
			'label'  => 'Cột thông tin',
			'help'   => 'Hiện cạnh khối AEF là gì trên desktop. Tắt = trang một cột.',
			'fields' => array(
				'about_fact_est_label'       => 'Nhãn năm khởi đầu',
				'about_fact_count'           => 'Số kỳ đã tổ chức',
				'about_fact_count_label'     => 'Nhãn số kỳ',
				'about_fact_city_label'      => 'Nhãn thành phố',
				'about_fact_venue_label'     => 'Nhãn địa điểm',
				'about_mail_general_label'   => 'Nhãn email chung',
				'about_mail_delegates_label' => 'Nhãn email đại biểu',
				'about_mail_press_label'     => 'Nhãn email báo chí',
				'about_facts_cta'            => 'Nút kỳ 2025',
			),
		),
	);
}

function aef_about_default_order() {
	return array( 'story', 'why', 'theme', 'aims', 'annual', 'hosts', 'editions' );
}

function aef_about_order() {
	$defs  = aef_about_block_defs();
	$saved = get_option( 'aef_about_order', array() );
	$out   = array();
	if ( is_array( $saved ) ) {
		foreach ( $saved as $id ) {
			$id = sanitize_key( $id );
			if ( isset( $defs[ $id ] ) && 'facts' !== $id && ! in_array( $id, $out, true ) ) {
				$out[] = $id;
			}
		}
	}
	foreach ( aef_about_default_order() as $id ) {
		if ( ! in_array( $id, $out, true ) ) {
			$out[] = $id;
		}
	}
	return $out;
}

function aef_about_block_on( $id ) {
	$all = aef_about_all();
	$key = 'about_block_' . $id;
	return ! isset( $all[ $key ] ) || '0' !== (string) $all[ $key ];
}

function aef_inner_defaults() {
	return array(
		'topics_eyebrow_en'  => 'AEF 2026',
		'topics_eyebrow_vi'  => 'AEF 2026',
		'topics_title_en'    => 'Four content pillars',
		'topics_title_vi'    => 'Bốn trụ cột nội dung',
		'topics_deck_en'     => 'Each pillar opens a set of policy questions and cooperation opportunities that run through the sessions and side events. The four pillars are a thinking frame, not four separate sessions.',
		'topics_deck_vi'     => 'Mỗi trụ cột mở ra một chuỗi câu hỏi chính sách và cơ hội hợp tác, được triển khai xuyên suốt các phiên thảo luận và hoạt động bên lề. Bốn trụ cột là khung tư duy, không phải bốn phiên riêng.',
		'topics_credit_en'   => 'Illustration',
		'topics_credit_vi'   => 'Minh họa',
		'topics_bg_id'       => '0',
		'partners_eyebrow_en' => 'AEF 2026',
		'partners_eyebrow_vi' => 'AEF 2026',
		'partners_title_en'   => 'Partners',
		'partners_title_vi'   => 'Đối tác',
		'partners_deck_en'    => 'Organisations accompanying AEF 2026. Appearance on this page does not by itself establish a sponsorship tier.',
		'partners_deck_vi'    => 'Các tổ chức đồng hành cùng AEF 2026. Việc xuất hiện trên trang không mặc nhiên xác lập thứ hạng tài trợ.',
		'partners_credit_en'  => 'Illustration',
		'partners_credit_vi'  => 'Minh họa',
		'partners_bg_id'      => '0',
	);
}

function aef_inner_all() {
	$saved = get_option( 'aef_inner', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	return array_merge( aef_inner_defaults(), $saved );
}

function aef_inner( $key ) {
	$all  = aef_inner_all();
	$lang = function_exists( 'aef_lang' ) ? aef_lang() : 'en';
	$try  = $key . '_' . $lang;
	if ( isset( $all[ $try ] ) && $all[ $try ] !== '' ) {
		return $all[ $try ];
	}
	return isset( $all[ $key ] ) ? $all[ $key ] : '';
}

function aef_inner_image( $slug, $fallback_file ) {
	$all = aef_inner_all();
	$id  = isset( $all[ $slug . '_bg_id' ] ) ? absint( $all[ $slug . '_bg_id' ] ) : 0;
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	return function_exists( 'aef_img' ) ? aef_img( $fallback_file ) : $fallback_file;
}

function aef_topics_block_defs() {
	return array(
		'p1' => array(
			'label' => '01 · Siêu đô thị',
			'help'  => 'Trụ cột 1. Ô tiêu đề trống = ẩn cả chương. Ảnh nền trống = giữ nền CSS.',
			'slug'  => 'megacities',
			'n'     => '01',
			'still' => 'visual/pillar-megacity.jpg',
		),
		'p2' => array(
			'label' => '02 · Công nghệ đột phá',
			'help'  => 'Trụ cột 2. Ô tiêu đề trống = ẩn cả chương. Ảnh nền trống = giữ nền CSS.',
			'slug'  => 'frontier-tech',
			'n'     => '02',
			'still' => 'visual/pillar-tech.jpg',
		),
		'p3' => array(
			'label' => '03 · Mô hình hợp tác',
			'help'  => 'Trụ cột 3. Ô tiêu đề trống = ẩn cả chương. Ảnh nền trống = giữ nền CSS.',
			'slug'  => 'cooperation',
			'n'     => '03',
			'still' => 'visual/pillar-cooperation.jpg',
		),
		'p4' => array(
			'label' => '04 · Khu vực tư nhân',
			'help'  => 'Trụ cột 4. Ô tiêu đề trống = ẩn cả chương. Ảnh nền trống = giữ nền CSS.',
			'slug'  => 'private-sector',
			'n'     => '04',
			'still' => 'visual/pillar-private.jpg',
		),
	);
}

function aef_topics_default_order() {
	return array( 'p1', 'p2', 'p3', 'p4' );
}

function aef_topics_defaults() {
	return array(
		'topics_eyebrow_en' => 'AEF 2026',
		'topics_eyebrow_vi' => 'AEF 2026',
		'topics_title_en'   => 'Four content pillars',
		'topics_title_vi'   => 'Bốn trụ cột nội dung',
		'topics_deck_en'    => 'Each pillar opens a set of policy questions and cooperation opportunities that run through the sessions and side events. The four pillars are a thinking frame, not four separate sessions.',
		'topics_deck_vi'    => 'Mỗi trụ cột mở ra một chuỗi câu hỏi chính sách và cơ hội hợp tác, được triển khai xuyên suốt các phiên thảo luận và hoạt động bên lề. Bốn trụ cột là khung tư duy, không phải bốn phiên riêng.',
		'topics_credit_en'  => 'Illustration',
		'topics_credit_vi'  => 'Minh họa',
		'topics_bg_id'      => '0',
		'topics_note_en'    => 'These four pillars frame the Forum. They are not four separate sessions.',
		'topics_note_vi'    => 'Bốn trụ cột là khung tư duy của Diễn đàn, không phải bốn phiên riêng.',
		'topics_qs_h_en'    => 'Guiding questions',
		'topics_qs_h_vi'    => 'Câu hỏi định hướng',
		'topics_sessions_cta_en' => 'See related sessions',
		'topics_sessions_cta_vi' => 'Xem các phiên liên quan',
		'topics_sessions_url'    => '/programme/',
		'topics_block_p1' => '1',
		'topics_block_p2' => '1',
		'topics_block_p3' => '1',
		'topics_block_p4' => '1',
		'p1_n' => '01',
		'p1_still_on' => '1',
		'p1_still_id' => '0',
		'p1_bg_id'    => '0',
		'p1_title_en' => 'The role of megacities',
		'p1_title_vi' => 'Vai trò của các siêu đô thị',
		'p1_short_en' => 'The megacity',
		'p1_short_vi' => 'Siêu đô thị',
		'p1_kicker_en' => 'Cities that now lead the new growth map',
		'p1_kicker_vi' => 'Những đô thị đang dẫn dắt bản đồ tăng trưởng mới',
		'p1_card_en' => 'Large cities concentrate capital, technology and skilled people. The Forum examines their role in growth, value chains and regional development.',
		'p1_card_vi' => 'Các đô thị lớn tập trung vốn, công nghệ và nhân lực. Diễn đàn bàn về vai trò của đô thị đối với tăng trưởng, chuỗi giá trị và phát triển vùng.',
		'p1_body_en' => 'As capital, technology, knowledge and skilled people concentrate in large urban centres, megacities are emerging as growth poles whose impact reaches beyond administrative borders. They are markets and production–service hubs, and also places where policy, technology and new development models are tested. At AEF 2026 the role of megacities is approached through how growth centres can cooperate rather than only compete; how infrastructure, finance, logistics, innovation and people can be connected; and how the gains of growth can spread to a wider urban region.',
		'p1_body_vi' => 'Khi các dòng vốn, công nghệ, tri thức và nhân lực chất lượng cao ngày càng tập trung tại các trung tâm đô thị lớn, siêu đô thị đang nổi lên như những cực tăng trưởng có khả năng tác động vượt ra ngoài ranh giới hành chính. Chúng vừa là thị trường, trung tâm sản xuất – dịch vụ, vừa là nơi thử nghiệm chính sách, công nghệ và các mô hình phát triển mới. Tại AEF 2026, vai trò của các siêu đô thị được tiếp cận từ câu hỏi làm thế nào các trung tâm tăng trưởng có thể hợp tác thay vì chỉ cạnh tranh; làm thế nào để kết nối hạ tầng, tài chính, logistics, đổi mới sáng tạo và nguồn nhân lực; và làm thế nào để thành quả tăng trưởng được lan tỏa tới vùng đô thị và khu vực rộng lớn hơn.',
		'p1_qs_en' => "What makes a megacity competitive in an era of technology and the green transition?\nHow can cities cooperate to form new growth corridors?\nHow can urban innovation create a spreading and inclusive effect?",
		'p1_qs_vi' => "Điều gì tạo nên năng lực cạnh tranh của một siêu đô thị trong kỷ nguyên công nghệ và chuyển đổi xanh?\nCác đô thị có thể hợp tác như thế nào để hình thành những hành lang tăng trưởng mới?\nLàm thế nào để đổi mới sáng tạo đô thị tạo ra tác động lan tỏa và bao trùm?",
		'p1_still_cap_en' => 'Illustration',
		'p1_still_cap_vi' => 'Minh họa',
		'p2_n' => '02',
		'p2_still_on' => '1',
		'p2_still_id' => '0',
		'p2_bg_id'    => '0',
		'p2_title_en' => 'Frontier technology and the innovation ecosystem',
		'p2_title_vi' => 'Công nghệ đột phá và hệ sinh thái đổi mới sáng tạo',
		'p2_short_en' => 'Frontier technology',
		'p2_short_vi' => 'Công nghệ đột phá',
		'p2_kicker_en' => 'From frontier technology to innovation capacity',
		'p2_kicker_vi' => 'Từ công nghệ đột phá đến năng lực đổi mới',
		'p2_card_en' => 'Artificial intelligence, quantum technology, advanced manufacturing and new industries. The Forum discusses how technology is applied in production, governance and competition.',
		'p2_card_vi' => 'Trí tuệ nhân tạo, công nghệ lượng tử, sản xuất tiên tiến và các ngành kinh tế mới. Diễn đàn thảo luận việc ứng dụng công nghệ trong sản xuất, quản trị và cạnh tranh.',
		'p2_body_en' => 'Artificial intelligence, automation, quantum technology, data and strategic technologies are changing production, governance and competition. Technology only creates a durable advantage when it sits in an ecosystem that can connect research, firms, capital, people and policy. This pillar focuses on the gap between owning technology and mastering innovation capacity. AEF 2026 aims to connect science and technology centres, startups, research institutes, universities, firms, investors and public authorities — not only to introduce trends, but to find cooperation models that move technology from research to use, from trial to scale, and from potential to real value.',
		'p2_body_vi' => 'Trí tuệ nhân tạo, tự động hóa, công nghệ lượng tử, dữ liệu và những công nghệ chiến lược đang làm thay đổi mô hình sản xuất, quản trị và cạnh tranh. Nhưng công nghệ chỉ tạo ra lợi thế bền vững khi được đặt trong một hệ sinh thái có khả năng kết nối nghiên cứu, doanh nghiệp, vốn, nhân lực và chính sách. Trụ cột này tập trung vào khoảng cách giữa sở hữu công nghệ và làm chủ năng lực đổi mới. AEF 2026 hướng tới kết nối các trung tâm khoa học – công nghệ, hệ sinh thái khởi nghiệp, viện nghiên cứu, trường đại học, doanh nghiệp, nhà đầu tư và cơ quan quản lý. Trọng tâm không chỉ là giới thiệu xu hướng, mà là tìm kiếm những mô hình hợp tác giúp công nghệ đi từ nghiên cứu tới ứng dụng, từ thử nghiệm tới quy mô, và từ tiềm năng tới giá trị thực tế.',
		'p2_qs_en' => "How can firms raise their capacity to absorb and master technology?\nWhich policies shorten the path from research to market?\nHow can innovation ecosystems connect across borders?\nHow does technological innovation travel with workforce development and social responsibility?",
		'p2_qs_vi' => "Làm thế nào để doanh nghiệp nâng cao năng lực hấp thụ và làm chủ công nghệ?\nChính sách nào giúp rút ngắn hành trình từ nghiên cứu tới thị trường?\nCác hệ sinh thái đổi mới có thể kết nối xuyên biên giới như thế nào?\nLàm thế nào để đổi mới công nghệ đi cùng phát triển nhân lực và trách nhiệm xã hội?",
		'p2_still_cap_en' => 'Illustration',
		'p2_still_cap_vi' => 'Minh họa',
		'p3_n' => '03',
		'p3_still_on' => '1',
		'p3_still_id' => '0',
		'p3_bg_id'    => '0',
		'p3_title_en' => 'Cooperation models in a new era',
		'p3_title_vi' => 'Các mô hình hợp tác trong kỷ nguyên mới',
		'p3_short_en' => 'New-era cooperation',
		'p3_short_vi' => 'Hợp tác kỷ nguyên mới',
		'p3_kicker_en' => 'New links for a multi-layer world',
		'p3_kicker_vi' => 'Những liên kết mới cho một thế giới đa tầng',
		'p3_card_en' => 'The Forum discusses cooperation among governments, localities, firms, international organisations and universities, including public–private and multilateral arrangements.',
		'p3_card_vi' => 'Diễn đàn thảo luận hợp tác giữa cơ quan nhà nước, địa phương, doanh nghiệp, tổ chức quốc tế và viện trường, gồm hợp tác công–tư và hợp tác đa phương.',
		'p3_body_en' => 'International economic cooperation is widening from relations among countries to multi-layer networks in which localities, cities, firms, international organisations, universities and specialist communities all take part. Challenges such as fragmented supply chains, the energy transition, data governance, responsible technology and workforce development do not sit inside one sector or one country. AEF 2026 focuses on cooperation models that can connect a global agenda with practical development needs — among cities, between research and firms, in public–private partnerships, and in cross-border programmes on technology, investment, finance and people.',
		'p3_body_vi' => 'Hợp tác kinh tế quốc tế đang mở rộng từ quan hệ giữa các quốc gia sang những mạng lưới đa tầng, nơi địa phương, đô thị, doanh nghiệp, tổ chức quốc tế, trường đại học và cộng đồng chuyên gia cùng tham gia. Những thách thức như phân mảnh chuỗi cung ứng, chuyển đổi năng lượng, quản trị dữ liệu, phát triển công nghệ có trách nhiệm hay xây dựng nguồn nhân lực không nằm gọn trong phạm vi của một ngành hoặc một quốc gia. AEF 2026 đặt trọng tâm vào các mô hình hợp tác có thể nối chương trình nghị sự toàn cầu với nhu cầu phát triển thực tiễn.',
		'p3_qs_en' => "Which cooperation model fits a world that is both connected and fragmented?\nHow is trust built and benefit shared among many actors?\nWhat mechanism lets an international initiative be delivered locally?",
		'p3_qs_vi' => "Mô hình hợp tác nào phù hợp với một thế giới vừa kết nối vừa phân mảnh?\nLàm thế nào để xây dựng lòng tin và phân bổ lợi ích giữa nhiều chủ thể?\nCơ chế nào giúp các sáng kiến quốc tế đi vào triển khai tại địa phương?",
		'p3_still_cap_en' => 'Illustration',
		'p3_still_cap_vi' => 'Minh họa',
		'p4_n' => '04',
		'p4_still_on' => '1',
		'p4_still_id' => '0',
		'p4_bg_id'    => '0',
		'p4_title_en' => 'The pioneering role of the private sector',
		'p4_title_vi' => 'Vai trò tiên phong của khu vực tư nhân',
		'p4_short_en' => 'The private sector',
		'p4_short_vi' => 'Khu vực tư nhân',
		'p4_kicker_en' => 'From participant to a force that leads growth',
		'p4_kicker_vi' => 'Từ người tham gia đến lực lượng dẫn dắt tăng trưởng',
		'p4_card_en' => 'Firms take part in technology, investment and market development. The Forum places the private sector in the working sessions of AEF 2026.',
		'p4_card_vi' => 'Doanh nghiệp tham gia công nghệ, đầu tư và phát triển thị trường. Diễn đàn đưa khu vực tư nhân vào các phiên làm việc của AEF 2026.',
		'p4_body_en' => 'The private sector is where much innovation is tested, resources are mobilised and market opportunities become products, services and jobs. That pioneering role shows in long-term investment, new business models, technology use, workforce development and new linkages. It is also the bridge between policy discussion and market practice: only when firms can deliver, measure and scale do ideas about green growth, digital transition or innovation create a real effect. AEF 2026 gives firms, investors, financial institutions and partners a space to talk directly with the public sector and specialists — to identify barriers, widen cooperation and help form initiatives that can continue after the Forum.',
		'p4_body_vi' => 'Khu vực tư nhân là nơi nhiều đổi mới được thử nghiệm, nguồn lực được huy động và các cơ hội thị trường được chuyển hóa thành sản phẩm, dịch vụ và việc làm. Vai trò tiên phong ấy thể hiện ở năng lực đầu tư dài hạn, đổi mới mô hình kinh doanh, ứng dụng công nghệ, phát triển nhân lực và hình thành các chuỗi liên kết mới. AEF 2026 tạo không gian để doanh nghiệp, nhà đầu tư, định chế tài chính và các đối tác trao đổi trực tiếp với khu vực công và giới chuyên gia. Mục tiêu là nhận diện những rào cản, mở rộng cơ hội hợp tác và thúc đẩy hình thành các sáng kiến, dự án có khả năng tiếp tục sau Diễn đàn.',
		'p4_qs_en' => "What conditions do firms need to invest in new growth engines?\nHow can the public and private sectors share risk, resources and delivery capacity?\nHow can Vietnamese firms go deeper into new value chains?",
		'p4_qs_vi' => "Doanh nghiệp cần điều kiện gì để đầu tư vào những động lực tăng trưởng mới?\nKhu vực công và tư có thể chia sẻ rủi ro, nguồn lực và năng lực triển khai ra sao?\nLàm thế nào để doanh nghiệp Việt Nam tham gia sâu hơn vào các chuỗi giá trị mới?",
		'p4_still_cap_en' => 'Illustration',
		'p4_still_cap_vi' => 'Minh họa',
	);
}

function aef_topics_all() {
	$saved = get_option( 'aef_topics', false );
	$inherit = false;
	if ( false === $saved || ! is_array( $saved ) ) {
		$saved   = array();
		$inherit = true;
	}
	$all = array_merge( aef_topics_defaults(), $saved );
	if ( $inherit && function_exists( 'aef_inner_all' ) ) {
		$inner = aef_inner_all();
		foreach ( array( 'topics_eyebrow_en', 'topics_eyebrow_vi', 'topics_title_en', 'topics_title_vi', 'topics_deck_en', 'topics_deck_vi', 'topics_credit_en', 'topics_credit_vi', 'topics_bg_id' ) as $k ) {
			if ( isset( $inner[ $k ] ) && '' !== (string) $inner[ $k ] && '0' !== (string) $inner[ $k ] ) {
				$all[ $k ] = $inner[ $k ];
			}
		}
	}
	return $all;
}

function aef_topics( $key ) {
	$all  = aef_topics_all();
	$lang = function_exists( 'aef_lang' ) ? aef_lang() : 'en';
	$try  = $key . '_' . $lang;
	if ( isset( $all[ $try ] ) && $all[ $try ] !== '' ) {
		return $all[ $try ];
	}
	return isset( $all[ $key ] ) ? $all[ $key ] : '';
}

function aef_topics_pair( $base ) {
	$all = aef_topics_all();
	$en  = isset( $all[ $base . '_en' ] ) ? (string) $all[ $base . '_en' ] : '';
	$vi  = isset( $all[ $base . '_vi' ] ) ? (string) $all[ $base . '_vi' ] : '';
	if ( '' === $en && '' !== $vi ) {
		$en = $vi;
	}
	if ( '' === $vi && '' !== $en ) {
		$vi = $en;
	}
	return array(
		'en' => $en,
		'vi' => $vi,
	);
}

function aef_topics_lines( $key ) {
	$all = aef_topics_all();
	$raw = isset( $all[ $key ] ) ? (string) $all[ $key ] : '';
	if ( '' === trim( $raw ) ) {
		return array();
	}
	$parts = preg_split( '/\r\n|\r|\n/', $raw );
	$out   = array();
	foreach ( $parts as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$out[] = $line;
		}
	}
	return $out;
}

function aef_topics_bg( $key ) {
	$all = aef_topics_all();
	$id  = isset( $all[ $key ] ) ? absint( $all[ $key ] ) : 0;
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	return '';
}

function aef_topics_image( $key, $fallback_file ) {
	$all = aef_topics_all();
	$id  = isset( $all[ $key ] ) ? absint( $all[ $key ] ) : 0;
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'large' );
		if ( $url ) {
			return $url;
		}
	}
	return function_exists( 'aef_img' ) ? aef_img( $fallback_file ) : $fallback_file;
}

function aef_topics_order() {
	$defs  = aef_topics_block_defs();
	$saved = get_option( 'aef_topics_order', array() );
	$out   = array();
	if ( is_array( $saved ) ) {
		foreach ( $saved as $id ) {
			$id = sanitize_key( $id );
			if ( isset( $defs[ $id ] ) && ! in_array( $id, $out, true ) ) {
				$out[] = $id;
			}
		}
	}
	foreach ( aef_topics_default_order() as $id ) {
		if ( ! in_array( $id, $out, true ) ) {
			$out[] = $id;
		}
	}
	return $out;
}

function aef_topics_block_on( $id ) {
	$all = aef_topics_all();
	$key = 'topics_block_' . $id;
	return ! isset( $all[ $key ] ) || '0' !== (string) $all[ $key ];
}

function aef_topics_still_on( $id ) {
	$all = aef_topics_all();
	$key = $id . '_still_on';
	return ! isset( $all[ $key ] ) || '0' !== (string) $all[ $key ];
}

function aef_chrome_defaults() {
	return array(
		'ribbon_on'       => '0',
		'ribbon_tag_en'   => '',
		'ribbon_tag_vi'   => '',
		'ribbon_text_en'  => '',
		'ribbon_text_vi'  => '',
		'ribbon_link'     => '/programme/',
		'ribbon_cta_en'   => 'Details',
		'ribbon_cta_vi'   => 'Chi tiết',
		'util_on'         => '1',
		'util_label_en'   => 'HCMC C4IR',
		'util_label_vi'   => 'Trung tâm C4IR TP.HCM',
		'util_short'      => 'C4IR',
		'util_url'        => '/about/',
		'cta_on'          => '1',
		'cta_label_en'    => 'Register',
		'cta_label_vi'    => 'Đăng ký',
		'cta_url'         => '/2026/delegates/how-to-register/',
		'menu_label_en'   => 'Menu',
		'menu_label_vi'   => 'Menu',
		'close_label_en'  => 'Close',
		'close_label_vi'  => 'Đóng',
		'footer_blurb_en' => 'Ho Chi Minh City’s annual platform for international economic dialogue.',
		'footer_blurb_vi' => 'Nền tảng đối thoại kinh tế quốc tế thường niên của Thành phố Hồ Chí Minh.',
		'footer_contact'  => 'aef.vn · contact@aef.vn',
		'footer_copy_en'  => '© 2026 Autumn Economic Forum · HCMC C4IR',
		'footer_copy_vi'  => '© 2026 Diễn đàn Kinh tế Mùa thu · HCMC C4IR',
		'footer_legal_en' => 'Terms of use · Personal data protection · Cookie policy',
		'footer_legal_vi' => 'Điều khoản sử dụng · Bảo vệ dữ liệu cá nhân · Chính sách cookie',
		'footer_h1_en'    => 'AEF 2026',
		'footer_h1_vi'    => 'AEF 2026',
		'footer_h2_en'    => 'Attend',
		'footer_h2_vi'    => 'Tham dự',
		'footer_h3_en'    => 'Institutional',
		'footer_h3_vi'    => 'Thông tin chung',
		'nav'             => array(
			array( 'on' => '1', 'url' => '/about/', 'en' => 'About', 'vi' => 'Giới thiệu' ),
			array( 'on' => '1', 'url' => '/programme/', 'en' => 'Programme', 'vi' => 'Chương trình' ),
			array( 'on' => '1', 'url' => '/speakers/', 'en' => 'Speakers', 'vi' => 'Diễn giả' ),
			array( 'on' => '1', 'url' => '/2026/media/', 'en' => 'Media', 'vi' => 'Truyền thông' ),
			array( 'on' => '1', 'url' => '/travel/', 'en' => 'Travel', 'vi' => 'Cẩm nang' ),
			array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' ),
			array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' ),
			array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' ),
			array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' ),
			array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' ),
			array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' ),
			array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' ),
		),
		'legal'           => array(
			array( 'on' => '1', 'url' => '/terms-of-use/', 'en' => 'Terms of use', 'vi' => 'Điều khoản sử dụng' ),
			array( 'on' => '1', 'url' => '/privacy-policy/', 'en' => 'Personal data protection', 'vi' => 'Bảo vệ dữ liệu cá nhân' ),
			array( 'on' => '1', 'url' => '/cookie-policy/', 'en' => 'Cookie policy', 'vi' => 'Chính sách cookie' ),
			array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' ),
		),
		'visit'           => array(
			array( 'on' => '1', 'url' => '/travel/', 'en' => 'Travel', 'vi' => 'Cẩm nang' ),
			array( 'on' => '1', 'url' => '/2026/delegates/how-to-register/', 'en' => 'How to register', 'vi' => 'Cách đăng ký' ),
			array( 'on' => '1', 'url' => '/about/', 'en' => 'HCMC C4IR', 'vi' => 'HCMC C4IR' ),
			array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' ),
		),
	);
}

function aef_chrome_all() {
	$saved = get_option( 'aef_chrome', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	$base = aef_chrome_defaults();
	$out  = array_merge( $base, $saved );
	if ( isset( $out['footer_h1_en'] ) && 'The Forum' === $out['footer_h1_en'] ) {
		$out['footer_h1_en'] = 'AEF 2026';
		$out['footer_h1_vi'] = 'AEF 2026';
	}
	if ( isset( $out['footer_h2_en'] ) && 'Visit' === $out['footer_h2_en'] ) {
		$out['footer_h2_en'] = 'Attend';
		$out['footer_h2_vi'] = 'Tham dự';
	}
	$out['nav']   = aef_chrome_pad( ! empty( $out['nav'] ) && is_array( $out['nav'] ) ? $out['nav'] : $base['nav'], 12 );
	$out['visit'] = aef_chrome_pad( ! empty( $out['visit'] ) && is_array( $out['visit'] ) ? $out['visit'] : $base['visit'], 4 );
	$out['legal'] = aef_chrome_pad( ! empty( $out['legal'] ) && is_array( $out['legal'] ) ? $out['legal'] : $base['legal'], 4 );
	return $out;
}

function aef_chrome_pad( $items, $n ) {
	if ( ! is_array( $items ) ) {
		$items = array();
	}
	$blank = array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' );
	while ( count( $items ) < $n ) {
		$items[] = $blank;
	}
	return array_values( $items );
}

function aef_chrome( $key ) {
	$all  = aef_chrome_all();
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

function aef_chrome_on( $key ) {
	$all = aef_chrome_all();
	return ! isset( $all[ $key ] ) || '0' !== (string) $all[ $key ];
}

function aef_chrome_href( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return home_url( '/' );
	}
	if ( preg_match( '#^https?://#i', $url ) ) {
		return $url;
	}
	return home_url( $url );
}

function aef_story_kinds() {
	return array(
		'news'     => array( 'en' => 'News', 'vi' => 'Tin tức' ),
		'press'    => array( 'en' => 'Press release', 'vi' => 'Thông cáo báo chí' ),
		'video'    => array( 'en' => 'Video', 'vi' => 'Video' ),
		'document' => array( 'en' => 'Document', 'vi' => 'Tài liệu / PDF' ),
	);
}

function aef_partner_tiers() {
	return array(
		'convening'    => array( 'en' => 'Convening', 'vi' => 'Chủ trì' ),
		'accompanying' => array( 'en' => 'Accompanying', 'vi' => 'Đồng hành' ),
		'media'        => array( 'en' => 'Media partner', 'vi' => 'Đối tác truyền thông' ),
		'other'        => array( 'en' => 'Other', 'vi' => 'Khác' ),
	);
}

function aef_video_html( $url, $file_id = 0 ) {
	$file_id = absint( $file_id );
	if ( $file_id ) {
		$src  = wp_get_attachment_url( $file_id );
		$mime = get_post_mime_type( $file_id );
		if ( $src ) {
			$type = $mime ? $mime : 'video/mp4';
			return '<div class="aef-video"><video class="aef-player" controls preload="metadata" playsinline><source src="' . esc_url( $src ) . '" type="' . esc_attr( $type ) . '"></video></div>';
		}
	}
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}
	if ( preg_match( '~(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([A-Za-z0-9_-]{6,})~', $url, $m ) ) {
		return '<div class="aef-video"><iframe src="https://www.youtube.com/embed/' . esc_attr( $m[1] ) . '" title="Video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe></div>';
	}
	if ( preg_match( '~vimeo\.com/(?:video/)?([0-9]+)~', $url, $m ) ) {
		return '<div class="aef-video"><iframe src="https://player.vimeo.com/video/' . esc_attr( $m[1] ) . '" title="Video" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen loading="lazy"></iframe></div>';
	}
	if ( false !== strpos( $url, 'facebook.com' ) || false !== strpos( $url, 'fb.watch' ) ) {
		return '<div class="aef-video"><iframe src="https://www.facebook.com/plugins/video.php?href=' . rawurlencode( $url ) . '&show_text=0" title="Facebook video" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe></div>';
	}
	if ( preg_match( '~\.(mp4|webm|ogg)(\?|$)~i', $url ) ) {
		return '<div class="aef-video"><video class="aef-player" controls preload="metadata" playsinline src="' . esc_url( $url ) . '"></video></div>';
	}
	return '';
}

function aef_partner_logo_src( $id, $size = 'medium' ) {
	$id   = absint( $id );
	$logo = $id ? get_the_post_thumbnail_url( $id, $size ) : '';
	if ( ! $logo && $id ) {
		$logo = get_post_meta( $id, 'logo_url', true );
	}
	return $logo ? (string) $logo : '';
}

function aef_home_partner_logos() {
	$q = new WP_Query(
		array(
			'post_type'      => 'aef_partner',
			'posts_per_page' => 80,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		)
	);
	$out = array();
	while ( $q->have_posts() ) {
		$q->the_post();
		$id = get_the_ID();
		if ( '0' === (string) get_post_meta( $id, 'carousel_on', true ) ) {
			continue;
		}
		$logo = aef_partner_logo_src( $id );
		if ( ! $logo ) {
			continue;
		}
		$out[] = array(
			'id'   => $id,
			'name' => function_exists( 'aef_bilingual_title' ) ? aef_bilingual_title( $id ) : get_the_title(),
			'logo' => $logo,
			'url'  => get_post_meta( $id, 'url', true ),
		);
	}
	wp_reset_postdata();
	return $out;
}

function aef_partners_by_tier() {
	$q = new WP_Query(
		array(
			'post_type'      => 'aef_partner',
			'posts_per_page' => 80,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		)
	);
	$grouped = array();
	foreach ( array_keys( aef_partner_tiers() ) as $tier ) {
		$grouped[ $tier ] = array();
	}
	while ( $q->have_posts() ) {
		$q->the_post();
		$id   = get_the_ID();
		$tier = get_post_meta( $id, 'tier', true );
		if ( ! isset( $grouped[ $tier ] ) ) {
			$tier = 'other';
		}
		$logo = aef_partner_logo_src( $id );
		$grouped[ $tier ][] = array(
			'id'   => $id,
			'name' => function_exists( 'aef_bilingual_title' ) ? aef_bilingual_title( $id ) : get_the_title(),
			'logo' => $logo,
			'url'  => get_post_meta( $id, 'url', true ),
		);
	}
	wp_reset_postdata();
	return $grouped;
}

function aef_pdf_html( $file_id, $label = '' ) {
	$file_id = absint( $file_id );
	if ( ! $file_id ) {
		return '';
	}
	$src = wp_get_attachment_url( $file_id );
	if ( ! $src ) {
		return '';
	}
	if ( ! $label ) {
		$label = 'PDF';
	}
	return '<div class="aef-pdf"><iframe src="' . esc_url( $src ) . '#view=FitH" title="' . esc_attr( $label ) . '"></iframe><p><a class="btn btn-b" href="' . esc_url( $src ) . '" target="_blank" rel="noopener">' . esc_html( $label ) . '</a></p></div>';
}

function aef_chrome_links( $group ) {
	$all   = aef_chrome_all();
	$items = isset( $all[ $group ] ) && is_array( $all[ $group ] ) ? $all[ $group ] : array();
	$out   = array();
	foreach ( $items as $it ) {
		if ( empty( $it['on'] ) || empty( $it['url'] ) ) {
			continue;
		}
		$out[] = $it;
	}
	return $out;
}

function aef_person_roles() {
	return array(
		'chair'     => array( 'en' => 'Chair', 'vi' => 'Chủ trì' ),
		'co_chair'  => array( 'en' => 'Co-chair', 'vi' => 'Đồng chủ trì' ),
		'keynote'   => array( 'en' => 'Keynote', 'vi' => 'Phát biểu đề dẫn' ),
		'welcome'   => array( 'en' => 'Welcome remarks', 'vi' => 'Phát biểu chào mừng' ),
		'dialogue'  => array( 'en' => 'Dialogue', 'vi' => 'Đối thoại' ),
		'presenter' => array( 'en' => 'Presenter', 'vi' => 'Tham luận' ),
		'moderator' => array( 'en' => 'Moderator', 'vi' => 'Điều phối viên' ),
		'panelist'  => array( 'en' => 'Panelist', 'vi' => 'Diễn giả tọa đàm' ),
		'speaker'   => array( 'en' => 'Speaker', 'vi' => 'Diễn giả' ),
		'closing'   => array( 'en' => 'Closing remarks', 'vi' => 'Phát biểu cảm ơn / bế mạc' ),
	);
}

function aef_session_role_plan( $session_id ) {
	$slug = get_post_field( 'post_name', $session_id );
	$map  = array(
		'27-oct-opening'        => array( 'welcome' ),
		'high-level-plenary'    => array( 'chair', 'keynote', 'welcome', 'speaker' ),
		'pm-dialogue'           => array( 'chair', 'dialogue' ),
		'ministerial-dialogue'  => array( 'chair', 'keynote', 'presenter', 'panelist', 'closing' ),
		'official-reception'    => array( 'chair' ),
		'business-networking-dinner' => array( 'speaker' ),
		'gala-dinner'           => array(),
		'rising-star-arena'     => array( 'speaker' ),
		'ceo-500-tea-connect'   => array( 'chair', 'keynote', 'speaker' ),
	);
	if ( isset( $map[ $slug ] ) ) {
		return $map[ $slug ];
	}
	$room = (string) get_post_meta( $session_id, 'room', true );
	if ( preg_match( '/Phòng\s*0?[123]|Room\s*0?[123]/iu', $room ) ) {
		return array( 'moderator', 'panelist' );
	}
	return array( 'speaker' );
}

function aef_speaker_portrait_url( $speaker_id, $size = 'medium_large' ) {
	$u = get_the_post_thumbnail_url( $speaker_id, $size );
	if ( $u ) {
		return $u;
	}
	$file = get_post_meta( $speaker_id, 'mock_portrait', true );
	if ( ! $file ) {
		$slug = get_post_field( 'post_name', $speaker_id );
		$file = $slug ? $slug . '.jpg' : '';
	}
	$file = $file ? basename( (string) $file ) : '';
	if ( ! $file || ! preg_match( '/^[a-z0-9._-]+\.(jpe?g|png|webp)$/i', $file ) ) {
		return '';
	}
	$path = get_template_directory() . '/assets/speakers/' . $file;
	if ( ! file_exists( $path ) ) {
		return '';
	}
	return get_template_directory_uri() . '/assets/speakers/' . rawurlencode( $file );
}

function aef_speaker_credit( $speaker_id ) {
	$lang = function_exists( 'aef_lang' ) ? aef_lang() : 'en';
	$title = 'vi' === $lang
		? aef_meta( $speaker_id, 'role_vi', aef_meta( $speaker_id, 'role_en' ) )
		: aef_meta( $speaker_id, 'role_en', aef_meta( $speaker_id, 'role_vi' ) );
	$org = 'vi' === $lang
		? aef_meta( $speaker_id, 'org_vi', aef_meta( $speaker_id, 'org_en' ) )
		: aef_meta( $speaker_id, 'org_en', aef_meta( $speaker_id, 'org_vi' ) );
	$title = trim( (string) $title );
	$org   = trim( (string) $org );
	if ( $title && $org ) {
		return $title . ' — ' . $org;
	}
	return $title ? $title : $org;
}

function aef_person_role_label( $role ) {
	$roles = aef_person_roles();
	$role  = sanitize_key( (string) $role );
	if ( ! isset( $roles[ $role ] ) ) {
		$role = 'panelist';
	}
	return function_exists( 'aef_t' ) ? aef_t( $roles[ $role ] ) : $roles[ $role ]['en'];
}

function aef_session_people( $session_id ) {
	$raw = get_post_meta( $session_id, 'aef_people', true );
	if ( is_string( $raw ) && $raw ) {
		$decoded = json_decode( $raw, true );
		$raw     = is_array( $decoded ) ? $decoded : array();
	}
	if ( ! is_array( $raw ) ) {
		$raw = array();
	}
	$out = array();
	$seen = array();
	foreach ( $raw as $row ) {
		$id = isset( $row['id'] ) ? absint( $row['id'] ) : 0;
		if ( ! $id || isset( $seen[ $id ] ) || 'aef_speaker' !== get_post_type( $id ) || 'publish' !== get_post_status( $id ) ) {
			continue;
		}
		$role = isset( $row['role'] ) ? sanitize_key( $row['role'] ) : 'panelist';
		if ( ! isset( aef_person_roles()[ $role ] ) ) {
			$role = 'panelist';
		}
		$seen[ $id ] = true;
		$out[]       = array(
			'id'   => $id,
			'role' => $role,
		);
	}
	return $out;
}

function aef_session_people_grouped( $session_id ) {
	$out = array();
	foreach ( array_keys( aef_person_roles() ) as $role ) {
		$out[ $role ] = array();
	}
	foreach ( aef_session_people( $session_id ) as $row ) {
		$out[ $row['role'] ][] = $row;
	}
	return $out;
}

function aef_speaker_sessions( $speaker_id ) {
	$speaker_id = absint( $speaker_id );
	if ( ! $speaker_id ) {
		return array();
	}
	$q = new WP_Query(
		array(
			'post_type'      => 'aef_session',
			'posts_per_page' => 80,
			'post_status'    => 'publish',
			'meta_query'     => array(
				array(
					'key'     => 'aef_person',
					'value'   => $speaker_id,
					'compare' => '=',
				),
			),
			'orderby'        => 'meta_value',
			'meta_key'       => 'time',
			'order'          => 'ASC',
		)
	);
	$out = array();
	while ( $q->have_posts() ) {
		$q->the_post();
		$sid  = get_the_ID();
		$role = 'panelist';
		foreach ( aef_session_people( $sid ) as $row ) {
			if ( (int) $row['id'] === $speaker_id ) {
				$role = $row['role'];
				break;
			}
		}
		$out[] = array(
			'id'   => $sid,
			'role' => $role,
		);
	}
	wp_reset_postdata();
	return $out;
}

add_filter( 'wp_sitemaps_enabled', 'aef_sitemaps_enabled' );
add_filter( 'users_can_register', '__return_false' );
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'rest_authentication_errors', 'aef_rest_require_login' );
add_filter( 'rest_endpoints', 'aef_rest_lock_endpoints' );
add_action( 'init', 'aef_block_xmlrpc_request', 0 );
add_action( 'send_headers', 'aef_security_headers' );
add_action( 'template_redirect', 'aef_block_author_enum', 1 );
add_action( 'init', 'aef_harden_head' );

function aef_sitemaps_enabled() {
	if ( function_exists( 'aef_coming_on' ) && aef_coming_on() ) {
		return is_user_logged_in() && current_user_can( 'edit_pages' );
	}
	return true;
}

function aef_rest_require_login( $result ) {
	if ( true === $result || is_wp_error( $result ) ) {
		return $result;
	}
	if ( is_user_logged_in() ) {
		return $result;
	}
	return new WP_Error(
		'rest_cannot_access',
		'REST API is not available.',
		array( 'status' => 401 )
	);
}

function aef_rest_lock_endpoints( $endpoints ) {
	if ( ! function_exists( 'current_user_can' ) || ! current_user_can( 'list_users' ) ) {
		unset( $endpoints['/wp/v2/users'] );
		unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
}

function aef_block_xmlrpc_request() {
	if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
		status_header( 403 );
		header( 'Content-Type: text/plain; charset=UTF-8' );
		exit( 'Forbidden' );
	}
}

function aef_security_headers() {
	if ( headers_sent() ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
}

function aef_block_author_enum() {
	if ( is_admin() ) {
		return;
	}
	if ( is_author() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}

function aef_harden_head() {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
	add_filter( 'the_generator', '__return_empty_string' );
	add_filter( 'emoji_svg_url', '__return_false' );
	add_filter( 'wp_resource_hints', 'aef_resource_hints', 10, 2 );
}

function aef_resource_hints( $urls, $relation_type ) {
	$block = array( 'fonts.googleapis.com', 'fonts.gstatic.com', 's.w.org' );
	$out   = array();
	foreach ( (array) $urls as $url ) {
		$hay = is_array( $url ) ? ( isset( $url['href'] ) ? $url['href'] : '' ) : (string) $url;
		$skip = false;
		foreach ( $block as $host ) {
			if ( false !== strpos( $hay, $host ) ) {
				$skip = true;
				break;
			}
		}
		if ( ! $skip ) {
			$out[] = $url;
		}
	}
	return $out;
}

add_action( 'template_redirect', 'aef_handle_lang' );
function aef_handle_lang() {
	if ( isset( $_GET['lang'] ) && in_array( $_GET['lang'], array( 'vi', 'en' ), true ) ) {
		setcookie( 'aef_lang', $_GET['lang'], time() + YEAR_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), true );
	}
}

function aef_coming_defaults() {
	return array(
		'coming_on'              => '0',
		'coming_target'          => '2026-10-27T00:00:00+07:00',
		'coming_bg_id'           => '0',
		'coming_ribbon_id'       => '0',
		'coming_logo_id'         => '0',
		'coming_seal_id'         => '0',
		'coming_favicon_id'      => '0',
		'coming_show_seal'       => '1',
		'coming_show_logo'       => '1',
		'coming_show_ribbon'     => '1',
		'coming_show_count'      => '1',
		'coming_show_meta'       => '1',
		'coming_show_hosts'      => '1',
		'coming_show_foot'       => '1',
		'coming_title_en'        => 'AEF 2026 — Forthcoming',
		'coming_title_vi'        => 'AEF 2026 — Sắp ra mắt',
		'coming_desc_en'         => 'Autumn Economic Forum 2026 — Ho Chi Minh City, 27–28 October. The official public website is being prepared.',
		'coming_desc_vi'         => 'Diễn đàn Kinh tế Mùa thu 2026 — TP. Hồ Chí Minh, 27–28 tháng 10. Website công khai đang được hoàn thiện.',
		'coming_og_en'           => 'AEF 2026 — Autumn Economic Forum',
		'coming_og_vi'           => 'AEF 2026 — Diễn đàn Kinh tế Mùa thu',
		'coming_logo_alt_en'     => 'AEF 2026',
		'coming_logo_alt_vi'     => 'AEF 2026',
		'coming_seal_alt_en'     => "People's Committee of Ho Chi Minh City",
		'coming_seal_alt_vi'     => 'Ủy ban nhân dân Thành phố Hồ Chí Minh',
		'coming_kicker_en'       => 'Ho Chi Minh City · October 2026',
		'coming_kicker_vi'       => 'Thành phố Hồ Chí Minh · Tháng 10 năm 2026',
		'coming_event_en'        => 'Autumn Economic Forum',
		'coming_event_vi'        => 'Diễn đàn Kinh tế Mùa thu',
		'coming_year'            => '2026',
		'coming_pos_en'          => 'The Convergence Of New Global Growth Engines',
		'coming_pos_vi'          => 'Sự hội tụ của các cực tăng trưởng mới toàn cầu',
		'coming_theme_en'        => 'Collaboration in a New Era',
		'coming_theme_vi'        => 'Tinh thần hợp tác trong kỷ nguyên mới',
		'coming_when_en'         => 'Ho Chi Minh City · October 27–28',
		'coming_when_vi'         => 'Thành phố Hồ Chí Minh · 27–28 tháng 10',
		'coming_label_d_en'      => 'Days',
		'coming_label_d_vi'      => 'Ngày',
		'coming_label_h_en'      => 'Hours',
		'coming_label_h_vi'      => 'Giờ',
		'coming_label_m_en'      => 'Minutes',
		'coming_label_m_vi'      => 'Phút',
		'coming_label_s_en'      => 'Seconds',
		'coming_label_s_vi'      => 'Giây',
		'coming_count_cap_en'    => 'Until the main forum · 27 October 2026',
		'coming_count_cap_vi'    => 'Đến diễn đàn chính · 27 tháng 10 năm 2026',
		'coming_meta1_label_en'  => 'Forum week',
		'coming_meta1_label_vi'  => 'Tuần lễ',
		'coming_meta1_value'     => '26–29.10.2026',
		'coming_meta2_label_en'  => 'Main days',
		'coming_meta2_label_vi'  => 'Ngày chính',
		'coming_meta2_value'     => '27–28.10',
		'coming_meta3_label_en'  => 'City',
		'coming_meta3_label_vi'  => 'Thành phố',
		'coming_meta3_value_en'  => 'Ho Chi Minh City',
		'coming_meta3_value_vi'  => 'TP. Hồ Chí Minh',
		'coming_meta4_label_en'  => 'Venue',
		'coming_meta4_label_vi'  => 'Địa điểm',
		'coming_meta4_value_en'  => 'Thiskyhall, Sala',
		'coming_meta4_value_vi'  => 'Thiskyhall, Sala',
		'coming_host1_role_en'   => 'Directing authority',
		'coming_host1_role_vi'   => 'Cơ quan chỉ đạo',
		'coming_host1_name_en'   => 'Government of Viet Nam',
		'coming_host1_name_vi'   => 'Chính phủ Việt Nam',
		'coming_host2_role_en'   => 'Convening authority',
		'coming_host2_role_vi'   => 'Đơn vị chủ trì',
		'coming_host2_name_en'   => "People's Committee of Ho Chi Minh City",
		'coming_host2_name_vi'   => 'Ủy ban nhân dân Thành phố Hồ Chí Minh',
		'coming_host3_role_en'   => 'Implementing centre',
		'coming_host3_role_vi'   => 'Đơn vị thực hiện',
		'coming_host3_name_en'   => 'HCMC C4IR',
		'coming_host3_name_vi'   => 'HCMC C4IR',
		'coming_host4_role_en'   => '',
		'coming_host4_role_vi'   => '',
		'coming_host4_name_en'   => '',
		'coming_host4_name_vi'   => '',
		'coming_line_en'         => 'The official public website is being prepared.',
		'coming_line_vi'         => 'Website công khai đang được hoàn thiện.',
		'coming_status_en'       => 'Official site forthcoming',
		'coming_status_vi'       => 'Sắp mở website chính thức',
		'coming_mail'            => 'contact@aef.vn',
	);
}

function aef_coming_media( $key, $fallback ) {
	return aef_attachment_or_fallback( absint( aef_coming( $key ) ), $fallback );
}

function aef_copy_media( $key, $fallback ) {
	$all = aef_copy_all();
	$id  = isset( $all[ $key ] ) ? absint( $all[ $key ] ) : 0;
	return aef_attachment_or_fallback( $id, $fallback );
}

function aef_attachment_or_fallback( $id, $fallback ) {
	$id = absint( $id );
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
		if ( ! $url ) {
			$url = wp_get_attachment_url( $id );
		}
		if ( $url ) {
			return $url;
		}
	}
	return $fallback;
}

function aef_coming_on_flag( $key ) {
	$v = aef_coming( $key );
	return '' === $v || '1' === (string) $v;
}

function aef_coming_all() {
	$saved = get_option( 'aef_coming', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	$persist = false;
	foreach ( array( 'coming_pos_en', 'coming_pos_vi' ) as $key ) {
		if ( empty( $saved[ $key ] ) || ! is_string( $saved[ $key ] ) ) {
			continue;
		}
		$fixed = aef_unstick_copy( $saved[ $key ] );
		if ( $fixed !== $saved[ $key ] ) {
			$saved[ $key ] = $fixed;
			$persist         = true;
		}
	}
	if ( $persist ) {
		update_option( 'aef_coming', $saved );
	}
	return array_merge( aef_coming_defaults(), $saved );
}

function aef_coming( $key ) {
	$all  = aef_coming_all();
	$lang = function_exists( 'aef_lang' ) ? aef_lang() : 'en';
	$try  = $key . '_' . $lang;
	if ( isset( $all[ $try ] ) && $all[ $try ] !== '' ) {
		return $all[ $try ];
	}
	return isset( $all[ $key ] ) ? $all[ $key ] : '';
}

function aef_coming_on() {
	$all = aef_coming_all();
	return isset( $all['coming_on'] ) && '1' === (string) $all['coming_on'];
}

function aef_pretty_break( $text ) {
	if ( ! is_string( $text ) || '' === trim( $text ) ) {
		return '';
	}
	$text = aef_unstick_copy( $text );
	$nbsp  = "\xC2\xA0";
	$units = array(
		"People's Committee",
		'People’s Committee',
		'Ho Chi Minh City',
		'Thành phố Hồ Chí Minh',
		'TP. Hồ Chí Minh',
		'Ủy ban nhân dân',
		'The Convergence',
		'Sự hội tụ',
		'Of New Global Growth Engines',
		'of New Global Growth Engines',
		'New Global Growth Engines',
		'of Global Growth Poles',
		'Global Growth Poles',
		'của các cực tăng trưởng mới toàn cầu',
		'cực tăng trưởng mới toàn cầu',
		'của các cực tăng trưởng toàn cầu',
		'cực tăng trưởng toàn cầu',
		'Collaboration in a New Era',
		'in a New Era',
		'New Era',
		'Tinh thần hợp tác trong kỷ nguyên mới',
		'Tinh thần hợp tác',
		'trong kỷ nguyên mới',
		'kỷ nguyên mới',
		'World Economic Forum',
		'Government of Viet Nam',
		'Chính phủ Việt Nam',
		'Viet Nam',
		'Việt Nam',
		'HCMC C4IR',
		'Thiskyhall, Sala',
	);
	usort(
		$units,
		static function ( $a, $b ) {
			return mb_strlen( $b ) - mb_strlen( $a );
		}
	);
	$map = array();
	$i   = 0;
	foreach ( $units as $unit ) {
		if ( false === mb_stripos( $text, $unit ) ) {
			continue;
		}
		$token         = "\x02U" . $i . "\x03";
		$map[ $token ] = str_replace( ' ', $nbsp, $unit );
		$text          = preg_replace( '/' . preg_quote( $unit, '/' ) . '/u', $token, $text, 1 );
		$i++;
	}
	$words = preg_split( '/\s+/u', trim( $text ) );
	$func  = array( 'of', 'and', 'for', 'in', 'at', 'to', 'của', 'và', 'tại', 'ở', 'cho' );
	$out   = array();
	$n     = count( $words );
	for ( $j = 0; $j < $n; $j++ ) {
		$w   = $words[ $j ];
		$low = function_exists( 'mb_strtolower' ) ? mb_strtolower( $w ) : strtolower( $w );
		if ( 0 === $j ) {
			$out[] = $w;
			continue;
		}
		$last      = preg_replace( '/^[\x{00A0}\s]+/u', '', end( $out ) );
		$prev_unit = isset( $map[ $last ] );
		$this_unit = isset( $map[ $w ] );
		if ( $this_unit && $prev_unit ) {
			$out[] = ' ' . $w;
			continue;
		}
		if ( in_array( $low, $func, true ) && $j < $n - 1 ) {
			$out[] = ' ' . $w;
			continue;
		}
		$out[] = $nbsp . $w;
	}
	$html = implode( '', $out );
	foreach ( $map as $token => $unit ) {
		$html = str_replace( $token, $unit, $html );
	}
	return esc_html( $html );
}

function aef_unstick_copy( $text ) {
	if ( ! is_string( $text ) ) {
		return $text;
	}
	$text = trim( $text );
	if ( '' === $text ) {
		return $text;
	}
	$known = array(
		'The Convergence Of New Global Growth Engines',
		'The Convergence of New Global Growth Engines',
		'The Convergence of Global Growth Poles',
		'Sự hội tụ của các cực tăng trưởng mới toàn cầu',
		'Sự hội tụ của các cực tăng trưởng toàn cầu',
		'Collaboration in a New Era',
		'Tinh thần hợp tác trong kỷ nguyên mới',
	);
	$compact = preg_replace( '/\s+/u', '', $text );
	foreach ( $known as $full ) {
		if ( 0 === strcasecmp( $text, $full ) ) {
			return $full;
		}
		if ( $compact === preg_replace( '/\s+/u', '', $full ) ) {
			return $full;
		}
	}
	return $text;
}

function aef_stack_lines( $text ) {
	$text = is_string( $text ) ? trim( $text ) : '';
	if ( '' === $text ) {
		return array();
	}
	$text  = aef_unstick_copy( $text );
	$known = array(
		'The Convergence Of New Global Growth Engines' => array( 'The Convergence', 'Of New Global', 'Growth Engines' ),
		'The Convergence of New Global Growth Engines' => array( 'The Convergence', 'of New Global', 'Growth Engines' ),
		'The Convergence of Global Growth Poles'       => array( 'The Convergence of', 'Global', 'Growth Poles' ),
		'Sự hội tụ của các cực tăng trưởng mới toàn cầu' => array( 'Sự hội tụ của các', 'cực tăng trưởng mới', 'toàn cầu' ),
		'Sự hội tụ của các cực tăng trưởng toàn cầu'   => array( 'Sự hội tụ của các', 'cực tăng trưởng', 'toàn cầu' ),
		'Collaboration in a New Era'                   => array( 'Collaboration', 'in a New Era' ),
		'Tinh thần hợp tác trong kỷ nguyên mới'        => array( 'Tinh thần hợp tác', 'trong kỷ nguyên mới' ),
		'Nơi những động lực tăng trưởng mới gặp nhau'  => array( 'Nơi những động lực', 'tăng trưởng mới gặp nhau' ),
		'Where new growth engines meet'                 => array( 'Where new growth engines meet' ),
		'About the Autumn Economic Forum'              => array( 'About the', 'Autumn Economic Forum' ),
		'Về Diễn đàn Kinh tế Mùa thu'                  => array( 'Về Diễn đàn', 'Kinh tế Mùa thu' ),
	);
	foreach ( $known as $full => $lines ) {
		if ( 0 === strcasecmp( $text, $full ) ) {
			return $lines;
		}
	}
	return array( $text );
}

function aef_title_lines_html( $text, $tag = 'h2', $class = '' ) {
	$text  = is_string( $text ) ? trim( $text ) : '';
	$lines = function_exists( 'aef_stack_lines' ) ? aef_stack_lines( $text ) : array( $text );
	if ( ! $lines ) {
		$lines = array( $text );
	}
	$open = '<' . $tag . ( $class ? ' class="' . esc_attr( $class ) . '"' : '' ) . '>';
	$html = $open;
	if ( count( $lines ) > 1 ) {
		foreach ( $lines as $line ) {
			$html .= '<span>' . esc_html( $line ) . '</span>';
		}
	} else {
		$html .= esc_html( $text );
	}
	$html .= '</' . $tag . '>';
	return $html;
}

function aef_nbsp_protect( $text, $units = array() ) {
	$html = esc_html( is_string( $text ) ? $text : '' );
	if ( ! $html ) {
		return '';
	}
	usort(
		$units,
		static function ( $a, $b ) {
			return mb_strlen( $b ) - mb_strlen( $a );
		}
	);
	foreach ( $units as $unit ) {
		$safe = esc_html( $unit );
		$html = str_ireplace( $safe, str_replace( ' ', "\xC2\xA0", $safe ), $html );
	}
	return $html;
}

function aef_heading_html( $text ) {
	$text = is_string( $text ) ? $text : '';
	$text = preg_replace( '/<br\s*\/?>/i', '|', $text );
	$lines = preg_split( '/\s*\|\s*/u', $text );
	$protect = array(
		'leadership connection',
		'shared action',
		'kết nối lãnh đạo',
		'hành động chung',
		'The Convergence',
		'New Global Growth Engines',
		'Global Growth Poles',
		'New Era',
	);
	$html = '';
	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		if ( preg_match( '/^(.*)\*(.+)\*(.*)$/us', $line, $m ) ) {
			$inner = aef_nbsp_protect( $m[1], $protect ) . '<em>' . aef_nbsp_protect( $m[2], $protect ) . '</em>' . aef_nbsp_protect( $m[3], $protect );
		} else {
			$inner = aef_nbsp_protect( $line, $protect );
		}
		$html .= '<span class="line">' . $inner . '</span>';
	}
	return $html;
}

add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'aef_coming';
	$vars[] = 'aef_ref';
	return $vars;
} );

add_action( 'template_redirect', 'aef_cybertech_ref_gate', 19 );
function aef_cybertech_ref_gate() {
	if ( is_admin() ) {
		return;
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
	if ( preg_match( '#wp-login|wp-admin|wp-cron#', $uri ) ) {
		return;
	}
	$q = isset( $_GET['ref'] ) ? sanitize_key( wp_unslash( $_GET['ref'] ) ) : '';
	if ( 'cybertech' !== $q && 'cybertech' !== (string) get_query_var( 'aef_ref' ) ) {
		return;
	}
	$tpl = get_template_directory() . '/cybertech-ref.php';
	if ( file_exists( $tpl ) ) {
		status_header( 200 );
		nocache_headers();
		include $tpl;
		exit;
	}
}

add_action( 'template_redirect', 'aef_coming_gate', 20 );
function aef_coming_gate() {
	if ( is_admin() ) {
		return;
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
	if ( preg_match( '#wp-login|wp-admin|wp-cron#', $uri ) ) {
		return;
	}
	$force = isset( $_GET['coming'] ) && '1' === $_GET['coming'];
	$route = get_query_var( 'aef_coming' );
	if ( ! $force && '1' !== (string) $route && ! aef_coming_on() ) {
		return;
	}
	if ( ! $force && '1' !== (string) $route && is_user_logged_in() && current_user_can( 'edit_pages' ) ) {
		return;
	}
	$tpl = get_template_directory() . '/coming-soon.php';
	if ( file_exists( $tpl ) ) {
		status_header( 200 );
		include $tpl;
		exit;
	}
}

function aef_formal_scrub_text( $s ) {
	if ( ! is_string( $s ) || '' === $s ) {
		return $s;
	}
	$map = array(
		' (dự kiến)' => '',
		'(dự kiến)' => '',
		'khung chương trình dự thảo' => 'chương trình',
		'Khung chương trình dự thảo' => 'Chương trình',
		'trong khung chương trình dự thảo' => 'trong chương trình',
		'sẽ được thông báo sau khi phê duyệt' => 'do Ban Tổ chức thông báo',
		'will be announced after approval' => 'is announced by the Organising Committee',
		'cần đối chiếu với Đề án/Kế hoạch' => 'Thiskyhall',
		'Địa điểm dự kiến: Thiskyhall' => 'Thiskyhall',
		'Nhãn vai trò chỉnh tại Cài đặt → AEF 2026.' => '',
		'Trang này không dùng FAQ.' => '',
		'Tạm thời gửi ' => 'Liên hệ ',
		'Expected participants:' => 'Participants:',
		'Thành phần dự kiến:' => 'Thành phần:',
	);
	return str_replace( array_keys( $map ), array_values( $map ), $s );
}

function aef_apply_formal_copy() {
	$copy_keys = array(
		'home_hero_lead_en', 'home_hero_lead_vi',
		'home_intro_title_en', 'home_intro_title_vi', 'home_intro_lead_en', 'home_intro_lead_vi',
		'home_fig_2_en', 'home_fig_2_vi',
		'home_week_lead_en', 'home_week_lead_vi',
		'home_programme_lead_en', 'home_programme_lead_vi',
		'home_speakers_title_en', 'home_speakers_title_vi', 'home_speakers_lead_en', 'home_speakers_lead_vi',
		'home_speakers_cta_en', 'home_speakers_cta_vi',
		'home_side_lead_en', 'home_side_lead_vi',
		'home_close_title_en', 'home_close_title_vi', 'home_close_lead_en', 'home_close_lead_vi',
		'home_audience_title_en', 'home_audience_title_vi', 'home_audience_lead_en', 'home_audience_lead_vi',
	);
	$copy = aef_copy_all();
	$cdef = aef_default_copy();
	foreach ( $copy_keys as $k ) {
		if ( isset( $cdef[ $k ] ) ) {
			$copy[ $k ] = $cdef[ $k ];
		}
	}
	update_option( 'aef_copy', $copy );

	$about_keys = array(
		'about_deck_en', 'about_deck_vi', 'about_credit_en', 'about_credit_vi',
		'about_lead_en', 'about_lead_vi', 'about_body_en', 'about_body_vi',
		'about_figure_cap_en', 'about_figure_cap_vi',
		'about_hosts_p_en', 'about_hosts_p_vi',
	);
	$about = get_option( 'aef_about', array() );
	if ( ! is_array( $about ) ) {
		$about = array();
	}
	$adef = aef_about_defaults();
	foreach ( $about_keys as $k ) {
		if ( isset( $adef[ $k ] ) ) {
			$about[ $k ] = $adef[ $k ];
		}
	}
	update_option( 'aef_about', $about );

	if ( function_exists( 'aef_topics_defaults' ) ) {
		$topics = get_option( 'aef_topics', array() );
		if ( ! is_array( $topics ) ) {
			$topics = array();
		}
		$tdef = aef_topics_defaults();
		foreach ( array( 'p1_card_en', 'p1_card_vi', 'p2_card_en', 'p2_card_vi', 'p3_card_en', 'p3_card_vi', 'p4_card_en', 'p4_card_vi' ) as $k ) {
			if ( isset( $tdef[ $k ] ) ) {
				$topics[ $k ] = $tdef[ $k ];
			}
		}
		update_option( 'aef_topics', $topics );
	}

	$sessions = array(
		'official-reception' => array(
			'room' => 'Thành phố Hồ Chí Minh',
			'vi'   => 'Tiệc chiêu đãi do Lãnh đạo Chính phủ và Thành phố Hồ Chí Minh chủ trì, dành cho đại biểu theo thư mời của Ban Tổ chức.',
			'en'   => 'A reception hosted by the Government and the leadership of Ho Chi Minh City, for delegates invited by the Organising Committee.',
		),
		'business-networking-dinner' => array(
			'vi' => 'Tiệc tối kết nối doanh nghiệp tại Thiskyhall, dành cho đại biểu theo thư mời của Ban Tổ chức.',
			'en' => 'A business dinner at Thiskyhall, for delegates invited by the Organising Committee.',
		),
		'high-level-plenary' => array(
			'vi' => 'Phiên Toàn thể cấp cao với chủ đề Sự hội tụ của các cực tăng trưởng mới toàn cầu. Phiên dành cho toàn thể đại biểu; chương trình được truyền hình trực tiếp.',
			'en' => 'High-level plenary on the theme The Convergence of New Global Growth Engines. Open to all Forum delegates; the session is broadcast live.',
		),
		'ministerial-dialogue' => array(
			'vi' => 'Phiên dành cho toàn thể đại biểu. Nội dung gồm tham luận về các xu hướng toàn cầu và đối thoại giữa lãnh đạo cấp Bộ các nước về khung hợp tác trong kỷ nguyên mới.',
			'en' => 'Open to all Forum delegates. The session comprises presentations on global trends and a dialogue among ministerial-level leaders on cooperation in a new era.',
		),
		'27-oct-parallels' => array(
			'vi' => 'Ngày 27 tháng 10 gồm các phiên thảo luận chuyên đề tổ chức song song tại Thiskyhall.',
			'en' => '27 October comprises parallel thematic sessions at Thiskyhall.',
		),
	);
	foreach ( $sessions as $slug => $row ) {
		$p = get_page_by_path( $slug, OBJECT, 'aef_session' );
		if ( ! $p ) {
			continue;
		}
		if ( ! empty( $row['room'] ) ) {
			update_post_meta( $p->ID, 'room', $row['room'] );
		}
		update_post_meta( $p->ID, 'content_vi', $row['vi'] );
		update_post_meta( $p->ID, 'excerpt_vi', $row['vi'] );
		update_post_meta( $p->ID, 'content_en', $row['en'] );
		update_post_meta( $p->ID, 'excerpt_en', $row['en'] );
		update_post_meta( $p->ID, 'short_vi', $row['vi'] );
		update_post_meta( $p->ID, 'short_en', $row['en'] );
		update_post_meta( $p->ID, 'long_vi', $row['vi'] );
		update_post_meta( $p->ID, 'long_en', $row['en'] );
		wp_update_post( array( 'ID' => $p->ID, 'post_content' => $row['vi'], 'post_excerpt' => $row['vi'] ) );
	}

	$q = new WP_Query( array(
		'post_type'      => 'aef_session',
		'posts_per_page' => -1,
		'post_status'    => 'any',
	) );
	foreach ( $q->posts as $post ) {
		foreach ( array( 'content_vi', 'content_en', 'excerpt_vi', 'excerpt_en', 'room', 'title_en', 'title_vi', 'short_vi', 'short_en', 'long_vi', 'long_en' ) as $mk ) {
			$v = get_post_meta( $post->ID, $mk, true );
			$n = aef_formal_scrub_text( $v );
			if ( is_string( $v ) && $n !== $v ) {
				update_post_meta( $post->ID, $mk, $n );
			}
		}
		$body = aef_formal_scrub_text( $post->post_content );
		if ( $body !== $post->post_content ) {
			wp_update_post( array( 'ID' => $post->ID, 'post_content' => $body ) );
		}
	}
	wp_reset_postdata();
	return true;
}
