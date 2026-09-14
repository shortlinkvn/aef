<?php
get_header();
$s = aef_settings();
$theme = aef_t( array( 'vi' => $s['theme_vi'], 'en' => $s['theme_en'] ) );
$lead  = aef_t( array( 'vi' => $s['theme_lead_vi'], 'en' => $s['theme_lead_en'] ) );
$days = get_terms( array( 'taxonomy' => 'aef_day', 'hide_empty' => false, 'orderby' => 'term_id' ) );
if ( is_wp_error( $days ) ) {
	$days = array();
}
?>
<?php if ( aef_block_on( 'hero' ) ) : ?>
<section class="hero on-dark">
  <div class="hero-photo" style="background-image:url('<?php echo esc_url( aef_img( 'visual/hcmc-dusk.jpg' ) ); ?>')"></div>
  <div class="shell">
    <p class="hosts"><?php echo esc_html( aef_t( array(
		'en' => 'AUTUMN ECONOMIC FORUM 2026 · HO CHI MINH CITY',
		'vi' => 'AUTUMN ECONOMIC FORUM 2026 · HO CHI MINH CITY',
	) ) ); ?></p>
    <h1 class="hero-headline"><?php echo esc_html( aef_t( array(
		'en' => 'The Convergence of Global Growth Poles',
		'vi' => 'Sự hội tụ của các cực tăng trưởng toàn cầu',
	) ) ); ?></h1>
    <p class="theme"><em><?php echo esc_html( $theme ); ?></em></p>
    <p class="theme-position"><?php echo esc_html( aef_t( array(
		'en' => 'As the growth map is being redrawn by technology, the green transition and new economic links, AEF 2026 opens a space for governments, cities, firms, investors and specialists to build trust, connect resources and shape new development engines.',
		'vi' => 'Khi bản đồ tăng trưởng đang được định hình lại bởi công nghệ, chuyển đổi xanh và những liên kết kinh tế mới, AEF 2026 mở ra một không gian đối thoại để các chính phủ, đô thị, doanh nghiệp, nhà đầu tư và giới chuyên gia cùng xây dựng lòng tin, kết nối nguồn lực và kiến tạo những động lực phát triển mới.',
	) ) ); ?></p>
    <div class="hmeta">
      <div><small><?php echo esc_html( aef_copy( 'home_meta_week' ) ); ?></small><b><?php echo esc_html( $s['week_dates'] ); ?></b></div>
      <div><small><?php echo esc_html( aef_copy( 'home_meta_main' ) ); ?></small><b><?php echo esc_html( $s['main_dates'] ); ?></b></div>
      <div><small><?php echo esc_html( aef_copy( 'home_meta_city' ) ); ?></small><b><?php echo esc_html( aef_t( array( 'vi' => $s['city_vi'], 'en' => $s['city_en'] ) ) ); ?></b></div>
    </div>
    <div class="hact">
      <a class="btn btn-p" href="<?php echo esc_url( home_url( '/2026/programme/' ) ); ?>"><?php echo esc_html( aef_copy( 'home_hero_cta1' ) ); ?></a>
      <a class="btn btn-g" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php echo esc_html( aef_copy( 'home_hero_cta2' ) ); ?></a>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ( aef_block_on( 'theme' ) ) : ?>
<section class="blk intro-strip">
  <div class="shell intro-layout rv">
    <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'A forum oriented toward action', 'vi' => 'Một diễn đàn hướng tới hành động' ) ) ); ?></p>
    <p class="lead"><?php echo esc_html( aef_t( array(
		'en' => 'The Autumn Economic Forum 2026 aims to connect countries, localities, cities, firms and international organisations in a multi-layer space for dialogue and cooperation. Positioned as “The Convergence of Global Growth Poles”, AEF 2026 focuses on the engines shaping the future: the role of megacities, frontier technology, new cooperation models and the leading force of the private sector.',
		'vi' => 'Diễn đàn Kinh tế Mùa thu 2026 hướng tới kết nối các quốc gia, địa phương, đô thị, doanh nghiệp và tổ chức quốc tế trong một không gian đối thoại và hợp tác đa chiều. Với định vị “Sự hội tụ của các cực tăng trưởng toàn cầu”, AEF 2026 tập trung vào những động lực đang định hình tương lai: vai trò của các siêu đô thị, công nghệ đột phá, các mô hình hợp tác mới và sức dẫn dắt của khu vực tư nhân.',
	) ) ); ?></p>
  </div>
