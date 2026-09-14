<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aef_render_home_block( $id ) {
	if ( ! aef_block_on( $id ) ) {
		return;
	}
	$fn = 'aef_home_block_' . $id;
	if ( function_exists( $fn ) ) {
		$fn();
	}
}

function aef_home_bg_url( $key, $fallback = '' ) {
	if ( function_exists( 'aef_copy_media' ) ) {
		return (string) aef_copy_media( $key, $fallback );
	}
	return $fallback;
}

function aef_home_photo_class( $key, $fallback = '' ) {
	return aef_home_bg_url( $key, $fallback ) ? ' has-photo' : '';
}

function aef_home_bg_div( $key, $fallback = '' ) {
	$url = aef_home_bg_url( $key, $fallback );
	if ( '' === $url ) {
		return;
	}
	echo '<div class="blk-photo" style="background-image:url(\'' . esc_url( $url ) . '\')"></div>';
}

function aef_home_block_hero() {
	$s     = aef_settings();
	$theme = aef_t( array( 'vi' => $s['theme_vi'], 'en' => $s['theme_en'] ) );
	$pos   = aef_t( array(
		'en' => ! empty( $s['positioning_en'] ) ? $s['positioning_en'] : 'The Convergence Of New Global Growth Engines',
		'vi' => ! empty( $s['positioning_vi'] ) ? $s['positioning_vi'] : 'Sự hội tụ của các cực tăng trưởng mới toàn cầu',
	) );
	$year_digits = preg_replace( '/\D/', '', isset( $s['year'] ) ? $s['year'] : '2026' );
	if ( strlen( $year_digits ) < 4 ) {
		$year_digits = '2026';
	}
	$h_lines = function_exists( 'aef_stack_lines' ) ? aef_stack_lines( $pos ) : array( $pos );
	$city    = aef_t( array( 'vi' => $s['city_vi'], 'en' => $s['city_en'] ) );
	if ( '' === trim( (string) $city ) ) {
		$city = aef_t( array( 'en' => 'Ho Chi Minh City', 'vi' => 'Thành phố Hồ Chí Minh' ) );
	}
	$hero_bg = function_exists( 'aef_copy_media' )
		? aef_copy_media( 'home_hero_bg_id', aef_img( 'visual/collaboration-roads.jpg' ) )
		: aef_img( 'visual/collaboration-roads.jpg' );
	?>
<section class="hero on-dark">
  <div class="hero-photo" style="background-image:url('<?php echo esc_url( $hero_bg ); ?>')"></div>
  <?php aef_home_hero_fx_layer(); ?>
  <div class="shell">
    <div class="hero-lockup">
      <img class="hero-aef" src="<?php echo esc_url( aef_logo( 'aef-logo-mono-white.svg' ) ); ?>" alt="AEF 2026" width="200" height="80">
      <img class="hero-seal" src="<?php echo esc_url( aef_logo( 'ubnd-kv.png' ) ); ?>" alt="<?php echo esc_attr( aef_t( array( 'en' => "People's Committee of Ho Chi Minh City", 'vi' => 'Ủy ban nhân dân Thành phố Hồ Chí Minh' ) ) ); ?>" width="120" height="88">
      <img class="hero-c4ir" src="<?php echo esc_url( aef_c4ir_mark( true ) ); ?>" alt="<?php echo esc_attr( aef_t( array( 'en' => 'Viet Nam Centre for the Fourth Industrial Revolution', 'vi' => 'Trung tâm C4IR Việt Nam' ) ) ); ?>" width="190" height="105">
    </div>
    <div class="hero-copy">
    <p class="hero-kicker"><?php echo esc_html( aef_t( array(
		'en' => 'Autumn Economic Forum 2026 · Ho Chi Minh City',
		'vi' => 'Diễn đàn Kinh tế Mùa thu 2026 · Thành phố Hồ Chí Minh',
	) ) ); ?></p>
    <div class="hero-mast">
      <div class="hero-year" aria-hidden="true"><b><?php echo esc_html( substr( $year_digits, 0, 2 ) ); ?></b><b><?php echo esc_html( substr( $year_digits, 2, 2 ) ); ?></b></div>
      <div class="hero-titles">
        <h1 class="hero-headline"><?php foreach ( $h_lines as $line ) : ?><span><?php echo esc_html( $line ); ?></span><?php endforeach; ?></h1>
        <?php if ( $theme ) : ?>
        <p class="hero-theme"><small><?php echo esc_html( aef_t( array( 'en' => 'Theme', 'vi' => 'Chủ đề' ) ) ); ?></small><b><?php echo esc_html( $theme ); ?></b></p>
        <?php endif; ?>
      </div>
    </div>
    <?php if ( aef_has_copy( 'home_hero_lead' ) ) : ?>
    <p class="hero-lead"><?php echo esc_html( aef_copy( 'home_hero_lead' ) ); ?></p>
    <?php endif; ?>
    <div class="hero-cta-block">
    <div class="hmeta">
      <div><small><?php echo esc_html( aef_copy( 'home_meta_week' ) ); ?></small><b><?php echo esc_html( $s['week_dates'] ); ?></b></div>
      <div><small><?php echo esc_html( aef_copy( 'home_meta_main' ) ); ?></small><b><?php echo esc_html( $s['main_dates'] ); ?></b></div>
      <div><small><?php echo esc_html( aef_copy( 'home_meta_city' ) ); ?></small><b><?php echo esc_html( $city ); ?></b></div>
    </div>
    <?php if ( aef_has_copy( 'home_hero_cta1' ) || aef_has_copy( 'home_hero_cta2' ) ) : ?>
    <div class="hact">
      <?php if ( aef_has_copy( 'home_hero_cta1' ) ) : ?>
      <a class="btn btn-p" href="<?php echo esc_url( home_url( '/programme/' ) ); ?>"><?php echo esc_html( aef_copy( 'home_hero_cta1' ) ); ?></a>
      <?php endif; ?>
      <?php if ( aef_has_copy( 'home_hero_cta2' ) ) : ?>
      <a class="btn btn-g" href="<?php echo esc_url( aef_register_url() ); ?>"><?php echo esc_html( aef_copy( 'home_hero_cta2' ) ); ?></a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php
	$target = function_exists( 'aef_coming' ) && aef_coming( 'coming_target' )
		? aef_coming( 'coming_target' )
		: '2026-10-27T08:00:00+07:00';
	?>
    <p class="hero-count-l"><?php echo esc_html( aef_t( array( 'en' => 'Countdown to the main Forum', 'vi' => 'Đếm ngược đến khai mạc Diễn đàn chính' ) ) ); ?></p>
    <div class="hero-count" data-cx-count data-target="<?php echo esc_attr( $target ); ?>">
      <div><b data-u="d">—</b><span><?php echo esc_html( aef_t( array( 'en' => 'Days', 'vi' => 'Ngày' ) ) ); ?></span></div>
      <div><b data-u="h">—</b><span><?php echo esc_html( aef_t( array( 'en' => 'Hours', 'vi' => 'Giờ' ) ) ); ?></span></div>
      <div><b data-u="m">—</b><span><?php echo esc_html( aef_t( array( 'en' => 'Minutes', 'vi' => 'Phút' ) ) ); ?></span></div>
      <div><b data-u="s">—</b><span><?php echo esc_html( aef_t( array( 'en' => 'Seconds', 'vi' => 'Giây' ) ) ); ?></span></div>
    </div>
    <script>
    (function(){
      var box=document.querySelector("[data-cx-count]");
      if(!box) return;
      var raw=(box.getAttribute("data-target")||"").replace(/\s/g,"");
      var end=Date.parse(raw);
      if(isNaN(end)){
        var p=raw.match(/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})([+-]\d{2}):?(\d{2})$/);
        if(p){
          end=Date.UTC(+p[1],+p[2]-1,+p[3],+p[4]-(+p[7]),+p[5]-(p[7].indexOf("-")===0?-+p[8]:+p[8]),+p[6]);
        }
      }
      if(!end||isNaN(end)) return;
      function pad(n){return n<10?"0"+n:String(n);}
      function tick(){
        var left=Math.max(0,end-Date.now()), s=Math.floor(left/1000);
        var d=Math.floor(s/86400); s-=d*86400;
        var h=Math.floor(s/3600); s-=h*3600;
        var m=Math.floor(s/60); s-=m*60;
        var map={d:String(d),h:pad(h),m:pad(m),s:pad(s)};
        var els=box.querySelectorAll("[data-u]");
        for(var i=0;i<els.length;i++){
          var k=els[i].getAttribute("data-u");
          if(k&&map[k]!=null) els[i].textContent=map[k];
        }
      }
      tick();
      setInterval(tick,1000);
    })();
    </script>
    </div>
    </div>
  </div>
