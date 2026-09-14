<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Official HEF news, photo albums and replay as published on hef.gov.vn.
 * Used as the News / Media Gallery reference. Not 2026 programme copy.
 */
function aef_hef_href( $slug ) {
	$slug = ltrim( (string) $slug, '/' );
	if ( aef_lang() === 'vi' ) {
		return 'https://hef.gov.vn/vi/' . $slug;
	}
	return 'https://hef.gov.vn/' . $slug;
}

function aef_hef_news_items() {
	return array(
		array(
			'url'      => aef_hef_href( 'hcmc-c4ir-works-with-the-consul-general-of-india-in-ho-chi-minh-city-promoting-strategic-vietnam-india-technology-cooperation.html' ),
			'img'      => 'https://hef.gov.vn/wp-content/uploads/2026/03/an-do_HCMC-C4IR_1-696x464.jpg',
			'title'    => aef_t( array(
				'en' => 'HCMC C4IR works with the Consul General of India in Ho Chi Minh City: Promoting strategic Vietnam – India technology cooperation',
				'vi' => 'HCMC C4IR làm việc với Tổng Lãnh sự quán Ấn Độ tại TPHCM: Thúc đẩy hợp tác công nghệ chiến lược Việt Nam - Ấn Độ',
			) ),
			'date'     => '04/03/2026',
			'kind'     => 'news',
			'external' => true,
		),
		array(
			'url'      => aef_hef_href( 'viet-nam-us-enhance-cooperation-in-sci-tech-innovation-digital-transformation.html' ),
			'img'      => 'https://hef.gov.vn/wp-content/uploads/2026/02/485718_83.jpg',
			'title'    => aef_t( array(
				'en' => 'Việt Nam, US enhance cooperation in sci-tech, innovation, digital transformation',
				'vi' => 'Việt Nam, US enhance cooperation in sci-tech, innovation, digital transformation',
			) ),
			'date'     => '23/02/2026',
			'kind'     => 'news',
			'external' => true,
		),
		array(
			'url'      => aef_hef_href( 'putting-the-autumn-economic-forum-initiative-into-practice-for-development.html' ),
			'img'      => 'https://hef.gov.vn/wp-content/uploads/2026/01/bui-thanh-son-696x464.jpg',
			'title'    => aef_t( array(
				'en' => 'Putting the Autumn Economic Forum initiative into practice for development',
				'vi' => 'Đưa sáng kiến Diễn đàn Kinh tế mùa thu vào thực tiễn phát triển',
			) ),
			'date'     => '01/01/2026',
			'kind'     => 'news',
			'external' => true,
		),
		array(
			'url'      => aef_hef_href( 'the-autumn-economic-forum-2025.html' ),
			'img'      => 'https://hef.gov.vn/wp-content/uploads/2025/12/autumn-economic-forum-2025-progammepr-696x989.jpg',
			'title'    => aef_t( array(
				'en' => 'Proceedings of The Autumn Economic Forum 2025',
				'vi' => 'Proceedings of The Autumn Economic Forum 2025',
			) ),
			'date'     => '29/12/2025',
			'kind'     => 'document',
			'external' => true,
		),
		array(
			'url'      => aef_hef_href( 'recap-autumn-economic-forum-2025.html' ),
			'img'      => 'https://hef.gov.vn/wp-content/uploads/2025/12/maxresdefault-696x392.jpg',
			'title'    => aef_t( array(
				'en' => 'RECAP | AUTUMN ECONOMIC FORUM 2025',
				'vi' => 'RECAP DIỄN ĐÀN KINH TẾ MÙA THU 2025',
			) ),
			'date'     => '11/12/2025',
			'kind'     => 'video',
			'duration' => '00:08:12',
			'external' => true,
			'skip'     => 'recap',
		),
		array(
			'url'      => aef_hef_href( 'autumn-economic-forum-2025-viet-nam-affirms-its-leading-role-in-the-region-driving-global-investment-into-pillars-of-green-and-digital-transformation.html' ),
			'img'      => 'https://hef.gov.vn/wp-content/uploads/2025/12/autumn-economic-forum-8392-696x464.jpg',
			'title'    => aef_t( array(
				'en' => 'Autumn Economic Forum 2025: Viet Nam affirms its leading role in the region, driving global investment into pillars of green and digital transformation',
				'vi' => 'Diễn đàn Kinh tế mùa thu năm 2025: Việt Nam khẳng định vai trò dẫn đầu khu vực, thúc đẩy đầu tư toàn cầu các trụ cột chuyển đổi xanh và chuyển đổi số',
			) ),
			'date'     => '04/12/2025',
			'kind'     => 'news',
			'external' => true,
		),
		array(
			'url'      => aef_hef_href( 'young-peoples-role-in-smart-and-sustainable-future-identified.html' ),
			'img'      => 'https://hef.gov.vn/wp-content/uploads/2025/12/89d37db8a42d402290c3d215fbc00b42-52528-696x465.jpg',
			'title'    => aef_t( array(
				'en' => 'Young people’s role in smart and sustainable future identified',
				'vi' => 'Young people’s role in smart and sustainable future identified',
			) ),
			'date'     => '11/12/2025',
			'kind'     => 'news',
			'external' => true,
		),
		array(
			'url'      => aef_hef_href( 'autumn-economic-forum-2025-a-milestone-opening-a-new-promising-path-for-ho-chi-minh-city.html' ),
			'img'      => 'https://hef.gov.vn/wp-content/uploads/2025/12/autumn-economic_forum_1-696x464.jpeg',
			'title'    => aef_t( array(
				'en' => 'Autumn Economic Forum 2025: A milestone opening a new promising path for Ho Chi Minh City',
				'vi' => 'Diễn đàn Kinh tế mùa Thu năm 2025: Dấu mốc mở ra chặng đường mới đầy triển vọng của TP.HCM',
			) ),
			'date'     => '04/12/2025',
			'kind'     => 'news',
			'external' => true,
		),
	);
}

