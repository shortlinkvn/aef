<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$lang = function_exists( 'aef_lang' ) ? aef_lang() : 'en';
$s    = function_exists( 'aef_settings' ) ? aef_settings() : array();
$css  = get_template_directory_uri() . '/assets/cybertech-ref.css?ver=1.0.0';
$js   = get_template_directory_uri() . '/assets/cybertech-ref.js?ver=1.0.0';
$fav  = function_exists( 'aef_logo' ) ? aef_logo( 'favicon-32.png' ) : '';
$hero = function_exists( 'aef_copy_media' )
	? aef_copy_media( 'home_hero_bg_id', aef_img( 'visual/collaboration-roads.jpg' ) )
	: aef_img( 'visual/collaboration-roads.jpg' );
$theme_photo = aef_img( 'visual/hcmc-dusk.jpg' );
$pos   = aef_t( array(
	'en' => ! empty( $s['positioning_en'] ) ? $s['positioning_en'] : 'The Convergence Of New Global Growth Engines',
	'vi' => ! empty( $s['positioning_vi'] ) ? $s['positioning_vi'] : 'Sự hội tụ của các cực tăng trưởng mới toàn cầu',
) );
$theme = aef_t( array(
	'en' => ! empty( $s['theme_en'] ) ? $s['theme_en'] : 'Collaboration in a New Era',
	'vi' => ! empty( $s['theme_vi'] ) ? $s['theme_vi'] : 'Tinh thần hợp tác trong kỷ nguyên mới',
) );
$theme_other = 'vi' === $lang
	? ( ! empty( $s['theme_en'] ) ? $s['theme_en'] : 'Collaboration in a New Era' )
	: ( ! empty( $s['theme_vi'] ) ? $s['theme_vi'] : 'Tinh thần hợp tác trong kỷ nguyên mới' );
$h_lines = function_exists( 'aef_stack_lines' ) ? aef_stack_lines( $pos ) : array( $pos );
$t_lines = function_exists( 'aef_stack_lines' ) ? aef_stack_lines( $theme ) : array( $theme );
$city    = aef_t( array(
	'en' => ! empty( $s['city_en'] ) ? $s['city_en'] : 'Ho Chi Minh City',
	'vi' => ! empty( $s['city_vi'] ) ? $s['city_vi'] : 'Thành phố Hồ Chí Minh',
) );
$venue   = aef_t( array(
	'en' => ! empty( $s['venue_en'] ) ? $s['venue_en'] : 'Thiskyhall, 10 Mai Chi Tho, Sala, An Khanh',
	'vi' => ! empty( $s['venue_vi'] ) ? $s['venue_vi'] : 'Thiskyhall, 10 Mai Chí Thọ, Sala, phường An Khánh',
) );
$week    = ! empty( $s['week_dates'] ) ? $s['week_dates'] : '26–29.10.2026';
$main    = ! empty( $s['main_dates'] ) ? $s['main_dates'] : '27–28.10';
$reg     = function_exists( 'aef_register_url' ) ? aef_register_url() : home_url( '/delegates/how-to-register/' );
$live    = home_url( '/' );
$self_en = esc_url( add_query_arg( array( 'ref' => 'cybertech', 'lang' => 'en' ), home_url( '/' ) ) );
$self_vi = esc_url( add_query_arg( array( 'ref' => 'cybertech', 'lang' => 'vi' ), home_url( '/' ) ) );
$target  = function_exists( 'aef_coming' ) && aef_coming( 'coming_target' )
	? aef_coming( 'coming_target' )
	: '2026-10-27T08:00:00+07:00';
