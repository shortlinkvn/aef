<?php
get_header();
the_post();
$id = get_the_ID();
echo aef_phero(
	array(
		array( 'AEF 2026', home_url( '/' ) ),
		array( aef_t( array( 'en' => 'Programme', 'vi' => 'Chương trình' ) ), home_url( '/2026/programme/' ) ),
		array( aef_bilingual_title( $id ) ),
	),
	aef_bilingual_title( $id ),
	'',
	aef_img( 'visual/forum-hall.jpg' )
);
$status = aef_meta( $id, 'status', 'up' );
$pills = array(
	'up' => aef_t( array( 'en' => 'Upcoming', 'vi' => 'Sắp diễn ra' ) ),
	'live' => aef_t( array( 'en' => 'Live', 'vi' => 'Đang phát' ) ),
	'rep' => aef_t( array( 'en' => 'Replay', 'vi' => 'Xem lại' ) ),
	'arc' => aef_t( array( 'en' => 'Archive', 'vi' => 'Lưu trữ' ) ),
);
?>
<section class="session-meta"><div class="shell session-meta-grid">
  <div><small><?php echo esc_html( aef_t( array( 'en' => 'Date', 'vi' => 'Ngày' ) ) ); ?></small><b><?php echo esc_html( aef_meta( $id, 'date_label', '—' ) ); ?></b></div>
  <div><small><?php echo esc_html( aef_t( array( 'en' => 'Time', 'vi' => 'Thời gian' ) ) ); ?></small><b><?php echo esc_html( aef_meta( $id, 'time' ) ); ?></b></div>
  <div><small><?php echo esc_html( aef_t( array( 'en' => 'Room', 'vi' => 'Không gian' ) ) ); ?></small><b><?php echo esc_html( aef_meta( $id, 'room' ) ); ?></b></div>
  <div><small><?php echo esc_html( aef_t( array( 'en' => 'Language', 'vi' => 'Ngôn ngữ' ) ) ); ?></small><b><?php echo esc_html( aef_session_lang( $id ) ); ?></b></div>
</div></section>
<section class="blk"><div class="shell session-layout">
  <article class="session-main body-copy">
    <div style="margin-bottom:22px"><span class="pill <?php echo esc_attr( $status ); ?>"><?php echo esc_html( isset( $pills[ $status ] ) ? $pills[ $status ] : $status ); ?></span></div>
    <p class="lead"><?php echo esc_html( aef_session_short( $id ) ); ?></p>
    <h2><?php echo esc_html( aef_t( array( 'en' => 'Session context', 'vi' => 'Bối cảnh phiên' ) ) ); ?></h2>
    <p><?php echo esc_html( wp_strip_all_tags( aef_session_long( $id ) ) ); ?></p>
    <?php $qs = aef_session_questions( $id ); if ( $qs ) : ?>
    <h2><?php echo esc_html( aef_t( array( 'en' => 'Guiding questions', 'vi' => 'Câu hỏi dẫn dắt' ) ) ); ?></h2>
    <ol class="question-list">
      <?php foreach ( $qs as $q ) : ?><li><?php echo esc_html( $q ); ?></li><?php endforeach; ?>
    </ol>
    <?php endif; ?>
    <div class="draft-callout">
      <b><?php echo esc_html( aef_t( array( 'en' => 'Still being completed', 'vi' => 'Thông tin đang hoàn thiện' ) ) ); ?></b>
      <p><?php echo esc_html( aef_t( array(
		'en' => 'Speakers, moderators, format and related documents will be updated after the Organising Committee confirms them. Speakers are published only after written confirmation.',
		'vi' => 'Diễn giả, người điều phối, định dạng phiên và tài liệu liên quan sẽ được cập nhật sau khi Ban Tổ chức xác nhận. Tên diễn giả chỉ công bố sau xác nhận bằng văn bản.',
	  ) ) ); ?></p>
    </div>
  </article>
  <aside class="session-side aside">
    <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Topics', 'vi' => 'Chủ đề' ) ) ); ?></p>
    <?php foreach ( aef_session_tags( $id ) as $tag ) : ?><i><?php echo esc_html( $tag ); ?></i><?php endforeach; ?>
    <hr>
    <p class="eyebrow"><?php echo esc_html( aef_t( array( 'en' => 'Session code', 'vi' => 'Mã phiên' ) ) ); ?></p>
    <b><?php echo esc_html( aef_meta( $id, 'session_id', '—' ) ); ?></b>
    <hr>
    <dl>
      <dt><?php echo esc_html( aef_t( array( 'en' => 'Access', 'vi' => 'Quyền tiếp cận' ) ) ); ?></dt>
      <dd><?php echo esc_html( aef_lang() === 'en' ? aef_meta( $id, 'access_en' ) : aef_meta( $id, 'access_vi' ) ); ?></dd>
    </dl>
    <a class="btn btn-b" style="margin-top:24px;width:100%;justify-content:center" href="<?php echo esc_url( home_url( aef_settings()['register_path'] ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Request access', 'vi' => 'Đăng ký tham dự' ) ) ); ?></a>
    <a class="text-link" style="margin-top:18px;display:inline-flex" href="<?php echo esc_url( home_url( '/2026/programme/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Back to programme', 'vi' => 'Trở lại chương trình' ) ) ); ?></a>
  </aside>
</div></section>
<?php get_footer();