</section>
	<?php
}

function aef_home_hero_fx_layer() {
	$slug = function_exists( 'aef_hero_fx' ) ? aef_hero_fx() : '';
	if ( ! $slug ) {
		return;
	}
	echo '<div class="hero-fx" data-fx="' . esc_attr( $slug ) . '" aria-hidden="true">';
	if ( 'rise' === $slug ) {
		?>
    <svg viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" focusable="false">
      <defs>
        <linearGradient id="aefRiseWash" gradientUnits="userSpaceOnUse" x1="40" y1="900" x2="1400" y2="40">
          <stop offset="0" stop-color="#085CEF" stop-opacity="0"/>
          <stop offset=".32" stop-color="#97DAFF" stop-opacity=".16"/>
          <stop offset=".62" stop-color="#ffffff" stop-opacity=".42"/>
          <stop offset="1" stop-color="#97DAFF" stop-opacity="0"/>
        </linearGradient>
      </defs>
      <path class="fx-rise-wash" d="M-80 960 C 280 780, 820 390, 1560 -60"/>
      <path class="fx-rise-band" d="M-80 960 C 280 780, 820 390, 1560 -60"/>
      <path class="fx-rise-core" d="M-80 960 C 280 780, 820 390, 1560 -60"/>
    </svg>
    <span class="fx-rise-flare"></span>
		<?php
	}
	echo '</div>';
}

function aef_home_block_intro() {
	$title   = trim( (string) aef_copy( 'home_intro_title' ) );
	$eyebrow = trim( (string) aef_copy( 'home_intro_eyebrow' ) );
	$lead    = trim( (string) aef_copy( 'home_intro_lead' ) );
	if ( '' === $title && '' === $lead ) {
		return;
	}
	$intro_bg = function_exists( 'aef_copy_media' )
		? aef_copy_media( 'home_intro_bg_id', aef_img( 'visual/hcmc-dusk.jpg' ) )
		: aef_img( 'visual/hcmc-dusk.jpg' );
	?>
<section class="blk intro-strip on-dark">
  <div class="intro-photo" style="background-image:url('<?php echo esc_url( $intro_bg ); ?>')"></div>
  <div class="shell intro-manifesto rv">
    <div class="intro-verbal">
      <?php if ( $eyebrow ) : ?>
      <p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
      <?php endif; ?>
      <?php if ( $title ) : ?>
      <?php $intro_lines = function_exists( 'aef_stack_lines' ) ? aef_stack_lines( $title ) : array( $title ); ?>
      <h2 class="intro-title"><?php foreach ( $intro_lines as $line ) : ?><span><?php echo esc_html( $line ); ?></span><?php endforeach; ?></h2>
      <?php endif; ?>
      <?php if ( $lead ) : ?>
      <div class="intro-copy">
        <?php echo aef_paras_html( $lead ); ?>
      </div>
      <?php endif; ?>
      <blockquote class="pull-quote">
        <?php echo esc_html( aef_t( array(
			'en' => 'From responding to volatility to proactively building partnerships, trust and shared solutions for new growth engines.',
			'vi' => 'Từ ứng phó với biến động sang chủ động kiến tạo quan hệ đối tác, xây dựng lòng tin và cùng phát triển giải pháp cho các động lực tăng trưởng mới.',
		) ) ); ?>
        <small><?php echo esc_html( aef_t( array( 'en' => 'AEF 2026 theme', 'vi' => 'Chủ đề AEF 2026' ) ) ); ?></small>
      </blockquote>
    </div>
  </div>
</section>
	<?php
}

function aef_home_block_figures() {
	$title = trim( (string) aef_copy( 'home_figures_title' ) );
	$items = array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$n = trim( (string) aef_copy( 'home_fig_' . $i . '_n' ) );
		$l = trim( (string) aef_copy( 'home_fig_' . $i ) );
		if ( '' === $n && '' === $l ) {
			continue;
		}
		$items[] = array( $n, $l );
	}
	if ( ! $items ) {
		return;
	}
	?>
<section class="home-figures-strip on-dark">
  <div class="shell">
    <div class="stats home-figures-grid">
      <?php foreach ( $items as $item ) : ?>
      <div class="stat rv"><b><?php echo esc_html( $item[0] ); ?></b><span><?php echo esc_html( $item[1] ); ?></span></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
	<?php
}