$aef_w   = aef_logo( 'aef-logo-mono-white.svg' );
$aef_c   = aef_logo( 'aef-logo-brand-palette.svg' );
$ubnd    = aef_logo( 'ubnd-kv.png' );
$ubnd_c  = aef_logo( 'ubnd.png' );
$c4ir_d  = aef_c4ir_mark( true );
$c4ir    = aef_c4ir_mark();
$host1_n = aef_t( array( 'vi' => $s['host_1_name_vi'], 'en' => $s['host_1_name_en'] ) );
$host1_r = aef_t( array( 'vi' => $s['host_1_role_vi'], 'en' => $s['host_1_role_en'] ) );
$host2_n = aef_t( array( 'vi' => $s['host_2_name_vi'], 'en' => $s['host_2_name_en'] ) );
$host2_r = aef_t( array( 'vi' => $s['host_2_role_vi'], 'en' => $s['host_2_role_en'] ) );
$host3_n = aef_copy( 'home_hosts_3_name' );
$host3_r = aef_copy( 'home_hosts_3_role' );
if ( '' === $host3_n ) {
	$host3_n = 'HCMC C4IR';
}
if ( '' === $host3_r ) {
	$host3_r = aef_t( array( 'en' => 'Implementing centre', 'vi' => 'Đơn vị thực hiện' ) );
}
$pillars = function_exists( 'aef_pillars' ) ? aef_pillars() : array();
$sides   = function_exists( 'aef_home_side_items' ) ? array_slice( aef_home_side_items(), 0, 6 ) : array();
$partners = function_exists( 'aef_home_partner_logos' ) ? aef_home_partner_logos() : array();
$spk = new WP_Query( function_exists( 'aef_speaker_public_args' )
	? aef_speaker_public_args( array( 'posts_per_page' => 8 ) )
	: array( 'post_type' => 'aef_speaker', 'posts_per_page' => 8 )
);
$news = get_posts( array( 'post_type' => 'aef_story', 'posts_per_page' => 3, 'post_status' => 'publish' ) );
$days = array(
	array(
		'when'  => '27.10',
		'tag'   => array( 'en' => 'Main forum', 'vi' => 'Diễn đàn chính' ),
		'title' => array( 'en' => 'Thematic sessions', 'vi' => 'Phiên thảo luận chuyên đề' ),
		'body'  => array(
			'en' => 'Opening remarks by a Vice Chairman of the City People’s Committee, then 15 named parallel sessions in three rooms, plus Rising Star Arena (all day) at Thiskyhall.',
			'vi' => 'Phát biểu khai mạc của Phó Chủ tịch UBND Thành phố, sau đó 15 phiên chuyên đề song song tại ba phòng, kèm khu trình diễn công nghệ cả ngày tại Thiskyhall.',
		),
	),
	array(
		'when'  => '28.10',
		'tag'   => array( 'en' => 'Main forum', 'vi' => 'Diễn đàn chính' ),
		'title' => array( 'en' => 'High-level day', 'vi' => 'Ngày toàn thể cấp cao' ),
		'body'  => array(
			'en' => 'High-level plenary (live), dialogue with the Prime Minister, then in-depth presentations and ministerial dialogue. Gala venue: to be confirmed.',
			'vi' => 'Phiên toàn thể cấp cao (truyền hình trực tiếp), đối thoại cùng Thủ tướng, tham luận chuyên sâu và đối thoại cấp Bộ. Địa điểm Gala: Đang xác nhận.',
		),
	),
	array(
		'when'  => '26–29.10',
		'tag'   => array( 'en' => 'Forum week', 'vi' => 'Tuần Diễn đàn' ),
		'title' => array( 'en' => 'City programme around the Forum', 'vi' => 'Chuỗi hoạt động quanh diễn đàn chính' ),
		'body'  => array(
			'en' => 'Collaboration Roads and GRECO 2026 on four city streets; CEO 500 and Open Innovation Day at Thiskyhall; Viet Nam–India, Israel, China and Nordic programmes. Some venues: to be confirmed.',
			'vi' => 'Collaboration Roads và GRECO 2026 trên bốn trục phố; CEO 500 và Open Innovation Day tại Thiskyhall; các chương trình Việt Nam – Ấn Độ, Israel, Trung Quốc, Bắc Âu. Một số địa điểm: Đang xác nhận.',
		),
	),
);
$lanes = array(
	array(
		'n' => '01', 'url' => '/delegates/how-to-register/', 'img' => 'visual/forum-hall.jpg',
		'k' => array( 'en' => 'Delegates', 'vi' => 'Đại biểu' ),
		'h' => array( 'en' => 'Attend', 'vi' => 'Tham dự' ),
		'p' => array( 'en' => 'Invitation, review, visa notes and badge collection.', 'vi' => 'Thư mời, xét duyệt, thị thực và nhận thẻ.' ),
	),
	array(
		'n' => '02', 'url' => '/support/media/', 'img' => 'youth.jpg',
		'k' => array( 'en' => 'Media', 'vi' => 'Báo chí' ),
		'h' => array( 'en' => 'Cover', 'vi' => 'Tác nghiệp' ),
		'p' => array( 'en' => 'Accreditation, press centre and interview requests.', 'vi' => 'Đăng ký tác nghiệp, trung tâm báo chí và đề nghị phỏng vấn.' ),
	),
	array(
		'n' => '03', 'url' => '/travel/', 'img' => 'travel/city/sala.jpg',
		'k' => array( 'en' => 'Travel', 'vi' => 'Cẩm nang' ),
		'h' => array( 'en' => 'Plan the visit', 'vi' => 'Lên đường' ),
		'p' => array( 'en' => 'Thiskyhall, Sala, airport, stay and the city.', 'vi' => 'Thiskyhall, Sala, sân bay, lưu trú và thành phố.' ),
	),
);
$points = array(
	array( 'en' => 'Shifts in the global economic model', 'vi' => 'Chuyển dịch mô hình kinh tế toàn cầu', 'en2' => 'Lessons from economic restructuring by nations and megacities; repositioning Viet Nam and ASEAN in global value chains.', 'vi2' => 'Kinh nghiệm tái cấu trúc nền kinh tế của các quốc gia và các siêu đô thị; định vị Việt Nam – ASEAN trong chuỗi giá trị toàn cầu.' ),
	array( 'en' => 'Institutions, finance and strategic technologies', 'vi' => 'Thể chế, tài chính và công nghệ chiến lược', 'en2' => 'Institutional reform, unlocking international capital, digital economy policy and strategic technologies.', 'vi2' => 'Kinh nghiệm thúc đẩy thể chế, khơi thông dòng vốn quốc tế, khung chính sách kinh tế số và các công nghệ chiến lược.' ),
	array( 'en' => 'International cooperation for a new growth model', 'vi' => 'Hợp tác quốc tế vì mô hình tăng trưởng mới', 'en2' => 'Science and technology cooperation, and collaboration among firms and young global business leaders.', 'vi2' => 'Hợp tác khoa học – công nghệ trong các ngành phục vụ mô hình tăng trưởng mới; hợp tác của cộng đồng doanh nghiệp và lãnh đạo doanh nghiệp trẻ toàn cầu.' ),
);
$title = aef_t( array(
	'en' => 'AEF 2026 — Cybertech reference (Brand 9.9)',
	'vi' => 'AEF 2026 — Bản tham chiếu Cybertech (Brand 9.9)',
) );
?><!doctype html>
<html lang="<?php echo esc_attr( $lang ); ?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo esc_html( $title ); ?></title>
<meta name="robots" content="noindex,nofollow">
<link rel="icon" href="<?php echo esc_url( $fav ); ?>" sizes="32x32">
<link rel="stylesheet" href="<?php echo esc_url( $css ); ?>">
</head>
<body class="cx">
<div class="cx-brief">
  <div class="cx-shell">
    <div><?php echo 'vi' === $lang
		? '<b>Bản tham chiếu</b> · Layout Cybertech + Brand Guideline 9.9 · copy chính thức · không phải site đang chạy'
		: '<b>Reference</b> · Cybertech layout + Brand Guideline 9.9 · official copy · not the live site'; ?></div>
    <div class="cx-brief-links">
      <a href="<?php echo esc_url( $live ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Live site', 'vi' => 'Site đang chạy' ) ) ); ?></a>
      <a href="#cx-spec"><?php echo esc_html( aef_t( array( 'en' => 'What changed vs demo', 'vi' => 'Khác demo thế nào' ) ) ); ?></a>
    </div>
  </div>