function aef_hef_photo_albums() {
	return array(
		array(
			'url'     => aef_hef_href( 'photo-youth-inspirational-talks.html' ),
			'img'     => aef_img( 'youth.jpg' ),
			'title'   => aef_t( array(
				'en' => 'Photo: Youth Inspiration Talks',
				'vi' => 'Photo: Youth Inspiration Talks',
			) ),
			'excerpt' => aef_t( array(
				'en' => 'More than 500 young intellectuals and global leaders gathered at the Youth Inspiration Talks, which kicked off the Autumn Economic Forum 2025 on November 25.',
				'vi' => 'Hơn 500 trí thức trẻ và nhà lãnh đạo toàn cầu tại Youth Inspiration Talks, mở màn Diễn đàn Kinh tế Mùa thu 2025 ngày 25/11.',
			) ),
			'meta'    => aef_t( array( 'en' => 'Gallery', 'vi' => 'Thư viện ảnh' ) ) . ' · 11/12/2025',
		),
		array(
			'url'     => aef_hef_href( 'photo-the-opening-ceremony-of-the-vietnam-c4ir.html' ),
			'img'     => aef_img( 'plenary.jpg' ),
			'title'   => aef_t( array(
				'en' => 'Photo: The opening ceremony of the Vietnam C4IR',
				'vi' => 'Hình ảnh: Lễ khánh thành Trung tâm Cách mạng Công nghiệp lần thứ 4 tại TP.HCM',
			) ),
			'excerpt' => aef_t( array(
				'en' => 'The event was attended by the Prime Minister, the Secretary of the Ho Chi Minh City Party Committee, and the Chairman of the Ho Chi Minh City People’s Committee.',
				'vi' => 'Sự kiện có sự tham dự của Thủ tướng Chính phủ, Bí thư Thành ủy và Chủ tịch UBND Thành phố Hồ Chí Minh.',
			) ),
			'meta'    => aef_t( array( 'en' => 'Gallery', 'vi' => 'Thư viện ảnh' ) ),
		),
		array(
			'url'     => aef_hef_href( '100-ceo-connect-meeting-hef-2023.html' ),
			'img'     => aef_img( 'ceo500.jpg' ),
			'title'   => aef_t( array(
				'en' => '100 CEO Connect Meeting 14/9/2023 — Gallery',
				'vi' => 'Chương trình CEO 100 Tea Connect 14/9/2023',
			) ),
			'excerpt' => aef_t( array(
				'en' => 'Published photo set from the CEO Connect programme on hef.gov.vn.',
				'vi' => 'Bộ ảnh đã đăng trên hef.gov.vn từ chương trình CEO Connect.',
			) ),
			'meta'    => aef_t( array( 'en' => 'Gallery', 'vi' => 'Thư viện ảnh' ) ),
		),
	);
}

