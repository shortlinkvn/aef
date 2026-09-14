<?php
get_header();
the_post();
$id    = get_the_ID();
$line  = function_exists( 'aef_speaker_credit' ) ? aef_speaker_credit( $id ) : '';
$bio   = aef_lang() === 'en' ? aef_meta( $id, 'content_en', aef_meta( $id, 'content_vi' ) ) : aef_meta( $id, 'content_vi', aef_meta( $id, 'content_en' ) );
$thumb = function_exists( 'aef_speaker_portrait_url' ) ? aef_speaker_portrait_url( $id, 'large' ) : get_the_post_thumbnail_url( $id, 'large' );
$sess  = function_exists( 'aef_speaker_sessions' ) ? aef_speaker_sessions( $id ) : array();
$country = function_exists( 'aef_speaker_country' ) ? aef_speaker_country( $id ) : aef_meta( $id, 'country' );
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
      <h1><?php echo esc_html( aef_bilingual_title( $id ) ); ?></h1>
      <?php if ( $line ) : ?>
      <p class="speaker-credit"><?php echo esc_html( $line ); ?></p>
      <?php endif; ?>
      <?php if ( $country ) : ?>
      <p class="speaker-country"><?php echo esc_html( $country ); ?></p>
      <?php endif; ?>
      <?php if ( $bio ) : ?>
      <div class="speaker-bio-inline body-copy">
        <h2><?php echo esc_html( aef_t( array( 'en' => 'Profile summary', 'vi' => 'Tóm tắt hồ sơ' ) ) ); ?></h2>
        <?php echo aef_paras_html( $bio ); ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</header>
<?php if ( $sess ) : ?>
<section class="speaker-appearances"><div class="shell">
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
<?php get_footer();
