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
	add_meta_box( 'aef_story_media', 'AEF — Loại bài, PDF, video', 'aef_story_media_box', 'aef_story', 'side', 'high' );
	add_meta_box( 'aef_i18n', 'AEF — English / Vietnamese', 'aef_i18n_box', 'aef_partner', 'normal', 'high' );
	add_meta_box( 'aef_partner_meta', 'AEF — Partner', 'aef_partner_box', 'aef_partner', 'side', 'high' );
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

/**
 * Với post_type 'page', ô soạn thảo Anh/Việt bên dưới KHÔNG hiển thị trên mọi
 * trang — 5 trang có bố cục thiết kế riêng (page.php route bằng slug, bỏ qua
 * hoàn toàn nội dung soạn thảo), 3 trang khác lấy nội dung chính từ 1 màn quản
 * trị riêng (ô soạn thảo chỉ là dự phòng khi màn đó bỏ trống). Việc này khiến
 * BTC dễ gõ nhầm vào ô chết mà không biết. Hàm này in ra 1 ghi chú rõ ràng,
 * đúng ngay tại chỗ dễ nhầm, thay vì chỉ nằm trong tài liệu riêng.
 * Xem thêm: docs/huong-dan-noi-dung.md
 */
function aef_page_editor_notice( $post ) {
	if ( 'page' !== $post->post_type ) {
		return;
	}
	$slug = $post->post_name;

	$code_only = array( 'travel', 'venue', 'hotels', 'transport', 'how-to-register', 'delegates', 'support', 'media-support' );
	if ( in_array( $slug, $code_only, true ) ) {
		echo '<div class="notice notice-warning inline" style="margin:0 0 14px"><p><strong>Lưu ý:</strong> trang này dùng bố cục thiết kế riêng (không phải bài viết thường). Nội dung gõ ở khung Anh/Việt bên dưới <strong>sẽ không hiện ra</strong> trên trang thật. Muốn đổi nội dung trang này, cần nhờ lập trình viên sửa code — xem <code>docs/huong-dan-noi-dung.md</code> trong mã nguồn theme.</p></div>';
		return;
	}

	$field_screens = array(
		'about'    => array( admin_url( 'admin.php?page=aef-about' ), 'Giới thiệu' ),
		'topics'   => array( admin_url( 'admin.php?page=aef-topics' ), 'Chuyên đề' ),
		'partners' => array( admin_url( 'admin.php?page=aef-inner' ), 'Trang trong' ),
	);
	if ( isset( $field_screens[ $slug ] ) ) {
		list( $url, $label ) = $field_screens[ $slug ];
		echo '<div class="notice notice-info inline" style="margin:0 0 14px"><p><strong>Lưu ý:</strong> nội dung chính của trang này sửa tại màn hình <a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>. Khung Anh/Việt bên dưới chỉ được dùng khi ô tương ứng ở màn đó để trống.</p></div>';
	}
}

function aef_i18n_box( $post ) {
	wp_nonce_field( 'aef_i18n', 'aef_i18n_nonce' );
	aef_page_editor_notice( $post );
	echo '<p>Công chúng đổi ngôn ngữ bằng EN / VI trên header. Ô WordPress phía trên chỉ là dự phòng khi một phía còn trống.</p>';
	echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">';
	echo '<div><h3>English</h3>';
	aef_field( $post->ID, 'title_en', 'Title (EN)' );
	aef_field( $post->ID, 'excerpt_en', 'Excerpt / deck (EN)', 'textarea' );
	if ( in_array( $post->post_type, array( 'aef_story', 'page' ), true ) ) {
		wp_editor( get_post_meta( $post->ID, 'content_en', true ), 'aef_content_en', array( 'textarea_name' => 'content_en', 'textarea_rows' => 12, 'media_buttons' => true ) );
	} else {
		aef_field( $post->ID, 'content_en', 'Body (EN)', 'textarea' );
	}
	echo '</div><div><h3>Tiếng Việt</h3>';
	aef_field( $post->ID, 'title_vi', 'Tiêu đề (VI)' );
	aef_field( $post->ID, 'excerpt_vi', 'Tóm tắt (VI)', 'textarea' );
	if ( in_array( $post->post_type, array( 'aef_story', 'page' ), true ) ) {
		wp_editor( get_post_meta( $post->ID, 'content_vi', true ), 'aef_content_vi', array( 'textarea_name' => 'content_vi', 'textarea_rows' => 12, 'media_buttons' => true ) );
	} else {
		aef_field( $post->ID, 'content_vi', 'Nội dung (VI)', 'textarea' );
	}
	echo '</div></div>';
}

function aef_speaker_box( $post ) {
	wp_nonce_field( 'aef_spk', 'aef_spk_nonce' );
	aef_field( $post->ID, 'role_en', 'Category / role (EN)' );
	aef_field( $post->ID, 'role_vi', 'Nhóm / vai trò (VI)' );
	aef_field( $post->ID, 'org_en', 'Organisation (EN)' );
	aef_field( $post->ID, 'org_vi', 'Tổ chức (VI)' );
	aef_speaker_country_field( $post->ID );
	$mock = get_post_meta( $post->ID, 'is_mockup', true );
	echo '<p><label><input type="checkbox" name="is_mockup" value="1"' . checked( $mock, '1', false ) . '> Demo mockup (hide real-name claim)</label></p>';
	echo '<p>Set the <strong>Featured image</strong> as the portrait. Admin replaces name, role and photo when confirmed.</p>';
}

function aef_speaker_country_field( $post_id ) {
	$raw  = get_post_meta( $post_id, 'country', true );
	$code = function_exists( 'aef_country_code_from_value' ) ? aef_country_code_from_value( $raw ) : '';
	$list = function_exists( 'aef_countries' ) ? aef_countries() : array();
	$pin  = array( 'VN', 'CN', 'US', 'JP', 'KR', 'SG', 'IN', 'FR', 'DE', 'GB', 'AU', 'CH' );
	$head = array();
	$rest = $list;
	foreach ( $pin as $iso ) {
		if ( isset( $rest[ $iso ] ) ) {
			$head[ $iso ] = $rest[ $iso ];
			unset( $rest[ $iso ] );
		}
	}
	uasort(
		$rest,
		function ( $a, $b ) {
			return strcasecmp( $a['vi'], $b['vi'] );
		}
	);
	echo '<p><label><strong>Quốc gia</strong><br><select name="country" class="widefat">';
	echo '<option value="">—</option>';
	if ( $head ) {
		echo '<optgroup label="' . esc_attr( 'Thường dùng' ) . '">';
		foreach ( $head as $iso => $names ) {
			$label = $names['vi'] . ' / ' . $names['en'];
			echo '<option value="' . esc_attr( $iso ) . '"' . selected( $code, $iso, false ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</optgroup>';
	}
	if ( $rest ) {
		echo '<optgroup label="' . esc_attr( 'Tất cả' ) . '">';
		foreach ( $rest as $iso => $names ) {
			$label = $names['vi'] . ' / ' . $names['en'];
			echo '<option value="' . esc_attr( $iso ) . '"' . selected( $code, $iso, false ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</optgroup>';
	}
	echo '</select></label></p>';
	echo '<p class="description">Chọn từ danh mục (mã ISO). Gõ chữ cái trong ô để tìm nhanh.</p>';
	if ( $raw && ! $code ) {
		echo '<p class="description">Giá trị cũ chưa khớp danh mục: <code>' . esc_html( $raw ) . '</code>. Chọn lại quốc gia trong danh sách rồi lưu.</p>';
	}
}

function aef_story_media_box( $post ) {
	wp_nonce_field( 'aef_story_media', 'aef_story_media_nonce' );
	$kind = get_post_meta( $post->ID, 'story_kind', true );
	if ( ! $kind ) {
		$kind = 'news';
	}
	echo '<p><label><strong>Loại bài</strong><br><select name="story_kind" class="widefat">';
	foreach ( aef_story_kinds() as $key => $lab ) {
		echo '<option value="' . esc_attr( $key ) . '"' . selected( $kind, $key, false ) . '>' . esc_html( $lab['vi'] . ' / ' . $lab['en'] ) . '</option>';
	}
	echo '</select></label></p>';
	echo '<p><label><strong>Video URL</strong> (YouTube, Facebook, Vimeo, hoặc .mp4)<br>';
	echo '<input type="url" class="widefat" name="video_url" value="' . esc_attr( get_post_meta( $post->ID, 'video_url', true ) ) . '" placeholder="https://www.youtube.com/watch?v=…"></label></p>';
	echo '<p><label><strong>Video tải lên</strong> (ID file trong Thư viện)<br>';
	echo '<input type="number" class="widefat" name="video_file_id" value="' . esc_attr( get_post_meta( $post->ID, 'video_file_id', true ) ) . '" placeholder="0"></label></p>';
	echo '<p class="description">Tải MP4 vào Media Library, copy ID (số trên URL attachment) dán vào đây. Ưu tiên hơn URL.</p>';
	echo '<p><label><strong>PDF</strong> (ID file)<br>';
	echo '<input type="number" class="widefat" name="pdf_id" value="' . esc_attr( get_post_meta( $post->ID, 'pdf_id', true ) ) . '"></label></p>';
	aef_field( $post->ID, 'pdf_label_en', 'Nhãn nút PDF (EN)' );
	aef_field( $post->ID, 'pdf_label_vi', 'Nhãn nút PDF (VI)' );
	echo '<p class="description">Ảnh đại diện = ảnh thẻ trên trang Media.</p>';
}

function aef_partner_box( $post ) {
	wp_nonce_field( 'aef_partner', 'aef_partner_nonce' );
	$tier = get_post_meta( $post->ID, 'tier', true );
	if ( ! $tier ) {
		$tier = 'accompanying';
	}
	echo '<p><label><strong>Nhóm</strong><br><select name="tier" class="widefat">';
	foreach ( aef_partner_tiers() as $key => $lab ) {
		echo '<option value="' . esc_attr( $key ) . '"' . selected( $tier, $key, false ) . '>' . esc_html( $lab['vi'] . ' / ' . $lab['en'] ) . '</option>';
	}
	echo '</select></label></p>';
	aef_field( $post->ID, 'url', 'Website (tuỳ chọn)' );
	$on = get_post_meta( $post->ID, 'carousel_on', true );
	if ( '' === $on ) {
		$on = '1';
	}
	echo '<p><label><input type="hidden" name="carousel_on" value="0"><input type="checkbox" name="carousel_on" value="1"' . checked( $on, '1', false ) . '> Hiện logo trên carousel trang chủ</label></p>';
	echo '<p><label><strong>Thứ tự</strong> (số nhỏ hiện trước)<br><input type="number" class="small-text" name="aef_menu_order" value="' . esc_attr( (string) $post->menu_order ) . '"></label></p>';
	echo '<p class="description">Kéo xếp hàng loạt: <a href="' . esc_url( admin_url( 'admin.php?page=aef-partner-logos' ) ) . '">Logo trang chủ</a>. Ảnh đại diện = logo (ưu tiên hơn file theme).</p>';
}

function aef_session_box( $post ) {
	wp_nonce_field( 'aef_ses', 'aef_ses_nonce' );
	echo '<p class="description"><strong>Đặt tên phiên:</strong> lấy đúng tiêu đề khung 10-9, không đánh số “Phiên 1/2”. Không nhét “Phòng 01” hay WEF vào tên — phòng để trường Room, WEF chỉ ghi trong nội dung phiên 28/10 làm chung. Tóm tắt = 1 câu dẫn (d); bối cảnh = đoạn mô tả (c). Địa điểm chưa chốt: gõ <code>Đang xác nhận</code>.</p>';
	aef_field( $post->ID, 'session_id', 'Session ID (AEF27-R1-S1…)' );
	aef_field( $post->ID, 'kind', 'Kind / loại (Phiên chuyên đề, Sự kiện…)' );
	aef_field( $post->ID, 'format_vi', 'Hình thức (VI)' );
	aef_field( $post->ID, 'format_en', 'Format (EN)' );
	aef_field( $post->ID, 'lead_vi', 'Chủ trì / phối hợp (VI)' );
	aef_field( $post->ID, 'lead_en', 'Chaired / coordinated by (EN)' );
	aef_field( $post->ID, 'audience_vi', 'Thành phần tham dự (VI)', 'textarea' );
	aef_field( $post->ID, 'audience_en', 'Participants (EN)', 'textarea' );
	aef_field( $post->ID, 'date_label', 'Date label (27/10/2026)' );
	aef_field( $post->ID, 'time', 'Time' );

	$room    = get_post_meta( $post->ID, 'room', true );
	$choices = aef_room_choices();
	if ( $room && ! isset( $choices[ $room ] ) ) {
		$choices[ $room ] = $room . ' (giá trị cũ, chưa có trong danh sách chuẩn)';
	}
	echo '<p><label><strong>Room</strong><br><select name="room" class="widefat">';
	foreach ( $choices as $key => $label ) {
		echo '<option value="' . esc_attr( $key ) . '"' . selected( $room, $key, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select></label></p>';
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

	echo '<hr>';
	$show_home = get_post_meta( $post->ID, 'show_on_home', true );
	echo '<p><label><input type="hidden" name="show_on_home" value="0"><input type="checkbox" name="show_on_home" value="1"' . checked( $show_home, '1', false ) . '> Hiện ở trang chủ (khối lịch trình)</label></p>';
	$is_key = get_post_meta( $post->ID, 'is_key', true );
	echo '<p><label><input type="hidden" name="is_key" value="0"><input type="checkbox" name="is_key" value="1"' . checked( $is_key, '1', false ) . '> Phiên nổi bật (đậm) ở trang chủ</label></p>';
	$is_live = get_post_meta( $post->ID, 'is_live', true );
	echo '<p><label><input type="hidden" name="is_live" value="0"><input type="checkbox" name="is_live" value="1"' . checked( $is_live, '1', false ) . '> Gắn nhãn "Truyền hình trực tiếp"</label></p>';
	echo '<p><label><strong>Thứ tự trong ngày</strong> (số nhỏ hiện trước)<br><input type="number" class="small-text" name="aef_menu_order" value="' . esc_attr( (string) $post->menu_order ) . '"></label></p>';
	echo '<p class="description">Sắp xếp kéo-thả hàng loạt: <a href="' . esc_url( admin_url( 'admin.php?page=aef-schedule-order' ) ) . '">Sắp xếp chương trình</a>.</p>';

	aef_session_people_editor( $post->ID );
}

function aef_speaker_choices() {
	$posts = get_posts(
		array(
			'post_type'      => 'aef_speaker',
			'posts_per_page' => 300,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
		)
	);
	$out = array();
	foreach ( $posts as $p ) {
		$vi  = trim( (string) get_post_meta( $p->ID, 'title_vi', true ) );
		$en  = trim( (string) get_post_meta( $p->ID, 'title_en', true ) );
		$name = $vi ? $vi : ( $en ? $en : $p->post_title );
		if ( $en && $vi && $en !== $vi ) {
			$name = $vi . ' / ' . $en;
		}
		$org = trim( (string) get_post_meta( $p->ID, 'org_vi', true ) );
		if ( ! $org ) {
			$org = trim( (string) get_post_meta( $p->ID, 'org_en', true ) );
		}
		$label = $org ? $name . ' — ' . $org : $name;
		$out[ $p->ID ] = array(
			'label' => $label,
			'thumb' => function_exists( 'aef_speaker_portrait_url' ) ? aef_speaker_portrait_url( $p->ID, 'thumbnail' ) : '',
		);
	}
	return $out;
}

function aef_session_people_editor( $session_id ) {
	$people  = function_exists( 'aef_session_people' ) ? aef_session_people( $session_id ) : array();
	$choices = aef_speaker_choices();
	$roles   = function_exists( 'aef_person_roles' ) ? aef_person_roles() : array(
		'moderator' => array( 'en' => 'Moderator', 'vi' => 'Điều phối' ),
		'panelist'  => array( 'en' => 'Panelist', 'vi' => 'Diễn giả' ),
	);
	echo '<hr><p><strong>Diễn giả tại phiên</strong></p>';
	echo '<p class="description">Chọn hồ sơ đã có (ảnh + tên + tổ chức). <strong>Chưa xác nhận thì để trống</strong> — trang phiên hiện “Đang xác nhận” theo vai trò dự kiến, không bịa tên. Vai trò (theo khung 10-9 / HTML 12.9): Chủ trì, Đồng chủ trì, Phát biểu đề dẫn, Chào mừng, Đối thoại, Tham luận, Điều phối viên, Diễn giả tọa đàm, Diễn giả, Phát biểu cảm ơn. Phiên chuyên đề 27/10: 1 điều phối viên + 3–4 diễn giả tọa đàm. Phiên 28/10 toàn thể: chủ trì / đề dẫn / chào mừng. Đối thoại TTg: chủ trì + đối thoại. Chiều 28/10: chủ trì, đề dẫn, tham luận, tọa đàm cấp Bộ, cảm ơn.</p>';
	if ( ! $choices ) {
		echo '<p class="description">Chưa có hồ sơ diễn giả. Tạo ở <a href="' . esc_url( admin_url( 'edit.php?post_type=aef_speaker' ) ) . '">Diễn giả</a> rồi quay lại.</p>';
		return;
	}
	echo '<div id="aef-people-rows">';
	if ( ! $people ) {
		$people = array( array( 'id' => 0, 'role' => 'panelist' ) );
	}
	foreach ( $people as $row ) {
		aef_session_person_row( $choices, $roles, $row );
	}
	echo '</div>';
	echo '<p><button type="button" class="button" id="aef-add-person">Thêm diễn giả</button></p>';
	echo '<template id="aef-person-tpl">';
	aef_session_person_row( $choices, $roles, array( 'id' => 0, 'role' => 'panelist' ) );
	echo '</template>';
}

function aef_session_person_row( $choices, $roles, $row ) {
	$id    = isset( $row['id'] ) ? absint( $row['id'] ) : 0;
	$role  = isset( $row['role'] ) ? $row['role'] : 'panelist';
	$thumb = ( $id && isset( $choices[ $id ]['thumb'] ) ) ? $choices[ $id ]['thumb'] : '';
	echo '<p class="aef-person-row" style="display:flex;gap:8px;align-items:center;margin:0 0 10px">';
	echo '<img class="aef-person-thumb" src="' . esc_url( $thumb ) . '" alt="" width="40" height="40" style="width:40px;height:40px;object-fit:cover;background:#042764;flex:0 0 40px;' . ( $thumb ? '' : 'visibility:hidden;' ) . '">';
	echo '<select name="aef_person_id[]" class="aef-person-id" style="flex:1;min-width:0">';
	echo '<option value="0" data-thumb="">—</option>';
	foreach ( $choices as $sid => $item ) {
		$label = is_array( $item ) ? $item['label'] : $item;
		$src   = is_array( $item ) && ! empty( $item['thumb'] ) ? $item['thumb'] : '';
		echo '<option value="' . esc_attr( $sid ) . '" data-thumb="' . esc_attr( $src ) . '"' . selected( $id, $sid, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select>';
	echo '<select name="aef_person_role[]" style="flex:0 0 260px">';
	foreach ( $roles as $key => $lab ) {
		$label = is_array( $lab ) ? $lab['vi'] . ' / ' . $lab['en'] : $lab;
		echo '<option value="' . esc_attr( $key ) . '"' . selected( $role, $key, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select>';
	echo '<button type="button" class="button aef-del-person">Xóa</button>';
	echo '</p>';
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
		foreach ( array( 'title_en', 'title_vi', 'excerpt_en', 'excerpt_vi', 'content_en', 'content_vi' ) as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, wp_kses_post( wp_unslash( $_POST[ $key ] ) ) );
			}
		}
	}
	if ( isset( $_POST['aef_spk_nonce'] ) && wp_verify_nonce( $_POST['aef_spk_nonce'], 'aef_spk' ) ) {
		foreach ( array( 'role_en', 'role_vi', 'org_en', 'org_vi' ) as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
			}
		}
		$country = isset( $_POST['country'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_POST['country'] ) ) ) : '';
		if ( $country && function_exists( 'aef_countries' ) && ! isset( aef_countries()[ $country ] ) ) {
			$country = '';
		}
		update_post_meta( $post_id, 'country', $country );
		update_post_meta( $post_id, 'is_mockup', empty( $_POST['is_mockup'] ) ? '' : '1' );
	}
	if ( isset( $_POST['aef_story_media_nonce'] ) && wp_verify_nonce( $_POST['aef_story_media_nonce'], 'aef_story_media' ) ) {
		$kind = isset( $_POST['story_kind'] ) ? sanitize_key( wp_unslash( $_POST['story_kind'] ) ) : 'news';
		if ( ! isset( aef_story_kinds()[ $kind ] ) ) {
			$kind = 'news';
		}
		update_post_meta( $post_id, 'story_kind', $kind );
		update_post_meta( $post_id, 'video_url', isset( $_POST['video_url'] ) ? esc_url_raw( wp_unslash( $_POST['video_url'] ) ) : '' );
		update_post_meta( $post_id, 'video_file_id', isset( $_POST['video_file_id'] ) ? absint( $_POST['video_file_id'] ) : 0 );
		update_post_meta( $post_id, 'pdf_id', isset( $_POST['pdf_id'] ) ? absint( $_POST['pdf_id'] ) : 0 );
		update_post_meta( $post_id, 'pdf_label_en', isset( $_POST['pdf_label_en'] ) ? sanitize_text_field( wp_unslash( $_POST['pdf_label_en'] ) ) : '' );
		update_post_meta( $post_id, 'pdf_label_vi', isset( $_POST['pdf_label_vi'] ) ? sanitize_text_field( wp_unslash( $_POST['pdf_label_vi'] ) ) : '' );
	}
	if ( isset( $_POST['aef_partner_nonce'] ) && wp_verify_nonce( $_POST['aef_partner_nonce'], 'aef_partner' ) ) {
		$tier = isset( $_POST['tier'] ) ? sanitize_key( wp_unslash( $_POST['tier'] ) ) : 'accompanying';
		if ( ! isset( aef_partner_tiers()[ $tier ] ) ) {
			$tier = 'accompanying';
		}
		update_post_meta( $post_id, 'tier', $tier );
		update_post_meta( $post_id, 'url', isset( $_POST['url'] ) ? esc_url_raw( wp_unslash( $_POST['url'] ) ) : '' );
		$on = ( isset( $_POST['carousel_on'] ) && '1' === (string) $_POST['carousel_on'] ) ? '1' : '0';
		update_post_meta( $post_id, 'carousel_on', $on );
		if ( isset( $_POST['aef_menu_order'] ) ) {
			$order = absint( $_POST['aef_menu_order'] );
			if ( (int) get_post_field( 'menu_order', $post_id ) !== $order ) {
				remove_action( 'save_post', 'aef_save_metaboxes' );
				wp_update_post(
					array(
						'ID'         => $post_id,
						'menu_order' => $order,
					)
				);
				add_action( 'save_post', 'aef_save_metaboxes' );
			}
		}
	}
	if ( isset( $_POST['aef_ses_nonce'] ) && wp_verify_nonce( $_POST['aef_ses_nonce'], 'aef_ses' ) ) {
		$text = array( 'session_id', 'kind', 'date_label', 'time', 'format_en', 'format_vi', 'lead_en', 'lead_vi', 'access_en', 'access_vi', 'status', 'tags' );
		foreach ( $text as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
			}
		}
		// Room: lưu nguyên giá trị đã chọn/đang có — không ép về rỗng nếu là giá trị cũ
		// chưa nằm trong aef_room_choices(), vì khung chọn ở aef_session_box() luôn tự
		// thêm giá trị hiện tại vào danh sách nên mọi giá trị gửi lên đều hợp lệ.
		if ( isset( $_POST['room'] ) ) {
			update_post_meta( $post_id, 'room', sanitize_text_field( wp_unslash( $_POST['room'] ) ) );
		}
		update_post_meta( $post_id, 'show_on_home', ( isset( $_POST['show_on_home'] ) && '1' === (string) $_POST['show_on_home'] ) ? '1' : '0' );
		update_post_meta( $post_id, 'is_key', ( isset( $_POST['is_key'] ) && '1' === (string) $_POST['is_key'] ) ? '1' : '0' );
		update_post_meta( $post_id, 'is_live', ( isset( $_POST['is_live'] ) && '1' === (string) $_POST['is_live'] ) ? '1' : '0' );
		if ( isset( $_POST['aef_menu_order'] ) ) {
			$order = absint( $_POST['aef_menu_order'] );
			if ( (int) get_post_field( 'menu_order', $post_id ) !== $order ) {
				remove_action( 'save_post', 'aef_save_metaboxes' );
				wp_update_post( array( 'ID' => $post_id, 'menu_order' => $order ) );
				add_action( 'save_post', 'aef_save_metaboxes' );
			}
		}
		$areas = array( 'short_en', 'short_vi', 'long_en', 'long_vi', 'questions_en', 'questions_vi', 'audience_en', 'audience_vi' );
		foreach ( $areas as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, wp_kses_post( wp_unslash( $_POST[ $key ] ) ) );
			}
		}
		$ids   = isset( $_POST['aef_person_id'] ) ? (array) wp_unslash( $_POST['aef_person_id'] ) : array();
		$roles = isset( $_POST['aef_person_role'] ) ? (array) wp_unslash( $_POST['aef_person_role'] ) : array();
		$people = array();
		$seen   = array();
		foreach ( $ids as $i => $raw_id ) {
			$sid = absint( $raw_id );
			if ( ! $sid || isset( $seen[ $sid ] ) || 'aef_speaker' !== get_post_type( $sid ) ) {
				continue;
			}
			$role  = isset( $roles[ $i ] ) ? sanitize_key( $roles[ $i ] ) : 'panelist';
			$known = function_exists( 'aef_person_roles' ) ? aef_person_roles() : array();
			if ( ! isset( $known[ $role ] ) ) {
				$role = 'panelist';
			}
			$seen[ $sid ] = true;
			$people[]     = array(
				'id'   => $sid,
				'role' => $role,
			);
		}
		delete_post_meta( $post_id, 'aef_person' );
		foreach ( $people as $row ) {
			add_post_meta( $post_id, 'aef_person', $row['id'] );
		}
		update_post_meta( $post_id, 'aef_people', $people );
	}
}

add_action( 'admin_menu', 'aef_editor_menu' );
function aef_editor_menu() {
	add_menu_page( 'AEF Content', 'AEF Content', 'edit_pages', 'aef-content', 'aef_content_hub', 'dashicons-welcome-widgets-menus', 3 );
	add_submenu_page( 'aef-content', 'Trang chủ', 'Trang chủ', 'edit_pages', 'aef-home-blocks', 'aef_home_blocks_page' );
	add_submenu_page( 'aef-content', 'Giới thiệu', 'Giới thiệu', 'edit_pages', 'aef-about', 'aef_about_page' );
	add_submenu_page( 'aef-content', 'Chuyên đề', 'Chuyên đề', 'edit_pages', 'aef-topics', 'aef_topics_page' );
	add_submenu_page( 'aef-content', 'Trang trong', 'Trang trong', 'edit_pages', 'aef-inner', 'aef_inner_page' );
	add_submenu_page( 'aef-content', 'Khung trang', 'Khung trang', 'edit_pages', 'aef-chrome', 'aef_chrome_page' );
	add_submenu_page( 'aef-content', 'Cài đặt kỳ', 'Cài đặt kỳ', 'manage_options', 'aef-edition', 'aef_settings_page' );
	add_submenu_page( 'aef-content', 'Sắp xếp chương trình', 'Sắp xếp chương trình', 'edit_pages', 'aef-schedule-order', 'aef_schedule_order_page' );
	add_submenu_page( 'aef-content', 'Menu EN/VI', 'Menu EN/VI', 'edit_theme_options', 'nav-menus.php' );
	add_submenu_page( 'aef-content', 'Tin / thông cáo', 'Tin / thông cáo', 'edit_posts', 'edit.php?post_type=aef_story' );
	add_submenu_page( 'aef-content', 'Đối tác', 'Đối tác', 'edit_posts', 'edit.php?post_type=aef_partner' );
	add_submenu_page( 'aef-content', 'Logo trang chủ', 'Logo trang chủ', 'edit_pages', 'aef-partner-logos', 'aef_partner_logos_page' );
	add_submenu_page( 'aef-content', 'Coming soon', 'Coming soon', 'edit_pages', 'aef-coming', 'aef_coming_page' );
	add_submenu_page( 'aef-content', 'CSS Custom', 'CSS Custom', 'edit_pages', 'aef-custom-css', 'aef_custom_css_page' );
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
	echo '<p>Desk sự kiện: Trang chủ (thứ tự khối), Giới thiệu (chữ + ảnh), Cài đặt kỳ (ngày, chủ đề, host). Phiên / diễn giả / tin là từng bản ghi.</p>';
	echo '<p>';
	echo '<a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=aef-coming' ) ) . '">Coming soon</a> ';
	echo '<a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=aef-chrome' ) ) . '">Khung trang (menu, ribbon)</a> ';
	echo '<a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=aef-home-blocks' ) ) . '">Trang chủ</a> ';
	echo '<a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=aef-about' ) ) . '">Giới thiệu</a> ';
	echo '<a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=aef-topics' ) ) . '">Chuyên đề</a> ';
	echo '<a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=aef-inner' ) ) . '">Trang trong</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'admin.php?page=aef-edition' ) ) . '">Ngày, chủ đề, host</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=aef_speaker' ) ) . '">Diễn giả</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=aef_session' ) ) . '">Phiên</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '">Trang</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=aef_story' ) ) . '">Tin / thông cáo / video / PDF</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'post-new.php?post_type=aef_story' ) ) . '">Thêm bài</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=aef_partner' ) ) . '">Đối tác</a> ';
	echo '<a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=aef-partner-logos' ) ) . '">Logo trang chủ</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'admin.php?page=aef-custom-css' ) ) . '">CSS Custom</a>';
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
		$out      = aef_copy_all();
		foreach ( $defaults as $key => $fallback ) {
			if ( 0 === strpos( $key, 'block_' ) ) {
				continue;
			}
			if ( '_id' === substr( $key, -3 ) ) {
				$out[ $key ] = isset( $_POST[ $key ] ) ? (string) absint( $_POST[ $key ] ) : '0';
				continue;
			}
			if ( isset( $_POST[ $key ] ) ) {
				$out[ $key ] = wp_kses_post( wp_unslash( $_POST[ $key ] ) );
			}
		}
		$defs = aef_home_block_defs();
		foreach ( array_keys( $defs ) as $id ) {
			$out[ 'block_' . $id ] = empty( $_POST[ 'block_' . $id ] ) ? '0' : '1';
		}
		$out['block_journey']  = $out['block_programme'];
		$out['block_featured'] = $out['block_programme'];
		update_option( 'aef_copy', $out );
		$order_in = isset( $_POST['home_order'] ) ? (array) wp_unslash( $_POST['home_order'] ) : array();
		$order    = array();
		foreach ( $order_in as $id ) {
			$id = sanitize_key( $id );
			if ( isset( $defs[ $id ] ) && ! in_array( $id, $order, true ) ) {
				$order[] = $id;
			}
		}
		foreach ( array_keys( $defs ) as $id ) {
			if ( ! in_array( $id, $order, true ) ) {
				$order[] = $id;
			}
		}
		update_option( 'aef_home_order', $order );
		echo '<div class="updated notice"><p>Đã lưu trang chủ. <a href="' . esc_url( home_url( '/' ) ) . '" target="_blank" rel="noopener">Xem trang chủ</a></p></div>';
	}

	$c     = aef_copy_all();
	$defs  = aef_home_block_defs();
	$order = aef_home_order();
	$on    = array();
	$off   = array();
	foreach ( $order as $id ) {
		if ( aef_block_on( $id ) ) {
			$on[] = $id;
		} else {
			$off[] = $id;
		}
	}

	echo '<div class="wrap aef-desk"><h1>Trang chủ — từng khối</h1>';
	echo '<p>Kéo thẻ (hoặc ↑ ↓) để đổi thứ tự. <strong>Xóa khỏi trang chủ</strong> chỉ ẩn — câu chữ vẫn giữ, khôi phục ở cuối trang. Ngày / chủ đề / host: <a href="' . esc_url( admin_url( 'options-general.php?page=aef-2026' ) ) . '">Cài đặt kỳ</a>.</p>';
	echo '<form method="post" id="aef-home-form">';
	wp_nonce_field( 'aef_copy' );
	echo '<ol class="aef-stack" id="aef-stack">';
	foreach ( $on as $id ) {
		aef_home_block_card( $id, $defs[ $id ], $c, true );
	}
	echo '</ol>';
	if ( $off ) {
		echo '<h2>Đã gỡ khỏi trang chủ</h2><p class="description">Khôi phục rồi bấm Lưu.</p>';
		echo '<ol class="aef-stack aef-stack-off">';
		foreach ( $off as $id ) {
			aef_home_block_card( $id, $defs[ $id ], $c, false );
		}
		echo '</ol>';
	}
	submit_button( 'Lưu trang chủ', 'primary', 'aef_save_copy' );
	echo '</form></div>';
	aef_home_blocks_assets();
	aef_admin_media_picker_js();
}