function aef_hef_videos() {
	return array(
		array(
			'id'       => 'ZV1MG5YAopg',
			'duration' => '03:15',
			'title'    => aef_t( array(
				'en' => 'Autumn Economic Forum 2025 | Diễn đàn Kinh tế mùa thu 2025',
				'vi' => 'Autumn Economic Forum 2025 | Diễn đàn Kinh tế mùa thu 2025',
			) ),
		),
		array(
			'id'       => 'Zt-QqPujMiw',
			'duration' => '01:04',
			'title'    => aef_t( array(
				'en' => 'Opening of the Autumn Economic Forum 2025',
				'vi' => 'KHAI MẠC DIỄN ĐÀN KINH TẾ MÙA THU 2025',
			) ),
		),
		array(
			'id'       => '-N0GZ7iRoJE',
			'duration' => '04:35',
			'title'    => aef_t( array(
				'en' => '60 minutes with the Prime Minister of Viet Nam',
				'vi' => 'DIỄN ĐÀN KINH TẾ MÙA THU 2025: 60 PHÚT CÙNG THỦ TƯỚNG CHÍNH PHỦ VIỆT NAM',
			) ),
		),
		array(
			'id'       => 'KSA6yjGxeHU',
			'duration' => '03:01',
			'title'    => aef_t( array(
				'en' => 'Making the Autumn Economic Forum an annual dialogue of standing',
				'vi' => 'Đưa Diễn đàn Kinh tế mùa Thu thành đối thoại thường niên, uy tín',
			) ),
		),
		array(
			'id'       => 'kG-MlP85BuY',
			'duration' => '10:33',
			'title'    => aef_t( array(
				'en' => 'Prime Minister Pham Minh Chinh at the Autumn Economic Forum | VTV24',
				'vi' => 'Thủ tướng Phạm Minh Chính dự các hoạt động tâm điểm tại Diễn đàn Kinh tế mùa Thu | VTV24',
			) ),
		),
		array(
			'id'       => '5-QjB9l5dcE',
			'duration' => '02:05',
			'title'    => aef_t( array(
				'en' => 'Ho Chi Minh City attracting investment as an international megacity',
				'vi' => 'TP. HỒ CHÍ MINH THU HÚT ĐẦU TƯ TRỞ THÀNH SIÊU ĐÔ THỊ QUỐC TẾ',
			) ),
		),
		array(
			'id'       => '3jfv3m7vEI4',
			'duration' => '02:14',
			'title'    => aef_t( array(
				'en' => 'Ho Chi Minh City building smart logistics and seaports',
				'vi' => 'TP. HỒ CHÍ MINH XÂY DỰNG LOGISTICS VÀ CẢNG BIỂN THÔNG MINH',
			) ),
		),
		array(
			'id'       => 'XEzRuu6wPBw',
			'duration' => '03:30',
			'title'    => aef_t( array(
				'en' => 'More than 500 young intellectuals at the opening dialogue',
				'vi' => 'HƠN 500 TRÍ THỨC TRẺ VÀ NHÀ LÃNH ĐẠO TOÀN CẦU ĐỐI THOẠI MỞ MÀN DIỄN ĐÀN KINH TẾ MÙA THU 2025',
			) ),
		),
	);
}