</section>
<section class="topics-preview">
  <div class="shell">
    <div class="hd rv"><div>
      <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'A thinking frame, not four sessions', 'vi' => 'Khung tư duy, không phải bốn phiên' ) ) ); ?></p>
      <h2><?php echo aef_lang() === 'vi' ? 'Bốn trụ cột<br>xuyên suốt' : 'Four pillars<br>through the week'; ?></h2>
    </div>
    <p class="lead"><?php echo esc_html( $lead ); ?></p></div>
    <?php foreach ( aef_pillars() as $p ) : ?>
      <a class="topic-row rv" href="<?php echo esc_url( home_url( '/topics/#pillar-' . $p['slug'] ) ); ?>">
        <span><?php echo esc_html( $p['n'] ); ?></span>
        <?php if ( ! empty( $p['image'] ) ) : ?>
          <img class="topic-thumb" src="<?php echo esc_url( aef_img( $p['image'] ) ); ?>" alt="" width="112" height="84">
        <?php endif; ?>
        <h3><?php echo esc_html( aef_t( $p['kicker'] ) ); ?></h3>
        <p><?php echo esc_html( aef_t( isset( $p['card'] ) ? $p['card'] : $p['title'] ) ); ?></p>
        <b>↗</b>
      </a>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if ( aef_block_on( 'hosts' ) ) : ?>
<section class="inst-strip">
  <div class="shell inst-grid">
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
      <small><?php echo esc_html( aef_t( array( 'en' => 'Implementing centre', 'vi' => 'Đơn vị thực hiện' ) ) ); ?></small>
      <img src="<?php echo esc_url( aef_logo( 'c4ir.png' ) ); ?>" alt="HCMC C4IR">
      <b>HCMC C4IR</b>
    </div>
    <div class="inst rv">
      <small><?php echo esc_html( aef_t( array( 'en' => 'Cooperating partner', 'vi' => 'Đối tác phối hợp' ) ) ); ?></small>
      <div class="inst-mark inst-mark-text">WEF</div>
      <b>World Economic Forum</b>
    </div>
  </div>
  <p class="inst-note"><?php echo esc_html( aef_t( array(
	'en' => 'Logos are temporary working files pending official artwork. Roles follow the 13 August draft plan.',
	'vi' => 'Logo đang dùng bản tạm, chờ tệp gốc. Vai trò theo dự thảo Kế hoạch 13/8.',
  ) ) ); ?></p>
</section>
<?php endif; ?>

<?php if ( aef_block_on( 'week' ) ) : ?>
<section class="blk">
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
      <a class="day-card rv" href="<?php echo esc_url( home_url( '/2026/programme/#day-' . $day->slug ) ); ?>">
        <small><?php echo esc_html( aef_t( array( 'en' => 'Layer 0' . $i, 'vi' => 'Lớp 0' . $i ) ) ); ?></small>
        <time><?php echo esc_html( $when ); ?></time>
        <h3><?php echo esc_html( $name ); ?></h3>
        <p><?php echo esc_html( $note ); ?></p>
        <span><?php echo esc_html( aef_t( array( 'en' => 'Open this day', 'vi' => 'Xem ngày này' ) ) ); ?> →</span>
      </a>
    <?php endforeach; ?>
    </div>
    <div style="margin-top:34px"><a class="btn btn-b" href="<?php echo esc_url( home_url( '/2026/programme/' ) ); ?>"><?php echo esc_html( aef_copy( 'home_week_cta' ) ); ?></a></div>
  </div>
</section>
<?php endif; ?>
<?php if ( aef_block_on( 'journey' ) || aef_block_on( 'featured' ) ) :
	$agenda = aef_home_agenda();
	?>
