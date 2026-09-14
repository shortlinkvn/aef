<?php
$pillars = aef_pillars();
$i = 0;
foreach ( $pillars as $p ) :
	$i++;
	?>
<section class="topic-chapter<?php echo $i % 2 ? '' : ' tint'; ?>" id="pillar-<?php echo esc_attr( $p['slug'] ); ?>">
  <div class="shell topic-chapter-inner">
    <div class="topic-index"><?php echo esc_html( $p['n'] ); ?></div>
    <div>
      <p class="eyebrow"><?php echo esc_html( aef_t( $p['title'] ) ); ?></p>
      <h2><?php echo esc_html( aef_t( $p['kicker'] ) ); ?></h2>
      <?php if ( ! empty( $p['image'] ) ) : ?>
        <figure class="topic-still">
          <img src="<?php echo esc_url( aef_img( $p['image'] ) ); ?>" alt="">
          <figcaption><?php echo esc_html( aef_t( array( 'en' => 'Illustration', 'vi' => 'Minh họa' ) ) ); ?></figcaption>
        </figure>
      <?php endif; ?>
    </div>
    <div class="copy">
      <p class="lead"><?php echo esc_html( aef_t( isset( $p['card'] ) ? $p['card'] : $p['title'] ) ); ?></p>
      <p><?php echo esc_html( aef_t( $p['body'] ) ); ?></p>
      <h3><?php echo esc_html( aef_t( array( 'en' => 'Guiding questions', 'vi' => 'Câu hỏi định hướng' ) ) ); ?></h3>
      <ul class="question-list">
        <?php foreach ( $p['qs'] as $q ) : ?>
          <li><?php echo esc_html( aef_t( $q ) ); ?></li>
        <?php endforeach; ?>
      </ul>
      <a class="text-link" href="<?php echo esc_url( home_url( '/2026/programme/' ) ); ?>"><?php echo esc_html( aef_t( array( 'en' => 'See related sessions', 'vi' => 'Xem các phiên liên quan' ) ) ); ?> →</a>
    </div>
  </div>
</section>
<?php endforeach; ?>
<p class="shell role-note" style="margin:40px auto 80px"><?php echo esc_html( aef_t( array(
	'en' => 'These four pillars frame the Forum. They are not four separate sessions. Draft of 13 August 2026.',
	'vi' => 'Bốn trụ cột là khung tư duy của Diễn đàn, không phải bốn phiên riêng. Dự thảo 13/8/2026.',
) ) ); ?></p>