</div>

<header class="cx-head">
  <div class="cx-shell cx-head-bar">
    <a class="cx-brand" href="#top" aria-label="AEF 2026">
      <img src="<?php echo esc_url( $aef_c ); ?>" alt="AEF 2026" width="160" height="64">
      <span class="cx-brand-txt"><span>Autumn Economic</span><em>Forum 2026</em></span>
    </a>
    <nav class="cx-nav" data-cx-nav aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Primary', 'vi' => 'Chính' ) ) ); ?>">
      <a href="#gioi-thieu"><?php echo esc_html( aef_t( array( 'en' => 'About', 'vi' => 'Giới thiệu' ) ) ); ?></a>
      <a href="#chuong-trinh"><?php echo esc_html( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ) ); ?></a>
      <a href="#dien-gia"><?php echo esc_html( aef_t( array( 'en' => 'Speakers', 'vi' => 'Diễn giả' ) ) ); ?></a>
      <a href="#truyen-thong"><?php echo esc_html( aef_t( array( 'en' => 'Media', 'vi' => 'Truyền thông' ) ) ); ?></a>
      <a href="#ho-tro"><?php echo esc_html( aef_t( array( 'en' => 'Support', 'vi' => 'Hỗ trợ' ) ) ); ?></a>
    </nav>
    <div class="cx-head-end">
      <div class="cx-lang" role="group" aria-label="Language">
        <a href="<?php echo $self_en; ?>" <?php echo 'en' === $lang ? 'aria-pressed="true"' : ''; ?>>EN</a>
        <a href="<?php echo $self_vi; ?>" <?php echo 'vi' === $lang ? 'aria-pressed="true"' : ''; ?>>VI</a>
      </div>
      <a class="cx-cta" href="<?php echo esc_url( $reg ); ?>"><?php echo esc_html( aef_copy( 'home_hero_cta2' ) ); ?></a>
      <button class="cx-burger" type="button" data-cx-burger aria-expanded="false" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Menu', 'vi' => 'Menu' ) ) ); ?>"><i></i><i></i><i></i></button>
    </div>
  </div>
</header>

