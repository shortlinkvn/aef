<?php
/**
 * Plugin Name: AEF 2026 Editor
 * Description: Hộp biên tập song ngữ EN/VI cho trang, phiên, diễn giả. Admin thay tên và ảnh mockup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'aef_register_metaboxes' );
function aef_register_metaboxes() {
	$types = array( 'page', 'aef_session', 'aef_speaker', 'aef_story', 'aef_support', 'aef_edition' );
	foreach ( $types as $type ) {
		add_meta_box( 'aef_i18n', 'AEF — English / Vietnamese', 'aef_i18n_box', $type, 'normal', 'high' );
	}
	add_meta_box( 'aef_speaker_profile', 'AEF — Speaker profile', 'aef_speaker_box', 'aef_speaker', 'side', 'high' );
	add_meta_box( 'aef_session_meta', 'AEF — Session details', 'aef_session_box', 'aef_session', 'side', 'high' );
}

function aef_field( $post_id, $key, $label, $type = 'text' ) {
	$val = get_post_meta( $post_id, $key, true );
	echo '<p><label><strong>' . esc_html( $label ) . '</strong><br>';
	if ( 'textarea' === $type ) {
		echo '<textarea name="' . esc_attr( $key ) . '" class="widefat" rows="5">' . esc_textarea( $val ) . '</textarea>';
	} else {
		echo '<input type="text" class="widefat" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '">';
	}
	echo '</label></p>';
}

function aef_i18n_box( $post ) {
	wp_nonce_field( 'aef_i18n', 'aef_i18n_nonce' );
	echo '<p>English is the public default. Vietnamese is the second language. The main editor above is the fallback title/body.</p>';
	echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">';
	echo '<div><h3>English</h3>';
	aef_field( $post->ID, 'title_en', 'Title (EN)' );
	aef_field( $post->ID, 'content_en', 'Body (EN)', 'textarea' );
	echo '</div><div><h3>Tiếng Việt</h3>';
	aef_field( $post->ID, 'title_vi', 'Tiêu đề (VI)' );
	aef_field( $post->ID, 'content_vi', 'Nội dung (VI)', 'textarea' );
	echo '</div></div>';
}

function aef_speaker_box( $post ) {
	wp_nonce_field( 'aef_spk', 'aef_spk_nonce' );
	aef_field( $post->ID, 'role_en', 'Category / role (EN)' );
	aef_field( $post->ID, 'role_vi', 'Nhóm / vai trò (VI)' );
	aef_field( $post->ID, 'org_en', 'Organisation (EN)' );
	aef_field( $post->ID, 'org_vi', 'Tổ chức (VI)' );
	aef_field( $post->ID, 'country', 'Country / Quốc gia' );
	$mock = get_post_meta( $post->ID, 'is_mockup', true );
	echo '<p><label><input type="checkbox" name="is_mockup" value="1"' . checked( $mock, '1', false ) . '> Demo mockup (hide real-name claim)</label></p>';
	echo '<p>Set the <strong>Featured image</strong> as the portrait. Admin replaces name, role and photo when confirmed.</p>';
}

function aef_session_box( $post ) {
	wp_nonce_field( 'aef_ses', 'aef_ses_nonce' );
	aef_field( $post->ID, 'session_id', 'Session ID (AEF27-R1-S1…)' );
	aef_field( $post->ID, 'kind', 'Kind / loại (Phiên chuyên đề, Sự kiện…)' );
	aef_field( $post->ID, 'date_label', 'Date label (27/10/2026)' );
	aef_field( $post->ID, 'time', 'Time' );
	aef_field( $post->ID, 'room', 'Room' );
	aef_field( $post->ID, 'access_en', 'Access (EN)' );
	aef_field( $post->ID, 'access_vi', 'Quyền tiếp cận (VI)' );
	aef_field( $post->ID, 'status', 'Status (up|live|rep|arc)' );
	aef_field( $post->ID, 'tags', 'Tags (comma-separated)' );
	aef_field( $post->ID, 'short_en', 'Short (EN)', 'textarea' );
	aef_field( $post->ID, 'short_vi', 'Tóm tắt (VI)', 'textarea' );
	aef_field( $post->ID, 'long_en', 'Context (EN)', 'textarea' );
	aef_field( $post->ID, 'long_vi', 'Bối cảnh (VI)', 'textarea' );
	aef_field( $post->ID, 'questions_en', 'Guiding questions EN (one per line)', 'textarea' );
	aef_field( $post->ID, 'questions_vi', 'Câu hỏi dẫn dắt VI (mỗi dòng một câu)', 'textarea' );
}

add_action( 'save_post', 'aef_save_metaboxes' );
function aef_save_metaboxes( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['aef_i18n_nonce'] ) && wp_verify_nonce( $_POST['aef_i18n_nonce'], 'aef_i18n' ) ) {
		foreach ( array( 'title_en', 'title_vi', 'content_en', 'content_vi' ) as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, wp_kses_post( wp_unslash( $_POST[ $key ] ) ) );
			}
		}
	}
	if ( isset( $_POST['aef_spk_nonce'] ) && wp_verify_nonce( $_POST['aef_spk_nonce'], 'aef_spk' ) ) {
		foreach ( array( 'role_en', 'role_vi', 'org_en', 'org_vi', 'country' ) as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
			}
		}
		update_post_meta( $post_id, 'is_mockup', empty( $_POST['is_mockup'] ) ? '' : '1' );
	}
	if ( isset( $_POST['aef_ses_nonce'] ) && wp_verify_nonce( $_POST['aef_ses_nonce'], 'aef_ses' ) ) {
		$text = array( 'session_id', 'kind', 'date_label', 'time', 'room', 'access_en', 'access_vi', 'status', 'tags' );
		foreach ( $text as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
			}
		}
		$areas = array( 'short_en', 'short_vi', 'long_en', 'long_vi', 'questions_en', 'questions_vi' );
		foreach ( $areas as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, wp_kses_post( wp_unslash( $_POST[ $key ] ) ) );
			}
		}
	}
}

add_action( 'admin_menu', 'aef_editor_menu' );
function aef_editor_menu() {
	add_menu_page( 'AEF Content', 'AEF Content', 'edit_pages', 'aef-content', 'aef_content_hub', 'dashicons-welcome-widgets-menus', 3 );
	add_submenu_page( 'aef-content', 'Trang chủ', 'Trang chủ', 'edit_pages', 'aef-home-blocks', 'aef_home_blocks_page' );
}

function aef_content_hub() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	if ( isset( $_POST['aef_seed_speakers'] ) && check_admin_referer( 'aef_seed_spk' ) ) {
		$n = aef_seed_speaker_mockups();
		echo '<div class="updated"><p>Speaker mockups ready (' . intval( $n ) . ' cards).</p></div>';
	}
	echo '<div class="wrap"><h1>AEF Content</h1>';
	echo '<p>Sửa câu chữ và bật/tắt khối ở <strong>Trang chủ</strong>. Ngày, chủ đề, host ở <strong>Kỳ 2026</strong>. Phiên / diễn giả / tin là từng bản ghi. Không kéo thả layout — thứ tự khối khóa theo yêu cầu thiết kế.</p>';
	echo '<p>';
	echo '<a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=aef-home-blocks' ) ) . '">Trang chủ — khối & câu chữ</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'options-general.php?page=aef-2026' ) ) . '">Ngày, chủ đề, host</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=aef_speaker' ) ) . '">Diễn giả</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=aef_session' ) ) . '">Phiên</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '">Trang</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=aef_story' ) ) . '">Tin / thông cáo</a>';
	echo '</p>';
	echo '<form method="post">';
	wp_nonce_field( 'aef_seed_spk' );
	submit_button( 'Tạo / làm mới thẻ diễn giả mẫu', 'secondary', 'aef_seed_speakers' );
	echo '</form></div>';
}

function aef_home_blocks_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	if ( isset( $_POST['aef_save_copy'] ) && check_admin_referer( 'aef_copy' ) ) {
		$defaults = aef_default_copy();
		$out      = array();
		foreach ( $defaults as $key => $fallback ) {
			if ( 0 === strpos( $key, 'block_' ) ) {
				$out[ $key ] = empty( $_POST[ $key ] ) ? '0' : '1';
			} elseif ( isset( $_POST[ $key ] ) ) {
				$out[ $key ] = wp_kses_post( wp_unslash( $_POST[ $key ] ) );
			} else {
				$out[ $key ] = $fallback;
			}
		}
		update_option( 'aef_copy', $out );
		echo '<div class="updated"><p>Đã lưu khối trang chủ.</p></div>';
	}
	$c      = aef_copy_all();
	$blocks = array(
		'hero'     => '1. Hero — tên, chủ đề, ngày, CTA',
		'theme'    => '2. Bốn trụ cột (hàng chuyên đề)',
		'hosts'    => '3. Vai trò tổ chức',
		'week'     => '4. Bốn lớp tuần lễ (25–30)',
		'journey'  => '5. Hành trình ba ngày 26–28',
		'featured' => '6. Sự kiện nổi bật',
		'outcomes' => '7. Từ đối thoại đến hành động',
		'audience' => '8. Nhóm người tham dự',
		'edition'  => '9. Kỳ 2025 — số liệu & ảnh',
		'speakers' => '10. Diễn giả (thẻ mẫu)',
		'partners' => '11. Đối tác (chờ xác nhận)',
		'support'  => '12. Hai cổng hỗ trợ',
	);
	$fields = array(
		'home_hero_cta1' => 'Hero — nút chương trình',
		'home_hero_cta2' => 'Hero — nút đăng ký',
		'home_meta_week' => 'Hero — nhãn tuần lễ',
		'home_meta_main' => 'Hero — nhãn diễn đàn chính',
		'home_meta_city' => 'Hero — nhãn thành phố',
		'home_week_eyebrow' => 'Tuần lễ — eyebrow',
		'home_week_title'   => 'Tuần lễ — tiêu đề',
		'home_week_lead'    => 'Tuần lễ — đoạn dẫn',
		'home_week_cta'     => 'Tuần lễ — nút',
		'home_edition_eyebrow' => 'Kỳ 2025 — eyebrow',
		'home_edition_title'   => 'Kỳ 2025 — tiêu đề',
		'home_edition_lead'    => 'Kỳ 2025 — đoạn dẫn',
		'home_speakers_eyebrow' => 'Diễn giả — eyebrow',
		'home_speakers_title'   => 'Diễn giả — tiêu đề',
		'home_speakers_lead'    => 'Diễn giả — đoạn dẫn',
		'home_support_eyebrow' => 'Hỗ trợ — eyebrow',
		'home_support_title'   => 'Hỗ trợ — tiêu đề',
		'home_support_lead'    => 'Hỗ trợ — đoạn dẫn',
	);
	echo '<div class="wrap"><h1>Trang chủ — khối & câu chữ</h1>';
	echo '<p>Thứ tự khối không đổi. Tắt khối chỉ ẩn trên trang chủ, không xóa dữ liệu. Chủ đề nguyên văn, ngày và host sửa ở <a href="' . esc_url( admin_url( 'options-general.php?page=aef-2026' ) ) . '">Cài đặt kỳ</a>.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'aef_copy' );
	echo '<h2>Hiển thị</h2><table class="form-table">';
	foreach ( $blocks as $id => $label ) {
		$key = 'block_' . $id;
		echo '<tr><th>' . esc_html( $label ) . '</th><td><label><input type="checkbox" name="' . esc_attr( $key ) . '" value="1"' . checked( $c[ $key ], '1', false ) . '> Hiện khối này</label></td></tr>';
	}
	echo '</table><h2>Câu chữ EN / VI</h2>';
	echo '<table class="form-table">';
	foreach ( $fields as $base => $label ) {
		echo '<tr><th>' . esc_html( $label ) . '</th><td>';
		echo '<p><input type="text" class="large-text" name="' . esc_attr( $base . '_en' ) . '" value="' . esc_attr( $c[ $base . '_en' ] ) . '" placeholder="English"></p>';
		echo '<p><input type="text" class="large-text" name="' . esc_attr( $base . '_vi' ) . '" value="' . esc_attr( $c[ $base . '_vi' ] ) . '" placeholder="Tiếng Việt"></p>';
		echo '</td></tr>';
	}
	echo '<tr><th>Số liệu kỳ 2025</th><td>';
	for ( $i = 1; $i <= 4; $i++ ) {
		echo '<p><input type="text" style="width:8em" name="home_stat_' . $i . '_n" value="' . esc_attr( $c[ 'home_stat_' . $i . '_n' ] ) . '"> ';
		echo '<input type="text" class="regular-text" name="home_stat_' . $i . '_en" value="' . esc_attr( $c[ 'home_stat_' . $i . '_en' ] ) . '" placeholder="EN"> ';
		echo '<input type="text" class="regular-text" name="home_stat_' . $i . '_vi" value="' . esc_attr( $c[ 'home_stat_' . $i . '_vi' ] ) . '" placeholder="VI"></p>';
	}
	echo '</td></tr></table>';
	submit_button( 'Lưu trang chủ', 'primary', 'aef_save_copy' );
	echo '</form></div>';
}

function aef_seed_speaker_mockups() {
	$cards = array(
		array( 'spk-gov-1', 'Government', 'Chính phủ', 'Senior government representative', 'Đại diện cấp cao khu vực nhà nước' ),
		array( 'spk-gov-2', 'Urban leadership', 'Quản trị đô thị', 'City leadership', 'Lãnh đạo đô thị' ),
		array( 'spk-intl-1', 'International organisation', 'Tổ chức quốc tế', 'Multilateral institution', 'Tổ chức đa phương' ),
		array( 'spk-intl-2', 'International organisation', 'Tổ chức quốc tế', 'Development partner', 'Đối tác phát triển' ),
		array( 'spk-biz-1', 'Private sector', 'Khu vực tư nhân', 'Enterprise leadership', 'Lãnh đạo doanh nghiệp' ),
		array( 'spk-biz-2', 'Investment', 'Đầu tư', 'Investment community', 'Cộng đồng đầu tư' ),
		array( 'spk-biz-3', 'Frontier technology', 'Công nghệ đột phá', 'Technology leadership', 'Lãnh đạo công nghệ' ),
		array( 'spk-aca-1', 'Research', 'Nghiên cứu', 'Research and academia', 'Nghiên cứu và học thuật' ),
	);
	$count = 0;
	foreach ( $cards as $c ) {
		$existing = get_page_by_path( $c[0], OBJECT, 'aef_speaker' );
		$data     = array(
			'post_title'  => 'To be announced',
			'post_name'   => $c[0],
			'post_status' => 'publish',
			'post_type'   => 'aef_speaker',
			'post_content'=> 'Speaker profile will be published after written confirmation.',
		);
		if ( $existing ) {
			$data['ID'] = $existing->ID;
			$id = wp_update_post( $data );
		} else {
			$id = wp_insert_post( $data );
		}
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, 'title_en', 'To be announced' );
			update_post_meta( $id, 'title_vi', 'Sẽ công bố' );
			update_post_meta( $id, 'content_en', 'This card is a visual placeholder. Replace the name, organisation and portrait in wp-admin when the participant has confirmed in writing.' );
			update_post_meta( $id, 'content_vi', 'Thẻ này là mô hình trình bày. Thay tên, tổ chức và ảnh chân dung trong wp-admin khi người tham gia đã xác nhận bằng văn bản.' );
			update_post_meta( $id, 'role_en', $c[1] );
			update_post_meta( $id, 'role_vi', $c[2] );
			update_post_meta( $id, 'org_en', $c[3] );
			update_post_meta( $id, 'org_vi', $c[4] );
			update_post_meta( $id, 'country', '—' );
			update_post_meta( $id, 'is_mockup', '1' );
			$count++;
		}
	}
	return $count;
}