function aef_hef_publications() {
	return array(
		array(
			'url'      => aef_hef_href( 'the-autumn-economic-forum-2025.html' ),
			'img'      => 'https://hef.gov.vn/wp-content/uploads/2025/12/autumn-economic-forum-2025-progammepr-696x989.jpg',
			'title'    => aef_t( array(
				'en' => 'Proceedings of The Autumn Economic Forum 2025',
				'vi' => 'Proceedings of The Autumn Economic Forum 2025',
			) ),
			'meta'     => aef_t( array( 'en' => 'News', 'vi' => 'Tin tức' ) ) . ' · 29/12/2025',
			'external' => true,
		),
		array(
			'url'      => aef_hef_href( 'autumn-economic-forum-2025-viet-nam-affirms-its-leading-role-in-the-region-driving-global-investment-into-pillars-of-green-and-digital-transformation.html' ),
			'img'      => 'https://hef.gov.vn/wp-content/uploads/2025/12/autumn-economic-forum-8392-696x464.jpg',
			'title'    => aef_t( array(
				'en' => 'Autumn Economic Forum 2025: Viet Nam affirms its leading role in the region, driving global investment into pillars of green and digital transformation',
				'vi' => 'Diễn đàn Kinh tế mùa thu năm 2025: Việt Nam khẳng định vai trò dẫn đầu khu vực, thúc đẩy đầu tư toàn cầu các trụ cột chuyển đổi xanh và chuyển đổi số',
			) ),
			'meta'     => aef_t( array( 'en' => 'News', 'vi' => 'Tin tức' ) ) . ' · 04/12/2025',
			'external' => true,
		),
		array(
			'url'      => aef_hef_href( 'global-economic-futures-competitiveness-in-2030.html' ),
			'img'      => aef_img( 'visual/pillar-cooperation.jpg' ),
			'title'    => aef_t( array(
				'en' => 'Global Economic Futures: Competitiveness in 2030',
				'vi' => 'Tương lai Kinh tế Toàn cầu: Năng lực cạnh tranh năm 2030',
			) ),
			'meta'     => aef_t( array( 'en' => 'Publications', 'vi' => 'Ấn phẩm' ) ) . ' · 24/07/2025',
			'external' => true,
		),
		array(
			'url'      => aef_hef_href( 'global-cybersecurity-outlook-2025.html' ),
			'img'      => aef_img( 'visual/pillar-tech.jpg' ),
			'title'    => aef_t( array(
				'en' => 'Global Cybersecurity Outlook 2025',
				'vi' => 'Báo cáo Triển vọng An ninh mạng Toàn cầu 2025',
			) ),
			'meta'     => aef_t( array( 'en' => 'Publications', 'vi' => 'Ấn phẩm' ) ) . ' · 14/07/2025',
			'external' => true,
		),
	);
}

function aef_story_as_media_card( $post, $kinds = array() ) {
	$id   = is_object( $post ) ? $post->ID : absint( $post );
	$kind = aef_meta( $id, 'story_kind', 'news' );
	$lab  = isset( $kinds[ $kind ] ) ? aef_t( $kinds[ $kind ] ) : $kind;
	$item = array(
		'url'      => get_permalink( $id ),
		'img'      => aef_story_image( $id, 'medium_large' ),
		'title'    => aef_bilingual_title( $id ),
		'date'     => get_the_date( 'd/m/Y', $id ),
		'kind'     => $kind,
		'meta'     => $lab . ' · ' . get_the_date( 'd/m/Y', $id ),
		'excerpt'  => aef_lang() === 'vi' ? aef_meta( $id, 'excerpt_vi' ) : aef_meta( $id, 'excerpt_en' ),
		'external' => false,
	);
	if ( 'video' === $kind ) {
		$item['duration'] = '00:08:12';
	}
	return $item;
}

