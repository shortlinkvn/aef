<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$s = aef_settings();
?>
<div class="page-about">
<?php
foreach ( aef_about_order() as $id ) {
	if ( ! aef_about_block_on( $id ) ) {
		continue;
	}
	$fn = 'aef_about_render_' . $id;
	if ( function_exists( $fn ) ) {
		$fn( $s );
	}
}
aef_about_render_oc_struct();
?>
</div>
<?php

function aef_about_band_open( $mod, $bg_key, $extra = '' ) {
	$bg  = function_exists( 'aef_about_bg' ) ? aef_about_bg( $bg_key ) : '';
	$cls = 'about-band about-' . $mod . $extra . ( $bg ? ' has-photo' : '' );
	echo '<section class="' . esc_attr( $cls ) . '">';
	if ( $bg ) {
		echo '<div class="blk-photo" style="background-image:url(\'' . esc_url( $bg ) . '\')"></div>';
	}
}

function aef_about_facts_items( $s ) {
	$items = array();
	if ( aef_about( 'about_fact_est' ) ) {
		$items[] = array( aef_about( 'about_fact_est_label' ), aef_about( 'about_fact_est' ) );
	}
	if ( aef_about( 'about_fact_count' ) ) {
		$items[] = array( aef_about( 'about_fact_count_label' ), aef_about( 'about_fact_count' ) );
	}
	$city = aef_t( array( 'en' => $s['city_en'], 'vi' => $s['city_vi'] ) );
	if ( $city ) {
		$items[] = array( aef_about( 'about_fact_city_label' ), $city );
	}
	$venue = aef_t( array( 'vi' => $s['venue_vi'], 'en' => $s['venue_en'] ) );
	if ( $venue ) {
		$items[] = array( aef_about( 'about_fact_venue_label' ), $venue );
	}
	$main = isset( $s['main_dates'] ) ? $s['main_dates'] : '27–28.10';
	$items[] = array(
		aef_t( array( 'en' => 'Main days', 'vi' => 'Ngày chính' ) ),
		$main . ' 2026',
	);
	return $items;
}

function aef_about_render_story( $s ) {
	$lead   = trim( (string) aef_about( 'about_lead' ) );
	$body   = trim( (string) aef_about( 'about_body' ) );
	$origin = trim( (string) aef_about( 'about_origin_p' ) );
	$quote  = trim( (string) aef_about( 'about_quote' ) );
	$fig    = aef_about_image( 'figure', 'visual/hcmc-dusk.jpg' );
	$cap    = trim( (string) aef_about( 'about_figure_cap' ) );
	$facts  = aef_about_block_on( 'facts' ) ? aef_about_facts_items( $s ) : array();
	if ( '' === $lead && '' === $body && '' === $origin && '' === $quote && ! $facts ) {
		return;
	}
	if ( $facts ) {
		echo '<section class="about-spec"><div class="shell about-spec-grid">';
		foreach ( $facts as $row ) {
			if ( ! $row[0] && ! $row[1] ) {
				continue;
			}
			echo '<div><small>' . esc_html( $row[0] ) . '</small><b>' . esc_html( $row[1] ) . '</b></div>';
		}
		echo '</div></section>';
	}
	aef_about_band_open( 'story', 'about_story_bg_id' );
	echo '<div class="shell about-story-grid">';
	echo '<div class="about-story-copy body-copy">';
	echo aef_paras_html( $lead, 'lead' );
	echo aef_paras_html( $body );
	echo aef_paras_html( $origin );
	if ( $quote ) {
		echo '<blockquote class="pullquote">' . esc_html( $quote ) . '</blockquote>';
	}
	$cta = trim( (string) aef_about( 'about_facts_cta' ) );
	if ( $cta ) {
		echo '<p class="about-band-more"><a class="text-link" href="' . esc_url( home_url( '/editions/2025/' ) ) . '">' . esc_html( $cta ) . ' →</a></p>';
	}
	echo '</div>';
	if ( $fig ) {
		echo '<figure class="about-story-fig"><img src="' . esc_url( $fig ) . '" alt="">';
		if ( $cap ) {
			echo '<figcaption>' . esc_html( $cap ) . '</figcaption>';
		}
		echo '</figure>';
	}
	echo '</div></section>';
}

