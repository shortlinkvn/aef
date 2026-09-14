<?php
get_header();
$s = aef_settings();
$view = isset( $_GET['view'] ) ? sanitize_key( wp_unslash( $_GET['view'] ) ) : 'all';
$view_map = array(
	'main'     => array( 'thematic', 'high-level' ),
	'thematic' => array( 'thematic' ),
	'arena'    => array( 'thematic' ),
	'side'     => array( 'pre', 'side' ),
);
$days = get_terms( array( 'taxonomy' => 'aef_day', 'hide_empty' => false, 'orderby' => 'term_id' ) );
if ( is_wp_error( $days ) ) {
	$days = array();
}
if ( isset( $view_map[ $view ] ) ) {
	$days = array_values(
		array_filter(
			$days,
			function ( $d ) use ( $view_map, $view ) {
				return in_array( $d->slug, $view_map[ $view ], true );
			}
		)
	);
}
$view_heads = array(
	'all'      => array( 'en' => 'Programme', 'vi' => 'Chương trình' ),
	'main'     => array( 'en' => 'Main Forum 27–28 October', 'vi' => 'Diễn đàn chính 27–28/10' ),
	'thematic' => array( 'en' => 'Thematic sessions', 'vi' => 'Phiên chuyên đề' ),
	'arena'    => array( 'en' => 'Rising Star Arena', 'vi' => 'Rising Star Arena' ),
	'side'     => array( 'en' => 'Side events', 'vi' => 'Hoạt động bên lề' ),
);
$view_leads = array(
	'all'      => array(
		'en' => '26 October: CEO 500, Viet Nam–India technology forum, dual-transition conference and Open Innovation Day. 27 October: opening, 15 parallel thematic sessions and Rising Star Arena. 28 October: high-level plenary, dialogue with the Prime Minister and ministerial dialogue. 26–29 October: Collaboration Roads and GRECO 2026. Some venues are still to be confirmed.',
		'vi' => '26/10: CEO 500, Diễn đàn công nghệ Việt Nam – Ấn Độ, hội nghị chuyển đổi kép và Open Innovation Day. 27/10: khai mạc, 15 phiên chuyên đề song song và khu trình diễn công nghệ. 28/10: phiên toàn thể cấp cao, đối thoại cùng Thủ tướng và đối thoại cấp Bộ. 26–29/10: Collaboration Roads và GRECO 2026. Một số địa điểm đang xác nhận.',
	),
	'main'     => array(
		'en' => '27 October is thematic depth and the Rising Star Arena. 28 October is the high-level plenary, the dialogue with the Prime Minister, and the ministerial dialogue.',
		'vi' => 'Ngày 27/10: chiều sâu chuyên đề và Rising Star Arena. Ngày 28/10: phiên toàn thể cấp cao, đối thoại cùng Thủ tướng và đối thoại cấp Bộ.',
	),
	'thematic' => array(
		'en' => 'Fifteen parallel sessions on 27 October across three rooms, listed by time slot. Each session: one moderator and 3–4 panelists.',
		'vi' => 'Mười lăm phiên thảo luận song song ngày 27/10 tại ba phòng, sắp xếp theo khung giờ. Mỗi phiên: 1 điều phối viên và 3–4 diễn giả tọa đàm.',
	),
	'arena'    => array(
		'en' => 'Technology and innovation showcase on 27 October at Thiskyhall, 45 minutes per slot. Presenting organisations: to be confirmed.',
		'vi' => 'Không gian trình diễn giải pháp công nghệ ngày 27/10 tại Thiskyhall, mỗi lượt 45 phút. Đơn vị trình diễn: Đang xác nhận.',
	),
	'side'     => array(
		'en' => 'Collaboration Roads, bilateral seminars, Open Innovation Day, CEO 500 and the C4IR Network meeting around the main Forum.',
		'vi' => 'Collaboration Roads, hội thảo song phương, Open Innovation Day, CEO 500 và họp mặt Mạng lưới C4IR quanh diễn đàn chính.',
	),
);
echo aef_opener(
	'AEF 2026',
	aef_t( isset( $view_heads[ $view ] ) ? $view_heads[ $view ] : $view_heads['all'] ),
	aef_t( isset( $view_leads[ $view ] ) ? $view_leads[ $view ] : $view_leads['all'] ),
	aef_img( 'visual/forum-hall.jpg' ),
	aef_t( array( 'en' => 'Illustration', 'vi' => 'Minh họa' ) )
);
?>
<?php
$rooms = array();
$tags  = array();
$all_q = new WP_Query( array( 'post_type' => 'aef_session', 'posts_per_page' => 120, 'orderby' => 'meta_value', 'meta_key' => 'time', 'order' => 'ASC' ) );
while ( $all_q->have_posts() ) {
	$all_q->the_post();
	$r = aef_meta( get_the_ID(), 'room' );
	if ( $r ) {
		$rooms[ $r ] = $r;
	}
	foreach ( aef_session_tags( get_the_ID() ) as $tag ) {
		$tags[ $tag ] = $tag;
	}
}
wp_reset_postdata();
ksort( $rooms );
ksort( $tags );
?>
<section class="programme-toolbar" id="search">
  <div class="shell">
    <div class="view-chips">
      <?php
		$views = array(
			'all'      => array( 'en' => 'All', 'vi' => 'Tất cả' ),
			'main'     => array( 'en' => 'Main Forum', 'vi' => 'Diễn đàn chính' ),
			'thematic' => array( 'en' => 'Thematic sessions', 'vi' => 'Phiên chuyên đề' ),
			'arena'    => array( 'en' => 'Rising Star Arena', 'vi' => 'Rising Star Arena' ),
			'side'     => array( 'en' => 'Side events', 'vi' => 'Bên lề' ),
		);
		foreach ( $views as $key => $lab ) :
			$url = $key === 'all' ? home_url( '/programme/' ) : add_query_arg( 'view', $key, home_url( '/programme/' ) );
			?>
      <a class="chip<?php echo $view === $key ? ' is-on' : ''; ?>" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( aef_t( $lab ) ); ?></a>
		<?php endforeach; ?>
    </div>
    <div id="dayfilter" class="day-chips" role="tablist">
      <button type="button" class="chip" data-f="all" aria-pressed="true"><?php echo esc_html( aef_t( array( 'en' => 'All days', 'vi' => 'Tất cả ngày' ) ) ); ?></button>
      <?php foreach ( $days as $day ) : ?>
        <button type="button" class="chip" data-f="<?php echo esc_attr( $day->slug ); ?>" aria-pressed="false"><?php echo esc_html( get_term_meta( $day->term_id, 'when', true ) . ' · ' . ( aef_lang() === 'en' && get_term_meta( $day->term_id, 'name_en', true ) ? get_term_meta( $day->term_id, 'name_en', true ) : $day->name ) ); ?></button>
      <?php endforeach; ?>
    </div>
  <div class="toolbar-grid">
    <input id="programme-query" type="search" placeholder="<?php echo esc_attr( aef_t( array( 'en' => 'Search session title or content…', 'vi' => 'Tìm theo tên phiên, nội dung…' ) ) ); ?>" autocomplete="off">
    <select id="day-filter">
      <option value="all"><?php echo esc_html( aef_t( array( 'en' => 'All days', 'vi' => 'Tất cả các ngày' ) ) ); ?></option>
      <?php foreach ( $days as $day ) : ?>
        <option value="<?php echo esc_attr( $day->slug ); ?>"><?php echo esc_html( get_term_meta( $day->term_id, 'when', true ) . ' · ' . ( aef_lang() === 'en' && get_term_meta( $day->term_id, 'name_en', true ) ? get_term_meta( $day->term_id, 'name_en', true ) : $day->name ) ); ?></option>
      <?php endforeach; ?>
    </select>
    <select id="room-filter">
      <option value="all"><?php echo esc_html( aef_t( array( 'en' => 'All rooms', 'vi' => 'Tất cả không gian' ) ) ); ?></option>
      <?php foreach ( $rooms as $room ) : ?>
        <option value="<?php echo esc_attr( $room ); ?>"><?php echo esc_html( function_exists( 'aef_place_label' ) ? aef_place_label( $room ) : $room ); ?></option>
      <?php endforeach; ?>
    </select>
    <select id="topic-filter">
      <option value="all"><?php echo esc_html( aef_t( array( 'en' => 'All topics', 'vi' => 'Tất cả chủ đề' ) ) ); ?></option>
      <?php foreach ( $tags as $tag ) : ?>
        <option value="<?php echo esc_attr( $tag ); ?>"><?php echo esc_html( aef_tag_label( $tag ) ); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  </div>