<section class="cx-hero" id="top">
  <div class="cx-hero-bg" style="background-image:url('<?php echo esc_url( $hero ); ?>')"></div>
  <div class="cx-shell">
    <div class="cx-lockup" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'AEF · City People’s Committee · C4IR', 'vi' => 'AEF · UBND Thành phố · C4IR' ) ) ); ?>">
      <img class="cx-lockup-aef" src="<?php echo esc_url( $aef_w ); ?>" alt="AEF 2026" width="200" height="80">
      <img class="cx-lockup-seal" src="<?php echo esc_url( $ubnd ); ?>" alt="<?php echo esc_attr( $host2_n ); ?>" width="120" height="88">
      <img class="cx-lockup-c4ir" src="<?php echo esc_url( $c4ir_d ); ?>" alt="Viet Nam Centre for the Fourth Industrial Revolution" width="190" height="105">
    </div>
    <div class="cx-hero-copy">
      <p class="cx-kicker"><?php echo esc_html( aef_t( array(
		'en' => 'Autumn Economic Forum 2026 · Ho Chi Minh City',
		'vi' => 'Diễn đàn Kinh tế Mùa thu 2026 · Thành phố Hồ Chí Minh',
	) ) ); ?></p>
      <h1 class="cx-h1"><?php foreach ( $h_lines as $line ) : ?><span><?php echo esc_html( $line ); ?></span><?php endforeach; ?></h1>
      <p class="cx-theme-line"><small><?php echo esc_html( aef_t( array( 'en' => 'Theme', 'vi' => 'Chủ đề' ) ) ); ?></small><?php foreach ( $t_lines as $i => $tl ) : ?><?php echo $i ? '<br>' : ''; ?><?php echo esc_html( $tl ); ?><?php endforeach; ?></p>
      <?php if ( aef_has_copy( 'home_hero_lead' ) ) : ?>
      <p class="cx-lead"><?php echo esc_html( aef_copy( 'home_hero_lead' ) ); ?></p>
      <?php endif; ?>
      <div class="cx-hero-meta">
        <div><small><?php echo esc_html( aef_copy( 'home_meta_week' ) ); ?></small><b><?php echo esc_html( $week ); ?></b></div>
        <div><small><?php echo esc_html( aef_copy( 'home_meta_main' ) ); ?></small><b><?php echo esc_html( $main ); ?></b></div>
        <div><small><?php echo esc_html( aef_copy( 'home_meta_city' ) ); ?></small><b><?php echo esc_html( $city ); ?></b></div>
      </div>
      <div class="cx-count" data-cx-count data-target="<?php echo esc_attr( $target ); ?>">
        <div><b data-u="d">—</b><span><?php echo esc_html( aef_t( array( 'en' => 'Days', 'vi' => 'Ngày' ) ) ); ?></span></div>
        <div><b data-u="h">—</b><span><?php echo esc_html( aef_t( array( 'en' => 'Hours', 'vi' => 'Giờ' ) ) ); ?></span></div>
        <div><b data-u="m">—</b><span><?php echo esc_html( aef_t( array( 'en' => 'Minutes', 'vi' => 'Phút' ) ) ); ?></span></div>
        <div><b data-u="s">—</b><span><?php echo esc_html( aef_t( array( 'en' => 'Seconds', 'vi' => 'Giây' ) ) ); ?></span></div>
      </div>
      <div class="cx-hero-act">
        <a class="cx-cta" href="#chuong-trinh"><?php echo esc_html( aef_copy( 'home_hero_cta1' ) ); ?></a>
        <a class="cx-cta cx-cta-ghost" href="<?php echo esc_url( $reg ); ?>"><?php echo esc_html( aef_copy( 'home_hero_cta2' ) ); ?></a>
      </div>
    </div>
  </div>
</section>

<section class="cx-sec-tight" id="gioi-thieu">
  <div class="cx-shell">
    <p class="cx-eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Organisation', 'vi' => 'Tổ chức' ) ) ); ?></p>
    <div class="cx-headrow">
      <h2 class="cx-h2"><?php echo esc_html( aef_t( array( 'en' => 'Who convenes AEF 2026', 'vi' => 'Ai tổ chức AEF 2026' ) ) ); ?></h2>
      <p class="cx-copy"><?php echo esc_html( aef_t( array(
		'en' => 'Three marks only on overall KV: the Forum, the City, the implementing centre. WEF is not shown on the global lockup.',
		'vi' => 'Cụm nhận diện tổng thể chỉ gồm Diễn đàn, Thành phố và đơn vị thực hiện. WEF không xuất hiện trên KV tổng.',
	) ) ); ?></p>
    </div>
    <div class="cx-hosts">
      <div class="cx-host">
        <small><?php echo esc_html( $host1_r ); ?></small>
        <div class="cx-mark">VN</div>
        <b><?php echo esc_html( $host1_n ); ?></b>
      </div>
      <div class="cx-host">
        <small><?php echo esc_html( $host2_r ); ?></small>
        <img src="<?php echo esc_url( $ubnd_c ); ?>" alt="" width="96" height="96">
        <b><?php echo esc_html( $host2_n ); ?></b>
      </div>
      <div class="cx-host">
        <small><?php echo esc_html( $host3_r ); ?></small>
        <img src="<?php echo esc_url( $c4ir ); ?>" alt="" width="190" height="105">
        <b><?php echo esc_html( $host3_n ); ?></b>
      </div>
    </div>
  </div>
