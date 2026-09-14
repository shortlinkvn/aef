<?php
get_header();
the_post();
$slug = get_post_field( 'post_name', get_the_ID() );
$travel_slugs = array( 'travel', 'venue', 'hotels', 'transport' );

if ( in_array( $slug, $travel_slugs, true ) ) {
	echo aef_render_travel();
	get_footer();
	return;
}

if ( 'how-to-register' === $slug ) {
	echo aef_opener(
		aef_t( array( 'en' => 'Delegates', 'vi' => 'Đại biểu' ) ),
		aef_t( array( 'en' => 'How to register', 'vi' => 'Cách đăng ký' ) ),
		aef_t( array(
			'en' => 'Invitation and Organising Committee review. This site does not collect personal data.',
			'vi' => 'Theo thư mời và xét duyệt của Ban Tổ chức. Website này không thu dữ liệu cá nhân.',
		) ),
		aef_img( 'visual/forum-hall.jpg' ),
		aef_t( array( 'en' => 'Illustration', 'vi' => 'Minh họa' ) ),
		'compact'
	);
	get_template_part( 'templates/delegates' );
	get_footer();
	return;
}

if ( 'delegates' === $slug ) {
	echo aef_opener(
		aef_t( array( 'en' => 'Delegates', 'vi' => 'Đại biểu' ) ),
		aef_t( array( 'en' => 'How to register', 'vi' => 'Cách đăng ký' ) ),
		aef_t( array(
			'en' => 'Invitation and Organising Committee review. This site does not collect personal data.',
			'vi' => 'Theo thư mời và xét duyệt của Ban Tổ chức. Website này không thu dữ liệu cá nhân.',
		) ),
		aef_img( 'visual/forum-hall.jpg' ),
		aef_illustration_credit(),
		'compact'
	);
	get_template_part( 'templates/delegates' );
	get_footer();
	return;
}

if ( 'support' === $slug ) {
	echo aef_opener(
		'AEF 2026',
		aef_t( array( 'en' => 'Support Centre', 'vi' => 'Trung tâm Hỗ trợ' ) ),
		aef_t( array(
			'en' => 'Delegates, accredited press and visitors each follow a separate route.',
			'vi' => 'Đại biểu, phóng viên đã cấp thẻ và khách mỗi bên một lối.',
		) ),
		aef_img( 'visual/arrival.jpg' ),
		aef_illustration_credit(),
		'compact'
	);
	get_template_part( 'templates/support' );
	get_footer();
	return;
}

if ( 'media-support' === $slug ) {
	echo aef_opener(
		aef_t( array( 'en' => 'Media', 'vi' => 'Báo chí' ) ),
		aef_t( array( 'en' => 'Working as press', 'vi' => 'Tác nghiệp báo chí' ) ),
		aef_t( array(
			'en' => 'Accreditation, press rooms and interview requests. Separate from delegate registration.',
			'vi' => 'Đăng ký tác nghiệp, trung tâm báo chí và đề nghị phỏng vấn. Tách khỏi đăng ký đại biểu.',
		) ),
		aef_img( 'youth.jpg' ),
		aef_illustration_credit(),
		'compact'
	);
	get_template_part( 'templates/media-support' );
	get_footer();
	return;
}

$img_map = array(
	'about'    => 'visual/hcmc-dusk.jpg',
	'topics'   => 'visual/pillar-megacity.jpg',
	'partners' => 'visual/pillar-private.jpg',
);
$img_file = isset( $img_map[ $slug ] ) ? $img_map[ $slug ] : 'visual/forum-hall.jpg';
if ( 'about' === $slug && function_exists( 'aef_about' ) ) {
	echo aef_opener(
		aef_about( 'about_eyebrow' ),
		aef_about( 'about_title' ),
		aef_about( 'about_deck' ),
		aef_about_image( 'opener', $img_file ),
		aef_about( 'about_credit' ),
		'about'
	);
} elseif ( 'topics' === $slug && function_exists( 'aef_topics' ) ) {
	$title    = trim( (string) aef_topics( 'topics_title' ) );
	$deck     = trim( (string) aef_topics( 'topics_deck' ) );
	$eyebrow  = trim( (string) aef_topics( 'topics_eyebrow' ) );
	$credit   = trim( (string) aef_topics( 'topics_credit' ) );
	if ( '' === $title ) {
		$title = aef_bilingual_title( get_the_ID() );
	}
	if ( '' === $deck ) {
		$deck = wp_strip_all_tags( aef_bilingual_excerpt( get_the_ID() ) );
	}
	$cover = function_exists( 'aef_topics_image' ) ? aef_topics_image( 'topics_bg_id', $img_file ) : aef_img( $img_file );
	echo aef_opener(
		$eyebrow,
		$title,
		$deck,
		$cover,
		$credit
	);
} elseif ( function_exists( 'aef_inner' ) && 'partners' === $slug ) {
	$title    = trim( (string) aef_inner( 'partners_title' ) );
	$deck     = trim( (string) aef_inner( 'partners_deck' ) );
	$eyebrow  = trim( (string) aef_inner( 'partners_eyebrow' ) );
	if ( '' === $title || preg_match( '/đơn vị|organisations/iu', $title ) ) {
		$title = aef_t( array( 'en' => 'Partners', 'vi' => 'Đối tác' ) );
	}
	if ( '' === $deck ) {
		$deck = aef_t( array(
			'en' => 'Organisations accompanying AEF 2026. Appearance on this page does not by itself establish a sponsorship tier.',
			'vi' => 'Các tổ chức đồng hành cùng AEF 2026. Việc xuất hiện trên trang không mặc nhiên xác lập thứ hạng tài trợ.',
		) );
	}
	echo aef_opener(
		$eyebrow ? $eyebrow : 'AEF 2026',
		$title,
		$deck,
		aef_img( $img_file ),
		aef_illustration_credit(),
		'compact'
	);
} else {
	echo aef_opener(
		'AEF 2026',
		aef_bilingual_title( get_the_ID() ),
		wp_strip_all_tags( aef_bilingual_excerpt( get_the_ID() ) ),
		aef_img( $img_file ),
		aef_t( array( 'en' => 'Illustration', 'vi' => 'Minh họa' ) )
	);
}

if ( 'about' === $slug ) {
	get_template_part( 'templates/about' );
} elseif ( 'topics' === $slug ) {
	get_template_part( 'templates/topics' );
} elseif ( 'partners' === $slug ) {
	get_template_part( 'templates/partners' );
} else {
	echo '<section class="blk"><div class="shell body-copy">';
	echo apply_filters( 'the_content', aef_bilingual_content( get_the_ID() ) );
	echo '</div></section>';
}

get_footer();
