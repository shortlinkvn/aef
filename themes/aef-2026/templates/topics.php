<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$pillars = aef_pillars();
$qs_h    = function_exists( 'aef_topics' ) ? trim( (string) aef_topics( 'topics_qs_h' ) ) : '';
$cta     = function_exists( 'aef_topics' ) ? trim( (string) aef_topics( 'topics_sessions_cta' ) ) : '';
$cta_url = function_exists( 'aef_topics' ) ? trim( (string) aef_topics( 'topics_sessions_url' ) ) : '/programme/';
$note    = function_exists( 'aef_topics' ) ? trim( (string) aef_topics( 'topics_note' ) ) : '';
if ( '' === $cta_url ) {
	$cta_url = '/programme/';
}
$i = 0;
echo '<div class="page-topics">';
foreach ( $pillars as $p ) :
	$i++;
	$title  = trim( (string) aef_t( $p['title'] ) );
	$kicker = trim( (string) aef_t( $p['kicker'] ) );
	$lead   = trim( (string) aef_t( isset( $p['card'] ) ? $p['card'] : array() ) );
	$body   = trim( (string) aef_t( $p['body'] ) );
	$cap    = trim( (string) aef_t( isset( $p['cap'] ) ? $p['cap'] : array() ) );
	$img    = '';
	if ( ! empty( $p['still_on'] ) ) {
		if ( ! empty( $p['image_url'] ) ) {
			$img = $p['image_url'];
		} elseif ( ! empty( $p['image'] ) ) {
			$img = aef_img( $p['image'] );
		}
	}
	$qs = array();
	if ( ! empty( $p['qs'] ) && is_array( $p['qs'] ) ) {
		foreach ( $p['qs'] as $q ) {
			$line = trim( (string) aef_t( $q ) );
			if ( '' !== $line ) {
				$qs[] = $line;
			}
		}
	}
	$bg  = ! empty( $p['bg'] ) ? $p['bg'] : '';
	$cls = 'topic-chapter' . ( $i % 2 ? '' : ' tint' ) . ( $bg ? ' has-photo' : '' );
	?>
<section class="<?php echo esc_attr( $cls ); ?>" id="pillar-<?php echo esc_attr( $p['slug'] ); ?>">
  <?php if ( $bg ) : ?>
    <div class="blk-photo" style="background-image:url('<?php echo esc_url( $bg ); ?>')"></div>
  <?php endif; ?>
  <div class="shell topic-chapter-inner">
    <?php if ( ! empty( $p['n'] ) ) : ?>
    <div class="topic-index"><?php echo esc_html( $p['n'] ); ?></div>
    <?php endif; ?>
    <div>
      <?php if ( $title ) : ?>
      <p class="eyebrow"><?php echo esc_html( $title ); ?></p>
      <?php endif; ?>
      <?php if ( $kicker ) : ?>
      <h2><?php echo esc_html( $kicker ); ?></h2>
      <?php endif; ?>
      <?php if ( $img ) : ?>
        <figure class="topic-still">
          <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ? $title : $kicker ); ?>" loading="lazy">
          <?php if ( $cap ) : ?>
          <figcaption><?php echo esc_html( $cap ); ?></figcaption>
          <?php endif; ?>
        </figure>
      <?php endif; ?>
    </div>
    <div class="copy">
      <?php if ( $lead ) : ?>
      <p class="lead"><?php echo esc_html( $lead ); ?></p>
      <?php endif; ?>
      <?php if ( $body ) : ?>
      <p><?php echo esc_html( $body ); ?></p>
      <?php endif; ?>
      <?php if ( $qs ) : ?>
        <?php if ( $qs_h ) : ?>
        <h3><?php echo esc_html( $qs_h ); ?></h3>
        <?php endif; ?>
        <ul class="question-list">
          <?php foreach ( $qs as $line ) : ?>
            <li><?php echo esc_html( $line ); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <?php if ( $cta ) : ?>
      <a class="text-link" href="<?php echo esc_url( home_url( $cta_url ) ); ?>"><?php echo esc_html( $cta ); ?> →</a>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php
endforeach;
if ( $note ) {
	echo '<p class="shell role-note" style="margin:40px auto 80px">' . esc_html( $note ) . '</p>';
}
echo '</div>';