<section class="home-programme" id="home-programme">
  <div class="shell">
    <div class="home-programme-head rv">
      <div>
        <p class="overline"><?php echo esc_html( aef_t( array( 'en' => 'Three focus days', 'vi' => 'Ba ngày trọng tâm' ) ) ); ?></p>
        <h2><?php echo aef_lang() === 'vi' ? 'Từ kết nối lãnh đạo<br>đến <em>hành động chung.</em>' : 'From leadership connection<br>to <em>shared action.</em>'; ?></h2>
      </div>
      <p class="status-note"><i></i> <?php echo esc_html( aef_t( array(
		'en' => 'Draft of 13.08.2026. The three days sit inside Forum week 25–30 October. Times on 28 October may still change.',
		'vi' => 'Dự thảo 13.08.2026. Ba ngày này nằm trong tuần Diễn đàn 25–30/10. Giờ ngày 28/10 có thể còn điều chỉnh.',
	  ) ) ); ?></p>
    </div>
    <div class="day-tabs" role="tablist" aria-label="<?php echo esc_attr( aef_t( array( 'en' => 'Programme day', 'vi' => 'Chọn ngày chương trình' ) ) ); ?>">
      <?php foreach ( $agenda as $i => $tab ) : ?>
        <button type="button" role="tab" id="home-tab-<?php echo esc_attr( $tab['key'] ); ?>" aria-controls="home-panel-<?php echo esc_attr( $tab['key'] ); ?>" aria-selected="<?php echo 1 === $i ? 'true' : 'false'; ?>" data-day="<?php echo esc_attr( $tab['key'] ); ?>">
          <span><?php echo esc_html( aef_t( $tab['weekday'] ) ); ?></span>
          <b><?php echo esc_html( $tab['when'] ); ?></b>
          <small><?php echo esc_html( aef_t( $tab['month'] ) ); ?></small>
        </button>
      <?php endforeach; ?>
    </div>
    <?php foreach ( $agenda as $i => $tab ) : ?>
      <div class="home-agenda" id="home-panel-<?php echo esc_attr( $tab['key'] ); ?>" role="tabpanel" aria-labelledby="home-tab-<?php echo esc_attr( $tab['key'] ); ?>" <?php echo 1 === $i ? '' : 'hidden'; ?>>
        <?php if ( empty( $tab['items'] ) ) : ?>
          <p class="home-agenda-empty"><?php echo esc_html( aef_t( array( 'en' => 'Sessions for this day are still being completed.', 'vi' => 'Các phiên ngày này đang được hoàn thiện.' ) ) ); ?></p>
        <?php else : ?>
          <?php foreach ( $tab['items'] as $item ) : ?>
            <a class="agenda-item" href="<?php echo esc_url( $item['url'] ); ?>">
              <time><?php echo esc_html( $item['time'] ); ?></time>
              <div>
                <h3><?php echo esc_html( $item['title'] ); ?></h3>
                <p><?php echo esc_html( $item['room'] ); ?></p>
              </div>
              <span><?php echo esc_html( $item['tag'] ); ?></span>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
    <a class="btn btn-g home-programme-cta" href="<?php echo esc_url( home_url( '/2026/programme/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Full programme', 'vi' => 'Xem chương trình tổng thể' ) ) ); ?> →</a>
  </div>
</section>
<?php endif; ?>
<section class="city-band why-city">
  <div class="city-band-photo" style="background-image:url('<?php echo esc_url( aef_img( 'visual/hcmc-dusk.jpg' ) ); ?>')"></div>
  <div class="shell city-band-copy">
    <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Host city', 'vi' => 'Thành phố chủ nhà' ) ) ); ?></p>
    <h2><?php echo aef_lang() === 'vi' ? 'Một không gian phát triển mới,<br>một điểm kết nối mới' : 'A new development space,<br>a new connection point'; ?></h2>
    <p class="lead"><?php echo esc_html( aef_t( array(
		'en' => 'As Viet Nam’s economic lead and a centre of finance, trade, science, technology and innovation, Ho Chi Minh City can connect capital, technology, knowledge and international business networks. The main forum days are at Thiskyhall, Sala.',
		'vi' => 'Với vai trò đầu tàu kinh tế, trung tâm tài chính, thương mại, khoa học – công nghệ và đổi mới sáng tạo của Việt Nam, Thành phố Hồ Chí Minh có điều kiện để kết nối các dòng vốn, công nghệ, tri thức và mạng lưới doanh nghiệp quốc tế. Hai ngày diễn đàn chính tại Thiskyhall, Sala.',
	) ) ); ?></p>
    <small class="illu-credit"><?php echo esc_html( aef_t( array( 'en' => 'Illustration — not an official venue photograph', 'vi' => 'Minh họa — không phải ảnh địa điểm chính thức' ) ) ); ?></small>
  </div>