function aef_home_block_theme() {
	$theme_title   = trim( (string) aef_copy( 'home_theme_title' ) );
	$theme_eyebrow = trim( (string) aef_copy( 'home_theme_eyebrow' ) );
	$theme_lead    = trim( (string) aef_copy( 'home_theme_lead' ) );
	$pillars_title = trim( (string) aef_copy( 'home_pillars_title' ) );
	$pillars_lead  = trim( (string) aef_copy( 'home_pillars_lead' ) );
	$pillars_cta   = trim( (string) aef_copy( 'home_pillars_cta' ) );
	if ( '' === $theme_lead ) {
		$s          = aef_settings();
		$theme_lead = aef_t( array( 'vi' => $s['theme_lead_vi'], 'en' => $s['theme_lead_en'] ) );
	}
	$s          = function_exists( 'aef_settings' ) ? aef_settings() : array();
	$theme_en   = isset( $s['theme_en'] ) ? trim( (string) $s['theme_en'] ) : 'Collaboration in a New Era';
	$theme_vi   = isset( $s['theme_vi'] ) ? trim( (string) $s['theme_vi'] ) : 'Tinh thần hợp tác trong kỷ nguyên mới';
	$other      = aef_lang() === 'vi' ? $theme_en : $theme_vi;
	$points     = array(
		array(
			'en'  => 'Shifts in the global economic model',
			'vi'  => 'Chuyển dịch mô hình kinh tế toàn cầu',
			'en2' => 'Lessons from economic restructuring by nations and megacities; repositioning Viet Nam and ASEAN in global value chains.',
			'vi2' => 'Kinh nghiệm tái cấu trúc nền kinh tế của các quốc gia và các siêu đô thị; định vị Việt Nam – ASEAN trong chuỗi giá trị toàn cầu.',
		),
		array(
			'en'  => 'Institutions, finance and strategic technologies',
			'vi'  => 'Thể chế, tài chính và công nghệ chiến lược',
			'en2' => 'Institutional reform, unlocking international capital, digital economy policy and strategic technologies.',
			'vi2' => 'Kinh nghiệm thúc đẩy thể chế, khơi thông dòng vốn quốc tế, khung chính sách kinh tế số và các công nghệ chiến lược.',
		),
		array(
			'en'  => 'International cooperation for a new growth model',
			'vi'  => 'Hợp tác quốc tế vì mô hình tăng trưởng mới',
			'en2' => 'Science and technology cooperation, and collaboration among firms and young global business leaders.',
			'vi2' => 'Hợp tác khoa học – công nghệ trong các ngành phục vụ mô hình tăng trưởng mới; hợp tác của cộng đồng doanh nghiệp và lãnh đạo doanh nghiệp trẻ toàn cầu.',
		),
	);
	?>
<?php if ( $theme_title || $theme_lead ) : ?>
<section class="home-theme-band on-dark<?php echo esc_attr( aef_home_photo_class( 'home_theme_bg_id' ) ); ?>">
  <?php aef_home_bg_div( 'home_theme_bg_id' ); ?>
  <div class="shell home-theme-lock rv">
    <p class="home-theme-kicker"><?php echo esc_html( $theme_eyebrow ? $theme_eyebrow : aef_t( array( 'en' => '2026 theme', 'vi' => 'Chủ đề 2026' ) ) ); ?></p>
    <?php if ( $theme_title ) : ?>
    <?php echo function_exists( 'aef_title_lines_html' ) ? aef_title_lines_html( $theme_title, 'h2', 'home-theme-title' ) : ( '<h2 class="home-theme-title">' . esc_html( $theme_title ) . '</h2>' ); ?>
    <?php endif; ?>
    <?php if ( $other && $other !== $theme_title ) : ?>
    <p class="home-theme-en"><?php echo esc_html( $other ); ?></p>
    <?php endif; ?>
    <span class="home-theme-rule" aria-hidden="true"></span>
    <?php if ( $theme_lead ) : ?>
    <div class="home-theme-body">
      <?php echo aef_paras_html( $theme_lead ); ?>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
<section class="topics-preview pillars-dark on-dark">
  <div class="shell theme-split rv">
    <div class="theme-copy">
      <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'The guiding framework', 'vi' => 'Khung tư duy xuyên suốt' ) ) ); ?></p>
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Four content pillars', 'vi' => 'Bốn trụ cột nội dung' ) ) ); ?></h2>
      <p class="lead"><?php echo esc_html( aef_t( array(
		'en' => 'The four pillars are not organised as separate sessions; they are woven into the framing and direction of every session, linking the global context, Viet Nam’s development priorities and the concrete cooperation outcomes the Forum pursues.',
		'vi' => 'Bốn trụ cột không tổ chức thành các phiên riêng biệt mà được lồng ghép vào cách đặt vấn đề và định hướng thảo luận của từng phiên, bảo đảm gắn kết giữa bối cảnh toàn cầu, yêu cầu phát triển của Việt Nam và các kết quả hợp tác cụ thể.',
	) ) ); ?></p>
    </div>
    <div class="pillars">
    <?php
	$html_pillars = array(
		array(
			'slug' => 'megacity',
			'n'    => '01',
			'title' => array( 'en' => 'The role of megacities', 'vi' => 'Vai trò của các siêu đô thị' ),
			'card'  => array(
				'en' => 'Megacities as coordinating hubs for capital, technology and innovation ecosystems; lessons in restructuring urban economies for a new era.',
				'vi' => 'Siêu đô thị như trung tâm điều phối dòng vốn, công nghệ và hệ sinh thái đổi mới sáng tạo; kinh nghiệm tái cấu trúc kinh tế đô thị trong kỷ nguyên mới.',
			),
		),
		array(
			'slug' => 'technology',
			'n'    => '02',
			'title' => array( 'en' => 'Breakthrough technologies and innovation ecosystems', 'vi' => 'Công nghệ đột phá và hệ sinh thái đổi mới sáng tạo' ),
			'card'  => array(
				'en' => 'Artificial intelligence, quantum technology, smart manufacturing and strategic technologies reshaping national competitiveness.',
				'vi' => 'Trí tuệ nhân tạo, công nghệ lượng tử, sản xuất thông minh và các công nghệ chiến lược tái định hình lợi thế cạnh tranh quốc gia.',
			),
		),
		array(
			'slug' => 'cooperation',
			'n'    => '03',
			'title' => array( 'en' => 'Collaboration models in the new era', 'vi' => 'Các mô hình hợp tác trong kỷ nguyên mới' ),
			'card'  => array(
				'en' => 'New frameworks for cooperation among nations, cities, businesses and international organisations to coordinate and mobilise resources across borders.',
				'vi' => 'Khuôn khổ hợp tác mới giữa quốc gia, địa phương, doanh nghiệp và tổ chức quốc tế nhằm điều phối, huy động nguồn lực xuyên biên giới.',
			),
		),
		array(
			'slug' => 'private-sector',
			'n'    => '04',
			'title' => array( 'en' => 'The pioneering role of the private sector', 'vi' => 'Vai trò tiên phong của khu vực tư nhân' ),
			'card'  => array(
				'en' => 'Enterprises, corporations, financial institutions and young global business leaders driving growth and innovation.',
				'vi' => 'Doanh nghiệp, tập đoàn, định chế tài chính và lãnh đạo doanh nghiệp trẻ toàn cầu dẫn dắt tăng trưởng và đổi mới sáng tạo.',
			),
		),
	);
	foreach ( $html_pillars as $p ) :
		?>
      <a class="pillar" href="<?php echo esc_url( home_url( '/topics/#pillar-' . $p['slug'] ) ); ?>">
        <span class="num"><?php echo esc_html( aef_t( array( 'en' => 'Pillar', 'vi' => 'Trụ cột' ) ) . ' ' . $p['n'] ); ?></span>
        <h3><?php echo esc_html( aef_t( $p['title'] ) ); ?></h3>
        <p><?php echo esc_html( aef_t( $p['card'] ) ); ?></p>
      </a>
    <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="home-streams" id="nhom-phien">
  <div class="shell rv">
    <div class="theme-copy">
      <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Programme logic', 'vi' => 'Mạch triển khai chương trình' ) ) ); ?></p>
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Three content streams of the thematic sessions', 'vi' => 'Ba nhóm nội dung của các phiên chuyên đề' ) ) ); ?></h2>
      <p class="lead"><?php echo esc_html( aef_t( array(
		'en' => 'Building on the four pillars, the thematic sessions on 27 October are organised into three content streams that follow the flow of the programme.',
		'vi' => 'Trên nền khung tư duy bốn trụ cột, các phiên chuyên đề ngày 27/10 được sắp xếp thành ba nhóm nội dung theo mạch triển khai của chương trình.',
	) ) ); ?></p>
    </div>
    <div class="streams">
      <?php
		$romans = array( 'i', 'ii', 'iii' );
		foreach ( $points as $i => $pt ) :
			?>
      <article class="stream">
        <div class="num"><?php echo esc_html( $romans[ $i ] ); ?></div>
        <h3><?php echo esc_html( aef_t( array( 'en' => $pt['en'], 'vi' => $pt['vi'] ) ) ); ?></h3>
        <p><?php echo esc_html( aef_t( array( 'en' => $pt['en2'], 'vi' => $pt['vi2'] ) ) ); ?></p>
      </article>
		<?php endforeach; ?>
    </div>
  </div>
</section>
	<?php
}

function aef_home_block_hosts() {
	$s        = aef_settings();
	$eyebrow  = trim( (string) aef_copy( 'home_hosts_eyebrow' ) );
	$title    = trim( (string) aef_copy( 'home_hosts_title' ) );
	$lead     = trim( (string) aef_copy( 'home_hosts_lead' ) );
	$host3_r  = trim( (string) aef_copy( 'home_hosts_3_role' ) );
	$host3_n  = trim( (string) aef_copy( 'home_hosts_3_name' ) );
	$host4_r  = trim( (string) aef_copy( 'home_hosts_4_role' ) );
	$host4_n  = trim( (string) aef_copy( 'home_hosts_4_name' ) );
	?>
<section class="inst-strip<?php echo esc_attr( aef_home_photo_class( 'home_hosts_bg_id' ) ); ?>">
  <?php aef_home_bg_div( 'home_hosts_bg_id' ); ?>
  <div class="shell">
    <?php if ( $eyebrow || $title || $lead ) : ?>
    <div class="hd rv"><div>
      <?php if ( $eyebrow ) : ?>
      <p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
      <?php endif; ?>
      <?php if ( $title ) : ?>
      <h2><?php echo esc_html( $title ); ?></h2>
      <?php endif; ?>
    </div>
    <?php if ( $lead ) : ?>
    <p class="lead"><?php echo esc_html( $lead ); ?></p>
    <?php endif; ?></div>
    <?php endif; ?>
    <?php
	$show_h4 = ( $host4_r || $host4_n ) && ! ( function_exists( 'aef_marks_wef' ) && ( aef_marks_wef( $host4_n ) || aef_marks_wef( $host4_r ) ) );
	?>
    <div class="inst-grid<?php echo $show_h4 ? '' : ' inst-grid-3'; ?>">
    <div class="inst rv">
      <small><?php echo esc_html( aef_t( array( 'vi' => $s['host_1_role_vi'], 'en' => $s['host_1_role_en'] ) ) ); ?></small>
      <div class="inst-mark inst-mark-text">VN</div>
      <b><?php echo esc_html( aef_t( array( 'vi' => $s['host_1_name_vi'], 'en' => $s['host_1_name_en'] ) ) ); ?></b>
    </div>
    <div class="inst rv">
      <small><?php echo esc_html( aef_t( array( 'vi' => $s['host_2_role_vi'], 'en' => $s['host_2_role_en'] ) ) ); ?></small>
      <img src="<?php echo esc_url( aef_logo( 'ubnd.png' ) ); ?>" alt="<?php echo esc_attr( $s['host_2_name_en'] ); ?>">
      <b><?php echo esc_html( aef_t( array( 'vi' => $s['host_2_name_vi'], 'en' => $s['host_2_name_en'] ) ) ); ?></b>
    </div>
    <div class="inst rv">
      <small><?php echo esc_html( $host3_r ); ?></small>
      <img class="inst-c4ir" src="<?php echo esc_url( aef_c4ir_mark() ); ?>" alt="<?php echo esc_attr( $host3_n ); ?>" width="190" height="105">
      <b><?php echo esc_html( $host3_n ); ?></b>
    </div>
    <?php if ( $show_h4 ) : ?>
    <div class="inst rv">
      <small><?php echo esc_html( $host4_r ); ?></small>
      <b><?php echo esc_html( $host4_n ); ?></b>
    </div>
    <?php endif; ?>
    </div>
  </div>
</section>
	<?php
}