function aef_home_block_card( $id, $def, $c, $visible ) {
	echo '<li class="aef-card' . ( $visible ? '' : ' is-off' ) . '" data-id="' . esc_attr( $id ) . '">';
	echo '<input type="hidden" name="home_order[]" value="' . esc_attr( $id ) . '">';
	echo '<div class="aef-card-bar">';
	echo '<span class="aef-handle" title="Kéo để đổi thứ tự">⋮⋮</span>';
	echo '<strong>' . esc_html( $def['label'] ) . '</strong>';
	echo '<span class="aef-badge">' . ( $visible ? 'Đang hiện' : 'Đã ẩn' ) . '</span>';
	echo '<span class="aef-move">';
	echo '<button type="button" class="button aef-up">↑</button> ';
	echo '<button type="button" class="button aef-down">↓</button>';
	echo '</span>';
	if ( $visible ) {
		echo '<label class="aef-hide"><input type="hidden" name="block_' . esc_attr( $id ) . '" value="0">';
		echo '<input type="checkbox" class="aef-on" name="block_' . esc_attr( $id ) . '" value="1" checked> Hiện</label>';
		echo '<button type="button" class="button-link-delete aef-remove">Xóa khỏi trang chủ</button>';
	} else {
		echo '<label class="aef-hide"><input type="hidden" name="block_' . esc_attr( $id ) . '" value="0">';
		echo '<input type="checkbox" class="aef-on" name="block_' . esc_attr( $id ) . '" value="1"> Khôi phục</label>';
	}
	echo '</div>';
	echo '<p class="description">' . esc_html( $def['help'] ) . '</p>';
	if ( 'partners' === $id ) {
		echo '<p><a class="button" href="' . esc_url( admin_url( 'admin.php?page=aef-partner-logos' ) ) . '">Quản lý logo &amp; thứ tự</a></p>';
	}
	if ( ! empty( $def['image'] ) && is_array( $def['image'] ) ) {
		foreach ( $def['image'] as $img_key => $img_label ) {
			$bg_defaults = array(
				'home_hero_bg_id'  => aef_img( 'visual/collaboration-roads.jpg' ),
				'home_intro_bg_id' => aef_img( 'visual/hcmc-dusk.jpg' ),
				'home_city_bg_id'  => aef_img( 'visual/hcmc-dusk.jpg' ),
			);
			$default_src = isset( $bg_defaults[ $img_key ] ) ? $bg_defaults[ $img_key ] : '';
			aef_admin_image( $c, $img_key, $img_label, $default_src );
			if ( 'home_hero_bg_id' === $img_key ) {
				echo '<p class="description">Chọn từ Thư viện, rồi Lưu trang chủ. Trống / “Dùng ảnh mặc định” = KV collaboration-roads.</p>';
			} elseif ( in_array( $img_key, array( 'home_intro_bg_id', 'home_city_bg_id' ), true ) ) {
				echo '<p class="description">Chọn từ Thư viện, rồi Lưu trang chủ. Trống / “Dùng ảnh mặc định” = phố chạng vạng (hcmc-dusk).</p>';
			} else {
				echo '<p class="description">Ảnh nền riêng của khối, lớp tách khỏi chữ. Trống / “Dùng ảnh mặc định” = giữ nền CSS hiện tại.</p>';
			}
		}
	}
	if ( 'hero' === $id && function_exists( 'aef_hero_fx_defs' ) ) {
		$fx_on = isset( $c['home_hero_fx_on'] ) ? (string) $c['home_hero_fx_on'] : '0';
		$fx    = isset( $c['home_hero_fx'] ) ? sanitize_key( $c['home_hero_fx'] ) : 'rise';
		echo '<div class="aef-hero-fx" style="margin:12px 0 8px;padding:12px 12px 8px;background:#f6f7f7;border:1px solid #dcdcde;border-radius:4px">';
		echo '<p style="margin:0 0 8px"><strong>Hiệu ứng Hero</strong></p>';
		echo '<p class="description" style="margin:0 0 8px">Lớp riêng phía trên ảnh nền. Tắt = chỉ còn ảnh. Code hiệu ứng không được đụng <code>.hero-photo</code>.</p>';
		echo '<p><label><input type="hidden" name="home_hero_fx_on" value="0">';
		echo '<input type="checkbox" name="home_hero_fx_on" value="1"' . checked( $fx_on, '1', false ) . '> Bật hiệu ứng</label></p>';
		echo '<p><label>Loại<br><select name="home_hero_fx">';
		foreach ( aef_hero_fx_defs() as $slug => $fxdef ) {
			echo '<option value="' . esc_attr( $slug ) . '"' . selected( $fx, $slug, false ) . '>' . esc_html( $fxdef['label'] ) . '</option>';
		}
		echo '</select></label></p>';
		echo '</div>';
	}
	if ( ! empty( $def['fields'] ) || ! empty( $def['stats'] ) || ! empty( $def['figures'] ) ) {
		echo '<details><summary>Sửa câu chữ EN / VI</summary><div class="aef-fields">';
		foreach ( $def['fields'] as $base => $label ) {
			$is_long = ( false !== strpos( $base, 'lead' ) || false !== strpos( $base, 'body' ) );
			$rows    = ( false !== strpos( $base, 'intro_lead' ) || false !== strpos( $base, 'theme_lead' ) || false !== strpos( $base, 'side_lead' ) ) ? 6 : 3;
			echo '<p><label><strong>' . esc_html( $label ) . '</strong></label></p>';
			if ( $is_long ) {
				echo '<p><textarea class="large-text" rows="' . intval( $rows ) . '" name="' . esc_attr( $base . '_en' ) . '" placeholder="English">' . esc_textarea( isset( $c[ $base . '_en' ] ) ? $c[ $base . '_en' ] : '' ) . '</textarea></p>';
				echo '<p><textarea class="large-text" rows="' . intval( $rows ) . '" name="' . esc_attr( $base . '_vi' ) . '" placeholder="Tiếng Việt">' . esc_textarea( isset( $c[ $base . '_vi' ] ) ? $c[ $base . '_vi' ] : '' ) . '</textarea></p>';
			} else {
				echo '<p><input type="text" class="large-text" name="' . esc_attr( $base . '_en' ) . '" value="' . esc_attr( isset( $c[ $base . '_en' ] ) ? $c[ $base . '_en' ] : '' ) . '" placeholder="English"></p>';
				echo '<p><input type="text" class="large-text" name="' . esc_attr( $base . '_vi' ) . '" value="' . esc_attr( isset( $c[ $base . '_vi' ] ) ? $c[ $base . '_vi' ] : '' ) . '" placeholder="Tiếng Việt"></p>';
			}
		}
		if ( ! empty( $def['figures'] ) ) {
			echo '<p><strong>Số liệu AEF 2026</strong> — số + nhãn. Ô số trống = ẩn cột đó.</p>';
			for ( $i = 1; $i <= 4; $i++ ) {
				echo '<p><input type="text" style="width:7em" name="home_fig_' . $i . '_n" value="' . esc_attr( isset( $c[ 'home_fig_' . $i . '_n' ] ) ? $c[ 'home_fig_' . $i . '_n' ] : '' ) . '" placeholder="Số"> ';
				echo '<input type="text" style="width:7em" name="home_fig_' . $i . '_n_en" value="' . esc_attr( isset( $c[ 'home_fig_' . $i . '_n_en' ] ) ? $c[ 'home_fig_' . $i . '_n_en' ] : '' ) . '" placeholder="Số EN"> ';
				echo '<input type="text" style="width:7em" name="home_fig_' . $i . '_n_vi" value="' . esc_attr( isset( $c[ 'home_fig_' . $i . '_n_vi' ] ) ? $c[ 'home_fig_' . $i . '_n_vi' ] : '' ) . '" placeholder="Số VI"> ';
				echo '<input type="text" class="regular-text" name="home_fig_' . $i . '_en" value="' . esc_attr( isset( $c[ 'home_fig_' . $i . '_en' ] ) ? $c[ 'home_fig_' . $i . '_en' ] : '' ) . '" placeholder="EN"> ';
				echo '<input type="text" class="regular-text" name="home_fig_' . $i . '_vi" value="' . esc_attr( isset( $c[ 'home_fig_' . $i . '_vi' ] ) ? $c[ 'home_fig_' . $i . '_vi' ] : '' ) . '" placeholder="VI"></p>';
			}
		}
		if ( ! empty( $def['stats'] ) ) {
			echo '<p><strong>Số liệu kỳ 2025</strong></p>';
			for ( $i = 1; $i <= 4; $i++ ) {
				echo '<p><input type="text" style="width:7em" name="home_stat_' . $i . '_n" value="' . esc_attr( $c[ 'home_stat_' . $i . '_n' ] ) . '"> ';
				echo '<input type="text" class="regular-text" name="home_stat_' . $i . '_en" value="' . esc_attr( $c[ 'home_stat_' . $i . '_en' ] ) . '" placeholder="EN"> ';
				echo '<input type="text" class="regular-text" name="home_stat_' . $i . '_vi" value="' . esc_attr( $c[ 'home_stat_' . $i . '_vi' ] ) . '" placeholder="VI"></p>';
			}
		}
		echo '</div></details>';
	}
	echo '</li>';
}

