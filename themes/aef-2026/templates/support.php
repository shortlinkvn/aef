<?php echo apply_filters( 'the_content', aef_bilingual_content( get_the_ID() ) ); ?>
<section class="blk" style="padding-top:0">
  <div class="shell support-compact">
    <a class="support-lane rv" href="<?php echo esc_url( home_url( '/2026/delegates/' ) ); ?>">
      <figure><img src="<?php echo esc_url( aef_img( 'visual/forum-hall.jpg' ) ); ?>" alt="" width="720" height="405" loading="lazy"></figure>
      <small>01 · <?php echo esc_html( aef_t( array( 'en' => 'Delegates', 'vi' => 'Đại biểu' ) ) ); ?></small>
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Attend', 'vi' => 'Tham dự' ) ) ); ?></h2>
      <p><?php echo esc_html( aef_t( array( 'en' => 'Eligibility, registration, visa and badge.', 'vi' => 'Điều kiện, đăng ký, thị thực và nhận thẻ.' ) ) ); ?></p>
    </a>
    <a class="support-lane rv" href="<?php echo esc_url( home_url( '/2026/support/media/' ) ); ?>">
      <figure><img src="<?php echo esc_url( aef_img( 'youth.jpg' ) ); ?>" alt="" width="720" height="405" loading="lazy"></figure>
      <small>02 · <?php echo esc_html( aef_t( array( 'en' => 'Media', 'vi' => 'Báo chí' ) ) ); ?></small>
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Cover', 'vi' => 'Tác nghiệp' ) ) ); ?></h2>
      <p><?php echo esc_html( aef_t( array( 'en' => 'Accreditation and on-site press facilities.', 'vi' => 'Đăng ký tác nghiệp và trung tâm báo chí.' ) ) ); ?></p>
    </a>
    <a class="support-lane rv" href="<?php echo esc_url( home_url( '/travel/' ) ); ?>">
      <figure><img src="<?php echo esc_url( aef_img( 'travel/city/sala.jpg' ) ); ?>" alt="" width="720" height="405" loading="lazy"></figure>
      <small>03 · <?php echo esc_html( aef_t( array( 'en' => 'Travel', 'vi' => 'Cẩm nang' ) ) ); ?></small>
      <h2><?php echo esc_html( aef_t( array( 'en' => 'Plan the visit', 'vi' => 'Lên đường' ) ) ); ?></h2>
      <p><?php echo esc_html( aef_t( array( 'en' => 'Venue, stay, airport and the city.', 'vi' => 'Địa điểm, lưu trú, sân bay và thành phố.' ) ) ); ?></p>
    </a>
  </div>
</section>
<section class="blk mist" style="padding-top:48px">
  <div class="shell">
    <div class="faq">
      <?php foreach ( aef_support_faq() as $faq ) : ?>
        <details>
          <summary><?php echo esc_html( aef_t( $faq[0] ) ); ?></summary>
          <p><?php echo esc_html( aef_t( $faq[1] ) ); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