</section>
<?php if ( aef_block_on( 'outcomes' ) ) : ?>
<section class="blk">
  <div class="shell">
    <div class="hd rv"><div>
      <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'From dialogue to action', 'vi' => 'Từ đối thoại đến hành động' ) ) ); ?></p>
      <h2><?php echo aef_lang() === 'vi' ? 'Những kết nối tiếp tục<br>sau Diễn đàn' : 'Connections that continue<br>after the Forum'; ?></h2>
    </div>
    <p class="lead"><?php echo esc_html( aef_t( array(
		'en' => 'AEF 2026 is not aimed only at exchanges across the two main days. Activities are designed to help form policy recommendations, connect investment, technology and finance, widen partnerships and create the conditions for initiatives that can continue after the event — when they meet the required conditions.',
		'vi' => 'AEF 2026 không chỉ hướng tới những cuộc trao đổi trong hai ngày diễn đàn chính. Các hoạt động được định hướng để góp phần hình thành khuyến nghị chính sách, kết nối đầu tư – công nghệ – tài chính, mở rộng quan hệ hợp tác và tạo nền tảng cho những sáng kiến có thể tiếp tục sau sự kiện — khi đủ điều kiện.',
	) ) ); ?></p></div>
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
<?php endif; ?>
<?php if ( aef_block_on( 'audience' ) ) : ?>
<section class="blk mist">
  <div class="shell">
    <div class="hd rv"><div>
      <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Who takes part', 'vi' => 'Người tham dự' ) ) ); ?></p>
      <h2><?php echo aef_lang() === 'vi' ? 'Một hệ sinh thái<br>đối thoại đa chiều' : 'A multi-layer<br>dialogue ecosystem'; ?></h2>
    </div>
    <p class="lead"><?php echo esc_html( aef_t( array(
		'en' => 'These are expected audience groups, not a list of confirmed guests. No name, country, organisation or firm should be read as having confirmed attendance.',
		'vi' => 'Đây là mô tả nhóm đối tượng dự kiến, không phải danh sách khách đã xác nhận. Không suy diễn rằng một cá nhân, quốc gia, tổ chức hoặc doanh nghiệp cụ thể đã xác nhận tham dự.',
	) ) ); ?></p></div>
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
<?php endif; ?>

<?php if ( aef_block_on( 'edition' ) ) : ?>
<section class="blk deep on-dark" style="padding:72px 0 0">
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
    <div style="margin-top:30px"><a class="btn btn-b" href="<?php echo esc_url( home_url( '/editions/2025/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'The 2025 edition in full', 'vi' => 'Toàn cảnh kỳ 2025' ) ) ); ?></a></div>
  </div>
</section>
<?php endif; ?>

<?php if ( aef_block_on( 'speakers' ) ) : ?>
<section class="blk">
  <div class="shell">
    <div class="hd rv"><div>
      <p class="eyebrow"><?php echo esc_html( aef_copy( 'home_speakers_eyebrow' ) ); ?></p>
      <h2><?php echo esc_html( aef_copy( 'home_speakers_title' ) ); ?></h2>
    </div>
    <p class="lead"><?php echo esc_html( aef_copy( 'home_speakers_lead' ) ); ?></p></div>
    <div class="people">
      <?php
      $spk = new WP_Query( array( 'post_type' => 'aef_speaker', 'posts_per_page' => 8, 'orderby' => 'menu_order title' ) );
      $i = 0;
      while ( $spk->have_posts() ) :
		$spk->the_post();
		$i++;
		get_template_part( 'partials/speaker', 'card', array( 'i' => $i ) );
      endwhile;
      wp_reset_postdata();
      ?>
    </div>
    <div style="margin-top:30px"><a class="btn btn-b" href="<?php echo esc_url( home_url( '/2026/speakers/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'All speakers', 'vi' => 'Toàn bộ diễn giả' ) ) ); ?></a></div>
  </div>