function aef_about_render_why( $s ) {
	$chapters = array(
		array( aef_about( 'about_why_h' ), aef_about( 'about_why_p' ) ),
		array( aef_about( 'about_vn_h' ), aef_about( 'about_vn_p' ) ),
		array( aef_about( 'about_city_h' ), aef_about( 'about_city_p' ) ),
	);
	$has = false;
	foreach ( $chapters as $c ) {
		if ( trim( (string) $c[0] ) || trim( (string) $c[1] ) ) {
			$has = true;
			break;
		}
	}
	if ( ! $has ) {
		return;
	}
	aef_about_band_open( 'why', 'about_why_bg_id', ' mist' );
	echo '<div class="shell"><div class="about-why-list">';
	$n = 0;
	foreach ( $chapters as $c ) {
		$h = trim( (string) $c[0] );
		$p = trim( (string) $c[1] );
		if ( '' === $h && '' === $p ) {
			continue;
		}
		$n++;
		echo '<article class="about-chapter rv">';
		echo '<span class="about-why-n">' . esc_html( sprintf( '%02d', $n ) ) . '</span>';
		echo '<div class="about-chapter-body">';
		if ( $h ) {
			echo '<h2>' . esc_html( $h ) . '</h2>';
		}
		echo aef_paras_html( $p );
		echo '</div></article>';
	}
	echo '</div></div></section>';
}

function aef_about_render_theme( $s ) {
	$p        = trim( (string) aef_about( 'about_theme_p' ) );
	$theme_en = isset( $s['theme_en'] ) ? trim( (string) $s['theme_en'] ) : 'Collaboration in a New Era';
	$theme_vi = isset( $s['theme_vi'] ) ? trim( (string) $s['theme_vi'] ) : 'Tinh thần hợp tác trong kỷ nguyên mới';
	$title    = aef_lang() === 'vi' ? $theme_vi : $theme_en;
	$other    = aef_lang() === 'vi' ? $theme_en : $theme_vi;
	if ( '' === $title && '' === $p ) {
		return;
	}
	echo '<section class="home-theme-band about-theme-band on-dark">';
	echo '<div class="shell home-theme-lock rv">';
	echo '<p class="home-theme-kicker">' . esc_html( aef_t( array( 'en' => '2026 theme', 'vi' => 'Chủ đề 2026' ) ) ) . '</p>';
	if ( $title ) {
		echo function_exists( 'aef_title_lines_html' ) ? aef_title_lines_html( $title, 'h2', 'home-theme-title' ) : ( '<h2 class="home-theme-title">' . esc_html( $title ) . '</h2>' );
	}
	if ( $other && $other !== $title ) {
		echo '<p class="home-theme-en">' . esc_html( $other ) . '</p>';
	}
	echo '<span class="home-theme-rule" aria-hidden="true"></span>';
	if ( $p ) {
		echo '<div class="home-theme-body">' . aef_paras_html( $p ) . '</div>';
	}
	echo '</div></section>';
}

function aef_about_render_aims( $s ) {
	$values = array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$vh = trim( (string) aef_about( 'about_v' . $i . '_h' ) );
		if ( '' === $vh ) {
			continue;
		}
		$values[] = array( sprintf( '%02d', $i ), $vh, aef_about( 'about_v' . $i . '_p' ) );
	}
	$h   = trim( (string) aef_about( 'about_values_h' ) );
	$cta = trim( (string) aef_about( 'about_pillars_link' ) );
	if ( ! $h && ! $values ) {
		return;
	}
	aef_about_band_open( 'aims', 'about_aims_bg_id', ' mist' );
	echo '<div class="shell">';
	if ( $h ) {
		echo '<h2 class="about-band-title">' . esc_html( $h ) . '</h2>';
	}
	if ( $values ) {
		echo '<div class="place-grid about-value-grid">';
		foreach ( $values as $v ) {
			echo '<article class="place-card rv"><p class="edition-when">' . esc_html( $v[0] ) . '</p><h3>' . esc_html( $v[1] ) . '</h3><p>' . esc_html( $v[2] ) . '</p></article>';
		}
		echo '</div>';
	}
	if ( $cta ) {
		echo '<p class="about-band-more"><a class="text-link" href="' . esc_url( home_url( '/topics/' ) ) . '">' . esc_html( $cta ) . ' →</a></p>';
	}
	echo '</div></section>';
}