function aef_home_block_week() {
	$days = get_terms( array( 'taxonomy' => 'aef_day', 'hide_empty' => false, 'orderby' => 'term_id' ) );
	if ( is_wp_error( $days ) ) {
		$days = array();
	}
	?>
<section class="blk<?php echo esc_attr( aef_home_photo_class( 'home_week_bg_id' ) ); ?>">
  <?php aef_home_bg_div( 'home_week_bg_id' ); ?>
  <div class="shell">
    <div class="hd rv"><div>
      <p class="eyebrow"><?php echo esc_html( aef_copy( 'home_week_eyebrow' ) ); ?></p>
      <h2><?php echo esc_html( aef_copy( 'home_week_title' ) ); ?></h2>
    </div>
    <p class="lead"><?php echo esc_html( aef_copy( 'home_week_lead' ) ); ?></p></div>
    <div class="day-cards">
    <?php
	$i = 0;
	foreach ( $days as $day ) :
		$i++;
		$when = get_term_meta( $day->term_id, 'when', true );
		$name = aef_lang() === 'en' && get_term_meta( $day->term_id, 'name_en', true ) ? get_term_meta( $day->term_id, 'name_en', true ) : $day->name;
		$note = aef_lang() === 'en' && get_term_meta( $day->term_id, 'note_en', true ) ? get_term_meta( $day->term_id, 'note_en', true ) : $day->description;
		?>
      <a class="day-card rv" href="<?php echo esc_url( home_url( '/programme/' ) . '#day-' . $day->slug ); ?>">
        <small><?php
		$layer = array(
			'pre'        => array( 'en' => 'Monday · Pre-Forum', 'vi' => 'Thứ Hai · Tiền diễn đàn' ),
			'thematic'   => array( 'en' => 'Tuesday · Main Forum — Day 1', 'vi' => 'Thứ Ba · Diễn đàn chính — Ngày 1' ),
			'high-level' => array( 'en' => 'Wednesday · Main Forum — Day 2', 'vi' => 'Thứ Tư · Diễn đàn chính — Ngày 2' ),
			'side'       => array( 'en' => 'Thursday · Post-Forum', 'vi' => 'Thứ Năm · Hậu diễn đàn' ),
		);
		echo esc_html( isset( $layer[ $day->slug ] ) ? aef_t( $layer[ $day->slug ] ) : aef_t( array( 'en' => 'Forum week', 'vi' => 'Tuần Diễn đàn' ) ) );
		?></small>
        <time><?php echo esc_html( $when ); ?></time>
        <h3><?php echo esc_html( $name ); ?></h3>
        <p><?php echo esc_html( $note ); ?></p>
        <span><?php echo esc_html( aef_t( array( 'en' => 'Open this day', 'vi' => 'Xem ngày này' ) ) ); ?> →</span>
      </a>
    <?php endforeach; ?>
    </div>
    <div style="margin-top:34px"><a class="btn btn-b" href="<?php echo esc_url( home_url( '/programme/' ) ); ?>"><?php echo esc_html( aef_copy( 'home_week_cta' ) ); ?></a></div>
  </div>
</section>
	<?php
}

function aef_home_tl_card( $href, $time, $dur, $name, $desc, $key = false, $live = false ) {
	?>
	<a class="tl-item<?php echo $key ? ' key' : ''; ?>" href="<?php echo esc_url( $href ); ?>">
	  <span class="time"><span><?php echo esc_html( $time ); ?></span><i><?php echo esc_html( $dur ); ?></i></span>
	  <span class="name"><?php echo esc_html( $name ); ?></span>
	  <span class="desc"><?php echo esc_html( $desc ); ?></span>
	  <?php if ( $live ) : ?><span class="live"><?php echo esc_html( aef_t( array( 'en' => 'Live broadcast', 'vi' => 'Truyền hình trực tiếp' ) ) ); ?></span><?php endif; ?>
	  <span class="more"><?php echo esc_html( aef_t( array( 'en' => 'View details →', 'vi' => 'Xem chi tiết →' ) ) ); ?></span>
	</a>
	<?php
}

function aef_home_tl_session( $slug, $key = false, $live = false ) {
	$p = get_page_by_path( $slug, OBJECT, 'aef_session' );
	if ( ! $p || 'publish' !== $p->post_status ) {
		return;
	}
	$id   = $p->ID;
	$time = (string) aef_meta( $id, 'time' );
	$time = preg_replace( '/\s*[–\-]\s*/u', '–', $time );
	aef_home_tl_card(
		get_permalink( $id ),
		$time,
		function_exists( 'aef_session_duration_label' ) ? aef_session_duration_label( $id ) : '',
		aef_bilingual_title( $id ),
		wp_trim_words( aef_session_short( $id ), 18 ),
		$key,
		$live
	);
}

function aef_home_block_programme() {
	$title     = aef_copy( 'home_programme_title' );
	$overline  = trim( (string) aef_copy( 'home_programme_overline' ) );
	$prog_lead = trim( (string) aef_copy( 'home_programme_lead' ) );
	$prog_note = trim( (string) aef_copy( 'home_programme_note' ) );
	$prog_cta  = trim( (string) aef_copy( 'home_programme_cta' ) );
	if ( ! $overline ) {
		$overline = aef_t( array( 'en' => 'Programme framework', 'vi' => 'Khung chương trình' ) );
	}
	if ( ! $title || in_array( $title, array( 'The AEF 2026 programme', 'Chương trình AEF 2026' ), true ) ) {
		$title = aef_t( array( 'en' => 'Four days, one path of convergence', 'vi' => 'Bốn ngày, một mạch hội tụ' ) );
	}
	if ( ! $prog_lead ) {
		$prog_lead = aef_t( array(
			'en' => 'All activities are listed in chronological order. 27 October is devoted to thematic depth and innovation networking; 28 October to high-level strategic dialogue. Select an activity to see its content, speakers and duration.',
			'vi' => 'Các hoạt động được sắp xếp theo trình tự thời gian. Ngày 27/10 dành cho chiều sâu chuyên đề và kết nối đổi mới sáng tạo; ngày 28/10 là các phiên đối thoại chiến lược cấp cao. Chọn một hoạt động để xem nội dung, diễn giả và thời lượng.',
		) );
	}
	$aside = $prog_note || $prog_lead;
	?>
<section class="home-programme home-tl<?php echo esc_attr( aef_home_photo_class( 'home_programme_bg_id' ) ); ?>" id="chuong-trinh">
  <?php aef_home_bg_div( 'home_programme_bg_id' ); ?>
  <div class="shell">
    <div class="home-programme-head rv<?php echo $aside ? '' : ' solo'; ?>">
      <div>
        <p class="overline"><?php echo esc_html( $overline ); ?></p>
        <h2><?php echo aef_heading_html( $title ); ?></h2>
      </div>
      <div>
      <?php if ( $prog_lead ) : ?>
      <p class="home-programme-lead"><?php echo esc_html( $prog_lead ); ?></p>
      <?php endif; ?>
      <?php if ( $prog_note ) : ?>
      <p class="status-note"><i></i> <?php echo esc_html( $prog_note ); ?></p>
      <?php endif; ?>
      </div>
    </div>
    <?php
	$days = array(
		array(
			'd'    => '26',
			'hl'   => false,
			'lab'  => array( 'en' => 'Monday · Pre-Forum', 'vi' => 'Thứ Hai · Tiền diễn đàn' ),
			'tag'  => '',
			'rows' => array( 'dual-transition-conference', 'vietnam-india-future-tech', 'oid-2026', 'ceo-500-tea-connect' ),
		),
		array(
			'd'    => '27',
			'hl'   => true,
			'lab'  => array( 'en' => 'Tuesday · Main Forum — Day 1', 'vi' => 'Thứ Ba · Diễn đàn chính — Ngày 1' ),
			'tag'  => array( 'en' => 'Thematic & networking', 'vi' => 'Chuyên đề & kết nối' ),
			'rows' => array( '27-oct-opening', '_thematic', '_arena', 'official-reception', 'business-networking-dinner' ),
		),
		array(
			'd'    => '28',
			'hl'   => true,
			'lab'  => array( 'en' => 'Wednesday · Main Forum — Day 2', 'vi' => 'Thứ Tư · Diễn đàn chính — Ngày 2' ),
			'tag'  => array( 'en' => 'High-level dialogue', 'vi' => 'Đối thoại cấp cao' ),
			'rows' => array( 'high-level-plenary', 'pm-dialogue', 'ministerial-dialogue', 'gala-dinner' ),
		),
		array(
			'd'    => '29',
			'hl'   => false,
			'lab'  => array( 'en' => 'Thursday · Post-Forum', 'vi' => 'Thứ Năm · Hậu diễn đàn' ),
			'tag'  => '',
			'rows' => array( 'vietnam-israel-innovation-day', 'vietnam-china-investment', 'nordic-investment', 'field-visits', 'c4ir-network-meeting' ),
		),
	);
	$key_slugs  = array( 'ceo-500-tea-connect', 'high-level-plenary', 'pm-dialogue', 'official-reception', 'c4ir-network-meeting' );
	$live_slugs = array( 'high-level-plenary', 'pm-dialogue' );
	?>
    <div class="tl">
      <?php foreach ( $days as $day ) : ?>
      <div class="tl-day<?php echo ! empty( $day['hl'] ) ? ' hl' : ''; ?>">
        <div class="dot"></div>
        <header>
          <span class="d"><?php echo esc_html( $day['d'] ); ?>/10</span>
          <span class="t"><?php echo esc_html( aef_t( $day['lab'] ) ); ?></span>
          <?php if ( ! empty( $day['tag'] ) ) : ?><span class="tag"><?php echo esc_html( aef_t( $day['tag'] ) ); ?></span><?php endif; ?>
        </header>
        <?php if ( ! empty( $day['hl'] ) ) : ?><div class="pg-mainpanel"><span class="pg-mainlabel"><?php echo esc_html( aef_t( array( 'en' => 'Main Forum', 'vi' => 'Diễn đàn chính' ) ) ); ?></span><?php endif; ?>
        <div class="tl-items">
          <?php foreach ( $day['rows'] as $row ) : ?>
            <?php if ( '_thematic' === $row ) : ?>
              <?php aef_home_tl_card( home_url( '/programme/?view=thematic' ), '08:30–18:00', aef_t( array( 'en' => '3 rooms', 'vi' => '3 phòng' ) ), aef_t( array( 'en' => '15 parallel thematic sessions', 'vi' => '15 phiên thảo luận chuyên đề song song' ) ), aef_t( array( 'en' => 'Three thematic rooms; each session features 3–4 speakers and one moderator.', 'vi' => 'Ba phòng chuyên đề, mỗi phiên 3–4 diễn giả và 1 điều phối viên.' ) ), true ); ?>
            <?php elseif ( '_arena' === $row ) : ?>
              <?php aef_home_tl_card( home_url( '/programme/?view=arena' ), '08:30–17:30', '45′', aef_t( array( 'en' => 'Rising Star Arena — technology showcase', 'vi' => 'Rising Star Arena — trình diễn giải pháp công nghệ' ) ), aef_t( array( 'en' => 'Technology showcase at Thiskyhall, 45 minutes per slot. Presenting organisations: to be confirmed.', 'vi' => 'Trình diễn công nghệ tại Thiskyhall, mỗi lượt 45 phút. Đơn vị trình diễn: Đang xác nhận.' ) ) ); ?>
            <?php else : ?>
              <?php aef_home_tl_session( $row, in_array( $row, $key_slugs, true ), in_array( $row, $live_slugs, true ) ); ?>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <?php if ( ! empty( $day['hl'] ) ) : ?></div><?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="home-prog-links">
      <a href="<?php echo esc_url( home_url( '/programme/?view=thematic' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => '15 thematic sessions', 'vi' => '15 phiên chuyên đề' ) ) ); ?></a>
      <a href="<?php echo esc_url( home_url( '/programme/?view=arena' ) ); ?>">Rising Star Arena</a>
      <a href="<?php echo esc_url( home_url( '/programme/?view=side' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Side events', 'vi' => 'Bên lề' ) ) ); ?></a>
    </div>
    <?php if ( $prog_cta ) : ?>
    <a class="btn btn-g home-programme-cta" href="<?php echo esc_url( home_url( '/programme/' ) ); ?>"><?php echo esc_html( $prog_cta ); ?> →</a>
    <?php endif; ?>
  </div>
</section>
	<?php
	aef_home_rooms_teaser();
}

