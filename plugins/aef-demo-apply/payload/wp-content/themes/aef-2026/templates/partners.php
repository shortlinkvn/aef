<?php echo apply_filters( 'the_content', aef_bilingual_content( get_the_ID() ) ); ?>
<div class="partners-page">
<?php foreach ( aef_partner_groups() as $group ) : ?>
  <section class="role-section">
    <div class="shell">
      <div class="role-head">
        <span><?php echo esc_html( aef_t( $group['role'] ) ); ?></span>
        <h2><?php echo esc_html( aef_t( $group['title'] ) ); ?></h2>
      </div>
      <div class="partner-grid">
        <?php foreach ( $group['items'] as $item ) : ?>
          <div class="partner-card">
            <img src="<?php echo esc_url( $item[1] ); ?>" alt="<?php echo esc_attr( $item[0] ); ?>" loading="lazy">
            <small><?php echo esc_html( $item[0] ); ?></small>
          </div>
        <?php endforeach; ?>
      </div>
      <?php if ( ! empty( $group['note'] ) ) : ?>
        <p class="role-note"><?php echo esc_html( aef_t( $group['note'] ) ); ?></p>
      <?php endif; ?>
    </div>
  </section>
<?php endforeach; ?>
</div>