</section>

<section class="cx-theme">
  <div class="cx-theme-copy">
    <p class="cx-eyebrow"><?php echo esc_html( aef_copy( 'home_theme_eyebrow' ) ); ?></p>
    <h2><?php foreach ( $t_lines as $tl ) : ?><span><?php echo esc_html( $tl ); ?></span><?php endforeach; ?></h2>
    <p class="cx-theme-en"><?php echo esc_html( $theme_other ); ?></p>
    <div class="cx-copy"><?php echo aef_paras_html( aef_copy( 'home_theme_lead' ) ); ?></div>
    <ul class="cx-points">
      <?php foreach ( $points as $pt ) : ?>
      <li><b><?php echo esc_html( aef_t( array( 'en' => $pt['en'], 'vi' => $pt['vi'] ) ) ); ?></b><span><?php echo esc_html( aef_t( array( 'en' => $pt['en2'], 'vi' => $pt['vi2'] ) ) ); ?></span></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="cx-theme-photo" style="background-image:url('<?php echo esc_url( $theme_photo ); ?>')" role="img" aria-label="<?php echo esc_attr( $city ); ?>"></div>
</section>

<section class="cx-sec cx-mist">
  <div class="cx-shell">
    <div class="cx-headrow">
      <h2 class="cx-h2"><?php echo esc_html( aef_copy( 'home_figures_title' ) ); ?></h2>
      <p class="cx-copy"><?php echo esc_html( aef_t( array(
		'en' => '2026 figures only. Country and speaker counts are not published until confirmed.',
		'vi' => 'Chỉ số liệu 2026 đã chốt. Số quốc gia và diễn giả không đưa khi chưa xác nhận.',
	) ) ); ?></p>
    </div>
    <div class="cx-figs">
      <?php for ( $i = 1; $i <= 4; $i++ ) :
			$n = aef_copy( 'home_fig_' . $i . '_n' );
			if ( 4 === $i && aef_copy( 'home_fig_4_n' ) ) {
				$n = aef_copy( 'home_fig_4_n' );
			}
			?>
      <div class="cx-fig"><b><?php echo esc_html( $n ); ?></b><span><?php echo esc_html( aef_copy( 'home_fig_' . $i ) ); ?></span></div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<section class="cx-sec" id="chuong-trinh">
  <div class="cx-shell">
    <div class="cx-headrow">
      <div>
        <p class="cx-eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ) ); ?></p>
        <h2 class="cx-h2"><?php echo esc_html( aef_copy( 'home_programme_title' ) ); ?></h2>
      </div>
      <p class="cx-copy"><?php echo esc_html( aef_copy( 'home_programme_lead' ) ); ?></p>
    </div>
    <div class="cx-days">
      <?php foreach ( $days as $day ) : ?>
      <a class="cx-day" href="<?php echo esc_url( home_url( '/programme/' ) ); ?>">
        <small><?php echo esc_html( aef_t( $day['tag'] ) ); ?></small>
        <time><?php echo esc_html( $day['when'] ); ?></time>
        <h3><?php echo esc_html( aef_t( $day['title'] ) ); ?></h3>
        <p><?php echo esc_html( aef_t( $day['body'] ) ); ?></p>
        <span><?php echo esc_html( aef_t( array( 'en' => 'Open programme', 'vi' => 'Xem chương trình' ) ) ); ?> →</span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if ( $pillars ) : ?>
<section class="cx-sec cx-mist">
  <div class="cx-shell">
    <div class="cx-headrow">
      <h2 class="cx-h2"><?php echo esc_html( aef_copy( 'home_pillars_title' ) ); ?></h2>
      <p class="cx-copy"><?php echo esc_html( aef_copy( 'home_pillars_lead' ) ); ?></p>
    </div>
    <div class="cx-pillars">
      <?php foreach ( $pillars as $p ) :
			$img = ! empty( $p['image_url'] ) ? $p['image_url'] : ( ! empty( $p['image'] ) ? aef_img( $p['image'] ) : '' );
			?>
      <a class="cx-pillar" href="<?php echo esc_url( home_url( '/topics/#pillar-' . $p['slug'] ) ); ?>">
        <figure<?php echo $img ? ' style="background-image:url(\'' . esc_url( $img ) . '\')"' : ''; ?>></figure>
        <div>
          <em><?php echo esc_html( $p['n'] ); ?></em>
          <h3><?php echo esc_html( aef_t( isset( $p['short'] ) ? $p['short'] : $p['title'] ) ); ?></h3>
          <?php if ( ! empty( $p['card'] ) ) : ?><p><?php echo esc_html( aef_t( $p['card'] ) ); ?></p><?php endif; ?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ( $sides ) : ?>