function aef_home_rooms_teaser() {
	$rooms = array(
		'1' => array(
			aef_t( array( 'en' => 'Room 01', 'vi' => 'Phòng 01' ) ),
			aef_t( array( 'en' => 'Value chains · AI · Quantum', 'vi' => 'Chuỗi giá trị · AI · Lượng tử' ) ),
		),
		'2' => array(
			aef_t( array( 'en' => 'Room 02', 'vi' => 'Phòng 02' ) ),
			aef_t( array( 'en' => 'Finance · Digital economy · Sovereignty', 'vi' => 'Tài chính · Kinh tế số · Tự chủ' ) ),
		),
		'3' => array(
			aef_t( array( 'en' => 'Room 03', 'vi' => 'Phòng 03' ) ),
			aef_t( array( 'en' => 'Manufacturing · Sustainability · Next generation', 'vi' => 'Sản xuất · Bền vững · Thế hệ mới' ) ),
		),
	);
	$q = new WP_Query(
		array(
			'post_type'      => 'aef_session',
			'posts_per_page' => 40,
			'post_status'    => 'publish',
			'tax_query'      => array( array( 'taxonomy' => 'aef_day', 'field' => 'slug', 'terms' => 'thematic' ) ),
			'orderby'        => 'meta_value',
			'meta_key'       => 'time',
			'order'          => 'ASC',
		)
	);
	$by = array( '1' => array(), '2' => array(), '3' => array() );
	while ( $q->have_posts() ) {
		$q->the_post();
		$id  = get_the_ID();
		$b   = function_exists( 'aef_prog_room_bucket' ) ? aef_prog_room_bucket( $id ) : '';
		if ( isset( $by[ $b ] ) ) {
			$by[ $b ][] = $id;
		}
	}
	wp_reset_postdata();
	?>
<section class="home-rooms on-dark" id="chuyen-de">
  <div class="shell">
    <div class="hd rv"><div>
      <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => '27 October · 08:30–18:00', 'vi' => 'Ngày 27/10 · 08:30–18:00' ) ) ); ?></p>
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Fifteen thematic sessions in three parallel rooms', 'vi' => 'Mười lăm phiên chuyên đề tại ba phòng song song' ) ) ); ?></h2>
    </div>
    <p class="lead"><?php echo esc_html( aef_t( array(
		'en' => 'Each session: one moderator and 3–4 panelists. Coordinating ministries are listed on the session page.',
		'vi' => 'Mỗi phiên: 1 điều phối viên và 3–4 diễn giả tọa đàm. Bộ, ngành phối hợp ghi trên trang phiên.',
	) ) ); ?></p></div>
    <div class="rooms-grid home-rooms-grid">
      <?php foreach ( $rooms as $rk => $lab ) : ?>
      <div class="room-col">
        <div class="room-col-h"><h3><?php echo esc_html( $lab[0] ); ?></h3><small><?php echo esc_html( $lab[1] ); ?></small></div>
        <?php foreach ( $by[ $rk ] as $sid ) : ?>
        <a class="agenda-card" href="<?php echo esc_url( get_permalink( $sid ) ); ?>">
          <time><?php echo esc_html( aef_meta( $sid, 'time' ) ); ?></time>
          <div><h3><?php echo esc_html( aef_bilingual_title( $sid ) ); ?></h3></div>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <a class="arena-band home-arena" href="<?php echo esc_url( home_url( '/programme/?view=arena' ) ); ?>">
      <div>
        <p class="eyebrow">Rising Star Arena</p>
        <h3><?php echo esc_html( aef_t( array( 'en' => 'Technology and innovation showcase', 'vi' => 'Trình diễn giải pháp công nghệ và đổi mới sáng tạo' ) ) ); ?></h3>
        <p><?php echo esc_html( aef_t( array(
			'en' => 'All day at Thiskyhall, 45 minutes per slot. Presenting organisations: to be confirmed.',
			'vi' => 'Cả ngày tại Thiskyhall, mỗi lượt 45 phút. Đơn vị trình diễn: Đang xác nhận.',
		) ) ); ?></p>
      </div>
      <span><?php echo esc_html( aef_t( array( 'en' => 'Open Rising Star Arena', 'vi' => 'Xem Rising Star Arena' ) ) ); ?> →</span>
    </a>
  </div>
</section>
	<?php
}

