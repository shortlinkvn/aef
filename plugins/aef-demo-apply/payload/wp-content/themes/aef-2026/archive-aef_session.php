<?php
get_header();
$s = aef_settings();
$days = get_terms( array( 'taxonomy' => 'aef_day', 'hide_empty' => false, 'orderby' => 'term_id' ) );
if ( is_wp_error( $days ) ) {
	$days = array();
}
echo aef_phero(
	array( array( 'AEF 2026', home_url( '/' ) ), array( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ) ) ),
	aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ),
	aef_t( array(
		'en' => 'Times, rooms, language and access for each session. The timetable is still a draft.',
		'vi' => 'Giờ, phòng, ngôn ngữ và quyền tiếp cận của từng phiên. Lịch vẫn là dự thảo.',
	) ),
	aef_img( 'visual/forum-hall.jpg' )
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
  <div class="shell toolbar-grid">
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
        <option value="<?php echo esc_attr( $room ); ?>"><?php echo esc_html( $room ); ?></option>
      <?php endforeach; ?>
    </select>
    <select id="topic-filter">
      <option value="all"><?php echo esc_html( aef_t( array( 'en' => 'All topics', 'vi' => 'Tất cả chủ đề' ) ) ); ?></option>
      <?php foreach ( $tags as $tag ) : ?>
        <option value="<?php echo esc_attr( $tag ); ?>"><?php echo esc_html( $tag ); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</section>
<section class="blk mist"><div class="shell">
  <p class="draft-note prog-disclaimer"><b><?php echo esc_html( aef_t( array( 'en' => 'Draft · ' . $s['programme_updated'], 'vi' => 'Dự thảo · ' . $s['programme_updated'] ) ) ); ?></b>
    <span><?php echo esc_html( aef_t( array(
		'en' => 'The AEF 2026 programme is still being completed and may change. Please check the update time on each session before attending. Content follows the 13 August draft plan and overall framework.',
		'vi' => 'Chương trình AEF 2026 đang tiếp tục được hoàn thiện và có thể được điều chỉnh. Vui lòng kiểm tra thời gian cập nhật trên từng phiên trước khi tham dự. Nội dung theo dự thảo Kế hoạch và Khung chương trình tổng thể ngày 13/8.',
	) ) ); ?></span></p>
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
        <div class="agenda-day-head">
          <span><?php echo esc_html( get_term_meta( $day->term_id, 'when', true ) ); ?>.2026</span>
          <b><?php echo esc_html( aef_lang() === 'en' && get_term_meta( $day->term_id, 'name_en', true ) ? get_term_meta( $day->term_id, 'name_en', true ) : $day->name ); ?></b>
          <p><?php echo esc_html( aef_lang() === 'en' && get_term_meta( $day->term_id, 'note_en', true ) ? get_term_meta( $day->term_id, 'note_en', true ) : $day->description ); ?></p>
        </div>
        <div class="agenda-list">
          <?php while ( $q->have_posts() ) : $q->the_post();
			$sid = get_the_ID();
			$hay = strtolower( aef_bilingual_title( $sid ) . ' ' . aef_session_short( $sid ) . ' ' . implode( ' ', aef_session_tags( $sid ) ) );
			?>
            <a class="agenda-card" href="<?php the_permalink(); ?>" data-day="<?php echo esc_attr( $day->slug ); ?>" data-room="<?php echo esc_attr( aef_meta( $sid, 'room' ) ); ?>" data-tags="<?php echo esc_attr( implode( '|', aef_session_tags( $sid ) ) ); ?>" data-q="<?php echo esc_attr( $hay ); ?>">
              <time><?php echo esc_html( aef_meta( $sid, 'time' ) ); ?></time>
              <span class="room"><?php echo esc_html( aef_meta( $sid, 'room' ) ); ?></span>
              <div>
                <small><?php echo esc_html( aef_session_kind( $sid ) ); ?></small>
                <h3><?php echo esc_html( aef_bilingual_title( $sid ) ); ?></h3>
                <p><?php echo esc_html( wp_trim_words( aef_session_short( $sid ), 22 ) ); ?></p>
                <div class="tags"><?php foreach ( aef_session_tags( $sid ) as $tag ) : ?><span><?php echo esc_html( $tag ); ?></span><?php endforeach; ?></div>
              </div>
              <b>↗</b>
            </a>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="empty-state" id="agenda-empty" hidden>
    <h2><?php echo esc_html( aef_t( array( 'en' => 'No matching sessions', 'vi' => 'Không tìm thấy nội dung phù hợp' ) ) ); ?></h2>
    <p><?php echo esc_html( aef_t( array( 'en' => 'Clear a filter or try another keyword.', 'vi' => 'Hãy thử bỏ bớt bộ lọc hoặc dùng từ khóa khác.' ) ) ); ?></p>
  </div>
</div></section>
<section class="blk" id="axes"><div class="shell">
  <div class="hd rv"><div>
    <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'How to read the week', 'vi' => 'Cách đọc chương trình' ) ) ); ?></p>
    <h2><?php echo aef_lang() === 'vi' ? 'Bốn trụ cột<br>nội dung' : 'Four content<br>pillars'; ?></h2>
  </div>
  <p class="lead"><?php echo esc_html( aef_t( array(
	'en' => 'These four pillars frame the Forum. They are not four separate sessions — they run through the thematic programme. Draft of 13 August 2026.',
	'vi' => 'Bốn trụ cột là khung tư duy của Diễn đàn, không phải bốn phiên riêng. Chúng được lồng vào các phiên chuyên đề. Dự thảo 13/8/2026.',
) ) ); ?></p></div>
  <div class="qs">
    <?php
    $axes = array(
		array( '01', $s['axis_1_en'], $s['axis_1_vi'] ),
		array( '02', $s['axis_2_en'], $s['axis_2_vi'] ),
		array( '03', $s['axis_3_en'], $s['axis_3_vi'] ),
		array( '04', $s['axis_4_en'], $s['axis_4_vi'] ),
    );
    foreach ( $axes as $a ) :
		?>
      <div class="q rv"><span class="n"><?php echo esc_html( $a[0] ); ?></span><div><h3><?php echo esc_html( aef_lang() === 'vi' ? $a[2] : $a[1] ); ?></h3></div></div>
    <?php endforeach; ?>
  </div>
</div></section>
<?php get_footer();