function aef_about_render_annual( $s ) {
	$h = trim( (string) aef_about( 'about_annual_h' ) );
	$p = trim( (string) aef_about( 'about_annual_p' ) );
	$items = array(
		array( aef_about( 'about_a1_h' ), aef_about( 'about_a1_p' ) ),
		array( aef_about( 'about_a2_h' ), aef_about( 'about_a2_p' ) ),
		array( aef_about( 'about_a3_h' ), aef_about( 'about_a3_p' ) ),
	);
	$has = false;
	foreach ( $items as $it ) {
		if ( trim( (string) $it[0] ) ) {
			$has = true;
			break;
		}
	}
	if ( ! $h && ! $has ) {
		return;
	}
	aef_about_band_open( 'annual', 'about_annual_bg_id' );
	echo '<div class="shell">';
	if ( $h ) {
		echo '<h2 class="about-band-title">' . esc_html( $h ) . '</h2>';
	}
	echo aef_paras_html( $p, 'lead' );
	echo '<div class="grid3 about-annual-grid">';
	foreach ( $items as $i => $it ) {
		if ( ! trim( (string) $it[0] ) ) {
			continue;
		}
		echo '<div class="card rv"><small>0' . intval( $i + 1 ) . '</small><h3>' . esc_html( $it[0] ) . '</h3><p>' . esc_html( $it[1] ) . '</p></div>';
	}
	echo '</div></div></section>';
}

function aef_about_render_hosts( $s ) {
	$h = trim( (string) aef_about( 'about_hosts_h' ) );
	$p = trim( (string) aef_about( 'about_hosts_p' ) );
	if ( '' === $h ) {
		$h = aef_t( array( 'en' => 'Organisation', 'vi' => 'Mô hình tổ chức' ) );
	}
	$host3_r = function_exists( 'aef_copy' ) ? trim( (string) aef_copy( 'home_hosts_3_role' ) ) : '';
	$host3_n = function_exists( 'aef_copy' ) ? trim( (string) aef_copy( 'home_hosts_3_name' ) ) : '';
	$host4_r = function_exists( 'aef_copy' ) ? trim( (string) aef_copy( 'home_hosts_4_role' ) ) : '';
	$host4_n = function_exists( 'aef_copy' ) ? trim( (string) aef_copy( 'home_hosts_4_name' ) ) : '';
	if ( '' === $host3_r ) {
		$host3_r = aef_t( array( 'en' => 'Implementing centre', 'vi' => 'Đơn vị thực hiện' ) );
	}
	if ( '' === $host3_n ) {
		$host3_n = 'HCMC C4IR';
	}
	$show_h4 = ( $host4_r || $host4_n ) && ! ( function_exists( 'aef_marks_wef' ) && ( aef_marks_wef( $host4_n ) || aef_marks_wef( $host4_r ) ) );
	aef_about_band_open( 'hosts', 'about_hosts_bg_id' );
	echo '<div class="shell">';
	echo '<h2 class="about-band-title">' . esc_html( $h ) . '</h2>';
	if ( $p ) {
		echo '<div class="about-hosts-p body-copy">' . aef_paras_html( $p ) . '</div>';
	}
	echo '<div class="inst-grid about-inst' . ( $show_h4 ? '' : ' inst-grid-3' ) . '">';
	echo '<div class="inst rv"><small>' . esc_html( aef_t( array( 'vi' => $s['host_1_role_vi'], 'en' => $s['host_1_role_en'] ) ) ) . '</small><div class="inst-mark inst-mark-text">VN</div><b>' . esc_html( aef_t( array( 'vi' => $s['host_1_name_vi'], 'en' => $s['host_1_name_en'] ) ) ) . '</b></div>';
	echo '<div class="inst rv"><small>' . esc_html( aef_t( array( 'vi' => $s['host_2_role_vi'], 'en' => $s['host_2_role_en'] ) ) ) . '</small><img src="' . esc_url( aef_logo( 'ubnd.png' ) ) . '" alt=""><b>' . esc_html( aef_t( array( 'vi' => $s['host_2_name_vi'], 'en' => $s['host_2_name_en'] ) ) ) . '</b></div>';
	echo '<div class="inst rv"><small>' . esc_html( $host3_r ) . '</small><img class="inst-c4ir" src="' . esc_url( aef_c4ir_mark() ) . '" alt="' . esc_attr( $host3_n ) . '" width="190" height="105"><b>' . esc_html( $host3_n ) . '</b></div>';
	if ( $show_h4 ) {
		echo '<div class="inst rv"><small>' . esc_html( $host4_r ) . '</small><b>' . esc_html( $host4_n ) . '</b></div>';
	}
	echo '</div></div></section>';
}

