<?php
$id    = isset( $args['id'] ) ? absint( $args['id'] ) : get_the_ID();
$i     = isset( $args['i'] ) ? intval( $args['i'] ) : 1;
$sess_role = isset( $args['session_role'] ) ? $args['session_role'] : '';
$thumb = function_exists( 'aef_speaker_portrait_url' ) ? aef_speaker_portrait_url( $id, 'medium_large' ) : get_the_post_thumbnail_url( $id, 'medium_large' );
$line  = function_exists( 'aef_speaker_credit' ) ? aef_speaker_credit( $id ) : '';
$mock  = aef_meta( $id, 'is_mockup' );
?>
<a class="person" href="<?php echo esc_url( get_permalink( $id ) ); ?>">
  <div class="portrait hue-<?php echo esc_attr( ( $i % 4 ) + 1 ); ?>">
    <?php if ( $thumb ) : ?>
      <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( aef_bilingual_title( $id ) ); ?>">
    <?php else : ?>
      <span class="portrait-mark">AEF</span>
    <?php endif; ?>
    <?php if ( $sess_role ) : ?>
      <em class="cast-role"><?php echo esc_html( aef_person_role_label( $sess_role ) ); ?></em>
    <?php endif; ?>
  </div>
  <div class="body">
    <h3><?php echo esc_html( aef_bilingual_title( $id ) ); ?></h3>
    <?php if ( $line ) : ?>
    <p><?php echo esc_html( $line ); ?></p>
    <?php endif; ?>
  </div>
</a>