</section>
<?php endif; ?>

<?php if ( aef_block_on( 'partners' ) ) : ?>
<section class="blk partners-preview">
  <div class="shell">
    <div class="partner-heading rv">
      <div>
        <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'The accompanying ecosystem', 'vi' => 'Hệ sinh thái đồng hành' ) ) ); ?></p>
        <h2><?php echo aef_lang() === 'vi' ? 'Kết nối nguồn lực<br>cho AEF 2026' : 'Connecting resources<br>for AEF 2026'; ?></h2>
      </div>
      <p><?php echo esc_html( aef_t( array(
		'en' => 'Names and tiers are pending Organising Committee confirmation. Logos are working files.',
		'vi' => 'Danh sách và phân hạng đang chờ Ban Tổ chức xác nhận. Logo là tệp làm việc.',
	  ) ) ); ?></p>
    </div>
    <div class="logo-rail">
      <?php
		$rail = aef_partner_groups();
		$items = isset( $rail[1]['items'] ) ? array_slice( $rail[1]['items'], 0, 8 ) : array();
		foreach ( $items as $item ) :
			?>
        <div><img src="<?php echo esc_url( $item[1] ); ?>" alt="<?php echo esc_attr( $item[0] ); ?>" loading="lazy"></div>
      <?php endforeach; ?>
    </div>
    <div style="margin-top:28px"><a class="text-link" href="<?php echo esc_url( home_url( '/2026/partners/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Organisations & partners', 'vi' => 'Đơn vị & đối tác' ) ) ); ?> →</a></div>
  </div>
</section>
<?php endif; ?>

<?php if ( aef_block_on( 'support' ) ) : ?>
<section class="blk mist">
  <div class="shell">
    <div class="hd rv"><div>
      <p class="eyebrow"><?php echo esc_html( aef_copy( 'home_support_eyebrow' ) ); ?></p>
      <h2><?php echo esc_html( aef_copy( 'home_support_title' ) ); ?></h2>
    </div>
    <p class="lead"><?php echo esc_html( aef_copy( 'home_support_lead' ) ); ?></p></div>
    <div class="support-gates home-gates">
      <article class="support-gate delegate rv">
        <small>01 · <?php echo esc_html( aef_t( array( 'en' => 'Delegates', 'vi' => 'Đại biểu' ) ) ); ?></small>
        <h2><?php echo esc_html( aef_t( array( 'en' => 'Attend', 'vi' => 'Tham dự' ) ) ); ?></h2>
        <p><?php echo esc_html( aef_t( array( 'en' => 'Eligibility, registration, visa, venue, accommodation and badge collection.', 'vi' => 'Điều kiện, đăng ký, thị thực, địa điểm, lưu trú và nhận thẻ.' ) ) ); ?></p>
        <a class="btn btn-p" href="<?php echo esc_url( home_url( '/2026/delegates/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Delegate route', 'vi' => 'Lộ trình đại biểu' ) ) ); ?></a>
      </article>
      <article class="support-gate press rv">
        <small>02 · <?php echo esc_html( aef_t( array( 'en' => 'Media', 'vi' => 'Báo chí' ) ) ); ?></small>
        <h2><?php echo esc_html( aef_t( array( 'en' => 'Cover', 'vi' => 'Tác nghiệp' ) ) ); ?></h2>
        <p><?php echo esc_html( aef_t( array( 'en' => 'Accreditation, press conferences, interview requests and on-site access.', 'vi' => 'Đăng ký tác nghiệp, họp báo, đề nghị phỏng vấn và lối vào tại chỗ.' ) ) ); ?></p>
        <a class="btn btn-p" href="<?php echo esc_url( home_url( '/2026/support/media/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Media route', 'vi' => 'Lộ trình báo chí' ) ) ); ?></a>
      </article>
    </div>
  </div>
</section>
<?php endif; ?>
<?php get_footer();