</section>
<section class="blk programme-agenda"><div class="shell">
  <p class="theme-inline"><?php echo esc_html( aef_t( array( 'en' => 'Theme', 'vi' => 'Chủ đề' ) ) ); ?> · <em><?php echo esc_html( aef_t( array( 'vi' => $s['theme_vi'], 'en' => $s['theme_en'] ) ) ); ?></em></p>
  <p class="programme-count" id="agenda-count"></p>
  <div id="prog">
    <?php foreach ( $days as $day ) :
		$q = new WP_Query( array(
			'post_type' => 'aef_session',
			'posts_per_page' => 80,
			'tax_query' => array( array( 'taxonomy' => 'aef_day', 'field' => 'term_id', 'terms' => $day->term_id ) ),
			'orderby' => 'meta_value',
			'meta_key' => 'time',
			'order' => 'ASC',
		) );
		?>
      <div class="rail rv" id="day-<?php echo esc_attr( $day->slug ); ?>" data-day="<?php echo esc_attr( $day->slug ); ?>">
        <?php
		$when = get_term_meta( $day->term_id, 'when', true );
		$dlab = array(
			'pre'        => array( 'en' => 'Monday · Pre-Forum', 'vi' => 'Thứ Hai · Tiền diễn đàn' ),
			'thematic'   => array( 'en' => 'Tuesday · Main Forum — Day 1', 'vi' => 'Thứ Ba · Diễn đàn chính — Ngày 1' ),
			'high-level' => array( 'en' => 'Wednesday · Main Forum — Day 2', 'vi' => 'Thứ Tư · Diễn đàn chính — Ngày 2' ),
			'side'       => array( 'en' => 'Thursday · Post-Forum', 'vi' => 'Thứ Năm · Hậu diễn đàn' ),
		);
		$dtag = array(
			'thematic'   => array( 'en' => 'Thematic & networking', 'vi' => 'Chuyên đề & kết nối' ),
			'high-level' => array( 'en' => 'High-level dialogue', 'vi' => 'Đối thoại cấp cao' ),
		);
		?>
        <div class="pg-dayhead">
          <b><?php echo esc_html( $when ); ?>/10</b>
          <small><?php echo esc_html( isset( $dlab[ $day->slug ] ) ? aef_t( $dlab[ $day->slug ] ) : $day->name ); ?></small>
          <?php if ( isset( $dtag[ $day->slug ] ) ) : ?>
          <span class="tag"><?php echo esc_html( aef_t( $dtag[ $day->slug ] ) ); ?></span>
          <?php endif; ?>
        </div>
        <?php
		$buckets = array( 'full' => array(), '1' => array(), '2' => array(), '3' => array(), 'arena' => array() );
		while ( $q->have_posts() ) {
			$q->the_post();
			$sid  = get_the_ID();
			$buck = function_exists( 'aef_prog_room_bucket' ) ? aef_prog_room_bucket( $sid ) : 'full';
			if ( ! isset( $buckets[ $buck ] ) ) {
				$buck = 'full';
			}
			$buckets[ $buck ][] = $sid;
		}
		wp_reset_postdata();
		$is_main = in_array( $day->slug, array( 'thematic', 'high-level' ), true );
		if ( $is_main ) {
			echo '<div class="pg-mainpanel"><span class="pg-mainlabel">' . esc_html( aef_t( array( 'en' => 'Main Forum', 'vi' => 'Diễn đàn chính' ) ) ) . '</span>';
		}
		if ( $buckets['full'] && 'arena' !== $view && 'thematic' !== $day->slug ) {
			echo '<div class="pg-list">';
			foreach ( $buckets['full'] as $sid ) {
				aef_prog_srow( $sid, $day->slug );
			}
			echo '</div>';
		}
		if ( 'thematic' === $day->slug && 'arena' !== $view ) {
			$pre = array();
			$post = array();
			foreach ( $buckets['full'] as $sid ) {
				$t0 = (string) aef_meta( $sid, 'time' );
				if ( preg_match( '/^0[0-7]:|^08:00/', $t0 ) ) {
					$pre[] = $sid;
				} else {
					$post[] = $sid;
				}
			}
			if ( $pre ) {
				echo '<div class="pg-list">';
				foreach ( $pre as $sid ) {
					aef_prog_srow( $sid, $day->slug );
				}
				echo '</div>';
			}
			echo '<div class="pg-dayhead" style="font-size:19px"><b>08:30–18:00</b><small>' . esc_html( aef_t( array( 'en' => '3 rooms in parallel', 'vi' => '3 phòng song song' ) ) ) . '</small></div>';
			aef_prog_pgrid( $buckets, $day->slug );
			if ( $post ) {
				echo '<div class="pg-list" style="margin-top:14px">';
				foreach ( $post as $sid ) {
					aef_prog_srow( $sid, $day->slug );
				}
				echo '</div>';
			}
		} elseif ( $buckets['full'] && 'arena' !== $view && 'thematic' === $day->slug ) {
			echo '<div class="pg-list">';
			foreach ( $buckets['full'] as $sid ) {
				aef_prog_srow( $sid, $day->slug );
			}
			echo '</div>';
		}
		if ( $buckets['arena'] ) {
			echo '<div class="arena-band">';
			foreach ( $buckets['arena'] as $sid ) {
				aef_prog_srow( $sid, $day->slug );
			}
			echo '</div>';
		}
		if ( $is_main ) {
			echo '</div>';
		}
		?>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="empty-state" id="agenda-empty" hidden>
    <h2><?php echo esc_html( aef_t( array( 'en' => 'No matching sessions', 'vi' => 'Không tìm thấy nội dung phù hợp' ) ) ); ?></h2>
    <p><?php echo esc_html( aef_t( array( 'en' => 'Clear a filter or try another keyword.', 'vi' => 'Hãy thử bỏ bớt bộ lọc hoặc dùng từ khóa khác.' ) ) ); ?></p>
  </div>
</div></section>
<?php get_footer();