function aef_home_block_city() {
	$s     = aef_settings();
	$title = aef_copy( 'home_city_title' );
	if ( false !== strpos( $title, ',' ) ) {
		$title = preg_replace( '/,\s+/', ',<br>', $title, 1 );
	}
	?>
<section class="city-band why-city">
  <div class="city-band-photo" style="background-image:url('<?php echo esc_url( aef_home_bg_url( 'home_city_bg_id', aef_img( 'visual/hcmc-dusk.jpg' ) ) ); ?>')"></div>
  <div class="shell city-band-copy">
    <p class="eyebrow"><?php echo esc_html( aef_copy( 'home_city_eyebrow' ) ); ?></p>
    <h2><?php echo wp_kses( $title, array( 'br' => array() ) ); ?></h2>
    <p class="lead"><?php echo esc_html( aef_copy( 'home_city_lead' ) ); ?></p>
    <dl class="venue-facts">
      <div><dt><?php echo esc_html( aef_t( array( 'en' => 'Main Forum', 'vi' => 'Diễn đàn chính' ) ) ); ?></dt><dd>27–28/10/2026</dd></div>
      <div><dt><?php echo esc_html( aef_t( array( 'en' => 'Side events', 'vi' => 'Bên lề' ) ) ); ?></dt><dd>26–29/10/2026</dd></div>
      <div><dt><?php echo esc_html( aef_t( array( 'en' => 'Venue', 'vi' => 'Địa điểm' ) ) ); ?></dt><dd><?php echo esc_html( aef_t( array( 'vi' => $s['venue_vi'], 'en' => $s['venue_en'] ) ) ); ?></dd></div>
      <div><dt><?php echo esc_html( aef_t( array( 'en' => 'Host', 'vi' => 'Chủ trì' ) ) ); ?></dt><dd><?php echo esc_html( aef_t( array( 'vi' => $s['host_2_name_vi'], 'en' => $s['host_2_name_en'] ) ) ); ?></dd></div>
    </dl>
    <a class="btn btn-g" href="<?php echo esc_url( home_url( '/travel/' ) ); ?>"><?php echo esc_html( aef_copy( 'home_city_cta' ) ); ?></a>
    <small class="illu-credit"><?php echo esc_html( aef_t( array( 'en' => 'Reference image', 'vi' => 'Ảnh minh họa' ) ) ); ?></small>
  </div>
</section>
	<?php
}

function aef_home_block_outcomes() {
	$eyebrow = trim( (string) aef_copy( 'home_outcomes_eyebrow' ) );
	$title   = trim( (string) aef_copy( 'home_outcomes_title' ) );
	$lead    = trim( (string) aef_copy( 'home_outcomes_lead' ) );
	?>
<section class="blk<?php echo esc_attr( aef_home_photo_class( 'home_outcomes_bg_id' ) ); ?>">
  <?php aef_home_bg_div( 'home_outcomes_bg_id' ); ?>
  <div class="shell">
    <div class="hd rv"><div>
      <?php if ( $eyebrow ) : ?>
      <p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
      <?php endif; ?>
      <?php if ( $title ) : ?>
      <h2><?php echo aef_heading_html( $title ); ?></h2>
      <?php endif; ?>
    </div>
    <?php if ( $lead ) : ?>
    <p class="lead"><?php echo esc_html( $lead ); ?></p>
    <?php endif; ?></div>
    <div class="outcome-grid">
      <?php foreach ( aef_outcomes() as $o ) : ?>
        <article class="rv">
          <h3><?php echo esc_html( aef_t( $o[0] ) ); ?></h3>
          <p><?php echo esc_html( aef_t( $o[1] ) ); ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
	<?php
}

function aef_home_block_audience() {
	$eyebrow = trim( (string) aef_copy( 'home_audience_eyebrow' ) );
	$title   = trim( (string) aef_copy( 'home_audience_title' ) );
	$lead    = trim( (string) aef_copy( 'home_audience_lead' ) );
	?>
<section class="blk mist<?php echo esc_attr( aef_home_photo_class( 'home_audience_bg_id' ) ); ?>">
  <?php aef_home_bg_div( 'home_audience_bg_id' ); ?>
  <div class="shell">
    <div class="hd rv"><div>
      <?php if ( $eyebrow ) : ?>
      <p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
      <?php endif; ?>
      <?php if ( $title ) : ?>
      <h2><?php echo aef_heading_html( $title ); ?></h2>
      <?php endif; ?>
    </div>
    <?php if ( $lead ) : ?>
    <p class="lead"><?php echo esc_html( $lead ); ?></p>
    <?php endif; ?></div>
    <div class="audience-grid">
      <?php foreach ( aef_audiences() as $a ) : ?>
        <article class="rv">
          <h3><?php echo esc_html( aef_t( $a[0] ) ); ?></h3>
          <p><?php echo esc_html( aef_t( $a[1] ) ); ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
	<?php
}

function aef_home_block_edition() {
	$edition_cta = trim( (string) aef_copy( 'home_edition_cta' ) );
	?>
<section class="blk deep on-dark<?php echo esc_attr( aef_home_photo_class( 'home_edition_bg_id' ) ); ?>" style="padding:72px 0 0">
  <?php aef_home_bg_div( 'home_edition_bg_id' ); ?>
  <div class="shell">
    <div class="hd rv"><div>
      <p class="eyebrow"><?php echo esc_html( aef_copy( 'home_edition_eyebrow' ) ); ?></p>
      <h2><?php echo esc_html( aef_copy( 'home_edition_title' ) ); ?></h2>
    </div>
    <p class="lead"><?php echo esc_html( aef_copy( 'home_edition_lead' ) ); ?></p></div>
    <div class="stats">
      <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
      <div class="stat rv"><b><?php echo esc_html( aef_copy( 'home_stat_' . $i . '_n' ) ); ?></b><span><?php echo esc_html( aef_copy( 'home_stat_' . $i ) ); ?></span></div>
      <?php endfor; ?>
    </div>
  </div>
</section>
<section class="blk">
  <div class="shell">
    <div class="mosaic" style="margin-top:0">
      <figure class="shot w2 h2 rv"><img src="<?php echo esc_url( aef_img( 'plenary.jpg' ) ); ?>" alt=""><figcaption><?php echo esc_html( aef_t( array( 'en' => 'High-level plenary, Thiskyhall Sala', 'vi' => 'Phiên toàn thể cấp cao, Thiskyhall Sala' ) ) ); ?></figcaption></figure>
      <figure class="shot w2 rv"><img src="<?php echo esc_url( aef_img( 'pm.jpg' ) ); ?>" alt=""><figcaption><?php echo esc_html( aef_t( array( 'en' => 'High-level dialogue at a previous edition', 'vi' => 'Đối thoại cấp cao tại một kỳ trước' ) ) ); ?></figcaption></figure>
      <figure class="shot rv"><img src="<?php echo esc_url( aef_img( 'expo.jpg' ) ); ?>" alt=""><figcaption><?php echo esc_html( aef_t( array( 'en' => 'Solutions showcase', 'vi' => 'Khu trình diễn giải pháp' ) ) ); ?></figcaption></figure>
      <figure class="shot rv"><img src="<?php echo esc_url( aef_img( 'youth.jpg' ) ); ?>" alt=""><figcaption><?php echo esc_html( aef_t( array( 'en' => 'Youth talks', 'vi' => 'Đối thoại người trẻ' ) ) ); ?></figcaption></figure>
    </div>
    <?php if ( $edition_cta ) : ?>
    <div style="margin-top:30px"><a class="btn btn-b" href="<?php echo esc_url( home_url( '/editions/2025/' ) ); ?>"><?php echo esc_html( $edition_cta ); ?></a></div>
    <?php endif; ?>
  </div>
</section>
	<?php
}

function aef_home_block_speakers() {
	$eyebrow = trim( (string) aef_copy( 'home_speakers_eyebrow' ) );
	$title   = trim( (string) aef_copy( 'home_speakers_title' ) );
	$lead    = trim( (string) aef_copy( 'home_speakers_lead' ) );
	$cta     = trim( (string) aef_copy( 'home_speakers_cta' ) );
	if ( '' === $cta ) {
		$cta = aef_t( array( 'en' => 'Explore the speakers', 'vi' => 'Khám phá các diễn giả' ) );
	}
	?>
<section class="blk<?php echo esc_attr( aef_home_photo_class( 'home_speakers_bg_id' ) ); ?>">
  <?php aef_home_bg_div( 'home_speakers_bg_id' ); ?>
  <div class="shell">
    <div class="hd rv"><div>
      <?php if ( $eyebrow ) : ?>
      <p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
      <?php endif; ?>
      <?php if ( $title ) : ?>
      <h2><?php echo esc_html( $title ); ?></h2>
      <?php endif; ?>
    </div>
    <?php if ( $lead ) : ?>
    <p class="lead"><?php echo esc_html( $lead ); ?></p>
    <?php endif; ?></div>
    <div class="people">
      <?php
      $spk = new WP_Query( function_exists( 'aef_speaker_public_args' ) ? aef_speaker_public_args( array( 'posts_per_page' => 8 ) ) : array( 'post_type' => 'aef_speaker', 'posts_per_page' => 8, 'orderby' => 'menu_order title' ) );
      $i = 0;
      while ( $spk->have_posts() ) :
		$spk->the_post();
		$i++;
		get_template_part( 'partials/speaker', 'card', array( 'i' => $i ) );
      endwhile;
      wp_reset_postdata();
      ?>
    </div>
    <?php if ( $cta ) : ?>
    <div style="margin-top:30px"><a class="btn btn-b" href="<?php echo esc_url( home_url( '/speakers/' ) ); ?>"><?php echo esc_html( $cta ); ?></a></div>
    <?php endif; ?>
  </div>
</section>
	<?php
}

