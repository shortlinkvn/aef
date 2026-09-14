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

function aef_logo( $file ) {
	return get_template_directory_uri() . '/assets/logos/' . ltrim( $file, '/' );
}

require_once get_template_directory() . '/inc/reference.php';
require_once get_template_directory() . '/inc/travel.php';

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

function aef_bilingual_title( $post_id ) {
	$l = aef_lang();
	$en = get_post_meta( $post_id, 'title_en', true );
	$vi = get_post_meta( $post_id, 'title_vi', true );
	if ( 'vi' === $l ) {
		if ( $vi ) {
			return $vi;
		}
		return get_the_title( $post_id );
	}
	if ( $en ) {
		return $en;
	}
	return get_the_title( $post_id );
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

class AEF_Nav_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$output .= '<a href="' . esc_url( $data_object->url ) . '">' . esc_html( $data_object->title ) . '</a>';
	}
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
}

add_action( 'wp_enqueue_scripts', 'aef_assets' );
function aef_assets() {
	wp_enqueue_style( 'aef-fonts', 'https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Be+Vietnam+Pro:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap', array(), null );
	wp_enqueue_style( 'aef-site', get_template_directory_uri() . '/assets/site.css', array(), '0.9.0' );
	wp_enqueue_style( 'aef-theme', get_stylesheet_uri(), array( 'aef-site' ), '0.9.0' );
	wp_enqueue_script( 'aef-front', get_template_directory_uri() . '/assets/front.js', array(), '0.9.0', true );
}

