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
<section class="blk" style="padding-top:0">
  <div class="shell">
    <div class="quick-grid">
      <a class="quick-tile" href="<?php echo esc_url( home_url( '/travel/#venue' ) ); ?>">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-5.2 7-11a7 7 0 0 0-14 0c0 5.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg></span>
        <b><?php echo esc_html( aef_t( array( 'en' => 'Venue', 'vi' => 'Địa điểm' ) ) ); ?></b>
        <span><?php echo esc_html( aef_t( array( 'en' => 'Venue details and map', 'vi' => 'Thông tin venue và bản đồ' ) ) ); ?></span>
      </a>
      <a class="quick-tile" href="<?php echo esc_url( home_url( '/travel/#stay' ) ); ?>">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21V8l6-4 6 4v13"/><path d="M9 21v-6h4v6"/><path d="M13 12h7v9"/></svg></span>
        <b><?php echo esc_html( aef_t( array( 'en' => 'Stay', 'vi' => 'Lưu trú' ) ) ); ?></b>
        <span><?php echo esc_html( aef_t( array( 'en' => 'Reference hotel list', 'vi' => 'Danh sách khách sạn tham khảo' ) ) ); ?></span>
      </a>
      <a class="quick-tile" href="<?php echo esc_url( home_url( '/travel/#move' ) ); ?>">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 17h14M6 17v3M18 17v3M5 17l1.5-6h11L19 17"/><circle cx="8" cy="20" r="1"/><circle cx="16" cy="20" r="1"/></svg></span>
        <b><?php echo esc_html( aef_t( array( 'en' => 'Transport', 'vi' => 'Di chuyển' ) ) ); ?></b>
        <span><?php echo esc_html( aef_t( array( 'en' => 'Airport to city guide', 'vi' => 'Hướng dẫn từ sân bay' ) ) ); ?></span>
      </a>
      <a class="quick-tile" href="#faq">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 1 1 3.5 2.3c-.9.4-1.5 1-1.5 2.2"/><circle cx="12" cy="17" r=".5" fill="currentColor"/></svg></span>
        <b>FAQ</b>
        <span><?php echo esc_html( aef_t( array( 'en' => 'Frequently asked questions', 'vi' => 'Câu hỏi thường gặp' ) ) ); ?></span>
      </a>
      <a class="quick-tile" href="mailto:contact@aef.vn">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="m4 6 8 6 8-6"/></svg></span>
        <b><?php echo esc_html( aef_t( array( 'en' => 'Contact', 'vi' => 'Liên hệ BTC' ) ) ); ?></b>
        <span><?php echo esc_html( aef_t( array( 'en' => 'contact@aef.vn', 'vi' => 'contact@aef.vn' ) ) ); ?></span>
      </a>
      <a class="quick-tile" href="<?php echo esc_url( home_url( '/2026/support/media/' ) ); ?>">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2h9l5 5v15H6z"/><path d="M15 2v5h5"/><path d="M9 13h6M9 17h6"/></svg></span>
        <b><?php echo esc_html( aef_t( array( 'en' => 'Press resources', 'vi' => 'Tài nguyên báo chí' ) ) ); ?></b>
        <span><?php echo esc_html( aef_t( array( 'en' => 'Docs, images, logos', 'vi' => 'Tài liệu, hình ảnh, logo' ) ) ); ?></span>
      </a>
    </div>
  </div>
</section>
<section class="blk mist" id="faq" style="padding-top:0">
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