function aef_about_render_oc_struct() {
	echo '<section class="blk oc-struct" id="oc"><div class="shell">';
	echo '<p class="eyebrow">' . esc_html( aef_t( array( 'en' => 'Organising Committee', 'vi' => 'Ban Tổ chức' ) ) ) . '</p>';
	echo '<h2 class="about-band-title">' . esc_html( aef_t( array( 'en' => 'Structure by position', 'vi' => 'Cơ cấu theo chức danh' ) ) ) . '</h2>';
	echo '<p class="lead">' . esc_html( aef_t( array(
		'en' => 'The Organising Committee is established by the Ho Chi Minh City People’s Committee. Names are published after the founding decision.',
		'vi' => 'Ban Tổ chức do Ủy ban nhân dân Thành phố Hồ Chí Minh thành lập. Tên được công bố sau quyết định thành lập.',
	) ) ) . '</p>';
	$oc = array(
		array( '01', array( 'en' => 'Chair', 'vi' => 'Trưởng ban' ), array( 'en' => 'Chairman of the Ho Chi Minh City People’s Committee', 'vi' => 'Chủ tịch Ủy ban nhân dân Thành phố Hồ Chí Minh' ) ),
		array( '02', array( 'en' => 'Vice-Chairs', 'vi' => 'Phó Trưởng ban' ), array( 'en' => 'Three Vice-Chairs — composition to be confirmed', 'vi' => '03 Phó Trưởng ban — thành phần: Đang xác nhận' ) ),
		array( '03', array( 'en' => 'Members', 'vi' => 'Thành viên' ), array( 'en' => 'Representatives of central ministries, city departments and related agencies — list to be confirmed', 'vi' => 'Đại diện Bộ, ngành Trung ương, sở ban ngành Thành phố và đơn vị liên quan — danh sách: Đang xác nhận' ) ),
	);
	foreach ( $oc as $row ) {
		echo '<div class="ocrole"><span class="num">' . esc_html( $row[0] ) . '</span><div class="t"><b>' . esc_html( aef_t( $row[1] ) ) . '</b><span>' . esc_html( aef_t( $row[2] ) ) . '</span></div></div>';
	}
	echo '</div></section>';
}

function aef_about_render_editions( $s ) {
	$h = trim( (string) aef_about( 'about_editions_h' ) );
	if ( '' === $h ) {
		return;
	}
	$editions = function_exists( 'aef_editions_query' )
		? aef_editions_query( array( 'posts_per_page' => 12 ) )
		: new WP_Query( array( 'post_type' => 'aef_edition', 'posts_per_page' => 12, 'orderby' => 'name', 'order' => 'DESC' ) );
	aef_about_band_open( 'editions', 'about_editions_bg_id', ' mist' );
	echo '<div class="shell">';
	echo '<h2 class="about-band-title">' . esc_html( $h ) . '</h2>';
	echo '<div class="years">';
	while ( $editions->have_posts() ) {
		$editions->the_post();
		echo '<a class="year rv" href="' . esc_url( get_permalink() ) . '">';
		echo '<b>' . esc_html( aef_meta( get_the_ID(), 'year', get_the_title() ) ) . '</b>';
		echo '<div><h3>' . esc_html( aef_bilingual_title( get_the_ID() ) ) . '</h3></div>';
		echo '<span>' . esc_html( aef_lang() === 'en' ? aef_meta( get_the_ID(), 'note_en' ) : aef_meta( get_the_ID(), 'note_vi' ) ) . '</span>';
		echo '</a>';
	}
	wp_reset_postdata();
	echo '</div></div></section>';
	echo '<section class="about-close on-dark"><div class="shell">';
	echo '<h2>' . esc_html( aef_t( array( 'en' => 'Continue on the Forum', 'vi' => 'Tiếp tục với Diễn đàn' ) ) ) . '</h2>';
	echo '<p class="lead">' . esc_html( aef_t( array(
		'en' => 'Read the 27–28 October programme, or the Forum-week activities from 26 to 29 October.',
		'vi' => 'Xem chương trình 27–28/10, hoặc chuỗi tuần Diễn đàn từ 26 đến 29/10.',
	) ) ) . '</p>';
	echo '<div class="hact">';
	echo '<a class="btn btn-p" href="' . esc_url( home_url( '/programme/' ) ) . '">' . esc_html( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ) ) . '</a>';
	echo '<a class="btn btn-g" href="' . esc_url( aef_register_url() ) . '">' . esc_html( aef_t( array( 'en' => 'How to register', 'vi' => 'Cách đăng ký' ) ) ) . '</a>';
	echo '</div></div></section>';
}