add_filter( 'document_title_parts', 'aef_title_parts' );
function aef_title_parts( $parts ) {
	$parts['site'] = 'AEF 2026';
	return $parts;
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
				<p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Venue intelligence', 'vi' => 'Thông tin địa điểm' ) ) ); ?></p>
				<h2><?php echo aef_lang() === 'vi' ? 'Bản đồ, sơ đồ và<br>luồng di chuyển' : 'Map, plan and<br>arrival sequence'; ?></h2>
			</div>
			<p class="lead"><?php echo esc_html( aef_t( array(
				'en' => 'Official floor plans, entrances, shuttle points and hotel data will replace illustrative geometry after approval.',
				'vi' => 'Sơ đồ tầng, lối vào, điểm shuttle và dữ liệu khách sạn chính thức sẽ được thay vào sau khi phê duyệt.',
			) ) ); ?></p></div>
			<div class="venue-layout">
				<div class="venue-map rv" role="img" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Illustrative venue map', 'vi' => 'Bản đồ minh họa' ) ) ); ?>">
					<div class="route-line"></div>
					<button class="map-node venue" type="button"><b>AEF</b><span>Thiskyhall Sala</span></button>
					<button class="map-node press" type="button"><b>M</b><span><?php echo esc_html( aef_t( array( 'en' => 'Media', 'vi' => 'Báo chí' ) ) ); ?></span></button>
					<button class="map-node hotel" type="button"><b>H</b><span><?php echo esc_html( aef_t( array( 'en' => 'Hotels', 'vi' => 'Lưu trú' ) ) ); ?></span></button>
					<p class="map-disclosure"><?php echo esc_html( aef_t( array( 'en' => 'Illustrative — not for navigation', 'vi' => 'Minh họa — không dùng để di chuyển' ) ) ); ?></p>
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
				'en' => 'The main forum is at Thiskyhall, 10 Mai Chi Tho, Sala, An Khanh. Hotel and shuttle lists go live after the Organising Committee confirms them.',
				'vi' => 'Diễn đàn chính tại Thiskyhall, số 10 Mai Chí Thọ, Sala, An Khánh. Danh sách khách sạn và xe trung chuyển sẽ đăng khi Ban Tổ chức chốt.',
			) ) ); ?></p></div>
			<div class="travel-grid">
				<a class="travel-card rv" href="<?php echo esc_url( home_url( '/2026/travel/#venue' ) ); ?>">
					<small>01</small>
					<h3><?php echo esc_html( aef_t( array( 'en' => 'Venue', 'vi' => 'Địa điểm' ) ) ); ?></h3>
					<p><?php echo esc_html( aef_t( array( 'vi' => $s['venue_vi'], 'en' => $s['venue_en'] ) ) ); ?></p>
					<span><?php echo esc_html( aef_t( array( 'en' => 'Access and floor plan', 'vi' => 'Lối vào và sơ đồ' ) ) ); ?> →</span>
				</a>
				<a class="travel-card rv" href="<?php echo esc_url( home_url( '/2026/travel/#stay' ) ); ?>">
					<small>02</small>
					<h3><?php echo esc_html( aef_t( array( 'en' => 'Stay', 'vi' => 'Lưu trú' ) ) ); ?></h3>
					<p><?php echo esc_html( aef_t( array(
						'en' => 'Approved hotels will be listed by distance to Thiskyhall. Nothing on this page is a booking.',
						'vi' => 'Khách sạn được duyệt sẽ xếp theo khoảng cách tới Thiskyhall. Trang này không phải chỗ đặt phòng.',
					) ) ); ?></p>
					<span><?php echo esc_html( aef_t( array( 'en' => 'Hotel list', 'vi' => 'Danh sách khách sạn' ) ) ); ?> →</span>
				</a>
				<a class="travel-card rv" href="<?php echo esc_url( home_url( '/2026/travel/#move' ) ); ?>">
					<small>03</small>
					<h3><?php echo esc_html( aef_t( array( 'en' => 'Move', 'vi' => 'Di chuyển' ) ) ); ?></h3>
					<p><?php echo esc_html( aef_t( array(
						'en' => 'Airport, shuttle and on-site arrival sequences will be published when confirmed.',
						'vi' => 'Sân bay, xe trung chuyển và luồng đến sự kiện sẽ công bố khi chốt.',
					) ) ); ?></p>
					<span><?php echo esc_html( aef_t( array( 'en' => 'Transport notes', 'vi' => 'Hướng dẫn di chuyển' ) ) ); ?> →</span>
				</a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function aef_primary_nav() {
	$items = array(
		array( 'home', '/', array( 'en' => 'Home', 'vi' => 'Trang chủ' ), array( 'en' => 'Home', 'vi' => 'Trang chủ' ), false ),
		array( 'about', '/about/', array( 'en' => 'About', 'vi' => 'Giới thiệu' ), array( 'en' => 'About', 'vi' => 'Giới thiệu' ), true ),
		array( 'topics', '/topics/', array( 'en' => 'Topics', 'vi' => 'Chuyên đề' ), array( 'en' => 'Topics', 'vi' => 'Chuyên đề' ), true ),
		array( 'programme', '/2026/programme/', array( 'en' => 'Programme', 'vi' => 'Chương trình' ), array( 'en' => 'Programme', 'vi' => 'Chương trình' ), true ),
		array( 'speakers', '/2026/speakers/', array( 'en' => 'Speakers', 'vi' => 'Diễn giả' ), array( 'en' => 'Speakers', 'vi' => 'Diễn giả' ), true ),
		array( 'media', '/2026/media/', array( 'en' => 'Media', 'vi' => 'Truyền thông' ), array( 'en' => 'Media', 'vi' => 'Truyền thông' ), true ),
		array( 'support', '/2026/support/', array( 'en' => 'Support Centre', 'vi' => 'Trung tâm Hỗ trợ' ), array( 'en' => 'Support', 'vi' => 'Hỗ trợ' ), true ),
	);
	foreach ( $items as $item ) {
		$full  = aef_t( $item[2] );
		$short = aef_t( $item[3] );
		echo '<div class="nav-item' . ( $item[4] ? ' has-mega' : '' ) . '" data-panel="' . esc_attr( $item[0] ) . '">';
		echo '<a class="nav-link" href="' . esc_url( home_url( $item[1] ) ) . '"' . ( $item[4] ? ' aria-haspopup="true"' : '' ) . '>';
		echo '<span class="nav-full">' . esc_html( $full ) . '</span>';
		if ( $short !== $full ) {
			echo '<span class="nav-short">' . esc_html( $short ) . '</span>';
		}
		echo '</a></div>';
	}
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
	          <p><?php echo esc_html( aef_t( array( 'en' => 'Four programme layers across Forum week. Draft until approved.', 'vi' => 'Bốn lớp chương trình trong tuần Diễn đàn. Dự thảo cho đến khi được duyệt.' ) ) ); ?></p>
	        </div>
	        <div class="mega-cols">
	          <?php
				aef_mega_link( '/2026/programme/', array( 'en' => 'Full schedule', 'vi' => 'Lịch đầy đủ' ), array( 'en' => 'Times, rooms and access by day.', 'vi' => 'Giờ, phòng và quyền tiếp cận theo ngày.' ) );
				aef_mega_link( '/2026/programme/#axes', array( 'en' => 'How to read the week', 'vi' => 'Cách đọc chương trình' ), array( 'en' => 'The framing questions under review.', 'vi' => 'Các câu hỏi định hình đang xem xét.' ) );
				aef_mega_link( '/2026/sessions/high-level-plenary/', array( 'en' => 'High-level plenary', 'vi' => 'Phiên toàn thể cấp cao' ), array( 'en' => 'The central session of the Forum.', 'vi' => 'Phiên trung tâm của Diễn đàn.' ) );
	          ?>
	        </div>
	      </div>
	    </section>
	    <section class="mega-panel" data-panel="speakers">
	      <div class="shell mega-grid">
	        <div class="mega-intro">
	          <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'People', 'vi' => 'Người tham gia' ) ) ); ?></p>
	          <h3><?php echo esc_html( aef_t( array( 'en' => 'Speakers', 'vi' => 'Diễn giả' ) ) ); ?></h3>
	          <p><?php echo esc_html( aef_t( array( 'en' => 'Profiles go live after written confirmation. Cards on the site are editable mockups.', 'vi' => 'Hồ sơ lên sau xác nhận bằng văn bản. Thẻ trên site là mô hình có thể thay.' ) ) ); ?></p>
	        </div>
	        <div class="mega-cols">
	          <?php
				aef_mega_link( '/2026/speakers/', array( 'en' => 'All speakers', 'vi' => 'Toàn bộ diễn giả' ), array( 'en' => 'Directory by role — government, international, business, research.', 'vi' => 'Danh mục theo nhóm — chính phủ, quốc tế, doanh nghiệp, nghiên cứu.' ) );
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
				aef_mega_link( '/2026/travel/', array( 'en' => 'Travel kit', 'vi' => 'Cẩm nang đi lại' ), array( 'en' => 'Venue, stay, airport and the city.', 'vi' => 'Địa điểm, lưu trú, sân bay và thành phố.' ) );
				aef_mega_link( aef_settings()['register_path'], array( 'en' => 'How to register', 'vi' => 'Cách đăng ký' ), array( 'en' => 'Information page, then the separate portal.', 'vi' => 'Trang hướng dẫn, rồi cổng riêng.' ) );
	          ?>
	        </div>
	      </div>
	    </section>
	  </div>
	</div>
	<?php
}