function aef_home_side_items() {
	$tbc = array( 'en' => 'Venue: to be confirmed.', 'vi' => 'Địa điểm: Đang xác nhận.' );
	return array(
		array(
			'when'  => array( 'en' => '26–29 Oct', 'vi' => '26–29/10' ),
			'title' => array( 'en' => 'Collaboration Roads and GRECO 2026', 'vi' => 'Collaboration Roads và GRECO 2026' ),
			'body'  => array(
				'en' => 'Four streets — Nguyen Hue, Ton Duc Thang, Le Loi and Dong Khoi — with seminars, showcases and the 4th Ho Chi Minh City Green Growth Exhibition.',
				'vi' => 'Bốn trục Nguyễn Huệ, Tôn Đức Thắng, Lê Lợi và Đồng Khởi: hội thảo, trưng bày và Triển lãm tăng trưởng xanh lần thứ 4 (GRECO 2026).',
			),
			'url'   => '/sessions/collaboration-roads/',
		),
		array(
			'when'  => array( 'en' => '26 Oct · 07:30–17:00', 'vi' => '26/10 · 07:30–17:00' ),
			'title' => array( 'en' => 'Twin Transition Conference: Digital and Green', 'vi' => 'Hội nghị Chuyển đổi kép: số và xanh' ),
			'body'  => $tbc,
			'url'   => '/sessions/dual-transition-conference/',
		),
		array(
			'when'  => array( 'en' => '26 Oct · 08:30–11:30', 'vi' => '26/10 · 08:30–11:30' ),
			'title' => array( 'en' => 'Viet Nam–India Future Industries Forum', 'vi' => 'Diễn đàn Công nghiệp Tương lai Việt Nam – Ấn Độ' ),
			'body'  => $tbc,
			'url'   => '/sessions/vietnam-india-future-tech/',
		),
		array(
			'when'  => array( 'en' => '26 Oct · 08:30–17:00', 'vi' => '26/10 · 08:30–17:00' ),
			'title' => array( 'en' => 'Open Innovation Day 2026', 'vi' => 'Open Innovation Day 2026' ),
			'body'  => array(
				'en' => 'Theme: The Next-Generation Industrial City. Thiskyhall, Sala.',
				'vi' => 'Chủ đề: Thành phố Công nghiệp thế hệ mới. Thiskyhall, Sala.',
			),
			'url'   => '/sessions/oid-2026/',
		),
		array(
			'when'  => array( 'en' => '26 Oct · 14:00–16:30', 'vi' => '26/10 · 14:00–16:30' ),
			'title' => array( 'en' => 'CEO 500 — TEA CONNECT', 'vi' => 'CEO 500 — TEA CONNECT' ),
			'body'  => array(
				'en' => 'New perspectives on FDI, technology and global financial flows, at Thiskyhall.',
				'vi' => 'Góc nhìn mới từ bài toán FDI – công nghệ – dòng chảy tài chính toàn cầu, tại Thiskyhall.',
			),
			'url'   => '/sessions/ceo-500-tea-connect/',
		),
		array(
			'when'  => array( 'en' => '29 Oct', 'vi' => '29/10' ),
			'title' => array( 'en' => 'Viet Nam–Israel Innovation Day', 'vi' => 'Việt Nam – Israel Innovation Day' ),
			'body'  => $tbc,
			'url'   => '/sessions/vietnam-israel-innovation-day/',
		),
		array(
			'when'  => array( 'en' => '29 Oct', 'vi' => '29/10' ),
			'title' => array( 'en' => 'Viet Nam–China Investment Promotion Workshop', 'vi' => 'Hội thảo xúc tiến đầu tư Việt Nam – Trung Quốc' ),
			'body'  => $tbc,
			'url'   => '/sessions/vietnam-china-investment/',
		),
		array(
			'when'  => array( 'en' => '29 Oct', 'vi' => '29/10' ),
			'title' => array( 'en' => 'Nordic Investment Promotion Workshop', 'vi' => 'Hội thảo xúc tiến đầu tư Bắc Âu' ),
			'body'  => $tbc,
			'url'   => '/sessions/nordic-investment/',
		),
		array(
			'when'  => array( 'en' => '29 Oct', 'vi' => '29/10' ),
			'title' => array( 'en' => 'Site visits and cultural experience', 'vi' => 'Tham quan thực địa và trải nghiệm văn hóa' ),
			'body'  => $tbc,
			'url'   => '/sessions/field-visits/',
		),
		array(
			'when'  => array( 'en' => '29 Oct · 17:30–22:00', 'vi' => '29/10 · 17:30–22:00' ),
			'title' => array( 'en' => 'C4IR Global Network Annual Gathering', 'vi' => 'Họp mặt thường niên Mạng lưới C4IR toàn cầu' ),
			'body'  => $tbc,
			'url'   => '/sessions/c4ir-network-meeting/',
		),
	);
}

function aef_home_block_side() {
	$title = trim( (string) aef_copy( 'home_side_title' ) );
	$lead  = trim( (string) aef_copy( 'home_side_lead' ) );
	if ( in_array( $title, array( 'A four-day city programme around the main Forum', 'Chuỗi bốn ngày quanh diễn đàn chính' ), true ) ) {
		$title = '';
	}
	if ( ! $title ) {
		$title = aef_t( array( 'en' => 'Collaboration spaces alongside the Forum', 'vi' => 'Không gian hợp tác bên lề Diễn đàn' ) );
	}
	if ( ! $lead ) {
		$lead = aef_t( array(
			'en' => 'Beyond the main programme, the Forum opens Collaboration Roads combining conferences, roundtables, exhibitions, technology showcases, investment matchmaking and cultural exchange. Select an activity for details.',
			'vi' => 'Bên cạnh chương trình chính, Diễn đàn mở ra các không gian hợp tác (Collaboration Roads) kết hợp hội nghị, tọa đàm, triển lãm, trình diễn công nghệ, kết nối đầu tư và giao lưu văn hóa. Chọn một hoạt động để xem chi tiết.',
		) );
	}
	$items = aef_home_side_items();
	?>
<section class="home-side-week<?php echo esc_attr( aef_home_photo_class( 'home_side_bg_id' ) ); ?>">
  <?php aef_home_bg_div( 'home_side_bg_id' ); ?>
  <div class="shell">
    <div class="home-side-head rv">
      <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => '26–29 October 2026', 'vi' => '26–29/10/2026' ) ) ); ?></p>
      <?php if ( $title ) : ?>
      <h2><?php echo esc_html( $title ); ?></h2>
      <?php endif; ?>
      <?php echo aef_paras_html( $lead, 'lead' ); ?>
    </div>
    <div class="home-side-grid">
      <?php foreach ( $items as $item ) : ?>
      <a class="home-side-card rv" href="<?php echo esc_url( home_url( $item['url'] ) ); ?>">
        <small><?php echo esc_html( aef_t( $item['when'] ) ); ?></small>
        <h3><?php echo esc_html( aef_t( $item['title'] ) ); ?></h3>
        <p><?php echo esc_html( aef_t( $item['body'] ) ); ?></p>
      </a>
      <?php endforeach; ?>
    </div>
    <p class="home-side-more"><a class="text-link" href="<?php echo esc_url( home_url( '/programme/?view=side' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'View all side events', 'vi' => 'Xem toàn bộ hoạt động bên lề' ) ) ); ?> →</a></p>
  </div>
</section>
	<?php
}

function aef_home_block_close() {
	$title = trim( (string) aef_copy( 'home_close_title' ) );
	$lead  = trim( (string) aef_copy( 'home_close_lead' ) );
	$cta1  = trim( (string) aef_copy( 'home_close_cta1' ) );
	$cta2  = trim( (string) aef_copy( 'home_close_cta2' ) );
	if ( '' === $title && '' === $lead && '' === $cta1 && '' === $cta2 ) {
		return;
	}
	?>
<section class="home-close on-dark<?php echo esc_attr( aef_home_photo_class( 'home_close_bg_id' ) ); ?>">
  <?php aef_home_bg_div( 'home_close_bg_id' ); ?>
  <div class="shell">
    <?php if ( $title ) : ?>
    <h2><?php echo esc_html( $title ); ?></h2>
    <?php endif; ?>
    <?php echo aef_paras_html( $lead, 'lead' ); ?>
    <?php if ( $cta1 || $cta2 ) : ?>
    <div class="hact">
      <?php if ( $cta1 ) : ?>
      <a class="btn btn-p" href="<?php echo esc_url( home_url( '/programme/' ) ); ?>"><?php echo esc_html( $cta1 ); ?></a>
      <?php endif; ?>
      <?php if ( $cta2 ) : ?>
      <a class="btn btn-g" href="<?php echo esc_url( aef_register_url() ); ?>"><?php echo esc_html( $cta2 ); ?></a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
	<?php
}