function aef_home_news_cards() {
	$kinds = function_exists( 'aef_story_kinds' ) ? aef_story_kinds() : array();
	$news  = get_posts(
		array(
			'post_type'      => 'aef_story',
			'posts_per_page' => 4,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
	$cards = array();
	$skip  = false;
	foreach ( $news as $st ) {
		$card = aef_story_as_media_card( $st, $kinds );
		unset( $card['meta'], $card['excerpt'] );
		$cards[] = $card;
		if ( 'video' === $card['kind'] ) {
			$skip = true;
		}
	}
	foreach ( aef_hef_news_items() as $it ) {
		if ( count( $cards ) >= 8 ) {
			break;
		}
		if ( $skip && ! empty( $it['skip'] ) && 'recap' === $it['skip'] ) {
			continue;
		}
		unset( $it['skip'] );
		$cards[] = $it;
	}
	return $cards;
}

function aef_media_card_html( $item ) {
	$url   = isset( $item['url'] ) ? $item['url'] : '#';
	$img   = isset( $item['img'] ) ? $item['img'] : '';
	$title = isset( $item['title'] ) ? $item['title'] : '';
	$dur   = isset( $item['duration'] ) ? $item['duration'] : '';
	$meta  = isset( $item['meta'] ) ? $item['meta'] : '';
	$ex    = isset( $item['excerpt'] ) ? $item['excerpt'] : '';
	$ext   = ! empty( $item['external'] );
	ob_start();
	?>
	<a class="hef-card" href="<?php echo esc_url( $url ); ?>"<?php echo $ext ? ' rel="noopener"' : ''; ?>>
		<figure>
			<?php if ( $img ) : ?>
				<img src="<?php echo esc_url( $img ); ?>" alt="" width="696" height="464" loading="lazy">
			<?php endif; ?>
			<?php if ( $dur ) : ?>
				<span class="hef-dur"><?php echo esc_html( $dur ); ?></span>
			<?php endif; ?>
		</figure>
		<?php if ( $meta ) : ?>
			<small><?php echo esc_html( $meta ); ?></small>
		<?php endif; ?>
		<h3><?php echo esc_html( $title ); ?></h3>
		<?php if ( $ex ) : ?>
			<p><?php echo esc_html( $ex ); ?></p>
		<?php endif; ?>
	</a>
	<?php
	return ob_get_clean();
}

function aef_video_thumb_html( $video, $with_title = false ) {
	$id  = isset( $video['id'] ) ? $video['id'] : '';
	if ( ! $id ) {
		return '';
	}
	$url = 'https://www.youtube.com/watch?v=' . rawurlencode( $id );
	$img = 'https://img.youtube.com/vi/' . rawurlencode( $id ) . '/hqdefault.jpg';
	$dur = isset( $video['duration'] ) ? $video['duration'] : '';
	ob_start();
	?>
	<a class="hef-yt<?php echo $with_title ? ' has-title' : ''; ?>" href="<?php echo esc_url( $url ); ?>" rel="noopener">
		<figure>
			<img src="<?php echo esc_url( $img ); ?>" alt="" width="480" height="360" loading="lazy">
			<span class="hef-play" aria-hidden="true"></span>
			<?php if ( $dur ) : ?>
				<span class="hef-dur"><?php echo esc_html( $dur ); ?></span>
			<?php endif; ?>
		</figure>
		<?php if ( $with_title && ! empty( $video['title'] ) ) : ?>
			<h3><?php echo esc_html( $video['title'] ); ?></h3>
		<?php endif; ?>
	</a>
	<?php
	return ob_get_clean();
}
