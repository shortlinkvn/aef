<?php
get_header();
the_post();
$id   = get_the_ID();
$slug = get_post_field( 'post_name', $id );
$title = aef_bilingual_title( $id );
$live  = in_array( $slug, array( 'high-level-plenary', 'pm-dialogue' ), true );
$wef   = in_array( $slug, array( 'pm-dialogue', 'repositioning-vietnam-asean', 'ai-workforce-readiness' ), true );
$fmt   = aef_lang() === 'en' ? aef_meta( $id, 'format_en' ) : aef_meta( $id, 'format_vi' );
$lead  = aef_lang() === 'en' ? aef_meta( $id, 'lead_en' ) : aef_meta( $id, 'lead_vi' );
$aud   = aef_lang() === 'en' ? aef_meta( $id, 'audience_en' ) : aef_meta( $id, 'audience_vi' );
$long  = wp_strip_all_tags( aef_session_long( $id ) );
$short = aef_session_short( $id );
$room  = function_exists( 'aef_place_label' ) ? aef_place_label( aef_meta( $id, 'room' ) ) : aef_meta( $id, 'room' );
$s     = aef_settings();
$place = aef_t( array( 'vi' => $s['venue_vi'], 'en' => $s['venue_en'] ) );
$cast  = function_exists( 'aef_session_people_grouped' ) ? aef_session_people_grouped( $id ) : array();
$ini   = static function ( $name ) {
	$n = preg_replace( '/[^\p{L}\s]/u', '', (string) $name );
	$p = preg_split( '/\s+/u', trim( $n ) );
	if ( ! $p ) {
		return '?';
	}
	$a = mb_substr( $p[0], 0, 1 );
	$b = count( $p ) > 1 ? mb_substr( $p[ count( $p ) - 1 ], 0, 1 ) : '';
	return mb_strtoupper( $a . $b );
};
$parent = array( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ), home_url( '/programme/' ) );
$bucket = function_exists( 'aef_prog_room_bucket' ) ? aef_prog_room_bucket( $id ) : '';
if ( in_array( $bucket, array( '1', '2', '3' ), true ) ) {
	$parent = array( aef_t( array( 'en' => 'Thematic sessions', 'vi' => 'Phiên chuyên đề' ) ), home_url( '/programme/?view=thematic' ) );
} elseif ( 'arena' === $bucket ) {
	$parent = array( 'Rising Star Arena', home_url( '/programme/?view=arena' ) );
}
?>
<section class="pg-page">
  <div class="shell">
    <div class="pg-crumb">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Overview', 'vi' => 'Tổng quan' ) ) ); ?></a>
      <span><a href="<?php echo esc_url( $parent[1] ); ?>"><?php echo esc_html( $parent[0] ); ?></a></span>
      <span><?php echo esc_html( $title ); ?></span>
    </div>
    <div class="pg-detail">
      <div>
        <div class="pg-chips">
          <span class="pg-chip"><?php echo esc_html( aef_session_kind_chip( $id ) ); ?></span>
          <?php if ( $room ) : ?><span class="pg-chip"><?php echo esc_html( $room ); ?></span><?php endif; ?>
          <?php if ( $wef ) : ?><span class="pg-chip"><?php echo esc_html( aef_t( array( 'en' => 'WEF joins this session', 'vi' => 'WEF tham gia phiên này' ) ) ); ?></span><?php endif; ?>
          <?php if ( $live ) : ?><span class="live"><?php echo esc_html( aef_t( array( 'en' => 'Live broadcast', 'vi' => 'Truyền hình trực tiếp' ) ) ); ?></span><?php endif; ?>
        </div>
        <h1 class="pg-h1"><?php echo esc_html( $title ); ?></h1>
        <?php if ( $short ) : ?><p class="pg-sum"><?php echo esc_html( $short ); ?></p><?php endif; ?>
        <?php if ( $long && $long !== $short ) : ?>
        <div class="pg-sec">
          <h3><?php echo esc_html( aef_t( array( 'en' => 'Content', 'vi' => 'Nội dung' ) ) ); ?></h3>
          <p><?php echo esc_html( $long ); ?></p>
        </div>
        <?php endif; ?>
        <?php if ( $aud ) : ?>
        <div class="pg-sec">
          <h3><?php echo esc_html( aef_t( array( 'en' => 'Participants', 'vi' => 'Thành phần tham dự' ) ) ); ?></h3>
          <p><?php echo esc_html( $aud ); ?></p>
        </div>
        <?php endif; ?>
        <?php
		$has = false;
		foreach ( $cast as $rows ) {
			if ( $rows ) {
				$has = true;
				break;
			}
		}
		?>
        <?php foreach ( $cast as $role => $rows ) : if ( empty( $rows ) ) { continue; } ?>
        <div class="pg-sec">
          <h3><?php echo esc_html( aef_person_role_label( $role ) ); ?></h3>
          <div class="pg-speak">
            <?php foreach ( $rows as $row ) : ?>
            <a class="pg-sp" href="<?php echo esc_url( get_permalink( $row['id'] ) ); ?>">
              <div class="pg-av"><?php echo esc_html( $ini( aef_bilingual_title( $row['id'] ) ) ); ?></div>
              <div>
                <b><?php echo esc_html( aef_bilingual_title( $row['id'] ) ); ?></b>
                <span><?php echo esc_html( aef_speaker_credit( $row['id'] ) ); ?></span>
                <div class="role"><?php echo esc_html( aef_person_role_label( $row['role'] ) ); ?></div>
              </div>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>
        <?php if ( ! $has ) : ?>
        <div class="pg-sec">
          <h3><?php echo esc_html( aef_t( array( 'en' => 'Speakers', 'vi' => 'Diễn giả' ) ) ); ?></h3>
          <div class="pg-speak">
            <?php
			$plan = function_exists( 'aef_session_role_plan' ) ? aef_session_role_plan( $id ) : array( 'speaker' );
			foreach ( $plan as $role ) :
				?>
            <div class="pg-sp ph">
              <div class="pg-av">?</div>
              <div>
                <b><?php echo esc_html( aef_person_role_label( $role ) ); ?></b>
                <span><?php echo esc_html( aef_t( array( 'en' => 'To be confirmed', 'vi' => 'Đang xác nhận' ) ) ); ?></span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <aside class="pg-facts">
        <div class="f"><small><?php echo esc_html( aef_t( array( 'en' => 'Duration', 'vi' => 'Thời lượng' ) ) ); ?></small><div class="dur"><?php echo esc_html( aef_session_duration_label( $id ) ); ?></div></div>
        <div class="f"><small><?php echo esc_html( aef_t( array( 'en' => 'Time', 'vi' => 'Thời gian' ) ) ); ?></small><b><?php echo esc_html( trim( aef_meta( $id, 'date_label' ) . ( aef_meta( $id, 'time' ) ? ' · ' . aef_meta( $id, 'time' ) : '' ) ) ); ?></b></div>
        <?php if ( $room ) : ?><div class="f"><small><?php echo esc_html( aef_t( array( 'en' => 'Room', 'vi' => 'Phòng' ) ) ); ?></small><b><?php echo esc_html( $room ); ?></b></div><?php endif; ?>
        <?php if ( $place ) : ?><div class="f"><small><?php echo esc_html( aef_t( array( 'en' => 'Venue', 'vi' => 'Địa điểm' ) ) ); ?></small><b><?php echo esc_html( $place ); ?></b></div><?php endif; ?>
        <?php if ( $fmt ) : ?><div class="f"><small><?php echo esc_html( aef_t( array( 'en' => 'Format', 'vi' => 'Hình thức' ) ) ); ?></small><b><?php echo esc_html( $fmt ); ?></b></div><?php endif; ?>
        <?php if ( $lead ) : ?><div class="f"><small><?php echo esc_html( in_array( $bucket, array( '1', '2', '3' ), true ) ? aef_t( array( 'en' => 'Coordinating ministry', 'vi' => 'Bộ, ngành phối hợp' ) ) : aef_t( array( 'en' => 'Chaired / coordinated by', 'vi' => 'Chủ trì / phối hợp' ) ) ); ?></small><b><?php echo esc_html( $lead ); ?></b></div><?php endif; ?>
        <?php
			$sponsor_name = trim( (string) aef_meta( $id, 'sponsor_name' ) );
			$sponsor_url  = trim( (string) aef_meta( $id, 'sponsor_url' ) );
		?>
        <div class="f">
          <small><?php echo esc_html( aef_t( array( 'en' => 'Brought to you by', 'vi' => 'Đồng hành cùng phiên' ) ) ); ?></small>
          <?php if ( $sponsor_name && $sponsor_url ) : ?>
          <b><a href="<?php echo esc_url( $sponsor_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $sponsor_name ); ?></a></b>
          <?php elseif ( $sponsor_name ) : ?>
          <b><?php echo esc_html( $sponsor_name ); ?></b>
          <?php else : ?>
          <b><?php echo esc_html( aef_t( array( 'en' => 'Session sponsor — to be announced', 'vi' => 'Nhà tài trợ phiên — đang cập nhật' ) ) ); ?></b>
          <?php endif; ?>
        </div>
        <a class="btn btn-b" style="margin-top:8px;width:100%;justify-content:center" href="<?php echo esc_url( home_url( '/delegates/how-to-register/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'How to attend', 'vi' => 'Cách tham dự' ) ) ); ?></a>
        <a class="text-link" style="margin-top:12px;display:inline-flex;color:#97DAFF" href="<?php echo esc_url( $parent[1] ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Back to programme', 'vi' => 'Trở lại chương trình' ) ) ); ?></a>
      </aside>
    </div>
  </div>
</section>
<?php get_footer();