function aef_home_block_partners() {
	$flat = array();
	$from_cms = function_exists( 'aef_home_partner_logos' ) ? aef_home_partner_logos() : array();
	foreach ( $from_cms as $it ) {
		if ( ! empty( $it['logo'] ) ) {
			$flat[] = array( $it['name'], $it['logo'] );
		}
	}
	if ( ! $flat && function_exists( 'aef_partner_groups' ) ) {
		foreach ( aef_partner_groups() as $group ) {
			if ( empty( $group['items'] ) ) {
				continue;
			}
			foreach ( $group['items'] as $item ) {
				if ( ! empty( $item[1] ) ) {
					$flat[] = $item;
				}
			}
		}
	}
	if ( ! $flat ) {
		return;
	}
	$loop     = array_merge( $flat, $flat );
	$eyebrow  = trim( (string) aef_copy( 'home_partners_eyebrow' ) );
	$title    = trim( (string) aef_copy( 'home_partners_title' ) );
	$lead     = trim( (string) aef_copy( 'home_partners_lead' ) );
	$cta      = trim( (string) aef_copy( 'home_partners_cta' ) );
	?>
<section class="blk partners-preview<?php echo esc_attr( aef_home_photo_class( 'home_partners_bg_id' ) ); ?>">
  <?php aef_home_bg_div( 'home_partners_bg_id' ); ?>
  <div class="shell">
    <div class="partner-heading rv">
      <div>
        <?php if ( $eyebrow ) : ?>
        <p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
        <?php endif; ?>
        <?php if ( $title ) : ?>
        <h2><?php echo aef_heading_html( $title ); ?></h2>
        <?php endif; ?>
      </div>
      <?php if ( $lead ) : ?>
      <p><?php echo esc_html( $lead ); ?></p>
      <?php endif; ?>
    </div>
  </div>
  <div class="partner-carousel" data-partner-carousel>
    <button type="button" class="partner-nav prev" data-partner-prev aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Previous partners', 'vi' => 'Đối tác trước' ) ) ); ?>">‹</button>
    <div class="partner-viewport">
      <div class="partner-track">
        <?php foreach ( $loop as $item ) : ?>
        <figure class="partner-slide">
          <img src="<?php echo esc_url( $item[1] ); ?>" alt="<?php echo esc_attr( $item[0] ); ?>" loading="lazy" width="220" height="88">
          <figcaption><?php echo esc_html( $item[0] ); ?></figcaption>
        </figure>
        <?php endforeach; ?>
      </div>
    </div>
    <button type="button" class="partner-nav next" data-partner-next aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Next partners', 'vi' => 'Đối tác tiếp' ) ) ); ?>">›</button>
  </div>
  <div class="shell">
    <?php if ( $cta ) : ?>
    <div class="partner-more"><a class="text-link" href="<?php echo esc_url( home_url( '/2026/partners/' ) ); ?>"><?php echo esc_html( $cta ); ?> →</a></div>
    <?php endif; ?>
  </div>
</section>
	<?php
}

function aef_home_block_media() {
	$title   = trim( (string) aef_copy( 'home_media_title' ) );
	$cta     = trim( (string) aef_copy( 'home_media_cta' ) );
	if ( '' === $title ) {
		$title = aef_t( array( 'en' => 'News', 'vi' => 'Tin tức' ) );
	}
	$archive = get_post_type_archive_link( 'aef_story' );
	if ( ! $archive ) {
		$archive = home_url( '/media/' );
	}
	$cards  = function_exists( 'aef_home_news_cards' ) ? aef_home_news_cards() : array();
	$videos = function_exists( 'aef_hef_videos' ) ? array_slice( aef_hef_videos(), 1, 7 ) : array();
	?>
<section class="home-media">
  <div class="shell">
    <div class="hef-news-head rv">
      <h2><a href="<?php echo esc_url( $archive ); ?>"><?php echo esc_html( $title ); ?></a></h2>
    </div>
    <?php if ( $cards ) : ?>
    <div class="hef-news-grid">
      <?php foreach ( $cards as $card ) : ?>
        <?php echo aef_media_card_html( $card ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if ( $videos ) : ?>
    <div class="hef-yt-strip" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Watch', 'vi' => 'Video' ) ) ); ?>">
      <?php foreach ( $videos as $video ) : ?>
        <?php echo aef_video_thumb_html( $video, false ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <p class="hef-news-more">
      <a class="text-link" href="<?php echo esc_url( $archive ); ?>"><?php echo esc_html( $cta ? $cta : aef_t( array( 'en' => 'All news', 'vi' => 'Mọi tin tức' ) ) ); ?> →</a>
      <a class="text-link" href="<?php echo esc_url( aef_lang() === 'vi' ? 'https://hef.gov.vn/vi/' : 'https://hef.gov.vn/' ); ?>" rel="noopener"><?php echo esc_html( aef_t( array( 'en' => 'hef.gov.vn', 'vi' => 'hef.gov.vn' ) ) ); ?> →</a>
    </p>
  </div>
</section>
	<?php
}

function aef_home_block_support() {
	$eyebrow = trim( (string) aef_copy( 'home_support_eyebrow' ) );
	$title   = trim( (string) aef_copy( 'home_support_title' ) );
	$lead    = trim( (string) aef_copy( 'home_support_lead' ) );
	$lanes   = array(
		array(
			'n'    => '01',
			'url'  => '/delegates/how-to-register/',
			'img'  => 'visual/forum-hall.jpg',
			'k'    => array( 'en' => 'Delegates', 'vi' => 'Đại biểu' ),
			'h'    => array( 'en' => 'Attend', 'vi' => 'Tham dự' ),
			'p'    => array( 'en' => 'Invitation, review, visa notes and badge collection.', 'vi' => 'Thư mời, xét duyệt, thị thực và nhận thẻ.' ),
		),
		array(
			'n'    => '02',
			'url'  => '/support/media/',
			'img'  => 'youth.jpg',
			'k'    => array( 'en' => 'Media', 'vi' => 'Báo chí' ),
			'h'    => array( 'en' => 'Cover', 'vi' => 'Tác nghiệp' ),
			'p'    => array( 'en' => 'Accreditation, press centre and interview requests.', 'vi' => 'Đăng ký tác nghiệp, trung tâm báo chí và đề nghị phỏng vấn.' ),
		),
		array(
			'n'    => '03',
			'url'  => '/travel/',
			'img'  => 'travel/city/sala.jpg',
			'k'    => array( 'en' => 'Travel', 'vi' => 'Cẩm nang' ),
			'h'    => array( 'en' => 'Plan the visit', 'vi' => 'Lên đường' ),
			'p'    => array( 'en' => 'Thiskyhall, Sala, airport, stay and the city.', 'vi' => 'Thiskyhall, Sala, sân bay, lưu trú và thành phố.' ),
		),
	);
	?>
<section class="home-support<?php echo esc_attr( aef_home_photo_class( 'home_support_bg_id' ) ); ?>">
  <?php aef_home_bg_div( 'home_support_bg_id' ); ?>
  <div class="shell">
    <div class="home-support-head rv">
      <p class="eyebrow"><?php echo esc_html( $eyebrow ? $eyebrow : aef_t( array( 'en' => 'Support Centre', 'vi' => 'Trung tâm Hỗ trợ' ) ) ); ?></p>
      <?php if ( $title ) : ?>
      <h2><?php echo esc_html( $title ); ?></h2>
      <?php endif; ?>
      <?php if ( $lead ) : ?>
      <p class="lead"><?php echo esc_html( $lead ); ?></p>
      <?php endif; ?>
    </div>
    <div class="support-compact">
      <?php foreach ( $lanes as $lane ) : ?>
      <a class="support-lane rv" href="<?php echo esc_url( home_url( $lane['url'] ) ); ?>">
        <?php if ( ! empty( $lane['img'] ) ) : ?>
        <figure><img src="<?php echo esc_url( aef_img( $lane['img'] ) ); ?>" alt="" width="720" height="405" loading="lazy"></figure>
        <?php endif; ?>
        <small><?php echo esc_html( $lane['n'] . ' · ' . aef_t( $lane['k'] ) ); ?></small>
        <h3><?php echo esc_html( aef_t( $lane['h'] ) ); ?></h3>
        <p><?php echo esc_html( aef_t( $lane['p'] ) ); ?></p>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
	<?php
}
