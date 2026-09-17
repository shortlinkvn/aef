<?php
get_header();
the_post();
$id      = get_the_ID();
$line    = function_exists( 'aef_speaker_credit' ) ? aef_speaker_credit( $id ) : '';
$bio     = aef_lang() === 'en' ? aef_meta( $id, 'content_en', aef_meta( $id, 'content_vi' ) ) : aef_meta( $id, 'content_vi', aef_meta( $id, 'content_en' ) );
$thumb   = function_exists( 'aef_speaker_portrait_url' ) ? aef_speaker_portrait_url( $id, 'large' ) : get_the_post_thumbnail_url( $id, 'large' );
$sess    = function_exists( 'aef_speaker_sessions' ) ? aef_speaker_sessions( $id ) : array();
$country = function_exists( 'aef_speaker_country' ) ? aef_speaker_country( $id ) : aef_meta( $id, 'country' );
$is_mock = '1' === (string) aef_meta( $id, 'is_mockup' );
$topics  = function_exists( 'aef_speaker_topics' ) ? aef_speaker_topics( $id ) : array();
$peers   = function_exists( 'aef_speaker_peers' ) ? aef_speaker_peers( $id ) : array();
$roles   = array();
foreach ( $sess as $row ) {
	$lbl = aef_person_role_label( $row['role'] );
	if ( ! in_array( $lbl, $roles, true ) ) {
		$roles[] = $lbl;
	}
}
?>
<header class="speaker-hero">
  <div class="shell speaker-hero-grid">
    <div class="portrait">
      <?php if ( $thumb ) : ?>
        <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( aef_bilingual_title( $id ) ); ?>">
      <?php else : ?>
        <span class="portrait-mark">AEF</span>
      <?php endif; ?>
    </div>
    <div class="speaker-who">
      <p class="eyebrow"><a href="<?php echo esc_url( home_url( '/speakers/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'Speakers', 'vi' => 'Diễn giả' ) ) ); ?></a></p>
      <?php if ( $is_mock ) : ?>
      <span class="spk-status"><?php echo esc_html( aef_t( array( 'en' => 'To be confirmed', 'vi' => 'Đang xác nhận' ) ) ); ?></span>
      <?php endif; ?>
      <h1><?php echo esc_html( aef_bilingual_title( $id ) ); ?></h1>
      <?php if ( $line ) : ?>
      <p class="speaker-credit"><?php echo esc_html( $line ); ?></p>
      <?php endif; ?>
      <?php if ( $country ) : ?>
      <p class="speaker-country"><?php echo esc_html( $country ); ?></p>
      <?php endif; ?>
      <?php if ( $bio || $sess || $peers ) : ?>
      <nav class="spk-subnav">
        <?php if ( $bio ) : ?><a href="#overview"><?php echo esc_html( aef_t( array( 'en' => 'Overview', 'vi' => 'Tổng quan' ) ) ); ?></a><?php endif; ?>
        <?php if ( $sess ) : ?><a href="#sessions"><?php echo esc_html( aef_t( array( 'en' => 'Sessions', 'vi' => 'Phiên tham gia' ) ) ); ?></a><?php endif; ?>
        <?php if ( $peers ) : ?><a href="#peers"><?php echo esc_html( aef_t( array( 'en' => 'Same group', 'vi' => 'Cùng nhóm' ) ) ); ?></a><?php endif; ?>
      </nav>
      <?php endif; ?>
      <?php if ( $bio ) : ?>
      <div id="overview" class="speaker-bio-inline body-copy">
        <h2><?php echo esc_html( aef_t( array( 'en' => 'Profile summary', 'vi' => 'Tóm tắt hồ sơ' ) ) ); ?></h2>
        <?php echo aef_paras_html( $bio ); ?>
      </div>
      <?php endif; ?>
      <?php if ( $roles ) : ?>
      <div class="spk-badges">
        <small><?php echo esc_html( aef_t( array( 'en' => 'Role at the Forum', 'vi' => 'Hình thức tham gia' ) ) ); ?></small>
        <div>
          <?php foreach ( $roles as $r ) : ?><span class="spk-tag"><?php echo esc_html( $r ); ?></span><?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
      <?php if ( $topics ) : ?>
      <div class="spk-badges">
        <small><?php echo esc_html( aef_t( array( 'en' => 'Related topics', 'vi' => 'Chủ đề liên quan' ) ) ); ?></small>
        <div>
          <?php foreach ( $topics as $t ) : ?><span class="spk-tag soft"><?php echo esc_html( $t ); ?></span><?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</header>
<?php if ( $sess ) : ?>
<section id="sessions" class="speaker-appearances"><div class="shell">
  <h2><?php echo esc_html( aef_t( array( 'en' => 'Sessions', 'vi' => 'Các phiên tham gia' ) ) ); ?></h2>
  <ul class="speaker-sessions">
    <?php foreach ( $sess as $row ) :
		$sid = $row['id'];
		?>
      <li>
        <a href="<?php echo esc_url( get_permalink( $sid ) ); ?>">
          <span class="sess-role"><?php echo esc_html( aef_person_role_label( $row['role'] ) ); ?></span>
          <strong><?php echo esc_html( aef_bilingual_title( $sid ) ); ?></strong>
          <small><?php echo esc_html( trim( aef_meta( $sid, 'date_label' ) . ' · ' . aef_meta( $sid, 'time' ) . ( aef_meta( $sid, 'room' ) ? ' · ' . aef_meta( $sid, 'room' ) : '' ), ' ·' ) ); ?></small>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div></section>
<?php endif; ?>
<?php if ( $peers ) : ?>
<section id="peers" class="speaker-appearances mist"><div class="shell">
  <h2><?php echo esc_html( aef_t( array( 'en' => 'Speakers in the same group', 'vi' => 'Diễn giả cùng nhóm' ) ) ); ?></h2>
  <div class="people">
    <?php
	$i = 0;
	foreach ( $peers as $pid ) :
		$i++;
		get_template_part( 'partials/speaker', 'card', array( 'id' => $pid, 'i' => $i ) );
	endforeach;
	?>
  </div>
</div></section>
<?php endif; ?>
<?php get_footer();