<section class="cx-sec">
  <div class="cx-shell">
    <div class="cx-headrow">
      <div>
        <p class="cx-eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Forum week · 26–29 October 2026', 'vi' => 'Tuần Diễn đàn · 26–29/10/2026' ) ) ); ?></p>
        <h2 class="cx-h2"><?php echo esc_html( aef_copy( 'home_side_title' ) ); ?></h2>
      </div>
      <p class="cx-copy"><?php echo esc_html( aef_copy( 'home_side_lead' ) ); ?></p>
    </div>
    <div class="cx-side">
      <?php foreach ( $sides as $item ) : ?>
      <a href="<?php echo esc_url( home_url( $item['url'] ) ); ?>">
        <small><?php echo esc_html( aef_t( $item['when'] ) ); ?></small>
        <h3><?php echo esc_html( aef_t( $item['title'] ) ); ?></h3>
        <p><?php echo esc_html( aef_t( $item['body'] ) ); ?></p>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="cx-sec cx-mist" id="dien-gia">
  <div class="cx-shell">
    <div class="cx-headrow">
      <div>
        <p class="cx-eyebrow"><?php echo esc_html( aef_copy( 'home_speakers_eyebrow' ) ); ?></p>
        <h2 class="cx-h2"><?php echo esc_html( aef_copy( 'home_speakers_title' ) ); ?></h2>
      </div>
      <p class="cx-copy"><?php echo esc_html( aef_copy( 'home_speakers_lead' ) ); ?></p>
    </div>
    <?php if ( $spk->have_posts() ) : ?>
    <div class="cx-people">
      <?php
		$i = 0;
		while ( $spk->have_posts() ) :
			$spk->the_post();
			$i++;
			$id    = get_the_ID();
			$thumb = function_exists( 'aef_speaker_portrait_url' ) ? aef_speaker_portrait_url( $id, 'medium_large' ) : '';
			$line  = function_exists( 'aef_speaker_credit' ) ? aef_speaker_credit( $id ) : '';
			?>
      <a class="cx-person" href="<?php echo esc_url( get_permalink( $id ) ); ?>">
        <div class="ph"><?php if ( $thumb ) : ?><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( aef_bilingual_title( $id ) ); ?>"><?php endif; ?></div>
        <div class="bd">
          <h3><?php echo esc_html( aef_bilingual_title( $id ) ); ?></h3>
          <?php if ( $line ) : ?><p><?php echo esc_html( $line ); ?></p><?php endif; ?>
        </div>
      </a>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
    </div>
    <p class="cx-more"><a href="<?php echo esc_url( home_url( '/speakers/' ) ); ?>"><?php echo esc_html( aef_copy( 'home_speakers_cta' ) ); ?> →</a></p>
    <?php else : ?>
    <p class="cx-empty"><?php echo esc_html( aef_t( array(
		'en' => 'Speaker names are published when confirmed. This block stays empty rather than inventing profiles.',
		'vi' => 'Tên diễn giả được công bố khi đã chốt. Khối này để trống, không bịa hồ sơ.',
	) ) ); ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="cx-sec" id="truyen-thong">
  <div class="cx-shell">
    <div class="cx-headrow">
      <div>
        <p class="cx-eyebrow"><?php echo esc_html( aef_copy( 'home_media_eyebrow' ) ); ?></p>
        <h2 class="cx-h2"><?php echo esc_html( aef_copy( 'home_media_title' ) ); ?></h2>
      </div>
      <p class="cx-copy"><?php echo esc_html( aef_copy( 'home_media_lead' ) ); ?></p>
    </div>
    <?php if ( $news ) : ?>
    <div class="cx-news">
      <?php foreach ( $news as $st ) :
			$sid = $st->ID;
			$img = function_exists( 'aef_story_image' ) ? aef_story_image( $sid, 'large' ) : get_the_post_thumbnail_url( $sid, 'large' );
			?>
      <a class="cx-card" href="<?php echo esc_url( get_permalink( $sid ) ); ?>">
        <figure><?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt=""><?php endif; ?></figure>
        <div class="bd">
          <small><?php echo esc_html( get_the_date( 'd.m.Y', $sid ) ); ?></small>
          <h3><?php echo esc_html( aef_bilingual_title( $sid ) ); ?></h3>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <p class="cx-more"><a href="<?php echo esc_url( get_post_type_archive_link( 'aef_story' ) ? get_post_type_archive_link( 'aef_story' ) : home_url( '/media/' ) ); ?>"><?php echo esc_html( aef_copy( 'home_media_cta' ) ); ?> →</a></p>
  </div>