function aef_home_blocks_assets() {
	?>
	<style>
		.aef-stack{list-style:none;margin:0 0 28px;padding:0;max-width:920px}
		.aef-card{background:#fff;border:1px solid #c3c4c7;border-radius:4px;margin:0 0 10px;padding:12px 14px}
		.aef-card.is-off{opacity:.72;background:#f6f7f7}
		.aef-card-bar{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
		.aef-handle{cursor:grab;color:#787c82;letter-spacing:-2px;user-select:none}
		.aef-badge{font-size:11px;padding:2px 8px;border-radius:10px;background:#d5f0d8;color:#1e4620}
		.aef-card.is-off .aef-badge{background:#f0f0f1;color:#50575e}
		.aef-move{margin-left:auto}
		.aef-hide{margin:0 8px}
		.aef-card details{margin-top:8px}
		.aef-fields{padding:8px 0 0}
		.aef-card.ui-sortable-helper{box-shadow:0 8px 24px rgba(0,0,0,.12)}
	</style>
	<script>
	jQuery(function ($) {
		var $stack = $('#aef-stack');
		if ($stack.length && $.fn.sortable) {
			$stack.sortable({ handle: '.aef-handle', axis: 'y', placeholder: 'aef-card' });
		}
		function swap($item, dir) {
			if (dir < 0) { $item.prev('li').before($item); }
			else { $item.next('li').after($item); }
		}
		$(document).on('click', '.aef-up', function () { swap($(this).closest('li'), -1); });
		$(document).on('click', '.aef-down', function () { swap($(this).closest('li'), 1); });
		$(document).on('click', '.aef-remove', function () {
			var $card = $(this).closest('li');
			$card.find('.aef-on').prop('checked', false);
			$card.addClass('is-off');
			$card.find('.aef-badge').text('Sẽ ẩn khi lưu');
		});
	});
	</script>
	<?php
}

add_action( 'admin_enqueue_scripts', 'aef_home_admin_scripts' );
function aef_home_admin_scripts( $hook ) {
	if ( false === strpos( $hook, 'aef-home-blocks' ) ) {
		return;
	}
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_media();
}

add_action( 'admin_bar_menu', 'aef_admin_bar_home', 80 );
function aef_admin_bar_home( $bar ) {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	$bar->add_node(
		array(
			'id'    => 'aef-home-blocks',
			'title' => 'Sửa khối trang chủ',
			'href'  => admin_url( 'admin.php?page=aef-home-blocks' ),
		)
	);
	$bar->add_node(
		array(
			'id'    => 'aef-about',
			'title' => 'Sửa Giới thiệu',
			'href'  => admin_url( 'admin.php?page=aef-about' ),
		)
	);
	$bar->add_node(
		array(
			'id'    => 'aef-topics',
			'title' => 'Sửa Chuyên đề',
			'href'  => admin_url( 'admin.php?page=aef-topics' ),
		)
	);
	$bar->add_node(
		array(
			'id'    => 'aef-chrome',
			'title' => 'Sửa menu / ribbon',
			'href'  => admin_url( 'admin.php?page=aef-chrome' ),
		)
	);
	$bar->add_node(
		array(
			'id'    => 'aef-partner-logos',
			'title' => 'Logo trang chủ',
			'href'  => admin_url( 'admin.php?page=aef-partner-logos' ),
		)
	);
	$bar->add_node(
		array(
			'id'    => 'aef-custom-css',
			'title' => 'CSS Custom',
			'href'  => admin_url( 'admin.php?page=aef-custom-css' ),
		)
	);
}

add_action( 'admin_enqueue_scripts', 'aef_partner_logos_scripts' );
function aef_partner_logos_scripts( $hook ) {
	if ( false === strpos( $hook, 'aef-partner-logos' ) ) {
		return;
	}
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_media();
}

function aef_partner_bundled_logo_map() {
	$map = array();
	if ( ! function_exists( 'aef_partner_groups' ) ) {
		return $map;
	}
	foreach ( aef_partner_groups() as $group ) {
		if ( empty( $group['items'] ) ) {
			continue;
		}
		foreach ( $group['items'] as $item ) {
			if ( ! empty( $item[0] ) && ! empty( $item[1] ) ) {
				$map[ $item[0] ] = $item[1];
			}
		}
	}
	return $map;
}

function aef_apply_bundled_partner_logos() {
	$map = aef_partner_bundled_logo_map();
	if ( ! $map ) {
		return 0;
	}
	$q = new WP_Query(
		array(
			'post_type'      => 'aef_partner',
			'posts_per_page' => 80,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		)
	);
	$n = 0;
	while ( $q->have_posts() ) {
		$q->the_post();
		$id    = get_the_ID();
		$names = array( get_the_title(), get_post_meta( $id, 'title_en', true ), get_post_meta( $id, 'title_vi', true ) );
		$url   = '';
		foreach ( $names as $name ) {
			$name = trim( (string) $name );
			if ( $name && isset( $map[ $name ] ) ) {
				$url = $map[ $name ];
				break;
			}
		}
		if ( $url && ! get_post_meta( $id, 'logo_url', true ) && ! get_post_thumbnail_id( $id ) ) {
			update_post_meta( $id, 'logo_url', esc_url_raw( $url ) );
			$n++;
		}
		if ( '' === (string) get_post_meta( $id, 'carousel_on', true ) ) {
			update_post_meta( $id, 'carousel_on', '1' );
		}
	}
	wp_reset_postdata();
	return $n;
}

add_action( 'init', 'aef_attach_partner_logos', 30 );
function aef_attach_partner_logos() {
	if ( '1' === (string) get_option( 'aef_partner_logos_attached' ) ) {
		return;
	}
	aef_apply_bundled_partner_logos();
	update_option( 'aef_partner_logos_attached', '1' );
}

function aef_partner_logos_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	if ( isset( $_POST['aef_attach_logos'] ) && check_admin_referer( 'aef_partner_logos' ) ) {
		delete_option( 'aef_partner_logos_attached' );
		$n = aef_apply_bundled_partner_logos();
		update_option( 'aef_partner_logos_attached', '1' );
		echo '<div class="updated notice"><p>Đã gắn ' . intval( $n ) . ' logo từ bộ theme (chỉ những đối tác chưa có ảnh).</p></div>';
	}

	if ( isset( $_POST['aef_save_logos'] ) && check_admin_referer( 'aef_partner_logos' ) ) {
		$ids    = isset( $_POST['logo_order'] ) ? array_map( 'absint', (array) wp_unslash( $_POST['logo_order'] ) ) : array();
		$on     = isset( $_POST['carousel_on'] ) ? (array) wp_unslash( $_POST['carousel_on'] ) : array();
		$thumbs = isset( $_POST['thumb_id'] ) ? (array) wp_unslash( $_POST['thumb_id'] ) : array();
		$i      = 0;
		foreach ( $ids as $id ) {
			if ( ! $id || 'aef_partner' !== get_post_type( $id ) || ! current_user_can( 'edit_post', $id ) ) {
				continue;
			}
			wp_update_post(
				array(
					'ID'         => $id,
					'menu_order' => $i,
				)
			);
			$show = ( isset( $on[ $id ] ) && '1' === (string) $on[ $id ] ) ? '1' : '0';
			update_post_meta( $id, 'carousel_on', $show );
			if ( isset( $thumbs[ $id ] ) ) {
				$tid = absint( $thumbs[ $id ] );
				if ( $tid ) {
					set_post_thumbnail( $id, $tid );
				}
			}
			$i++;
		}
		echo '<div class="updated notice"><p>Đã lưu thứ tự logo. <a href="' . esc_url( home_url( '/' ) ) . '" target="_blank" rel="noopener">Xem trang chủ</a></p></div>';
	}

	$q = new WP_Query(
		array(
			'post_type'      => 'aef_partner',
			'posts_per_page' => 80,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		)
	);
	$tiers = function_exists( 'aef_partner_tiers' ) ? aef_partner_tiers() : array();

	echo '<div class="wrap aef-desk"><h1>Logo trang chủ</h1>';
	echo '<p>Kéo hàng (hoặc ↑ ↓) để đổi thứ tự carousel. Bỏ chọn <strong>Hiện</strong> thì logo ẩn trên trang chủ nhưng vẫn còn trong danh sách Đối tác. Ảnh đại diện (nếu có) được ưu tiên hơn file theme.</p>';
	echo '<p><a class="button" href="' . esc_url( admin_url( 'post-new.php?post_type=aef_partner' ) ) . '">Thêm đối tác</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=aef_partner' ) ) . '">Danh sách đối tác</a> ';
	echo '<a class="button" href="' . esc_url( home_url( '/' ) ) . '" target="_blank" rel="noopener">Xem trang chủ</a></p>';

	echo '<div class="aef-logo-preview-wrap"><p class="description">Xem trước thứ tự đang hiện</p><div class="aef-logo-preview" id="aef-logo-preview"></div></div>';

	echo '<form method="post" id="aef-logo-form">';
	wp_nonce_field( 'aef_partner_logos' );

	if ( ! $q->have_posts() ) {
		echo '<p>Chưa có đối tác. Bấm <strong>Thêm đối tác</strong> hoặc tải lại trang để gắn logo có sẵn.</p>';
	} else {
		echo '<ol class="aef-stack" id="aef-logo-stack">';
		while ( $q->have_posts() ) {
			$q->the_post();
			$id    = get_the_ID();
			$thumb = (int) get_post_thumbnail_id( $id );
			$src   = function_exists( 'aef_partner_logo_src' ) ? aef_partner_logo_src( $id, 'medium' ) : get_the_post_thumbnail_url( $id, 'medium' );
			$on    = get_post_meta( $id, 'carousel_on', true );
			if ( '' === $on ) {
				$on = '1';
			}
			$visible = '1' === (string) $on;
			$tier    = get_post_meta( $id, 'tier', true );
			$tier_l  = ( $tier && isset( $tiers[ $tier ] ) ) ? $tiers[ $tier ]['vi'] : $tier;
			$field   = 'thumb_' . $id;
			echo '<li class="aef-card aef-logo-card' . ( $visible ? '' : ' is-off' ) . '" data-id="' . esc_attr( (string) $id ) . '" data-name="' . esc_attr( get_the_title() ) . '">';
			echo '<input type="hidden" name="logo_order[]" value="' . esc_attr( (string) $id ) . '">';
			echo '<div class="aef-card-bar">';
			echo '<span class="aef-handle" title="Kéo để đổi thứ tự">⋮⋮</span>';
			echo '<span class="aef-logo-thumb">';
			if ( $src ) {
				echo '<img id="' . esc_attr( $field ) . '-prev" src="' . esc_url( $src ) . '" alt="">';
			} else {
				echo '<img id="' . esc_attr( $field ) . '-prev" src="" alt="" style="display:none">';
				echo '<span class="aef-logo-missing">Chưa có logo</span>';
			}
			echo '</span>';
			echo '<div class="aef-logo-meta"><strong>' . esc_html( get_the_title() ) . '</strong>';
			if ( $tier_l ) {
				echo '<span class="aef-logo-tier">' . esc_html( $tier_l ) . '</span>';
			}
			echo '</div>';
			echo '<span class="aef-badge">' . ( $visible ? 'Đang hiện' : 'Đã ẩn' ) . '</span>';
			echo '<span class="aef-move">';
			echo '<button type="button" class="button aef-up">↑</button> ';
			echo '<button type="button" class="button aef-down">↓</button>';
			echo '</span>';
			echo '<label class="aef-hide"><input type="hidden" name="carousel_on[' . esc_attr( (string) $id ) . ']" value="0">';
			echo '<input type="checkbox" class="aef-on" name="carousel_on[' . esc_attr( (string) $id ) . ']" value="1"' . checked( $visible, true, false ) . '> Hiện</label>';
			echo '<input type="hidden" name="thumb_id[' . esc_attr( (string) $id ) . ']" id="' . esc_attr( $field ) . '" value="' . esc_attr( $thumb ? (string) $thumb : '' ) . '">';
			echo '<button type="button" class="button aef-pick" data-target="' . esc_attr( $field ) . '">Đổi logo</button> ';
			echo '<a class="button-link" href="' . esc_url( get_edit_post_link( $id, 'raw' ) ) . '">Sửa</a>';
			echo '</div></li>';
		}
		echo '</ol>';
	}
	wp_reset_postdata();

	submit_button( 'Lưu thứ tự logo', 'primary', 'aef_save_logos' );
	echo '<p class="description">Nếu danh sách chưa có ảnh: ';
	submit_button( 'Gắn logo từ bộ theme', 'secondary', 'aef_attach_logos', false );
	echo '</p>';
	echo '</form></div>';
	aef_partner_logos_assets();
	aef_admin_media_picker_js();
}

function aef_partner_logos_assets() {
	?>
	<style>
		.aef-logo-preview-wrap{max-width:1100px;margin:0 0 18px;background:#fff;border:1px solid #c3c4c7;border-radius:4px;padding:12px 14px}
		.aef-logo-preview{display:flex;flex-wrap:wrap;gap:8px;min-height:52px}
		.aef-logo-preview .chip{display:flex;align-items:center;justify-content:center;width:120px;height:52px;background:#f6f7f7;border:1px solid #dcdcde;border-radius:4px;padding:6px}
		.aef-logo-preview .chip img{max-width:100%;max-height:40px;object-fit:contain}
		.aef-stack{list-style:none;margin:0 0 16px;padding:0;max-width:1100px}
		.aef-logo-card{background:#fff;border:1px solid #c3c4c7;border-radius:4px;margin:0 0 8px;padding:10px 12px}
		.aef-logo-card.is-off{opacity:.62;background:#f6f7f7}
		.aef-card-bar{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
		.aef-handle{cursor:grab;color:#787c82;letter-spacing:-2px;user-select:none}
		.aef-logo-thumb{width:96px;height:44px;display:flex;align-items:center;justify-content:center;background:#f6f7f7;border:1px solid #dcdcde;border-radius:4px;overflow:hidden}
		.aef-logo-thumb img{max-width:88px;max-height:38px;object-fit:contain}
		.aef-logo-missing{font-size:11px;color:#8c8f94}
		.aef-logo-meta{display:flex;flex-direction:column;gap:2px;min-width:160px}
		.aef-logo-tier{font-size:12px;color:#646970}
		.aef-badge{font-size:11px;padding:2px 8px;border-radius:10px;background:#d5f0d8;color:#1e4620}
		.aef-logo-card.is-off .aef-badge{background:#f0f0f1;color:#50575e}
		.aef-move{margin-left:auto}
		.aef-hide{margin:0 8px}
		.aef-logo-card.ui-sortable-helper{box-shadow:0 8px 24px rgba(0,0,0,.12)}
	</style>
	<script>
	jQuery(function ($) {
		var $stack = $('#aef-logo-stack');
		if ($stack.length && $.fn.sortable) {
			$stack.sortable({ handle: '.aef-handle', axis: 'y', placeholder: 'aef-card', update: rebuildPreview });
		}
		function swap($item, dir) {
			if (dir < 0) { $item.prev('li').before($item); }
			else { $item.next('li').after($item); }
			rebuildPreview();
		}
		function rebuildPreview() {
			var html = '';
			$stack.children('li').each(function () {
				var $li = $(this);
				if (!$li.find('.aef-on').prop('checked')) return;
				var src = $li.find('.aef-logo-thumb img').attr('src');
				if (!src) return;
				html += '<span class="chip"><img src="' + src + '" alt=""></span>';
			});
			$('#aef-logo-preview').html(html || '<span class="description">Không có logo đang hiện.</span>');
		}
		$(document).on('click', '.aef-up', function () { swap($(this).closest('li'), -1); });
		$(document).on('click', '.aef-down', function () { swap($(this).closest('li'), 1); });
		$(document).on('change', '#aef-logo-stack .aef-on', function () {
			var $card = $(this).closest('li');
			$card.toggleClass('is-off', !this.checked);
			$card.find('.aef-badge').text(this.checked ? 'Đang hiện' : 'Đã ẩn');
			rebuildPreview();
		});
		rebuildPreview();
	});
	</script>
	<?php
}

function aef_schedule_order_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	if ( isset( $_POST['aef_save_schedule_order'] ) && check_admin_referer( 'aef_schedule_order' ) ) {
		$groups = isset( $_POST['order'] ) ? (array) wp_unslash( $_POST['order'] ) : array();
		$saved  = 0;
		foreach ( $groups as $ids ) {
			$i = 0;
			foreach ( (array) $ids as $raw_id ) {
				$id = absint( $raw_id );
				if ( ! $id || 'aef_session' !== get_post_type( $id ) || ! current_user_can( 'edit_post', $id ) ) {
					continue;
				}
				if ( (int) get_post_field( 'menu_order', $id ) !== $i ) {
					wp_update_post( array( 'ID' => $id, 'menu_order' => $i ) );
				}
				$i++;
				$saved++;
			}
		}
		echo '<div class="updated notice"><p>Đã lưu thứ tự cho ' . intval( $saved ) . ' phiên.</p></div>';
	}

	$days = get_terms( array( 'taxonomy' => 'aef_day', 'hide_empty' => false, 'orderby' => 'term_id' ) );
	if ( is_wp_error( $days ) ) {
		$days = array();
	}
	$rooms = aef_room_choices();

	echo '<div class="wrap aef-desk"><h1>Sắp xếp chương trình</h1>';
	echo '<p>Kéo (hoặc dùng nút ↑ ↓) để đổi thứ tự phiên trong từng ngày — thứ tự này quyết định phiên nào hiện trước trên trang chủ và trang /programme/. Muốn đổi ngày, phòng, hay bật/tắt hiện ở trang chủ, vào sửa từng phiên (bấm "Sửa").</p>';
	echo '<form method="post">';
	wp_nonce_field( 'aef_schedule_order' );

	if ( ! $days ) {
		echo '<p class="description">Chưa có "Lớp chương trình" (taxonomy aef_day) nào.</p>';
	}

	foreach ( $days as $day ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'aef_session',
				'posts_per_page' => 100,
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'tax_query'      => array(
					array(
						'taxonomy' => 'aef_day',
						'field'    => 'slug',
						'terms'    => $day->slug,
					),
				),
			)
		);
		echo '<h2>' . esc_html( $day->name ) . '</h2>';
		if ( ! $q->have_posts() ) {
			echo '<p class="description">Chưa có phiên nào trong ngày này.</p>';
			continue;
		}
		echo '<ol class="aef-stack aef-sched-stack" data-day="' . esc_attr( $day->slug ) . '">';
		while ( $q->have_posts() ) {
			$q->the_post();
			$id       = get_the_ID();
			$room_key = get_post_meta( $id, 'room', true );
			$room_lbl = isset( $rooms[ $room_key ] ) ? $rooms[ $room_key ] : ( $room_key ? $room_key : '— chưa gán phòng —' );
			$time     = get_post_meta( $id, 'time', true );
			$home_on  = '1' === (string) get_post_meta( $id, 'show_on_home', true );
			echo '<li class="aef-card" data-id="' . esc_attr( (string) $id ) . '">';
			echo '<input type="hidden" name="order[' . esc_attr( $day->slug ) . '][]" value="' . esc_attr( (string) $id ) . '">';
			echo '<span class="aef-handle" title="Kéo để đổi thứ tự">⋮⋮</span> ';
			echo '<strong>' . esc_html( get_the_title() ) . '</strong> ';
			echo '<span class="aef-badge">' . esc_html( $room_lbl ) . '</span>';
			if ( $time ) {
				echo ' <span class="aef-badge">' . esc_html( $time ) . '</span>';
			}
			if ( $home_on ) {
				echo ' <span class="aef-badge" style="background:#d5f0d8;color:#1e4620">Trang chủ</span>';
			}
			echo ' <span class="aef-move"><button type="button" class="button aef-up">↑</button> <button type="button" class="button aef-down">↓</button></span>';
			echo ' <a class="button-link" href="' . esc_url( get_edit_post_link( $id, 'raw' ) ) . '">Sửa</a>';
			echo '</li>';
		}
		echo '</ol>';
		wp_reset_postdata();
	}

	submit_button( 'Lưu thứ tự', 'primary', 'aef_save_schedule_order' );
	echo '</form></div>';
	aef_schedule_order_assets();
}

function aef_schedule_order_assets() {
	?>
	<style>
		.aef-sched-stack{list-style:none;margin:0 0 24px;padding:0;max-width:900px}
		.aef-sched-stack .aef-card{background:#fff;border:1px solid #c3c4c7;border-radius:4px;margin:0 0 6px;padding:8px 10px;display:flex;align-items:center;gap:8px;flex-wrap:wrap}
		.aef-sched-stack .aef-handle{cursor:grab;color:#787c82;letter-spacing:-2px;user-select:none}
		.aef-sched-stack .aef-badge{font-size:11px;padding:2px 8px;border-radius:10px;background:#f0f0f1;color:#50575e}
		.aef-sched-stack .aef-move{margin-left:auto}
		.aef-sched-stack .ui-sortable-helper{box-shadow:0 8px 24px rgba(0,0,0,.12)}
	</style>
	<script>
	jQuery(function ($) {
		$('.aef-sched-stack').each(function () {
			if ($.fn.sortable) {
				$(this).sortable({ handle: '.aef-handle', axis: 'y', placeholder: 'aef-card' });
			}
		});
		function swap($item, dir) {
			if (dir < 0) { $item.prev('li').before($item); }
			else { $item.next('li').after($item); }
		}
		$(document).on('click', '.aef-up', function () { swap($(this).closest('li'), -1); });
		$(document).on('click', '.aef-down', function () { swap($(this).closest('li'), 1); });
	});
	</script>
	<?php
}

add_action( 'wp_nav_menu_item_custom_fields', 'aef_menu_item_fields', 10, 2 );
function aef_menu_item_fields( $item_id, $item ) {
	$en = get_post_meta( $item_id, '_aef_title_en', true );
	$vi = get_post_meta( $item_id, '_aef_title_vi', true );
	if ( ! $en ) {
		$en = $item->title;
	}
	echo '<p class="description description-wide"><label>English<br>';
	echo '<input type="text" class="widefat" name="aef_title_en[' . esc_attr( $item_id ) . ']" value="' . esc_attr( $en ) . '"></label></p>';
	echo '<p class="description description-wide"><label>Tiếng Việt<br>';
	echo '<input type="text" class="widefat" name="aef_title_vi[' . esc_attr( $item_id ) . ']" value="' . esc_attr( $vi ) . '"></label></p>';
}

add_action( 'wp_update_nav_menu_item', 'aef_menu_item_save', 10, 2 );
function aef_menu_item_save( $menu_id, $item_id ) {
	if ( isset( $_POST['aef_title_en'][ $item_id ] ) ) {
		update_post_meta( $item_id, '_aef_title_en', sanitize_text_field( wp_unslash( $_POST['aef_title_en'][ $item_id ] ) ) );
	}
	if ( isset( $_POST['aef_title_vi'][ $item_id ] ) ) {
		update_post_meta( $item_id, '_aef_title_vi', sanitize_text_field( wp_unslash( $_POST['aef_title_vi'][ $item_id ] ) ) );
	}
}

add_action( 'admin_init', 'aef_seed_partners' );
function aef_seed_partners() {
	if ( get_option( 'aef_partners_seeded' ) ) {
		return;
	}
	$n = wp_count_posts( 'aef_partner' );
	if ( $n && (int) $n->publish > 0 ) {
		update_option( 'aef_partners_seeded', '1' );
		return;
	}
	if ( ! function_exists( 'aef_partner_groups' ) ) {
		return;
	}
	$map = array( 0 => 'convening', 1 => 'accompanying', 2 => 'media' );
	$i   = 0;
	foreach ( aef_partner_groups() as $gi => $group ) {
		$tier = isset( $map[ $gi ] ) ? $map[ $gi ] : 'other';
		foreach ( $group['items'] as $item ) {
			$id = wp_insert_post(
				array(
					'post_type'   => 'aef_partner',
					'post_status' => 'publish',
					'post_title'  => $item[0],
					'menu_order'  => $i++,
				)
			);
			if ( $id && ! is_wp_error( $id ) ) {
				update_post_meta( $id, 'title_en', $item[0] );
				update_post_meta( $id, 'title_vi', $item[0] );
				update_post_meta( $id, 'tier', $tier );
				if ( ! empty( $item[1] ) ) {
					update_post_meta( $id, 'logo_url', esc_url_raw( $item[1] ) );
				}
				update_post_meta( $id, 'carousel_on', '1' );
			}
		}
	}
	update_option( 'aef_partners_seeded', '1' );
}

add_action( 'admin_init', 'aef_maybe_flush' );
function aef_maybe_flush() {
	if ( '2' === (string) get_option( 'aef_flush_media_1' ) ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'aef_flush_media_1', '2' );
}

add_action( 'admin_init', 'aef_seed_bilingual_menus' );
function aef_seed_bilingual_menus() {
	if ( '2' === (string) get_option( 'aef_menus_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'wp_create_nav_menu' ) ) {
		return;
	}
	$sets = array(
		'primary'        => array(
			'AEF Header',
			array(
				array( '/about/', 'About', 'Giới thiệu' ),
				array( '/programme/', 'Programme', 'Chương trình' ),
				array( '/speakers/', 'Speakers', 'Diễn giả' ),
				array( '/2026/media/', 'Media', 'Truyền thông' ),
				array( '/travel/', 'Travel', 'Cẩm nang' ),
			),
		),
		'footer_forum'   => array(
			'AEF Footer 2026',
			array(
				array( '/programme/', 'The Agenda', 'Chương trình nghị sự' ),
				array( '/programme/', 'Programme', 'Chương trình' ),
				array( '/speakers/', 'People', 'Diễn giả' ),
				array( '/2026/partners/', 'Partners', 'Đối tác' ),
			),
		),
		'footer_support' => array(
			'AEF Footer Attend',
			array(
				array( '/2026/delegates/how-to-register/', 'How to register', 'Cách đăng ký' ),
				array( '/travel/', 'Venue & access', 'Địa điểm và ra vào' ),
				array( '/travel/', 'Travel kit', 'Cẩm nang đi lại' ),
				array( '/about/', 'About', 'Giới thiệu' ),
			),
		),
		'footer_follow'  => array(
			'AEF Footer Institutional',
			array(
				array( '/about/', 'About the Forum', 'Về Diễn đàn' ),
				array( '/editions/', 'Editions', 'Các kỳ Diễn đàn' ),
				array( '/2026/media/', 'Media Hub', 'Trung tâm truyền thông' ),
				array( '/editions/2025/', 'AEF 2025', 'AEF 2025' ),
			),
		),
	);
	$locations = get_theme_mod( 'nav_menu_locations' );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}
	foreach ( $sets as $loc => $pack ) {
		$menu    = wp_get_nav_menu_object( $pack[0] );
		$menu_id = $menu ? (int) $menu->term_id : 0;
		if ( ! $menu_id ) {
			$menu_id = wp_create_nav_menu( $pack[0] );
			if ( is_wp_error( $menu_id ) ) {
				continue;
			}
		}
		$existing = wp_get_nav_menu_items( $menu_id );
		if ( empty( $existing ) ) {
			foreach ( $pack[1] as $i => $row ) {
				$item_id = wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'    => $row[1],
						'menu-item-url'      => home_url( $row[0] ),
						'menu-item-status'   => 'publish',
						'menu-item-position' => $i + 1,
						'menu-item-type'     => 'custom',
					)
				);
				if ( $item_id && ! is_wp_error( $item_id ) ) {
					update_post_meta( $item_id, '_aef_title_en', $row[1] );
					update_post_meta( $item_id, '_aef_title_vi', $row[2] );
				}
			}
		}
		$locations[ $loc ] = $menu_id;
	}
	set_theme_mod( 'nav_menu_locations', $locations );
	update_option( 'aef_menus_seeded', '2' );
}

add_filter( 'manage_aef_story_posts_columns', 'aef_story_columns' );
function aef_story_columns( $cols ) {
	$cols['aef_kind'] = 'Loại';
	$cols['aef_en']   = 'EN';
	$cols['aef_vi']   = 'VI';
	return $cols;
}

add_action( 'manage_aef_story_posts_custom_column', 'aef_story_column', 10, 2 );
function aef_story_column( $col, $post_id ) {
	if ( 'aef_kind' === $col ) {
		$kinds = aef_story_kinds();
		$kind  = get_post_meta( $post_id, 'story_kind', true );
		echo isset( $kinds[ $kind ] ) ? esc_html( $kinds[ $kind ]['vi'] ) : '—';
	}
	if ( 'aef_en' === $col ) {
		echo get_post_meta( $post_id, 'title_en', true ) ? '●' : '○';
	}
	if ( 'aef_vi' === $col ) {
		echo get_post_meta( $post_id, 'title_vi', true ) ? '●' : '○';
	}
}

function aef_admin_pair( $all, $base, $label, $long = false ) {
	echo '<p><label><strong>' . esc_html( $label ) . '</strong></label></p>';
	$en = isset( $all[ $base . '_en' ] ) ? $all[ $base . '_en' ] : '';
	$vi = isset( $all[ $base . '_vi' ] ) ? $all[ $base . '_vi' ] : '';
	if ( $long ) {
		echo '<p><textarea class="large-text" rows="4" name="' . esc_attr( $base . '_en' ) . '" placeholder="English">' . esc_textarea( $en ) . '</textarea></p>';
		echo '<p><textarea class="large-text" rows="4" name="' . esc_attr( $base . '_vi' ) . '" placeholder="Tiếng Việt">' . esc_textarea( $vi ) . '</textarea></p>';
	} else {
		echo '<p><input type="text" class="large-text" name="' . esc_attr( $base . '_en' ) . '" value="' . esc_attr( $en ) . '" placeholder="English"></p>';
		echo '<p><input type="text" class="large-text" name="' . esc_attr( $base . '_vi' ) . '" value="' . esc_attr( $vi ) . '" placeholder="Tiếng Việt"></p>';
	}
}

function aef_admin_image( $all, $key, $label, $default_src = '' ) {
	$id  = isset( $all[ $key ] ) ? absint( $all[ $key ] ) : 0;
	$src = $id ? wp_get_attachment_image_url( $id, 'medium' ) : $default_src;
	echo '<p><strong>' . esc_html( $label ) . '</strong></p>';
	echo '<p>';
	$show = $src ? 'block' : 'none';
	echo '<img id="' . esc_attr( $key ) . '-prev" src="' . esc_url( $src ) . '" alt="" data-default="' . esc_url( $default_src ) . '" style="max-width:240px;height:auto;display:' . esc_attr( $show ) . ';margin:0 0 8px">';
	echo '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" value="' . esc_attr( $id ? (string) $id : '' ) . '">';
	echo '<button type="button" class="button aef-pick" data-target="' . esc_attr( $key ) . '">Chọn ảnh từ thư viện</button> ';
	echo '<button type="button" class="button aef-clear" data-target="' . esc_attr( $key ) . '">Dùng ảnh mặc định</button>';
	echo '</p>';
}

function aef_about_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	if ( isset( $_POST['aef_save_about'] ) && check_admin_referer( 'aef_about' ) ) {
		$defaults = aef_about_defaults();
		$defs     = aef_about_block_defs();
		$out      = array();
		foreach ( $defaults as $key => $fallback ) {
			if ( 0 === strpos( $key, 'about_block_' ) ) {
				$out[ $key ] = empty( $_POST[ $key ] ) ? '0' : '1';
				continue;
			}
			if ( '_id' === substr( $key, -3 ) ) {
				$out[ $key ] = isset( $_POST[ $key ] ) ? (string) absint( $_POST[ $key ] ) : '0';
				continue;
			}
			if ( isset( $_POST[ $key ] ) ) {
				$out[ $key ] = wp_kses_post( wp_unslash( $_POST[ $key ] ) );
			} else {
				$out[ $key ] = $fallback;
			}
		}
		update_option( 'aef_about', $out );
		if ( function_exists( 'aef_settings' ) ) {
			$set  = aef_settings();
			$hkeys = array(
				'host_1_name_en', 'host_1_name_vi', 'host_1_role_en', 'host_1_role_vi',
				'host_2_name_en', 'host_2_name_vi', 'host_2_role_en', 'host_2_role_vi',
			);
			$dirty = false;
			foreach ( $hkeys as $hk ) {
				if ( isset( $_POST[ $hk ] ) ) {
					$set[ $hk ] = wp_kses_post( wp_unslash( $_POST[ $hk ] ) );
					$dirty      = true;
				}
			}
			if ( $dirty ) {
				update_option( 'aef_settings', $set );
			}
		}
		if ( function_exists( 'aef_copy_all' ) ) {
			$copy  = aef_copy_all();
			$ckeys = array(
				'home_hosts_3_role_en', 'home_hosts_3_role_vi', 'home_hosts_3_name_en', 'home_hosts_3_name_vi',
				'home_hosts_4_role_en', 'home_hosts_4_role_vi', 'home_hosts_4_name_en', 'home_hosts_4_name_vi',
			);
			$dirty = false;
			foreach ( $ckeys as $ck ) {
				if ( isset( $_POST[ $ck ] ) ) {
					$copy[ $ck ] = wp_kses_post( wp_unslash( $_POST[ $ck ] ) );
					$dirty       = true;
				}
			}
			if ( $dirty ) {
				update_option( 'aef_copy', $copy );
			}
		}
		$order_in = isset( $_POST['about_order'] ) ? (array) wp_unslash( $_POST['about_order'] ) : array();
		$order    = array();
		foreach ( $order_in as $id ) {
			$id = sanitize_key( $id );
			if ( isset( $defs[ $id ] ) && 'facts' !== $id && ! in_array( $id, $order, true ) ) {
				$order[] = $id;
			}
		}
		foreach ( aef_about_default_order() as $id ) {
			if ( ! in_array( $id, $order, true ) ) {
				$order[] = $id;
			}
		}
		update_option( 'aef_about_order', $order );
		echo '<div class="updated notice"><p>Đã lưu Giới thiệu. <a href="' . esc_url( home_url( '/about/' ) ) . '" target="_blank" rel="noopener">Xem trang</a></p></div>';
	}

	$a     = aef_about_all();
	$defs  = aef_about_block_defs();
	$order = aef_about_order();
	$on    = array();
	$off   = array();
	foreach ( $order as $id ) {
		if ( aef_about_block_on( $id ) ) {
			$on[] = $id;
		} else {
			$off[] = $id;
		}
	}

	echo '<div class="wrap aef-desk"><h1>Giới thiệu — từng khối</h1>';
	echo '<p>Kéo thẻ để đổi thứ tự trên <a href="' . esc_url( home_url( '/about/' ) ) . '" target="_blank" rel="noopener">/about/</a>. Ô trống = ẩn. Khối <strong>Mô hình tổ chức</strong> gồm tiêu đề, đoạn mô tả và bốn chủ thể.</p>';
	echo '<form method="post" id="aef-about-form">';
	wp_nonce_field( 'aef_about' );

	echo '<div class="aef-card" style="max-width:920px;background:#fff;border:1px solid #c3c4c7;padding:16px 18px;margin:0 0 14px">';
	echo '<h2>Mở trang</h2>';
	echo '<p class="description">Hero của /about/. Không kéo thứ tự — luôn đứng đầu.</p>';
	aef_admin_pair( $a, 'about_eyebrow', 'Eyebrow' );
	aef_admin_pair( $a, 'about_title', 'Tiêu đề' );
	aef_admin_pair( $a, 'about_deck', 'Đoạn dưới tiêu đề', true );
	aef_admin_pair( $a, 'about_credit', 'Dòng ghi dưới ảnh' );
	aef_admin_image( $a, 'about_opener_id', 'Ảnh opener', aef_img( 'visual/hcmc-dusk.jpg' ) );
	echo '</div>';

	echo '<ol class="aef-stack" id="aef-stack" style="max-width:920px">';
	foreach ( $on as $id ) {
		aef_about_block_card( $id, $defs[ $id ], $a, true );
	}
	echo '</ol>';
	if ( $off ) {
		echo '<h2>Đã gỡ khỏi trang</h2>';
		echo '<ol class="aef-stack aef-stack-off" style="max-width:920px">';
		foreach ( $off as $id ) {
			aef_about_block_card( $id, $defs[ $id ], $a, false );
		}
		echo '</ol>';
	}

	echo '<ol class="aef-stack" style="max-width:920px">';
	aef_about_block_card( 'facts', $defs['facts'], $a, aef_about_block_on( 'facts' ) );
	echo '</ol>';

	submit_button( 'Lưu Giới thiệu', 'primary', 'aef_save_about' );
	echo '</form></div>';
	aef_home_blocks_assets();
	aef_admin_media_picker_js();
}

function aef_about_block_card( $id, $def, $a, $visible ) {
	$sortable = ( 'facts' !== $id );
	echo '<li class="aef-card' . ( $visible ? '' : ' is-off' ) . '" data-id="' . esc_attr( $id ) . '" style="list-style:none">';
	if ( $sortable ) {
		echo '<input type="hidden" name="about_order[]" value="' . esc_attr( $id ) . '">';
	}
	echo '<div class="aef-card-bar">';
	if ( $sortable ) {
		echo '<span class="aef-handle" title="Kéo để đổi thứ tự">⋮⋮</span>';
	}
	echo '<strong>' . esc_html( $def['label'] ) . '</strong>';
	echo '<span class="aef-badge">' . ( $visible ? 'Đang hiện' : 'Đã ẩn' ) . '</span>';
	if ( $sortable ) {
		echo '<span class="aef-move"><button type="button" class="button aef-up">↑</button> <button type="button" class="button aef-down">↓</button></span>';
	} else {
		echo '<span class="aef-move"></span>';
	}
	echo '<label class="aef-hide"><input type="hidden" name="about_block_' . esc_attr( $id ) . '" value="0">';
	echo '<input type="checkbox" class="aef-on" name="about_block_' . esc_attr( $id ) . '" value="1"' . checked( $visible, true, false ) . '> Hiện</label>';
	echo '</div>';
	echo '<p class="description">' . esc_html( $def['help'] ) . '</p>';
	if ( ! empty( $def['image'] ) ) {
		foreach ( $def['image'] as $img_key => $img_label ) {
			aef_admin_image( $a, $img_key, $img_label );
			echo '<p class="description">Trống = giữ nền CSS của khối.</p>';
		}
	}
	if ( ! empty( $def['ids'] ) ) {
		foreach ( $def['ids'] as $img_key => $img_label ) {
			aef_admin_image( $a, $img_key, $img_label, aef_img( 'visual/hcmc-dusk.jpg' ) );
		}
	}
	if ( 'facts' === $id ) {
		echo '<p><label>Năm khởi đầu<br><input type="text" class="regular-text" name="about_fact_est" value="' . esc_attr( $a['about_fact_est'] ) . '"></label></p>';
		echo '<p><label>Email chung<br><input type="text" class="regular-text" name="about_mail_general" value="' . esc_attr( $a['about_mail_general'] ) . '"></label></p>';
		echo '<p><label>Email đại biểu<br><input type="text" class="regular-text" name="about_mail_delegates" value="' . esc_attr( $a['about_mail_delegates'] ) . '"></label></p>';
		echo '<p><label>Email báo chí<br><input type="text" class="regular-text" name="about_mail_press" value="' . esc_attr( $a['about_mail_press'] ) . '"></label></p>';
	}
	if ( ! empty( $def['fields'] ) ) {
		echo '<details' . ( 'hosts' === $id ? ' open' : '' ) . '><summary>Sửa câu chữ EN / VI</summary><div class="aef-fields">';
		foreach ( $def['fields'] as $base => $label ) {
			$is_long = ( false !== strpos( $base, '_p' ) || false !== strpos( $base, 'lead' ) || false !== strpos( $base, 'body' ) || false !== strpos( $base, 'quote' ) || false !== strpos( $base, 'deck' ) );
			if ( in_array( $base, array( 'about_fact_est' ), true ) ) {
				continue;
			}
			aef_admin_pair( $a, $base, $label, $is_long );
		}
		echo '</div></details>';
	}
	if ( 'hosts' === $id && function_exists( 'aef_settings' ) ) {
		$set  = aef_settings();
		$copy = function_exists( 'aef_copy_all' ) ? aef_copy_all() : array();
		echo '<details open><summary>Bốn chủ thể</summary><div class="aef-fields">';
		aef_admin_pair( $set, 'host_1_name', '1. Tên' );
		aef_admin_pair( $set, 'host_1_role', '1. Vai trò' );
		aef_admin_pair( $set, 'host_2_name', '2. Tên' );
		aef_admin_pair( $set, 'host_2_role', '2. Vai trò' );
		aef_admin_pair( $copy, 'home_hosts_3_name', '3. Tên (C4IR)' );
		aef_admin_pair( $copy, 'home_hosts_3_role', '3. Vai trò' );
		aef_admin_pair( $copy, 'home_hosts_4_name', '4. Tên (WEF)' );
		aef_admin_pair( $copy, 'home_hosts_4_role', '4. Vai trò' );
		echo '</div></details>';
	}
	echo '</li>';
}

function aef_topics_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	if ( isset( $_POST['aef_save_topics'] ) && check_admin_referer( 'aef_topics' ) ) {
		$defaults = aef_topics_defaults();
		$defs     = aef_topics_block_defs();
		$out      = array();
		foreach ( $defaults as $key => $fallback ) {
			if ( 0 === strpos( $key, 'topics_block_' ) || '_still_on' === substr( $key, -9 ) ) {
				$out[ $key ] = empty( $_POST[ $key ] ) ? '0' : '1';
				continue;
			}
			if ( '_id' === substr( $key, -3 ) ) {
				$out[ $key ] = isset( $_POST[ $key ] ) ? (string) absint( $_POST[ $key ] ) : '0';
				continue;
			}
			if ( isset( $_POST[ $key ] ) ) {
				$out[ $key ] = wp_kses_post( wp_unslash( $_POST[ $key ] ) );
			} else {
				$out[ $key ] = $fallback;
			}
		}
		update_option( 'aef_topics', $out );
		$order_in = isset( $_POST['topics_order'] ) ? (array) wp_unslash( $_POST['topics_order'] ) : array();
		$order    = array();
		foreach ( $order_in as $id ) {
			$id = sanitize_key( $id );
			if ( isset( $defs[ $id ] ) && ! in_array( $id, $order, true ) ) {
				$order[] = $id;
			}
		}
		foreach ( aef_topics_default_order() as $id ) {
			if ( ! in_array( $id, $order, true ) ) {
				$order[] = $id;
			}
		}
		update_option( 'aef_topics_order', $order );
		if ( function_exists( 'aef_inner_all' ) ) {
			$inner = aef_inner_all();
			foreach ( array( 'topics_eyebrow_en', 'topics_eyebrow_vi', 'topics_title_en', 'topics_title_vi', 'topics_deck_en', 'topics_deck_vi', 'topics_credit_en', 'topics_credit_vi', 'topics_bg_id' ) as $k ) {
				if ( isset( $out[ $k ] ) ) {
					$inner[ $k ] = $out[ $k ];
				}
			}
			update_option( 'aef_inner', $inner );
		}
		echo '<div class="updated notice"><p>Đã lưu Chuyên đề. <a href="' . esc_url( home_url( '/topics/' ) ) . '" target="_blank" rel="noopener">Xem trang</a></p></div>';
	}

	$a     = aef_topics_all();
	$defs  = aef_topics_block_defs();
	$order = aef_topics_order();
	$on    = array();
	$off   = array();
	foreach ( $order as $id ) {
		if ( aef_topics_block_on( $id ) ) {
			$on[] = $id;
		} else {
			$off[] = $id;
		}
	}

	echo '<div class="wrap aef-desk"><h1>Chuyên đề — bốn trụ cột</h1>';
	echo '<p>Kéo thẻ để đổi thứ tự trên <a href="' . esc_url( home_url( '/topics/' ) ) . '" target="_blank" rel="noopener">/topics/</a>. Ô trống = ẩn. Ảnh nền trống = giữ nền CSS. Bốn trụ cột là khung tư duy, không phải bốn phiên. Không thêm trụ cột thứ năm.</p>';
	echo '<form method="post" id="aef-topics-form">';
	wp_nonce_field( 'aef_topics' );

	echo '<div class="aef-card" style="max-width:920px;background:#fff;border:1px solid #c3c4c7;padding:16px 18px;margin:0 0 14px">';
	echo '<h2>Mở trang</h2>';
	echo '<p class="description">Hero của /topics/. Không kéo thứ tự — luôn đứng đầu.</p>';
	aef_admin_pair( $a, 'topics_eyebrow', 'Eyebrow' );
	aef_admin_pair( $a, 'topics_title', 'Tiêu đề' );
	aef_admin_pair( $a, 'topics_deck', 'Đoạn dưới tiêu đề', true );
	aef_admin_pair( $a, 'topics_credit', 'Dòng ghi dưới ảnh' );
	aef_admin_image( $a, 'topics_bg_id', 'Ảnh opener', aef_img( 'visual/pillar-megacity.jpg' ) );
	echo '</div>';

	echo '<ol class="aef-stack" id="aef-stack" style="max-width:920px">';
	foreach ( $on as $id ) {
		aef_topics_block_card( $id, $defs[ $id ], $a, true );
	}
	echo '</ol>';
	if ( $off ) {
		echo '<h2>Đã gỡ khỏi trang</h2>';
		echo '<ol class="aef-stack aef-stack-off" style="max-width:920px">';
		foreach ( $off as $id ) {
			aef_topics_block_card( $id, $defs[ $id ], $a, false );
		}
		echo '</ol>';
	}

	echo '<div class="aef-card" style="max-width:920px;background:#fff;border:1px solid #c3c4c7;padding:16px 18px;margin:0 0 14px">';
	echo '<h2>Dòng cuối trang</h2>';
	echo '<p class="description">Ô trống = ẩn. Nút phiên trống = ẩn liên kết.</p>';
	aef_admin_pair( $a, 'topics_note', 'Ghi chú dưới bốn trụ cột', true );
	aef_admin_pair( $a, 'topics_qs_h', 'Tiêu đề nhóm câu hỏi' );
	aef_admin_pair( $a, 'topics_sessions_cta', 'Nút sang Chương trình' );
	echo '<p><label><strong>URL nút Chương trình</strong><br><input type="text" class="large-text" name="topics_sessions_url" value="' . esc_attr( $a['topics_sessions_url'] ) . '" placeholder="/programme/"></label></p>';
	echo '</div>';

	submit_button( 'Lưu Chuyên đề', 'primary', 'aef_save_topics' );
	echo '</form></div>';
	aef_home_blocks_assets();
	aef_admin_media_picker_js();
}

function aef_topics_block_card( $id, $def, $a, $visible ) {
	$still_on = ! isset( $a[ $id . '_still_on' ] ) || '0' !== (string) $a[ $id . '_still_on' ];
	echo '<li class="aef-card' . ( $visible ? '' : ' is-off' ) . '" data-id="' . esc_attr( $id ) . '" style="list-style:none">';
	echo '<input type="hidden" name="topics_order[]" value="' . esc_attr( $id ) . '">';
	echo '<div class="aef-card-bar">';
	echo '<span class="aef-handle" title="Kéo để đổi thứ tự">⋮⋮</span>';
	echo '<strong>' . esc_html( $def['label'] ) . '</strong>';
	echo '<span class="aef-badge">' . ( $visible ? 'Đang hiện' : 'Đã ẩn' ) . '</span>';
	echo '<span class="aef-move"><button type="button" class="button aef-up">↑</button> <button type="button" class="button aef-down">↓</button></span>';
	echo '<label class="aef-hide"><input type="hidden" name="topics_block_' . esc_attr( $id ) . '" value="0">';
	echo '<input type="checkbox" class="aef-on" name="topics_block_' . esc_attr( $id ) . '" value="1"' . checked( $visible, true, false ) . '> Hiện</label>';
	echo '</div>';
	echo '<p class="description">' . esc_html( $def['help'] ) . ' Neo: <code>#pillar-' . esc_html( $def['slug'] ) . '</code></p>';
	echo '<p><label><strong>Số hiển thị</strong><br><input type="text" class="small-text" name="' . esc_attr( $id ) . '_n" value="' . esc_attr( isset( $a[ $id . '_n' ] ) ? $a[ $id . '_n' ] : $def['n'] ) . '" placeholder="01"></label></p>';
	aef_admin_image( $a, $id . '_bg_id', 'Ảnh nền khối' );
	echo '<p class="description">Trống = giữ nền CSS của khối.</p>';
	aef_admin_image( $a, $id . '_still_id', 'Ảnh minh họa trong chương', aef_img( $def['still'] ) );
	echo '<p><label><input type="hidden" name="' . esc_attr( $id ) . '_still_on" value="0">';
	echo '<input type="checkbox" name="' . esc_attr( $id ) . '_still_on" value="1"' . checked( $still_on, true, false ) . '> Hiện ảnh minh họa</label></p>';
	echo '<details><summary>Sửa câu chữ EN / VI</summary><div class="aef-fields">';
	aef_admin_pair( $a, $id . '_title', 'Tiêu đề (eyebrow)' );
	aef_admin_pair( $a, $id . '_short', 'Tên ngắn (thẻ trang chủ)' );
	aef_admin_pair( $a, $id . '_kicker', 'Dòng lớn (H2)' );
	aef_admin_pair( $a, $id . '_card', 'Đoạn dẫn', true );
	aef_admin_pair( $a, $id . '_body', 'Đoạn thân', true );
	aef_admin_pair( $a, $id . '_qs', 'Câu hỏi định hướng (mỗi dòng một câu)', true );
	aef_admin_pair( $a, $id . '_still_cap', 'Chú thích ảnh minh họa' );
	echo '</div></details>';
	echo '</li>';
}

function aef_inner_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	if ( isset( $_POST['aef_save_inner'] ) && check_admin_referer( 'aef_inner' ) ) {
		$defaults = aef_inner_defaults();
		$prev     = aef_inner_all();
		$out      = array();
		foreach ( $defaults as $key => $fallback ) {
			if ( 0 === strpos( $key, 'topics_' ) ) {
				$out[ $key ] = isset( $prev[ $key ] ) ? $prev[ $key ] : $fallback;
				continue;
			}
			if ( '_id' === substr( $key, -3 ) ) {
				$out[ $key ] = isset( $_POST[ $key ] ) ? (string) absint( $_POST[ $key ] ) : '0';
			} elseif ( isset( $_POST[ $key ] ) ) {
				$out[ $key ] = wp_kses_post( wp_unslash( $_POST[ $key ] ) );
			} else {
				$out[ $key ] = $fallback;
			}
		}
		update_option( 'aef_inner', $out );
		echo '<div class="updated notice"><p>Đã lưu opener trang trong. <a href="' . esc_url( home_url( '/2026/partners/' ) ) . '" target="_blank" rel="noopener">Partners</a></p></div>';
	}
	$c = aef_inner_all();
	echo '<div class="wrap aef-desk"><h1>Trang trong — opener</h1>';
	echo '<p>Hero chữ + ảnh của Partners. Topics sửa ở <a href="' . esc_url( admin_url( 'admin.php?page=aef-topics' ) ) . '">Chuyên đề</a>. About sửa ở <a href="' . esc_url( admin_url( 'admin.php?page=aef-about' ) ) . '">Giới thiệu</a>. Ô trống = ẩn dòng. Ảnh trống = ảnh mặc định theme.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'aef_inner' );
	echo '<div class="aef-card" style="max-width:920px;background:#fff;border:1px solid #c3c4c7;padding:16px 18px;margin:0 0 14px">';
	echo '<h2>Partners / Đơn vị &amp; đối tác</h2>';
	aef_admin_pair( $c, 'partners_eyebrow', 'Eyebrow' );
	aef_admin_pair( $c, 'partners_title', 'Tiêu đề' );
	aef_admin_pair( $c, 'partners_deck', 'Đoạn dưới tiêu đề', true );
	aef_admin_pair( $c, 'partners_credit', 'Dòng ghi dưới ảnh' );
	aef_admin_image( $c, 'partners_bg_id', 'Ảnh opener', aef_img( 'visual/pillar-private.jpg' ) );
	echo '</div>';
	submit_button( 'Lưu opener trang trong', 'primary', 'aef_save_inner' );
	echo '</form></div>';
	aef_admin_media_picker_js();
}

function aef_admin_media_picker_js() {
	?>
	<script>
	jQuery(function($){
		$(document).on('click','.aef-pick',function(e){
			e.preventDefault();
			var t=$(this).data('target');
			var f=wp.media({title:'Chọn ảnh',library:{type:'image'},multiple:false});
			f.on('select',function(){
				var a=f.state().get('selection').first().toJSON();
				var url=(a.sizes&&a.sizes.medium)?a.sizes.medium.url:a.url;
				$('#'+t).val(a.id);
				$('#'+t+'-prev').attr('src',url).show();
			});
			f.open();
		});
		$(document).on('click','.aef-clear',function(e){
			e.preventDefault();
			var t=$(this).data('target');
			var $prev=$('#'+t+'-prev');
			var d=$prev.attr('data-default')||'';
			$('#'+t).val('');
			if(d){ $prev.attr('src',d).show(); }
			else { $prev.attr('src','').hide(); }
		});
	});
	</script>
	<?php
}

add_action( 'admin_footer', 'aef_session_people_scripts' );
function aef_session_people_scripts() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'aef_session' !== $screen->post_type ) {
		return;
	}
	?>
	<script>
	jQuery(function($){
		function aefSyncThumb($row){
			var $sel=$row.find('.aef-person-id');
			var src=$sel.find('option:selected').attr('data-thumb')||'';
			var $img=$row.find('.aef-person-thumb');
			if(src){ $img.attr('src',src).css('visibility','visible'); }
			else { $img.attr('src','').css('visibility','hidden'); }
		}
		$(document).on('click','#aef-add-person',function(e){
			e.preventDefault();
			var tpl=document.getElementById('aef-person-tpl');
			if(!tpl){return;}
			var $row=$(tpl.innerHTML);
			$('#aef-people-rows').append($row);
			aefSyncThumb($row);
		});
		$(document).on('change','.aef-person-id',function(){
			aefSyncThumb($(this).closest('.aef-person-row'));
		});
		$(document).on('click','.aef-del-person',function(e){
			e.preventDefault();
			var $rows=$('#aef-people-rows .aef-person-row');
			if($rows.length<=1){
				$(this).closest('.aef-person-row').find('select').each(function(){ this.selectedIndex=0; });
				aefSyncThumb($(this).closest('.aef-person-row'));
				return;
			}
			$(this).closest('.aef-person-row').remove();
		});
	});
	</script>
	<?php
}

add_action( 'admin_enqueue_scripts', 'aef_about_admin_scripts' );
function aef_about_admin_scripts( $hook ) {
	if ( false === strpos( $hook, 'aef-about' ) && false === strpos( $hook, 'aef-coming' ) && false === strpos( $hook, 'aef-inner' ) && false === strpos( $hook, 'aef-topics' ) ) {
		return;
	}
	if ( false !== strpos( $hook, 'aef-about' ) || false !== strpos( $hook, 'aef-topics' ) ) {
		wp_enqueue_script( 'jquery-ui-sortable' );
	}
	wp_enqueue_media();
}

function aef_chrome_collect_links( $prefix, $max ) {
	$out = array();
	for ( $i = 0; $i < $max; $i++ ) {
		$out[] = array(
			'on'  => empty( $_POST[ $prefix . '_on' ][ $i ] ) ? '0' : '1',
			'url' => isset( $_POST[ $prefix . '_url' ][ $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ $prefix . '_url' ][ $i ] ) ) : '',
			'en'  => isset( $_POST[ $prefix . '_en' ][ $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ $prefix . '_en' ][ $i ] ) ) : '',
			'vi'  => isset( $_POST[ $prefix . '_vi' ][ $i ] ) ? sanitize_text_field( wp_unslash( $_POST[ $prefix . '_vi' ][ $i ] ) ) : '',
		);
	}
	return $out;
}

function aef_chrome_link_rows( $items, $prefix, $max, $title ) {
	echo '<h2>' . esc_html( $title ) . '</h2>';
	echo '<p class="description">URL nội bộ dạng <code>/about/</code>. URL ngoài bắt đầu bằng https://. Bỏ tick = ẩn.</p>';
	echo '<table class="widefat striped" style="max-width:1100px"><thead><tr><th>Hiện</th><th>URL</th><th>English</th><th>Tiếng Việt</th></tr></thead><tbody>';
	for ( $i = 0; $i < $max; $i++ ) {
		$it  = isset( $items[ $i ] ) ? $items[ $i ] : array( 'on' => '0', 'url' => '', 'en' => '', 'vi' => '' );
		$on  = ! empty( $it['on'] ) && '0' !== (string) $it['on'];
		echo '<tr>';
		echo '<td><input type="checkbox" name="' . esc_attr( $prefix ) . '_on[' . $i . ']" value="1"' . checked( $on, true, false ) . '></td>';
		echo '<td><input type="text" class="regular-text" name="' . esc_attr( $prefix ) . '_url[' . $i . ']" value="' . esc_attr( $it['url'] ) . '" placeholder="/about/"></td>';
		echo '<td><input type="text" class="regular-text" name="' . esc_attr( $prefix ) . '_en[' . $i . ']" value="' . esc_attr( $it['en'] ) . '"></td>';
		echo '<td><input type="text" class="regular-text" name="' . esc_attr( $prefix ) . '_vi[' . $i . ']" value="' . esc_attr( $it['vi'] ) . '"></td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

function aef_chrome_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	if ( isset( $_POST['aef_save_chrome'] ) && check_admin_referer( 'aef_chrome' ) ) {
		$defaults = aef_chrome_defaults();
		$out      = array();
		foreach ( $defaults as $key => $fallback ) {
			if ( in_array( $key, array( 'nav', 'visit', 'legal' ), true ) ) {
				continue;
			}
			if ( 0 === substr_compare( $key, '_on', -3 ) ) {
				$out[ $key ] = empty( $_POST[ $key ] ) ? '0' : '1';
			} elseif ( isset( $_POST[ $key ] ) ) {
				$out[ $key ] = wp_kses_post( wp_unslash( $_POST[ $key ] ) );
			} else {
				$out[ $key ] = $fallback;
			}
		}
		$out['nav']   = aef_chrome_collect_links( 'nav', 12 );
		$out['visit'] = aef_chrome_collect_links( 'visit', 4 );
		$out['legal'] = aef_chrome_collect_links( 'legal', 4 );
		update_option( 'aef_chrome', $out );
		echo '<div class="updated notice"><p>Đã lưu khung trang. <a href="' . esc_url( home_url( '/' ) ) . '" target="_blank" rel="noopener">Xem trang chủ</a></p></div>';
	}
	$c = aef_chrome_all();
	echo '<div class="wrap aef-desk"><h1>Khung trang</h1>';
	echo '<p>Ribbon dự thảo, menu trên, nút Đăng ký, chân trang. Không đổi màu/navy — đó là nhận diện. Chữ luôn có EN và VI.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'aef_chrome' );

	echo '<div class="aef-card" style="max-width:1100px;background:#fff;border:1px solid #c3c4c7;padding:16px 18px;margin:0 0 14px">';
	echo '<h2>Dải dự thảo (ribbon)</h2>';
	echo '<p><label><input type="hidden" name="ribbon_on" value="0"><input type="checkbox" name="ribbon_on" value="1"' . checked( $c['ribbon_on'], '1', false ) . '> Hiện dải dự thảo trên mọi trang</label></p>';
	aef_admin_pair( $c, 'ribbon_tag', 'Nhãn (INTERNAL DRAFT / DỰ THẢO)' );
	aef_admin_pair( $c, 'ribbon_text', 'Câu mô tả', true );
	echo '<p><label>URL nút<br><input type="text" class="regular-text" name="ribbon_link" value="' . esc_attr( $c['ribbon_link'] ) . '"></label></p>';
	aef_admin_pair( $c, 'ribbon_cta', 'Chữ nút' );
	echo '</div>';

	echo '<div class="aef-card" style="max-width:1100px;background:#fff;border:1px solid #c3c4c7;padding:16px 18px;margin:0 0 14px">';
	echo '<h2>Thanh trên cùng + nút Đăng ký</h2>';
	echo '<p><label><input type="hidden" name="util_on" value="0"><input type="checkbox" name="util_on" value="1"' . checked( $c['util_on'], '1', false ) . '> Hiện thanh C4IR</label></p>';
	aef_admin_pair( $c, 'util_label', 'Nhãn C4IR' );
	echo '<p><label>Nhãn ngắn (mobile)<br><input type="text" class="regular-text" name="util_short" value="' . esc_attr( $c['util_short'] ) . '"></label></p>';
	echo '<p><label>URL C4IR<br><input type="text" class="regular-text" name="util_url" value="' . esc_attr( $c['util_url'] ) . '"></label></p>';
	echo '<p><label><input type="hidden" name="cta_on" value="0"><input type="checkbox" name="cta_on" value="1"' . checked( $c['cta_on'], '1', false ) . '> Hiện nút Đăng ký</label></p>';
	aef_admin_pair( $c, 'cta_label', 'Nút Đăng ký' );
	echo '<p><label>URL Đăng ký<br><input type="text" class="regular-text" name="cta_url" value="' . esc_attr( $c['cta_url'] ) . '"></label></p>';
	aef_admin_pair( $c, 'menu_label', 'Chữ nút Menu (mobile)' );
	aef_admin_pair( $c, 'close_label', 'Chữ Đóng menu' );
	echo '</div>';

	aef_chrome_link_rows( $c['nav'], 'nav', 12, 'Menu chính — thêm nút bằng hàng trống (URL + EN + VI)' );
	echo '<p class="description" style="margin:8px 0 18px">12 chỗ. Tick Hiện, điền URL và chữ hai ngôn ngữ. Thứ tự hàng = thứ tự trên menu và cột footer Diễn đàn.</p>';
	aef_chrome_link_rows( $c['visit'], 'visit', 4, 'Cột footer — Chuyến đi' );
	aef_chrome_link_rows( $c['legal'], 'legal', 4, 'Điều khoản cuối trang (mỗi mục một URL)' );
	echo '<p class="description" style="margin:8px 0 18px">Ví dụ /terms-of-use/ hoặc https://… Tick Hiện. Có thể thêm mục thứ 4.</p>';

	echo '<div class="aef-card" style="max-width:1100px;background:#fff;border:1px solid #c3c4c7;padding:16px 18px;margin:18px 0 14px">';
	echo '<h2>Chân trang</h2>';
	aef_admin_pair( $c, 'footer_blurb', 'Đoạn giới thiệu', true );
	echo '<p><label>Dòng liên hệ<br><input type="text" class="large-text" name="footer_contact" value="' . esc_attr( $c['footer_contact'] ) . '"></label></p>';
	aef_admin_pair( $c, 'footer_h1', 'Tiêu đề cột 1 (AEF 2026)' );
	aef_admin_pair( $c, 'footer_h2', 'Tiêu đề cột 2 (Attend)' );
	aef_admin_pair( $c, 'footer_h3', 'Tiêu đề cột 3 (Institutional)' );
	echo '<p><a class="button" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">Mở Giao diện → Menu để thêm / sửa / sắp link</a></p>';
	echo '<p class="description">Mỗi mục menu có ô <strong>English</strong> và <strong>Tiếng Việt</strong>. Gán menu vào vị trí: Header, Footer AEF 2026, Footer Attend, Footer Institutional.</p>';
	aef_admin_pair( $c, 'footer_copy', 'Copyright' );
	echo '</div>';

	submit_button( 'Lưu khung trang', 'primary', 'aef_save_chrome' );
	echo '</form></div>';
}

function aef_coming_flag_keys() {
	return array( 'coming_on', 'coming_show_seal', 'coming_show_logo', 'coming_show_ribbon', 'coming_show_count', 'coming_show_meta', 'coming_show_hosts', 'coming_show_foot' );
}

function aef_coming_id_keys() {
	return array( 'coming_bg_id', 'coming_ribbon_id', 'coming_logo_id', 'coming_seal_id', 'coming_favicon_id' );
}

function aef_admin_on( $all, $key, $label ) {
	$on = isset( $all[ $key ] ) && '1' === (string) $all[ $key ];
	echo '<p><label><input type="hidden" name="' . esc_attr( $key ) . '" value="0"><input type="checkbox" name="' . esc_attr( $key ) . '" value="1"' . checked( $on, true, false ) . '> ' . esc_html( $label ) . '</label></p>';
}

function aef_admin_card_open( $title, $help = '' ) {
	echo '<div class="aef-card" style="max-width:960px;background:#fff;border:1px solid #c3c4c7;padding:16px 18px;margin:0 0 14px">';
	echo '<h2 style="margin-top:0">' . esc_html( $title ) . '</h2>';
	if ( $help ) {
		echo '<p class="description">' . esc_html( $help ) . '</p>';
	}
}

function aef_coming_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	if ( isset( $_POST['aef_save_coming'] ) && check_admin_referer( 'aef_coming' ) ) {
		$defaults = aef_coming_defaults();
		$flags    = aef_coming_flag_keys();
		$ids      = aef_coming_id_keys();
		$out      = array();
		foreach ( $defaults as $key => $fallback ) {
			if ( in_array( $key, $flags, true ) ) {
				$out[ $key ] = empty( $_POST[ $key ] ) ? '0' : '1';
			} elseif ( in_array( $key, $ids, true ) ) {
				$out[ $key ] = isset( $_POST[ $key ] ) ? (string) absint( $_POST[ $key ] ) : '0';
			} elseif ( isset( $_POST[ $key ] ) ) {
				$out[ $key ] = sanitize_text_field( wp_unslash( $_POST[ $key ] ) );
			} else {
				$out[ $key ] = $fallback;
			}
		}
		update_option( 'aef_coming', $out );
		echo '<div class="updated notice"><p>Đã lưu Coming soon. <a href="' . esc_url( home_url( '/?coming=1' ) ) . '" target="_blank" rel="noopener">Xem thử</a></p></div>';
	}
	$c = aef_coming_all();
	echo '<div class="wrap"><h1>Coming soon</h1>';
	echo '<p>Mỗi khối dưới đây là một vùng trên màn hình. Dòng trên = English, dòng dưới = Tiếng Việt. Ô trống = ẩn dòng đó. Ảnh để trống = dùng ảnh nhận diện mặc định trong theme. <strong>Admin đã đăng nhập vẫn thấy site đầy đủ</strong> trừ khi mở <a href="' . esc_url( home_url( '/?coming=1' ) ) . '" target="_blank">/?coming=1</a>.</p>';
	echo '<p>Bản tham chiếu layout Cybertech + Brand 9.9 (không thay trang chủ đang chạy): <a href="' . esc_url( home_url( '/?ref=cybertech' ) ) . '" target="_blank" rel="noopener">/?ref=cybertech</a> · <a href="' . esc_url( home_url( '/?ref=cybertech&lang=vi' ) ) . '" target="_blank" rel="noopener">bản VI</a>.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'aef_coming' );

	aef_admin_card_open( '1. Công tắc trang', 'Bật khi aef.vn chỉ hiện coming soon với khách chưa đăng nhập.' );
	aef_admin_on( $c, 'coming_on', 'Bật Coming soon cho khách chưa đăng nhập' );
	echo '<p><label>Mốc đếm ngược (ISO 8601, giờ Việt Nam)<br><input type="text" class="regular-text" name="coming_target" value="' . esc_attr( $c['coming_target'] ) . '"></label></p>';
	echo '<p class="description">Ví dụ 2026-10-27T00:00:00+07:00 — ngày diễn đàn chính.</p>';
	echo '</div>';

	aef_admin_card_open( '2. Ảnh nền, logo, biểu tượng', 'Chọn từ Thư viện WordPress. Nút “Dùng ảnh mặc định” trả về file trong theme.' );
	aef_admin_image( $c, 'coming_bg_id', 'Ảnh nền chính' );
	aef_admin_on( $c, 'coming_show_ribbon', 'Hiện lớp dải sáng phía trên nền' );
	aef_admin_image( $c, 'coming_ribbon_id', 'Lớp dải sáng (overlay)' );
	aef_admin_on( $c, 'coming_show_logo', 'Hiện logo AEF' );
	aef_admin_image( $c, 'coming_logo_id', 'Logo AEF (nên dùng bản trắng / trong suốt)' );
	aef_admin_pair( $c, 'coming_logo_alt', 'Alt logo' );
	aef_admin_on( $c, 'coming_show_seal', 'Hiện quốc huy / con dấu UBND' );
	aef_admin_image( $c, 'coming_seal_id', 'Quốc huy / con dấu' );
	aef_admin_pair( $c, 'coming_seal_alt', 'Alt quốc huy' );
	aef_admin_image( $c, 'coming_favicon_id', 'Favicon (tab trình duyệt)' );
	echo '</div>';

	aef_admin_card_open( '3. Tiêu đề trình duyệt & SEO' );
	aef_admin_pair( $c, 'coming_title', 'Title trên tab trình duyệt' );
	aef_admin_pair( $c, 'coming_og', 'Tiêu đề khi chia sẻ (Open Graph)' );
	aef_admin_pair( $c, 'coming_desc', 'Mô tả ngắn / meta description', true );
	echo '</div>';

	aef_admin_card_open( '4. Khối chữ chính (giữa màn hình)' );
	aef_admin_pair( $c, 'coming_kicker', 'Dòng nhỏ phía trên (địa điểm · thời gian)' );
	aef_admin_pair( $c, 'coming_event', 'Tên sự kiện' );
	echo '<p><label>Năm / số lớn<br><input type="text" class="regular-text" name="coming_year" value="' . esc_attr( $c['coming_year'] ) . '"></label></p>';
	aef_admin_pair( $c, 'coming_pos', 'Dòng định vị (positioning)' );
	aef_admin_pair( $c, 'coming_theme', 'Chủ đề năm' );
	aef_admin_pair( $c, 'coming_when', 'Dòng thành phố · ngày' );
	echo '</div>';

	aef_admin_card_open( '5. Đồng hồ đếm ngược' );
	aef_admin_on( $c, 'coming_show_count', 'Hiện đếm ngược' );
	aef_admin_pair( $c, 'coming_label_d', 'Nhãn ngày' );
	aef_admin_pair( $c, 'coming_label_h', 'Nhãn giờ' );
	aef_admin_pair( $c, 'coming_label_m', 'Nhãn phút' );
	aef_admin_pair( $c, 'coming_label_s', 'Nhãn giây' );
	aef_admin_pair( $c, 'coming_count_cap', 'Dòng chú thích dưới đồng hồ' );
	echo '</div>';

	aef_admin_card_open( '6. Bốn ô thông tin' );
	aef_admin_on( $c, 'coming_show_meta', 'Hiện hàng thông tin' );
	echo '<h3>Ô 1</h3>';
	aef_admin_pair( $c, 'coming_meta1_label', 'Nhãn' );
	echo '<p><label>Giá trị (một dòng, không đổi theo ngôn ngữ)<br><input type="text" class="large-text" name="coming_meta1_value" value="' . esc_attr( $c['coming_meta1_value'] ) . '"></label></p>';
	echo '<h3>Ô 2</h3>';
	aef_admin_pair( $c, 'coming_meta2_label', 'Nhãn' );
	echo '<p><label>Giá trị<br><input type="text" class="large-text" name="coming_meta2_value" value="' . esc_attr( $c['coming_meta2_value'] ) . '"></label></p>';
	echo '<h3>Ô 3</h3>';
	aef_admin_pair( $c, 'coming_meta3_label', 'Nhãn' );
	aef_admin_pair( $c, 'coming_meta3_value', 'Giá trị' );
	echo '<h3>Ô 4</h3>';
	aef_admin_pair( $c, 'coming_meta4_label', 'Nhãn' );
	aef_admin_pair( $c, 'coming_meta4_value', 'Giá trị' );
	echo '</div>';

	aef_admin_card_open( '7. Bốn chủ thể tổ chức' );
	aef_admin_on( $c, 'coming_show_hosts', 'Hiện hàng chủ thể' );
	echo '<h3>Chủ thể 1</h3>';
	aef_admin_pair( $c, 'coming_host1_role', 'Vai trò' );
	aef_admin_pair( $c, 'coming_host1_name', 'Tên' );
	echo '<h3>Chủ thể 2</h3>';
	aef_admin_pair( $c, 'coming_host2_role', 'Vai trò' );
	aef_admin_pair( $c, 'coming_host2_name', 'Tên' );
	echo '<h3>Chủ thể 3</h3>';
	aef_admin_pair( $c, 'coming_host3_role', 'Vai trò' );
	aef_admin_pair( $c, 'coming_host3_name', 'Tên' );
	echo '<h3>Chủ thể 4</h3>';
	aef_admin_pair( $c, 'coming_host4_role', 'Vai trò' );
	aef_admin_pair( $c, 'coming_host4_name', 'Tên' );
	echo '</div>';

	aef_admin_card_open( '8. Chân trang' );
	aef_admin_on( $c, 'coming_show_foot', 'Hiện chân trang' );
	aef_admin_pair( $c, 'coming_line', 'Câu trạng thái website' );
	aef_admin_pair( $c, 'coming_status', 'Nhãn “sắp mở”' );
	echo '<p><label>Email liên hệ<br><input type="text" class="regular-text" name="coming_mail" value="' . esc_attr( $c['coming_mail'] ) . '"></label></p>';
	echo '</div>';

	submit_button( 'Lưu Coming soon', 'primary', 'aef_save_coming' );
	echo '</form></div>';
	aef_admin_media_picker_js();
}

function aef_speaker_mockup_cards() {
	return array(
		array(
			'slug' => 'spk-gov-1', 'en' => 'Mr. Vo Thanh Quang', 'vi' => 'Ông Võ Thanh Quang',
			'role_en' => 'Government', 'role_vi' => 'Khu vực nhà nước',
			'org_en' => 'Public policy and international cooperation', 'org_vi' => 'Chính sách công và hợp tác quốc tế',
			'country' => 'VN',
			'bio_en' => "Works on economic cooperation and the role of emerging growth centres in a shifting global economy.\n\nAt AEF 2026 he joins sessions on value chains, public policy and how governments work with firms and international partners.",
			'bio_vi' => "Hoạt động trong lĩnh vực hợp tác kinh tế và vai trò của các cực tăng trưởng mới trong bối cảnh kinh tế toàn cầu đang tái cấu trúc.\n\nTại AEF 2026, ông tham gia các phiên về chuỗi giá trị, chính sách công và cách khu vực nhà nước làm việc với doanh nghiệp cùng đối tác quốc tế.",
		),
		array(
			'slug' => 'spk-gov-2', 'en' => 'Ms. Dang My Linh', 'vi' => 'Bà Đặng Mỹ Linh',
			'role_en' => 'Urban leadership', 'role_vi' => 'Quản trị đô thị',
			'org_en' => 'City development and public services', 'org_vi' => 'Phát triển đô thị và dịch vụ công',
			'country' => 'VN',
			'bio_en' => "Focuses on how large cities organise infrastructure, public services and investment as they take a larger role in national growth.\n\nShe contributes to AEF 2026 discussions on megacities, urban governance and the host city’s development agenda.",
			'bio_vi' => "Tập trung vào cách các đô thị lớn tổ chức hạ tầng, dịch vụ công và đầu tư khi vai trò của thành phố trong tăng trưởng quốc gia ngày càng rõ.\n\nBà tham gia các thảo luận AEF 2026 về siêu đô thị, quản trị đô thị và chương trình phát triển của thành phố chủ nhà.",
		),
		array(
			'slug' => 'spk-gov-3', 'en' => 'Mr. Huynh Duc Tam', 'vi' => 'Ông Huỳnh Đức Tâm',
			'role_en' => 'Public policy', 'role_vi' => 'Chính sách công',
			'org_en' => 'Economic and technology policy', 'org_vi' => 'Chính sách kinh tế và công nghệ',
			'country' => 'VN',
			'bio_en' => "Works at the meeting point of economic policy, digital transformation and strategic technology.\n\nHis AEF 2026 sessions look at policy frames that let firms invest, innovate and join deeper value chains.",
			'bio_vi' => "Làm việc ở giao điểm giữa chính sách kinh tế, chuyển đổi số và công nghệ chiến lược.\n\nCác phiên ông tham gia tại AEF 2026 tập trung vào khung chính sách giúp doanh nghiệp đầu tư, đổi mới và đi sâu hơn vào chuỗi giá trị.",
		),
		array(
			'slug' => 'spk-intl-1', 'en' => 'Ms. Amara Diallo', 'vi' => 'Bà Amara Diallo',
			'role_en' => 'International organisation', 'role_vi' => 'Tổ chức quốc tế',
			'org_en' => 'Multilateral cooperation', 'org_vi' => 'Hợp tác đa phương',
			'country' => 'SN',
			'bio_en' => "Works with multilateral programmes on trade, development finance and regional connectivity.\n\nAt AEF 2026 she brings a cross-regional view on how international organisations work with cities and firms.",
			'bio_vi' => "Tham gia các chương trình đa phương về thương mại, tài chính phát triển và kết nối khu vực.\n\nTại AEF 2026, bà mang góc nhìn xuyên khu vực về cách tổ chức quốc tế làm việc với đô thị và doanh nghiệp.",
		),
		array(
			'slug' => 'spk-intl-2', 'en' => 'Mr. Henrik Lindqvist', 'vi' => 'Ông Henrik Lindqvist',
			'role_en' => 'International organisation', 'role_vi' => 'Tổ chức quốc tế',
			'org_en' => 'Development cooperation', 'org_vi' => 'Hợp tác phát triển',
			'country' => 'SE',
			'bio_en' => "Specialises in development cooperation, technology partnerships and institutional capacity.\n\nHe joins AEF 2026 sessions on finance, data security and how partners support long-term capability.",
			'bio_vi' => "Chuyên về hợp tác phát triển, đối tác công nghệ và năng lực thể chế.\n\nÔng tham gia các phiên AEF 2026 về tài chính, an toàn dữ liệu và cách các đối tác hỗ trợ năng lực dài hạn.",
		),
		array(
			'slug' => 'spk-intl-3', 'en' => 'Ms. Tan Mei Ling', 'vi' => 'Bà Tan Mei Ling',
			'role_en' => 'Regional cooperation', 'role_vi' => 'Hợp tác khu vực',
			'org_en' => 'ASEAN and regional networks', 'org_vi' => 'ASEAN và mạng lưới khu vực',
			'country' => 'SG',
			'bio_en' => "Works on ASEAN economic connectivity, digital policy and regional innovation networks.\n\nHer AEF 2026 contributions sit in sessions on value chains, digital economy policy and sovereign AI capability.",
			'bio_vi' => "Làm việc về kết nối kinh tế ASEAN, chính sách số và mạng lưới đổi mới khu vực.\n\nCác phần bà tham gia tại AEF 2026 gắn với chuỗi giá trị, chính sách kinh tế số và năng lực tự chủ về trí tuệ nhân tạo.",
		),
		array(
			'slug' => 'spk-biz-1', 'en' => 'Mr. Do Anh Tuan', 'vi' => 'Ông Đỗ Anh Tuấn',
			'role_en' => 'Private sector', 'role_vi' => 'Khu vực tư nhân',
			'org_en' => 'Enterprise leadership', 'org_vi' => 'Lãnh đạo doanh nghiệp',
			'country' => 'VN',
			'bio_en' => "Leads work on manufacturing, investment and how Vietnamese firms move up in global production networks.\n\nAt AEF 2026 he speaks in sessions on advanced manufacturing, AI on the shop floor and private-sector cooperation.",
			'bio_vi' => "Phụ trách các nội dung về sản xuất, đầu tư và cách doanh nghiệp Việt đi lên trong mạng lưới sản xuất toàn cầu.\n\nTại AEF 2026, ông tham gia các phiên về sản xuất tiên tiến, AI trong nhà máy và hợp tác khu vực tư nhân.",
		),
		array(
			'slug' => 'spk-biz-2', 'en' => 'Ms. Priya Raman', 'vi' => 'Bà Priya Raman',
			'role_en' => 'Investment', 'role_vi' => 'Đầu tư',
			'org_en' => 'Investment and capital markets', 'org_vi' => 'Đầu tư và thị trường vốn',
			'country' => 'IN',
			'bio_en' => "Works with investors and firms on capital allocation, ESG standards and cross-border investment.\n\nShe joins AEF 2026 discussions on finance, sustainability standards and matching investment with technology.",
			'bio_vi' => "Làm việc với nhà đầu tư và doanh nghiệp về phân bổ vốn, tiêu chuẩn ESG và đầu tư xuyên biên giới.\n\nBà tham gia các thảo luận AEF 2026 về tài chính, tiêu chuẩn phát triển bền vững và kết nối đầu tư với công nghệ.",
		),
		array(
			'slug' => 'spk-biz-3', 'en' => 'Mr. Kenji Watanabe', 'vi' => 'Ông Kenji Watanabe',
			'role_en' => 'Frontier technology', 'role_vi' => 'Công nghệ đột phá',
			'org_en' => 'Technology and industry', 'org_vi' => 'Công nghệ và công nghiệp',
			'country' => 'JP',
			'bio_en' => "Focuses on advanced manufacturing, industrial AI and strategic technology cooperation.\n\nHis AEF 2026 sessions cover smart production, dual-use industries and how firms adopt new technology at scale.",
			'bio_vi' => "Tập trung vào sản xuất tiên tiến, AI công nghiệp và hợp tác công nghệ chiến lược.\n\nCác phiên ông tham gia tại AEF 2026 gồm sản xuất thông minh, công nghiệp lưỡng dụng và cách doanh nghiệp đưa công nghệ mới vào quy mô.",
		),
		array(
			'slug' => 'spk-aca-1', 'en' => 'Assoc. Prof. Hoang Lan Phuong', 'vi' => 'PGS. Hoàng Lan Phương',
			'role_en' => 'Research', 'role_vi' => 'Nghiên cứu',
			'org_en' => 'Research and higher education', 'org_vi' => 'Nghiên cứu và đào tạo',
			'country' => 'VN',
			'bio_en' => "Researches skills, industrial upgrading and how universities work with firms on technology and workforce development.\n\nAt AEF 2026 she joins sessions on AI and labour, agrifood value chains and the research–industry link.",
			'bio_vi' => "Nghiên cứu về kỹ năng, nâng cấp công nghiệp và cách trường đại học làm việc với doanh nghiệp về công nghệ và nhân lực.\n\nTại AEF 2026, bà tham gia các phiên về AI và lao động, chuỗi nông sản và cầu nối nghiên cứu – doanh nghiệp.",
		),
		array(
			'slug' => 'spk-aca-2', 'en' => 'Dr. James Whitfield', 'vi' => 'TS. James Whitfield',
			'role_en' => 'Research', 'role_vi' => 'Nghiên cứu',
			'org_en' => 'University and applied research', 'org_vi' => 'Đại học và nghiên cứu ứng dụng',
			'country' => 'GB',
			'bio_en' => "Works on data, cyber resilience and the economics of emerging technology, including quantum-era security.\n\nHe contributes to AEF 2026 sessions on data security, quantum ecosystems and ESG in corporate strategy.",
			'bio_vi' => "Làm việc về dữ liệu, khả năng chống chịu an ninh mạng và kinh tế của công nghệ mới, gồm an ninh trong kỷ nguyên lượng tử.\n\nÔng tham gia các phiên AEF 2026 về an toàn dữ liệu, hệ sinh thái lượng tử và ESG trong chiến lược doanh nghiệp.",
		),
		array(
			'slug' => 'spk-fin-1', 'en' => 'Ms. Mai Phuong Thao', 'vi' => 'Bà Mai Phương Thảo',
			'role_en' => 'Finance', 'role_vi' => 'Tài chính',
			'org_en' => 'Financial services', 'org_vi' => 'Dịch vụ tài chính',
			'country' => 'VN',
			'bio_en' => "Works on capital markets, financial infrastructure and how Ho Chi Minh City connects to international capital.\n\nAt AEF 2026 she joins sessions on the international financial centre, growth capital and logistics finance.",
			'bio_vi' => "Làm việc về thị trường vốn, hạ tầng tài chính và cách Thành phố Hồ Chí Minh kết nối với dòng vốn quốc tế.\n\nTại AEF 2026, bà tham gia các phiên về trung tâm tài chính quốc tế, vốn cho tăng trưởng và tài chính logistics.",
		),
		array(
			'slug' => 'spk-fin-2', 'en' => 'Mr. Omar Al-Hassan', 'vi' => 'Ông Omar Al-Hassan',
			'role_en' => 'Finance', 'role_vi' => 'Tài chính',
			'org_en' => 'Regional finance', 'org_vi' => 'Tài chính khu vực',
			'country' => 'AE',
			'bio_en' => "Focuses on regional capital flows, investment partnerships and financial innovation that can serve real-economy projects.\n\nHe takes part in AEF 2026 discussions on international capital, development finance and risk governance.",
			'bio_vi' => "Tập trung vào dòng vốn khu vực, đối tác đầu tư và đổi mới tài chính phục vụ dự án kinh tế thực.\n\nÔng tham gia các thảo luận AEF 2026 về vốn quốc tế, tài chính phát triển và quản trị rủi ro.",
		),
		array(
			'slug' => 'spk-tech-1', 'en' => 'Mr. Phan Tuan Kiet', 'vi' => 'Ông Phan Tuấn Kiệt',
			'role_en' => 'Digital technology', 'role_vi' => 'Công nghệ số',
			'org_en' => 'Technology enterprise', 'org_vi' => 'Doanh nghiệp công nghệ',
			'country' => 'VN',
			'bio_en' => "Works on industrial software, data platforms and AI applications that can be operated in Vietnamese plants and supply chains.\n\nHis AEF 2026 sessions cover factory AI, quantum-ready security and technology demonstration.",
			'bio_vi' => "Làm việc về phần mềm công nghiệp, nền tảng dữ liệu và ứng dụng AI có thể vận hành trong nhà máy và chuỗi cung ứng tại Việt Nam.\n\nCác phiên ông tham gia tại AEF 2026 gồm AI nhà máy, an ninh sẵn sàng cho lượng tử và trình diễn công nghệ.",
		),
		array(
			'slug' => 'spk-tech-2', 'en' => 'Ms. Sofia Alvarez', 'vi' => 'Bà Sofia Alvarez',
			'role_en' => 'Innovation', 'role_vi' => 'Đổi mới',
			'org_en' => 'Innovation networks', 'org_vi' => 'Mạng lưới đổi mới',
			'country' => 'MX',
			'bio_en' => "Works with start-ups, corporates and city innovation programmes on scaling new technology and young leadership.\n\nAt AEF 2026 she joins sessions on digital policy, the low-altitude economy and future business leaders.",
			'bio_vi' => "Làm việc với khởi nghiệp, doanh nghiệp và chương trình đổi mới của đô thị về nhân rộng công nghệ mới và lãnh đạo trẻ.\n\nTại AEF 2026, bà tham gia các phiên về chính sách số, kinh tế tầm thấp và vai trò lãnh đạo doanh nghiệp trẻ.",
		),
		array(
			'slug' => 'spk-city-1', 'en' => 'Mr. Lam Gia Bao', 'vi' => 'Ông Lâm Gia Bảo',
			'role_en' => 'Urban development', 'role_vi' => 'Phát triển đô thị',
			'org_en' => 'Urban economy and infrastructure', 'org_vi' => 'Kinh tế đô thị và hạ tầng',
			'country' => 'VN',
			'bio_en' => "Works on urban economy, new industries and how city infrastructure supports investment and technology.\n\nHe contributes to AEF 2026 sessions on the low-altitude economy, city development and young leadership.",
			'bio_vi' => "Làm việc về kinh tế đô thị, ngành kinh tế mới và cách hạ tầng thành phố hỗ trợ đầu tư cùng công nghệ.\n\nÔng tham gia các phiên AEF 2026 về kinh tế tầm thấp, phát triển đô thị và lãnh đạo trẻ.",
		),
	);
}

function aef_speaker_attach_portrait( $post_id, $filename ) {
	$filename = basename( (string) $filename );
	$src      = get_template_directory() . '/assets/speakers/' . $filename;
	if ( ! $filename || ! file_exists( $src ) ) {
		return 0;
	}
	update_post_meta( $post_id, 'mock_portrait', $filename );
	if ( get_post_thumbnail_id( $post_id ) && get_post_meta( $post_id, 'mock_portrait_file', true ) === $filename ) {
		return (int) get_post_thumbnail_id( $post_id );
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$tmp = wp_tempnam( $filename );
	if ( ! $tmp || ! copy( $src, $tmp ) ) {
		return 0;
	}
	$att = media_handle_sideload(
		array(
			'name'     => $filename,
			'tmp_name' => $tmp,
		),
		$post_id
	);
	if ( is_wp_error( $att ) ) {
		if ( file_exists( $tmp ) ) {
			unlink( $tmp );
		}
		return 0;
	}
	set_post_thumbnail( $post_id, $att );
	update_post_meta( $post_id, 'mock_portrait_file', $filename );
	return (int) $att;
}

function aef_seed_speaker_mockups() {
	$count = 0;
	foreach ( aef_speaker_mockup_cards() as $c ) {
		$existing = get_page_by_path( $c['slug'], OBJECT, 'aef_speaker' );
		$data = array(
			'post_title'   => $c['en'],
			'post_name'    => $c['slug'],
			'post_status'  => 'publish',
			'post_type'    => 'aef_speaker',
			'post_excerpt' => $c['role_en'] . ' — ' . $c['org_en'],
			'post_content' => $c['bio_en'],
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
		update_post_meta( $id, 'is_mockup', '1' );
		aef_speaker_attach_portrait( $id, $c['slug'] . '.jpg' );
		$count++;
	}
	$keep = array();
	foreach ( aef_speaker_mockup_cards() as $c ) {
		$keep[ $c['slug'] ] = true;
	}
	$extras = get_posts(
		array(
			'post_type'      => 'aef_speaker',
			'posts_per_page' => 200,
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
		)
	);
	foreach ( $extras as $p ) {
		if ( isset( $keep[ $p->post_name ] ) ) {
			continue;
		}
		$title = trim( (string) $p->post_title );
		$vi    = trim( (string) get_post_meta( $p->ID, 'title_vi', true ) );
		$en    = trim( (string) get_post_meta( $p->ID, 'title_en', true ) );
		$blank = array( 'To be announced', 'Sẽ công bố', '' );
		if ( in_array( $title, $blank, true ) && in_array( $vi, $blank, true ) && in_array( $en, $blank, true ) ) {
			wp_trash_post( $p->ID );
		}
	}
	return $count;
}

function aef_apply_operational_site() {
	$out = array(
		'speakers' => aef_seed_speaker_mockups(),
		'sessions' => 0,
		'rooms'    => 0,
	);

	$coming = get_option( 'aef_coming', array() );
	if ( ! is_array( $coming ) ) {
		$coming = array();
	}
	$coming['coming_on'] = '0';
	update_option( 'aef_coming', $coming );

	$chrome = get_option( 'aef_chrome', array() );
	if ( ! is_array( $chrome ) ) {
		$chrome = array();
	}
	$chrome['ribbon_on']        = '0';
	$chrome['footer_blurb_en']  = 'Ho Chi Minh City’s annual platform for international economic dialogue.';
	$chrome['footer_blurb_vi']  = 'Nền tảng đối thoại kinh tế quốc tế thường niên của Thành phố Hồ Chí Minh.';
	update_option( 'aef_chrome', $chrome );

	$copy = get_option( 'aef_copy', array() );
	if ( ! is_array( $copy ) ) {
		$copy = array();
	}
	$copy['home_speakers_eyebrow_en'] = 'Speakers';
	$copy['home_speakers_eyebrow_vi'] = 'Diễn giả';
	$copy['home_speakers_title_en']   = 'AEF 2026 speakers';
	$copy['home_speakers_title_vi']   = 'Diễn giả AEF 2026';
	$copy['home_speakers_lead_en']    = 'Leaders, policymakers, executives and specialists taking part in the thematic sessions and the high-level programme.';
	$copy['home_speakers_lead_vi']    = 'Lãnh đạo, nhà hoạch định chính sách, doanh nhân và chuyên gia tham gia các phiên thảo luận chuyên đề và chương trình cấp cao.';
	$copy['home_speakers_cta_en']     = 'All speakers';
	$copy['home_speakers_cta_vi']     = 'Toàn bộ diễn giả';
	update_option( 'aef_copy', $copy );

	$spk = array();
	foreach ( aef_speaker_mockup_cards() as $c ) {
		$p = get_page_by_path( $c['slug'], OBJECT, 'aef_speaker' );
		if ( $p ) {
			$spk[ $c['slug'] ] = (int) $p->ID;
		}
	}

	$cast = array(
		'repositioning-vietnam-asean'   => array( 'spk-gov-1', 'spk-intl-3', 'spk-biz-1' ),
		'financial-innovation-ifc'      => array( 'spk-fin-1', 'spk-fin-2', 'spk-intl-2' ),
		'advanced-manufacturing'        => array( 'spk-biz-1', 'spk-tech-1', 'spk-biz-3' ),
		'esg-corporate-strategy'        => array( 'spk-biz-2', 'spk-gov-2', 'spk-aca-2' ),
		'digital-economy-policy'        => array( 'spk-gov-3', 'spk-tech-2', 'spk-intl-3' ),
		'smart-manufacturing-logistics' => array( 'spk-biz-3', 'spk-tech-1', 'spk-fin-1' ),
		'ai-workforce-readiness'        => array( 'spk-aca-1', 'spk-biz-1', 'spk-gov-2' ),
		'data-security-quantum'         => array( 'spk-tech-1', 'spk-aca-2', 'spk-intl-2' ),
		'smart-agriculture'             => array( 'spk-aca-1', 'spk-gov-3', 'spk-biz-2' ),
		'industrial-ai'                 => array( 'spk-tech-1', 'spk-biz-3', 'spk-aca-2' ),
		'sovereign-ai'                  => array( 'spk-gov-1', 'spk-tech-2', 'spk-intl-3' ),
		'dual-use-industries'           => array( 'spk-gov-3', 'spk-biz-3', 'spk-intl-1' ),
		'quantum-ecosystem'             => array( 'spk-aca-2', 'spk-tech-1', 'spk-intl-2' ),
		'low-altitude-economy'          => array( 'spk-city-1', 'spk-tech-2', 'spk-biz-1' ),
		'global-future-leaders'         => array( 'spk-tech-2', 'spk-biz-2', 'spk-city-1' ),
		'rising-star-arena'             => array( 'spk-tech-1', 'spk-tech-2', 'spk-aca-1' ),
		'ceo-500-tea-connect'           => array( 'spk-fin-1', 'spk-biz-1', 'spk-intl-1' ),
	);

	foreach ( $cast as $slug => $slugs ) {
		$session = get_page_by_path( $slug, OBJECT, 'aef_session' );
		if ( ! $session ) {
			continue;
		}
		$people = array();
		$seen   = array();
		foreach ( $slugs as $i => $spk_slug ) {
			if ( empty( $spk[ $spk_slug ] ) || isset( $seen[ $spk_slug ] ) ) {
				continue;
			}
			$seen[ $spk_slug ] = true;
			$people[]          = array(
				'id'   => $spk[ $spk_slug ],
				'role' => ( 0 === $i ) ? 'moderator' : 'panelist',
			);
		}
		if ( ! $people ) {
			continue;
		}
		delete_post_meta( $session->ID, 'aef_person' );
		foreach ( $people as $row ) {
			add_post_meta( $session->ID, 'aef_person', $row['id'] );
		}
		update_post_meta( $session->ID, 'aef_people', $people );
		$out['sessions']++;
	}

	$rooms = get_posts(
		array(
			'post_type'      => 'aef_session',
			'posts_per_page' => 120,
			'post_status'    => 'any',
		)
	);
	foreach ( $rooms as $p ) {
		$room = trim( (string) get_post_meta( $p->ID, 'room', true ) );
		if ( in_array( $room, array( 'To be confirmed', 'TBD', 'tbd', '—' ), true ) ) {
			update_post_meta( $p->ID, 'room', 'Ho Chi Minh City' );
			$out['rooms']++;
		}
	}

	$copy['block_support']           = '1';
	$copy['block_media']             = '1';
	$copy['home_theme_eyebrow_en']   = '2026 theme';
	$copy['home_theme_eyebrow_vi']   = 'Chủ đề 2026';
	$copy['home_theme_lead_en']      = "AEF 2026 takes collaboration as the working method of the Forum: not only among countries, but among cities, firms, universities, investors and international organisations.\n\nThe aim is to turn dialogue into partnerships, programmes and projects that can continue after 27–28 October.";
	$copy['home_theme_lead_vi']      = "AEF 2026 lấy hợp tác làm cách làm việc của Diễn đàn: không chỉ giữa các quốc gia, mà giữa đô thị, doanh nghiệp, viện trường, nhà đầu tư và tổ chức quốc tế.\n\nMục tiêu là chuyển đối thoại thành quan hệ đối tác, chương trình và dự án có thể tiếp tục sau các ngày 27–28 tháng 10.";
	$copy['home_side_title_en']      = 'A four-day city programme around the main Forum';
	$copy['home_side_title_vi']      = 'Chuỗi bốn ngày quanh diễn đàn chính';
	$copy['home_side_lead_en']       = "Forum week runs from 26 to 29 October 2026. The main days on 27–28 October sit inside a city-wide series: CEO 500 — TEA CONNECT, bilateral seminars, a cooperation space, technology demonstration, the C4IR Network meeting, field visits and cultural programmes.\n\nThis is not a side note to the plenary. It is the working week in which delegates continue the conversation, see the city’s economic and technology ecosystem, and form partnerships.";
	$copy['home_side_lead_vi']       = "Tuần Diễn đàn diễn ra từ 26 đến 29 tháng 10 năm 2026. Hai ngày chính 27–28/10 nằm trong một chuỗi trên địa bàn thành phố: CEO 500 — TEA CONNECT, hội thảo song phương, không gian hợp tác, trình diễn công nghệ, họp mặt Mạng lưới C4IR, tham quan thực địa và chương trình văn hóa.\n\nĐây không phải phần phụ của phiên toàn thể. Đây là tuần làm việc để đại biểu tiếp tục trao đổi, tiếp cận hệ sinh thái kinh tế – công nghệ của thành phố và hình thành hợp tác.";
	$copy['home_support_title_en']   = 'One centre, three routes';
	$copy['home_support_title_vi']   = 'Một trung tâm, ba lối đi';
	$copy['home_support_lead_en']    = 'Delegates, journalists and visitors each follow a separate path: registration and access, press working rules, and the city kit for Thiskyhall and Sala.';
	$copy['home_support_lead_vi']    = 'Đại biểu, nhà báo và khách mỗi bên một lối: đăng ký và quyền vào cửa, quy định tác nghiệp, và cẩm nang Thiskyhall – Sala.';
	$copy['home_media_title_en']     = 'News';
	$copy['home_media_title_vi']     = 'Tin tức';
	$copy['home_media_lead_en']      = 'Official public information of AEF 2026, with a working note for the press.';
	$copy['home_media_lead_vi']      = 'Thông tin công khai chính thức của AEF 2026, kèm đầu mối dành cho báo chí.';
	aef_apply_wef_overall_strip( $copy, $chrome );
	update_option( 'aef_copy', $copy );

	$order = aef_home_order();
	$order = array_values( array_diff( $order, array( 'media', 'support' ) ) );
	$at    = array_search( 'speakers', $order, true );
	if ( false === $at ) {
		$at = array_search( 'side', $order, true );
	}
	if ( false === $at ) {
		$order[] = 'media';
	} else {
		array_splice( $order, $at + 1, 0, array( 'media' ) );
	}
	$at = array_search( 'close', $order, true );
	if ( false === $at ) {
		$order[] = 'support';
	} else {
		array_splice( $order, $at, 0, array( 'support' ) );
	}
	update_option( 'aef_home_order', $order );

	$out['stories'] = aef_seed_home_stories();
	return $out;
}

function aef_apply_wef_overall_strip( &$copy = null, &$chrome = null ) {
	if ( null === $copy ) {
		$copy = get_option( 'aef_copy', array() );
		if ( ! is_array( $copy ) ) {
			$copy = array();
		}
	}
	if ( null === $chrome ) {
		$chrome = get_option( 'aef_chrome', array() );
		if ( ! is_array( $chrome ) ) {
			$chrome = array();
		}
	}
	$copy['home_hosts_4_role_en'] = '';
	$copy['home_hosts_4_role_vi'] = '';
	$copy['home_hosts_4_name_en'] = '';
	$copy['home_hosts_4_name_vi'] = '';
	$copy['home_hero_lead_en']    = 'The Autumn Economic Forum 2026 is convened by the People’s Committee of Ho Chi Minh City. The Forum gathers delegates from government, business, international organisations and academia.';
	$copy['home_hero_lead_vi']    = 'Diễn đàn Kinh tế Mùa thu năm 2026 do Ủy ban nhân dân Thành phố Hồ Chí Minh chủ trì. Diễn đàn quy tụ đại biểu từ khu vực nhà nước, doanh nghiệp, tổ chức quốc tế và giới học thuật.';
	$chrome['footer_blurb_en']    = 'Ho Chi Minh City’s annual platform for international economic dialogue.';
	$chrome['footer_blurb_vi']    = 'Nền tảng đối thoại kinh tế quốc tế thường niên của Thành phố Hồ Chí Minh.';
	update_option( 'aef_copy', $copy );
	update_option( 'aef_chrome', $chrome );

	$set = get_option( 'aef_settings', array() );
	if ( ! is_array( $set ) ) {
		$set = array();
	}
	$set['host_3_name_en'] = 'HCMC C4IR';
	$set['host_3_name_vi'] = 'HCMC C4IR';
	$set['host_3_role_en'] = 'Implementing centre';
	$set['host_3_role_vi'] = 'Đơn vị thực hiện';
	update_option( 'aef_settings', $set );

	$about = get_option( 'aef_about', array() );
	if ( ! is_array( $about ) ) {
		$about = array();
	}
	$about['about_deck_en']    = 'Convened by the People’s Committee of Ho Chi Minh City.';
	$about['about_deck_vi']    = 'Do Ủy ban nhân dân Thành phố Hồ Chí Minh chủ trì.';
	$about['about_hosts_p_en'] = 'Directed by the Government of Viet Nam. Convened by the People’s Committee of Ho Chi Minh City. HCMC C4IR is the implementing centre.';
	$about['about_hosts_p_vi'] = 'Chính phủ Việt Nam chỉ đạo. UBND Thành phố Hồ Chí Minh chủ trì. HCMC C4IR là đơn vị thực hiện.';
	$about['about_origin_p_en'] = "The Forum began in 2018 as the Ho Chi Minh City Economic Forum. From 2025 it has been convened under the direct direction of the Prime Minister of Viet Nam, under the name Autumn Economic Forum.\n\nIt is not a policy exchange alone. It is a mechanism to turn technology trends, innovation and global resources into cooperation programmes and investment projects.";
	$about['about_origin_p_vi'] = "Diễn đàn bắt đầu năm 2018 với tên Diễn đàn Kinh tế Thành phố Hồ Chí Minh. Từ năm 2025, Diễn đàn được tổ chức dưới sự chỉ đạo trực tiếp của Thủ tướng Chính phủ, và mang tên Diễn đàn Kinh tế Mùa thu.\n\nĐây không chỉ là nơi trao đổi chính sách, mà là cơ chế chuyển hóa các xu hướng công nghệ, sáng kiến đổi mới sáng tạo và nguồn lực toàn cầu thành chương trình hợp tác và dự án đầu tư.";
	update_option( 'aef_about', $about );

	$coming = get_option( 'aef_coming', array() );
	if ( ! is_array( $coming ) ) {
		$coming = array();
	}
	$coming['coming_host4_role_en'] = '';
	$coming['coming_host4_role_vi'] = '';
	$coming['coming_host4_name_en'] = '';
	$coming['coming_host4_name_vi'] = '';
	update_option( 'aef_coming', $coming );
	return true;
}

function aef_seed_home_stories() {
	$items = array(
		array(
			'slug'  => 'aef-2026-forum-week',
			'kind'  => 'news',
			'en'    => 'AEF 2026: main Forum 27–28 October, Forum week 26–29 October',
			'vi'    => 'AEF 2026: diễn đàn chính 27–28/10, tuần Diễn đàn 26–29/10',
			'ex_en' => 'The Autumn Economic Forum 2026 takes place in Ho Chi Minh City, with the main days at Thiskyhall, Sala.',
			'ex_vi' => 'Diễn đàn Kinh tế Mùa thu năm 2026 tổ chức tại Thành phố Hồ Chí Minh, hai ngày chính tại Thiskyhall, Sala.',
			'body_en' => "The Autumn Economic Forum 2026 — The Convergence Of New Global Growth Engines — will be held in Ho Chi Minh City. The main Forum days are 27–28 October 2026 at Thiskyhall, 10 Mai Chi Tho, Sala, An Khanh. Forum-week activities run from 26 to 29 October.\n\nThe 2026 theme is Collaboration in a New Era. On 27 October, opening remarks by the Vice Chairman of the Ho Chi Minh City People’s Committee are followed by 15 parallel thematic sessions and a technology demonstration area. On 28 October the high-level plenary, the dialogue with the Prime Minister of Viet Nam, and the ministerial dialogue are open to Forum delegates.\n\nDirecting authority is the Government of Viet Nam. The People’s Committee of Ho Chi Minh City is the convening authority. HCMC C4IR is the implementing centre.",
			'body_vi' => "Diễn đàn Kinh tế Mùa thu năm 2026 — Sự hội tụ của các cực tăng trưởng mới toàn cầu — tổ chức tại Thành phố Hồ Chí Minh. Diễn đàn chính ngày 27–28 tháng 10 năm 2026 tại Thiskyhall, số 10 Mai Chí Thọ, Sala, phường An Khánh. Các hoạt động trong tuần Diễn đàn diễn ra từ 26 đến 29 tháng 10.\n\nChủ đề năm 2026 là Tinh thần hợp tác trong kỷ nguyên mới. Ngày 27/10, phát biểu khai mạc của Phó Chủ tịch UBND Thành phố trước 15 phiên thảo luận chuyên đề song song và khu vực trình diễn công nghệ. Ngày 28/10, phiên toàn thể cấp cao, đối thoại cùng Thủ tướng Chính phủ Việt Nam và đối thoại cấp Bộ dành cho đại biểu Diễn đàn.\n\nCơ quan chỉ đạo là Chính phủ Việt Nam. Đơn vị chủ trì là UBND Thành phố Hồ Chí Minh. Đơn vị thực hiện là HCMC C4IR.",
		),
		array(
			'slug'  => 'aef-2026-forum-week-programme',
			'kind'  => 'news',
			'en'    => 'Forum week includes CEO 500, bilateral seminars and a cooperation space',
			'vi'    => 'Tuần Diễn đàn gồm CEO 500, hội thảo song phương và không gian hợp tác',
			'ex_en' => 'The two main days sit inside a four-day city programme for delegates.',
			'ex_vi' => 'Hai ngày chính nằm trong chuỗi bốn ngày trên địa bàn thành phố dành cho đại biểu.',
			'body_en' => "Alongside the main Forum, AEF 2026 organises a Forum-week series from 26 to 29 October 2026.\n\nOn 26 October, CEO 500 — TEA CONNECT looks at FDI, technology and global capital flows. Through the week, bilateral seminars bring together Ho Chi Minh City, ministries, localities and international partners. A cooperation space combines talks, exhibition, technology demonstration, investment matching and cultural exchange. The technology demonstration area at Thiskyhall on 27 October presents proven solutions in 45-minute slots. The C4IR Network holds its annual meeting. Field visits cover hi-tech parks, innovation centres, typical firms and cultural programmes.\n\nTimes and rooms for each activity are on the Programme page.",
			'body_vi' => "Bên cạnh diễn đàn chính, AEF 2026 tổ chức chuỗi tuần Diễn đàn từ 26 đến 29 tháng 10 năm 2026.\n\nNgày 26/10, CEO 500 — TEA CONNECT tập trung vào FDI, công nghệ và dòng vốn toàn cầu. Trong tuần, hội thảo song phương kết nối Thành phố Hồ Chí Minh, các bộ ngành, địa phương và đối tác quốc tế. Không gian hợp tác kết hợp tọa đàm, triển lãm, trình diễn công nghệ, kết nối đầu tư và giao lưu văn hóa. Khu vực trình diễn công nghệ tại Thiskyhall ngày 27/10 giới thiệu giải pháp đã được chứng minh, mỗi phiên 45 phút. Mạng lưới C4IR họp mặt thường niên. Chương trình tham quan gồm khu công nghệ cao, trung tâm đổi mới, doanh nghiệp tiêu biểu và hoạt động văn hóa.\n\nGiờ và không gian từng hoạt động nằm ở trang Chương trình.",
		),
		array(
			'slug'  => 'working-as-press-at-aef-2026',
			'kind'  => 'press',
			'en'    => 'Working as press at AEF 2026',
			'vi'    => 'Tác nghiệp báo chí tại AEF 2026',
			'ex_en' => 'Journalists register separately from delegates. aef.vn does not collect personal data.',
			'ex_vi' => 'Nhà báo đăng ký tách khỏi đại biểu. aef.vn không thu dữ liệu cá nhân.',
			'body_en' => "Press accreditation for AEF 2026 is separate from delegate registration. This public website does not host a personal-data form.\n\nJournalists follow the event’s working rules, including access to press facilities and interview requests through the media desk. Delegate and media flows at Thiskyhall are kept separate.\n\nFor accreditation and on-site working conditions, use the Media support page or write to contact@aef.vn.",
			'body_vi' => "Đăng ký tác nghiệp báo chí AEF 2026 tách khỏi đăng ký đại biểu. Website công khai này không đặt form thu dữ liệu cá nhân.\n\nNhà báo tuân thủ quy định tác nghiệp của sự kiện, gồm điều kiện làm việc tại chỗ và đề nghị phỏng vấn qua đầu mối truyền thông. Luồng Đại biểu và Báo chí tại Thiskyhall tách riêng.\n\nĐể đăng ký tác nghiệp và điều kiện làm việc, dùng trang Hỗ trợ báo chí hoặc gửi contact@aef.vn.",
		),
		array(
			'slug'    => 'aef-2025-official-recap',
			'kind'    => 'video',
			'en'      => 'Official recap of the 2025 Forum',
			'vi'      => 'Phim tổng kết chính thức kỳ 2025',
			'ex_en'   => 'The published recap of the Autumn Economic Forum 2025, as released on hef.gov.vn.',
			'ex_vi'   => 'Phim tổng kết Diễn đàn Kinh tế Mùa thu 2025 đã đăng trên hef.gov.vn.',
			'body_en' => "The 2025 edition of the Autumn Economic Forum was held in Ho Chi Minh City. The official recap published after the edition is available here. It is a record of the previous year, not the 2026 programme.",
			'body_vi' => "Kỳ 2025 của Diễn đàn Kinh tế Mùa thu tổ chức tại Thành phố Hồ Chí Minh. Phim tổng kết chính thức đã phát hành sau kỳ diễn đàn được đăng tại đây. Đây là tư liệu năm trước, không phải chương trình 2026.",
			'video'   => 'https://www.youtube.com/watch?v=vSAqGhQpEH0',
		),
	);
	$n = 0;
	$t = time();
	foreach ( $items as $i => $it ) {
		$existing = get_page_by_path( $it['slug'], OBJECT, 'aef_story' );
		$data     = array(
			'post_title'   => $it['en'],
			'post_name'    => $it['slug'],
			'post_status'  => 'publish',
			'post_type'    => 'aef_story',
			'post_excerpt' => $it['ex_en'],
			'post_content' => $it['body_en'],
			'post_date'    => gmdate( 'Y-m-d H:i:s', $t - ( ( count( $items ) - $i ) * DAY_IN_SECONDS ) ),
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
		update_post_meta( $id, 'title_en', $it['en'] );
		update_post_meta( $id, 'title_vi', $it['vi'] );
		update_post_meta( $id, 'excerpt_en', $it['ex_en'] );
		update_post_meta( $id, 'excerpt_vi', $it['ex_vi'] );
		update_post_meta( $id, 'content_en', $it['body_en'] );
		update_post_meta( $id, 'content_vi', $it['body_vi'] );
		update_post_meta( $id, 'story_kind', $it['kind'] );
		if ( ! empty( $it['video'] ) ) {
			update_post_meta( $id, 'video_url', $it['video'] );
		}
		$n++;
	}
	return $n;
}

function aef_custom_css_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	if ( isset( $_POST['aef_save_custom_css'] ) && check_admin_referer( 'aef_custom_css' ) ) {
		$on  = ( isset( $_POST['aef_custom_css_on'] ) && '1' === (string) $_POST['aef_custom_css_on'] ) ? '1' : '0';
		$css = isset( $_POST['aef_custom_css'] ) ? wp_unslash( $_POST['aef_custom_css'] ) : '';
		$css = function_exists( 'aef_sanitize_custom_css' ) ? aef_sanitize_custom_css( $css ) : wp_strip_all_tags( $css );
		update_option( 'aef_custom_css_on', $on );
		update_option( 'aef_custom_css', $css );
		echo '<div class="updated notice"><p>Đã lưu CSS Custom. <a href="' . esc_url( home_url( '/' ) ) . '" target="_blank" rel="noopener">Xem trang chủ</a></p></div>';
	}
	$on  = function_exists( 'aef_custom_css_on' ) && aef_custom_css_on();
	$css = function_exists( 'aef_custom_css' ) ? aef_custom_css() : '';
	echo '<div class="wrap aef-desk"><h1>CSS Custom</h1>';
	echo '<p>Ghi đè <code>site.css</code> mà không sửa file theme. Nạp sau CSS gốc, chỉ khi bật và ô không trống. Tắt công tắc = gỡ hết ghi đè, chữ CSS vẫn giữ.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'aef_custom_css' );
	echo '<div class="aef-card" style="max-width:1100px;background:#fff;border:1px solid #c3c4c7;padding:16px 18px;margin:0 0 14px">';
	echo '<p><label><input type="hidden" name="aef_custom_css_on" value="0">';
	echo '<input type="checkbox" name="aef_custom_css_on" value="1"' . checked( $on, true, false ) . '> Bật CSS Custom trên site</label></p>';
	echo '<p><label for="aef_custom_css"><strong>CSS ghi đè</strong></label></p>';
	echo '<textarea name="aef_custom_css" id="aef_custom_css" class="large-text code" rows="22" spellcheck="false" style="font-family:ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;font-size:13px;line-height:1.45">' . esc_textarea( $css ) . '</textarea>';
	echo '<p class="description">Viết selector đầy đủ. Không dùng <code>&lt;style&gt;</code>. Ví dụ: <code>.hero-kicker{display:none}</code></p>';
	echo '<details><summary>Ví dụ</summary><pre style="background:#f6f7f7;padding:12px;overflow:auto">/* Chữ hero */
.hero-lead { max-width: 52ch; }

/* Thanh ngày / địa điểm */
.hmeta b { font-size: 16px; }

/* Ẩn một khối khi cần */
.partners-preview { display: none; }</pre></details>';
	echo '</div>';
	submit_button( 'Lưu CSS Custom', 'primary', 'aef_save_custom_css' );
	echo '</form></div>';
}