</section>

<section class="cx-sec cx-mist">
  <div class="cx-shell">
    <div class="cx-headrow">
      <div>
        <p class="cx-eyebrow"><?php echo esc_html( aef_copy( 'home_partners_eyebrow' ) ); ?></p>
        <h2 class="cx-h2"><?php echo aef_heading_html( aef_copy( 'home_partners_title' ) ); ?></h2>
      </div>
      <p class="cx-copy"><?php echo esc_html( aef_copy( 'home_partners_lead' ) ); ?></p>
    </div>
    <?php if ( $partners ) : ?>
    <div class="cx-logos">
      <?php foreach ( $partners as $it ) : ?>
      <figure class="cx-logo"><img src="<?php echo esc_url( $it['logo'] ); ?>" alt="<?php echo esc_attr( $it['name'] ); ?>"></figure>
      <?php endforeach; ?>
    </div>
    <?php else : ?>
    <p class="cx-empty"><?php echo esc_html( aef_t( array(
		'en' => 'Partner logos go here only after contracts. No invented names, no sponsor amounts on aef.vn.',
		'vi' => 'Logo đối tác chỉ hiện khi đã có hợp đồng. Không bịa tên, không ghi số tiền tài trợ trên aef.vn.',
	) ) ); ?></p>
    <?php endif; ?>
    <p class="cx-more"><a href="<?php echo esc_url( home_url( '/2026/partners/' ) ); ?>"><?php echo esc_html( aef_copy( 'home_partners_cta' ) ); ?> →</a></p>
  </div>
</section>

<section class="cx-sec" id="ho-tro">
  <div class="cx-shell">
    <div class="cx-headrow">
      <div>
        <p class="cx-eyebrow"><?php echo esc_html( aef_copy( 'home_support_eyebrow' ) ); ?></p>
        <h2 class="cx-h2"><?php echo esc_html( aef_copy( 'home_support_title' ) ); ?></h2>
      </div>
      <p class="cx-copy"><?php echo esc_html( aef_copy( 'home_support_lead' ) ); ?></p>
    </div>
    <div class="cx-lanes">
      <?php foreach ( $lanes as $lane ) : ?>
      <a class="cx-lane" href="<?php echo esc_url( home_url( $lane['url'] ) ); ?>">
        <figure><img src="<?php echo esc_url( aef_img( $lane['img'] ) ); ?>" alt=""></figure>
        <div class="bd">
          <small><?php echo esc_html( $lane['n'] . ' · ' . aef_t( $lane['k'] ) ); ?></small>
          <h3><?php echo esc_html( aef_t( $lane['h'] ) ); ?></h3>
          <p><?php echo esc_html( aef_t( $lane['p'] ) ); ?></p>
          <span><?php echo esc_html( aef_t( array( 'en' => 'Open', 'vi' => 'Mở' ) ) ); ?> →</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cx-close cx-dark">
  <div class="cx-shell">
    <h2 class="cx-h2"><?php echo esc_html( aef_copy( 'home_close_title' ) ); ?></h2>
    <div class="cx-copy"><?php echo aef_paras_html( aef_copy( 'home_close_lead' ) ); ?></div>
    <div class="cx-hero-act">
      <a class="cx-cta" href="<?php echo esc_url( home_url( '/programme/' ) ); ?>"><?php echo esc_html( aef_copy( 'home_close_cta1' ) ); ?></a>
      <a class="cx-cta cx-cta-ghost" href="<?php echo esc_url( $reg ); ?>"><?php echo esc_html( aef_copy( 'home_close_cta2' ) ); ?></a>
    </div>
  </div>
</section>

<section class="cx-spec" id="cx-spec" data-cx-spec>
  <div class="cx-shell">
    <div class="cx-spec-bar">
      <div>
        <p class="cx-eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Brief for Cybertech', 'vi' => 'Brief cho Cybertech' ) ) ); ?></p>
        <h2 class="cx-h2" style="font-size:28px"><?php echo esc_html( aef_t( array( 'en' => 'Apply Brand 9.9 on your IA — do not copy demo facts', 'vi' => 'Áp Brand 9.9 lên IA của bạn — không copy số liệu demo' ) ) ); ?></h2>
      </div>
      <button type="button" data-cx-spec-toggle aria-expanded="false"><?php echo esc_html( aef_t( array( 'en' => 'Open table', 'vi' => 'Mở bảng' ) ) ); ?></button>
    </div>
    <div class="cx-spec-body">
      <table>
        <thead>
          <tr>
            <th><?php echo esc_html( aef_t( array( 'en' => 'Your Figma Make demo', 'vi' => 'Demo Figma Make' ) ) ); ?></th>
            <th><?php echo esc_html( aef_t( array( 'en' => 'This reference (use this)', 'vi' => 'Bản này (làm theo đây)' ) ) ); ?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Lockup WEF → C4IR → UBND → AEF, pill kính mờ</td>
            <td>Trái → phải <b>AEF – UBND – C4IR</b>. C4IR = cao AEF. UBND = 2× AEF. Không WEF trên KV tổng (BG slide 17 + rule WEF).</td>
          </tr>
          <tr>
            <td>Space Grotesk + Be Vietnam Pro</td>
            <td>Một họ: <b>Archivo</b>. Phân cấp bằng weight, không thêm display font.</td>
          </tr>
          <tr>
            <td>Đỏ #FC0303 · nền tối #031d4a</td>
            <td>Đỏ quốc kỳ <b>#FF0000</b>. Xanh tin cậy <b>#05092F</b>. Xanh phát triển #085CEF. Nhấn #97DAFF. Xám #F2F2F2.</td>
          </tr>
          <tr>
            <td>GEM Center · 3.000 lãnh đạo · 50+ quốc gia · Schwab / Pichai</td>
            <td>Thiskyhall, Sala. ~2.000 đại biểu. 15 phiên ngày 27/10. Không bịa diễn giả, không bịa số quốc gia.</td>
          </tr>
          <tr>
            <td>Badge “Đồng tổ chức WEF” trên cả ngày 27–28 · footer UBND–WEF–C4IR</td>
            <td>WEF chỉ trên phiên 27–28 thật sự làm chung (sau khi chốt). Chrome tổng: 3 chủ thể nhà nước.</td>
          </tr>
          <tr>
            <td>Form đăng ký trên aef.vn</td>
            <td>aef.vn không thu PII. CTA “Đăng ký” → how-to-register / invite.aef.vn.</td>
          </tr>
          <tr>
            <td>Header 72px, shell 1440, countdown, CTA nổi, dải chủ đề tách cột</td>
            <td>Giữ IA và nhịp này. Đó là phần nên lấy từ demo.</td>
          </tr>
          <tr>
            <td>Unsplash generic</td>
            <td>Ảnh KV / Thiskyhall / thành phố có quyền sử dụng. Logo không kéo giãn, không invert lung tung.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<footer class="cx-foot">
  <div class="cx-shell">
    <div class="cx-foot-grid">
      <div>
        <img src="<?php echo esc_url( $aef_w ); ?>" alt="AEF 2026" width="160" height="48">
        <p><?php echo esc_html( $venue ); ?><br><?php echo esc_html( $week ); ?></p>
        <div class="cx-foot-lock">
          <img src="<?php echo esc_url( $aef_w ); ?>" alt="">
          <img class="seal" src="<?php echo esc_url( $ubnd ); ?>" alt="">
          <img src="<?php echo esc_url( $c4ir_d ); ?>" alt="">
        </div>
      </div>
      <div>
        <p><b><?php echo esc_html( $host1_n ); ?></b><br><?php echo esc_html( $host1_r ); ?></p>
        <p><b><?php echo esc_html( $host2_n ); ?></b><br><?php echo esc_html( $host2_r ); ?></p>
        <p><b><?php echo esc_html( $host3_n ); ?></b><br><?php echo esc_html( $host3_r ); ?></p>
      </div>
      <div>
        <p><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'About', 'vi' => 'Giới thiệu' ) ) ); ?></a></p>
        <p><a href="<?php echo esc_url( home_url( '/programme/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ) ); ?></a></p>
        <p><a href="<?php echo esc_url( $reg ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'How to attend', 'vi' => 'Cách tham dự' ) ) ); ?></a></p>
        <p><a href="<?php echo esc_url( $live ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Current live homepage', 'vi' => 'Trang chủ đang chạy' ) ) ); ?></a></p>
      </div>
    </div>
    <p class="cx-copyr"><?php echo esc_html( aef_t( array(
		'en' => '© 2026 Autumn Economic Forum. People’s Committee of Ho Chi Minh City · HCMC C4IR. Reference layout for design review.',
		'vi' => '© 2026 Diễn đàn Kinh tế Mùa thu. UBND Thành phố Hồ Chí Minh · HCMC C4IR. Bản layout tham chiếu để góp ý thiết kế.',
	) ) ); ?></p>
  </div>
</footer>

<div class="cx-float" data-cx-float>
  <a class="cx-cta" href="#chuong-trinh"><?php echo esc_html( aef_copy( 'home_hero_cta1' ) ); ?></a>
  <a class="cx-cta cx-cta-red" href="<?php echo esc_url( $reg ); ?>"><?php echo esc_html( aef_copy( 'home_hero_cta2' ) ); ?></a>
</div>
<script src="<?php echo esc_url( $js ); ?>"></script>
</body>
</html>
